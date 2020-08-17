<?php
/**
 * SOTESHOP/stCeneoPlugin
 *
 * Ten plik należy do aplikacji stCeneoPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stCeneoPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 15167 2011-09-20 11:20:33Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stCeneoFrontnedComponents
 *
 * @package     stCeneoPlugin
 * @subpackage  actions
 */
class stCeneoFrontendComponents extends sfComponents
{
	/**
	 * Wyświetlanie zaufanych opini
	 */
	public function executeTrustedOpinion()
	{
		$this->smarty = new stSmarty('stCeneoFrontend');

		$this->hasTrustedOpinion = false;

		$config = stConfig::getInstance(sfContext::getInstance(), 'stCeneoBackend');
		$this->trustedOpinionId = $config->get('trusted_opinion_id');
		$this->showTransactionSystem = $config->get('transaction_system_on');
		$this->trustedOpinionNewType = true;

		if (strlen($this->trustedOpinionId) < 15) $this->trustedOpinionNewType = false;

		if ($config->get('trusted_opinion_on') == 1 && !empty($this->trustedOpinionId))
		{
			if ($this->getRequest()->hasParameter('id') && $this->getRequest()->hasParameter('hash_code'))
			{
				$id = $this->getRequestParameter('id');
				$hashCode = $this->getRequestParameter('hash_code');
				$order = OrderPeer::retrieveByIdAndHashCode($id, $hashCode);

				$this->email = $order->getGuardUser()->getUsername();
				
				if (!$order->getShowOpinion())
					$this->email = 'test@ceneo.pl';

				$this->orderId = $order->getNumber();
				$this->orderAmount = number_format($order->getTotalAmount(true), 2, '.', '');

				$c = new Criteria();
				$c->add(OrderProductPeer::ORDER_ID, $order->getId());
				$products = OrderProductPeer::doSelect($c);

				$this->productIds = '';
				foreach ($products as $product)
				{
					for ($i = 1; $i<= $product->getQuantity(); $i++)
					{
						$this->productIds.= '#'.$product->getProductId();
					}
				}

				$this->hasTrustedOpinion = true;
			}
		}
		stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stCeneoPlugin.postTrustedOpinionNotify', array()));
		if ($this->hasTrustedOpinion == false) return sfView::NONE;
	}
}