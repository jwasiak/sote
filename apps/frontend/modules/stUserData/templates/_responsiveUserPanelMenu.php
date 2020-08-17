<?php 
st_theme_use_stylesheet('stUser.css');
$smarty->assign('user_email', sfContext::getInstance()->getUser()->getUsername());
$smarty->assign('active_tab', $active_tab);
$smarty->assign('order_number', $order_number);
      
$newsletter_config = stConfig::getInstance(sfContext::getInstance(), 'stNewsletterBackend');      
      
if($newsletter_config->get('newsletter_enabled')==1){
    $smarty->assign('newsletter_enabled', 0);    
}else{
    $smarty->assign('newsletter_enabled', 1);
}


$smarty->display('userdata_responsive_user_panel_menu.html');

?>