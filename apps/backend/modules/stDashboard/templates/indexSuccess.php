<?php
use_helper('stAdminGenerator');
use_helper('stBackend');
use_javascript('jquery.cookie.js');
use_javascript('backend/dashboard.js?v5');
use_stylesheet('backend/beta/dashboard.css?v5', 'last');
?>
<div id="dashboard">
   <ul class="menu">
      <li><a href="#<?php echo get_gadget_column_id($default_dashboard, 1) ?>" rel="#gadgets_directory"><?php echo __('Dodaj gadżet', null, 'stBackend') ?></a></li>
      <li class="config">
         <a href="#"><?php echo __('Konfiguracja', null, 'stBackend') ?></a>
         <ul class="dropdown_menu">
            <li><a href="#default" class="action"><?php echo __('Ustaw jako domyślny', null, 'stBackend') ?></a></li>
            <li><a href="#edit" class="action"><?php echo __('Edytuj pulpit', null, 'stBackend') ?></a></li>
            <li><a href="#delete" class="action"><?php echo __('Usuń pulpit', null, 'stBackend') ?></a></li>
         </ul>
      </li>
      <li class="clr"></li>
   </ul>
	<ul class="tabs">
<?php foreach ($dashboards as $dashboard): ?>
		<li><a href="#<?php echo $dashboard->getId() ?>-<?php echo $dashboard->getUpdatedAt() ?>" class="tab<?php if ($dashboard->getIsDefault()): ?> current<?php endif ?>"><?php echo $dashboard->getLabel() ?></a></li>
<?php endforeach; ?>
      <li class="new" <?php if (count($dashboards) >= 5): ?>style="display: none"<?php endif; ?>><a href="#new" class="action">+</a></li>
		<li class="clr"></li>
	</ul>
	<div class="panes">
<?php foreach ($dashboards as $dashboard): ?>
			<div id="<?php echo $dashboard->getId() ?>-<?php echo $dashboard->getUpdatedAt() ?>" class="<?php echo $dashboard->getLayout() ?>" style="display: none"></div>
<?php endforeach; ?>
	</div>
</div>

<div id="gadgets_directory" class="popup_window preloader_160x24"></div>
<div id="gadgets_configuration" class="popup_window preloader_160x24"></div>

<script type="text/javascript">
   jQuery(function($) {

      var dashboard_api = initializeDashboardTabs(<?php echo $default_index ?>);

      function editOrCreateDashboard(dashboard_id, callback) {
         
         var dashboard_configuration = $('<div id="dashboard_configuration" class="popup_window preloader_160x24"></div>');

         $('#dashboard').after(dashboard_configuration);
         
         dashboard_configuration.overlay({
            speed: 'fast',
            close: '#',
            load: false,
            mask: {
               color: '#444',
               loadSpeed: 'fast',
               opacity: 0.5
            }
         });

         dashboard_configuration.bind('onBeforeLoad', function() {
     
               var api = $(this).data("overlay");;
              
               var overlay = api.getOverlay();

               var params = {};
               
               if (dashboard_id) {
                  params.id = dashboard_id;
               }
               
               overlay.addClass('preloader_160x24');

               $.get('<?php echo st_url_for('@stDashboard?action=ajaxEditOrCreate') ?>', params, function(html) {
                  
                  var html = $(html);
                  
                  var form = html.filter('.content').children('form');
                  
                  form.find('#dashboard_configuration_label').change(function() {
                     var input = $(this);

                     if (!input.val().replace(' ', ''))
                     {
                        input.val(input.attr('defaultValue'));
                     }
                  });         

                  form.submit(function(event) {
                     overlay.addClass('preloader_160x24');
                     form.css({ visibility: 'hidden' });
                     $.post(form.attr('action'), form.serializeArray(), function(data) {
                        if (callback) {
                           callback.call(this, data);
                        }
                        dashboard_api.getCurrentTab().html(data.label);
                        overlay.removeClass('preloader_160x24');
                        overlay.html('');
                        api.close();
                        dashboard_configuration.remove();

                        
                     }, 'json');
                     event.preventDefault();
                  });        
                  
                  overlay.html(html);

                  overlay.find('.close a').click(function(event) {
                     api.close();
                     event.preventDefault();
                  });                  
                  
                  overlay.removeClass('preloader_160x24');
               });
            });
         
         dashboard_configuration.data('overlay').load();
      }
      
      var dashboard_menu = initializeDropdownMenu('#dashboard > ul.menu > li.config', function(event) {
         var action = $(this);

         var dashboard = getCurrentDashboardData();
         
         if (!action.hasClass('disabled'))
         {
            switch (action.attr('href')) {
               case '#default':
                  $.get('<?php echo st_url_for('@stDashboard?action=ajaxSetDefault') ?>', {id: dashboard.id});
                  break;
               case '#edit':
                  editOrCreateDashboard(dashboard.id, function(data) {
                     var pane = dashboard_api.getCurrentPane();
                     if (pane.attr('class') != data.layout) {
                        var index = dashboard_api.getIndex();
                        var tab = dashboard_api.getCurrentTab();                        
                        tab.attr('href', '#'+data.id+'-'+data.updated_at);
                        pane.attr('id', data.id+'-'+data.updated_at);
                        pane.html('');
                        pane.attr('class', data.layout);
                        dashboard_api.destroy();
                        dashboard_api = initializeDashboardTabs(index);
                     }
                  });
                  break;
               case '#delete':
                  if (window.confirm('<?php echo __('Jesteś pewien, że chcesz usunać wybrany pulpit?', null, 'stBackend') ?>'))
                  {
                     $.get('<?php echo st_url_for('@stDashboard?action=ajaxDelete') ?>', {'id': dashboard.id}, function(data) {

                        var index = dashboard_api.getIndex() < dashboard_api.getTabs().length - 1 ? dashboard_api.getIndex() + 1: dashboard_api.getIndex() - 1;
                        var tab = dashboard_api.getTabs().eq(index);
                        dashboard_api.getCurrentTab().parent().remove();
                        dashboard_api.getCurrentPane().remove();
                        dashboard_api.destroy();
                        dashboard_api = initializeDashboardTabs(null);
                        dashboard_api.click(tab.attr('href'));
                     });
                  }
                  break;
            }
         }

         event.preventDefault();
      });
      
		function initializeDashboardTabs(index) {
			var tabs = $('#dashboard > .tabs').tabs('#dashboard > div.panes > div', {
				initialIndex: index,
				tabs: 'a.tab',
				onBeforeClick: function(event, i) {
               if (this.getPanes().length > 0) { 
   					var pane = this.getPanes().eq(i);

   					var dashboard = getCurrentDashboardData(this, i);

   					if (pane.is(':empty'))
   					{
                     pane.addClass('preloader_160x24');

   						$.get('<?php echo st_url_for('@stDashboard?action=ajaxChoose') ?>', {id: dashboard.id, refresh: dashboard.updated_at, culture: '<?php echo $sf_user->getCulture() ?>'}, function(html) {
   							pane.removeClass('preloader_160x24');
                        pane.html(html);
   							initializeDashboard(pane);
   						}, 'html');
   					} else {
                     pane.find('.gadget').each(function() {
                        refreshGadgets($(this), false);
                     });
                  }

   					var trigger = $('#dashboard > .menu > li > a[rel=#gadgets_directory]');

   					trigger.attr('href', trigger.attr('href').replace(/#column-[0-9]+-([0-9]+)/, '#column-'+dashboard.id+'-$1'));

                  $('#dashboard > .menu').show();
               } else {
                  $('#dashboard > .menu').hide();
               }
				}
			});

         var api = tabs.data('tabs');

         if (api.getTabs().length >= 5) {
            tabs.children('.new').hide();
         } else {
            tabs.children('.new').show();
         }

         return api;
		}

		$('#dashboard > .tabs > li > .action').click(function(event) {

			var action = $(this);

			switch(action.attr('href'))
			{
				case '#new':
					editOrCreateDashboard(null, createDashboard);
				break;
			}

			event.preventDefault();
		});
      
      function createDashboard(data)
      {
         dashboard_api.destroy();
         var tabs = $('#dashboard > .tabs');
         tabs.children('.new').before('<li><a href="#'+data.id+'-'+data.updated_at+'" class="tab">'+data.label+'</a></li>');
         $('#dashboard > .panes').append('<div class="'+data.layout+'"></div>');
         dashboard_api = initializeDashboardTabs(tabs.find('> li > a.tab').length-1);
         initializeDashboard(dashboard_api.getCurrentPane());
         if (dashboard_api.getPanes().length > 1) {
            dashboard_menu.find('.action').removeClass('disabled');
         }         
      }
      
      function getCurrentDashboardData(api, index) {
         if (api == undefined) {
            api = dashboard_api;
         }

         var tab = index != undefined ? api.getTabs().eq(index) : api.getCurrentTab();
         
         var tmp = tab.attr('href').slice(1).split('-');

         return { id: tmp[0], 'updated_at': tmp[1] };
      }

		function addGadgetPlaceholderVisibility(column) {
			var columns = column == undefined ? dashboard_api.getCurrentPane().children('div.column') : column;

			columns.each(function() {
				if ($(this).children('.gadget').length)
				{
					$(this).children('.add-gadget-placeholder').hide();
				}
				else
				{
					$(this).children('.add-gadget-placeholder').show();
				}
			});
		}

		function gadgetActionsEvent(event) {
			var dashboard = getCurrentDashboardData();

			var action = $(this);

			var gadget_id = action.attr('href').replace('#gadget-', '');

			var gadget = $(this).parents('.gadget');

			if (action.hasClass('edit')) {
				var content = gadget.children('.content');

				var configuration = $('#gadgets_configuration');

				configuration.overlay({
               speed: 'fast',
               mask: {
                  color: '#444',
                  loadSpeed: 'fast',
                  opacity: 0.5
               },
               onClose: function() {
                  this.getOverlay().html('');
                  configuration.removeClass('preloader_160x24');
               }
            });

            var api = configuration.data('overlay');

            api.load();

				$.get('<?php echo st_url_for('@stDashboard?action=ajaxEditGadget') ?>', {'id': gadget_id, 'dashboard_id': dashboard.id}, function(data) {
					api.getOverlay().html(data);

               api.getOverlay().find('.close a').click(function() {
                  api.close();

                  return false;
               });

               var form = api.getOverlay().find('.content > form');

               form.find('#gadget_configuration_title').change(function() {
                  var input = $(this);

                  if (!input.val().replace(' ', ''))
                  {
                     input.val(input.attr('defaultValue'));
                  }
               });

               form.submit(function(event) {
                  configuration.addClass('preloader_160x24');
                  form.css({ visibility: 'hidden' });
                  $.post(form.attr('action'), form.serializeArray(), function(data) {
                     var header = gadget.children('h2');
                     header.html(data.title);
                     header.css({ 'background-color': data.color });
                     if (data.refresh_by > 0) {
                        initGadgetRefresh(gadget, data.refresh_by * 1000);
                     }
                     else {
                        stopGadgetRefresh(gadget);
                     }
                     api.close();
                  }, 'json');
                  event.preventDefault();
               });         
				});
			} else if (action.hasClass('delete') && window.confirm('<?php echo __('Jesteś pewien, że chcesz usunać wybrany gadżet?', null, 'stBackend') ?>')) {
				$.get('<?php echo st_url_for('@stDashboard?action=ajaxRemoveGadget') ?>', {'id': gadget_id, 'dashboard_id': dashboard.id}, function() {
					var column = gadget.parent('.column');
					gadget.remove();
               addGadgetPlaceholderVisibility(column);
				});
			}
         else if (action.hasClass('refresh')) {
            refreshGadgets(gadget);
         }

			event.preventDefault();
		}
      
      
      function gadgetIframeLoad() {
         var iframe = $(this);

         var content = iframe.parent('.content');
         content.removeClass('preloader_160x24'); 
         iframe.show().css({visibility: 'visible'});
         if (iframe.attr('src').charAt(0) == '/') {    
            if(this.contentDocument){
               var height = this.contentDocument.body.offsetHeight;
            } else {
               var height  = this.contentWindow.document.body.scrollHeight;
            }

            iframe.css({ 'height': height+'px' });
         }
      }

      function initGadget(gadget) {
         gadget.find('> .content > iframe').load(gadgetIframeLoad);

         initializeDropdownMenu(gadget.find('> .menu > .config'), gadgetActionsEvent);
      }


		function gadgetsDirectory(objects) {
			objects.overlay({
				speed: 'fast',
				close: '#',
				mask: {
					color: '#444',
					loadSpeed: 'fast',
					opacity: 0.5
				},
				onBeforeLoad: function() {
					var api = this;
					var overlay = api.getOverlay();
					var dashboard =  api.getTrigger().attr('href').replace('#column-', '').split('-');
					var column_id = '#column-'+dashboard[0]+'-'+dashboard[1];
					$.get('<?php echo st_url_for('@stDashboard?action=ajaxGadgetDirectory') ?>', function(html) {
						overlay.removeClass('preloader_160x24');
						overlay.html(html);
						$('#gadgets_directory .tabs').tabs("div.panes > div");
						$('#gadgets_directory .gadget .add > a').click(function(event) {
							if ($(this).hasClass('preloader_26x26'))
							{
								return event.preventDefault();
							}

							var name = $(this).attr('href').slice(1);

							var add_buttons = overlay.find('.gadget .add a[href=#'+name+']');

							add_buttons.addClass('preloader_26x26');

							$.get('<?php echo st_url_for('@stDashboard?action=ajaxAddGadget') ?>', {'column': dashboard[1], 'name': name, 'dashboard_id': dashboard[0]}, function(html) {
								var gadget = $(html);
								var column = $(column_id);
								initGadget(gadget);
								column.prepend(gadget);
								add_buttons.removeClass('preloader_26x26');
								addGadgetPlaceholderVisibility(column);
							});
							event.preventDefault();
						});
						overlay.find('.close > a').click(function(event) { api.close(); event.preventDefault(); });
					});

				},
				onClose: function() {
					this.getOverlay().html('').addClass('preloader_160x24');
				},
				closeOnClick: false
			});
		}

		gadgetsDirectory($('#dashboard > .menu > li > a[rel=#gadgets_directory]'));

		function initializeDashboard(pane) {
			var dashboard_columns = pane ? pane.children('div.column') : dashboard_api.getCurrentPane().children('div.column');

			gadgetsDirectory(dashboard_columns.find('> .add-gadget-placeholder > a[rel=#gadgets_directory]'));

			var gadgets = dashboard_columns.children('.gadget');

			initGadget(gadgets);

			var changed = false;

			dashboard_columns.sortable({
				pointerAt:  'top',
				tolerance: 'pointer',
				items:      '> .gadget',
				connectWith: dashboard_columns,
				handle: '.moveable',
				cursor: 'move',
				placeholder: 'placeholder',
				forcePlaceholderSize: true,
				opacity: 0.4,
				update: function(event, ui) {
					changed = true;
				},
				start: function(event, ui) {
               dashboard_columns.find('> .add-gadget-placeholder').hide();
               ui.item.find('> .content > iframe').css({'visibility': 'hidden'});
               ui.item.find('> .content').addClass('preloader_160x24');
				},
            beforeStop: function(event, ui) {
               
            },
				stop: function(event, ui) {
               addGadgetPlaceholderVisibility();
					if (changed)
					{                  
						var parent = ui.item.parent('.column');

						var dashboard = parent.attr('id').replace('column-', '').split('-');

						var gadget = ui.item.attr('id').replace('gadget-', '');

						var position = parent.children('.gadget').index(ui.item);

                  var iframe = ui.item.find('> .content > iframe').css({'visibility': 'hidden'});
                  ui.item.find('> .content').addClass('preloader_160x24');

						$.post('<?php echo st_url_for('@stDashboard?action=ajaxUpdateLayout') ?>', {'column': dashboard[1], 'gadget_id': gadget, 'position': position+1, 'dashboard_id': dashboard[0]}, function() {
                     var date = new Date();

                     var src = iframe.attr('src').replace(/refreshed_at=[0-9]+/, 'refreshed_at='+Math.ceil(date.getTime() / 1000));

                     iframe.attr('src', src); 
                  });

						changed = false;              
					}
				}
			});
		}

		initializeDashboard();
});
</script>