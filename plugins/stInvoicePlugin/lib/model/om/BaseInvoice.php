<?php

/**
 * Base class that represents a row from the 'st_invoice' table.
 *
 * 
 *
 * @package    plugins.stInvoicePlugin.lib.model.om
 */
abstract class BaseInvoice extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        InvoicePeer
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
	 * The value for the invoice_user_seller_id field.
	 * @var        int
	 */
	protected $invoice_user_seller_id;


	/**
	 * The value for the invoice_user_customer_id field.
	 * @var        int
	 */
	protected $invoice_user_customer_id;


	/**
	 * The value for the order_id field.
	 * @var        int
	 */
	protected $order_id;


	/**
	 * The value for the invoice_currency_id field.
	 * @var        int
	 */
	protected $invoice_currency_id;


	/**
	 * The value for the invoice_proforma_id field.
	 * @var        int
	 */
	protected $invoice_proforma_id;


	/**
	 * The value for the company_description field.
	 * @var        string
	 */
	protected $company_description;


	/**
	 * The value for the invoice_description field.
	 * @var        string
	 */
	protected $invoice_description;


	/**
	 * The value for the order_discount field.
	 * @var        double
	 */
	protected $order_discount;


	/**
	 * The value for the date_selle field.
	 * @var        int
	 */
	protected $date_selle;


	/**
	 * The value for the date_create_copy field.
	 * @var        int
	 */
	protected $date_create_copy;


	/**
	 * The value for the number field.
	 * @var        string
	 */
	protected $number;


	/**
	 * The value for the signature_seller field.
	 * @var        string
	 */
	protected $signature_seller;


	/**
	 * The value for the signature_customer field.
	 * @var        string
	 */
	protected $signature_customer;


	/**
	 * The value for the opt_total_ammount_brutto field.
	 * @var        double
	 */
	protected $opt_total_ammount_brutto;


	/**
	 * The value for the town field.
	 * @var        string
	 */
	protected $town;


	/**
	 * The value for the curency field.
	 * @var        string
	 */
	protected $curency;


	/**
	 * The value for the max_day field.
	 * @var        string
	 */
	protected $max_day = 'none';


	/**
	 * The value for the payment_type field.
	 * @var        string
	 */
	protected $payment_type = 'none';


	/**
	 * The value for the is_proforma field.
	 * @var        boolean
	 */
	protected $is_proforma = true;


	/**
	 * The value for the is_request field.
	 * @var        boolean
	 */
	protected $is_request = false;


	/**
	 * The value for the is_confirm field.
	 * @var        boolean
	 */
	protected $is_confirm = false;

	/**
	 * @var        InvoiceUserSeller
	 */
	protected $aInvoiceUserSeller;

	/**
	 * @var        InvoiceUserCustomer
	 */
	protected $aInvoiceUserCustomer;

	/**
	 * @var        Order
	 */
	protected $aOrder;

	/**
	 * @var        InvoiceCurrency
	 */
	protected $aInvoiceCurrency;

	/**
	 * Collection to store aggregation of collInvoiceStatuss.
	 * @var        array
	 */
	protected $collInvoiceStatuss;

	/**
	 * The criteria used to select the current contents of collInvoiceStatuss.
	 * @var        Criteria
	 */
	protected $lastInvoiceStatusCriteria = null;

	/**
	 * Collection to store aggregation of collInvoiceProducts.
	 * @var        array
	 */
	protected $collInvoiceProducts;

	/**
	 * The criteria used to select the current contents of collInvoiceProducts.
	 * @var        Criteria
	 */
	protected $lastInvoiceProductCriteria = null;

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
     * Get the [invoice_user_seller_id] column value.
     * 
     * @return     int
     */
    public function getInvoiceUserSellerId()
    {

            return $this->invoice_user_seller_id;
    }

    /**
     * Get the [invoice_user_customer_id] column value.
     * 
     * @return     int
     */
    public function getInvoiceUserCustomerId()
    {

            return $this->invoice_user_customer_id;
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
     * Get the [invoice_currency_id] column value.
     * 
     * @return     int
     */
    public function getInvoiceCurrencyId()
    {

            return $this->invoice_currency_id;
    }

    /**
     * Get the [invoice_proforma_id] column value.
     * 
     * @return     int
     */
    public function getInvoiceProformaId()
    {

            return $this->invoice_proforma_id;
    }

    /**
     * Get the [company_description] column value.
     * 
     * @return     string
     */
    public function getCompanyDescription()
    {

            return $this->company_description;
    }

    /**
     * Get the [invoice_description] column value.
     * 
     * @return     string
     */
    public function getInvoiceDescription()
    {

            return $this->invoice_description;
    }

    /**
     * Get the [order_discount] column value.
     * 
     * @return     double
     */
    public function getOrderDiscount()
    {

            return null !== $this->order_discount ? (string)$this->order_discount : null;
    }

	/**
	 * Get the [optionally formatted] [date_selle] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getDateSelle($format = 'Y-m-d')
	{

		if ($this->date_selle === null || $this->date_selle === '') {
			return null;
		} elseif (!is_int($this->date_selle)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->date_selle);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [date_selle] as date/time value: " . var_export($this->date_selle, true));
			}
		} else {
			$ts = $this->date_selle;
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
	 * Get the [optionally formatted] [date_create_copy] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getDateCreateCopy($format = 'Y-m-d')
	{

		if ($this->date_create_copy === null || $this->date_create_copy === '') {
			return null;
		} elseif (!is_int($this->date_create_copy)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->date_create_copy);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [date_create_copy] as date/time value: " . var_export($this->date_create_copy, true));
			}
		} else {
			$ts = $this->date_create_copy;
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
     * Get the [number] column value.
     * 
     * @return     string
     */
    public function getNumber()
    {

            return $this->number;
    }

    /**
     * Get the [signature_seller] column value.
     * 
     * @return     string
     */
    public function getSignatureSeller()
    {

            return $this->signature_seller;
    }

    /**
     * Get the [signature_customer] column value.
     * 
     * @return     string
     */
    public function getSignatureCustomer()
    {

            return $this->signature_customer;
    }

    /**
     * Get the [opt_total_ammount_brutto] column value.
     * 
     * @return     double
     */
    public function getOptTotalAmmountBrutto()
    {

            return null !== $this->opt_total_ammount_brutto ? (string)$this->opt_total_ammount_brutto : null;
    }

    /**
     * Get the [town] column value.
     * 
     * @return     string
     */
    public function getTown()
    {

            return $this->town;
    }

    /**
     * Get the [curency] column value.
     * 
     * @return     string
     */
    public function getCurency()
    {

            return $this->curency;
    }

    /**
     * Get the [max_day] column value.
     * 
     * @return     string
     */
    public function getMaxDay()
    {

            return $this->max_day;
    }

    /**
     * Get the [payment_type] column value.
     * 
     * @return     string
     */
    public function getPaymentType()
    {

            return $this->payment_type;
    }

    /**
     * Get the [is_proforma] column value.
     * 
     * @return     boolean
     */
    public function getIsProforma()
    {

            return $this->is_proforma;
    }

    /**
     * Get the [is_request] column value.
     * 
     * @return     boolean
     */
    public function getIsRequest()
    {

            return $this->is_request;
    }

    /**
     * Get the [is_confirm] column value.
     * 
     * @return     boolean
     */
    public function getIsConfirm()
    {

            return $this->is_confirm;
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
			$this->modifiedColumns[] = InvoicePeer::CREATED_AT;
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
			$this->modifiedColumns[] = InvoicePeer::UPDATED_AT;
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
          $this->modifiedColumns[] = InvoicePeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [invoice_user_seller_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setInvoiceUserSellerId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->invoice_user_seller_id !== $v) {
          $this->invoice_user_seller_id = $v;
          $this->modifiedColumns[] = InvoicePeer::INVOICE_USER_SELLER_ID;
        }

		if ($this->aInvoiceUserSeller !== null && $this->aInvoiceUserSeller->getId() !== $v) {
			$this->aInvoiceUserSeller = null;
		}

	} // setInvoiceUserSellerId()

	/**
	 * Set the value of [invoice_user_customer_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setInvoiceUserCustomerId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->invoice_user_customer_id !== $v) {
          $this->invoice_user_customer_id = $v;
          $this->modifiedColumns[] = InvoicePeer::INVOICE_USER_CUSTOMER_ID;
        }

		if ($this->aInvoiceUserCustomer !== null && $this->aInvoiceUserCustomer->getId() !== $v) {
			$this->aInvoiceUserCustomer = null;
		}

	} // setInvoiceUserCustomerId()

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
          $this->modifiedColumns[] = InvoicePeer::ORDER_ID;
        }

		if ($this->aOrder !== null && $this->aOrder->getId() !== $v) {
			$this->aOrder = null;
		}

	} // setOrderId()

	/**
	 * Set the value of [invoice_currency_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setInvoiceCurrencyId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->invoice_currency_id !== $v) {
          $this->invoice_currency_id = $v;
          $this->modifiedColumns[] = InvoicePeer::INVOICE_CURRENCY_ID;
        }

		if ($this->aInvoiceCurrency !== null && $this->aInvoiceCurrency->getId() !== $v) {
			$this->aInvoiceCurrency = null;
		}

	} // setInvoiceCurrencyId()

	/**
	 * Set the value of [invoice_proforma_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setInvoiceProformaId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->invoice_proforma_id !== $v) {
          $this->invoice_proforma_id = $v;
          $this->modifiedColumns[] = InvoicePeer::INVOICE_PROFORMA_ID;
        }

	} // setInvoiceProformaId()

	/**
	 * Set the value of [company_description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCompanyDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->company_description !== $v) {
          $this->company_description = $v;
          $this->modifiedColumns[] = InvoicePeer::COMPANY_DESCRIPTION;
        }

	} // setCompanyDescription()

	/**
	 * Set the value of [invoice_description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setInvoiceDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->invoice_description !== $v) {
          $this->invoice_description = $v;
          $this->modifiedColumns[] = InvoicePeer::INVOICE_DESCRIPTION;
        }

	} // setInvoiceDescription()

	/**
	 * Set the value of [order_discount] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOrderDiscount($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->order_discount !== $v) {
          $this->order_discount = $v;
          $this->modifiedColumns[] = InvoicePeer::ORDER_DISCOUNT;
        }

	} // setOrderDiscount()

	/**
	 * Set the value of [date_selle] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setDateSelle($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [date_selle] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->date_selle !== $ts) {
			$this->date_selle = $ts;
			$this->modifiedColumns[] = InvoicePeer::DATE_SELLE;
		}

	} // setDateSelle()

	/**
	 * Set the value of [date_create_copy] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setDateCreateCopy($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [date_create_copy] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->date_create_copy !== $ts) {
			$this->date_create_copy = $ts;
			$this->modifiedColumns[] = InvoicePeer::DATE_CREATE_COPY;
		}

	} // setDateCreateCopy()

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
          $this->modifiedColumns[] = InvoicePeer::NUMBER;
        }

	} // setNumber()

	/**
	 * Set the value of [signature_seller] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setSignatureSeller($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->signature_seller !== $v) {
          $this->signature_seller = $v;
          $this->modifiedColumns[] = InvoicePeer::SIGNATURE_SELLER;
        }

	} // setSignatureSeller()

	/**
	 * Set the value of [signature_customer] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setSignatureCustomer($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->signature_customer !== $v) {
          $this->signature_customer = $v;
          $this->modifiedColumns[] = InvoicePeer::SIGNATURE_CUSTOMER;
        }

	} // setSignatureCustomer()

	/**
	 * Set the value of [opt_total_ammount_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOptTotalAmmountBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->opt_total_ammount_brutto !== $v) {
          $this->opt_total_ammount_brutto = $v;
          $this->modifiedColumns[] = InvoicePeer::OPT_TOTAL_AMMOUNT_BRUTTO;
        }

	} // setOptTotalAmmountBrutto()

	/**
	 * Set the value of [town] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTown($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->town !== $v) {
          $this->town = $v;
          $this->modifiedColumns[] = InvoicePeer::TOWN;
        }

	} // setTown()

	/**
	 * Set the value of [curency] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCurency($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->curency !== $v) {
          $this->curency = $v;
          $this->modifiedColumns[] = InvoicePeer::CURENCY;
        }

	} // setCurency()

	/**
	 * Set the value of [max_day] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setMaxDay($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->max_day !== $v || $v === 'none') {
          $this->max_day = $v;
          $this->modifiedColumns[] = InvoicePeer::MAX_DAY;
        }

	} // setMaxDay()

	/**
	 * Set the value of [payment_type] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPaymentType($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->payment_type !== $v || $v === 'none') {
          $this->payment_type = $v;
          $this->modifiedColumns[] = InvoicePeer::PAYMENT_TYPE;
        }

	} // setPaymentType()

	/**
	 * Set the value of [is_proforma] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsProforma($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_proforma !== $v || $v === true) {
          $this->is_proforma = $v;
          $this->modifiedColumns[] = InvoicePeer::IS_PROFORMA;
        }

	} // setIsProforma()

	/**
	 * Set the value of [is_request] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsRequest($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_request !== $v || $v === false) {
          $this->is_request = $v;
          $this->modifiedColumns[] = InvoicePeer::IS_REQUEST;
        }

	} // setIsRequest()

	/**
	 * Set the value of [is_confirm] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsConfirm($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_confirm !== $v || $v === false) {
          $this->is_confirm = $v;
          $this->modifiedColumns[] = InvoicePeer::IS_CONFIRM;
        }

	} // setIsConfirm()

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
      if ($this->getDispatcher()->getListeners('Invoice.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Invoice.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->invoice_user_seller_id = $rs->getInt($startcol + 3);

      $this->invoice_user_customer_id = $rs->getInt($startcol + 4);

      $this->order_id = $rs->getInt($startcol + 5);

      $this->invoice_currency_id = $rs->getInt($startcol + 6);

      $this->invoice_proforma_id = $rs->getInt($startcol + 7);

      $this->company_description = $rs->getString($startcol + 8);

      $this->invoice_description = $rs->getString($startcol + 9);

      $this->order_discount = $rs->getString($startcol + 10);
      if (null !== $this->order_discount && $this->order_discount == intval($this->order_discount))
      {
        $this->order_discount = (string)intval($this->order_discount);
      }

      $this->date_selle = $rs->getDate($startcol + 11, null);

      $this->date_create_copy = $rs->getDate($startcol + 12, null);

      $this->number = $rs->getString($startcol + 13);

      $this->signature_seller = $rs->getString($startcol + 14);

      $this->signature_customer = $rs->getString($startcol + 15);

      $this->opt_total_ammount_brutto = $rs->getString($startcol + 16);
      if (null !== $this->opt_total_ammount_brutto && $this->opt_total_ammount_brutto == intval($this->opt_total_ammount_brutto))
      {
        $this->opt_total_ammount_brutto = (string)intval($this->opt_total_ammount_brutto);
      }

      $this->town = $rs->getString($startcol + 17);

      $this->curency = $rs->getString($startcol + 18);

      $this->max_day = $rs->getString($startcol + 19);

      $this->payment_type = $rs->getString($startcol + 20);

      $this->is_proforma = $rs->getBoolean($startcol + 21);

      $this->is_request = $rs->getBoolean($startcol + 22);

      $this->is_confirm = $rs->getBoolean($startcol + 23);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Invoice.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Invoice.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 24)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 24; // 24 = InvoicePeer::NUM_COLUMNS - InvoicePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Invoice object", $e);
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

    if ($this->getDispatcher()->getListeners('Invoice.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Invoice.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseInvoice:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseInvoice:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(InvoicePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      InvoicePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Invoice.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Invoice.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseInvoice:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseInvoice:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Invoice.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Invoice.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseInvoice:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(InvoicePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(InvoicePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(InvoicePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Invoice.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Invoice.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseInvoice:save:post') as $callable)
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

			if ($this->aInvoiceUserSeller !== null) {
				if ($this->aInvoiceUserSeller->isModified()) {
					$affectedRows += $this->aInvoiceUserSeller->save($con);
				}
				$this->setInvoiceUserSeller($this->aInvoiceUserSeller);
			}

			if ($this->aInvoiceUserCustomer !== null) {
				if ($this->aInvoiceUserCustomer->isModified()) {
					$affectedRows += $this->aInvoiceUserCustomer->save($con);
				}
				$this->setInvoiceUserCustomer($this->aInvoiceUserCustomer);
			}

			if ($this->aOrder !== null) {
				if ($this->aOrder->isModified()) {
					$affectedRows += $this->aOrder->save($con);
				}
				$this->setOrder($this->aOrder);
			}

			if ($this->aInvoiceCurrency !== null) {
				if ($this->aInvoiceCurrency->isModified()) {
					$affectedRows += $this->aInvoiceCurrency->save($con);
				}
				$this->setInvoiceCurrency($this->aInvoiceCurrency);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = InvoicePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += InvoicePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collInvoiceStatuss !== null) {
				foreach($this->collInvoiceStatuss as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collInvoiceProducts !== null) {
				foreach($this->collInvoiceProducts as $referrerFK) {
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

			if ($this->aInvoiceUserSeller !== null) {
				if (!$this->aInvoiceUserSeller->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aInvoiceUserSeller->getValidationFailures());
				}
			}

			if ($this->aInvoiceUserCustomer !== null) {
				if (!$this->aInvoiceUserCustomer->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aInvoiceUserCustomer->getValidationFailures());
				}
			}

			if ($this->aOrder !== null) {
				if (!$this->aOrder->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOrder->getValidationFailures());
				}
			}

			if ($this->aInvoiceCurrency !== null) {
				if (!$this->aInvoiceCurrency->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aInvoiceCurrency->getValidationFailures());
				}
			}


			if (($retval = InvoicePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collInvoiceStatuss !== null) {
					foreach($this->collInvoiceStatuss as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collInvoiceProducts !== null) {
					foreach($this->collInvoiceProducts as $referrerFK) {
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
		$pos = InvoicePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getInvoiceUserSellerId();
				break;
			case 4:
				return $this->getInvoiceUserCustomerId();
				break;
			case 5:
				return $this->getOrderId();
				break;
			case 6:
				return $this->getInvoiceCurrencyId();
				break;
			case 7:
				return $this->getInvoiceProformaId();
				break;
			case 8:
				return $this->getCompanyDescription();
				break;
			case 9:
				return $this->getInvoiceDescription();
				break;
			case 10:
				return $this->getOrderDiscount();
				break;
			case 11:
				return $this->getDateSelle();
				break;
			case 12:
				return $this->getDateCreateCopy();
				break;
			case 13:
				return $this->getNumber();
				break;
			case 14:
				return $this->getSignatureSeller();
				break;
			case 15:
				return $this->getSignatureCustomer();
				break;
			case 16:
				return $this->getOptTotalAmmountBrutto();
				break;
			case 17:
				return $this->getTown();
				break;
			case 18:
				return $this->getCurency();
				break;
			case 19:
				return $this->getMaxDay();
				break;
			case 20:
				return $this->getPaymentType();
				break;
			case 21:
				return $this->getIsProforma();
				break;
			case 22:
				return $this->getIsRequest();
				break;
			case 23:
				return $this->getIsConfirm();
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
		$keys = InvoicePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getInvoiceUserSellerId(),
			$keys[4] => $this->getInvoiceUserCustomerId(),
			$keys[5] => $this->getOrderId(),
			$keys[6] => $this->getInvoiceCurrencyId(),
			$keys[7] => $this->getInvoiceProformaId(),
			$keys[8] => $this->getCompanyDescription(),
			$keys[9] => $this->getInvoiceDescription(),
			$keys[10] => $this->getOrderDiscount(),
			$keys[11] => $this->getDateSelle(),
			$keys[12] => $this->getDateCreateCopy(),
			$keys[13] => $this->getNumber(),
			$keys[14] => $this->getSignatureSeller(),
			$keys[15] => $this->getSignatureCustomer(),
			$keys[16] => $this->getOptTotalAmmountBrutto(),
			$keys[17] => $this->getTown(),
			$keys[18] => $this->getCurency(),
			$keys[19] => $this->getMaxDay(),
			$keys[20] => $this->getPaymentType(),
			$keys[21] => $this->getIsProforma(),
			$keys[22] => $this->getIsRequest(),
			$keys[23] => $this->getIsConfirm(),
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
		$pos = InvoicePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setInvoiceUserSellerId($value);
				break;
			case 4:
				$this->setInvoiceUserCustomerId($value);
				break;
			case 5:
				$this->setOrderId($value);
				break;
			case 6:
				$this->setInvoiceCurrencyId($value);
				break;
			case 7:
				$this->setInvoiceProformaId($value);
				break;
			case 8:
				$this->setCompanyDescription($value);
				break;
			case 9:
				$this->setInvoiceDescription($value);
				break;
			case 10:
				$this->setOrderDiscount($value);
				break;
			case 11:
				$this->setDateSelle($value);
				break;
			case 12:
				$this->setDateCreateCopy($value);
				break;
			case 13:
				$this->setNumber($value);
				break;
			case 14:
				$this->setSignatureSeller($value);
				break;
			case 15:
				$this->setSignatureCustomer($value);
				break;
			case 16:
				$this->setOptTotalAmmountBrutto($value);
				break;
			case 17:
				$this->setTown($value);
				break;
			case 18:
				$this->setCurency($value);
				break;
			case 19:
				$this->setMaxDay($value);
				break;
			case 20:
				$this->setPaymentType($value);
				break;
			case 21:
				$this->setIsProforma($value);
				break;
			case 22:
				$this->setIsRequest($value);
				break;
			case 23:
				$this->setIsConfirm($value);
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
		$keys = InvoicePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setInvoiceUserSellerId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setInvoiceUserCustomerId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOrderId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setInvoiceCurrencyId($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setInvoiceProformaId($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCompanyDescription($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setInvoiceDescription($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setOrderDiscount($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setDateSelle($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setDateCreateCopy($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setNumber($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setSignatureSeller($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setSignatureCustomer($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setOptTotalAmmountBrutto($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setTown($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setCurency($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setMaxDay($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setPaymentType($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setIsProforma($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setIsRequest($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setIsConfirm($arr[$keys[23]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(InvoicePeer::DATABASE_NAME);

		if ($this->isColumnModified(InvoicePeer::CREATED_AT)) $criteria->add(InvoicePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(InvoicePeer::UPDATED_AT)) $criteria->add(InvoicePeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(InvoicePeer::ID)) $criteria->add(InvoicePeer::ID, $this->id);
		if ($this->isColumnModified(InvoicePeer::INVOICE_USER_SELLER_ID)) $criteria->add(InvoicePeer::INVOICE_USER_SELLER_ID, $this->invoice_user_seller_id);
		if ($this->isColumnModified(InvoicePeer::INVOICE_USER_CUSTOMER_ID)) $criteria->add(InvoicePeer::INVOICE_USER_CUSTOMER_ID, $this->invoice_user_customer_id);
		if ($this->isColumnModified(InvoicePeer::ORDER_ID)) $criteria->add(InvoicePeer::ORDER_ID, $this->order_id);
		if ($this->isColumnModified(InvoicePeer::INVOICE_CURRENCY_ID)) $criteria->add(InvoicePeer::INVOICE_CURRENCY_ID, $this->invoice_currency_id);
		if ($this->isColumnModified(InvoicePeer::INVOICE_PROFORMA_ID)) $criteria->add(InvoicePeer::INVOICE_PROFORMA_ID, $this->invoice_proforma_id);
		if ($this->isColumnModified(InvoicePeer::COMPANY_DESCRIPTION)) $criteria->add(InvoicePeer::COMPANY_DESCRIPTION, $this->company_description);
		if ($this->isColumnModified(InvoicePeer::INVOICE_DESCRIPTION)) $criteria->add(InvoicePeer::INVOICE_DESCRIPTION, $this->invoice_description);
		if ($this->isColumnModified(InvoicePeer::ORDER_DISCOUNT)) $criteria->add(InvoicePeer::ORDER_DISCOUNT, $this->order_discount);
		if ($this->isColumnModified(InvoicePeer::DATE_SELLE)) $criteria->add(InvoicePeer::DATE_SELLE, $this->date_selle);
		if ($this->isColumnModified(InvoicePeer::DATE_CREATE_COPY)) $criteria->add(InvoicePeer::DATE_CREATE_COPY, $this->date_create_copy);
		if ($this->isColumnModified(InvoicePeer::NUMBER)) $criteria->add(InvoicePeer::NUMBER, $this->number);
		if ($this->isColumnModified(InvoicePeer::SIGNATURE_SELLER)) $criteria->add(InvoicePeer::SIGNATURE_SELLER, $this->signature_seller);
		if ($this->isColumnModified(InvoicePeer::SIGNATURE_CUSTOMER)) $criteria->add(InvoicePeer::SIGNATURE_CUSTOMER, $this->signature_customer);
		if ($this->isColumnModified(InvoicePeer::OPT_TOTAL_AMMOUNT_BRUTTO)) $criteria->add(InvoicePeer::OPT_TOTAL_AMMOUNT_BRUTTO, $this->opt_total_ammount_brutto);
		if ($this->isColumnModified(InvoicePeer::TOWN)) $criteria->add(InvoicePeer::TOWN, $this->town);
		if ($this->isColumnModified(InvoicePeer::CURENCY)) $criteria->add(InvoicePeer::CURENCY, $this->curency);
		if ($this->isColumnModified(InvoicePeer::MAX_DAY)) $criteria->add(InvoicePeer::MAX_DAY, $this->max_day);
		if ($this->isColumnModified(InvoicePeer::PAYMENT_TYPE)) $criteria->add(InvoicePeer::PAYMENT_TYPE, $this->payment_type);
		if ($this->isColumnModified(InvoicePeer::IS_PROFORMA)) $criteria->add(InvoicePeer::IS_PROFORMA, $this->is_proforma);
		if ($this->isColumnModified(InvoicePeer::IS_REQUEST)) $criteria->add(InvoicePeer::IS_REQUEST, $this->is_request);
		if ($this->isColumnModified(InvoicePeer::IS_CONFIRM)) $criteria->add(InvoicePeer::IS_CONFIRM, $this->is_confirm);

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
		$criteria = new Criteria(InvoicePeer::DATABASE_NAME);

		$criteria->add(InvoicePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Invoice (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setInvoiceUserSellerId($this->invoice_user_seller_id);

		$copyObj->setInvoiceUserCustomerId($this->invoice_user_customer_id);

		$copyObj->setOrderId($this->order_id);

		$copyObj->setInvoiceCurrencyId($this->invoice_currency_id);

		$copyObj->setInvoiceProformaId($this->invoice_proforma_id);

		$copyObj->setCompanyDescription($this->company_description);

		$copyObj->setInvoiceDescription($this->invoice_description);

		$copyObj->setOrderDiscount($this->order_discount);

		$copyObj->setDateSelle($this->date_selle);

		$copyObj->setDateCreateCopy($this->date_create_copy);

		$copyObj->setNumber($this->number);

		$copyObj->setSignatureSeller($this->signature_seller);

		$copyObj->setSignatureCustomer($this->signature_customer);

		$copyObj->setOptTotalAmmountBrutto($this->opt_total_ammount_brutto);

		$copyObj->setTown($this->town);

		$copyObj->setCurency($this->curency);

		$copyObj->setMaxDay($this->max_day);

		$copyObj->setPaymentType($this->payment_type);

		$copyObj->setIsProforma($this->is_proforma);

		$copyObj->setIsRequest($this->is_request);

		$copyObj->setIsConfirm($this->is_confirm);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getInvoiceStatuss() as $relObj) {
				$copyObj->addInvoiceStatus($relObj->copy($deepCopy));
			}

			foreach($this->getInvoiceProducts() as $relObj) {
				$copyObj->addInvoiceProduct($relObj->copy($deepCopy));
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
	 * @return     Invoice Clone of current object.
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
	 * @return     InvoicePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new InvoicePeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a InvoiceUserSeller object.
	 *
	 * @param      InvoiceUserSeller $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setInvoiceUserSeller($v)
	{


		if ($v === null) {
			$this->setInvoiceUserSellerId(NULL);
		} else {
			$this->setInvoiceUserSellerId($v->getId());
		}


		$this->aInvoiceUserSeller = $v;
	}


	/**
	 * Get the associated InvoiceUserSeller object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     InvoiceUserSeller The associated InvoiceUserSeller object.
	 * @throws     PropelException
	 */
	public function getInvoiceUserSeller($con = null)
	{
		if ($this->aInvoiceUserSeller === null && ($this->invoice_user_seller_id !== null)) {
			// include the related Peer class
			$this->aInvoiceUserSeller = InvoiceUserSellerPeer::retrieveByPK($this->invoice_user_seller_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = InvoiceUserSellerPeer::retrieveByPK($this->invoice_user_seller_id, $con);
			   $obj->addInvoiceUserSellers($this);
			 */
		}
		return $this->aInvoiceUserSeller;
	}

	/**
	 * Declares an association between this object and a InvoiceUserCustomer object.
	 *
	 * @param      InvoiceUserCustomer $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setInvoiceUserCustomer($v)
	{


		if ($v === null) {
			$this->setInvoiceUserCustomerId(NULL);
		} else {
			$this->setInvoiceUserCustomerId($v->getId());
		}


		$this->aInvoiceUserCustomer = $v;
	}


	/**
	 * Get the associated InvoiceUserCustomer object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     InvoiceUserCustomer The associated InvoiceUserCustomer object.
	 * @throws     PropelException
	 */
	public function getInvoiceUserCustomer($con = null)
	{
		if ($this->aInvoiceUserCustomer === null && ($this->invoice_user_customer_id !== null)) {
			// include the related Peer class
			$this->aInvoiceUserCustomer = InvoiceUserCustomerPeer::retrieveByPK($this->invoice_user_customer_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = InvoiceUserCustomerPeer::retrieveByPK($this->invoice_user_customer_id, $con);
			   $obj->addInvoiceUserCustomers($this);
			 */
		}
		return $this->aInvoiceUserCustomer;
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
	 * Declares an association between this object and a InvoiceCurrency object.
	 *
	 * @param      InvoiceCurrency $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setInvoiceCurrency($v)
	{


		if ($v === null) {
			$this->setInvoiceCurrencyId(NULL);
		} else {
			$this->setInvoiceCurrencyId($v->getId());
		}


		$this->aInvoiceCurrency = $v;
	}


	/**
	 * Get the associated InvoiceCurrency object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     InvoiceCurrency The associated InvoiceCurrency object.
	 * @throws     PropelException
	 */
	public function getInvoiceCurrency($con = null)
	{
		if ($this->aInvoiceCurrency === null && ($this->invoice_currency_id !== null)) {
			// include the related Peer class
			$this->aInvoiceCurrency = InvoiceCurrencyPeer::retrieveByPK($this->invoice_currency_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = InvoiceCurrencyPeer::retrieveByPK($this->invoice_currency_id, $con);
			   $obj->addInvoiceCurrencys($this);
			 */
		}
		return $this->aInvoiceCurrency;
	}

	/**
	 * Temporary storage of collInvoiceStatuss to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initInvoiceStatuss()
	{
		if ($this->collInvoiceStatuss === null) {
			$this->collInvoiceStatuss = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Invoice has previously
	 * been saved, it will retrieve related InvoiceStatuss from storage.
	 * If this Invoice is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getInvoiceStatuss($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collInvoiceStatuss === null) {
			if ($this->isNew()) {
			   $this->collInvoiceStatuss = array();
			} else {

				$criteria->add(InvoiceStatusPeer::INVOICE_ID, $this->getId());

				InvoiceStatusPeer::addSelectColumns($criteria);
				$this->collInvoiceStatuss = InvoiceStatusPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(InvoiceStatusPeer::INVOICE_ID, $this->getId());

				InvoiceStatusPeer::addSelectColumns($criteria);
				if (!isset($this->lastInvoiceStatusCriteria) || !$this->lastInvoiceStatusCriteria->equals($criteria)) {
					$this->collInvoiceStatuss = InvoiceStatusPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastInvoiceStatusCriteria = $criteria;
		return $this->collInvoiceStatuss;
	}

	/**
	 * Returns the number of related InvoiceStatuss.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countInvoiceStatuss($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(InvoiceStatusPeer::INVOICE_ID, $this->getId());

		return InvoiceStatusPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a InvoiceStatus object to this object
	 * through the InvoiceStatus foreign key attribute
	 *
	 * @param      InvoiceStatus $l InvoiceStatus
	 * @return     void
	 * @throws     PropelException
	 */
	public function addInvoiceStatus(InvoiceStatus $l)
	{
		$this->collInvoiceStatuss[] = $l;
		$l->setInvoice($this);
	}

	/**
	 * Temporary storage of collInvoiceProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initInvoiceProducts()
	{
		if ($this->collInvoiceProducts === null) {
			$this->collInvoiceProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Invoice has previously
	 * been saved, it will retrieve related InvoiceProducts from storage.
	 * If this Invoice is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getInvoiceProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collInvoiceProducts === null) {
			if ($this->isNew()) {
			   $this->collInvoiceProducts = array();
			} else {

				$criteria->add(InvoiceProductPeer::INVOICE_ID, $this->getId());

				InvoiceProductPeer::addSelectColumns($criteria);
				$this->collInvoiceProducts = InvoiceProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(InvoiceProductPeer::INVOICE_ID, $this->getId());

				InvoiceProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastInvoiceProductCriteria) || !$this->lastInvoiceProductCriteria->equals($criteria)) {
					$this->collInvoiceProducts = InvoiceProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastInvoiceProductCriteria = $criteria;
		return $this->collInvoiceProducts;
	}

	/**
	 * Returns the number of related InvoiceProducts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countInvoiceProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(InvoiceProductPeer::INVOICE_ID, $this->getId());

		return InvoiceProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a InvoiceProduct object to this object
	 * through the InvoiceProduct foreign key attribute
	 *
	 * @param      InvoiceProduct $l InvoiceProduct
	 * @return     void
	 * @throws     PropelException
	 */
	public function addInvoiceProduct(InvoiceProduct $l)
	{
		$this->collInvoiceProducts[] = $l;
		$l->setInvoice($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Invoice is new, it will return
	 * an empty collection; or if this Invoice has previously
	 * been saved, it will retrieve related InvoiceProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Invoice.
	 */
	public function getInvoiceProductsJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collInvoiceProducts === null) {
			if ($this->isNew()) {
				$this->collInvoiceProducts = array();
			} else {

				$criteria->add(InvoiceProductPeer::INVOICE_ID, $this->getId());

				$this->collInvoiceProducts = InvoiceProductPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(InvoiceProductPeer::INVOICE_ID, $this->getId());

			if (!isset($this->lastInvoiceProductCriteria) || !$this->lastInvoiceProductCriteria->equals($criteria)) {
				$this->collInvoiceProducts = InvoiceProductPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastInvoiceProductCriteria = $criteria;

		return $this->collInvoiceProducts;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Invoice.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseInvoice:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseInvoice::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseInvoice
