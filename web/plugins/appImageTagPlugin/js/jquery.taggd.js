/*
 * jQuery Taggd
 * A helpful plugin that helps you adding 'tags' on images.
 *
 * Tim Severien
 * http://timseverien.nl
 *
 * Copyright (c) 2013 Tim Severien
 * Released under the GPLv2 license.
 *
 */

(function($) {

    var settings = {
        'offset': {
            'left': 0,
            'top': 0
        }
    };

    var instances = [];

    var methods = {
        'init': function(tags, opt) {
            var wrapper = $('<div class="taggd-wrapper" />');
            var imageWrapper = $('<div class="taggd-image-wrapper"  style="position: relative;" />');
            var popup = $('<div class="taggd-image-popup" />');

            var $this = this;

            this.wrap(imageWrapper)
            this.after(wrapper);
            $('body').append(popup);

            this.data('wrapper', wrapper);
            this.data('imageWrapper', imageWrapper);
            this.data('popup', popup);

            $.extend(true, $this.settings, settings);
            $.extend(true, $this.settings, opt);

            this.one("load", function() { 
                methods.items.call($this, tags); 
                $this.trigger('taggd-init', $this);               
            });

            if (this.get(0).complete || this.get(0).readyState === 4) {
                this.trigger("load");                     
            }


            wrapper.on('click', '.taggd-item', function() {

                methods.showPopup.call($this, $(this));
                
                $(document).one("mousedown touchstart", function(e) {
    
                    if (!popup.is(e.target) && popup.has(e.target).length === 0) {
                        popup.hide();
                    }
                }); 

                return false;             
            });

            instances.push($this);
        },
        showPopup: function(tag) {
            var $window = $(window);
            var offset = tag.offset();
            var popup = this.data('popup');
            
            popup.html(tag.data('taggd-content')); 

            if (popup.outerWidth(false) + offset.left > $window.width()) {
                offset.left = offset.left - popup.outerWidth(false) + tag.outerWidth(false);
            }
            popup.show();
            popup.offset(offset);             
        },
        hidePopup: function() {
            this.data('popup').hide();
        },
        hide: function() {
            if (this.data('wrapper')) { 
                this.data('wrapper').hide();
            }
        },
        show: function() {
            if (this.data('wrapper')) { 
                this.data('wrapper').show();
            }
        },
        'items': function(items) {

            var $this = this;
            var $wrapper = $this.data('wrapper');

            var height = this.height();
            var width = this.width();

            for (var i = 0; i < items.length; i++) {
                var v = items[i];
              
                var item = $('<a href="#" class="taggd-item" style="position: '+('absolute')+'" onclick="" />');

                if(v.x > 1 && v.x % 1 === 0 && v.y > 1 && v.y % 1 === 0) {
                    v.x = v.x / width;
                    v.y = v.y / height;
                }

                item.data('x', v.x);
                item.data('y', v.y);

                $wrapper.append(item);

                $this.trigger('taggd-add-item', [ item, v ]);

                if(typeof v.text === 'string' && v.text.length > 0) {
                    item.data('taggd-content', v.text);                    
                }

            }

            $this.removeAttr('style');
            methods.draw.call($this);
            $this.data('initialized', true);
        },
        'draw': function() {
            var $this = this;
            var $parent = $this.data('wrapper');
            var poffset = 0;
            var soffset = $(window).scrollTop();


            $parent.children('.taggd-item').each(function(i, e) {
                var $el = $(e);

                var left = $el.data('x') * $this.width();
                var top = $el.data('y') * $this.height();

                $el.css({
                    'left': (left - $el.outerWidth(true) / 2) + 'px',
                    'top': (top - $el.outerHeight(true) / 2) + 'px',
                    webkitTransform: 'scale(1)',
                });  
            });
        }
    };

    $.fn.taggd = function(tags, opt) {
        if(typeof tags === 'string' && methods[tags]) {
            return methods[tags].call(this, opt);
        } else {
            return methods.init.apply(this, arguments);
        }

        return this;
    };

    var win = $(window);

    var throttle = 250,
        handler = function() {
            curr = ( new Date() ).getTime();
            diff = curr - lastCall;

            if ( diff >= throttle ) {

                lastCall = curr;
                $( window ).trigger( "throttledresize" );

            } else {

                if ( heldCall ) {
                    clearTimeout( heldCall );
                }

                // Promise a held call will still execute
                heldCall = setTimeout( handler, throttle - diff );
            }
        },
        lastCall = 0,
        heldCall,
        curr,
        diff;

    win.resize(handler);

    win.on("deviceorientation", handler); 

    win.on("throttledresize", function() {
        for (var i = 0; i < instances.length; i++) {
            if (instances[i].data('initialized')) {
                methods.draw.call(instances[i]);
            }
        }        
        win.one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend webkitAnimationEnd oanimationend msAnimationEnd animationend', function() {
            for (var i = 0; i < instances.length; i++) {
                if (instances[i].data('initialized')) {
                    methods.draw.call(instances[i]);
                }
            }
            win.trigger('taggd-refresh');
        });
    });
})(jQuery);
