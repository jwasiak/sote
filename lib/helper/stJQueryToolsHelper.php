<?php

function init_jcrop()
{
   static $initialized = false;

   if (!$initialized)
   { 
      use_stylesheet('/jQueryTools/jcrop/css/jquery.jcrop.min.css'); 
      use_javascript('/jQueryTools/jcrop/js/jquery.jcrop.min.js'); 
      $initialized = true;
   }    
}

function st_tokenizer_input_tag($name, $source, $defaults = array(), $options = array())
{
   static $js_included = false;

   if (!$js_included)
   { 
      if (SF_APP != 'backend')
      {
         use_javascript('/jQueryTools/tokenizer/js/jquery.tokeninput.js');
      }
      else
      {
         use_javascript('/jQueryTools/tokenizer/js/jquery.tokeninput.js?v9'); 
      }
      
      $js_included = true;
   }
   
   $extend = array();
   
   $tokenizer = array();
   
   if (isset($options['tokenizer']))
   {
      $tokenizer = $options['tokenizer'];
            
      if (isset($options['tokenizer']['resultsFormatter']))
      {
         $extend[] = sprintf('resultsFormatter: %s', $options['tokenizer']['resultsFormatter']);
      }
      
      if (isset($options['tokenizer']['tokenFormatter']))
      {
         $extend[] = sprintf('tokenFormatter: %s', $options['tokenizer']['tokenFormatter']);
      }

      if (isset($options['tokenizer']['onResult']))
      {
         $extend[] = sprintf('onResult: %s', $options['tokenizer']['onResult']);
      }

      if (isset($options['tokenizer']['onAdd']))
      {
         $extend[] = sprintf('onAdd: %s', $options['tokenizer']['onAdd']);
      }

      if (isset($options['tokenizer']['onBeforeAdd']))
      {
         $extend[] = sprintf('onBeforeAdd: %s', $options['tokenizer']['onBeforeAdd']);
      }  

      if (isset($options['tokenizer']['onDelete']))
      {
         $extend[] = sprintf('onDelete: %s', $options['tokenizer']['onDelete']);
      }    

      unset($options['tokenizer']);
   }

   if (!isset($tokenizer['theme']))
   {
      $tokenizer['theme'] = SF_APP == 'backend' ? 'backend' : 'facebook';

      if ($tokenizer['theme'] == 'facebook')
      {
         use_stylesheet('/jQueryTools/tokenizer/css/token-input.css');
         use_stylesheet('/jQueryTools/tokenizer/css/token-input-facebook.css');    
      }  
      elseif ($tokenizer['theme'] == 'backend')
      {
         use_stylesheet('backend/beta/token_input.css');
      }
   }

   if (!isset($tokenizer['noResultsText']))
   {
      $tokenizer['noResultsText'] = __('Nie znaleziono...', null, 'stJQueryTools');
   }

   if (!isset($tokenizer['searchingText']))
   {
      $tokenizer['searchingText'] = __('Szukanie w toku...', null, 'stJQueryTools');
   } 
   
   if (!isset($tokenizer['hintText']))
   {
      $tokenizer['hintText'] = __('Wpisz szukana frazę', null, 'stJQueryTools');
   }    

   if (!isset($tokenizer['hintText']))
   {
      $tokenizer['hintText'] = __('Wpisz szukana frazę', null, 'stJQueryTools');
   } 

   if (!isset($tokenizer['addNewText']))
   {
      $tokenizer['addNewText'] = __('dodaj', null, 'stJQueryTools');
   }                

   $tokenizer['prePopulate'] = $defaults;

   $tokenizer = json_encode($tokenizer);
   
   $extend = implode(', ', $extend);
   
   $id = isset($options['id']) ? $options['id'] : get_id_from_name($name);
   
   if (is_array($source))
   {
      $source = json_encode($source);
   }
   else
   {
      $source = '"'.$source.'"';
   }
   
   $js =<<<JS
<script type="text/javascript">
jQuery(function($) {
   var options = $tokenizer;

   $.extend(options, { $extend });
   var input = $('#$id');
   input.tokenInput($source, options);
   if (options.sortable) {
      var sortable = input.prev('ul.token-input-list-backend');
      sortable.sortable({ 
         items: '> :not(.token-input-input-token-backend)', 
         cursor: 'move',
         stop: function() {
            input.tokenInput('updateTokens');
         }
      }).disableSelection();
      sortable.children(':not(.token-input-input-token-backend)').each(function() {
         $(this).css({ cursor: 'move' });
      });
   }
});
</script>
JS;
   
   return input_tag($name, null, $options).$js;
}

