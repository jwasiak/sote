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
 * @version     $Id: components.class.php 12239 2011-04-14 11:47:41Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/** 
 * Komponent stNewsletterFrontendComponents
 *
 * @package     stNewsletterPlugin
 * @subpackage  actions
 */
class stNewsletterFrontendComponents extends sfComponents
{
    public function executeNewsletter()
    {
        $this->smarty = new stSmarty('stNewsletterFrontend');

        $this->config = stConfig::getInstance('stNewsletterBackend');
        
        if ($this->config->get('newsletter_enabled')==1)
        {        
            return sfView::NONE;   
        }

        $newsletterConfig = $this->config->load();
        
        $this->newsletter_config = $newsletterConfig;
		
        if($this->getUser()->isAuthenticated())
        {
            $this->loginUser = 1;
            
            $c = new Criteria();
            $c->add(NewsletterUserPeer::SF_GUARD_USER_ID, $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
            $newsletterUser = NewsletterUserPeer::doSelectOne($c);
            
            if($newsletterUser)
            {
                $this->new_user = 0;
            }
            else
            {
                $this->new_user = 1;
            }
			    
        }
        else
        {
            $this->loginUser = 0;
			
        }
    }
    
    public function executeRequestNewsletter()
    {
       $this->smarty = new stSmarty('stNewsletterFrontend');
              
       $this->config = stConfig::getInstance('stNewsletterBackend');  

        if ($this->config->get('newsletter_enabled'))
        {        
            return sfView::NONE;   
        }     
       
       if ($this->getRequest()->getMethod() == sfRequest::POST && $this->getRequestParameter('submit_save'))
       {   
                   
            $userDataBillingFromRequest = $this->getRequestParameter('user_data_billing');
            
            if(@$userDataBillingFromRequest['newsletter']==1)
            {
               $this->newsletterRequest = 1; 
            }
            else 
            {
                $this->newsletterRequest = 0;    
            }
       }
       else 
       {
            $this->newsletterRequest = 0;    
       }
       
    }
}