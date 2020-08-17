<?php 
$version = stTheme::getInstance($sf_context)->getVersion();

if ($version >= 7) 
{
    $smarty->assign('basket_show_component', esc_js_no_entities(st_get_component("stBasket", "show")));
}

$smarty->display('basket_ajax_added_product_preview.html');
?>
<?php if (stTheme::getInstance($sf_context)->getVersion() < 7): ?>
<script type="text/javascript">
   jQuery(function($) {
      $('#basket_show').html('<?php echo esc_js_no_entities(st_get_component("stBasket", "show")) ?>');
      $('#login_status_container').html('<?php echo esc_js_no_entities(st_get_component("stUser", "loginStatus")) ?>');
      $('#added_product_preview').overlay({ 
         load: true, 
         left: 'center', 
         top: '30%', 
         closeOnClick: true,
         mask: {
            color: '#ebecff',
            loadSpeed: 200,
            opacity: 0.6
         },
         onLoad: function() {
            var error = this.getOverlay().find('.error');
            if (error.length) {
               error.tooltip({
                  position: 'center left',
                  effect: 'slide',
                  direction: 'left',
                  relative: true
               }).data('tooltip').show();
            }
         },             
         onClose: function() {
            this.getOverlay().remove();
         }                       
      });      
   });
</script>
<?php endif ?>

<?php
   $content = "";
   echo $sf_context->getController()->getDispatcher()->filter(new sfEvent(null, 'stBasket.renderAjaxAddedProductPreview'), $content)->getReturnValue();
?>