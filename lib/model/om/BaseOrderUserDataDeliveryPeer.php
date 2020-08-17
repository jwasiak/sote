<?php

/**
 * Base static class for performing query and update operations on the 'st_order_user_data_delivery' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseOrderUserDataDeliveryPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_order_user_data_delivery';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.OrderUserDataDelivery';

	/** The total number of columns. */
	const NUM_COLUMNS = 21;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_order_user_data_delivery.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_order_user_data_delivery.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_order_user_data_delivery.ID';

	/** the column name for the COUNTRIES_ID field */
	const COUNTRIES_ID = 'st_order_user_data_delivery.COUNTRIES_ID';

	/** the column name for the COUNTRY field */
	const COUNTRY = 'st_order_user_data_delivery.COUNTRY';

	/** the column name for the FULL_NAME field */
	const FULL_NAME = 'st_order_user_data_delivery.FULL_NAME';

	/** the column name for the ADDRESS field */
	const ADDRESS = 'st_order_user_data_delivery.ADDRESS';

	/** the column name for the ADDRESS_MORE field */
	const ADDRESS_MORE = 'st_order_user_data_delivery.ADDRESS_MORE';

	/** the column name for the REGION field */
	const REGION = 'st_order_user_data_delivery.REGION';

	/** the column name for the NAME field */
	const NAME = 'st_order_user_data_delivery.NAME';

	/** the column name for the SURNAME field */
	const SURNAME = 'st_order_user_data_delivery.SURNAME';

	/** the column name for the STREET field */
	const STREET = 'st_order_user_data_delivery.STREET';

	/** the column name for the HOUSE field */
	const HOUSE = 'st_order_user_data_delivery.HOUSE';

	/** the column name for the FLAT field */
	const FLAT = 'st_order_user_data_delivery.FLAT';

	/** the column name for the CODE field */
	const CODE = 'st_order_user_data_delivery.CODE';

	/** the column name for the TOWN field */
	const TOWN = 'st_order_user_data_delivery.TOWN';

	/** the column name for the PHONE field */
	const PHONE = 'st_order_user_data_delivery.PHONE';

	/** the column name for the COMPANY field */
	const COMPANY = 'st_order_user_data_delivery.COMPANY';

	/** the column name for the VAT_NUMBER field */
	const VAT_NUMBER = 'st_order_user_data_delivery.VAT_NUMBER';

	/** the column name for the PESEL field */
	const PESEL = 'st_order_user_data_delivery.PESEL';

	/** the column name for the CRYPT field */
	const CRYPT = 'st_order_user_data_delivery.CRYPT';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'CountriesId', 'Country', 'FullName', 'Address', 'AddressMore', 'Region', 'Name', 'Surname', 'Street', 'House', 'Flat', 'Code', 'Town', 'Phone', 'Company', 'VatNumber', 'Pesel', 'Crypt', ),
		BasePeer::TYPE_COLNAME => array (OrderUserDataDeliveryPeer::CREATED_AT, OrderUserDataDeliveryPeer::UPDATED_AT, OrderUserDataDeliveryPeer::ID, OrderUserDataDeliveryPeer::COUNTRIES_ID, OrderUserDataDeliveryPeer::COUNTRY, OrderUserDataDeliveryPeer::FULL_NAME, OrderUserDataDeliveryPeer::ADDRESS, OrderUserDataDeliveryPeer::ADDRESS_MORE, OrderUserDataDeliveryPeer::REGION, OrderUserDataDeliveryPeer::NAME, OrderUserDataDeliveryPeer::SURNAME, OrderUserDataDeliveryPeer::STREET, OrderUserDataDeliveryPeer::HOUSE, OrderUserDataDeliveryPeer::FLAT, OrderUserDataDeliveryPeer::CODE, OrderUserDataDeliveryPeer::TOWN, OrderUserDataDeliveryPeer::PHONE, OrderUserDataDeliveryPeer::COMPANY, OrderUserDataDeliveryPeer::VAT_NUMBER, OrderUserDataDeliveryPeer::PESEL, OrderUserDataDeliveryPeer::CRYPT, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'countries_id', 'country', 'full_name', 'address', 'address_more', 'region', 'name', 'surname', 'street', 'house', 'flat', 'code', 'town', 'phone', 'company', 'vat_number', 'pesel', 'crypt', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'CountriesId' => 3, 'Country' => 4, 'FullName' => 5, 'Address' => 6, 'AddressMore' => 7, 'Region' => 8, 'Name' => 9, 'Surname' => 10, 'Street' => 11, 'House' => 12, 'Flat' => 13, 'Code' => 14, 'Town' => 15, 'Phone' => 16, 'Company' => 17, 'VatNumber' => 18, 'Pesel' => 19, 'Crypt' => 20, ),
		BasePeer::TYPE_COLNAME => array (OrderUserDataDeliveryPeer::CREATED_AT => 0, OrderUserDataDeliveryPeer::UPDATED_AT => 1, OrderUserDataDeliveryPeer::ID => 2, OrderUserDataDeliveryPeer::COUNTRIES_ID => 3, OrderUserDataDeliveryPeer::COUNTRY => 4, OrderUserDataDeliveryPeer::FULL_NAME => 5, OrderUserDataDeliveryPeer::ADDRESS => 6, OrderUserDataDeliveryPeer::ADDRESS_MORE => 7, OrderUserDataDeliveryPeer::REGION => 8, OrderUserDataDeliveryPeer::NAME => 9, OrderUserDataDeliveryPeer::SURNAME => 10, OrderUserDataDeliveryPeer::STREET => 11, OrderUserDataDeliveryPeer::HOUSE => 12, OrderUserDataDeliveryPeer::FLAT => 13, OrderUserDataDeliveryPeer::CODE => 14, OrderUserDataDeliveryPeer::TOWN => 15, OrderUserDataDeliveryPeer::PHONE => 16, OrderUserDataDeliveryPeer::COMPANY => 17, OrderUserDataDeliveryPeer::VAT_NUMBER => 18, OrderUserDataDeliveryPeer::PESEL => 19, OrderUserDataDeliveryPeer::CRYPT => 20, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'countries_id' => 3, 'country' => 4, 'full_name' => 5, 'address' => 6, 'address_more' => 7, 'region' => 8, 'name' => 9, 'surname' => 10, 'street' => 11, 'house' => 12, 'flat' => 13, 'code' => 14, 'town' => 15, 'phone' => 16, 'company' => 17, 'vat_number' => 18, 'pesel' => 19, 'crypt' => 20, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
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
		return BasePeer::getMapBuilder('lib.model.map.OrderUserDataDeliveryMapBuilder');
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
			$map = OrderUserDataDeliveryPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. OrderUserDataDeliveryPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(OrderUserDataDeliveryPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::CREATED_AT);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::UPDATED_AT);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::ID);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::COUNTRIES_ID);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::COUNTRY);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::FULL_NAME);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::ADDRESS);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::ADDRESS_MORE);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::REGION);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::NAME);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::SURNAME);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::STREET);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::HOUSE);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::FLAT);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::CODE);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::TOWN);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::PHONE);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::COMPANY);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::VAT_NUMBER);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::PESEL);

		$criteria->addSelectColumn(OrderUserDataDeliveryPeer::CRYPT);


		if (stEventDispatcher::getInstance()->getListeners('OrderUserDataDeliveryPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'OrderUserDataDeliveryPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_order_user_data_delivery.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_order_user_data_delivery.ID)';

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
			$criteria->addSelectColumn(OrderUserDataDeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderUserDataDeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OrderUserDataDeliveryPeer::doSelectRS($criteria, $con);
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
	 * @return     OrderUserDataDelivery
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = OrderUserDataDeliveryPeer::doSelect($critcopy, $con);
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
		return OrderUserDataDeliveryPeer::populateObjects(OrderUserDataDeliveryPeer::doSelectRS($criteria, $con));
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
			OrderUserDataDeliveryPeer::addSelectColumns($criteria);
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
		$cls = OrderUserDataDeliveryPeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related Countries table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinCountries(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderUserDataDeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderUserDataDeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderUserDataDeliveryPeer::COUNTRIES_ID, CountriesPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderUserDataDeliveryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of OrderUserDataDelivery objects pre-filled with their Countries objects.
	 *
	 * @return     array Array of OrderUserDataDelivery objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinCountries(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderUserDataDeliveryPeer::addSelectColumns($c);

		CountriesPeer::addSelectColumns($c);

		$c->addJoin(OrderUserDataDeliveryPeer::COUNTRIES_ID, CountriesPeer::ID, Criteria::LEFT_JOIN);
		$rs = OrderUserDataDeliveryPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new OrderUserDataDelivery();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getCountriesId())
                        {

			   $obj2 = new Countries();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrderUserDataDelivery($obj1);
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
			$criteria->addSelectColumn(OrderUserDataDeliveryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderUserDataDeliveryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderUserDataDeliveryPeer::COUNTRIES_ID, CountriesPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderUserDataDeliveryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of OrderUserDataDelivery objects pre-filled with all related objects.
	 *
	 * @return     array Array of OrderUserDataDelivery objects.
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

		OrderUserDataDeliveryPeer::addSelectColumns($c);
		$startcol2 = (OrderUserDataDeliveryPeer::NUM_COLUMNS - OrderUserDataDeliveryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CountriesPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CountriesPeer::NUM_COLUMNS;

		$c->addJoin(OrderUserDataDeliveryPeer::COUNTRIES_ID, CountriesPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderUserDataDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined Countries rows
	
			$omClass = CountriesPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCountries(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOrderUserDataDelivery($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrderUserDataDeliverys();
				$obj2->addOrderUserDataDelivery($obj1);
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
		return OrderUserDataDeliveryPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a OrderUserDataDelivery or Criteria object.
	 *
	 * @param      mixed $values Criteria or OrderUserDataDelivery object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseOrderUserDataDeliveryPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseOrderUserDataDeliveryPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from OrderUserDataDelivery object
		}

		$criteria->remove(OrderUserDataDeliveryPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseOrderUserDataDeliveryPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseOrderUserDataDeliveryPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a OrderUserDataDelivery or Criteria object.
	 *
	 * @param      mixed $values Criteria or OrderUserDataDelivery object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseOrderUserDataDeliveryPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseOrderUserDataDeliveryPeer', $values, $con);
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

			$comparison = $criteria->getComparison(OrderUserDataDeliveryPeer::ID);
			$selectCriteria->add(OrderUserDataDeliveryPeer::ID, $criteria->remove(OrderUserDataDeliveryPeer::ID), $comparison);

		} else { // $values is OrderUserDataDelivery object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseOrderUserDataDeliveryPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseOrderUserDataDeliveryPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_order_user_data_delivery table.
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
			OrderUserDataDeliveryPeer::doOnDeleteSetNull(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(OrderUserDataDeliveryPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a OrderUserDataDelivery or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or OrderUserDataDelivery object or primary key or array of primary keys
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
			$con = Propel::getConnection(OrderUserDataDeliveryPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof OrderUserDataDelivery) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(OrderUserDataDeliveryPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			OrderUserDataDeliveryPeer::doOnDeleteSetNull($criteria, $con);
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
		$objects = OrderUserDataDeliveryPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {

			// set fkey col in related Order rows to NULL
			$selectCriteria = new Criteria(OrderUserDataDeliveryPeer::DATABASE_NAME);
			$updateValues = new Criteria(OrderUserDataDeliveryPeer::DATABASE_NAME);
			$selectCriteria->add(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, $obj->getId());
			$updateValues->add(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

		}
	}

	/**
	 * Validates all modified columns of given OrderUserDataDelivery object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      OrderUserDataDelivery $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(OrderUserDataDelivery $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OrderUserDataDeliveryPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OrderUserDataDeliveryPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OrderUserDataDeliveryPeer::DATABASE_NAME, OrderUserDataDeliveryPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OrderUserDataDeliveryPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     OrderUserDataDelivery
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(OrderUserDataDeliveryPeer::DATABASE_NAME);

		$criteria->add(OrderUserDataDeliveryPeer::ID, $pk);


		$v = OrderUserDataDeliveryPeer::doSelect($criteria, $con);

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
			$criteria->add(OrderUserDataDeliveryPeer::ID, $pks, Criteria::IN);
			$objs = OrderUserDataDeliveryPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseOrderUserDataDeliveryPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseOrderUserDataDeliveryPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('lib.model.map.OrderUserDataDeliveryMapBuilder');
}
