<?php

/** 
 * SOTESHOP/stExtendImportExportPlugin
 * 
 * 
 * @package     stExtendImportExportPlugin
 * @author      Pawel Byszewski <pawel.byszewski@sote.pl>
 */

class stExtendImportExportPluginListener
{
    
    public static function generateProduct (sfEvent $event)
    {
        $event->getSubject()->attachAdminGeneratorFile('stExtendImportExportPlugin', 'stProduct.yml');
    }
}