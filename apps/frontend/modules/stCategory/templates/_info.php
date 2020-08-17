<?php
use_helper('stCategoryImage');

st_theme_use_stylesheet('stCategory.css');
$smarty->assign("check_parent", $category->getParentId());
$smarty->assign("photo", st_category_image_tag($category, 'small'));
$smarty->assign('show_subcategories',$show_subcategories);
$smarty->assign('name',$category->getName());
$smarty->assign('description',$category->getDescription());
$smarty->assign('categories',get_component('stCategory', 'subcategories', array('category' => $category)));
$smarty->display('category_info.html');

?>