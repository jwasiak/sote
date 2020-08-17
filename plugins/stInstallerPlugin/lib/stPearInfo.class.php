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
 * @version     $Id: stPearInfo.class.php 4329 2010-03-30 13:17:13Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/**
 * Katalog z bazą danych sum kontrolnych
 */
if (! defined('ST_APP_REGISTRY_MD5SUM'))
define ("ST_APP_REGISTRY_MD5SUM",sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.md5sum');

/**
 * Plik optymalizacji danych PEAR summary
 */                                      
define ("ST_PEAR_OPT_SUMMARY",sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.pearsummary');

/**
 * Plik optymalizacji danych PEAR versions
 */                                      
define ("ST_PEAR_OPT_VERSIONS",sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.pearversions');
                  

/** 
 *  Zwaraca informacje o pakietach PEAR zainstaowanych z lokalnym repozytorium.
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
class stPearInfo
{   
    
    /** 
     * @var string ścieżka do konfiguracji PEAR
     */
    protected $pearCfg;                 
    
     /** 
      * @var string katalog zawierający instlację PEAR
      */
     protected $pearDir;
    
    /** 
     * @var array Lista zainstalowanych pakietów. 
     * array(array('appname'=>'nazwa',...)
     */
    protected $packages = array();
    
     /** 
      * Instancja klasy. Singleton.
      * @var object
      */
    protected static $instance_install = null;        
    
    /** 
      * Druga instancja klasy. Singleton. 
      * @var object
      */
    protected static $instance_verify = null;
                              
    /**
     * @var string rodzaj weryfikacji danych o pakietach  
     * install - weryfikuje dane z bazy .registry, verify - weryfikuje dane z .registry i .md5sum 
     */
    protected $mode='install';   
    
    /**
     * 1 linia pliku .pearrc
     */ 
    protected $pearrcVersionHead="#PEAR_Config 0.9";         
    
     /** 
      * Singleton (2x)
      * At the same time can be set more than one instance. 
      * Default system use 2 instances in install & verify mode.
      *                                                   
      * @param   string      $mode install|verify 
      * @return  object      instancja klasy
      */
     public static function getInstance($mode='install')
     {                              
         if ($mode=='install')
         {   
             // one instancje for install mode   
             if (! isset(self::$instance_install))
             {
                 $class = __CLASS__;
                 self::$instance_install = new $class($mode);
             }       
             return self::$instance_install;                
         } elseif ($mode=='verify')
         {
             // one instance for verify mode
             if (! isset(self::$instance_verify))
             {
                 $class = __CLASS__;
                 self::$instance_verify = new $class($mode);
             }
             return self::$instance_verify;                
         } else
         {
             // one instance for rest
             if (! isset(self::$instance))
             {
                 $class = __CLASS__;
                 self::$instance = new $class($mode);
             }
             return self::$instance;
         }
     
     }
    
    /** 
     * Konstruktor. Inicuje konfiguracje.
     *
     * @param string $mode (install|verify)
     */
    public function __construct($mode='install')
    {              
        $this->mode=$mode;
        $this->pearDir=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'; 
        $this->pearCfg=$this->pearDir.DIRECTORY_SEPARATOR.'.pearrc';    
        $channels=$this->getChannels();     
  
        foreach ($channels as $channel) 
        {                          
            $this->packages = array_merge($this->packages,$this->getChannelPackages($channel));    
        }        
               
        if (! $this->isOptimized()) $this->optimize();                                                                                      
    }    
    
    /** 
     * Odczytuje listę pakietów zainstalowanych dla danego kanału wraz z informacjami o tych pakietach.     
     *
     * @param   string      $channel            nazwa kanału PEAR  
     * @return  array       Dane PEAR dla wszystkich zainstalowanych pakietów. array('stName'=>array(...))  
     */
    public function getChannelPackages($channel)
    {       
        // path/install/src/.registry/.channel.__uri        
        $pearDir = $this->getPearRegistryDir() .DIRECTORY_SEPARATOR. '.channel.'.$channel;
        $packagesReg = stFile::ls($pearDir);       
 
        $pInfoData = array();
        foreach ($packagesReg as $package)
        {                                 
            // sprawdz czy istnieje plik w ST_APP_REGISTRY_MD5SUM           
            if ((file_exists(ST_APP_REGISTRY_MD5SUM.DIRECTORY_SEPARATOR.$package)) && ($this->mode=='verify'))
            {   
                // registry przed synchronizacja       
                $filereg=ST_APP_REGISTRY_MD5SUM.DIRECTORY_SEPARATOR.$package;
            } else
            {         
                // registry plikow niesynchornizowanych (np. po upgrade z wczesniejszej wersji) 
                // od soteshop 5.0.1 ten element nie powinien byc wykonywany, gdyż dane są odczytywane z kopii registers
                // ten fragment kodu MUSI pozostać dla zachowania zgodności wersji poprzednich
                $filereg=$pearDir . DIRECTORY_SEPARATOR . $package;                             
            }
            $data=stFile::read($filereg);
            $pinfo = @unserialize($data);   
            if (is_array($pinfo)) $pInfoData[$pinfo['name']] = $pinfo;
        }      

        return $pInfoData;
    }       
    
    /**
     * Zwraca ścieżkę do plików registry    
     */                                     
     public function getPearRegistryDir()
     {
         return $this->pearDir . DIRECTORY_SEPARATOR . '.registry';
     }                
     
     /**
      * Zwaraca plik register dla danego pliku
      *
      * @param string $app aplikacja
      * @return string ścieżka bezwzględna do pliku regiter eg /path/.register/.channel/pear.sote.pl/stproduct.reg
      */                                      
     public function getPearRegistryFile($app)
     {       
         $appfile=strtolower($app).'.reg';  
         $files=sfFinder::type('file')->name($appfile)->in($this->getPearRegistryDir());
         if (sizeof($files)==1) {
             return $files[0];
         } else return NULL;
     }    
    
     /** 
      * Odczytuje listę zainstalowanych pakietów (z optymalizacji)
      *                  
      * @param string $mode ST_PEAR_OPT_SUMMARY, ST_PEAR_OPT_VERSIONS
      * @return   array
      */
      static public function getOptPackages($mode=ST_PEAR_OPT_SUMMARY) {           
         if (self::isOptimized())
         {
             return unserialize(file_get_contents($mode));             
         } else {
             $peari = stPearInfo::getInstance();
             return $peari->getPackages();
         }
      }                                                          
      
      /** 
       * Odczytuje listę zainstalowanych pakietów z PEAR
       *
       * @return   array
       */
      public function getPackages()
      {
          $ret=array();
          foreach ($this->packages as $package=>$data) 
          {
              $ret[$package]=$data['summary'];
          }
          return $ret;

     } 
     
      /** 
       * Odczytuje listę zainstalowanych pakietów
       *
       * @return   array
       */
      public function getPackagesVersions() {
          $ret=array();
          foreach ($this->packages as $package=>$data) 
          {
              $ret[$package]=$data['version']['release'];
          }
          return $ret;
      }        
      
      /** 
       * Odczytaj wersję aplikacji  
       *
       * @param        string      $package
       * @return  string      wersja np. '1.0.2'
       */
      public function getPackageVersion($package)
      {
          return $this->packages[$package]['version']['release'];
      }
     
     
      /** 
       * Odczytuje nazwę pakietu wg podanego pliku/kataogu.
       *
       * @param   string      $file               np. web/css/backend/smCefarmAskAdviserPlugin.css
       * @return  string      package name
       */
      public function getPackage($file)
      {
          foreach ($this->packages as $package=>$data) 
          {
              // print "<pre>";print_r($data);print "</pre>";
              $dt = $data['contents']['dir']['file'];
              foreach ($dt as $id=>$fileData) 
              {
                  $dfile=$fileData['attribs']['name'];
                  if (strpos($dfile, $file) !== false) return $package;    
                  // echo "<li>$dfile</li>";
              }              
          }
          
          return null;
      }                           
      
    /**
     * Odczytuje listę plików dla pakietu
     *
     * @param string $package 
     * @return array
     */             
    public function getFiles($package)
    {                         
         if (! empty($this->packages[$package]['contents']['dir']['file']))
         {
             return $this->packages[$package]['contents']['dir']['file'];
         }
    }        
    
    
    /** 
     * Sprawdza czy dany pakiet jest zainstalowany.
     *
     * @param   string      $package            Nazwa pakietu.
     * @return   bool
     */
    public function isInstalled($package)
    {
        if (! empty($this->packages[$package]))  return true;
        else return false;
    }
    
    /** 
     * Odczytuje numer wersji zainstalowanego pakietu.
     *
     * @param   string      $pqackage           Nazwa pakietu.
     * @return  string      Numer wersji.
     */
    public function getVersion($package)
    {
        $version = @$this->packageInfo[$package]['version']['release'];
        if ($version) return $version;
        else return '';
    }
    
    /**
     * Zwaraca dane z .pearrc
     * Array
     * (
     *    [php_dir]      => /Users/marek/Web/soteshop.502//install/src
     *    [data_dir]     => /Users/marek/Web/soteshop.502//install/src
     *    [www_dir]      => /Users/marek/Web/soteshop.502//install/src
     *    [cfg_dir]      => /Users/marek/Web/soteshop.502//install/src
     *    [ext_dir]      => /Users/marek/Web/soteshop.502//install/src
     *    [doc_dir]      => /Users/marek/Web/soteshop.502//install/src
     *    [test_dir]     => /Users/marek/Web/soteshop.502//install/src
     *    [cache_dir]    => /Users/marek/Web/soteshop.502//install/cache
     *    [download_dir] => /Users/marek/Web/soteshop.502//install/download
     *    [temp_dir]     => /Users/marek/Web/soteshop.502//install/cache
     *    [bin_dir]      => /Users/marek/Web/soteshop.502//install/src
     *    [__channels] => Array
     *        (
     *            [pecl.php.net] => Array
     *                (
     *                )
     *
     *            [__uri] => Array
     *                (
     *                )
     *
     *            [pear.dev.quad.sote.pl] => Array
     *                (
     *                )
     *
     *        )
     *
     *    [cache_ttl] => 3600
     *    [php_bin] => php
     *    [preferred_state] => stable
     *    [umask] => 18
     *    [default_channel] => pear.dev.quad.sote.pl
     * )    
     * 
     * @return array
     */  
    public function getPearrc()
    {
        $rawdata=stFile::read($this->pearCfg);
        if (preg_match("/^\#/",$rawdata))
        {
            $reg=preg_split("/\n/",$rawdata);      
            $this->pearrcVersionHead=$reg[0];
            $rawdata=$reg[1];
        }                
        $result=@unserialize($rawdata);
        if (is_array($result))
        {
            return $result;
        } else return array();
    }
    
    /** 
     * Zwaraca listę kanałów PEAR.
     *
     * @return   array
     */
    public function getChannels() 
    {
        $data=$this->getPearrc();
        foreach ($data['__channels'] as $channel=>$val) {
            if (! preg_match("/php.net/",$channel)) 
            {
                $channels[]=$channel;    
            }
        }
        return $channels;        
    }                  
           
    /**
     * Odczytuje domyślny kanał PEAR
     */                             
    public function getDefaultChannel()
    {
        $data=$this->getPearrc();
        return $data['default_channel'];
    }
        
    /**
     * Aktualizuje ścieżki w konfiguracji PEAR.    
     * Zmienia wartosci:
     *    [php_dir]      => /Users/marek/Web/soteshop.502//install/src
     *    [data_dir]     => /Users/marek/Web/soteshop.502//install/src
     *    [www_dir]      => /Users/marek/Web/soteshop.502//install/src
     *    [cfg_dir]      => /Users/marek/Web/soteshop.502//install/src
     *    [ext_dir]      => /Users/marek/Web/soteshop.502//install/src
     *    [doc_dir]      => /Users/marek/Web/soteshop.502//install/src
     *    [test_dir]     => /Users/marek/Web/soteshop.502//install/src
     *    [cache_dir]    => /Users/marek/Web/soteshop.502//install/cache
     *    [download_dir] => /Users/marek/Web/soteshop.502//install/download
     *    [temp_dir]     => /Users/marek/Web/soteshop.502//install/cache
     *    [bin_dir]      => /Users/marek/Web/soteshop.502//install/src
     */       
    public function updateConfig()
    {
        $data=$this->getPearrc();
        $data2=$data;           
        $sf_root_dir=sfConfig::get('sf_root_dir');
        
        $path = $sf_root_dir.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR;
        foreach ($data as $key=>$value)
        {
           switch ($key)
           {
               case "php_dir":
               case "data_dir":
               case "www_dir":
               case "cfg_dir":
               case "ext_dir":
               case "doc_dir":
               case "bin_dir":
               case "test_dir":     $data2[$key]=$path.'src'     ;break;
               case "temp_dir":
               case "cache_dir":    $data2[$key]=$path.'cache'   ;break;
               case "download_dir": $data2[$key]=$path.'download';break;
           }
        }
        
        $raw=serialize($data2);
        $src=$this->pearrcVersionHead."\n".$raw;     
        if (file_put_contents($this->pearCfg,$src))    
        {
            $data_test = $this->getPearrc();
            if (is_array($data_test)) return true;
            else throw new Exception ('Wrong PEARRC format in file:'.$this->pearCfg);
        } else {
            throw new Exception('Can\'t write data to file:'.$this->pearCfg);
        }
    }     
        
    /**
     * Zwaraca informacje czy zostały zapisane dane optymalizacyjne
     * @return bool
     */
    static public function isOptimized()
    {
        if ((! file_exists(ST_PEAR_OPT_SUMMARY)) || (! file_exists(ST_PEAR_OPT_VERSIONS))) return false;
        else return true;            
    }                              
    
    /**
     * Optymalizuje plik bazy pakietów. Zapisuje tylko aplikacje nazwy i wersje w osobnych plikach.
     * @return true
     */                                                                                         
    public function optimize()
    {
        $packages_summary = $this->getPackages();               
        $packages_versions = $this->getPackagesVersions();      
        
        if (! file_put_contents(ST_PEAR_OPT_SUMMARY, serialize($packages_summary)))  throw new Exception("Unable save file ".ST_PEAR_OPT_SUMMARY);
        if (! file_put_contents(ST_PEAR_OPT_VERSIONS,serialize($packages_versions))) throw new Exception("Unable save file ".ST_PEAR_OPT_VERSIONS);
        
        return true;
    }
        
}

