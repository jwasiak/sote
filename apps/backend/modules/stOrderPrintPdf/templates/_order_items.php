<?php
/**
 * @var Order $order
 */
use_helper('stCurrency', 'stOrder', 'stPrice', 'stJQueryTools', 'stProductImage', 'stDiscount');
sfLoader::loadHelpers('stProduct');
?>


<table cellpadding="0" cellspacing="0" border="1" style="font-size: 8px">
    <tr>
        <td>
            <table cellspacing="0" cellpadding="4" width="502">
                <tr>
                    <td bgcolor="#ccc">
                        <b><?php echo __('Produkty'); ?></b>
                    </td>
                </tr>
            </table>
            <table border="0" cellpadding="4" cellspacing="0" width="502">
                <tr>
                    <td width="21" bgcolor="#eee" align="center"></td>
                    <td width="45" bgcolor="#eee" align="center"><?php echo __('Kod') ?></td>
                    <td width="<?php if($order_for_points==1): echo "106"; else: echo "176"; endif; ?>" bgcolor="#eee" align="left"><?php echo __('Nazwa') ?></td>
                    <td width="60" bgcolor="#eee" align="right"><?php echo __('Netto') ?></td>
                    <td width="30" bgcolor="#eee" align="right"><?php echo __('Vat') ?></td>
                    <td width="60" bgcolor="#eee" align="right"><?php echo __('Brutto') ?></td>
                    <?php if($order_for_points==1): ?>
                    <td width="70" bgcolor="#eee" align="right"><?php echo $config_points->get('points_shortcut', null, true) ?></td>
                    <?php endif; ?>
                    <td width="30" bgcolor="#eee" align="right"><?php echo __('Ilość') ?></td>
                    <td width="80" bgcolor="#eee" align="right"><?php echo __('Suma') ?></td>
                </tr>
            <?php $totalPriceBrutto = 0; ?>
            <?php $total_points_value = 0;?>
            <?php foreach ($order->getOrderProducts() as $key=>$product): 
            /**
             * @var OrderProduct $product    
             */
            ?>
                
            <?php if($product->getProductForPoints()==1): $total_points_value += $product->getPointsValue() * $product->getQuantity(); endif;?>
                
            <?php $brutto = ($product->getPrice(true));?>
            <tr>
            <td width="21" style="text-align:center;"><?php echo $key+1  ?></td>
            <td width="45" style="text-align:center;"><?php echo $product->getCode(); ?></td>
            <td width="<?php if($order_for_points==1): echo "106"; else: echo "176"; endif; ?>" style="text-align:left;">
                <?php echo strip_tags($product->getName()); ?>
                <?php if ($product->getOptions()): ?>
                    <?php st_order_display_product_options($product) ?>
                <?php endif; ?>
                <?php if ($order->isAllegroOrder()): ?>
                    <?php echo __('Oferta Allegro') ?>: <?php echo $product->getAllegroAuctionId() ?>
                <?php endif ?>
            </td>          
            <td width="60" style="text-align:right;"><?php if($product->getProductForPoints()==1): echo "-"; else: echo st_order_product_price($product); endif;?></td>
            <td width="30" style="text-align:right;"><?php if($product->getProductForPoints()==1): echo "-"; else: echo $product->getVat()."%"; endif;?></td>
            <td width="60" style="text-align:right;"><span><?php if($product->getProductForPoints()==1): echo "-"; else: echo st_order_product_price($product, true); endif;?></span></td>
            <?php if($order_for_points==1): ?><td width="70" style="text-align:right;"><span><?php if($product->getProductForPoints()==1): echo $product->getPointsValue(); else: echo "-"; endif;  ?></span></td><?php endif; ?>
            <td width="30" style="text-align:right;"><?php echo $product->getQuantity(); ?> <?php echo st_product_uom($product->getProduct()) ?></td>
            <td width="80" style="text-align:right;"><?php if($product->getProductForPoints()==1): echo $product->getPointsValue() * $product->getQuantity();  echo " ".$config_points->get('points_shortcut', null, true); else: echo st_order_product_total_amount($product, true); endif; ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
            <td colspan="5"  width="502" bgcolor="#eee" align="right" style="margin-right: 25px;"><?php echo __('Łącznie'); ?>:&nbsp;&nbsp;&nbsp;<b><?php echo st_order_product_total_amount($order) ?><?php if($total_points_value > 0): ?><br/> <?php echo $total_points_value." ".$config_points->get('points_shortcut', null, true); ?> <?php endif; ?></b></td>

            </tr>
            </table>
        </td>
    </tr>
</table>