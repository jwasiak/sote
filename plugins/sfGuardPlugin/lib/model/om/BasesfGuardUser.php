<?php

/**
 * Base class that represents a row from the 'sf_guard_user' table.
 *
 * 
 *
 * @package    plugins.sfGuardPlugin.lib.model.om
 */
abstract class BasesfGuardUser extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        sfGuardUserPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the username field.
	 * @var        string
	 */
	protected $username;


	/**
	 * The value for the algorithm field.
	 * @var        string
	 */
	protected $algorithm = 'sha1';


	/**
	 * The value for the salt field.
	 * @var        string
	 */
	protected $salt = '';


	/**
	 * The value for the password field.
	 * @var        string
	 */
	protected $password = '';


	/**
	 * The value for the created_at field.
	 * @var        int
	 */
	protected $created_at;


	/**
	 * The value for the last_login field.
	 * @var        int
	 */
	protected $last_login;


	/**
	 * The value for the is_active field.
	 * @var        boolean
	 */
	protected $is_active = true;


	/**
	 * The value for the is_super_admin field.
	 * @var        boolean
	 */
	protected $is_super_admin = false;


	/**
	 * The value for the is_confirm field.
	 * @var        boolean
	 */
	protected $is_confirm = true;


	/**
	 * The value for the is_admin_confirm field.
	 * @var        boolean
	 */
	protected $is_admin_confirm = false;


	/**
	 * The value for the hash_code field.
	 * @var        string
	 */
	protected $hash_code;


	/**
	 * The value for the language field.
	 * @var        string
	 */
	protected $language;


	/**
	 * The value for the external_account field.
	 * @var        string
	 */
	protected $external_account;


	/**
	 * The value for the points field.
	 * @var        int
	 */
	protected $points = 0;


	/**
	 * The value for the points_available field.
	 * @var        boolean
	 */
	protected $points_available = true;


	/**
	 * The value for the points_release field.
	 * @var        boolean
	 */
	protected $points_release = false;


	/**
	 * The value for the opt_allegro_user_id field.
	 * @var        int
	 */
	protected $opt_allegro_user_id;


	/**
	 * The value for the wholesale field.
	 * @var        string
	 */
	protected $wholesale = '0';

	/**
	 * Collection to store aggregation of collDashboards.
	 * @var        array
	 */
	protected $collDashboards;

	/**
	 * The criteria used to select the current contents of collDashboards.
	 * @var        Criteria
	 */
	protected $lastDashboardCriteria = null;

	/**
	 * Collection to store aggregation of collAdminGeneratorFilters.
	 * @var        array
	 */
	protected $collAdminGeneratorFilters;

	/**
	 * The criteria used to select the current contents of collAdminGeneratorFilters.
	 * @var        Criteria
	 */
	protected $lastAdminGeneratorFilterCriteria = null;

	/**
	 * Collection to store aggregation of collUserPointssRelatedBySfGuardUserId.
	 * @var        array
	 */
	protected $collUserPointssRelatedBySfGuardUserId;

	/**
	 * The criteria used to select the current contents of collUserPointssRelatedBySfGuardUserId.
	 * @var        Criteria
	 */
	protected $lastUserPointsRelatedBySfGuardUserIdCriteria = null;

	/**
	 * Collection to store aggregation of collUserPointssRelatedByAdminId.
	 * @var        array
	 */
	protected $collUserPointssRelatedByAdminId;

	/**
	 * The criteria used to select the current contents of collUserPointssRelatedByAdminId.
	 * @var        Criteria
	 */
	protected $lastUserPointsRelatedByAdminIdCriteria = null;

	/**
	 * Collection to store aggregation of collGuardUserHasNavigations.
	 * @var        array
	 */
	protected $collGuardUserHasNavigations;

	/**
	 * The criteria used to select the current contents of collGuardUserHasNavigations.
	 * @var        Criteria
	 */
	protected $lastGuardUserHasNavigationCriteria = null;

	/**
	 * Collection to store aggregation of collPayments.
	 * @var        array
	 */
	protected $collPayments;

	/**
	 * The criteria used to select the current contents of collPayments.
	 * @var        Criteria
	 */
	protected $lastPaymentCriteria = null;

	/**
	 * Collection to store aggregation of collUserHasDiscounts.
	 * @var        array
	 */
	protected $collUserHasDiscounts;

	/**
	 * The criteria used to select the current contents of collUserHasDiscounts.
	 * @var        Criteria
	 */
	protected $lastUserHasDiscountCriteria = null;

	/**
	 * Collection to store aggregation of collDiscountUsers.
	 * @var        array
	 */
	protected $collDiscountUsers;

	/**
	 * The criteria used to select the current contents of collDiscountUsers.
	 * @var        Criteria
	 */
	protected $lastDiscountUserCriteria = null;

	/**
	 * Collection to store aggregation of collDiscountCouponCodes.
	 * @var        array
	 */
	protected $collDiscountCouponCodes;

	/**
	 * The criteria used to select the current contents of collDiscountCouponCodes.
	 * @var        Criteria
	 */
	protected $lastDiscountCouponCodeCriteria = null;

	/**
	 * Collection to store aggregation of collThemeLayouts.
	 * @var        array
	 */
	protected $collThemeLayouts;

	/**
	 * The criteria used to select the current contents of collThemeLayouts.
	 * @var        Criteria
	 */
	protected $lastThemeLayoutCriteria = null;

	/**
	 * Collection to store aggregation of collOrders.
	 * @var        array
	 */
	protected $collOrders;

	/**
	 * The criteria used to select the current contents of collOrders.
	 * @var        Criteria
	 */
	protected $lastOrderCriteria = null;

	/**
	 * Collection to store aggregation of collWebApiSessions.
	 * @var        array
	 */
	protected $collWebApiSessions;

	/**
	 * The criteria used to select the current contents of collWebApiSessions.
	 * @var        Criteria
	 */
	protected $lastWebApiSessionCriteria = null;

	/**
	 * Collection to store aggregation of collReviews.
	 * @var        array
	 */
	protected $collReviews;

	/**
	 * The criteria used to select the current contents of collReviews.
	 * @var        Criteria
	 */
	protected $lastReviewCriteria = null;

	/**
	 * Collection to store aggregation of collReviewOrders.
	 * @var        array
	 */
	protected $collReviewOrders;

	/**
	 * The criteria used to select the current contents of collReviewOrders.
	 * @var        Criteria
	 */
	protected $lastReviewOrderCriteria = null;

	/**
	 * Collection to store aggregation of collUserDatas.
	 * @var        array
	 */
	protected $collUserDatas;

	/**
	 * The criteria used to select the current contents of collUserDatas.
	 * @var        Criteria
	 */
	protected $lastUserDataCriteria = null;

	/**
	 * Collection to store aggregation of collNewsletterUsers.
	 * @var        array
	 */
	protected $collNewsletterUsers;

	/**
	 * The criteria used to select the current contents of collNewsletterUsers.
	 * @var        Criteria
	 */
	protected $lastNewsletterUserCriteria = null;

	/**
	 * Collection to store aggregation of collsfGuardUserPermissions.
	 * @var        array
	 */
	protected $collsfGuardUserPermissions;

	/**
	 * The criteria used to select the current contents of collsfGuardUserPermissions.
	 * @var        Criteria
	 */
	protected $lastsfGuardUserPermissionCriteria = null;

	/**
	 * Collection to store aggregation of collsfGuardUserGroups.
	 * @var        array
	 */
	protected $collsfGuardUserGroups;

	/**
	 * The criteria used to select the current contents of collsfGuardUserGroups.
	 * @var        Criteria
	 */
	protected $lastsfGuardUserGroupCriteria = null;

	/**
	 * Collection to store aggregation of collsfGuardRememberKeys.
	 * @var        array
	 */
	protected $collsfGuardRememberKeys;

	/**
	 * The criteria used to select the current contents of collsfGuardRememberKeys.
	 * @var        Criteria
	 */
	protected $lastsfGuardRememberKeyCriteria = null;

	/**
	 * Collection to store aggregation of collsfGuardUserModulePermissions.
	 * @var        array
	 */
	protected $collsfGuardUserModulePermissions;

	/**
	 * The criteria used to select the current contents of collsfGuardUserModulePermissions.
	 * @var        Criteria
	 */
	protected $lastsfGuardUserModulePermissionCriteria = null;

	/**
	 * Collection to store aggregation of collPartners.
	 * @var        array
	 */
	protected $collPartners;

	/**
	 * The criteria used to select the current contents of collPartners.
	 * @var        Criteria
	 */
	protected $lastPartnerCriteria = null;

	/**
	 * Collection to store aggregation of collBaskets.
	 * @var        array
	 */
	protected $collBaskets;

	/**
	 * The criteria used to select the current contents of collBaskets.
	 * @var        Criteria
	 */
	protected $lastBasketCriteria = null;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

    /**
     * Get the [id] column value.
     * 
     * @return     int
     */
    public function getId()
    {

            return $this->id;
    }

    /**
     * Get the [username] column value.
     * 
     * @return     string
     */
    public function getUsername()
    {

            return $this->username;
    }

    /**
     * Get the [algorithm] column value.
     * 
     * @return     string
     */
    public function getAlgorithm()
    {

            return $this->algorithm;
    }

    /**
     * Get the [salt] column value.
     * 
     * @return     string
     */
    public function getSalt()
    {

            return $this->salt;
    }

    /**
     * Get the [password] column value.
     * 
     * @return     string
     */
    public function getPassword()
    {

            return $this->password;
    }

	/**
	 * Get the [optionally formatted] [created_at] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	/**
	 * Get the [optionally formatted] [last_login] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getLastLogin($format = 'Y-m-d H:i:s')
	{

		if ($this->last_login === null || $this->last_login === '') {
			return null;
		} elseif (!is_int($this->last_login)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->last_login);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [last_login] as date/time value: " . var_export($this->last_login, true));
			}
		} else {
			$ts = $this->last_login;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

    /**
     * Get the [is_active] column value.
     * 
     * @return     boolean
     */
    public function getIsActive()
    {

            return $this->is_active;
    }

    /**
     * Get the [is_super_admin] column value.
     * 
     * @return     boolean
     */
    public function getIsSuperAdmin()
    {

            return $this->is_super_admin;
    }

    /**
     * Get the [is_confirm] column value.
     * 
     * @return     boolean
     */
    public function getIsConfirm()
    {

            return $this->is_confirm;
    }

    /**
     * Get the [is_admin_confirm] column value.
     * 
     * @return     boolean
     */
    public function getIsAdminConfirm()
    {

            return $this->is_admin_confirm;
    }

    /**
     * Get the [hash_code] column value.
     * 
     * @return     string
     */
    public function getHashCode()
    {

            return $this->hash_code;
    }

    /**
     * Get the [language] column value.
     * 
     * @return     string
     */
    public function getLanguage()
    {

            return $this->language;
    }

    /**
     * Get the [external_account] column value.
     * 
     * @return     string
     */
    public function getExternalAccount()
    {

            return $this->external_account;
    }

    /**
     * Get the [points] column value.
     * 
     * @return     int
     */
    public function getPoints()
    {

            return $this->points;
    }

    /**
     * Get the [points_available] column value.
     * 
     * @return     boolean
     */
    public function getPointsAvailable()
    {

            return $this->points_available;
    }

    /**
     * Get the [points_release] column value.
     * 
     * @return     boolean
     */
    public function getPointsRelease()
    {

            return $this->points_release;
    }

    /**
     * Get the [opt_allegro_user_id] column value.
     * 
     * @return     int
     */
    public function getOptAllegroUserId()
    {

            return $this->opt_allegro_user_id;
    }

    /**
     * Get the [wholesale] column value.
     * 
     * @return     string
     */
    public function getWholesale()
    {

            return $this->wholesale;
    }

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->id !== $v) {
          $this->id = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [username] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUsername($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->username !== $v) {
          $this->username = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::USERNAME;
        }

	} // setUsername()

	/**
	 * Set the value of [algorithm] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setAlgorithm($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->algorithm !== $v || $v === 'sha1') {
          $this->algorithm = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::ALGORITHM;
        }

	} // setAlgorithm()

	/**
	 * Set the value of [salt] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setSalt($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->salt !== $v || $v === '') {
          $this->salt = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::SALT;
        }

	} // setSalt()

	/**
	 * Set the value of [password] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPassword($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->password !== $v || $v === '') {
          $this->password = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::PASSWORD;
        }

	} // setPassword()

	/**
	 * Set the value of [created_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = sfGuardUserPeer::CREATED_AT;
		}

	} // setCreatedAt()

	/**
	 * Set the value of [last_login] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setLastLogin($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [last_login] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->last_login !== $ts) {
			$this->last_login = $ts;
			$this->modifiedColumns[] = sfGuardUserPeer::LAST_LOGIN;
		}

	} // setLastLogin()

	/**
	 * Set the value of [is_active] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsActive($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_active !== $v || $v === true) {
          $this->is_active = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::IS_ACTIVE;
        }

	} // setIsActive()

	/**
	 * Set the value of [is_super_admin] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsSuperAdmin($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_super_admin !== $v || $v === false) {
          $this->is_super_admin = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::IS_SUPER_ADMIN;
        }

	} // setIsSuperAdmin()

	/**
	 * Set the value of [is_confirm] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsConfirm($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_confirm !== $v || $v === true) {
          $this->is_confirm = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::IS_CONFIRM;
        }

	} // setIsConfirm()

	/**
	 * Set the value of [is_admin_confirm] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsAdminConfirm($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_admin_confirm !== $v || $v === false) {
          $this->is_admin_confirm = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::IS_ADMIN_CONFIRM;
        }

	} // setIsAdminConfirm()

	/**
	 * Set the value of [hash_code] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setHashCode($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->hash_code !== $v) {
          $this->hash_code = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::HASH_CODE;
        }

	} // setHashCode()

	/**
	 * Set the value of [language] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setLanguage($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->language !== $v) {
          $this->language = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::LANGUAGE;
        }

	} // setLanguage()

	/**
	 * Set the value of [external_account] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setExternalAccount($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->external_account !== $v) {
          $this->external_account = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::EXTERNAL_ACCOUNT;
        }

	} // setExternalAccount()

	/**
	 * Set the value of [points] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPoints($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->points !== $v || $v === 0) {
          $this->points = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::POINTS;
        }

	} // setPoints()

	/**
	 * Set the value of [points_available] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setPointsAvailable($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->points_available !== $v || $v === true) {
          $this->points_available = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::POINTS_AVAILABLE;
        }

	} // setPointsAvailable()

	/**
	 * Set the value of [points_release] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setPointsRelease($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->points_release !== $v || $v === false) {
          $this->points_release = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::POINTS_RELEASE;
        }

	} // setPointsRelease()

	/**
	 * Set the value of [opt_allegro_user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOptAllegroUserId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->opt_allegro_user_id !== $v) {
          $this->opt_allegro_user_id = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::OPT_ALLEGRO_USER_ID;
        }

	} // setOptAllegroUserId()

	/**
	 * Set the value of [wholesale] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setWholesale($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->wholesale !== $v || $v === '0') {
          $this->wholesale = $v;
          $this->modifiedColumns[] = sfGuardUserPeer::WHOLESALE;
        }

	} // setWholesale()

  /**
   * Hydrates (populates) the object variables with values from the database resultset.
   *
   * An offset (1-based "start column") is specified so that objects can be hydrated
   * with a subset of the columns in the resultset rows.  This is needed, for example,
   * for results of JOIN queries where the resultset row includes columns from two or
   * more tables.
   *
   * @param      ResultSet $rs The ResultSet class with cursor advanced to desired record pos.
   * @param      int $startcol 1-based offset column which indicates which restultset column to start with.
   * @return     int next starting column
   * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
   */
  public function hydrate(ResultSet $rs, $startcol = 1)
  {
    try {
      if ($this->getDispatcher()->getListeners('sfGuardUser.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardUser.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->username = $rs->getString($startcol + 1);

      $this->algorithm = $rs->getString($startcol + 2);

      $this->salt = $rs->getString($startcol + 3);

      $this->password = $rs->getString($startcol + 4);

      $this->created_at = $rs->getTimestamp($startcol + 5, null);

      $this->last_login = $rs->getTimestamp($startcol + 6, null);

      $this->is_active = $rs->getBoolean($startcol + 7);

      $this->is_super_admin = $rs->getBoolean($startcol + 8);

      $this->is_confirm = $rs->getBoolean($startcol + 9);

      $this->is_admin_confirm = $rs->getBoolean($startcol + 10);

      $this->hash_code = $rs->getString($startcol + 11);

      $this->language = $rs->getString($startcol + 12);

      $this->external_account = $rs->getString($startcol + 13);

      $this->points = $rs->getInt($startcol + 14);

      $this->points_available = $rs->getBoolean($startcol + 15);

      $this->points_release = $rs->getBoolean($startcol + 16);

      $this->opt_allegro_user_id = $rs->getInt($startcol + 17);

      $this->wholesale = $rs->getString($startcol + 18);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('sfGuardUser.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardUser.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 19)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 19; // 19 = sfGuardUserPeer::NUM_COLUMNS - sfGuardUserPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating sfGuardUser object", $e);
    }
  }

  /**
   * Removes this object from datastore and sets delete attribute.
   *
   * @param      Connection $con
   * @return     void
   * @throws     PropelException
   * @see        BaseObject::setDeleted()
   * @see        BaseObject::isDeleted()
   */
  public function delete($con = null)
  {
    if ($this->isDeleted()) {
      throw new PropelException("This object has already been deleted.");
    }

    if ($this->getDispatcher()->getListeners('sfGuardUser.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardUser.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasesfGuardUser:delete:pre'))
    {
      foreach (sfMixer::getCallables('BasesfGuardUser:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(sfGuardUserPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      sfGuardUserPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('sfGuardUser.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardUser.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasesfGuardUser:delete:post'))
    {
      foreach (sfMixer::getCallables('BasesfGuardUser:delete:post') as $callable)
      {
        call_user_func($callable, $this, $con);
      }
    }
  }

  /**
   * Stores the object in the database.  If the object is new,
   * it inserts it; otherwise an update is performed.  This method
   * wraps the doSave() worker method in a transaction.
   *
   * @param      Connection $con
   * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
   * @throws     PropelException
   * @see        doSave()
   */
  public function save($con = null)
  {
    if ($this->isDeleted()) {
      throw new PropelException("You cannot save an object that has been deleted.");
    }

    if (!$this->alreadyInSave) {
      if ($this->getDispatcher()->getListeners('sfGuardUser.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardUser.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BasesfGuardUser:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(sfGuardUserPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(sfGuardUserPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('sfGuardUser.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardUser.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BasesfGuardUser:save:post') as $callable)
        {
          call_user_func($callable, $this, $con, $affectedRows);
        }
      }

      return $affectedRows;
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }
  }

	/**
	 * Stores the object in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      Connection $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave($con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfGuardUserPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += sfGuardUserPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collDashboards !== null) {
				foreach($this->collDashboards as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAdminGeneratorFilters !== null) {
				foreach($this->collAdminGeneratorFilters as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserPointssRelatedBySfGuardUserId !== null) {
				foreach($this->collUserPointssRelatedBySfGuardUserId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserPointssRelatedByAdminId !== null) {
				foreach($this->collUserPointssRelatedByAdminId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGuardUserHasNavigations !== null) {
				foreach($this->collGuardUserHasNavigations as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPayments !== null) {
				foreach($this->collPayments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserHasDiscounts !== null) {
				foreach($this->collUserHasDiscounts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDiscountUsers !== null) {
				foreach($this->collDiscountUsers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDiscountCouponCodes !== null) {
				foreach($this->collDiscountCouponCodes as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collThemeLayouts !== null) {
				foreach($this->collThemeLayouts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOrders !== null) {
				foreach($this->collOrders as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collWebApiSessions !== null) {
				foreach($this->collWebApiSessions as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collReviews !== null) {
				foreach($this->collReviews as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collReviewOrders !== null) {
				foreach($this->collReviewOrders as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserDatas !== null) {
				foreach($this->collUserDatas as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collNewsletterUsers !== null) {
				foreach($this->collNewsletterUsers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collsfGuardUserPermissions !== null) {
				foreach($this->collsfGuardUserPermissions as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collsfGuardUserGroups !== null) {
				foreach($this->collsfGuardUserGroups as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collsfGuardRememberKeys !== null) {
				foreach($this->collsfGuardRememberKeys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collsfGuardUserModulePermissions !== null) {
				foreach($this->collsfGuardUserModulePermissions as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPartners !== null) {
				foreach($this->collPartners as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collBaskets !== null) {
				foreach($this->collBaskets as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = sfGuardUserPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collDashboards !== null) {
					foreach($this->collDashboards as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAdminGeneratorFilters !== null) {
					foreach($this->collAdminGeneratorFilters as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserPointssRelatedBySfGuardUserId !== null) {
					foreach($this->collUserPointssRelatedBySfGuardUserId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserPointssRelatedByAdminId !== null) {
					foreach($this->collUserPointssRelatedByAdminId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGuardUserHasNavigations !== null) {
					foreach($this->collGuardUserHasNavigations as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPayments !== null) {
					foreach($this->collPayments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserHasDiscounts !== null) {
					foreach($this->collUserHasDiscounts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDiscountUsers !== null) {
					foreach($this->collDiscountUsers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDiscountCouponCodes !== null) {
					foreach($this->collDiscountCouponCodes as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collThemeLayouts !== null) {
					foreach($this->collThemeLayouts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOrders !== null) {
					foreach($this->collOrders as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collWebApiSessions !== null) {
					foreach($this->collWebApiSessions as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collReviews !== null) {
					foreach($this->collReviews as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collReviewOrders !== null) {
					foreach($this->collReviewOrders as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserDatas !== null) {
					foreach($this->collUserDatas as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collNewsletterUsers !== null) {
					foreach($this->collNewsletterUsers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collsfGuardUserPermissions !== null) {
					foreach($this->collsfGuardUserPermissions as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collsfGuardUserGroups !== null) {
					foreach($this->collsfGuardUserGroups as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collsfGuardRememberKeys !== null) {
					foreach($this->collsfGuardRememberKeys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collsfGuardUserModulePermissions !== null) {
					foreach($this->collsfGuardUserModulePermissions as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPartners !== null) {
					foreach($this->collPartners as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collBaskets !== null) {
					foreach($this->collBaskets as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants TYPE_PHPNAME,
	 *                     TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfGuardUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getUsername();
				break;
			case 2:
				return $this->getAlgorithm();
				break;
			case 3:
				return $this->getSalt();
				break;
			case 4:
				return $this->getPassword();
				break;
			case 5:
				return $this->getCreatedAt();
				break;
			case 6:
				return $this->getLastLogin();
				break;
			case 7:
				return $this->getIsActive();
				break;
			case 8:
				return $this->getIsSuperAdmin();
				break;
			case 9:
				return $this->getIsConfirm();
				break;
			case 10:
				return $this->getIsAdminConfirm();
				break;
			case 11:
				return $this->getHashCode();
				break;
			case 12:
				return $this->getLanguage();
				break;
			case 13:
				return $this->getExternalAccount();
				break;
			case 14:
				return $this->getPoints();
				break;
			case 15:
				return $this->getPointsAvailable();
				break;
			case 16:
				return $this->getPointsRelease();
				break;
			case 17:
				return $this->getOptAllegroUserId();
				break;
			case 18:
				return $this->getWholesale();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType One of the class type constants TYPE_PHPNAME,
	 *                        TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfGuardUserPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUsername(),
			$keys[2] => $this->getAlgorithm(),
			$keys[3] => $this->getSalt(),
			$keys[4] => $this->getPassword(),
			$keys[5] => $this->getCreatedAt(),
			$keys[6] => $this->getLastLogin(),
			$keys[7] => $this->getIsActive(),
			$keys[8] => $this->getIsSuperAdmin(),
			$keys[9] => $this->getIsConfirm(),
			$keys[10] => $this->getIsAdminConfirm(),
			$keys[11] => $this->getHashCode(),
			$keys[12] => $this->getLanguage(),
			$keys[13] => $this->getExternalAccount(),
			$keys[14] => $this->getPoints(),
			$keys[15] => $this->getPointsAvailable(),
			$keys[16] => $this->getPointsRelease(),
			$keys[17] => $this->getOptAllegroUserId(),
			$keys[18] => $this->getWholesale(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants TYPE_PHPNAME,
	 *                     TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfGuardUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setUsername($value);
				break;
			case 2:
				$this->setAlgorithm($value);
				break;
			case 3:
				$this->setSalt($value);
				break;
			case 4:
				$this->setPassword($value);
				break;
			case 5:
				$this->setCreatedAt($value);
				break;
			case 6:
				$this->setLastLogin($value);
				break;
			case 7:
				$this->setIsActive($value);
				break;
			case 8:
				$this->setIsSuperAdmin($value);
				break;
			case 9:
				$this->setIsConfirm($value);
				break;
			case 10:
				$this->setIsAdminConfirm($value);
				break;
			case 11:
				$this->setHashCode($value);
				break;
			case 12:
				$this->setLanguage($value);
				break;
			case 13:
				$this->setExternalAccount($value);
				break;
			case 14:
				$this->setPoints($value);
				break;
			case 15:
				$this->setPointsAvailable($value);
				break;
			case 16:
				$this->setPointsRelease($value);
				break;
			case 17:
				$this->setOptAllegroUserId($value);
				break;
			case 18:
				$this->setWholesale($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME,
	 * TYPE_NUM. The default key type is the column's phpname (e.g. 'authorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfGuardUserPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUsername($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setAlgorithm($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSalt($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPassword($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setLastLogin($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsActive($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsSuperAdmin($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setIsConfirm($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setIsAdminConfirm($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setHashCode($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setLanguage($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setExternalAccount($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setPoints($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setPointsAvailable($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setPointsRelease($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setOptAllegroUserId($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setWholesale($arr[$keys[18]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(sfGuardUserPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfGuardUserPeer::ID)) $criteria->add(sfGuardUserPeer::ID, $this->id);
		if ($this->isColumnModified(sfGuardUserPeer::USERNAME)) $criteria->add(sfGuardUserPeer::USERNAME, $this->username);
		if ($this->isColumnModified(sfGuardUserPeer::ALGORITHM)) $criteria->add(sfGuardUserPeer::ALGORITHM, $this->algorithm);
		if ($this->isColumnModified(sfGuardUserPeer::SALT)) $criteria->add(sfGuardUserPeer::SALT, $this->salt);
		if ($this->isColumnModified(sfGuardUserPeer::PASSWORD)) $criteria->add(sfGuardUserPeer::PASSWORD, $this->password);
		if ($this->isColumnModified(sfGuardUserPeer::CREATED_AT)) $criteria->add(sfGuardUserPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(sfGuardUserPeer::LAST_LOGIN)) $criteria->add(sfGuardUserPeer::LAST_LOGIN, $this->last_login);
		if ($this->isColumnModified(sfGuardUserPeer::IS_ACTIVE)) $criteria->add(sfGuardUserPeer::IS_ACTIVE, $this->is_active);
		if ($this->isColumnModified(sfGuardUserPeer::IS_SUPER_ADMIN)) $criteria->add(sfGuardUserPeer::IS_SUPER_ADMIN, $this->is_super_admin);
		if ($this->isColumnModified(sfGuardUserPeer::IS_CONFIRM)) $criteria->add(sfGuardUserPeer::IS_CONFIRM, $this->is_confirm);
		if ($this->isColumnModified(sfGuardUserPeer::IS_ADMIN_CONFIRM)) $criteria->add(sfGuardUserPeer::IS_ADMIN_CONFIRM, $this->is_admin_confirm);
		if ($this->isColumnModified(sfGuardUserPeer::HASH_CODE)) $criteria->add(sfGuardUserPeer::HASH_CODE, $this->hash_code);
		if ($this->isColumnModified(sfGuardUserPeer::LANGUAGE)) $criteria->add(sfGuardUserPeer::LANGUAGE, $this->language);
		if ($this->isColumnModified(sfGuardUserPeer::EXTERNAL_ACCOUNT)) $criteria->add(sfGuardUserPeer::EXTERNAL_ACCOUNT, $this->external_account);
		if ($this->isColumnModified(sfGuardUserPeer::POINTS)) $criteria->add(sfGuardUserPeer::POINTS, $this->points);
		if ($this->isColumnModified(sfGuardUserPeer::POINTS_AVAILABLE)) $criteria->add(sfGuardUserPeer::POINTS_AVAILABLE, $this->points_available);
		if ($this->isColumnModified(sfGuardUserPeer::POINTS_RELEASE)) $criteria->add(sfGuardUserPeer::POINTS_RELEASE, $this->points_release);
		if ($this->isColumnModified(sfGuardUserPeer::OPT_ALLEGRO_USER_ID)) $criteria->add(sfGuardUserPeer::OPT_ALLEGRO_USER_ID, $this->opt_allegro_user_id);
		if ($this->isColumnModified(sfGuardUserPeer::WHOLESALE)) $criteria->add(sfGuardUserPeer::WHOLESALE, $this->wholesale);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfGuardUserPeer::DATABASE_NAME);

		$criteria->add(sfGuardUserPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of sfGuardUser (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setUsername($this->username);

		$copyObj->setAlgorithm($this->algorithm);

		$copyObj->setSalt($this->salt);

		$copyObj->setPassword($this->password);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setLastLogin($this->last_login);

		$copyObj->setIsActive($this->is_active);

		$copyObj->setIsSuperAdmin($this->is_super_admin);

		$copyObj->setIsConfirm($this->is_confirm);

		$copyObj->setIsAdminConfirm($this->is_admin_confirm);

		$copyObj->setHashCode($this->hash_code);

		$copyObj->setLanguage($this->language);

		$copyObj->setExternalAccount($this->external_account);

		$copyObj->setPoints($this->points);

		$copyObj->setPointsAvailable($this->points_available);

		$copyObj->setPointsRelease($this->points_release);

		$copyObj->setOptAllegroUserId($this->opt_allegro_user_id);

		$copyObj->setWholesale($this->wholesale);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getDashboards() as $relObj) {
				$copyObj->addDashboard($relObj->copy($deepCopy));
			}

			foreach($this->getAdminGeneratorFilters() as $relObj) {
				$copyObj->addAdminGeneratorFilter($relObj->copy($deepCopy));
			}

			foreach($this->getUserPointssRelatedBySfGuardUserId() as $relObj) {
				$copyObj->addUserPointsRelatedBySfGuardUserId($relObj->copy($deepCopy));
			}

			foreach($this->getUserPointssRelatedByAdminId() as $relObj) {
				$copyObj->addUserPointsRelatedByAdminId($relObj->copy($deepCopy));
			}

			foreach($this->getGuardUserHasNavigations() as $relObj) {
				$copyObj->addGuardUserHasNavigation($relObj->copy($deepCopy));
			}

			foreach($this->getPayments() as $relObj) {
				$copyObj->addPayment($relObj->copy($deepCopy));
			}

			foreach($this->getUserHasDiscounts() as $relObj) {
				$copyObj->addUserHasDiscount($relObj->copy($deepCopy));
			}

			foreach($this->getDiscountUsers() as $relObj) {
				$copyObj->addDiscountUser($relObj->copy($deepCopy));
			}

			foreach($this->getDiscountCouponCodes() as $relObj) {
				$copyObj->addDiscountCouponCode($relObj->copy($deepCopy));
			}

			foreach($this->getThemeLayouts() as $relObj) {
				$copyObj->addThemeLayout($relObj->copy($deepCopy));
			}

			foreach($this->getOrders() as $relObj) {
				$copyObj->addOrder($relObj->copy($deepCopy));
			}

			foreach($this->getWebApiSessions() as $relObj) {
				$copyObj->addWebApiSession($relObj->copy($deepCopy));
			}

			foreach($this->getReviews() as $relObj) {
				$copyObj->addReview($relObj->copy($deepCopy));
			}

			foreach($this->getReviewOrders() as $relObj) {
				$copyObj->addReviewOrder($relObj->copy($deepCopy));
			}

			foreach($this->getUserDatas() as $relObj) {
				$copyObj->addUserData($relObj->copy($deepCopy));
			}

			foreach($this->getNewsletterUsers() as $relObj) {
				$copyObj->addNewsletterUser($relObj->copy($deepCopy));
			}

			foreach($this->getsfGuardUserPermissions() as $relObj) {
				$copyObj->addsfGuardUserPermission($relObj->copy($deepCopy));
			}

			foreach($this->getsfGuardUserGroups() as $relObj) {
				$copyObj->addsfGuardUserGroup($relObj->copy($deepCopy));
			}

			foreach($this->getsfGuardRememberKeys() as $relObj) {
				$copyObj->addsfGuardRememberKey($relObj->copy($deepCopy));
			}

			foreach($this->getsfGuardUserModulePermissions() as $relObj) {
				$copyObj->addsfGuardUserModulePermission($relObj->copy($deepCopy));
			}

			foreach($this->getPartners() as $relObj) {
				$copyObj->addPartner($relObj->copy($deepCopy));
			}

			foreach($this->getBaskets() as $relObj) {
				$copyObj->addBasket($relObj->copy($deepCopy));
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a pkey column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     sfGuardUser Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     sfGuardUserPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new sfGuardUserPeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collDashboards to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDashboards()
	{
		if ($this->collDashboards === null) {
			$this->collDashboards = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related Dashboards from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDashboards($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDashboards === null) {
			if ($this->isNew()) {
			   $this->collDashboards = array();
			} else {

				$criteria->add(DashboardPeer::SF_GUARD_USER_ID, $this->getId());

				DashboardPeer::addSelectColumns($criteria);
				$this->collDashboards = DashboardPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DashboardPeer::SF_GUARD_USER_ID, $this->getId());

				DashboardPeer::addSelectColumns($criteria);
				if (!isset($this->lastDashboardCriteria) || !$this->lastDashboardCriteria->equals($criteria)) {
					$this->collDashboards = DashboardPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDashboardCriteria = $criteria;
		return $this->collDashboards;
	}

	/**
	 * Returns the number of related Dashboards.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDashboards($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DashboardPeer::SF_GUARD_USER_ID, $this->getId());

		return DashboardPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Dashboard object to this object
	 * through the Dashboard foreign key attribute
	 *
	 * @param      Dashboard $l Dashboard
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDashboard(Dashboard $l)
	{
		$this->collDashboards[] = $l;
		$l->setsfGuardUser($this);
	}

	/**
	 * Temporary storage of collAdminGeneratorFilters to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initAdminGeneratorFilters()
	{
		if ($this->collAdminGeneratorFilters === null) {
			$this->collAdminGeneratorFilters = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related AdminGeneratorFilters from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getAdminGeneratorFilters($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAdminGeneratorFilters === null) {
			if ($this->isNew()) {
			   $this->collAdminGeneratorFilters = array();
			} else {

				$criteria->add(AdminGeneratorFilterPeer::GUARD_USER_ID, $this->getId());

				AdminGeneratorFilterPeer::addSelectColumns($criteria);
				$this->collAdminGeneratorFilters = AdminGeneratorFilterPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AdminGeneratorFilterPeer::GUARD_USER_ID, $this->getId());

				AdminGeneratorFilterPeer::addSelectColumns($criteria);
				if (!isset($this->lastAdminGeneratorFilterCriteria) || !$this->lastAdminGeneratorFilterCriteria->equals($criteria)) {
					$this->collAdminGeneratorFilters = AdminGeneratorFilterPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAdminGeneratorFilterCriteria = $criteria;
		return $this->collAdminGeneratorFilters;
	}

	/**
	 * Returns the number of related AdminGeneratorFilters.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countAdminGeneratorFilters($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AdminGeneratorFilterPeer::GUARD_USER_ID, $this->getId());

		return AdminGeneratorFilterPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a AdminGeneratorFilter object to this object
	 * through the AdminGeneratorFilter foreign key attribute
	 *
	 * @param      AdminGeneratorFilter $l AdminGeneratorFilter
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAdminGeneratorFilter(AdminGeneratorFilter $l)
	{
		$this->collAdminGeneratorFilters[] = $l;
		$l->setsfGuardUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related AdminGeneratorFilters from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getAdminGeneratorFiltersJoinAdminGeneratorFilterData($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAdminGeneratorFilters === null) {
			if ($this->isNew()) {
				$this->collAdminGeneratorFilters = array();
			} else {

				$criteria->add(AdminGeneratorFilterPeer::GUARD_USER_ID, $this->getId());

				$this->collAdminGeneratorFilters = AdminGeneratorFilterPeer::doSelectJoinAdminGeneratorFilterData($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AdminGeneratorFilterPeer::GUARD_USER_ID, $this->getId());

			if (!isset($this->lastAdminGeneratorFilterCriteria) || !$this->lastAdminGeneratorFilterCriteria->equals($criteria)) {
				$this->collAdminGeneratorFilters = AdminGeneratorFilterPeer::doSelectJoinAdminGeneratorFilterData($criteria, $con);
			}
		}
		$this->lastAdminGeneratorFilterCriteria = $criteria;

		return $this->collAdminGeneratorFilters;
	}

	/**
	 * Temporary storage of collUserPointssRelatedBySfGuardUserId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initUserPointssRelatedBySfGuardUserId()
	{
		if ($this->collUserPointssRelatedBySfGuardUserId === null) {
			$this->collUserPointssRelatedBySfGuardUserId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related UserPointssRelatedBySfGuardUserId from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getUserPointssRelatedBySfGuardUserId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserPointssRelatedBySfGuardUserId === null) {
			if ($this->isNew()) {
			   $this->collUserPointssRelatedBySfGuardUserId = array();
			} else {

				$criteria->add(UserPointsPeer::SF_GUARD_USER_ID, $this->getId());

				UserPointsPeer::addSelectColumns($criteria);
				$this->collUserPointssRelatedBySfGuardUserId = UserPointsPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserPointsPeer::SF_GUARD_USER_ID, $this->getId());

				UserPointsPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserPointsRelatedBySfGuardUserIdCriteria) || !$this->lastUserPointsRelatedBySfGuardUserIdCriteria->equals($criteria)) {
					$this->collUserPointssRelatedBySfGuardUserId = UserPointsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserPointsRelatedBySfGuardUserIdCriteria = $criteria;
		return $this->collUserPointssRelatedBySfGuardUserId;
	}

	/**
	 * Returns the number of related UserPointssRelatedBySfGuardUserId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countUserPointssRelatedBySfGuardUserId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(UserPointsPeer::SF_GUARD_USER_ID, $this->getId());

		return UserPointsPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a UserPoints object to this object
	 * through the UserPoints foreign key attribute
	 *
	 * @param      UserPoints $l UserPoints
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserPointsRelatedBySfGuardUserId(UserPoints $l)
	{
		$this->collUserPointssRelatedBySfGuardUserId[] = $l;
		$l->setsfGuardUserRelatedBySfGuardUserId($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related UserPointssRelatedBySfGuardUserId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getUserPointssRelatedBySfGuardUserIdJoinOrder($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserPointssRelatedBySfGuardUserId === null) {
			if ($this->isNew()) {
				$this->collUserPointssRelatedBySfGuardUserId = array();
			} else {

				$criteria->add(UserPointsPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collUserPointssRelatedBySfGuardUserId = UserPointsPeer::doSelectJoinOrder($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserPointsPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastUserPointsRelatedBySfGuardUserIdCriteria) || !$this->lastUserPointsRelatedBySfGuardUserIdCriteria->equals($criteria)) {
				$this->collUserPointssRelatedBySfGuardUserId = UserPointsPeer::doSelectJoinOrder($criteria, $con);
			}
		}
		$this->lastUserPointsRelatedBySfGuardUserIdCriteria = $criteria;

		return $this->collUserPointssRelatedBySfGuardUserId;
	}

	/**
	 * Temporary storage of collUserPointssRelatedByAdminId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initUserPointssRelatedByAdminId()
	{
		if ($this->collUserPointssRelatedByAdminId === null) {
			$this->collUserPointssRelatedByAdminId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related UserPointssRelatedByAdminId from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getUserPointssRelatedByAdminId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserPointssRelatedByAdminId === null) {
			if ($this->isNew()) {
			   $this->collUserPointssRelatedByAdminId = array();
			} else {

				$criteria->add(UserPointsPeer::ADMIN_ID, $this->getId());

				UserPointsPeer::addSelectColumns($criteria);
				$this->collUserPointssRelatedByAdminId = UserPointsPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserPointsPeer::ADMIN_ID, $this->getId());

				UserPointsPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserPointsRelatedByAdminIdCriteria) || !$this->lastUserPointsRelatedByAdminIdCriteria->equals($criteria)) {
					$this->collUserPointssRelatedByAdminId = UserPointsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserPointsRelatedByAdminIdCriteria = $criteria;
		return $this->collUserPointssRelatedByAdminId;
	}

	/**
	 * Returns the number of related UserPointssRelatedByAdminId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countUserPointssRelatedByAdminId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(UserPointsPeer::ADMIN_ID, $this->getId());

		return UserPointsPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a UserPoints object to this object
	 * through the UserPoints foreign key attribute
	 *
	 * @param      UserPoints $l UserPoints
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserPointsRelatedByAdminId(UserPoints $l)
	{
		$this->collUserPointssRelatedByAdminId[] = $l;
		$l->setsfGuardUserRelatedByAdminId($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related UserPointssRelatedByAdminId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getUserPointssRelatedByAdminIdJoinOrder($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserPointssRelatedByAdminId === null) {
			if ($this->isNew()) {
				$this->collUserPointssRelatedByAdminId = array();
			} else {

				$criteria->add(UserPointsPeer::ADMIN_ID, $this->getId());

				$this->collUserPointssRelatedByAdminId = UserPointsPeer::doSelectJoinOrder($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserPointsPeer::ADMIN_ID, $this->getId());

			if (!isset($this->lastUserPointsRelatedByAdminIdCriteria) || !$this->lastUserPointsRelatedByAdminIdCriteria->equals($criteria)) {
				$this->collUserPointssRelatedByAdminId = UserPointsPeer::doSelectJoinOrder($criteria, $con);
			}
		}
		$this->lastUserPointsRelatedByAdminIdCriteria = $criteria;

		return $this->collUserPointssRelatedByAdminId;
	}

	/**
	 * Temporary storage of collGuardUserHasNavigations to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initGuardUserHasNavigations()
	{
		if ($this->collGuardUserHasNavigations === null) {
			$this->collGuardUserHasNavigations = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related GuardUserHasNavigations from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getGuardUserHasNavigations($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGuardUserHasNavigations === null) {
			if ($this->isNew()) {
			   $this->collGuardUserHasNavigations = array();
			} else {

				$criteria->add(GuardUserHasNavigationPeer::SF_GUARD_USER_ID, $this->getId());

				GuardUserHasNavigationPeer::addSelectColumns($criteria);
				$this->collGuardUserHasNavigations = GuardUserHasNavigationPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GuardUserHasNavigationPeer::SF_GUARD_USER_ID, $this->getId());

				GuardUserHasNavigationPeer::addSelectColumns($criteria);
				if (!isset($this->lastGuardUserHasNavigationCriteria) || !$this->lastGuardUserHasNavigationCriteria->equals($criteria)) {
					$this->collGuardUserHasNavigations = GuardUserHasNavigationPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGuardUserHasNavigationCriteria = $criteria;
		return $this->collGuardUserHasNavigations;
	}

	/**
	 * Returns the number of related GuardUserHasNavigations.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countGuardUserHasNavigations($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(GuardUserHasNavigationPeer::SF_GUARD_USER_ID, $this->getId());

		return GuardUserHasNavigationPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a GuardUserHasNavigation object to this object
	 * through the GuardUserHasNavigation foreign key attribute
	 *
	 * @param      GuardUserHasNavigation $l GuardUserHasNavigation
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGuardUserHasNavigation(GuardUserHasNavigation $l)
	{
		$this->collGuardUserHasNavigations[] = $l;
		$l->setsfGuardUser($this);
	}

	/**
	 * Temporary storage of collPayments to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPayments()
	{
		if ($this->collPayments === null) {
			$this->collPayments = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related Payments from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPayments($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPayments === null) {
			if ($this->isNew()) {
			   $this->collPayments = array();
			} else {

				$criteria->add(PaymentPeer::SF_GUARD_USER_ID, $this->getId());

				PaymentPeer::addSelectColumns($criteria);
				$this->collPayments = PaymentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PaymentPeer::SF_GUARD_USER_ID, $this->getId());

				PaymentPeer::addSelectColumns($criteria);
				if (!isset($this->lastPaymentCriteria) || !$this->lastPaymentCriteria->equals($criteria)) {
					$this->collPayments = PaymentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPaymentCriteria = $criteria;
		return $this->collPayments;
	}

	/**
	 * Returns the number of related Payments.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPayments($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PaymentPeer::SF_GUARD_USER_ID, $this->getId());

		return PaymentPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Payment object to this object
	 * through the Payment foreign key attribute
	 *
	 * @param      Payment $l Payment
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPayment(Payment $l)
	{
		$this->collPayments[] = $l;
		$l->setsfGuardUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related Payments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getPaymentsJoinPaymentType($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPayments === null) {
			if ($this->isNew()) {
				$this->collPayments = array();
			} else {

				$criteria->add(PaymentPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collPayments = PaymentPeer::doSelectJoinPaymentType($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PaymentPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastPaymentCriteria) || !$this->lastPaymentCriteria->equals($criteria)) {
				$this->collPayments = PaymentPeer::doSelectJoinPaymentType($criteria, $con);
			}
		}
		$this->lastPaymentCriteria = $criteria;

		return $this->collPayments;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related Payments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getPaymentsJoinGiftCard($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPayments === null) {
			if ($this->isNew()) {
				$this->collPayments = array();
			} else {

				$criteria->add(PaymentPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collPayments = PaymentPeer::doSelectJoinGiftCard($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PaymentPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastPaymentCriteria) || !$this->lastPaymentCriteria->equals($criteria)) {
				$this->collPayments = PaymentPeer::doSelectJoinGiftCard($criteria, $con);
			}
		}
		$this->lastPaymentCriteria = $criteria;

		return $this->collPayments;
	}

	/**
	 * Temporary storage of collUserHasDiscounts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initUserHasDiscounts()
	{
		if ($this->collUserHasDiscounts === null) {
			$this->collUserHasDiscounts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related UserHasDiscounts from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getUserHasDiscounts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserHasDiscounts === null) {
			if ($this->isNew()) {
			   $this->collUserHasDiscounts = array();
			} else {

				$criteria->add(UserHasDiscountPeer::SF_GUARD_USER_ID, $this->getId());

				UserHasDiscountPeer::addSelectColumns($criteria);
				$this->collUserHasDiscounts = UserHasDiscountPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserHasDiscountPeer::SF_GUARD_USER_ID, $this->getId());

				UserHasDiscountPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserHasDiscountCriteria) || !$this->lastUserHasDiscountCriteria->equals($criteria)) {
					$this->collUserHasDiscounts = UserHasDiscountPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserHasDiscountCriteria = $criteria;
		return $this->collUserHasDiscounts;
	}

	/**
	 * Returns the number of related UserHasDiscounts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countUserHasDiscounts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(UserHasDiscountPeer::SF_GUARD_USER_ID, $this->getId());

		return UserHasDiscountPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a UserHasDiscount object to this object
	 * through the UserHasDiscount foreign key attribute
	 *
	 * @param      UserHasDiscount $l UserHasDiscount
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserHasDiscount(UserHasDiscount $l)
	{
		$this->collUserHasDiscounts[] = $l;
		$l->setsfGuardUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related UserHasDiscounts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getUserHasDiscountsJoinDiscount($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserHasDiscounts === null) {
			if ($this->isNew()) {
				$this->collUserHasDiscounts = array();
			} else {

				$criteria->add(UserHasDiscountPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collUserHasDiscounts = UserHasDiscountPeer::doSelectJoinDiscount($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserHasDiscountPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastUserHasDiscountCriteria) || !$this->lastUserHasDiscountCriteria->equals($criteria)) {
				$this->collUserHasDiscounts = UserHasDiscountPeer::doSelectJoinDiscount($criteria, $con);
			}
		}
		$this->lastUserHasDiscountCriteria = $criteria;

		return $this->collUserHasDiscounts;
	}

	/**
	 * Temporary storage of collDiscountUsers to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDiscountUsers()
	{
		if ($this->collDiscountUsers === null) {
			$this->collDiscountUsers = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related DiscountUsers from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDiscountUsers($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountUsers === null) {
			if ($this->isNew()) {
			   $this->collDiscountUsers = array();
			} else {

				$criteria->add(DiscountUserPeer::SF_GUARD_USER_ID, $this->getId());

				DiscountUserPeer::addSelectColumns($criteria);
				$this->collDiscountUsers = DiscountUserPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountUserPeer::SF_GUARD_USER_ID, $this->getId());

				DiscountUserPeer::addSelectColumns($criteria);
				if (!isset($this->lastDiscountUserCriteria) || !$this->lastDiscountUserCriteria->equals($criteria)) {
					$this->collDiscountUsers = DiscountUserPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDiscountUserCriteria = $criteria;
		return $this->collDiscountUsers;
	}

	/**
	 * Returns the number of related DiscountUsers.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDiscountUsers($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DiscountUserPeer::SF_GUARD_USER_ID, $this->getId());

		return DiscountUserPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DiscountUser object to this object
	 * through the DiscountUser foreign key attribute
	 *
	 * @param      DiscountUser $l DiscountUser
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDiscountUser(DiscountUser $l)
	{
		$this->collDiscountUsers[] = $l;
		$l->setsfGuardUser($this);
	}

	/**
	 * Temporary storage of collDiscountCouponCodes to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDiscountCouponCodes()
	{
		if ($this->collDiscountCouponCodes === null) {
			$this->collDiscountCouponCodes = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related DiscountCouponCodes from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDiscountCouponCodes($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountCouponCodes === null) {
			if ($this->isNew()) {
			   $this->collDiscountCouponCodes = array();
			} else {

				$criteria->add(DiscountCouponCodePeer::SF_GUARD_USER_ID, $this->getId());

				DiscountCouponCodePeer::addSelectColumns($criteria);
				$this->collDiscountCouponCodes = DiscountCouponCodePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountCouponCodePeer::SF_GUARD_USER_ID, $this->getId());

				DiscountCouponCodePeer::addSelectColumns($criteria);
				if (!isset($this->lastDiscountCouponCodeCriteria) || !$this->lastDiscountCouponCodeCriteria->equals($criteria)) {
					$this->collDiscountCouponCodes = DiscountCouponCodePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDiscountCouponCodeCriteria = $criteria;
		return $this->collDiscountCouponCodes;
	}

	/**
	 * Returns the number of related DiscountCouponCodes.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDiscountCouponCodes($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DiscountCouponCodePeer::SF_GUARD_USER_ID, $this->getId());

		return DiscountCouponCodePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DiscountCouponCode object to this object
	 * through the DiscountCouponCode foreign key attribute
	 *
	 * @param      DiscountCouponCode $l DiscountCouponCode
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDiscountCouponCode(DiscountCouponCode $l)
	{
		$this->collDiscountCouponCodes[] = $l;
		$l->setsfGuardUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related DiscountCouponCodes from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getDiscountCouponCodesJoinOrder($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountCouponCodes === null) {
			if ($this->isNew()) {
				$this->collDiscountCouponCodes = array();
			} else {

				$criteria->add(DiscountCouponCodePeer::SF_GUARD_USER_ID, $this->getId());

				$this->collDiscountCouponCodes = DiscountCouponCodePeer::doSelectJoinOrder($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DiscountCouponCodePeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastDiscountCouponCodeCriteria) || !$this->lastDiscountCouponCodeCriteria->equals($criteria)) {
				$this->collDiscountCouponCodes = DiscountCouponCodePeer::doSelectJoinOrder($criteria, $con);
			}
		}
		$this->lastDiscountCouponCodeCriteria = $criteria;

		return $this->collDiscountCouponCodes;
	}

	/**
	 * Temporary storage of collThemeLayouts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initThemeLayouts()
	{
		if ($this->collThemeLayouts === null) {
			$this->collThemeLayouts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related ThemeLayouts from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getThemeLayouts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collThemeLayouts === null) {
			if ($this->isNew()) {
			   $this->collThemeLayouts = array();
			} else {

				$criteria->add(ThemeLayoutPeer::SF_GUARD_USER_ID, $this->getId());

				ThemeLayoutPeer::addSelectColumns($criteria);
				$this->collThemeLayouts = ThemeLayoutPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ThemeLayoutPeer::SF_GUARD_USER_ID, $this->getId());

				ThemeLayoutPeer::addSelectColumns($criteria);
				if (!isset($this->lastThemeLayoutCriteria) || !$this->lastThemeLayoutCriteria->equals($criteria)) {
					$this->collThemeLayouts = ThemeLayoutPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastThemeLayoutCriteria = $criteria;
		return $this->collThemeLayouts;
	}

	/**
	 * Returns the number of related ThemeLayouts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countThemeLayouts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ThemeLayoutPeer::SF_GUARD_USER_ID, $this->getId());

		return ThemeLayoutPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ThemeLayout object to this object
	 * through the ThemeLayout foreign key attribute
	 *
	 * @param      ThemeLayout $l ThemeLayout
	 * @return     void
	 * @throws     PropelException
	 */
	public function addThemeLayout(ThemeLayout $l)
	{
		$this->collThemeLayouts[] = $l;
		$l->setsfGuardUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related ThemeLayouts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getThemeLayoutsJoinTheme($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collThemeLayouts === null) {
			if ($this->isNew()) {
				$this->collThemeLayouts = array();
			} else {

				$criteria->add(ThemeLayoutPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collThemeLayouts = ThemeLayoutPeer::doSelectJoinTheme($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ThemeLayoutPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastThemeLayoutCriteria) || !$this->lastThemeLayoutCriteria->equals($criteria)) {
				$this->collThemeLayouts = ThemeLayoutPeer::doSelectJoinTheme($criteria, $con);
			}
		}
		$this->lastThemeLayoutCriteria = $criteria;

		return $this->collThemeLayouts;
	}

	/**
	 * Temporary storage of collOrders to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOrders()
	{
		if ($this->collOrders === null) {
			$this->collOrders = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related Orders from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOrders($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
			   $this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

				OrderPeer::addSelectColumns($criteria);
				$this->collOrders = OrderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

				OrderPeer::addSelectColumns($criteria);
				if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
					$this->collOrders = OrderPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOrderCriteria = $criteria;
		return $this->collOrders;
	}

	/**
	 * Returns the number of related Orders.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOrders($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

		return OrderPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Order object to this object
	 * through the Order foreign key attribute
	 *
	 * @param      Order $l Order
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOrder(Order $l)
	{
		$this->collOrders[] = $l;
		$l->setsfGuardUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getOrdersJoinOrderDelivery($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinOrderDelivery($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getOrdersJoinOrderUserDataDelivery($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataDelivery($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getOrdersJoinOrderUserDataBilling($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataBilling($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataBilling($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getOrdersJoinOrderCurrency($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinOrderCurrency($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getOrdersJoinOrderStatus($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderStatus($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinOrderStatus($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getOrdersJoinDiscountCouponCode($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getOrdersJoinDiscount($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinDiscount($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinDiscount($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getOrdersJoinPartner($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinPartner($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinPartner($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}

	/**
	 * Temporary storage of collWebApiSessions to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initWebApiSessions()
	{
		if ($this->collWebApiSessions === null) {
			$this->collWebApiSessions = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related WebApiSessions from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getWebApiSessions($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collWebApiSessions === null) {
			if ($this->isNew()) {
			   $this->collWebApiSessions = array();
			} else {

				$criteria->add(WebApiSessionPeer::SF_GUARD_USER_ID, $this->getId());

				WebApiSessionPeer::addSelectColumns($criteria);
				$this->collWebApiSessions = WebApiSessionPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(WebApiSessionPeer::SF_GUARD_USER_ID, $this->getId());

				WebApiSessionPeer::addSelectColumns($criteria);
				if (!isset($this->lastWebApiSessionCriteria) || !$this->lastWebApiSessionCriteria->equals($criteria)) {
					$this->collWebApiSessions = WebApiSessionPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastWebApiSessionCriteria = $criteria;
		return $this->collWebApiSessions;
	}

	/**
	 * Returns the number of related WebApiSessions.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countWebApiSessions($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(WebApiSessionPeer::SF_GUARD_USER_ID, $this->getId());

		return WebApiSessionPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a WebApiSession object to this object
	 * through the WebApiSession foreign key attribute
	 *
	 * @param      WebApiSession $l WebApiSession
	 * @return     void
	 * @throws     PropelException
	 */
	public function addWebApiSession(WebApiSession $l)
	{
		$this->collWebApiSessions[] = $l;
		$l->setsfGuardUser($this);
	}

	/**
	 * Temporary storage of collReviews to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initReviews()
	{
		if ($this->collReviews === null) {
			$this->collReviews = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related Reviews from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getReviews($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReviews === null) {
			if ($this->isNew()) {
			   $this->collReviews = array();
			} else {

				$criteria->add(ReviewPeer::SF_GUARD_USER_ID, $this->getId());

				ReviewPeer::addSelectColumns($criteria);
				$this->collReviews = ReviewPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ReviewPeer::SF_GUARD_USER_ID, $this->getId());

				ReviewPeer::addSelectColumns($criteria);
				if (!isset($this->lastReviewCriteria) || !$this->lastReviewCriteria->equals($criteria)) {
					$this->collReviews = ReviewPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastReviewCriteria = $criteria;
		return $this->collReviews;
	}

	/**
	 * Returns the number of related Reviews.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countReviews($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ReviewPeer::SF_GUARD_USER_ID, $this->getId());

		return ReviewPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Review object to this object
	 * through the Review foreign key attribute
	 *
	 * @param      Review $l Review
	 * @return     void
	 * @throws     PropelException
	 */
	public function addReview(Review $l)
	{
		$this->collReviews[] = $l;
		$l->setsfGuardUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related Reviews from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getReviewsJoinOrder($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReviews === null) {
			if ($this->isNew()) {
				$this->collReviews = array();
			} else {

				$criteria->add(ReviewPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collReviews = ReviewPeer::doSelectJoinOrder($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ReviewPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastReviewCriteria) || !$this->lastReviewCriteria->equals($criteria)) {
				$this->collReviews = ReviewPeer::doSelectJoinOrder($criteria, $con);
			}
		}
		$this->lastReviewCriteria = $criteria;

		return $this->collReviews;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related Reviews from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getReviewsJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReviews === null) {
			if ($this->isNew()) {
				$this->collReviews = array();
			} else {

				$criteria->add(ReviewPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collReviews = ReviewPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ReviewPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastReviewCriteria) || !$this->lastReviewCriteria->equals($criteria)) {
				$this->collReviews = ReviewPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastReviewCriteria = $criteria;

		return $this->collReviews;
	}

	/**
	 * Temporary storage of collReviewOrders to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initReviewOrders()
	{
		if ($this->collReviewOrders === null) {
			$this->collReviewOrders = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related ReviewOrders from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getReviewOrders($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReviewOrders === null) {
			if ($this->isNew()) {
			   $this->collReviewOrders = array();
			} else {

				$criteria->add(ReviewOrderPeer::SF_GUARD_USER_ID, $this->getId());

				ReviewOrderPeer::addSelectColumns($criteria);
				$this->collReviewOrders = ReviewOrderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ReviewOrderPeer::SF_GUARD_USER_ID, $this->getId());

				ReviewOrderPeer::addSelectColumns($criteria);
				if (!isset($this->lastReviewOrderCriteria) || !$this->lastReviewOrderCriteria->equals($criteria)) {
					$this->collReviewOrders = ReviewOrderPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastReviewOrderCriteria = $criteria;
		return $this->collReviewOrders;
	}

	/**
	 * Returns the number of related ReviewOrders.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countReviewOrders($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ReviewOrderPeer::SF_GUARD_USER_ID, $this->getId());

		return ReviewOrderPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ReviewOrder object to this object
	 * through the ReviewOrder foreign key attribute
	 *
	 * @param      ReviewOrder $l ReviewOrder
	 * @return     void
	 * @throws     PropelException
	 */
	public function addReviewOrder(ReviewOrder $l)
	{
		$this->collReviewOrders[] = $l;
		$l->setsfGuardUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related ReviewOrders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getReviewOrdersJoinOrder($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReviewOrders === null) {
			if ($this->isNew()) {
				$this->collReviewOrders = array();
			} else {

				$criteria->add(ReviewOrderPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collReviewOrders = ReviewOrderPeer::doSelectJoinOrder($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ReviewOrderPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastReviewOrderCriteria) || !$this->lastReviewOrderCriteria->equals($criteria)) {
				$this->collReviewOrders = ReviewOrderPeer::doSelectJoinOrder($criteria, $con);
			}
		}
		$this->lastReviewOrderCriteria = $criteria;

		return $this->collReviewOrders;
	}

	/**
	 * Temporary storage of collUserDatas to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initUserDatas()
	{
		if ($this->collUserDatas === null) {
			$this->collUserDatas = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related UserDatas from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getUserDatas($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserDatas === null) {
			if ($this->isNew()) {
			   $this->collUserDatas = array();
			} else {

				$criteria->add(UserDataPeer::SF_GUARD_USER_ID, $this->getId());

				UserDataPeer::addSelectColumns($criteria);
				$this->collUserDatas = UserDataPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserDataPeer::SF_GUARD_USER_ID, $this->getId());

				UserDataPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserDataCriteria) || !$this->lastUserDataCriteria->equals($criteria)) {
					$this->collUserDatas = UserDataPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserDataCriteria = $criteria;
		return $this->collUserDatas;
	}

	/**
	 * Returns the number of related UserDatas.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countUserDatas($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(UserDataPeer::SF_GUARD_USER_ID, $this->getId());

		return UserDataPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a UserData object to this object
	 * through the UserData foreign key attribute
	 *
	 * @param      UserData $l UserData
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserData(UserData $l)
	{
		$this->collUserDatas[] = $l;
		$l->setsfGuardUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related UserDatas from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getUserDatasJoinCountries($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserDatas === null) {
			if ($this->isNew()) {
				$this->collUserDatas = array();
			} else {

				$criteria->add(UserDataPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collUserDatas = UserDataPeer::doSelectJoinCountries($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserDataPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastUserDataCriteria) || !$this->lastUserDataCriteria->equals($criteria)) {
				$this->collUserDatas = UserDataPeer::doSelectJoinCountries($criteria, $con);
			}
		}
		$this->lastUserDataCriteria = $criteria;

		return $this->collUserDatas;
	}

	/**
	 * Temporary storage of collNewsletterUsers to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initNewsletterUsers()
	{
		if ($this->collNewsletterUsers === null) {
			$this->collNewsletterUsers = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related NewsletterUsers from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getNewsletterUsers($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNewsletterUsers === null) {
			if ($this->isNew()) {
			   $this->collNewsletterUsers = array();
			} else {

				$criteria->add(NewsletterUserPeer::SF_GUARD_USER_ID, $this->getId());

				NewsletterUserPeer::addSelectColumns($criteria);
				$this->collNewsletterUsers = NewsletterUserPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(NewsletterUserPeer::SF_GUARD_USER_ID, $this->getId());

				NewsletterUserPeer::addSelectColumns($criteria);
				if (!isset($this->lastNewsletterUserCriteria) || !$this->lastNewsletterUserCriteria->equals($criteria)) {
					$this->collNewsletterUsers = NewsletterUserPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastNewsletterUserCriteria = $criteria;
		return $this->collNewsletterUsers;
	}

	/**
	 * Returns the number of related NewsletterUsers.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countNewsletterUsers($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(NewsletterUserPeer::SF_GUARD_USER_ID, $this->getId());

		return NewsletterUserPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a NewsletterUser object to this object
	 * through the NewsletterUser foreign key attribute
	 *
	 * @param      NewsletterUser $l NewsletterUser
	 * @return     void
	 * @throws     PropelException
	 */
	public function addNewsletterUser(NewsletterUser $l)
	{
		$this->collNewsletterUsers[] = $l;
		$l->setsfGuardUser($this);
	}

	/**
	 * Temporary storage of collsfGuardUserPermissions to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initsfGuardUserPermissions()
	{
		if ($this->collsfGuardUserPermissions === null) {
			$this->collsfGuardUserPermissions = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related sfGuardUserPermissions from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getsfGuardUserPermissions($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUserPermissions === null) {
			if ($this->isNew()) {
			   $this->collsfGuardUserPermissions = array();
			} else {

				$criteria->add(sfGuardUserPermissionPeer::USER_ID, $this->getId());

				sfGuardUserPermissionPeer::addSelectColumns($criteria);
				$this->collsfGuardUserPermissions = sfGuardUserPermissionPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(sfGuardUserPermissionPeer::USER_ID, $this->getId());

				sfGuardUserPermissionPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfGuardUserPermissionCriteria) || !$this->lastsfGuardUserPermissionCriteria->equals($criteria)) {
					$this->collsfGuardUserPermissions = sfGuardUserPermissionPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfGuardUserPermissionCriteria = $criteria;
		return $this->collsfGuardUserPermissions;
	}

	/**
	 * Returns the number of related sfGuardUserPermissions.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countsfGuardUserPermissions($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfGuardUserPermissionPeer::USER_ID, $this->getId());

		return sfGuardUserPermissionPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a sfGuardUserPermission object to this object
	 * through the sfGuardUserPermission foreign key attribute
	 *
	 * @param      sfGuardUserPermission $l sfGuardUserPermission
	 * @return     void
	 * @throws     PropelException
	 */
	public function addsfGuardUserPermission(sfGuardUserPermission $l)
	{
		$this->collsfGuardUserPermissions[] = $l;
		$l->setsfGuardUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related sfGuardUserPermissions from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getsfGuardUserPermissionsJoinsfGuardPermission($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUserPermissions === null) {
			if ($this->isNew()) {
				$this->collsfGuardUserPermissions = array();
			} else {

				$criteria->add(sfGuardUserPermissionPeer::USER_ID, $this->getId());

				$this->collsfGuardUserPermissions = sfGuardUserPermissionPeer::doSelectJoinsfGuardPermission($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(sfGuardUserPermissionPeer::USER_ID, $this->getId());

			if (!isset($this->lastsfGuardUserPermissionCriteria) || !$this->lastsfGuardUserPermissionCriteria->equals($criteria)) {
				$this->collsfGuardUserPermissions = sfGuardUserPermissionPeer::doSelectJoinsfGuardPermission($criteria, $con);
			}
		}
		$this->lastsfGuardUserPermissionCriteria = $criteria;

		return $this->collsfGuardUserPermissions;
	}

	/**
	 * Temporary storage of collsfGuardUserGroups to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initsfGuardUserGroups()
	{
		if ($this->collsfGuardUserGroups === null) {
			$this->collsfGuardUserGroups = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related sfGuardUserGroups from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getsfGuardUserGroups($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUserGroups === null) {
			if ($this->isNew()) {
			   $this->collsfGuardUserGroups = array();
			} else {

				$criteria->add(sfGuardUserGroupPeer::USER_ID, $this->getId());

				sfGuardUserGroupPeer::addSelectColumns($criteria);
				$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(sfGuardUserGroupPeer::USER_ID, $this->getId());

				sfGuardUserGroupPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfGuardUserGroupCriteria) || !$this->lastsfGuardUserGroupCriteria->equals($criteria)) {
					$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfGuardUserGroupCriteria = $criteria;
		return $this->collsfGuardUserGroups;
	}

	/**
	 * Returns the number of related sfGuardUserGroups.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countsfGuardUserGroups($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfGuardUserGroupPeer::USER_ID, $this->getId());

		return sfGuardUserGroupPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a sfGuardUserGroup object to this object
	 * through the sfGuardUserGroup foreign key attribute
	 *
	 * @param      sfGuardUserGroup $l sfGuardUserGroup
	 * @return     void
	 * @throws     PropelException
	 */
	public function addsfGuardUserGroup(sfGuardUserGroup $l)
	{
		$this->collsfGuardUserGroups[] = $l;
		$l->setsfGuardUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related sfGuardUserGroups from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getsfGuardUserGroupsJoinsfGuardGroup($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUserGroups === null) {
			if ($this->isNew()) {
				$this->collsfGuardUserGroups = array();
			} else {

				$criteria->add(sfGuardUserGroupPeer::USER_ID, $this->getId());

				$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelectJoinsfGuardGroup($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(sfGuardUserGroupPeer::USER_ID, $this->getId());

			if (!isset($this->lastsfGuardUserGroupCriteria) || !$this->lastsfGuardUserGroupCriteria->equals($criteria)) {
				$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelectJoinsfGuardGroup($criteria, $con);
			}
		}
		$this->lastsfGuardUserGroupCriteria = $criteria;

		return $this->collsfGuardUserGroups;
	}

	/**
	 * Temporary storage of collsfGuardRememberKeys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initsfGuardRememberKeys()
	{
		if ($this->collsfGuardRememberKeys === null) {
			$this->collsfGuardRememberKeys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related sfGuardRememberKeys from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getsfGuardRememberKeys($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardRememberKeys === null) {
			if ($this->isNew()) {
			   $this->collsfGuardRememberKeys = array();
			} else {

				$criteria->add(sfGuardRememberKeyPeer::USER_ID, $this->getId());

				sfGuardRememberKeyPeer::addSelectColumns($criteria);
				$this->collsfGuardRememberKeys = sfGuardRememberKeyPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(sfGuardRememberKeyPeer::USER_ID, $this->getId());

				sfGuardRememberKeyPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfGuardRememberKeyCriteria) || !$this->lastsfGuardRememberKeyCriteria->equals($criteria)) {
					$this->collsfGuardRememberKeys = sfGuardRememberKeyPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfGuardRememberKeyCriteria = $criteria;
		return $this->collsfGuardRememberKeys;
	}

	/**
	 * Returns the number of related sfGuardRememberKeys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countsfGuardRememberKeys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfGuardRememberKeyPeer::USER_ID, $this->getId());

		return sfGuardRememberKeyPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a sfGuardRememberKey object to this object
	 * through the sfGuardRememberKey foreign key attribute
	 *
	 * @param      sfGuardRememberKey $l sfGuardRememberKey
	 * @return     void
	 * @throws     PropelException
	 */
	public function addsfGuardRememberKey(sfGuardRememberKey $l)
	{
		$this->collsfGuardRememberKeys[] = $l;
		$l->setsfGuardUser($this);
	}

	/**
	 * Temporary storage of collsfGuardUserModulePermissions to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initsfGuardUserModulePermissions()
	{
		if ($this->collsfGuardUserModulePermissions === null) {
			$this->collsfGuardUserModulePermissions = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related sfGuardUserModulePermissions from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getsfGuardUserModulePermissions($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUserModulePermissions === null) {
			if ($this->isNew()) {
			   $this->collsfGuardUserModulePermissions = array();
			} else {

				$criteria->add(sfGuardUserModulePermissionPeer::ID, $this->getId());

				sfGuardUserModulePermissionPeer::addSelectColumns($criteria);
				$this->collsfGuardUserModulePermissions = sfGuardUserModulePermissionPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(sfGuardUserModulePermissionPeer::ID, $this->getId());

				sfGuardUserModulePermissionPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfGuardUserModulePermissionCriteria) || !$this->lastsfGuardUserModulePermissionCriteria->equals($criteria)) {
					$this->collsfGuardUserModulePermissions = sfGuardUserModulePermissionPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfGuardUserModulePermissionCriteria = $criteria;
		return $this->collsfGuardUserModulePermissions;
	}

	/**
	 * Returns the number of related sfGuardUserModulePermissions.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countsfGuardUserModulePermissions($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfGuardUserModulePermissionPeer::ID, $this->getId());

		return sfGuardUserModulePermissionPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a sfGuardUserModulePermission object to this object
	 * through the sfGuardUserModulePermission foreign key attribute
	 *
	 * @param      sfGuardUserModulePermission $l sfGuardUserModulePermission
	 * @return     void
	 * @throws     PropelException
	 */
	public function addsfGuardUserModulePermission(sfGuardUserModulePermission $l)
	{
		$this->collsfGuardUserModulePermissions[] = $l;
		$l->setsfGuardUser($this);
	}

	/**
	 * Temporary storage of collPartners to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPartners()
	{
		if ($this->collPartners === null) {
			$this->collPartners = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related Partners from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPartners($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPartners === null) {
			if ($this->isNew()) {
			   $this->collPartners = array();
			} else {

				$criteria->add(PartnerPeer::SF_GUARD_USER_ID, $this->getId());

				PartnerPeer::addSelectColumns($criteria);
				$this->collPartners = PartnerPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PartnerPeer::SF_GUARD_USER_ID, $this->getId());

				PartnerPeer::addSelectColumns($criteria);
				if (!isset($this->lastPartnerCriteria) || !$this->lastPartnerCriteria->equals($criteria)) {
					$this->collPartners = PartnerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPartnerCriteria = $criteria;
		return $this->collPartners;
	}

	/**
	 * Returns the number of related Partners.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPartners($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PartnerPeer::SF_GUARD_USER_ID, $this->getId());

		return PartnerPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Partner object to this object
	 * through the Partner foreign key attribute
	 *
	 * @param      Partner $l Partner
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPartner(Partner $l)
	{
		$this->collPartners[] = $l;
		$l->setsfGuardUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related Partners from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getPartnersJoinCountries($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPartners === null) {
			if ($this->isNew()) {
				$this->collPartners = array();
			} else {

				$criteria->add(PartnerPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collPartners = PartnerPeer::doSelectJoinCountries($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PartnerPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastPartnerCriteria) || !$this->lastPartnerCriteria->equals($criteria)) {
				$this->collPartners = PartnerPeer::doSelectJoinCountries($criteria, $con);
			}
		}
		$this->lastPartnerCriteria = $criteria;

		return $this->collPartners;
	}

	/**
	 * Temporary storage of collBaskets to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initBaskets()
	{
		if ($this->collBaskets === null) {
			$this->collBaskets = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser has previously
	 * been saved, it will retrieve related Baskets from storage.
	 * If this sfGuardUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getBaskets($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBaskets === null) {
			if ($this->isNew()) {
			   $this->collBaskets = array();
			} else {

				$criteria->add(BasketPeer::SF_GUARD_USER_ID, $this->getId());

				BasketPeer::addSelectColumns($criteria);
				$this->collBaskets = BasketPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(BasketPeer::SF_GUARD_USER_ID, $this->getId());

				BasketPeer::addSelectColumns($criteria);
				if (!isset($this->lastBasketCriteria) || !$this->lastBasketCriteria->equals($criteria)) {
					$this->collBaskets = BasketPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastBasketCriteria = $criteria;
		return $this->collBaskets;
	}

	/**
	 * Returns the number of related Baskets.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countBaskets($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(BasketPeer::SF_GUARD_USER_ID, $this->getId());

		return BasketPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Basket object to this object
	 * through the Basket foreign key attribute
	 *
	 * @param      Basket $l Basket
	 * @return     void
	 * @throws     PropelException
	 */
	public function addBasket(Basket $l)
	{
		$this->collBaskets[] = $l;
		$l->setsfGuardUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardUser is new, it will return
	 * an empty collection; or if this sfGuardUser has previously
	 * been saved, it will retrieve related Baskets from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardUser.
	 */
	public function getBasketsJoinDiscountCouponCode($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBaskets === null) {
			if ($this->isNew()) {
				$this->collBaskets = array();
			} else {

				$criteria->add(BasketPeer::SF_GUARD_USER_ID, $this->getId());

				$this->collBaskets = BasketPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(BasketPeer::SF_GUARD_USER_ID, $this->getId());

			if (!isset($this->lastBasketCriteria) || !$this->lastBasketCriteria->equals($criteria)) {
				$this->collBaskets = BasketPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		}
		$this->lastBasketCriteria = $criteria;

		return $this->collBaskets;
	}


  public function getDispatcher()
  {
      if (null === self::$dispatcher)
      {
          self::$dispatcher = stEventDispatcher::getInstance();
      }

      return self::$dispatcher;
  }
        
  public function __call($method, $arguments)
  {
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'sfGuardUser.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BasesfGuardUser:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BasesfGuardUser::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BasesfGuardUser
