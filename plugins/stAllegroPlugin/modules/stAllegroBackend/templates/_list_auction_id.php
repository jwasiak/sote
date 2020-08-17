<?php echo $allegro_auction->getAuctionId() ? st_external_link_to($allegro_auction->getAuctionId(), $allegro_auction->getAuctionLink(), array('target' => '_blank')) : '-';
