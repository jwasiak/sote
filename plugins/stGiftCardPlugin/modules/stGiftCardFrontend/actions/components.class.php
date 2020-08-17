<?php

class stGiftCardFrontendComponents extends sfComponents
{

   public function executeShow()
   {
      $config = stConfig::getInstance('stGiftCardBackend');

      if (!$config->get('enabled'))
      {
         return sfView::NONE;
      }

      $this->smarty = new stSmarty('stGiftCardFrontend');

      $i18n = $this->getContext()->getI18N();

      $giftCards = stGiftCardPlugin::get();

      $error = null;

      if ($giftCards)
      { 
         $controller = $this->getController();
         
         $results = array();
         
         foreach ($giftCards as $index => $gift_card)
         {
            $results[$index] = array(
                'instance' => $gift_card, 
                'code' => $gift_card->getCode(), 
                'amount' => $gift_card->getAmount(true),
                'remove_url' => $controller->genUrl('@stGiftCardRemove?id='.$gift_card->getId().'&return_url='.rawurlencode($this->return_url))
            );
         }

         foreach ($giftCards as $giftCard)
         {
            if (!stGiftCardPlugin::hasValidBasketProducts($giftCard))
            {               
               $error = $i18n->__('Bon nie może być zrealizowany z produktami znajdującymi się w koszyku');
            }
            elseif (!$giftCard->isValidOrderAmount($this->getUser()->getBasket()->getTotalAmount(true, true)))
            {
               sfLoader::loadHelpers(array('Helper', 'stCurrency'));
               $this->setFlash('st_gift_card_error', $i18n->__('Musisz złożyć zamówienie za minimum %%amount%%', array(
                  '%%amount%%' => st_currency_format($giftCard->getMinOrderAmount(), array('digits' => 0))
               ), 'stGiftCardFrontend'));
            }
         }         
         
         $this->smarty->assign('gift_cards', $results);
      }

      $this->smarty->assign('form', array(
         'code' => $this->getRequestParameter('gift_card[coupon_code]'),
         'action' => $this->getController()->genUrl(array('module' => 'stGiftCardFrontend', 'action' => 'activate')),
         'error' => $error ? $error : $this->getFlash('st_gift_card_error'),
         'return_url' => $this->return_url
     ));
   }
}

