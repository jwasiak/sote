<?php
/** 
 * SOTESHOP/stUser 
 * 
 * Ten plik należy do aplikacji stUser opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stUser
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 2671 2009-08-19 14:33:54Z bartek $
 */

/** 
 * Akcje profili użytkownika 
 *
 * @author Bartosz Alejski <bartosz.alejski@sote.pl>
 *
 * @package     stUser
 * @subpackage  actions
 */
class stUserActions extends stActions
{

    public function executeCreateAccount()
    {
        if($this->getUser()->isAuthenticated())
        {
            $this->redirect('stUserData/userPanel');
        }
        else
        {

            $this->smarty = new stSmarty($this->getModuleName());

            $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');

            $c = new Criteria();
            $c->add(WebpagePeer::ID, 4);
            $this->webpage = WebpagePeer::doSelectOne($c);

            if ($this->getRequest()->getMethod() == sfRequest::POST)
            {
               $username = $this->getRequestParameter('user[email]');
               $password = $this->getRequestParameter('user[password1]');

               $c = new Criteria();
               $c->add(sfGuardUserPeer::USERNAME, $username);
               $user = sfGuardUserPeer::doSelectOne($c);

               if($user)
               {
                   if($user->getIsConfirm()==0)
                   {
                       $user->setPassword($password);
                       $user->save();

                       $this->sendMail($user, $password,1);

                       return $this->forward('stUser', 'userWaitConfirm');
                   }
                   else
                   {
                      return $this->forward('stUserData', 'userPanel');
                   }
               }
               else
               {

               $user = stUser::addUser($username,$password);    

               stNewsletter::addNewUserToNewsletterList($username,$user->getId());

                try {
                $this->sendMail($user, $password);
                } catch (Exception $e)
                {
                //@todo: add to log.
                }
                $this->postExecute();
                return $this->forward('stUser', 'userWaitConfirm');

               }
            }
        }
    }

