<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
   <?php $version = 47; ?>
   <?php use_javascript('jquery-1.7.2.min.js?v'.$version, 'first') ?>
   <?php use_javascript('jquery-no-conflict.js?v'.$version, 'first') ?>
   <?php use_javascript('jquery-ui-1.8.20.custom.min.js?v'.$version) ?>      
   <?php use_javascript('jquery.tools-1.2.6.min.js?v'.$version, 'first') ?>
   <?php use_javascript('jquery.cookie.js?v'.$version, 'first') ?>  
   <?php use_javascript('jquery.resize.min.js?v'.$version, 'first') ?>   
   <?php use_javascript('jquery.stickybox.js?v'.$version, 'first') ?>
   <?php use_javascript('/jQueryTools/jcrop/js/jquery.jcrop.min.js?v'.$version); ?>
   <?php use_javascript('/jQueryTools/clipboard/js/clipboard.min.js?v'.$version); ?> 
   <?php use_javascript('/jQueryTools/prevue/js/jquery.prevue.js?v'.$version); ?>
   <?php use_stylesheet('backend/beta/style.css?v'.$version, 'first') ?>
   <?php use_stylesheet('/jQueryTools/jcrop/css/jquery.jcrop.min.css?v'.$version); ?>
   <?php use_stylesheet('/jQueryTools/prevue/css/font-awesome-eyes.css?v'.$version); ?>

   <?php sfContext::getInstance()->getResponse()->addMeta('robots','noindex');?>
   <?php include_http_metas() ?>
   <?php include_metas() ?>
   <title><?php echo __('SOTESHOP - panel administracyjny', null, 'stBackendMain') ?></title>
   <link rel="shortcut icon" href="/favicon.ico"/>
</head>
<body<?php if (!$sf_user->isAuthenticated()): ?> id="login_layout"<?php endif ?>>


