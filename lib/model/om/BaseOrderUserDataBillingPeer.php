<?php

/**
 * Base static class for performing query and update operations on the 'st_order_user_data_billing' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseOrderUserDataBillingPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_order_user_data_billing';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.OrderUserDataBilling';

	/** The total number of columns. */
	const NUM_COLUMNS = 22;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_order_user_data_billing.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_order_user_data_billing.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_order_user_data_billing.ID';

	/** the column name for the COUNTRIES_ID field */
	const COUNTRIES_ID = 'st_order_user_data_billing.COUNTRIES_ID';

	/** the column name for the HAS_VALID_VAT_EU field */
	const HAS_VALID_VAT_EU = 'st_order_user_data_billing.HAS_VALID_VAT_EU';

	/** the column name for the COUNTRY field */
	const COUNTRY = 'st_order_user_data_billing.COUNTRY';

	/** the column name for the FULL_NAME field */
	const FULL_NAME = 'st_order_user_data_billing.FULL_NAME';

	/** the column name for the ADDRESS field */
	const ADDRESS = 'st_order_user_data_billing.ADDRESS';

	/** the column name for the ADDRESS_MORE field */
	const ADDRESS_MORE = 'st_order_user_data_billing.ADDRESS_MORE';

	/** the column name for the REGION field */
	const REGION = 'st_order_user_data_billing.REGION';

	/** the column name for the NAME field */
	const NAME = 'st_order_user_data_billing.NAME';

	/** the column name for the SURNAME field */
	const SURNAME = 'st_order_user_data_billing.SURNAME';

	/** the column name for the STREET field */
	const STREET = 'st_order_user_data_billing.STREET';

	/** the column name for the HOUSE field */
	const HOUSE = 'st_order_user_data_billing.HOUSE';

	/** the column name for the FLAT field */
	const FLAT = 'st_order_user_data_billing.FLAT';

	/** the column name for the CODE field */
	const CODE = 'st_order_user_data_billing.CODE';

	/** the column name for the TOWN field */
	const TOWN = 'st_order_user_data_billing.TOWN';

	/** the column name for the PHONE field */
	const PHONE = 'st_order_user_data_billing.PHONE';

	/** the column name for the COMPANY field */
	const COMPANY = 'st_order_user_data_billing.COMPANY';

	/** the column name for the VAT_NUMBER field */
	const VAT_NUMBER = 'st_order_user_data_billing.VAT_NUMBER';

	/** the column name for the PESEL field */
	const PESEL = 'st_order_user_data_billing.PESEL';

	/** the column name for the CRYPT field */
	const CRYPT = 'st_order_user_data_billing.CRYPT';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'CountriesId', 'HasValidVatEu', 'Country', 'FullName', 'Address', 'AddressMore', 'Region', 'Name', 'Surname', 'Street', 'House', 'Flat', 'Code', 'Town', 'Phone', 'Company', 'VatNumber', 'Pesel', 'Crypt', ),
		BasePeer::TYPE_COLNAME => array (OrderUserDataBillingPeer::CREATED_AT, OrderUserDataBillingPeer::UPDATED_AT, OrderUserDataBillingPeer::ID, OrderUserDataBillingPeer::COUNTRIES_ID, OrderUserDataBillingPeer::HAS_VALID_VAT_EU, OrderUserDataBillingPeer::COUNTRY, OrderUserDataBillingPeer::FULL_NAME, OrderUserDataBillingPeer::ADDRESS, OrderUserDataBillingPeer::ADDRESS_MORE, OrderUserDataBillingPeer::REGION, OrderUserDataBillingPeer::NAME, OrderUserDataBillingPeer::SURNAME, OrderUserDataBillingPeer::STREET, OrderUserDataBillingPeer::HOUSE, OrderUserDataBillingPeer::FLAT, OrderUserDataBillingPeer::CODE, OrderUserDataBillingPeer::TOWN, OrderUserDataBillingPeer::PHONE, OrderUserDataBillingPeer::COMPANY, OrderUserDataBillingPeer::VAT_NUMBER, OrderUserDataBillingPeer::PESEL, OrderUserDataBillingPeer::CRYPT, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'countries_id', 'has_valid_vat_eu', 'country', 'full_name', 'address', 'address_more', 'region', 'name', 'surname', 'street', 'house', 'flat', 'code', 'town', 'phone', 'company', 'vat_number', 'pesel', 'crypt', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'CountriesId' => 3, 'HasValidVatEu' => 4, 'Country' => 5, 'FullName' => 6, 'Address' => 7, 'AddressMore' => 8, 'Region' => 9, 'Name' => 10, 'Surname' => 11, 'Street' => 12, 'House' => 13, 'Flat' => 14, 'Code' => 15, 'Town' => 16, 'Phone' => 17, 'Company' => 18, 'VatNumber' => 19, 'Pesel' => 20, 'Crypt' => 21, ),
		BasePeer::TYPE_COLNAME => array (OrderUserDataBillingPeer::CREATED_AT => 0, OrderUserDataBillingPeer::UPDATED_AT => 1, OrderUserDataBillingPeer::ID => 2, OrderUserDataBillingPeer::COUNTRIES_ID => 3, OrderUserDataBillingPeer::HAS_VALID_VAT_EU => 4, OrderUserDataBillingPeer::COUNTRY => 5, OrderUserDataBillingPeer::FULL_NAME => 6, OrderUserDataBillingPeer::ADDRESS => 7, OrderUserDataBillingPeer::ADDRESS_MORE => 8, OrderUserDataBillingPeer::REGION => 9, OrderUserDataBillingPeer::NAME => 10, OrderUserDataBillingPeer::SURNAME => 11, OrderUserDataBillingPeer::STREET => 12, OrderUserDataBillingPeer::HOUSE => 13, OrderUserDataBillingPeer::FLAT => 14, OrderUserDataBillingPeer::CODE => 15, OrderUserDataBillingPeer::TOWN => 16, OrderUserDataBillingPeer::PHONE => 17, OrderUserDataBillingPeer::COMPANY => 18, OrderUserDataBillingPeer::VAT_NUMBER => 19, OrderUserDataBillingPeer::PESEL => 20, OrderUserDataBillingPeer::CRYPT => 21, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'countries_id' => 3, 'has_valid_vat_eu' => 4, 'country' => 5, 'full_name' => 6, 'address' => 7, 'address_more' => 8, 'region' => 9, 'name' => 10, 'surname' => 11, 'street' => 12, 'house' => 13, 'flat' => 14, 'code' => 15, 'town' => 16, 'phone' => 17, 'company' => 18, 'vat_number' => 19, 'pesel' => 20, 'crypt' => 21, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, )
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
		return BasePeer::getMapBuilder('lib.model.map.OrderUserDataBillingMapBuilder');
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
			$map = OrderUserDataBillingPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. OrderUserDataBillingPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(OrderUserDataBillingPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(OrderUserDataBillingPeer::CREATED_AT);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::UPDATED_AT);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::ID);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::COUNTRIES_ID);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::HAS_VALID_VAT_EU);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::COUNTRY);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::FULL_NAME);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::ADDRESS);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::ADDRESS_MORE);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::REGION);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::NAME);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::SURNAME);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::STREET);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::HOUSE);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::FLAT);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::CODE);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::TOWN);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::PHONE);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::COMPANY);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::VAT_NUMBER);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::PESEL);

		$criteria->addSelectColumn(OrderUserDataBillingPeer::CRYPT);


		if (stEventDispatcher::getInstance()->getListeners('OrderUserDataBillingPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'OrderUserDataBillingPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_order_user_data_billing.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_order_user_data_billing.ID)';

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
			$criteria->addSelectColumn(OrderUserDataBillingPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderUserDataBillingPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OrderUserDataBillingPeer::doSelectRS($criteria, $con);
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
	 * @return     OrderUserDataBilling
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = OrderUserDataBillingPeer::doSelect($critcopy, $con);
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
		return OrderUserDataBillingPeer::populateObjects(OrderUserDataBillingPeer::doSelectRS($criteria, $con));
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
			OrderUserDataBillingPeer::addSelectColumns($criteria);
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
		$cls = OrderUserDataBillingPeer::getOMClass();
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
			$criteria->addSelectColumn(OrderUserDataBillingPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderUserDataBillingPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderUserDataBillingPeer::COUNTRIES_ID, CountriesPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderUserDataBillingPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of OrderUserDataBilling objects pre-filled with their Countries objects.
	 *
	 * @return     array Array of OrderUserDataBilling objects.
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

		OrderUserDataBillingPeer::addSelectColumns($c);

		CountriesPeer::addSelectColumns($c);

		$c->addJoin(OrderUserDataBillingPeer::COUNTRIES_ID, CountriesPeer::ID, Criteria::LEFT_JOIN);
		$rs = OrderUserDataBillingPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new OrderUserDataBilling();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getCountriesId())
                        {

			   $obj2 = new Countries();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrderUserDataBilling($obj1);
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
			$criteria->addSelectColumn(OrderUserDataBillingPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderUserDataBillingPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderUserDataBillingPeer::COUNTRIES_ID, CountriesPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderUserDataBillingPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of OrderUserDataBilling objects pre-filled with all related objects.
	 *
	 * @return     array Array of OrderUserDataBilling objects.
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

		OrderUserDataBillingPeer::addSelectColumns($c);
		$startcol2 = (OrderUserDataBillingPeer::NUM_COLUMNS - OrderUserDataBillingPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CountriesPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CountriesPeer::NUM_COLUMNS;

		$c->addJoin(OrderUserDataBillingPeer::COUNTRIES_ID, CountriesPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderUserDataBillingPeer::getOMClass();


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
					$temp_obj2->addOrderUserDataBilling($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrderUserDataBillings();
				$obj2->addOrderUserDataBilling($obj1);
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
		return OrderUserDataBillingPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a OrderUserDataBilling or Criteria object.
	 *
	 * @param      mixed $values Criteria or OrderUserDataBilling object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseOrderUserDataBillingPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseOrderUserDataBillingPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from OrderUserDataBilling object
		}

		$criteria->remove(OrderUserDataBillingPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseOrderUserDataBillingPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseOrderUserDataBillingPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a OrderUserDataBilling or Criteria object.
	 *
	 * @param      mixed $values Criteria or OrderUserDataBilling object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseOrderUserDataBillingPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseOrderUserDataBillingPeer', $values, $con);
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

			$comparison = $criteria->getComparison(OrderUserDataBillingPeer::ID);
			$selectCriteria->add(OrderUserDataBillingPeer::ID, $criteria->remove(OrderUserDataBillingPeer::ID), $comparison);

		} else { // $values is OrderUserDataBilling object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseOrderUserDataBillingPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseOrderUserDataBillingPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_order_user_data_billing table.
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
			OrderUserDataBillingPeer::doOnDeleteSetNull(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(OrderUserDataBillingPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a OrderUserDataBilling or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or OrderUserDataBilling object or primary key or array of primary keys
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
			$con = Propel::getConnection(OrderUserDataBillingPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof OrderUserDataBilling) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(OrderUserDataBillingPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			OrderUserDataBillingPeer::doOnDeleteSetNull($criteria, $con);
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
		$objects = OrderUserDataBillingPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {

			// set fkey col in related Order rows to NULL
			$selectCriteria = new Criteria(OrderUserDataBillingPeer::DATABASE_NAME);
			$updateValues = new Criteria(OrderUserDataBillingPeer::DATABASE_NAME);
			$selectCriteria->add(OrderPeer::ORDER_USER_DATA_BILLING_ID, $obj->getId());
			$updateValues->add(OrderPeer::ORDER_USER_DATA_BILLING_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

		}
	}

	/**
	 * Validates all modified columns of given OrderUserDataBilling object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      OrderUserDataBilling $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(OrderUserDataBilling $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OrderUserDataBillingPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OrderUserDataBillingPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OrderUserDataBillingPeer::DATABASE_NAME, OrderUserDataBillingPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OrderUserDataBillingPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     OrderUserDataBilling
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(OrderUserDataBillingPeer::DATABASE_NAME);

		$criteria->add(OrderUserDataBillingPeer::ID, $pk);


		$v = OrderUserDataBillingPeer::doSelect($criteria, $con);

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
			$criteria->add(OrderUserDataBillingPeer::ID, $pks, Criteria::IN);
			$objs = OrderUserDataBillingPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseOrderUserDataBillingPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseOrderUserDataBillingPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('lib.model.map.OrderUserDataBillingMapBuilder');
}
