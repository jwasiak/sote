<?php
use_helper('stProduct'); 
$views = array();
$smarty = new stSmarty('stProduct');
$smarty->assign('selected', $sf_request->getParameter('type', $for_link['type']));
foreach ($view_labels as $view_name => $label_name)
{
    $label = __($label_name);

    $url = st_product_url_for($action, $for_link, array('type'=> $view_name)); 

    $views[$view_name]['link'] = '<a href="'.$url.'" rel="nofollow">'.$label.'</a>';

    $views[$view_name]['link_without_name'] = $url;

    $views[$view_name]['name'] = $view_name;
    
    $views[$view_name]['image_link'] = '<a href="'.$url.'" rel="nofollow">'.st_theme_image_tag('icon_'.$view_name.'.gif', array('alt'=> $label, 'title'=> $label)).'</a>';  
    
    $views[$view_name]['image_link_selected'] = '<a href="'.$url.'" rel="nofollow">'.st_theme_image_tag('icon_'.$view_name.'_selected.gif', array('alt'=> $label, 'title'=> $label)).'</a>';
        
    $views[$view_name]['label'] = $label;
}
$smarty->assign('views', $views);
$smarty->display('product_view_types.html')
?>