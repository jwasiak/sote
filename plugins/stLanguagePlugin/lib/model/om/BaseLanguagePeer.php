<?php

/**
 * Base static class for performing query and update operations on the 'st_language' table.
 *
 * 
 *
 * @package    plugins.stLanguagePlugin.lib.model.om
 */
abstract class BaseLanguagePeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_language';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stLanguagePlugin.lib.model.Language';

	/** The total number of columns. */
	const NUM_COLUMNS = 15;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_language.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_language.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_language.ID';

	/** the column name for the CURRENCY_ID field */
	const CURRENCY_ID = 'st_language.CURRENCY_ID';

	/** the column name for the ACTIVE_IMAGE field */
	const ACTIVE_IMAGE = 'st_language.ACTIVE_IMAGE';

	/** the column name for the INACTIVE_IMAGE field */
	const INACTIVE_IMAGE = 'st_language.INACTIVE_IMAGE';

	/** the column name for the SHORTCUT field */
	const SHORTCUT = 'st_language.SHORTCUT';

	/** the column name for the IS_DEFAULT field */
	const IS_DEFAULT = 'st_language.IS_DEFAULT';

	/** the column name for the ACTIVE field */
	const ACTIVE = 'st_language.ACTIVE';

	/** the column name for the LANGUAGE field */
	const LANGUAGE = 'st_language.LANGUAGE';

	/** the column name for the IS_TRANSLATE field */
	const IS_TRANSLATE = 'st_language.IS_TRANSLATE';

	/** the column name for the SYSTEM field */
	const SYSTEM = 'st_language.SYSTEM';

	/** the column name for the IS_DEFAULT_PANEL field */
	const IS_DEFAULT_PANEL = 'st_language.IS_DEFAULT_PANEL';

	/** the column name for the IS_TRANSLATE_PANEL field */
	const IS_TRANSLATE_PANEL = 'st_language.IS_TRANSLATE_PANEL';

	/** the column name for the OPT_NAME field */
	const OPT_NAME = 'st_language.OPT_NAME';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'CurrencyId', 'ActiveImage', 'InactiveImage', 'Shortcut', 'IsDefault', 'Active', 'Language', 'IsTranslate', 'System', 'IsDefaultPanel', 'IsTranslatePanel', 'OptName', ),
		BasePeer::TYPE_COLNAME => array (LanguagePeer::CREATED_AT, LanguagePeer::UPDATED_AT, LanguagePeer::ID, LanguagePeer::CURRENCY_ID, LanguagePeer::ACTIVE_IMAGE, LanguagePeer::INACTIVE_IMAGE, LanguagePeer::SHORTCUT, LanguagePeer::IS_DEFAULT, LanguagePeer::ACTIVE, LanguagePeer::LANGUAGE, LanguagePeer::IS_TRANSLATE, LanguagePeer::SYSTEM, LanguagePeer::IS_DEFAULT_PANEL, LanguagePeer::IS_TRANSLATE_PANEL, LanguagePeer::OPT_NAME, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'currency_id', 'active_image', 'inactive_image', 'shortcut', 'is_default', 'active', 'language', 'is_translate', 'system', 'is_default_panel', 'is_translate_panel', 'opt_name', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'CurrencyId' => 3, 'ActiveImage' => 4, 'InactiveImage' => 5, 'Shortcut' => 6, 'IsDefault' => 7, 'Active' => 8, 'Language' => 9, 'IsTranslate' => 10, 'System' => 11, 'IsDefaultPanel' => 12, 'IsTranslatePanel' => 13, 'OptName' => 14, ),
		BasePeer::TYPE_COLNAME => array (LanguagePeer::CREATED_AT => 0, LanguagePeer::UPDATED_AT => 1, LanguagePeer::ID => 2, LanguagePeer::CURRENCY_ID => 3, LanguagePeer::ACTIVE_IMAGE => 4, LanguagePeer::INACTIVE_IMAGE => 5, LanguagePeer::SHORTCUT => 6, LanguagePeer::IS_DEFAULT => 7, LanguagePeer::ACTIVE => 8, LanguagePeer::LANGUAGE => 9, LanguagePeer::IS_TRANSLATE => 10, LanguagePeer::SYSTEM => 11, LanguagePeer::IS_DEFAULT_PANEL => 12, LanguagePeer::IS_TRANSLATE_PANEL => 13, LanguagePeer::OPT_NAME => 14, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'currency_id' => 3, 'active_image' => 4, 'inactive_image' => 5, 'shortcut' => 6, 'is_default' => 7, 'active' => 8, 'language' => 9, 'is_translate' => 10, 'system' => 11, 'is_default_panel' => 12, 'is_translate_panel' => 13, 'opt_name' => 14, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

         protected static $hydrateMethod = null;

         protected static $postHydrateMethod = null;

         public static function setHydrateMethod($callback)
         {
            self::$hydrateMethod = $callback;
         }

         public static function setPostHydrateMethod($callback)
         {
            self::$postHydrateMethod = $callback;
         }

	/**
	 * @return     MapBuilder the map builder for this peer
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getMapBuilder()
	{
		return BasePeer::getMapBuilder('plugins.stLanguagePlugin.lib.model.map.LanguageMapBuilder');
	}
	/**
	 * Gets a map (hash) of PHP names to DB column names.
	 *
	 * @return     array The PHP to DB name map for this peer
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @deprecated Use the getFieldNames() and translateFieldName() methods instead of this.
	 */
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = LanguagePeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	/**
	 * Translates a fieldname to another type
	 *
	 * @param      string $name field name
	 * @param      string $fromType One of the class type constants TYPE_PHPNAME,
	 *                         TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @param      string $toType   One of the class type constants
	 * @return     string translated name of the field.
	 */
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	/**
	 * Returns an array of of field names.
	 *
	 * @param      string $type The type of fieldnames to return:
	 *                      One of the class type constants TYPE_PHPNAME,
	 *                      TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     array A list of field names
	 */

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	/**
	 * Convenience method which changes table.column to alias.column.
	 *
	 * Using this method you can maintain SQL abstraction while using column aliases.
	 * <code>
	 *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
	 *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
	 * </code>
	 * @param      string $alias The alias for the current table.
	 * @param      string $column The column name for current table. (i.e. LanguagePeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(LanguagePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	/**
	 * Add all the columns needed to create a new object.
	 *
	 * Note: any columns that were marked with lazyLoad="true" in the
	 * XML schema will not be added to the select list and only loaded
	 * on demand.
	 *
	 * @param      criteria object containing the columns to add.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(LanguagePeer::CREATED_AT);

		$criteria->addSelectColumn(LanguagePeer::UPDATED_AT);

		$criteria->addSelectColumn(LanguagePeer::ID);

		$criteria->addSelectColumn(LanguagePeer::CURRENCY_ID);

		$criteria->addSelectColumn(LanguagePeer::ACTIVE_IMAGE);

		$criteria->addSelectColumn(LanguagePeer::INACTIVE_IMAGE);

		$criteria->addSelectColumn(LanguagePeer::SHORTCUT);

		$criteria->addSelectColumn(LanguagePeer::IS_DEFAULT);

		$criteria->addSelectColumn(LanguagePeer::ACTIVE);

		$criteria->addSelectColumn(LanguagePeer::LANGUAGE);

		$criteria->addSelectColumn(LanguagePeer::IS_TRANSLATE);

		$criteria->addSelectColumn(LanguagePeer::SYSTEM);

		$criteria->addSelectColumn(LanguagePeer::IS_DEFAULT_PANEL);

		$criteria->addSelectColumn(LanguagePeer::IS_TRANSLATE_PANEL);

		$criteria->addSelectColumn(LanguagePeer::OPT_NAME);


		if (stEventDispatcher::getInstance()->getListeners('LanguagePeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'LanguagePeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_language.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_language.ID)';

	/**
	 * Returns the number of rows matching criteria.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(LanguagePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LanguagePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = LanguagePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}
	/**
	 * Method to select one object from the DB.
	 *
	 * @param      Criteria $criteria object used to create the SELECT statement.
	 * @param      Connection $con
	 * @return     Language
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = LanguagePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	/**
	 * Method to do selects.
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      Connection $con
	 * @return     array Array of selected Objects
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return LanguagePeer::populateObjects(LanguagePeer::doSelectRS($criteria, $con));
	}
	/**
	 * Prepares the Criteria object and uses the parent doSelect()
	 * method to get a ResultSet.
	 *
	 * Use this method directly if you want to just get the resultset
	 * (instead of an array of objects).
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      Connection $con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @return     ResultSet The resultset object with numerically-indexed fields.
	 * @see        BasePeer::doSelect()
	 */
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			LanguagePeer::addSelectColumns($criteria);
		}

		if (stEventDispatcher::getInstance()->getListeners('BasePeer.preDoSelectRs')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'BasePeer.preDoSelectRs'));
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		// BasePeer returns a Creole ResultSet, set to return
		// rows indexed numerically.
		$rs =  BasePeer::doSelect($criteria, $con);

		if (stEventDispatcher::getInstance()->getListeners('BasePeer.postDoSelectRs')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($rs, 'BasePeer.postDoSelectRs'));
		}		

		return $rs;
	}
	/**
	 * The returned array will contain objects of the default type or
	 * objects that inherit from the default.
	 *
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function populateObjects(ResultSet $rs)
	{
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();
	
		// set the class once to avoid overhead in the loop
		$cls = LanguagePeer::getOMClass();
		$cls = Propel::import($cls);
		// populate the object(s)
		while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj) : $obj;
			
		}
		return $results;
	}

	/**
	 * Returns the number of rows matching criteria, joining the related Currency table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinCurrency(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(LanguagePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LanguagePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LanguagePeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$rs = LanguagePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Language objects pre-filled with their Currency objects.
	 *
	 * @return     array Array of Language objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinCurrency(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		LanguagePeer::addSelectColumns($c);

		CurrencyPeer::addSelectColumns($c);

		$c->addJoin(LanguagePeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);
		$rs = LanguagePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Language();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getCurrencyId())
                        {

			   $obj2 = new Currency();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addLanguage($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining all related tables
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(LanguagePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LanguagePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LanguagePeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$rs = LanguagePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Language objects pre-filled with all related objects.
	 *
	 * @return     array Array of Language objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAll(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		LanguagePeer::addSelectColumns($c);
		$startcol2 = (LanguagePeer::NUM_COLUMNS - LanguagePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CurrencyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CurrencyPeer::NUM_COLUMNS;

		$c->addJoin(LanguagePeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = LanguagePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined Currency rows
	
			$omClass = CurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCurrency(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addLanguage($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initLanguages();
				$obj2->addLanguage($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


     /**
      * Selects a collection of Language objects pre-filled with their i18n objects.
      *
      * @return array Array of Language objects.
      * @throws PropelException Any exceptions caught during processing will be
      *     rethrown wrapped into a PropelException.
      */
     public static function doSelectWithI18n(Criteria $c, $culture = null, $con = null)
     {
       $c = clone $c;

       if ($culture === null)
       {
         $culture = sfContext::getInstance()->getUser()->getCulture();
       }

       // Set the correct dbName if it has not been overridden
       if ($c->getDbName() == Propel::getDefaultDB())
       {
         $c->setDbName(self::DATABASE_NAME);
       }
      
       if (!$c->getSelectColumns())
       {
          LanguagePeer::addSelectColumns($c);
          LanguageI18nPeer::addSelectColumns($c);
       }

      $c->addJoin(LanguagePeer::ID, sprintf('%s AND %s = \'%s\'', LanguageI18nPeer::ID, LanguageI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

      $rs = LanguagePeer::doSelectRs($c, $con);

      if (self::$hydrateMethod)
      {
         return call_user_func(self::$hydrateMethod, $rs);
      }

      $results = array();

      while($rs->next()) {

         $obj1 = new Language();
         $startcol = $obj1->hydrate($rs);
         $obj1->setCulture($culture);

         $obj2 = new LanguageI18n();
         $obj2->hydrate($rs, $startcol);

         $obj1->setLanguageI18nForCulture($obj2, $culture);
         $obj2->setLanguage($obj1);

         $results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
       }
       return $results;
     }

	/**
	 * Returns the TableMap related to this peer.
	 * This method is not needed for general use but a specific application could have a need.
	 * @return     TableMap
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	/**
	 * The class that the Peer will make instances of.
	 *
	 * This uses a dot-path notation which is tranalted into a path
	 * relative to a location on the PHP include_path.
	 * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
	 *
	 * @return     string path.to.ClassName
	 */
	public static function getOMClass()
	{
		return LanguagePeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a Language or Criteria object.
	 *
	 * @param      mixed $values Criteria or Language object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseLanguagePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseLanguagePeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from Language object
		}

		$criteria->remove(LanguagePeer::ID); // remove pkey col since this table uses auto-increment


		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		try {
			// use transaction because $criteria could contain info
			// for more than one table (I guess, conceivably)
			$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseLanguagePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseLanguagePeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a Language or Criteria object.
	 *
	 * @param      mixed $values Criteria or Language object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseLanguagePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseLanguagePeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(LanguagePeer::ID);
			$selectCriteria->add(LanguagePeer::ID, $criteria->remove(LanguagePeer::ID), $comparison);

		} else { // $values is Language object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseLanguagePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseLanguagePeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_language table.
	 *
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += LanguagePeer::doOnDeleteCascade(new Criteria(), $con);
			LanguagePeer::doOnDeleteSetNull(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(LanguagePeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a Language or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or Language object or primary key or array of primary keys
	 *              which is used to create the DELETE statement
	 * @param      Connection $con the connection to use
	 * @return     int 	The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
	 *				if supported by native driver or if emulated using Propel.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(LanguagePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof Language) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(LanguagePeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += LanguagePeer::doOnDeleteCascade($criteria, $con);LanguagePeer::doOnDeleteSetNull($criteria, $con);
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * This is a method for emulating ON DELETE CASCADE for DBs that don't support this
	 * feature (like MySQL or SQLite).
	 *
	 * This method is not very speedy because it must perform a query first to get
	 * the implicated records and then perform the deletes by calling those Peer classes.
	 *
	 * This method should be used within a transaction if possible.
	 *
	 * @param      Criteria $criteria
	 * @param      Connection $con
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	protected static function doOnDeleteCascade(Criteria $criteria, Connection $con)
	{
		// initialize var to track total num of affected rows
		$affectedRows = 0;

		// first find the objects that are implicated by the $criteria
		$objects = LanguagePeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related LanguageHasDomain objects
			$c = new Criteria();
			
			$c->add(LanguageHasDomainPeer::LANGUAGE_ID, $obj->getId());
			$affectedRows += LanguageHasDomainPeer::doDelete($c, $con);

			// delete related LanguageI18n objects
			$c = new Criteria();
			
			$c->add(LanguageI18nPeer::ID, $obj->getId());
			$affectedRows += LanguageI18nPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	/**
	 * This is a method for emulating ON DELETE SET NULL DBs that don't support this
	 * feature (like MySQL or SQLite).
	 *
	 * This method is not very speedy because it must perform a query first to get
	 * the implicated records and then perform the deletes by calling those Peer classes.
	 *
	 * This method should be used within a transaction if possible.
	 *
	 * @param      Criteria $criteria
	 * @param      Connection $con
	 * @return     void
	 */
	protected static function doOnDeleteSetNull(Criteria $criteria, Connection $con)
	{

		// first find the objects that are implicated by the $criteria
		$objects = LanguagePeer::doSelect($criteria, $con);
		foreach($objects as $obj) {

			// set fkey col in related ProductHasAttachment rows to NULL
			$selectCriteria = new Criteria(LanguagePeer::DATABASE_NAME);
			$updateValues = new Criteria(LanguagePeer::DATABASE_NAME);
			$selectCriteria->add(ProductHasAttachmentPeer::LANGUAGE_ID, $obj->getId());
			$updateValues->add(ProductHasAttachmentPeer::LANGUAGE_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

		}
	}

	/**
	 * Validates all modified columns of given Language object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      Language $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(Language $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(LanguagePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(LanguagePeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(LanguagePeer::DATABASE_NAME, LanguagePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = LanguagePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      mixed $pk the primary key.
	 * @param      Connection $con the connection to use
	 * @return     Language
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(LanguagePeer::DATABASE_NAME);

		$criteria->add(LanguagePeer::ID, $pk);


		$v = LanguagePeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	/**
	 * Retrieve multiple objects by pkey.
	 *
	 * @param      array $pks List of primary keys
	 * @param      Connection $con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(LanguagePeer::ID, $pks, Criteria::IN);
			$objs = LanguagePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseLanguagePeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseLanguagePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stLanguagePlugin.lib.model.map.LanguageMapBuilder');
}
