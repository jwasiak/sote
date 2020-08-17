<?php
$smarty = new stSmarty('stFrontendMain');
$smarty->assign('lang',$lang);
$smarty->assign('open', $open);
$smarty->display('copyright.html');
?>