<?php
/** 
 * SOTESHOP/stWholesalePlugin
 *
 * Ten plik należy do aplikacji stPositioningPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stWholesalePlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 1100 2009-05-11 11:42:40Z krzysiek $
 */

/** 
 * Konfiguracja modułu stWholesalePlugin
 *
 * @package stWholesalePlugin
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

stPluginHelper::addEnableModule('stWholesaleBackend', 'backend');

/** 
 * pobiera instancję obiektu sfEventDispatcher
 */
$dispatcher = stEventDispatcher::getInstance();

/** 
 * dodaje sluchacza dla zdarzenia generator.generate
 */
$dispatcher->connect('stAdminGenerator.generateStProduct', array('stWholesalePluginListener', 'generateStProduct'));

$dispatcher->connect('stAdminGenerator.generateStUser', array('stWholesalePluginListener', 'generateStUser'));


if (SF_APP == 'frontend')
{
    $dispatcher->connect('Product.postHydrate', array('stWholesalePluginListener', 'productPostHydrate'));

    $dispatcher->connect('Product.getWholesaleByType', array('stWholesalePluginListener', 'getWholesaleByType'));
}
elseif (SF_APP == 'backend')
{
   $dispatcher->connect('autoStProductActions.postUpdateFromRequest', array('stWholesalePluginListener', 'postUpdateFromRequestProduct'));
}

$dispatcher->connect('Product.preSave', array('stWholesalePluginListener', 'preSaveProduct'));

$dispatcher->connect('AddPrice.preSave', array('stWholesalePluginListener', 'preSaveAddPrice'));

$dispatcher->connect('Currency.preSave', array('stWholesalePluginListener', 'preSaveCurrency'));


?>