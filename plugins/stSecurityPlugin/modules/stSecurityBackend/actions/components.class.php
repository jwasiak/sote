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
 * @version     $Id: components.class.php 613 2009-04-09 12:34:35Z michal $
 */

/** 
 * Klasa stThemeBackendComponents
 *
 * @package     stRegister
 * @subpackage  actions
 */
class stSecurityBackendComponents extends sfComponents
{
    Public function executeShowUncryptUsers()
    {                       
        if(Crypt::is_mcrypt())
        {
            $c = new Criteria();
            $c->add(UserDataPeer::CRYPT, 0);
            $this->countUncryptUsers = UserDataPeer::doCount($c);
        }
        else
        {
            $this->countUncryptUsers = 0;
        }
    }
    
    Public function executeShowUncryptOrderBillingUsers()
    {    
        if(Crypt::is_mcrypt())
        {                
            $c = new Criteria();
            $c->add(OrderUserDataBillingPeer::CRYPT, 0);
            $this->countUncryptOrderBillingUsers = OrderUserDataBillingPeer::doCount($c);
        }
        else 
        {
            $this->countUncryptOrderBillingUsers = 0;
        }
    }
    
    Public function executeShowUncryptOrderDeliveryUsers()
    {   
        if(Crypt::is_mcrypt())
        {                 
            $c = new Criteria();
            $c->add(OrderUserDataDeliveryPeer::CRYPT, 0);
            $this->countUncryptOrderDeliveryUsers = OrderUserDataDeliveryPeer::doCount($c);        
        }
        else 
        {
            $this->countUncryptOrderDeliveryUsers = 0;
        }
    }
    
    
    Public function executeShowUncryptInvoiceCustomer()
    {    
        if(Crypt::is_mcrypt())
        {                
            $c = new Criteria();
            $c->add(InvoiceUserCustomerPeer::CRYPT, 0);
            $this->countUncryptInvoiceCustomer = InvoiceUserCustomerPeer::doCount($c);
        }
        else 
        {
            $this->countUncryptInvoiceCustomer = 0;
        }
    }
    
    Public function executeShowUncryptInvoiceSeller()
    {   
        if(Crypt::is_mcrypt())
        {                 
            $c = new Criteria();
            $c->add(InvoiceUserSellerPeer::CRYPT, 0);
            $this->countUncryptInvoiceSeller = InvoiceUserSellerPeer::doCount($c);        
        }
        else 
        {
            $this->countUncryptInvoiceSeller = 0;
        }
    }
    
}