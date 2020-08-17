<?php

/**
 * Base static class for performing query and update operations on the 'st_order_product' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseOrderProductPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_order_product';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.OrderProduct';

	/** The total number of columns. */
	const NUM_COLUMNS = 29;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_order_product.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_order_product.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_order_product.ID';

	/** the column name for the ORDER_ID field */
	const ORDER_ID = 'st_order_product.ORDER_ID';

	/** the column name for the PRODUCT_ID field */
	const PRODUCT_ID = 'st_order_product.PRODUCT_ID';

	/** the column name for the TAX_ID field */
	const TAX_ID = 'st_order_product.TAX_ID';

	/** the column name for the QUANTITY field */
	const QUANTITY = 'st_order_product.QUANTITY';

	/** the column name for the CODE field */
	const CODE = 'st_order_product.CODE';

	/** the column name for the NAME field */
	const NAME = 'st_order_product.NAME';

	/** the column name for the IMAGE field */
	const IMAGE = 'st_order_product.IMAGE';

	/** the column name for the PRICE field */
	const PRICE = 'st_order_product.PRICE';

	/** the column name for the PRICE_BRUTTO field */
	const PRICE_BRUTTO = 'st_order_product.PRICE_BRUTTO';

	/** the column name for the CUSTOM_PRICE field */
	const CUSTOM_PRICE = 'st_order_product.CUSTOM_PRICE';

	/** the column name for the CUSTOM_PRICE_BRUTTO field */
	const CUSTOM_PRICE_BRUTTO = 'st_order_product.CUSTOM_PRICE_BRUTTO';

	/** the column name for the VAT field */
	const VAT = 'st_order_product.VAT';

	/** the column name for the POINTS_VALUE field */
	const POINTS_VALUE = 'st_order_product.POINTS_VALUE';

	/** the column name for the POINTS_EARN field */
	const POINTS_EARN = 'st_order_product.POINTS_EARN';

	/** the column name for the PRODUCT_FOR_POINTS field */
	const PRODUCT_FOR_POINTS = 'st_order_product.PRODUCT_FOR_POINTS';

	/** the column name for the VERSION field */
	const VERSION = 'st_order_product.VERSION';

	/** the column name for the IS_SET field */
	const IS_SET = 'st_order_product.IS_SET';

	/** the column name for the IS_GIFT field */
	const IS_GIFT = 'st_order_product.IS_GIFT';

	/** the column name for the SEND_REVIEW field */
	const SEND_REVIEW = 'st_order_product.SEND_REVIEW';

	/** the column name for the PRICE_MODIFIERS field */
	const PRICE_MODIFIERS = 'st_order_product.PRICE_MODIFIERS';

	/** the column name for the DISCOUNT field */
	const DISCOUNT = 'st_order_product.DISCOUNT';

	/** the column name for the CURRENCY field */
	const CURRENCY = 'st_order_product.CURRENCY';

	/** the column name for the WHOLESALE field */
	const WHOLESALE = 'st_order_product.WHOLESALE';

	/** the column name for the ONLINE_CODE field */
	const ONLINE_CODE = 'st_order_product.ONLINE_CODE';

	/** the column name for the ALLEGRO_AUCTION_ID field */
	const ALLEGRO_AUCTION_ID = 'st_order_product.ALLEGRO_AUCTION_ID';

	/** the column name for the OPTIONS field */
	const OPTIONS = 'st_order_product.OPTIONS';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'OrderId', 'ProductId', 'TaxId', 'Quantity', 'Code', 'Name', 'Image', 'Price', 'PriceBrutto', 'CustomPrice', 'CustomPriceBrutto', 'Vat', 'PointsValue', 'PointsEarn', 'ProductForPoints', 'Version', 'IsSet', 'IsGift', 'SendReview', 'PriceModifiers', 'Discount', 'Currency', 'Wholesale', 'OnlineCode', 'AllegroAuctionId', 'Options', ),
		BasePeer::TYPE_COLNAME => array (OrderProductPeer::CREATED_AT, OrderProductPeer::UPDATED_AT, OrderProductPeer::ID, OrderProductPeer::ORDER_ID, OrderProductPeer::PRODUCT_ID, OrderProductPeer::TAX_ID, OrderProductPeer::QUANTITY, OrderProductPeer::CODE, OrderProductPeer::NAME, OrderProductPeer::IMAGE, OrderProductPeer::PRICE, OrderProductPeer::PRICE_BRUTTO, OrderProductPeer::CUSTOM_PRICE, OrderProductPeer::CUSTOM_PRICE_BRUTTO, OrderProductPeer::VAT, OrderProductPeer::POINTS_VALUE, OrderProductPeer::POINTS_EARN, OrderProductPeer::PRODUCT_FOR_POINTS, OrderProductPeer::VERSION, OrderProductPeer::IS_SET, OrderProductPeer::IS_GIFT, OrderProductPeer::SEND_REVIEW, OrderProductPeer::PRICE_MODIFIERS, OrderProductPeer::DISCOUNT, OrderProductPeer::CURRENCY, OrderProductPeer::WHOLESALE, OrderProductPeer::ONLINE_CODE, OrderProductPeer::ALLEGRO_AUCTION_ID, OrderProductPeer::OPTIONS, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'order_id', 'product_id', 'tax_id', 'quantity', 'code', 'name', 'image', 'price', 'price_brutto', 'custom_price', 'custom_price_brutto', 'vat', 'points_value', 'points_earn', 'product_for_points', 'version', 'is_set', 'is_gift', 'send_review', 'price_modifiers', 'discount', 'currency', 'wholesale', 'online_code', 'allegro_auction_id', 'options', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'OrderId' => 3, 'ProductId' => 4, 'TaxId' => 5, 'Quantity' => 6, 'Code' => 7, 'Name' => 8, 'Image' => 9, 'Price' => 10, 'PriceBrutto' => 11, 'CustomPrice' => 12, 'CustomPriceBrutto' => 13, 'Vat' => 14, 'PointsValue' => 15, 'PointsEarn' => 16, 'ProductForPoints' => 17, 'Version' => 18, 'IsSet' => 19, 'IsGift' => 20, 'SendReview' => 21, 'PriceModifiers' => 22, 'Discount' => 23, 'Currency' => 24, 'Wholesale' => 25, 'OnlineCode' => 26, 'AllegroAuctionId' => 27, 'Options' => 28, ),
		BasePeer::TYPE_COLNAME => array (OrderProductPeer::CREATED_AT => 0, OrderProductPeer::UPDATED_AT => 1, OrderProductPeer::ID => 2, OrderProductPeer::ORDER_ID => 3, OrderProductPeer::PRODUCT_ID => 4, OrderProductPeer::TAX_ID => 5, OrderProductPeer::QUANTITY => 6, OrderProductPeer::CODE => 7, OrderProductPeer::NAME => 8, OrderProductPeer::IMAGE => 9, OrderProductPeer::PRICE => 10, OrderProductPeer::PRICE_BRUTTO => 11, OrderProductPeer::CUSTOM_PRICE => 12, OrderProductPeer::CUSTOM_PRICE_BRUTTO => 13, OrderProductPeer::VAT => 14, OrderProductPeer::POINTS_VALUE => 15, OrderProductPeer::POINTS_EARN => 16, OrderProductPeer::PRODUCT_FOR_POINTS => 17, OrderProductPeer::VERSION => 18, OrderProductPeer::IS_SET => 19, OrderProductPeer::IS_GIFT => 20, OrderProductPeer::SEND_REVIEW => 21, OrderProductPeer::PRICE_MODIFIERS => 22, OrderProductPeer::DISCOUNT => 23, OrderProductPeer::CURRENCY => 24, OrderProductPeer::WHOLESALE => 25, OrderProductPeer::ONLINE_CODE => 26, OrderProductPeer::ALLEGRO_AUCTION_ID => 27, OrderProductPeer::OPTIONS => 28, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'order_id' => 3, 'product_id' => 4, 'tax_id' => 5, 'quantity' => 6, 'code' => 7, 'name' => 8, 'image' => 9, 'price' => 10, 'price_brutto' => 11, 'custom_price' => 12, 'custom_price_brutto' => 13, 'vat' => 14, 'points_value' => 15, 'points_earn' => 16, 'product_for_points' => 17, 'version' => 18, 'is_set' => 19, 'is_gift' => 20, 'send_review' => 21, 'price_modifiers' => 22, 'discount' => 23, 'currency' => 24, 'wholesale' => 25, 'online_code' => 26, 'allegro_auction_id' => 27, 'options' => 28, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, )
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
		return BasePeer::getMapBuilder('lib.model.map.OrderProductMapBuilder');
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
			$map = OrderProductPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. OrderProductPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(OrderProductPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(OrderProductPeer::CREATED_AT);

		$criteria->addSelectColumn(OrderProductPeer::UPDATED_AT);

		$criteria->addSelectColumn(OrderProductPeer::ID);

		$criteria->addSelectColumn(OrderProductPeer::ORDER_ID);

		$criteria->addSelectColumn(OrderProductPeer::PRODUCT_ID);

		$criteria->addSelectColumn(OrderProductPeer::TAX_ID);

		$criteria->addSelectColumn(OrderProductPeer::QUANTITY);

		$criteria->addSelectColumn(OrderProductPeer::CODE);

		$criteria->addSelectColumn(OrderProductPeer::NAME);

		$criteria->addSelectColumn(OrderProductPeer::IMAGE);

		$criteria->addSelectColumn(OrderProductPeer::PRICE);

		$criteria->addSelectColumn(OrderProductPeer::PRICE_BRUTTO);

		$criteria->addSelectColumn(OrderProductPeer::CUSTOM_PRICE);

		$criteria->addSelectColumn(OrderProductPeer::CUSTOM_PRICE_BRUTTO);

		$criteria->addSelectColumn(OrderProductPeer::VAT);

		$criteria->addSelectColumn(OrderProductPeer::POINTS_VALUE);

		$criteria->addSelectColumn(OrderProductPeer::POINTS_EARN);

		$criteria->addSelectColumn(OrderProductPeer::PRODUCT_FOR_POINTS);

		$criteria->addSelectColumn(OrderProductPeer::VERSION);

		$criteria->addSelectColumn(OrderProductPeer::IS_SET);

		$criteria->addSelectColumn(OrderProductPeer::IS_GIFT);

		$criteria->addSelectColumn(OrderProductPeer::SEND_REVIEW);

		$criteria->addSelectColumn(OrderProductPeer::PRICE_MODIFIERS);

		$criteria->addSelectColumn(OrderProductPeer::DISCOUNT);

		$criteria->addSelectColumn(OrderProductPeer::CURRENCY);

		$criteria->addSelectColumn(OrderProductPeer::WHOLESALE);

		$criteria->addSelectColumn(OrderProductPeer::ONLINE_CODE);

		$criteria->addSelectColumn(OrderProductPeer::ALLEGRO_AUCTION_ID);

		$criteria->addSelectColumn(OrderProductPeer::OPTIONS);


		if (stEventDispatcher::getInstance()->getListeners('OrderProductPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'OrderProductPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_order_product.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_order_product.ID)';

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
			$criteria->addSelectColumn(OrderProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OrderProductPeer::doSelectRS($criteria, $con);
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
	 * @return     OrderProduct
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = OrderProductPeer::doSelect($critcopy, $con);
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
		return OrderProductPeer::populateObjects(OrderProductPeer::doSelectRS($criteria, $con));
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
			OrderProductPeer::addSelectColumns($criteria);
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
		$cls = OrderProductPeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related Order table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinOrder(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderProductPeer::ORDER_ID, OrderPeer::ID);

		$rs = OrderProductPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(OrderProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderProductPeer::PRODUCT_ID, ProductPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderProductPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(OrderProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of OrderProduct objects pre-filled with their Order objects.
	 *
	 * @return     array Array of OrderProduct objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinOrder(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderProductPeer::addSelectColumns($c);

		OrderPeer::addSelectColumns($c);

		$c->addJoin(OrderProductPeer::ORDER_ID, OrderPeer::ID);
		$rs = OrderProductPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new OrderProduct();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getOrderId())
                        {

			   $obj2 = new Order();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrderProduct($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of OrderProduct objects pre-filled with their Product objects.
	 *
	 * @return     array Array of OrderProduct objects.
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

		OrderProductPeer::addSelectColumns($c);

		ProductPeer::addSelectColumns($c);

		$c->addJoin(OrderProductPeer::PRODUCT_ID, ProductPeer::ID, Criteria::LEFT_JOIN);
		$rs = OrderProductPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new OrderProduct();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getProductId())
                        {

			   $obj2 = new Product();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrderProduct($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of OrderProduct objects pre-filled with their Tax objects.
	 *
	 * @return     array Array of OrderProduct objects.
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

		OrderProductPeer::addSelectColumns($c);

		TaxPeer::addSelectColumns($c);

		$c->addJoin(OrderProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);
		$rs = OrderProductPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new OrderProduct();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getTaxId())
                        {

			   $obj2 = new Tax();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrderProduct($obj1);
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
			$criteria->addSelectColumn(OrderProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderProductPeer::ORDER_ID, OrderPeer::ID);

		$criteria->addJoin(OrderProductPeer::PRODUCT_ID, ProductPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of OrderProduct objects pre-filled with all related objects.
	 *
	 * @return     array Array of OrderProduct objects.
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

		OrderProductPeer::addSelectColumns($c);
		$startcol2 = (OrderProductPeer::NUM_COLUMNS - OrderProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderPeer::NUM_COLUMNS;

		ProductPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProductPeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(OrderProductPeer::ORDER_ID, OrderPeer::ID);

		$c->addJoin(OrderProductPeer::PRODUCT_ID, ProductPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderProductPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined Order rows
	
			$omClass = OrderPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrder(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOrderProduct($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrderProducts();
				$obj2->addOrderProduct($obj1);
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
					$temp_obj3->addOrderProduct($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initOrderProducts();
				$obj3->addOrderProduct($obj1);
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
					$temp_obj4->addOrderProduct($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj4->initOrderProducts();
				$obj4->addOrderProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Order table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptOrder(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderProductPeer::PRODUCT_ID, ProductPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderProductPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(OrderProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderProductPeer::ORDER_ID, OrderPeer::ID);

		$criteria->addJoin(OrderProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderProductPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(OrderProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderProductPeer::ORDER_ID, OrderPeer::ID);

		$criteria->addJoin(OrderProductPeer::PRODUCT_ID, ProductPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of OrderProduct objects pre-filled with all related objects except Order.
	 *
	 * @return     array Array of OrderProduct objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptOrder(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderProductPeer::addSelectColumns($c);
		$startcol2 = (OrderProductPeer::NUM_COLUMNS - OrderProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ProductPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ProductPeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(OrderProductPeer::PRODUCT_ID, ProductPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderProductPeer::getOMClass();

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
					$temp_obj2->addOrderProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrderProducts();
				$obj2->addOrderProduct($obj1);
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
					$temp_obj3->addOrderProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initOrderProducts();
				$obj3->addOrderProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of OrderProduct objects pre-filled with all related objects except Product.
	 *
	 * @return     array Array of OrderProduct objects.
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

		OrderProductPeer::addSelectColumns($c);
		$startcol2 = (OrderProductPeer::NUM_COLUMNS - OrderProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderPeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(OrderProductPeer::ORDER_ID, OrderPeer::ID);

		$c->addJoin(OrderProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderProductPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OrderPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrder(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOrderProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrderProducts();
				$obj2->addOrderProduct($obj1);
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
					$temp_obj3->addOrderProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initOrderProducts();
				$obj3->addOrderProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of OrderProduct objects pre-filled with all related objects except Tax.
	 *
	 * @return     array Array of OrderProduct objects.
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

		OrderProductPeer::addSelectColumns($c);
		$startcol2 = (OrderProductPeer::NUM_COLUMNS - OrderProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderPeer::NUM_COLUMNS;

		ProductPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProductPeer::NUM_COLUMNS;

		$c->addJoin(OrderProductPeer::ORDER_ID, OrderPeer::ID);

		$c->addJoin(OrderProductPeer::PRODUCT_ID, ProductPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderProductPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OrderPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrder(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOrderProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrderProducts();
				$obj2->addOrderProduct($obj1);
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
					$temp_obj3->addOrderProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initOrderProducts();
				$obj3->addOrderProduct($obj1);
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
		return OrderProductPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a OrderProduct or Criteria object.
	 *
	 * @param      mixed $values Criteria or OrderProduct object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseOrderProductPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseOrderProductPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from OrderProduct object
		}

		$criteria->remove(OrderProductPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseOrderProductPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseOrderProductPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a OrderProduct or Criteria object.
	 *
	 * @param      mixed $values Criteria or OrderProduct object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseOrderProductPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseOrderProductPeer', $values, $con);
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

			$comparison = $criteria->getComparison(OrderProductPeer::ID);
			$selectCriteria->add(OrderProductPeer::ID, $criteria->remove(OrderProductPeer::ID), $comparison);

		} else { // $values is OrderProduct object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseOrderProductPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseOrderProductPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_order_product table.
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
			$affectedRows += OrderProductPeer::doOnDeleteCascade(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(OrderProductPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a OrderProduct or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or OrderProduct object or primary key or array of primary keys
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
			$con = Propel::getConnection(OrderProductPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof OrderProduct) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(OrderProductPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += OrderProductPeer::doOnDeleteCascade($criteria, $con);
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
		$objects = OrderProductPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related OrderProductHasSet objects
			$c = new Criteria();
			
			$c->add(OrderProductHasSetPeer::ORDER_PRODUCT_ID, $obj->getId());
			$affectedRows += OrderProductHasSetPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	/**
	 * Validates all modified columns of given OrderProduct object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      OrderProduct $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(OrderProduct $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OrderProductPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OrderProductPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OrderProductPeer::DATABASE_NAME, OrderProductPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OrderProductPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     OrderProduct
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(OrderProductPeer::DATABASE_NAME);

		$criteria->add(OrderProductPeer::ID, $pk);


		$v = OrderProductPeer::doSelect($criteria, $con);

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
			$criteria->add(OrderProductPeer::ID, $pks, Criteria::IN);
			$objs = OrderProductPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseOrderProductPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseOrderProductPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('lib.model.map.OrderProductMapBuilder');
}
