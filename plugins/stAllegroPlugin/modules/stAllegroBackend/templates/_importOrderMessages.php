<table class="st_record_list st_record_manager" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th width="25%"><?php echo __('Nazwa aukcji');?></th>
            <th width="8%"><?php echo __('Numer aukcji');?></th>
            <th width="10%"><?php echo __('Numer zamówienia');?></th>
            <th><?php echo __('Komunikat');?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($messages as $id => $message):?>
            <?php list($auctionId, $orderId) = explode('_', $id);?>
            <?php $auction = AllegroAuctionPeer::retrieveByPK($auctionId);?>
            <?php $order = OrderPeer::retrieveByPK($orderId);?>
            <?php if (is_object($auction)): ?>
                <tr>
                    <td><?php echo st_external_link_to($auction->getName(), '@stAllegroPlugin?action=edit&id=' . $auction->getAuctionId() . '&product_id=' . $auction->getProductId(), array('target'=>'_blank'));?></td>
                    <td><?php echo st_external_link_to($auction->getAuctionId(), '@stAllegroPlugin?action=edit&id=' . $auction->getAuctionId() . '&product_id=' . $auction->getProductId(), array('target'=>'_blank'));?></td>
                    <td><?php echo is_object($order) ? st_external_link_to($order->getNumber(), 'stOrder/edit?id='.$orderId, array('target'=>'_blank')) : '-';?></td>
                    <td><?php echo ($message !== true) ? __($message, null, 'stAllegroMessages') : '-';?></td>
                </tr>
            <?php endif;?>
        <?php endforeach;?>
    </tbody>
</table>
