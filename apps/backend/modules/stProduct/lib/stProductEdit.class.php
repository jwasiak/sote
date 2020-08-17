<?php 
class stProductEdit
{
   public static function getCurrency()
   {
         $arr = array();

         $currencies = CurrencyPeer::doSelect(new Criteria());

         foreach ($currencies as $currency)
         {
            if ($currency->getIsSystemCurrency())
            {
               $arr['system_currency_id'] = $currency->getId();
            }

            $arr['exchange_rates'][$currency->getId()] = $currency->getExchangeBackend();

            $arr['select_options'][$currency->getId()] = $currency->getNameBackend();
         }

         $arr['exchange_rates'] = json_encode($arr['exchange_rates']);      

         return $arr;
   }   
}