<?php
if (version_compare($version_old, '1.0.4.9', '<'))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    $c = new Criteria();
    $c->add(CategoryI18nPeer::CULTURE, '');
    CategoryI18nPeer::doDelete($c);
}

if (version_compare($version_old, '7.2.0.26', '<'))
{
    $file = sfConfig::get('sf_root_dir')."/apps/backend/modules/stOrder/templates/webapi.wsdl";

    if (is_file($file))
    {
        unlink($file);
    }
}