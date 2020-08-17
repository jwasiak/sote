<?php
/**
 * SOTESHOP/stInBankPlugin
 *
 * Ten plik należy do aplikacji stInBankPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stInBankPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 15168 2011-09-20 11:56:58Z michal $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa stInBankBackendActions
 *
 * @package     stInBankPlugin
 * @subpackage  actions
 */
class stInBankBackendActions extends stActions
{
    /**
     * Wyświetla konfigurację modułu
     */
    public function executeIndex()
    {
        $this->labels = $this->getLabels();
           	
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->config->save();
            
            if (!stInBank::hasPaymentType())
            {
                $activeGateway = new PaymentType();
                $activeGateway->setActive(true);
                $activeGateway->setCulture(stLanguage::getOptLanguage());
                $activeGateway->setName('RATY Inbank');
                $activeGateway->setModuleName('stInBank');
                $activeGateway->save(); 
            } 

            stTheme::clearSmartyCache(true);

            $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
        }
    }

    public function validateIndex()
    {
        $this->config = stConfig::getInstance('stInBank');

        $payments = appBlueMedia::getPayments(false);

        $ok = true;

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

            $i18n = $this->getContext()->getI18N();

            if (stTheme::getInstance($this->getContext())->getVersion() < 7)
            {
                $this->getRequest()->setError('api', $i18n->__('Funkcjonalność dostępna tylko i wyłącznie dla nowych tematów responsywnych'));
                return false;
            } 

            $data = $this->getRequestParameter('config');

            // if (stTheme::getInstance($this->getContext())->getVersion() < 7)
            // {
            //     $this->getRequest()->setError('api', $i18n->__('Funkcjonalność dostępna tylko i wyłącznie dla nowych tematów responsywnych'));
            //     $ok = false;
            // } 

            if (!$data['api_key'])
            {
                $this->getRequest()->setError('config{api_key}', $i18n->__('Proszę uzupełnić pole.'));
            }

            if (!$data['product_code'])
            {
                $this->getRequest()->setError('config{product_code}', $i18n->__('Proszę uzupełnić pole.'));
            }

            if (!$data['uuid'])
            {
                $this->getRequest()->setError('config{uuid}', $i18n->__('Proszę uzupełnić pole.'));
            }

            $this->config->setFromRequest('config');

            if (!$this->getRequest()->hasErrors())
            {
                if (!stInBank::validateCredentials($data['product_code'], $data['uuid'], $data['api_key'], isset($data['sandbox']))) 
                {
                    $this->getRequest()->setError('api', $i18n->__('Wystąpił błąd podczas próby połączenia się z serwisem. Proszę sprawdzić czy wprowadzone dane są poprawne i spróbować ponownie.'));
                }

                $this->config->set('configuration_check', true);
            }
        }

        return !$this->getRequest()->hasErrors();
    }   

    public function getLabels()
    {
        return array(
            'config{uuid}' => 'UUID',
            'config{product_code}' => $this->getContext()->getI18n()->__('Kod produktu'),
            'config{api_key}' => $this->getContext()->getI18n()->__('Klucz API'),
            'api' => 'Inbank',
        );   
    }   

    /**
     * Akcja w przypadku błędu w uzupełnianiu pól
     */
    public function handleErrorIndex()
    {        
        $this->labels = $this->getLabels();
        
        return sfView::SUCCESS;
    }
}