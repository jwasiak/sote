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
 * @version     $Id: stCleanInstallerCache.class.php 10048 2010-12-29 16:37:55Z michal $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
 
sfLoader::loadHelpers('Helper');
use_helper('I18N', 'Url', 'Tag'); 
use_helper('stProgressBar', 'Partial');
    
/** 
 * After installation configuragtion system. Progress bar class.
 *
 * @package     stUpdate
 * @subpackage  libs
 * @deprecated
 */
class stCleanInstallerCache {

    protected $msg = '';
    
    public function step($step) {
        sleep(1);

        $this->msg = __('Optymalizuje', null, 'stInstallerWeb').':';
        return $step + 1;           
    }       
    
    public function getMessage() {
        return $this->msg;      
    }          

    public function getTitle() {
        return __('Konfiguracja i optymalizacja systemu', null, 'stInstallerWeb');
    }             
    
    public function close() {

        sfLoader::loadHelpers('Tag');
        sfLoader::loadHelpers('Javascript');

        $this->msg .= "<script type=\"text/javascript\">document.getElementById('stSetup-install_actions').style.visibility=\"visible\";</script>";
    }                                                                                                                                            
    
    static public function getSteps() {
        return 7; // lucky number :)
    }            
}
