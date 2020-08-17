<?php

/**
 * SOTESHOP/stCurrencyPlugin 
 * 
 * Ten plik należy do aplikacji stCurrencyPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stCurrencyPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 10373 2011-01-20 11:27:26Z pawel $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/**
 * stCurrencyBackend actions.
 *
 * @package     stCurrencyPlugin
 * @subpackage  actions
 */
class stCurrencyBackendActions extends autostCurrencyBackendActions
{

    public function validateEdit()
    {
        $ok = true;

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $request = $this->getRequestParameter('currency');

            $config = stConfig::getInstance(null, 'stCurrencyPlugin');

            if ($request['shortcut'] != $config->get('default_currency'))
            {
                $validator = new sfNumberValidator();

                $validator->initialize($this->getContext(), array('nan_error' => 'Niepoprawny format liczbowy kursu (przykładowy format: 10, 10.1234)', 'min_error' => 'Wartość kursu musi być większa od 0', 'min' => '0.0001'));

                if (!$validator->execute($request['exchange'], $error))
                {
                    $this->getRequest()->setError('currency{exchange}', $error);

                    $ok = false;
                }
                elseif (floatval($request['exchange']) == 1)
                {
                    $this->getRequest()->setError('currency{exchange}', 'Wartość kursu nie może być równa 1');

                    $ok = false;                    
                }
            }

            $validator = new sfPropelUniqueValidator();

            $validator->initialize($this->getContext(), array('class' => 'Currency', 'column' => 'shortcut'));

            if (!$validator->execute($request['shortcut'], $error))
            {
                if ($request['edit_iso_code'] != '')
                {
                    $this->getRequest()->setError('currency{edit_iso_code}', 'Wybrana waluta już istnieje...');
                }
                else
                {
                    $this->getRequest()->setError('currency{shortcut}', 'Waluta z podanym kodem ISO już istnieje...');
                }

                $ok = false;
            }
        }

        return $ok;
    }

    protected function saveConfig() 
    {   
        parent::saveConfig();
        stFastCacheManager::clearCache();
    }

    protected function loadConfigOrCreate() 
    {    
        $config = stConfig::getInstance('stCurrencyPlugin', array('culture' => $this->getRequestParameter('culture', stLanguage::getOptLanguage())));

        if ($config->isEmpty())
        { 
            $config->set('inverse', ''); 
        } 

        return $config;
    }    

}
