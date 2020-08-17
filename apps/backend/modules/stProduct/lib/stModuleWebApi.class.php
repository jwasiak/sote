<?php
/**
 * SOTESHOP/stWebApiPlugin
 *
 * Ten plik należy do aplikacji stWebApiPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stModuleWebApi.class.php 15273 2011-09-27 10:56:44Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

define( "WEBAPI_CATEGORY_ERROR", "Kategoria o id %d nie istenieje.");
define( "WEBAPI_AVAILABILITY_ERROR", "Dostępność o id %d nie istenieje.");

/**
 * Klasa stProductWebApi
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 */
class StProductWebApi extends autoStProductWebApi {

    protected static $optionsPriceType = array();

    protected $productPool = array();

    protected $currencyPool = array();

    public function setFieldsForUpdateTax($object, $item) {    
        if(isset($object->vat_name))
            $item->setVatName($object->vat_name);

        if(isset($object->is_default) && $object->is_default == 1)
            $item->setIsDefault($object->is_default);
    }

    public function AssignProductToCategory($object) {
        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateAssignProductToCategoryFields($object);

        $item = ProductPeer::retrieveByPk($object->id);
        if ($item) {

            $category = CategoryPeer::retrieveByPK($object->category_id);
            if (!$category)
                throw new SoapFault('2', sprintf($this->__(WEBAPI_CATEGORY_ERROR), $object->category_id));

            $c = new Criteria();
            $c->add(ProductHasCategoryPeer::PRODUCT_ID, $object->id);
            $c->add(ProductHasCategoryPeer::CATEGORY_ID, $object->category_id);
            $producHasCategory = ProductHasCategoryPeer::doSelectOne($c);
            if (!$producHasCategory) {
                $producHasCategory = new ProductHasCategory();
                $producHasCategory->setProductId($item->getId());
                $producHasCategory->setCategoryId($category->getId());
            }
            
            if (isset($object->is_default))
                $producHasCategory->setIsDefault($object->is_default);

            $producHasCategory->save();

            $object = new StdClass();
            $object->_update = 1;
            return $object;
        } else {
            throw new SoapFault('1', $this->__(WEBAPI_INCORRECT_ID));
        }
    }

    public function RemoveProductFromCategory($object) {
        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateRemoveProductFromCategoryFields($object);

        $item = ProductPeer::retrieveByPk($object->id);
        if ($item) {
            $c = new Criteria();
            $c->add(ProductHasCategoryPeer::PRODUCT_ID, $object->id);
            $c->add(ProductHasCategoryPeer::CATEGORY_ID, $object->category_id);
            $producHasCategory = ProductHasCategoryPeer::doSelectOne($c);
            if ($producHasCategory) {
                $producHasCategory->delete();
            }
            
            $obj = new StdClass();
            $obj->_delete = 1;
            return $obj;
        } else {
            throw new SoapFault('1', $this->__(WEBAPI_INCORRECT_ID));
        }
    }

    public static function getIsStockValidated($item) {
        return $item->getIsStockValidated(true);
    }

    public static function setIsStockValidated($item, $v) {
        $item->setIsStockValidated($v);
    }

    public static function getProductOptions($item) {
        return stProductOptionsImportExport::getProductOptions($item);
    }

    public static function setProductOptions($item, $value) {
        try {
            if (!$item->isNew()) {
                stProductOptionsImportExport::$useLogger = false;
                return stProductOptionsImportExport::setProductOptions($item, $value);
            }
        } catch (Exception $e) {
            throw new SoapFault('2', sprintf(sfContext::getInstance()->getI18n()->__(WEBAPI_UPDATE_ERROR), $e->getMessage()));
        }
    }

    public function getRAProducts($product_id, $ids, $message)
    {
        if (!isset($product_id))
        {
            throw new SoapFault( "3", sprintf( $this->__(WEBAPI_REQUIRE_ERROR), 'product_id' ));
        }

        $c = new Criteria();
        $c->add(ProductPeer::ID, $product_id);

        if (!ProductPeer::doCount($c))
        {
            throw new SoapFault('2', sfContext::getInstance()->getI18n()->__('Produkt o podanym id %%id%% nie istnieje', array('%%id%%' => $product_id)));
        }

        $results = array();

        if ($ids)
        {
            $c = new Criteria();
            $c->addSelectColumn(ProductPeer::ID);
            $c->add(ProductPeer::ID, $ids, Criteria::IN);

            $rs = ProductPeer::doSelectRS($c);   

            while($rs->next())
            {
                $row = $rs->getRow();
                $results[] = $row[0];
            }  

            $diff = array_diff($ids, $results);

            if ($diff)
            {
                throw new SoapFault('2', sfContext::getInstance()->getI18n()->__($message, array('%%id%%' => implode(', ', $diff))));
            } 
        } 

        return $results;       
    }

    public function UpdateRecommendedList($object)
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');

        if (!isset($object->recommended))
        {
            throw new SoapFault( "3", sprintf( $this->__(WEBAPI_REQUIRE_ERROR), 'recommended' ));
        }

        if (count($object->recommended) > 20)
        {
            throw new SoapFault('2', sfContext::getInstance()->getI18n()->__('Produkt może posiadać maksymalnie 20 produktów polecanych'));
        }

        $ids = $this->getRAProducts($object->product_id, $object->recommended, 'Produkty polecane o podanym id %%id%% nie istnieją');

        $c = new Criteria();
        $c->add(ProductHasRecommendPeer::PRODUCT_ID, $object->product_id);
        ProductHasRecommendPeer::doDelete($c);

