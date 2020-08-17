<?php

/**
 * SOTESHOP/stMailPlugin
 *
 * Ten plik należy do aplikacji stMailPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stMailPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 12185 2011-04-13 11:31:16Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa stMailAccountBackendActions
 *
 * @package     stMailPlugin
 * @subpackage  actions
 */
class stMailAccountBackendActions extends autostMailAccountBackendActions
{

   public function validateEdit()
   {
      $error_exist = false;

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $mail_account = $this->getRequestParameter('mail_account');

         $validator = new sfEmailValidator();

         $validator->initialize($this->getContext(), array('check_domain' => true, 'email_error' => 'Podany adres e-mail posiada nieprawidłowy format lub nie istnieje...'));

         if (!$validator->execute($mail_account['email'], $error))
         {
            $this->getRequest()->setError('mail_account{email}', $error);
            $error_exist = true;
         }

         if (empty($mail_account['username']))
         {
            $this->getRequest()->setError('mail_account{username}', 'Brak użytkownika...');
            $error_exist = true;
         }

         if (empty($mail_account['password']))
         {
            $this->getRequest()->setError('mail_account{password}', 'Brak hasła...');
            $error_exist = true;
         }

         if (!$this->getRequest()->hasErrors())
         {
            $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend'); 
             
            $smtp_profile = MailSmtpProfilePeer::retrieveByPK($mail_account['mail_smtp_profile_id']);

            $mailHead = stMailer::getHtmlMailDescription("header");

            $mailFoot = stMailer::getHtmlMailDescription("footer");

            $htmlMailMessage = stMailTemplate::render('confirmSend', array('mail' => $mail_account['email'], 'head' => $mailHead, 'foot' => $mailFoot, 'mail_config'=>$mail_config));

            if ($mail_account['name'])
            {
               $sender = array($mail_account['email'] => $mail_account['name']);
            }
            else
            {
               $sender = $mail_account['email'];
            }
            
            $mail = stMail::getInstance()->setSmtpConnection($sender, $smtp_profile->getHost(), $smtp_profile->getPort(), $mail_account['username'], $mail_account['password'], $smtp_profile->getEncType());

            $mail->setTo($mail_account['email']);

            $mail->setSubject($this->getContext()->getI18N()->__('Konfiguracja e-mail - sklep').' ')->setHtmlMessage($htmlMailMessage);

            if (!$mail->send())
            {
               $this->getRequest()->setError('send_error', 'Wystąpił błąd podczas wysyłania wiadomości weryfikującej konto e-mail, sprawdź czy poniższe dane są prawidłowe...');
               $error_exist = true;
            }
            else
            {
               $flash_text = $this->getContext()->getI18N()->__('Twoje zmiany zostały zapisane - odbierz e-mail weryfikacyjny wysłany na adres');
               $this->setFlash('notice', $flash_text.' "'.$mail_account['email'].'"');
            }
         }
      }

      return!$error_exist;
   }

   protected function getLabels()
   {
      $labels = parent::getLabels();
      $labels['send_error'] = '';
      return $labels;
   }
   
  protected function updateConfigFromRequest()
  {
    $config = $this->getRequestParameter('config');
    
      if ($this->getRequest()->getFileSize('config[logo]'))
      {
         $currentFile = sfConfig::get('sf_upload_dir') . $this->config->get('logo'); 
          
         $fileName = md5($this->getRequest()->getFileName('config[logo]') . time() . rand(0, 99999));
         $ext = $this->getRequest()->getFileExtension('config[logo]');
         
        if($ext==".jpg" || $ext==".jpeg" || $ext==".JPEG" || $ext==".JPG" || $ext==".gif" || $ext==".png" || $ext==".PNG"){
         
             if (is_file($currentFile))
             {
                unlink($currentFile);
             }
            
             $this->config->set('logo', "/picture/". $fileName . $ext, false);
             $this->getRequest()->moveFile('config[logo]', sfConfig::get('sf_upload_dir') . $this->config->get('logo'));
         }
         
      }

    //$this->config->set('logo', $config['logo'], false);
    $this->config->set('bg_header_color', $config['bg_header_color'], false);
    $this->config->set('bg_footer_color', $config['bg_footer_color'], false);
    $this->config->set('bg_action_color', $config['bg_action_color'], false);
    $this->config->set('bg_action_link_color', $config['bg_action_link_color'], false);
    $this->config->set('link_color', $config['link_color'], false);
     
  }  

}