<?php

class stRecommendedProductsImportExport {

    public static function getProductRecommend(Product $object) {
        $recommended = $object->getProductHasRecommendsRelatedByProductId();
        if (is_array($recommended)) {
            $ids = array();
            foreach($recommended as $item) {
                if (is_object($item) && !is_null($item->getCode()))
                $ids[] = $item->getCode();
            }
            return implode(',',$ids);
        }
        return '';
    }

    public static function setProductRecommend(Product $object, $value) {
        $recommended = $object->getProductHasRecommendsRelatedByProductId();

        // usuń w przypadku gdy pole puste
        if (!strlen(trim($value))) {
            if (is_array($recommended)) {
                foreach($recommended as $item) {
                    $item->delete();
                }
            }
            return ;
        }

        $idsNew = explode(',',$value);
        foreach ($idsNew as $key=>$itemValue) {
            if (strlen(trim($itemValue))) {
                $idsNew[$key] = trim($itemValue); 
            } else {
                unset($idsNew[$key]);
            }
        }

        $ids = array();

        if (is_array($recommended)) {
            foreach($recommended as $item) {
                $ids[] = $item->getCode();
            }
        }
        $old = array_diff($ids, $idsNew);
        $idsNew = array_unique(array_diff($idsNew, $ids));

        foreach($recommended as $item) {
            if (array_search($item->getCode(),$old)!== false) {
                $item->delete();
            }
        }

        foreach ($idsNew as $id) {
            $c = new Criteria();
            $c->add(ProductPeer::CODE,$id);
            $recommend = ProductPeer::doSelectOne($c);

            if (is_object($recommend) && $object->getId()!=$recommend->getId()) {
                $tmp = new ProductHasRecommend();
                $tmp->setProductId($object->getId());
                $tmp->setRecommendId($recommend->getId());
                $tmp->save(); 
            }
        }

    }
}
