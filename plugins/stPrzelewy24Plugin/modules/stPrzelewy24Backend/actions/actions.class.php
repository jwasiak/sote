<?php
/**
 * SOTESHOP/stPrzelewy24Plugin
 *
 * Ten plik należy do aplikacji stPrzelewy24Plugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPrzelewy24Plugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 10909 2011-02-09 09:43:43Z pawel $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPrzelewy24BackendActions
 *
 * @package     stPrzelewy24Plugin
 * @subpackage  actions
 */
class stPrzelewy24BackendActions extends stActions
{
    /**
     * Wyświetla konfigurację modułu
     */
    public function executeIndex()
    {
    	$context = $this->getContext();
    	
        $this->config = stConfig::getInstance('stPrzelewy24Backend');

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->config->setFromRequest('config');
            $this->config->save();
            $this->setFlash('notice', $context->getI18n()->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
        }
        $this->labels = $this->getLabels();
    }

    protected function getLabels()
    {
        $i18n = $this->getContext()->getI18n();

        return array(
            'config{przelewy24_id}' => $i18n->__('Id sprzedawcy'),
            'config{salt}' => $i18n->__('Klucz do CRC'),
            'config{test}' => $i18n->__('Tryb testowy'),
            'config{notice}' => $i18n->__('Przelewy24'),
            'config{autoredirect}' => $i18n->__('Automatyczne przekierowanie'),
        );  
    }

    public function validateIndex()
    {
        $request = $this->getRequest();

        if ($request->getMethod() == sfRequest::POST)
        {
            $i18n = $this->getContext()->getI18N();

            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

            $data = $this->getRequestParameter('config');

            if (!$data['przelewy24_id'])
            {
                $request->setError('config{przelewy24_id}', $i18n->__('Uzupełnij pole'));
            }

            if (!$data['salt'])
            {
                $request->setError('config{salt}', $i18n->__('Uzupełnij pole'));
            }


            if (!$request->hasErrors())
            {
                $api = new Przelewy24($data['przelewy24_id'], $data['przelewy24_id'], $data['salt'], isset($data['test']) && $data['test']);

                $api->addValue("p24_amount", 1000 * 100);
                $api->addValue("p24_currency", 'PLN');
                $api->addValue("p24_description", "Walidacja konfiguracji płatności");
                $api->addValue("p24_email", 'john.doe@example.com');
                $api->addValue("p24_session_id", 'validate:'.uniqid());
                $api->addValue("p24_country", 'PL');
                $api->addValue("p24_language", 'pl');
                $api->addValue("p24_encoding", "UTF-8");
        
                $api->addValue("p24_url_return", $this->getController()->genUrl('@stPrzelewy24Plugin?action=returnSuccess', true));
        
                $res = $api->trnRegister(false);

                if ($res['error'])
                {
                    $request->setError('config{notice}', $i18n->__('Wystąpił problem z połączeniem sprawdź czy wprowadzone dane są prawidłowe (Zwrócony błąd: %error%)', array('%error%' => $i18n->__($res['errorMessage']))));
                }
            }

        }
        
        return !$request->hasErrors();
    }     

    /**
     * Akcja w przypadku błędu w uzupełnianiu pól
     */
    public function handleErrorIndex()
    {
    	$context = $this->getContext();
    	$i18n = $context->getI18n();
    	
        $this->config = stConfig::getInstance($context);
        $this->config->setFromRequest('config');
        $this->labels = $this->getLabels();
        return sfView::SUCCESS;
    }
}