<?php

/**
 * Base static class for performing query and update operations on the 'st_newsletter_user_has_newsletter_group' table.
 *
 * 
 *
 * @package    plugins.stNewsletterPlugin.lib.model.om
 */
abstract class BaseNewsletterUserHasNewsletterGroupPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_newsletter_user_has_newsletter_group';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stNewsletterPlugin.lib.model.NewsletterUserHasNewsletterGroup';

	/** The total number of columns. */
	const NUM_COLUMNS = 5;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_newsletter_user_has_newsletter_group.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_newsletter_user_has_newsletter_group.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_newsletter_user_has_newsletter_group.ID';

	/** the column name for the NEWSLETTER_GROUP_ID field */
	const NEWSLETTER_GROUP_ID = 'st_newsletter_user_has_newsletter_group.NEWSLETTER_GROUP_ID';

	/** the column name for the NEWSLETTER_USER_ID field */
	const NEWSLETTER_USER_ID = 'st_newsletter_user_has_newsletter_group.NEWSLETTER_USER_ID';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'NewsletterGroupId', 'NewsletterUserId', ),
		BasePeer::TYPE_COLNAME => array (NewsletterUserHasNewsletterGroupPeer::CREATED_AT, NewsletterUserHasNewsletterGroupPeer::UPDATED_AT, NewsletterUserHasNewsletterGroupPeer::ID, NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'newsletter_group_id', 'newsletter_user_id', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'NewsletterGroupId' => 3, 'NewsletterUserId' => 4, ),
		BasePeer::TYPE_COLNAME => array (NewsletterUserHasNewsletterGroupPeer::CREATED_AT => 0, NewsletterUserHasNewsletterGroupPeer::UPDATED_AT => 1, NewsletterUserHasNewsletterGroupPeer::ID => 2, NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID => 3, NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID => 4, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'newsletter_group_id' => 3, 'newsletter_user_id' => 4, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
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
		return BasePeer::getMapBuilder('plugins.stNewsletterPlugin.lib.model.map.NewsletterUserHasNewsletterGroupMapBuilder');
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
			$map = NewsletterUserHasNewsletterGroupPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. NewsletterUserHasNewsletterGroupPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(NewsletterUserHasNewsletterGroupPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::CREATED_AT);

		$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::UPDATED_AT);

		$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::ID);

		$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID);

		$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID);


		if (stEventDispatcher::getInstance()->getListeners('NewsletterUserHasNewsletterGroupPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'NewsletterUserHasNewsletterGroupPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_newsletter_user_has_newsletter_group.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_newsletter_user_has_newsletter_group.ID)';

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
			$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = NewsletterUserHasNewsletterGroupPeer::doSelectRS($criteria, $con);
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
	 * @return     NewsletterUserHasNewsletterGroup
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = NewsletterUserHasNewsletterGroupPeer::doSelect($critcopy, $con);
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
		return NewsletterUserHasNewsletterGroupPeer::populateObjects(NewsletterUserHasNewsletterGroupPeer::doSelectRS($criteria, $con));
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
			NewsletterUserHasNewsletterGroupPeer::addSelectColumns($criteria);
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
		$cls = NewsletterUserHasNewsletterGroupPeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related NewsletterGroup table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinNewsletterGroup(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, NewsletterGroupPeer::ID);

		$rs = NewsletterUserHasNewsletterGroupPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related NewsletterUser table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinNewsletterUser(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, NewsletterUserPeer::ID);

		$rs = NewsletterUserHasNewsletterGroupPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of NewsletterUserHasNewsletterGroup objects pre-filled with their NewsletterGroup objects.
	 *
	 * @return     array Array of NewsletterUserHasNewsletterGroup objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinNewsletterGroup(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		NewsletterUserHasNewsletterGroupPeer::addSelectColumns($c);

		NewsletterGroupPeer::addSelectColumns($c);

		$c->addJoin(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, NewsletterGroupPeer::ID);
		$rs = NewsletterUserHasNewsletterGroupPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new NewsletterUserHasNewsletterGroup();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getNewsletterGroupId())
                        {

			   $obj2 = new NewsletterGroup();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addNewsletterUserHasNewsletterGroup($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of NewsletterUserHasNewsletterGroup objects pre-filled with their NewsletterUser objects.
	 *
	 * @return     array Array of NewsletterUserHasNewsletterGroup objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinNewsletterUser(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		NewsletterUserHasNewsletterGroupPeer::addSelectColumns($c);

		NewsletterUserPeer::addSelectColumns($c);

		$c->addJoin(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, NewsletterUserPeer::ID);
		$rs = NewsletterUserHasNewsletterGroupPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new NewsletterUserHasNewsletterGroup();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getNewsletterUserId())
                        {

			   $obj2 = new NewsletterUser();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addNewsletterUserHasNewsletterGroup($obj1);
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
			$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, NewsletterGroupPeer::ID);

		$criteria->addJoin(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, NewsletterUserPeer::ID);

		$rs = NewsletterUserHasNewsletterGroupPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of NewsletterUserHasNewsletterGroup objects pre-filled with all related objects.
	 *
	 * @return     array Array of NewsletterUserHasNewsletterGroup objects.
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

		NewsletterUserHasNewsletterGroupPeer::addSelectColumns($c);
		$startcol2 = (NewsletterUserHasNewsletterGroupPeer::NUM_COLUMNS - NewsletterUserHasNewsletterGroupPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		NewsletterGroupPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + NewsletterGroupPeer::NUM_COLUMNS;

		NewsletterUserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + NewsletterUserPeer::NUM_COLUMNS;

		$c->addJoin(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, NewsletterGroupPeer::ID);

		$c->addJoin(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, NewsletterUserPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = NewsletterUserHasNewsletterGroupPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined NewsletterGroup rows
	
			$omClass = NewsletterGroupPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getNewsletterGroup(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addNewsletterUserHasNewsletterGroup($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initNewsletterUserHasNewsletterGroups();
				$obj2->addNewsletterUserHasNewsletterGroup($obj1);
			}


				// Add objects for joined NewsletterUser rows
	
			$omClass = NewsletterUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getNewsletterUser(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addNewsletterUserHasNewsletterGroup($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initNewsletterUserHasNewsletterGroups();
				$obj3->addNewsletterUserHasNewsletterGroup($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related NewsletterGroup table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptNewsletterGroup(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, NewsletterUserPeer::ID);

		$rs = NewsletterUserHasNewsletterGroupPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related NewsletterUser table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptNewsletterUser(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(NewsletterUserHasNewsletterGroupPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, NewsletterGroupPeer::ID);

		$rs = NewsletterUserHasNewsletterGroupPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of NewsletterUserHasNewsletterGroup objects pre-filled with all related objects except NewsletterGroup.
	 *
	 * @return     array Array of NewsletterUserHasNewsletterGroup objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptNewsletterGroup(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		NewsletterUserHasNewsletterGroupPeer::addSelectColumns($c);
		$startcol2 = (NewsletterUserHasNewsletterGroupPeer::NUM_COLUMNS - NewsletterUserHasNewsletterGroupPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		NewsletterUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + NewsletterUserPeer::NUM_COLUMNS;

		$c->addJoin(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, NewsletterUserPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = NewsletterUserHasNewsletterGroupPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = NewsletterUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getNewsletterUser(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addNewsletterUserHasNewsletterGroup($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initNewsletterUserHasNewsletterGroups();
				$obj2->addNewsletterUserHasNewsletterGroup($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of NewsletterUserHasNewsletterGroup objects pre-filled with all related objects except NewsletterUser.
	 *
	 * @return     array Array of NewsletterUserHasNewsletterGroup objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptNewsletterUser(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		NewsletterUserHasNewsletterGroupPeer::addSelectColumns($c);
		$startcol2 = (NewsletterUserHasNewsletterGroupPeer::NUM_COLUMNS - NewsletterUserHasNewsletterGroupPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		NewsletterGroupPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + NewsletterGroupPeer::NUM_COLUMNS;

		$c->addJoin(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, NewsletterGroupPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = NewsletterUserHasNewsletterGroupPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = NewsletterGroupPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getNewsletterGroup(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addNewsletterUserHasNewsletterGroup($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initNewsletterUserHasNewsletterGroups();
				$obj2->addNewsletterUserHasNewsletterGroup($obj1);
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
		return NewsletterUserHasNewsletterGroupPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a NewsletterUserHasNewsletterGroup or Criteria object.
	 *
	 * @param      mixed $values Criteria or NewsletterUserHasNewsletterGroup object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseNewsletterUserHasNewsletterGroupPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseNewsletterUserHasNewsletterGroupPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from NewsletterUserHasNewsletterGroup object
		}

		$criteria->remove(NewsletterUserHasNewsletterGroupPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseNewsletterUserHasNewsletterGroupPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseNewsletterUserHasNewsletterGroupPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a NewsletterUserHasNewsletterGroup or Criteria object.
	 *
	 * @param      mixed $values Criteria or NewsletterUserHasNewsletterGroup object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseNewsletterUserHasNewsletterGroupPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseNewsletterUserHasNewsletterGroupPeer', $values, $con);
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

			$comparison = $criteria->getComparison(NewsletterUserHasNewsletterGroupPeer::ID);
			$selectCriteria->add(NewsletterUserHasNewsletterGroupPeer::ID, $criteria->remove(NewsletterUserHasNewsletterGroupPeer::ID), $comparison);

		} else { // $values is NewsletterUserHasNewsletterGroup object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseNewsletterUserHasNewsletterGroupPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseNewsletterUserHasNewsletterGroupPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_newsletter_user_has_newsletter_group table.
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
			$affectedRows += BasePeer::doDeleteAll(NewsletterUserHasNewsletterGroupPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a NewsletterUserHasNewsletterGroup or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or NewsletterUserHasNewsletterGroup object or primary key or array of primary keys
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
			$con = Propel::getConnection(NewsletterUserHasNewsletterGroupPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof NewsletterUserHasNewsletterGroup) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(NewsletterUserHasNewsletterGroupPeer::ID, (array) $values, Criteria::IN);
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
	 * Validates all modified columns of given NewsletterUserHasNewsletterGroup object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      NewsletterUserHasNewsletterGroup $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(NewsletterUserHasNewsletterGroup $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(NewsletterUserHasNewsletterGroupPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(NewsletterUserHasNewsletterGroupPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(NewsletterUserHasNewsletterGroupPeer::DATABASE_NAME, NewsletterUserHasNewsletterGroupPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = NewsletterUserHasNewsletterGroupPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     NewsletterUserHasNewsletterGroup
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(NewsletterUserHasNewsletterGroupPeer::DATABASE_NAME);

		$criteria->add(NewsletterUserHasNewsletterGroupPeer::ID, $pk);


		$v = NewsletterUserHasNewsletterGroupPeer::doSelect($criteria, $con);

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
			$criteria->add(NewsletterUserHasNewsletterGroupPeer::ID, $pks, Criteria::IN);
			$objs = NewsletterUserHasNewsletterGroupPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseNewsletterUserHasNewsletterGroupPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseNewsletterUserHasNewsletterGroupPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stNewsletterPlugin.lib.model.map.NewsletterUserHasNewsletterGroupMapBuilder');
}
