<?php

/**
 * SOTESHOP/stProduct
 *
 * Ten plik należy do aplikacji stProduct opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stProduct
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: ProductPeer.php 2641 2009-08-18 12:02:50Z krzysiek $
 */

class ProductPeer extends BaseProductPeer
{
    const STOCK_PRODUCT_OPTIONS = 0;
    const STOCK_PRODUCT = 1;

    protected static $showedProduct = null;

    protected static $urlPool = array();

    public static function retrieveByUrl($url)
    {
        if (!isset(self::$urlPool[$url]) && !array_key_exists($url, self::$urlPool))
        {
            $c = new Criteria();
            $c->addSelectColumn(ProductI18nPeer::ID);
            $c->add(ProductI18nPeer::URL, $url);
            $c->setLimit(1);
            $rs = ProductI18nPeer::doSelectRS($c);

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

    public static function doSelectImages(Product $product, Criteria $c)
    {
        $c = clone $c;

        $c->addJoin(sfAssetPeer::ID, ProductHasSfAssetPeer::SF_ASSET_ID);

        $c->add(ProductHasSfAssetPeer::PRODUCT_ID, $product->getId());

        return sfAssetPeer::doSelectWithI18n($c);
    }
    
    public static function getShowedProduct()
    {
        return sfContext::getInstance()->getUser()->getParameter('selected', null, 'soteshop/stProduct');
    }   
    
    static public function doCountProduct($c, $distinct = true, $con = null)
    {
        return ProductPeer::doCount($c, $distinct, $con);
    }

    /**
     * Sprawdza czy dany produkt jest nowy
     *
     * @param       Product     $product
     * @return   bool
     */
    static public function isInNewGroup(Product $product)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        $configProduct = stConfig::getConfig('product');
        $c->add(ProductPeer::CREATED_AT, $configProduct['new_product_date'], Criteria::GREATER_THAN);
        $c->add(ProductPeer::ID, $product->getId());
        self::addTimeOn($c);
        $newProduct = ProductPeer::doSelectOne($c);
        if (empty($newProduct))
            return false;
        return true;
    }

    /**
     * Zwraca true jeżeli produkt jest w danej grupie
     *
     * @param        object      $product
     * @param        object      $group
     * @return   bool
     */
    static public function isInGroup(Product $product, $group)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->add(ProductPeer::ID, $product->getId());
        self::addTimeOn($c);
        $product = ProductPeer::doSelectOne($c);
        if (!empty($product))
        {
            $groups = $product->getProductGroups();
            foreach ($groups as $singleGroup)
            {
                if ($group == $singleGroup)
                    return true;
            }
        }
        return false;
    }

    /**
     * Dodaje weryfikacje czy produkt powinien się pokazywać
     *
     * @param      Criteria    $c
     * @return   void
     */
    static private function addTimeOn(Criteria $c)
    {
        $date = date(DATE_ATOM);
        $c1 = $c->getNewCriterion(ProductPeer::START_TIME, $date, Criteria::LESS_THAN);
        $c2 = $c->getNewCriterion(ProductPeer::END_TIME, $date, Criteria::GREATER_THAN);
        $c1->addOr($c->getNewCriterion(ProductPeer::START_TIME, null, Criteria::ISNULL));
        $c2->addOr($c->getNewCriterion(ProductPeer::END_TIME, null, Criteria::ISNULL));
        $c1->addAnd($c2);
        $c1->addOr($c->getNewCriterion(ProductPeer::TIME_ON, false));
        $c->add(ProductPeer::ACTIVE, 1);
        $c->add($c1);
    }

    /**
     * pobieranie z dodatkowym cachem
     *
     * @param       integer     $pk
     * @param        object      $con
     * @return   Product
     */
    public static function retrieveByPK($pk, $con = null)
    {
        /**
         * @todo przerobić cachowanie danych, tak aby można było odczytać wersje językowe
         */
        //        $stCache = new stFunctionCache('stProduct');
        //        return $stCache->add('retrieve_'.$pk,"BaseProductPeer::retrieveByPK",$pk, $con);
        return parent::retrieveByPK($pk, $con = null);
    }

    public static function setVat(Product $object = null, $value)
    {
        $c = new Criteria();
        $c->add(TaxPeer::VAT,$value);
        $tax = TaxPeer::doSelectOne($c);

        if (!$tax)
        {
            $tax = new Tax();
            $tax->setVat($value);
            $tax->save();
        }
        $object->setVat($tax->getId());
        $object->setOptVat($value);
        $object->setPriceBruttoByNetto($object->getPrice(),$value);
    }

