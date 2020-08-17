<?php

/**
 * Base static class for performing query and update operations on the 'st_delivery' table.
 *
 * 
 *
 * @package    plugins.stDeliveryPlugin.lib.model.om
 */
abstract class BaseDeliveryPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_delivery';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stDeliveryPlugin.lib.model.Delivery';

	/** The total number of columns. */
	const NUM_COLUMNS = 28;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the ID field */
	const ID = 'st_delivery.ID';

	/** the column name for the COUNTRIES_AREA_ID field */
	const COUNTRIES_AREA_ID = 'st_delivery.COUNTRIES_AREA_ID';

	/** the column name for the TAX_ID field */
	const TAX_ID = 'st_delivery.TAX_ID';

	/** the column name for the TYPE_ID field */
	const TYPE_ID = 'st_delivery.TYPE_ID';

	/** the column name for the FREE_DELIVERY field */
	const FREE_DELIVERY = 'st_delivery.FREE_DELIVERY';

	/** the column name for the ACTIVE field */
	const ACTIVE = 'st_delivery.ACTIVE';

	/** the column name for the ALLOW_IN_SELECTED_PRODUCTS field */
	const ALLOW_IN_SELECTED_PRODUCTS = 'st_delivery.ALLOW_IN_SELECTED_PRODUCTS';

	/** the column name for the DEFAULT_COST field */
	const DEFAULT_COST = 'st_delivery.DEFAULT_COST';

	/** the column name for the DEFAULT_COST_BRUTTO field */
	const DEFAULT_COST_BRUTTO = 'st_delivery.DEFAULT_COST_BRUTTO';

	/** the column name for the WIDTH field */
	const WIDTH = 'st_delivery.WIDTH';

	/** the column name for the HEIGHT field */
	const HEIGHT = 'st_delivery.HEIGHT';

	/** the column name for the DEPTH field */
	const DEPTH = 'st_delivery.DEPTH';

	/** the column name for the VOLUME field */
	const VOLUME = 'st_delivery.VOLUME';

	/** the column name for the IS_SYSTEM_DEFAULT field */
	const IS_SYSTEM_DEFAULT = 'st_delivery.IS_SYSTEM_DEFAULT';

	/** the column name for the OPT_NAME field */
	const OPT_NAME = 'st_delivery.OPT_NAME';

	/** the column name for the OPT_DESCRIPTION field */
	const OPT_DESCRIPTION = 'st_delivery.OPT_DESCRIPTION';

	/** the column name for the IS_DEFAULT field */
	const IS_DEFAULT = 'st_delivery.IS_DEFAULT';

	/** the column name for the SECTION_COST_TYPE field */
	const SECTION_COST_TYPE = 'st_delivery.SECTION_COST_TYPE';

	/** the column name for the MAX_ORDER_WEIGHT field */
	const MAX_ORDER_WEIGHT = 'st_delivery.MAX_ORDER_WEIGHT';

	/** the column name for the MAX_ORDER_AMOUNT field */
	const MAX_ORDER_AMOUNT = 'st_delivery.MAX_ORDER_AMOUNT';

	/** the column name for the MAX_ORDER_QUANTITY field */
	const MAX_ORDER_QUANTITY = 'st_delivery.MAX_ORDER_QUANTITY';

	/** the column name for the MIN_ORDER_WEIGHT field */
	const MIN_ORDER_WEIGHT = 'st_delivery.MIN_ORDER_WEIGHT';

	/** the column name for the MIN_ORDER_AMOUNT field */
	const MIN_ORDER_AMOUNT = 'st_delivery.MIN_ORDER_AMOUNT';

	/** the column name for the MIN_ORDER_QUANTITY field */
	const MIN_ORDER_QUANTITY = 'st_delivery.MIN_ORDER_QUANTITY';

	/** the column name for the POSITION field */
	const POSITION = 'st_delivery.POSITION';

	/** the column name for the PARAMS field */
	const PARAMS = 'st_delivery.PARAMS';

	/** the column name for the PACZKOMATY_TYPE field */
	const PACZKOMATY_TYPE = 'st_delivery.PACZKOMATY_TYPE';

	/** the column name for the PACZKOMATY_SIZE field */
	const PACZKOMATY_SIZE = 'st_delivery.PACZKOMATY_SIZE';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'CountriesAreaId', 'TaxId', 'TypeId', 'FreeDelivery', 'Active', 'AllowInSelectedProducts', 'DefaultCost', 'DefaultCostBrutto', 'Width', 'Height', 'Depth', 'Volume', 'IsSystemDefault', 'OptName', 'OptDescription', 'IsDefault', 'SectionCostType', 'MaxOrderWeight', 'MaxOrderAmount', 'MaxOrderQuantity', 'MinOrderWeight', 'MinOrderAmount', 'MinOrderQuantity', 'Position', 'Params', 'PaczkomatyType', 'PaczkomatySize', ),
		BasePeer::TYPE_COLNAME => array (DeliveryPeer::ID, DeliveryPeer::COUNTRIES_AREA_ID, DeliveryPeer::TAX_ID, DeliveryPeer::TYPE_ID, DeliveryPeer::FREE_DELIVERY, DeliveryPeer::ACTIVE, DeliveryPeer::ALLOW_IN_SELECTED_PRODUCTS, DeliveryPeer::DEFAULT_COST, DeliveryPeer::DEFAULT_COST_BRUTTO, DeliveryPeer::WIDTH, DeliveryPeer::HEIGHT, DeliveryPeer::DEPTH, DeliveryPeer::VOLUME, DeliveryPeer::IS_SYSTEM_DEFAULT, DeliveryPeer::OPT_NAME, DeliveryPeer::OPT_DESCRIPTION, DeliveryPeer::IS_DEFAULT, DeliveryPeer::SECTION_COST_TYPE, DeliveryPeer::MAX_ORDER_WEIGHT, DeliveryPeer::MAX_ORDER_AMOUNT, DeliveryPeer::MAX_ORDER_QUANTITY, DeliveryPeer::MIN_ORDER_WEIGHT, DeliveryPeer::MIN_ORDER_AMOUNT, DeliveryPeer::MIN_ORDER_QUANTITY, DeliveryPeer::POSITION, DeliveryPeer::PARAMS, DeliveryPeer::PACZKOMATY_TYPE, DeliveryPeer::PACZKOMATY_SIZE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'countries_area_id', 'tax_id', 'type_id', 'free_delivery', 'active', 'allow_in_selected_products', 'default_cost', 'default_cost_brutto', 'width', 'height', 'depth', 'volume', 'is_system_default', 'opt_name', 'opt_description', 'is_default', 'section_cost_type', 'max_order_weight', 'max_order_amount', 'max_order_quantity', 'min_order_weight', 'min_order_amount', 'min_order_quantity', 'position', 'params', 'paczkomaty_type', 'paczkomaty_size', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CountriesAreaId' => 1, 'TaxId' => 2, 'TypeId' => 3, 'FreeDelivery' => 4, 'Active' => 5, 'AllowInSelectedProducts' => 6, 'DefaultCost' => 7, 'DefaultCostBrutto' => 8, 'Width' => 9, 'Height' => 10, 'Depth' => 11, 'Volume' => 12, 'IsSystemDefault' => 13, 'OptName' => 14, 'OptDescription' => 15, 'IsDefault' => 16, 'SectionCostType' => 17, 'MaxOrderWeight' => 18, 'MaxOrderAmount' => 19, 'MaxOrderQuantity' => 20, 'MinOrderWeight' => 21, 'MinOrderAmount' => 22, 'MinOrderQuantity' => 23, 'Position' => 24, 'Params' => 25, 'PaczkomatyType' => 26, 'PaczkomatySize' => 27, ),
		BasePeer::TYPE_COLNAME => array (DeliveryPeer::ID => 0, DeliveryPeer::COUNTRIES_AREA_ID => 1, DeliveryPeer::TAX_ID => 2, DeliveryPeer::TYPE_ID => 3, DeliveryPeer::FREE_DELIVERY => 4, DeliveryPeer::ACTIVE => 5, DeliveryPeer::ALLOW_IN_SELECTED_PRODUCTS => 6, DeliveryPeer::DEFAULT_COST => 7, DeliveryPeer::DEFAULT_COST_BRUTTO => 8, DeliveryPeer::WIDTH => 9, DeliveryPeer::HEIGHT => 10, DeliveryPeer::DEPTH => 11, DeliveryPeer::VOLUME => 12, DeliveryPeer::IS_SYSTEM_DEFAULT => 13, DeliveryPeer::OPT_NAME => 14, DeliveryPeer::OPT_DESCRIPTION => 15, DeliveryPeer::IS_DEFAULT => 16, DeliveryPeer::SECTION_COST_TYPE => 17, DeliveryPeer::MAX_ORDER_WEIGHT => 18, DeliveryPeer::MAX_ORDER_AMOUNT => 19, DeliveryPeer::MAX_ORDER_QUANTITY => 20, DeliveryPeer::MIN_ORDER_WEIGHT => 21, DeliveryPeer::MIN_ORDER_AMOUNT => 22, DeliveryPeer::MIN_ORDER_QUANTITY => 23, DeliveryPeer::POSITION => 24, DeliveryPeer::PARAMS => 25, DeliveryPeer::PACZKOMATY_TYPE => 26, DeliveryPeer::PACZKOMATY_SIZE => 27, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'countries_area_id' => 1, 'tax_id' => 2, 'type_id' => 3, 'free_delivery' => 4, 'active' => 5, 'allow_in_selected_products' => 6, 'default_cost' => 7, 'default_cost_brutto' => 8, 'width' => 9, 'height' => 10, 'depth' => 11, 'volume' => 12, 'is_system_default' => 13, 'opt_name' => 14, 'opt_description' => 15, 'is_default' => 16, 'section_cost_type' => 17, 'max_order_weight' => 18, 'max_order_amount' => 19, 'max_order_quantity' => 20, 'min_order_weight' => 21, 'min_order_amount' => 22, 'min_order_quantity' => 23, 'position' => 24, 'params' => 25, 'paczkomaty_type' => 26, 'paczkomaty_size' => 27, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, )
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
		return BasePeer::getMapBuilder('plugins.stDeliveryPlugin.lib.model.map.DeliveryMapBuilder');
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
			$map = DeliveryPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. DeliveryPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(DeliveryPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(DeliveryPeer::ID);

		$criteria->addSelectColumn(DeliveryPeer::COUNTRIES_AREA_ID);

		$criteria->addSelectColumn(DeliveryPeer::TAX_ID);

		$criteria->addSelectColumn(DeliveryPeer::TYPE_ID);

		$criteria->addSelectColumn(DeliveryPeer::FREE_DELIVERY);

		$criteria->addSelectColumn(DeliveryPeer::ACTIVE);

		$criteria->addSelectColumn(DeliveryPeer::ALLOW_IN_SELECTED_PRODUCTS);

		$criteria->addSelectColumn(DeliveryPeer::DEFAULT_COST);

		$criteria->addSelectColumn(DeliveryPeer::DEFAULT_COST_BRUTTO);

		$criteria->addSelectColumn(DeliveryPeer::WIDTH);

		$criteria->addSelectColumn(DeliveryPeer::HEIGHT);

		$criteria->addSelectColumn(DeliveryPeer::DEPTH);

		$criteria->addSelectColumn(DeliveryPeer::VOLUME);

		$criteria->addSelectColumn(DeliveryPeer::IS_SYSTEM_DEFAULT);

		$criteria->addSelectColumn(DeliveryPeer::OPT_NAME);

		$criteria->addSelectColumn(DeliveryPeer::OPT_DESCRIPTION);

		$criteria->addSelectColumn(DeliveryPeer::IS_DEFAULT);

		$criteria->addSelectColumn(DeliveryPeer::SECTION_COST_TYPE);

		$criteria->addSelectColumn(DeliveryPeer::MAX_ORDER_WEIGHT);

		$criteria->addSelectColumn(DeliveryPeer::MAX_ORDER_AMOUNT);

		$criteria->addSelectColumn(DeliveryPeer::MAX_ORDER_QUANTITY);

		$criteria->addSelectColumn(DeliveryPeer::MIN_ORDER_WEIGHT);

		$criteria->addSelectColumn(DeliveryPeer::MIN_ORDER_AMOUNT);

		$criteria->addSelectColumn(DeliveryPeer::MIN_ORDER_QUANTITY);

		$criteria->addSelectColumn(DeliveryPeer::POSITION);

		$criteria->addSelectColumn(DeliveryPeer::PARAMS);

		$criteria->addSelectColumn(DeliveryPeer::PACZKOMATY_TYPE);

		$criteria->addSelectColumn(DeliveryPeer::PACZKOMATY_SIZE);


		if (stEventDispatcher::getInstance()->getListeners('DeliveryPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'DeliveryPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_delivery.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_delivery.ID)';

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
			$criteria->addSelectColumn(DeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = DeliveryPeer::doSelectRS($criteria, $con);
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
	 * @return     Delivery
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = DeliveryPeer::doSelect($critcopy, $con);
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
		return DeliveryPeer::populateObjects(DeliveryPeer::doSelectRS($criteria, $con));
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
			DeliveryPeer::addSelectColumns($criteria);
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
		$cls = DeliveryPeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related CountriesArea table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinCountriesArea(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DeliveryPeer::COUNTRIES_AREA_ID, CountriesAreaPeer::ID, Criteria::LEFT_JOIN);

		$rs = DeliveryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Tax table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinTax(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DeliveryPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = DeliveryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related DeliveryType table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinDeliveryType(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DeliveryPeer::TYPE_ID, DeliveryTypePeer::ID, Criteria::LEFT_JOIN);

		$rs = DeliveryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Delivery objects pre-filled with their CountriesArea objects.
	 *
	 * @return     array Array of Delivery objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinCountriesArea(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DeliveryPeer::addSelectColumns($c);

		CountriesAreaPeer::addSelectColumns($c);

		$c->addJoin(DeliveryPeer::COUNTRIES_AREA_ID, CountriesAreaPeer::ID, Criteria::LEFT_JOIN);
		$rs = DeliveryPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Delivery();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getCountriesAreaId())
                        {

			   $obj2 = new CountriesArea();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addDelivery($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Delivery objects pre-filled with their Tax objects.
	 *
	 * @return     array Array of Delivery objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinTax(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DeliveryPeer::addSelectColumns($c);

		TaxPeer::addSelectColumns($c);

		$c->addJoin(DeliveryPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);
		$rs = DeliveryPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Delivery();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getTaxId())
                        {

			   $obj2 = new Tax();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addDelivery($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Delivery objects pre-filled with their DeliveryType objects.
	 *
	 * @return     array Array of Delivery objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinDeliveryType(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DeliveryPeer::addSelectColumns($c);

		DeliveryTypePeer::addSelectColumns($c);

		$c->addJoin(DeliveryPeer::TYPE_ID, DeliveryTypePeer::ID, Criteria::LEFT_JOIN);
		$rs = DeliveryPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Delivery();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getTypeId())
                        {

			   $obj2 = new DeliveryType();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addDelivery($obj1);
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
			$criteria->addSelectColumn(DeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DeliveryPeer::COUNTRIES_AREA_ID, CountriesAreaPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(DeliveryPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(DeliveryPeer::TYPE_ID, DeliveryTypePeer::ID, Criteria::LEFT_JOIN);

		$rs = DeliveryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Delivery objects pre-filled with all related objects.
	 *
	 * @return     array Array of Delivery objects.
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

		DeliveryPeer::addSelectColumns($c);
		$startcol2 = (DeliveryPeer::NUM_COLUMNS - DeliveryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CountriesAreaPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CountriesAreaPeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + TaxPeer::NUM_COLUMNS;

		DeliveryTypePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + DeliveryTypePeer::NUM_COLUMNS;

		$c->addJoin(DeliveryPeer::COUNTRIES_AREA_ID, CountriesAreaPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(DeliveryPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(DeliveryPeer::TYPE_ID, DeliveryTypePeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = DeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined CountriesArea rows
	
			$omClass = CountriesAreaPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCountriesArea(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDelivery($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initDeliverys();
				$obj2->addDelivery($obj1);
			}


				// Add objects for joined Tax rows
	
			$omClass = TaxPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getTax(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDelivery($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initDeliverys();
				$obj3->addDelivery($obj1);
			}


				// Add objects for joined DeliveryType rows
	
			$omClass = DeliveryTypePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getDeliveryType(); // CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addDelivery($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj4->initDeliverys();
				$obj4->addDelivery($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related CountriesArea table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptCountriesArea(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DeliveryPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(DeliveryPeer::TYPE_ID, DeliveryTypePeer::ID, Criteria::LEFT_JOIN);

		$rs = DeliveryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Tax table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptTax(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DeliveryPeer::COUNTRIES_AREA_ID, CountriesAreaPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(DeliveryPeer::TYPE_ID, DeliveryTypePeer::ID, Criteria::LEFT_JOIN);

		$rs = DeliveryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related DeliveryType table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptDeliveryType(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DeliveryPeer::COUNTRIES_AREA_ID, CountriesAreaPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(DeliveryPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = DeliveryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Delivery objects pre-filled with all related objects except CountriesArea.
	 *
	 * @return     array Array of Delivery objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptCountriesArea(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DeliveryPeer::addSelectColumns($c);
		$startcol2 = (DeliveryPeer::NUM_COLUMNS - DeliveryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		TaxPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + TaxPeer::NUM_COLUMNS;

		DeliveryTypePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DeliveryTypePeer::NUM_COLUMNS;

		$c->addJoin(DeliveryPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(DeliveryPeer::TYPE_ID, DeliveryTypePeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = DeliveryPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = TaxPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getTax(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDelivery($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDeliverys();
				$obj2->addDelivery($obj1);
			}

			$omClass = DeliveryTypePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getDeliveryType(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDelivery($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initDeliverys();
				$obj3->addDelivery($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Delivery objects pre-filled with all related objects except Tax.
	 *
	 * @return     array Array of Delivery objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptTax(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DeliveryPeer::addSelectColumns($c);
		$startcol2 = (DeliveryPeer::NUM_COLUMNS - DeliveryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CountriesAreaPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CountriesAreaPeer::NUM_COLUMNS;

		DeliveryTypePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DeliveryTypePeer::NUM_COLUMNS;

		$c->addJoin(DeliveryPeer::COUNTRIES_AREA_ID, CountriesAreaPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(DeliveryPeer::TYPE_ID, DeliveryTypePeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = DeliveryPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = CountriesAreaPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCountriesArea(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDelivery($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDeliverys();
				$obj2->addDelivery($obj1);
			}

			$omClass = DeliveryTypePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getDeliveryType(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDelivery($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initDeliverys();
				$obj3->addDelivery($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Delivery objects pre-filled with all related objects except DeliveryType.
	 *
	 * @return     array Array of Delivery objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptDeliveryType(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DeliveryPeer::addSelectColumns($c);
		$startcol2 = (DeliveryPeer::NUM_COLUMNS - DeliveryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CountriesAreaPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CountriesAreaPeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(DeliveryPeer::COUNTRIES_AREA_ID, CountriesAreaPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(DeliveryPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = DeliveryPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = CountriesAreaPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCountriesArea(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDelivery($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDeliverys();
				$obj2->addDelivery($obj1);
			}

			$omClass = TaxPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getTax(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDelivery($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initDeliverys();
				$obj3->addDelivery($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


     /**
      * Selects a collection of Delivery objects pre-filled with their i18n objects.
      *
      * @return array Array of Delivery objects.
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
          DeliveryPeer::addSelectColumns($c);
          DeliveryI18nPeer::addSelectColumns($c);
       }

      $c->addJoin(DeliveryPeer::ID, sprintf('%s AND %s = \'%s\'', DeliveryI18nPeer::ID, DeliveryI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

      $rs = DeliveryPeer::doSelectRs($c, $con);

      if (self::$hydrateMethod)
      {
         return call_user_func(self::$hydrateMethod, $rs);
      }

      $results = array();

      while($rs->next()) {

         $obj1 = new Delivery();
         $startcol = $obj1->hydrate($rs);
         $obj1->setCulture($culture);

         $obj2 = new DeliveryI18n();
         $obj2->hydrate($rs, $startcol);

         $obj1->setDeliveryI18nForCulture($obj2, $culture);
         $obj2->setDelivery($obj1);

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
		return DeliveryPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a Delivery or Criteria object.
	 *
	 * @param      mixed $values Criteria or Delivery object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseDeliveryPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseDeliveryPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from Delivery object
		}

		$criteria->remove(DeliveryPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseDeliveryPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseDeliveryPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a Delivery or Criteria object.
	 *
	 * @param      mixed $values Criteria or Delivery object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseDeliveryPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseDeliveryPeer', $values, $con);
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

			$comparison = $criteria->getComparison(DeliveryPeer::ID);
			$selectCriteria->add(DeliveryPeer::ID, $criteria->remove(DeliveryPeer::ID), $comparison);

		} else { // $values is Delivery object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseDeliveryPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseDeliveryPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_delivery table.
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
			$affectedRows += DeliveryPeer::doOnDeleteCascade(new Criteria(), $con);
			DeliveryPeer::doOnDeleteSetNull(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(DeliveryPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a Delivery or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or Delivery object or primary key or array of primary keys
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
			$con = Propel::getConnection(DeliveryPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof Delivery) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(DeliveryPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += DeliveryPeer::doOnDeleteCascade($criteria, $con);DeliveryPeer::doOnDeleteSetNull($criteria, $con);
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
		$objects = DeliveryPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related DeliverySections objects
			$c = new Criteria();
			
			$c->add(DeliverySectionsPeer::DELIVERY_ID, $obj->getId());
			$affectedRows += DeliverySectionsPeer::doDelete($c, $con);

			// delete related DeliveryHasPaymentType objects
			$c = new Criteria();
			
			$c->add(DeliveryHasPaymentTypePeer::DELIVERY_ID, $obj->getId());
			$affectedRows += DeliveryHasPaymentTypePeer::doDelete($c, $con);

			// delete related DeliveryI18n objects
			$c = new Criteria();
			
			$c->add(DeliveryI18nPeer::ID, $obj->getId());
			$affectedRows += DeliveryI18nPeer::doDelete($c, $con);
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
		$objects = DeliveryPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {

			// set fkey col in related OrderDelivery rows to NULL
			$selectCriteria = new Criteria(DeliveryPeer::DATABASE_NAME);
			$updateValues = new Criteria(DeliveryPeer::DATABASE_NAME);
			$selectCriteria->add(OrderDeliveryPeer::DELIVERY_ID, $obj->getId());
			$updateValues->add(OrderDeliveryPeer::DELIVERY_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

		}
	}

	/**
	 * Validates all modified columns of given Delivery object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      Delivery $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(Delivery $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(DeliveryPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(DeliveryPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(DeliveryPeer::DATABASE_NAME, DeliveryPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = DeliveryPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     Delivery
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(DeliveryPeer::DATABASE_NAME);

		$criteria->add(DeliveryPeer::ID, $pk);


		$v = DeliveryPeer::doSelect($criteria, $con);

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
			$criteria->add(DeliveryPeer::ID, $pks, Criteria::IN);
			$objs = DeliveryPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseDeliveryPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseDeliveryPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stDeliveryPlugin.lib.model.map.DeliveryMapBuilder');
}
