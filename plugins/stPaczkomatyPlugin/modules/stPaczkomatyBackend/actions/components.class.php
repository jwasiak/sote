<?php

class stPaczkomatyBackendComponents extends autostPaczkomatyBackendComponents 
{
    public function executeOrderDelivery()
    {
        if ($this->order->getOrderDelivery() === null || $this->order->getOrderDelivery()->getDelivery() === null && !$this->order->getOptAllegroNick() || $this->order->getOptAllegroNick()  && !$this->order->getOrderDelivery()->getPaczkomatyNumber() || !$this->order->getOptAllegroNick() && !$this->order->getOrderDelivery()->getDelivery()->isType('inpostp'))
        {   
            return sfView::NONE;
        }

        $this->pp = PaczkomatyPackPeer::retrieveByOrder($this->order);
    }
}
