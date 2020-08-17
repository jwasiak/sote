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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 2687 2009-08-20 10:57:02Z krzysiek $
 */

/**
 * Akcje komponentu produktu
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>
 *
 * @package     stProduct
 * @subpackage  actions
 */
class stProductComponents extends sfComponents {

    protected static $category = null;

    /**
     * Wyświetla grupę produktów
     */
    public function executeProductGroup() {
        $this->smarty = new stSmarty('stProduct');

        $this->smarty->register_function('st_product_image_tag', 'st_product_smarty_image_tag');

        $this->config = stConfig::getInstance('stProduct');
        
        $this->config_points = stConfig::getInstance('stPointsBackend');
        $this->config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());

        $this->product_group_config = stConfig::getInstance('stProductGroup');

        if ($this->params) {
            $product_group = $this->params;
        } elseif ($this->product_group) {
            $product_group = $this->product_group;
        }

        $c = new Criteria();
        $c->add(ProductGroupPeer::PRODUCT_GROUP, $product_group);
        $product_group_object = ProductGroupPeer::doSelectOneCached($c);
        if ($product_group_object) {
            $this->group_name = $product_group_object->getName();

            $this->group_id = $product_group_object->getId();

            $this->group_url = $product_group_object->getFriendlyUrl();

            $this->product_limit = $product_group_object->getProductLimit();
        } else {
            return sfView::NONE;
        }

        if ($this->product_limit) {
            $c = new Criteria();

            $c->addJoin(ProductGroupHasProductPeer::PRODUCT_ID, ProductPeer::ID);

            $c->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $this->group_id);

            $this->addProductFilterCriteria($c);

            if ($this->product_group_config->get('limitation')) {
                $this->addCategoryLimitation($c);
            }

            if ($this->config->get('show_unique')) {
                $stUniqueProduct = stUniqueProduct::getInstance();
                $stUniqueProduct->getCriteria($c);
            }

             if ($product_group != 'MAIN_PAGE' || $this->product_group_config->get('sort_main') == "randomize") {
                
                $this->addRandomCriteria($c, $this->product_limit);
            }elseif ($product_group == 'MAIN_PAGE'){
                if ($this->product_group_config->get('sort_asc_desc') == "asc")
                {
                   $c->addAscendingOrderByColumn(ProductPeer::MAIN_PAGE_ORDER);
                }else{
                   $c->addDescendingOrderByColumn(ProductPeer::MAIN_PAGE_ORDER);
                }
            }

            $c->setLimit($this->product_limit);

            $this->products = ProductPeer::doSelectForPager($c);

            if (!$this->products) 
            {
                return sfView::NONE;
            }

           if ($product_group != 'MAIN_PAGE' || $this->product_group_config->get('sort_main') == "randomize") {
                shuffle($this->products);
            }

            if ($this->config->get('show_unique')) {
                $stUniqueProduct->addProducts($this->products);
            }

