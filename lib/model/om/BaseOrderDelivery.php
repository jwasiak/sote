<?php

/**
 * Base class that represents a row from the 'st_order_delivery' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseOrderDelivery extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        OrderDeliveryPeer
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
	 * The value for the tax_id field.
	 * @var        int
	 */
	protected $tax_id;


	/**
	 * The value for the delivery_id field.
	 * @var        int
	 */
	protected $delivery_id;


	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the cost field.
	 * @var        double
	 */
	protected $cost;


	/**
	 * The value for the payment_cost field.
	 * @var        double
	 */
	protected $payment_cost;


	/**
	 * The value for the opt_tax field.
	 * @var        double
	 */
	protected $opt_tax;


	/**
	 * The value for the number field.
	 * @var        string
	 */
	protected $number;


	/**
	 * The value for the cost_brutto field.
	 * @var        double
	 */
	protected $cost_brutto;


	/**
	 * The value for the payment_cost_brutto field.
	 * @var        double
	 */
	protected $payment_cost_brutto;


	/**
	 * The value for the custom_cost_brutto field.
	 * @var        double
	 */
	protected $custom_cost_brutto;


	/**
	 * The value for the delivery_date field.
	 * @var        int
	 */
	protected $delivery_date;


	/**
	 * The value for the pickup_point field.
	 * @var        string
	 */
	protected $pickup_point;


	/**
	 * The value for the opt_allegro_delivery_method_id field.
	 * @var        string
	 */
	protected $opt_allegro_delivery_method_id;


	/**
	 * The value for the opt_allegro_delivery_smart field.
	 * @var        boolean
	 */
	protected $opt_allegro_delivery_smart;


	/**
	 * The value for the paczkomaty_number field.
	 * @var        string
	 */
	protected $paczkomaty_number;

	/**
	 * @var        Tax
	 */
	protected $aTax;

	/**
	 * @var        Delivery
	 */
	protected $aDelivery;

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
     * Get the [tax_id] column value.
     * 
     * @return     int
     */
    public function getTaxId()
    {

            return $this->tax_id;
    }

    /**
     * Get the [delivery_id] column value.
     * 
     * @return     int
     */
    public function getDeliveryId()
    {

            return $this->delivery_id;
    }

    /**
     * Get the [name] column value.
     * 
     * @return     string
     */
    public function getName()
    {

            return $this->name;
    }

    /**
     * Get the [cost] column value.
     * 
     * @return     double
     */
    public function getCost()
    {

            return null !== $this->cost ? (string)$this->cost : null;
    }

    /**
     * Get the [payment_cost] column value.
     * 
     * @return     double
     */
    public function getPaymentCost()
    {

            return null !== $this->payment_cost ? (string)$this->payment_cost : null;
    }

    /**
     * Get the [opt_tax] column value.
     * 
     * @return     double
     */
    public function getOptTax()
    {

            return null !== $this->opt_tax ? (string)$this->opt_tax : null;
    }

    /**
     * Get the [number] column value.
     * 
     * @return     string
     */
    public function getNumber()
    {

            return $this->number;
    }

    /**
     * Get the [cost_brutto] column value.
     * 
     * @return     double
     */
    public function getCostBrutto()
    {

            return null !== $this->cost_brutto ? (string)$this->cost_brutto : null;
    }

    /**
     * Get the [payment_cost_brutto] column value.
     * 
     * @return     double
     */
    public function getPaymentCostBrutto()
    {

            return null !== $this->payment_cost_brutto ? (string)$this->payment_cost_brutto : null;
    }

    /**
     * Get the [custom_cost_brutto] column value.
     * 
     * @return     double
     */
    public function getCustomCostBrutto()
    {

            return null !== $this->custom_cost_brutto ? (string)$this->custom_cost_brutto : null;
    }

	/**
	 * Get the [optionally formatted] [delivery_date] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getDeliveryDate($format = 'Y-m-d H:i:s')
	{

		if ($this->delivery_date === null || $this->delivery_date === '') {
			return null;
		} elseif (!is_int($this->delivery_date)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->delivery_date);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [delivery_date] as date/time value: " . var_export($this->delivery_date, true));
			}
		} else {
			$ts = $this->delivery_date;
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
     * Get the [pickup_point] column value.
     * 
     * @return     string
     */
    public function getPickupPoint()
    {

            return $this->pickup_point;
    }

    /**
     * Get the [opt_allegro_delivery_method_id] column value.
     * 
     * @return     string
     */
    public function getOptAllegroDeliveryMethodId()
    {

            return $this->opt_allegro_delivery_method_id;
    }

    /**
     * Get the [opt_allegro_delivery_smart] column value.
     * 
     * @return     boolean
     */
    public function getOptAllegroDeliverySmart()
    {

            return $this->opt_allegro_delivery_smart;
    }

    /**
     * Get the [paczkomaty_number] column value.
     * 
     * @return     string
     */
    public function getPaczkomatyNumber()
    {

            return $this->paczkomaty_number;
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
			$this->modifiedColumns[] = OrderDeliveryPeer::CREATED_AT;
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
			$this->modifiedColumns[] = OrderDeliveryPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = OrderDeliveryPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [tax_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setTaxId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->tax_id !== $v) {
          $this->tax_id = $v;
          $this->modifiedColumns[] = OrderDeliveryPeer::TAX_ID;
        }

		if ($this->aTax !== null && $this->aTax->getId() !== $v) {
			$this->aTax = null;
		}

	} // setTaxId()

	/**
	 * Set the value of [delivery_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setDeliveryId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->delivery_id !== $v) {
          $this->delivery_id = $v;
          $this->modifiedColumns[] = OrderDeliveryPeer::DELIVERY_ID;
        }

		if ($this->aDelivery !== null && $this->aDelivery->getId() !== $v) {
			$this->aDelivery = null;
		}

	} // setDeliveryId()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setName($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->name !== $v) {
          $this->name = $v;
          $this->modifiedColumns[] = OrderDeliveryPeer::NAME;
        }

	} // setName()

	/**
	 * Set the value of [cost] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setCost($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->cost !== $v) {
          $this->cost = $v;
          $this->modifiedColumns[] = OrderDeliveryPeer::COST;
        }

	} // setCost()

	/**
	 * Set the value of [payment_cost] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setPaymentCost($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->payment_cost !== $v) {
          $this->payment_cost = $v;
          $this->modifiedColumns[] = OrderDeliveryPeer::PAYMENT_COST;
        }

	} // setPaymentCost()

	/**
	 * Set the value of [opt_tax] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOptTax($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->opt_tax !== $v) {
          $this->opt_tax = $v;
          $this->modifiedColumns[] = OrderDeliveryPeer::OPT_TAX;
        }

	} // setOptTax()

	/**
	 * Set the value of [number] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setNumber($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->number !== $v) {
          $this->number = $v;
          $this->modifiedColumns[] = OrderDeliveryPeer::NUMBER;
        }

	} // setNumber()

	/**
	 * Set the value of [cost_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setCostBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->cost_brutto !== $v) {
          $this->cost_brutto = $v;
          $this->modifiedColumns[] = OrderDeliveryPeer::COST_BRUTTO;
        }

	} // setCostBrutto()

	/**
	 * Set the value of [payment_cost_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setPaymentCostBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->payment_cost_brutto !== $v) {
          $this->payment_cost_brutto = $v;
          $this->modifiedColumns[] = OrderDeliveryPeer::PAYMENT_COST_BRUTTO;
        }

	} // setPaymentCostBrutto()

	/**
	 * Set the value of [custom_cost_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setCustomCostBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->custom_cost_brutto !== $v) {
          $this->custom_cost_brutto = $v;
          $this->modifiedColumns[] = OrderDeliveryPeer::CUSTOM_COST_BRUTTO;
        }

	} // setCustomCostBrutto()

	/**
	 * Set the value of [delivery_date] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setDeliveryDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [delivery_date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->delivery_date !== $ts) {
			$this->delivery_date = $ts;
			$this->modifiedColumns[] = OrderDeliveryPeer::DELIVERY_DATE;
		}

	} // setDeliveryDate()

	/**
	 * Set the value of [pickup_point] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPickupPoint($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->pickup_point !== $v) {
          $this->pickup_point = $v;
          $this->modifiedColumns[] = OrderDeliveryPeer::PICKUP_POINT;
        }

	} // setPickupPoint()

	/**
	 * Set the value of [opt_allegro_delivery_method_id] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptAllegroDeliveryMethodId($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_allegro_delivery_method_id !== $v) {
          $this->opt_allegro_delivery_method_id = $v;
          $this->modifiedColumns[] = OrderDeliveryPeer::OPT_ALLEGRO_DELIVERY_METHOD_ID;
        }

	} // setOptAllegroDeliveryMethodId()

	/**
	 * Set the value of [opt_allegro_delivery_smart] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setOptAllegroDeliverySmart($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->opt_allegro_delivery_smart !== $v) {
          $this->opt_allegro_delivery_smart = $v;
          $this->modifiedColumns[] = OrderDeliveryPeer::OPT_ALLEGRO_DELIVERY_SMART;
        }

	} // setOptAllegroDeliverySmart()

	/**
	 * Set the value of [paczkomaty_number] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPaczkomatyNumber($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->paczkomaty_number !== $v) {
          $this->paczkomaty_number = $v;
          $this->modifiedColumns[] = OrderDeliveryPeer::PACZKOMATY_NUMBER;
        }

	} // setPaczkomatyNumber()

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
      if ($this->getDispatcher()->getListeners('OrderDelivery.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'OrderDelivery.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->tax_id = $rs->getInt($startcol + 3);

      $this->delivery_id = $rs->getInt($startcol + 4);

      $this->name = $rs->getString($startcol + 5);

      $this->cost = $rs->getString($startcol + 6);
      if (null !== $this->cost && $this->cost == intval($this->cost))
      {
        $this->cost = (string)intval($this->cost);
      }

      $this->payment_cost = $rs->getString($startcol + 7);
      if (null !== $this->payment_cost && $this->payment_cost == intval($this->payment_cost))
      {
        $this->payment_cost = (string)intval($this->payment_cost);
      }

      $this->opt_tax = $rs->getString($startcol + 8);
      if (null !== $this->opt_tax && $this->opt_tax == intval($this->opt_tax))
      {
        $this->opt_tax = (string)intval($this->opt_tax);
      }

      $this->number = $rs->getString($startcol + 9);

      $this->cost_brutto = $rs->getString($startcol + 10);
      if (null !== $this->cost_brutto && $this->cost_brutto == intval($this->cost_brutto))
      {
        $this->cost_brutto = (string)intval($this->cost_brutto);
      }

      $this->payment_cost_brutto = $rs->getString($startcol + 11);
      if (null !== $this->payment_cost_brutto && $this->payment_cost_brutto == intval($this->payment_cost_brutto))
      {
        $this->payment_cost_brutto = (string)intval($this->payment_cost_brutto);
      }

      $this->custom_cost_brutto = $rs->getString($startcol + 12);
      if (null !== $this->custom_cost_brutto && $this->custom_cost_brutto == intval($this->custom_cost_brutto))
      {
        $this->custom_cost_brutto = (string)intval($this->custom_cost_brutto);
      }

      $this->delivery_date = $rs->getTimestamp($startcol + 13, null);

      $this->pickup_point = $rs->getString($startcol + 14);

      $this->opt_allegro_delivery_method_id = $rs->getString($startcol + 15);

      $this->opt_allegro_delivery_smart = $rs->getBoolean($startcol + 16);

      $this->paczkomaty_number = $rs->getString($startcol + 17);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('OrderDelivery.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'OrderDelivery.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 18)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 18; // 18 = OrderDeliveryPeer::NUM_COLUMNS - OrderDeliveryPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating OrderDelivery object", $e);
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

    if ($this->getDispatcher()->getListeners('OrderDelivery.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'OrderDelivery.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseOrderDelivery:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseOrderDelivery:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(OrderDeliveryPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      OrderDeliveryPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('OrderDelivery.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'OrderDelivery.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseOrderDelivery:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseOrderDelivery:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('OrderDelivery.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'OrderDelivery.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseOrderDelivery:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(OrderDeliveryPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(OrderDeliveryPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(OrderDeliveryPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('OrderDelivery.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'OrderDelivery.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseOrderDelivery:save:post') as $callable)
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

			if ($this->aTax !== null) {
				if ($this->aTax->isModified()) {
					$affectedRows += $this->aTax->save($con);
				}
				$this->setTax($this->aTax);
			}

			if ($this->aDelivery !== null) {
				if ($this->aDelivery->isModified() || $this->aDelivery->getCurrentDeliveryI18n()->isModified()) {
					$affectedRows += $this->aDelivery->save($con);
				}
				$this->setDelivery($this->aDelivery);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OrderDeliveryPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += OrderDeliveryPeer::doUpdate($this, $con);
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

			if ($this->aTax !== null) {
				if (!$this->aTax->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTax->getValidationFailures());
				}
			}

			if ($this->aDelivery !== null) {
				if (!$this->aDelivery->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDelivery->getValidationFailures());
				}
			}


			if (($retval = OrderDeliveryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOrders !== null) {
					foreach($this->collOrders as $referrerFK) {
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
		$pos = OrderDeliveryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getTaxId();
				break;
			case 4:
				return $this->getDeliveryId();
				break;
			case 5:
				return $this->getName();
				break;
			case 6:
				return $this->getCost();
				break;
			case 7:
				return $this->getPaymentCost();
				break;
			case 8:
				return $this->getOptTax();
				break;
			case 9:
				return $this->getNumber();
				break;
			case 10:
				return $this->getCostBrutto();
				break;
			case 11:
				return $this->getPaymentCostBrutto();
				break;
			case 12:
				return $this->getCustomCostBrutto();
				break;
			case 13:
				return $this->getDeliveryDate();
				break;
			case 14:
				return $this->getPickupPoint();
				break;
			case 15:
				return $this->getOptAllegroDeliveryMethodId();
				break;
			case 16:
				return $this->getOptAllegroDeliverySmart();
				break;
			case 17:
				return $this->getPaczkomatyNumber();
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
		$keys = OrderDeliveryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getTaxId(),
			$keys[4] => $this->getDeliveryId(),
			$keys[5] => $this->getName(),
			$keys[6] => $this->getCost(),
			$keys[7] => $this->getPaymentCost(),
			$keys[8] => $this->getOptTax(),
			$keys[9] => $this->getNumber(),
			$keys[10] => $this->getCostBrutto(),
			$keys[11] => $this->getPaymentCostBrutto(),
			$keys[12] => $this->getCustomCostBrutto(),
			$keys[13] => $this->getDeliveryDate(),
			$keys[14] => $this->getPickupPoint(),
			$keys[15] => $this->getOptAllegroDeliveryMethodId(),
			$keys[16] => $this->getOptAllegroDeliverySmart(),
			$keys[17] => $this->getPaczkomatyNumber(),
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
		$pos = OrderDeliveryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setTaxId($value);
				break;
			case 4:
				$this->setDeliveryId($value);
				break;
			case 5:
				$this->setName($value);
				break;
			case 6:
				$this->setCost($value);
				break;
			case 7:
				$this->setPaymentCost($value);
				break;
			case 8:
				$this->setOptTax($value);
				break;
			case 9:
				$this->setNumber($value);
				break;
			case 10:
				$this->setCostBrutto($value);
				break;
			case 11:
				$this->setPaymentCostBrutto($value);
				break;
			case 12:
				$this->setCustomCostBrutto($value);
				break;
			case 13:
				$this->setDeliveryDate($value);
				break;
			case 14:
				$this->setPickupPoint($value);
				break;
			case 15:
				$this->setOptAllegroDeliveryMethodId($value);
				break;
			case 16:
				$this->setOptAllegroDeliverySmart($value);
				break;
			case 17:
				$this->setPaczkomatyNumber($value);
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
		$keys = OrderDeliveryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTaxId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDeliveryId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setName($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCost($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPaymentCost($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setOptTax($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setNumber($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setCostBrutto($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setPaymentCostBrutto($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setCustomCostBrutto($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setDeliveryDate($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setPickupPoint($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setOptAllegroDeliveryMethodId($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setOptAllegroDeliverySmart($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setPaczkomatyNumber($arr[$keys[17]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(OrderDeliveryPeer::DATABASE_NAME);

		if ($this->isColumnModified(OrderDeliveryPeer::CREATED_AT)) $criteria->add(OrderDeliveryPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(OrderDeliveryPeer::UPDATED_AT)) $criteria->add(OrderDeliveryPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(OrderDeliveryPeer::ID)) $criteria->add(OrderDeliveryPeer::ID, $this->id);
		if ($this->isColumnModified(OrderDeliveryPeer::TAX_ID)) $criteria->add(OrderDeliveryPeer::TAX_ID, $this->tax_id);
		if ($this->isColumnModified(OrderDeliveryPeer::DELIVERY_ID)) $criteria->add(OrderDeliveryPeer::DELIVERY_ID, $this->delivery_id);
		if ($this->isColumnModified(OrderDeliveryPeer::NAME)) $criteria->add(OrderDeliveryPeer::NAME, $this->name);
		if ($this->isColumnModified(OrderDeliveryPeer::COST)) $criteria->add(OrderDeliveryPeer::COST, $this->cost);
		if ($this->isColumnModified(OrderDeliveryPeer::PAYMENT_COST)) $criteria->add(OrderDeliveryPeer::PAYMENT_COST, $this->payment_cost);
		if ($this->isColumnModified(OrderDeliveryPeer::OPT_TAX)) $criteria->add(OrderDeliveryPeer::OPT_TAX, $this->opt_tax);
		if ($this->isColumnModified(OrderDeliveryPeer::NUMBER)) $criteria->add(OrderDeliveryPeer::NUMBER, $this->number);
		if ($this->isColumnModified(OrderDeliveryPeer::COST_BRUTTO)) $criteria->add(OrderDeliveryPeer::COST_BRUTTO, $this->cost_brutto);
		if ($this->isColumnModified(OrderDeliveryPeer::PAYMENT_COST_BRUTTO)) $criteria->add(OrderDeliveryPeer::PAYMENT_COST_BRUTTO, $this->payment_cost_brutto);
		if ($this->isColumnModified(OrderDeliveryPeer::CUSTOM_COST_BRUTTO)) $criteria->add(OrderDeliveryPeer::CUSTOM_COST_BRUTTO, $this->custom_cost_brutto);
		if ($this->isColumnModified(OrderDeliveryPeer::DELIVERY_DATE)) $criteria->add(OrderDeliveryPeer::DELIVERY_DATE, $this->delivery_date);
		if ($this->isColumnModified(OrderDeliveryPeer::PICKUP_POINT)) $criteria->add(OrderDeliveryPeer::PICKUP_POINT, $this->pickup_point);
		if ($this->isColumnModified(OrderDeliveryPeer::OPT_ALLEGRO_DELIVERY_METHOD_ID)) $criteria->add(OrderDeliveryPeer::OPT_ALLEGRO_DELIVERY_METHOD_ID, $this->opt_allegro_delivery_method_id);
		if ($this->isColumnModified(OrderDeliveryPeer::OPT_ALLEGRO_DELIVERY_SMART)) $criteria->add(OrderDeliveryPeer::OPT_ALLEGRO_DELIVERY_SMART, $this->opt_allegro_delivery_smart);
		if ($this->isColumnModified(OrderDeliveryPeer::PACZKOMATY_NUMBER)) $criteria->add(OrderDeliveryPeer::PACZKOMATY_NUMBER, $this->paczkomaty_number);

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
		$criteria = new Criteria(OrderDeliveryPeer::DATABASE_NAME);

		$criteria->add(OrderDeliveryPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of OrderDelivery (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setTaxId($this->tax_id);

		$copyObj->setDeliveryId($this->delivery_id);

		$copyObj->setName($this->name);

		$copyObj->setCost($this->cost);

		$copyObj->setPaymentCost($this->payment_cost);

		$copyObj->setOptTax($this->opt_tax);

		$copyObj->setNumber($this->number);

		$copyObj->setCostBrutto($this->cost_brutto);

		$copyObj->setPaymentCostBrutto($this->payment_cost_brutto);

		$copyObj->setCustomCostBrutto($this->custom_cost_brutto);

		$copyObj->setDeliveryDate($this->delivery_date);

		$copyObj->setPickupPoint($this->pickup_point);

		$copyObj->setOptAllegroDeliveryMethodId($this->opt_allegro_delivery_method_id);

		$copyObj->setOptAllegroDeliverySmart($this->opt_allegro_delivery_smart);

		$copyObj->setPaczkomatyNumber($this->paczkomaty_number);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getOrders() as $relObj) {
				$copyObj->addOrder($relObj->copy($deepCopy));
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
	 * @return     OrderDelivery Clone of current object.
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
	 * @return     OrderDeliveryPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new OrderDeliveryPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Tax object.
	 *
	 * @param      Tax $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setTax($v)
	{


		if ($v === null) {
			$this->setTaxId(NULL);
		} else {
			$this->setTaxId($v->getId());
		}


		$this->aTax = $v;
	}


	/**
	 * Get the associated Tax object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Tax The associated Tax object.
	 * @throws     PropelException
	 */
	public function getTax($con = null)
	{
		if ($this->aTax === null && ($this->tax_id !== null)) {
			// include the related Peer class
			$this->aTax = TaxPeer::retrieveByPK($this->tax_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = TaxPeer::retrieveByPK($this->tax_id, $con);
			   $obj->addTaxs($this);
			 */
		}
		return $this->aTax;
	}

	/**
	 * Declares an association between this object and a Delivery object.
	 *
	 * @param      Delivery $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setDelivery($v)
	{


		if ($v === null) {
			$this->setDeliveryId(NULL);
		} else {
			$this->setDeliveryId($v->getId());
		}


		$this->aDelivery = $v;
	}


	/**
	 * Get the associated Delivery object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Delivery The associated Delivery object.
	 * @throws     PropelException
	 */
	public function getDelivery($con = null)
	{
		if ($this->aDelivery === null && ($this->delivery_id !== null)) {
			// include the related Peer class
			$this->aDelivery = DeliveryPeer::retrieveByPK($this->delivery_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = DeliveryPeer::retrieveByPK($this->delivery_id, $con);
			   $obj->addDeliverys($this);
			 */
		}
		return $this->aDelivery;
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
	 * Otherwise if this OrderDelivery has previously
	 * been saved, it will retrieve related Orders from storage.
	 * If this OrderDelivery is new, it will return
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

				$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

				OrderPeer::addSelectColumns($criteria);
				$this->collOrders = OrderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

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

		$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

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
		$l->setOrderDelivery($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this OrderDelivery is new, it will return
	 * an empty collection; or if this OrderDelivery has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderDelivery.
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

				$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

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
	 * Otherwise if this OrderDelivery is new, it will return
	 * an empty collection; or if this OrderDelivery has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderDelivery.
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

				$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

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
	 * Otherwise if this OrderDelivery is new, it will return
	 * an empty collection; or if this OrderDelivery has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderDelivery.
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

				$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataBilling($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

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
	 * Otherwise if this OrderDelivery is new, it will return
	 * an empty collection; or if this OrderDelivery has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderDelivery.
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

				$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

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
	 * Otherwise if this OrderDelivery is new, it will return
	 * an empty collection; or if this OrderDelivery has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderDelivery.
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

				$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderStatus($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

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
	 * Otherwise if this OrderDelivery is new, it will return
	 * an empty collection; or if this OrderDelivery has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderDelivery.
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

				$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

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
	 * Otherwise if this OrderDelivery is new, it will return
	 * an empty collection; or if this OrderDelivery has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderDelivery.
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

				$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinDiscount($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

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
	 * Otherwise if this OrderDelivery is new, it will return
	 * an empty collection; or if this OrderDelivery has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderDelivery.
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

				$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinPartner($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinPartner($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'OrderDelivery.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseOrderDelivery:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseOrderDelivery::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseOrderDelivery
