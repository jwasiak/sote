<?php

class stGoogleShopping extends stPriceCompareGenerateFile implements stPriceCompareGenerateFileInterface {

    /**
     * Konfiguracja
     * 
     * @var stConfig
     */
    protected $config;

    /**
     * Obsługa zdarzeń
     *
     * @var stEventDispatcher
     */
    protected $dispatcher;

    public function __construct() {
        parent::__construct(__CLASS__);
        $this->config = stConfig::getInstance('stGoogleShoppingBackend');
        $this->dispatcher = stEventDispatcher::getInstance();
    }

    public function getStepsCount() {
        $c = new Criteria();
        $c->add(GoogleShoppingPeer::ACTIVE, 1);
        $c->add(ProductPeer::ACTIVE, 1);
        $c->add(ProductPeer::IS_GIFT, 0);
        $c2 = $c->getNewCriterion(ProductPeer::HIDE_PRICE, null, Criteria::ISNULL);
        $c3 = $c->getNewCriterion(ProductPeer::HIDE_PRICE, 0);
        $c2->addOr($c3);
        $c->add($c2);
        if ($this->config->get('stock')) {
            $c4 = $c->getNewCriterion(ProductPeer::STOCK, null, Criteria::ISNULL);
            $c5 = $c->getNewCriterion(ProductPeer::STOCK, 0, Criteria::GREATER_THAN);
            $c4->addOr($c5);
            $c->add($c4);
        }
        $this->count = GoogleShoppingPeer::doCountJoinAll($c);
        return intval(ceil($this->count/$this->productsByStep));
    }

    protected function getProducts($step) {
        $c = new Criteria();
        $c->add(GoogleShoppingPeer::ACTIVE, 1);
        $c->add(ProductPeer::ACTIVE, 1);
        $c->add(ProductPeer::IS_GIFT, 0);
        $c2 = $c->getNewCriterion(ProductPeer::HIDE_PRICE, null, Criteria::ISNULL);
        $c3 = $c->getNewCriterion(ProductPeer::HIDE_PRICE, 0);
        $c2->addOr($c3);
        $c->add($c2);
        if ($this->config->get('stock')) {
            $c4 = $c->getNewCriterion(ProductPeer::STOCK, null, Criteria::ISNULL);
            $c5 = $c->getNewCriterion(ProductPeer::STOCK, 0, Criteria::GREATER_THAN);
            $c4->addOr($c5);
            $c->add($c4);
        }
        $c->setOffset($this->productsByStep*$step);
        $c->setLimit($this->productsByStep);
        $c->addAscendingOrderByColumn(GoogleShoppingPeer::PRODUCT_ID);
        return GoogleShoppingPeer::doSelectJoinAll($c);
    }

    public function getConfig($name) {
        return $this->config->get($name, null);
    }

    protected function getFileHead() {
        $content = xml_open_tag('?xml version="1.0"?');
        $content.= xml_open_tag('rss version="2.0" xmlns:g="http://base.google.com/ns/1.0"');
        $content.= xml_open_tag('channel');
        $content.= xml_cdata_tag('title', $this->config->get('title'));
        $content.= xml_tag('link', $this->getHomepageUrl(stLanguage::getOptLanguage()));
        $content.= xml_cdata_tag('description', $this->config->get('description'));
        return $content;
    }

    protected function getFileFoot() {
        return xml_close_tag('channel').xml_close_tag('rss');
    }

