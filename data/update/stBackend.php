<?php
if (version_compare($version_old, '2.1.0.15', '<'))
{
    try
    {
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    $c = new Criteria();
    $dashboardGadgets = DashboardGadgetPeer::doSelect($c);
    
    if($dashboardGadgets){
        
        foreach ($dashboardGadgets as $gadgets)
        {
            if($gadgets->getName()=="google_documents" || $gadgets->getName()=="currency_widget" || $gadgets->getName()=="google_documents" || $gadgets->getName()=="exchange_widget" || $gadgets->getName()=="facebook_widget" || $gadgets->getName()=="google_calc" || $gadgets->getName()=="google_calendar"  || $gadgets->getName()=="exchange2_widget"){
                $gadgets->delete();
            }
        } 
    }


    $databaseManager->shutdown();
    }
    catch (Exception $e)
    {
        if (SF_ENVIRONMENT == 'dev')
        {
            throw new PropelException($e);
        }
    }
}

if (version_compare($version_old, '2.1.7.6', '<') && stLicense::isOpen())
{
    $tmp = sfConfig::getAll();
    
    $configHandler = new sfDefineEnvironmentConfigHandler();
    $configHandler->initialize(array('prefix' => 'app_'));
    
    $root_dir = sfConfig::get('sf_root_dir');
    $data = substr($configHandler->execute(array($root_dir.'/apps/backend/config/app.yml')), 5);
    eval($data);

    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize(); 
        foreach (DashboardPeer::doSelect(new Criteria()) as $dashboard)
        {
            $gadget = DashboardGadgetPeer::doCreate('sote_news', $dashboard->getId(), array('column' => $dashboard->getLayoutColumns()));

            $gadget->save();
        }
    }
    catch (Exception $e)
    {
    }  

    sfConfig::clear();
    sfConfig::add($tmp);
}

if (version_compare($version_old, '2.1.7.7', '<') && !stLicense::isOpen())
{
    $tmp = sfConfig::getAll();
    
    $configHandler = new sfDefineEnvironmentConfigHandler();
    $configHandler->initialize(array('prefix' => 'app_'));
    
    $root_dir = sfConfig::get('sf_root_dir');
    $data = substr($configHandler->execute(array($root_dir.'/apps/backend/config/app.yml')), 5);
    eval($data);

    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize(); 

        $c = new Criteria();
        $c->add(DashboardPeer::IS_DEFAULT, true);
        $dashboard = DashboardPeer::doSelectOne($c);

        if (null !== $dashboard)
        {
            $gadget = DashboardGadgetPeer::doCreate('sote_news', $dashboard->getId(), array('column' => $dashboard->getLayoutColumns()));

            $gadget->save();
        }
    }
    catch (Exception $e)
    {
    }  

    sfConfig::clear();
    sfConfig::add($tmp);    
}

if (version_compare($version_old, '2.2.0.0', '<') && !stLicense::isOpen())
{
    $tmp = sfConfig::getAll();

    $configHandler = new sfDefineEnvironmentConfigHandler();
    $configHandler->initialize(array('prefix' => 'app_'));

    $root_dir = sfConfig::get('sf_root_dir');
    $data = substr($configHandler->execute(array($root_dir.'/apps/backend/config/app.yml')), 5);
    eval($data);

    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->add(DashboardPeer::IS_DEFAULT, true);
        $dashboard = DashboardPeer::doSelectOne($c);

        if (null !== $dashboard)
        {
            $column = $dashboard->getLayoutColumns();

            foreach ($dashboard->getGadgetsByColumn($column) as $gadget)
            {
                if ($gadget->getName() == 'soteshop_movie2' || $gadget->getName() == 'soteshop_movie1')
                {
                    $gadget->delete();
                }
            }
        }
    }
    catch (Exception $e)
    {
    }

    sfConfig::clear();
    sfConfig::add($tmp);
} 
