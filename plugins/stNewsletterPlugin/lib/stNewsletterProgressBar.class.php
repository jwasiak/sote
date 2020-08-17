<?php

class stNewsletterProgressBar
{
   public function init()
   {
   }

   public function close()
   {
      $i18n = sfContext::getInstance()->getI18N();

      $id = self::getParam('id');

      sfLoader::loadHelpers(array('Helper', 'stPartial'));

      $newsletter = NewsletterMessagePeer::retrieveByPK($id);

      $newsletter->setSentAt(time());

      $newsletter->save();

      $message = st_get_partial('stNewsletterBackend/progress_success', array('steps' => self::getAttribute('steps'), 'id' => $id));

      $this->setMessage($message);

      sfContext::getInstance()->getUser()->getAttributeHolder()->removeNamespace('soteshop/stNewsletterProgressBar');
   }
   
    public function getTitle(){
        $i18n = sfContext::getInstance() -> getI18N();
        $title = $i18n -> __('Wysyłanie wiadomości', null, 'stNewsletterBackend');
        return $title;
    }
    
   public function send($offset) {
        
        $config = stConfig::getInstance(sfContext::getInstance(), 'stNewsletterBackend');
        $newsletter = NewsletterMessagePeer::retrieveByPK(self::getParam('id'));
        
        $i18n = sfContext::getInstance() -> getI18N();
        
        $c = new Criteria();
        $c->add(MailAccountPeer::IS_NEWSLETTER, 1);
        $newsletterMailAccount = MailAccountPeer::doSelectOne($c);

        $c = new Criteria();

        $c -> setOffset($offset);

        $c -> setLimit(100);

        $newsletterUsers = $newsletter -> getUsers($c);

        $usersArray = array();
        $usersCultureArray = array();

        foreach ($newsletterUsers as $key => $user) {

            $userCulture = $user -> getLanguage();

            if (!$user -> getLanguage()) {
                $userCulture = $config->get('newsletter_default_culture', null, false);
            }

            $usersArray[$userCulture][] = $user;
        }

        ksort($usersArray);
        
        foreach ($usersArray as $key => $users) {
            
            $mailer = stMailer::getInstance();
            $mailer->initialize();

            $newsletter -> setCulture($key);
            $config->setCulture($key);
            
            $templates = $config->get('templates', null, true);
            
            $templates = preg_replace('/{HOST}/', sfContext::getInstance()->getRequest()->getHost(), $templates);
            $templates = preg_replace('/{NEWSLETTER_CONTENT}/', $newsletter->getContent(), $templates);
            $templates = preg_replace('/{LINK_TO_UNSUBSCRIBE}/', 'http://'.sfContext::getInstance()->getRequest()->getHost().'/newsletter/unsubscribe', $templates);    
            
            $html = $templates;

            $plain = stMailTemplate::render('stNewsletterBackend/messagePlain', array('newsletter' => $newsletter));

            if($newsletterMailAccount){
                $mailer->setSubject($newsletter->getSubject())->setAccount($newsletterMailAccount->getEmail())->setHtmlMessage($html)->setPlainMessage($plain);      
            }else{
                $mailer->setSubject($newsletter->getSubject())->setHtmlMessage($html)->setPlainMessage($plain);  
            }
                         
            $counter = 0;
            
            foreach ($users as $user) {
                $counter++;
                
                try {
                    $mailer -> addBcc($user -> getEmail());
                } catch(Swift_RfcComplianceException $e) {
                    
                }

                if ($counter == 20) {
                    $mailer -> send();

                    $mailer -> setBcc(array());

                    $counter = 0;

                    usleep(200000);
                }
                
            }
            
            if ($counter > 0) {
                $mailer -> send();
            }
        }
        
        self::setMessage($i18n -> __('Wysyłanie wiadomości w toku %current%/%from%', array('%current%' => $offset, '%from%' => self::getAttribute('steps')), 'stNewsletterBackend'));

        sleep(1);

        return $offset + count($newsletterUsers);
    } 

  

   public static function setParam($name, $value)
   {
      sfContext::getInstance()->getUser()->setAttribute($name, $value, 'soteshop/stNewsletterProgressBar');
   }

   public static function getParam($name, $default = null)
   {
      return sfContext::getInstance()->getUser()->getAttribute($name, $default, 'soteshop/stNewsletterProgressBar');
   }

   public static function getAttribute($name)
   {
      $attributes = sfContext::getInstance()->getUser()->getAttribute('stNewsletter', array(), 'soteshop/stProgressBarPlugin');

      return isset($attributes[$name]) ? $attributes[$name] : null;
   }

   public static function setMessage($message)
   {
      sfContext::getInstance()->getUser()->setAttribute('stProgressBar-stNewsletter', $message, 'symfony/flash');
   }
}