    public static function getProductImagesArray(Product $product, $returnUrl = false)
    {
        $c = new Criteria();
        $c->addSelectColumn(sfAssetPeer::ID);
        $c->addSelectColumn(sfAssetPeer::FILENAME);
        $c->add(ProductHasSfAssetPeer::PRODUCT_ID, $product->getId());
        $c->addJoin(sfAssetPeer::ID, ProductHasSfAssetPeer::SF_ASSET_ID);
        $c->addDescendingOrderByColumn(ProductHasSfAssetPeer::IS_DEFAULT);
        $c->addAscendingOrderByColumn(ProductHasSfAssetPeer::ID);
        $rs = sfAssetPeer::doSelectRS($c);
        
        $images = array();
        while($rs->next())
        {
            list($id, $filename) = $rs->getRow();
            
            if ($returnUrl) 
            {
                $request = sfContext::getInstance()->getRequest();
                $httpPrefix = stConfig::getInstance('stSecurityBackend')->get('ssl') == 'shop' ? 'https://' : 'http://';
                $images[$id] = $httpPrefix . $request->getHost() . '/media/products/' . $product->getOptAssetFolder() . '/images/' . $filename;
            }
            else
            {
                $images[$id] = $filename;
            }
        }

        return $images;        
    }

    /**
     * Przeciążenie metody pobierającej produkty w odpowiedniej wersji jezykowej
     *
     * @param Criteria $c Kryteria
     * @param mixed $culture Wersja językowa
     * @param CreoleConnection $con Połączenie z bazą danych
     * @return array Produkty
     */
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

        $c->addJoin(ProductI18nPeer::ID, ProductPeer::ID);

        $c->add(ProductI18nPeer::CULTURE, stLanguage::getHydrateCulture());

