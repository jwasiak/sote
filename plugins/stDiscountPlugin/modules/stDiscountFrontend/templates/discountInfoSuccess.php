<?php 
st_theme_use_stylesheet('stUser.css');
st_theme_use_stylesheet('stDiscountPlugin.css');
$smarty->assign('user_panel_icon',st_theme_image_tag('user_panel_icon.png'));
$smarty->assign('user_panel_path',link_to(__('Moje konto'), 'stUserData/userPanel').' / '.__('Rabaty'));
$smarty->assign('user_panel_menu',st_get_component('stUserData', 'userPanelMenu'));
$smarty->assign('discounts',$all_discounts);
$smarty->display('discount_info.html');