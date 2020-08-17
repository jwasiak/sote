<?php

/**
 * Base class that represents a row from the 'st_invoice_product' table.
 *
 * 
 *
 * @package    plugins.stInvoicePlugin.lib.model.om
 */
abstract class BaseInvoiceProduct extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        InvoiceProductPeer
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
	 * The value for the invoice_id field.
	 * @var        int
	 */
	protected $invoice_id;


	/**
	 * The value for the product_id field.
	 * @var        int
	 */
	protected $product_id;


	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the code field.
	 * @var        string
	 */
	protected $code;


	/**
	 * The value for the pkwiu field.
	 * @var        string
	 */
	protected $pkwiu;


	/**
	 * The value for the quantity field.
	 * @var        double
	 */
	protected $quantity;


	/**
	 * The value for the measure_unit field.
	 * @var        string
	 */
	protected $measure_unit;


	/**
	 * The value for the discount field.
	 * @var        double
	 */
	protected $discount;


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
	 * The value for the vat field.
	 * @var        double
	 */
	protected $vat;


	/**
	 * The value for the vat_id field.
	 * @var        int
	 */
	protected $vat_id;


	/**
	 * The value for the total_price_netto field.
	 * @var        double
	 */
	protected $total_price_netto;


	/**
	 * The value for the vat_ammount field.
	 * @var        double
	 */
	protected $vat_ammount;


	/**
	 * The value for the opt_total_price_brutto field.
	 * @var        double
	 */
	protected $opt_total_price_brutto;

	/**
	 * @var        Invoice
	 */
	protected $aInvoice;

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
     * Get the [invoice_id] column value.
     * 
     * @return     int
     */
    public function getInvoiceId()
    {

            return $this->invoice_id;
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
     * Get the [name] column value.
     * 
     * @return     string
     */
    public function getName()
    {

            return $this->name;
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
     * Get the [pkwiu] column value.
     * 
     * @return     string
     */
    public function getPkwiu()
    {

            return $this->pkwiu;
    }

    /**
     * Get the [quantity] column value.
     * 
     * @return     double
     */
    public function getQuantity()
    {

            return null !== $this->quantity ? (string)$this->quantity : null;
    }

    /**
     * Get the [measure_unit] column value.
     * 
     * @return     string
     */
    public function getMeasureUnit()
    {

            return $this->measure_unit;
    }

    /**
     * Get the [discount] column value.
     * 
     * @return     double
     */
    public function getDiscount()
    {

            return $this->discount;
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
     * Get the [vat] column value.
     * 
     * @return     double
     */
    public function getVat()
    {

            return $this->vat;
    }

    /**
     * Get the [vat_id] column value.
     * 
     * @return     int
     */
    public function getVatId()
    {

            return $this->vat_id;
    }

    /**
     * Get the [total_price_netto] column value.
     * 
     * @return     double
     */
    public function getTotalPriceNetto()
    {

            return null !== $this->total_price_netto ? (string)$this->total_price_netto : null;
    }

    /**
     * Get the [vat_ammount] column value.
     * 
     * @return     double
     */
    public function getVatAmmount()
    {

            return null !== $this->vat_ammount ? (string)$this->vat_ammount : null;
    }

    /**
     * Get the [opt_total_price_brutto] column value.
     * 
     * @return     double
     */
    public function getOptTotalPriceBrutto()
    {

            return null !== $this->opt_total_price_brutto ? (string)$this->opt_total_price_brutto : null;
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
			$this->modifiedColumns[] = InvoiceProductPeer::CREATED_AT;
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
			$this->modifiedColumns[] = InvoiceProductPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = InvoiceProductPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [invoice_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setInvoiceId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->invoice_id !== $v) {
          $this->invoice_id = $v;
          $this->modifiedColumns[] = InvoiceProductPeer::INVOICE_ID;
        }

		if ($this->aInvoice !== null && $this->aInvoice->getId() !== $v) {
			$this->aInvoice = null;
		}

	} // setInvoiceId()

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
          $this->modifiedColumns[] = InvoiceProductPeer::PRODUCT_ID;
        }

		if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
			$this->aProduct = null;
		}

	} // setProductId()

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
          $this->modifiedColumns[] = InvoiceProductPeer::NAME;
        }

	} // setName()

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
          $this->modifiedColumns[] = InvoiceProductPeer::CODE;
        }

	} // setCode()

	/**
	 * Set the value of [pkwiu] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPkwiu($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->pkwiu !== $v) {
          $this->pkwiu = $v;
          $this->modifiedColumns[] = InvoiceProductPeer::PKWIU;
        }

	} // setPkwiu()

	/**
	 * Set the value of [quantity] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setQuantity($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->quantity !== $v) {
          $this->quantity = $v;
          $this->modifiedColumns[] = InvoiceProductPeer::QUANTITY;
        }

	} // setQuantity()

	/**
	 * Set the value of [measure_unit] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setMeasureUnit($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->measure_unit !== $v) {
          $this->measure_unit = $v;
          $this->modifiedColumns[] = InvoiceProductPeer::MEASURE_UNIT;
        }

	} // setMeasureUnit()

	/**
	 * Set the value of [discount] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setDiscount($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->discount !== $v) {
          $this->discount = $v;
          $this->modifiedColumns[] = InvoiceProductPeer::DISCOUNT;
        }

	} // setDiscount()

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
          $this->modifiedColumns[] = InvoiceProductPeer::PRICE_NETTO;
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
          $this->modifiedColumns[] = InvoiceProductPeer::PRICE_BRUTTO;
        }

	} // setPriceBrutto()

	/**
	 * Set the value of [vat] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setVat($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->vat !== $v) {
          $this->vat = $v;
          $this->modifiedColumns[] = InvoiceProductPeer::VAT;
        }

	} // setVat()

	/**
	 * Set the value of [vat_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setVatId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->vat_id !== $v) {
          $this->vat_id = $v;
          $this->modifiedColumns[] = InvoiceProductPeer::VAT_ID;
        }

	} // setVatId()

	/**
	 * Set the value of [total_price_netto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setTotalPriceNetto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->total_price_netto !== $v) {
          $this->total_price_netto = $v;
          $this->modifiedColumns[] = InvoiceProductPeer::TOTAL_PRICE_NETTO;
        }

	} // setTotalPriceNetto()

	/**
	 * Set the value of [vat_ammount] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setVatAmmount($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->vat_ammount !== $v) {
          $this->vat_ammount = $v;
          $this->modifiedColumns[] = InvoiceProductPeer::VAT_AMMOUNT;
        }

	} // setVatAmmount()

	/**
	 * Set the value of [opt_total_price_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOptTotalPriceBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->opt_total_price_brutto !== $v) {
          $this->opt_total_price_brutto = $v;
          $this->modifiedColumns[] = InvoiceProductPeer::OPT_TOTAL_PRICE_BRUTTO;
        }

	} // setOptTotalPriceBrutto()

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
      if ($this->getDispatcher()->getListeners('InvoiceProduct.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceProduct.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->invoice_id = $rs->getInt($startcol + 3);

      $this->product_id = $rs->getInt($startcol + 4);

      $this->name = $rs->getString($startcol + 5);

      $this->code = $rs->getString($startcol + 6);

      $this->pkwiu = $rs->getString($startcol + 7);

      $this->quantity = $rs->getString($startcol + 8);
      if (null !== $this->quantity && $this->quantity == intval($this->quantity))
      {
        $this->quantity = (string)intval($this->quantity);
      }

      $this->measure_unit = $rs->getString($startcol + 9);

      $this->discount = $rs->getFloat($startcol + 10);

      $this->price_netto = $rs->getString($startcol + 11);
      if (null !== $this->price_netto && $this->price_netto == intval($this->price_netto))
      {
        $this->price_netto = (string)intval($this->price_netto);
      }

      $this->price_brutto = $rs->getString($startcol + 12);
      if (null !== $this->price_brutto && $this->price_brutto == intval($this->price_brutto))
      {
        $this->price_brutto = (string)intval($this->price_brutto);
      }

      $this->vat = $rs->getFloat($startcol + 13);

      $this->vat_id = $rs->getInt($startcol + 14);

      $this->total_price_netto = $rs->getString($startcol + 15);
      if (null !== $this->total_price_netto && $this->total_price_netto == intval($this->total_price_netto))
      {
        $this->total_price_netto = (string)intval($this->total_price_netto);
      }

      $this->vat_ammount = $rs->getString($startcol + 16);
      if (null !== $this->vat_ammount && $this->vat_ammount == intval($this->vat_ammount))
      {
        $this->vat_ammount = (string)intval($this->vat_ammount);
      }

      $this->opt_total_price_brutto = $rs->getString($startcol + 17);
      if (null !== $this->opt_total_price_brutto && $this->opt_total_price_brutto == intval($this->opt_total_price_brutto))
      {
        $this->opt_total_price_brutto = (string)intval($this->opt_total_price_brutto);
      }

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('InvoiceProduct.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceProduct.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 18)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 18; // 18 = InvoiceProductPeer::NUM_COLUMNS - InvoiceProductPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating InvoiceProduct object", $e);
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

    if ($this->getDispatcher()->getListeners('InvoiceProduct.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceProduct.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseInvoiceProduct:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseInvoiceProduct:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(InvoiceProductPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      InvoiceProductPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('InvoiceProduct.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceProduct.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseInvoiceProduct:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseInvoiceProduct:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('InvoiceProduct.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceProduct.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseInvoiceProduct:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(InvoiceProductPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(InvoiceProductPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(InvoiceProductPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('InvoiceProduct.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceProduct.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseInvoiceProduct:save:post') as $callable)
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

			if ($this->aInvoice !== null) {
				if ($this->aInvoice->isModified()) {
					$affectedRows += $this->aInvoice->save($con);
				}
				$this->setInvoice($this->aInvoice);
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
					$pk = InvoiceProductPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += InvoiceProductPeer::doUpdate($this, $con);
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

			if ($this->aInvoice !== null) {
				if (!$this->aInvoice->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aInvoice->getValidationFailures());
				}
			}

			if ($this->aProduct !== null) {
				if (!$this->aProduct->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProduct->getValidationFailures());
				}
			}


			if (($retval = InvoiceProductPeer::doValidate($this, $columns)) !== true) {
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
		$pos = InvoiceProductPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getInvoiceId();
				break;
			case 4:
				return $this->getProductId();
				break;
			case 5:
				return $this->getName();
				break;
			case 6:
				return $this->getCode();
				break;
			case 7:
				return $this->getPkwiu();
				break;
			case 8:
				return $this->getQuantity();
				break;
			case 9:
				return $this->getMeasureUnit();
				break;
			case 10:
				return $this->getDiscount();
				break;
			case 11:
				return $this->getPriceNetto();
				break;
			case 12:
				return $this->getPriceBrutto();
				break;
			case 13:
				return $this->getVat();
				break;
			case 14:
				return $this->getVatId();
				break;
			case 15:
				return $this->getTotalPriceNetto();
				break;
			case 16:
				return $this->getVatAmmount();
				break;
			case 17:
				return $this->getOptTotalPriceBrutto();
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
		$keys = InvoiceProductPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getInvoiceId(),
			$keys[4] => $this->getProductId(),
			$keys[5] => $this->getName(),
			$keys[6] => $this->getCode(),
			$keys[7] => $this->getPkwiu(),
			$keys[8] => $this->getQuantity(),
			$keys[9] => $this->getMeasureUnit(),
			$keys[10] => $this->getDiscount(),
			$keys[11] => $this->getPriceNetto(),
			$keys[12] => $this->getPriceBrutto(),
			$keys[13] => $this->getVat(),
			$keys[14] => $this->getVatId(),
			$keys[15] => $this->getTotalPriceNetto(),
			$keys[16] => $this->getVatAmmount(),
			$keys[17] => $this->getOptTotalPriceBrutto(),
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
		$pos = InvoiceProductPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setInvoiceId($value);
				break;
			case 4:
				$this->setProductId($value);
				break;
			case 5:
				$this->setName($value);
				break;
			case 6:
				$this->setCode($value);
				break;
			case 7:
				$this->setPkwiu($value);
				break;
			case 8:
				$this->setQuantity($value);
				break;
			case 9:
				$this->setMeasureUnit($value);
				break;
			case 10:
				$this->setDiscount($value);
				break;
			case 11:
				$this->setPriceNetto($value);
				break;
			case 12:
				$this->setPriceBrutto($value);
				break;
			case 13:
				$this->setVat($value);
				break;
			case 14:
				$this->setVatId($value);
				break;
			case 15:
				$this->setTotalPriceNetto($value);
				break;
			case 16:
				$this->setVatAmmount($value);
				break;
			case 17:
				$this->setOptTotalPriceBrutto($value);
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
		$keys = InvoiceProductPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setInvoiceId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setProductId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setName($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCode($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPkwiu($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setQuantity($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setMeasureUnit($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setDiscount($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setPriceNetto($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setPriceBrutto($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setVat($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setVatId($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setTotalPriceNetto($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setVatAmmount($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setOptTotalPriceBrutto($arr[$keys[17]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(InvoiceProductPeer::DATABASE_NAME);

		if ($this->isColumnModified(InvoiceProductPeer::CREATED_AT)) $criteria->add(InvoiceProductPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(InvoiceProductPeer::UPDATED_AT)) $criteria->add(InvoiceProductPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(InvoiceProductPeer::ID)) $criteria->add(InvoiceProductPeer::ID, $this->id);
		if ($this->isColumnModified(InvoiceProductPeer::INVOICE_ID)) $criteria->add(InvoiceProductPeer::INVOICE_ID, $this->invoice_id);
		if ($this->isColumnModified(InvoiceProductPeer::PRODUCT_ID)) $criteria->add(InvoiceProductPeer::PRODUCT_ID, $this->product_id);
		if ($this->isColumnModified(InvoiceProductPeer::NAME)) $criteria->add(InvoiceProductPeer::NAME, $this->name);
		if ($this->isColumnModified(InvoiceProductPeer::CODE)) $criteria->add(InvoiceProductPeer::CODE, $this->code);
		if ($this->isColumnModified(InvoiceProductPeer::PKWIU)) $criteria->add(InvoiceProductPeer::PKWIU, $this->pkwiu);
		if ($this->isColumnModified(InvoiceProductPeer::QUANTITY)) $criteria->add(InvoiceProductPeer::QUANTITY, $this->quantity);
		if ($this->isColumnModified(InvoiceProductPeer::MEASURE_UNIT)) $criteria->add(InvoiceProductPeer::MEASURE_UNIT, $this->measure_unit);
		if ($this->isColumnModified(InvoiceProductPeer::DISCOUNT)) $criteria->add(InvoiceProductPeer::DISCOUNT, $this->discount);
		if ($this->isColumnModified(InvoiceProductPeer::PRICE_NETTO)) $criteria->add(InvoiceProductPeer::PRICE_NETTO, $this->price_netto);
		if ($this->isColumnModified(InvoiceProductPeer::PRICE_BRUTTO)) $criteria->add(InvoiceProductPeer::PRICE_BRUTTO, $this->price_brutto);
		if ($this->isColumnModified(InvoiceProductPeer::VAT)) $criteria->add(InvoiceProductPeer::VAT, $this->vat);
		if ($this->isColumnModified(InvoiceProductPeer::VAT_ID)) $criteria->add(InvoiceProductPeer::VAT_ID, $this->vat_id);
		if ($this->isColumnModified(InvoiceProductPeer::TOTAL_PRICE_NETTO)) $criteria->add(InvoiceProductPeer::TOTAL_PRICE_NETTO, $this->total_price_netto);
		if ($this->isColumnModified(InvoiceProductPeer::VAT_AMMOUNT)) $criteria->add(InvoiceProductPeer::VAT_AMMOUNT, $this->vat_ammount);
		if ($this->isColumnModified(InvoiceProductPeer::OPT_TOTAL_PRICE_BRUTTO)) $criteria->add(InvoiceProductPeer::OPT_TOTAL_PRICE_BRUTTO, $this->opt_total_price_brutto);

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
		$criteria = new Criteria(InvoiceProductPeer::DATABASE_NAME);

		$criteria->add(InvoiceProductPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of InvoiceProduct (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setInvoiceId($this->invoice_id);

		$copyObj->setProductId($this->product_id);

		$copyObj->setName($this->name);

		$copyObj->setCode($this->code);

		$copyObj->setPkwiu($this->pkwiu);

		$copyObj->setQuantity($this->quantity);

		$copyObj->setMeasureUnit($this->measure_unit);

		$copyObj->setDiscount($this->discount);

		$copyObj->setPriceNetto($this->price_netto);

		$copyObj->setPriceBrutto($this->price_brutto);

		$copyObj->setVat($this->vat);

		$copyObj->setVatId($this->vat_id);

		$copyObj->setTotalPriceNetto($this->total_price_netto);

		$copyObj->setVatAmmount($this->vat_ammount);

		$copyObj->setOptTotalPriceBrutto($this->opt_total_price_brutto);


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
	 * @return     InvoiceProduct Clone of current object.
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
	 * @return     InvoiceProductPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new InvoiceProductPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Invoice object.
	 *
	 * @param      Invoice $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setInvoice($v)
	{


		if ($v === null) {
			$this->setInvoiceId(NULL);
		} else {
			$this->setInvoiceId($v->getId());
		}


		$this->aInvoice = $v;
	}


	/**
	 * Get the associated Invoice object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Invoice The associated Invoice object.
	 * @throws     PropelException
	 */
	public function getInvoice($con = null)
	{
		if ($this->aInvoice === null && ($this->invoice_id !== null)) {
			// include the related Peer class
			$this->aInvoice = InvoicePeer::retrieveByPK($this->invoice_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = InvoicePeer::retrieveByPK($this->invoice_id, $con);
			   $obj->addInvoices($this);
			 */
		}
		return $this->aInvoice;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'InvoiceProduct.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseInvoiceProduct:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseInvoiceProduct::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseInvoiceProduct
