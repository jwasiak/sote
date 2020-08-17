<?php

class stAssetImageConfigurationActions extends stActions
{

   public function executeImageCropper()
   {
      $asset_id = $this->getRequestParameter('asset_id');

      if (is_numeric($asset_id))
      {
         $this->asset = sfAssetPeer::retrieveByPK($asset_id);
      } 
      else 
      {
         $this->asset = new sfAsset();
         $folder = new sfAssetFolder();
         $folder->setRelativePath(dirname($asset_id));
         $this->asset->setsfAssetFolder($folder);
         $this->asset->setRawFilename(basename($asset_id));
         $this->asset->setType('image');
      }

      $this->namespace = $this->getRequestParameter('namespace');      

      $this->for = $this->getRequestParameter('for');  

      $this->config = stConfig::getInstance('stAsset');   

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->updateImageCropperFromRequest();

         if (!$this->asset->isNew())
         {
            $this->asset->save();

            $this->asset->destroy($this->for, false);
         }
         else
         {
            $this->asset->updateCropFile();
            $this->asset->destroy($this->for, false);
            SlideBannerPeer::clearCache();
         }

         return sfView::HEADER_ONLY;
      }

      $crop = $this->asset->getCrop();
      $image_params = $this->config->get($this->for);


      if (isset($crop['_crop']))
      {
         foreach ($crop['_crop'] as $type => $params)
         {   
            if (isset($image_params[$type]) && !sfAssetsLibraryTools::isValidCrop($params, $image_params[$type]['width'], $image_params[$type]['height']))
            {
               unset($crop[$type]);
            }
         }

         $this->asset->setCrop($crop);
      }

      
      $this->image_types = sfAssetsLibraryTools::getCropImageTypes($this->for);

        if (stSoteshop::checkInstallVersion('6.6.4') && $this->for == 'product'){
        unset($this->image_types['icon']);
        
        unset($this->image_types['thumb']);
        }

      $this->image_labels = $this->getLabels($this->for);

