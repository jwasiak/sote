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
 * @version     $Id: stSimpleSearch.php 16897 2012-01-30 13:35:08Z piotr $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */

/**
 * Klasa stSimpleSearch
 *
 * @package     stSearchPlugin
 * @subpackage  libs
 */
class stSimpleSearch extends stSearch {

    public $codes = array();

    protected static $searchFields = array();

    protected static $instance = null;

    public static function getInstance() {
        if ( ! isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class();
            self::$instance->initialize();
        }
        return self::$instance;
    }

    public function search($what = '') {
        $this->c = parent::search($what);
        // zapisz wyszukiwanie
        $this->what = $what;

        // rozdziel słowa i zapisz je
        $this->generateWords($what);
        $this->swapWords();

        // przekierowuje jezeli ktores ze slow spelni warunke
        $this->doRedirect();

        if (!count($this->codes) && !count($this->words)) {
            return null;
        }

        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stSearchFrontend.SimpleCriteria.pre', array('searchCriteria'=>$this->c, 'customCriteria'=>$this->customCriteria)));
        $this->doSimpleSearch($this->c);
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stSearchFrontend.SimpleCriteria.post', array('searchCriteria'=>$this->c, 'customCriteria'=>$this->customCriteria)));
        if (is_object($this->customCriteria)) {
            $this->c->add($this->customCriteria);
        }

        return $this->c;
    }

