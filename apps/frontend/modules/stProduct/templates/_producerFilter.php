<?php
use_helper('stProduct');


$results = array(
   0 => array(
      'url' => st_product_url_for($action, $for_link, array('producer_filter' => 0)),
      'label' => __('Wszyscy producenci', null, 'stProducer'),
   )
);

foreach ($producers as $id => $producer)
{
   $results[$id] = $producer;

   if ($sf_request->hasParameter('filter'))
   {
      $results[$id]['url'] = st_product_url_for($action, $for_link, array('producer_filter' => $id));
   }
   else
   {
      $results[$id]['url'] = st_product_url_for($action, $for_link, array('producer_filter' => $id)).'?filter=1';
   }
}   

$smarty->assign('producers', $results);

$smarty->assign('selected', $selected);

$smarty->display('product_producer_filter.html');
?>