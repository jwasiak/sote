<?php
/** 
 * SOTESHOP/stOptimizationPlugin 
 * 
 * Ten plik należy do aplikacji stOptimizationPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stOptimizationPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 6551 2010-07-16 10:59:52Z pawel $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stOptimizationBackendActions
 *
 * @package     stOptimizationPlugin
 * @subpackage  actions
 */
class stOptimizationBackendActions extends stActions
{
    /** 
     * Wyświetla konfigurację modułu
     */
    public function executeIndex() {
        $this->config = stConfig::getInstance($this->getContext(), 'stOptimizationBackend');
        $i18n = $this->getContext()->getI18N();

        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
            $this->config->set('off', !$this->getRequest()->getParameter('config[off]', false));
            $this->config->save();
            $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
        }
    }

    /** 
     * Wykonywanie taska clean-cache
     */
    public function executeCleanCache() {
        stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
        $pakeweb = new stPakeWeb();
        $i18n = $this->getContext()->getI18N();
        
        stLock::lock('frontend');
        
        if ($pakeweb->run('cc frontend') && $pakeweb->run('cc functions')) {
            $flash_text = $i18n->__('Pamięć podręczna została wyczyszczona');
            $this->setFlash('notice', $flash_text);
        } else
            throw new Exception($pakeweb->error);

        $cUrl = curl_init();
        curl_setopt($cUrl, CURLOPT_URL, 'http://'.$this->getContext()->getRequest()->getHost().'/?open-key='.md5_file(SF_ROOT_DIR.'/config/databases.yml'));
        curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($cUrl);
        curl_close($cUrl);
        
        stLock::unlock('frontend');
        
        $this->forward('stOptimizationBackend', 'index');
    }
}