    protected function generateWords($what = '') {
        if (sfContext::getInstance()->getRequest()->getParameter('st_search[detail]',0))
            $simple = $this->searchConfig->get('simple_full_search_fields');
        else
            $simple = $this->searchConfig->get('simple_search_fields');

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
            if (strlen($word) && isset($simple['product_code']) && $simple['product_code']) $this->codes[] = mysql_real_escape_string($word);
        }
    }

    /**
     * Wymienia slowa
     */
    protected function swapWords() {

        $c = new Criteria();
        $c->add(SearchedWordsPeer::WORD,$this->words,Criteria::IN);

        $c2 = new Criterion($c,SearchedWordsPeer::SWAP,null,Criteria::ISNOTNULL);
        $c3 = new Criterion($c,SearchedWordsPeer::SWAP,'',Criteria::NOT_EQUAL);

        $c->addAnd($c3);
        $c->addAnd($c2);

        $replace = SearchedWordsPeer::doSelect($c);

        foreach ($replace as $word) {
            $index = array_search($word->getWord(), $this->words);
            $this->words[$index] =  mysql_real_escape_string($word->getSwap());

            $index = array_search($word->getWord(), $this->codes);
            $this->codes[$index] =  mysql_real_escape_string($word->getSwap());
        }
    }

    /**
     * Sprawdza czy nalezy przekierowac zapytanie
     */
    protected function doRedirect() {
        $this->testRedirect(array($this->what));
        $this->testRedirect($this->words);
    }

    /**
     * Sprawdza czy nalezy pirzekierowac i wykonuje przekierowanie
     *
     * @param   unknown_type $words
     */
    protected function testRedirect($words = array()) {

        $c = new Criteria();
        $c->add(SearchedWordsPeer::WORD,$this->words,Criteria::IN);

        $c2 = new Criterion($c,SearchedWordsPeer::URL,null,Criteria::ISNOTNULL);
        $c3 = new Criterion($c,SearchedWordsPeer::URL,'',Criteria::NOT_EQUAL);

        $c2->addAnd($c3);
        $c->addAnd($c2);

        $redirect = SearchedWordsPeer::doSelect($c);

        // wykonaj przekierowanie, tylko gdy wystepuje jeden wynik
        if (count($redirect)==1) {
            sfContext::getInstance()->getController()->redirect($redirect[0]->getUrl(),0,302);
            throw new sfStopException();
        }
    }

    /**
     * Tworzy kryteria wyszukiwnia dla poszczegolnych slow
     *
     * @param        string      $word
     * @param        object      $c
     */
    public function doSimpleSearch($c) {
        $ret = false;
        $cWords = null;
        $cCodes = null;
        if (count($this->words)) {
            $c->add(ProductSearchIndexPeer::CULTURE, $this->culture);
            $c->addJoin(ProductPeer::ID, ProductSearchIndexPeer::ID);
            $words = explode(' ',str_replace('-','_',implode(' ',$this->words)));

            if (!$this->searchConfig->get('match_full_words')) {
                foreach ($words as $key=>$word)
                    $words[$key] = rtrim($word, '_')."*";
            }

            if (sfContext::getInstance()->getRequest()->getParameter('st_search[and_search]', $this->searchConfig->get('simple_and_search'))) {
                //wyszukaj produkty ktore zawieraja wylacznie
                if (sfContext::getInstance()->getRequest()->getParameter('st_search[detail]',0)) {
                    $cWords = $c->getNewCriterion(ProductSearchIndexPeer::NAME, 'MATCH('.ProductSearchIndexPeer::NAME.', '.ProductSearchIndexPeer::SIMPLE_SEARCH.') AGAINST(\'+'.implode(' +',$words).'\' IN BOOLEAN MODE)', Criteria::CUSTOM);
                } else {
                    $cWords = $c->getNewCriterion(ProductSearchIndexPeer::NAME, 'MATCH('.ProductSearchIndexPeer::NAME.') AGAINST(\'+'.implode(' +',$words).'\' IN BOOLEAN MODE)', Criteria::CUSTOM);
                }
            } else {
                if (sfContext::getInstance()->getRequest()->getParameter('st_search[detail]',0)) {
                    $cWords = $c->getNewCriterion(ProductSearchIndexPeer::NAME, 'MATCH('.ProductSearchIndexPeer::NAME.', '.ProductSearchIndexPeer::SIMPLE_SEARCH.') AGAINST(\''.implode('* ',$words).'\' IN BOOLEAN MODE)', Criteria::CUSTOM);
                } else {
                    $cWords = $c->getNewCriterion(ProductSearchIndexPeer::NAME, 'MATCH('.ProductSearchIndexPeer::NAME.') AGAINST(\''.implode(' ',$words).'\' IN BOOLEAN MODE)', Criteria::CUSTOM);
                }
            }
        }
        $cCodes = null;
        if (count($this->codes)) {
            if (sfContext::getInstance()->getRequest()->getParameter('st_search[detail]',0))
                $simple = $this->searchConfig->get('simple_full_search_fields');
            else
                $simple = $this->searchConfig->get('simple_search_fields');

            if (isset($simple['product_code']) && $simple['product_code']) {
                $cCodes = $c->getNewCriterion(ProductPeer::CODE, $this->codes, Criteria::IN);
            }
            $ret = true;
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
                    $order_sql = '(MATCH('.ProductSearchIndexPeer::NAME.', '.ProductSearchIndexPeer::SIMPLE_SEARCH.') AGAINST(\''.implode(' ',$words).'\'))';
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

    public static function buildIndex($item, $culture='pl_PL') {
        $config = stConfig::getInstance(sfContext::getInstance(), 'stSearchBackend');
        $config->load();
        $item->setCulture($culture);

        if ($config->get('enable_new')==1) {stNewSearch::buildIndex($item, true); return true;}

        $name = '';
        $data = '';

        if (count(self::$searchFields)==0)
            stEventDispatcher::getInstance()->notify(new sfEvent(self::$searchFields, 'stSimpleSearch.generateIndexes', array()));

        $fast = $config->get('simple_search_fields');
        $full = $config->get('simple_full_search_fields');

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
            $productIndex->setCulture($item->getCulture());            
            $productIndex->setId($item->getId());
        }

        $productIndex->setName($name);
        $productIndex->setSimpleSearch($data);
        $productIndex->save();
    }

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
