<?php
if (version_compare($version_old, '1.3.13.0', '<')) {
    try {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->add(PaymentTypePeer::MODULE_NAME, 'stDotpay');
        $p = PaymentTypePeer::doSelectOne($c);
        if (is_object($p)) {
            $p->setCulture('pl_PL');
            $p->setSummaryDescription('<p style="text-align: center;">Visa, MasterCard, JCB, Diners Club, Visa Electron, Maestro<br /> Przelewy online</p>');
            $p->save();

            $p->setCulture('en_US');
            $p->setSummaryDescription('<p style="text-align: center;">Visa, MasterCard, JCB, Diners Club, Visa Electron, Maestro<br /> Online transfers</p>');
            $p->save();
        }
    } catch (Exception $e) {
        // do nothing
    }
}