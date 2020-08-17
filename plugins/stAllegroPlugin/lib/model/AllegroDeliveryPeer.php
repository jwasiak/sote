<?php

class AllegroDeliveryPeer extends BaseAllegroDeliveryPeer {

    public static function doSelectDefault($environment) {
        $c = new Criteria();
        $c->add(self::IS_DEFAULT, TRUE);
        $c->add(self::ENVIRONMENT, $environment);
        return self::doSelectOne($c);
    }
}