<?php

class stTax
{
    protected static $activeCached = null;

    public static function getById($id)
    {
        $taxes = self::get();

        return isset($taxes[$id]) ? $taxes[$id] : null;
    }

    public static function getByValue($value)
    {
        $results = self::fetchCached();

        $rates = $results['rates'];

        return isset($rates[$value]) ? $results['active'][$rates[$value]] : null;        
    }

    public static function get()
    {
        $results = self::fetchCached();

        return $results['active'];
    }

    public static function getDefault()
    {
        $results = self::fetchCached();

        return $results['default'] ? $results['active'][$results['default']] : null;
    }

    public static function hasEx($country_id = null)
    {   
        $country = stDeliveryFrontend::getInstance(sfContext::getInstance()->getUser()->getBasket())->getDefaultDeliveryCountry();

        return null !== self::getEx() && $country && !$country->isEU() && (null === $country_id || !CountriesPeer::retrieveByPK($country_id)->isEU());
    }

    public static function getEx()
    {
        $results = self::fetchCached();

        return $results['ex'] ? $results['active'][$results['ex']] : null;
    }

    public static function fetchCached()
    {
        if (null === self::$activeCached)
        {
            $cache = new stFunctionCache('stTax');
            self::$activeCached = $cache->cacheCall(array('stTax', 'fetch'));
        }

        return self::$activeCached;        
    }

    public static function fetch()
    {      
        $c = new Criteria();
        $c->add(TaxPeer::IS_ACTIVE, true);

        $rs = TaxPeer::doSelectRS($c);

        $results = array();
        $rates = array();
        $default = null;
        $ex = null;

        while($rs->next())
        {
            $tax = new Tax();
            $tax->hydrate($rs);
            $results[$tax->getId()] = $tax;
            $rates[$tax->getVat()] = $tax->getId();

            if ($tax->getIsDefault())
            {
                $default = $tax->getId();
            } 

            if ($tax->getVatName() == 'ex')
            {
                $ex = $tax->getId();
            }
        }

        return array('active' => $results, 'default' => $default, 'rates' => $rates, 'ex' => $ex);  
    }  
}