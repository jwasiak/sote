<?php

/**
 * Subclass for performing query and update operations on the 'st_mail_description' table.
 *
 *
 *
 * @package plugins.stMailPlugin.lib.model
 */
class MailDescriptionPeer extends BaseMailDescriptionPeer
{
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

		MailDescriptionPeer::addSelectColumns($c);

		$startcol = (MailDescriptionPeer::NUM_COLUMNS - MailDescriptionPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		MailDescriptionI18nPeer::addSelectColumns($c);

		$c->addJoin(MailDescriptionPeer::ID, sprintf("%s AND %s = '%s'", MailDescriptionI18nPeer::ID, MailDescriptionI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);

		$results = array();

		while($rs->next())
		{

			$omClass = MailDescriptionPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);
			$obj1->setCulture($culture);

			$omClass = MailDescriptionI18nPeer::getOMClass($rs, $startcol);

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$obj1->setMailDescriptionI18nForCulture($obj2, $culture);
			$obj2->setMailDescription($obj1);

			$results[] = $obj1;
		}
		return $results;
	}


	public static function doCountWithI18n(Criteria $c, $con = null)
	{
		$c->addJoin(MailDescriptionI18nPeer::ID, MailDescriptionPeer::ID);

		$c->add(MailDescriptionI18nPeer::CULTURE, sfContext::getInstance()->getUser()->getCulture());

		return self::doCount($c, $con);
	}
}
