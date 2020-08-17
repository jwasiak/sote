<?php use_helper('stAsset') ?>
<?php use_stylesheet('backend/stAssetImageCropper.css?v1') ?>

<?php if (!isset($trigger)): ?>
   <a id="<?php echo $id ?>_trigger" href="#" rel="#<?php echo $id ?>" data-id="<?php echo $asset->getId() ?>"><?php echo __('Kadruj') ?></a>
<?php endif ?>

<div id="<?php echo $id ?>" class="crop_overlay popup_window">
   <div class="close"><img src="/images/backend/beta/gadgets/close.png" alt="<?php echo __('Zamknij', null, 'stBackend') ?>" /></div>
   <h2><?php echo __('Kadrowanie zdjęcia') ?></h2>
   <div class="content"></div>
</div>


<script type="text/javascript">
jQuery(function($) {
   var image_types = <?php echo json_encode($image_types) ?>;
   var namespace = '<?php echo $id ?>';

   $('body').append($('#'+namespace));

   function init() {
      var crop_api = [];

      var overlay = this.getOverlay();

      var tabs = overlay.find('.tabs');

      function updateForm(c, image_type) {

         var select = [Math.floor(c.x), Math.floor(c.y), Math.floor(c.x2), Math.floor(c.y2)];

         $('#'+namespace+'_select_'+image_type).val('['+select.join(', ')+']');
      }

      if (!overlay.data('_initialized')) {
         var tools = overlay.find('.tools a');

         tools.tooltip({
            tipClass: 'jquery_tooltip',
            position: 'bottom center',
            offset: [3, 0]
         });
         
         tools.click(function() {
            var link = $(this);
            if (!link.hasClass('disabled')) {
               var tabs_api = tabs.data('tabs');
               var index = tabs_api.getIndex();
               var sel = crop_api[index].tellSelect();
               var ws = crop_api[index].getBounds(); 
               var width = sel.x2 - sel.x;
               var height = sel.y2 - sel.y;

               switch(link.attr('class')) {
                  case 'align_left':
                     sel.x2 = width;
                     sel.x = 0;
                  break;

                  case 'align_right':
                     sel.x = ws[0] - width;
                     sel.x2 = ws[0];
                  break;

                  case 'align_center':
                     var x = (ws[0] - width) / 2
                     sel.x = x;
                     sel.x2 = x + width;
                  break; 

                  case 'align_top':
                     sel.y2 = height;
                     sel.y = 0;
                  break;

                  case 'align_bottom':
                     sel.y = ws[1] - height;
                     sel.y2 = ws[1];
                  break;

                  case 'align_middle':
                     var y = (ws[1] - height) / 2
                     sel.y = y;
                     sel.y2 = y + height;
                  break;                                                          
               }

               var select = [sel.x, sel.y, sel.x2, sel.y2];

               crop_api[index].animateTo(select);
            }

            return false;
         });

         tabs.tabs(overlay.find('.panes > div'), {
            onClick: function() {
               var pane = this.getCurrentPane();
               var index = this.getIndex();

               tools.removeClass('disabled');

               if (!pane.data('_initialized')) {
                  var img = pane.children('img');

                  var image_type = img.attr('class');

                  var image_config = image_types[image_type];

                  var select = $.parseJSON($('#'+namespace+'_select_'+image_type).val());

                  var aspect_ratio = parseInt(image_config.width) / parseInt(image_config.height);

                  var enabled = img.data('width') > parseInt(image_config.width) || img.data('height') > parseInt(image_config.height);

                  if (enabled) {
                     var crop_options = {
                        bgOpacity: 0.4,
                        aspectRatio: img.data('width') >= parseInt(image_config.width) && img.data('height') >= parseInt(image_config.height) ? aspect_ratio : false,
                        minSize: [img.data('width') >= parseInt(image_config.width) ? parseInt(image_config.width) : parseInt(img.data('width')) , img.data('height') >= parseInt(image_config.height) ? parseInt(image_config.height) : parseInt(img.data('height'))],
                        trueSize: [parseInt(img.data('width')), parseInt(img.data('height'))],
                        allowSelect: false,
                        allowResize: img.data('width') >= parseInt(image_config.width) && img.data('height') >= parseInt(image_config.height),
                        onChange: function(c) { updateForm.call(this, c, image_type) },
                        onSelect: function(c) { updateForm.call(this, c, image_type) },
                        onDblClick: function(c) {
                           if (crop_options.allowResize) {
                              var bounds = this.getBounds();
                              if (c.x2 < bounds[0] && c.y2 < bounds[1]) {
                                 c.x2 = bounds[0] + 1;
                                 c.y2 = bounds[1] + 1;
                              } else {
                                 var min_size = this.getOptions().minSize;
                                 c.x2 = c.x + min_size[0] - 1;
                                 c.y2 = c.y + min_size[1] - 1;
                              }

                              crop_api[index].animateTo([c.x, c.y, c.x2, c.y2]);
                           }
                        }
                     };

                     if (select.length) {
                        crop_options.setSelect = select;
                     }

                     img.Jcrop(crop_options, function() {
                        crop_api[index] = this;
                        var bounds = this.getBounds();
                        var options = this.getOptions();

                        if (!select.length) {
                           this.setSelect([0, 0, bounds[0], bounds[1]]);
                           var sel = this.tellSelect();
                           
                           if (!options.aspectRatio) {
                              var width = bounds[0] > options.minSize[0] ? options.minSize[0] : sel.x2 - sel.x;
                              var height = bounds[1] > options.minSize[1] ? options.minSize[1] : sel.y2 - sel.y;
                           } else {
                              var width = sel.x2 - sel.x;
                              var height = sel.y2 - sel.y;                              
                           }
             
                           sel.x =  Math.round((bounds[0] - width) / 2);
                           sel.x2 = sel.x + width; 
                           sel.y = Math.round((bounds[1] - height) / 2);
                           sel.y2 = sel.y + height;
                           
                           this.setSelect([sel.x, sel.y, sel.x2, sel.y2]);                                                     
                        }
                        
                     });
                  } else {
                     tools.addClass('disabled');
                  }

                  pane.data('_initialized', true);
               } else {
                  if (crop_api[index].getOptions().disabled) {
                     tools.addClass('disabled');
                     crop_api[index].disable();
                  } else {
                     crop_api[index].enable();
                  }
               }
            }
         });           
         overlay.data('_initialize', true);
      }    
   }
  
   function overlayInit(trigger) {
      $(trigger).overlay({
         closeOnClick: false,
         closeOnEsc: false,
         top: "5%", 
         speed: 'fast',
         oneInstance: true,
         fixed: false,

         mask: {
            color: '#444',
            loadSpeed: 'fast',
            opacity: 0.5,
            zIndex: 30000
         }, 

         target: '#<?php echo $id ?>',
         onClose: function() {
            var content = this.getOverlay().children('.content');
            content.html('');
            content.removeClass('preloader_160x24');
         },
         onBeforeLoad: function() {
            var api = this;
            var content = this.getOverlay().children('.content');
            var overlay = this.getOverlay();

            content.addClass('preloader_160x24');
           
            $.get("<?php echo st_url_for('@stAssetImageConfiguration?action=imageCropper') ?>", { asset_id: api.getTrigger().data('id'), for: "<?php echo $for ?>", 'namespace': namespace}, function(html) {
               content.removeClass('preloader_160x24');
               content.html(html);
               content.find('form').submit(function() {
                  var form = $(this);
                  content.children().hide();
                  content.addClass('preloader_160x24');
                  var tab_api = content.children('.tabs').data('tabs');
                  tab_api.getTabs().each(function() {
                     this.click();
                  });
                  tab_api.click(0);

                  $.post(form.attr('action'), form.serializeArray(), function() {
                     api.close();
                  });

                  return false;
               })
               init.call(api);

               overlay.css("top", Math.max(28, $(window).scrollTop() + 28) + "px");
               overlay.css("left", Math.max(0, (($(window).width() - overlay.outerWidth()) / 2) + 
                                            $(window).scrollLeft()) + "px");
            });
            
         },
         onLoad: function() {
            var overlay = this.getOverlay();
            overlay.css("top", Math.max(28, $(window).scrollTop() + 28) + "px");
            overlay.css("left", Math.max(0, (($(window).width() - overlay.outerWidth()) / 2) + 
                                            $(window).scrollLeft()) + "px");
         }
      });
   }

   $(document).on(namespace+'_init', function(e, trigger) {
      overlayInit(trigger);
   });

   overlayInit(<?php if (!isset($trigger)): ?>'#'+namespace+'_trigger'<?php else: ?>"<?php echo $trigger ?>"<?php endif ?>);
});
</script>