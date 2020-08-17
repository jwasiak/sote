<?php

class stEservice2FrontendComponents extends sfComponents 
{

    public function executeShowPayment() 
    {
        $smarty = new stSmarty('stEservice2Frontend');
        $api = new stEservice2();
        $response = $api->getToken($this->order);
        
        if ($response)
        {
            $smarty->assign('logo', $api->getLogoPath());
            $smarty->assign('url', $api->getPaymentUrl());
            $smarty->assign('params', array(
                'merchantId' => $response->merchantId,
                'token' => $response->token,
                'integrationMode' => 'hostedPayPage',
            ));
        }
        else
        {
            return $this->getController()->redirect($this->getController()->genUrl('@stEservice2Plugin?action=returnFail'));
        }

        return $smarty;
    }
}
