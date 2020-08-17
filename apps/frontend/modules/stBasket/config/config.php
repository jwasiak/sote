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
 * @version     $Id: config.php 17068 2012-02-09 13:16:30Z marcin $
 */

/** 
 * SOTESHOP/stBasket
 * Ten plik należy do aplikacji stBasket opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package stBasket
 * @subpackage libs
 */

stPluginHelper::addRouting('stBasket', '/basket/:action/*', 'stBasket', 'index', 'frontend');

stPluginHelper::addRouting('stBasketAdd', '/basket/add/:product_id/:quantity', 'stBasket', 'addReferer', 'frontend');

$dispatcher->connect('stActions.preExecute', array('stBasketListener', 'preExecuteAction'));

$dispatcher->connect('stActions.postExecute', array('stBasketListener', 'postExecuteAction'));

$dispatcher->connect('stUser.postValidateLoginUser', array('stBasketListener', 'refreshBasketProducts'));

$dispatcher->connect('stPartialCache.generateId', array('stBasketListener', 'stPartialCacheGenerateId'));
?>