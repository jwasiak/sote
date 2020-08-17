<?php

class stPaczkomatyBackendActions extends autostPaczkomatyBackendActions 
{
    public function preExecute() 
    {
        if (!stCommunication::getIsSeven() && $this->getActionName() != 'seven')
        {
            $this->forward('stPaczkomatyBackend', 'seven');
        }
    }

    public function executeSeven() {

    }

    /**
     * Undocumented function
     *
     * @param PaczkomatyPack $paczkomaty_pack
     * @return void
     */
    protected function deletePaczkomatyPack($paczkomaty_pack)
    {
        parent::deletePaczkomatyPack($paczkomaty_pack);

        $api = stInPostApi::getInstance();

        try
        {
            $api->deleteShipment($paczkomaty_pack->getInpostShipmentId());
        }
        catch (stInPostApiException $e)
        {
        }
    }

    /**
     * {@inheritDoc}
     * @return PaczkomatyPack
     */
    protected function getPaczkomatyPackOrCreate($id = 'id')
    {
        if (!isset($this->paczkomaty_pack))
        {
            $pack = parent::getPaczkomatyPackOrCreate($id);

            $i18n = $this->getContext()->getI18N();

            if ($this->hasRequestParameter('order'))
            {
                $pack->setOrderId($this->getRequestParameter('order'));
            }

            if ($pack->isNew())
            {
                $order = $pack->getOrder();
                $config = stConfig::getInstance('stPaczkomatyBackend');
                $pack->setCustomerEmail($order->getOptClientEmail());
                $pack->setCustomerPhone($order->isAllegroOrder() ? $order->getOrderUserDataDelivery()->getPhone() : $order->getOrderUserDataBilling()->getPhone());
                $pack->setCustomerPickupPoint($order->getOrderDelivery()->getPaczkomatyNumber());
                $pack->setSendingMethod($config->get('sending_method'));
                $pack->setDropOffPoint($config->get('dropoff_point'));
                $pack->setDescription($i18n->__('Zamówienie '.$order->getNumber()));


                if ($order->getOrderDelivery()->getDelivery()) 
                {
                    $pack->setPackType($order->getOrderDelivery()->getDelivery()->getPaczkomatySize());
                }

                // $pack->setInsurance("0.00");
                // $pack->setCashOnDelivery("0.00");
            }
            else
            {
                $api = stInPostApi::getInstance();
                
                try
                {
                    $response = $api->getShipment($pack->getInpostShipmentId());

                    $pack->setSendingMethod($response->custom_attributes->sending_method);
                    $pack->setCustomerPickupPoint($response->custom_attributes->target_point);

                    if (isset($response->custom_attributes->dropoff_point))
                    {
                        $pack->setDropOffPoint($response->custom_attributes->dropoff_point);
                    }

                    if (!$pack->getTrackingNumber())
                    {
                        $pack->setTrackingNumber($response->tracking_number);
                    }

                    $pack->setParcelTemplate($response->parcels[0]->template);
                    $pack->setStatus($response->status);
                    $pack->setEndOfWeekCollection($response->end_of_week_collection);
                    
                    $pack->setCashOnDelivery(isset($response->cod) && $response->cod ? $response->cod->amount : 0);
                    $pack->setInsurance(isset($response->insurance) && $response->insurance ? $response->insurance->amount : 0);     
                }
                catch(stInPostApiException $e)
                {
                    $this->getRequest()->setError('api', $e->getMessage());
                }

                if ($response->transactions)
                {
                    foreach ($response->transactions as $transaction)
                    {
                        if ($transaction->status == 'failure')
                        {
                            $this->getRequest()->setError('api', $transaction->details->message);
                            break;
                        }
                    }
                }
            }
        }

        return $this->paczkomaty_pack;
    }

    public function executeEdit()
    {
        parent::executeEdit();

        if (!isset($this->forward_parameters['order']))
        {
            $this->forward_parameters['order'] = null;
        }
    }

    public function handleErrorEdit()
    {
        $ret = parent::handleErrorEdit();

        if (!isset($this->forward_parameters['order']))
        {
            $this->forward_parameters['order'] = null;
        }  
        
        return $ret;
    }

