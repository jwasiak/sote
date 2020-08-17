<?php

/**
 * Base static class for performing query and update operations on the 'st_trusted_shops_has_order' table.
 *
 * 
 *
 * @package    plugins.stTrustedShopsPlugin.lib.model.om
 */
abstract class BaseTrustedShopsHasOrderPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_trusted_shops_has_order';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stTrustedShopsPlugin.lib.model.TrustedShopsHasOrder';

	/** The total number of columns. */
	const NUM_COLUMNS = 6;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_trusted_shops_has_order.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_trusted_shops_has_order.UPDATED_AT';

	/** the column name for the TRUSTED_SHOPS_ID field */
	const TRUSTED_SHOPS_ID = 'st_trusted_shops_has_order.TRUSTED_SHOPS_ID';

	/** the column name for the ORDER_ID field */
	const ORDER_ID = 'st_trusted_shops_has_order.ORDER_ID';

	/** the column name for the STATUS field */
	const STATUS = 'st_trusted_shops_has_order.STATUS';

	/** the column name for the CHECKED field */
	const CHECKED = 'st_trusted_shops_has_order.CHECKED';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'TrustedShopsId', 'OrderId', 'Status', 'Checked', ),
		BasePeer::TYPE_COLNAME => array (TrustedShopsHasOrderPeer::CREATED_AT, TrustedShopsHasOrderPeer::UPDATED_AT, TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID, TrustedShopsHasOrderPeer::ORDER_ID, TrustedShopsHasOrderPeer::STATUS, TrustedShopsHasOrderPeer::CHECKED, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'trusted_shops_id', 'order_id', 'status', 'checked', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'TrustedShopsId' => 2, 'OrderId' => 3, 'Status' => 4, 'Checked' => 5, ),
		BasePeer::TYPE_COLNAME => array (TrustedShopsHasOrderPeer::CREATED_AT => 0, TrustedShopsHasOrderPeer::UPDATED_AT => 1, TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID => 2, TrustedShopsHasOrderPeer::ORDER_ID => 3, TrustedShopsHasOrderPeer::STATUS => 4, TrustedShopsHasOrderPeer::CHECKED => 5, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'trusted_shops_id' => 2, 'order_id' => 3, 'status' => 4, 'checked' => 5, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
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
		return BasePeer::getMapBuilder('plugins.stTrustedShopsPlugin.lib.model.map.TrustedShopsHasOrderMapBuilder');
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
			$map = TrustedShopsHasOrderPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. TrustedShopsHasOrderPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(TrustedShopsHasOrderPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(TrustedShopsHasOrderPeer::CREATED_AT);

		$criteria->addSelectColumn(TrustedShopsHasOrderPeer::UPDATED_AT);

		$criteria->addSelectColumn(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID);

		$criteria->addSelectColumn(TrustedShopsHasOrderPeer::ORDER_ID);

		$criteria->addSelectColumn(TrustedShopsHasOrderPeer::STATUS);

		$criteria->addSelectColumn(TrustedShopsHasOrderPeer::CHECKED);


		if (stEventDispatcher::getInstance()->getListeners('TrustedShopsHasOrderPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'TrustedShopsHasOrderPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_trusted_shops_has_order.TRUSTED_SHOPS_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_trusted_shops_has_order.TRUSTED_SHOPS_ID)';

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
			$criteria->addSelectColumn(TrustedShopsHasOrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TrustedShopsHasOrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = TrustedShopsHasOrderPeer::doSelectRS($criteria, $con);
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
	 * @return     TrustedShopsHasOrder
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = TrustedShopsHasOrderPeer::doSelect($critcopy, $con);
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
		return TrustedShopsHasOrderPeer::populateObjects(TrustedShopsHasOrderPeer::doSelectRS($criteria, $con));
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
			TrustedShopsHasOrderPeer::addSelectColumns($criteria);
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
		$cls = TrustedShopsHasOrderPeer::getOMClass();
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
			$criteria->addSelectColumn(TrustedShopsHasOrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TrustedShopsHasOrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID, TrustedShopsPeer::ID);

		$rs = TrustedShopsHasOrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Order table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinOrder(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TrustedShopsHasOrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TrustedShopsHasOrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TrustedShopsHasOrderPeer::ORDER_ID, OrderPeer::ID);

		$rs = TrustedShopsHasOrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of TrustedShopsHasOrder objects pre-filled with their TrustedShops objects.
	 *
	 * @return     array Array of TrustedShopsHasOrder objects.
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

		TrustedShopsHasOrderPeer::addSelectColumns($c);

		TrustedShopsPeer::addSelectColumns($c);

		$c->addJoin(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID, TrustedShopsPeer::ID);
		$rs = TrustedShopsHasOrderPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new TrustedShopsHasOrder();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getTrustedShopsId())
                        {

			   $obj2 = new TrustedShops();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addTrustedShopsHasOrder($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of TrustedShopsHasOrder objects pre-filled with their Order objects.
	 *
	 * @return     array Array of TrustedShopsHasOrder objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinOrder(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TrustedShopsHasOrderPeer::addSelectColumns($c);

		OrderPeer::addSelectColumns($c);

		$c->addJoin(TrustedShopsHasOrderPeer::ORDER_ID, OrderPeer::ID);
		$rs = TrustedShopsHasOrderPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new TrustedShopsHasOrder();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getOrderId())
                        {

			   $obj2 = new Order();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addTrustedShopsHasOrder($obj1);
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
			$criteria->addSelectColumn(TrustedShopsHasOrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TrustedShopsHasOrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID, TrustedShopsPeer::ID);

		$criteria->addJoin(TrustedShopsHasOrderPeer::ORDER_ID, OrderPeer::ID);

		$rs = TrustedShopsHasOrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of TrustedShopsHasOrder objects pre-filled with all related objects.
	 *
	 * @return     array Array of TrustedShopsHasOrder objects.
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

		TrustedShopsHasOrderPeer::addSelectColumns($c);
		$startcol2 = (TrustedShopsHasOrderPeer::NUM_COLUMNS - TrustedShopsHasOrderPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		TrustedShopsPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + TrustedShopsPeer::NUM_COLUMNS;

		OrderPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OrderPeer::NUM_COLUMNS;

		$c->addJoin(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID, TrustedShopsPeer::ID);

		$c->addJoin(TrustedShopsHasOrderPeer::ORDER_ID, OrderPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = TrustedShopsHasOrderPeer::getOMClass();


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
					$temp_obj2->addTrustedShopsHasOrder($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initTrustedShopsHasOrders();
				$obj2->addTrustedShopsHasOrder($obj1);
			}


				// Add objects for joined Order rows
	
			$omClass = OrderPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOrder(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addTrustedShopsHasOrder($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initTrustedShopsHasOrders();
				$obj3->addTrustedShopsHasOrder($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
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
	public static function doCountJoinAllExceptTrustedShops(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TrustedShopsHasOrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TrustedShopsHasOrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TrustedShopsHasOrderPeer::ORDER_ID, OrderPeer::ID);

		$rs = TrustedShopsHasOrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Order table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptOrder(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TrustedShopsHasOrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TrustedShopsHasOrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID, TrustedShopsPeer::ID);

		$rs = TrustedShopsHasOrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of TrustedShopsHasOrder objects pre-filled with all related objects except TrustedShops.
	 *
	 * @return     array Array of TrustedShopsHasOrder objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptTrustedShops(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TrustedShopsHasOrderPeer::addSelectColumns($c);
		$startcol2 = (TrustedShopsHasOrderPeer::NUM_COLUMNS - TrustedShopsHasOrderPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderPeer::NUM_COLUMNS;

		$c->addJoin(TrustedShopsHasOrderPeer::ORDER_ID, OrderPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = TrustedShopsHasOrderPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OrderPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrder(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addTrustedShopsHasOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initTrustedShopsHasOrders();
				$obj2->addTrustedShopsHasOrder($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of TrustedShopsHasOrder objects pre-filled with all related objects except Order.
	 *
	 * @return     array Array of TrustedShopsHasOrder objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptOrder(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TrustedShopsHasOrderPeer::addSelectColumns($c);
		$startcol2 = (TrustedShopsHasOrderPeer::NUM_COLUMNS - TrustedShopsHasOrderPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		TrustedShopsPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + TrustedShopsPeer::NUM_COLUMNS;

		$c->addJoin(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID, TrustedShopsPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = TrustedShopsHasOrderPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = TrustedShopsPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getTrustedShops(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addTrustedShopsHasOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initTrustedShopsHasOrders();
				$obj2->addTrustedShopsHasOrder($obj1);
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
		return TrustedShopsHasOrderPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a TrustedShopsHasOrder or Criteria object.
	 *
	 * @param      mixed $values Criteria or TrustedShopsHasOrder object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseTrustedShopsHasOrderPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseTrustedShopsHasOrderPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from TrustedShopsHasOrder object
		}


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

		
    foreach (sfMixer::getCallables('BaseTrustedShopsHasOrderPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseTrustedShopsHasOrderPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a TrustedShopsHasOrder or Criteria object.
	 *
	 * @param      mixed $values Criteria or TrustedShopsHasOrder object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseTrustedShopsHasOrderPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseTrustedShopsHasOrderPeer', $values, $con);
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

			$comparison = $criteria->getComparison(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID);
			$selectCriteria->add(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID, $criteria->remove(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID), $comparison);

			$comparison = $criteria->getComparison(TrustedShopsHasOrderPeer::ORDER_ID);
			$selectCriteria->add(TrustedShopsHasOrderPeer::ORDER_ID, $criteria->remove(TrustedShopsHasOrderPeer::ORDER_ID), $comparison);

		} else { // $values is TrustedShopsHasOrder object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseTrustedShopsHasOrderPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseTrustedShopsHasOrderPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_trusted_shops_has_order table.
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
			$affectedRows += BasePeer::doDeleteAll(TrustedShopsHasOrderPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a TrustedShopsHasOrder or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or TrustedShopsHasOrder object or primary key or array of primary keys
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
			$con = Propel::getConnection(TrustedShopsHasOrderPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof TrustedShopsHasOrder) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			// primary key is composite; we therefore, expect
			// the primary key passed to be an array of pkey
			// values
			if(count($values) == count($values, COUNT_RECURSIVE))
			{
				// array is not multi-dimensional
				$values = array($values);
			}
			$vals = array();
			foreach($values as $value)
			{

				$vals[0][] = $value[0];
				$vals[1][] = $value[1];
			}

			$criteria->add(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID, $vals[0], Criteria::IN);
			$criteria->add(TrustedShopsHasOrderPeer::ORDER_ID, $vals[1], Criteria::IN);
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
	 * Validates all modified columns of given TrustedShopsHasOrder object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      TrustedShopsHasOrder $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(TrustedShopsHasOrder $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(TrustedShopsHasOrderPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(TrustedShopsHasOrderPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(TrustedShopsHasOrderPeer::DATABASE_NAME, TrustedShopsHasOrderPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = TrustedShopsHasOrderPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	/**
	 * Retrieve object using using composite pkey values.
	 * @param int $trusted_shops_id
	   @param int $order_id
	   
	 * @param      Connection $con
	 * @return     TrustedShopsHasOrder
	 */
	public static function retrieveByPK( $trusted_shops_id, $order_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID, $trusted_shops_id);
		$criteria->add(TrustedShopsHasOrderPeer::ORDER_ID, $order_id);
		$v = TrustedShopsHasOrderPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} // BaseTrustedShopsHasOrderPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseTrustedShopsHasOrderPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stTrustedShopsPlugin.lib.model.map.TrustedShopsHasOrderMapBuilder');
}
