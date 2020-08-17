<?php

class stPaczkomatyFrontendActions extends stActions 
{
    public function executeChooseDeliveryPoint()
    {
        $delivery_id = $this->getRequestParameter('delivery_id');

        $points = $this->getUser()->getAttribute('delivery_point', array(), 'soteshop/stPaczkomatyPlugin');
        
        $points[$delivery_id] = $this->getRequestParameter('point');

        $this->getUser()->setAttribute('delivery_point', $points, 'soteshop/stPaczkomatyPlugin');

        return sfView::HEADER_ONLY;
    }

    public function executeShowMap() {
        $this->smarty = new stSmarty('stPaczkomatyFrontend');
        $this->setLayout(false);
        $this->config = stConfig::getInstance('stPaczkomatyBackend');

        $this->cities = stPaczkomatyCites::getListofCities();

        $delivery = DeliveryPeer::retrieveByPK($this->getRequestParameter('deliveryId'));

        if (is_object($delivery))
            $this->machinesNamespace = $delivery->getPaczkomatyType();
    }

    public function executeGetMachines() {
        $i18n = $this->getContext()->getI18n();

        if ($this->getRequestParameter('machinesNamespace', 'ALL') == 'COD') {
            $data = stPaczkomatyMachines::getListOfCodMachines();
        } else {
            $data = stPaczkomatyMachines::getListOfMachines();
        }

        return $this->renderJSON($data);
    }

    public function executeGetMachine() {

        return $this->renderJSON(stPaczkomatyMachines::getMachine($this->getRequestParameter('number')));

   
    }

    public function executeGetMachineByPostCode() {
       
        return $this->renderJSON(stPaczkomatyMachines::getMachineByPostCode($this->getRequestParameter('post_code')));

        
    }

    public function executeGetMachinesByPostCode()
    {        
        return $this->renderJSON(stPaczkomatyMachines::getMachinesByPostCode($this->getRequestParameter('post_code'), $this->getRequestParameter('limit')));
    }

    public function executeGet3MachinesByPostCode() {

        return $this->renderJSON(stPaczkomatyMachines::get3MachinesByPostCode($this->getRequestParameter('post_code')));


    }

    public function executeEasyPackShow()
    {
        $this->setLayout(false);
        $config = stConfig::getInstance('stPaczkomatyBackend');
        $this->smarty = new stSmarty('stPaczkomatyFrontend');
        $this->smarty->assign('sandbox', $config->get('sandbox'));

        if (!$config->get('sandbox'))
        {
            $this->smarty->assign('api_endpoint', 'https://api-pl-points.easypack24.net/v1');
        }
        else
        {
            $this->smarty->assign('api_endpoint', 'https://stage-api-pl-points.easypack24.net/v1');
        }
        
    }
}
