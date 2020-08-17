<?php
/**
 * SOTESHOP/stInvoicePlugin
 *
 * Ten plik należy do aplikacji stInvoicePlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stInvoicePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 665 2009-04-16 07:43:27Z michal $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Komponent stInvoiceFrontendComponents
 *
 * @package     stInvoicePlugin
 * @subpackage  actions
 */
class stInvoiceFrontendComponents extends sfComponents
{
  public function executeRequestInvoice()
  {
       $this->smarty = new stSmarty('stInvoiceFrontend');
              
       $this->config = stConfig::getInstance($this->getContext(), 'stInvoiceBackend');        
       $this->config->setCulture(stLanguage::getOptLanguage());
       
       if ($this->getRequest()->getMethod() == sfRequest::POST && $this->getRequestParameter('submit_save'))
       {   
                   
            $userDataBillingFromRequest = $this->getRequestParameter('user_data_billing');
            
            if(@$userDataBillingFromRequest['invoice']==1)
            {
               $this->invoiceRequest = 1; 
            }
            else 
            {
                $this->invoiceRequest = 0;    
            }
       }
       else 
       {
            $this->invoiceRequest = 0;    
       }
       
  }
   
}