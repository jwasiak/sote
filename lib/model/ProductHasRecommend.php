<?php

/**
 * Subclass for representing a row from the 'st_product_has_recommend' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ProductHasRecommend extends BaseProductHasRecommend
{
    public function getCode()
    {
        if (is_object($this->getProductRelatedByRecommendId())) return $this->getProductRelatedByRecommendId()->getCode();
        return null;
    }
}
