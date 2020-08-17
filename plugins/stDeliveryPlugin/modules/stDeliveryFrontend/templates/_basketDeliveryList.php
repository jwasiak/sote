<?php
st_theme_use_stylesheet('stDelivery.css');

use_javascript('stDelivery.js');

$smarty->assign('deliveries', $delivery->getDeliveries());

$smarty->assign('delivery_countries', $delivery->getDeliveryCountries());

if ($config->get('date_on'))
{
   $smarty->assign('date_time', st_get_component('stDeliveryFrontend', 'dateTime'));
}

if (!$delivery->hasDeliveries())
{
   if (DeliveryPeer::retrieveIdsCached())
   {
      $smarty->assign('max_order_amount_exceeded', true);
   }
}


$smarty->assign('has_valid_allow_criteria', $delivery->hasValidAllowCriteria());


$smarty->display('basket_delivery_list.html');
?>
<?php if ($sf_context->getController()->getTheme()->getVersion() < 7): ?>
<script type="text/javascript">
jQuery(function($) {
   $('input.st_delivery-default').each(function() {
      if (this.checked)
      {
         stDelivery.deliveryChecked = this.id;
      }

      $(this).click(function() {
         if (stDelivery.deliveryChecked != this.id)
         {
            $(document).trigger('delivery.change.started', this);
            stDelivery.executeAjaxUpdate($(this), '<?php echo url_for('stDeliveryFrontend/ajaxDeliveryUpdate') ?>');

            stDelivery.deliveryChecked = this.id;
         }
      });
   });

   $('#delivery_country').change(function()
   {
      stDelivery.executeAjaxUpdate($(this), '<?php echo url_for('stDeliveryFrontend/ajaxDeliveryCountryUpdate') ?>');
   });    
});
</script>
<?php endif ?>