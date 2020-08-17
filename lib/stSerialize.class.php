<?php
/** 
 * SOTESHOP/stProduct 
 * 
 * Ten plik należy do aplikacji stProduct opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProduct
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stSerialize.class.php 617 2009-04-09 13:02:31Z michal $
 */

/** 
 * SOTESHOP/stProduct
 * Ten plik należy do aplikacji stProduct opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stProduct
 * @subpackage  libs
 */
class stSerialize
{
    /** 
     * Zmienna
     */
    var $content=array();
    
    /** 
     * Konstruktor klasy stSerialize
     *
     * @param        string      $folder
     */
    function __construct($file)
    {    
        $this->file=$file;
        if (file_exists($this->file)) $this->open();
    }
    
    /** 
     * Odczytuje plik
     *
     * @return   string
     */
    private function open()
    {
        $content=stFile::read($this->file);
        $this->content=unserialize($content);
    }
    
    /** 
     * Zapisuje plik
     *
     * @param        string      $content
     */
    public function save()
    {  
        if (! empty($this->content)) stFile::write($this->file, serialize($this->content));
    }
    
    /** 
     * Ustawia zmienna dla zapisu
     *
     * @param        string      $content
     */
    public function set($key, $val)
    {
        $this->content[$key]=$val;
    }
    
    /** 
     * Pobiera dane z pliku
     *
     * @return   string
     */
    public function get($key)
    {
        $this->open();
        if (! empty($this->content[$key])) return $this->content[$key];
        else return '';
    }
}












