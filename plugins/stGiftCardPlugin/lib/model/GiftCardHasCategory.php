<?php

/**
 * Subclass for representing a row from the 'st_gift_card_has_category' table.
 *
 * 
 *
 * @package plugins.stGiftCardPlugin.lib.model
 */ 
class GiftCardHasCategory extends BaseGiftCardHasCategory
{
    public function save($con = null)
    {
        $isNew = $this->isNew();

        $result = parent::save($con);

        if ($isNew && $this->getCategory()->hasChildren())
        {
            $con = Propel::getConnection();

            $con->executeQuery(sprintf("INSERT INTO %s (%s, %s, %s) SELECT %d, %s, %d FROM %s WHERE %s BETWEEN %d AND %d AND %s = %d",
                GiftCardHasCategoryPeer::TABLE_NAME,
                GiftCardHasCategoryPeer::GIFT_CARD_ID,
                GiftCardHasCategoryPeer::CATEGORY_ID,
                GiftCardHasCategoryPeer::IS_OPT,
                $this->getGiftCardId(),
                CategoryPeer::ID,
                1,
                CategoryPeer::TABLE_NAME,
                CategoryPeer::LFT,
                $this->getCategory()->getLft() + 1,
                $this->getCategory()->getRgt() - 1,
                CategoryPeer::SCOPE,
                $this->getCategory()->getScope()
            ));
        }

        return $result;
    }
}
