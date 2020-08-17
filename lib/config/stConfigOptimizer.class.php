<?php
/** 
 * SOTESHOP/stBase
 * 
 * Ten plik należy do aplikacji stBase opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBase
 * @subpackage  lib
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stConfigOptimizer.class.php 7 2009-08-24 08:59:30Z michal $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */                
                 
define ('ST_CONFIG_DAT_FILE',sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'__config.dat');

/**
 * Optymalizacja konfiguracji danych z bazy danych.
 * @package stBase
 */               
class stConfigOptimizer
{                                                               
    /**
     * Plik bazy danych.
     */                 
    var $file;
     
    /**
     * Dane 
     */     
    var $data=array(); 
    
    /** 
     * Instalcja klasy. Singleton.
     * @var object
     */
    protected static $instance = null;
    
    /** 
     * Singleton.
     *
     * @return  object      instancja klasy
     */
     public static function getInstance()
     {      
         if (! isset(self::$instance))
         {
             $class = __CLASS__;
             self::$instance = new $class();
         }
         return self::$instance;
     }                                         
     
     /**
      * Konstruktor
      */                       
     public function __construct()
     {            
         $this->file=ST_CONFIG_DAT_FILE;
     }
         
    /**
     * Odczytuje zmienną z kofniguracji.
     *          
     * @param string $nazwa zmiennej
     * @return mixed wartość zmiennej $nazwa
     */
    public function get($name)
    {   
        if (empty($this->data)) $this->_read();      
        return $this->data[$name];
    }                
                                        
    /**
     * Zapisuje zmienną w konfiguracji.
     *
     * @param string $name  nazwa zmiennej
     * @param mixed  $value wartość 
     */
    public function set($name, $value)
    {   
        if (empty($this->data)) $this->_read();
        $this->data[$name]=$value;
        $this->_save();
    }                
        
    /**
     * Zwaraca informacje czy zmienna jest zapisana.
     *
     * @param string $name
     * @return bool
     */
    public function is($name)
    {
        if (empty($this->data)) $this->_read();
        if (isset($this->data[$name])) return true;
        else return false;
    }     
    
    /**
     * Alias do funkcji `is`.
     *
     * @author Michal Prochowski <michal.prochowski@sote.pl>
     *
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return $this->is($name);
    }     
        
    private function _read()
    {           
        if (! file_exists($this->file)) { $this->data=array(); return; }
        $this->data=unserialize(file_get_contents($this->file));           
    }   
    
    private function _save()
    {                                        
        file_put_contents($this->file,serialize($this->data)); 
    }
    
}

