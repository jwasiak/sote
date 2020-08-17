<?php

class stCategoryTreeComponents extends sfComponents
{
   public $productCountCriteria = null;

   protected $cache = null;

   protected static $cachedCategories = array();

   protected $check = null;

   protected $hydrateWithProducer = false;

   public $categoryUrlParameters = array('module' => 'stProduct', 'action' => 'list');

   /**
    * Konfiguracja kategorii
    *
    * @var stConfig
    */
   protected $categoryConfig = null;

   protected $dispatcher;

   public function initialize($context)
   {
      $this->cache = new stFunctionCache('stCategoryTree');

      $ret = parent::initialize($context);

      $c = new Criteria();
      $c->addSelectColumn('COUNT(DISTINCT '.ProductPeer::ID.')');
      $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);
      $c->addJoin(ProductHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);
      $c->add(CategoryPeer::IS_ACTIVE, 1);

      // if ($this->checkForHidden())
      // {
      //    $c->add(CategoryPeer::IS_HIDDEN, 0);
      // }

      ProductPeer::addFilterCriteria($this->getContext(), $c, false);

      $this->productCountCriteria = $c;

      $this->dispatcher = stEventDispatcher::getInstance();

      $this->categoryConfig = stConfig::getInstance('stCategory');

      return $ret;
   }

   public function __toString()
   {
      return get_class($this);
   }

   public function executeShow()
   {
      $this->dispatcher->notify(new sfEvent($this, 'stCategoryTreeComponents.preExecuteShow'));

      $this->smarty = new stSmarty('stCategoryTree');

      $this->config = stConfig::getInstance($this->getContext(), 'stCategory');

      $selected = $this->getUser()->getParameter('selected', null, 'soteshop/stCategory');

      if ($selected && !$selected->getIsHidden())
      {
         CategoryPeer::setHydrateMethod(array($this, 'hydrateSelected'));

         $path = $selected->getPath();

         $path[$selected->getId()] = $selected->getId();
         
         $this->expanded = $path;
      }
      else
      {
         $this->expanded = array();
      }

      $c = new Criteria();

      $c->addAsColumn('ID', CategoryPeer::ID);

      $c->addAscendingOrderByColumn(CategoryPeer::SCOPE);

      CategoryPeer::setHydrateMethod(array($this, 'hydrateCategories'));

      $host = sfContext::getInstance()->getRequest()->getHost();

      $this->roots = $this->getCategoriesCached(array('producer_id' => stProducer::getSelectedProducerId(), 'host'=>$host));

      CategoryPeer::setHydrateMethod(null);

      if (!$this->roots)
      {
         return sfView::NONE;
      }
   }

   public function executeTree()
   {
      $this->dispatcher->notify(new sfEvent($this, 'stCategoryTreeComponents.preExecuteTree'));

      $host = sfContext::getInstance()->getRequest()->getHost();
      $producer_id = stProducer::getSelectedProducerId();

      $config = stConfig::getInstance($this->getContext(), 'stCategory');

      $fc = new stFunctionCache('stCategoryTree');

      $categories = $this->getCategoriesCached(array('scope' => $this->parent['scope'], 'producer_id' => $producer_id, 'host'=>$host));

      $this->categories = new stCategoryTreeIterator($categories, $this->expanded);

      $this->show_product_count = $config->get('show_product_count');
   }

   public function executeVertical()
   {
      $smarty = new stSmarty('stCategoryTree');

      sfLoader::loadHelpers(array('Helper', 'stUrl'));

      $this->dispatcher->notify(new sfEvent($this, 'stCategoryTreeComponents.preExecuteVertical'));

      if (!isset($this->category))
      {
         $this->category = $this->getUser()->getParameter('selected', null, 'soteshop/stCategory');
      }

      $producer = stProducer::getSelectedProducer();

      if ($this->category)
      {

         $categories = array();

         if ($this->category->hasChildren())
         {
            $categories = $this->getCategoriesCached(array('parent_id' => $this->category->getId(), 'producer_id' => stProducer::getSelectedProducerId()));
            $has_children = !empty($categories);
         }
         else
         {
            $has_children = false;
         }

         if (!$categories)
         {
            $categories = $this->getCategoriesCached(array('parent_id' => $this->category->getParentId(), 'producer_id' => stProducer::getSelectedProducerId()));
         }

         $show_roots = count($this->getCategoriesCached(array('producer_id' => stProducer::getSelectedProducerId()))) > 1;

         if ($has_children && $this->category->getDepth() >= 1 || $this->category->getDepth() == 0 && $show_roots)
         {
            $url = array('module' => 'stProduct', 'action' => 'list', 'url' => $this->category->getFriendlyUrl());

            if (stProducer::getSelectedProducer() && $this->hasRequestParameter('producer'))
            {
               $url['producer'] = $this->getRequestParameter('producer');      
            }

            $smarty->assign('current', array(
               'url' => st_url_for($url),
               'name' => $this->category->getName(),
            ));
         }
         elseif ($this->category->getParent() && ($this->category->getDepth() > 1 || $show_roots))
         {
            $url = array('module' => 'stProduct', 'action' => 'list', 'url' => $this->category->getParent()->getFriendlyUrl());

            if (stProducer::getSelectedProducer() && $this->hasRequestParameter('producer'))
            {
               $url['producer'] = $this->getRequestParameter('producer');      
            }

            $smarty->assign('current', array(
               'url' => st_url_for($url),
               'name' => $this->category->getParent()->getName(),
            ));
         }
         elseif ($producer)
         {
            $smarty->assign('current', array(
               'url' => st_url_for('stProduct/producerList?url='.$producer->getUrl()),
               'name' => $producer->getName(),
            ));
         }

         $smarty->assign('selected', array('id' => $this->category->getId()));
         $smarty->assign('categories', $categories);
         $smarty->assign('config', array(
            'show_roots' => $show_roots
         ));

         if ($producer && ($show_roots && $this->category->getDepth() == 0 || !$show_roots && $this->category->getDepth() == 1 && $has_children || $show_roots && $this->category->getDepth() == 1 && !$has_children || !$show_roots && $this->category->getDepth() == 2 && !$has_children))
         {
            $smarty->assign('parent', array(
               'url' => st_url_for(array('module' => 'stProduct', 'action' => 'producerList', 'url' => $producer->getFriendlyUrl())),
               'name' => $producer->getName(),
            ));
        
         }
         elseif ($this->category->getDepth() >= 1 && $this->category->getParent())
         {
            $parent = $has_children ? $this->category->getParent() : $this->category->getParent()->getParent();

            if ($parent && $parent->getDepth() < 1)
            {
                $smarty->assign('parent', array(
                    'url' => st_url_for('@homepage'),
                    'name' => $this->getContext()->getI18N()->__('Strona główna', null, 'stFrontend'),
                 ));                  
            }
            elseif ($parent)
            {
               $url = array('module' => 'stProduct', 'action' => 'list', 'url' => $parent->getFriendlyUrl());

               if (stProducer::getSelectedProducer() && $this->hasRequestParameter('producer'))
               {
                  $url['producer'] = $this->getRequestParameter('producer');      
               }

               $smarty->assign('parent', array(
                  'url' => st_url_for($url),
                  'name' => $parent->getName(),
               ));
            }
         }
         elseif ($show_roots || $this->category->getDepth() < 1)
         {
            $smarty->assign('parent', array(
               'url' => st_url_for('@homepage'),
               'name' => $this->getContext()->getI18N()->__('Strona główna', null, 'stFrontend'),
            ));            
         }
         else
         {
            $smarty->assign('parent', null);
         }
      }
      else
      {

         $roots = $this->getCategoriesCached(array('producer_id' => stProducer::getSelectedProducerId()));


         if (count($roots) == 1)
         {                   
            $categories = $this->getCategoriesCached(array('parent_id' => $roots[0]['id'], 'producer_id' => stProducer::getSelectedProducerId()));
         }
         else
         {
            $categories = $roots;
         }

         $smarty->assign('categories', $categories);

         if ($producer)
         {
            $smarty->assign('current', array(
               'url' => st_url_for('stProduct/producerList?url='.$producer->getUrl()),
               'name' => $producer->getName(),
            ));
         }
      }

      $smarty->assign('tree', $this);

      return $smarty;
   }   

   public function executeHorizontalChildren()
   {
      $config = stConfig::getInstance($this->getContext(), 'stCategory');

      if (!isset($this->category))
      {
         $this->category = $this->getUser()->getParameter('selected', null, 'soteshop/stCategory');
      }

      if (isset($this->checkForHidden))
      {
         $this->check = $this->checkForHidden;
      }
      
      $this->check = false;

      if (!$this->category || !$this->category->hasChildren() || $config->get('show_subcategories')!=1)
      {
         return sfView::NONE;
      }

      $limit = isset($this->limit) ? $this->limit : null;
      
      $categories = $this->getCategoriesCached(array('parent_id' => $this->category->getId(), 'producer_id' => stProducer::getSelectedProducerId(), 'horizontal' => 1));

      if (!$categories)
      {
         return sfView::NONE;
      }

      $smarty = new stSmarty('stCategoryTree');
      $smarty->assign('categories', $categories);
      $smarty->assign('tree', $this);
      $smarty->assign('producer', stProducer::getSelectedProducerId());

      return $smarty;
   }

   public function executeHorizontal()
   {
      if ($this->checkForHidden())
      {
         $roots = $this->getCategoriesCached();

         if (!$roots)
         {         
            return sfView::NONE;
         }         
      }
      else
      {
         $id = stConfig::getInstance('appCategoryHorizontalBackend')->get('category_id');
         $roots = $this->getCategoriesCached(array('parent_id' => $id));
      }

      if (!$roots)
      {         
         return sfView::NONE;
      }           

      $smarty = new stSmarty('stCategoryTree');

      if (count($roots) == 1)
      {
         $smarty->assign('categories_root', $roots);
         $categories = $this->getChildren($roots[0]);
         $smarty->assign('root', $roots[0]);
         $smarty->assign('categories', $categories);
         $smarty->assign('single_tree', 1);
      }
      else
      {
         $smarty->assign('categories', $roots);
         $smarty->assign('single_tree', 0);
      }

      $config = stConfig::getInstance('stCategory');

      $smarty->assign('tree', $this);

      return $smarty;
   }

   public function executeHorizontalTree()
   {
      sfLoader::loadHelpers(array('Helper', 'Url', 'stUrl'));

      $c = new Criteria();

      $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);

      $roots = CategoryPeer::doSelect($c);

      if (!$roots)
      {
         return sfView::NONE;
      }

      $results = array();

      foreach ($roots as $root)
      {
         $c = new Criteria();

         $c->add(CategoryPeer::PARENT_ID, $root->getId());

         $categories = array();

         $children = ProductHasCategoryPeer::doSelectCategories($c);

         if ($children)
         {
            foreach ($children as $child)
            {
               $categories[] = array('name' => $child->getName(), 'url' => st_url_for('stProduct/list?url=' . $child->getFriendlyUrl()), 'instance' => $child);
            }

            $results[] = array('name' => $root->getName(), 'categories' => $categories, 'instance' => $root);
         }
      }

      $this->results = $results;

      $this->smarty = new stSmarty('stCategoryTree');
   }

   public function executeAjaxTree()
   {
      $this->dispatcher->notify(new sfEvent($this, 'stCategoryTreeComponents.preExecuteAjaxTree'));

      $config = stConfig::getInstance(sfContext::getInstance(), 'stCategory');

      $expand_always = !$this->expanded && $config->get('expand_root') != -1 || $this->expanded && $config->get('expand_always');

      $this->smarty = new stSmarty('stCategoryTree');

      $this->smarty->register_function('render_ajax_categories', array($this, 'smartyRenderAjaxCategories'));

      $this->smarty->register_function('jquery_tree_init', array($this, 'smartyJQueryTreeInit'));

      $this->smarty->assign('roots', $this->roots);
      
      if ($this->getUser()->hasParameter('selected', 'soteshop/stCategory'))
      {
         $this->smarty->assign('selected', $this->expanded ? end($this->expanded) : null);
      }      

      $this->smarty->assign('expand_always', $expand_always);

      $this->smarty->assign('expanded', $this->expanded);

      $this->smarty->assign('show_roots', !$config->get('hide_root'));

      $this->smarty->assign('show_product_count', $config->get('show_product_count'));
   }

   public function executeAjaxCategories()
   {
      $this->dispatcher->notify(new sfEvent($this, 'stCategoryTreeComponents.preExecuteAjaxCategories'));

      $host = sfContext::getInstance()->getRequest()->getHost();
      $producer_id = stProducer::getSelectedProducerId();

      $config = stConfig::getInstance(sfContext::getInstance(), 'stCategory');

      $fc = new stFunctionCache('stCategoryTree');

      $categories = $this->getCategoriesCached(array('scope' => $this->parent['scope'], 'parent_id' => $this->parent['id'], 'producer_id' => $producer_id, 'host'=>$host));

      if (!$categories)
      {
         return sfView::NONE;
      }

      $this->smarty = new stSmarty('stCategoryTree');

      $this->smarty->assign('categories', $categories);

      if ($this->getUser()->hasParameter('selected', 'soteshop/stCategory'))
      {
         $this->smarty->assign('selected', $this->expanded ? end($this->expanded) : null);
      }

      $this->smarty->assign('unique_id', !$this->parent['is_root'] || $config->get('hide_root') ? $this->parent['id'] : null);

      $this->smarty->assign('expanded', $this->expanded);

      $this->smarty->assign('show_product_count', $config->get('show_product_count'));

      $this->smarty->assign('include_root_class', $config->get('hide_root') && $this->parent['is_root']);

      $this->smarty->register_function('render_ajax_categories', array($this, 'smartyRenderAjaxCategories'));
   }

   public function smartyRenderAjaxCategories($params)
   {
      return st_get_component('stCategoryTree', 'ajaxCategories', array('parent' => $params['for'], 'expanded' => $this->expanded));
   }

   public function smartyJQueryTreeInit($params)
   {
      sfLoader::loadHelpers(array('stJQueryTree'), 'stCategoryTree');

      $url = $this->dispatcher->filter(new sfEvent($this, 'stCategoryTreeComponents.smartyJQueryTreeInit'), array('module' => 'stCategoryTree', 'action' => 'ajaxCategories'))->getReturnValue();

      return st_jquery_tree_init($params['for']['id'], array('url' => $url));
   }

   public function getChildren($category, $producer = null)
   {
      return $this->getCategoriesCached(array('parent_id' => $category['id'], 'producer_id' => $producer));
   }

   public function getCategoriesCached($params = array())
   {      

      $params = $this->dispatcher->filter(new sfEvent($this, 'stCategoryTreeComponents.filterCategoryParams'), $params)->getReturnValue();

      $id = $this->getUser()->getCulture().'-'.sha1(serialize($params).serialize($this->categoryUrlParameters));

      if (!isset(self::$cachedCategories[$id]))
      {
         self::$cachedCategories[$id] = $this->cache->cacheCall(array($this, 'getCategories'), array($params), array('id' => $id));
      }

      return self::$cachedCategories[$id];
   }

   public function getCategories($params = array())
   {
      $product_config = stConfig::getInstance(null, 'stProduct');
      
      $c = new Criteria();
      $c->addSelectColumn(CategoryPeer::ID);
      $c->addSelectColumn(CategoryPeer::PARENT_ID);      
      $c->addSelectColumn(CategoryPeer::LFT);
      $c->addSelectColumn(CategoryPeer::RGT);
      $c->addSelectColumn(CategoryPeer::SCOPE);
      $c->addSelectColumn(CategoryPeer::DEPTH);
      $c->addSelectColumn(CategoryI18nPeer::NAME);
      $c->addSelectColumn(CategoryPeer::OPT_NAME);
      $c->addSelectColumn(CategoryI18nPeer::URL);
      $c->addSelectColumn(CategoryPeer::OPT_URL);
      $c->addSelectColumn(CategoryPeer::OPT_IMAGE);
   
      stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stCategoryTreeComponents.getCategories',array('criteria'=>$c)));

      $c->add(CategoryPeer::IS_ACTIVE, true);
      
      if ($this->checkForHidden())
      {
         $c->add(CategoryPeer::IS_HIDDEN, false);
      }

      if (isset($params['parent_id']))
      {
         $c->add(CategoryPeer::PARENT_ID, $params['parent_id']);

         $c->addAscendingOrderByColumn(CategoryPeer::LFT);
      }
      elseif (isset($params['scope']))
      {
         $c->add(CategoryPeer::SCOPE, $params['scope']);

         $c->addAscendingOrderByColumn(CategoryPeer::LFT);
      }
      else
      {
         $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);

         $c->addAscendingOrderByColumn(CategoryPeer::ROOT_POSITION);
      }

      if ($this->categoryConfig->get('hide_categories_without_products'))
      {
         if (isset($params['producer_id']) && $params['producer_id'])
         {
            $this->productCountCriteria->add(ProductPeer::PRODUCER_ID, $params['producer_id']);
            $this->hydrateWithProducer = true;
         }
         else
         {
            $this->productCountCriteria->remove(ProductPeer::PRODUCER_ID);
            $this->hydrateWithProducer = false;
         }
      }
      elseif (isset($params['producer_id']) && $params['producer_id'])
      {
         $c->addJoin(CategoryPeer::ID, ProductHasCategoryPeer::CATEGORY_ID);
         $c->addJoin(ProductHasCategoryPeer::PRODUCT_ID, ProductPeer::ID);
         $c->add(ProductPeer::PRODUCER_ID, $params['producer_id']);
         $c->addGroupByColumn(CategoryPeer::ID);
         $this->hydrateWithProducer = true;
      }
      else 
      {
         $this->hydrateWithProducer = false;
      }

      if (isset($params['limit']))
      {
         $c->setLimit($params['limit']);
      }

      CategoryPeer::setHydrateMethod(array($this, 'hydrateCategories'));

      $ret = CategoryPeer::doSelectWithI18n($c);

      CategoryPeer::setHydrateMethod(null);

      $this->hydrateWithProducer = false;

      return $ret;
   }

   public function hydrateSelected(ResultSet $rs)
   {
      $results = array();

      $rs->setFetchmode(ResultSet::FETCHMODE_ASSOC);

      while ($rs->next())
      {
         $row = $rs->getRow();

         $results[$row['ID']] = $row['ID'];
      }

      return $results;
   }

   public function hydrateCategories(ResultSet $rs)
   {
      $results = array();

      $rs->setFetchmode(ResultSet::FETCHMODE_ASSOC);

      sfLoader::loadHelpers(array('Helper', 'stUrl'));

      $url = $this->categoryUrlParameters;

      if ($this->getRequest()->hasParameter('producer') && $this->hydrateWithProducer)
      {
         $url['producer'] = $this->getRequest()->getParameter('producer');
      }

      while ($rs->next())
      {
         $row = $rs->getRow();
         $product_count = $this->countProduct($row['LFT'], $row['RGT'], $row['SCOPE']);
         if ($product_count > 0)
         {
            $image = $row['OPT_IMAGE'];

            if(!$image || !is_file(sfConfig::get('sf_web_dir').'/'.$image))
            {
               $image = CategoryPeer::generateImage($row['ID'], $row['SCOPE'], $row['LFT'], $row['RGT']);
            }

            $url['url'] = $row['URL'] ? $row['URL'] : $row['OPT_URL'];

            $results[] = array(
               'id' => $row['ID'],
               'scope' => $row['SCOPE'],
               'name' => $row['NAME'] ? $row['NAME'] : $row['OPT_NAME'],
               'url' => st_url_for($url),
               'image' => $image,
               'lft' => $row['LFT'],
               'rgt' => $row['RGT'],
               'depth' => $row['DEPTH'],
               'is_root' => $row['PARENT_ID'] === null,
               'parent_id' => $row['PARENT_ID'],
               'depth' => $row['DEPTH'],
               'has_children' => $row['RGT'] - $row['LFT'] > 1,
               'product_count' => $product_count
            );
         }
      }

      return $results;
   }

   protected function countProduct($lft, $rgt, $scope)
   {
      if (isset($this->countProducts) && !$this->countProducts || !$this->categoryConfig->get('hide_categories_without_products'))
      {
         return true;
      }

      if ($lft > 1)
      {
         $this->productCountCriteria->add(CategoryPeer::LFT, sprintf('%s BETWEEN %s AND %s', CategoryPeer::LFT, $lft, $rgt), Criteria::CUSTOM);
      }
      else 
      {
         $this->productCountCriteria->remove(CategoryPeer::LFT);
      }

      $this->productCountCriteria->add(CategoryPeer::SCOPE, $scope);

      $rs = ProductPeer::doSelectRs($this->productCountCriteria);

      return $rs->next() ? $rs->getInt(1) : 0;
   }

   protected function checkForHidden()
   {
      if (null === $this->check)
      {
         if (stTheme::getInstance($this->getContext())->getVersion() < 7)
         {
            $this->check = true;
         }
         else
         {
            $count = $this->cache->cacheCall(array('stCategoryTreeComponents', 'countVisibleRoots'));            
            $this->check = !($count == 0 && stConfig::getInstance('appCategoryHorizontalBackend')->get('menu_on'));            
         }
      }

      return $this->check;
   }

   public static function countVisibleRoots()
   {
      $c = new Criteria();
      $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);
      $c->add(CategoryPeer::IS_HIDDEN, false);
      return CategoryPeer::doCount($c);
   }
}
