<?php
st_theme_use_stylesheet('stErrorPlugin.css');
$smarty->assign('form_start', form_tag('/', array('class' => 'st_form')));
$smarty->assign('main_page_submit',submit_tag(__('Strona główna')));
$smarty->display('product_not_found.html');
?>