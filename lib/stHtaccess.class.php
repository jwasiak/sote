<?php
/**
 * SOTESHOP/stUpdate
 *
 * This file is the part of stUpdate application. License: (Open License SOTE) Open License SOTE.
 * Do not modify this file, system will overwrite it during upgrade.
 *
 * @package     stUpdate
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Open License SOTE
 * @version     $Id:  $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

class stHtaccess {

    const BASE_FILE = '/install/db/htaccess.base';

    public static function rebuild($baseFile = null, $params = array()) {

        if (is_null($baseFile)) $baseFile = self::getBaseFilePath();

        if (file_exists($baseFile)) {
            $config = stConfig::getInstance('stHtaccessBackend');
            $content = file_get_contents($baseFile);

            foreach(array('top', 'middle', 'bottom') as $place) {
                if (is_array($params) && !empty($params)) {
                    if (isset($params[$place]) && !empty($params[$place])) {
                        $content = str_replace('###HTACCESS_'.strtoupper($place), $params[$place], $content);
                    }
                } elseif ($config->get($place) != '') {
                    $content = str_replace('###HTACCESS_'.strtoupper($place), $config->get($place), $content);
                }
            }

            file_put_contents(sfConfig::get('sf_web_dir').'/.htaccess', $content);

            return true;
        }
        return false;
    }

    public static function getBaseFilePath() {
        return sfConfig::get('sf_root_dir').self::BASE_FILE;
    }
}
