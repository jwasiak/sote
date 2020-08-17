<?php
use_helper('stBasket', 'stUrl', 'stCurrency');

$theme = stTheme::getInstance($sf_context);

if ($theme->getVersion() < 7)
{
   st_theme_use_stylesheet('stBasket.css'); 

   if (!$basket->isEmpty())
   {
      $basket_array = array();
      
      $basket_summary = 0;

      foreach($basket->getItems() as $basket_item)
      {   
         $validate = $basket_item->productValidate();
         $url_for = $validate ? st_url_for('stProduct/show?url='.$basket_item->getProduct()->getFriendlyUrl()) : null;
         
         $basket_array[] = array(
            'name' =>  $url_for ? content_tag('a', $basket_item->getName(), array('href' => $url_for)) : $basket_item->getName(),
            'price' => st_currency_format($basket_item->getPriceBrutto(true, true), array('with_exchange' => false)),
            'product_for_points' => $validate ? $basket_item->getProductForPoints() : 0,
            'points_value' => $validate ? $basket_item->getProduct()->getPointsValue()." ".$config_points->get('points_shortcut', null, true) : 0,
            'quantity' => $basket_item->getQuantity(),
            'image' => $url_for ? content_tag('a', st_product_image_tag($basket_item, 'icon'), array('href' => $url_for)) : st_product_image_tag($basket_item, 'icon'),
         );
                        
      }
   }
   else 
   {
      $basket_array = null;
   }

    if(stPoints::isPointsSystemActive()){
        $smarty->assign("basket_icon", st_secure_link_to(st_basket_total_amount($basket, true)." / ".stPoints::getBasketPointsValue()." ".$config_points->get('points_shortcut', null, true), 'stBasket/index' . ($sf_context->getModuleName() == 'stBasket' ? '' : 'Referer')));   
    }else{
        $smarty->assign("basket_icon", st_secure_link_to(st_basket_total_amount($basket, true), 'stBasket/index' . ($sf_context->getModuleName() == 'stBasket' ? '' : 'Referer')));
    }

    $smarty->assign("amount_icon", st_secure_link_to(st_theme_image_tag('basket/basket_selected.png'), 'stBasket/index' . ($sf_context->getModuleName() == 'stBasket' ? '' : 'Referer'), 'class=st_basket-list-link'));
    $smarty->assign('basket_array', $basket_array);
    
    
    
}
else
{
   $item = array();

   $basket_summary = 0;

   foreach($basket->getItems() as $basket_item)
   {   
      $validate = $basket_item->productValidate();
      $url_for = $validate ? st_url_for('stProduct/show?url='.$basket_item->getProduct()->getFriendlyUrl()) : null;
      
      $items[] = array(
         'url' => $url_for,
         'delete_url' => st_url_for('@stBasket?action=remove&product_id='.$basket_item->getItemId()),
         'name' =>  $basket_item->getName(),
         'price' => st_currency_format($basket_item->getPriceBrutto(true, true), array('with_exchange' => false)),
         'product_for_points' => $validate ? $basket_item->getProductForPoints() : 0,
         'points_value' => $validate ? $basket_item->getProduct()->getPointsValue()." ".$config_points->get('points_shortcut', null, true) : 0,
         'quantity' => $basket_item->getQuantity(),
         'price_modifiers' => $basket_item->getPriceModifiers(),
         'image' => st_product_image_path($basket_item, 'small'),
      );
      
      $basket_summary += $basket_item->getPriceBrutto(true, true) * $basket_item->getQuantity();
   }

   $smarty->assign('url', st_secure_url_for('stBasket/index' . ($sf_context->getModuleName() == 'stBasket' ? '' : 'Referer')));
   $smarty->assign('items', $items);
   $smarty->assign("total_quantity", count($items));
   $smarty->assign('basket_summary', st_currency_format($basket_summary, array('with_exchange' => false)));
}



//points system
$smarty->assign('points_system_is_active', stPoints::isPointsSystemActive());

$smarty->assign('points_shortcut', $config_points->get('points_shortcut', null, true));

$smarty->assign("basket_points_amount", stPoints::getBasketPointsValue());

$smarty->assign("basket_amount", st_basket_total_amount($basket, true));

$smarty->display("basket_show.html");

?>

<?php if ($theme->getVersion() < 7): ?>
<script type="text/javascript" language="javascript">
    jQuery(function ($) {
         $(document).ready(function () {
            $("#basket_show, .st_basket-list-link").tooltip({ 
               tip: '#basket_tooltip',
               effect: 'slide',
               opacity: 1,
               position: 'bottom left',
               offset: [10,92]

            });
        });
    });
</script>
<?php endif ?>