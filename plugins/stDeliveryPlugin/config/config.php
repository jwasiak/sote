<?php
/** 
 * SOTESHOP/stDelivery 
 * 
 * Ten plik należy do aplikacji stDelivery opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stDelivery
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 15816 2011-10-27 11:08:53Z marcin $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stDeliveryFrontend', 'frontend');
stPluginHelper::addEnableModule('stDeliveryBackend', 'backend');

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stDelivery', '/delivery/:action/*', 'stDeliveryBackend', 'index', 'backend');

stSocketView::addComponent('stDeliveryBackend.configCustom.Content','stDeliveryBackend','configContent');

stConfiguration::addModule(array('label' => 'Dostawy', 'route' => '@stDelivery?action=config', 'icon' => 'stDelivery', 'name' => 'stDeliveryBackend'), 'Konfiguracja modułów');