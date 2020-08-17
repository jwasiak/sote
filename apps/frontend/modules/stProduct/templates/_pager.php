<?php
use_helper('stUrl', 'stProduct');

$smarty = new stSmarty('stProduct');

st_theme_use_stylesheet('stProduct.css');

if ($product_pager->haveToPaginate())
{
   $smarty->assign('current_page', $product_pager->getPage());

   $smarty->assign('last_page', $product_pager->getLastPage());

   if (!$sf_user->hasAttribute('sort_order', 'soteshop/stProduct'))
   {
      foreach ($for_link as $k => $v)
      {
         if (!in_array($k, array('url', 'page', 'module', 'producer')))
         {
            unset($for_link[$k]);
         }
      }
   }

   $links = array();

   if (stTheme::getInstance(sfContext::getInstance())->getVersion() < 7)
   {
      $custom_for_link = array();

      if (isset($for_link['module']))
      {
         $custom_for_link['module'] = $for_link['module'];
      } 
      
      $event = new sfEvent($product_pager, 'stProduct.pagerCustomLink');
      stEventDispatcher::getInstance()->filter($event, array('custom_for_link'=>$custom_for_link));
      $tmp = $event->getReturnValue();
      $custom_for_link = $tmp['custom_for_link'];

      $smarty->assign('first_page', st_product_url_for($action, $for_link, array('page' => 1), $custom_for_link));
      $smarty->assign('previous_page_url', st_product_url_for($action, $for_link, array('page' => $product_pager->getPreviousPage()), $custom_for_link));
      $smarty->assign('next_page_url', st_product_url_for($action, $for_link, array('page' => $product_pager->getNextPage()), $custom_for_link));
      $smarty->assign('last_page_url', st_product_url_for($action, $for_link, array('page' => $product_pager->getLastPage()), $custom_for_link));      
      
      foreach ($product_pager->getLinks() as $page)
      {
         if ($page != $product_pager->getPage())
         {
            $row['page'] = st_product_link_to($page, $action, $for_link, array_merge(array('page' => $page),$custom_for_link));
         }
         else
         {
            $row['page'] = '<span>' . $page . '</span>';
         }

         $links[] = $row;
      }
   } 
   else
   {

      $for_link = stEventDispatcher::getInstance()->filter(new sfEvent($product_pager, 'stProduct.pagerFilterParameters'), $for_link)->getReturnValue();

      foreach ($product_pager->getLinks() as $page)
      {
         $links[] = array(
            'url' => st_product_url_for($action, $for_link, array('page' => $page)),
            'page' => $page,
         );
      }  

      $smarty->assign('first_page', st_product_url_for($action, $for_link, array('page' => 1)));
      $smarty->assign('previous_page_url', st_product_url_for($action, $for_link, array('page' => $product_pager->getPreviousPage())));
      $smarty->assign('next_page_url', st_product_url_for($action, $for_link, array('page' => $product_pager->getNextPage())));
      $smarty->assign('last_page_url', st_product_url_for($action, $for_link, array('page' => $product_pager->getLastPage())));               

      $smarty->assign('current', $product_pager->getPage());
   }
   
   
   $smarty->assign("links", $links);
   $smarty->display('product_pager.html');
}