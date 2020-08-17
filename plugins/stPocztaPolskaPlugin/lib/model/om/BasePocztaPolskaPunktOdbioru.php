<?php

/**
 * Base class that represents a row from the 'st_poczta_polska_punkt_odbioru' table.
 *
 * 
 *
 * @package    plugins.stPocztaPolskaPlugin.lib.model.om
 */
abstract class BasePocztaPolskaPunktOdbioru extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PocztaPolskaPunktOdbioruPeer
	 */
	protected static $peer;


	/**
	 * The value for the order_id field.
	 * @var        int
	 */
	protected $order_id;


	/**
	 * The value for the pni field.
	 * @var        string
	 */
	protected $pni;


	/**
	 * The value for the type field.
	 * @var        string
	 */
	protected $type;


	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;


	/**
	 * The value for the phone field.
	 * @var        string
	 */
	protected $phone;


	/**
	 * The value for the street field.
	 * @var        string
	 */
	protected $street;


	/**
	 * The value for the city field.
	 * @var        string
	 */
	protected $city;


	/**
	 * The value for the zip_code field.
	 * @var        string
	 */
	protected $zip_code;


	/**
	 * The value for the province field.
	 * @var        string
	 */
	protected $province;


	/**
	 * The value for the ekspres24 field.
	 * @var        boolean
	 */
	protected $ekspres24;


	/**
	 * The value for the kurier48 field.
	 * @var        boolean
	 */
	protected $kurier48;


	/**
	 * The value for the paczka_ekstra24 field.
	 * @var        boolean
	 */
	protected $paczka_ekstra24;

	/**
	 * @var        Order
	 */
	protected $aOrder;

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
     * Get the [order_id] column value.
     * 
     * @return     int
     */
    public function getOrderId()
    {

            return $this->order_id;
    }

    /**
     * Get the [pni] column value.
     * 
     * @return     string
     */
    public function getPni()
    {

            return $this->pni;
    }

    /**
     * Get the [type] column value.
     * 
     * @return     string
     */
    public function getType()
    {

            return $this->type;
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
     * Get the [description] column value.
     * 
     * @return     string
     */
    public function getDescription()
    {

            return $this->description;
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
     * Get the [street] column value.
     * 
     * @return     string
     */
    public function getStreet()
    {

            return $this->street;
    }

    /**
     * Get the [city] column value.
     * 
     * @return     string
     */
    public function getCity()
    {

            return $this->city;
    }

    /**
     * Get the [zip_code] column value.
     * 
     * @return     string
     */
    public function getZipCode()
    {

            return $this->zip_code;
    }

    /**
     * Get the [province] column value.
     * 
     * @return     string
     */
    public function getProvince()
    {

            return $this->province;
    }

    /**
     * Get the [ekspres24] column value.
     * 
     * @return     boolean
     */
    public function getEkspres24()
    {

            return $this->ekspres24;
    }

    /**
     * Get the [kurier48] column value.
     * 
     * @return     boolean
     */
    public function getKurier48()
    {

            return $this->kurier48;
    }

    /**
     * Get the [paczka_ekstra24] column value.
     * 
     * @return     boolean
     */
    public function getPaczkaEkstra24()
    {

            return $this->paczka_ekstra24;
    }

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
          $this->modifiedColumns[] = PocztaPolskaPunktOdbioruPeer::ORDER_ID;
        }

		if ($this->aOrder !== null && $this->aOrder->getId() !== $v) {
			$this->aOrder = null;
		}

	} // setOrderId()

	/**
	 * Set the value of [pni] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPni($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->pni !== $v) {
          $this->pni = $v;
          $this->modifiedColumns[] = PocztaPolskaPunktOdbioruPeer::PNI;
        }

	} // setPni()

	/**
	 * Set the value of [type] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setType($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->type !== $v) {
          $this->type = $v;
          $this->modifiedColumns[] = PocztaPolskaPunktOdbioruPeer::TYPE;
        }

	} // setType()

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
          $this->modifiedColumns[] = PocztaPolskaPunktOdbioruPeer::NAME;
        }

	} // setName()

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
          $this->modifiedColumns[] = PocztaPolskaPunktOdbioruPeer::DESCRIPTION;
        }

	} // setDescription()

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
          $this->modifiedColumns[] = PocztaPolskaPunktOdbioruPeer::PHONE;
        }

	} // setPhone()

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
          $this->modifiedColumns[] = PocztaPolskaPunktOdbioruPeer::STREET;
        }

	} // setStreet()

	/**
	 * Set the value of [city] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCity($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->city !== $v) {
          $this->city = $v;
          $this->modifiedColumns[] = PocztaPolskaPunktOdbioruPeer::CITY;
        }

	} // setCity()

	/**
	 * Set the value of [zip_code] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setZipCode($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->zip_code !== $v) {
          $this->zip_code = $v;
          $this->modifiedColumns[] = PocztaPolskaPunktOdbioruPeer::ZIP_CODE;
        }

	} // setZipCode()

	/**
	 * Set the value of [province] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setProvince($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->province !== $v) {
          $this->province = $v;
          $this->modifiedColumns[] = PocztaPolskaPunktOdbioruPeer::PROVINCE;
        }

	} // setProvince()

	/**
	 * Set the value of [ekspres24] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setEkspres24($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->ekspres24 !== $v) {
          $this->ekspres24 = $v;
          $this->modifiedColumns[] = PocztaPolskaPunktOdbioruPeer::EKSPRES24;
        }

	} // setEkspres24()

	/**
	 * Set the value of [kurier48] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setKurier48($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->kurier48 !== $v) {
          $this->kurier48 = $v;
          $this->modifiedColumns[] = PocztaPolskaPunktOdbioruPeer::KURIER48;
        }

	} // setKurier48()

	/**
	 * Set the value of [paczka_ekstra24] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setPaczkaEkstra24($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->paczka_ekstra24 !== $v) {
          $this->paczka_ekstra24 = $v;
          $this->modifiedColumns[] = PocztaPolskaPunktOdbioruPeer::PACZKA_EKSTRA24;
        }

	} // setPaczkaEkstra24()

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
      if ($this->getDispatcher()->getListeners('PocztaPolskaPunktOdbioru.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'PocztaPolskaPunktOdbioru.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->order_id = $rs->getInt($startcol + 0);

      $this->pni = $rs->getString($startcol + 1);

      $this->type = $rs->getString($startcol + 2);

      $this->name = $rs->getString($startcol + 3);

      $this->description = $rs->getString($startcol + 4);

      $this->phone = $rs->getString($startcol + 5);

      $this->street = $rs->getString($startcol + 6);

      $this->city = $rs->getString($startcol + 7);

      $this->zip_code = $rs->getString($startcol + 8);

      $this->province = $rs->getString($startcol + 9);

      $this->ekspres24 = $rs->getBoolean($startcol + 10);

      $this->kurier48 = $rs->getBoolean($startcol + 11);

      $this->paczka_ekstra24 = $rs->getBoolean($startcol + 12);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('PocztaPolskaPunktOdbioru.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'PocztaPolskaPunktOdbioru.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 13)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 13; // 13 = PocztaPolskaPunktOdbioruPeer::NUM_COLUMNS - PocztaPolskaPunktOdbioruPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating PocztaPolskaPunktOdbioru object", $e);
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

    if ($this->getDispatcher()->getListeners('PocztaPolskaPunktOdbioru.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'PocztaPolskaPunktOdbioru.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePocztaPolskaPunktOdbioru:delete:pre'))
    {
      foreach (sfMixer::getCallables('BasePocztaPolskaPunktOdbioru:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(PocztaPolskaPunktOdbioruPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      PocztaPolskaPunktOdbioruPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('PocztaPolskaPunktOdbioru.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'PocztaPolskaPunktOdbioru.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePocztaPolskaPunktOdbioru:delete:post'))
    {
      foreach (sfMixer::getCallables('BasePocztaPolskaPunktOdbioru:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('PocztaPolskaPunktOdbioru.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'PocztaPolskaPunktOdbioru.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BasePocztaPolskaPunktOdbioru:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(PocztaPolskaPunktOdbioruPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('PocztaPolskaPunktOdbioru.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'PocztaPolskaPunktOdbioru.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BasePocztaPolskaPunktOdbioru:save:post') as $callable)
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


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PocztaPolskaPunktOdbioruPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += PocztaPolskaPunktOdbioruPeer::doUpdate($this, $con);
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

			if ($this->aOrder !== null) {
				if (!$this->aOrder->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOrder->getValidationFailures());
				}
			}


			if (($retval = PocztaPolskaPunktOdbioruPeer::doValidate($this, $columns)) !== true) {
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
		$pos = PocztaPolskaPunktOdbioruPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getOrderId();
				break;
			case 1:
				return $this->getPni();
				break;
			case 2:
				return $this->getType();
				break;
			case 3:
				return $this->getName();
				break;
			case 4:
				return $this->getDescription();
				break;
			case 5:
				return $this->getPhone();
				break;
			case 6:
				return $this->getStreet();
				break;
			case 7:
				return $this->getCity();
				break;
			case 8:
				return $this->getZipCode();
				break;
			case 9:
				return $this->getProvince();
				break;
			case 10:
				return $this->getEkspres24();
				break;
			case 11:
				return $this->getKurier48();
				break;
			case 12:
				return $this->getPaczkaEkstra24();
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
		$keys = PocztaPolskaPunktOdbioruPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getOrderId(),
			$keys[1] => $this->getPni(),
			$keys[2] => $this->getType(),
			$keys[3] => $this->getName(),
			$keys[4] => $this->getDescription(),
			$keys[5] => $this->getPhone(),
			$keys[6] => $this->getStreet(),
			$keys[7] => $this->getCity(),
			$keys[8] => $this->getZipCode(),
			$keys[9] => $this->getProvince(),
			$keys[10] => $this->getEkspres24(),
			$keys[11] => $this->getKurier48(),
			$keys[12] => $this->getPaczkaEkstra24(),
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
		$pos = PocztaPolskaPunktOdbioruPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setOrderId($value);
				break;
			case 1:
				$this->setPni($value);
				break;
			case 2:
				$this->setType($value);
				break;
			case 3:
				$this->setName($value);
				break;
			case 4:
				$this->setDescription($value);
				break;
			case 5:
				$this->setPhone($value);
				break;
			case 6:
				$this->setStreet($value);
				break;
			case 7:
				$this->setCity($value);
				break;
			case 8:
				$this->setZipCode($value);
				break;
			case 9:
				$this->setProvince($value);
				break;
			case 10:
				$this->setEkspres24($value);
				break;
			case 11:
				$this->setKurier48($value);
				break;
			case 12:
				$this->setPaczkaEkstra24($value);
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
		$keys = PocztaPolskaPunktOdbioruPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setOrderId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPni($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setType($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDescription($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPhone($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setStreet($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCity($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setZipCode($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setProvince($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setEkspres24($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setKurier48($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setPaczkaEkstra24($arr[$keys[12]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PocztaPolskaPunktOdbioruPeer::DATABASE_NAME);

		if ($this->isColumnModified(PocztaPolskaPunktOdbioruPeer::ORDER_ID)) $criteria->add(PocztaPolskaPunktOdbioruPeer::ORDER_ID, $this->order_id);
		if ($this->isColumnModified(PocztaPolskaPunktOdbioruPeer::PNI)) $criteria->add(PocztaPolskaPunktOdbioruPeer::PNI, $this->pni);
		if ($this->isColumnModified(PocztaPolskaPunktOdbioruPeer::TYPE)) $criteria->add(PocztaPolskaPunktOdbioruPeer::TYPE, $this->type);
		if ($this->isColumnModified(PocztaPolskaPunktOdbioruPeer::NAME)) $criteria->add(PocztaPolskaPunktOdbioruPeer::NAME, $this->name);
		if ($this->isColumnModified(PocztaPolskaPunktOdbioruPeer::DESCRIPTION)) $criteria->add(PocztaPolskaPunktOdbioruPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(PocztaPolskaPunktOdbioruPeer::PHONE)) $criteria->add(PocztaPolskaPunktOdbioruPeer::PHONE, $this->phone);
		if ($this->isColumnModified(PocztaPolskaPunktOdbioruPeer::STREET)) $criteria->add(PocztaPolskaPunktOdbioruPeer::STREET, $this->street);
		if ($this->isColumnModified(PocztaPolskaPunktOdbioruPeer::CITY)) $criteria->add(PocztaPolskaPunktOdbioruPeer::CITY, $this->city);
		if ($this->isColumnModified(PocztaPolskaPunktOdbioruPeer::ZIP_CODE)) $criteria->add(PocztaPolskaPunktOdbioruPeer::ZIP_CODE, $this->zip_code);
		if ($this->isColumnModified(PocztaPolskaPunktOdbioruPeer::PROVINCE)) $criteria->add(PocztaPolskaPunktOdbioruPeer::PROVINCE, $this->province);
		if ($this->isColumnModified(PocztaPolskaPunktOdbioruPeer::EKSPRES24)) $criteria->add(PocztaPolskaPunktOdbioruPeer::EKSPRES24, $this->ekspres24);
		if ($this->isColumnModified(PocztaPolskaPunktOdbioruPeer::KURIER48)) $criteria->add(PocztaPolskaPunktOdbioruPeer::KURIER48, $this->kurier48);
		if ($this->isColumnModified(PocztaPolskaPunktOdbioruPeer::PACZKA_EKSTRA24)) $criteria->add(PocztaPolskaPunktOdbioruPeer::PACZKA_EKSTRA24, $this->paczka_ekstra24);

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
		$criteria = new Criteria(PocztaPolskaPunktOdbioruPeer::DATABASE_NAME);

		$criteria->add(PocztaPolskaPunktOdbioruPeer::ORDER_ID, $this->order_id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getOrderId();
	}

	/**
	 * Generic method to set the primary key (order_id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setOrderId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of PocztaPolskaPunktOdbioru (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setPni($this->pni);

		$copyObj->setType($this->type);

		$copyObj->setName($this->name);

		$copyObj->setDescription($this->description);

		$copyObj->setPhone($this->phone);

		$copyObj->setStreet($this->street);

		$copyObj->setCity($this->city);

		$copyObj->setZipCode($this->zip_code);

		$copyObj->setProvince($this->province);

		$copyObj->setEkspres24($this->ekspres24);

		$copyObj->setKurier48($this->kurier48);

		$copyObj->setPaczkaEkstra24($this->paczka_ekstra24);


		$copyObj->setNew(true);

		$copyObj->setOrderId(NULL); // this is a pkey column, so set to default value

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
	 * @return     PocztaPolskaPunktOdbioru Clone of current object.
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
	 * @return     PocztaPolskaPunktOdbioruPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PocztaPolskaPunktOdbioruPeer();
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'PocztaPolskaPunktOdbioru.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BasePocztaPolskaPunktOdbioru:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BasePocztaPolskaPunktOdbioru::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BasePocztaPolskaPunktOdbioru
