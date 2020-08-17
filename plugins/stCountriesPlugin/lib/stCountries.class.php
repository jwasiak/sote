<?php
/** 
 * SOTESHOP/stCountriesPlugin 
 * 
 * Ten plik należy do aplikacji stCountriesPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stCountriesPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stCountries.class.php 5356 2010-05-31 11:07:06Z michal $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/** 
 * Klasa do obsługi krajów.
 *
 * @package     stCountriesPlugin
 * @subpackage  libs
 */
class stCountries
{
    /** 
     * Przestrzeń nazw
     */
    const SESSION_NAMESPACE = 'soteshop/countries';

    /** 
     * Instanacja obiektu stCountries
     * @var stCountries object
     */
    protected static $instance = null;
    
    /** 
     * Zmienna całej klasy
     * @var int
     */
    private $countries = null;

    /** 
     * Przelicznik instancji
     * @var int
     */
    private $counter = 1;
    
    /** 
     * Inicjalizacja countries
     *
     * @param   string      $context            instancja obiektu sfContext::getInstance()
     */
    private  $context;
    
    /** 
     * Incjalizacja klasy stCountries
     *
     * @param        string      $context
     */
    public function initialize($context)
    {
        $this->context = $context;
        $this->countries = $context->getUser()->getAttribute('countries', null, self::SESSION_NAMESPACE);
    }
    
    /** 
     * Zwraca instancje obiektu
     *
     * @param        string      $context
     * @return   stCountries
     */
    public static function getInstance($context)
    {
        if (!isset(self::$instance))
        {
            $class = __CLASS__;
            self::$instance = new $class();
            self::$instance->initialize($context);
        }
        return self::$instance;
    }
    
    /** 
     * Zapisuje ID countries dla uzytkownika
     *
     * @param   idCountries $id
     */
    public function set($id)
    {
        $this->context->getUser()->setAttribute('countries', $id);
    }
}