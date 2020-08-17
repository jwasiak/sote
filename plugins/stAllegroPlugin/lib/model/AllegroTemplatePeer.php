<?php

class AllegroTemplatePeer extends BaseAllegroTemplatePeer {

    public static function doSelectDefault() {
        $c = new Criteria();
        $c->add(self::IS_DEFAULT, TRUE);
        return self::doSelectOne($c);
    }
}
