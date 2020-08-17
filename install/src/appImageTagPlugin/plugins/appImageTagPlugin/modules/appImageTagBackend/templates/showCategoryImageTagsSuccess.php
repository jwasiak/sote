<?php use_helper('stAsset', 'stJQueryTools', 'stAdminGenerator') ?>

<div id="app-image-tag-overlay-close" class="close"><a href="#"><img src="/images/backend/beta/gadgets/close.png" alt="<?php echo __('Zamknij', null, 'stBackend') ?>" /></a></div>
<div id="app-image-tag-overlay">
   <h2><?php echo __('Zarządzaj kolekcją produktów') ?></h2>
   <div id="app-category-image-tag"><img src="/stThumbnailPlugin.php?i=<?php echo $tag && $tag->hasImage() ? $tag->getImagePath() : $category->getOptImage() ?>&w=640&h=320" alt="" /></div>

   <form style="text-align: left" id="tags-save-button" class="admin_form" action="<?php echo url_for('@appImageTagBackend?action=save&category_id='.$category->getId().'&id='.$sf_request->getParameter('image_id')) ?>">
      <fieldset style="border-left: none; border-right: none">
         <div class="content">
            <?php echo st_admin_get_form_field('description', __('Opis'), $tag ? $tag->getDescription() : '', 'textarea_tag', array('style' => 'width: 100%; height: 80px', 'maxlength' => 512)); ?>
            <?php echo st_admin_get_form_field('description_color', __('Kolor tekstu'), array(__('Jasny'), __('Ciemny')), 'select_tag', array('selected' => $tag ? $tag->getDescriptionColor(): null, 'help' => __('Jeśli tło zdjęcia jest ciemne, tekst powinien być jasny. Jeśli tło zdjęcia jest jasne, tekst powinien być ciemny.'))); ?>
            <?php echo st_admin_get_form_field('url', __('Link'), $tag ? $tag->getUrl() : '', 'input_tag', array('style' => 'width: 100%;', 'maxlength' => 255, 'help' => __("Jeżeli link jest podany użytkownik zostaje przekierowany po kliknięciu na zdjęcie"))); ?>
         </div>
      </fieldset>
      <?php echo st_get_admin_actions_head() ?>
      <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
      <?php echo st_get_admin_actions_foot() ?>
   </form>

   <div id="app-image-tag-create-overlay" class="popup_window">
      <div class="close"><img src="/images/backend/beta/gadgets/close.png" alt="<?php echo __('Zamknij', null, 'stBackend') ?>" /></div>
      <h2><?php echo __('Dodaj produkt') ?></h2>
      <div class="content">
         <?php echo st_autocompleter_input_tag("product_tag", null, array('placeholder' => __('Wpisz kod lub nazwę produktu'),'autocompleter' => array(
            'buttonNavigation' => false,
            'zIndex' => 40000,
            'serviceUrl' => url_for('appImageTagBackend/productAutoComplete'),
            'deferRequestBy' => 300,
            'onSelect' => 'createTag(data); return false;',
            'resultFormat' => 'resultFormat')))?>
      </div>
   </div>
</div>
<?php init_tooltip('#app-image-tag-overlay .help', array('relative' => true)) ?>
<script type="text/javascript">
function resultFormat(value, data, currentValue) {
   var pattern = '(' + currentValue.replace(jQuery.fn.autocomplete.escapePattern, '\\$1') + ')';

   var code = data.code.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>');;

   var name = data.name.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>');

   return '<div class="app-image-tag-rf"><img src="'+data.icon+'" alt="" /><p class="name">'+name+'</p><p class="code">'+code+'</p></div>';  
}

function createTag(data) {
   var overlay = jQuery('#app-image-tag-create-overlay');
   overlay.data('tag-data', data);
   overlay.data('overlay').close();
}

jQuery(function($) {
   var tags = <?php echo json_encode($tags) ?>;
   var culture = "<?php echo $tag ? $tag->getCulture() : $category->getCulture() ?>";
   $('#product_tag').keypress(function(e) {
      if (e.keyCode == 13) {
         return false;
      }
   });

   var taggable = $('#app-category-image-tag > img');

   $('#app-image-tag-create-overlay').overlay({
      closeOnClick: false,
      closeOnEsc: false,
      speed: 0,
      oneInstance: false,
      onClose: function() {
         var overlay = this.getOverlay();
         var tag = overlay.data('tag');

         if (overlay.data('tag-data')) {
            var data = overlay.data('tag-data');
            tag.data('taggd-content', '<p class="remove"><img data-id="'+data.id+'" src="/jQueryTools/plupload/images/remove.png" alt="" /></p><img src="'+data.thumb+'"  alt="" /><p class="name">'+data.name+'</p><p class="code">'+data.code+'</p>');
            tag.data('id', data.id);
         } else {
            tag.remove();
         }

         overlay.data('tag', null);
         overlay.data('tag-data', null);
         $('#product_tag').val('').change();
         taggable.removeClass('tagging');
         $('.taggd-image-popup').remove();
         
      },
      onBeforeLoad: function() {

      },
      onLoad: function() {
         var tag = this.getOverlay().data('tag');
         var top = tag.offset().top - $(window).scrollTop();
         var offset = { "top": top+'px', "left": tag.offset().left+'px' };
     
         this.getOverlay().css(offset);
      }     
   });

   taggable.bind('taggd-add-item', function(e, item, data) {
      if (data.id) {
         item.data('id', data.id);
      }
   });

   taggable.taggd(tags);

   taggable.on('taggd-init', function() {

      $('.taggd-image-popup').on('click', '.remove > img', function() {
   
         var close = $(this);
         var id = close.data('id');

         taggable.data('wrapper').children().each(function() {
            var tag = $(this);
            if (tag.data('id') == id) {
               tag.remove();
            }
         });

         close.closest('.taggd-image-popup').hide();
      });
   });

   taggable.click(function(e) {
      if (!taggable.hasClass('tagging')) {
         var offset = taggable.offset();
         var px = (e.pageX - offset.left) / taggable.width();
         var py = (e.pageY - offset.top) / taggable.height();

         taggable.taggd('items', [{ x: px.toFixed(2), y: py.toFixed(2), text: '' }]); 
         var tag = taggable.data('wrapper').children().last();
         var overlay = $('#app-image-tag-create-overlay');
         overlay.data('tag', tag);
         taggable.addClass('tagging');
         overlay.data('overlay').load();
      }
   }); 

   var overlay = $('#plupload_edit_overlay');  

   $('#tags-save-button').submit(function() {
         var form = $(this);

         overlay.addClass('preloader_160x24'); 
         $('#app-image-tag-overlay').css({ visibility: 'hidden' });
         $('#app-image-tag-overlay-close').hide();
         var tags = {};

         taggable.data('wrapper').children().each(function() {
            var tag = $(this);
            tags[tag.data('id')] = { x: tag.data('x'), y: tag.data('y') }
         });

         var params = {};

         $(form.serializeArray()).each(function() {
            params[this['name']] = this['value'];
         });

         $.post(form.attr('action'), { 'tags': tags, 'params': params, 'culture': culture } , function() {
            overlay.removeClass('preloader_160x24');
            overlay.data('overlay').close();
         });

         return false;
   }); 

   function center(overlay) {      
      var left = ($(window).width() - overlay.outerWidth()) / 2;
      overlay.css("left", left + "px");       
   } 

   center(overlay);   
});
</script>
