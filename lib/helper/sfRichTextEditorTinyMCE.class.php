<?php
use_helper('Javascript', 'I18N');

$response = sfContext::getInstance()->getResponse();

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfRichTextEditorTinyMCE implements the TinyMCE rich text editor.
 *
 * <b>Options:</b>
 *  - css - Path to the TinyMCE editor stylesheet
 *
 *    <b>Css example:</b>
 *    <code>
 *    / * user: foo * / => without spaces. 'foo' is the name in the select box
 *    .foobar
 *    {
 *      color: #f00;
 *    }
 *    </code>
 *
 * @package    symfony
 * @subpackage helper
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfRichTextEditorTinyMCE.class.php 904 2009-04-29 13:08:36Z bartek $
 */
class sfRichTextEditorTinyMCE extends sfRichTextEditor
{
   protected static $securityKey = null;

   const VERSION = '4.7.5';

   public static function getSecurityKey()
   {
      if (null === self::$securityKey)
      {
         self::$securityKey = sha1_file(sfConfig::get('sf_root_dir').'/data/config/__stRegister.yml');
      }

      return self::$securityKey;
   }

   public static function getJavascriptInit($id, $culture = null, $simple = false)
   {
      $key = self::getSecurityKey();

      $version = self::VERSION;

      $config = stConfig::getInstance('stTinyMCE');

      if ($simple) 
      {
         return "  
            tinymce.init({
              selector: \"#$id\",
              skin: \"custom\",
              plugins: [
                  \"autolink lists charmap print preview\",
                  \"searchreplace visualblocks fullscreen\",
                  \"insertdatetime paste autoresize\"
              ],
              browser_spellcheck: true,
              menubar: false,
              convert_urls: false,
              relative_urls: true,
              toolbar: \"undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist\",
              resize: true,
              image_advtab: true,
              language: \"$culture\",
              width: \"100%\",
              autoresize_max_height: 200,
              cache_suffix: \"?v=$version\",
              entity_encoding: \"raw\",
              extended_valid_elements: 'script[*]',
              content_css: [\"/css/backend/stTinyMCEContent.css\"],
              external_filemanager_path: \"/js/filemanager/\",
              external_plugins: { \"filemanager\" : \"/js/filemanager/plugin.min.js\"},
              filemanager_access_key: \"$key\",
            });      
         ";
      }
      else
      {
         $config = stConfig::getInstance('stTinyMCE');

         if ($config->get('advanced'))
         {

            $options = "
               toolbar1: \"insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image\",
               toolbar2: \"fontselect fontsizeselect | forecolor backcolor\",
               fontsize_formats: \"1em 8pt 9pt 10pt 12pt 14pt 18pt 24pt 36pt\",
            ";
         }
         else 
         {
            $options = "
               toolbar1: \"insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image\",
            ";
         } 

         return "  
            tinymce.init({
              selector: \"#$id\",
              skin: \"custom\",
              plugins: [
                  \"advlist autolink lists link image charmap print preview anchor\",
                  \"searchreplace visualblocks fullscreen\",
                  \"insertdatetime media table contextmenu paste responsivefilemanager autoresize textcolor colorpicker\"
              ],
              browser_spellcheck: true,
              image_advtab: true,
              convert_urls: false,
              relative_urls: true,
              $options
              external_filemanager_path: \"/js/filemanager/\",
              external_plugins: { \"filemanager\" : \"/js/filemanager/plugin.min.js\"},
              filemanager_access_key: \"$key\",
              resize: true,
              cache_suffix: \"?v=$version\",
              language: \"$culture\",
              width: \"100%\",
              autoresize_max_height: 400,
              entity_encoding: \"raw\",
              extended_valid_elements: 'script[*]',
              content_css: [\"/css/backend/stTinyMCEContent.css\"],
              image_title: true,
              rel_list: [
                {title: '".__('Brak', null, 'stAdminGeneratorPlugin')."', value: '' },
                {title: 'nofollow', value: 'nofollow'}
                
              ],
              file_picker_types: 'file image media',
              file_picker_callback: function(cb, value, meta) {
              var width = window.innerWidth-30;
              var height = window.innerHeight-60;
              if(width > 1800) width=1800;
              if(height > 1200) height=1200;
              if(width>600){
              var width_reduce = (width - 20) % 138;
              width = width - width_reduce + 10;
              }
              var urltype=2;
              if (meta.filetype=='image') { urltype=1; }
              if (meta.filetype=='media') { urltype=3; }
              var title=\"RESPONSIVE FileManager\";
              if (typeof this.settings.filemanager_title !== \"undefined\" && this.settings.filemanager_title) {
              title=this.settings.filemanager_title;
              }
              var akey=\"key\";
              if (typeof this.settings.filemanager_access_key !== \"undefined\" && this.settings.filemanager_access_key) {
              akey=this.settings.filemanager_access_key;
              }
              var sort_by=\"\";
              if (typeof this.settings.filemanager_sort_by !== \"undefined\" && this.settings.filemanager_sort_by) {
              sort_by=\"&sort_by=\"+this.settings.filemanager_sort_by;
              }
              var descending=\"false\";
              if (typeof this.settings.filemanager_descending !== \"undefined\" && this.settings.filemanager_descending) {
              descending=this.settings.filemanager_descending;
              }
              var fldr=\"\";
              if (typeof this.settings.filemanager_subfolder !== \"undefined\" && this.settings.filemanager_subfolder) {
              fldr=\"&fldr=\"+this.settings.filemanager_subfolder;
              }
              var crossdomain=\"\";
              if (typeof this.settings.filemanager_crossdomain !== \"undefined\" && this.settings.filemanager_crossdomain) {
              crossdomain=\"&crossdomain=1\";
              // Add handler for a message from ResponsiveFilemanager
              if(window.addEventListener){
              window.addEventListener('message', filemanager_onMessage, false);
              } else {
              window.attachEvent('onmessage', filemanager_onMessage);
              }
              }
              tinymce.activeEditor.windowManager.open({
              title: title,
              file: this.settings.external_filemanager_path+'dialog.php?type='+urltype+'&descending='+descending+sort_by+fldr+crossdomain+'&lang='+this.settings.language+'&akey='+akey,
              width: width,
              height: height,
              resizable: true,
              maximizable: true,
              inline: 1
              }, {
              setUrl: function (url) {
              cb(url);
              }
              });
              },
            });      
         ";
      }
   }

	/**
	 * Returns the rich text editor as HTML.
	 *
	 * @return string Rich text editor HTML representation
	 */
	public function toHTML()
	{
		$options = $this->options;

		// we need to know the id for things the rich text editor
		// in advance of building the tag
		$id = _get_option($options, 'id', get_id_from_name($this->name, null));

		sfContext::getInstance()->getResponse()->addJavascript('tinymce/tinymce.min.js?v='.self::VERSION);
      sfContext::getInstance()->getResponse()->addStylesheet('backend/stTinyMCEPlugin.css?v='.self::VERSION);

		$tinymce_options = '';
		$style_selector  = '';

		$culture = strtolower(substr(sfContext::getInstance()->getUser()->getCulture(), 0, 2));

		$function_name = 'tinymce_'.$id;

      $script = self::getJavascriptInit($id, $culture, isset($options['tinymce_options']) && strpos($options['tinymce_options'], 'simple') !== false);

		$tinymce_js = "
      function $function_name() {
         $script 
      }
    ";

      $editor_styles = $textarea_styles = '';

		if (isset($options['tinymce_options']))
		{
         $tinymce_options = $this->parseWidthAndHeight($options['tinymce_options']);

         if (isset($tinymce_options['width']))
         {
            $width = is_numeric($tinymce_options['width']) ? ($tinymce_options['width']-6).'px' : $tinymce_options['width']; 

            $height = is_numeric($tinymce_options['height']) ? $tinymce_options['height'].'px' : $tinymce_options['height']; 

            $editor_styles = 'width: '.$width.'; height: '.$height;

            $textarea_styles = 'width: 100%; height: '.$height;
         } 

			unset($options['tinymce_options']);
		}

      if (!$textarea_styles)
      {
         $textarea_styles = 'width: 100%; height: 200px';
      }

		$toggle =<<<JS
jQuery(function($) {
   var tabs = $("#$id-content > .tabs").tabs("#$id-content > div.panes > div");
   var textarea = $('#$id');
   var html_textarea = $('#{$id}-html');
   var content = textarea.val();
   var cleanup = false; 

   if (content.indexOf('<!--[mode:html]-->') != -1) {
      var mode = 'html';
      cleanup = true;
   } else if (content.indexOf('<!--[mode:tiny]-->') != -1) {
      var mode = 'tiny';
      cleanup = true;
   } else {
      var mode = 'tiny';
   }
   if (cleanup) {
      textarea.val(content.substr(18));
   }

   if (mode == 'html') {
      tabs.data('tabs').click(1);
      html_textarea.val(textarea.val());
   } else {
      tinyMode();
   }

   function tinyMode() {
      $function_name();
   }     

   textarea.parents('form').first().submit(function() {
      if (mode == 'html') {
         var value = html_textarea.val();
      } else {
         var value = tinymce.EditorManager.get(textarea.attr('id')).getContent();
      }

      var input = $('<input name="'+textarea.attr('name')+'" type="hidden" value="">');
      input.val(value ? '<!--[mode:'+mode+']-->'+value : '');

      textarea.prop('disabled', true);

      textarea.closest('form').append(input);    
   });

   tabs.on('onBeforeClick', function(e, index) {

      var instance = tinymce.EditorManager.get('$id');
      if (index == 0) {
         mode = 'tiny';
         var content = html_textarea.val();
         if (instance) {
            instance.setContent(content);
         } else {
            textarea.val(content);
            tinyMode();
         } 
      } else {
         mode = 'html';
         if (instance) {
            html_textarea.val(instance.getContent());
         } else {
            html_textarea.val(textarea.val());
         }
      }
   }).on('onClick', function(e, index) {
      if (index == 0) { 
            var instance = tinymce.EditorManager.get('$id');
            if (instance) {
               instance.focus();
            }
      } else {
         html_textarea.focus();
      }
   });

   textarea.on('change', function() {
      var instance = tinymce.EditorManager.get('$id');
      var content = $(this).val();

      if (instance) {
         instance.setContent(content);
      }

      html_textarea.val(content);
   });

});
JS;

		return
			javascript_tag($tinymce_js).
         '<div id="'.$id.'-content" class="tinymce-container"><ul class="tabs"><li><a class="tiny_mode" href="#">'.__('Wizualny', null, 'stTinyMCE').'</a></li><li><a class="html_mode" href="#">HTML</a></li></ul>'.
         '<div class="panes"><div>'.content_tag('textarea', $this->content, array_merge(array('name' => $this->name, 'id' => $id, 'style' => $textarea_styles), _convert_options($options))).'</div><div><textarea id="'.$id.'-html"style="'.$textarea_styles.'"></textarea></div></div></div>'.
			javascript_tag($toggle);
	}

   protected function parseWidthAndHeight($tinymce_options)
   {
      $tmp = str_replace("'", "", $tinymce_options);
      $tmp = preg_replace("/([a-z0-9%]+)/i", '"$1"', $tmp);
         
      return json_decode('{'.$tmp.'}', true);
   }
}
