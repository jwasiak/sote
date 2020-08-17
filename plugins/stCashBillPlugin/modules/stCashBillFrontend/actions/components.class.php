<?php

class stCashBillFrontendComponents extends sfComponents {

    public function executeShowPayment() {
        $this->smarty = new stSmarty('stCashBillFrontend');

        $this->stCashBill = new stCashBill();
        $this->order = OrderPeer::retrieveByPK($this->getRequestParameter('id'));

        if (in_array($this->stCashBill->getShowVariant(), array('text', 'image'))) {
            $this->channels = $this->stCashBill->getPaymentChannels();
        } else
            $this->channels = array();

        if ($this->getContext()->getModuleName() == 'stPayment' && $this->getContext()->getActionName() == 'pay')
            $this->redirect = true;
        else 
            $this->redirect = false;
    }
}
