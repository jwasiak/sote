<td class="st-allegro-list-auction-table-actions">
    <ul class="st_object_actions">
        <?php if($allegro_auction->getAuctionId()):?>
            <li><?php echo link_to(image_tag('/images/backend/icons/view.png', array('alt' => __('Podgląd'), 'title' => __('Podgląd'))), 'stProduct/allegroEdit?id='.$allegro_auction->getId().'&product_id='.$allegro_auction->getProductId().'&list=stAllegroPlugin');?></li>
        <?php else:?>
            <li><?php echo link_to(image_tag('/images/backend/icons/edit.png', array('alt' => __('Edycja'), 'title' => __('Edycja'))), 'stProduct/allegroEdit?id='.$allegro_auction->getId().'&product_id='.$allegro_auction->getProductId().'&list=stAllegroPlugin');?></li>
            <li><?php echo link_to(image_tag('/images/backend/icons/auction.png', array('alt' => __('Wystaw'), 'title' => __('Wystaw'))), 'stAllegroBackend/sale?id='.$allegro_auction->getId());?></li>
        <?php endif;?>
        <li><?php echo link_to(image_tag('/images/backend/icons/duplicate.png', array('alt' => __('Kopiuj'), 'title' => __('Kopiuj'))), 'stAllegroBackend/duplicate?id='.$allegro_auction->getId());?></li>

        <?php if ($allegro_auction->getEnded() && 1==2): ?>
            <li><?php echo link_to(image_tag('/images/backend/icons/refresh.png', array('alt' => __('Wystaw ponownie'), 'title' => __('Wystaw ponownie'))), 'stAllegroBackend/copy?id='.$allegro_auction->getId()."&resale=1") ?></li>
        <?php endif; ?>

        <li><?php echo link_to(image_tag('/images/backend/icons/delete.png', array('alt' => __('Usuń'), 'title' => __('Usuń'))), 'stAllegroBackend/delete?id='.$allegro_auction->getId().'&product_id='.$allegro_auction->getProductId(), array('post' => true, 'confirm' => __('Czy na pewno chcesz usunąć?', null, 'stAllegroBackend')));?></li>
    </ul>
</td>
