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
 * @version     $Id: stRegisterSync.class.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
      
/** 
 * Plik z bazą danych synchronizowanych aplikacji.
 * @deprecated since stInstallerPlugin 1.0.3
 */
define ("ST_APP_REGISTRY_DB",sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.registry.yml');     
                             
/**
 * Plik z bazą danych synchronizowanych aplikacji.
 */
define ("ST_APP_REGISTRY_DB2",sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.registry.reg'); 

/**
 * Katalog z bazą danych sum kontrolnych
 */      
if (! defined('ST_APP_REGISTRY_MD5SUM'))  
define ("ST_APP_REGISTRY_MD5SUM",sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.md5sum'); 

/** 
 * Obsługuje dane synchronizacji zapisane w pliku.
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
class stRegisterSync 
{   
    /** 
     * @var string plik z bazą danych synchornizowanych aplikacji
     */
    var $registryFile;
     
    /** 
     * @var stInstaller
     */
    var $installer;
    
    /** 
     * Konstruktor.
     */
    public function __construct($file=ST_APP_REGISTRY_DB2) 
    {   
        $this->peari = stPearInfo::getInstance();      
        $this->registryFile=$file;   
        $this->installer = new stInstaller();
        $this->history = new stInstallerHistory();        
        $this->fixmd5sum();
    }             
    
    /** 
     * Zapisz w bazie informacje o zainstalowaniu aplikacji.
     * Baza danych aplikacji install/db/.registry.reg
     *
     * @param   string      $app                nazwa aplikacji
     * @return   bool
    */
  	public function register($app)
  	{           
        $version=$this->peari->getPackageVersion($app);                                    

        if (empty($version)) $action='uninstall';   
        else $action='install';
  	             
        $registry=$this->getData();             
                 
        switch ($action)
        {
            case "install":      
            
                if ($this->registerMd5sum($app))
                {
                    $registry['packages'][$app]=$version;     
                }
               
                break;
            case "uninstall":
                if ($this->unregisterMd5sum($app))
                {
                    unset($registry['packages'][$app]);
                }
                break;
        }
             
        // $ret=stFile::write($this->registryFile,sfYaml::dump($registry));                        
        $ret=stFile::write($this->registryFile,serialize($registry)); 
              
        $this->history->add($app,$version);     // dodaj do historii aktualizacji
        $this->history->save();                 // zapisz po każdej aktualizacji, na wypadek przerwania aktualizacji
               
        $this->peari->optimize(); // zapianie danych optymalizacyjnych PEAR
                
        return $ret;
  	}     
  	
    /** 
     * Odczytuje dane z pliku i zwaraca tablicę.
     *
     * @return   array
     */
    static public function getData()
  	 {
  	      $registry=array();
       	  if (file_exists(ST_APP_REGISTRY_DB2)) 
       	  {             
       	      // update z wersji 1.0.2 do 1.0.3, zmiana lokalizacji pliku danych
       	      // system za pierwszym razem odczytuje dane ze starego pliku a zapisuje w nowym       	      
       	      if (! file_exists(ST_APP_REGISTRY_DB2)) $data=sfYaml::load(ST_APP_REGISTRY_DB2);   
       	      else {
       	          if (file_exists(ST_APP_REGISTRY_DB)) unlink(ST_APP_REGISTRY_DB); // usun stary plik z werjsi 1.0.2
       	          $data=unserialize(file_get_contents(ST_APP_REGISTRY_DB2));
       	      }
       	      
       	      if (! empty($data)) $registry=$data;
          } else {                                                                             
              if (file_exists(ST_APP_REGISTRY_DB))  
              {    
                  $data=sfYaml::load(ST_APP_REGISTRY_DB);   
                  if (! empty($data)) $registry=$data; 
              }
          }          
          return $registry;
  	 }
  	
  	
    /** 
     * Odczytaj listę aplikacji 
     *
     * @return        array       array('stAppName'=>'1.0.2','stTest'=>'1.0.0',...)
     */
    static public function getSynchronizedApps()
    {
  	    $data=self::getData();
        if (is_array($data['packages'])) return $data['packages'];
        else return array();
  	}        
  	
    /**
     * Odczytuje wersje zsynchronizowanej wersji aplikacji
     *
     * @return string|null np. 1.0.2      
     * @todo prztestować
     */                                                   
     static public function getPackageVersion($app)
     {
         $apps=self::getSynchronizedApps();
         if (! empty($apps[$app])) return $apps[$app];
         else return null;
     }   
  	                                  
    /** 
     * Zwraca listę aplikacji so synchronizacji
     *
     * @return   array
     */
  	function getAppsToSync()
  	{     	   
        $apps_pear=$this->installer->getInstalledApps();
        $apps_sync=$this->getSynchronizedApps();
        $changes=st_array_diff($apps_sync,$apps_pear);           
        return $changes;
  	}       
  	
  	/**
  	 * Rejestruje sumy kontrolne plików aplikacji
  	 * 
  	 * @param string $app aplikacja
  	 * @return bool 
  	 */                                          
  	private function registerMd5Sum($app) 
  	{    
         pake_echo ("Registering md5sum for $app");  
  	     $file = new stFile();                                                        
  	     $filereg=$this->peari->getPearRegistryFile($app); 
  	     if (! is_dir(ST_APP_REGISTRY_MD5SUM)) {
  	        
  	         $file->mkdir(ST_APP_REGISTRY_MD5SUM);
  	     }      
         $regfiledb=ST_APP_REGISTRY_MD5SUM.DIRECTORY_SEPARATOR.basename($filereg);
         $file->copy($filereg,$regfiledb);            
  	     return true;
  	}   
  	
  	/**
  	 * Usuwa dane sum kontrolnych aplikacji
  	 * 
  	 * @param string $app aplikacja
  	 * @return bool 
  	 */                                    
  	private function unregisterMd5Sum($app)
  	{                                    
  	     pake_echo ("Unregistering md5sum for $app");    
  	     $file = new stFile(); 
  	     $filereg=strtolower($app).'.reg';     
  	     $regfiledb=ST_APP_REGISTRY_MD5SUM.DIRECTORY_SEPARATOR.basename($filereg);
  	     if (file_exists($regfiledb))
  	     {              
             if ($file->rm($regfiledb)) return true;
             else return false;
         }
         return true;         
  	}        
  	    
  	/**
  	 * Fix soteshop 5.0.0 -> 5.0.1 
  	 * Dodaje bazę install/db/.md5sum. Baza może być dodana przez kopiowanie TYLKO 1 raz, jeśli nie istnieje, 
  	 * lub zostanie błędnie usunięta.
  	 */
  	static public function fixmd5sum()
  	{          
        if (! is_dir(ST_APP_REGISTRY_MD5SUM))
        {
            $peari = stPearInfo::getInstance();
            $file = new stFile();
            $dir=$peari->getPearRegistryDir();
            $apps=sfFinder::type('file')->name('*.reg')->in($dir);     
            if ($file->mkdir(ST_APP_REGISTRY_MD5SUM))
            {
                foreach ($apps as $regfile)
                {
                    $file->copy($regfile,ST_APP_REGISTRY_MD5SUM.DIRECTORY_SEPARATOR.basename($regfile));
                }
            } else throw new Exception('Can\'t make directory '.$dir);
        }
  	}
}


