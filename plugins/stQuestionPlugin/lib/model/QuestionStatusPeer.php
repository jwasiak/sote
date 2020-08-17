<?php

/**
 * Subclass for performing query and update operations on the 'st_question_status' table.
 *
 *
 *
 * @package plugins.stQuestionPlugin.lib.model
 */
class QuestionStatusPeer extends BaseQuestionStatusPeer
{
	/**
	 * Zwraca listę stałych typów statusów
	 *
	 * @return  array       Lista typów statusów  
	 */
	public static function getTypes()
	{
		return array('ST_CANCELED' => 'anulowane', 'ST_NEW' => 'nowe', 'ST_PENDING' => 'oczekuje', 'ST_COMPLETE' => 'wysłane');
	}

	/**
	 * Zwraca nazwę dla danego typu statusu
	 *
	 * @return   string
	 */
	public static function getNameFromType($type)
	{
		$types = self::getTypes();

		return isset($types[$type]) ? $types[$type] : '';
	}

	/**
	 * Zwraca domyślny stan typu ST_NEW
	 *
	 * @return   QuestionStatus
	 */
	public static function retrieveDefaultNewStatus(Criteria $c, $con = null)
	{
		$criteria = clone $c;

		$criteria->add(self::IS_DEFAULT, true);

		$criteria->add(self::STATUS_TYPE, 'ST_NEW');

		return self::doSelectOne($criteria, $con);
	}


	/**
	 * Zwraca domyślny stan typu ST_COMPLETE
	 *
	 * @return   QuestionStatus
	 */
	public static function retriveDefaultCompleteStatus()
	{
		$c = new Criteria();

		$c->add(self::IS_SYSTEM_DEFAULT, true);

		$c->add(self::STATUS_TYPE, 'ST_COMPLETE');

		return self::doSelectOne($c);
	}

	/**
	 * Zwraca domyślny stan systemowy o podanym typie
	 *
	 * @param   const       $type               Typ stanu
	 * @return   QuestionStatus
	 */
	public static function retrieveSystemStatusByType($type)
	{
		$c = new Criteria();

		$c->add(self::IS_SYSTEM_DEFAULT, true);

		$c->add(self::STATUS_TYPE, $type);

		return self::doSelectOne($c);
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

		QuestionStatusPeer::addSelectColumns($c);

		$startcol = (QuestionStatusPeer::NUM_COLUMNS - QuestionStatusPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		QuestionStatusI18nPeer::addSelectColumns($c);

		$c->addJoin(QuestionStatusPeer::ID, sprintf("%s AND %s = '%s'", QuestionStatusI18nPeer::ID, QuestionStatusI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);

		$results = array();

		while($rs->next())
		{
			$omClass = QuestionStatusPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);
			$obj1->setCulture($culture);

			$omClass = QuestionStatusI18nPeer::getOMClass($rs, $startcol);

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$obj1->setQuestionStatusI18nForCulture($obj2, $culture);
			$obj2->setQuestionStatus($obj1);

			$results[] = $obj1;
		}
		return $results;
	}

	public static function doCountWithI18n(Criteria $c, $con = null)
	{
		$c->addJoin(QuestionStatusI18nPeer::ID, QuestionStatusPeer::ID);

		$c->add(QuestionStatusI18nPeer::CULTURE, stLanguage::getHydrateCulture());

		return self::doCount($c, $con);
	}
}