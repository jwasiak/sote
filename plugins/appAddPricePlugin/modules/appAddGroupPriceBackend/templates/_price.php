<?php
// use_helper('stPrice');
// 
// 
   // st_price_tax_managment_init(array(
           // 'taxValue' => $add_price->getProduct()->getVat(),
           // 'priceFields' => array(
                   // array('price' => 'add_price_price_netto', 'priceWithTax' => 'add_price_price_brutto'),
                   // array('price' => 'add_price_old_price_netto', 'priceWithTax' => 'add_price_old_price_brutto'),
//            
           // ))); 

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
            <td><?php echo input_tag ('add_group_price[price_netto]', st_price_format($add_group_price->getPriceNetto()), array('size' => 7)) ?></td>
            <td><?php echo input_tag ('add_group_price[price_brutto]', st_price_format($add_group_price->getPriceBrutto()), array('size' => 7)) ?></td>
        </tr>
    </tbody>
</table>