<?php

/**
 * Base static class for performing query and update operations on the 'st_user_data' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseUserDataPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_user_data';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.UserData';

	/** The total number of columns. */
	const NUM_COLUMNS = 23;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_user_data.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_user_data.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_user_data.ID';

	/** the column name for the SF_GUARD_USER_ID field */
	const SF_GUARD_USER_ID = 'st_user_data.SF_GUARD_USER_ID';

	/** the column name for the COUNTRIES_ID field */
	const COUNTRIES_ID = 'st_user_data.COUNTRIES_ID';

	/** the column name for the IS_BILLING field */
	const IS_BILLING = 'st_user_data.IS_BILLING';

	/** the column name for the IS_DEFAULT field */
	const IS_DEFAULT = 'st_user_data.IS_DEFAULT';

	/** the column name for the NAME field */
	const NAME = 'st_user_data.NAME';

	/** the column name for the SURNAME field */
	const SURNAME = 'st_user_data.SURNAME';

	/** the column name for the FULL_NAME field */
	const FULL_NAME = 'st_user_data.FULL_NAME';

	/** the column name for the ADDRESS field */
	const ADDRESS = 'st_user_data.ADDRESS';

	/** the column name for the ADDRESS_MORE field */
	const ADDRESS_MORE = 'st_user_data.ADDRESS_MORE';

	/** the column name for the REGION field */
	const REGION = 'st_user_data.REGION';

	/** the column name for the STREET field */
	const STREET = 'st_user_data.STREET';

	/** the column name for the HOUSE field */
	const HOUSE = 'st_user_data.HOUSE';

	/** the column name for the FLAT field */
	const FLAT = 'st_user_data.FLAT';

	/** the column name for the CODE field */
	const CODE = 'st_user_data.CODE';

	/** the column name for the TOWN field */
	const TOWN = 'st_user_data.TOWN';

	/** the column name for the PHONE field */
	const PHONE = 'st_user_data.PHONE';

	/** the column name for the COMPANY field */
	const COMPANY = 'st_user_data.COMPANY';

	/** the column name for the VAT_NUMBER field */
	const VAT_NUMBER = 'st_user_data.VAT_NUMBER';

	/** the column name for the PESEL field */
	const PESEL = 'st_user_data.PESEL';

	/** the column name for the CRYPT field */
	const CRYPT = 'st_user_data.CRYPT';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'SfGuardUserId', 'CountriesId', 'IsBilling', 'IsDefault', 'Name', 'Surname', 'FullName', 'Address', 'AddressMore', 'Region', 'Street', 'House', 'Flat', 'Code', 'Town', 'Phone', 'Company', 'VatNumber', 'Pesel', 'Crypt', ),
		BasePeer::TYPE_COLNAME => array (UserDataPeer::CREATED_AT, UserDataPeer::UPDATED_AT, UserDataPeer::ID, UserDataPeer::SF_GUARD_USER_ID, UserDataPeer::COUNTRIES_ID, UserDataPeer::IS_BILLING, UserDataPeer::IS_DEFAULT, UserDataPeer::NAME, UserDataPeer::SURNAME, UserDataPeer::FULL_NAME, UserDataPeer::ADDRESS, UserDataPeer::ADDRESS_MORE, UserDataPeer::REGION, UserDataPeer::STREET, UserDataPeer::HOUSE, UserDataPeer::FLAT, UserDataPeer::CODE, UserDataPeer::TOWN, UserDataPeer::PHONE, UserDataPeer::COMPANY, UserDataPeer::VAT_NUMBER, UserDataPeer::PESEL, UserDataPeer::CRYPT, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'sf_guard_user_id', 'countries_id', 'is_billing', 'is_default', 'name', 'surname', 'full_name', 'address', 'address_more', 'region', 'street', 'house', 'flat', 'code', 'town', 'phone', 'company', 'vat_number', 'pesel', 'crypt', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'SfGuardUserId' => 3, 'CountriesId' => 4, 'IsBilling' => 5, 'IsDefault' => 6, 'Name' => 7, 'Surname' => 8, 'FullName' => 9, 'Address' => 10, 'AddressMore' => 11, 'Region' => 12, 'Street' => 13, 'House' => 14, 'Flat' => 15, 'Code' => 16, 'Town' => 17, 'Phone' => 18, 'Company' => 19, 'VatNumber' => 20, 'Pesel' => 21, 'Crypt' => 22, ),
		BasePeer::TYPE_COLNAME => array (UserDataPeer::CREATED_AT => 0, UserDataPeer::UPDATED_AT => 1, UserDataPeer::ID => 2, UserDataPeer::SF_GUARD_USER_ID => 3, UserDataPeer::COUNTRIES_ID => 4, UserDataPeer::IS_BILLING => 5, UserDataPeer::IS_DEFAULT => 6, UserDataPeer::NAME => 7, UserDataPeer::SURNAME => 8, UserDataPeer::FULL_NAME => 9, UserDataPeer::ADDRESS => 10, UserDataPeer::ADDRESS_MORE => 11, UserDataPeer::REGION => 12, UserDataPeer::STREET => 13, UserDataPeer::HOUSE => 14, UserDataPeer::FLAT => 15, UserDataPeer::CODE => 16, UserDataPeer::TOWN => 17, UserDataPeer::PHONE => 18, UserDataPeer::COMPANY => 19, UserDataPeer::VAT_NUMBER => 20, UserDataPeer::PESEL => 21, UserDataPeer::CRYPT => 22, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'sf_guard_user_id' => 3, 'countries_id' => 4, 'is_billing' => 5, 'is_default' => 6, 'name' => 7, 'surname' => 8, 'full_name' => 9, 'address' => 10, 'address_more' => 11, 'region' => 12, 'street' => 13, 'house' => 14, 'flat' => 15, 'code' => 16, 'town' => 17, 'phone' => 18, 'company' => 19, 'vat_number' => 20, 'pesel' => 21, 'crypt' => 22, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, )
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
		return BasePeer::getMapBuilder('lib.model.map.UserDataMapBuilder');
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
			$map = UserDataPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. UserDataPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(UserDataPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(UserDataPeer::CREATED_AT);

		$criteria->addSelectColumn(UserDataPeer::UPDATED_AT);

		$criteria->addSelectColumn(UserDataPeer::ID);

		$criteria->addSelectColumn(UserDataPeer::SF_GUARD_USER_ID);

		$criteria->addSelectColumn(UserDataPeer::COUNTRIES_ID);

		$criteria->addSelectColumn(UserDataPeer::IS_BILLING);

		$criteria->addSelectColumn(UserDataPeer::IS_DEFAULT);

		$criteria->addSelectColumn(UserDataPeer::NAME);

		$criteria->addSelectColumn(UserDataPeer::SURNAME);

		$criteria->addSelectColumn(UserDataPeer::FULL_NAME);

		$criteria->addSelectColumn(UserDataPeer::ADDRESS);

		$criteria->addSelectColumn(UserDataPeer::ADDRESS_MORE);

		$criteria->addSelectColumn(UserDataPeer::REGION);

		$criteria->addSelectColumn(UserDataPeer::STREET);

		$criteria->addSelectColumn(UserDataPeer::HOUSE);

		$criteria->addSelectColumn(UserDataPeer::FLAT);

		$criteria->addSelectColumn(UserDataPeer::CODE);

		$criteria->addSelectColumn(UserDataPeer::TOWN);

		$criteria->addSelectColumn(UserDataPeer::PHONE);

		$criteria->addSelectColumn(UserDataPeer::COMPANY);

		$criteria->addSelectColumn(UserDataPeer::VAT_NUMBER);

		$criteria->addSelectColumn(UserDataPeer::PESEL);

		$criteria->addSelectColumn(UserDataPeer::CRYPT);


		if (stEventDispatcher::getInstance()->getListeners('UserDataPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'UserDataPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_user_data.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_user_data.ID)';

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
			$criteria->addSelectColumn(UserDataPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(UserDataPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = UserDataPeer::doSelectRS($criteria, $con);
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
	 * @return     UserData
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = UserDataPeer::doSelect($critcopy, $con);
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
		return UserDataPeer::populateObjects(UserDataPeer::doSelectRS($criteria, $con));
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
			UserDataPeer::addSelectColumns($criteria);
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
		$cls = UserDataPeer::getOMClass();
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
			$criteria->addSelectColumn(UserDataPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(UserDataPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(UserDataPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID);

		$rs = UserDataPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
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
			$criteria->addSelectColumn(UserDataPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(UserDataPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(UserDataPeer::COUNTRIES_ID, CountriesPeer::ID);

		$rs = UserDataPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of UserData objects pre-filled with their sfGuardUser objects.
	 *
	 * @return     array Array of UserData objects.
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

		UserDataPeer::addSelectColumns($c);

		sfGuardUserPeer::addSelectColumns($c);

		$c->addJoin(UserDataPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID);
		$rs = UserDataPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new UserData();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getSfGuardUserId())
                        {

			   $obj2 = new sfGuardUser();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addUserData($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of UserData objects pre-filled with their Countries objects.
	 *
	 * @return     array Array of UserData objects.
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

		UserDataPeer::addSelectColumns($c);

		CountriesPeer::addSelectColumns($c);

		$c->addJoin(UserDataPeer::COUNTRIES_ID, CountriesPeer::ID);
		$rs = UserDataPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new UserData();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getCountriesId())
                        {

			   $obj2 = new Countries();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addUserData($obj1);
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
			$criteria->addSelectColumn(UserDataPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(UserDataPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(UserDataPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID);

		$criteria->addJoin(UserDataPeer::COUNTRIES_ID, CountriesPeer::ID);

		$rs = UserDataPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of UserData objects pre-filled with all related objects.
	 *
	 * @return     array Array of UserData objects.
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

		UserDataPeer::addSelectColumns($c);
		$startcol2 = (UserDataPeer::NUM_COLUMNS - UserDataPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		CountriesPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + CountriesPeer::NUM_COLUMNS;

		$c->addJoin(UserDataPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID);

		$c->addJoin(UserDataPeer::COUNTRIES_ID, CountriesPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = UserDataPeer::getOMClass();


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
					$temp_obj2->addUserData($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initUserDatas();
				$obj2->addUserData($obj1);
			}


				// Add objects for joined Countries rows
	
			$omClass = CountriesPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getCountries(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addUserData($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initUserDatas();
				$obj3->addUserData($obj1);
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
			$criteria->addSelectColumn(UserDataPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(UserDataPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(UserDataPeer::COUNTRIES_ID, CountriesPeer::ID);

		$rs = UserDataPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Countries table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptCountries(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(UserDataPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(UserDataPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(UserDataPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID);

		$rs = UserDataPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of UserData objects pre-filled with all related objects except sfGuardUser.
	 *
	 * @return     array Array of UserData objects.
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

		UserDataPeer::addSelectColumns($c);
		$startcol2 = (UserDataPeer::NUM_COLUMNS - UserDataPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CountriesPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CountriesPeer::NUM_COLUMNS;

		$c->addJoin(UserDataPeer::COUNTRIES_ID, CountriesPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = UserDataPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = CountriesPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCountries(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addUserData($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initUserDatas();
				$obj2->addUserData($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of UserData objects pre-filled with all related objects except Countries.
	 *
	 * @return     array Array of UserData objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptCountries(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		UserDataPeer::addSelectColumns($c);
		$startcol2 = (UserDataPeer::NUM_COLUMNS - UserDataPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(UserDataPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = UserDataPeer::getOMClass();

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
					$temp_obj2->addUserData($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initUserDatas();
				$obj2->addUserData($obj1);
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
		return UserDataPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a UserData or Criteria object.
	 *
	 * @param      mixed $values Criteria or UserData object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseUserDataPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseUserDataPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from UserData object
		}

		$criteria->remove(UserDataPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseUserDataPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseUserDataPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a UserData or Criteria object.
	 *
	 * @param      mixed $values Criteria or UserData object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseUserDataPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseUserDataPeer', $values, $con);
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

			$comparison = $criteria->getComparison(UserDataPeer::ID);
			$selectCriteria->add(UserDataPeer::ID, $criteria->remove(UserDataPeer::ID), $comparison);

		} else { // $values is UserData object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseUserDataPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseUserDataPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_user_data table.
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
			$affectedRows += BasePeer::doDeleteAll(UserDataPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a UserData or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or UserData object or primary key or array of primary keys
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
			$con = Propel::getConnection(UserDataPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof UserData) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(UserDataPeer::ID, (array) $values, Criteria::IN);
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
	 * Validates all modified columns of given UserData object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      UserData $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(UserData $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(UserDataPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(UserDataPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(UserDataPeer::DATABASE_NAME, UserDataPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = UserDataPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     UserData
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(UserDataPeer::DATABASE_NAME);

		$criteria->add(UserDataPeer::ID, $pk);


		$v = UserDataPeer::doSelect($criteria, $con);

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
			$criteria->add(UserDataPeer::ID, $pks, Criteria::IN);
			$objs = UserDataPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseUserDataPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseUserDataPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('lib.model.map.UserDataMapBuilder');
}
