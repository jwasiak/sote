<?php 
/**
 * @var Order $order
 * @var Payment $payment
 */
use_helper('stCurrency');
?>
<table border="1" cellpadding="0" cellspacing="0" style="font-size: 8px">
    <tr>
        <td>
            <table cellspacing="0" cellpadding="4" width="502">
                <tr>
                    <td bgcolor="#ccc">
                        <b><?php echo __('Dane płatności') ?></b>
                    </td>
                </tr>
            </table>
            <?php if($order->getOrderPayment()->getId()): ?>
                <table border="0" cellspacing="0" cellpadding="4" width="502">
                    <thead>
                        <tr>
                            <th bgcolor="#eee" width="62"><?php echo __('Id') ?></th>
                            <th bgcolor="#eee" width="120"><?php echo __('Data dokonania płatności') ?></th>
                            <th bgcolor="#eee" width="180"><?php echo __('Typ płatności') ?></th>
                            <th bgcolor="#eee" width="60"><?php echo __('Status') ?></th>
                            <th bgcolor="#eee" width="80" align="right"><?php echo __('Kwota') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order->getOrderPayments() as $payment): 
  
                        ?>
                            <tr>
                                <td width="62"><?php echo $payment->getId() ?></td>
                                <td width="120"><?php echo $payment->getPayedAt() ?></td>
                                <td width="180"><?php echo $payment->getPaymentType() ?></td>
                                <td width="60">
                                    <?php if ($payment->getStatus()): ?>
                                        <?php echo __('Rozliczona') ?>
                                    <?php else: ?>
                                        <?php echo __('Nierozliczona') ?>
                                    <?php endif; ?>
                                </td>
                                <td width="80" align="right"><?php echo st_order_price_format($payment->getAmount(), $order->getOrderCurrency());?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </td>
    </tr>
</table>