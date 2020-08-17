<?php

/**
 * SOTESHOP/stOrder
 *
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stOrder
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: OrderPeer.php 13690 2011-06-20 06:58:55Z marcin $
 */

/**
 * SOTESHOP/stOrder
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stOrder
 * @subpackage  libs
 */
class OrderPeer extends BaseOrderPeer
{

   /**
    * Zwraca zamówienie na podstawie numeru
    *
    * @param   string      $number             Numer zamówienia
    * @return   Order
    */
   public static function retrieveByNumber($number)
   {
      $c = new Criteria();

      $c->add(self::NUMBER, $number);

      return self::doSelectOne($c);
   }

   /**
    * Zwraca zamówienie na podstawie id i ciągu hash
    *
    * @param   string      $id                 Id zamówienia
    * @param   string      $hash_code          Ciągu hash
    */
   public static function retrieveByIdAndHashCode($id, $hash_code)
   {
      $c = new Criteria();

      $c->add(self::ID, $id);

      $result = self::doSelectOne($c);

      return null !== $result && $result->getHashCode() == $hash_code ? $result : null; 
   }

   /**
    * Zwraca zamówienie na podstawie numeru i ciągu hash
    *
    * @param   string      $number             Numer zamówienia
    * @param   string      $hash_code          Ciągu hash
    */
   public static function retrieveByNumberAndHashCode($number, $hash_code)
   {
      $c = new Criteria();

      $c->add(self::NUMBER, $number);

      $result = self::doSelectOne($c);

      return null !== $result && $result->getHashCode() == $hash_code ? $result : null; 
   }


   public static function updateOptIsPaid(Order $order)
   {
      $order->setOptIsPayed($order->getUnpaidAmount() == 0);

      $order->save();
   }

   public static function doTotalAmountSummary(Criteria $c)
   {
      $c = clone $c;

      $c->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

      $c->clearSelectColumns();
         
      $c->addAsColumn('total_amount' ,sprintf('SUM(ROUND(%s * %s, 2))', OrderPeer::OPT_TOTAL_AMOUNT, OrderCurrencyPeer::EXCHANGE));

      $rs = BasePeer::doSelect($c, Propel::getConnection());

      if ($rs->next()) 
      {
         return $rs->getString(1);   
      }
      else
      {
         return 0;
      }
   }

   public static function updateOrderNumber($id, $created_at)
   {
      $dateFormat = new sfDateFormat();

      $config = stConfig::getInstance('stOrder');

      $format = $config->get('number_format');

      $date = $dateFormat->getDate($created_at, 'd');

      $number = str_replace(array('{NUMER}', '{DZIEN}', '{MIESIAC}', '{ROK}'), array($id, $date['mday'], $date['mon'], $date['year']), $format);

      $con = Propel::getConnection();

      $ps = $con->prepareStatement(sprintf("UPDATE %s SET %s = ? WHERE %s = ?", 
         OrderPeer::TABLE_NAME,
         OrderPeer::NUMBER,
         OrderPeer::ID
      ));

      $ps->setString(1, $number);
      $ps->setInteger(2, $id);
      $ps->executeUpdate(); 

      return $number;     
   }

   public static function addStatusFilterCriteria(Criteria $c, $filters)
   {
      if (isset($filters['filter_order_status']) && !empty($filters['filter_order_status']))
      {
         if (is_numeric($filters['filter_order_status']))
         {
            $c->add(OrderPeer::ORDER_STATUS_ID, $filters['filter_order_status']);
         }
         else
         {            
            $c->add(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::doSelectIdsByType($filters['filter_order_status']), Criteria::IN);
         }
      }        
   }

}
