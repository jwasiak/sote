<?php

/**
 * SOTESHOP/stProductOptionsPlugin
 * Ten plik należy do aplikacji stProductOptionsPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 *
 * @package     stProductOptionsPlugin
 * @subpackage  libs
 */
class ProductOptionsField extends BaseProductOptionsField
{
    public $_duplicated = null;

    public function __toString()
    {
        return $this->getName();
    }

    public function copyInto($copyObj, $deepCopy = false)
    {
        parent::copyInto($copyObj, $deepCopy);

        $copyObj->_duplicated = true;
    }       
    
    /**
     * Returns ProductOptionsValue object of given product id
     * with the same value as default one.
     *
     * @param $product_id
     * @return ProductOptionsValue object
     */
    public function getDefaultNode($product_id)
    {
        $c = new Criteria();
        $c->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());
        $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product_id);
        $c->addJoin(ProductOptionsValuePeer::ID, ProductOptionsValueI18nPeer::ID);
        
        foreach (ProductOptionsValuePeer::doSelect($c) as $value)
        {
            $value->setCulture($this->getCulture());
            if ($value->getValue() == $this->getDefaultValue()) return $value;
        }
    }

    public function getValues()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(ProductOptionsValuePeer::LFT);
        return $this->getProductOptionsValues($c);
    }

    public function getDefaultValues()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(ProductOptionsDefaultValuePeer::LFT);
        return $this->getProductOptionsDefaultValues($c);
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
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }
    
    /**
     * Przeciążenie setName
     * 
     * @param string $v
     */
    public function setName($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }
        
        parent::setName($v);
    }
    
    /**
     * Przeciążenie getDefaultValue
     *
     * @return string
     */
    public function getDefaultValue()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);   
        }   
        $v = parent::getDefaultValue();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }
    
    /**
     * Przeciążenie setDefaultValue
     * 
     * @param string $v
     */
    public function setDefaultValue($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }
        
        parent::setDefaultValue($v);
    }

    public function save($con = null)
    {
        if (!isset($this->_duplicated) && !$this->isNew() && $this->isColumnModified(ProductOptionsFieldPeer::PRODUCT_OPTIONS_FILTER_ID))
        {
            $con = Propel::getConnection();
            
            $q = new Criteria();
            $q->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

            $u = new Criteria();
            $u->add(ProductOptionsValuePeer::OPT_FILTER_ID, $this->getProductOptionsFilterId());

            BasePeer::doUpdate($q, $u, $con);
        }

        return parent::save($con);
    }

	public function clearI18ns()
	{
		if ($this->collProductOptionsFieldI18ns)
		{
			unset($this->collProductOptionsFieldI18ns);
			$this->collProductOptionsFieldI18ns = null;
		}
	}
}
