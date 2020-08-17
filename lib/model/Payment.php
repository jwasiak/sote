<?php

/**
 * SOTESHOP/stPayment
 *
 * Ten plik należy do aplikacji stPayment opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPayment
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: Payment.php 15219 2011-09-23 11:29:27Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa Payment
 *
 * @package     stPayment
 * @subpackage  libs
 */
class Payment extends BasePayment
{
	protected $isValid = null;
	protected $order = null;

	/**
	 * Pobieranie id zamówienia
	 *
	 * @return int
	 */
	public function getOrderId()
	{
		return $this->getOrder() ? $this->getOrder()->getId() : null;
	}

	/**
	 * Pobieranie numeru zamówienia
	 *
	 * @return string
	 */
	public function getOrderNumber()
	{
		return $this->getOrder() ? $this->getOrder()->getNumber() : null;
	}

	public function getOrder()
	{
		if (!$this->order)
		{
			$c = new Criteria();

			$c->addJoin(OrderPeer::ID, OrderHasPaymentPeer::ORDER_ID);

			$c->add(OrderHasPaymentPeer::PAYMENT_ID, $this->getId());

			$this->order = OrderPeer::doSelectOne($c);
		}

		return $this->order;
	}

	public function getTransactionId()
	{
		$transactionId = parent::getTransactionId();

		if (null === $transactionId && null === $this->getGiftCardId())
		{
			$paymentType = $this->getPaymentType();
			$module = $paymentType->getModuleName();

			if ($paymentType && class_exists($module) && method_exists($module, 'getServiceTransactionId'))
			{
				$transactionId = call_user_func(array($module, 'getServiceTransactionId'), $this);
			}
		}

		return $transactionId;
	}

	/**
	 * @author Marcin Butlak <marcin.butlak@sote.pl>
	 */
	public function save($con = null)
	{
		$isNew = $this->isNew();

		$isValid = $this->isValid();
		 
		if ($isNew)
		{
			if (null === $this->getHash())
			{
				$hash = md5(serialize($this) . microtime(true));

				$this->setHash($hash);
			}
			 
			$this->setVersion(2);
		}

		$statusModified = $this->isColumnModified(PaymentPeer::STATUS);

		if ($statusModified && $this->getStatus() && !$this->getPayedAt())
		{
			$this->setPayedAt(time());
		}

		if ($this->isValid())
		{ 
			$this->setPaymentSecurityHash($this->generatePaymentSecurityHash());
		}
		

		$ret = parent::save($con);

		if ($statusModified)
		{
			if ($this->getOrder())
			{
				OrderPeer::updateOptIsPaid($this->getOrder());
			} 
		}

		return $ret;
	}
	 
	public function delete($con = null)
	{
		$order = $this->getOrder();

		$result = parent::delete($con);

		if ($order) 
		{
			OrderPeer::updateOptIsPaid($order);
		} 
	}

	public function isValid()
	{
		if (strtotime(stConfig::getInstance('stOrder')->get('payment_verification_check')) >= strtotime($this->getCreatedAt()))
		{
			return true;
		}

		if (null === $this->isValid)
		{
			$this->isValid = $this->isNew() || $this->getPaymentSecurityHash() == $this->generatePaymentSecurityHash();
		}

		return $this->isValid;
	}

	protected function generatePaymentSecurityHash()
	{
		return stSecureToken::generate(array(
			intval($this->getStatus()),
			$this->getPayedAt(),
			$this->getHash(),
		));
	}

	public function setStatus($v)
	{
		$this->isValid();
		return parent::setStatus($v);
	}

	public function getConfigurationParameter($name, $default = null)
    {
        $configuration = $this->getConfiguration();

        return isset($configuration[$name]) ? $configuration[$name] : $default;
    }

    public function setConfigurationParameter($name, $value)
    {
        $configuration = $this->getConfiguration();

        if (!$configuration)
        {
            $configuration = array();
        }

        $configuration[$name] = $value;

        $this->setConfiguration($configuration);
    }
}