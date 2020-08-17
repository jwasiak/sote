<?php

/**
 * Base class that represents a row from the 'st_trusted_shops' table.
 *
 * 
 *
 * @package    plugins.stTrustedShopsPlugin.lib.model.om
 */
abstract class BaseTrustedShops extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        TrustedShopsPeer
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
	 * The value for the certificate field.
	 * @var        string
	 */
	protected $certificate;


	/**
	 * The value for the username field.
	 * @var        string
	 */
	protected $username;


	/**
	 * The value for the password field.
	 * @var        string
	 */
	protected $password;


	/**
	 * The value for the type field.
	 * @var        string
	 */
	protected $type;


	/**
	 * The value for the url field.
	 * @var        string
	 */
	protected $url;


	/**
	 * The value for the language field.
	 * @var        string
	 */
	protected $language;


	/**
	 * The value for the status field.
	 * @var        string
	 */
	protected $status;


	/**
	 * The value for the logo field.
	 * @var        boolean
	 */
	protected $logo;


	/**
	 * The value for the rating_widget field.
	 * @var        boolean
	 */
	protected $rating_widget;


	/**
	 * The value for the rating_status field.
	 * @var        boolean
	 */
	protected $rating_status;


	/**
	 * The value for the rating_in_order_mail field.
	 * @var        boolean
	 */
	protected $rating_in_order_mail;


	/**
	 * The value for the trustbadge_code field.
	 * @var        string
	 */
	protected $trustbadge_code;

	/**
	 * Collection to store aggregation of collTrustedShopsHasPaymentTypes.
	 * @var        array
	 */
	protected $collTrustedShopsHasPaymentTypes;

	/**
	 * The criteria used to select the current contents of collTrustedShopsHasPaymentTypes.
	 * @var        Criteria
	 */
	protected $lastTrustedShopsHasPaymentTypeCriteria = null;

	/**
	 * Collection to store aggregation of collTrustedShopsProtectionProductss.
	 * @var        array
	 */
	protected $collTrustedShopsProtectionProductss;

	/**
	 * The criteria used to select the current contents of collTrustedShopsProtectionProductss.
	 * @var        Criteria
	 */
	protected $lastTrustedShopsProtectionProductsCriteria = null;

	/**
	 * Collection to store aggregation of collTrustedShopsHasOrders.
	 * @var        array
	 */
	protected $collTrustedShopsHasOrders;

	/**
	 * The criteria used to select the current contents of collTrustedShopsHasOrders.
	 * @var        Criteria
	 */
	protected $lastTrustedShopsHasOrderCriteria = null;

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
     * Get the [certificate] column value.
     * 
     * @return     string
     */
    public function getCertificate()
    {

            return $this->certificate;
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
     * Get the [password] column value.
     * 
     * @return     string
     */
    public function getPassword()
    {

            return $this->password;
    }

    /**
     * Get the [type] column value.
     * 
     * @return     string
     */
    public function getType()
    {

            return $this->type;
    }

    /**
     * Get the [url] column value.
     * 
     * @return     string
     */
    public function getUrl()
    {

            return $this->url;
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
     * Get the [status] column value.
     * 
     * @return     string
     */
    public function getStatus()
    {

            return $this->status;
    }

    /**
     * Get the [logo] column value.
     * 
     * @return     boolean
     */
    public function getLogo()
    {

            return $this->logo;
    }

    /**
     * Get the [rating_widget] column value.
     * 
     * @return     boolean
     */
    public function getRatingWidget()
    {

            return $this->rating_widget;
    }

    /**
     * Get the [rating_status] column value.
     * 
     * @return     boolean
     */
    public function getRatingStatus()
    {

            return $this->rating_status;
    }

    /**
     * Get the [rating_in_order_mail] column value.
     * 
     * @return     boolean
     */
    public function getRatingInOrderMail()
    {

            return $this->rating_in_order_mail;
    }

    /**
     * Get the [trustbadge_code] column value.
     * 
     * @return     string
     */
    public function getTrustbadgeCode()
    {

            return $this->trustbadge_code;
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
			$this->modifiedColumns[] = TrustedShopsPeer::CREATED_AT;
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
			$this->modifiedColumns[] = TrustedShopsPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = TrustedShopsPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [certificate] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCertificate($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->certificate !== $v) {
          $this->certificate = $v;
          $this->modifiedColumns[] = TrustedShopsPeer::CERTIFICATE;
        }

	} // setCertificate()

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
          $this->modifiedColumns[] = TrustedShopsPeer::USERNAME;
        }

	} // setUsername()

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

        if ($this->password !== $v) {
          $this->password = $v;
          $this->modifiedColumns[] = TrustedShopsPeer::PASSWORD;
        }

	} // setPassword()

	/**
	 * Set the value of [type] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setType($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->type !== $v) {
          $this->type = $v;
          $this->modifiedColumns[] = TrustedShopsPeer::TYPE;
        }

	} // setType()

	/**
	 * Set the value of [url] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUrl($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->url !== $v) {
          $this->url = $v;
          $this->modifiedColumns[] = TrustedShopsPeer::URL;
        }

	} // setUrl()

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
          $this->modifiedColumns[] = TrustedShopsPeer::LANGUAGE;
        }

	} // setLanguage()

	/**
	 * Set the value of [status] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setStatus($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->status !== $v) {
          $this->status = $v;
          $this->modifiedColumns[] = TrustedShopsPeer::STATUS;
        }

	} // setStatus()

	/**
	 * Set the value of [logo] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setLogo($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->logo !== $v) {
          $this->logo = $v;
          $this->modifiedColumns[] = TrustedShopsPeer::LOGO;
        }

	} // setLogo()

	/**
	 * Set the value of [rating_widget] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setRatingWidget($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->rating_widget !== $v) {
          $this->rating_widget = $v;
          $this->modifiedColumns[] = TrustedShopsPeer::RATING_WIDGET;
        }

	} // setRatingWidget()

	/**
	 * Set the value of [rating_status] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setRatingStatus($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->rating_status !== $v) {
          $this->rating_status = $v;
          $this->modifiedColumns[] = TrustedShopsPeer::RATING_STATUS;
        }

	} // setRatingStatus()

	/**
	 * Set the value of [rating_in_order_mail] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setRatingInOrderMail($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->rating_in_order_mail !== $v) {
          $this->rating_in_order_mail = $v;
          $this->modifiedColumns[] = TrustedShopsPeer::RATING_IN_ORDER_MAIL;
        }

	} // setRatingInOrderMail()

	/**
	 * Set the value of [trustbadge_code] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTrustbadgeCode($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->trustbadge_code !== $v) {
          $this->trustbadge_code = $v;
          $this->modifiedColumns[] = TrustedShopsPeer::TRUSTBADGE_CODE;
        }

	} // setTrustbadgeCode()

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
      if ($this->getDispatcher()->getListeners('TrustedShops.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShops.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->certificate = $rs->getString($startcol + 3);

      $this->username = $rs->getString($startcol + 4);

      $this->password = $rs->getString($startcol + 5);

      $this->type = $rs->getString($startcol + 6);

      $this->url = $rs->getString($startcol + 7);

      $this->language = $rs->getString($startcol + 8);

      $this->status = $rs->getString($startcol + 9);

      $this->logo = $rs->getBoolean($startcol + 10);

      $this->rating_widget = $rs->getBoolean($startcol + 11);

      $this->rating_status = $rs->getBoolean($startcol + 12);

      $this->rating_in_order_mail = $rs->getBoolean($startcol + 13);

      $this->trustbadge_code = $rs->getString($startcol + 14);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('TrustedShops.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShops.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 15)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 15; // 15 = TrustedShopsPeer::NUM_COLUMNS - TrustedShopsPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating TrustedShops object", $e);
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

    if ($this->getDispatcher()->getListeners('TrustedShops.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShops.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTrustedShops:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseTrustedShops:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(TrustedShopsPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      TrustedShopsPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('TrustedShops.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShops.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTrustedShops:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseTrustedShops:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('TrustedShops.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShops.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseTrustedShops:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(TrustedShopsPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(TrustedShopsPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(TrustedShopsPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('TrustedShops.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShops.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseTrustedShops:save:post') as $callable)
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
					$pk = TrustedShopsPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += TrustedShopsPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collTrustedShopsHasPaymentTypes !== null) {
				foreach($this->collTrustedShopsHasPaymentTypes as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTrustedShopsProtectionProductss !== null) {
				foreach($this->collTrustedShopsProtectionProductss as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTrustedShopsHasOrders !== null) {
				foreach($this->collTrustedShopsHasOrders as $referrerFK) {
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


			if (($retval = TrustedShopsPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collTrustedShopsHasPaymentTypes !== null) {
					foreach($this->collTrustedShopsHasPaymentTypes as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTrustedShopsProtectionProductss !== null) {
					foreach($this->collTrustedShopsProtectionProductss as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTrustedShopsHasOrders !== null) {
					foreach($this->collTrustedShopsHasOrders as $referrerFK) {
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
		$pos = TrustedShopsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCertificate();
				break;
			case 4:
				return $this->getUsername();
				break;
			case 5:
				return $this->getPassword();
				break;
			case 6:
				return $this->getType();
				break;
			case 7:
				return $this->getUrl();
				break;
			case 8:
				return $this->getLanguage();
				break;
			case 9:
				return $this->getStatus();
				break;
			case 10:
				return $this->getLogo();
				break;
			case 11:
				return $this->getRatingWidget();
				break;
			case 12:
				return $this->getRatingStatus();
				break;
			case 13:
				return $this->getRatingInOrderMail();
				break;
			case 14:
				return $this->getTrustbadgeCode();
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
		$keys = TrustedShopsPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getCertificate(),
			$keys[4] => $this->getUsername(),
			$keys[5] => $this->getPassword(),
			$keys[6] => $this->getType(),
			$keys[7] => $this->getUrl(),
			$keys[8] => $this->getLanguage(),
			$keys[9] => $this->getStatus(),
			$keys[10] => $this->getLogo(),
			$keys[11] => $this->getRatingWidget(),
			$keys[12] => $this->getRatingStatus(),
			$keys[13] => $this->getRatingInOrderMail(),
			$keys[14] => $this->getTrustbadgeCode(),
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
		$pos = TrustedShopsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setCertificate($value);
				break;
			case 4:
				$this->setUsername($value);
				break;
			case 5:
				$this->setPassword($value);
				break;
			case 6:
				$this->setType($value);
				break;
			case 7:
				$this->setUrl($value);
				break;
			case 8:
				$this->setLanguage($value);
				break;
			case 9:
				$this->setStatus($value);
				break;
			case 10:
				$this->setLogo($value);
				break;
			case 11:
				$this->setRatingWidget($value);
				break;
			case 12:
				$this->setRatingStatus($value);
				break;
			case 13:
				$this->setRatingInOrderMail($value);
				break;
			case 14:
				$this->setTrustbadgeCode($value);
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
		$keys = TrustedShopsPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCertificate($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setUsername($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPassword($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setType($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setUrl($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setLanguage($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setStatus($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setLogo($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setRatingWidget($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setRatingStatus($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setRatingInOrderMail($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setTrustbadgeCode($arr[$keys[14]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(TrustedShopsPeer::DATABASE_NAME);

		if ($this->isColumnModified(TrustedShopsPeer::CREATED_AT)) $criteria->add(TrustedShopsPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(TrustedShopsPeer::UPDATED_AT)) $criteria->add(TrustedShopsPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(TrustedShopsPeer::ID)) $criteria->add(TrustedShopsPeer::ID, $this->id);
		if ($this->isColumnModified(TrustedShopsPeer::CERTIFICATE)) $criteria->add(TrustedShopsPeer::CERTIFICATE, $this->certificate);
		if ($this->isColumnModified(TrustedShopsPeer::USERNAME)) $criteria->add(TrustedShopsPeer::USERNAME, $this->username);
		if ($this->isColumnModified(TrustedShopsPeer::PASSWORD)) $criteria->add(TrustedShopsPeer::PASSWORD, $this->password);
		if ($this->isColumnModified(TrustedShopsPeer::TYPE)) $criteria->add(TrustedShopsPeer::TYPE, $this->type);
		if ($this->isColumnModified(TrustedShopsPeer::URL)) $criteria->add(TrustedShopsPeer::URL, $this->url);
		if ($this->isColumnModified(TrustedShopsPeer::LANGUAGE)) $criteria->add(TrustedShopsPeer::LANGUAGE, $this->language);
		if ($this->isColumnModified(TrustedShopsPeer::STATUS)) $criteria->add(TrustedShopsPeer::STATUS, $this->status);
		if ($this->isColumnModified(TrustedShopsPeer::LOGO)) $criteria->add(TrustedShopsPeer::LOGO, $this->logo);
		if ($this->isColumnModified(TrustedShopsPeer::RATING_WIDGET)) $criteria->add(TrustedShopsPeer::RATING_WIDGET, $this->rating_widget);
		if ($this->isColumnModified(TrustedShopsPeer::RATING_STATUS)) $criteria->add(TrustedShopsPeer::RATING_STATUS, $this->rating_status);
		if ($this->isColumnModified(TrustedShopsPeer::RATING_IN_ORDER_MAIL)) $criteria->add(TrustedShopsPeer::RATING_IN_ORDER_MAIL, $this->rating_in_order_mail);
		if ($this->isColumnModified(TrustedShopsPeer::TRUSTBADGE_CODE)) $criteria->add(TrustedShopsPeer::TRUSTBADGE_CODE, $this->trustbadge_code);

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
		$criteria = new Criteria(TrustedShopsPeer::DATABASE_NAME);

		$criteria->add(TrustedShopsPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of TrustedShops (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setCertificate($this->certificate);

		$copyObj->setUsername($this->username);

		$copyObj->setPassword($this->password);

		$copyObj->setType($this->type);

		$copyObj->setUrl($this->url);

		$copyObj->setLanguage($this->language);

		$copyObj->setStatus($this->status);

		$copyObj->setLogo($this->logo);

		$copyObj->setRatingWidget($this->rating_widget);

		$copyObj->setRatingStatus($this->rating_status);

		$copyObj->setRatingInOrderMail($this->rating_in_order_mail);

		$copyObj->setTrustbadgeCode($this->trustbadge_code);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getTrustedShopsHasPaymentTypes() as $relObj) {
				$copyObj->addTrustedShopsHasPaymentType($relObj->copy($deepCopy));
			}

			foreach($this->getTrustedShopsProtectionProductss() as $relObj) {
				$copyObj->addTrustedShopsProtectionProducts($relObj->copy($deepCopy));
			}

			foreach($this->getTrustedShopsHasOrders() as $relObj) {
				$copyObj->addTrustedShopsHasOrder($relObj->copy($deepCopy));
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
	 * @return     TrustedShops Clone of current object.
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
	 * @return     TrustedShopsPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new TrustedShopsPeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collTrustedShopsHasPaymentTypes to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initTrustedShopsHasPaymentTypes()
	{
		if ($this->collTrustedShopsHasPaymentTypes === null) {
			$this->collTrustedShopsHasPaymentTypes = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this TrustedShops has previously
	 * been saved, it will retrieve related TrustedShopsHasPaymentTypes from storage.
	 * If this TrustedShops is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getTrustedShopsHasPaymentTypes($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTrustedShopsHasPaymentTypes === null) {
			if ($this->isNew()) {
			   $this->collTrustedShopsHasPaymentTypes = array();
			} else {

				$criteria->add(TrustedShopsHasPaymentTypePeer::TRUSTED_SHOPS_ID, $this->getId());

				TrustedShopsHasPaymentTypePeer::addSelectColumns($criteria);
				$this->collTrustedShopsHasPaymentTypes = TrustedShopsHasPaymentTypePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(TrustedShopsHasPaymentTypePeer::TRUSTED_SHOPS_ID, $this->getId());

				TrustedShopsHasPaymentTypePeer::addSelectColumns($criteria);
				if (!isset($this->lastTrustedShopsHasPaymentTypeCriteria) || !$this->lastTrustedShopsHasPaymentTypeCriteria->equals($criteria)) {
					$this->collTrustedShopsHasPaymentTypes = TrustedShopsHasPaymentTypePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTrustedShopsHasPaymentTypeCriteria = $criteria;
		return $this->collTrustedShopsHasPaymentTypes;
	}

	/**
	 * Returns the number of related TrustedShopsHasPaymentTypes.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countTrustedShopsHasPaymentTypes($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TrustedShopsHasPaymentTypePeer::TRUSTED_SHOPS_ID, $this->getId());

		return TrustedShopsHasPaymentTypePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a TrustedShopsHasPaymentType object to this object
	 * through the TrustedShopsHasPaymentType foreign key attribute
	 *
	 * @param      TrustedShopsHasPaymentType $l TrustedShopsHasPaymentType
	 * @return     void
	 * @throws     PropelException
	 */
	public function addTrustedShopsHasPaymentType(TrustedShopsHasPaymentType $l)
	{
		$this->collTrustedShopsHasPaymentTypes[] = $l;
		$l->setTrustedShops($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this TrustedShops is new, it will return
	 * an empty collection; or if this TrustedShops has previously
	 * been saved, it will retrieve related TrustedShopsHasPaymentTypes from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in TrustedShops.
	 */
	public function getTrustedShopsHasPaymentTypesJoinPaymentType($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTrustedShopsHasPaymentTypes === null) {
			if ($this->isNew()) {
				$this->collTrustedShopsHasPaymentTypes = array();
			} else {

				$criteria->add(TrustedShopsHasPaymentTypePeer::TRUSTED_SHOPS_ID, $this->getId());

				$this->collTrustedShopsHasPaymentTypes = TrustedShopsHasPaymentTypePeer::doSelectJoinPaymentType($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(TrustedShopsHasPaymentTypePeer::TRUSTED_SHOPS_ID, $this->getId());

			if (!isset($this->lastTrustedShopsHasPaymentTypeCriteria) || !$this->lastTrustedShopsHasPaymentTypeCriteria->equals($criteria)) {
				$this->collTrustedShopsHasPaymentTypes = TrustedShopsHasPaymentTypePeer::doSelectJoinPaymentType($criteria, $con);
			}
		}
		$this->lastTrustedShopsHasPaymentTypeCriteria = $criteria;

		return $this->collTrustedShopsHasPaymentTypes;
	}

	/**
	 * Temporary storage of collTrustedShopsProtectionProductss to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initTrustedShopsProtectionProductss()
	{
		if ($this->collTrustedShopsProtectionProductss === null) {
			$this->collTrustedShopsProtectionProductss = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this TrustedShops has previously
	 * been saved, it will retrieve related TrustedShopsProtectionProductss from storage.
	 * If this TrustedShops is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getTrustedShopsProtectionProductss($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTrustedShopsProtectionProductss === null) {
			if ($this->isNew()) {
			   $this->collTrustedShopsProtectionProductss = array();
			} else {

				$criteria->add(TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID, $this->getId());

				TrustedShopsProtectionProductsPeer::addSelectColumns($criteria);
				$this->collTrustedShopsProtectionProductss = TrustedShopsProtectionProductsPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID, $this->getId());

				TrustedShopsProtectionProductsPeer::addSelectColumns($criteria);
				if (!isset($this->lastTrustedShopsProtectionProductsCriteria) || !$this->lastTrustedShopsProtectionProductsCriteria->equals($criteria)) {
					$this->collTrustedShopsProtectionProductss = TrustedShopsProtectionProductsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTrustedShopsProtectionProductsCriteria = $criteria;
		return $this->collTrustedShopsProtectionProductss;
	}

	/**
	 * Returns the number of related TrustedShopsProtectionProductss.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countTrustedShopsProtectionProductss($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID, $this->getId());

		return TrustedShopsProtectionProductsPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a TrustedShopsProtectionProducts object to this object
	 * through the TrustedShopsProtectionProducts foreign key attribute
	 *
	 * @param      TrustedShopsProtectionProducts $l TrustedShopsProtectionProducts
	 * @return     void
	 * @throws     PropelException
	 */
	public function addTrustedShopsProtectionProducts(TrustedShopsProtectionProducts $l)
	{
		$this->collTrustedShopsProtectionProductss[] = $l;
		$l->setTrustedShops($this);
	}

	/**
	 * Temporary storage of collTrustedShopsHasOrders to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initTrustedShopsHasOrders()
	{
		if ($this->collTrustedShopsHasOrders === null) {
			$this->collTrustedShopsHasOrders = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this TrustedShops has previously
	 * been saved, it will retrieve related TrustedShopsHasOrders from storage.
	 * If this TrustedShops is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getTrustedShopsHasOrders($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTrustedShopsHasOrders === null) {
			if ($this->isNew()) {
			   $this->collTrustedShopsHasOrders = array();
			} else {

				$criteria->add(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID, $this->getId());

				TrustedShopsHasOrderPeer::addSelectColumns($criteria);
				$this->collTrustedShopsHasOrders = TrustedShopsHasOrderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID, $this->getId());

				TrustedShopsHasOrderPeer::addSelectColumns($criteria);
				if (!isset($this->lastTrustedShopsHasOrderCriteria) || !$this->lastTrustedShopsHasOrderCriteria->equals($criteria)) {
					$this->collTrustedShopsHasOrders = TrustedShopsHasOrderPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTrustedShopsHasOrderCriteria = $criteria;
		return $this->collTrustedShopsHasOrders;
	}

	/**
	 * Returns the number of related TrustedShopsHasOrders.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countTrustedShopsHasOrders($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID, $this->getId());

		return TrustedShopsHasOrderPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a TrustedShopsHasOrder object to this object
	 * through the TrustedShopsHasOrder foreign key attribute
	 *
	 * @param      TrustedShopsHasOrder $l TrustedShopsHasOrder
	 * @return     void
	 * @throws     PropelException
	 */
	public function addTrustedShopsHasOrder(TrustedShopsHasOrder $l)
	{
		$this->collTrustedShopsHasOrders[] = $l;
		$l->setTrustedShops($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this TrustedShops is new, it will return
	 * an empty collection; or if this TrustedShops has previously
	 * been saved, it will retrieve related TrustedShopsHasOrders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in TrustedShops.
	 */
	public function getTrustedShopsHasOrdersJoinOrder($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTrustedShopsHasOrders === null) {
			if ($this->isNew()) {
				$this->collTrustedShopsHasOrders = array();
			} else {

				$criteria->add(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID, $this->getId());

				$this->collTrustedShopsHasOrders = TrustedShopsHasOrderPeer::doSelectJoinOrder($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(TrustedShopsHasOrderPeer::TRUSTED_SHOPS_ID, $this->getId());

			if (!isset($this->lastTrustedShopsHasOrderCriteria) || !$this->lastTrustedShopsHasOrderCriteria->equals($criteria)) {
				$this->collTrustedShopsHasOrders = TrustedShopsHasOrderPeer::doSelectJoinOrder($criteria, $con);
			}
		}
		$this->lastTrustedShopsHasOrderCriteria = $criteria;

		return $this->collTrustedShopsHasOrders;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'TrustedShops.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseTrustedShops:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseTrustedShops::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseTrustedShops
