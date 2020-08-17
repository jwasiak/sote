<?php

/**
 * Base static class for performing query and update operations on the 'st_invoice_user_customer' table.
 *
 * 
 *
 * @package    plugins.stInvoicePlugin.lib.model.om
 */
abstract class BaseInvoiceUserCustomerPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_invoice_user_customer';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stInvoicePlugin.lib.model.InvoiceUserCustomer';

	/** The total number of columns. */
	const NUM_COLUMNS = 19;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_invoice_user_customer.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_invoice_user_customer.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_invoice_user_customer.ID';

	/** the column name for the COUNTRY field */
	const COUNTRY = 'st_invoice_user_customer.COUNTRY';

	/** the column name for the FULL_NAME field */
	const FULL_NAME = 'st_invoice_user_customer.FULL_NAME';

	/** the column name for the NAME field */
	const NAME = 'st_invoice_user_customer.NAME';

	/** the column name for the SURNAME field */
	const SURNAME = 'st_invoice_user_customer.SURNAME';

	/** the column name for the ADDRESS field */
	const ADDRESS = 'st_invoice_user_customer.ADDRESS';

	/** the column name for the ADDRESS_MORE field */
	const ADDRESS_MORE = 'st_invoice_user_customer.ADDRESS_MORE';

	/** the column name for the REGION field */
	const REGION = 'st_invoice_user_customer.REGION';

	/** the column name for the STREET field */
	const STREET = 'st_invoice_user_customer.STREET';

	/** the column name for the HOUSE field */
	const HOUSE = 'st_invoice_user_customer.HOUSE';

	/** the column name for the FLAT field */
	const FLAT = 'st_invoice_user_customer.FLAT';

	/** the column name for the CODE field */
	const CODE = 'st_invoice_user_customer.CODE';

	/** the column name for the TOWN field */
	const TOWN = 'st_invoice_user_customer.TOWN';

	/** the column name for the COMPANY field */
	const COMPANY = 'st_invoice_user_customer.COMPANY';

	/** the column name for the VAT_NUMBER field */
	const VAT_NUMBER = 'st_invoice_user_customer.VAT_NUMBER';

	/** the column name for the PESEL field */
	const PESEL = 'st_invoice_user_customer.PESEL';

	/** the column name for the CRYPT field */
	const CRYPT = 'st_invoice_user_customer.CRYPT';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'Country', 'FullName', 'Name', 'Surname', 'Address', 'AddressMore', 'Region', 'Street', 'House', 'Flat', 'Code', 'Town', 'Company', 'VatNumber', 'Pesel', 'Crypt', ),
		BasePeer::TYPE_COLNAME => array (InvoiceUserCustomerPeer::CREATED_AT, InvoiceUserCustomerPeer::UPDATED_AT, InvoiceUserCustomerPeer::ID, InvoiceUserCustomerPeer::COUNTRY, InvoiceUserCustomerPeer::FULL_NAME, InvoiceUserCustomerPeer::NAME, InvoiceUserCustomerPeer::SURNAME, InvoiceUserCustomerPeer::ADDRESS, InvoiceUserCustomerPeer::ADDRESS_MORE, InvoiceUserCustomerPeer::REGION, InvoiceUserCustomerPeer::STREET, InvoiceUserCustomerPeer::HOUSE, InvoiceUserCustomerPeer::FLAT, InvoiceUserCustomerPeer::CODE, InvoiceUserCustomerPeer::TOWN, InvoiceUserCustomerPeer::COMPANY, InvoiceUserCustomerPeer::VAT_NUMBER, InvoiceUserCustomerPeer::PESEL, InvoiceUserCustomerPeer::CRYPT, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'country', 'full_name', 'name', 'surname', 'address', 'address_more', 'region', 'street', 'house', 'flat', 'code', 'town', 'company', 'vat_number', 'pesel', 'crypt', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'Country' => 3, 'FullName' => 4, 'Name' => 5, 'Surname' => 6, 'Address' => 7, 'AddressMore' => 8, 'Region' => 9, 'Street' => 10, 'House' => 11, 'Flat' => 12, 'Code' => 13, 'Town' => 14, 'Company' => 15, 'VatNumber' => 16, 'Pesel' => 17, 'Crypt' => 18, ),
		BasePeer::TYPE_COLNAME => array (InvoiceUserCustomerPeer::CREATED_AT => 0, InvoiceUserCustomerPeer::UPDATED_AT => 1, InvoiceUserCustomerPeer::ID => 2, InvoiceUserCustomerPeer::COUNTRY => 3, InvoiceUserCustomerPeer::FULL_NAME => 4, InvoiceUserCustomerPeer::NAME => 5, InvoiceUserCustomerPeer::SURNAME => 6, InvoiceUserCustomerPeer::ADDRESS => 7, InvoiceUserCustomerPeer::ADDRESS_MORE => 8, InvoiceUserCustomerPeer::REGION => 9, InvoiceUserCustomerPeer::STREET => 10, InvoiceUserCustomerPeer::HOUSE => 11, InvoiceUserCustomerPeer::FLAT => 12, InvoiceUserCustomerPeer::CODE => 13, InvoiceUserCustomerPeer::TOWN => 14, InvoiceUserCustomerPeer::COMPANY => 15, InvoiceUserCustomerPeer::VAT_NUMBER => 16, InvoiceUserCustomerPeer::PESEL => 17, InvoiceUserCustomerPeer::CRYPT => 18, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'country' => 3, 'full_name' => 4, 'name' => 5, 'surname' => 6, 'address' => 7, 'address_more' => 8, 'region' => 9, 'street' => 10, 'house' => 11, 'flat' => 12, 'code' => 13, 'town' => 14, 'company' => 15, 'vat_number' => 16, 'pesel' => 17, 'crypt' => 18, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
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
		return BasePeer::getMapBuilder('plugins.stInvoicePlugin.lib.model.map.InvoiceUserCustomerMapBuilder');
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
			$map = InvoiceUserCustomerPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. InvoiceUserCustomerPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(InvoiceUserCustomerPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::CREATED_AT);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::UPDATED_AT);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::ID);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::COUNTRY);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::FULL_NAME);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::NAME);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::SURNAME);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::ADDRESS);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::ADDRESS_MORE);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::REGION);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::STREET);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::HOUSE);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::FLAT);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::CODE);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::TOWN);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::COMPANY);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::VAT_NUMBER);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::PESEL);

		$criteria->addSelectColumn(InvoiceUserCustomerPeer::CRYPT);


		if (stEventDispatcher::getInstance()->getListeners('InvoiceUserCustomerPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'InvoiceUserCustomerPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_invoice_user_customer.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_invoice_user_customer.ID)';

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
			$criteria->addSelectColumn(InvoiceUserCustomerPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(InvoiceUserCustomerPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = InvoiceUserCustomerPeer::doSelectRS($criteria, $con);
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
	 * @return     InvoiceUserCustomer
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = InvoiceUserCustomerPeer::doSelect($critcopy, $con);
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
		return InvoiceUserCustomerPeer::populateObjects(InvoiceUserCustomerPeer::doSelectRS($criteria, $con));
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
			InvoiceUserCustomerPeer::addSelectColumns($criteria);
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
		$cls = InvoiceUserCustomerPeer::getOMClass();
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
		return InvoiceUserCustomerPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a InvoiceUserCustomer or Criteria object.
	 *
	 * @param      mixed $values Criteria or InvoiceUserCustomer object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseInvoiceUserCustomerPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseInvoiceUserCustomerPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from InvoiceUserCustomer object
		}

		$criteria->remove(InvoiceUserCustomerPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseInvoiceUserCustomerPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseInvoiceUserCustomerPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a InvoiceUserCustomer or Criteria object.
	 *
	 * @param      mixed $values Criteria or InvoiceUserCustomer object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseInvoiceUserCustomerPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseInvoiceUserCustomerPeer', $values, $con);
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

			$comparison = $criteria->getComparison(InvoiceUserCustomerPeer::ID);
			$selectCriteria->add(InvoiceUserCustomerPeer::ID, $criteria->remove(InvoiceUserCustomerPeer::ID), $comparison);

		} else { // $values is InvoiceUserCustomer object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseInvoiceUserCustomerPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseInvoiceUserCustomerPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_invoice_user_customer table.
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
			$affectedRows += BasePeer::doDeleteAll(InvoiceUserCustomerPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a InvoiceUserCustomer or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or InvoiceUserCustomer object or primary key or array of primary keys
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
			$con = Propel::getConnection(InvoiceUserCustomerPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof InvoiceUserCustomer) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(InvoiceUserCustomerPeer::ID, (array) $values, Criteria::IN);
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
	 * Validates all modified columns of given InvoiceUserCustomer object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      InvoiceUserCustomer $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(InvoiceUserCustomer $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(InvoiceUserCustomerPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(InvoiceUserCustomerPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(InvoiceUserCustomerPeer::DATABASE_NAME, InvoiceUserCustomerPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = InvoiceUserCustomerPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     InvoiceUserCustomer
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(InvoiceUserCustomerPeer::DATABASE_NAME);

		$criteria->add(InvoiceUserCustomerPeer::ID, $pk);


		$v = InvoiceUserCustomerPeer::doSelect($criteria, $con);

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
			$criteria->add(InvoiceUserCustomerPeer::ID, $pks, Criteria::IN);
			$objs = InvoiceUserCustomerPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseInvoiceUserCustomerPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseInvoiceUserCustomerPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stInvoicePlugin.lib.model.map.InvoiceUserCustomerMapBuilder');
}