    public function executeRequestDeleteAccount()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        if($this->getUser()->isAuthenticated())
        {            
            $user_id = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
            $this->email = $this->getUser()->getEmail();
            
            $c = new Criteria();
            $c->add(SfGuardUserPeer::ID , $user_id);
            $user = SfGuardUserPeer::doSelectOne($c);
            
            $this->sendMailWithRequestUserDelete($user);      
            
            $this->getUser()->signOut();      
        }             
    }
    
        /** 
     * Obsługuje wysyłanie mail'i
     */
    function sendMailWithRequestUserDelete($user)
    {
        $this->smarty = new stSmarty($this->getModuleName());

        $mail_error = $this->mailWithRequestUserDelete($user);
        
        return $mail_error;
    }
    
    /** 
     * Wysyła mail z zamówieniem do administratora
     */
    function mailWithRequestUserDelete($user)
    {       
        $this->smarty = new stSmarty($this->getModuleName());

        $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend');

        $mailHtmlHead = stMailer::getHtmlMailDescription("header");
                
        $mailHtmlFoot = stMailer::getHtmlMailDescription("footer");

        $language = LanguagePeer::retrieveByCulture($user->getLanguage());
        $languageShortcut = $language->getShortcut();
        
        $sendRequestUserConfirmDeleteHtmlMailMessage = stMailTemplate::render('sendRequestUserConfirmDeleteHtml', array(
        'user' => $user,
        'mail_config' => $mail_config,
        'languageShortcut' => $languageShortcut,
        'head' => $mailHtmlHead,
        'foot' => $mailHtmlFoot,
        
        'smarty' => $this->smarty 
        ));
        
        $mailPlainHead = stMailer::getPlainMailDescription("header");
                
        $mailPlainFoot = stMailer::getPlainMailDescription("footer");
                       
        $sendRequestUserConfirmDeletePlainMailMessage = stMailTemplate::render('sendRequestUserConfirmDeletePlain', array(
        'user' => $user,
        'mail_config' => $mail_config,
        'languageShortcut' => $languageShortcut,
        'head' => $mailPlainHead,
        'foot' => $mailPlainFoot,
 
        'smarty' => $this->smarty 
        ));        
          
        $mail = stMailer::getInstance();
        return $mail->setSubject(__('Prośba o potwierdzenie usunięcia konta.'))->setHtmlMessage($sendRequestUserConfirmDeleteHtmlMailMessage)->setPlainMessage($sendRequestUserConfirmDeletePlainMailMessage)->setTo($user->getUsername())->sendToClient();
        
    }
    
    public function executeDeleteAccount()
    {        
        $this->smarty = new stSmarty($this->getModuleName());
        
        $user_id = $this->getRequestParameter('user');
                    
        $hashCode = $this->getRequestParameter('hash_code');
        
        stLanguage::changeLanguageByShortcut($this->getRequestParameter('language'));
             
        $c = new Criteria();
        $c->add(sfGuardUserPeer::ID, $user_id);
        $user = sfGuardUserPeer::doSelectOne($c);
        
        $this->email = $user->getUsername();
        
        if($user)
        {
            $user->delete();
        }    
        
            
        
    }
    
    


    public function executeGoogleOAuthSingIn()
    {
       
       $username = stGooglePlusAccess::getAuthUser();
       //$back = $this->getRequestParameter('back');
       
               
        $back = sfContext::getInstance()->getUser()->getAttribute('google_back', 'create');

       
       // //$back="basket";
       // echo "action: ".$back."<br/>";
       // echo $username;
       // //$back="create";
       // die();

         if(!sfGuardUserPeer::retrieveByUsername($username))
         {
            stUser::addUser($username);
            stUser::setExternalAccount($username,"google");
            stUser::setIsConfirm($username);
         }

         stUser::loginUserOnlyUsername($username);
         
         stPoints::refreshLoginStatusPoints();
         
         if($back == "create")
         {
            $user = sfGuardUserPeer::retrieveByUsername($username);

            $c = new Criteria();
            $c->add(UserDataPeer::SF_GUARD_USER_ID, $user->getId());
            
            if(UserDataPeer::doSelectOne($c))
            {
               $this->postExecute();
               $this->redirect('stUserData/userPanel');
            }
            else
            {
               $this->postExecute();
               //$this->redirect('stUserData/createFirstUserData');
               $this->redirect('stUserData/userPanel');
            }

         }

         if($back == "basket")
         {
            $this->postExecute();
            $this->redirect('stBasket/index#external_account');
         }
       
       
    }


    public function executeGoogleSingIn()
    {
       $back = $this->getRequestParameter('back');


       define('CALLBACK_URL', 'http://'.$_SERVER['SERVER_NAME'].'/user/loginGoogleUser/back/'.$back);

       // Creating new instance
       $openid = new stOpenId;
       $openid->identity = 'https://www.google.com/accounts/o8/id';
       //setting call back url
       $openid->returnUrl = CALLBACK_URL;
       //finding open id end point from google
       $endpoint = $openid->discover('https://www.google.com/accounts/o8/id');
       $fields =
               '?openid.ns=' . urlencode('http://specs.openid.net/auth/2.0') .
               '&openid.return_to=' . urlencode($openid->returnUrl) .
               '&openid.claimed_id=' . urlencode('http://specs.openid.net/auth/2.0/identifier_select') .
               '&openid.identity=' . urlencode('http://specs.openid.net/auth/2.0/identifier_select') .
               '&openid.mode=' . urlencode('checkid_setup') .
               '&openid.ns.ax=' . urlencode('http://openid.net/srv/ax/1.0') .
               '&openid.ax.mode=' . urlencode('fetch_request') .
               '&openid.ax.required=' . urlencode('email,firstname,lastname') .
               '&openid.ax.type.firstname=' . urlencode('http://axschema.org/namePerson/first') .
               '&openid.ax.type.lastname=' . urlencode('http://axschema.org/namePerson/last') .
               '&openid.ax.type.email=' . urlencode('http://axschema.org/contact/email');
               
               return $this->redirect($endpoint.$fields);
       
    }

    public function executeLoginGoogleUser()
    {

         $username = $this->getRequestParameter('openid_ext1_value_email');
         $back = $this->getRequestParameter('back');

         if(!sfGuardUserPeer::retrieveByUsername($username))
         {
            stUser::addUser($username);
            stUser::setExternalAccount($username,"google");
            stUser::setIsConfirm($username);
         }

         stUser::loginUserOnlyUsername($username);
         
         stPoints::refreshLoginStatusPoints();
         
         if($back == "create")
         {
            $user = sfGuardUserPeer::retrieveByUsername($username);

            $c = new Criteria();
            $c->add(UserDataPeer::SF_GUARD_USER_ID, $user->getId());
            
            if(UserDataPeer::doSelectOne($c))
            {
               $this->postExecute();
               $this->redirect('stUserData/userPanel');
            }
            else
            {
               $this->postExecute();
               $this->redirect('stUserData/userPanel');
               //$this->redirect('stUserData/createFirstUserData');
            }

         }

         if($back == "basket")
         {
            $this->postExecute();
            $this->redirect('stBasket/index#external_account');
         }
         
    }


    public function validateCreateAccount()
    {
        $error_exists = false;
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {

            $i18n = $this->getContext()->getI18N();

            $username = $this->getRequestParameter('user[email]');

            if (!$username){
                
                 $this->getRequest()->setError('user{email}', $i18n->__('Brak adresu email.'));
                 $error_exists = true;
                
            }elseif (!filter_var($username, FILTER_VALIDATE_EMAIL)) {

                $this->getRequest()->setError('user{email}', $i18n->__('Nieprawidłowy format adresu e-mail.'));
                $error_exists = true;
            }
            else
            {
                $c = new Criteria();

                $c->add(sfGuardUserPeer::USERNAME, $username);

                $user = sfGuardUserPeer::doSelectOne($c);

                if(stUser::isFullAccount($user))
                {
                    $this->getRequest()->setError('user{email}', "Taki użytkownik już istnieje.");
                    $error_exists = true;
                }
            }                                             
            
            if($this->getRequestParameter('user[privacy]')!=1)
            {
                $this->getRequest()->setError('error_privacy', 1);
                $error_exists = true;
            }
            else 
            {
                if(!$this->getUser()->isAuthenticated())
                {
                    $validator = new stCaptchaGDValidator();
        
                    $validator->initialize($this->getContext(), array('captcha_error' => 'Wprowadzono zły numer.'));
            
                    $captcha = $this->getRequestParameter('captcha');
                    
                    if (!$validator->execute($captcha, $error) && $this->getUser()->getAttribute('captcha_off')!=1)
                    {
                        $this->getRequest()->setError('captcha', $error);
                        $error_exists = true;
                    }else{
                        $this->getUser()->setAttribute('captcha_off', true);
                    }   
                }           
            }
        
        }

        return !$error_exists;
    }
    
    
    public function executeEditAccount()
    {  
        $this->smarty = new stSmarty($this->getModuleName());
        
        $showMessage = $this->getRequestParameter('showMessage');
        $email = $this->getUser()->getEmail();
        $this->email = $email;
        
        if(sfContext::getInstance()->getUser()->hasGroup('admin')){
            $this->redirect('stUserData/userPanel');
        }
        
        if($this->getUser()->isAuthenticated())
        {
            $c = new Criteria();
            $c->add(UserDataPeer::SF_GUARD_USER_ID , $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
            $c->add(UserDataPeer::IS_BILLING , 1);
            $c->add(UserDataPeer::IS_DEFAULT , 1);
            $userDataBilling = UserDataPeer::doSelectOne($c);           
                        
            $c = new Criteria();
            $c->add(UserDataPeer::SF_GUARD_USER_ID , $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
            $c->add(UserDataPeer::IS_BILLING , 0);
            $c->add(UserDataPeer::IS_DEFAULT , 1);
            $userDataDelivery = UserDataPeer::doSelectOne($c);
            
            $this->userDataBilling = $userDataBilling;  
            $this->userDataDelivery = $userDataDelivery; 
            $this->showMessage = $showMessage;
                             
            $c = new Criteria();
            $c->add(SfGuardUserPeer::ID , $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));                        
            $user = SfGuardUserPeer::doSelectOne($c);
                        
            $this->salt = $user->getSalt();
        }
        else
        {
            stUser::processAuthentication();
        }
    }
    
    public function executeEditLogin()
    {  
        $this->smarty = new stSmarty($this->getModuleName());                        
                
            if ($this->getRequest()->getMethod() == sfRequest::POST)
            {
            $this->getUser()->setEmail($this->getRequestParameter('user[email]'));
            
            $c = new Criteria();
            $c->add(SfGuardUserPeer::USERNAME , $this->getRequestParameter('user[email]'));                        
            $user = SfGuardUserPeer::doSelectOne($c);        
            $user->setIsConfirm(0);
            $user->save();
            
            $this->sendMailWithRequestUserConfirm($user);
            $this->getUser()->logoutUser();
                    
            $this->redirect('stUser/userWaitConfirm');
            
            }
        
    }
    
    public function executeEditPassword()
    {  
        $this->smarty = new stSmarty($this->getModuleName());
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
        $this->getUser()->setPassword($this->getRequestParameter('user[password1]'));        
                
        try {
        $this->sendMailWithNewPasswordToUser($this->getUser(), $this->getRequestParameter('user[password1]'));
            } catch (Exception $e)
            {
            //@todo: add to log.
            }
        $email = $this->getUser()->getUsername();
        $this->getUser()->logoutUser();    
        $this->redirect('stUser/confirmSendPassword?email='.$email);
        }
        else
        {
        $this->redirect('stUserData/userPanel');
        }

    }
    
    public function executeLoginUserBasket()
    {   
        $this->smarty = new stSmarty($this->getModuleName());
        
        // logowanie odbywa sie przy validacji 
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
             $this->redirect('stBasket/index#selectUserData');
        }
    }
    
    public function executeLoginUser()
    {   
        $this->smarty = new stSmarty($this->getModuleName());
        
        //    logowanie odbywa sie przy validacji 
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->redirect('stUserData/userPanel');
        }
            
    }
    
    /** 
     * Wysyła mail z zamówieniem do administratora
     */
    function mailWithNewUserToAdmin($user)
    {
       $culture = $this->getUser()->getCulture();

        $this->smarty = new stSmarty($this->getModuleName());
        
        $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend');

        $c = new Criteria();
        $c->add(LanguagePeer::IS_DEFAULT_PANEL,1);
        $language = LanguagePeer::doSelectOne($c);
        if(is_object($language)) $this->getUser()->setCulture($language->getOriginalLanguage());
        
        $mailHtmlHead = stMailer::getHtmlMailDescription("header");
                
        $mailHtmlFoot = stMailer::getHtmlMailDescription("footer");
        
        $sendNewUserToAdminHtmlMailMessage = stMailTemplate::render('sendNewUserToAdminHtml', array(
        'user' => $user,
        'mail_config' => $mail_config,
        'head' => $mailHtmlHead,
        'foot' => $mailHtmlFoot,
        'smarty' => $this->smarty 
        ));
        
        $mailPlainHead = stMailer::getPlainMailDescription("header");
                
        $mailPlainFoot = stMailer::getPlainMailDescription("footer");
        
        $sendNewUserToAdminPlainMailMessage = stMailTemplate::render('sendNewUserToAdminPlain', array(
        'user' => $user, 
        'mail_config' => $mail_config,
        'head' => $mailPlainHead,
        'foot' => $mailPlainFoot,
        'smarty' => $this->smarty
        ));        
          
        $mail = stMailer::getInstance();
        $ret = $mail->setSubject(__('W sklepie zarejestrował się nowy klient.'))->setHtmlMessage($sendNewUserToAdminHtmlMailMessage)->setPlainMessage($sendNewUserToAdminPlainMailMessage)->sendToMerchant();
        
        $this->getUser()->setCulture($culture);
        
        return $ret;
    }
    
    /** 
     * Wysyła mail z zamówieniem do administratora
     */
    function mailWithNewUserToUser($user, $password)
    {       
        $this->smarty = new stSmarty($this->getModuleName());
        
        $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend');

        $language = LanguagePeer::retrieveByCulture($this->getUser()->getCulture());
        
        $mailHtmlHead = stMailer::getHtmlMailDescription("header");
                
        $mailHtmlFoot = stMailer::getHtmlMailDescription("footer");
        
        $mailHtmlHeadContent = stMailer::getHtmlMailDescription("top_user_new");
        
        $mailHtmlFootContent = stMailer::getHtmlMailDescription("bottom_user_new");
        
        $sendNewUserToUserHtmlMailMessage = stMailTemplate::render('sendNewUserToUserHtml', array(
        'user' => $user,
        'password' => $password,
        'head' => $mailHtmlHead,
        'foot' => $mailHtmlFoot,
        'head_content' => $mailHtmlHeadContent,
        'foot_content' => $mailHtmlFootContent,
        'mail_config' => $mail_config,
        'languageShortcut' => $language->getShortcut(),
        'smarty' => $this->smarty 
        ));
        
        $mailPlainHead = stMailer::getPlainMailDescription("header");
                
        $mailPlainFoot = stMailer::getPlainMailDescription("footer");
        
        $mailPlainHeadContent = stMailer::getPlainMailDescription("top_user_new");
        
        $mailPlainFootContent = stMailer::getPlainMailDescription("bottom_user_new");
        
        $sendNewUserToUserPlainMailMessage = stMailTemplate::render('sendNewUserToUserPlain', array(
        'user' => $user, 
        'password' => $password,
        'head' => $mailPlainHead,
        'foot' => $mailPlainFoot,
        'head_content' => $mailPlainHeadContent,
        'foot_content' => $mailPlainFootContent,
        'languageShortcut' => $language->getShortcut(),
        'smarty' => $this->smarty 
        ));        
          
        $mail = stMailer::getInstance();
        return $mail->setSubject(__('Twoje konto w sklepie zostało założone.'))->setHtmlMessage($sendNewUserToUserHtmlMailMessage)->setPlainMessage($sendNewUserToUserPlainMailMessage)->setTo($user->getUsername())->sendToClient();
        
    }
    
    
    /** 
     * Wysyła mail z zamówieniem do administratora
     */
    function mailWithLinkToChangePassword($user, $hashCode)
    {       
        
        $this->smarty = new stSmarty($this->getModuleName());
        
        $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend');
        
        $mailHtmlHead = stMailer::getHtmlMailDescription("header");
                
        $mailHtmlFoot = stMailer::getHtmlMailDescription("footer");
        
        $sendLinkToPasswordToUserHtmlMailMessage = stMailTemplate::render('sendLinkToPasswordToUserHtml', array(
        'user' => $user,
        'mail_config' => $mail_config,
        'hashCode' => $hashCode,
        'head' => $mailHtmlHead,
        'foot' => $mailHtmlFoot,
        'smarty' => $this->smarty
        ));
        
        $mailPlainHead = stMailer::getPlainMailDescription("header");
                
        $mailPlainFoot = stMailer::getPlainMailDescription("footer");
        
        $sendLinkToPasswordToUserPlainMailMessage = stMailTemplate::render('sendLinkToPasswordToUserPlain', array(
        'user' => $user, 
        'mail_config' => $mail_config,
        'hashCode' => $hashCode, 
        'head' => $mailPlainHead,
        'foot' => $mailPlainFoot,
        'smarty' => $this->smarty
        ));        
          
        $mail = stMailer::getInstance();
        return $mail->setSubject(__('Link do zmiany hasła dla konta:')." ".$user)->setHtmlMessage($sendLinkToPasswordToUserHtmlMailMessage)->setPlainMessage($sendLinkToPasswordToUserPlainMailMessage)->setTo($user)->sendToClient();
        
    }
    
    /** 
     * Wysyła mail z zamówieniem do administratora
     */
    function sendMailWithNewPasswordToUser($user, $password)
    {       
        $this->smarty = new stSmarty($this->getModuleName());
        
        $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend');
        
        $mailHtmlHead = stMailer::getHtmlMailDescription("header");
                
        $mailHtmlFoot = stMailer::getHtmlMailDescription("footer");
        
        $mailHtmlHeadContent = stMailer::getHtmlMailDescription("top_user_remaind");
        
        $mailHtmlFootContent = stMailer::getHtmlMailDescription("bottom_user_remaind");
                
        $sendNewPasswordToUserHtmlMailMessage = stMailTemplate::render('sendNewPasswordToUserHtml', array(
        'user' => $user,        
        'password' => $password,
        'mail_config' => $mail_config,
        'head_content' => $mailHtmlHeadContent,
        'foot_content' => $mailHtmlFootContent,
        'head' => $mailHtmlHead,
        'foot' => $mailHtmlFoot,
        'smarty' => $this->smarty 
        ));
        
        $mailPlainHead = stMailer::getPlainMailDescription("header");
                
        $mailPlainFoot = stMailer::getPlainMailDescription("footer");
        
        $mailPlainHeadContent = stMailer::getPlainMailDescription("top_user_remaind");
        
        $mailPlainFootContent = stMailer::getPlainMailDescription("bottom_user_remaind");
        
        $sendNewPasswordToUserPlainMailMessage = stMailTemplate::render('sendNewPasswordToUserPlain', array(
        'user' => $user, 
        'password' => $password,
        'mail_config' => $mail_config,
        'head_content' => $mailPlainHeadContent,
        'foot_content' => $mailPlainFootContent,
        'head' => $mailPlainHead,
        'foot' => $mailPlainFoot,
        'smarty' => $this->smarty 
        ));        
          
        $mail = stMailer::getInstance();
        return $mail->setSubject(__('Twoje hasło zostało zmienione.'))->setHtmlMessage($sendNewPasswordToUserHtmlMailMessage)->setPlainMessage($sendNewPasswordToUserPlainMailMessage)->setTo($user->getUsername())->sendToClient();
        
    }
    
    /** 
     * Obsługuje wysyłanie mail'i
     */
    function SendMail($user, $password, $only_user=0)
    {
        $this->smarty = new stSmarty($this->getModuleName());
        
        $mail_error = $this->MailWithNewUserToUser($user, $password);
        if($only_user!=1)
        {
            $mail_error = $this->MailWithNewUserToAdmin($user);
        }
        return $mail_error;
    }
    
    /** 
     * Obsługuje wysyłanie mail'i
     */
    function sendMailWithRequestUserConfirm($user)
    {
        $this->smarty = new stSmarty($this->getModuleName());

        $mail_error = $this->mailWithRequestUserConfirm($user);
        
        return $mail_error;
    }
    
    /** 
     * Wysyła mail z zamówieniem do administratora
     */
    function mailWithRequestUserConfirm($user)
    {       
        $this->smarty = new stSmarty($this->getModuleName());

        $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend');

        $mailHtmlHead = stMailer::getHtmlMailDescription("header");
                
        $mailHtmlFoot = stMailer::getHtmlMailDescription("footer");

        $language = LanguagePeer::retrieveByCulture($user->getLanguage());
        $languageShortcut = $language->getShortcut();
        
        $sendRequestUserConfirmHtmlMailMessage = stMailTemplate::render('sendRequestUserConfirmHtml', array(
        'user' => $user,
        'mail_config' => $mail_config,
        'languageShortcut' => $languageShortcut,
        'head' => $mailHtmlHead,
        'foot' => $mailHtmlFoot,
        
        'smarty' => $this->smarty 
        ));
        
        $mailPlainHead = stMailer::getPlainMailDescription("header");
                
        $mailPlainFoot = stMailer::getPlainMailDescription("footer");
                       
        $sendRequestUserConfirmPlainMailMessage = stMailTemplate::render('sendRequestUserConfirmPlain', array(
        'user' => $user,
        'mail_config' => $mail_config,
        'languageShortcut' => $languageShortcut,
        'head' => $mailPlainHead,
        'foot' => $mailPlainFoot,
 
        'smarty' => $this->smarty 
        ));        
          
        $mail = stMailer::getInstance();
        return $mail->setSubject(__('Prośba o potwierdzenie konta.'))->setHtmlMessage($sendRequestUserConfirmHtmlMailMessage)->setPlainMessage($sendRequestUserConfirmPlainMailMessage)->setTo($user->getUsername())->sendToClient();
        
    }
    
    /** 
     * Obsługuje wysyłanie mail'i
     */
    function sendLinkToChangePasswordMail($user, $hashCode)
    {
        $this->smarty = new stSmarty($this->getModuleName());
                
        $mail_error = $this->mailWithLinkToChangePassword($user, $hashCode);
        return $mail_error;
    }
    
    public function executeLogoutUser()
    {   
        if($this->getUser()->isAuthenticated())
        {
            $this->username = $this->getUser()->getUsername();
            $this->getUser()->logoutUser();
            stPoints::refreshLoginStatusPoints();

            if (SF_ENVIRONMENT == 'theme')
            {
                return $this->redirect($this->getUser()->getAttribute('return_url', '/backend.php', 'stThemePlugin'));
            }
        }
        else
        {    
            return $this->redirect('@homepage');
        } 

        $this->smarty = new stSmarty($this->getModuleName());
    }
    
    public function executeCreatePassword()
    {   
        if($this->getUser()->isAuthenticated())
        {
        
            $this->smarty = new stSmarty($this->getModuleName());
                    
            $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');
            $login = $this->getUser()->getEmail();
            $user = $this->getUser()->getGuardUser();

            if($user->getIsConfirm()==1)
            {
               return $this->forward('stUserData', 'userPanel');
            }

            $c = new Criteria();
            $c->add(WebpagePeer::ID, 4);
            $this->webpage = WebpagePeer::doSelectOne($c); 
            
            $this->login = $login;
            
            if ($this->getRequest()->getMethod() == sfRequest::POST)
            {
                 
                $this->getUser()->setPassword($this->getRequestParameter('user[password1]'));
                    
                $user = $this->getUser()->getGuardUser();
                
                $password = $this->getRequestParameter('user[password1]');
                 
                try {
                $this->sendMail($user, $password);
                } catch (Exception $e)
                {
                //@todo: add to log.
                }

                if($user->getIsConfirm()==1)
                {
                     return $this->forward('stUserData', 'userPanel');

                }else{

                     $this->getUser()->logoutUser();

                     return $this->forward('stUser', 'userWaitConfirm');
                }
                 
            }
        }
        else
        {
            stUser::processAuthentication();
        }
    }
    
    /** 
     * Wysyła maila z hasłem do użytkownika.
     */
    public function executeRemindPassword()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        
        $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');
        
        $this->send_true = 0;
        
        $c = new Criteria();
        $c->add(WebpagePeer::ID, 4);
        $this->webpage = WebpagePeer::doSelectOne($c);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
                        
            $c = new Criteria();
            $c->add(sfGuardUserPeer::USERNAME , $this->getRequestParameter('user[email]'));
            $user = sfGuardUserPeer::doSelectOne($c);
                       
            if($user)
            {

                $c = new Criteria();

                $c->add(sfGuardGroupPeer::NAME , 'user');
                $idUserGroupAdmin = sfGuardGroupPeer::doSelectOne($c);
                
                $c = new Criteria();
                $c->add(sfGuardUserGroupPeer::USER_ID , $user->getId());
                $c->add(sfGuardUserGroupPeer::GROUP_ID , $idUserGroupAdmin->getId());
                $userGroup = sfGuardUserGroupPeer::doSelectOne($c);

                if($userGroup)
                {

                    if($user->getHashCode()=="")
                    {
                       $user->setHashCode(md5(microtime()));
                       $user->save();       
                    }
                                                                 
                    try {
                                                
                        $this->sendLinkToChangePasswordMail($this->getRequestParameter('user[email]'), $user->getHashCode());
                    } catch (Exception $e)
                    {
                    //@todo: add to log.
                    }
                       
                    $this->send_true = 1;
                }
                else 
                {
                    $this->send_true = 0;
                }
            
            }
            else 
            {
                $this->send_true = 0;
            }
        }
    }
    
    
    /** 
     * Uchwyt do walidatora tworzenia konta.
     *
     * @return   string
     */
    public function handleErrorCreateAccount()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        
        $c = new Criteria();
        $c->add(WebpagePeer::ID, 4);
        $this->webpage = WebpagePeer::doSelectOne($c); 
        
        $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');
        return sfView::SUCCESS;
    }
    
    /** 
     * Uchwyt do walidatora edycji hasła.
     */
    public function handleErrorEditPassword()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        
        return $this->forward('stUser', 'editAccount');
    }
    
    /** 
     * Uchwyt do walidatora edycji hasła.
     */
    public function handleErrorRemindPassword()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        
        $c = new Criteria();
        $c->add(WebpagePeer::ID, 4);
        $this->webpage = WebpagePeer::doSelectOne($c); 
        
        $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');
        $this->send_true = 0;
        return sfView::SUCCESS;
    }
    
    /** 
     * Uchwyt do walidatora edycji hasła.
     */
    public function validateRemindPassword()
    {
        $error_exists = false;
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
        
            $i18n = $this->getContext()->getI18N();
                
            $validator = new stCaptchaGDValidator();
            
            $validator->initialize($this->getContext(), array('captcha_error' => 'Wprowadzono zły numer.'));
            
            $captcha = $this->getRequestParameter('captcha');
                    
            if (!$validator->execute($captcha, $error) && $this->getUser()->getAttribute('captcha_off')!=1)
            {
                $this->getRequest()->setError('captcha', $error);
                $error_exists = true;
           }else{
                $this->getUser()->setAttribute('captcha_off', true);
           }   
            
            $email = $this->getRequestParameter('user[email]');
                              
                              
           if (!$email){
                
                 $this->getRequest()->setError('user{email}', $i18n->__('Brak adresu email.'));
                 $error_exists = true;
                
            }elseif(!filter_var(trim($email), FILTER_VALIDATE_EMAIL)){
            $this->getRequest()->setError('user{email}', "Nieprawidłowy format adresu e-mail.");
              $error_exists = true;
          }

        }
        return !$error_exists;   
    }
    
    /** 
     * Uchwyt do walidatora edycji hasła.
     */
    public function handleErrorCreatePassword()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        
        $c = new Criteria();
        $c->add(WebpagePeer::ID, 4);
        $this->webpage = WebpagePeer::doSelectOne($c); 
        
        $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');
        $login = $this->getUser()->getEmail();
        $this->login = $login;
        return sfView::SUCCESS;
    }
    
    /** 
     * Uchwyt do walidatora edycji hasła.
     */
    public function validateCreatePassword()
    { 
        $error_exists = false;
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
        

        $i18n = $this->getContext()->getI18N();
    
        
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
        
    /** 
     * Uchwyt do walidatora edycji hasła.
     */
    public function handleErrorEditLogin()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        
        return $this->forward('stUser', 'editAccount');
    }
    
    /** 
     * Uchwyt do walidatora tworzenia konta.
     *
     * @return   string
     */
    public function handleErrorLoginUser()
    {
        $this->smarty = new stSmarty($this->getModuleName());
                
        $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');        
                
        $c = new Criteria();
        $c->add(WebpagePeer::ID, 4);
        $this->webpage = WebpagePeer::doSelectOne($c);
        
        return sfView::SUCCESS;
    }
    
    /**
     * Uchwyt do walidatora edycji hasła.
     */
    public function validateLoginUser()
    {        
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
                        
            $user = $this->getRequestParameter('user');
            
            
            if(stUser::hiddenLoginUser($user['email'],$user['password']))
            {
            
                $email = explode("@",$user['email']);
                
                if(!isset($email[1]))
                {
                    $this->getUser()->logoutUser();
                    return $this->forward('stUser', 'migration');
                }
                     
                    if($this->getUser()->getGuardUser()->getIsConfirm()!=1)
                    {
                        $this->getUser()->logoutUser();
                        return $this->forward('stUser', 'userWaitConfirmRemind');
                    }
                    
                    $this->dispatcher->notify(new sfEvent($this, 'stUser.postValidateLoginUser'));
                    
                    
                    stPoints::refreshLoginStatusPoints();
                    return $this->forward('stUserData', 'userPanel');
            }
        }else{
            if($this->getUser()->isAuthenticated() && $this->getUser()->getGuardUser()->getIsConfirm()==1)
            {        
                    $this->forward('stUserData', 'userPanel');
            }
        }

        return true;
    }
    
    /** 
     * Uchwyt do walidatora tworzenia konta.
     *
     * @return   string
     */
    public function handleErrorLoginUserBasket()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        
        return $this->forward('stBasket', 'index');
    }
    
     /**
     * Uchwyt do walidatora edycji hasła.
     */
    public function validateLoginUserBasket()
    {        
                
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
                        
            $user = $this->getRequestParameter('user');
            
            if(stUser::hiddenLoginUser($user['email'],$user['password']))
            {
            
                $email = explode("@",$user['email']);
                
                if(!isset($email[1]))
                {
                    $this->getUser()->logoutUser();
                    return $this->forward('stUser', 'migration');
                }
                    if($this->getUser()->getGuardUser()->getIsConfirm()!=1)
                    {
                        $this->getUser()->logoutUser();
                        return $this->forward('stUser', 'userWaitConfirmRemind');
                    }

                    $this->dispatcher->notify(new sfEvent($this, 'stUser.postValidateLoginUser'));

                    stPoints::refreshLoginStatusPoints();
                    return $this->redirect('stBasket', 'index');
            }
        }
    }
    
    /** 
    * logowanie po migracji
    */
    public function executeMigration()
    { 
        $this->smarty = new stSmarty($this->getModuleName());
    
        $user = $this->getRequestParameter('user');
               
        if(!isset($user['old_login']))
        {
            $this->old_login = $user['email'];    
        }
        else 
        {
            $this->old_login = $user['old_login'];
        }
        
        
        $this->password = $user['password'];
    }
    
    /** 
    * logowanie po migracji
    */
    public function executeSaveMigrationAccount()
    { 
        //$this->smarty = new stSmarty($this->getModuleName());
    
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $user = $this->getRequestParameter('user');
                        
            stUser::hiddenLoginUser($user['old_login'],$user['password']);           
            
            $this->getUser()->setEmail($user['email']);
            
            $this->getUser()->logoutUser();
            
            stUser::hiddenLoginUser($user['email'],$user['password']); 
            
            return $this->forward('stUserData', 'userPanel');
            
        }       
    }
    
     /** 
     * Uchwyt do walidatora tworzenia konta.
     *
     * @return   string
     */
    public function handleErrorSaveMigrationAccount()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        
        return $this->forward('stUser', 'migration');
    }
    
    public function executeEmailConfirm()
    {        
        $this->smarty = new stSmarty($this->getModuleName());
        
        $user_id = $this->getRequestParameter('user');
                    
        $hashCode = $this->getRequestParameter('hash_code');
        
        stLanguage::changeLanguageByShortcut($this->getRequestParameter('language'));
             
        $c = new Criteria();
        $c->add(sfGuardUserPeer::ID, $user_id);
        $user = sfGuardUserPeer::doSelectOne($c);
        
        if(!$user)
        {
            $this->confirm = 0;
        }
        else 
        {

            if($user->getIsConfirm()==1 && stUser::isFullAccount($user->getUsername()))
            {
                $this->confirm = 2;
            }
            else
            {
            
                if($user->getHashCode()==$hashCode)
                {
                    $user->setIsConfirm(1);
        
                    $user->save();
                    
                    $this->confirm = 1;
                    
                    stUser::loginUserOnlyUsername($user->getUsername());

                    $basket = $this->getUser()->getBasket();

                    $basket->refresh();
                    $basket->save();
                    
                    return $this->redirect('stUserData/userPanel');
                }
                else 
                {
                    $this->confirm = 0;
                }
            }
        }
    }
    
    public function executeUserWaitConfirm()
    {    
        $this->smarty = new stSmarty($this->getModuleName());
        
        $this->username = $this->getRequestParameter('user[email]');
        
        $basket = stBasket::getInstance($this->getUser());
                
        $this->show_basket = count($basket->getItems());
        
    }
    
    public function executeUserWaitConfirmRemind()
    {    
       $this->smarty = new stSmarty($this->getModuleName());
        
       $username = $this->getRequestParameter('user[email]');
                    
       $this->username = $username;
       
       $basket = stBasket::getInstance($this->getUser());
       
       $this->show_basket = count($basket->getItems());
       
       $c = new Criteria();
       $c->add(sfGuardUserPeer::USERNAME, $username);           
       $user = sfGuardUserPeer::doSelectOne($c);
       
       if($user)
       {
           if($user->getIsConfirm()==0)
           {                                                                               
               $this->sendMailWithRequestUserConfirm($user);
           }
       }
        
    }
    
    public function executeCreateNewPassword()
    {    
        
        $this->smarty = new stSmarty($this->getModuleName());
        
        $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');
        
        $hashCode = $this->getRequestParameter('hash_code');
        
        if($hashCode)
        {
            $c = new Criteria();
            $c->add(sfGuardUserPeer::HASH_CODE, $hashCode);
            $user = sfGuardUserPeer::doSelectOne($c);
            
            $this->login = $user->getUsername();
            
            $this->hashCode = $hashCode;
                    
            if ($this->getRequest()->getMethod() == sfRequest::POST)
            {
                            
                $user->setPassword($this->getRequestParameter('user[password1]'));
                
                $user->save();
                
                 
                try {
                $this->sendMailWithNewPasswordToUser($user, $this->getRequestParameter('user[password1]'));
                } catch (Exception $e)
                {
                //@todo: add to log.
                }
                
                //return $this->forward('stUser', 'confirmSendPassword?email='.$user->getUsername());
                $this->redirect('stUser/confirmSendPassword?email='.$user->getUsername());
                 
            }
        }else{
            return $this->redirect('/');
        }
    }
    
    /** 
     * Uchwyt do walidatora edycji hasła.
     */
    public function validateCreateNewPassword()
    { 
        $error_exists = false;
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
        

        $i18n = $this->getContext()->getI18N();
    
        
        $validator = new stCaptchaGDValidator();
        
        $validator->initialize($this->getContext(), array('captcha_error' => 'Wprowadzono zły numer.'));
        
        $captcha = $this->getRequestParameter('captcha');
        
        if (!$validator->execute($captcha, $error) && $this->getUser()->getAttribute('captcha_off')!=1)
        {
                $this->getRequest()->setError('captcha', $error);
                $error_exists = true;
        }else{
                $this->getUser()->setAttribute('captcha_off', true);
        }   
        
        
        }
        
        return !$error_exists;
        
    }
    
    /** 
     * Uchwyt do walidatora edycji hasła.
     */
    public function handleErrorCreateNewPassword()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        
        $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');
        
        $hashCode = $this->getRequestParameter('hash_code');
        
        $c = new Criteria();
        $c->add(sfGuardUserPeer::HASH_CODE, $hashCode);
        $user = sfGuardUserPeer::doSelectOne($c);
        
        $this->login = $user->getUsername();
        $this->hashCode = $hashCode;
        
        return sfView::SUCCESS;
    }

    
    public function executeConfirmSendPassword()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->email = $this->getRequestParameter('email');
    }

    public function executeShowPrivacy()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->webpage = WebpagePeer::getPrivacyWebpage();
    }

    public function executeShowTerms()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->webpage = WebpagePeer::getTermsWebpage();
    }
    
    public function executeShowRight2Cancel()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->webpage = WebpagePeer::getRight2CancelWebpage();
    }
}