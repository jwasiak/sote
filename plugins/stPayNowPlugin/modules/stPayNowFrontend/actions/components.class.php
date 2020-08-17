<?php

class stPayNowFrontendComponents extends sfComponents
{
    public function executeShowPayment()
    {
        stPayment::log('paynow', 'Creating new payment for order: '. $this->order->getNumber());

        $api = new stPayNow();
        
        $url = $api->createPayment($this->order);

        if (false === $url)
        {
            stPayment::log('paynow', 'Failure: '. $api->getLastError());

            return $this->redirect($this->getController()->genUrl('@stPayNowFail?id='.$this->order->getId().'&hash_code='.$this->order->getHashCode()));
        }

        stPayment::log('paynow', 'Success: '. $url);


        return $this->redirect($url);  
    }

    public function redirect($url)
    {
        $this->getController()->redirect($url);
        throw new sfStopException();  
    }
}