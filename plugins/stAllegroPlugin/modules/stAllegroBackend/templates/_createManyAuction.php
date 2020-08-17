<table class="st_record_list st_record_manager" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><?php echo __('ID');?></th>
            <th><?php echo __('Nazwa aukcji');?></th>
            <th><?php echo __('Numer aukcji');?></th>
            <th><?php echo __('Koszt wystawienia');?></th>
            <th><?php echo __('Komunikat błędu');?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($messages as $id => $message):?>
            <?php $auction = AllegroAuctionPeer::retrieveByPK($id)?>
            <?php if (is_object($auction)):?>
                <tr>
                    <td><?php echo st_external_link_to($auction->getId(), 'stProduct/allegroEdit?id='.$auction->getId().'&product_id='.$auction->getProductId(), array('target'=>'_blank'));?></td>
                    <td><?php echo st_external_link_to($auction->getName(), 'stProduct/allegroEdit?id='.$auction->getId().'&product_id='.$auction->getProductId(), array('target'=>'_blank'));?></td>
                    <td><?php echo ($message === true && $auction->getAuctionId()) ? st_external_link_to($auction->getAuctionId(), $auction->getAuctionLink(), array('target'=>'_blank')) : '-';?></td>
                    <td><?php echo ($message === true && $auction->getAuctionCost()) ? $auction->getAuctionCost() : '-';?></td>
                    <td><?php echo ($message !== true) ? __($message, null, 'stAllegroMessages') : '-';?></td>
                </tr>
            <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
