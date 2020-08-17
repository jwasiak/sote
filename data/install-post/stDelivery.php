<?php
try {
    if (stSoteshopVersion::getVersion() == stSoteshopVersion::ST_SOTESHOP_VERSION_INTERNATIONAL) {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
        $c = new Criteria();
        $c->add(DeliveryPeer::ID, 2);
        $delivery = DeliveryPeer::doSelectOne($c);
        if(is_object($delivery)) {
            $delivery->setCulture('pl_PL');
            $delivery->setName('United Parcel Service');
            $delivery->save();
            $delivery->setCulture('en_US');
            $delivery->setName('United Parcel Service');
            $delivery->save();
        }
        $databaseManager->shutdown();
    }
} catch(Exception $e) {
    // @todo: log this
}