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
 * @version     $Id: actions.class.php 11171 2011-02-21 13:07:13Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stLanguageBackendActions
 *
 * @package     stLanguagePlugin
 * @subpackage  actions
 */
class stLanguageBackendActions extends autoStLanguageBackendActions
{
    /**
     * Zmiana języka na angielski
     */
    public function executeChangeLanguage()
    {
        if ($this->getRequest()->hasParameter('name'))
        {
            if ($this->getRequest()->getParameter('name') == 'pl')
            {
                $this->getUser()->setCulture('pl_PL');
            } elseif ($this->getRequest()->getParameter('name') == 'en') {
                $this->getUser()->setCulture('en_US');
            }
        } else {
            $this->getUser()->setCulture('pl_PL');
        }

        $this->getUser()->setAttribute('changedLanguage', true, stLanguage::SESSION_NAMESPACE);

        $this->redirect($this->getRequest()->getReferer());
    }

    public function executeAdvancedEdit() {

        $this->language = LanguagePeer::retrieveByPk($this->getRequestParameter('id', null));
        if ($this->language === null)
            $this->forward404();

        $this->processAdvancedEditForwardParameters();
        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStLanguageBackend/advanced_forward_parameters');
        $this->related_object = $this->language;

        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $file = $this->getRequest()->getFileName('language[file]');
            if (!empty($file)) {
                $cacheDir = sfConfig::get('sf_cache_dir').'/messages.user.'.$this->language->getLanguage().'.tmp';
                $this->getRequest()->moveFile('language[file]', $cacheDir);

                $this->getRequest()->setParameter('id', $this->language->getId());
                $this->forward('stLanguageBackend', 'splitXliff');
            }

            if ($this->getRequestParameter('language[delete_file]')) {
                stLock::lock('frontend');
                
                foreach (glob(sfConfig::get('sf_root_dir').'/apps/frontend/i18n/*.user.'.$this->language->getLanguage().'.xml') as $file)
                    unlink($file);


                $pakeweb = new stPakeWeb();
                if (!$pakeweb->run('cc frontend'))
                    throw new Exception($pakeweb->error);

                stFastCacheManager::clearCache();

                stLock::unlock('frontend');
            }

            $this->setFlash('notice', sfI18N::getInstance()->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
            
            return $this->redirect('stLanguageBackend/advancedEdit?id='.$this->language->getId());
        } else {
            $this->labels = $this->getAdvancedLabels();
        }
    }

    public function executeSplitXliff() {
        $this->language = LanguagePeer::retrieveByPK($this->getRequestParameter('id', null));

        if ($this->language === null)
            $this->forward404();

        $this->processAdvancedEditForwardParameters();
        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStLanguageBackend/advanced_forward_parameters');
        $this->related_object = $this->language;
    }

    public function executeDownload() {
        $language = LanguagePeer::retrieveByPK($this->getRequestParameter('id', null));
        $type = $this->getRequestParameter('type', null);

        $this->setLayout(false);

        if ($language === null || $type === null)
            $this->forward404();

        $fileName = 'messages.'.$type.'.'.$language->getLanguage().'.xml';

        $response = $this->getContext()->getResponse();
        $response->setContentType("text/xml");
        $response->setHttpHeader('Content-Disposition', 'attachment; filename="'.$fileName.'"');

        $languageEditor = stLanguageEditor::getInstance($language->getLanguage(), true);
        $languageEditor->saveXliffFile($type);

        $filePath = sfConfig::get('sf_root_dir').'/apps/frontend/i18n/'.$fileName;
        if (file_exists($filePath))
            $this->handle = fopen($filePath, 'r');
        else 
            $this->forward404();
    }

    /**
     * Prazeciążenie executeDomainList
     */
    public function executeDomainList()
    {
        parent::executeDomainList();
            
        $this->pager->getCriteria()->add(LanguageHasDomainPeer::LANGUAGE_ID, $this->forward_parameters['language_id']);
        $this->pager->init();
    }

    /**
     * Przeciążenie getDomainLanguageHasDomainOrCreate
     */
    protected function getDomainLanguageHasDomainOrCreate($id = 'id')
    {
        parent::getDomainLanguageHasDomainOrCreate($id);

        $this->language_has_domain->setLanguageId($this->forward_parameters['language_id']);
        return $this->language_has_domain;
    }

    /**
     * Przeciążenie aktualizacji config'a
     */
    protected function updateConfigFromRequest()
    {
        $config = $this->getRequestParameter('config');

        $c = new Criteria();
        $c->add(LanguagePeer::ID, $config['language_panel']);
        $language = LanguagePeer::doSelectOne($c);

        if(is_object($language))
        {
            $language->setIsDefaultPanel(true);
            $language->save();
                
            $this->getUser()->setCulture($language->getOriginalLanguage());
                
            $config = stConfig::getInstance($this->getContext(), 'stLanguagePlugin');
            $config->set('admin_language', $language->getOriginalLanguage());
            $config->save();
        }
    }

