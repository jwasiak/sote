<?php

/**
 * SOTESHOP/stDelivery
 *
 * Ten plik należy do aplikacji stDelivery opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stDeliveryPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 14270 2011-07-22 12:09:39Z bartek $
 * @author      Marcin Olejnczak <marcin.olejniczak@sote.pl>
 */

/**
 * Delivery actions.
 *
 * @author Marcin Olejnczak <marcin.olejniczak@sote.pl>
 *
 * @package     stDeliveryPlugin
 * @subpackage  actions
 */
class stDeliveryBackendActions extends autoStDeliveryBackendActions
{

   protected function updateConfigFromRequest()
   {
      parent::updateConfigFromRequest();

      $config = $this->getRequestParameter('config');

      $ids = stJQueryToolsHelper::parseTokensFromRequest($config['alternate_deliveries'], true);
      
      $this->config->set('alternate_deliveries', $ids, false);
      
   }  

   public function validateEdit()
   {
      $request = $this->getRequest();

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $nv = new sfNumberValidator();

         $nv->initialize($this->getContext(), array(
             'min_error' => 'Wartość pola "%s" nie może być ujemna',
             'nan_error' => 'Wartość pola "%s" posiada nieprawidłowy format (prawidłowy format: 10, 10.00)',
             'min' => 0,
             'type' => 'any'
         ));

         $sections = $this->getRequestParameter('delivery[sections]', array());

         $type = DeliveryTypePeer::retrieveTypeById($request->getParameter('delivery[type_id]'));

         if (($type == 'ppk' || $type == 'ppo'))
         {
             $params = $request->getParameter('delivery');

             if (!isset($params['params']['usluga']) || $params['params']['usluga'] === "")
             {
                 $request->setError('delivery{pp_usluga}', 'Musisz wybrać usługę dla Poczty Polskiej');
             }
         }

         if ($request->getParameter('delivery[section_cost_type]'))
         {
            if (empty($sections))
            {
               $request->setError('delivery{sections}', 'Musisz zdefiniować przynajmniej jeden koszt dodatkowy');
            }
            else
            {
               foreach ($sections as $k1 => $v1)
               {
                  if (!$nv->execute($v1['from'], $error))
                  {
                     $request->setError('delivery{sections}{'.$k1.'}{from}', sprintf($error, 'Od'));

                     $request->setError('delivery{sections}', 'Popraw błędy');
                  }

                  if (!$nv->execute($v1['cost_netto'], $error))
                  {
                     $request->setError('delivery{sections}{'.$k1.'}{cost_netto}', sprintf($error, 'Koszt'));

                     $request->setError('delivery{sections}', 'Popraw błędy');
                  }

                  if (!$nv->execute($v1['cost_brutto'], $error))
                  {
                     $request->setError('delivery{sections}{'.$k1.'}{cost_brutto}', sprintf($error, 'Koszt'));

                     $request->setError('delivery{sections}', 'Popraw błędy');
                  }


                  foreach ($sections as $k2 => $v2)
                  {
                     if ($request->hasError('delivery{sections}{'.$k1.'}{from}'))
                        continue;

                     if ($k1 != $k2 && floatval($v1['from']) == floatval($v2['from']))
                     {
                        $request->setError('delivery{sections}{'.$k1.'}{from}', 'Wartości pola "Od" nie mogą być takie same');

                        $request->setError('delivery{sections}', 'Popraw błędy');

                        break;
                     }
                  }
               }
            }
         }

         $payments = $this->getRequestParameter('delivery[payments]', array());

         $one_payment_active = false;

         foreach ($payments as $payment)
         {
            if (isset($payment['is_active']))
            {
               $one_payment_active = true;

               break;
            }
         }

         if (!$one_payment_active)
         {
            $request->setError('delivery{payments}', 'Musisz aktywować przynajmniej jedną płatność');
         }
         else
         {
            foreach ($payments as $k => $payment)
            {
               if (!isset($payment['is_active']))
                  continue;

               if (!$nv->execute($payment['free_from'], $error))
               {
                  $request->setError('delivery{payments}{'.$k.'}{free_from}', sprintf($error, 'Darmowa od'));

                  $request->setError('delivery{payments}', 'Popraw błędy');
               }


               if (!$nv->execute($payment['cost_netto'], $error))
               {
                  $request->setError('delivery{payments}{'.$k.'}{cost_netto}', sprintf($error, 'Koszt'));

                  $request->setError('delivery{payments}', 'Popraw błędy');
               }

               if (!$nv->execute($payment['cost_brutto'], $error))
               {
                  $request->setError('delivery{payments}{'.$k.'}{cost_brutto}', sprintf($error, 'Koszt'));

                  $request->setError('delivery{payments}', 'Popraw błędy');
               }
            }
         }
      }

