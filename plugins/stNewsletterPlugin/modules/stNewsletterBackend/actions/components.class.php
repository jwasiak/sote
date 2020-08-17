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
 * @version     $Id: components.class.php 12207 2011-04-13 12:12:14Z marcin $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Komponent stNewsletterFrontendComponents
 *
 * @package     stNewsletterPlugin
 * @subpackage  actions
 */
class stNewsletterBackendComponents extends autoStNewsletterBackendComponents
{

   public function executeNewsletterGroup()
   {
      $this->groups = NewsletterGroupPeer::doSelect(new Criteria());

      if (isset($this->newsletter_message))
      {
         if ($this->getRequest()->getMethod() == sfRequest::POST)
         {
            $checked = $this->getRequestParameter('newsletter_message[newsletter_group]');
         }
         else
         {
            $checked = NewsletterMessagePeer::getAssignedById($this->newsletter_message->getId());
         }
      }
      else
      {
         if ($this->getRequest()->getMethod() == sfRequest::POST)
         {
            $checked = $this->getRequestParameter('newsletter_user[newsletter_group]');
         }
         else
         {
            $checked = NewsletterUserPeer::getAssignedById($this->newsletter_user->getId());
         }
      }

      $this->checked = $checked;
   }
   
    /**
     * Wyświetlanie wyboru języków 
     */
    public function executeShowLanguages()
    {
        
        $c = new Criteria();
        $languages = LanguagePeer::doSelect($c);
        
        
        $arrayLanguage = array();
        
        foreach($languages as $language){
            $arrayLanguage[$language->getOriginalLanguage()] = $language->getOptName(); 
        } 
        
        $this->languages  = $arrayLanguage;
    }
    
    /**
     * Wyświetlanie wyboru języków 
     */
    public function executeUserShowLanguages()
    {
        
        $c = new Criteria();
        $languages = LanguagePeer::doSelect($c);
        
        $arrayLanguage = array();
        
        $arrayLanguage['none']= $this->getContext()->getI18N()->__('Brak'); 
        foreach($languages as $language){
            $arrayLanguage[$language->getOriginalLanguage()] = $language->getOptName(); 
        } 
        $config = stConfig::getInstance($this->getContext(), 'stNewsletterBackend');
        
        $this->languages  = $arrayLanguage;
        $this->defaultLanguages = $config->get('newsletter_default_culture');
    }

}