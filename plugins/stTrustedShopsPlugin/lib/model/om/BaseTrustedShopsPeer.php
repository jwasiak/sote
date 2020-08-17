<?php

/**
 * Base static class for performing query and update operations on the 'st_trusted_shops' table.
 *
 * 
 *
 * @package    plugins.stTrustedShopsPlugin.lib.model.om
 */
abstract class BaseTrustedShopsPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_trusted_shops';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stTrustedShopsPlugin.lib.model.TrustedShops';

	/** The total number of columns. */
	const NUM_COLUMNS = 15;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_trusted_shops.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_trusted_shops.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_trusted_shops.ID';

	/** the column name for the CERTIFICATE field */
	const CERTIFICATE = 'st_trusted_shops.CERTIFICATE';

	/** the column name for the USERNAME field */
	const USERNAME = 'st_trusted_shops.USERNAME';

	/** the column name for the PASSWORD field */
	const PASSWORD = 'st_trusted_shops.PASSWORD';

	/** the column name for the TYPE field */
	const TYPE = 'st_trusted_shops.TYPE';

	/** the column name for the URL field */
	const URL = 'st_trusted_shops.URL';

	/** the column name for the LANGUAGE field */
	const LANGUAGE = 'st_trusted_shops.LANGUAGE';

	/** the column name for the STATUS field */
	const STATUS = 'st_trusted_shops.STATUS';

	/** the column name for the LOGO field */
	const LOGO = 'st_trusted_shops.LOGO';

	/** the column name for the RATING_WIDGET field */
	const RATING_WIDGET = 'st_trusted_shops.RATING_WIDGET';

	/** the column name for the RATING_STATUS field */
	const RATING_STATUS = 'st_trusted_shops.RATING_STATUS';

	/** the column name for the RATING_IN_ORDER_MAIL field */
	const RATING_IN_ORDER_MAIL = 'st_trusted_shops.RATING_IN_ORDER_MAIL';

	/** the column name for the TRUSTBADGE_CODE field */
	const TRUSTBADGE_CODE = 'st_trusted_shops.TRUSTBADGE_CODE';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'Certificate', 'Username', 'Password', 'Type', 'Url', 'Language', 'Status', 'Logo', 'RatingWidget', 'RatingStatus', 'RatingInOrderMail', 'TrustbadgeCode', ),
		BasePeer::TYPE_COLNAME => array (TrustedShopsPeer::CREATED_AT, TrustedShopsPeer::UPDATED_AT, TrustedShopsPeer::ID, TrustedShopsPeer::CERTIFICATE, TrustedShopsPeer::USERNAME, TrustedShopsPeer::PASSWORD, TrustedShopsPeer::TYPE, TrustedShopsPeer::URL, TrustedShopsPeer::LANGUAGE, TrustedShopsPeer::STATUS, TrustedShopsPeer::LOGO, TrustedShopsPeer::RATING_WIDGET, TrustedShopsPeer::RATING_STATUS, TrustedShopsPeer::RATING_IN_ORDER_MAIL, TrustedShopsPeer::TRUSTBADGE_CODE, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'certificate', 'username', 'password', 'type', 'url', 'language', 'status', 'logo', 'rating_widget', 'rating_status', 'rating_in_order_mail', 'trustbadge_code', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'Certificate' => 3, 'Username' => 4, 'Password' => 5, 'Type' => 6, 'Url' => 7, 'Language' => 8, 'Status' => 9, 'Logo' => 10, 'RatingWidget' => 11, 'RatingStatus' => 12, 'RatingInOrderMail' => 13, 'TrustbadgeCode' => 14, ),
		BasePeer::TYPE_COLNAME => array (TrustedShopsPeer::CREATED_AT => 0, TrustedShopsPeer::UPDATED_AT => 1, TrustedShopsPeer::ID => 2, TrustedShopsPeer::CERTIFICATE => 3, TrustedShopsPeer::USERNAME => 4, TrustedShopsPeer::PASSWORD => 5, TrustedShopsPeer::TYPE => 6, TrustedShopsPeer::URL => 7, TrustedShopsPeer::LANGUAGE => 8, TrustedShopsPeer::STATUS => 9, TrustedShopsPeer::LOGO => 10, TrustedShopsPeer::RATING_WIDGET => 11, TrustedShopsPeer::RATING_STATUS => 12, TrustedShopsPeer::RATING_IN_ORDER_MAIL => 13, TrustedShopsPeer::TRUSTBADGE_CODE => 14, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'certificate' => 3, 'username' => 4, 'password' => 5, 'type' => 6, 'url' => 7, 'language' => 8, 'status' => 9, 'logo' => 10, 'rating_widget' => 11, 'rating_status' => 12, 'rating_in_order_mail' => 13, 'trustbadge_code' => 14, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
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
		return BasePeer::getMapBuilder('plugins.stTrustedShopsPlugin.lib.model.map.TrustedShopsMapBuilder');
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
			$map = TrustedShopsPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. TrustedShopsPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(TrustedShopsPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(TrustedShopsPeer::CREATED_AT);

		$criteria->addSelectColumn(TrustedShopsPeer::UPDATED_AT);

		$criteria->addSelectColumn(TrustedShopsPeer::ID);

		$criteria->addSelectColumn(TrustedShopsPeer::CERTIFICATE);

		$criteria->addSelectColumn(TrustedShopsPeer::USERNAME);

		$criteria->addSelectColumn(TrustedShopsPeer::PASSWORD);

		$criteria->addSelectColumn(TrustedShopsPeer::TYPE);

		$criteria->addSelectColumn(TrustedShopsPeer::URL);

		$criteria->addSelectColumn(TrustedShopsPeer::LANGUAGE);

		$criteria->addSelectColumn(TrustedShopsPeer::STATUS);

		$criteria->addSelectColumn(TrustedShopsPeer::LOGO);

		$criteria->addSelectColumn(TrustedShopsPeer::RATING_WIDGET);

		$criteria->addSelectColumn(TrustedShopsPeer::RATING_STATUS);

		$criteria->addSelectColumn(TrustedShopsPeer::RATING_IN_ORDER_MAIL);

		$criteria->addSelectColumn(TrustedShopsPeer::TRUSTBADGE_CODE);


		if (stEventDispatcher::getInstance()->getListeners('TrustedShopsPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'TrustedShopsPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_trusted_shops.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_trusted_shops.ID)';

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
			$criteria->addSelectColumn(TrustedShopsPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TrustedShopsPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = TrustedShopsPeer::doSelectRS($criteria, $con);
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
	 * @return     TrustedShops
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = TrustedShopsPeer::doSelect($critcopy, $con);
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
		return TrustedShopsPeer::populateObjects(TrustedShopsPeer::doSelectRS($criteria, $con));
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
			TrustedShopsPeer::addSelectColumns($criteria);
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
		$cls = TrustedShopsPeer::getOMClass();
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
		return TrustedShopsPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a TrustedShops or Criteria object.
	 *
	 * @param      mixed $values Criteria or TrustedShops object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseTrustedShopsPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseTrustedShopsPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from TrustedShops object
		}

		$criteria->remove(TrustedShopsPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseTrustedShopsPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseTrustedShopsPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a TrustedShops or Criteria object.
	 *
	 * @param      mixed $values Criteria or TrustedShops object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseTrustedShopsPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseTrustedShopsPeer', $values, $con);
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

			$comparison = $criteria->getComparison(TrustedShopsPeer::ID);
			$selectCriteria->add(TrustedShopsPeer::ID, $criteria->remove(TrustedShopsPeer::ID), $comparison);

		} else { // $values is TrustedShops object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseTrustedShopsPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseTrustedShopsPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_trusted_shops table.
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
			$affectedRows += TrustedShopsPeer::doOnDeleteCascade(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(TrustedShopsPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a TrustedShops or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or TrustedShops object or primary key or array of primary keys
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
			$con = Propel::getConnection(TrustedShopsPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof TrustedShops) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(TrustedShopsPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += TrustedShopsPeer::doOnDeleteCascade($criteria, $con);
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
		$objects = TrustedShopsPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related TrustedShopsHasPaymentType objects
			$c = new Criteria();
			
			$c->add(TrustedShopsHasPaymentTypePeer::TRUSTED_SHOPS_ID, $obj->getId());
			$affectedRows += TrustedShopsHasPaymentTypePeer::doDelete($c, $con);

			// delete related TrustedShopsProtectionProducts objects
			$c = new Criteria();
			
			$c->add(TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID, $obj->getId());
			$affectedRows += TrustedShopsProtectionProductsPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	/**
	 * Validates all modified columns of given TrustedShops object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      TrustedShops $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(TrustedShops $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(TrustedShopsPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(TrustedShopsPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(TrustedShopsPeer::DATABASE_NAME, TrustedShopsPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = TrustedShopsPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     TrustedShops
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(TrustedShopsPeer::DATABASE_NAME);

		$criteria->add(TrustedShopsPeer::ID, $pk);


		$v = TrustedShopsPeer::doSelect($criteria, $con);

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
			$criteria->add(TrustedShopsPeer::ID, $pks, Criteria::IN);
			$objs = TrustedShopsPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseTrustedShopsPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseTrustedShopsPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stTrustedShopsPlugin.lib.model.map.TrustedShopsMapBuilder');
}
