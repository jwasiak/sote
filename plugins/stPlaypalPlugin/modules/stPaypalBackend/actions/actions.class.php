<?php
class stPaypalBackendActions extends stActions
{
    public function executeSave()
    {
        return $this->forward('stPaypalBackend', 'config');
    }

    public function executeConfig()
    {
        $this->config = stConfig::getInstance('stPaypal');
        $this->labels = $this->getConfigLabels();

        $this->deliveries = DeliveryPeer::doSelect(new Criteria());

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->updateConfigRequest();

            $this->config->set('configuration_verified', true);

            $this->config->save();

            $this->redirect('stPaypalBackend/config');
        }
    }

    public function executeAjaxPaypalPendingPayments()
    {
        $this->setLayout(false);

        $this->config = stConfig::getInstance($this->getContext(), 'stPaypal');

        $paypal = $this->getPaypalCallerService();

        $request = new stPaypalCallerRequest();

        $timestamp_end = time();

        $timestamp_start = $timestamp_end - 86400 * 7;

        $request->setStartDate(date('Y-m-d\TH:i:s\Z', $timestamp_start));

        $request->setEndDate(date('Y-m-d\TH:i:s\Z', $timestamp_end));

        $request->setTransactionClass('Received');

        $request->setStatus('Pending');

        $this->paypal_response = $paypal->transactionSearch($request);
    }

    public function executeAjaxPaypalAccountBalance()
    {
        $this->setLayout(false);

        $this->config = stConfig::getInstance($this->getContext(), 'stPaypal');

        $paypal = $this->getPaypalCallerService();

        $request = new stPaypalCallerRequest();

        $request->setReturnAllCurrencies(true);

        $this->paypal_response = $paypal->getBalance($request);
    }

    protected function getPaypalCallerService()
    {
        $paypal = stPaypalCallerService::getInstance();

        if ($this->config->get('test_mode'))
        {
            $username = $this->config->get('sandbox_api_username');
            $password = $this->config->get('sandbox_api_password');
            $signature = $this->config->get('sandbox_api_signature');
            $environment = 'sandbox';

        }
        else
        {
            $username = $this->config->get('live_api_username');
            $password = $this->config->get('live_api_password');
            $signature = $this->config->get('live_api_signature');
            $environment = 'live';
        }

        $paypal->initialize($username, $password, $signature, array('environment' => $environment));

        return $paypal;
    }

    protected function updateConfigRequest()
    {
        $request = $this->getRequestParameter('config');

        foreach ($request as $name => $value)
        {
            $this->config->set($name, trim($value));
        }

        $this->config->set('test_mode', isset($request['test_mode']));

        $this->config->set('show_shipping_info', isset($request['show_shipping_info']));

        $this->config->set('express', isset($request['express']));
    }

    public function handleErrorConfig()
    {
        $this->config = stConfig::getInstance('stPaypal');
        $this->labels = $this->getConfigLabels();

        $this->deliveries = DeliveryPeer::doSelect(new Criteria());

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->updateConfigRequest();
        }

        return sfView::SUCCESS;
    }

    public function validateConfig()
    {

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

            $i18n = $this->getContext()->getI18n();

            $request = $this->getRequestParameter('config');

            if (isset($request['test_mode']))
            {
                if (empty($request['sandbox_api_username']))
                {
                    $this->getRequest()->setError('config{sandbox_api_username}', 'Musisz podać nazwę użytkownika API');
                }

                if (empty($request['sandbox_api_password']))
                {
                    $this->getRequest()->setError('config{sandbox_api_password}', 'Musisz podać hasło API');
                }

                if (empty($request['sandbox_api_signature']))
                {
                    $this->getRequest()->setError('config{sandbox_api_signature}', 'Musisz podać podpis API');
                }
            }
            else
            {
                if (empty($request['live_api_username']))
                {
                    $this->getRequest()->setError('config{live_api_username}', 'Musisz podać nazwę użytkownika API');
                }

                if (empty($request['live_api_password']))
                {
                    $this->getRequest()->setError('config{live_api_password}', 'Musisz podać hasło API');
                }

                if (empty($request['live_api_signature']))
                {
                    $this->getRequest()->setError('config{live_api_signature}', 'Musisz podać podpis API');
                }
            }

            if (!$this->getRequest()->hasErrors())
            {
                $paypal = stPaypalCallerService::getInstance();

                if (isset($request['test_mode']))
                {
                    $paypal->initialize(trim($request['sandbox_api_username']), trim($request['sandbox_api_password']), trim($request['sandbox_api_signature']), array('environment' => 'sandbox'));
                }
                else
                {
                    $paypal->initialize(trim($request['live_api_username']), trim($request['live_api_password']), trim($request['live_api_signature']));
                }

                $paypal_response = $paypal->getBalance(new stPaypalCallerRequest());

                if ($paypal_response->hasFailed())
                {
                    $errors = array();
                    
                    foreach ($paypal_response->getItems() as $error)
                    {
                        $errors[] = $error->getErrorCode().': '.$error->getLongMessage();
                    }

                    $this->getRequest()->setError('send_error', $i18n->__('Weryfikacja dostępu do API zakończyła się niepowodzeniem (%errors%)', array('%errors%' => implode(", ", $errors))));
                } 
                else
                {
                    $this->setFlash('notice', $i18n->__('Weryfikacja dostępu do API zakończona powodzeniem. Twoje zmiany zostały zapisane'));
                }
            }
        }

        return !$this->getRequest()->hasErrors();
    }

    protected function getConfigLabels()
    {
        return array(
            'send_error' => 'Paypal',
        );
    }
}