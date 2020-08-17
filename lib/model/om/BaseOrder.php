<?php

/**
 * Base class that represents a row from the 'st_order' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseOrder extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        OrderPeer
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
	 * The value for the order_delivery_id field.
	 * @var        int
	 */
	protected $order_delivery_id;


	/**
	 * The value for the sf_guard_user_id field.
	 * @var        int
	 */
	protected $sf_guard_user_id;


	/**
	 * The value for the order_user_data_delivery_id field.
	 * @var        int
	 */
	protected $order_user_data_delivery_id;


	/**
	 * The value for the order_user_data_billing_id field.
	 * @var        int
	 */
	protected $order_user_data_billing_id;


	/**
	 * The value for the order_currency_id field.
	 * @var        int
	 */
	protected $order_currency_id;


	/**
	 * The value for the order_status_id field.
	 * @var        int
	 */
	protected $order_status_id;


	/**
	 * The value for the discount_coupon_code_id field.
	 * @var        int
	 */
	protected $discount_coupon_code_id;


	/**
	 * The value for the discount_id field.
	 * @var        int
	 */
	protected $discount_id;


	/**
	 * The value for the order_discount field.
	 * @var        string
	 */
	protected $order_discount;


	/**
	 * The value for the hash_code field.
	 * @var        string
	 */
	protected $hash_code;


	/**
	 * The value for the payment_security_hash field.
	 * @var        string
	 */
	protected $payment_security_hash;


	/**
	 * The value for the session_hash field.
	 * @var        string
	 */
	protected $session_hash;


	/**
	 * The value for the is_confirmed field.
	 * @var        boolean
	 */
	protected $is_confirmed = false;


	/**
	 * The value for the is_marked_as_read field.
	 * @var        boolean
	 */
	protected $is_marked_as_read = true;


	/**
	 * The value for the number field.
	 * @var        string
	 */
	protected $number;


	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;


	/**
	 * The value for the order_type field.
	 * @var        string
	 */
	protected $order_type;


	/**
	 * The value for the merchant_notes field.
	 * @var        string
	 */
	protected $merchant_notes;


	/**
	 * The value for the client_culture field.
	 * @var        string
	 */
	protected $client_culture;


	/**
	 * The value for the host field.
	 * @var        string
	 */
	protected $host;


	/**
	 * The value for the opt_total_amount field.
	 * @var        double
	 */
	protected $opt_total_amount = 0;


	/**
	 * The value for the opt_is_payed field.
	 * @var        boolean
	 */
	protected $opt_is_payed;


	/**
	 * The value for the opt_client_name field.
	 * @var        string
	 */
	protected $opt_client_name;


	/**
	 * The value for the opt_client_email field.
	 * @var        string
	 */
	protected $opt_client_email;


	/**
	 * The value for the opt_client_company field.
	 * @var        string
	 */
	protected $opt_client_company;


	/**
	 * The value for the remote_address field.
	 * @var        string
	 */
	protected $remote_address;


	/**
	 * The value for the is_codes_sent field.
	 * @var        int
	 */
	protected $is_codes_sent;


	/**
	 * The value for the opt_allegro_nick field.
	 * @var        string
	 */
	protected $opt_allegro_nick;


	/**
	 * The value for the opt_allegro_checkout_form_id field.
	 * @var        string
	 */
	protected $opt_allegro_checkout_form_id;


	/**
	 * The value for the show_opinion field.
	 * @var        int
	 */
	protected $show_opinion;


	/**
	 * The value for the change_stock_on field.
	 * @var        string
	 */
	protected $change_stock_on;


	/**
	 * The value for the partner_id field.
	 * @var        int
	 */
	protected $partner_id;


	/**
	 * The value for the provision_value field.
	 * @var        double
	 */
	protected $provision_value;


	/**
	 * The value for the provision_payed field.
	 * @var        boolean
	 */
	protected $provision_payed = false;

	/**
	 * @var        OrderDelivery
	 */
	protected $aOrderDelivery;

	/**
	 * @var        sfGuardUser
	 */
	protected $asfGuardUser;

	/**
	 * @var        OrderUserDataDelivery
	 */
	protected $aOrderUserDataDelivery;

	/**
	 * @var        OrderUserDataBilling
	 */
	protected $aOrderUserDataBilling;

	/**
	 * @var        OrderCurrency
	 */
	protected $aOrderCurrency;

	/**
	 * @var        OrderStatus
	 */
	protected $aOrderStatus;

	/**
	 * @var        DiscountCouponCode
	 */
	protected $aDiscountCouponCode;

	/**
	 * @var        Discount
	 */
	protected $aDiscount;

	/**
	 * @var        Partner
	 */
	protected $aPartner;

	/**
	 * Collection to store aggregation of collPaczkomatyPacks.
	 * @var        array
	 */
	protected $collPaczkomatyPacks;

	/**
	 * The criteria used to select the current contents of collPaczkomatyPacks.
	 * @var        Criteria
	 */
	protected $lastPaczkomatyPackCriteria = null;

	/**
	 * Collection to store aggregation of collUserPointss.
	 * @var        array
	 */
	protected $collUserPointss;

	/**
	 * The criteria used to select the current contents of collUserPointss.
	 * @var        Criteria
	 */
	protected $lastUserPointsCriteria = null;

	/**
	 * Collection to store aggregation of collAllegroAuctionHasOrders.
	 * @var        array
	 */
	protected $collAllegroAuctionHasOrders;

	/**
	 * The criteria used to select the current contents of collAllegroAuctionHasOrders.
	 * @var        Criteria
	 */
	protected $lastAllegroAuctionHasOrderCriteria = null;

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
	 * Collection to store aggregation of collDiscountCouponCodes.
	 * @var        array
	 */
	protected $collDiscountCouponCodes;

	/**
	 * The criteria used to select the current contents of collDiscountCouponCodes.
	 * @var        Criteria
	 */
	protected $lastDiscountCouponCodeCriteria = null;

	/**
	 * Collection to store aggregation of collPaybynetHasOrders.
	 * @var        array
	 */
	protected $collPaybynetHasOrders;

	/**
	 * The criteria used to select the current contents of collPaybynetHasOrders.
	 * @var        Criteria
	 */
	protected $lastPaybynetHasOrderCriteria = null;

	/**
	 * Collection to store aggregation of collPocztaPolskaPunktOdbiorus.
	 * @var        array
	 */
	protected $collPocztaPolskaPunktOdbiorus;

	/**
	 * The criteria used to select the current contents of collPocztaPolskaPunktOdbiorus.
	 * @var        Criteria
	 */
	protected $lastPocztaPolskaPunktOdbioruCriteria = null;

	/**
	 * Collection to store aggregation of collPocztaPolskaPaczkas.
	 * @var        array
	 */
	protected $collPocztaPolskaPaczkas;

	/**
	 * The criteria used to select the current contents of collPocztaPolskaPaczkas.
	 * @var        Criteria
	 */
	protected $lastPocztaPolskaPaczkaCriteria = null;

	/**
	 * Collection to store aggregation of collOrderProducts.
	 * @var        array
	 */
	protected $collOrderProducts;

	/**
	 * The criteria used to select the current contents of collOrderProducts.
	 * @var        Criteria
	 */
	protected $lastOrderProductCriteria = null;

	/**
	 * Collection to store aggregation of collReviews.
	 * @var        array
	 */
	protected $collReviews;

	/**
	 * The criteria used to select the current contents of collReviews.
	 * @var        Criteria
	 */
	protected $lastReviewCriteria = null;

	/**
	 * Collection to store aggregation of collReviewOrders.
	 * @var        array
	 */
	protected $collReviewOrders;

	/**
	 * The criteria used to select the current contents of collReviewOrders.
	 * @var        Criteria
	 */
	protected $lastReviewOrderCriteria = null;

	/**
	 * Collection to store aggregation of collInvoices.
	 * @var        array
	 */
	protected $collInvoices;

	/**
	 * The criteria used to select the current contents of collInvoices.
	 * @var        Criteria
	 */
	protected $lastInvoiceCriteria = null;

	/**
	 * Collection to store aggregation of collTrustedShopsHasOrders.
	 * @var        array
	 */
	protected $collTrustedShopsHasOrders;

	/**
	 * The criteria used to select the current contents of collTrustedShopsHasOrders.
	 * @var        Criteria
	 */
	protected $lastTrustedShopsHasOrderCriteria = null;

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
     * Get the [order_delivery_id] column value.
     * 
     * @return     int
     */
    public function getOrderDeliveryId()
    {

            return $this->order_delivery_id;
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
     * Get the [order_user_data_delivery_id] column value.
     * 
     * @return     int
     */
    public function getOrderUserDataDeliveryId()
    {

            return $this->order_user_data_delivery_id;
    }

    /**
     * Get the [order_user_data_billing_id] column value.
     * 
     * @return     int
     */
    public function getOrderUserDataBillingId()
    {

            return $this->order_user_data_billing_id;
    }

    /**
     * Get the [order_currency_id] column value.
     * 
     * @return     int
     */
    public function getOrderCurrencyId()
    {

            return $this->order_currency_id;
    }

    /**
     * Get the [order_status_id] column value.
     * 
     * @return     int
     */
    public function getOrderStatusId()
    {

            return $this->order_status_id;
    }

    /**
     * Get the [discount_coupon_code_id] column value.
     * 
     * @return     int
     */
    public function getDiscountCouponCodeId()
    {

            return $this->discount_coupon_code_id;
    }

    /**
     * Get the [discount_id] column value.
     * 
     * @return     int
     */
    public function getDiscountId()
    {

            return $this->discount_id;
    }

    /**
     * Get the [order_discount] column value.
     * 
     * @return     string
     */
    public function getOrderDiscount()
    {

            return $this->order_discount;
    }

    /**
     * Get the [hash_code] column value.
     * 
     * @return     string
     */
    public function getHashCode()
    {

            return $this->hash_code;
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
     * Get the [session_hash] column value.
     * 
     * @return     string
     */
    public function getSessionHash()
    {

            return $this->session_hash;
    }

    /**
     * Get the [is_confirmed] column value.
     * 
     * @return     boolean
     */
    public function getIsConfirmed()
    {

            return $this->is_confirmed;
    }

    /**
     * Get the [is_marked_as_read] column value.
     * 
     * @return     boolean
     */
    public function getIsMarkedAsRead()
    {

            return $this->is_marked_as_read;
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
     * Get the [description] column value.
     * 
     * @return     string
     */
    public function getDescription()
    {

            return $this->description;
    }

    /**
     * Get the [order_type] column value.
     * 
     * @return     string
     */
    public function getOrderType()
    {

            return $this->order_type;
    }

    /**
     * Get the [merchant_notes] column value.
     * 
     * @return     string
     */
    public function getMerchantNotes()
    {

            return $this->merchant_notes;
    }

    /**
     * Get the [client_culture] column value.
     * 
     * @return     string
     */
    public function getClientCulture()
    {

            return $this->client_culture;
    }

    /**
     * Get the [host] column value.
     * 
     * @return     string
     */
    public function getHost()
    {

            return $this->host;
    }

    /**
     * Get the [opt_total_amount] column value.
     * 
     * @return     double
     */
    public function getOptTotalAmount()
    {

            return null !== $this->opt_total_amount ? (string)$this->opt_total_amount : null;
    }

    /**
     * Get the [opt_is_payed] column value.
     * 
     * @return     boolean
     */
    public function getOptIsPayed()
    {

            return $this->opt_is_payed;
    }

    /**
     * Get the [opt_client_name] column value.
     * 
     * @return     string
     */
    public function getOptClientName()
    {

            return $this->opt_client_name;
    }

    /**
     * Get the [opt_client_email] column value.
     * 
     * @return     string
     */
    public function getOptClientEmail()
    {

            return $this->opt_client_email;
    }

    /**
     * Get the [opt_client_company] column value.
     * 
     * @return     string
     */
    public function getOptClientCompany()
    {

            return $this->opt_client_company;
    }

    /**
     * Get the [remote_address] column value.
     * 
     * @return     string
     */
    public function getRemoteAddress()
    {

            return $this->remote_address;
    }

    /**
     * Get the [is_codes_sent] column value.
     * 
     * @return     int
     */
    public function getIsCodesSent()
    {

            return $this->is_codes_sent;
    }

    /**
     * Get the [opt_allegro_nick] column value.
     * 
     * @return     string
     */
    public function getOptAllegroNick()
    {

            return $this->opt_allegro_nick;
    }

    /**
     * Get the [opt_allegro_checkout_form_id] column value.
     * 
     * @return     string
     */
    public function getOptAllegroCheckoutFormId()
    {

            return $this->opt_allegro_checkout_form_id;
    }

    /**
     * Get the [show_opinion] column value.
     * 
     * @return     int
     */
    public function getShowOpinion()
    {

            return $this->show_opinion;
    }

    /**
     * Get the [change_stock_on] column value.
     * 
     * @return     string
     */
    public function getChangeStockOn()
    {

            return $this->change_stock_on;
    }

    /**
     * Get the [partner_id] column value.
     * 
     * @return     int
     */
    public function getPartnerId()
    {

            return $this->partner_id;
    }

    /**
     * Get the [provision_value] column value.
     * 
     * @return     double
     */
    public function getProvisionValue()
    {

            return $this->provision_value;
    }

    /**
     * Get the [provision_payed] column value.
     * 
     * @return     boolean
     */
    public function getProvisionPayed()
    {

            return $this->provision_payed;
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
			$this->modifiedColumns[] = OrderPeer::CREATED_AT;
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
			$this->modifiedColumns[] = OrderPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = OrderPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [order_delivery_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOrderDeliveryId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->order_delivery_id !== $v) {
          $this->order_delivery_id = $v;
          $this->modifiedColumns[] = OrderPeer::ORDER_DELIVERY_ID;
        }

		if ($this->aOrderDelivery !== null && $this->aOrderDelivery->getId() !== $v) {
			$this->aOrderDelivery = null;
		}

	} // setOrderDeliveryId()

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
          $this->modifiedColumns[] = OrderPeer::SF_GUARD_USER_ID;
        }

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} // setSfGuardUserId()

	/**
	 * Set the value of [order_user_data_delivery_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOrderUserDataDeliveryId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->order_user_data_delivery_id !== $v) {
          $this->order_user_data_delivery_id = $v;
          $this->modifiedColumns[] = OrderPeer::ORDER_USER_DATA_DELIVERY_ID;
        }

		if ($this->aOrderUserDataDelivery !== null && $this->aOrderUserDataDelivery->getId() !== $v) {
			$this->aOrderUserDataDelivery = null;
		}

	} // setOrderUserDataDeliveryId()

	/**
	 * Set the value of [order_user_data_billing_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOrderUserDataBillingId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->order_user_data_billing_id !== $v) {
          $this->order_user_data_billing_id = $v;
          $this->modifiedColumns[] = OrderPeer::ORDER_USER_DATA_BILLING_ID;
        }

		if ($this->aOrderUserDataBilling !== null && $this->aOrderUserDataBilling->getId() !== $v) {
			$this->aOrderUserDataBilling = null;
		}

	} // setOrderUserDataBillingId()

	/**
	 * Set the value of [order_currency_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOrderCurrencyId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->order_currency_id !== $v) {
          $this->order_currency_id = $v;
          $this->modifiedColumns[] = OrderPeer::ORDER_CURRENCY_ID;
        }

		if ($this->aOrderCurrency !== null && $this->aOrderCurrency->getId() !== $v) {
			$this->aOrderCurrency = null;
		}

	} // setOrderCurrencyId()

	/**
	 * Set the value of [order_status_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOrderStatusId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->order_status_id !== $v) {
          $this->order_status_id = $v;
          $this->modifiedColumns[] = OrderPeer::ORDER_STATUS_ID;
        }

		if ($this->aOrderStatus !== null && $this->aOrderStatus->getId() !== $v) {
			$this->aOrderStatus = null;
		}

	} // setOrderStatusId()

	/**
	 * Set the value of [discount_coupon_code_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setDiscountCouponCodeId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->discount_coupon_code_id !== $v) {
          $this->discount_coupon_code_id = $v;
          $this->modifiedColumns[] = OrderPeer::DISCOUNT_COUPON_CODE_ID;
        }

		if ($this->aDiscountCouponCode !== null && $this->aDiscountCouponCode->getId() !== $v) {
			$this->aDiscountCouponCode = null;
		}

	} // setDiscountCouponCodeId()

	/**
	 * Set the value of [discount_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setDiscountId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->discount_id !== $v) {
          $this->discount_id = $v;
          $this->modifiedColumns[] = OrderPeer::DISCOUNT_ID;
        }

		if ($this->aDiscount !== null && $this->aDiscount->getId() !== $v) {
			$this->aDiscount = null;
		}

	} // setDiscountId()

	/**
	 * Set the value of [order_discount] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOrderDiscount($v)
	{

        if ($this->order_discount !== $v) {
          $this->order_discount = $v;
          $this->modifiedColumns[] = OrderPeer::ORDER_DISCOUNT;
        }

	} // setOrderDiscount()

	/**
	 * Set the value of [hash_code] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setHashCode($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->hash_code !== $v) {
          $this->hash_code = $v;
          $this->modifiedColumns[] = OrderPeer::HASH_CODE;
        }

	} // setHashCode()

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
          $this->modifiedColumns[] = OrderPeer::PAYMENT_SECURITY_HASH;
        }

	} // setPaymentSecurityHash()

	/**
	 * Set the value of [session_hash] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setSessionHash($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->session_hash !== $v) {
          $this->session_hash = $v;
          $this->modifiedColumns[] = OrderPeer::SESSION_HASH;
        }

	} // setSessionHash()

	/**
	 * Set the value of [is_confirmed] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsConfirmed($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_confirmed !== $v || $v === false) {
          $this->is_confirmed = $v;
          $this->modifiedColumns[] = OrderPeer::IS_CONFIRMED;
        }

	} // setIsConfirmed()

	/**
	 * Set the value of [is_marked_as_read] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsMarkedAsRead($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_marked_as_read !== $v || $v === true) {
          $this->is_marked_as_read = $v;
          $this->modifiedColumns[] = OrderPeer::IS_MARKED_AS_READ;
        }

	} // setIsMarkedAsRead()

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
          $this->modifiedColumns[] = OrderPeer::NUMBER;
        }

	} // setNumber()

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
          $this->modifiedColumns[] = OrderPeer::DESCRIPTION;
        }

	} // setDescription()

	/**
	 * Set the value of [order_type] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOrderType($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->order_type !== $v) {
          $this->order_type = $v;
          $this->modifiedColumns[] = OrderPeer::ORDER_TYPE;
        }

	} // setOrderType()

	/**
	 * Set the value of [merchant_notes] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setMerchantNotes($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->merchant_notes !== $v) {
          $this->merchant_notes = $v;
          $this->modifiedColumns[] = OrderPeer::MERCHANT_NOTES;
        }

	} // setMerchantNotes()

	/**
	 * Set the value of [client_culture] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setClientCulture($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->client_culture !== $v) {
          $this->client_culture = $v;
          $this->modifiedColumns[] = OrderPeer::CLIENT_CULTURE;
        }

	} // setClientCulture()

	/**
	 * Set the value of [host] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setHost($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->host !== $v) {
          $this->host = $v;
          $this->modifiedColumns[] = OrderPeer::HOST;
        }

	} // setHost()

	/**
	 * Set the value of [opt_total_amount] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOptTotalAmount($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->opt_total_amount !== $v || $v === 0) {
          $this->opt_total_amount = $v;
          $this->modifiedColumns[] = OrderPeer::OPT_TOTAL_AMOUNT;
        }

	} // setOptTotalAmount()

	/**
	 * Set the value of [opt_is_payed] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setOptIsPayed($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->opt_is_payed !== $v) {
          $this->opt_is_payed = $v;
          $this->modifiedColumns[] = OrderPeer::OPT_IS_PAYED;
        }

	} // setOptIsPayed()

	/**
	 * Set the value of [opt_client_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptClientName($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_client_name !== $v) {
          $this->opt_client_name = $v;
          $this->modifiedColumns[] = OrderPeer::OPT_CLIENT_NAME;
        }

	} // setOptClientName()

	/**
	 * Set the value of [opt_client_email] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptClientEmail($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_client_email !== $v) {
          $this->opt_client_email = $v;
          $this->modifiedColumns[] = OrderPeer::OPT_CLIENT_EMAIL;
        }

	} // setOptClientEmail()

	/**
	 * Set the value of [opt_client_company] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptClientCompany($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_client_company !== $v) {
          $this->opt_client_company = $v;
          $this->modifiedColumns[] = OrderPeer::OPT_CLIENT_COMPANY;
        }

	} // setOptClientCompany()

	/**
	 * Set the value of [remote_address] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setRemoteAddress($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->remote_address !== $v) {
          $this->remote_address = $v;
          $this->modifiedColumns[] = OrderPeer::REMOTE_ADDRESS;
        }

	} // setRemoteAddress()

	/**
	 * Set the value of [is_codes_sent] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setIsCodesSent($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->is_codes_sent !== $v) {
          $this->is_codes_sent = $v;
          $this->modifiedColumns[] = OrderPeer::IS_CODES_SENT;
        }

	} // setIsCodesSent()

	/**
	 * Set the value of [opt_allegro_nick] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptAllegroNick($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_allegro_nick !== $v) {
          $this->opt_allegro_nick = $v;
          $this->modifiedColumns[] = OrderPeer::OPT_ALLEGRO_NICK;
        }

	} // setOptAllegroNick()

	/**
	 * Set the value of [opt_allegro_checkout_form_id] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptAllegroCheckoutFormId($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_allegro_checkout_form_id !== $v) {
          $this->opt_allegro_checkout_form_id = $v;
          $this->modifiedColumns[] = OrderPeer::OPT_ALLEGRO_CHECKOUT_FORM_ID;
        }

	} // setOptAllegroCheckoutFormId()

	/**
	 * Set the value of [show_opinion] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setShowOpinion($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->show_opinion !== $v) {
          $this->show_opinion = $v;
          $this->modifiedColumns[] = OrderPeer::SHOW_OPINION;
        }

	} // setShowOpinion()

	/**
	 * Set the value of [change_stock_on] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setChangeStockOn($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->change_stock_on !== $v) {
          $this->change_stock_on = $v;
          $this->modifiedColumns[] = OrderPeer::CHANGE_STOCK_ON;
        }

	} // setChangeStockOn()

	/**
	 * Set the value of [partner_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPartnerId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->partner_id !== $v) {
          $this->partner_id = $v;
          $this->modifiedColumns[] = OrderPeer::PARTNER_ID;
        }

		if ($this->aPartner !== null && $this->aPartner->getId() !== $v) {
			$this->aPartner = null;
		}

	} // setPartnerId()

	/**
	 * Set the value of [provision_value] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setProvisionValue($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->provision_value !== $v) {
          $this->provision_value = $v;
          $this->modifiedColumns[] = OrderPeer::PROVISION_VALUE;
        }

	} // setProvisionValue()

	/**
	 * Set the value of [provision_payed] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setProvisionPayed($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->provision_payed !== $v || $v === false) {
          $this->provision_payed = $v;
          $this->modifiedColumns[] = OrderPeer::PROVISION_PAYED;
        }

	} // setProvisionPayed()

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
      if ($this->getDispatcher()->getListeners('Order.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Order.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->order_delivery_id = $rs->getInt($startcol + 3);

      $this->sf_guard_user_id = $rs->getInt($startcol + 4);

      $this->order_user_data_delivery_id = $rs->getInt($startcol + 5);

      $this->order_user_data_billing_id = $rs->getInt($startcol + 6);

      $this->order_currency_id = $rs->getInt($startcol + 7);

      $this->order_status_id = $rs->getInt($startcol + 8);

      $this->discount_coupon_code_id = $rs->getInt($startcol + 9);

      $this->discount_id = $rs->getInt($startcol + 10);

      $this->order_discount = $rs->getString($startcol + 11) ? unserialize($rs->getString($startcol + 11)) : null;

      $this->hash_code = $rs->getString($startcol + 12);

      $this->payment_security_hash = $rs->getString($startcol + 13);

      $this->session_hash = $rs->getString($startcol + 14);

      $this->is_confirmed = $rs->getBoolean($startcol + 15);

      $this->is_marked_as_read = $rs->getBoolean($startcol + 16);

      $this->number = $rs->getString($startcol + 17);

      $this->description = $rs->getString($startcol + 18);

      $this->order_type = $rs->getString($startcol + 19);

      $this->merchant_notes = $rs->getString($startcol + 20);

      $this->client_culture = $rs->getString($startcol + 21);

      $this->host = $rs->getString($startcol + 22);

      $this->opt_total_amount = $rs->getString($startcol + 23);
      if (null !== $this->opt_total_amount && $this->opt_total_amount == intval($this->opt_total_amount))
      {
        $this->opt_total_amount = (string)intval($this->opt_total_amount);
      }

      $this->opt_is_payed = $rs->getBoolean($startcol + 24);

      $this->opt_client_name = $rs->getString($startcol + 25);

      $this->opt_client_email = $rs->getString($startcol + 26);

      $this->opt_client_company = $rs->getString($startcol + 27);

      $this->remote_address = $rs->getString($startcol + 28);

      $this->is_codes_sent = $rs->getInt($startcol + 29);

      $this->opt_allegro_nick = $rs->getString($startcol + 30);

      $this->opt_allegro_checkout_form_id = $rs->getString($startcol + 31);

      $this->show_opinion = $rs->getInt($startcol + 32);

      $this->change_stock_on = $rs->getString($startcol + 33);

      $this->partner_id = $rs->getInt($startcol + 34);

      $this->provision_value = $rs->getFloat($startcol + 35);

      $this->provision_payed = $rs->getBoolean($startcol + 36);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Order.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Order.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 37)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 37; // 37 = OrderPeer::NUM_COLUMNS - OrderPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Order object", $e);
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

    if ($this->getDispatcher()->getListeners('Order.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Order.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseOrder:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseOrder:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(OrderPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      OrderPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Order.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Order.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseOrder:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseOrder:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Order.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Order.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseOrder:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(OrderPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(OrderPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(OrderPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Order.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Order.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseOrder:save:post') as $callable)
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

			if ($this->aOrderDelivery !== null) {
				if ($this->aOrderDelivery->isModified()) {
					$affectedRows += $this->aOrderDelivery->save($con);
				}
				$this->setOrderDelivery($this->aOrderDelivery);
			}

			if ($this->asfGuardUser !== null) {
				if ($this->asfGuardUser->isModified()) {
					$affectedRows += $this->asfGuardUser->save($con);
				}
				$this->setsfGuardUser($this->asfGuardUser);
			}

			if ($this->aOrderUserDataDelivery !== null) {
				if ($this->aOrderUserDataDelivery->isModified()) {
					$affectedRows += $this->aOrderUserDataDelivery->save($con);
				}
				$this->setOrderUserDataDelivery($this->aOrderUserDataDelivery);
			}

			if ($this->aOrderUserDataBilling !== null) {
				if ($this->aOrderUserDataBilling->isModified()) {
					$affectedRows += $this->aOrderUserDataBilling->save($con);
				}
				$this->setOrderUserDataBilling($this->aOrderUserDataBilling);
			}

			if ($this->aOrderCurrency !== null) {
				if ($this->aOrderCurrency->isModified()) {
					$affectedRows += $this->aOrderCurrency->save($con);
				}
				$this->setOrderCurrency($this->aOrderCurrency);
			}

			if ($this->aOrderStatus !== null) {
				if ($this->aOrderStatus->isModified() || $this->aOrderStatus->getCurrentOrderStatusI18n()->isModified()) {
					$affectedRows += $this->aOrderStatus->save($con);
				}
				$this->setOrderStatus($this->aOrderStatus);
			}

			if ($this->aDiscountCouponCode !== null) {
				if ($this->aDiscountCouponCode->isModified()) {
					$affectedRows += $this->aDiscountCouponCode->save($con);
				}
				$this->setDiscountCouponCode($this->aDiscountCouponCode);
			}

			if ($this->aDiscount !== null) {
				if ($this->aDiscount->isModified()) {
					$affectedRows += $this->aDiscount->save($con);
				}
				$this->setDiscount($this->aDiscount);
			}

			if ($this->aPartner !== null) {
				if ($this->aPartner->isModified()) {
					$affectedRows += $this->aPartner->save($con);
				}
				$this->setPartner($this->aPartner);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
              $o_order_discount = $this->order_discount;
              if (null !== $this->order_discount && $this->isColumnModified(OrderPeer::ORDER_DISCOUNT)) {
                  $this->order_discount = serialize($this->order_discount);
              }

				if ($this->isNew()) {
					$pk = OrderPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += OrderPeer::doUpdate($this, $con);
				}
				$this->resetModified();
             $this->order_discount = $o_order_discount;
 // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPaczkomatyPacks !== null) {
				foreach($this->collPaczkomatyPacks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserPointss !== null) {
				foreach($this->collUserPointss as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAllegroAuctionHasOrders !== null) {
				foreach($this->collAllegroAuctionHasOrders as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOrderHasPayments !== null) {
				foreach($this->collOrderHasPayments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDiscountCouponCodes !== null) {
				foreach($this->collDiscountCouponCodes as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPaybynetHasOrders !== null) {
				foreach($this->collPaybynetHasOrders as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPocztaPolskaPunktOdbiorus !== null) {
				foreach($this->collPocztaPolskaPunktOdbiorus as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPocztaPolskaPaczkas !== null) {
				foreach($this->collPocztaPolskaPaczkas as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOrderProducts !== null) {
				foreach($this->collOrderProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collReviews !== null) {
				foreach($this->collReviews as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collReviewOrders !== null) {
				foreach($this->collReviewOrders as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collInvoices !== null) {
				foreach($this->collInvoices as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTrustedShopsHasOrders !== null) {
				foreach($this->collTrustedShopsHasOrders as $referrerFK) {
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

			if ($this->aOrderDelivery !== null) {
				if (!$this->aOrderDelivery->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOrderDelivery->getValidationFailures());
				}
			}

			if ($this->asfGuardUser !== null) {
				if (!$this->asfGuardUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUser->getValidationFailures());
				}
			}

			if ($this->aOrderUserDataDelivery !== null) {
				if (!$this->aOrderUserDataDelivery->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOrderUserDataDelivery->getValidationFailures());
				}
			}

			if ($this->aOrderUserDataBilling !== null) {
				if (!$this->aOrderUserDataBilling->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOrderUserDataBilling->getValidationFailures());
				}
			}

			if ($this->aOrderCurrency !== null) {
				if (!$this->aOrderCurrency->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOrderCurrency->getValidationFailures());
				}
			}

			if ($this->aOrderStatus !== null) {
				if (!$this->aOrderStatus->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOrderStatus->getValidationFailures());
				}
			}

			if ($this->aDiscountCouponCode !== null) {
				if (!$this->aDiscountCouponCode->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDiscountCouponCode->getValidationFailures());
				}
			}

			if ($this->aDiscount !== null) {
				if (!$this->aDiscount->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDiscount->getValidationFailures());
				}
			}

			if ($this->aPartner !== null) {
				if (!$this->aPartner->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPartner->getValidationFailures());
				}
			}


			if (($retval = OrderPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPaczkomatyPacks !== null) {
					foreach($this->collPaczkomatyPacks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserPointss !== null) {
					foreach($this->collUserPointss as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAllegroAuctionHasOrders !== null) {
					foreach($this->collAllegroAuctionHasOrders as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOrderHasPayments !== null) {
					foreach($this->collOrderHasPayments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDiscountCouponCodes !== null) {
					foreach($this->collDiscountCouponCodes as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPaybynetHasOrders !== null) {
					foreach($this->collPaybynetHasOrders as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPocztaPolskaPunktOdbiorus !== null) {
					foreach($this->collPocztaPolskaPunktOdbiorus as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPocztaPolskaPaczkas !== null) {
					foreach($this->collPocztaPolskaPaczkas as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOrderProducts !== null) {
					foreach($this->collOrderProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collReviews !== null) {
					foreach($this->collReviews as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collReviewOrders !== null) {
					foreach($this->collReviewOrders as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collInvoices !== null) {
					foreach($this->collInvoices as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTrustedShopsHasOrders !== null) {
					foreach($this->collTrustedShopsHasOrders as $referrerFK) {
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
		$pos = OrderPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getOrderDeliveryId();
				break;
			case 4:
				return $this->getSfGuardUserId();
				break;
			case 5:
				return $this->getOrderUserDataDeliveryId();
				break;
			case 6:
				return $this->getOrderUserDataBillingId();
				break;
			case 7:
				return $this->getOrderCurrencyId();
				break;
			case 8:
				return $this->getOrderStatusId();
				break;
			case 9:
				return $this->getDiscountCouponCodeId();
				break;
			case 10:
				return $this->getDiscountId();
				break;
			case 11:
				return $this->getOrderDiscount();
				break;
			case 12:
				return $this->getHashCode();
				break;
			case 13:
				return $this->getPaymentSecurityHash();
				break;
			case 14:
				return $this->getSessionHash();
				break;
			case 15:
				return $this->getIsConfirmed();
				break;
			case 16:
				return $this->getIsMarkedAsRead();
				break;
			case 17:
				return $this->getNumber();
				break;
			case 18:
				return $this->getDescription();
				break;
			case 19:
				return $this->getOrderType();
				break;
			case 20:
				return $this->getMerchantNotes();
				break;
			case 21:
				return $this->getClientCulture();
				break;
			case 22:
				return $this->getHost();
				break;
			case 23:
				return $this->getOptTotalAmount();
				break;
			case 24:
				return $this->getOptIsPayed();
				break;
			case 25:
				return $this->getOptClientName();
				break;
			case 26:
				return $this->getOptClientEmail();
				break;
			case 27:
				return $this->getOptClientCompany();
				break;
			case 28:
				return $this->getRemoteAddress();
				break;
			case 29:
				return $this->getIsCodesSent();
				break;
			case 30:
				return $this->getOptAllegroNick();
				break;
			case 31:
				return $this->getOptAllegroCheckoutFormId();
				break;
			case 32:
				return $this->getShowOpinion();
				break;
			case 33:
				return $this->getChangeStockOn();
				break;
			case 34:
				return $this->getPartnerId();
				break;
			case 35:
				return $this->getProvisionValue();
				break;
			case 36:
				return $this->getProvisionPayed();
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
		$keys = OrderPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getOrderDeliveryId(),
			$keys[4] => $this->getSfGuardUserId(),
			$keys[5] => $this->getOrderUserDataDeliveryId(),
			$keys[6] => $this->getOrderUserDataBillingId(),
			$keys[7] => $this->getOrderCurrencyId(),
			$keys[8] => $this->getOrderStatusId(),
			$keys[9] => $this->getDiscountCouponCodeId(),
			$keys[10] => $this->getDiscountId(),
			$keys[11] => $this->getOrderDiscount(),
			$keys[12] => $this->getHashCode(),
			$keys[13] => $this->getPaymentSecurityHash(),
			$keys[14] => $this->getSessionHash(),
			$keys[15] => $this->getIsConfirmed(),
			$keys[16] => $this->getIsMarkedAsRead(),
			$keys[17] => $this->getNumber(),
			$keys[18] => $this->getDescription(),
			$keys[19] => $this->getOrderType(),
			$keys[20] => $this->getMerchantNotes(),
			$keys[21] => $this->getClientCulture(),
			$keys[22] => $this->getHost(),
			$keys[23] => $this->getOptTotalAmount(),
			$keys[24] => $this->getOptIsPayed(),
			$keys[25] => $this->getOptClientName(),
			$keys[26] => $this->getOptClientEmail(),
			$keys[27] => $this->getOptClientCompany(),
			$keys[28] => $this->getRemoteAddress(),
			$keys[29] => $this->getIsCodesSent(),
			$keys[30] => $this->getOptAllegroNick(),
			$keys[31] => $this->getOptAllegroCheckoutFormId(),
			$keys[32] => $this->getShowOpinion(),
			$keys[33] => $this->getChangeStockOn(),
			$keys[34] => $this->getPartnerId(),
			$keys[35] => $this->getProvisionValue(),
			$keys[36] => $this->getProvisionPayed(),
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
		$pos = OrderPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setOrderDeliveryId($value);
				break;
			case 4:
				$this->setSfGuardUserId($value);
				break;
			case 5:
				$this->setOrderUserDataDeliveryId($value);
				break;
			case 6:
				$this->setOrderUserDataBillingId($value);
				break;
			case 7:
				$this->setOrderCurrencyId($value);
				break;
			case 8:
				$this->setOrderStatusId($value);
				break;
			case 9:
				$this->setDiscountCouponCodeId($value);
				break;
			case 10:
				$this->setDiscountId($value);
				break;
			case 11:
				$this->setOrderDiscount($value);
				break;
			case 12:
				$this->setHashCode($value);
				break;
			case 13:
				$this->setPaymentSecurityHash($value);
				break;
			case 14:
				$this->setSessionHash($value);
				break;
			case 15:
				$this->setIsConfirmed($value);
				break;
			case 16:
				$this->setIsMarkedAsRead($value);
				break;
			case 17:
				$this->setNumber($value);
				break;
			case 18:
				$this->setDescription($value);
				break;
			case 19:
				$this->setOrderType($value);
				break;
			case 20:
				$this->setMerchantNotes($value);
				break;
			case 21:
				$this->setClientCulture($value);
				break;
			case 22:
				$this->setHost($value);
				break;
			case 23:
				$this->setOptTotalAmount($value);
				break;
			case 24:
				$this->setOptIsPayed($value);
				break;
			case 25:
				$this->setOptClientName($value);
				break;
			case 26:
				$this->setOptClientEmail($value);
				break;
			case 27:
				$this->setOptClientCompany($value);
				break;
			case 28:
				$this->setRemoteAddress($value);
				break;
			case 29:
				$this->setIsCodesSent($value);
				break;
			case 30:
				$this->setOptAllegroNick($value);
				break;
			case 31:
				$this->setOptAllegroCheckoutFormId($value);
				break;
			case 32:
				$this->setShowOpinion($value);
				break;
			case 33:
				$this->setChangeStockOn($value);
				break;
			case 34:
				$this->setPartnerId($value);
				break;
			case 35:
				$this->setProvisionValue($value);
				break;
			case 36:
				$this->setProvisionPayed($value);
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
		$keys = OrderPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setOrderDeliveryId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSfGuardUserId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOrderUserDataDeliveryId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setOrderUserDataBillingId($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setOrderCurrencyId($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setOrderStatusId($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setDiscountCouponCodeId($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setDiscountId($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setOrderDiscount($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setHashCode($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setPaymentSecurityHash($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setSessionHash($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setIsConfirmed($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setIsMarkedAsRead($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setNumber($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setDescription($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setOrderType($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setMerchantNotes($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setClientCulture($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setHost($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setOptTotalAmount($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setOptIsPayed($arr[$keys[24]]);
		if (array_key_exists($keys[25], $arr)) $this->setOptClientName($arr[$keys[25]]);
		if (array_key_exists($keys[26], $arr)) $this->setOptClientEmail($arr[$keys[26]]);
		if (array_key_exists($keys[27], $arr)) $this->setOptClientCompany($arr[$keys[27]]);
		if (array_key_exists($keys[28], $arr)) $this->setRemoteAddress($arr[$keys[28]]);
		if (array_key_exists($keys[29], $arr)) $this->setIsCodesSent($arr[$keys[29]]);
		if (array_key_exists($keys[30], $arr)) $this->setOptAllegroNick($arr[$keys[30]]);
		if (array_key_exists($keys[31], $arr)) $this->setOptAllegroCheckoutFormId($arr[$keys[31]]);
		if (array_key_exists($keys[32], $arr)) $this->setShowOpinion($arr[$keys[32]]);
		if (array_key_exists($keys[33], $arr)) $this->setChangeStockOn($arr[$keys[33]]);
		if (array_key_exists($keys[34], $arr)) $this->setPartnerId($arr[$keys[34]]);
		if (array_key_exists($keys[35], $arr)) $this->setProvisionValue($arr[$keys[35]]);
		if (array_key_exists($keys[36], $arr)) $this->setProvisionPayed($arr[$keys[36]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(OrderPeer::DATABASE_NAME);

		if ($this->isColumnModified(OrderPeer::CREATED_AT)) $criteria->add(OrderPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(OrderPeer::UPDATED_AT)) $criteria->add(OrderPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(OrderPeer::ID)) $criteria->add(OrderPeer::ID, $this->id);
		if ($this->isColumnModified(OrderPeer::ORDER_DELIVERY_ID)) $criteria->add(OrderPeer::ORDER_DELIVERY_ID, $this->order_delivery_id);
		if ($this->isColumnModified(OrderPeer::SF_GUARD_USER_ID)) $criteria->add(OrderPeer::SF_GUARD_USER_ID, $this->sf_guard_user_id);
		if ($this->isColumnModified(OrderPeer::ORDER_USER_DATA_DELIVERY_ID)) $criteria->add(OrderPeer::ORDER_USER_DATA_DELIVERY_ID, $this->order_user_data_delivery_id);
		if ($this->isColumnModified(OrderPeer::ORDER_USER_DATA_BILLING_ID)) $criteria->add(OrderPeer::ORDER_USER_DATA_BILLING_ID, $this->order_user_data_billing_id);
		if ($this->isColumnModified(OrderPeer::ORDER_CURRENCY_ID)) $criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->order_currency_id);
		if ($this->isColumnModified(OrderPeer::ORDER_STATUS_ID)) $criteria->add(OrderPeer::ORDER_STATUS_ID, $this->order_status_id);
		if ($this->isColumnModified(OrderPeer::DISCOUNT_COUPON_CODE_ID)) $criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->discount_coupon_code_id);
		if ($this->isColumnModified(OrderPeer::DISCOUNT_ID)) $criteria->add(OrderPeer::DISCOUNT_ID, $this->discount_id);
		if ($this->isColumnModified(OrderPeer::ORDER_DISCOUNT)) $criteria->add(OrderPeer::ORDER_DISCOUNT, $this->order_discount);
		if ($this->isColumnModified(OrderPeer::HASH_CODE)) $criteria->add(OrderPeer::HASH_CODE, $this->hash_code);
		if ($this->isColumnModified(OrderPeer::PAYMENT_SECURITY_HASH)) $criteria->add(OrderPeer::PAYMENT_SECURITY_HASH, $this->payment_security_hash);
		if ($this->isColumnModified(OrderPeer::SESSION_HASH)) $criteria->add(OrderPeer::SESSION_HASH, $this->session_hash);
		if ($this->isColumnModified(OrderPeer::IS_CONFIRMED)) $criteria->add(OrderPeer::IS_CONFIRMED, $this->is_confirmed);
		if ($this->isColumnModified(OrderPeer::IS_MARKED_AS_READ)) $criteria->add(OrderPeer::IS_MARKED_AS_READ, $this->is_marked_as_read);
		if ($this->isColumnModified(OrderPeer::NUMBER)) $criteria->add(OrderPeer::NUMBER, $this->number);
		if ($this->isColumnModified(OrderPeer::DESCRIPTION)) $criteria->add(OrderPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(OrderPeer::ORDER_TYPE)) $criteria->add(OrderPeer::ORDER_TYPE, $this->order_type);
		if ($this->isColumnModified(OrderPeer::MERCHANT_NOTES)) $criteria->add(OrderPeer::MERCHANT_NOTES, $this->merchant_notes);
		if ($this->isColumnModified(OrderPeer::CLIENT_CULTURE)) $criteria->add(OrderPeer::CLIENT_CULTURE, $this->client_culture);
		if ($this->isColumnModified(OrderPeer::HOST)) $criteria->add(OrderPeer::HOST, $this->host);
		if ($this->isColumnModified(OrderPeer::OPT_TOTAL_AMOUNT)) $criteria->add(OrderPeer::OPT_TOTAL_AMOUNT, $this->opt_total_amount);
		if ($this->isColumnModified(OrderPeer::OPT_IS_PAYED)) $criteria->add(OrderPeer::OPT_IS_PAYED, $this->opt_is_payed);
		if ($this->isColumnModified(OrderPeer::OPT_CLIENT_NAME)) $criteria->add(OrderPeer::OPT_CLIENT_NAME, $this->opt_client_name);
		if ($this->isColumnModified(OrderPeer::OPT_CLIENT_EMAIL)) $criteria->add(OrderPeer::OPT_CLIENT_EMAIL, $this->opt_client_email);
		if ($this->isColumnModified(OrderPeer::OPT_CLIENT_COMPANY)) $criteria->add(OrderPeer::OPT_CLIENT_COMPANY, $this->opt_client_company);
		if ($this->isColumnModified(OrderPeer::REMOTE_ADDRESS)) $criteria->add(OrderPeer::REMOTE_ADDRESS, $this->remote_address);
		if ($this->isColumnModified(OrderPeer::IS_CODES_SENT)) $criteria->add(OrderPeer::IS_CODES_SENT, $this->is_codes_sent);
		if ($this->isColumnModified(OrderPeer::OPT_ALLEGRO_NICK)) $criteria->add(OrderPeer::OPT_ALLEGRO_NICK, $this->opt_allegro_nick);
		if ($this->isColumnModified(OrderPeer::OPT_ALLEGRO_CHECKOUT_FORM_ID)) $criteria->add(OrderPeer::OPT_ALLEGRO_CHECKOUT_FORM_ID, $this->opt_allegro_checkout_form_id);
		if ($this->isColumnModified(OrderPeer::SHOW_OPINION)) $criteria->add(OrderPeer::SHOW_OPINION, $this->show_opinion);
		if ($this->isColumnModified(OrderPeer::CHANGE_STOCK_ON)) $criteria->add(OrderPeer::CHANGE_STOCK_ON, $this->change_stock_on);
		if ($this->isColumnModified(OrderPeer::PARTNER_ID)) $criteria->add(OrderPeer::PARTNER_ID, $this->partner_id);
		if ($this->isColumnModified(OrderPeer::PROVISION_VALUE)) $criteria->add(OrderPeer::PROVISION_VALUE, $this->provision_value);
		if ($this->isColumnModified(OrderPeer::PROVISION_PAYED)) $criteria->add(OrderPeer::PROVISION_PAYED, $this->provision_payed);

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
		$criteria = new Criteria(OrderPeer::DATABASE_NAME);

		$criteria->add(OrderPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Order (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setOrderDeliveryId($this->order_delivery_id);

		$copyObj->setSfGuardUserId($this->sf_guard_user_id);

		$copyObj->setOrderUserDataDeliveryId($this->order_user_data_delivery_id);

		$copyObj->setOrderUserDataBillingId($this->order_user_data_billing_id);

		$copyObj->setOrderCurrencyId($this->order_currency_id);

		$copyObj->setOrderStatusId($this->order_status_id);

		$copyObj->setDiscountCouponCodeId($this->discount_coupon_code_id);

		$copyObj->setDiscountId($this->discount_id);

		$copyObj->setOrderDiscount($this->order_discount);

		$copyObj->setHashCode($this->hash_code);

		$copyObj->setPaymentSecurityHash($this->payment_security_hash);

		$copyObj->setSessionHash($this->session_hash);

		$copyObj->setIsConfirmed($this->is_confirmed);

		$copyObj->setIsMarkedAsRead($this->is_marked_as_read);

		$copyObj->setNumber($this->number);

		$copyObj->setDescription($this->description);

		$copyObj->setOrderType($this->order_type);

		$copyObj->setMerchantNotes($this->merchant_notes);

		$copyObj->setClientCulture($this->client_culture);

		$copyObj->setHost($this->host);

		$copyObj->setOptTotalAmount($this->opt_total_amount);

		$copyObj->setOptIsPayed($this->opt_is_payed);

		$copyObj->setOptClientName($this->opt_client_name);

		$copyObj->setOptClientEmail($this->opt_client_email);

		$copyObj->setOptClientCompany($this->opt_client_company);

		$copyObj->setRemoteAddress($this->remote_address);

		$copyObj->setIsCodesSent($this->is_codes_sent);

		$copyObj->setOptAllegroNick($this->opt_allegro_nick);

		$copyObj->setOptAllegroCheckoutFormId($this->opt_allegro_checkout_form_id);

		$copyObj->setShowOpinion($this->show_opinion);

		$copyObj->setChangeStockOn($this->change_stock_on);

		$copyObj->setPartnerId($this->partner_id);

		$copyObj->setProvisionValue($this->provision_value);

		$copyObj->setProvisionPayed($this->provision_payed);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getPaczkomatyPacks() as $relObj) {
				$copyObj->addPaczkomatyPack($relObj->copy($deepCopy));
			}

			foreach($this->getUserPointss() as $relObj) {
				$copyObj->addUserPoints($relObj->copy($deepCopy));
			}

			foreach($this->getAllegroAuctionHasOrders() as $relObj) {
				$copyObj->addAllegroAuctionHasOrder($relObj->copy($deepCopy));
			}

			foreach($this->getOrderHasPayments() as $relObj) {
				$copyObj->addOrderHasPayment($relObj->copy($deepCopy));
			}

			foreach($this->getDiscountCouponCodes() as $relObj) {
				$copyObj->addDiscountCouponCode($relObj->copy($deepCopy));
			}

			foreach($this->getPaybynetHasOrders() as $relObj) {
				$copyObj->addPaybynetHasOrder($relObj->copy($deepCopy));
			}

			foreach($this->getPocztaPolskaPunktOdbiorus() as $relObj) {
				$copyObj->addPocztaPolskaPunktOdbioru($relObj->copy($deepCopy));
			}

			foreach($this->getPocztaPolskaPaczkas() as $relObj) {
				$copyObj->addPocztaPolskaPaczka($relObj->copy($deepCopy));
			}

			foreach($this->getOrderProducts() as $relObj) {
				$copyObj->addOrderProduct($relObj->copy($deepCopy));
			}

			foreach($this->getReviews() as $relObj) {
				$copyObj->addReview($relObj->copy($deepCopy));
			}

			foreach($this->getReviewOrders() as $relObj) {
				$copyObj->addReviewOrder($relObj->copy($deepCopy));
			}

			foreach($this->getInvoices() as $relObj) {
				$copyObj->addInvoice($relObj->copy($deepCopy));
			}

			foreach($this->getTrustedShopsHasOrders() as $relObj) {
				$copyObj->addTrustedShopsHasOrder($relObj->copy($deepCopy));
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
	 * @return     Order Clone of current object.
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
	 * @return     OrderPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new OrderPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a OrderDelivery object.
	 *
	 * @param      OrderDelivery $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setOrderDelivery($v)
	{


		if ($v === null) {
			$this->setOrderDeliveryId(NULL);
		} else {
			$this->setOrderDeliveryId($v->getId());
		}


		$this->aOrderDelivery = $v;
	}


	/**
	 * Get the associated OrderDelivery object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     OrderDelivery The associated OrderDelivery object.
	 * @throws     PropelException
	 */
	public function getOrderDelivery($con = null)
	{
		if ($this->aOrderDelivery === null && ($this->order_delivery_id !== null)) {
			// include the related Peer class
			$this->aOrderDelivery = OrderDeliveryPeer::retrieveByPK($this->order_delivery_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = OrderDeliveryPeer::retrieveByPK($this->order_delivery_id, $con);
			   $obj->addOrderDeliverys($this);
			 */
		}
		return $this->aOrderDelivery;
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
	 * Declares an association between this object and a OrderUserDataDelivery object.
	 *
	 * @param      OrderUserDataDelivery $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setOrderUserDataDelivery($v)
	{


		if ($v === null) {
			$this->setOrderUserDataDeliveryId(NULL);
		} else {
			$this->setOrderUserDataDeliveryId($v->getId());
		}


		$this->aOrderUserDataDelivery = $v;
	}


	/**
	 * Get the associated OrderUserDataDelivery object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     OrderUserDataDelivery The associated OrderUserDataDelivery object.
	 * @throws     PropelException
	 */
	public function getOrderUserDataDelivery($con = null)
	{
		if ($this->aOrderUserDataDelivery === null && ($this->order_user_data_delivery_id !== null)) {
			// include the related Peer class
			$this->aOrderUserDataDelivery = OrderUserDataDeliveryPeer::retrieveByPK($this->order_user_data_delivery_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = OrderUserDataDeliveryPeer::retrieveByPK($this->order_user_data_delivery_id, $con);
			   $obj->addOrderUserDataDeliverys($this);
			 */
		}
		return $this->aOrderUserDataDelivery;
	}

	/**
	 * Declares an association between this object and a OrderUserDataBilling object.
	 *
	 * @param      OrderUserDataBilling $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setOrderUserDataBilling($v)
	{


		if ($v === null) {
			$this->setOrderUserDataBillingId(NULL);
		} else {
			$this->setOrderUserDataBillingId($v->getId());
		}


		$this->aOrderUserDataBilling = $v;
	}


	/**
	 * Get the associated OrderUserDataBilling object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     OrderUserDataBilling The associated OrderUserDataBilling object.
	 * @throws     PropelException
	 */
	public function getOrderUserDataBilling($con = null)
	{
		if ($this->aOrderUserDataBilling === null && ($this->order_user_data_billing_id !== null)) {
			// include the related Peer class
			$this->aOrderUserDataBilling = OrderUserDataBillingPeer::retrieveByPK($this->order_user_data_billing_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = OrderUserDataBillingPeer::retrieveByPK($this->order_user_data_billing_id, $con);
			   $obj->addOrderUserDataBillings($this);
			 */
		}
		return $this->aOrderUserDataBilling;
	}

	/**
	 * Declares an association between this object and a OrderCurrency object.
	 *
	 * @param      OrderCurrency $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setOrderCurrency($v)
	{


		if ($v === null) {
			$this->setOrderCurrencyId(NULL);
		} else {
			$this->setOrderCurrencyId($v->getId());
		}


		$this->aOrderCurrency = $v;
	}


	/**
	 * Get the associated OrderCurrency object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     OrderCurrency The associated OrderCurrency object.
	 * @throws     PropelException
	 */
	public function getOrderCurrency($con = null)
	{
		if ($this->aOrderCurrency === null && ($this->order_currency_id !== null)) {
			// include the related Peer class
			$this->aOrderCurrency = OrderCurrencyPeer::retrieveByPK($this->order_currency_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = OrderCurrencyPeer::retrieveByPK($this->order_currency_id, $con);
			   $obj->addOrderCurrencys($this);
			 */
		}
		return $this->aOrderCurrency;
	}

	/**
	 * Declares an association between this object and a OrderStatus object.
	 *
	 * @param      OrderStatus $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setOrderStatus($v)
	{


		if ($v === null) {
			$this->setOrderStatusId(NULL);
		} else {
			$this->setOrderStatusId($v->getId());
		}


		$this->aOrderStatus = $v;
	}


	/**
	 * Get the associated OrderStatus object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     OrderStatus The associated OrderStatus object.
	 * @throws     PropelException
	 */
	public function getOrderStatus($con = null)
	{
		if ($this->aOrderStatus === null && ($this->order_status_id !== null)) {
			// include the related Peer class
			$this->aOrderStatus = OrderStatusPeer::retrieveByPK($this->order_status_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = OrderStatusPeer::retrieveByPK($this->order_status_id, $con);
			   $obj->addOrderStatuss($this);
			 */
		}
		return $this->aOrderStatus;
	}

	/**
	 * Declares an association between this object and a DiscountCouponCode object.
	 *
	 * @param      DiscountCouponCode $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setDiscountCouponCode($v)
	{


		if ($v === null) {
			$this->setDiscountCouponCodeId(NULL);
		} else {
			$this->setDiscountCouponCodeId($v->getId());
		}


		$this->aDiscountCouponCode = $v;
	}


	/**
	 * Get the associated DiscountCouponCode object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     DiscountCouponCode The associated DiscountCouponCode object.
	 * @throws     PropelException
	 */
	public function getDiscountCouponCode($con = null)
	{
		if ($this->aDiscountCouponCode === null && ($this->discount_coupon_code_id !== null)) {
			// include the related Peer class
			$this->aDiscountCouponCode = DiscountCouponCodePeer::retrieveByPK($this->discount_coupon_code_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = DiscountCouponCodePeer::retrieveByPK($this->discount_coupon_code_id, $con);
			   $obj->addDiscountCouponCodes($this);
			 */
		}
		return $this->aDiscountCouponCode;
	}

	/**
	 * Declares an association between this object and a Discount object.
	 *
	 * @param      Discount $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setDiscount($v)
	{


		if ($v === null) {
			$this->setDiscountId(NULL);
		} else {
			$this->setDiscountId($v->getId());
		}


		$this->aDiscount = $v;
	}


	/**
	 * Get the associated Discount object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Discount The associated Discount object.
	 * @throws     PropelException
	 */
	public function getDiscount($con = null)
	{
		if ($this->aDiscount === null && ($this->discount_id !== null)) {
			// include the related Peer class
			$this->aDiscount = DiscountPeer::retrieveByPK($this->discount_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = DiscountPeer::retrieveByPK($this->discount_id, $con);
			   $obj->addDiscounts($this);
			 */
		}
		return $this->aDiscount;
	}

	/**
	 * Declares an association between this object and a Partner object.
	 *
	 * @param      Partner $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setPartner($v)
	{


		if ($v === null) {
			$this->setPartnerId(NULL);
		} else {
			$this->setPartnerId($v->getId());
		}


		$this->aPartner = $v;
	}


	/**
	 * Get the associated Partner object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Partner The associated Partner object.
	 * @throws     PropelException
	 */
	public function getPartner($con = null)
	{
		if ($this->aPartner === null && ($this->partner_id !== null)) {
			// include the related Peer class
			$this->aPartner = PartnerPeer::retrieveByPK($this->partner_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = PartnerPeer::retrieveByPK($this->partner_id, $con);
			   $obj->addPartners($this);
			 */
		}
		return $this->aPartner;
	}

	/**
	 * Temporary storage of collPaczkomatyPacks to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPaczkomatyPacks()
	{
		if ($this->collPaczkomatyPacks === null) {
			$this->collPaczkomatyPacks = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order has previously
	 * been saved, it will retrieve related PaczkomatyPacks from storage.
	 * If this Order is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPaczkomatyPacks($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPaczkomatyPacks === null) {
			if ($this->isNew()) {
			   $this->collPaczkomatyPacks = array();
			} else {

				$criteria->add(PaczkomatyPackPeer::ORDER_ID, $this->getId());

				PaczkomatyPackPeer::addSelectColumns($criteria);
				$this->collPaczkomatyPacks = PaczkomatyPackPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PaczkomatyPackPeer::ORDER_ID, $this->getId());

				PaczkomatyPackPeer::addSelectColumns($criteria);
				if (!isset($this->lastPaczkomatyPackCriteria) || !$this->lastPaczkomatyPackCriteria->equals($criteria)) {
					$this->collPaczkomatyPacks = PaczkomatyPackPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPaczkomatyPackCriteria = $criteria;
		return $this->collPaczkomatyPacks;
	}

	/**
	 * Returns the number of related PaczkomatyPacks.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPaczkomatyPacks($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PaczkomatyPackPeer::ORDER_ID, $this->getId());

		return PaczkomatyPackPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a PaczkomatyPack object to this object
	 * through the PaczkomatyPack foreign key attribute
	 *
	 * @param      PaczkomatyPack $l PaczkomatyPack
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPaczkomatyPack(PaczkomatyPack $l)
	{
		$this->collPaczkomatyPacks[] = $l;
		$l->setOrder($this);
	}

	/**
	 * Temporary storage of collUserPointss to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initUserPointss()
	{
		if ($this->collUserPointss === null) {
			$this->collUserPointss = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order has previously
	 * been saved, it will retrieve related UserPointss from storage.
	 * If this Order is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getUserPointss($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserPointss === null) {
			if ($this->isNew()) {
			   $this->collUserPointss = array();
			} else {

				$criteria->add(UserPointsPeer::ORDER_ID, $this->getId());

				UserPointsPeer::addSelectColumns($criteria);
				$this->collUserPointss = UserPointsPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserPointsPeer::ORDER_ID, $this->getId());

				UserPointsPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserPointsCriteria) || !$this->lastUserPointsCriteria->equals($criteria)) {
					$this->collUserPointss = UserPointsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserPointsCriteria = $criteria;
		return $this->collUserPointss;
	}

	/**
	 * Returns the number of related UserPointss.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countUserPointss($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(UserPointsPeer::ORDER_ID, $this->getId());

		return UserPointsPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a UserPoints object to this object
	 * through the UserPoints foreign key attribute
	 *
	 * @param      UserPoints $l UserPoints
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserPoints(UserPoints $l)
	{
		$this->collUserPointss[] = $l;
		$l->setOrder($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order is new, it will return
	 * an empty collection; or if this Order has previously
	 * been saved, it will retrieve related UserPointss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Order.
	 */
	public function getUserPointssJoinsfGuardUserRelatedBySfGuardUserId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserPointss === null) {
			if ($this->isNew()) {
				$this->collUserPointss = array();
			} else {

				$criteria->add(UserPointsPeer::ORDER_ID, $this->getId());

				$this->collUserPointss = UserPointsPeer::doSelectJoinsfGuardUserRelatedBySfGuardUserId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserPointsPeer::ORDER_ID, $this->getId());

			if (!isset($this->lastUserPointsCriteria) || !$this->lastUserPointsCriteria->equals($criteria)) {
				$this->collUserPointss = UserPointsPeer::doSelectJoinsfGuardUserRelatedBySfGuardUserId($criteria, $con);
			}
		}
		$this->lastUserPointsCriteria = $criteria;

		return $this->collUserPointss;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order is new, it will return
	 * an empty collection; or if this Order has previously
	 * been saved, it will retrieve related UserPointss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Order.
	 */
	public function getUserPointssJoinsfGuardUserRelatedByAdminId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserPointss === null) {
			if ($this->isNew()) {
				$this->collUserPointss = array();
			} else {

				$criteria->add(UserPointsPeer::ORDER_ID, $this->getId());

				$this->collUserPointss = UserPointsPeer::doSelectJoinsfGuardUserRelatedByAdminId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserPointsPeer::ORDER_ID, $this->getId());

			if (!isset($this->lastUserPointsCriteria) || !$this->lastUserPointsCriteria->equals($criteria)) {
				$this->collUserPointss = UserPointsPeer::doSelectJoinsfGuardUserRelatedByAdminId($criteria, $con);
			}
		}
		$this->lastUserPointsCriteria = $criteria;

		return $this->collUserPointss;
	}

	/**
	 * Temporary storage of collAllegroAuctionHasOrders to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initAllegroAuctionHasOrders()
	{
		if ($this->collAllegroAuctionHasOrders === null) {
			$this->collAllegroAuctionHasOrders = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order has previously
	 * been saved, it will retrieve related AllegroAuctionHasOrders from storage.
	 * If this Order is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getAllegroAuctionHasOrders($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAllegroAuctionHasOrders === null) {
			if ($this->isNew()) {
			   $this->collAllegroAuctionHasOrders = array();
			} else {

				$criteria->add(AllegroAuctionHasOrderPeer::ORDER_ID, $this->getId());

				AllegroAuctionHasOrderPeer::addSelectColumns($criteria);
				$this->collAllegroAuctionHasOrders = AllegroAuctionHasOrderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AllegroAuctionHasOrderPeer::ORDER_ID, $this->getId());

				AllegroAuctionHasOrderPeer::addSelectColumns($criteria);
				if (!isset($this->lastAllegroAuctionHasOrderCriteria) || !$this->lastAllegroAuctionHasOrderCriteria->equals($criteria)) {
					$this->collAllegroAuctionHasOrders = AllegroAuctionHasOrderPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAllegroAuctionHasOrderCriteria = $criteria;
		return $this->collAllegroAuctionHasOrders;
	}

	/**
	 * Returns the number of related AllegroAuctionHasOrders.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countAllegroAuctionHasOrders($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AllegroAuctionHasOrderPeer::ORDER_ID, $this->getId());

		return AllegroAuctionHasOrderPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a AllegroAuctionHasOrder object to this object
	 * through the AllegroAuctionHasOrder foreign key attribute
	 *
	 * @param      AllegroAuctionHasOrder $l AllegroAuctionHasOrder
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAllegroAuctionHasOrder(AllegroAuctionHasOrder $l)
	{
		$this->collAllegroAuctionHasOrders[] = $l;
		$l->setOrder($this);
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
	 * Otherwise if this Order has previously
	 * been saved, it will retrieve related OrderHasPayments from storage.
	 * If this Order is new, it will return
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

				$criteria->add(OrderHasPaymentPeer::ORDER_ID, $this->getId());

				OrderHasPaymentPeer::addSelectColumns($criteria);
				$this->collOrderHasPayments = OrderHasPaymentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderHasPaymentPeer::ORDER_ID, $this->getId());

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

		$criteria->add(OrderHasPaymentPeer::ORDER_ID, $this->getId());

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
		$l->setOrder($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order is new, it will return
	 * an empty collection; or if this Order has previously
	 * been saved, it will retrieve related OrderHasPayments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Order.
	 */
	public function getOrderHasPaymentsJoinPayment($criteria = null, $con = null)
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

				$criteria->add(OrderHasPaymentPeer::ORDER_ID, $this->getId());

				$this->collOrderHasPayments = OrderHasPaymentPeer::doSelectJoinPayment($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderHasPaymentPeer::ORDER_ID, $this->getId());

			if (!isset($this->lastOrderHasPaymentCriteria) || !$this->lastOrderHasPaymentCriteria->equals($criteria)) {
				$this->collOrderHasPayments = OrderHasPaymentPeer::doSelectJoinPayment($criteria, $con);
			}
		}
		$this->lastOrderHasPaymentCriteria = $criteria;

		return $this->collOrderHasPayments;
	}

	/**
	 * Temporary storage of collDiscountCouponCodes to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDiscountCouponCodes()
	{
		if ($this->collDiscountCouponCodes === null) {
			$this->collDiscountCouponCodes = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order has previously
	 * been saved, it will retrieve related DiscountCouponCodes from storage.
	 * If this Order is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDiscountCouponCodes($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountCouponCodes === null) {
			if ($this->isNew()) {
			   $this->collDiscountCouponCodes = array();
			} else {

				$criteria->add(DiscountCouponCodePeer::ORDER_ID, $this->getId());

				DiscountCouponCodePeer::addSelectColumns($criteria);
				$this->collDiscountCouponCodes = DiscountCouponCodePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountCouponCodePeer::ORDER_ID, $this->getId());

				DiscountCouponCodePeer::addSelectColumns($criteria);
				if (!isset($this->lastDiscountCouponCodeCriteria) || !$this->lastDiscountCouponCodeCriteria->equals($criteria)) {
					$this->collDiscountCouponCodes = DiscountCouponCodePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDiscountCouponCodeCriteria = $criteria;
		return $this->collDiscountCouponCodes;
	}

	/**
	 * Returns the number of related DiscountCouponCodes.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDiscountCouponCodes($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DiscountCouponCodePeer::ORDER_ID, $this->getId());

		return DiscountCouponCodePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DiscountCouponCode object to this object
	 * through the DiscountCouponCode foreign key attribute
	 *
	 * @param      DiscountCouponCode $l DiscountCouponCode
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDiscountCouponCode(DiscountCouponCode $l)
	{
		$this->collDiscountCouponCodes[] = $l;
		$l->setOrder($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order is new, it will return
	 * an empty collection; or if this Order has previously
	 * been saved, it will retrieve related DiscountCouponCodes from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Order.
	 */
	public function getDiscountCouponCodesJoinsfGuardUser($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountCouponCodes === null) {
			if ($this->isNew()) {
				$this->collDiscountCouponCodes = array();
			} else {

				$criteria->add(DiscountCouponCodePeer::ORDER_ID, $this->getId());

				$this->collDiscountCouponCodes = DiscountCouponCodePeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DiscountCouponCodePeer::ORDER_ID, $this->getId());

			if (!isset($this->lastDiscountCouponCodeCriteria) || !$this->lastDiscountCouponCodeCriteria->equals($criteria)) {
				$this->collDiscountCouponCodes = DiscountCouponCodePeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastDiscountCouponCodeCriteria = $criteria;

		return $this->collDiscountCouponCodes;
	}

	/**
	 * Temporary storage of collPaybynetHasOrders to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPaybynetHasOrders()
	{
		if ($this->collPaybynetHasOrders === null) {
			$this->collPaybynetHasOrders = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order has previously
	 * been saved, it will retrieve related PaybynetHasOrders from storage.
	 * If this Order is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPaybynetHasOrders($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPaybynetHasOrders === null) {
			if ($this->isNew()) {
			   $this->collPaybynetHasOrders = array();
			} else {

				$criteria->add(PaybynetHasOrderPeer::ORDER_ID, $this->getId());

				PaybynetHasOrderPeer::addSelectColumns($criteria);
				$this->collPaybynetHasOrders = PaybynetHasOrderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PaybynetHasOrderPeer::ORDER_ID, $this->getId());

				PaybynetHasOrderPeer::addSelectColumns($criteria);
				if (!isset($this->lastPaybynetHasOrderCriteria) || !$this->lastPaybynetHasOrderCriteria->equals($criteria)) {
					$this->collPaybynetHasOrders = PaybynetHasOrderPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPaybynetHasOrderCriteria = $criteria;
		return $this->collPaybynetHasOrders;
	}

	/**
	 * Returns the number of related PaybynetHasOrders.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPaybynetHasOrders($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PaybynetHasOrderPeer::ORDER_ID, $this->getId());

		return PaybynetHasOrderPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a PaybynetHasOrder object to this object
	 * through the PaybynetHasOrder foreign key attribute
	 *
	 * @param      PaybynetHasOrder $l PaybynetHasOrder
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPaybynetHasOrder(PaybynetHasOrder $l)
	{
		$this->collPaybynetHasOrders[] = $l;
		$l->setOrder($this);
	}

	/**
	 * Temporary storage of collPocztaPolskaPunktOdbiorus to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPocztaPolskaPunktOdbiorus()
	{
		if ($this->collPocztaPolskaPunktOdbiorus === null) {
			$this->collPocztaPolskaPunktOdbiorus = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order has previously
	 * been saved, it will retrieve related PocztaPolskaPunktOdbiorus from storage.
	 * If this Order is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPocztaPolskaPunktOdbiorus($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPocztaPolskaPunktOdbiorus === null) {
			if ($this->isNew()) {
			   $this->collPocztaPolskaPunktOdbiorus = array();
			} else {

				$criteria->add(PocztaPolskaPunktOdbioruPeer::ORDER_ID, $this->getId());

				PocztaPolskaPunktOdbioruPeer::addSelectColumns($criteria);
				$this->collPocztaPolskaPunktOdbiorus = PocztaPolskaPunktOdbioruPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PocztaPolskaPunktOdbioruPeer::ORDER_ID, $this->getId());

				PocztaPolskaPunktOdbioruPeer::addSelectColumns($criteria);
				if (!isset($this->lastPocztaPolskaPunktOdbioruCriteria) || !$this->lastPocztaPolskaPunktOdbioruCriteria->equals($criteria)) {
					$this->collPocztaPolskaPunktOdbiorus = PocztaPolskaPunktOdbioruPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPocztaPolskaPunktOdbioruCriteria = $criteria;
		return $this->collPocztaPolskaPunktOdbiorus;
	}

	/**
	 * Returns the number of related PocztaPolskaPunktOdbiorus.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPocztaPolskaPunktOdbiorus($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PocztaPolskaPunktOdbioruPeer::ORDER_ID, $this->getId());

		return PocztaPolskaPunktOdbioruPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a PocztaPolskaPunktOdbioru object to this object
	 * through the PocztaPolskaPunktOdbioru foreign key attribute
	 *
	 * @param      PocztaPolskaPunktOdbioru $l PocztaPolskaPunktOdbioru
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPocztaPolskaPunktOdbioru(PocztaPolskaPunktOdbioru $l)
	{
		$this->collPocztaPolskaPunktOdbiorus[] = $l;
		$l->setOrder($this);
	}

	/**
	 * Temporary storage of collPocztaPolskaPaczkas to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPocztaPolskaPaczkas()
	{
		if ($this->collPocztaPolskaPaczkas === null) {
			$this->collPocztaPolskaPaczkas = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order has previously
	 * been saved, it will retrieve related PocztaPolskaPaczkas from storage.
	 * If this Order is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPocztaPolskaPaczkas($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPocztaPolskaPaczkas === null) {
			if ($this->isNew()) {
			   $this->collPocztaPolskaPaczkas = array();
			} else {

				$criteria->add(PocztaPolskaPaczkaPeer::ORDER_ID, $this->getId());

				PocztaPolskaPaczkaPeer::addSelectColumns($criteria);
				$this->collPocztaPolskaPaczkas = PocztaPolskaPaczkaPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PocztaPolskaPaczkaPeer::ORDER_ID, $this->getId());

				PocztaPolskaPaczkaPeer::addSelectColumns($criteria);
				if (!isset($this->lastPocztaPolskaPaczkaCriteria) || !$this->lastPocztaPolskaPaczkaCriteria->equals($criteria)) {
					$this->collPocztaPolskaPaczkas = PocztaPolskaPaczkaPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPocztaPolskaPaczkaCriteria = $criteria;
		return $this->collPocztaPolskaPaczkas;
	}

	/**
	 * Returns the number of related PocztaPolskaPaczkas.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPocztaPolskaPaczkas($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PocztaPolskaPaczkaPeer::ORDER_ID, $this->getId());

		return PocztaPolskaPaczkaPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a PocztaPolskaPaczka object to this object
	 * through the PocztaPolskaPaczka foreign key attribute
	 *
	 * @param      PocztaPolskaPaczka $l PocztaPolskaPaczka
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPocztaPolskaPaczka(PocztaPolskaPaczka $l)
	{
		$this->collPocztaPolskaPaczkas[] = $l;
		$l->setOrder($this);
	}

	/**
	 * Temporary storage of collOrderProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOrderProducts()
	{
		if ($this->collOrderProducts === null) {
			$this->collOrderProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order has previously
	 * been saved, it will retrieve related OrderProducts from storage.
	 * If this Order is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOrderProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderProducts === null) {
			if ($this->isNew()) {
			   $this->collOrderProducts = array();
			} else {

				$criteria->add(OrderProductPeer::ORDER_ID, $this->getId());

				OrderProductPeer::addSelectColumns($criteria);
				$this->collOrderProducts = OrderProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderProductPeer::ORDER_ID, $this->getId());

				OrderProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastOrderProductCriteria) || !$this->lastOrderProductCriteria->equals($criteria)) {
					$this->collOrderProducts = OrderProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOrderProductCriteria = $criteria;
		return $this->collOrderProducts;
	}

	/**
	 * Returns the number of related OrderProducts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOrderProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OrderProductPeer::ORDER_ID, $this->getId());

		return OrderProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a OrderProduct object to this object
	 * through the OrderProduct foreign key attribute
	 *
	 * @param      OrderProduct $l OrderProduct
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOrderProduct(OrderProduct $l)
	{
		$this->collOrderProducts[] = $l;
		$l->setOrder($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order is new, it will return
	 * an empty collection; or if this Order has previously
	 * been saved, it will retrieve related OrderProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Order.
	 */
	public function getOrderProductsJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderProducts === null) {
			if ($this->isNew()) {
				$this->collOrderProducts = array();
			} else {

				$criteria->add(OrderProductPeer::ORDER_ID, $this->getId());

				$this->collOrderProducts = OrderProductPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderProductPeer::ORDER_ID, $this->getId());

			if (!isset($this->lastOrderProductCriteria) || !$this->lastOrderProductCriteria->equals($criteria)) {
				$this->collOrderProducts = OrderProductPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastOrderProductCriteria = $criteria;

		return $this->collOrderProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order is new, it will return
	 * an empty collection; or if this Order has previously
	 * been saved, it will retrieve related OrderProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Order.
	 */
	public function getOrderProductsJoinTax($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderProducts === null) {
			if ($this->isNew()) {
				$this->collOrderProducts = array();
			} else {

				$criteria->add(OrderProductPeer::ORDER_ID, $this->getId());

				$this->collOrderProducts = OrderProductPeer::doSelectJoinTax($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderProductPeer::ORDER_ID, $this->getId());

			if (!isset($this->lastOrderProductCriteria) || !$this->lastOrderProductCriteria->equals($criteria)) {
				$this->collOrderProducts = OrderProductPeer::doSelectJoinTax($criteria, $con);
			}
		}
		$this->lastOrderProductCriteria = $criteria;

		return $this->collOrderProducts;
	}

	/**
	 * Temporary storage of collReviews to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initReviews()
	{
		if ($this->collReviews === null) {
			$this->collReviews = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order has previously
	 * been saved, it will retrieve related Reviews from storage.
	 * If this Order is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getReviews($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReviews === null) {
			if ($this->isNew()) {
			   $this->collReviews = array();
			} else {

				$criteria->add(ReviewPeer::ORDER_ID, $this->getId());

				ReviewPeer::addSelectColumns($criteria);
				$this->collReviews = ReviewPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ReviewPeer::ORDER_ID, $this->getId());

				ReviewPeer::addSelectColumns($criteria);
				if (!isset($this->lastReviewCriteria) || !$this->lastReviewCriteria->equals($criteria)) {
					$this->collReviews = ReviewPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastReviewCriteria = $criteria;
		return $this->collReviews;
	}

	/**
	 * Returns the number of related Reviews.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countReviews($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ReviewPeer::ORDER_ID, $this->getId());

		return ReviewPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Review object to this object
	 * through the Review foreign key attribute
	 *
	 * @param      Review $l Review
	 * @return     void
	 * @throws     PropelException
	 */
	public function addReview(Review $l)
	{
		$this->collReviews[] = $l;
		$l->setOrder($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order is new, it will return
	 * an empty collection; or if this Order has previously
	 * been saved, it will retrieve related Reviews from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Order.
	 */
	public function getReviewsJoinsfGuardUser($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReviews === null) {
			if ($this->isNew()) {
				$this->collReviews = array();
			} else {

				$criteria->add(ReviewPeer::ORDER_ID, $this->getId());

				$this->collReviews = ReviewPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ReviewPeer::ORDER_ID, $this->getId());

			if (!isset($this->lastReviewCriteria) || !$this->lastReviewCriteria->equals($criteria)) {
				$this->collReviews = ReviewPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastReviewCriteria = $criteria;

		return $this->collReviews;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order is new, it will return
	 * an empty collection; or if this Order has previously
	 * been saved, it will retrieve related Reviews from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Order.
	 */
	public function getReviewsJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReviews === null) {
			if ($this->isNew()) {
				$this->collReviews = array();
			} else {

				$criteria->add(ReviewPeer::ORDER_ID, $this->getId());

				$this->collReviews = ReviewPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ReviewPeer::ORDER_ID, $this->getId());

			if (!isset($this->lastReviewCriteria) || !$this->lastReviewCriteria->equals($criteria)) {
				$this->collReviews = ReviewPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastReviewCriteria = $criteria;

		return $this->collReviews;
	}

	/**
	 * Temporary storage of collReviewOrders to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initReviewOrders()
	{
		if ($this->collReviewOrders === null) {
			$this->collReviewOrders = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order has previously
	 * been saved, it will retrieve related ReviewOrders from storage.
	 * If this Order is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getReviewOrders($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReviewOrders === null) {
			if ($this->isNew()) {
			   $this->collReviewOrders = array();
			} else {

				$criteria->add(ReviewOrderPeer::ORDER_ID, $this->getId());

				ReviewOrderPeer::addSelectColumns($criteria);
				$this->collReviewOrders = ReviewOrderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ReviewOrderPeer::ORDER_ID, $this->getId());

				ReviewOrderPeer::addSelectColumns($criteria);
				if (!isset($this->lastReviewOrderCriteria) || !$this->lastReviewOrderCriteria->equals($criteria)) {
					$this->collReviewOrders = ReviewOrderPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastReviewOrderCriteria = $criteria;
		return $this->collReviewOrders;
	}

	/**
	 * Returns the number of related ReviewOrders.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countReviewOrders($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ReviewOrderPeer::ORDER_ID, $this->getId());

		return ReviewOrderPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ReviewOrder object to this object
	 * through the ReviewOrder foreign key attribute
	 *
	 * @param      ReviewOrder $l ReviewOrder
	 * @return     void
	 * @throws     PropelException
	 */
	public function addReviewOrder(ReviewOrder $l)
	{
		$this->collReviewOrders[] = $l;
		$l->setOrder($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order is new, it will return
	 * an empty collection; or if this Order has previously
	 * been saved, it will retrieve related ReviewOrders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Order.
	 */
	public function getReviewOrdersJoinsfGuardUser($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReviewOrders === null) {
			if ($this->isNew()) {
				$this->collReviewOrders = array();
			} else {

				$criteria->add(ReviewOrderPeer::ORDER_ID, $this->getId());

				$this->collReviewOrders = ReviewOrderPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ReviewOrderPeer::ORDER_ID, $this->getId());

			if (!isset($this->lastReviewOrderCriteria) || !$this->lastReviewOrderCriteria->equals($criteria)) {
				$this->collReviewOrders = ReviewOrderPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastReviewOrderCriteria = $criteria;

		return $this->collReviewOrders;
	}

	/**
	 * Temporary storage of collInvoices to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initInvoices()
	{
		if ($this->collInvoices === null) {
			$this->collInvoices = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order has previously
	 * been saved, it will retrieve related Invoices from storage.
	 * If this Order is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getInvoices($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collInvoices === null) {
			if ($this->isNew()) {
			   $this->collInvoices = array();
			} else {

				$criteria->add(InvoicePeer::ORDER_ID, $this->getId());

				InvoicePeer::addSelectColumns($criteria);
				$this->collInvoices = InvoicePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(InvoicePeer::ORDER_ID, $this->getId());

				InvoicePeer::addSelectColumns($criteria);
				if (!isset($this->lastInvoiceCriteria) || !$this->lastInvoiceCriteria->equals($criteria)) {
					$this->collInvoices = InvoicePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastInvoiceCriteria = $criteria;
		return $this->collInvoices;
	}

	/**
	 * Returns the number of related Invoices.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countInvoices($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(InvoicePeer::ORDER_ID, $this->getId());

		return InvoicePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Invoice object to this object
	 * through the Invoice foreign key attribute
	 *
	 * @param      Invoice $l Invoice
	 * @return     void
	 * @throws     PropelException
	 */
	public function addInvoice(Invoice $l)
	{
		$this->collInvoices[] = $l;
		$l->setOrder($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order is new, it will return
	 * an empty collection; or if this Order has previously
	 * been saved, it will retrieve related Invoices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Order.
	 */
	public function getInvoicesJoinInvoiceUserSeller($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collInvoices === null) {
			if ($this->isNew()) {
				$this->collInvoices = array();
			} else {

				$criteria->add(InvoicePeer::ORDER_ID, $this->getId());

				$this->collInvoices = InvoicePeer::doSelectJoinInvoiceUserSeller($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(InvoicePeer::ORDER_ID, $this->getId());

			if (!isset($this->lastInvoiceCriteria) || !$this->lastInvoiceCriteria->equals($criteria)) {
				$this->collInvoices = InvoicePeer::doSelectJoinInvoiceUserSeller($criteria, $con);
			}
		}
		$this->lastInvoiceCriteria = $criteria;

		return $this->collInvoices;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order is new, it will return
	 * an empty collection; or if this Order has previously
	 * been saved, it will retrieve related Invoices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Order.
	 */
	public function getInvoicesJoinInvoiceUserCustomer($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collInvoices === null) {
			if ($this->isNew()) {
				$this->collInvoices = array();
			} else {

				$criteria->add(InvoicePeer::ORDER_ID, $this->getId());

				$this->collInvoices = InvoicePeer::doSelectJoinInvoiceUserCustomer($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(InvoicePeer::ORDER_ID, $this->getId());

			if (!isset($this->lastInvoiceCriteria) || !$this->lastInvoiceCriteria->equals($criteria)) {
				$this->collInvoices = InvoicePeer::doSelectJoinInvoiceUserCustomer($criteria, $con);
			}
		}
		$this->lastInvoiceCriteria = $criteria;

		return $this->collInvoices;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order is new, it will return
	 * an empty collection; or if this Order has previously
	 * been saved, it will retrieve related Invoices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Order.
	 */
	public function getInvoicesJoinInvoiceCurrency($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collInvoices === null) {
			if ($this->isNew()) {
				$this->collInvoices = array();
			} else {

				$criteria->add(InvoicePeer::ORDER_ID, $this->getId());

				$this->collInvoices = InvoicePeer::doSelectJoinInvoiceCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(InvoicePeer::ORDER_ID, $this->getId());

			if (!isset($this->lastInvoiceCriteria) || !$this->lastInvoiceCriteria->equals($criteria)) {
				$this->collInvoices = InvoicePeer::doSelectJoinInvoiceCurrency($criteria, $con);
			}
		}
		$this->lastInvoiceCriteria = $criteria;

		return $this->collInvoices;
	}

	/**
	 * Temporary storage of collTrustedShopsHasOrders to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initTrustedShopsHasOrders()
	{
		if ($this->collTrustedShopsHasOrders === null) {
			$this->collTrustedShopsHasOrders = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order has previously
	 * been saved, it will retrieve related TrustedShopsHasOrders from storage.
	 * If this Order is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getTrustedShopsHasOrders($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTrustedShopsHasOrders === null) {
			if ($this->isNew()) {
			   $this->collTrustedShopsHasOrders = array();
			} else {

				$criteria->add(TrustedShopsHasOrderPeer::ORDER_ID, $this->getId());

				TrustedShopsHasOrderPeer::addSelectColumns($criteria);
				$this->collTrustedShopsHasOrders = TrustedShopsHasOrderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(TrustedShopsHasOrderPeer::ORDER_ID, $this->getId());

				TrustedShopsHasOrderPeer::addSelectColumns($criteria);
				if (!isset($this->lastTrustedShopsHasOrderCriteria) || !$this->lastTrustedShopsHasOrderCriteria->equals($criteria)) {
					$this->collTrustedShopsHasOrders = TrustedShopsHasOrderPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTrustedShopsHasOrderCriteria = $criteria;
		return $this->collTrustedShopsHasOrders;
	}

	/**
	 * Returns the number of related TrustedShopsHasOrders.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countTrustedShopsHasOrders($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TrustedShopsHasOrderPeer::ORDER_ID, $this->getId());

		return TrustedShopsHasOrderPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a TrustedShopsHasOrder object to this object
	 * through the TrustedShopsHasOrder foreign key attribute
	 *
	 * @param      TrustedShopsHasOrder $l TrustedShopsHasOrder
	 * @return     void
	 * @throws     PropelException
	 */
	public function addTrustedShopsHasOrder(TrustedShopsHasOrder $l)
	{
		$this->collTrustedShopsHasOrders[] = $l;
		$l->setOrder($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Order is new, it will return
	 * an empty collection; or if this Order has previously
	 * been saved, it will retrieve related TrustedShopsHasOrders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Order.
	 */
	public function getTrustedShopsHasOrdersJoinTrustedShops($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTrustedShopsHasOrders === null) {
			if ($this->isNew()) {
				$this->collTrustedShopsHasOrders = array();
			} else {

				$criteria->add(TrustedShopsHasOrderPeer::ORDER_ID, $this->getId());

				$this->collTrustedShopsHasOrders = TrustedShopsHasOrderPeer::doSelectJoinTrustedShops($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(TrustedShopsHasOrderPeer::ORDER_ID, $this->getId());

			if (!isset($this->lastTrustedShopsHasOrderCriteria) || !$this->lastTrustedShopsHasOrderCriteria->equals($criteria)) {
				$this->collTrustedShopsHasOrders = TrustedShopsHasOrderPeer::doSelectJoinTrustedShops($criteria, $con);
			}
		}
		$this->lastTrustedShopsHasOrderCriteria = $criteria;

		return $this->collTrustedShopsHasOrders;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Order.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseOrder:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseOrder::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseOrder
