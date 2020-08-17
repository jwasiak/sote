<?php
st_theme_use_stylesheet('stGiftCardPlugin.css');
use_javascript('jquery.infieldlabel.js', 'last');
$smarty->assign('remove_icon', _st_get_image_path('delete.gif'));

$smarty->display('gift_card_show.html');
?>