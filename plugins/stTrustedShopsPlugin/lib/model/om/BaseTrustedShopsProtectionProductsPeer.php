<?php

/**
 * Base static class for performing query and update operations on the 'st_trusted_shops_protection_products' table.
 *
 * 
 *
 * @package    plugins.stTrustedShopsPlugin.lib.model.om
 */
abstract class BaseTrustedShopsProtectionProductsPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_trusted_shops_protection_products';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stTrustedShopsPlugin.lib.model.TrustedShopsProtectionProducts';

	/** The total number of columns. */
	const NUM_COLUMNS = 10;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_trusted_shops_protection_products.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_trusted_shops_protection_products.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_trusted_shops_protection_products.ID';

	/** the column name for the TRUSTED_SHOPS_ID field */
	const TRUSTED_SHOPS_ID = 'st_trusted_shops_protection_products.TRUSTED_SHOPS_ID';

	/** the column name for the CURRENCY field */
	const CURRENCY = 'st_trusted_shops_protection_products.CURRENCY';

	/** the column name for the GROSS field */
	const GROSS = 'st_trusted_shops_protection_products.GROSS';

	/** the column name for the NETTO field */
	const NETTO = 'st_trusted_shops_protection_products.NETTO';

	/** the column name for the AMOUNT field */
	const AMOUNT = 'st_trusted_shops_protection_products.AMOUNT';

	/** the column name for the DURATION field */
	const DURATION = 'st_trusted_shops_protection_products.DURATION';

	/** the column name for the PRODUCT_ID field */
	const PRODUCT_ID = 'st_trusted_shops_protection_products.PRODUCT_ID';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'TrustedShopsId', 'Currency', 'Gross', 'Netto', 'Amount', 'Duration', 'ProductId', ),
		BasePeer::TYPE_COLNAME => array (TrustedShopsProtectionProductsPeer::CREATED_AT, TrustedShopsProtectionProductsPeer::UPDATED_AT, TrustedShopsProtectionProductsPeer::ID, TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID, TrustedShopsProtectionProductsPeer::CURRENCY, TrustedShopsProtectionProductsPeer::GROSS, TrustedShopsProtectionProductsPeer::NETTO, TrustedShopsProtectionProductsPeer::AMOUNT, TrustedShopsProtectionProductsPeer::DURATION, TrustedShopsProtectionProductsPeer::PRODUCT_ID, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'trusted_shops_id', 'currency', 'gross', 'netto', 'amount', 'duration', 'product_id', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'TrustedShopsId' => 3, 'Currency' => 4, 'Gross' => 5, 'Netto' => 6, 'Amount' => 7, 'Duration' => 8, 'ProductId' => 9, ),
		BasePeer::TYPE_COLNAME => array (TrustedShopsProtectionProductsPeer::CREATED_AT => 0, TrustedShopsProtectionProductsPeer::UPDATED_AT => 1, TrustedShopsProtectionProductsPeer::ID => 2, TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID => 3, TrustedShopsProtectionProductsPeer::CURRENCY => 4, TrustedShopsProtectionProductsPeer::GROSS => 5, TrustedShopsProtectionProductsPeer::NETTO => 6, TrustedShopsProtectionProductsPeer::AMOUNT => 7, TrustedShopsProtectionProductsPeer::DURATION => 8, TrustedShopsProtectionProductsPeer::PRODUCT_ID => 9, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'trusted_shops_id' => 3, 'currency' => 4, 'gross' => 5, 'netto' => 6, 'amount' => 7, 'duration' => 8, 'product_id' => 9, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
		return BasePeer::getMapBuilder('plugins.stTrustedShopsPlugin.lib.model.map.TrustedShopsProtectionProductsMapBuilder');
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
			$map = TrustedShopsProtectionProductsPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. TrustedShopsProtectionProductsPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(TrustedShopsProtectionProductsPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::CREATED_AT);

		$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::UPDATED_AT);

		$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::ID);

		$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID);

		$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::CURRENCY);

		$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::GROSS);

		$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::NETTO);

		$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::AMOUNT);

		$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::DURATION);

		$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::PRODUCT_ID);


		if (stEventDispatcher::getInstance()->getListeners('TrustedShopsProtectionProductsPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'TrustedShopsProtectionProductsPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_trusted_shops_protection_products.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_trusted_shops_protection_products.ID)';

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
			$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = TrustedShopsProtectionProductsPeer::doSelectRS($criteria, $con);
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
	 * @return     TrustedShopsProtectionProducts
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = TrustedShopsProtectionProductsPeer::doSelect($critcopy, $con);
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
		return TrustedShopsProtectionProductsPeer::populateObjects(TrustedShopsProtectionProductsPeer::doSelectRS($criteria, $con));
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
			TrustedShopsProtectionProductsPeer::addSelectColumns($criteria);
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
		$cls = TrustedShopsProtectionProductsPeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related TrustedShops table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinTrustedShops(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID, TrustedShopsPeer::ID);

		$rs = TrustedShopsProtectionProductsPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of TrustedShopsProtectionProducts objects pre-filled with their TrustedShops objects.
	 *
	 * @return     array Array of TrustedShopsProtectionProducts objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinTrustedShops(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TrustedShopsProtectionProductsPeer::addSelectColumns($c);

		TrustedShopsPeer::addSelectColumns($c);

		$c->addJoin(TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID, TrustedShopsPeer::ID);
		$rs = TrustedShopsProtectionProductsPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new TrustedShopsProtectionProducts();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getTrustedShopsId())
                        {

			   $obj2 = new TrustedShops();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addTrustedShopsProtectionProducts($obj1);
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
			$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TrustedShopsProtectionProductsPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID, TrustedShopsPeer::ID);

		$rs = TrustedShopsProtectionProductsPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of TrustedShopsProtectionProducts objects pre-filled with all related objects.
	 *
	 * @return     array Array of TrustedShopsProtectionProducts objects.
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

		TrustedShopsProtectionProductsPeer::addSelectColumns($c);
		$startcol2 = (TrustedShopsProtectionProductsPeer::NUM_COLUMNS - TrustedShopsProtectionProductsPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		TrustedShopsPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + TrustedShopsPeer::NUM_COLUMNS;

		$c->addJoin(TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID, TrustedShopsPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = TrustedShopsProtectionProductsPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined TrustedShops rows
	
			$omClass = TrustedShopsPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getTrustedShops(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addTrustedShopsProtectionProducts($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initTrustedShopsProtectionProductss();
				$obj2->addTrustedShopsProtectionProducts($obj1);
			}

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
		return TrustedShopsProtectionProductsPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a TrustedShopsProtectionProducts or Criteria object.
	 *
	 * @param      mixed $values Criteria or TrustedShopsProtectionProducts object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseTrustedShopsProtectionProductsPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseTrustedShopsProtectionProductsPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from TrustedShopsProtectionProducts object
		}

		$criteria->remove(TrustedShopsProtectionProductsPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseTrustedShopsProtectionProductsPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseTrustedShopsProtectionProductsPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a TrustedShopsProtectionProducts or Criteria object.
	 *
	 * @param      mixed $values Criteria or TrustedShopsProtectionProducts object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseTrustedShopsProtectionProductsPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseTrustedShopsProtectionProductsPeer', $values, $con);
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

			$comparison = $criteria->getComparison(TrustedShopsProtectionProductsPeer::ID);
			$selectCriteria->add(TrustedShopsProtectionProductsPeer::ID, $criteria->remove(TrustedShopsProtectionProductsPeer::ID), $comparison);

		} else { // $values is TrustedShopsProtectionProducts object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseTrustedShopsProtectionProductsPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseTrustedShopsProtectionProductsPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_trusted_shops_protection_products table.
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
			$affectedRows += BasePeer::doDeleteAll(TrustedShopsProtectionProductsPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a TrustedShopsProtectionProducts or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or TrustedShopsProtectionProducts object or primary key or array of primary keys
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
			$con = Propel::getConnection(TrustedShopsProtectionProductsPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof TrustedShopsProtectionProducts) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(TrustedShopsProtectionProductsPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Validates all modified columns of given TrustedShopsProtectionProducts object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      TrustedShopsProtectionProducts $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(TrustedShopsProtectionProducts $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(TrustedShopsProtectionProductsPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(TrustedShopsProtectionProductsPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(TrustedShopsProtectionProductsPeer::DATABASE_NAME, TrustedShopsProtectionProductsPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = TrustedShopsProtectionProductsPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     TrustedShopsProtectionProducts
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(TrustedShopsProtectionProductsPeer::DATABASE_NAME);

		$criteria->add(TrustedShopsProtectionProductsPeer::ID, $pk);


		$v = TrustedShopsProtectionProductsPeer::doSelect($criteria, $con);

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
			$criteria->add(TrustedShopsProtectionProductsPeer::ID, $pks, Criteria::IN);
			$objs = TrustedShopsProtectionProductsPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseTrustedShopsProtectionProductsPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseTrustedShopsProtectionProductsPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stTrustedShopsPlugin.lib.model.map.TrustedShopsProtectionProductsMapBuilder');
}
