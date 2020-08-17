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
class ProductOptionsValuePeer extends BaseProductOptionsValuePeer
{
    protected static
            $selectedItems = array(),
            $doSelectByProduct = array(),
            $getPriceType = array(),
            $colorFilters = null;

    const version = 1;

    public static $hide_no_stock = false;

    public static function doCountLeafsJoinProduct(Criteria $c = null, $con = null)
    {
        if($c == null)
        {
            $c = new Criteria();
        }

        $user = sfContext::getInstance()->getUser();
        $filters = sfContext::getInstance()->getRequest()->getParameter('filters', array());
        
        
        $c->add(ProductOptionsValuePeer::LFT, ProductOptionsValuePeer::RGT.'-'.ProductOptionsValuePeer::LFT.'=1', Criteria::CUSTOM);
        $c->addAscendingOrderByColumn(ProductOptionsValuePeer::LFT);
        $c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, BaseProductOptionsFieldPeer::ID);
        $c->addJoin(ProductOptionsValuePeer::ID, ProductOptionsValueI18nPeer::ID.' AND '.ProductOptionsValueI18nPeer::CULTURE.'=\''.$user->getCulture().'\'', Criteria::LEFT_JOIN);
        $c->add(BaseProductOptionsFieldPeer::OPT_NAME, null, Criteria::ISNOTNULL);
        
        return self::doCountJoinProduct($c, $con);
    }    
    
    public static function doSelectLeafsJoinProduct(Criteria $c = null, $con = null)
    {
        if($c == null)
        {
            $c = new Criteria();
        }

        $user = sfContext::getInstance()->getUser();
        $filters = sfContext::getInstance()->getRequest()->getParameter('filters', array());

        $c->add(ProductOptionsValuePeer::LFT, ProductOptionsValuePeer::RGT.'-'.ProductOptionsValuePeer::LFT.'=1', Criteria::CUSTOM);
        $c->addAscendingOrderByColumn(ProductOptionsValuePeer::LFT);
        $c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, BaseProductOptionsFieldPeer::ID);
        $c->addJoin(ProductOptionsValuePeer::ID, ProductOptionsValueI18nPeer::ID.' AND '.ProductOptionsValueI18nPeer::CULTURE.'=\''.$user->getCulture().'\'', Criteria::LEFT_JOIN);
        $c->add(BaseProductOptionsFieldPeer::OPT_NAME, null, Criteria::ISNOTNULL);
        return self::doSelectJoinProduct($c, $con);

    }

    public static function updateStock($product, $update_product = true, $return_stock = true)
    {
        if ($product)
        {
            $is_object = is_object($product);

            if ($is_object && !$product->hasStockManagmentWithOptions())
            {
                return $product->getStock();
            }
            
            $id = $is_object ? $product->getId() : $product;
            $con = Propel::getConnection();
            
            $con->executeQuery(sprintf('UPDATE %1$s v LEFT JOIN %1$s c ON c.LFT BETWEEN v.LFT AND v.RGT AND c.product_id = %2$s AND c.RGT - c.LFT = 1 AND c.stock > 0 SET v.stock = IFNULL(c.stock, 0) WHERE v.product_id = %2$s AND v.RGT - v.LFT > 1',
                ProductOptionsValuePeer::TABLE_NAME,
                $id 
            ));

            if ($update_product || $return_stock)
            {
                $stock = self::getMaxStock($product);
                
                if ($update_product)
                {
                    stDepository::set($product, $stock);
                }

                return $stock;
            }
        }

        return null;
    }

    public static function getMaxStock($product)
    {
        if ($product)
        {
            $id = is_object($product) ? $product->getId() : $product;        
            $c = new Criteria();
            $c->addSelectColumn('MAX('.ProductOptionsValuePeer::STOCK.')');
            $c->add(ProductOptionsValuePeer::PRODUCT_ID, $id);
            $rs = ProductOptionsValuePeer::doSelectRs($c);

            if ($rs && $rs->next())
            {
                $row = $rs->getRow();
                return $row[0];
            }
        }  

        return null;      
    }

    public static function updateTotalStock($product_id)
    {
        ProductOptionsValuePeer::updateStock($product_id);
    }

    public static function unsetTemplate($product)
    {
        $c = new Criteria();
        $c->add(ProductOptionsValuePeer::DEPTH, 0);
        $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product->getId());

        $root = ProductOptionsValuePeer::doSelectOne($c);
        if(is_object($root))
        {
            $root->setProductOptionsTemplateId(null);
            $root->save();
        }
    }

    public static function doSelectByIds($ids)
    {
        $options = array();

        foreach ($ids as $id) 
        {
            $option = self::retrieveByPk($id);
            if (null === $option)
            {
                return array();
            }
            
            $options[] = $option;
        }

        return $options;        
    }

    public static function getProductOptionsStock($product)
    {
        $c = new Criteria();
        $c->add(ProductOptionsValuePeer::PRODUCT_ID,$product->getId());
        $c->add(ProductOptionsValuePeer::LFT, ProductOptionsValuePeer::RGT.'-'.ProductOptionsValuePeer::LFT.'=1', Criteria::CUSTOM);

        $stock = 0;
        foreach (ProductOptionsValuePeer::doSelect($c) as $option)
        {
            $stock+= $option->getStock();
        }
        return $stock;
    }

    public static function retrieveByPkWithProduct($pk)
    {
        $c = new Criteria();

        $c->add(ProductOptionsValuePeer::ID, $pk);

        $options = ProductOptionsValuePeer::doSelectJoinProduct($c);

        return isset($options[0]) ? $options[0] : null;
    }

    public static function retrieveByPksWithProduct($pks)
    {
        $c = new Criteria();

        $c->add(ProductOptionsValuePeer::ID, $pks, Criteria::IN);

        return ProductOptionsValuePeer::doSelectJoinProduct($c);
    }

    public static function setSelectedItems($id, $items = array())
    {
        self::$selectedItems[$id] = $items;
    }

    public static function getSelectedItems($id)
    {
        if (isset(self::$selectedItems[$id])) return self::$selectedItems[$id];
        return array();
    }

    public static function getRoot($product_id)
    {
        $c = new Criteria();
        $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product_id);
        $c->add(ProductOptionsValuePeer::LFT, 1);

        return ProductOptionsValuePeer::doSelectOne($c);
    }

    public static function getPriceType($product)
    {
        $id = is_object($product) ? $product->getId() : $product;

        if (!isset(self::$getPriceType[$id]))
        {
            $c = new Criteria();

            $c->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, null, Criteria::ISNULL);

            $c->add(ProductOptionsValuePeer::PRICE_TYPE, null, Criteria::ISNOTNULL);

            $c->addSelectColumn(ProductOptionsValuePeer::PRICE_TYPE);

            $c->add(ProductOptionsValuePeer::PRODUCT_ID, $id);

            $c->setLimit(1);

            $rs = ProductOptionsValuePeer::doSelectRS($c);

            $config = stConfig::getInstance(null, 'stProduct');

            self::$getPriceType[$id] = $rs->next() ? $rs->getString(1) : $config->get('price_type');
        }

        return self::$getPriceType[$id];
    }

    public static function doSelectByProduct($product, $hide_no_stock = true)
    {
        $id = $product->getId();

        if (!isset(self::$doSelectByProduct[$id]))
        {
            $c = new Criteria();

            $c->add(ProductOptionsValuePeer::PRODUCT_ID, $id);

            self::addOrderCriteria($c);

            $c->add(ProductOptionsValuePeer::DEPTH, 1);

            if ($hide_no_stock && $product->getStockManagment() == ProductPeer::STOCK_PRODUCT_OPTIONS && $product->getConfiguration()->get('hide_options_with_empty_stock')) 
            {
               $c->add(ProductOptionsValuePeer::STOCK, sprintf('(%1$s IS NULL OR %1$s > 0)', ProductOptionsValuePeer::STOCK), Criteria::CUSTOM);
            }            

            self::$doSelectByProduct[$id] = ProductOptionsValuePeer::doSelectJoinProductOptionsField($c);
        }

        return self::$doSelectByProduct[$id];
    }

    public static function getColorImageDir($product_id, $system = false, $root_path = null)
    {
        if (null === $root_path)
        {
            $root_path = '/uploads/options';
        }

        $path = $root_path.'/'.$product_id;

        if ($system) 
        {
            return sfConfig::get('sf_web_dir').$path; 
        }

        return $path;
    }

    public static function getColorImagePath($product_id, $option_id, $color_image_name, $system = false, $root_path = null)
    {
        return self::getColorImageDir($product_id, $system, $root_path).'/'.$option_id.'-'.$color_image_name;
    }

    public static function addOrderCriteria(Criteria $c)
    {
        $c->addAscendingOrderByColumn(ProductOptionsFieldPeer::FIELD_ORDER);
        
        $c->addAscendingOrderByColumn(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID);

        $c->addAscendingOrderByColumn(ProductOptionsValuePeer::LFT);        
    }

    public static function clearImportHash($id)
    {
        ExportMd5HashPeer::clearHash($id, 'Product', 'product_options');       
    }

    public static function updateProductColor($product)
    {
        $object = is_object($product);

        $product_id = $object ? $product->getId() : $product;

        if (null === self::$colorFilters)
        {
            $c = new Criteria();
            $c->addSelectColumn(ProductOptionsFilterPeer::ID);
            $c->add(ProductOptionsFilterPeer::FILTER_TYPE, 2);
            $rs = ProductOptionsFilterPeer::doSelectRs($c);
            self::$colorFilters = array();

            while($rs->next())
            {
                self::$colorFilters[] = $rs->getInt(1);
            }
        }

        $colors = array();

        if (self::$colorFilters)
        {
            $c = new Criteria();
            $c->addSelectColumn(ProductOptionsValuePeer::ID);
            $c->addSelectColumn(ProductOptionsValuePeer::COLOR);
            $c->addSelectColumn(ProductOptionsValuePeer::STOCK);
            $c->addSelectColumn(ProductOptionsValuePeer::USE_IMAGE_AS_COLOR);
            $c->addSelectColumn(ProductOptionsValuePeer::SF_ASSET_ID);
            $c->add(ProductOptionsValuePeer::LFT, ProductOptionsValuePeer::RGT." - ".ProductOptionsValuePeer::LFT." > 0", Criteria::CUSTOM);
            $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product_id);
            $c->add(ProductOptionsValuePeer::OPT_FILTER_ID, self::$colorFilters, Criteria::IN);
            $c->addAscendingOrderByColumn(ProductOptionsValuePeer::LFT);
            $c->addGroupByColumn(ProductOptionsValuePeer::COLOR);
            $rs = ProductOptionsValuePeer::doSelectRs($c);
            
            while($rs->next())
            {
                $row = $rs->getRow();
                $colors[] = array(
                    'color' => $row[3] ? ProductOptionsValuePeer::getColorImagePath($product_id, $row[0], $row[1]) : $row[1],
                    'stock' => $row[2],
                    'image_as_color' => $row[3],
                    'image_id' => $row[4],
                );
            }   
        }    

        if (!$object)
        {
            $sel = new Criteria();
            $sel->add(ProductPeer::ID, $product_id);

            $up = new Criteria();
            $up->add(ProductPeer::OPTIONS_COLOR, serialize($colors));

            BasePeer::doUpdate($sel, $up, Propel::getConnection());  
        }     
        else
        {
            $product->setOptionsColor($colors);
        }    
    }

    public static function doInsert($values, $con = null)
    {

        foreach (sfMixer::getCallables('BaseProductOptionsValuePeer:doInsert:pre') as $callable)
        {
            $ret = call_user_func($callable, 'BaseProductOptionsValuePeer', $values, $con);
            if (false !== $ret)
            {
                return $ret;
            }
        }


        if ($con === null) {
            $con = Propel::getConnection(self::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
            $criteria->remove(ProductOptionsValuePeer::ID);
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from ProductOptionsValue object
            if (!$values->isColumnModified(ProductOptionsValuePeer::ID)) {
                $criteria->remove(ProductOptionsValuePeer::ID); // remove pkey col since this table uses auto-increment
            }  
        }

        // Set the correct dbName
        $criteria->setDbName(self::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->begin();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
            } catch(PropelException $e) {
            $con->rollback();
            throw $e;
        }


        foreach (sfMixer::getCallables('BaseProductOptionsValuePeer:doInsert:post') as $callable)
        {
            call_user_func($callable, 'BaseProductOptionsValuePeer', $values, $con, $pk);
        }

        return $pk;
    }
}
