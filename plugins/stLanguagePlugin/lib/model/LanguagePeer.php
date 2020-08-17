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
 * @version     $Id: LanguagePeer.php 10732 2011-02-01 12:15:55Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa LanguagePeer
 *
 * @package     stLanguagePlugin
 * @subpackage  libs
 */
class LanguagePeer extends BaseLanguagePeer
{
    protected static $allLanguages, $allLanguagesCulture = null; 

    public static function doSelectLanguages(Criteria $criteria = null, $con = null) {
        if (!is_null(self::$allLanguages) && self::$allLanguagesCulture == sfContext::getInstance()->getUser()->getCulture())
            return self::$allLanguages;
        else {
            if (is_null($criteria))
                $c = new Criteria();
            else
                $c = clone $criteria;

            self::$allLanguagesCulture = sfContext::getInstance()->getUser()->getCulture();

            $stCache = new stFunctionCache('stLanguagePlugin');
            self::$allLanguages = $stCache->add('allLanguages_'.self::$allLanguagesCulture, "LanguagePeer::doSelect", $c, $con);
            return self::$allLanguages;
        }
        return null;
    }

    public static function doSelectActive(Criteria $criteria = null, $con = null)
    {
        $returnLanguages = array();
        $languages = LanguagePeer::doSelectLanguages($criteria, $con);

        foreach ($languages as $language)
        {
            if ($language->getActive())
            {
                $returnLanguages[] = $language;
            }
        }
        return $returnLanguages;
    }

    public static function doSelectDefault(Criteria $criteria = null, $con = null)
    {
        $languages = LanguagePeer::doSelectActive($criteria, $con);

        foreach ($languages as $language)
        {
            if ($language->getIsDefault()) return $language;
        }

        if(isset($languages[0]))
        {
            return $languages[0];
        }

        return null;
    }

    public static function retrieveByCulture($culture, $con = null)
    {
        $languages = LanguagePeer::doSelectActive(null, $con);

        foreach ($languages as $language)
        {
            if ($language->getOriginalLanguage() == $culture) return $language;
        }

        return null;
    }

    public static function retrieveByShortcut($shortcut, $con = null)
    {
        $languages = LanguagePeer::doSelectActive(null, $con);

        foreach ($languages as $language)
        {
            if ($language->getShortcut() == $shortcut) return $language;
        }

        return null;
    }

    public static function doSelectByDomain($domainParam, $con = null)
    {
        $domains = LanguageHasDomainPeer::doSelectAll($con);
        $languages = LanguagePeer::doSelectLanguages(null, $con);

        $languageId = null;
        foreach($domains as $domain)
        {
            if ($domain->getDomain() == $domainParam)
            {
                $languageId = $domain->getLanguageId();
                break;
            }
        }

        if ($languageId == null) return null;

        foreach($languages as $language)
        {
            if ($language->getId() == $languageId)
            {
                return $language;
            }
        }
    }
    
    public static function doSelectWithI18n(Criteria $c, $culture = null, $con = null)
    {
        if ($culture === null)
        {
            $culture = stLanguage::getHydrateCulture();
        }

        if ($c->getDbName() == Propel::getDefaultDB())
        {
            $c->setDbName(self::DATABASE_NAME);
        }

        LanguagePeer::addSelectColumns($c);

        $startcol = (LanguagePeer::NUM_COLUMNS - LanguagePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

        LanguageI18nPeer::addSelectColumns($c);

        $c->addJoin(LanguagePeer::ID, sprintf("%s AND %s = '%s'", LanguageI18nPeer::ID, LanguageI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

        $rs = BasePeer::doSelect($c, $con);

        $results = array();

        while($rs->next())
        {

            $omClass = LanguagePeer::getOMClass();

            $cls = Propel::import($omClass);
            $obj1 = new $cls();
            $obj1->hydrate($rs);
            $obj1->setCulture($culture);

            $omClass = LanguageI18nPeer::getOMClass($rs, $startcol);

            $cls = Propel::import($omClass);
            $obj2 = new $cls();
            $obj2->hydrate($rs, $startcol);

            $obj1->setLanguageI18nForCulture($obj2, $culture);
            $obj2->setLanguage($obj1);

            $results[] = $obj1;
        }
        return $results;
    }
    
    public static function doCountWithI18n(Criteria $c, $con = null)
    {
        $c->addJoin(LanguageI18nPeer::ID, LanguagePeer::ID);

        $c->add(LanguageI18nPeer::CULTURE, stLanguage::getHydrateCulture());

        return self::doCount($c, $con);
    }

    public static function getLanguagesAsArray() {
        $languages = self::doSelectLanguages();
        $list = array();

        foreach ($languages as $language)
            $list[$language->getLanguage()] = $language->getName();

        return $list;
    }
}
