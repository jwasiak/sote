<?php
if (empty($smarty)) $smarty = new stSmarty('stNavigationFrontend');

$smarty->assign('hasPath', $hasPath);
$smarty->assign('viewType', $viewType);
$smarty->assign('homepageLink', $homepageLink);
$smarty->assign('navigationPath', $navigationPath);
$smarty->assign('decrease', $decrease);
$smarty->assign('navigationPathCount', $navigationPathCount);

$smarty->display('navigation_navigation_breadcrumbs.html');
?>