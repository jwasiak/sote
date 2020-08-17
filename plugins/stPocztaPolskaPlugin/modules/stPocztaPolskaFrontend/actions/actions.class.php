<?php

class stPocztaPolskaFrontendActions extends stActions
{
    public function executeChooseDeliveryPoint()
    {
        $delivery_id = $this->getRequestParameter('delivery_id');

        $points = $this->getUser()->getAttribute('delivery_point', array(), 'soteshop/stPocztaPolskaPlugin');
        
        $points[$delivery_id] = $this->getRequestParameter('point');

        $this->getUser()->setAttribute('delivery_point', $points, 'soteshop/stPocztaPolskaPlugin');

        return sfView::HEADER_ONLY;
    }
}