    public function executeDownloadLabel()
    {
        $pack = PaczkomatyPackPeer::retrieveByPK($this->getRequestParameter('id'));
        $api = stInPostApi::getInstance();

        try
        {
            if ($pack->getInpostShipmentId())
            {
                $id = $pack->getInpostShipmentId();
            }
            else
            {
                $shipment = $api->getShipmentByTrackingNumber($pack->getTrackingNumber());

                $id = $shipment->id;
            }

            $label = $api->downloadLabel($id);

            $response = $this->getResponse();
            $response->clearHttpHeaders();
            $response->setHttpHeader('Content-Type', 'application/pdf');

            return $this->renderText($label);
        }
        catch(stInPostApiException $e)
        {
            $i18n = $this->getContext()->getI18N();
            $this->getRequest()->setError('api', $i18n->__('Wystąpił bład podczas pobierania etykiety (Błąd: %error%)', array('%error%' => $e->getMessage())));

            return $this->forward('stPaczkomatyBackend', 'edit');
        }
    }

    public function validateEdit()
    {
        $request = $this->getRequest();

        if ($request->getMethod() == sfRequest::POST)
        {

            $pack = $this->getPaczkomatyPackOrCreate();

            $this->updatePaczkomatyPackFromRequest();

            $api = stInPostApi::getInstance();

            $i18n = $this->getContext()->getI18N();

            $order = $pack->getOrder();

            $currency = $order->getOrderCurrency()->getShortcut();

            $config = stConfig::getInstance('stPaczkomatyBackend');
            
            $shipmentRequest = array(
                'receiver' => array(
                    'email' => $pack->getCustomerEmail(),
                    'phone' => $pack->getCustomerPhone(),
                ),
                'sender' => array(
                    "company_name" => $config->get('sender_company'),
                    "first_name" => $config->get('sender_name'),
                    "last_name" => $config->get('sender_surname'),
                    "email" => trim($config->get('sender_email')),
                    "phone" => str_replace(array('+48', ' ', '-'), '', $config->get('sender_phone')),
                    "address" => array(
                        "street" => $config->get('sender_street'),
                        "building_number" => $config->get('sender_building'),
                        "city" => $config->get('sender_city'),
                        "post_code" => $config->get('sender_post_code'),
                        "country_code" => $config->get('sender_country_code'),
                    ),
                ),
                'parcels' => array(
                    array(
                        'template' => $pack->getParcelTemplate(),
                    ),
                ),
                'custom_attributes' => array(
                    'target_point' => $pack->getCustomerPickupPoint(),
                    'sending_method' => $pack->getSendingMethod(),
                ),
                'service' => $order->isAllegroOrder() ? 'inpost_locker_allegro' : 'inpost_locker_standard',
                'reference' => $pack->getDescription(),
                'only_choice_of_offer' => false,
            );

            if ($pack->getInsurance() > 0)
            {
                $shipmentRequest['insurance'] = array(
                    'amount' => $pack->getInsurance(),
                    'currency' => $currency,
                );
            }

            $shipmentRequest['end_of_week_collection'] = $pack->getEndOfWeekCollection();

            if ($pack->getCashOnDelivery() > 0)
            {
                $shipmentRequest['cod'] = array(
                    'amount' => $pack->getCashOnDelivery(),
                    'currency' => $currency,
                );
            }

            if (!$pack->getCustomerPickupPoint())
            {
                $request->setError('paczkomaty_pack{customer_pickup_point}', $i18n->__('Proszę uzupełnić pole.'));
            }

            if (in_array($pack->getSendingMethod(), array('parcel_locker')))
            {
                if (!$pack->getDropOffPoint())
                {
                    $request->setError('paczkomaty_pack{dropoff_point}', $i18n->__('Proszę uzupełnić pole.'));
                }

                // if ($pack->getDropOffPoint() == $pack->getCustomerPickupPoint())
                // {
                //     $request->setError('paczkomaty_pack{dropoff_point}', $i18n->__('Paczkomat nadawcy nie może być taki sam jak paczkomat odbiorcy'));
                // }

                $shipmentRequest['custom_attributes']['dropoff_point'] = $pack->getDropOffPoint();
            }

            if (!$request->hasErrors())
            {                
                try
                {      
                    $response = $api->createShipment($shipmentRequest);

                    $count = 0;

                    while((null === $response->tracking_number || $response->status != 'confirmed') && $count <= 20)
                    {
                        sleep(2);
                        
                        $result = $api->getShipment($response->id);

                        if ($result && is_object($result))
                        {
                            $response = $result;
                        }

                        $count++;
                    }

                    $request->setParameter('create_shipment', $response, 'soteshop/stInPostApi');
                }
                catch (stInPostApiException $e)
                {
                    $error = $api->getLastError();

                    if ($error && $error->error == stInPostApi::VALIDATION_FAILED)
                    {
                        if (isset($error->details->cod))
                        {
                            $request->setError('paczkomaty_pack{cash_on_delivery}', stInPostApi::formatDetailError($error->details->cod[0]->amount));
                        }

                        if (isset($error->details->insurance))
                        {
                            $request->setError('paczkomaty_pack{insurance}', stInPostApi::formatDetailError($error->details->insurance[0]->amount));
                        }

                        if (isset($error->details->custom_attributes))
                        {
                            foreach ($error->details->custom_attributes as $item)
                            {
                                if (isset($item->dropoff_point) && $item->dropoff_point[0] == "dropoff_and_target_points_must_be_different")
                                {
                                    $request->setError('paczkomaty_pack{dropoff_point}', $i18n->__('Paczkomat nadawcy nie może być taki sam jak paczkomat odbiorcy'));
                                }
                            }
                        }

             

                        if (isset($error->details->receiver[0]->email))
                        {
                            $request->setError('paczkomaty_pack{customer_email}', stInPostApi::formatDetailError($error->details->receiver[0]->email));
                        }

                        if (!$request->hasErrors())
                        {
                            $request->setError('api', $i18n->__("Wystąpił nieobsługiwany wyjątek (%error%)", array('%error%' => json_encode($error->details))));
                        }
                    }
                    else
                    {
                        $request->setError('api', $e->getMessage());
                    }
                }
            }
       
        }

        return !$request->hasErrors();
    }

