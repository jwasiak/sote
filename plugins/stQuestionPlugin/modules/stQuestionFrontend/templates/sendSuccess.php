<?php
use_helper('Validation');
st_theme_use_stylesheet('stQuestionPlugin.css');

$smarty->assign('product_name', $product_name);
$smarty->assign('small_product_info', st_get_component('stProduct', 'smallProductInfo', array('product_id'=>$product_id, 'product' => $product)));
$smarty->assign('back_to_product', link_to(__('powrót do produktu'), 'product/show?id='.$product_id));

$smarty->display('question_send.html');
?>