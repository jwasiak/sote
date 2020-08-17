<?php
use_helper('Validation','Object');
st_theme_use_stylesheet('stReview.css');

$smarty->assign('user_panel_icon', image_tag('/images/frontend/theme/default/user_panel_icon.png'));
$smarty->assign('my_account', link_to(__('Moje konto'), 'stUserData/userPanel'));
$smarty->assign('order_id',  $order->getId());
$smarty->assign('user_panel_menu',  st_get_component('stUserData', 'userPanelMenu'));
$smarty->assign('transaction', st_get_partial('transactionReview', array('order' => $order, 'reviewed_order' => $reviewed_order, 'transaction' => $transaction, 'agreement' => $agreement, 'smarty' => $smarty)));

$smarty->display('review_add.html');
?>