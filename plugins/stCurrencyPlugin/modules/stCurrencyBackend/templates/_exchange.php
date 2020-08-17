<?php
use_helper('stPrice');
echo input_hidden_tag('currency[exchange]', $currency->getExchangeBackend(), array('id' => 'currency_exchange_hidden'));
echo input_tag('currency[exchange]', $currency->getExchangeBackend(), array('disabled' => $currency->getIsSystemCurrency()));
echo st_price_add_format_behavior('currency_exchange', 4);
?>
