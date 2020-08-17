<?php
/** 
 * SOTESHOP/stCurrencyPlugin
 *
 * Ten plik należy do aplikacji stCurrencyPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stCurrencyPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 13226 2011-05-30 14:29:24Z marcin $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stCurrencyFrontend', 'frontend');
stPluginHelper::addEnableModule('stCurrencyBackend', 'backend');

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stCurrencyPlugin', '/currency/:action/*', 'stCurrencyBackend', 'index', 'backend');
stPluginHelper::addRouting('stCurrencyFrontend', '/currency/:action/*', 'stCurrencyFrontend', 'index', 'frontend');
