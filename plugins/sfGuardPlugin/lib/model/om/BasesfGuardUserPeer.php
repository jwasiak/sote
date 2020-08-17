<?php

/**
 * Base static class for performing query and update operations on the 'sf_guard_user' table.
 *
 * 
 *
 * @package    plugins.sfGuardPlugin.lib.model.om
 */
abstract class BasesfGuardUserPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'sf_guard_user';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.sfGuardPlugin.lib.model.sfGuardUser';

	/** The total number of columns. */
	const NUM_COLUMNS = 19;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the ID field */
	const ID = 'sf_guard_user.ID';

	/** the column name for the USERNAME field */
	const USERNAME = 'sf_guard_user.USERNAME';

	/** the column name for the ALGORITHM field */
	const ALGORITHM = 'sf_guard_user.ALGORITHM';

	/** the column name for the SALT field */
	const SALT = 'sf_guard_user.SALT';

	/** the column name for the PASSWORD field */
	const PASSWORD = 'sf_guard_user.PASSWORD';

	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'sf_guard_user.CREATED_AT';

	/** the column name for the LAST_LOGIN field */
	const LAST_LOGIN = 'sf_guard_user.LAST_LOGIN';

	/** the column name for the IS_ACTIVE field */
	const IS_ACTIVE = 'sf_guard_user.IS_ACTIVE';

	/** the column name for the IS_SUPER_ADMIN field */
	const IS_SUPER_ADMIN = 'sf_guard_user.IS_SUPER_ADMIN';

	/** the column name for the IS_CONFIRM field */
	const IS_CONFIRM = 'sf_guard_user.IS_CONFIRM';

	/** the column name for the IS_ADMIN_CONFIRM field */
	const IS_ADMIN_CONFIRM = 'sf_guard_user.IS_ADMIN_CONFIRM';

	/** the column name for the HASH_CODE field */
	const HASH_CODE = 'sf_guard_user.HASH_CODE';

	/** the column name for the LANGUAGE field */
	const LANGUAGE = 'sf_guard_user.LANGUAGE';

	/** the column name for the EXTERNAL_ACCOUNT field */
	const EXTERNAL_ACCOUNT = 'sf_guard_user.EXTERNAL_ACCOUNT';

	/** the column name for the POINTS field */
	const POINTS = 'sf_guard_user.POINTS';

	/** the column name for the POINTS_AVAILABLE field */
	const POINTS_AVAILABLE = 'sf_guard_user.POINTS_AVAILABLE';

	/** the column name for the POINTS_RELEASE field */
	const POINTS_RELEASE = 'sf_guard_user.POINTS_RELEASE';

	/** the column name for the OPT_ALLEGRO_USER_ID field */
	const OPT_ALLEGRO_USER_ID = 'sf_guard_user.OPT_ALLEGRO_USER_ID';

	/** the column name for the WHOLESALE field */
	const WHOLESALE = 'sf_guard_user.WHOLESALE';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Username', 'Algorithm', 'Salt', 'Password', 'CreatedAt', 'LastLogin', 'IsActive', 'IsSuperAdmin', 'IsConfirm', 'IsAdminConfirm', 'HashCode', 'Language', 'ExternalAccount', 'Points', 'PointsAvailable', 'PointsRelease', 'OptAllegroUserId', 'Wholesale', ),
		BasePeer::TYPE_COLNAME => array (sfGuardUserPeer::ID, sfGuardUserPeer::USERNAME, sfGuardUserPeer::ALGORITHM, sfGuardUserPeer::SALT, sfGuardUserPeer::PASSWORD, sfGuardUserPeer::CREATED_AT, sfGuardUserPeer::LAST_LOGIN, sfGuardUserPeer::IS_ACTIVE, sfGuardUserPeer::IS_SUPER_ADMIN, sfGuardUserPeer::IS_CONFIRM, sfGuardUserPeer::IS_ADMIN_CONFIRM, sfGuardUserPeer::HASH_CODE, sfGuardUserPeer::LANGUAGE, sfGuardUserPeer::EXTERNAL_ACCOUNT, sfGuardUserPeer::POINTS, sfGuardUserPeer::POINTS_AVAILABLE, sfGuardUserPeer::POINTS_RELEASE, sfGuardUserPeer::OPT_ALLEGRO_USER_ID, sfGuardUserPeer::WHOLESALE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'username', 'algorithm', 'salt', 'password', 'created_at', 'last_login', 'is_active', 'is_super_admin', 'is_confirm', 'is_admin_confirm', 'hash_code', 'language', 'external_account', 'points', 'points_available', 'points_release', 'opt_allegro_user_id', 'wholesale', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Username' => 1, 'Algorithm' => 2, 'Salt' => 3, 'Password' => 4, 'CreatedAt' => 5, 'LastLogin' => 6, 'IsActive' => 7, 'IsSuperAdmin' => 8, 'IsConfirm' => 9, 'IsAdminConfirm' => 10, 'HashCode' => 11, 'Language' => 12, 'ExternalAccount' => 13, 'Points' => 14, 'PointsAvailable' => 15, 'PointsRelease' => 16, 'OptAllegroUserId' => 17, 'Wholesale' => 18, ),
		BasePeer::TYPE_COLNAME => array (sfGuardUserPeer::ID => 0, sfGuardUserPeer::USERNAME => 1, sfGuardUserPeer::ALGORITHM => 2, sfGuardUserPeer::SALT => 3, sfGuardUserPeer::PASSWORD => 4, sfGuardUserPeer::CREATED_AT => 5, sfGuardUserPeer::LAST_LOGIN => 6, sfGuardUserPeer::IS_ACTIVE => 7, sfGuardUserPeer::IS_SUPER_ADMIN => 8, sfGuardUserPeer::IS_CONFIRM => 9, sfGuardUserPeer::IS_ADMIN_CONFIRM => 10, sfGuardUserPeer::HASH_CODE => 11, sfGuardUserPeer::LANGUAGE => 12, sfGuardUserPeer::EXTERNAL_ACCOUNT => 13, sfGuardUserPeer::POINTS => 14, sfGuardUserPeer::POINTS_AVAILABLE => 15, sfGuardUserPeer::POINTS_RELEASE => 16, sfGuardUserPeer::OPT_ALLEGRO_USER_ID => 17, sfGuardUserPeer::WHOLESALE => 18, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'username' => 1, 'algorithm' => 2, 'salt' => 3, 'password' => 4, 'created_at' => 5, 'last_login' => 6, 'is_active' => 7, 'is_super_admin' => 8, 'is_confirm' => 9, 'is_admin_confirm' => 10, 'hash_code' => 11, 'language' => 12, 'external_account' => 13, 'points' => 14, 'points_available' => 15, 'points_release' => 16, 'opt_allegro_user_id' => 17, 'wholesale' => 18, ),
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
		return BasePeer::getMapBuilder('plugins.sfGuardPlugin.lib.model.map.sfGuardUserMapBuilder');
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
			$map = sfGuardUserPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. sfGuardUserPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(sfGuardUserPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(sfGuardUserPeer::ID);

		$criteria->addSelectColumn(sfGuardUserPeer::USERNAME);

		$criteria->addSelectColumn(sfGuardUserPeer::ALGORITHM);

		$criteria->addSelectColumn(sfGuardUserPeer::SALT);

		$criteria->addSelectColumn(sfGuardUserPeer::PASSWORD);

		$criteria->addSelectColumn(sfGuardUserPeer::CREATED_AT);

		$criteria->addSelectColumn(sfGuardUserPeer::LAST_LOGIN);

		$criteria->addSelectColumn(sfGuardUserPeer::IS_ACTIVE);

		$criteria->addSelectColumn(sfGuardUserPeer::IS_SUPER_ADMIN);

		$criteria->addSelectColumn(sfGuardUserPeer::IS_CONFIRM);

		$criteria->addSelectColumn(sfGuardUserPeer::IS_ADMIN_CONFIRM);

		$criteria->addSelectColumn(sfGuardUserPeer::HASH_CODE);

		$criteria->addSelectColumn(sfGuardUserPeer::LANGUAGE);

		$criteria->addSelectColumn(sfGuardUserPeer::EXTERNAL_ACCOUNT);

		$criteria->addSelectColumn(sfGuardUserPeer::POINTS);

		$criteria->addSelectColumn(sfGuardUserPeer::POINTS_AVAILABLE);

		$criteria->addSelectColumn(sfGuardUserPeer::POINTS_RELEASE);

		$criteria->addSelectColumn(sfGuardUserPeer::OPT_ALLEGRO_USER_ID);

		$criteria->addSelectColumn(sfGuardUserPeer::WHOLESALE);


		if (stEventDispatcher::getInstance()->getListeners('sfGuardUserPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'sfGuardUserPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(sf_guard_user.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_guard_user.ID)';

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
			$criteria->addSelectColumn(sfGuardUserPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfGuardUserPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = sfGuardUserPeer::doSelectRS($criteria, $con);
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
	 * @return     sfGuardUser
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = sfGuardUserPeer::doSelect($critcopy, $con);
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
		return sfGuardUserPeer::populateObjects(sfGuardUserPeer::doSelectRS($criteria, $con));
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
			sfGuardUserPeer::addSelectColumns($criteria);
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
		$cls = sfGuardUserPeer::getOMClass();
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
		return sfGuardUserPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a sfGuardUser or Criteria object.
	 *
	 * @param      mixed $values Criteria or sfGuardUser object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfGuardUserPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfGuardUserPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from sfGuardUser object
		}

		$criteria->remove(sfGuardUserPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BasesfGuardUserPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasesfGuardUserPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a sfGuardUser or Criteria object.
	 *
	 * @param      mixed $values Criteria or sfGuardUser object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfGuardUserPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfGuardUserPeer', $values, $con);
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

			$comparison = $criteria->getComparison(sfGuardUserPeer::ID);
			$selectCriteria->add(sfGuardUserPeer::ID, $criteria->remove(sfGuardUserPeer::ID), $comparison);

		} else { // $values is sfGuardUser object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasesfGuardUserPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasesfGuardUserPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the sf_guard_user table.
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
			$affectedRows += sfGuardUserPeer::doOnDeleteCascade(new Criteria(), $con);
			sfGuardUserPeer::doOnDeleteSetNull(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(sfGuardUserPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a sfGuardUser or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or sfGuardUser object or primary key or array of primary keys
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
			$con = Propel::getConnection(sfGuardUserPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof sfGuardUser) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(sfGuardUserPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += sfGuardUserPeer::doOnDeleteCascade($criteria, $con);sfGuardUserPeer::doOnDeleteSetNull($criteria, $con);
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
		$objects = sfGuardUserPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related Dashboard objects
			$c = new Criteria();
			
			$c->add(DashboardPeer::SF_GUARD_USER_ID, $obj->getId());
			$affectedRows += DashboardPeer::doDelete($c, $con);

			// delete related AdminGeneratorFilter objects
			$c = new Criteria();
			
			$c->add(AdminGeneratorFilterPeer::GUARD_USER_ID, $obj->getId());
			$affectedRows += AdminGeneratorFilterPeer::doDelete($c, $con);

			// delete related UserPoints objects
			$c = new Criteria();
			
			$c->add(UserPointsPeer::ADMIN_ID, $obj->getId());
			$affectedRows += UserPointsPeer::doDelete($c, $con);

			// delete related UserHasDiscount objects
			$c = new Criteria();
			
			$c->add(UserHasDiscountPeer::SF_GUARD_USER_ID, $obj->getId());
			$affectedRows += UserHasDiscountPeer::doDelete($c, $con);

			// delete related DiscountUser objects
			$c = new Criteria();
			
			$c->add(DiscountUserPeer::SF_GUARD_USER_ID, $obj->getId());
			$affectedRows += DiscountUserPeer::doDelete($c, $con);

			// delete related DiscountCouponCode objects
			$c = new Criteria();
			
			$c->add(DiscountCouponCodePeer::SF_GUARD_USER_ID, $obj->getId());
			$affectedRows += DiscountCouponCodePeer::doDelete($c, $con);

			// delete related ThemeLayout objects
			$c = new Criteria();
			
			$c->add(ThemeLayoutPeer::SF_GUARD_USER_ID, $obj->getId());
			$affectedRows += ThemeLayoutPeer::doDelete($c, $con);

			// delete related Review objects
			$c = new Criteria();
			
			$c->add(ReviewPeer::SF_GUARD_USER_ID, $obj->getId());
			$affectedRows += ReviewPeer::doDelete($c, $con);

			// delete related ReviewOrder objects
			$c = new Criteria();
			
			$c->add(ReviewOrderPeer::SF_GUARD_USER_ID, $obj->getId());
			$affectedRows += ReviewOrderPeer::doDelete($c, $con);

			// delete related UserData objects
			$c = new Criteria();
			
			$c->add(UserDataPeer::SF_GUARD_USER_ID, $obj->getId());
			$affectedRows += UserDataPeer::doDelete($c, $con);

			// delete related sfGuardUserPermission objects
			$c = new Criteria();
			
			$c->add(sfGuardUserPermissionPeer::USER_ID, $obj->getId());
			$affectedRows += sfGuardUserPermissionPeer::doDelete($c, $con);

			// delete related sfGuardUserGroup objects
			$c = new Criteria();
			
			$c->add(sfGuardUserGroupPeer::USER_ID, $obj->getId());
			$affectedRows += sfGuardUserGroupPeer::doDelete($c, $con);

			// delete related sfGuardRememberKey objects
			$c = new Criteria();
			
			$c->add(sfGuardRememberKeyPeer::USER_ID, $obj->getId());
			$affectedRows += sfGuardRememberKeyPeer::doDelete($c, $con);

			// delete related sfGuardUserModulePermission objects
			$c = new Criteria();
			
			$c->add(sfGuardUserModulePermissionPeer::ID, $obj->getId());
			$affectedRows += sfGuardUserModulePermissionPeer::doDelete($c, $con);

			// delete related Basket objects
			$c = new Criteria();
			
			$c->add(BasketPeer::SF_GUARD_USER_ID, $obj->getId());
			$affectedRows += BasketPeer::doDelete($c, $con);
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
		$objects = sfGuardUserPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {

			// set fkey col in related Order rows to NULL
			$selectCriteria = new Criteria(sfGuardUserPeer::DATABASE_NAME);
			$updateValues = new Criteria(sfGuardUserPeer::DATABASE_NAME);
			$selectCriteria->add(OrderPeer::SF_GUARD_USER_ID, $obj->getId());
			$updateValues->add(OrderPeer::SF_GUARD_USER_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related NewsletterUser rows to NULL
			$selectCriteria = new Criteria(sfGuardUserPeer::DATABASE_NAME);
			$updateValues = new Criteria(sfGuardUserPeer::DATABASE_NAME);
			$selectCriteria->add(NewsletterUserPeer::SF_GUARD_USER_ID, $obj->getId());
			$updateValues->add(NewsletterUserPeer::SF_GUARD_USER_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

		}
	}

	/**
	 * Validates all modified columns of given sfGuardUser object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      sfGuardUser $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(sfGuardUser $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfGuardUserPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfGuardUserPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(sfGuardUserPeer::DATABASE_NAME, sfGuardUserPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfGuardUserPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     sfGuardUser
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(sfGuardUserPeer::DATABASE_NAME);

		$criteria->add(sfGuardUserPeer::ID, $pk);


		$v = sfGuardUserPeer::doSelect($criteria, $con);

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
			$criteria->add(sfGuardUserPeer::ID, $pks, Criteria::IN);
			$objs = sfGuardUserPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BasesfGuardUserPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BasesfGuardUserPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.sfGuardPlugin.lib.model.map.sfGuardUserMapBuilder');
}
