<?php
/**
 * SOTESHOP/stSearchPlugin
 *
 * Ten plik należy do aplikacji stSearchPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stSearchPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 13582 2011-06-10 11:32:10Z marcin $
 */

/**
 * stSearchBackend actions.
 *
 * @author Your name here
 *
 * @package     stSearchPlugin
 * @subpackage  actions
 */
class stSearchBackendActions extends autoStSearchBackendActions
{
    public function executeIndex()
    {
        $searchConfig = stConfig::getInstance($this->context, 'stSearchBackend');
        if ($searchConfig->get('enable_new') != 0) {
            return $this->redirect('stSearchBackend/newConfig');
        }
        parent::executeIndex();
    }

    public function executeConfig()
    {
        $searchConfig = stConfig::getInstance($this->context, 'stSearchBackend');
        if ($searchConfig->get('enable_new') != 0) {
            return $this->redirect('stSearchBackend/newConfig');
        }
        parent::executeConfig();
    }

    public function executeNewConfig() 
    {
        if ($this->hasFlash('notice'))
        {
            return $this->forward('stSearchBackend', 'optimize');
        }

        return parent::executeNewConfig();
    }

    public function executeOptimize()
    {
        stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStSearchBackend/forward_parameters');
        $this->productCount = stSearchOptimize::count();
    }

    protected function updateConfigFromRequest()
    {
        $i18n = sfContext::getInstance()->getI18N();
        $old_simple = $this->config->get('simple_search_fields',array());
        $old_advanced = $this->config->get('advanced_search_fields',array());
        $old_simple_full = $this->config->get('simple_full_search_fields',array());
        $old_advanced_full = $this->config->get('advanced_full_search_fields',array());
        
        foreach ($old_simple as $key=>$value) $old_simple[$key] = 0;
        foreach ($old_advanced as $key=>$value) $old_advanced[$key] = 0;
        foreach ($old_simple_full as $key=>$value) $old_simple_full[$key] = 0;
        foreach ($old_advanced_full as $key=>$value) $old_advanced_full[$key] = 0;

        $config = $this->getRequestParameter('config');

        if (!isset($config['advanced_search_fields'])) $config['advanced_search_fields']=array();
        if (!isset($config['simple_search_fields'])) $config['simple_search_fields']=array();
        if (!isset($config['advanced_full_search_fields'])) $config['advanced_full_search_fields']=array();
        if (!isset($config['simple_full_search_fields'])) $config['simple_full_search_fields']=array();
        
        $config['advanced_search_fields'] = array_merge($old_advanced, $config['advanced_search_fields']);
        $config['simple_search_fields'] = array_merge($old_simple, $config['simple_search_fields']);
        $config['advanced_full_search_fields'] = array_merge($old_advanced,  $config['advanced_full_search_fields']);
        $config['simple_full_search_fields'] = array_merge($old_simple, $config['simple_full_search_fields']);

        if ($this->config->get('advanced_search_fields') != $config['advanced_search_fields'] || 
            $this->config->get('simple_search_fields') != $config['simple_search_fields'] ||
            $this->config->get('advanced_full_search_fields') != $config['advanced_full_search_fields'] ||
            $this->config->get('simple_full_search_fields') != $config['simple_full_search_fields'])
        { 
            sfLoader::loadhelpers(array('Helper','stUrl'));
            $this->setFlash('warning', $i18n->__('Konfiguracja wyszukiwanych pól została zmieniona.<br />Wykonuję aktulizacje wyników wyszukiwnia, proszę nie zamykać okna przeglądarki'),false);
        }

        parent::updateConfigFromRequest();
       
        $this->config->set('advanced_search_fields',$config['advanced_search_fields']);
        $this->config->set('simple_search_fields',$config['simple_search_fields']);
        $this->config->set('advanced_full_search_fields',$config['advanced_full_search_fields']);
        $this->config->set('simple_full_search_fields',$config['simple_full_search_fields']);

        $this->config->set('list_type', $config['list_type']);
    }
    
    protected function saveConfig()
    {
       parent::saveConfig();
       
       stFastCacheManager::clearCache();
    }


    public function validateConfig()
    {
        $i18n = sfContext::getInstance()->getI18N();
        $ret = true;
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            if (count($this->getRequestParameter('config[advanced_search_fields]', array()))==0) {
                $ret = false;
                $this->getRequest()->setError('config{advanced_search_fields}', $i18n->__('Proszę wybrać co najmniej jedno pole.'));
            }
            if (count($this->getRequestParameter('config[simple_search_fields]', array()))==0) {
                $ret = false;
                $this->getRequest()->setError('config{simple_search_fields}', $i18n->__('Proszę wybrać co najmniej jedno pole.'));
            }
            if (count($this->getRequestParameter('config[advanced_full_search_fields]', array()))==0) {
                $ret = false;
                $this->getRequest()->setError('config{advanced_full_search_fields}', $i18n->__('Proszę wybrać co najmniej jedno pole.'));
            }
            if (count($this->getRequestParameter('config[simple_full_search_fields]', array()))==0) {
                $ret = false;
                $this->getRequest()->setError('config{simple_full_search_fields}', $i18n->__('Proszę wybrać co najmniej jedno pole.'));
            }
        }
        return $ret;
    }

    public function validateSearchLinkEdit()
    {
        $request = $this->getRequest();
        
        if ($request->getMethod() == sfRequest::POST) 
        {
            $data = $request->getParameter('search_link');

            $i18n = $this->getContext()->getI18N();

            if (!$data['title'])
            {
                $request->setError('search_link{title}', $i18n->__('Proszę uzupełnić pole.'));
            }
            elseif (!$this->isTitleValid($data['title'], $request->getParameter('culture'), $request->getParameter('id')))
            {
                $request->setError('search_link{title}', $i18n->__('Podany tytuł już istnieje'));
            }

            if (!$data['search_keywords'])
            {
                $request->setError('search_link{search_keywords}', $i18n->__('Proszę uzupełnić pole.'));
            }

            if (isset($data['url']) && !$data['url'] && $request->getParameter('id'))
            {
                $request->setError('search_link{url}', $i18n->__('Proszę uzupełnić pole.'));
            }
        }

        return !$request->hasErrors();
    }

    public function handleErrorSearchLinkEdit()
    {
        $ret = parent::handleErrorSearchLinkEdit();

        $this->getUser()->setParameter('hide', $this->search_link->isNew(), 'stSearchBackend/edit/fields/url');

        return $ret;
    }

    public function executeSearchLinkEdit()
    {
        $ret = parent::executeSearchLinkEdit();

        $this->getUser()->setParameter('hide', $this->search_link->isNew(), 'stSearchBackend/edit/fields/url');
        
        return $ret;
    }

    protected function isTitleValid($title, $culture, $id = null)
    {
        $c = new Criteria();
        $c->add(SearchLinkI18nPeer::TITLE, $title);
        $c->add(SearchLinkI18nPeer::CULTURE, $culture);
        
        if ($id)
        {
            $c->add(SearchLinkI18nPeer::ID, $id, Criteria::NOT_EQUAL);
        }

        return !SearchLinkI18nPeer::doCount($c);
    }
}
