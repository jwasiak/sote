<?php
/**
 * SOTESHOP/stCountriesPlugin
 *
 * Ten plik należy do aplikacji stCountriesPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stCountriesPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: Countries.php 10216 2011-01-13 11:34:53Z michal $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/**
 * Klasa Countries
 *
 * @package     stCountriesPlugin
 * @subpackage  libs
 */
class Countries extends BaseCountries
{
/**
 * Przekaztwanie nazwy kraju
 *
 * @return   string
 */
    public function __toString()
    {
        return $this->getName();
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
     *
     * Alias dla metody setName dodany na potrzeby admin generatora
     *
     * @param string $v Nazwa kraju
     */
    public function setEditName($v)
    {
        $this->setName($v);
    }

    public function save($con = null)
    {
        if ($this->getIsDefault() && $this->isColumnModified(CountriesPeer::IS_DEFAULT))
        {
            $country = CountriesPeer::doSelectDefault(new Criteria(), $con);

            if ($country)
            {
                $country->setIsDefault(false);

                $country->save($con);
            }
        }

        $ret = parent::save($con);

        self::clearCache();

        return $ret;
    }

    public function delete($con = null)
    {
        $ret = parent::delete($con);

        self::clearCache();

        return $ret;
    }

    public function isEU()
    {        
        return in_array($this->iso_a2, array('AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PL' , 'PT', 'RO', 'SK', 'SI', 'ES', 'SE', 'GB'));
    }

    public static function clearCache()
    {
        stFunctionCache::getInstance('stCountriesPlugin')->removeAll();
    }
}