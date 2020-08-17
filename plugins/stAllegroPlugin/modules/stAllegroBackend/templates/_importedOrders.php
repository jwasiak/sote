<?php use_helper('stOrder', 'stDate') ?>
<?php if ($orders): $currency = CurrencyPeer::retrieveByIso('PLN') ?>
    <table class="st_record_list st_record_manager" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="10%"><?php echo __('Numer zamówienia');?></th>
                <th><?php echo __('Złożone') ?></th>
                <th><?php echo __('Kwota') ?></th>
                <th><?php echo __('Oferty');?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $order):?>
                <tr>
                    <td><a href="<?php echo st_url_for('@stOrder?action=edit&id=' . $order['id']) ?>" target="_blank"><?php echo $order['number'] ?></a></td>
                    <td><?php echo st_format_date($order['created_at']) ?></td>
                    <td><?php echo st_order_price_format($order['total_amount'], $currency) ?></td>
                    <td>
                        <?php foreach ($order['offers'] as $id): ?>
                            <p><a href="<?php echo url_for('@stAllegroPlugin?action=edit&id=' . $id) ?>" target="_blank"><?php echo $id ?></a></p>
                        <?php endforeach ?>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>

<?php else: ?>
<p>
    <?php echo __('Brak nowych zamówień') ?>
</p>
<?php endif ?>
