<?php

/**
 * Base static class for performing query and update operations on the 'st_product_options_default_value' table.
 *
 * 
 *
 * @package    plugins.stProductOptionsPlugin.lib.model.om
 */
abstract class BaseProductOptionsDefaultValuePeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_product_options_default_value';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stProductOptionsPlugin.lib.model.ProductOptionsDefaultValue';

	/** The total number of columns. */
	const NUM_COLUMNS = 18;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_product_options_default_value.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_product_options_default_value.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_product_options_default_value.ID';

	/** the column name for the PRODUCT_OPTIONS_TEMPLATE_ID field */
	const PRODUCT_OPTIONS_TEMPLATE_ID = 'st_product_options_default_value.PRODUCT_OPTIONS_TEMPLATE_ID';

	/** the column name for the PRODUCT_OPTIONS_DEFAULT_VALUE_ID field */
	const PRODUCT_OPTIONS_DEFAULT_VALUE_ID = 'st_product_options_default_value.PRODUCT_OPTIONS_DEFAULT_VALUE_ID';

	/** the column name for the PRODUCT_OPTIONS_FIELD_ID field */
	const PRODUCT_OPTIONS_FIELD_ID = 'st_product_options_default_value.PRODUCT_OPTIONS_FIELD_ID';

	/** the column name for the PRICE field */
	const PRICE = 'st_product_options_default_value.PRICE';

	/** the column name for the WEIGHT field */
	const WEIGHT = 'st_product_options_default_value.WEIGHT';

	/** the column name for the LFT field */
	const LFT = 'st_product_options_default_value.LFT';

	/** the column name for the RGT field */
	const RGT = 'st_product_options_default_value.RGT';

	/** the column name for the OPT_VALUE field */
	const OPT_VALUE = 'st_product_options_default_value.OPT_VALUE';

	/** the column name for the PRICE_TYPE field */
	const PRICE_TYPE = 'st_product_options_default_value.PRICE_TYPE';

	/** the column name for the DEPTH field */
	const DEPTH = 'st_product_options_default_value.DEPTH';

	/** the column name for the OPT_VERSION field */
	const OPT_VERSION = 'st_product_options_default_value.OPT_VERSION';

	/** the column name for the COLOR field */
	const COLOR = 'st_product_options_default_value.COLOR';

	/** the column name for the USE_IMAGE_AS_COLOR field */
	const USE_IMAGE_AS_COLOR = 'st_product_options_default_value.USE_IMAGE_AS_COLOR';

	/** the column name for the OLD_PRICE field */
	const OLD_PRICE = 'st_product_options_default_value.OLD_PRICE';

	/** the column name for the PUM field */
	const PUM = 'st_product_options_default_value.PUM';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'ProductOptionsTemplateId', 'ProductOptionsDefaultValueId', 'ProductOptionsFieldId', 'Price', 'Weight', 'Lft', 'Rgt', 'OptValue', 'PriceType', 'Depth', 'OptVersion', 'Color', 'UseImageAsColor', 'OldPrice', 'Pum', ),
		BasePeer::TYPE_COLNAME => array (ProductOptionsDefaultValuePeer::CREATED_AT, ProductOptionsDefaultValuePeer::UPDATED_AT, ProductOptionsDefaultValuePeer::ID, ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID, ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsDefaultValuePeer::PRICE, ProductOptionsDefaultValuePeer::WEIGHT, ProductOptionsDefaultValuePeer::LFT, ProductOptionsDefaultValuePeer::RGT, ProductOptionsDefaultValuePeer::OPT_VALUE, ProductOptionsDefaultValuePeer::PRICE_TYPE, ProductOptionsDefaultValuePeer::DEPTH, ProductOptionsDefaultValuePeer::OPT_VERSION, ProductOptionsDefaultValuePeer::COLOR, ProductOptionsDefaultValuePeer::USE_IMAGE_AS_COLOR, ProductOptionsDefaultValuePeer::OLD_PRICE, ProductOptionsDefaultValuePeer::PUM, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'product_options_template_id', 'product_options_default_value_id', 'product_options_field_id', 'price', 'weight', 'lft', 'rgt', 'opt_value', 'price_type', 'depth', 'opt_version', 'color', 'use_image_as_color', 'old_price', 'pum', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'ProductOptionsTemplateId' => 3, 'ProductOptionsDefaultValueId' => 4, 'ProductOptionsFieldId' => 5, 'Price' => 6, 'Weight' => 7, 'Lft' => 8, 'Rgt' => 9, 'OptValue' => 10, 'PriceType' => 11, 'Depth' => 12, 'OptVersion' => 13, 'Color' => 14, 'UseImageAsColor' => 15, 'OldPrice' => 16, 'Pum' => 17, ),
		BasePeer::TYPE_COLNAME => array (ProductOptionsDefaultValuePeer::CREATED_AT => 0, ProductOptionsDefaultValuePeer::UPDATED_AT => 1, ProductOptionsDefaultValuePeer::ID => 2, ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID => 3, ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID => 4, ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID => 5, ProductOptionsDefaultValuePeer::PRICE => 6, ProductOptionsDefaultValuePeer::WEIGHT => 7, ProductOptionsDefaultValuePeer::LFT => 8, ProductOptionsDefaultValuePeer::RGT => 9, ProductOptionsDefaultValuePeer::OPT_VALUE => 10, ProductOptionsDefaultValuePeer::PRICE_TYPE => 11, ProductOptionsDefaultValuePeer::DEPTH => 12, ProductOptionsDefaultValuePeer::OPT_VERSION => 13, ProductOptionsDefaultValuePeer::COLOR => 14, ProductOptionsDefaultValuePeer::USE_IMAGE_AS_COLOR => 15, ProductOptionsDefaultValuePeer::OLD_PRICE => 16, ProductOptionsDefaultValuePeer::PUM => 17, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'product_options_template_id' => 3, 'product_options_default_value_id' => 4, 'product_options_field_id' => 5, 'price' => 6, 'weight' => 7, 'lft' => 8, 'rgt' => 9, 'opt_value' => 10, 'price_type' => 11, 'depth' => 12, 'opt_version' => 13, 'color' => 14, 'use_image_as_color' => 15, 'old_price' => 16, 'pum' => 17, ),
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
		return BasePeer::getMapBuilder('plugins.stProductOptionsPlugin.lib.model.map.ProductOptionsDefaultValueMapBuilder');
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
			$map = ProductOptionsDefaultValuePeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. ProductOptionsDefaultValuePeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(ProductOptionsDefaultValuePeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::CREATED_AT);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::UPDATED_AT);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::ID);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::PRICE);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::WEIGHT);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::LFT);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::RGT);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::OPT_VALUE);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::PRICE_TYPE);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::DEPTH);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::OPT_VERSION);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::COLOR);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::USE_IMAGE_AS_COLOR);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::OLD_PRICE);

		$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::PUM);


		if (stEventDispatcher::getInstance()->getListeners('ProductOptionsDefaultValuePeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'ProductOptionsDefaultValuePeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_product_options_default_value.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_product_options_default_value.ID)';

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
			$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ProductOptionsDefaultValuePeer::doSelectRS($criteria, $con);
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
	 * @return     ProductOptionsDefaultValue
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = ProductOptionsDefaultValuePeer::doSelect($critcopy, $con);
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
		return ProductOptionsDefaultValuePeer::populateObjects(ProductOptionsDefaultValuePeer::doSelectRS($criteria, $con));
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
			ProductOptionsDefaultValuePeer::addSelectColumns($criteria);
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
		$cls = ProductOptionsDefaultValuePeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related ProductOptionsTemplate table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinProductOptionsTemplate(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID);

		$rs = ProductOptionsDefaultValuePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related ProductOptionsField table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinProductOptionsField(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductOptionsDefaultValuePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of ProductOptionsDefaultValue objects pre-filled with their ProductOptionsTemplate objects.
	 *
	 * @return     array Array of ProductOptionsDefaultValue objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinProductOptionsTemplate(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductOptionsDefaultValuePeer::addSelectColumns($c);

		ProductOptionsTemplatePeer::addSelectColumns($c);

		$c->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID);
		$rs = ProductOptionsDefaultValuePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new ProductOptionsDefaultValue();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getProductOptionsTemplateId())
                        {

			   $obj2 = new ProductOptionsTemplate();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addProductOptionsDefaultValue($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of ProductOptionsDefaultValue objects pre-filled with their ProductOptionsField objects.
	 *
	 * @return     array Array of ProductOptionsDefaultValue objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinProductOptionsField(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductOptionsDefaultValuePeer::addSelectColumns($c);

		ProductOptionsFieldPeer::addSelectColumns($c);

		$c->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);
		$rs = ProductOptionsDefaultValuePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new ProductOptionsDefaultValue();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getProductOptionsFieldId())
                        {

			   $obj2 = new ProductOptionsField();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addProductOptionsDefaultValue($obj1);
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
			$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID);

		$criteria->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductOptionsDefaultValuePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of ProductOptionsDefaultValue objects pre-filled with all related objects.
	 *
	 * @return     array Array of ProductOptionsDefaultValue objects.
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

		ProductOptionsDefaultValuePeer::addSelectColumns($c);
		$startcol2 = (ProductOptionsDefaultValuePeer::NUM_COLUMNS - ProductOptionsDefaultValuePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ProductOptionsTemplatePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ProductOptionsTemplatePeer::NUM_COLUMNS;

		ProductOptionsFieldPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProductOptionsFieldPeer::NUM_COLUMNS;

		$c->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID);

		$c->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductOptionsDefaultValuePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined ProductOptionsTemplate rows
	
			$omClass = ProductOptionsTemplatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getProductOptionsTemplate(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProductOptionsDefaultValue($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initProductOptionsDefaultValues();
				$obj2->addProductOptionsDefaultValue($obj1);
			}


				// Add objects for joined ProductOptionsField rows
	
			$omClass = ProductOptionsFieldPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProductOptionsField(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProductOptionsDefaultValue($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initProductOptionsDefaultValues();
				$obj3->addProductOptionsDefaultValue($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related ProductOptionsTemplate table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptProductOptionsTemplate(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductOptionsDefaultValuePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related ProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID);

		$criteria->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductOptionsDefaultValuePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related ProductOptionsField table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptProductOptionsField(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsDefaultValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID);

		$rs = ProductOptionsDefaultValuePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of ProductOptionsDefaultValue objects pre-filled with all related objects except ProductOptionsTemplate.
	 *
	 * @return     array Array of ProductOptionsDefaultValue objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptProductOptionsTemplate(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductOptionsDefaultValuePeer::addSelectColumns($c);
		$startcol2 = (ProductOptionsDefaultValuePeer::NUM_COLUMNS - ProductOptionsDefaultValuePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ProductOptionsFieldPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ProductOptionsFieldPeer::NUM_COLUMNS;

		$c->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductOptionsDefaultValuePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ProductOptionsFieldPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getProductOptionsField(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProductOptionsDefaultValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProductOptionsDefaultValues();
				$obj2->addProductOptionsDefaultValue($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of ProductOptionsDefaultValue objects pre-filled with all related objects except ProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId.
	 *
	 * @return     array Array of ProductOptionsDefaultValue objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductOptionsDefaultValuePeer::addSelectColumns($c);
		$startcol2 = (ProductOptionsDefaultValuePeer::NUM_COLUMNS - ProductOptionsDefaultValuePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ProductOptionsTemplatePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ProductOptionsTemplatePeer::NUM_COLUMNS;

		ProductOptionsFieldPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProductOptionsFieldPeer::NUM_COLUMNS;

		$c->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID);

		$c->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductOptionsDefaultValuePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ProductOptionsTemplatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getProductOptionsTemplate(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProductOptionsDefaultValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProductOptionsDefaultValues();
				$obj2->addProductOptionsDefaultValue($obj1);
			}

			$omClass = ProductOptionsFieldPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProductOptionsField(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProductOptionsDefaultValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initProductOptionsDefaultValues();
				$obj3->addProductOptionsDefaultValue($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of ProductOptionsDefaultValue objects pre-filled with all related objects except ProductOptionsField.
	 *
	 * @return     array Array of ProductOptionsDefaultValue objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptProductOptionsField(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductOptionsDefaultValuePeer::addSelectColumns($c);
		$startcol2 = (ProductOptionsDefaultValuePeer::NUM_COLUMNS - ProductOptionsDefaultValuePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ProductOptionsTemplatePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ProductOptionsTemplatePeer::NUM_COLUMNS;

		$c->addJoin(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductOptionsDefaultValuePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ProductOptionsTemplatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getProductOptionsTemplate(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProductOptionsDefaultValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProductOptionsDefaultValues();
				$obj2->addProductOptionsDefaultValue($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


     /**
      * Selects a collection of ProductOptionsDefaultValue objects pre-filled with their i18n objects.
      *
      * @return array Array of ProductOptionsDefaultValue objects.
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
          ProductOptionsDefaultValuePeer::addSelectColumns($c);
          ProductOptionsDefaultValueI18nPeer::addSelectColumns($c);
       }

      $c->addJoin(ProductOptionsDefaultValuePeer::ID, sprintf('%s AND %s = \'%s\'', ProductOptionsDefaultValueI18nPeer::ID, ProductOptionsDefaultValueI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

      $rs = ProductOptionsDefaultValuePeer::doSelectRs($c, $con);

      if (self::$hydrateMethod)
      {
         return call_user_func(self::$hydrateMethod, $rs);
      }

      $results = array();

      while($rs->next()) {

         $obj1 = new ProductOptionsDefaultValue();
         $startcol = $obj1->hydrate($rs);
         $obj1->setCulture($culture);

         $obj2 = new ProductOptionsDefaultValueI18n();
         $obj2->hydrate($rs, $startcol);

         $obj1->setProductOptionsDefaultValueI18nForCulture($obj2, $culture);
         $obj2->setProductOptionsDefaultValue($obj1);

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
		return ProductOptionsDefaultValuePeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a ProductOptionsDefaultValue or Criteria object.
	 *
	 * @param      mixed $values Criteria or ProductOptionsDefaultValue object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseProductOptionsDefaultValuePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseProductOptionsDefaultValuePeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from ProductOptionsDefaultValue object
		}

		$criteria->remove(ProductOptionsDefaultValuePeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseProductOptionsDefaultValuePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseProductOptionsDefaultValuePeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a ProductOptionsDefaultValue or Criteria object.
	 *
	 * @param      mixed $values Criteria or ProductOptionsDefaultValue object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseProductOptionsDefaultValuePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseProductOptionsDefaultValuePeer', $values, $con);
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

			$comparison = $criteria->getComparison(ProductOptionsDefaultValuePeer::ID);
			$selectCriteria->add(ProductOptionsDefaultValuePeer::ID, $criteria->remove(ProductOptionsDefaultValuePeer::ID), $comparison);

		} else { // $values is ProductOptionsDefaultValue object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseProductOptionsDefaultValuePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseProductOptionsDefaultValuePeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_product_options_default_value table.
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
			$affectedRows += ProductOptionsDefaultValuePeer::doOnDeleteCascade(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(ProductOptionsDefaultValuePeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a ProductOptionsDefaultValue or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or ProductOptionsDefaultValue object or primary key or array of primary keys
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
			$con = Propel::getConnection(ProductOptionsDefaultValuePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof ProductOptionsDefaultValue) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ProductOptionsDefaultValuePeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += ProductOptionsDefaultValuePeer::doOnDeleteCascade($criteria, $con);
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
		$objects = ProductOptionsDefaultValuePeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related ProductOptionsDefaultValueI18n objects
			$c = new Criteria();
			
			$c->add(ProductOptionsDefaultValueI18nPeer::ID, $obj->getId());
			$affectedRows += ProductOptionsDefaultValueI18nPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	/**
	 * Validates all modified columns of given ProductOptionsDefaultValue object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      ProductOptionsDefaultValue $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(ProductOptionsDefaultValue $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ProductOptionsDefaultValuePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ProductOptionsDefaultValuePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ProductOptionsDefaultValuePeer::DATABASE_NAME, ProductOptionsDefaultValuePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ProductOptionsDefaultValuePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     ProductOptionsDefaultValue
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(ProductOptionsDefaultValuePeer::DATABASE_NAME);

		$criteria->add(ProductOptionsDefaultValuePeer::ID, $pk);


		$v = ProductOptionsDefaultValuePeer::doSelect($criteria, $con);

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
			$criteria->add(ProductOptionsDefaultValuePeer::ID, $pks, Criteria::IN);
			$objs = ProductOptionsDefaultValuePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseProductOptionsDefaultValuePeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseProductOptionsDefaultValuePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stProductOptionsPlugin.lib.model.map.ProductOptionsDefaultValueMapBuilder');
}
