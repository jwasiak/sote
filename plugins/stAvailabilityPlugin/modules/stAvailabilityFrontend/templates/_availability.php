<?php
use_helper('stAvailabilityImage');
st_theme_use_stylesheet('stAvailabilityPlugin.css');


$smarty->assign("availability", content_tag('span', $availability->getAvailabilityName(), array('id' => 'st_availability_info-value', 'style' => 'float: none;'.($availability->getColor() != null ? 'color: #'.$availability->getColor() : ''))));
$smarty->assign("availability_link", $availability->getStockFrom());

$smarty->assign("availability_image", st_availability_image_tag($availability, 'full'));
$smarty->assign("check_xml", $check_xml);

$smarty->display("availability.html");
?>
<script type="text/javascript" language="javascript">
   jQuery(function ($)
   {
      $(document).ready(function ()
      {
         $('#active_availability_alert_overlay').click(function()
         {
           <?php  if(stTheme::is_responsive()): ?>
 
                $('#availability_alert_modal').modal('show');
                
                $.get('<?php echo url_for('stAvailabilityFrontend/showAddOverlay') ?>?'+$('#st_update_product_options_form').serialize(), { 'product_id':'<?php echo $product->getId(); ?>'}, function(data)
                {
                    $('#availability_alert').html(data);
                });
            
           <?php else: ?> 
             
             
            var api = $('#availability_alert_overlay').data('overlay');

            if (!api)
            {
               $('#availability_alert_overlay').overlay(
               {

                  onBeforeLoad: function()
                  {
                     var wrap = this.getOverlay().find('.availability_alert_overlay_content');
                     $.get('<?php echo url_for('stAvailabilityFrontend/showAddOverlay') ?>?'+$('#st_update_product_options_form').serialize(), { 'product_id':'<?php echo $product->getId(); ?>'}, function(data)
                     {
                        wrap.html(data);
                     });
                  },
                  load: true
               });
            }
            else
            {
               api.load();
            }
            
            <?php endif; ?> 
         });

      });
   });
</script>
