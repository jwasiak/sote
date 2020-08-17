<?php
/**
 * SOTESHOP/stPlatnosciPlPlugin
 *
 * Ten plik należy do aplikacji stPlatnosciPlPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPlatnosciPlPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 15168 2011-09-20 11:56:58Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPlatnosciPlBackendActions
 *
 * @package     stPlatnosciPlPlugin
 * @subpackage  actions
 */
class stPlatnosciPlBackendActions extends stActions
{
    /**
     * Wyświetla konfigurację modułu
     */
    public function executeIndex()
    {
        $this->labels = $this->getLabels();
           	
        $this->config = stConfig::getInstance($this->getContext());

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->config->setFromRequest('config');
            $data = $this->getRequestParameter('config');
            $this->config->set('configuration_check', false);
            foreach ($this->getCurrencies() as $currency)
            {
                $shortcut = $currency->getShortcut();
                $value = $this->config->get($shortcut);

                if (isset($value['enabled']) && $value['enabled'])
                {
                    $this->config->set('configuration_check', true);
                    break;
                }
            }
            $this->config->save();
            $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
        }

        $this->config->load();
    }

    public function validateIndex()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

            $data = $this->getRequestParameter('config');

            $i18n = $this->getContext()->getI18N();

            foreach ($this->getCurrencies() as $currency)
            {
                $shortcut = $currency->getShortcut();

                if (!isset($data[$shortcut]))
                {
                    continue;
                }

                $ok = true;

                if (!$data[$shortcut]['pos_id'] || !$data[$shortcut]['md5_secound_key'])
                {
                    $ok = false;
                    $this->getRequest()->setError('config{'.$shortcut.'}{currency}', $shortcut);
                }

                if (!$data[$shortcut]['pos_id'])
                {
                    $this->getRequest()->setError('config{'.$shortcut.'}{pos_id}', $i18n->__('Proszę uzupełnić pole.'));
                }

                if (!$data[$shortcut]['md5_secound_key'])
                {
                    $this->getRequest()->setError('config{'.$shortcut.'}{md5_secound_key}', $i18n->__('Proszę uzupełnić pole.'));
                }

                if ($ok)
                {
                    try
                    {
                        OpenPayU_Configuration::setEnvironment('secure');
                        OpenPayU_Configuration::setMerchantPosId($data[$shortcut]['pos_id']); // POS ID (Checkout)
                        OpenPayU_Configuration::setSignatureKey($data[$shortcut]['md5_secound_key']);
                        $order['notifyUrl'] = 'http://localhost/';
                        $order['customerIp'] = $_SERVER['REMOTE_ADDR'];
                        $order['merchantPosId'] = OpenPayU_Configuration::getMerchantPosId();
                        $order['description'] = 'New order';
                        $order['currencyCode'] = $shortcut;
                        $order['totalAmount'] = 3200;

                        $order['products'][0]['name'] = 'Product1';
                        $order['products'][0]['unitPrice'] = 3200;
                        $order['products'][0]['quantity'] = 1;
                        $result = OpenPayU_Order::create($order); 

                        if ($result->getStatus() == 'ERROR_INCONSISTENT_CURRENCIES')
                        {
                            $this->getRequest()->setError('config{'.$shortcut.'}{currency}', $shortcut);
                            $this->getRequest()->setError('config{'.$shortcut.'}{payu}', $i18n->__('Brak zgodności z walutą "sklepu" PayU (Podaj konfigurację punktu płatności zgodną z wybraną walutą lub skontaktuj się z PayU)'));
                        }
                    }
                    catch(OpenPayU_Exception_Authorization $e)
                    {
                        $this->getRequest()->setError('config{'.$shortcut.'}{currency}', $shortcut);
                        $this->getRequest()->setError('config{'.$shortcut.'}{pos_id}', $i18n->__('Podana konfiguracja punktu płatności jest nieprawidłowa'));
                        $this->getRequest()->setError('config{'.$shortcut.'}{md5_secound_key}', $i18n->__('Podana konfiguracja punktu płatności jest nieprawidłowa'));
                    }
                    catch(OpenPayU_Exception $e)
                    {
                        $this->getRequest()->setError('config{'.$shortcut.'}{currency}', $shortcut);
                        $this->getRequest()->setError('config{'.$shortcut.'}{payu}', $i18n->__('Wystąpił problem z połączeniem z usługą PayU (%%error%%)', array('%%error%%' => $e->getMessage())));
                    }
                    
                }
            }
        }
        
        return !$this->getRequest()->hasErrors();
    }   

    public function getCurrencies()
    {
        if (!isset($this->currencies))
        {
            $this->currencies = CurrencyPeer::doSelectActive();
        }

        return $this->currencies;
    }

    public function getLabels()
    {
        $i18n_posid = $this->getContext()->getI18n()->__('Id punktu płatności (pos_id)');
        $i18n_md5 = $this->getContext()->getI18n()->__('Drugi klucz (md5)');
        $i18n_curency = $this->getContext()->getI18n()->__('Waluta');

        $labels = array();

        foreach ($this->getCurrencies() as $currency) 
        {
            $shortcut = $currency->getShortcut();
            $labels['config{'.$shortcut.'}{payu}'] = 'PayU';
            $labels['config{'.$shortcut.'}{currency}'] = $i18n_curency;
            $labels['config{'.$shortcut.'}{pos_id}'] = $i18n_posid;
            $labels['config{'.$shortcut.'}{md5_secound_key}'] = $i18n_md5;
        }    

        return $labels;    
    }   

    /**
     * Akcja w przypadku błędu w uzupełnianiu pól
     */
    public function handleErrorIndex()
    {
        $this->webRequest = new stWebRequest();
        $this->config = stConfig::getInstance($this->getContext());
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->config->setFromRequest('config');
        }

        $this->labels = $this->getLabels();
        return sfView::SUCCESS;
    }
}