<?php

if (version_compare($version_old, '1.0.6.17', '<'))
{
    $dispatcher = stEventDispatcher::getInstance();
    $dispatcher->connect('stInstallerTaks.onClose', array('stUserFixUpdate', 'postInstall'));
}

if (version_compare($version_old, '1.0.7.12', '<'))
{   
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();
    
    $c = new Criteria();
    $c->add(MailDescriptionPeer::SYSTEM_NAME, "bottom_order_confirm");
    $newMailDescription = MailDescriptionPeer::doSelectOne($c);
          
    $newDescription = str_replace('<span style="font-size: small;"><span style="color: #ff0000;">Twoje zam&oacute;wienie nie będzie zrealizowane dop&oacute;ki go nie potwierdzisz.</span></span><br /><br />', "", $newMailDescription->getDescription());
    
    $newMailDescription->setDescription($newDescription);
    $newMailDescription->save();
    
    $databaseManager->shutdown();   
}

if (version_compare($version_old, '1.0.7.32','<'))
{
    $context = sfContext::getInstance();
    $config = stConfig::getInstance($context, 'stUser');
    $config->set('show_users_online', 0);
    sleep(2);
    $config->save();
    $config->load();
}

if (version_compare($version_old, '1.2.0.16', '<'))
{
    try
    {
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    $mailDescription = new MailDescription();
   
    $mailDescription->setCulture("pl_PL");
    $mailDescription->setSystemName("admin_confirm_user");
    $mailDescription->setName("Klient - weryfikacja danych");
    $mailDescription->setDescription("Witam,<br />twoje dane zostały zweryfikowane, od tej chwili twoje konto zyskało pełne uprawnienia do korzystania z naszego sklepu.<br /><br />Zapraszamy do zakupów.");
    $mailDescription->setIsActive(1);
    $mailDescription->save();

    $mailDescription->setCulture("en_US");
    $mailDescription->setSystemName("admin_confirm_user");
    $mailDescription->setName("Client - verification of data");
    $mailDescription->setDescription("Hello, <br /> your data has been verified from the moment your account has gained full rights to the use of our store. <br /> <br /> We invite you to purchase.");
    $mailDescription->setIsActive(1);
    $mailDescription->save();


    $databaseManager->shutdown();
    }
    catch (Exception $e)
    {
        if (SF_ENVIRONMENT == 'dev')
        {
            throw new PropelException($e);
        }
    }
}

if (version_compare($version_old, '2.0.0.6', '<'))
{
    $dir = sfConfig::get('sf_root_dir').'/apps/frontend/modules/stUserData/validate';

    $files = array(
        'addBasketUser.yml',
        'checkBasketUser.yml',
    );

    foreach ($files as $file) 
    {
        if (is_file($dir.'/'.$file))
        {
            unlink($dir.'/'.$file);
        }
    }
}