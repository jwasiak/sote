<?php

/**
 * Subclass for representing a row from the 'app_product_attribute_variant_has_product' table.
 *
 * 
 *
 * @package plugins.appProductAttributesPlugin.lib.model
 */ 
class appProductAttributeVariantHasProduct extends BaseappProductAttributeVariantHasProduct
{
    public function copyInto($copyObj, $deepCopy = false)
    {
        parent::copyInto($copyObj, $deepCopy);
        $copyObj->setVariantId($this->getVariantId());
    }
}
