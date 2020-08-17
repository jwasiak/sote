<?php
use_helper('stUrl');
st_theme_use_stylesheet('stPayment.css');
st_theme_use_stylesheet('stLukasPlugin.css');
use_javascript('/js/stLukasPlugin/stLukasPlugin.js');

$smarty->assign('check_configuration', $stLukas->checkPaymentConfiguration());
if ($stLukas->checkPaymentConfiguration())
{
	$smarty->assign('form_start', form_tag('lukas/ewniosek', array('class' => 'st_form', 'id'=>'lukas_form')));
	$smarty->assign('type', input_hidden_tag('type', stLukas::TYPE_ORDER));
	$smarty->assign('id', input_hidden_tag('id', $order->getId()));
	$smarty->assign('procedure', link_to(__('Warunkami udzielania kredytu ratalnego Credit Agricole Bank Polska'), '#', array('onClick' => 'openLukasUrl("'.st_url_for('lukas/procedure').'");')));
	$smarty->assign('statement', checkbox_tag('lukas_statement', 1, false));
	$text = __("Proszę zaznaczyć opcję: 'Oświadczam, że zapoznałem/am się z informacją o warunkach i sposobie udzielania kredytu ratalnego Credit Agricole Bank Polska'");
	$smarty->assign('submit_button', image_tag('https://ewniosek.credit-agricole.pl/eWniosek/res/CA_grafika/raty_120x44_duckblue.png', array('id' => 'lukas_zloz_wniosek', 'onClick' => 'jQuery(function($){$("#lukas_form").submit();})', 'style' => 'cursor: pointer')));
    $smarty->assign('description', stPaymentType::getSummaryDescriptionByOrderIdAndHash($order->getId()));
}
$smarty->display('lukas_show_payment.html');