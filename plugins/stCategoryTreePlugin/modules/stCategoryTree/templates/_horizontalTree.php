<?php
st_theme_use_stylesheet('stCategoryHorizontalTree.css');

$smarty->assign('roots', $results);

$smarty->display('horizontal_tree.html');
?>