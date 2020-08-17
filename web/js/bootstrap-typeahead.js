jQuery(function($) {
    $.fn.typeahead = function(options) {
        var ignoreKeys = [9, 27, 37, 39, 13, 38, 40];        
        var defaults = {
            trigger: {
                hide: 'body',
                show: 'focus'
            },
            hidePopupIfEmpty: false,
            minLength: 3,
            template: function(suggestions) {
                var content = '';
                for (var i = 0; i < suggestions.length; i++) {
                    content += '<li>'+suggestions[i].name+'</li>';
                }

                return content;
            },
            messages: {
                noresults: "No results"
            }
        };
        options = $.extend(defaults, options);
        var $this = this;

        this.each(function() {
            var input = $(this);

            if (!input.hasClass('bootstrap-typeahead'))
            {
                input.addClass('bootstrap-typeahead');

                var content = '';
                var allowHide = true;

                function search()
                {
                    if (input.val().length >= options.minLength) {
                        content = '';
                        input.addClass('bootstrap-typeahead-preloader');
                        options.source(input.val(), function(suggestions) {
                            if (suggestions.length) {
                                content = options.template.call($this, suggestions);
                            } else {
                                content = '';
                            }

                            input.removeClass('bootstrap-typeahead-preloader');

                            if (!content.length && false !== options.messages.noresults || content.length) {
                                input.popover('show');
                            } else {
                                input.popover('hide');
                            }
                        });
                    }                    
                }

                var popoverOptions = {
                    'html': true, 
                    'placement':  'bottom',
                    'trigger':    'manual',
                    'template':   '<div class="popover typeahead-popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
                    'content':    function() {
                        if (content.length == 0) {
                            return '<ul class="list-unstyled"><li>'+options.messages.noresults+'</li></ul>';
                        }

                        return '<ul class="list-unstyled">'+content+'</ul>';
                    }
                };

                if (options.viewport) {
                    if (options.viewport.selector) {
                        popoverOptions.container = options.viewport.selector;
                    }

                    popoverOptions.viewport = options.viewport;
                }

                input.popover(popoverOptions);

                input.on('shown.bs.popover', function() {
                    var id = $(this).attr('aria-describedby');

                    $('#'+id).one('click', 'li[data-url]', function() {
                        window.location = $(this).data('url');
                        return false;
                    }).on('mouseleave', function() {
                        allowHide = true; 
                    }).on('mouseenter', function() {
                        allowHide = false;
                    });
                }); 

                if (options.trigger.hide == 'body') {
                    $('body').on('mouseup', function(e) {
                        if (allowHide) {
                            input.popover("hide");
                        } 
                    });

                    input.on('mouseleave', function() {
                        allowHide = true; 
                    }).on('mouseenter', function() {
                        allowHide = false;
                    });
                }

                input.keyup(function(e) {

                    var key = e.which || e.keyCode;

                    if (ignoreKeys.indexOf(key) < 0) {
                        search();
                    } 
                });

                if (options.trigger.show != 'manual') {
                    input.on(options.trigger.show, function() {
                        if (input.val().length >= options.minLength) {
           
                            search();
                        } else {
                            input.popover('hide');
                        }
                    });
                }

                if (options.trigger.hide != 'manual' && options.trigger.hide != 'body') {
                    input.on(options.trigger.hide, function() {
                        input.popover('hide');
                    });
                }
            }
        });

        var resized = false;

        $(window).resize(function() { 
            resized = true;
        });

        var $this = this;

        function update() {
            if (resized) {
                $this.each(function() {
                    var input = $(this);
                    if (input.attr('aria-describedby')) {
                        if (options.trigger.hide != 'manual') {
                            input.trigger(options.trigger.hide);
                        } else {
                            input.popover('hide');
                        }
                    }
                });
                resized = false;
            }
        }

        setInterval(update, 200);
    }
});