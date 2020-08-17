<?php

/**
 * SOTESHOP/stMigrationSoteshopPlugin 
 * 
 * Ten plik należy do aplikacji stMigrationSoteshopPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *  
 * @package     stMigrationSoteshopPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stMigrationOrder.class.php 3823 2010-03-09 10:33:42Z pawel $
 */

/**
 * Klasa odpowiadająca za obsługę procesu migracji
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @package     stMigrationSoteshopPlugin
 * @subpackage  libs
 */
class stMigrationSoteshopOrderBase extends stMigrationModel
{
   protected $payment = null;
   
   public function postCreate($order)
   {
      $this->payment = null;
   }
   
   public function setMId($order, $o_id)
   {
      $this->mId = $o_id;

      $order->setNumber($o_id);
   }

   public function setMStatus($order, $o_confirm, $o_cancel = false)
   {
      if ($o_confirm)
      {
         $order_status = OrderStatusPeer::retrieveSystemStatusByType('ST_COMPLETE');
      }
      elseif ($o_cancel)
      {
         $order_status = OrderStatusPeer::retrieveSystemStatusByType('ST_CANCELED');
      }
      else
      {
         $order_status = OrderStatusPeer::retrieveSystemStatusByType('ST_PENDING');
      }

      $order->setOrderStatus($order_status);
   }

   public function setMCreatedAt($order, $o_date_add, $o_time_add)
   {
      $time = $o_date_add . ' ' . $o_time_add;

      if (strtotime($time) != -1)
      {
         $order->setCreatedAt($time);
      }
   }

   public function setMUpdatedAt($order, $time)
   {
      if (strtotime($time) != -1)
      {
         $order->setUpdatedAt($time);
      }
   }

   /**
    * 
    * @param Order $order Zamówienie 
    */
   public function setMDelivery($order, $d_name, $d_price)
   {
      $order_delivery = new OrderDelivery();

      $order_delivery->setName($d_name);

      $order_delivery->setCost(stCurrency::extractNettoFromBrutto($d_price, 22));

      $order_delivery->setOptTax(22);

      $order->setOrderDelivery($order_delivery);
   }

   /**
    * 
    * @param Order $order Zamówienie
    */
   public function preSave($order)
   {
      $c = new Criteria();

      $c->add(CurrencyPeer::SHORTCUT, 'PLN');

      $currency = CurrencyPeer::doSelectOne($c);

      $order->getOrderCurrency()->setShortcut($currency->getShortcut());

      $order->getOrderCurrency()->setBackSymbol($currency->getBackSymbol());

      $order->getOrderCurrency()->setFrontSymbol($currency->getFrontSymbol());

      $order->getOrderCurrency()->setExchange($currency->getExchange());

      $this->addOrderProduct($order);
      
      if (null !== $this->payment)
      {
         $payment = stPayment::newPaymentInstance($this->payment['id'], $order->getTotalAmountWithDelivery(true, true), array('user_id' => $order->getsfGuardUserId(), 'is_paid' => $this->payment['is_paid']));
         
         if ($this->payment['is_paid'])
         {
            $payment->setPayedAt($order->getCreatedAt());
         }
         
         $order->addOrderPayment($payment);
         
         $order->setOptIsPayed($this->payment['is_paid']);
      }
   }

   public function postSave($order)
   {
   }

   public function setMUser($order, $crypt_login, $crypt_email)
   {
      $c = new Criteria();

      $username = $this->decrypt($crypt_login);

      $email = $this->decrypt($crypt_email);

      $username = str_replace("'", "", trim($username));

      $email = str_replace("'", "", trim($email));

      $criterion = $c->getNewCriterion(sfGuardUserPeer::USERNAME, $username);
      
      $criterion->addOr($c->getNewCriterion(sfGuardUserPeer::USERNAME, $email));     
      
      $c->add($criterion);
     
      $user = sfGuardUserPeer::doSelectOne($c);

      if ($user && $user->getUsername())
      {
         $order->setsfGuardUser($user);
      }
      elseif (!empty($email))
      {
         $user = $this->addAnonymousUser($email);

         $user->setCreatedAt($order->getCreatedAt());

         $user->save();

         $order->setsfGuardUser($user);
      }
   }
   
   public function setMPayment($order, $payment_id, $confirm, $confirm_online)
   {
      if ($payment_id)
      {
         $this->payment = array('id' => $this->getPaymentTypeIdByPaymentId($payment_id), 'is_paid' => $confirm || $confirm_online);
      }
   }

