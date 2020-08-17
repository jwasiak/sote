<?php use_helper('stPaypal', 'stDate') ?>
<?php if ($paypal_response->isSuccessful() && count($paypal_response->getItems()) > 0): ?>

<table class="st_record_list" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo __('Numer zamówienia') ?></th>
            <th><?php echo __('Data płatności') ?></th>
            <th><?php echo __('Płacący') ?></th>
            <th><?php echo __('Kwota płatności') ?></th>
        </tr>
    </thead>
    <tbody>

<?php foreach ($paypal_response->getItems() as $transaction): ?>
        <tr>
            <td><?php echo st_paypal_order_link($transaction->getTransactionId()) ?></td>
            <td><?php echo st_format_date($transaction->getTimestamp(), 'f') ?></td>
            <td>
                <?php echo $transaction->getName() ?><br />
                <?php echo $transaction->getEmail() ?>
            </td>
            <td><?php echo $transaction->getAmt() ?> <?php echo $transaction->getCurrencyCode() ?></td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>
<?php elseif ($paypal_response->isSuccessful()): ?>
<p><?php echo __('Brak oczekujących płatności') ?></p>
<?php else: ?>
    <?php echo __('Wystąpiły problemy podczas próby połączenia z Paypal') ?>
<?php endif; 

