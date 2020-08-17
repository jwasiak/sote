<?php
use_helper('stCurrency', 'stOrder', 'stPrice', 'stJQueryTools', 'stProductImage', 'stDiscount');
sfLoader::loadHelpers('stProduct');
?>
<font size="8">
<table border="1" cellspacing="0" width="502">
<tr><td bgcolor="#ccc">
<b><?php echo __('Produkty'); ?>:</b>
</td></tr>
<tr><td>
<table border="0" cellpadding="0" cellspacing="0" width="502">
    <tr>
        <td width="50" bgcolor="#eee" align="center"><font size="8"><?php echo __('Kod') ?></font></td>
        <td width="<?php if($order_for_points==1): echo "100"; else: echo "170"; endif; ?>" bgcolor="#eee" align="center"><font size="8"><?php echo __('Nazwa') ?></font></td>
        <td width="66" bgcolor="#eee" align="right"><font size="8"><?php echo __('Netto') ?></font></td>
        <td width="30" bgcolor="#eee" align="right"><font size="8"><?php echo __('Vat') ?></font></td>
        <td width="66" bgcolor="#eee" align="right"><font size="8"><?php echo __('Brutto') ?></font></td>
        <?php if($order_for_points==1): ?>
        <td width="70" bgcolor="#eee" align="right"><font size="8"><?php echo $config_points->get('points_shortcut', null, true) ?></font></td>
        <?php endif; ?>
        <td width="40" bgcolor="#eee" align="center"><font size="8"><?php echo __('Ilość') ?></font></td>
        <td width="80" bgcolor="#eee" align="right"><font size="8"><?php echo __('Suma') ?></font>&nbsp;&nbsp;</td>
    </tr>
<?php $totalPriceBrutto = 0; ?>
<?php $total_points_value = 0;?>
<?php foreach ($order->getOrderProducts() as $product): ?>
    
<?php if($product->getProductForPoints()==1): $total_points_value += $product->getPointsValue() * $product->getQuantity(); endif;?>
    
<?php $brutto = ($product->getPrice(true));?>
<tr>
<td  width="50" style="text-align:center;"><font size="8"><?php echo $product->getCode(); ?></font></td>
<td bgcolor="#efefef" width="<?php if($order_for_points==1): echo "100"; else: echo "170"; endif; ?>" style="text-align:left;"><font size="8"><?php echo strip_tags($product->getName()); ?><?php if ($product->getOptions()): ?><?php st_order_display_product_options($product) ?><?php endif; ?></font></td>          
<td width="66" style="text-align:right;"><font size="8"><?php if($product->getProductForPoints()==1): echo "-"; else: echo st_order_product_price($product); endif;?></font></td>
<td width="30" style="text-align:right;"><font size="8"><?php if($product->getProductForPoints()==1): echo "-"; else: echo $product->getVat()."%"; endif;?></font></td>
<td width="66" style="text-align:right;"><font size="8"><span><?php if($product->getProductForPoints()==1): echo "-"; else: echo st_order_product_price($product, true); endif;?></span></font></td>
<?php if($order_for_points==1): ?><td width="70" style="text-align:right;"><font size="8"><span><?php if($product->getProductForPoints()==1): echo $product->getPointsValue(); else: echo "-"; endif;  ?></span></font></td><?php endif; ?>
<td width="40" style="text-align:center;"><font size="8"><?php echo $product->getQuantity(); ?>  <?php echo st_product_uom($product->getProduct()) ?></font></td>
<td width="80" style="text-align:right;"><font size="8"><?php if($product->getProductForPoints()==1): echo $product->getPointsValue() * $product->getQuantity(); echo " ".$config_points->get('points_shortcut', null, true); else: echo st_order_product_total_amount($product, true); endif; ?></font>&nbsp;&nbsp;</td>
</tr>
<?php endforeach; ?>
<tr>
<td colspan="5"  width="502" bgcolor="#eee" align="right" style="margin-right: 25px;"><font size="8"><?php echo __('Łącznie'); ?>:</font>&nbsp;&nbsp;&nbsp;<font size="8"><b><?php echo st_order_product_total_amount($order) ?> &nbsp;<?php if($total_points_value > 0): ?><br/> <?php echo $total_points_value." ".$config_points->get('points_shortcut', null, true); ?> <?php endif; ?></b></font>&nbsp;</td>
</tr>
<?php if ($order->hasDiscount()): ?>
<tr bgcolor="#eee">
    <td colspan="6" align="right"><?php echo __('Rabat', null, 'stOrder'); ?>:</td>
    <td align="right"><b>-<?php echo st_order_price_format($order->getTotalProductDiscountAmount(true, true), $order->getOrderCurrency()) ?></b>&nbsp;</td>
</tr>
<?php endif ?>
</table>
</td></tr>
</table>
</font>
