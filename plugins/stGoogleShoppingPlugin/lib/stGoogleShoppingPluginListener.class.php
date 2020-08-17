<?php

class stGoogleShoppingPluginListener {
    
    public static function generate(sfEvent $event) {
        $event->getSubject()->attachAdminGeneratorFile('stGoogleShoppingPlugin', 'stGoogleShoppingInProduct.yml');
    }
    
    public static function generateStProduct(sfEvent $event) {
        $event->getSubject()->attachAdminGeneratorFile('stGoogleShoppingPlugin', 'stProduct.yml');
    }

    public static function postGetGoogleShoppingOrCreate(sfEvent $event) {
        $action = $event->getSubject();
        if (!$action->getRequestParameter('id')) {
            $c = new Criteria();
            $c->add(GoogleShoppingPeer::PRODUCT_ID, $action->forward_parameters['product_id']);
            $object = GoogleShoppingPeer::doSelectOne($c);
            if (!$object) {
                $object = new GoogleShopping();
                $object->setProductId($action->forward_parameters['product_id']);
            }
            $action->google_shopping = $object;
        }
    }
}
