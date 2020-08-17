<?php
use_helper('stPrice');
?>
<table class="st_record_list" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo __('Netto') ?></th>
            <th><?php echo __('Brutto') ?></th>
        </tr>
    </thead> 
    <tbody>
        <tr>
            <td><?php echo input_tag ('add_group_price[old_price_netto]', st_price_format($add_group_price->getOldPriceNetto()), array('size' => 7)) ?></td>
            <td><?php echo input_tag ('add_group_price[old_price_brutto]', st_price_format($add_group_price->getOldPriceBrutto()), array('size' => 7)) ?></td>
        </tr>
    </tbody>
</table>