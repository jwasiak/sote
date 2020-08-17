<?php

class stGiftCardFrontendActions extends stActions
{

   public function executeActivate()
   {
      return $this->redirect($this->getRequest()->getReferer());
   }

   public function executeRemove()
   {
      $id = $this->getRequestParameter('id');

      $object = GiftCardPeer::retrieveByPk($id);

      if (stGiftCardPlugin::has($object))
      {
         stGiftCardPlugin::remove($object);
      }

      return $this->redirect($this->getRequest()->getReferer());
   }

   public function validateActivate()
   {
      $ok = true;

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $i18n = $this->getContext()->getI18N();
         
         $gift_card = $this->getRequestParameter('gift_card');

         if (empty($gift_card['code']))
         {
            $this->setFlash('st_gift_card_error', $i18n->__('Wprowadź kod'));

            return false;
         }

         $object = GiftCardPeer::retrieveByCode($gift_card['code']);

         if (!$object)
         {
            $this->setFlash('st_gift_card_error', $i18n->__('Bon o kodzie <b>%%code%%</b> nie istnieje', array('%%code%%' => $gift_card['code'])));

            $ok = false;
         }
         elseif (stGiftCardPlugin::has($object))
         {
            $this->setFlash('st_gift_card_error', $i18n->__('Bon o kodzie <b>%%code%%</b> jest już aktywny', array('%%code%%' => $object->getCode())));

            $ok = false;
         }
         elseif ($object->getCurrency()->getShortcut() != stCurrency::getInstance($this->getContext())->get()->getShortcut())
         {
            $this->setFlash('st_gift_card_error', $i18n->__('Bonem o kodzie <b>%%code%%</b> można płacić wyłącznie w walucie %currency%', array('%currency%' => $object->getCurrency()->getShortcut(), '%%code%%' => $object->getCode())));

            $ok = false;
         }
         elseif (count(stGiftCardPlugin::get()) > 1)
         {
            $this->setFlash('st_gift_card_error', $i18n->__('Nie możesz aktywować więcej niż 1 bon'));

            $ok = false;
         }         
         elseif (!$object->isValid())
         {
            $this->setFlash('st_gift_card_error', $i18n->__('Bon o kodzie <b>%%code%%</b> jest nieważny', array('%%code%%' => $object->getCode())));

            $ok = false;
         }
         elseif (!$object->isValidOrderAmount($this->getUser()->getBasket()->getTotalAmount(true, true)))
         {
            sfLoader::loadHelpers(array('Helper', 'stCurrency'));
            $this->setFlash('st_gift_card_error', $i18n->__('Musisz złożyć zamówienie za minimum %%amount%%', array(
               '%%amount%%' => st_currency_format($object->getMinOrderAmount(), array('digits' => 0))
            )));

            $ok = false;            
         }
         else
         {
            stGiftCardPlugin::add($object);
         }
      }

      return $ok;
   }

   public function handleErrorActivate()
   {
      return $this->redirect($this->getRequestParameter('gift_card[return_url]'));
   }

}
