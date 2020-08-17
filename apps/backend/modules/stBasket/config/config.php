<?php
/** 
 * SOTESHOP/stBasket 
 * 
 * Ten plik należy do aplikacji stBasket opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBasket
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 34 2009-08-24 14:00:47Z marcin $
 */

stPluginHelper::addRouting('stBasket', '/basket/:action/*', 'stBasket', 'list', 'backend');
stPluginHelper::addRouting('stBasketDefault', '/basket', 'stBasket', 'list', 'backend');
$dispatcher = stEventDispatcher::getInstance();
$dispatcher->connect('stAdminGenerator.generateStProduct', array('stBasketListener', 'generateStProduct'));
?>