<div id="container">
   <?php $lang = sfContext::getInstance()->getUser()->getCulture(); ?>

   <?php if ($sf_user->isAuthenticated()): ?>
      <?php init_tooltip('#navigation .tooltip, #social .tooltip', array('width' => 'auto', 'position' => 'bottom left')) ?>
      <?php init_tooltip('.list_tooltip', array('position' => 'center right', 'offset' => array(0, 10), 'width' => 'auto')) ?>
      <div id="navigation">   
         <div class="float_right">               
            <div class="menu admin_info">
               <ul>
                  <li class="expandable"><a id="admin_info" href="#"></a>
                     <ul class="inverted">
                        <li><a href="<?php echo st_url_for('sfGuardUser/edit?id='.$sf_user->getGuardUserId()) ?>"><?php echo __('Zalogowany', null, 'stBackendMain') ?>: <b><?php echo $sf_user->getUsername(); ?></b></a></li>
                        <li class="langs"><b style="font-weight: 400; color: #6f7170; padding-left: 10px; float: left;"><?php echo __('Wybierz język', null, 'stBackendMain') ?>:</b><?php backend_language_picker() ?></li>
                        <li class="logout"><a class="logout" href="<?php echo st_url_for('@sf_guard_signout') ?>"><?php echo __('Wyloguj', null, 'stBackendMain') ?></a></li>
                     </ul>
                  </li>
               </ul>
            </div>
            <a href="http://<?php echo $sf_request->getHost() ?>" class="preview tooltip" title="<?php echo __('Pokaż stronę sklepu', null, 'stBackendMain') ?>" target="_blank"></a>
            <div id="search">
               <form action="<?php echo st_url_for('@stProductDefault') ?>" method="post">
                  <input type="text" value="<?php echo __('szukaj', null, 'stBackend') ?>" name="filters[namecode]" id="search_filters_namecode" />
               </form>
            </div>
            <div id="webstore">
               <?php if ($lang == 'pl_PL'): ?><a href="https://www.sote.pl/category/webstore" target="_blank" rel="noopener"><?php else: ?><a href="https://www.soteshop.com/category/webstore" target="_blank" rel="noopener"><?php endif; ?><?php echo __('Dodatki WebStore', null, 'stBackendMain') ?></a>
            </div>
            <div id="dot">&bull;</div>
            <div id="news">
               <?php if ($lang == 'pl_PL'): ?><a href="https://www.sote.pl/posts" target="_blank" rel="noopener"><?php else: ?><a href="https://www.soteshop.com/posts" target="_blank" rel="noopener"><?php endif; ?><?php echo __('Nowości', null, 'stBackendMain') ?></a>
            </div>
         </div>
         <div class="menu float_left">
            <?php st_include_component('stBackend', 'menu') ?>
            <div class="clr"></div>
         </div>
         <div class="clr"></div>
      </div>
      <?php st_include_component('stBackend', 'abuseInformation');?>
      <div id="content">
            <div id="content_column_full">
               <?php include_slot('container_left') ?>
               <?php echo $sf_data->getRaw('sf_content') ?>
            </div>
         <div class="clr"></div>
      </div>
      
      <div style="background-color: #F1F1F1; border: 1px solid #BFC0BF;">
         <div id="st_version"><?php echo get_backend_version_information() ?></div>
         <div class="clr"></div>
      </div>
      <div id="preloader-dialog" class="popup_window" style="z-index: 200000">
         <div class="close" style="position: absolute; right: -20px; text-align: right; top: -20px; width: 100%; display: none"><a href="#"><img src="/images/frontend/theme/default2/buttons/close.png" alt="Zamknij"></a></div>
         <div class="content"></div>
      </div>
      <?php st_include_component('stBackend', 'popupInfo');?> 
   <?php else: ?>
      <?php echo $sf_data->getRaw('sf_content') ?>
   <?php endif; ?>

   <script type="text/javascript">
   //<![CDATA[
      jQuery(function($) {
         function detectIE() {
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf('MSIE ');
            
            if (msie > 0) {
               return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
            }

            var trident = ua.indexOf('Trident/');
            if (trident > 0) {
               var rv = ua.indexOf('rv:');
               return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
            }

            var edge = ua.indexOf('Edge/');
            if (edge > 0) {
               return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
            }

            return false;
         }

         $(document).ajaxError(function(event, jqXHR, ajaxSettings, thrownError) {
            switch(jqXHR.status) {
               case 401:
                  window.location = "<?php echo st_url_for('@sf_guard_signin') ?>";
               break;
               case 403:
                  window.alert('<?php echo __("Nie posiadasz odpowiednich uprawnień do wykonania tej operacji", null, "sfGuardUser"); ?>');
               break;
            }
         });

         if (typeof(Ajax) != 'undefined') {
            Ajax.Responders.register({
               onException: function(req) {
                  switch (req.transport.status) {
                     case 401:
                        window.location = "<?php echo st_url_for('@sf_guard_signin') ?>";
                     break;               
                     case 403:
                        window.alert('<?php echo __("Nie posiadasz odpowiednich uprawnień do wykonania tej operacji", null, "sfGuardUser"); ?>');
                     break;            
                  }
               }
            });
         }

         if (!detectIE()) {
            $('input[type=password]').prevue();
         }
         
         var preloader = $('#preloader-dialog').overlay({
            speed: 0,
            load: false,
            mask: {
               color: '#444',
               loadSpeed: 0,
               closeSpeed: 0,
               opacity: 0.5,
               zIndex: 200000,
            },
            closeOnClick: false,
            closeOnEsc: false,
            onLoad: function() {
               var content = this.getOverlay().find('.content');
               this.getOverlay().find('.close').hide();
               content.html('<p><?php echo __("Operacja w trakcie, proszę czekać...", null, 'stBackend') ?><\/p><div class="preloader_48x48">&nbsp;<\/div>');
            },
            onBeforeLoad: function () {
               preloader.data('preloader_is_open', true);
            },
            onClose: function() {
               preloader.data('preloader_is_open', false);
            }
         });
         
         $(document)
            .on('preloader', function(e, flag, content) {
               var api = preloader.data('overlay');
               if (flag == 'show') {
                  if (!preloader.data('preloader_is_open')) {
                     api.load();
                  }
               } else if (flag == 'close') {
                     if (preloader.data('preloader_is_open')) {
                        api.close();
                     }
               
               } else if (flag == 'toggle' || flag == undefined) {
                  if (preloader.data('preloader_is_open')) {
                     api.close();
                  } else {
                     api.load();
                  }
               } else if (flag == 'update') {
                  if (content === undefined) {
                     throw 'The "content" parameter is required';
                  }

                  api.getOverlay().find('.close').show();
                  api.getOverlay().find('.content').html(content);
               }
            });

         var clipboard = new Clipboard('.clipboard-btn');
         clipboard.on('success', function(e) {
            
            var api = $(e.trigger).data('tooltip');
            api.show();
            api.getTip().html("<?php echo __('Skopiowane!', null, 'stBackend') ?>");

            e.clearSelection();
         });
         $('#search_filters_namecode').click(function() {
            if (this.defaultValue == this.value) {
               this.value = '';
            } 
         });
      });
   //]]>   
   </script>  
</div>
</body>
</html>