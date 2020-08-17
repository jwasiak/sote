<?php

class AllegroCategoryPeer extends BaseAllegroCategoryPeer {

    public static function doSelectByCatId($categoryId, $environment) {
        $c = new Criteria();
        $c->add(self::CAT_ID, $categoryId);
        $c->add(self::SITE, $environment);
        return self::doSelectOne($c);
    }

    public static function doSelectCategoriesTokens(Criteria $c) {
        $tokens = array();

        $c = clone $c;
        $c->addSelectColumn(self::ID);
        $c->addSelectColumn(self::NAME);
        $c->addSelectColumn(self::PARENT);
        $c->addSelectColumn(self::CAT_ID);

        $rs = self::doSelectRs($c);

        return self::categoryTokensHelper($rs, $c->getValue(self::SITE));    
    }

    public static function categoryTokensHelper(ResultSet $rs, $environment)
    {
        $tokens = array();

        $rs->setFetchmode(ResultSet::FETCHMODE_NUM);

        while($rs->next()) {
            $current = $rs->getRow();
            $path = array();
            $parent = $current[2];

            while ($parent != 0) {
                $cc = new Criteria();
                $cc->addSelectColumn(self::NAME);
                $cc->addSelectColumn(self::PARENT);
                $cc->add(self::CAT_ID, $parent);
                $cc->add(self::SITE, $environment);
                $cc->add(self::IS_OLD, 0);

                $rs2 = self::doSelectRs($cc); 
                while($rs2->next()) {
                    $path[$parent] = $rs2->getString(1);
                    $parent = $rs2->getInt(2);
                }
            }

            $path[$current[3]] = $current[1];

            ksort($path);
            $tokens[] = array('id' => $current[3], 'name' => implode(' / ', $path));
        }

        return $tokens;
    }

    public static function doSelectIdCategoryPathById($categoryId, $environment) {
        $path = array();

        $category = AllegroCategoryPeer::doSelectByCatId($categoryId, $environment);
        
        if (is_object($category)) {
            $parent = $category->getParent();

            while($parent != 0) {
                $category = AllegroCategoryPeer::doSelectByCatId($parent, $environment);
                if (is_object($category)) {
                    $path[] = $category->getCatId();
                    $parent = $category->getParent();
                } else 
                    $parent = 0;
            }
        }

        return $path;
    }

    public static function hasCategories($environment) {
        $c = new Criteria();
        $c->add(self::SITE, $environment);
        return (bool) self::doCount($c);
    }
}
