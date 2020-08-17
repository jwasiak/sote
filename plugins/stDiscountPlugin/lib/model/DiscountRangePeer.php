<?php
/**
 * 
 *
 */

class DiscountRangePeer extends BaseDiscountRangePeer
{
    public static function getDiscountsForSelect() 
    {
        $items = array();

        $c = new Criteria();

        $c->add(DiscountPeer::TYPE, 'P');

        foreach (DiscountPeer::doSelect($c) as $item) 
        {
            $items[$item->getId()] = $item->getName();
        }

        return $items;
    }   
}
