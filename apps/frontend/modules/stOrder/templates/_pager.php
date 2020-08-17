<?php
use_helper('stUrl');

sfLoader::loadHelpers(array('stProduct'), 'stProduct');

$smarty = new stSmarty('stOrder');

st_theme_use_stylesheet('stProduct.css');

if ($order_pager->haveToPaginate())
{
   $smarty->assign('current_page', $order_pager->getPage());

   $smarty->assign('last_page', $order_pager->getLastPage());

   $action = "list";
   $links = array();

      $for_link = array('module' => 'stOrder');

      foreach ($order_pager->getLinks() as $page)
      {
         $links[] = array(
            'url' => st_product_url_for($action, $for_link, array('page' => $page)),
            'page' => $page,
         );
      }  

      $smarty->assign('first_page', st_product_url_for($action, $for_link, array('page' => 1)));
      $smarty->assign('previous_page_url', st_product_url_for($action, $for_link, array('page' => $order_pager->getPreviousPage())));
      $smarty->assign('next_page_url', st_product_url_for($action, $for_link, array('page' => $order_pager->getNextPage())));
      $smarty->assign('last_page_url', st_product_url_for($action, $for_link, array('page' => $order_pager->getLastPage())));               

      $smarty->assign('current', $order_pager->getPage());
   
   
   
   $smarty->assign("links", $links);
   $smarty->display('order_pager.html');
}