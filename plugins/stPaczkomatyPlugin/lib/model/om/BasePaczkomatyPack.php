<?php

/**
 * Base class that represents a row from the 'st_paczkomaty_pack' table.
 *
 * 
 *
 * @package    plugins.stPaczkomatyPlugin.lib.model.om
 */
abstract class BasePaczkomatyPack extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PaczkomatyPackPeer
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
	 * The value for the customer_email field.
	 * @var        string
	 */
	protected $customer_email;


	/**
	 * The value for the customer_phone field.
	 * @var        string
	 */
	protected $customer_phone;


	/**
	 * The value for the customer_paczkomat field.
	 * @var        string
	 */
	protected $customer_paczkomat;


	/**
	 * The value for the sending_method field.
	 * @var        string
	 */
	protected $sending_method;


	/**
	 * The value for the sender_paczkomat field.
	 * @var        string
	 */
	protected $sender_paczkomat;


	/**
	 * The value for the use_sender_paczkomat field.
	 * @var        boolean
	 */
	protected $use_sender_paczkomat = false;


	/**
	 * The value for the pack_type field.
	 * @var        string
	 */
	protected $pack_type;


	/**
	 * The value for the inpost_shipment_id field.
	 * @var        int
	 */
	protected $inpost_shipment_id;


	/**
	 * The value for the insurance field.
	 * @var        double
	 */
	protected $insurance;


	/**
	 * The value for the cash_on_delivery field.
	 * @var        double
	 */
	protected $cash_on_delivery;


	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;


	/**
	 * The value for the code field.
	 * @var        string
	 */
	protected $code;


	/**
	 * The value for the has_cash_on_delivery field.
	 * @var        boolean
	 */
	protected $has_cash_on_delivery;


	/**
	 * The value for the customer_delivering_code field.
	 * @var        string
	 */
	protected $customer_delivering_code;


	/**
	 * The value for the status field.
	 * @var        string
	 */
	protected $status;


	/**
	 * The value for the status_changed_at field.
	 * @var        int
	 */
	protected $status_changed_at;


	/**
	 * The value for the order_id field.
	 * @var        int
	 */
	protected $order_id;

	/**
	 * @var        Order
	 */
	protected $aOrder;

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
     * Get the [customer_email] column value.
     * 
     * @return     string
     */
    public function getCustomerEmail()
    {

            return $this->customer_email;
    }

    /**
     * Get the [customer_phone] column value.
     * 
     * @return     string
     */
    public function getCustomerPhone()
    {

            return $this->customer_phone;
    }

    /**
     * Get the [customer_paczkomat] column value.
     * 
     * @return     string
     */
    public function getCustomerPaczkomat()
    {

            return $this->customer_paczkomat;
    }

    /**
     * Get the [sending_method] column value.
     * 
     * @return     string
     */
    public function getSendingMethod()
    {

            return $this->sending_method;
    }

    /**
     * Get the [sender_paczkomat] column value.
     * 
     * @return     string
     */
    public function getSenderPaczkomat()
    {

            return $this->sender_paczkomat;
    }

    /**
     * Get the [use_sender_paczkomat] column value.
     * 
     * @return     boolean
     */
    public function getUseSenderPaczkomat()
    {

            return $this->use_sender_paczkomat;
    }

    /**
     * Get the [pack_type] column value.
     * 
     * @return     string
     */
    public function getPackType()
    {

            return $this->pack_type;
    }

    /**
     * Get the [inpost_shipment_id] column value.
     * 
     * @return     int
     */
    public function getInpostShipmentId()
    {

            return $this->inpost_shipment_id;
    }

    /**
     * Get the [insurance] column value.
     * 
     * @return     double
     */
    public function getInsurance()
    {

            return null !== $this->insurance ? (string)$this->insurance : null;
    }

    /**
     * Get the [cash_on_delivery] column value.
     * 
     * @return     double
     */
    public function getCashOnDelivery()
    {

            return null !== $this->cash_on_delivery ? (string)$this->cash_on_delivery : null;
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
     * Get the [code] column value.
     * 
     * @return     string
     */
    public function getCode()
    {

            return $this->code;
    }

    /**
     * Get the [has_cash_on_delivery] column value.
     * 
     * @return     boolean
     */
    public function getHasCashOnDelivery()
    {

            return $this->has_cash_on_delivery;
    }

    /**
     * Get the [customer_delivering_code] column value.
     * 
     * @return     string
     */
    public function getCustomerDeliveringCode()
    {

            return $this->customer_delivering_code;
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
	 * Get the [optionally formatted] [status_changed_at] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getStatusChangedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->status_changed_at === null || $this->status_changed_at === '') {
			return null;
		} elseif (!is_int($this->status_changed_at)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->status_changed_at);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [status_changed_at] as date/time value: " . var_export($this->status_changed_at, true));
			}
		} else {
			$ts = $this->status_changed_at;
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
     * Get the [order_id] column value.
     * 
     * @return     int
     */
    public function getOrderId()
    {

            return $this->order_id;
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
			$this->modifiedColumns[] = PaczkomatyPackPeer::CREATED_AT;
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
			$this->modifiedColumns[] = PaczkomatyPackPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = PaczkomatyPackPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [customer_email] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCustomerEmail($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->customer_email !== $v) {
          $this->customer_email = $v;
          $this->modifiedColumns[] = PaczkomatyPackPeer::CUSTOMER_EMAIL;
        }

	} // setCustomerEmail()

	/**
	 * Set the value of [customer_phone] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCustomerPhone($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->customer_phone !== $v) {
          $this->customer_phone = $v;
          $this->modifiedColumns[] = PaczkomatyPackPeer::CUSTOMER_PHONE;
        }

	} // setCustomerPhone()

	/**
	 * Set the value of [customer_paczkomat] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCustomerPaczkomat($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->customer_paczkomat !== $v) {
          $this->customer_paczkomat = $v;
          $this->modifiedColumns[] = PaczkomatyPackPeer::CUSTOMER_PACZKOMAT;
        }

	} // setCustomerPaczkomat()

	/**
	 * Set the value of [sending_method] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setSendingMethod($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->sending_method !== $v) {
          $this->sending_method = $v;
          $this->modifiedColumns[] = PaczkomatyPackPeer::SENDING_METHOD;
        }

	} // setSendingMethod()

	/**
	 * Set the value of [sender_paczkomat] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setSenderPaczkomat($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->sender_paczkomat !== $v) {
          $this->sender_paczkomat = $v;
          $this->modifiedColumns[] = PaczkomatyPackPeer::SENDER_PACZKOMAT;
        }

	} // setSenderPaczkomat()

	/**
	 * Set the value of [use_sender_paczkomat] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setUseSenderPaczkomat($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->use_sender_paczkomat !== $v || $v === false) {
          $this->use_sender_paczkomat = $v;
          $this->modifiedColumns[] = PaczkomatyPackPeer::USE_SENDER_PACZKOMAT;
        }

	} // setUseSenderPaczkomat()

	/**
	 * Set the value of [pack_type] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPackType($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->pack_type !== $v) {
          $this->pack_type = $v;
          $this->modifiedColumns[] = PaczkomatyPackPeer::PACK_TYPE;
        }

	} // setPackType()

	/**
	 * Set the value of [inpost_shipment_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setInpostShipmentId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->inpost_shipment_id !== $v) {
          $this->inpost_shipment_id = $v;
          $this->modifiedColumns[] = PaczkomatyPackPeer::INPOST_SHIPMENT_ID;
        }

	} // setInpostShipmentId()

	/**
	 * Set the value of [insurance] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setInsurance($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->insurance !== $v) {
          $this->insurance = $v;
          $this->modifiedColumns[] = PaczkomatyPackPeer::INSURANCE;
        }

	} // setInsurance()

	/**
	 * Set the value of [cash_on_delivery] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setCashOnDelivery($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->cash_on_delivery !== $v) {
          $this->cash_on_delivery = $v;
          $this->modifiedColumns[] = PaczkomatyPackPeer::CASH_ON_DELIVERY;
        }

	} // setCashOnDelivery()

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
          $this->modifiedColumns[] = PaczkomatyPackPeer::DESCRIPTION;
        }

	} // setDescription()

	/**
	 * Set the value of [code] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCode($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->code !== $v) {
          $this->code = $v;
          $this->modifiedColumns[] = PaczkomatyPackPeer::CODE;
        }

	} // setCode()

	/**
	 * Set the value of [has_cash_on_delivery] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setHasCashOnDelivery($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->has_cash_on_delivery !== $v) {
          $this->has_cash_on_delivery = $v;
          $this->modifiedColumns[] = PaczkomatyPackPeer::HAS_CASH_ON_DELIVERY;
        }

	} // setHasCashOnDelivery()

	/**
	 * Set the value of [customer_delivering_code] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCustomerDeliveringCode($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->customer_delivering_code !== $v) {
          $this->customer_delivering_code = $v;
          $this->modifiedColumns[] = PaczkomatyPackPeer::CUSTOMER_DELIVERING_CODE;
        }

	} // setCustomerDeliveringCode()

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
          $this->modifiedColumns[] = PaczkomatyPackPeer::STATUS;
        }

	} // setStatus()

	/**
	 * Set the value of [status_changed_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setStatusChangedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [status_changed_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->status_changed_at !== $ts) {
			$this->status_changed_at = $ts;
			$this->modifiedColumns[] = PaczkomatyPackPeer::STATUS_CHANGED_AT;
		}

	} // setStatusChangedAt()

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
          $this->modifiedColumns[] = PaczkomatyPackPeer::ORDER_ID;
        }

		if ($this->aOrder !== null && $this->aOrder->getId() !== $v) {
			$this->aOrder = null;
		}

	} // setOrderId()

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
      if ($this->getDispatcher()->getListeners('PaczkomatyPack.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'PaczkomatyPack.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->customer_email = $rs->getString($startcol + 3);

      $this->customer_phone = $rs->getString($startcol + 4);

      $this->customer_paczkomat = $rs->getString($startcol + 5);

      $this->sending_method = $rs->getString($startcol + 6);

      $this->sender_paczkomat = $rs->getString($startcol + 7);

      $this->use_sender_paczkomat = $rs->getBoolean($startcol + 8);

      $this->pack_type = $rs->getString($startcol + 9);

      $this->inpost_shipment_id = $rs->getInt($startcol + 10);

      $this->insurance = $rs->getString($startcol + 11);
      if (null !== $this->insurance && $this->insurance == intval($this->insurance))
      {
        $this->insurance = (string)intval($this->insurance);
      }

      $this->cash_on_delivery = $rs->getString($startcol + 12);
      if (null !== $this->cash_on_delivery && $this->cash_on_delivery == intval($this->cash_on_delivery))
      {
        $this->cash_on_delivery = (string)intval($this->cash_on_delivery);
      }

      $this->description = $rs->getString($startcol + 13);

      $this->code = $rs->getString($startcol + 14);

      $this->has_cash_on_delivery = $rs->getBoolean($startcol + 15);

      $this->customer_delivering_code = $rs->getString($startcol + 16);

      $this->status = $rs->getString($startcol + 17);

      $this->status_changed_at = $rs->getTimestamp($startcol + 18, null);

      $this->order_id = $rs->getInt($startcol + 19);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('PaczkomatyPack.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'PaczkomatyPack.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 20)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 20; // 20 = PaczkomatyPackPeer::NUM_COLUMNS - PaczkomatyPackPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating PaczkomatyPack object", $e);
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

    if ($this->getDispatcher()->getListeners('PaczkomatyPack.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'PaczkomatyPack.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePaczkomatyPack:delete:pre'))
    {
      foreach (sfMixer::getCallables('BasePaczkomatyPack:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(PaczkomatyPackPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      PaczkomatyPackPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('PaczkomatyPack.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'PaczkomatyPack.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePaczkomatyPack:delete:post'))
    {
      foreach (sfMixer::getCallables('BasePaczkomatyPack:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('PaczkomatyPack.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'PaczkomatyPack.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BasePaczkomatyPack:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(PaczkomatyPackPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(PaczkomatyPackPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(PaczkomatyPackPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('PaczkomatyPack.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'PaczkomatyPack.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BasePaczkomatyPack:save:post') as $callable)
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


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PaczkomatyPackPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PaczkomatyPackPeer::doUpdate($this, $con);
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


			if (($retval = PaczkomatyPackPeer::doValidate($this, $columns)) !== true) {
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
		$pos = PaczkomatyPackPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCustomerEmail();
				break;
			case 4:
				return $this->getCustomerPhone();
				break;
			case 5:
				return $this->getCustomerPaczkomat();
				break;
			case 6:
				return $this->getSendingMethod();
				break;
			case 7:
				return $this->getSenderPaczkomat();
				break;
			case 8:
				return $this->getUseSenderPaczkomat();
				break;
			case 9:
				return $this->getPackType();
				break;
			case 10:
				return $this->getInpostShipmentId();
				break;
			case 11:
				return $this->getInsurance();
				break;
			case 12:
				return $this->getCashOnDelivery();
				break;
			case 13:
				return $this->getDescription();
				break;
			case 14:
				return $this->getCode();
				break;
			case 15:
				return $this->getHasCashOnDelivery();
				break;
			case 16:
				return $this->getCustomerDeliveringCode();
				break;
			case 17:
				return $this->getStatus();
				break;
			case 18:
				return $this->getStatusChangedAt();
				break;
			case 19:
				return $this->getOrderId();
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
		$keys = PaczkomatyPackPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getCustomerEmail(),
			$keys[4] => $this->getCustomerPhone(),
			$keys[5] => $this->getCustomerPaczkomat(),
			$keys[6] => $this->getSendingMethod(),
			$keys[7] => $this->getSenderPaczkomat(),
			$keys[8] => $this->getUseSenderPaczkomat(),
			$keys[9] => $this->getPackType(),
			$keys[10] => $this->getInpostShipmentId(),
			$keys[11] => $this->getInsurance(),
			$keys[12] => $this->getCashOnDelivery(),
			$keys[13] => $this->getDescription(),
			$keys[14] => $this->getCode(),
			$keys[15] => $this->getHasCashOnDelivery(),
			$keys[16] => $this->getCustomerDeliveringCode(),
			$keys[17] => $this->getStatus(),
			$keys[18] => $this->getStatusChangedAt(),
			$keys[19] => $this->getOrderId(),
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
		$pos = PaczkomatyPackPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setCustomerEmail($value);
				break;
			case 4:
				$this->setCustomerPhone($value);
				break;
			case 5:
				$this->setCustomerPaczkomat($value);
				break;
			case 6:
				$this->setSendingMethod($value);
				break;
			case 7:
				$this->setSenderPaczkomat($value);
				break;
			case 8:
				$this->setUseSenderPaczkomat($value);
				break;
			case 9:
				$this->setPackType($value);
				break;
			case 10:
				$this->setInpostShipmentId($value);
				break;
			case 11:
				$this->setInsurance($value);
				break;
			case 12:
				$this->setCashOnDelivery($value);
				break;
			case 13:
				$this->setDescription($value);
				break;
			case 14:
				$this->setCode($value);
				break;
			case 15:
				$this->setHasCashOnDelivery($value);
				break;
			case 16:
				$this->setCustomerDeliveringCode($value);
				break;
			case 17:
				$this->setStatus($value);
				break;
			case 18:
				$this->setStatusChangedAt($value);
				break;
			case 19:
				$this->setOrderId($value);
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
		$keys = PaczkomatyPackPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCustomerEmail($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCustomerPhone($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCustomerPaczkomat($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setSendingMethod($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setSenderPaczkomat($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setUseSenderPaczkomat($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setPackType($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setInpostShipmentId($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setInsurance($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setCashOnDelivery($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setDescription($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setCode($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setHasCashOnDelivery($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setCustomerDeliveringCode($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setStatus($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setStatusChangedAt($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setOrderId($arr[$keys[19]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PaczkomatyPackPeer::DATABASE_NAME);

		if ($this->isColumnModified(PaczkomatyPackPeer::CREATED_AT)) $criteria->add(PaczkomatyPackPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(PaczkomatyPackPeer::UPDATED_AT)) $criteria->add(PaczkomatyPackPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(PaczkomatyPackPeer::ID)) $criteria->add(PaczkomatyPackPeer::ID, $this->id);
		if ($this->isColumnModified(PaczkomatyPackPeer::CUSTOMER_EMAIL)) $criteria->add(PaczkomatyPackPeer::CUSTOMER_EMAIL, $this->customer_email);
		if ($this->isColumnModified(PaczkomatyPackPeer::CUSTOMER_PHONE)) $criteria->add(PaczkomatyPackPeer::CUSTOMER_PHONE, $this->customer_phone);
		if ($this->isColumnModified(PaczkomatyPackPeer::CUSTOMER_PACZKOMAT)) $criteria->add(PaczkomatyPackPeer::CUSTOMER_PACZKOMAT, $this->customer_paczkomat);
		if ($this->isColumnModified(PaczkomatyPackPeer::SENDING_METHOD)) $criteria->add(PaczkomatyPackPeer::SENDING_METHOD, $this->sending_method);
		if ($this->isColumnModified(PaczkomatyPackPeer::SENDER_PACZKOMAT)) $criteria->add(PaczkomatyPackPeer::SENDER_PACZKOMAT, $this->sender_paczkomat);
		if ($this->isColumnModified(PaczkomatyPackPeer::USE_SENDER_PACZKOMAT)) $criteria->add(PaczkomatyPackPeer::USE_SENDER_PACZKOMAT, $this->use_sender_paczkomat);
		if ($this->isColumnModified(PaczkomatyPackPeer::PACK_TYPE)) $criteria->add(PaczkomatyPackPeer::PACK_TYPE, $this->pack_type);
		if ($this->isColumnModified(PaczkomatyPackPeer::INPOST_SHIPMENT_ID)) $criteria->add(PaczkomatyPackPeer::INPOST_SHIPMENT_ID, $this->inpost_shipment_id);
		if ($this->isColumnModified(PaczkomatyPackPeer::INSURANCE)) $criteria->add(PaczkomatyPackPeer::INSURANCE, $this->insurance);
		if ($this->isColumnModified(PaczkomatyPackPeer::CASH_ON_DELIVERY)) $criteria->add(PaczkomatyPackPeer::CASH_ON_DELIVERY, $this->cash_on_delivery);
		if ($this->isColumnModified(PaczkomatyPackPeer::DESCRIPTION)) $criteria->add(PaczkomatyPackPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(PaczkomatyPackPeer::CODE)) $criteria->add(PaczkomatyPackPeer::CODE, $this->code);
		if ($this->isColumnModified(PaczkomatyPackPeer::HAS_CASH_ON_DELIVERY)) $criteria->add(PaczkomatyPackPeer::HAS_CASH_ON_DELIVERY, $this->has_cash_on_delivery);
		if ($this->isColumnModified(PaczkomatyPackPeer::CUSTOMER_DELIVERING_CODE)) $criteria->add(PaczkomatyPackPeer::CUSTOMER_DELIVERING_CODE, $this->customer_delivering_code);
		if ($this->isColumnModified(PaczkomatyPackPeer::STATUS)) $criteria->add(PaczkomatyPackPeer::STATUS, $this->status);
		if ($this->isColumnModified(PaczkomatyPackPeer::STATUS_CHANGED_AT)) $criteria->add(PaczkomatyPackPeer::STATUS_CHANGED_AT, $this->status_changed_at);
		if ($this->isColumnModified(PaczkomatyPackPeer::ORDER_ID)) $criteria->add(PaczkomatyPackPeer::ORDER_ID, $this->order_id);

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
		$criteria = new Criteria(PaczkomatyPackPeer::DATABASE_NAME);

		$criteria->add(PaczkomatyPackPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of PaczkomatyPack (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setCustomerEmail($this->customer_email);

		$copyObj->setCustomerPhone($this->customer_phone);

		$copyObj->setCustomerPaczkomat($this->customer_paczkomat);

		$copyObj->setSendingMethod($this->sending_method);

		$copyObj->setSenderPaczkomat($this->sender_paczkomat);

		$copyObj->setUseSenderPaczkomat($this->use_sender_paczkomat);

		$copyObj->setPackType($this->pack_type);

		$copyObj->setInpostShipmentId($this->inpost_shipment_id);

		$copyObj->setInsurance($this->insurance);

		$copyObj->setCashOnDelivery($this->cash_on_delivery);

		$copyObj->setDescription($this->description);

		$copyObj->setCode($this->code);

		$copyObj->setHasCashOnDelivery($this->has_cash_on_delivery);

		$copyObj->setCustomerDeliveringCode($this->customer_delivering_code);

		$copyObj->setStatus($this->status);

		$copyObj->setStatusChangedAt($this->status_changed_at);

		$copyObj->setOrderId($this->order_id);


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
	 * @return     PaczkomatyPack Clone of current object.
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
	 * @return     PaczkomatyPackPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PaczkomatyPackPeer();
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'PaczkomatyPack.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BasePaczkomatyPack:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BasePaczkomatyPack::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BasePaczkomatyPack