   public function setMUserData($order, $billing, $delivery)
   {
      if (!sfToolkit::isArrayValuesEmpty($billing))
      {
         $order->getOrderUserDataBilling()->setFullName(stMigrationSoteshopHelper::getFullName($billing['crypt_name'], $billing['crypt_surname']));

         $order->getOrderUserDataBilling()->setAddress(stMigrationSoteshopHelper::getAddress($billing['crypt_street'], $billing['crypt_street_n1'], $billing['crypt_street_n2']));

         $order->getOrderUserDataBilling()->setCode($this->decrypt($billing['crypt_postcode']));

         $order->getOrderUserDataBilling()->setTown($this->decrypt($billing['crypt_city']));

         $country = $this->retrieveCountryByName($this->decrypt($billing['crypt_country']));

         $order->getOrderUserDataBilling()->setCountry($country->getName());

         $order->getOrderUserDataBilling()->setPhone($this->decrypt($billing['crypt_phone']));

         $order->getOrderUserDataBilling()->setCompany($this->decrypt($billing['crypt_firm']));

         $order->getOrderUserDataBilling()->setVatNumber($this->decrypt($billing['crypt_nip']));
      }

      if (sfToolkit::isArrayValuesEmpty($delivery))
      {
         $delivery['crypt_cor_name'] = $billing['crypt_name'];
         $delivery['crypt_cor_surname'] = $billing['crypt_surname'];
         $delivery['crypt_cor_street'] = $billing['crypt_street'];
         $delivery['crypt_cor_street_n1'] = $billing['crypt_street_n1'];
         $delivery['crypt_cor_street_n2'] = $billing['crypt_street_n2'];
         $delivery['crypt_cor_postcode'] = $billing['crypt_postcode'];
         $delivery['crypt_cor_city'] = $billing['crypt_city'];
         $delivery['crypt_cor_country'] = $billing['crypt_country'];
         $delivery['crypt_cor_phone'] = $billing['crypt_phone'];
         $delivery['crypt_cor_firm'] = $billing['crypt_firm'];
      }

      if (!sfToolkit::isArrayValuesEmpty($delivery))
      {
         $order->getOrderUserDataDelivery()->setFullName(stMigrationSoteshopHelper::getFullName($delivery['crypt_cor_name'], $delivery['crypt_cor_surname']));

         $order->getOrderUserDataDelivery()->setAddress(stMigrationSoteshopHelper::getAddress($delivery['crypt_cor_street'], $delivery['crypt_cor_street_n1'], $delivery['crypt_cor_street_n2']));

         $order->getOrderUserDataDelivery()->setCode($this->decrypt($delivery['crypt_cor_postcode']));

         $order->getOrderUserDataDelivery()->setTown($this->decrypt($delivery['crypt_cor_city']));

         $country = $this->retrieveCountryByName($this->decrypt($delivery['crypt_cor_country']));

         $order->getOrderUserDataDelivery()->setCountry($country->getName());

         $order->getOrderUserDataDelivery()->setPhone($this->decrypt($delivery['crypt_cor_phone']));

         $order->getOrderUserDataDelivery()->setCompany($this->decrypt($delivery['crypt_cor_firm']));
      }
   }

   protected function getOrderProductFillin()
   {
      return array('m_code' => array('params' => 'user_id_main'), 'name' => array('params' => 'name'), 'quantity' => array('params' => 'num'), 'm_price' => array('params' => array('price_brutto', 'vat')), 'm_product' => array('params' => array('user_id_main')));
   }

   protected function retrieveCountryByName($name)
   {
      $c = new Criteria();

      $c->add(CountriesI18nPeer::NAME, $name);

      $c->add(CountriesI18nPeer::CULTURE, 'pl_PL');

      $countries = CountriesPeer::doSelectWithI18n($c);

      if (!$countries)
      {
         $c = new Criteria();

         $c->add(CountriesPeer::ISO_A2, $name);

         $c->add(CountriesI18nPeer::CULTURE, 'pl_PL');

         $countries = CountriesPeer::doSelectWithI18n($c);
      }

      return isset($countries[0]) ? $countries[0] : CountriesPeer::doSelectDefault(new Criteria());
   }

   protected function decrypt($data)
   {
      return stMigrationSoteshopHelper::decrypt($data);
   }

