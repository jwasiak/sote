<?php
/**
 * SOTESHOP/stLukasPlugin
 *
 * Ten plik należy do aplikacji stLukasPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLukasPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stLukasFrontendActions
 *
 * @package     stLukasPlugin
 * @subpackage  actions
 */
class stLukasFrontendActions extends stActions
{
	/**
	 * Składanie eWniosku
	 */
	public function executeEwniosek()
	{
		$this->setLayout(false);
		
		$stLukas = new stLukas();
		$context = $this->getContext();
		$this->url = '';

		/**
		 * Hack na zmianę języka
		 */
		stLanguage::getInstance($context)->clearPath();
		
		if ($this->getRequest()->hasParameter('type'))
		{
			$type = $this->getRequest()->getParameter('type');

			if ($type == stLukas::TYPE_ORDER)
			{
				$c = new Criteria();
				$c->add(OrderPeer::ID, $this->getRequest()->getParameter('id'));
				$order = OrderPeer::doSelectOne($c);

				$stWebRequest = new stWebRequest();
				$wsdlFilename = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'lukas_bank.wsdl';

				if (!file_exists($wsdlFilename) || (time() - filemtime($wsdlFilename)) > 864000)
				{
					$b = new sfWebBrowser(array(), 'sfCurlAdapter', array('ssl_verify' => false));
					$b->get(stLukas::LUKAS_WSDL_URL);
					$wsdl = trim($b->getResponseText());

					file_put_contents($wsdlFilename, $wsdl);
				}

				$client = new SoapClient(sfConfig::get('sf_web_dir').'/cache/lukas_bank.wsdl', array('cache_wsdl' => 0, 'trace'=>1));

				$xml = '<?xml version="1.0" encoding="UTF-8"?>';
				$xml.= '<form>';
					
				$xml.= '<block id="creditInfo">';
				$xml.= '<element importAs="creditInfo.creditAmount.value">'.($order->getUnpaidAmount()).'</element>';
				$xml.= '</block>';

				$xml.= '<block id="cart">';
				$xml.= '<element importAs="cart.shopName.value">'.$stLukas->getShopName().'</element>';
				$xml.= '<element importAs="cart.orderNumber.value">'.$order->getNumber().'</element>';

				$c = new Criteria();
				$c->add(OrderProductPeer::ORDER_ID, $order->getId());
				$products = OrderProductPeer::doSelect($c);

				$i = 1;
				foreach($products as $product)
				{
					$xml.= '<element importAs="cart.itemName'.$i.'.value">'.$product->getName().'</element>';
					$xml.= '<element importAs="cart.itemQty'.$i.'.value">'.$product->getQuantity().'</element>';
					$xml.= '<element importAs="cart.itemPrice'.$i.'.value">'.$product->getPriceBrutto().'</element>';
					$i++;
				}

                if($order->getOrderDelivery()->getCostBrutto()!=0){
    				$xml.= '<element importAs="cart.itemName'.$i.'.value">'.$context->getI18n()->__('Dostawa:').' '.$order->getOrderDelivery()->getName().'</element>';
    				$xml.= '<element importAs="cart.itemQty'.$i.'.value">1</element>';
    				$xml.= '<element importAs="cart.itemPrice'.$i.'.value">'.$order->getOrderDelivery()->getCostBrutto().'</element>';
				}
                
				$xml.= '</block>';

				$xml.= '<block id="email">';
				$xml.= '<element importAs="email.address.value">'.$order->getGuardUser()->getUsername().'</element>';
				$xml.= '</block>';

				$xml.= '</form>';

				try {
					$paramSetup = $client->put($xml);
				} catch (Exception $e) { }

				$this->url = $stLukas->generateUrl(array('simulate' => true, 'param_setup' => $paramSetup));

			} elseif ($type == stLukas::TYPE_PRODUCT) {
				$this->url = $stLukas->generateUrl(array('simulate' => true, 'amount' => $this->getRequest()->getParameter('price')));
			}
		} else {
			if ($this->hasFlash('lukas_procedure') && $this->getFlash('lukas_procedure') == true)
			{
                $this->url = $stLukas->generateUrl(array('procedure' => true));
			} else {
				$basket = stBasket::getInstance($context->getUser());
				$delivery = stDeliveryFrontend::getInstance($basket);

				$this->url = $stLukas->generateUrl(array('simulate' => true, 'amount' => ($basket->getTotalAmount(true)+$delivery->getTotalDeliveryCost(true))));
			}
		}
	}

	/**
	 * Procedura składania wniosku
	 */
	public function executeProcedure()
	{
		$this->setFlash('lukas_procedure', true);
		$this->redirect('lukas/ewniosek');
	}

	/**
	 * Pozytywny powrót z płatności
	 */
	public function executeReturnSuccess()
	{
		$this->smarty = new stSmarty($this->getModuleName());
	}

	/**
	 * Negatywny powrót z płatności
	 */
	public function executeReturnFail()
	{
		$this->smarty = new stSmarty($this->getModuleName());
		$this->contactPage = WebpagePeer::retrieveByState('CONTACT');
	}
}