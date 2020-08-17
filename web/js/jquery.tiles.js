

jQuery(function($) {
    $.fn.tiles = function() {
        function init() {
            var container = {
                height: this.height(),
                width: this.width(),
                offset: this.offset()
            };

            container.offset.width = container.offset.left + container.width;

            this.height(container.height);
            var tiles = this.children('.tile');

            var y_index = 0;
            var x_index = 0;
            var positions = new Array(30);
            var computed_height = 0;

            for (var i=0; i < positions.length; i++) {
                positions[i] = new Array(100);
            }
            
            tiles.css({ display: 'inline-block' });

            tiles.each(function() {
                var tile = $(this);
                var width = tile.width();
                var height = tile.height();
                var left = positions[x_index-1] && positions[x_index-1][y_index] ? positions[x_index-1][y_index].left : container.offset.left;
                
                if (positions[x_index-1] && positions[x_index-1][y_index-1] && positions[x_index-1][y_index-1].left > left) {
                    var top = positions[x_index-1][y_index-1].top;
                } else if (positions[x_index] && positions[x_index][y_index-1]) {
                    var top = positions[x_index][y_index-1].top; 
                } else {
                    var top = container.offset.top;
                }

                var y_offset = top + height;
                var x_offset = left + width;

                if (x_offset > container.offset.width) {
                    x_index = 0;
                    y_index++;
                    left = container.offset.left;
                    top =  positions[x_index][y_index-1].top;   
                    y_offset = top + height;
                    x_offset = left + width;                                      
                }

                tile.css({ "top": top+'px', "left": left+'px', position: 'absolute' });
                
                positions[x_index][y_index] = { 'left': x_offset, 'top': y_offset };              

                if (y_offset > computed_height) {
                    computed_height = y_offset;
                }
                
                x_index++;
            });

            $this.height(computed_height - container.offset.top);            
        }

        this.each(function() {
            $this = $(this);
            init.call($this);
            $(window).load(function() {
                init.call($this);
            });
            $(window).resize(function() {
                init.call($this);
            });
        });
    };
});

