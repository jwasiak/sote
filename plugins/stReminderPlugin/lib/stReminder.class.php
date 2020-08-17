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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stReminder.class.php 11464 2011-03-07 12:22:24Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stReminder
 *
 * @package     stReminderPlugin
 * @subpackage  libs
 */
class stReminder
{
	protected static $list = array();

	/**
	 * Dodanie przypomnienia
	 *
	 * @param $module string nazwa modułu
	 * @param $message string wiadmość przypomniania
	 */
	public static function add($module, $message, $type = 'notify')
	{
		if ($module == 'stPositioningBackend')
		{
			$type = 'warning';
		}

		self::$list[$module] = array('message' => $message, 'type' => $type);

		$alert = BackendAlertPeer::retrieveByCode($module);
		if (!is_object($alert))
		{
			 $alert = new BackendAlert();
			 $alert->setCulture(stLanguage::getOptLanguage());
			 $alert->setCode($module);
			 $alert->setName($message);
			 $alert->setDisplay(0);
			 $alert->save();
		}
	}

	public static function getCodes()
	{
		return array_keys(self::$list);
	}

}