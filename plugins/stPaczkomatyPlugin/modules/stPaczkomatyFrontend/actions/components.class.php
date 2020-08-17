<?php
class stPaczkomatyFrontendComponents extends sfComponents {

    public function executeBasketTerms() {
        if(stPaczkomaty::isActive() == false)
            return sfView::NONE;
        

        $this->smarty = new stSmarty('stPaczkomatyFrontend');
        $this->number = htmlspecialchars($this->getRequestParameter('user_data_billing[paczkomaty_machine_number]'));
    }

    public function executeDeliveryOnBasketList() {
        if(stPaczkomaty::isActive() == false || !$this->delivery->getPaczkomatyType() || $this->delivery->getPaczkomatyType() == 'NONE') 
            return sfView::NONE;

        $this->smarty = new stSmarty('stPaczkomatyFrontend');
        
        $point = json_decode($this->getRequestParameter('user_data_billing[paczkomaty_machine_number]'), true);

        $this->smarty->assign('point', $point);

        $this->smarty->assign('id', $this->delivery->getId());
    }

    public function executeHelper()
    {
        if ($this->getModuleName() != 'stBasket')
        {
            return sfView::NONE;
        }
        
        $smarty = new stSmarty('stPaczkomatyFrontend');
        $config = stConfig::getInstance('stPaczkomatyBackend');
        $smarty->assign('payments', json_encode($config->get('payment', array())));
        $smarty->assign('endpoint', stInPostApi::getInstance()->getEndpoint());

        return $smarty;
    }
}
