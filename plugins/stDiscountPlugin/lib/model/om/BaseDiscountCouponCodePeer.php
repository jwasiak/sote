<?php

/**
 * Base static class for performing query and update operations on the 'st_discount_coupon_code' table.
 *
 * 
 *
 * @package    plugins.stDiscountPlugin.lib.model.om
 */
abstract class BaseDiscountCouponCodePeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_discount_coupon_code';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stDiscountPlugin.lib.model.DiscountCouponCode';

	/** The total number of columns. */
	const NUM_COLUMNS = 10;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the ID field */
	const ID = 'st_discount_coupon_code.ID';

	/** the column name for the SF_GUARD_USER_ID field */
	const SF_GUARD_USER_ID = 'st_discount_coupon_code.SF_GUARD_USER_ID';

	/** the column name for the ORDER_ID field */
	const ORDER_ID = 'st_discount_coupon_code.ORDER_ID';

	/** the column name for the CODE field */
	const CODE = 'st_discount_coupon_code.CODE';

	/** the column name for the USED field */
	const USED = 'st_discount_coupon_code.USED';

	/** the column name for the VALID_USAGE field */
	const VALID_USAGE = 'st_discount_coupon_code.VALID_USAGE';

	/** the column name for the ALLOW_ALL_PRODUCTS field */
	const ALLOW_ALL_PRODUCTS = 'st_discount_coupon_code.ALLOW_ALL_PRODUCTS';

	/** the column name for the VALID_FROM field */
	const VALID_FROM = 'st_discount_coupon_code.VALID_FROM';

	/** the column name for the VALID_TO field */
	const VALID_TO = 'st_discount_coupon_code.VALID_TO';

	/** the column name for the DISCOUNT field */
	const DISCOUNT = 'st_discount_coupon_code.DISCOUNT';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'SfGuardUserId', 'OrderId', 'Code', 'Used', 'ValidUsage', 'AllowAllProducts', 'ValidFrom', 'ValidTo', 'Discount', ),
		BasePeer::TYPE_COLNAME => array (DiscountCouponCodePeer::ID, DiscountCouponCodePeer::SF_GUARD_USER_ID, DiscountCouponCodePeer::ORDER_ID, DiscountCouponCodePeer::CODE, DiscountCouponCodePeer::USED, DiscountCouponCodePeer::VALID_USAGE, DiscountCouponCodePeer::ALLOW_ALL_PRODUCTS, DiscountCouponCodePeer::VALID_FROM, DiscountCouponCodePeer::VALID_TO, DiscountCouponCodePeer::DISCOUNT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'sf_guard_user_id', 'order_id', 'code', 'used', 'valid_usage', 'allow_all_products', 'valid_from', 'valid_to', 'discount', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'SfGuardUserId' => 1, 'OrderId' => 2, 'Code' => 3, 'Used' => 4, 'ValidUsage' => 5, 'AllowAllProducts' => 6, 'ValidFrom' => 7, 'ValidTo' => 8, 'Discount' => 9, ),
		BasePeer::TYPE_COLNAME => array (DiscountCouponCodePeer::ID => 0, DiscountCouponCodePeer::SF_GUARD_USER_ID => 1, DiscountCouponCodePeer::ORDER_ID => 2, DiscountCouponCodePeer::CODE => 3, DiscountCouponCodePeer::USED => 4, DiscountCouponCodePeer::VALID_USAGE => 5, DiscountCouponCodePeer::ALLOW_ALL_PRODUCTS => 6, DiscountCouponCodePeer::VALID_FROM => 7, DiscountCouponCodePeer::VALID_TO => 8, DiscountCouponCodePeer::DISCOUNT => 9, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'sf_guard_user_id' => 1, 'order_id' => 2, 'code' => 3, 'used' => 4, 'valid_usage' => 5, 'allow_all_products' => 6, 'valid_from' => 7, 'valid_to' => 8, 'discount' => 9, ),
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
		return BasePeer::getMapBuilder('plugins.stDiscountPlugin.lib.model.map.DiscountCouponCodeMapBuilder');
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
			$map = DiscountCouponCodePeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. DiscountCouponCodePeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(DiscountCouponCodePeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(DiscountCouponCodePeer::ID);

		$criteria->addSelectColumn(DiscountCouponCodePeer::SF_GUARD_USER_ID);

		$criteria->addSelectColumn(DiscountCouponCodePeer::ORDER_ID);

		$criteria->addSelectColumn(DiscountCouponCodePeer::CODE);

		$criteria->addSelectColumn(DiscountCouponCodePeer::USED);

		$criteria->addSelectColumn(DiscountCouponCodePeer::VALID_USAGE);

		$criteria->addSelectColumn(DiscountCouponCodePeer::ALLOW_ALL_PRODUCTS);

		$criteria->addSelectColumn(DiscountCouponCodePeer::VALID_FROM);

		$criteria->addSelectColumn(DiscountCouponCodePeer::VALID_TO);

		$criteria->addSelectColumn(DiscountCouponCodePeer::DISCOUNT);


		if (stEventDispatcher::getInstance()->getListeners('DiscountCouponCodePeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'DiscountCouponCodePeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_discount_coupon_code.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_discount_coupon_code.ID)';

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
			$criteria->addSelectColumn(DiscountCouponCodePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DiscountCouponCodePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = DiscountCouponCodePeer::doSelectRS($criteria, $con);
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
	 * @return     DiscountCouponCode
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = DiscountCouponCodePeer::doSelect($critcopy, $con);
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
		return DiscountCouponCodePeer::populateObjects(DiscountCouponCodePeer::doSelectRS($criteria, $con));
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
			DiscountCouponCodePeer::addSelectColumns($criteria);
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
		$cls = DiscountCouponCodePeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related sfGuardUser table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinsfGuardUser(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DiscountCouponCodePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DiscountCouponCodePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DiscountCouponCodePeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$rs = DiscountCouponCodePeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(DiscountCouponCodePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DiscountCouponCodePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DiscountCouponCodePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$rs = DiscountCouponCodePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of DiscountCouponCode objects pre-filled with their sfGuardUser objects.
	 *
	 * @return     array Array of DiscountCouponCode objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinsfGuardUser(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DiscountCouponCodePeer::addSelectColumns($c);

		sfGuardUserPeer::addSelectColumns($c);

		$c->addJoin(DiscountCouponCodePeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);
		$rs = DiscountCouponCodePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new DiscountCouponCode();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getSfGuardUserId())
                        {

			   $obj2 = new sfGuardUser();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addDiscountCouponCode($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of DiscountCouponCode objects pre-filled with their Order objects.
	 *
	 * @return     array Array of DiscountCouponCode objects.
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

		DiscountCouponCodePeer::addSelectColumns($c);

		OrderPeer::addSelectColumns($c);

		$c->addJoin(DiscountCouponCodePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);
		$rs = DiscountCouponCodePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new DiscountCouponCode();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getOrderId())
                        {

			   $obj2 = new Order();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addDiscountCouponCode($obj1);
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
			$criteria->addSelectColumn(DiscountCouponCodePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DiscountCouponCodePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DiscountCouponCodePeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(DiscountCouponCodePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$rs = DiscountCouponCodePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of DiscountCouponCode objects pre-filled with all related objects.
	 *
	 * @return     array Array of DiscountCouponCode objects.
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

		DiscountCouponCodePeer::addSelectColumns($c);
		$startcol2 = (DiscountCouponCodePeer::NUM_COLUMNS - DiscountCouponCodePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		OrderPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OrderPeer::NUM_COLUMNS;

		$c->addJoin(DiscountCouponCodePeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(DiscountCouponCodePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = DiscountCouponCodePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined sfGuardUser rows
	
			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfGuardUser(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDiscountCouponCode($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initDiscountCouponCodes();
				$obj2->addDiscountCouponCode($obj1);
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
					$temp_obj3->addDiscountCouponCode($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initDiscountCouponCodes();
				$obj3->addDiscountCouponCode($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related sfGuardUser table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptsfGuardUser(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DiscountCouponCodePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DiscountCouponCodePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DiscountCouponCodePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$rs = DiscountCouponCodePeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(DiscountCouponCodePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DiscountCouponCodePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DiscountCouponCodePeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$rs = DiscountCouponCodePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of DiscountCouponCode objects pre-filled with all related objects except sfGuardUser.
	 *
	 * @return     array Array of DiscountCouponCode objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptsfGuardUser(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DiscountCouponCodePeer::addSelectColumns($c);
		$startcol2 = (DiscountCouponCodePeer::NUM_COLUMNS - DiscountCouponCodePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderPeer::NUM_COLUMNS;

		$c->addJoin(DiscountCouponCodePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = DiscountCouponCodePeer::getOMClass();

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
					$temp_obj2->addDiscountCouponCode($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDiscountCouponCodes();
				$obj2->addDiscountCouponCode($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of DiscountCouponCode objects pre-filled with all related objects except Order.
	 *
	 * @return     array Array of DiscountCouponCode objects.
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

		DiscountCouponCodePeer::addSelectColumns($c);
		$startcol2 = (DiscountCouponCodePeer::NUM_COLUMNS - DiscountCouponCodePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(DiscountCouponCodePeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = DiscountCouponCodePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfGuardUser(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDiscountCouponCode($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDiscountCouponCodes();
				$obj2->addDiscountCouponCode($obj1);
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
		return DiscountCouponCodePeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a DiscountCouponCode or Criteria object.
	 *
	 * @param      mixed $values Criteria or DiscountCouponCode object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseDiscountCouponCodePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseDiscountCouponCodePeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from DiscountCouponCode object
		}

		$criteria->remove(DiscountCouponCodePeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseDiscountCouponCodePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseDiscountCouponCodePeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a DiscountCouponCode or Criteria object.
	 *
	 * @param      mixed $values Criteria or DiscountCouponCode object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseDiscountCouponCodePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseDiscountCouponCodePeer', $values, $con);
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

			$comparison = $criteria->getComparison(DiscountCouponCodePeer::ID);
			$selectCriteria->add(DiscountCouponCodePeer::ID, $criteria->remove(DiscountCouponCodePeer::ID), $comparison);

		} else { // $values is DiscountCouponCode object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseDiscountCouponCodePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseDiscountCouponCodePeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_discount_coupon_code table.
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
			$affectedRows += DiscountCouponCodePeer::doOnDeleteCascade(new Criteria(), $con);
			DiscountCouponCodePeer::doOnDeleteSetNull(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(DiscountCouponCodePeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a DiscountCouponCode or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or DiscountCouponCode object or primary key or array of primary keys
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
			$con = Propel::getConnection(DiscountCouponCodePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof DiscountCouponCode) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(DiscountCouponCodePeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += DiscountCouponCodePeer::doOnDeleteCascade($criteria, $con);DiscountCouponCodePeer::doOnDeleteSetNull($criteria, $con);
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
		$objects = DiscountCouponCodePeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related DiscountCouponCodeHasProducer objects
			$c = new Criteria();
			
			$c->add(DiscountCouponCodeHasProducerPeer::DISCOUNT_COUPON_CODE_ID, $obj->getId());
			$affectedRows += DiscountCouponCodeHasProducerPeer::doDelete($c, $con);

			// delete related DiscountCouponCodeHasCategory objects
			$c = new Criteria();
			
			$c->add(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, $obj->getId());
			$affectedRows += DiscountCouponCodeHasCategoryPeer::doDelete($c, $con);

			// delete related DiscountCouponCodeHasProduct objects
			$c = new Criteria();
			
			$c->add(DiscountCouponCodeHasProductPeer::DISCOUNT_COUPON_CODE_ID, $obj->getId());
			$affectedRows += DiscountCouponCodeHasProductPeer::doDelete($c, $con);
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
		$objects = DiscountCouponCodePeer::doSelect($criteria, $con);
		foreach($objects as $obj) {

			// set fkey col in related Order rows to NULL
			$selectCriteria = new Criteria(DiscountCouponCodePeer::DATABASE_NAME);
			$updateValues = new Criteria(DiscountCouponCodePeer::DATABASE_NAME);
			$selectCriteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $obj->getId());
			$updateValues->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

		}
	}

	/**
	 * Validates all modified columns of given DiscountCouponCode object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      DiscountCouponCode $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(DiscountCouponCode $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(DiscountCouponCodePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(DiscountCouponCodePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(DiscountCouponCodePeer::DATABASE_NAME, DiscountCouponCodePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = DiscountCouponCodePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     DiscountCouponCode
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(DiscountCouponCodePeer::DATABASE_NAME);

		$criteria->add(DiscountCouponCodePeer::ID, $pk);


		$v = DiscountCouponCodePeer::doSelect($criteria, $con);

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
			$criteria->add(DiscountCouponCodePeer::ID, $pks, Criteria::IN);
			$objs = DiscountCouponCodePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseDiscountCouponCodePeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseDiscountCouponCodePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stDiscountPlugin.lib.model.map.DiscountCouponCodeMapBuilder');
}
