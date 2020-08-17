<?php
class stPaypalFrontendComponents extends sfComponents
{
    public function executeShowPayment()
    {
       $order = stPaymentType::getOrderInSummary();

       $url = $this->getContext()->getController()->genUrl('@stPaypalSetExpressCheckout?order_id=' . $order->getId() . '&order_hash=' . $order->getHashCode());

       return $this->getContext()->getController()->redirect($url);
    }
}
