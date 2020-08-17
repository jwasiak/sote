<?php

class stExtendImportExport
{
	public static function ImportValidateCode($value, $product_code)
	{
		$c = new Criteria();

		$c->add(ProductPeer::CODE, $product_code);

		if (!ProductPeer::doCount($c))
		{
			stImportExportLog::getActiveLogger()->add($product_code, sfContext::getInstance()->getI18n()->__('Produkt nie istnieje'), 2);

			return false;
		}

		return true;
    }
    
    protected $product;

    public static function getCulture(Product $object = null)
    {
        $culture = $object->getCulture();

        if ($culture)
        {
            return str_replace(array('pl_PL', 'en_US'), array('pl', 'en'), $culture);
        }
        return NULL;
    }
    
    public static function setCulture(Product $object = null, $culture)
    {
        $culture = str_replace(array('pl', 'en'), array('pl_PL', 'en_US'), $culture);
        $object->setCulture($culture);
    }

    public static function getName(Product $object = null)
    {
        $name = $object->getName();
        if ($name)
        {
            return $name;
        }
        return NULL;
    }
    
    public static function setName(Product $object = null, $name)
    {
        $object->setName($name);
         
    }

    public static function getDescription(Product $object = null)
    {
        $full_description = $object->getDescription();
        if ($full_description)
        {
            return $full_description;
        }
        return NULL;
    }
    
    public static function setDescription(Product $object = null, $full_description)
    {
        $object->setDescription($full_description);

    }

    public static function getShortDescription(Product $object = null)
    {
        $short_description = $object->getShortDescription();
        if ($short_description)
        {
            return $short_description;
        }
        return NULL;
    }

    public static function setShortDescription(Product $object = null, $short_description)
    {
        $object->setShortDescription($short_description);

    }
    
    public static function setDescription2(Product $object = null, $add_description)
    {
        $object->setDescription2($add_description);

    }

    public static function getDescription2(Product $object = null)
    {
        $add_description = $object->getDescription2();
        if ($add_description)
        {
            return $add_description;
        }
        return NULL;
    }

    public static function getUom(Product $object = null)
    {
        $uom = $object->getUom();
        if ($uom)
        {
            return $uom;
        }
        return NULL;
    }
    
    public static function setUom(Product $object = null, $uom)
    {
        $object->setUom($uom);
    }

    public static function getAttributesLabel(Product $object = null)
    {
        return $object->getAttributesLabel();
    }
    
    public static function setAttributesLabel(Product $object = null, $value)
    {
        $object->setAttributesLabel($value);
    }

    public static function setSearchKeywords(Product $object = null, $value)
    {
        $object->setSearchKeywords($value);
    }

    public static function getSearchKeywords(Product $object = null)
    {
        return $object->getSearchKeywords();
    }
}