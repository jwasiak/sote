<?php

class stAllegroTemplateBackendActions extends autostAllegroTemplateBackendActions 
{

   public function validateEdit()
   {
      $ok = true;
      
      $id = $this->getRequestParameter('id');

      if ($id)
      {
         $template = AllegroTemplatePeer::retrieveByPK($id);

         if (null !== $template->getTheme())
         {
            $this->theme_config = $template->getThemeInstance()->getThemeConfig();

            $this->editor_config = $this->loadEditorConfiguration($this->theme_config);

            if ($this->getRequest()->getMethod() == sfRequest::POST)
            {
               $this->labels = array();

               $validator = new stAssetFileValidator();

               $validator->initialize($this->getContext(), array('mime_types' => '@web_images', 'required' => false));

               $validator->setParameter('max_image_size', array(4096, 4096));

               $files = $this->getRequest()->getFiles();

               if (isset($files['theme_config']))
               {
                  foreach ($files['theme_config']['name'] as $category => $fields)
                  {
                     foreach ($fields as $name => $value)
                     {
                        $value = $this->getRequest()->getFileValues('theme_config['.$category.']['.$name.']');

                        if ($value && !$validator->execute($value, $error))
                        {
                           $this->getRequest()->setError('theme_config{'.$category.'}{'.$name.'}', $error);

                           $ok = false;

                           $this->labels['theme_config{'.$category.'}{'.$name.'}'] = $this->editor_config->getGraphicFieldParameter($category, $name, 'label');
                        }
                     }
                  }
               }
            }
         }
      }

      return $ok;
   }

   public function executeRestore()
   {
      $pk = $this->getRequestParameter('id');

      $allegro_template = AllegroTemplatePeer::retrieveByPK($pk);

      $theme_config = $allegro_template->getThemeInstance()->getThemeConfig();
      
      $theme_config->restoreCss();

      $theme_config->restoreImages();
   
      $theme_config->save();

      $this->setFlash('notice', $this->getContext()->getI18N()->__('Domyślne ustawienia zostały przywrócone."'));

      return $this->redirect($this->getRequest()->getReferer());
   }

   public function executePreview()
   {
      $this->setLayout(false);

      $template = AllegroTemplatePeer::retrieveByPK($this->getRequestParameter('id'));

      if (null === $template)
      {
         return sfView::NONE;
      }

      $loremipsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut mattis felis justo, id consectetur lectus auctor eget. Aliquam aliquam magna vel tempor tristique. Morbi vel feugiat sem. Nunc lacus lorem, semper in molestie id, venenatis at felis. Etiam in posuere ex. Suspendisse vitae eros rutrum, interdum tellus bibendum, auctor ante. Integer ut sem efficitur, commodo neque ac, hendrerit dui. Sed rutrum orci quis lectus dapibus sagittis.";

      $preview = $template->render(array(
         '{TITLE}' => 'Zegarek Orange II',
         '{PRICE}' => 499, 
         '{DESC}' => $loremipsum,
         '{SHORT_DESC}' => $loremipsum,
         '{CODE}' => 'A404',
         '{PRODUCER}' => 'Lorem ipsum',
         '{MAN_CODE}' => '978-1617951541',
         '{OLD_PRICE}' => 599, 
         '{ADDITIONAL_DESC}' => $loremipsum,
         '{ID_SELLER}' => 0,
      ));

      preg_match_all('/\{PHOTO:([0-9]+)\}/', $preview, $photos);

      sfLoader::loadHelpers(array('Helper', 'stProductImage'));

      $photo_assets = array(
         '/plugins/stAllegroPlugin/preview/img0.jpg',
         '/plugins/stAllegroPlugin/preview/img1.jpg',
         '/plugins/stAllegroPlugin/preview/img2.jpg',
      ); 

      foreach($photos[1] as $photo) 
      {
         if (isset($photo_assets[$photo-1]))
         {
            $preview = str_replace('{PHOTO:'.$photo.'}', image_tag(st_product_image_path($photo_assets[$photo-1], 'allegro', true, false, true)), $preview);
         }
         else
         {
            $preview = str_replace('{PHOTO:'.$photo.'}', '', $preview);
         }
      }

      $this->preview = preg_replace('/href="[^"]+"/i', 'href="#"', $preview);
   }

   protected function loadEditorConfiguration(ThemeConfig $theme_config)
   {
      $editor_config = new stThemeEditorConfig();

      $editor_config->load($theme_config);

      return $editor_config;
   }

