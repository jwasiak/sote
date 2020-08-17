<?php

/**
 * Base class that represents a row from the 'st_invoice_user_customer' table.
 *
 * 
 *
 * @package    plugins.stInvoicePlugin.lib.model.om
 */
abstract class BaseInvoiceUserCustomer extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        InvoiceUserCustomerPeer
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
	 * The value for the country field.
	 * @var        string
	 */
	protected $country;


	/**
	 * The value for the full_name field.
	 * @var        string
	 */
	protected $full_name;


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
     * Get the [country] column value.
     * 
     * @return     string
     */
    public function getCountry()
    {

            return $this->country;
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
			$this->modifiedColumns[] = InvoiceUserCustomerPeer::CREATED_AT;
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
			$this->modifiedColumns[] = InvoiceUserCustomerPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [country] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCountry($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->country !== $v) {
          $this->country = $v;
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::COUNTRY;
        }

	} // setCountry()

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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::FULL_NAME;
        }

	} // setFullName()

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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::NAME;
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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::SURNAME;
        }

	} // setSurname()

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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::ADDRESS;
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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::ADDRESS_MORE;
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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::REGION;
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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::STREET;
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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::HOUSE;
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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::FLAT;
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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::CODE;
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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::TOWN;
        }

	} // setTown()

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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::COMPANY;
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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::VAT_NUMBER;
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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::PESEL;
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
          $this->modifiedColumns[] = InvoiceUserCustomerPeer::CRYPT;
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
      if ($this->getDispatcher()->getListeners('InvoiceUserCustomer.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceUserCustomer.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->country = $rs->getString($startcol + 3);

      $this->full_name = $rs->getString($startcol + 4);

      $this->name = $rs->getString($startcol + 5);

      $this->surname = $rs->getString($startcol + 6);

      $this->address = $rs->getString($startcol + 7);

      $this->address_more = $rs->getString($startcol + 8);

      $this->region = $rs->getString($startcol + 9);

      $this->street = $rs->getString($startcol + 10);

      $this->house = $rs->getString($startcol + 11);

      $this->flat = $rs->getString($startcol + 12);

      $this->code = $rs->getString($startcol + 13);

      $this->town = $rs->getString($startcol + 14);

      $this->company = $rs->getString($startcol + 15);

      $this->vat_number = $rs->getString($startcol + 16);

      $this->pesel = $rs->getString($startcol + 17);

      $this->crypt = $rs->getBoolean($startcol + 18);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('InvoiceUserCustomer.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceUserCustomer.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 19)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 19; // 19 = InvoiceUserCustomerPeer::NUM_COLUMNS - InvoiceUserCustomerPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating InvoiceUserCustomer object", $e);
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

    if ($this->getDispatcher()->getListeners('InvoiceUserCustomer.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceUserCustomer.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseInvoiceUserCustomer:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseInvoiceUserCustomer:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(InvoiceUserCustomerPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      InvoiceUserCustomerPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('InvoiceUserCustomer.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceUserCustomer.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseInvoiceUserCustomer:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseInvoiceUserCustomer:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('InvoiceUserCustomer.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceUserCustomer.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseInvoiceUserCustomer:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(InvoiceUserCustomerPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(InvoiceUserCustomerPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(InvoiceUserCustomerPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('InvoiceUserCustomer.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceUserCustomer.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseInvoiceUserCustomer:save:post') as $callable)
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


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = InvoiceUserCustomerPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += InvoiceUserCustomerPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collInvoices !== null) {
				foreach($this->collInvoices as $referrerFK) {
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


			if (($retval = InvoiceUserCustomerPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collInvoices !== null) {
					foreach($this->collInvoices as $referrerFK) {
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
		$pos = InvoiceUserCustomerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCountry();
				break;
			case 4:
				return $this->getFullName();
				break;
			case 5:
				return $this->getName();
				break;
			case 6:
				return $this->getSurname();
				break;
			case 7:
				return $this->getAddress();
				break;
			case 8:
				return $this->getAddressMore();
				break;
			case 9:
				return $this->getRegion();
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
				return $this->getCompany();
				break;
			case 16:
				return $this->getVatNumber();
				break;
			case 17:
				return $this->getPesel();
				break;
			case 18:
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
		$keys = InvoiceUserCustomerPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getCountry(),
			$keys[4] => $this->getFullName(),
			$keys[5] => $this->getName(),
			$keys[6] => $this->getSurname(),
			$keys[7] => $this->getAddress(),
			$keys[8] => $this->getAddressMore(),
			$keys[9] => $this->getRegion(),
			$keys[10] => $this->getStreet(),
			$keys[11] => $this->getHouse(),
			$keys[12] => $this->getFlat(),
			$keys[13] => $this->getCode(),
			$keys[14] => $this->getTown(),
			$keys[15] => $this->getCompany(),
			$keys[16] => $this->getVatNumber(),
			$keys[17] => $this->getPesel(),
			$keys[18] => $this->getCrypt(),
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
		$pos = InvoiceUserCustomerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setCountry($value);
				break;
			case 4:
				$this->setFullName($value);
				break;
			case 5:
				$this->setName($value);
				break;
			case 6:
				$this->setSurname($value);
				break;
			case 7:
				$this->setAddress($value);
				break;
			case 8:
				$this->setAddressMore($value);
				break;
			case 9:
				$this->setRegion($value);
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
				$this->setCompany($value);
				break;
			case 16:
				$this->setVatNumber($value);
				break;
			case 17:
				$this->setPesel($value);
				break;
			case 18:
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
		$keys = InvoiceUserCustomerPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCountry($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setFullName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setName($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setSurname($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setAddress($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setAddressMore($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setRegion($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setStreet($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setHouse($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setFlat($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setCode($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setTown($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setCompany($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setVatNumber($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setPesel($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setCrypt($arr[$keys[18]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(InvoiceUserCustomerPeer::DATABASE_NAME);

		if ($this->isColumnModified(InvoiceUserCustomerPeer::CREATED_AT)) $criteria->add(InvoiceUserCustomerPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::UPDATED_AT)) $criteria->add(InvoiceUserCustomerPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::ID)) $criteria->add(InvoiceUserCustomerPeer::ID, $this->id);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::COUNTRY)) $criteria->add(InvoiceUserCustomerPeer::COUNTRY, $this->country);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::FULL_NAME)) $criteria->add(InvoiceUserCustomerPeer::FULL_NAME, $this->full_name);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::NAME)) $criteria->add(InvoiceUserCustomerPeer::NAME, $this->name);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::SURNAME)) $criteria->add(InvoiceUserCustomerPeer::SURNAME, $this->surname);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::ADDRESS)) $criteria->add(InvoiceUserCustomerPeer::ADDRESS, $this->address);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::ADDRESS_MORE)) $criteria->add(InvoiceUserCustomerPeer::ADDRESS_MORE, $this->address_more);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::REGION)) $criteria->add(InvoiceUserCustomerPeer::REGION, $this->region);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::STREET)) $criteria->add(InvoiceUserCustomerPeer::STREET, $this->street);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::HOUSE)) $criteria->add(InvoiceUserCustomerPeer::HOUSE, $this->house);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::FLAT)) $criteria->add(InvoiceUserCustomerPeer::FLAT, $this->flat);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::CODE)) $criteria->add(InvoiceUserCustomerPeer::CODE, $this->code);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::TOWN)) $criteria->add(InvoiceUserCustomerPeer::TOWN, $this->town);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::COMPANY)) $criteria->add(InvoiceUserCustomerPeer::COMPANY, $this->company);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::VAT_NUMBER)) $criteria->add(InvoiceUserCustomerPeer::VAT_NUMBER, $this->vat_number);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::PESEL)) $criteria->add(InvoiceUserCustomerPeer::PESEL, $this->pesel);
		if ($this->isColumnModified(InvoiceUserCustomerPeer::CRYPT)) $criteria->add(InvoiceUserCustomerPeer::CRYPT, $this->crypt);

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
		$criteria = new Criteria(InvoiceUserCustomerPeer::DATABASE_NAME);

		$criteria->add(InvoiceUserCustomerPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of InvoiceUserCustomer (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setCountry($this->country);

		$copyObj->setFullName($this->full_name);

		$copyObj->setName($this->name);

		$copyObj->setSurname($this->surname);

		$copyObj->setAddress($this->address);

		$copyObj->setAddressMore($this->address_more);

		$copyObj->setRegion($this->region);

		$copyObj->setStreet($this->street);

		$copyObj->setHouse($this->house);

		$copyObj->setFlat($this->flat);

		$copyObj->setCode($this->code);

		$copyObj->setTown($this->town);

		$copyObj->setCompany($this->company);

		$copyObj->setVatNumber($this->vat_number);

		$copyObj->setPesel($this->pesel);

		$copyObj->setCrypt($this->crypt);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getInvoices() as $relObj) {
				$copyObj->addInvoice($relObj->copy($deepCopy));
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
	 * @return     InvoiceUserCustomer Clone of current object.
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
	 * @return     InvoiceUserCustomerPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new InvoiceUserCustomerPeer();
		}
		return self::$peer;
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
	 * Otherwise if this InvoiceUserCustomer has previously
	 * been saved, it will retrieve related Invoices from storage.
	 * If this InvoiceUserCustomer is new, it will return
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

				$criteria->add(InvoicePeer::INVOICE_USER_CUSTOMER_ID, $this->getId());

				InvoicePeer::addSelectColumns($criteria);
				$this->collInvoices = InvoicePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(InvoicePeer::INVOICE_USER_CUSTOMER_ID, $this->getId());

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

		$criteria->add(InvoicePeer::INVOICE_USER_CUSTOMER_ID, $this->getId());

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
		$l->setInvoiceUserCustomer($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this InvoiceUserCustomer is new, it will return
	 * an empty collection; or if this InvoiceUserCustomer has previously
	 * been saved, it will retrieve related Invoices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in InvoiceUserCustomer.
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

				$criteria->add(InvoicePeer::INVOICE_USER_CUSTOMER_ID, $this->getId());

				$this->collInvoices = InvoicePeer::doSelectJoinInvoiceUserSeller($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(InvoicePeer::INVOICE_USER_CUSTOMER_ID, $this->getId());

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
	 * Otherwise if this InvoiceUserCustomer is new, it will return
	 * an empty collection; or if this InvoiceUserCustomer has previously
	 * been saved, it will retrieve related Invoices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in InvoiceUserCustomer.
	 */
	public function getInvoicesJoinOrder($criteria = null, $con = null)
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

				$criteria->add(InvoicePeer::INVOICE_USER_CUSTOMER_ID, $this->getId());

				$this->collInvoices = InvoicePeer::doSelectJoinOrder($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(InvoicePeer::INVOICE_USER_CUSTOMER_ID, $this->getId());

			if (!isset($this->lastInvoiceCriteria) || !$this->lastInvoiceCriteria->equals($criteria)) {
				$this->collInvoices = InvoicePeer::doSelectJoinOrder($criteria, $con);
			}
		}
		$this->lastInvoiceCriteria = $criteria;

		return $this->collInvoices;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this InvoiceUserCustomer is new, it will return
	 * an empty collection; or if this InvoiceUserCustomer has previously
	 * been saved, it will retrieve related Invoices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in InvoiceUserCustomer.
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

				$criteria->add(InvoicePeer::INVOICE_USER_CUSTOMER_ID, $this->getId());

				$this->collInvoices = InvoicePeer::doSelectJoinInvoiceCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(InvoicePeer::INVOICE_USER_CUSTOMER_ID, $this->getId());

			if (!isset($this->lastInvoiceCriteria) || !$this->lastInvoiceCriteria->equals($criteria)) {
				$this->collInvoices = InvoicePeer::doSelectJoinInvoiceCurrency($criteria, $con);
			}
		}
		$this->lastInvoiceCriteria = $criteria;

		return $this->collInvoices;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'InvoiceUserCustomer.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseInvoiceUserCustomer:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseInvoiceUserCustomer::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseInvoiceUserCustomer
