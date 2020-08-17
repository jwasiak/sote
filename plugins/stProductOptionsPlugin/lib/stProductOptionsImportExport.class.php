<?php
/**
 * SOTESHOP/stProductOptionsPlugin
 * Ten plik należy do aplikacji stProductOptionsPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 *
 * @package     stProductOptionsPlugin
 * @subpackage  libs
 */
class stProductOptionsImportExport 
{    
    public static $useLogger = true;

    protected static $filterPool = array();

    protected static $productOptionsColorPool = array();

    protected static $valid = true;

    protected static $jsonUnicode = false;

    protected static $duplicates = array();

    protected static $paramTranslation = array(
        'filter' => 'filtr',
        'default' => 'domyslna',
        'price' => 'cena',
        'old_price' => 'stara_cena',
        'stock' => 'magazyn',
        'weight' => 'waga',
        'code' => 'kod',
        'pum' => 'ijm',
        'image' => 'zdjecie',
        'option_color' => 'kolor_opcji',   
        'price_type' => 'typ_ceny', 
        'man_code' => 'kod_producenta',  
    );

    protected static $paramsTranslation = null;

    public static function getParamTranslation($name, $culture)
    {

        if ($culture == 'pl_PL' && isset(self::$paramTranslation[$name]))
        {
            return self::$paramTranslation[$name];
        }

        return $name;
    }

    public static function translateParams($params)
    {
        if (null === self::$paramsTranslation)
        {
            $from = array();
            foreach (array_values(self::$paramTranslation) as $value)
            {
                $from[] = '"'.$value.'"';
            }

            $to = array();
            foreach (array_keys(self::$paramTranslation) as $value)
            {
                $to[] = '"'.$value.'"';
            }            

            self::$paramsTranslation = array(
                'from' => $from,
                'to' => $to,
            );
        }

        return str_replace(self::$paramsTranslation['from'], self::$paramsTranslation['to'], $params);
    }

    /**
     * Pobiera drzewo opcji dla produktu
     * @param $product_id - id produktu
     * @return object
     */
    public static function getRootForProduct($product_id) 
    {
        $c = new Criteria();
        $c->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, null, Criteria::ISNULL);
        $c->add(ProductOptionsValuePeer::PRODUCT_ID,$product_id);
        $root = ProductOptionsValuePeer::doSelectOne($c);

