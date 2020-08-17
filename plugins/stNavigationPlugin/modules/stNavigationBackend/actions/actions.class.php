<?php
/**
 * SOTESHOP/stNavigationPlugin
 *
 * Ten plik należy do aplikacji stNavigationPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package stNavigationPlugin
 * @subpackage actions
 * @copyright SOTE (www.sote.pl)
 * @license http://www.sote.pl/license/sote (Professional License SOTE)
 * @version $Id: actions.class.php 10468 2011-01-25 12:07:47Z pawel $
 * @author Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stNavigationBackendActions
 *
 * @package stNavigationPlugin
 * @subpackage actions
 */
class stNavigationBackendActions extends stActions
{
    /**
     * Wyświetla konfigurację modułu
     */
    public function executeIndex()
    {
        $i18n = $this->getContext()->getI18N();
        $this->config = stConfig::getInstance($this->getContext(), array('culture' => $this->getRequestParameter('culture', stLanguage::getOptLanguage())));

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $req = $this->getRequestParameter('navigation');
            foreach (array( 'view_type', 'bar', 'navigation', 'historyOn', 'history', 
            				'history_link', 'history_products', 'decrease', 'decrease_last', 'decrease_length',
            				'history_box', 'history_box_limit',) as $param) $this->config->set($param, $req[$param]);
            $this->config->set('navigation_start_name', $req['navigation_start_name'], true);
            $this->config->save();
            stFastCacheManager::clearCache();
            $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
        }
    }

    public function validateIndex()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST && !stTheme::hideOldConfiguration())
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
        $i18n = $this->getContext()->getI18N();
        $this->config = stConfig::getInstance($this->getContext());
        $this->labels = array(
        'navigation{history_products}' => $i18n->__('Ilość ostatnio oglądanych produktów'),
        'navigation{decrease_length}' => $i18n->__('Ilość znaków po obcięciu'),
        'navigation{history_box_limit}' => $i18n->__('Ilość wyświetlanych produktów w boksie'),
        'navigation{navigation_start_name}' => $i18n->__('Nazwa pierwszego elementu'));
        return sfView::SUCCESS;
    }
}