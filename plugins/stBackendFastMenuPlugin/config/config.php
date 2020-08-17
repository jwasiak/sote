<?php
/** 
 * SOTESHOP/stBackendFastMenuPlugin 
 * 
 * Ten plik należy do aplikacji stBackendFastMenuPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBackendFastMenuPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id$
 * @author      Bartosz Alejski <bartek.alejski@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stBackendFastMenu', 'backend');

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stBackendFastMenuPlugin', '/stBackendFastMenu/:action/*', 'stBackendFastMenuPlugin', 'index', 'backend');