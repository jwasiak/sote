<?php 
st_theme_use_stylesheet('stCompatibilityPlugin.css');
$smarty->assign('checkbox', checkbox_tag('user_data_billing[opinion]', 1, $sf_request->getParameter('user_data_billing[opinion]'), array('id' => 'st_form-user-compatibility-opinion')));
$smarty->assign('text', $text);
$smarty->display('compatibility_opinion_basket_checkbox.html');
