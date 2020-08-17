<?php
st_theme_use_stylesheet('smDepositoryAlertPlugin.css');
$smarty->display('depository_alert_show_link.html');
?>
<script type="text/javascript" language="javascript">
   jQuery(function ($)
   {
      $(document).ready(function ()
      {
         $('#active_depository_alert_overlay').click(function()
         {
            var api = $('#depository_alert_overlay').data('overlay');

            if (!api)
            {
               $('#depository_alert_overlay').overlay(
               {

                  onBeforeLoad: function()
                  {
                     var wrap = this.getOverlay().find('.depository_alert_overlay_content');
                     $.get('<?php echo url_for('smDepositoryAlertFrontend/showAddOverlay') ?>', { 'product_id':'<?php echo $product->getId(); ?>', 'option_name':'<?php echo $option_name ?>'}, function(data)
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
         });

      });
   });
</script>
