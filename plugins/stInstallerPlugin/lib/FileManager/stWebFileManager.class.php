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
 * @version     $Id: stWebFileManager.class.php 3782 2010-03-05 13:39:42Z marek $
 */

/** 
 * Obsługa operacji plikowych dla WWW.
 *
 * @author Marek Jakubowicz
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
class stWebFileManager extends stBaseFileManager
{
    protected static $instance = null;
    
    /** 
     * Kopiuje plik
     *
     * @param   string      $origin_path        Ścieżka przenoszonego pliku  
     * @param   string      $target_path        Ścieżka docelowa przenoszonego pliku  
     */
    protected function _copy($origin_path, $target_path, $perm = null)
    {
        $ret = true;
        
        if (is_file($origin_path))
        {
            $ret = @copy($origin_path, $target_path);
        }
        elseif (is_dir($origin_path))
        {   
            $this->_mkdir($target_path, $perm);
        }
         
        if ($ret)
        {
            $this->chmod($target_path, $perm);
        }
        
        return $ret;
    }
    
    /** 
     * Tworzy katalog o podanej ścieżce
     *
     * @param   string      $path               Ścieżka do katalogu  
     */
    protected function _mkdir($path, $perm = null)
    {
        if (is_null($perm))  
        {
            $perm = $this->perm['dir'];
        }
        
        return @mkdir($path, $perm, true);
    }
    
    /** 
     * Usuwa plik lub katalog
     *
     * @param   string      $file               Ścieżka usuwanego pliku lub katalogu  
     */
    protected function _remove($file)
    {
        if (is_dir($file))
        { 
            return @rmdir($file);
        }
        else
        {
            return @unlink($file);
        }
        
        return false;
    }
    
    public function silentMode()
    {       
        return $this;
    }
    
    public function verboseMode()
    {   
        return $this;
    }
    
    /** 
     * Pobiera instancje obiektu stFileManager
     *
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

