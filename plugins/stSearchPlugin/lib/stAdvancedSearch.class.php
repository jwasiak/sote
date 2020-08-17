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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stSimpleSearch.php 617 2009-04-09 13:02:31Z michal $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */

/**
 * class stAdvancedSearch
 *
 * @package     stSearchPlugin
 * @subpackage  libs
 */
class stAdvancedSearch extends stSearch {

    /**
     * Search config fields
     * @var array
     */
    protected static $searchFields = array();

    /**
     * Instance
     * @var object
     */
    protected static $instance = null;

    public $codes = array();

    /**
     * Create or return instance of object stAdvancedSearch
     * @return object
     */
    public static function getInstance() {
        if ( ! isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class();
            self::$instance->initialize();
        }
        return self::$instance;
    }

    /**
     * Main search function
     * @param string $what
     * @return object
     */
    public function search($what = '') {
        $args = $this->getAllParams();
        if (!is_array($args) || count($args)==0)return null;

        $this->c = parent::search($what);
        $this->what = $what;

        $this->generateWords($what);

        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stSearchFrontend.AdvanceCriteria.pre', array('searchCriteria'=>$this->c, 'customCriteria'=>$this->customCriteria)));
        $this->doAdvancedSearch($this->c);
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stSearchFrontend.AdvanceCriteria.post', array('searchCriteria'=>$this->c, 'customCriteria'=>$this->customCriteria)));

        if (is_object($this->customCriteria)) {
            $this->c->add($this->customCriteria);
        }
        $this->addParam('showAdvance',true);
        return $this->c;
    }

    /**
     * Split search string into words
     * @param string $what
     */
    protected function generateWords($what = '') {
        if (sfContext::getInstance()->getRequest()->getParameter('st_search[detail]',0))
            $advanced = $this->searchConfig->get('advanced_full_search_fields');
        else
            $advanced = $this->searchConfig->get('advanced_search_fields');
                	
		$items = split("[\(\)\n\r\t ]+",stSearch::rebuildSearchIndex($what));
        $items = array_unique($items);

            foreach ($items as $word) {
            $word = trim($word,"'\"!:;.,");
            if (strlen($word)) {
            	$this->words[] = mysql_real_escape_string(str_pad($word, stSearch::getMinLen(), '_', STR_PAD_RIGHT));
            }
        }
        
        $items = split("[\(\)\n\r\t ]+",$what);
        $items = array_unique($items);
        foreach ($items as $word) {
            $word = trim($word,"'\"!:;.,");
            if (strlen($word) && isset($advanced['product_code']) && $advanced['product_code']) $this->codes[] = mysql_real_escape_string($word);
        }
    }

    /**
     * Prepare criteria for search
     * @param object $c
     */
    public function doAdvancedSearch($c) {
        $cWords = null;
        if (count($this->words)) {
            $c->add(ProductSearchIndexPeer::CULTURE, $this->culture);
            $c->addJoin(ProductPeer::ID, ProductSearchIndexPeer::ID);
            $words = explode(' ',str_replace('-','_',implode(' ',$this->words)));

            if (!$this->searchConfig->get('match_full_words')) {
                foreach ($words as $key=>$word) $words[$key] = rtrim($word, '_')."*";
            }

            if (sfContext::getInstance()->getRequest()->getParameter('st_search[and_search]')) {
                //wyszukaj produkty ktore zawieraja wylacznie
                if (sfContext::getInstance()->getRequest()->getParameter('st_search[detail]',0)) {
                    $cWords = $c->getNewCriterion(ProductSearchIndexPeer::ADVANCED_NAME, 'MATCH('.ProductSearchIndexPeer::ADVANCED_NAME.', '.ProductSearchIndexPeer::ADVANCED_SEARCH.') AGAINST(\'+'.implode(' +',$words).'\' IN BOOLEAN MODE)', Criteria::CUSTOM);
                } else {
                    $cWords = $c->getNewCriterion(ProductSearchIndexPeer::ADVANCED_NAME, 'MATCH('.ProductSearchIndexPeer::ADVANCED_NAME.') AGAINST(\'+'.implode(' +',$words).'\' IN BOOLEAN MODE)', Criteria::CUSTOM);
                }
            } else {
                if (sfContext::getInstance()->getRequest()->getParameter('st_search[detail]',0)) {
                    $cWords = $c->getNewCriterion(ProductSearchIndexPeer::ADVANCED_NAME, 'MATCH('.ProductSearchIndexPeer::ADVANCED_NAME.', '.ProductSearchIndexPeer::ADVANCED_SEARCH.') AGAINST(\''.implode(' ',$words).'\' IN BOOLEAN MODE)', Criteria::CUSTOM);
                } else {
                    $cWords = $c->getNewCriterion(ProductSearchIndexPeer::ADVANCED_NAME, 'MATCH('.ProductSearchIndexPeer::ADVANCED_NAME.') AGAINST(\''.implode(' ',$words).'\' IN BOOLEAN MODE)', Criteria::CUSTOM);
                }
            }
        }

        $cCodes = null;
        if (count($this->codes)) {
            if (sfContext::getInstance()->getRequest()->getParameter('st_search[detail]',0))
                $advanced = $this->searchConfig->get('advanced_full_search_fields');
            else
                $advanced = $this->searchConfig->get('advanced_search_fields');

            if (isset($advanced['product_code']) && $advanced['product_code']) {
                $cCodes = $c->getNewCriterion(ProductPeer::CODE, $this->codes, Criteria::IN);
            }
        }

        if (is_object($cWords) && is_object($cCodes)) {
            $cWords->addOr($cCodes);
            $c->add($cWords);
        } elseif (is_object($cWords)) {
            $c->add($cWords);
        } elseif (is_object($cCodes)) {
            $c->add($cCodes);
        }
        $this->addOrder($c);
    }

