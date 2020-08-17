function initializeDropdownMenu(target, callback) {
   target = jQuery(target);

   target.find('.action').click(callback).click(function() {
      jQuery(this).parents('ul:first').hide();
   });

   target.hover(function() {
      jQuery(this).children('ul').show();
   }, function() {
      jQuery(this).children('ul').hide();
   });

   return target;
}
      
function stopGadgetRefresh(gadget) {
   var timer = gadget.data('refresh_timer');
         
   if (timer) {
      clearInterval(timer);
      gadget.data('refresh_timer', null);
   }
}
      
function initGadgetRefresh(gadget, refresh_by) {
   stopGadgetRefresh(gadget);
         
   var updateGadget = function() {
      refreshGadgets(gadget); 
      var timer = self.setTimeout(updateGadget, refresh_by);
      gadget.data('refresh_timer', timer);      
   }

   var timer = self.setTimeout(updateGadget, refresh_by);
   gadget.data('refresh_timer', timer);         
}

function refreshGadgets(gadget, refresh) {
   var content = gadget.children('.content');

   if (content.length) {
      if (refresh == undefined) {
         refresh = true;
      }

      var iframe = content.children('iframe');

      if (iframe.attr('src').charAt(0) == '/') {
         iframe.css({
            visibility: 'hidden'
         });

         content.addClass('preloader_160x24');

         var src = iframe.attr('src');

         if (refresh) {
            date = new Date();
            src = src.replace(/refreshed_at=[0-9]+/, 'refreshed_at='+Math.floor(date.getTime() / 1000));
         }

         iframe.attr('src', src);
      }
   }
}
