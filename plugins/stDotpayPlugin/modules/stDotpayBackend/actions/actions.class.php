<?php
/**
 * SOTESHOP/stDotpayPlugin
 *
 * Ten plik należy do aplikacji stDotpayPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stDotpayPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 7193 2010-08-02 12:43:35Z marek $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stDotpayBackendActions
 *
 * @package     stDotpayPlugin
 * @subpackage  actions
 */
class stDotpayBackendActions extends stActions
{
    public function executeIndex()
    {
        $this->stDotpay = new stDotpay();

        $i18n = $this->getContext()->getI18N();
        $this->config = stConfig::getInstance($this->getContext(), array('culture' => $this->getRequestParameter('culture', stLanguage::getOptLanguage())));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        { 
            $this->config->setFromRequest('config');
            $this->config->save();
            $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
        }
        $this->config->load();

        $this->labels = $this->getLabels();
    }
    
    public function validateIndex()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
        }
    
        return true;
    }

    public function handleErrorIndex()
    {
        $this->stDotpay = new stDotpay();

        $this->config = stConfig::getInstance($this->getContext());

        $this->labels = $this->getLabels();

        return sfView::SUCCESS;
    }

    public function getLabels()
    {
        return array('config{dotpay_id}' => 'Identyfikator', 'config{pin}' => 'Numer PIN do weryfikacji płatności');
    }
}