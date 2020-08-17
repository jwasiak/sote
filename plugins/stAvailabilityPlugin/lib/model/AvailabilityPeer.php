<?php
/**
 * SOTESHOP/stAvailabilityPlugin
 *
 * Ten plik należy do aplikacji stAvailabilityPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stAvailabilityPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: AvailabilityPeer.php 617 2009-04-09 13:02:31Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/**
 * Klasa AvailabilityPeer
 *
 * @package     stAvailabilityPlugin
 * @subpackage  libs
 */
class AvailabilityPeer extends BaseAvailabilityPeer
{
    protected static $hiddenRange = null;

    protected static $retrieveByProduct = null;

    protected static $addProductCriteria = null;

    public static function doSelectWithI18n(Criteria $c, $culture = null, $con = null)
    {
        if ($culture === null)
        {
            $culture = stLanguage::getHydrateCulture();
        }

        return parent::doSelectWithI18n($c, $culture, $con);
    }

    public static function doCountWithI18n(Criteria $c, $con = null)
    {
        $c->addJoin(AvailabilityI18nPeer::ID, AvailabilityPeer::ID);

        $c->add(AvailabilityI18nPeer::CULTURE, stLanguage::getHydrateCulture());

        return self::doCount($c, $con);
    }

    public static function getProductAvailability($product)
    {
        $avail = $product->getAvailability();
        if (is_object($avail)) return $avail->getOptAvailabilityName();
        return '';
    }

    public static function setProductAvailability($product, $value)
    {
        $value = trim($value);
        if (!empty($value))
        {
            $c = new Criteria();
            $c->add(AvailabilityPeer::OPT_AVAILABILITY_NAME, $value);
            $avail = AvailabilityPeer::doSelectOne($c);

            if (is_object($avail)) $product->setAvailabilityId($avail->getId());
        }else{
            $product->setAvailabilityId(null);
        }
    }

    public static function doSelectOrderByStock()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(AvailabilityPeer::STOCK_FROM);

        $availabilities = AvailabilityPeer::doSelectWithI18n($c);

        $results = array();

        foreach ($availabilities as $availability)
        {
            $results[$availability->getId()] = $availability;
        }

        return $results;
    }

    public static function doSelectOrderByStockCached($culture = null)
    {
        if (null === $culture)
        {
            $culture = sfContext::getInstance()->getUser()->getCulture();
        }

        $fc = new stFunctionCache('stAvailability');
        return $fc->cacheCall(array('AvailabilityPeer', 'doSelectOrderByStock'), array('culture' => $culture));
    }

    public static function cleanCache()
    {
        $fc = new stFunctionCache('stAvailability');

        $fc->removeAll();
    }

    public static function retrieveByProduct(Product $product)
    {
        $result = null;

        if (null === self::$retrieveByProduct)
        {
            self::$retrieveByProduct = array_reverse(AvailabilityPeer::doSelectOrderByStockCached());
        }

        foreach (self::$retrieveByProduct as $availability)
        {
            if ($availability->getStockFrom() <= $product->getStock())
            {
                $result = $availability;
                break;
            }
        }

        return $result;
    }

    public static function isProductActive(Product $product)
    {
        $config = stConfig::getInstance('stAvailabilityBackend');

        if ($config->get('hide_products_avail_on') && $config->get('hide_products_avail'))
        {
            if (null !== $product->getAvailabilityId())
            {
                return $product->getAvailabilityId() != $config->get('hide_products_avail');
            }
            else
            {
                $range = self::retrieveHiddenRange();

                return !$range || !($product->getStock() >= $range[0] && (null === $range[1] || $product->getStock() < $range[1]));
            }
        }

        return true;
    }

    public static function retrieveHiddenRange()
    {
        if (null === self::$hiddenRange)
        {
            $config = stConfig::getInstance('stAvailabilityBackend');

            if ($config->get('hide_products_avail_on'))
            {
                $hidden = $config->get('hide_products_avail');

                $availabilities = AvailabilityPeer::doSelectOrderByStockCached();

                $to = null;
                $from = null;

                foreach ($availabilities as $availability)
                {
                    if (null !== $from)
                    {
                        $to = $availability->getStockFrom();
                        break;
                    }

                    if ($availability->getId() == $hidden)
                    {
                        $from = $availability->getStockFrom();
                    }
                }

                self::$hiddenRange = null !== $from ? array($from, $to) : array();
            }
            else
            {
                self::$hiddenRange = array();
            }
        }

        return self::$hiddenRange;
    }

    /**
     * Dodaje kryteria filtrowania po dostępności produktu
     *
     * @param Criteria $productCriteria
     * @return void
     */
    public static function addProductCriteria(Criteria $criteria)
    {
        if (null === self::$addProductCriteria)
        {
            $availabilities = AvailabilityPeer::doSelectOrderByStockCached(); 

            if ($availabilities)
            {
                $config = stConfig::getInstance('stAvailabilityBackend');
                $stock_from = false;
                $stock_from_next = false;
                $availability_id = $config->get('hide_products_avail') ? $config->get('hide_products_avail') : $availabilities[0];

                foreach ($availabilities as $availability)
                {
                    if (false !== $stock_from)
                    {
                        $stock_from_next=$availability->getStockFrom();
                        break;
                    }

                    if ($availability->getId() == $availability_id)
                    {
                        $stock_from=$availability->getStockFrom();
                    }
                }

                $criterion = $criteria->getNewCriterion(ProductPeer::AVAILABILITY_ID, null, Criteria::ISNOTNULL);
                $criterion->addAnd($criteria->getNewCriterion(ProductPeer::AVAILABILITY_ID, $availability_id, Criteria::NOT_EQUAL));
        
                if ($stock_from == 0)
                {
                    $criterion1 = $criteria->getNewCriterion(ProductPeer::STOCK, $stock_from_next, Criteria::GREATER_EQUAL);
                    $criterion1->addAnd($criteria->getNewCriterion(ProductPeer::AVAILABILITY_ID, null, Criteria::ISNULL));
                    $criterion->addOr($criterion1);
                }
                elseif ($stock_from_next !== false)
                {
                    $criterion1 = $criteria->getNewCriterion(ProductPeer::STOCK, $stock_from, Criteria::LESS_THAN);
                    $criterion1->addAnd($criteria->getNewCriterion(ProductPeer::STOCK, $stock_from_next, Criteria::GREATER_EQUAL));
                    $criterion1->addAnd($criteria->getNewCriterion(ProductPeer::AVAILABILITY_ID, null, Criteria::ISNULL));
                    $criterion->addOr($criterion1);
                } 
                else 
                {
                    $criterion1 = $criteria->getNewCriterion(ProductPeer::STOCK, $stock_from, Criteria::LESS_THAN);
                    $criterion1->addAnd($criteria->getNewCriterion(ProductPeer::AVAILABILITY_ID, null, Criteria::ISNULL));
                    $criterion->addOr($criterion1);
                }

                self::$addProductCriteria = $criterion;
            }   
        }

        if (null !== self::$addProductCriteria)
        {
            $criteria->add(self::$addProductCriteria);
        }
    }
}
