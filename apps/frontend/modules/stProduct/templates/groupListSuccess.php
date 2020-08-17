<?php
use_helper('stUrl');
st_theme_use_stylesheet('stProduct.css');

$smarty->assign('title_text', $title);
$smarty->assign('title', $title);


if ($product_pager->getPage()>1){

    $title = sfContext::getInstance()->getResponse()->getTitle();

    $title = $title." - ".__('strona')." ".$product_pager->getPage();

    $meta_description = sfContext::getInstance()->getResponse()->getMetas()['description'];

    if($meta_description){

        $meta_description = $meta_description." - ".__('strona')." ".$product_pager->getPage();

        sfContext::getInstance()->getResponse()->addMeta('description',$meta_description);
    }

    sfContext::getInstance()->getResponse()->setTitle($title);

}

if ($product_pager->getnbResults() > 0)
{
    $smarty->assign('list_type',get_partial('view_type',array('for_link'=> $for_link, 'view_labels'=> $view_labels, 'smarty'=>$smarty, 'action' => 'groupList')));
    $smarty->assign('sort',get_partial('sort',array('for_link'=> $for_link, 'smarty'=>$smarty, 'sort_labels' => $sort_labels,'action' => 'groupList')));
    $smarty->assign('product_on_page',$product_on_page);
    $smarty->assign('product_all',$product_pager->getnbResults());
    $smarty->assign('pager',st_get_partial('pager', array('for_link'=> $for_link, 'product_pager' => $product_pager, 'smarty' => $smarty, 'action' => 'groupList')));
    $smarty->assign('product_list',st_get_partial($list_type, array('product_pager'=>$product_pager,'smarty'=>$smarty, 'config'=>$config, 'config_points' => $config_points)));

    if (empty($producer_id))
    {
        $smarty->assign('producer_filter',st_get_component('stProduct', 'producerFilter', array('related_object' => $product_group, 'for_link' => $for_link, 'action' => 'groupList')));
    }
    $smarty->assign('product_pager_lang_args',array('%number%' => $product_on_page, '%count%' => $product_pager->getnbResults()));
}
$smarty->display('product_list.html');
?>
