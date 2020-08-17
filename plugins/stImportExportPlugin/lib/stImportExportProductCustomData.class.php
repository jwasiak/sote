<?php
class stImportExportProductCustomData {

    public static function getWholesaleA(Product $object) {
        return stImportExportProductCustomData::getPriceFor($object->getId(),'A');
    }

    public static function getWholesaleB(Product $object) {
        return stImportExportProductCustomData::getPriceFor($object->getId(),'B');
    }

    public static function getWholesaleC(Product $object) {
        return stImportExportProductCustomData::getPriceFor($object->getId(),'C');
    }

    protected static function getPriceFor($product_id, $whole_sale = 'A'){
        $c = new Criteria();
        $c->add(ProductHasWholesalePeer::PRODUCT_ID,$product_id);

        $item = ProductHasWholesalePeer::doSelectOne($c);
        if (is_object($item)) {
            $func = 'getPrice'.$whole_sale;
            return $item->$func();
        }
        return 0.0;
    }

    public static function setWholesaleA(Product $object, $value) {
        return stImportExportProductCustomData::setPriceFor($object->getId(),'A',$value, $object->getVat());
    }

    public static function setWholesaleB(Product $object, $value) {
        return stImportExportProductCustomData::setPriceFor($object->getId(),'B',$value, $object->getVat());
    }

    public static function setWholesaleC(Product $object, $value) {
        return stImportExportProductCustomData::setPriceFor($object->getId(),'C',$value, $object->getVat());
    }

    protected static function setPriceFor($product_id, $whole_sale = 'A', $price = 0.0, $vat){
        $c = new Criteria();
        $c->add(ProductHasWholesalePeer::PRODUCT_ID,$product_id);

        $item = ProductHasWholesalePeer::doSelectOne($c);

        if (!is_object($item)) {
            $item = new ProductHasWholesale();
            $item->setProductId($product_id);
        }

        $func = 'setPriceBrutto'.$whole_sale.'ByNetto';
        $item->$func($price, $vat);
        $item->save();
    }


    public static function getPositioningTitle(Product $object) {
        $item = stImportExportProductCustomData::getPositioning($object->getId());

        if (is_object($item)) {
            return $item->getTitle();
        }
        return '';
    }

    public static function getPositioningKeywords(Product $object) {
        $item = stImportExportProductCustomData::getPositioning($object->getId());

        if (is_object($item)) {
            return $item->getKeywords();
        }
        return '';
    }

    public static function getPositioningDesc(Product $object) {
        $item = stImportExportProductCustomData::getPositioning($object->getId());

        if (is_object($item)) {
            return $item->getDescription();
        }
        return '';
    }

    public static function setPositioningTitle(Product $object, $value) {
        $item = stImportExportProductCustomData::getPositioning($object->getId());

        if (!is_object($item)) {
            $item = new ProductHasPositioning();
            $item->setProductId($object->getId());
        }
        $item->setCulture($object->getCulture());
        $item->setTitle($value);
        $item->save();
    }

    public static function setPositioningKeywords(Product $object, $value) {
        $item = stImportExportProductCustomData::getPositioning($object->getId());

        if (!is_object($item)) {
            $item = new ProductHasPositioning();
            $item->setProductId($object->getId());
        }
        $item->setCulture($object->getCulture());
        $item->setKeywords($value);
        $item->save();
    }

    public static function setPositioningDesc(Product $object, $value) {
        $item = stImportExportProductCustomData::getPositioning($object->getId());

        if (!is_object($item)) {
            $item = new ProductHasPositioning();
            $item->setProductId($object->getId());
        }
        $item->setCulture($object->getCulture());
        $item->setDescription($value);
        $item->save();
    }


    protected static function getPositioning($product_id) {
        $c = new Criteria();
        $c->add(ProductHasPositioningPeer::PRODUCT_ID,$product_id);

        return ProductHasPositioningPeer::doSelectOne($c);
    }

}