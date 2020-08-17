<table class="st_record_list" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo __('Netto') ?></th>
            <th><?php echo __('Brutto') ?></th>
        </tr>
    </thead> 
    <tbody>
        <tr>
            <td><?php echo input_tag ('add_price[price_netto]', st_price_format($add_price->getPriceNetto()), array('size' => 7)) ?></td>
            <td><?php echo input_tag ('add_price[price_brutto]', st_price_format($add_price->getPriceBrutto()), array('size' => 7)) ?></td>
        </tr>
    </tbody>
</table>