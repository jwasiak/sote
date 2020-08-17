<?php
/** 
 * SOTESHOP/stAuthUsers 
 * 
 * Ten plik należy do aplikacji stAuthUsers opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAuthUsers
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 251 2009-03-30 11:35:06Z marek $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stAuth', '/auth/users/:action/*', 'sfGuardUser', 'index', 'backend');
stPluginHelper::addRouting('stAuthGroups', '/auth/groups/:action/*', 'sfGuardGroup', 'index', 'backend');
stPluginHelper::addRouting('stAuthPermissions', '/auth/permission/:action/*', 'sfGuardPermission', 'index', 'backend');
stPluginHelper::addRouting('stAuthUsers', '/auth/users/:action/*', 'sfGuardUser', 'index', 'backend');
stPluginHelper::addRouting('sf_guard_signin', '/login', 'sfGuardAuth', 'signin', 'backend');
stPluginHelper::addRouting('sf_guard_signout', '/logout', 'sfGuardAuth', 'signout', 'backend');
stPluginHelper::addRouting('sf_guard_password', '/request_password', 'sfGuardAuth', 'password', 'backend');

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('sfGuardAuth', 'backend');
stPluginHelper::addEnableModule('sfGuardUser', 'backend');
stPluginHelper::addEnableModule('sfGuardGroup', 'backend');
stPluginHelper::addEnableModule('sfGuardPermission', 'backend');