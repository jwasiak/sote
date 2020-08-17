<?php

class stEservice2BackendActions extends stActions 
{

    public function initializeParameters() 
    {
        $this->config = stConfig::getInstance('stEservice2Backend');

        $i18n = $this->getContext()->getI18N();

        $this->labels = array(
            'eservice{client_id}' => $i18n->__('Numer sprzedawcy'),
            'eservice{password}' => $i18n->__('Hasło sprzedawcy'),
            'api' => 'eService',
        );
    }

    public function executeIndex() 
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST) 
        {
            $modules = PaymentTypePeer::doSelectByModuleName('stEservice2');

            if (!$modules)
            {
                $modules = PaymentTypePeer::doSelectByModuleName('stEservice');
                // $paymentType = new PaymentType();
                // $paymentType->setModuleName('stEservice2');
                // $paymentType->setCulture('pl_PL');
                // $paymentType->setName('eService (karta lub przelew)');
                // $paymentType->setCulture('en_US');
                // $paymentType->setName('eService (card or bank transfer)');
                // $modules = array($paymentType);
            }
            
            /**
             * @var PaymentType $module
             */
            foreach ($modules as $module)
            {
                $module->setModuleName('stEservice2');
                $module->setIsActive($this->config->get('enabled'));
                $module->save();
            }

            if ($this->config->get('enabled'))
            {
                $config = stConfig::getInstance('stEserviceBackend');
                $config->set('enabled', false);
                $config->save();
            }

            $this->config->save();

            $this->setFlash('notice', $this->getContext()->getI18n()->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
        }
    }

    public function validateIndex() 
    {
        $this->initializeParameters();

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $i18n = $this->getContext()->getI18N();
            $this->config->setFromRequest('config');
        }
        
        return !$this->getRequest()->hasErrors();
    }      

    public function handleErrorIndex() 
    {
        $this->initializeParameters();
        return sfView::SUCCESS;
    }
}
