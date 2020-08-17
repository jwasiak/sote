<?php
use_helper('stUrl');
st_theme_use_stylesheet('stCompatibilityPlugin.css');
st_theme_use_stylesheet('stUser.css');
$smarty->assign('showMessage', $showMessage);

$smarty->assign('changeTermsColor', $change_terms_color);
$smarty->assign('changeTermsBackground', $change_terms_background);
$smarty->assign('changeTermsWidth', $change_terms_width);
$smarty->assign('changeTermsCookieHash', $change_terms_cookie_hash);
$smarty->assign('isAuthenticated', $is_authenticated);

if (sfContext::getInstance()->getController()->getTheme()->getVersion() >= 2){
$smarty->assign('last_div', "#bg_container");
}else{
$smarty->assign('last_div', "#footer");    
}          
if($privacy_webpage){
    $change_terms_description = preg_replace('/{LINK_TO_PRIVACY}/', st_url_for('stWebpageFrontend/index?url='.$privacy_webpage->getFriendlyUrl()), $change_terms_description);    
}

if($terms_webpage){
    $change_terms_description = preg_replace('/{LINK_TO_TERMS}/', st_url_for('stWebpageFrontend/index?url='.$terms_webpage->getFriendlyUrl()), $change_terms_description);
}    
    
if($shipping_webpage){    
    $change_terms_description = preg_replace('/{LINK_TO_SHIPPING}/', st_url_for('stWebpageFrontend/index?url='.$shipping_webpage->getFriendlyUrl()), $change_terms_description);
}

if($right_2_cancel_webpage){
    $change_terms_description = preg_replace('/{LINK_TO_RIGHT_2_CANCEL}/', st_url_for('stWebpageFrontend/index?url='.$right_2_cancel_webpage->getFriendlyUrl()), $change_terms_description);
}

$smarty->assign('changeTermsDescription', $change_terms_description);

//$smarty->assign('link_to_privacy', st_url_for('stWebpageFrontend/index?url='.$privacy_webpage->getFriendlyUrl()));

$smarty->display('compatibility_show_change_terms_info.html');