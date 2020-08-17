<?php
/**
 * SOTESHOP/stPriceCompare
 *
 * Ten plik należy do aplikacji stPriceCompare opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPriceCompare
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id:  $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPriceCompareFilter
 *
 * @package     stPriceCompare
 * @subpackage  libs
 */
class stPriceCompareFilter extends sfFilter
{
	/**
	 * Wykonywanie filtra
	 *
	 * @param $filterChain
	 */
	public function execute($filterChain)
	{
		$context = $this->getContext();
		$r = $context->getRequest();

		if ($this->isFirstCall())
		{
			if ($r->hasParameter('pc_module_type'))
			{
				$context->getUser()->setAttribute('name', $r->getParameter('pc_module_type'), stPriceCompare::SESSION_NAMESPACE);
			}
		}

		$filterChain->execute();
	}
}