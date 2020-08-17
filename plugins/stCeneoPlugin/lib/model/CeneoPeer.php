<?php

class CeneoPeer extends BaseCeneoPeer {

    public static function doSelectJoinProductForList(Criteria $c, $con = null) {
        $c = clone $c;
        if ($c->getDbName() == Propel::getDefaultDB()) {
            $c->setDbName(self::DATABASE_NAME);
        }

        CeneoPeer::addSelectColumns($c);
        $startcol2 = (CeneoPeer::NUM_COLUMNS - GoogleShoppingPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

        ProductPeer::addSelectColumns($c);
        $startcol3 = $startcol2 + ProductPeer::NUM_COLUMNS;

        $c->addJoin(CeneoPeer::PRODUCT_ID, ProductPeer::ID, Criteria::RIGHT_JOIN);
        $rs = BasePeer::doSelect($c, $con);
        
        if (self::$hydrateMethod)
        {
           return call_user_func(self::$hydrateMethod, $rs);
        }
        $results = array();

        while ($rs->next()) {
            $omClass = CeneoPeer::getOMClass();

            $cls = Propel::import($omClass);
            $obj1 = new $cls();
            $obj1->hydrate($rs);
                    
            $omClass = ProductPeer::getOMClass();

            $cls = Propel::import($omClass);
            $obj2 = new $cls();
            $obj2->hydrate($rs, $startcol2);

            $newObject = true;
            for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
                $temp_obj1 = $results[$j];
                $temp_obj2 = $temp_obj1->getProduct();              
                if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
                    $newObject = false;
                    $temp_obj2->addCeneo($obj1);                   
                    break;
                }
            }

            if ($newObject) {
                $obj2->initCeneos();
                $obj2->addCeneo($obj1);
            }

            $results[] = self::$postHydrateMethod ? call_use_func(self::$postHydrateMethod, $obj1) : $obj1;
        }
        return $results;
    }

    public static function doCountJoinProductForList(Criteria $criteria, $distinct = false, $con = null)
    {
        $criteria = clone $criteria;

        $criteria->clearSelectColumns()->clearOrderByColumns();
        if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
        } else {
            $criteria->addSelectColumn(ProductPeer::COUNT);
        }

        foreach($criteria->getGroupByColumns() as $column)
        {
            $criteria->addSelectColumn($column);
        }

        $criteria->add(CeneoPeer::ID, 0, Criteria::GREATER_THAN);
        $criteria->addOr(CeneoPeer::ID, null, Criteria::ISNULL);

        $criteria->addJoin(CeneoPeer::PRODUCT_ID, ProductPeer::ID, Criteria::RIGHT_JOIN);

        $rs = CeneoPeer::doSelectRS($criteria, $con);
        if ($rs->next()) {
            return $rs->getInt(1);
        } else {
            return 0;
        }
    }
}
