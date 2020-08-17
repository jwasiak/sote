<?php

class stPocztaPolskaBackendActions extends autostPocztaPolskaBackendActions
{
    protected $update = false;

    public function executeAjaxUpdateCreatePackageForm()
    {
        $order = OrderPeer::retrieveByPK($this->getRequestParameter('order_id'));
        $serviceName = $this->getRequestParameter('service');
        $country = $this->getRequestParameter('country');

        if (null === $order)
        {
            throw new Exception(sprintf("Order with %s does not exist", $this->getRequestParameter('order_id')));
        }    

        $package = stPocztaPolskaPackage::getInstance($order, $serviceName);

        if ($country)
        {
            $package->setCountry($country);
        }

        $content = $this->getRenderComponent('stPocztaPolskaBackend', 'createPackageForm', array('package' => $package, 'order' => $order));

        return $this->renderText($content);
    }

    public function validateConfig()
    {
        $request = $this->getRequest();

        if ($request->getMethod() == sfRequest::POST)
        {
            $data = $request->getParameter('config');

            if (isset($data['enabled']) && $data['enabled'])
            {
                $hello = new hello();
                $hello->in = "test";
                $en = new stPocztaPolskaClient($data['login'], $data['password'], isset($data['test_mode']) && $data['test_mode']);

                try
                {
                    $response = $en->hello($hello);
                }
                catch(Exception $e)
                {
                    if (sfConfig::get('sf_debug') && sfConfig::get('sf_logging_enabled'))
                    {
                        sfLogger::getInstance()->log('{stPocztaPolska} HEADERS: '.$en->getClient()->__getLastRequestHeaders (), SF_LOG_ERR);
                        sfLogger::getInstance()->log('{stPocztaPolska} REQUEST: '.$en->getClient()->__getLastRequest(), SF_LOG_ERR);
                        sfLogger::getInstance()->log('{stPocztaPolska} '.$e->getMessage(), SF_LOG_ERR);
                    }

                    $request->setError('{stPocztaPolska}', "Błąd autoryzacji. Sprawdź wprowadzone login i hasło");
                }

                if (isset($data['is_company'])) 
                {
                    $required = array('urzad_nadania', 'company', 'region', 'zip_code', 'town', 'phone', 'street', 'house', 'rachunek1');
                }
                else 
                {
                    $required = array('urzad_nadania', 'name', 'surname', 'region', 'zip_code', 'town', 'phone', 'street', 'house', 'rachunek1');
                }

                foreach ($required as $name)
                {
                    if (isset($data[$name]) && !$data[$name])
                    {
                        $request->setError('config{'.$name.'}', "Uzupełnij");
                    }
                }

                $config = stConfig::getInstance('stPocztaPolskaBackend');
                $this->update = $config->get('login') != $data['login'] || $config->get('password') != $data['password'] || $config->get('enabled') != $data['enabled'] && $data['enabled'];
            }
        }

        return !$request->hasErrors();
    }

    protected function updateConfigFromRequest()
    {
        parent::updateConfigFromRequest();

        $config = $this->getRequestParameter('config');

        if (isset($config['payment']))
        {
            $tokens = stJQueryToolsHelper::parseTokensFromRequest($config['payment']);      

            $payments = array();

            foreach ($tokens as $token)
            {
                $payments[] = $token['id'];
            }

            $this->config->set('payment', $payments);
        }
    }

    protected function saveConfig() 
    {    
        $ret = parent::saveConfig();

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (stConfig::getInstance('stPocztaPolskaBackend')->get('enabled'))
            {
                $config = stConfig::getInstance('stUser');
                $config->set('validate_phone', true);
                $config->save();
            }

            if ($this->update)
            {                
                stFunctionCache::getInstance('stPocztaPolska')->removeAll();
            }

            stTheme::clearSmartyCache(true);
        }  

