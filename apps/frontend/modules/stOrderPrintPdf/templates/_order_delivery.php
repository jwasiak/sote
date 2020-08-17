<?php use_helper('stCurrency', 'stOrder', 'stDelivery');?>
<font size="8">
<table border="1" cellspacing="0" width="502">
<tr><td bgcolor="#ccc">
<b><?php echo __('Dane dostawy:') ?></b>
</td></tr>

<tr><td>

<table border="0" cellpadding="0" cellspacing="0" width="502">
<thead>
    <tr>
        <th width="130" bgcolor="#eee"  align="left"><?php echo __('Rodzaj dostawy:') ?></th>
       
        <th width="130" bgcolor="#eee" align="left"><?php echo __('Koszt przesyłki:') ?></th>
       
        <th width="130" bgcolor="#eee" align="left"><?php if($order->getOrderDelivery()->getDeliveryDate()!=""): ?><?php echo __('Termin dostawy') ?>:<?php endif; ?></th>
        
        <th width="112" bgcolor="#eee" align="left"><?php if($order->getOrderDelivery()->getNumber()!=""): ?><?php echo __('Numer przesyłki:') ?><?php endif; ?></th>
        
    </tr>
     </thead>
    <tbody>
    <tr>
        <td width="130" align="left"><?php echo $order->getOrderDelivery()->getName(); ?></td>
        <td width="130" align="left"><?php echo st_order_delivery_cost($order, true) ?></td>        
        <td width="130" align="left"><?php if($order->getOrderDelivery()->getDeliveryDate()!=""): ?><?php echo getDeliveryDateFormat($order->getOrderDelivery()->getDeliveryDate()); ?><?php endif; ?></td>
            
        <td width="112" align="left"><?php if($order->getOrderDelivery()->getNumber()!=""): ?><?php echo $order->getOrderDelivery()->getNumber(); ?><?php endif; ?></td>
    </tr>
    </tbody>
</table>
</td></tr>
</table>
</font>