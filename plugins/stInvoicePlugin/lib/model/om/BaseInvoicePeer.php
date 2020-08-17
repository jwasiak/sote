<?php

/**
 * Base static class for performing query and update operations on the 'st_invoice' table.
 *
 * 
 *
 * @package    plugins.stInvoicePlugin.lib.model.om
 */
abstract class BaseInvoicePeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_invoice';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stInvoicePlugin.lib.model.Invoice';

	/** The total number of columns. */
	const NUM_COLUMNS = 24;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_invoice.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_invoice.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_invoice.ID';

	/** the column name for the INVOICE_USER_SELLER_ID field */
	const INVOICE_USER_SELLER_ID = 'st_invoice.INVOICE_USER_SELLER_ID';

	/** the column name for the INVOICE_USER_CUSTOMER_ID field */
	const INVOICE_USER_CUSTOMER_ID = 'st_invoice.INVOICE_USER_CUSTOMER_ID';

	/** the column name for the ORDER_ID field */
	const ORDER_ID = 'st_invoice.ORDER_ID';

	/** the column name for the INVOICE_CURRENCY_ID field */
	const INVOICE_CURRENCY_ID = 'st_invoice.INVOICE_CURRENCY_ID';

	/** the column name for the INVOICE_PROFORMA_ID field */
	const INVOICE_PROFORMA_ID = 'st_invoice.INVOICE_PROFORMA_ID';

	/** the column name for the COMPANY_DESCRIPTION field */
	const COMPANY_DESCRIPTION = 'st_invoice.COMPANY_DESCRIPTION';

	/** the column name for the INVOICE_DESCRIPTION field */
	const INVOICE_DESCRIPTION = 'st_invoice.INVOICE_DESCRIPTION';

	/** the column name for the ORDER_DISCOUNT field */
	const ORDER_DISCOUNT = 'st_invoice.ORDER_DISCOUNT';

	/** the column name for the DATE_SELLE field */
	const DATE_SELLE = 'st_invoice.DATE_SELLE';

	/** the column name for the DATE_CREATE_COPY field */
	const DATE_CREATE_COPY = 'st_invoice.DATE_CREATE_COPY';

	/** the column name for the NUMBER field */
	const NUMBER = 'st_invoice.NUMBER';

	/** the column name for the SIGNATURE_SELLER field */
	const SIGNATURE_SELLER = 'st_invoice.SIGNATURE_SELLER';

	/** the column name for the SIGNATURE_CUSTOMER field */
	const SIGNATURE_CUSTOMER = 'st_invoice.SIGNATURE_CUSTOMER';

	/** the column name for the OPT_TOTAL_AMMOUNT_BRUTTO field */
	const OPT_TOTAL_AMMOUNT_BRUTTO = 'st_invoice.OPT_TOTAL_AMMOUNT_BRUTTO';

	/** the column name for the TOWN field */
	const TOWN = 'st_invoice.TOWN';

	/** the column name for the CURENCY field */
	const CURENCY = 'st_invoice.CURENCY';

	/** the column name for the MAX_DAY field */
	const MAX_DAY = 'st_invoice.MAX_DAY';

	/** the column name for the PAYMENT_TYPE field */
	const PAYMENT_TYPE = 'st_invoice.PAYMENT_TYPE';

	/** the column name for the IS_PROFORMA field */
	const IS_PROFORMA = 'st_invoice.IS_PROFORMA';

	/** the column name for the IS_REQUEST field */
	const IS_REQUEST = 'st_invoice.IS_REQUEST';

	/** the column name for the IS_CONFIRM field */
	const IS_CONFIRM = 'st_invoice.IS_CONFIRM';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'InvoiceUserSellerId', 'InvoiceUserCustomerId', 'OrderId', 'InvoiceCurrencyId', 'InvoiceProformaId', 'CompanyDescription', 'InvoiceDescription', 'OrderDiscount', 'DateSelle', 'DateCreateCopy', 'Number', 'SignatureSeller', 'SignatureCustomer', 'OptTotalAmmountBrutto', 'Town', 'Curency', 'MaxDay', 'PaymentType', 'IsProforma', 'IsRequest', 'IsConfirm', ),
		BasePeer::TYPE_COLNAME => array (InvoicePeer::CREATED_AT, InvoicePeer::UPDATED_AT, InvoicePeer::ID, InvoicePeer::INVOICE_USER_SELLER_ID, InvoicePeer::INVOICE_USER_CUSTOMER_ID, InvoicePeer::ORDER_ID, InvoicePeer::INVOICE_CURRENCY_ID, InvoicePeer::INVOICE_PROFORMA_ID, InvoicePeer::COMPANY_DESCRIPTION, InvoicePeer::INVOICE_DESCRIPTION, InvoicePeer::ORDER_DISCOUNT, InvoicePeer::DATE_SELLE, InvoicePeer::DATE_CREATE_COPY, InvoicePeer::NUMBER, InvoicePeer::SIGNATURE_SELLER, InvoicePeer::SIGNATURE_CUSTOMER, InvoicePeer::OPT_TOTAL_AMMOUNT_BRUTTO, InvoicePeer::TOWN, InvoicePeer::CURENCY, InvoicePeer::MAX_DAY, InvoicePeer::PAYMENT_TYPE, InvoicePeer::IS_PROFORMA, InvoicePeer::IS_REQUEST, InvoicePeer::IS_CONFIRM, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'invoice_user_seller_id', 'invoice_user_customer_id', 'order_id', 'invoice_currency_id', 'invoice_proforma_id', 'company_description', 'invoice_description', 'order_discount', 'date_selle', 'date_create_copy', 'number', 'signature_seller', 'signature_customer', 'opt_total_ammount_brutto', 'town', 'curency', 'max_day', 'payment_type', 'is_proforma', 'is_request', 'is_confirm', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'InvoiceUserSellerId' => 3, 'InvoiceUserCustomerId' => 4, 'OrderId' => 5, 'InvoiceCurrencyId' => 6, 'InvoiceProformaId' => 7, 'CompanyDescription' => 8, 'InvoiceDescription' => 9, 'OrderDiscount' => 10, 'DateSelle' => 11, 'DateCreateCopy' => 12, 'Number' => 13, 'SignatureSeller' => 14, 'SignatureCustomer' => 15, 'OptTotalAmmountBrutto' => 16, 'Town' => 17, 'Curency' => 18, 'MaxDay' => 19, 'PaymentType' => 20, 'IsProforma' => 21, 'IsRequest' => 22, 'IsConfirm' => 23, ),
		BasePeer::TYPE_COLNAME => array (InvoicePeer::CREATED_AT => 0, InvoicePeer::UPDATED_AT => 1, InvoicePeer::ID => 2, InvoicePeer::INVOICE_USER_SELLER_ID => 3, InvoicePeer::INVOICE_USER_CUSTOMER_ID => 4, InvoicePeer::ORDER_ID => 5, InvoicePeer::INVOICE_CURRENCY_ID => 6, InvoicePeer::INVOICE_PROFORMA_ID => 7, InvoicePeer::COMPANY_DESCRIPTION => 8, InvoicePeer::INVOICE_DESCRIPTION => 9, InvoicePeer::ORDER_DISCOUNT => 10, InvoicePeer::DATE_SELLE => 11, InvoicePeer::DATE_CREATE_COPY => 12, InvoicePeer::NUMBER => 13, InvoicePeer::SIGNATURE_SELLER => 14, InvoicePeer::SIGNATURE_CUSTOMER => 15, InvoicePeer::OPT_TOTAL_AMMOUNT_BRUTTO => 16, InvoicePeer::TOWN => 17, InvoicePeer::CURENCY => 18, InvoicePeer::MAX_DAY => 19, InvoicePeer::PAYMENT_TYPE => 20, InvoicePeer::IS_PROFORMA => 21, InvoicePeer::IS_REQUEST => 22, InvoicePeer::IS_CONFIRM => 23, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'invoice_user_seller_id' => 3, 'invoice_user_customer_id' => 4, 'order_id' => 5, 'invoice_currency_id' => 6, 'invoice_proforma_id' => 7, 'company_description' => 8, 'invoice_description' => 9, 'order_discount' => 10, 'date_selle' => 11, 'date_create_copy' => 12, 'number' => 13, 'signature_seller' => 14, 'signature_customer' => 15, 'opt_total_ammount_brutto' => 16, 'town' => 17, 'curency' => 18, 'max_day' => 19, 'payment_type' => 20, 'is_proforma' => 21, 'is_request' => 22, 'is_confirm' => 23, ),
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
		return BasePeer::getMapBuilder('plugins.stInvoicePlugin.lib.model.map.InvoiceMapBuilder');
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
			$map = InvoicePeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. InvoicePeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(InvoicePeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(InvoicePeer::CREATED_AT);

		$criteria->addSelectColumn(InvoicePeer::UPDATED_AT);

		$criteria->addSelectColumn(InvoicePeer::ID);

		$criteria->addSelectColumn(InvoicePeer::INVOICE_USER_SELLER_ID);

		$criteria->addSelectColumn(InvoicePeer::INVOICE_USER_CUSTOMER_ID);

		$criteria->addSelectColumn(InvoicePeer::ORDER_ID);

		$criteria->addSelectColumn(InvoicePeer::INVOICE_CURRENCY_ID);

		$criteria->addSelectColumn(InvoicePeer::INVOICE_PROFORMA_ID);

		$criteria->addSelectColumn(InvoicePeer::COMPANY_DESCRIPTION);

		$criteria->addSelectColumn(InvoicePeer::INVOICE_DESCRIPTION);

		$criteria->addSelectColumn(InvoicePeer::ORDER_DISCOUNT);

		$criteria->addSelectColumn(InvoicePeer::DATE_SELLE);

		$criteria->addSelectColumn(InvoicePeer::DATE_CREATE_COPY);

		$criteria->addSelectColumn(InvoicePeer::NUMBER);

		$criteria->addSelectColumn(InvoicePeer::SIGNATURE_SELLER);

		$criteria->addSelectColumn(InvoicePeer::SIGNATURE_CUSTOMER);

		$criteria->addSelectColumn(InvoicePeer::OPT_TOTAL_AMMOUNT_BRUTTO);

		$criteria->addSelectColumn(InvoicePeer::TOWN);

		$criteria->addSelectColumn(InvoicePeer::CURENCY);

		$criteria->addSelectColumn(InvoicePeer::MAX_DAY);

		$criteria->addSelectColumn(InvoicePeer::PAYMENT_TYPE);

		$criteria->addSelectColumn(InvoicePeer::IS_PROFORMA);

		$criteria->addSelectColumn(InvoicePeer::IS_REQUEST);

		$criteria->addSelectColumn(InvoicePeer::IS_CONFIRM);


		if (stEventDispatcher::getInstance()->getListeners('InvoicePeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'InvoicePeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_invoice.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_invoice.ID)';

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
			$criteria->addSelectColumn(InvoicePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(InvoicePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = InvoicePeer::doSelectRS($criteria, $con);
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
	 * @return     Invoice
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = InvoicePeer::doSelect($critcopy, $con);
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
		return InvoicePeer::populateObjects(InvoicePeer::doSelectRS($criteria, $con));
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
			InvoicePeer::addSelectColumns($criteria);
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
		$cls = InvoicePeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related InvoiceUserSeller table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinInvoiceUserSeller(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(InvoicePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(InvoicePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(InvoicePeer::INVOICE_USER_SELLER_ID, InvoiceUserSellerPeer::ID, Criteria::LEFT_JOIN);

		$rs = InvoicePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related InvoiceUserCustomer table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinInvoiceUserCustomer(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(InvoicePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(InvoicePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(InvoicePeer::INVOICE_USER_CUSTOMER_ID, InvoiceUserCustomerPeer::ID, Criteria::LEFT_JOIN);

		$rs = InvoicePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
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
			$criteria->addSelectColumn(InvoicePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(InvoicePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(InvoicePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$rs = InvoicePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related InvoiceCurrency table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinInvoiceCurrency(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(InvoicePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(InvoicePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(InvoicePeer::INVOICE_CURRENCY_ID, InvoiceCurrencyPeer::ID, Criteria::LEFT_JOIN);

		$rs = InvoicePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Invoice objects pre-filled with their InvoiceUserSeller objects.
	 *
	 * @return     array Array of Invoice objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinInvoiceUserSeller(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		InvoicePeer::addSelectColumns($c);

		InvoiceUserSellerPeer::addSelectColumns($c);

		$c->addJoin(InvoicePeer::INVOICE_USER_SELLER_ID, InvoiceUserSellerPeer::ID, Criteria::LEFT_JOIN);
		$rs = InvoicePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Invoice();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getInvoiceUserSellerId())
                        {

			   $obj2 = new InvoiceUserSeller();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addInvoice($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Invoice objects pre-filled with their InvoiceUserCustomer objects.
	 *
	 * @return     array Array of Invoice objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinInvoiceUserCustomer(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		InvoicePeer::addSelectColumns($c);

		InvoiceUserCustomerPeer::addSelectColumns($c);

		$c->addJoin(InvoicePeer::INVOICE_USER_CUSTOMER_ID, InvoiceUserCustomerPeer::ID, Criteria::LEFT_JOIN);
		$rs = InvoicePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Invoice();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getInvoiceUserCustomerId())
                        {

			   $obj2 = new InvoiceUserCustomer();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addInvoice($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Invoice objects pre-filled with their Order objects.
	 *
	 * @return     array Array of Invoice objects.
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

		InvoicePeer::addSelectColumns($c);

		OrderPeer::addSelectColumns($c);

		$c->addJoin(InvoicePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);
		$rs = InvoicePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Invoice();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getOrderId())
                        {

			   $obj2 = new Order();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addInvoice($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Invoice objects pre-filled with their InvoiceCurrency objects.
	 *
	 * @return     array Array of Invoice objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinInvoiceCurrency(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		InvoicePeer::addSelectColumns($c);

		InvoiceCurrencyPeer::addSelectColumns($c);

		$c->addJoin(InvoicePeer::INVOICE_CURRENCY_ID, InvoiceCurrencyPeer::ID, Criteria::LEFT_JOIN);
		$rs = InvoicePeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Invoice();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getInvoiceCurrencyId())
                        {

			   $obj2 = new InvoiceCurrency();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addInvoice($obj1);
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
			$criteria->addSelectColumn(InvoicePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(InvoicePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(InvoicePeer::INVOICE_USER_SELLER_ID, InvoiceUserSellerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(InvoicePeer::INVOICE_USER_CUSTOMER_ID, InvoiceUserCustomerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(InvoicePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(InvoicePeer::INVOICE_CURRENCY_ID, InvoiceCurrencyPeer::ID, Criteria::LEFT_JOIN);

		$rs = InvoicePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Invoice objects pre-filled with all related objects.
	 *
	 * @return     array Array of Invoice objects.
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

		InvoicePeer::addSelectColumns($c);
		$startcol2 = (InvoicePeer::NUM_COLUMNS - InvoicePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		InvoiceUserSellerPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + InvoiceUserSellerPeer::NUM_COLUMNS;

		InvoiceUserCustomerPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + InvoiceUserCustomerPeer::NUM_COLUMNS;

		OrderPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + OrderPeer::NUM_COLUMNS;

		InvoiceCurrencyPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + InvoiceCurrencyPeer::NUM_COLUMNS;

		$c->addJoin(InvoicePeer::INVOICE_USER_SELLER_ID, InvoiceUserSellerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(InvoicePeer::INVOICE_USER_CUSTOMER_ID, InvoiceUserCustomerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(InvoicePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(InvoicePeer::INVOICE_CURRENCY_ID, InvoiceCurrencyPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = InvoicePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined InvoiceUserSeller rows
	
			$omClass = InvoiceUserSellerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getInvoiceUserSeller(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addInvoice($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initInvoices();
				$obj2->addInvoice($obj1);
			}


				// Add objects for joined InvoiceUserCustomer rows
	
			$omClass = InvoiceUserCustomerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getInvoiceUserCustomer(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addInvoice($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initInvoices();
				$obj3->addInvoice($obj1);
			}


				// Add objects for joined Order rows
	
			$omClass = OrderPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getOrder(); // CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addInvoice($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj4->initInvoices();
				$obj4->addInvoice($obj1);
			}


				// Add objects for joined InvoiceCurrency rows
	
			$omClass = InvoiceCurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5 = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getInvoiceCurrency(); // CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addInvoice($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj5->initInvoices();
				$obj5->addInvoice($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related InvoiceUserSeller table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptInvoiceUserSeller(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(InvoicePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(InvoicePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(InvoicePeer::INVOICE_USER_CUSTOMER_ID, InvoiceUserCustomerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(InvoicePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(InvoicePeer::INVOICE_CURRENCY_ID, InvoiceCurrencyPeer::ID, Criteria::LEFT_JOIN);

		$rs = InvoicePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related InvoiceUserCustomer table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptInvoiceUserCustomer(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(InvoicePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(InvoicePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(InvoicePeer::INVOICE_USER_SELLER_ID, InvoiceUserSellerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(InvoicePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(InvoicePeer::INVOICE_CURRENCY_ID, InvoiceCurrencyPeer::ID, Criteria::LEFT_JOIN);

		$rs = InvoicePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
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
			$criteria->addSelectColumn(InvoicePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(InvoicePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(InvoicePeer::INVOICE_USER_SELLER_ID, InvoiceUserSellerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(InvoicePeer::INVOICE_USER_CUSTOMER_ID, InvoiceUserCustomerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(InvoicePeer::INVOICE_CURRENCY_ID, InvoiceCurrencyPeer::ID, Criteria::LEFT_JOIN);

		$rs = InvoicePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related InvoiceCurrency table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptInvoiceCurrency(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(InvoicePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(InvoicePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(InvoicePeer::INVOICE_USER_SELLER_ID, InvoiceUserSellerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(InvoicePeer::INVOICE_USER_CUSTOMER_ID, InvoiceUserCustomerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(InvoicePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$rs = InvoicePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Invoice objects pre-filled with all related objects except InvoiceUserSeller.
	 *
	 * @return     array Array of Invoice objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptInvoiceUserSeller(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		InvoicePeer::addSelectColumns($c);
		$startcol2 = (InvoicePeer::NUM_COLUMNS - InvoicePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		InvoiceUserCustomerPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + InvoiceUserCustomerPeer::NUM_COLUMNS;

		OrderPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OrderPeer::NUM_COLUMNS;

		InvoiceCurrencyPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + InvoiceCurrencyPeer::NUM_COLUMNS;

		$c->addJoin(InvoicePeer::INVOICE_USER_CUSTOMER_ID, InvoiceUserCustomerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(InvoicePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(InvoicePeer::INVOICE_CURRENCY_ID, InvoiceCurrencyPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = InvoicePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = InvoiceUserCustomerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getInvoiceUserCustomer(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addInvoice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initInvoices();
				$obj2->addInvoice($obj1);
			}

			$omClass = OrderPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOrder(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addInvoice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initInvoices();
				$obj3->addInvoice($obj1);
			}

			$omClass = InvoiceCurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getInvoiceCurrency(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addInvoice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initInvoices();
				$obj4->addInvoice($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Invoice objects pre-filled with all related objects except InvoiceUserCustomer.
	 *
	 * @return     array Array of Invoice objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptInvoiceUserCustomer(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		InvoicePeer::addSelectColumns($c);
		$startcol2 = (InvoicePeer::NUM_COLUMNS - InvoicePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		InvoiceUserSellerPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + InvoiceUserSellerPeer::NUM_COLUMNS;

		OrderPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OrderPeer::NUM_COLUMNS;

		InvoiceCurrencyPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + InvoiceCurrencyPeer::NUM_COLUMNS;

		$c->addJoin(InvoicePeer::INVOICE_USER_SELLER_ID, InvoiceUserSellerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(InvoicePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(InvoicePeer::INVOICE_CURRENCY_ID, InvoiceCurrencyPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = InvoicePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = InvoiceUserSellerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getInvoiceUserSeller(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addInvoice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initInvoices();
				$obj2->addInvoice($obj1);
			}

			$omClass = OrderPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOrder(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addInvoice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initInvoices();
				$obj3->addInvoice($obj1);
			}

			$omClass = InvoiceCurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getInvoiceCurrency(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addInvoice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initInvoices();
				$obj4->addInvoice($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Invoice objects pre-filled with all related objects except Order.
	 *
	 * @return     array Array of Invoice objects.
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

		InvoicePeer::addSelectColumns($c);
		$startcol2 = (InvoicePeer::NUM_COLUMNS - InvoicePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		InvoiceUserSellerPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + InvoiceUserSellerPeer::NUM_COLUMNS;

		InvoiceUserCustomerPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + InvoiceUserCustomerPeer::NUM_COLUMNS;

		InvoiceCurrencyPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + InvoiceCurrencyPeer::NUM_COLUMNS;

		$c->addJoin(InvoicePeer::INVOICE_USER_SELLER_ID, InvoiceUserSellerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(InvoicePeer::INVOICE_USER_CUSTOMER_ID, InvoiceUserCustomerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(InvoicePeer::INVOICE_CURRENCY_ID, InvoiceCurrencyPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = InvoicePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = InvoiceUserSellerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getInvoiceUserSeller(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addInvoice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initInvoices();
				$obj2->addInvoice($obj1);
			}

			$omClass = InvoiceUserCustomerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getInvoiceUserCustomer(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addInvoice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initInvoices();
				$obj3->addInvoice($obj1);
			}

			$omClass = InvoiceCurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getInvoiceCurrency(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addInvoice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initInvoices();
				$obj4->addInvoice($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Invoice objects pre-filled with all related objects except InvoiceCurrency.
	 *
	 * @return     array Array of Invoice objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptInvoiceCurrency(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		InvoicePeer::addSelectColumns($c);
		$startcol2 = (InvoicePeer::NUM_COLUMNS - InvoicePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		InvoiceUserSellerPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + InvoiceUserSellerPeer::NUM_COLUMNS;

		InvoiceUserCustomerPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + InvoiceUserCustomerPeer::NUM_COLUMNS;

		OrderPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + OrderPeer::NUM_COLUMNS;

		$c->addJoin(InvoicePeer::INVOICE_USER_SELLER_ID, InvoiceUserSellerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(InvoicePeer::INVOICE_USER_CUSTOMER_ID, InvoiceUserCustomerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(InvoicePeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = InvoicePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = InvoiceUserSellerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getInvoiceUserSeller(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addInvoice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initInvoices();
				$obj2->addInvoice($obj1);
			}

			$omClass = InvoiceUserCustomerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getInvoiceUserCustomer(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addInvoice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initInvoices();
				$obj3->addInvoice($obj1);
			}

			$omClass = OrderPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getOrder(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addInvoice($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initInvoices();
				$obj4->addInvoice($obj1);
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
		return InvoicePeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a Invoice or Criteria object.
	 *
	 * @param      mixed $values Criteria or Invoice object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseInvoicePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseInvoicePeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from Invoice object
		}

		$criteria->remove(InvoicePeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseInvoicePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseInvoicePeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a Invoice or Criteria object.
	 *
	 * @param      mixed $values Criteria or Invoice object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseInvoicePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseInvoicePeer', $values, $con);
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

			$comparison = $criteria->getComparison(InvoicePeer::ID);
			$selectCriteria->add(InvoicePeer::ID, $criteria->remove(InvoicePeer::ID), $comparison);

		} else { // $values is Invoice object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseInvoicePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseInvoicePeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_invoice table.
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
			$affectedRows += InvoicePeer::doOnDeleteCascade(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(InvoicePeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a Invoice or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or Invoice object or primary key or array of primary keys
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
			$con = Propel::getConnection(InvoicePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof Invoice) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(InvoicePeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += InvoicePeer::doOnDeleteCascade($criteria, $con);
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
		$objects = InvoicePeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related InvoiceStatus objects
			$c = new Criteria();
			
			$c->add(InvoiceStatusPeer::INVOICE_ID, $obj->getId());
			$affectedRows += InvoiceStatusPeer::doDelete($c, $con);

			// delete related InvoiceProduct objects
			$c = new Criteria();
			
			$c->add(InvoiceProductPeer::INVOICE_ID, $obj->getId());
			$affectedRows += InvoiceProductPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	/**
	 * Validates all modified columns of given Invoice object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      Invoice $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(Invoice $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(InvoicePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(InvoicePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(InvoicePeer::DATABASE_NAME, InvoicePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = InvoicePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     Invoice
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(InvoicePeer::DATABASE_NAME);

		$criteria->add(InvoicePeer::ID, $pk);


		$v = InvoicePeer::doSelect($criteria, $con);

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
			$criteria->add(InvoicePeer::ID, $pks, Criteria::IN);
			$objs = InvoicePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseInvoicePeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseInvoicePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stInvoicePlugin.lib.model.map.InvoiceMapBuilder');
}
