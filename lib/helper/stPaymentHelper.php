<?php
use_helper('stCurrency');
function st_payment_amount($payment)
{
	if ($payment->getVersion() == 2 && is_object($payment->getOrder())) $currency = $payment->getOrder()->getOrderCurrency(); 
	else $currency = stCurrency::getInstance(sfContext::getInstance())->getBackendMainCurrency();
	
	return $currency->getFrontSymbol().st_format_price($payment->getAmount()).' '.$currency->getBackSymbol();
}