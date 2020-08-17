<?php use_helper('stPaypal') ?>
<?php if ($paypal_response->isSuccessful()): ?>
<?php $items = $paypal_response->getItems() ?>
<?php if (count($items) > 1): ?>
<table class="st_record_list" cellspacing="0">
    <thead>
        <tr>
<?php foreach ($items as $balance): ?>
            <th><?php echo $balance->getCurrencyCode() ?></th>
<?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <tr>
<?php foreach ($items as $balance): ?>
            <td><?php echo $balance->getAmt() ?></td>
<?php endforeach; ?>
        </tr>
    </tbody>
</table>
<?php else: ?>
<?php echo $items[0]->getAmt() . ' ' . $items[0]->getCurrencyCode() ?>
<?php endif; ?>
<?php else: ?>
    <?php echo __('Wystąpiły problemy podczas próby połączenia z Paypal') ?>
<?php endif; ?>

