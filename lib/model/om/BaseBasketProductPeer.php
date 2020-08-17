<?php

/**
 * Base static class for performing query and update operations on the 'st_basket_product' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseBasketProductPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_basket_product';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.BasketProduct';

	/** The total number of columns. */
	const NUM_COLUMNS = 24;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_basket_product.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_basket_product.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_basket_product.ID';

	/** the column name for the PRODUCT_ID field */
	const PRODUCT_ID = 'st_basket_product.PRODUCT_ID';

	/** the column name for the PRODUCT_SET_DISCOUNT_ID field */
	const PRODUCT_SET_DISCOUNT_ID = 'st_basket_product.PRODUCT_SET_DISCOUNT_ID';

	/** the column name for the BASKET_ID field */
	const BASKET_ID = 'st_basket_product.BASKET_ID';

	/** the column name for the IS_GIFT field */
	const IS_GIFT = 'st_basket_product.IS_GIFT';

	/** the column name for the QUANTITY field */
	const QUANTITY = 'st_basket_product.QUANTITY';

	/** the column name for the MAX_QUANTITY field */
	const MAX_QUANTITY = 'st_basket_product.MAX_QUANTITY';

	/** the column name for the CODE field */
	const CODE = 'st_basket_product.CODE';

	/** the column name for the NAME field */
	const NAME = 'st_basket_product.NAME';

	/** the column name for the IMAGE field */
	const IMAGE = 'st_basket_product.IMAGE';

	/** the column name for the ITEM_ID field */
	const ITEM_ID = 'st_basket_product.ITEM_ID';

	/** the column name for the PRICE field */
	const PRICE = 'st_basket_product.PRICE';

	/** the column name for the PRICE_BRUTTO field */
	const PRICE_BRUTTO = 'st_basket_product.PRICE_BRUTTO';

	/** the column name for the VAT field */
	const VAT = 'st_basket_product.VAT';

	/** the column name for the WEIGHT field */
	const WEIGHT = 'st_basket_product.WEIGHT';

	/** the column name for the PRODUCT_FOR_POINTS field */
	const PRODUCT_FOR_POINTS = 'st_basket_product.PRODUCT_FOR_POINTS';

	/** the column name for the PRICE_MODIFIERS field */
	const PRICE_MODIFIERS = 'st_basket_product.PRICE_MODIFIERS';

	/** the column name for the DISCOUNT field */
	const DISCOUNT = 'st_basket_product.DISCOUNT';

	/** the column name for the CURRENCY field */
	const CURRENCY = 'st_basket_product.CURRENCY';

	/** the column name for the WHOLESALE field */
	const WHOLESALE = 'st_basket_product.WHOLESALE';

	/** the column name for the OPTIONS field */
	const OPTIONS = 'st_basket_product.OPTIONS';

	/** the column name for the NEW_OPTIONS field */
	const NEW_OPTIONS = 'st_basket_product.NEW_OPTIONS';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'ProductId', 'ProductSetDiscountId', 'BasketId', 'IsGift', 'Quantity', 'MaxQuantity', 'Code', 'Name', 'Image', 'ItemId', 'Price', 'PriceBrutto', 'Vat', 'Weight', 'ProductForPoints', 'PriceModifiers', 'Discount', 'Currency', 'Wholesale', 'Options', 'NewOptions', ),
		BasePeer::TYPE_COLNAME => array (BasketProductPeer::CREATED_AT, BasketProductPeer::UPDATED_AT, BasketProductPeer::ID, BasketProductPeer::PRODUCT_ID, BasketProductPeer::PRODUCT_SET_DISCOUNT_ID, BasketProductPeer::BASKET_ID, BasketProductPeer::IS_GIFT, BasketProductPeer::QUANTITY, BasketProductPeer::MAX_QUANTITY, BasketProductPeer::CODE, BasketProductPeer::NAME, BasketProductPeer::IMAGE, BasketProductPeer::ITEM_ID, BasketProductPeer::PRICE, BasketProductPeer::PRICE_BRUTTO, BasketProductPeer::VAT, BasketProductPeer::WEIGHT, BasketProductPeer::PRODUCT_FOR_POINTS, BasketProductPeer::PRICE_MODIFIERS, BasketProductPeer::DISCOUNT, BasketProductPeer::CURRENCY, BasketProductPeer::WHOLESALE, BasketProductPeer::OPTIONS, BasketProductPeer::NEW_OPTIONS, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'product_id', 'product_set_discount_id', 'basket_id', 'is_gift', 'quantity', 'max_quantity', 'code', 'name', 'image', 'item_id', 'price', 'price_brutto', 'vat', 'weight', 'product_for_points', 'price_modifiers', 'discount', 'currency', 'wholesale', 'options', 'new_options', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'ProductId' => 3, 'ProductSetDiscountId' => 4, 'BasketId' => 5, 'IsGift' => 6, 'Quantity' => 7, 'MaxQuantity' => 8, 'Code' => 9, 'Name' => 10, 'Image' => 11, 'ItemId' => 12, 'Price' => 13, 'PriceBrutto' => 14, 'Vat' => 15, 'Weight' => 16, 'ProductForPoints' => 17, 'PriceModifiers' => 18, 'Discount' => 19, 'Currency' => 20, 'Wholesale' => 21, 'Options' => 22, 'NewOptions' => 23, ),
		BasePeer::TYPE_COLNAME => array (BasketProductPeer::CREATED_AT => 0, BasketProductPeer::UPDATED_AT => 1, BasketProductPeer::ID => 2, BasketProductPeer::PRODUCT_ID => 3, BasketProductPeer::PRODUCT_SET_DISCOUNT_ID => 4, BasketProductPeer::BASKET_ID => 5, BasketProductPeer::IS_GIFT => 6, BasketProductPeer::QUANTITY => 7, BasketProductPeer::MAX_QUANTITY => 8, BasketProductPeer::CODE => 9, BasketProductPeer::NAME => 10, BasketProductPeer::IMAGE => 11, BasketProductPeer::ITEM_ID => 12, BasketProductPeer::PRICE => 13, BasketProductPeer::PRICE_BRUTTO => 14, BasketProductPeer::VAT => 15, BasketProductPeer::WEIGHT => 16, BasketProductPeer::PRODUCT_FOR_POINTS => 17, BasketProductPeer::PRICE_MODIFIERS => 18, BasketProductPeer::DISCOUNT => 19, BasketProductPeer::CURRENCY => 20, BasketProductPeer::WHOLESALE => 21, BasketProductPeer::OPTIONS => 22, BasketProductPeer::NEW_OPTIONS => 23, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'product_id' => 3, 'product_set_discount_id' => 4, 'basket_id' => 5, 'is_gift' => 6, 'quantity' => 7, 'max_quantity' => 8, 'code' => 9, 'name' => 10, 'image' => 11, 'item_id' => 12, 'price' => 13, 'price_brutto' => 14, 'vat' => 15, 'weight' => 16, 'product_for_points' => 17, 'price_modifiers' => 18, 'discount' => 19, 'currency' => 20, 'wholesale' => 21, 'options' => 22, 'new_options' => 23, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, )
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
		return BasePeer::getMapBuilder('lib.model.map.BasketProductMapBuilder');
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
			$map = BasketProductPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. BasketProductPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(BasketProductPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(BasketProductPeer::CREATED_AT);

		$criteria->addSelectColumn(BasketProductPeer::UPDATED_AT);

		$criteria->addSelectColumn(BasketProductPeer::ID);

		$criteria->addSelectColumn(BasketProductPeer::PRODUCT_ID);

		$criteria->addSelectColumn(BasketProductPeer::PRODUCT_SET_DISCOUNT_ID);

		$criteria->addSelectColumn(BasketProductPeer::BASKET_ID);

		$criteria->addSelectColumn(BasketProductPeer::IS_GIFT);

		$criteria->addSelectColumn(BasketProductPeer::QUANTITY);

		$criteria->addSelectColumn(BasketProductPeer::MAX_QUANTITY);

		$criteria->addSelectColumn(BasketProductPeer::CODE);

		$criteria->addSelectColumn(BasketProductPeer::NAME);

		$criteria->addSelectColumn(BasketProductPeer::IMAGE);

		$criteria->addSelectColumn(BasketProductPeer::ITEM_ID);

		$criteria->addSelectColumn(BasketProductPeer::PRICE);

		$criteria->addSelectColumn(BasketProductPeer::PRICE_BRUTTO);

		$criteria->addSelectColumn(BasketProductPeer::VAT);

		$criteria->addSelectColumn(BasketProductPeer::WEIGHT);

		$criteria->addSelectColumn(BasketProductPeer::PRODUCT_FOR_POINTS);

		$criteria->addSelectColumn(BasketProductPeer::PRICE_MODIFIERS);

		$criteria->addSelectColumn(BasketProductPeer::DISCOUNT);

		$criteria->addSelectColumn(BasketProductPeer::CURRENCY);

		$criteria->addSelectColumn(BasketProductPeer::WHOLESALE);

		$criteria->addSelectColumn(BasketProductPeer::OPTIONS);

		$criteria->addSelectColumn(BasketProductPeer::NEW_OPTIONS);


		if (stEventDispatcher::getInstance()->getListeners('BasketProductPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'BasketProductPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_basket_product.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_basket_product.ID)';

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
			$criteria->addSelectColumn(BasketProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(BasketProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = BasketProductPeer::doSelectRS($criteria, $con);
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
	 * @return     BasketProduct
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = BasketProductPeer::doSelect($critcopy, $con);
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
		return BasketProductPeer::populateObjects(BasketProductPeer::doSelectRS($criteria, $con));
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
			BasketProductPeer::addSelectColumns($criteria);
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
		$cls = BasketProductPeer::getOMClass();
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
			$criteria->addSelectColumn(BasketProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(BasketProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(BasketProductPeer::PRODUCT_ID, ProductPeer::ID);

		$rs = BasketProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Basket table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinBasket(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(BasketProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(BasketProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(BasketProductPeer::BASKET_ID, BasketPeer::ID);

		$rs = BasketProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of BasketProduct objects pre-filled with their Product objects.
	 *
	 * @return     array Array of BasketProduct objects.
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

		BasketProductPeer::addSelectColumns($c);

		ProductPeer::addSelectColumns($c);

		$c->addJoin(BasketProductPeer::PRODUCT_ID, ProductPeer::ID);
		$rs = BasketProductPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new BasketProduct();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getProductId())
                        {

			   $obj2 = new Product();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addBasketProduct($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of BasketProduct objects pre-filled with their Basket objects.
	 *
	 * @return     array Array of BasketProduct objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinBasket(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		BasketProductPeer::addSelectColumns($c);

		BasketPeer::addSelectColumns($c);

		$c->addJoin(BasketProductPeer::BASKET_ID, BasketPeer::ID);
		$rs = BasketProductPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new BasketProduct();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getBasketId())
                        {

			   $obj2 = new Basket();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addBasketProduct($obj1);
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
			$criteria->addSelectColumn(BasketProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(BasketProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(BasketProductPeer::PRODUCT_ID, ProductPeer::ID);

		$criteria->addJoin(BasketProductPeer::BASKET_ID, BasketPeer::ID);

		$rs = BasketProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of BasketProduct objects pre-filled with all related objects.
	 *
	 * @return     array Array of BasketProduct objects.
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

		BasketProductPeer::addSelectColumns($c);
		$startcol2 = (BasketProductPeer::NUM_COLUMNS - BasketProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ProductPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ProductPeer::NUM_COLUMNS;

		BasketPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + BasketPeer::NUM_COLUMNS;

		$c->addJoin(BasketProductPeer::PRODUCT_ID, ProductPeer::ID);

		$c->addJoin(BasketProductPeer::BASKET_ID, BasketPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = BasketProductPeer::getOMClass();


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
					$temp_obj2->addBasketProduct($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initBasketProducts();
				$obj2->addBasketProduct($obj1);
			}


				// Add objects for joined Basket rows
	
			$omClass = BasketPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getBasket(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addBasketProduct($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initBasketProducts();
				$obj3->addBasketProduct($obj1);
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
			$criteria->addSelectColumn(BasketProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(BasketProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(BasketProductPeer::BASKET_ID, BasketPeer::ID);

		$rs = BasketProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Basket table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptBasket(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(BasketProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(BasketProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(BasketProductPeer::PRODUCT_ID, ProductPeer::ID);

		$rs = BasketProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of BasketProduct objects pre-filled with all related objects except Product.
	 *
	 * @return     array Array of BasketProduct objects.
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

		BasketProductPeer::addSelectColumns($c);
		$startcol2 = (BasketProductPeer::NUM_COLUMNS - BasketProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		BasketPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + BasketPeer::NUM_COLUMNS;

		$c->addJoin(BasketProductPeer::BASKET_ID, BasketPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = BasketProductPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = BasketPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getBasket(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addBasketProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initBasketProducts();
				$obj2->addBasketProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of BasketProduct objects pre-filled with all related objects except Basket.
	 *
	 * @return     array Array of BasketProduct objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptBasket(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		BasketProductPeer::addSelectColumns($c);
		$startcol2 = (BasketProductPeer::NUM_COLUMNS - BasketProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ProductPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ProductPeer::NUM_COLUMNS;

		$c->addJoin(BasketProductPeer::PRODUCT_ID, ProductPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = BasketProductPeer::getOMClass();

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
					$temp_obj2->addBasketProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initBasketProducts();
				$obj2->addBasketProduct($obj1);
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
		return BasketProductPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a BasketProduct or Criteria object.
	 *
	 * @param      mixed $values Criteria or BasketProduct object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseBasketProductPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseBasketProductPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from BasketProduct object
		}

		$criteria->remove(BasketProductPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseBasketProductPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseBasketProductPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a BasketProduct or Criteria object.
	 *
	 * @param      mixed $values Criteria or BasketProduct object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseBasketProductPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseBasketProductPeer', $values, $con);
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

			$comparison = $criteria->getComparison(BasketProductPeer::ID);
			$selectCriteria->add(BasketProductPeer::ID, $criteria->remove(BasketProductPeer::ID), $comparison);

		} else { // $values is BasketProduct object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseBasketProductPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseBasketProductPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_basket_product table.
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
			$affectedRows += BasePeer::doDeleteAll(BasketProductPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a BasketProduct or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or BasketProduct object or primary key or array of primary keys
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
			$con = Propel::getConnection(BasketProductPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof BasketProduct) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(BasketProductPeer::ID, (array) $values, Criteria::IN);
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
	 * Validates all modified columns of given BasketProduct object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      BasketProduct $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(BasketProduct $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(BasketProductPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(BasketProductPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(BasketProductPeer::DATABASE_NAME, BasketProductPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = BasketProductPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     BasketProduct
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(BasketProductPeer::DATABASE_NAME);

		$criteria->add(BasketProductPeer::ID, $pk);


		$v = BasketProductPeer::doSelect($criteria, $con);

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
			$criteria->add(BasketProductPeer::ID, $pks, Criteria::IN);
			$objs = BasketProductPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseBasketProductPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseBasketProductPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('lib.model.map.BasketProductMapBuilder');
}
