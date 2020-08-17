<?php 

class stCompatibilityOnlineProducts {

    public static function isBasketHasProductOnline($basket) {
        foreach ($basket->getItems() as $product)
            if (is_object($product->getProduct()))
                $productIds[] = $product->getProduct()->getId();

        if (!empty($productIds)) {
            $cC = new Criteria();
            $cC->add(OnlineCodesPeer::PRODUCT_ID, $productIds, Criteria::IN);

            $cF = new Criteria();
            $cF->add(OnlineFilesPeer::PRODUCT_ID, $productIds, Criteria::IN);

            return (bool)(OnlineCodesPeer::doCount($cC) || OnlineFilesPeer::doCount($cF));
        } else 
            return FALSE;
    }
}
