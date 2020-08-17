<?php

/**
 * Base static class for performing query and update operations on the 'st_category' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseCategoryPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_category';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.Category';

	/** The total number of columns. */
	const NUM_COLUMNS = 20;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_category.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_category.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_category.ID';

	/** the column name for the OPT_IMAGE field */
	const OPT_IMAGE = 'st_category.OPT_IMAGE';

	/** the column name for the LFT field */
	const LFT = 'st_category.LFT';

	/** the column name for the RGT field */
	const RGT = 'st_category.RGT';

	/** the column name for the SCOPE field */
	const SCOPE = 'st_category.SCOPE';

	/** the column name for the MAIN_PAGE field */
	const MAIN_PAGE = 'st_category.MAIN_PAGE';

	/** the column name for the PARENT_ID field */
	const PARENT_ID = 'st_category.PARENT_ID';

	/** the column name for the SF_ASSET_ID field */
	const SF_ASSET_ID = 'st_category.SF_ASSET_ID';

	/** the column name for the OPT_NAME field */
	const OPT_NAME = 'st_category.OPT_NAME';

	/** the column name for the OPT_DESCRIPTION field */
	const OPT_DESCRIPTION = 'st_category.OPT_DESCRIPTION';

	/** the column name for the OPT_IMAGE_CROP field */
	const OPT_IMAGE_CROP = 'st_category.OPT_IMAGE_CROP';

	/** the column name for the DEPTH field */
	const DEPTH = 'st_category.DEPTH';

	/** the column name for the ROOT_POSITION field */
	const ROOT_POSITION = 'st_category.ROOT_POSITION';

	/** the column name for the IS_ACTIVE field */
	const IS_ACTIVE = 'st_category.IS_ACTIVE';

	/** the column name for the IS_HIDDEN field */
	const IS_HIDDEN = 'st_category.IS_HIDDEN';

	/** the column name for the SHOW_CHILDREN_PRODUCTS field */
	const SHOW_CHILDREN_PRODUCTS = 'st_category.SHOW_CHILDREN_PRODUCTS';

	/** the column name for the OPT_URL field */
	const OPT_URL = 'st_category.OPT_URL';

	/** the column name for the IS_APP_IMAGE_TAG_ACTIVE field */
	const IS_APP_IMAGE_TAG_ACTIVE = 'st_category.IS_APP_IMAGE_TAG_ACTIVE';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'OptImage', 'Lft', 'Rgt', 'Scope', 'MainPage', 'ParentId', 'SfAssetId', 'OptName', 'OptDescription', 'ImageCrop', 'Depth', 'RootPosition', 'IsActive', 'IsHidden', 'ShowChildrenProducts', 'OptUrl', 'IsAppImageTagActive', ),
		BasePeer::TYPE_COLNAME => array (CategoryPeer::CREATED_AT, CategoryPeer::UPDATED_AT, CategoryPeer::ID, CategoryPeer::OPT_IMAGE, CategoryPeer::LFT, CategoryPeer::RGT, CategoryPeer::SCOPE, CategoryPeer::MAIN_PAGE, CategoryPeer::PARENT_ID, CategoryPeer::SF_ASSET_ID, CategoryPeer::OPT_NAME, CategoryPeer::OPT_DESCRIPTION, CategoryPeer::OPT_IMAGE_CROP, CategoryPeer::DEPTH, CategoryPeer::ROOT_POSITION, CategoryPeer::IS_ACTIVE, CategoryPeer::IS_HIDDEN, CategoryPeer::SHOW_CHILDREN_PRODUCTS, CategoryPeer::OPT_URL, CategoryPeer::IS_APP_IMAGE_TAG_ACTIVE, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'opt_image', 'lft', 'rgt', 'scope', 'main_page', 'parent_id', 'sf_asset_id', 'opt_name', 'opt_description', 'opt_image_crop', 'depth', 'root_position', 'is_active', 'is_hidden', 'show_children_products', 'opt_url', 'is_app_image_tag_active', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'OptImage' => 3, 'Lft' => 4, 'Rgt' => 5, 'Scope' => 6, 'MainPage' => 7, 'ParentId' => 8, 'SfAssetId' => 9, 'OptName' => 10, 'OptDescription' => 11, 'ImageCrop' => 12, 'Depth' => 13, 'RootPosition' => 14, 'IsActive' => 15, 'IsHidden' => 16, 'ShowChildrenProducts' => 17, 'OptUrl' => 18, 'IsAppImageTagActive' => 19, ),
		BasePeer::TYPE_COLNAME => array (CategoryPeer::CREATED_AT => 0, CategoryPeer::UPDATED_AT => 1, CategoryPeer::ID => 2, CategoryPeer::OPT_IMAGE => 3, CategoryPeer::LFT => 4, CategoryPeer::RGT => 5, CategoryPeer::SCOPE => 6, CategoryPeer::MAIN_PAGE => 7, CategoryPeer::PARENT_ID => 8, CategoryPeer::SF_ASSET_ID => 9, CategoryPeer::OPT_NAME => 10, CategoryPeer::OPT_DESCRIPTION => 11, CategoryPeer::OPT_IMAGE_CROP => 12, CategoryPeer::DEPTH => 13, CategoryPeer::ROOT_POSITION => 14, CategoryPeer::IS_ACTIVE => 15, CategoryPeer::IS_HIDDEN => 16, CategoryPeer::SHOW_CHILDREN_PRODUCTS => 17, CategoryPeer::OPT_URL => 18, CategoryPeer::IS_APP_IMAGE_TAG_ACTIVE => 19, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'opt_image' => 3, 'lft' => 4, 'rgt' => 5, 'scope' => 6, 'main_page' => 7, 'parent_id' => 8, 'sf_asset_id' => 9, 'opt_name' => 10, 'opt_description' => 11, 'opt_image_crop' => 12, 'depth' => 13, 'root_position' => 14, 'is_active' => 15, 'is_hidden' => 16, 'show_children_products' => 17, 'opt_url' => 18, 'is_app_image_tag_active' => 19, ),
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
		return BasePeer::getMapBuilder('lib.model.map.CategoryMapBuilder');
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
			$map = CategoryPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. CategoryPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(CategoryPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(CategoryPeer::CREATED_AT);

		$criteria->addSelectColumn(CategoryPeer::UPDATED_AT);

		$criteria->addSelectColumn(CategoryPeer::ID);

		$criteria->addSelectColumn(CategoryPeer::OPT_IMAGE);

		$criteria->addSelectColumn(CategoryPeer::LFT);

		$criteria->addSelectColumn(CategoryPeer::RGT);

		$criteria->addSelectColumn(CategoryPeer::SCOPE);

		$criteria->addSelectColumn(CategoryPeer::MAIN_PAGE);

		$criteria->addSelectColumn(CategoryPeer::PARENT_ID);

		$criteria->addSelectColumn(CategoryPeer::SF_ASSET_ID);

		$criteria->addSelectColumn(CategoryPeer::OPT_NAME);

		$criteria->addSelectColumn(CategoryPeer::OPT_DESCRIPTION);

		$criteria->addSelectColumn(CategoryPeer::OPT_IMAGE_CROP);

		$criteria->addSelectColumn(CategoryPeer::DEPTH);

		$criteria->addSelectColumn(CategoryPeer::ROOT_POSITION);

		$criteria->addSelectColumn(CategoryPeer::IS_ACTIVE);

		$criteria->addSelectColumn(CategoryPeer::IS_HIDDEN);

		$criteria->addSelectColumn(CategoryPeer::SHOW_CHILDREN_PRODUCTS);

		$criteria->addSelectColumn(CategoryPeer::OPT_URL);

		$criteria->addSelectColumn(CategoryPeer::IS_APP_IMAGE_TAG_ACTIVE);


		if (stEventDispatcher::getInstance()->getListeners('CategoryPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'CategoryPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_category.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_category.ID)';

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
			$criteria->addSelectColumn(CategoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(CategoryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = CategoryPeer::doSelectRS($criteria, $con);
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
	 * @return     Category
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = CategoryPeer::doSelect($critcopy, $con);
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
		return CategoryPeer::populateObjects(CategoryPeer::doSelectRS($criteria, $con));
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
			CategoryPeer::addSelectColumns($criteria);
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
		$cls = CategoryPeer::getOMClass();
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
			$criteria->addSelectColumn(CategoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(CategoryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(CategoryPeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$rs = CategoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Category objects pre-filled with their sfAsset objects.
	 *
	 * @return     array Array of Category objects.
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

		CategoryPeer::addSelectColumns($c);

		sfAssetPeer::addSelectColumns($c);

		$c->addJoin(CategoryPeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);
		$rs = CategoryPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Category();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getSfAssetId())
                        {

			   $obj2 = new sfAsset();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addCategory($obj1);
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
			$criteria->addSelectColumn(CategoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(CategoryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(CategoryPeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$rs = CategoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Category objects pre-filled with all related objects.
	 *
	 * @return     array Array of Category objects.
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

		CategoryPeer::addSelectColumns($c);
		$startcol2 = (CategoryPeer::NUM_COLUMNS - CategoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfAssetPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfAssetPeer::NUM_COLUMNS;

		$c->addJoin(CategoryPeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = CategoryPeer::getOMClass();


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
					$temp_obj2->addCategory($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initCategorys();
				$obj2->addCategory($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related CategoryRelatedByParentId table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptCategoryRelatedByParentId(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(CategoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(CategoryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(CategoryPeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);

		$rs = CategoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related sfAsset table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptsfAsset(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(CategoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(CategoryPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = CategoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Category objects pre-filled with all related objects except CategoryRelatedByParentId.
	 *
	 * @return     array Array of Category objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptCategoryRelatedByParentId(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		CategoryPeer::addSelectColumns($c);
		$startcol2 = (CategoryPeer::NUM_COLUMNS - CategoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfAssetPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfAssetPeer::NUM_COLUMNS;

		$c->addJoin(CategoryPeer::SF_ASSET_ID, sfAssetPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = CategoryPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfAssetPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfAsset(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addCategory($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initCategorys();
				$obj2->addCategory($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Category objects pre-filled with all related objects except sfAsset.
	 *
	 * @return     array Array of Category objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptsfAsset(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		CategoryPeer::addSelectColumns($c);
		$startcol2 = (CategoryPeer::NUM_COLUMNS - CategoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = CategoryPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


     /**
      * Selects a collection of Category objects pre-filled with their i18n objects.
      *
      * @return array Array of Category objects.
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
          CategoryPeer::addSelectColumns($c);
          CategoryI18nPeer::addSelectColumns($c);
       }

      $c->addJoin(CategoryPeer::ID, sprintf('%s AND %s = \'%s\'', CategoryI18nPeer::ID, CategoryI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

      $rs = CategoryPeer::doSelectRs($c, $con);

      if (self::$hydrateMethod)
      {
         return call_user_func(self::$hydrateMethod, $rs);
      }

      $results = array();

      while($rs->next()) {

         $obj1 = new Category();
         $startcol = $obj1->hydrate($rs);
         $obj1->setCulture($culture);

         $obj2 = new CategoryI18n();
         $obj2->hydrate($rs, $startcol);

         $obj1->setCategoryI18nForCulture($obj2, $culture);
         $obj2->setCategory($obj1);

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
		return CategoryPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a Category or Criteria object.
	 *
	 * @param      mixed $values Criteria or Category object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseCategoryPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCategoryPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from Category object
		}

		$criteria->remove(CategoryPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseCategoryPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseCategoryPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a Category or Criteria object.
	 *
	 * @param      mixed $values Criteria or Category object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseCategoryPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCategoryPeer', $values, $con);
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

			$comparison = $criteria->getComparison(CategoryPeer::ID);
			$selectCriteria->add(CategoryPeer::ID, $criteria->remove(CategoryPeer::ID), $comparison);

		} else { // $values is Category object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseCategoryPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseCategoryPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_category table.
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
			$affectedRows += CategoryPeer::doOnDeleteCascade(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(CategoryPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a Category or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or Category object or primary key or array of primary keys
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
			$con = Propel::getConnection(CategoryPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof Category) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(CategoryPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += CategoryPeer::doOnDeleteCascade($criteria, $con);
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
		$objects = CategoryPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related DiscountHasCategory objects
			$c = new Criteria();
			
			$c->add(DiscountHasCategoryPeer::CATEGORY_ID, $obj->getId());
			$affectedRows += DiscountHasCategoryPeer::doDelete($c, $con);

			// delete related DiscountCouponCodeHasCategory objects
			$c = new Criteria();
			
			$c->add(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, $obj->getId());
			$affectedRows += DiscountCouponCodeHasCategoryPeer::doDelete($c, $con);

			// delete related CategoryI18n objects
			$c = new Criteria();
			
			$c->add(CategoryI18nPeer::ID, $obj->getId());
			$affectedRows += CategoryI18nPeer::doDelete($c, $con);

			// delete related ProductHasCategory objects
			$c = new Criteria();
			
			$c->add(ProductHasCategoryPeer::CATEGORY_ID, $obj->getId());
			$affectedRows += ProductHasCategoryPeer::doDelete($c, $con);

			// delete related appCategoryImageTag objects
			$c = new Criteria();
			
			$c->add(appCategoryImageTagPeer::ID, $obj->getId());
			$affectedRows += appCategoryImageTagPeer::doDelete($c, $con);

			// delete related appCategoryImageTagGallery objects
			$c = new Criteria();
			
			$c->add(appCategoryImageTagGalleryPeer::CATEGORY_ID, $obj->getId());
			$affectedRows += appCategoryImageTagGalleryPeer::doDelete($c, $con);

			// delete related GiftCardHasCategory objects
			$c = new Criteria();
			
			$c->add(GiftCardHasCategoryPeer::CATEGORY_ID, $obj->getId());
			$affectedRows += GiftCardHasCategoryPeer::doDelete($c, $con);

			// delete related appProductAttributeHasCategory objects
			$c = new Criteria();
			
			$c->add(appProductAttributeHasCategoryPeer::CATEGORY_ID, $obj->getId());
			$affectedRows += appProductAttributeHasCategoryPeer::doDelete($c, $con);

			// delete related CategoryHasPositioning objects
			$c = new Criteria();
			
			$c->add(CategoryHasPositioningPeer::CATEGORY_ID, $obj->getId());
			$affectedRows += CategoryHasPositioningPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	/**
	 * Validates all modified columns of given Category object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      Category $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(Category $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(CategoryPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(CategoryPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(CategoryPeer::DATABASE_NAME, CategoryPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = CategoryPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     Category
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(CategoryPeer::DATABASE_NAME);

		$criteria->add(CategoryPeer::ID, $pk);


		$v = CategoryPeer::doSelect($criteria, $con);

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
			$criteria->add(CategoryPeer::ID, $pks, Criteria::IN);
			$objs = CategoryPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseCategoryPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseCategoryPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('lib.model.map.CategoryMapBuilder');
}
