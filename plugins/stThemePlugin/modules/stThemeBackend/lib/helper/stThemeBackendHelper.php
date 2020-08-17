<?php

function st_theme_color_pallete_select_tag($for, $color, $colors)
{
   return select_tag($for, options_for_select($colors, $color, array('include_custom' => 'Domyślny')));
}

function st_theme_layout_field($name, stThemeConfig $config, ThemeConfig $theme_config)
{
   $layout_config = $config->get('layout_config');

   $category = $layout_config[$name];

   if ($category)
   {
      $options = array('' => __('Układ domyślny'));

      foreach ($category['layouts'] as $layout)
      {
         $options[$layout] = __($layout_config['_layouts'][$layout]);
      }

      $layouts = $theme_config->getConfigParameter('layouts');

      echo st_admin_get_form_field('layout_config['.$name.']', __($category['label']), $options, 'select_tag', array('selected' => isset($layouts['config'][$name]) ? $layouts['config'][$name] : null));
   }
}

function st_theme_generate_editor_fields($category, stThemeEditorConfig $editor_config, ThemeConfig $theme_config)
{
   if (is_array($category))
   {
      foreach ($editor_config->getGraphicFields($category) as $field)
      {
         $name = $category[0];

         $help = __($editor_config->getGraphicFieldParameter($name, $field, 'help'));
         
         $label = $editor_config->getGraphicFieldParameter($name, $field, 'label');

         $default = $editor_config->getGraphicFieldParameter($name, $field, 'default');

         if ($editor_config->isGraphicFieldRelated($name, $field))
         {
            $value = $theme_config->getLess($field);

            echo st_admin_get_form_field('theme_config['.$name.']['.$field.']', __($label), $value == 'transparent' ? '' : $value, 'st_theme_colorpicker_input_tag', array('default' => $default, 'help' => $help));
         }
         else
         {
            $value = $theme_config->getLess($field, $default);

            echo st_admin_get_form_field('theme_config['.$name.']['.$field.']', __($label), $value == 'transparent' ? '' : $value, 'st_colorpicker_input_tag', array('help' => $help));
         }
      }
   }
   else
   {
      foreach ($editor_config->getGraphicFields($category) as $field)
      {
         $help = __($editor_config->getGraphicFieldParameter($category, $field, 'help'));

         $label = $editor_config->getGraphicFieldParameter($category, $field, 'label');

         $default = $editor_config->getGraphicFieldParameter($category, $field, 'default');

         if ($editor_config->hasGraphicFieldType($category, $field, 'css'))
         {
            if ($editor_config->hasGraphicFieldProperty($category, $field, 'background-image'))
            {
               echo st_admin_get_form_field('theme_config['.$category.']['.$field.']', __($label), $theme_config->getCss($category, $field, $default), 'st_theme_upload_image_tag', array('theme_config' => $theme_config, 'help' => $help));
            }
            elseif ($editor_config->hasGraphicFieldProperty($category, $field, 'background-repeat'))
            {
               echo st_admin_get_form_field('theme_config['.$category.']['.$field.']', __($label), $theme_config->getCss($category, $field, $default), 'st_theme_background_repeat_tag', array('help' => $help));
            }
            elseif ($editor_config->isGraphicFieldRelated($category, $field))
            {
               $value = $theme_config->getCss($category, $field);

               echo st_admin_get_form_field('theme_config['.$category.']['.$field.']', __($label), $value == 'transparent' ? '' : $value, 'st_theme_colorpicker_input_tag', array('default' => $default, 'help' => $help));
            }
            else
            {
               $value = $theme_config->getCss($category, $field, $default);

               echo st_admin_get_form_field('theme_config['.$category.']['.$field.']', __($label), $value == 'transparent' ? '' : $value, 'st_colorpicker_input_tag', array('help' => $help));
            }
         }
         elseif ($editor_config->hasGraphicFieldType($category, $field, 'image'))
         {            
            echo st_admin_get_form_field('theme_config['.$category.']['.$field.']', __($label), $theme_config->getImage($category, $field, $default), 'st_theme_upload_image_tag', array('theme_config' => $theme_config, 'help' => $help));
         }
      }
   }
}

function st_theme_colorpicker_input_tag($name, $value, $params = array())
{
   $default = $params['default'];

   $colorpicker_tag = st_colorpicker_input_tag($name, $value ? $value : $default, array('disabled' => null === $value));

   $default_tag = label_for($name.'[default]', __('kolor z palety'), array('style' => 'float: none')).checkbox_tag($name.'[default]', true, null === $value);

   $id = get_id_from_name($name);

   $html = <<<HTML
<div style="float: left">$colorpicker_tag</div>
<div style="float: left; padding-left: 10px">$default_tag</div>
   <script type="text/javascript">
   jQuery('#{$id}_default').change(function()
   {
      jQuery('#'+this.id.replace('_default', '')).attr('disabled', this.checked);
   });  
   </script>   
HTML;

   return $html;
}

function st_theme_background_repeat_tag($name, $selected)
{
   return select_tag($name, options_for_select(array('no-repeat' => __('Brak'), 'repeat-x' => __('W poziomie'), 'repeat-y' => __('W pionie'), 'repeat' => __('W pionie i poziomie')), $selected));
}

function st_theme_upload_image_tag($name, $image, $params = array())
{
   $theme_config = $params['theme_config'];

   $preview_tag = '';

   $restore = '';

   if ($image)
   {
      if ($image{0} == '/')
      {
         $preview = $image;
      }
      else
      {
         $preview = $theme_config->getTheme()->findEditorImagePath($image);
      }

      if (strpos($image, '_editor/') !== false && is_readable($theme_config->getTheme()->getEditorImagePath($image, true)))
      {
         $restore = '<p>'.label_for($name.'[restore]', __('przywróć domyślne'), array('style' => 'float: none')).checkbox_tag($name.'[restore]', true, false).'</p>';
      }

      $preview_tag = "<img class=\"st_theme_image_preview\" src=\"$preview\" style=\"margin-left: 10px; border: 1px dotted #ccc; padding: 5px; vertical-align: top; max-height: 100px; max-width: 400px; background-color: #eee\" />";
   }

   $file_tag = input_file_tag($name);

   $id = get_id_from_name($name);

   $html = <<<HTML
   <div style="float: left">
      $file_tag
      $restore
   </div>
   <div style="float: left">
      $preview_tag
   </div>
   <div style="clear: left"></div>
   <script type="text/javascript">
   jQuery('#{$id}_restore').change(function()
   {
      jQuery('#'+this.id.replace('_restore', '')).attr('disabled', this.checked);
   });  
   </script>
HTML;

   return $html;
}