      return!$request->hasErrors();
   }

   protected function updateDeliveryFromRequest()
   {
      parent::updateDeliveryFromRequest();

      $delivery = $this->getRequestParameter('delivery');

      $this->delivery->setCostNetto($delivery['cost_netto']);

      $this->delivery->setCostBrutto($delivery['cost_brutto']);

      $this->delivery->setSectionCostType(!empty($delivery['section_cost_type']) ? $delivery['section_cost_type'] : null);

      $this->delivery->setIsDefault(isset($delivery['is_default']) ? $delivery['is_default'] : null);

      if (isset($delivery['min_order_quantity']))
      {
         $this->delivery->setMinOrderQuantity($delivery['min_order_quantity']);
      }
      
      if (isset($delivery['min_order_weight']))
      {      
         $this->delivery->setMinOrderWeight($delivery['min_order_weight']);
      }
      
      if (isset($delivery['min_order_amount']))
      {      
         $this->delivery->setMinOrderAmount($delivery['min_order_amount']);
      }      
      
      if (isset($delivery['max_order_quantity']))
      {
         $this->delivery->setMaxOrderQuantity($delivery['max_order_quantity']);
      }

      if (isset($delivery['max_order_weight']))
      {
         $this->delivery->setMaxOrderWeight($delivery['max_order_weight']);
      }
      
      if (isset($delivery['max_order_amount']))
      {      
         $this->delivery->setMaxOrderAmount($delivery['max_order_amount']);
      }

      if (isset($delivery['params']))
      {
          $this->delivery->setParams($delivery['params']);
      }
      else
      {
          $this->delivery->setParams(null);
      }

      $this->delivery->setCountriesAreaId(isset($delivery['countries_area_id']) ? $delivery['countries_area_id'] : null);

      if ($this->delivery->isType('inpostp'))
      {
         $this->delivery->setPaczkomatyType('ALL');
         $this->delivery->setPaczkomatySize($delivery['paczkomaty_size']);
         $dimensions = json_decode($delivery['paczkomaty_dimension']);
         $this->delivery->setWidth($dimensions[1]);
         $this->delivery->setHeight($dimensions[0]);
         $this->delivery->setDepth($dimensions[2]);
      }
      else
      {
         $this->delivery->setPaczkomatyType('NONE');
         $this->delivery->setPaczkomatySize(null);
      }
   }

   /**
    *
    * @param Delivery $delivery
    */
   protected function saveDelivery($delivery)
   {
      parent::saveDelivery($delivery);

      $this->savePayment($delivery);
      $this->saveSections($delivery);
   }

   protected function savePayment($delivery)
   {
      $delivery_payments = $this->getRequestParameter('delivery[payments]', array());

      $is_default_payment = $this->getRequestParameter('delivery[is_default_payment]');

      $c = new Criteria();

      $c->add(DeliveryHasPaymentTypePeer::DELIVERY_ID, $delivery->getId());

      DeliveryHasPaymentTypePeer::doDelete($c);

      foreach ($delivery_payments as $payment_id => $delivery_payment)
      {
         $dhp = new DeliveryHasPaymentType();

         $dhp->setDeliveryId($delivery->getId());

         $dhp->setPaymentTypeId($payment_id);

         $dhp->setCostNetto($delivery_payment['cost_type'] == '%' ? $delivery_payment['cost_brutto'] : $delivery_payment['cost_netto']);

         $dhp->setCostBrutto($delivery_payment['cost_brutto']);

         $dhp->setFreeFrom($delivery_payment['free_from']);

         $dhp->setCostType($delivery_payment['cost_type']);

         $dhp->setIsDefault($is_default_payment == $payment_id);

         $dhp->setIsActive(isset($delivery_payment['is_active']));

         $dhp->setCourierCost($delivery_payment['courier_cost']);

         $dhp->save();
      }
   }

   protected function saveSections($delivery)
   {
      $delivery_sections = $this->getRequestParameter('delivery[sections]', array());

      $c = new Criteria();

      $c->add(DeliverySectionsPeer::DELIVERY_ID, $delivery->getId());

      DeliverySectionsPeer::doDelete($c);

      if ($this->getRequestParameter('delivery[section_cost_type]'))
      {
         foreach ($delivery_sections as $delivery_section)
         {
            $ds = new DeliverySections();

            $ds->setFrom($delivery_section['from']);

            $ds->setCostNetto($delivery_section['cost_netto']);

            $ds->setCostBrutto($delivery_section['cost_brutto']);

            $ds->setDeliveryId($delivery->getId());

            $ds->save();
         }
      }
   }

   protected function getLabels()
   {
      $labels = parent::getLabels();

      $labels['delivery{sections}'] = $labels['delivery{edit_additional_cost}'];

      $labels['delivery{payments}'] = $labels['delivery{edit_payment}'];

      $labels['delivery{max_order_quantity}'] = 'Ukryj wyświetlanie';

      $labels['delivery{max_order_amount}'] = 'Ukryj wyświetlanie';

      $labels['delivery{max_order_weight}'] = 'Ukryj wyświetlanie';

      $labels['delivery{countries_area_id}'] = 'Strefa';

      return $labels;
   }

   public function executeSaveConfig()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {              
            $this->config = stConfig::getInstance($this->getContext(), 'stDeliveryBackend');

            $configFromRequest = $this->getRequestParameter('dateTime', array());

            
            $this->config->setFromRequest('dateTime');

            if(isset($configFromRequest['array1_from'])){
                $this->config->set('array1_from',$this->chacekFormat($configFromRequest['array1_from']));
            }

            if(isset($configFromRequest['array1_to'])){
                $this->config->set('array1_to',$this->chacekFormat($configFromRequest['array1_to']));
            }

            if(isset($configFromRequest['array2_from'])){
                $this->config->set('array2_from',$this->chacekFormat($configFromRequest['array2_from']));
            }

            if(isset($configFromRequest['array2_to'])){
                $this->config->set('array2_to',$this->chacekFormat($configFromRequest['array2_to']));
            }

            if(isset($configFromRequest['array3_from'])){
                $this->config->set('array3_from',$this->chacekFormat($configFromRequest['array3_from']));
            }

            if(isset($configFromRequest['array3_to'])){
                $this->config->set('array3_to',$this->chacekFormat($configFromRequest['array3_to']));
            }

            if(isset($configFromRequest['array4_from'])){
                $this->config->set('array4_from',$this->chacekFormat($configFromRequest['array4_from']));
            }

            if(isset($configFromRequest['array4_to'])){
                $this->config->set('array4_to',$this->chacekFormat($configFromRequest['array4_to']));
            }

            if(isset($configFromRequest['array5_from'])){
                $this->config->set('array5_from',$this->chacekFormat($configFromRequest['array5_from']));
            }

            if(isset($configFromRequest['array5_to'])){
                $this->config->set('array5_to',$this->chacekFormat($configFromRequest['array5_to']));
            }

            if(isset($configFromRequest['array6_from'])){
                $this->config->set('array6_from',$this->chacekFormat($configFromRequest['array6_from']));
            }

            if(isset($configFromRequest['array6_to'])){
                $this->config->set('array6_to',$this->chacekFormat($configFromRequest['array6_to']));
            }

            $this->config->save();



            $this->setFlash('notice', 'Twoje zmiany zostały zapisane');

            $this->redirect('delivery/configCustom');
      }
   }

    public function validateSaveConfig()
    {

        $error_exists = false;

        $i18n = $this->getContext()->getI18N();

        $configFromRequest = $this->getRequestParameter('dateTime', array());

        if($configFromRequest['time_h_to'].$configFromRequest['time_m_to']<$configFromRequest['time_h_from'].$configFromRequest['time_m_from'])
        {
            $this->getRequest()->setError('dateTime{time_h_from}', $i18n->__('Godzina rozpoczęcia musi być mniejsza od godziny zakończenia.'));
            $this->getRequest()->setError('dateTime{time_h_to}', $i18n->__('Godzina rozpoczęcia musi być mniejsza od godziny zakończenia.'));

            $error_exists = true;
        }


        if($configFromRequest['time_h_limit']>'23' || $configFromRequest['time_h_limit']=="")
        {
           if($configFromRequest['time_h_limit']=="")
           {
               $this->getRequest()->setError('dateTime{time_h_limit}', $i18n->__('Pole nie może być puste.'));
           }
           else
           {
               $this->getRequest()->setError('dateTime{time_h_limit}', $i18n->__('Godzina nie może być większa niż 23.'));
           }
            
            $error_exists = true;
        }

        if($configFromRequest['time_h_limit']<'0')
        {
           $this->getRequest()->setError('dateTime{time_h_limit}', $i18n->__('Czas nie może być ujemny.'));

           $error_exists = true;
        }

         if(!preg_match("/^[0-9]+$/",$configFromRequest['time_h_limit']))
         {
               $this->getRequest()->setError('dateTime{time_h_limit}', $i18n->__('Wartość musi być liczbą.'));

               $error_exists = true;
         }


        if($configFromRequest['time_m_limit']>'59' || $configFromRequest['time_m_limit']=="")
        {
           if($configFromRequest['time_m_limit']=="")
           {
               $this->getRequest()->setError('dateTime{time_m_limit}', $i18n->__('Pole nie może być puste.'));
           }
           else
           {
            $this->getRequest()->setError('dateTime{time_m_limit}', $i18n->__('Minut nie może być więcej niż 59.'));
           }
            $error_exists = true;
        }

        if($configFromRequest['time_m_limit']<'0')
        {
           $this->getRequest()->setError('dateTime{time_m_limit}', $i18n->__('Czas nie może być ujemny.'));

           $error_exists = true;
        }

        if(!preg_match("/^[0-9]+$/",$configFromRequest['time_m_limit']))
        {
               $this->getRequest()->setError('dateTime{time_m_limit}', $i18n->__('Wartość musi być liczbą.'));

               $error_exists = true;
        }

        if($configFromRequest['time_h_from']>'23' || $configFromRequest['time_h_from']=="")
        {
           if($configFromRequest['time_h_from']=="")
           {
               $this->getRequest()->setError('dateTime{time_h_from}', $i18n->__('Pole nie może być puste.'));
           }
           else
           {
            $this->getRequest()->setError('dateTime{time_h_from}', $i18n->__('Godzina nie może być większa niż 23.'));
           }
           $error_exists = true;
        }

        if($configFromRequest['time_h_from']<'0')
        {
           $this->getRequest()->setError('dateTime{time_h_from}', $i18n->__('Czas nie może być ujemny.'));

           $error_exists = true;
        }

        if(!preg_match("/^[0-9]+$/",$configFromRequest['time_h_from']))
        {
               $this->getRequest()->setError('dateTime{time_h_from}', $i18n->__('Wartość musi być liczbą.'));

               $error_exists = true;
        }

        if($configFromRequest['time_m_from']>'59' || $configFromRequest['time_m_from']=="")
        {
           if($configFromRequest['time_m_from']=="")
           {
               $this->getRequest()->setError('dateTime{time_m_from}', $i18n->__('Pole nie może być puste.'));
           }
           else
           {
               $this->getRequest()->setError('dateTime{time_m_from}', $i18n->__('Minut nie może być więcej niż 59.'));
           }
           $error_exists = true;
        }

        if($configFromRequest['time_m_from']<'0')
        {
           $this->getRequest()->setError('dateTime{time_m_from}', $i18n->__('Czas nie może być ujemny.'));

           $error_exists = true;
        }

        if(!preg_match("/^[0-9]+$/",$configFromRequest['time_m_from']))
        {
               $this->getRequest()->setError('dateTime{time_m_from}', $i18n->__('Wartość musi być liczbą.'));

               $error_exists = true;
        }

        if($configFromRequest['time_h_to']>'23' || $configFromRequest['time_h_to']=="")
        {
           if($configFromRequest['time_h_to']=="")
           {
               $this->getRequest()->setError('dateTime{time_h_to}', $i18n->__('Pole nie może być puste.'));
           }
           else
           {
            $this->getRequest()->setError('dateTime{time_h_to}', $i18n->__('Godzina nie może być większa niż 23.'));
           }
            $error_exists = true;
        }

        if($configFromRequest['time_h_to']<'0')
        {
           $this->getRequest()->setError('dateTime{time_h_to}', $i18n->__('Czas nie może być ujemny.'));

           $error_exists = true;
        }

        if(!preg_match("/^[0-9]+$/",$configFromRequest['time_h_to']))
        {
               $this->getRequest()->setError('dateTime{time_h_to}', $i18n->__('Wartość musi być liczbą.'));

               $error_exists = true;
        }

        if($configFromRequest['time_m_to']>'59' || $configFromRequest['time_m_to']=="")
        {
           if($configFromRequest['time_m_to']=="")
           {
               $this->getRequest()->setError('dateTime{time_m_to}', $i18n->__('Pole nie może być puste.'));
           }
           else
           {
               $this->getRequest()->setError('dateTime{time_m_to}', $i18n->__('Minut nie może być więcej niż 59.'));
           }
            $error_exists = true;
        }

        if($configFromRequest['time_m_to']<'0')
        {
           $this->getRequest()->setError('dateTime{time_m_to}', $i18n->__('Czas nie może być ujemny.'));

           $error_exists = true;
        }

        if(!preg_match("/^[0-9]+$/",$configFromRequest['time_m_to']))
        {
               $this->getRequest()->setError('dateTime{time_m_to}', $i18n->__('Wartość musi być liczbą.'));

               $error_exists = true;
        }



        if($configFromRequest['time_h_def']>'23' || $configFromRequest['time_h_def']=="")
        {
           if($configFromRequest['time_h_def']=="")
           {
               $this->getRequest()->setError('dateTime{time_h_def}', $i18n->__('Pole nie może być puste.'));
           }
           else
           {
            $this->getRequest()->setError('dateTime{time_h_def}', $i18n->__('Godzina nie może być większa niż 23.'));
           }
            $error_exists = true;
        }

        if($configFromRequest['time_h_def']<'0')
        {
           $this->getRequest()->setError('dateTime{time_h_def}', $i18n->__('Czas nie może być ujemny.'));

           $error_exists = true;
        }

        if(!preg_match("/^[0-9]+$/",$configFromRequest['time_h_def']))
        {
               $this->getRequest()->setError('dateTime{time_h_def}', $i18n->__('Wartość musi być liczbą.'));

               $error_exists = true;
        }

        if($configFromRequest['time_m_def']>'59' || $configFromRequest['time_m_def']=="")
        {
           if($configFromRequest['time_m_def']=="")
           {
               $this->getRequest()->setError('dateTime{time_m_def}', $i18n->__('Pole nie może być puste.'));
           }
           else
           {
            $this->getRequest()->setError('dateTime{time_m_def}', $i18n->__('Minut nie może być więcej niż 59.'));
           }
            $error_exists = true;
        }

        if($configFromRequest['time_m_def']<'0')
        {
           $this->getRequest()->setError('dateTime{time_m_def}', $i18n->__('Czas nie może być ujemny.'));

           $error_exists = true;
        }

        if(!preg_match("/^[0-9]+$/",$configFromRequest['time_m_def']))
        {
               $this->getRequest()->setError('dateTime{time_m_def}', $i18n->__('Wartość musi być liczbą.'));

               $error_exists = true;
        }

        if($configFromRequest['time_h_def'].$configFromRequest['time_m_def'] < $configFromRequest['time_h_from'].$configFromRequest['time_m_from'] || $configFromRequest['time_h_def'].$configFromRequest['time_m_def'] > $configFromRequest['time_h_to'].$configFromRequest['time_m_to'])
        {
            $this->getRequest()->setError('dateTime{time_h_def}', $i18n->__('Godzina domyślna musi się zawierać w przedziale od min do max.'));
          
            $error_exists = true;
        }



        if($this->chacekFormat($configFromRequest['array1_from']) > $this->chacekFormat($configFromRequest['array1_to']) || $this->chacekFormat($configFromRequest['array1_from'])=="" && $this->chacekFormat($configFromRequest['array1_to'])!=="")
        {
            $this->getRequest()->setError('dateTime{array1_from}', $i18n->__('Określono zły przedział.'));
            $error_exists = true;
        }

        if($this->chacekFormat($configFromRequest['array2_from']) > $this->chacekFormat($configFromRequest['array2_to']) || $this->chacekFormat($configFromRequest['array2_from'])=="" && $this->chacekFormat($configFromRequest['array2_to'])!=="")
        {
            $this->getRequest()->setError('dateTime{array2_from}', $i18n->__('Określono zły przedział.'));
            $error_exists = true;
        }


        if($this->chacekFormat($configFromRequest['array3_from']) > $this->chacekFormat($configFromRequest['array3_to']) || $this->chacekFormat($configFromRequest['array3_from'])=="" && $this->chacekFormat($configFromRequest['array3_to'])!=="")
        {
            $this->getRequest()->setError('dateTime{array3_from}', $i18n->__('Określono zły przedział.'));
            $error_exists = true;
        }

        if($this->chacekFormat($configFromRequest['array4_from']) > $this->chacekFormat($configFromRequest['array4_to']) || $this->chacekFormat($configFromRequest['array4_from'])=="" && $this->chacekFormat($configFromRequest['array4_to'])!=="")
        {
            $this->getRequest()->setError('dateTime{array4_from}', $i18n->__('Określono zły przedział.'));
            $error_exists = true;
        }

        if($this->chacekFormat($configFromRequest['array5_from']) > $this->chacekFormat($configFromRequest['array5_to']) || $this->chacekFormat($configFromRequest['array5_from'])=="" && $this->chacekFormat($configFromRequest['array5_to'])!=="")
        {
            $this->getRequest()->setError('dateTime{array5_from}', $i18n->__('Określono zły przedział.'));
            $error_exists = true;
        }

        if($this->chacekFormat($configFromRequest['array6_from']) > $this->chacekFormat($configFromRequest['array6_to']) || $this->chacekFormat($configFromRequest['array6_from'])=="" && $this->chacekFormat($configFromRequest['array6_to'])!=="")
        {
            $this->getRequest()->setError('dateTime{array6_from}', $i18n->__('Określono zły przedział.'));
            $error_exists = true;
        }

        if($configFromRequest['min']<'0' || $configFromRequest['min']=="" || !preg_match("/^[0-9]+$/",$configFromRequest['min']) || $configFromRequest['min']>$configFromRequest['max'])
        {


           if($configFromRequest['min']=="")
           {
               $this->getRequest()->setError('dateTime{min}', $i18n->__('Pole nie może być puste.'));
           }
           else
           {
               $this->getRequest()->setError('dateTime{min}', $i18n->__('Wartość nie może być mniejsza niż 0.'));
           }

           if($configFromRequest['min']>$configFromRequest['max'])
           {
              $this->getRequest()->setError('dateTime{min}', $i18n->__('Data zakończenia nie może być mniejsza od daty rozpoczęcia.'));
           }

           if(!preg_match("/^[0-9]+$/",$configFromRequest['min']))
           {
               $this->getRequest()->setError('dateTime{min}', $i18n->__('Wartość musi być liczbą.'));
           }

            $error_exists = true;
        }



        if($configFromRequest['max']<'0' || $configFromRequest['max']=="" || !preg_match("/^[0-9]+$/",$configFromRequest['max']) || $configFromRequest['min']>$configFromRequest['max'])
        {
           if($configFromRequest['max']=="")
           {
               $this->getRequest()->setError('dateTime{max}', $i18n->__('Pole nie może być puste.'));
           }
           else
           {
               $this->getRequest()->setError('dateTime{max}', $i18n->__('Wartość nie może być mniejsza niż 0.'));
           }

           if($configFromRequest['min']>$configFromRequest['max'])
           {
              $this->getRequest()->setError('dateTime{max}', $i18n->__('Data zakończenia nie może być mniejsza od daty rozpoczęcia.'));
           }

           if(!preg_match("/^[0-9]+$/",$configFromRequest['max']))
           {
               $this->getRequest()->setError('dateTime{max}', $i18n->__('Wartość musi być liczbą.'));
           }

            $error_exists = true;
        }



        return !$error_exists;
    }


    public function handleErrorSaveConfig()
    {
        $this->config = stConfig::getInstance($this->getContext(), 'stDeliveryBackend');

        $configFromRequest = $this->getRequestParameter('dateTime', array());
         
        $this->config->set('date_on',$configFromRequest['date_on']);
         
        $this->config->set('time_on',$configFromRequest['time_on']);
         

        if(isset($configFromRequest['min'])){
             $this->config->set('min',$configFromRequest['min']);
        }

        if(isset($configFromRequest['max'])){
             $this->config->set('max',$configFromRequest['max']);
        }

        $this->config->set('weekends_on',$configFromRequest['weekends_on']);
         
         if(isset($configFromRequest['time_h_from'])){
             $this->config->set('time_h_from',$configFromRequest['time_h_from']);
         }

         if(isset($configFromRequest['time_m_from'])){
             $this->config->set('time_m_from',$configFromRequest['time_m_from']);
         }

         if(isset($configFromRequest['time_h_to'])){
             $this->config->set('time_h_to',$configFromRequest['time_h_to']);
         }

         if(isset($configFromRequest['time_m_to'])){
             $this->config->set('time_m_to',$configFromRequest['time_m_to']);
         }

         if(isset($configFromRequest['time_h_def'])){
             $this->config->set('time_h_def',$configFromRequest['time_h_def']);
         }

         if(isset($configFromRequest['time_m_def'])){
             $this->config->set('time_m_def',$configFromRequest['time_m_def']);
         }

         if(isset($configFromRequest['time_h_limit'])){
             $this->config->set('time_h_limit',$configFromRequest['time_h_limit']);
         }

         if(isset($configFromRequest['time_m_limit'])){
             $this->config->set('time_m_limit',$configFromRequest['time_m_limit']);
         }

         if(isset($configFromRequest['array1_from'])){
             $this->config->set('array1_from',$configFromRequest['array1_from']);
         }

         if(isset($configFromRequest['array1_to'])){
             $this->config->set('array1_to',$configFromRequest['array1_to']);
         }

         if(isset($configFromRequest['array2_from'])){
             $this->config->set('array2_from',$this->chacekFormat($configFromRequest['array2_from']));
         }

         if(isset($configFromRequest['array2_to'])){
             $this->config->set('array2_to',$this->chacekFormat($configFromRequest['array2_to']));
         }

         if(isset($configFromRequest['array3_from'])){
             $this->config->set('array3_from',$this->chacekFormat($configFromRequest['array3_from']));
         }

         if(isset($configFromRequest['array3_to'])){
             $this->config->set('array3_to',$this->chacekFormat($configFromRequest['array3_to']));
         }

         if(isset($configFromRequest['array4_from'])){
             $this->config->set('array4_from',$this->chacekFormat($configFromRequest['array4_from']));
         }

         if(isset($configFromRequest['array4_to'])){
             $this->config->set('array4_to',$this->chacekFormat($configFromRequest['array4_to']));
         }

         if(isset($configFromRequest['array5_from'])){
             $this->config->set('array5_from',$this->chacekFormat($configFromRequest['array5_from']));
         }

         if(isset($configFromRequest['array5_to'])){
             $this->config->set('array5_to',$this->chacekFormat($configFromRequest['array5_to']));
         }

         if(isset($configFromRequest['array6_from'])){
             $this->config->set('array6_from',$this->chacekFormat($configFromRequest['array6_from']));
         }

         if(isset($configFromRequest['array6_to'])){
             $this->config->set('array6_to',$this->chacekFormat($configFromRequest['array6_to']));
         }

        return $this->forward('stDeliveryBackend', 'configCustom');
    }



    public function chacekDateFormat($val)
    {
       if($val!="")
        {

            if(strstr($val, "-")!==False)
            {
               $date = explode("-",$val);

               if($date[0]=="" || $date[1]=="" || $date[2]=="" || $date[1]>'12' || $date[2]>'31')
               {

                  return true;
               }
            }

        }

        return false;
    }

    public function chacekFormat($val)
    {
       if($val!="")
       {

            if(strstr($val, "-")!==False)
            {
              return $val;
            }

            if(strstr($val, "/")!==False)
            {
               $today_and_max = date('d-m-Y', $today_and_max);

               return $val;
            }

       }
       else
       {
          return $val;
       }

    }

}
