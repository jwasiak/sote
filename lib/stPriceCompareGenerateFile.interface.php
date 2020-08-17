<?php
/**
 * SOTESHOP/stPriceCompare
 *
 * Ten plik należy do aplikacji stPriceCompare opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPriceCompare
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPriceCompareGenerateFile.interface.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Interfejs stPriceCompareGenerateFile
 *
 * @package    stPriceCompare
 * @subpackage libs
 */
interface stPriceCompareGenerateFileInterface
{
    /**
     * Zapisywanie nagłówka pliku
     */
    public function init();

    /**
     * Zapisywanie zawartości pliku
     *
     * @param $step integer numer kroku
     * @return integer numer kolejnego kroku
     */
    public function generate($step);

    /**
     * Zapisywanie stopki pliku
     */
    public function close();

    /**
     * Pobieranie ilości kroków
     *
     * @return integer ilość kroków  
     */
    public function getStepsCount();

    /**
     * Pobieranie infromacji o porównywarce podczas eksportu
     *
     * @param $object object
     * @return integer
     */
    static public function getProduct($object = null);
    /**
     * Ustawianie infromacji o porównywarce podczas importu
     *
     * @param $object object
     * @param $value integer
     * @return boolean
     */
    static public function setProduct($object = null, $active = 0);
}