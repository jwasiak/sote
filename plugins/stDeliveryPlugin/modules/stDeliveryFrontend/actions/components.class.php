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
 * @version     $Id: components.class.php 14599 2011-08-17 13:19:16Z marcin $
 */

/**
 * Akcje komponentu produktu
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stDeliveryPlugin
 * @subpackage  actions
 */
class stDeliveryFrontendComponents extends sfComponents
{

   /**
    * Podsumowanie koszyka
    */
   public function executeBasketSummary()
   {
      $this->smarty = new stSmarty('stDeliveryFrontend');

      $dispatcher = $this->getController()->getDispatcher();
      $dispatcher->notify(new sfEvent($this, 'stDeliveryFrontendComponents.preExecuteBasketSummary'));

      $this -> config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
      $this -> config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());

      $this->discount_coupon_code = st_get_component('stDiscountFrontend', 'couponCode', array('return_url' => 'stBasket/index'));       
      $this->gift_card = st_get_component('stGiftCardFrontend', 'show', array('return_url' => 'stBasket/index'));

      $this->delivery = stDeliveryFrontend::getInstance($this->basket);
   }

   public function executeBasketDeliveryList()
   {
      $this->smarty = new stSmarty('stDeliveryFrontend');

      $this->delivery = stDeliveryFrontend::getInstance($this->basket);

      $this->config = stConfig::getInstance('stDeliveryBackend');
   }

   /**
    * Wyświetlenie listy płatności
    */
   public function executeBasketPaymentList()
   {
      $i18n = $this->getContext()->getI18N();

      $this->smarty = new stSmarty('stDeliveryFrontend');

      $this->delivery_payments = array();

      $this->delivery = stDeliveryFrontend::getInstance($this->basket);

      if ($this->delivery->hasDeliveries())
      {
         $default_delivery = $this->delivery->getDefaultDelivery();

         $total_amount = $this->basket->getTotalAmount(true, true) + $default_delivery->getTotalCost(true, true);

         if (stGiftCardPlugin::isActive() && stGiftCardPlugin::calculateAmountLeft($total_amount) == 0)
         {
            $pt = new PaymentType();

            $pt->setName($i18n->__('Bony zakupowe'));

            $dhp = new DeliveryHasPaymentType();

            $dhp->setIsActive(true);

            $dhp->setDelivery($default_delivery);

            $dhp->setPaymentType($pt);

            $dp = new stDeliveryPaymentFrontendContainer($this->delivery, $dhp);

            $this->delivery->getDefaultDelivery()->setDefaultPayment($dhp);

            $this->delivery_payments = array($dp);
         }
         else
         {
            $this->delivery_payments = $this->delivery->getDefaultDelivery()->getDeliveryPayments();
         }
      }
   }

   /**
    * Data i czas dostawy
    */
   public function executeDateTime()
   {
      $this->smarty = new stSmarty('stDeliveryFrontend');

      $this->language = $this->getUser()->getCulture();
      


      $config = stConfig::getInstance($this->getContext(), 'stDeliveryBackend');

      $this->config = $config;

      $deliveryFromRequest = $this->getRequestParameter('delivery');

      if ($deliveryFromRequest['time'] != "")
      {
         $time = explode(":", $deliveryFromRequest['time']);
         $this->time_h_def = $time[0];
         $this->time_m_def = $time[1];
      }
      else
      {
         $this->time_h_def = $config->get('time_h_def');
         $this->time_m_def = $config->get('time_m_def');
      }

      $dates_array = array();

      $dates_array[] = $this->dates_inbetween($config->get('array1_from'), $config->get('array1_to'));
      $dates_array[] = $this->dates_inbetween($config->get('array2_from'), $config->get('array2_to'));
      $dates_array[] = $this->dates_inbetween($config->get('array3_from'), $config->get('array3_to'));
      $dates_array[] = $this->dates_inbetween($config->get('array4_from'), $config->get('array4_to'));
      $dates_array[] = $this->dates_inbetween($config->get('array5_from'), $config->get('array5_to'));
      $dates_array[] = $this->dates_inbetween($config->get('array6_from'), $config->get('array6_to'));

      foreach ($dates_array as $dates)
      {
         foreach ($dates as $date)
         {
            if ($date != '01-01-1970')
            {
               $allowed_dates.='{"allow_date":"' . $date . '"},';
            }
         }
      }

      $dates = array(
          array('from' => $config->get('array1_from'), 'to' => $config->get('array1_to')),
          array('from' => $config->get('array2_from'), 'to' => $config->get('array2_to')),
          array('from' => $config->get('array3_from'), 'to' => $config->get('array3_to')),
          array('from' => $config->get('array4_from'), 'to' => $config->get('array4_to')),
          array('from' => $config->get('array5_from'), 'to' => $config->get('array5_to')),
          array('from' => $config->get('array6_from'), 'to' => $config->get('array6_to')),

      );
      
      foreach ($dates as $k => $date)
      {
         $dates[$k]['from'] = strtotime($date['from']);
         $dates[$k]['to'] = strtotime($date['to']);
      }

      
      

      $time_limit=$config->get('time_h_limit').$config->get('time_m_limit');

      $current = time();

      if(date('Hi')>=$time_limit)
      {
         $current += 60*60*24;
         
         $new_min = $config->get('min');
      }else{
         $new_min = $config->get('min')-1;
      }
      
      $min = strtotime(date('d-m-Y', time()+ 60*60*24*$new_min));

      $current = strtotime(date('d-m-Y',$current));


      if ($deliveryFromRequest['date'] != "")
      {
         $this->default_date = $deliveryFromRequest['date'];
      }
      else
      {
         $this->default_date = date('d-m-Y', $this->getCurrentDate($current, $dates, $min, $config->get('weekends_on')));
      }

      $today = strtotime(date('d-m-Y'));

      $today_and_max = $today + $config->get('max')*(60*60*24);

      $today_and_max = date('d-m-Y', $today_and_max);

      $off_date_picker = 0;

      

      if(strtotime($this->default_date) > strtotime($today_and_max))
      {         
         $off_date_picker = 1;
      }

      $this->off_date_picker = $off_date_picker;
      

      if (isset($allowed_dates))
      {
         $this->allowed_dates = $allowed_dates;
      }


   }

   protected function getCurrentDate($current_date, $allowed_dates, $min, $weekend)
   {
       
      // echo $weekend;
      
      $ok = true;
      

      if ($current_date > $min)
      {
         foreach ($allowed_dates as $allow_date)
         {
            if ($current_date >= $allow_date['from'] && $current_date <= $allow_date['to'])
            {
               $ok = false;

               break;
            }
         }
      }
      else
      {
         $ok = false;
      }


      if ($ok)
      {

        if($weekend==1){
            //echo $current_date;
            
            $w = date('w', $current_date);  
                        
            if($w == 0 || $w == 6){                
                return $this->getCurrentDate($current_date + 60 * 60 * 24, $allowed_dates, $min, $weekend);
            }  else{
                return $current_date;                
            }
        }else{
            return $current_date;
        }

      }else{
        return $this->getCurrentDate($current_date + 60 * 60 * 24, $allowed_dates, $min, $weekend);    
      }

      
   }

   function dates_inbetween($date1, $date2)
   {

      $day = 60 * 60 * 24;

      $date1 = strtotime($date1);
      $date2 = strtotime($date2);

      $days_diff = round(($date2 - $date1) / $day); // Unix time difference devided by 1 day to get total days in between

      $dates_array = array();

      $dates_array[] = date('d-m-Y', $date1);

      for ($x = 1; $x < $days_diff; $x++)
      {
         $dates_array[] = date('d-m-Y', ($date1 + ($day * $x)));
      }

      $dates_array[] = date('d-m-Y', $date2);

      return $dates_array;
   }

}