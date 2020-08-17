<?php

class stTrustedShopsBackendComponents extends autoStTrustedShopsBackendComponents {

	public function executePaymentMethods()
	{
		$this->paymentTypes = array();
		$this->paymentTypesSelected = array();

		$paymentTypes = PaymentTypePeer::doSelect(new Criteria());
		foreach($paymentTypes as $paymentType)
		{
			$this->paymentTypes[$paymentType->getId()] = $paymentType->getName();
				
			$c = new Criteria();
			$c->add(TrustedShopsHasPaymentTypePeer::TRUSTED_SHOPS_ID, $this->trusted_shops->getId());
			$c->add(TrustedShopsHasPaymentTypePeer::PAYMENT_TYPE_ID, $paymentType->getId());
			$trustedShopsPaymentType = TrustedShopsHasPaymentTypePeer::doSelectOne($c);
			if (is_object($trustedShopsPaymentType))
			{
				$this->paymentTypesSelected[$paymentType->getId()] = $trustedShopsPaymentType->getMethod();
			} else {
				$this->paymentTypesSelected[$paymentType->getId()] = '';
			}
				
		}

		$i18n = $this->getContext()->getI18n();

		$this->paymentMethods = array('DIRECT_DEBIT' => $i18n->__('polecenie zapłaty'),
                                      'CREDIT_CARD' => $i18n->__('karta kredytowa'),
                                      'INVOICE' => $i18n->__('faktura'),
                                      'CASH_ON_DELIVERY' => $i18n->__('gotówką przy dostawie'),
                                      'PREPAYMENT' => $i18n->__('przedpłata'),
                                      'CHEQUE' => $i18n->__('czek'),
                                      'PAYBOX' => $i18n->__('Paybox'),
                                      'PAYPAL' => $i18n->__('PayPal'),
                                      'AMAZON_PAYMENTS' => $i18n->__('Płatności Amazon'),
                                      'CASH_ON_PICKUP' => $i18n->__('gotówką przy odbiorze'),
                                      'FINANCING' => $i18n->__('finansowanie'),
                                      'LEASING' => $i18n->__('leasing'),
                                      'T_PAY' => $i18n->__('T-Pay'),
                                      'CLICKANDBUY' => $i18n->__('Click&Buy'),
                                      'GIROPAY' => $i18n->__('Giropay'),
                                      'GOOGLE_CHECKOUT' => $i18n->__('Google Checkout'),
                                      'SHOP_CARD' => $i18n->__('karta sklepu'),
                                      'DIRECT_E_BANKING' => $i18n->__('bezpośrednio przez e-banking'),
                                      'MONEYBOOKERS' => $i18n->__('moneybookers.com'),
                                      'DOTPAY' => $i18n->__('Dotpay'),
                                      'PLATNOSCI' => $i18n->__('Płatności.pl'),
                                      'PRZELEWY24' => $i18n->__('Przelewy24'),
                                      'OTHER' => $i18n->__('inne')
		);
	}
}