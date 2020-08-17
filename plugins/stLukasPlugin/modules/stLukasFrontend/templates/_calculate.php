<?php
use_helper('stUrl');
use_javascript('/js/stLukasPlugin/stLukasPlugin.js');

$smarty->assign('form', form_tag('lukas/ewniosek', array('method' => 'post', 'target' => 'lukasWindow', 'name' => 'lukasCalculator')));
$smarty->assign('type', input_hidden_tag('type', stLukas::TYPE_PRODUCT));
$smarty->assign('id', input_hidden_tag('id', $id));
$smarty->assign('price', input_hidden_tag('price', '', array('id' => 'lukasPrice')));
$smarty->assign('submit', link_to(image_tag('https://ewniosek.credit-agricole.pl/eWniosek/res/CA_grafika/oblicz_raty_duckblue.png'), '#', array('onClick' => 'lukasUpdatePrice(); openLukasUrlWithPost("'.st_url_for('lukas/ewniosek').'");')));

$smarty->display('lukas_calculate.html');