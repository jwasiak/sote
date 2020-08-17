<?php
use_helper('stUrl');
use_javascript('/js/stLukasPlugin/stLukasPlugin.js');

if($sf_user->getBasket()->getTotalAmount(true) <="500"){
    $smarty->assign('link', link_to(image_tag('https://ewniosek.credit-agricole.pl/eWniosek/res/CA_grafika/oblicz_raty_duckblue.png'), '#', array('id'=>'credit-agricol')));
}else{
    $smarty->assign('link', link_to(image_tag('https://ewniosek.credit-agricole.pl/eWniosek/res/CA_grafika/oblicz_raty_duckblue.png'), '#', array('id'=>'credit-agricol','onClick' => "window.open('".url_for('lukas/ewniosek')."', 'lukasWindow', 'location=no, scrollbars=yes, resizable=yes, toolbar=no, menubar=no, height=600, width=840');")));    
}
$smarty->assign('amount', $sf_user->getBasket()->getTotalAmount(true));
$smarty->display('lukas_calculate_in_basket.html');