<?php

use_helper('I18N');

function category_picker_input_tag($name, array $defaults = array(), array $options = array())
{
   $title = __('Drzewo kategorii', array(), 'stCategory');

   $title2 = __('drzewo kategorii', array(), 'stCategory');

   $button_label = __('Zastosuj', array(), 'stCategory');

   $url = st_url_for('@stCategoryAction?action=ajaxCategoryTree');

   $id = get_id_from_name($name);

   $unique = uniqid();

   if (isset($options['show_default']))
   {
      $show_default = intval($options['show_default']);
   }
   else
   {
      $show_default = 1;
   }

   if (isset($options['allow_assign_leaf_only']))
   {
      $allow_assign_leaf_only = intval($options['allow_assign_leaf_only']);
   }
   else
   {
      $allow_assign_leaf_only = 0;
   }

   $allow_assign_parents_only = intval(isset($options['allow_assign_parents_only']) && $options['allow_assign_parents_only']);

   if (isset($options['default']))
   {
      $default = $options['default'];
   }
   else
   {
      $default = 0;
   }

   $overlay = <<<OVERLAY
   <a id="category_overlay_trigger" href="#" rel="#category_overlay">$title2</a>
   <div id="category_overlay" class="popup_window" style="border: 1px solid #dddddd;">
      <div class="close" style="position: absolute; right: -20px; text-align: right; top: -20px; width: 100%;"><img src="/images/frontend/theme/default2/buttons/close.png" alt="" /></div>
      <h2 style="border-bottom: medium none; color: #000; font-size: 16px; font-weight: normal; margin-top: 45px; padding: 0 25px 0 10px; text-align: center;">$title</h2>
      <div class="content preloader_160x24" style="width: 500px; max-height: 400px; min-height: 100px; overflow: auto; margin-bottom: -1px; padding: 28px 20px;">
      </div>
      <div style="background: #fff; padding: 10px; text-align: right">
         <button class="submit" type="button" style="background: none repeat scroll 0 0 #ddd; font-size: 14px; padding: 5px 20px; white-space: nowrap;">$button_label</button>
      </div>
   </div>
   <script type="text/javascript">
      jQuery(function($) {
         var show_default = $show_default;

         var allow_assign_leaf_only = $allow_assign_leaf_only;
         var allow_assign_parents_only = $allow_assign_parents_only;

         $('#category_overlay .submit').click(function() {

            var api = $('#category_overlay_trigger').data('overlay');

            var content = api.getOverlay().children('.content');

            var jstree = $('#jstree');

            content.addClass('preloader_160x24');

            jstree.css({ 'visibility': 'hidden' });

            var tokeninput = $('#$id');

            var added = jstree.data('added');

            var removed = jstree.data('removed'); 

            var default_category = jstree.find('input:radio:checked').attr('value');

            var instance = $.jstree._reference(jstree);

            if (added) {
               console.log("adding");
               console.log(added);
               $.each(added, function() {
                  var path = instance.get_path($('#jstree-'+this));
             
                  tokeninput.tokenInput("add", { 'id': Number(this), 'name': path.join(' / '), 'default': default_category == this });
               });
            }

            if (removed) {
               console.log("removing");
               console.log(removed);
               $.each(removed, function() {
                  tokeninput.tokenInput("remove", { 'id': this });
               });
            }

            tokeninput
               .prev('.token-input-list-backend')
               .find('input:radio[value="'+default_category+'"]')
               .attr('checked', true);

            api.close();     
         });

         $('#category_overlay_trigger').overlay({
            speed: 'fast',
            close: $('#category_overlay > .close img'),
            load: false,
            mask: {
               color: '#444',
               loadSpeed: 'fast',
               opacity: 0.5,
            },
            closeOnClick: false,
            closeOnEsc: false,
            onBeforeLoad: function() {
               var api = this;
               var value = $('#$id').val();
               var assigned = [];

               if (value) {               
                  var tokens = $.parseJSON(value);

                  $.each(tokens, function() {
                     assigned.push(this.id);
                  });
               }

               var default_category = show_default ? $('#$id').prev('ul').find('input[name="product_default_category"]:checked').attr('value') : null;
               
               var content = api.getOverlay().children('.content');

               content.html('');

               $.post('$url?v=$unique', {'assigned': assigned.join(), 'default': default_category, 'show_default': show_default, 'allow_assign_leaf_only': allow_assign_leaf_only, 'allow_assign_parents_only': allow_assign_parents_only}, function(html) {                 
                  content.html(html);
                  var jstree = $('#jstree');

                  if (allow_assign_parents_only)
                  {
                     jstree.click(function (event) {
                        var target = $(event.target).filter('input:checkbox');
      
                        if (target.length) {
                           var checked = event.target.checked;
                           var added = jstree.data('added') ? jstree.data('added') : [];
                           var removed = jstree.data('removed') ? jstree.data('removed') : [];

                           $('#jstree-' + target.val()).find('.assigned').each(function (index) {
                              if (index > 0) {
                                    var checkbox = $(this);
                                    checkbox.attr("checked", checked);
                                    checkbox.attr("disabled", checked);

                                    var id = checkbox.val();
                                    
                                    var tmp = added.indexOf(id);

                                    if (tmp > -1) {
                                       added.splice(tmp, 1);
                                    } 

                                    var tmp = removed.indexOf(id);

                                    if (tmp < 0) {
                                       removed.push(id);
                                    }
                              }
                           });

                           jstree.data('added', added);
             
                           jstree.data('removed', removed);
                        }
                     });
         
                     jstree.bind("load_node.jstree", function (event, data) {
         
                           if (data.rslt.obj != -1) {
                              var input = data.rslt.obj.children('.assigned');
         
                              var checked = input.attr('checked');
         
                              if (checked) {
                                 data.rslt.obj.find('.assigned').each(function (index) {
                                       if (index > 0) {
                                          var checkbox = $(this);
                                          checkbox.attr("checked", checked);
                                          checkbox.attr("disabled", checked);
                                       }
                                 });
                              }
                           }
                           else {
                              var checked = jstree.find('li:has(>input:checked)');
         
                              checked.find('ul .assigned').prop('checked', true).prop('disabled', true);
                           }
                     });
                  }
               });
            }
         });
      });
   </script>
OVERLAY;

   $token_formatter = _token_input_category_token_formatter($default, $show_default);

   return st_tokenizer_input_tag($name, st_url_for('@stProductDefault?action=ajaxCategoryToken&allow_assign_leaf_only=' . $allow_assign_leaf_only), $defaults, array(
      'tokenizer' => array(
         'preventDuplicates' => true, 
         'hintText' => __('Wpisz nazwę szukanej kategorii', array(), 'stCategory'),
         'tokenFormatter' => $token_formatter,
      )
   )).$overlay;   
}

function _token_input_category_token_formatter($default, $show_default = true)
{
   if ($show_default)
   {
      if (!$default) 
      {
         $default = 0;
      }

      return "function (item) { 
         var checked = '';
         if (item.default === undefined && item.id == $default || item.default) {
            checked = 'checked=\"checked\"';
         }

         return '<li class=\"category_token\"><input name=\"product_default_category\" type=\"radio\" value=\"'+item.id+'\" '+checked+' onclick=\"event.stopPropagation();\" />'+item.name+'</li>';
      }";   
   }  
   
   return "function (item) { 
      return '<li class=\"category_token\">'+item.name+'</li>';
   }";  
}