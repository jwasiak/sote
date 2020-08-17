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
 * @version     $Id: stUniqueProduct.class.php 617 2009-04-09 13:02:31Z michal $
 */

/** 
 * Klasa stUniqueProduct
 *
 * @package     stProduct
 * @subpackage  libs
 */
class stUniqueProduct
{
    /** 
     * Instanacja obiektu stUniqueProduct
     * @var stUniqueProduct
     */
    protected static $instance = null;

    /** 
     * Instancja obiektu sfContext::getInstance()
     * @var sfContext
     */
    private $context;

    /** 
     * Tablica z listą produktów
     * @var array
     */
    private $productList = array();

    /** 
     * Incjalizacja klasy stUniqueProduct
     */
    public function initialize()
    {
        $this->context = sfContext::getInstance();
    }

    /** 
     * Zwraca instancje obiektu
     *
     * @return       string      $instance
     */
    public static function getInstance()
    {
        if ( ! isset(self::$instance))
        {
            $class = __CLASS__;
            self::$instance = new $class();
            self::$instance->initialize();
        }
        return self::$instance;
    }

    /** 
     * Dodawanie produktów
     *
     * @param         mixed       $product
     */
    public function addProducts($product)
    {
        foreach (func_get_args() as $value)
        {
            if (is_array($value))
            {
                foreach ($value as $product) {
                    $this->addProduct($product->getId());
                }
            }

            if (is_object($value))
            {
                $this->addProduct($value->getId());
            }
            
            if (is_int($value))
            {
                $this->addProduct($value);
            }
        }
    }

    /** 
     * Dodawanie produktu dostępne jedynie dla klasy stUniqueProduct
     *
     * @param        object      $product
     */
    private function addProduct($productId)
    {
        if (!$this->productList)
        {
            $this->productList[0] = 0;
        }
        $this->productList[$productId] = $productId;
    }

    /** 
     * Pobieranie zmienionych kryteriów wyszukiwania produktów.
     *
     * @param      Criteria    $c
     */
    public function getCriteria(Criteria $c)
    {
        $c->add(ProductPeer::ID, $this->productList, Criteria::NOT_IN);
    }
}












