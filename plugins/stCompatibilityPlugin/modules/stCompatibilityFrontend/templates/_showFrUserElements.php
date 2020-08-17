<?php
st_theme_use_stylesheet('stCompatibilityPlugin.css');
$smarty->assign('text', $text->getContent());
$smarty->display('compatibility_show_fr_user_elements.html');