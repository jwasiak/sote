<?php

class stGiftGroupComponents extends sfComponents
{
    public function executeShow()
    {
        $basket = $this->getUser()->getBasket();

        foreach ($basket->getItems() as $item)
        {
            if ($item->getIsGift())
            {
                return sfView::NONE;
            }
        }        

        $gift_groups = ProductGroupPeer::doSelectGifts();

        if (!$gift_groups)
        {
            return sfView::NONE;
        }

        $discount = $basket->getDiscount();
        $basket->setDiscount(false);
        $total = $basket->getTotalAmount(true);
        $basket->setDiscount($discount);


        $group_id = null;

        $ids = array();

        foreach ($gift_groups as $id => $group)
        {
            if ($group->getFromBasketValue() <= $total)
            {
                $ids[] = $id;
            }
        }

        if (!$ids)
        {
            return sfView::NONE;
        }

        $c = new Criteria();
        $c->addJoin(ProductGroupHasProductPeer::PRODUCT_ID, ProductPeer::ID);
        $c->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $ids, Criteria::IN);
        $c->setLimit(100);
        ProductPeer::addFilterCriteria($this->getContext(), $c);
        $c->add(ProductPeer::OPT_HAS_OPTIONS, 1, Criteria::LESS_EQUAL);
        $c->remove(ProductPeer::IS_GIFT);
        $c->remove(ProductPeer::PRICE);
        $c->remove(ProductPeer::PRODUCER_ID);
        $c->add(ProductPeer::POINTS_ONLY, true, Criteria::NOT_EQUAL);
        $c->addDescendingOrderByColumn(ProductPeer::PRIORITY);

        $this->count = ProductPeer::doCount($c);

        if (!$this->count)
        {
            return sfView::NONE;
        }

        $this->products = ProductPeer::doSelect($c);        
        $this->config = stConfig::getInstance('stProduct');
        $this->smarty = new stSmarty('stGiftGroup');
        $this->smarty->assign('is_ajax', isset($this->is_ajax) && $this->is_ajax);
    }
}