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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 17600 2012-03-30 11:03:40Z krzysiek $
 */

/** 
 * Klasa zawierajaca akcje dla modulu discount
 *
 * @package     stDiscountPlugin
 * @subpackage  actions
 */
class stDiscountBackendActions extends autostDiscountBackendActions
{
   public function executeAjaxProductsToken()
   {
      $query = $this->getRequestParameter('q');

      $id = $this->getRequestParameter('id');

      $duplicates = explode(',', $this->getRequestParameter('d'));

      if ($id)
      {
         $duplicates[] = $id;
      }

      $c = new Criteria();

      $criterion = $c->getNewCriterion(ProductPeer::CODE, $query);

      $criterion->addOr($c->getNewCriterion(ProductPeer::OPT_NAME, '%'.$query.'%', Criteria::LIKE));

      if ($duplicates)
      {
         $c->add(ProductPeer::ID, $duplicates, Criteria::NOT_IN);
      }
      
      $c->add(ProductPeer::POINTS_ONLY, false);
      $c->add(ProductPeer::IS_GIFT, 0);

      $c->add($criterion);

      $c->setLimit(100);

      $tokens = ProductPeer::doSelectTokens($c);

      return $this->renderJson($tokens);
   }  
       
   public function executeCouponCodeList()
   {

      $context = sfContext::getInstance();

      if (!stConfig::getInstance($this->getContext(), 'stDiscountBackend')->get('coupon_code'))
      {
         $notice = $context->getI18N()->__('Aby korzystać z kodów rabatowych w sklepie musisz je włączyć w konfiguracji');
         $this->setFlash('notice', $notice);

         return $this->redirect('stDiscountBackend/config');
      }
      
      return parent::executeCouponCodeList();
   }

   public function executeList()
   {
      parent::executeList();
      if ($this->hasRequestParameter('id') && $this->hasRequestParameter('pos'))
      {
         $this->fixPriority();
         $discount = DiscountPeer::retrieveByPk($this->getRequestParameter('id'));
         if (is_object($discount))
         {
            if ($this->getRequestParameter('pos') == 1)
               $discount->moveUp();
            if ($this->getRequestParameter('pos') == -1)
               $discount->moveDown();
            $discount->save();
         }
         return $this->redirect('stDiscountBackend/list');
      }
   }

   protected function saveDiscount($discount)
   {
      $isNew = $discount->isNew();

      parent::saveDiscount($discount);

      $categories = stJQueryToolsHelper::parseTokensFromRequest($this->getRequestParameter('categories'));

      if (!$isNew)
      {
         $c = new Criteria();

         $c->add(DiscountHasCategoryPeer::DISCOUNT_ID, $discount->getId());

         DiscountHasCategoryPeer::doDelete($c);
      }

      foreach ($categories as $token)
      {
         $ghc = new DiscountHasCategory();
         $ghc->setDiscount($discount);
         $ghc->setCategoryId($token['id']);
         $ghc->save();
      }

      $producers = stJQueryToolsHelper::parseTokensFromRequest($this->getRequestParameter('producers'));

      if (!$isNew)
      {
         $c = new Criteria();

         $c->add(DiscountHasProducerPeer::DISCOUNT_ID, $discount->getId());

         DiscountHasProducerPeer::doDelete($c);
      }

      foreach ($producers as $token)
      {
         $ghp = new DiscountHasProducer();
         $ghp->setDiscount($discount);
         $ghp->setProducerId($token['id']);
         $ghp->save();
      }
   }

   protected function saveCouponCodeDiscountCouponCode($discount_coupon_code)
   {
      $isNew = $discount_coupon_code->isNew();

      parent::saveCouponCodeDiscountCouponCode($discount_coupon_code);

      $categories = stJQueryToolsHelper::parseTokensFromRequest($this->getRequestParameter('categories'));

      if (!$isNew)
      {
         $c = new Criteria();

         $c->add(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, $discount_coupon_code->getId());

         DiscountCouponCodeHasCategoryPeer::doDelete($c);
      }

      foreach ($categories as $token)
      {

         $ghc = new DiscountCouponCodeHasCategory();
         $ghc->setDiscountCouponCode($discount_coupon_code);
         $ghc->setCategoryId($token['id']);
         $ghc->save();
      }

      $producers = stJQueryToolsHelper::parseTokensFromRequest($this->getRequestParameter('producers'));

      if (!$isNew)
      {
         $c = new Criteria();

         $c->add(DiscountCouponCodeHasProducerPeer::DISCOUNT_COUPON_CODE_ID, $discount_coupon_code->getId());

         DiscountCouponCodeHasProducerPeer::doDelete($c);
      }

      foreach ($producers as $token)
      {
         $ghp = new DiscountCouponCodeHasProducer();
         $ghp->setDiscountCouponCode($discount_coupon_code);
         $ghp->setProducerId($token['id']);
         $ghp->save();
      }
   }

   protected function addSortCriteria($c)
   {
      parent::addSortCriteria($c);

      $c->addDescendingOrderByColumn(DiscountPeer::PRIORITY);
   }

   protected function addCouponCodeFiltersCriteria($c)
   {
      parent::addCouponCodeFiltersCriteria($c);

      if (isset($this->filters['generated_for']) && $this->filters['generated_for'] !== '')
      {
         $cc = $c->getNewCriterion(OrderPeer::NUMBER, $this->filters['generated_for'].'%', Criteria::LIKE);

         $cc->addOr($c->getNewCriterion(OrderPeer::OPT_CLIENT_EMAIL, '%'.$this->filters['generated_for'].'%', Criteria::LIKE));

         $c->add($cc);
      }      
   }

   protected function addFiltersCriteria($c)
   {
      parent::addFiltersCriteria($c);

      if (isset($this->filters['type_label']) && $this->filters['type_label'] !== '')
      {
         $c->add(DiscountPeer::TYPE, $this->filters['type_label']);
      }      
   }

   protected function addUserFiltersCriteria($c)
   {
      parent::addUserFiltersCriteria($c);

      $group = sfGuardGroupPeer::retrieveByName('user');

      $c->addJoin(sfGuardUserPeer::ID, sfGuardUserGroupPeer::USER_ID);
      $c->add(sfGuardUserGroupPeer::GROUP_ID, $group->getId());

      if (isset($this->filters['filter_full_name']) && !empty($this->filters['filter_full_name'])) 
      {
         $this->addJoinUserDataCriteria($c);
         $c->add(UserDataPeer::IS_BILLING, 1);
         $c->add(UserDataPeer::FULL_NAME, '%' . $this->filters['filter_full_name'] . '%', Criteria::LIKE);

      }

      if (isset($this->filters['filter_company']) && !empty($this->filters['filter_company'])) 
      {
         $this->addJoinUserDataCriteria($c);
         $c->add(UserDataPeer::IS_BILLING, 1);

         $c->add(UserDataPeer::COMPANY, '%' . $this->filters['filter_company'] . '%', Criteria::LIKE);
      }
   }

   protected function addJoinUserDataCriteria(Criteria $c)
   {
       if (!array_key_exists(sfGuardUserPeer::ID.UserDataPeer::SF_GUARD_USER_ID, $c->getJoins()))
       {
           $c -> addJoin(sfGuardUserPeer::ID, UserDataPeer::SF_GUARD_USER_ID, Criteria::LEFT_JOIN);

           if (!in_array(sfGuardUserPeer::ID, $c->getGroupByColumns()))
           {
               $c->addGroupByColumn(sfGuardUserPeer::ID);
           }
       }       
   }

   protected function addProductFiltersCriteria($c)
   {
      parent::addProductFiltersCriteria($c);

      if (isset($this->filters['list_image']) && $this->filters['list_image'] !== '')
      {
         $c->add(ProductPeer::OPT_IMAGE, null, $this->filters['list_image'] ? Criteria::ISNOTNULL : Criteria::ISNULL);
      }

      if ($this->related_object && $this->related_object->getType() == 'S')
      {
         $c->add(ProductPeer::ID, $this->related_object->getProductId(), Criteria::NOT_EQUAL);
         $c->add(ProductPeer::TAX_ID, $this->related_object->getProduct()->getTaxId());
      }
      
      $c->add(ProductPeer::POINTS_ONLY, false);
      $c->add(ProductPeer::IS_GIFT, 0);
   }

   public function executeRangeList()
   {
      parent::executeRangeList();
      $this->discountCount = DiscountPeer::doCount(new Criteria());
      if (!$this->discountCount)
      {
         $this->setFlash('notice', "Przed ustawieniem progów rabatowych, proszę utworzyć co najmniej jeden rabat.", false);
      }
   }

   public function fixPriority()
   {
      $con = Propel::getConnection();
      $query = "SELECT COUNT(`id`) as cnt FROM `st_discount` GROUP BY `priority` ORDER BY cnt DESC LIMIT 1";
      $stmt = $con->prepareStatement($query);
      $resultset = $stmt->executeQuery();
      if ($resultset->next() && $resultset->getInt('cnt') > 1)
      {
         $c = new Criteria();
         $c->addAscendingOrderByColumn(DiscountPeer::PRIORITY);
         $discounts = DiscountPeer::doSelect($c);
         $i = 1;
         foreach ($discounts as $discount)
         {
            $discount->setPriority($i);
            $discount->save();
            $i++;
         }
      }
   }    


