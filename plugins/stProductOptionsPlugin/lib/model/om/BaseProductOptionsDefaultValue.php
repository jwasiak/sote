<?php

/**
 * Base class that represents a row from the 'st_product_options_default_value' table.
 *
 * 
 *
 * @package    plugins.stProductOptionsPlugin.lib.model.om
 */
abstract class BaseProductOptionsDefaultValue extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ProductOptionsDefaultValuePeer
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
	 * The value for the product_options_template_id field.
	 * @var        int
	 */
	protected $product_options_template_id;


	/**
	 * The value for the product_options_default_value_id field.
	 * @var        int
	 */
	protected $product_options_default_value_id;


	/**
	 * The value for the product_options_field_id field.
	 * @var        int
	 */
	protected $product_options_field_id;


	/**
	 * The value for the price field.
	 * @var        string
	 */
	protected $price;


	/**
	 * The value for the weight field.
	 * @var        string
	 */
	protected $weight;


	/**
	 * The value for the lft field.
	 * @var        int
	 */
	protected $lft;


	/**
	 * The value for the rgt field.
	 * @var        int
	 */
	protected $rgt;


	/**
	 * The value for the opt_value field.
	 * @var        string
	 */
	protected $opt_value;


	/**
	 * The value for the price_type field.
	 * @var        string
	 */
	protected $price_type;


	/**
	 * The value for the depth field.
	 * @var        int
	 */
	protected $depth;


	/**
	 * The value for the opt_version field.
	 * @var        int
	 */
	protected $opt_version = 0;


	/**
	 * The value for the color field.
	 * @var        string
	 */
	protected $color;


	/**
	 * The value for the use_image_as_color field.
	 * @var        boolean
	 */
	protected $use_image_as_color = false;


	/**
	 * The value for the old_price field.
	 * @var        double
	 */
	protected $old_price;


	/**
	 * The value for the pum field.
	 * @var        double
	 */
	protected $pum;

	/**
	 * @var        ProductOptionsTemplate
	 */
	protected $aProductOptionsTemplate;

	/**
	 * @var        ProductOptionsDefaultValue
	 */
	protected $aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId;

	/**
	 * @var        ProductOptionsField
	 */
	protected $aProductOptionsField;

	/**
	 * Collection to store aggregation of collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId.
	 * @var        array
	 */
	protected $collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId;

	/**
	 * The criteria used to select the current contents of collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId.
	 * @var        Criteria
	 */
	protected $lastProductOptionsDefaultValueRelatedByProductOptionsDefaultValueIdCriteria = null;

	/**
	 * Collection to store aggregation of collProductOptionsDefaultValueI18ns.
	 * @var        array
	 */
	protected $collProductOptionsDefaultValueI18ns;

	/**
	 * The criteria used to select the current contents of collProductOptionsDefaultValueI18ns.
	 * @var        Criteria
	 */
	protected $lastProductOptionsDefaultValueI18nCriteria = null;

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
     * Get the [product_options_template_id] column value.
     * 
     * @return     int
     */
    public function getProductOptionsTemplateId()
    {

            return $this->product_options_template_id;
    }

    /**
     * Get the [product_options_default_value_id] column value.
     * 
     * @return     int
     */
    public function getProductOptionsDefaultValueId()
    {

            return $this->product_options_default_value_id;
    }

    /**
     * Get the [product_options_field_id] column value.
     * 
     * @return     int
     */
    public function getProductOptionsFieldId()
    {

            return $this->product_options_field_id;
    }

    /**
     * Get the [price] column value.
     * 
     * @return     string
     */
    public function getPrice()
    {

            return $this->price;
    }

    /**
     * Get the [weight] column value.
     * 
     * @return     string
     */
    public function getWeight()
    {

            return $this->weight;
    }

    /**
     * Get the [lft] column value.
     * 
     * @return     int
     */
    public function getLft()
    {

            return $this->lft;
    }

    /**
     * Get the [rgt] column value.
     * 
     * @return     int
     */
    public function getRgt()
    {

            return $this->rgt;
    }

    /**
     * Get the [opt_value] column value.
     * 
     * @return     string
     */
    public function getOptValue()
    {

            return $this->opt_value;
    }

    /**
     * Get the [price_type] column value.
     * 
     * @return     string
     */
    public function getPriceType()
    {

            return $this->price_type;
    }

    /**
     * Get the [depth] column value.
     * 
     * @return     int
     */
    public function getDepth()
    {

            return $this->depth;
    }

    /**
     * Get the [opt_version] column value.
     * 
     * @return     int
     */
    public function getOptVersion()
    {

            return $this->opt_version;
    }

    /**
     * Get the [color] column value.
     * 
     * @return     string
     */
    public function getColor()
    {

            return $this->color;
    }

    /**
     * Get the [use_image_as_color] column value.
     * 
     * @return     boolean
     */
    public function getUseImageAsColor()
    {

            return $this->use_image_as_color;
    }

    /**
     * Get the [old_price] column value.
     * 
     * @return     double
     */
    public function getOldPrice()
    {

            return null !== $this->old_price ? (string)$this->old_price : null;
    }

    /**
     * Get the [pum] column value.
     * 
     * @return     double
     */
    public function getPum()
    {

            return null !== $this->pum ? (string)$this->pum : null;
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
			$this->modifiedColumns[] = ProductOptionsDefaultValuePeer::CREATED_AT;
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
			$this->modifiedColumns[] = ProductOptionsDefaultValuePeer::UPDATED_AT;
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
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [product_options_template_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setProductOptionsTemplateId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->product_options_template_id !== $v) {
          $this->product_options_template_id = $v;
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID;
        }

		if ($this->aProductOptionsTemplate !== null && $this->aProductOptionsTemplate->getId() !== $v) {
			$this->aProductOptionsTemplate = null;
		}

	} // setProductOptionsTemplateId()

	/**
	 * Set the value of [product_options_default_value_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setProductOptionsDefaultValueId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->product_options_default_value_id !== $v) {
          $this->product_options_default_value_id = $v;
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID;
        }

		if ($this->aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId !== null && $this->aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId->getId() !== $v) {
			$this->aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId = null;
		}

	} // setProductOptionsDefaultValueId()

	/**
	 * Set the value of [product_options_field_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setProductOptionsFieldId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->product_options_field_id !== $v) {
          $this->product_options_field_id = $v;
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID;
        }

		if ($this->aProductOptionsField !== null && $this->aProductOptionsField->getId() !== $v) {
			$this->aProductOptionsField = null;
		}

	} // setProductOptionsFieldId()

	/**
	 * Set the value of [price] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPrice($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->price !== $v) {
          $this->price = $v;
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::PRICE;
        }

	} // setPrice()

	/**
	 * Set the value of [weight] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setWeight($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->weight !== $v) {
          $this->weight = $v;
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::WEIGHT;
        }

	} // setWeight()

	/**
	 * Set the value of [lft] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setLft($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->lft !== $v) {
          $this->lft = $v;
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::LFT;
        }

	} // setLft()

	/**
	 * Set the value of [rgt] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setRgt($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->rgt !== $v) {
          $this->rgt = $v;
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::RGT;
        }

	} // setRgt()

	/**
	 * Set the value of [opt_value] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptValue($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_value !== $v) {
          $this->opt_value = $v;
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::OPT_VALUE;
        }

	} // setOptValue()

	/**
	 * Set the value of [price_type] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPriceType($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->price_type !== $v) {
          $this->price_type = $v;
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::PRICE_TYPE;
        }

	} // setPriceType()

	/**
	 * Set the value of [depth] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setDepth($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->depth !== $v) {
          $this->depth = $v;
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::DEPTH;
        }

	} // setDepth()

	/**
	 * Set the value of [opt_version] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOptVersion($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->opt_version !== $v || $v === 0) {
          $this->opt_version = $v;
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::OPT_VERSION;
        }

	} // setOptVersion()

	/**
	 * Set the value of [color] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setColor($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->color !== $v) {
          $this->color = $v;
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::COLOR;
        }

	} // setColor()

	/**
	 * Set the value of [use_image_as_color] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setUseImageAsColor($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->use_image_as_color !== $v || $v === false) {
          $this->use_image_as_color = $v;
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::USE_IMAGE_AS_COLOR;
        }

	} // setUseImageAsColor()

	/**
	 * Set the value of [old_price] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOldPrice($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->old_price !== $v) {
          $this->old_price = $v;
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::OLD_PRICE;
        }

	} // setOldPrice()

	/**
	 * Set the value of [pum] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setPum($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->pum !== $v) {
          $this->pum = $v;
          $this->modifiedColumns[] = ProductOptionsDefaultValuePeer::PUM;
        }

	} // setPum()

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
      if ($this->getDispatcher()->getListeners('ProductOptionsDefaultValue.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsDefaultValue.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->product_options_template_id = $rs->getInt($startcol + 3);

      $this->product_options_default_value_id = $rs->getInt($startcol + 4);

      $this->product_options_field_id = $rs->getInt($startcol + 5);

      $this->price = $rs->getString($startcol + 6);

      $this->weight = $rs->getString($startcol + 7);

      $this->lft = $rs->getInt($startcol + 8);

      $this->rgt = $rs->getInt($startcol + 9);

      $this->opt_value = $rs->getString($startcol + 10);

      $this->price_type = $rs->getString($startcol + 11);

      $this->depth = $rs->getInt($startcol + 12);

      $this->opt_version = $rs->getInt($startcol + 13);

      $this->color = $rs->getString($startcol + 14);

      $this->use_image_as_color = $rs->getBoolean($startcol + 15);

      $this->old_price = $rs->getString($startcol + 16);
      if (null !== $this->old_price && $this->old_price == intval($this->old_price))
      {
        $this->old_price = (string)intval($this->old_price);
      }

      $this->pum = $rs->getString($startcol + 17);
      if (null !== $this->pum && $this->pum == intval($this->pum))
      {
        $this->pum = (string)intval($this->pum);
      }

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('ProductOptionsDefaultValue.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsDefaultValue.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 18)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 18; // 18 = ProductOptionsDefaultValuePeer::NUM_COLUMNS - ProductOptionsDefaultValuePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating ProductOptionsDefaultValue object", $e);
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

    if ($this->getDispatcher()->getListeners('ProductOptionsDefaultValue.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsDefaultValue.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductOptionsDefaultValue:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseProductOptionsDefaultValue:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ProductOptionsDefaultValuePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ProductOptionsDefaultValuePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('ProductOptionsDefaultValue.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsDefaultValue.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductOptionsDefaultValue:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseProductOptionsDefaultValue:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('ProductOptionsDefaultValue.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsDefaultValue.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseProductOptionsDefaultValue:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(ProductOptionsDefaultValuePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ProductOptionsDefaultValuePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(ProductOptionsDefaultValuePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('ProductOptionsDefaultValue.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsDefaultValue.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseProductOptionsDefaultValue:save:post') as $callable)
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

			if ($this->aProductOptionsTemplate !== null) {
				if ($this->aProductOptionsTemplate->isModified() || $this->aProductOptionsTemplate->getCurrentProductOptionsTemplateI18n()->isModified()) {
					$affectedRows += $this->aProductOptionsTemplate->save($con);
				}
				$this->setProductOptionsTemplate($this->aProductOptionsTemplate);
			}

			if ($this->aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId !== null) {
				if ($this->aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId->isModified() || $this->aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId->getCurrentProductOptionsDefaultValueI18n()->isModified()) {
					$affectedRows += $this->aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId->save($con);
				}
				$this->setProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId($this->aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId);
			}

			if ($this->aProductOptionsField !== null) {
				if ($this->aProductOptionsField->isModified() || $this->aProductOptionsField->getCurrentProductOptionsFieldI18n()->isModified()) {
					$affectedRows += $this->aProductOptionsField->save($con);
				}
				$this->setProductOptionsField($this->aProductOptionsField);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ProductOptionsDefaultValuePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ProductOptionsDefaultValuePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId !== null) {
				foreach($this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductOptionsDefaultValueI18ns !== null) {
				foreach($this->collProductOptionsDefaultValueI18ns as $referrerFK) {
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

			if ($this->aProductOptionsTemplate !== null) {
				if (!$this->aProductOptionsTemplate->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProductOptionsTemplate->getValidationFailures());
				}
			}

			if ($this->aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId !== null) {
				if (!$this->aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId->getValidationFailures());
				}
			}

			if ($this->aProductOptionsField !== null) {
				if (!$this->aProductOptionsField->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProductOptionsField->getValidationFailures());
				}
			}


			if (($retval = ProductOptionsDefaultValuePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collProductOptionsDefaultValueI18ns !== null) {
					foreach($this->collProductOptionsDefaultValueI18ns as $referrerFK) {
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
		$pos = ProductOptionsDefaultValuePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getProductOptionsTemplateId();
				break;
			case 4:
				return $this->getProductOptionsDefaultValueId();
				break;
			case 5:
				return $this->getProductOptionsFieldId();
				break;
			case 6:
				return $this->getPrice();
				break;
			case 7:
				return $this->getWeight();
				break;
			case 8:
				return $this->getLft();
				break;
			case 9:
				return $this->getRgt();
				break;
			case 10:
				return $this->getOptValue();
				break;
			case 11:
				return $this->getPriceType();
				break;
			case 12:
				return $this->getDepth();
				break;
			case 13:
				return $this->getOptVersion();
				break;
			case 14:
				return $this->getColor();
				break;
			case 15:
				return $this->getUseImageAsColor();
				break;
			case 16:
				return $this->getOldPrice();
				break;
			case 17:
				return $this->getPum();
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
		$keys = ProductOptionsDefaultValuePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getProductOptionsTemplateId(),
			$keys[4] => $this->getProductOptionsDefaultValueId(),
			$keys[5] => $this->getProductOptionsFieldId(),
			$keys[6] => $this->getPrice(),
			$keys[7] => $this->getWeight(),
			$keys[8] => $this->getLft(),
			$keys[9] => $this->getRgt(),
			$keys[10] => $this->getOptValue(),
			$keys[11] => $this->getPriceType(),
			$keys[12] => $this->getDepth(),
			$keys[13] => $this->getOptVersion(),
			$keys[14] => $this->getColor(),
			$keys[15] => $this->getUseImageAsColor(),
			$keys[16] => $this->getOldPrice(),
			$keys[17] => $this->getPum(),
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
		$pos = ProductOptionsDefaultValuePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setProductOptionsTemplateId($value);
				break;
			case 4:
				$this->setProductOptionsDefaultValueId($value);
				break;
			case 5:
				$this->setProductOptionsFieldId($value);
				break;
			case 6:
				$this->setPrice($value);
				break;
			case 7:
				$this->setWeight($value);
				break;
			case 8:
				$this->setLft($value);
				break;
			case 9:
				$this->setRgt($value);
				break;
			case 10:
				$this->setOptValue($value);
				break;
			case 11:
				$this->setPriceType($value);
				break;
			case 12:
				$this->setDepth($value);
				break;
			case 13:
				$this->setOptVersion($value);
				break;
			case 14:
				$this->setColor($value);
				break;
			case 15:
				$this->setUseImageAsColor($value);
				break;
			case 16:
				$this->setOldPrice($value);
				break;
			case 17:
				$this->setPum($value);
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
		$keys = ProductOptionsDefaultValuePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setProductOptionsTemplateId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setProductOptionsDefaultValueId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setProductOptionsFieldId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setPrice($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setWeight($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setLft($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setRgt($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setOptValue($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setPriceType($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setDepth($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setOptVersion($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setColor($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setUseImageAsColor($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setOldPrice($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setPum($arr[$keys[17]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ProductOptionsDefaultValuePeer::DATABASE_NAME);

		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::CREATED_AT)) $criteria->add(ProductOptionsDefaultValuePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::UPDATED_AT)) $criteria->add(ProductOptionsDefaultValuePeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::ID)) $criteria->add(ProductOptionsDefaultValuePeer::ID, $this->id);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID)) $criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->product_options_template_id);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID)) $criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID, $this->product_options_default_value_id);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID)) $criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->product_options_field_id);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::PRICE)) $criteria->add(ProductOptionsDefaultValuePeer::PRICE, $this->price);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::WEIGHT)) $criteria->add(ProductOptionsDefaultValuePeer::WEIGHT, $this->weight);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::LFT)) $criteria->add(ProductOptionsDefaultValuePeer::LFT, $this->lft);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::RGT)) $criteria->add(ProductOptionsDefaultValuePeer::RGT, $this->rgt);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::OPT_VALUE)) $criteria->add(ProductOptionsDefaultValuePeer::OPT_VALUE, $this->opt_value);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::PRICE_TYPE)) $criteria->add(ProductOptionsDefaultValuePeer::PRICE_TYPE, $this->price_type);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::DEPTH)) $criteria->add(ProductOptionsDefaultValuePeer::DEPTH, $this->depth);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::OPT_VERSION)) $criteria->add(ProductOptionsDefaultValuePeer::OPT_VERSION, $this->opt_version);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::COLOR)) $criteria->add(ProductOptionsDefaultValuePeer::COLOR, $this->color);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::USE_IMAGE_AS_COLOR)) $criteria->add(ProductOptionsDefaultValuePeer::USE_IMAGE_AS_COLOR, $this->use_image_as_color);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::OLD_PRICE)) $criteria->add(ProductOptionsDefaultValuePeer::OLD_PRICE, $this->old_price);
		if ($this->isColumnModified(ProductOptionsDefaultValuePeer::PUM)) $criteria->add(ProductOptionsDefaultValuePeer::PUM, $this->pum);

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
		$criteria = new Criteria(ProductOptionsDefaultValuePeer::DATABASE_NAME);

		$criteria->add(ProductOptionsDefaultValuePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of ProductOptionsDefaultValue (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setProductOptionsTemplateId($this->product_options_template_id);

		$copyObj->setProductOptionsDefaultValueId($this->product_options_default_value_id);

		$copyObj->setProductOptionsFieldId($this->product_options_field_id);

		$copyObj->setPrice($this->price);

		$copyObj->setWeight($this->weight);

		$copyObj->setLft($this->lft);

		$copyObj->setRgt($this->rgt);

		$copyObj->setOptValue($this->opt_value);

		$copyObj->setPriceType($this->price_type);

		$copyObj->setDepth($this->depth);

		$copyObj->setOptVersion($this->opt_version);

		$copyObj->setColor($this->color);

		$copyObj->setUseImageAsColor($this->use_image_as_color);

		$copyObj->setOldPrice($this->old_price);

		$copyObj->setPum($this->pum);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId() as $relObj) {
				if($this->getPrimaryKey() === $relObj->getPrimaryKey()) {
						continue;
				}

				$copyObj->addProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId($relObj->copy($deepCopy));
			}

			foreach($this->getProductOptionsDefaultValueI18ns() as $relObj) {
				$copyObj->addProductOptionsDefaultValueI18n($relObj->copy($deepCopy));
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
	 * @return     ProductOptionsDefaultValue Clone of current object.
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
	 * @return     ProductOptionsDefaultValuePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ProductOptionsDefaultValuePeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a ProductOptionsTemplate object.
	 *
	 * @param      ProductOptionsTemplate $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setProductOptionsTemplate($v)
	{


		if ($v === null) {
			$this->setProductOptionsTemplateId(NULL);
		} else {
			$this->setProductOptionsTemplateId($v->getId());
		}


		$this->aProductOptionsTemplate = $v;
	}


	/**
	 * Get the associated ProductOptionsTemplate object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     ProductOptionsTemplate The associated ProductOptionsTemplate object.
	 * @throws     PropelException
	 */
	public function getProductOptionsTemplate($con = null)
	{
		if ($this->aProductOptionsTemplate === null && ($this->product_options_template_id !== null)) {
			// include the related Peer class
			$this->aProductOptionsTemplate = ProductOptionsTemplatePeer::retrieveByPK($this->product_options_template_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductOptionsTemplatePeer::retrieveByPK($this->product_options_template_id, $con);
			   $obj->addProductOptionsTemplates($this);
			 */
		}
		return $this->aProductOptionsTemplate;
	}

	/**
	 * Declares an association between this object and a ProductOptionsDefaultValue object.
	 *
	 * @param      ProductOptionsDefaultValue $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId($v)
	{


		if ($v === null) {
			$this->setProductOptionsDefaultValueId(NULL);
		} else {
			$this->setProductOptionsDefaultValueId($v->getId());
		}


		$this->aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId = $v;
	}


	/**
	 * Get the associated ProductOptionsDefaultValue object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     ProductOptionsDefaultValue The associated ProductOptionsDefaultValue object.
	 * @throws     PropelException
	 */
	public function getProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId($con = null)
	{
		if ($this->aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId === null && ($this->product_options_default_value_id !== null)) {
			// include the related Peer class
			$this->aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId = ProductOptionsDefaultValuePeer::retrieveByPK($this->product_options_default_value_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductOptionsDefaultValuePeer::retrieveByPK($this->product_options_default_value_id, $con);
			   $obj->addProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId($this);
			 */
		}
		return $this->aProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId;
	}

	/**
	 * Declares an association between this object and a ProductOptionsField object.
	 *
	 * @param      ProductOptionsField $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setProductOptionsField($v)
	{


		if ($v === null) {
			$this->setProductOptionsFieldId(NULL);
		} else {
			$this->setProductOptionsFieldId($v->getId());
		}


		$this->aProductOptionsField = $v;
	}


	/**
	 * Get the associated ProductOptionsField object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     ProductOptionsField The associated ProductOptionsField object.
	 * @throws     PropelException
	 */
	public function getProductOptionsField($con = null)
	{
		if ($this->aProductOptionsField === null && ($this->product_options_field_id !== null)) {
			// include the related Peer class
			$this->aProductOptionsField = ProductOptionsFieldPeer::retrieveByPK($this->product_options_field_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductOptionsFieldPeer::retrieveByPK($this->product_options_field_id, $con);
			   $obj->addProductOptionsFields($this);
			 */
		}
		return $this->aProductOptionsField;
	}

	/**
	 * Temporary storage of collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId()
	{
		if ($this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId === null) {
			$this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsDefaultValue has previously
	 * been saved, it will retrieve related ProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId from storage.
	 * If this ProductOptionsDefaultValue is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId === null) {
			if ($this->isNew()) {
			   $this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId = array();
			} else {

				$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID, $this->getId());

				ProductOptionsDefaultValuePeer::addSelectColumns($criteria);
				$this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId = ProductOptionsDefaultValuePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID, $this->getId());

				ProductOptionsDefaultValuePeer::addSelectColumns($criteria);
				if (!isset($this->lastProductOptionsDefaultValueRelatedByProductOptionsDefaultValueIdCriteria) || !$this->lastProductOptionsDefaultValueRelatedByProductOptionsDefaultValueIdCriteria->equals($criteria)) {
					$this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId = ProductOptionsDefaultValuePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductOptionsDefaultValueRelatedByProductOptionsDefaultValueIdCriteria = $criteria;
		return $this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId;
	}

	/**
	 * Returns the number of related ProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID, $this->getId());

		return ProductOptionsDefaultValuePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductOptionsDefaultValue object to this object
	 * through the ProductOptionsDefaultValue foreign key attribute
	 *
	 * @param      ProductOptionsDefaultValue $l ProductOptionsDefaultValue
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId(ProductOptionsDefaultValue $l)
	{
		$this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId[] = $l;
		$l->setProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsDefaultValue is new, it will return
	 * an empty collection; or if this ProductOptionsDefaultValue has previously
	 * been saved, it will retrieve related ProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsDefaultValue.
	 */
	public function getProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueIdJoinProductOptionsTemplate($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId === null) {
			if ($this->isNew()) {
				$this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId = array();
			} else {

				$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID, $this->getId());

				$this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId = ProductOptionsDefaultValuePeer::doSelectJoinProductOptionsTemplate($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID, $this->getId());

			if (!isset($this->lastProductOptionsDefaultValueRelatedByProductOptionsDefaultValueIdCriteria) || !$this->lastProductOptionsDefaultValueRelatedByProductOptionsDefaultValueIdCriteria->equals($criteria)) {
				$this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId = ProductOptionsDefaultValuePeer::doSelectJoinProductOptionsTemplate($criteria, $con);
			}
		}
		$this->lastProductOptionsDefaultValueRelatedByProductOptionsDefaultValueIdCriteria = $criteria;

		return $this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsDefaultValue is new, it will return
	 * an empty collection; or if this ProductOptionsDefaultValue has previously
	 * been saved, it will retrieve related ProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsDefaultValue.
	 */
	public function getProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueIdJoinProductOptionsField($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId === null) {
			if ($this->isNew()) {
				$this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId = array();
			} else {

				$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID, $this->getId());

				$this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId = ProductOptionsDefaultValuePeer::doSelectJoinProductOptionsField($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID, $this->getId());

			if (!isset($this->lastProductOptionsDefaultValueRelatedByProductOptionsDefaultValueIdCriteria) || !$this->lastProductOptionsDefaultValueRelatedByProductOptionsDefaultValueIdCriteria->equals($criteria)) {
				$this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId = ProductOptionsDefaultValuePeer::doSelectJoinProductOptionsField($criteria, $con);
			}
		}
		$this->lastProductOptionsDefaultValueRelatedByProductOptionsDefaultValueIdCriteria = $criteria;

		return $this->collProductOptionsDefaultValuesRelatedByProductOptionsDefaultValueId;
	}

	/**
	 * Temporary storage of collProductOptionsDefaultValueI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductOptionsDefaultValueI18ns()
	{
		if ($this->collProductOptionsDefaultValueI18ns === null) {
			$this->collProductOptionsDefaultValueI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsDefaultValue has previously
	 * been saved, it will retrieve related ProductOptionsDefaultValueI18ns from storage.
	 * If this ProductOptionsDefaultValue is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductOptionsDefaultValueI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsDefaultValueI18ns === null) {
			if ($this->isNew()) {
			   $this->collProductOptionsDefaultValueI18ns = array();
			} else {

				$criteria->add(ProductOptionsDefaultValueI18nPeer::ID, $this->getId());

				ProductOptionsDefaultValueI18nPeer::addSelectColumns($criteria);
				$this->collProductOptionsDefaultValueI18ns = ProductOptionsDefaultValueI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductOptionsDefaultValueI18nPeer::ID, $this->getId());

				ProductOptionsDefaultValueI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductOptionsDefaultValueI18nCriteria) || !$this->lastProductOptionsDefaultValueI18nCriteria->equals($criteria)) {
					$this->collProductOptionsDefaultValueI18ns = ProductOptionsDefaultValueI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductOptionsDefaultValueI18nCriteria = $criteria;
		return $this->collProductOptionsDefaultValueI18ns;
	}

	/**
	 * Returns the number of related ProductOptionsDefaultValueI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductOptionsDefaultValueI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductOptionsDefaultValueI18nPeer::ID, $this->getId());

		return ProductOptionsDefaultValueI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductOptionsDefaultValueI18n object to this object
	 * through the ProductOptionsDefaultValueI18n foreign key attribute
	 *
	 * @param      ProductOptionsDefaultValueI18n $l ProductOptionsDefaultValueI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductOptionsDefaultValueI18n(ProductOptionsDefaultValueI18n $l)
	{
		$this->collProductOptionsDefaultValueI18ns[] = $l;
		$l->setProductOptionsDefaultValue($this);
	}

  public function getCulture()
  {
    return $this->culture;
  }

  public function setCulture($culture)
  {
    $this->culture = $culture;
  }

  public function getValue()
  {
    $obj = $this->getCurrentProductOptionsDefaultValueI18n();

    return ($obj ? $obj->getValue() : null);
  }

  public function setValue($value)
  {
    $this->getCurrentProductOptionsDefaultValueI18n()->setValue($value);
  }

  public $current_i18n = array();

  public function getCurrentProductOptionsDefaultValueI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = ProductOptionsDefaultValueI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setProductOptionsDefaultValueI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setProductOptionsDefaultValueI18nForCulture(new ProductOptionsDefaultValueI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setProductOptionsDefaultValueI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addProductOptionsDefaultValueI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'ProductOptionsDefaultValue.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseProductOptionsDefaultValue:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseProductOptionsDefaultValue::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseProductOptionsDefaultValue
