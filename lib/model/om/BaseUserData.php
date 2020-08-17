<?php

/**
 * Base class that represents a row from the 'st_user_data' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseUserData extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        UserDataPeer
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
	 * The value for the sf_guard_user_id field.
	 * @var        int
	 */
	protected $sf_guard_user_id;


	/**
	 * The value for the countries_id field.
	 * @var        int
	 */
	protected $countries_id;


	/**
	 * The value for the is_billing field.
	 * @var        boolean
	 */
	protected $is_billing;


	/**
	 * The value for the is_default field.
	 * @var        boolean
	 */
	protected $is_default = false;


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
	 * The value for the full_name field.
	 * @var        string
	 */
	protected $full_name;


	/**
	 * The value for the address field.
	 * @var        string
	 */
	protected $address;


	/**
	 * The value for the address_more field.
	 * @var        string
	 */
	protected $address_more;


	/**
	 * The value for the region field.
	 * @var        string
	 */
	protected $region;


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
	 * The value for the pesel field.
	 * @var        string
	 */
	protected $pesel;


	/**
	 * The value for the crypt field.
	 * @var        boolean
	 */
	protected $crypt = false;

	/**
	 * @var        sfGuardUser
	 */
	protected $asfGuardUser;

	/**
	 * @var        Countries
	 */
	protected $aCountries;

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
     * Get the [sf_guard_user_id] column value.
     * 
     * @return     int
     */
    public function getSfGuardUserId()
    {

            return $this->sf_guard_user_id;
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
     * Get the [is_billing] column value.
     * 
     * @return     boolean
     */
    public function getIsBilling()
    {

            return $this->is_billing;
    }

    /**
     * Get the [is_default] column value.
     * 
     * @return     boolean
     */
    public function getIsDefault()
    {

            return $this->is_default;
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
     * Get the [full_name] column value.
     * 
     * @return     string
     */
    public function getFullName()
    {

            return $this->full_name;
    }

    /**
     * Get the [address] column value.
     * 
     * @return     string
     */
    public function getAddress()
    {

            return $this->address;
    }

    /**
     * Get the [address_more] column value.
     * 
     * @return     string
     */
    public function getAddressMore()
    {

            return $this->address_more;
    }

    /**
     * Get the [region] column value.
     * 
     * @return     string
     */
    public function getRegion()
    {

            return $this->region;
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
     * Get the [pesel] column value.
     * 
     * @return     string
     */
    public function getPesel()
    {

            return $this->pesel;
    }

    /**
     * Get the [crypt] column value.
     * 
     * @return     boolean
     */
    public function getCrypt()
    {

            return $this->crypt;
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
			$this->modifiedColumns[] = UserDataPeer::CREATED_AT;
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
			$this->modifiedColumns[] = UserDataPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = UserDataPeer::ID;
        }

	} // setId()

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
          $this->modifiedColumns[] = UserDataPeer::SF_GUARD_USER_ID;
        }

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} // setSfGuardUserId()

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
          $this->modifiedColumns[] = UserDataPeer::COUNTRIES_ID;
        }

		if ($this->aCountries !== null && $this->aCountries->getId() !== $v) {
			$this->aCountries = null;
		}

	} // setCountriesId()

	/**
	 * Set the value of [is_billing] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsBilling($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_billing !== $v) {
          $this->is_billing = $v;
          $this->modifiedColumns[] = UserDataPeer::IS_BILLING;
        }

	} // setIsBilling()

	/**
	 * Set the value of [is_default] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsDefault($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_default !== $v || $v === false) {
          $this->is_default = $v;
          $this->modifiedColumns[] = UserDataPeer::IS_DEFAULT;
        }

	} // setIsDefault()

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
          $this->modifiedColumns[] = UserDataPeer::NAME;
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
          $this->modifiedColumns[] = UserDataPeer::SURNAME;
        }

	} // setSurname()

	/**
	 * Set the value of [full_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFullName($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->full_name !== $v) {
          $this->full_name = $v;
          $this->modifiedColumns[] = UserDataPeer::FULL_NAME;
        }

	} // setFullName()

	/**
	 * Set the value of [address] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setAddress($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->address !== $v) {
          $this->address = $v;
          $this->modifiedColumns[] = UserDataPeer::ADDRESS;
        }

	} // setAddress()

	/**
	 * Set the value of [address_more] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setAddressMore($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->address_more !== $v) {
          $this->address_more = $v;
          $this->modifiedColumns[] = UserDataPeer::ADDRESS_MORE;
        }

	} // setAddressMore()

	/**
	 * Set the value of [region] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setRegion($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->region !== $v) {
          $this->region = $v;
          $this->modifiedColumns[] = UserDataPeer::REGION;
        }

	} // setRegion()

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
          $this->modifiedColumns[] = UserDataPeer::STREET;
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
          $this->modifiedColumns[] = UserDataPeer::HOUSE;
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
          $this->modifiedColumns[] = UserDataPeer::FLAT;
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
          $this->modifiedColumns[] = UserDataPeer::CODE;
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
          $this->modifiedColumns[] = UserDataPeer::TOWN;
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
          $this->modifiedColumns[] = UserDataPeer::PHONE;
        }

	} // setPhone()

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
          $this->modifiedColumns[] = UserDataPeer::COMPANY;
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
          $this->modifiedColumns[] = UserDataPeer::VAT_NUMBER;
        }

	} // setVatNumber()

	/**
	 * Set the value of [pesel] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPesel($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->pesel !== $v) {
          $this->pesel = $v;
          $this->modifiedColumns[] = UserDataPeer::PESEL;
        }

	} // setPesel()

	/**
	 * Set the value of [crypt] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setCrypt($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->crypt !== $v || $v === false) {
          $this->crypt = $v;
          $this->modifiedColumns[] = UserDataPeer::CRYPT;
        }

	} // setCrypt()

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
      if ($this->getDispatcher()->getListeners('UserData.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'UserData.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->sf_guard_user_id = $rs->getInt($startcol + 3);

      $this->countries_id = $rs->getInt($startcol + 4);

      $this->is_billing = $rs->getBoolean($startcol + 5);

      $this->is_default = $rs->getBoolean($startcol + 6);

      $this->name = $rs->getString($startcol + 7);

      $this->surname = $rs->getString($startcol + 8);

      $this->full_name = $rs->getString($startcol + 9);

      $this->address = $rs->getString($startcol + 10);

      $this->address_more = $rs->getString($startcol + 11);

      $this->region = $rs->getString($startcol + 12);

      $this->street = $rs->getString($startcol + 13);

      $this->house = $rs->getString($startcol + 14);

      $this->flat = $rs->getString($startcol + 15);

      $this->code = $rs->getString($startcol + 16);

      $this->town = $rs->getString($startcol + 17);

      $this->phone = $rs->getString($startcol + 18);

      $this->company = $rs->getString($startcol + 19);

      $this->vat_number = $rs->getString($startcol + 20);

      $this->pesel = $rs->getString($startcol + 21);

      $this->crypt = $rs->getBoolean($startcol + 22);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('UserData.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'UserData.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 23)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 23; // 23 = UserDataPeer::NUM_COLUMNS - UserDataPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating UserData object", $e);
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

    if ($this->getDispatcher()->getListeners('UserData.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'UserData.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseUserData:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseUserData:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(UserDataPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      UserDataPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('UserData.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'UserData.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseUserData:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseUserData:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('UserData.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'UserData.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseUserData:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(UserDataPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(UserDataPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(UserDataPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('UserData.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'UserData.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseUserData:save:post') as $callable)
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

			if ($this->asfGuardUser !== null) {
				if ($this->asfGuardUser->isModified()) {
					$affectedRows += $this->asfGuardUser->save($con);
				}
				$this->setsfGuardUser($this->asfGuardUser);
			}

			if ($this->aCountries !== null) {
				if ($this->aCountries->isModified() || $this->aCountries->getCurrentCountriesI18n()->isModified()) {
					$affectedRows += $this->aCountries->save($con);
				}
				$this->setCountries($this->aCountries);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = UserDataPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += UserDataPeer::doUpdate($this, $con);
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

			if ($this->asfGuardUser !== null) {
				if (!$this->asfGuardUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUser->getValidationFailures());
				}
			}

			if ($this->aCountries !== null) {
				if (!$this->aCountries->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCountries->getValidationFailures());
				}
			}


			if (($retval = UserDataPeer::doValidate($this, $columns)) !== true) {
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
		$pos = UserDataPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getSfGuardUserId();
				break;
			case 4:
				return $this->getCountriesId();
				break;
			case 5:
				return $this->getIsBilling();
				break;
			case 6:
				return $this->getIsDefault();
				break;
			case 7:
				return $this->getName();
				break;
			case 8:
				return $this->getSurname();
				break;
			case 9:
				return $this->getFullName();
				break;
			case 10:
				return $this->getAddress();
				break;
			case 11:
				return $this->getAddressMore();
				break;
			case 12:
				return $this->getRegion();
				break;
			case 13:
				return $this->getStreet();
				break;
			case 14:
				return $this->getHouse();
				break;
			case 15:
				return $this->getFlat();
				break;
			case 16:
				return $this->getCode();
				break;
			case 17:
				return $this->getTown();
				break;
			case 18:
				return $this->getPhone();
				break;
			case 19:
				return $this->getCompany();
				break;
			case 20:
				return $this->getVatNumber();
				break;
			case 21:
				return $this->getPesel();
				break;
			case 22:
				return $this->getCrypt();
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
		$keys = UserDataPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getSfGuardUserId(),
			$keys[4] => $this->getCountriesId(),
			$keys[5] => $this->getIsBilling(),
			$keys[6] => $this->getIsDefault(),
			$keys[7] => $this->getName(),
			$keys[8] => $this->getSurname(),
			$keys[9] => $this->getFullName(),
			$keys[10] => $this->getAddress(),
			$keys[11] => $this->getAddressMore(),
			$keys[12] => $this->getRegion(),
			$keys[13] => $this->getStreet(),
			$keys[14] => $this->getHouse(),
			$keys[15] => $this->getFlat(),
			$keys[16] => $this->getCode(),
			$keys[17] => $this->getTown(),
			$keys[18] => $this->getPhone(),
			$keys[19] => $this->getCompany(),
			$keys[20] => $this->getVatNumber(),
			$keys[21] => $this->getPesel(),
			$keys[22] => $this->getCrypt(),
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
		$pos = UserDataPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setSfGuardUserId($value);
				break;
			case 4:
				$this->setCountriesId($value);
				break;
			case 5:
				$this->setIsBilling($value);
				break;
			case 6:
				$this->setIsDefault($value);
				break;
			case 7:
				$this->setName($value);
				break;
			case 8:
				$this->setSurname($value);
				break;
			case 9:
				$this->setFullName($value);
				break;
			case 10:
				$this->setAddress($value);
				break;
			case 11:
				$this->setAddressMore($value);
				break;
			case 12:
				$this->setRegion($value);
				break;
			case 13:
				$this->setStreet($value);
				break;
			case 14:
				$this->setHouse($value);
				break;
			case 15:
				$this->setFlat($value);
				break;
			case 16:
				$this->setCode($value);
				break;
			case 17:
				$this->setTown($value);
				break;
			case 18:
				$this->setPhone($value);
				break;
			case 19:
				$this->setCompany($value);
				break;
			case 20:
				$this->setVatNumber($value);
				break;
			case 21:
				$this->setPesel($value);
				break;
			case 22:
				$this->setCrypt($value);
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
		$keys = UserDataPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSfGuardUserId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCountriesId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setIsBilling($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsDefault($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setName($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setSurname($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setFullName($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setAddress($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setAddressMore($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setRegion($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setStreet($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setHouse($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setFlat($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setCode($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setTown($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setPhone($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setCompany($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setVatNumber($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setPesel($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setCrypt($arr[$keys[22]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(UserDataPeer::DATABASE_NAME);

		if ($this->isColumnModified(UserDataPeer::CREATED_AT)) $criteria->add(UserDataPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(UserDataPeer::UPDATED_AT)) $criteria->add(UserDataPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(UserDataPeer::ID)) $criteria->add(UserDataPeer::ID, $this->id);
		if ($this->isColumnModified(UserDataPeer::SF_GUARD_USER_ID)) $criteria->add(UserDataPeer::SF_GUARD_USER_ID, $this->sf_guard_user_id);
		if ($this->isColumnModified(UserDataPeer::COUNTRIES_ID)) $criteria->add(UserDataPeer::COUNTRIES_ID, $this->countries_id);
		if ($this->isColumnModified(UserDataPeer::IS_BILLING)) $criteria->add(UserDataPeer::IS_BILLING, $this->is_billing);
		if ($this->isColumnModified(UserDataPeer::IS_DEFAULT)) $criteria->add(UserDataPeer::IS_DEFAULT, $this->is_default);
		if ($this->isColumnModified(UserDataPeer::NAME)) $criteria->add(UserDataPeer::NAME, $this->name);
		if ($this->isColumnModified(UserDataPeer::SURNAME)) $criteria->add(UserDataPeer::SURNAME, $this->surname);
		if ($this->isColumnModified(UserDataPeer::FULL_NAME)) $criteria->add(UserDataPeer::FULL_NAME, $this->full_name);
		if ($this->isColumnModified(UserDataPeer::ADDRESS)) $criteria->add(UserDataPeer::ADDRESS, $this->address);
		if ($this->isColumnModified(UserDataPeer::ADDRESS_MORE)) $criteria->add(UserDataPeer::ADDRESS_MORE, $this->address_more);
		if ($this->isColumnModified(UserDataPeer::REGION)) $criteria->add(UserDataPeer::REGION, $this->region);
		if ($this->isColumnModified(UserDataPeer::STREET)) $criteria->add(UserDataPeer::STREET, $this->street);
		if ($this->isColumnModified(UserDataPeer::HOUSE)) $criteria->add(UserDataPeer::HOUSE, $this->house);
		if ($this->isColumnModified(UserDataPeer::FLAT)) $criteria->add(UserDataPeer::FLAT, $this->flat);
		if ($this->isColumnModified(UserDataPeer::CODE)) $criteria->add(UserDataPeer::CODE, $this->code);
		if ($this->isColumnModified(UserDataPeer::TOWN)) $criteria->add(UserDataPeer::TOWN, $this->town);
		if ($this->isColumnModified(UserDataPeer::PHONE)) $criteria->add(UserDataPeer::PHONE, $this->phone);
		if ($this->isColumnModified(UserDataPeer::COMPANY)) $criteria->add(UserDataPeer::COMPANY, $this->company);
		if ($this->isColumnModified(UserDataPeer::VAT_NUMBER)) $criteria->add(UserDataPeer::VAT_NUMBER, $this->vat_number);
		if ($this->isColumnModified(UserDataPeer::PESEL)) $criteria->add(UserDataPeer::PESEL, $this->pesel);
		if ($this->isColumnModified(UserDataPeer::CRYPT)) $criteria->add(UserDataPeer::CRYPT, $this->crypt);

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
		$criteria = new Criteria(UserDataPeer::DATABASE_NAME);

		$criteria->add(UserDataPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of UserData (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setSfGuardUserId($this->sf_guard_user_id);

		$copyObj->setCountriesId($this->countries_id);

		$copyObj->setIsBilling($this->is_billing);

		$copyObj->setIsDefault($this->is_default);

		$copyObj->setName($this->name);

		$copyObj->setSurname($this->surname);

		$copyObj->setFullName($this->full_name);

		$copyObj->setAddress($this->address);

		$copyObj->setAddressMore($this->address_more);

		$copyObj->setRegion($this->region);

		$copyObj->setStreet($this->street);

		$copyObj->setHouse($this->house);

		$copyObj->setFlat($this->flat);

		$copyObj->setCode($this->code);

		$copyObj->setTown($this->town);

		$copyObj->setPhone($this->phone);

		$copyObj->setCompany($this->company);

		$copyObj->setVatNumber($this->vat_number);

		$copyObj->setPesel($this->pesel);

		$copyObj->setCrypt($this->crypt);


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
	 * @return     UserData Clone of current object.
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
	 * @return     UserDataPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new UserDataPeer();
		}
		return self::$peer;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'UserData.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseUserData:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseUserData::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseUserData
