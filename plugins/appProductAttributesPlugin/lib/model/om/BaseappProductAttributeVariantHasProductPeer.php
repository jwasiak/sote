<?php

/**
 * Base static class for performing query and update operations on the 'app_product_attribute_variant_has_product' table.
 *
 * 
 *
 * @package    plugins.appProductAttributesPlugin.lib.model.om
 */
abstract class BaseappProductAttributeVariantHasProductPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'app_product_attribute_variant_has_product';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.appProductAttributesPlugin.lib.model.appProductAttributeVariantHasProduct';

	/** The total number of columns. */
	const NUM_COLUMNS = 2;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the PRODUCT_ID field */
	const PRODUCT_ID = 'app_product_attribute_variant_has_product.PRODUCT_ID';

	/** the column name for the VARIANT_ID field */
	const VARIANT_ID = 'app_product_attribute_variant_has_product.VARIANT_ID';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('ProductId', 'VariantId', ),
		BasePeer::TYPE_COLNAME => array (appProductAttributeVariantHasProductPeer::PRODUCT_ID, appProductAttributeVariantHasProductPeer::VARIANT_ID, ),
		BasePeer::TYPE_FIELDNAME => array ('product_id', 'variant_id', ),
		BasePeer::TYPE_NUM => array (0, 1, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('ProductId' => 0, 'VariantId' => 1, ),
		BasePeer::TYPE_COLNAME => array (appProductAttributeVariantHasProductPeer::PRODUCT_ID => 0, appProductAttributeVariantHasProductPeer::VARIANT_ID => 1, ),
		BasePeer::TYPE_FIELDNAME => array ('product_id' => 0, 'variant_id' => 1, ),
		BasePeer::TYPE_NUM => array (0, 1, )
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
		return BasePeer::getMapBuilder('plugins.appProductAttributesPlugin.lib.model.map.appProductAttributeVariantHasProductMapBuilder');
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
			$map = appProductAttributeVariantHasProductPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. appProductAttributeVariantHasProductPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(appProductAttributeVariantHasProductPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(appProductAttributeVariantHasProductPeer::PRODUCT_ID);

		$criteria->addSelectColumn(appProductAttributeVariantHasProductPeer::VARIANT_ID);


		if (stEventDispatcher::getInstance()->getListeners('appProductAttributeVariantHasProductPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'appProductAttributeVariantHasProductPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(app_product_attribute_variant_has_product.PRODUCT_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT app_product_attribute_variant_has_product.PRODUCT_ID)';

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
			$criteria->addSelectColumn(appProductAttributeVariantHasProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(appProductAttributeVariantHasProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = appProductAttributeVariantHasProductPeer::doSelectRS($criteria, $con);
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
	 * @return     appProductAttributeVariantHasProduct
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = appProductAttributeVariantHasProductPeer::doSelect($critcopy, $con);
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
		return appProductAttributeVariantHasProductPeer::populateObjects(appProductAttributeVariantHasProductPeer::doSelectRS($criteria, $con));
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
			appProductAttributeVariantHasProductPeer::addSelectColumns($criteria);
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
		$cls = appProductAttributeVariantHasProductPeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related Product table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinProduct(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(appProductAttributeVariantHasProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(appProductAttributeVariantHasProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(appProductAttributeVariantHasProductPeer::PRODUCT_ID, ProductPeer::ID);

		$rs = appProductAttributeVariantHasProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related appProductAttributeVariant table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinappProductAttributeVariant(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(appProductAttributeVariantHasProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(appProductAttributeVariantHasProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(appProductAttributeVariantHasProductPeer::VARIANT_ID, appProductAttributeVariantPeer::ID);

		$rs = appProductAttributeVariantHasProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of appProductAttributeVariantHasProduct objects pre-filled with their Product objects.
	 *
	 * @return     array Array of appProductAttributeVariantHasProduct objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinProduct(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		appProductAttributeVariantHasProductPeer::addSelectColumns($c);

		ProductPeer::addSelectColumns($c);

		$c->addJoin(appProductAttributeVariantHasProductPeer::PRODUCT_ID, ProductPeer::ID);
		$rs = appProductAttributeVariantHasProductPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new appProductAttributeVariantHasProduct();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getProductId())
                        {

			   $obj2 = new Product();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addappProductAttributeVariantHasProduct($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of appProductAttributeVariantHasProduct objects pre-filled with their appProductAttributeVariant objects.
	 *
	 * @return     array Array of appProductAttributeVariantHasProduct objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinappProductAttributeVariant(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		appProductAttributeVariantHasProductPeer::addSelectColumns($c);

		appProductAttributeVariantPeer::addSelectColumns($c);

		$c->addJoin(appProductAttributeVariantHasProductPeer::VARIANT_ID, appProductAttributeVariantPeer::ID);
		$rs = appProductAttributeVariantHasProductPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new appProductAttributeVariantHasProduct();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getVariantId())
                        {

			   $obj2 = new appProductAttributeVariant();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addappProductAttributeVariantHasProduct($obj1);
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
			$criteria->addSelectColumn(appProductAttributeVariantHasProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(appProductAttributeVariantHasProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(appProductAttributeVariantHasProductPeer::PRODUCT_ID, ProductPeer::ID);

		$criteria->addJoin(appProductAttributeVariantHasProductPeer::VARIANT_ID, appProductAttributeVariantPeer::ID);

		$rs = appProductAttributeVariantHasProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of appProductAttributeVariantHasProduct objects pre-filled with all related objects.
	 *
	 * @return     array Array of appProductAttributeVariantHasProduct objects.
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

		appProductAttributeVariantHasProductPeer::addSelectColumns($c);
		$startcol2 = (appProductAttributeVariantHasProductPeer::NUM_COLUMNS - appProductAttributeVariantHasProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ProductPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ProductPeer::NUM_COLUMNS;

		appProductAttributeVariantPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + appProductAttributeVariantPeer::NUM_COLUMNS;

		$c->addJoin(appProductAttributeVariantHasProductPeer::PRODUCT_ID, ProductPeer::ID);

		$c->addJoin(appProductAttributeVariantHasProductPeer::VARIANT_ID, appProductAttributeVariantPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = appProductAttributeVariantHasProductPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined Product rows
	
			$omClass = ProductPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getProduct(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addappProductAttributeVariantHasProduct($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initappProductAttributeVariantHasProducts();
				$obj2->addappProductAttributeVariantHasProduct($obj1);
			}


				// Add objects for joined appProductAttributeVariant rows
	
			$omClass = appProductAttributeVariantPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getappProductAttributeVariant(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addappProductAttributeVariantHasProduct($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initappProductAttributeVariantHasProducts();
				$obj3->addappProductAttributeVariantHasProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Product table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptProduct(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(appProductAttributeVariantHasProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(appProductAttributeVariantHasProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(appProductAttributeVariantHasProductPeer::VARIANT_ID, appProductAttributeVariantPeer::ID);

		$rs = appProductAttributeVariantHasProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related appProductAttributeVariant table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptappProductAttributeVariant(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(appProductAttributeVariantHasProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(appProductAttributeVariantHasProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(appProductAttributeVariantHasProductPeer::PRODUCT_ID, ProductPeer::ID);

		$rs = appProductAttributeVariantHasProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of appProductAttributeVariantHasProduct objects pre-filled with all related objects except Product.
	 *
	 * @return     array Array of appProductAttributeVariantHasProduct objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptProduct(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		appProductAttributeVariantHasProductPeer::addSelectColumns($c);
		$startcol2 = (appProductAttributeVariantHasProductPeer::NUM_COLUMNS - appProductAttributeVariantHasProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		appProductAttributeVariantPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + appProductAttributeVariantPeer::NUM_COLUMNS;

		$c->addJoin(appProductAttributeVariantHasProductPeer::VARIANT_ID, appProductAttributeVariantPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = appProductAttributeVariantHasProductPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = appProductAttributeVariantPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getappProductAttributeVariant(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addappProductAttributeVariantHasProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initappProductAttributeVariantHasProducts();
				$obj2->addappProductAttributeVariantHasProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of appProductAttributeVariantHasProduct objects pre-filled with all related objects except appProductAttributeVariant.
	 *
	 * @return     array Array of appProductAttributeVariantHasProduct objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptappProductAttributeVariant(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		appProductAttributeVariantHasProductPeer::addSelectColumns($c);
		$startcol2 = (appProductAttributeVariantHasProductPeer::NUM_COLUMNS - appProductAttributeVariantHasProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ProductPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ProductPeer::NUM_COLUMNS;

		$c->addJoin(appProductAttributeVariantHasProductPeer::PRODUCT_ID, ProductPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = appProductAttributeVariantHasProductPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ProductPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getProduct(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addappProductAttributeVariantHasProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initappProductAttributeVariantHasProducts();
				$obj2->addappProductAttributeVariantHasProduct($obj1);
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
		return appProductAttributeVariantHasProductPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a appProductAttributeVariantHasProduct or Criteria object.
	 *
	 * @param      mixed $values Criteria or appProductAttributeVariantHasProduct object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseappProductAttributeVariantHasProductPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseappProductAttributeVariantHasProductPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from appProductAttributeVariantHasProduct object
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

		
    foreach (sfMixer::getCallables('BaseappProductAttributeVariantHasProductPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseappProductAttributeVariantHasProductPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a appProductAttributeVariantHasProduct or Criteria object.
	 *
	 * @param      mixed $values Criteria or appProductAttributeVariantHasProduct object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseappProductAttributeVariantHasProductPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseappProductAttributeVariantHasProductPeer', $values, $con);
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

			$comparison = $criteria->getComparison(appProductAttributeVariantHasProductPeer::PRODUCT_ID);
			$selectCriteria->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $criteria->remove(appProductAttributeVariantHasProductPeer::PRODUCT_ID), $comparison);

			$comparison = $criteria->getComparison(appProductAttributeVariantHasProductPeer::VARIANT_ID);
			$selectCriteria->add(appProductAttributeVariantHasProductPeer::VARIANT_ID, $criteria->remove(appProductAttributeVariantHasProductPeer::VARIANT_ID), $comparison);

		} else { // $values is appProductAttributeVariantHasProduct object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseappProductAttributeVariantHasProductPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseappProductAttributeVariantHasProductPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the app_product_attribute_variant_has_product table.
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
			$affectedRows += BasePeer::doDeleteAll(appProductAttributeVariantHasProductPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a appProductAttributeVariantHasProduct or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or appProductAttributeVariantHasProduct object or primary key or array of primary keys
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
			$con = Propel::getConnection(appProductAttributeVariantHasProductPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof appProductAttributeVariantHasProduct) {

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

			$criteria->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $vals[0], Criteria::IN);
			$criteria->add(appProductAttributeVariantHasProductPeer::VARIANT_ID, $vals[1], Criteria::IN);
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
	 * Validates all modified columns of given appProductAttributeVariantHasProduct object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      appProductAttributeVariantHasProduct $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(appProductAttributeVariantHasProduct $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(appProductAttributeVariantHasProductPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(appProductAttributeVariantHasProductPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(appProductAttributeVariantHasProductPeer::DATABASE_NAME, appProductAttributeVariantHasProductPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = appProductAttributeVariantHasProductPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	/**
	 * Retrieve object using using composite pkey values.
	 * @param int $product_id
	   @param int $variant_id
	   
	 * @param      Connection $con
	 * @return     appProductAttributeVariantHasProduct
	 */
	public static function retrieveByPK( $product_id, $variant_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $product_id);
		$criteria->add(appProductAttributeVariantHasProductPeer::VARIANT_ID, $variant_id);
		$v = appProductAttributeVariantHasProductPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} // BaseappProductAttributeVariantHasProductPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseappProductAttributeVariantHasProductPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.appProductAttributesPlugin.lib.model.map.appProductAttributeVariantHasProductMapBuilder');
}
