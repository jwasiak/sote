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
 * @version     $Id: components.class.php 13911 2011-07-01 11:46:25Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPositioningBackendComponents
 *
 * @package     stPositioningPlugin
 * @subpackage  actions
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */
class stPositioningBackendComponents extends autostPositioningBackendComponents
{
    /**
     * Edycja pliku robots.txt
     */
    public function executeRobotFile()
    {
        $i18n = $this->getContext()->getI18N();
        if ($this->getRequest()->getMethod() == sfRequest::POST && $this->getRequest()->hasParameter('positioning[fileContent]'))
        {
            stFile::write('robots.txt', $this->getRequest()->getParameter('positioning[fileContent]'));
            $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'), false);
        }

        if ($this->getRequestParameter('restore', false)) {
            $baseFile = sfConfig::get('sf_root_dir').'/install/db/robots.base';
            stFile::write('robots.txt', file_exists($baseFile) ? file_get_contents($baseFile) : '');
        }
        
        $this->fileContent = stFile::read('robots.txt');
    }

    /**
     * Typ w edycji produktu
     */
    public function executeProductType() {
        $positioning = new stProductMetaTagsGenerator();
        $this->positioning_data = $this->getPositioningData($positioning, $this->product_has_positioning->getProduct(), $this->product_has_positioning);
    }

    /**
     * Typ w edycji kategorii
     */
    public function executeCategoryType() {
        $positioning = new stCategoryMetaTagsGenerator();
        $this->positioning_data = $this->getPositioningData($positioning, $this->category_has_positioning->getCategory(), $this->category_has_positioning);
    }

    /**
     * Typ w edycji grup produktów
     */
    public function executeProductGroupType() {
        $positioning = new stProductGroupMetaTagsGenerator();
        $this->positioning_data = $this->getPositioningData($positioning, $this->product_group_has_positioning->getProductGroup(), $this->product_group_has_positioning);
    }

    /**
     * Typ w edycji stron www
     */
    public function executeWebpageType() {
        $positioning = new stWebpageMetaTagsGenerator();
        $this->positioning_data = $this->getPositioningData($positioning, $this->webpage_has_positioning->getWebpage(), $this->webpage_has_positioning);
    }

    /**
     * Typ w edycji producenta
     */
    public function executeProducerType()
    {
      $positioning = new stProducerMetaTagsGenerator();
      $this->positioning_data = $this->getPositioningData($positioning, $this->producer_has_positioning->getProducer(), $this->producer_has_positioning);
    }

    /**
     * Typ w edycji bloga
     */
    public function executeBlogType()
    {
      $positioning = new stBlogMetaTagsGenerator();
      $this->positioning_data = $this->getPositioningData($positioning, $this->blog_has_positioning->getBlog(), $this->blog_has_positioning);
    }

    protected function getPositioningData($metaGenerator, $object, $hasPositioning) {
        $positioning_data = array();

        $positioning = PositioningPeer::doSelectDefaultValues();
        $positioning->setCulture($this->getRequestParameter('language'));

        $positioning_data[] = array( 'title' => $positioning->getTitle(),
                                    'desc' => $positioning->getDescription(),
                                    'keywords' => $positioning->getKeywords());

        $positioning_data[] = array( 'title' => $hasPositioning->getTitle(),
                                    'desc' => $hasPositioning->getDescription(),
                                    'keywords' => $hasPositioning->getKeywords());

        $metaGenerator->generate($object);
        $positioning_data[] = array( 'title' => $metaGenerator->getTitle(),
                                    'desc' => $metaGenerator->getDescription(),
                                    'keywords' => $metaGenerator->getKeywords());

        if (strlen(trim($hasPositioning->getTitle().$hasPositioning->getDescription().$hasPositioning->getKeywords()))== 0) {
            $positioning_data[1] = $positioning_data[2];
        }

        return $positioning_data;
    }

