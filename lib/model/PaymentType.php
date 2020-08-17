<?php
/**
 * SOTESHOP/stPayment
 *
 * Ten plik należy do aplikacji stPayment opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPayment
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: PaymentType.php 10198 2011-01-13 09:18:10Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa PaymentType
 *
 * @package     stPayment
 * @subpackage  libs
 */
class PaymentType extends BasePaymentType
{
    protected $apiInstance = null;

    public function setCreatedAt($v)
    {

    }

    public function setUpdatedAt($v)
    {

    }

    /**
     * Zwracanie nazwy typu płatności
     *
     * @return   string
     */
    public function __toString()
    {
        return $this->getName();
    }

    public function getApiInstance()
    {
        if (null === $this->apiInstance)
        {
            $class = $this->getModuleName();
            $this->apiInstance = new $class();
        }

        return $this->apiInstance;
    }

    /**
     * Ustawianie domyślnego typu płatności
     *
     * @param int $v
     */
    public function setIsDefault($v)
    {
        if ($v == 1 && $this->getIsDefault() == 0)
        {
            $c1 = new Criteria();
            $c1->add(PaymentTypePeer::ID, 0, Criteria::GREATER_THAN);
            $c2 = new Criteria();
            $c2->add(PaymentTypePeer::IS_DEFAULT, 0);
            BasePeer::doUpdate($c1, $c2, Propel::getConnection());
        }

        parent::setIsDefault($v);
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
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }

    /**
     * Przeciążenie setDescription
     *
     * @param string $v
     */
    public function setDescription($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        parent::setDescription($v);
    }

    /**
     * Sprawdzianie konfiguracji typu płatości
     *
     * @return bool
     */
    public function checkPaymentConfiguration()
    {
        $module_name = $this->getModuleName();

        if(class_exists($module_name))
        {
            $obj = new $module_name;

            if(method_exists($obj, 'checkPaymentConfiguration'))
            {
                return $obj->checkPaymentConfiguration();
            }
        }

        return true;
    }

    /**
     * Przeciążenie zapisu
     *
     * @param PropelConnection $con
     */
    public function save($con = null)
    {
        $is_modified = $this->isModified();

        $ret = parent::save($con);

        if ($is_modified)
        {
            self::cacheClear();
        }

        return $ret;
    }

    public function delete($con = null)
    {
        $ret = parent::delete($con);

        self::cacheClear();

        return $ret;
    }

    public function getSummaryDescription() {
        if ($this->getCulture() == stLanguage::getOptLanguage()) return stLanguage::getDefaultValue($this, __METHOD__);
        $v = parent::getSummaryDescription();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }

    public function setSummaryDescription($v) {
        if ($this->getCulture() == stLanguage::getOptLanguage()) stLanguage::setDefaultValue($this, __METHOD__, $v);
        parent::setSummaryDescription($v);
    }

    public function cacheClear()
    {
        $stCache = stFunctionCache::getInstance('stPayment');
        $stCache->removeAll();        
    }

    public function getConfigurationParameter($name, $default = null)
    {
        $configuration = $this->getConfiguration();

        return isset($configuration[$name]) ? $configuration[$name] : $default;
    }

    public function setConfigurationParameter($name, $value)
    {
        $configuration = $this->getConfiguration();

        if (!$configuration)
        {
            $configuration = array();
        }

        $configuration[$name] = $value;

        $this->setConfiguration($configuration);
    }
    
    public function getIsActive()
    {
        return $this->getActive();
    }

    public function setIsActive($v)
    {
        $this->setActive($v);
    }
}