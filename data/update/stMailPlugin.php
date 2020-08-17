<?php
if (version_compare($version_old, '1.0.1.8', '<'))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    $newMailDescription1 = new MailDescription();
    $newMailDescription1->setSystemName("header");
    $newMailDescription1->setName("Uniwerslany nagłówek");
    $newMailDescription1->setDescription("");
    $newMailDescription1->setIsActive(0);
    $newMailDescription1->save();

    $newMailDescription2 = new MailDescription();
    $newMailDescription2->setSystemName("footer");
    $newMailDescription2->setName("Uniwersalna stopka");
    $newMailDescription2->setDescription("");
    $newMailDescription2->setIsActive(0);
    $newMailDescription2->save();

    $newMailDescription3 = new MailDescription();
    $newMailDescription3->setSystemName("top_user_new");
    $newMailDescription3->setName("Klient - założenie nowego konta - góra");
    $newMailDescription3->setDescription("Twoje konto w sklepie zostało założone. Poniżej zamieszczono dane dostępu do konta, wykorzystaj je aby zalogować się do konta klienckiego.");
    $newMailDescription3->setIsActive(1);
    $newMailDescription3->save();

    $newMailDescription4 = new MailDescription();
    $newMailDescription4->setSystemName("bottom_user_new");
    $newMailDescription4->setName("Klient - założenie nowego konta - dół");
    $newMailDescription4->setDescription("<span style='color: #ff0000;'>Twoje konto w sklepie nie będzie aktywne dopóki nie potwierdzisz rejestracji.</span><br /><br/>Zapraszamy do zapoznania się z pełną ofertą naszego sklepu.");
    $newMailDescription4->setIsActive(1);
    $newMailDescription4->save();

    $newMailDescription5 = new MailDescription();
    $newMailDescription5->setSystemName("top_user_remaind");
    $newMailDescription5->setName("Klient - przypomnienie hasła - góra");
    $newMailDescription5->setDescription("");
    $newMailDescription5->setIsActive(0);
    $newMailDescription5->save();

    $newMailDescription6 = new MailDescription();
    $newMailDescription6->setSystemName("bottom_user_remaind");
    $newMailDescription6->setName("Klient - przypomnienie hasła - dół");
    $newMailDescription6->setDescription("Jeżeli chcesz ustawić swoje hasło zaloguj się do panelu klienta sklepu.<br />");
    $newMailDescription6->setIsActive(1);
    $newMailDescription6->save();

    $newMailDescription7 = new MailDescription();
    $newMailDescription7->setSystemName("top_order_confirm");
    $newMailDescription7->setName("Zamówienie - dane zamówienia - góra");
    $newMailDescription7->setDescription("Dziękujemy za złożenie zamówienia.<br />");
    $newMailDescription7->setIsActive(1);
    $newMailDescription7->save();

    $newMailDescription8 = new MailDescription();
    $newMailDescription8->setSystemName("bottom_order_confirm");
    $newMailDescription8->setName("Zamówienie - dane zamówienia - dół");
    $newMailDescription8->setDescription("<span style='font-size: small;'><span style='color: #ff0000;'>Twoje zamówienie nie będzie zrealizowane dopóki go nie potwierdzisz.</span></span><br /><br/>Bardzo dziękujemy za dokonanie zakupów w naszym sklepie. Państwa zamówienie zostanie możliwie szybko zrealizowane.<br />");
    $newMailDescription8->setIsActive(1);
    $newMailDescription8->save();

    $newMailDescription9 = new MailDescription();
    $newMailDescription9->setSystemName("top_order_status");
    $newMailDescription9->setName("Zamówienie - zmiana statusu - góra");
    $newMailDescription9->setDescription("Zamówienie złożone w sklepie zmieniło swój status. Aktualny status Twojego zamówienia:");
    $newMailDescription9->setIsActive(1);
    $newMailDescription9->save();

    $newMailDescription10 = new MailDescription();
    $newMailDescription10->setSystemName("bottom_order_status");
    $newMailDescription10->setName("Zamówienie - zmiana statusu - dół");
    $newMailDescription10->setDescription("");
    $newMailDescription10->setIsActive(0);
    $newMailDescription10->save();
}

if (version_compare($version_old, '1.0.1.12', '<'))
{
    sfLoader::loadPluginConfig();

    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "bottom_user_new");
    $newMailDescription = MailDescriptionPeer::doSelectOne($c);

    $newMailDescription->setDescription("<span style='color: #ff0000;'>Twoje konto w sklepie nie będzie aktywne do czasu aż nie potwierdzisz rejestracji.</span><br /><br/>Zapraszamy do zapoznania się z pełną ofertą naszego sklepu.");
    $newMailDescription->setIsActive(1);
    $newMailDescription->save();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "header");
    $newMailDescription = MailDescriptionPeer::doSelectOne($c);

    $newMailDescription->setName("Uniwersalny nagłówek");
    $newMailDescription->save();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "bottom_order_confirm");
    $newMailDescription = MailDescriptionPeer::doSelectOne($c);

    $newMailDescription->setDescription("<span style='font-size: small;'><span style='color: #ff0000;'>Twoje zamówienie nie będzie zrealizowane dopóki go nie potwierdzisz.</span></span><br /><br/>Bardzo dziękujemy za dokonanie zakupów w naszym sklepie. Państwa zamówienie zostanie możliwie szybko zrealizowane.<br />");
    $newMailDescription->setIsActive(1);
    $newMailDescription->save();

    $databaseManager->shutdown();
}

