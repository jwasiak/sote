<?php
sfLoader::loadHelpers(array('stProduct', 'stBasket'), 'stProduct');

st_theme_use_stylesheet('stBasket.css');

use_javascript('stPrice.js');

if ($product->getOptHasOptions() > 1)
{
   echo content_tag('div', st_get_component('stProductOptionsFrontend', 'modifyBasketView', array('smarty' => $smarty, 'product' => $product, 'simple' => $simple, 'info' => $info, 'basket_config' => $basket_config, 'enabled' => $enabled)), array('id' => 'st_product_options-modify-basket', 'style' => 'display: inline'));
}

if ($show_basket)
{
   $smarty->assign('product_id', $product->getId());

   if ($simple)
   {

      if ($enabled)
      {

         if ($sf_context->getController()->getTheme()->getVersion() >= 2)
         {
            $smarty->assign('basket_add_simple_enabled', st_secure_link_to(st_theme_image_tag('buttons/basket.png', array('alt' => __('Dodaj do koszyka'))), '@stBasketAdd?product_id='.$product->getId().'&quantity='.$product->getMinQty(), array('class' => 'add_to_basket')));
         }
         else
         {

            $smarty->assign('basket_add_simple_enabled', st_secure_link_to(st_theme_image_tag('add_basket.gif', array('alt' => __('Dodaj do koszyka'))), '@stBasketAdd?product_id='.$product->getId().'&quantity='.$product->getMinQty()));
         }

         $smarty->display('basket_add_simple_enabled.html');
      }
      else
      {
         if ($sf_context->getController()->getTheme()->getVersion() >= 2)
         {

            $smarty->assign('basket_add_simple_disabled', st_theme_image_tag('buttons/basket.png', array('alt' => __('Dodaj do koszyka'))));
         }
         else
         {

            $smarty->assign('basket_add_simple_disabled', st_theme_image_tag('add_basket.gif', array('alt' => __('Dodaj do koszyka'))));
         }

         $smarty->display('basket_add_simple_disabled.html');
      }
   }
   elseif ($info)
   {
      $smarty->assign('product_id', $product->getId());

      if ($product_config->get('show_basket_quantity'))
      {
         $smarty->assign('form_action', st_secure_url_for('stBasket/addReferer?product_id='.$product->getId()));
         
         if ($product->getStepQty())
         {
            $smarty->assign('quantity_field', st_product_quantity_list('quantity', $product, null, array('disabled' => !$enabled)).' '.st_product_uom($product));            
         }
         else
         {         
            $smarty->assign('quantity_field', input_tag('quantity', $product->getMinQty(), array(
                                'size' => 3,
                                'maxlength' => 11,
                                'style' => 'text-align:right',
                                'disabled' => !$enabled,
                                'onchange' => 'this.value = stPrice.fixNumberFormat(this.value, '.($product->getStockInDecimals() ? 2 : 0).');'
            )).' '.st_product_uom($product));
         }   
      }
      else
      {
         $smarty->assign('form_action', st_secure_url_for('stBasket/addReferer?product_id='.$product->getId().'&quantity='.$product->getMinQty()));
      }

      $smarty->assign('submit_button', submit_tag(__('Dodaj do koszyka'), array('class' => 'st_button-basket-submit-enabled', 'disabled' => !$enabled)));

      $smarty->assign('enabled', $enabled);

      $smarty->display('basket_add_quantity_enabled.html');
   }
   else
   {
      if ($enabled)
      {
         $smarty->assign('basket_add_enable', st_secure_link_to(__('Dodaj do koszyka'), '@stBasketAdd?product_id='.$product->getId().'&quantity='.$product->getMinQty(), array('class' => 'add_to_basket')));
         
         $smarty->display('basket_add_enabled.html');
      }
      else
      {
         $smarty->display('basket_add_disabled.html');
      }
   }
}

if ($basket_config->get('ajax') && $show_basket && $info) 
{
   init_ajax_basket('#st_basket-add-to-basket-form', 'submit');   
}
elseif ($show_basket && $basket_config->get('ajax') && !stBasketComponents::$ajaxIncludeOnce)
{
   stBasketComponents::$ajaxIncludeOnce = true;
   init_ajax_basket('.add_to_basket');    
}
?>

<?php if ($show_basket && $info): ?>
<script type="text/javascript">
jQuery(function($) {
   var link = $("#st_basket-add-button a");
   link.click(function(event) {
      if (link.hasClass('disabled')) {
         return false;
      }
      
      $("#st_basket-add-to-basket-form").submit();
      
      return false;
   });
<?php if (!$enabled): ?>
   link.addClass('disabled');
<?php endif ?>
   $("#quantity").click(function(event) {
      event.stopPropagation();
   });
});
</script>
<?php endif; ?>