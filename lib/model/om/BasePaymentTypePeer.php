<?php

/**
 * Base static class for performing query and update operations on the 'st_payment_type' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePaymentTypePeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_payment_type';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.PaymentType';

	/** The total number of columns. */
	const NUM_COLUMNS = 11;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the ID field */
	const ID = 'st_payment_type.ID';

	/** the column name for the MODULE_NAME field */
	const MODULE_NAME = 'st_payment_type.MODULE_NAME';

	/** the column name for the HIDE_MODULE field */
	const HIDE_MODULE = 'st_payment_type.HIDE_MODULE';

	/** the column name for the HIDE_FOR_CONFIGURATION field */
	const HIDE_FOR_CONFIGURATION = 'st_payment_type.HIDE_FOR_CONFIGURATION';

	/** the column name for the HIDE_FOR_WHOLESALE field */
	const HIDE_FOR_WHOLESALE = 'st_payment_type.HIDE_FOR_WHOLESALE';

	/** the column name for the ACTIVE field */
	const ACTIVE = 'st_payment_type.ACTIVE';

	/** the column name for the IMAGE field */
	const IMAGE = 'st_payment_type.IMAGE';

	/** the column name for the CONFIGURATION field */
	const CONFIGURATION = 'st_payment_type.CONFIGURATION';

	/** the column name for the OPT_NAME field */
	const OPT_NAME = 'st_payment_type.OPT_NAME';

	/** the column name for the OPT_DESCRIPTION field */
	const OPT_DESCRIPTION = 'st_payment_type.OPT_DESCRIPTION';

	/** the column name for the OPT_SUMMARY_DESCRIPTION field */
	const OPT_SUMMARY_DESCRIPTION = 'st_payment_type.OPT_SUMMARY_DESCRIPTION';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'ModuleName', 'HideModule', 'HideForConfiguration', 'HideForWholesale', 'Active', 'Image', 'Configuration', 'OptName', 'OptDescription', 'OptSummaryDescription', ),
		BasePeer::TYPE_COLNAME => array (PaymentTypePeer::ID, PaymentTypePeer::MODULE_NAME, PaymentTypePeer::HIDE_MODULE, PaymentTypePeer::HIDE_FOR_CONFIGURATION, PaymentTypePeer::HIDE_FOR_WHOLESALE, PaymentTypePeer::ACTIVE, PaymentTypePeer::IMAGE, PaymentTypePeer::CONFIGURATION, PaymentTypePeer::OPT_NAME, PaymentTypePeer::OPT_DESCRIPTION, PaymentTypePeer::OPT_SUMMARY_DESCRIPTION, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'module_name', 'hide_module', 'hide_for_configuration', 'hide_for_wholesale', 'active', 'image', 'configuration', 'opt_name', 'opt_description', 'opt_summary_description', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ModuleName' => 1, 'HideModule' => 2, 'HideForConfiguration' => 3, 'HideForWholesale' => 4, 'Active' => 5, 'Image' => 6, 'Configuration' => 7, 'OptName' => 8, 'OptDescription' => 9, 'OptSummaryDescription' => 10, ),
		BasePeer::TYPE_COLNAME => array (PaymentTypePeer::ID => 0, PaymentTypePeer::MODULE_NAME => 1, PaymentTypePeer::HIDE_MODULE => 2, PaymentTypePeer::HIDE_FOR_CONFIGURATION => 3, PaymentTypePeer::HIDE_FOR_WHOLESALE => 4, PaymentTypePeer::ACTIVE => 5, PaymentTypePeer::IMAGE => 6, PaymentTypePeer::CONFIGURATION => 7, PaymentTypePeer::OPT_NAME => 8, PaymentTypePeer::OPT_DESCRIPTION => 9, PaymentTypePeer::OPT_SUMMARY_DESCRIPTION => 10, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'module_name' => 1, 'hide_module' => 2, 'hide_for_configuration' => 3, 'hide_for_wholesale' => 4, 'active' => 5, 'image' => 6, 'configuration' => 7, 'opt_name' => 8, 'opt_description' => 9, 'opt_summary_description' => 10, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
		return BasePeer::getMapBuilder('lib.model.map.PaymentTypeMapBuilder');
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
			$map = PaymentTypePeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. PaymentTypePeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(PaymentTypePeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(PaymentTypePeer::ID);

		$criteria->addSelectColumn(PaymentTypePeer::MODULE_NAME);

		$criteria->addSelectColumn(PaymentTypePeer::HIDE_MODULE);

		$criteria->addSelectColumn(PaymentTypePeer::HIDE_FOR_CONFIGURATION);

		$criteria->addSelectColumn(PaymentTypePeer::HIDE_FOR_WHOLESALE);

		$criteria->addSelectColumn(PaymentTypePeer::ACTIVE);

		$criteria->addSelectColumn(PaymentTypePeer::IMAGE);

		$criteria->addSelectColumn(PaymentTypePeer::CONFIGURATION);

		$criteria->addSelectColumn(PaymentTypePeer::OPT_NAME);

		$criteria->addSelectColumn(PaymentTypePeer::OPT_DESCRIPTION);

		$criteria->addSelectColumn(PaymentTypePeer::OPT_SUMMARY_DESCRIPTION);


		if (stEventDispatcher::getInstance()->getListeners('PaymentTypePeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'PaymentTypePeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_payment_type.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_payment_type.ID)';

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
			$criteria->addSelectColumn(PaymentTypePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PaymentTypePeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = PaymentTypePeer::doSelectRS($criteria, $con);
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
	 * @return     PaymentType
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = PaymentTypePeer::doSelect($critcopy, $con);
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
		return PaymentTypePeer::populateObjects(PaymentTypePeer::doSelectRS($criteria, $con));
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
			PaymentTypePeer::addSelectColumns($criteria);
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
		$cls = PaymentTypePeer::getOMClass();
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
      * Selects a collection of PaymentType objects pre-filled with their i18n objects.
      *
      * @return array Array of PaymentType objects.
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
          PaymentTypePeer::addSelectColumns($c);
          PaymentTypeI18nPeer::addSelectColumns($c);
       }

      $c->addJoin(PaymentTypePeer::ID, sprintf('%s AND %s = \'%s\'', PaymentTypeI18nPeer::ID, PaymentTypeI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

      $rs = PaymentTypePeer::doSelectRs($c, $con);

      if (self::$hydrateMethod)
      {
         return call_user_func(self::$hydrateMethod, $rs);
      }

      $results = array();

      while($rs->next()) {

         $obj1 = new PaymentType();
         $startcol = $obj1->hydrate($rs);
         $obj1->setCulture($culture);

         $obj2 = new PaymentTypeI18n();
         $obj2->hydrate($rs, $startcol);

         $obj1->setPaymentTypeI18nForCulture($obj2, $culture);
         $obj2->setPaymentType($obj1);

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
		return PaymentTypePeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a PaymentType or Criteria object.
	 *
	 * @param      mixed $values Criteria or PaymentType object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasePaymentTypePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasePaymentTypePeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from PaymentType object
		}

		$criteria->remove(PaymentTypePeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BasePaymentTypePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasePaymentTypePeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a PaymentType or Criteria object.
	 *
	 * @param      mixed $values Criteria or PaymentType object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasePaymentTypePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasePaymentTypePeer', $values, $con);
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

			$comparison = $criteria->getComparison(PaymentTypePeer::ID);
			$selectCriteria->add(PaymentTypePeer::ID, $criteria->remove(PaymentTypePeer::ID), $comparison);

		} else { // $values is PaymentType object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasePaymentTypePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasePaymentTypePeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_payment_type table.
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
			$affectedRows += PaymentTypePeer::doOnDeleteCascade(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(PaymentTypePeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a PaymentType or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or PaymentType object or primary key or array of primary keys
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
			$con = Propel::getConnection(PaymentTypePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof PaymentType) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(PaymentTypePeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += PaymentTypePeer::doOnDeleteCascade($criteria, $con);
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
		$objects = PaymentTypePeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related PaymentTypeI18n objects
			$c = new Criteria();
			
			$c->add(PaymentTypeI18nPeer::ID, $obj->getId());
			$affectedRows += PaymentTypeI18nPeer::doDelete($c, $con);

			// delete related DeliveryHasPaymentType objects
			$c = new Criteria();
			
			$c->add(DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID, $obj->getId());
			$affectedRows += DeliveryHasPaymentTypePeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	/**
	 * Validates all modified columns of given PaymentType object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      PaymentType $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(PaymentType $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(PaymentTypePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(PaymentTypePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(PaymentTypePeer::DATABASE_NAME, PaymentTypePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = PaymentTypePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     PaymentType
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(PaymentTypePeer::DATABASE_NAME);

		$criteria->add(PaymentTypePeer::ID, $pk);


		$v = PaymentTypePeer::doSelect($criteria, $con);

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
			$criteria->add(PaymentTypePeer::ID, $pks, Criteria::IN);
			$objs = PaymentTypePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BasePaymentTypePeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BasePaymentTypePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('lib.model.map.PaymentTypeMapBuilder');
}
