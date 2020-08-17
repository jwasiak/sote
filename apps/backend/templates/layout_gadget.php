<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
   <head>
      <?php $version = 47; ?>
      <?php use_javascript('jquery-1.7.2.min.js?v'.$version, 'first') ?>
      <?php use_javascript('jquery-no-conflict.js?v'.$version, 'first') ?>
      <?php use_javascript('jquery.tools-1.2.6.min.js?v'.$version, 'first') ?>   
      <?php use_javascript('/js/backend/jquery-ui.min.js?v'.$version, 'first') ?> 
      <?php use_javascript('/jQueryTools/clipboard/js/clipboard.min.js?v'.$version); ?> 
      <?php use_stylesheet('backend/beta/style.css?v'.$version, 'first') ?>
      <?php include_http_metas() ?>
      <?php include_metas() ?>
      <title><?php echo __('SOTESHOP - panel administracyjny', null, 'stBackendMain') ?></title>
   </head>    
   <body class="iframe">     
      <?php init_tooltip('.list_tooltip', array('position' => 'center right', 'offset' => array(0, 10), 'width' => 'auto')) ?>    
      <?php echo $sf_data->getRaw('sf_content') ?> 
      <script type="text/javascript">
         jQuery(function($) {
            var clipboard = new Clipboard('.clipboard-btn');
            clipboard.on('success', function(e) {
               
               var api = $(e.trigger).data('tooltip');
               api.show();
               api.getTip().html("<?php echo __('Skopiowane!', null, 'stBackend') ?>");

               e.clearSelection();
            });
            $('body').on('click', '.external-link', function() {
               var href = $(this).attr('href');
               window.parent.location = href;
               return false;
            });   
         });
      </script>    
   </body>
</html>