        return self::doCount($c, $con);
    }

    public static function setOldPrice(Product $object, $value=0.0)
    {
        $object->setOldPriceBruttoByNetto($value,$object->getVat());
        return $object->setOldPrice($value);

    }

    public static function getOldPrice(Product $object)
    {
        return $object->getOldPrice();
    }
    
    public static function setBasicPrice(Product $object, $value=0.0)
    {
        $object->setBasicPriceBruttoByNetto($value,$object->getVat());
        return $object->setBasicPrice($value);

    }

    public static function getBasicPrice(Product $object)
    {
        return $object->getBasicPrice();
    }

    public static function doSelectDiscountGroupsForTokenInput(Product $product)
    {
        $c = new Criteria();

        $c->add(DiscountHasProductPeer::PRODUCT_ID, $product->getId());

        $c->addJoin(DiscountHasProductPeer::DISCOUNT_ID, DiscountPeer::ID);

        $c->addSelectColumn(DiscountPeer::ID);

        $c->addSelectColumn(DiscountPeer::NAME);

        $c->addSelectColumn(DiscountPeer::VALUE);

        $rs = DiscountPeer::doSelectRs($c);

        $tokens = array();

        while($rs->next())
        {
            $row = $rs->getRow();

            $tokens[] = array('id' => $row[0], 'name' => $row[1].' ('.$row[2].')');
        }

        return $tokens;
    }

    public static function doSelectProductGroupsForTokenInput(Product $product)
    {
        $c = new Criteria();

        $c->add(ProductGroupHasProductPeer::PRODUCT_ID, $product->getId());
        $c->addJoin(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, ProductGroupPeer::ID);
        $c->add(ProductGroupPeer::FROM_BASKET_VALUE, null, Criteria::ISNULL);

        return self::doSelectProductGroupTokens($c);
    }  

    public static function doSelectProductGroupTokens(Criteria $c)
    {
        $tokens = array();
        
        $c = clone $c;

        $c->addSelectColumn(ProductGroupPeer::ID);
        $c->addSelectColumn(ProductGroupPeer::OPT_NAME);

        $rs = ProductGroupPeer::doSelectRs($c);

        $tokens = array();

        while($rs->next())
        {
            list($id, $name) = $rs->getRow();

            $tokens[] = array('id' => $id, 'name' => $name);
        }  

        return $tokens;     
    }

    public static function doSelectAccessoriesForTokenInput(Product $product)
    {
        $c = new Criteria();

        $c->add(ProductHasAccessoriesPeer::PRODUCT_ID, $product->getId());

        $c->addJoin(self::ID, ProductHasAccessoriesPeer::ACCESSORIES_ID);

        $c->addAscendingOrderByColumn(ProductHasAccessoriesPeer::ID);

        return self::doSelectTokens($c);
    }

    public static function doSelectRecommendForTokenInput(Product $product)
    {
        $c = new Criteria();

        $c->add(ProductHasRecommendPeer::PRODUCT_ID, $product->getId());

        $c->addJoin(ProductHasRecommendPeer::RECOMMEND_ID, self::ID);

        $c->addAscendingOrderByColumn(ProductHasRecommendPeer::ID);

        return self::doSelectTokens($c);
    }     

    public static function doSelectTokens(Criteria $c)
    {
        sfLoader::loadHelpers(array('Helper', 'stProductImage'));

        $c = clone $c;

        $c->addSelectColumn(self::ID);

        $c->addSelectColumn(self::OPT_NAME);

        $c->addSelectColumn(self::OPT_IMAGE);

        $c->addSelectColumn(self::CODE);

        $rs = self::doSelectRs($c);

        $tokens = array();

        while($rs->next())
        {
            list($id, $name, $image, $code) = $rs->getRow();

            $tokens[] = array('id' => $id, 'name' => $name, 'image' => st_product_image_path($image, 'icon'), 'code' => $code);
        }

        return $tokens;      
    }

    public static function doSelectCategoriesTokens(Criteria $c)
    {
        return CategoryPeer::doSelectCategoriesTokens($c);
    }
    
    public static function doSelectCategoriesForTokenInput(Product $product)
    {
        $c = new Criteria();

        $c->add(ProductHasCategoryPeer::PRODUCT_ID, $product->getId());

        $c->addJoin(ProductHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);

        $c->addAscendingOrderByColumn(ProductHasCategoryPeer::ID); 

        return self::doSelectCategoriesTokens($c);
    }  

    public static function doSelectDefaultCategoryId(Product $product)
    {
        $c = new Criteria();

        $c->addSelectColumn(ProductHasCategoryPeer::CATEGORY_ID);

        $c->add(ProductHasCategoryPeer::PRODUCT_ID, $product->getId());

        $c->add(ProductHasCategoryPeer::IS_DEFAULT, true);

        $rs = self::doSelectRS($c);

        if ($rs && $rs->next())
        {
           return $rs->getInt(1);
        }

        return null;
    }

    public static function addFilterCriteria(sfContext $context = null, Criteria $c, $with_list_criteria = true)
    {
        $config = stConfig::getInstance('stProduct');

        $c->add(self::ACTIVE, 1);
        $c->add(self::IS_GIFT, 0);

        if ($config->get('show_without_price'))
        {            
            if(stPoints::isPointsSystemActive())
            {
                $criterion = $c->getNewCriterion(self::PRICE, 0, Criteria::GREATER_THAN);
                $criterion->addOr($c->getNewCriterion(self::POINTS_ONLY, 1));
                $c->add($criterion);    
            }
            else
            {
                $c->add(self::PRICE, 0, Criteria::GREATER_THAN);
                $c->add(self::POINTS_ONLY, 0);
            }
            
        }  

        if (null !== $context)
        { 
            if ($with_list_criteria)
            {
                $producer_id = stProducer::getSelectedProducerId();

                if ($producer_id)
                {
                    $c->add(self::PRODUCER_ID, $producer_id);   
                }

                $category = $context->getUser()->getParameter('selected', null, 'soteshop/stCategory');  

                if ($category)
                {
                    if ($category->getShowChildrenProducts() && $category->hasChildren())
                    {
                        $c->add(CategoryPeer::SCOPE, $category->getScope());
                        
                        if (!$category->isRoot())
                        {
                            $c->add(CategoryPeer::LFT, sprintf('%s BETWEEN %d AND %d', CategoryPeer::LFT, $category->getLft(), $category->getRgt()), Criteria::CUSTOM);
                        }
                        
                        $c->addJoin(CategoryPeer::ID, ProductHasCategoryPeer::CATEGORY_ID);
                        $c->addJoin(self::ID, ProductHasCategoryPeer::PRODUCT_ID);
                    }
                    else
                    {
                        $c->addJoin(self::ID, ProductHasCategoryPeer::PRODUCT_ID);
                        $c->add(ProductHasCategoryPeer::CATEGORY_ID, $category->getId());
                    } 

                    if (!in_array(self::ID, $c->getGroupByColumns()))
                    {
                        $c->addGroupByColumn(self::ID);
                    }        
                } 
            }

            $action = $context->getActionStack()->getLastEntry()->getActionInstance();

            if (stConfig::getInstance('stAvailabilityBackend')->get('show_available_only_filter')) 
            {
                $filters = stProductFilter::getFilters($context);

                if (isset($filters['available_only']) && $filters['available_only'])
                {
                    AvailabilityPeer::addProductCriteria($c);
                }
            }

            stEventDispatcher::getInstance()->notify(new sfEvent($action, 'stProductActions.postAddProductCriteria', array('criteria' => $c)));  
        }    
    }

    public static function addPriceFilterCriteria(sfContext $context, Criteria $c)
    {
        $filters = stProductFilter::getFilters($context);

        $config = stConfig::getInstance('stProduct');
        $view_type = $context->getUser()->getAttribute('view_type', $config->get('list_type'), 'soteshop/stProduct');
        if ($view_type == 'description')
        {
            $view_type = 'long';
        }
        $brutto = $config->get('price_view_'.$view_type) == 'only_gross' || $config->get('price_view_'.$view_type) == 'gross_net';

        if (stConfig::getInstance('stProduct')->get('show_price_filter') && isset($filters['price']))
        {
            $user = $context->getUser();
            $min = filter_var($filters['price']['min'], FILTER_SANITIZE_NUMBER_FLOAT);
            $max = filter_var($filters['price']['max'], FILTER_SANITIZE_NUMBER_FLOAT);
            $currency = stCurrency::getInstance($context)->get();
            
            AddPricePeer::addJoinCriteria($c, $currency);

            if ($user->isAuthenticated() && $user->getGuardUser() && $user->getGuardUser()->getWholesale())
            {
                $wholesale = ucfirst($user->getGuardUser()->getWholesale());
                $c->add(ProductPeer::OPT_PRICE_BRUTTO, sprintf('(%8$s = 0.00 AND (%1$s IS NULL AND %2$s BETWEEN %3$s AND %4$s OR %1$s IS NOT NULL AND %1$s BETWEEN %5$s AND %6$s) OR %7$s IS NULL AND %8$s BETWEEN %3$s AND %4$s OR %7$s IS NOT NULL AND %7$s BETWEEN %5$s AND %6$s)',
                    $brutto ? AddPricePeer::PRICE_BRUTTO : AddPricePeer::PRICE_NETTO,
                    $brutto ? ProductPeer::OPT_PRICE_BRUTTO : ProductPeer::PRICE,                                                                                                                                                                        
                    $currency->exchange($min, true),
                    $currency->exchange($max, true),
                    $min,
                    $max,
                    $brutto ? constant('AddPricePeer::WHOLESALE_'.$wholesale.'_BRUTTO') : constant('AddPricePeer::WHOLESALE_'.$wholesale.'_NETTO'),
                    $brutto ? constant('ProductPeer::WHOLESALE_'.$wholesale.'_BRUTTO') : constant('ProductPeer::WHOLESALE_'.$wholesale.'_NETTO')
                ), Criteria::CUSTOM);
            }
            else
            {
                $c->add(ProductPeer::OPT_PRICE_BRUTTO, sprintf('(%1$s IS NULL AND %2$s BETWEEN %3$s AND %4$s OR %1$s IS NOT NULL AND %1$s BETWEEN %5$s AND %6$s)',
                    $brutto ? AddPricePeer::PRICE_BRUTTO : AddPricePeer::PRICE_NETTO,
                    $brutto ? ProductPeer::OPT_PRICE_BRUTTO : ProductPeer::PRICE, 
                    $currency->exchange($min, true),
                    $currency->exchange($max, true),
                    $min,
                    $max
                ), Criteria::CUSTOM);
            }

            self::addPriceVisibilityCriteria($c);
            $c->add(ProductPeer::POINTS_ONLY, false);
        } 
    }

    public static function addSearchCriteria(Criteria $c, $keywords, $culture)
    {
        $revelance = count($keywords);

        if ($revelance)
        {
            $c->addJoin(ProductHasProductSearchTagPeer::PRODUCT_ID, ProductPeer::ID);
            $c->addJoin(ProductSearchTagPeer::ID, ProductHasProductSearchTagPeer::PRODUCT_SEARCH_TAG_ID);      


            if ($revelance > 1)
            {
                if (strlen($keywords[$revelance-1]) > 1)
                {
                    $criterion = $c->getNewCriterion(ProductSearchTagPeer::TAG, array_slice($keywords, 0, $revelance-1), Criteria::IN);  
                    $criterion->addOr($c->getNewCriterion(ProductSearchTagPeer::TAG, $keywords[$revelance-1].'%', Criteria::LIKE));
                    $c->add($criterion);
                }
                else
                {
                    $c->add(ProductSearchTagPeer::TAG, $keywords, Criteria::IN);  
                }      
            }
            else
            {
                $c->add(ProductSearchTagPeer::TAG, $keywords[0].'%', Criteria::LIKE);
            }

            $c->add(ProductHasProductSearchTagPeer::CULTURE, $culture);

            if (!in_array(ProductPeer::ID, $c->getGroupByColumns()))
            {
                $c->addGroupByColumn(ProductPeer::ID);
            }

            $c->addHaving('COUNT('.ProductHasProductSearchTagPeer::TAG_VALUE.') >= '.$revelance); 

            stEventDispatcher::getInstance()->notify(new sfEvent(null, 'ProductPeer.addSearchCriteria', array('criteria' => $c)));  
        }
        else
        {
            $c->add(ProductPeer::ID, 0, Criteria::CUSTOM);
        }

        return $revelance > 0;             
    }

    public static function getSearchSortCriteria($query, $culture)
    {
        $analyzer = stTextAnalyzer::getInstance($culture);
        $keywords = array_keys($analyzer->analyze($query));

        $cmp = array();

        $phpVersion = version_compare(PHP_VERSION, '7.0.0', '<');

        $con = Propel::getConnection();

        foreach ($keywords as $keyword)
        {
            $keyword = $phpVersion ? mysql_escape_string($keyword) : mysqli_real_escape_string($con->getResource(), $keyword);
                
            $cmp[] = sprintf("IF(STRCMP(%s, '%s'), 1, 2)", ProductSearchTagPeer::TAG, $keyword);
        }

        return $cmp;        
    }


    public static function addSearchSortCriteria($query, Criteria $criteria, $culture)
    {
        $cmp = self::getSearchSortCriteria($query, $culture);

        $criteria->addDescendingOrderByColumn('SUM('.ProductHasProductSearchTagPeer::TAG_VALUE.($cmp ? ' * '.implode(" + ", $cmp) : '').')');        
    }

    public static function doSelectForPager(Criteria $c)
    {
        $c = clone $c;

        $c->addJoin(ProductPeer::ID, sprintf('%s AND %s = \'%s\'', ProductI18nPeer::ID, ProductI18nPeer::CULTURE, sfContext::getInstance()->getUser()->getCulture()), Criteria::LEFT_JOIN);

        $sort = $c->getOrderByColumns();
        
        $ids = self::doSelectIds($c);

        if (!$ids)
        {
            return array();
        }

        DiscountPeer::setProductBatchIds($ids);

        $pc = new Criteria();

        $pc->add(self::ID, $ids, Criteria::IN);

        $pc->addOrderByField(self::ID, $ids);

        return self::doSelectWithI18n($pc);
    } 

    public static function doSelectIds(Criteria $c)
    {
        $c = clone $c;
        $c->clearSelectColumns();
        $c->addSelectColumn(self::ID);

        $rs = self::doSelectRs($c);

        $ids = array();

        while($rs->next())
        {
            $row = $rs->getRow();
            $ids[] = $row[0];
        } 

        return $ids;       
    }   

    public static function addPriceVisibilityCriteria(Criteria $c)
    {
        $user = sfContext::getInstance()->getUser();

        $criterion = $c->getNewCriterion(ProductPeer::HIDE_PRICE, null, Criteria::ISNULL);

        $hide = stConfig::getInstance('stProduct')->get('global_hide_price');

        if ($hide == 0 || $hide == 2 && $user->isAuthenticated() || $hide == 3 && $user->isAuthenticated() && null !== $user->getGuardUser() && $user->getGuardUser()->getIsAdminConfirm())
        {
            $criterion->addOr($c->getNewCriterion(ProductPeer::HIDE_PRICE, 0)); 
        }

        if ($user->isAuthenticated())
        {
            $criterion->addOr($c->getNewCriterion(ProductPeer::HIDE_PRICE, 2));
        }

        if ($user->isAuthenticated() && null !== $user->getGuardUser() && $user->getGuardUser()->getIsAdminConfirm())
        {
            $criterion->addOr($c->getNewCriterion(ProductPeer::HIDE_PRICE, 3));
        }   

        $c->add($criterion);   
    }
}