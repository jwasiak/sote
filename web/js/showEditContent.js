jQuery(function($)
{
   $(document).ready(function ()
   {
      var smarty_slots = $('.smarty_slot');
      var smarty_slot_update = false;

      var smarty_components = $('.smarty_component:not(:empty)');

      $('#theme_edit_mode').change(function() {
         $.cookies.set('st_theme_editor.edit_mode', this.checked, {path: '/'});
         if (!this.checked) {
            smarty_slots.sortable('destroy');
            smarty_components.css({ 'min-height': 0 });
            $('.smarty_handle').remove();
            $('.smarty_menu').remove();
         }
         else {
            smartySortableInit();
         }
      });         


      if (null === $.cookies.get('st_theme_editor.edit_mode')) {
        $('#theme_edit_mode').click();
      }

      function smartyUpdateComponents(smarty_component)
      {
         var components = smarty_component !== undefined ? smarty_component : smarty_components; 
         components.each(function() {

            var component = $(this);
            component.css({ 'min-height': '35px' });
            var height = component.height();
            var width = component.width();

            var handle = component.children('.smarty_handle');

            if (handle.length) {
               handle.height(height).width(width);
               component.children('.smarty_menu').width(width);
            } else {
               component.prepend('<div class="smarty_handle" style="height: '+height+'px; width: '+width+'px"></div>');
               
               if (component.hasClass('content_block_type')) {
                  var config = $('<div class="smarty_menu" style="width: '+width+'px"><a class="smarty_edit" href="/frontend_theme.php/stSmartyFrontend/contentBlockEdit"></a></div>');
                  config.click(function(event) {
                     var target = $(event.target);

                     if (target.hasClass('smarty_menu')) { 
                        return false;
                     }
                     
                     var overlay = $('<div class="smarty_popup_window smarty_preloader"></div>');
                     $('body').append(overlay);

                     overlay.overlay({
                        closeOnClick: false,
                        closeOnEsc: false,
                        top: "15%", 
                        speed: 'fast',
                        mask: {
                           color: '#444',
                           loadSpeed: 'fast',
                           opacity: 0.5,
                           zIndex: 30000
                        },                        
                        load: true,
                        onBeforeLoad: function() {
                           function showPreloader(api) {
                              api.getOverlay().addClass('smarty_preloader');
                              api.getOverlay().children('.smarty_popup_container').css({ visibility: 'hidden' });
                           }

                           var api = this;                           
                           $.post(target.attr('href'), {data: component.data('smarty')}, function(data) {
                              api.getOverlay().html(data);
                              api.getOverlay().removeClass('smarty_preloader');
                              api.getOverlay().find('.close a').click(function() {
                                 api.close();
                                 return false;
                              }); 

                              var form = $('#content_block_form'); 

                              var iframe = $('#content_block_form_submit');

                              form.submit(function() {
                                 showPreloader(api);
                              });

                              form.find('.smarty_restore').bind('restore', function() {
                                 showPreloader(api);
                                 $.post($(this).attr('href'), {data: form.find('#content_block_data').val()}, function(data) {
                                    if (data.decorator != 'box') {
                                       component.html(data.content);
                                    } else {
                                       var box = component.children('.box');
                                       box.children('.head').html(data.title);
                                       box.children('.content').html(data.content);                                        
                                    }

                                    smartyUpdateComponents(component);

                                    component.find('img').load(function() {
                                       smartyUpdateComponents(component);
                                    });                                    
                                    api.close();
                                 });
                              });

                              iframe.load(function() {
                                 results = $(this).contents().text();
                                 if (results && results != 'false') {
                                    if (tinymce.activeEditor) {
                                       tinymce.remove(tinymce.activeEditor);
                                    }
                                    var data = $.parseJSON(results);

                                    if (data.decorator != 'box') {
                                       component.html(data.content);
                                    } else {
                                       var box = component.children('.box');
                                       box.children('.head').html(data.title);
                                       box.children('.content').html(data.content);                                        
                                    }

                                    smartyUpdateComponents(component);

                                    component.find('img').load(function() {
                                       smartyUpdateComponents(component);
                                    });

                                    api.close();
                                 }

                                 return false;
                              });                                                      
                           });
                        },
                        onClose: function() {
                           if (tinymce.activeEditor) {
                              tinymce.remove(tinymce.activeEditor);
                           }                           
                           this.getOverlay().remove();
                        }
                     });

                     return false;
                  });
                  component.prepend(config);
               }
            }
         });            
      }

      function checkSlotPlaceholder(slot) {
         slot.removeClass('smarty_slot_placeholder');

         if (slot.height() == 0) {
            slot.addClass('smarty_slot_placeholder');
         } else {
            slot.removeClass('smarty_slot_placeholder');
         }
      }

      function smartySortableInit() {
         smarty_slots.sortable({
            pointerAt:  'top',
            tolerance: 'pointer',
            items:      '> .smarty_component:not(:empty)',
            connectWith: smarty_slots,
            cursor: 'move',
            placeholder: 'smarty_placeholder',
            forcePlaceholderSize: true,
            opacity: 0.4,
            create: function(event, ui) {
               checkSlotPlaceholder($(this));
            },
            update: function(event, ui) {
               smarty_slot_update = true;
            },            
            stop: function(event, ui) {
               if (smarty_slot_update) {
                  var slots = {'slots': {}};

                  smarty_slots.each(function() {

                     var slot = $(this);
                     var slot_id = slot.attr('id');
    
                     slots['slots'][slot_id] = [];
                     $(this).children('.smarty_component').each(function(index) {
                        var component = $(this);
                        slots['slots'][slot_id].push(component.data('smarty'));

                        component.attr('id', slot_id+':'+index);
                     });

                     checkSlotPlaceholder(slot);

                     if (!slots['slots'][slot_id].length) {
                        slots['slots'][slot_id] = false;  
                     }
                  });

                  smartyUpdateComponents();
         
                  $.post('/frontend_theme.php/stSmartyFrontend/updateSlots', slots);

                  $('#restore_default_layout').parent().show();
               }
            }
         });

         smartyUpdateComponents();
      }

      if ($.cookies.get('st_theme_editor.edit_mode'))
      {
         $('#theme_edit_mode').attr('checked', true);

         smartySortableInit();

         $(window).load(function() { smartyUpdateComponents() });
      }
				
	
   });
});