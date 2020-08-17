<?php

class stSantanderFrontendComponents extends sfComponents
{
    public function executeShowPayment()
    {
        $smarty = new stSmarty('stSantanderFrontend');

        $order = stPaymentType::getOrderInSummary();

        $smarty->assign('order', $order);
        $smarty->assign('order_total_amount', $order->getTotalAmountWithDelivery(true, true));
        $smarty->assign('order_total_quantity', $order->getTotalQuantity()+1);
        $smarty->assign('shop_number', stConfig::getInstance('stSantanderBackend')->get('shop_number'));
        $smarty->assign('order_delivery', $order->getOrderDelivery()->getName());
        $smarty->assign('client', array(
            'name' => $order->getOrderUserDataBilling()->getName(),
            'surname' => $order->getOrderUserDataBilling()->getSurname(),
            'email' => $order->getOptClientEmail(),
        ));
        $smarty->assign('url_accepted', $this->getController()->genUrl('@stSantanderFrontend?action=accepted', true).'?id=');
        $smarty->assign('url_canceled', $this->getController()->genUrl('@stSantanderFrontend?action=canceled', true).'?id=');
        
        return $smarty;
    }

    public function executeCalculate()
    {
        $config = stConfig::getInstance(sfContext::getInstance(), 'stSantanderBackend');
        if ($this->amount < 100 || !$config->get('shop_number')){
            return sfView::NONE;
        }

        $smarty = new stSmarty('stSantanderFrontend');

        $smarty->assign('url', stSantander::getCalculateRateUrl($this->amount));
        $smarty->assign('is_ajax', isset($this->is_ajax) ? $this->is_ajax: false);
        $smarty->assign('small', isset($this->small) ? $this->small: false);

        return $smarty;
    }

    public function executeCalculateInBasket()
    {
        sfLoader::loadHelpers(array('Helper', 'stPartial'));
        echo st_get_component('stSantanderFrontend', 'calculate', array('amount' => $this->getUser()->getBasket()->getTotalAmount(true, true), 'small' => true));

        return sfView::NONE;
    }
}