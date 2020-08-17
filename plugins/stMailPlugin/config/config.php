<?php
/** 
 * SOTESHOP/stMailPlugin 
 * 
 * Ten plik należy do aplikacji stMailPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stMailPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 12185 2011-04-13 11:31:16Z marcin $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stMailAccountBackend', 'backend');
stPluginHelper::addEnableModule('stMailSmtpProfileBackend', 'backend');

/** 
 * Dodanie routingu
 */
stPluginHelper::addRouting('stMailPlugin','/mail_account/:action/*','stMailAccountBackend', null,'backend');
stPluginHelper::addRouting('stMailPluginDefault','/mail_account/list','stMailAccountBackend','list','backend');



if (SF_APP == 'backend')
{
   $dispatcher->connect('stActions.postExecute', array('stMailListener', 'reminder'));
}