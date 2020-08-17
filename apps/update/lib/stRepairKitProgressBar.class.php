<?php
class stRepairKitProgressBar
{
    protected $context = null;

    const PROCESS_CATEGORY_COUNT = 40;

    const PROCESS_ASSET_FOLDER_COUNT = 40;

    const CATEGORY_NAMESPACE = 'soteshop/stRepairKit/repairCategories';

    const ASSET_FOLDER_NAMESPACE = 'soteshop/stRepairKit/repairAssetFolders';

    public static function cleanSession($namespace)
    {
        $user = sfContext::getInstance()->getUser();

        $user->getAttributeHolder()->removeNamespace($namespace);
    }

    public static function getSessionVar($name, $default = null, $namespace)
    {
        $user = sfContext::getInstance()->getUser();

        return $user->getAttribute($name, $default, $namespace);
    }

    public static function setSessionVar($name, $value, $namespace)
    {
        $user = sfContext::getInstance()->getUser();

        $user->setAttribute($name, $value, $namespace);
    }

    public function  __construct()
    {
        $this->context = sfContext::getInstance();
    }

    public function init()
    {
        stLock::lock('backend');

        stLock::lock('frontend');
    }

    public function close()
    {
        stLock::unlock('backend');

        stLock::unlock('frontend');

        $this->setMessage('Naprawa została zakończona pomyślnie');
    }

    public function repairAssetFolders($offset)
    {
        $this->initialize();

        $c = new Criteria();

        $c->addAscendingOrderByColumn(sfAssetFolderPeer::ID);

        $c->setOffset($offset);

        $c->setLimit(self::PROCESS_ASSET_FOLDER_COUNT);

        $parents = sfAssetFolderPeer::doSelect($c);

        foreach ($parents as $parent)
        {
            $process_info = $this->assetFolderFixHelper($parent);

            if ($process_info !== null)
            {
                $this->setMessage(sprintf('Naprawa katalogów (%s z %s)', $process_info['processed'], $process_info['to_process']));

                return $offset;
            }

            $offset++;
        }

        $this->setMessage('Naprawa zdjęć w toku');

        return $offset;
    }

    public function repairCategories($offset)
    {
        $this->initialize();

        $c = new Criteria();

        $c->addAscendingOrderByColumn(CategoryPeer::ID);

        $c->setOffset($offset);

        $c->setLimit(self::PROCESS_CATEGORY_COUNT);

        $parents = CategoryPeer::doSelect($c);

        foreach ($parents as $parent)
        {

            $process_info = $this->categoryFixHelper($parent);

            if ($process_info !== null)
            {
                $this->setMessage(sprintf('Naprawa podkategorii (%s z %s)', $process_info['processed'], $process_info['to_process']));

                return $offset;
            }


            $offset++;

        }

        $this->setMessage('Naprawa kategorii w toku...');

        return $offset;
    }

    /**
     *
     * Metoda pomocnicza naprawiająca zagnieżdżenia kategorii
     *
     * @param Category $parent Rodzic
     */
    protected function categoryFixHelper($parent)
    {
        $offset = self::getSessionVar('child-offset', 0, self::CATEGORY_NAMESPACE);

        $c = new Criteria();

        $c->add(CategoryPeer::PARENT_ID, $parent->getId());

        $c->addAscendingOrderByColumn(CategoryPeer::ID);

        $c->setOffset($offset);

        $c->setLimit(self::PROCESS_CATEGORY_COUNT);

        $categories = CategoryPeer::doSelect($c);

        $processed = count($categories);

        if (!$processed)
        {
            return null;
        }

        foreach ($categories as $category)
        {
            $category->setCulture('pl_PL');

            $parent = $parent->reload();

            $parent->setCulture('pl_PL');

            $category->insertAsLastChildOf($parent);

            $category->save();
        }



        $offset += $processed;

        $c = new Criteria();

        $c->add(CategoryPeer::PARENT_ID, $parent->getId());

        $to_process = CategoryPeer::doCount($c);

        if ($offset >= $to_process)
        {
            self::setSessionVar('child-offset', 0 , self::CATEGORY_NAMESPACE);

            return null;
        }
        else
        {
            self::setSessionVar('child-offset', $offset , self::CATEGORY_NAMESPACE);
        }

        return array('processed' => $offset, 'to_process' => $to_process);
    }
    /**
     *
     * Metoda pomocnicza naprawiająca zagnieżdżenia katalogów zdjęć
     *
     * @param sfAssetFolder $parent Rodzic
     */
    protected function assetFolderFixHelper($parent)
    {
        $offset = self::getSessionVar('child-offset', 0, self::ASSET_FOLDER_NAMESPACE);

        $c = new Criteria();

        $c->add(sfAssetFolderPeer::TREE_PARENT, $parent->getId());

        $c->addAscendingOrderByColumn(sfAssetFolderPeer::ID);

        $c->setOffset($offset);

        $c->setLimit(self::PROCESS_ASSET_FOLDER_COUNT);

        $asset_folders = sfAssetFolderPeer::doSelect($c);

        $processed = count($asset_folders);

        if (!$processed)
        {
            return null;
        }

        foreach ($asset_folders as $asset_folder)
        {
            $parent = $parent->reload();

            $asset_folder->insertAsLastChildOf($parent);

            $asset_folder->save();
        }



        $offset += $processed;

        $c = new Criteria();

        $c->add(sfAssetFolderPeer::TREE_PARENT, $parent->getId());

        $to_process = sfAssetFolderPeer::doCount($c);

        if ($offset >= $to_process)
        {
            self::setSessionVar('child-offset', 0 , self::ASSET_FOLDER_NAMESPACE);

            return null;
        }
        else
        {
            self::setSessionVar('child-offset', $offset , self::ASSET_FOLDER_NAMESPACE);
        }

        return array('processed' => $offset, 'to_process' => $to_process);
    }

    protected function setMessage($message)
    {
        $user = $this->context->getUser();

        $user->setAttribute('stProgressBar-stRepairKit', $message, 'symfony/flash');
    }

    protected function initialize()
    {
        sfLoader::loadPluginConfig();

        $dbm = new sfDatabaseManager();

        $dbm->initialize();
    }
}
?>
