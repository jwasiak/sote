<?php
/**
 * Szablon dla partial'a _price
 *
 * @package stProduct
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @copyright SOTE
 * @license SOTE
 * @version $Id: _price.php 2545 2009-08-11 13:58:21Z pawel $
 */
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
            <td><?php echo input_tag ('product[price_netto]', $product->getCurrency()->getIsSystemCurrency() ? st_price_format($product->getPriceNetto()) : null, array('size' => 7, 'disabled' => !$product->getCurrency()->getIsSystemCurrency())) ?></td>
            <td><?php echo input_tag ('product[price_brutto]', st_price_format($product->getCurrency()->getIsSystemCurrency() ? $product->getPriceBrutto() : $product->getCurrencyPrice()), array('size' => 7)) ?></td>
        </tr>
    </tbody>
</table>

