<?php
/** 
 * SOTESHOP/stAllegroPlugin 
 * 
 * Ten plik należy do aplikacji stAllegroPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAllegroPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: AllegroAuctionHasOrderPeer.php 4776 2010-04-28 08:58:48Z piotr $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */
 
/** 
 * Klasa AllegroAuctionHasOrderPeer
 *
 * @package     stAllegroPlugin
 * @subpackage  libs
 */
class AllegroAuctionHasOrderPeer extends BaseAllegroAuctionHasOrderPeer {
    public static function exists($trans_id, AllegroAuction $auction)
    {
        $c = new Criteria();
        $c->add(self::TRANS_ID, $trans_id);
        $c->add(self::ALLEGRO_AUCTION_ID, $auction->getAuctionId());
        return self::doCount($c) > 0;
    }
}
