<?php

class stOrderProgressBar
{
   protected static $dbm = null;
   /**
    *
    * @return Criteria 
    */
   public static function getCriteria()
   {
      $c = new Criteria();
      
      return $c;
   }
   
   public static function initDatabase()
   {
      self::$dbm = new sfDatabaseManager();

      self::$dbm->initialize();      
   }
   
   public static function shutdownDatabase()
   {
      self::$dbm->shutdown();
   }
   
   public static function countRepairTotalAmount()
   {
      self::initDatabase();
      
      $count = OrderPeer::doCount(self::getCriteria());
      
      self::shutdownDatabase();
      
      return $count;
   }
   
   public function close()
   {
      $this->setMessage('Naprawa zamówień zakończona pomyślnie');
   }
   
   public function repairTotalAmount($offset = 0)
   {      
      self::initDatabase();
      
      $c = self::getCriteria();
      
      $c->setOffset($offset);
      
      $c->setLimit(100);

      $orders = OrderPeer::doSelect($c);   
      
      foreach ($orders as $order)
      {
         $order->setOptTotalAmount($order->getTotalAmountWithDelivery(true, true));
         
         $order->save();
         
         $offset++;
         
         usleep(200000);
      }
      
      $this->setMessage('Zamówienia - Naprawa sortowania i filtrowania po cenie');
      
      self::shutdownDatabase();
      
      sleep(2);
      
      return $offset;
   }

   public static function countRepairOrderNumber()
   {
      self::initDatabase();
      $c = self::createRepairOrderNumberCriteria();

      $count = OrderPeer::doCount($c);

      self::shutdownDatabase();

      return $count;
   }

   public function repairOrderNumber($offset = 0)
   {
      self::initDatabase();
      $c = self::createRepairOrderNumberCriteria();
      $c->addSelectColumn(OrderPeer::ID);
      $c->addSelectColumn(OrderPeer::CREATED_AT);
      $c->setOffset($offset);
      $c->setLimit(100);

      $rs = OrderPeer::doSelectRS($c);

      while($rs->next())
      {
         list($id, $created_at) = $rs->getRow();

         OrderPeer::updateOrderNumber($id, $created_at);

         $offset++;
      }

      self::shutdownDatabase();

      return $offset;
   }

   protected static function createRepairOrderNumberCriteria()
   {
      $c = new Criteria();
      $c->add(OrderPeer::NUMBER, null, Criteria::ISNULL);

      return $c;
   }
   
   protected function setMessage($message)
   {
     $user = sfContext::getInstance()->getUser();

     $user->setAttribute('stProgressBar-stOrderRepair', $message, 'symfony/flash');
   }   
}
