<?php
/**
 * SOTESHOP/stGoogleAnalyticsPlugin
 * 
 * Ten plik należy do aplikacji stDelivery opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stGoogleAnalyticsPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 1321 2009-05-22 10:56:56Z krzysiek $
 */

/**
 * Akcje stGoogleAnalyticsBackend
 *
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>, Paweł Byszewski <pawel.byszewski@sote.pl>,
 * @package     stGoogleAnalyticsPlugin
 * @subpackage  actions
 */
class stGoogleAnalyticsBackendActions extends sfActions
{
    /**
   * Zapisuje konfiguracje modulu
   */
    public function executeIndex()
    {
        $i18n = $this->getContext()->getI18N();

        $this->config = stConfig::getInstance($this->getContext());

        $this->labels = $this->getLabels();

        if ($this->getRequest()->getMethod() == sfRequest::POST){

            $this->config->set('analytics_part2', $this->getRequestParameter('google_analytics[analytics_part2]'));

            $this->config->set('analytics_part3', $this->getRequestParameter('google_analytics[analytics_part3]'));

            $this->config->set('analytics', $this->getRequestParameter('google_analytics[analytics]'));

            $this->config->set('ecommerce', $this->getRequestParameter('google_analytics[ecommerce]'));

            $this->config->save();

            $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
        }
    }

    public function validateIndex()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST){

            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
        }
        
        return true;
    }       

    /**
     * Informuje o nieudanym wysłaniu polecenia sklepu
     */
    public function handleErrorIndex()
    {
        $this->config = stConfig::getInstance($this->getContext());

        $this->config->setFromRequest('google_analytics');

        $this->labels = $this->getLabels();
        
        return sfView::SUCCESS;

    }

    protected function getLabels()
    {

        return array(
        'google_analytics{analytics_part2}' => 'Numer w kodzie otrzymanym od Google',

        'google_analytics{analytics_part3}' => 'Numer w kodzie otrzymanym od Google',
        );
    }


}
