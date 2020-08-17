<?php

/**
 * Base class that represents a row from the 'st_product_options_value' table.
 *
 * 
 *
 * @package    plugins.stProductOptionsPlugin.lib.model.om
 */
abstract class BaseProductOptionsValue extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ProductOptionsValuePeer
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
	 * The value for the sf_asset_id field.
	 * @var        int
	 */
	protected $sf_asset_id;


	/**
	 * The value for the product_id field.
	 * @var        int
	 */
	protected $product_id;


	/**
	 * The value for the product_options_template_id field.
	 * @var        int
	 */
	protected $product_options_template_id;


	/**
	 * The value for the product_options_value_id field.
	 * @var        int
	 */
	protected $product_options_value_id;


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
	 * The value for the stock field.
	 * @var        double
	 */
	protected $stock;


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
	 * The value for the opt_filter_id field.
	 * @var        int
	 */
	protected $opt_filter_id;


	/**
	 * The value for the use_product field.
	 * @var        string
	 */
	protected $use_product;


	/**
	 * The value for the old_price field.
	 * @var        double
	 */
	protected $old_price;


	/**
	 * The value for the man_code field.
	 * @var        string
	 */
	protected $man_code;


	/**
	 * The value for the pum field.
	 * @var        double
	 */
	protected $pum;


	/**
	 * The value for the is_updated field.
	 * @var        boolean
	 */
	protected $is_updated = false;

	/**
	 * @var        sfAsset
	 */
	protected $asfAsset;

	/**
	 * @var        Product
	 */
	protected $aProduct;

	/**
	 * @var        ProductOptionsTemplate
	 */
	protected $aProductOptionsTemplate;

	/**
	 * @var        ProductOptionsValue
	 */
	protected $aProductOptionsValueRelatedByProductOptionsValueId;

	/**
	 * @var        ProductOptionsField
	 */
	protected $aProductOptionsField;

	/**
	 * Collection to store aggregation of collProductOptionsValuesRelatedByProductOptionsValueId.
	 * @var        array
	 */
	protected $collProductOptionsValuesRelatedByProductOptionsValueId;

	/**
	 * The criteria used to select the current contents of collProductOptionsValuesRelatedByProductOptionsValueId.
	 * @var        Criteria
	 */
	protected $lastProductOptionsValueRelatedByProductOptionsValueIdCriteria = null;

	/**
	 * Collection to store aggregation of collProductOptionsValueI18ns.
	 * @var        array
	 */
	protected $collProductOptionsValueI18ns;

	/**
	 * The criteria used to select the current contents of collProductOptionsValueI18ns.
	 * @var        Criteria
	 */
	protected $lastProductOptionsValueI18nCriteria = null;

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
     * Get the [sf_asset_id] column value.
     * 
     * @return     int
     */
    public function getSfAssetId()
    {

            return $this->sf_asset_id;
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
     * Get the [product_options_template_id] column value.
     * 
     * @return     int
     */
    public function getProductOptionsTemplateId()
    {

            return $this->product_options_template_id;
    }

    /**
     * Get the [product_options_value_id] column value.
     * 
     * @return     int
     */
    public function getProductOptionsValueId()
    {

            return $this->product_options_value_id;
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
     * Get the [stock] column value.
     * 
     * @return     double
     */
    public function getStock()
    {

            return null !== $this->stock ? (string)$this->stock : null;
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
     * Get the [opt_filter_id] column value.
     * 
     * @return     int
     */
    public function getOptFilterId()
    {

            return $this->opt_filter_id;
    }

    /**
     * Get the [use_product] column value.
     * 
     * @return     string
     */
    public function getUseProduct()
    {

            return $this->use_product;
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
     * Get the [man_code] column value.
     * 
     * @return     string
     */
    public function getManCode()
    {

            return $this->man_code;
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
     * Get the [is_updated] column value.
     * 
     * @return     boolean
     */
    public function getIsUpdated()
    {

            return $this->is_updated;
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
			$this->modifiedColumns[] = ProductOptionsValuePeer::CREATED_AT;
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
			$this->modifiedColumns[] = ProductOptionsValuePeer::UPDATED_AT;
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
          $this->modifiedColumns[] = ProductOptionsValuePeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [sf_asset_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setSfAssetId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->sf_asset_id !== $v) {
          $this->sf_asset_id = $v;
          $this->modifiedColumns[] = ProductOptionsValuePeer::SF_ASSET_ID;
        }

		if ($this->asfAsset !== null && $this->asfAsset->getId() !== $v) {
			$this->asfAsset = null;
		}

	} // setSfAssetId()

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
          $this->modifiedColumns[] = ProductOptionsValuePeer::PRODUCT_ID;
        }

		if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
			$this->aProduct = null;
		}

	} // setProductId()

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
          $this->modifiedColumns[] = ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID;
        }

		if ($this->aProductOptionsTemplate !== null && $this->aProductOptionsTemplate->getId() !== $v) {
			$this->aProductOptionsTemplate = null;
		}

	} // setProductOptionsTemplateId()

	/**
	 * Set the value of [product_options_value_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setProductOptionsValueId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->product_options_value_id !== $v) {
          $this->product_options_value_id = $v;
          $this->modifiedColumns[] = ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID;
        }

		if ($this->aProductOptionsValueRelatedByProductOptionsValueId !== null && $this->aProductOptionsValueRelatedByProductOptionsValueId->getId() !== $v) {
			$this->aProductOptionsValueRelatedByProductOptionsValueId = null;
		}

	} // setProductOptionsValueId()

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
          $this->modifiedColumns[] = ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID;
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
          $this->modifiedColumns[] = ProductOptionsValuePeer::PRICE;
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
          $this->modifiedColumns[] = ProductOptionsValuePeer::WEIGHT;
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
          $this->modifiedColumns[] = ProductOptionsValuePeer::LFT;
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
          $this->modifiedColumns[] = ProductOptionsValuePeer::RGT;
        }

	} // setRgt()

	/**
	 * Set the value of [stock] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setStock($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->stock !== $v) {
          $this->stock = $v;
          $this->modifiedColumns[] = ProductOptionsValuePeer::STOCK;
        }

	} // setStock()

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
          $this->modifiedColumns[] = ProductOptionsValuePeer::OPT_VALUE;
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
          $this->modifiedColumns[] = ProductOptionsValuePeer::PRICE_TYPE;
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
          $this->modifiedColumns[] = ProductOptionsValuePeer::DEPTH;
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
          $this->modifiedColumns[] = ProductOptionsValuePeer::OPT_VERSION;
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
          $this->modifiedColumns[] = ProductOptionsValuePeer::COLOR;
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
          $this->modifiedColumns[] = ProductOptionsValuePeer::USE_IMAGE_AS_COLOR;
        }

	} // setUseImageAsColor()

	/**
	 * Set the value of [opt_filter_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOptFilterId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->opt_filter_id !== $v) {
          $this->opt_filter_id = $v;
          $this->modifiedColumns[] = ProductOptionsValuePeer::OPT_FILTER_ID;
        }

	} // setOptFilterId()

	/**
	 * Set the value of [use_product] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUseProduct($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->use_product !== $v) {
          $this->use_product = $v;
          $this->modifiedColumns[] = ProductOptionsValuePeer::USE_PRODUCT;
        }

	} // setUseProduct()

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
          $this->modifiedColumns[] = ProductOptionsValuePeer::OLD_PRICE;
        }

	} // setOldPrice()

	/**
	 * Set the value of [man_code] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setManCode($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->man_code !== $v) {
          $this->man_code = $v;
          $this->modifiedColumns[] = ProductOptionsValuePeer::MAN_CODE;
        }

	} // setManCode()

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
          $this->modifiedColumns[] = ProductOptionsValuePeer::PUM;
        }

	} // setPum()

	/**
	 * Set the value of [is_updated] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsUpdated($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_updated !== $v || $v === false) {
          $this->is_updated = $v;
          $this->modifiedColumns[] = ProductOptionsValuePeer::IS_UPDATED;
        }

	} // setIsUpdated()

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
      if ($this->getDispatcher()->getListeners('ProductOptionsValue.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsValue.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->sf_asset_id = $rs->getInt($startcol + 3);

      $this->product_id = $rs->getInt($startcol + 4);

      $this->product_options_template_id = $rs->getInt($startcol + 5);

      $this->product_options_value_id = $rs->getInt($startcol + 6);

      $this->product_options_field_id = $rs->getInt($startcol + 7);

      $this->price = $rs->getString($startcol + 8);

      $this->weight = $rs->getString($startcol + 9);

      $this->lft = $rs->getInt($startcol + 10);

      $this->rgt = $rs->getInt($startcol + 11);

      $this->stock = $rs->getString($startcol + 12);
      if (null !== $this->stock && $this->stock == intval($this->stock))
      {
        $this->stock = (string)intval($this->stock);
      }

      $this->opt_value = $rs->getString($startcol + 13);

      $this->price_type = $rs->getString($startcol + 14);

      $this->depth = $rs->getInt($startcol + 15);

      $this->opt_version = $rs->getInt($startcol + 16);

      $this->color = $rs->getString($startcol + 17);

      $this->use_image_as_color = $rs->getBoolean($startcol + 18);

      $this->opt_filter_id = $rs->getInt($startcol + 19);

      $this->use_product = $rs->getString($startcol + 20);

      $this->old_price = $rs->getString($startcol + 21);
      if (null !== $this->old_price && $this->old_price == intval($this->old_price))
      {
        $this->old_price = (string)intval($this->old_price);
      }

      $this->man_code = $rs->getString($startcol + 22);

      $this->pum = $rs->getString($startcol + 23);
      if (null !== $this->pum && $this->pum == intval($this->pum))
      {
        $this->pum = (string)intval($this->pum);
      }

      $this->is_updated = $rs->getBoolean($startcol + 24);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('ProductOptionsValue.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsValue.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 25)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 25; // 25 = ProductOptionsValuePeer::NUM_COLUMNS - ProductOptionsValuePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating ProductOptionsValue object", $e);
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

    if ($this->getDispatcher()->getListeners('ProductOptionsValue.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsValue.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductOptionsValue:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseProductOptionsValue:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ProductOptionsValuePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ProductOptionsValuePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('ProductOptionsValue.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsValue.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductOptionsValue:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseProductOptionsValue:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('ProductOptionsValue.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsValue.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseProductOptionsValue:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(ProductOptionsValuePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ProductOptionsValuePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(ProductOptionsValuePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('ProductOptionsValue.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsValue.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseProductOptionsValue:save:post') as $callable)
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

			if ($this->asfAsset !== null) {
				if ($this->asfAsset->isModified() || $this->asfAsset->getCurrentsfAssetI18n()->isModified()) {
					$affectedRows += $this->asfAsset->save($con);
				}
				$this->setsfAsset($this->asfAsset);
			}

			if ($this->aProduct !== null) {
				if ($this->aProduct->isModified() || $this->aProduct->getCurrentProductI18n()->isModified()) {
					$affectedRows += $this->aProduct->save($con);
				}
				$this->setProduct($this->aProduct);
			}

			if ($this->aProductOptionsTemplate !== null) {
				if ($this->aProductOptionsTemplate->isModified() || $this->aProductOptionsTemplate->getCurrentProductOptionsTemplateI18n()->isModified()) {
					$affectedRows += $this->aProductOptionsTemplate->save($con);
				}
				$this->setProductOptionsTemplate($this->aProductOptionsTemplate);
			}

			if ($this->aProductOptionsValueRelatedByProductOptionsValueId !== null) {
				if ($this->aProductOptionsValueRelatedByProductOptionsValueId->isModified() || $this->aProductOptionsValueRelatedByProductOptionsValueId->getCurrentProductOptionsValueI18n()->isModified()) {
					$affectedRows += $this->aProductOptionsValueRelatedByProductOptionsValueId->save($con);
				}
				$this->setProductOptionsValueRelatedByProductOptionsValueId($this->aProductOptionsValueRelatedByProductOptionsValueId);
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
					$pk = ProductOptionsValuePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ProductOptionsValuePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collProductOptionsValuesRelatedByProductOptionsValueId !== null) {
				foreach($this->collProductOptionsValuesRelatedByProductOptionsValueId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductOptionsValueI18ns !== null) {
				foreach($this->collProductOptionsValueI18ns as $referrerFK) {
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

			if ($this->asfAsset !== null) {
				if (!$this->asfAsset->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfAsset->getValidationFailures());
				}
			}

			if ($this->aProduct !== null) {
				if (!$this->aProduct->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProduct->getValidationFailures());
				}
			}

			if ($this->aProductOptionsTemplate !== null) {
				if (!$this->aProductOptionsTemplate->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProductOptionsTemplate->getValidationFailures());
				}
			}

			if ($this->aProductOptionsValueRelatedByProductOptionsValueId !== null) {
				if (!$this->aProductOptionsValueRelatedByProductOptionsValueId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProductOptionsValueRelatedByProductOptionsValueId->getValidationFailures());
				}
			}

			if ($this->aProductOptionsField !== null) {
				if (!$this->aProductOptionsField->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProductOptionsField->getValidationFailures());
				}
			}


			if (($retval = ProductOptionsValuePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collProductOptionsValueI18ns !== null) {
					foreach($this->collProductOptionsValueI18ns as $referrerFK) {
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
		$pos = ProductOptionsValuePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getSfAssetId();
				break;
			case 4:
				return $this->getProductId();
				break;
			case 5:
				return $this->getProductOptionsTemplateId();
				break;
			case 6:
				return $this->getProductOptionsValueId();
				break;
			case 7:
				return $this->getProductOptionsFieldId();
				break;
			case 8:
				return $this->getPrice();
				break;
			case 9:
				return $this->getWeight();
				break;
			case 10:
				return $this->getLft();
				break;
			case 11:
				return $this->getRgt();
				break;
			case 12:
				return $this->getStock();
				break;
			case 13:
				return $this->getOptValue();
				break;
			case 14:
				return $this->getPriceType();
				break;
			case 15:
				return $this->getDepth();
				break;
			case 16:
				return $this->getOptVersion();
				break;
			case 17:
				return $this->getColor();
				break;
			case 18:
				return $this->getUseImageAsColor();
				break;
			case 19:
				return $this->getOptFilterId();
				break;
			case 20:
				return $this->getUseProduct();
				break;
			case 21:
				return $this->getOldPrice();
				break;
			case 22:
				return $this->getManCode();
				break;
			case 23:
				return $this->getPum();
				break;
			case 24:
				return $this->getIsUpdated();
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
		$keys = ProductOptionsValuePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getSfAssetId(),
			$keys[4] => $this->getProductId(),
			$keys[5] => $this->getProductOptionsTemplateId(),
			$keys[6] => $this->getProductOptionsValueId(),
			$keys[7] => $this->getProductOptionsFieldId(),
			$keys[8] => $this->getPrice(),
			$keys[9] => $this->getWeight(),
			$keys[10] => $this->getLft(),
			$keys[11] => $this->getRgt(),
			$keys[12] => $this->getStock(),
			$keys[13] => $this->getOptValue(),
			$keys[14] => $this->getPriceType(),
			$keys[15] => $this->getDepth(),
			$keys[16] => $this->getOptVersion(),
			$keys[17] => $this->getColor(),
			$keys[18] => $this->getUseImageAsColor(),
			$keys[19] => $this->getOptFilterId(),
			$keys[20] => $this->getUseProduct(),
			$keys[21] => $this->getOldPrice(),
			$keys[22] => $this->getManCode(),
			$keys[23] => $this->getPum(),
			$keys[24] => $this->getIsUpdated(),
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
		$pos = ProductOptionsValuePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setSfAssetId($value);
				break;
			case 4:
				$this->setProductId($value);
				break;
			case 5:
				$this->setProductOptionsTemplateId($value);
				break;
			case 6:
				$this->setProductOptionsValueId($value);
				break;
			case 7:
				$this->setProductOptionsFieldId($value);
				break;
			case 8:
				$this->setPrice($value);
				break;
			case 9:
				$this->setWeight($value);
				break;
			case 10:
				$this->setLft($value);
				break;
			case 11:
				$this->setRgt($value);
				break;
			case 12:
				$this->setStock($value);
				break;
			case 13:
				$this->setOptValue($value);
				break;
			case 14:
				$this->setPriceType($value);
				break;
			case 15:
				$this->setDepth($value);
				break;
			case 16:
				$this->setOptVersion($value);
				break;
			case 17:
				$this->setColor($value);
				break;
			case 18:
				$this->setUseImageAsColor($value);
				break;
			case 19:
				$this->setOptFilterId($value);
				break;
			case 20:
				$this->setUseProduct($value);
				break;
			case 21:
				$this->setOldPrice($value);
				break;
			case 22:
				$this->setManCode($value);
				break;
			case 23:
				$this->setPum($value);
				break;
			case 24:
				$this->setIsUpdated($value);
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
		$keys = ProductOptionsValuePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSfAssetId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setProductId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setProductOptionsTemplateId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setProductOptionsValueId($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setProductOptionsFieldId($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setPrice($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setWeight($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setLft($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setRgt($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setStock($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setOptValue($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setPriceType($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setDepth($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setOptVersion($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setColor($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setUseImageAsColor($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setOptFilterId($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setUseProduct($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setOldPrice($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setManCode($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setPum($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setIsUpdated($arr[$keys[24]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ProductOptionsValuePeer::DATABASE_NAME);

		if ($this->isColumnModified(ProductOptionsValuePeer::CREATED_AT)) $criteria->add(ProductOptionsValuePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ProductOptionsValuePeer::UPDATED_AT)) $criteria->add(ProductOptionsValuePeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(ProductOptionsValuePeer::ID)) $criteria->add(ProductOptionsValuePeer::ID, $this->id);
		if ($this->isColumnModified(ProductOptionsValuePeer::SF_ASSET_ID)) $criteria->add(ProductOptionsValuePeer::SF_ASSET_ID, $this->sf_asset_id);
		if ($this->isColumnModified(ProductOptionsValuePeer::PRODUCT_ID)) $criteria->add(ProductOptionsValuePeer::PRODUCT_ID, $this->product_id);
		if ($this->isColumnModified(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID)) $criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->product_options_template_id);
		if ($this->isColumnModified(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID)) $criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, $this->product_options_value_id);
		if ($this->isColumnModified(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID)) $criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->product_options_field_id);
		if ($this->isColumnModified(ProductOptionsValuePeer::PRICE)) $criteria->add(ProductOptionsValuePeer::PRICE, $this->price);
		if ($this->isColumnModified(ProductOptionsValuePeer::WEIGHT)) $criteria->add(ProductOptionsValuePeer::WEIGHT, $this->weight);
		if ($this->isColumnModified(ProductOptionsValuePeer::LFT)) $criteria->add(ProductOptionsValuePeer::LFT, $this->lft);
		if ($this->isColumnModified(ProductOptionsValuePeer::RGT)) $criteria->add(ProductOptionsValuePeer::RGT, $this->rgt);
		if ($this->isColumnModified(ProductOptionsValuePeer::STOCK)) $criteria->add(ProductOptionsValuePeer::STOCK, $this->stock);
		if ($this->isColumnModified(ProductOptionsValuePeer::OPT_VALUE)) $criteria->add(ProductOptionsValuePeer::OPT_VALUE, $this->opt_value);
		if ($this->isColumnModified(ProductOptionsValuePeer::PRICE_TYPE)) $criteria->add(ProductOptionsValuePeer::PRICE_TYPE, $this->price_type);
		if ($this->isColumnModified(ProductOptionsValuePeer::DEPTH)) $criteria->add(ProductOptionsValuePeer::DEPTH, $this->depth);
		if ($this->isColumnModified(ProductOptionsValuePeer::OPT_VERSION)) $criteria->add(ProductOptionsValuePeer::OPT_VERSION, $this->opt_version);
		if ($this->isColumnModified(ProductOptionsValuePeer::COLOR)) $criteria->add(ProductOptionsValuePeer::COLOR, $this->color);
		if ($this->isColumnModified(ProductOptionsValuePeer::USE_IMAGE_AS_COLOR)) $criteria->add(ProductOptionsValuePeer::USE_IMAGE_AS_COLOR, $this->use_image_as_color);
		if ($this->isColumnModified(ProductOptionsValuePeer::OPT_FILTER_ID)) $criteria->add(ProductOptionsValuePeer::OPT_FILTER_ID, $this->opt_filter_id);
		if ($this->isColumnModified(ProductOptionsValuePeer::USE_PRODUCT)) $criteria->add(ProductOptionsValuePeer::USE_PRODUCT, $this->use_product);
		if ($this->isColumnModified(ProductOptionsValuePeer::OLD_PRICE)) $criteria->add(ProductOptionsValuePeer::OLD_PRICE, $this->old_price);
		if ($this->isColumnModified(ProductOptionsValuePeer::MAN_CODE)) $criteria->add(ProductOptionsValuePeer::MAN_CODE, $this->man_code);
		if ($this->isColumnModified(ProductOptionsValuePeer::PUM)) $criteria->add(ProductOptionsValuePeer::PUM, $this->pum);
		if ($this->isColumnModified(ProductOptionsValuePeer::IS_UPDATED)) $criteria->add(ProductOptionsValuePeer::IS_UPDATED, $this->is_updated);

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
		$criteria = new Criteria(ProductOptionsValuePeer::DATABASE_NAME);

		$criteria->add(ProductOptionsValuePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of ProductOptionsValue (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setSfAssetId($this->sf_asset_id);

		$copyObj->setProductId($this->product_id);

		$copyObj->setProductOptionsTemplateId($this->product_options_template_id);

		$copyObj->setProductOptionsValueId($this->product_options_value_id);

		$copyObj->setProductOptionsFieldId($this->product_options_field_id);

		$copyObj->setPrice($this->price);

		$copyObj->setWeight($this->weight);

		$copyObj->setLft($this->lft);

		$copyObj->setRgt($this->rgt);

		$copyObj->setStock($this->stock);

		$copyObj->setOptValue($this->opt_value);

		$copyObj->setPriceType($this->price_type);

		$copyObj->setDepth($this->depth);

		$copyObj->setOptVersion($this->opt_version);

		$copyObj->setColor($this->color);

		$copyObj->setUseImageAsColor($this->use_image_as_color);

		$copyObj->setOptFilterId($this->opt_filter_id);

		$copyObj->setUseProduct($this->use_product);

		$copyObj->setOldPrice($this->old_price);

		$copyObj->setManCode($this->man_code);

		$copyObj->setPum($this->pum);

		$copyObj->setIsUpdated($this->is_updated);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getProductOptionsValuesRelatedByProductOptionsValueId() as $relObj) {
				if($this->getPrimaryKey() === $relObj->getPrimaryKey()) {
						continue;
				}

				$copyObj->addProductOptionsValueRelatedByProductOptionsValueId($relObj->copy($deepCopy));
			}

			foreach($this->getProductOptionsValueI18ns() as $relObj) {
				$copyObj->addProductOptionsValueI18n($relObj->copy($deepCopy));
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
	 * @return     ProductOptionsValue Clone of current object.
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
	 * @return     ProductOptionsValuePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ProductOptionsValuePeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a sfAsset object.
	 *
	 * @param      sfAsset $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setsfAsset($v)
	{


		if ($v === null) {
			$this->setSfAssetId(NULL);
		} else {
			$this->setSfAssetId($v->getId());
		}


		$this->asfAsset = $v;
	}


	/**
	 * Get the associated sfAsset object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     sfAsset The associated sfAsset object.
	 * @throws     PropelException
	 */
	public function getsfAsset($con = null)
	{
		if ($this->asfAsset === null && ($this->sf_asset_id !== null)) {
			// include the related Peer class
			$this->asfAsset = sfAssetPeer::retrieveByPK($this->sf_asset_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = sfAssetPeer::retrieveByPK($this->sf_asset_id, $con);
			   $obj->addsfAssets($this);
			 */
		}
		return $this->asfAsset;
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
	 * Declares an association between this object and a ProductOptionsValue object.
	 *
	 * @param      ProductOptionsValue $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setProductOptionsValueRelatedByProductOptionsValueId($v)
	{


		if ($v === null) {
			$this->setProductOptionsValueId(NULL);
		} else {
			$this->setProductOptionsValueId($v->getId());
		}


		$this->aProductOptionsValueRelatedByProductOptionsValueId = $v;
	}


	/**
	 * Get the associated ProductOptionsValue object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     ProductOptionsValue The associated ProductOptionsValue object.
	 * @throws     PropelException
	 */
	public function getProductOptionsValueRelatedByProductOptionsValueId($con = null)
	{
		if ($this->aProductOptionsValueRelatedByProductOptionsValueId === null && ($this->product_options_value_id !== null)) {
			// include the related Peer class
			$this->aProductOptionsValueRelatedByProductOptionsValueId = ProductOptionsValuePeer::retrieveByPK($this->product_options_value_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductOptionsValuePeer::retrieveByPK($this->product_options_value_id, $con);
			   $obj->addProductOptionsValuesRelatedByProductOptionsValueId($this);
			 */
		}
		return $this->aProductOptionsValueRelatedByProductOptionsValueId;
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
	 * Temporary storage of collProductOptionsValuesRelatedByProductOptionsValueId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductOptionsValuesRelatedByProductOptionsValueId()
	{
		if ($this->collProductOptionsValuesRelatedByProductOptionsValueId === null) {
			$this->collProductOptionsValuesRelatedByProductOptionsValueId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsValue has previously
	 * been saved, it will retrieve related ProductOptionsValuesRelatedByProductOptionsValueId from storage.
	 * If this ProductOptionsValue is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductOptionsValuesRelatedByProductOptionsValueId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValuesRelatedByProductOptionsValueId === null) {
			if ($this->isNew()) {
			   $this->collProductOptionsValuesRelatedByProductOptionsValueId = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, $this->getId());

				ProductOptionsValuePeer::addSelectColumns($criteria);
				$this->collProductOptionsValuesRelatedByProductOptionsValueId = ProductOptionsValuePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, $this->getId());

				ProductOptionsValuePeer::addSelectColumns($criteria);
				if (!isset($this->lastProductOptionsValueRelatedByProductOptionsValueIdCriteria) || !$this->lastProductOptionsValueRelatedByProductOptionsValueIdCriteria->equals($criteria)) {
					$this->collProductOptionsValuesRelatedByProductOptionsValueId = ProductOptionsValuePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductOptionsValueRelatedByProductOptionsValueIdCriteria = $criteria;
		return $this->collProductOptionsValuesRelatedByProductOptionsValueId;
	}

	/**
	 * Returns the number of related ProductOptionsValuesRelatedByProductOptionsValueId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductOptionsValuesRelatedByProductOptionsValueId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, $this->getId());

		return ProductOptionsValuePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductOptionsValue object to this object
	 * through the ProductOptionsValue foreign key attribute
	 *
	 * @param      ProductOptionsValue $l ProductOptionsValue
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductOptionsValueRelatedByProductOptionsValueId(ProductOptionsValue $l)
	{
		$this->collProductOptionsValuesRelatedByProductOptionsValueId[] = $l;
		$l->setProductOptionsValueRelatedByProductOptionsValueId($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsValue is new, it will return
	 * an empty collection; or if this ProductOptionsValue has previously
	 * been saved, it will retrieve related ProductOptionsValuesRelatedByProductOptionsValueId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsValue.
	 */
	public function getProductOptionsValuesRelatedByProductOptionsValueIdJoinsfAsset($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValuesRelatedByProductOptionsValueId === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValuesRelatedByProductOptionsValueId = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, $this->getId());

				$this->collProductOptionsValuesRelatedByProductOptionsValueId = ProductOptionsValuePeer::doSelectJoinsfAsset($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueRelatedByProductOptionsValueIdCriteria) || !$this->lastProductOptionsValueRelatedByProductOptionsValueIdCriteria->equals($criteria)) {
				$this->collProductOptionsValuesRelatedByProductOptionsValueId = ProductOptionsValuePeer::doSelectJoinsfAsset($criteria, $con);
			}
		}
		$this->lastProductOptionsValueRelatedByProductOptionsValueIdCriteria = $criteria;

		return $this->collProductOptionsValuesRelatedByProductOptionsValueId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsValue is new, it will return
	 * an empty collection; or if this ProductOptionsValue has previously
	 * been saved, it will retrieve related ProductOptionsValuesRelatedByProductOptionsValueId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsValue.
	 */
	public function getProductOptionsValuesRelatedByProductOptionsValueIdJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValuesRelatedByProductOptionsValueId === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValuesRelatedByProductOptionsValueId = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, $this->getId());

				$this->collProductOptionsValuesRelatedByProductOptionsValueId = ProductOptionsValuePeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueRelatedByProductOptionsValueIdCriteria) || !$this->lastProductOptionsValueRelatedByProductOptionsValueIdCriteria->equals($criteria)) {
				$this->collProductOptionsValuesRelatedByProductOptionsValueId = ProductOptionsValuePeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastProductOptionsValueRelatedByProductOptionsValueIdCriteria = $criteria;

		return $this->collProductOptionsValuesRelatedByProductOptionsValueId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsValue is new, it will return
	 * an empty collection; or if this ProductOptionsValue has previously
	 * been saved, it will retrieve related ProductOptionsValuesRelatedByProductOptionsValueId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsValue.
	 */
	public function getProductOptionsValuesRelatedByProductOptionsValueIdJoinProductOptionsTemplate($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValuesRelatedByProductOptionsValueId === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValuesRelatedByProductOptionsValueId = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, $this->getId());

				$this->collProductOptionsValuesRelatedByProductOptionsValueId = ProductOptionsValuePeer::doSelectJoinProductOptionsTemplate($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueRelatedByProductOptionsValueIdCriteria) || !$this->lastProductOptionsValueRelatedByProductOptionsValueIdCriteria->equals($criteria)) {
				$this->collProductOptionsValuesRelatedByProductOptionsValueId = ProductOptionsValuePeer::doSelectJoinProductOptionsTemplate($criteria, $con);
			}
		}
		$this->lastProductOptionsValueRelatedByProductOptionsValueIdCriteria = $criteria;

		return $this->collProductOptionsValuesRelatedByProductOptionsValueId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsValue is new, it will return
	 * an empty collection; or if this ProductOptionsValue has previously
	 * been saved, it will retrieve related ProductOptionsValuesRelatedByProductOptionsValueId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsValue.
	 */
	public function getProductOptionsValuesRelatedByProductOptionsValueIdJoinProductOptionsField($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValuesRelatedByProductOptionsValueId === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValuesRelatedByProductOptionsValueId = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, $this->getId());

				$this->collProductOptionsValuesRelatedByProductOptionsValueId = ProductOptionsValuePeer::doSelectJoinProductOptionsField($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueRelatedByProductOptionsValueIdCriteria) || !$this->lastProductOptionsValueRelatedByProductOptionsValueIdCriteria->equals($criteria)) {
				$this->collProductOptionsValuesRelatedByProductOptionsValueId = ProductOptionsValuePeer::doSelectJoinProductOptionsField($criteria, $con);
			}
		}
		$this->lastProductOptionsValueRelatedByProductOptionsValueIdCriteria = $criteria;

		return $this->collProductOptionsValuesRelatedByProductOptionsValueId;
	}

	/**
	 * Temporary storage of collProductOptionsValueI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductOptionsValueI18ns()
	{
		if ($this->collProductOptionsValueI18ns === null) {
			$this->collProductOptionsValueI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsValue has previously
	 * been saved, it will retrieve related ProductOptionsValueI18ns from storage.
	 * If this ProductOptionsValue is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductOptionsValueI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValueI18ns === null) {
			if ($this->isNew()) {
			   $this->collProductOptionsValueI18ns = array();
			} else {

				$criteria->add(ProductOptionsValueI18nPeer::ID, $this->getId());

				ProductOptionsValueI18nPeer::addSelectColumns($criteria);
				$this->collProductOptionsValueI18ns = ProductOptionsValueI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductOptionsValueI18nPeer::ID, $this->getId());

				ProductOptionsValueI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductOptionsValueI18nCriteria) || !$this->lastProductOptionsValueI18nCriteria->equals($criteria)) {
					$this->collProductOptionsValueI18ns = ProductOptionsValueI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductOptionsValueI18nCriteria = $criteria;
		return $this->collProductOptionsValueI18ns;
	}

	/**
	 * Returns the number of related ProductOptionsValueI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductOptionsValueI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductOptionsValueI18nPeer::ID, $this->getId());

		return ProductOptionsValueI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductOptionsValueI18n object to this object
	 * through the ProductOptionsValueI18n foreign key attribute
	 *
	 * @param      ProductOptionsValueI18n $l ProductOptionsValueI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductOptionsValueI18n(ProductOptionsValueI18n $l)
	{
		$this->collProductOptionsValueI18ns[] = $l;
		$l->setProductOptionsValue($this);
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
    $obj = $this->getCurrentProductOptionsValueI18n();

    return ($obj ? $obj->getValue() : null);
  }

  public function setValue($value)
  {
    $this->getCurrentProductOptionsValueI18n()->setValue($value);
  }

  public $current_i18n = array();

  public function getCurrentProductOptionsValueI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = ProductOptionsValueI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setProductOptionsValueI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setProductOptionsValueI18nForCulture(new ProductOptionsValueI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setProductOptionsValueI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addProductOptionsValueI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'ProductOptionsValue.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseProductOptionsValue:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseProductOptionsValue::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseProductOptionsValue
