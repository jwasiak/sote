<?php
/**
 * SOTESHOP/stWebpagePlugin
 *
 * Ten plik należy do aplikacji stWebpagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stWebpagePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 7868 2010-08-25 14:30:12Z krzysiek $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/**
 * stWebpageBackend actions.
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>
 *
 * @package     stWebpagePlugin
 * @subpackage  actions
 */
class stWebpageBackendActions extends autostWebpageBackendActions
{

    public function executeList()
    {

        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStWebpageBackend/forward_parameters');

        $this->processSort();

        $this->processFilters();

        $this->filters = $this->getUser()->getAttributeHolder()->getAll('soteshop/stAdminGenerator/stWebpageBackend/list/filters');

        $max_per_page = $this->getUser()->getAttribute('list.max_per_page', array(), 'soteshop/stAdminGenerator/stWebpageBackend/config');

        $this->pager = new stPropelPager('Webpage', $max_per_page ? $max_per_page : 20);
        $c = new Criteria();
        $c->add(WebpageI18nPeer::OTHER_LINK, NULL, Criteria::ISNULL);
        $this->addSortCriteria($c);
        $this->addFiltersCriteria($c);
        $this->pager->setCriteria($c);
        $this->pager->setPage($this->getRequestParameter('page', 1));
        $this->pager->setPeerMethod('doSelectWithI18n');
        $this->pager->setPeerCountMethod('doCountWithI18n');
        $this->pager->init();

        $this->webpage_action_select_options = $this->getActionSelectControlOptions();

        $this->related_object = null;

    }

    public function addFiltersCriteria($c){
                
        // $c->add(WebpagePeer::OPT_URL, "app-terms", Criteria::NOT_EQUAL);
        // $c->add(WebpagePeer::OPT_URL, "app-privacy", Criteria::NOT_EQUAL);
        // $c->add(WebpagePeer::OPT_URL, "app-right2cancel", Criteria::NOT_EQUAL);
               
        $criterion = $c->getNewCriterion(WebpagePeer::OPT_URL, "app-terms", Criteria::NOT_EQUAL);
        $criterion->addAnd($c->getNewCriterion(WebpagePeer::OPT_URL, "app-privacy", Criteria::NOT_EQUAL));
        $criterion->addAnd($c->getNewCriterion(WebpagePeer::OPT_URL, "app-right2cancel", Criteria::NOT_EQUAL));
        $c->add($criterion);

        $c->addAscendingOrderByColumn("CREATED_AT");
        parent::addFiltersCriteria($c);     
    }

    public function validateEdit()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $data = $this->getRequestParameter('webpage');
            $terms = stConfig::getInstance('stCompatibilityBackend')->get('terms_in_mail_confirm_order_format');
            $right2Cancel = stConfig::getInstance('stCompatibilityBackend')->get('right_2_cancel_in_mail_confirm_order_format');

            if (($data['state'] == 'TERMS' && $terms == 'pdf' || $data['state'] == 'RIGHT2CANCEL' && $right2Cancel == 'pdf') && $this->getRequest()->getFileError('webpage[attachment]') == UPLOAD_ERR_OK && strpos($this->getRequest()->getFileName('webpage[attachment]'), '.pdf') === false)
            {
                $i18n = $this->getContext()->getI18N();
                $this->getRequest()->setError('webpage{attachment}', $i18n->__('Załączony plik musi być w formacie PDF'));
            }

            if (isset($data['generate_pdf']) && $data['generate_pdf'] && ini_get('max_execution_time') < 180 && !set_time_limit(180))
            {
                $i18n = $this->getContext()->getI18N();
                $this->getRequest()->setError('webpage{attachment}', $i18n->__('Automatycznego generowanie plików PDF wymaga ustawienie parametru PHP "max_execution_time" na minimum 180 sekund'));                
            }

            //echo stConfig::getInstance('appTermsBackend')->get('terms_on');        
                       
            if ($data['state'] == 'TERMS' && stConfig::getInstance('appTermsBackend')->get('terms_on')==1 && !$this->getRequest()->hasErrors())
            {    
                $config = stConfig::getInstance('appTermsBackend');
                $config->setCulture(sfContext::getInstance()->getRequest()->getParameter('culture', stLanguage::getOptLanguage()));

                $config->set('terms_field1', $data['terms_field1'], true);
                $config->set('terms_field2', $data['terms_field2'], true);                
                $config->set('terms_field3', $data['terms_field3'], true);
                $config->set('terms_field4', $data['terms_field4'], true);
                $config->set('terms_field5', $data['terms_field5'], true);
                $config->set('terms_field6', $data['terms_field6'], true);
                $config->set('terms_field7', $data['terms_field7'], true);
                $config->set('terms_field8', $data['terms_field8'], true);
                $config->set('terms_field9', $data['terms_field9'], true);
                $config->set('terms_field10', $data['terms_field10'], true);
                
                $config->set('terms_field11', $data['terms_field11'], true);
                $config->set('terms_field12', $data['terms_field12'], true);
                $config->set('terms_field13', $data['terms_field13'], true);
                
                $config->save();
            }
            
