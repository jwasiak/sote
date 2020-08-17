<?php

use_helper('stUrl');
st_theme_use_stylesheet('stProduct.css');

if (isset($category))
{
   use_helper('stCategoryImage');
   $smarty->assign('category_id', $category->getId());

   if ($sf_context->getController()->getTheme()->getVersion() < 7)
   {
      if (stConfig::getInstance('stCategory')->get('enable_image_tag') && $category->getIsAppImageTagActive())
      {
         $smarty->assignComponent('category_info', 'appImageTagFrontend', 'showCategoryImageTags');
      }
      else
      {
         $smarty->assignComponent('category_info', 'stCategory', 'info', array("category" => $category));
      }
   }
   else
   {
      $smarty->assign('title', $category->getName());
      
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
         $smarty->assign('description', $category->getDescription());
      }
      $smarty->assign('image', st_category_image_tag($category, 'small'));
      $smarty->assign('category_url', st_url_for('stProduct/list?url='.$category->getFriendlyUrl()));
   }

   $smarty->assign('category', $category);
}
elseif (null !== $searchLink)
{
   $smarty->assign('title', $searchLink->getTitle());
}
elseif (null !== $query)
{
   $smarty->assign('title', __('Wyszukiwanie', null, 'stSearchFrontend'));
}

if (null !== $query && $revelance > 0 && $product_pager->getNbResults() > 0 || null === $query && $product_pager->getNbResults() > 0)
{


   if (!stSoteshop::checkInstallVersion('6.6.4')){
      $smarty->assign("show_types", 1);
   }else{
      $smarty->assign("show_types", 0);
   }

   $smarty->assignPartial('list_type', 'stProduct', 'view_type', array('for_link' => $for_link, 'view_labels' => $view_labels, 'action' => 'list'));
   $smarty->assignPartial('sort', 'stProduct', 'sort', array('for_link' => $for_link, 'sort_labels' => $sort_labels, 'action' => 'list'));
   $smarty->assign('product_on_page', $product_on_page);
   $smarty->assign('product_all', $product_pager->getNbResults());
   $smarty->assignPartial('pager', 'stProduct', 'pager', array('for_link' => $for_link, 'product_pager' => $product_pager, 'action' => 'list'));
   
   $smarty->assignPartial('product_list', 'stProduct', $list_type, array('product_pager' => $product_pager, 'smarty' => $smarty, 'config' => $config, 'config_points' => $config_points));

   $smarty->assignComponent('producer_filter', 'stProduct', 'producerFilter', array('related_object' => isset($category) ? $category : null, 'for_link' => $for_link, 'action' => 'list'));

   $smarty->assign('product_pager_lang_args', array('%number%' => $product_on_page, '%count%' => $product_pager->getNbResults()));
}

$smarty->assign('query', $query);
$smarty->assign('search_link', $searchLink);

$smarty->assign('show_no_products_notice', (appProductAttributeHelper::hasFilters($sf_context) || stProductFilter::hasFilters($sf_context)) && $product_pager->getNbResults() == 0 || null !== $query && $revelance == 0 || (isset($category) && $category && $category->isLeaf() || null !== $query) && $product_pager->getNbResults() == 0);

$smarty->display('product_list.html')
?>
