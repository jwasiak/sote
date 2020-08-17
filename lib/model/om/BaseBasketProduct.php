<?php

/**
 * Base class that represents a row from the 'st_basket_product' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseBasketProduct extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        BasketProductPeer
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
	 * The value for the product_id field.
	 * @var        int
	 */
	protected $product_id = 0;


	/**
	 * The value for the product_set_discount_id field.
	 * @var        int
	 */
	protected $product_set_discount_id;


	/**
	 * The value for the basket_id field.
	 * @var        int
	 */
	protected $basket_id;


	/**
	 * The value for the is_gift field.
	 * @var        boolean
	 */
	protected $is_gift = false;


	/**
	 * The value for the quantity field.
	 * @var        double
	 */
	protected $quantity;


	/**
	 * The value for the max_quantity field.
	 * @var        double
	 */
	protected $max_quantity;


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
	 * The value for the item_id field.
	 * @var        string
	 */
	protected $item_id;


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
	 * The value for the vat field.
	 * @var        double
	 */
	protected $vat;


	/**
	 * The value for the weight field.
	 * @var        double
	 */
	protected $weight;


	/**
	 * The value for the product_for_points field.
	 * @var        boolean
	 */
	protected $product_for_points = false;


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
	 * The value for the options field.
	 * @var        string
	 */
	protected $options;


	/**
	 * The value for the new_options field.
	 * @var        string
	 */
	protected $new_options;

	/**
	 * @var        Product
	 */
	protected $aProduct;

	/**
	 * @var        Basket
	 */
	protected $aBasket;

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
     * Get the [product_id] column value.
     * 
     * @return     int
     */
    public function getProductId()
    {

            return $this->product_id;
    }

    /**
     * Get the [product_set_discount_id] column value.
     * 
     * @return     int
     */
    public function getProductSetDiscountId()
    {

            return $this->product_set_discount_id;
    }

    /**
     * Get the [basket_id] column value.
     * 
     * @return     int
     */
    public function getBasketId()
    {

            return $this->basket_id;
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
     * Get the [quantity] column value.
     * 
     * @return     double
     */
    public function getQuantity()
    {

            return null !== $this->quantity ? (string)$this->quantity : null;
    }

    /**
     * Get the [max_quantity] column value.
     * 
     * @return     double
     */
    public function getMaxQuantity()
    {

            return null !== $this->max_quantity ? (string)$this->max_quantity : null;
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
     * Get the [item_id] column value.
     * 
     * @return     string
     */
    public function getItemId()
    {

            return $this->item_id;
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
     * Get the [vat] column value.
     * 
     * @return     double
     */
    public function getVat()
    {

            return $this->vat;
    }

    /**
     * Get the [weight] column value.
     * 
     * @return     double
     */
    public function getWeight()
    {

            return $this->weight;
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
     * Get the [options] column value.
     * 
     * @return     string
     */
    public function getOptions()
    {

            return $this->options;
    }

    /**
     * Get the [new_options] column value.
     * 
     * @return     string
     */
    public function getNewOptions()
    {

            return $this->new_options;
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
			$this->modifiedColumns[] = BasketProductPeer::CREATED_AT;
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
			$this->modifiedColumns[] = BasketProductPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = BasketProductPeer::ID;
        }

	} // setId()

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

        if ($this->product_id !== $v || $v === 0) {
          $this->product_id = $v;
          $this->modifiedColumns[] = BasketProductPeer::PRODUCT_ID;
        }

		if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
			$this->aProduct = null;
		}

	} // setProductId()

	/**
	 * Set the value of [product_set_discount_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setProductSetDiscountId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->product_set_discount_id !== $v) {
          $this->product_set_discount_id = $v;
          $this->modifiedColumns[] = BasketProductPeer::PRODUCT_SET_DISCOUNT_ID;
        }

	} // setProductSetDiscountId()

	/**
	 * Set the value of [basket_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setBasketId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->basket_id !== $v) {
          $this->basket_id = $v;
          $this->modifiedColumns[] = BasketProductPeer::BASKET_ID;
        }

		if ($this->aBasket !== null && $this->aBasket->getId() !== $v) {
			$this->aBasket = null;
		}

	} // setBasketId()

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
          $this->modifiedColumns[] = BasketProductPeer::IS_GIFT;
        }

	} // setIsGift()

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
          $this->modifiedColumns[] = BasketProductPeer::QUANTITY;
        }

	} // setQuantity()

	/**
	 * Set the value of [max_quantity] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setMaxQuantity($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->max_quantity !== $v) {
          $this->max_quantity = $v;
          $this->modifiedColumns[] = BasketProductPeer::MAX_QUANTITY;
        }

	} // setMaxQuantity()

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
          $this->modifiedColumns[] = BasketProductPeer::CODE;
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
          $this->modifiedColumns[] = BasketProductPeer::NAME;
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
          $this->modifiedColumns[] = BasketProductPeer::IMAGE;
        }

	} // setImage()

	/**
	 * Set the value of [item_id] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setItemId($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->item_id !== $v) {
          $this->item_id = $v;
          $this->modifiedColumns[] = BasketProductPeer::ITEM_ID;
        }

	} // setItemId()

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
          $this->modifiedColumns[] = BasketProductPeer::PRICE;
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
          $this->modifiedColumns[] = BasketProductPeer::PRICE_BRUTTO;
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
          $this->modifiedColumns[] = BasketProductPeer::VAT;
        }

	} // setVat()

	/**
	 * Set the value of [weight] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setWeight($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->weight !== $v) {
          $this->weight = $v;
          $this->modifiedColumns[] = BasketProductPeer::WEIGHT;
        }

	} // setWeight()

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
          $this->modifiedColumns[] = BasketProductPeer::PRODUCT_FOR_POINTS;
        }

	} // setProductForPoints()

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
          $this->modifiedColumns[] = BasketProductPeer::PRICE_MODIFIERS;
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
          $this->modifiedColumns[] = BasketProductPeer::DISCOUNT;
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
          $this->modifiedColumns[] = BasketProductPeer::CURRENCY;
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
          $this->modifiedColumns[] = BasketProductPeer::WHOLESALE;
        }

	} // setWholesale()

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
          $this->modifiedColumns[] = BasketProductPeer::OPTIONS;
        }

	} // setOptions()

	/**
	 * Set the value of [new_options] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setNewOptions($v)
	{

        if ($this->new_options !== $v) {
          $this->new_options = $v;
          $this->modifiedColumns[] = BasketProductPeer::NEW_OPTIONS;
        }

	} // setNewOptions()

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
      if ($this->getDispatcher()->getListeners('BasketProduct.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'BasketProduct.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->product_id = $rs->getInt($startcol + 3);

      $this->product_set_discount_id = $rs->getInt($startcol + 4);

      $this->basket_id = $rs->getInt($startcol + 5);

      $this->is_gift = $rs->getBoolean($startcol + 6);

      $this->quantity = $rs->getString($startcol + 7);
      if (null !== $this->quantity && $this->quantity == intval($this->quantity))
      {
        $this->quantity = (string)intval($this->quantity);
      }

      $this->max_quantity = $rs->getString($startcol + 8);
      if (null !== $this->max_quantity && $this->max_quantity == intval($this->max_quantity))
      {
        $this->max_quantity = (string)intval($this->max_quantity);
      }

      $this->code = $rs->getString($startcol + 9);

      $this->name = $rs->getString($startcol + 10);

      $this->image = $rs->getString($startcol + 11);

      $this->item_id = $rs->getString($startcol + 12);

      $this->price = $rs->getString($startcol + 13);
      if (null !== $this->price && $this->price == intval($this->price))
      {
        $this->price = (string)intval($this->price);
      }

      $this->price_brutto = $rs->getString($startcol + 14);
      if (null !== $this->price_brutto && $this->price_brutto == intval($this->price_brutto))
      {
        $this->price_brutto = (string)intval($this->price_brutto);
      }

      $this->vat = $rs->getFloat($startcol + 15);

      $this->weight = $rs->getFloat($startcol + 16);

      $this->product_for_points = $rs->getBoolean($startcol + 17);

      $this->price_modifiers = $rs->getString($startcol + 18) ? unserialize($rs->getString($startcol + 18)) : null;

      $this->discount = $rs->getString($startcol + 19) ? unserialize($rs->getString($startcol + 19)) : null;

      $this->currency = $rs->getString($startcol + 20) ? unserialize($rs->getString($startcol + 20)) : null;

      $this->wholesale = $rs->getString($startcol + 21) ? unserialize($rs->getString($startcol + 21)) : null;

      $this->options = $rs->getString($startcol + 22);

      $this->new_options = $rs->getString($startcol + 23) ? unserialize($rs->getString($startcol + 23)) : null;

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('BasketProduct.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'BasketProduct.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 24)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 24; // 24 = BasketProductPeer::NUM_COLUMNS - BasketProductPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating BasketProduct object", $e);
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

    if ($this->getDispatcher()->getListeners('BasketProduct.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'BasketProduct.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseBasketProduct:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseBasketProduct:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(BasketProductPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      BasketProductPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('BasketProduct.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'BasketProduct.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseBasketProduct:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseBasketProduct:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('BasketProduct.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'BasketProduct.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseBasketProduct:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(BasketProductPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(BasketProductPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(BasketProductPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('BasketProduct.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'BasketProduct.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseBasketProduct:save:post') as $callable)
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

			if ($this->aBasket !== null) {
				if ($this->aBasket->isModified()) {
					$affectedRows += $this->aBasket->save($con);
				}
				$this->setBasket($this->aBasket);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
              $o_price_modifiers = $this->price_modifiers;
              if (null !== $this->price_modifiers && $this->isColumnModified(BasketProductPeer::PRICE_MODIFIERS)) {
                  $this->price_modifiers = serialize($this->price_modifiers);
              }

              $o_discount = $this->discount;
              if (null !== $this->discount && $this->isColumnModified(BasketProductPeer::DISCOUNT)) {
                  $this->discount = serialize($this->discount);
              }

              $o_currency = $this->currency;
              if (null !== $this->currency && $this->isColumnModified(BasketProductPeer::CURRENCY)) {
                  $this->currency = serialize($this->currency);
              }

              $o_wholesale = $this->wholesale;
              if (null !== $this->wholesale && $this->isColumnModified(BasketProductPeer::WHOLESALE)) {
                  $this->wholesale = serialize($this->wholesale);
              }

              $o_new_options = $this->new_options;
              if (null !== $this->new_options && $this->isColumnModified(BasketProductPeer::NEW_OPTIONS)) {
                  $this->new_options = serialize($this->new_options);
              }

				if ($this->isNew()) {
					$pk = BasketProductPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += BasketProductPeer::doUpdate($this, $con);
				}
				$this->resetModified();
             $this->price_modifiers = $o_price_modifiers;

             $this->discount = $o_discount;

             $this->currency = $o_currency;

             $this->wholesale = $o_wholesale;

             $this->new_options = $o_new_options;
 // [HL] After being saved an object is no longer 'modified'
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

			if ($this->aBasket !== null) {
				if (!$this->aBasket->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aBasket->getValidationFailures());
				}
			}


			if (($retval = BasketProductPeer::doValidate($this, $columns)) !== true) {
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
		$pos = BasketProductPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getProductId();
				break;
			case 4:
				return $this->getProductSetDiscountId();
				break;
			case 5:
				return $this->getBasketId();
				break;
			case 6:
				return $this->getIsGift();
				break;
			case 7:
				return $this->getQuantity();
				break;
			case 8:
				return $this->getMaxQuantity();
				break;
			case 9:
				return $this->getCode();
				break;
			case 10:
				return $this->getName();
				break;
			case 11:
				return $this->getImage();
				break;
			case 12:
				return $this->getItemId();
				break;
			case 13:
				return $this->getPrice();
				break;
			case 14:
				return $this->getPriceBrutto();
				break;
			case 15:
				return $this->getVat();
				break;
			case 16:
				return $this->getWeight();
				break;
			case 17:
				return $this->getProductForPoints();
				break;
			case 18:
				return $this->getPriceModifiers();
				break;
			case 19:
				return $this->getDiscount();
				break;
			case 20:
				return $this->getCurrency();
				break;
			case 21:
				return $this->getWholesale();
				break;
			case 22:
				return $this->getOptions();
				break;
			case 23:
				return $this->getNewOptions();
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
		$keys = BasketProductPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getProductId(),
			$keys[4] => $this->getProductSetDiscountId(),
			$keys[5] => $this->getBasketId(),
			$keys[6] => $this->getIsGift(),
			$keys[7] => $this->getQuantity(),
			$keys[8] => $this->getMaxQuantity(),
			$keys[9] => $this->getCode(),
			$keys[10] => $this->getName(),
			$keys[11] => $this->getImage(),
			$keys[12] => $this->getItemId(),
			$keys[13] => $this->getPrice(),
			$keys[14] => $this->getPriceBrutto(),
			$keys[15] => $this->getVat(),
			$keys[16] => $this->getWeight(),
			$keys[17] => $this->getProductForPoints(),
			$keys[18] => $this->getPriceModifiers(),
			$keys[19] => $this->getDiscount(),
			$keys[20] => $this->getCurrency(),
			$keys[21] => $this->getWholesale(),
			$keys[22] => $this->getOptions(),
			$keys[23] => $this->getNewOptions(),
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
		$pos = BasketProductPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setProductId($value);
				break;
			case 4:
				$this->setProductSetDiscountId($value);
				break;
			case 5:
				$this->setBasketId($value);
				break;
			case 6:
				$this->setIsGift($value);
				break;
			case 7:
				$this->setQuantity($value);
				break;
			case 8:
				$this->setMaxQuantity($value);
				break;
			case 9:
				$this->setCode($value);
				break;
			case 10:
				$this->setName($value);
				break;
			case 11:
				$this->setImage($value);
				break;
			case 12:
				$this->setItemId($value);
				break;
			case 13:
				$this->setPrice($value);
				break;
			case 14:
				$this->setPriceBrutto($value);
				break;
			case 15:
				$this->setVat($value);
				break;
			case 16:
				$this->setWeight($value);
				break;
			case 17:
				$this->setProductForPoints($value);
				break;
			case 18:
				$this->setPriceModifiers($value);
				break;
			case 19:
				$this->setDiscount($value);
				break;
			case 20:
				$this->setCurrency($value);
				break;
			case 21:
				$this->setWholesale($value);
				break;
			case 22:
				$this->setOptions($value);
				break;
			case 23:
				$this->setNewOptions($value);
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
		$keys = BasketProductPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setProductId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setProductSetDiscountId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setBasketId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsGift($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setQuantity($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setMaxQuantity($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setCode($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setName($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setImage($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setItemId($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setPrice($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setPriceBrutto($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setVat($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setWeight($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setProductForPoints($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setPriceModifiers($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setDiscount($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setCurrency($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setWholesale($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setOptions($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setNewOptions($arr[$keys[23]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(BasketProductPeer::DATABASE_NAME);

		if ($this->isColumnModified(BasketProductPeer::CREATED_AT)) $criteria->add(BasketProductPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(BasketProductPeer::UPDATED_AT)) $criteria->add(BasketProductPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(BasketProductPeer::ID)) $criteria->add(BasketProductPeer::ID, $this->id);
		if ($this->isColumnModified(BasketProductPeer::PRODUCT_ID)) $criteria->add(BasketProductPeer::PRODUCT_ID, $this->product_id);
		if ($this->isColumnModified(BasketProductPeer::PRODUCT_SET_DISCOUNT_ID)) $criteria->add(BasketProductPeer::PRODUCT_SET_DISCOUNT_ID, $this->product_set_discount_id);
		if ($this->isColumnModified(BasketProductPeer::BASKET_ID)) $criteria->add(BasketProductPeer::BASKET_ID, $this->basket_id);
		if ($this->isColumnModified(BasketProductPeer::IS_GIFT)) $criteria->add(BasketProductPeer::IS_GIFT, $this->is_gift);
		if ($this->isColumnModified(BasketProductPeer::QUANTITY)) $criteria->add(BasketProductPeer::QUANTITY, $this->quantity);
		if ($this->isColumnModified(BasketProductPeer::MAX_QUANTITY)) $criteria->add(BasketProductPeer::MAX_QUANTITY, $this->max_quantity);
		if ($this->isColumnModified(BasketProductPeer::CODE)) $criteria->add(BasketProductPeer::CODE, $this->code);
		if ($this->isColumnModified(BasketProductPeer::NAME)) $criteria->add(BasketProductPeer::NAME, $this->name);
		if ($this->isColumnModified(BasketProductPeer::IMAGE)) $criteria->add(BasketProductPeer::IMAGE, $this->image);
		if ($this->isColumnModified(BasketProductPeer::ITEM_ID)) $criteria->add(BasketProductPeer::ITEM_ID, $this->item_id);
		if ($this->isColumnModified(BasketProductPeer::PRICE)) $criteria->add(BasketProductPeer::PRICE, $this->price);
		if ($this->isColumnModified(BasketProductPeer::PRICE_BRUTTO)) $criteria->add(BasketProductPeer::PRICE_BRUTTO, $this->price_brutto);
		if ($this->isColumnModified(BasketProductPeer::VAT)) $criteria->add(BasketProductPeer::VAT, $this->vat);
		if ($this->isColumnModified(BasketProductPeer::WEIGHT)) $criteria->add(BasketProductPeer::WEIGHT, $this->weight);
		if ($this->isColumnModified(BasketProductPeer::PRODUCT_FOR_POINTS)) $criteria->add(BasketProductPeer::PRODUCT_FOR_POINTS, $this->product_for_points);
		if ($this->isColumnModified(BasketProductPeer::PRICE_MODIFIERS)) $criteria->add(BasketProductPeer::PRICE_MODIFIERS, $this->price_modifiers);
		if ($this->isColumnModified(BasketProductPeer::DISCOUNT)) $criteria->add(BasketProductPeer::DISCOUNT, $this->discount);
		if ($this->isColumnModified(BasketProductPeer::CURRENCY)) $criteria->add(BasketProductPeer::CURRENCY, $this->currency);
		if ($this->isColumnModified(BasketProductPeer::WHOLESALE)) $criteria->add(BasketProductPeer::WHOLESALE, $this->wholesale);
		if ($this->isColumnModified(BasketProductPeer::OPTIONS)) $criteria->add(BasketProductPeer::OPTIONS, $this->options);
		if ($this->isColumnModified(BasketProductPeer::NEW_OPTIONS)) $criteria->add(BasketProductPeer::NEW_OPTIONS, $this->new_options);

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
		$criteria = new Criteria(BasketProductPeer::DATABASE_NAME);

		$criteria->add(BasketProductPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of BasketProduct (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setProductId($this->product_id);

		$copyObj->setProductSetDiscountId($this->product_set_discount_id);

		$copyObj->setBasketId($this->basket_id);

		$copyObj->setIsGift($this->is_gift);

		$copyObj->setQuantity($this->quantity);

		$copyObj->setMaxQuantity($this->max_quantity);

		$copyObj->setCode($this->code);

		$copyObj->setName($this->name);

		$copyObj->setImage($this->image);

		$copyObj->setItemId($this->item_id);

		$copyObj->setPrice($this->price);

		$copyObj->setPriceBrutto($this->price_brutto);

		$copyObj->setVat($this->vat);

		$copyObj->setWeight($this->weight);

		$copyObj->setProductForPoints($this->product_for_points);

		$copyObj->setPriceModifiers($this->price_modifiers);

		$copyObj->setDiscount($this->discount);

		$copyObj->setCurrency($this->currency);

		$copyObj->setWholesale($this->wholesale);

		$copyObj->setOptions($this->options);

		$copyObj->setNewOptions($this->new_options);


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
	 * @return     BasketProduct Clone of current object.
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
	 * @return     BasketProductPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new BasketProductPeer();
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
			$this->setProductId('0');
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
	 * Declares an association between this object and a Basket object.
	 *
	 * @param      Basket $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setBasket($v)
	{


		if ($v === null) {
			$this->setBasketId(NULL);
		} else {
			$this->setBasketId($v->getId());
		}


		$this->aBasket = $v;
	}


	/**
	 * Get the associated Basket object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Basket The associated Basket object.
	 * @throws     PropelException
	 */
	public function getBasket($con = null)
	{
		if ($this->aBasket === null && ($this->basket_id !== null)) {
			// include the related Peer class
			$this->aBasket = BasketPeer::retrieveByPK($this->basket_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = BasketPeer::retrieveByPK($this->basket_id, $con);
			   $obj->addBaskets($this);
			 */
		}
		return $this->aBasket;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'BasketProduct.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseBasketProduct:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseBasketProduct::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseBasketProduct
