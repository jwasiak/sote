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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stSitemapGenerator.class.php 16783 2012-01-19 10:27:23Z piotr $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */

/**
 * Klasa stSitemapGenerator
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */
class stSitemapGenerator {

    /**
     * Pozycja początku linków dla produkty
     * @var integer
     */
    protected $productStart = 0;

    /**
     * Pozycja początku linków dla grup produktów
     * @var integer
     */
    protected $productGroupStart = 0;

    /**
     * Pozycja początku linków dla stron www
     * @var integer
     */
    protected $webpageStart = 0;

    /**
     * Pozycja początku linków dla bloga
     * @var integer
     */
    protected $blogStart = 0;

    /**
     * Pozycja początku linków dla kategorii
     * @var integer
     */
    protected $categoryStart = 0;

    /**
     * Wiadomosc dla progressBara
     * @var string
     */
    protected $msg = '';

    /**
     * tablica linków do zapisania
     * @var array
     */
    protected $writeData = array();

    /**
     * limit linków dla jednego pliku xml
     * @var integer
     */
    protected $linksPerPage = 1000;

    /**
     * Uchwyt pliku do zapisu
     * @var object
     */
    protected $fileHandle = false;

    /**
     * Dostępne języki dla tworzenia linków
     * @var array
     */
    protected $langs = array();

    /**
     * Konfiguracja modulu pozycjonowania
     * @var object
     */
    protected $config = null;

    /**
     * Adres sklepu
     * @var string
     */
    protected $host = '';

    /**
     * Domyslny jezyk
     * @var string
     */
    protected $defalutLang = '';

    protected $lang = 'pl_PL';
    
    protected $culture = 'pl_PL';

    /**
     * Konstruktor klasy
     * @return null
     */
    public function __construct() {

        sfLoader::loadHelpers('Helper');
        sfLoader::loadHelpers('Tag');
        sfLoader::loadHelpers('stUrl');

        $this->caclualteItems();
        $context = sfContext::getInstance();
        $this->config = stConfig::getInstance($context,null,'stPositioningBackend');
        $this->config->load();
        $context->getRequest()->setScriptNameByApp('frontend');
        $this->addRouting();
    }

    /**
     * Destruktor klasy
     */
    public function __destruct() {
        $context = sfContext::getInstance();
        $context->getRequest()->setScriptNameByApp(null);
    }

    protected function addRouting() {
        stPluginHelper::addRouting('stBackendProductUrlLang', '/:lang/:url.html', 'stProduct', 'show', 'backend', array(), array('lang' => '[a-z]{2,4}'));
        stPluginHelper::addRouting('stBackendProductUrl', '/:url.html', 'stProduct', 'show', 'backend');
        stPluginHelper::addRouting('stBackendProductCategoryUrlLang3', '/category/:lang/:url', 'stProduct', 'list', 'backend', array(), array('lang' => '[a-z]{2,4}'));
        stPluginHelper::addRouting('stBackendProductCategoryUrl3', '/category/:url', 'stProduct', 'list', 'backend');
        stPluginHelper::addRouting('stBackendWebpageUrlLang', '/webpage/:lang/:url.html', 'stWebpageFrontend', 'index', 'backend');
        stPluginHelper::addRouting('stBackendWebpageUrl', '/webpage/:url.html', 'stWebpageFrontend', 'index', 'backend');
        stPluginHelper::addRouting('stBackendBlogUrlLang', '/blog/:lang/:url.html', 'stBlogFrontend', 'index', 'backend');
        stPluginHelper::addRouting('stBackendBlogUrl', '/blog/:url.html', 'stBlogFrontend', 'index', 'backend');
        stPluginHelper::addRouting('stBackendProductGroupUrlLang4', '/group/:lang/:url', 'stProduct', 'groupList', 'backend', array(), array('lang' => '[a-z]{2,4}'));
        stPluginHelper::addRouting('stBackendProductGroupUrl4', '/group/:url', 'stProduct', 'groupList', 'backend');
    }