    /**
     * Generowanie mapy serwisu
     */
    public function executeSitemap() {
        $this->config = stConfig::getInstance($this->getContext());

        $i18n = $this->getContext()->getI18N();

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $sitemap = $this->getRequestParameter('sitemap',array());
            $this->config->set('langs',isset($sitemap['langs'])?$sitemap['langs']:array());
            $this->config->set('verify',isset($sitemap['verify'])?$sitemap['verify']:'');
            $this->config->set('seolinks',isset($sitemap['seolinks'])?$sitemap['seolinks']:'');
            if (!$this->getRequest()->hasErrors())
            {
                $this->config->save();
                if (!$this->getRequestParameter('save_and_generate',0))
                $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'),false);
            }
            $this->langs = $this->config->get('langs');
        } else {

            $this->config->load();
            $this->langs = $this->config->get('langs');
            if (!is_array($this->langs) || count($this->langs)==0) {
                $language = LanguagePeer::doSelectDefault();
                $this->langs = array();
                $this->langs[$language->getShortcut()] = $language->getOriginalLanguage();
            }
        }
        
        $c = new Criteria();
        $c->add(LanguagePeer::ACTIVE,1);
        $this->languages = LanguagePeer::doSelect($c);
        $c = new Criteria();
        $c->add(LanguageHasDomainPeer::IS_DEFAULT, 1);
        $this->domains = LanguageHasDomainPeer::doSelect($c);
    }

    public function executeGenerateSitemap() {
        $categoryCount = CategoryPeer::doCount(new Criteria());

        $c = new Criteria();
        $c->add(ProductGroupPeer::OPT_NAME,null, Criteria::ISNOTNULL);
        $productGroupCount = ProductGroupPeer::doCount($c);

        $c = new Criteria();
        $c->add(WebpagePeer::ACTIVE, 1);
        $c->add(WebpagePeer::OPT_CONTENT, null, Criteria::ISNOTNULL);
        $webpageCount = WebpagePeer::doCount($c);

        $c = new Criteria();
        $c->add(BlogPeer::ACTIVE, 1);
        $blogCount = BlogPeer::doCount($c);

        $c = new Criteria();
        $config = stConfig::getInstance('stProduct');
        $c->add(ProductPeer::ACTIVE,1);
        if ($config->get('show_without_price'))
        {
            $c->add(ProductPeer::PRICE,0,Criteria::GREATER_THAN);
        }
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stProductActions.postAddProductCriteria', array('criteria' => $c)));
        $ProductCount = ProductPeer::doCount($c);

        $this->count = $categoryCount + $productGroupCount + $webpageCount + $blogCount + $ProductCount;
        
        $config = stConfig::getInstance($this->getContext());
        $config->load();
        $this->langs = $config->get('langs');
    }

    /**
     * Edycja pliku robots.txt
     */
    public function executeVerifySearch()
    {

        $this->config = stConfig::getInstance($this->getContext());

        $i18n = $this->getContext()->getI18N();

        $current = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.sfConfig::get('sf_web_dir_name');

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $verify = $this->getRequestParameter('verify',array());

            $this->config->set('verify',isset($verify['verify'])?$verify['verify']:'');

            $verify_file = $this->getRequest()->getFileName('verify[file]');

            if (!$this->getRequest()->hasErrors())
            {
                if ($verify_file)
                {   
                    $this->getRequest()->moveFile('verify[file]', $current."/".$verify_file);
                }

                $this->config->save();

                $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'),false);
            }
        }

        $this->domainsVerify = $this->config->get('verify');

        $c = new Criteria();
        
        $c->add(LanguageHasDomainPeer::IS_DEFAULT, 1);
        
        $this->domains = LanguageHasDomainPeer::doSelect($c);
        
        $files = scandir($current);

        $this->added_files = array();

        foreach ($files as $key => $file)
        {
            if ((strpos($file, "google")!== false) || (strpos($file, "yandex")!== false) || (strpos($file, "BingSiteAuth")!== false))
            {
                 $this->added_files[$key] = $file;
            }
        }

    }

     /**
     * Edycja pliku robots.txt
     */


    public function execute404links()
    {
        $i18n = $this->getContext()->getI18N();
        if ($this->getRequest()->getMethod() == sfRequest::POST && $this->getRequest()->hasParameter('404links[fileContent]'))
        {
            stFile::write('404_links.txt', $this->getRequest()->getParameter('404links[fileContent]'));
            $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'), false);
        }
        
        $this->fileContent = stFile::read('404_links.txt');
    }


}
