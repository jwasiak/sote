<?php

class appExportAttributesPeer {

    const PRODUCT_CODE = 'st_product.code';
    
    public static function doCount(Criteria $c) {
        return ProductPeer::doCount(new Criteria());
    }

    public static function doSelect(Criteria $c) {

        $cr = new Criteria();
        $cr->setLimit($c->getLimit());
        $cr->setOffset($c->getOffset());
        $products = ProductPeer::doSelect($cr);

        $results = array();

        $con = Propel::getConnection();

        foreach ($products as $product) {
            $attributes = self::doSelectArrayByProduct($product);

            foreach ($attributes as $attributeId => $attribute) {
                $record = new appExportAttributes();
                $record->productCode = $product->getCode();
                $record->productName = $product->getName();
                $record->attributeName = $attribute['name'];
                $record->attributeId = $attributeId;

                $sql = "SELECT 
                            GROUP_CONCAT(pav.opt_name SEPARATOR ', ') as variantName,
                            GROUP_CONCAT(pav.opt_value SEPARATOR ', ') as variantValue
                        FROM 
                            app_product_attribute_has_variant pahv,
                            app_product_attribute_variant_has_product pavhp,
                            app_product_attribute_variant pav
                        WHERE 
                            pahv.variant_id = pav.id AND
                            pav.id = pavhp.variant_id AND
                            pavhp.PRODUCT_ID = " . $product->getId() . " AND
                            pahv.attribute_id = " . $attributeId;

                $rs = $con->executeQuery($sql);
                $rs->setFetchmode(ResultSet::FETCHMODE_ASSOC);

                $rs->next();
                $row = $rs->getRow();

                $record->variantName = $row['variantValue'];
                if ($attribute['type'] == 'C') $record->variantName = $row['variantName'];
                if ($attribute['type'] == 'B') {
                    if (!is_null($row['variantValue'])) $record->variantName = 'Y';
                    else $record->variantName = 'N';
                }
                $results[] = $record;
            }
        }

        return $results;
    }

    public static function doSelectOne($c) {
        $c = clone $c;
        return ProductPeer::doSelectOne($c);
    }

    public static function doSelectArrayByProduct($product) {
        $ranges = appProductAttributePeer::doSelectCategoriesRangesByProduct($product);

        if (!$ranges) {
            return array();
        }

        $c = new Criteria();

        foreach ($ranges as $range) {
            $sql = sprintf('%s <= %s AND %s >= %s AND %s = %s', CategoryPeer::LFT, $range[0], CategoryPeer::RGT, $range[1], CategoryPeer::SCOPE, $range[2]);
            $c->addOr(CategoryPeer::LFT, $sql, Criteria::CUSTOM);
        }   

        $c->addJoin(appProductAttributePeer::ID, appProductAttributeHasCategoryPeer::ATTRIBUTE_ID);
        $c->addJoin(appProductAttributeHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID); 
        $c->addGroupByColumn(appProductAttributePeer::ID);

        return appProductAttributePeer::doSelectArray($c, 'pl_PL');     
    }
}

class appExportAttributes {

    public $id = null;
    public $productCode = null;
    public $productName = null;
    public $attributeName = null;
    public $attributeId = null;
    public $variantName = null;
    public $code = null;

    public function __call($method, $params) {
        if (preg_match('/^get/', $method)) {
            $attribute = lcfirst(str_replace('get', '', $method));
            return $this->$attribute;
        }
    }
}

class appImportAttributes {

    protected static $currentPK = null; 

    public static function setProductName($object, $value, $log, $data) {}

    public static function setAttributeName($object, $value, $log, $data) {}

    public static function setAttributeId($object, $value, $log, $data) {}

    public static function setVariantName($object, $value, $log, $data) 
    { 
        if ($object && $object->getId()) 
        {
            $attribute = appProductAttributePeer::retrieveByPK($data['attribute_id']);

            if ($attribute) 
            {
                self::clearVariants($object, $attribute);

                $variants = explode(',', $value);
                $attributeVariant = null;

                $type = $attribute->getType();
                $attribute_id = $attribute->getId();

                foreach ($variants as $variant) 
                {
                    $variant = trim($variant);
                    
                    if (empty($variant))
                    {
                        continue;
                    }

                    $c = new Criteria();
                    
                    if ($type == 'C')
                    {
                        $c->add(appProductAttributeVariantPeer::OPT_NAME, $variant);
                    }
                    else
                    {
                        $c->add(appProductAttributeVariantPeer::OPT_VALUE, $type == 'B' ? '' : $variant);
                    }

                    $c->addJoin(appProductAttributeVariantPeer::ID, appProductAttributeHasVariantPeer::VARIANT_ID);
                    $c->add(appProductAttributeHasVariantPeer::ATTRIBUTE_ID, $attribute_id);
                    $attributeVariant = appProductAttributeVariantPeer::doSelectOne($c);

                    if ($type == 'B')
                    {
                        if (in_array($variant, array('1', 'Y', 'Yes', 'T', 'Tak')))
                        {
                            if (!$attributeVariant) {
                                $attributeVariant = new appProductAttributeVariant();
                                $attributeVariant->setCulture(stLanguage::getOptLanguage());
                                $attributeVariant->setValue('');
                                $attributeVariant->save();

                                $pahv = new appProductAttributeHasVariant();
                                $pahv->setAttributeId($attribute->getId());
                                $pahv->setVariantId($attributeVariant->getId());
                                $pahv->save();
                            }
                        }
                        else
                        {
                            $attributeVariant = null;
                        }
                        
                    }
                    elseif ($type != 'C')
                    {
                        if (!$attributeVariant) {
                            $attributeVariant = new appProductAttributeVariant();
                            $attributeVariant->setCulture(stLanguage::getOptLanguage());
                            $attributeVariant->setValue($variant);
                            $attributeVariant->save();

                            $pahv = new appProductAttributeHasVariant();
                            $pahv->setAttributeId($attribute->getId());
                            $pahv->setVariantId($attributeVariant->getId());
                            $pahv->save();
                        }                    
                    }

                    if ($attributeVariant) {
                        $pahp = new appProductAttributeVariantHasProduct();
                        $pahp->setProductId($object->getId());
                        $pahp->setVariantId($attributeVariant->getId());
                        $pahp->save();
                    }                
                }
            }
        }
        else
        {
            stImportExportLog::getActiveLogger()->add($object->getCode(), sfContext::getInstance()->getI18n()->__('Produkt nie istnieje - Atrybut "%attr%" nie został zaktualizowany', array('%attr%' => $data['attribute_name']), 'stProduct'), 2);
        }
    }

    public static function clearVariants($product, $attribute)
    {
        $c = new Criteria();
        $c->addSelectColumn(appProductAttributeHasVariantPeer::VARIANT_ID);
        $c->addJoin(appProductAttributeVariantHasProductPeer::VARIANT_ID, appProductAttributeHasVariantPeer::VARIANT_ID);
        $c->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $product->getId());
        $c->add(appProductAttributeHasVariantPeer::ATTRIBUTE_ID, $attribute->getId());
        $rs = appProductAttributeHasVariantPeer::doSelectRs($c); 

        $ids = array();

        while($rs->next())  
        {
            $row = $rs->getRow();
            $ids[] = $row[0];
        }     

        $c = new Criteria();
        $c->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $product->getId());
        $c->add(appProductAttributeVariantHasProductPeer::VARIANT_ID, $ids, Criteria::IN);
        BasePeer::doDelete($c, Propel::getConnection());
    }
}