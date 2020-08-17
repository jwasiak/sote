<?php echo $allegro_auction->getAuctionId() ? ($allegro_auction->getEnded() ? __('Zakończona') : __('Wystawiona')) : __('Do wystawienia');
