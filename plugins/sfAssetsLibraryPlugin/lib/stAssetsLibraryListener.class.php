<?php
class stAssetsLibraryListener
{
    public static function postInstall(sfEvent $event)
    {
        sfLoader::loadHelpers('stProgressBar');
        sfLoader::loadHelpers('Partial');

        $dbm = new sfDatabaseManager();

        $dbm->initialize();

        stRepairKitProgressBar::cleanSession(stRepairKitProgressBar::ASSET_FOLDER_NAMESPACE);

        $select = new Criteria();

        $select->add(sfAssetFolderPeer::TREE_PARENT, null, Criteria::ISNOTNULL);

        $update = new Criteria();

        $update->add(sfAssetFolderPeer::STATIC_SCOPE, null);

        $con = Propel::getConnection();

        $category = BasePeer::doUpdate($select, $update, $con);

        $steps = sfAssetFolderPeer::doCount(new Criteria());

        $c = new Criteria();

        $c->add(sfAssetFolderPeer::TREE_PARENT, null, Criteria::ISNULL);

        $c->addAscendingOrderByColumn(sfAssetFolderPeer::ID);

        $roots = sfAssetFolderPeer::doSelect($c);

        foreach ($roots as $root)
        {
            $root->setTreeLeft(null);

            $root->makeRoot();

            $root->setStaticScope($root->getId());

            $root->save();
        }

        $event->getSubject()->msg .= progress_bar('stRepairKit', 'stRepairKitProgressBar', 'repairAssetFolders', $steps);
    }
}
