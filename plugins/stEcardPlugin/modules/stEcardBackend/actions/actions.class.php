<?php
/**
 * SOTESHOP/stEcardPlugin
 *
 * Ten plik należy do aplikacji stEcardPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stEcardPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 7200 2010-08-02 12:49:54Z marek $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stEcardBackendActions
 *
 * @package     stEcardPlugin
 * @subpackage  actions
 */
class stEcardBackendActions extends stActions
{
    /**
     * Wyświetla konfigurację modułu
     */
    public function executeIndex()
    {
        $this->config = stConfig::getInstance($this->getContext());
        $i18n = $this->getContext()->getI18N();
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->config->setFromRequest('ecard');
            $this->config->save();
            $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
        }
        $this->labels = $this->getLabels();
        $this->config->load();
    }

    public function validateIndex()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
        }
        
        return true;
    }

    /**
     * Akcja w przypadku błędu w uzupełnianiu pól
     */
    public function handleErrorIndex()
    {
        $this->config = stConfig::getInstance($this->getContext());
        $this->labels = $this->getLabels();
        return sfView::SUCCESS;
    }

    protected function getLabels()
    {
        return array('ecard{ecard_id}' => 'Identyfikator', 'ecard{ecard_password}' => 'Hasło autoryzacji');        
    }
}