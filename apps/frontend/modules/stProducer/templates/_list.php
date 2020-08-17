<?php
use_helper('Object');
st_theme_use_stylesheet('stProducer.css');
$smarty->assign("form_start", form_tag('stProducer/choose'));
$smarty->assign("select_producer", select_tag('id', options_for_select($producers, $selected, array('include_custom' => __('Wszyscy producenci'))), array('onchange' => 'this.form.submit()')));
$smarty->assign("hidden_submit",submit_tag(__('ok')));
$smarty->display('producer_list.html');
?>