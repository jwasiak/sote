<?php
/** 
 * SOTESHOP/stInstallerPlugin 
 * 
 * Ten plik należy do aplikacji stInstallerPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stInstallerPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stYamlConfig.class.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/** 
 * Helper tablic PHP.
 */
require_once (sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stInstallerPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'helper'.DIRECTORY_SEPARATOR.'stArrayHelper.php');        
 
/** 
 * Obsługa plików YAML modyfikowanych przez aplikacje ze strony użytkownika.
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
class stYamlConfig {
     
     /** 
      * Odczytuje plik YAML.
      * Odczytywany jest wskazany plik np. /path/file.yml i /path/__file.yml
      */
     static public function load($file) 
     {              
         $user_file=dirname($file).DIRECTORY_SEPARATOR.'__'.basename($file);         
         if (file_exists($file))      $dat1=sfYaml::load($file); else $dat1=array();
         if (file_exists($user_file)) $dat2=sfYaml::load($user_file); else $dat2=array();
           
         return st_array_merge_recursive3($dat1, $dat2);
     }   
     
     /** 
      * Zapisuje konfiguracje użytkownika.
      */
     static public function write($file, $data)
     {
        $user_file=dirname($file).DIRECTORY_SEPARATOR.'__'.basename($file);  
        $data_dump=sfYaml::dump($data);                             
        if (stFile::write($user_file,$data_dump)) return true;
        else return false;
     }      
}
?>
