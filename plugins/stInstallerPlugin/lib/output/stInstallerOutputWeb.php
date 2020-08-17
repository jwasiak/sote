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
 * @version     $Id: stInstallerOutputWeb.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
                                                                              
/** 
 * PEAR Console ProgressBar
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
require_once (dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR.'ProgressBar.class.php');  
 
/** 
 * Komunikaty dla strony WWW
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
class stInstallerOutputWeb extends stInstallerOutput
{
    public function message($message='') 
    {
        return print_r($message,true);
    }  
      
    public function progressBarStart($data=array())  
    {                                         
        return "start";
    }     
              
    public function progressBarEnd() 
    {
        return "<br>koniec</br>\n";
    }
                                                                   
    public function progressBarStep($data=array())  
    {                    
        $i=$data['i'];  
        return "i=$i<br>";        
        // $this->bar->update($i);
    }
        
    public function listStart() {}            
    
    public function listAddItem($data=array()) {}           

    public function listEnd() {}                                             
}