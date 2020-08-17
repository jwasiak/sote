<?php

/**
 * Base static class for performing query and update operations on the 'st_group_price' table.
 *
 * 
 *
 * @package    plugins.stGroupPricePlugin.lib.model.om
 */
abstract class BaseGroupPricePeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_group_price';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stGroupPricePlugin.lib.model.GroupPrice';

	/** The total number of columns. */
	const NUM_COLUMNS = 18;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_group_price.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_group_price.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_group_price.ID';

	/** the column name for the NAME field */
	const NAME = 'st_group_price.NAME';

	/** the column name for the DESCRIPTION field */
	const DESCRIPTION = 'st_group_price.DESCRIPTION';

	/** the column name for the TAX_ID field */
	const TAX_ID = 'st_group_price.TAX_ID';

	/** the column name for the OPT_VAT field */
	const OPT_VAT = 'st_group_price.OPT_VAT';

	/** the column name for the CURRENCY_ID field */
	const CURRENCY_ID = 'st_group_price.CURRENCY_ID';

	/** the column name for the PRICE_NETTO field */
	const PRICE_NETTO = 'st_group_price.PRICE_NETTO';

	/** the column name for the PRICE_BRUTTO field */
	const PRICE_BRUTTO = 'st_group_price.PRICE_BRUTTO';

	/** the column name for the OLD_PRICE_NETTO field */
	const OLD_PRICE_NETTO = 'st_group_price.OLD_PRICE_NETTO';

	/** the column name for the OLD_PRICE_BRUTTO field */
	const OLD_PRICE_BRUTTO = 'st_group_price.OLD_PRICE_BRUTTO';

	/** the column name for the WHOLESALE_A_NETTO field */
	const WHOLESALE_A_NETTO = 'st_group_price.WHOLESALE_A_NETTO';

	/** the column name for the WHOLESALE_A_BRUTTO field */
	const WHOLESALE_A_BRUTTO = 'st_group_price.WHOLESALE_A_BRUTTO';

	/** the column name for the WHOLESALE_B_NETTO field */
	const WHOLESALE_B_NETTO = 'st_group_price.WHOLESALE_B_NETTO';

	/** the column name for the WHOLESALE_B_BRUTTO field */
	const WHOLESALE_B_BRUTTO = 'st_group_price.WHOLESALE_B_BRUTTO';

	/** the column name for the WHOLESALE_C_NETTO field */
	const WHOLESALE_C_NETTO = 'st_group_price.WHOLESALE_C_NETTO';

	/** the column name for the WHOLESALE_C_BRUTTO field */
	const WHOLESALE_C_BRUTTO = 'st_group_price.WHOLESALE_C_BRUTTO';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'Name', 'Description', 'TaxId', 'OptVat', 'CurrencyId', 'PriceNetto', 'PriceBrutto', 'OldPriceNetto', 'OldPriceBrutto', 'WholesaleANetto', 'WholesaleABrutto', 'WholesaleBNetto', 'WholesaleBBrutto', 'WholesaleCNetto', 'WholesaleCBrutto', ),
		BasePeer::TYPE_COLNAME => array (GroupPricePeer::CREATED_AT, GroupPricePeer::UPDATED_AT, GroupPricePeer::ID, GroupPricePeer::NAME, GroupPricePeer::DESCRIPTION, GroupPricePeer::TAX_ID, GroupPricePeer::OPT_VAT, GroupPricePeer::CURRENCY_ID, GroupPricePeer::PRICE_NETTO, GroupPricePeer::PRICE_BRUTTO, GroupPricePeer::OLD_PRICE_NETTO, GroupPricePeer::OLD_PRICE_BRUTTO, GroupPricePeer::WHOLESALE_A_NETTO, GroupPricePeer::WHOLESALE_A_BRUTTO, GroupPricePeer::WHOLESALE_B_NETTO, GroupPricePeer::WHOLESALE_B_BRUTTO, GroupPricePeer::WHOLESALE_C_NETTO, GroupPricePeer::WHOLESALE_C_BRUTTO, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'name', 'description', 'tax_id', 'opt_vat', 'currency_id', 'price_netto', 'price_brutto', 'old_price_netto', 'old_price_brutto', 'wholesale_a_netto', 'wholesale_a_brutto', 'wholesale_b_netto', 'wholesale_b_brutto', 'wholesale_c_netto', 'wholesale_c_brutto', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'Name' => 3, 'Description' => 4, 'TaxId' => 5, 'OptVat' => 6, 'CurrencyId' => 7, 'PriceNetto' => 8, 'PriceBrutto' => 9, 'OldPriceNetto' => 10, 'OldPriceBrutto' => 11, 'WholesaleANetto' => 12, 'WholesaleABrutto' => 13, 'WholesaleBNetto' => 14, 'WholesaleBBrutto' => 15, 'WholesaleCNetto' => 16, 'WholesaleCBrutto' => 17, ),
		BasePeer::TYPE_COLNAME => array (GroupPricePeer::CREATED_AT => 0, GroupPricePeer::UPDATED_AT => 1, GroupPricePeer::ID => 2, GroupPricePeer::NAME => 3, GroupPricePeer::DESCRIPTION => 4, GroupPricePeer::TAX_ID => 5, GroupPricePeer::OPT_VAT => 6, GroupPricePeer::CURRENCY_ID => 7, GroupPricePeer::PRICE_NETTO => 8, GroupPricePeer::PRICE_BRUTTO => 9, GroupPricePeer::OLD_PRICE_NETTO => 10, GroupPricePeer::OLD_PRICE_BRUTTO => 11, GroupPricePeer::WHOLESALE_A_NETTO => 12, GroupPricePeer::WHOLESALE_A_BRUTTO => 13, GroupPricePeer::WHOLESALE_B_NETTO => 14, GroupPricePeer::WHOLESALE_B_BRUTTO => 15, GroupPricePeer::WHOLESALE_C_NETTO => 16, GroupPricePeer::WHOLESALE_C_BRUTTO => 17, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'name' => 3, 'description' => 4, 'tax_id' => 5, 'opt_vat' => 6, 'currency_id' => 7, 'price_netto' => 8, 'price_brutto' => 9, 'old_price_netto' => 10, 'old_price_brutto' => 11, 'wholesale_a_netto' => 12, 'wholesale_a_brutto' => 13, 'wholesale_b_netto' => 14, 'wholesale_b_brutto' => 15, 'wholesale_c_netto' => 16, 'wholesale_c_brutto' => 17, ),
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
		return BasePeer::getMapBuilder('plugins.stGroupPricePlugin.lib.model.map.GroupPriceMapBuilder');
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
			$map = GroupPricePeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. GroupPricePeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(GroupPricePeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(GroupPricePeer::CREATED_AT);

		$criteria->addSelectColumn(GroupPricePeer::UPDATED_AT);

		$criteria->addSelectColumn(GroupPricePeer::ID);

		$criteria->addSelectColumn(GroupPricePeer::NAME);

		$criteria->addSelectColumn(GroupPricePeer::DESCRIPTION);

		$criteria->addSelectColumn(GroupPricePeer::TAX_ID);

		$criteria->addSelectColumn(GroupPricePeer::OPT_VAT);

		$criteria->addSelectColumn(GroupPricePeer::CURRENCY_ID);

		$criteria->addSelectColumn(GroupPricePeer::PRICE_NETTO);

		$criteria->addSelectColumn(GroupPricePeer::PRICE_BRUTTO);

		$criteria->addSelectColumn(GroupPricePeer::OLD_PRICE_NETTO);

		$criteria->addSelectColumn(GroupPricePeer::OLD_PRICE_BRUTTO);

		$criteria->addSelectColumn(GroupPricePeer::WHOLESALE_A_NETTO);

		$criteria->addSelectColumn(GroupPricePeer::WHOLESALE_A_BRUTTO);

		$criteria->addSelectColumn(GroupPricePeer::WHOLESALE_B_NETTO);

		$criteria->addSelectColumn(GroupPricePeer::WHOLESALE_B_BRUTTO);

		$criteria->addSelectColumn(GroupPricePeer::WHOLESALE_C_NETTO);

		$criteria->addSelectColumn(GroupPricePeer::WHOLESALE_C_BRUTTO);


		if (stEventDispatcher::getInstance()->getListeners('GroupPricePeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'GroupPricePeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_group_price.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_group_price.ID)';

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
			$criteria->addSelectColumn(GroupPricePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(GroupPricePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = GroupPricePeer::doSelectRS($criteria, $con);
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
	 * @return     GroupPrice
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = GroupPricePeer::doSelect($critcopy, $con);
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
		return GroupPricePeer::populateObjects(GroupPricePeer::doSelectRS($criteria, $con));
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
			GroupPricePeer::addSelectColumns($criteria);
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
		$cls = GroupPricePeer::getOMClass();
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
			$criteria->addSelectColumn(GroupPricePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(GroupPricePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(GroupPricePeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = GroupPricePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Currency table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinCurrency(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(GroupPricePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(GroupPricePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(GroupPricePeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$rs = GroupPricePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of GroupPrice objects pre-filled with their Tax objects.
	 *
	 * @return     array Array of GroupPrice objects.
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

		GroupPricePeer::addSelectColumns($c);

		TaxPeer::addSelectColumns($c);

		$c->addJoin(GroupPricePeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);
		$rs = GroupPricePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new GroupPrice();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getTaxId())
                        {

			   $obj2 = new Tax();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addGroupPrice($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of GroupPrice objects pre-filled with their Currency objects.
	 *
	 * @return     array Array of GroupPrice objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinCurrency(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		GroupPricePeer::addSelectColumns($c);

		CurrencyPeer::addSelectColumns($c);

		$c->addJoin(GroupPricePeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);
		$rs = GroupPricePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new GroupPrice();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getCurrencyId())
                        {

			   $obj2 = new Currency();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addGroupPrice($obj1);
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
			$criteria->addSelectColumn(GroupPricePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(GroupPricePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(GroupPricePeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(GroupPricePeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$rs = GroupPricePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of GroupPrice objects pre-filled with all related objects.
	 *
	 * @return     array Array of GroupPrice objects.
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

		GroupPricePeer::addSelectColumns($c);
		$startcol2 = (GroupPricePeer::NUM_COLUMNS - GroupPricePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		TaxPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + TaxPeer::NUM_COLUMNS;

		CurrencyPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + CurrencyPeer::NUM_COLUMNS;

		$c->addJoin(GroupPricePeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(GroupPricePeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = GroupPricePeer::getOMClass();


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
					$temp_obj2->addGroupPrice($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initGroupPrices();
				$obj2->addGroupPrice($obj1);
			}


				// Add objects for joined Currency rows
	
			$omClass = CurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getCurrency(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addGroupPrice($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initGroupPrices();
				$obj3->addGroupPrice($obj1);
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
			$criteria->addSelectColumn(GroupPricePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(GroupPricePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(GroupPricePeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$rs = GroupPricePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Currency table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptCurrency(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(GroupPricePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(GroupPricePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(GroupPricePeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = GroupPricePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of GroupPrice objects pre-filled with all related objects except Tax.
	 *
	 * @return     array Array of GroupPrice objects.
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

		GroupPricePeer::addSelectColumns($c);
		$startcol2 = (GroupPricePeer::NUM_COLUMNS - GroupPricePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CurrencyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CurrencyPeer::NUM_COLUMNS;

		$c->addJoin(GroupPricePeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = GroupPricePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = CurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCurrency(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addGroupPrice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initGroupPrices();
				$obj2->addGroupPrice($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of GroupPrice objects pre-filled with all related objects except Currency.
	 *
	 * @return     array Array of GroupPrice objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptCurrency(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		GroupPricePeer::addSelectColumns($c);
		$startcol2 = (GroupPricePeer::NUM_COLUMNS - GroupPricePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		TaxPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(GroupPricePeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = GroupPricePeer::getOMClass();

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
					$temp_obj2->addGroupPrice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initGroupPrices();
				$obj2->addGroupPrice($obj1);
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
		return GroupPricePeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a GroupPrice or Criteria object.
	 *
	 * @param      mixed $values Criteria or GroupPrice object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseGroupPricePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseGroupPricePeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from GroupPrice object
		}

		$criteria->remove(GroupPricePeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseGroupPricePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseGroupPricePeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a GroupPrice or Criteria object.
	 *
	 * @param      mixed $values Criteria or GroupPrice object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseGroupPricePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseGroupPricePeer', $values, $con);
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

			$comparison = $criteria->getComparison(GroupPricePeer::ID);
			$selectCriteria->add(GroupPricePeer::ID, $criteria->remove(GroupPricePeer::ID), $comparison);

		} else { // $values is GroupPrice object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseGroupPricePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseGroupPricePeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_group_price table.
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
			$affectedRows += GroupPricePeer::doOnDeleteCascade(new Criteria(), $con);
			GroupPricePeer::doOnDeleteSetNull(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(GroupPricePeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a GroupPrice or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or GroupPrice object or primary key or array of primary keys
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
			$con = Propel::getConnection(GroupPricePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof GroupPrice) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(GroupPricePeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += GroupPricePeer::doOnDeleteCascade($criteria, $con);GroupPricePeer::doOnDeleteSetNull($criteria, $con);
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
		$objects = GroupPricePeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related AddGroupPrice objects
			$c = new Criteria();
			
			$c->add(AddGroupPricePeer::ID, $obj->getId());
			$affectedRows += AddGroupPricePeer::doDelete($c, $con);
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
		$objects = GroupPricePeer::doSelect($criteria, $con);
		foreach($objects as $obj) {

			// set fkey col in related Product rows to NULL
			$selectCriteria = new Criteria(GroupPricePeer::DATABASE_NAME);
			$updateValues = new Criteria(GroupPricePeer::DATABASE_NAME);
			$selectCriteria->add(ProductPeer::GROUP_PRICE_ID, $obj->getId());
			$updateValues->add(ProductPeer::GROUP_PRICE_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

		}
	}

	/**
	 * Validates all modified columns of given GroupPrice object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      GroupPrice $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(GroupPrice $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(GroupPricePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(GroupPricePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(GroupPricePeer::DATABASE_NAME, GroupPricePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = GroupPricePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     GroupPrice
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(GroupPricePeer::DATABASE_NAME);

		$criteria->add(GroupPricePeer::ID, $pk);


		$v = GroupPricePeer::doSelect($criteria, $con);

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
			$criteria->add(GroupPricePeer::ID, $pks, Criteria::IN);
			$objs = GroupPricePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseGroupPricePeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseGroupPricePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stGroupPricePlugin.lib.model.map.GroupPriceMapBuilder');
}