   protected function updateThemeConfigFromRequest(ThemeConfig $theme_config, stThemeEditorConfig $editor_config)
   {
      $request = $this->getRequestParameter('theme_config');

      $theme = $theme_config->getTheme();

      foreach ($request as $category => $fields)
      {
         foreach ($fields as $name => $value)
         {
            $default = $editor_config->getGraphicFieldParameter($category, $name, 'default');

            if (strpos($default, 'rgb') !== false)
            {
                preg_match_all('/[0-9]+/', $default, $matches);
                $rgb = $matches[0];
                $default = ltrim(stThemeLess::rgbToHex(array(1 => $rgb[0], 2 => $rgb[1], 3 => $rgb[2])), '#');
                
            }

            if ($category == '_less')
            {
               if (is_array($value) && isset($value['default']))
               {
                  $theme_config->removeLess($name);
               }
               else
               {
                  $theme_config->setLess($name, $value);
               }
            }
            elseif ($editor_config->hasGraphicFieldType($category, $name, 'css'))
            {
               if (is_array($value) && isset($value['restore']))
               {
                  $theme_config->removeCssImage($category, $name);
               }
               elseif (is_array($value) && isset($value['default']))
               {
                  $theme_config->removeCss($category, $name);
               }
               elseif ($theme->getVersion() < 7 || trim($value, '#') != $default)
               {                
                  $theme_config->setCss($category, $name, $value);
               }
               else
               {
                  $theme_config->removeCss($category, $name); 
               }
            }
            elseif (is_array($value) && isset($value['restore']) && $editor_config->hasGraphicFieldType($category, $name, 'image'))
            {
               $theme_config->removeImage($category, $name);
            }
         }
      }
   }
   
   protected function saveAllegroTemplate($allegro_template)
   {
      $ret = parent::saveAllegroTemplate($allegro_template);
      
      if (null !== $allegro_template->getTheme())
      {         
         $this->saveThemeConfig($this->theme_config, $this->editor_config);


         $generator = new stThemeConfigGenerator($this->editor_config);
         $generator->generateGraphic();
      }

      if ($this->hasRequestParameter('preview_save'))
      {
         $this->setFlash('preview', true);
      }

      return $ret;
   }

   protected function updateAllegroTemplateFromRequest()
   {
      $ret = parent::updateAllegroTemplateFromRequest();

      if (null !== $this->allegro_template->getTheme())
      {         
         $this->updateThemeConfigFromRequest($this->theme_config, $this->editor_config);
      }

      return $ret;
   }

   protected function getLabels()
   {
      return isset($this->labels) ? $this->labels : parent::getLabels();
   }

   protected function saveThemeConfig(ThemeConfig $theme_config, stThemeEditorConfig $editor_config)
   {
      $files = $this->getRequest()->getFiles();

      if (isset($files['theme_config']))
      {
         foreach ($files['theme_config']['name'] as $category => $fields)
         {
            foreach ($fields as $name => $value)
            {
               if ($editor_config->hasGraphicFieldType($category, $name, 'css') && $editor_config->hasGraphicFieldProperty($category, $name, 'background-image'))
               {
                  $image = $this->uploadImage($theme_config, 'theme_config['.$category.']['.$name.']', $theme_config->getCss($category, $name));

                  if ($image)
                  {
                     $theme_config->setCss($category, $name, $image);
                  }
               }
               elseif ($editor_config->hasGraphicFieldType($category, $name, 'image'))
               {
                  $image = $this->uploadImage($theme_config, 'theme_config['.$category.']['.$name.']', $theme_config->getImage($category, $name));

                  if ($image)
                  {
                     $theme_config->setImage($category, $name, $image);
                  }
               }
            }
         }
      }

      $theme_config->save();
   }

   protected function uploadImage(ThemeConfig $theme_config, $field_name, $prev_image)
   {
      $image = null;

      if ($this->getRequest()->getFileError($field_name) == UPLOAD_ERR_OK)
      {
         $filename = $this->getRequest()->getFileName($field_name);

         $fileinfo = pathinfo($filename);

         $image = '_editor/preview/'.md5($filename.microtime(true)).'.'.$fileinfo['extension'];

         if ($prev_image && is_file($theme_config->getTheme()->getImageDir(true).'/'.$prev_image))
         {
            unlink($theme_config->getTheme()->getImageDir(true).'/'.$prev_image);
         }

         $this->getRequest()->moveFile($field_name, $theme_config->getTheme()->getImageDir(true).'/'.$image, 0664, true, 0775);
      }

      return $image;
   }
}