        if (!$root) 
        {
            $root = new ProductOptionsValue();
            $root->setProductId($product_id);
            $root->makeRoot();
            $root->_duplicated = true;
            $root->save();

        }
        return $root;
    }


    /**
     * Pobiera opcje danego produktu
     * @param $object - obiekt produktu
     * @return string
     */
    public static function getProductOptions(Product $product) 
    {
        /* PHP 5.3.x compatibility fix */
        self::$jsonUnicode = defined('JSON_UNESCAPED_UNICODE');

        $sf_context = sfContext::getInstance();

        $culture = $sf_context->getUser()->getCulture();
        
        $c = new Criteria();

        $c->addSelectColumn(ProductOptionsValuePeer::ID);
        $c->addSelectColumn(ProductOptionsFieldPeer::OPT_NAME);
        $c->addSelectColumn(ProductOptionsFieldPeer::PRODUCT_OPTIONS_FILTER_ID);
        $c->addSelectColumn(ProductOptionsFieldPeer::OPT_DEFAULT_VALUE);
        $c->addSelectColumn(ProductOptionsValuePeer::SF_ASSET_ID);
        $c->addSelectColumn(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID);
        $c->addSelectColumn(ProductOptionsValuePeer::PRICE);
        $c->addSelectColumn(ProductOptionsValuePeer::WEIGHT);
        $c->addSelectColumn(ProductOptionsValuePeer::STOCK);
        $c->addSelectColumn(ProductOptionsValuePeer::OPT_VALUE);
        $c->addSelectColumn(ProductOptionsValuePeer::PRICE_TYPE);
        $c->addSelectColumn(ProductOptionsValuePeer::COLOR);
        $c->addSelectColumn(ProductOptionsValuePeer::USE_IMAGE_AS_COLOR);
        $c->addSelectColumn(ProductOptionsValuePeer::USE_PRODUCT);
        $c->addSelectColumn(ProductOptionsValuePeer::OLD_PRICE);
        $c->addSelectColumn(ProductOptionsValuePeer::PUM);
        $c->addSelectColumn(ProductOptionsValuePeer::DEPTH);
        $c->addSelectColumn(ProductOptionsValuePeer::LFT);
        $c->addSelectColumn(ProductOptionsValuePeer::RGT);
        $c->addSelectColumn(ProductOptionsValuePeer::MAN_CODE);


        $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product->getId());
        $c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);
        $c->addAscendingOrderByColumn(ProductOptionsValuePeer::LFT);

        $rs = ProductOptionsValuePeer::doSelectRS($c);
        $rs->setFetchmode(ResultSet::FETCHMODE_ASSOC);

        $combinations = array();
        $paths = array();
        $path = '';
        $last_row = null;

        $externalImages = $sf_context->getUser()->getAttribute('external_images', false, 'soteshop/stProduct/export');

        if ($externalImages)
        {
            $request = $sf_context->getRequest();
            $httpPrefix = stConfig::getInstance('stSecurityBackend')->get('ssl') == 'shop' ? 'https://' : 'http://';
            $url = $httpPrefix . $request->getHost();
        }
        else
        {
            $url = '';
        }

        while($rs->next())
        {
            $row = $rs->getRow();
            if ($row['DEPTH'] == 0) 
            {
                $price_type = $row['PRICE_TYPE'];
                if (null === $price_type)
                {
                    $config = stConfig::getInstance('stProduct');
                    $price_type = $config->get('price_type');   
                }

                if ($product->getCurrencyExchange() != 1)
                {
                    $price_type = 'brutto';    
                }

                $combinations[] = self::getJsonFormat(array(self::getParamTranslation('price_type', $culture) => $price_type));
                continue;
            }
            
            $depth = $row['DEPTH'];
            $field = $row['PRODUCT_OPTIONS_FIELD_ID'];

            if ($last_row && ($depth < $last_row['DEPTH'] || $last_row['PRODUCT_OPTIONS_FIELD_ID'] != $field && $last_row['RGT'] < $row['LFT']))
            {
                $path = '';
            }

            if ($row['PRODUCT_OPTIONS_FILTER_ID'])
            {
                $filter = self::getFilter($row['PRODUCT_OPTIONS_FILTER_ID']);
            }
            else
            {
                $filter = null;
            }
            
            if (!isset($paths[$field]))
            {
                $paths[$field] = $path ? $path.' | '.$row['OPT_NAME'] : $row['OPT_NAME'];
                
                $combinations[] = $paths[$field] .' '. self::getJsonFormat(array(
                    self::getParamTranslation('filter', $culture) => $filter ? $filter->getOptName() : '',
                    self::getParamTranslation('default', $culture) => $row['OPT_DEFAULT_VALUE'] ? $row['OPT_DEFAULT_VALUE'] : $row['OPT_VALUE'],
                    self::getParamTranslation('id', $culture) => !$externalImages && null !== $row['PRODUCT_OPTIONS_FIELD_ID'] ? $row['PRODUCT_OPTIONS_FIELD_ID'] : '',
                ));
            }

            $path = $paths[$field].' | '.$row['OPT_VALUE'];
            $last_row = $row;

            if ($row['RGT'] - $row['LFT'] == 1)
            {
                $params = array(
                    self::getParamTranslation('price', $culture) => null !== $row['PRICE'] ? $row['PRICE'] : '',
                    self::getParamTranslation('old_price', $culture) => null !== $row['OLD_PRICE'] ? $row['OLD_PRICE'] : '',
                    self::getParamTranslation('stock', $culture) => null !== $row['STOCK'] ? $row['STOCK'] : '',
                    self::getParamTranslation('weight', $culture) => null !== $row['WEIGHT'] ? $row['WEIGHT'] : '',
                    self::getParamTranslation('code', $culture) => null !== $row['USE_PRODUCT'] ? $row['USE_PRODUCT'] : '',
                    self::getParamTranslation('pum', $culture) => null !== $row['PUM'] ? $row['PUM'] : '',
                    self::getParamTranslation('image', $culture) => $row['SF_ASSET_ID'] ? $row['SF_ASSET_ID'] : '',
                    self::getParamTranslation('man_code', $culture) => $row['MAN_CODE'] ? $row['MAN_CODE'] : '',
                );
                if ($filter && $filter->getFilterType() == 2)
                {
                    if ($row['USE_IMAGE_AS_COLOR'])
                    {
                        $params[self::getParamTranslation('option_color', $culture)] = $url ? $url . ProductOptionsValuePeer::getColorImagePath($product->getId(), $row['ID'], $row['COLOR']) : $row['COLOR'];
                    } 
                    else
                    {
                        $params[self::getParamTranslation('option_color', $culture)] = '#'.$row['COLOR'];
                    }
                }
                $params[self::getParamTranslation('id', $culture)] = !$externalImages && null !== $row['ID'] ? $row['ID'] : '';
                $combinations[] = $path .' '. self::getJsonFormat($params);
            }
            else
            {
                $params = array(
                    self::getParamTranslation('price', $culture) => null !== $row['PRICE'] ? $row['PRICE'] : '',
                    self::getParamTranslation('old_price', $culture) => null !== $row['OLD_PRICE'] ? $row['OLD_PRICE'] : '',
                    self::getParamTranslation('weight', $culture) => null !== $row['WEIGHT'] ? $row['WEIGHT'] : '',
                    self::getParamTranslation('image', $culture) => $row['SF_ASSET_ID'] ? $row['SF_ASSET_ID'] : '',
                    self::getParamTranslation('id', $culture) => !$externalImages && null !== $row['ID'] ? $row['ID'] : '',
                );

                $combinations[] = $path .' '. self::getJsonFormat($params);
            }
        }

        
        return $combinations ? implode("\n", $combinations) : '';
    }

    /**
     * Ustawia opcji dla produktu
     * @param $object - obiekt produktu 
     * @param $value - wartosc
     * @return null
     */
    public static function setProductOptions(Product $product, $value) 
    {
        if ($value)
        {
            $combinations = explode("\n", $value);

            $options = array();

            self::$valid = true; 

            $price_type = null;

            foreach ($combinations as $combination)
            {
                if (!trim($combination)) continue;

                if (null === $price_type && strpos($combination, '{') !== false)
                {
                    $params = self::decodeJsonFormat($combination);

                    if ($params)
                    {
                        $price_type = $params['price_type'];
                        continue;
                    }
                }

                $values = explode('|', $combination);
                
                if (!$values) continue;

                $current = array();
                $params = array();
                foreach ($values as $value) 
                {
                    if (strpos($value, '{') !== false)
                    {
                        $tmp = explode('{', $value);
                        $current[] = trim($tmp[0]);
                        $params = self::decodeJsonFormat('{'.$tmp[1]);                        
                        
                        self::validateOptionsParams($product, $current, $params);
                    }
                    elseif (strpos($value, ':') !== false && preg_match('/:[^,]+,[^,]+,[^,]+,[^,]+/', $value))
                    {
                        stImportExportLog::getActiveLogger()->add($product->getCode(), sfContext::getInstance()->getI18n()->__('<b>%%option%%:</b> Używasz starego formatu opcji produktu. <a href="http://www.sote.pl/trac/wiki/new_doc/products/import_export#Opisplikuimportueksportu" target="_blank">Zapoznaj się z nowym formatem</a>', array(
                            '%%option%%' => implode(' | ', $current)
                        ), 'stProductOptionsBackend'), stImportExportLog::$WARNING); 
                        self::$valid = false;                           
                    }
                    else
                    {
                        $current[] = trim($value);
                    }
                }

                $options[] = array('values' => $current, 'params' => $params);
            }

            if (!self::$valid)
            {
                throw new Exception(sfContext::getInstance()->getI18n()->__('Opcje nie zostały zaimportowane popraw powyższe błędy', null, 'stProductOptionsBackend'));  
            }

            unset($combinations);

            $keepIds = true;

            $ids = array();

            foreach ($options as $i => $option)
            {
                $is_field = ($i + 1) % 2;

                if (!$is_field) {
                    if (isset($option['params']['id']))
                    {
                        $ids[] = $option['params']['id'];
                    }
                }
            }

            if ($ids)
            {
                $c = new Criteria();
                $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product->getId());
                $c->add(ProductOptionsValuePeer::ID, $ids, Criteria::IN);
                $keepIds = ProductOptionsValuePeer::doCount($c);
            }

            $fields = array();
            $values = array();

            $con = Propel::getConnection();
            $sql = sprintf('DELETE %1$s, %2$s, %3$s, %4$s FROM %1$s LEFT JOIN %3$s ON %5$s = %6$s, %2$s LEFT JOIN %4$s ON %7$s = %8$s WHERE %9$s = %7$s AND %10$s = ?',
                ProductOptionsValuePeer::TABLE_NAME,
                ProductOptionsFieldPeer::TABLE_NAME,
                ProductOptionsValueI18nPeer::TABLE_NAME,
                ProductOptionsFieldI18nPeer::TABLE_NAME,
                ProductOptionsValuePeer::ID,
                ProductOptionsValueI18nPeer::ID,
                ProductOptionsFieldPeer::ID,
                ProductOptionsFieldI18nPeer::ID,
                ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, 
                ProductOptionsValuePeer::PRODUCT_ID
            );
    
            $ps = $con->prepareStatement($sql);
            $ps->setInteger(1, $product->getId());
            $ps->executeQuery();


            $root = self::getRootForProduct($product->getId());
            $root->setLft(1);
            $root->setRgt(2);
            $root->_duplicated = true;

            if (null === $price_type)
            {
                $config = stConfig::getInstance('stProduct');
                $price_type = $config->get('price_type');   
            }

            if ($product->getCurrencyExchange() != 1)
            {
                $price_type = 'brutto';    
            }

            $root->setPriceType($price_type);
            $root->save();

            $option_count = 0;

            $culture = stLanguage::getOptLanguage();

            foreach ($options as $index => $option) 
            {
                $field = null;

                $count = count($option['values']);
                $croot = $root;
                for ($i = 0; $i < $count; $i++)
                {
                    $value = $option['values'][$i];
                    $is_field = ($i + 1) % 2;
                    $is_last = $i == $count - 1;
                    $namespace = ($field ? $field->getId() : '').$croot->getId().$value;

                    if ($is_field)
                    {
                        if (!isset($fields[$namespace]))
                        {
                            $field = new ProductOptionsField();
                            $field->setCulture($culture);
                            $field->setName($value);

                            if (isset($option['params']['filter']) && !empty($option['params']['filter']) && self::getFilter($option['params']['filter']))
                            {
                                $filter = self::getFilter($option['params']['filter'], true);
                                $field->setProductOptionsFilterId($filter->getId());
                            }

                            if (isset($option['params']['default']))
                            {
                                $field->setOptDefaultValue($option['params']['default']);
                            }

                            if ($keepIds && isset($option['params']['id'])) 
                            {
                                $field->setId($option['params']['id']);
                            }

                            $field->_duplicated = true;
                            $field->save();
                            $fields[$namespace] = $field;
                        }
                        elseif ($is_last)
                        {
                            stImportExportLog::getActiveLogger()->add($product->getCode(), sfContext::getInstance()->getI18n()->__('<b>%%option%%:</b> Nazwa opcji została zdefiniowana już wcześniej (wiersz: %%row%%)', array(
                                '%%option%%' => implode(' | ', $option['values']),
                                '%%row%%' => $index + 1,             
                            ), 'stProductOptionsBackend'));  
                        }
                        else
                        {
                            $field = $fields[$namespace];
                        }                        
                    }
                    else
                    {
                        if (!isset($values[$namespace]))
                        {
                            $pov = new ProductOptionsValue(); 
                            $pov->setCulture($culture);
                            $pov->setValue($value);
                            $pov->setProductOptionsField($field);

                            if ($field->getProductOptionsFilterId())
                            {
                                $pov->setOptFilterId($field->getProductOptionsFilterId());
                            }

                            if ($keepIds && isset($option['params']['id']))
                            {
                                $pov->setId($option['params']['id']);
                            }
                            
                            if (isset($option['params']['price']))
                            {
                                $pov->setPrice($option['params']['price']);
                            }
                            
                            if (isset($option['params']['old_price']))
                            {
                                $pov->setOldPrice($option['params']['old_price']);
                            }

                            if (isset($option['params']['stock']) && $option['params']['stock'] !== "")
                            {
                                $pov->setStock($option['params']['stock']);
                            }

                            if (isset($option['params']['weight']))
                            {
                                $pov->setWeight($option['params']['weight']);
                            }

                            if (isset($option['params']['code']))
                            {
                                $pov->setUseProduct($option['params']['code']);
                            }

                            if (isset($option['params']['man_code']))
                            {
                                $pov->setManCode($option['params']['man_code']);
                            }

                            if (isset($option['params']['pum']))
                            {
                                $pov->setPum($option['params']['pum']);
                            }

                            if (isset($option['params']['image']))
                            {
                                $pov->setSfAssetId($option['params']['image']);
                            }

                            if (isset($option['params']['option_color']))
                            {
                                $color = $option['params']['option_color'];
                 
                                $pov->setUseImageAsColor($color[0] != '#');

                                if ($pov->getUseImageAsColor())
                                {
                                    $pov->setColor($color);
                                }
                                else
                                {
                                    $pov->setColor(ltrim($color, '#'));
                                }
                            }
                            elseif ($field->getProductOptionsFilterId() && self::getFilter($field->getProductOptionsFilterId()))
                            {
                                $filter = self::getFilter($field->getProductOptionsFilterId());

                                if ($filter->getFilterType() == 2)
                                {
                                    $pov->setColor('ffffff');
                                }
                            }

                            $pov->_duplicated = true;

                            $croot = $croot->reload();

                            $pov->insertAsLastChildOf($croot);

                            $pov->save();

                            $option_count++;

                            if ($pov->getUseImageAsColor())
                            {
                                self::copyProductOptionsColorImage($product, $pov);
                            }

                            if (null == $field->getOptDefaultValue() || $field->getOptDefaultValue() == $value)
                            {
                                $field->getOptDefaultValue($value);
                                $field->setOptValueId($pov->getId());
                                $field->save();
                            }                            

                            $values[$namespace] = $pov;

                            $croot = $pov;
                        }  
                        elseif ($is_last)
                        {
                            stImportExportLog::getActiveLogger()->add($product->getCode(), sfContext::getInstance()->getI18n()->__('<b>%%option%%:</b> Wartość opcji została zdefiniowana już wcześniej (wiersz: %%row%%)', array(
                                '%%option%%' => implode(' | ', $option['values']),
                                '%%row%%' => $index + 1,              
                            ), 'stProductOptionsBackend'));  
                        }
                        else
                        {
                            $croot = $values[$namespace];
                        }                      
                    }
                }
            }

            self::cleanupProductOptionsColorImage($product);
            $product->setOptHasOptions($option_count + 1);              
            $product->setStock(ProductOptionsValuePeer::updateStock($product, false)); 
            ProductOptionsValuePeer::updateProductColor($product, false);
        } 
        else
        {
            self::updateProductOptHasOptions($product, 0);  
        }
    }

    public static function updateStockForOptions(sfEvent $event) 
    {
        $tmp = $event->getParameters();
        $object = $tmp['modelInstance'];
        ProductOptionsValuePeer::updateTotalStock($object->getId());
    }

    public static function updateProductOptHasOptions($product, $count = null) 
    {
        $con = Propel::getConnection();
        $sql = sprintf('UPDATE %1$s SET %2$s = ? WHERE %3$s = %4$s',
            ProductPeer::TABLE_NAME,
            ProductPeer::OPT_HAS_OPTIONS,
            ProductPeer::ID,
            $product->getId()
        );
        $st = $con->prepareStatement($sql);  
        $st->setInteger(1, null !== $count ? $count : $product->countProductOptionsValues());
        $st->executeQuery();      
    }

    public static function getJsonFormat($params)
    {
        return str_replace(array('":', '{', '}', ','), array('": ', '{ ', ' }', ',  '), json_encode($params, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public static function decodeJsonFormat($json)
    {
        return json_decode(trim(self::translateParams(str_replace(array('„', '“', '”'), array('"', '"', '"'), $json))), true);
    }

    public static function getFilter($id, $create = false)
    {
        if (!$id)
        {
            return null;
        }

        return is_numeric($id) ? ProductOptionsFilterPeer::retrieveById($id) : ProductOptionsFilterPeer::retrieveByName($id);
    }

    public static function jsonUnsecapedUnicode($matches)
    {
        return mb_convert_encoding(pack('H*', $matches[1]), 'UTF-8', 'UTF-16');
    }

    protected static function imageExists(Product $product, $image_id)
    {
        $c = new Criteria();
        $c->add(ProductHasSfAssetPeer::SF_ASSET_ID, $image_id);
        $c->add(ProductHasSfAssetPeer::PRODUCT_ID, $product->getId());
        return ProductHasSfAssetPeer::doCount($c);        
    }   

    protected static function checkProductOptionsColorImage(Product $product, &$filename, $current)
    {
        $product_id = $product->getId();

        $is_url = false !== strpos($filename, '://');

        if (!$is_url)
        {
            if (!isset(self::$productOptionsColorPool[$product_id]))
            {
                $images = array();

                foreach (glob(ProductOptionsValuePeer::getColorImageDir($product_id, true).'/*') as $image)
                {   
                    list(,$name) = explode('-', basename($image), 2);  
                        
                    if(!isset($images[$name]))
                    {
                        $images[$name] = array();
                    }

                    $images[$name][] = $image;
                }

                self::$productOptionsColorPool[$product_id] = $images;
            }  
            
            if (isset(self::$productOptionsColorPool[$product_id][$filename]))
            {
                return true;
            }

            $is_file = is_file(sfConfig::get('sf_upload_dir').'/assets/'.$filename);

            if (!$is_file)
            {
                stImportExportLog::getActiveLogger()->add($product->getCode(), sfContext::getInstance()->getI18n()->__('<b>%%option%%:</b> Zdjęcie "%%filename%%" nie zostało znalezione w katalogu "%%dir%%"', array(
                    '%%filename%%' => $filename,
                    '%%dir%%' => basename(sfConfig::get('sf_root_dir')).'/uploads/assets',
                    '%%option%%' => implode(' | ', $current)
                ), 'stProductOptionsBackend'), stImportExportLog::$WARNING);  
            }

            return $is_file;
        }
        else
        {
            try
            {
                $file = stImportExportPropel::getFileContents($filename);
                $filename = basename($file);
                return true;
            }
            catch(Exception $e)
            {
                stImportExportLog::getActiveLogger()->add($product->getCode(), sfContext::getInstance()->getI18n()->__('<b>%%option%%:</b> Wystąpił błąd przy próbie pobrania zdjęcia koloru (błąd: %%error%%)', array(
                    '%%option%%' => implode(' | ', $current),
                    '%%error%%' => $e->getMessage(),             
                ), 'stProductOptionsBackend'));  
            }
        }

        return false;
    }

    protected static function copyProductOptionsColorImage(Product $product, ProductOptionsValue $pov)
    {
        $product_id = $product->getId();

        $filename = $pov->getColor();     

        if (isset(self::$productOptionsColorPool[$product_id][$filename]))
        {
            $oldimagepath = array_pop(self::$productOptionsColorPool[$product_id][$filename]);
            $newimagepath = $pov->getColorImagePath(true);
            rename($oldimagepath, $newimagepath);
        }  
        else
        {
            $oldimagepath = sfConfig::get('sf_upload_dir').'/assets/'.$filename;
            $newimagepath = $pov->getColorImagePath(true);
            $dir = dirname($newimagepath);
            if (!is_dir($dir))
            {
                mkdir($dir, 0755, true);
            }

            copy($oldimagepath, $newimagepath);            
        }
    }

    protected static function cleanupProductOptionsColorImage(Product $product)
    {
        $product_id = $product->getId();
        if (isset(self::$productOptionsColorPool[$product_id]))
        {
            foreach (self::$productOptionsColorPool[$product_id] as $images) 
            {
                foreach ($images as $image) 
                {
                    unlink($image);
                } 
            }
        }
    }

    protected static function validateOptionsParams(Product $product, $current, &$params)
    {
        $code = $product->getCode();
        
        if (!$params)
        {                            
            stImportExportLog::getActiveLogger()->add($code, sfContext::getInstance()->getI18n()->__('<b>%%option%%:</b> Nieprawidłowy format parametrów dla opcji (poprawny: { "parametr": "wartość", "parametr": "wartość" })', array(
                '%%option%%' => implode(' | ', $current)
            ), 'stProductOptionsBackend'), stImportExportLog::$WARNING);
            self::$valid = false; 
            return;
        }

        $culture = sfContext::getInstance()->getUser()->getCulture();

        if (isset($params['filter']) && !empty($params['filter']) && !self::getFilter($params['filter']))
        {
            if (is_numeric($params['filter']))
            {
                stImportExportLog::getActiveLogger()->add($code, sfContext::getInstance()->getI18n()->__('<b>%%option%%:</b> Filtr opcji o id "%%id%%" nie istnieje', array(
                    '%%option%%' => implode(' | ', $current),
                    '%%id%%' => $params['filter'],
                ), 'stProductOptionsBackend'), stImportExportLog::$WARNING);
            } 
            else
            {
                stImportExportLog::getActiveLogger()->add($code, sfContext::getInstance()->getI18n()->__('<b>%%option%%:</b> Filtr opcji o nazwie "%%name%%" nie istnieje', array(
                    '%%option%%' => implode(' | ', $current),
                    '%%name%%' => $params['filter'],
                ), 'stProductOptionsBackend'), stImportExportLog::$WARNING);                
            }
            self::$valid = false; 
        }

        if (isset($params['option_color']) && $params['option_color'][0] != '#' && !self::checkProductOptionsColorImage($product, $params['option_color'], $current))
        {
            self::$valid = false;                         
        } 
        
        if (isset($params['price']) && $params['price'] && !is_numeric(rtrim($params['price'], '%')))  
        {
            stImportExportLog::getActiveLogger()->add($code, sfContext::getInstance()->getI18n()->__('<b>%%option%%:</b> Nieprawidłowy format parametru "%%parameter%%" (poprawny: %%correct%%)', array(
                '%%option%%' => implode(' | ', $current),
                '%%parameter%%' => self::getParamTranslation('price', $culture),
                '%%correct%%' => '+2%, -2.4, 2',
            ), 'stProductOptionsBackend'), stImportExportLog::$WARNING);
            self::$valid = false;                
        }  

        if (isset($params['weight']) && $params['weight'] && !is_numeric(rtrim($params['weight'], '%')))  
        {
            stImportExportLog::getActiveLogger()->add($code, sfContext::getInstance()->getI18n()->__('<b>%%option%%:</b> Nieprawidłowy format parametru "%%parameter%%" (poprawny: %%correct%%)', array(
                '%%option%%' => implode(' | ', $current),
                '%%parameter%%' => self::getParamTranslation('weight', $culture),
                '%%correct%%' => '+2%, -2.4, 2',
            ), 'stProductOptionsBackend'), stImportExportLog::$WARNING); 
            self::$valid = false;                
        }

        if (isset($params['old_price']) && $params['old_price'] && (!is_numeric($params['old_price']) || $params['old_price'] < 0))
        {
            stImportExportLog::getActiveLogger()->add($code, sfContext::getInstance()->getI18n()->__('<b>%%option%%:</b> Nieprawidłowy format parametru "%%parameter%%" (poprawny: %%correct%%)', array(
                '%%option%%' => implode(' | ', $current),
                '%%parameter%%' => self::getParamTranslation('old_price', $culture),
                '%%correct%%' => '2, 2.4, 2.04',                
            ), 'stProductOptionsBackend'), stImportExportLog::$WARNING);  
            self::$valid = false;              
        }  

        if (isset($params['stock']) && $params['stock'] !== "" && (!is_numeric($params['stock']) || $params['stock'] < 0))  
        {
            stImportExportLog::getActiveLogger()->add($code, sfContext::getInstance()->getI18n()->__('<b>%%option%%:</b> Nieprawidłowy format parametru "%%parameter%%" (poprawny: %%correct%%)', array(
                '%%option%%' => implode(' | ', $current),
                '%%parameter%%' => self::getParamTranslation('stock', $culture),
                '%%correct%%' => '2, 2.4, 2.04',  
            ), 'stProductOptionsBackend'), stImportExportLog::$WARNING); 
            self::$valid = false;                 
        } 

        if (isset($params['image']) && $params['image'] && !self::imageExists($product, $params['image'])) 
        {
            stImportExportLog::getActiveLogger()->add($code, sfContext::getInstance()->getI18n()->__('<b>%%option%%:</b> Zdjęcie (parametr "%%parameter%%") produktu o podanym id "%%id%%" nie istnieje', array(
                '%%option%%' => implode(' | ', $current),
                '%%parameter%%' => self::getParamTranslation('image', $culture),
                '%%id%%' => $params['image'],
            ), 'stProductOptionsBackend'), stImportExportLog::$WARNING); 
            self::$valid = false;             
        }                      
    }
}
