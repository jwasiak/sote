<?php
$smarty->assign('no_query',  __('Proszę podać prawidłowe kryteria wyszukiwania, minimalna ilość znaków %min_len%.', array('%min_len%' =>$min_len)));
$smarty->display('search_no_query.html');
?>