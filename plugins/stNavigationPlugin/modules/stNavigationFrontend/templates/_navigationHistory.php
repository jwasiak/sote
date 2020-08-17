<?php
if (empty($smarty)) $smarty = new stSmarty('stNavigationFrontend');

$smarty->assign('hasProduct', $hasProduct);
$smarty->assign('viewType', $viewType);
$smarty->assign('productLink', $productLink);
$smarty->assign('historyLink', $historyLink);
$smarty->assign('fastcache', $fastcache);

$smarty->display('navigation_navigation_history.html');