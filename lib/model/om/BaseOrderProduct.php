<?php

/**
 * Base class that represents a row from the 'st_order_product' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseOrderProduct extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        OrderProductPeer
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
	 * The value for the order_id field.
	 * @var        int
	 */
	protected $order_id;


	/**
	 * The value for the product_id field.
	 * @var        int
	 */
	protected $product_id;


	/**
	 * The value for the tax_id field.
	 * @var        int
	 */
	protected $tax_id;


	/**
	 * The value for the quantity field.
	 * @var        double
	 */
	protected $quantity;


	/**
	 * The value for the code field.
	 * @var        string
	 */
	protected $code;


	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the image field.
	 * @var        string
	 */
	protected $image;


	/**
	 * The value for the price field.
	 * @var        double
	 */
	protected $price;


	/**
	 * The value for the price_brutto field.
	 * @var        double
	 */
	protected $price_brutto;


	/**
	 * The value for the custom_price field.
	 * @var        double
	 */
	protected $custom_price;


	/**
	 * The value for the custom_price_brutto field.
	 * @var        double
	 */
	protected $custom_price_brutto;


	/**
	 * The value for the vat field.
	 * @var        double
	 */
	protected $vat;


	/**
	 * The value for the points_value field.
	 * @var        int
	 */
	protected $points_value = 0;


	/**
	 * The value for the points_earn field.
	 * @var        int
	 */
	protected $points_earn = 0;


	/**
	 * The value for the product_for_points field.
	 * @var        boolean
	 */
	protected $product_for_points = false;


	/**
	 * The value for the version field.
	 * @var        int
	 */
	protected $version;


	/**
	 * The value for the is_set field.
	 * @var        boolean
	 */
	protected $is_set = false;


	/**
	 * The value for the is_gift field.
	 * @var        boolean
	 */
	protected $is_gift = false;


	/**
	 * The value for the send_review field.
	 * @var        int
	 */
	protected $send_review;


	/**
	 * The value for the price_modifiers field.
	 * @var        string
	 */
	protected $price_modifiers;


	/**
	 * The value for the discount field.
	 * @var        string
	 */
	protected $discount;


	/**
	 * The value for the currency field.
	 * @var        string
	 */
	protected $currency;


	/**
	 * The value for the wholesale field.
	 * @var        string
	 */
	protected $wholesale;


	/**
	 * The value for the online_code field.
	 * @var        string
	 */
	protected $online_code;


	/**
	 * The value for the allegro_auction_id field.
	 * @var        string
	 */
	protected $allegro_auction_id;


	/**
	 * The value for the options field.
	 * @var        string
	 */
	protected $options;

	/**
	 * @var        Order
	 */
	protected $aOrder;

	/**
	 * @var        Product
	 */
	protected $aProduct;

	/**
	 * @var        Tax
	 */
	protected $aTax;

	/**
	 * Collection to store aggregation of collOrderProductHasSets.
	 * @var        array
	 */
	protected $collOrderProductHasSets;

	/**
	 * The criteria used to select the current contents of collOrderProductHasSets.
	 * @var        Criteria
	 */
	protected $lastOrderProductHasSetCriteria = null;

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
     * Get the [order_id] column value.
     * 
     * @return     int
     */
    public function getOrderId()
    {

            return $this->order_id;
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
     * Get the [tax_id] column value.
     * 
     * @return     int
     */
    public function getTaxId()
    {

            return $this->tax_id;
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
     * Get the [code] column value.
     * 
     * @return     string
     */
    public function getCode()
    {

            return $this->code;
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
     * Get the [image] column value.
     * 
     * @return     string
     */
    public function getImage()
    {

            return $this->image;
    }

    /**
     * Get the [price] column value.
     * 
     * @return     double
     */
    public function getPrice()
    {

            return null !== $this->price ? (string)$this->price : null;
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
     * Get the [custom_price] column value.
     * 
     * @return     double
     */
    public function getCustomPrice()
    {

            return null !== $this->custom_price ? (string)$this->custom_price : null;
    }

    /**
     * Get the [custom_price_brutto] column value.
     * 
     * @return     double
     */
    public function getCustomPriceBrutto()
    {

            return null !== $this->custom_price_brutto ? (string)$this->custom_price_brutto : null;
    }

    /**
     * Get the [vat] column value.
     * 
     * @return     double
     */
    public function getVat()
    {

            return null !== $this->vat ? (string)$this->vat : null;
    }

    /**
     * Get the [points_value] column value.
     * 
     * @return     int
     */
    public function getPointsValue()
    {

            return $this->points_value;
    }

    /**
     * Get the [points_earn] column value.
     * 
     * @return     int
     */
    public function getPointsEarn()
    {

            return $this->points_earn;
    }

    /**
     * Get the [product_for_points] column value.
     * 
     * @return     boolean
     */
    public function getProductForPoints()
    {

            return $this->product_for_points;
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
     * Get the [is_set] column value.
     * 
     * @return     boolean
     */
    public function getIsSet()
    {

            return $this->is_set;
    }

    /**
     * Get the [is_gift] column value.
     * 
     * @return     boolean
     */
    public function getIsGift()
    {

            return $this->is_gift;
    }

	/**
	 * Get the [optionally formatted] [send_review] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getSendReview($format = 'Y-m-d H:i:s')
	{

		if ($this->send_review === null || $this->send_review === '') {
			return null;
		} elseif (!is_int($this->send_review)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->send_review);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [send_review] as date/time value: " . var_export($this->send_review, true));
			}
		} else {
			$ts = $this->send_review;
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
     * Get the [price_modifiers] column value.
     * 
     * @return     string
     */
    public function getPriceModifiers()
    {

            return $this->price_modifiers;
    }

    /**
     * Get the [discount] column value.
     * 
     * @return     string
     */
    public function getDiscount()
    {

            return $this->discount;
    }

    /**
     * Get the [currency] column value.
     * 
     * @return     string
     */
    public function getCurrency()
    {

            return $this->currency;
    }

    /**
     * Get the [wholesale] column value.
     * 
     * @return     string
     */
    public function getWholesale()
    {

            return $this->wholesale;
    }

    /**
     * Get the [online_code] column value.
     * 
     * @return     string
     */
    public function getOnlineCode()
    {

            return $this->online_code;
    }

    /**
     * Get the [allegro_auction_id] column value.
     * 
     * @return     string
     */
    public function getAllegroAuctionId()
    {

            return $this->allegro_auction_id;
    }

    /**
     * Get the [options] column value.
     * 
     * @return     string
     */
    public function getOptions()
    {

            return $this->options;
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
			$this->modifiedColumns[] = OrderProductPeer::CREATED_AT;
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
			$this->modifiedColumns[] = OrderProductPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = OrderProductPeer::ID;
        }

	} // setId()

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
          $this->modifiedColumns[] = OrderProductPeer::ORDER_ID;
        }

		if ($this->aOrder !== null && $this->aOrder->getId() !== $v) {
			$this->aOrder = null;
		}

	} // setOrderId()

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
          $this->modifiedColumns[] = OrderProductPeer::PRODUCT_ID;
        }

		if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
			$this->aProduct = null;
		}

	} // setProductId()

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
          $this->modifiedColumns[] = OrderProductPeer::TAX_ID;
        }

		if ($this->aTax !== null && $this->aTax->getId() !== $v) {
			$this->aTax = null;
		}

	} // setTaxId()

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
          $this->modifiedColumns[] = OrderProductPeer::QUANTITY;
        }

	} // setQuantity()

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
          $this->modifiedColumns[] = OrderProductPeer::CODE;
        }

	} // setCode()

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
          $this->modifiedColumns[] = OrderProductPeer::NAME;
        }

	} // setName()

	/**
	 * Set the value of [image] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setImage($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->image !== $v) {
          $this->image = $v;
          $this->modifiedColumns[] = OrderProductPeer::IMAGE;
        }

	} // setImage()

	/**
	 * Set the value of [price] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setPrice($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->price !== $v) {
          $this->price = $v;
          $this->modifiedColumns[] = OrderProductPeer::PRICE;
        }

	} // setPrice()

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
          $this->modifiedColumns[] = OrderProductPeer::PRICE_BRUTTO;
        }

	} // setPriceBrutto()

	/**
	 * Set the value of [custom_price] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setCustomPrice($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->custom_price !== $v) {
          $this->custom_price = $v;
          $this->modifiedColumns[] = OrderProductPeer::CUSTOM_PRICE;
        }

	} // setCustomPrice()

	/**
	 * Set the value of [custom_price_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setCustomPriceBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->custom_price_brutto !== $v) {
          $this->custom_price_brutto = $v;
          $this->modifiedColumns[] = OrderProductPeer::CUSTOM_PRICE_BRUTTO;
        }

	} // setCustomPriceBrutto()

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
          $this->modifiedColumns[] = OrderProductPeer::VAT;
        }

	} // setVat()

	/**
	 * Set the value of [points_value] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPointsValue($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->points_value !== $v || $v === 0) {
          $this->points_value = $v;
          $this->modifiedColumns[] = OrderProductPeer::POINTS_VALUE;
        }

	} // setPointsValue()

	/**
	 * Set the value of [points_earn] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPointsEarn($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->points_earn !== $v || $v === 0) {
          $this->points_earn = $v;
          $this->modifiedColumns[] = OrderProductPeer::POINTS_EARN;
        }

	} // setPointsEarn()

	/**
	 * Set the value of [product_for_points] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setProductForPoints($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->product_for_points !== $v || $v === false) {
          $this->product_for_points = $v;
          $this->modifiedColumns[] = OrderProductPeer::PRODUCT_FOR_POINTS;
        }

	} // setProductForPoints()

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
          $this->modifiedColumns[] = OrderProductPeer::VERSION;
        }

	} // setVersion()

	/**
	 * Set the value of [is_set] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsSet($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_set !== $v || $v === false) {
          $this->is_set = $v;
          $this->modifiedColumns[] = OrderProductPeer::IS_SET;
        }

	} // setIsSet()

	/**
	 * Set the value of [is_gift] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsGift($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_gift !== $v || $v === false) {
          $this->is_gift = $v;
          $this->modifiedColumns[] = OrderProductPeer::IS_GIFT;
        }

	} // setIsGift()

	/**
	 * Set the value of [send_review] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setSendReview($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [send_review] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->send_review !== $ts) {
			$this->send_review = $ts;
			$this->modifiedColumns[] = OrderProductPeer::SEND_REVIEW;
		}

	} // setSendReview()

	/**
	 * Set the value of [price_modifiers] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPriceModifiers($v)
	{

        if ($this->price_modifiers !== $v) {
          $this->price_modifiers = $v;
          $this->modifiedColumns[] = OrderProductPeer::PRICE_MODIFIERS;
        }

	} // setPriceModifiers()

	/**
	 * Set the value of [discount] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setDiscount($v)
	{

        if ($this->discount !== $v) {
          $this->discount = $v;
          $this->modifiedColumns[] = OrderProductPeer::DISCOUNT;
        }

	} // setDiscount()

	/**
	 * Set the value of [currency] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCurrency($v)
	{

        if ($this->currency !== $v) {
          $this->currency = $v;
          $this->modifiedColumns[] = OrderProductPeer::CURRENCY;
        }

	} // setCurrency()

	/**
	 * Set the value of [wholesale] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setWholesale($v)
	{

        if ($this->wholesale !== $v) {
          $this->wholesale = $v;
          $this->modifiedColumns[] = OrderProductPeer::WHOLESALE;
        }

	} // setWholesale()

	/**
	 * Set the value of [online_code] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOnlineCode($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->online_code !== $v) {
          $this->online_code = $v;
          $this->modifiedColumns[] = OrderProductPeer::ONLINE_CODE;
        }

	} // setOnlineCode()

	/**
	 * Set the value of [allegro_auction_id] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setAllegroAuctionId($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->allegro_auction_id !== $v) {
          $this->allegro_auction_id = $v;
          $this->modifiedColumns[] = OrderProductPeer::ALLEGRO_AUCTION_ID;
        }

	} // setAllegroAuctionId()

	/**
	 * Set the value of [options] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptions($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->options !== $v) {
          $this->options = $v;
          $this->modifiedColumns[] = OrderProductPeer::OPTIONS;
        }

	} // setOptions()

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
      if ($this->getDispatcher()->getListeners('OrderProduct.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'OrderProduct.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->order_id = $rs->getInt($startcol + 3);

      $this->product_id = $rs->getInt($startcol + 4);

      $this->tax_id = $rs->getInt($startcol + 5);

      $this->quantity = $rs->getString($startcol + 6);
      if (null !== $this->quantity && $this->quantity == intval($this->quantity))
      {
        $this->quantity = (string)intval($this->quantity);
      }

      $this->code = $rs->getString($startcol + 7);

      $this->name = $rs->getString($startcol + 8);

      $this->image = $rs->getString($startcol + 9);

      $this->price = $rs->getString($startcol + 10);
      if (null !== $this->price && $this->price == intval($this->price))
      {
        $this->price = (string)intval($this->price);
      }

      $this->price_brutto = $rs->getString($startcol + 11);
      if (null !== $this->price_brutto && $this->price_brutto == intval($this->price_brutto))
      {
        $this->price_brutto = (string)intval($this->price_brutto);
      }

      $this->custom_price = $rs->getString($startcol + 12);
      if (null !== $this->custom_price && $this->custom_price == intval($this->custom_price))
      {
        $this->custom_price = (string)intval($this->custom_price);
      }

      $this->custom_price_brutto = $rs->getString($startcol + 13);
      if (null !== $this->custom_price_brutto && $this->custom_price_brutto == intval($this->custom_price_brutto))
      {
        $this->custom_price_brutto = (string)intval($this->custom_price_brutto);
      }

      $this->vat = $rs->getString($startcol + 14);
      if (null !== $this->vat && $this->vat == intval($this->vat))
      {
        $this->vat = (string)intval($this->vat);
      }

      $this->points_value = $rs->getInt($startcol + 15);

      $this->points_earn = $rs->getInt($startcol + 16);

      $this->product_for_points = $rs->getBoolean($startcol + 17);

      $this->version = $rs->getInt($startcol + 18);

      $this->is_set = $rs->getBoolean($startcol + 19);

      $this->is_gift = $rs->getBoolean($startcol + 20);

      $this->send_review = $rs->getTimestamp($startcol + 21, null);

      $this->price_modifiers = $rs->getString($startcol + 22) ? unserialize($rs->getString($startcol + 22)) : null;

      $this->discount = $rs->getString($startcol + 23) ? unserialize($rs->getString($startcol + 23)) : null;

      $this->currency = $rs->getString($startcol + 24) ? unserialize($rs->getString($startcol + 24)) : null;

      $this->wholesale = $rs->getString($startcol + 25) ? unserialize($rs->getString($startcol + 25)) : null;

      $this->online_code = $rs->getString($startcol + 26);

      $this->allegro_auction_id = $rs->getString($startcol + 27);

      $this->options = $rs->getString($startcol + 28);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('OrderProduct.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'OrderProduct.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 29)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 29; // 29 = OrderProductPeer::NUM_COLUMNS - OrderProductPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating OrderProduct object", $e);
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

    if ($this->getDispatcher()->getListeners('OrderProduct.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'OrderProduct.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseOrderProduct:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseOrderProduct:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(OrderProductPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      OrderProductPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('OrderProduct.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'OrderProduct.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseOrderProduct:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseOrderProduct:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('OrderProduct.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'OrderProduct.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseOrderProduct:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(OrderProductPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(OrderProductPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(OrderProductPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('OrderProduct.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'OrderProduct.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseOrderProduct:save:post') as $callable)
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

			if ($this->aProduct !== null) {
				if ($this->aProduct->isModified() || $this->aProduct->getCurrentProductI18n()->isModified()) {
					$affectedRows += $this->aProduct->save($con);
				}
				$this->setProduct($this->aProduct);
			}

			if ($this->aTax !== null) {
				if ($this->aTax->isModified()) {
					$affectedRows += $this->aTax->save($con);
				}
				$this->setTax($this->aTax);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
              $o_price_modifiers = $this->price_modifiers;
              if (null !== $this->price_modifiers && $this->isColumnModified(OrderProductPeer::PRICE_MODIFIERS)) {
                  $this->price_modifiers = serialize($this->price_modifiers);
              }

              $o_discount = $this->discount;
              if (null !== $this->discount && $this->isColumnModified(OrderProductPeer::DISCOUNT)) {
                  $this->discount = serialize($this->discount);
              }

              $o_currency = $this->currency;
              if (null !== $this->currency && $this->isColumnModified(OrderProductPeer::CURRENCY)) {
                  $this->currency = serialize($this->currency);
              }

              $o_wholesale = $this->wholesale;
              if (null !== $this->wholesale && $this->isColumnModified(OrderProductPeer::WHOLESALE)) {
                  $this->wholesale = serialize($this->wholesale);
              }

				if ($this->isNew()) {
					$pk = OrderProductPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += OrderProductPeer::doUpdate($this, $con);
				}
				$this->resetModified();
             $this->price_modifiers = $o_price_modifiers;

             $this->discount = $o_discount;

             $this->currency = $o_currency;

             $this->wholesale = $o_wholesale;
 // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collOrderProductHasSets !== null) {
				foreach($this->collOrderProductHasSets as $referrerFK) {
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

			if ($this->aOrder !== null) {
				if (!$this->aOrder->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOrder->getValidationFailures());
				}
			}

			if ($this->aProduct !== null) {
				if (!$this->aProduct->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProduct->getValidationFailures());
				}
			}

			if ($this->aTax !== null) {
				if (!$this->aTax->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTax->getValidationFailures());
				}
			}


			if (($retval = OrderProductPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOrderProductHasSets !== null) {
					foreach($this->collOrderProductHasSets as $referrerFK) {
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
		$pos = OrderProductPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getOrderId();
				break;
			case 4:
				return $this->getProductId();
				break;
			case 5:
				return $this->getTaxId();
				break;
			case 6:
				return $this->getQuantity();
				break;
			case 7:
				return $this->getCode();
				break;
			case 8:
				return $this->getName();
				break;
			case 9:
				return $this->getImage();
				break;
			case 10:
				return $this->getPrice();
				break;
			case 11:
				return $this->getPriceBrutto();
				break;
			case 12:
				return $this->getCustomPrice();
				break;
			case 13:
				return $this->getCustomPriceBrutto();
				break;
			case 14:
				return $this->getVat();
				break;
			case 15:
				return $this->getPointsValue();
				break;
			case 16:
				return $this->getPointsEarn();
				break;
			case 17:
				return $this->getProductForPoints();
				break;
			case 18:
				return $this->getVersion();
				break;
			case 19:
				return $this->getIsSet();
				break;
			case 20:
				return $this->getIsGift();
				break;
			case 21:
				return $this->getSendReview();
				break;
			case 22:
				return $this->getPriceModifiers();
				break;
			case 23:
				return $this->getDiscount();
				break;
			case 24:
				return $this->getCurrency();
				break;
			case 25:
				return $this->getWholesale();
				break;
			case 26:
				return $this->getOnlineCode();
				break;
			case 27:
				return $this->getAllegroAuctionId();
				break;
			case 28:
				return $this->getOptions();
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
		$keys = OrderProductPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getOrderId(),
			$keys[4] => $this->getProductId(),
			$keys[5] => $this->getTaxId(),
			$keys[6] => $this->getQuantity(),
			$keys[7] => $this->getCode(),
			$keys[8] => $this->getName(),
			$keys[9] => $this->getImage(),
			$keys[10] => $this->getPrice(),
			$keys[11] => $this->getPriceBrutto(),
			$keys[12] => $this->getCustomPrice(),
			$keys[13] => $this->getCustomPriceBrutto(),
			$keys[14] => $this->getVat(),
			$keys[15] => $this->getPointsValue(),
			$keys[16] => $this->getPointsEarn(),
			$keys[17] => $this->getProductForPoints(),
			$keys[18] => $this->getVersion(),
			$keys[19] => $this->getIsSet(),
			$keys[20] => $this->getIsGift(),
			$keys[21] => $this->getSendReview(),
			$keys[22] => $this->getPriceModifiers(),
			$keys[23] => $this->getDiscount(),
			$keys[24] => $this->getCurrency(),
			$keys[25] => $this->getWholesale(),
			$keys[26] => $this->getOnlineCode(),
			$keys[27] => $this->getAllegroAuctionId(),
			$keys[28] => $this->getOptions(),
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
		$pos = OrderProductPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setOrderId($value);
				break;
			case 4:
				$this->setProductId($value);
				break;
			case 5:
				$this->setTaxId($value);
				break;
			case 6:
				$this->setQuantity($value);
				break;
			case 7:
				$this->setCode($value);
				break;
			case 8:
				$this->setName($value);
				break;
			case 9:
				$this->setImage($value);
				break;
			case 10:
				$this->setPrice($value);
				break;
			case 11:
				$this->setPriceBrutto($value);
				break;
			case 12:
				$this->setCustomPrice($value);
				break;
			case 13:
				$this->setCustomPriceBrutto($value);
				break;
			case 14:
				$this->setVat($value);
				break;
			case 15:
				$this->setPointsValue($value);
				break;
			case 16:
				$this->setPointsEarn($value);
				break;
			case 17:
				$this->setProductForPoints($value);
				break;
			case 18:
				$this->setVersion($value);
				break;
			case 19:
				$this->setIsSet($value);
				break;
			case 20:
				$this->setIsGift($value);
				break;
			case 21:
				$this->setSendReview($value);
				break;
			case 22:
				$this->setPriceModifiers($value);
				break;
			case 23:
				$this->setDiscount($value);
				break;
			case 24:
				$this->setCurrency($value);
				break;
			case 25:
				$this->setWholesale($value);
				break;
			case 26:
				$this->setOnlineCode($value);
				break;
			case 27:
				$this->setAllegroAuctionId($value);
				break;
			case 28:
				$this->setOptions($value);
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
		$keys = OrderProductPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setOrderId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setProductId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setTaxId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setQuantity($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCode($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setName($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setImage($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setPrice($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setPriceBrutto($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setCustomPrice($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setCustomPriceBrutto($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setVat($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setPointsValue($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setPointsEarn($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setProductForPoints($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setVersion($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setIsSet($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setIsGift($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setSendReview($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setPriceModifiers($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setDiscount($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setCurrency($arr[$keys[24]]);
		if (array_key_exists($keys[25], $arr)) $this->setWholesale($arr[$keys[25]]);
		if (array_key_exists($keys[26], $arr)) $this->setOnlineCode($arr[$keys[26]]);
		if (array_key_exists($keys[27], $arr)) $this->setAllegroAuctionId($arr[$keys[27]]);
		if (array_key_exists($keys[28], $arr)) $this->setOptions($arr[$keys[28]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(OrderProductPeer::DATABASE_NAME);

		if ($this->isColumnModified(OrderProductPeer::CREATED_AT)) $criteria->add(OrderProductPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(OrderProductPeer::UPDATED_AT)) $criteria->add(OrderProductPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(OrderProductPeer::ID)) $criteria->add(OrderProductPeer::ID, $this->id);
		if ($this->isColumnModified(OrderProductPeer::ORDER_ID)) $criteria->add(OrderProductPeer::ORDER_ID, $this->order_id);
		if ($this->isColumnModified(OrderProductPeer::PRODUCT_ID)) $criteria->add(OrderProductPeer::PRODUCT_ID, $this->product_id);
		if ($this->isColumnModified(OrderProductPeer::TAX_ID)) $criteria->add(OrderProductPeer::TAX_ID, $this->tax_id);
		if ($this->isColumnModified(OrderProductPeer::QUANTITY)) $criteria->add(OrderProductPeer::QUANTITY, $this->quantity);
		if ($this->isColumnModified(OrderProductPeer::CODE)) $criteria->add(OrderProductPeer::CODE, $this->code);
		if ($this->isColumnModified(OrderProductPeer::NAME)) $criteria->add(OrderProductPeer::NAME, $this->name);
		if ($this->isColumnModified(OrderProductPeer::IMAGE)) $criteria->add(OrderProductPeer::IMAGE, $this->image);
		if ($this->isColumnModified(OrderProductPeer::PRICE)) $criteria->add(OrderProductPeer::PRICE, $this->price);
		if ($this->isColumnModified(OrderProductPeer::PRICE_BRUTTO)) $criteria->add(OrderProductPeer::PRICE_BRUTTO, $this->price_brutto);
		if ($this->isColumnModified(OrderProductPeer::CUSTOM_PRICE)) $criteria->add(OrderProductPeer::CUSTOM_PRICE, $this->custom_price);
		if ($this->isColumnModified(OrderProductPeer::CUSTOM_PRICE_BRUTTO)) $criteria->add(OrderProductPeer::CUSTOM_PRICE_BRUTTO, $this->custom_price_brutto);
		if ($this->isColumnModified(OrderProductPeer::VAT)) $criteria->add(OrderProductPeer::VAT, $this->vat);
		if ($this->isColumnModified(OrderProductPeer::POINTS_VALUE)) $criteria->add(OrderProductPeer::POINTS_VALUE, $this->points_value);
		if ($this->isColumnModified(OrderProductPeer::POINTS_EARN)) $criteria->add(OrderProductPeer::POINTS_EARN, $this->points_earn);
		if ($this->isColumnModified(OrderProductPeer::PRODUCT_FOR_POINTS)) $criteria->add(OrderProductPeer::PRODUCT_FOR_POINTS, $this->product_for_points);
		if ($this->isColumnModified(OrderProductPeer::VERSION)) $criteria->add(OrderProductPeer::VERSION, $this->version);
		if ($this->isColumnModified(OrderProductPeer::IS_SET)) $criteria->add(OrderProductPeer::IS_SET, $this->is_set);
		if ($this->isColumnModified(OrderProductPeer::IS_GIFT)) $criteria->add(OrderProductPeer::IS_GIFT, $this->is_gift);
		if ($this->isColumnModified(OrderProductPeer::SEND_REVIEW)) $criteria->add(OrderProductPeer::SEND_REVIEW, $this->send_review);
		if ($this->isColumnModified(OrderProductPeer::PRICE_MODIFIERS)) $criteria->add(OrderProductPeer::PRICE_MODIFIERS, $this->price_modifiers);
		if ($this->isColumnModified(OrderProductPeer::DISCOUNT)) $criteria->add(OrderProductPeer::DISCOUNT, $this->discount);
		if ($this->isColumnModified(OrderProductPeer::CURRENCY)) $criteria->add(OrderProductPeer::CURRENCY, $this->currency);
		if ($this->isColumnModified(OrderProductPeer::WHOLESALE)) $criteria->add(OrderProductPeer::WHOLESALE, $this->wholesale);
		if ($this->isColumnModified(OrderProductPeer::ONLINE_CODE)) $criteria->add(OrderProductPeer::ONLINE_CODE, $this->online_code);
		if ($this->isColumnModified(OrderProductPeer::ALLEGRO_AUCTION_ID)) $criteria->add(OrderProductPeer::ALLEGRO_AUCTION_ID, $this->allegro_auction_id);
		if ($this->isColumnModified(OrderProductPeer::OPTIONS)) $criteria->add(OrderProductPeer::OPTIONS, $this->options);

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
		$criteria = new Criteria(OrderProductPeer::DATABASE_NAME);

		$criteria->add(OrderProductPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of OrderProduct (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setOrderId($this->order_id);

		$copyObj->setProductId($this->product_id);

		$copyObj->setTaxId($this->tax_id);

		$copyObj->setQuantity($this->quantity);

		$copyObj->setCode($this->code);

		$copyObj->setName($this->name);

		$copyObj->setImage($this->image);

		$copyObj->setPrice($this->price);

		$copyObj->setPriceBrutto($this->price_brutto);

		$copyObj->setCustomPrice($this->custom_price);

		$copyObj->setCustomPriceBrutto($this->custom_price_brutto);

		$copyObj->setVat($this->vat);

		$copyObj->setPointsValue($this->points_value);

		$copyObj->setPointsEarn($this->points_earn);

		$copyObj->setProductForPoints($this->product_for_points);

		$copyObj->setVersion($this->version);

		$copyObj->setIsSet($this->is_set);

		$copyObj->setIsGift($this->is_gift);

		$copyObj->setSendReview($this->send_review);

		$copyObj->setPriceModifiers($this->price_modifiers);

		$copyObj->setDiscount($this->discount);

		$copyObj->setCurrency($this->currency);

		$copyObj->setWholesale($this->wholesale);

		$copyObj->setOnlineCode($this->online_code);

		$copyObj->setAllegroAuctionId($this->allegro_auction_id);

		$copyObj->setOptions($this->options);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getOrderProductHasSets() as $relObj) {
				$copyObj->addOrderProductHasSet($relObj->copy($deepCopy));
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
	 * @return     OrderProduct Clone of current object.
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
	 * @return     OrderProductPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new OrderProductPeer();
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
	 * Temporary storage of collOrderProductHasSets to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOrderProductHasSets()
	{
		if ($this->collOrderProductHasSets === null) {
			$this->collOrderProductHasSets = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this OrderProduct has previously
	 * been saved, it will retrieve related OrderProductHasSets from storage.
	 * If this OrderProduct is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOrderProductHasSets($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderProductHasSets === null) {
			if ($this->isNew()) {
			   $this->collOrderProductHasSets = array();
			} else {

				$criteria->add(OrderProductHasSetPeer::ORDER_PRODUCT_ID, $this->getId());

				OrderProductHasSetPeer::addSelectColumns($criteria);
				$this->collOrderProductHasSets = OrderProductHasSetPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderProductHasSetPeer::ORDER_PRODUCT_ID, $this->getId());

				OrderProductHasSetPeer::addSelectColumns($criteria);
				if (!isset($this->lastOrderProductHasSetCriteria) || !$this->lastOrderProductHasSetCriteria->equals($criteria)) {
					$this->collOrderProductHasSets = OrderProductHasSetPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOrderProductHasSetCriteria = $criteria;
		return $this->collOrderProductHasSets;
	}

	/**
	 * Returns the number of related OrderProductHasSets.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOrderProductHasSets($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OrderProductHasSetPeer::ORDER_PRODUCT_ID, $this->getId());

		return OrderProductHasSetPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a OrderProductHasSet object to this object
	 * through the OrderProductHasSet foreign key attribute
	 *
	 * @param      OrderProductHasSet $l OrderProductHasSet
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOrderProductHasSet(OrderProductHasSet $l)
	{
		$this->collOrderProductHasSets[] = $l;
		$l->setOrderProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this OrderProduct is new, it will return
	 * an empty collection; or if this OrderProduct has previously
	 * been saved, it will retrieve related OrderProductHasSets from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderProduct.
	 */
	public function getOrderProductHasSetsJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderProductHasSets === null) {
			if ($this->isNew()) {
				$this->collOrderProductHasSets = array();
			} else {

				$criteria->add(OrderProductHasSetPeer::ORDER_PRODUCT_ID, $this->getId());

				$this->collOrderProductHasSets = OrderProductHasSetPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderProductHasSetPeer::ORDER_PRODUCT_ID, $this->getId());

			if (!isset($this->lastOrderProductHasSetCriteria) || !$this->lastOrderProductHasSetCriteria->equals($criteria)) {
				$this->collOrderProductHasSets = OrderProductHasSetPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastOrderProductHasSetCriteria = $criteria;

		return $this->collOrderProductHasSets;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'OrderProduct.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseOrderProduct:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseOrderProduct::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseOrderProduct
