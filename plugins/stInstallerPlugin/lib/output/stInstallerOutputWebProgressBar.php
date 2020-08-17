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
 * @version     $Id: stInstallerOutputWebProgressBar.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
                                                                              

/** 
 * Komunikaty dla Web ProgressBar
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
class stInstallerOutputWebProgressBar extends stInstallerOutput
{
    public function message($message='') 
    {
        
    }  
      
    public function progressBarStart($data=array())  
    {                                         
      
    }     
              
    public function progressBarEnd() 
    {
      
    }
                                                                   
    public function progressBarStep($data=array())  
    {                    
      
    }
        
    public function listStart() {}            
    
    public function listAddItem($data=array()) {}           

    public function listEnd() {}                                             
}
