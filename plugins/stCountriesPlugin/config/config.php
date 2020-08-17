<?php
/** 
 * SOTESHOP/stCountriesPlugin 
 * 
 * Ten plik należy do aplikacji stCountriesPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stCountriesPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 4 2009-08-24 08:52:56Z marcin $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stCountriesFrontend', 'frontend');
stPluginHelper::addEnableModule('stCountriesBackend', 'backend');

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stCountriesPlugin', '/countries/:action/*', 'stCountriesBackend', 'list', 'backend');
stPluginHelper::addRouting('stCountriesPluginDefault', '/countries', 'stCountriesBackend', 'list', 'backend');