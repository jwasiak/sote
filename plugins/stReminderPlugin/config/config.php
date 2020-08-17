<?php
/** 
 * SOTESHOP/stReminderPlugin 
 * 
 * Ten plik należy do aplikacji stReminderPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stReminderPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stReminderBackend', 'backend');
stPluginHelper::addEnableModule('stReminderGadget', 'backend');

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stReminderPlugin', '/remind/:action/*','stRemindBackend', null, 'backend');
stPluginHelper::addRouting('stReminderPluginDefault', '/remind', 'stRemindBackend', 'index', 'backend');
stPluginHelper::addRouting('stReminderGadget', '/reminder_news/:action','stReminderGadget', 'index', 'backend');


