<?php
class stGiftCardBackendActions extends autoStGiftCardBackendActions
{
    public function validateConfig()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $config = $this->getRequest()->getParameter('config');
            
            $i18n = $this->getContext()->getI18N(); 

            if (!$config['code_format'])
            {
                $this->getRequest()->setError('config{code_format}', $i18n->__('Podaj format kodu'));
            }
            elseif (strpos($config['code_format'], '@') === false)
            {
                $this->getRequest()->setError('config{code_format}', $i18n->__('Parametr "@" jest wymagany'));
            }
        }

        return !$this->getRequest()->hasErrors();
    }

    public function validateEdit()
    {
        $request = $this->getRequest();

        $i18n = $this->getContext()->getI18N();

        if ($request->getMethod() != sfRequest::POST &&  $request->getParameter('id'))
        {
            $giftCard = GiftCardPeer::retrieveByPk($request->getParameter('id'));
        
            if (!$giftCard->getAllowAllProducts() && !$giftCard->countGiftCardHasProducts() && !$giftCard->countGiftCardHasCategorys() && !$giftCard->countGiftCardHasProducers())
            {
                $request->setError('{giftcard_assign_products}', $i18n->__('Musisz dodać przynajmniej jeden produkt lub kategorie lub producenta lub zaznaczyć opcję <b>Dla Wszystkich produktów</b>', null, 'stDiscountBackend'));
            }                     
        }

        return !$request->hasErrors();
    }

    protected function saveGiftCard($gift_card)
    {
        $isNew = $gift_card->isNew();

        parent::saveGiftCard($gift_card);

        $categories = stJQueryToolsHelper::parseTokensFromRequest($this->getRequestParameter('categories'));

        if (!$isNew)
        {
            $c = new Criteria();

            $c->add(GiftCardHasCategoryPeer::GIFT_CARD_ID, $gift_card->getId());
    
            GiftCardHasCategoryPeer::doDelete($c);
        }

        foreach ($categories as $token)
        {

            $ghc = new GiftCardHasCategory();
            $ghc->setGiftCard($gift_card);
            $ghc->setCategoryId($token['id']);
            $ghc->save();
        }

        $producers = stJQueryToolsHelper::parseTokensFromRequest($this->getRequestParameter('producers'));

        if (!$isNew)
        {
            $c = new Criteria();

            $c->add(GiftCardHasProducerPeer::GIFT_CARD_ID, $gift_card->getId());
    
            GiftCardHasProducerPeer::doDelete($c);
        }

        foreach ($producers as $token)
        {
            $ghp = new GiftCardHasProducer();
            $ghp->setGiftCard($gift_card);
            $ghp->setProducerId($token['id']);
            $ghp->save();
        }
    }

    protected function getLabels()
    {
        $labels = parent::getLabels();

        $labels['{giftcard_assign_products}'] = $this->getContext()->getI18N()->__('Przypisz produkty', null, 'stDiscountBackend');

        return $labels;
    }
}