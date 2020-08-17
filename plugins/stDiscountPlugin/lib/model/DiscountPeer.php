<?php
/** 
 * SOTESHOP/stDiscountPlugin 
 * 
 * Ten plik należy do aplikacji stDiscountPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stDiscountPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: DiscountPeer.php 10 2009-08-24 09:32:18Z michal $
 */

class DiscountPeer extends BaseDiscountPeer
{
    protected static $activeDiscounts = null;

    protected static $idsForUser = array();

    protected static $discountsForUser = array();

    protected static $productBatchIds = array();

    protected static $productBatchDiscountIds = null;

    public static function getDiscountTypes()
    {
        return array(
            'P' => __('Na produkty', null, 'stDiscountBackend'), 
            'O' => __('Na zamówienie', null, 'stDiscountBackend'),
            'S' => __('Na zestaw', null, 'stDiscountBackend')
        );
    }

    public static function doSelectIdsByUser(sfGuardUser $user)
    {
        if (!isset(self::$idsForUser[$user->getId()]))
        {
            $c = new Criteria();
            $c->addSelectColumn(UserHasDiscountPeer::DISCOUNT_ID);
            $c->add(UserHasDiscountPeer::SF_GUARD_USER_ID, $user->getId());
            $rs = UserHasDiscountPeer::doSelectRS($c);
            $ids = array();
            while($rs->next())
            {
                list($id) = $rs->getRow();
                $ids[$id] = $id;
            }
            self::$idsForUser[$user->getId()] = $ids;
        }

        return self::$idsForUser[$user->getId()];
    }

    public static function setProductBatchIds(array $ids)
    {
        if (self::$productBatchIds != $ids)
        {
            self::$productBatchIds = $ids;
            self::$productBatchDiscountIds = null;
        }
    }

    public static function fetchAllProductBatchDiscountIds()
    {
        if (null === self::$productBatchDiscountIds && self::$productBatchIds)
        {
            $ids = array();
            
            foreach (self::$productBatchIds as $product_id)
            {
                $ids[$product_id] = array();
            }

            self::updateProductBatchDiscountIds(self::$productBatchIds);
        }

        return self::$productBatchDiscountIds;
    }

    public static function updateProductBatchDiscountIds(array $productIds)
    {
        if ($productIds)
        {
            $c = new Criteria();
            $c->addSelectColumn(ProductHasCategoryPeer::PRODUCT_ID);
            $c->addSelectColumn(DiscountHasCategoryPeer::DISCOUNT_ID);
            $c->addJoin(DiscountHasCategoryPeer::CATEGORY_ID, ProductHasCategoryPeer::CATEGORY_ID);
            $c->add(ProductHasCategoryPeer::PRODUCT_ID, $productIds, Criteria::IN);
            $c->addGroupByColumn(ProductHasCategoryPeer::PRODUCT_ID);
            $c->addGroupByColumn(DiscountHasCategoryPeer::DISCOUNT_ID);
    
            $rs = ProductHasCategoryPeer::doSelectRS($c);
    
            while($rs->next())
            {
                list($product_id, $id) = $rs->getRow();
                self::$productBatchDiscountIds[$product_id][$id] = $id;
            }
    
            $c = new Criteria();
            $c->addSelectColumn(ProductPeer::ID);
            $c->addSelectColumn(DiscountHasProducerPeer::DISCOUNT_ID);
            $c->addJoin(DiscountHasProducerPeer::PRODUCER_ID, ProductPeer::PRODUCER_ID);
            $c->add(ProductPeer::ID, $productIds, Criteria::IN);
    
            $rs = DiscountHasProducerPeer::doSelectRS($c);
    
            while($rs->next())
            {
                list($product_id, $id) = $rs->getRow();
                self::$productBatchDiscountIds[$product_id][$id] = $id;
            }

            $c = new Criteria();
            $c->addSelectColumn(DiscountHasProductPeer::PRODUCT_ID);
            $c->addSelectColumn(DiscountHasProductPeer::DISCOUNT_ID);
            $c->add(DiscountHasProductPeer::PRODUCT_ID, $productIds, Criteria::IN);
            $rs = DiscountHasProductPeer::doSelectRS($c);

            while($rs->next())
            {
                list($product_id, $id) = $rs->getRow();
                self::$productBatchDiscountIds[$product_id][$id] = $id;
            }
        }        
    }

    public static function doSelectIdsByProduct(Product $product)
    {
        self::fetchAllProductBatchDiscountIds();
        $product_id = $product->getId();

        if (!isset(self::$productBatchDiscountIds[$product_id]))
        {
            self::$productBatchDiscountIds[$product_id] = array();

            self::updateProductBatchDiscountIds(array($product_id));
        }
        
        return self::$productBatchDiscountIds[$product_id];        
    }

    public static function doSelectIdsByProductIds($product_ids)
    {
        $c = new Criteria();
        $c->addSelectColumn(DiscountHasProductPeer::DISCOUNT_ID);
        $c->add(DiscountHasProductPeer::PRODUCT_ID, $product_ids, Criteria::IN);
        $c->addGroupByColumn(DiscountHasProductPeer::DISCOUNT_ID);
        $rs = DiscountHasProductPeer::doSelectRS($c);
        $ids = array();
        while($rs->next())
        {
            $ids[] = $rs->getInt(1);
        }
        
        return $ids;        
    }    

    public static function doSelectOneByProductAndUser(Product $product, sfGuardUser $user = null)
    {
        $discounts = self::doSelectActiveCached();

        if (isset($discounts['P']))
        {
            $discount = current($discounts['P']);

            if ($discount->getAllProducts() && (null === $user && $discount->getAllowAnonymousClients() || $user && $discount->getAllClients()))
            {
                return $discount;
            }

            $user_discounts = self::doSelectForUserCached($user);
        
            if ($user_discounts)
            {
                $pids = self::doSelectIdsByProduct($product);
                
                foreach ($user_discounts as $discount)
                {
                    if ($discount->getAllProducts() || isset($pids[$discount->getId()]))
                    {
                        return $discount;
                    }
                }
            }
        }
        
        return null;
    }

    public static function doSelectForUserCached(sfGuardUser $user = null)
    {
        $discounts = self::doSelectActiveCached();

        $id = null !== $user ? $user->getId() : 0;

        if (!isset(self::$discountsForUser[$id]))
        {
            $results = array();

            if (isset($discounts['P']))
            {
                $uids = $user ? self::doSelectIdsByUser($user) : array();

                foreach ($discounts['P'] as $discount)
                {
                    if (!$user && $discount->getAllowAnonymousClients() || $user && $discount->getAllClients() || $uids && isset($uids[$discount->getId()]))
                    {
                        $results[$discount->getId()] = $discount;
                    }
                }
            }

            self::$discountsForUser[$id] = $results;
        }

        return self::$discountsForUser[$id];
    }

    public static function doSelectActiveCached()
    {
        if (null === self::$activeDiscounts)
        {
            $fc = new stFunctionCache('stDiscount');

            $c = new Criteria();
            $c->add(self::TYPE, array('O', 'P'), Criteria::IN);

            self::setHydrateMethod(array('DiscountPeer', 'hydrateActiveCached'));

            self::$activeDiscounts = $fc->cacheCall(array('DiscountPeer','doSelectActive'), array($c));

            self::$activeDiscounts = stEventDispatcher::getInstance()->filter(new sfEvent(null, 'DiscountPeer.doSelectActiveCached'), self::$activeDiscounts)->getReturnValue();

            self::setHydrateMethod(null);
        }

        return self::$activeDiscounts;
    }

    public static function doSelectActive(Criteria $c)
    {
        $c->add(self::ACTIVE, true);
        $c->addDescendingOrderByColumn(self::PRIORITY);

        return self::doSelect($c);
    }

    public static function doSelectProductsInSet(Product $product)
    {
        $c = new Criteria();
        $c->addSelectColumn(DiscountHasProductPeer::DISCOUNT_ID);
        $c->add(DiscountHasProductPeer::PRODUCT_ID, $product->getId());
        $c->addJoin(DiscountPeer::ID, DiscountHasProductPeer::DISCOUNT_ID);
        $rs = DiscountHasProductPeer::doSelectRS($c);        
    }

    public static function doSelectSetDiscounts(Product $product, sfGuardUser $user = null)
    {
        $uid = $user ? self::doSelectIdsByUser($user) : array();

        $discount = null;

        $c = new Criteria();
        $c->add(self::TYPE, 'S');

        $c->add(self::PRODUCT_ID, $product->getId());
       
        if ($user)
        {
            if ($uid)
            {
                $uc = $c->getNewCriterion(self::ID, $uid, Criteria::IN);
                $uc->addOr($c->getNewCriterion(self::ALL_CLIENTS, true));
                $c->add($uc);
            }
            else
            {
                $c->add(self::ALL_CLIENTS, true);
            }
        }
        else
        {
            $c->add(self::ALLOW_ANONYMOUS_CLIENTS, true);
        }

        $discounts = self::doSelectActive($c);

        foreach ($discounts as $discount)
        {
            $discount->setProduct($product);
        }

        return $discounts;
    }

    public static function hydrateActiveCached($rs)
    {
        $results = array();

        while($rs->next()) 
        {
            $obj = new Discount();
            $obj->hydrate($rs);

            $results[$obj->getType()][$obj->getId()] = $obj;
        }

        return $results;
    }

    public static function clearCache()
    {
        $cache = new stFunctionCache('stDiscount');
        $cache->removeAll();
        stFastCacheManager::clearCache();
    }
}