    /**
     * Zapisuje model PaczkomatyPack
     *
     * @param PaczkomatyPack $pack
     * @return void
     */
    protected function savePaczkomatyPack($pack)
    {
        $response = $this->getRequest()->getParameter('create_shipment', null, 'soteshop/stInPostApi');

        // throw new Exception("<pre>".var_export($response, true)."</pre>");
        
        $pack->setInpostShipmentId($response->id);
        $pack->setStatus($response->status);
        $pack->setTrackingNumber($response->tracking_number);

        $isNew = $pack->isNew();

        $ret = parent::savePaczkomatyPack($pack);

        if ($isNew)
        {
            $this->updateOrderStatus($pack->getOrder());
        }
    }

    public function executeEasypackWidget()
    {
        $this->setLayout(false);

        if (!$this->getRequestParameter('sandbox'))
        {
            $this->endpoint = 'https://api-pl-points.easypack24.net/v1';
        }
        else
        {
            $this->endpoint = 'https://stage-api-pl-points.easypack24.net/v1';
        }

        $this->scope = $this->getRequestParameter('scope');
    }

    public function validateConfig() 
    {
        $request = $this->getRequest();
        $data = $request->getParameter('config');

        $this->config = stConfig::getInstance('stPaczkomatyBackend');

        $api = stInPostApi::getInstance();

        $i18n = $this->getContext()->getI18N();

        if ($request->getMethod() == sfRequest::POST)
        {
            $this->updateConfigFromRequest();

            if ($this->config->get('enabled'))
            {
                if (!$this->config->get('token'))
                {
                    $request->setError('config{token}', $i18n->__('Proszę uzupełnić pole.'));
                }
                                
                if (!$request->hasErrors())
                {
                    if ($api->isValid())
                    {
                        if (!$this->config->get('sending_method'))
                        {
                            $request->setError('config{sending_method}', $i18n->__('Proszę uzupełnić pole.'));
                        }
                        elseif ($this->config->get('sending_method') == 'parcel_locker' && !$this->config->get('dropoff_point'))
                        {
                            $request->setError('config{dropoff_point}', $i18n->__('Proszę uzupełnić pole.'));
                        }

                        $required = array('sender_email', 'sender_phone', 'sender_country_code', 'sender_street', 'sender_building', 'sender_city', 'sender_post_code');
                        
                        if (!$this->config->get('sender_company') && (!$this->config->get('sender_company') || !$this->config->get('sender_company')))
                        {
                            $required = array_merge(array('sender_name', 'sender_surname'), $required);
                        }

                        foreach ($required as $field)
                        {
                            if (!$this->config->get($field))
                            {
                                $request->setError('config{' . $field . '}', $i18n->__('Proszę uzupełnić pole.'));
                            }
                        }
                    }

                    try
                    {
                        $organizations = $api->getOrganizations();

                        $request->setParameter('organizations', $organizations, 'soteshop/stInPostApi');
                    }
                    catch(stInPostApiException $e)
                    {
                        $request->setError('api', $e->getMessage());
                    }
                }
            }
        }

        if ($this->config->get('enabled') && $this->config->get('token') && !$request->hasErrors() && !$api->isValid())
        {
            $request->setError('api', $api->getLastErrorMessage());
        }

        return !$request->hasErrors();
    }

    protected function updateConfigFromRequest()
    {
        parent::updateConfigFromRequest();

        $data = $this->getRequestParameter('config');

        if (isset($data['payment']))
        {
            $tokens = stJQueryToolsHelper::parseTokensFromRequest($data['payment']);      

            $payments = array();

            foreach ($tokens as $token)
            {
                $payments[] = $token['id'];
            }

            $this->config->set('payment', $payments);
        }

        $this->updateSenderFromOrganization();
    }

    protected function updateOrderStatus(Order $order)
    {
        $config = stConfig::getInstance('stPaczkomatyBackend');

        if ($config->get('order_status') && $order->getOrderStatusId() != $config->get('order_status'))
        {
            $order->setOrderStatusId($config->get('order_status'));
            $order->save();

            if ($order->getOrderStatus()->getHasMailNotification())
            {
                $user = sfContext::getInstance()->getUser();

                $module = 'stOrder';

                $culture = $this->getUser()->getCulture();

                if ($order->getClientCulture())
                {
                    $this->getUser()->setCulture($order->getClientCulture());
                }

                if (!$user->hasParameter($module, 'stAdminGeneratPlugin/generate'))
                {
                    $user->setParameter($module, true,'stAdminGeneratPlugin/generate');
        
                    $x = sfConfigCache::getInstance()->checkConfig(sfConfig::get('sf_app_module_dir_name').'/'.$module.'/'.sfConfig::get('sf_app_module_config_dir_name').'/generator.yml', true);
        
                    if (!empty($x))
                    {
                        require($x);
                    }
                }

                $orderActions = $this->getController()->getAction($module, 'mode');

                $this->getController()->getActionStack()->addEntry($module, 'mode', $orderActions);
                $orderActions->sendOrderStatus($order);
                $this->getController()->getActionStack()->popEntry();

                $this->getUser()->setCulture($culture);   
            }   
        }  
    }

    protected function saveConfig() 
    {      
        $ret = parent::saveConfig();
        stTheme::clearSmartyCache(true);

        return $ret;
    }


    protected function updateSenderFromOrganization()
    {
        $organizations = $this->getRequest()->getParameter('organizations', null, 'soteshop/stInPostApi');

        if ($organizations && !$this->config->get('organization'))
        {
            $organization = $organizations->items[0];

            $this->config->set('organization', $organization->id);
            $this->config->set('sender_company', $organization->name);
            $this->config->set('sender_street', $organization->address->street);
            $this->config->set('sender_building', $organization->address->building_number); 
            $this->config->set('sender_post_code', $organization->address->post_code); 
            $this->config->set('sender_country_code', $organization->address->country_code); 
            $this->config->set('sender_city', $organization->address->city);   
            $this->config->set('sender_email', $organization->contact_person->email); 
            $this->config->set('sender_phone', $organization->contact_person->phone); 
            $this->config->set('sender_name', $organization->contact_person->first_name); 
            $this->config->set('sender_surname', $organization->contact_person->last_name); 
            $this->config->set('services', $organization->services);            
        }
    }

    protected function updatePaczkomatyPackFromRequest()
    {
        parent::updatePaczkomatyPackFromRequest();

        $paczkomaty_pack = $this->getRequestParameter('paczkomaty_pack');

        foreach (array('customer_email', 'customer_phone', 'customer_paczkomat', 'use_sender_paczkomat', 'sender_paczkomat', 'pack_type', 'insurance', 'cash_on_delivery', 'description') as $v) {
            if (isset($paczkomaty_pack[$v]))
            {
                call_user_func(array($this->paczkomaty_pack, sfInflector::camelize('set_'.$v)), $paczkomaty_pack[$v]);
            }
        }
    }

    protected function getLabels()
    {
        $labels = parent::getLabels();
        
        $labels['api'] = 'InPost';

        return $labels;
    }

    protected function getConfigLabels()
    {
        $labels = parent::getConfigLabels();

        $labels['api'] = 'InPost';

        return $labels;
    }
}
