<?php

class stHtaccessBackendActions extends stActions {

    public function executeIndex() {

        $this->labels = array('config{error}' => ' ');

        $this->config = stConfig::getInstance('stHtaccessBackend');
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $c = $this->getRequestParameter('config');

            stHtaccess::rebuild(null, array('top' => $c['top'], 'middle' => $c['middle'], 'bottom' => $c['bottom']));

            $testFilename = 'test_'.time().'.php';
            file_put_contents(sfConfig::get('sf_web_dir').'/'.$testFilename, '<?php echo "'.$testFilename.'";');

            $b = new sfWebBrowser(array(), 'sfCurlAdapter', array('ssl_verify' => false));
            $b->get($this->getRequest()->getUriPrefix().'/'.$testFilename);

            unlink(sfConfig::get('sf_web_dir').'/'.$testFilename);

            if ($b->getResponseText() == $testFilename) {
                $this->config->setFromRequest('config');
                $this->config->save();
                $this->setFlash('notice', $this->getContext()->getI18n()->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
            } else {
                stHtaccess::rebuild(null, array('top' => $this->config->get('top'), 'middle' => $this->config->get('middle'), 'bottom' => $this->config->get('bottom')));
                $this->getRequest()->setError('config{error}', 'Sprawdź poprawność wprowadzonych danych.');
            }
        }

        $this->config->load();
    }

    public function validateIndex() {
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
        }
        return true;
    }      
}
