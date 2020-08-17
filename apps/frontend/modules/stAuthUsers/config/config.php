<?php
/** 
 * SOTESHOP/stThemePlugin 
 * 
 * Ten plik należy do aplikacji stThemePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stThemePlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 256 2009-03-30 11:49:45Z marek $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stAuth', '/auth/users/:action/*', 'sfGuardUser', 'index', 'frontend');
stPluginHelper::addRouting('sf_guard_signin', '/login', 'sfGuardAuth', 'signin', 'frontend');
stPluginHelper::addRouting('sf_guard_signout', '/logout', 'sfGuardAuth', 'signout', 'frontend');
stPluginHelper::addRouting('sf_guard_password', '/request_password', 'sfGuardAuth', 'password', 'frontend');

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('sfGuardAuth', 'frontend');