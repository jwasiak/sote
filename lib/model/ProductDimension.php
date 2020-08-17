<?php

/**
 * Subclass for representing a row from the 'st_product_dimension' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ProductDimension extends BaseProductDimension
{
    public function save($con = null)
    {
        $is_new = $this->isNew();
        $is_modified = $this->isModified();

        $ret = parent::save($con);

        if (!$is_new && $is_modified)
        {
            $s = new Criteria();
            $s->add(ProductPeer::DIMENSION_ID, $this->id);

            $u = new Criteria();
            $u->add(ProductPeer::WIDTH, $this->width);
            $u->add(ProductPeer::HEIGHT, $this->height);
            $u->add(ProductPeer::DEPTH, $this->depth);

            BasePeer::doUpdate($s, $u, Propel::getConnection());
        }

        ProductDimensionPeer::clearCache();
        return $ret;
    }

    public function delete($con = null)
    {
        $ret = parent::delete($con);
        ProductDimensionPeer::clearCache();
        return $ret;        
    }
}
