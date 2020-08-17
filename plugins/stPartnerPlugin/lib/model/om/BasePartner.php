<?php

/**
 * Base class that represents a row from the 'st_partner' table.
 *
 * 
 *
 * @package    plugins.stPartnerPlugin.lib.model.om
 */
abstract class BasePartner extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PartnerPeer
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
	 * The value for the countries_id field.
	 * @var        int
	 */
	protected $countries_id;


	/**
	 * The value for the sf_guard_user_id field.
	 * @var        int
	 */
	protected $sf_guard_user_id;


	/**
	 * The value for the company field.
	 * @var        string
	 */
	protected $company;


	/**
	 * The value for the vat_number field.
	 * @var        string
	 */
	protected $vat_number;


	/**
	 * The value for the bank_number field.
	 * @var        string
	 */
	protected $bank_number;


	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the surname field.
	 * @var        string
	 */
	protected $surname;


	/**
	 * The value for the street field.
	 * @var        string
	 */
	protected $street;


	/**
	 * The value for the house field.
	 * @var        string
	 */
	protected $house;


	/**
	 * The value for the flat field.
	 * @var        string
	 */
	protected $flat;


	/**
	 * The value for the code field.
	 * @var        string
	 */
	protected $code;


	/**
	 * The value for the town field.
	 * @var        string
	 */
	protected $town;


	/**
	 * The value for the phone field.
	 * @var        string
	 */
	protected $phone;


	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;


	/**
	 * The value for the provision field.
	 * @var        string
	 */
	protected $provision;


	/**
	 * The value for the amount field.
	 * @var        string
	 */
	protected $amount;


	/**
	 * The value for the system_value field.
	 * @var        int
	 */
	protected $system_value;


	/**
	 * The value for the is_active field.
	 * @var        boolean
	 */
	protected $is_active = true;


	/**
	 * The value for the is_system field.
	 * @var        boolean
	 */
	protected $is_system = false;


	/**
	 * The value for the is_confirm field.
	 * @var        boolean
	 */
	protected $is_confirm = false;

	/**
	 * @var        Countries
	 */
	protected $aCountries;

	/**
	 * @var        sfGuardUser
	 */
	protected $asfGuardUser;

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
	 * Collection to store aggregation of collPartnerHashs.
	 * @var        array
	 */
	protected $collPartnerHashs;

	/**
	 * The criteria used to select the current contents of collPartnerHashs.
	 * @var        Criteria
	 */
	protected $lastPartnerHashCriteria = null;

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
     * Get the [countries_id] column value.
     * 
     * @return     int
     */
    public function getCountriesId()
    {

            return $this->countries_id;
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
     * Get the [company] column value.
     * 
     * @return     string
     */
    public function getCompany()
    {

            return $this->company;
    }

    /**
     * Get the [vat_number] column value.
     * 
     * @return     string
     */
    public function getVatNumber()
    {

            return $this->vat_number;
    }

    /**
     * Get the [bank_number] column value.
     * 
     * @return     string
     */
    public function getBankNumber()
    {

            return $this->bank_number;
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
     * Get the [surname] column value.
     * 
     * @return     string
     */
    public function getSurname()
    {

            return $this->surname;
    }

    /**
     * Get the [street] column value.
     * 
     * @return     string
     */
    public function getStreet()
    {

            return $this->street;
    }

    /**
     * Get the [house] column value.
     * 
     * @return     string
     */
    public function getHouse()
    {

            return $this->house;
    }

    /**
     * Get the [flat] column value.
     * 
     * @return     string
     */
    public function getFlat()
    {

            return $this->flat;
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
     * Get the [town] column value.
     * 
     * @return     string
     */
    public function getTown()
    {

            return $this->town;
    }

    /**
     * Get the [phone] column value.
     * 
     * @return     string
     */
    public function getPhone()
    {

            return $this->phone;
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
     * Get the [provision] column value.
     * 
     * @return     string
     */
    public function getProvision()
    {

            return $this->provision;
    }

    /**
     * Get the [amount] column value.
     * 
     * @return     string
     */
    public function getAmount()
    {

            return $this->amount;
    }

    /**
     * Get the [system_value] column value.
     * 
     * @return     int
     */
    public function getSystemValue()
    {

            return $this->system_value;
    }

    /**
     * Get the [is_active] column value.
     * 
     * @return     boolean
     */
    public function getIsActive()
    {

            return $this->is_active;
    }

    /**
     * Get the [is_system] column value.
     * 
     * @return     boolean
     */
    public function getIsSystem()
    {

            return $this->is_system;
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
			$this->modifiedColumns[] = PartnerPeer::CREATED_AT;
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
			$this->modifiedColumns[] = PartnerPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = PartnerPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [countries_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCountriesId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->countries_id !== $v) {
          $this->countries_id = $v;
          $this->modifiedColumns[] = PartnerPeer::COUNTRIES_ID;
        }

		if ($this->aCountries !== null && $this->aCountries->getId() !== $v) {
			$this->aCountries = null;
		}

	} // setCountriesId()

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
          $this->modifiedColumns[] = PartnerPeer::SF_GUARD_USER_ID;
        }

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} // setSfGuardUserId()

	/**
	 * Set the value of [company] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCompany($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->company !== $v) {
          $this->company = $v;
          $this->modifiedColumns[] = PartnerPeer::COMPANY;
        }

	} // setCompany()

	/**
	 * Set the value of [vat_number] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setVatNumber($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->vat_number !== $v) {
          $this->vat_number = $v;
          $this->modifiedColumns[] = PartnerPeer::VAT_NUMBER;
        }

	} // setVatNumber()

	/**
	 * Set the value of [bank_number] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setBankNumber($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->bank_number !== $v) {
          $this->bank_number = $v;
          $this->modifiedColumns[] = PartnerPeer::BANK_NUMBER;
        }

	} // setBankNumber()

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
          $this->modifiedColumns[] = PartnerPeer::NAME;
        }

	} // setName()

	/**
	 * Set the value of [surname] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setSurname($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->surname !== $v) {
          $this->surname = $v;
          $this->modifiedColumns[] = PartnerPeer::SURNAME;
        }

	} // setSurname()

	/**
	 * Set the value of [street] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setStreet($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->street !== $v) {
          $this->street = $v;
          $this->modifiedColumns[] = PartnerPeer::STREET;
        }

	} // setStreet()

	/**
	 * Set the value of [house] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setHouse($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->house !== $v) {
          $this->house = $v;
          $this->modifiedColumns[] = PartnerPeer::HOUSE;
        }

	} // setHouse()

	/**
	 * Set the value of [flat] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFlat($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->flat !== $v) {
          $this->flat = $v;
          $this->modifiedColumns[] = PartnerPeer::FLAT;
        }

	} // setFlat()

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
          $this->modifiedColumns[] = PartnerPeer::CODE;
        }

	} // setCode()

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
          $this->modifiedColumns[] = PartnerPeer::TOWN;
        }

	} // setTown()

	/**
	 * Set the value of [phone] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPhone($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->phone !== $v) {
          $this->phone = $v;
          $this->modifiedColumns[] = PartnerPeer::PHONE;
        }

	} // setPhone()

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
          $this->modifiedColumns[] = PartnerPeer::DESCRIPTION;
        }

	} // setDescription()

	/**
	 * Set the value of [provision] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setProvision($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->provision !== $v) {
          $this->provision = $v;
          $this->modifiedColumns[] = PartnerPeer::PROVISION;
        }

	} // setProvision()

	/**
	 * Set the value of [amount] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setAmount($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->amount !== $v) {
          $this->amount = $v;
          $this->modifiedColumns[] = PartnerPeer::AMOUNT;
        }

	} // setAmount()

	/**
	 * Set the value of [system_value] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setSystemValue($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->system_value !== $v) {
          $this->system_value = $v;
          $this->modifiedColumns[] = PartnerPeer::SYSTEM_VALUE;
        }

	} // setSystemValue()

	/**
	 * Set the value of [is_active] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsActive($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_active !== $v || $v === true) {
          $this->is_active = $v;
          $this->modifiedColumns[] = PartnerPeer::IS_ACTIVE;
        }

	} // setIsActive()

	/**
	 * Set the value of [is_system] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsSystem($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_system !== $v || $v === false) {
          $this->is_system = $v;
          $this->modifiedColumns[] = PartnerPeer::IS_SYSTEM;
        }

	} // setIsSystem()

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
          $this->modifiedColumns[] = PartnerPeer::IS_CONFIRM;
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
      if ($this->getDispatcher()->getListeners('Partner.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Partner.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->countries_id = $rs->getInt($startcol + 3);

      $this->sf_guard_user_id = $rs->getInt($startcol + 4);

      $this->company = $rs->getString($startcol + 5);

      $this->vat_number = $rs->getString($startcol + 6);

      $this->bank_number = $rs->getString($startcol + 7);

      $this->name = $rs->getString($startcol + 8);

      $this->surname = $rs->getString($startcol + 9);

      $this->street = $rs->getString($startcol + 10);

      $this->house = $rs->getString($startcol + 11);

      $this->flat = $rs->getString($startcol + 12);

      $this->code = $rs->getString($startcol + 13);

      $this->town = $rs->getString($startcol + 14);

      $this->phone = $rs->getString($startcol + 15);

      $this->description = $rs->getString($startcol + 16);

      $this->provision = $rs->getString($startcol + 17);

      $this->amount = $rs->getString($startcol + 18);

      $this->system_value = $rs->getInt($startcol + 19);

      $this->is_active = $rs->getBoolean($startcol + 20);

      $this->is_system = $rs->getBoolean($startcol + 21);

      $this->is_confirm = $rs->getBoolean($startcol + 22);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Partner.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Partner.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 23)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 23; // 23 = PartnerPeer::NUM_COLUMNS - PartnerPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Partner object", $e);
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

    if ($this->getDispatcher()->getListeners('Partner.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Partner.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePartner:delete:pre'))
    {
      foreach (sfMixer::getCallables('BasePartner:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(PartnerPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      PartnerPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Partner.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Partner.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePartner:delete:post'))
    {
      foreach (sfMixer::getCallables('BasePartner:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Partner.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Partner.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BasePartner:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(PartnerPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(PartnerPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(PartnerPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Partner.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Partner.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BasePartner:save:post') as $callable)
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

			if ($this->aCountries !== null) {
				if ($this->aCountries->isModified() || $this->aCountries->getCurrentCountriesI18n()->isModified()) {
					$affectedRows += $this->aCountries->save($con);
				}
				$this->setCountries($this->aCountries);
			}

			if ($this->asfGuardUser !== null) {
				if ($this->asfGuardUser->isModified()) {
					$affectedRows += $this->asfGuardUser->save($con);
				}
				$this->setsfGuardUser($this->asfGuardUser);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PartnerPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PartnerPeer::doUpdate($this, $con);
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

			if ($this->collPartnerHashs !== null) {
				foreach($this->collPartnerHashs as $referrerFK) {
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

			if ($this->aCountries !== null) {
				if (!$this->aCountries->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCountries->getValidationFailures());
				}
			}

			if ($this->asfGuardUser !== null) {
				if (!$this->asfGuardUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUser->getValidationFailures());
				}
			}


			if (($retval = PartnerPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOrders !== null) {
					foreach($this->collOrders as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPartnerHashs !== null) {
					foreach($this->collPartnerHashs as $referrerFK) {
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
		$pos = PartnerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCountriesId();
				break;
			case 4:
				return $this->getSfGuardUserId();
				break;
			case 5:
				return $this->getCompany();
				break;
			case 6:
				return $this->getVatNumber();
				break;
			case 7:
				return $this->getBankNumber();
				break;
			case 8:
				return $this->getName();
				break;
			case 9:
				return $this->getSurname();
				break;
			case 10:
				return $this->getStreet();
				break;
			case 11:
				return $this->getHouse();
				break;
			case 12:
				return $this->getFlat();
				break;
			case 13:
				return $this->getCode();
				break;
			case 14:
				return $this->getTown();
				break;
			case 15:
				return $this->getPhone();
				break;
			case 16:
				return $this->getDescription();
				break;
			case 17:
				return $this->getProvision();
				break;
			case 18:
				return $this->getAmount();
				break;
			case 19:
				return $this->getSystemValue();
				break;
			case 20:
				return $this->getIsActive();
				break;
			case 21:
				return $this->getIsSystem();
				break;
			case 22:
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
		$keys = PartnerPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getCountriesId(),
			$keys[4] => $this->getSfGuardUserId(),
			$keys[5] => $this->getCompany(),
			$keys[6] => $this->getVatNumber(),
			$keys[7] => $this->getBankNumber(),
			$keys[8] => $this->getName(),
			$keys[9] => $this->getSurname(),
			$keys[10] => $this->getStreet(),
			$keys[11] => $this->getHouse(),
			$keys[12] => $this->getFlat(),
			$keys[13] => $this->getCode(),
			$keys[14] => $this->getTown(),
			$keys[15] => $this->getPhone(),
			$keys[16] => $this->getDescription(),
			$keys[17] => $this->getProvision(),
			$keys[18] => $this->getAmount(),
			$keys[19] => $this->getSystemValue(),
			$keys[20] => $this->getIsActive(),
			$keys[21] => $this->getIsSystem(),
			$keys[22] => $this->getIsConfirm(),
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
		$pos = PartnerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setCountriesId($value);
				break;
			case 4:
				$this->setSfGuardUserId($value);
				break;
			case 5:
				$this->setCompany($value);
				break;
			case 6:
				$this->setVatNumber($value);
				break;
			case 7:
				$this->setBankNumber($value);
				break;
			case 8:
				$this->setName($value);
				break;
			case 9:
				$this->setSurname($value);
				break;
			case 10:
				$this->setStreet($value);
				break;
			case 11:
				$this->setHouse($value);
				break;
			case 12:
				$this->setFlat($value);
				break;
			case 13:
				$this->setCode($value);
				break;
			case 14:
				$this->setTown($value);
				break;
			case 15:
				$this->setPhone($value);
				break;
			case 16:
				$this->setDescription($value);
				break;
			case 17:
				$this->setProvision($value);
				break;
			case 18:
				$this->setAmount($value);
				break;
			case 19:
				$this->setSystemValue($value);
				break;
			case 20:
				$this->setIsActive($value);
				break;
			case 21:
				$this->setIsSystem($value);
				break;
			case 22:
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
		$keys = PartnerPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCountriesId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSfGuardUserId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCompany($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setVatNumber($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setBankNumber($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setName($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setSurname($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setStreet($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setHouse($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setFlat($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setCode($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setTown($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setPhone($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setDescription($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setProvision($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setAmount($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setSystemValue($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setIsActive($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setIsSystem($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setIsConfirm($arr[$keys[22]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PartnerPeer::DATABASE_NAME);

		if ($this->isColumnModified(PartnerPeer::CREATED_AT)) $criteria->add(PartnerPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(PartnerPeer::UPDATED_AT)) $criteria->add(PartnerPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(PartnerPeer::ID)) $criteria->add(PartnerPeer::ID, $this->id);
		if ($this->isColumnModified(PartnerPeer::COUNTRIES_ID)) $criteria->add(PartnerPeer::COUNTRIES_ID, $this->countries_id);
		if ($this->isColumnModified(PartnerPeer::SF_GUARD_USER_ID)) $criteria->add(PartnerPeer::SF_GUARD_USER_ID, $this->sf_guard_user_id);
		if ($this->isColumnModified(PartnerPeer::COMPANY)) $criteria->add(PartnerPeer::COMPANY, $this->company);
		if ($this->isColumnModified(PartnerPeer::VAT_NUMBER)) $criteria->add(PartnerPeer::VAT_NUMBER, $this->vat_number);
		if ($this->isColumnModified(PartnerPeer::BANK_NUMBER)) $criteria->add(PartnerPeer::BANK_NUMBER, $this->bank_number);
		if ($this->isColumnModified(PartnerPeer::NAME)) $criteria->add(PartnerPeer::NAME, $this->name);
		if ($this->isColumnModified(PartnerPeer::SURNAME)) $criteria->add(PartnerPeer::SURNAME, $this->surname);
		if ($this->isColumnModified(PartnerPeer::STREET)) $criteria->add(PartnerPeer::STREET, $this->street);
		if ($this->isColumnModified(PartnerPeer::HOUSE)) $criteria->add(PartnerPeer::HOUSE, $this->house);
		if ($this->isColumnModified(PartnerPeer::FLAT)) $criteria->add(PartnerPeer::FLAT, $this->flat);
		if ($this->isColumnModified(PartnerPeer::CODE)) $criteria->add(PartnerPeer::CODE, $this->code);
		if ($this->isColumnModified(PartnerPeer::TOWN)) $criteria->add(PartnerPeer::TOWN, $this->town);
		if ($this->isColumnModified(PartnerPeer::PHONE)) $criteria->add(PartnerPeer::PHONE, $this->phone);
		if ($this->isColumnModified(PartnerPeer::DESCRIPTION)) $criteria->add(PartnerPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(PartnerPeer::PROVISION)) $criteria->add(PartnerPeer::PROVISION, $this->provision);
		if ($this->isColumnModified(PartnerPeer::AMOUNT)) $criteria->add(PartnerPeer::AMOUNT, $this->amount);
		if ($this->isColumnModified(PartnerPeer::SYSTEM_VALUE)) $criteria->add(PartnerPeer::SYSTEM_VALUE, $this->system_value);
		if ($this->isColumnModified(PartnerPeer::IS_ACTIVE)) $criteria->add(PartnerPeer::IS_ACTIVE, $this->is_active);
		if ($this->isColumnModified(PartnerPeer::IS_SYSTEM)) $criteria->add(PartnerPeer::IS_SYSTEM, $this->is_system);
		if ($this->isColumnModified(PartnerPeer::IS_CONFIRM)) $criteria->add(PartnerPeer::IS_CONFIRM, $this->is_confirm);

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
		$criteria = new Criteria(PartnerPeer::DATABASE_NAME);

		$criteria->add(PartnerPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Partner (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setCountriesId($this->countries_id);

		$copyObj->setSfGuardUserId($this->sf_guard_user_id);

		$copyObj->setCompany($this->company);

		$copyObj->setVatNumber($this->vat_number);

		$copyObj->setBankNumber($this->bank_number);

		$copyObj->setName($this->name);

		$copyObj->setSurname($this->surname);

		$copyObj->setStreet($this->street);

		$copyObj->setHouse($this->house);

		$copyObj->setFlat($this->flat);

		$copyObj->setCode($this->code);

		$copyObj->setTown($this->town);

		$copyObj->setPhone($this->phone);

		$copyObj->setDescription($this->description);

		$copyObj->setProvision($this->provision);

		$copyObj->setAmount($this->amount);

		$copyObj->setSystemValue($this->system_value);

		$copyObj->setIsActive($this->is_active);

		$copyObj->setIsSystem($this->is_system);

		$copyObj->setIsConfirm($this->is_confirm);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getOrders() as $relObj) {
				$copyObj->addOrder($relObj->copy($deepCopy));
			}

			foreach($this->getPartnerHashs() as $relObj) {
				$copyObj->addPartnerHash($relObj->copy($deepCopy));
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
	 * @return     Partner Clone of current object.
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
	 * @return     PartnerPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PartnerPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Countries object.
	 *
	 * @param      Countries $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setCountries($v)
	{


		if ($v === null) {
			$this->setCountriesId(NULL);
		} else {
			$this->setCountriesId($v->getId());
		}


		$this->aCountries = $v;
	}


	/**
	 * Get the associated Countries object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Countries The associated Countries object.
	 * @throws     PropelException
	 */
	public function getCountries($con = null)
	{
		if ($this->aCountries === null && ($this->countries_id !== null)) {
			// include the related Peer class
			$this->aCountries = CountriesPeer::retrieveByPK($this->countries_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = CountriesPeer::retrieveByPK($this->countries_id, $con);
			   $obj->addCountriess($this);
			 */
		}
		return $this->aCountries;
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
	 * Otherwise if this Partner has previously
	 * been saved, it will retrieve related Orders from storage.
	 * If this Partner is new, it will return
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

				$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

				OrderPeer::addSelectColumns($criteria);
				$this->collOrders = OrderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

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

		$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

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
		$l->setPartner($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Partner is new, it will return
	 * an empty collection; or if this Partner has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Partner.
	 */
	public function getOrdersJoinOrderDelivery($criteria = null, $con = null)
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

				$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinOrderDelivery($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Partner is new, it will return
	 * an empty collection; or if this Partner has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Partner.
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

				$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

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
	 * Otherwise if this Partner is new, it will return
	 * an empty collection; or if this Partner has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Partner.
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

				$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

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
	 * Otherwise if this Partner is new, it will return
	 * an empty collection; or if this Partner has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Partner.
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

				$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataBilling($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

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
	 * Otherwise if this Partner is new, it will return
	 * an empty collection; or if this Partner has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Partner.
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

				$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

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
	 * Otherwise if this Partner is new, it will return
	 * an empty collection; or if this Partner has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Partner.
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

				$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderStatus($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

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
	 * Otherwise if this Partner is new, it will return
	 * an empty collection; or if this Partner has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Partner.
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

				$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

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
	 * Otherwise if this Partner is new, it will return
	 * an empty collection; or if this Partner has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Partner.
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

				$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinDiscount($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::PARTNER_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinDiscount($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}

	/**
	 * Temporary storage of collPartnerHashs to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPartnerHashs()
	{
		if ($this->collPartnerHashs === null) {
			$this->collPartnerHashs = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Partner has previously
	 * been saved, it will retrieve related PartnerHashs from storage.
	 * If this Partner is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPartnerHashs($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPartnerHashs === null) {
			if ($this->isNew()) {
			   $this->collPartnerHashs = array();
			} else {

				$criteria->add(PartnerHashPeer::PARTNER_ID, $this->getId());

				PartnerHashPeer::addSelectColumns($criteria);
				$this->collPartnerHashs = PartnerHashPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PartnerHashPeer::PARTNER_ID, $this->getId());

				PartnerHashPeer::addSelectColumns($criteria);
				if (!isset($this->lastPartnerHashCriteria) || !$this->lastPartnerHashCriteria->equals($criteria)) {
					$this->collPartnerHashs = PartnerHashPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPartnerHashCriteria = $criteria;
		return $this->collPartnerHashs;
	}

	/**
	 * Returns the number of related PartnerHashs.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPartnerHashs($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PartnerHashPeer::PARTNER_ID, $this->getId());

		return PartnerHashPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a PartnerHash object to this object
	 * through the PartnerHash foreign key attribute
	 *
	 * @param      PartnerHash $l PartnerHash
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPartnerHash(PartnerHash $l)
	{
		$this->collPartnerHashs[] = $l;
		$l->setPartner($this);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Partner.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BasePartner:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BasePartner::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BasePartner
