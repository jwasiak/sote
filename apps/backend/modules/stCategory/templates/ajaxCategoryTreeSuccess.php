<div id="jstree" style="padding: 0px 10px 10px 0px">
</div>
<script type="text/javascript">

jQuery(function($) {
   $.getScript('/jQueryTools/jstree/js/jstree.min.js?v1', function() {
      var jstree = $("#jstree");
      jstree.jstree({
         themes: {
            url: "/jQueryTools/jstree/themes/default/style.css",
            theme: 'default'
         },
         html_data: {
            ajax: {
               url:  function(node) {
                  var id = node ? node.attr('id').replace('jstree-', '') : 0;
                  return "<?php echo st_url_for('@stCategoryAction?action=ajaxCategoryChildren') ?>?id="+id+"&default=<?php echo $default ?>&h=<?php echo uniqid() ?>";
               },
               data: { assigned: "<?php echo $sf_request->getParameter('assigned') ?>", show_default: <?php echo $show_default ?> },
               type: 'POST'
            },
            data: '<?php echo $html_data ?>'
         },
         plugins:   ["themes", "html_data"]
      });

      jstree.data('assigned', <?php echo json_encode(explode(',', $sf_request->getParameter('assigned'))) ?>);
      jstree.click(function(event) {
         var target = $(event.target).filter('input:checkbox'); 

         if (target.length) {
            var id = event.target.value;
           
            var instance =  $.jstree._reference(jstree);

            var settings = instance.get_settings();

            var added = jstree.data('added') ? jstree.data('added') : [];

            var removed = jstree.data('removed') ? jstree.data('removed') : [];

            var assigned = jstree.data('assigned');

            var input = $(event.target).next('input');

            input.attr('disabled', !event.target.checked);

            if (event.target.checked) {
               if (added.indexOf(id) < 0 && assigned.indexOf(id) < 0) {
                  added.push(id);
               } 

               var tmp = removed.indexOf(id);

               if (tmp > -1) {
                  removed.splice(tmp, 1);
               }
            } else {
               if (removed.indexOf(id) < 0) {
                  removed.push(id);
               } 

               var tmp = added.indexOf(id);

               if (tmp > -1) {
                  added.splice(tmp, 1);
               }    
            }

            jstree.data('added', added);

            jstree.data('removed', removed);

            if (event.target.checked) {
               if (jstree.find('input:radio::enabled:checked').length == 0) {
                  input.attr('checked', true);
               }
            }
         }
      });
   });

});
</script>