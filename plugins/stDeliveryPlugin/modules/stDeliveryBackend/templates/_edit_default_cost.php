<?php
use_helper('stPrice');


$error_netto = form_has_error('delivery{cost_netto}');

$error_brutto = form_has_error('delivery{cost_brutto}');
?>
<table class="st_record_list" cellspacing="0">
    <thead>
        <tr>
            <th><b><?php echo __('Netto') ?></b></th>
            <th><b><?php echo __('Brutto') ?></b></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo input_tag ('delivery[cost_netto]', st_price_format($delivery->getCostNetto()), array('size' => 8, 'style' => $error_netto ? 'border-color: #FF3333' : '')) ?></td>
            <td><?php echo input_tag ('delivery[cost_brutto]', st_price_format($delivery->getCostBrutto()), array('size' => 8, 'style' => $error_brutto ? 'border-color: #FF3333' : '')) ?></td>
        </tr>
    </tbody>
</table>