    /**
     * Funkja progressBara
     *
     * @param $step integer
     */
    public function step($step, $lang = null) {
        $this->initLangs($lang);
        $this->openFile($step);
        $prevStep = $step;
        $old_conf = sfConfig::get('sf_no_script_name');
        sfConfig::set('sf_no_script_name',1);

        if ($step<$this->productGroupStart) {
            $step += $this->processCategory($step);
        } elseif ($step<$this->webpageStart) {
            $step += $this->processProductGroup($step-$this->productGroupStart);
        } elseif ($step<$this->blogStart) {
            $step += $this->processWebpage($step-$this->webpageStart);
        } elseif ($step<$this->productStart) {
            $step += $this->processBlog($step-$this->blogStart);
        } else {
            $step += $this->processProduct($step-$this->productStart);
        }
        $this->writeDatatoFile($prevStep);
        $this->closeFile();

        sfConfig::set('sf_no_script_name',$old_conf);

        return $step;
    }

    protected function initLangs($lang) {
        $this->langs = array('pl'=>'pl_PL');
        $this->host = sfContext::getInstance()->getRequest()->getHost();
        $this->defalutLang = $shortcut = 'pl';
        $this->culture = 'pl_PL';

        $c = new Criteria();
        $c->add(LanguagePeer::LANGUAGE, $lang);
        $langO = LanguagePeer::doSelectOne($c);
        if (is_object($langO)) {
            $this->langs = array($langO->getShortcut()=>$langO->getOriginalLanguage());
            $this->culture = $langO->getOriginalLanguage();
            $shortcut = $langO->getShortcut();
        }
        $domains = LanguageHasDomainPeer::doSelectByLanguageShortcut($shortcut);
        foreach ($domains as $domain) {
            if ($domain->getIsDefault()) {
                $this->host = $domain->getDomain();
                $this->defalutLang = $shortcut;
            }
        }

        $this->lang = $shortcut;
    }

    /**
     *  Oblicza liczbe poszczegolnych elemento mapy strony
     *
     */
    protected function caclualteItems() {
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

        $config = stConfig::getInstance('stProduct');
        $c->add(ProductPeer::ACTIVE,1);
        if ($config->get('show_without_price'))
        {
            $c->add(ProductPeer::PRICE,0,Criteria::GREATER_THAN);
        }
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stProductActions.postAddProductCriteria', array('criteria' => $c)));
        $ProductCount = ProductPeer::doCount($c);

        $this->productGroupStart = $categoryCount;
        $this->webpageStart = $this->productGroupStart + $productGroupCount;
        $this->blogStart = $this->webpageStart + $webpageCount;
        $this->productStart = $this->blogStart + $blogCount;
    }

    /**
     * Generuje linki dla kategorii
     * @param $step integer
     */
    protected function processCategory($step) {
        $i18n = sfContext::getInstance()->getI18N();
        
        $c = new Criteria();
        $c->setLimit(20);
        $c->setOffset($step);
        $categeories = CategoryPeer::doSelect($c);

        $config = stConfig::getInstance(sfContext::getInstance(), array( 'show_without_price' => stConfig::BOOL),'stProduct' );
        $config->load();
        $c = new Criteria();
        $c->add(ProductPeer::ACTIVE,1);
        if ($config->get('show_without_price'))
        {
            $c->add(ProductPeer::PRICE,0,Criteria::GREATER_THAN);
        }
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stProductActions.postAddProductCriteria', array('criteria' => $c)));
        $c->addJoin(ProductPeer::ID, ProductHasCategoryPeer::PRODUCT_ID);
        $c->addJoin(ProductHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);

        foreach ($categeories as $category) {

            $c->add(CategoryPeer::LFT, $category->getLft(), Criteria::GREATER_EQUAL);
            $c->add(CategoryPeer::RGT, $category->getRgt(), Criteria::LESS_EQUAL);

            if (ProductPeer::doCount($c) == 0) {$this->writeData[]=''; continue;}


            if ($category->getIsActive() == 1)
            {
            foreach ($this->langs as $key=>$value) {
                $category->setCulture($value);
                try {$friendyurl = $category->getFriendlyUrl();} catch (Exception $e) {$friendyurl = "";}
                if (!empty($friendyurl)) {
                    $this->writeData[] = $this->generateSitemapLink(st_url_for("stProduct/list?url=".$category->getFriendlyUrl(),true, 'frontend', $this->host, $key), $category->getUpdatedAt(DATE_ATOM), 0.8);
                } else {
                    $this->writeData[] = $this->generateSitemapLink(st_url_for('stProduct/list?id_category='.$category->getId()."&lang=".$key,true, 'frontend', $this->host, $key), $category->getUpdatedAt(DATE_ATOM), 0.8);
                }
            }
            }else{
                {$this->writeData[]=''; continue;}
            }
        }
        $this->msg = $i18n->__('Generuje mape witryny dla kategorii', array(), 'stPositioningBackend');
        return count($categeories);
    }

