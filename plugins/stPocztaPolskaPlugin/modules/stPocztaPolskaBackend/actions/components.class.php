<?php

class stPocztaPolskaBackendComponents extends autostPocztaPolskaBackendComponents
{
    public function executeOrderDelivery()
    {
        if (!stConfig::getInstance('stPocztaPolskaBackend')->get('enabled') || $this->order->getOrderDelivery() === null || $this->order->getOrderDelivery()->getDelivery() === null)
        {
            return sfView::NONE;
        }

        $delivery = $this->order->getOrderDelivery()->getDelivery();

        if (!$delivery->isType('ppo') && !$delivery->isType('ppk'))
        {
            return sfView::NONE;
        }


        $this->paczka = PocztaPolskaPaczkaPeer::retrieveByOrder($this->order);
    }

    public function executeListMenu()
    {
        if ($this->getContext()->getActionName() == 'packagesList')
        {
            return sfView::NONE;
        }
        
        return parent::executeListMenu();
    }

    public function executeCreatePackageForm()
    {
        $this->service = $this->package->getService();
                
        $this->bufor = $this->package->getBufor();
    }
}