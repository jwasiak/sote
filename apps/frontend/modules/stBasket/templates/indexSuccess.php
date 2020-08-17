<?php
st_theme_use_stylesheet('stBasket.css');

$smarty->assign("button_back", link_to(__('Wróć do zakupów'), $referer));

$smarty->assign("if_warning", $sf_flash->has('warning'));

$smarty->assign("if_notice", $sf_flash->has('notice'));

$smarty->assign("show_warning", $sf_flash->get('warning'));

$sf_flash->set('warning', null);

$smarty->assign("products", $basket->getItems());

$smarty->assign("has_deliveries", $delivery->hasDeliveries());

$smarty->assign("show_products", $basket_config->get('show_products'));

$smarty->assign("return_url", $referer);

$smarty->assign('description', $sf_request->getParameter('user_data_billing[description]'));

if ($basket->getItems())
{
   $smarty->assign("product_list", st_get_partial('product_list', array('basket' => $basket, 'basket_config' => $basket_config, 'config_points' => $config_points, 'smarty' => $smarty, 'referer' => $referer)));

   $smarty->assign("delivery", st_get_component('stDeliveryFrontend', 'basketDeliveryList', array('basket' => $basket)));

   $smarty->assign("payment", st_get_component('stDeliveryFrontend', 'basketPaymentList', array('basket' => $basket)));

   $smarty->assign("total", st_get_component('stDeliveryFrontend', 'basketSummary', array('basket' => $basket)));
   $smarty->assign("products_promote", st_get_component('stPromoteProductsInBasket', 'showProducts'));
   $smarty->assign("user_form", st_get_partial('stUserData/user_form', array('basket' => $basket)));
   $smarty->assign("discount_coupon_code", st_get_component('stDiscountFrontend', 'couponCode', array('return_url' => 'stBasket/index')));
   $smarty->assign("gift_card", st_get_component('stGiftCardFrontend', 'show', array('return_url' => 'stBasket/index')));
   $smarty->assign('basket_discount', stDiscount::getBasketMessage());
   
   $smarty->assign("trusted_shops", st_get_component('stTrustedShopsFrontend', 'showExcellenceBuyerProtection'));
   $smarty->assign("socket_above_user_form", stSocketView::openComponents('stBasketAboveUserForm'));
   $smarty->assignComponent('gift_group', 'stGiftGroup', 'show', array('limit' => 10, 'overlay' => true));
}
else
{
   $smarty->assign("product_basket", st_get_component('stProduct', 'productInBasketGroup', array('basket' => $basket)));
}

$smarty->display("_basket_index.html");
?>
