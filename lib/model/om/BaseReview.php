<?php

/**
 * Base class that represents a row from the 'st_review' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseReview extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ReviewPeer
	 */
	protected static $peer;


	/**
	 * The value for the created_at field.
	 * @var        int
	 */
	protected $created_at;


	/**
	 * The value for the updated_at field.
	 * @var        int
	 */
	protected $updated_at;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the order_id field.
	 * @var        int
	 */
	protected $order_id;


	/**
	 * The value for the sf_guard_user_id field.
	 * @var        int
	 */
	protected $sf_guard_user_id;


	/**
	 * The value for the product_id field.
	 * @var        int
	 */
	protected $product_id;


	/**
	 * The value for the active field.
	 * @var        boolean
	 */
	protected $active = true;


	/**
	 * The value for the score field.
	 * @var        int
	 */
	protected $score;


	/**
	 * The value for the merchant field.
	 * @var        boolean
	 */
	protected $merchant;


	/**
	 * The value for the admin_name field.
	 * @var        string
	 */
	protected $admin_name;


	/**
	 * The value for the admin_active field.
	 * @var        boolean
	 */
	protected $admin_active;


	/**
	 * The value for the anonymous field.
	 * @var        string
	 */
	protected $anonymous;


	/**
	 * The value for the agreement field.
	 * @var        boolean
	 */
	protected $agreement = false;


	/**
	 * The value for the skipped field.
	 * @var        boolean
	 */
	protected $skipped = false;


	/**
	 * The value for the order_number field.
	 * @var        string
	 */
	protected $order_number;


	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;


	/**
	 * The value for the user_ip field.
	 * @var        string
	 */
	protected $user_ip;


	/**
	 * The value for the username field.
	 * @var        string
	 */
	protected $username;


	/**
	 * The value for the language field.
	 * @var        string
	 */
	protected $language;


	/**
	 * The value for the is_pin_review field.
	 * @var        boolean
	 */
	protected $is_pin_review = false;


	/**
	 * The value for the pin_review field.
	 * @var        int
	 */
	protected $pin_review = 0;


	/**
	 * The value for the user_picture field.
	 * @var        string
	 */
	protected $user_picture;


	/**
	 * The value for the user_facebook field.
	 * @var        string
	 */
	protected $user_facebook;


	/**
	 * The value for the user_instagram field.
	 * @var        string
	 */
	protected $user_instagram;


	/**
	 * The value for the user_youtube field.
	 * @var        string
	 */
	protected $user_youtube;


	/**
	 * The value for the user_twitter field.
	 * @var        string
	 */
	protected $user_twitter;


	/**
	 * The value for the user_review_verified field.
	 * @var        boolean
	 */
	protected $user_review_verified = false;

	/**
	 * @var        Order
	 */
	protected $aOrder;

	/**
	 * @var        sfGuardUser
	 */
	protected $asfGuardUser;

	/**
	 * @var        Product
	 */
	protected $aProduct;

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
	 * Get the [optionally formatted] [updated_at] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->updated_at === null || $this->updated_at === '') {
			return null;
		} elseif (!is_int($this->updated_at)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->updated_at);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [updated_at] as date/time value: " . var_export($this->updated_at, true));
			}
		} else {
			$ts = $this->updated_at;
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
     * Get the [id] column value.
     * 
     * @return     int
     */
    public function getId()
    {

            return $this->id;
    }

    /**
     * Get the [order_id] column value.
     * 
     * @return     int
     */
    public function getOrderId()
    {

            return $this->order_id;
    }

    /**
     * Get the [sf_guard_user_id] column value.
     * 
     * @return     int
     */
    public function getSfGuardUserId()
    {

            return $this->sf_guard_user_id;
    }

    /**
     * Get the [product_id] column value.
     * 
     * @return     int
     */
    public function getProductId()
    {

            return $this->product_id;
    }

    /**
     * Get the [active] column value.
     * 
     * @return     boolean
     */
    public function getActive()
    {

            return $this->active;
    }

    /**
     * Get the [score] column value.
     * 
     * @return     int
     */
    public function getScore()
    {

            return $this->score;
    }

    /**
     * Get the [merchant] column value.
     * 
     * @return     boolean
     */
    public function getMerchant()
    {

            return $this->merchant;
    }

    /**
     * Get the [admin_name] column value.
     * 
     * @return     string
     */
    public function getAdminName()
    {

            return $this->admin_name;
    }

    /**
     * Get the [admin_active] column value.
     * 
     * @return     boolean
     */
    public function getAdminActive()
    {

            return $this->admin_active;
    }

    /**
     * Get the [anonymous] column value.
     * 
     * @return     string
     */
    public function getAnonymous()
    {

            return $this->anonymous;
    }

    /**
     * Get the [agreement] column value.
     * 
     * @return     boolean
     */
    public function getAgreement()
    {

            return $this->agreement;
    }

    /**
     * Get the [skipped] column value.
     * 
     * @return     boolean
     */
    public function getSkipped()
    {

            return $this->skipped;
    }

    /**
     * Get the [order_number] column value.
     * 
     * @return     string
     */
    public function getOrderNumber()
    {

            return $this->order_number;
    }

    /**
     * Get the [description] column value.
     * 
     * @return     string
     */
    public function getDescription()
    {

            return $this->description;
    }

    /**
     * Get the [user_ip] column value.
     * 
     * @return     string
     */
    public function getUserIp()
    {

            return $this->user_ip;
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
     * Get the [language] column value.
     * 
     * @return     string
     */
    public function getLanguage()
    {

            return $this->language;
    }

    /**
     * Get the [is_pin_review] column value.
     * 
     * @return     boolean
     */
    public function getIsPinReview()
    {

            return $this->is_pin_review;
    }

    /**
     * Get the [pin_review] column value.
     * 
     * @return     int
     */
    public function getPinReview()
    {

            return $this->pin_review;
    }

    /**
     * Get the [user_picture] column value.
     * 
     * @return     string
     */
    public function getUserPicture()
    {

            return $this->user_picture;
    }

    /**
     * Get the [user_facebook] column value.
     * 
     * @return     string
     */
    public function getUserFacebook()
    {

            return $this->user_facebook;
    }

    /**
     * Get the [user_instagram] column value.
     * 
     * @return     string
     */
    public function getUserInstagram()
    {

            return $this->user_instagram;
    }

    /**
     * Get the [user_youtube] column value.
     * 
     * @return     string
     */
    public function getUserYoutube()
    {

            return $this->user_youtube;
    }

    /**
     * Get the [user_twitter] column value.
     * 
     * @return     string
     */
    public function getUserTwitter()
    {

            return $this->user_twitter;
    }

    /**
     * Get the [user_review_verified] column value.
     * 
     * @return     boolean
     */
    public function getUserReviewVerified()
    {

            return $this->user_review_verified;
    }

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
			$this->modifiedColumns[] = ReviewPeer::CREATED_AT;
		}

	} // setCreatedAt()

	/**
	 * Set the value of [updated_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setUpdatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [updated_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->updated_at !== $ts) {
			$this->updated_at = $ts;
			$this->modifiedColumns[] = ReviewPeer::UPDATED_AT;
		}

	} // setUpdatedAt()

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
          $this->modifiedColumns[] = ReviewPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [order_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOrderId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->order_id !== $v) {
          $this->order_id = $v;
          $this->modifiedColumns[] = ReviewPeer::ORDER_ID;
        }

		if ($this->aOrder !== null && $this->aOrder->getId() !== $v) {
			$this->aOrder = null;
		}

	} // setOrderId()

	/**
	 * Set the value of [sf_guard_user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setSfGuardUserId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->sf_guard_user_id !== $v) {
          $this->sf_guard_user_id = $v;
          $this->modifiedColumns[] = ReviewPeer::SF_GUARD_USER_ID;
        }

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} // setSfGuardUserId()

	/**
	 * Set the value of [product_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setProductId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->product_id !== $v) {
          $this->product_id = $v;
          $this->modifiedColumns[] = ReviewPeer::PRODUCT_ID;
        }

		if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
			$this->aProduct = null;
		}

	} // setProductId()

	/**
	 * Set the value of [active] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setActive($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->active !== $v || $v === true) {
          $this->active = $v;
          $this->modifiedColumns[] = ReviewPeer::ACTIVE;
        }

	} // setActive()

	/**
	 * Set the value of [score] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setScore($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->score !== $v) {
          $this->score = $v;
          $this->modifiedColumns[] = ReviewPeer::SCORE;
        }

	} // setScore()

	/**
	 * Set the value of [merchant] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setMerchant($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->merchant !== $v) {
          $this->merchant = $v;
          $this->modifiedColumns[] = ReviewPeer::MERCHANT;
        }

	} // setMerchant()

	/**
	 * Set the value of [admin_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setAdminName($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->admin_name !== $v) {
          $this->admin_name = $v;
          $this->modifiedColumns[] = ReviewPeer::ADMIN_NAME;
        }

	} // setAdminName()

	/**
	 * Set the value of [admin_active] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setAdminActive($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->admin_active !== $v) {
          $this->admin_active = $v;
          $this->modifiedColumns[] = ReviewPeer::ADMIN_ACTIVE;
        }

	} // setAdminActive()

	/**
	 * Set the value of [anonymous] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setAnonymous($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->anonymous !== $v) {
          $this->anonymous = $v;
          $this->modifiedColumns[] = ReviewPeer::ANONYMOUS;
        }

	} // setAnonymous()

	/**
	 * Set the value of [agreement] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setAgreement($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->agreement !== $v || $v === false) {
          $this->agreement = $v;
          $this->modifiedColumns[] = ReviewPeer::AGREEMENT;
        }

	} // setAgreement()

	/**
	 * Set the value of [skipped] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setSkipped($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->skipped !== $v || $v === false) {
          $this->skipped = $v;
          $this->modifiedColumns[] = ReviewPeer::SKIPPED;
        }

	} // setSkipped()

	/**
	 * Set the value of [order_number] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOrderNumber($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->order_number !== $v) {
          $this->order_number = $v;
          $this->modifiedColumns[] = ReviewPeer::ORDER_NUMBER;
        }

	} // setOrderNumber()

	/**
	 * Set the value of [description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->description !== $v) {
          $this->description = $v;
          $this->modifiedColumns[] = ReviewPeer::DESCRIPTION;
        }

	} // setDescription()

	/**
	 * Set the value of [user_ip] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUserIp($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->user_ip !== $v) {
          $this->user_ip = $v;
          $this->modifiedColumns[] = ReviewPeer::USER_IP;
        }

	} // setUserIp()

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
          $this->modifiedColumns[] = ReviewPeer::USERNAME;
        }

	} // setUsername()

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
          $this->modifiedColumns[] = ReviewPeer::LANGUAGE;
        }

	} // setLanguage()

	/**
	 * Set the value of [is_pin_review] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsPinReview($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_pin_review !== $v || $v === false) {
          $this->is_pin_review = $v;
          $this->modifiedColumns[] = ReviewPeer::IS_PIN_REVIEW;
        }

	} // setIsPinReview()

	/**
	 * Set the value of [pin_review] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPinReview($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->pin_review !== $v || $v === 0) {
          $this->pin_review = $v;
          $this->modifiedColumns[] = ReviewPeer::PIN_REVIEW;
        }

	} // setPinReview()

	/**
	 * Set the value of [user_picture] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUserPicture($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->user_picture !== $v) {
          $this->user_picture = $v;
          $this->modifiedColumns[] = ReviewPeer::USER_PICTURE;
        }

	} // setUserPicture()

	/**
	 * Set the value of [user_facebook] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUserFacebook($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->user_facebook !== $v) {
          $this->user_facebook = $v;
          $this->modifiedColumns[] = ReviewPeer::USER_FACEBOOK;
        }

	} // setUserFacebook()

	/**
	 * Set the value of [user_instagram] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUserInstagram($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->user_instagram !== $v) {
          $this->user_instagram = $v;
          $this->modifiedColumns[] = ReviewPeer::USER_INSTAGRAM;
        }

	} // setUserInstagram()

	/**
	 * Set the value of [user_youtube] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUserYoutube($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->user_youtube !== $v) {
          $this->user_youtube = $v;
          $this->modifiedColumns[] = ReviewPeer::USER_YOUTUBE;
        }

	} // setUserYoutube()

	/**
	 * Set the value of [user_twitter] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUserTwitter($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->user_twitter !== $v) {
          $this->user_twitter = $v;
          $this->modifiedColumns[] = ReviewPeer::USER_TWITTER;
        }

	} // setUserTwitter()

	/**
	 * Set the value of [user_review_verified] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setUserReviewVerified($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->user_review_verified !== $v || $v === false) {
          $this->user_review_verified = $v;
          $this->modifiedColumns[] = ReviewPeer::USER_REVIEW_VERIFIED;
        }

	} // setUserReviewVerified()

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
      if ($this->getDispatcher()->getListeners('Review.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Review.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->order_id = $rs->getInt($startcol + 3);

      $this->sf_guard_user_id = $rs->getInt($startcol + 4);

      $this->product_id = $rs->getInt($startcol + 5);

      $this->active = $rs->getBoolean($startcol + 6);

      $this->score = $rs->getInt($startcol + 7);

      $this->merchant = $rs->getBoolean($startcol + 8);

      $this->admin_name = $rs->getString($startcol + 9);

      $this->admin_active = $rs->getBoolean($startcol + 10);

      $this->anonymous = $rs->getString($startcol + 11);

      $this->agreement = $rs->getBoolean($startcol + 12);

      $this->skipped = $rs->getBoolean($startcol + 13);

      $this->order_number = $rs->getString($startcol + 14);

      $this->description = $rs->getString($startcol + 15);

      $this->user_ip = $rs->getString($startcol + 16);

      $this->username = $rs->getString($startcol + 17);

      $this->language = $rs->getString($startcol + 18);

      $this->is_pin_review = $rs->getBoolean($startcol + 19);

      $this->pin_review = $rs->getInt($startcol + 20);

      $this->user_picture = $rs->getString($startcol + 21);

      $this->user_facebook = $rs->getString($startcol + 22);

      $this->user_instagram = $rs->getString($startcol + 23);

      $this->user_youtube = $rs->getString($startcol + 24);

      $this->user_twitter = $rs->getString($startcol + 25);

      $this->user_review_verified = $rs->getBoolean($startcol + 26);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Review.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Review.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 27)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 27; // 27 = ReviewPeer::NUM_COLUMNS - ReviewPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Review object", $e);
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

    if ($this->getDispatcher()->getListeners('Review.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Review.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseReview:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseReview:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ReviewPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ReviewPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Review.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Review.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseReview:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseReview:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Review.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Review.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseReview:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(ReviewPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ReviewPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(ReviewPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Review.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Review.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseReview:save:post') as $callable)
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


			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aOrder !== null) {
				if ($this->aOrder->isModified()) {
					$affectedRows += $this->aOrder->save($con);
				}
				$this->setOrder($this->aOrder);
			}

			if ($this->asfGuardUser !== null) {
				if ($this->asfGuardUser->isModified()) {
					$affectedRows += $this->asfGuardUser->save($con);
				}
				$this->setsfGuardUser($this->asfGuardUser);
			}

			if ($this->aProduct !== null) {
				if ($this->aProduct->isModified() || $this->aProduct->getCurrentProductI18n()->isModified()) {
					$affectedRows += $this->aProduct->save($con);
				}
				$this->setProduct($this->aProduct);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ReviewPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ReviewPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
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


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aOrder !== null) {
				if (!$this->aOrder->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOrder->getValidationFailures());
				}
			}

			if ($this->asfGuardUser !== null) {
				if (!$this->asfGuardUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUser->getValidationFailures());
				}
			}

			if ($this->aProduct !== null) {
				if (!$this->aProduct->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProduct->getValidationFailures());
				}
			}


			if (($retval = ReviewPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
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
		$pos = ReviewPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCreatedAt();
				break;
			case 1:
				return $this->getUpdatedAt();
				break;
			case 2:
				return $this->getId();
				break;
			case 3:
				return $this->getOrderId();
				break;
			case 4:
				return $this->getSfGuardUserId();
				break;
			case 5:
				return $this->getProductId();
				break;
			case 6:
				return $this->getActive();
				break;
			case 7:
				return $this->getScore();
				break;
			case 8:
				return $this->getMerchant();
				break;
			case 9:
				return $this->getAdminName();
				break;
			case 10:
				return $this->getAdminActive();
				break;
			case 11:
				return $this->getAnonymous();
				break;
			case 12:
				return $this->getAgreement();
				break;
			case 13:
				return $this->getSkipped();
				break;
			case 14:
				return $this->getOrderNumber();
				break;
			case 15:
				return $this->getDescription();
				break;
			case 16:
				return $this->getUserIp();
				break;
			case 17:
				return $this->getUsername();
				break;
			case 18:
				return $this->getLanguage();
				break;
			case 19:
				return $this->getIsPinReview();
				break;
			case 20:
				return $this->getPinReview();
				break;
			case 21:
				return $this->getUserPicture();
				break;
			case 22:
				return $this->getUserFacebook();
				break;
			case 23:
				return $this->getUserInstagram();
				break;
			case 24:
				return $this->getUserYoutube();
				break;
			case 25:
				return $this->getUserTwitter();
				break;
			case 26:
				return $this->getUserReviewVerified();
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
		$keys = ReviewPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getOrderId(),
			$keys[4] => $this->getSfGuardUserId(),
			$keys[5] => $this->getProductId(),
			$keys[6] => $this->getActive(),
			$keys[7] => $this->getScore(),
			$keys[8] => $this->getMerchant(),
			$keys[9] => $this->getAdminName(),
			$keys[10] => $this->getAdminActive(),
			$keys[11] => $this->getAnonymous(),
			$keys[12] => $this->getAgreement(),
			$keys[13] => $this->getSkipped(),
			$keys[14] => $this->getOrderNumber(),
			$keys[15] => $this->getDescription(),
			$keys[16] => $this->getUserIp(),
			$keys[17] => $this->getUsername(),
			$keys[18] => $this->getLanguage(),
			$keys[19] => $this->getIsPinReview(),
			$keys[20] => $this->getPinReview(),
			$keys[21] => $this->getUserPicture(),
			$keys[22] => $this->getUserFacebook(),
			$keys[23] => $this->getUserInstagram(),
			$keys[24] => $this->getUserYoutube(),
			$keys[25] => $this->getUserTwitter(),
			$keys[26] => $this->getUserReviewVerified(),
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
		$pos = ReviewPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setCreatedAt($value);
				break;
			case 1:
				$this->setUpdatedAt($value);
				break;
			case 2:
				$this->setId($value);
				break;
			case 3:
				$this->setOrderId($value);
				break;
			case 4:
				$this->setSfGuardUserId($value);
				break;
			case 5:
				$this->setProductId($value);
				break;
			case 6:
				$this->setActive($value);
				break;
			case 7:
				$this->setScore($value);
				break;
			case 8:
				$this->setMerchant($value);
				break;
			case 9:
				$this->setAdminName($value);
				break;
			case 10:
				$this->setAdminActive($value);
				break;
			case 11:
				$this->setAnonymous($value);
				break;
			case 12:
				$this->setAgreement($value);
				break;
			case 13:
				$this->setSkipped($value);
				break;
			case 14:
				$this->setOrderNumber($value);
				break;
			case 15:
				$this->setDescription($value);
				break;
			case 16:
				$this->setUserIp($value);
				break;
			case 17:
				$this->setUsername($value);
				break;
			case 18:
				$this->setLanguage($value);
				break;
			case 19:
				$this->setIsPinReview($value);
				break;
			case 20:
				$this->setPinReview($value);
				break;
			case 21:
				$this->setUserPicture($value);
				break;
			case 22:
				$this->setUserFacebook($value);
				break;
			case 23:
				$this->setUserInstagram($value);
				break;
			case 24:
				$this->setUserYoutube($value);
				break;
			case 25:
				$this->setUserTwitter($value);
				break;
			case 26:
				$this->setUserReviewVerified($value);
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
		$keys = ReviewPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setOrderId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSfGuardUserId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setProductId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setActive($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setScore($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setMerchant($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setAdminName($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setAdminActive($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setAnonymous($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setAgreement($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setSkipped($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setOrderNumber($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setDescription($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setUserIp($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setUsername($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setLanguage($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setIsPinReview($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setPinReview($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setUserPicture($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setUserFacebook($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setUserInstagram($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setUserYoutube($arr[$keys[24]]);
		if (array_key_exists($keys[25], $arr)) $this->setUserTwitter($arr[$keys[25]]);
		if (array_key_exists($keys[26], $arr)) $this->setUserReviewVerified($arr[$keys[26]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ReviewPeer::DATABASE_NAME);

		if ($this->isColumnModified(ReviewPeer::CREATED_AT)) $criteria->add(ReviewPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ReviewPeer::UPDATED_AT)) $criteria->add(ReviewPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(ReviewPeer::ID)) $criteria->add(ReviewPeer::ID, $this->id);
		if ($this->isColumnModified(ReviewPeer::ORDER_ID)) $criteria->add(ReviewPeer::ORDER_ID, $this->order_id);
		if ($this->isColumnModified(ReviewPeer::SF_GUARD_USER_ID)) $criteria->add(ReviewPeer::SF_GUARD_USER_ID, $this->sf_guard_user_id);
		if ($this->isColumnModified(ReviewPeer::PRODUCT_ID)) $criteria->add(ReviewPeer::PRODUCT_ID, $this->product_id);
		if ($this->isColumnModified(ReviewPeer::ACTIVE)) $criteria->add(ReviewPeer::ACTIVE, $this->active);
		if ($this->isColumnModified(ReviewPeer::SCORE)) $criteria->add(ReviewPeer::SCORE, $this->score);
		if ($this->isColumnModified(ReviewPeer::MERCHANT)) $criteria->add(ReviewPeer::MERCHANT, $this->merchant);
		if ($this->isColumnModified(ReviewPeer::ADMIN_NAME)) $criteria->add(ReviewPeer::ADMIN_NAME, $this->admin_name);
		if ($this->isColumnModified(ReviewPeer::ADMIN_ACTIVE)) $criteria->add(ReviewPeer::ADMIN_ACTIVE, $this->admin_active);
		if ($this->isColumnModified(ReviewPeer::ANONYMOUS)) $criteria->add(ReviewPeer::ANONYMOUS, $this->anonymous);
		if ($this->isColumnModified(ReviewPeer::AGREEMENT)) $criteria->add(ReviewPeer::AGREEMENT, $this->agreement);
		if ($this->isColumnModified(ReviewPeer::SKIPPED)) $criteria->add(ReviewPeer::SKIPPED, $this->skipped);
		if ($this->isColumnModified(ReviewPeer::ORDER_NUMBER)) $criteria->add(ReviewPeer::ORDER_NUMBER, $this->order_number);
		if ($this->isColumnModified(ReviewPeer::DESCRIPTION)) $criteria->add(ReviewPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(ReviewPeer::USER_IP)) $criteria->add(ReviewPeer::USER_IP, $this->user_ip);
		if ($this->isColumnModified(ReviewPeer::USERNAME)) $criteria->add(ReviewPeer::USERNAME, $this->username);
		if ($this->isColumnModified(ReviewPeer::LANGUAGE)) $criteria->add(ReviewPeer::LANGUAGE, $this->language);
		if ($this->isColumnModified(ReviewPeer::IS_PIN_REVIEW)) $criteria->add(ReviewPeer::IS_PIN_REVIEW, $this->is_pin_review);
		if ($this->isColumnModified(ReviewPeer::PIN_REVIEW)) $criteria->add(ReviewPeer::PIN_REVIEW, $this->pin_review);
		if ($this->isColumnModified(ReviewPeer::USER_PICTURE)) $criteria->add(ReviewPeer::USER_PICTURE, $this->user_picture);
		if ($this->isColumnModified(ReviewPeer::USER_FACEBOOK)) $criteria->add(ReviewPeer::USER_FACEBOOK, $this->user_facebook);
		if ($this->isColumnModified(ReviewPeer::USER_INSTAGRAM)) $criteria->add(ReviewPeer::USER_INSTAGRAM, $this->user_instagram);
		if ($this->isColumnModified(ReviewPeer::USER_YOUTUBE)) $criteria->add(ReviewPeer::USER_YOUTUBE, $this->user_youtube);
		if ($this->isColumnModified(ReviewPeer::USER_TWITTER)) $criteria->add(ReviewPeer::USER_TWITTER, $this->user_twitter);
		if ($this->isColumnModified(ReviewPeer::USER_REVIEW_VERIFIED)) $criteria->add(ReviewPeer::USER_REVIEW_VERIFIED, $this->user_review_verified);

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
		$criteria = new Criteria(ReviewPeer::DATABASE_NAME);

		$criteria->add(ReviewPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Review (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setOrderId($this->order_id);

		$copyObj->setSfGuardUserId($this->sf_guard_user_id);

		$copyObj->setProductId($this->product_id);

		$copyObj->setActive($this->active);

		$copyObj->setScore($this->score);

		$copyObj->setMerchant($this->merchant);

		$copyObj->setAdminName($this->admin_name);

		$copyObj->setAdminActive($this->admin_active);

		$copyObj->setAnonymous($this->anonymous);

		$copyObj->setAgreement($this->agreement);

		$copyObj->setSkipped($this->skipped);

		$copyObj->setOrderNumber($this->order_number);

		$copyObj->setDescription($this->description);

		$copyObj->setUserIp($this->user_ip);

		$copyObj->setUsername($this->username);

		$copyObj->setLanguage($this->language);

		$copyObj->setIsPinReview($this->is_pin_review);

		$copyObj->setPinReview($this->pin_review);

		$copyObj->setUserPicture($this->user_picture);

		$copyObj->setUserFacebook($this->user_facebook);

		$copyObj->setUserInstagram($this->user_instagram);

		$copyObj->setUserYoutube($this->user_youtube);

		$copyObj->setUserTwitter($this->user_twitter);

		$copyObj->setUserReviewVerified($this->user_review_verified);


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
	 * @return     Review Clone of current object.
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
	 * @return     ReviewPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ReviewPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Order object.
	 *
	 * @param      Order $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setOrder($v)
	{


		if ($v === null) {
			$this->setOrderId(NULL);
		} else {
			$this->setOrderId($v->getId());
		}


		$this->aOrder = $v;
	}


	/**
	 * Get the associated Order object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Order The associated Order object.
	 * @throws     PropelException
	 */
	public function getOrder($con = null)
	{
		if ($this->aOrder === null && ($this->order_id !== null)) {
			// include the related Peer class
			$this->aOrder = OrderPeer::retrieveByPK($this->order_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = OrderPeer::retrieveByPK($this->order_id, $con);
			   $obj->addOrders($this);
			 */
		}
		return $this->aOrder;
	}

	/**
	 * Declares an association between this object and a sfGuardUser object.
	 *
	 * @param      sfGuardUser $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setsfGuardUser($v)
	{


		if ($v === null) {
			$this->setSfGuardUserId(NULL);
		} else {
			$this->setSfGuardUserId($v->getId());
		}


		$this->asfGuardUser = $v;
	}


	/**
	 * Get the associated sfGuardUser object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     sfGuardUser The associated sfGuardUser object.
	 * @throws     PropelException
	 */
	public function getsfGuardUser($con = null)
	{
		if ($this->asfGuardUser === null && ($this->sf_guard_user_id !== null)) {
			// include the related Peer class
			$this->asfGuardUser = sfGuardUserPeer::retrieveByPK($this->sf_guard_user_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = sfGuardUserPeer::retrieveByPK($this->sf_guard_user_id, $con);
			   $obj->addsfGuardUsers($this);
			 */
		}
		return $this->asfGuardUser;
	}

	/**
	 * Declares an association between this object and a Product object.
	 *
	 * @param      Product $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setProduct($v)
	{


		if ($v === null) {
			$this->setProductId(NULL);
		} else {
			$this->setProductId($v->getId());
		}


		$this->aProduct = $v;
	}


	/**
	 * Get the associated Product object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Product The associated Product object.
	 * @throws     PropelException
	 */
	public function getProduct($con = null)
	{
		if ($this->aProduct === null && ($this->product_id !== null)) {
			// include the related Peer class
			$this->aProduct = ProductPeer::retrieveByPK($this->product_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductPeer::retrieveByPK($this->product_id, $con);
			   $obj->addProducts($this);
			 */
		}
		return $this->aProduct;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Review.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseReview:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseReview::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseReview
