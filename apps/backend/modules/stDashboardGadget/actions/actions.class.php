<?php
class stDashboardGadgetActions extends stGadgetActions 
{
   public function executeApplicationShortcuts() 
   {
      $applications = array();
      
      $routing = sfRouting::getInstance();
      
      foreach (sfConfig::get('app_default_desktop') as $name) 
      {
         $applications[] = new stBackendDesktopModule($routing, $name);
      }
      
      $this->applications = $applications;
      
      if (!sfConfig::get('sf_debug'))
      {
         $this->setResponseMaxAge(60*60*24*384);
      }
   }

   public function executeReviewGadget()
   {
      $request = $this->getRequest();

      if ($request->getMethod() == sfRequest::POST)
      {
         $id = $request->getParameter('review_id');

         $type = $request->getParameter('type');

         $review = ReviewPeer::retrieveByPK($id);

         if ($review) 
         {
            if ($type == 'accept')
            {
               $review->setAgreement(true);
            }
            elseif ($type == 'skip')
            {
               $review->setSkipped(true);
            }

            $review->save();

            $this->getGadget()->refresh();
         }         

         return sfView::HEADER_ONLY;
      }

      $c = new Criteria();

      $c->add(ReviewPeer::AGREEMENT, 0);

      $c->add(ReviewPeer::SKIPPED, 0);

      $c->addDescendingOrderByColumn(ReviewPeer::ID);

      $c->setLimit(5);
      
      $this->reviews = ReviewPeer::doSelect($c);
   }

   public function executeSoteNews()
   {

      $lang = $this->getUser()->getCulture();

      if ($lang == 'pl_PL') {

         $url = 'https://www.sote.pl/smNewsFrontend/index';

         $this->sote = 'https://www.sote.pl/';

       } else {

         $url = 'https://www.soteshop.com/smNewsFrontend/index';

         $this->sote = 'https://www.soteshop.com/';

       }
      
      if(ini_get('allow_url_fopen')){

         $contents = file_get_contents($url);

      } else {

         $contents = $this->getCurlContent($url);
      }
      
      $contents = utf8_encode($contents);
      
      $results = json_decode($contents);

      $this->results = $results;

   }

   public function executeSoteHelp()
   {
      $lang = $this->getUser()->getCulture();
   }

   public function executeLastRegisteredClients()
   {
      $request = $this->getRequest();

      stAuthUsersListener::checkAccessCredentials($this, $request, 'stUser');      

      list($page, $max_per_page) = $this->processPagerParameters($request); 

      $this->filters = $this->processFilters($request);

      $group = sfGuardGroupPeer::retrieveByName('user');      

      $c = new Criteria();

      $c->addJoin(sfGuardUserPeer::ID, sfGuardUserGroupPeer::USER_ID);    

      $c->add(sfGuardUserGroupPeer::GROUP_ID, $group->getId());         

      $c->add(sfGuardUserPeer::PASSWORD, sprintf("%s <> SHA1(CONCAT(%s, '%s'))", sfGuardUserPeer::PASSWORD, sfGuardUserPeer::SALT, 'anonymous'), Criteria::CUSTOM);

      $c->addDescendingOrderByColumn(sfGuardUserPeer::CREATED_AT);

      $this->addUserFilterCriteria($c);

      $this->pager = $this->createUserPager($page, $max_per_page);

      $this->pager->setCriteria($c);

      $this->pager->init();

      if ($this->pager->getNbResults() > 0)
      {
         $ids = array();

         foreach ($this->pager->getResults() as $user)
         {
            $ids[] = $user->getId();
         }

         $c = new Criteria();

         $c->add(UserDataPeer::SF_GUARD_USER_ID, $ids, Criteria::IN);

         $c->add(UserDataPeer::IS_DEFAULT, true);

         $c->add(UserDataPeer::IS_BILLING, true);

         UserDataPeer::setHydrateMethod(array($this, 'userDataHydrate'));

         $this->user_data = UserDataPeer::doSelect($c);
      }

      $this->view = $this->getGadgetViewType();
   }

   public function executeLastOrders()
   {      
      $request = $this->getRequest();

      stAuthUsersListener::checkAccessCredentials($this, $request, 'stOrder');      

      list($page, $max_per_page) = $this->processPagerParameters($request); 

      $this->filters = $this->processFilters($request);

      $c = new Criteria();   

      $c->addDescendingOrderByColumn(OrderPeer::CREATED_AT);

      $this->addOrderFilterCriteria($c);

      $this->total_amount = OrderPeer::doTotalAmountSummary($c);      
      
      $this->pager = $this->createOrderPager($page, $max_per_page);

      $this->pager->setCriteria($c);

      $this->pager->init();

      $this->view = $this->getGadgetViewType();
   }

   public function executeRecentlyOrderedProducts()
   {      
      $request = $this->getRequest();

      stAuthUsersListener::checkAccessCredentials($this, $request, 'stProduct');
      stAuthUsersListener::checkAccessCredentials($this, $request, 'stOrder');      

      list($page, $max_per_page) = $this->processPagerParameters($request);  

      $this->filters = $this->processFilters($request);

      $c = new Criteria();

      $c->addSelectColumn(ProductPeer::ID);

      $c->addSelectColumn(ProductPeer::CODE);

      $c->addSelectColumn(ProductPeer::OPT_IMAGE);

      $c->addSelectColumn(ProductPeer::OPT_NAME);

      $c->addSelectColumn(ProductPeer::OPT_UOM);

      $c->addAsColumn('_ordered', 'SUM('.OrderProductPeer::QUANTITY.')');

      $c->addJoin(ProductPeer::ID, OrderProductPeer::PRODUCT_ID);

      $c->addJoin(OrderProductPeer::ORDER_ID, OrderPeer::ID);

      $this->addOrderFilterCriteria($c);

      $c->addDescendingOrderByColumn('_ordered');

      $c->addGroupByColumn(OrderProductPeer::PRODUCT_ID);

      ProductPeer::setHydrateMethod(array($this, 'orderProductHydrate'));

      $this->pager = $this->createProductPager($page, $max_per_page);

      $this->pager->setCriteria($c);

      $this->pager->init();
   }

   public function userDataHydrate($rs)
   {
      $results = array();

      while($rs->next())
      {
         $obj = new UserData();

         $obj->hydrate($rs);

         $results[$obj->getSfGuardUserId()] = $obj;
      }

      return $results;
   }

   public function orderProductHydrate($rs)
   {
      $results = array();

      $culture = $this->getUser()->getCulture();

      while($rs->next())
      {
         list($id, $code, $image, $name, $uom, $quantity) = $rs->getRow();

         $obj = new Product();

         $obj->setId($id);

         $obj->setCode($code);

         $obj->setOptImage($image);

         $obj->setOptName($name);

         $obj->setOptUom($uom);

         $obj->setCulture($culture);

         $obj->_order_quantity = $quantity;

         $results[] = $obj;
      }

      return $results;
   }

   protected function addUserFilterCriteria(Criteria $c)
   {
      $from_date = $this->computeFromDate();

      $c->add(sfGuardUserPeer::CREATED_AT, $from_date, Criteria::GREATER_EQUAL);      

      if (isset($this->filters['is_confirmed']) && $this->filters['is_confirmed'] !== "")
      {
         $c->add(sfGuardUserPeer::IS_CONFIRM, $this->filters['is_confirmed']);
      }
   }

   protected function addOrderFilterCriteria(Criteria $c)
   {
      $from_date = $this->computeFromDate();

      $c->add(OrderPeer::CREATED_AT, $from_date, Criteria::GREATER_EQUAL);

      OrderPeer::addStatusFilterCriteria($c, $this->filters);

      if (isset($this->filters['is_confirmed']) && $this->filters['is_confirmed'] !== "")
      {
         $c->add(OrderPeer::IS_CONFIRMED, $this->filters['is_confirmed']);
      }

      if (isset($this->filters['is_paid']) && $this->filters['is_paid'] !== "")
      {
         $c->add(OrderPeer::OPT_IS_PAYED, $this->filters['is_paid']);
      }
	  
	  $c = $this->getDispatcher()->filter(new sfEvent($this, 'stDashboardGagdetActions.addOrderFilterCriteria'), $c);            
   }

   protected function createUserPager($page, $max_per_page = 20)
   {
      $pager = new stPropelPager('sfGuardUser', $max_per_page);

      $pager->setPage($page);

      $pager->setPeerMethod('doSelect'); 

      $pager->setPeerCountMethod('doCount');
      
      return $pager;       
   }   

   protected function createOrderPager($page, $max_per_page = 20)
   {
      $pager = new stPropelPager('Order', $max_per_page);

      $pager->setPage($page);

      $pager->setPeerMethod('doSelectJoinOrderCurrency'); 

      $pager->setPeerCountMethod('doCount');
      
      return $pager;       
   }   

   protected function createProductPager($page, $max_per_page = 20)
   {
      $pager = new stPropelPager('Product', $max_per_page);

      $pager->setPage($page);

      $pager->setPeerMethod('doSelect');

      $pager->setPeerCountMethod('doCount');
      
      return $pager;       
   } 

   protected function processFilters(sfRequest $request)
   {
      $config = $this->getGadget()->getGadgetConfiguration();

      if ($request->getMethod() == sfRequest::POST)
      {
         $filters = $request->getParameter('filters');

         $config->setParameter('filters', $filters);

         $config->save();         
      }
      else
      {
         $filters = $config->getParameter('filters', array());
      }

      return $filters;
   } 

   protected function processPagerParameters(sfRequest $request)
   {
      $page = $request->getParameter('page', 1);

      $config = $this->getGadget()->getGadgetConfiguration(); 

      if ($request->hasParameter('max_per_page'))
      {
         $max_per_page = $request->getParameter('max_per_page'); 

         $config->setParameter('pager.max_per_page', $max_per_page);

         $config->save();            
      } 
      else
      {
         $max_per_page = $config->getParameter('pager.max_per_page', 10);
      }

      return array($page, $max_per_page);        
   } 

   protected function computeFromDate()
   {
      if (!isset($this->filters['from_date']))
      {
         $this->filters['from_date'] = 86400;
      }

      switch ($this->filters['from_date']) 
      {
         case 'day':
            $from_date = date('Y-m-d H:i:s', time() - 86400);
         break;

         case 'week':
            $from_date = date('Y-m-d H:i:s', time() - 604800);
         break;

         case 'month':
           $from_date = date('Y-m-d H:i:s', time() -  2678400);
         break;

         case 'last_login':
            $from_date = $this->getUser()->getLastLogin();
         break;
         
         default:
            $from_date = date('Y-m-d H:i:s', time() - 86400);
         break;
      }

      return $from_date;
   }

   function getCurlContent($url) {

    if (!function_exists('curl_init')){ 
      
        die('CURL is not installed!');
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $output = curl_exec($ch);
    
    curl_close($ch);
    
    return $output;
    }
}