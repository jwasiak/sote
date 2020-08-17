<?php
/**
 * SOTESHOP/stPartnerPlugin
 *
 * Ten plik należy do aplikacji stPartnerPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPartnerPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 1858 2009-06-25 13:59:29Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Komponent stPartnerFrontendComponents
 *
 * @package     stPartnerPlugin
 * @subpackage  actions
 */
class stPartnerBackendComponents extends autoStPartnerBackendComponents
{
    public function executeConfirm()
    {                     
        $this->confirm = $this->partner->getIsConfirm();
        $this->id = $this->partner->getId();
    }
    
    Public function executeLink()
    {       
         $c = new Criteria();
         $c->add(PartnerHashPeer::PARTNER_ID , $this->getRequestParameter('partner_id'));
         $partnerHash = PartnerHashPeer::doSelectOne($c);
         $this->partner_hash = $partnerHash;
    }
    
    Public function executeProvisionStatus()
    {                    
         
         $this->provisionAll = $this->partnerProvision($this->partner->getId());
         
         $this->provisionNotPayed = $this->partnerProvision($this->partner->getId(),'0');
         
         $this->provisionPayed = $this->partnerProvision($this->partner->getId(), '1');
         
         $this->id = $this->partner->getId();
         
    }
    
    Public function executePartnerStatus()
    {                
         
         $user_id = $this->getRequestParameter('user_id');
         
         $c = new Criteria();
         
         $c->add(sfGuardUserPeer::ID , $user_id);
     
         $user = sfGuardUserPeer::doSelectOne($c);
         
         $this->user = $user;
         
         
         $c = new Criteria();
         
         $c->add(PartnerPeer::SF_GUARD_USER_ID , $user_id);
         
         $partner = PartnerPeer::doSelectOne($c);
         
         if($partner)
         {
                          
             $this->create = false;             
             
             $this->provisionAll = $this->partnerProvision($partner->getId());
             
             $this->provisionNotPayed = $this->partnerProvision($partner->getId(),'0');
             
             $this->provisionPayed = $this->partnerProvision($partner->getId(), '1');
             
             $this->partner = $partner;
         }
         else 
         {
             $this->user_id = $user_id;
             $this->create = true;       
         }
         
    }
    
    public function partnerProvision($partner_id, $payed="off")
    {              
        $c = new Criteria();
        $c->add(OrderPeer::PARTNER_ID , $partner_id);
        
        $c->addJoin(OrderStatusPeer::ID, OrderPeer::ORDER_STATUS_ID);
        
        $c->add(OrderStatusPeer::TYPE, 'ST_COMPLETE');
        
        if($payed!="off")
        {
            $c->add(OrderPeer::PROVISION_PAYED , $payed);
        }
        
        $orders = OrderPeer::doSelect($c);
        
        
               
        $provision = 0;
        
        foreach ($orders as $order)
        {
            
            $provision = $provision + $order->getProvisionValue();
        }
        
        return $provision;
    }
    
   public function executeConfigContent()
   {
        $config = stConfig::getInstance($this->getContext(), 'stPartnerBackend');
        $this->config = $config->load();    
        
   }
}