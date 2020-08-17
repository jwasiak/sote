<?php
/** 
 * SOTESHOP/stRegister 
 * 
 * Ten plik należy do aplikacji stRegister opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stRegister
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 251 2009-03-30 11:35:06Z marek $
 */

class stRemindPasswordComponents extends sfComponents
{
   public function executeRemind()
   {
      
   }
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

    public function executeRemindPassword()
    {
        $this->send_true = 0;

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {

            $c = new Criteria();
            $c->add(sfGuardUserPeer::USERNAME , $this->getRequestParameter('remind[email]'));
            $user = sfGuardUserPeer::doSelectOne($c);

            if($user)
            {
                $c = new Criteria();

                $c->add(sfGuardGroupPeer::NAME , 'admin');
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
                     
                       $this->sendLinkToChangePasswordMail($this->getRequestParameter('remind[email]'), $user->getHashCode());
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
        'date' => date("Y-m-d H:i:s")

        ));

        $mailPlainHead = stMailer::getPlainMailDescription("header");

        $mailPlainFoot = stMailer::getPlainMailDescription("footer");

        $sendLinkToPasswordToUserPlainMailMessage = stMailTemplate::render('sendLinkToPasswordToUserPlain', array(
        'user' => $user,
        'hashCode' => $hashCode,
        'head' => $mailPlainHead,
        'foot' => $mailPlainFoot,
        'date' => date("Y-m-d H:i:s")
        ));        

        $mail = stMailer::getInstance();
        return $mail->setSubject($this->getRequest()->getHost().' - '.__('Link do zmiany hasła dla konta').": ".$user)->setHtmlMessage($sendLinkToPasswordToUserHtmlMailMessage)->setPlainMessage($sendLinkToPasswordToUserPlainMailMessage)->setTo($user)->sendToClient();

    }


    /**
     * Uchwyt do walidatora edycji hasła.
     */
    public function handleErrorRemindPassword()
    {

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

            if (!$validator->execute($captcha, $error))
            {
                $this->getRequest()->setError('captcha', $error);

                $error_exists = true;
            }


            $c = new Criteria();
            $c->add(sfGuardUserPeer::USERNAME , $this->getRequestParameter('remind[email]'));
            $user = sfGuardUserPeer::doSelectOne($c);

            if($user)
            {
                $c = new Criteria();

                $c->add(sfGuardGroupPeer::NAME , 'admin');
                $idUserGroupAdmin = sfGuardGroupPeer::doSelectOne($c);

                $c = new Criteria();
                $c->add(sfGuardUserGroupPeer::USER_ID , $user->getId());
                $c->add(sfGuardUserGroupPeer::GROUP_ID , $idUserGroupAdmin->getId());
                $userGroup = sfGuardUserGroupPeer::doSelectOne($c);

                if(!$userGroup)
                {

                    $this->getRequest()->setError('remind{email}', $i18n->__('Nie ma takiego administratora.'));
                    $error_exists = true;

                }
            }
            else
            {
                    $this->getRequest()->setError('remind{email}', $i18n->__('Nie ma takiego administratora.'));
                    $error_exists = true;
            }


        }
        return !$error_exists;
    }

}
?>