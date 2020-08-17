<?php

/** 
 * SOTESHOP/stProductOptionsPlugin
 * Ten plik należy do aplikacji stReview opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 *
 * @package     stProductOptionsPlugin
 * @subpackage  libs
 */
class ProductOptionsDefaultValue extends BaseProductOptionsDefaultValue
{
    protected static $version = 1; 
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
	 * Przeciążenie getPriceType
	 *
	 * @return string
	 */
	public function getPriceType($check = false)
	{
	    if($this->isRoot())
	    {    
     		$result = $this->price_type;

 			if($result === null)
 			{
 				foreach($this->getDescendants() as $option)
 				{
 					$result = $option->getPriceType(true);
 					if($result!==null)
 					{
 					    $this->setPriceType($result);
 						break;
 					}
 				}
 				if($result === null)
 				{
 				    $this->setPriceType(0);
 				}
 			}
 			
 			if($result === 0)
			{
				$config = stConfig::getInstance(sfContext::getInstance(), array('price_type' => stConfig::STRING), 'stProduct');
				$config->load();
				$result = $config->get('price_type');
			}
		    return $result;
	    }
	    else
	    {
	        if($check)
	        {
	            return $this->price_type;
	        }
	        else
	        {
                $c = new Criteria();
                $c->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getProductOptionsTemplateId());
                $c->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID, null, Criteria::ISNULL);
                $root = ProductOptionsDefaultValuePeer::doSelectOne($c);
	            return $root->getPriceType();
	        }
	    }
	}

    /**
     * Przeciążenie getValue
     *
     * @return string
     */
    public function getValue()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);   
        }
        $v = parent::getValue();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }
    
    /**
     * Przeciążenie setValue
     * 
     * @param string $v
     */
    public function setValue($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }
        
        parent::setValue($v);
    }

    public function save($con = null)
    {
        if ($this->getOptVersion()!=ProductOptionsDefaultValue::$version) {
            $this->setOptVersion(ProductOptionsDefaultValue::$version);
        }
        
        parent::save($con);

        $field = ProductOptionsFieldPeer::retrieveByPk($this->product_options_field_id);
        if ($field && $this->getDepth()>0) {
            $field->setOptValueId($this->getParent()->getId());
            $field->save();
        }
    }

    public function delete($con = null)
    {
        $sql = sprintf('DELETE %1$s, %2$s FROM %1$s LEFT JOIN %2$s ON %8$s = %7$s, %3$s WHERE %10$s = %11$s AND %4$s > %5$s AND %4$s < %6$s AND %7$s = %9$s',
            ProductOptionsFieldPeer::TABLE_NAME,
            ProductOptionsFieldI18nPeer::TABLE_NAME,
            ProductOptionsDefaultValuePeer::TABLE_NAME,
            ProductOptionsDefaultValuePeer::LFT,
            $this->getLft(),
            $this->getRgt(),
            ProductOptionsFieldPeer::ID,
            ProductOptionsFieldI18nPeer::ID,
            ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, 
            ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID,
            $this->getProductOptionsTemplateId()
        ); 

        $ret = parent::delete();
        $this->deleteColorImage();
        return $ret;
    }
    
    public function getParentId()
    {
        return $this->getProductOptionsDefaultValueId();
    }

    public function clearI18ns()
    {
        if ($this->collProductOptionsDefaultValueI18ns)
        {
            unset($this->collProductOptionsDefaultValueI18ns);
            $this->collProductOptionsDefaultValueI18ns = null;
        }
    }

    public function getColorImagePath($system = false)
    {
        return ProductOptionsValuePeer::getColorImagePath($this->getProductOptionsTemplateId(), $this->getId(), $this->getColor(), $system, '/uploads/default-options');
    }

    public function deleteColorImage()
    {
        if ($this->getUseImageAsColor() && is_file($this->getColorImagePath(true)))
        {
            unlink($this->getColorImagePath(true));
        }
    }

    public function getColorImageDir($system = false)
    {
        return ProductOptionsValuePeer::getColorImageDir($this->getProductOptionsTemplateId(), $system, '/uploads/default-options');
    } 

    public function setColorImage($v)
    {
        $this->setColor($v);
    } 

    public function getColorImage()
    {
        return $this->getColor();
    }        
}

$columns = array('left' => ProductOptionsDefaultValuePeer::LFT,
                 'right' => ProductOptionsDefaultValuePeer::RGT,
                 'parent' => ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID,
                 'scope' => ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID,
                 'depth' => ProductOptionsDefaultValuePeer::DEPTH);

sfPropelBehavior::add('ProductOptionsDefaultValue', array('actasnestedset' => array('columns' => $columns)));