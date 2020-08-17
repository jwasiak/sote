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
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 13375 2011-06-02 08:19:22Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Dodawanie routingow
 */
stPluginHelper::addRouting('stPriceCompare','/price_compare/:action/*','stPriceCompare',null,'backend');
stPluginHelper::addRouting('stPriceCompareDefault','/price_compare','stPriceCompare','index','backend');

/** 
 * Dodanie do menu stPriceComare modułu stPriceCompare i dodanie do menu porównywarek cen linków aplikacji
 */
stPriceCompare::addToMenu('stPriceCompare');
stPriceCompare::generatePriceComparesMenu();

/** 
 * Przeciazanie generatora produktu
 */
$dispatcher = stEventDispatcher::getInstance();
$dispatcher->connect('stAdminGenerator.generateStProduct', array('stPriceCompareListener', 'generate')); 

/** 
 * Przeciazanie generatora porownywarek
 */
$dispatcher->connect('stAdminGenerator.generateStCeneoBackend', array('stPriceCompareListener', 'generateStCeneoBackend'));
$dispatcher->connect('stAdminGenerator.generateStNokautBackend', array('stPriceCompareListener', 'generateStNokautBackend'));
$dispatcher->connect('stAdminGenerator.generateStOkazjeBackend', array('stPriceCompareListener', 'generateStOkazjeBackend'));
$dispatcher->connect('stAdminGenerator.generateStRadarBackend', array('stPriceCompareListener', 'generateStRadarBackend'));
$dispatcher->connect('stAdminGenerator.generateStSklepy24Backend', array('stPriceCompareListener', 'generateStSklepy24Backend'));

/** 
 * Dodawanie komponentu
 */
stSocketView::addComponent('stProduct.priceCompareCustom.Content','stPriceCompare','priceComparesInProduct',array());