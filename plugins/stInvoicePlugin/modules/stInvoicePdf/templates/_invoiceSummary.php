<?php use_helper('stCurrency', 'stAllegro') ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="200">
<?php if ($status->getPaidAmount() > 0): ?>
<tr>
<td><font size="8"><b><?php echo __("Zapłacono"); ?>:</b></font></td>
<td><font size="8"><?php echo st_back_price($paid_amount)." ".$shortcut ?></font></td>
</tr>
<tr>
<td><font size="8"><b><?php echo __("Pozostało do zapłaty"); ?>:</b></font></td>
<td><font size="8"><b><?php echo st_back_price($unpaid_amount)." ".$shortcut ?></b></font></td>
</tr>
<?php else: ?>
<tr>
<td><font size="8"><b><?php echo __("Do zapłaty"); ?>:</b></font></td>
<td><font size="8"><?php echo st_back_price($paid_amount)." ".$shortcut; ?></font></td>
</tr>
<?php if ($invoice->getStatus()): ?>
    <tr>   
        <td colspan="2" >
            <font size="8"><?php echo $invoice->getStatus()->getOptPaymentTypeName() ?><?php if ($invoice->getOrder()->getOrderPayment()->getAllegroPaymentType()): ?> - <?php echo st_allegro_payment_type($invoice->getOrder()->getOrderPayment()->getAllegroPaymentType()) ?><?php endif ?></font>
            <?php if($invoice->getMaxDay()!="none"): ?>
                <br/><font size="8"><?php echo __('termin płatności') ?> <?php echo $invoice->getMaxDay(); ?> <?php echo __('dni') ?></font>
            <?php endif ?>                        
        </td>
    </tr>
<?php endif ?>
<?php endif; ?>
</table>
</td>
<td>
<table border="1" cellpadding="0" cellspacing="0" width="100%">
<?php if ($invoice->getIsProforma() && $invoice->hasDiscount() && $invoice->getTotalDiscountAmount()>0): ?>
<tr>
<td align="left"><font size="10"><?php echo __('Razem') ?>:</font></td>
<td align="right"><font size="10"><?php echo st_back_price($invoice->getTotalAmount(false)); ?></font></td>
</tr>
<tr>
<td align="left"><font size="10"><?php echo __('Rabat', null, 'stOrder') ?>:</font></td>
<td align="right"><font size="10">-<?php echo st_back_price($invoice->getTotalDiscountAmount()); ?></font></td>
</tr>
<?php endif ?>
<tr>
<td align="left"><font size="10"><b><?php echo __('Razem do zapłaty') ?>:</b></font></td>
<td align="right"><font size="10"><b><?php echo st_back_price($invoice->getTotalAmount())." ".$shortcut; ?></b></font></td>
</tr>

<?php if($culture=='pl_PL'): ?>
<tr>
<td align="left" colspan="2"><font size="8">
<b><?php echo __('Słownie') ?>:</b> <?php
            $ammountArr1 = explode('.', $invoice->getTotalAmount());

            $ammountArr2 = explode('.', number_format($invoice->getTotalAmount(), 2));

            echo ( @stInvoice::getAmmountWord($ammountArr1[0]) . " " . $shortcut . " " . $ammountArr2[1] . '/100' );
?></font></td></tr>
<?php endif; ?>
</table></td></tr></table>
<br>
<font size="10"><?php echo $invoice->getInvoiceDescription(); ?></font>
