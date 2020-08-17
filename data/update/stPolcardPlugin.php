<?php
if (version_compare($version_old, '1.3.13.0', '<')) {
    try {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->add(PaymentTypePeer::MODULE_NAME, 'stPolcard');
        $p = PaymentTypePeer::doSelectOne($c);
        if (is_object($p)) {
            $p->setCulture('pl_PL');
            $p->setSummaryDescription('<p style="text-align: center;">VISA, Maestro, MasterCard, Diners Club, American Express, JCB, POLCARD</p>');
            $p->save();

            $p->setCulture('en_US');
            $p->setSummaryDescription('<p style="text-align: center;">VISA, Maestro, MasterCard, Diners Club, American Express, JCB, POLCARD</p>');
            $p->save();
        }
    } catch (Exception $e) {
        // do nothing
    }
}

if (version_compare($version_old, '7.2.0.0', '<')) {
    try {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
        $c = new Criteria();
        $c->add(PaymentTypePeer::MODULE_NAME, 'stPolcard');
        $p = PaymentTypePeer::doSelectOne($c);

        if ($p) {
            $p->setCulture('pl_PL');
            $p->setName('Payeezy');
            $p->setCulture('en_US');
            $p->setName('Payeezy');
            $p->save();
        }
    } catch (Exception $e) {
        // do nothing
    }
}