<?php foreach (AllegroAuctionPeer::doSelectAuctionIdsByOrder($order) as $auction_id): ?>
    <p><a href="<?php echo url_for('@stAllegroPlugin?action=edit&id=' . $auction_id) ?>" target="_blank"><?php echo $auction_id ?></a></p>
<?php endforeach ?>