<?php
/**
 * SOTESHOP/stPolcardPlugin
 *
 * Ten plik należy do aplikacji stPolcardPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPolcardPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 7196 2010-08-02 12:45:55Z marek $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPolcardBackendActions
 *
 * @package     stPolcardPlugin
 * @subpackage  actions
 */
class stPolcardBackendActions extends stActions
{
    /**
     * Wyświetla konfigurację modułu
     */
    public function executeIndex()
    {       
        $this->config = stConfig::getInstance($this->getModuleName());

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->config->setFromRequest('config');
            $this->config->save();
            $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
        }


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

    public function getLabels()
    {
        return  array(
            'config{pos_id}' => $this->getContext()->getI18n()->__('Identyfikator sprzedaży'),
            'config{shared_key}' => $this->getContext()->getI18n()->__('Klucz współdzielony'),
        );        
    }      

    /**
     * Akcja w przypadku błędu w uzupełnianiu pó
     */
    public function handleErrorIndex()
    {
        $this->config = stConfig::getInstance($this->getModuleName());
        $this->labels = $this->getLabels();
        return sfView::SUCCESS;
    }
}