            $this->product_group = $product_group;
        }
    }

    /**
     * Pokaż boks nowe produkty
     */
     public function executeNew() 
     {
        
        $config_product_group = stConfig::getInstance('stProductGroup');

        $new_type = $config_product_group->get('new_type');

        if($new_type == 'manual')
        {

            $this->product_group = "NEW";

            $this->executeProductGroup();

            if (empty($this->products)) 
            {
                return sfView::NONE;
            }

        }
        elseif ($new_type == 'date')
        {

            $c = new Criteria();

            $c->add(ProductGroupPeer::PRODUCT_GROUP, "NEW");

            $product_group_object = ProductGroupPeer::doSelectOneCached($c);

            if ($product_group_object) {
                $this->group_name = $product_group_object->getName();

                $this->group_id = $product_group_object->getId();

                $this->group_url = $product_group_object->getFriendlyUrl();

                $this->product_limit = $product_group_object->getProductLimit();
            } else {
                return sfView::NONE;
            }

            $this->config_points = stConfig::getInstance('stPointsBackend');
        
            $this->config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());

            $this->smarty = new stSmarty('stProduct');

            $this->smarty->register_function('st_product_image_tag', 'st_product_smarty_image_tag');

            $this->config = stConfig::getInstance('stProduct');

            $c = new Criteria();

            $c->add(ProductPeer::CREATED_AT, $this->config->get('new_product_date'), Criteria::GREATER_THAN);

            if ($config_product_group->get('limitation')) 
            {
                $this->addCategoryLimitation($c);
            }
            
            $this->addProductFilterCriteria($c);

            $this->product_limit = $product_group_object->getProductLimit();

            if (!$this->product_limit) $this->product_limit = 6;

            $this->addRandomCriteria($c, $this->product_limit);

            $c->setLimit($this->product_limit);


            if ($this->config->get('show_unique')) {
                $stUniqueProduct = stUniqueProduct::getInstance();
                $stUniqueProduct->getCriteria($c);
            }

            $this->products = ProductPeer::doSelectForPager($c);

            if (!$this->products) {
                return sfView::NONE;
            }

            shuffle($this->products);

            if ($this->config->get('show_unique')) {
                $stUniqueProduct->addProducts($this->products);
            }
        }
    }

    /**
     * Filtrowanie kategorii po producentach
     */
    public function executeProducerFilter() 
    {
        if (stProducer::getSelectedProducerId())
        {
            return sfView::NONE;
        }
        
        $this->smarty = new stSmarty('stProduct');

        $config = stConfig::getInstance('stProducer');

        $this->show_filter_in_category = $config->get('show_filter_in_category');

        if (!$this->show_filter_in_category) {
            return sfView::NONE;
        }

        if (!isset($this->criteria))
        {
            $action = $this->getContext()->getActionStack()->getLastEntry()->getActionInstance();

            if (!isset($action->product_pager) || !$action->product_pager->getNbResults())
            {
                return sfView::NONE;
            }

            $pc = clone $action->product_pager->getCriteria();
        }
        else
        {
            $pc = clone $this->criteria;
            ProductPeer::addFilterCriteria($this->getContext(), $pc);
            
            if (!stConfig::getInstance('stProduct')->get('disable_filter_dependency'))
            {
                ProductPeer::addPriceFilterCriteria($this->getContext(), $pc);
                appProductAttributeHelper::addProductFilterCriteria($this->getContext(), $pc);
                stNewProductOptions::addOptionsFilterCriteria($this->getContext(), $pc);
            }
        }

        $pc->clearSelectColumns();
        $pc->clearOrderByColumns();
        $pc->clearGroupByColumns();
        $pc->addSelectColumn(ProductPeer::PRODUCER_ID);
        $pc->remove(ProductPeer::PRODUCER_ID);

        $c = $pc;
        $c->addJoin(ProducerPeer::ID, ProductPeer::PRODUCER_ID);
        $c->addGroupByColumn(ProducerPeer::ID);
        $c->setLimit(-1);
        $c->setOffset(0);

        $this->producers = ProducerPeer::doSelectArray($c);

        if (empty($this->producers)) {
            return sfView::NONE;
        } 

        if ($this->getContext()->getController()->getTheme()->getVersion() >= 7)
        {   
            $this->smarty->assign('action_url', stProductFilter::getFilterUrl($this->getContext()));  
            $this->smarty->assign('reset_url', stProductFilter::getFilterResetUrl($this->getContext(), 'producer'));         
            $this->smarty->assign('producers', $this->producers);
            $this->smarty->assign('filters', stProductFilter::getFilters($this->getContext()));
            return $this->smarty;
        }
        else
        {
            $this->selected = $this->getUser()->getAttribute('producer_filter', 0, stProductFilter::getNamespace($this->getContext(), 'soteshop/stProduct'));                   
        }
    }

    public function executeFilters()
    {

        if (!isset($this->criteria))
        {
            $action = $this->getContext()->getActionStack()->getLastEntry()->getActionInstance();

            if (!isset($action->product_pager) || !stProductFilter::hasFilters($this->getContext()) && !appProductAttributeHelper::hasFilters($this->getContext()) && !$action->product_pager->getNbResults()) 
            {
                return sfView::NONE;
            }

            $this->criteria = $action->getUser()->getParameter('pre_filter_criteria', null, 'soteshop/stProduct');
        }

        $category = $this->getUser()->getParameter('selected', null, 'soteshop/stCategory');

        $smarty = new stSmarty('stProduct');
        $smarty->assign('criteria', $this->criteria);
        $smarty->assign('modal_only', isset($this->modal_only) ? $this->modal_only : false); 
        $smarty->assign('action_url', stProductFilter::getFilterUrl($this->getContext()));
        $smarty->assign('filters', stProductFilter::getFilters($this->getContext()));
        $smarty->assign('show_available_only_filter', stConfig::getInstance('stAvailabilityBackend')->get('show_available_only_filter'));

        return $smarty;
    }

    public function executePriceFilter()
    {
        if (!stConfig::getInstance('stProduct')->get('show_price_filter'))
        {
            return sfView::NONE;
        }

        $filters = stProductFilter::getFilters($this->getContext());

        if (!isset($this->criteria))
        {
            $action = $this->getContext()->getActionStack()->getLastEntry()->getActionInstance();

            if (!isset($action->product_pager) || !$filters && !$action->product_pager->getNbResults()) 
            {
                return sfView::NONE;
            }

            $this->criteria = clone $this->getUser()->getParameter('pre_filter_criteria', null, 'soteshop/stProduct');
        }
        else
        {
            $this->criteria = clone $this->criteria;
        }

        if ($this->getUser()->isAuthenticated() && $this->getUser()->getGuardUser())
        {
            $user = $this->getUser()->getGuardUser();
            $wholesale = $user->getWholesale() ? ucfirst($user->getWholesale()) : false;
        }
        else
        {
            $wholesale = false;
            $user = null;
        }

        $config = stConfig::getInstance('stProduct');
        $view_type = $this->getUser()->getAttribute('view_type', $config->get('list_type'), 'soteshop/stProduct');
        if ($view_type == 'description')
        {
            $view_type = 'long';
        }        
        $brutto = $config->get('price_view_'.$view_type) == 'only_gross' || $config->get('price_view_'.$view_type) == 'gross_net';

        $currency = stCurrency::getInstance($this->getContext());

        $this->criteria->clearSelectColumns();
        $this->criteria->clearOrderByColumns();
        
        if ($brutto)
        {
            $this->criteria->addSelectColumn(ProductPeer::OPT_PRICE_BRUTTO);
            $this->criteria->addSelectColumn(AddPricePeer::PRICE_BRUTTO);
        }
        else
        {
            $this->criteria->addSelectColumn(ProductPeer::PRICE);
            $this->criteria->addSelectColumn(AddPricePeer::PRICE_NETTO);            
        }
        
        AddPricePeer::addJoinCriteria($this->criteria, $currency->get());

        if (!$config->get('disable_filter_dependency'))
        {
            appProductAttributeHelper::addProductFilterCriteria($this->getContext(), $this->criteria);
            stNewProductOptions::addOptionsFilterCriteria($this->getContext(), $this->criteria);
        }

        ProductPeer::addPriceVisibilityCriteria($this->criteria);
        
        $sql = BasePeer::createSqlQuery($this->criteria);

        $con = Propel::getConnection();

        if ($brutto)
        {
            $rs = $con->executeQuery("SELECT MIN(tpp.OPT_PRICE_BRUTTO), MAX(tpp.OPT_PRICE_BRUTTO), MIN(tpp.PRICE_BRUTTO), MAX(tpp.PRICE_BRUTTO) FROM ($sql) as tpp");            
        }
        else
        {
            $rs = $con->executeQuery("SELECT MIN(tpp.PRICE), MAX(tpp.PRICE), MIN(tpp.PRICE_NETTO), MAX(tpp.PRICE_NETTO) FROM ($sql) as tpp");
        }

        $rs->setFetchMode(ResultSet::FETCHMODE_NUM);

        if ($rs->next())
        {
            list($min, $max, $cmin, $cmax) = $rs->getRow();
        }

        if ($min == $max && $cmin == $cmax)
        {
            return sfView::NONE;
        }

        $min = floor($currency->get()->exchange($min));
        $max = ceil($currency->get()->exchange($max));

        if ($wholesale)
        {
            $this->criteria->clearSelectColumns();
            $this->criteria->clearOrderByColumns();  
            if ($brutto)
            {          
                $this->criteria->addSelectColumn(constant('ProductPeer::WHOLESALE_'.$wholesale.'_BRUTTO'));
                $this->criteria->addSelectColumn(constant('AddPricePeer::WHOLESALE_'.$wholesale.'_BRUTTO').' AS currency_wholesale');
            }
            else
            {
                $this->criteria->addSelectColumn(constant('ProductPeer::WHOLESALE_'.$wholesale.'_NETTO'));
                $this->criteria->addSelectColumn(constant('AddPricePeer::WHOLESALE_'.$wholesale.'_NETTO').' AS currency_wholesale');                
            }

            $sql = BasePeer::createSqlQuery($this->criteria);

            if ($brutto)
            {
                $rs = $con->executeQuery("SELECT MIN(tpp.WHOLESALE_{$wholesale}_BRUTTO), MAX(tpp.WHOLESALE_{$wholesale}_BRUTTO), MIN(tpp.currency_wholesale), MAX(tpp.currency_wholesale) FROM ($sql) as tpp WHERE tpp.WHOLESALE_{$wholesale}_BRUTTO > 0");
            }
            else
            {
                $rs = $con->executeQuery("SELECT MIN(tpp.WHOLESALE_{$wholesale}_NETTO), MAX(tpp.WHOLESALE_{$wholesale}_NETTO), MIN(tpp.currency_wholesale), MAX(tpp.currency_wholesale) FROM ($sql) as tpp WHERE tpp.WHOLESALE_{$wholesale}_NETTO > 0");                
            }
            
            $rs->setFetchMode(ResultSet::FETCHMODE_NUM);

            if ($rs->next())
            {
                list($wmin, $wmax, $cwmin, $cwmax) = $rs->getRow();
            }

            if ($wmin)
            {
                $wmin = floor($currency->get()->exchange($wmin));
                $min = min(array($min, floor($wmin)));
            }
            
            if ($wmax)
            {
                $wmax = ceil($currency->get()->exchange($wmax)); 
                $max = max(array($max, ceil($wmax))); 
            }  

            if ($cwmin)
            {
                $min = min(array($min, floor($cwmin)));
            }

            if ($cwmax)
            {
                $max = max(array($max, ceil($cwmax))); 
            }             
        }

        if (null !== $cmax) 
        {
            $min = min(array($min, floor($cmin)));
        }

        if (null !== $cmax)
        {
            $max = max(array($max, ceil($cmax)));
        }

        if ($max == 0) {
            return sfView::NONE;
        }            

        if (!isset($filters['price']))
        {
            $filters['price'] = array('min' => $min, 'max' => $max);
        }
        else
        {
            if ($filters['price']['min'] < $min)
            {
                $filters['price']['min'] = $min;
            }

            if ($filters['price']['max'] > $max)
            {
                $filters['price']['max'] = $max;
            }           
        }

        $smarty = new stSmarty('stProduct');
        $smarty->assign('value', array('min' => $min, 'max' => $max));
        $smarty->assign('filters', $filters);
        $smarty->assign('currency', $currency->getFrontSymbol() ? $currency->getFrontSymbol() : $currency->getBackSymbol());
        
        
        $smarty->assign('action_url', stProductFilter::getFilterUrl($this->getContext()));
        $smarty->assign('reset_url', stProductFilter::getFilterResetUrl($this->getContext(), 'price'));            
        

        return $smarty;
    }

    /**
     * Wyświetla kategorie na stronie głównej
     */
    public function executeTreeMain() {
        $config = stConfig::getInstance('stCategory');

        $this->show_category_main_menu = $config->get('show_category_main_menu');

        if (!$this->show_category_main_menu) {
            return sfView::NONE;
        }

        $this->categories = ProductHasCategoryPeer::doSelectMainPageCategories();

        if (!$this->categories) {
            return sfView::NONE;
        }

        $this->smarty = new stSmarty('stProduct');

        $this->config = $config;

        $this->last_category = count($this->categories) - 1;
    }

    /**
     * Wyświetla produktu dla drzewka dla opcjonalnego pokazywania kategorii
     */
    public function executeTreeProduct() {
        $this->smarty = new stSmarty('stProduct');

        $this->smarty->register_function('st_product_image_tag', 'st_product_smarty_image_tag');

        $config = stConfig::getInstance('stProduct');

        $c = new Criteria();
        $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);
        $c->add(ProductHasCategoryPeer::CATEGORY_ID, $this->id_category);

        if ($config->get('show_unique')) {
            $stUniqueProduct = stUniqueProduct::getInstance();
            $stUniqueProduct->getCriteria($c);
        }
        $this->addProductCriteria($c);
        $this->addRandomCriteria($c, 1);
        $this->product = ProductPeer::doSelectOne($c);
        if ($config->get('show_unique')) {
            $stUniqueProduct->addProducts($this->product);
        }
        $this->category = CategoryPeer::retrieveByPK($this->id_category);
    }

    /**
     * Ogranicza wyświetlanie produktów dla wybranej kategorii
     *
     * @param      Criteria    $c
     */
    private function addCategoryLimitation(Criteria $c) {
        $category = $this->getUser()->getParameter('selected', null, 'soteshop/stCategory');

        if ($category) {
            $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);
            $c->addJoin(ProductHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);
            $c->add(CategoryPeer::LFT, CategoryPeer::LFT . ' BETWEEN ' . $category->getLft() . ' AND ' . $category->getRgt(), Criteria::CUSTOM);
            $c->add(CategoryPeer::SCOPE, $category->getScope());

            if (!in_array(ProductPeer::ID, $c->getGroupByColumns()))
            {
                $c->addGroupByColumn(ProductPeer::ID);
            }
        }
    }

    /**
     * Pokazuje produkt: zdjęcie, opis skrócony
     */
    public function executeSmallProductInfo() {
        $this->smarty = new stSmarty('stProduct');

        $this->config = stConfig::getInstance('stQuestionBackend');

        if ($this->product_id) {
            $this->product = ProductPeer::retrieveByPK($this->product_id);
        }
    }

    public function executeImageGallery() {
        $this->smarty = new stSmarty('stProduct');

        $this->images = $this->product->getImages();

        if (empty($this->images) || $this->getController()->getTheme()->getVersion() >= 7 && count($this->images) == 1)  {
            return sfView::NONE;
        }

        $this->themeVersion = $this->getController()->getTheme()->getVersion();
    }

    /**
     * Lista produktow z grupy typu sBASKET
     */
    public function executeProductInBasketGroup() {
        $c = new Criteria();

        $c->add(ProductGroupPeer::PRODUCT_GROUP, 'BASKET');

        $product_group_object = ProductGroupPeer::doSelectOneCached($c);

        if ($product_group_object) {
            $this->product_limit = $product_group_object->getProductLimit();
        }

        if ($this->product_limit) {
            $c = new Criteria();
            $this->product_group = $product_group_object;
            $c->addJoin(ProductGroupHasProductPeer::PRODUCT_ID, ProductPeer::ID);
            $c->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $product_group_object->getId());
            $this->addProductFilterCriteria($c);
            $c->addAscendingOrderByColumn('RAND()');
            $this->pager = new stPropelPager('Product', $this->product_limit);
            $this->pager->setCriteria($c);
            $this->pager->init();

            if (!$this->pager->getCntResults()) {
                return sfView::NONE;
            }
        } else {
            return sfView::NONE;
        }

        $this->config = stConfig::getInstance('stProduct');

        $this->smarty = new stSmarty('stProduct');

        $this->smarty->register_function('st_product_image_tag', 'st_product_smarty_image_tag');
    }

    /**
     * Pokazuje wybrane losowo produkty z puli
     *
     * @param criteria $c
     * @param integer  $product_limit
     */
    public function addRandomCriteria($c, $product_limit) {
        $count_product = ProductPeer::doCount($c);
        if ($count_product > $product_limit) {
            $random_offset = rand(0, $count_product - $product_limit);
            $c->setOffset($random_offset);
        }
    }
    
   protected function getSortColumns($type = null)
   {
      $sort = array(
          'table_names' => array(
              'name' => ProductI18nPeer::NAME,
              'price' => ProductPeer::PRICE,
              'created_at' => ProductPeer::CREATED_AT,
          ),
      );
      return $type ? $sort[$type] : $sort;
   }

   protected function addProductFilterCriteria($c)
   {
      $category = $this->getUser()->getParameter('selected', null, 'soteshop/stCategory');
      $this->getUser()->setParameter('selected', null, 'soteshop/stCategory');
      ProductPeer::addFilterCriteria($this->getContext(), $c);
      $c->remove(ProductPeer::PRODUCER_ID);
      $this->getUser()->setParameter('selected', $category, 'soteshop/stCategory');
      stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stProductComponents.postAddProductCriteria', array('criteria' => $c)));
   }

   public function hydrateProducerFilter(ResultSet $rs)
   {
        $results = array();

        $rs->setFetchMode(ResultSet::FETCHMODE_ASSOC);
        while($rs->next())
        {        
            $row = $rs->getRow();

            $results[$row['ID']] = array(
                'label' => $row['NAME'] ? $row['NAME'] : $row['OPT_NAME'],
                'image' => $row['IMAGE']
            ); 
        }

        return $results;
   }     
}
