<?php

/*
 * @author  Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

class appAdditionalDescPluginListener {

    public static function generate(sfEvent $event) {
        $event->getSubject()->attachAdminGeneratorFile('appAdditionalDescPlugin', 'stProduct.yml');
    }

    public static function append(sfEvent $event, $components) {

        if ($event['slot'] == 'product_right_column' || $event['slot'] == 'add_desc_right') {
            $components[] = $event->getSubject()->createComponent('appAdditionalDescFrontend', 'showRight');
        }
        if ($event['slot'] == 'product_after_description' || $event['slot'] == 'add_desc_after') {
            $components[] = $event->getSubject()->createComponent('appAdditionalDescFrontend', 'show', array("position" => "after"));
        }
        if ($event['slot'] == 'product_before_description' || $event['slot'] == 'add_desc_before') {
            $components[] = $event->getSubject()->createComponent('appAdditionalDescFrontend', 'show', array("position" => "before"));
        }

        return $components;
    }

}