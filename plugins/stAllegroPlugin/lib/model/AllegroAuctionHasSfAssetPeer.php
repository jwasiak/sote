<?php

class AllegroAuctionHasSfAssetPeer extends BaseAllegroAuctionHasSfAssetPeer {

    public static function doDeleteByAuctionId($id) {
        $c = new Criteria();
        $c->add(self::ALLEGRO_AUCTION_ID, $id);
        return self::doDelete($c);
    }
}
