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
 * @version     $Id: stDiscount.class.php 10157 2011-01-12 09:30:11Z piotr $
 */

class stDiscount {

    /**
     * Czy uzytkownika posiada rabat
     *
     * @var boolean
     */
    protected static $userHasDiscount = false;

    protected static $validDiscountCouponCodeProductIds = array();

    /**
     *
     * @var object
     */
    protected static $user = null;

    protected static $discounts = array();

    protected static $disabledForPromotion = null;

    public static function isDisabledForPromotionProducts()
    {
        if (null === self::$disabledForPromotion)
        {
            $discount_config = stConfig::getInstance('stDiscountBackend');

            if ($discount_config->get('disable_for_promotion_products'))
            {
                self::$disabledForPromotion = false;

                foreach (sfContext::getInstance()->getUser()->getBasket()->getItems() as $item)
                {
                    if ($item->hasDiscount() || $item->getProductSetDiscount())
                    {
                        self::$disabledForPromotion = true;

                        break;
                    }
                }
            } 
        }  

        return self::$disabledForPromotion;      
    }

    public static function isDisabledForWholesale(sfGuardUser $user = null)
    {
        return $user && stConfig::getInstance('stDiscountBackend')->get('disable_for_wholesale') && $user->getWholesale(); 
    }

    public static function getBasketMessage()
    {
        if (!stLicense::hasSupport() && !stLicense::isOpen())
        {
            return null;
        }

        $sf_context = sfContext::getInstance();

        $i18n = $sf_context->getI18N();

        $sf_user = $sf_context->getUser();

        $basket = $sf_user->getBasket();

        $user = $sf_user->isAuthenticated() && $sf_user->getGuardUser() ? $sf_user->getGuardUser() : null;

        if (self::isDisabledForWholesale($user))
        {
            return null;
        } 

        if (self::isDisabledForPromotionProducts())
        {
            return null;
        }

        $discount = null;        

        if (!$basket->isEmpty())
        {
            $item_info = array();

            $basket->setDiscount(null);

            $discounts = DiscountPeer::doSelectActiveCached();

            if (isset($discounts['O']))
            {
                $tmp = $basket->getDiscount();

                $basket->setDiscount(false);

                $total_amount = $basket->getTotalAmount(true, true);

                $basket->setDiscount($tmp);

                $uid = $user ? DiscountPeer::doSelectIdsByUser($user) : array();

                $selected_discount = array();

                foreach ($discounts['O'] as $current)
                {
                    if (!$user && $current->getAllowAnonymousClients() || $user && $current->getAllClients() || $uid && isset($uid[$current->getId()]))
                    {
                        $from_amount = stCurrency::exchange($current->getCondition('from_amount'));

                        if ($total_amount < $from_amount && (null === $discount || stCurrency::exchange($discount->getCondition('from_amount')) > $from_amount)) 
                        {
                            $discount = $current;
                        }
                    }
                }
            }
        }

        if (null !== $discount)
        {
            sfLoader::loadHelpers(array('Helper', 'stCurrency'));

            $amount = stCurrency::exchange($discount->getCondition('from_amount')) - $total_amount; 

            if ($discount->getPriceType() == '%') 
            { 
                $discount_amount = st_format_price($discount->getValue(), 1).'%';

            }
            else
            {
                $discount_amount = st_currency_format($discount->getValue(), array('with_exchange' => true));
            }

            return $i18n->__('Dokonaj zakupu za %amount% a otrzymasz rabat %discount% na aktualne zamówienie', array(
                '%amount%' => st_currency_format($amount, array('with_exchange' => false)),
                '%discount%' => $discount_amount
            ), 'stDiscountFrontend');
        } 

        return null;     
    }

    public static function updateBasketDiscount($basket)
    {
        $sf_user = $basket->getUser();

        $basket->setDiscount(false);

        if (!stLicense::hasSupport() && !stLicense::isOpen())
        {
            return false;
        }

        $user = $sf_user->isAuthenticated() && $sf_user->getGuardUser() ? $sf_user->getGuardUser() : null;

        if (stDiscount::isDisabledForWholesale($user) || stDiscount::isDisabledForPromotionProducts())
        {
            return false;
        } 

        if (!$basket->isEmpty())
        {
            $discount = null;

            $discounts = DiscountPeer::doSelectActiveCached();

            if (isset($discounts['O']))
            {
                $total_amount = $basket->getTotalAmount(true, true);

                $uid = $user ? DiscountPeer::doSelectIdsByUser($user) : array();

                $selected_discount = array();

                foreach ($discounts['O'] as $current)
                {
                    if (!$user && $current->getAllowAnonymousClients() || $user && $current->getAllClients() || $uid && isset($uid[$current->getId()]))
                    {
                        $from_amount = stCurrency::exchange($current->getCondition('from_amount'));

                        if ($total_amount >= $from_amount && (null === $discount || stCurrency::exchange($discount->getCondition('from_amount')) < $from_amount)) 
                        {
                            $discount = $current;
                        }
                    }
                }
            }

            if ($discount)
            {            
                $basket->setDiscount($discount);
            }
        }

        return true;
    }

