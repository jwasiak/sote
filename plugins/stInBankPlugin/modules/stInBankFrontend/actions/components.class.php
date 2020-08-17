<?php

class stInBankFrontendComponents extends sfComponents
{
    public function executeShowPayment()
    {
        $api = new stInBank();
        $order = $this->order;

        sfLoader::loadHelpers(array('Helper', 'stUrl'));

        try
        {
            $url = $api->createPayment($order); 

            if ($url) 
            {
                $this->getController()->redirect($url);   
                throw new sfStopException();
            }
        }   
        catch (sfStopException $e)
        {
            throw $e;
        }
        catch (Exception $e) 
        {
            self::log('Init payment for order ' . $order->getNumber() . ': '. $e->getMessage());      
        } 

        $this->getController()->redirect(st_url_for('@stInBankFrontend?action=fail'));   
        throw new sfStopException();     
    }

    public function executeHelper()
    {        
        $scope = $this->getModuleName() . '/' . $this->getActionName();

        if (stTheme::getInstance($this->getContext())->getVersion() < 7 && !in_array($scope, array('stProduct/show', 'stBasket/index')))
        {
            return sfView::NONE;
        }

        $smarty = new stSmarty('stInBankFrontend');

        return $smarty;
    }

    public function executeCalculate()
    {
        if (stTheme::getInstance($this->getContext())->getVersion() < 7 || !stConfig::getInstance('stInBank')->get('enabled'))
        {
            return sfView::NONE;
        }

        $scope = $this->getModuleName() . '/' . $this->getActionName();

        if ($scope == 'stProduct/show')
        {
            $amount = $this->getController()->getActionStack()->getLastEntry()->getActionInstance()->product->getPriceBrutto(true);
        }
        else
        {
            $basket = $this->getUser()->getBasket();
            $amount = $basket->getTotalAmount(true, true);
            $amount += stDeliveryFrontend::getInstance($basket)->getTotalDeliveryCost(true, true);            
        }
        
        $smarty = new stSmarty('stInBankFrontend');
        $smarty->assign('amount', stPrice::round($amount));

        return $smarty;
    }
}