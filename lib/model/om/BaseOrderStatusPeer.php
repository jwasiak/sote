<?php

/**
 * Base static class for performing query and update operations on the 'st_order_status' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseOrderStatusPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_order_status';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.OrderStatus';

	/** The total number of columns. */
	const NUM_COLUMNS = 14;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_order_status.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_order_status.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_order_status.ID';

	/** the column name for the COUPON_CODE_ID field */
	const COUPON_CODE_ID = 'st_order_status.COUPON_CODE_ID';

	/** the column name for the OPT_NAME field */
	const OPT_NAME = 'st_order_status.OPT_NAME';

	/** the column name for the OPT_DESCRIPTION field */
	const OPT_DESCRIPTION = 'st_order_status.OPT_DESCRIPTION';

	/** the column name for the TYPE field */
	const TYPE = 'st_order_status.TYPE';

	/** the column name for the IS_DEFAULT field */
	const IS_DEFAULT = 'st_order_status.IS_DEFAULT';

	/** the column name for the IS_SYSTEM_DEFAULT field */
	const IS_SYSTEM_DEFAULT = 'st_order_status.IS_SYSTEM_DEFAULT';

	/** the column name for the HAS_MAIL_NOTIFICATION field */
	const HAS_MAIL_NOTIFICATION = 'st_order_status.HAS_MAIL_NOTIFICATION';

	/** the column name for the HAS_COUPON_CODE field */
	const HAS_COUPON_CODE = 'st_order_status.HAS_COUPON_CODE';

	/** the column name for the HAS_INVOICE_PROFORMA field */
	const HAS_INVOICE_PROFORMA = 'st_order_status.HAS_INVOICE_PROFORMA';

	/** the column name for the HAS_INVOICE field */
	const HAS_INVOICE = 'st_order_status.HAS_INVOICE';

	/** the column name for the DEPOSITORY_ACTION field */
	const DEPOSITORY_ACTION = 'st_order_status.DEPOSITORY_ACTION';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'CouponCodeId', 'OptName', 'OptDescription', 'Type', 'IsDefault', 'IsSystemDefault', 'HasMailNotification', 'HasCouponCode', 'HasInvoiceProforma', 'HasInvoice', 'DepositoryAction', ),
		BasePeer::TYPE_COLNAME => array (OrderStatusPeer::CREATED_AT, OrderStatusPeer::UPDATED_AT, OrderStatusPeer::ID, OrderStatusPeer::COUPON_CODE_ID, OrderStatusPeer::OPT_NAME, OrderStatusPeer::OPT_DESCRIPTION, OrderStatusPeer::TYPE, OrderStatusPeer::IS_DEFAULT, OrderStatusPeer::IS_SYSTEM_DEFAULT, OrderStatusPeer::HAS_MAIL_NOTIFICATION, OrderStatusPeer::HAS_COUPON_CODE, OrderStatusPeer::HAS_INVOICE_PROFORMA, OrderStatusPeer::HAS_INVOICE, OrderStatusPeer::DEPOSITORY_ACTION, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'coupon_code_id', 'opt_name', 'opt_description', 'type', 'is_default', 'is_system_default', 'has_mail_notification', 'has_coupon_code', 'has_invoice_proforma', 'has_invoice', 'depository_action', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'CouponCodeId' => 3, 'OptName' => 4, 'OptDescription' => 5, 'Type' => 6, 'IsDefault' => 7, 'IsSystemDefault' => 8, 'HasMailNotification' => 9, 'HasCouponCode' => 10, 'HasInvoiceProforma' => 11, 'HasInvoice' => 12, 'DepositoryAction' => 13, ),
		BasePeer::TYPE_COLNAME => array (OrderStatusPeer::CREATED_AT => 0, OrderStatusPeer::UPDATED_AT => 1, OrderStatusPeer::ID => 2, OrderStatusPeer::COUPON_CODE_ID => 3, OrderStatusPeer::OPT_NAME => 4, OrderStatusPeer::OPT_DESCRIPTION => 5, OrderStatusPeer::TYPE => 6, OrderStatusPeer::IS_DEFAULT => 7, OrderStatusPeer::IS_SYSTEM_DEFAULT => 8, OrderStatusPeer::HAS_MAIL_NOTIFICATION => 9, OrderStatusPeer::HAS_COUPON_CODE => 10, OrderStatusPeer::HAS_INVOICE_PROFORMA => 11, OrderStatusPeer::HAS_INVOICE => 12, OrderStatusPeer::DEPOSITORY_ACTION => 13, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'coupon_code_id' => 3, 'opt_name' => 4, 'opt_description' => 5, 'type' => 6, 'is_default' => 7, 'is_system_default' => 8, 'has_mail_notification' => 9, 'has_coupon_code' => 10, 'has_invoice_proforma' => 11, 'has_invoice' => 12, 'depository_action' => 13, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
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
		return BasePeer::getMapBuilder('lib.model.map.OrderStatusMapBuilder');
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
			$map = OrderStatusPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. OrderStatusPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(OrderStatusPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(OrderStatusPeer::CREATED_AT);

		$criteria->addSelectColumn(OrderStatusPeer::UPDATED_AT);

		$criteria->addSelectColumn(OrderStatusPeer::ID);

		$criteria->addSelectColumn(OrderStatusPeer::COUPON_CODE_ID);

		$criteria->addSelectColumn(OrderStatusPeer::OPT_NAME);

		$criteria->addSelectColumn(OrderStatusPeer::OPT_DESCRIPTION);

		$criteria->addSelectColumn(OrderStatusPeer::TYPE);

		$criteria->addSelectColumn(OrderStatusPeer::IS_DEFAULT);

		$criteria->addSelectColumn(OrderStatusPeer::IS_SYSTEM_DEFAULT);

		$criteria->addSelectColumn(OrderStatusPeer::HAS_MAIL_NOTIFICATION);

		$criteria->addSelectColumn(OrderStatusPeer::HAS_COUPON_CODE);

		$criteria->addSelectColumn(OrderStatusPeer::HAS_INVOICE_PROFORMA);

		$criteria->addSelectColumn(OrderStatusPeer::HAS_INVOICE);

		$criteria->addSelectColumn(OrderStatusPeer::DEPOSITORY_ACTION);


		if (stEventDispatcher::getInstance()->getListeners('OrderStatusPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'OrderStatusPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_order_status.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_order_status.ID)';

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
			$criteria->addSelectColumn(OrderStatusPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderStatusPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OrderStatusPeer::doSelectRS($criteria, $con);
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
	 * @return     OrderStatus
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = OrderStatusPeer::doSelect($critcopy, $con);
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
		return OrderStatusPeer::populateObjects(OrderStatusPeer::doSelectRS($criteria, $con));
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
			OrderStatusPeer::addSelectColumns($criteria);
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
		$cls = OrderStatusPeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related OrderStatusCouponCode table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinOrderStatusCouponCode(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OrderStatusPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderStatusPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderStatusPeer::COUPON_CODE_ID, OrderStatusCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderStatusPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of OrderStatus objects pre-filled with their OrderStatusCouponCode objects.
	 *
	 * @return     array Array of OrderStatus objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinOrderStatusCouponCode(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OrderStatusPeer::addSelectColumns($c);

		OrderStatusCouponCodePeer::addSelectColumns($c);

		$c->addJoin(OrderStatusPeer::COUPON_CODE_ID, OrderStatusCouponCodePeer::ID, Criteria::LEFT_JOIN);
		$rs = OrderStatusPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new OrderStatus();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getCouponCodeId())
                        {

			   $obj2 = new OrderStatusCouponCode();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addOrderStatus($obj1);
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
			$criteria->addSelectColumn(OrderStatusPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OrderStatusPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OrderStatusPeer::COUPON_CODE_ID, OrderStatusCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$rs = OrderStatusPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of OrderStatus objects pre-filled with all related objects.
	 *
	 * @return     array Array of OrderStatus objects.
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

		OrderStatusPeer::addSelectColumns($c);
		$startcol2 = (OrderStatusPeer::NUM_COLUMNS - OrderStatusPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderStatusCouponCodePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderStatusCouponCodePeer::NUM_COLUMNS;

		$c->addJoin(OrderStatusPeer::COUPON_CODE_ID, OrderStatusCouponCodePeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = OrderStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined OrderStatusCouponCode rows
	
			$omClass = OrderStatusCouponCodePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrderStatusCouponCode(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOrderStatus($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initOrderStatuss();
				$obj2->addOrderStatus($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


     /**
      * Selects a collection of OrderStatus objects pre-filled with their i18n objects.
      *
      * @return array Array of OrderStatus objects.
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
          OrderStatusPeer::addSelectColumns($c);
          OrderStatusI18nPeer::addSelectColumns($c);
       }

      $c->addJoin(OrderStatusPeer::ID, sprintf('%s AND %s = \'%s\'', OrderStatusI18nPeer::ID, OrderStatusI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

      $rs = OrderStatusPeer::doSelectRs($c, $con);

      if (self::$hydrateMethod)
      {
         return call_user_func(self::$hydrateMethod, $rs);
      }

      $results = array();

      while($rs->next()) {

         $obj1 = new OrderStatus();
         $startcol = $obj1->hydrate($rs);
         $obj1->setCulture($culture);

         $obj2 = new OrderStatusI18n();
         $obj2->hydrate($rs, $startcol);

         $obj1->setOrderStatusI18nForCulture($obj2, $culture);
         $obj2->setOrderStatus($obj1);

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
		return OrderStatusPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a OrderStatus or Criteria object.
	 *
	 * @param      mixed $values Criteria or OrderStatus object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseOrderStatusPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseOrderStatusPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from OrderStatus object
		}

		$criteria->remove(OrderStatusPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseOrderStatusPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseOrderStatusPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a OrderStatus or Criteria object.
	 *
	 * @param      mixed $values Criteria or OrderStatus object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseOrderStatusPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseOrderStatusPeer', $values, $con);
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

			$comparison = $criteria->getComparison(OrderStatusPeer::ID);
			$selectCriteria->add(OrderStatusPeer::ID, $criteria->remove(OrderStatusPeer::ID), $comparison);

		} else { // $values is OrderStatus object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseOrderStatusPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseOrderStatusPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_order_status table.
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
			$affectedRows += OrderStatusPeer::doOnDeleteCascade(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(OrderStatusPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a OrderStatus or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or OrderStatus object or primary key or array of primary keys
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
			$con = Propel::getConnection(OrderStatusPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof OrderStatus) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(OrderStatusPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += OrderStatusPeer::doOnDeleteCascade($criteria, $con);
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
		$objects = OrderStatusPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related OrderStatusI18n objects
			$c = new Criteria();
			
			$c->add(OrderStatusI18nPeer::ID, $obj->getId());
			$affectedRows += OrderStatusI18nPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	/**
	 * Validates all modified columns of given OrderStatus object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      OrderStatus $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(OrderStatus $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OrderStatusPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OrderStatusPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OrderStatusPeer::DATABASE_NAME, OrderStatusPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OrderStatusPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     OrderStatus
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(OrderStatusPeer::DATABASE_NAME);

		$criteria->add(OrderStatusPeer::ID, $pk);


		$v = OrderStatusPeer::doSelect($criteria, $con);

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
			$criteria->add(OrderStatusPeer::ID, $pks, Criteria::IN);
			$objs = OrderStatusPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseOrderStatusPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseOrderStatusPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('lib.model.map.OrderStatusMapBuilder');
}
