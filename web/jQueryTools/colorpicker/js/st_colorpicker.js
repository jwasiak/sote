jQuery(function($) {
   function hex(x) {
      return ("0" + parseInt(x).toString(16)).slice(-2);
   }

   function updateRGBA(input, rgb) {
      var rgba = $('#'+input.attr('id')+'-rgba');

      if (rgba.length) {
         rgba.val('rgba('+rgb.r+', '+rgb.g+', '+rgb.b+', '+input.data('rgba')+')');
      }
   }

   $.fn.stColorPicker = function(options)
   {
      var input = $(this);
      
      var trigger = $('#'+input.attr('id')+'-trigger');

      if (options == undefined)
      {
         options = {};
      }

      trigger.click(function() {
         input.ColorPickerShow();
      });

      $.extend(options, {
         onSubmit: function(hsb, hex, rgb, el)
         {
            input.val(hex);
            updateRGBA(input, rgb);
            input.ColorPickerHide();
         },
         onBeforeShow: function ()
         {
            $(this).ColorPickerSetColor(this.value);
         },
         onChange: function (hsb, hex, rgb)
         {
            input.val(hex);

            if (input.data('rgba') > 0) {
               trigger.css('background-color', 'rgba('+rgb.r+', '+rgb.g+', '+rgb.b+', '+input.data('rgba')+')');
            } else {
               trigger.css('background-color', '#'+hex);
            }

            updateRGBA(input, rgb);
         },
         onHide: function()
         {
            input.trigger('onHide');
         },
         onShow: function()
         {
            return !input.attr('disabled');
         }
      });

      if (options.color.indexOf('rgb') >= 0) {

         var rgb = options.color.match(/[0-9.]+/g);
         
         if (rgb.length == 4) {
            input.data('rgba', rgb[3]);
            input.after('<input type="hidden" name="'+input.attr('name')+'" id="'+input.attr('id')+'-rgba" value="'+input.val()+'" />');
         }

         var color = hex(rgb[0])+hex(rgb[1])+hex(rgb[2]);

         options.color = '#'+color;

         input.val(color);

      }       

      input.ColorPicker(options)
      .bind('keyup', function()
      {
         $(this).ColorPickerSetColor(this.value);

         trigger.css('background-color', '#'+this.value);
      });


   }
});


