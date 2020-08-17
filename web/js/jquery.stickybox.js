jQuery(function ($) {
    $.fn.stickyBox = function (options) {
        var defaults = {
            class: 'floating_container',
            content_class: 'floating_content',
            inverted: true,
            top: 0
        }

        options = $.extend(defaults, options);

        var container = $(this).wrapInner('<div class="'+options.content_class+'" ></div>');
      var container_content = container.children('div.'+options.content_class);
        var view = $(window);
        var view_height = view.height();
        var floating_container = $('<div class="'+options.class+'" style="display: none; position: fixed; z-index: 10000;"></div>');
      var resize = false;

      if (!options.inverted) {
         floating_container.css({ top: options.top+'px' });
      }

        floating_container.insertBefore(container);

        var container_height = container.height();

        floating_container.css({ 'min-width':container.width() });

        var container_offset = container.offset().top;

        function scroll() {
         if (resize) {
            floating_container.css({ 'min-width':container.width() });
            view_height = view.height() ;
            resize = false;
         }

         container_offset = container.offset().top;

         var scroll = options.inverted ? view.scrollTop() + view.height() < container_offset + container_height : view.scrollTop() + options.top > container_offset;

            if (scroll) {
                if (!container.hasClass('fixed')) {
                    container.addClass('fixed');
                    var fillup = $('<div></div>');
                    fillup.css({ height:container_height });
                    floating_container.append(container_content);
                    floating_container.show();
                    container.html(fillup);
                }
            } else if (container.hasClass('fixed')) {
                var floating_content = floating_container.children('.'+options.content_class);
                container.removeClass('fixed');
                container.html('');
            container.append(container_content);
                floating_container.hide();
            }
        }
        
        view.resize(function() { resize = true; });
        setInterval(scroll, 60);
    }
});