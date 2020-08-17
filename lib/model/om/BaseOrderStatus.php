<?php

/**
 * Base class that represents a row from the 'st_order_status' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseOrderStatus extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        OrderStatusPeer
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
	 * The value for the coupon_code_id field.
	 * @var        int
	 */
	protected $coupon_code_id;


	/**
	 * The value for the opt_name field.
	 * @var        string
	 */
	protected $opt_name;


	/**
	 * The value for the opt_description field.
	 * @var        string
	 */
	protected $opt_description;


	/**
	 * The value for the type field.
	 * @var        string
	 */
	protected $type;


	/**
	 * The value for the is_default field.
	 * @var        boolean
	 */
	protected $is_default = false;


	/**
	 * The value for the is_system_default field.
	 * @var        boolean
	 */
	protected $is_system_default = false;


	/**
	 * The value for the has_mail_notification field.
	 * @var        boolean
	 */
	protected $has_mail_notification = true;


	/**
	 * The value for the has_coupon_code field.
	 * @var        boolean
	 */
	protected $has_coupon_code = false;


	/**
	 * The value for the has_invoice_proforma field.
	 * @var        boolean
	 */
	protected $has_invoice_proforma = false;


	/**
	 * The value for the has_invoice field.
	 * @var        boolean
	 */
	protected $has_invoice = false;


	/**
	 * The value for the depository_action field.
	 * @var        string
	 */
	protected $depository_action;

	/**
	 * @var        OrderStatusCouponCode
	 */
	protected $aOrderStatusCouponCode;

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
	 * Collection to store aggregation of collOrderStatusI18ns.
	 * @var        array
	 */
	protected $collOrderStatusI18ns;

	/**
	 * The criteria used to select the current contents of collOrderStatusI18ns.
	 * @var        Criteria
	 */
	protected $lastOrderStatusI18nCriteria = null;

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
   * The value for the culture field.
   * @var string
   */
  protected $culture;

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
     * Get the [coupon_code_id] column value.
     * 
     * @return     int
     */
    public function getCouponCodeId()
    {

            return $this->coupon_code_id;
    }

    /**
     * Get the [opt_name] column value.
     * 
     * @return     string
     */
    public function getOptName()
    {

            return $this->opt_name;
    }

    /**
     * Get the [opt_description] column value.
     * 
     * @return     string
     */
    public function getOptDescription()
    {

            return $this->opt_description;
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
     * Get the [is_default] column value.
     * 
     * @return     boolean
     */
    public function getIsDefault()
    {

            return $this->is_default;
    }

    /**
     * Get the [is_system_default] column value.
     * 
     * @return     boolean
     */
    public function getIsSystemDefault()
    {

            return $this->is_system_default;
    }

    /**
     * Get the [has_mail_notification] column value.
     * 
     * @return     boolean
     */
    public function getHasMailNotification()
    {

            return $this->has_mail_notification;
    }

    /**
     * Get the [has_coupon_code] column value.
     * 
     * @return     boolean
     */
    public function getHasCouponCode()
    {

            return $this->has_coupon_code;
    }

    /**
     * Get the [has_invoice_proforma] column value.
     * 
     * @return     boolean
     */
    public function getHasInvoiceProforma()
    {

            return $this->has_invoice_proforma;
    }

    /**
     * Get the [has_invoice] column value.
     * 
     * @return     boolean
     */
    public function getHasInvoice()
    {

            return $this->has_invoice;
    }

    /**
     * Get the [depository_action] column value.
     * 
     * @return     string
     */
    public function getDepositoryAction()
    {

            return $this->depository_action;
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
			$this->modifiedColumns[] = OrderStatusPeer::CREATED_AT;
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
			$this->modifiedColumns[] = OrderStatusPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = OrderStatusPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [coupon_code_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCouponCodeId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->coupon_code_id !== $v) {
          $this->coupon_code_id = $v;
          $this->modifiedColumns[] = OrderStatusPeer::COUPON_CODE_ID;
        }

		if ($this->aOrderStatusCouponCode !== null && $this->aOrderStatusCouponCode->getId() !== $v) {
			$this->aOrderStatusCouponCode = null;
		}

	} // setCouponCodeId()

	/**
	 * Set the value of [opt_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptName($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_name !== $v) {
          $this->opt_name = $v;
          $this->modifiedColumns[] = OrderStatusPeer::OPT_NAME;
        }

	} // setOptName()

	/**
	 * Set the value of [opt_description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_description !== $v) {
          $this->opt_description = $v;
          $this->modifiedColumns[] = OrderStatusPeer::OPT_DESCRIPTION;
        }

	} // setOptDescription()

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
          $this->modifiedColumns[] = OrderStatusPeer::TYPE;
        }

	} // setType()

	/**
	 * Set the value of [is_default] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsDefault($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_default !== $v || $v === false) {
          $this->is_default = $v;
          $this->modifiedColumns[] = OrderStatusPeer::IS_DEFAULT;
        }

	} // setIsDefault()

	/**
	 * Set the value of [is_system_default] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsSystemDefault($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_system_default !== $v || $v === false) {
          $this->is_system_default = $v;
          $this->modifiedColumns[] = OrderStatusPeer::IS_SYSTEM_DEFAULT;
        }

	} // setIsSystemDefault()

	/**
	 * Set the value of [has_mail_notification] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setHasMailNotification($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->has_mail_notification !== $v || $v === true) {
          $this->has_mail_notification = $v;
          $this->modifiedColumns[] = OrderStatusPeer::HAS_MAIL_NOTIFICATION;
        }

	} // setHasMailNotification()

	/**
	 * Set the value of [has_coupon_code] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setHasCouponCode($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->has_coupon_code !== $v || $v === false) {
          $this->has_coupon_code = $v;
          $this->modifiedColumns[] = OrderStatusPeer::HAS_COUPON_CODE;
        }

	} // setHasCouponCode()

	/**
	 * Set the value of [has_invoice_proforma] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setHasInvoiceProforma($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->has_invoice_proforma !== $v || $v === false) {
          $this->has_invoice_proforma = $v;
          $this->modifiedColumns[] = OrderStatusPeer::HAS_INVOICE_PROFORMA;
        }

	} // setHasInvoiceProforma()

	/**
	 * Set the value of [has_invoice] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setHasInvoice($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->has_invoice !== $v || $v === false) {
          $this->has_invoice = $v;
          $this->modifiedColumns[] = OrderStatusPeer::HAS_INVOICE;
        }

	} // setHasInvoice()

	/**
	 * Set the value of [depository_action] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setDepositoryAction($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->depository_action !== $v) {
          $this->depository_action = $v;
          $this->modifiedColumns[] = OrderStatusPeer::DEPOSITORY_ACTION;
        }

	} // setDepositoryAction()

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
      if ($this->getDispatcher()->getListeners('OrderStatus.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'OrderStatus.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->coupon_code_id = $rs->getInt($startcol + 3);

      $this->opt_name = $rs->getString($startcol + 4);

      $this->opt_description = $rs->getString($startcol + 5);

      $this->type = $rs->getString($startcol + 6);

      $this->is_default = $rs->getBoolean($startcol + 7);

      $this->is_system_default = $rs->getBoolean($startcol + 8);

      $this->has_mail_notification = $rs->getBoolean($startcol + 9);

      $this->has_coupon_code = $rs->getBoolean($startcol + 10);

      $this->has_invoice_proforma = $rs->getBoolean($startcol + 11);

      $this->has_invoice = $rs->getBoolean($startcol + 12);

      $this->depository_action = $rs->getString($startcol + 13);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('OrderStatus.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'OrderStatus.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 14)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 14; // 14 = OrderStatusPeer::NUM_COLUMNS - OrderStatusPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating OrderStatus object", $e);
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

    if ($this->getDispatcher()->getListeners('OrderStatus.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'OrderStatus.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseOrderStatus:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseOrderStatus:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(OrderStatusPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      OrderStatusPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('OrderStatus.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'OrderStatus.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseOrderStatus:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseOrderStatus:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('OrderStatus.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'OrderStatus.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseOrderStatus:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(OrderStatusPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(OrderStatusPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(OrderStatusPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('OrderStatus.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'OrderStatus.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseOrderStatus:save:post') as $callable)
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

			if ($this->aOrderStatusCouponCode !== null) {
				if ($this->aOrderStatusCouponCode->isModified()) {
					$affectedRows += $this->aOrderStatusCouponCode->save($con);
				}
				$this->setOrderStatusCouponCode($this->aOrderStatusCouponCode);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OrderStatusPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += OrderStatusPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collOrders !== null) {
				foreach($this->collOrders as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOrderStatusI18ns !== null) {
				foreach($this->collOrderStatusI18ns as $referrerFK) {
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


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aOrderStatusCouponCode !== null) {
				if (!$this->aOrderStatusCouponCode->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOrderStatusCouponCode->getValidationFailures());
				}
			}


			if (($retval = OrderStatusPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOrders !== null) {
					foreach($this->collOrders as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOrderStatusI18ns !== null) {
					foreach($this->collOrderStatusI18ns as $referrerFK) {
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
		$pos = OrderStatusPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCouponCodeId();
				break;
			case 4:
				return $this->getOptName();
				break;
			case 5:
				return $this->getOptDescription();
				break;
			case 6:
				return $this->getType();
				break;
			case 7:
				return $this->getIsDefault();
				break;
			case 8:
				return $this->getIsSystemDefault();
				break;
			case 9:
				return $this->getHasMailNotification();
				break;
			case 10:
				return $this->getHasCouponCode();
				break;
			case 11:
				return $this->getHasInvoiceProforma();
				break;
			case 12:
				return $this->getHasInvoice();
				break;
			case 13:
				return $this->getDepositoryAction();
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
		$keys = OrderStatusPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getCouponCodeId(),
			$keys[4] => $this->getOptName(),
			$keys[5] => $this->getOptDescription(),
			$keys[6] => $this->getType(),
			$keys[7] => $this->getIsDefault(),
			$keys[8] => $this->getIsSystemDefault(),
			$keys[9] => $this->getHasMailNotification(),
			$keys[10] => $this->getHasCouponCode(),
			$keys[11] => $this->getHasInvoiceProforma(),
			$keys[12] => $this->getHasInvoice(),
			$keys[13] => $this->getDepositoryAction(),
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
		$pos = OrderStatusPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setCouponCodeId($value);
				break;
			case 4:
				$this->setOptName($value);
				break;
			case 5:
				$this->setOptDescription($value);
				break;
			case 6:
				$this->setType($value);
				break;
			case 7:
				$this->setIsDefault($value);
				break;
			case 8:
				$this->setIsSystemDefault($value);
				break;
			case 9:
				$this->setHasMailNotification($value);
				break;
			case 10:
				$this->setHasCouponCode($value);
				break;
			case 11:
				$this->setHasInvoiceProforma($value);
				break;
			case 12:
				$this->setHasInvoice($value);
				break;
			case 13:
				$this->setDepositoryAction($value);
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
		$keys = OrderStatusPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCouponCodeId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setOptName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOptDescription($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setType($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsDefault($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsSystemDefault($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setHasMailNotification($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setHasCouponCode($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setHasInvoiceProforma($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setHasInvoice($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setDepositoryAction($arr[$keys[13]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(OrderStatusPeer::DATABASE_NAME);

		if ($this->isColumnModified(OrderStatusPeer::CREATED_AT)) $criteria->add(OrderStatusPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(OrderStatusPeer::UPDATED_AT)) $criteria->add(OrderStatusPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(OrderStatusPeer::ID)) $criteria->add(OrderStatusPeer::ID, $this->id);
		if ($this->isColumnModified(OrderStatusPeer::COUPON_CODE_ID)) $criteria->add(OrderStatusPeer::COUPON_CODE_ID, $this->coupon_code_id);
		if ($this->isColumnModified(OrderStatusPeer::OPT_NAME)) $criteria->add(OrderStatusPeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(OrderStatusPeer::OPT_DESCRIPTION)) $criteria->add(OrderStatusPeer::OPT_DESCRIPTION, $this->opt_description);
		if ($this->isColumnModified(OrderStatusPeer::TYPE)) $criteria->add(OrderStatusPeer::TYPE, $this->type);
		if ($this->isColumnModified(OrderStatusPeer::IS_DEFAULT)) $criteria->add(OrderStatusPeer::IS_DEFAULT, $this->is_default);
		if ($this->isColumnModified(OrderStatusPeer::IS_SYSTEM_DEFAULT)) $criteria->add(OrderStatusPeer::IS_SYSTEM_DEFAULT, $this->is_system_default);
		if ($this->isColumnModified(OrderStatusPeer::HAS_MAIL_NOTIFICATION)) $criteria->add(OrderStatusPeer::HAS_MAIL_NOTIFICATION, $this->has_mail_notification);
		if ($this->isColumnModified(OrderStatusPeer::HAS_COUPON_CODE)) $criteria->add(OrderStatusPeer::HAS_COUPON_CODE, $this->has_coupon_code);
		if ($this->isColumnModified(OrderStatusPeer::HAS_INVOICE_PROFORMA)) $criteria->add(OrderStatusPeer::HAS_INVOICE_PROFORMA, $this->has_invoice_proforma);
		if ($this->isColumnModified(OrderStatusPeer::HAS_INVOICE)) $criteria->add(OrderStatusPeer::HAS_INVOICE, $this->has_invoice);
		if ($this->isColumnModified(OrderStatusPeer::DEPOSITORY_ACTION)) $criteria->add(OrderStatusPeer::DEPOSITORY_ACTION, $this->depository_action);

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
		$criteria = new Criteria(OrderStatusPeer::DATABASE_NAME);

		$criteria->add(OrderStatusPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of OrderStatus (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setCouponCodeId($this->coupon_code_id);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setOptDescription($this->opt_description);

		$copyObj->setType($this->type);

		$copyObj->setIsDefault($this->is_default);

		$copyObj->setIsSystemDefault($this->is_system_default);

		$copyObj->setHasMailNotification($this->has_mail_notification);

		$copyObj->setHasCouponCode($this->has_coupon_code);

		$copyObj->setHasInvoiceProforma($this->has_invoice_proforma);

		$copyObj->setHasInvoice($this->has_invoice);

		$copyObj->setDepositoryAction($this->depository_action);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getOrders() as $relObj) {
				$copyObj->addOrder($relObj->copy($deepCopy));
			}

			foreach($this->getOrderStatusI18ns() as $relObj) {
				$copyObj->addOrderStatusI18n($relObj->copy($deepCopy));
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
	 * @return     OrderStatus Clone of current object.
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
	 * @return     OrderStatusPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new OrderStatusPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a OrderStatusCouponCode object.
	 *
	 * @param      OrderStatusCouponCode $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setOrderStatusCouponCode($v)
	{


		if ($v === null) {
			$this->setCouponCodeId(NULL);
		} else {
			$this->setCouponCodeId($v->getId());
		}


		$this->aOrderStatusCouponCode = $v;
	}


	/**
	 * Get the associated OrderStatusCouponCode object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     OrderStatusCouponCode The associated OrderStatusCouponCode object.
	 * @throws     PropelException
	 */
	public function getOrderStatusCouponCode($con = null)
	{
		if ($this->aOrderStatusCouponCode === null && ($this->coupon_code_id !== null)) {
			// include the related Peer class
			$this->aOrderStatusCouponCode = OrderStatusCouponCodePeer::retrieveByPK($this->coupon_code_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = OrderStatusCouponCodePeer::retrieveByPK($this->coupon_code_id, $con);
			   $obj->addOrderStatusCouponCodes($this);
			 */
		}
		return $this->aOrderStatusCouponCode;
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
	 * Otherwise if this OrderStatus has previously
	 * been saved, it will retrieve related Orders from storage.
	 * If this OrderStatus is new, it will return
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

				$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

				OrderPeer::addSelectColumns($criteria);
				$this->collOrders = OrderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

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

		$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

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
		$l->setOrderStatus($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this OrderStatus is new, it will return
	 * an empty collection; or if this OrderStatus has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderStatus.
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

				$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

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
	 * Otherwise if this OrderStatus is new, it will return
	 * an empty collection; or if this OrderStatus has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderStatus.
	 */
	public function getOrdersJoinsfGuardUser($criteria = null, $con = null)
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

				$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this OrderStatus is new, it will return
	 * an empty collection; or if this OrderStatus has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderStatus.
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

				$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

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
	 * Otherwise if this OrderStatus is new, it will return
	 * an empty collection; or if this OrderStatus has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderStatus.
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

				$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataBilling($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

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
	 * Otherwise if this OrderStatus is new, it will return
	 * an empty collection; or if this OrderStatus has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderStatus.
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

				$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

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
	 * Otherwise if this OrderStatus is new, it will return
	 * an empty collection; or if this OrderStatus has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderStatus.
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

				$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

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
	 * Otherwise if this OrderStatus is new, it will return
	 * an empty collection; or if this OrderStatus has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderStatus.
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

				$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinDiscount($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

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
	 * Otherwise if this OrderStatus is new, it will return
	 * an empty collection; or if this OrderStatus has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderStatus.
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

				$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinPartner($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinPartner($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}

	/**
	 * Temporary storage of collOrderStatusI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOrderStatusI18ns()
	{
		if ($this->collOrderStatusI18ns === null) {
			$this->collOrderStatusI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this OrderStatus has previously
	 * been saved, it will retrieve related OrderStatusI18ns from storage.
	 * If this OrderStatus is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOrderStatusI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderStatusI18ns === null) {
			if ($this->isNew()) {
			   $this->collOrderStatusI18ns = array();
			} else {

				$criteria->add(OrderStatusI18nPeer::ID, $this->getId());

				OrderStatusI18nPeer::addSelectColumns($criteria);
				$this->collOrderStatusI18ns = OrderStatusI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderStatusI18nPeer::ID, $this->getId());

				OrderStatusI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastOrderStatusI18nCriteria) || !$this->lastOrderStatusI18nCriteria->equals($criteria)) {
					$this->collOrderStatusI18ns = OrderStatusI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOrderStatusI18nCriteria = $criteria;
		return $this->collOrderStatusI18ns;
	}

	/**
	 * Returns the number of related OrderStatusI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOrderStatusI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OrderStatusI18nPeer::ID, $this->getId());

		return OrderStatusI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a OrderStatusI18n object to this object
	 * through the OrderStatusI18n foreign key attribute
	 *
	 * @param      OrderStatusI18n $l OrderStatusI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOrderStatusI18n(OrderStatusI18n $l)
	{
		$this->collOrderStatusI18ns[] = $l;
		$l->setOrderStatus($this);
	}

  public function getCulture()
  {
    return $this->culture;
  }

  public function setCulture($culture)
  {
    $this->culture = $culture;
  }

  public function getName()
  {
    $obj = $this->getCurrentOrderStatusI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentOrderStatusI18n()->setName($value);
  }

  public function getDescription()
  {
    $obj = $this->getCurrentOrderStatusI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentOrderStatusI18n()->setDescription($value);
  }

  public $current_i18n = array();

  public function getCurrentOrderStatusI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = OrderStatusI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setOrderStatusI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setOrderStatusI18nForCulture(new OrderStatusI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setOrderStatusI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addOrderStatusI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'OrderStatus.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseOrderStatus:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseOrderStatus::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseOrderStatus
