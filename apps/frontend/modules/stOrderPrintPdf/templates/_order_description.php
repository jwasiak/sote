<?php if($order->getDescription()!=""): ?>
<table border="1" cellspacing="0" width="502">
<tr>
    <td bgcolor="#ccc"><font size="8"><b><?php echo __('Uwagi klienta') ?>:</b></font>
</td>
</tr>
<tr>
    <td><font size="8"><?php echo $order->getDescription(); ?></font></td>
</tr>
</table>
<?php endif; ?>