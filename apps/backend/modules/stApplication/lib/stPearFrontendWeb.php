<?php
/** 
 * SOTESHOP/stApplication 
 * 
 * Ten plik należy do aplikacji stApplication opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stApplication
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stPearFrontendWeb.php 3123 2008-12-10 13:29:11Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
   

error_reporting(1); // domyslnie wylaczamy wyswietlanie bledow, gdyz pakiety PEAR ladowane do obslugi PEAR_Frontened_Web wyswietlaja komunikaty strict error
require_once ("PEAR.php");              

class stPearFrontendWeb {     

    static public function installer() {
                                         
        // konfiguracja  
        // @see http://pear.php.net/package/PEAR_Frontend_Web/docs/latest/__filesource/fsource_apidoc_PEAR_Frontend_Web_PEAR_Frontend_Web-0.7.3docsexample.php.html
        $pear_user_config=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR."install".DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR.".pearrc";      
        $pear_frontweb_protected = true;  // system posiada autoryzacje (symfony) nie wyswietlaj komunikatow o braku autoryzacji
                       
                 
        include_once (sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'modules'.
        DIRECTORY_SEPARATOR.'stApplication'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pearfrontendweb.php');
    }  
}
?>
