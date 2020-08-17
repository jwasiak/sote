<?php
use_helper('stUrl');
st_theme_use_stylesheet('stCompatibilityPlugin.css');
$smarty->assign('showMessage', $showMessage);

$smarty->assign('cookiesInfoColor', $cookies_info_color);
$smarty->assign('cookiesInfoBackground', $cookies_info_background);
$smarty->assign('cookiesInfoWidth', $cookies_info_width);

if (sfContext::getInstance()->getController()->getTheme()->getVersion() >= 2){
$smarty->assign('last_div', "#bg_container");
}else{
$smarty->assign('last_div', "#footer");    
}


$cookies_description = preg_replace('/{LINK_TO_PRIVACY}/', st_url_for('stWebpageFrontend/index?url='.$webpage->getFriendlyUrl()), $cookies_description);

$smarty->assign('cookiesDescription', $cookies_description);

$smarty->assign('link_to_privacy', st_url_for('stWebpageFrontend/index?url='.$webpage->getFriendlyUrl()));
$smarty->display('compatibility_show_cookies_info.html');