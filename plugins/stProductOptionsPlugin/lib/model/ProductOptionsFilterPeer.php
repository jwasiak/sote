<?php

/**
 * Subclass for performing query and update operations on the 'st_product_options_filter' table.
 *
 * 
 *
 * @package plugins.stProductOptionsPlugin.lib.model
 */ 
class ProductOptionsFilterPeer extends BaseProductOptionsFilterPeer
{ 
    const PRICE_FILTER = 3;

    const COLOR_FILTER = 2;
  
    const NORMAL_FILTER = 1;

    protected static $optionFiltersPool = null;

    protected static $byNamePool = array();

    public static function getOptionFiltersCached() 
    {
        if (null === self::$optionFiltersPool)
        {        
            $fc = stFunctionCache::getInstance('stProductOptionsPlugin');
            self::$optionFiltersPool = $fc->cacheCall(array('ProductOptionsFilterPeer', 'getOptionFilters'));
        }

        return self::$optionFiltersPool;
    }

    public static function getOptionFiltersForSelect()
    {
        $results = self::getOptionFiltersCached();

        return $results && $results['id'] ? $results['id'] : array();
    } 

    public static function getOptionFilters() 
    {
        $c = new Criteria();
        $c->add(ProductOptionsFilterPeer::FILTER_TYPE, self::PRICE_FILTER, Criteria::NOT_EQUAL);
        $c->addAscendingOrderByColumn(ProductOptionsFilterPeer::OPT_NAME);
        $results = array('id' => array(), 'name' => array());

        foreach (ProductOptionsFilterPeer::doSelect($c) as $filter)
        {
            $results['id'][$filter->getId()] = $filter;
            $results['name'][$filter->getOptName()] = $filter->getId();
        }    

        return $results;
    }

    public static function retrieveById($id)
    {
        $results = self::getOptionFiltersCached();

        return isset($results['id'][$id]) ? $results['id'][$id] : null;        
    }

    public static function retrieveByName($name)
    {
        $results = self::getOptionFiltersCached();

        return isset($results['name'][$name]) && isset($results['id'][$results['name'][$name]]) ? $results['id'][$results['name'][$name]] : null;
    }
}