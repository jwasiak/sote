<?php
use_helper('Validation');
st_theme_use_stylesheet('stQuestionPlugin.css');

$smarty->assign('form_start', form_tag('question/send?product_id='.$product_id, array('class' => 'st_form')));
$smarty->assign('input_hidden_product_id', input_hidden_tag('question[product_id]', $product_id));
$smarty->assign('input_hidden_type', input_hidden_tag('type', $type));
$smarty->assign('small_product_info', st_get_component('stProduct', 'smallProductInfo', array('product_id'=>$product_id)));
$smarty->assign('back_to_product', link_to(__('powrót do produktu'), 'product/show?id='.$product_id));

if($type=='depository')
{
    $smarty->assign('type_depository', $type=='depository');
    $smarty->assign('depository_question_text', textarea_tag('question[text]', __('Proszę o informacje o dostępności produktu'), array ('id' => 'question[text]', 'size' => '61x10')));
}

if($type=='price')
{
    $smarty->assign('type_price', $type=='price');
    $smarty->assign('depository_price_text', textarea_tag('question[text]', __('Proszę o informacje o cenie produktu'), array ('id' => 'question[text]', 'size' => '61x10')));
}

if($login_required==false)
{
    $smarty->assign('login_false', $login_required==false);
    $smarty->assign('error_email', form_error('question[email]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')));
    $smarty->assign('email', input_tag('question[email]', '', array('id'=>'st_application-question-email', 'size' => 50, 'class'=>'st_form-error' ? 'st_form-error' : '')));
}
else
{
    $smarty->assign('email', input_hidden_tag('question[email]', $user->getUsername()));
}

$smarty->assign('question_submit', submit_tag(__('Wyślij zapytanie')));
$smarty->display('question_send_error.html');
?>