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
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stBackendFastMenuHelper.php 3170 2008-12-11 12:04:27Z michal $
 * @author      Bartosz Alejsi <bartosz.alejski@sote.pl>
 */

/** 
 * Ładujemy klase stBackendFastMenu
 *
 * @package     stBackendFastMenuPlugin
 * @subpackage  helpers
 */
include_once(sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stBackendFastMenuPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stBackendFastMenu.class.php');

/** 
 * Dodanie zapisania informacji o aplikacji
 */
stBackendFastMenu::addToTask();