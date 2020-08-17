<?php

/**
 * SOTESHOP/stThemePlugin
 *
 * Ten plik należy do aplikacji stThemePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stThemePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 256 2009-03-30 11:49:45Z marek $
 */

/**
 * Klasa stThemeBackendActions
 *
 * @package     stThemePlugin
 * @subpackage  actions
 */
class stThemeBackendActions extends autoStThemeBackendActions
{

   protected $editorConfiguration = null;

   public function executeGraphicSave()
   {
      $this->forward('stThemeBackend', 'graphicEdit');
   }

   public function executeLayoutSave()
   {
      $this->forward('stThemeBackend', 'layoutEdit');
   }

   public function executeConfig()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         if ($this->getRequestParameter("config[responsive]") && !stCommunication::getIsSeven())
         {
            return $this->redirect('@homepage');
         }

         stFastCacheManager::clearCache();
      }
      
      return parent::executeConfig();
   }

   public function validateEdit()
   {
      $ok = true;

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $name = $this->getRequestParameter('theme[theme]');

         $ignore_themes = array('default', 'homeelectronics');

         if (in_array($name, $ignore_themes))
         {
            $this->getRequest()->setError('theme{theme}', 'Temat nie jest kompatybilny z aktualna wersja oprogramowania');

            $ok = false;
         }
      }

      return $ok;
   }

   public function executeList()
   {
      parent::executeList();

      $path = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'soteshop.yml';

      $config = sfYaml::load($path);

      $this->developerTheme = $config['all']['.view']['theme'];
   }

   public function executeSetDefault()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName(), false);

      $pk = $this->getRequestParameter('id');

      $theme = ThemePeer::retrieveByPK($pk);

      $theme->setActive(true);

      $theme->save();

      $redirect = urlencode($this->getRequest()->getReferer());
          
      return $this->redirect('http://'.$this->getRequest()->getHost().'/frontend_theme.php/stThemeFrontend/editorMessage?redirect='.$redirect.'&default');
   }

   protected function applyChanges()
   {
      $this->theme_config = $this->getThemeConfigOrCreate();

      $this->editor_config = $this->loadEditorConfiguration($this->theme_config);

      $generator = new stThemeConfigGenerator($this->editor_config);

      if ($this->theme_config->getTheme()->getVersion() < 7)
      {
         $generator->generateLess();
      }

      $generator->generateGraphic();
      
      stTheme::clearCache(true);
      
      stTheme::clearAssetsCache();    
   }


   public function executeApplyChanges()
   {
      if ($this->hasRequestParameter('save'))
      {
         if ($this->getRequestParameter('save') == 'redirect') 
         {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName(), false);
         }
         else
         {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
         }

         $this->applyChanges();
         
         if ($this->getRequestParameter('save') == 'redirect')
         {
            $redirect = urlencode($this->getRequest()->getReferer());
          
            return $this->redirect('http://'.$this->getRequest()->getHost().'/frontend_theme.php/stThemeFrontend/editorMessage?redirect='.$redirect.'&apply');
         }
         else
         {
            $this->setFlash('notice', $this->getContext()->getI18N()->__('Twoje zmiany zostały zastosowane do aktualnego tematu'));         
            
            return $this->redirect('stThemeBackend/applyChanges?id='.$this->theme_config->getId());
         }
      }
   }


   public function validateColorEdit()
   {
      $ok = true;

      $this->theme_config = $this->getThemeConfigOrCreate();

      $this->editor_config = $this->loadEditorConfiguration($this->theme_config);

      return $ok;
   }

   public function validateGraphicEdit()
   {
      $ok = true;

      $this->theme_config = $this->getThemeConfigOrCreate();

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

                     $this->labels['theme_config{'.$category.'}{'.$name.'}'] = $this->editor_config->getGraphicCategoryLabel($category).' -> '.$this->editor_config->getGraphicFieldParameter($category, $name, 'label');
                  }
               }
            }
         }
      }

      return $ok;
   }

   public function handleErrorGraphicEdit()
   {
      $this->updateThemeConfigFromRequest($this->theme_config, $this->editor_config);

      return sfView::SUCCESS;
   }

   public function executeRestore()
   {
      $pk = $this->getRequestParameter('id');

      $theme_config = ThemeConfigPeer::retrieveByPK($pk);
      
      if ($this->getRequestParameter('type') == 'graphic')
      {
         $theme_config->restoreCss();

         $theme_config->restoreImages();
      }
      else
      {
         $theme_config->restoreLess();
      }

      $theme_config->save();

      $this->setFlash('notice', $this->getContext()->getI18N()->__('Domyślne ustawienia zostały przywrócone. Aby Twoje zmiany były widoczne po stronie sklepu kliknij "Zapisz i zastosuj"'));

      stTheme::clearCache(false);

      return $this->redirect($this->getRequest()->getReferer());
   }

   public function executeColorEdit()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

         $this->updateThemeConfigFromRequest($this->theme_config, $this->editor_config);

         $this->saveThemeConfig($this->theme_config, $this->editor_config);

         $generator = new stThemeConfigGenerator($this->editor_config);

         if (!$this->hasRequestParameter('save_and_apply'))
         {
            $generator->generateLess(true);

            stTheme::clearCache(false);
         }
         else
         {
            $generator->generateLess();

            $generator->generateGraphic();
            
            stTheme::clearCache(true);
            
            stTheme::clearAssetsCache();
         }

         if ($this->hasRequestParameter('preview_save'))
         {
            return $this->redirectToPreview($this->theme_config);
         }
         else
         {
            $i18n = $this->getContext()->getI18N();

            if ($this->hasRequestParameter('save_and_apply'))
            {
                $msg = $i18n->__('Twoje zmiany zostały zapisane', array(), 'stAdminGeneratorPlugin');
            }
            else
            {
                $msg = $i18n->__('Twoje zmiany zostały zapisane, aby były widoczne po stronie sklepu kliknij "Zapisz i zastosuj"');
            }
            
            $this->setFlash('notice', $msg);

            return $this->redirect('stThemeBackend/colorEdit?id='.$this->theme_config->getId());
         }
      }
   }

   public function executeLayoutEdit()
   {
      $this->theme_config = $this->getThemeConfigOrCreate();
      $this->config = new stThemeConfig();
      $this->config->load($this->theme_config);

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $layout_config_request = $this->getRequestParameter('layout_config');

         $layouts = array();
         $actions = array();

         $layout_config = $this->config->get('layout_config');

         foreach ($this->config->getCategories('layout_config') as $category)
         {
            if (isset($layout_config_request[$category]))
            {
               $layouts[$category] = $layout_config_request[$category];

               foreach ($layout_config[$category]['actions'] as $action)
               {
                  $actions[$action] = $layout_config_request[$category];
               }
            }
         }

         $this->theme_config->setConfigParameter('layouts', array(
            'config' => $layouts,
            'actions' => $actions,
         ));

         $this->theme_config->save();

         stTheme::clearCache();

         $i18n = $this->getContext()->getI18N();
   
         $msg = $i18n->__('Twoje zmiany zostały zapisane', array(), 'stAdminGeneratorPlugin');

         $this->setFlash('notice', $msg);

         return $this->redirect('stThemeBackend/layoutEdit?id='.$this->theme_config->getId());
      }
   }

   public function executeGraphicEdit()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

         $this->updateThemeConfigFromRequest($this->theme_config, $this->editor_config);

         $this->saveThemeConfig($this->theme_config, $this->editor_config);

         $generator = new stThemeConfigGenerator($this->editor_config);

         if (!$this->hasRequestParameter('save_and_apply'))
         {
            $generator->generateGraphic(true);

            stTheme::clearCache(false);
         }
         else
         {
            if ($this->theme_config->getTheme()->getVersion() < 7)
            {
               $generator->generateLess();
            }

            $generator->generateGraphic();
            
            stTheme::clearCache(true);
            
            stTheme::clearAssetsCache();
         }         

         if ($this->hasRequestParameter('preview_save'))
         {
            return $this->redirectToPreview($this->theme_config);
         }
         else
         {
            $i18n = $this->getContext()->getI18N();

            if ($this->hasRequestParameter('save_and_apply'))
            {
                $msg = $i18n->__('Twoje zmiany zostały zapisane', array(), 'stAdminGeneratorPlugin');
            }
            else
            {
                $msg = $i18n->__('Twoje zmiany zostały zapisane, aby były widoczne po stronie sklepu kliknij "Zapisz i zastosuj"');
            }
            
            $this->setFlash('notice', $msg);

            return $this->redirect('stThemeBackend/graphicEdit?id='.$this->theme_config->getId());
         }
      }
   }

   protected function redirectToPreview(ThemeConfig $theme_config)
   {
      $culture = $this->getUser()->getCulture();

      return $this->redirect('http://'.$this->getRequest()->getHost().'/frontend_theme.php?theme='.$theme_config->getTheme()->getName().'&theme_culture='.$culture);
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

   protected function getThemeConfigOrCreate()
   {
      $theme_id = $this->getRequestParameter('id');

      $theme_config = ThemeConfigPeer::retrieveByPk($theme_id);

      if (null === $theme_config)
      {
         $theme_config = new ThemeConfig();

         $theme_config->setId($theme_id);
      }

      return $theme_config;
   }

   public function saveTheme($current_theme)
   {
      $theme_name = preg_replace('/[^0-9a-z_\-]+/', '', strtolower($current_theme->getTheme()));

      $current_theme->setTheme($theme_name);

      $config = stConfig::getInstance('stThemeBackend');

      if ($current_theme->getIsResponsive() || $this->hasRequestParameter('theme[responsive]'))
      {
         $config->set('responsive', $this->hasRequestParameter('theme[responsive]') ? $current_theme->getId() : null);
         $config->save(true);
      }
      
      if ($this->getRequest()->getMethod() == sfRequest::POST && !$this->getRequestParameter('id') && $this->hasRequestParameter('theme[copy_theme]'))
      {
         $copy_theme = $this->getRequestParameter('theme[copy_theme]'); 
         $source = ThemePeer::retrieveByPK($copy_theme);
         $this->themeCopy($source, $current_theme);
      }       

      $active_modified = $current_theme->isColumnModified(ThemePeer::ACTIVE);

      parent::saveTheme($current_theme); 

      if ($active_modified && $current_theme->getActive())
      {
         ThemePeer::updateThemeImageConfiguration($current_theme);  
         SlideBannerPeer::clearCache();       
      }
   }

   public function handleErrorSave()
   {
      return $this->forward('stThemeBackend', 'edit');
   }

   public function executeDownloadTheme()
   {
      if ($this->getRequest()->hasParameter('id'))
      {
         $c = new Criteria();
         $c->add(ThemePeer::ID, $this->getRequest()->getParameter('id'));
         $theme = ThemePeer::doSelectOne($c);

         if (is_object($theme))
         {
            $td = new stThemeDownloader($theme->getName());
            $td->makePackage();

            $this->setLayout(false);
            $response = $this->getContext()->getResponse();
            $response->setContentType('application/octet-stream');
            $response->setHttpHeader('Content-Disposition', 'attachment; filename="'.$theme->getName().'.tgz"');

            $this->handle = fopen($td->getPackagePath(), 'r');
         }
      }
   }

   public function executeSaveConfig()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->config = stConfig::getInstance($this->getContext(), 'stThemeBackend');

         $this->config->setFromRequest('themeBackend');

         stFastCacheManager::clearCache();

         $this->config->save();

         $this->setFlash('notice', 'Twoje zmiany zostały zapisane');

         $this->redirect('theme/configCustom');
      }
   }

   public function executeEdit() 
   {
      if ($this->hasFlash('copy_theme'))
      {
         return $this->forward('stThemeBackend', 'copyTheme');
      } 

      return parent::executeEdit();    
   }  

   public function executeCopyTheme()
   {
      $this->theme = $this->getThemeOrCreate();
      $this->copy_theme = $this->getFlash('copy_theme');
      $this->theme_name = $this->getFlash('theme_name');
   }

   protected function addFiltersCriteria($c)
   {
      $c->add(ThemePeer::VERSION, 2, Criteria::GREATER_EQUAL);

      if (!stCommunication::getIsSeven())
      {
        $c->add(ThemePeer::VERSION, 7, Criteria::LESS_THAN);
      }
      
      $default2Config = stConfig::getInstance('stThemeDefault2');
      
      if (!$default2Config->get('show')) $c->add(ThemePeer::THEME, 'default2', Criteria::NOT_EQUAL);

      $c->add(ThemePeer::IS_HIDDEN, false);
   }

   protected function themeCopy(Theme $source, Theme $target)
   {
      $target->setVersion($source->getVersion());          
      $target->setBaseThemeId($source->getId());

      $css_dir = $target->getCssDir(true);

      if (!is_dir($css_dir))
      {
         mkdir($css_dir, 0755, true);
      }

      file_put_contents($css_dir.'/'.$target->getTheme().'.css', "/* Put your custom css styles here */");

      foreach ($source->getThemeContents() as $current)
      {
         $themeContent = new ThemeContent();
         $themeContent->fromArray($current->toArray());
         $themeContent->setId(null);

         foreach ($themeContent->getThemeContentI18ns() as $currentI18n)
         {
            $themeContentI18n = new ThemeContentI18n();
            $themeContentI18n->fromArray($currentI18n->toArray());
            $themeContent->addThemeContentI18n($themeContentI18n);
         }
         
         $themeContent->setTheme($target);
         $themeContent->save();
      }
        
      $baseThemeConfig = ThemeConfigPeer::retrieveByPk($source->getId());

      if(null !== $baseThemeConfig) 
      {
         stWebFileManager::getInstance()->copy($source->getEditorImageDir(true), $target->getEditorImageDir(true));         
         
         $theme_config = $target->getThemeConfig();
         $theme_config->setParameters($baseThemeConfig->getParameters());            
         $theme_config->save(); 

         $editor_config = new stThemeEditorConfig();
         $editor_config->load($theme_config);

         $generator = new stThemeConfigGenerator($editor_config);

         if ($theme_config->getTheme()->getVersion() < 7)
         {
            $generator->generateLess();
         }

         $generator->generateGraphic();

         stTheme::clearCache(true);

         stTheme::clearAssetsCache();                        
      }
   }

   protected function getContentThemeContentOrCreate($id = 'id')
   {
      parent::getContentThemeContentOrCreate($id);

      if ($this->theme_content->isNew())
      {
         $this->theme_content->setThemeId($this->forward_parameters['theme_id']);
      }

      if (SF_ENVIRONMENT == 'prod')
      {
         $this->getUser()->setParameter('hide', true, 'stThemeBackend/edit/fields/content_id');
         $this->getUser()->setParameter('hide', true, 'stThemeBackend/edit/fields/name');
      }

      return $this->theme_content;
   }

   protected function addContentFiltersCriteria($c)
   {
      $c->add(ThemeContentPeer::THEME_ID, $this->forward_parameters['theme_id']);
      return parent::addContentFiltersCriteria($c);
   }
}
