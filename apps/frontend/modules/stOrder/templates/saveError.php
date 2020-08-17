<?php 
use_helper('stUrl');
st_theme_use_stylesheet('stGiftCardPlugin.css');
$smarty->assign('return_url', st_url_for('stBasket/index'));

$smarty->display('order_save_error.html');

?>
