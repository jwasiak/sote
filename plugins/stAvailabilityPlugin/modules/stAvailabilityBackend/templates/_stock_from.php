<?php 
use_helper('stPrice');

echo input_tag('availability[stock_from]', st_price_format($availability->getStockFrom()), array('size' => 8, 'maxlength' => 11, 'readonly' => $availability->getStockFrom() === 0));

echo st_price_add_format_behavior('availability_stock_from');
?>