    /**
     * Generuje linki dla grup produktów
     * @param $step integer
     */
    protected function processProductGroup($step) {
        $i18n = sfContext::getInstance()->getI18N();
        
        $c = new Criteria();
        $c->setLimit(20);
        $c->setOffset($step);
        $c->add(ProductGroupPeer::OPT_NAME,null, Criteria::ISNOTNULL);
        $productGroups = ProductGroupPeer::doSelect($c);

        foreach ($productGroups as $productGroup) {
            foreach ($this->langs as $key=>$value) {
                try {$friendyurl = $productGroup->getFriendlyUrl();} catch (Exception $e) {$friendyurl = "";}
                $productGroup->setCulture($value);
                if (!empty($friendyurl)) {
                    $this->writeData[] = $this->generateSitemapLink(st_url_for("stProduct/groupList?url=".$productGroup->getFriendlyUrl(),true, 'frontend', $this->host, $key), $productGroup->getUpdatedAt(DATE_ATOM), 0.5);
                } else {
                    $this->writeData[] = $this->generateSitemapLink(st_url_for('stProduct/list?group_id='.$productGroup->getId()."&lang=".$key,true, 'frontend', $this->host, $key), $productGroup->getUpdatedAt(DATE_ATOM), 0.5);
                }
            }
        }
        $this->msg = $i18n->__('Generuje mape witryny dla grup produktów', array(), 'stPositioningBackend');
        return count($productGroups);
    }

    /**
     * Generuje linki dla stron www
     * @param $step integer
     */
    protected function processWebpage($step) {
        $i18n = sfContext::getInstance()->getI18N();
        
        $c = new Criteria();
        $c->setLimit(20);
        $c->setOffset($step);
        $c->add(WebpagePeer::ACTIVE, 1);
        $c->add(WebpagePeer::OPT_CONTENT, null, Criteria::ISNOTNULL);
        $webpages = WebpagePeer::doSelect($c);

        foreach ($webpages as $webpage) {
            foreach ($this->langs as $key=>$value) {
                $webpage->setCulture($value);
                try {$friendyurl = $webpage->getFriendlyUrl();} catch (Exception $e) {$friendyurl = "";}
                if (!empty($friendyurl)) {
                    $this->writeData[] = $this->generateSitemapLink(st_url_for("stWebpageFrontend/index?url=".$webpage->getFriendlyUrl(),true, 'frontend', $this->host, $key), $webpage->getUpdatedAt(DATE_ATOM), 0.8);
                } else {
                    $this->writeData[] = $this->generateSitemapLink(st_url_for('stWebpageFrontend/index?webpage_id='.$webpage->getId()."&lang=".$key,true, 'frontend', $this->host, $key), $webpage->getUpdatedAt(DATE_ATOM), 0.8);
                }
            }
        }
        $this->msg = $i18n->__('Generuje mape witryny dla stron www', array(), 'stPositioningBackend');

        return count($webpages);
    }