    public static function getDiscountForProduct(Product $product)
    {
        return isset(self::$discounts[$product->getId()]) ? self::$discounts[$product->getId()] : null;
    }

    public static function setDiscountForProduct(Product $product) 
    {
        if (!$product->getMaxDiscount() || $product->getIsGift())
        {
            return false;
        }   
        
        if (null === self::$user)
        {
            $sf_user = sfContext::getInstance()->getUser();

            self::$user = $sf_user->isAuthenticated() && $sf_user->getGuardUser() ? $sf_user->getGuardUser() : null;
        }

        if (self::isDisabledForWholesale(self::$user))
        {
            return false;
        }        

        $id = $product->getId();

        if (!isset(self::$discounts[$id]) && !array_key_exists($id, self::$discounts))
        {
            $discount = null;

            if (self::$user)
            {   
                $discount = DiscountUserPeer::doSelectOneByUser(self::$user);
            }

            $productDiscount = DiscountPeer::doSelectOneByProductAndUser($product, self::$user);

            if ($discount && $productDiscount)
            {
                $price = $product->getPriceBrutto(true, false);

                if ($discount->apply($price) > $productDiscount->apply($price))
                {
                    $discount = $productDiscount;
                }  
            } 
            elseif ($productDiscount)
            {
                $discount = $productDiscount;
            }

            self::$discounts[$id] = $discount;
        }

        if (null !== self::$discounts[$id])
        {
            $product->setDiscount(array('value' => self::$discounts[$id]->getValue(), 'type' => self::$discounts[$id]->getPriceType()));
        }

    }

    public static function calculateCouponCodeDiscount(DiscountInterface $product, DiscountCouponCode $coupon_code)
    { 
        $coupon_code_method = stConfig::getInstance('stDiscountBackend')->get('coupon_code_calculate_method', 'overwrite');

        if ($coupon_code_method == 'overwrite') 
        {
            $coupon_code_discount = $coupon_code->getDiscount();
        }
        elseif ($coupon_code_method == 'add_up')
        {
            $coupon_code_discount = $product->getDiscountInPercent() + $coupon_code->getDiscount();
        }
        elseif ($coupon_code_method == 'highest')
        {
            $coupon_code_discount = max(array($product->getDiscountInPercent(), $coupon_code->getDiscount()));
        }

        return $coupon_code_discount;      
    }

    public static function updateDiscountCouponCodeProductIds(DiscountCouponCode $couponCode, array $productIds)
    {
        if ($couponCode->getAllowAllProducts())
        {
            return $productIds;
        }

        $productIds = array_diff($productIds, self::$validDiscountCouponCodeProductIds);

        if ($productIds)
        {
            $c = new Criteria();
            $c->addSelectColumn(DiscountCouponCodeHasProductPeer::PRODUCT_ID);
            $c->add(DiscountCouponCodeHasProductPeer::PRODUCT_ID, $productIds, Criteria::IN);
            $c->add(DiscountCouponCodeHasProductPeer::DISCOUNT_COUPON_CODE_ID, $couponCode->getId());
            $rs = DiscountCouponCodeHasProductPeer::doSelectRS($c); 
            
            while($rs->next())
            {
                $row = $rs->getRow();
                self::$validDiscountCouponCodeProductIds[$row[0]] = $row[0];
            }

            $productIds = array_diff($productIds, self::$validDiscountCouponCodeProductIds);
        }
        
        if ($productIds)
        {
            $c = new Criteria();
            $c->addSelectColumn(ProductHasCategoryPeer::PRODUCT_ID);
            $c->addJoin(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, ProductHasCategoryPeer::CATEGORY_ID);
            $c->add(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, $couponCode->getId());
            $c->add(ProductHasCategoryPeer::PRODUCT_ID, $productIds, Criteria::IN);
            $rs = DiscountCouponCodeHasCategoryPeer::doSelectRS($c);       

            while($rs->next())
            {
                $row = $rs->getRow();
                self::$validDiscountCouponCodeProductIds[$row[0]] = $row[0];
            }

            $productIds = array_diff($productIds, self::$validDiscountCouponCodeProductIds);
        }
        
        if ($productIds)
        {
            $c = new Criteria();
            $c->addSelectColumn(ProductPeer::ID);
            $c->addJoin(DiscountCouponCodeHasProducerPeer::PRODUCER_ID, ProductPeer::PRODUCER_ID);
            $c->add(DiscountCouponCodeHasProducerPeer::DISCOUNT_COUPON_CODE_ID, $couponCode->getId());
            $c->add(ProductPeer::ID, $productIds, Criteria::IN);
            $rs = DiscountCouponCodeHasProducerPeer::doSelectRS($c);

            while($rs->next())
            {
                $row = $rs->getRow();
                self::$validDiscountCouponCodeProductIds[$row[0]] = $row[0];
            }
        }

        return self::$validDiscountCouponCodeProductIds;
    }

    public static function isValidDiscountCouponCodeProductIds(DiscountCouponCode $couponCode, Product $product)
    {
        if ($couponCode->getAllowAllProducts())
        {
            return true;
        }
        
        $ids = array();

        if (!self::$validDiscountCouponCodeProductIds)
        {
            foreach (sfContext::getInstance()->getUser()->getBasket()->getItems() as $item)
            {
                $ids[] = $item->getProductId();
            }
        }

        if (!in_array($product->getId(), $ids))
        {
            $ids[] = $product->getId();
        }

        $valid = self::updateDiscountCouponCodeProductIds($couponCode, $ids);

        return $valid && isset($valid[$product->getId()]);
    }

    /**
     * Dodaje użytkownika do grupy rabatowej
     *
     * @param $user_id
     * @param $discount_id
     * @param $auto
     * @return unknown_type
     */
    public static function AddUserDiscount($user_id, $discount_id, $auto = true) {

        $c = new Criteria();
        $c->add(UserHasDiscountPeer::SF_GUARD_USER_ID,$user_id);
        $c->add(UserHasDiscountPeer::AUTO,true);

        UserHasDiscountPeer::doDelete($c);

        $c = new Criteria();
        $c->add(UserHasDiscountPeer::DISCOUNT_ID,$discount_id);
        $c->add(UserHasDiscountPeer::SF_GUARD_USER_ID,$user_id);

        $userHasDiscount = UserHasDiscountPeer::doSelectOne($c);

        if (!$userHasDiscount) {

            $userHasDiscount = new UserHasDiscount();
            $userHasDiscount->setDiscountId($discount_id);
            $userHasDiscount->setSfGuardUserId($user_id);
            $userHasDiscount->setAuto($auto);
            $userHasDiscount->save();
        }

    }

    public static function setMaxDiscount(Product $object, $value) {
        if (!is_numeric($value)) return false;
        if ($value > 100) $value = 100.0;
        if ($value < 0) $value = 0.0;
        $object->setMaxDiscount($value);
    }
    
    public static function getOrderSumForUser(Order $order)
    {
        $user_id = $order->getSfGuardUserId();

        $total = 0;
        
        if (!empty($user_id))
        {
            $ids = OrderStatusPeer::doSelectIdsByType('ST_COMPLETE');

            if ($ids)
            {                
                $c = new Criteria();
                $c->addSelectColumn("SUM(".OrderPeer::OPT_TOTAL_AMOUNT.")");
                $c->add(OrderPeer::SF_GUARD_USER_ID, $user_id);
                $c->add(OrderPeer::ORDER_STATUS_ID, $ids, Criteria::IN);
                $rs = OrderPeer::doSelectRS($c);

                if ($rs && $rs->next()) 
                {
                    $row = $rs->getRow();
                    $total = doubleval($row[0]);
                } 
            }
        } 

        return $total;
    }

    public static function value($price, $discounts = array())
    {
        $value = 0;

        if (isset($discounts[0]) && $discounts[0])
        {
            foreach ($discounts as $current)
            {
                $value += $current['type'] == '%' ? stPrice::discountValue($price, $current['value']) : stCurrency::exchange($current['value']);

                $price = self::_apply($price, $current);
            }
        }
        elseif (isset($discounts['percent']))
        {
            return stPrice::discountValue($price, $discounts['percent']);  
        }

        return $value;        
    }

    public static function apply($price, $discounts = array(), $max_discount = null, $with_currency = true)
    {
        if ($max_discount !== null && $max_discount != 100 && self::percent($price, $discounts) > $max_discount)
        {
            $price = stPrice::applyDiscount($price, $max_discount);
        }
        else
        {
            if (isset($discounts[0]) && $discounts[0])
            {
                foreach ($discounts as $current)
                {
                    $price = self::_apply($price, $current, $with_currency);
                }

                $price = stPrice::round($price);
            }
            elseif (isset($discounts['percent']))
            {
                $price = stPrice::applyDiscount($price, $discounts['percent']);
            }
        }

        return $price > 0 ? $price : 0;
    }

    public static function percent($price, $discounts = array())
    {
        $percent = 0;

        if (isset($discounts[0]) && $discounts[0])
        {
            foreach ($discounts as $current)
            {
                $percent += $current['type'] == '%' ? $current['value'] : stPrice::percentFromValue($price, $current['value']);
            }
        }        
        elseif (isset($discounts['percent']))
        {
            return $discounts['percent'];
        }

        return $percent;
    }

    protected static function _apply($price, $discount, $with_currency = true)
    {
        if ($discount['type'] == '%')
        {
            return $price - $price * ($discount['value'] / 100);
        }
        elseif ($with_currency)
        {
            return $price - stCurrency::exchange($discount['value']);
        }
        else
        {
            return $price - $discount['value'];
        }        
    }
}
?>