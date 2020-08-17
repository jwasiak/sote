<?php
use_helper('stUrl', 'stProductOptions', 'stBasket');

sfLoader::loadHelpers('stProduct', 'stProduct');

use_javascript('stPrice.js');

st_theme_use_stylesheet('stProductOptionsPlugin.css');

if ($info)
{    
   $options_smarty->assign('options', st_product_options_get_form($product, $selected_options));

   $options_smarty->display('options_form.html');


   if (!$product_config->get('hide_basket'))
   {
      $smarty->assign('product_id', $product->getId());

      if ($product_config->get('show_basket_quantity'))
      {
         $smarty->assign('form_action', st_secure_url_for('stBasket/addReferer?product_id='.$product->getId().'&option_list='.implode('-', $selected_options)));
         
         if ($product->getStepQty())
         {
            $smarty->assign('quantity_field', st_product_quantity_list('quantity', $product, null, array('disabled' => !$enabled)).' '.st_product_uom($product));
         }
         else
         {
            $smarty->assign('quantity_field', input_tag('quantity', stPrice::round($product->getMinQty(), $product->getStockInDecimals()), array(
                                'size' => 3,
                                'maxlength' => 11,
                                'style' => 'text-align:right',
                                'disabled' => !$enabled,
                                'onchange' => 'this.value = stPrice.fixNumberFormat(this.value, '.$product->getStockInDecimals().');'                
                            )).' '.st_product_uom($product));
         }
      }
      else
      {
         $smarty->assign('form_action', st_secure_url_for('stBasket/addReferer?product_id='.$product->getId().'&quantity='.$product->getMinQty().'&option_list='.implode('-', $selected_options)));
      }
      
      $smarty->assign('submit_button', submit_tag(__('Dodaj do koszyka', null, 'stBasket'), array('class' => 'st_button-basket-submit-enabled', 'disabled' => $enabled == false)));

      $smarty->assign('enabled', $enabled);

      $smarty->display('basket_add_quantity_enabled.html');
   }
}
else
{
   if (!$simple && !$product_config->get('hide_basket'))
   {
      $smarty->assign('basket_add_enable', st_link_to(__('Wybierz opcje produktu'), 'stProduct/show?url='.$product->getFriendlyUrl(), array('class' => "st_button_options_basket")));

      $smarty->display('basket_add_enabled.html');
   }
}

if ($basket_config->get('ajax')) 
{
   init_ajax_basket('#st_basket-add-to-basket-form', 'submit');
}
?>
<?php if ($info): $url = st_url_for('@stProductOptionsFrontend?action=ajaxNewUpdateProduct&product_id='.$product->getId()) ?>

<script type="text/javascript">
//<![CDATA[
      jQuery(function($) {
         var link = $("#st_basket-add-button a");

<?php if (!$enabled): ?>
         link.addClass('disabled');
<?php endif ?>

         link.click(function(event) {
            if (!link.hasClass('disabled')) {
               $("#st_basket-add-to-basket-form").submit();
            }
            event.preventDefault();
         });   

         $("#quantity").click(function(event) {
            event.stopPropagation();
         }); 
      });

function change_color(field, option_id) {
    jQuery('#'+field).val(option_id);
}
jQuery(function($) {   
    var colors = $('div.product_options-color-filter-box');
    colors.click(function() {
        var color = $(this);

        if (color.data('clicked')) {
            return false;
        }

        colors.data('clicked', true);

        var form = $('#st_update_product_options_form');

        var parameters = form.serializeArray();

        var basket_form = $('#st_basket-add-to-basket-form');

        if (basket_form.length) {
            var submit = $(basket_form.get(0).elements);
            submit.attr('disabled', true);
        }

        if (form.length) {
            var options =  $(form.get(0).elements);
            options.attr('disabled', true);
        }

        var change_field = $(this).attr('class').replace('color_st_product_options_', '').replace('product_options-color-filter-box', '').replace(' ', '');

        parameters.push({ name: "change_field", value: change_field });

        $.post("<?php echo $url ?>", parameters, function() {
            if (form.length) {
                options.removeAttr('disabled');
            }
            $('div.product_options-color-filter-box').data('clicked', false);
        });
    });    

    var options = $('.st_product_options_select');

    options.change(function() {
        
        var form = $(this.form);

        var basket_form = $('#st_basket-add-to-basket-form');

        if (basket_form.length) {
            var submit = $(basket_form.get(0).elements);
            submit.attr('disabled', true);
        }

        parameters = form.serializeArray();

        options.attr('disabled', true);

        parameters.push({ name: "change_field", value: $(this).attr('id').replace('st_product_options_', '') });

        $.post("<?php echo $url ?>", parameters, function() {
            options.removeAttr('disabled');
        });
    });
});
//]]>
</script>   
<?php endif; ?>
