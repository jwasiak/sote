<?php
/**
 * SOTESHOP/stPositioningPlugin
 *
 * Ten plik należy do aplikacji stPositioningPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPositioningPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 10490 2011-01-26 10:57:59Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPositioningBackendActions
 *
 * @package     stPositioningPlugin
 * @subpackage  actions
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */
class stPositioningBackendActions extends autoStPositioningBackendActions
{
    protected function getPositioningOrCreate($id = 'id')
    {
        $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'autoStPositioningBackendActions.preGetOrCreate'));
        if (!$event->isProcessed())
        {
            if (!$this->getRequestParameter($id))
            {
                $c = new Criteria();
                $c->add(PositioningPeer::SYSTEM_NAME, 'DEFAULT_VALUE');
                $this->positioning = PositioningPeer::doSelectOne($c);
                if (!is_object($this->positioning)) {
                    $this->positioning = $this->createDefaultPositioning();
                }
            }
            else
            {
                $this->positioning = PositioningPeer::retrieveByPk($this->getRequestParameter($id));

                $this->forward404Unless($this->positioning);
            }
        }

        $this->getDispatcher()->notify(new sfEvent($this, 'autoStPositioningBackendActions.postGetOrCreate', array('modelInstance' => $this->positioning)));

        if (method_exists($this->positioning, 'setCulture'))
        {
            if ($this->positioning->getPrimaryKey())
            {
                $language = $this->getRequestParameter('culture', stLanguage::getOptLanguage());
            }
            else
            {
                $language = stLanguage::getOptLanguage();
            }

            $this->positioning->setCulture($language);
        }

        return $this->positioning;
    }
    /**
     * Dodatkowa walidacja dla zapisu danych
     */
    public function validateEdit()
    {
        $i18n = $this->getContext()->getI18n();
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

            if ($this->getRequest()->hasParameter('id'))
            {
                $positioning = PositioningPeer::retrieveByPK($this->getRequest()->getParameter('id'));
                if (is_object($positioning))
                {
                    if ($positioning->getSystemName() == "DEFAULT_VALUE")
                    {
                        foreach (array('title', 'keywords', 'description') as $name)
                        {
                            if ($this->getRequest()->hasParameter('positioning['.$name.']'))
                            {
                                $v = $this->getRequest()->getParameter('positioning['.$name.']');
                                if(empty($v)) $this->getRequest()->setError('positioning{'.$name.'}', $i18n->__('Proszę uzupełnić pole.'));
                            } else {
                                $this->getRequest()->setError('positioning{'.$name.'}', $i18n->__('Proszę uzupełnić pole.'));
                            }
                        }
                    }
                }
            }
        }
        return true;
    }

    public function handleErrorSitemapCustom()
    {
        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStPositioningBackend/sitemap_forward_parameters');
        $this->related_object = PositioningPeer::retrieveByPk($this->forward_parameters['meta_id']);
        return sfView::SUCCESS;
    }

    public function executeRebuildSeoLinks() {
        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStPositioningBackend/sitemap_forward_parameters');
        $this->related_object = PositioningPeer::retrieveByPk($this->forward_parameters['meta_id']); 

    }
    
    public function validateRebuildSeoLinks() {
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());         
            if (!$this->getRequestParameter('seo_links',array())) {
                $this->getRequest()->setError('seo_links', $this->getContext()->getI18n()->__('Proszę wybrać jedną z opcji'));
       

            }

            if (!$this->getRequestParameter('language',array())) {
                $this->getRequest()->setError('language', $this->getContext()->getI18n()->__('Proszę wybrać jedną z opcji'));
            }
        }
        return !$this->getRequest()->hasErrors();
    }
    public function handleErrorRebuildSeoLinks()
    {
        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStPositioningBackend/sitemap_forward_parameters');
        return sfView::SUCCESS;
    }
    public function validateConfig() {
        $i18n = $this->getContext()->getI18n();
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            if ($this->hasRequestParameter('config[redirect]')) {
                if (!$this->hasRequestParameter('config[redirect]')) {
                    $this->getRequest()->setError('config{domain}', $i18n->__('Musisz wybrac język dla mapy strony'));
                    return false;
                }
                $validator = new stLanguageDomainValidator();
                $validator->initialize($this->getContext(), array('domain_error'=>$i18n->__('Nieprawidłowa nazwa domeny')));
                $domain = $this->getRequestParameter('config[domain]');
                if (!$validator->execute($domain, $error))
                {
                    $this->getRequest()->setError('config{domain}', $error);
                    return false;
                }
            }
        }
        return true;
    }

    public function validateRobotFileCustom()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());         
        }      
    }

    public function handleErrorRobotFileCustom()
    {
      $this->processRobotFileCustomForwardParameters();
      $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStPositioningBackend/robot_file_forward_parameters');     
      $this->related_object = PositioningPeer::retrieveByPk($this->forward_parameters['meta_id']);  
      return sfView::SUCCESS;
    }

    public function validateSitemapCustom() {

        $i18n = $this->getContext()->getI18n();
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
            $sitemap = $this->getRequestParameter('sitemap');
            if(!isset($sitemap['langs']) || !count($sitemap['langs'])) {
                $this->getRequest()->setError('sitemap{langs}', $i18n->__('Musisz wybrac język dla mapy strony'));
                return false;
            }

        }
        return true;
    }

    public function validateVerifySearchCustom()
    {
        $i18n = $this->getContext()->getI18n();
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
            $verify = $this->getRequestParameter('verify');

            if(!isset($verify['file'])){
                $verify_file = $this->getRequest()->getFileName('verify[file]');
                if($verify_file)
                {
                    if ((strpos($verify_file, "google")!== false) || (strpos($verify_file, "yandex")!==false) || (strpos($verify_file,"BingSiteAuth")!==false)){             
                    }else{
                        $this->getRequest()->setError('verify{file}', $i18n->__('Załącz poprawny plik od Google, Bing lub Yandex'));       
                        return false;
                    }
                }
                
            }
            $verifies = $verify['verify'];
            foreach ($verifies as $key=>$value) {
                $newVal = trim($value);
                if (strlen($newVal)>0 && (strlen($newVal)<43 || strlen($newVal)>44)) {
                    $this->getRequest()->setError('verify{verify}', $i18n->__('Prosze podać poprawny klucz dla domeny').' '.$key);
                return false;
                }
            }
        }
        return true;
    }



    protected function createDefaultPositioning() {
        $object = new Positioning();
        $object->setCulture('pl_PL');
        $object->setName('Wartości domyślne');
        $object->setSystemName('DEFAULT_VALUE');
        $object->setTitle('Sklep internetowy');
        $object->setKeywords('');
        $object->setDescription('');
        $object->save();
        $object->setCulture('en_US');
        $object->setType(0);
        $object->save();
        return $object;
    }


    public function handleErrorVerifySearchCustom()
    {
        $this->processVerifySearchCustomForwardParameters();
        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStPositioningBackend/verify_search_forward_parameters');
        $this->related_object = PositioningPeer::retrieveByPk($this->forward_parameters['meta_id']);
        return sfView::SUCCESS;   
    }

    public function handleError404linksCustom()
    {
        $this->process404linksCustomForwardParameters();
        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStPositioningBackend/404links_forward_parameters');
        $this->related_object = PositioningPeer::retrieveByPk($this->forward_parameters['meta_id']);
        return sfView::SUCCESS; 
    }

    public function validate404linksCustom()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());         
        }      
    }

    public function executeRemoveFile()
    {
        $del = $this->getRequestParameter('del',array());
        $delete_file = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.sfConfig::get('sf_web_dir_name')."/".$del;
        
        if ($delete_file)
        {
            unlink($delete_file);
        }

        $this->redirect('stPositioningBackend/verifySearchCustom', 301);
       
    }
}