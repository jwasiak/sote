<?php

/**
 * Base class that represents a row from the 'st_group_price' table.
 *
 * 
 *
 * @package    plugins.stGroupPricePlugin.lib.model.om
 */
abstract class BaseGroupPrice extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        GroupPricePeer
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
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;


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
	 * The value for the currency_id field.
	 * @var        int
	 */
	protected $currency_id;


	/**
	 * The value for the price_netto field.
	 * @var        double
	 */
	protected $price_netto;


	/**
	 * The value for the price_brutto field.
	 * @var        double
	 */
	protected $price_brutto;


	/**
	 * The value for the old_price_netto field.
	 * @var        double
	 */
	protected $old_price_netto;


	/**
	 * The value for the old_price_brutto field.
	 * @var        double
	 */
	protected $old_price_brutto;


	/**
	 * The value for the wholesale_a_netto field.
	 * @var        double
	 */
	protected $wholesale_a_netto;


	/**
	 * The value for the wholesale_a_brutto field.
	 * @var        double
	 */
	protected $wholesale_a_brutto;


	/**
	 * The value for the wholesale_b_netto field.
	 * @var        double
	 */
	protected $wholesale_b_netto;


	/**
	 * The value for the wholesale_b_brutto field.
	 * @var        double
	 */
	protected $wholesale_b_brutto;


	/**
	 * The value for the wholesale_c_netto field.
	 * @var        double
	 */
	protected $wholesale_c_netto;


	/**
	 * The value for the wholesale_c_brutto field.
	 * @var        double
	 */
	protected $wholesale_c_brutto;

	/**
	 * @var        Tax
	 */
	protected $aTax;

	/**
	 * @var        Currency
	 */
	protected $aCurrency;

	/**
	 * Collection to store aggregation of collProducts.
	 * @var        array
	 */
	protected $collProducts;

	/**
	 * The criteria used to select the current contents of collProducts.
	 * @var        Criteria
	 */
	protected $lastProductCriteria = null;

	/**
	 * Collection to store aggregation of collAddGroupPrices.
	 * @var        array
	 */
	protected $collAddGroupPrices;

	/**
	 * The criteria used to select the current contents of collAddGroupPrices.
	 * @var        Criteria
	 */
	protected $lastAddGroupPriceCriteria = null;

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
     * Get the [name] column value.
     * 
     * @return     string
     */
    public function getName()
    {

            return $this->name;
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
     * Get the [currency_id] column value.
     * 
     * @return     int
     */
    public function getCurrencyId()
    {

            return $this->currency_id;
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
			$this->modifiedColumns[] = GroupPricePeer::CREATED_AT;
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
			$this->modifiedColumns[] = GroupPricePeer::UPDATED_AT;
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
          $this->modifiedColumns[] = GroupPricePeer::ID;
        }

	} // setId()

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
          $this->modifiedColumns[] = GroupPricePeer::NAME;
        }

	} // setName()

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
          $this->modifiedColumns[] = GroupPricePeer::DESCRIPTION;
        }

	} // setDescription()

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
          $this->modifiedColumns[] = GroupPricePeer::TAX_ID;
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
          $this->modifiedColumns[] = GroupPricePeer::OPT_VAT;
        }

	} // setOptVat()

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
          $this->modifiedColumns[] = GroupPricePeer::CURRENCY_ID;
        }

		if ($this->aCurrency !== null && $this->aCurrency->getId() !== $v) {
			$this->aCurrency = null;
		}

	} // setCurrencyId()

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

        if ($this->price_netto !== $v) {
          $this->price_netto = $v;
          $this->modifiedColumns[] = GroupPricePeer::PRICE_NETTO;
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

        if ($this->price_brutto !== $v) {
          $this->price_brutto = $v;
          $this->modifiedColumns[] = GroupPricePeer::PRICE_BRUTTO;
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

        if ($this->old_price_netto !== $v) {
          $this->old_price_netto = $v;
          $this->modifiedColumns[] = GroupPricePeer::OLD_PRICE_NETTO;
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

        if ($this->old_price_brutto !== $v) {
          $this->old_price_brutto = $v;
          $this->modifiedColumns[] = GroupPricePeer::OLD_PRICE_BRUTTO;
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

        if ($this->wholesale_a_netto !== $v) {
          $this->wholesale_a_netto = $v;
          $this->modifiedColumns[] = GroupPricePeer::WHOLESALE_A_NETTO;
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

        if ($this->wholesale_a_brutto !== $v) {
          $this->wholesale_a_brutto = $v;
          $this->modifiedColumns[] = GroupPricePeer::WHOLESALE_A_BRUTTO;
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

        if ($this->wholesale_b_netto !== $v) {
          $this->wholesale_b_netto = $v;
          $this->modifiedColumns[] = GroupPricePeer::WHOLESALE_B_NETTO;
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

        if ($this->wholesale_b_brutto !== $v) {
          $this->wholesale_b_brutto = $v;
          $this->modifiedColumns[] = GroupPricePeer::WHOLESALE_B_BRUTTO;
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

        if ($this->wholesale_c_netto !== $v) {
          $this->wholesale_c_netto = $v;
          $this->modifiedColumns[] = GroupPricePeer::WHOLESALE_C_NETTO;
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

        if ($this->wholesale_c_brutto !== $v) {
          $this->wholesale_c_brutto = $v;
          $this->modifiedColumns[] = GroupPricePeer::WHOLESALE_C_BRUTTO;
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
      if ($this->getDispatcher()->getListeners('GroupPrice.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'GroupPrice.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->name = $rs->getString($startcol + 3);

      $this->description = $rs->getString($startcol + 4);

      $this->tax_id = $rs->getInt($startcol + 5);

      $this->opt_vat = $rs->getString($startcol + 6);
      if (null !== $this->opt_vat && $this->opt_vat == intval($this->opt_vat))
      {
        $this->opt_vat = (string)intval($this->opt_vat);
      }

      $this->currency_id = $rs->getInt($startcol + 7);

      $this->price_netto = $rs->getString($startcol + 8);
      if (null !== $this->price_netto && $this->price_netto == intval($this->price_netto))
      {
        $this->price_netto = (string)intval($this->price_netto);
      }

      $this->price_brutto = $rs->getString($startcol + 9);
      if (null !== $this->price_brutto && $this->price_brutto == intval($this->price_brutto))
      {
        $this->price_brutto = (string)intval($this->price_brutto);
      }

      $this->old_price_netto = $rs->getString($startcol + 10);
      if (null !== $this->old_price_netto && $this->old_price_netto == intval($this->old_price_netto))
      {
        $this->old_price_netto = (string)intval($this->old_price_netto);
      }

      $this->old_price_brutto = $rs->getString($startcol + 11);
      if (null !== $this->old_price_brutto && $this->old_price_brutto == intval($this->old_price_brutto))
      {
        $this->old_price_brutto = (string)intval($this->old_price_brutto);
      }

      $this->wholesale_a_netto = $rs->getString($startcol + 12);
      if (null !== $this->wholesale_a_netto && $this->wholesale_a_netto == intval($this->wholesale_a_netto))
      {
        $this->wholesale_a_netto = (string)intval($this->wholesale_a_netto);
      }

      $this->wholesale_a_brutto = $rs->getString($startcol + 13);
      if (null !== $this->wholesale_a_brutto && $this->wholesale_a_brutto == intval($this->wholesale_a_brutto))
      {
        $this->wholesale_a_brutto = (string)intval($this->wholesale_a_brutto);
      }

      $this->wholesale_b_netto = $rs->getString($startcol + 14);
      if (null !== $this->wholesale_b_netto && $this->wholesale_b_netto == intval($this->wholesale_b_netto))
      {
        $this->wholesale_b_netto = (string)intval($this->wholesale_b_netto);
      }

      $this->wholesale_b_brutto = $rs->getString($startcol + 15);
      if (null !== $this->wholesale_b_brutto && $this->wholesale_b_brutto == intval($this->wholesale_b_brutto))
      {
        $this->wholesale_b_brutto = (string)intval($this->wholesale_b_brutto);
      }

      $this->wholesale_c_netto = $rs->getString($startcol + 16);
      if (null !== $this->wholesale_c_netto && $this->wholesale_c_netto == intval($this->wholesale_c_netto))
      {
        $this->wholesale_c_netto = (string)intval($this->wholesale_c_netto);
      }

      $this->wholesale_c_brutto = $rs->getString($startcol + 17);
      if (null !== $this->wholesale_c_brutto && $this->wholesale_c_brutto == intval($this->wholesale_c_brutto))
      {
        $this->wholesale_c_brutto = (string)intval($this->wholesale_c_brutto);
      }

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('GroupPrice.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'GroupPrice.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 18)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 18; // 18 = GroupPricePeer::NUM_COLUMNS - GroupPricePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating GroupPrice object", $e);
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

    if ($this->getDispatcher()->getListeners('GroupPrice.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'GroupPrice.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseGroupPrice:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseGroupPrice:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(GroupPricePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      GroupPricePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('GroupPrice.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'GroupPrice.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseGroupPrice:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseGroupPrice:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('GroupPrice.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'GroupPrice.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseGroupPrice:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(GroupPricePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(GroupPricePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(GroupPricePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('GroupPrice.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'GroupPrice.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseGroupPrice:save:post') as $callable)
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

			if ($this->aCurrency !== null) {
				if ($this->aCurrency->isModified() || $this->aCurrency->getCurrentCurrencyI18n()->isModified()) {
					$affectedRows += $this->aCurrency->save($con);
				}
				$this->setCurrency($this->aCurrency);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = GroupPricePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += GroupPricePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collProducts !== null) {
				foreach($this->collProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAddGroupPrices !== null) {
				foreach($this->collAddGroupPrices as $referrerFK) {
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

			if ($this->aCurrency !== null) {
				if (!$this->aCurrency->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCurrency->getValidationFailures());
				}
			}


			if (($retval = GroupPricePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collProducts !== null) {
					foreach($this->collProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAddGroupPrices !== null) {
					foreach($this->collAddGroupPrices as $referrerFK) {
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
		$pos = GroupPricePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getName();
				break;
			case 4:
				return $this->getDescription();
				break;
			case 5:
				return $this->getTaxId();
				break;
			case 6:
				return $this->getOptVat();
				break;
			case 7:
				return $this->getCurrencyId();
				break;
			case 8:
				return $this->getPriceNetto();
				break;
			case 9:
				return $this->getPriceBrutto();
				break;
			case 10:
				return $this->getOldPriceNetto();
				break;
			case 11:
				return $this->getOldPriceBrutto();
				break;
			case 12:
				return $this->getWholesaleANetto();
				break;
			case 13:
				return $this->getWholesaleABrutto();
				break;
			case 14:
				return $this->getWholesaleBNetto();
				break;
			case 15:
				return $this->getWholesaleBBrutto();
				break;
			case 16:
				return $this->getWholesaleCNetto();
				break;
			case 17:
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
		$keys = GroupPricePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getName(),
			$keys[4] => $this->getDescription(),
			$keys[5] => $this->getTaxId(),
			$keys[6] => $this->getOptVat(),
			$keys[7] => $this->getCurrencyId(),
			$keys[8] => $this->getPriceNetto(),
			$keys[9] => $this->getPriceBrutto(),
			$keys[10] => $this->getOldPriceNetto(),
			$keys[11] => $this->getOldPriceBrutto(),
			$keys[12] => $this->getWholesaleANetto(),
			$keys[13] => $this->getWholesaleABrutto(),
			$keys[14] => $this->getWholesaleBNetto(),
			$keys[15] => $this->getWholesaleBBrutto(),
			$keys[16] => $this->getWholesaleCNetto(),
			$keys[17] => $this->getWholesaleCBrutto(),
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
		$pos = GroupPricePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setName($value);
				break;
			case 4:
				$this->setDescription($value);
				break;
			case 5:
				$this->setTaxId($value);
				break;
			case 6:
				$this->setOptVat($value);
				break;
			case 7:
				$this->setCurrencyId($value);
				break;
			case 8:
				$this->setPriceNetto($value);
				break;
			case 9:
				$this->setPriceBrutto($value);
				break;
			case 10:
				$this->setOldPriceNetto($value);
				break;
			case 11:
				$this->setOldPriceBrutto($value);
				break;
			case 12:
				$this->setWholesaleANetto($value);
				break;
			case 13:
				$this->setWholesaleABrutto($value);
				break;
			case 14:
				$this->setWholesaleBNetto($value);
				break;
			case 15:
				$this->setWholesaleBBrutto($value);
				break;
			case 16:
				$this->setWholesaleCNetto($value);
				break;
			case 17:
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
		$keys = GroupPricePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDescription($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setTaxId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setOptVat($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCurrencyId($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setPriceNetto($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setPriceBrutto($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setOldPriceNetto($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setOldPriceBrutto($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setWholesaleANetto($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setWholesaleABrutto($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setWholesaleBNetto($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setWholesaleBBrutto($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setWholesaleCNetto($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setWholesaleCBrutto($arr[$keys[17]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(GroupPricePeer::DATABASE_NAME);

		if ($this->isColumnModified(GroupPricePeer::CREATED_AT)) $criteria->add(GroupPricePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(GroupPricePeer::UPDATED_AT)) $criteria->add(GroupPricePeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(GroupPricePeer::ID)) $criteria->add(GroupPricePeer::ID, $this->id);
		if ($this->isColumnModified(GroupPricePeer::NAME)) $criteria->add(GroupPricePeer::NAME, $this->name);
		if ($this->isColumnModified(GroupPricePeer::DESCRIPTION)) $criteria->add(GroupPricePeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(GroupPricePeer::TAX_ID)) $criteria->add(GroupPricePeer::TAX_ID, $this->tax_id);
		if ($this->isColumnModified(GroupPricePeer::OPT_VAT)) $criteria->add(GroupPricePeer::OPT_VAT, $this->opt_vat);
		if ($this->isColumnModified(GroupPricePeer::CURRENCY_ID)) $criteria->add(GroupPricePeer::CURRENCY_ID, $this->currency_id);
		if ($this->isColumnModified(GroupPricePeer::PRICE_NETTO)) $criteria->add(GroupPricePeer::PRICE_NETTO, $this->price_netto);
		if ($this->isColumnModified(GroupPricePeer::PRICE_BRUTTO)) $criteria->add(GroupPricePeer::PRICE_BRUTTO, $this->price_brutto);
		if ($this->isColumnModified(GroupPricePeer::OLD_PRICE_NETTO)) $criteria->add(GroupPricePeer::OLD_PRICE_NETTO, $this->old_price_netto);
		if ($this->isColumnModified(GroupPricePeer::OLD_PRICE_BRUTTO)) $criteria->add(GroupPricePeer::OLD_PRICE_BRUTTO, $this->old_price_brutto);
		if ($this->isColumnModified(GroupPricePeer::WHOLESALE_A_NETTO)) $criteria->add(GroupPricePeer::WHOLESALE_A_NETTO, $this->wholesale_a_netto);
		if ($this->isColumnModified(GroupPricePeer::WHOLESALE_A_BRUTTO)) $criteria->add(GroupPricePeer::WHOLESALE_A_BRUTTO, $this->wholesale_a_brutto);
		if ($this->isColumnModified(GroupPricePeer::WHOLESALE_B_NETTO)) $criteria->add(GroupPricePeer::WHOLESALE_B_NETTO, $this->wholesale_b_netto);
		if ($this->isColumnModified(GroupPricePeer::WHOLESALE_B_BRUTTO)) $criteria->add(GroupPricePeer::WHOLESALE_B_BRUTTO, $this->wholesale_b_brutto);
		if ($this->isColumnModified(GroupPricePeer::WHOLESALE_C_NETTO)) $criteria->add(GroupPricePeer::WHOLESALE_C_NETTO, $this->wholesale_c_netto);
		if ($this->isColumnModified(GroupPricePeer::WHOLESALE_C_BRUTTO)) $criteria->add(GroupPricePeer::WHOLESALE_C_BRUTTO, $this->wholesale_c_brutto);

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
		$criteria = new Criteria(GroupPricePeer::DATABASE_NAME);

		$criteria->add(GroupPricePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of GroupPrice (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setName($this->name);

		$copyObj->setDescription($this->description);

		$copyObj->setTaxId($this->tax_id);

		$copyObj->setOptVat($this->opt_vat);

		$copyObj->setCurrencyId($this->currency_id);

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


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getProducts() as $relObj) {
				$copyObj->addProduct($relObj->copy($deepCopy));
			}

			foreach($this->getAddGroupPrices() as $relObj) {
				$copyObj->addAddGroupPrice($relObj->copy($deepCopy));
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
	 * @return     GroupPrice Clone of current object.
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
	 * @return     GroupPricePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new GroupPricePeer();
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
	 * Temporary storage of collProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProducts()
	{
		if ($this->collProducts === null) {
			$this->collProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GroupPrice has previously
	 * been saved, it will retrieve related Products from storage.
	 * If this GroupPrice is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
			   $this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

				ProductPeer::addSelectColumns($criteria);
				$this->collProducts = ProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

				ProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
					$this->collProducts = ProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductCriteria = $criteria;
		return $this->collProducts;
	}

	/**
	 * Returns the number of related Products.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

		return ProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Product object to this object
	 * through the Product foreign key attribute
	 *
	 * @param      Product $l Product
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProduct(Product $l)
	{
		$this->collProducts[] = $l;
		$l->setGroupPrice($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GroupPrice is new, it will return
	 * an empty collection; or if this GroupPrice has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in GroupPrice.
	 */
	public function getProductsJoinProductRelatedByParentId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinProductRelatedByParentId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinProductRelatedByParentId($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GroupPrice is new, it will return
	 * an empty collection; or if this GroupPrice has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in GroupPrice.
	 */
	public function getProductsJoinCurrency($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinCurrency($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GroupPrice is new, it will return
	 * an empty collection; or if this GroupPrice has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in GroupPrice.
	 */
	public function getProductsJoinProducer($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinProducer($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinProducer($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GroupPrice is new, it will return
	 * an empty collection; or if this GroupPrice has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in GroupPrice.
	 */
	public function getProductsJoinBasicPriceUnitMeasureRelatedByBpumDefaultId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumDefaultId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumDefaultId($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GroupPrice is new, it will return
	 * an empty collection; or if this GroupPrice has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in GroupPrice.
	 */
	public function getProductsJoinBasicPriceUnitMeasureRelatedByBpumId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumId($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GroupPrice is new, it will return
	 * an empty collection; or if this GroupPrice has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in GroupPrice.
	 */
	public function getProductsJoinProductDimension($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinProductDimension($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinProductDimension($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GroupPrice is new, it will return
	 * an empty collection; or if this GroupPrice has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in GroupPrice.
	 */
	public function getProductsJoinAvailability($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinAvailability($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinAvailability($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GroupPrice is new, it will return
	 * an empty collection; or if this GroupPrice has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in GroupPrice.
	 */
	public function getProductsJoinTax($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinTax($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::GROUP_PRICE_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinTax($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}

	/**
	 * Temporary storage of collAddGroupPrices to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initAddGroupPrices()
	{
		if ($this->collAddGroupPrices === null) {
			$this->collAddGroupPrices = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GroupPrice has previously
	 * been saved, it will retrieve related AddGroupPrices from storage.
	 * If this GroupPrice is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getAddGroupPrices($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAddGroupPrices === null) {
			if ($this->isNew()) {
			   $this->collAddGroupPrices = array();
			} else {

				$criteria->add(AddGroupPricePeer::ID, $this->getId());

				AddGroupPricePeer::addSelectColumns($criteria);
				$this->collAddGroupPrices = AddGroupPricePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AddGroupPricePeer::ID, $this->getId());

				AddGroupPricePeer::addSelectColumns($criteria);
				if (!isset($this->lastAddGroupPriceCriteria) || !$this->lastAddGroupPriceCriteria->equals($criteria)) {
					$this->collAddGroupPrices = AddGroupPricePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAddGroupPriceCriteria = $criteria;
		return $this->collAddGroupPrices;
	}

	/**
	 * Returns the number of related AddGroupPrices.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countAddGroupPrices($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AddGroupPricePeer::ID, $this->getId());

		return AddGroupPricePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a AddGroupPrice object to this object
	 * through the AddGroupPrice foreign key attribute
	 *
	 * @param      AddGroupPrice $l AddGroupPrice
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAddGroupPrice(AddGroupPrice $l)
	{
		$this->collAddGroupPrices[] = $l;
		$l->setGroupPrice($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GroupPrice is new, it will return
	 * an empty collection; or if this GroupPrice has previously
	 * been saved, it will retrieve related AddGroupPrices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in GroupPrice.
	 */
	public function getAddGroupPricesJoinCurrency($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAddGroupPrices === null) {
			if ($this->isNew()) {
				$this->collAddGroupPrices = array();
			} else {

				$criteria->add(AddGroupPricePeer::ID, $this->getId());

				$this->collAddGroupPrices = AddGroupPricePeer::doSelectJoinCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AddGroupPricePeer::ID, $this->getId());

			if (!isset($this->lastAddGroupPriceCriteria) || !$this->lastAddGroupPriceCriteria->equals($criteria)) {
				$this->collAddGroupPrices = AddGroupPricePeer::doSelectJoinCurrency($criteria, $con);
			}
		}
		$this->lastAddGroupPriceCriteria = $criteria;

		return $this->collAddGroupPrices;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GroupPrice is new, it will return
	 * an empty collection; or if this GroupPrice has previously
	 * been saved, it will retrieve related AddGroupPrices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in GroupPrice.
	 */
	public function getAddGroupPricesJoinTax($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAddGroupPrices === null) {
			if ($this->isNew()) {
				$this->collAddGroupPrices = array();
			} else {

				$criteria->add(AddGroupPricePeer::ID, $this->getId());

				$this->collAddGroupPrices = AddGroupPricePeer::doSelectJoinTax($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AddGroupPricePeer::ID, $this->getId());

			if (!isset($this->lastAddGroupPriceCriteria) || !$this->lastAddGroupPriceCriteria->equals($criteria)) {
				$this->collAddGroupPrices = AddGroupPricePeer::doSelectJoinTax($criteria, $con);
			}
		}
		$this->lastAddGroupPriceCriteria = $criteria;

		return $this->collAddGroupPrices;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'GroupPrice.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseGroupPrice:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseGroupPrice::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseGroupPrice
