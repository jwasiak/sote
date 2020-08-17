<?php
/**
 * 
 * @author Sote
 *
 */
class stProductGroupOptimize {
    /**
     * Products per step
     * @var integer
     */
    protected $limit = 25;

    /**
     * public construcotr
     * @return unknown_type
     */
    public function __construct() {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
       }

    /**
     * Optimize product in all languages
     * @param integer $step
     * @return integer
     */
    public function optimize($step)
    {
        // get data from database
        $c = new Criteria();
        $c->setLimit($this->limit);
        $c->setOffset($step);
        $product_group_has_products = ProductGroupHasProductPeer::doSelect($c);

        foreach ($product_group_has_products  as $product_group_has_product)
        {
            $product = ProductPeer::retrieveByPK($product_group_has_product->getProductId());
            $product_group_id = $product_group_has_product->getProductGroupId();
            $opt_pg = $product->getOptProductGroup();
            if ($opt_pg)
            {
                $opt_pg = unserialize($opt_pg);
                if (!in_array($product_group_id, $opt_pg))
                {
                    $opt_pg[] = $product_group_id;
                }
            }
            else
            {
                $opt_pg = array();
                $opt_pg[] = $product_group_id;     
            }

            $opt_pg = serialize($opt_pg);
            $product->setOptProductGroup($opt_pg);
            $product->save();
        }
        
        // increase steps
        $step+=count($product_group_has_products);
        return $step;
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
        sfLoader::loadHelpers(array('Helper', 'stProgressBar', 'Partial'));
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
        $event->getSubject()->msg .= progress_bar('stProductGroup_optimize', 'stProductGroupOptimize', 'updateOptimize', ProductGroupHasProductPeer::doCount(new Criteria()));
    }
    
    /**
     * Return title for progressbar
     * @return string
     */
    public function getTitle() 
    {
        return sfContext::getInstance()->getI18n()->__('Optymalizacja grup produktów', array(), 'stProductGroupBackend');
    }
}