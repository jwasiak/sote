<?php
/**
 * 
 * @author Sote
 *
 */
class stSearchOptimize 
{
    /**
     * Products per step
     * @var integer
     */
    protected $limit = 25;


    protected $config = null;
    /**
     * public construcotr
     * @return unknown_type
     */
    public function __construct() 
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
        $this->config= stConfig::getInstance('stSearchBackend');
        $this->user = sfContext::getInstance()->getUser();
    }

    /**
     * Optimize product in all languages
     * @param integer $step
     * @return integer
     */
    public function optimize($step)
    {
        if ($step == 0) 
        {
            if ($this->config->get('enable_new'))
            {
                $con = Propel::getConnection();

                $con->executeQuery('TRUNCATE '.ProductSearchTagPeer::TABLE_NAME);
                $con->executeQuery('TRUNCATE '.ProductHasProductSearchTagPeer::TABLE_NAME);
            }

            $languages = array();

            foreach (LanguagePeer::doSelectActive(new Criteria()) as $lang)
            {
                $languages[] = $lang->getOriginalLanguage();
            }
            $this->user->setAttribute('offset', 0, 'soteshop/stSearchOptimize');
            $this->user->setAttribute('languages', $languages, 'soteshop/stSearchOptimize');
            $this->user->setAttribute('current_lang', 0, 'soteshop/stSearchOptimize');
            $this->user->setAttribute('count', ProductPeer::doCount(new Criteria()), 'soteshop/stSearchOptimize');
        }

        $culture = $this->getCurrentCulture();
        $offset = $this->getCurrentOffset();

        // get data from database
        $c = new Criteria();
        $c->setLimit($this->config->get('enable_new') ? 40 : $this->limit);
        $c->setOffset($offset);
        $items = ProductPeer::doSelect($c);

        // build indexes for product for all languages
        foreach ($items as $item) 
        {
            if (!$this->config->get('enable_new')) 
            {
                stSimpleSearch::getInstance()->buildIndex($item, $culture);
                stAdvancedSearch::getInstance()->buildIndex($item, $culture);
            } 
            else 
            {
                $item->setCulture($culture);
                stNewSearch::buildIndex($item);
            }
            
            usleep(200000);
        }
        
        // increase steps
        $count = count($items);
        $this->setCurrentOffset($offset + $count);

        return $step + $count;
    }

    public function close()
    {
        $con = Propel::getConnection();
        $con->executeQuery('OPTIMIZE TABLE '.ProductSearchTagPeer::TABLE_NAME);
        $con->executeQuery('OPTIMIZE TABLE '.ProductHasProductSearchTagPeer::TABLE_NAME); 
    }
    
    
    /**
     * Main loop in progressbar
     * @param integer $step
     * @return integer
     */
    public function updateOptimize($step) {
        sfLoader::loadPluginConfig();
        return $this->optimize($step);
    }
    
    /**
     * Initialize post update progressbar
     * @param sfEvent $event
     * @return unknown_type
     */
    public static function postInstall(sfEvent $event) {
        $dbm = new sfDatabaseManager();
        $dbm->initialize();        
        sfLoader::loadPluginConfig();
        sfLoader::loadHelpers('stProgressBar');
        sfLoader::loadHelpers('Partial');
        // removing unused columns
        try {
            $con = Propel::getConnection();
            $con->executeQuery('TRUNCATE '.ProductSearchTagPeer::TABLE_NAME);
            $con->executeQuery('TRUNCATE '.ProductHasProductSearchTagPeer::TABLE_NAME);  
            $con->executeQuery('ALTER TABLE `st_product_has_product_search_tag` DROP `created_at`, DROP `updated_at`'); 
            $con->executeQuery('ALTER TABLE `st_product_search_tag` DROP `created_at`, DROP `updated_at`');
        } catch (Exception $e) {
            
        }

        $event->getSubject()->msg .= progress_bar('stSearch_optimize', 'stSearchOptimize', 'updateOptimize', stSearchOptimize::count());
    }
    
    /**
     * Return title for progressbar
     * @return string
     */
    public function getTitle() 
    {
        return sfContext::getInstance()->getI18n()->__('Aktualizacja wyników wyszukiwania', array(), 'stSearchBackend');
    }

    protected function getCurrentCulture()
    {
        $languages = $this->user->getAttribute('languages', array(), 'soteshop/stSearchOptimize');
        $current_lang = $this->user->getAttribute('current_lang', 0, 'soteshop/stSearchOptimize');
        return $languages[$current_lang];       
    }

    protected function getCurrentOffset()
    {
        return $this->user->getAttribute('offset', 0, 'soteshop/stSearchOptimize');
    }

    protected function setCurrentOffset($offset)
    {
        $count = $this->user->getAttribute('count', 0, 'soteshop/stSearchOptimize');

        if ($offset >= $count)
        {
            $offset = 0;
            $current_lang = $this->user->getAttribute('current_lang', 0, 'soteshop/stSearchOptimize');
            $this->user->setAttribute('current_lang', $current_lang + 1, 'soteshop/stSearchOptimize');
        }        

        $this->user->setAttribute('offset', $offset, 'soteshop/stSearchOptimize');
    }

    public static function count()
    {
        $c = new Criteria();
        $c->add(LanguagePeer::ACTIVE, true);
        return ProductPeer::doCount(new Criteria()) * LanguagePeer::doCount($c);
    }
}
