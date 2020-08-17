<?php
$options = array("" => "---", -1 => __('Wyłączone')) + _product_hide_price_options();

echo select_tag('filters[hide_price]', options_for_select($options, isset($filters['hide_price']) ? $filters['hide_price'] : null));
?>