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
 * @version     $Id: stPearDownload.class.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */  

/**
 * Pliki i katalogi z PEAR->Downloads install/download
 * @package stInstallerPlugin
 */                          
class stPearDownload 
{   
    /**
     * @var $int ilość usuniętych plików
     */                                 
    private $count=0;
    
    /**
     * @var string 
     */            
    var $download_dir;
    
    /**
     * Konstruktor.
     */
    public function __construct($download_dir='download')
    {
        $this->download_dir=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.$download_dir;
        return true;
    }               
    
    /**
     * Zwraca listę pakietów.
     * @return array
     */             
    public function getPackages()
    { 
        $result=sfFinder::type('dir')->name("st*")->maxdepth(0)->relative()->in($this->download_dir);
        return $result;
    }                                           
        
    /**
     * Usuwa wskazany pakiet.
     * 
     * @param string $package
     * @return bool
     */ 
    public function deletePackage($package)
    {
        $package_dir  = $this->download_dir.DIRECTORY_SEPARATOR.$package;    
        $package_file = $this->download_dir.DIRECTORY_SEPARATOR.$package.'.tgz';                
        
        if (! is_dir($package_dir)) return true;
        
        $files=sfFinder::type('any')->in($package_dir);
        $items=array_reverse($files);
        foreach ($items as $item)
        {
            if (is_file($item)) { unlink($item);   $this->count++; }
            elseif (is_dir($item)) { rmdir($item); $this->count++; }  
            else return false;
        } 
                                                                                 
        if (is_dir($package_dir))    rmdir($package_dir);
        if (is_file($package_file))  unlink($package_file);
        
        return true;                                                              
    }                                                             
                              
    /**
     * Zwraca liczbę usuniętych plików i katalogów.
     */
    public function getCountDeleted()
    {
        return $this->count;
    }
}                                               
