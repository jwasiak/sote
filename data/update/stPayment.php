<?php
if (version_compare($version_old, '1.3.13.5', '<')) {
    try {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->add(PaymentTypePeer::MODULE_NAME, 'stStandardPayment');
        $c->add(PaymentTypePeer::OPT_NAME, 'Płatność przelewem');
        $p = PaymentTypePeer::doSelectOne($c);
        if (is_object($p)) {
            $p->setCulture('pl_PL');
            $p->setSummaryDescription('Wpłatę prosimy dokonać na numer rachunku bankowego:<br />{BANK}<br />tytułem: Wpłata za zamówienie numer {NUMBER}<br />Informacje o realizacji zamówienia możesz uzyskać pod numerem telefonu: {PHONE}<br />oraz pod adresem e-mailowym: {EMAIL}');
            $p->save();

            $p->setCulture('en_US');
            $p->setSummaryDescription('Please send the money to the following bank account:<br />{BANK}.<br />In the correspondence field, please enter: Payment for the order No. {NUMBER}.<br />For information on order execution please call {PHONE}<br />or e-mail us at {EMAIL}.');
            $p->save();
        }
    } catch (Exception $e) {
        // do nothing
    }
}