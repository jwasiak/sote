<?php

class stEserviceBackendActions extends stActions 
{

    public function initializeParameters() 
    {
        $this->config = stConfig::getInstance('stEserviceBackend');

        $i18n = $this->getContext()->getI18N();

        $this->labels = array(
            'eservice{client_id}' => $i18n->__('Numer sprzedawcy'),
            'eservice{password}' => $i18n->__('Hasło sprzedawcy'),
            'eservice{store_key}' => $i18n->__('Klucz sklepu'),
            '{eService}' => 'eService',
        );
    }

    public function executeIndex() 
    {
        $this->initializeParameters();

        if ($this->getRequest()->getMethod() == sfRequest::POST) 
        {
            $this->config->setFromRequest('config');
            $this->config->save();

            $modules = PaymentTypePeer::doSelectByModuleName('stEservice');

            if (!$modules)
            {
                $modules = PaymentTypePeer::doSelectByModuleName('stEservice2');
            }
            
            /**
             * @var PaymentType $module
             */
            foreach ($modules as $module)
            {
                $module->setModuleName('stEservice');
                $module->setIsActive($this->config->get('enabled'));
                $module->save();
            }

            if ($this->config->get('enabled'))
            {
                $config = stConfig::getInstance('stEservice2Backend');
                $config->set('enabled', false);
                $config->save();
            }

            $this->setFlash('notice', $this->getContext()->getI18n()->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
        }
    }



    public function validateIndex() 
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $i18n = $this->getContext()->getI18N();

            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

            $data = $this->getRequestParameter('config');

            if (isset($data['enabled']))
            {
                $postParameters = array(
                    'ClientId' => $data['client_id'],
                    'Password' => $data['password'],
                    'OrderId' => uniqid(),
                    'Total' => 500,
                    'Currency' => 'PLN',
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, isset($data['test']) ? stEservice::TOKEN_URL_TEST : stEservice::TOKEN_URL_PROD);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postParameters, '', '&'));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);

                if ($response)
                {       
                    parse_str($response, $result);

                    if (strtolower($result['status']) != 'ok')
                    {
                        if ($result['msg'] == 'merchant-invalid')
                        {
                            $this->getRequest()->setError('{eService}', $i18n->__('Podane dane są nieprawidłowe'));                        
                        }
                        else
                        {
                            $this->getRequest()->setError('{eService}', $i18n->__('Wystąpił problem podczas próby weryfikacji danych (zwrócony błąd: "%msg%")', array('%msg%' => $result['msg'])));
                        }
                    }
                }
                else
                {
                    $this->getRequest()->setError('{eService}', $i18n->__('Wystąpił nieznany problem podczas weryfikacji danych'));
                }
            }
        }
        
        return !$this->getRequest()->hasErrors();
    }      

    public function handleErrorIndex() 
    {
        $this->initializeParameters();
        return sfView::SUCCESS;
    }
}
