<?php

/**
 * Base static class for performing query and update operations on the 'st_positioning_i18n' table.
 *
 * 
 *
 * @package    plugins.stPositioningPlugin.lib.model.om
 */
abstract class BasePositioningI18nPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_positioning_i18n';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.stPositioningPlugin.lib.model.PositioningI18n';

	/** The total number of columns. */
	const NUM_COLUMNS = 13;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the ID field */
	const ID = 'st_positioning_i18n.ID';

	/** the column name for the CULTURE field */
	const CULTURE = 'st_positioning_i18n.CULTURE';

	/** the column name for the TITLE field */
	const TITLE = 'st_positioning_i18n.TITLE';

	/** the column name for the KEYWORDS field */
	const KEYWORDS = 'st_positioning_i18n.KEYWORDS';

	/** the column name for the DESCRIPTION field */
	const DESCRIPTION = 'st_positioning_i18n.DESCRIPTION';

	/** the column name for the TITLE_PRODUCT field */
	const TITLE_PRODUCT = 'st_positioning_i18n.TITLE_PRODUCT';

	/** the column name for the TITLE_CATEGORY field */
	const TITLE_CATEGORY = 'st_positioning_i18n.TITLE_CATEGORY';

	/** the column name for the TITLE_MANUFACTEUR field */
	const TITLE_MANUFACTEUR = 'st_positioning_i18n.TITLE_MANUFACTEUR';

	/** the column name for the TITLE_BLOG field */
	const TITLE_BLOG = 'st_positioning_i18n.TITLE_BLOG';

	/** the column name for the TITLE_PRODUCT_GROUP field */
	const TITLE_PRODUCT_GROUP = 'st_positioning_i18n.TITLE_PRODUCT_GROUP';

	/** the column name for the TITLE_WEBPAGE field */
	const TITLE_WEBPAGE = 'st_positioning_i18n.TITLE_WEBPAGE';

	/** the column name for the TYPE field */
	const TYPE = 'st_positioning_i18n.TYPE';

	/** the column name for the DEFAULT_TITLE field */
	const DEFAULT_TITLE = 'st_positioning_i18n.DEFAULT_TITLE';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Culture', 'Title', 'Keywords', 'Description', 'TitleProduct', 'TitleCategory', 'TitleManufacteur', 'TitleBlog', 'TitleProductGroup', 'TitleWebpage', 'Type', 'DefaultTitle', ),
		BasePeer::TYPE_COLNAME => array (PositioningI18nPeer::ID, PositioningI18nPeer::CULTURE, PositioningI18nPeer::TITLE, PositioningI18nPeer::KEYWORDS, PositioningI18nPeer::DESCRIPTION, PositioningI18nPeer::TITLE_PRODUCT, PositioningI18nPeer::TITLE_CATEGORY, PositioningI18nPeer::TITLE_MANUFACTEUR, PositioningI18nPeer::TITLE_BLOG, PositioningI18nPeer::TITLE_PRODUCT_GROUP, PositioningI18nPeer::TITLE_WEBPAGE, PositioningI18nPeer::TYPE, PositioningI18nPeer::DEFAULT_TITLE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'culture', 'title', 'keywords', 'description', 'title_product', 'title_category', 'title_manufacteur', 'title_blog', 'title_product_group', 'title_webpage', 'type', 'default_title', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Culture' => 1, 'Title' => 2, 'Keywords' => 3, 'Description' => 4, 'TitleProduct' => 5, 'TitleCategory' => 6, 'TitleManufacteur' => 7, 'TitleBlog' => 8, 'TitleProductGroup' => 9, 'TitleWebpage' => 10, 'Type' => 11, 'DefaultTitle' => 12, ),
		BasePeer::TYPE_COLNAME => array (PositioningI18nPeer::ID => 0, PositioningI18nPeer::CULTURE => 1, PositioningI18nPeer::TITLE => 2, PositioningI18nPeer::KEYWORDS => 3, PositioningI18nPeer::DESCRIPTION => 4, PositioningI18nPeer::TITLE_PRODUCT => 5, PositioningI18nPeer::TITLE_CATEGORY => 6, PositioningI18nPeer::TITLE_MANUFACTEUR => 7, PositioningI18nPeer::TITLE_BLOG => 8, PositioningI18nPeer::TITLE_PRODUCT_GROUP => 9, PositioningI18nPeer::TITLE_WEBPAGE => 10, PositioningI18nPeer::TYPE => 11, PositioningI18nPeer::DEFAULT_TITLE => 12, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'culture' => 1, 'title' => 2, 'keywords' => 3, 'description' => 4, 'title_product' => 5, 'title_category' => 6, 'title_manufacteur' => 7, 'title_blog' => 8, 'title_product_group' => 9, 'title_webpage' => 10, 'type' => 11, 'default_title' => 12, ),
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
		return BasePeer::getMapBuilder('plugins.stPositioningPlugin.lib.model.map.PositioningI18nMapBuilder');
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
			$map = PositioningI18nPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. PositioningI18nPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(PositioningI18nPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(PositioningI18nPeer::ID);

		$criteria->addSelectColumn(PositioningI18nPeer::CULTURE);

		$criteria->addSelectColumn(PositioningI18nPeer::TITLE);

		$criteria->addSelectColumn(PositioningI18nPeer::KEYWORDS);

		$criteria->addSelectColumn(PositioningI18nPeer::DESCRIPTION);

		$criteria->addSelectColumn(PositioningI18nPeer::TITLE_PRODUCT);

		$criteria->addSelectColumn(PositioningI18nPeer::TITLE_CATEGORY);

		$criteria->addSelectColumn(PositioningI18nPeer::TITLE_MANUFACTEUR);

		$criteria->addSelectColumn(PositioningI18nPeer::TITLE_BLOG);

		$criteria->addSelectColumn(PositioningI18nPeer::TITLE_PRODUCT_GROUP);

		$criteria->addSelectColumn(PositioningI18nPeer::TITLE_WEBPAGE);

		$criteria->addSelectColumn(PositioningI18nPeer::TYPE);

		$criteria->addSelectColumn(PositioningI18nPeer::DEFAULT_TITLE);


		if (stEventDispatcher::getInstance()->getListeners('PositioningI18nPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'PositioningI18nPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_positioning_i18n.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_positioning_i18n.ID)';

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
			$criteria->addSelectColumn(PositioningI18nPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PositioningI18nPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = PositioningI18nPeer::doSelectRS($criteria, $con);
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
	 * @return     PositioningI18n
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = PositioningI18nPeer::doSelect($critcopy, $con);
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
		return PositioningI18nPeer::populateObjects(PositioningI18nPeer::doSelectRS($criteria, $con));
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
			PositioningI18nPeer::addSelectColumns($criteria);
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
		$cls = PositioningI18nPeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related Positioning table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinPositioning(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(PositioningI18nPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PositioningI18nPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(PositioningI18nPeer::ID, PositioningPeer::ID);

		$rs = PositioningI18nPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of PositioningI18n objects pre-filled with their Positioning objects.
	 *
	 * @return     array Array of PositioningI18n objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinPositioning(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		PositioningI18nPeer::addSelectColumns($c);

		PositioningPeer::addSelectColumns($c);

		$c->addJoin(PositioningI18nPeer::ID, PositioningPeer::ID);
		$rs = PositioningI18nPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new PositioningI18n();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getId())
                        {

			   $obj2 = new Positioning();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addPositioningI18n($obj1);
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
			$criteria->addSelectColumn(PositioningI18nPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PositioningI18nPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(PositioningI18nPeer::ID, PositioningPeer::ID);

		$rs = PositioningI18nPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of PositioningI18n objects pre-filled with all related objects.
	 *
	 * @return     array Array of PositioningI18n objects.
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

		PositioningI18nPeer::addSelectColumns($c);
		$startcol2 = (PositioningI18nPeer::NUM_COLUMNS - PositioningI18nPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		PositioningPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + PositioningPeer::NUM_COLUMNS;

		$c->addJoin(PositioningI18nPeer::ID, PositioningPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = PositioningI18nPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined Positioning rows
	
			$omClass = PositioningPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getPositioning(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addPositioningI18n($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initPositioningI18ns();
				$obj2->addPositioningI18n($obj1);
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
		return PositioningI18nPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a PositioningI18n or Criteria object.
	 *
	 * @param      mixed $values Criteria or PositioningI18n object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasePositioningI18nPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasePositioningI18nPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from PositioningI18n object
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

		
    foreach (sfMixer::getCallables('BasePositioningI18nPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasePositioningI18nPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a PositioningI18n or Criteria object.
	 *
	 * @param      mixed $values Criteria or PositioningI18n object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasePositioningI18nPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasePositioningI18nPeer', $values, $con);
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

			$comparison = $criteria->getComparison(PositioningI18nPeer::ID);
			$selectCriteria->add(PositioningI18nPeer::ID, $criteria->remove(PositioningI18nPeer::ID), $comparison);

			$comparison = $criteria->getComparison(PositioningI18nPeer::CULTURE);
			$selectCriteria->add(PositioningI18nPeer::CULTURE, $criteria->remove(PositioningI18nPeer::CULTURE), $comparison);

		} else { // $values is PositioningI18n object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasePositioningI18nPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasePositioningI18nPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_positioning_i18n table.
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
			$affectedRows += BasePeer::doDeleteAll(PositioningI18nPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a PositioningI18n or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or PositioningI18n object or primary key or array of primary keys
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
			$con = Propel::getConnection(PositioningI18nPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof PositioningI18n) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			// primary key is composite; we therefore, expect
			// the primary key passed to be an array of pkey
			// values
			if(count($values) == count($values, COUNT_RECURSIVE))
			{
				// array is not multi-dimensional
				$values = array($values);
			}
			$vals = array();
			foreach($values as $value)
			{

				$vals[0][] = $value[0];
				$vals[1][] = $value[1];
			}

			$criteria->add(PositioningI18nPeer::ID, $vals[0], Criteria::IN);
			$criteria->add(PositioningI18nPeer::CULTURE, $vals[1], Criteria::IN);
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
	 * Validates all modified columns of given PositioningI18n object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      PositioningI18n $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(PositioningI18n $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(PositioningI18nPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(PositioningI18nPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(PositioningI18nPeer::DATABASE_NAME, PositioningI18nPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = PositioningI18nPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	/**
	 * Retrieve object using using composite pkey values.
	 * @param int $id
	   @param string $culture
	   
	 * @param      Connection $con
	 * @return     PositioningI18n
	 */
	public static function retrieveByPK( $id, $culture, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(PositioningI18nPeer::ID, $id);
		$criteria->add(PositioningI18nPeer::CULTURE, $culture);
		$v = PositioningI18nPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} // BasePositioningI18nPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BasePositioningI18nPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('plugins.stPositioningPlugin.lib.model.map.PositioningI18nMapBuilder');
}
