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
 * @version     $Id: Discount.php 2008 2009-11-05 11:13:04Z piotr $
 */

if (SF_APP == 'backend')
{
    require_once sfConfig::get('sf_root_dir').'/apps/frontend/lib/stBasket.class.php';
}

class Discount extends BaseDiscount
{
    protected $products = null;

    protected static $availability = null;

    public function __toString() {
        return $this->getName();
    }
    
    public function save($con = null)
    {    
        if ($this->type != 'O')
        {
            $this->setConditions(null);
        }
        elseif ($this->type == 'O')
        {
            $this->setAllProducts(true);
        }

        $clearCache = $this->isModified();

        $ret = parent::save($con);

        if ($clearCache) 
        {
            DiscountPeer::clearCache();
            stPartialCache::clear('stProduct', '_productGroup', array('app' => 'frontend'));
            stPartialCache::clear('stProduct', '_new', array('app' => 'frontend'));
            stFastCacheManager::clearCache();
        }

        return $ret;
    }

    public function getTypeLabel()
    {
        $types = DiscountPeer::getDiscountTypes();

        return $this->type ? $types[$this->type] : null;
    }

    public function delete($con = null)
    {
        $ret = parent::delete($con);
        DiscountPeer::clearCache();
        return $ret;      
    }

    public function getCondition($name, $default = null)
    {
        $conditions = $this->getConditions();

        $value = isset($conditions[$name]) ? $conditions[$name] : $default; 

        return is_numeric($value) ? floatval($value) : $value;
    }

  

    public function apply($amount)
    {
        if ($this->getPriceType() == '%')
        {
            $amount = stPrice::applyDiscount($amount, $this->getValue());
        }
        else
        {
            $amount -= stCurrency::exchange($this->getValue());
        }

        return $amount > 0 ? $amount : 0;
    }

    public function getProducts($with_default = true, $check = true)
    {
        if (null === $this->products)
        {        
            $c = new Criteria();
            $c->addSelectColumn(DiscountHasProductPeer::PRODUCT_ID);
            $c->add(DiscountHasProductPeer::DISCOUNT_ID, $this->getId());
            $rs = DiscountHasProductPeer::doSelectRS($c);

            $ids = array();

            while($rs->next())
            {
                list($id) = $rs->getRow();
                $ids[] = $id;
            }

            $c = new Criteria();
            $c->add(ProductPeer::ID, $ids, Criteria::IN);
            ProductPeer::addFilterCriteria(null, $c);        
            
            $this->products = ProductPeer::doSelectWithI18n($c);

            if ($check)
            {
                if (count($ids) != count($this->products))
                {
                    $this->products = array();
                } 

                $avail = $this->getAvailability();

                foreach ($this->products as $p)
                {
                    if (!stBasket::isEnabled($p) || $avail && ($p->getAvailabilityId() == $avail->getId() || $p->getFrontendAvailability()->getId() == $avail->getId()))
                    {
                        $this->products = array();
                        break;
                    }
                }  
            }         
        }

        if ($with_default && $this->products)
        {
            return array_merge(array($this->getProduct()), $this->products);
        }

        return $this->products;
    }

    public function getTotalProductAmount($with_discount = true)
    {
        $total = 0;

        $discount = array(array('value' => $this->getValue(), 'type' => $this->getPriceType()));

        $sf_user = sfContext::getInstance()->getUser();

        $user = $sf_user->isAuthenticated() ? $sf_user->getGuardUser() : null;

        $with_discount = $with_discount && !stDiscount::isDisabledForWholesale($user);

        if ($this->getPriceType() == '%')
        {       
            foreach ($this->getProducts() as $product)
            {
                $price = $product->getPriceBrutto(true);

                $total += $price;
            }

            if ($with_discount)
            {
                $total = stPrice::applyDiscount($total, $this->getValue());
            }
        }
        else
        {
            foreach ($this->getProducts() as $product)
            {
                $price = $product->getPriceBrutto(true);

                $total += $price;
            }    

            if ($with_discount)
            {
                $total -= stCurrency::exchange($this->getValue());  
            }      
        }

        return $total;
    }

    protected static function getAvailability()
    {
        if (null === self::$availability)
        {
            $config = stConfig::getInstance('stAvailabilityBackend');

            $id = $config->get('hide_products_avail');

            
            if ($id && $config->get('hide_products_avail_on'))
            {
                self::$availability = AvailabilityPeer::retrieveByPK($id);
            }
            else
            {
                self::$availability = false;
            }
        }

        return self::$availability;
    }
}

sfPropelBehavior::add('Discount', array('act_as_sortable' => array('column' => 'priority')));