<?php

/**
 * Base static class for performing query and update operations on the 'st_delivery_has_payment_type' table.
 *
 * 
 *
 * @package    plugins.stDeliveryPlugin.lib.model.om
 */
abstract class BaseDeliveryHasPaymentTypePeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_delivery_has_payment_type';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stDeliveryPlugin.lib.model.DeliveryHasPaymentType';

	/** The total number of columns. */
	const NUM_COLUMNS = 10;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the ID field */
	const ID = 'st_delivery_has_payment_type.ID';

	/** the column name for the PAYMENT_TYPE_ID field */
	const PAYMENT_TYPE_ID = 'st_delivery_has_payment_type.PAYMENT_TYPE_ID';

	/** the column name for the DELIVERY_ID field */
	const DELIVERY_ID = 'st_delivery_has_payment_type.DELIVERY_ID';

	/** the column name for the IS_ACTIVE field */
	const IS_ACTIVE = 'st_delivery_has_payment_type.IS_ACTIVE';

	/** the column name for the IS_DEFAULT field */
	const IS_DEFAULT = 'st_delivery_has_payment_type.IS_DEFAULT';

	/** the column name for the COST field */
	const COST = 'st_delivery_has_payment_type.COST';

	/** the column name for the COST_BRUTTO field */
	const COST_BRUTTO = 'st_delivery_has_payment_type.COST_BRUTTO';

	/** the column name for the FREE_FROM field */
	const FREE_FROM = 'st_delivery_has_payment_type.FREE_FROM';

	/** the column name for the COST_TYPE field */
	const COST_TYPE = 'st_delivery_has_payment_type.COST_TYPE';

	/** the column name for the COURIER_COST field */
	const COURIER_COST = 'st_delivery_has_payment_type.COURIER_COST';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'PaymentTypeId', 'DeliveryId', 'IsActive', 'IsDefault', 'Cost', 'CostBrutto', 'FreeFrom', 'CostType', 'CourierCost', ),
		BasePeer::TYPE_COLNAME => array (DeliveryHasPaymentTypePeer::ID, DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID, DeliveryHasPaymentTypePeer::DELIVERY_ID, DeliveryHasPaymentTypePeer::IS_ACTIVE, DeliveryHasPaymentTypePeer::IS_DEFAULT, DeliveryHasPaymentTypePeer::COST, DeliveryHasPaymentTypePeer::COST_BRUTTO, DeliveryHasPaymentTypePeer::FREE_FROM, DeliveryHasPaymentTypePeer::COST_TYPE, DeliveryHasPaymentTypePeer::COURIER_COST, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'payment_type_id', 'delivery_id', 'is_active', 'is_default', 'cost', 'cost_brutto', 'free_from', 'cost_type', 'courier_cost', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'PaymentTypeId' => 1, 'DeliveryId' => 2, 'IsActive' => 3, 'IsDefault' => 4, 'Cost' => 5, 'CostBrutto' => 6, 'FreeFrom' => 7, 'CostType' => 8, 'CourierCost' => 9, ),
		BasePeer::TYPE_COLNAME => array (DeliveryHasPaymentTypePeer::ID => 0, DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID => 1, DeliveryHasPaymentTypePeer::DELIVERY_ID => 2, DeliveryHasPaymentTypePeer::IS_ACTIVE => 3, DeliveryHasPaymentTypePeer::IS_DEFAULT => 4, DeliveryHasPaymentTypePeer::COST => 5, DeliveryHasPaymentTypePeer::COST_BRUTTO => 6, DeliveryHasPaymentTypePeer::FREE_FROM => 7, DeliveryHasPaymentTypePeer::COST_TYPE => 8, DeliveryHasPaymentTypePeer::COURIER_COST => 9, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'payment_type_id' => 1, 'delivery_id' => 2, 'is_active' => 3, 'is_default' => 4, 'cost' => 5, 'cost_brutto' => 6, 'free_from' => 7, 'cost_type' => 8, 'courier_cost' => 9, ),
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
		return BasePeer::getMapBuilder('plugins.stDeliveryPlugin.lib.model.map.DeliveryHasPaymentTypeMapBuilder');
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
			$map = DeliveryHasPaymentTypePeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. DeliveryHasPaymentTypePeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(DeliveryHasPaymentTypePeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::ID);

		$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID);

		$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::DELIVERY_ID);

		$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::IS_ACTIVE);

		$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::IS_DEFAULT);

		$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COST);

		$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COST_BRUTTO);

		$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::FREE_FROM);

		$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COST_TYPE);

		$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COURIER_COST);


		if (stEventDispatcher::getInstance()->getListeners('DeliveryHasPaymentTypePeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'DeliveryHasPaymentTypePeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_delivery_has_payment_type.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_delivery_has_payment_type.ID)';

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
			$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = DeliveryHasPaymentTypePeer::doSelectRS($criteria, $con);
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
	 * @return     DeliveryHasPaymentType
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = DeliveryHasPaymentTypePeer::doSelect($critcopy, $con);
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
		return DeliveryHasPaymentTypePeer::populateObjects(DeliveryHasPaymentTypePeer::doSelectRS($criteria, $con));
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
			DeliveryHasPaymentTypePeer::addSelectColumns($criteria);
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
		$cls = DeliveryHasPaymentTypePeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related PaymentType table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinPaymentType(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID, PaymentTypePeer::ID);

		$rs = DeliveryHasPaymentTypePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Delivery table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinDelivery(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DeliveryHasPaymentTypePeer::DELIVERY_ID, DeliveryPeer::ID);

		$rs = DeliveryHasPaymentTypePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of DeliveryHasPaymentType objects pre-filled with their PaymentType objects.
	 *
	 * @return     array Array of DeliveryHasPaymentType objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinPaymentType(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DeliveryHasPaymentTypePeer::addSelectColumns($c);

		PaymentTypePeer::addSelectColumns($c);

		$c->addJoin(DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID, PaymentTypePeer::ID);
		$rs = DeliveryHasPaymentTypePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new DeliveryHasPaymentType();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getPaymentTypeId())
                        {

			   $obj2 = new PaymentType();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addDeliveryHasPaymentType($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of DeliveryHasPaymentType objects pre-filled with their Delivery objects.
	 *
	 * @return     array Array of DeliveryHasPaymentType objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinDelivery(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DeliveryHasPaymentTypePeer::addSelectColumns($c);

		DeliveryPeer::addSelectColumns($c);

		$c->addJoin(DeliveryHasPaymentTypePeer::DELIVERY_ID, DeliveryPeer::ID);
		$rs = DeliveryHasPaymentTypePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new DeliveryHasPaymentType();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getDeliveryId())
                        {

			   $obj2 = new Delivery();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addDeliveryHasPaymentType($obj1);
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
			$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID, PaymentTypePeer::ID);

		$criteria->addJoin(DeliveryHasPaymentTypePeer::DELIVERY_ID, DeliveryPeer::ID);

		$rs = DeliveryHasPaymentTypePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of DeliveryHasPaymentType objects pre-filled with all related objects.
	 *
	 * @return     array Array of DeliveryHasPaymentType objects.
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

		DeliveryHasPaymentTypePeer::addSelectColumns($c);
		$startcol2 = (DeliveryHasPaymentTypePeer::NUM_COLUMNS - DeliveryHasPaymentTypePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		PaymentTypePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + PaymentTypePeer::NUM_COLUMNS;

		DeliveryPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DeliveryPeer::NUM_COLUMNS;

		$c->addJoin(DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID, PaymentTypePeer::ID);

		$c->addJoin(DeliveryHasPaymentTypePeer::DELIVERY_ID, DeliveryPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = DeliveryHasPaymentTypePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined PaymentType rows
	
			$omClass = PaymentTypePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getPaymentType(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDeliveryHasPaymentType($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initDeliveryHasPaymentTypes();
				$obj2->addDeliveryHasPaymentType($obj1);
			}


				// Add objects for joined Delivery rows
	
			$omClass = DeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getDelivery(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDeliveryHasPaymentType($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initDeliveryHasPaymentTypes();
				$obj3->addDeliveryHasPaymentType($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related PaymentType table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptPaymentType(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DeliveryHasPaymentTypePeer::DELIVERY_ID, DeliveryPeer::ID);

		$rs = DeliveryHasPaymentTypePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Delivery table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptDelivery(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DeliveryHasPaymentTypePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID, PaymentTypePeer::ID);

		$rs = DeliveryHasPaymentTypePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of DeliveryHasPaymentType objects pre-filled with all related objects except PaymentType.
	 *
	 * @return     array Array of DeliveryHasPaymentType objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptPaymentType(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DeliveryHasPaymentTypePeer::addSelectColumns($c);
		$startcol2 = (DeliveryHasPaymentTypePeer::NUM_COLUMNS - DeliveryHasPaymentTypePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DeliveryPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DeliveryPeer::NUM_COLUMNS;

		$c->addJoin(DeliveryHasPaymentTypePeer::DELIVERY_ID, DeliveryPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = DeliveryHasPaymentTypePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = DeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getDelivery(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDeliveryHasPaymentType($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDeliveryHasPaymentTypes();
				$obj2->addDeliveryHasPaymentType($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of DeliveryHasPaymentType objects pre-filled with all related objects except Delivery.
	 *
	 * @return     array Array of DeliveryHasPaymentType objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptDelivery(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DeliveryHasPaymentTypePeer::addSelectColumns($c);
		$startcol2 = (DeliveryHasPaymentTypePeer::NUM_COLUMNS - DeliveryHasPaymentTypePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		PaymentTypePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + PaymentTypePeer::NUM_COLUMNS;

		$c->addJoin(DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID, PaymentTypePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = DeliveryHasPaymentTypePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = PaymentTypePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getPaymentType(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDeliveryHasPaymentType($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDeliveryHasPaymentTypes();
				$obj2->addDeliveryHasPaymentType($obj1);
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
		return DeliveryHasPaymentTypePeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a DeliveryHasPaymentType or Criteria object.
	 *
	 * @param      mixed $values Criteria or DeliveryHasPaymentType object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseDeliveryHasPaymentTypePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseDeliveryHasPaymentTypePeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from DeliveryHasPaymentType object
		}

		$criteria->remove(DeliveryHasPaymentTypePeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseDeliveryHasPaymentTypePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseDeliveryHasPaymentTypePeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a DeliveryHasPaymentType or Criteria object.
	 *
	 * @param      mixed $values Criteria or DeliveryHasPaymentType object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseDeliveryHasPaymentTypePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseDeliveryHasPaymentTypePeer', $values, $con);
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

			$comparison = $criteria->getComparison(DeliveryHasPaymentTypePeer::ID);
			$selectCriteria->add(DeliveryHasPaymentTypePeer::ID, $criteria->remove(DeliveryHasPaymentTypePeer::ID), $comparison);

		} else { // $values is DeliveryHasPaymentType object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseDeliveryHasPaymentTypePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseDeliveryHasPaymentTypePeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_delivery_has_payment_type table.
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
			$affectedRows += BasePeer::doDeleteAll(DeliveryHasPaymentTypePeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a DeliveryHasPaymentType or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or DeliveryHasPaymentType object or primary key or array of primary keys
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
			$con = Propel::getConnection(DeliveryHasPaymentTypePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof DeliveryHasPaymentType) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(DeliveryHasPaymentTypePeer::ID, (array) $values, Criteria::IN);
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
	 * Validates all modified columns of given DeliveryHasPaymentType object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      DeliveryHasPaymentType $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(DeliveryHasPaymentType $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(DeliveryHasPaymentTypePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(DeliveryHasPaymentTypePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(DeliveryHasPaymentTypePeer::DATABASE_NAME, DeliveryHasPaymentTypePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = DeliveryHasPaymentTypePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     DeliveryHasPaymentType
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(DeliveryHasPaymentTypePeer::DATABASE_NAME);

		$criteria->add(DeliveryHasPaymentTypePeer::ID, $pk);


		$v = DeliveryHasPaymentTypePeer::doSelect($criteria, $con);

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
			$criteria->add(DeliveryHasPaymentTypePeer::ID, $pks, Criteria::IN);
			$objs = DeliveryHasPaymentTypePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseDeliveryHasPaymentTypePeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseDeliveryHasPaymentTypePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stDeliveryPlugin.lib.model.map.DeliveryHasPaymentTypeMapBuilder');
}
