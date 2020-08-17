<?php
$version = $sf_context->getController()->getTheme()->getVersion();
use_helper('stUrl', 'stProducerImage');

if ($version < 7)
{
    st_theme_use_stylesheet('stProduct.css');
}

if ($producer)
{
    $smarty->assign('producer', $producer);
    if ($sf_context->getController()->getTheme()->getVersion() < 7)
    {
        $smarty->assign('producer_id',$producer->getId());
        $smarty->assign('producer_info',st_get_component('stProducer', 'info',array("producer"=>$producer)));
    }
    else
    {
      $smarty->assign('title', $producer->getName());
      if ($product_pager->getPage()>1){

        $smarty->assign('description', "");

        $title = sfContext::getInstance()->getResponse()->getTitle();

        $title = $title." - ".__('strona')." ".$product_pager->getPage();

        $meta_description = sfContext::getInstance()->getResponse()->getMetas()['description'];

        if($meta_description){

          $meta_description = $meta_description." - ".__('strona')." ".$product_pager->getPage();

          sfContext::getInstance()->getResponse()->addMeta('description',$meta_description);
        }

        sfContext::getInstance()->getResponse()->setTitle($title);

      }else{
         $smarty->assign('description', $producer->getDescription());
      }
      $smarty->assign('image', st_producer_image_tag($producer, 'large'));
    }
}

if ($product_pager->getnbResults() > 0)
{
    $smarty->assign('list_type',get_partial('view_type',array('for_link'=>$for_link, 'view_labels'=> $view_labels, 'smarty'=>$smarty, 'action' => 'producerList')));
    $smarty->assign('sort',get_partial('sort',array('for_link'=>$for_link, 'smarty'=>$smarty, 'sort_labels' => $sort_labels,'action' => 'producerList')));
    $smarty->assign('product_on_page',$product_on_page);
    $smarty->assign('product_all',$product_pager->getnbResults());
    $smarty->assign('pager',st_get_partial('pager', array('for_link'=> $for_link, 'product_pager' => $product_pager, 'smarty' => $smarty, 'action' => 'producerList')));
    $smarty->assign('product_list',st_get_partial(@$list_type, array('product_pager'=>$product_pager,'smarty'=>$smarty, 'config'=>$config,  'config_points' => $config_points, 'for_link'=> $for_link)));
    $smarty->assign('product_pager_lang_args',array('%number%' => $product_on_page, '%count%' => $product_pager->getnbResults()));
}

$smarty->display('product_list.html');
?>
