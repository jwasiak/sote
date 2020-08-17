<?php

/**
 * Base static class for performing query and update operations on the 'st_product_options_value' table.
 *
 * 
 *
 * @package    plugins.stProductOptionsPlugin.lib.model.om
 */
abstract class BaseProductOptionsValuePeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_product_options_value';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stProductOptionsPlugin.lib.model.ProductOptionsValue';

	/** The total number of columns. */
	const NUM_COLUMNS = 25;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_product_options_value.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_product_options_value.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_product_options_value.ID';

	/** the column name for the SF_ASSET_ID field */
	const SF_ASSET_ID = 'st_product_options_value.SF_ASSET_ID';

	/** the column name for the PRODUCT_ID field */
	const PRODUCT_ID = 'st_product_options_value.PRODUCT_ID';

	/** the column name for the PRODUCT_OPTIONS_TEMPLATE_ID field */
	const PRODUCT_OPTIONS_TEMPLATE_ID = 'st_product_options_value.PRODUCT_OPTIONS_TEMPLATE_ID';

	/** the column name for the PRODUCT_OPTIONS_VALUE_ID field */
	const PRODUCT_OPTIONS_VALUE_ID = 'st_product_options_value.PRODUCT_OPTIONS_VALUE_ID';

	/** the column name for the PRODUCT_OPTIONS_FIELD_ID field */
	const PRODUCT_OPTIONS_FIELD_ID = 'st_product_options_value.PRODUCT_OPTIONS_FIELD_ID';

	/** the column name for the PRICE field */
	const PRICE = 'st_product_options_value.PRICE';

	/** the column name for the WEIGHT field */
	const WEIGHT = 'st_product_options_value.WEIGHT';

	/** the column name for the LFT field */
	const LFT = 'st_product_options_value.LFT';

	/** the column name for the RGT field */
	const RGT = 'st_product_options_value.RGT';

	/** the column name for the STOCK field */
	const STOCK = 'st_product_options_value.STOCK';

	/** the column name for the OPT_VALUE field */
	const OPT_VALUE = 'st_product_options_value.OPT_VALUE';

	/** the column name for the PRICE_TYPE field */
	const PRICE_TYPE = 'st_product_options_value.PRICE_TYPE';

	/** the column name for the DEPTH field */
	const DEPTH = 'st_product_options_value.DEPTH';

	/** the column name for the OPT_VERSION field */
	const OPT_VERSION = 'st_product_options_value.OPT_VERSION';

	/** the column name for the COLOR field */
	const COLOR = 'st_product_options_value.COLOR';

	/** the column name for the USE_IMAGE_AS_COLOR field */
	const USE_IMAGE_AS_COLOR = 'st_product_options_value.USE_IMAGE_AS_COLOR';

	/** the column name for the OPT_FILTER_ID field */
	const OPT_FILTER_ID = 'st_product_options_value.OPT_FILTER_ID';

	/** the column name for the USE_PRODUCT field */
	const USE_PRODUCT = 'st_product_options_value.USE_PRODUCT';

	/** the column name for the OLD_PRICE field */
	const OLD_PRICE = 'st_product_options_value.OLD_PRICE';

	/** the column name for the MAN_CODE field */
	const MAN_CODE = 'st_product_options_value.MAN_CODE';

	/** the column name for the PUM field */
	const PUM = 'st_product_options_value.PUM';

	/** the column name for the IS_UPDATED field */
	const IS_UPDATED = 'st_product_options_value.IS_UPDATED';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'SfAssetId', 'ProductId', 'ProductOptionsTemplateId', 'ProductOptionsValueId', 'ProductOptionsFieldId', 'Price', 'Weight', 'Lft', 'Rgt', 'Stock', 'OptValue', 'PriceType', 'Depth', 'OptVersion', 'Color', 'UseImageAsColor', 'OptFilterId', 'UseProduct', 'OldPrice', 'ManCode', 'Pum', 'IsUpdated', ),
		BasePeer::TYPE_COLNAME => array (ProductOptionsValuePeer::CREATED_AT, ProductOptionsValuePeer::UPDATED_AT, ProductOptionsValuePeer::ID, ProductOptionsValuePeer::SF_ASSET_ID, ProductOptionsValuePeer::PRODUCT_ID, ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsValuePeer::PRICE, ProductOptionsValuePeer::WEIGHT, ProductOptionsValuePeer::LFT, ProductOptionsValuePeer::RGT, ProductOptionsValuePeer::STOCK, ProductOptionsValuePeer::OPT_VALUE, ProductOptionsValuePeer::PRICE_TYPE, ProductOptionsValuePeer::DEPTH, ProductOptionsValuePeer::OPT_VERSION, ProductOptionsValuePeer::COLOR, ProductOptionsValuePeer::USE_IMAGE_AS_COLOR, ProductOptionsValuePeer::OPT_FILTER_ID, ProductOptionsValuePeer::USE_PRODUCT, ProductOptionsValuePeer::OLD_PRICE, ProductOptionsValuePeer::MAN_CODE, ProductOptionsValuePeer::PUM, ProductOptionsValuePeer::IS_UPDATED, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'sf_asset_id', 'product_id', 'product_options_template_id', 'product_options_value_id', 'product_options_field_id', 'price', 'weight', 'lft', 'rgt', 'stock', 'opt_value', 'price_type', 'depth', 'opt_version', 'color', 'use_image_as_color', 'opt_filter_id', 'use_product', 'old_price', 'man_code', 'pum', 'is_updated', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'SfAssetId' => 3, 'ProductId' => 4, 'ProductOptionsTemplateId' => 5, 'ProductOptionsValueId' => 6, 'ProductOptionsFieldId' => 7, 'Price' => 8, 'Weight' => 9, 'Lft' => 10, 'Rgt' => 11, 'Stock' => 12, 'OptValue' => 13, 'PriceType' => 14, 'Depth' => 15, 'OptVersion' => 16, 'Color' => 17, 'UseImageAsColor' => 18, 'OptFilterId' => 19, 'UseProduct' => 20, 'OldPrice' => 21, 'ManCode' => 22, 'Pum' => 23, 'IsUpdated' => 24, ),
		BasePeer::TYPE_COLNAME => array (ProductOptionsValuePeer::CREATED_AT => 0, ProductOptionsValuePeer::UPDATED_AT => 1, ProductOptionsValuePeer::ID => 2, ProductOptionsValuePeer::SF_ASSET_ID => 3, ProductOptionsValuePeer::PRODUCT_ID => 4, ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID => 5, ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID => 6, ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID => 7, ProductOptionsValuePeer::PRICE => 8, ProductOptionsValuePeer::WEIGHT => 9, ProductOptionsValuePeer::LFT => 10, ProductOptionsValuePeer::RGT => 11, ProductOptionsValuePeer::STOCK => 12, ProductOptionsValuePeer::OPT_VALUE => 13, ProductOptionsValuePeer::PRICE_TYPE => 14, ProductOptionsValuePeer::DEPTH => 15, ProductOptionsValuePeer::OPT_VERSION => 16, ProductOptionsValuePeer::COLOR => 17, ProductOptionsValuePeer::USE_IMAGE_AS_COLOR => 18, ProductOptionsValuePeer::OPT_FILTER_ID => 19, ProductOptionsValuePeer::USE_PRODUCT => 20, ProductOptionsValuePeer::OLD_PRICE => 21, ProductOptionsValuePeer::MAN_CODE => 22, ProductOptionsValuePeer::PUM => 23, ProductOptionsValuePeer::IS_UPDATED => 24, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'sf_asset_id' => 3, 'product_id' => 4, 'product_options_template_id' => 5, 'product_options_value_id' => 6, 'product_options_field_id' => 7, 'price' => 8, 'weight' => 9, 'lft' => 10, 'rgt' => 11, 'stock' => 12, 'opt_value' => 13, 'price_type' => 14, 'depth' => 15, 'opt_version' => 16, 'color' => 17, 'use_image_as_color' => 18, 'opt_filter_id' => 19, 'use_product' => 20, 'old_price' => 21, 'man_code' => 22, 'pum' => 23, 'is_updated' => 24, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, )
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
		return BasePeer::getMapBuilder('plugins.stProductOptionsPlugin.lib.model.map.ProductOptionsValueMapBuilder');
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
			$map = ProductOptionsValuePeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. ProductOptionsValuePeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(ProductOptionsValuePeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(ProductOptionsValuePeer::CREATED_AT);

		$criteria->addSelectColumn(ProductOptionsValuePeer::UPDATED_AT);

		$criteria->addSelectColumn(ProductOptionsValuePeer::ID);

		$criteria->addSelectColumn(ProductOptionsValuePeer::SF_ASSET_ID);

		$criteria->addSelectColumn(ProductOptionsValuePeer::PRODUCT_ID);

		$criteria->addSelectColumn(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID);

		$criteria->addSelectColumn(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID);

		$criteria->addSelectColumn(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID);

		$criteria->addSelectColumn(ProductOptionsValuePeer::PRICE);

		$criteria->addSelectColumn(ProductOptionsValuePeer::WEIGHT);

		$criteria->addSelectColumn(ProductOptionsValuePeer::LFT);

		$criteria->addSelectColumn(ProductOptionsValuePeer::RGT);

		$criteria->addSelectColumn(ProductOptionsValuePeer::STOCK);

		$criteria->addSelectColumn(ProductOptionsValuePeer::OPT_VALUE);

		$criteria->addSelectColumn(ProductOptionsValuePeer::PRICE_TYPE);

		$criteria->addSelectColumn(ProductOptionsValuePeer::DEPTH);

		$criteria->addSelectColumn(ProductOptionsValuePeer::OPT_VERSION);

		$criteria->addSelectColumn(ProductOptionsValuePeer::COLOR);

		$criteria->addSelectColumn(ProductOptionsValuePeer::USE_IMAGE_AS_COLOR);

		$criteria->addSelectColumn(ProductOptionsValuePeer::OPT_FILTER_ID);

		$criteria->addSelectColumn(ProductOptionsValuePeer::USE_PRODUCT);

		$criteria->addSelectColumn(ProductOptionsValuePeer::OLD_PRICE);

		$criteria->addSelectColumn(ProductOptionsValuePeer::MAN_CODE);

		$criteria->addSelectColumn(ProductOptionsValuePeer::PUM);

		$criteria->addSelectColumn(ProductOptionsValuePeer::IS_UPDATED);


		if (stEventDispatcher::getInstance()->getListeners('ProductOptionsValuePeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'ProductOptionsValuePeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_product_options_value.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_product_options_value.ID)';

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
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ProductOptionsValuePeer::doSelectRS($criteria, $con);
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
	 * @return     ProductOptionsValue
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = ProductOptionsValuePeer::doSelect($critcopy, $con);
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
		return ProductOptionsValuePeer::populateObjects(ProductOptionsValuePeer::doSelectRS($criteria, $con));
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
			ProductOptionsValuePeer::addSelectColumns($criteria);
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
		$cls = ProductOptionsValuePeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related sfAsset table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinsfAsset(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsValuePeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductOptionsValuePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
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
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_ID, ProductPeer::ID);

		$rs = ProductOptionsValuePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
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
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductOptionsValuePeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductOptionsValuePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of ProductOptionsValue objects pre-filled with their sfAsset objects.
	 *
	 * @return     array Array of ProductOptionsValue objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinsfAsset(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductOptionsValuePeer::addSelectColumns($c);

		sfAssetPeer::addSelectColumns($c);

		$c->addJoin(ProductOptionsValuePeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);
		$rs = ProductOptionsValuePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new ProductOptionsValue();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getSfAssetId())
                        {

			   $obj2 = new sfAsset();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addProductOptionsValue($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of ProductOptionsValue objects pre-filled with their Product objects.
	 *
	 * @return     array Array of ProductOptionsValue objects.
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

		ProductOptionsValuePeer::addSelectColumns($c);

		ProductPeer::addSelectColumns($c);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_ID, ProductPeer::ID);
		$rs = ProductOptionsValuePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new ProductOptionsValue();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getProductId())
                        {

			   $obj2 = new Product();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addProductOptionsValue($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of ProductOptionsValue objects pre-filled with their ProductOptionsTemplate objects.
	 *
	 * @return     array Array of ProductOptionsValue objects.
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

		ProductOptionsValuePeer::addSelectColumns($c);

		ProductOptionsTemplatePeer::addSelectColumns($c);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID, Criteria::LEFT_JOIN);
		$rs = ProductOptionsValuePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new ProductOptionsValue();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getProductOptionsTemplateId())
                        {

			   $obj2 = new ProductOptionsTemplate();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addProductOptionsValue($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of ProductOptionsValue objects pre-filled with their ProductOptionsField objects.
	 *
	 * @return     array Array of ProductOptionsValue objects.
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

		ProductOptionsValuePeer::addSelectColumns($c);

		ProductOptionsFieldPeer::addSelectColumns($c);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);
		$rs = ProductOptionsValuePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new ProductOptionsValue();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getProductOptionsFieldId())
                        {

			   $obj2 = new ProductOptionsField();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addProductOptionsValue($obj1);
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
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsValuePeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_ID, ProductPeer::ID);

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductOptionsValuePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of ProductOptionsValue objects pre-filled with all related objects.
	 *
	 * @return     array Array of ProductOptionsValue objects.
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

		ProductOptionsValuePeer::addSelectColumns($c);
		$startcol2 = (ProductOptionsValuePeer::NUM_COLUMNS - ProductOptionsValuePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfAssetPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfAssetPeer::NUM_COLUMNS;

		ProductPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProductPeer::NUM_COLUMNS;

		ProductOptionsTemplatePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + ProductOptionsTemplatePeer::NUM_COLUMNS;

		ProductOptionsFieldPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + ProductOptionsFieldPeer::NUM_COLUMNS;

		$c->addJoin(ProductOptionsValuePeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_ID, ProductPeer::ID);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductOptionsValuePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined sfAsset rows
	
			$omClass = sfAssetPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfAsset(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProductOptionsValue($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initProductOptionsValues();
				$obj2->addProductOptionsValue($obj1);
			}


				// Add objects for joined Product rows
	
			$omClass = ProductPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProduct(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProductOptionsValue($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initProductOptionsValues();
				$obj3->addProductOptionsValue($obj1);
			}


				// Add objects for joined ProductOptionsTemplate rows
	
			$omClass = ProductOptionsTemplatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getProductOptionsTemplate(); // CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProductOptionsValue($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj4->initProductOptionsValues();
				$obj4->addProductOptionsValue($obj1);
			}


				// Add objects for joined ProductOptionsField rows
	
			$omClass = ProductOptionsFieldPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5 = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getProductOptionsField(); // CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addProductOptionsValue($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj5->initProductOptionsValues();
				$obj5->addProductOptionsValue($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related sfAsset table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptsfAsset(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_ID, ProductPeer::ID);

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductOptionsValuePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
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
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsValuePeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductOptionsValuePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
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
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsValuePeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_ID, ProductPeer::ID);

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductOptionsValuePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related ProductOptionsValueRelatedByProductOptionsValueId table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptProductOptionsValueRelatedByProductOptionsValueId(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsValuePeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_ID, ProductPeer::ID);

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductOptionsValuePeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductOptionsValuePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductOptionsValuePeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_ID, ProductPeer::ID);

		$criteria->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductOptionsValuePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of ProductOptionsValue objects pre-filled with all related objects except sfAsset.
	 *
	 * @return     array Array of ProductOptionsValue objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptsfAsset(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductOptionsValuePeer::addSelectColumns($c);
		$startcol2 = (ProductOptionsValuePeer::NUM_COLUMNS - ProductOptionsValuePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ProductPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ProductPeer::NUM_COLUMNS;

		ProductOptionsTemplatePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProductOptionsTemplatePeer::NUM_COLUMNS;

		ProductOptionsFieldPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + ProductOptionsFieldPeer::NUM_COLUMNS;

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_ID, ProductPeer::ID);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductOptionsValuePeer::getOMClass();

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
					$temp_obj2->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProductOptionsValues();
				$obj2->addProductOptionsValue($obj1);
			}

			$omClass = ProductOptionsTemplatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProductOptionsTemplate(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initProductOptionsValues();
				$obj3->addProductOptionsValue($obj1);
			}

			$omClass = ProductOptionsFieldPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getProductOptionsField(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initProductOptionsValues();
				$obj4->addProductOptionsValue($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of ProductOptionsValue objects pre-filled with all related objects except Product.
	 *
	 * @return     array Array of ProductOptionsValue objects.
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

		ProductOptionsValuePeer::addSelectColumns($c);
		$startcol2 = (ProductOptionsValuePeer::NUM_COLUMNS - ProductOptionsValuePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfAssetPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfAssetPeer::NUM_COLUMNS;

		ProductOptionsTemplatePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProductOptionsTemplatePeer::NUM_COLUMNS;

		ProductOptionsFieldPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + ProductOptionsFieldPeer::NUM_COLUMNS;

		$c->addJoin(ProductOptionsValuePeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductOptionsValuePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfAssetPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfAsset(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProductOptionsValues();
				$obj2->addProductOptionsValue($obj1);
			}

			$omClass = ProductOptionsTemplatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProductOptionsTemplate(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initProductOptionsValues();
				$obj3->addProductOptionsValue($obj1);
			}

			$omClass = ProductOptionsFieldPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getProductOptionsField(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initProductOptionsValues();
				$obj4->addProductOptionsValue($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of ProductOptionsValue objects pre-filled with all related objects except ProductOptionsTemplate.
	 *
	 * @return     array Array of ProductOptionsValue objects.
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

		ProductOptionsValuePeer::addSelectColumns($c);
		$startcol2 = (ProductOptionsValuePeer::NUM_COLUMNS - ProductOptionsValuePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfAssetPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfAssetPeer::NUM_COLUMNS;

		ProductPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProductPeer::NUM_COLUMNS;

		ProductOptionsFieldPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + ProductOptionsFieldPeer::NUM_COLUMNS;

		$c->addJoin(ProductOptionsValuePeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_ID, ProductPeer::ID);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductOptionsValuePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfAssetPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfAsset(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProductOptionsValues();
				$obj2->addProductOptionsValue($obj1);
			}

			$omClass = ProductPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProduct(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initProductOptionsValues();
				$obj3->addProductOptionsValue($obj1);
			}

			$omClass = ProductOptionsFieldPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getProductOptionsField(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initProductOptionsValues();
				$obj4->addProductOptionsValue($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of ProductOptionsValue objects pre-filled with all related objects except ProductOptionsValueRelatedByProductOptionsValueId.
	 *
	 * @return     array Array of ProductOptionsValue objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptProductOptionsValueRelatedByProductOptionsValueId(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductOptionsValuePeer::addSelectColumns($c);
		$startcol2 = (ProductOptionsValuePeer::NUM_COLUMNS - ProductOptionsValuePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfAssetPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfAssetPeer::NUM_COLUMNS;

		ProductPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProductPeer::NUM_COLUMNS;

		ProductOptionsTemplatePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + ProductOptionsTemplatePeer::NUM_COLUMNS;

		ProductOptionsFieldPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + ProductOptionsFieldPeer::NUM_COLUMNS;

		$c->addJoin(ProductOptionsValuePeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_ID, ProductPeer::ID);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, ProductOptionsFieldPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductOptionsValuePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfAssetPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfAsset(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProductOptionsValues();
				$obj2->addProductOptionsValue($obj1);
			}

			$omClass = ProductPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProduct(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initProductOptionsValues();
				$obj3->addProductOptionsValue($obj1);
			}

			$omClass = ProductOptionsTemplatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getProductOptionsTemplate(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initProductOptionsValues();
				$obj4->addProductOptionsValue($obj1);
			}

			$omClass = ProductOptionsFieldPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getProductOptionsField(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initProductOptionsValues();
				$obj5->addProductOptionsValue($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of ProductOptionsValue objects pre-filled with all related objects except ProductOptionsField.
	 *
	 * @return     array Array of ProductOptionsValue objects.
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

		ProductOptionsValuePeer::addSelectColumns($c);
		$startcol2 = (ProductOptionsValuePeer::NUM_COLUMNS - ProductOptionsValuePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfAssetPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfAssetPeer::NUM_COLUMNS;

		ProductPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProductPeer::NUM_COLUMNS;

		ProductOptionsTemplatePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + ProductOptionsTemplatePeer::NUM_COLUMNS;

		$c->addJoin(ProductOptionsValuePeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_ID, ProductPeer::ID);

		$c->addJoin(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, ProductOptionsTemplatePeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductOptionsValuePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfAssetPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfAsset(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProductOptionsValues();
				$obj2->addProductOptionsValue($obj1);
			}

			$omClass = ProductPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProduct(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initProductOptionsValues();
				$obj3->addProductOptionsValue($obj1);
			}

			$omClass = ProductOptionsTemplatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getProductOptionsTemplate(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProductOptionsValue($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initProductOptionsValues();
				$obj4->addProductOptionsValue($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


     /**
      * Selects a collection of ProductOptionsValue objects pre-filled with their i18n objects.
      *
      * @return array Array of ProductOptionsValue objects.
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
          ProductOptionsValuePeer::addSelectColumns($c);
          ProductOptionsValueI18nPeer::addSelectColumns($c);
       }

      $c->addJoin(ProductOptionsValuePeer::ID, sprintf('%s AND %s = \'%s\'', ProductOptionsValueI18nPeer::ID, ProductOptionsValueI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

      $rs = ProductOptionsValuePeer::doSelectRs($c, $con);

      if (self::$hydrateMethod)
      {
         return call_user_func(self::$hydrateMethod, $rs);
      }

      $results = array();

      while($rs->next()) {

         $obj1 = new ProductOptionsValue();
         $startcol = $obj1->hydrate($rs);
         $obj1->setCulture($culture);

         $obj2 = new ProductOptionsValueI18n();
         $obj2->hydrate($rs, $startcol);

         $obj1->setProductOptionsValueI18nForCulture($obj2, $culture);
         $obj2->setProductOptionsValue($obj1);

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
		return ProductOptionsValuePeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a ProductOptionsValue or Criteria object.
	 *
	 * @param      mixed $values Criteria or ProductOptionsValue object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseProductOptionsValuePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseProductOptionsValuePeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from ProductOptionsValue object
		}

		$criteria->remove(ProductOptionsValuePeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseProductOptionsValuePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseProductOptionsValuePeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a ProductOptionsValue or Criteria object.
	 *
	 * @param      mixed $values Criteria or ProductOptionsValue object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseProductOptionsValuePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseProductOptionsValuePeer', $values, $con);
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

			$comparison = $criteria->getComparison(ProductOptionsValuePeer::ID);
			$selectCriteria->add(ProductOptionsValuePeer::ID, $criteria->remove(ProductOptionsValuePeer::ID), $comparison);

		} else { // $values is ProductOptionsValue object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseProductOptionsValuePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseProductOptionsValuePeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_product_options_value table.
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
			$affectedRows += ProductOptionsValuePeer::doOnDeleteCascade(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(ProductOptionsValuePeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a ProductOptionsValue or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or ProductOptionsValue object or primary key or array of primary keys
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
			$con = Propel::getConnection(ProductOptionsValuePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof ProductOptionsValue) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ProductOptionsValuePeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += ProductOptionsValuePeer::doOnDeleteCascade($criteria, $con);
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
		$objects = ProductOptionsValuePeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related ProductOptionsValueI18n objects
			$c = new Criteria();
			
			$c->add(ProductOptionsValueI18nPeer::ID, $obj->getId());
			$affectedRows += ProductOptionsValueI18nPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	/**
	 * Validates all modified columns of given ProductOptionsValue object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      ProductOptionsValue $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(ProductOptionsValue $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ProductOptionsValuePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ProductOptionsValuePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ProductOptionsValuePeer::DATABASE_NAME, ProductOptionsValuePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ProductOptionsValuePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     ProductOptionsValue
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(ProductOptionsValuePeer::DATABASE_NAME);

		$criteria->add(ProductOptionsValuePeer::ID, $pk);


		$v = ProductOptionsValuePeer::doSelect($criteria, $con);

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
			$criteria->add(ProductOptionsValuePeer::ID, $pks, Criteria::IN);
			$objs = ProductOptionsValuePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseProductOptionsValuePeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseProductOptionsValuePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stProductOptionsPlugin.lib.model.map.ProductOptionsValueMapBuilder');
}
