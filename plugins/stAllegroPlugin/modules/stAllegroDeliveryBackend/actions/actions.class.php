<?php

class stAllegroDeliveryBackendActions extends stActions 
{
    public function executeList()
    {
        try
        {
            $api = stAllegroApi::getInstance();

            $this->shippingRates = $api->getShippingRates();
        }
        catch(stAllegroException $e)
        {
            $messages = array();

            foreach (stAllegroApi::getLastErrors() as $error)
            {
                $messages[] = $error->userMessage;
            }

            $this->setFlash('warning', implode('<br>', $messages));

            return $this->redirect('@stAllegroPlugin?action=config');           
        }
    }

    public function executeDelete()
    {
    }

    public function executeEdit()
    {
        try
        {
            $api = stAllegroApi::getInstance();

            $id = $this->getRequestParameter('id');

            if ($id)
            {
                $this->shippingRate = $api->getShippingRate($id);

                $rates = array();

                foreach ($this->shippingRate->rates as $methodId => $rate)
                {
                    $rates[$methodId] = array(
                        'first_item_rate' => array(
                            'amount' => $rate->firstItemRate->amount, 
                            'currency' => $rate->firstItemRate->currency, 
                            'default' => 0.00
                        ),
                        'next_item_rate' => array(
                            'amount' => $rate->nextItemRate->amount,
                            'currency' => $rate->firstItemRate->currency,
                            'default' => 0.00
                        ),
                        'max_quantity_per_package' => $rate->maxQuantityPerPackage,
                    );
                }

                $this->delivery = array(
                    'name' => $this->shippingRate->name,
                    'rates' => $rates,
                );
            }
            else
            {
                $this->delivery = array(
                    'name' => '',
                    'rates' => array(),
                );
            }

            if ($this->getRequest()->getMethod() == sfRequest::POST)
            {
                $i18n = $this->getContext()->getI18N();

                $this->updateDeliveryFromRequest();

                try
                {
                    if ($id)
                    {
                        $response = $api->updateShippingRate($id, $this->delivery);
                    }
                    else
                    {
                        $response = $api->createShippingRate($this->delivery);
                    }
                }
                catch (Exception $e)
                {
                    foreach (stAllegroApi::getLastErrors() as $error)
                    {
                        $error->path = str_replace("items[", "rates[", $error->path);

                        if ($error->path == "name")
                        {
                            $error->path = "delivery{name}";
                        }
                        
                        $this->getRequest()->setError($error->path, $error->userMessage);
                    }
                }   

                if (!$this->getRequest()->hasErrors())
                {
                    $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
                    return $this->redirect('@stAllegroDelivery?action=edit&id=' . $response->id);
                }
            }

            $this->labels = $this->getLabels();
            // die("<pre>".var_export($this->deliveryGroups, true)."</pre>");
        }
        catch(stAllegroException $e)
        {
            $messages = array();

            foreach (stAllegroApi::getLastErrors() as $error)
            {
                $messages[] = $error->userMessage;
            }

            $this->setFlash('warning', implode('<br>', $messages));
            
            return $this->redirect('@stAllegroPlugin?action=config');           
        }
    }

    public function getLabels()
    {
        $labels = array();

        return $labels;
    }

    public function updateDeliveryFromRequest()
    {
        $delivery = $this->getRequestParameter('delivery');
        
        $this->delivery = $delivery;
    }
}
