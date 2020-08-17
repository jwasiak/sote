<?php
$smarty->assign("producer_info",st_get_partial('info', array('producer'=>$producer, 'smarty'=>$smarty)));
$smarty->display('producer_choose.html');
?>