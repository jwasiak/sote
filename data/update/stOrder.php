<?php

try
{

   if (version_compare($version_old, '1.0.9.50', '<'))
   {
      $databaseManager = new sfDatabaseManager();
      $databaseManager->initialize();


      $c = new Criteria();

      $c->add(TextPeer::SYSTEM_NAME, 'stOrderSummary');

      if (!TextPeer::doCount($c))
      {
         $text = new Text();
         $text->setCulture('pl_PL');
         $text->setSystemName('stOrderSummary');
         $text->setActive(1);
         $text->setName('Podsumowanie zamówienia');
         $text->setContent('Jeśli wybrałeś płatność przelewem to wpłatę prosimy dokonać na numer rachunku bankowego:<br /> {BANK},<br /> tytułem: Wpłata za zamówienie numer {NUMBER}<br /> Informacje o realizacji zamówienia możesz uzyskać pod numerem telefonu: {PHONE}<br /> oraz pod adresem e-mailowym: {EMAIL}');
         $text->save();
      }

      $c = new Criteria();

      $c->add(MailDescriptionPeer::SYSTEM_NAME, 'top_order_status');

      $desc = MailDescriptionPeer::doSelectOne($c);

      if ($desc)
      {
         $desc->setCulture('pl_PL');

         if ($desc->getDescription() == 'Zamówienie złożone w sklepie zmieniło swój status. Aktualny status Twojego zamówienia:')
         {
            $desc->setDescription('Zamówienie złożone w sklepie zmieniło swój status. Aktualny status Twojego zamówienia: {ORDER_STATUS}');
         }

         $desc->setCulture('en_US');

         if ($desc->getDescription() == 'The order placed in the shop changed its status. Current status of your order:')
         {
            $desc->setDescription('The order placed in the shop changed its status. Current status of your order: {ORDER_STATUS}');
         }

         $desc->save();
      }
   }

   if (version_compare($version_old, '1.1.0.42', '<'))
   {
      $databaseManager = new sfDatabaseManager();
      $databaseManager->initialize();

      $con = Propel::getConnection();

      $con->executeQuery('UPDATE st_order o, sf_guard_user u SET o.opt_client_email = u.USERNAME WHERE o.SF_GUARD_USER_ID = u.ID');

      $con->executeQuery('UPDATE st_order o, st_order_user_data_billing u SET o.opt_client_name = CONCAT(u.NAME, \' \', u.SURNAME) WHERE o.ORDER_USER_DATA_BILLING_ID = u.ID');

      $con->executeQuery('UPDATE st_order o, st_order_status os SET o.opt_order_status = os.OPT_NAME WHERE o.ORDER_STATUS_ID = os.ID');
   }

   if (version_compare($version_old, '1.2.0.47', '<'))
   {
      $databaseManager = new sfDatabaseManager();
      $databaseManager->initialize();

      $c = new Criteria();
      $c->add(TextPeer::SYSTEM_NAME, 'stOrderConfirm');
      if (!TextPeer::doCount($c))
      {
         $text = new Text();
         $text->setCulture('pl_PL');
         $text->setSystemName('stOrderConfirm');
         $text->setActive(0);
         $text->setName('Potwierdzenie zamówienia');
         $text->setContent('Akceptuje <a href="/webpage/regulamin.html">regulamin sklepu</a> i zapoznałem się z <a href="/webpage/regulamin.html">prawem do odstąpienia od umowy</a>.');
         $text->save();

         $text->setCulture('en_US');
         $text->setName('Order confirm');
         $text->setContent('I accept the shop\'s  <a href="/webpage/terms-and-conditions.html">terms</a> and also I acquainted with the <a href="/webpage/terms-and-conditions.html">right to withdraw from the agreement</a>.');
         $text->save();
      }
   }

   if (version_compare($version_old, '1.2.0.57', '<'))
   {
      $dispatcher = stEventDispatcher::getInstance();

      $dispatcher->connect('stInstallerTaks.onClose', array('stOrderListener', 'postInstall'));
   }

   if (version_compare($version_old, '7.0.7.7', '<'))
   {
      $dispatcher = stEventDispatcher::getInstance();

      $dispatcher->connect('stInstallerTaks.onClose', array('stOrderListener', 'numberRepair'));
   }  

   if (version_compare($version_old, '7.4.3.8', '<'))
   {
      $config = stConfig::getInstance('stOrder');

      $config->set('payment_verification_check', date('Y-m-d H:i:s'));

      $config->save();
   } 
}
catch (Exception $e)
{
   
}
