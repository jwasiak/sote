<?php
/**
 * SOTESHOP/stNewsletterPlugin
 *
 * Ten plik należy do aplikacji stNewsletterPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stNewsletterPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: NewsletterGroupPeer.php 10556 2011-01-27 12:27:02Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa NewsletterGroupPeer
 *
 * @package     stNewsletterPlugin
 * @subpackage  libs
 */
class NewsletterGroupPeer extends BaseNewsletterGroupPeer
{
	/**
	 * Przeciążenie metody doSelectWithI18n
	 *
	 * @param Criteria $c
	 * @param mixed $culture
	 * @param CreoleConnection $con
	 * @return array
	 */
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

		NewsletterGroupPeer::addSelectColumns($c);

		$startcol = (NewsletterGroupPeer::NUM_COLUMNS - NewsletterGroupPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		NewsletterGroupI18nPeer::addSelectColumns($c);

		$c->addJoin(NewsletterGroupPeer::ID, sprintf("%s AND %s = '%s'", NewsletterGroupI18nPeer::ID, NewsletterGroupI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);

		$results = array();

		while($rs->next())
		{

			$omClass = NewsletterGroupPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);
			$obj1->setCulture($culture);

			$omClass = NewsletterGroupI18nPeer::getOMClass($rs, $startcol);

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$obj1->setNewsletterGroupI18nForCulture($obj2, $culture);
			$obj2->setNewsletterGroup($obj1);

			$results[] = $obj1;
		}
		return $results;
	}

	/**
	 * Metoda doCountWithI18n
	 *
	 * @param Criteria $c
	 * @param CreoleConnection $con
	 * @return integer
	 */
	public static function doCountWithI18n(Criteria $c, $con = null)
	{
		$c->addJoin(NewsletterGroupI18nPeer::ID, NewsletterGroupPeer::ID);

		$c->add(NewsletterGroupI18nPeer::CULTURE, stLanguage::getHydrateCulture());

		return self::doCount($c, $con);
	}
}