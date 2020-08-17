<?php
if (version_compare($version_old, '1.0.1.13', '<='))
{
    $databaseManager = new sfDatabaseManager();

    $databaseManager->initialize();

    $con = Propel::getConnection();

    $con->executeQuery('UPDATE st_product p, st_product_has_wholesale phw SET p.wholesale_a_netto = phw.price_a, p.wholesale_a_brutto = phw.opt_price_brutto_a, p.wholesale_b_netto = phw.price_b, p.wholesale_b_brutto = phw.opt_price_brutto_b, p.wholesale_c_netto = phw.price_c, p.wholesale_c_brutto = phw.opt_price_brutto_c WHERE p.id = phw.product_id');
}

if (version_compare($version_old, '7.0.0.2', '<='))
{
    $databaseManager = new sfDatabaseManager();

    $databaseManager->initialize();

    $con = Propel::getConnection();

    $con->executeQuery("UPDATE sf_guard_user SET wholesale = '0' WHERE wholesale IS NULL");
}