      $this->image_info = $this->asset->getImageInfo();
   }

   public function executeWatermark()
   {
      $i18n = $this->getContext()->getI18N();

      $config = stConfig::getInstance(null, 'stAsset');

      $this->menu_items = $this->getMenuItems();

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $config->set('watermark', $this->getRequestParameter('watermark'));

         $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));

         $config->save(true);
         $this->saveThemeConfig($config);

         return $this->redirect($this->getRequest()->getReferer());
      }

      $this->config = $config->get('watermark', array());
   }

   public function executeGeneral()
   {
      $i18n = $this->getContext()->getI18N();

      $config = stConfig::getInstance('stAsset');

      $this->menu_items = $this->getMenuItems();

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {         
         $general = $this->getRequestParameter('general');

         foreach (array('high_quality_images', 'respect_exif_orientation') as $checkbox)
         {
            $general[$checkbox] = isset($general[$checkbox]);
         }

         $config->set('general', $general);

         $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));

         $config->save(true);
         // $this->saveThemeConfig($config);

         stFastCacheManager::clearCache();

         return $this->redirect($this->getRequest()->getReferer());
      }

      $this->config = $config->get('general', array());

      if (!isset($this->config['adapter']))
      {
         $this->config['adapter'] = sfThumbnail::getDefaultAdapter();
      }
   }

   public function executeGallery()
   {
      $i18n = $this->getContext()->getI18N();

      $config = stConfig::getInstance(null, 'stAsset');

      $this->menu_items = $this->getMenuItems();

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $config->set('gallery', $this->getRequestParameter('gallery'));

         $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));

         $config->save(true);
         $this->saveThemeConfig($config);

         return $this->redirect($this->getRequest()->getReferer());
      }

      $this->config = $config->get('gallery', array());
   }

   public function executeProduct()
   {
      $i18n = $this->getContext()->getI18N();

      $config = stConfig::getInstance(null, 'stAsset');

      $this->menu_items = $this->getMenuItems();

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->updateConfigFromRequest($config, 'product');

         $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));

         $config->save(true);
         $this->saveThemeConfig($config);

         return $this->redirect($this->getRequest()->getReferer());
      }

      $this->config = $config->get('product', array());
   }

   public function executeCategory()
   {
      $i18n = $this->getContext()->getI18N();

      $config = stConfig::getInstance(null, 'stAsset');

      $this->menu_items = $this->getMenuItems();

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->updateConfigFromRequest($config, 'category');

         $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));

         $config->save(true);
         $this->saveThemeConfig($config);

         return $this->redirect($this->getRequest()->getReferer());
      }

      $this->config = $config->get('category', array());
   }

   public function executeSlide()
   {
      $i18n = $this->getContext()->getI18N();

      $config = stConfig::getInstance(null, 'stAsset');

      $this->menu_items = $this->getMenuItems();

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->updateConfigFromRequest($config, 'slide');
         $this->updateConfigFromRequest($config, 'slide_mobile');

         $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));

         $config->save(true);
         $this->saveThemeConfig($config);
         SlideBannerPeer::clearCache();

         return $this->redirect($this->getRequest()->getReferer());
      }

      $this->config = $config->get('slide', array());
      $this->config_mobile = $config->get('slide_mobile', array());
   }
   
   public function executeBlog()
   {
      $i18n = $this->getContext()->getI18N();

      $config = stConfig::getInstance(null, 'stAsset');

      $this->menu_items = $this->getMenuItems();

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->updateConfigFromRequest($config, 'blog');         

         $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));

         $config->save(true);
         $this->saveThemeConfig($config);
         SlideBannerPeer::clearCache();

         return $this->redirect($this->getRequest()->getReferer());
      }

      $this->config = $config->get('blog', array());      
   }

   public function executeProducer()
   {
      $i18n = $this->getContext()->getI18N();

      $config = stConfig::getInstance(null, 'stAsset');

      $this->menu_items = $this->getMenuItems();

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->updateConfigFromRequest($config, 'producer');

         $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));

         $config->save(true);
         $this->saveThemeConfig($config);
         
         return $this->redirect($this->getRequest()->getReferer());
      }

      $this->config = $config->get('producer', array());
   }

   public function validateWatermark()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->checkCredentials();
      }

      return true;
   }

   public function validateGallery()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->checkCredentials();
      }

      return true;
   }   

   public function validateCategory()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->checkCredentials();

         $validator1 = $this->getThumbnailValidator('szerokość');

         $validator2 = $this->getThumbnailValidator('wysokość');

         foreach ($this->getRequestParameter('category') as $thumbnail => $values)
         {
            if (!$validator1->execute($values['width'], $error))
            {
               $this->getRequest()->setError('category{'.$thumbnail.'}{width}', $error);
            }

            if (!$validator2->execute($values['height'], $error))
            {
               $this->getRequest()->setError('category{'.$thumbnail.'}{height}', $error);
            }
         }
      }

      return!$this->getRequest()->hasErrors();
   }

   public function handleErrorCategory()
   {
      $config = stConfig::getInstance(null, 'stAsset');

      $this->menu_items = $this->getMenuItems();

      $this->updateConfigFromRequest($config, 'category');

      $this->config = $config->get('category', array());

      return sfView::SUCCESS;
   }

   public function validateProduct()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->checkCredentials();

         $validator1 = $this->getThumbnailValidator('szerokość');

         $validator2 = $this->getThumbnailValidator('wysokość');

         foreach ($this->getRequestParameter('product') as $thumbnail => $values)
         {
            if (!$validator1->execute($values['width'], $error))
            {
               $this->getRequest()->setError('product{'.$thumbnail.'}{width}', $error);
            }

            if (!$validator2->execute($values['height'], $error))
            {
               $this->getRequest()->setError('product{'.$thumbnail.'}{height}', $error);
            }
         }
      }

      return!$this->getRequest()->hasErrors();
   }

   public function handleErrorProduct()
   {
      $config = stConfig::getInstance(null, 'stAsset');

      $this->menu_items = $this->getMenuItems();

      $this->updateConfigFromRequest($config, 'product');

      $this->config = $config->get('product', array());

      return sfView::SUCCESS;
   }

   public function validateProducer()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->checkCredentials();

         $validator1 = $this->getThumbnailValidator('szerokość');

         $validator2 = $this->getThumbnailValidator('wysokość');

         foreach ($this->getRequestParameter('producer') as $thumbnail => $values)
         {
            if (!$validator1->execute($values['width'], $error))
            {
               $this->getRequest()->setError('producer{'.$thumbnail.'}{width}', $error);
            }

            if (!$validator2->execute($values['height'], $error))
            {
               $this->getRequest()->setError('producer{'.$thumbnail.'}{height}', $error);
            }
         }
      }

      return!$this->getRequest()->hasErrors();
   }

   public function handleErrorProducer()
   {
      $config = stConfig::getInstance(null, 'stAsset');

      $this->menu_items = $this->getMenuItems();

      $this->updateConfigFromRequest($config, 'producer');

      $this->config = $config->get('producer', array());

      return sfView::SUCCESS;
   }

   public function handleErrorWatermark()
   {
      $config = stConfig::getInstance(null, 'stAsset');

      $this->menu_items = $this->getMenuItems();

      $config->set('watermark', $this->getRequestParameter('watermark'));

      $this->config = $config->get('watermark', array());

      return sfView::SUCCESS;
   }

   protected function updateConfigFromRequest($config, $for)
   {
      $thumbnails = $config->get($for, array());

      foreach ($this->getRequestParameter($for) as $thumbnail => $values)
      {
         $thumbnails[$thumbnail] = $values;

         $thumbnails[$thumbnail]['watermark'] = isset($values['watermark']);
         
         $thumbnails[$thumbnail]['auto_crop'] = isset($values['auto_crop']);
      }

      $config->set($for, $thumbnails);
   }

   public function executeRestoreDefaults()
   {
      $for = explode(",", $this->getRequestParameter('for'));
      
      $theme = ThemePeer::doSelectActive();

      foreach ($for as $current)
      {
         ThemePeer::updateThemeImageConfiguration($theme, $current);
      }

      $i18n = $this->getContext()->getI18N();

      $this->setFlash('notice', $i18n->__('Domyślna konfiguracja została przywrócona', null, 'stAssetImageConfiguration'));

      return $this->redirect($this->getRequest()->getReferer());
   }

   

   protected function getMenuItems()
   {
      $i18n = $this->getContext()->getI18N();

      $menu_array =  array(
         '@stAssetImageConfiguration?action=watermark' => $i18n->__('Znak wodny'),
         '@stAssetImageConfiguration?action=product' => $i18n->__('Produkty'),
         '@stAssetImageConfiguration?action=category' => $i18n->__('Kategorie'),
         '@stAssetImageConfiguration?action=producer' => $i18n->__('Producent'),
         '@stAssetImageConfiguration?action=gallery' => $i18n->__('Galeria'),
         '@stAssetImageConfiguration?action=slide' => $i18n->__('Banery'),
         '@stAssetImageConfiguration?action=blog' => $i18n->__('Blog'),
         '@stAssetImageConfiguration?action=general' => $i18n->__('Konfiguracja ogólna'),
      );

      if (stTheme::hideOldConfiguration()) {
         unset($menu_array['@stAssetImageConfiguration?action=gallery']);
      }
      
      return $menu_array;
   }

   protected function getThumbnailValidator($label)
   {
      $validator = new sfNumberValidator();

      $i18n = $this->getContext()->getI18N();

      $validator->initialize($this->getContext(), array(
          'min' => 16,
          'min_error' => $i18n->__('Minimalna').' '.$i18n->__($label).' '.$i18n->__('to').' 16 px',
          'type' => 'integer',
          'type_error' => $i18n->__(ucfirst($label)).' '.$i18n->__('musi być liczbą całkowitą'),
          'nan_error' => $i18n->__(ucfirst($label)).' '.$i18n->__('musi być liczbą całkowitą'),
      ));

      return $validator;
   }

   protected function checkCredentials()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
   }

   protected function updateImageCropperFromRequest() 
   {
      $data = $this->getRequestParameter($this->namespace);

      $crop = $this->asset->getCrop() ? $this->asset->getCrop() : array();

      $crop['_crop'] = array();

      $params = $this->config->get($this->for);

      foreach ($data['select'] as $type => $select)
      {
         $crop[$type] = json_decode($select);

         $crop['_crop'][$type] = array(
            'width' => $params[$type]['width'],
            'height' => $params[$type]['height']
         );
      }

      $this->asset->setCrop($crop);
   }

   protected function getLabels($for)
   {
      $labels = array(
         'product' => array(
            'small'     => 'Lista pełna',
            'icon'      => 'Lista skrócona',
            'thumb'     => 'Lista alternatywna',
            'gallery'   => 'Galeria',
            'large'     => 'Karta',
            'big'       => 'Powiększone',
            'allegro'   => 'Allegro'          
         ),
         'category' => array(
            'thumb' => 'Strona główna',
            'small' => 'Strona kategorii'
         ),
         'producer' => array(
            'large' => 'Strona producenta',
            'thumb' => 'Logo'
         ),
         'slide' => array(
            'thumb' => '',
         ),
         'slide_mobile' => array(
            'thumb' => '',
         ),
          'blog' => array(
            'thumb' => '',
         ),
      );

      return $labels[$for];
   }

   protected function saveThemeConfig(stConfig $config)
   {
      $theme = ThemePeer::doSelectActive();

      $thumbs = array();

      foreach ($config->getArray() as $name => $values)
      {
         if ($name != 'general')
         {         
            $thumbs[$name] = $values;
         }
      }

      $theme->getThemeConfig()->setConfigParameter('thumbs', $thumbs);
      $theme->save();
   }
}
