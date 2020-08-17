<?php
use_helper('stProduct');

$smarty = new stSmarty('stProduct');

if (stTheme::getInstance($sf_context)->getVersion() < 7)
{
    $smarty->assign("for_link_sort_by",$for_link['sort_by']);
    $smarty->assign("for_link_sort_order",$for_link['sort_order']);

    foreach ($sort_labels as $sort_name => $label_name)
    {
       $asc_link = st_product_url_for($action, $for_link, array('sort_by' => $sort_name,'sort_order' => 'asc'));

       $desc_link = st_product_url_for($action, $for_link, array('sort_by' => $sort_name,'sort_order' => 'desc'));

       $smarty->assign('link_'.$sort_name.'_asc', content_tag('a', __($label_name), array('href' => $asc_link, 'rel'=> "nofollow")));

       $smarty->assign('arrow_'.$sort_name.'_asc', content_tag('a', st_theme_image_tag('arrow_down.gif'), array('href' => $asc_link, 'rel'=> "nofollow")));

       $smarty->assign('link_'.$sort_name.'_desc', content_tag('a', __($label_name), array('href' => $desc_link, 'rel'=> "nofollow")));

       $smarty->assign('arrow_'.$sort_name.'_desc', content_tag('a', st_theme_image_tag('arrow_up.gif'), array(), array('href' => $desc_link, 'rel'=> "nofollow")));

       $smarty->assign('link_'.$sort_name, st_product_link_to(__($label_name), $action, $for_link, array('sort_by' => $sort_name), array('rel'=> "nofollow")));
    }
}
else
{
    $sort_types = array();

    foreach ($sort_labels as $sort_name => $label_name)
    { 
        if ($sort_name!="priority")
        {
          $sort_types[$sort_name] = array(
              'asc_url' => st_product_url_for($action, $for_link, array('sort_by' => $sort_name,'sort_order' => 'asc')),
              'desc_url' => st_product_url_for($action, $for_link, array('sort_by' => $sort_name,'sort_order' => 'desc')),
              'label' => __($label_name),
          );
        }      
    }

    $smarty->assign('sort_types', $sort_types);
    $smarty->assign('url_params', $for_link);
}

$smarty->display('product_sort.html');
?>
