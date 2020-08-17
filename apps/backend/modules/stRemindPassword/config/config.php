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
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stRemindPassword', 'backend');

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stRemindPassword', '/remindPassword/:action/*', 'stRemindPassword', 'remindPassword', 'backend');
stPluginHelper::addRouting('stChangePassForAdmin', '/remindPassword/createNewPassword/:hash_code', 'stRemindPassword', 'createNewPassword', 'backend', array('confirm' => true));