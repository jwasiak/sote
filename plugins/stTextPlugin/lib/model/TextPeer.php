<?php
/**
 * SOTESHOP/stTextPlugin
 *
 * Ten plik należy do aplikacji stTextPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stTextPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: TextPeer.php 617 2009-04-09 13:02:31Z michal $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Klasa TextPeer
 *
 * @package     stTextPlugin
 * @subpackage  libs
 */
class TextPeer extends BaseTextPeer
{
	public static function retrieveBySystemName($system_name)
	{
		$criteria = new Criteria(TextPeer::DATABASE_NAME);
		$criteria->add(TextPeer::SYSTEM_NAME, $system_name);
		$criteria->add(TextPeer::ACTIVE, 1);
		$v = TextPeer::doSelect($criteria);
		return !empty($v) > 0 ? $v[0] : null;
	}

	/**
	 * Przeciążenie metody pobierającej tekstów w odpowiedniej wersji jezykowej
	 *
	 * @param Criteria $c Kryteria
	 * @param mixed $culture Wersja językowa
	 * @param CreoleConnection $con Połączenie z bazą danych
	 * @return array Produkty
	 */
	public static function doSelectWithI18n(Criteria $c, $culture = null, $con = null)
	{
		if ($culture === null)
		{
			$culture = sfContext::getInstance()->getUser()->getCulture();
		}

		if ($c->getDbName() == Propel::getDefaultDB())
		{
			$c->setDbName(self::DATABASE_NAME);
		}

		TextPeer::addSelectColumns($c);

		$startcol = (TextPeer::NUM_COLUMNS - TextPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		TextI18nPeer::addSelectColumns($c);

		$c->addJoin(TextPeer::ID, sprintf("%s AND %s = '%s'", TextI18nPeer::ID, TextI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);

		$results = array();

		while($rs->next())
		{
			$omClass = TextPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);
			$obj1->setCulture($culture);

			$omClass = TextI18nPeer::getOMClass($rs, $startcol);

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$obj1->setTextI18nForCulture($obj2, $culture);
			$obj2->setText($obj1);

			$results[] = $obj1;
		}
		return $results;
	}

	public static function doCountWithI18n(Criteria $c, $con = null)
	{
		$c->addJoin(TextI18nPeer::ID, TextPeer::ID);

		$c->add(TextI18nPeer::CULTURE, sfContext::getInstance()->getUser()->getCulture());

		return self::doCount($c, $con);
	}
}