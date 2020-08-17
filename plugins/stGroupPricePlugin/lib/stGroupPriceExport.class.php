<?php
class stGroupPriceExport {
    static public function getProduct($object = null) {
        return $object -> getGroupPrice();
    }

    static public function setProduct($object = null, $group_price = null) {

        if ($group_price!=null) {
            $c = new Criteria();
            $c -> add(GroupPricePeer::NAME, $group_price);
            $group = GroupPricePeer::doSelectOne($c);

            if (!is_object($group)) {
                $group = new GroupPrice();
                $group -> setName($group_price);
                $group -> save();
            }

            $object -> setGroupPriceId($group -> getId());
        }
        return true;
    }

}