    protected function updateDiscountFromRequest()
    {
        parent::updateDiscountFromRequest();

        $discount = $this->getRequestParameter('discount');

        if (isset($discount['price_type']))
        {
            $this->discount->setPriceType($discount['price_type']);
        }


        $product_set_discount = $this->getRequestParameter('product_set_discount');
        
        if ($product_set_discount !== null)
        {
            $tokens = stJQueryToolsHelper::parseTokensFromRequest($product_set_discount);

            if ($tokens)
            {
                $this->discount->setProductId($tokens[0]['id']);
            }
        }
    }

    public function getDiscountOrCreate($id = "id")
    {
        if (!isset($this->discount))
        {
            $this->discount = parent::getDiscountOrCreate($id);
        }

        return $this->discount;
    }

    public function validateEdit()
    {
        $ok = true;

        $discount = $this->getDiscountOrCreate();

        $request = $this->getRequest();

        if ($request->getMethod() == sfRequest::POST)
        {
            $data = $request->getParameter('discount');

            if ($data['price_type'] == '%')
            {
                $validator = new sfNumberValidator();

                $validator->initialize($this->getContext(), array(
                    'nan_error' => 'Proszę podać wartość liczbową',
                    'min' => 1,
                    'min_error' => 'Minimalna wartość rabatu to 1%',
                    'max' => 99,
                    'max_error' => 'Maksymalna wartość rabatu to 99%',
                ));

                if (!$validator->execute($data['value'], $error))
                {
                    $request->setError('discount{value}', $error);
                    $ok = false;
                }
            }

            if ($data['type'] == 'O' && $data['conditions'])
            {

                $ok = false;

                foreach ($data['conditions'] as $key => $value)
                {
                    if ($key == 'operator') continue;

                    if (floatval($value) > 0)
                    {

                        $ok = true;
                        break;
                    }
                }   

                if (!$ok)
                {
                    $request->setError('discount{conditions}', 'Przynajmniej jedna wartość musi być większa od 0');
                }
            }

            if ($data['type'] == 'S') 
            {
                $product_set_discount = $request->getParameter('product_set_discount');

                $productIds = stJQueryToolsHelper::parseTokensFromRequest($product_set_discount, true);

                if ($product_set_discount !== null && !$productIds)
                {
                    $request->setError('discount{product}', 'Musisz dodać produkt główny');
                    $ok = false;
                } 
                else
                {
                    $productIds = stJQueryToolsHelper::parseTokensFromRequest($product_set_discount, true);
                    $c = new Criteria();
                    $c->add(DiscountHasProductPeer::PRODUCT_ID, $productIds[0]);
    
                    if ($discount->countDiscountHasProducts($c) > 0) 
                    {
                        $request->setError('discount{product}', 'Wybrany produkt już jest przypisany do tej grupy rabatowej');
                        $ok = false;
                    }
                }

            }
        }
        elseif ($request->getParameter('id'))
        {        
            if ($discount->getType() == 'P' && !$discount->getAllProducts() && !$discount->countDiscountHasProducts() && !$discount->countDiscountHasCategorys() && !$discount->countDiscountHasProducers())
            {
                $request->setError('{discount_assign_products}', 'Musisz dodać przynajmniej jeden produkt lub kategorie lub producenta lub zaznaczyć opcję <b>Dla Wszystkich produktów</b>');
            }   
            elseif ($discount->getType() == 'S'  && !$discount->getAllProducts() && !$discount->countDiscountHasProducts())  
            {
                $request->setError('{discount_assign_products}', 'Musisz dodać przynajmniej jeden produkt'); 
            }            
            

            if (!$discount->getAllClients() && !$discount->getAllowAnonymousClients() && !$discount->countUserHasDiscounts() && !$discount->getAutoActive())
            {
                $request->setError('{discount_assign_clients}', 'Musisz dodać przynajmniej jednego klienta lub zaznaczyć opcję <b>Dla Wszystkich klientów</b> lub <b>Dla klientów niezalogowanych</b>');
            }                           
        }

        return $ok;
    }

    protected function getLabels()
    {
        $labels = parent::getLabels();

        $labels['{discount_assign_products}'] = 'Przypisz produkty';
        $labels['{discount_assign_clients}'] = 'Przypisz klientów';

        return $labels;
    }

    public function validateConfig()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $config = $this->getRequest()->getParameter('config');
            
            $i18n = $this->getContext()->getI18N(); 

            if (!$config['code_format'])
            {
                $this->getRequest()->setError('config{code_format}', $i18n->__('Podaj format kodu', null, 'stGiftCardBackend'));
            }
            elseif (strpos($config['code_format'], '@') === false)
            {
                $this->getRequest()->setError('config{code_format}', $i18n->__('Parametr "@" jest wymagany', null, 'stGiftCardBackend'));
            }
        }

        return !$this->getRequest()->hasErrors();
    }    
}
