<?php

/**
 * Base static class for performing query and update operations on the 'st_partner' table.
 *
 * 
 *
 * @package    plugins.stPartnerPlugin.lib.model.om
 */
abstract class BasePartnerPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_partner';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stPartnerPlugin.lib.model.Partner';

	/** The total number of columns. */
	const NUM_COLUMNS = 23;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_partner.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_partner.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_partner.ID';

	/** the column name for the COUNTRIES_ID field */
	const COUNTRIES_ID = 'st_partner.COUNTRIES_ID';

	/** the column name for the SF_GUARD_USER_ID field */
	const SF_GUARD_USER_ID = 'st_partner.SF_GUARD_USER_ID';

	/** the column name for the COMPANY field */
	const COMPANY = 'st_partner.COMPANY';

	/** the column name for the VAT_NUMBER field */
	const VAT_NUMBER = 'st_partner.VAT_NUMBER';

	/** the column name for the BANK_NUMBER field */
	const BANK_NUMBER = 'st_partner.BANK_NUMBER';

	/** the column name for the NAME field */
	const NAME = 'st_partner.NAME';

	/** the column name for the SURNAME field */
	const SURNAME = 'st_partner.SURNAME';

	/** the column name for the STREET field */
	const STREET = 'st_partner.STREET';

	/** the column name for the HOUSE field */
	const HOUSE = 'st_partner.HOUSE';

	/** the column name for the FLAT field */
	const FLAT = 'st_partner.FLAT';

	/** the column name for the CODE field */
	const CODE = 'st_partner.CODE';

	/** the column name for the TOWN field */
	const TOWN = 'st_partner.TOWN';

	/** the column name for the PHONE field */
	const PHONE = 'st_partner.PHONE';

	/** the column name for the DESCRIPTION field */
	const DESCRIPTION = 'st_partner.DESCRIPTION';

	/** the column name for the PROVISION field */
	const PROVISION = 'st_partner.PROVISION';

	/** the column name for the AMOUNT field */
	const AMOUNT = 'st_partner.AMOUNT';

	/** the column name for the SYSTEM_VALUE field */
	const SYSTEM_VALUE = 'st_partner.SYSTEM_VALUE';

	/** the column name for the IS_ACTIVE field */
	const IS_ACTIVE = 'st_partner.IS_ACTIVE';

	/** the column name for the IS_SYSTEM field */
	const IS_SYSTEM = 'st_partner.IS_SYSTEM';

	/** the column name for the IS_CONFIRM field */
	const IS_CONFIRM = 'st_partner.IS_CONFIRM';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'CountriesId', 'SfGuardUserId', 'Company', 'VatNumber', 'BankNumber', 'Name', 'Surname', 'Street', 'House', 'Flat', 'Code', 'Town', 'Phone', 'Description', 'Provision', 'Amount', 'SystemValue', 'IsActive', 'IsSystem', 'IsConfirm', ),
		BasePeer::TYPE_COLNAME => array (PartnerPeer::CREATED_AT, PartnerPeer::UPDATED_AT, PartnerPeer::ID, PartnerPeer::COUNTRIES_ID, PartnerPeer::SF_GUARD_USER_ID, PartnerPeer::COMPANY, PartnerPeer::VAT_NUMBER, PartnerPeer::BANK_NUMBER, PartnerPeer::NAME, PartnerPeer::SURNAME, PartnerPeer::STREET, PartnerPeer::HOUSE, PartnerPeer::FLAT, PartnerPeer::CODE, PartnerPeer::TOWN, PartnerPeer::PHONE, PartnerPeer::DESCRIPTION, PartnerPeer::PROVISION, PartnerPeer::AMOUNT, PartnerPeer::SYSTEM_VALUE, PartnerPeer::IS_ACTIVE, PartnerPeer::IS_SYSTEM, PartnerPeer::IS_CONFIRM, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'countries_id', 'sf_guard_user_id', 'company', 'vat_number', 'bank_number', 'name', 'surname', 'street', 'house', 'flat', 'code', 'town', 'phone', 'description', 'provision', 'amount', 'system_value', 'is_active', 'is_system', 'is_confirm', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'CountriesId' => 3, 'SfGuardUserId' => 4, 'Company' => 5, 'VatNumber' => 6, 'BankNumber' => 7, 'Name' => 8, 'Surname' => 9, 'Street' => 10, 'House' => 11, 'Flat' => 12, 'Code' => 13, 'Town' => 14, 'Phone' => 15, 'Description' => 16, 'Provision' => 17, 'Amount' => 18, 'SystemValue' => 19, 'IsActive' => 20, 'IsSystem' => 21, 'IsConfirm' => 22, ),
		BasePeer::TYPE_COLNAME => array (PartnerPeer::CREATED_AT => 0, PartnerPeer::UPDATED_AT => 1, PartnerPeer::ID => 2, PartnerPeer::COUNTRIES_ID => 3, PartnerPeer::SF_GUARD_USER_ID => 4, PartnerPeer::COMPANY => 5, PartnerPeer::VAT_NUMBER => 6, PartnerPeer::BANK_NUMBER => 7, PartnerPeer::NAME => 8, PartnerPeer::SURNAME => 9, PartnerPeer::STREET => 10, PartnerPeer::HOUSE => 11, PartnerPeer::FLAT => 12, PartnerPeer::CODE => 13, PartnerPeer::TOWN => 14, PartnerPeer::PHONE => 15, PartnerPeer::DESCRIPTION => 16, PartnerPeer::PROVISION => 17, PartnerPeer::AMOUNT => 18, PartnerPeer::SYSTEM_VALUE => 19, PartnerPeer::IS_ACTIVE => 20, PartnerPeer::IS_SYSTEM => 21, PartnerPeer::IS_CONFIRM => 22, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'countries_id' => 3, 'sf_guard_user_id' => 4, 'company' => 5, 'vat_number' => 6, 'bank_number' => 7, 'name' => 8, 'surname' => 9, 'street' => 10, 'house' => 11, 'flat' => 12, 'code' => 13, 'town' => 14, 'phone' => 15, 'description' => 16, 'provision' => 17, 'amount' => 18, 'system_value' => 19, 'is_active' => 20, 'is_system' => 21, 'is_confirm' => 22, ),
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
		return BasePeer::getMapBuilder('plugins.stPartnerPlugin.lib.model.map.PartnerMapBuilder');
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
			$map = PartnerPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. PartnerPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(PartnerPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(PartnerPeer::CREATED_AT);

		$criteria->addSelectColumn(PartnerPeer::UPDATED_AT);

		$criteria->addSelectColumn(PartnerPeer::ID);

		$criteria->addSelectColumn(PartnerPeer::COUNTRIES_ID);

		$criteria->addSelectColumn(PartnerPeer::SF_GUARD_USER_ID);

		$criteria->addSelectColumn(PartnerPeer::COMPANY);

		$criteria->addSelectColumn(PartnerPeer::VAT_NUMBER);

		$criteria->addSelectColumn(PartnerPeer::BANK_NUMBER);

		$criteria->addSelectColumn(PartnerPeer::NAME);

		$criteria->addSelectColumn(PartnerPeer::SURNAME);

		$criteria->addSelectColumn(PartnerPeer::STREET);

		$criteria->addSelectColumn(PartnerPeer::HOUSE);

		$criteria->addSelectColumn(PartnerPeer::FLAT);

		$criteria->addSelectColumn(PartnerPeer::CODE);

		$criteria->addSelectColumn(PartnerPeer::TOWN);

		$criteria->addSelectColumn(PartnerPeer::PHONE);

		$criteria->addSelectColumn(PartnerPeer::DESCRIPTION);

		$criteria->addSelectColumn(PartnerPeer::PROVISION);

		$criteria->addSelectColumn(PartnerPeer::AMOUNT);

		$criteria->addSelectColumn(PartnerPeer::SYSTEM_VALUE);

		$criteria->addSelectColumn(PartnerPeer::IS_ACTIVE);

		$criteria->addSelectColumn(PartnerPeer::IS_SYSTEM);

		$criteria->addSelectColumn(PartnerPeer::IS_CONFIRM);


		if (stEventDispatcher::getInstance()->getListeners('PartnerPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'PartnerPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_partner.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_partner.ID)';

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
			$criteria->addSelectColumn(PartnerPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PartnerPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = PartnerPeer::doSelectRS($criteria, $con);
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
	 * @return     Partner
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = PartnerPeer::doSelect($critcopy, $con);
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
		return PartnerPeer::populateObjects(PartnerPeer::doSelectRS($criteria, $con));
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
			PartnerPeer::addSelectColumns($criteria);
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
		$cls = PartnerPeer::getOMClass();
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
			$criteria->addSelectColumn(PartnerPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PartnerPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(PartnerPeer::COUNTRIES_ID, CountriesPeer::ID);

		$rs = PartnerPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
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
			$criteria->addSelectColumn(PartnerPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PartnerPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(PartnerPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$rs = PartnerPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Partner objects pre-filled with their Countries objects.
	 *
	 * @return     array Array of Partner objects.
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

		PartnerPeer::addSelectColumns($c);

		CountriesPeer::addSelectColumns($c);

		$c->addJoin(PartnerPeer::COUNTRIES_ID, CountriesPeer::ID);
		$rs = PartnerPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Partner();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getCountriesId())
                        {

			   $obj2 = new Countries();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addPartner($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Partner objects pre-filled with their sfGuardUser objects.
	 *
	 * @return     array Array of Partner objects.
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

		PartnerPeer::addSelectColumns($c);

		sfGuardUserPeer::addSelectColumns($c);

		$c->addJoin(PartnerPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);
		$rs = PartnerPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Partner();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getSfGuardUserId())
                        {

			   $obj2 = new sfGuardUser();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addPartner($obj1);
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
			$criteria->addSelectColumn(PartnerPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PartnerPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(PartnerPeer::COUNTRIES_ID, CountriesPeer::ID);

		$criteria->addJoin(PartnerPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$rs = PartnerPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Partner objects pre-filled with all related objects.
	 *
	 * @return     array Array of Partner objects.
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

		PartnerPeer::addSelectColumns($c);
		$startcol2 = (PartnerPeer::NUM_COLUMNS - PartnerPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CountriesPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CountriesPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(PartnerPeer::COUNTRIES_ID, CountriesPeer::ID);

		$c->addJoin(PartnerPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = PartnerPeer::getOMClass();


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
					$temp_obj2->addPartner($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initPartners();
				$obj2->addPartner($obj1);
			}


				// Add objects for joined sfGuardUser rows
	
			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfGuardUser(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addPartner($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initPartners();
				$obj3->addPartner($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
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
	public static function doCountJoinAllExceptCountries(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(PartnerPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PartnerPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(PartnerPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$rs = PartnerPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
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
			$criteria->addSelectColumn(PartnerPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PartnerPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(PartnerPeer::COUNTRIES_ID, CountriesPeer::ID);

		$rs = PartnerPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Partner objects pre-filled with all related objects except Countries.
	 *
	 * @return     array Array of Partner objects.
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

		PartnerPeer::addSelectColumns($c);
		$startcol2 = (PartnerPeer::NUM_COLUMNS - PartnerPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(PartnerPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = PartnerPeer::getOMClass();

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
					$temp_obj2->addPartner($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initPartners();
				$obj2->addPartner($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Partner objects pre-filled with all related objects except sfGuardUser.
	 *
	 * @return     array Array of Partner objects.
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

		PartnerPeer::addSelectColumns($c);
		$startcol2 = (PartnerPeer::NUM_COLUMNS - PartnerPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CountriesPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CountriesPeer::NUM_COLUMNS;

		$c->addJoin(PartnerPeer::COUNTRIES_ID, CountriesPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = PartnerPeer::getOMClass();

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
					$temp_obj2->addPartner($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initPartners();
				$obj2->addPartner($obj1);
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
		return PartnerPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a Partner or Criteria object.
	 *
	 * @param      mixed $values Criteria or Partner object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasePartnerPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasePartnerPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from Partner object
		}

		$criteria->remove(PartnerPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BasePartnerPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasePartnerPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a Partner or Criteria object.
	 *
	 * @param      mixed $values Criteria or Partner object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasePartnerPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasePartnerPeer', $values, $con);
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

			$comparison = $criteria->getComparison(PartnerPeer::ID);
			$selectCriteria->add(PartnerPeer::ID, $criteria->remove(PartnerPeer::ID), $comparison);

		} else { // $values is Partner object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasePartnerPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasePartnerPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_partner table.
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
			PartnerPeer::doOnDeleteSetNull(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(PartnerPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a Partner or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or Partner object or primary key or array of primary keys
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
			$con = Propel::getConnection(PartnerPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof Partner) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(PartnerPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			PartnerPeer::doOnDeleteSetNull($criteria, $con);
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
		$objects = PartnerPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {

			// set fkey col in related Order rows to NULL
			$selectCriteria = new Criteria(PartnerPeer::DATABASE_NAME);
			$updateValues = new Criteria(PartnerPeer::DATABASE_NAME);
			$selectCriteria->add(OrderPeer::PARTNER_ID, $obj->getId());
			$updateValues->add(OrderPeer::PARTNER_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

		}
	}

	/**
	 * Validates all modified columns of given Partner object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      Partner $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(Partner $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(PartnerPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(PartnerPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(PartnerPeer::DATABASE_NAME, PartnerPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = PartnerPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     Partner
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(PartnerPeer::DATABASE_NAME);

		$criteria->add(PartnerPeer::ID, $pk);


		$v = PartnerPeer::doSelect($criteria, $con);

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
			$criteria->add(PartnerPeer::ID, $pks, Criteria::IN);
			$objs = PartnerPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BasePartnerPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BasePartnerPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stPartnerPlugin.lib.model.map.PartnerMapBuilder');
}