function st_autocompleter_input_tag($name, $value = null, $options = array())
{
   static $js_included = false;

   if (!$js_included)
   {    
      if (SF_APP != 'backend')
      {
         use_javascript('/jQueryTools/autocompleter/js/jquery.autocomplete.js');      
      }
      else
      {
         use_javascript('/jQueryTools/autocompleter/js/jquery.autocomplete.js?v1');
         use_stylesheet('/jQueryTools/autocompleter/css/styles.css?v1');
      }
      
      $js_included = true;
   }

   if (!isset($options['autocompleter']))
   {
      throw new sfException('You must set the autocompleter option...');
   }

   if (isset($options['autocompleter']['onSelect']))
   {
      $on_select = $options['autocompleter']['onSelect'];

      unset($options['autocompleter']['onSelect']);
   }
   else
   {
      $on_select = '';
   }

   if (isset($options['autocompleter']['resultFormat']))
   {
      $format_result = $options['autocompleter']['resultFormat'];

      unset($options['autocompleter']['resultFormat']);
   }
   else
   {
      $format_result = '$.fn.autocomplete.fnFormatResult';
   }

   if (isset($options['autocompleter']['indicator']))
   {
      $indicator = $options['autocompleter']['indicator'];
   }
   else
   {
      $indicator = '/jQueryTools/autocompleter/images/indicator.gif';
   }

   $autocompleter = json_encode($options['autocompleter']);

   unset($options['autocompleter']);

   $id = isset($options['id']) ? $options['id'] : get_id_from_name($name);

   $js =<<<JS
<script type="text/javascript">
jQuery(function($) {
   var options = $autocompleter;

   $.extend(options, {
      indicator: $('#$id-indicator'),
      onSelect: function(value, data, el) { $on_select },
      fnFormatResult: function(value, data, current) { return $format_result(value, data, current); }
   });

   $('#$id').autocomplete(options);
});
</script>
JS;

   return input_tag($name, $value, $options).image_tag($indicator, array('alt' => '', 'id' => $id.'-indicator', 'class' => 'autocomplete-indicator')).$js;
}


function st_colorpicker_input_tag($name, $value, $params = array())
{
   static $js_included = false;

   if (!$js_included)
   {
      use_javascript('/jQueryTools/colorpicker/js/colorpicker.js?v1');
      use_javascript('/jQueryTools/colorpicker/js/st_colorpicker.js?v1');
      use_stylesheet('/jQueryTools/colorpicker/css/colorpicker.css?v1', 'last');
      use_stylesheet('/jQueryTools/colorpicker/css/layout.css?v1', 'last');

      $js_included = true;
   }

   $id = isset($params['id']) ? $params['id'] : get_id_from_name($name);

   $options = array();

   if (isset($params['colorpicker']))
   {
      $options = $params['colorpicker'];

      unset($params['colorpicker']);
   }

   $options['color'] = '#'.$value;

   $options = json_encode($options);

   $params['size'] = $params['maxlength'] = 6;

   $input = input_tag($name, $value, $params);

   $image = image_tag('/jQueryTools/colorpicker/images/select2.png', array('style' => 'background-color: '.(strpos($value, 'rgb') === false ? '#'.$value : $value), 'id' => $id.'-trigger'));

   $html = <<<HTML
<span class="colorpicker-control">
   <span>#</span>
   $input
   $image
   <script type="text/javascript">
      jQuery(function($) {
         $('#$id').stColorPicker($options);
      });
   </script>
</span>
HTML;

   return $html;
}

function plupload_init()
{
   static $js_included = false;
   
   if (!$js_included)
   {
      use_stylesheet('/jQueryTools/plupload/css/plupload.css?v10'); 
      use_javascript('/jQueryTools/plupload/js/plupload.js?v10');
      use_javascript('/jQueryTools/plupload/js/plupload.html4.js?v10');
      use_javascript('/jQueryTools/plupload/js/plupload.html5.js?v10');
      $js_included = true;
   }    
}

