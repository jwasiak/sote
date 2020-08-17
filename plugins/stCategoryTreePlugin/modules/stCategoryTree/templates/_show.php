<?php

if (!$config->get('tree_type') || $config->get('tree_type') == 'default')
{
   ob_start();
   
   foreach ($roots as $root)
   {
      st_include_component('stCategoryTree', 'tree', array('parent' => $root, 'expanded' => $expanded));
   }

   $smarty->assign('category_tree_content', ob_get_clean());
}
else
{
   $smarty->assign('category_tree_content', st_get_component('stCategoryTree', $config->get('tree_type'), array('roots' => $roots, 'expanded' => $expanded)));
}

$smarty->display('show.html');
