<?php
/** 
 * SOTESHOP/stLanguagePlugin 
 * 
 * Ten plik należy do aplikacji stLanguagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stLanguagePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 9 2009-08-24 09:31:16Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stLanguageBackendActions
 *
 * @package     stLanguagePlugin
 * @subpackage  actions
 */
class stLanguageBackendComponents extends autoStLanguageBackendComponents {

    public function executeShowLanguages() {
        $this->languages = LanguagePeer::doSelect(new Criteria());
    }

    public function executeTranslationsExport() {
        $this->language = LanguagePeer::retrieveByPK($this->getRequestParameter('id', null));
        $this->hasTranslations = (bool)count(glob(sfConfig::get('sf_root_dir').'/apps/frontend/i18n/*.user.'.$this->language->getLanguage().'.xml'));
    }
    
    public function executeTranslationsDelete() {
        $this->language = LanguagePeer::retrieveByPK($this->getRequestParameter('id', null));
        $this->hasTranslations = (bool)count(glob(sfConfig::get('sf_root_dir').'/apps/frontend/i18n/*.user.'.$this->language->getLanguage().'.xml'));
    }
}
