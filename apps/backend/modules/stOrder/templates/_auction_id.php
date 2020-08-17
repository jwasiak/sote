<?php foreach (AllegroAuctionPeer::getAuctionsByOrder($order) as $auction):?>
    <?php echo st_external_link_to($auction->getAuctionId(), $auction->getAuctionLink(), array('target'=>'_new'));?><br />
<?php endforeach;?>