    /**
     * Generuje linki dla bloga
     * @param $step integer
     */
    protected function processBlog($step) {
        $i18n = sfContext::getInstance()->getI18N();
        
        $c = new Criteria();
        $c->setLimit(20);
        $c->setOffset($step);
        $c->add(BlogPeer::ACTIVE, 1);
        $blogs = BlogPeer::doSelect($c);

        foreach ($blogs as $blog) {
            foreach ($this->langs as $key=>$value) {
                $blog->setCulture($value);
                try {$friendyurl = $blog->getFriendlyUrl();} catch (Exception $e) {$friendyurl = "";}
                if (!empty($friendyurl)) {
                    $this->writeData[] = $this->generateSitemapLink(st_url_for("stBlogFrontend/index?url=".$blog->getFriendlyUrl(),true, 'frontend', $this->host, $key), $blog->getUpdatedAt(DATE_ATOM), 0.8);
                } else {
                    $this->writeData[] = $this->generateSitemapLink(st_url_for('stBlogFrontend/index?blog_id='.$blog->getId()."&lang=".$key,true, 'frontend', $this->host, $key), $blog->getUpdatedAt(DATE_ATOM), 0.8);
                }
            }
        }
        $this->msg = $i18n->__('Generuje mape witryny dla bloga', array(), 'stPositioningBackend');

        return count($blogs);
    }

    /**
     * Generuje linki dla produktów
     * @param $step integer
     */
    protected function processProduct($step) {
        $i18n = sfContext::getInstance()->getI18N();
        
        $c = new Criteria();
        $c->setLimit(20);
        $c->setOffset($step);

        $config = stConfig::getInstance('stProduct');
        $c->add(ProductPeer::ACTIVE,1);
        if ($config->get('show_without_price'))
        {
            $c->add(ProductPeer::PRICE,0,Criteria::GREATER_THAN);
        }
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stProductActions.postAddProductCriteria', array('criteria' => $c)));
        $products = ProductPeer::doSelect($c);

        foreach ($products as $product) {
            foreach ($this->langs as $key=>$value) {
                $product->setCulture($value);
                try {$friendyurl = $product->getFriendlyUrl();} catch (Exception $e) {$friendyurl = "";}
                if (!empty($friendyurl)) {
                    $this->writeData[] = $this->generateSitemapLink(st_url_for("stProduct/show?url=".$product->getFriendlyUrl(),true, 'frontend', $this->host, $key), $product->getUpdatedAt(DATE_ATOM), 1.0);
                } else {
                    $this->writeData[] = $this->generateSitemapLink(st_url_for('stProduct/show?id='.$product->getId()."&lang=".$key,true, 'frontend', $this->host, $key), $product->getUpdatedAt(DATE_ATOM), 1.0);
                }
            }
        }
        $this->msg = $i18n->__('Generuje mape witryny dla produktów', array(), 'stPositioningBackend');

        return count($products);
    }

    /**
     * funkcja pomocnicza generujaca przyjazny link
     * @param $loc string
     * @param $lastmod string;
     * @param $priority double
     * @param $changefreq string
     */
    protected function generateSitemapLink($loc, $lastmod, $priority=0.5, $changefreq = 'weekly') {
        return content_tag('url',content_tag('loc',$loc).content_tag('lastmod',$lastmod).content_tag('priority',$priority).content_tag('changefreq',$changefreq));
    }

    /**
     * Zapisuje dane do pliku
     * @param $step integer
     */
    protected function writeDatatoFile($step) {
        $file_index = $step?floor($step/$this->linksPerPage):0;
        foreach ($this->writeData as $data) {
            if ($this->fileHandle === false) $this->openFile($step);
            if (!empty($data)) fputs($this->fileHandle,$data."\n");
            $step++;
            $new_file_index = $step?floor($step/$this->linksPerPage):0;
            if ($new_file_index != $file_index) {
                $this->writeFooter();
                $file_index = $new_file_index;
            }
        }
    }

    /**
     * Zapisuje nagłówek pliku
     *
     */
    protected function writeHeader() {
        fputs($this->fileHandle,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
        fputs($this->fileHandle,'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n");
    }

    /**
     * Zapisuje stopke pliku
     *
     */
    protected function writeFooter() {
        fputs($this->fileHandle,'</urlset>'."\n");
        $this->closeFile();
    }

    /**
     * Otwiera plik xml do zapisu
     */
    protected function openFile($step) {
        if ($this->fileHandle === false) {
            $file_index = $step?floor($step/$this->linksPerPage):0;
            $filename = sfConfig::get('sf_cache_dir').DIRECTORY_SEPARATOR.'sitemap_index_'.$this->lang.'_'.$file_index.'.xml';
            if (!file_exists($filename)) {
                $this->fileHandle = fopen($filename,'a+');
                $this->writeHeader();
            } else {
                $this->fileHandle = fopen($filename,'a+');
            }
        }
    }

    /**
     * Zamyka plik xml
     *
     */
    protected function closeFile() {
        if ($this->fileHandle) {
            fclose($this->fileHandle);
        }
        $this->fileHandle=false;
    }

    /**
     * Inicjalizacja progressBara
     *
     */
    public function init() {
        $filename = sfConfig::get('sf_cache_dir').DIRECTORY_SEPARATOR.'sitemap_index_*.xml';
        $files = glob($filename);
        foreach($files as $file) {
            unlink($file);
        }
    }

    /**
     * Zwraca wiadomość do progressBara
     *
     */
    public function getMessage()
    {
        return $this->msg;
    }

    /**
     * Konczy prace progressBara
     *
     */
    public function close() {
        $this->initLangs($this->getLangFromFunction(sfContext::getInstance()->getRequest()->getParameterHolder()->get('name')));

        $progressBarInformation = sfContext::getInstance()->getUser()->getAttribute('stPositioning_sitemap_'.$this->culture, array(), 'soteshop/stProgressBarPlugin');
        if ($progressBarInformation['steps']%$this->linksPerPage) {
            $steps = $progressBarInformation['steps'];
            $this->openFile($steps);
            $this->writeFooter();
        }
        $this->generateGlobalSiteMap();
        sfLoader::loadHelpers('Helper');
        sfLoader::loadHelpers('Url');
        sfLoader::loadHelpers('stAdminGenerator');
        $this->msg = sfContext::getInstance()->getI18N()->__('Mapa witryny', null, 'stPositioningBackend').": ".st_external_link_to("http://".$this->host."/sitemap_".$this->lang.".xml", "http://".$this->host."/sitemap_".$this->lang.".xml", array('target'=>'_new'));
    }

    /**
     * Tworzy główny plik z sitemap
     *
     */
    protected function generateGlobalSiteMap() {
        $filename = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'xml'.DIRECTORY_SEPARATOR.'sitemap_index_'.$this->lang.'_*.xml';
        $files = glob($filename);
        foreach($files as $file) {
            unlink($file);
        }
        $fh = fopen(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'sitemap_'.$this->lang.'.xml','w+');

        fputs($fh,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
        fputs($fh,'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n");

        $filename = sfConfig::get('sf_cache_dir').DIRECTORY_SEPARATOR.'sitemap_index_'.$this->lang.'_*.xml';
        $files = glob($filename);
        foreach($files as $file) {
            rename($file,sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'xml'.DIRECTORY_SEPARATOR.basename($file));
            fputs($fh,content_tag('sitemap',
            content_tag('loc',sfContext::getInstance()->getController()->genUrl("http://".$this->host.'/xml/'.basename($file),true)).
            content_tag('lastmod',date(DATE_ATOM))
            )."\n");
        }

        fputs($fh,'</sitemapindex>'."\n");
        fclose($fh);
    }

    public function __call($method, $args = array())
    {
        if (strpos($method, 'step') === 0)
        {
            $x = explode("_", $method, 2);
            return $this->step($args[0], $x[1]);
        }
        else
        {
            throw new Exception(sprintf('Method %s does not exist', $method));
        }
    }

    protected function getLangFromFunction($method) {
        $x = explode("_", $method,3);
        if (count($x)==3) {
            return $x[2];
        }
        return 'pl_PL';
    }
    
    public static function getDefaultDomainForLang($shortcut) {
        $domains = LanguageHasDomainPeer::doSelectByLanguageShortcut($shortcut);
        foreach ($domains as $domain) {
            if ($domain->getIsDefault()) {
                return $domain->getDomain();
            }
        }
        return sfContext::getInstance()->getRequest()->getHost();
    }
}
