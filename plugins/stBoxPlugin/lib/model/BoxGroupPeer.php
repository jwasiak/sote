<?php

/**
 * Subclass for performing query and update operations on the 'st_box_group' table.
 *
 *
 *
 * @package plugins.stBoxPlugin.lib.model
 */
class BoxGroupPeer extends BaseBoxGroupPeer
{
    /**
     * Przeciążenie metody pobierającej grupy strony www w odpowiedniej wersji jezykowej
     *
     * @param Criteria $c Kryteria
     * @param mixed $culture Wersja językowa
     * @param CreoleConnection $con Połączenie z bazą danych
     * @return array Produkty
     */
    public static function doSelectWithI18n(Criteria $c, $culture = null, $con = null)
    {
        if ($culture === null)
        {
            $culture = sfContext::getInstance()->getUser()->getCulture();
        }

        if ($c->getDbName() == Propel::getDefaultDB())
        {
            $c->setDbName(self::DATABASE_NAME);
        }

        BoxGroupPeer::addSelectColumns($c);

        $startcol = (BoxGroupPeer::NUM_COLUMNS - BoxGroupPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

        BoxGroupI18nPeer::addSelectColumns($c);

        $c->addJoin(BoxGroupPeer::ID, sprintf("%s AND %s = '%s'", BoxGroupI18nPeer::ID, BoxGroupI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

        $rs = BasePeer::doSelect($c, $con);

        $results = array();

        while($rs->next())
        {

            $omClass = BoxGroupPeer::getOMClass();

            $cls = Propel::import($omClass);
            $obj1 = new $cls();
            $obj1->hydrate($rs);
            $obj1->setCulture($culture);

            $omClass = BoxGroupI18nPeer::getOMClass($rs, $startcol);

            $cls = Propel::import($omClass);
            $obj2 = new $cls();
            $obj2->hydrate($rs, $startcol);

            $obj1->setBoxGroupI18nForCulture($obj2, $culture);
            $obj2->setBoxGroup($obj1);

            $results[] = $obj1;
        }
        return $results;
    }

    public static function doCountWithI18n(Criteria $c, $con = null)
    {
        $c->addJoin(BoxGroupI18nPeer::ID, BoxGroupPeer::ID);

        $c->add(BoxGroupI18nPeer::CULTURE, sfContext::getInstance()->getUser()->getCulture());

        return self::doCount($c, $con);
    }

    public static function doSelectGroupsForBox(Criteria $c = null, $con = null)
    {
        if (is_null($c))
        {
            $c = new Criteria();
        }
        else
        {
            $c = clone $c;
        }

        $c->addAscendingOrderByColumn(BoxGroupI18nPeer::NAME);

        return self::doSelectWithI18n($c, $con);
    }

}
