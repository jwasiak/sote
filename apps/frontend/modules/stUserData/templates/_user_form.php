<?php 
use_helper('stUrl'); 

st_theme_use_stylesheet('stUser.css');

$delivery = stDeliveryFrontend::getInstance($sf_user->getBasket());

$smarty = new stSmarty('stUserData'); 

$smarty->assign('description', $sf_request->getParameter('user_data_billing[description]')); 

$smarty->assign('is_authenticated', $sf_user->isAuthenticated()); 

$smarty->assign('username', $sf_user->isAuthenticated() ? $sf_user->getGuardUser()->getUsername() : "");

$smarty->assign('external_account', $sf_user->isAuthenticated() ? $sf_user->getGuardUser()->getExternalAccount() : ""); 

$smarty->assign('action', st_secure_url_for('stUserData/addBasketUser')); 

$smarty->assignComponent('billing_profiles', 'stUserData', 'profileList', array('type' => 'billing', 'selected' => $sf_request->getParameter('user_billing_profile')));

$default_country = $delivery->getDefaultDeliveryCountry();

$smarty->assignComponent('delivery_profiles', 'stUserData', 'profileList', array('type' => 'delivery', 'country_id' => $default_country ? $default_country->getId(): null, 'selected' => $sf_request->getParameter('user_delivery_profile')));


$smarty->display('user_form.html');
?> 