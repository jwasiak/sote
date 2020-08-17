<?php
/**
 * SOTESHOP/stNokautPlugin
 *
 * Ten plik należy do aplikacji stNokautPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stNokautPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 5661 2010-06-21 12:04:42Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stNokautBackendActions
 *
 * @package     stNokautPlugin
 * @subpackage  actions
 */
class stNokautBackendActions extends autostNokautBackendActions
{
	/**
	 * Przeciążenie aktualizacji config'a
	 */
	protected function updateConfigFromRequest()
	{
		$config = $this->getRequestParameter('config');
		$this->config->set('use_product_code', isset($config['use_product_code']) ?  $config['use_product_code'] : null);

		foreach (stNokaut::getAvailabilities() as $availability)
		{
			$this->config->set('availability_'.$availability->getId(), $config['availability_'.$availability->getId()]);
		}
	}
}