function plupload_images_tag($name, $images = array(), $params = array()) {

   $extensions = 'jpeg,jpg,gif,png';

   $max_file_size = '10mb';

   $translations = array(
      'Init error.' => __('Błąd inicjalizacji', null, 'stJQueryTools'),
      'Failed to open temp directory.' => __('Bład podczas otwierania katalogu tymczasowego.', null, 'stJQueryTools'),
      'File extension error.' => __('Nieprawidłowe rozszerzenie pliku (dozwolone: %extensions%).', array('%extensions%' => $extensions), 'stJQueryTools'),
      'File size error.' => __('Zbyt duży plik (maksymalny rozmiar: %max%).', array('%max%' => $max_file_size), 'stJQueryTools'),    
      'image_load' => __('Musisz poczekać na załadowanie obrazka', null, 'jQueryTools'), 
   );

   $confirm = __('Jesteś pewien?', null, 'stJQueryTools');   

   plupload_init();

   $storage = sfContext::getInstance()->getStorage();
   
   $request = sfContext::getInstance()->getRequest();

   $req_params = $request->getParameter($name, array('namespace' => uniqid(), 'delete' => null, 'modified' => null));
   
   $shop_hash = stConfig::getInstance('stRegister')->get('shop_hash');

   $namespace = $req_params['namespace'];

   $storage->write('soteshop/jQueryTools/plupload', $shop_hash);

   $token = sha1($shop_hash.$namespace);
      
   $delete = $req_params['delete'];

   $modified = $req_params['modified'];
   
   $id = get_id_from_name($name);
   
   $translations = json_encode($translations);

   $limit = isset($params['limit']) ? $params['limit'] : 0;

   $crop = isset($params['crop']) ? $params['crop'] : null;

   $cover = intval(isset($params['cover']) ? $params['cover'] : true);

   $actions = array();

   $width = 0;
   $height = 0;

   $types = sfAssetsLibraryTools::getImageTypes($crop);

   if (!sfAssetsLibraryTools::getCropImageTypes($crop))
   {
      $crop = null;
   }

   foreach ($types as $values)
   {
      if ($width < $values['width'])
      {
         $width = $values['width'];
      }

      if ($height < $values['height'])
      {
         $height = $values['height'];
      }
   }

   if ($crop)
   {
      $crop_action = array(
         'class' => 'crop_action',
         'icon' => '/jQueryTools/plupload/images/crop.png?v2',
      );

      $actions[] = $crop_action;
   }
   else
   {
      $crop_action = array();
   }

   if (isset($params['actions']))
   {
      $actions = array_merge($actions, $params['actions']);
   }
   elseif (isset($params['edit_url']))
   {
      $actions[] = array(
         'url' =>  st_url_for($params['edit_url']),
         'name' => __('Edycja', null, 'stJQueryTools'),
         'icon' => '/jQueryTools/plupload/images/edit.png?v2'
      );
   }

   $crop_json = json_encode($crop_action);

   $js =<<<JS
jQuery(function($) {

var form_auto_submit = false;
var limit = $limit;
var cover = $cover;
var crop = $crop_json;
var translations = $translations;
var namespace = '$namespace';

plupload.addI18n(translations);

var filelist = $('#plupload_{$id} .filelist');

function hidden_input_delete(name, value, by_index)
{
   var input = $('#{$id}_'+name);

   var values = input.val() ? input.val().split(',') : [];

   var index = by_index == undefined ? values.indexOf(value) : value;

   if (index != -1) {
      values.splice(index, 1);
   }   

   input.val(values.join());      
}

function hidden_input_add(name, value)
{
   var input = $('#{$id}_'+name);

   var values = input.val() ? input.val().split(',') : [];

   values.push(value);

   input.val(values.join());   
}

function update_modified_hidden_input()
{
   var images = [];

   $('#plupload_{$id} .file .tools').each(function() {
      var id = $(this).data('id');
      if (id) {
         images.push(id !== Number(id) ? id.split('/').pop() : id);
      }
   });

   $('#{$id}_modified').val(images.join());
}

function browse_button_visibility(forceVisible) {
   var browse_button = $('#plupload_{$id}_browse');

   if (forceVisible) {
      browse_button.show();
   } else if (limit > 0 && filelist.children('.file').not('.browse_button').length >= limit) {
      browse_button.hide();
   } else {
      browse_button.show();
   }
}

function tools_listener(event)
{
   var action = $(this);

   var file = action.parents('.file');

   var image_id = action.parent().data('id');

   if (image_id) {
      action.data('id', image_id);
   } else {
      image_id = action.data('id');
   }

   if (action.hasClass('delete'))
   {
      if (window.confirm('$confirm'))
      {
         if (!file.hasClass('new'))
         {
            hidden_input_add('delete', image_id);
         }
         
         file.remove();

         browse_button_visibility();

         update_modified_hidden_input();
      }  
      
      return false;

   } else if (action.hasClass('custom')) {
      
      var url = action.attr('href');

      if (url && url != '#') {
         var overlay = $('<div id="plupload_edit_overlay" class="popup_window preloader_160x24"></div>');

         $('body').prepend(overlay);

         overlay.overlay({
            closeOnClick: false,
            closeOnEsc: false,
            top: "5%", 
            speed: 'fast',
            mask: {
               color: '#444',
               loadSpeed: 'fast',
               opacity: 0.5,
               zIndex: 30000
            },    
            fixed: false,    
            oneInstance: false,                
            load: true,
            onBeforeLoad: function() {
               var api = this;
               var overlay = this.getOverlay();

               $.get(url, { 'image_id': image_id }, function(data) {
                  api.getOverlay().removeClass('preloader_160x24').html(data);
                  api.getOverlay().find('> .close img').click(function() {
                     api.close();

                     return false;
                  });
                  
                  overlay.css("top", Math.max(28, $(window).scrollTop() + 28) + "px");
                  overlay.css("left", Math.max(0, (($(window).width() - overlay.outerWidth()) / 2) + 
                                            $(window).scrollLeft()) + "px");
               });
            },
            onLoad: function() {
               var overlay = this.getOverlay();
               overlay.css("top", Math.max(28, $(window).scrollTop() + 28) + "px");
               overlay.css("left", Math.max(0, (($(window).width() - overlay.outerWidth()) / 2) + 
                                            $(window).scrollLeft()) + "px");
            },
            onClose: function() {
               overlay.remove();
            }
         });

         return false;
      }
   }  
}



var uploader = new plupload.Uploader({
   runtimes : 'html5,html4',
   browse_button : 'plupload_{$id}_browse',
   drop_element: 'plupload_{$id}',
   container: 'plupload_{$id}',
   max_file_size : '$max_file_size',
   url : '/jQueryTools/plupload/upload.php?namespace=$namespace&token=$token',
   filters : [
      {title : "Image files", extensions : "$extensions"}
   ]
});


/*
var form = $('#{$id}_modified').get(0).form;

$(form).submit(function(event) {
   if (uploader.state == plupload.STARTED)
   {
      event.preventDefault();

      form_auto_submit = true;
   }
});
*/


uploader.bind('Init', function(up) {
   browse_button_visibility();
});

uploader.bind('FileFiltered', function() {
   console.log('fileadded');

   return false;
});

uploader.bind('FilesAdded', function(up, files) {
   var browse_button = $('#plupload_{$id}_browse');
   var count = filelist.children('.file').not('.browse_button').length;

   files.each(function(item) {
      count++;
      if (limit > 0 && count > limit) {
         up.removeFile(item.id);
      } else {
         var file_id = 'plupload_{$id}_file_' + item.id;
         if (!crop) {
            browse_button.before('<div class="file new" id="'+file_id+'"><div class="preview"><div class="tools"><a href="#" class="delete"></a><div class="clr"></div></div></div></div>');
         } else {
            browse_button.before('<div class="file new" id="'+file_id+'"><div class="preview"><div class="tools"><a href="#" class="delete"></a><a href="#" class="custom '+crop.class+'" style="background-image: url('+crop.icon+')"></a><div class="clr"></div></div></div></div>');
            $('#'+file_id+' .'+crop.class).click(function(e) {
               var action = $(this);

               if (!action.data('id')) {
                  window.alert(translations.image_load);
                  e.stopImmediatePropagation();
                  e.stopPropagation();
                  return false;
               } 
            });  

            $(document).trigger('crop_overlay_'+namespace+'_init', '#'+file_id+' .'+crop.class);
         }
         $('#'+file_id+' .tools a').click(tools_listener);
      }
   });
   

   browse_button_visibility();
});

uploader.bind('QueueChanged', function(up, files) {
   up.start();
});

uploader.bind('Error', function() {
   browse_button_visibility(true);
});

uploader.bind('FileUploaded', function(up, file, info) {
   var response = $.parseJSON(info.response);
   
   if (response.error)
   {
      up.trigger('Error', response.error);
      browse_button_visibility(true);
   }
   else
   {
      var preview = $('#plupload_{$id}_file_'+file.id+' .preview');

      if (preview.length > 0)
      {
         var resource = 'uploads/plupload/$namespace/'+response.result.filename;
         var tools = preview.find('.tools');
         tools.data('id', resource);
         tools.children('a').data('id', resource);

         update_modified_hidden_input();
         
         var image = new Image();
         
         image.src = '/'+resource;

         image.onload = function() {
            if (cover) {
               preview.css({'background-image': 'url('+this.src+')' , 'background-size': 'cover'});
            } else {
               preview.parent().addClass('no-cover');
               preview.prepend('<img src="'+this.src+'" >');
            }

         }
      }
   }
});

uploader.bind('Error', function(up, args) {
   if (args.file) {
      $('#plupload_{$id}_file_' + args.file.id).remove();
   }
   window.alert(plupload.translate(args.message));
});

/*
uploader.bind('UploadComplete', function() {
   if (form_auto_submit) {
      form.submit();
   }
});
*/
uploader.init();

$('#plupload_{$id} .tools a').click(tools_listener);

if (limit !== 1) {
   filelist.sortable({ 
      placeholder: "file file-placeholder",
      tolerance: 'pointer',
      items: '> :not(.browse_button)',
      forcePlaceholderSize: false,
      cursor: 'move', 
      handle: '.tools',
      opacity: 0.5,
      stop: function(event, ui) {
         update_modified_hidden_input();
      },
      start: function(event, ui) {
         if (ui.item.index() == 0)
         {
            filelist.append(ui.item);
         }
      }
   });
   filelist.disableSelection();
} 
});     
JS;

   $filelist = '';

   if ($modified)
   {
      foreach (explode(',', $modified) as $image_id => $image_name)
      {
         if (isset($images[$image_name]))
         {
            $image_path = $images[$image_name]; 
            $filelist .= _plupload_thumb_helper($id, $image_id, $image_path, array('cover' => $cover));
         }
         else
         {
            $image_path = '/uploads/plupload/'.$namespace.'/'.$image_name;
            $filelist .= _plupload_thumb_helper($id, $image_id, $image_path, array('new' => true, 'cover' => $cover));
         }
      }
   }
   elseif (!$delete)
   {
      $custom_actions = '';

      foreach ($actions as $action)
      {
         $custom_actions .= '<a href="'.(isset($action['url']) ? $action['url'] : '#').'" class="custom'.(isset($action['class']) ? ' '.$action['class'] : '').'" style="background-image: url('.$action['icon'].')"></a>';
      }      

      foreach ($images as $image_id => $image_path)
      {
         $filelist .= _plupload_thumb_helper($id, $image_id, $image_path, array('custom_actions' => $custom_actions, 'cover' => $cover));
      }
   }

   if ($width > 0)
   {
      $size = __('Minimalny rozmiar', null, 'stJQueryTools').__('<br>%%width%%px x %%height%%px', array('%%width%%' => $width, '%%height%%' => $height));
   }
   else
   {
      $size = '';
   }

   $html =<<<HTML
<input name="{$name}[delete]" id="{$id}_delete" type="hidden" value="$delete" />
<input name="{$name}[modified]" id="{$id}_modified" type="hidden" value="$modified" />
<input name="{$name}[namespace]" id="{$id}_namespace" type="hidden" value="$namespace" />
<div id="plupload_{$id}" class="plupload">
   <div class="filelist">
      $filelist
      <div id="plupload_{$id}_browse" class="file browse_button" style="display: none">
         <div class="size">$size</div>
         <div class="preview"></div>
      </div>
      <div class="clr"></div>
   </div>
</div>  
<script type="text/javascript">$js</script> 
HTML;

   if ($crop)
   {
      $html .= st_get_component('stAssetImageConfiguration', 'imageCropper', array('for' => $crop, 'trigger' => '#plupload_'.$id.' .crop_action', 'namespace' => $namespace));
   }
   
   return $html;
}

function _plupload_thumb_helper($id, $image_id, $image_path, $params = array())
{

   if (!isset($params['cover']) || !$params['cover'])
   {
      return '<div class="file no-cover'.(isset($params['new']) && $params['new'] ? ' new' : '').'" id="plupload_'.$id.'_file_'.crc32($image_id).'"><div class="preview"><img src="'.$image_path.'" alt=""><div class="tools" data-id="'.$image_id.'"><a href="#" class="delete"></a>'.(isset($params['custom_actions']) ? $params['custom_actions'] : array()).'<div class="clr"></div><div style="position: absolute; bottom: 0; left: 0; padding: 2px 6px">ID: '.$image_id.'</div></div></div></div>';
   }

   return '<div class="file'.(isset($params['new']) && $params['new'] ? ' new' : '').'" id="plupload_'.$id.'_file_'.crc32($image_id).'"><div class="preview" style="background-image: url('.$image_path.'); background-size: cover"><div class="tools" data-id="'.$image_id.'"><a href="#" class="delete"></a>'.(isset($params['custom_actions']) ? $params['custom_actions'] : array()).'<div class="clr"></div><div style="position: absolute; bottom: 0; left: 0; padding: 2px 6px">ID: '.$image_id.'</div></div></div></div>';  
}