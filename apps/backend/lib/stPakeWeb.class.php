<?php
/** 
 * SOTESHOP/stInstallerWebPlugin 
 * 
 * Ten plik należy do aplikacji stInstallerWebPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stInstallerWebPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPakeWeb.class.php 9276 2010-11-18 12:06:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/** 
 * Uruchamianie tasków przez WWW.                     
 *
 * @author Marek Jakubowicz <marek.jakubowicz@sote.pl>
 *
 * @package     stInstallerWebPlugin
 * @subpackage  libs
 */
class stPakeWeb 
{   
    /** 
     * @var string $content wynik zwrócony przez TASK
     */
    var $content=''; 
    
    /** 
     * @var string $error komunikat blędu jeśli wystąpił wyjątek 
     */
    var $error='';  
    
    /** 
     * @var string wartość niewykorzytywana, wymagana do uruchomienia task'a 
     */
    var $symfony='/usr/bin/symfony';
                         
    /** 
     * Wykonaj Task
     *
     * @param   string      np.                 propel-build-model, cc
     * @return   bool
     */
    public function run($webtask)                 
    {                                   
        if (empty($webtask)) { 
            $this->error='Empty parameter task';           
            return false;
        }
        
        // clean Fast Cache
        if ($webtask=='cc') 
        {
            stFastCacheManager::clearCache();
        }
        
        // symfony directories
        $sf_symfony_lib_dir  = sfConfig::get('sf_symfony_lib_dir');
        $sf_symfony_data_dir = sfConfig::get('sf_symfony_data_dir');
        
        $sf_root_dir=sfConfig::get('sf_root_dir');    
        chdir($sf_root_dir);

        // force populating $argc and $argv in the case PHP does not automatically create them (fixes #2943)
        $argc=array();
        $argv=array($this->symfony,$webtask);    

        $pakelib=$sf_root_dir.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stPake.php';                                  
        require_once($pakelib);                                  

        $pake = pakeApp::get_instance();
        try 
        {       
            ob_start(); 
            $ret = $pake->run(null, $webtask, false);     // wykonaj task
            $content = ob_get_clean();    
            $this->content = $content;   
            return true;
        }                                             
        catch (Exception $ret) 
        {
            $this->error = $ret->getMessage();          
            return false;
        }                          
    }
}