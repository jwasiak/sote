<?php
/** 
 * SOTESHOP/stBoxPlugin 
 * 
 * Ten plik należy do aplikacji stBoxPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBoxPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id$
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stBoxBackend', 'backend');
stPluginHelper::addEnableModule('stBoxGroupBackend', 'backend');
stPluginHelper::addEnableModule('stBoxFrontend', 'frontend');

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stBoxPlugin', '/box/:action/*', 'stBoxBackend', 'list', 'backend');
stPluginHelper::addRouting('stBoxGroupBackend', '/box_group/:action/*', 'stBoxGroupBackend', 'list', 'backend');
stPluginHelper::addRouting('webpage_group', '/box_group/:action/*', 'stBoxGroupBackend', 'list', 'backend');
