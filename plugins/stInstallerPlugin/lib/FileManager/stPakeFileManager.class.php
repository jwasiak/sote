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
 * @version     $Id: stPakeFileManager.class.php 3782 2010-03-05 13:39:42Z marek $
 */

/** 
 * Obsługa operacji plikowych dla konsoli
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
class stPakeFileManager extends stBaseFileManager
{
    protected static $instance = null;
    
    /** 
     * Kopiuje plik
     *
     * @param   string      $origin_path        Ścieżka przenoszonego pliku  
     * @param   string      $target_path        Ścieżka docelowa przenoszonego pliku  
     * @param        string      $force_override
     */
    protected function _copy($origin_path, $target_path, $perm = null)
    {
        if (is_dir($origin_path))
        {
            pake_mkdirs($target_path);
        } 
        else if (is_file($origin_path))
        {
            pake_copy($origin_path, $target_path, array('override' => true));
        } 
        else if (is_link($origin_path))
        {
            pake_symlink($origin_path, $target_path);
        } 
        else
        {
            throw new pakeException(sprintf('Unable to determine "%s" type', $origin_path));
        }
    }
    
    /** 
     * Tworzy katalog o podanej ścieżce
     *
     * @param   string      $path               Ścieżka do katalogu  
     */
    protected function _mkdir($path, $perm = null)
    {
        pake_mkdirs($path);
    }
    
    /** 
     * Usuwa plik lub katalog
     *
     * @param   string      $file               Ścieżka usuwanego pliku lub katalogu  
     */
    protected function _remove($file)
    {
    
        
        if (is_dir($file) &&  ! is_link($file))
        {
            pake_echo_action('dir-', $file);
            
            if (!@rmdir($file))
            {
                pake_echo_comment(sprintf('Directory "%s" not empty - ignoring...', $file));
            }
        } else
        {
            pake_echo_action(is_link($file) ? 'link-' : 'file-', $file);
            
            unlink($file);
        }
    }
    
    public function silentMode()
    {
        pakeApp::get_instance()->handle_options('--quiet');
        return $this;
    }
    
    public function verboseMode()
    {
        pakeApp::get_instance()->handle_options('--verbose');
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
?>
