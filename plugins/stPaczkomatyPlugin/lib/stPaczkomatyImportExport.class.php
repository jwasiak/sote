<?php

class stPaczkomatyImportExport {

    public static function getProduct($object) {
        $c = new Criteria();
        $c->add(PaczkomatyHasProductPeer::PRODUCT_ID, $object->getId());
        $c->add(PaczkomatyHasProductPeer::DISABLE_DELIVERY, 1);
        $hasProductObject = PaczkomatyHasProductPeer::doSelectOne($c);
        if (is_object($hasProductObject)) 
            return 1;
        return 0;
    }

    public function setProduct($object = null, $disableDelivery = 0) {
        $c = new Criteria();
        $c->add(PaczkomatyHasProductPeer::PRODUCT_ID, $object->getId());
        $hasProductObject = PaczkomatyHasProductPeer::doSelectOne($c);

        if (!is_object($hasProductObject)) {
            $hasProductObject = new PaczkomatyHasProduct();
            $hasProductObject->setProductId($object->getId());
        }

        if ($hasProductObject->getDisableDelivery() != $disableDelivery)
            $hasProductObject->setDisableDelivery($disableDelivery);

        $hasProductObject->save();

        return true;
    }
}