            if ($data['state'] == 'PRIVACY' && stConfig::getInstance('appTermsBackend')->get('privacy_on')==1 && !$this->getRequest()->hasErrors())
            {    
                $config = stConfig::getInstance('appTermsBackend');
                $config->setCulture(sfContext::getInstance()->getRequest()->getParameter('culture', stLanguage::getOptLanguage()));

                $config->set('privacy_field1', $data['privacy_field1'], true);                
                $config->set('privacy_field2', $data['privacy_field2'], true);
                $config->set('privacy_field3', $data['privacy_field3'], true);
                $config->set('privacy_field4', $data['privacy_field4'], true);
                $config->set('privacy_field5', $data['privacy_field5'], true);
                $config->save();
            }          
          

        }



        return !$this->getRequest()->hasErrors();
    }

    public function executeDeleteTerms()
    {
        $path = $this->getRequestParameter('path');
        $page = $this->getRequestParameter('page');
        
        
        if (is_file($path))
        {
          unlink($path);
        }                        
         
        $this->redirect("/webpage/edit?id=".$page);
    }

    public function executeLinksList()
    {

        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStWebpageBackend/links_forward_parameters');

        $this->processLinksSort();

        $this->processLinksFilters();

        $this->filters = $this->getUser()->getAttributeHolder()->getAll('soteshop/stAdminGenerator/stWebpageBackend/linksList/filters');

        $max_per_page = $this->getUser()->getAttribute('linksList.max_per_page', array(), 'soteshop/stAdminGenerator/stWebpageBackend/config');

        $this->pager = new stPropelPager('Webpage', $max_per_page ? $max_per_page : 20);
        $this->pager->setPeerMethod('doSelectWithI18n');
        $this->pager->setPeerCountMethod('doCountWithI18n');

        $c = new Criteria();
        $c->add(WebpagePeer::OPT_CONTENT, NULL, Criteria::ISNULL);
        $this->addLinksSortCriteria($c);
        $this->addLinksFiltersCriteria($c);
        $this->pager->setCriteria($c);
        $this->pager->setPage($this->getRequestParameter('page', 1));
        $this->pager->init();

        $this->webpage_action_select_options = $this->getLinksActionSelectControlOptions();

        $this->related_object = null;

    }

    protected function saveWebpage($webpage)
    {
        $ret = parent::saveWebpage($webpage);

        if ($this->getRequest()->getParameter('webpage_delete_attachment'))
        {
            $webpage->deleteAttachment();
        } 
        elseif ($this->getRequest()->getFileError('webpage[attachment]') == UPLOAD_ERR_OK)
        {
            $filepath = $webpage->getPdfAttachmentPath();
            $this->getRequest()->moveFile('webpage[attachment]', $filepath, 0644, true, 0755);
        }

        return $ret;
    }

    protected function updateWebpageGroupMainWebpageGroupFromRequest()
    {
        $webpage_group = $this->getRequestParameter('webpage_group');
        if (isset($webpage_group['show_header']))
        {
            $c = new Criteria();
            $c ->add(WebpageGroupPeer::SHOW_HEADER, 1);
            $webpages_group_object = WebpageGroupPeer::doSelectOne($c);
            if ($webpages_group_object)
            {
                $webpages_group_object->setShowHeader(0);
                $webpages_group_object->save();
            }
        }
        parent::updateWebpageGroupMainWebpageGroupFromRequest();
    }

    protected function updateWebpageFromRequest() {
        $data = $this->getRequestParameter('webpage');

        if (isset($data['state']) && !empty($data['state'])) {
            $c = new Criteria();
            $c->add(WebpagePeer::STATE, $data['state']);
            $c->add(WebpagePeer::ID, $this->getRequestParameter('id'), Criteria::NOT_EQUAL);
            $webpages = WebpagePeer::doSelect($c);
            foreach ($webpages as $webpage) {
                $webpage->setState(NULL);
                $webpage->save();
            }
        }

        parent::updateWebpageFromRequest();

        if (isset($data['generate_pdf'])) {
            $this->webpage->setGeneratePdf((bool)$data['generate_pdf']);
        }

        if (!isset($data['state']) || empty($data['state']))
            $this->webpage->setState(NULL);
    }

    protected function updateLinksWebpageFromRequest() {
        parent::updateLinksWebpageFromRequest();
        $webpage = $this->getRequestParameter('webpage');

        $this->webpage->setUrl(NULL);

        if ($webpage['target']!=1)
        {
            $this->webpage->setTarget(NULL);
        }
    }
}
