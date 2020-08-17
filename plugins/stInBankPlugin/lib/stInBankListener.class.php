<?php

class stInBankListener
{
    public static function smartySlotAppend(sfEvent $event, $components)
    {
        if (($event['slot'] == 'base-footer' || $event['slot'] == 'base_footer') && stConfig::getInstance('stInBank')->get('enabled')) {
            $components[] = $event->getSubject()->createComponent('stInBankFrontend', 'helper');
        }

        return $components;      
    } 
}