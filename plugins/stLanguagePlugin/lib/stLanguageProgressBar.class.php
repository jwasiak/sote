<?php

class stLanguageXliffProgressBar {

    protected $message = '';

    protected $catalogues = array();

    public function getTitle() {
        return sfContext::getInstance()->getI18N()->__('Zapisywanie definicji językowych', null, 'stLanguageBackend').':';
    }

    public function getMessage() {
        return $this->message;
    }

    public function close() {
        $this->message = '<script type="text/javascript">document.getElementById("progressbar-button").style.visibility="visible";</script>';
        stLock::unlock('frontend');
    }

    public static function clearCache() {
        $pakeweb = new stPakeWeb();
        if (!$pakeweb->run('cc frontend') || !$pakeweb->run('cc functions'))
            throw new Exception($pakeweb->error);

        stFastCacheManager::clearCache();
    }
}

class stLanguageGenerateXliffProgressBar extends stLanguageXliffProgressBar {
    
    public static function getSteps($language) {
        $e = stLanguageEditor::getInstance($language->getLanguage(), true);

        return count($e->getCatalogues(true))+1;
    }

    public function step($step) {
        list(, $id) = explode('_', sfContext::getInstance()->getRequest()->getParameter('name'));

        $this->language = LanguagePeer::retrieveByPk($id);
        $this->stLanguageEditor = stLanguageEditor::getInstance($this->language->getLanguage(), true);

        if (!is_object($this->language))
            throw new Exception('Invalid language id.');

        if ($step == 0) {
            stLock::lock('frontend');
            $this->clearCache();
        } else
            $this->parseStep($step-1);
        
        return $step+1;
    }

    protected function parseStep($step) {
        $catalogues = $this->stLanguageEditor->getCatalogues(true);
        $catalogue = reset($catalogues);

        $this->stLanguageEditor->saveXliffFile(array('cache', 'user'), $catalogue);

        $c = new Criteria();
        $c->add(TranslationCachePeer::CATALOGUE, $catalogue);
        $c->add(TranslationCachePeer::LANGUAGE_ID, $this->language->getId());
        TranslationCachePeer::doDelete($c);
    }
}

class stLanguageSplitXliffProgressBar extends stLanguageXliffProgressBar {

    public static function getSteps($language) {
        $filePath = sfConfig::get('sf_cache_dir').'/messages.user.'.$language->getLanguage().'.tmp';
        if (file_exists($filePath)) {
            $phrases = stLanguageEditor::parseXliffFile($filePath);
            return count($phrases);
        } else 
            throw new Exception('Invalid file.');

        return null;
    }

    public function step($step) {
        list(, $id) = explode('_', sfContext::getInstance()->getRequest()->getParameter('name'));

        $language = LanguagePeer::retrieveByPk($id);
        if (!is_object($language))
            throw new Exception('Invalid language.');

        $filePath = sfConfig::get('sf_cache_dir').'/messages.user.'.$language->getLanguage().'.tmp';
        if (!file_exists($filePath))
            throw new Exception('Invalid file.');

        if ($step == 0) {
            stLock::lock('frontend');
            $this->clearCache();
        } else {
            $editor = stLanguageEditor::getInstance($language->getLanguage(), true);
            $phrases = stLanguageEditor::parseXliffFile($filePath);

            $catalogues = array_keys($phrases);
            $catalogue = $catalogues[$step-1];

            $editor->saveXliffFile('user', $catalogue, $phrases);

            $c = new Criteria();
            $c->add(TranslationCachePeer::CATALOGUE, $catalogue);
            $c->add(TranslationCachePeer::LANGUAGE_ID, $language->getId());
            TranslationCachePeer::doDelete($c);
        }
        
        return $step+1;
    }
}
