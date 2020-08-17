<?php

/**
 * Base static class for performing query and update operations on the 'st_discount_coupon_code_has_category' table.
 *
 * 
 *
 * @package    plugins.stDiscountPlugin.lib.model.om
 */
abstract class BaseDiscountCouponCodeHasCategoryPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_discount_coupon_code_has_category';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stDiscountPlugin.lib.model.DiscountCouponCodeHasCategory';

	/** The total number of columns. */
	const NUM_COLUMNS = 3;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the DISCOUNT_COUPON_CODE_ID field */
	const DISCOUNT_COUPON_CODE_ID = 'st_discount_coupon_code_has_category.DISCOUNT_COUPON_CODE_ID';

	/** the column name for the CATEGORY_ID field */
	const CATEGORY_ID = 'st_discount_coupon_code_has_category.CATEGORY_ID';

	/** the column name for the IS_OPT field */
	const IS_OPT = 'st_discount_coupon_code_has_category.IS_OPT';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('DiscountCouponCodeId', 'CategoryId', 'IsOpt', ),
		BasePeer::TYPE_COLNAME => array (DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, DiscountCouponCodeHasCategoryPeer::IS_OPT, ),
		BasePeer::TYPE_FIELDNAME => array ('discount_coupon_code_id', 'category_id', 'is_opt', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('DiscountCouponCodeId' => 0, 'CategoryId' => 1, 'IsOpt' => 2, ),
		BasePeer::TYPE_COLNAME => array (DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID => 0, DiscountCouponCodeHasCategoryPeer::CATEGORY_ID => 1, DiscountCouponCodeHasCategoryPeer::IS_OPT => 2, ),
		BasePeer::TYPE_FIELDNAME => array ('discount_coupon_code_id' => 0, 'category_id' => 1, 'is_opt' => 2, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, )
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
		return BasePeer::getMapBuilder('plugins.stDiscountPlugin.lib.model.map.DiscountCouponCodeHasCategoryMapBuilder');
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
			$map = DiscountCouponCodeHasCategoryPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. DiscountCouponCodeHasCategoryPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(DiscountCouponCodeHasCategoryPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID);

		$criteria->addSelectColumn(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID);

		$criteria->addSelectColumn(DiscountCouponCodeHasCategoryPeer::IS_OPT);


		if (stEventDispatcher::getInstance()->getListeners('DiscountCouponCodeHasCategoryPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'DiscountCouponCodeHasCategoryPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_discount_coupon_code_has_category.DISCOUNT_COUPON_CODE_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_discount_coupon_code_has_category.DISCOUNT_COUPON_CODE_ID)';

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
			$criteria->addSelectColumn(DiscountCouponCodeHasCategoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DiscountCouponCodeHasCategoryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = DiscountCouponCodeHasCategoryPeer::doSelectRS($criteria, $con);
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
	 * @return     DiscountCouponCodeHasCategory
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = DiscountCouponCodeHasCategoryPeer::doSelect($critcopy, $con);
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
		return DiscountCouponCodeHasCategoryPeer::populateObjects(DiscountCouponCodeHasCategoryPeer::doSelectRS($criteria, $con));
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
			DiscountCouponCodeHasCategoryPeer::addSelectColumns($criteria);
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
		$cls = DiscountCouponCodeHasCategoryPeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related DiscountCouponCode table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinDiscountCouponCode(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DiscountCouponCodeHasCategoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DiscountCouponCodeHasCategoryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID);

		$rs = DiscountCouponCodeHasCategoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Category table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinCategory(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DiscountCouponCodeHasCategoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DiscountCouponCodeHasCategoryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);

		$rs = DiscountCouponCodeHasCategoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of DiscountCouponCodeHasCategory objects pre-filled with their DiscountCouponCode objects.
	 *
	 * @return     array Array of DiscountCouponCodeHasCategory objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinDiscountCouponCode(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DiscountCouponCodeHasCategoryPeer::addSelectColumns($c);

		DiscountCouponCodePeer::addSelectColumns($c);

		$c->addJoin(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID);
		$rs = DiscountCouponCodeHasCategoryPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new DiscountCouponCodeHasCategory();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getDiscountCouponCodeId())
                        {

			   $obj2 = new DiscountCouponCode();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addDiscountCouponCodeHasCategory($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of DiscountCouponCodeHasCategory objects pre-filled with their Category objects.
	 *
	 * @return     array Array of DiscountCouponCodeHasCategory objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinCategory(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DiscountCouponCodeHasCategoryPeer::addSelectColumns($c);

		CategoryPeer::addSelectColumns($c);

		$c->addJoin(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);
		$rs = DiscountCouponCodeHasCategoryPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new DiscountCouponCodeHasCategory();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getCategoryId())
                        {

			   $obj2 = new Category();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addDiscountCouponCodeHasCategory($obj1);
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
			$criteria->addSelectColumn(DiscountCouponCodeHasCategoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DiscountCouponCodeHasCategoryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID);

		$criteria->addJoin(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);

		$rs = DiscountCouponCodeHasCategoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of DiscountCouponCodeHasCategory objects pre-filled with all related objects.
	 *
	 * @return     array Array of DiscountCouponCodeHasCategory objects.
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

		DiscountCouponCodeHasCategoryPeer::addSelectColumns($c);
		$startcol2 = (DiscountCouponCodeHasCategoryPeer::NUM_COLUMNS - DiscountCouponCodeHasCategoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DiscountCouponCodePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DiscountCouponCodePeer::NUM_COLUMNS;

		CategoryPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + CategoryPeer::NUM_COLUMNS;

		$c->addJoin(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID);

		$c->addJoin(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = DiscountCouponCodeHasCategoryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined DiscountCouponCode rows
	
			$omClass = DiscountCouponCodePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getDiscountCouponCode(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDiscountCouponCodeHasCategory($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initDiscountCouponCodeHasCategorys();
				$obj2->addDiscountCouponCodeHasCategory($obj1);
			}


				// Add objects for joined Category rows
	
			$omClass = CategoryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getCategory(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDiscountCouponCodeHasCategory($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initDiscountCouponCodeHasCategorys();
				$obj3->addDiscountCouponCodeHasCategory($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related DiscountCouponCode table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptDiscountCouponCode(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DiscountCouponCodeHasCategoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DiscountCouponCodeHasCategoryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);

		$rs = DiscountCouponCodeHasCategoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Category table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptCategory(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DiscountCouponCodeHasCategoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DiscountCouponCodeHasCategoryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID);

		$rs = DiscountCouponCodeHasCategoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of DiscountCouponCodeHasCategory objects pre-filled with all related objects except DiscountCouponCode.
	 *
	 * @return     array Array of DiscountCouponCodeHasCategory objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptDiscountCouponCode(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DiscountCouponCodeHasCategoryPeer::addSelectColumns($c);
		$startcol2 = (DiscountCouponCodeHasCategoryPeer::NUM_COLUMNS - DiscountCouponCodeHasCategoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CategoryPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CategoryPeer::NUM_COLUMNS;

		$c->addJoin(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, CategoryPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = DiscountCouponCodeHasCategoryPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = CategoryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCategory(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDiscountCouponCodeHasCategory($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDiscountCouponCodeHasCategorys();
				$obj2->addDiscountCouponCodeHasCategory($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of DiscountCouponCodeHasCategory objects pre-filled with all related objects except Category.
	 *
	 * @return     array Array of DiscountCouponCodeHasCategory objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptCategory(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DiscountCouponCodeHasCategoryPeer::addSelectColumns($c);
		$startcol2 = (DiscountCouponCodeHasCategoryPeer::NUM_COLUMNS - DiscountCouponCodeHasCategoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DiscountCouponCodePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DiscountCouponCodePeer::NUM_COLUMNS;

		$c->addJoin(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = DiscountCouponCodeHasCategoryPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = DiscountCouponCodePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getDiscountCouponCode(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDiscountCouponCodeHasCategory($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDiscountCouponCodeHasCategorys();
				$obj2->addDiscountCouponCodeHasCategory($obj1);
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
		return DiscountCouponCodeHasCategoryPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a DiscountCouponCodeHasCategory or Criteria object.
	 *
	 * @param      mixed $values Criteria or DiscountCouponCodeHasCategory object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseDiscountCouponCodeHasCategoryPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseDiscountCouponCodeHasCategoryPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from DiscountCouponCodeHasCategory object
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

		
    foreach (sfMixer::getCallables('BaseDiscountCouponCodeHasCategoryPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseDiscountCouponCodeHasCategoryPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a DiscountCouponCodeHasCategory or Criteria object.
	 *
	 * @param      mixed $values Criteria or DiscountCouponCodeHasCategory object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseDiscountCouponCodeHasCategoryPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseDiscountCouponCodeHasCategoryPeer', $values, $con);
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

			$comparison = $criteria->getComparison(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID);
			$selectCriteria->add(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, $criteria->remove(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID), $comparison);

			$comparison = $criteria->getComparison(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID);
			$selectCriteria->add(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, $criteria->remove(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID), $comparison);

		} else { // $values is DiscountCouponCodeHasCategory object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseDiscountCouponCodeHasCategoryPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseDiscountCouponCodeHasCategoryPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_discount_coupon_code_has_category table.
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
			$affectedRows += BasePeer::doDeleteAll(DiscountCouponCodeHasCategoryPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a DiscountCouponCodeHasCategory or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or DiscountCouponCodeHasCategory object or primary key or array of primary keys
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
			$con = Propel::getConnection(DiscountCouponCodeHasCategoryPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof DiscountCouponCodeHasCategory) {

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

			$criteria->add(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, $vals[0], Criteria::IN);
			$criteria->add(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, $vals[1], Criteria::IN);
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
	 * Validates all modified columns of given DiscountCouponCodeHasCategory object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      DiscountCouponCodeHasCategory $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(DiscountCouponCodeHasCategory $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(DiscountCouponCodeHasCategoryPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(DiscountCouponCodeHasCategoryPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(DiscountCouponCodeHasCategoryPeer::DATABASE_NAME, DiscountCouponCodeHasCategoryPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = DiscountCouponCodeHasCategoryPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	/**
	 * Retrieve object using using composite pkey values.
	 * @param int $discount_coupon_code_id
	   @param int $category_id
	   
	 * @param      Connection $con
	 * @return     DiscountCouponCodeHasCategory
	 */
	public static function retrieveByPK( $discount_coupon_code_id, $category_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, $discount_coupon_code_id);
		$criteria->add(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, $category_id);
		$v = DiscountCouponCodeHasCategoryPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} // BaseDiscountCouponCodeHasCategoryPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseDiscountCouponCodeHasCategoryPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stDiscountPlugin.lib.model.map.DiscountCouponCodeHasCategoryMapBuilder');
}
