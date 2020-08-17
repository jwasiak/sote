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
 * @version     $Id: actions.class.php 10 2009-08-24 09:32:18Z michal $
 */

/**
 * Klasa zawierajaca akcje dla modulu discount
 *
 * @package     stDiscountPlugin
 * @subpackage  actions
 */
class stDiscountFrontendActions extends stActions
{
   public function executeDeactivateCouponCode()
   {
      $return_url = $this->getRequestParameter('return_url');
      
      $basket = stBasket::getInstance($this->getUser());

      $basket->setCouponCode(null);  
      
      $basket->refresh();
      
      $basket->save();
      
      return $this->redirect(rawurldecode($return_url));
   }   
   
   public function executeActivateCouponCode()
   {
      $discount = $this->getRequestParameter('discount');
      
      return $this->redirect($discount['return_url']);
   }
   
   public function validateActivateCouponCode()
   {
      $ok = true;
      
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $discount = $this->getRequestParameter('discount');

         if (empty($discount['coupon_code']))
         {
            $this->setFlash('discount_coupon_code_error', 'Wprowadź kod rabatowy');

            return false;
         }

         $c = new Criteria();
         
         $c->add(DiscountCouponCodePeer::CODE, $discount['coupon_code']);
         
         $coupon_code = DiscountCouponCodePeer::doSelectOne($c);
         
         if (!$coupon_code)
         {
            $this->setFlash('discount_coupon_code_error', 'Podany kod nie istnieje');
            
            $ok = false;
         }
         elseif (!$coupon_code->isValid() || stDiscount::isDisabledForWholesale($this->getUser()->getGuardUser()))
         {
            $this->setFlash('discount_coupon_code_error', 'Podany kod jest nieważny');
            
            $ok = false;
         }
         else
         {
            $basket = $this->getUser()->getBasket();

            $basket->get()->setDiscountCouponCode($coupon_code);

            $items = $basket->getItems();

            foreach ($items as $item)
            {               
               if (null === $item->getProductId() || !stDiscount::isValidDiscountCouponCodeProductIds($coupon_code, $item->getProduct()))
               {
                  continue;
               }

               $product = $item->getProduct();

               $productSetDiscount = $item->getProductSetDiscount();               
               $item->setDiscount($productSetDiscount ? array('value' => $productSetDiscount->getValue(), 'type' => $productSetDiscount->getPriceType()) : $product->getDiscount());

               $discount = stDiscount::calculateCouponCodeDiscount($item, $coupon_code);
               
               $item->setDiscount(array('value' => $discount, 'type' => '%'));
            }

            $basket->save();
         }
      }
      
      return $ok;
   }
   
   public function handleErrorActivateCouponCode()
   {
      return $this->redirect($this->getRequestParameter('discount[return_url]'));
   }
   
   public function executeDiscountInfo()
   {
      $this->smarty = new stSmarty('stDiscountFrontend');
      $user = sfContext::getInstance()->getUser()->getGuardUser();
      $this->all_discounts = array();

      if (!stDiscount::isDisabledForWholesale($user))
      {
         sfLoader::loadHelpers(array('Helper', 'Tag', 'Url', 'stUrl'));
  
         if (is_object($user))
         {
            $c = new Criteria();
            $c->add(DiscountUserPeer::SF_GUARD_USER_ID, $user->getId());
            $userDiscount = DiscountUserPeer::doSelectOne($c);

            if (is_object($userDiscount) && $userDiscount->getDiscount())
            {
               $this->all_discounts[] = array('id' => 0, 'name' => $this->getContext()->getI18n()->__('Rabat ogólny'), 'value' => sprintf("%2.2f", $userDiscount->getDiscount()), 'link_to' => '-');
            }
 
            $discounts = DiscountPeer::doSelectActiveCached();

            if ($discounts && isset($discounts['P']))
            {
                $uids = DiscountPeer::doSelectIdsByUser($user);

                foreach ($discounts['P'] as $discount)
                {
                    if (($discount->getAllClients() || $uids && isset($uids[$discount->getId()])) && ($discount->getAllProducts() || $discount->countDiscountHasProducts() > 0))
                    {
                        $this->all_discounts[] = array(
                            'id' => $discount->getId(),
                            'name' => $discount->getName(),
                            'value' => $discount->getValue(),
                            'type' => $discount->getPriceType(),
                            'link_to' => st_link_to(
                                $this->getContext()->getI18n()->__('Lista produktów'), 'stDiscountFrontend/productList?discountId='.$discount->getId()
                            )
                        );
                    }
                }
            }
         }
      }
   }

   public function executeProductList()
   {
      $this->selectDiscount = DiscountPeer::retrieveByPk($this->getRequestParameter('discountId'));
      if (!is_object($this->selectDiscount) || !$this->selectDiscount->getActive())
         $this->forward404();

      $this->smarty = new stSmarty($this->getModuleName());
      $this->productSmarty = new stSmarty('stProduct');
      $this->productSmarty->register_function('st_product_image_tag', 'st_product_smarty_image_tag');
      $this->configProduct = stConfig::getInstance(sfContext::getInstance(), 'stProduct');

      $c = new Criteria();
      if (!$this->selectDiscount->getAllProducts())
      {
         $c->addJoin(ProductPeer::ID, DiscountHasProductPeer::PRODUCT_ID);
         $c->add(DiscountHasProductPeer::DISCOUNT_ID, $this->getRequestParameter('discountId'));
      }

      $c->add(ProductPeer::ACTIVE, 1);
      if ($this->configProduct->get('show_without_price'))
      {
         $c->add(ProductPeer::PRICE, 0, Criteria::GREATER_THAN);
      }
      stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stProductActions.postAddProductCriteria', array('criteria' => $c)));

      $this->pager = new sfPropelPager('Product');
      $this->pager->setCriteria($c);
      $this->pager->setPeerMethod('doSelect');
      $this->pager->setPage($this->getRequestParameter('page', 1));

      if (stTheme::getInstance(sfContext::getInstance())->getVersion() < 7)
      {
        $this->pager->setMaxPerPage($this->configProduct->get('short_list'));
      }else{
        $this->pager->setMaxPerPage($this->configProduct->get('long_list'));
      }

      
      $this->pager->init();

      $this->for_link = array(
          'discountId' => $this->getRequestParameter('discountId'),
          'type' => $this->type_list_url,
          'sort_by' => $this->sort_by,
          'sort_order' => $this->sort_order,
          'page' => $this->pager->getPage(),
          'producer_filter' => $this->producer_filter
      );

      $this->list_type = $this->getViewTypes('view_names');

      $this->config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
      $this->config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());      
   }

   protected function getViewTypes($type = null)
   {
      $types = array(
          'label_names' => array(
              'long' => 'Pełna lista',
              'short' => 'Skrócona lista',
              'other' => 'Lista alternatywna',
          ),
          'view_names' => array(
              'long' => 'listLongProduct',
              'short' => 'listShortProduct',
              'other' => 'listOther',
          ),
      );

      return $type ? $types[$type] : $types;
   }

}
