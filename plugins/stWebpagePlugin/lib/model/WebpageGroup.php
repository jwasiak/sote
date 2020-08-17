<?php
/** 
 * SOTESHOP/stWebpagePlugin 
 * 
 * Ten plik należy do aplikacji stWebpagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stWebpagePlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: WebpageGroup.php 12416 2011-04-21 11:50:51Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * Klasa WebpageGroup
 *
 * @package     stWebpagePlugin
 * @subpackage  libs
 */
class WebpageGroup extends BaseWebpageGroup
{
    /** 
     * Pobieranie nazwy
     *
     * @return   string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /** 
     * Zapisuje wartości domyślne dla zapisanej strony
     *
     * @param   string      domyślna           wartość stron $page  
     */
    public function setDefaultGroupPage($group_page)
    {
        if ($group_page=="NONE") $group_page=NULL;
        $this->setGroupPage($group_page);
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

    public function save($con = null)
    {
        $ret = parent::save($con);

        WebpagePeer::clearCache();

        return $ret;
    }

    public function delete($con = null)
    {
        $ret = parent::delete($con);

        WebpagePeer::clearCache();

        return $ret;
    }    
}