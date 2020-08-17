<?php

if (version_compare($version_old, '7.0.0.12', '<'))
{
    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->add(PaymentTypePeer::MODULE_NAME, 'stInBank');
        $payment = PaymentTypePeer::doSelectOne($c);

        if (null !== $payment)
        {
            $payment->setCulture(stLanguage::getOptLanguage());
            $payment->setName('RATY Inbank');
            $payment->save();
        }
    }
    catch(Exception $e)
    {

    }
    
}