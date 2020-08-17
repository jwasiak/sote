<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_modifier_st_currency_format($price, $compatibility = false, $with_exchange = false, $with_symbol = true)
{
    use_helper('stCurrency');

    return st_currency_format($price, array('with_exchange' => $with_exchange, 'with_symbol' => $with_symbol));
}
?>
