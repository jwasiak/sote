<?php

/**
 * Base static class for performing query and update operations on the 'st_blog' table.
 *
 * 
 *
 * @package    plugins.stBlogPlugin.lib.model.om
 */
abstract class BaseBlogPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_blog';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stBlogPlugin.lib.model.Blog';

	/** The total number of columns. */
	const NUM_COLUMNS = 13;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_blog.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_blog.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_blog.ID';

	/** the column name for the SF_ASSET_ID field */
	const SF_ASSET_ID = 'st_blog.SF_ASSET_ID';

	/** the column name for the ACTIVE field */
	const ACTIVE = 'st_blog.ACTIVE';

	/** the column name for the OPT_NAME field */
	const OPT_NAME = 'st_blog.OPT_NAME';

	/** the column name for the OPT_SHORT_DESCRIPTION field */
	const OPT_SHORT_DESCRIPTION = 'st_blog.OPT_SHORT_DESCRIPTION';

	/** the column name for the OPT_LONG_DESCRIPTION field */
	const OPT_LONG_DESCRIPTION = 'st_blog.OPT_LONG_DESCRIPTION';

	/** the column name for the IMAGE_MAIN_PAGE field */
	const IMAGE_MAIN_PAGE = 'st_blog.IMAGE_MAIN_PAGE';

	/** the column name for the IMAGE field */
	const IMAGE = 'st_blog.IMAGE';

	/** the column name for the OPT_URL field */
	const OPT_URL = 'st_blog.OPT_URL';

	/** the column name for the ALTERNATIVE_URL field */
	const ALTERNATIVE_URL = 'st_blog.ALTERNATIVE_URL';

	/** the column name for the GALLERY field */
	const GALLERY = 'st_blog.GALLERY';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'SfAssetId', 'Active', 'OptName', 'OptShortDescription', 'OptLongDescription', 'ImageMainPage', 'Image', 'OptUrl', 'AlternativeUrl', 'Gallery', ),
		BasePeer::TYPE_COLNAME => array (BlogPeer::CREATED_AT, BlogPeer::UPDATED_AT, BlogPeer::ID, BlogPeer::SF_ASSET_ID, BlogPeer::ACTIVE, BlogPeer::OPT_NAME, BlogPeer::OPT_SHORT_DESCRIPTION, BlogPeer::OPT_LONG_DESCRIPTION, BlogPeer::IMAGE_MAIN_PAGE, BlogPeer::IMAGE, BlogPeer::OPT_URL, BlogPeer::ALTERNATIVE_URL, BlogPeer::GALLERY, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'sf_asset_id', 'active', 'opt_name', 'opt_short_description', 'opt_long_description', 'image_main_page', 'image', 'opt_url', 'alternative_url', 'gallery', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'SfAssetId' => 3, 'Active' => 4, 'OptName' => 5, 'OptShortDescription' => 6, 'OptLongDescription' => 7, 'ImageMainPage' => 8, 'Image' => 9, 'OptUrl' => 10, 'AlternativeUrl' => 11, 'Gallery' => 12, ),
		BasePeer::TYPE_COLNAME => array (BlogPeer::CREATED_AT => 0, BlogPeer::UPDATED_AT => 1, BlogPeer::ID => 2, BlogPeer::SF_ASSET_ID => 3, BlogPeer::ACTIVE => 4, BlogPeer::OPT_NAME => 5, BlogPeer::OPT_SHORT_DESCRIPTION => 6, BlogPeer::OPT_LONG_DESCRIPTION => 7, BlogPeer::IMAGE_MAIN_PAGE => 8, BlogPeer::IMAGE => 9, BlogPeer::OPT_URL => 10, BlogPeer::ALTERNATIVE_URL => 11, BlogPeer::GALLERY => 12, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'sf_asset_id' => 3, 'active' => 4, 'opt_name' => 5, 'opt_short_description' => 6, 'opt_long_description' => 7, 'image_main_page' => 8, 'image' => 9, 'opt_url' => 10, 'alternative_url' => 11, 'gallery' => 12, ),
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
		return BasePeer::getMapBuilder('plugins.stBlogPlugin.lib.model.map.BlogMapBuilder');
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
			$map = BlogPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. BlogPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(BlogPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(BlogPeer::CREATED_AT);

		$criteria->addSelectColumn(BlogPeer::UPDATED_AT);

		$criteria->addSelectColumn(BlogPeer::ID);

		$criteria->addSelectColumn(BlogPeer::SF_ASSET_ID);

		$criteria->addSelectColumn(BlogPeer::ACTIVE);

		$criteria->addSelectColumn(BlogPeer::OPT_NAME);

		$criteria->addSelectColumn(BlogPeer::OPT_SHORT_DESCRIPTION);

		$criteria->addSelectColumn(BlogPeer::OPT_LONG_DESCRIPTION);

		$criteria->addSelectColumn(BlogPeer::IMAGE_MAIN_PAGE);

		$criteria->addSelectColumn(BlogPeer::IMAGE);

		$criteria->addSelectColumn(BlogPeer::OPT_URL);

		$criteria->addSelectColumn(BlogPeer::ALTERNATIVE_URL);

		$criteria->addSelectColumn(BlogPeer::GALLERY);


		if (stEventDispatcher::getInstance()->getListeners('BlogPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'BlogPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_blog.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_blog.ID)';

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
			$criteria->addSelectColumn(BlogPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(BlogPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = BlogPeer::doSelectRS($criteria, $con);
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
	 * @return     Blog
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = BlogPeer::doSelect($critcopy, $con);
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
		return BlogPeer::populateObjects(BlogPeer::doSelectRS($criteria, $con));
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
			BlogPeer::addSelectColumns($criteria);
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
		$cls = BlogPeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related sfAsset table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinsfAsset(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(BlogPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(BlogPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(BlogPeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$rs = BlogPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Blog objects pre-filled with their sfAsset objects.
	 *
	 * @return     array Array of Blog objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinsfAsset(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		BlogPeer::addSelectColumns($c);

		sfAssetPeer::addSelectColumns($c);

		$c->addJoin(BlogPeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);
		$rs = BlogPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Blog();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getSfAssetId())
                        {

			   $obj2 = new sfAsset();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addBlog($obj1);
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
			$criteria->addSelectColumn(BlogPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(BlogPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(BlogPeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$rs = BlogPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Blog objects pre-filled with all related objects.
	 *
	 * @return     array Array of Blog objects.
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

		BlogPeer::addSelectColumns($c);
		$startcol2 = (BlogPeer::NUM_COLUMNS - BlogPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfAssetPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfAssetPeer::NUM_COLUMNS;

		$c->addJoin(BlogPeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = BlogPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined sfAsset rows
	
			$omClass = sfAssetPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfAsset(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addBlog($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initBlogs();
				$obj2->addBlog($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


     /**
      * Selects a collection of Blog objects pre-filled with their i18n objects.
      *
      * @return array Array of Blog objects.
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
          BlogPeer::addSelectColumns($c);
          BlogI18nPeer::addSelectColumns($c);
       }

      $c->addJoin(BlogPeer::ID, sprintf('%s AND %s = \'%s\'', BlogI18nPeer::ID, BlogI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

      $rs = BlogPeer::doSelectRs($c, $con);

      if (self::$hydrateMethod)
      {
         return call_user_func(self::$hydrateMethod, $rs);
      }

      $results = array();

      while($rs->next()) {

         $obj1 = new Blog();
         $startcol = $obj1->hydrate($rs);
         $obj1->setCulture($culture);

         $obj2 = new BlogI18n();
         $obj2->hydrate($rs, $startcol);

         $obj1->setBlogI18nForCulture($obj2, $culture);
         $obj2->setBlog($obj1);

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
		return BlogPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a Blog or Criteria object.
	 *
	 * @param      mixed $values Criteria or Blog object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseBlogPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseBlogPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from Blog object
		}

		$criteria->remove(BlogPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseBlogPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseBlogPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a Blog or Criteria object.
	 *
	 * @param      mixed $values Criteria or Blog object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseBlogPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseBlogPeer', $values, $con);
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

			$comparison = $criteria->getComparison(BlogPeer::ID);
			$selectCriteria->add(BlogPeer::ID, $criteria->remove(BlogPeer::ID), $comparison);

		} else { // $values is Blog object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseBlogPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseBlogPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_blog table.
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
			$affectedRows += BlogPeer::doOnDeleteCascade(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(BlogPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a Blog or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or Blog object or primary key or array of primary keys
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
			$con = Propel::getConnection(BlogPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof Blog) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(BlogPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += BlogPeer::doOnDeleteCascade($criteria, $con);
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
		$objects = BlogPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related BlogHasBlogCategory objects
			$c = new Criteria();
			
			$c->add(BlogHasBlogCategoryPeer::BLOG_ID, $obj->getId());
			$affectedRows += BlogHasBlogCategoryPeer::doDelete($c, $con);

			// delete related BlogI18n objects
			$c = new Criteria();
			
			$c->add(BlogI18nPeer::ID, $obj->getId());
			$affectedRows += BlogI18nPeer::doDelete($c, $con);

			// delete related BlogHasPositioning objects
			$c = new Criteria();
			
			$c->add(BlogHasPositioningPeer::BLOG_ID, $obj->getId());
			$affectedRows += BlogHasPositioningPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	/**
	 * Validates all modified columns of given Blog object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      Blog $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(Blog $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(BlogPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(BlogPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(BlogPeer::DATABASE_NAME, BlogPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = BlogPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     Blog
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(BlogPeer::DATABASE_NAME);

		$criteria->add(BlogPeer::ID, $pk);


		$v = BlogPeer::doSelect($criteria, $con);

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
			$criteria->add(BlogPeer::ID, $pks, Criteria::IN);
			$objs = BlogPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseBlogPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseBlogPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stBlogPlugin.lib.model.map.BlogMapBuilder');
}
