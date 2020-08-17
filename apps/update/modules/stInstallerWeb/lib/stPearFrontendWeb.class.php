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
 * @version     $Id: stPearFrontendWeb.class.php 11065 2011-02-16 10:38:27Z marek $
 */
                 
/** 
 * PEAR Frontend Web.
 *
 * @author Marek jakubowicz <marek.jakubowicz@sote.pl>
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stPearFrontendWeb extends PEAR_Frontend_CLI 
{   
    
     
    public function PEAR_Frontend_Web()
    {
        parent::PEAR();
        $this->config = &$GLOBALS['_PEAR_Frontend_Web_config'];
    }

    function setConfig(&$config)
    {
        $this->config = &$config;
    }
    
    /** 
     * Display human-friendly output formatted depending on the
     * $command parameter.
     * This should be able to handle basic output data with no command
     * @abstract
     *
     * @param   mixed       $data               data structure containing the information to display
     * @param   string      $command            command from which this method was called
     */
    public function outputData($data, $command = '_default')
    {      
       switch ($command)
       {
           case "list":    
               $this->_list($data);
               break;
           case "list-upgrades":
               $this->_listUpgrades($data);
               break;    
           case "install":
               $this->_install($data);
               stPearCache::removeCache();
               break; 
           case "upgrade":
               $this->_upgrade($data);
               stPearCache::removeCache();
               break;
           case "clear-cache":
               stPearCache::removeCache();
               break;
           default:                          
               $this->_default($data);
               break;
       }
    }   
    
     /** 
      * Show application list.
      *
      * @param     array
      * @return   STDOUT
      */
     private function _list($data)
     {
        if (! empty($data['data'])) {
            $list=array();     

            foreach ($data['data'] as $key=>$app)
            {                              
                $name=$app[0];
                $version=$app[1];               
                $list[$name]=$version;                               
            }
            // show template
            // include_once (ST_TMPL_PEAR.'pear_list.php');                         
            $this->printResult(serialize($list));            
        }        
     }      
     
     /** 
      * Show messages after installation.
      *
      * @param     array
      * @return   STDOUT
      */
     private function _install($data)
     {
         $this->printResult(serialize(array($data)));
     }
     
      /** 
       * Show list upgrades.
       *
       * @param     array
       */
      private function _listUpgrades($data)
      {          
         if (! empty($data['data'])) {
             $list=array();     

             foreach ($data['data'] as $key=>$app)
             {                              
                 $channel=$app[0];
                 $name=$app[1];               
                 $version=$app[3];
                 $size=$app[4];
                 $list[]=array('channel'=>$channel,'name'=>$name,'version'=>$version,'size'=>$size);                             
             }
             // wyswietl szablon  
             $this->printResult(serialize($list));
         }        
      }
            
      /** 
       * Show upgrade result. 
       *
       * @param     mixed
       * @return   STDOUT string
       */
      private function _upgrade($data)
      {                  
          $this->printResult($data['data']);                                      
      }
                 
     
      /** 
       * Show PEAR messages.
       *
       * @param        string      $data
       * @return   STDOUT
       */
      private function _default($data) 
      {   
          $this->printResult(serialize($data));
      }          
      
      /** 
       * Return printed data.
       *
       * @param        string      $data
       * @return   STDOUT
       */
      private function printResult($data)
      {
          print "<PEAR_RESULT>".$data."</PEAR_RESULT>";
      }
      
    /** 
     * Get data from $this->print()
     *
     * @param                 string      $data               PEAR_RESULT
     * @param                 string      $mode               unserialize|raw
     * @return  string      | serialized string | NULL
     */
    static public function getPearResult($data, $mode = 'unserialize') {
        $data = preg_replace('/<\/*PEAR_RESULT>/', '', $data);
        if (!empty($data)) {
            if ($mode == 'unserialize') {
                $arrayData = @unserialize($data);
                if (is_array($arrayData)) 
                    return $arrayData;
                else
                    return $data;
            }

            return $data;
        }
        return null;
    }
}       
