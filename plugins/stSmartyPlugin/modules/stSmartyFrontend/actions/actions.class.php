<?php
/**
 * SOTESHOP/stSmartyPlugin
 *
 * Ten plik należy do aplikacji stInvoicePlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stSmartyPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 665 2009-04-16 07:43:27Z michal $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Klasa ststSmartyFrontendActions.
 *
 * @package     stSmartyPlugin
 * @subpackage  actions
 */
class stSmartyFrontendActions extends stActions 
{
   public function preExecute()
   {
      parent::preExecute();

      $this->forward404Unless(SF_ENVIRONMENT == 'theme' && $this->getUser()->isAuthenticated() && $this->getUser()->hasCredential('stThemeBackend.modification'));

      $culture = $this->getUser()->getAttribute('culture', stLanguage::getOptLanguage(), 'stThemePlugin');

      $this->getContext()->getI18N()->setCulture($culture);
   }

   public function executeLogin()
   {
      return $this->redirect('@homepage');
   }

   public function validateLogin()
   {
      $request = $this->getRequest();

      if ($request->getMethod() == sfRequest::POST)
      {
         $theme_login = $request->getParameter('theme_login');

         $user = sfGuardUserPeer::retrieveByUsername($theme_login['login']);

         if (null === $user || !$user->checkPassword($theme_login['password']))
         {
            $request->setError('theme_login', 'Proszę podać poprawny login i hasło');
         }
         elseif (!$user->hasModulePermission('stThemeBackend.modification') && !$user->getIsSuperAdmin())
         {
            $request->setError('theme_login', 'Nie posiadasz wystarczających uprawnień');
         }
         else
         {
            $this->getUser()->signIn($user);
         }
      }

      return !$request->hasErrors();
   }

   public function handleErrorLogin()
   {
      return $this->forward('stFrontendMain', 'index');
   }

	public function executeRestoreSlots()
   {
      $theme = stTheme::getInstance($this->getContext())->getTheme();

      foreach ($theme->getSmartySlots() as $slot)
      {
         $slot->delete();
      }

      stSmarty::clearCache($theme);

      $this->setFlash('theme_notice', $this->getContext()->getI18N()->__('Domyślny układ został przywrócony', null, 'stThemeFrontend'));

      return $this->redirect($this->getRequest()->getReferer());
   }

   public function executeUpdateSlots()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $slots = $this->getRequestParameter('slots');

         $theme = stTheme::getInstance($this->getContext())->getTheme();

         foreach ($slots as $name => $components)
         {
            $slot = SmartySlotPeer::retrieveByNameAndTheme($name, $theme);

            if (null === $slot)
            {
               $slot = new SmartySlot();

               $slot->setName($name);

               $slot->setThemeId($theme->getId());

               $slot->save();
            }
            else
            {
               $c = new Criteria();

               $c->add(SmartySlotContentPeer::SLOT_ID, $slot->getId());

               SmartySlotContentPeer::doDelete($c);
            }

            if ($components)
            {
                foreach ($components as $id => $content)
                {
                   $content = json_decode($content, true);

                   $slot_content = new SmartySlotContent();

                   $slot_content->setSlotId($slot->getId());

                   $slot_content->setId($id);

                   $slot_content->setContent($content);

                   $slot_content->save();
                }
            }
         }

         stSmarty::clearCache($theme);
      }

      return sfView::HEADER_ONLY;
   }

   public function executeContentBlockRestore()
   {
      $request = $this->getRequest();

      if ($request->getMethod() == sfRequest::POST)
      {      
         $data = json_decode($this->getRequestParameter('data'), true);

         $block = SmartyContentBlockPeer::retrieveByName($data['name'], $this->getUser()->getCulture());

         if ($block)
         {
            $block->delete();
         }

         if ($this->getUser()->getCulture() != stLanguage::getOptLanguage())
         {
            $block = SmartyContentBlockPeer::retrieveByName($data['name'], stLanguage::getOptLanguage());

            if (null !== $block)
            {
               $data = array_merge($data, $block->getContent());
            }
         }

         return $this->renderJson($data);
      }
      else
      {
         return sfView::HEADER_ONLY;
      }
   }   

   public function executeContentBlockEdit()
   {
      $data = json_decode($this->getRequestParameter('data'), true);

      $this->block = $this->getContentBlockOrCreate($data);

      $this->data = $data;

      $request = $this->getRequest();

      if ($request->getMethod() == sfRequest::POST && $request->hasParameter('save'))
      {
         $this->updateContentBlockFromRequest($data);

         $json = $this->block->getContent();

         $json['decorator'] = $data['decorator'];

         $ret = $this->renderJson($json);

         $this->getResponse()->setContentType('text/plain');

         return $ret;
      }
   }

   protected function getContentBlockOrCreate($data)
   {
      $culture = $this->getUser()->getCulture();

      $block = SmartyContentBlockPeer::retrieveByName($data['name'], $culture);

      if (null === $block && $culture != stLanguage::getOptLanguage())
      {
         $block = SmartyContentBlockPeer::retrieveByName($data['name'], stLanguage::getOptLanguage());

         if (null !== $block)
         {
            $block = $block->copy();

            $block->setName($data['name']);

            $block->setOptCulture($culture);
         }
      }
      
      if (null === $block)
      {
         $block = new SmartyContentBlock();

         $block->setName($data['name']);

         $block->setOptCulture($culture);

         if ($data['decorator'] == 'box')
         {
            $block->setContent(array('title' => $data['title'], 'content' => $data['content']));
         }
         else
         {
            $block->setContent(array('content' => $data['content']));
         }
      }

      return $block;
   }

   protected function updateContentBlockFromRequest($data)
   {
      $content_block = $this->getRequestParameter('content_block');

      $content = $this->block->getContent();

      if ($data['decorator'] == 'box')
      {
         $this->block->setContentByName('title', $content_block['title']);
      }  

      if ($data['content_type'] == 'image')
      {
         $this->updateImageContent($this->block);
      }  
      else
      {  
         $this->block->setContentByName('content', $content_block['content']);
      }

      $this->block->save();
   }

   protected function updateImageContent(SmartyContentBlock $block)
   {
      $request = $this->getRequest();

      $upload_dir = $block->getUploadDir();

      $web_dir = sfConfig::get('sf_web_dir');

      if (!is_dir($web_dir.'/'.$upload_dir))
      {
         mkdir($web_dir.'/'.$upload_dir, 0755, true);
      }

      $content = $block->getContentByName('content');

      $images = $block->getImagesContent();

      foreach ($request->getFileValues('content_block[image]') as $name => $value) 
      {
         if ($value['error'] == 0 && $value['name'])
         {
            $ext = pathinfo($value['name'], PATHINFO_EXTENSION);

            $image = $upload_dir.'/'.$name.'.'.$ext;

            if ($request->moveFile('content_block[image]['.$name.']', $web_dir.'/'.$image))
            {
               $lm = filemtime($web_dir.'/'.$image);

               $replacement = str_replace($images[$name]['path'], '/'.$image.'?v'.$lm, $images[$name]['html']);

               $content = str_replace($images[$name]['html'], $replacement, $content);
            }  
         }
      }

      $block->setContentByName('content', $content);
   }
}
