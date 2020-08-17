<?php

class stPocztaPolskaFrontendComponents extends sfComponents
{
    public function executeChooseDeliveryPoint()
    {        
        if ($this->delivery->getTypeId() != DeliveryTypePeer::retrieveIdByType('ppo') || !stConfig::getInstance('stPocztaPolskaBackend')->get('enabled')) 
        {
            return sfView::NONE;
        }

        $smarty = new stSmarty('stPocztaPolskaFrontend');
        $points = $this->getUser()->getAttribute('delivery_point', array(), 'soteshop/stPocztaPolskaPlugin');

        $config = stConfig::getInstance('stPocztaPolskaBackend');

        $smarty->assign('point', $points && isset($points[$this->delivery->getId()]) ? $points[$this->delivery->getId()] : array());
        $smarty->assign('id', $this->delivery->getId());

        return $smarty;
    }

    public function executeHelper()
    {
        $smarty = new stSmarty('stPocztaPolskaFrontend');
        $config = stConfig::getInstance('stPocztaPolskaBackend');
        $smarty->assign('payments', json_encode($config->get('payment')));
        return $smarty;
    }
}