   protected function addOrderProduct($order)
   {
      $data_procesor = new stMigrationDataProcesor();

      $data_retriever = $this->getDataRetriever();

      $model_fillin = $this->getOrderProductFillin();

      $stmt = $data_retriever->prepareStatement('SELECT * FROM order_products WHERE order_id = ?');

      $stmt->setInt(1, $this->mId);

      $stmt->setLimit(0);

      $rs = $stmt->executeQuery();

      $data_procesor->setModelClass('OrderProduct');

      $data_procesor->setModelFillin($model_fillin);

      $data_procesor->setModelParams(array('order' => $order));

      $data_procesor->autoSaveModel(false);

      while ($rs->next())
      {
         $data_procesor->process($rs->getRow());
      }
   }

   public static function addAnonymousUser($username)
   {
      $user = new sfGuardUser();
      $user->setUsername($username);
      $user->setPassword('anonymous');
      $user->save();

      $user->addGroupByName('user');

      return $user;
   }

   public static function preProcess(stMigrationDataRetriever $data_retriever)
   {
      $connection = Propel::getConnection();

      $connection->executeQuery('ALTER TABLE `st_order` AUTO_INCREMENT=1');
   }

   public static function postProcess(stMigrationDataRetriever $data_retriever)
   {
      $connection = Propel::getConnection();

      $rs = $connection->executeQuery('SELECT max(o.NUMBER + 0) as number FROM `st_order` o', ResultSet::FETCHMODE_ASSOC);

      $number = $rs->next() ? $rs->getInt('number') : 0;

      $rs = $connection->executeQuery('SELECT max(o.ID) as id FROM `st_order` o', ResultSet::FETCHMODE_ASSOC);

      $id = $rs->next() ? $rs->getInt('id') : 0;

      if ($number > $id)
      {
         $stm = $connection->prepareStatement('ALTER TABLE `st_order` AUTO_INCREMENT=?');

         $stm->setInt(1, $number + 1);

         $stm->executeQuery();
      }
   }
   
   protected function getPaymentTypeIdByPaymentId($id)
   {
      $payment_names = array(
         "1"=>"Płatność gotówką",
         "2"=>"eCard",
         "3"=>"Polcard",
         "10"=>"Płatność gotówką",
         "11"=>"Płatność przelewem",
         "12"=>"Przelewy24",
         "20"=>"Płatności.pl",
         "21"=>"Dotpay",
         "22"=>"Żagiel - eRaty",
         "101"=>"PayPal",
         "110"=>"Płatność Kartą",
      );
      
      $name = isset($payment_names[$id]) ? $payment_names[$id] : 'niestandardowa';
      
      $c = new Criteria();
      
      $c->add(PaymentTypePeer::OPT_NAME, $name);
      
      $payment_type = PaymentTypePeer::doSelectOne($c);      
      
      if (null === $payment_type)
      {
         $payment_type = new PaymentType();
         
         $payment_type->setCulture('pl_PL');      
         
         $payment_type->setName($name);
         
         $payment_type->setModuleName('stStandardPayment');      
         
         $payment_type->save();
      }
      else
      {
         $payment_type->setCulture('pl_PL');
      }
      
      return $payment_type->getId();
   }

}

class stMigrationOrderProduct extends stMigrationModel
{

   /**
    * Przypisuje produkt do aktualnego zamówienia
    * 
    * @param OrderProduct $order_product Produkt w zamówieniu
    */
   public function postCreate($order_product)
   {
      $order = $this->getMigrationParam('order');

      $order->addOrderProduct($order_product);
   }

   public function setMCode($order_product, $code)
   {
      $order_product->setCode(stMigrationSoteshopHelper::fixString($code));
   }

   public function setMProduct($order_product, $code)
   {
      $c = new Criteria();

      $c->add(ProductPeer::CODE, stMigrationSoteshopHelper::fixString($code));

      $product = ProductPeer::doSelectOne($c);

      $order_product->setProduct($product);
   }

   /**
    * Ustawia cenę produktu
    * 
    * @param OrderProduct $order_product Produkt w zamówieniu
    * @param float $price_brutto Cena brutto
    * @param float $vat Vat
    */
   public function setMPrice($order_product, $price_brutto, $vat)
   {
      $price = stMigrationSoteshopHelper::calculateNettoPrice($price_brutto, $vat);

      $order_product->setPrice($price);

      $order_product->setPriceBrutto($price_brutto);

      $order_product->setVat($vat);
   }

}

?>
