<?php

class stDiscountFrontendComponents extends sfComponents
{

   public function executeCouponCode()
   {
      $config = stConfig::getInstance($this->getContext(), 'stDiscountBackend');

      if (!$config->get('coupon_code'))
      {
         return sfView::NONE;
      }
      
      $this->smarty = new stSmarty('stDiscountFrontend');

      $this->smarty->assign('form', array(
          'code' => $this->getRequestParameter('discount[coupon_code]'),
          'action' => $this->getController()->genUrl(array('module' => 'stDiscountFrontend', 'action' => 'activateCouponCode')),
          'error' => $this->getFlash('discount_coupon_code_error'),
          'return_url' => $this->return_url
      ));

      $coupon_code = stBasket::getInstance($this->getUser())->getCouponCode();

      if ($coupon_code)
      {
         $this->smarty->assign('coupon_code', array(
             'code' => $coupon_code->getCode(),
             'discount' => $coupon_code->getDiscount(),
             'instance' => $coupon_code,
             'remove_url' => $this->getController()->genUrl('stDiscountFrontend/deactivateCouponCode?return_url='.rawurlencode($this->return_url)),
         ));
      }
   }

   public function executeDiscountProductSetList()
   {
      if (!stLicense::hasSupport() && !stLicense::isOpen())
      {
         return sfView::NONE;
      }

      $user = $this->getUser()->isAuthenticated() && $this->getUser()->getGuardUser() ? $this->getUser()->getGuardUser() : null;

      if (stDiscount::isDisabledForWholesale($user))
      {
         return sfView::NONE;
      }

      $discounts = DiscountPeer::doSelectSetDiscounts($this->product, $user);

      if (!$discounts)
      {
         return sfView::NONE;
      }

      $visible = false;

      foreach ($discounts as $discount)
      {
         if ($discount->getProducts())
         {
            $visible = true;
            break;
         }
      }

      if (!$visible)
      {
         return sfView::NONE;
      }

      sfLoader::loadHelpers(array('Helper', 'stProductPrice', 'I18N'));

      $smarty = new stSmarty('stDiscountFrontend');
      $smarty->register_function('st_product_image_tag', 'st_product_smarty_image_tag');
      $smarty->register_function('st_product_price_tag', 'st_product_smarty_price_tag');
      $smarty->register_function('st_discount_basket_add_button', array($this, 'smartyDiscounBasketAddButton'));
      $smarty->assign('discounts', $discounts);

      return $smarty;
   }

   public function smartyDiscounBasketAddButton($params)
   {
      sfLoader::loadHelpers('Helper', 'stBasket');

      $discount = $params['discount'];

      $options = stNewProductOptions::getSelectedOptions($discount->getProduct());

      $i18n = $this->getContext()->getI18N();
   
      return st_basket_add_button('st_discount_set_'.$discount->getId(), $discount->getProduct(), array('options' => $options, 'product_set_discount' => $discount->getId(), 'important' => true, 'label' => $i18n->__('do koszyka')));
   }
}

?>
