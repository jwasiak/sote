<?php
if (version_compare($version_old, '1.1.0.1', '<='))
{
    try {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->add(BoxPeer::OPT_NAME, 'LUKAS Raty');
        $box = BoxPeer::doSelectOne($c);
        
        if (is_object($box))
        {
            if (!$box->getActive())
            {
                $box->setContent('<p style="text-align: center;"><a href="#" onClick="window.open(\'/lukas/procedure\',\'lukasWindow\',\'location=no,scrollbars=yes,resizable=yes,toolbar=no,menubar=no,height=600,width=840\');"><img src="/images/frontend/theme/default/stLukasPlugin/procedure.png" border="0" /></a></p>');
                $box->setCulture('en_US');
                $box->setContent('<p style="text-align: center;"><a href="#" onClick="window.open(\'/lukas/procedure\',\'lukasWindow\',\'location=no,scrollbars=yes,resizable=yes,toolbar=no,menubar=no,height=600,width=840\');"><img src="/images/frontend/theme/default/stLukasPlugin/procedure.png" border="0" /></a></p>');
                $box->save();
            }
        }
    } catch (Exception $e) {
        if (SF_ENVIRONMENT == 'dev') throw new Exception($e);
    }
}

try {
    if (version_compare($version_old, '2.1.8.0', '<')) {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->add(PaymentTypePeer::OPT_NAME, 'LUKAS Raty');
        $paymentTypes = PaymentTypePeer::doSelect($c);
        foreach ($paymentTypes as $v) {
            $v->setName('Credit Agricole Raty');
            $v->save();
        }
    }
} catch (Exception $e) {
    if (SF_ENVIRONMENT == 'dev') throw new Exception($e);
}
