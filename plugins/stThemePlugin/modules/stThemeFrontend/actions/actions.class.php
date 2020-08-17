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
 * @version     $Id: actions.class.php 1206 2009-05-14 09:10:23Z bartek $
 */

/**
 * Klasa stThemeFrontendActions
 *
 * @package     stThemePlugin
 * @subpackage  actions
 */
class stThemeFrontendActions extends stActions
{
   public function preExecute()
   {
      parent::preExecute();

      $this->getContext()->getI18N()->setCulture(stLanguage::getOptLanguage());
   }
   
   public function executeEditorMessage()
   {
      if ($this->hasRequestParameter('apply'))
      {
         $this->setFlash('notice', $this->getContext()->getI18N()->__('Twoje zmiany zostały zastosowane do aktualnego tematu')); 
      }
      elseif ($this->hasRequestParameter('default'))
      {
         $this->setFlash('notice', $this->getContext()->getI18N()->__('Temat został ustawiony jako domyślny'));
      }
      
      $redirect = $this->getRequestParameter('redirect');
      
      return $this->redirect($redirect);
   }

   public function executeSetDefaultTheme()
   {
      $this->forward404Unless(SF_ENVIRONMENT == 'theme');

      $pk = $this->getRequestParameter('id');

      $theme = ThemePeer::retrieveByPK($pk);

      $theme->setActive(true);

      $theme->save();

      $this->setFlash('theme_notice', $this->getContext()->getI18N()->__('Temat został ustawiony jako domyślny'));

      return $this->redirect($this->getRequest()->getReferer());
   }

    /**
     * Odczyt widoku użytkownika.
     */
    public function executeLoadView()
    {
        $ThemeName = stTheme::getInstance($this->getContext())->getThemeName();
        $c = new Criteria();
        $c->add(ThemePeer::THEME,  $ThemeName);
        $theme = ThemePeer::doSelectOne($c);

        sfConfig::set("sf_web_debug", false);

        $c = new Criteria();
        $c->add(ThemeLayoutPeer::THEME_ID, $theme->getId());
        $userView = ThemeLayoutPeer::doSelect($c);

        $settings="";
         
        foreach ($userView as $view)
        {
            $settings .= "\"".$view->getContainer()."\": ";

            $blocks = explode(",",$view->getBlocks());

            $settings .= "[";
            foreach ($blocks as $block)
            {
                $settings .= "\"".$block."\",";
            }
            $settings = substr($settings, 0, -1);
            
            $settings .= "], ";

        }
        
        $settings = substr($settings, 0, -2);
                
        return $this->RenderText('var settings = {'.$settings.'};');
    }

    /**
     * Zapis zmian widoku użytkownika.
     */
    public function executeSaveView()
    {
        if (SF_ENVIRONMENT == 'edit')
        {
            $ThemeName = stTheme::getInstance($this->getContext())->getThemeName();
            $c = new Criteria();
            $c->add(ThemePeer::THEME,  $ThemeName);
            $theme = ThemePeer::doSelectOne($c);
            
            $query=explode(':',$this->getRequestParameter('value'));
            $container = $query[0];
            $block = $query[1];

            $c = new Criteria();
            $c->add(ThemeLayoutPeer::CONTAINER, $container);
            $c->add(ThemeLayoutPeer::THEME_ID, $theme->getId());
            ThemeLayoutPeer::doDelete($c);

            $userView = new ThemeLayout();
            $userView->setThemeId($theme->getId());
            $userView->setContainer($container);
            $userView->setBlocks($block);
            $userView->save();
        }

        return true;
    }

    public function executeLoadConfig()
    {
        if (SF_ENVIRONMENT == 'edit')
        {
            $options="
                portal: 'portal',
                column: 'portal-column',
                block: 'block',
                content: 'content',
                handle: 'handle',
                hoverclass: 'block-hover',
                toggle: 'block-toggle',
                blocklist: 'portal-column-block-list',
                blocklistlink: 'portal-block-list-link',
                blocklisthandle: 'block-list-handle',
                saveurl: '/frontend_edit.php/stThemeFrontend/SaveView'
               ";
        }
        else
        {
            $options="
                portal: 'portal',
                column: 'portal-column',
                block: 'block',
                content: 'content',
                handle: 'handle',
                hoverclass: 'block-hover',
                toggle: 'block-toggle',
                blocklist: 'portal-column-block-list',
                blocklistlink: 'portal-block-list-link',
                blocklisthandle: 'block-list-handle',
                saveurl: ''
               ";
        }

        return $this->RenderText('var options = {'.$options.'};');

    }

    /**
     * Zapis zmian widoku użytkownika.
     */
    public function executeChangeImage()
    {
        sfConfig::set('sf_st_theme_clipboard', false);
        
        $ThemeName = stTheme::getInstance($this->getContext())->getThemeName();      

        $c = new Criteria();
        $c->add(ThemePeer::THEME,  $ThemeName);
        $theme = ThemePeer::doSelectOne($c);
          
        if($this->getRequestParameter('download')==1)
        {
            $element = $this->getRequestParameter('element');
        }
        else
        {
            $element = explode(",",$this->getRequestParameter('element'));
                    
                
            //spacja jest celowa
            if($element[1]=="#baner ")
            {
                
                               
                $c = new Criteria();
                $c->add(ThemeCssPeer::THEME_ID,  $theme->getId());
                $c->add(ThemeCssPeer::CSS_HEAD_ID,  "baner_swf");
                $baner = ThemeCssPeer::doSelectOne($c);      
                                
                if($baner)
                {
                    $this->baner = $baner;
                    
                    $banerElement = explode(",",$baner->getCssContent());
                    
                    $this->banerPath = $banerElement[0];
                    
                }
                
            }
        }
        
        $c = new Criteria();
        $c->add(ThemeCssPeer::THEME_ID,  $theme->getId());
        $c->add(ThemeCssPeer::CSS_HEAD_ID,  $element[1]);
        $themeCss = ThemeCssPeer::doSelectOne($c);       

        if($themeCss)
        {
            $this->resetElement = 1;
        }
        else 
        {
            $this->resetElement = 0;
        }

        $this->element = $element;

        $imgPropertis = getimagesize(sfConfig::get('sf_web_dir').$element[3]);
        $this->imgPropertis = $imgPropertis;
         
        if($this->getRequestParameter('download')==1)
        {
            $response = $this->getContext()->getResponse();
            $response->setContentType("application/octet-stream");
            $response->setHttpHeader('Content-type', 'image/jpeg');
            $response->setHttpHeader("Content-Disposition", 'attachment; filename="'.$element[4].'"');
            return $this->renderText(file_get_contents(sfConfig::get('sf_web_dir').$element[3]));
        }
    }

    public function executeUploadFile()
    {
        $ThemeName = stTheme::getInstance($this->getContext())->getThemeName();

        // obluga wyslanego formualrza
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            
            if(preg_match('/[ąężźłóćśń\s]/i', $this->getRequest()->getFileName('filename')))
            {
                                
                $this->redirect('stThemeFrontend/printError');
            }              
                        
            if($this->getRequest()->getFileName('filename'))
            {
                $filename = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."frontend".DIRECTORY_SEPARATOR."theme".DIRECTORY_SEPARATOR.$ThemeName.DIRECTORY_SEPARATOR.$this->getRequest()->getFileName('filename');
                $this->getRequest()->moveFile('filename',$filename);
            }
            
            $name = explode(".",$this->getRequest()->getFileName('filename'));
            
            if($name[1]=="swf")
            {
                $this->forward('stThemeFrontend/', 'modSwf');
            }
        }

