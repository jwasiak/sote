<?php

if (version_compare($version_old, '2.0.0.11', '<'))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    $privacy = WebpagePeer::retrieveByPk(4);
    if ($privacy)
    {
        $privacy->setState("PRIVACY");
        $privacy->save();
    }
        
    $terms = WebpagePeer::retrieveByPk(2);
    if ($terms)
    {
        $terms->setState("TERMS");
        $terms->save();
    }
}

if (version_compare($version_old, '1.0.2.31', '<'))
{
    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $webpageGroups = WebpageGroupPeer::doSelect($c);
        foreach ($webpageGroups as $webpageGroup)
        {
            $webpageGroup->setCulture('pl_PL');
            $webpageGroup->setName($webpageGroup->getName());
            if ($webpageGroup->getName()=="Stopka")
            {
                $webpageGroup->setCulture('en_US');
                $webpageGroup->setName('Footer');
            }
            $webpageGroup->save();
        }
    }
    catch (Exception $e)
    {
        if (SF_ENVIRONMENT == 'dev')
        {
            throw new PropelException($e);
        }
    }
}

if (version_compare($version_old, '1.1.1', '<'))
{
    try
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $webpageGroups = WebpageGroupPeer::doSelect($c);
        foreach ($webpageGroups as $webpageGroup)
        {

            if ($webpageGroup->getGroupPage() == 'FOOTER')
            {
                $webpageGroup->setCulture('pl_PL');
                $webpageGroup->setName('Informacje');
                $webpageGroup->setCulture('en_US');
                $webpageGroup->setName('Information');
                $webpageGroup->setShowFooter(1);
                $webpageGroup->save();
            }
            if ($webpageGroup->getGroupPage() == 'HEADER')
            {
                $webpageGroup->setShowHeader(1);
                $webpageGroup->save();
            }
        }

    }
    catch (Exception $e)
    {
        if (SF_ENVIRONMENT == 'dev')
        {
            throw new PropelException($e);
        }
    }



}