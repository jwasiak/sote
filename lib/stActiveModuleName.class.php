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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stActiveModuleName.class.php 3454 2010-02-11 10:07:38Z marcin $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stActiveModuleName
 *
 * @deprecated  since 5.0.7
 * @package     stBase
 * @subpackage  libs
 */
class stActiveModuleName
{
    /** 
     * Instanacja obiektu stActiveModuleName
     * @var stActiveModuleName object
     */
    protected static $instance = null;

    /** 
     * stActiveModuleName
     * @var stActiveModuleName object
     */
    private $activeModuleName = null;

    /** 
     * Nazwa modułu
     * @var string
     */
    protected $moduleName = '';
    
    /** 
     * Incjalizacja klasy stActiveModuleName
     *
     * @param        string      $context
     */
    public function initialize($context)
    {
        $this->context = $context;

    }

    /** 
     * Zwraca instancje obiektu
     *
     * @param        string      $context
     * @return   stActiveModuleName
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
     * Pobieranie nazwy modułu
     *
     * @return   string
     */
    public function get()
    {
        return $this->moduleName;
    }
    
    /** 
     * Ustawianie nazwy modułu
     *
     * @param        string      $moduleName
     */
    public function set($moduleName)
    {
        /**
         * compatibility hack
         * @author Marcin Butlak <marcin.butlak@sote.pl>
         */
        if (empty($moduleName))
        {
            sfContext::getInstance()->getI18N()->setCurrentCatalogue('dummy');
        }

        $this->moduleName = $moduleName;
    }
}