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
class stPartnerFrontendActions extends stActions
{
    
    public function executeAjaxValidateUrl()
    {
        $b = new sfWebBrowser(array(), 'sfFopenAdapter');
        try 
        {
            @$content = $b->get($this->getRequestParameter('url'));
        }
        catch(Exception $e)
        {
            return $this->renderText('<span style="color:red;">Podany adres url nie istnieje.</span>');  
        }
        
        return $this->renderText($content->getResponseCode() != 200 ? '<span style="color:red;">Podany adres url nie istnieje.</span>' : '<span style="color:green;">Podany adres url strony jest poprawny.</span>');
    }
    
    public function executeIndex()
    {
        $c = new Criteria();
       
        $c->add(PartnerPeer::SF_GUARD_USER_ID, $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
        $this->partnerData = PartnerPeer::doSelectOne($c);
         
        if ($this->getController()->getTheme()->getVersion() > 1)
        {
            $this->getController()->getTheme()->setLayoutName("one_column_layout");
        }
        
    }
    
    public function executeSavePartner()
    {
            
        $partnerDataFromRequest = $this->getRequestParameter('partner_data');
        
        $partnerData = new Partner();
        
        $partnerData->setSfGuardUserId($partnerDataFromRequest['user_id']);
        $partnerData->setCompany($partnerDataFromRequest['company']);
        $partnerData->setName($partnerDataFromRequest['name']);
        $partnerData->setSurname($partnerDataFromRequest['surname']);
        $partnerData->setStreet($partnerDataFromRequest['street']);
        $partnerData->setHouse($partnerDataFromRequest['house']);
        $partnerData->setFlat($partnerDataFromRequest['flat']);
        $partnerData->setCode($partnerDataFromRequest['code']);
        $partnerData->setTown($partnerDataFromRequest['town']);
        $partnerData->setCountriesId($partnerDataFromRequest['country']);
        $partnerData->setPhone($partnerDataFromRequest['phone']);
        $partnerData->setVatNumber($partnerDataFromRequest['vatNumber']);
        $partnerData->setBankNumber($partnerDataFromRequest['bankNumber']);
        $partnerData->setDescription($partnerDataFromRequest['description']);
        $partnerData->setIsActive(1);
        $partnerData->setIsConfirm(0);
        $partnerData->save();
        
        $hash = md5($partnerDataFromRequest['user_id']);
        
        $partnerHash = new PartnerHash();
        
        $partnerHash->setPartnerId($partnerData->getId());
        $partnerHash->setHash($hash);
        $partnerHash->save();
        
        $this->SendRegisterPartnerMail($partnerData);
        
        $this->forward('stPartnerFrontend', 'index');
        
    }
    
    /** 
    * Obsługuje wysyłanie mail'i
    */
    function SendRegisterPartnerMail($partnerData)
    {
        $mail_error = $this->MailWithRegisterPartnerToAdmin($partnerData);
        
        return $mail_error;
    }
    
    /** 
    * Wysyła mail z prośbą o autoryzajcę
    */
    function mailWithRegisterPartnerToAdmin($partnerData)
    {
        
        $sendRegisterPartnerToAdminHtmlMailMessage = stMailTemplate::render('sendRegisterPartnerToAdminHtml', array('partnerData' => $partnerData));
        
        $sendRegisterPartnerToAdminPlainMailMessage = stMailTemplate::render('sendRegisterPartnerToAdminPlain', array('partnerData' => $partnerData));
        
        $mail = stMailer::getInstance();
        return $mail->setSubject($this->getRequest()->getHost() . ' - Prośba o weryfikacje konta partnerskiego.')->setHtmlMessage($sendRegisterPartnerToAdminHtmlMailMessage)->setPlainMessage($sendRegisterPartnerToAdminPlainMailMessage)->sendToMerchant();
    
    }
    
    
    
     /** 
     * Uchwyt do walidatora tworzenia konta.
     *
     * @return   string
     */
    public function handleErrorSavePartner()
    {              
        return $this->forward('stPartnerFrontend', 'index');
    }
    
}