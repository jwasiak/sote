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
 * @version     $Id: actions.class.php 16897 2012-01-30 13:35:08Z piotr $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */

/**
 * Klasa stSearchFrontendActions
 *
 * @package     stSearchPlugin
 * @subpackage  actions
 */
class stSearchFrontendActions extends stActions {

    /**
     * Akcja search
     */
    public function executeSearch() {
        $this->config = stConfig::getInstance($this->getContext(), 'stSearchBackend');
        $this->config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
        $this->config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());
        if ($this->config->get('enable_new') != 0)  {
            return $this->forward('stNewSearchFrontend','newSearch');
        }
        stSearchListener::generateIndexes();

        $this->searchDone = false;

        $this->smarty = new stSmarty($this->getModuleName());
        $this->productSmarty = new stSmarty('stProduct');
        $this->productSmarty->register_function('st_product_image_tag', 'st_product_smarty_image_tag');

        $config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');
        $config->load();
        $this->configProduct = $config;

        $this->config = stConfig::getInstance($this->getContext(), 'stSearchBackend');
        $this->config->load();

        $this->price_view = $config->get('price_view');
        $this->searchResults = null;

        $this->showAdvance = $this->getRequestParameter('showAdvance', null);
        if ($this->showAdvance) {
            $this->searchEngine = stAdvancedSearch::getInstance();
        } else {
            $this->searchEngine = stSimpleSearch::getInstance();
        }

        if ($this->hasRequestParameter('st_search'))
            $this->searchEngine->setParams($this->getRequestParameter('st_search', array('search' => $this->getRequestParameter('search', ''))));
        if ($this->hasRequestParameter('st_search_category'))
            $this->searchEngine->setParams($this->getRequestParameter('st_search_category', ''), 'st_search_category');
        if ($this->hasRequestParameter('sm_search'))
            $this->searchEngine->setParams($this->getRequestParameter('sm_search', array()), 'sm_search');

        if ($this->hasRequestParameter('st_search[name]')) {
            $this->what = stXssSafe::cleanHtml(mb_strtolower($this->getRequestParameter('st_search[name]', $this->getRequestParameter('search', '')), 'UTF-8'));
        } else {
            $this->what = stXssSafe::cleanHtml(mb_strtolower($this->getRequestParameter('st_search[search]', $this->getRequestParameter('search', '')), 'UTF-8'));
        }

        $this->searchResults = null;
        if (count($this->searchEngine->getAllParams())) {
            $this->searchEngine->addParam('sort_by', $this->getRequestParameter('sort_by', $this->config->get('order_field', 'default')));
            $this->searchEngine->addParam('sort_order', $this->getRequestParameter('sort_order', $this->config->get('order', 'desc')));
            $this->searchEngine->addParam('showAdvance', $this->showAdvance);

            $this->config = stConfig::getInstance($this->getContext(), 'stSearchBackend');
            $this->searchDone = true;

            if ($this->searchCriteria = $this->searchEngine->search($this->what)) {


                $pager = new sfPropelPager('Product');
                $pager->setCriteria($this->searchCriteria);
                $pager->setPeerMethod('doSelect');
                $pager->setPage($this->getRequestParameter('page', 1));
                $pager->setMaxPerPage($this->config->get('items_per_page'));
                $pager->init();
                $this->searchResults = $pager;

                $this->sort_data = $this->getSortData();
                $this->searchEngine->addStats($this->what, $pager->getNbResults());
            }
        }
    }

    protected function getSortData() {
        return array(
            'label_names' => array(
                'default' => 'Trafności',
                'name' => 'Nazwie',
                'price' => 'Cenie',
                'created_at' => 'Najnowszym',
            ),
            'table_names' => array(
                'default' => '',
                'name' => ProductI18nPeer::NAME,
                'price' => ProductPeer::PRICE,
                'created_at' => ProductPeer::CREATED_AT,
            ),
        );
    }



    public function executeAjaxSearchProduct() {
        $this->config = stConfig::getInstance($this->getContext(), 'stSearchBackend');
        if ($this->config->get('enable_new') != 0)  {
            return $this->forward('stNewSearchFrontend','ajaxSearchProduct');
        }

        $this->config = stConfig::getInstance($this->getContext(), 'stSearchBackend');

        $this->config->load();

        $query = stXssSafe::cleanHtml(urldecode($this->getRequestParameter('query')));

        $simple_search = stSimpleSearch::getInstance();

        $simple_search->addParam('sort_by', $this->getRequestParameter('sort_by', $this->config->get('order_field', 'default')));

        $simple_search->addParam('sort_order', $this->getRequestParameter('sort_order', $this->config->get('order', 'desc')));


        $c = $simple_search->search($query);

        $c->setLimit($this->config->get('items_per_page'));

        $products = ProductPeer::doSelect($c);

        $results = array();

        $suggestions = array();

        sfLoader::loadHelpers(array('Helper', 'stCurrency', 'stProductImage'));
        
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stSearchFrontendActions.myExecuteAjaxSearchProduct'));
        
        foreach ($products as $product) {
            
            if ($product->isPriceVisible()) {
                $pn = st_currency_format($product->getPriceNetto(true));
                $pb = st_currency_format($product->getPriceBrutto(true));
            } else {
                $pn = "";
                $pb = "";
            }

            $results[] = array(
                'image' => st_product_image_path($product, 'icon'),
                'name' => $product->getName(),
                'pn' => $pn,
                'pb' => $pb,
                'url' => $product->getUrl(),
                'id' => $product->getId());

            $suggestions[] = $product->getName();
        }

        $json = json_encode(array('query' => $query, 'data' => $results, 'suggestions' => $suggestions));

        return $this->renderText($json);
    }

    public function executeTypeahead()
    {
        sfLoader::loadHelpers(array('Helper', 'stCurrency', 'stProductImage', 'stUrl'));

        $query = $this->getRequestParameter('query');

        $results = array();

        if ($query)
        {
            $analyzer = stTextAnalyzer::getInstance($this->getUser()->getCulture());
            $keywords = array_keys($analyzer->analyze($query)); 

            if ($keywords)
            {
                $c = new Criteria();
                ProductPeer::addFilterCriteria($this->getContext(), $c, false);           
                ProductPeer::addSearchCriteria($c, $keywords, $this->getUser()->getCulture());
                ProductPeer::addSearchSortCriteria($query, $c, $this->getUser()->getCulture());
                $c->setLimit(100);

                $this->getDispatcher()->notify(new sfEvent($this, 'stSearchFrontendActions.executeTypeahead', array('criteria' => $c)));

                foreach (ProductPeer::doSelectForPager($c) as $product)
                {
                    if ($product->isPriceVisible())
                    {
                        $price = array(
                            'type' => $product->getConfiguration()->get('price_view'),
                            'netto' => st_currency_format($product->getPriceNetto(true)),
                            'brutto' => st_currency_format($product->getPriceBrutto(true)),
                        );
                    }
                    else
                    {
                        $price = array();
                    }

                    $results[] = array(
                        'id' => $product->getId(),
                        'image' => st_product_image_path($product, 'icon'),
                        'name' => $product->getName(),
                        'price' => $price,
                        'url' => st_url_for(array('module' => 'stProduct', 'action' => 'show', 'url' => $product->getUrl())),
                    );
                }
            }   
        } 

        return $this->renderJSON($results);
    }

}
