<?php
/** 
 * SOTESHOP/stMoneybookersPlugin 
 * 
 * Ten plik należy do aplikacji stMoneybookersPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stMoneybookersPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Dodanie informacji o istnieniu płatności
 */
stPluginHelper::addConfigValue('stPaymentType', 'stMoneybookersPlugin', array('name' => 'stMoneybookers', 'description' => 'Płatność przez serwis Skrill'));

/** 
 * Włączanie modułu
 */
stPluginHelper::addEnableModule('stMoneybookersBackend', 'backend');
stPluginHelper::addEnableModule('stMoneybookersFrontend', 'frontend');

/** 
 * Dodawania routingu
 */
stPluginHelper::addRouting('stMoneybookersPlugin', '/moneybookers', 'stMoneybookersBackend', 'index', 'backend');
stPluginHelper::addRouting('stMoneybookersPlugin', '/moneybookers/:action/*', 'stMoneybookersFrontend', 'config', 'frontend');