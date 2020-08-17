<?php

class stInBankFrontendActions extends stActions
{
    public function executeFail()
    {
        $this->smarty = new stSmarty($this->getModuleName());

        $webpage = WebpagePeer::retrieveByState('CONTACT');

        if ($webpage)
        {
            sfLoader::loadHelpers(array('Helper', 'stUrl'));
            $this->smarty->assign('contact_url', st_url_for('stWebpageFrontend/index?url='.$webpage->getFriendlyUrl()));
        }
    }

    public function executeReturn()
    {
        $id = $this->getRequest()->getParameter('id');
        $hash = $this->getRequest()->getParameter('hash');
        $hmac = $this->getRequest()->getParameter('hmac');
        $message = $this->getRequest()->getParameter('message');
        $timestamp = $this->getRequest()->getParameter('timestamp');

        $order = OrderPeer::retrieveByIdAndHashCode($id, $hash);

        if ($order)
        {
            $this->updatePaymentStatus($order, $hmac, $message, $timestamp);
        }
        else
        {
            stInBank::log('executeReturn: Order $id with hash $hash does not exist');
        }

        $this->smarty = new stSmarty($this->getModuleName());
    }

    public function executeCallback()
    {
        $id = $this->getRequest()->getParameter('id');
        $hash = $this->getRequest()->getParameter('hash');
        $hmac = $this->getRequest()->getParameter('hmac');
        $message = $this->getRequest()->getParameter('message');
        $timestamp = $this->getRequest()->getParameter('timestamp');

        $order = OrderPeer::retrieveByIdAndHashCode($id, $hash);

        if ($order)
        {
            $this->updatePaymentStatus($order, $hmac, $message, $timestamp);
        }
        else
        {
            stInBank::log('executeCallback: Order $id with hash $hash does not exist');
        }

        return $this->renderText('OK');
    }

    public function executeReturnCancel()
    {
        $this->smarty = new stSmarty($this->getModuleName());
    }

    protected function updatePaymentStatus(\Order $order, $hmac, $message, $timestamp)
    {
        $api = new stInBank();

        if ($api->verifyPostCallback($hmac, $timestamp, $message))
        {
            $payment = $order->getOrderPayment();

            if ($payment)
            {
                $payment->setStatus(true);
                $payment->save();

                stInBank::log("UpdatePaymentStatus for order {$order->getNumber()}: Order has been paid successfully");
            }
            else
            {
                stInBank::log("UpdatePaymentStatus for order {$order->getNumber()}: Payment does not exist");
            }
        }        
    }
}