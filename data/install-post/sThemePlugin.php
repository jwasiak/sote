<?php
try {
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();

    $con = Propel::getConnection();

    $theme = ThemePeer::doSelectActive();
    if (is_object($theme) && in_array($theme->getName(), array('argento', 'coffeestore', 'giallo', 'moderno', 'quattro', 'segno'))) {
        $sql = 'SELECT '.CategoryPeer::ID.' FROM '.CategoryPeer::TABLE_NAME.' WHERE '.CategoryPeer::OPT_NAME.' = "Menu" LIMIT 1;';
        $stmt = $con->prepareStatement($sql);
        $rs = $stmt->executeQuery(ResultSet::FETCHMODE_NUM);
        $rs->next();
        $categoryId = $rs->getInt(1);
        if ($categoryId) {
            $config = stConfig::getInstance('appCategoryHorizontalBackend');
            $config->set('menu_on', 1);
            $config->set('category_id', $categoryId);
            $config->save(true);
        }
    }

    if (is_object($theme) && in_array($theme->getName(), array('sportivo'))) {
        $sql = 'SELECT '.CategoryPeer::ID.' FROM '.CategoryPeer::TABLE_NAME.' WHERE '.CategoryPeer::OPT_NAME.' = "Kategorie" OR '.CategoryPeer::OPT_NAME.' = "Categories" LIMIT 1;';
        $stmt = $con->prepareStatement($sql);
        $rs = $stmt->executeQuery(ResultSet::FETCHMODE_NUM);
        $rs->next();
        $categoryId = $rs->getInt(1);
        if ($categoryId) {
            $config = stConfig::getInstance('appCategoryHorizontalBackend');
            $config->set('menu_on', 1);
            $config->set('category_id', $categoryId);
            $config->save(true);
        }
    }

    if (is_object($theme) && in_array($theme->getName(), array('quattro', 'sportivo'))) {
        $c = new Criteria();
        $c->add(ProductGroupPeer::PRODUCT_GROUP, 'MAIN_PAGE');
        $productGroup = ProductGroupPeer::doSelectOne($c);
        if (is_object($productGroup)) {
            $productGroup->setProductLimit(8);
            $productGroup->save();
        }
    }

    $databaseManager->shutdown();
} catch(Exception $e) {}
