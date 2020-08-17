<?php
use_helper('stUrl');
use_javascript('/js/stLukasPlugin/stLukasPlugin.js');

$smarty->assign('form', form_tag('lukas/ewniosek', array('method' => 'post', 'target' => 'lukasWindow', 'name' => 'lukasCalculator')));
$smarty->assign('submit', link_to(st_theme_image_tag('stLukasPlugin/oblicz_rate.gif'), '#', array('onClick' => 'openLukasUrlWithPost("'.url_for('lukas/ewniosek').'");')));

$smarty->display('lukas_order_summary.html');