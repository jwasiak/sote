<?php

/**
 * Subclass for representing a row from the 'app_add_price' table.
 *
 * 
 *
 * @package plugins.appAddPricePlugin.lib.model
 */ 
class AddPrice extends BaseAddPrice
{
    public function setPrice($v)
    {
        $this->setPriceNetto($v);
    }

    public function setOldPrice($v)
    {
        $this->setOldPriceNetto($v);
    }

    public function getPrice()
    {
        return $this->getPriceNetto();
    }

    public function getOldPrice()
    {
        return $this->getOldPriceNetto();
    }

    public function save($con = null)
    {
        if ($this->isNew() && null === $this->getTaxId())
        {
            $this->setTax($this->getProduct()->getTax());
        }

        if (!$this->getPriceNetto() && $this->getPriceBrutto() || $this->isColumnModified(AddPricePeer::PRICE_BRUTTO))
        {
           $this->setPriceNetto(stPrice::extract($this->getPriceBrutto(), $this->getVatValue()));
        }
        elseif ($this->getPriceNetto() && !$this->getPriceBrutto() || $this->isColumnModified(AddPricePeer::PRICE_NETTO))
        {
           $this->setPriceBrutto(stPrice::calculate($this->getPriceNetto(), $this->getVatValue()));
        }
  
        if (!$this->getOldPriceNetto() && $this->getOldPriceBrutto() || $this->isColumnModified(AddPricePeer::OLD_PRICE_BRUTTO))
        {
           $this->setOldPriceNetto(stPrice::extract($this->getOldPriceBrutto(), $this->getVatValue()));
        }
        elseif ($this->getOldPriceNetto() && !$this->getOldPriceBrutto() || $this->isColumnModified(AddPricePeer::OLD_PRICE_NETTO))
        {
           $this->setOldPriceBrutto(stPrice::calculate($this->getOldPriceNetto(), $this->getVatValue()));
        }

        $isModified = $this->isModified();

        $result = parent::save($con);

        if ($isModified)
        {
            stPartialCache::clear('stProduct', '_productGroup', array('app' => 'frontend'));
            stPartialCache::clear('stProduct', '_new', array('app' => 'frontend'));
            stFastCacheManager::clearCache();
        }

        return $result;
    }

    public function getVatValue()
    {
        return $this->getTax()->getVat();
    }

    public function setProductId($v)
    {
        $this->setId($v);
    }

    public function getProductId()
    {
        return $this->getId();
    }
}
