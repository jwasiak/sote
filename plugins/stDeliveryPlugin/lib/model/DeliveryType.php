<?php

/**
 * Subclass for representing a row from the 'st_delivery_type' table.
 *
 * 
 *
 * @package plugins.stDeliveryPlugin.lib.model
 */ 
class DeliveryType extends BaseDeliveryType
{
    public function __toString()
    {
        return $this->getName();
    }

    public function getIsSystemDefault()
    {
        return null !== $this->type;
    }

    public function save($con = null)
    {
        $ret = parent::save($con);

        DeliveryTypePeer::clearCache();

        return $ret;
    }

    public function delete($con = null)
    {
        $ret = parent::delete($con);

        DeliveryTypePeer::clearCache();

        return $ret;
    }
}
