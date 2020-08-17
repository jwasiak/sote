<?php
use_helper('stSearch');
stSearch::useFriendlyLink(false);
$smarty->assign("for_link_sort_by", isset($for_link['sort_by']) ? $for_link['sort_by'] : null);
$smarty->assign("for_link_sort_order",isset($for_link['sort_order']) ? $for_link['sort_order'] : null);

foreach ($sort_labels['label_names'] as $sort_name => $label_name)
{
    $smarty->assign('link_'.$sort_name.'_asc',st_search_link_to(__($label_name), $action, $for_link, array('sort_by' => $sort_name,'sort_order'=>'asc')));
    $smarty->assign('arrow_'.$sort_name.'_asc',st_search_link_to(st_theme_image_tag('arrow_down.gif'), $action, $for_link, array('sort_by' => $sort_name,'sort_order'=>'asc')));
    $smarty->assign('link_'.$sort_name.'_desc', st_search_link_to(__($label_name), $action, $for_link, array('sort_by'=> $sort_name,'sort_order'=>'desc')));
    $smarty->assign('arrow_'.$sort_name.'_desc', st_search_link_to(st_theme_image_tag('arrow_up.gif'), $action, $for_link, array('sort_by' => $sort_name,'sort_order'=>'desc')));
    $smarty->assign('link_'.$sort_name, st_search_link_to(__($label_name), $action, $for_link, array('sort_by' => $sort_name)));
}

stSearch::useFriendlyLink(true);
$smarty->display('product_sort.html');
?>
