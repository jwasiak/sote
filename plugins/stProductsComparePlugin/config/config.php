<?php
/** 
 * SOTESHOP/stProductComparePlugin 
 * 
 * Ten plik należy do aplikacji stProductComparePlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProductsComparePlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stProductsCompareFrontend', 'frontend');

/** 
 * Dodanie routingów
 */
stPluginHelper::addRouting('stProductsComparePlugin','/productsCompare/:action/*','stProductsCompareFrontend','index','frontend');