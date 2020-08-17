<ul class="st_object_actions">
    <?php if($allegro_auction->getAuctionId()):?>
        <li><?php echo link_to(image_tag('/images/backend/icons/view.png', array('alt' => __('Podgląd'), 'title' => __('Podgląd'))), 'stProduct/allegroEdit?id='.$allegro_auction->getId().'&product_id='.$allegro_auction->getProductId().'&list=stAllegroPlugin');?></li>
    <?php else:?>
        <li><?php echo link_to(image_tag('/images/backend/icons/edit.png', array('alt' => __('Edycja'), 'title' => __('Edycja'))), 'stProduct/allegroEdit?id='.$allegro_auction->getId().'&product_id='.$allegro_auction->getProductId().'&list=stAllegroPlugin');?></li>
    <?php endif;?>
</ul>
