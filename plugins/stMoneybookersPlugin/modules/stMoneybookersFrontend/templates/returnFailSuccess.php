<?php
st_theme_use_stylesheet('stPayment.css');
$smarty->assign('contactLink', is_object($contactPage) ? url_for('stWebpageFrontend/index?url='.$contactPage->getFriendlyUrl()) : null);
$smarty->display("moneybookers_return_fail.html");
