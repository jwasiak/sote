<?php

/**
 * SOTESHOP/stDelivery
 *
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stOrder
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stOrderHelper.php 13690 2011-06-20 06:58:55Z marcin $
 */


function getDeliveryDateFormat($date)
{
   if ($date)
   {    
      $date = explode(" ", $date);

      if($date[0]!="1999-11-30")
      {
         $date_format = explode("-",$date[0]);
         $delivery_date = $date_format[2]."-".$date_format[1]."-".$date_format[0];
      }
      else
      {
         $delivery_date = "";
      }

      if($date[1]!="00:00:00")
      {
         $time_format = explode(":",$date[1]);
         $delivery_time = $time_format[0].":".$time_format[1];
      }
      else
      {
         $delivery_time = "";
      }

      return $delivery_date." ".$delivery_time;
   }
   else
   {
      return '';
   }
}

function countries_select_tag($name, $selected = null)
{
   $countries = CountriesPeer::doSelectActiveCached();

   ob_start();

   foreach ($countries as $country)
   {
      if ($country->getId() == $selected)
      {
         echo '<option value="'.$country->getId().'" selected="selected">'.$country->getName().'</option>';         
      }
      else
      {
         echo '<option value="'.$country->getId().'">'.$country->getName().'</option>';
      }
   }   

   $options = ob_get_clean(); 

   return '<select class="form-control" name="'.$name.'" id="'.get_id_from_name($name).'">'.$options.'</select>';
}

function delivery_countries_select_tag($name, $selected = null)
{
   $basket = sfContext::getInstance()->getUser()->getBasket();

   $delivery = stDeliveryFrontend::getInstance($basket);

   $delivery_countries = $delivery->getDeliveryCountries(true);

   $options = '';

   ob_start();

   foreach ($delivery_countries as $country)
   {
      if ($country->getId() == $selected)
      {
         echo '<option value="'.$country->getId().'" selected="selected">'.$country->getName().'</option>';         
      }
      else
      {
         echo '<option value="'.$country->getId().'">'.$country->getName().'</option>';
      }
   } 

   $options = ob_get_clean();  

   return '<select class="form-control" name="'.$name.'" id="'.get_id_from_name($name).'">'.$options.'</select>';
}