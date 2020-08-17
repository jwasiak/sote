<?php if($order->getDescription()!="" || $order->getMerchantNotes()!=""): ?>
<table border="1" cellspacing="0" width="502">
<?php if($order->getDescription()!=""): ?>    
    <tr>
        <td bgcolor="#ccc"><font size="8"><b><?php echo __('Uwagi klienta') ?>:</b></font></td>
    </tr>
    <tr>
        <td><font size="8"><?php echo $order->getDescription(); ?></font></td>
    </tr>
<?php endif; ?>
<?php if($order->getMerchantNotes()!=""): ?>
    <tr>
        <td bgcolor="#ccc"><font size="8"><b><?php echo __('Notatki sprzedawcy') ?>:</b></font></td>
    </tr>
    <tr>
        <td><font size="8"><?php  echo str_replace("\n","<br />",$order->getMerchantNotes()); ?></font></td>
    </tr>
<?php endif; ?>
</table>
<?php endif; ?>
