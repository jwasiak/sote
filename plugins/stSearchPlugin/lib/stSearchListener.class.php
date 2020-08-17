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
 * @version     $Id: stSearchListener.class.php 5669 2010-06-21 12:31:25Z piotr $
 */

class stSearchListener {
    public static function priceLimitAdv(sfEvent $event) {
        $tmp = $event->getParameters();
        $searchCriteria = $tmp['searchCriteria'];

        $action = sfContext::getInstance()->getRequest();

        if (class_exists('Currency')) {
            $currenct = stCurrency::getInstance(sfContext::getInstance())->get()->getExchange();
        } else {
            $currenct = 1.0;
        }

        if ($priceFrom = stXssSafe::cleanHtml($action->getParameter('st_search[price_from]'))) {
            $query = sprintf("(%s / %f) +0.005 >= %f",ProductPeer::OPT_PRICE_BRUTTO,$currenct,$priceFrom);
            $criterion_from = $searchCriteria->getNewCriterion(ProductPeer::PRICE,$query,Criteria::CUSTOM);
        }

        if ($priceTo = stXssSafe::cleanHtml($action->getParameter('st_search[price_to]'))) {
            $query = sprintf("(%s / %f) -0.005 <= %f",ProductPeer::OPT_PRICE_BRUTTO,$currenct,$priceTo);
            $criterion_to = $searchCriteria->getNewCriterion(ProductPeer::PRICE,$query,Criteria::CUSTOM);
        }

        if ($priceFrom && $priceTo) {
            $criterion_from->addAnd($criterion_to);
            $searchCriteria->add($criterion_from);
        } elseif ($priceFrom) {
            $searchCriteria->add($criterion_from);
        } elseif ($priceTo) {
            $searchCriteria->add($criterion_to);
        }


    }

    public static function producerLimitAdv(sfEvent $event) {
        if ($producer = stXssSafe::cleanHtml(sfContext::getInstance()->getRequest()->getParameter('st_search[producer]'))) {
            $customCriteria = $event->getSubject()->c;
            $customCriteria->add(ProductPeer::PRODUCER_ID,$producer);
        }
    }

    public static function categoryLimitAdv(sfEvent $event) {
        $categories = sfContext::getInstance()->getRequest()->getParameter('st_search_category',array());
        if (count($categories)) {
        	$selected = CategoryPeer::retrieveByPks($categories);
            $customCriteria = $event->getSubject()->c;
            $customCriteria->addJoin(ProductPeer::ID,ProductHasCategoryPeer::PRODUCT_ID);
        	
            $tmp = array();
            foreach ($selected as $item)
            {
            	$tmp[] ="(".CategoryPeer::SCOPE."=".$item->getScope()." AND ".CategoryPeer::LFT.">=".$item->getLft()." AND ".CategoryPeer::RGT."<=".$item->getRgt().")";
            }
            
            $customsql =  	"(".ProductHasCategoryPeer::CATEGORY_ID." IN (SELECT ".CategoryPeer::ID." FROM ".CategoryPeer::TABLE_NAME.
            				" WHERE ".implode (' OR ',$tmp) ;
            
            $customsql.="))";
            
            $customCriteria->add(ProductHasCategoryPeer::CATEGORY_ID, $customsql, Criteria::CUSTOM);
            $customCriteria->setDistinct(true);
        }
    }

    public static function generateIndexes() {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
        $con = Propel::getConnection();

        $sql = 'SHOW KEYS FROM `st_product_search_index` WHERE Key_name LIKE "simple_search"';
        $stmt = $con->PrepareStatement($sql);
        $rs = $stmt->executeQuery();

        if (!$rs->next()) {
            $sql = 'ALTER TABLE `st_product_search_index` ADD FULLTEXT `simple_search`(`name` ,`simple_search`)';
            $stmt = $con->PrepareStatement($sql);
            $rs = $stmt->executeQuery();
        }

        $sql = 'SHOW KEYS FROM `st_product_search_index` WHERE Key_name LIKE "advanced_search"';
        $stmt = $con->PrepareStatement($sql);
        $rs = $stmt->executeQuery();
        if (!$rs->next()) {
            $sql = 'ALTER TABLE `st_product_search_index` ADD FULLTEXT `advanced_search` (`advanced_name` ,`advanced_search`)';
            $stmt = $con->PrepareStatement($sql);
            $rs = $stmt->executeQuery();
        }
    }

    public static function fixGeneratedIndexes() {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
        $con = Propel::getConnection();

        $sql = 'TRUNCATE TABLE `st_product_search_index`';
        $stmt = $con->PrepareStatement($sql);
        $rs = $stmt->executeQuery();

        $sql = 'ALTER TABLE `st_product_search_index` DROP INDEX `advanced_search`';
        $stmt = $con->PrepareStatement($sql);
        $rs = $stmt->executeQuery();

        $sql = 'ALTER TABLE `st_product_search_index` ADD FULLTEXT `advanced_search` (`advanced_name` ,`advanced_search`)';
        $stmt = $con->PrepareStatement($sql);
        $rs = $stmt->executeQuery();
    }

    public static function importProductIndex(sfEvent $event) {
        $item = $event['modelInstance'];
        $config = stConfig::getInstance('stSearchBackend');
        $languages = LanguagePeer::doSelect(new Criteria());

        if (!$config->get('enable_new'))
        {
            foreach ($languages as $lang) {
                stSimpleSearch::getInstance()->buildIndex($item, $lang->getOriginalLanguage());
                stAdvancedSearch::getInstance()->buildIndex($item, $lang->getOriginalLanguage());
            }
        } 
        else
        {
            stNewSearch::buildIndex($item, true);   
        }

    }

    public static function generateSimpleIndexes(sfEvent $event) {
        stSimpleSearch::addIndexField('product_name', 'stSimpleSearch::productGetName');
        stSimpleSearch::addIndexField('product_code', 'stSimpleSearch::productGetCode');
        stSimpleSearch::addIndexField('product_short_desc', 'stSimpleSearch::productGetShortDesc');
        stSimpleSearch::addIndexField('product_long_desc', 'stSimpleSearch::productGetLongDesc');
        stSimpleSearch::addIndexField('product_keywords', 'stSimpleSearch::productGetKeywords');
        stSimpleSearch::addIndexField('product_producer', 'stSimpleSearch::productGetProducer');
    }

    public static function generateAdvancedIndexes(sfEvent $event) {
        stAdvancedSearch::addIndexField('product_name', 'stAdvancedSearch::productGetName');
        stAdvancedSearch::addIndexField('product_code', 'stAdvancedSearch::productGetCode');
        stAdvancedSearch::addIndexField('product_short_desc', 'stAdvancedSearch::productGetShortDesc');
        stAdvancedSearch::addIndexField('product_long_desc', 'stAdvancedSearch::productGetLongDesc');
        stAdvancedSearch::addIndexField('product_keywords', 'stAdvancedSearch::productGetKeywords');
        stAdvancedSearch::addIndexField('product_producer', 'stAdvancedSearch::productGetProducer');
    }
}

?>
