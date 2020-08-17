<?php
use_helper('stCurrency');
st_theme_use_stylesheet('stBasket.css');

$value = st_get_component('stDeliveryFrontend', 'basketSummary', array('basket' => $basket));
if ($value)
{
    $smarty->assign("value", $value);
}
else
{
    $smarty->assign("total_amount", st_front_symbol().$basket->getTotalAmount(true, true).st_back_symbol());
}
$smarty->display("basket_summary.html");
?>