        foreach ($ids as $id)
        {
            $phr = new ProductHasRecommend();
            $phr->setRecommendId($id);
            $phr->setProductId($object->product_id);
            $phr->save();
        }  

        $object = new StdClass();
        $object->_update = 1;
        return $object;
    }

    public function UpdateAccessoriesList($object)
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');

        if (!isset($object->accessories))
        {
            throw new SoapFault( "3", sprintf( $this->__(WEBAPI_REQUIRE_ERROR), 'accessories' ));
        }

        if (count($object->accessories) > 20)
        {
            throw new SoapFault('2', sfContext::getInstance()->getI18n()->__('Produkt może posiadać maksymalnie 20 akcesoriów'));
        }

        $ids = $this->getRAProducts($object->product_id, $object->accessories, 'Akcesoria o podanym id %%id%% nie istnieją');

        $c = new Criteria();
        $c->add(ProductHasAccessoriesPeer::PRODUCT_ID, $object->product_id);
        ProductHasAccessoriesPeer::doDelete($c);

        foreach ($ids as $id)
        {
            $pha = new ProductHasAccessories();
            $pha->setAccessoriesId($id);
            $pha->setProductId($object->product_id);
            $pha->save();
        }  

        $object = new StdClass();
        $object->_update = 1;
        return $object;
    }

    public function GetRecommendedList($object)
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');

        if (!isset($object->product_id))
        {
            throw new SoapFault( "3", sprintf( $this->__(WEBAPI_REQUIRE_ERROR), 'product_id' ));
        }

        $c = new Criteria();
        $c->addSelectColumn(ProductHasRecommendPeer::RECOMMEND_ID);
        $c->add(ProductHasRecommendPeer::PRODUCT_ID, $object->product_id);

        $rs = ProductHasRecommendPeer::doSelectRS($c);

        $ids = array();

        while($rs->next())
        {
            $row = $rs->getRow();
            $ids[] = $row[0];
        }

        if (!$ids)
        {
            return array();
        }

        $c = new Criteria();
        
        $c->add(ProductPeer::ID, $ids, Criteria::IN);   

        return $this->getProductListHelper($c);         
    }

    public function GetAccessoriesList($object)
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');

        if (!isset($object->product_id))
        {
            throw new SoapFault( "3", sprintf( $this->__(WEBAPI_REQUIRE_ERROR), 'product_id' ));
        }

        $c = new Criteria();
        $c->addSelectColumn(ProductHasAccessoriesPeer::ACCESSORIES_ID);
        $c->add(ProductHasAccessoriesPeer::PRODUCT_ID, $object->product_id);

        $rs = ProductHasAccessoriesPeer::doSelectRS($c);

        $ids = array();

        while($rs->next())
        {
            $row = $rs->getRow();
            $ids[] = $row[0];
        }  

        if (!$ids)
        {
            return array();
        }

        $c = new Criteria();
        
        $c->add(ProductPeer::ID, $ids, Criteria::IN);          

        return $this->getProductListHelper($c);  
    }

    public function getProductListHelper(Criteria $c)
    {
        $items = ProductPeer::doSelect($c);
        
        if ($items)
        {
          // Zwracanie wyniku, dla wszystkich pol z tablicy 'out'
            $items_array = array();
            foreach ($items as $item)
            {
                $object = new StdClass();
                $this->getFieldsForGetProductList($object, $item);        
                $items_array[] = $object;
            }
            return $items_array;
        } else {
            return array();
        }          
    }

    public function AddProduct( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateAddProductFields( $object );

        if (preg_match('/["\']/', $object->code))
        {
            throw new SoapFault( "2", sprintf($this->__(WEBAPI_ADD_ERROR), $this->__("Niedozwolony kod produktu.")));
        }

        if (isset($object->category_id) && !CategoryPeer::retrieveByPK($object->category_id))
        throw new SoapFault( "2", sprintf($this->__(WEBAPI_ADD_ERROR), $this->__("kategoria o id").' '.$object->category_id.' '.$this->__("nie istnieje")));
        if (isset($object->producer_id) && !ProducerPeer::retrieveByPK($object->producer_id))
        throw new SoapFault( "2", sprintf($this->__(WEBAPI_ADD_ERROR), $this->__("producent o id").' '.$object->producer_id.' '.$this->__("nie istnieje")) );
        if (isset($object->tax_id) && !TaxPeer::retrieveByPK($object->tax_id))
        throw new SoapFault( "2", sprintf($this->__(WEBAPI_ADD_ERROR), $this->__("VAT o id").' '.$object->tax_id.' '.$this->__("nie istnieje")) );
        if (isset($object->weight) && $object->weight<0) $object->weight = 0.0;
        
        $c = new Criteria();
        $c->add(ProductPeer::CODE, $object->code);
        if (is_object(ProductPeer::doSelectOne($c))) {
            throw new SoapFault( "2", sprintf($this->__(WEBAPI_ADD_ERROR), $this->__("produkt o kodzie").' '.$object->code.' '.$this->__("już istnieje")) );
        }

        $item = new Product( );
        if ( $item )
        {
            $this->setFieldsForAddProduct( $object, $item );
            //Zapisywanie danych do bazy
            try {
                //w przypadku gdy nie ma tax id ustaw domyslny
                if (!isset($object->tax_id)) {
                    $c_tax = new Criteria();
                    $c_tax->add(TaxPeer::IS_DEFAULT, 0, Criteria::GREATER_THAN);
                    $tax = TaxPeer::doSelectOne($c_tax);
                } else {
                    $tax = TaxPeer::retrieveByPk($object->tax_id);
                }
                if (is_object($tax)) $item->setTax($tax);
                else throw new SoapFault( "2", sprintf($this->__(WEBAPI_ADD_ERROR), $this->__("Proszę podać poprawną wartość pola vat_id")));
                
                $this->setProductPrices($item, $object);

                $item->save();

                if (isset($object->product_options))
                {
                    stProductOptionsImportExport::$useLogger = false;
                    stProductOptionsImportExport::setProductOptions($item, $object->product_options);
                }

                $item->save();

                $category = CategoryPeer::retrieveByPK($object->category_id);
                if ($category) {
                    $producHasCategory = new ProductHasCategory();
                    $producHasCategory->setProductId($item->getId());
                    $producHasCategory->setCategoryId($object->category_id);
                    $producHasCategory->setIsDefault(true);
                    $producHasCategory->save();
                }

                stNewSearch::buildIndex($item);

            } catch ( Exception $e ) {
                throw new SoapFault( "2", sprintf($this->__(WEBAPI_ADD_ERROR), $this->__("błąd podczas zapisu: ").$e->getMessage()));
            }

            // Zwracanie danych
            $object = new StdClass( );
            $this->getFieldsForAddProduct( $object, $item );
            return $object;

        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_ADD_ERROR) );
        }
    }

    public function UpdateProductOption($object)
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_write');

        if (!isset($object->option_id))
        {
            throw new SoapFault( "3", sprintf( $this->__(WEBAPI_REQUIRE_ERROR), 'option_id' ));
        }  

        $i18n = sfContext::getInstance()->getI18n();

        $option = ProductOptionsValuePeer::retrieveByPK($object->option_id);

        if (null === $option)
        {
            throw new SoapFault( "2", sprintf($this->__(WEBAPI_UPDATE_ERROR), $i18n->__('Opcja o id "%id%" nie istnieje', null, array('%id%' => $object->option_id))));
        }

        $option->setCulture($this->__getCulture());

        if (isset($object->value))
        {
            $option->setValue($object->value);
        }

        if (isset($object->price))
        {
            if (!is_numeric(rtrim($object->price, '%')))
            {
                throw new SoapFault( "2", sprintf($this->__(WEBAPI_UPDATE_ERROR), $i18n->__('Nieprawidłowy format parametru "%%parameter%%" (poprawny: %%correct%%)', array(
                    '%%parameter%%' => 'price',
                    '%%correct%%' => '+2%, -2.4, 2',
                ))));
            }

            $option->setPrice($object->price);
        }    

        if (isset($object->old_price))
        {
            if (!is_numeric($object->old_price))
            {
                throw new SoapFault( "2", sprintf($this->__(WEBAPI_UPDATE_ERROR), $i18n->__('Nieprawidłowy format parametru "%%parameter%%" (poprawny: %%correct%%)', array(
                    '%%parameter%%' => 'old_price',
                    '%%correct%%' => '2, 2.4, 2.04',
                ))));
            } 

            $option->setOldPrice($object->old_price);
        } 

        if (isset($object->stock))
        {
            $option->setStock($object->stock);
        }     

        if (isset($object->weight))
        {
            if (!is_numeric(rtrim($object->weight, '%')))
            {
                throw new SoapFault( "2", sprintf($this->__(WEBAPI_UPDATE_ERROR), $i18n->__('Nieprawidłowy format parametru "%%parameter%%" (poprawny: %%correct%%)', array(
                    '%%parameter%%' => 'weight',
                    '%%correct%%' => '+2%, -2.4, 2',
                ))));
            } 

            $option->setWeight($object->weight);
        }     

        if (isset($object->code))
        {
            $option->setUseProduct($object->code);
        } 

        if (isset($object->man_code))
        {
            $option->setManCode($object->man_code);
        } 

        if (isset($object->pum))
        {
            $option->setPum($object->pum);
        } 

        if (isset($object->image_id))
        {
            $option->setSfAssetId($object->image_id);
        } 

        $option->save();

        $object = new StdClass();
        $object->_update = 1;
        return $object;
    }

    public function CountProductOptionsList($object)
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_write');

        $obj = new StdClass( );
        $c = new Criteria();

        if (isset($object->product_id))
        {
            $c->add(ProductOptionsValuePeer::PRODUCT_ID, $object->product_id);
        }

        if (isset($object->product_code))
        {
            $c->add(ProductOptionsValuePeer::USE_PRODUCT, $object->product_code);
        }
        
        $c->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, null, Criteria::ISNOTNULL);
        $obj->_count = ProductOptionsValuePeer::doCount($c);

        return $obj;        
    }

    public static function getOptionsPriceType($product_id)
    {
        if (!isset(self::$optionsPriceType[$product_id]))
        {
            $price_type = $row['PRICE_TYPE'];

            $c = new Criteria();
            $c->addSelectColumn(ProductOptionsValuePeer::PRICE_TYPE);
            $c->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, null, Criteria::ISNOTNULL);
            $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product_id);
            $c->setLimit(1);
            $rs = ProductOptionsValuePeer::doSelectRS($c);

            $price_type = $rs->next() ? $rs->getString(1) : null;

            if (null === $price_type)
            {
                $config = stConfig::getInstance('stProduct');
                $price_type = $config->get('price_type');   
            }

            self::$optionsPriceType[$product_id] = $price_type;
        }

        return self::$optionsPriceType[$product_id];
    }

    public static function GetProductOptionsListHelper(Criteria $c, $culture)
    {
        $c = clone $c;
        $c->addSelectColumn(ProductOptionsValuePeer::ID);
        $c->addSelectColumn(ProductOptionsValuePeer::SF_ASSET_ID);
        $c->addSelectColumn(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID);
        $c->addSelectColumn(ProductOptionsValuePeer::PRICE);
        $c->addSelectColumn(ProductOptionsValuePeer::WEIGHT);
        $c->addSelectColumn(ProductOptionsValuePeer::PRODUCT_ID);
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
        $c->addSelectColumn(ProductOptionsValueI18nPeer::VALUE);
        $c->addSelectColumn(ProductOptionsFieldI18nPeer::NAME);
        $c->addSelectColumn(ProductOptionsFieldPeer::OPT_NAME);
        

        $c->addAscendingOrderByColumn(ProductOptionsValuePeer::PRODUCT_ID);
        $c->addAscendingOrderByColumn(ProductOptionsValuePeer::LFT);
        $c->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, null, Criteria::ISNOTNULL);
        $c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);
        $c->addJoin(ProductOptionsFieldI18nPeer::ID, sprintf("%s = %s AND %s = '%s'", ProductOptionsFieldI18nPeer::ID, ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN | Criteria::CUSTOM);
        $c->addJoin(ProductOptionsValueI18nPeer::ID, sprintf("%s = %s AND %s = '%s'", ProductOptionsValueI18nPeer::ID, ProductOptionsValuePeer::ID, ProductOptionsValueI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN | Criteria::CUSTOM); 

        $rs = ProductOptionsValuePeer::doSelectRS($c);
   
        $rs->setFetchmode(ResultSet::FETCHMODE_ASSOC); 

        $results = array();
        

        while($rs->next())
        {
            $row = $rs->getRow();

            $price_type = self::getOptionsPriceType($row['PRODUCT_ID']);

            $is_leaf = $row['RGT'] - $row['LFT'] == 1;

            $obj = new StdClass();

            $obj->id = $row['ID'];
            $obj->name = null !== $row['NAME'] ? $row['NAME'] : $row['OPT_NAME'];
            $obj->value = null !== $row['VALUE'] ? $row['VALUE'] : $row['OPT_VALUE'];
            $obj->parent_id = $row['PRODUCT_OPTIONS_VALUE_ID'];
            $obj->product_id = $row['PRODUCT_ID'];
            $obj->price_type = $price_type;
            $obj->price = null !== $row['PRICE'] ? $row['PRICE'] : 0;
            $obj->old_price = null !== $row['OLD_PRICE'] ? $row['OLD_PRICE'] : 0;
            $obj->stock = $is_leaf && null !== $row['STOCK'] ? $row['STOCK'] : null;
            $obj->weight = null !== $row['WEIGHT'] ? $row['WEIGHT'] : 0;
            $obj->code = $is_leaf && null !== $row['USE_PRODUCT'] ? $row['USE_PRODUCT'] : null;
            $obj->man_code = $is_leaf && null !== $row['MAN_CODE'] ? $row['MAN_CODE'] : null;
            $obj->pum = $is_leaf && null !== $row['PUM'] ? $row['PUM'] : null;
            $obj->image_id = $row['SF_ASSET_ID'] ? $row['SF_ASSET_ID'] : '';

            $results[] = $obj;
        }

        return $results;        
    }

    public function GetProductOptionsList($object)
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_write');

        $c = new Criteria();

        if (isset($object->product_id))
        {
            $c->add(ProductOptionsValuePeer::PRODUCT_ID, $object->product_id);
        }

        if (isset($object->product_code))
        {
            $c->add(ProductOptionsValuePeer::USE_PRODUCT, $object->product_code);
        }

        if (isset($object->_offset))
        {
            $c->setOffset($object->_offset);
        }
        
        $c->setLimit(isset($object->_limit) ? $object->_limit : 50);

        return self::GetProductOptionsListHelper($c, $this->__getCulture());
    }


    /**
     * Aktualizacja danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      obiekt z true
     * @throws WEBAPI_INCORRECT_ID WEBAPI_UPDATE_ERROR WEBAPI_REQUIRE_ERROR
     * @todo dodać walidacje danych
     */
    public function UpdateProduct( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateUpdateProductFields( $object );

        if (isset($object->code))
        {
            if (preg_match('/["\']/', $object->code))
            {
                throw new SoapFault( "2", sprintf($this->__(WEBAPI_UPDATE_ERROR), $this->__("Niedozwolony kod produktu.")));
            }
        }

        if (isset($object->category_id) && !CategoryPeer::retrieveByPK($object->category_id))
        throw new SoapFault( "2", sprintf($this->__(WEBAPI_UPDATE_ERROR), $this->__("kategoria o id").' '.$object->category_id.' '.$this->__("nie istnieje")) );
        if (isset($object->producer_id) && !ProducerPeer::retrieveByPK($object->producer_id))
        throw new SoapFault( "2", sprintf($this->__(WEBAPI_UPDATE_ERROR), $this->__("producent o id").' '.$object->producer_id.' '.$this->__("nie istnieje")) );
        if (isset($object->tax_id) && !TaxPeer::retrieveByPK($object->tax_id))
        throw new SoapFault( "2", sprintf($this->__(WEBAPI_UPDATE_ERROR), $this->__("VAT o id").' '.$object->tax_id.' '.$this->__("nie istnieje")) );
        if (isset($object->weight) && $object->weight<0) $object->weight = 0.0;
        
        $item = ProductPeer::retrieveByPk( $object->id );
        if ( $item )
        {
            //Zapisywanie danych do bazy
            try {
                $this->setFieldsForUpdateProduct( $object, $item );

                if (isset($object->category_id)) $this->UpdateDefaultCategory($object->id, $object->category_id);
                $this->setProductPrices($item, $object);

                $item->save();

                stNewSearch::buildIndex($item, true);

            } catch ( Exception $e ) {
                throw new SoapFault( "2", sprintf($this->__(WEBAPI_UPDATE_ERROR),$e->getMessage()) );
            }

            // Zwracanie danych
            $object = new StdClass( );
            $object->_update = 1;
            return $object;

        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID));
        }
    }

    public function UpdateDefaultCategory($product_id, $category_id)
    {
        
        $c = new Criteria();
        $c->add(ProductHasCategoryPeer::PRODUCT_ID, $product_id);
        $c->add(ProductHasCategoryPeer::CATEGORY_ID, $category_id);

        $producHasCategory = ProductHasCategoryPeer::doSelectOne($c);
        if(is_object($producHasCategory)) {
            $producHasCategory->setIsDefault(true);
            $producHasCategory->save();
        } else {
            $producHasCategory = new ProductHasCategory();
            $producHasCategory->setProductId($product_id);
            $producHasCategory->setCategoryId($category_id);
            $producHasCategory->setIsDefault(true);
            $producHasCategory->save();
        }

    }

    /**
     * Zwraca liste zdjec dla produktu
     * @param $object
     * @return array
     */
    public function GetProductImageList( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}        
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetProductImageListFields( $object );
        $this->validateProductImageHelper($object);

        $c = new Criteria( );

        if (isset($object->_modified_from) && isset($object->_modified_to)) {
            $criterion = $c->getNewCriterion(ProductHasSfAssetPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
            $criterion->addAnd($c->getNewCriterion(ProductHasSfAssetPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL));
            $c->add($criterion);
        } else {
            if (isset($object->_modified_from)) {
                $criterion = $c->getNewCriterion(ProductHasSfAssetPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                $c->add($criterion);
            }

            if (isset($object->_modified_to)) {
                $criterion = $c->getNewCriterion(ProductHasSfAssetPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL);
                $c->add($criterion);
            }
        }

        if (!isset($object->_limit)) $object->_limit = 20;

        // ustawiamy kryteria wyboru
        $c->setLimit( $object->_limit );
        $c->setOffset( $object->_offset );
        $c->add(ProductHasSfAssetPeer::PRODUCT_ID, $object->product_id);

        $items = ProductHasSfAssetPeer::doSelectJoinSfAsset( $c );

        if ( $items )
        {
            $format = !isset($object->format) || !$object->format ? 'base64' : $object->format;
            sfLoader::loadHelpers(array('Helper', 'stAsset'));

            // Zwracanie wyniku, dla wszystkich pol z tablicy 'out'
            $items_array = array();
            foreach ( $items as $item )
            {
                $object = new StdClass( );
                $this->getFieldsForGetProductImageList( $object, $item );
                $this->getProductImageHelper($object, $item, $format);
                
                $items_array[] = $object;
            }
            return $items_array;
        } else {
            return array();
        }
    }

    /** 
     * Pobieranie danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      okiekt z danymi
     * @throws WEBAPI_INCORRECT_ID WEBAPI_REQUIRE_ERROR
     */
    public function GetProductImage( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetProductImageFields( $object );
        $this->validateProductImageHelper($object);


        $c = new Criteria();
        $c->add(sfAssetPeer::ID,  $object->id);
        $c->setLimit(1);
        $items = ProductHasSfAssetPeer::doSelectJoinSfAsset($c);

        if ( $items )
        {
            $item = $items[0];
            $format = !isset($object->format) || !$object->format ? 'base64' : $object->format;
            sfLoader::loadHelpers(array('Helper', 'stAsset'));
            $object = new StdClass( );
            $this->getFieldsForGetProductImage( $object, $item );  
            $this->getProductImageHelper($object, $item, $format);      
            return $object;
        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID) );
        }
    }

    public function getProductImageHelper($object, $item, $format)
    {
        if ($format == 'base64')
        {
            $object->image = base64_encode(file_get_contents(st_asset_image_path($item->getSfAsset(),'full', 'product', true, false)));
        }
        elseif ($format == 'url')
        {
            $object->image = st_asset_image_path($item->getSfAsset(),'full', 'product', false, true);
        }

        $object->image_filename = $item->getSfAsset()->getFilename();
        $object->id = $item->getSfAssetId();        
    }

    public function validateProductImageHelper($object)
    {
        if (isset($object->format) && $object->format && !in_array($object->format, array('base64', 'url')))
        {
            throw new SoapFault( "3", sprintf( $this->__(WEBAPI_VALIDATE_ERROR), 'format' ) );
        }
    }
       

    public function getFieldsForAddProductImage( $object, $item ) 
    {
        parent::getFieldsForAddProductImage($object, $item);
        $object->id = $item->getSfAssetId();
    } 

    /**
     * Przeladowanie domyslnej funkcji setFieldsForAddProductImage
     * @param $object
     * @param $item
     * @return unknown_type
     */
    public function setFieldsForAddProductImage( $object, $item ) {
        parent::setFieldsForAddProductImage( $object, $item );

        $input_file = sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.$object->image_filename;
        file_put_contents($input_file,base64_decode($object->image));

        $item->setProductId($object->product_id);
        $item->createAsset($object->image_filename, $input_file, ProductHasSfAssetPeer::IMAGE_FOLDER,pathinfo($object->image_filename,PATHINFO_FILENAME));
    }


    /**
     * Zwraca liczbe zdjec dla produktu
     * @param $object
     * @return $object
     */
    public function CountProductImage( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}        
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        try{
            //Zwracanie danych
            $obj = new StdClass( );
            $c = new Criteria();
            $c->add(ProductHasSfAssetPeer::PRODUCT_ID,$object->product_id);
            $obj->_count = ProductHasSfAssetPeer::doCount( $c );
            return $obj;
        } catch ( Exception $e ) {
            throw new SoapFault( "1", sprintf($this->__(WEBAPI_COUNT_ERROR),$e->getMessage()) );
        }
    }

    /**
     * Usuwanie zdjec dla produktu
     * @param $object
     * @return $object
     */
    public function DeleteProductImage( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}        
        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateDeleteProductImageFields( $object );

        $item = sfAssetPeer::retrieveByPk( $object->id );

        if ( $item )
        {
            // Zwracanie danych
            $obj = new StdClass( );
            $item->delete();
            $obj->_delete = 1;
            return $obj;
        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID));
        }
    }

    /**
     * Pobieranie danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      okiekt z danymi
     * @throws WEBAPI_INCORRECT_ID WEBAPI_REQUIRE_ERROR
     */
    public function GetProductList( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}        
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetProductListFields( $object );
        $c = new Criteria( );

        if (isset($object->_modified_from) && isset($object->_modified_to)) {
            $criterion = $c->getNewCriterion(ProductPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
            $criterion->addAnd($c->getNewCriterion(ProductPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL));
            $c->add($criterion);
        } else {
            if (isset($object->_modified_from)) {
                $criterion = $c->getNewCriterion(ProductPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                $c->add($criterion);
            }

            if (isset($object->_modified_to)) {
                $criterion = $c->getNewCriterion(ProductPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL);
                $c->add($criterion);
            }
        }

        if (isset($object->category_id)) {
            $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);
            $c->add(ProductHasCategoryPeer::CATEGORY_ID,$object->category_id);
        }

        if (!isset($object->_limit)) $object->_limit = 20;

        // ustawiamy kryteria wyboru
        $c->setLimit( $object->_limit );
        $c->setOffset( $object->_offset );

        return $this->getProductListHelper($c);
    }

    /**
     *
     * @param $object
     * @param $item
     * @return unknown_type
     */
    public function getFieldsForCountProduct( $object, $item ) {
        if (method_exists($item,"get_count" ) ) { $object->_count = $item->get_count();}
    }

    /**
     * Zwraca id dostepnosci
     * @param $object
     * @return $object
     */
    public static function getAvailabilityId($item) {
        if (is_object($item->getAvailability()))
        {
            return $item->getAvailability()->getId();
        }
        else
        {
            return 0;
        }
    }

    /**
     * ustawia dostenosc dla produktu
     *
     * @param $item object
     * @param $v mixed
     * @return boolean
     */
    public static function setAvailabilityId($item, $v) {
        $availability = AvailabilityPeer::retrieveByPk($v);
        if ($v==0 || is_object($availability)) $item->setAvailabilityId($v);
        else throw new SoapFault( "2", sprintf($this->__(WEBAPI_AVAILABILITY_ERROR),$v));
        return true;
    }

    /**
     * Usuwanie danych
     *
     * @param   object      $object             obiekt z danymi
     * @return  object      obiekt z true
     * @throws WEBAPI_INCORRECT_ID WEBAPI_DELETE_ERROR WEBAPI_REQUIRE_ERROR
     */
    public function DeleteTax( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}        
        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateDeleteTaxFields( $object );

        $item = TaxPeer::retrieveByPk( $object->id );
        if ( $item )
        {
            if ($item->getIsDefault()) {
                throw new SoapFault( "2", sprintf($this->__(WEBAPI_DELETE_ERROR), $this->__("nie można usunąć domyślnej stawki VAT")) );
            }

            if (TaxPeer::doCount(new Criteria())==1) {
                throw new SoapFault( "2", sprintf($this->__(WEBAPI_DELETE_ERROR), $this->__("w sklepie musi istnieć co najmniej jedna stawka VAT")));
            }
            // Zwracanie danych
            $obj = new StdClass( );
            $item->delete( );
            $obj->_delete = 1;
            return $obj;
        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID));
        }
    }

    /**
     * ustawia stawke VAT dla produktu
     *
     * @param $item object
     * @param $v mixed
     * @return boolean
     */
    public static function setTaxId($item, $v)
    {
        $tax = TaxPeer::retrieveByPk($v);
        if (is_object($tax))
        {
            $item->setTaxId($v);
            $item->setOptVat($tax->getVat());
        } else {
            throw new SoapFault( '2', sprintf($this->__(WEBAPI_UPDATE_ERROR), $this->__("w sklepie nie istnieje stawka VAT")));
        }
    }

    /**
     * Zwraca id stawki VAT
     * @param $object
     * @return $object
     */
    public static function getTaxId($item)
    {
        return $item->getTaxId();
    }

    /**
     * Pobieranie danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      okiekt z danymi
     * @throws WEBAPI_INCORRECT_ID WEBAPI_REQUIRE_ERROR
     */
    public function GetProductByCode( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}        
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetProductByCodeFields( $object );

        $c = new Criteria();
        $c->add(ProductPeer::CODE, $object->code);
        $item = ProductPeer::doSelectOne($c);
        if ( $item )
        {
            $object = new StdClass( );
            $this->getFieldsForGetProduct( $object, $item );
            return $object;
        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID) );
        }
    }

    /**
     * Aktualizacja danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      obiekt z true
     * @throws WEBAPI_INCORRECT_ID WEBAPI_UPDATE_ERROR WEBAPI_REQUIRE_ERROR
     * @todo dodać walidacje danych
     */
    public function UpdateProductByCode( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_write');

        if (isset($object->category_id) && !CategoryPeer::retrieveByPK($object->category_id))
        throw new SoapFault( "2", sprintf($this->__(WEBAPI_UPDATE_ERROR), $this->__("kategoria o id ").$object->category_id.$this->__(" nie istnieje")) );
        if (isset($object->producer_id) && !ProducerPeer::retrieveByPK($object->producer_id))
        throw new SoapFault( "2", sprintf($this->__(WEBAPI_UPDATE_ERROR), $this->__("producent o id ").$object->producer_id.$this->__(" nie istnieje")) );
        if (isset($object->tax_id) && !TaxPeer::retrieveByPK($object->tax_id))
        throw new SoapFault( "2", sprintf($this->__(WEBAPI_UPDATE_ERROR), $this->__("VAT o id ").$object->tax_id.$this->__(" nie istnieje")) );
        if (isset($object->weight) && $object->weight<0) $object->weight = 0.0;
        
        $this->TestAndValidateUpdateProductByCodeFields( $object );

        $c = new Criteria();
        $c->add(ProductPeer::CODE, $object->code);
        $item = ProductPeer::doSelectOne($c);
        if ( $item )
        {
            $this->setFieldsForUpdateProductByCode( $object, $item );
            //Zapisywanie danych do bazy
            try {
                if (isset($object->category_id)) $this->UpdateDefaultCategory($item->getId(), $object->category_id);
                $this->setProductPrices($item, $object);
                $item->save( );

                stNewSearch::buildIndex($item, true);
                
                              
            } catch ( Exception $e ) {
                throw new SoapFault( "2", sprintf($this->__(WEBAPI_ADD_ERROR),$e->getMessage()) );
            }

            // Zwracanie danych
            $object = new StdClass( );
            $object->_update = 1;
            return $object;

        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID) );
        }
    }

    public function validateProductPrices($object, Product $product = null)
    {
        if (null === $product)
        {
            $product = $this->retrieveProduct($object->product_id);
        }

        if (null === $product)
        {
            throw new SoapFault( "2", $this->__('Produkt o id "%%id%%" nie istnieje', array('%%id%%' => $object->product_id)));
        }   
           
        if (isset($object->currency_id))
        {        
            $currency = $this->retrieveCurrency($object->currency_id);

            if (null === $currency)
            {
                throw new SoapFault( "2", $this->__('Waluta o id "%%id%%" nie istnieje', array('%%id%%' => $object->currency_id)));
            }
        }

        if (isset($object->tax_id))
        {
            $product->setVat($object->tax_id);
        }

        $taxValue = $product->getVat();

        if (isset($object->price) && isset($object->price_brutto) && (stPrice::round($object->price) == stPrice::extract($object->price_brutto, $taxValue) || stPrice::round($object->price_brutto) == stPrice::calculate($object->price, $taxValue)) == false)
        {
            throw new SoapFault( "2", $this->__("Cena brutto (price_brutto) nie pokrywa się z ceną netto (jeżeli chcesz zmienić cenę brutto usuń cenę netto)"));
        }

        if (isset($object->old_price) && isset($object->old_price_brutto) && (stPrice::round($object->old_price) == stPrice::extract($object->old_price_brutto, $taxValue) || stPrice::round($object->old_price_brutto) == stPrice::calculate($object->old_price, $taxValue)) == false)
        {
            throw new SoapFault( "2", $this->__("Cena brutto (old_price_brutto) nie pokrywa się z ceną netto (jeżeli chcesz zmienić cenę brutto usuń cenę netto)"));
        }

        if (isset($object->wholesale_a_netto) && isset($object->wholesale_a_brutto) && (stPrice::round($object->wholesale_a_netto) == stPrice::extract($object->wholesale_a_brutto, $taxValue) || stPrice::round($object->wholesale_a_brutto) == stPrice::calculate($object->wholesale_a_netto, $taxValue)) == false)
        {
            throw new SoapFault( "2",  $this->__("Cena brutto (wholesale_a_brutto) nie pokrywa się z ceną netto (jeżeli chcesz zmienić cenę brutto usuń cenę netto)"));
        }

        if (isset($object->wholesale_b_netto) && isset($object->wholesale_b_brutto) && (stPrice::round($object->wholesale_b_netto) == stPrice::extract($object->wholesale_b_brutto, $taxValue) || stPrice::round($object->wholesale_b_brutto) == stPrice::calculate($object->wholesale_b_netto, $taxValue)) == false)
        {
            throw new SoapFault( "2", $this->__("Cena brutto (wholesale_a_brutto) nie pokrywa się z ceną netto (jeżeli chcesz zmienić cenę brutto usuń cenę netto)"));
        }
        
        if (isset($object->wholesale_c_netto) && isset($object->wholesale_c_brutto) && (stPrice::round($object->wholesale_c_netto) == stPrice::extract($object->wholesale_c_brutto, $taxValue) || stPrice::round($object->wholesale_c_brutto) == stPrice::calculate($object->wholesale_c_netto, $taxValue)) == false)
        {
            throw new SoapFault( "2", $this->__("Cena brutto (wholesale_a_brutto) nie pokrywa się z ceną netto (jeżeli chcesz zmienić cenę brutto usuń cenę netto)"));
        }        
    }

    public function TestAndValidateAddProductPriceFields($object)
    {
        parent::TestAndValidateAddProductPriceFields($object);

        if (AddPricePeer::exists($object->product_id, $object->currency_id))
        {
            throw new SoapFault( "2", $this->__('Cena dla waluty o id "%%id%%" już istnieje', array('%%id%%' => $object->currency_id)));
        }

        $this->validateProductPrices($object);
    }

    public function TestAndValidateUpdateProductPriceFields($object)
    {
        parent::TestAndValidateUpdateProductPriceFields($object);

        $this->validateProductPrices($object);
    }

    /** 
     * Zwraca criteria dla metody CountProductPrice
     * @return  Criteria
     */
    public function getCountProductPriceCriteria($object)
    {
        $c = parent::getCountProductPriceCriteria($object);

        if (isset($object->product_id))
        {
            $c->add(AddPricePeer::ID, $object->product_id);
        }

        return $c;
    }

    /** 
     * Zwraca criteria dla metody GetProductPriceList 
     * @return  Criteria
     */
    public function getGetProductPriceListCriteria($object)
    {
        $c = parent::getGetProductPriceListCriteria($object);

        if (isset($object->product_id))
        {
            $c->add(AddPricePeer::ID, $object->product_id);
        }

        return $c;
    }


    public function GetProductPrice( $object )
    {
		if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetProductPriceFields( $object );

        $item = AddPricePeer::retrieveByPk( $object->product_id, $object->currency_id );
        if ( $item )
        {
            $object = new StdClass( );
            $this->getFieldsForGetProductPrice( $object, $item );        
            return $object;
        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID) );
        }
    }

    public function UpdateProductPrice( $object )
    {
		if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateUpdateProductPriceFields( $object );        
        $item = AddPricePeer::retrieveByPk( $object->product_id, $object->currency_id );
        if ( $item )
        {
            $this->setFieldsForUpdateProductPrice( $object, $item );          
            //Zapisywanie danych do bazy
            try {
                $item->save( );
            } catch ( Exception $e ) {
                throw new SoapFault( "2", sprintf($this->__(WEBAPI_UPDATE_ERROR),$e->getMessage()) );
            }
            
            // Zwracanie danych
            $object = new StdClass( );
            $object->_update = 1;
            return $object;
            
        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID) );
        }
    }

    public function DeleteProductPrice( $object )
    {
		if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateDeleteProductPriceFields( $object );

        $item = AddPricePeer::retrieveByPk( $object->product_id, $object->currency_id );
        if ( $item )
        {
            // Zwracanie danych
          $obj = new StdClass( );
          $item->delete();
          $obj->_delete = 1;
          return $obj;
        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID) );
        }
    }

    public function setProductPrices(Product $product, $object)
    {
        $product->setVat($product->getTax()->getId());

        $this->validateProductPrices($object, $product);
        
        if (isset($object->price) && !isset($object->price_brutto)) $product->setPriceBrutto(stPrice::calculate($object->price, $product->getVat()));
        if (!isset($object->price) && isset($object->price_brutto)) $product->setPrice(stPrice::extract($object->price_brutto, $product->getVat()));

        if (isset($object->old_price) && !isset($object->old_price_brutto)) $product->setOldPriceBrutto(stPrice::calculate($object->old_price, $product->getVat()));
        if (!isset($object->old_price) && isset($object->old_price_brutto)) $product->setOldPrice(stPrice::extract($object->old_price_brutto, $product->getVat()));

        if (isset($object->wholesale_a_netto) && !isset($object->wholesale_a_brutto)) $product->setWholesaleABrutto(stPrice::calculate($object->wholesale_a_netto, $product->getVat()));
        if (!isset($object->wholesale_a_netto) && isset($object->wholesale_a_brutto)) $product->setWholesaleANetto(stPrice::extract($object->wholesale_a_brutto, $product->getVat()));

        if (isset($object->wholesale_b_netto) && !isset($object->wholesale_b_brutto)) $product->setWholesaleBBrutto(stPrice::calculate($object->wholesale_b_netto, $product->getVat()));
        if (!isset($object->wholesale_b_netto) && isset($object->wholesale_b_brutto)) $product->setWholesaleBNetto(stPrice::extract($object->wholesale_b_brutto, $product->getVat()));

        if (isset($object->wholesale_c_netto) && !isset($object->wholesale_c_brutto)) $product->setWholesaleCBrutto(stPrice::calculate($object->wholesale_c_netto, $product->getVat()));
        if (!isset($object->wholesale_c_netto) && isset($object->wholesale_c_brutto)) $product->setWholesaleCNetto(stPrice::extract($object->wholesale_c_brutto, $product->getVat()));
    }

    protected function retrieveProduct($id)
    {
        if (!isset($this->productPool[$id]) && !array_key_exists($id, $this->productPool))
        {
            $this->productPool[$id] = ProductPeer::retrieveByPK($id);
        }

        return $this->productPool[$id];
    }

    protected function retrieveCurrency($id)
    {
        if (!isset($this->currencyPool[$id]) && !array_key_exists($id, $this->currencyPool))
        {
            $this->currencyPool[$id] = CurrencyPeer::retrieveByPK($id);
        }

        return $this->currencyPool[$id];
    }
}
