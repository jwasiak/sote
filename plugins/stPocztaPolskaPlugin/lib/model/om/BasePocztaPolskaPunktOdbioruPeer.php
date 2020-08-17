<?php

/**
 * Base static class for performing query and update operations on the 'st_poczta_polska_punkt_odbioru' table.
 *
 * 
 *
 * @package    plugins.stPocztaPolskaPlugin.lib.model.om
 */
abstract class BasePocztaPolskaPunktOdbioruPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_poczta_polska_punkt_odbioru';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stPocztaPolskaPlugin.lib.model.PocztaPolskaPunktOdbioru';

	/** The total number of columns. */
	const NUM_COLUMNS = 13;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the ORDER_ID field */
	const ORDER_ID = 'st_poczta_polska_punkt_odbioru.ORDER_ID';

	/** the column name for the PNI field */
	const PNI = 'st_poczta_polska_punkt_odbioru.PNI';

	/** the column name for the TYPE field */
	const TYPE = 'st_poczta_polska_punkt_odbioru.TYPE';

	/** the column name for the NAME field */
	const NAME = 'st_poczta_polska_punkt_odbioru.NAME';

	/** the column name for the DESCRIPTION field */
	const DESCRIPTION = 'st_poczta_polska_punkt_odbioru.DESCRIPTION';

	/** the column name for the PHONE field */
	const PHONE = 'st_poczta_polska_punkt_odbioru.PHONE';

	/** the column name for the STREET field */
	const STREET = 'st_poczta_polska_punkt_odbioru.STREET';

	/** the column name for the CITY field */
	const CITY = 'st_poczta_polska_punkt_odbioru.CITY';

	/** the column name for the ZIP_CODE field */
	const ZIP_CODE = 'st_poczta_polska_punkt_odbioru.ZIP_CODE';

	/** the column name for the PROVINCE field */
	const PROVINCE = 'st_poczta_polska_punkt_odbioru.PROVINCE';

	/** the column name for the EKSPRES24 field */
	const EKSPRES24 = 'st_poczta_polska_punkt_odbioru.EKSPRES24';

	/** the column name for the KURIER48 field */
	const KURIER48 = 'st_poczta_polska_punkt_odbioru.KURIER48';

	/** the column name for the PACZKA_EKSTRA24 field */
	const PACZKA_EKSTRA24 = 'st_poczta_polska_punkt_odbioru.PACZKA_EKSTRA24';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('OrderId', 'Pni', 'Type', 'Name', 'Description', 'Phone', 'Street', 'City', 'ZipCode', 'Province', 'Ekspres24', 'Kurier48', 'PaczkaEkstra24', ),
		BasePeer::TYPE_COLNAME => array (PocztaPolskaPunktOdbioruPeer::ORDER_ID, PocztaPolskaPunktOdbioruPeer::PNI, PocztaPolskaPunktOdbioruPeer::TYPE, PocztaPolskaPunktOdbioruPeer::NAME, PocztaPolskaPunktOdbioruPeer::DESCRIPTION, PocztaPolskaPunktOdbioruPeer::PHONE, PocztaPolskaPunktOdbioruPeer::STREET, PocztaPolskaPunktOdbioruPeer::CITY, PocztaPolskaPunktOdbioruPeer::ZIP_CODE, PocztaPolskaPunktOdbioruPeer::PROVINCE, PocztaPolskaPunktOdbioruPeer::EKSPRES24, PocztaPolskaPunktOdbioruPeer::KURIER48, PocztaPolskaPunktOdbioruPeer::PACZKA_EKSTRA24, ),
		BasePeer::TYPE_FIELDNAME => array ('order_id', 'pni', 'type', 'name', 'description', 'phone', 'street', 'city', 'zip_code', 'province', 'ekspres24', 'kurier48', 'paczka_ekstra24', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('OrderId' => 0, 'Pni' => 1, 'Type' => 2, 'Name' => 3, 'Description' => 4, 'Phone' => 5, 'Street' => 6, 'City' => 7, 'ZipCode' => 8, 'Province' => 9, 'Ekspres24' => 10, 'Kurier48' => 11, 'PaczkaEkstra24' => 12, ),
		BasePeer::TYPE_COLNAME => array (PocztaPolskaPunktOdbioruPeer::ORDER_ID => 0, PocztaPolskaPunktOdbioruPeer::PNI => 1, PocztaPolskaPunktOdbioruPeer::TYPE => 2, PocztaPolskaPunktOdbioruPeer::NAME => 3, PocztaPolskaPunktOdbioruPeer::DESCRIPTION => 4, PocztaPolskaPunktOdbioruPeer::PHONE => 5, PocztaPolskaPunktOdbioruPeer::STREET => 6, PocztaPolskaPunktOdbioruPeer::CITY => 7, PocztaPolskaPunktOdbioruPeer::ZIP_CODE => 8, PocztaPolskaPunktOdbioruPeer::PROVINCE => 9, PocztaPolskaPunktOdbioruPeer::EKSPRES24 => 10, PocztaPolskaPunktOdbioruPeer::KURIER48 => 11, PocztaPolskaPunktOdbioruPeer::PACZKA_EKSTRA24 => 12, ),
		BasePeer::TYPE_FIELDNAME => array ('order_id' => 0, 'pni' => 1, 'type' => 2, 'name' => 3, 'description' => 4, 'phone' => 5, 'street' => 6, 'city' => 7, 'zip_code' => 8, 'province' => 9, 'ekspres24' => 10, 'kurier48' => 11, 'paczka_ekstra24' => 12, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
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
		return BasePeer::getMapBuilder('plugins.stPocztaPolskaPlugin.lib.model.map.PocztaPolskaPunktOdbioruMapBuilder');
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
			$map = PocztaPolskaPunktOdbioruPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. PocztaPolskaPunktOdbioruPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(PocztaPolskaPunktOdbioruPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::ORDER_ID);

		$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::PNI);

		$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::TYPE);

		$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::NAME);

		$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::DESCRIPTION);

		$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::PHONE);

		$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::STREET);

		$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::CITY);

		$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::ZIP_CODE);

		$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::PROVINCE);

		$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::EKSPRES24);

		$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::KURIER48);

		$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::PACZKA_EKSTRA24);


		if (stEventDispatcher::getInstance()->getListeners('PocztaPolskaPunktOdbioruPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'PocztaPolskaPunktOdbioruPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_poczta_polska_punkt_odbioru.ORDER_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_poczta_polska_punkt_odbioru.ORDER_ID)';

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
			$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = PocztaPolskaPunktOdbioruPeer::doSelectRS($criteria, $con);
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
	 * @return     PocztaPolskaPunktOdbioru
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = PocztaPolskaPunktOdbioruPeer::doSelect($critcopy, $con);
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
		return PocztaPolskaPunktOdbioruPeer::populateObjects(PocztaPolskaPunktOdbioruPeer::doSelectRS($criteria, $con));
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
			PocztaPolskaPunktOdbioruPeer::addSelectColumns($criteria);
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
		$cls = PocztaPolskaPunktOdbioruPeer::getOMClass();
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
			$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(PocztaPolskaPunktOdbioruPeer::ORDER_ID, OrderPeer::ID);

		$rs = PocztaPolskaPunktOdbioruPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of PocztaPolskaPunktOdbioru objects pre-filled with their Order objects.
	 *
	 * @return     array Array of PocztaPolskaPunktOdbioru objects.
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

		PocztaPolskaPunktOdbioruPeer::addSelectColumns($c);

		OrderPeer::addSelectColumns($c);

		$c->addJoin(PocztaPolskaPunktOdbioruPeer::ORDER_ID, OrderPeer::ID);
		$rs = PocztaPolskaPunktOdbioruPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new PocztaPolskaPunktOdbioru();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getOrderId())
                        {

			   $obj2 = new Order();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addPocztaPolskaPunktOdbioru($obj1);
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
			$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PocztaPolskaPunktOdbioruPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(PocztaPolskaPunktOdbioruPeer::ORDER_ID, OrderPeer::ID);

		$rs = PocztaPolskaPunktOdbioruPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of PocztaPolskaPunktOdbioru objects pre-filled with all related objects.
	 *
	 * @return     array Array of PocztaPolskaPunktOdbioru objects.
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

		PocztaPolskaPunktOdbioruPeer::addSelectColumns($c);
		$startcol2 = (PocztaPolskaPunktOdbioruPeer::NUM_COLUMNS - PocztaPolskaPunktOdbioruPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderPeer::NUM_COLUMNS;

		$c->addJoin(PocztaPolskaPunktOdbioruPeer::ORDER_ID, OrderPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = PocztaPolskaPunktOdbioruPeer::getOMClass();


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
					$temp_obj2->addPocztaPolskaPunktOdbioru($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initPocztaPolskaPunktOdbiorus();
				$obj2->addPocztaPolskaPunktOdbioru($obj1);
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
		return PocztaPolskaPunktOdbioruPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a PocztaPolskaPunktOdbioru or Criteria object.
	 *
	 * @param      mixed $values Criteria or PocztaPolskaPunktOdbioru object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasePocztaPolskaPunktOdbioruPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasePocztaPolskaPunktOdbioruPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from PocztaPolskaPunktOdbioru object
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

		
    foreach (sfMixer::getCallables('BasePocztaPolskaPunktOdbioruPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasePocztaPolskaPunktOdbioruPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a PocztaPolskaPunktOdbioru or Criteria object.
	 *
	 * @param      mixed $values Criteria or PocztaPolskaPunktOdbioru object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasePocztaPolskaPunktOdbioruPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasePocztaPolskaPunktOdbioruPeer', $values, $con);
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

			$comparison = $criteria->getComparison(PocztaPolskaPunktOdbioruPeer::ORDER_ID);
			$selectCriteria->add(PocztaPolskaPunktOdbioruPeer::ORDER_ID, $criteria->remove(PocztaPolskaPunktOdbioruPeer::ORDER_ID), $comparison);

		} else { // $values is PocztaPolskaPunktOdbioru object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasePocztaPolskaPunktOdbioruPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasePocztaPolskaPunktOdbioruPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_poczta_polska_punkt_odbioru table.
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
			$affectedRows += BasePeer::doDeleteAll(PocztaPolskaPunktOdbioruPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a PocztaPolskaPunktOdbioru or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or PocztaPolskaPunktOdbioru object or primary key or array of primary keys
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
			$con = Propel::getConnection(PocztaPolskaPunktOdbioruPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof PocztaPolskaPunktOdbioru) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(PocztaPolskaPunktOdbioruPeer::ORDER_ID, (array) $values, Criteria::IN);
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
	 * Validates all modified columns of given PocztaPolskaPunktOdbioru object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      PocztaPolskaPunktOdbioru $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(PocztaPolskaPunktOdbioru $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(PocztaPolskaPunktOdbioruPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(PocztaPolskaPunktOdbioruPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(PocztaPolskaPunktOdbioruPeer::DATABASE_NAME, PocztaPolskaPunktOdbioruPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = PocztaPolskaPunktOdbioruPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     PocztaPolskaPunktOdbioru
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(PocztaPolskaPunktOdbioruPeer::DATABASE_NAME);

		$criteria->add(PocztaPolskaPunktOdbioruPeer::ORDER_ID, $pk);


		$v = PocztaPolskaPunktOdbioruPeer::doSelect($criteria, $con);

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
			$criteria->add(PocztaPolskaPunktOdbioruPeer::ORDER_ID, $pks, Criteria::IN);
			$objs = PocztaPolskaPunktOdbioruPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BasePocztaPolskaPunktOdbioruPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BasePocztaPolskaPunktOdbioruPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stPocztaPolskaPlugin.lib.model.map.PocztaPolskaPunktOdbioruMapBuilder');
}
