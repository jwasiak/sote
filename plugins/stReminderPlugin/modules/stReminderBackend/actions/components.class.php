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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 11464 2011-03-07 12:22:24Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stReminderComponents
 *
 * @package     stReminderPlugin
 * @subpackage  actions
 */
class stReminderBackendComponents extends autoStReminderBackendComponents
{

	/**
	 * Wyświetlenie przypomnien w panelu sklepu
	 */
	public function executeShowReminds()
	{
		stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stReminderBackend.beforeReminderCount', array()));

		$this->alerts = BackendAlertPeer::doCountActive();

		if (!$this->alerts)
		{
			return sfView::NONE;
		}
	}

}