<?php 
   use_javascript('/plugins/appImageTagPlugin/js/jquery.taggd.js?v1');
   use_stylesheet('/plugins/appImageTagPlugin/css/taggd.css?v1');
   use_javascript('/jQueryTools/autocompleter/js/jquery.autocomplete.js?v1');
   use_stylesheet('/jQueryTools/autocompleter/css/styles.css?v1');
?>

<style type="text/css">

.admin_form .row_show_category_image_tags {
   padding-top: 0px;
}

#product_tag {
    width: 100%;
}

#app-image-tag-overlay {
   width: 660px;
   text-align: center;
}

#app-image-tag-overlay .admin_actions {
   margin: 10px;
}

#app-image-tag-overlay .content.preloader_160x24 {
   height: 200px;
}

.app-image-tag-rf {
   cursor: pointer;
   padding: 5px 10px;
   min-width: 200px;
}

.app-image-tag-rf:after {
   content: "";
   display: table;
   clear: left;
}

.app-image-tag-rf img {
   vertical-align: top;
   float: left;
   max-width: 42px;
}

.app-image-tag-rf .name,
.app-image-tag-rf .code {
   margin-left: 50px;
}

.taggd-item-hover {
   max-width: 130px;
}

.taggd-item-hover .remove {
   padding-bottom: 5px;
   text-align: right;
   margin-top: -5px;
   margin-right: -5px;
}

.taggd-item-hover img {
   max-width: 114px;
}

.taggd-item-hover .remove img {
   cursor: pointer;
}

#app-category-image-tag {
   padding: 5px;
   background: #eee;
}

#app-category-image-tag > img {
   cursor: crosshair;
}

#app-category-image-tag > img.tagging {
    cursor: default;
}

#app-image-tag-create-overlay .content {
   padding: 10px;
}

#app-image-tag-create-overlay {
   box-shadow: 0px 0px 5px #000;
}
</style>

<?php if ($category->getOptImage() && $category->getSfAssetId() || $tag && $tag->hasImage()): ?>
<div>
   <a id="app-image-tag-trigger" href="<?php echo st_url_for('@appImageTagBackend') ?>" rel="#app-image-tag-overlay"><?php echo __('Zarządzaj kolekcją produktów') ?></a>
   <div id="app-image-tag-overlay" class="app-image-tag-overlay popup_window">
      <div class="close"><img src="/images/backend/beta/gadgets/close.png" alt="<?php echo __('Zamknij', null, 'stBackend') ?>" /></div>
      <h2><?php echo __('Zarządzaj kolekcją produktów') ?></h2>
      <div class="content"></div>
   </div>    
</div>
<?php endif ?>

<script type="text/javascript">
jQuery(function($) {
   $('body').append($('#app-image-tag-overlay'));
   var saved = false;
   $('#app-image-tag-trigger').overlay({
      closeOnClick: false,
      closeOnEsc: false,
      top: "5%", 
      speed: 'fast',
      oneInstance: false,
      mask: {
         color: '#444',
         loadSpeed: 'fast',
         opacity: 0.5,
         zIndex: 30000
      }, 
      onClose: function() {
         var content = this.getOverlay().children('.content');
         if (saved) {
            content.children().not('#app-image-tag-create-overlay').show();
         } else {
            content.html('');
         }
         content.removeClass('preloader_160x24');
         
      },
      onBeforeLoad: function() {
         saved = false;
         var api = this;
         var content = this.getOverlay().children('.content');
         content.addClass('preloader_160x24');
         if (content.is(':empty')) {            
            $.get(api.getTrigger().attr('href'), { id: <?php echo $category->getId() ?> }, function(html) {
               content.removeClass('preloader_160x24');
               content.html(html);
            
               var taggable = $('#app-category-image-tag > img');

               $('#tags-save-button').submit(function() {
                     content.children().hide();
                     content.addClass('preloader_160x24'); 
                     var tags = {};

                     taggable.data('wrapper').children().each(function() {
                        var tag = $(this);
                        tags[tag.data('id')] = { x: tag.data('x'), y: tag.data('y') }
                     });

                     $.post($(this).attr('action'), { data: tags } , function() {
                        content.removeClass('preloader_160x24');
                        saved = true;
                        api.close();
                     });

                     return false;
               });      
            });
         } 
      }     
   });
});
</script>

