<?php

/**
 * Base static class for performing query and update operations on the 'st_review' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseReviewPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_review';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.Review';

	/** The total number of columns. */
	const NUM_COLUMNS = 27;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_review.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_review.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_review.ID';

	/** the column name for the ORDER_ID field */
	const ORDER_ID = 'st_review.ORDER_ID';

	/** the column name for the SF_GUARD_USER_ID field */
	const SF_GUARD_USER_ID = 'st_review.SF_GUARD_USER_ID';

	/** the column name for the PRODUCT_ID field */
	const PRODUCT_ID = 'st_review.PRODUCT_ID';

	/** the column name for the ACTIVE field */
	const ACTIVE = 'st_review.ACTIVE';

	/** the column name for the SCORE field */
	const SCORE = 'st_review.SCORE';

	/** the column name for the MERCHANT field */
	const MERCHANT = 'st_review.MERCHANT';

	/** the column name for the ADMIN_NAME field */
	const ADMIN_NAME = 'st_review.ADMIN_NAME';

	/** the column name for the ADMIN_ACTIVE field */
	const ADMIN_ACTIVE = 'st_review.ADMIN_ACTIVE';

	/** the column name for the ANONYMOUS field */
	const ANONYMOUS = 'st_review.ANONYMOUS';

	/** the column name for the AGREEMENT field */
	const AGREEMENT = 'st_review.AGREEMENT';

	/** the column name for the SKIPPED field */
	const SKIPPED = 'st_review.SKIPPED';

	/** the column name for the ORDER_NUMBER field */
	const ORDER_NUMBER = 'st_review.ORDER_NUMBER';

	/** the column name for the DESCRIPTION field */
	const DESCRIPTION = 'st_review.DESCRIPTION';

	/** the column name for the USER_IP field */
	const USER_IP = 'st_review.USER_IP';

	/** the column name for the USERNAME field */
	const USERNAME = 'st_review.USERNAME';

	/** the column name for the LANGUAGE field */
	const LANGUAGE = 'st_review.LANGUAGE';

	/** the column name for the IS_PIN_REVIEW field */
	const IS_PIN_REVIEW = 'st_review.IS_PIN_REVIEW';

	/** the column name for the PIN_REVIEW field */
	const PIN_REVIEW = 'st_review.PIN_REVIEW';

	/** the column name for the USER_PICTURE field */
	const USER_PICTURE = 'st_review.USER_PICTURE';

	/** the column name for the USER_FACEBOOK field */
	const USER_FACEBOOK = 'st_review.USER_FACEBOOK';

	/** the column name for the USER_INSTAGRAM field */
	const USER_INSTAGRAM = 'st_review.USER_INSTAGRAM';

	/** the column name for the USER_YOUTUBE field */
	const USER_YOUTUBE = 'st_review.USER_YOUTUBE';

	/** the column name for the USER_TWITTER field */
	const USER_TWITTER = 'st_review.USER_TWITTER';

	/** the column name for the USER_REVIEW_VERIFIED field */
	const USER_REVIEW_VERIFIED = 'st_review.USER_REVIEW_VERIFIED';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'OrderId', 'SfGuardUserId', 'ProductId', 'Active', 'Score', 'Merchant', 'AdminName', 'AdminActive', 'Anonymous', 'Agreement', 'Skipped', 'OrderNumber', 'Description', 'UserIp', 'Username', 'Language', 'IsPinReview', 'PinReview', 'UserPicture', 'UserFacebook', 'UserInstagram', 'UserYoutube', 'UserTwitter', 'UserReviewVerified', ),
		BasePeer::TYPE_COLNAME => array (ReviewPeer::CREATED_AT, ReviewPeer::UPDATED_AT, ReviewPeer::ID, ReviewPeer::ORDER_ID, ReviewPeer::SF_GUARD_USER_ID, ReviewPeer::PRODUCT_ID, ReviewPeer::ACTIVE, ReviewPeer::SCORE, ReviewPeer::MERCHANT, ReviewPeer::ADMIN_NAME, ReviewPeer::ADMIN_ACTIVE, ReviewPeer::ANONYMOUS, ReviewPeer::AGREEMENT, ReviewPeer::SKIPPED, ReviewPeer::ORDER_NUMBER, ReviewPeer::DESCRIPTION, ReviewPeer::USER_IP, ReviewPeer::USERNAME, ReviewPeer::LANGUAGE, ReviewPeer::IS_PIN_REVIEW, ReviewPeer::PIN_REVIEW, ReviewPeer::USER_PICTURE, ReviewPeer::USER_FACEBOOK, ReviewPeer::USER_INSTAGRAM, ReviewPeer::USER_YOUTUBE, ReviewPeer::USER_TWITTER, ReviewPeer::USER_REVIEW_VERIFIED, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'order_id', 'sf_guard_user_id', 'product_id', 'active', 'score', 'merchant', 'admin_name', 'admin_active', 'anonymous', 'agreement', 'skipped', 'order_number', 'description', 'user_ip', 'username', 'language', 'is_pin_review', 'pin_review', 'user_picture', 'user_facebook', 'user_instagram', 'user_youtube', 'user_twitter', 'user_review_verified', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'OrderId' => 3, 'SfGuardUserId' => 4, 'ProductId' => 5, 'Active' => 6, 'Score' => 7, 'Merchant' => 8, 'AdminName' => 9, 'AdminActive' => 10, 'Anonymous' => 11, 'Agreement' => 12, 'Skipped' => 13, 'OrderNumber' => 14, 'Description' => 15, 'UserIp' => 16, 'Username' => 17, 'Language' => 18, 'IsPinReview' => 19, 'PinReview' => 20, 'UserPicture' => 21, 'UserFacebook' => 22, 'UserInstagram' => 23, 'UserYoutube' => 24, 'UserTwitter' => 25, 'UserReviewVerified' => 26, ),
		BasePeer::TYPE_COLNAME => array (ReviewPeer::CREATED_AT => 0, ReviewPeer::UPDATED_AT => 1, ReviewPeer::ID => 2, ReviewPeer::ORDER_ID => 3, ReviewPeer::SF_GUARD_USER_ID => 4, ReviewPeer::PRODUCT_ID => 5, ReviewPeer::ACTIVE => 6, ReviewPeer::SCORE => 7, ReviewPeer::MERCHANT => 8, ReviewPeer::ADMIN_NAME => 9, ReviewPeer::ADMIN_ACTIVE => 10, ReviewPeer::ANONYMOUS => 11, ReviewPeer::AGREEMENT => 12, ReviewPeer::SKIPPED => 13, ReviewPeer::ORDER_NUMBER => 14, ReviewPeer::DESCRIPTION => 15, ReviewPeer::USER_IP => 16, ReviewPeer::USERNAME => 17, ReviewPeer::LANGUAGE => 18, ReviewPeer::IS_PIN_REVIEW => 19, ReviewPeer::PIN_REVIEW => 20, ReviewPeer::USER_PICTURE => 21, ReviewPeer::USER_FACEBOOK => 22, ReviewPeer::USER_INSTAGRAM => 23, ReviewPeer::USER_YOUTUBE => 24, ReviewPeer::USER_TWITTER => 25, ReviewPeer::USER_REVIEW_VERIFIED => 26, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'order_id' => 3, 'sf_guard_user_id' => 4, 'product_id' => 5, 'active' => 6, 'score' => 7, 'merchant' => 8, 'admin_name' => 9, 'admin_active' => 10, 'anonymous' => 11, 'agreement' => 12, 'skipped' => 13, 'order_number' => 14, 'description' => 15, 'user_ip' => 16, 'username' => 17, 'language' => 18, 'is_pin_review' => 19, 'pin_review' => 20, 'user_picture' => 21, 'user_facebook' => 22, 'user_instagram' => 23, 'user_youtube' => 24, 'user_twitter' => 25, 'user_review_verified' => 26, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, )
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
		return BasePeer::getMapBuilder('lib.model.map.ReviewMapBuilder');
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
			$map = ReviewPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. ReviewPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(ReviewPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(ReviewPeer::CREATED_AT);

		$criteria->addSelectColumn(ReviewPeer::UPDATED_AT);

		$criteria->addSelectColumn(ReviewPeer::ID);

		$criteria->addSelectColumn(ReviewPeer::ORDER_ID);

		$criteria->addSelectColumn(ReviewPeer::SF_GUARD_USER_ID);

		$criteria->addSelectColumn(ReviewPeer::PRODUCT_ID);

		$criteria->addSelectColumn(ReviewPeer::ACTIVE);

		$criteria->addSelectColumn(ReviewPeer::SCORE);

		$criteria->addSelectColumn(ReviewPeer::MERCHANT);

		$criteria->addSelectColumn(ReviewPeer::ADMIN_NAME);

		$criteria->addSelectColumn(ReviewPeer::ADMIN_ACTIVE);

		$criteria->addSelectColumn(ReviewPeer::ANONYMOUS);

		$criteria->addSelectColumn(ReviewPeer::AGREEMENT);

		$criteria->addSelectColumn(ReviewPeer::SKIPPED);

		$criteria->addSelectColumn(ReviewPeer::ORDER_NUMBER);

		$criteria->addSelectColumn(ReviewPeer::DESCRIPTION);

		$criteria->addSelectColumn(ReviewPeer::USER_IP);

		$criteria->addSelectColumn(ReviewPeer::USERNAME);

		$criteria->addSelectColumn(ReviewPeer::LANGUAGE);

		$criteria->addSelectColumn(ReviewPeer::IS_PIN_REVIEW);

		$criteria->addSelectColumn(ReviewPeer::PIN_REVIEW);

		$criteria->addSelectColumn(ReviewPeer::USER_PICTURE);

		$criteria->addSelectColumn(ReviewPeer::USER_FACEBOOK);

		$criteria->addSelectColumn(ReviewPeer::USER_INSTAGRAM);

		$criteria->addSelectColumn(ReviewPeer::USER_YOUTUBE);

		$criteria->addSelectColumn(ReviewPeer::USER_TWITTER);

		$criteria->addSelectColumn(ReviewPeer::USER_REVIEW_VERIFIED);


		if (stEventDispatcher::getInstance()->getListeners('ReviewPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'ReviewPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_review.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_review.ID)';

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
			$criteria->addSelectColumn(ReviewPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReviewPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ReviewPeer::doSelectRS($criteria, $con);
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
	 * @return     Review
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = ReviewPeer::doSelect($critcopy, $con);
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
		return ReviewPeer::populateObjects(ReviewPeer::doSelectRS($criteria, $con));
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
			ReviewPeer::addSelectColumns($criteria);
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
		$cls = ReviewPeer::getOMClass();
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
			$criteria->addSelectColumn(ReviewPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReviewPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReviewPeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$rs = ReviewPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related sfGuardUser table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinsfGuardUser(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReviewPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReviewPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReviewPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$rs = ReviewPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Product table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinProduct(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReviewPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReviewPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReviewPeer::PRODUCT_ID, ProductPeer::ID);

		$rs = ReviewPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Review objects pre-filled with their Order objects.
	 *
	 * @return     array Array of Review objects.
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

		ReviewPeer::addSelectColumns($c);

		OrderPeer::addSelectColumns($c);

		$c->addJoin(ReviewPeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);
		$rs = ReviewPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Review();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getOrderId())
                        {

			   $obj2 = new Order();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addReview($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Review objects pre-filled with their sfGuardUser objects.
	 *
	 * @return     array Array of Review objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinsfGuardUser(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReviewPeer::addSelectColumns($c);

		sfGuardUserPeer::addSelectColumns($c);

		$c->addJoin(ReviewPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);
		$rs = ReviewPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Review();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getSfGuardUserId())
                        {

			   $obj2 = new sfGuardUser();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addReview($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Review objects pre-filled with their Product objects.
	 *
	 * @return     array Array of Review objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinProduct(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReviewPeer::addSelectColumns($c);

		ProductPeer::addSelectColumns($c);

		$c->addJoin(ReviewPeer::PRODUCT_ID, ProductPeer::ID);
		$rs = ReviewPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Review();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getProductId())
                        {

			   $obj2 = new Product();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addReview($obj1);
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
			$criteria->addSelectColumn(ReviewPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReviewPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReviewPeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ReviewPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ReviewPeer::PRODUCT_ID, ProductPeer::ID);

		$rs = ReviewPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Review objects pre-filled with all related objects.
	 *
	 * @return     array Array of Review objects.
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

		ReviewPeer::addSelectColumns($c);
		$startcol2 = (ReviewPeer::NUM_COLUMNS - ReviewPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardUserPeer::NUM_COLUMNS;

		ProductPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + ProductPeer::NUM_COLUMNS;

		$c->addJoin(ReviewPeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ReviewPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ReviewPeer::PRODUCT_ID, ProductPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ReviewPeer::getOMClass();


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
					$temp_obj2->addReview($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initReviews();
				$obj2->addReview($obj1);
			}


				// Add objects for joined sfGuardUser rows
	
			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfGuardUser(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addReview($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initReviews();
				$obj3->addReview($obj1);
			}


				// Add objects for joined Product rows
	
			$omClass = ProductPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getProduct(); // CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addReview($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj4->initReviews();
				$obj4->addReview($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
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
	public static function doCountJoinAllExceptOrder(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReviewPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReviewPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReviewPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ReviewPeer::PRODUCT_ID, ProductPeer::ID);

		$rs = ReviewPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related sfGuardUser table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptsfGuardUser(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReviewPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReviewPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReviewPeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ReviewPeer::PRODUCT_ID, ProductPeer::ID);

		$rs = ReviewPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Product table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptProduct(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReviewPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReviewPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReviewPeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ReviewPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$rs = ReviewPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Review objects pre-filled with all related objects except Order.
	 *
	 * @return     array Array of Review objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptOrder(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReviewPeer::addSelectColumns($c);
		$startcol2 = (ReviewPeer::NUM_COLUMNS - ReviewPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		ProductPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProductPeer::NUM_COLUMNS;

		$c->addJoin(ReviewPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ReviewPeer::PRODUCT_ID, ProductPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ReviewPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfGuardUser(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addReview($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initReviews();
				$obj2->addReview($obj1);
			}

			$omClass = ProductPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProduct(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addReview($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initReviews();
				$obj3->addReview($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Review objects pre-filled with all related objects except sfGuardUser.
	 *
	 * @return     array Array of Review objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptsfGuardUser(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReviewPeer::addSelectColumns($c);
		$startcol2 = (ReviewPeer::NUM_COLUMNS - ReviewPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderPeer::NUM_COLUMNS;

		ProductPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProductPeer::NUM_COLUMNS;

		$c->addJoin(ReviewPeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ReviewPeer::PRODUCT_ID, ProductPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ReviewPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OrderPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrder(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addReview($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initReviews();
				$obj2->addReview($obj1);
			}

			$omClass = ProductPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProduct(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addReview($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initReviews();
				$obj3->addReview($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Review objects pre-filled with all related objects except Product.
	 *
	 * @return     array Array of Review objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptProduct(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReviewPeer::addSelectColumns($c);
		$startcol2 = (ReviewPeer::NUM_COLUMNS - ReviewPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OrderPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OrderPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(ReviewPeer::ORDER_ID, OrderPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ReviewPeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ReviewPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OrderPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOrder(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addReview($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initReviews();
				$obj2->addReview($obj1);
			}

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfGuardUser(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addReview($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initReviews();
				$obj3->addReview($obj1);
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
		return ReviewPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a Review or Criteria object.
	 *
	 * @param      mixed $values Criteria or Review object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseReviewPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseReviewPeer', $values, $con);
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
			$criteria = $values->buildCriteria(); // build Criteria from Review object
		}

		$criteria->remove(ReviewPeer::ID); // remove pkey col since this table uses auto-increment


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

		
    foreach (sfMixer::getCallables('BaseReviewPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseReviewPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a Review or Criteria object.
	 *
	 * @param      mixed $values Criteria or Review object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseReviewPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseReviewPeer', $values, $con);
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

			$comparison = $criteria->getComparison(ReviewPeer::ID);
			$selectCriteria->add(ReviewPeer::ID, $criteria->remove(ReviewPeer::ID), $comparison);

		} else { // $values is Review object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseReviewPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseReviewPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_review table.
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
			$affectedRows += BasePeer::doDeleteAll(ReviewPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a Review or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or Review object or primary key or array of primary keys
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
			$con = Propel::getConnection(ReviewPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof Review) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ReviewPeer::ID, (array) $values, Criteria::IN);
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
	 * Validates all modified columns of given Review object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      Review $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(Review $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ReviewPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ReviewPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ReviewPeer::DATABASE_NAME, ReviewPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ReviewPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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
	 * @return     Review
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(ReviewPeer::DATABASE_NAME);

		$criteria->add(ReviewPeer::ID, $pk);


		$v = ReviewPeer::doSelect($criteria, $con);

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
			$criteria->add(ReviewPeer::ID, $pks, Criteria::IN);
			$objs = ReviewPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseReviewPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseReviewPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('lib.model.map.ReviewMapBuilder');
}
