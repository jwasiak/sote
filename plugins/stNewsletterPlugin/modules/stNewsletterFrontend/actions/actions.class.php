<?php

/**
 * SOTESHOP/stNewsletterPlugin
 *
 * Ten plik należy do aplikacji stNewsletterPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stNewsletterPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 12239 2011-04-14 11:47:41Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Klasa stNewsletterFrontendActions.
 *
 * @package     stNewsletterPlugin
 * @subpackage  actions
 */
class stNewsletterFrontendActions extends stActions
{

   public function executeUnsubscribe()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         return $this->redirect('stNewsletterFrontend/unsubscribeConfirmation?email='.$this->getRequestParameter('newsletter[email]'));
      }
      
      $this->smarty = new stSmarty('stNewsletterFrontend');
      
      $this->unsubscribeUpdateFromRequest();
   }
   
   public function executeUnsubscribeConfirmation()
   {
      $this->smarty = new stSmarty('stNewsletterFrontend');

      $this->email = $this->getRequestParameter('email');
   }

   public function validateUnsubscribe()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $form = $this->getRequestParameter('newsletter');

         $validator = new stCaptchaGDValidator();

         $validator->initialize($this->getContext(), array('captcha_error' => 'Wprowadzono zły numer.'));

         if (!$validator->execute($form['captcha'], $error))
         {
            $this->getRequest()->setError('newsletter{captcha}', $error);
         }
         else
         {
            $user = NewsletterUserPeer::retrieveByEmail($form['email']);

            if (null === $user)
            {
               $this->getRequest()->setError('newsletter{email}', 'Podany adres e-mail nie istnieje');
            }
            else
            {
               sfLoader::loadHelpers(array('Helper', 'I18N'));
               
               $smarty = new stSmarty('stNewsletterFrontend');
               
               $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend');
               
               $smarty->assign('date', date("d-m-Y H:i"));

               $smarty->assign('user_head', stMailer::getHtmlMailDescription("header"));
                
               $smarty->assign('user_foot', stMailer::getHtmlMailDescription("footer"));
                
               $smarty->assign('bg_header_color', $mail_config->get('bg_header_color'));
                
               $smarty->assign('bg_footer_color', $mail_config->get('bg_footer_color'));
                
               $smarty->assign('bg_action_color', $mail_config->get('bg_action_color'));
                
               $smarty->assign('bg_action_link_color', $mail_config->get('bg_action_link_color'));
                
               $smarty->assign('link_color', $mail_config->get('link_color'));
                
               $smarty->assign('logo', $mail_config->get('logo')); 

               
               $smarty->assign('confirmation_url', $this->getController()->genUrl('@stNewsletterRemove?id=' . $user->getId() . '&hash_code=' . $user->getHash(), true));
               
               $smarty->assign('host', $this->getRequest()->getHost());
               
               $html = $smarty->fetch('newsletter_mail_unsubscribe_html.html');
               
               $plain = $smarty->fetch('newsletter_mail_unsubscribe_plain.html'); 
               
               stMailer::getInstance()->setTo($form['email'])->setSubject(__('Potwierdzenie rezygnacji z listy subskrypcji'))->setHtmlMessage($html)->setPlainMessage($plain)->send();
            }
         }
      }

      return !$this->getRequest()->hasErrors();
   }

   public function handleErrorUnsubscribe()
   {
      $this->smarty = new stSmarty('stNewsletterFrontend');
      
      $this->unsubscribeUpdateFromRequest();

      return sfView::SUCCESS;
   }

   protected function unsubscribeUpdateFromRequest()
   {
      $form = $this->getRequestParameter('newsletter', array());
      
      $form['errors']['captcha'] = $this->getRequest()->getError('newsletter{captcha}');
      
      $form['errors']['email'] = $this->getRequest()->getError('newsletter{email}');
      
      $this->form = $form;
   }
   public function executeIndex()
   {
      $this->smarty = new stSmarty($this->getModuleName());
      $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');
      
      $newsletter_config = stConfig::getInstance($this->getContext(), 'stNewsletterBackend');      
      
      if($newsletter_config->get('newsletter_enabled')==1){
            $this->redirect("/");    
      }

      $c = new Criteria();
      $c->add(NewsletterGroupPeer::IS_PUBLIC, 1);
      $newsletterGroup = NewsletterGroupPeer::doSelect($c);

      $this->newsletter_config = $newsletter_config;
      $this->newsletterGroup = $newsletterGroup;
   }

   public function executeAddToList()
   {
      $this->smarty = new stSmarty($this->getModuleName());
      
      $newsletter_config = stConfig::getInstance($this->getContext(), 'stNewsletterBackend');      
      
      $c = new Criteria();
      $c->add(sfGuardUserPeer::USERNAME, $this->getRequestParameter('newsletter[email]'));
      $user = sfGuardUserPeer::doSelectOne($c);

      if ($user)
      {
         $user_id = $user->getId();
      }
      else
      {
         $user_id = null;
      }
      
      $newsletterUser = new NewsletterUser();
      $newsletterUser->setEmail($this->getRequestParameter("newsletter[email]"));
      $newsletterUser->setUserId($user_id);
      $newsletterUser->setLanguage(sfContext::getInstance()->getUser()->getCulture());
      $newsletterUser->setActive(1);
      $newsletterUser->setConfirm(0);
      $newsletterUser->save();

      $newsletter_user_id = $newsletterUser->getId();

      $checkedGroup = $this->getRequestParameter('newsletter[group]');

      if ($checkedGroup)
      {
         foreach ($checkedGroup as $key => $value)
         {
            $c = new Criteria();
            $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $newsletter_user_id);
            $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, $key);
            NewsletterUserHasNewsletterGroupPeer::doInsert($c);
         }
      }

      $c = new Criteria();
      $c->add(NewsletterGroupPeer::IS_PUBLIC, 0);
      $c->add(NewsletterGroupPeer::IS_DEFAULT, 1);
      $defaultNewsletterGroup = NewsletterGroupPeer::doSelect($c);

      if ($defaultNewsletterGroup)
      {
         foreach ($defaultNewsletterGroup as $group)
         {
            $c = new Criteria();
            $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $newsletter_user_id);
            $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, $group->getId());
            NewsletterUserHasNewsletterGroupPeer::doInsert($c);
         }
      }

      $c = new Criteria();
      $c->addJoin(NewsletterGroupPeer::ID, NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID);
      $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $newsletterUser->getId());
      $c->add(NewsletterGroupPeer::IS_PUBLIC, 1);
      $choseGroup = NewsletterGroupPeer::doSelect($c);

      //wysył maila
      $this->SendMail($newsletterUser, $choseGroup, $newsletterUser->getHash());

      //zmienne na template
      $this->email = $this->getRequestParameter("newsletter[email]");
      $this->choseGroup = $choseGroup;
   }

   /**
    * Obsługuje wysyłanie mail'i
    */
   function SendMail($user, $group, $hash)
   {
      $this->smarty = new stSmarty($this->getModuleName());
      $mail_error = $this->mailWithConfirmRegisterToUser($user, $group, $hash, $this->smarty);
      return $mail_error;
   }

   /**
    * Wysyła mail z zamówieniem do administratora
    */
   function mailWithConfirmRegisterToUser($user, $group, $hash, $smarty)
   {
      $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend'); 
       
      $mailHtmlHead = stMailer::getHtmlMailDescription("header");
                
      $mailHtmlFoot = stMailer::getHtmlMailDescription("footer"); 
       
      $sendConfirmRegisterToUserHtmlMailMessage = stMailTemplate::render('sendConfirmRegisterToUserHtml', array(
                  'user' => $user,
                  'mail_config' => $mail_config,
                  'group' => $group,
                  'hash' => $hash,
                  'head' => $mailHtmlHead,
                  'foot' => $mailHtmlFoot,
                  'smarty' => $smarty,                  
              ));

      $sendConfirmRegisterToUserPlainMailMessage = stMailTemplate::render('sendConfirmRegisterToUserPlain', array(
                  'user' => $user,
                  'group' => $group,
                  'hash' => $hash,
                  'smarty' => $smarty,
              ));

      $mail = stMailer::getInstance();
      return $mail->setSubject(__('Rejestracja na liście subskrypcji.'))->setHtmlMessage($sendConfirmRegisterToUserHtmlMailMessage)->setPlainMessage($sendConfirmRegisterToUserPlainMailMessage)->setTo($user->getEmail())->sendToClient();
   }

   /**
    * Obsługuje wysyłanie mail'i
    */
   function sendAfterRegisterMail($user)
   {
      $this->smarty = new stSmarty($this->getModuleName());
      $mail_error = $this->mailWithRegisterMessageToUser($user, $this->smarty);
      return $mail_error;
   }
   
      /**
    * Wysyła mail dodatkową wiadomością
    */
   function mailWithRegisterMessageToUser($user, $smarty)
   {
      $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend');
      
      $newsletter_config = stConfig::getInstance($this->getContext(), 'stNewsletterBackend');       
       
      $mailHtmlHead = stMailer::getHtmlMailDescription("header");
                
      $mailHtmlFoot = stMailer::getHtmlMailDescription("footer"); 
       
      $sendRegisterMessageToUserHtmlMailMessage = stMailTemplate::render('sendRegisterMessageToUserHtml', array(
                  'user' => $user,
                  'mail_config' => $mail_config,
                  'newsletter_config' => $newsletter_config,                                    
                  'head' => $mailHtmlHead,
                  'foot' => $mailHtmlFoot,
                  'smarty' => $smarty,                  
              ));

      $sendRegisterMessageToUserPlainMailMessage = stMailTemplate::render('sendRegisterMessageToUserPlain', array(
                  'user' => $user,                  
                  'smarty' => $smarty,
              ));    

      $mail = stMailer::getInstance();
      return $mail->setSubject($newsletter_config->get('register_message_title', null, true))->setHtmlMessage($sendRegisterMessageToUserHtmlMailMessage)->setPlainMessage($sendRegisterMessageToUserPlainMailMessage)->setTo($user->getEmail())->sendToClient();
   }

   /**
    * Uchwyt do walidatora edycji hasła.
    */
   public function validateAddToList()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $error_exists = false;

         $i18n = $this->getContext()->getI18N();

         if($this->getRequestParameter('newsletter[privacy]')!=1)
		 {
				$this->getRequest()->setError('error_privacy', 1);
	            $error_exists = true;
		 }
		 else 
		 {		
				$validator = new stCaptchaGDValidator();
	
		        $validator->initialize($this->getContext(), array('captcha_error' => 'Wprowadzono zły numer.'));
		
		        $captcha = $this->getRequestParameter('captcha');
				
		        if (!$validator->execute($captcha, $error))
		        {
		            $this->getRequest()->setError('captcha', $error);
		            $error_exists = true;
	        	}				
			}
		
		return !$error_exists;
		}
        
      }

   /**
    * Uchwyt do walidatora edycji hasła.
    */
   public function handleErrorAddToList()
   {
      $this->smarty = new stSmarty($this->getModuleName());

      $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');
      return $this->forward('stNewsletterFrontend', 'index');
   }

   public function executeAdd()
   {
      $this->smarty = new stSmarty($this->getModuleName());
      return $this->forward('stNewsletterFrontend', 'index');
   }

   /**
    * Uchwyt do walidatora edycji hasła.
    */
   public function handleErrorAdd()
   {
      $this->smarty = new stSmarty($this->getModuleName());
      return $this->forward('stNewsletterFrontend', 'index');
   }

   public function executeConfirm()
   {
      $this->smarty = new stSmarty($this->getModuleName());
      
      $this->newsletter_config = stConfig::getInstance($this->getContext(), 'stNewsletterBackend');
      
      if ($this->hasRequestParameter('confirm'))
      {
         $c = new Criteria();
         $c->add(NewsletterUserPeer::ID, $this->getRequestParameter('id'));
         $newsletterUser = NewsletterUserPeer::doSelectOne($c);

         if ($newsletterUser)
         {
            if ($newsletterUser->getHash() == $this->getRequestParameter('hash_code'))
            {
               $newsletterUser->setConfirm(1);
               $newsletterUser->save();

               $this->newsletterUser = $newsletterUser;
               
               if($this->newsletter_config->get('register_message_on')){
                    $this->sendAfterRegisterMail($newsletterUser);    
               }
               
            }
            else
            {
               $this->redirect("stNewsletterFrontend/index");
            }
         }
         else
         {
            $this->redirect("stNewsletterFrontend/index");
         }
      }
      else
      {
         $this->redirect("stNewsletterFrontend/index");
      }
   }

   public function executeRemove()
   {
      $this->smarty = new stSmarty($this->getModuleName());
      if ($this->hasRequestParameter('remove'))
      {
         $c = new Criteria();

         $c->add(NewsletterUserPeer::ID, $this->getRequestParameter('id'));
         $newsletterUser = NewsletterUserPeer::doSelectOne($c);

         if ($newsletterUser)
         {
            if ($newsletterUser->getHash() == $this->getRequestParameter('hash_code'))
            {
               $c = new Criteria();

               $c->add(NewsletterUserPeer::ID, $this->getRequestParameter('id'));
               NewsletterUserPeer::doDelete($c);

               $this->newsletterUser = $newsletterUser;
            }
            else
            {
               $this->redirect("stNewsletterFrontend/index");
            }
         }
         else
         {
            $this->redirect("stNewsletterFrontend/index");
         }
      }
      else
      {
         $this->redirect("stNewsletterFrontend/index?ff=1");
      }
   }

   public function executeNewsletterList()
   {
      $this->smarty = new stSmarty($this->getModuleName());
      
      $newsletter_config = stConfig::getInstance($this->getContext(), 'stNewsletterBackend');      
      
      if($newsletter_config->get('newsletter_enabled')==1){
            $this->redirect("/");    
      }

      $user = sfContext::getInstance()->getUser()->getGuardUser();

      $c = new Criteria();
      $c->add(sfGuardUserPeer::ID, $user->getId());
      $user = sfGuardUserPeer::doSelectOne($c);

      $c = new Criteria();
      $c->add(NewsletterUserPeer::SF_GUARD_USER_ID, $user->getId());
      $newsletterUser = NewsletterUserPeer::doSelectOne($c);

      if ($newsletterUser)
      {

         if ($this->getRequestParameter('newsletter[email]'))
         {
            $this->newsletterUserEmail = $this->getRequestParameter('newsletter[email]');
         }
         else
         {
            $this->newsletterUserEmail = $user->getUsername();
         }

         $this->newsletterUser = $newsletterUser;

         $c = new Criteria();
         $c->add(NewsletterGroupPeer::IS_PUBLIC, 1);
         $newsletterGroup = NewsletterGroupPeer::doSelect($c);
         
         
         foreach ($newsletterGroup as $group)
         {
          
            $c = new Criteria();
            $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $newsletterUser->getId());
            $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, $group->getId());
            $NewsletterUserHasNewsletterGroup = NewsletterUserHasNewsletterGroupPeer::doSelectOne($c);
            if ($NewsletterUserHasNewsletterGroup)
            {
               $group->setIsDefault(1);
            }
            else
            {
               $group->setIsDefault(0);
            }
            
         }
         
         $this->userEmail = $newsletterUser->getEmail();

         $this->newsletterGroup = $newsletterGroup;

         $this->newUser = 0;
      }
      else
      {
      	
         if ($this->getRequestParameter('newsletter[email]'))
         {
            $this->newsletterUserEmail = $this->getRequestParameter('newsletter[email]');
         }
         else
         {
            $this->newsletterUserEmail = $user->getUsername();
         }

         $c = new Criteria();
         $c->add(NewsletterGroupPeer::IS_PUBLIC, 1);
         $newsletterGroup = NewsletterGroupPeer::doSelect($c);
         
         foreach ($newsletterGroup as $group)
         {
            $group->setIsDefault(0);
         }

         $this->newsletterGroup = $newsletterGroup;

         $this->newUser = 1;
      }

      if ($this->getRequestParameter('update') == 1)
      {
         $this->update = 1;
      }
      else
      {
         $this->update = 0;
      }
   }

   public function executeAddLoginUserToNewsletter()
   {

      $this->smarty = new stSmarty($this->getModuleName());

	  if(!$this->getUser()->isAuthenticated())
      {
		$this->redirect("stNewsletterFrontend/add");
	  }
		
      if ($this->getRequestParameter('newsletter[new_user]') == 1)
      {
         $c = new Criteria();
         $c->add(sfGuardUserPeer::USERNAME, $this->getRequestParameter('newsletter[email]'));
         $user = sfGuardUserPeer::doSelectOne($c);
		 
         if($user)
         {
            $user_id = $user->getId();
         }
         else
         {
            $user_id = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
         }

         $newsletterUser = new NewsletterUser();
         $newsletterUser->setEmail($this->getRequestParameter("newsletter[email]"));
         $newsletterUser->setUserId($user_id);
         $newsletterUser->setActive(1);
         $newsletterUser->setConfirm(1);
         $newsletterUser->save();
      }
      else
      {
      		
		
         $c = new Criteria();
         $c->add(NewsletterUserPeer::SF_GUARD_USER_ID, $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
         $newsletterUser = NewsletterUserPeer::doSelectOne($c);

         if ($this->getRequestParameter("newsletter[email]") != "")
         {
            $c = new Criteria();
            $c->add(sfGuardUserPeer::ID, $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
            $user = sfGuardUserPeer::doSelectOne($c);
            $newsletterUser->setEmail($this->getRequestParameter("newsletter[email]"));
            $newsletterUser->save();
         }
      }

      $newsletter_user_id = $newsletterUser->getId();

      if ($this->getRequestParameter('newsletter[new_user]') != 1)
      {
         $c = new Criteria();
         $c->addJoin(NewsletterGroupPeer::ID, NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID);
         $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $newsletterUser->getId());
         NewsletterUserHasNewsletterGroupPeer::doDelete($c);
      }

      $checkedGroup = $this->getRequestParameter('newsletter[group]');

      if ($checkedGroup)
      {
         foreach ($checkedGroup as $key => $value)
         {
            $c = new Criteria();
            $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $newsletter_user_id);
            $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, $key);
            NewsletterUserHasNewsletterGroupPeer::doInsert($c);
         }
      }else{
             $c = new Criteria();
             $c->add(NewsletterUserPeer::ID, $newsletter_user_id);
             NewsletterUserPeer::doDelete($c);
      }


      $c = new Criteria();
      if (!$this->getRequestParameter('newsletter[group]'))
      {
         $c->add(NewsletterGroupPeer::IS_PUBLIC, 1);
      }
      else
      {
         $c->add(NewsletterGroupPeer::IS_PUBLIC, 0);
      }
      $c->add(NewsletterGroupPeer::IS_DEFAULT, 1);
      $defaultNewsletterGroup = NewsletterGroupPeer::doSelect($c);

      if ($defaultNewsletterGroup)
      {
         foreach ($defaultNewsletterGroup as $group)
         {
            $c = new Criteria();
            $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $newsletter_user_id);
            $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, $group->getId());
            NewsletterUserHasNewsletterGroupPeer::doInsert($c);
         }
      }



      $c = new Criteria();
      $c->add(sfGuardUserPeer::ID, $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
      $user = sfGuardUserPeer::doSelectOne($c);

      if ($this->getRequestParameter("newsletter[email]") != $user->getUsername())
      {
         $c = new Criteria();
         $c->addJoin(NewsletterGroupPeer::ID, NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID);
         $c->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $newsletterUser->getId());
         $c->add(NewsletterGroupPeer::IS_PUBLIC, 1);
         $choseGroup = NewsletterGroupPeer::doSelect($c);

         $newsletterUser->setConfirm(0);
         $newsletterUser->save();

         $this->SendMail($newsletterUser, $choseGroup, $newsletterUser->getHash());
      }
      else
      {
         $newsletterUser->setConfirm(1);
         $newsletterUser->save();
      }


      $this->redirect("stNewsletterFrontend/newsletterList?update=1");
   }

   /**
    * Uchwyt do walidatora dodania użytkownika do newslettera.
    */
   public function handleErrorAddLoginUserToNewsletter()
   {

      $this->smarty = new stSmarty($this->getModuleName());

      return $this->forward('stNewsletterFrontend', 'newsletterList');
   }

   public function validateAddLoginUserToNewsletter()
   {
   	  $error_exists = false;
	  

	  
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
        
         $i18n = $this->getContext()->getI18N();

         if ($this->getRequestParameter('newsletter[new_user]') == 1 && $this->getRequestParameter('newsletter[email]') == "")
         {
               $this->getRequest()->setError('newsletter{email}', "Brak adresu e-mail.");
               $error_exists = true;
			   
         }
         
         if($this->getRequestParameter('newsletter[privacy]')!=1)
         {
                $this->getRequest()->setError('error_privacy', 1);
                $error_exists = true;
         }
		 
		 if ($this->getRequestParameter('newsletter[new_user]') == 1)
		 {
			 $c = new Criteria();
	         $c->add(NewsletterUserPeer::EMAIL, $this->getRequestParameter('newsletter[email]'));
	         $newsletterUser = NewsletterUserPeer::doSelectOne($c);
	
	         if ($newsletterUser)
	         {
	            $this->getRequest()->setError('newsletter{email}', "Taki użytkownik już istnieje.");
	            $error_exists = true;	
         	 }
		 }   
      }
	  return!$error_exists;
   }

}