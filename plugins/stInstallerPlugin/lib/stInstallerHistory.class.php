<?php
/** 
 * SOTESHOP/stUpdate
 * 
 * Ten plik należy do aplikacji stUpdate  opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stUpdate
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stInstallerHistory.class.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */              
        
/**
 * Baza z historią aktualizacji.
 */
define ("ST_HISTORY_INSTALLER_DB",sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.history.reg');   
    
/**
 * Historia aktualizacji.
 */
class stInstallerHistory 
{   
    private $history = array();                                            
    
    public function __construct()
    {
        if (file_exists(ST_HISTORY_INSTALLER_DB))  
        {
            $data = file_get_contents(ST_HISTORY_INSTALLER_DB);
            $this->history = unserialize($data);
        }
    }
    
    /**             
     * Zwraca historię aktualizacji    
     * @param  int $limit liczba ostatnich aktualizacji, 0 - zwraca wszystkie aktualizacje
     * @return array
     */
    public function getHistory($limit=0)
    {                         
        return $this->history;
    } 
    
    public function add($package,$version)
    {
        $this->history[date('Y/m/d')][]=array('package'=>$package,'version'=>$version,'date'=>date('Y:m:d H:i:s'));
    }     
    
    public function save()
    {
        $data = serialize($this->history);
        file_put_contents(ST_HISTORY_INSTALLER_DB,$data);
    }                  
        
}

