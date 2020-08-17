<?php
class stRepairKitActions extends sfActions
{
    /**
     *
     * Baza danych
     *
     * @var sfDatabaseManager
     */
    protected $dbm = null;

    public function executeIndex()
    {

    }

    /**
     *
     * Naprawa zagnieżdżeń kategorii
     *
     */
    public function executeRepairCategories()
    {
        stRepairKitProgressBar::cleanSession(stRepairKitProgressBar::CATEGORY_NAMESPACE);
        
        $select = new Criteria();

        $select->add(CategoryPeer::PARENT_ID, null, Criteria::ISNOTNULL);

        $update = new Criteria();

        $update->add(CategoryPeer::SCOPE, null);

        $con = Propel::getConnection();

        $category = BasePeer::doUpdate($select, $update, $con);

        $this->steps = CategoryPeer::doCount(new Criteria());

        $c = new Criteria();

        $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);

        $c->addAscendingOrderByColumn(CategoryPeer::LFT);

        $roots = CategoryPeer::doSelect($c);

        foreach ($roots as $root)
        {
            $root->setCulture('pl_PL');

            $root->setLft(null);

            $root->makeRoot();

            $root->setScope($root->getId());

            $root->save();
        }
    }

    public function executeRepairAssetFolders()
    {
        stRepairKitProgressBar::cleanSession(stRepairKitProgressBar::ASSET_FOLDER_NAMESPACE);

        $select = new Criteria();

        $select->add(sfAssetFolderPeer::TREE_PARENT, null, Criteria::ISNOTNULL);

        $update = new Criteria();

        $update->add(sfAssetFolderPeer::STATIC_SCOPE, null);

        $con = Propel::getConnection();

        $category = BasePeer::doUpdate($select, $update, $con);

        $this->steps = sfAssetFolderPeer::doCount(new Criteria());

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
    }



    /**
     *
     * Inicjalizacja połączenia bazą danych i załadowanie konfiguracji wszystkich pluginów
     *
     */
    public function preExecute()
    {

        sfLoader::loadPluginConfig();

        $this->dbm = new sfDatabaseManager();

        $this->dbm->initialize();

        parent::preExecute();
    }

    /**
     *
     * Zamknięcie połączenia z bazą danych
     *
     */
    public function postExecute()
    {
        $this->dbm->shutdown();

        parent::postExecute();
    }
}
?>
