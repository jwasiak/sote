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
 * @version     $Id: stFtpFileManager.class.php 3782 2010-03-05 13:39:42Z marek $
 */

/** 
 * Obsługa operacji plikowych przez FTP (WWW).
 *
 * @author Marek Jakubowicz
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
class stFtpFileManager extends stBaseFileManager
{
    protected static $instance = null;
    
    /** 
     * Kopiuje plik
     *
     * @param   string      $origin_path        Ścieżka przenoszonego pliku  
     * @param   string      $target_path        Ścieżka docelowa przenoszonego pliku  
     * @param        string      $force_override
     */
    protected function _copy($origin_path, $target_path)
    {
       
    }
    
    /** 
     * Tworzy katalog o podanej ścieżce
     *
     * @param   string      $path               Ścieżka do katalogu  
     */
    protected function _mkdir($path)
    {
       
    }
    
    /** 
     * Usuwa plik lub katalog
     *
     * @param   string      $file               Ścieżka usuwanego pliku lub katalogu  
     */
    protected function _remove($file)
    {
           
    }
    
    public function silentMode()
    {
       
    }
    
    public function verboseMode()
    {
    }
    
    /** 
     * Pobiera instancje obiektu stFileManager
     *
     * @param   $filter_type Typ                filtru (any - dowolny plik, directory - tylko katalogi, file - tylko pliki)
     * @return   stPakeFileManager
     */
    public static function getInstance()
    {
        if (is_null(self::$instance))
        {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
}