    public function addOrder($c) {
        $type = null;
        switch ($this->getParam('sort_by')) {
            case 'name':
                $c->addJoin(ProductPeer::ID,ProductI18nPeer::ID);
                $c->add(ProductI18nPeer::CULTURE,$this->culture);
                $order_sql = ProductI18nPeer::NAME;
                break;
            case 'price':
                $order_sql = ProductPeer::OPT_PRICE_BRUTTO;
                break;
            case 'created_at':
                $order_sql = ProductPeer::CREATED_AT;
                break;
            default:
                if (count($this->words)) {
                    $words = explode(' ',str_replace('-','_',implode(' ',$this->words)));
                    $order_sql = '(MATCH('.ProductSearchIndexPeer::ADVANCED_NAME.', '.ProductSearchIndexPeer::ADVANCED_SEARCH.') AGAINST(\''.implode(' ',$words).'\'))';
                    $type = Criteria::CUSTOM;
                } else {
                    $c->addJoin(ProductPeer::ID,ProductI18nPeer::ID);
                    $c->add(ProductI18nPeer::CULTURE,$this->culture);
                    $order_sql = ProductI18nPeer::NAME;
                }
                break;
        }
        if ($this->getParam('sort_order')=='desc') $c->addDescendingOrderByColumn($order_sql, $type);
        else $c->addAscendingOrderByColumn($order_sql, $type);
    }

    public static function addIndexField($field, $func) {
        self::$searchFields[$field] = array('name' => $field,
                'func' => $func);
    }

    /**
     * Build product indexes for advance search
     * @param object $item
     * @param string $culture
     */
    public static function buildIndex($item, $culture='pl_PL') {
        $config = stConfig::getInstance(sfContext::getInstance(), 'stSearchBackend');
        $config->load();
        $item->setCulture($culture);

        if ($config->get('enable_new')==1) {return true;}

        if (count(self::$searchFields)==0)
            stEventDispatcher::getInstance()->notify(new sfEvent(self::$searchFields, 'stAdvancedSearch.generateIndexes', array()));

        $name = '';
        $data = '';

        $fast = $config->get('advanced_search_fields');
        $full = $config->get('advanced_full_search_fields');

        foreach(self::$searchFields as $key=>$value) {
            if (isset($fast[$key]) && $fast[$key] != 0 || strpos($key,'custom')!==false) $name = $name.' '.call_user_func(self::$searchFields[$key]['func'],$item);
            if (isset($full[$key]) && $full[$key] != 0 || strpos($key,'custom')!==false) $data = $data.' '.call_user_func(self::$searchFields[$key]['func'],$item);
        }

        $name = stSearch::rebuildSearchIndex($name);
        $data = stSearch::rebuildSearchIndex($data);

        $c = new Criteria();
        $c->add(ProductSearchIndexPeer::ID, $item->getId());
        $c->add(ProductSearchIndexPeer::CULTURE, $item->getCulture());
        $productIndex = ProductSearchIndexPeer::doSelectOne($c);

        if (!is_object($productIndex)) {
            $productIndex = new ProductSearchIndex();
            $productIndex->setId($item->getId());
            $productIndex->setCulture($item->getCulture());
        }

        $productIndex->setAdvancedName($name);
        $productIndex->setAdvancedSearch($data);
        $productIndex->save();
    }

    /**
     * Handle product save
     * @param $event
     */
    public static function productSave(sfEvent $event) {
        $config = stConfig::getInstance('stSearchBackend');
        $product = $event['modelInstance'];
        if (!$config->get('enable_new'))
        {
            $languages = LanguagePeer::doSelectActive(new Criteria());
            foreach ($languages as $lang) {
                self::buildIndex($product, $lang->getOriginalLanguage());
            }
        }
    }
}

?>
