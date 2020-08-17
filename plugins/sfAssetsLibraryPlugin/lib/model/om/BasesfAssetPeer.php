<?php

/**
 * Base static class for performing query and update operations on the 'sf_asset' table.
 *
 * 
 *
 * @package    plugins.sfAssetsLibraryPlugin.lib.model.om
 */
abstract class BasesfAssetPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'sf_asset';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.sfAssetsLibraryPlugin.lib.model.sfAsset';

	/** The total number of columns. */
	const NUM_COLUMNS = 10;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the ID field */
	const ID = 'sf_asset.ID';

	/** the column name for the FOLDER_ID field */
	const FOLDER_ID = 'sf_asset.FOLDER_ID';

	/** the column name for the FILENAME field */
	const FILENAME = 'sf_asset.FILENAME';

	/** the column name for the OPT_DESCRIPTION field */
	const OPT_DESCRIPTION = 'sf_asset.OPT_DESCRIPTION';

	/** the column name for the AUTHOR field */
	const AUTHOR = 'sf_asset.AUTHOR';

	/** the column name for the COPYRIGHT field */
	const COPYRIGHT = 'sf_asset.COPYRIGHT';

	/** the column name for the TYPE field */
	const TYPE = 'sf_asset.TYPE';

	/** the column name for the FILESIZE field */
	const FILESIZE = 'sf_asset.FILESIZE';

	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'sf_asset.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'sf_asset.UPDATED_AT';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'FolderId', 'Filename', 'OptDescription', 'Author', 'Copyright', 'Type', 'Filesize', 'CreatedAt', 'UpdatedAt', ),
		BasePeer::TYPE_COLNAME => array (sfAssetPeer::ID, sfAssetPeer::FOLDER_ID, sfAssetPeer::FILENAME, sfAssetPeer::OPT_DESCRIPTION, sfAssetPeer::AUTHOR, sfAssetPeer::COPYRIGHT, sfAssetPeer::TYPE, sfAssetPeer::FILESIZE, sfAssetPeer::CREATED_AT, sfAssetPeer::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'folder_id', 'filename', 'opt_description', 'author', 'copyright', 'type', 'filesize', 'created_at', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'FolderId' => 1, 'Filename' => 2, 'OptDescription' => 3, 'Author' => 4, 'Copyright' => 5, 'Type' => 6, 'Filesize' => 7, 'CreatedAt' => 8, 'UpdatedAt' => 9, ),
		BasePeer::TYPE_COLNAME => array (sfAssetPeer::ID => 0, sfAssetPeer::FOLDER_ID => 1, sfAssetPeer::FILENAME => 2, sfAssetPeer::OPT_DESCRIPTION => 3, sfAssetPeer::AUTHOR => 4, sfAssetPeer::COPYRIGHT => 5, sfAssetPeer::TYPE => 6, sfAssetPeer::FILESIZE => 7, sfAssetPeer::CREATED_AT => 8, sfAssetPeer::UPDATED_AT => 9, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'folder_id' => 1, 'filename' => 2, 'opt_description' => 3, 'author' => 4, 'copyright' => 5, 'type' => 6, 'filesize' => 7, 'created_at' => 8, 'updated_at' => 9, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
		return BasePeer::getMapBuilder('plugins.sfAssetsLibraryPlugin.lib.model.map.sfAssetMapBuilder');
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
			$map = sfAssetPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. sfAssetPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(sfAssetPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(sfAssetPeer::ID);

		$criteria->addSelectColumn(sfAssetPeer::FOLDER_ID);

		$criteria->addSelectColumn(sfAssetPeer::FILENAME);

		$criteria->addSelectColumn(sfAssetPeer::OPT_DESCRIPTION);

		$criteria->addSelectColumn(sfAssetPeer::AUTHOR);

		$criteria->addSelectColumn(sfAssetPeer::COPYRIGHT);

		$criteria->addSelectColumn(sfAssetPeer::TYPE);

		$criteria->addSelectColumn(sfAssetPeer::FILESIZE);

		$criteria->addSelectColumn(sfAssetPeer::CREATED_AT);

		$criteria->addSelectColumn(sfAssetPeer::UPDATED_AT);


		if (stEventDispatcher::getInstance()->getListeners('sfAssetPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'sfAssetPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(sf_asset.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_asset.ID)';

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
			$criteria->addSelectColumn(sfAssetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfAssetPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = sfAssetPeer::doSelectRS($criteria, $con);
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
	 * @return     sfAsset
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = sfAssetPeer::doSelect($critcopy, $con);
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
		return sfAssetPeer::populateObjects(sfAssetPeer::doSelectRS($criteria, $con));
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
			sfAssetPeer::addSelectColumns($criteria);
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
		$cls = sfAssetPeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related sfAssetFolder table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinsfAssetFolder(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfAssetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfAssetPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfAssetPeer::FOLDER_ID, sfAssetFolderPeer::ID);

		$rs = sfAssetPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of sfAsset objects pre-filled with their sfAssetFolder objects.
	 *
	 * @return     array Array of sfAsset objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinsfAssetFolder(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfAssetPeer::addSelectColumns($c);

		sfAssetFolderPeer::addSelectColumns($c);

		$c->addJoin(sfAssetPeer::FOLDER_ID, sfAssetFolderPeer::ID);
		$rs = sfAssetPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new sfAsset();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getFolderId())
                        {

			   $obj2 = new sfAssetFolder();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addsfAsset($obj1);
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
			$criteria->addSelectColumn(sfAssetPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfAssetPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfAssetPeer::FOLDER_ID, sfAssetFolderPeer::ID);

		$rs = sfAssetPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of sfAsset objects pre-filled with all related objects.
	 *
	 * @return     array Array of sfAsset objects.
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

		sfAssetPeer::addSelectColumns($c);
		$startcol2 = (sfAssetPeer::NUM_COLUMNS - sfAssetPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfAssetFolderPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfAssetFolderPeer::NUM_COLUMNS;

		$c->addJoin(sfAssetPeer::FOLDER_ID, sfAssetFolderPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = sfAssetPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined sfAssetFolder rows
	
			$omClass = sfAssetFolderPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfAssetFolder(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addsfAsset($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initsfAssets();
				$obj2->addsfAsset($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


     /**
      * Selects a collection of sfAsset objects pre-filled with their i18n objects.
      *
      * @return array Array of sfAsset objects.
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
          sfAssetPeer::addSelectColumns($c);
          sfAssetI18nPeer::addSelectColumns($c);
       }

      $c->addJoin(sfAssetPeer::ID, sprintf('%s AND %s = \'%s\'', sfAssetI18nPeer::ID, sfAssetI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

      $rs = sfAssetPeer::doSelectRs($c, $con);

      if (self::$hydrateMethod)
      {
         return call_user_func(self::$hydrateMethod, $rs);
      }

      $results = array();

      while($rs->next()) {

         $obj1 = new sfAsset();
         $startcol = $obj1->hydrate($rs);
         $obj1->setCulture($culture);

         $obj2 = new sfAssetI18n();
         $obj2->hydrate($rs, $startcol);

         $obj1->setsfAssetI18nForCulture($obj2, $culture);
         $obj2->setsfAsset($obj1);

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
		return sfAssetPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a sfAsset or Criteria object.
	 *
	 * @param      mixed $values Criteria or sfAsset object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfAssetPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfAssetPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from sfAsset object
		}

		$criteria->remove(sfAssetPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BasesfAssetPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasesfAssetPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a sfAsset or Criteria object.
	 *
	 * @param      mixed $values Criteria or sfAsset object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfAssetPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfAssetPeer', $values, $con);
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

			$comparison = $criteria->getComparison(sfAssetPeer::ID);
			$selectCriteria->add(sfAssetPeer::ID, $criteria->remove(sfAssetPeer::ID), $comparison);

		} else { // $values is sfAsset object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasesfAssetPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasesfAssetPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the sf_asset table.
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
			$affectedRows += sfAssetPeer::doOnDeleteCascade(new Criteria(), $con);
			sfAssetPeer::doOnDeleteSetNull(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(sfAssetPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a sfAsset or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or sfAsset object or primary key or array of primary keys
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
			$con = Propel::getConnection(sfAssetPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof sfAsset) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(sfAssetPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += sfAssetPeer::doOnDeleteCascade($criteria, $con);sfAssetPeer::doOnDeleteSetNull($criteria, $con);
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
		$objects = sfAssetPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related sfAssetI18n objects
			$c = new Criteria();
			
			$c->add(sfAssetI18nPeer::ID, $obj->getId());
			$affectedRows += sfAssetI18nPeer::doDelete($c, $con);

			// delete related ProductHasSfAsset objects
			$c = new Criteria();
			
			$c->add(ProductHasSfAssetPeer::SF_ASSET_ID, $obj->getId());
			$affectedRows += ProductHasSfAssetPeer::doDelete($c, $con);

			// delete related ProductHasAttachment objects
			$c = new Criteria();
			
			$c->add(ProductHasAttachmentPeer::SF_ASSET_ID, $obj->getId());
			$affectedRows += ProductHasAttachmentPeer::doDelete($c, $con);
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
		$objects = sfAssetPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {

			// set fkey col in related Category rows to NULL
			$selectCriteria = new Criteria(sfAssetPeer::DATABASE_NAME);
			$updateValues = new Criteria(sfAssetPeer::DATABASE_NAME);
			$selectCriteria->add(CategoryPeer::SF_ASSET_ID, $obj->getId());
			$updateValues->add(CategoryPeer::SF_ASSET_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related ProductOptionsValue rows to NULL
			$selectCriteria = new Criteria(sfAssetPeer::DATABASE_NAME);
			$updateValues = new Criteria(sfAssetPeer::DATABASE_NAME);
			$selectCriteria->add(ProductOptionsValuePeer::SF_ASSET_ID, $obj->getId());
			$updateValues->add(ProductOptionsValuePeer::SF_ASSET_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Producer rows to NULL
			$selectCriteria = new Criteria(sfAssetPeer::DATABASE_NAME);
			$updateValues = new Criteria(sfAssetPeer::DATABASE_NAME);
			$selectCriteria->add(ProducerPeer::SF_ASSET_ID, $obj->getId());
			$updateValues->add(ProducerPeer::SF_ASSET_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Blog rows to NULL
			$selectCriteria = new Criteria(sfAssetPeer::DATABASE_NAME);
			$updateValues = new Criteria(sfAssetPeer::DATABASE_NAME);
			$selectCriteria->add(BlogPeer::SF_ASSET_ID, $obj->getId());
			$updateValues->add(BlogPeer::SF_ASSET_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Availability rows to NULL
			$selectCriteria = new Criteria(sfAssetPeer::DATABASE_NAME);
			$updateValues = new Criteria(sfAssetPeer::DATABASE_NAME);
			$selectCriteria->add(AvailabilityPeer::SF_ASSET_ID, $obj->getId());
			$updateValues->add(AvailabilityPeer::SF_ASSET_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

		}
	}

	/**
	 * Validates all modified columns of given sfAsset object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      sfAsset $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(sfAsset $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfAssetPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfAssetPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(sfAssetPeer::DATABASE_NAME, sfAssetPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfAssetPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     sfAsset
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(sfAssetPeer::DATABASE_NAME);

		$criteria->add(sfAssetPeer::ID, $pk);


		$v = sfAssetPeer::doSelect($criteria, $con);

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
			$criteria->add(sfAssetPeer::ID, $pks, Criteria::IN);
			$objs = sfAssetPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BasesfAssetPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BasesfAssetPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.sfAssetsLibraryPlugin.lib.model.map.sfAssetMapBuilder');
}
