<?php
if (version_compare($version_old, '1.0.4.20', '<'))
{
    $databaseManager = new sfDatabaseManager();

    $databaseManager->initialize();

    $deliveries = DeliveryPeer::doSelect(new Criteria());

    $c = new Criteria();

    $c->add(PaymentTypePeer::ACTIVE, true);

    $payments = PaymentTypePeer::doSelect($c);

    $countries = CountriesPeer::doSelect(new Criteria());

    $c = new Criteria();

    $c->add(TaxPeer::VAT, 22);

    $tax = TaxPeer::doSelectOne($c);

    if ($tax == null)
    {
        $tax = new Tax();

        $tax->setVat(22);

        $tax->setVatName('22%');

        $tax->save();
    }

    CountriesAreaPeer::doDeleteAll();

    $country_area = new CountriesArea();

    $country_area->setName('Domyślna');

    $country_area->setIsActive(true);

    $country_area->save();

    foreach($countries as $country)
    {
        $cahc = new CountriesAreaHasCountries();

        $cahc->setCountriesId($country->getId());

        $cahc->setCountriesAreaId($country_area->getId());

        $cahc->save();
        
        $country->setCulture('pl_PL');

        $country->setIsActive(true);

        if ($country->getName() == 'Azejberdżan')
        {
            $country->setName('Azerbejdżan');
        }

        if ($country->getName() == 'Polska')
        {
            $country->setIsDefault(true);
        }

        $country->save();
    }

    DeliveryHasPaymentTypePeer::doDeleteAll();

    foreach($deliveries as $dk => $delivery)
    {
        $dss = $delivery->getDeliverySectionss();

        foreach ($dss as $ds)
        {
            $netto = stCurrency::extractNettoFromBrutto($ds->getAmount(), 22);

            $ds->setAmount($netto);

            $ds->save();
        }

        foreach ($payments as $pk => $payment)
        {
            $dhp = new DeliveryHasPaymentType();

            $dhp->setPaymentTypeId($payment->getId());

            $dhp->setDeliveryId($delivery->getId());

            $dhp->setIsActive(true);

            if ($pk == 0)
            {
                $dhp->setIsDefault(true);
            }

            $dhp->save();
        }

        $netto = stCurrency::extractNettoFromBrutto($delivery->getDefaultCost(), 22);

        if (empty($dss))
        {
            $delivery->setDefaultCost($netto);
        }
        else
        {
            $delivery->setDefaultCost(0);

            $ds = new DeliverySections();

            $ds->setDeliveryId($delivery->getId());

            $ds->setAmount($netto);

            $ds->setFrom(0);

            $ds->save();

            $delivery->setSectionCostType('ST_BY_ORDER_WEIGHT');
        }

        $delivery->setTaxId($tax->getId());

        $delivery->setIsSystemDefault(false);

        if ($dk == 0)
        {
            $delivery->setIsDefault(true);
        }

        $delivery->setCountriesAreaId($country_area->getId());

        $delivery->save();
    }
}

if (version_compare($version_old, '2.0.0.7', '<'))
{
   $file = sfConfig::get('sf_root_dir').'/plugins/stDeliveryPlugin/modules/stDeliveryBackend/templates/configCustomSuccess.php';

   if (is_file($file))
   {
      unlink($file);
   }
}

if (version_compare($version_old, '7.0.0.122', '<'))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();
    $con = Propel::getConnection();
    $con->executeQuery("ALTER TABLE `st_delivery_has_payment_type` DROP `created_at`, DROP `updated_at`");
    $con->executeQuery("ALTER TABLE `st_delivery_sections` DROP `created_at`, DROP `updated_at`");   
    $con->executeQuery("ALTER TABLE `st_delivery` DROP `created_at`, DROP `updated_at`"); 
    $con->executeQuery("OPTIMIZE TABLE `st_delivery_has_payment_type`");
    $con->executeQuery("OPTIMIZE TABLE `st_delivery_sections`");
    $con->executeQuery("OPTIMIZE TABLE `st_delivery`");
}

if (version_compare($version_old, '7.1.1.7', '<'))
{
    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize(); 
        $con = Propel::getConnection();
        $con->executeQuery('UPDATE st_delivery d, st_delivery_dimension dd SET d.width = dd.width, d.height = dd.height, d.depth = dd.depth, d.volume = dd.volume, d.paczkomaty_size = dd.paczkomaty_size WHERE dd.id = d.delivery_dimension_id'); 
    } 
    catch(Exception $e)
    {

    }  

    try
    {
        $con = Propel::getConnection();
        $insert =<<<SQL
INSERT IGNORE INTO `st_delivery_type` (`id`, `name`, `type`) VALUES
(1, 'Poczta Polska - Kurier', 'ppk'),
(2, 'Poczta Polska - Odbiór w punkcie', 'ppo'),
(3, 'InPost - Paczkomaty', 'inpostp'),
(4, 'DPD', 'dpd'),
(5, 'FedEx', 'fedex'),
(6, 'UPS', 'ups'),
(7, 'GLS', 'gls'),
(8, 'DHL', 'dhl'),
(9, 'InPost - Kurier', 'inpostk'),
(10, 'Global Express', 'ge');
SQL;
        $con->executeQuery($insert); 
        $con->executeQuery("UPDATE st_delivery d SET d.type_id = 3 WHERE d.paczkomaty_type IS NOT NULL AND d.paczkomaty_type <> 'NONE'");
    }
    catch(Exception $e)
    {        
    }
}

if (version_compare($version_old, '7.1.2.15', '<'))
{
    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize(); 
        $con = Propel::getConnection();
        $id = DeliveryTypePeer::retrieveIdByType('inpostp');
        $ids = array();

        if ($id) {
            $rs = $con->executeQuery('SELECT d.id FROM st_delivery d WHERE d.type_id = '.$id);
            while($rs->next()) 
            {
                $row = $rs->getRow();
                $ids[] = $row['id'];
            }

        }

        if ($ids) {
            $deliveries = array(
                'ids' => $ids,
                'mode' => 'exclude', 
            );

            $ps = $con->prepareStatement('UPDATE st_product p, st_paczkomaty_has_product php SET p.DELIVERIES = ? WHERE p.ID = php.PRODUCT_ID AND php.DISABLE_DELIVERY = 1');

            $ps->setString(1, serialize($deliveries));
            $ps->executeQuery();
        }
    } 
    catch(Exception $e)
    {

    }  
}

if (version_compare($version_old, '7.2.0.8', '<'))
{
    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize(); 
        $con = Propel::getConnection();
        
        $c = new Criteria();
        $c->add(DeliveryTypePeer::TYPE, 'ppo');
        
        if (!DeliveryTypePeer::doCount($c))
        {
            $dt = new DeliveryType();
            $dt->setName('Poczta Polska - Odbiór w punkcie');
            $dt->setType('ppo');
            $dt->save();
        }
   
        $con->executeQuery("UPDATE st_delivery_type d SET d.type = 'ppk', d.name = 'Poczta Polska - Kurier' WHERE d.type = 'pp'");
    }
    catch(Exception $e)
    {        
    }
}
