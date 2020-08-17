<?php
/**
 * Szablon dla partial'a _price
 *
 * @package stProduct
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @copyright SOTE
 * @license SOTE
 * @version $Id: _old_price.php 2545 2009-08-11 13:58:21Z pawel $
 */
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
           <td><?php echo input_tag ('product[old_price_netto]', $product->getCurrency()->getIsSystemCurrency() ? st_price_format($product->getOldPriceNetto()) : null, array('size' => 8, 'disabled' => !$product->getCurrency()->getIsSystemCurrency())) ?></td>
            <td><?php echo input_tag ('product[old_price_brutto]', st_price_format($product->getCurrency()->getIsSystemCurrency() ? $product->getOldPriceBrutto() : $product->getCurrencyOldPrice()), array('size' => 8)) ?></td>
        </tr>
    </tbody>
</table>