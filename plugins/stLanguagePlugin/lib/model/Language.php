<?php
/**
 * SOTESHOP/stLanguagePlugin
 *
 * Ten plik należy do aplikacji stLanguagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLanguagePlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: Language.php 10732 2011-02-01 12:15:55Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa Language
 *
 * @package     stLanguagePlugin
 * @subpackage  libs
 */
class Language extends BaseLanguage
{
    /**
     * Zwracanie nazwy wersji językowej
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Ustawianie pola is_default
     *
     * @param $v int
     */
    public function setIsDefault($v)
    {
        if ($v == 1 && $this->getIsDefault() == 0)
        {
            $c1 = new Criteria();
            $c1->add(LanguagePeer::ID, 0, Criteria::GREATER_THAN);
            $c2 = new Criteria();
            $c2->add(LanguagePeer::IS_DEFAULT, 0);
            BasePeer::doUpdate($c1, $c2, Propel::getConnection());

            $stConfigOptimizer = stConfigOptimizer::getInstance();
            $stConfigOptimizer->set('default_language', $this->getOriginalLanguage());
        }

        parent::setIsDefault($v);
    }

    /**
     * Ustawianie pola is_default_panel
     *
     * @param $v int
     */
    public function setIsDefaultPanel($v)
    {
        if ($v == 1 && $this->getIsDefaultPanel() == 0)
        {
            $c1 = new Criteria();
            $c1->add(LanguagePeer::ID, 0, Criteria::GREATER_THAN);
            $c2 = new Criteria();
            $c2->add(LanguagePeer::IS_DEFAULT_PANEL, 0);
            BasePeer::doUpdate($c1, $c2, Propel::getConnection());
        }

        parent::setIsDefaultPanel($v);
    }

    /**
     * Pobieranie języka systemowego (culture)
     *
     * @return string
     */
    public function getLanguage()
    {
        $v = $this->language;
        if ($v == 'pl_PL')
        {
            $v = 'pl';
        } elseif ($v == 'en_US')
        {
            $v = 'en';
        }

        return $v;
    }

    /**
     * Ustawianie języka systemowego (culture)
     *
     * @param $v string
     */
    public function setLanguage($v)
    {
        if ($v == 'pl') $v = 'pl_PL';
        elseif ($v == 'en') $v = 'en_US';

        parent::setLanguage($v);
    }

    /**
     * Pobieranie nie zmienionego języka systemowego (culture) 
     *
     * @return string
     */
    public function getOriginalLanguage()
    {
        return $this->language;
    }

    /**
     * Przeciążenie zapisu
     */
    public function save($con = null) {
        $this->clearCache();
        
        if($this->shortcut == null) 
            $this->setShortcut($this->getLanguage());

        return parent::save($con);
    }

    /**
     * Przeciążenie usuwania
     */
    public function delete($con = null) {
        $this->clearCache();
        return parent::delete($con);
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

    public function getDefaultDomain()
    {
        $c = new Criteria();
        $c->add(LanguageHasDomainPeer::LANGUAGE_ID, $this->id);
        $c->add(LanguageHasDomainPeer::IS_DEFAULT, true);
        return LanguageHasDomainPeer::doSelectOne($c);
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

    public function getIsSystemDefault() {
        if ($this->getIsDefault() && $this->getActive()) return true;
        return false;
    }

    protected function clearCache() {
        stFastCacheManager::clearCache();
        stLanguageFastCache::create();

        foreach (glob(sfConfig::get('sf_root_dir').'/cache/functions/*/*/stLanguagePlugin/*') as $file)
            if (file_exists($file))
                unlink($file);
    }
}
