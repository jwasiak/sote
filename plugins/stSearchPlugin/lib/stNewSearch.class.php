<?php

class stNewSearch {
    // Search part
    protected $query = '';

    protected $query_keywords = array();

    protected $culture = '';

    protected $limit = 10;

    public $criteria = null;

    protected $config = null;

    protected $page = 0;

    public function __construct($query)
    {
        $this->loadConfig();
        $this->culture = sfContext::getInstance()->getUser()->getCulture();
        $analyzer = stTextAnalyzer::getInstance($this->culture);
        $this->query = $query;
        $this->query_keywords = array_keys($analyzer->analyze($query));
        $this->initSearch();
    }

    protected function loadConfig() {
        $this->config = stConfig::getInstance(sfContext::getInstance(), 'stSearchBackend');
        $this->limit = $this->config->get('items_per_page');
    }

    public function getQueryKeywords() {
        if (count($this->query_keywords)==0) $this->query_keywords = explode(' ',str_replace(array("\n","\t","\r","&nbsp;"),array(' ', ' ', ' ',' '), $this->query));
        return $this->query_keywords;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getPageLimit()
    {
        return $this->limit;
    }

    public function setPage($page) {
        $this->page = $page;
    }

    public function initSearch() {
        $config = stConfig::getInstance('stProduct');
        $config->load();

        $this->criteria = new Criteria();
        
        ProductPeer::addFilterCriteria(sfContext::getInstance(), $this->criteria);
        $this->criteria->remove(ProductPeer::PRODUCER_ID);


        ProductPeer::addSearchCriteria($this->criteria, $this->query_keywords, sfContext::getInstance()->getUser()->getCulture());
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stNewSearch.postAddCriteria', array('criteria' => $this->criteria)));
    }
    
    public function setLimit($limit) {
        $this->limit = $limit;
    }

    public function setOrderColumn($column, $direction = 'ASC') {
        if ($direction == 'ASC') $this->criteria->addAscendingOrderByColumn($column);
        else $this->criteria->addDescendingOrderByColumn($column);
    }

    public function getCriteria() {
        return $this->criteria;
    }

    public function countResults() {
        if (!$this->query_keywords)
        {
            return 0;
        }

        return ProductPeer::doCount($this->criteria);
    }

    public function getResults() {
        if (!$this->query_keywords)
        {
            return array();
        }

        $this->criteria->setLimit($this->limit);

        $this->criteria->setOffset($this->limit*$this->page);

        return ProductPeer::doSelect($this->criteria);
    }
    // Keywords generation part

    public static function buildIndexAllLanguages(Product $product)
    {
        foreach (LanguagePeer::doSelectActive() as $language)
        {
            $product->setCulture($language->getOriginalLanguage());
            self::buildIndex($product, true);
        }
    }

    public static function buildIndex(Product $product, $cleanup = false) 
    {
        $tags = array();

        if (!$cleanup)
        {
            $c = new Criteria();
            $c->add(ProductHasProductSearchTagPeer::PRODUCT_ID, $product->getId());
            $c->add(ProductHasProductSearchTagPeer::CULTURE, $product->getCulture());
            if (ProductHasProductSearchTagPeer::doCount($c) > 0)
            {
                return false;
            }
        }

        $analyzer = stTextAnalyzer::getInstance($product->getCulture());
        $config = stConfig::getInstance('stSearchBackend');
        
        $tags = $analyzer->analyze($product->getName(), $tags, 100);

        if ($config->get('code')) 
        {
            $tags = $analyzer->analyze($product->getCode(), $tags, 100);
        }

        if ($config->get('category')) 
        {
            $names = self::getCategoryNames($product);
            
            if ($names) 
            {
                $tags = $analyzer->analyze($names, $tags);
            }
        }
        
        if ($config->get('producer') && $product->getProducerId())
        {
            $tags = $analyzer->analyze(self::getProducerName($product), $tags);
        }

        if ($config->get('description') && $product->getDescription()) 
        {
            $tags = $analyzer->analyze($product->getDescription(), $tags);
        }
        
        if ($config->get('short_description') && $product->getShortDescription()) 
        {
            $tags = $analyzer->analyze($product->getShortDescription(), $tags);
        }

        if ($config->get('additional_description') && $product->getDescription2())
        {
            $tags = $analyzer->analyze($product->getDescription2(), $tags);   
        }

        if ($config->get('producer_code') && $product->getManCode()) 
        {
            $tags = $analyzer->analyze($product->getManCode(), $tags);
        }

        if ($config->get('options') && $product->getOptHasOptions() > 1)
        {
            $tags = $analyzer->analyze(self::getProductOptions($product), $tags);
        }

        if ($config->get('search_keywords') && $product->getSearchKeywords())
        {
            $tags = $analyzer->analyze($product->getSearchKeywords(), $tags);
        }        
        
        $tags = stEventDispatcher::getInstance()->filter(new sfEvent($product, 'stNewSearch.buildIndex'), $tags)->getReturnValue();

        if ($cleanup)
        {
            self::cleanupTags($product);
        }
        
        if ($tags)
        {
            self::insertTags($product, $tags);
        }
    }

    public static function cleanupTags($product)
    {
        $c = new Criteria();
        $c->add(ProductHasProductSearchTagPeer::PRODUCT_ID, $product->getId());
        $c->add(ProductHasProductSearchTagPeer::CULTURE, $product->getCulture());
        ProductHasProductSearchTagPeer::doDelete($c);
    }

    public static function insertTags($product, $tags)
    {
        $con = Propel::getConnection();

        $sql = sprintf("INSERT IGNORE %s (%s) VALUES", ProductSearchTagPeer::TABLE_NAME, ProductSearchTagPeer::TAG);

        $values = array();

        if (version_compare(PHP_VERSION, '7.0.0', '<')) 
        {
            foreach ($tags as $tag => $weight) 
            {
                $values[] = '(\''.mysql_real_escape_string($tag, $con->getResource()).'\')';
            }
        }
        else
        {
            foreach ($tags as $tag => $weight) 
            {
                $values[] = '(\''.mysqli_real_escape_string($con->getResource(), $tag).'\')';
            }
        }

        $con->executeQuery($sql.implode(',', $values));

        $c = new Criteria();
        $c->addSelectColumn(ProductSearchTagPeer::ID);
        $c->addSelectColumn(ProductSearchTagPeer::TAG);

        $c->add(ProductSearchTagPeer::TAG, array_keys($tags), Criteria::IN);

        $rs = ProductSearchTagPeer::doSelectRS($c);

        $values = array();

        $sql = sprintf("INSERT INTO %s (%s, %s, %s, %s) VALUES", 
            ProductHasProductSearchTagPeer::TABLE_NAME,
            ProductHasProductSearchTagPeer::PRODUCT_ID,
            ProductHasProductSearchTagPeer::PRODUCT_SEARCH_TAG_ID,
            ProductHasProductSearchTagPeer::CULTURE,
            ProductHasProductSearchTagPeer::TAG_VALUE
        );

        $product_id = $product->getId();

        $culture = $product->getCulture();

        while($rs->next())
        {
            list($id, $tag) = $rs->getRow();

            $values[] = '('.$product_id.','.$id.',\''.$culture.'\','.$tags[$tag].')';
        }

        if ($values) 
        {
            $con->executeQuery($sql.implode(',', $values));
        }
    }

    public static function str_highlight($text, $needle, $options = null, $highlight = null)
    {
        if ($highlight === null) {
            $highlight = '<strong>\1</strong>';
        }
     
        $pattern = '#(?!<.*?)(%s)(?![^<>]*?>)#'; 
        $pattern .= 'i';
     
        $needle = explode(' ',$needle);

        foreach ($needle as $needle_s) {
            if (!empty($needle_s)) {
                $needle_s = preg_quote($needle_s);
     
                $regex = sprintf($pattern, $needle_s);
                $text = preg_replace($regex, $highlight, $text);
            }
        }
     
        return $text;
    }

    public static function productPostSave(sfEvent $event)
    {
        $config = stConfig::getInstance('stSearchBackend');
        $product = $event['modelInstance'];

        if ($config->get('enable_new'))
        {
            self::buildIndex($product, true);
        }
    }

    protected static function getCategoryNames(Product $product)
    {
        $ids = array();

        $c = new Criteria();

        $c->addSelectColumn(CategoryPeer::ID);

        $c->addSelectColumn(CategoryPeer::LFT);

        $c->addSelectColumn(CategoryPeer::RGT);

        $c->addSelectColumn(CategoryPeer::SCOPE);

        $c->addJoin(ProductHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);

        $c->add(ProductHasCategoryPeer::PRODUCT_ID, $product->getId());

        $rs = CategoryPeer::doSelectRs($c);

        $ranges = array();

        while($rs->next())
        {
            $row = $rs->getRow();

            if ($row[0] != $row[3])
            {
                $ranges[] = sprintf("%s < %d AND %s > %d AND %s = %d", 
                    CategoryPeer::LFT,
                    $row[1],
                    CategoryPeer::RGT,
                    $row[2],
                    CategoryPeer::SCOPE,
                    $row[3]
                );
            }

            $ids[$row[0]] = $row[0];
        }  

        if (!$ranges)
        {
            return null;
        }

        $c = new Criteria();

        $c->add(CategoryPeer::LFT, implode(" OR ", $ranges), Criteria::CUSTOM);

        $c->addSelectColumn(CategoryPeer::ID);

        $c->addSelectColumn(CategoryPeer::SCOPE);

        $rs = CategoryPeer::doSelectRs($c);

        while($rs->next())
        {
            $row = $rs->getRow();

            $ids[$row[0]] = $row[0];
        } 

        if (!$ids)
        {
            return null;
        }

        $c = new Criteria();
        $c->addSelectColumn(CategoryI18nPeer::NAME);
        $c->addSelectColumn(CategoryPeer::OPT_NAME);
        $c->add(CategoryPeer::ID, $ids, Criteria::IN);
        $c->add(CategoryPeer::IS_ACTIVE, true);
        CategoryPeer::setHydrateMethod(array('stNewSearch', 'hydrateI18nName'));
        $tags = CategoryPeer::doSelectWithI18n($c, $product->getCulture());
        CategoryPeer::setHydrateMethod(null);      

        return $tags ? implode(' ', $tags) : null;      
    }

    protected static function getProducerName(Product $product)
    {
        $c = new Criteria();
        $c->addSelectColumn(ProducerI18nPeer::NAME);
        $c->addSelectColumn(ProducerPeer::OPT_NAME);        
        $c->add(ProducerPeer::ID, $product->getProducerId());
        ProducerPeer::setHydrateMethod(array('stNewSearch', 'hydrateI18nName'));
        $names = ProducerPeer::doSelectWithI18n($c, $product->getCulture());  
        ProducerPeer::setHydrateMethod(null);

        return $names ? $names[0] : null;
    }

    protected static function getProductOptions(Product $product)
    {
        $c = new Criteria();
        $c->addAsColumn('con1', sprintf("GROUP_CONCAT(DISTINCT IFNULL(%s, %s) SEPARATOR ' ')", ProductOptionsValueI18nPeer::VALUE, ProductOptionsValuePeer::OPT_VALUE));
        $c->addAsColumn('con2', sprintf("GROUP_CONCAT(DISTINCT %s SEPARATOR ' ')", ProductOptionsValuePeer::USE_PRODUCT));
        $c->addSelectColumn(ProductOptionsValuePeer::ID);
        $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product->getId());

        ProductOptionsValuePeer::setHydrateMethod(function(ResultSet $rs) {
            if ($rs->next())
            {
                $row = $rs->getRow();
                return $row[1] . ' ' . $row[2];
            }

            return '';
        });

        $result = ProductOptionsValuePeer::doSelectWithI18n($c, $product->getCulture());

        ProductOptionsValuePeer::setHydrateMethod(null);

        return $result;
    }

    public static function hydrateI18nName(ResultSet $rs)
    {
        $tags = array();

        while($rs->next())
        {
            $row = $rs->getRow();

            $tags[] = $row[0] ? $row[0] : $row[1]; 
        }

        return $tags;
    } 
}
