<?php
if (version_compare($version_old, '1.1.0.10', '<'))
{
    try {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->add(CurrencyPeer::SHORTCUT, 'CZK');

        if(!CurrencyPeer::doCount($c))
        {
            $newCurrency1 = new Currency();
            $newCurrency1->setCulture('pl_PL');
            $newCurrency1->setShortcut("CZK");
            $newCurrency1->setExchange(0.1500);
            $newCurrency1->setActive(1);
            $newCurrency1->setMain(0);
            $newCurrency1->setBackSymbol("Kč");
            $newCurrency1->setSystem(1);
            $newCurrency1->setName("Korona czeska");
            $newCurrency1->setCulture('en_US');
            $newCurrency1->setName("Czech koruna");
            $newCurrency1->save();
        }

        $c = new Criteria();
        $c->add(CurrencyPeer::SHORTCUT, 'RUB');

        if(!CurrencyPeer::doCount($c))
        {
            $newCurrency2 = new Currency();
            $newCurrency2->setCulture('pl_PL');
            $newCurrency2->setShortcut("RUB");
            $newCurrency2->setExchange(0.0900);
            $newCurrency2->setActive(1);
            $newCurrency2->setMain(0);
            $newCurrency2->setBackSymbol("руб");
            $newCurrency2->setSystem(1);
            $newCurrency2->setName("Ruble rosyjskie");
            $newCurrency2->setCulture('en_US');
            $newCurrency2->setName("Russian ruble");
            $newCurrency2->save();
        }

        $c = new Criteria();
        $c->add(CurrencyPeer::SHORTCUT, 'GBP');

        if(!CurrencyPeer::doCount($c))
        {
            $newCurrency3 = new Currency();
            $newCurrency3->setCulture('pl_PL');
            $newCurrency3->setShortcut("GBP");
            $newCurrency3->setExchange(4.5700);
            $newCurrency3->setActive(1);
            $newCurrency3->setMain(0);
            $newCurrency3->setFrontSymbol("£");
            $newCurrency3->setSystem(1);
            $newCurrency3->setName("Funt brytyjski");
            $newCurrency3->setCulture('en_US');
            $newCurrency3->setName("Pound sterling");
            $newCurrency3->save();
        }
    } catch(Exception $e) {

    }
}


if (version_compare($version_old, '2.1.0.11', '<'))
{
    $config = stConfig::getInstance('stCurrencyPlugin');
    $config->set('inverse', true);
    $config->save(true);
}