    protected function getFileBody($step) {

        $priceCompareProducts = $this->getProducts($step);

        $content = "";

        $google_category = is_dir(sfConfig::get('sf_plugins_dir')."/smGoogleShoppingCategoryPlugin");

        $google_product_category = is_dir(sfConfig::get('sf_plugins_dir')."/appGoogleProductCategoryPlugin");

        foreach ($priceCompareProducts as $priceCompareProduct) {
            /**
             * @var Product
             */
            $product = $priceCompareProduct->getProduct();

            $this->dispatcher->notify(new sfEvent($this, 'stGoogleShopping.modifyProduct', array('product' => $product)));

            $product->resetModified();

            $parsedProduct = new stPriceCompareProductParser($product);

            if ($parsedProduct->checkProduct()) {
                $productName = $parsedProduct->getName();

                /**
                 * @deprecated 7.0.8.5 use stGoogleShopping.modifyProduct instead
                 */
                $this->dispatcher->notify(new sfEvent($this, 'stGoogleShoppingPlugin.changeName', array()));

                switch ($this->config->get('type_id')) {
                    case 'product_id':
                        $product_id = $parsedProduct->getId();
                        break;                    
                    case 'product_code':
                        $product_id = $parsedProduct->getCode();
                        break;
                    default:
                        $product_id = $parsedProduct->getId();
                        break;
                }

                $productContent = xml_tag('g:id', $product_id);
       
                $productContent.= xml_tag('g:gtin', $parsedProduct->getManCode());
                $productContent.= xml_tag('g:mpn', $parsedProduct->getMpnCode());                                                     
                
                if ($parsedProduct->hasManCode() || $parsedProduct->hasMpnCode()){                    
                    $identifier_exists = 'tak';  
                }else{
                    $identifier_exists = 'nie';     
                }
                $productContent.= xml_tag('g:identifier_exists', $identifier_exists);
                
                $productContent.= xml_cdata_tag('g:title', mb_substr($productName, 0, 70, 'UTF-8'));

                switch ($this->config->get('desc_type')) {
                    case 'full':
                        $desc = $parsedProduct->getDescription();
                        break;
                    case 'short':
                        $desc = $parsedProduct->getShortDescription();
                        break;
                    case 'additional':
                        $desc = $parsedProduct->getDescription2();
                        break;
                    default:
                        $desc = $parsedProduct->getDescription();
                        break;
                }

                $productContent.= xml_cdata_tag('g:description', $this->parseDesc($desc));
                $productContent.= xml_cdata_tag('g:product_type', $parsedProduct->getCategory(' > '));

                $productContent.= xml_tag('g:link', $this->getProductUrl($product, stLanguage::getOptLanguage()));

                $productContent.= xml_tag('g:image_link', $parsedProduct->getPhoto());
                $productContent.= xml_tag('g:condition', 'new');                                
                
                $productContent.= xml_tag('g:availability', $this->getAvailabilityById($parsedProduct->getPriceCompareAvailability($this, 2)));
                if($parsedProduct->getWeight()){
                    $productContent.= xml_tag('g:shipping_weight', $parsedProduct->getWeight().' Kg');
                }
               
                
                if($priceCompareProduct->getSalePrice()!=0){
                    $productContent.= xml_cdata_tag('g:sale_price', str_replace(',', '.',  $priceCompareProduct->getSalePrice()).' PLN');
                    $productContent.= xml_tag('g:price', $parsedProduct->getPrice().' PLN');     
                }
                elseif($parsedProduct->getOldPrice()!=0){
                    $productContent.= xml_cdata_tag('g:sale_price', $parsedProduct->getPrice().' PLN');
                    $productContent.= xml_tag('g:price', $parsedProduct->getOptOldPriceBrutto().' PLN');   
                }else{
                    $productContent.= xml_tag('g:price', $parsedProduct->getPrice().' PLN');
                }                                                
                
                
                if ($parsedProduct->hasProducer()){
                    $productContent.= xml_cdata_tag('g:brand', $parsedProduct->getProducer());                    
                }


                $productContent.= xml_open_tag('g:shipping');

                $productContent.= xml_cdata_tag('g:country', 'PL');
                
                //$productContent.= xml_cdata_tag('g:price', str_replace(',', '.',  $priceCompareProduct->getShippingPrice()).' PLN');

                if($priceCompareProduct->getShippingPrice()!=""){
                    $productContent.= xml_cdata_tag('g:price', str_replace(',', '.',  $priceCompareProduct->getShippingPrice()).' PLN');
                }else{
                    $productContent.= xml_cdata_tag('g:price', str_replace(',', '.',  $this->config->get('shipping')).' PLN');                    
                }
                
                


                $productContent.= xml_close_tag('g:shipping');
                
                if ($google_category){
                    
                    if ($parsedProduct->getDefaultCategory()->getGoogleCategory()){
                        $productContent.= xml_tag('g:google_product_category', $parsedProduct->getDefaultCategory()->getGoogleCategory());
                    }
                }

                if ($google_product_category){
                    
                    if ($parsedProduct->getDefaultCategory()->getGoogleCategory()){
                        $productContent.= xml_tag('g:google_product_category', $parsedProduct->getDefaultCategory()->getGoogleCategory());
                    }
                }    
                
                $productContent = $this->dispatcher->filter(new sfEvent($this, 'stGoogleShopping.getFileBodyFilter', array('product' => $parsedProduct)), $productContent)->getReturnValue();
                    
                $content.= xml_tag('item', $productContent);
            }
            unset($parsedProduct);
        }
        return $content;
    }

    static public function getGoogleShoppingAvailabilities() {
        return array(0 => __('W magazynie'), 1 => __('Niedostępny'), 2 => __('Zamówienie przedpremierowe'));
    }

    public function getAvailabilityById($id) {
        $availabilities = array(0 => 'in stock',
                                1 => 'out of stock',
                                2 => 'preorder',                                
        );
        return isset($availabilities[$id]) ? $availabilities[$id] : $availabilities[2];
    }

    static public function getProduct($object = null) {
        return stPriceCompareGenerateFile::getProductForExport(__CLASS__, $object);
    }

    static public function setProduct($object = null, $active = 0) {
        return stPriceCompareGenerateFile::setProductForImport(__CLASS__, $object, $active);
    }

    public function parseDesc($description) {
        return mb_substr(strip_tags(preg_replace('/<script(.*)<\\/script>/sU', '', $description)), 0, 5000, 'UTF-8');
    }
}
