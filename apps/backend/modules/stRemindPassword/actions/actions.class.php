<?php
/** 
 * SOTESHOP/stRegister 
 * 
 * Ten plik należy do aplikacji stRegister opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stRegister
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 1885 2009-06-26 13:15:49Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/** 
 * Modul prezentujacy mozliwosci klasy stRegister
 *
 * @package     stRegister
 * @subpackage  actions
 */
class stRemindPasswordActions extends stActions
{

    public function executeCreateNewPassword()
    {

        $this->passwordChange = 0;
        $hashCode = $this->getRequestParameter('hash_code');

        if($hashCode)
        {
            $c = new Criteria();
            $c->add(sfGuardUserPeer::HASH_CODE, $hashCode);
            $user = sfGuardUserPeer::doSelectOne($c);

            if($user)
            {

            $this->login = $user->getUsername();

            $this->hashCode = $hashCode;

                if ($this->getRequest()->getMethod() == sfRequest::POST)
                {

                    $user->setPassword($this->getRequestParameter('remind[password1]'));

                    $user->save();

                    $this->passwordChange = 1;

                    //return $this->forward('stUser', 'confirmSendPassword');

                }
            }
            else
            {
                return $this->redirect('/');
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
    public function handleErrorCreateNewPassword()
    {

        $hashCode = $this->getRequestParameter('hash_code');

        $c = new Criteria();
        $c->add(sfGuardUserPeer::HASH_CODE, $hashCode);
        $user = sfGuardUserPeer::doSelectOne($c);

        $this->login = $user->getUsername();
        $this->hashCode = $hashCode;
        $this->passwordChange = 0;

        return sfView::SUCCESS;
    }

    public function executeRemind()
    {
        $this->send = false;

        $this->setLayout(false);

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {

            $email = $this->getRequestParameter('remind_email');

            $c = new Criteria();
            $c->add(sfGuardUserPeer::USERNAME , $email);
            $this->user = sfGuardUserPeer::doSelectOne($c);

            if($this->user)
            {
               if($this->user->getHashCode()=="")
               {
                  $this->user->setHashCode(md5(microtime()));
                  $this->user->save();
               }

               $this->send = $this->sendLinkToChangePasswordMail($email, $this->user->getHashCode());
            }
            else
            {
               $this->send = false;
            }
        }
    }

     /**
     * Obsługuje wysyłanie mail'i
     */
    function sendLinkToChangePasswordMail($user, $hashCode)
    {
        $mail_error = $this->mailWithLinkToChangePassword($user, $hashCode);
        return $mail_error;
    }

     /**
     * Wysyła mail z zamówieniem do administratora
     */
    function mailWithLinkToChangePassword($user, $hashCode)
    {

        $mailHtmlHead = stMailer::getHtmlMailDescription("header");

        $mailHtmlFoot = stMailer::getHtmlMailDescription("footer");

        $sendLinkToPasswordToUserHtmlMailMessage = stMailTemplate::render('sendLinkToPasswordToUserHtml', array(
        'user' => $user,
        'hashCode' => $hashCode,
        'head' => $mailHtmlHead,
        'foot' => $mailHtmlFoot,
        'date' => date("d/m/Y")

        ));

        $mailPlainHead = stMailer::getPlainMailDescription("header");

        $mailPlainFoot = stMailer::getPlainMailDescription("footer");

        $sendLinkToPasswordToUserPlainMailMessage = stMailTemplate::render('sendLinkToPasswordToUserPlain', array(
        'user' => $user,
        'hashCode' => $hashCode,
        'head' => $mailPlainHead,
        'foot' => $mailPlainFoot,
        'date' => date("d/m/Y")
        ));        

        $mail = stMailer::getInstance();
        return $mail->setSubject($this->getRequest()->getHost().' - '.__('Link do zmiany hasła dla konta').": ".$user)->setHtmlMessage($sendLinkToPasswordToUserHtmlMailMessage)->setPlainMessage($sendLinkToPasswordToUserPlainMailMessage)->setTo($user)->sendToClient();

    }

    public function executeAjaxShow()
    {
      sfLoader::loadHelpers(array('Helper', 'stPartial'));

      $form = st_get_component('stRemindPassword', 'remind');

      return $this->renderText($form);      
    }


    /**
     * Uchwyt do walidatora edycji hasła.
     */
    public function handleErrorRemind()
    {
      return $this->executeAjaxShow();
    }

    /**
     * Uchwyt do walidatora edycji hasła.
     */
    public function validateRemind()
    {
        $error_exists = false;

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {

            $i18n = $this->getContext()->getI18N();

            $validator = new stCaptchaGDValidator();

            $validator->initialize($this->getContext(), array('captcha_error' => 'Wprowadzono zły numer.'));

            $captcha = $this->getRequestParameter('remind_captcha');

            if (!$validator->execute($captcha, $error))
            {
                $this->getRequest()->setError('remind_captcha', $error);

                $error_exists = true;
            }

            $c = new Criteria();

            $c->add(sfGuardUserPeer::USERNAME , $this->getRequestParameter('remind_email'));

            $user = sfGuardUserPeer::doSelectOne($c);

            if(null === $user || !$user->hasGroup('admin'))
            {
              $this->getRequest()->setError('remind_email', $i18n->__('Nie ma takiego administratora.'));
              $error_exists = true;
            }

        }

        return !$error_exists;
    }


}