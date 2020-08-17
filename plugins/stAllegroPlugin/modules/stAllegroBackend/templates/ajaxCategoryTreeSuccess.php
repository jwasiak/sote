<div id="jstree" style="padding: 0px 10px 10px 0px"></div>

<script type="text/javascript">
   jQuery(function($) {
      $.getScript('/jQueryTools/jstree/js/jstree.min.js?v1', function() {
         var jstree = $('#jstree');
         jstree.jstree({
            themes: {
               url: "/jQueryTools/jstree/themes/default/style.css",
               theme: 'default'
            },
            html_data: {
               ajax: {
                  url:  function(node) {
                     var id = node ? node.attr('id').replace('jstree-', '') : 0;
                     return "<?php echo st_url_for('@stAllegroPlugin?action=ajaxCategoryChildren'); ?>?id="+id+"&path=<?php echo implode(',', $path) ?>";
                  },
                  type: 'POST'
               },
               data: '<?php echo $tree;?>'
            },
            plugins:   ["themes", "html_data"]
         });

      jstree.click(function(event) {
         var target = $(event.target).filter('input:radio'); 

         if (target.length) {
            var id = event.target.value;
            jstree.data('selected', id);
         }
      });
   });

});
</script>
