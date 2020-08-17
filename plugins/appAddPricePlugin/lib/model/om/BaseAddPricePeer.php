<?php

/**
 * Base static class for performing query and update operations on the 'app_add_price' table.
 *
 * 
 *
 * @package    plugins.appAddPricePlugin.lib.model.om
 */
abstract class BaseAddPricePeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'app_add_price';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.appAddPricePlugin.lib.model.AddPrice';

	/** The total number of columns. */
	const NUM_COLUMNS = 16;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'app_add_price.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'app_add_price.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'app_add_price.ID';

	/** the column name for the CURRENCY_ID field */
	const CURRENCY_ID = 'app_add_price.CURRENCY_ID';

	/** the column name for the TAX_ID field */
	const TAX_ID = 'app_add_price.TAX_ID';

	/** the column name for the OPT_VAT field */
	const OPT_VAT = 'app_add_price.OPT_VAT';

	/** the column name for the PRICE_NETTO field */
	const PRICE_NETTO = 'app_add_price.PRICE_NETTO';

	/** the column name for the PRICE_BRUTTO field */
	const PRICE_BRUTTO = 'app_add_price.PRICE_BRUTTO';

	/** the column name for the OLD_PRICE_NETTO field */
	const OLD_PRICE_NETTO = 'app_add_price.OLD_PRICE_NETTO';

	/** the column name for the OLD_PRICE_BRUTTO field */
	const OLD_PRICE_BRUTTO = 'app_add_price.OLD_PRICE_BRUTTO';

	/** the column name for the WHOLESALE_A_NETTO field */
	const WHOLESALE_A_NETTO = 'app_add_price.WHOLESALE_A_NETTO';

	/** the column name for the WHOLESALE_A_BRUTTO field */
	const WHOLESALE_A_BRUTTO = 'app_add_price.WHOLESALE_A_BRUTTO';

	/** the column name for the WHOLESALE_B_NETTO field */
	const WHOLESALE_B_NETTO = 'app_add_price.WHOLESALE_B_NETTO';

	/** the column name for the WHOLESALE_B_BRUTTO field */
	const WHOLESALE_B_BRUTTO = 'app_add_price.WHOLESALE_B_BRUTTO';

	/** the column name for the WHOLESALE_C_NETTO field */
	const WHOLESALE_C_NETTO = 'app_add_price.WHOLESALE_C_NETTO';

	/** the column name for the WHOLESALE_C_BRUTTO field */
	const WHOLESALE_C_BRUTTO = 'app_add_price.WHOLESALE_C_BRUTTO';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'CurrencyId', 'TaxId', 'OptVat', 'PriceNetto', 'PriceBrutto', 'OldPriceNetto', 'OldPriceBrutto', 'WholesaleANetto', 'WholesaleABrutto', 'WholesaleBNetto', 'WholesaleBBrutto', 'WholesaleCNetto', 'WholesaleCBrutto', ),
		BasePeer::TYPE_COLNAME => array (AddPricePeer::CREATED_AT, AddPricePeer::UPDATED_AT, AddPricePeer::ID, AddPricePeer::CURRENCY_ID, AddPricePeer::TAX_ID, AddPricePeer::OPT_VAT, AddPricePeer::PRICE_NETTO, AddPricePeer::PRICE_BRUTTO, AddPricePeer::OLD_PRICE_NETTO, AddPricePeer::OLD_PRICE_BRUTTO, AddPricePeer::WHOLESALE_A_NETTO, AddPricePeer::WHOLESALE_A_BRUTTO, AddPricePeer::WHOLESALE_B_NETTO, AddPricePeer::WHOLESALE_B_BRUTTO, AddPricePeer::WHOLESALE_C_NETTO, AddPricePeer::WHOLESALE_C_BRUTTO, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'currency_id', 'tax_id', 'opt_vat', 'price_netto', 'price_brutto', 'old_price_netto', 'old_price_brutto', 'wholesale_a_netto', 'wholesale_a_brutto', 'wholesale_b_netto', 'wholesale_b_brutto', 'wholesale_c_netto', 'wholesale_c_brutto', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'CurrencyId' => 3, 'TaxId' => 4, 'OptVat' => 5, 'PriceNetto' => 6, 'PriceBrutto' => 7, 'OldPriceNetto' => 8, 'OldPriceBrutto' => 9, 'WholesaleANetto' => 10, 'WholesaleABrutto' => 11, 'WholesaleBNetto' => 12, 'WholesaleBBrutto' => 13, 'WholesaleCNetto' => 14, 'WholesaleCBrutto' => 15, ),
		BasePeer::TYPE_COLNAME => array (AddPricePeer::CREATED_AT => 0, AddPricePeer::UPDATED_AT => 1, AddPricePeer::ID => 2, AddPricePeer::CURRENCY_ID => 3, AddPricePeer::TAX_ID => 4, AddPricePeer::OPT_VAT => 5, AddPricePeer::PRICE_NETTO => 6, AddPricePeer::PRICE_BRUTTO => 7, AddPricePeer::OLD_PRICE_NETTO => 8, AddPricePeer::OLD_PRICE_BRUTTO => 9, AddPricePeer::WHOLESALE_A_NETTO => 10, AddPricePeer::WHOLESALE_A_BRUTTO => 11, AddPricePeer::WHOLESALE_B_NETTO => 12, AddPricePeer::WHOLESALE_B_BRUTTO => 13, AddPricePeer::WHOLESALE_C_NETTO => 14, AddPricePeer::WHOLESALE_C_BRUTTO => 15, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'currency_id' => 3, 'tax_id' => 4, 'opt_vat' => 5, 'price_netto' => 6, 'price_brutto' => 7, 'old_price_netto' => 8, 'old_price_brutto' => 9, 'wholesale_a_netto' => 10, 'wholesale_a_brutto' => 11, 'wholesale_b_netto' => 12, 'wholesale_b_brutto' => 13, 'wholesale_c_netto' => 14, 'wholesale_c_brutto' => 15, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
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
		return BasePeer::getMapBuilder('plugins.appAddPricePlugin.lib.model.map.AddPriceMapBuilder');
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
			$map = AddPricePeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. AddPricePeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(AddPricePeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(AddPricePeer::CREATED_AT);

		$criteria->addSelectColumn(AddPricePeer::UPDATED_AT);

		$criteria->addSelectColumn(AddPricePeer::ID);

		$criteria->addSelectColumn(AddPricePeer::CURRENCY_ID);

		$criteria->addSelectColumn(AddPricePeer::TAX_ID);

		$criteria->addSelectColumn(AddPricePeer::OPT_VAT);

		$criteria->addSelectColumn(AddPricePeer::PRICE_NETTO);

		$criteria->addSelectColumn(AddPricePeer::PRICE_BRUTTO);

		$criteria->addSelectColumn(AddPricePeer::OLD_PRICE_NETTO);

		$criteria->addSelectColumn(AddPricePeer::OLD_PRICE_BRUTTO);

		$criteria->addSelectColumn(AddPricePeer::WHOLESALE_A_NETTO);

		$criteria->addSelectColumn(AddPricePeer::WHOLESALE_A_BRUTTO);

		$criteria->addSelectColumn(AddPricePeer::WHOLESALE_B_NETTO);

		$criteria->addSelectColumn(AddPricePeer::WHOLESALE_B_BRUTTO);

		$criteria->addSelectColumn(AddPricePeer::WHOLESALE_C_NETTO);

		$criteria->addSelectColumn(AddPricePeer::WHOLESALE_C_BRUTTO);


		if (stEventDispatcher::getInstance()->getListeners('AddPricePeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'AddPricePeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(app_add_price.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT app_add_price.ID)';

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
			$criteria->addSelectColumn(AddPricePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AddPricePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = AddPricePeer::doSelectRS($criteria, $con);
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
	 * @return     AddPrice
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = AddPricePeer::doSelect($critcopy, $con);
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
		return AddPricePeer::populateObjects(AddPricePeer::doSelectRS($criteria, $con));
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
			AddPricePeer::addSelectColumns($criteria);
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
		$cls = AddPricePeer::getOMClass();
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
			$criteria->addSelectColumn(AddPricePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AddPricePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AddPricePeer::ID, ProductPeer::ID);

		$rs = AddPricePeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(AddPricePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AddPricePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AddPricePeer::CURRENCY_ID, CurrencyPeer::ID);

		$rs = AddPricePeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(AddPricePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AddPricePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AddPricePeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = AddPricePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of AddPrice objects pre-filled with their Product objects.
	 *
	 * @return     array Array of AddPrice objects.
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

		AddPricePeer::addSelectColumns($c);

		ProductPeer::addSelectColumns($c);

		$c->addJoin(AddPricePeer::ID, ProductPeer::ID);
		$rs = AddPricePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new AddPrice();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getId())
                        {

			   $obj2 = new Product();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addAddPrice($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of AddPrice objects pre-filled with their Currency objects.
	 *
	 * @return     array Array of AddPrice objects.
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

		AddPricePeer::addSelectColumns($c);

		CurrencyPeer::addSelectColumns($c);

		$c->addJoin(AddPricePeer::CURRENCY_ID, CurrencyPeer::ID);
		$rs = AddPricePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new AddPrice();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getCurrencyId())
                        {

			   $obj2 = new Currency();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addAddPrice($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of AddPrice objects pre-filled with their Tax objects.
	 *
	 * @return     array Array of AddPrice objects.
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

		AddPricePeer::addSelectColumns($c);

		TaxPeer::addSelectColumns($c);

		$c->addJoin(AddPricePeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);
		$rs = AddPricePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new AddPrice();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getTaxId())
                        {

			   $obj2 = new Tax();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addAddPrice($obj1);
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
			$criteria->addSelectColumn(AddPricePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AddPricePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AddPricePeer::ID, ProductPeer::ID);

		$criteria->addJoin(AddPricePeer::CURRENCY_ID, CurrencyPeer::ID);

		$criteria->addJoin(AddPricePeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = AddPricePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of AddPrice objects pre-filled with all related objects.
	 *
	 * @return     array Array of AddPrice objects.
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

		AddPricePeer::addSelectColumns($c);
		$startcol2 = (AddPricePeer::NUM_COLUMNS - AddPricePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ProductPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ProductPeer::NUM_COLUMNS;

		CurrencyPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + CurrencyPeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(AddPricePeer::ID, ProductPeer::ID);

		$c->addJoin(AddPricePeer::CURRENCY_ID, CurrencyPeer::ID);

		$c->addJoin(AddPricePeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = AddPricePeer::getOMClass();


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
					$temp_obj2->addAddPrice($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initAddPrices();
				$obj2->addAddPrice($obj1);
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
					$temp_obj3->addAddPrice($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initAddPrices();
				$obj3->addAddPrice($obj1);
			}


				// Add objects for joined Tax rows
	
			$omClass = TaxPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getTax(); // CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addAddPrice($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj4->initAddPrices();
				$obj4->addAddPrice($obj1);
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
			$criteria->addSelectColumn(AddPricePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AddPricePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AddPricePeer::CURRENCY_ID, CurrencyPeer::ID);

		$criteria->addJoin(AddPricePeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = AddPricePeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(AddPricePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AddPricePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AddPricePeer::ID, ProductPeer::ID);

		$criteria->addJoin(AddPricePeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = AddPricePeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(AddPricePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(AddPricePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(AddPricePeer::ID, ProductPeer::ID);

		$criteria->addJoin(AddPricePeer::CURRENCY_ID, CurrencyPeer::ID);

		$rs = AddPricePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of AddPrice objects pre-filled with all related objects except Product.
	 *
	 * @return     array Array of AddPrice objects.
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

		AddPricePeer::addSelectColumns($c);
		$startcol2 = (AddPricePeer::NUM_COLUMNS - AddPricePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CurrencyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CurrencyPeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(AddPricePeer::CURRENCY_ID, CurrencyPeer::ID);

		$c->addJoin(AddPricePeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = AddPricePeer::getOMClass();

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
					$temp_obj2->addAddPrice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initAddPrices();
				$obj2->addAddPrice($obj1);
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
					$temp_obj3->addAddPrice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initAddPrices();
				$obj3->addAddPrice($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of AddPrice objects pre-filled with all related objects except Currency.
	 *
	 * @return     array Array of AddPrice objects.
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

		AddPricePeer::addSelectColumns($c);
		$startcol2 = (AddPricePeer::NUM_COLUMNS - AddPricePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ProductPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ProductPeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(AddPricePeer::ID, ProductPeer::ID);

		$c->addJoin(AddPricePeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = AddPricePeer::getOMClass();

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
					$temp_obj2->addAddPrice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initAddPrices();
				$obj2->addAddPrice($obj1);
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
					$temp_obj3->addAddPrice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initAddPrices();
				$obj3->addAddPrice($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of AddPrice objects pre-filled with all related objects except Tax.
	 *
	 * @return     array Array of AddPrice objects.
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

		AddPricePeer::addSelectColumns($c);
		$startcol2 = (AddPricePeer::NUM_COLUMNS - AddPricePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ProductPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ProductPeer::NUM_COLUMNS;

		CurrencyPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + CurrencyPeer::NUM_COLUMNS;

		$c->addJoin(AddPricePeer::ID, ProductPeer::ID);

		$c->addJoin(AddPricePeer::CURRENCY_ID, CurrencyPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = AddPricePeer::getOMClass();

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
					$temp_obj2->addAddPrice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initAddPrices();
				$obj2->addAddPrice($obj1);
			}

			$omClass = CurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getCurrency(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addAddPrice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initAddPrices();
				$obj3->addAddPrice($obj1);
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
		return AddPricePeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a AddPrice or Criteria object.
	 *
	 * @param      mixed $values Criteria or AddPrice object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseAddPricePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseAddPricePeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from AddPrice object
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

		
    foreach (sfMixer::getCallables('BaseAddPricePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseAddPricePeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a AddPrice or Criteria object.
	 *
	 * @param      mixed $values Criteria or AddPrice object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseAddPricePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseAddPricePeer', $values, $con);
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

			$comparison = $criteria->getComparison(AddPricePeer::ID);
			$selectCriteria->add(AddPricePeer::ID, $criteria->remove(AddPricePeer::ID), $comparison);

			$comparison = $criteria->getComparison(AddPricePeer::CURRENCY_ID);
			$selectCriteria->add(AddPricePeer::CURRENCY_ID, $criteria->remove(AddPricePeer::CURRENCY_ID), $comparison);

		} else { // $values is AddPrice object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseAddPricePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseAddPricePeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the app_add_price table.
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
			$affectedRows += BasePeer::doDeleteAll(AddPricePeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a AddPrice or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or AddPrice object or primary key or array of primary keys
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
			$con = Propel::getConnection(AddPricePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof AddPrice) {

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

			$criteria->add(AddPricePeer::ID, $vals[0], Criteria::IN);
			$criteria->add(AddPricePeer::CURRENCY_ID, $vals[1], Criteria::IN);
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
	 * Validates all modified columns of given AddPrice object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      AddPrice $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(AddPrice $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(AddPricePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(AddPricePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(AddPricePeer::DATABASE_NAME, AddPricePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = AddPricePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	/**
	 * Retrieve object using using composite pkey values.
	 * @param int $id
	   @param int $currency_id
	   
	 * @param      Connection $con
	 * @return     AddPrice
	 */
	public static function retrieveByPK( $id, $currency_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(AddPricePeer::ID, $id);
		$criteria->add(AddPricePeer::CURRENCY_ID, $currency_id);
		$v = AddPricePeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} // BaseAddPricePeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseAddPricePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.appAddPricePlugin.lib.model.map.AddPriceMapBuilder');
}
