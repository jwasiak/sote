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
 * @version     $Id: stInstallerOutputPake.class.php 3782 2010-03-05 13:39:42Z marek $
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
 * Komunikaty dla konsoli (Pake)
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
class stInstallerOutputPake extends stInstallerOutput
{
    public function message($message='') 
    {
        pake_echo($message);
    }  
      
    public function progressBarStart($data=array())  
    {                                         
        $steps=$data['steps'];                     
        if (! empty($data['title'])) $title=$data['title'].' '; else $title='';
        $this->bar = new Console_ProgressBar($title.'[%bar%] %percent%', '=>', ' ', 80, $steps);
        
    }     
              
    public function progressBarEnd() 
    {
        echo "\n"; 
    }
                                                                   
    public function progressBarStep($data=array())  
    {                    
        $i=$data['i'];          
        $this->bar->update($i);
    }
        
    public function listStart() {}            
    
    public function listAddItem($data=array()) {}           

    public function listEnd() {}                                             
}
