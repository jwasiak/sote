<?php

/**
 * Base static class for performing query and update operations on the 'st_order_delivery' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseOrderDeliveryPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_order_delivery';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.OrderDelivery';

	/** The total number of columns. */
	const NUM_COLUMNS = 18;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_order_delivery.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_order_delivery.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_order_delivery.ID';

	/** the column name for the TAX_ID field */
	const TAX_ID = 'st_order_delivery.TAX_ID';

	/** the column name for the DELIVERY_ID field */
	const DELIVERY_ID = 'st_order_delivery.DELIVERY_ID';

	/** the column name for the NAME field */
	const NAME = 'st_order_delivery.NAME';

	/** the column name for the COST field */
	const COST = 'st_order_delivery.COST';

	/** the column name for the PAYMENT_COST field */
	const PAYMENT_COST = 'st_order_delivery.PAYMENT_COST';

	/** the column name for the OPT_TAX field */
	const OPT_TAX = 'st_order_delivery.OPT_TAX';

	/** the column name for the NUMBER field */
	const NUMBER = 'st_order_delivery.NUMBER';

	/** the column name for the COST_BRUTTO field */
	const COST_BRUTTO = 'st_order_delivery.COST_BRUTTO';

	/** the column name for the PAYMENT_COST_BRUTTO field */
	const PAYMENT_COST_BRUTTO = 'st_order_delivery.PAYMENT_COST_BRUTTO';

	/** the column name for the CUSTOM_COST_BRUTTO field */
	const CUSTOM_COST_BRUTTO = 'st_order_delivery.CUSTOM_COST_BRUTTO';

	/** the column name for the DELIVERY_DATE field */
	const DELIVERY_DATE = 'st_order_delivery.DELIVERY_DATE';

	/** the column name for the PICKUP_POINT field */
	const PICKUP_POINT = 'st_order_delivery.PICKUP_POINT';

	/** the column name for the OPT_ALLEGRO_DELIVERY_METHOD_ID field */
	const OPT_ALLEGRO_DELIVERY_METHOD_ID = 'st_order_delivery.OPT_ALLEGRO_DELIVERY_METHOD_ID';

	/** the column name for the OPT_ALLEGRO_DELIVERY_SMART field */
	const OPT_ALLEGRO_DELIVERY_SMART = 'st_order_delivery.OPT_ALLEGRO_DELIVERY_SMART';

	/** the column name for the PACZKOMATY_NUMBER field */
	const PACZKOMATY_NUMBER = 'st_order_delivery.PACZKOMATY_NUMBER';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'TaxId', 'DeliveryId', 'Name', 'Cost', 'PaymentCost', 'OptTax', 'Number', 'CostBrutto', 'PaymentCostBrutto', 'CustomCostBrutto', 'DeliveryDate', 'PickupPoint', 'OptAllegroDeliveryMethodId', 'OptAllegroDeliverySmart', 'PaczkomatyNumber', ),
		BasePeer::TYPE_COLNAME => array (OrderDeliveryPeer::CREATED_AT, OrderDeliveryPeer::UPDATED_AT, OrderDeliveryPeer::ID, OrderDeliveryPeer::TAX_ID, OrderDeliveryPeer::DELIVERY_ID, OrderDeliveryPeer::NAME, OrderDeliveryPeer::COST, OrderDeliveryPeer::PAYMENT_COST, OrderDeliveryPeer::OPT_TAX, OrderDeliveryPeer::NUMBER, OrderDeliveryPeer::COST_BRUTTO, OrderDeliveryPeer::PAYMENT_COST_BRUTTO, OrderDeliveryPeer::CUSTOM_COST_BRUTTO, OrderDeliveryPeer::DELIVERY_DATE, OrderDeliveryPeer::PICKUP_POINT, OrderDeliveryPeer::OPT_ALLEGRO_DELIVERY_METHOD_ID, OrderDeliveryPeer::OPT_ALLEGRO_DELIVERY_SMART, OrderDeliveryPeer::PACZKOMATY_NUMBER, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'tax_id', 'delivery_id', 'name', 'cost', 'payment_cost', 'opt_tax', 'number', 'cost_brutto', 'payment_cost_brutto', 'custom_cost_brutto', 'delivery_date', 'pickup_point', 'opt_allegro_delivery_method_id', 'opt_allegro_delivery_smart', 'paczkomaty_number', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'TaxId' => 3, 'DeliveryId' => 4, 'Name' => 5, 'Cost' => 6, 'PaymentCost' => 7, 'OptTax' => 8, 'Number' => 9, 'CostBrutto' => 10, 'PaymentCostBrutto' => 11, 'CustomCostBrutto' => 12, 'DeliveryDate' => 13, 'PickupPoint' => 14, 'OptAllegroDeliveryMethodId' => 15, 'OptAllegroDeliverySmart' => 16, 'PaczkomatyNumber' => 17, ),
		BasePeer::TYPE_COLNAME => array (OrderDeliveryPeer::CREATED_AT => 0, OrderDeliveryPeer::UPDATED_AT => 1, OrderDeliveryPeer::ID => 2, OrderDeliveryPeer::TAX_ID => 3, OrderDeliveryPeer::DELIVERY_ID => 4, OrderDeliveryPeer::NAME => 5, OrderDeliveryPeer::COST => 6, OrderDeliveryPeer::PAYMENT_COST => 7, OrderDeliveryPeer::OPT_TAX => 8, OrderDeliveryPeer::NUMBER => 9, OrderDeliveryPeer::COST_BRUTTO => 10, OrderDeliveryPeer::PAYMENT_COST_BRUTTO => 11, OrderDeliveryPeer::CUSTOM_COST_BRUTTO => 12, OrderDeliveryPeer::DELIVERY_DATE => 13, OrderDeliveryPeer::PICKUP_POINT => 14, OrderDeliveryPeer::OPT_ALLEGRO_DELIVERY_METHOD_ID => 15, OrderDeliveryPeer::OPT_ALLEGRO_DELIVERY_SMART => 16, OrderDeliveryPeer::PACZKOMATY_NUMBER => 17, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'tax_id' => 3, 'delivery_id' => 4, 'name' => 5, 'cost' => 6, 'payment_cost' => 7, 'opt_tax' => 8, 'number' => 9, 'cost_brutto' => 10, 'payment_cost_brutto' => 11, 'custom_cost_brutto' => 12, 'delivery_date' => 13, 'pickup_point' => 14, 'opt_allegro_delivery_method_id' => 15, 'opt_allegro_delivery_smart' => 16, 'paczkomaty_number' => 17, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
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
		return BasePeer::getMapBuilder('lib.model.map.OrderDeliveryMapBuilder');
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
			$map = OrderDeliveryPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. OrderDeliveryPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(OrderDeliveryPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(OrderDeliveryPeer::CREATED_AT);

		$criteria->addSelectColumn(OrderDeliveryPeer::UPDATED_AT);

		$criteria->addSelectColumn(OrderDeliveryPeer::ID);

		$criteria->addSelectColumn(OrderDeliveryPeer::TAX_ID);

		$criteria->addSelectColumn(OrderDeliveryPeer::DELIVERY_ID);

		$criteria->addSelectColumn(OrderDeliveryPeer::NAME);

		$criteria->addSelectColumn(OrderDeliveryPeer::COST);

		$criteria->addSelectColumn(OrderDeliveryPeer::PAYMENT_COST);

		$criteria->addSelectColumn(OrderDeliveryPeer::OPT_TAX);

		$criteria->addSelectColumn(OrderDeliveryPeer::NUMBER);

		$criteria->addSelectColumn(OrderDeliveryPeer::COST_BRUTTO);

		$criteria->addSelectColumn(OrderDeliveryPeer::PAYMENT_COST_BRUTTO);

		$criteria->addSelectColumn(OrderDeliveryPeer::CUSTOM_COST_BRUTTO);

		$criteria->addSelectColumn(OrderDeliveryPeer::DELIVERY_DATE);

		$criteria->addSelectColumn(OrderDeliveryPeer::PICKUP_POINT);

		$criteria->addSelectColumn(OrderDeliveryPeer::OPT_ALLEGRO_DELIVERY_METHOD_ID);

		$criteria->addSelectColumn(OrderDeliveryPeer::OPT_ALLEGRO_DELIVERY_SMART);

		$criteria->addSelectColumn(OrderDeliveryPeer::PACZKOMATY_NUMBER);


		if (stEventDispatcher::getInstance()->getListeners('OrderDeliveryPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'OrderDeliveryPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_order_delivery.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_order_delivery.ID)';

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
			$criteria->addSelectColumn(OrderDeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderDeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OrderDeliveryPeer::doSelectRS($criteria, $con);
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
	 * @return     OrderDelivery
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = OrderDeliveryPeer::doSelect($critcopy, $con);
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
		return OrderDeliveryPeer::populateObjects(OrderDeliveryPeer::doSelectRS($criteria, $con));
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
			OrderDeliveryPeer::addSelectColumns($criteria);
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
		$cls = OrderDeliveryPeer::getOMClass();
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
			$criteria->addSelectColumn(OrderDeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderDeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderDeliveryPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderDeliveryPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(OrderDeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderDeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderDeliveryPeer::DELIVERY_ID, DeliveryPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderDeliveryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of OrderDelivery objects pre-filled with their Tax objects.
	 *
	 * @return     array Array of OrderDelivery objects.
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

		OrderDeliveryPeer::addSelectColumns($c);

		TaxPeer::addSelectColumns($c);

		$c->addJoin(OrderDeliveryPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);
		$rs = OrderDeliveryPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new OrderDelivery();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getTaxId())
                        {

			   $obj2 = new Tax();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrderDelivery($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of OrderDelivery objects pre-filled with their Delivery objects.
	 *
	 * @return     array Array of OrderDelivery objects.
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

		OrderDeliveryPeer::addSelectColumns($c);

		DeliveryPeer::addSelectColumns($c);

		$c->addJoin(OrderDeliveryPeer::DELIVERY_ID, DeliveryPeer::ID, Criteria::LEFT_JOIN);
		$rs = OrderDeliveryPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new OrderDelivery();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getDeliveryId())
                        {

			   $obj2 = new Delivery();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrderDelivery($obj1);
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
			$criteria->addSelectColumn(OrderDeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderDeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderDeliveryPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderDeliveryPeer::DELIVERY_ID, DeliveryPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderDeliveryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of OrderDelivery objects pre-filled with all related objects.
	 *
	 * @return     array Array of OrderDelivery objects.
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

		OrderDeliveryPeer::addSelectColumns($c);
		$startcol2 = (OrderDeliveryPeer::NUM_COLUMNS - OrderDeliveryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		TaxPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + TaxPeer::NUM_COLUMNS;

		DeliveryPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DeliveryPeer::NUM_COLUMNS;

		$c->addJoin(OrderDeliveryPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderDeliveryPeer::DELIVERY_ID, DeliveryPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined Tax rows
	
			$omClass = TaxPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getTax(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOrderDelivery($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrderDeliverys();
				$obj2->addOrderDelivery($obj1);
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
					$temp_obj3->addOrderDelivery($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initOrderDeliverys();
				$obj3->addOrderDelivery($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
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
			$criteria->addSelectColumn(OrderDeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderDeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderDeliveryPeer::DELIVERY_ID, DeliveryPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderDeliveryPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(OrderDeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderDeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderDeliveryPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderDeliveryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of OrderDelivery objects pre-filled with all related objects except Tax.
	 *
	 * @return     array Array of OrderDelivery objects.
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

		OrderDeliveryPeer::addSelectColumns($c);
		$startcol2 = (OrderDeliveryPeer::NUM_COLUMNS - OrderDeliveryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		DeliveryPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + DeliveryPeer::NUM_COLUMNS;

		$c->addJoin(OrderDeliveryPeer::DELIVERY_ID, DeliveryPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderDeliveryPeer::getOMClass();

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
					$temp_obj2->addOrderDelivery($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrderDeliverys();
				$obj2->addOrderDelivery($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of OrderDelivery objects pre-filled with all related objects except Delivery.
	 *
	 * @return     array Array of OrderDelivery objects.
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

		OrderDeliveryPeer::addSelectColumns($c);
		$startcol2 = (OrderDeliveryPeer::NUM_COLUMNS - OrderDeliveryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		TaxPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(OrderDeliveryPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderDeliveryPeer::getOMClass();

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
					$temp_obj2->addOrderDelivery($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrderDeliverys();
				$obj2->addOrderDelivery($obj1);
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
		return OrderDeliveryPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a OrderDelivery or Criteria object.
	 *
	 * @param      mixed $values Criteria or OrderDelivery object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseOrderDeliveryPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseOrderDeliveryPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from OrderDelivery object
		}

		$criteria->remove(OrderDeliveryPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseOrderDeliveryPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseOrderDeliveryPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a OrderDelivery or Criteria object.
	 *
	 * @param      mixed $values Criteria or OrderDelivery object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseOrderDeliveryPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseOrderDeliveryPeer', $values, $con);
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

			$comparison = $criteria->getComparison(OrderDeliveryPeer::ID);
			$selectCriteria->add(OrderDeliveryPeer::ID, $criteria->remove(OrderDeliveryPeer::ID), $comparison);

		} else { // $values is OrderDelivery object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseOrderDeliveryPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseOrderDeliveryPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_order_delivery table.
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
			OrderDeliveryPeer::doOnDeleteSetNull(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(OrderDeliveryPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a OrderDelivery or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or OrderDelivery object or primary key or array of primary keys
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
			$con = Propel::getConnection(OrderDeliveryPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof OrderDelivery) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(OrderDeliveryPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			OrderDeliveryPeer::doOnDeleteSetNull($criteria, $con);
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
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
		$objects = OrderDeliveryPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {

			// set fkey col in related Order rows to NULL
			$selectCriteria = new Criteria(OrderDeliveryPeer::DATABASE_NAME);
			$updateValues = new Criteria(OrderDeliveryPeer::DATABASE_NAME);
			$selectCriteria->add(OrderPeer::ORDER_DELIVERY_ID, $obj->getId());
			$updateValues->add(OrderPeer::ORDER_DELIVERY_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

		}
	}

	/**
	 * Validates all modified columns of given OrderDelivery object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      OrderDelivery $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(OrderDelivery $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OrderDeliveryPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OrderDeliveryPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OrderDeliveryPeer::DATABASE_NAME, OrderDeliveryPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OrderDeliveryPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     OrderDelivery
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(OrderDeliveryPeer::DATABASE_NAME);

		$criteria->add(OrderDeliveryPeer::ID, $pk);


		$v = OrderDeliveryPeer::doSelect($criteria, $con);

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
			$criteria->add(OrderDeliveryPeer::ID, $pks, Criteria::IN);
			$objs = OrderDeliveryPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseOrderDeliveryPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseOrderDeliveryPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('lib.model.map.OrderDeliveryMapBuilder');
}
