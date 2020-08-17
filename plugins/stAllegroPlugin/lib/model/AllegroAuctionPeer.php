<?php

class AllegroAuctionPeer extends BaseAllegroAuctionPeer {

    public static function doSelectByProduct($productId, $environment) {
        $c = new Criteria();
        $c->add(self::PRODUCT_ID, $productId);
        $c->add(self::SITE, $environment);
        $c->addAscendingOrderByColumn(self::ID);
        $c->setIgnoreCase(false);
        return self::doSelect($c);
    }

    public static function getAuctionByOrder($order) {
        $c = new Criteria();
        $c->add(AllegroAuctionHasOrderPeer::ORDER_ID, $order->getId());
        $auctionHasOrder = AllegroAuctionHasOrderPeer::doSelectOne($c);

        if (is_object($auctionHasOrder)) {
            $c = new Criteria();
            $c->add(self::AUCTION_ID, $auctionHasOrder->getAllegroAuctionId());
            return self::doSelectOne($c);
        }

        return null;        
    }

    /**
     * Pobiera aukcje dla danego zamówienia
     *
     * @param Order $order
     * @return AllegroAuction[] 
     */
    public static function getAuctionsByOrder(Order $order) {
        $c = new Criteria();
        $c->add(AllegroAuctionHasOrderPeer::ORDER_ID, $order->getId());
        $c->addJoin(self::AUCTION_ID, AllegroAuctionHasOrderPeer::ALLEGRO_AUCTION_ID);
        return self::doSelect($c);
    }

    public static function retrieveByAuctionNumber($number)
    {
        $c = new Criteria();
        $c->add(self::AUCTION_ID, $number);
        return self::doSelectOne($c);        
    }

    /**
     * Pobiera aukcje po id
     *
     * @param Order $order
     * @return AllegroAuction[] 
     */
    public static function doSelectByAuctionIds(array $ids)
    {
        $c = new Criteria();
        $c->add(self::AUCTION_ID, $ids, Criteria::IN);
        
        $offers = array();

        foreach (self::doSelectJoinProduct($c) as $offer)
        {
            $offers[$offer->getAuctionId()] = $offer;
        }   

        return $offers;
    }

    public static function doSelectAuctionIdsByOrder(Order $order)
    {
        $c = new Criteria();
        $c->addSelectColumn(OrderProductPeer::ALLEGRO_AUCTION_ID);
        $c->add(OrderProductPeer::ORDER_ID, $order->getId());
        $rs = OrderProductPeer::doSelectRS($c);

        $ids = array();

        while($rs->next())
        {
            $ids[] = $rs->getInt(1);
        }

        return $ids;
    }

    public static function updateRequiresSync($productId = null, $optionId = null)
    {        
        $updateAt = new DateTime();
        $selCriteria = new Criteria();
        
        if (null !== $productId)
        {
            $selCriteria->add(AllegroAuctionPeer::PRODUCT_ID, $productId);
        }
        
        if ($optionId)
        {
            $selCriteria->add(AllegroAuctionPeer::PRODUCT_OPTIONS, sprintf('(%1$s = \'%2$d\' OR %1$s LIKE \'%%,%2$d\')', AllegroAuctionPeer::PRODUCT_OPTIONS, $optionId), Criteria::CUSTOM);
        }

        $upCriteria = new Criteria();
        $upCriteria->add(AllegroAuctionPeer::REQUIRES_SYNC, true);
        
        BasePeer::doUpdate($selCriteria, $upCriteria, Propel::getConnection());
    }
}