        return $ret;
    }

    public function executeDownloadBlankietyPobrania()
    {
        $paczka_id = $this->getRequestParameter('paczka_id');

        if (!$paczka_id)
        {
            $bufor_id = $this->getRequestParameter('bufor_id');

            $api = stPocztaPolskaClient::getInstance();

            try
            {
                $guids = $api->getBuforGuids($bufor_id);
            }
            catch(Exception $e)
            {
                $i18n = $this->getContext()->getI18N();
                $this->setFlash('warning',$e->getMessage() == 'Unauthorized' ? $i18n->__("Błąd autoryzacji. Sprawdź wprowadzone login i hasło") : $e->getMessage());
                return $this->redirect($this->getRequest()->getReferer());
            }

            $filename = "BlankietyPobrania-".$bufor_id;
        }
        else
        {
            $paczka = PocztaPolskaPaczkaPeer::retrieveByPK($paczka_id);

            $bufor_id = $paczka->getBuforId();

            $guids = array($paczka->getGuid());

            $filename = "BlankietPobrania-".$paczka->getNumerNadania();
        }

        return $this->downloadBlankietyPobraniaByGuids($guids, $bufor_id, $filename);
    }

    protected function downloadBlankietyPobraniaByGuids($guids, $bufor_id, $filename)
    {
        $getBlankietPobraniaByGuids = new getBlankietPobraniaByGuids();
        $getBlankietPobraniaByGuids->guid = $guids;
        $getBlankietPobraniaByGuids->idBufor = $bufor_id;

        $api = stPocztaPolskaClient::getInstance();

        try
        {
            $response = $api->getBlankietPobraniaByGuids($getBlankietPobraniaByGuids);
        }
        catch(Exception $e)
        {
            $i18n = $this->getContext()->getI18N();
            $this->setFlash('warning',$e->getMessage() == 'Unauthorized' ? $i18n->__("Błąd autoryzacji. Sprawdź wprowadzone login i hasło") : $e->getMessage());
            return $this->redirect($this->getRequest()->getReferer());
        }

        if ($response->error)
        {
            $this->setFlash('warning', stPocztaPolskaClient::getFormatedErrors($response->error));

            return $this->redirect($this->getRequest()->getReferer());
        }

        return $this->renderPdf($response->content->pdfContent, $filename);        
    }

    public function executeDownloadAddressLabels()
    {
        $paczka_id = $this->getRequestParameter('paczka_id');

        if (!$paczka_id)
        {
            $bufor_id = $this->getRequestParameter('bufor_id');

            $api = stPocztaPolskaClient::getInstance();

            try
            {
                $guids = $api->getBuforGuids($bufor_id);
            }
            catch(Exception $e)
            {
                $i18n = $this->getContext()->getI18N();
                $this->setFlash('warning', $e->getMessage() == 'Unauthorized' ? $i18n->__("Błąd autoryzacji. Sprawdź wprowadzone login i hasło") : $e->getMessage());
                return $this->redirect($this->getRequest()->getReferer());
            }            

            $filename = "EtykietyAdresowe-".$bufor_id;
        }
        else
        {
            $paczka = PocztaPolskaPaczkaPeer::retrieveByPK($paczka_id);

            $bufor_id = $paczka->getBuforId();

            $guids = array($paczka->getGuid());

            $filename = "EtykietyAdresowe-".$paczka->getNumerNadania();
        }

        return $this->downloadAddressLabelsByGuids($guids, $bufor_id, $filename);
    }

    protected function downloadAddressLabelsByGuids($guids, $bufor_id, $filename)
    {
        $getAddresLabelByGuidCompact = new getAddresLabelByGuidCompact();
        $getAddresLabelByGuidCompact->guid = $guids;
        $getAddresLabelByGuidCompact->idBufor = $bufor_id;

        $api = stPocztaPolskaClient::getInstance();

        $i18n = $this->getContext()->getI18N();

        try
        {
            $response = $api->getAddresLabelByGuidCompact($getAddresLabelByGuidCompact);
        }
        catch(Exception $e)
        {
            $this->setFlash('warning', $e->getMessage() == 'Unauthorized' ? $i18n->__("Błąd autoryzacji. Sprawdź wprowadzone login i hasło") : $e->getMessage());
            return $this->redirect($this->getRequest()->getReferer());
        }

        if ($response->error)
        {
            $this->setFlash('warning', stPocztaPolskaClient::getFormatedErrors($response->error));

            return $this->redirect($this->getRequest()->getReferer());
        }

        return $this->renderPdf($response->pdfContent, $filename);        
    }

    public function executeDownloadAddressLabel()
    {
        $paczka_id = $this->getRequestParameter('paczka_id');

        $paczka = PocztaPolskaPaczkaPeer::retrieveByPK($paczka_id);

        $api = stPocztaPolskaClient::getInstance();

        $getAddressLabel = new getAddressLabel();
        $getAddressLabel->idEnvelope = $paczka->getEnvelopeId();

        $i18n = $this->getContext()->getI18N();

        try
        {
            $response = $api->getAddressLabel($getAddressLabel);
        }
        catch(Exception $e)
        {
            $this->setFlash('warning', $e->getMessage() == 'Unauthorized' ? $i18n->__("Błąd autoryzacji. Sprawdź wprowadzone login i hasło") : $e->getMessage());
            return $this->redirect($this->getRequest()->getReferer());
        }

        if (!$response)
        {
            $this->setFlash('warning', $this->getContext()->getI18N()->__('Przesyłka %%number%% nie istnieje', array('%%number%%' => $paczka->getNumerNadania())));

            return $this->redirect($this->getRequest()->getReferer());
        }
        elseif ($response->error)
        {
            $this->setFlash('warning', stPocztaPolskaClient::getFormatedErrors($response->error));

            return $this->redirect($this->getRequest()->getReferer());
        }

        $results = is_array($response->content) ? $response->content : array($response->content);

        foreach ($results as $result)
        {
            if ($result->nrNadania == $paczka->getNumerNadania())
            {
                $filename = "EtykietaAdresowa-".$paczka->getNumerNadania();

                return $this->renderPdf($result->pdfContent, $filename);               
            }
        }      
    }


    public function executeDownloadOutboxBook()
    {
        $paczka_id = $this->getRequestParameter('paczka_id');
        $paczka = PocztaPolskaPaczkaPeer::retrieveByPK($paczka_id);

        $api = stPocztaPolskaClient::getInstance();

        $getOutboxBook = new getOutboxBook();
        $getOutboxBook->idEnvelope = $paczka->getEnvelopeId();

        $i18n = $this->getContext()->getI18N();

        try
        {
            $response = $api->getOutboxBook($getOutboxBook);
        }
        catch(Exception $e)
        {
            $this->setFlash('warning', $e->getMessage() == 'Unauthorized' ? $i18n->__("Błąd autoryzacji. Sprawdź wprowadzone login i hasło") : $e->getMessage());
            return $this->redirect($this->getRequest()->getReferer());
        }            

        if (!$response)
        {
            $this->setFlash('warning', $this->getContext()->getI18N()->__('Przesyłka %%number%% nie istnieje', array('%%number%%' => $paczka->getNumerNadania())));

            return $this->redirect($this->getRequest()->getReferer());
        }
        elseif ($response->error)
        {
            $this->setFlash('warning', stPocztaPolskaClient::getFormatedErrors($response->error));

            return $this->redirect($this->getRequest()->getReferer());
        }

        $filename = "KsiazkaNadawcza-".$paczka->getNumerNadania();;

        return $this->renderPdf($response->pdfContent, $filename);
    }

    protected function renderPdf($content, $filename)
    {
        $this->getResponse()->clearHttpHeaders();
        $this->getResponse()->setHttpHeader('Content-Type', 'application/pdf');
        $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename="'.$filename.'.pdf');

        return $this->renderText($content);        
    }


    public function executeSend()
    {
        $bufor_id = $this->getRequestParameter('bufor_id');

        $api = stPocztaPolskaClient::getInstance();

        $ppb = PocztaPolskaBuforPeer::retrieveByBuforId($bufor_id);

        $sendEnvelope = new sendEnvelope();
        $sendEnvelope->idBufor = $bufor_id;
        $sendEnvelope->urzadNadania = $ppb->getUrzadNadania();
        
        try
        {
            $response = $api->sendEnvelope($sendEnvelope); 
        }
        catch(Exception $e)
        {
            $i18n = $this->getContext()->getI18N();
            $this->setFlash('warning', $e->getMessage() == 'Unauthorized' ? $i18n->__("Błąd autoryzacji. Sprawdź wprowadzone login i hasło") : $e->getMessage());
  
            stPayment::log('poczta_polska', "Send Package Exception For Bufor $bufor_id: " . $e->getMessage());

            return $this->redirect($this->getRequest()->getReferer());            
        }

        if ($response->error)
        {
            $this->setFlash('warning', stPocztaPolskaClient::getFormatedErrors($response->error));

            stPayment::log('poczta_polska', "Send Package Error For Bufor $bufor_id:\n" . var_export($response, true));

            return $this->redirect($this->getRequest()->getReferer()); 
        }

        stPayment::log('poczta_polska', "Send Package Success For Bufor $bufor_id:\n" . var_export($response, true));

        try 
        {
            $c = new Criteria();
            $c->add(PocztaPolskaPaczkaPeer::BUFOR_ID, $bufor_id);
            
            foreach (PocztaPolskaPaczkaPeer::doSelect($c) as $paczka)
            {
                $paczka->setEnvelopeId($response->idEnvelope);
                $paczka->setBuforId(null);
                $paczka->save();
            }

            $ppb->delete();
        }
        catch(Exception $e)
        {
            stPayment::log('poczta_polska', "Send Package Error For Bufor $bufor_id: " . $e->getMessage());
        }

        return $this->redirect('@stPocztaPolskaBackend?action=sentList');      
    }

    public function executeUpdateBufor()
    {
        $bufor_id = $this->getRequestParameter('bufor_id');

        $bufor = $this->getRequestParameter('bufor');

        $api = stPocztaPolskaClient::getInstance();

        $updateEnvelopeBufor = new updateEnvelopeBufor();

        $updateEnvelopeBufor->bufor = new buforType();
        $updateEnvelopeBufor->bufor->idBufor = $bufor_id;
        $updateEnvelopeBufor->bufor->dataNadania = $bufor['data_nadania'];
        $updateEnvelopeBufor->bufor->urzadNadania = $bufor['urzad_nadania'];
        $updateEnvelopeBufor->bufor->opis = stPocztaPolskaClient::getBuforDescription($bufor['data_nadania'], $bufor['urzad_nadania']);

        $ppb = PocztaPolskaBuforPeer::retrieveByBuforId($bufor_id);
        $ppb->setUrzadNadania($bufor['urzad_nadania']);
        $ppb->setDataNadania($bufor['data_nadania']);
        $ppb->save();

        $response = $api->updateEnvelopeBufor($updateEnvelopeBufor);

        return $this->renderJSON($response);
    }

    public function executeCreatePackage()
    {
        $request = $this->getRequest();

        if ($request->getMethod() == sfRequest::POST)
        {
            return $this->redirect('@stPocztaPolskaBackend?action=packagesList&bufor_id='.$this->paczka->getBuforId());
        }
    }

    public function executeDeleteBufor()
    {
        $api = stPocztaPolskaClient::getInstance();

        $i18n = $this->getContext()->getI18N();

        try
        {
            $api->deleteBufor($this->getRequestParameter('bufor_id'));
        }
        catch(Exception $e)
        {
            $this->setFlash('warning', $e->getMessage() == 'Unauthorized' ? $i18n->__("Błąd autoryzacji. Sprawdź wprowadzone login i hasło") : $e->getMessage());
            return $this->redirect($this->getRequest()->getReferer());
        } 

        // if ($response->error)
        // {
        //     $this->setFlash('warning', stPocztaPolskaClient::getFormatedErrors($response->error));
        
        //     return $this->redirect($this->getRequest()->getReferer());
        // }

        return $this->redirect('@stPocztaPolskaBackend?action=list');
    }

    public function handleErrorCreatePackage()
    {
        return sfView::SUCCESS;       
    }

    public function executePackagesList()
    {
        $bufor_id = $this->getRequestParameter('bufor_id');

        $this->bufor = PocztaPolskaBuforPeer::retrieveByBuforId($bufor_id);

        if (null === $this->bufor)
        {
            return $this->forward404();
        }

        $this->getUser()->setParameter('bufor', $this->bufor, 'soteshop/stPocztaPolska');
        
        return parent::executePackagesList();
    }

    protected function addPackagesFiltersCriteria($c)
    {
        $ret = parent::addPackagesFiltersCriteria($c);

        if ($this->bufor)
        {
            $c->add(PocztaPolskaPaczkaPeer::BUFOR_ID, $this->bufor->getBuforId());
        }
    }

    protected function addSentFiltersCriteria($c)
    {
        $ret = parent::addSentFiltersCriteria($c);
 
        $c->add(PocztaPolskaPaczkaPeer::ENVELOPE_ID, null, Criteria::ISNOTNULL);   

        if (!$c->getOrderByColumns())
        {
            $c->addDescendingOrderByColumn(PocztaPolskaPaczkaPeer::ID);
        }
    }

    public function validateCreatePackage()
    {
        $request = $this->getRequest();

        $this->initCreatePackage($this->getRequestParameter('service_name'));

        if ($request->getMethod() == sfRequest::POST)
        {
            $i18n = $this->getContext()->getI18N();

            $package = $this->getRequestParameter('package');

            $this->updateCreatePackageFromRequest();

            if (isset($package['po']) && (!$package['po'] || $package['po'] == '[]'))
            {
                $request->setError('package{po}', $i18n->__('Musisz podać punkt odbioru'));
            }

            if ($this->serviceName == 'paczka_zagraniczna' || $this->serviceName == 'paczka_zagraniczna_ue')
            {
                $isEU = stPocztaPolskaClient::isEUCountry($this->service->adres->kraj);

                if (!$isEU && $this->serviceName == 'paczka_zagraniczna_ue')
                {
                    $request->setError('package{adres}{kraj}', $i18n->__('Wybrany kraj musi należeć do Unii Europejskiej'));
                }
                elseif ($isEU && $this->serviceName == 'paczka_zagraniczna')
                {
                    $request->setError('package{adres}{kraj}', $i18n->__('Wybrany kraj nie może należeć do Unii Europejskiej'));
                }
            }

            if ($request->hasErrors())
            {
                return false;
            }

            $api = stPocztaPolskaClient::getInstance();

            $response = null;

            try
            {
                $response = $api->getOrCreateBufor($this->bufor->dataNadania, $this->bufor->urzadNadania);
            }
            catch(Exception $e)
            {
                $request->setError('{stPocztaPolska}', $e->getMessage() == 'Unauthorized' ? $i18n->__("Błąd autoryzacji. Sprawdź wprowadzone login i hasło") : $e->getMessage());
                return false;
            }

            if (!$response)
            {
                $request->setError('{stPocztaPolska}', $i18n->__('Wystąpił nieznany błąd po stronie Poczty Polskiej podczas próby tworzenia nowego zbioru'));
            }
            elseif ($response->error)
            {
                if (sfConfig::get('debug'))
                {
                    sfLogger::getInstance()->log('{stPocztaPolska}'.var_export($response, true), SF_LOG_ERR);
                }

                $request->setError('{stPocztaPolska}', stPocztaPolskaClient::getFormatedErrors($response->error));

                return false;
            }

            $this->bufor = $response->bufor;

            $g = new getGuid();

            $g->ilosc = 1;

            try
            {
                $response = $api->getGuid($g);
            }
            catch(Exception $e)
            {
                $request->setError('{stPocztaPolska}', $e->getMessage() == 'Unauthorized' ? $i18n->__("Błąd autoryzacji. Sprawdź wprowadzone login i hasło") : $e->getMessage());
                return false;
            }  

            $shipment = new addShipment();

            $shipment->idBufor = $this->bufor->idBufor;

            $this->service->guid = $response->guid;

            $shipment->przesylki[] = $this->service;

            // throw new Exception("<pre>".var_export($shipment, true));

        
            try
            {
                $response = $api->addShipment($shipment);
            }
            catch(Exception $e)
            {
                $request->setError('{stPocztaPolska}', $e->getMessage() == 'Unauthorized' ? $i18n->__("Błąd autoryzacji. Sprawdź wprowadzone login i hasło") : $e->getMessage());
                return false;
            } 

            if (!$response || !$response->retval)
            {
                $request->setError('{stPocztaPolska}', $i18n->__('Wystąpił nieznany błąd po stronie Poczty Polskiej podczas próby dodania nowej przesyłki'));
            }
            elseif (is_array($response->retval))
            {
                if (sfConfig::get('sf_debug'))
                {
                    sfLogger::getInstance()->log('{stPocztaPolska} '.$api->getClient()->__getLastRequest(), SF_LOG_ERR);
                }
                
                if ($response->retval[0]->error)
                {
                    $request->setError('{stPocztaPolska} ', stPocztaPolskaClient::getFormatedErrors($response->retval[0]->error));
                    return false;
                }
            }
            elseif ($response->retval->error)
            {                
                if (sfConfig::get('sf_debug'))
                {
                    sfLogger::getInstance()->log('{stPocztaPolska} '.$api->getClient()->__getLastRequest(), SF_LOG_ERR);
                }

                if (sfConfig::get('sf_debug'))
                {
                    sfLogger::getInstance()->log('{stPocztaPolska} '.var_export($response, true), SF_LOG_ERR);
                }

                $request->setError('{stPocztaPolska}', stPocztaPolskaClient::getFormatedErrors($response->retval->error));

                return false;
            }

            $this->paczka = new PocztaPolskaPaczka();
            $this->paczka->setOrderId($this->order->getId());
            $this->paczka->setGuid($response->retval->guid);
            $this->paczka->setNumerNadania($response->retval->numerNadania);
            $this->paczka->setBuforId($this->bufor->idBufor);
            $this->paczka->setParameters($this->packageReq);

            $this->paczka->save();

            if (isset($this->po)) 
            {
                $this->po->save();
            }
        }

        return true;
    }

    public function executeSendPackage()
    {
        $client = stPocztaPolskaClient::getInstance();

        $client->getGuid();
    }

    public function executePackagesDelete()
    {
        stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
        $forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStPocztaPolskaBackend/forward_parameters');

        $selected = $this->getRequestParameter('poczta_polska_paczka[selected]', array($this->getRequestParameter('id')));

        $guids = array();

        $bufor_id = null;

        foreach($selected as $id)
        {
            $poczta_polska_paczka = PocztaPolskaPaczkaPeer::retrieveByPK($id);

            if ($poczta_polska_paczka) {
                $guids[$poczta_polska_paczka->getGuid()] = $poczta_polska_paczka;
                $bufor_id = $poczta_polska_paczka->getBuforId();
            }
        }

        if ($guids)
        {
            $api = stPocztaPolskaClient::getInstance();
            $clearEnvelopeByGuids = new clearEnvelopeByGuids();
            $clearEnvelopeByGuids->guid = array_keys($guids);
            $clearEnvelopeByGuids->idBufor = $bufor_id;

            try
            {
                $response = $api->clearEnvelopeByGuids($clearEnvelopeByGuids);
            }
            catch(Exception $e)
            {
                $i18n = $this->getContext()->getI18N();
                $this->setFlash('warning', '{stPocztaPolska}', $e->getMessage() == 'Unauthorized' ? $i18n->__("Błąd autoryzacji. Sprawdź wprowadzone login i hasło") : $e->getMessage());
                return $this->redirect($this->getRequest()->getReferer());
            } 

            if ($response->error)
            {
                $errors = is_array($response->error) ? $response->error : array($response->error);

                foreach ($errors as $error) 
                {
                    if (isset($guids[$error->guid]))
                    {
                        unset($guids[$error->guid]);
                    }
                }

                foreach ($guids as $package) 
                {
                    $package->delete();
                }

                $this->setFlash('warning', stPocztaPolskaClient::getFormatedErrors($response->error));
    
                return $this->redirect($this->getRequest()->getReferer());
            }
            else
            {
                foreach ($guids as $package) 
                {
                    $package->delete();
                }                
            }
        }

        return $this->redirect('@stPocztaPolskaBackend?action=packagesList&bufor_id='.$bufor_id.'&page='.$this->getRequestParameter('page', 1));
    }

    public function updateCreatePackageFromRequest()
    {
        $this->packageReq = $this->getRequestParameter('package');
        
        if (isset($this->packageReq['po']) && $this->packageReq['po'] && $this->packageReq['po'] !== '[]')
        {
            $this->po->setPoint(json_decode($this->packageReq['po'], true));

            $urzadWydaniaEPrzesylkiType = new urzadWydaniaEPrzesylkiType();
            $urzadWydaniaEPrzesylkiType->id = intval($this->po->getPni());
            $urzadWydaniaEPrzesylkiType->wojewodztwo = $this->po->getProvince();

            $this->service->urzadWydaniaEPrzesylki = $urzadWydaniaEPrzesylkiType;

            unset($this->packageReq['po']);
        }

        if (isset($this->packageReq['adres']['kraj']))
        {
            $this->package->setCountry($this->packageReq['adres']['kraj']);
        }

        stPocztaPolskaClient::updateService($this->service, $this->packageReq);

        if (isset($this->service->deklaracjaCelna2) && $this->service->deklaracjaCelna2) 
        {
            $szczegoly = array();

            foreach (array_values($this->packageReq['deklaracja_celna2']['szczegoly_zawartosci_przesylki']) as $szczegol)
            {
                if (!$szczegol['okreslenie_zawartosci']) 
                {
                    continue;
                }

                $szczegolyZawartosciPrzesylkiZagranicznejType = new szczegolyZawartosciPrzesylkiZagranicznejType();

                stPocztaPolskaClient::updateService($szczegolyZawartosciPrzesylkiZagranicznejType, $szczegol);

                $szczegoly[] = $szczegolyZawartosciPrzesylkiZagranicznejType;
            }

            $this->service->deklaracjaCelna2->szczegolyZawartosciPrzesylki = $szczegoly;  

            $dokumenty = array();

            foreach (array_values($this->packageReq['deklaracja_celna2']['dokumenty_towarzyszace']) as $dokument)
            {
                if (!$dokument['rodzaj']) 
                {
                    continue;
                }

                $dokumentyTowarzyszaceType = new dokumentyTowarzyszaceType();

                stPocztaPolskaClient::updateService($dokumentyTowarzyszaceType, $dokument);

                $dokumenty[] = $dokumentyTowarzyszaceType;
            }

            $this->service->deklaracjaCelna2->dokumentyTowarzyszace = $dokumenty;             
        }



        $bufor = $this->getRequestParameter('bufor');

        $this->bufor->urzadNadania = $bufor['urzad_nadania'];
        $this->bufor->dataNadania = $bufor['data_nadania'];

        // throw new Exception("<pre>".var_export($this->service, true));
        
    }

    protected function initCreatePackage($serviceName)
    {
        $id = $this->getRequestParameter('id');

        $this->order = OrderPeer::retrieveByPK($id);

        if (null === $this->order)
        {
            throw new Exception("Order with $id does not exist");
        }        
        
        $this->package = stPocztaPolskaPackage::getInstance($this->order, $serviceName);

        $this->service = $this->package->getService();
        $this->po = $this->package->getDeliveryPoint();
        $this->bufor = $this->package->getBufor();
        $this->serviceName = $this->package->getServiceName();

        $this->labels = $this->getCreatePackageLabels();       
    }

    protected function getCreatePackageLabels()
    {   
        return array(
            '{stPocztaPolska}' => "Poczta Polska:",
            'package{po}' => "Punkt odbioru",
            'package{deklaracja_celna}{szczegoly}' => "Szczegóły zawartości przesyłki",
            'package{adres}{kraj}' => "Kraj",
        );
    }

    protected function getConfigLabels()
    {
        $labels = parent::getConfigLabels();

        $labels["{stPocztaPolska}"] = "Poczta Polska:";

        return $labels;
    }
}