        $this->forward('stThemeFrontend/', 'modCss');
    }
    
    public function executePrintError()
    {
        sfConfig::set('sf_st_theme_clipboard', false);
    }

    public function executeModCss()
    {
        sfConfig::set('sf_st_theme_clipboard', false);
         
        $ThemeName = stTheme::getInstance($this->getContext())->getThemeName();

        $c = new Criteria();
        $c->add(ThemePeer::THEME,  $ThemeName);
        $theme = ThemePeer::doSelectOne($c);
         
        $element = $this->getRequestParameter('element');
        $fileName = $this->getRequest()->getFileName('filename');

        if($fileName=="")
        {
            $fileName = $this->getRequestParameter('filename');
        }

        if($element[2]=="")
        {
            $c = new Criteria();
            $c->add(ThemeCssPeer::THEME_ID, $theme->getId());
            $c->add(ThemeCssPeer::CSS_HEAD_ID, $element[1]);
            $css = ThemeCssPeer::doSelectOne($c);
            $cssContent = $css->getCssContent();
        }
        else
        {
            $cssContent="background:url(/images/frontend/theme/".$ThemeName."/".$fileName.");";
        }

        $imgPropertis = getimagesize(sfConfig::get('sf_web_dir')."/images/frontend/theme/".$ThemeName."/".$fileName);
        $this->imgPropertis = $imgPropertis;
        $cssExtendContent=$cssContent;

        $this->cssContent = $cssContent;
        $this->cssExtendContent = $cssExtendContent;
        $this->imgPath = "/images/frontend/theme/".$ThemeName."/".$fileName;
        $this->fileName = $fileName;
        $this->element = $element;
    }


    public function executeSaveCss()
    {
        $ThemeName = stTheme::getInstance($this->getContext())->getThemeName();

        $element = $this->getRequestParameter('element');
        //$fileName = $this->getRequest()->getFileName('filename');
        $cssContent = $this->getRequestParameter('cssContent');
        $cssExtendContent = $this->getRequestParameter('cssExtendContent');

        $modSize = $this->getRequestParameter('modSize');
        $imgPropertis = $this->getRequestParameter('imgPropertis');

        if($modSize==2){
            $cssContent .= "width:".$imgPropertis[0]."px; height:".$imgPropertis[1]."px;";
        }

        if(!$cssExtendContent)
        {
            $cssContent.= $cssExtendContent;
        }

        $c = new Criteria();
        $c->add(ThemePeer::THEME,  $ThemeName);
        $theme = ThemePeer::doSelectOne($c);

        $c = new Criteria();
        $c->add(ThemeCssPeer::THEME_ID, $theme->getId());
        $c->add(ThemeCssPeer::CSS_HEAD_ID, $element[1]);
        ThemeCssPeer::doDelete($c);

        $userCss = new ThemeCss();
        $userCss->setThemeId($theme->getId());
        $userCss->setCssHeadId($element[1]);
        $userCss->setCssContent($cssContent);
        $userCss->save();

    }
    
    public function executeSaveSwf()
    {
        $ThemeName = stTheme::getInstance($this->getContext())->getThemeName();

        $element = $this->getRequestParameter('element');
        $fileName = $this->getRequestParameter('filename');
        

        $sizeW = $this->getRequestParameter('sizeW');
        $sizeH = $this->getRequestParameter('sizeH');
        
        if($sizeW==""){$sizeW = 985;}
        
        if($sizeH==""){$sizeH = 200;}
        
        $cssContent = "/images/frontend/theme/".$ThemeName."/".$fileName.",".$sizeW.",".$sizeH;
        
        $c = new Criteria();
        $c->add(ThemePeer::THEME,  $ThemeName);
        $theme = ThemePeer::doSelectOne($c);

        $c = new Criteria();
        $c->add(ThemeCssPeer::THEME_ID, $theme->getId());
        $c->add(ThemeCssPeer::CSS_HEAD_ID, "baner_swf");
        ThemeCssPeer::doDelete($c);
        
        $swf = new ThemeCss();
        $swf->setThemeId($theme->getId());
        $swf->setCssHeadId("baner_swf");
        $swf->setCssContent($cssContent);
        $swf->save();      
        
        $c = new Criteria();
        $c->add(ThemeCssPeer::THEME_ID, $theme->getId());
        $c->add(ThemeCssPeer::CSS_HEAD_ID, "#baner");
        ThemeCssPeer::doDelete($c);

        $cssContent = "background:none;width:".$sizeW."px;height:".$sizeH."px;";
        
        $userCss = new ThemeCss();
        $userCss->setThemeId($theme->getId());
        $userCss->setCssHeadId("#baner");
        $userCss->setCssContent($cssContent);
        $userCss->save();
        
        

    }

    public function executeSetDefault()
    {
        $ThemeName = stTheme::getInstance($this->getContext())->getThemeName();
        
        $c = new Criteria();
        $c->add(ThemePeer::THEME,  $ThemeName);
        $theme = ThemePeer::doSelectOne($c);
        
        $c = new Criteria();
        $c->add(ThemeCssPeer::THEME_ID, $theme->getId());
        $c->add(ThemeCssPeer::CSS_HEAD_ID, $this->getRequestParameter('element'));
        ThemeCssPeer::doDelete($c);
              
        if($this->getRequestParameter('baner'))
        {
            $c = new Criteria();
            $c->add(ThemeCssPeer::THEME_ID, $theme->getId());
            $c->add(ThemeCssPeer::CSS_HEAD_ID, "baner_swf");
            ThemeCssPeer::doDelete($c);
        }

        stTheme::clearCache();
    }
    
    public function executeResetAllChanges()
    {   
        $ThemeName = stTheme::getInstance($this->getContext())->getThemeName();      
                
        $c = new Criteria();
        $c->add(ThemePeer::THEME,  $ThemeName);
        $theme = ThemePeer::doSelectOne($c);

        $c = new Criteria();
        $c->add(ThemeCssPeer::THEME_ID, $theme->getId());
        $css = ThemeCssPeer::doDelete($c);
        
        $c = new Criteria();
        $c->add(ThemeLayoutPeer::THEME_ID, $theme->getId());
        $css = ThemeLayoutPeer::doDelete($c);

        stTheme::clearCache();

        $this->redirect('/');
         
    }

    public function executeExtendCss()
    {
        sfConfig::set("sf_web_debug", false);

        $this->getResponse()->setHttpHeader('Content-type', 'text/css');

        $theme = $this->getRequestParameter('theme');

        $c = new Criteria();

        $c->addJoin(ThemeCssPeer::THEME_ID, ThemePeer::ID);

        $c->add(ThemePeer::THEME, $theme);

        $styles = ThemeCssPeer::doSelect($c);

        $css_content = '';

        foreach ($styles as $style)
        {
            $css_content .= $style->getCssHeadId() . " { " . $style->getCssContent() . "; }\n";
        }
        
        return $this->renderText($css_content);
    }
    
    public function executeModSwf()
    {
        sfConfig::set('sf_st_theme_clipboard', false);
        $element = $this->getRequestParameter('element');
        $fileName = $this->getRequest()->getFileName('filename');
         
        $this->theme = stTheme::getInstance($this->getContext())->getThemeName();  
        
        $this->element = $element;
        
        $this->fileName = $fileName;        
    }
    
    /**
     * Ukrycie bloku w schowku
     */
    public function executeHiddenBlock()
    {
    
    if (SF_ENVIRONMENT == 'edit')
    {
        $block_id = $this->getRequestParameter('block_id');
       
        $ThemeName = stTheme::getInstance($this->getContext())->getThemeName();
        $c = new Criteria();
        $c->add(ThemePeer::THEME,  $ThemeName);
        $theme = ThemePeer::doSelectOne($c);
        
     
        $c = new Criteria();
        $c->add(ThemeLayoutPeer::THEME_ID, $theme->getId());
        $themeLayouts = ThemeLayoutPeer::doSelect($c);
    
        
        foreach ($themeLayouts as $themeLayout)
        {
            $newThemeLayout = str_replace($block_id, "", $themeLayout->getBlocks());
            $themeLayout->setBlocks($newThemeLayout);
            $themeLayout->save();
        }
        
        $c = new Criteria();
        $c->add(ThemeLayoutPeer::CONTAINER , 'magazine1');
        $c->add(ThemeLayoutPeer::THEME_ID, $theme->getId());
        $containerMagazine = ThemeLayoutPeer::doSelectOne($c);
        
        if(!$containerMagazine)
        {
            $containerMagazine =  new ThemeLayout();
            
            $containerMagazine->setThemeId($theme->getId());
            $containerMagazine->setContainer('magazine1');
            $containerMagazine->setBlocks($block_id);
            
            $containerMagazine->save();
        }
        else 
        {
            $containerMagazine->setBlocks($block_id.",".$containerMagazine->getBlocks());
            $containerMagazine->save();
        }
        
    }  
       return true;
    }
    
    /**
     * Ukrycie bloku w schowku
     */
    public function executeVisibleBlock()
    {                
        if (SF_ENVIRONMENT == 'edit')
        {
            $block_id = $this->getRequestParameter('block_id');
           
            $ThemeName = stTheme::getInstance($this->getContext())->getThemeName();
            $c = new Criteria();
            $c->add(ThemePeer::THEME,  $ThemeName);
            $theme = ThemePeer::doSelectOne($c);
                   
            $c = new Criteria();
            $c->add(ThemeLayoutPeer::CONTAINER , 'magazine1');
            $c->add(ThemeLayoutPeer::THEME_ID, $theme->getId());
            $containerMagazine = ThemeLayoutPeer::doSelectOne($c);
            
            if($containerMagazine)
            {
                $updateContainerMagazine = str_replace($block_id, "", $containerMagazine->getBlocks());
                $containerMagazine->setBlocks($updateContainerMagazine);            
                $containerMagazine->save();       
            }
        }  
        return true;
    }
    
    /**
     * Ukrycie bloku w schowku
     */
    public function executeChangeActiveColor()
    {                
        if (SF_ENVIRONMENT == 'edit' && $this->getRequest()->getMethod() == sfRequest::POST)
        {
                       
            $context = sfContext::getInstance();
            
            $controller = $context->getController();
            
            $ThemeName = stTheme::getInstance($this->getContext())->getThemeName();
            
            $this->ThemeName = $ThemeName;
               
            $c = new Criteria();
            $c->add(ThemePeer::THEME,  $ThemeName);
            $theme = ThemePeer::doSelectOne($c);
        
            $theme_color_id = $this->getRequestParameter('theme_color');
                   
            $c = new Criteria();
            $c->add(ThemeColorSchemePeer::THEME_ID,  $theme->getId());
                      
            if (!$theme_color_id)
            {
                $c->add(ThemeColorSchemePeer::IS_DEFAULT, true);
            }
            else
            {
                $c->add(ThemeColorSchemePeer::ID,  $theme_color_id);
            }
           
            $theme_color = ThemeColorSchemePeer::doSelectOne($c);
            
            if ($theme_color)
            {
                $theme_color->setIsDefault((bool)$theme_color_id);                    
                $theme_color->save();
            }
                
        }
        
        $this->redirect('/');
        
    }
}