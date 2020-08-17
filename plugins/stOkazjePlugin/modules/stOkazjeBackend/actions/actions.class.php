<?php
/**
 * SOTESHOP/stOkazjePlugin
 *
 * Ten plik należy do aplikacji stOkazjePlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stOkazjePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 12554 2011-04-27 08:30:56Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stOkazjeBackendActions
 *
 * @package     stOkazjePlugin
 * @subpackage  actions
 */
class stOkazjeBackendActions extends autostOkazjeBackendActions
{
	/**
	 * Przeciążenie aktualizacji config'a
	 */
	protected function updateConfigFromRequest()
	{
		$config = $this->getRequestParameter('config');
		$this->config->set('use_product_code', isset($config['use_product_code']) ?  $config['use_product_code'] : null);

		foreach (stOkazje::getAvailabilities() as $availability)
		{
			$this->config->set('availability_'.$availability->getId(), $config['availability_'.$availability->getId()]);
		}
	}
}