if (version_compare($version_old, '1.0.1.15', '<'))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    $newMailDescription11 = new MailDescription();
    $newMailDescription11->setSystemName("top_partner_confirm");
    $newMailDescription11->setName("Partner - weryfikacja danych - góra");
    $newMailDescription11->setDescription("");
    $newMailDescription11->setIsActive(0);
    $newMailDescription11->save();

    $newMailDescription12 = new MailDescription();
    $newMailDescription12->setSystemName("bottom_partner_confirm");
    $newMailDescription12->setName("Partner - weryfikacja danych - dół");
    $newMailDescription12->setDescription("");
    $newMailDescription12->setIsActive(0);
    $newMailDescription12->save();

    $databaseManager->shutdown();

}

if (version_compare($version_old, '1.0.1.20', '<'))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    $newMailDescription13 = new MailDescription();
    $newMailDescription13->setSystemName("top_question_answer");
    $newMailDescription13->setName("Zapytanie - odpowiedź - góra");
    $newMailDescription13->setDescription("Drogi {USER},<br /><br /> Dziękujemy za odwiedzenie sklepu {SHOP}.<br /><br />W odpowiedzi na zapytanie o produkt:<br /><br />");
    $newMailDescription13->setIsActive(0);
    $newMailDescription13->save();

    $newMailDescription14 = new MailDescription();
    $newMailDescription14->setSystemName("bottom_question_answer");
    $newMailDescription14->setName("Zapytanie - odpowiedź - dół");
    $newMailDescription14->setDescription("<div style='margin-top: 20px; font-size: 12px'>Mamy nadzieję, że informacja na temat produktu {PRODUCT} okazała się przydatna.<br /><br />Zapraszamy do odwiedzania sklepu {SHOP}</div>");
    $newMailDescription14->setIsActive(0);
    $newMailDescription14->save();

    $databaseManager->shutdown();
}

if (version_compare($version_old, '1.0.1.23', '<'))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "header");
    $newMailDescription1 = MailDescriptionPeer::doSelectOne($c);
    $newMailDescription1->setCulture('en_US');
    $newMailDescription1->setDescription("");
    $newMailDescription1->save();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "footer");
    $newMailDescription2 = MailDescriptionPeer::doSelectOne($c);
    $newMailDescription2->setCulture('en_US');
    $newMailDescription2->setDescription("");
    $newMailDescription2->save();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "top_user_new");
    $newMailDescription3 = MailDescriptionPeer::doSelectOne($c);
    $newMailDescription3->setCulture('en_US');
    $newMailDescription3->setDescription("Your account in the store was created. There are acount access data placed below, use them to log into the client account.");
    $newMailDescription3->save();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "bottom_user_new");
    $newMailDescription4 = MailDescriptionPeer::doSelectOne($c);
    $newMailDescription4->setCulture('en_US');
    $newMailDescription4->setDescription("<span style='color: #ff0000;'>Your account in the store won't be active until you confirm the registration.</span><br /><br/>We invite you to get to know the full offer of our store.");
    $newMailDescription4->save();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "top_user_remaind");
    $newMailDescription5 = MailDescriptionPeer::doSelectOne($c);
    $newMailDescription5->setCulture('en_US');
    $newMailDescription5->setDescription("");
    $newMailDescription5->save();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "bottom_user_remaind");
    $newMailDescription6 = MailDescriptionPeer::doSelectOne($c);
    $newMailDescription6->setCulture('en_US');
    $newMailDescription6->setDescription("If you want to set your password up log into customer's panel.<br />");
    $newMailDescription6->save();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "top_order_confirm");
    $newMailDescription7 = MailDescriptionPeer::doSelectOne($c);
    $newMailDescription7->setCulture('en_US');
    $newMailDescription7->setDescription("Thank you for placing your order.<br />");
    $newMailDescription7->save();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "bottom_order_confirm");
    $newMailDescription8 = MailDescriptionPeer::doSelectOne($c);
    $newMailDescription8->setCulture('en_US');
    $newMailDescription8->setDescription("Thank you a lot for doing the shopping in our store. Your order will be fulfilled as soon as possible.<br />");
    $newMailDescription8->save();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "top_order_status");
    $newMailDescription9 = MailDescriptionPeer::doSelectOne($c);
    $newMailDescription9->setCulture('en_US');
    $newMailDescription9->setDescription("The order placed in the shop changed its status. Current status of your order:");
    $newMailDescription9->save();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "bottom_order_status");
    $newMailDescription10 = MailDescriptionPeer::doSelectOne($c);
    $newMailDescription10->setCulture('en_US');
    $newMailDescription10->setDescription("");
    $newMailDescription10->save();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "top_partner_confirm");
    $newMailDescription11 = MailDescriptionPeer::doSelectOne($c);
    if (is_object($newMailDescription11))
    {
        $newMailDescription11->setCulture('en_US');
        $newMailDescription11->setDescription("");
        $newMailDescription11->save();
    }

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "bottom_partner_confirm");
    $newMailDescription12 = MailDescriptionPeer::doSelectOne($c);
    $newMailDescription12->setCulture('en_US');
    $newMailDescription12->setDescription("");
    $newMailDescription12->save();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "top_question_answer");
    $newMailDescription13 = MailDescriptionPeer::doSelectOne($c);
    $newMailDescription13->setCulture('en_US');
    $newMailDescription13->setDescription("Dear {USER},<br /><br />Thank you for visiting the shop {SHOP}.<br /><br />In the response to the inquiry about the product:<br /><br />");
    $newMailDescription13->save();

    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "bottom_question_answer");
    $newMailDescription14 = MailDescriptionPeer::doSelectOne($c);
    $newMailDescription14->setCulture('en_US');
    $newMailDescription14->setDescription("<div style='margin-top: 20px; font-size: 12px'>We hope, that information about the product {PRODUCT} turned out to be useful. <br /><br />We invite to visit the shop {SHOP}</div>");
    $newMailDescription14->save();
}

if (version_compare($version_old, '1.0.2.4', '<'))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    $c = new Criteria();

    $c->add(MailSmtpProfilePeer::HOST, 'mail.sote.pl');

    if ($profile = MailSmtpProfilePeer::doSelectOne($c))
    {
        $profile->setPort(587);

        $profile->save();
    }
}

if (version_compare($version_old, '1.0.2.15', '<'))
{
    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $mails = MailDescriptionPeer::doSelect($c);

        foreach ($mails as $mail)
        {
            $mail->setCulture('pl_PL');
            $mail->setSystemName($mail->getSystemName());
            $mail->setName($mail->getOptName());
            $mail->setDescription($mail->getDescription());
            $mail->setIsActive($mail->getIsActive());
            $mail->setCulture('en_US');

            if ($mail->getSystemName()=="header")
            {
                $mail->setName("Universal header");
            }
            
            if ($mail->getSystemName()=="footer")
            {
                $mail->setName("Universal footer");
            }

            if ($mail->getSystemName()=="top_user_new")
            {
                $mail->setName("Customer - new account - header");
            }

            if ($mail->getSystemName()=="bottom_user_new")
            {
                $mail->setName("Customer - new account - footer");
            }

            if ($mail->getSystemName()=="top_user_remaind")
            {
                $mail->setName("Customer - password remind - header");
            }

            if ($mail->getSystemName()=="bottom_user_remaind")
            {
                $mail->setName("Customer - password remind - footer");
            }

            if ($mail->getSystemName()=="top_order_confirm")
            {
                $mail->setName("Order - order data - header");
            }

            if ($mail->getSystemName()=="bottom_order_confirm")
            {
                $mail->setName("Order - order data - footer");
            }

            if ($mail->getSystemName()=="top_order_status")
            {
                $mail->setName("Order - status change - header");
            }

            if ($mail->getSystemName()=="bottom_order_status")
            {
                $mail->setName("Order - status change - footer");
            }

            if ($mail->getSystemName()=="top_partner_confirm")
            {
                $mail->setName("Partner - verify data - header");
            }

            if ($mail->getSystemName()=="bottom_partner_confirm")
            {
                $mail->setName("Partner - verify data - footer");
            }

            if ($mail->getSystemName()=="top_question_answer")
            {
                $mail->setName("Inquiry - the answer - header");
            }

            if ($mail->getSystemName()=="bottom_question_answer")
            {
                $mail->setName("Inquiry - the answer - footer");
            }

            $mail->save();
        }
    }
    catch (Exception $e)
    {
        if (SF_ENVIRONMENT == 'dev')
        {
            throw new PropelException($e);
        }
    }
}

if (version_compare($version_old, '2.0.0.2', '<'))
{
    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->add(MailAccountPeer::IS_DEFAULT, 1);
        $mailAccount = MailAccountPeer::doSelectOne($c);
 
        if($mailAccount){       
            $mailAccount->setIsNewsletter(1);
            $mailAccount->save();
        }
        
    }
    catch (Exception $e)
    {
        if (SF_ENVIRONMENT == 'dev')
        {
            throw new PropelException($e);
        }
    }
}

if (version_compare($version_old, '7.0.3.8', '<'))
{
    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();

        foreach (MailAccountPeer::doSelect($c) as $account)
        {
            $account->save();
        }
    }
    catch (Exception $e)
    {
        
    }
}