    public function executeTranslationList() {
        $this->processTranslationListForwardParameters();

        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStLanguageBackend/translation_forward_parameters');

        $this->related_object = LanguagePeer::retrieveByPk($this->forward_parameters['id']); 

        $this->processTranslationSort();

        $this->processTranslationFilters();

        $this->filters = $this->getUser()->getAttributeHolder()->getAll('soteshop/stAdminGenerator/stLanguageBackend/translationList/filters');

        $this->hasTranslationCache = (bool)TranslationCachePeer::doCountByLanguage($this->forward_parameters['id']);

        $this->catalogue = isset($this->filters['filter_catalogue']) ? $this->filters['filter_catalogue'] : null;
        if ($this->catalogue == 'NONE')
            $this->catalogue = null;

        $searchPhrase = isset($this->filters['filter_phrase']) ? $this->filters['filter_phrase'] : null;
        if (empty($searchPhrase))
            $searchPhrase = null;

        $searchTranslation = isset($this->filters['filter_phrase_user']) ? $this->filters['filter_phrase_user'] : null;
        if (empty($searchTranslation))
            $searchTranslation = null;

        $stLanguageEditor = new stLanguageEditor($this->related_object->getLanguage());

        if ($searchPhrase && $searchTranslation) {
            $sp = $stLanguageEditor->searchPhrase($searchPhrase, $this->catalogue);
            $st = $stLanguageEditor->searchTranslation($searchTranslation, $this->catalogue);

            $phrases = array();
            foreach ($sp as $catalogue => $translations) {
                foreach ($translations as $key => $value) {
                    if (isset($st[$catalogue][$key]))
                        $phrases[$catalogue][$key] = $value;
                }
            }

            $this->phrases = $phrases;
        } elseif ($searchPhrase)
            $this->phrases = $stLanguageEditor->searchPhrase($searchPhrase, $this->catalogue);
        elseif ($searchTranslation)
            $this->phrases = $stLanguageEditor->searchTranslation($searchTranslation, $this->catalogue);
        else
            $this->phrases = $stLanguageEditor->getPhrases($this->catalogue);
        
        $this->catalogues = $stLanguageEditor->getCatalogues();
    }

    public function executeTranslationEdit() {

        $i18n = sfI18N::getInstance();
        $this->processTranslationEditForwardParameters();
        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStLanguageBackend/translation_forward_parameters');

        $this->translation_cache = $this->getTranslationTranslationCacheOrCreate();

        $this->labels = array();

        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $this->updateTranslationTranslationCacheFromRequest();
            $this->saveTranslationTranslationCache($this->translation_cache);

            if (!$this->hasFlash('notice'))
                $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));

            return $this->redirect('stLanguageBackend/translationEdit?culture='.$this->getRequestParameter('culture', 'pl_PL').'&id='.$this->forward_parameters['id'].'&index='.$this->getRequestParameter('index', null));
        }

        $this->related_object = LanguagePeer::retrieveByPk($this->forward_parameters['id']); 
    }


    protected function getTranslationTranslationCacheOrCreate($id = 'id') {
        $this->language = LanguagePeer::retrieveByPk($this->getRequestParameter('id'));
        if (is_object($this->language)) {

            list($this->catalogue, $this->index) = explode('_', $this->getRequestParameter('index', null));

            if ($this->catalogue !== null && $this->index !== null) {
                $this->translation_cache = TranslationCachePeer::doSelectByCatalogueAndIndex($this->catalogue, $this->index, $this->language->getId());

                $le = new stLanguageEditor($this->language->getLanguage());
                $this->phrase = $le->getPhraseByIndex($this->catalogue, $this->index);

                if ($this->phrase === null)
                    return $this->forward404();

                if (!is_object($this->translation_cache)) {
                    $this->translation_cache = new TranslationCache();
                    $this->translation_cache->setCatalogue($this->catalogue);
                    $this->translation_cache->setCatalogueIndex($this->index);
                    $this->translation_cache->setLanguage($this->language);
                    $this->translation_cache->setValue((isset($this->phrase['user']) ? $this->phrase['user'] : $this->phrase['shop']));
                }
            }
        }

        $this->forward404Unless($this->language);

        return $this->translation_cache;
    }

    protected function addTranslationCacheFiltersCriteria($c) {
        parent::addTranslationCacheFiltersCriteria($c);
        $c->add(TranslationCachePeer::LANGUAGE_ID, $this->related_object->getId());
    }


    public function executeGenerateXliff() {
        $this->language = LanguagePeer::retrieveByPk($this->getRequestParameter('id'));

        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStLanguageBackend/translation_forward_parameters');
    }
}
