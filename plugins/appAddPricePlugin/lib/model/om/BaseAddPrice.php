<?php

/**
 * Base class that represents a row from the 'app_add_price' table.
 *
 * 
 *
 * @package    plugins.appAddPricePlugin.lib.model.om
 */
abstract class BaseAddPrice extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        AddPricePeer
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
	 * The value for the currency_id field.
	 * @var        int
	 */
	protected $currency_id;


	/**
	 * The value for the tax_id field.
	 * @var        int
	 */
	protected $tax_id;


	/**
	 * The value for the opt_vat field.
	 * @var        double
	 */
	protected $opt_vat;


	/**
	 * The value for the price_netto field.
	 * @var        double
	 */
	protected $price_netto = 0;


	/**
	 * The value for the price_brutto field.
	 * @var        double
	 */
	protected $price_brutto = 0;


	/**
	 * The value for the old_price_netto field.
	 * @var        double
	 */
	protected $old_price_netto = 0;


	/**
	 * The value for the old_price_brutto field.
	 * @var        double
	 */
	protected $old_price_brutto = 0;


	/**
	 * The value for the wholesale_a_netto field.
	 * @var        double
	 */
	protected $wholesale_a_netto = 0;


	/**
	 * The value for the wholesale_a_brutto field.
	 * @var        double
	 */
	protected $wholesale_a_brutto = 0;


	/**
	 * The value for the wholesale_b_netto field.
	 * @var        double
	 */
	protected $wholesale_b_netto = 0;


	/**
	 * The value for the wholesale_b_brutto field.
	 * @var        double
	 */
	protected $wholesale_b_brutto = 0;


	/**
	 * The value for the wholesale_c_netto field.
	 * @var        double
	 */
	protected $wholesale_c_netto = 0;


	/**
	 * The value for the wholesale_c_brutto field.
	 * @var        double
	 */
	protected $wholesale_c_brutto = 0;

	/**
	 * @var        Product
	 */
	protected $aProduct;

	/**
	 * @var        Currency
	 */
	protected $aCurrency;

	/**
	 * @var        Tax
	 */
	protected $aTax;

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
     * Get the [currency_id] column value.
     * 
     * @return     int
     */
    public function getCurrencyId()
    {

            return $this->currency_id;
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
     * Get the [opt_vat] column value.
     * 
     * @return     double
     */
    public function getOptVat()
    {

            return null !== $this->opt_vat ? (string)$this->opt_vat : null;
    }

    /**
     * Get the [price_netto] column value.
     * 
     * @return     double
     */
    public function getPriceNetto()
    {

            return null !== $this->price_netto ? (string)$this->price_netto : null;
    }

    /**
     * Get the [price_brutto] column value.
     * 
     * @return     double
     */
    public function getPriceBrutto()
    {

            return null !== $this->price_brutto ? (string)$this->price_brutto : null;
    }

    /**
     * Get the [old_price_netto] column value.
     * 
     * @return     double
     */
    public function getOldPriceNetto()
    {

            return null !== $this->old_price_netto ? (string)$this->old_price_netto : null;
    }

    /**
     * Get the [old_price_brutto] column value.
     * 
     * @return     double
     */
    public function getOldPriceBrutto()
    {

            return null !== $this->old_price_brutto ? (string)$this->old_price_brutto : null;
    }

    /**
     * Get the [wholesale_a_netto] column value.
     * 
     * @return     double
     */
    public function getWholesaleANetto()
    {

            return null !== $this->wholesale_a_netto ? (string)$this->wholesale_a_netto : null;
    }

    /**
     * Get the [wholesale_a_brutto] column value.
     * 
     * @return     double
     */
    public function getWholesaleABrutto()
    {

            return null !== $this->wholesale_a_brutto ? (string)$this->wholesale_a_brutto : null;
    }

    /**
     * Get the [wholesale_b_netto] column value.
     * 
     * @return     double
     */
    public function getWholesaleBNetto()
    {

            return null !== $this->wholesale_b_netto ? (string)$this->wholesale_b_netto : null;
    }

    /**
     * Get the [wholesale_b_brutto] column value.
     * 
     * @return     double
     */
    public function getWholesaleBBrutto()
    {

            return null !== $this->wholesale_b_brutto ? (string)$this->wholesale_b_brutto : null;
    }

    /**
     * Get the [wholesale_c_netto] column value.
     * 
     * @return     double
     */
    public function getWholesaleCNetto()
    {

            return null !== $this->wholesale_c_netto ? (string)$this->wholesale_c_netto : null;
    }

    /**
     * Get the [wholesale_c_brutto] column value.
     * 
     * @return     double
     */
    public function getWholesaleCBrutto()
    {

            return null !== $this->wholesale_c_brutto ? (string)$this->wholesale_c_brutto : null;
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
			$this->modifiedColumns[] = AddPricePeer::CREATED_AT;
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
			$this->modifiedColumns[] = AddPricePeer::UPDATED_AT;
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
          $this->modifiedColumns[] = AddPricePeer::ID;
        }

		if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
			$this->aProduct = null;
		}

	} // setId()

	/**
	 * Set the value of [currency_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCurrencyId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->currency_id !== $v) {
          $this->currency_id = $v;
          $this->modifiedColumns[] = AddPricePeer::CURRENCY_ID;
        }

		if ($this->aCurrency !== null && $this->aCurrency->getId() !== $v) {
			$this->aCurrency = null;
		}

	} // setCurrencyId()

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
          $this->modifiedColumns[] = AddPricePeer::TAX_ID;
        }

		if ($this->aTax !== null && $this->aTax->getId() !== $v) {
			$this->aTax = null;
		}

	} // setTaxId()

	/**
	 * Set the value of [opt_vat] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOptVat($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->opt_vat !== $v) {
          $this->opt_vat = $v;
          $this->modifiedColumns[] = AddPricePeer::OPT_VAT;
        }

	} // setOptVat()

	/**
	 * Set the value of [price_netto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setPriceNetto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->price_netto !== $v || $v === 0) {
          $this->price_netto = $v;
          $this->modifiedColumns[] = AddPricePeer::PRICE_NETTO;
        }

	} // setPriceNetto()

	/**
	 * Set the value of [price_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setPriceBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->price_brutto !== $v || $v === 0) {
          $this->price_brutto = $v;
          $this->modifiedColumns[] = AddPricePeer::PRICE_BRUTTO;
        }

	} // setPriceBrutto()

	/**
	 * Set the value of [old_price_netto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOldPriceNetto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->old_price_netto !== $v || $v === 0) {
          $this->old_price_netto = $v;
          $this->modifiedColumns[] = AddPricePeer::OLD_PRICE_NETTO;
        }

	} // setOldPriceNetto()

	/**
	 * Set the value of [old_price_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOldPriceBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->old_price_brutto !== $v || $v === 0) {
          $this->old_price_brutto = $v;
          $this->modifiedColumns[] = AddPricePeer::OLD_PRICE_BRUTTO;
        }

	} // setOldPriceBrutto()

	/**
	 * Set the value of [wholesale_a_netto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setWholesaleANetto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->wholesale_a_netto !== $v || $v === 0) {
          $this->wholesale_a_netto = $v;
          $this->modifiedColumns[] = AddPricePeer::WHOLESALE_A_NETTO;
        }

	} // setWholesaleANetto()

	/**
	 * Set the value of [wholesale_a_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setWholesaleABrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->wholesale_a_brutto !== $v || $v === 0) {
          $this->wholesale_a_brutto = $v;
          $this->modifiedColumns[] = AddPricePeer::WHOLESALE_A_BRUTTO;
        }

	} // setWholesaleABrutto()

	/**
	 * Set the value of [wholesale_b_netto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setWholesaleBNetto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->wholesale_b_netto !== $v || $v === 0) {
          $this->wholesale_b_netto = $v;
          $this->modifiedColumns[] = AddPricePeer::WHOLESALE_B_NETTO;
        }

	} // setWholesaleBNetto()

	/**
	 * Set the value of [wholesale_b_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setWholesaleBBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->wholesale_b_brutto !== $v || $v === 0) {
          $this->wholesale_b_brutto = $v;
          $this->modifiedColumns[] = AddPricePeer::WHOLESALE_B_BRUTTO;
        }

	} // setWholesaleBBrutto()

	/**
	 * Set the value of [wholesale_c_netto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setWholesaleCNetto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->wholesale_c_netto !== $v || $v === 0) {
          $this->wholesale_c_netto = $v;
          $this->modifiedColumns[] = AddPricePeer::WHOLESALE_C_NETTO;
        }

	} // setWholesaleCNetto()

	/**
	 * Set the value of [wholesale_c_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setWholesaleCBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->wholesale_c_brutto !== $v || $v === 0) {
          $this->wholesale_c_brutto = $v;
          $this->modifiedColumns[] = AddPricePeer::WHOLESALE_C_BRUTTO;
        }

	} // setWholesaleCBrutto()

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
      if ($this->getDispatcher()->getListeners('AddPrice.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'AddPrice.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->currency_id = $rs->getInt($startcol + 3);

      $this->tax_id = $rs->getInt($startcol + 4);

      $this->opt_vat = $rs->getString($startcol + 5);
      if (null !== $this->opt_vat && $this->opt_vat == intval($this->opt_vat))
      {
        $this->opt_vat = (string)intval($this->opt_vat);
      }

      $this->price_netto = $rs->getString($startcol + 6);
      if (null !== $this->price_netto && $this->price_netto == intval($this->price_netto))
      {
        $this->price_netto = (string)intval($this->price_netto);
      }

      $this->price_brutto = $rs->getString($startcol + 7);
      if (null !== $this->price_brutto && $this->price_brutto == intval($this->price_brutto))
      {
        $this->price_brutto = (string)intval($this->price_brutto);
      }

      $this->old_price_netto = $rs->getString($startcol + 8);
      if (null !== $this->old_price_netto && $this->old_price_netto == intval($this->old_price_netto))
      {
        $this->old_price_netto = (string)intval($this->old_price_netto);
      }

      $this->old_price_brutto = $rs->getString($startcol + 9);
      if (null !== $this->old_price_brutto && $this->old_price_brutto == intval($this->old_price_brutto))
      {
        $this->old_price_brutto = (string)intval($this->old_price_brutto);
      }

      $this->wholesale_a_netto = $rs->getString($startcol + 10);
      if (null !== $this->wholesale_a_netto && $this->wholesale_a_netto == intval($this->wholesale_a_netto))
      {
        $this->wholesale_a_netto = (string)intval($this->wholesale_a_netto);
      }

      $this->wholesale_a_brutto = $rs->getString($startcol + 11);
      if (null !== $this->wholesale_a_brutto && $this->wholesale_a_brutto == intval($this->wholesale_a_brutto))
      {
        $this->wholesale_a_brutto = (string)intval($this->wholesale_a_brutto);
      }

      $this->wholesale_b_netto = $rs->getString($startcol + 12);
      if (null !== $this->wholesale_b_netto && $this->wholesale_b_netto == intval($this->wholesale_b_netto))
      {
        $this->wholesale_b_netto = (string)intval($this->wholesale_b_netto);
      }

      $this->wholesale_b_brutto = $rs->getString($startcol + 13);
      if (null !== $this->wholesale_b_brutto && $this->wholesale_b_brutto == intval($this->wholesale_b_brutto))
      {
        $this->wholesale_b_brutto = (string)intval($this->wholesale_b_brutto);
      }

      $this->wholesale_c_netto = $rs->getString($startcol + 14);
      if (null !== $this->wholesale_c_netto && $this->wholesale_c_netto == intval($this->wholesale_c_netto))
      {
        $this->wholesale_c_netto = (string)intval($this->wholesale_c_netto);
      }

      $this->wholesale_c_brutto = $rs->getString($startcol + 15);
      if (null !== $this->wholesale_c_brutto && $this->wholesale_c_brutto == intval($this->wholesale_c_brutto))
      {
        $this->wholesale_c_brutto = (string)intval($this->wholesale_c_brutto);
      }

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('AddPrice.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'AddPrice.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 16)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 16; // 16 = AddPricePeer::NUM_COLUMNS - AddPricePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating AddPrice object", $e);
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

    if ($this->getDispatcher()->getListeners('AddPrice.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'AddPrice.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseAddPrice:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseAddPrice:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(AddPricePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      AddPricePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('AddPrice.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'AddPrice.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseAddPrice:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseAddPrice:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('AddPrice.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'AddPrice.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseAddPrice:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(AddPricePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(AddPricePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(AddPricePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('AddPrice.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'AddPrice.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseAddPrice:save:post') as $callable)
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

			if ($this->aProduct !== null) {
				if ($this->aProduct->isModified() || $this->aProduct->getCurrentProductI18n()->isModified()) {
					$affectedRows += $this->aProduct->save($con);
				}
				$this->setProduct($this->aProduct);
			}

			if ($this->aCurrency !== null) {
				if ($this->aCurrency->isModified() || $this->aCurrency->getCurrentCurrencyI18n()->isModified()) {
					$affectedRows += $this->aCurrency->save($con);
				}
				$this->setCurrency($this->aCurrency);
			}

			if ($this->aTax !== null) {
				if ($this->aTax->isModified()) {
					$affectedRows += $this->aTax->save($con);
				}
				$this->setTax($this->aTax);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = AddPricePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += AddPricePeer::doUpdate($this, $con);
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

			if ($this->aProduct !== null) {
				if (!$this->aProduct->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProduct->getValidationFailures());
				}
			}

			if ($this->aCurrency !== null) {
				if (!$this->aCurrency->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCurrency->getValidationFailures());
				}
			}

			if ($this->aTax !== null) {
				if (!$this->aTax->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTax->getValidationFailures());
				}
			}


			if (($retval = AddPricePeer::doValidate($this, $columns)) !== true) {
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
		$pos = AddPricePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCurrencyId();
				break;
			case 4:
				return $this->getTaxId();
				break;
			case 5:
				return $this->getOptVat();
				break;
			case 6:
				return $this->getPriceNetto();
				break;
			case 7:
				return $this->getPriceBrutto();
				break;
			case 8:
				return $this->getOldPriceNetto();
				break;
			case 9:
				return $this->getOldPriceBrutto();
				break;
			case 10:
				return $this->getWholesaleANetto();
				break;
			case 11:
				return $this->getWholesaleABrutto();
				break;
			case 12:
				return $this->getWholesaleBNetto();
				break;
			case 13:
				return $this->getWholesaleBBrutto();
				break;
			case 14:
				return $this->getWholesaleCNetto();
				break;
			case 15:
				return $this->getWholesaleCBrutto();
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
		$keys = AddPricePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getCurrencyId(),
			$keys[4] => $this->getTaxId(),
			$keys[5] => $this->getOptVat(),
			$keys[6] => $this->getPriceNetto(),
			$keys[7] => $this->getPriceBrutto(),
			$keys[8] => $this->getOldPriceNetto(),
			$keys[9] => $this->getOldPriceBrutto(),
			$keys[10] => $this->getWholesaleANetto(),
			$keys[11] => $this->getWholesaleABrutto(),
			$keys[12] => $this->getWholesaleBNetto(),
			$keys[13] => $this->getWholesaleBBrutto(),
			$keys[14] => $this->getWholesaleCNetto(),
			$keys[15] => $this->getWholesaleCBrutto(),
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
		$pos = AddPricePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setCurrencyId($value);
				break;
			case 4:
				$this->setTaxId($value);
				break;
			case 5:
				$this->setOptVat($value);
				break;
			case 6:
				$this->setPriceNetto($value);
				break;
			case 7:
				$this->setPriceBrutto($value);
				break;
			case 8:
				$this->setOldPriceNetto($value);
				break;
			case 9:
				$this->setOldPriceBrutto($value);
				break;
			case 10:
				$this->setWholesaleANetto($value);
				break;
			case 11:
				$this->setWholesaleABrutto($value);
				break;
			case 12:
				$this->setWholesaleBNetto($value);
				break;
			case 13:
				$this->setWholesaleBBrutto($value);
				break;
			case 14:
				$this->setWholesaleCNetto($value);
				break;
			case 15:
				$this->setWholesaleCBrutto($value);
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
		$keys = AddPricePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCurrencyId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTaxId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOptVat($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setPriceNetto($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPriceBrutto($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setOldPriceNetto($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setOldPriceBrutto($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setWholesaleANetto($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setWholesaleABrutto($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setWholesaleBNetto($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setWholesaleBBrutto($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setWholesaleCNetto($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setWholesaleCBrutto($arr[$keys[15]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(AddPricePeer::DATABASE_NAME);

		if ($this->isColumnModified(AddPricePeer::CREATED_AT)) $criteria->add(AddPricePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(AddPricePeer::UPDATED_AT)) $criteria->add(AddPricePeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(AddPricePeer::ID)) $criteria->add(AddPricePeer::ID, $this->id);
		if ($this->isColumnModified(AddPricePeer::CURRENCY_ID)) $criteria->add(AddPricePeer::CURRENCY_ID, $this->currency_id);
		if ($this->isColumnModified(AddPricePeer::TAX_ID)) $criteria->add(AddPricePeer::TAX_ID, $this->tax_id);
		if ($this->isColumnModified(AddPricePeer::OPT_VAT)) $criteria->add(AddPricePeer::OPT_VAT, $this->opt_vat);
		if ($this->isColumnModified(AddPricePeer::PRICE_NETTO)) $criteria->add(AddPricePeer::PRICE_NETTO, $this->price_netto);
		if ($this->isColumnModified(AddPricePeer::PRICE_BRUTTO)) $criteria->add(AddPricePeer::PRICE_BRUTTO, $this->price_brutto);
		if ($this->isColumnModified(AddPricePeer::OLD_PRICE_NETTO)) $criteria->add(AddPricePeer::OLD_PRICE_NETTO, $this->old_price_netto);
		if ($this->isColumnModified(AddPricePeer::OLD_PRICE_BRUTTO)) $criteria->add(AddPricePeer::OLD_PRICE_BRUTTO, $this->old_price_brutto);
		if ($this->isColumnModified(AddPricePeer::WHOLESALE_A_NETTO)) $criteria->add(AddPricePeer::WHOLESALE_A_NETTO, $this->wholesale_a_netto);
		if ($this->isColumnModified(AddPricePeer::WHOLESALE_A_BRUTTO)) $criteria->add(AddPricePeer::WHOLESALE_A_BRUTTO, $this->wholesale_a_brutto);
		if ($this->isColumnModified(AddPricePeer::WHOLESALE_B_NETTO)) $criteria->add(AddPricePeer::WHOLESALE_B_NETTO, $this->wholesale_b_netto);
		if ($this->isColumnModified(AddPricePeer::WHOLESALE_B_BRUTTO)) $criteria->add(AddPricePeer::WHOLESALE_B_BRUTTO, $this->wholesale_b_brutto);
		if ($this->isColumnModified(AddPricePeer::WHOLESALE_C_NETTO)) $criteria->add(AddPricePeer::WHOLESALE_C_NETTO, $this->wholesale_c_netto);
		if ($this->isColumnModified(AddPricePeer::WHOLESALE_C_BRUTTO)) $criteria->add(AddPricePeer::WHOLESALE_C_BRUTTO, $this->wholesale_c_brutto);

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
		$criteria = new Criteria(AddPricePeer::DATABASE_NAME);

		$criteria->add(AddPricePeer::ID, $this->id);
		$criteria->add(AddPricePeer::CURRENCY_ID, $this->currency_id);

		return $criteria;
	}

	/**
	 * Returns the composite primary key for this object.
	 * The array elements will be in same order as specified in XML.
	 * @return     array
	 */
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId();

		$pks[1] = $this->getCurrencyId();

		return $pks;
	}

	/**
	 * Set the [composite] primary key.
	 *
	 * @param      array $keys The elements of the composite key (order must match the order in XML file).
	 * @return     void
	 */
	public function setPrimaryKey($keys)
	{

		$this->setId($keys[0]);

		$this->setCurrencyId($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of AddPrice (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setTaxId($this->tax_id);

		$copyObj->setOptVat($this->opt_vat);

		$copyObj->setPriceNetto($this->price_netto);

		$copyObj->setPriceBrutto($this->price_brutto);

		$copyObj->setOldPriceNetto($this->old_price_netto);

		$copyObj->setOldPriceBrutto($this->old_price_brutto);

		$copyObj->setWholesaleANetto($this->wholesale_a_netto);

		$copyObj->setWholesaleABrutto($this->wholesale_a_brutto);

		$copyObj->setWholesaleBNetto($this->wholesale_b_netto);

		$copyObj->setWholesaleBBrutto($this->wholesale_b_brutto);

		$copyObj->setWholesaleCNetto($this->wholesale_c_netto);

		$copyObj->setWholesaleCBrutto($this->wholesale_c_brutto);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a pkey column, so set to default value

		$copyObj->setCurrencyId(NULL); // this is a pkey column, so set to default value

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
	 * @return     AddPrice Clone of current object.
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
	 * @return     AddPricePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new AddPricePeer();
		}
		return self::$peer;
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
			$this->setId(NULL);
		} else {
			$this->setId($v->getId());
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
		if ($this->aProduct === null && ($this->id !== null)) {
			// include the related Peer class
			$this->aProduct = ProductPeer::retrieveByPK($this->id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductPeer::retrieveByPK($this->id, $con);
			   $obj->addProducts($this);
			 */
		}
		return $this->aProduct;
	}

	/**
	 * Declares an association between this object and a Currency object.
	 *
	 * @param      Currency $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setCurrency($v)
	{


		if ($v === null) {
			$this->setCurrencyId(NULL);
		} else {
			$this->setCurrencyId($v->getId());
		}


		$this->aCurrency = $v;
	}


	/**
	 * Get the associated Currency object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Currency The associated Currency object.
	 * @throws     PropelException
	 */
	public function getCurrency($con = null)
	{
		if ($this->aCurrency === null && ($this->currency_id !== null)) {
			// include the related Peer class
			$this->aCurrency = CurrencyPeer::retrieveByPK($this->currency_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = CurrencyPeer::retrieveByPK($this->currency_id, $con);
			   $obj->addCurrencys($this);
			 */
		}
		return $this->aCurrency;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'AddPrice.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseAddPrice:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseAddPrice::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseAddPrice
