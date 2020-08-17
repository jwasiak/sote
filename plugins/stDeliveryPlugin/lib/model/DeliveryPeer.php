<?php

/**
 * Subclass for performing query and update operations on the 'st_delivery' table.
 *
 *
 *
 * @package plugins.stDeliveryPlugin.lib.model
 */
class DeliveryPeer extends BaseDeliveryPeer
{
    protected static $cachedIds = null;
    protected static $cachedAllowedIds = null;

    public static function doSelectPaymentsWithDeliveryHasPaymentsByPK($pk, $con = null)
    {
        $c = new Criteria();

        $c->addJoin(PaymentTypePeer::ID, sprintf("%s AND %s = %d", DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID, DeliveryHasPaymentTypePeer::DELIVERY_ID, $pk), Criteria::LEFT_JOIN);

        $c->add(PaymentTypePeer::ACTIVE, true);

        $c->addDescendingOrderByColumn(DeliveryHasPaymentTypePeer::IS_ACTIVE);

        $c->addAscendingOrderByColumn(DeliveryHasPaymentTypePeer::ID);

        $joinHelper = new sfPropelCustomJoinHelper('PaymentType');

        $joinHelper->addSelectTables('DeliveryHasPaymentType');

        stEventDispatcher::getInstance()->notify(new sfEvent($c, 'DeliveryPeer.doSelectPaymentsWithDeliveryHasPaymentsByPK'));

        return $joinHelper->doSelect($c, $con);
    }

    public static function doSelectCountryAreaWithDeliveryHasCountryAreaByPK($pk, $con = null)
    {
        $c = new Criteria();

        $c->addJoin(CountriesAreaPeer::ID, sprintf("%s AND %s = %d", DeliveryHasCountriesAreaPeer::COUNTRIES_AREA_ID, DeliveryHasCountriesAreaPeer::DELIVERY_ID, $pk), Criteria::LEFT_JOIN);

        $c->addAscendingOrderByColumn(DeliveryHasCountriesAreaPeer::ID);

        $joinHelper = new sfPropelCustomJoinHelper('CountriesArea');

        $joinHelper->addSelectTables('DeliveryHasCountriesArea');

        return $joinHelper->doSelect($c, $con);
    }

    public static function doSelectDefault(Criteria $c, $con = null)
    {
        $criteria = clone $c;

        $criteria->add(self::IS_DEFAULT, true);

        return self::doSelectOne($criteria, $con);
    }

    public static function retrieveIdsCached()
    {
        if (null === self::$cachedIds)
        { 
            self::$cachedIds = stFunctionCache::getInstance('stDelivery')->cacheCall(array('DeliveryPeer', 'retrieveIds'), array(), array('id' => 'delivery-ids'));
        }

        return self::$cachedIds;
    }

    public static function retrieveAllowedIdsCached()
    {
        if (null === self::$cachedAllowedIds)
        { 
            self::$cachedAllowedIds = stFunctionCache::getInstance('stDelivery')->cacheCall(array('DeliveryPeer', 'retrieveIds'), array(false), array('id' => 'delivery-allowed-ids'));
        }

        return self::$cachedAllowedIds;
    }

    public static function retrieveIds($allowed_in_selected_products = null)
    {
        $c = new Criteria();
        $c->addSelectColumn(self::ID);
        $c->add(self::ACTIVE, true);

        if (null !== $allowed_in_selected_products)
        {
            $c->add(self::ALLOW_IN_SELECTED_PRODUCTS, $allowed_in_selected_products);
        }

        $rs = self::doSelectRS($c);

        $ids = array();

        while($rs->next())
        {
            $row = $rs->getRow();
            $ids[$row[0]] = $row[0];
        }

        return $ids;        
    }

    public static function retrieveIdsFor($totals, Criteria $criteria)
    {
        $c = clone $criteria;

        $c->clearSelectColumns();

        $c->addSelectColumn('MIN('.self::VOLUME.')');
        $c->add(DeliveryPeer::WIDTH, $totals['width'], Criteria::GREATER_EQUAL);
        $c->add(DeliveryPeer::HEIGHT, $totals['height'], Criteria::GREATER_EQUAL);
        $c->add(DeliveryPeer::DEPTH, $totals['depth'], Criteria::GREATER_EQUAL);
        $c->add(DeliveryPeer::VOLUME, $totals['volume'], Criteria::GREATER_EQUAL);

        $c->addGroupByColumn(self::TYPE_ID);
        $sql = BasePeer::createSqlQuery($c);
        $c = clone $criteria;
        $c->clearSelectColumns();
        $c->addSelectColumn(self::ID);
        $c->add(self::VOLUME, sprintf('(%s = 0 OR %s IN (%s))', self::VOLUME, self::VOLUME, $sql), Criteria::CUSTOM);
        $c->add(self::TYPE_ID, null, Criteria::ISNOTNULL);
        $c->addGroupByColumn(self::TYPE_ID);

        $rs = self::doSelectRS($c);

        $volumes = array();

        while($rs->next())
        {
            $row = $rs->getRow();
            $volumes[] = $row[0];
        }

        return $volumes;
    }
}
