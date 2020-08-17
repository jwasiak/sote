<?php

/**
 * Base static class for performing query and update operations on the 'st_paczkomaty_pack' table.
 *
 * 
 *
 * @package    plugins.stPaczkomatyPlugin.lib.model.om
 */
abstract class BasePaczkomatyPackPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_paczkomaty_pack';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stPaczkomatyPlugin.lib.model.PaczkomatyPack';

	/** The total number of columns. */
	const NUM_COLUMNS = 20;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_paczkomaty_pack.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_paczkomaty_pack.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_paczkomaty_pack.ID';

	/** the column name for the CUSTOMER_EMAIL field */
	const CUSTOMER_EMAIL = 'st_paczkomaty_pack.CUSTOMER_EMAIL';

	/** the column name for the CUSTOMER_PHONE field */
	const CUSTOMER_PHONE = 'st_paczkomaty_pack.CUSTOMER_PHONE';

	/** the column name for the CUSTOMER_PACZKOMAT field */
	const CUSTOMER_PACZKOMAT = 'st_paczkomaty_pack.CUSTOMER_PACZKOMAT';

	/** the column name for the SENDING_METHOD field */
	const SENDING_METHOD = 'st_paczkomaty_pack.SENDING_METHOD';

	/** the column name for the SENDER_PACZKOMAT field */
	const SENDER_PACZKOMAT = 'st_paczkomaty_pack.SENDER_PACZKOMAT';

	/** the column name for the USE_SENDER_PACZKOMAT field */
	const USE_SENDER_PACZKOMAT = 'st_paczkomaty_pack.USE_SENDER_PACZKOMAT';

	/** the column name for the PACK_TYPE field */
	const PACK_TYPE = 'st_paczkomaty_pack.PACK_TYPE';

	/** the column name for the INPOST_SHIPMENT_ID field */
	const INPOST_SHIPMENT_ID = 'st_paczkomaty_pack.INPOST_SHIPMENT_ID';

	/** the column name for the INSURANCE field */
	const INSURANCE = 'st_paczkomaty_pack.INSURANCE';

	/** the column name for the CASH_ON_DELIVERY field */
	const CASH_ON_DELIVERY = 'st_paczkomaty_pack.CASH_ON_DELIVERY';

	/** the column name for the DESCRIPTION field */
	const DESCRIPTION = 'st_paczkomaty_pack.DESCRIPTION';

	/** the column name for the CODE field */
	const CODE = 'st_paczkomaty_pack.CODE';

	/** the column name for the HAS_CASH_ON_DELIVERY field */
	const HAS_CASH_ON_DELIVERY = 'st_paczkomaty_pack.HAS_CASH_ON_DELIVERY';

	/** the column name for the CUSTOMER_DELIVERING_CODE field */
	const CUSTOMER_DELIVERING_CODE = 'st_paczkomaty_pack.CUSTOMER_DELIVERING_CODE';

	/** the column name for the STATUS field */
	const STATUS = 'st_paczkomaty_pack.STATUS';

	/** the column name for the STATUS_CHANGED_AT field */
	const STATUS_CHANGED_AT = 'st_paczkomaty_pack.STATUS_CHANGED_AT';

	/** the column name for the ORDER_ID field */
	const ORDER_ID = 'st_paczkomaty_pack.ORDER_ID';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'CustomerEmail', 'CustomerPhone', 'CustomerPaczkomat', 'SendingMethod', 'SenderPaczkomat', 'UseSenderPaczkomat', 'PackType', 'InpostShipmentId', 'Insurance', 'CashOnDelivery', 'Description', 'Code', 'HasCashOnDelivery', 'CustomerDeliveringCode', 'Status', 'StatusChangedAt', 'OrderId', ),
		BasePeer::TYPE_COLNAME => array (PaczkomatyPackPeer::CREATED_AT, PaczkomatyPackPeer::UPDATED_AT, PaczkomatyPackPeer::ID, PaczkomatyPackPeer::CUSTOMER_EMAIL, PaczkomatyPackPeer::CUSTOMER_PHONE, PaczkomatyPackPeer::CUSTOMER_PACZKOMAT, PaczkomatyPackPeer::SENDING_METHOD, PaczkomatyPackPeer::SENDER_PACZKOMAT, PaczkomatyPackPeer::USE_SENDER_PACZKOMAT, PaczkomatyPackPeer::PACK_TYPE, PaczkomatyPackPeer::INPOST_SHIPMENT_ID, PaczkomatyPackPeer::INSURANCE, PaczkomatyPackPeer::CASH_ON_DELIVERY, PaczkomatyPackPeer::DESCRIPTION, PaczkomatyPackPeer::CODE, PaczkomatyPackPeer::HAS_CASH_ON_DELIVERY, PaczkomatyPackPeer::CUSTOMER_DELIVERING_CODE, PaczkomatyPackPeer::STATUS, PaczkomatyPackPeer::STATUS_CHANGED_AT, PaczkomatyPackPeer::ORDER_ID, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'customer_email', 'customer_phone', 'customer_paczkomat', 'sending_method', 'sender_paczkomat', 'use_sender_paczkomat', 'pack_type', 'inpost_shipment_id', 'insurance', 'cash_on_delivery', 'description', 'code', 'has_cash_on_delivery', 'customer_delivering_code', 'status', 'status_changed_at', 'order_id', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'CustomerEmail' => 3, 'CustomerPhone' => 4, 'CustomerPaczkomat' => 5, 'SendingMethod' => 6, 'SenderPaczkomat' => 7, 'UseSenderPaczkomat' => 8, 'PackType' => 9, 'InpostShipmentId' => 10, 'Insurance' => 11, 'CashOnDelivery' => 12, 'Description' => 13, 'Code' => 14, 'HasCashOnDelivery' => 15, 'CustomerDeliveringCode' => 16, 'Status' => 17, 'StatusChangedAt' => 18, 'OrderId' => 19, ),
		BasePeer::TYPE_COLNAME => array (PaczkomatyPackPeer::CREATED_AT => 0, PaczkomatyPackPeer::UPDATED_AT => 1, PaczkomatyPackPeer::ID => 2, PaczkomatyPackPeer::CUSTOMER_EMAIL => 3, PaczkomatyPackPeer::CUSTOMER_PHONE => 4, PaczkomatyPackPeer::CUSTOMER_PACZKOMAT => 5, PaczkomatyPackPeer::SENDING_METHOD => 6, PaczkomatyPackPeer::SENDER_PACZKOMAT => 7, PaczkomatyPackPeer::USE_SENDER_PACZKOMAT => 8, PaczkomatyPackPeer::PACK_TYPE => 9, PaczkomatyPackPeer::INPOST_SHIPMENT_ID => 10, PaczkomatyPackPeer::INSURANCE => 11, PaczkomatyPackPeer::CASH_ON_DELIVERY => 12, PaczkomatyPackPeer::DESCRIPTION => 13, PaczkomatyPackPeer::CODE => 14, PaczkomatyPackPeer::HAS_CASH_ON_DELIVERY => 15, PaczkomatyPackPeer::CUSTOMER_DELIVERING_CODE => 16, PaczkomatyPackPeer::STATUS => 17, PaczkomatyPackPeer::STATUS_CHANGED_AT => 18, PaczkomatyPackPeer::ORDER_ID => 19, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'customer_email' => 3, 'customer_phone' => 4, 'customer_paczkomat' => 5, 'sending_method' => 6, 'sender_paczkomat' => 7, 'use_sender_paczkomat' => 8, 'pack_type' => 9, 'inpost_shipment_id' => 10, 'insurance' => 11, 'cash_on_delivery' => 12, 'description' => 13, 'code' => 14, 'has_cash_on_delivery' => 15, 'customer_delivering_code' => 16, 'status' => 17, 'status_changed_at' => 18, 'order_id' => 19, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, )
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
		return BasePeer::getMapBuilder('plugins.stPaczkomatyPlugin.lib.model.map.PaczkomatyPackMapBuilder');
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
			$map = PaczkomatyPackPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. PaczkomatyPackPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(PaczkomatyPackPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(PaczkomatyPackPeer::CREATED_AT);

		$criteria->addSelectColumn(PaczkomatyPackPeer::UPDATED_AT);

		$criteria->addSelectColumn(PaczkomatyPackPeer::ID);

		$criteria->addSelectColumn(PaczkomatyPackPeer::CUSTOMER_EMAIL);

		$criteria->addSelectColumn(PaczkomatyPackPeer::CUSTOMER_PHONE);

		$criteria->addSelectColumn(PaczkomatyPackPeer::CUSTOMER_PACZKOMAT);

		$criteria->addSelectColumn(PaczkomatyPackPeer::SENDING_METHOD);

		$criteria->addSelectColumn(PaczkomatyPackPeer::SENDER_PACZKOMAT);

		$criteria->addSelectColumn(PaczkomatyPackPeer::USE_SENDER_PACZKOMAT);

		$criteria->addSelectColumn(PaczkomatyPackPeer::PACK_TYPE);

		$criteria->addSelectColumn(PaczkomatyPackPeer::INPOST_SHIPMENT_ID);

		$criteria->addSelectColumn(PaczkomatyPackPeer::INSURANCE);

		$criteria->addSelectColumn(PaczkomatyPackPeer::CASH_ON_DELIVERY);

		$criteria->addSelectColumn(PaczkomatyPackPeer::DESCRIPTION);

		$criteria->addSelectColumn(PaczkomatyPackPeer::CODE);

		$criteria->addSelectColumn(PaczkomatyPackPeer::HAS_CASH_ON_DELIVERY);

		$criteria->addSelectColumn(PaczkomatyPackPeer::CUSTOMER_DELIVERING_CODE);

		$criteria->addSelectColumn(PaczkomatyPackPeer::STATUS);

		$criteria->addSelectColumn(PaczkomatyPackPeer::STATUS_CHANGED_AT);

		$criteria->addSelectColumn(PaczkomatyPackPeer::ORDER_ID);


		if (stEventDispatcher::getInstance()->getListeners('PaczkomatyPackPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'PaczkomatyPackPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_paczkomaty_pack.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_paczkomaty_pack.ID)';

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
			$criteria->addSelectColumn(PaczkomatyPackPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PaczkomatyPackPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = PaczkomatyPackPeer::doSelectRS($criteria, $con);
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
	 * @return     PaczkomatyPack
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = PaczkomatyPackPeer::doSelect($critcopy, $con);
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
		return PaczkomatyPackPeer::populateObjects(PaczkomatyPackPeer::doSelectRS($criteria, $con));
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
			PaczkomatyPackPeer::addSelectColumns($criteria);
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
		$cls = PaczkomatyPackPeer::getOMClass();
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
			$criteria->addSelectColumn(PaczkomatyPackPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PaczkomatyPackPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(PaczkomatyPackPeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$rs = PaczkomatyPackPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of PaczkomatyPack objects pre-filled with their Order objects.
	 *
	 * @return     array Array of PaczkomatyPack objects.
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

		PaczkomatyPackPeer::addSelectColumns($c);

		OrderPeer::addSelectColumns($c);

		$c->addJoin(PaczkomatyPackPeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);
		$rs = PaczkomatyPackPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new PaczkomatyPack();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getOrderId())
                        {

			   $obj2 = new Order();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addPaczkomatyPack($obj1);
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
			$criteria->addSelectColumn(PaczkomatyPackPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PaczkomatyPackPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(PaczkomatyPackPeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$rs = PaczkomatyPackPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of PaczkomatyPack objects pre-filled with all related objects.
	 *
	 * @return     array Array of PaczkomatyPack objects.
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

		PaczkomatyPackPeer::addSelectColumns($c);
		$startcol2 = (PaczkomatyPackPeer::NUM_COLUMNS - PaczkomatyPackPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderPeer::NUM_COLUMNS;

		$c->addJoin(PaczkomatyPackPeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = PaczkomatyPackPeer::getOMClass();


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
					$temp_obj2->addPaczkomatyPack($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initPaczkomatyPacks();
				$obj2->addPaczkomatyPack($obj1);
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
		return PaczkomatyPackPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a PaczkomatyPack or Criteria object.
	 *
	 * @param      mixed $values Criteria or PaczkomatyPack object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasePaczkomatyPackPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasePaczkomatyPackPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from PaczkomatyPack object
		}

		$criteria->remove(PaczkomatyPackPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BasePaczkomatyPackPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasePaczkomatyPackPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a PaczkomatyPack or Criteria object.
	 *
	 * @param      mixed $values Criteria or PaczkomatyPack object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasePaczkomatyPackPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasePaczkomatyPackPeer', $values, $con);
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

			$comparison = $criteria->getComparison(PaczkomatyPackPeer::ID);
			$selectCriteria->add(PaczkomatyPackPeer::ID, $criteria->remove(PaczkomatyPackPeer::ID), $comparison);

		} else { // $values is PaczkomatyPack object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasePaczkomatyPackPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasePaczkomatyPackPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_paczkomaty_pack table.
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
			$affectedRows += BasePeer::doDeleteAll(PaczkomatyPackPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a PaczkomatyPack or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or PaczkomatyPack object or primary key or array of primary keys
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
			$con = Propel::getConnection(PaczkomatyPackPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof PaczkomatyPack) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(PaczkomatyPackPeer::ID, (array) $values, Criteria::IN);
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
	 * Validates all modified columns of given PaczkomatyPack object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      PaczkomatyPack $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(PaczkomatyPack $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(PaczkomatyPackPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(PaczkomatyPackPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(PaczkomatyPackPeer::DATABASE_NAME, PaczkomatyPackPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = PaczkomatyPackPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     PaczkomatyPack
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(PaczkomatyPackPeer::DATABASE_NAME);

		$criteria->add(PaczkomatyPackPeer::ID, $pk);


		$v = PaczkomatyPackPeer::doSelect($criteria, $con);

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
			$criteria->add(PaczkomatyPackPeer::ID, $pks, Criteria::IN);
			$objs = PaczkomatyPackPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BasePaczkomatyPackPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BasePaczkomatyPackPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stPaczkomatyPlugin.lib.model.map.PaczkomatyPackMapBuilder');
}
