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
 * @version     $Id: stInstaller.class.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
                   
$error_reporting=ini_get('error_reporting');           
error_reporting(0 & ~E_STRICT);
require_once 'PEAR'.DIRECTORY_SEPARATOR.'Config.php';  
require_once 'PEAR'.DIRECTORY_SEPARATOR.'Registry.php';     
error_reporting($error_reporting);

/** 
 * Helper tablic PHP.
 */
require_once (sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stInstallerPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'helper'.DIRECTORY_SEPARATOR.'stArrayHelper.php');        
 
/**
 * stInstallerIgnore class
 */
require_once (sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stInstallerPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stInstallerIgnore.class.php');

/** 
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
class stInstaller 
{   
    /** 
     * @var stInstallerFrontend abstract
     */
    var $ui; 

    /** 
     * Konstruktor
     *
     * @param   string      $mode               (pake|web) określenie typu synchornizacji; pake - wykonywana z task'a, web - wykonywana przez www  
     * @return   true
     */
    function __construct($mode='pake')
    {             
        if ($mode=='pake') 
        {   
            // synchornizacja wykonywana z task'a
            $this->filemanager = stPakeFileManager::getInstance();      
        } else {                                 
            // synchronizacja wykonywana przez www
            $this->filemanager = stWebFileManager::getInstance();      
        }
        return true;
    }                   

    /** 
     * Usatwia obiekt obsługujący wyświetlanie prezyjaznych dla użytkownika komunikatów, wartości.
     *
     * @param        stInstallerOutput abstract      class
     */
    function setOutputObject(&$ui)
    {
        $this->ui=&$ui;      
    }

    /** 
     * @var array Lista zainstalowanych aplikacji przed instalacją.
     */
    var $preData=array();    

    /** 
     * @var array Lista zainstalowanych aplikacji przed instalacją.
     */
    var $postData=array();

    /** 
     * Metoda wywoływana przed wykonaniem instalacji pakietów.
     */
    public function preAction()
    {      
        $this->preData=$this->getInstalledApps();    
    }    

    /** 
     * Metoda wywoływana po wykonaniu instalacji pakietów.
     */
    public function postAction()
    {                                
        $this->postData=$this->getInstalledApps();              
        $changes=$this->getChanges();   
        // synchronizacja po instalacji pakietów
        // $this->sync($changes['all']);
    }     

    /** 
     * Synchronizje listę aplikacji z install/src do sf_root_dir 
     *                                                
     * @param    array $apps
     * @param    string      $title               
     * @return   bool                                 
     */
    public function sync($apps,$title='')
    {                                    
         
        $regsync = new stRegisterSync();
                    
        $this->rootdir=sfConfig::get('sf_root_dir'); 
        // $this->cache=sfConfig::get('sf_root_cache_dir'); // old version for previous sync
        $this->cache=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'sync';

        if (empty($apps)) return true;  

        $data=array('steps'=>sizeof($apps),'title'=>$title);     
        $this->ui->progressBarStart($data);   
        #$this->filemanager->silentMode();    
        $i=1;
        foreach ($apps as $app)
        {                   
            if ($this->_sync($app))
            {          
                if (! $regsync->register($app)) return false;                           
                $data=array('i'=>$i++);     

                $this->filemanager->verboseMode(); 
                $this->ui->progressBarStep($data);
              #  $this->filemanager->silentMode(); 

            }           
        }     
        $this->filemanager->verboseMode();   
        $this->ui->progressBarEnd();  
        
        unset($regsync); // memory optimization

        return true;
    }                          

    /** 
     * Synchronizuje aplikację. Synchronizacja install/src/stAppName -> soteshop
     *                                         
     * @package string $app nazwa aplikacji         
     */
    protected function _sync($app)
    {
        // synchronizuje install/src/stAppName/stAppname -> soteshop                                                                           
        $dir=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src';          
        $from=$dir.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.$app;       

        if (is_dir($from)) 
        {                         
            $this->filemanager->sync($from, $this->rootdir, $this->cache, true, '', $this->getIgnore($app));                                      
        }           

        // synchronizuje install/src/stAppName
        $from=$dir.DIRECTORY_SEPARATOR.$app;                               

        $delete=false;
        if (! is_dir($from)) 
        {
            $this->filemanager->mkdir($from);
            $delete=true;
        }                                                                                                  
        
        $disereg='install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.$app;                              
        $this->filemanager->sync($from, $this->rootdir, $this->cache, true, $disereg, $this->getIgnore($app));      
        if ($delete) $this->filemanager->remove($from);   

        return true;
    }                                                                                          
         
    /**
     * Odczytuje i zwraca listę wyrażeń regularnych, dla pomijanych plików
     *                                                                                     
     * @param string $app nazwa aplikacji np. stAppName
     * @return array ignore|discard (discard - odrzuca zawsze, ignore - pomija jesli plik juz istnieje)
     */
    private function getIgnore($app)
    {                       
        return stInstallerIgnore::getIgnore($app);
    }
    
                                 

    /** 
     * Odczytuje listę dodanych aplikacji.          
     *
     * @see $this->setPreData() $this->setPostData()
     * @return   array
     */
    public function getChanges() 
    {                                                                 
        return st_array_diff($this->preData,$this->postData);
    }                      


    /** 
     * Uaktualnia konfigurację.
     * Dane odczytuje z __database.yml oraz __propel.ini i zapisuje w $sf_path_dir/config/propel.ini config/database.yml
     *
     * @param   string      $sf_path_dir        Scieżka do głownego klatalogu instalacji. Jeśli jest pusta, pobierana jest wartosc SF_ROOT_DIR.  
     * @param               array       $params             array('database'=>array())
     * @return   bool
     */
    static function setConfig($params, $sf_path_dir='')
    {                                      
        if (empty($sf_path_dir)) $sf_path_dir=sfConfig::get('sf_root_dir');
        if (empty($params['database'])) return false;       
        
        $schema = version_compare(phpversion(), '7.0.0', '<') ? 'mysql' : 'mysqli';

        // setup database
        $databases_file = $sf_path_dir.DIRECTORY_SEPARATOR.sfConfig::get('sf_config_dir_name').DIRECTORY_SEPARATOR.'databases.yml';       
        $data=sfYaml::load($databases_file);
        if (! empty($data['all']['propel']['param'])) 
        {
            foreach ($params['database'] as $key=>$val)
            {
                $data['all']['propel']['param'][$key]=$val;
            }
        }    
        
        $data['all']['propel']['param']['phptype'] = $schema;
        
        if (! stFile::write($databases_file,sfYaml::dump($data))) return false;

        // setup propel.ini
        $propelini_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . sfConfig::get('sf_config_dir_name') . DIRECTORY_SEPARATOR .  'propel.ini';
        $data=stFile::read($propelini_file);
        $lines=explode("\n",$data);
        $lines2=''; 
        
        foreach ($lines as $line)
        {            
            $line2=$line;
            $dat=explode('=',$line,2);  
            if (! empty($dat[1])) 
            {
                $key1=$dat[0];$val1=$dat[1];
                $key=trim($key1); $db=$params['database'];
                switch ($key)
                {           
                    case "propel.database.createUrl":       
                    $line2=$key1.'= '.$schema.'://'.$db['username'].':'.$db['password'].'@'.$db['host'].'/';                  // mysql://user:password@localhost/            
                    break;
                    case "propel.database.url":     
                    $line2=$key1.'= '.$schema.'://'.$db['username'].':'.$db['password'].'@'.$db['host'].'/'.$db['database'];  // mysql://user:password@localhost/database          
                    break;
                    case "propel.output.dir": 
                    $line2=$key1.'= '.$sf_path_dir;
                    break;
                }
            }
            $lines2.=$line2."\n";
        }

        if (! stFile::write($sf_path_dir.DIRECTORY_SEPARATOR.sfConfig::get('sf_config_dir_name').DIRECTORY_SEPARATOR.'propel.ini',$lines2)) throw new Exception ('The file '.$propelini_file.' wasn\'t updated.');

        return true;
    }

    /** 
     * Odczytuje wersje i nazwy zainstalowanych aplikacji.
     *
     * @return  array       lista zainstalowanych aplikacji array("stAppName"=>"1.0.2",...)
     */
    public function getInstalledApps() {

        if (class_exists('stPear'))
            return stPear::getInstalledPackages();

        $dat=array();
        $pear_user_file = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'.pearrc';
        $config = new PEAR_Config($pear_user_file, $pear_user_file);  
        $registry =  $config->getRegistry();  
        $installed = $registry->packageInfo(null, null, null);

        foreach ($installed as $channel=>$packages)
        {
            foreach ($packages as $package)
            {                                           
                $pobj = $registry->getPackage(isset($package['package']) ? $package['package'] : $package['name'], $channel);
                $pkg=$pobj->getPackage();
                $ver=$pobj->getVersion(); 
                if ($pkg!='symfony') $dat[$pkg]=$ver;
            }
        } 

        return $dat;
    }

}

