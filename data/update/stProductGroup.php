<?php

if (version_compare($version_old, '7.0.2.8', '<'))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();
    $config = stConfig::getInstance(sfContext::getInstance(), 'stProductGroup');

    $c = new Criteria();
    $c->add(ProductGroupPeer::PRODUCT_GROUP, "NEW");
    $product_group = ProductGroupPeer::doSelect($c);


    if ($product_group)
    {
        $c->add(ProductGroupPeer::PRODUCT_GROUP, "NEW");
        $c->addJoin(ProductGroupHasProductPeer::PRODUCT_ID, ProductPeer::ID);
        $c->addJoin(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, ProductGroupPeer::ID);
        $products = ProductPeer::doSelectWithI18n($c);
        if ($products)
        {
            $config->set("new_type", "manual");
            $config->save();
        }else{
            $config->set("new_type", "date");
            $config->save();
        }
    }else{
        $config->set("new_type", "date");
        $config->save();
    }
}


if (version_compare($version_old, '1.0.2.9', '<'))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    $product_groups = ProductGroupPeer::doSelect(new Criteria());
    foreach ($product_groups as $product_group)
    {
        $product_group_limit = $product_group->getProductLimit();
        if (empty($product_group_limit))
        {
            $product_group->setProductLimit(6);
            $product_group->save();
        }
    }
}

if (version_compare($version_old, '1.0.3.7', '<'))
{     
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();
    
    $new = new ProductGroup();
    $new->setCulture('pl_PL');
    $new->setName('Nowości');
    $new->setProductGroup('NEW');
    $new->setUrl('nowosci');
    $new->setProductLimit(6);
    $new->save();
    
    $new->setCulture('en_US');
    $new->setName('New Products');
    $new->setUrl('new-products');
    $new->save();
}

if (version_compare($version_old, '2.0.0.21', '<'))
{
    $dispatcher = stEventDispatcher::getInstance();
    $dispatcher->connect('stInstallerTaks.onClose', array('stProductGroupOptimize', 'postInstall'));
}


