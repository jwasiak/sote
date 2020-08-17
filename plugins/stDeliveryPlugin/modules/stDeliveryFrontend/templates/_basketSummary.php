<?php
use_helper('stCurrency');
st_theme_use_stylesheet('stDelivery.css');

$paid = stGiftCardPlugin::getTotalAmountPaid();

$discount_amount = $basket->getTotalProductDiscountAmount(true, true);

$basket_amount = $basket->getTotalAmount(true, true);

$delivery_cost = $delivery->getTotalDeliveryCost(true, true);

$total_amount = $basket_amount + $delivery_cost - $paid;

$smarty->assign("basket", $basket);

$smarty->assign("delivery", $delivery);

$smarty->assign("basket_cost", $basket_amount + $discount_amount);

$smarty->assign('basket_discount', $discount_amount);

$smarty->assign('basket_discount_name', $basket->getDiscount() ? $basket->getDiscount()->getName() : null);

if (sfContext::getInstance()->getUser()->isAuthenticated() == 1)
{
    $smarty->assign("points_value", stPoints::getBasketPointsValue());
}

$smarty->assign('points_system_is_active', stPoints::isPointsSystemActive());

$smarty->assign('points_shortcut', $config_points->get('points_shortcut', null, true));

$smarty->assign("basket_weight", $basket->getTotalProductWeight());

$smarty->assign("basket_quantity", $basket->getTotalProductQuantity());

$smarty->assign("delivery_cost", $delivery_cost);

$smarty->assign('max_order_amount', $delivery->getMaxOrderAmount());

$smarty->assign('max_order_weight', $delivery->getMaxOrderWeight());

$smarty->assign('max_order_quantity', $delivery->getMaxOrderQuantity());

$smarty->assign('paid', $paid);

$smarty->assign('total_amount', $total_amount >= 0 ? $total_amount : 0);

$smarty->assign('basket_discount_message', stDiscount::getBasketMessage());

$smarty->assign("discount_coupon_code", $discount_coupon_code);
     
$smarty->assign("gift_card", $gift_card);

$smarty->display("basket_summary.html");
?>