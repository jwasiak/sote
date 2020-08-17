<?php

/**
 * SOTESHOP/stProductGroup
 *
 * Ten plik należy do aplikacji stProductGroup opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stProductGroup
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: ProductGroupPeer.php 10534 2011-01-26 17:22:38Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>,
 */

class ProductGroupPeer extends BaseProductGroupPeer
{
    protected static $isGift = array();

    protected static $gifts = null;

    protected static $urlPool = array();

    public static function retrieveByUrl($url)
    {
        if (!isset(self::$urlPool[$url]) && !array_key_exists($url, self::$urlPool))
        {
            $c = new Criteria();
            $c->addSelectColumn(ProductGroupI18nPeer::ID);
            $c->add(ProductGroupI18nPeer::URL, $url);
            $c->setLimit(1);
            $rs = ProductGroupI18nPeer::doSelectRS($c);

            if ($rs->next())
            {  
                $row = $rs->getRow();
                $c = new Criteria();
                $c->add(self::ID, $row[0]);
                $c->setLimit(1);
                $tmp = self::doSelectWithI18n($c);     
                self::$urlPool[$url] = $tmp ? $tmp[0] : null;   
            }
        }

        return self::$urlPool[$url];
    }  

    public static function isGift(Product $product, $total = null, $force = false)
    {
        if (!isset(self::$isGift[$product->getId()]) || $force)
        {
            $gifts = self::doSelectGifts();

            if (null !== $total)
            {
                $total = $total - $product->getPriceBrutto();

                $ids = null;

                foreach ($gifts as $id => $group)
                {
                    if ($group->getFromBasketValue() <= $total)
                    {
                        $ids[] = $id;
                    }
                }
            }
            else
            {
                $ids = array_keys($gifts);
            }

            if ($ids) 
            {
                $c = new Criteria();
                $c->add(ProductGroupHasProductPeer::PRODUCT_ID, $product->getId());
                $c->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $ids, Criteria::IN);
                self::$isGift[$product->getId()] = ProductGroupHasProductPeer::doCount($c) > 0;
            }
            else
            {
                self::$isGift[$product->getId()] = false;
            }
        }

        return self::$isGift[$product->getId()];
    }

    /**
     * Pobiera grupy gratisowe
     *
     * @return ProductGroup[]
     */
    public static function doSelectGifts()
    {
        if (null === self::$gifts)
        {
            $c = new Criteria();
            $c->addJoin(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, ProductGroupPeer::ID);
            $c->addDescendingOrderByColumn(ProductGroupPeer::FROM_BASKET_VALUE);
            $c->add(ProductGroupPeer::FROM_BASKET_VALUE, null, Criteria::ISNOTNULL);
            $c->addGroupByColumn(ProductGroupPeer::ID);
            if (stEventDispatcher::getInstance()->getListeners('ProductGroupPeer.doSelectGifts')) {
                stEventDispatcher::getInstance()->notify(new sfEvent($c, 'ProductGroupPeer.doSelectGifts'));
            }
            $groups = ProductGroupPeer::doSelect($c);

            $results = array();

            foreach ($groups as $group)
            {
                $results[$group->getId()] = $group;
            }

            self::$gifts = $results;
        }

        return self::$gifts;        
    }

    public static function doSelectCached(Criteria $c, $con = null)
    {
        $fc = new stFunctionCache('stProductGroup');

        return $fc->cacheCall(array('ProductGroupPeer','doSelect'), array($c, $con, sfContext::getInstance()->getUser()->getCulture()));
    }

    public static function doSelectOneCached(Criteria $c, $con = null)
    {
        $object = self::doSelectCached($c, $con);

        return isset($object[0]) ? $object[0] : null;
    }

    public static function cleanCache()
    {
        $fc = new stFunctionCache('stProductGroup');

        $fc->removeAll();

        stPartialCache::clear('stProduct', '_productGroup', array('app' => 'frontend'));
        stPartialCache::clear('stProduct', '_new', array('app' => 'frontend'));        

        stFastCacheManager::clearCache();
    }

   public function doSelectOneByType($type)
   {
      $c = new Criteria();

      $c->add(self::PRODUCT_GROUP, $type);

      return self::doSelectOne($c);
   }

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
        $c = clone $c;

        $c->addJoin(ProductGroupI18nPeer::ID, ProductGroupPeer::ID);

        $c->add(ProductGroupI18nPeer::CULTURE, stLanguage::getHydrateCulture());

        return self::doCount($c, $con);
    }

    public static function doSelectLabelsArray()
    {
        $groups = self::doSelect(New Criteria());

        $results = array();

        foreach($groups as $group)
        {
            $label = $group->getLabel();

            $image = null;

            if (!$label)
            {
                continue;
            }

            if ($label == 'my_image') 
            {
                $image = $group->getImage();
            }
            elseif ($label != 'none')
            {
                $image = $label;
            }

            if ($image)
            {
                $results[$group->getId()] = array(
                    'name' => $group->getName(),
                    'image' => $image,
                    'url' => $group->getFriendlyUrl(),
                );
            }
        }  

        return $results;      
    }

    public static function updateProductsWithGift(ProductGroup $group, $is_gift)
    {
        $con = Propel::getConnection();

        if ($is_gift)
        {
            $sql = 'UPDATE %1$s, %2$s SET %3$s = %3$s + 1 WHERE %4$s = %5$s AND %6$s = ?';
        } 
        else
        {
            $sql = 'UPDATE %1$s, %2$s SET %3$s = %3$s - 1 WHERE %4$s = %5$s AND %6$s = ?';
        }

        $st = $con->prepareStatement(sprintf($sql,
            ProductPeer::TABLE_NAME,
            ProductGroupHasProductPeer::TABLE_NAME,
            ProductPeer::IS_GIFT,
            ProductGroupHasProductPeer::PRODUCT_ID,
            ProductPeer::ID,
            ProductGroupHasProductPeer::PRODUCT_GROUP_ID
        ));

        $st->setInt(1, $group->getId());
        $st->executeUpdate();        
    }
}