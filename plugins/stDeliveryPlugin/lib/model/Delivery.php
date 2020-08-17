<?php
/**
 * SOTESHOP/stDelivery
 *
 * Ten plik należy do aplikacji stDelivery opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stDelivery
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: Delivery.php 10244 2011-01-13 14:26:05Z michal $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/**
 * Subclass for representing a row from the 'st_delivery' table.
 *
 * @package     stDelivery
 * @subpackage  libs
 */
class Delivery extends BaseDelivery
{
    protected static $currency = null;

    public function  __construct()
    {
        if (null === self::$currency && SF_APP == 'frontend')
        {
            self::$currency = stCurrency::getInstance(sfContext::getInstance())->get();
        }
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function setWidth($v)
    {
        parent::setWidth($v);
        $this->computeVolume();
    }

    public function setHeight($v)
    {
        parent::setHeight($v);
        $this->computeVolume();
    }

    public function setDepth($v)
    {
        parent::setDepth($v);
        $this->computeVolume();
    }   

    public function getMaxOrderWeight()
    {
        return $this->format(parent::getMaxOrderWeight());
    }

    public function getMaxOrderAmount()
    {
        return $this->format(parent::getMaxOrderAmount());
    }

    public function getMinOrderWeight()
    {
        return $this->format(parent::getMinOrderWeight());
    }

    public function getMinOrderAmount()
    {
        return $this->format(parent::getMinOrderAmount());
    }

    public function getDefaultCost()
    {
        return $this->format(parent::getDefaultCost());
    }

    public function getCostNetto($with_currency = false)
    {
        $v = $this->getDefaultCost();

        if ($with_currency)
        {
            $v = self::$currency->exchange($v);
        }

        return $v;
    }

    public function setCostNetto($v)
    {
        $this->setDefaultCost($v);
    }

    public function getCostBrutto($with_currency = false)
    {
        if (SF_APP == 'frontend' && (sfContext::getInstance()->getUser()->hasVatEu() || sfContext::getInstance()->getUser()->hasVatEx()))
        {
            return $this->getCostNetto($with_currency);
        }

        $v =  $this->getDefaultCostBrutto();

        if (null === $v)
        {
            $v = stPrice::calculate($this->getCostNetto(), $this->getTax()->getVat());

            $this->setCostBrutto($v);
        }

        if ($with_currency)
        {
            $v = self::$currency->exchange($v);
        }

        return $this->format($v);
    }

    public function getFreeDelivery()
    {
        if (SF_APP == 'frontend' && (sfContext::getInstance()->getUser()->hasVatEu() || sfContext::getInstance()->getUser()->hasVatEx()))
        {
            return stPrice::extract(parent::getFreeDelivery(), $this->getVat(false));
        }

        return parent::getFreeDelivery();
    }

    public function getVat($with_eu_tax = false)
    {
        return $this->getTax(null, $with_eu_tax)->getVat();
    }

    public function setCostBrutto($v)
    {
        $this->setDefaultCostBrutto($v);
    }

    public function getFreeFrom()
    {
        return $this->format($this->getFreeDelivery());
    }

    public function setFreeFrom($v)
    {
        $this->setFreeDelivery($v);
    }

    public function isType($type)
    {
        return $this->getTypeId() && $this->getTypeId() == DeliveryTypePeer::retrieveIdByType($type);       
    }

    public function getSectionCostTypeDesc()
    {
        $tmp = DeliverySectionsPeer::getAdditionalSectionCosts();

        return $this->getSectionCostType() ? $tmp[$this->getSectionCostType()] : null;
    }

    /**
     *
     * Dodana na potrzeby admin generator
     *
     * @param int $v Id vat
     */
    public function setEditTax($v)
    {
        $this->setTaxId($v);
    }

    public function getTax($con = null, $with_eu_tax = true)
    {
        if (SF_APP == 'frontend' && $with_eu_tax && (sfContext::getInstance()->getUser()->hasVatEu() || sfContext::getInstance()->getUser()->hasVatEx()))
        {
            return TaxPeer::retrieveByTax(0);
        }

        $this->aTax = parent::getTax($con);

        if (null === $this->aTax)
        {
            $this->aTax = TaxPeer::doSelectDefaultOne(new Criteria());
        }

        return $this->aTax;
    }


    /**
     * Przeciążenie hydrate
     *
     * @param ResultSet $rs
     * @param int $startcol
     * @return object
     */
    public function hydrate(ResultSet $rs, $startcol = 1)
    {
        $this->setCulture(stLanguage::getHydrateCulture());

        return parent::hydrate($rs, $startcol);
    }

    /**
     * Przeciążenie getName
     *
     * @return string
     */
    public function getName()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }

        $v = parent::getName();

        if (is_null($v))
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
        }

        return $v;
    }

    /**
     * Przeciążenie setName
     *
     * @param string $v Nazwa producenta
     */
    public function setName($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        parent::setName($v);
    }

    public function getParam($name, $default = null)
    {
        return $this->params && isset($this->params[$name]) ? $this->params[$name] : $default;
    }

    /**
     * Przeciążenie getDescription
     *
     * @return string
     */
    public function getDescription()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }

        $v = parent::getDescription();

        if (is_null($v))
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
        }

        return $v;
    }

    /**
     * Przeciążenie setDescription
     *
     * @param string $v Nazwa producenta
     */
    public function setDescription($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        parent::setDescription($v);
    }

    public function delete($con = null)
    {
        $ret = parent::delete($con);

        self::clearCache();

        return $ret;
    }

    public function save($con = null)
    {
        if ($this->getIsDefault() && $this->isColumnModified(DeliveryPeer::IS_DEFAULT))
        {
            $c = new Criteria();

            $c->add(DeliveryPeer::COUNTRIES_AREA_ID, $this->getCountriesAreaId());

            $delivery = DeliveryPeer::doSelectDefault($c);

            if ($delivery)
            {
                $delivery->setIsDefault(false);

                $delivery->save($con);
            }
        }

        $ret = parent::save($con);

        self::clearCache();

        return $ret;
    }

    protected function format($v)
    {
        $v = $v ? $v : 0.00;

        if (is_numeric($v))
        {
            return stPrice::round($v);
        }

        return $v;
    }

    protected function computeVolume()
    {
        $volume = $this->width * $this->height * $this->depth;
        $this->setVolume($volume);
    }

    public static function clearCache()
    {
        $fc = new stFunctionCache('stDelivery');   
        $fc->removeAll();     
    } 
}