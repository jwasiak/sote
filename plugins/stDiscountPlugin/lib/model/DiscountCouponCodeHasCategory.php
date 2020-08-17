<?php

/**
 * Subclass for representing a row from the 'st_discount_coupon_code_has_category' table.
 *
 * 
 *
 * @package plugins.stDiscountPlugin.lib.model
 */ 
class DiscountCouponCodeHasCategory extends BaseDiscountCouponCodeHasCategory
{
    public function save($con = null)
    {
        $isNew = $this->isNew();

        $result = parent::save($con);

        if ($isNew && $this->getCategory()->hasChildren())
        {
            $con = Propel::getConnection();

            $con->executeQuery(sprintf("INSERT INTO %s (%s, %s, %s) SELECT %d, %s, %d FROM %s WHERE %s BETWEEN %d AND %d AND %s = %d",
                DiscountCouponCodeHasCategoryPeer::TABLE_NAME,
                DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID,
                DiscountCouponCodeHasCategoryPeer::CATEGORY_ID,
                DiscountCouponCodeHasCategoryPeer::IS_OPT,
                $this->getDiscountCouponCodeId(),
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
