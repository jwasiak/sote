<?php
/**
 * SOTESHOP/stPayNowPlugin
 *
 * Ten plik należy do aplikacji stDotpayPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPayNowPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 30807 2020-01-08 09:07:06Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa stPayNowBackendActions
 *
 * @package     stPayNowPlugin
 * @subpackage  actions
 */
class stPayNowBackendActions extends stActions
{
    public function preExecute()
    {
        stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

        parent::preExecute();
    }

    public function executeIndex()
    {
        $i18n = $this->getContext()->getI18N();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {  
            $modules = PaymentTypePeer::doSelectByModuleName('stPayNow');

            if (!$modules)
            {
                $paymentType = new PaymentType();
                $paymentType->setCulture(stLanguage::getOptLanguage());
                $paymentType->setName('Paynow');
                $paymentType->setModuleName('stPayNow');
            }
            else
            {
                $paymentType = current($modules);
            }

            $paymentType->setActive($this->config->get('enabled'));
            $paymentType->save(); 
            
            $this->config->save();
            $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));

            if ($this->hasRequestParameter('debug'))
            {
                return $this->redirect('@stPayNowPlugin?action=index&debug=1'); 
            }

            return $this->redirect('@stPayNowPlugin?action=index');
        }

        $this->labels = $this->getLabels();
    }
    
    public function validateIndex()
    {
        $this->config = stConfig::getInstance('stPayNow');

        $request = $this->getRequest();

        if ($request->getMethod() == sfRequest::POST)
        {
            $i18n = $this->getContext()->getI18N();

            $this->config->setFromRequest('config');

            if (!$this->config->get('api_key'))
            {
                $this->getRequest()->setError('config{api_key}', $i18n->__('Proszę uzupełnić pole.'));
            }

            if (!$this->config->get('api_signature_key'))
            {
                $this->getRequest()->setError('config{api_signature_key}', $i18n->__('Proszę uzupełnić pole.'));
            }

            if (!$request->hasErrors())
            {
                $api = new stPayNow();

                if (!$api->validateConfiguration())
                {
                    $request->setError('api', $i18n->__('Wystąpił błąd podczas próby połączenia się z serwisem. Proszę sprawdzić czy wprowadzone dane są poprawne i spróbować ponownie.'));
                }
            }
        }

        return !$request->hasErrors();
    }

    public function handleErrorIndex()
    {
        $this->labels = $this->getLabels();

        return sfView::SUCCESS;
    }

    public function getLabels()
    {
        $i18n = $this->getContext()->getI18n();

        return array(
            'api' => 'Paynow',
            'config{api_key}' => $i18n->__('Klucz dostępu do API'),
            'config{api_signature_key}' => $i18n->__('Klucz obliczania podpisu'),
            'config{enabled}' => $i18n->__('Włącz'),
            'config{autoredirect}' => $i18n->__('Automatyczne przekierowanie', null, 'stPayment'),
            'config{sandbox}' => $i18n->__('Tryb testowy'),
            'notify_url' => $i18n->__('Adres powiadomień'),
        );
    }
}