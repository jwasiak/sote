<?php
if (version_compare($version_old, '1.0.1', '<='))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();
    
    $taxes = TaxPeer::doSelect(new Criteria());
    foreach ($taxes as $tax)
    {
        $vatName = $tax->getVatName();
        if (empty($vatName))
        {
            $tax->setVatName($tax->getVat()."%");
            $tax->save();
        }
    }
    
    $newTax1 = new Tax();
    $newTax1->setVat(0);
    $newTax1->setVatName("ue");
    $newTax1->save();
    
    $newTax2 = new Tax();
    $newTax2->setVat(0);
    $newTax2->setVatName("ex");
    $newTax2->save();
    
    $newTax3 = new Tax();
    $newTax3->setVat(0);
    $newTax3->setVatName("zw");
    $newTax3->save();
}

if (version_compare($version_old, '7.0.0.8', '<'))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();
    
    $c = new Criteria();
    $c->add(TaxPeer::VAT_NAME, 'ex');
    $tax = TaxPeer::doSelectOne($c);

    if (null === $tax)
    {
        $tax = new Tax();
        $tax->setVat(0);
        $tax->setVatName("ex");
    }

    $tax->setIsSystemDefault(true);
    $tax->save(); 

    $c = new Criteria();
    $c->add(TaxPeer::VAT_NAME, 'zw');
    $tax = TaxPeer::doSelectOne($c);

    if (null === $tax)
    {
        $tax = new Tax();
        $tax->setVat(0);
        $tax->setVatName("zw");
    }

    $tax->setIsSystemDefault(true);
    $tax->save();  

    $c = new Criteria();
    $c->add(TaxPeer::VAT_NAME, 'ue');
    $tax = TaxPeer::doSelectOne($c);

    if (null === $tax)
    {
        $tax = new Tax();
        $tax->setVat(0);
        $tax->setVatName("ue");
    }

    $tax->setIsSystemDefault(true);
    $tax->save();             
}