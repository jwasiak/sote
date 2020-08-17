<?php
/**
 * SOTESHOP/sstBackendAlertPlugin
 *
 * Ten plik należy do aplikacji stLanguagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBackendAlertPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 11171 2011-02-21 13:07:13Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stBackendAlertActions
 *
 * @package     stLanguagePlugin
 * @subpackage  actions
 */
class stReminderBackendActions extends autoStReminderBackendActions
{
	public function executeList()
	{
		stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stReminderBackend.beforeReminderCount', array()));
		parent::executeList();	
	}
}