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
 * @version     $Id: stFile.class.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/** 
 * Komunikat błędu, dla trybu odczytywania listy plików z konfiguracji SVN.
 */
define("ERROR_SVN_NOTFOUND", "Check if the .svn exists in your package directories.");

/** 
 * Pliki/Katalogi.
 * Operacje na plikach/katalogach.
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
class stFile
{
    /** 
     * Pliki, które są ignorowane przy kopiowaniu.
     * @var array
     */
    private $ignore = array();
    
    /** 
     * Ustawia pliki ignorowane przy kopiowaniu.
     *
     * @param         array       $ignore
     */
    public function setIgnore($ignore)
    {
        $this->ignore = $ignore;
    }
    
    /** 
     * Rekurencyjne zakładanie katalogów
     *
     * @param   string      $dir                zakładany katalog  
     * @param   string      $rootDir            ścieżka powyżej której nie będą zakładane katalogi  
     * @return   bool
     */
    public function mkdir($dir, $rootDir = '')
    {                                         
	    if (empty($rootDIR)) $rootDir=sfConfig::get('sf_root_dir');
        if (! is_dir($dir))
        {
            if (@mkdir($dir))
            {
                return true;
            } else
            {
                $dir2 = dirname($dir);
                if ($dir2 == $rootDir)
                    return false;
                else
                {
                    $this->mkdir($dir2);
                }
            }
        }
        @mkdir($dir);
        return true;
    }
    
    /** 
     * Rekurencyjne usuwanie katalogów.
     *
     * @see http://pl2.php.net/manual/pl/function.rmdir.php
     * @param   string      $folderPath         usuwany katalog
     * @return   bool
     */
    function rmdir($folderPath)
    {
        if (is_dir($folderPath))
        {
            foreach (scandir($folderPath) as $value)
            {
                if ($value != "." && $value != "..")
                {
                    $value = $folderPath . "/" . $value;
                    if (is_dir($value))
                    {
                        $this->rmdir($value);
                    } elseif (is_file($value))
                    {
                        @unlink($value);
                    }
                }
            }
            
            return rmdir($folderPath);
        } else
        {
            return false;
        }
    }     
    
     /** 
      * Usuń pliki lub katalogi
      *
      * @param   string      $path               ścieżka usuwanego pliku lub katalogu  
      * @return   bool
      */
     public function rm($path)
     {           
        if (is_dir($path))
        {
            if ($this->rmdir($path)) return true;
            else return false;
        } elseif (unlink($path)) return true;
        else return false;
     }
    
    /** 
     * Kopiowanie rekurencyjne katalogów.
     *
     * @see http://pear.php.net/manual/en/package.filesystem.file.php
     * @param   string      $source             Katalog kopiowany.
     * @param   string      $target             Katalog tworzony.
     * @throws ERROR_SVN_NOTFOUND
     */
    public function copy($source, $target)
    {
        if (is_dir($source))
        {
            if (! $this->mkdir($target, sfConfig::get('sf_root_dir')))
            {
                throw new Exception(__CLASS__ . ': Cannot make directory: ' . $target . "\n");
            }
            
            $d = dir($source);
            while (FALSE !== ($entry = $d->read()))
            {
                
                if ($entry == '.' || $entry == '..')
                {
                    continue;
                }
                
                if (in_array($entry, $this->ignore))
                    continue;
                
                $Entry = $source . '/' . $entry;
                if (is_dir($Entry))
                {
                    $this->copy($Entry, $target . '/' . $entry);
                    continue;
                }
                if (! copy($Entry, $target . '/' . $entry))
                {
                    throw new Exception(__CLASS__ . ': Cannot copy the file: ' . "\n" . $Entry . "\nto:\n" . $target . '/' . $entry . "\n\n[Sugestion]:\n" . ERROR_SVN_NOTFOUND);
                }
            }
            $d->close();
        
        } else
        {
            if (! $this->mkdir(dirname($target), sfConfig::get('sf_root_dir')))
            {
                throw new Exception(__CLASS__ . ': Cannot make directory: ' . $target . "\n");
            }
            if (! (copy($source, $target)))
            {
                throw new Exception(__CLASS__ . ": Cannot copy the file:\n$source\nto:\n$target\n\n[Sugestion]:\n" . ERROR_SVN_NOTFOUND);
            }
        }
    }
    
    /** 
     * Zwaraca listę plików ze wskazanego katalogu.
     *
     * @param        string      $dir
     * @param   bool        $hidden             true - odczytaj ukryte pliki, false w p.w.
     * @return   array
     */
    static public function ls($dir, $hidden = false)
    {
        $d = dir($dir);
        $dr = array();
        if (is_object($d))
        {
            while (FALSE !== ($entry = $d->read()))
            {
                if ((preg_match("/^\\./", $entry)) && (! $hidden))
                {
                    continue;
                }
                array_push($dr, $entry);
            }
            $d->close();
        }
        return $dr;
    }
    
    /** 
     * Odczytuje zawartość pliku.
     *
     * @param        string      $file
     * @return  string      Zawartość pliku.  
     */
    static public function read($file)
    {
        if ($fd = fopen($file, 'r'))
        {
            $data=fread($fd, filesize($file));            
            fclose($fd);
            return $data;
        } else
        {         
            return '';
        }
    }
    
     /** 
      * Zapisuje zawartość do pliku.
      *
      * @param   string      $file               plik, do ktorego zpaisujemy dane
      * @param                 string      $data               dane
      * @return   bool
      */
     static public function write($file,$data)
     {          
         if ($fd=fopen($file,"w+")) 
         {
             fwrite($fd,$data,strlen($data));
             fclose($fd);
             return true;
         } else 
         {
             return false;
         }
     }
    
    /** 
     * Metoda do zweryfikowania działania unit-test dla klast StFile.
     *
     * @return   1
     *
     * @package     stInstallerPlugin
     * @subpackage  libs
     */
    function classExistsTest()
    {
        return 1;
    }
}
