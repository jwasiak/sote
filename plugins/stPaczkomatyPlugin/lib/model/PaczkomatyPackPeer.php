<?php

class PaczkomatyPackPeer extends BasePaczkomatyPackPeer {

    public static function retrieveByCode($code, $con = null) {
        $c = new Criteria();
        $c->add(PaczkomatyPackPeer::CODE, $code);
        return PaczkomatyPackPeer::doSelectOne($c, $con);
    }

    public static function retrieveByOrder(Order $order)
    {
        $c = new Criteria();
        $c->add(self::ORDER_ID, $order->getId());
        $c->addDescendingOrderByColumn(self::ID);
        return self::doSelectOne($c);
    }
}
