<?php

/**
 * Base class that represents a row from the 'st_payment' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePayment extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PaymentPeer
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
	 * The value for the sf_guard_user_id field.
	 * @var        int
	 */
	protected $sf_guard_user_id;


	/**
	 * The value for the payment_type_id field.
	 * @var        int
	 */
	protected $payment_type_id;


	/**
	 * The value for the amount field.
	 * @var        double
	 */
	protected $amount;


	/**
	 * The value for the status field.
	 * @var        boolean
	 */
	protected $status = false;


	/**
	 * The value for the in_progress field.
	 * @var        boolean
	 */
	protected $in_progress = false;


	/**
	 * The value for the cancel field.
	 * @var        boolean
	 */
	protected $cancel = false;


	/**
	 * The value for the transaction_id field.
	 * @var        string
	 */
	protected $transaction_id;


	/**
	 * The value for the hash field.
	 * @var        string
	 */
	protected $hash;


	/**
	 * The value for the payment_security_hash field.
	 * @var        string
	 */
	protected $payment_security_hash;


	/**
	 * The value for the payed_at field.
	 * @var        int
	 */
	protected $payed_at;


	/**
	 * The value for the version field.
	 * @var        int
	 */
	protected $version;


	/**
	 * The value for the configuration field.
	 * @var        string
	 */
	protected $configuration;


	/**
	 * The value for the allegro_payment_type field.
	 * @var        string
	 */
	protected $allegro_payment_type;


	/**
	 * The value for the gift_card_id field.
	 * @var        int
	 */
	protected $gift_card_id;

	/**
	 * @var        sfGuardUser
	 */
	protected $asfGuardUser;

	/**
	 * @var        PaymentType
	 */
	protected $aPaymentType;

	/**
	 * @var        GiftCard
	 */
	protected $aGiftCard;

	/**
	 * Collection to store aggregation of collOrderHasPayments.
	 * @var        array
	 */
	protected $collOrderHasPayments;

	/**
	 * The criteria used to select the current contents of collOrderHasPayments.
	 * @var        Criteria
	 */
	protected $lastOrderHasPaymentCriteria = null;

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
     * Get the [sf_guard_user_id] column value.
     * 
     * @return     int
     */
    public function getSfGuardUserId()
    {

            return $this->sf_guard_user_id;
    }

    /**
     * Get the [payment_type_id] column value.
     * 
     * @return     int
     */
    public function getPaymentTypeId()
    {

            return $this->payment_type_id;
    }

    /**
     * Get the [amount] column value.
     * 
     * @return     double
     */
    public function getAmount()
    {

            return null !== $this->amount ? (string)$this->amount : null;
    }

    /**
     * Get the [status] column value.
     * 
     * @return     boolean
     */
    public function getStatus()
    {

            return $this->status;
    }

    /**
     * Get the [in_progress] column value.
     * 
     * @return     boolean
     */
    public function getInProgress()
    {

            return $this->in_progress;
    }

    /**
     * Get the [cancel] column value.
     * 
     * @return     boolean
     */
    public function getCancel()
    {

            return $this->cancel;
    }

    /**
     * Get the [transaction_id] column value.
     * 
     * @return     string
     */
    public function getTransactionId()
    {

            return $this->transaction_id;
    }

    /**
     * Get the [hash] column value.
     * 
     * @return     string
     */
    public function getHash()
    {

            return $this->hash;
    }

    /**
     * Get the [payment_security_hash] column value.
     * 
     * @return     string
     */
    public function getPaymentSecurityHash()
    {

            return $this->payment_security_hash;
    }

	/**
	 * Get the [optionally formatted] [payed_at] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getPayedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->payed_at === null || $this->payed_at === '') {
			return null;
		} elseif (!is_int($this->payed_at)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->payed_at);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [payed_at] as date/time value: " . var_export($this->payed_at, true));
			}
		} else {
			$ts = $this->payed_at;
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
     * Get the [version] column value.
     * 
     * @return     int
     */
    public function getVersion()
    {

            return $this->version;
    }

    /**
     * Get the [configuration] column value.
     * 
     * @return     string
     */
    public function getConfiguration()
    {

            return $this->configuration;
    }

    /**
     * Get the [allegro_payment_type] column value.
     * 
     * @return     string
     */
    public function getAllegroPaymentType()
    {

            return $this->allegro_payment_type;
    }

    /**
     * Get the [gift_card_id] column value.
     * 
     * @return     int
     */
    public function getGiftCardId()
    {

            return $this->gift_card_id;
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
			$this->modifiedColumns[] = PaymentPeer::CREATED_AT;
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
			$this->modifiedColumns[] = PaymentPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = PaymentPeer::ID;
        }

	} // setId()

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
          $this->modifiedColumns[] = PaymentPeer::SF_GUARD_USER_ID;
        }

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} // setSfGuardUserId()

	/**
	 * Set the value of [payment_type_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPaymentTypeId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->payment_type_id !== $v) {
          $this->payment_type_id = $v;
          $this->modifiedColumns[] = PaymentPeer::PAYMENT_TYPE_ID;
        }

		if ($this->aPaymentType !== null && $this->aPaymentType->getId() !== $v) {
			$this->aPaymentType = null;
		}

	} // setPaymentTypeId()

	/**
	 * Set the value of [amount] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setAmount($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->amount !== $v) {
          $this->amount = $v;
          $this->modifiedColumns[] = PaymentPeer::AMOUNT;
        }

	} // setAmount()

	/**
	 * Set the value of [status] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setStatus($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->status !== $v || $v === false) {
          $this->status = $v;
          $this->modifiedColumns[] = PaymentPeer::STATUS;
        }

	} // setStatus()

	/**
	 * Set the value of [in_progress] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setInProgress($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->in_progress !== $v || $v === false) {
          $this->in_progress = $v;
          $this->modifiedColumns[] = PaymentPeer::IN_PROGRESS;
        }

	} // setInProgress()

	/**
	 * Set the value of [cancel] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setCancel($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->cancel !== $v || $v === false) {
          $this->cancel = $v;
          $this->modifiedColumns[] = PaymentPeer::CANCEL;
        }

	} // setCancel()

	/**
	 * Set the value of [transaction_id] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTransactionId($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->transaction_id !== $v) {
          $this->transaction_id = $v;
          $this->modifiedColumns[] = PaymentPeer::TRANSACTION_ID;
        }

	} // setTransactionId()

	/**
	 * Set the value of [hash] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setHash($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->hash !== $v) {
          $this->hash = $v;
          $this->modifiedColumns[] = PaymentPeer::HASH;
        }

	} // setHash()

	/**
	 * Set the value of [payment_security_hash] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPaymentSecurityHash($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->payment_security_hash !== $v) {
          $this->payment_security_hash = $v;
          $this->modifiedColumns[] = PaymentPeer::PAYMENT_SECURITY_HASH;
        }

	} // setPaymentSecurityHash()

	/**
	 * Set the value of [payed_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPayedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [payed_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->payed_at !== $ts) {
			$this->payed_at = $ts;
			$this->modifiedColumns[] = PaymentPeer::PAYED_AT;
		}

	} // setPayedAt()

	/**
	 * Set the value of [version] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setVersion($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->version !== $v) {
          $this->version = $v;
          $this->modifiedColumns[] = PaymentPeer::VERSION;
        }

	} // setVersion()

	/**
	 * Set the value of [configuration] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setConfiguration($v)
	{

        if ($this->configuration !== $v) {
          $this->configuration = $v;
          $this->modifiedColumns[] = PaymentPeer::CONFIGURATION;
        }

	} // setConfiguration()

	/**
	 * Set the value of [allegro_payment_type] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setAllegroPaymentType($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->allegro_payment_type !== $v) {
          $this->allegro_payment_type = $v;
          $this->modifiedColumns[] = PaymentPeer::ALLEGRO_PAYMENT_TYPE;
        }

	} // setAllegroPaymentType()

	/**
	 * Set the value of [gift_card_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setGiftCardId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->gift_card_id !== $v) {
          $this->gift_card_id = $v;
          $this->modifiedColumns[] = PaymentPeer::GIFT_CARD_ID;
        }

		if ($this->aGiftCard !== null && $this->aGiftCard->getId() !== $v) {
			$this->aGiftCard = null;
		}

	} // setGiftCardId()

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
      if ($this->getDispatcher()->getListeners('Payment.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Payment.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->sf_guard_user_id = $rs->getInt($startcol + 3);

      $this->payment_type_id = $rs->getInt($startcol + 4);

      $this->amount = $rs->getString($startcol + 5);
      if (null !== $this->amount && $this->amount == intval($this->amount))
      {
        $this->amount = (string)intval($this->amount);
      }

      $this->status = $rs->getBoolean($startcol + 6);

      $this->in_progress = $rs->getBoolean($startcol + 7);

      $this->cancel = $rs->getBoolean($startcol + 8);

      $this->transaction_id = $rs->getString($startcol + 9);

      $this->hash = $rs->getString($startcol + 10);

      $this->payment_security_hash = $rs->getString($startcol + 11);

      $this->payed_at = $rs->getTimestamp($startcol + 12, null);

      $this->version = $rs->getInt($startcol + 13);

      $this->configuration = $rs->getString($startcol + 14) ? unserialize($rs->getString($startcol + 14)) : null;

      $this->allegro_payment_type = $rs->getString($startcol + 15);

      $this->gift_card_id = $rs->getInt($startcol + 16);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Payment.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Payment.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 17)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 17; // 17 = PaymentPeer::NUM_COLUMNS - PaymentPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Payment object", $e);
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

    if ($this->getDispatcher()->getListeners('Payment.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Payment.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePayment:delete:pre'))
    {
      foreach (sfMixer::getCallables('BasePayment:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(PaymentPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      PaymentPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Payment.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Payment.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePayment:delete:post'))
    {
      foreach (sfMixer::getCallables('BasePayment:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Payment.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Payment.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BasePayment:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(PaymentPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(PaymentPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(PaymentPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Payment.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Payment.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BasePayment:save:post') as $callable)
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

			if ($this->asfGuardUser !== null) {
				if ($this->asfGuardUser->isModified()) {
					$affectedRows += $this->asfGuardUser->save($con);
				}
				$this->setsfGuardUser($this->asfGuardUser);
			}

			if ($this->aPaymentType !== null) {
				if ($this->aPaymentType->isModified() || $this->aPaymentType->getCurrentPaymentTypeI18n()->isModified()) {
					$affectedRows += $this->aPaymentType->save($con);
				}
				$this->setPaymentType($this->aPaymentType);
			}

			if ($this->aGiftCard !== null) {
				if ($this->aGiftCard->isModified()) {
					$affectedRows += $this->aGiftCard->save($con);
				}
				$this->setGiftCard($this->aGiftCard);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
              $o_configuration = $this->configuration;
              if (null !== $this->configuration && $this->isColumnModified(PaymentPeer::CONFIGURATION)) {
                  $this->configuration = serialize($this->configuration);
              }

				if ($this->isNew()) {
					$pk = PaymentPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PaymentPeer::doUpdate($this, $con);
				}
				$this->resetModified();
             $this->configuration = $o_configuration;
 // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collOrderHasPayments !== null) {
				foreach($this->collOrderHasPayments as $referrerFK) {
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

			if ($this->asfGuardUser !== null) {
				if (!$this->asfGuardUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUser->getValidationFailures());
				}
			}

			if ($this->aPaymentType !== null) {
				if (!$this->aPaymentType->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPaymentType->getValidationFailures());
				}
			}

			if ($this->aGiftCard !== null) {
				if (!$this->aGiftCard->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aGiftCard->getValidationFailures());
				}
			}


			if (($retval = PaymentPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOrderHasPayments !== null) {
					foreach($this->collOrderHasPayments as $referrerFK) {
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
		$pos = PaymentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getSfGuardUserId();
				break;
			case 4:
				return $this->getPaymentTypeId();
				break;
			case 5:
				return $this->getAmount();
				break;
			case 6:
				return $this->getStatus();
				break;
			case 7:
				return $this->getInProgress();
				break;
			case 8:
				return $this->getCancel();
				break;
			case 9:
				return $this->getTransactionId();
				break;
			case 10:
				return $this->getHash();
				break;
			case 11:
				return $this->getPaymentSecurityHash();
				break;
			case 12:
				return $this->getPayedAt();
				break;
			case 13:
				return $this->getVersion();
				break;
			case 14:
				return $this->getConfiguration();
				break;
			case 15:
				return $this->getAllegroPaymentType();
				break;
			case 16:
				return $this->getGiftCardId();
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
		$keys = PaymentPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getSfGuardUserId(),
			$keys[4] => $this->getPaymentTypeId(),
			$keys[5] => $this->getAmount(),
			$keys[6] => $this->getStatus(),
			$keys[7] => $this->getInProgress(),
			$keys[8] => $this->getCancel(),
			$keys[9] => $this->getTransactionId(),
			$keys[10] => $this->getHash(),
			$keys[11] => $this->getPaymentSecurityHash(),
			$keys[12] => $this->getPayedAt(),
			$keys[13] => $this->getVersion(),
			$keys[14] => $this->getConfiguration(),
			$keys[15] => $this->getAllegroPaymentType(),
			$keys[16] => $this->getGiftCardId(),
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
		$pos = PaymentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setSfGuardUserId($value);
				break;
			case 4:
				$this->setPaymentTypeId($value);
				break;
			case 5:
				$this->setAmount($value);
				break;
			case 6:
				$this->setStatus($value);
				break;
			case 7:
				$this->setInProgress($value);
				break;
			case 8:
				$this->setCancel($value);
				break;
			case 9:
				$this->setTransactionId($value);
				break;
			case 10:
				$this->setHash($value);
				break;
			case 11:
				$this->setPaymentSecurityHash($value);
				break;
			case 12:
				$this->setPayedAt($value);
				break;
			case 13:
				$this->setVersion($value);
				break;
			case 14:
				$this->setConfiguration($value);
				break;
			case 15:
				$this->setAllegroPaymentType($value);
				break;
			case 16:
				$this->setGiftCardId($value);
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
		$keys = PaymentPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSfGuardUserId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPaymentTypeId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setAmount($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setStatus($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setInProgress($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCancel($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setTransactionId($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setHash($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setPaymentSecurityHash($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setPayedAt($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setVersion($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setConfiguration($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setAllegroPaymentType($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setGiftCardId($arr[$keys[16]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PaymentPeer::DATABASE_NAME);

		if ($this->isColumnModified(PaymentPeer::CREATED_AT)) $criteria->add(PaymentPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(PaymentPeer::UPDATED_AT)) $criteria->add(PaymentPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(PaymentPeer::ID)) $criteria->add(PaymentPeer::ID, $this->id);
		if ($this->isColumnModified(PaymentPeer::SF_GUARD_USER_ID)) $criteria->add(PaymentPeer::SF_GUARD_USER_ID, $this->sf_guard_user_id);
		if ($this->isColumnModified(PaymentPeer::PAYMENT_TYPE_ID)) $criteria->add(PaymentPeer::PAYMENT_TYPE_ID, $this->payment_type_id);
		if ($this->isColumnModified(PaymentPeer::AMOUNT)) $criteria->add(PaymentPeer::AMOUNT, $this->amount);
		if ($this->isColumnModified(PaymentPeer::STATUS)) $criteria->add(PaymentPeer::STATUS, $this->status);
		if ($this->isColumnModified(PaymentPeer::IN_PROGRESS)) $criteria->add(PaymentPeer::IN_PROGRESS, $this->in_progress);
		if ($this->isColumnModified(PaymentPeer::CANCEL)) $criteria->add(PaymentPeer::CANCEL, $this->cancel);
		if ($this->isColumnModified(PaymentPeer::TRANSACTION_ID)) $criteria->add(PaymentPeer::TRANSACTION_ID, $this->transaction_id);
		if ($this->isColumnModified(PaymentPeer::HASH)) $criteria->add(PaymentPeer::HASH, $this->hash);
		if ($this->isColumnModified(PaymentPeer::PAYMENT_SECURITY_HASH)) $criteria->add(PaymentPeer::PAYMENT_SECURITY_HASH, $this->payment_security_hash);
		if ($this->isColumnModified(PaymentPeer::PAYED_AT)) $criteria->add(PaymentPeer::PAYED_AT, $this->payed_at);
		if ($this->isColumnModified(PaymentPeer::VERSION)) $criteria->add(PaymentPeer::VERSION, $this->version);
		if ($this->isColumnModified(PaymentPeer::CONFIGURATION)) $criteria->add(PaymentPeer::CONFIGURATION, $this->configuration);
		if ($this->isColumnModified(PaymentPeer::ALLEGRO_PAYMENT_TYPE)) $criteria->add(PaymentPeer::ALLEGRO_PAYMENT_TYPE, $this->allegro_payment_type);
		if ($this->isColumnModified(PaymentPeer::GIFT_CARD_ID)) $criteria->add(PaymentPeer::GIFT_CARD_ID, $this->gift_card_id);

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
		$criteria = new Criteria(PaymentPeer::DATABASE_NAME);

		$criteria->add(PaymentPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Payment (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setSfGuardUserId($this->sf_guard_user_id);

		$copyObj->setPaymentTypeId($this->payment_type_id);

		$copyObj->setAmount($this->amount);

		$copyObj->setStatus($this->status);

		$copyObj->setInProgress($this->in_progress);

		$copyObj->setCancel($this->cancel);

		$copyObj->setTransactionId($this->transaction_id);

		$copyObj->setHash($this->hash);

		$copyObj->setPaymentSecurityHash($this->payment_security_hash);

		$copyObj->setPayedAt($this->payed_at);

		$copyObj->setVersion($this->version);

		$copyObj->setConfiguration($this->configuration);

		$copyObj->setAllegroPaymentType($this->allegro_payment_type);

		$copyObj->setGiftCardId($this->gift_card_id);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getOrderHasPayments() as $relObj) {
				$copyObj->addOrderHasPayment($relObj->copy($deepCopy));
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
	 * @return     Payment Clone of current object.
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
	 * @return     PaymentPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PaymentPeer();
		}
		return self::$peer;
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
	 * Declares an association between this object and a PaymentType object.
	 *
	 * @param      PaymentType $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setPaymentType($v)
	{


		if ($v === null) {
			$this->setPaymentTypeId(NULL);
		} else {
			$this->setPaymentTypeId($v->getId());
		}


		$this->aPaymentType = $v;
	}


	/**
	 * Get the associated PaymentType object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     PaymentType The associated PaymentType object.
	 * @throws     PropelException
	 */
	public function getPaymentType($con = null)
	{
		if ($this->aPaymentType === null && ($this->payment_type_id !== null)) {
			// include the related Peer class
			$this->aPaymentType = PaymentTypePeer::retrieveByPK($this->payment_type_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = PaymentTypePeer::retrieveByPK($this->payment_type_id, $con);
			   $obj->addPaymentTypes($this);
			 */
		}
		return $this->aPaymentType;
	}

	/**
	 * Declares an association between this object and a GiftCard object.
	 *
	 * @param      GiftCard $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setGiftCard($v)
	{


		if ($v === null) {
			$this->setGiftCardId(NULL);
		} else {
			$this->setGiftCardId($v->getId());
		}


		$this->aGiftCard = $v;
	}


	/**
	 * Get the associated GiftCard object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     GiftCard The associated GiftCard object.
	 * @throws     PropelException
	 */
	public function getGiftCard($con = null)
	{
		if ($this->aGiftCard === null && ($this->gift_card_id !== null)) {
			// include the related Peer class
			$this->aGiftCard = GiftCardPeer::retrieveByPK($this->gift_card_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = GiftCardPeer::retrieveByPK($this->gift_card_id, $con);
			   $obj->addGiftCards($this);
			 */
		}
		return $this->aGiftCard;
	}

	/**
	 * Temporary storage of collOrderHasPayments to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOrderHasPayments()
	{
		if ($this->collOrderHasPayments === null) {
			$this->collOrderHasPayments = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Payment has previously
	 * been saved, it will retrieve related OrderHasPayments from storage.
	 * If this Payment is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOrderHasPayments($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderHasPayments === null) {
			if ($this->isNew()) {
			   $this->collOrderHasPayments = array();
			} else {

				$criteria->add(OrderHasPaymentPeer::PAYMENT_ID, $this->getId());

				OrderHasPaymentPeer::addSelectColumns($criteria);
				$this->collOrderHasPayments = OrderHasPaymentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderHasPaymentPeer::PAYMENT_ID, $this->getId());

				OrderHasPaymentPeer::addSelectColumns($criteria);
				if (!isset($this->lastOrderHasPaymentCriteria) || !$this->lastOrderHasPaymentCriteria->equals($criteria)) {
					$this->collOrderHasPayments = OrderHasPaymentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOrderHasPaymentCriteria = $criteria;
		return $this->collOrderHasPayments;
	}

	/**
	 * Returns the number of related OrderHasPayments.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOrderHasPayments($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OrderHasPaymentPeer::PAYMENT_ID, $this->getId());

		return OrderHasPaymentPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a OrderHasPayment object to this object
	 * through the OrderHasPayment foreign key attribute
	 *
	 * @param      OrderHasPayment $l OrderHasPayment
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOrderHasPayment(OrderHasPayment $l)
	{
		$this->collOrderHasPayments[] = $l;
		$l->setPayment($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Payment is new, it will return
	 * an empty collection; or if this Payment has previously
	 * been saved, it will retrieve related OrderHasPayments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Payment.
	 */
	public function getOrderHasPaymentsJoinOrder($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderHasPayments === null) {
			if ($this->isNew()) {
				$this->collOrderHasPayments = array();
			} else {

				$criteria->add(OrderHasPaymentPeer::PAYMENT_ID, $this->getId());

				$this->collOrderHasPayments = OrderHasPaymentPeer::doSelectJoinOrder($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderHasPaymentPeer::PAYMENT_ID, $this->getId());

			if (!isset($this->lastOrderHasPaymentCriteria) || !$this->lastOrderHasPaymentCriteria->equals($criteria)) {
				$this->collOrderHasPayments = OrderHasPaymentPeer::doSelectJoinOrder($criteria, $con);
			}
		}
		$this->lastOrderHasPaymentCriteria = $criteria;

		return $this->collOrderHasPayments;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Payment.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BasePayment:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BasePayment::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BasePayment
