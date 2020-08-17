<?php

class stNewSearchFrontendActions extends stActions {

    public function executeNewSearch() {
        $this->smarty = new stSmarty($this->getModuleName());
        $query = $this->getRequestParameter('query',$this->getRequestParameter('st_search[search]',''));
        $this->search = new stNewSearch($query);

        ProductPeer::addSearchSortCriteria($query, $this->search->getCriteria(), $this->getUser()->getCulture());

        $this->search->setPage($this->getRequestParameter('page',0));

        if (empty($query)) $this->results = array(); 
        else $this->results = $this->search->getResults();

        $this->isAjax = $this->getRequest()->isXmlHttpRequest();
    }

    public function executeNewSearchAjax() {
        $this->smarty = new stSmarty($this->getModuleName());
        $query = $this->getRequestParameter('query',$this->getRequestParameter('st_search[search]',''));
        $this->search = new stNewSearch($query);
        ProductPeer::addSearchSortCriteria($query, $this->search->getCriteria(), $this->getUser()->getCulture());
        $this->results = $this->search->getResults();
        
        sfLoader::loadHelpers(array('Helper', 'stCurrency', 'stProductImage'));

        foreach ($this->results as $product) {
            $results[] = content_tag('li',stNewSearch::str_highlight(mb_strtolower($product->getName(),'UTF-8'),mb_strtolower(implode(' ',$this->search->getQueryKeywords()),'UTF-8')));
        }

        return $this->renderText('<ul>'.implode("\n",$results)."</ul>");
    }

    public function executeAjaxSearchProduct() {
        sfLoader::loadHelpers(array('Helper', 'stCurrency', 'stProductImage'));

        $this->smarty = new stSmarty($this->getModuleName());
        $query = $this->getRequestParameter('query',$this->getRequestParameter('st_search[search]',''));
        $search = new stNewSearch($query);
        ProductPeer::addSearchSortCriteria($query, $search->getCriteria(), $this->getUser()->getCulture());
        $products = $search->getResults();
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
}
