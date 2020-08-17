<?php

/**
 * Subclass for representing a row from the 'st_discount_has_category' table.
 *
 * 
 *
 * @package plugins.stDiscountPlugin.lib.model
 */ 
class DiscountHasCategory extends BaseDiscountHasCategory
{
    public function save($con = null)
    {
        $isNew = $this->isNew();

        $result = parent::save($con);

        if ($isNew && $this->getCategory()->hasChildren())
        {
            $con = Propel::getConnection();

            $con->executeQuery(sprintf("INSERT INTO %s (%s, %s, %s) SELECT %d, %s, %d FROM %s WHERE %s BETWEEN %d AND %d AND %s = %d",
                DiscountHasCategoryPeer::TABLE_NAME,
                DiscountHasCategoryPeer::DISCOUNT_ID,
                DiscountHasCategoryPeer::CATEGORY_ID,
                DiscountHasCategoryPeer::IS_OPT,
                $this->getDiscountId(),
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
