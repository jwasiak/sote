<?php

/**
 * Base static class for performing query and update operations on the 'st_order' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseOrderPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_order';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.Order';

	/** The total number of columns. */
	const NUM_COLUMNS = 37;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_order.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_order.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_order.ID';

	/** the column name for the ORDER_DELIVERY_ID field */
	const ORDER_DELIVERY_ID = 'st_order.ORDER_DELIVERY_ID';

	/** the column name for the SF_GUARD_USER_ID field */
	const SF_GUARD_USER_ID = 'st_order.SF_GUARD_USER_ID';

	/** the column name for the ORDER_USER_DATA_DELIVERY_ID field */
	const ORDER_USER_DATA_DELIVERY_ID = 'st_order.ORDER_USER_DATA_DELIVERY_ID';

	/** the column name for the ORDER_USER_DATA_BILLING_ID field */
	const ORDER_USER_DATA_BILLING_ID = 'st_order.ORDER_USER_DATA_BILLING_ID';

	/** the column name for the ORDER_CURRENCY_ID field */
	const ORDER_CURRENCY_ID = 'st_order.ORDER_CURRENCY_ID';

	/** the column name for the ORDER_STATUS_ID field */
	const ORDER_STATUS_ID = 'st_order.ORDER_STATUS_ID';

	/** the column name for the DISCOUNT_COUPON_CODE_ID field */
	const DISCOUNT_COUPON_CODE_ID = 'st_order.DISCOUNT_COUPON_CODE_ID';

	/** the column name for the DISCOUNT_ID field */
	const DISCOUNT_ID = 'st_order.DISCOUNT_ID';

	/** the column name for the ORDER_DISCOUNT field */
	const ORDER_DISCOUNT = 'st_order.ORDER_DISCOUNT';

	/** the column name for the HASH_CODE field */
	const HASH_CODE = 'st_order.HASH_CODE';

	/** the column name for the PAYMENT_SECURITY_HASH field */
	const PAYMENT_SECURITY_HASH = 'st_order.PAYMENT_SECURITY_HASH';

	/** the column name for the SESSION_HASH field */
	const SESSION_HASH = 'st_order.SESSION_HASH';

	/** the column name for the IS_CONFIRMED field */
	const IS_CONFIRMED = 'st_order.IS_CONFIRMED';

	/** the column name for the IS_MARKED_AS_READ field */
	const IS_MARKED_AS_READ = 'st_order.IS_MARKED_AS_READ';

	/** the column name for the NUMBER field */
	const NUMBER = 'st_order.NUMBER';

	/** the column name for the DESCRIPTION field */
	const DESCRIPTION = 'st_order.DESCRIPTION';

	/** the column name for the ORDER_TYPE field */
	const ORDER_TYPE = 'st_order.ORDER_TYPE';

	/** the column name for the MERCHANT_NOTES field */
	const MERCHANT_NOTES = 'st_order.MERCHANT_NOTES';

	/** the column name for the CLIENT_CULTURE field */
	const CLIENT_CULTURE = 'st_order.CLIENT_CULTURE';

	/** the column name for the HOST field */
	const HOST = 'st_order.HOST';

	/** the column name for the OPT_TOTAL_AMOUNT field */
	const OPT_TOTAL_AMOUNT = 'st_order.OPT_TOTAL_AMOUNT';

	/** the column name for the OPT_IS_PAYED field */
	const OPT_IS_PAYED = 'st_order.OPT_IS_PAYED';

	/** the column name for the OPT_CLIENT_NAME field */
	const OPT_CLIENT_NAME = 'st_order.OPT_CLIENT_NAME';

	/** the column name for the OPT_CLIENT_EMAIL field */
	const OPT_CLIENT_EMAIL = 'st_order.OPT_CLIENT_EMAIL';

	/** the column name for the OPT_CLIENT_COMPANY field */
	const OPT_CLIENT_COMPANY = 'st_order.OPT_CLIENT_COMPANY';

	/** the column name for the REMOTE_ADDRESS field */
	const REMOTE_ADDRESS = 'st_order.REMOTE_ADDRESS';

	/** the column name for the IS_CODES_SENT field */
	const IS_CODES_SENT = 'st_order.IS_CODES_SENT';

	/** the column name for the OPT_ALLEGRO_NICK field */
	const OPT_ALLEGRO_NICK = 'st_order.OPT_ALLEGRO_NICK';

	/** the column name for the OPT_ALLEGRO_CHECKOUT_FORM_ID field */
	const OPT_ALLEGRO_CHECKOUT_FORM_ID = 'st_order.OPT_ALLEGRO_CHECKOUT_FORM_ID';

	/** the column name for the SHOW_OPINION field */
	const SHOW_OPINION = 'st_order.SHOW_OPINION';

	/** the column name for the CHANGE_STOCK_ON field */
	const CHANGE_STOCK_ON = 'st_order.CHANGE_STOCK_ON';

	/** the column name for the PARTNER_ID field */
	const PARTNER_ID = 'st_order.PARTNER_ID';

	/** the column name for the PROVISION_VALUE field */
	const PROVISION_VALUE = 'st_order.PROVISION_VALUE';

	/** the column name for the PROVISION_PAYED field */
	const PROVISION_PAYED = 'st_order.PROVISION_PAYED';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'OrderDeliveryId', 'SfGuardUserId', 'OrderUserDataDeliveryId', 'OrderUserDataBillingId', 'OrderCurrencyId', 'OrderStatusId', 'DiscountCouponCodeId', 'DiscountId', 'OrderDiscount', 'HashCode', 'PaymentSecurityHash', 'SessionHash', 'IsConfirmed', 'IsMarkedAsRead', 'Number', 'Description', 'OrderType', 'MerchantNotes', 'ClientCulture', 'Host', 'OptTotalAmount', 'OptIsPayed', 'OptClientName', 'OptClientEmail', 'OptClientCompany', 'RemoteAddress', 'IsCodesSent', 'OptAllegroNick', 'OptAllegroCheckoutFormId', 'ShowOpinion', 'ChangeStockOn', 'PartnerId', 'ProvisionValue', 'ProvisionPayed', ),
		BasePeer::TYPE_COLNAME => array (OrderPeer::CREATED_AT, OrderPeer::UPDATED_AT, OrderPeer::ID, OrderPeer::ORDER_DELIVERY_ID, OrderPeer::SF_GUARD_USER_ID, OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderPeer::ORDER_CURRENCY_ID, OrderPeer::ORDER_STATUS_ID, OrderPeer::DISCOUNT_COUPON_CODE_ID, OrderPeer::DISCOUNT_ID, OrderPeer::ORDER_DISCOUNT, OrderPeer::HASH_CODE, OrderPeer::PAYMENT_SECURITY_HASH, OrderPeer::SESSION_HASH, OrderPeer::IS_CONFIRMED, OrderPeer::IS_MARKED_AS_READ, OrderPeer::NUMBER, OrderPeer::DESCRIPTION, OrderPeer::ORDER_TYPE, OrderPeer::MERCHANT_NOTES, OrderPeer::CLIENT_CULTURE, OrderPeer::HOST, OrderPeer::OPT_TOTAL_AMOUNT, OrderPeer::OPT_IS_PAYED, OrderPeer::OPT_CLIENT_NAME, OrderPeer::OPT_CLIENT_EMAIL, OrderPeer::OPT_CLIENT_COMPANY, OrderPeer::REMOTE_ADDRESS, OrderPeer::IS_CODES_SENT, OrderPeer::OPT_ALLEGRO_NICK, OrderPeer::OPT_ALLEGRO_CHECKOUT_FORM_ID, OrderPeer::SHOW_OPINION, OrderPeer::CHANGE_STOCK_ON, OrderPeer::PARTNER_ID, OrderPeer::PROVISION_VALUE, OrderPeer::PROVISION_PAYED, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'order_delivery_id', 'sf_guard_user_id', 'order_user_data_delivery_id', 'order_user_data_billing_id', 'order_currency_id', 'order_status_id', 'discount_coupon_code_id', 'discount_id', 'order_discount', 'hash_code', 'payment_security_hash', 'session_hash', 'is_confirmed', 'is_marked_as_read', 'number', 'description', 'order_type', 'merchant_notes', 'client_culture', 'host', 'opt_total_amount', 'opt_is_payed', 'opt_client_name', 'opt_client_email', 'opt_client_company', 'remote_address', 'is_codes_sent', 'opt_allegro_nick', 'opt_allegro_checkout_form_id', 'show_opinion', 'change_stock_on', 'partner_id', 'provision_value', 'provision_payed', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'OrderDeliveryId' => 3, 'SfGuardUserId' => 4, 'OrderUserDataDeliveryId' => 5, 'OrderUserDataBillingId' => 6, 'OrderCurrencyId' => 7, 'OrderStatusId' => 8, 'DiscountCouponCodeId' => 9, 'DiscountId' => 10, 'OrderDiscount' => 11, 'HashCode' => 12, 'PaymentSecurityHash' => 13, 'SessionHash' => 14, 'IsConfirmed' => 15, 'IsMarkedAsRead' => 16, 'Number' => 17, 'Description' => 18, 'OrderType' => 19, 'MerchantNotes' => 20, 'ClientCulture' => 21, 'Host' => 22, 'OptTotalAmount' => 23, 'OptIsPayed' => 24, 'OptClientName' => 25, 'OptClientEmail' => 26, 'OptClientCompany' => 27, 'RemoteAddress' => 28, 'IsCodesSent' => 29, 'OptAllegroNick' => 30, 'OptAllegroCheckoutFormId' => 31, 'ShowOpinion' => 32, 'ChangeStockOn' => 33, 'PartnerId' => 34, 'ProvisionValue' => 35, 'ProvisionPayed' => 36, ),
		BasePeer::TYPE_COLNAME => array (OrderPeer::CREATED_AT => 0, OrderPeer::UPDATED_AT => 1, OrderPeer::ID => 2, OrderPeer::ORDER_DELIVERY_ID => 3, OrderPeer::SF_GUARD_USER_ID => 4, OrderPeer::ORDER_USER_DATA_DELIVERY_ID => 5, OrderPeer::ORDER_USER_DATA_BILLING_ID => 6, OrderPeer::ORDER_CURRENCY_ID => 7, OrderPeer::ORDER_STATUS_ID => 8, OrderPeer::DISCOUNT_COUPON_CODE_ID => 9, OrderPeer::DISCOUNT_ID => 10, OrderPeer::ORDER_DISCOUNT => 11, OrderPeer::HASH_CODE => 12, OrderPeer::PAYMENT_SECURITY_HASH => 13, OrderPeer::SESSION_HASH => 14, OrderPeer::IS_CONFIRMED => 15, OrderPeer::IS_MARKED_AS_READ => 16, OrderPeer::NUMBER => 17, OrderPeer::DESCRIPTION => 18, OrderPeer::ORDER_TYPE => 19, OrderPeer::MERCHANT_NOTES => 20, OrderPeer::CLIENT_CULTURE => 21, OrderPeer::HOST => 22, OrderPeer::OPT_TOTAL_AMOUNT => 23, OrderPeer::OPT_IS_PAYED => 24, OrderPeer::OPT_CLIENT_NAME => 25, OrderPeer::OPT_CLIENT_EMAIL => 26, OrderPeer::OPT_CLIENT_COMPANY => 27, OrderPeer::REMOTE_ADDRESS => 28, OrderPeer::IS_CODES_SENT => 29, OrderPeer::OPT_ALLEGRO_NICK => 30, OrderPeer::OPT_ALLEGRO_CHECKOUT_FORM_ID => 31, OrderPeer::SHOW_OPINION => 32, OrderPeer::CHANGE_STOCK_ON => 33, OrderPeer::PARTNER_ID => 34, OrderPeer::PROVISION_VALUE => 35, OrderPeer::PROVISION_PAYED => 36, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'order_delivery_id' => 3, 'sf_guard_user_id' => 4, 'order_user_data_delivery_id' => 5, 'order_user_data_billing_id' => 6, 'order_currency_id' => 7, 'order_status_id' => 8, 'discount_coupon_code_id' => 9, 'discount_id' => 10, 'order_discount' => 11, 'hash_code' => 12, 'payment_security_hash' => 13, 'session_hash' => 14, 'is_confirmed' => 15, 'is_marked_as_read' => 16, 'number' => 17, 'description' => 18, 'order_type' => 19, 'merchant_notes' => 20, 'client_culture' => 21, 'host' => 22, 'opt_total_amount' => 23, 'opt_is_payed' => 24, 'opt_client_name' => 25, 'opt_client_email' => 26, 'opt_client_company' => 27, 'remote_address' => 28, 'is_codes_sent' => 29, 'opt_allegro_nick' => 30, 'opt_allegro_checkout_form_id' => 31, 'show_opinion' => 32, 'change_stock_on' => 33, 'partner_id' => 34, 'provision_value' => 35, 'provision_payed' => 36, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, )
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
		return BasePeer::getMapBuilder('lib.model.map.OrderMapBuilder');
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
			$map = OrderPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. OrderPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(OrderPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(OrderPeer::CREATED_AT);

		$criteria->addSelectColumn(OrderPeer::UPDATED_AT);

		$criteria->addSelectColumn(OrderPeer::ID);

		$criteria->addSelectColumn(OrderPeer::ORDER_DELIVERY_ID);

		$criteria->addSelectColumn(OrderPeer::SF_GUARD_USER_ID);

		$criteria->addSelectColumn(OrderPeer::ORDER_USER_DATA_DELIVERY_ID);

		$criteria->addSelectColumn(OrderPeer::ORDER_USER_DATA_BILLING_ID);

		$criteria->addSelectColumn(OrderPeer::ORDER_CURRENCY_ID);

		$criteria->addSelectColumn(OrderPeer::ORDER_STATUS_ID);

		$criteria->addSelectColumn(OrderPeer::DISCOUNT_COUPON_CODE_ID);

		$criteria->addSelectColumn(OrderPeer::DISCOUNT_ID);

		$criteria->addSelectColumn(OrderPeer::ORDER_DISCOUNT);

		$criteria->addSelectColumn(OrderPeer::HASH_CODE);

		$criteria->addSelectColumn(OrderPeer::PAYMENT_SECURITY_HASH);

		$criteria->addSelectColumn(OrderPeer::SESSION_HASH);

		$criteria->addSelectColumn(OrderPeer::IS_CONFIRMED);

		$criteria->addSelectColumn(OrderPeer::IS_MARKED_AS_READ);

		$criteria->addSelectColumn(OrderPeer::NUMBER);

		$criteria->addSelectColumn(OrderPeer::DESCRIPTION);

		$criteria->addSelectColumn(OrderPeer::ORDER_TYPE);

		$criteria->addSelectColumn(OrderPeer::MERCHANT_NOTES);

		$criteria->addSelectColumn(OrderPeer::CLIENT_CULTURE);

		$criteria->addSelectColumn(OrderPeer::HOST);

		$criteria->addSelectColumn(OrderPeer::OPT_TOTAL_AMOUNT);

		$criteria->addSelectColumn(OrderPeer::OPT_IS_PAYED);

		$criteria->addSelectColumn(OrderPeer::OPT_CLIENT_NAME);

		$criteria->addSelectColumn(OrderPeer::OPT_CLIENT_EMAIL);

		$criteria->addSelectColumn(OrderPeer::OPT_CLIENT_COMPANY);

		$criteria->addSelectColumn(OrderPeer::REMOTE_ADDRESS);

		$criteria->addSelectColumn(OrderPeer::IS_CODES_SENT);

		$criteria->addSelectColumn(OrderPeer::OPT_ALLEGRO_NICK);

		$criteria->addSelectColumn(OrderPeer::OPT_ALLEGRO_CHECKOUT_FORM_ID);

		$criteria->addSelectColumn(OrderPeer::SHOW_OPINION);

		$criteria->addSelectColumn(OrderPeer::CHANGE_STOCK_ON);

		$criteria->addSelectColumn(OrderPeer::PARTNER_ID);

		$criteria->addSelectColumn(OrderPeer::PROVISION_VALUE);

		$criteria->addSelectColumn(OrderPeer::PROVISION_PAYED);


		if (stEventDispatcher::getInstance()->getListeners('OrderPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'OrderPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_order.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_order.ID)';

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
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OrderPeer::doSelectRS($criteria, $con);
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
	 * @return     Order
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = OrderPeer::doSelect($critcopy, $con);
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
		return OrderPeer::populateObjects(OrderPeer::doSelectRS($criteria, $con));
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
			OrderPeer::addSelectColumns($criteria);
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
		$cls = OrderPeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related OrderDelivery table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinOrderDelivery(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related OrderUserDataDelivery table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinOrderUserDataDelivery(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related OrderUserDataBilling table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinOrderUserDataBilling(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related OrderCurrency table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinOrderCurrency(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related OrderStatus table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinOrderStatus(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related DiscountCouponCode table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinDiscountCouponCode(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Discount table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinDiscount(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Partner table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinPartner(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Order objects pre-filled with their OrderDelivery objects.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinOrderDelivery(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);

		OrderDeliveryPeer::addSelectColumns($c);

		$c->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);
		$rs = OrderPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Order();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getOrderDeliveryId())
                        {

			   $obj2 = new OrderDelivery();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrder($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with their sfGuardUser objects.
	 *
	 * @return     array Array of Order objects.
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

		OrderPeer::addSelectColumns($c);

		sfGuardUserPeer::addSelectColumns($c);

		$c->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);
		$rs = OrderPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Order();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getSfGuardUserId())
                        {

			   $obj2 = new sfGuardUser();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrder($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with their OrderUserDataDelivery objects.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinOrderUserDataDelivery(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);

		OrderUserDataDeliveryPeer::addSelectColumns($c);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);
		$rs = OrderPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Order();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getOrderUserDataDeliveryId())
                        {

			   $obj2 = new OrderUserDataDelivery();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrder($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with their OrderUserDataBilling objects.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinOrderUserDataBilling(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);

		OrderUserDataBillingPeer::addSelectColumns($c);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);
		$rs = OrderPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Order();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getOrderUserDataBillingId())
                        {

			   $obj2 = new OrderUserDataBilling();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrder($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with their OrderCurrency objects.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinOrderCurrency(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);

		OrderCurrencyPeer::addSelectColumns($c);

		$c->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);
		$rs = OrderPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Order();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getOrderCurrencyId())
                        {

			   $obj2 = new OrderCurrency();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrder($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with their OrderStatus objects.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinOrderStatus(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);

		OrderStatusPeer::addSelectColumns($c);

		$c->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);
		$rs = OrderPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Order();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getOrderStatusId())
                        {

			   $obj2 = new OrderStatus();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrder($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with their DiscountCouponCode objects.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinDiscountCouponCode(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);

		DiscountCouponCodePeer::addSelectColumns($c);

		$c->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);
		$rs = OrderPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Order();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getDiscountCouponCodeId())
                        {

			   $obj2 = new DiscountCouponCode();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrder($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with their Discount objects.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinDiscount(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);

		DiscountPeer::addSelectColumns($c);

		$c->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);
		$rs = OrderPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Order();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getDiscountId())
                        {

			   $obj2 = new Discount();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrder($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with their Partner objects.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinPartner(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);

		PartnerPeer::addSelectColumns($c);

		$c->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);
		$rs = OrderPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Order();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getPartnerId())
                        {

			   $obj2 = new Partner();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrder($obj1);
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
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$criteria->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$criteria->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Order objects pre-filled with all related objects.
	 *
	 * @return     array Array of Order objects.
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

		OrderPeer::addSelectColumns($c);
		$startcol2 = (OrderPeer::NUM_COLUMNS - OrderPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderDeliveryPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderDeliveryPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardUserPeer::NUM_COLUMNS;

		OrderUserDataDeliveryPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + OrderUserDataDeliveryPeer::NUM_COLUMNS;

		OrderUserDataBillingPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + OrderUserDataBillingPeer::NUM_COLUMNS;

		OrderCurrencyPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + OrderCurrencyPeer::NUM_COLUMNS;

		OrderStatusPeer::addSelectColumns($c);
		$startcol8 = $startcol7 + OrderStatusPeer::NUM_COLUMNS;

		DiscountCouponCodePeer::addSelectColumns($c);
		$startcol9 = $startcol8 + DiscountCouponCodePeer::NUM_COLUMNS;

		DiscountPeer::addSelectColumns($c);
		$startcol10 = $startcol9 + DiscountPeer::NUM_COLUMNS;

		PartnerPeer::addSelectColumns($c);
		$startcol11 = $startcol10 + PartnerPeer::NUM_COLUMNS;

		$c->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$c->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$c->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined OrderDelivery rows
	
			$omClass = OrderDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrderDelivery(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOrder($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrders();
				$obj2->addOrder($obj1);
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
					$temp_obj3->addOrder($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initOrders();
				$obj3->addOrder($obj1);
			}


				// Add objects for joined OrderUserDataDelivery rows
	
			$omClass = OrderUserDataDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getOrderUserDataDelivery(); // CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addOrder($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj4->initOrders();
				$obj4->addOrder($obj1);
			}


				// Add objects for joined OrderUserDataBilling rows
	
			$omClass = OrderUserDataBillingPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5 = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getOrderUserDataBilling(); // CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addOrder($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj5->initOrders();
				$obj5->addOrder($obj1);
			}


				// Add objects for joined OrderCurrency rows
	
			$omClass = OrderCurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6 = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getOrderCurrency(); // CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addOrder($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj6->initOrders();
				$obj6->addOrder($obj1);
			}


				// Add objects for joined OrderStatus rows
	
			$omClass = OrderStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7 = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getOrderStatus(); // CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addOrder($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj7->initOrders();
				$obj7->addOrder($obj1);
			}


				// Add objects for joined DiscountCouponCode rows
	
			$omClass = DiscountCouponCodePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8 = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getDiscountCouponCode(); // CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addOrder($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj8->initOrders();
				$obj8->addOrder($obj1);
			}


				// Add objects for joined Discount rows
	
			$omClass = DiscountPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj9 = new $cls();
			$obj9->hydrate($rs, $startcol9);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj9 = $temp_obj1->getDiscount(); // CHECKME
				if ($temp_obj9->getPrimaryKey() === $obj9->getPrimaryKey()) {
					$newObject = false;
					$temp_obj9->addOrder($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj9->initOrders();
				$obj9->addOrder($obj1);
			}


				// Add objects for joined Partner rows
	
			$omClass = PartnerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj10 = new $cls();
			$obj10->hydrate($rs, $startcol10);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj10 = $temp_obj1->getPartner(); // CHECKME
				if ($temp_obj10->getPrimaryKey() === $obj10->getPrimaryKey()) {
					$newObject = false;
					$temp_obj10->addOrder($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj10->initOrders();
				$obj10->addOrder($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related OrderDelivery table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptOrderDelivery(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$criteria->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$criteria->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$criteria->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$criteria->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related OrderUserDataDelivery table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptOrderUserDataDelivery(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$criteria->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$criteria->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related OrderUserDataBilling table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptOrderUserDataBilling(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$criteria->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$criteria->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related OrderCurrency table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptOrderCurrency(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$criteria->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related OrderStatus table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptOrderStatus(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$criteria->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related DiscountCouponCode table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptDiscountCouponCode(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$criteria->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$criteria->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Discount table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptDiscount(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$criteria->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$criteria->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Partner table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptPartner(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$criteria->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$criteria->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Order objects pre-filled with all related objects except OrderDelivery.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptOrderDelivery(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);
		$startcol2 = (OrderPeer::NUM_COLUMNS - OrderPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		OrderUserDataDeliveryPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OrderUserDataDeliveryPeer::NUM_COLUMNS;

		OrderUserDataBillingPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + OrderUserDataBillingPeer::NUM_COLUMNS;

		OrderCurrencyPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + OrderCurrencyPeer::NUM_COLUMNS;

		OrderStatusPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + OrderStatusPeer::NUM_COLUMNS;

		DiscountCouponCodePeer::addSelectColumns($c);
		$startcol8 = $startcol7 + DiscountCouponCodePeer::NUM_COLUMNS;

		DiscountPeer::addSelectColumns($c);
		$startcol9 = $startcol8 + DiscountPeer::NUM_COLUMNS;

		PartnerPeer::addSelectColumns($c);
		$startcol10 = $startcol9 + PartnerPeer::NUM_COLUMNS;

		$c->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$c->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$c->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderPeer::getOMClass();

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
					$temp_obj2->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrders();
				$obj2->addOrder($obj1);
			}

			$omClass = OrderUserDataDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOrderUserDataDelivery(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initOrders();
				$obj3->addOrder($obj1);
			}

			$omClass = OrderUserDataBillingPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getOrderUserDataBilling(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initOrders();
				$obj4->addOrder($obj1);
			}

			$omClass = OrderCurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getOrderCurrency(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initOrders();
				$obj5->addOrder($obj1);
			}

			$omClass = OrderStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getOrderStatus(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initOrders();
				$obj6->addOrder($obj1);
			}

			$omClass = DiscountCouponCodePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getDiscountCouponCode(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initOrders();
				$obj7->addOrder($obj1);
			}

			$omClass = DiscountPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getDiscount(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initOrders();
				$obj8->addOrder($obj1);
			}

			$omClass = PartnerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj9  = new $cls();
			$obj9->hydrate($rs, $startcol9);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj9 = $temp_obj1->getPartner(); //CHECKME
				if ($temp_obj9->getPrimaryKey() === $obj9->getPrimaryKey()) {
					$newObject = false;
					$temp_obj9->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj9->initOrders();
				$obj9->addOrder($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with all related objects except sfGuardUser.
	 *
	 * @return     array Array of Order objects.
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

		OrderPeer::addSelectColumns($c);
		$startcol2 = (OrderPeer::NUM_COLUMNS - OrderPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderDeliveryPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderDeliveryPeer::NUM_COLUMNS;

		OrderUserDataDeliveryPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OrderUserDataDeliveryPeer::NUM_COLUMNS;

		OrderUserDataBillingPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + OrderUserDataBillingPeer::NUM_COLUMNS;

		OrderCurrencyPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + OrderCurrencyPeer::NUM_COLUMNS;

		OrderStatusPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + OrderStatusPeer::NUM_COLUMNS;

		DiscountCouponCodePeer::addSelectColumns($c);
		$startcol8 = $startcol7 + DiscountCouponCodePeer::NUM_COLUMNS;

		DiscountPeer::addSelectColumns($c);
		$startcol9 = $startcol8 + DiscountPeer::NUM_COLUMNS;

		PartnerPeer::addSelectColumns($c);
		$startcol10 = $startcol9 + PartnerPeer::NUM_COLUMNS;

		$c->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$c->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$c->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OrderDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrderDelivery(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrders();
				$obj2->addOrder($obj1);
			}

			$omClass = OrderUserDataDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOrderUserDataDelivery(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initOrders();
				$obj3->addOrder($obj1);
			}

			$omClass = OrderUserDataBillingPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getOrderUserDataBilling(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initOrders();
				$obj4->addOrder($obj1);
			}

			$omClass = OrderCurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getOrderCurrency(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initOrders();
				$obj5->addOrder($obj1);
			}

			$omClass = OrderStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getOrderStatus(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initOrders();
				$obj6->addOrder($obj1);
			}

			$omClass = DiscountCouponCodePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getDiscountCouponCode(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initOrders();
				$obj7->addOrder($obj1);
			}

			$omClass = DiscountPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getDiscount(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initOrders();
				$obj8->addOrder($obj1);
			}

			$omClass = PartnerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj9  = new $cls();
			$obj9->hydrate($rs, $startcol9);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj9 = $temp_obj1->getPartner(); //CHECKME
				if ($temp_obj9->getPrimaryKey() === $obj9->getPrimaryKey()) {
					$newObject = false;
					$temp_obj9->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj9->initOrders();
				$obj9->addOrder($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with all related objects except OrderUserDataDelivery.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptOrderUserDataDelivery(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);
		$startcol2 = (OrderPeer::NUM_COLUMNS - OrderPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderDeliveryPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderDeliveryPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardUserPeer::NUM_COLUMNS;

		OrderUserDataBillingPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + OrderUserDataBillingPeer::NUM_COLUMNS;

		OrderCurrencyPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + OrderCurrencyPeer::NUM_COLUMNS;

		OrderStatusPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + OrderStatusPeer::NUM_COLUMNS;

		DiscountCouponCodePeer::addSelectColumns($c);
		$startcol8 = $startcol7 + DiscountCouponCodePeer::NUM_COLUMNS;

		DiscountPeer::addSelectColumns($c);
		$startcol9 = $startcol8 + DiscountPeer::NUM_COLUMNS;

		PartnerPeer::addSelectColumns($c);
		$startcol10 = $startcol9 + PartnerPeer::NUM_COLUMNS;

		$c->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$c->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$c->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OrderDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrderDelivery(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrders();
				$obj2->addOrder($obj1);
			}

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfGuardUser(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initOrders();
				$obj3->addOrder($obj1);
			}

			$omClass = OrderUserDataBillingPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getOrderUserDataBilling(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initOrders();
				$obj4->addOrder($obj1);
			}

			$omClass = OrderCurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getOrderCurrency(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initOrders();
				$obj5->addOrder($obj1);
			}

			$omClass = OrderStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getOrderStatus(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initOrders();
				$obj6->addOrder($obj1);
			}

			$omClass = DiscountCouponCodePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getDiscountCouponCode(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initOrders();
				$obj7->addOrder($obj1);
			}

			$omClass = DiscountPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getDiscount(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initOrders();
				$obj8->addOrder($obj1);
			}

			$omClass = PartnerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj9  = new $cls();
			$obj9->hydrate($rs, $startcol9);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj9 = $temp_obj1->getPartner(); //CHECKME
				if ($temp_obj9->getPrimaryKey() === $obj9->getPrimaryKey()) {
					$newObject = false;
					$temp_obj9->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj9->initOrders();
				$obj9->addOrder($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with all related objects except OrderUserDataBilling.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptOrderUserDataBilling(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);
		$startcol2 = (OrderPeer::NUM_COLUMNS - OrderPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderDeliveryPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderDeliveryPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardUserPeer::NUM_COLUMNS;

		OrderUserDataDeliveryPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + OrderUserDataDeliveryPeer::NUM_COLUMNS;

		OrderCurrencyPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + OrderCurrencyPeer::NUM_COLUMNS;

		OrderStatusPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + OrderStatusPeer::NUM_COLUMNS;

		DiscountCouponCodePeer::addSelectColumns($c);
		$startcol8 = $startcol7 + DiscountCouponCodePeer::NUM_COLUMNS;

		DiscountPeer::addSelectColumns($c);
		$startcol9 = $startcol8 + DiscountPeer::NUM_COLUMNS;

		PartnerPeer::addSelectColumns($c);
		$startcol10 = $startcol9 + PartnerPeer::NUM_COLUMNS;

		$c->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$c->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$c->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OrderDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrderDelivery(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrders();
				$obj2->addOrder($obj1);
			}

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfGuardUser(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initOrders();
				$obj3->addOrder($obj1);
			}

			$omClass = OrderUserDataDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getOrderUserDataDelivery(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initOrders();
				$obj4->addOrder($obj1);
			}

			$omClass = OrderCurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getOrderCurrency(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initOrders();
				$obj5->addOrder($obj1);
			}

			$omClass = OrderStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getOrderStatus(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initOrders();
				$obj6->addOrder($obj1);
			}

			$omClass = DiscountCouponCodePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getDiscountCouponCode(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initOrders();
				$obj7->addOrder($obj1);
			}

			$omClass = DiscountPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getDiscount(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initOrders();
				$obj8->addOrder($obj1);
			}

			$omClass = PartnerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj9  = new $cls();
			$obj9->hydrate($rs, $startcol9);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj9 = $temp_obj1->getPartner(); //CHECKME
				if ($temp_obj9->getPrimaryKey() === $obj9->getPrimaryKey()) {
					$newObject = false;
					$temp_obj9->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj9->initOrders();
				$obj9->addOrder($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with all related objects except OrderCurrency.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptOrderCurrency(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);
		$startcol2 = (OrderPeer::NUM_COLUMNS - OrderPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderDeliveryPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderDeliveryPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardUserPeer::NUM_COLUMNS;

		OrderUserDataDeliveryPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + OrderUserDataDeliveryPeer::NUM_COLUMNS;

		OrderUserDataBillingPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + OrderUserDataBillingPeer::NUM_COLUMNS;

		OrderStatusPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + OrderStatusPeer::NUM_COLUMNS;

		DiscountCouponCodePeer::addSelectColumns($c);
		$startcol8 = $startcol7 + DiscountCouponCodePeer::NUM_COLUMNS;

		DiscountPeer::addSelectColumns($c);
		$startcol9 = $startcol8 + DiscountPeer::NUM_COLUMNS;

		PartnerPeer::addSelectColumns($c);
		$startcol10 = $startcol9 + PartnerPeer::NUM_COLUMNS;

		$c->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$c->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OrderDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrderDelivery(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrders();
				$obj2->addOrder($obj1);
			}

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfGuardUser(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initOrders();
				$obj3->addOrder($obj1);
			}

			$omClass = OrderUserDataDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getOrderUserDataDelivery(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initOrders();
				$obj4->addOrder($obj1);
			}

			$omClass = OrderUserDataBillingPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getOrderUserDataBilling(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initOrders();
				$obj5->addOrder($obj1);
			}

			$omClass = OrderStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getOrderStatus(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initOrders();
				$obj6->addOrder($obj1);
			}

			$omClass = DiscountCouponCodePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getDiscountCouponCode(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initOrders();
				$obj7->addOrder($obj1);
			}

			$omClass = DiscountPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getDiscount(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initOrders();
				$obj8->addOrder($obj1);
			}

			$omClass = PartnerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj9  = new $cls();
			$obj9->hydrate($rs, $startcol9);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj9 = $temp_obj1->getPartner(); //CHECKME
				if ($temp_obj9->getPrimaryKey() === $obj9->getPrimaryKey()) {
					$newObject = false;
					$temp_obj9->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj9->initOrders();
				$obj9->addOrder($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with all related objects except OrderStatus.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptOrderStatus(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);
		$startcol2 = (OrderPeer::NUM_COLUMNS - OrderPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderDeliveryPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderDeliveryPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardUserPeer::NUM_COLUMNS;

		OrderUserDataDeliveryPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + OrderUserDataDeliveryPeer::NUM_COLUMNS;

		OrderUserDataBillingPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + OrderUserDataBillingPeer::NUM_COLUMNS;

		OrderCurrencyPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + OrderCurrencyPeer::NUM_COLUMNS;

		DiscountCouponCodePeer::addSelectColumns($c);
		$startcol8 = $startcol7 + DiscountCouponCodePeer::NUM_COLUMNS;

		DiscountPeer::addSelectColumns($c);
		$startcol9 = $startcol8 + DiscountPeer::NUM_COLUMNS;

		PartnerPeer::addSelectColumns($c);
		$startcol10 = $startcol9 + PartnerPeer::NUM_COLUMNS;

		$c->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$c->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OrderDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrderDelivery(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrders();
				$obj2->addOrder($obj1);
			}

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfGuardUser(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initOrders();
				$obj3->addOrder($obj1);
			}

			$omClass = OrderUserDataDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getOrderUserDataDelivery(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initOrders();
				$obj4->addOrder($obj1);
			}

			$omClass = OrderUserDataBillingPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getOrderUserDataBilling(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initOrders();
				$obj5->addOrder($obj1);
			}

			$omClass = OrderCurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getOrderCurrency(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initOrders();
				$obj6->addOrder($obj1);
			}

			$omClass = DiscountCouponCodePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getDiscountCouponCode(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initOrders();
				$obj7->addOrder($obj1);
			}

			$omClass = DiscountPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getDiscount(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initOrders();
				$obj8->addOrder($obj1);
			}

			$omClass = PartnerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj9  = new $cls();
			$obj9->hydrate($rs, $startcol9);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj9 = $temp_obj1->getPartner(); //CHECKME
				if ($temp_obj9->getPrimaryKey() === $obj9->getPrimaryKey()) {
					$newObject = false;
					$temp_obj9->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj9->initOrders();
				$obj9->addOrder($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with all related objects except DiscountCouponCode.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptDiscountCouponCode(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);
		$startcol2 = (OrderPeer::NUM_COLUMNS - OrderPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderDeliveryPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderDeliveryPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardUserPeer::NUM_COLUMNS;

		OrderUserDataDeliveryPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + OrderUserDataDeliveryPeer::NUM_COLUMNS;

		OrderUserDataBillingPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + OrderUserDataBillingPeer::NUM_COLUMNS;

		OrderCurrencyPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + OrderCurrencyPeer::NUM_COLUMNS;

		OrderStatusPeer::addSelectColumns($c);
		$startcol8 = $startcol7 + OrderStatusPeer::NUM_COLUMNS;

		DiscountPeer::addSelectColumns($c);
		$startcol9 = $startcol8 + DiscountPeer::NUM_COLUMNS;

		PartnerPeer::addSelectColumns($c);
		$startcol10 = $startcol9 + PartnerPeer::NUM_COLUMNS;

		$c->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$c->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$c->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OrderDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrderDelivery(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrders();
				$obj2->addOrder($obj1);
			}

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfGuardUser(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initOrders();
				$obj3->addOrder($obj1);
			}

			$omClass = OrderUserDataDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getOrderUserDataDelivery(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initOrders();
				$obj4->addOrder($obj1);
			}

			$omClass = OrderUserDataBillingPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getOrderUserDataBilling(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initOrders();
				$obj5->addOrder($obj1);
			}

			$omClass = OrderCurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getOrderCurrency(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initOrders();
				$obj6->addOrder($obj1);
			}

			$omClass = OrderStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getOrderStatus(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initOrders();
				$obj7->addOrder($obj1);
			}

			$omClass = DiscountPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getDiscount(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initOrders();
				$obj8->addOrder($obj1);
			}

			$omClass = PartnerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj9  = new $cls();
			$obj9->hydrate($rs, $startcol9);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj9 = $temp_obj1->getPartner(); //CHECKME
				if ($temp_obj9->getPrimaryKey() === $obj9->getPrimaryKey()) {
					$newObject = false;
					$temp_obj9->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj9->initOrders();
				$obj9->addOrder($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with all related objects except Discount.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptDiscount(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);
		$startcol2 = (OrderPeer::NUM_COLUMNS - OrderPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderDeliveryPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderDeliveryPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardUserPeer::NUM_COLUMNS;

		OrderUserDataDeliveryPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + OrderUserDataDeliveryPeer::NUM_COLUMNS;

		OrderUserDataBillingPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + OrderUserDataBillingPeer::NUM_COLUMNS;

		OrderCurrencyPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + OrderCurrencyPeer::NUM_COLUMNS;

		OrderStatusPeer::addSelectColumns($c);
		$startcol8 = $startcol7 + OrderStatusPeer::NUM_COLUMNS;

		DiscountCouponCodePeer::addSelectColumns($c);
		$startcol9 = $startcol8 + DiscountCouponCodePeer::NUM_COLUMNS;

		PartnerPeer::addSelectColumns($c);
		$startcol10 = $startcol9 + PartnerPeer::NUM_COLUMNS;

		$c->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$c->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$c->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::PARTNER_ID, PartnerPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OrderDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrderDelivery(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrders();
				$obj2->addOrder($obj1);
			}

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfGuardUser(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initOrders();
				$obj3->addOrder($obj1);
			}

			$omClass = OrderUserDataDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getOrderUserDataDelivery(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initOrders();
				$obj4->addOrder($obj1);
			}

			$omClass = OrderUserDataBillingPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getOrderUserDataBilling(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initOrders();
				$obj5->addOrder($obj1);
			}

			$omClass = OrderCurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getOrderCurrency(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initOrders();
				$obj6->addOrder($obj1);
			}

			$omClass = OrderStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getOrderStatus(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initOrders();
				$obj7->addOrder($obj1);
			}

			$omClass = DiscountCouponCodePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getDiscountCouponCode(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initOrders();
				$obj8->addOrder($obj1);
			}

			$omClass = PartnerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj9  = new $cls();
			$obj9->hydrate($rs, $startcol9);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj9 = $temp_obj1->getPartner(); //CHECKME
				if ($temp_obj9->getPrimaryKey() === $obj9->getPrimaryKey()) {
					$newObject = false;
					$temp_obj9->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj9->initOrders();
				$obj9->addOrder($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Order objects pre-filled with all related objects except Partner.
	 *
	 * @return     array Array of Order objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptPartner(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderPeer::addSelectColumns($c);
		$startcol2 = (OrderPeer::NUM_COLUMNS - OrderPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderDeliveryPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderDeliveryPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardUserPeer::NUM_COLUMNS;

		OrderUserDataDeliveryPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + OrderUserDataDeliveryPeer::NUM_COLUMNS;

		OrderUserDataBillingPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + OrderUserDataBillingPeer::NUM_COLUMNS;

		OrderCurrencyPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + OrderCurrencyPeer::NUM_COLUMNS;

		OrderStatusPeer::addSelectColumns($c);
		$startcol8 = $startcol7 + OrderStatusPeer::NUM_COLUMNS;

		DiscountCouponCodePeer::addSelectColumns($c);
		$startcol9 = $startcol8 + DiscountCouponCodePeer::NUM_COLUMNS;

		DiscountPeer::addSelectColumns($c);
		$startcol10 = $startcol9 + DiscountPeer::NUM_COLUMNS;

		$c->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, OrderUserDataDeliveryPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_USER_DATA_BILLING_ID, OrderUserDataBillingPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

		$c->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);

		$c->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(OrderPeer::DISCOUNT_ID, DiscountPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OrderDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrderDelivery(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrders();
				$obj2->addOrder($obj1);
			}

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfGuardUser(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initOrders();
				$obj3->addOrder($obj1);
			}

			$omClass = OrderUserDataDeliveryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getOrderUserDataDelivery(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initOrders();
				$obj4->addOrder($obj1);
			}

			$omClass = OrderUserDataBillingPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getOrderUserDataBilling(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initOrders();
				$obj5->addOrder($obj1);
			}

			$omClass = OrderCurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getOrderCurrency(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initOrders();
				$obj6->addOrder($obj1);
			}

			$omClass = OrderStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getOrderStatus(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initOrders();
				$obj7->addOrder($obj1);
			}

			$omClass = DiscountCouponCodePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getDiscountCouponCode(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initOrders();
				$obj8->addOrder($obj1);
			}

			$omClass = DiscountPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj9  = new $cls();
			$obj9->hydrate($rs, $startcol9);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj9 = $temp_obj1->getDiscount(); //CHECKME
				if ($temp_obj9->getPrimaryKey() === $obj9->getPrimaryKey()) {
					$newObject = false;
					$temp_obj9->addOrder($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj9->initOrders();
				$obj9->addOrder($obj1);
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
		return OrderPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a Order or Criteria object.
	 *
	 * @param      mixed $values Criteria or Order object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseOrderPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseOrderPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from Order object
		}

		$criteria->remove(OrderPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseOrderPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseOrderPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a Order or Criteria object.
	 *
	 * @param      mixed $values Criteria or Order object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseOrderPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseOrderPeer', $values, $con);
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

			$comparison = $criteria->getComparison(OrderPeer::ID);
			$selectCriteria->add(OrderPeer::ID, $criteria->remove(OrderPeer::ID), $comparison);

		} else { // $values is Order object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseOrderPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseOrderPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_order table.
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
			$affectedRows += OrderPeer::doOnDeleteCascade(new Criteria(), $con);
			OrderPeer::doOnDeleteSetNull(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(OrderPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a Order or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or Order object or primary key or array of primary keys
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
			$con = Propel::getConnection(OrderPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof Order) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(OrderPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += OrderPeer::doOnDeleteCascade($criteria, $con);OrderPeer::doOnDeleteSetNull($criteria, $con);
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
		$objects = OrderPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related UserPoints objects
			$c = new Criteria();
			
			$c->add(UserPointsPeer::ORDER_ID, $obj->getId());
			$affectedRows += UserPointsPeer::doDelete($c, $con);

			// delete related AllegroAuctionHasOrder objects
			$c = new Criteria();
			
			$c->add(AllegroAuctionHasOrderPeer::ORDER_ID, $obj->getId());
			$affectedRows += AllegroAuctionHasOrderPeer::doDelete($c, $con);

			// delete related OrderHasPayment objects
			$c = new Criteria();
			
			$c->add(OrderHasPaymentPeer::ORDER_ID, $obj->getId());
			$affectedRows += OrderHasPaymentPeer::doDelete($c, $con);

			// delete related DiscountCouponCode objects
			$c = new Criteria();
			
			$c->add(DiscountCouponCodePeer::ORDER_ID, $obj->getId());
			$affectedRows += DiscountCouponCodePeer::doDelete($c, $con);

			// delete related PaybynetHasOrder objects
			$c = new Criteria();
			
			$c->add(PaybynetHasOrderPeer::ORDER_ID, $obj->getId());
			$affectedRows += PaybynetHasOrderPeer::doDelete($c, $con);

			// delete related PocztaPolskaPunktOdbioru objects
			$c = new Criteria();
			
			$c->add(PocztaPolskaPunktOdbioruPeer::ORDER_ID, $obj->getId());
			$affectedRows += PocztaPolskaPunktOdbioruPeer::doDelete($c, $con);

			// delete related PocztaPolskaPaczka objects
			$c = new Criteria();
			
			$c->add(PocztaPolskaPaczkaPeer::ORDER_ID, $obj->getId());
			$affectedRows += PocztaPolskaPaczkaPeer::doDelete($c, $con);

			// delete related OrderProduct objects
			$c = new Criteria();
			
			$c->add(OrderProductPeer::ORDER_ID, $obj->getId());
			$affectedRows += OrderProductPeer::doDelete($c, $con);

			// delete related Review objects
			$c = new Criteria();
			
			$c->add(ReviewPeer::ORDER_ID, $obj->getId());
			$affectedRows += ReviewPeer::doDelete($c, $con);

			// delete related ReviewOrder objects
			$c = new Criteria();
			
			$c->add(ReviewOrderPeer::ORDER_ID, $obj->getId());
			$affectedRows += ReviewOrderPeer::doDelete($c, $con);
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
		$objects = OrderPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {

			// set fkey col in related PaczkomatyPack rows to NULL
			$selectCriteria = new Criteria(OrderPeer::DATABASE_NAME);
			$updateValues = new Criteria(OrderPeer::DATABASE_NAME);
			$selectCriteria->add(PaczkomatyPackPeer::ORDER_ID, $obj->getId());
			$updateValues->add(PaczkomatyPackPeer::ORDER_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Invoice rows to NULL
			$selectCriteria = new Criteria(OrderPeer::DATABASE_NAME);
			$updateValues = new Criteria(OrderPeer::DATABASE_NAME);
			$selectCriteria->add(InvoicePeer::ORDER_ID, $obj->getId());
			$updateValues->add(InvoicePeer::ORDER_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

		}
	}

	/**
	 * Validates all modified columns of given Order object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      Order $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(Order $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OrderPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OrderPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OrderPeer::DATABASE_NAME, OrderPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OrderPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     Order
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(OrderPeer::DATABASE_NAME);

		$criteria->add(OrderPeer::ID, $pk);


		$v = OrderPeer::doSelect($criteria, $con);

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
			$criteria->add(OrderPeer::ID, $pks, Criteria::IN);
			$objs = OrderPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseOrderPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseOrderPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('lib.model.map.OrderMapBuilder');
}
