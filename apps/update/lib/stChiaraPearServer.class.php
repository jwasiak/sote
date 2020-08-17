<?php                                                 
/** 
 * SOTESHOP/stUpdate 
 * 
 * This file is the part of stUpdate application. License: (Open License SOTE) Open License SOTE. 
 * Do not modify this file, system will overwrite it during upgrade.
 * 
 * @package     stUpdate
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Open License SOTE
 * @version     $Id: stChiaraPearServer.class.php 13528 2011-06-08 09:57:46Z michal $
 */
 
/** 
 * Chiara PEAR server API.
 *
 * @author Marek jakubowicz <marek.jakubowicz@sote.pl>
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stChiaraPearServer 
{      
    /** 
     * @var string $channel
     */
    var $channel;         
    
    /** 
     * @var array $deps packages dependencies
     */
    var $deps=array();
               
    /** 
     * List of already read packages.
     */
    var $readed=array();                
    
    /** 
     * Options: dependency min|latest
     */
    var $options=array('dependency'=>'min');
    
    /** 
     * Construct
     */
    public function __construct($channel)
    {
        $this->channel=$channel;        
    }                                
              
    /** 
     * Get all dependencies for provided package (recursive).
     *
     * @param        string      $package
     * @param        string      $version
     * @see $this->deps
     */
    public function getDeps($package,$version,$count=0)    
    {                                                 
        if (empty($this->readed[$package][$version]))        
        {
            $data=$this->getPackageInfo($package,$version);               
            $this->readed[$package][$version]=1;
            $this->setVersion($package,$data['version']);
        }
        
        if (isset($data['deps']['required']['package'][0]) && is_array($data['deps']['required']['package'][0]))
        {        
           // >1 dependecies
           $deps=$data['deps']['required']['package'];  
        }    
        elseif (isset($data['deps']['required']['package']))
        {                     
            // 1 dependency
            $deps=array(0=>$data['deps']['required']['package']);
        }
        else return;

        foreach ($deps as $id=>$dep)
        {     
            $name=$dep['name'];
            $version=$dep['min'];         
            if (empty($this->readed[$name][$version])) $this->getDeps($name,$version);           
        }       
        
        return $this->deps;
    }    
                                            
    /** 
     * Set option.
     *
     * @param        string      $option
     * @param         mixed       $value
     */
    public function setOption($option,$value)
    {
        $this->options[$option]=$value;
    }                                  
    
    /** 
     * Get option.
     *
     * @param        string      $option
     * @return   mixed
     */
    private function getOption($option)
    {
        if (! empty($this->options[$option])) return $this->options[$option];
        else return NULL;
    }
    
     /** 
      * Get latest package version.
      *
      * @param        string      $package
      * @param        string      $version
      */
     private function setVersion($package,$version)
     {
         if (! empty($this->deps[$package])) 
         {
             $version_1=intval(str_replace('.','',$version));
             $version_2=intval(str_replace('.','',$this->deps[$package]));
             if ($version_1 > $version_2) $this->deps[$package]=$version;
         } else 
         {
             $this->deps[$package]=$version;
         }  
     }
        
    /** 
     * Get package information from PEAR server.
     *
     * @param   string      $package            package name
     * @param              string      $version            1.0.2
     * @return   array
     */
    private function getPackageInfo($package,$version)
    {              
        $result=array();
        $url_base   = $this->getPackageURL($package);
        
        // latest
        $url_latest = $url_base.'latest.txt';
        $result['latest']=$this->getUrlResponse($url_latest);
             
        if ($this->getOption('dependency')=='latest') $version=$result['latest'];
               
        $result['version']=$version;
        
        // deps 
        $url_deps   = $url_base."deps.$version.txt";                
        $result['deps']=unserialize($this->getUrlResponse($url_deps));
  
        return $result;
    }                                        
    
    /** 
     * Get base URL for package.
     *
     * @param        string      $package
     * @return       string      http://pear.sote.pl/Chiara_PEAR_Server_REST/r/stuser
     */
    private function getPackageURL($package)
    {
        return 'http://'.$this->channel.'/Chiara_PEAR_Server_REST/r/'.strtolower($package).'/';
    }
                  
    /** 
     * Get URL response.
     *
     * @param   string      $url                URL np. http://pear.sote.pl/channel.xml
     * @return  string      zawartość strony URL 
     */
    private function getUrlResponse($url)
    {          
        $c = curl_init(); 
        curl_setopt($c, CURLOPT_URL,  $url); 
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true); 
        $ret = curl_exec($c); 
        curl_close($c); 
                   
        return $ret;
    } 
}