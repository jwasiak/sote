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
 * @version     $Id: actions.class.php 1958 2009-07-02 10:25:20Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Klasa stPartnerFrontendActions.
 *
 * @package     stPartnerPlugin
 * @subpackage  actions
 */
class stPartnerBackendActions extends autoStPartnerBackendActions
{
    public function executeAjaxValidateUrl()
    {
        $b = new sfWebBrowser(array(), 'sfFopenAdapter');

        $incorrecturl = $this->getContext()->getI18N()->__('Podany adres url nie istnieje.');

        $correcturl = $this->getContext()->getI18N()->__('Podany adres url strony jest poprawny.');
        
        try 
        {
            @$content = $b->get($this->getRequestParameter('url'));
        }
        catch(Exception $e)
        {
            return $this->renderText('<span style="color:red;">'.$incorrecturl.'</span>');
        }
        
        return $this->renderText($content->getResponseCode() != 200 ? '<span style="color:red;">'.$incorrecturl.'</span>' : '<span style="color:green;">'.$correcturl.'</span>');
    }
    
    public function executeCreateEdit()
    {
        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStPartnerBackend/create_forward_parameters');

        $this->partner = $this->getCreatePartnerOrCreate();

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
                       
            $this->updateCreatePartnerFromRequest();

            $this->saveCreatePartner($this->partner);
            
            $hash = md5($this->partner->getId());
            
            $partnerHash = new PartnerHash();
            
            $partnerHash->setPartnerId($this->partner->getId());
            $partnerHash->setHash($hash);
            $partnerHash->save();
            
            if (!$this->hasFlash('notice'))
            {
                $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
            }
            if ($this->getRequestParameter('save_and_add'))
            {
                return $this->redirect('stPartnerBackend/createCreate');
            }
            else if ($this->getRequestParameter('save_and_list'))
            {
                return $this->redirect('stPartnerBackend/createList');
            }
            else
            {
                return $this->redirect('stPartnerBackend/edit?id='.$this->partner->getId());
            }
        }
        else
        {
            $this->labels = $this->getCreateLabels();
        }
    }
    
    public function executeOrderList()
    {
        parent::executeOrderList();
        
        $this->pager->getCriteria()->add(OrderPeer::PARTNER_ID, $this->forward_parameters['partner_id']);
        
        $this->pager->getCriteria()->add(OrderPeer::PARTNER_ID, $this->forward_parameters['partner_id']);
        
        $this->pager->getCriteria()->addJoin(OrderStatusPeer::ID, OrderPeer::ORDER_STATUS_ID);
        
        $this->pager->getCriteria()->add(OrderStatusPeer::TYPE, 'ST_COMPLETE');
        
        $this->pager->init();
    }
    
    public function executeUpdateConfirm()
    {
        $partner_id = $this->getRequestParameter('id');
        
        $c = new Criteria();
        $c->add(PartnerPeer::ID, $partner_id);
        $partnerData = PartnerPeer::doSelectOne($c);
                
        $partnerData->setIsConfirm(1);
        $partnerData->save();
        
        $this->sendConfirmPartnerMail($partnerData);
        
        return $this->redirect('stPartnerBackend/edit?id='.$partnerData->getId());
        
    }
    
    public function executeCreateAccount()
    {
    
        $user_id = $this->getRequestParameter('user_id');
        
        $partnerData = new Partner();
        
        $partnerData->setSfGuardUserId($user_id);
        
        $c = new Criteria();
        $c->add(UserDataPeer::SF_GUARD_USER_ID, $user_id);
        $c->add(UserDataPeer::IS_DEFAULT , 1);
        $c->add(UserDataPeer::IS_BILLING , 1);
        if ($userDataBillingDefault = UserDataPeer::doSelectOne($c))
        {
            $partnerData->setCompany($userDataBillingDefault->getCompany());
            $partnerData->setName($userDataBillingDefault->getName());
            $partnerData->setSurname($userDataBillingDefault->getSurname());
            $partnerData->setStreet($userDataBillingDefault->getStreet());
            $partnerData->setHouse($userDataBillingDefault->getHouse());
            $partnerData->setFlat($userDataBillingDefault->getFlat());
            $partnerData->setCode($userDataBillingDefault->getCode());
            $partnerData->setTown($userDataBillingDefault->getTown());
            $partnerData->setCountries($userDataBillingDefault->getCountries());
            $partnerData->setPhone($userDataBillingDefault->getPhone());
            $partnerData->setVatNumber($userDataBillingDefault->getVatNumber());
        }
        $partnerData->setIsActive(1);
        $partnerData->setIsConfirm(0);
        $partnerData->save();
        
        $hash = md5($user_id);
        
        $partnerHash = new PartnerHash();
        
        $partnerHash->setPartnerId($partnerData->getId());
        $partnerHash->setHash($hash);
        $partnerHash->save();
        
        return $this->redirect('stPartnerBackend/edit?id='.$partnerData->getId());
    }
    
    public function executeSaveConfigContent()
    {
       
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $updateConfig = $this->getRequestParameter('config');

            $this->config = stConfig::getInstance($this->getContext(), 'stPartnerBackend');

            $this->config->load();
            
            if(isset($updateConfig['is_active'])){
                $this->config->set('is_active',$updateConfig['is_active']);
            }
            else 
            {
                $this->config->set('is_active',0);
            }

            if(isset($updateConfig['cookie_day_expire'])){
                $this->config->set('cookie_day_expire',$updateConfig['cookie_day_expire']);
            }

            $this->config->save();

            $this->redirect('stPartnerBackend/configCustom');

            $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
        }
    }
    
    /** 
    * Obsługuje wysyłanie mail'i
    */
    function sendConfirmPartnerMail($partnerData)
    {
        $mail_error = $this->MailWithConfirmPartnerToUser($partnerData);
        
        return $mail_error;
    }
    
    /** 
    * Wysyła mail z prośbą o autoryzajcę
    */
    function mailWithConfirmPartnerToUser($partnerData)
    {
        $c = new Criteria();
        
        $c->add(sfGuardUserPeer::ID, $partnerData->getSfGuardUserId());           
           
        $user = sfGuardUserPeer::doSelectOne($c);
        
        
        $mailHtmlHead = stMailer::getHtmlMailDescription("header");
                
        $mailHtmlFoot = stMailer::getHtmlMailDescription("footer");
        
        $mailHtmlHeadContent = stMailer::getHtmlMailDescription("top_partner_confirm");
        
        $mailHtmlFootContent = stMailer::getHtmlMailDescription("bottom_partner_confirm");
        
        $sendConfirmPartnerMailToUserHtmlMailMessage = stMailTemplate::render('sendConfirmPartnerMailToUserHtml', array(
        
        'user' => $user,
        'head' => $mailHtmlHead,
        'foot' => $mailHtmlFoot,
        'partnerData' => $partnerData,
        
        'head_content' => $mailHtmlHeadContent,
        'foot_content' => $mailHtmlFootContent,
        ));
            
        
        
        //$sendConfirmPartnerMailToUserPlainMailMessage = stMailTemplate::render('sendConfirmPartnerMailToUserPlain');
        
        $mail = stMailer::getInstance();
        $verified_account = $this->getContext()->getI18N()->__('Zweryfikowano konto partnerskie.');
        return $mail->setSubject($this->getRequest()->getHost() . ' - ' . $verified_account)->setHtmlMessage($sendConfirmPartnerMailToUserHtmlMailMessage)->setTo($user->getUsername())->sendToClient();
    
    }
}