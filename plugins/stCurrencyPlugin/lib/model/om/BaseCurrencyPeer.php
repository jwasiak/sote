<?php

/**
 * Base static class for performing query and update operations on the 'st_currency' table.
 *
 * 
 *
 * @package    plugins.stCurrencyPlugin.lib.model.om
 */
abstract class BaseCurrencyPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_currency';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stCurrencyPlugin.lib.model.Currency';

	/** The total number of columns. */
	const NUM_COLUMNS = 13;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_currency.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_currency.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_currency.ID';

	/** the column name for the CURRENCY_STANDARD_ID field */
	const CURRENCY_STANDARD_ID = 'st_currency.CURRENCY_STANDARD_ID';

	/** the column name for the SHORTCUT field */
	const SHORTCUT = 'st_currency.SHORTCUT';

	/** the column name for the EXCHANGE field */
	const EXCHANGE = 'st_currency.EXCHANGE';

	/** the column name for the ACTIVE field */
	const ACTIVE = 'st_currency.ACTIVE';

	/** the column name for the MAIN field */
	const MAIN = 'st_currency.MAIN';

	/** the column name for the FRONT_SYMBOL field */
	const FRONT_SYMBOL = 'st_currency.FRONT_SYMBOL';

	/** the column name for the BACK_SYMBOL field */
	const BACK_SYMBOL = 'st_currency.BACK_SYMBOL';

	/** the column name for the NBP_EXCHANGE field */
	const NBP_EXCHANGE = 'st_currency.NBP_EXCHANGE';

	/** the column name for the SYSTEM field */
	const SYSTEM = 'st_currency.SYSTEM';

	/** the column name for the OPT_NAME field */
	const OPT_NAME = 'st_currency.OPT_NAME';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'CurrencyStandardId', 'Shortcut', 'Exchange', 'Active', 'Main', 'FrontSymbol', 'BackSymbol', 'NbpExchange', 'System', 'OptName', ),
		BasePeer::TYPE_COLNAME => array (CurrencyPeer::CREATED_AT, CurrencyPeer::UPDATED_AT, CurrencyPeer::ID, CurrencyPeer::CURRENCY_STANDARD_ID, CurrencyPeer::SHORTCUT, CurrencyPeer::EXCHANGE, CurrencyPeer::ACTIVE, CurrencyPeer::MAIN, CurrencyPeer::FRONT_SYMBOL, CurrencyPeer::BACK_SYMBOL, CurrencyPeer::NBP_EXCHANGE, CurrencyPeer::SYSTEM, CurrencyPeer::OPT_NAME, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'currency_standard_id', 'shortcut', 'exchange', 'active', 'main', 'front_symbol', 'back_symbol', 'nbp_exchange', 'system', 'opt_name', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'CurrencyStandardId' => 3, 'Shortcut' => 4, 'Exchange' => 5, 'Active' => 6, 'Main' => 7, 'FrontSymbol' => 8, 'BackSymbol' => 9, 'NbpExchange' => 10, 'System' => 11, 'OptName' => 12, ),
		BasePeer::TYPE_COLNAME => array (CurrencyPeer::CREATED_AT => 0, CurrencyPeer::UPDATED_AT => 1, CurrencyPeer::ID => 2, CurrencyPeer::CURRENCY_STANDARD_ID => 3, CurrencyPeer::SHORTCUT => 4, CurrencyPeer::EXCHANGE => 5, CurrencyPeer::ACTIVE => 6, CurrencyPeer::MAIN => 7, CurrencyPeer::FRONT_SYMBOL => 8, CurrencyPeer::BACK_SYMBOL => 9, CurrencyPeer::NBP_EXCHANGE => 10, CurrencyPeer::SYSTEM => 11, CurrencyPeer::OPT_NAME => 12, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'currency_standard_id' => 3, 'shortcut' => 4, 'exchange' => 5, 'active' => 6, 'main' => 7, 'front_symbol' => 8, 'back_symbol' => 9, 'nbp_exchange' => 10, 'system' => 11, 'opt_name' => 12, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
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
		return BasePeer::getMapBuilder('plugins.stCurrencyPlugin.lib.model.map.CurrencyMapBuilder');
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
			$map = CurrencyPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. CurrencyPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(CurrencyPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(CurrencyPeer::CREATED_AT);

		$criteria->addSelectColumn(CurrencyPeer::UPDATED_AT);

		$criteria->addSelectColumn(CurrencyPeer::ID);

		$criteria->addSelectColumn(CurrencyPeer::CURRENCY_STANDARD_ID);

		$criteria->addSelectColumn(CurrencyPeer::SHORTCUT);

		$criteria->addSelectColumn(CurrencyPeer::EXCHANGE);

		$criteria->addSelectColumn(CurrencyPeer::ACTIVE);

		$criteria->addSelectColumn(CurrencyPeer::MAIN);

		$criteria->addSelectColumn(CurrencyPeer::FRONT_SYMBOL);

		$criteria->addSelectColumn(CurrencyPeer::BACK_SYMBOL);

		$criteria->addSelectColumn(CurrencyPeer::NBP_EXCHANGE);

		$criteria->addSelectColumn(CurrencyPeer::SYSTEM);

		$criteria->addSelectColumn(CurrencyPeer::OPT_NAME);


		if (stEventDispatcher::getInstance()->getListeners('CurrencyPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'CurrencyPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_currency.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_currency.ID)';

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
			$criteria->addSelectColumn(CurrencyPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(CurrencyPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = CurrencyPeer::doSelectRS($criteria, $con);
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
	 * @return     Currency
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = CurrencyPeer::doSelect($critcopy, $con);
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
		return CurrencyPeer::populateObjects(CurrencyPeer::doSelectRS($criteria, $con));
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
			CurrencyPeer::addSelectColumns($criteria);
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
		$cls = CurrencyPeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related CurrencyStandard table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinCurrencyStandard(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(CurrencyPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(CurrencyPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(CurrencyPeer::CURRENCY_STANDARD_ID, CurrencyStandardPeer::ID, Criteria::LEFT_JOIN);

		$rs = CurrencyPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Currency objects pre-filled with their CurrencyStandard objects.
	 *
	 * @return     array Array of Currency objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinCurrencyStandard(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		CurrencyPeer::addSelectColumns($c);

		CurrencyStandardPeer::addSelectColumns($c);

		$c->addJoin(CurrencyPeer::CURRENCY_STANDARD_ID, CurrencyStandardPeer::ID, Criteria::LEFT_JOIN);
		$rs = CurrencyPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Currency();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getCurrencyStandardId())
                        {

			   $obj2 = new CurrencyStandard();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addCurrency($obj1);
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
			$criteria->addSelectColumn(CurrencyPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(CurrencyPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(CurrencyPeer::CURRENCY_STANDARD_ID, CurrencyStandardPeer::ID, Criteria::LEFT_JOIN);

		$rs = CurrencyPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Currency objects pre-filled with all related objects.
	 *
	 * @return     array Array of Currency objects.
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

		CurrencyPeer::addSelectColumns($c);
		$startcol2 = (CurrencyPeer::NUM_COLUMNS - CurrencyPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CurrencyStandardPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CurrencyStandardPeer::NUM_COLUMNS;

		$c->addJoin(CurrencyPeer::CURRENCY_STANDARD_ID, CurrencyStandardPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = CurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined CurrencyStandard rows
	
			$omClass = CurrencyStandardPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCurrencyStandard(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addCurrency($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initCurrencys();
				$obj2->addCurrency($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


     /**
      * Selects a collection of Currency objects pre-filled with their i18n objects.
      *
      * @return array Array of Currency objects.
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
          CurrencyPeer::addSelectColumns($c);
          CurrencyI18nPeer::addSelectColumns($c);
       }

      $c->addJoin(CurrencyPeer::ID, sprintf('%s AND %s = \'%s\'', CurrencyI18nPeer::ID, CurrencyI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

      $rs = CurrencyPeer::doSelectRs($c, $con);

      if (self::$hydrateMethod)
      {
         return call_user_func(self::$hydrateMethod, $rs);
      }

      $results = array();

      while($rs->next()) {

         $obj1 = new Currency();
         $startcol = $obj1->hydrate($rs);
         $obj1->setCulture($culture);

         $obj2 = new CurrencyI18n();
         $obj2->hydrate($rs, $startcol);

         $obj1->setCurrencyI18nForCulture($obj2, $culture);
         $obj2->setCurrency($obj1);

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
		return CurrencyPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a Currency or Criteria object.
	 *
	 * @param      mixed $values Criteria or Currency object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseCurrencyPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCurrencyPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from Currency object
		}

		$criteria->remove(CurrencyPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseCurrencyPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseCurrencyPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a Currency or Criteria object.
	 *
	 * @param      mixed $values Criteria or Currency object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseCurrencyPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCurrencyPeer', $values, $con);
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

			$comparison = $criteria->getComparison(CurrencyPeer::ID);
			$selectCriteria->add(CurrencyPeer::ID, $criteria->remove(CurrencyPeer::ID), $comparison);

		} else { // $values is Currency object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseCurrencyPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseCurrencyPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_currency table.
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
			$affectedRows += CurrencyPeer::doOnDeleteCascade(new Criteria(), $con);
			CurrencyPeer::doOnDeleteSetNull(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(CurrencyPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a Currency or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or Currency object or primary key or array of primary keys
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
			$con = Propel::getConnection(CurrencyPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof Currency) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(CurrencyPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += CurrencyPeer::doOnDeleteCascade($criteria, $con);CurrencyPeer::doOnDeleteSetNull($criteria, $con);
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
		$objects = CurrencyPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related AddPrice objects
			$c = new Criteria();
			
			$c->add(AddPricePeer::CURRENCY_ID, $obj->getId());
			$affectedRows += AddPricePeer::doDelete($c, $con);

			// delete related AddGroupPrice objects
			$c = new Criteria();
			
			$c->add(AddGroupPricePeer::CURRENCY_ID, $obj->getId());
			$affectedRows += AddGroupPricePeer::doDelete($c, $con);

			// delete related CurrencyI18n objects
			$c = new Criteria();
			
			$c->add(CurrencyI18nPeer::ID, $obj->getId());
			$affectedRows += CurrencyI18nPeer::doDelete($c, $con);

			// delete related GiftCard objects
			$c = new Criteria();
			
			$c->add(GiftCardPeer::CURRENCY_ID, $obj->getId());
			$affectedRows += GiftCardPeer::doDelete($c, $con);
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
		$objects = CurrencyPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {

			// set fkey col in related Product rows to NULL
			$selectCriteria = new Criteria(CurrencyPeer::DATABASE_NAME);
			$updateValues = new Criteria(CurrencyPeer::DATABASE_NAME);
			$selectCriteria->add(ProductPeer::CURRENCY_ID, $obj->getId());
			$updateValues->add(ProductPeer::CURRENCY_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related GroupPrice rows to NULL
			$selectCriteria = new Criteria(CurrencyPeer::DATABASE_NAME);
			$updateValues = new Criteria(CurrencyPeer::DATABASE_NAME);
			$selectCriteria->add(GroupPricePeer::CURRENCY_ID, $obj->getId());
			$updateValues->add(GroupPricePeer::CURRENCY_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Language rows to NULL
			$selectCriteria = new Criteria(CurrencyPeer::DATABASE_NAME);
			$updateValues = new Criteria(CurrencyPeer::DATABASE_NAME);
			$selectCriteria->add(LanguagePeer::CURRENCY_ID, $obj->getId());
			$updateValues->add(LanguagePeer::CURRENCY_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

		}
	}

	/**
	 * Validates all modified columns of given Currency object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      Currency $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(Currency $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(CurrencyPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(CurrencyPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(CurrencyPeer::DATABASE_NAME, CurrencyPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = CurrencyPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     Currency
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(CurrencyPeer::DATABASE_NAME);

		$criteria->add(CurrencyPeer::ID, $pk);


		$v = CurrencyPeer::doSelect($criteria, $con);

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
			$criteria->add(CurrencyPeer::ID, $pks, Criteria::IN);
			$objs = CurrencyPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseCurrencyPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseCurrencyPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stCurrencyPlugin.lib.model.map.CurrencyMapBuilder');
}
