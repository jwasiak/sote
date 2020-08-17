<?php use_helper('stCurrency', 'stOrder', 'stDelivery');?>

<table border="1" cellpadding="0" cellspacing="0" style="font-size: 8px">
    <tr>
        <td>
            <table cellspacing="0" cellpadding="4" width="502">
                <tr>
                    <td bgcolor="#ccc">
                        <b><?php echo __('Dane dostawy') ?></b>
                    </td>
                </tr>
            </table>

            <table border="0" cellpadding="4" cellspacing="0" width="502">
                <thead>
                    <tr>
                        <th width="260" bgcolor="#eee"  align="left"><?php echo __('Rodzaj dostawy') ?></th>
                    
                        <th width="130" bgcolor="#eee" align="left"><?php if($order->getOrderDelivery()->getNumber()!=""): ?><?php echo __('Numer przesyłki:') ?><?php endif; ?></th>  
                        
                        <th width="112" bgcolor="#eee" align="right"><?php echo __('Koszt przesyłki') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="260" align="left"><?php echo strip_tags($order->getOrderDelivery()->getName()); ?></td>           
                        <td width="130" align="left"><?php if($order->getOrderDelivery()->getNumber()!=""): ?><?php echo $order->getOrderDelivery()->getNumber(); ?><?php endif; ?></td>
                        <td width="112" align="right"><?php echo st_order_delivery_cost($order, true) ?></td>  
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>