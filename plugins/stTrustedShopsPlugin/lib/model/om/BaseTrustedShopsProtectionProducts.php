<?php

/**
 * Base class that represents a row from the 'st_trusted_shops_protection_products' table.
 *
 * 
 *
 * @package    plugins.stTrustedShopsPlugin.lib.model.om
 */
abstract class BaseTrustedShopsProtectionProducts extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        TrustedShopsProtectionProductsPeer
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
	 * The value for the trusted_shops_id field.
	 * @var        int
	 */
	protected $trusted_shops_id;


	/**
	 * The value for the currency field.
	 * @var        string
	 */
	protected $currency;


	/**
	 * The value for the gross field.
	 * @var        double
	 */
	protected $gross;


	/**
	 * The value for the netto field.
	 * @var        double
	 */
	protected $netto;


	/**
	 * The value for the amount field.
	 * @var        double
	 */
	protected $amount;


	/**
	 * The value for the duration field.
	 * @var        int
	 */
	protected $duration;


	/**
	 * The value for the product_id field.
	 * @var        string
	 */
	protected $product_id;

	/**
	 * @var        TrustedShops
	 */
	protected $aTrustedShops;

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
     * Get the [trusted_shops_id] column value.
     * 
     * @return     int
     */
    public function getTrustedShopsId()
    {

            return $this->trusted_shops_id;
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
     * Get the [gross] column value.
     * 
     * @return     double
     */
    public function getGross()
    {

            return null !== $this->gross ? (string)$this->gross : null;
    }

    /**
     * Get the [netto] column value.
     * 
     * @return     double
     */
    public function getNetto()
    {

            return null !== $this->netto ? (string)$this->netto : null;
    }

    /**
     * Get the [amount] column value.
     * 
     * @return     double
     */
    public function getAmount()
    {

            return null !== $this->amount ? (string)$this->amount : null;
    }

    /**
     * Get the [duration] column value.
     * 
     * @return     int
     */
    public function getDuration()
    {

            return $this->duration;
    }

    /**
     * Get the [product_id] column value.
     * 
     * @return     string
     */
    public function getProductId()
    {

            return $this->product_id;
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
			$this->modifiedColumns[] = TrustedShopsProtectionProductsPeer::CREATED_AT;
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
			$this->modifiedColumns[] = TrustedShopsProtectionProductsPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = TrustedShopsProtectionProductsPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [trusted_shops_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setTrustedShopsId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->trusted_shops_id !== $v) {
          $this->trusted_shops_id = $v;
          $this->modifiedColumns[] = TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID;
        }

		if ($this->aTrustedShops !== null && $this->aTrustedShops->getId() !== $v) {
			$this->aTrustedShops = null;
		}

	} // setTrustedShopsId()

	/**
	 * Set the value of [currency] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCurrency($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->currency !== $v) {
          $this->currency = $v;
          $this->modifiedColumns[] = TrustedShopsProtectionProductsPeer::CURRENCY;
        }

	} // setCurrency()

	/**
	 * Set the value of [gross] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setGross($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->gross !== $v) {
          $this->gross = $v;
          $this->modifiedColumns[] = TrustedShopsProtectionProductsPeer::GROSS;
        }

	} // setGross()

	/**
	 * Set the value of [netto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setNetto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->netto !== $v) {
          $this->netto = $v;
          $this->modifiedColumns[] = TrustedShopsProtectionProductsPeer::NETTO;
        }

	} // setNetto()

	/**
	 * Set the value of [amount] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setAmount($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->amount !== $v) {
          $this->amount = $v;
          $this->modifiedColumns[] = TrustedShopsProtectionProductsPeer::AMOUNT;
        }

	} // setAmount()

	/**
	 * Set the value of [duration] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setDuration($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->duration !== $v) {
          $this->duration = $v;
          $this->modifiedColumns[] = TrustedShopsProtectionProductsPeer::DURATION;
        }

	} // setDuration()

	/**
	 * Set the value of [product_id] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setProductId($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->product_id !== $v) {
          $this->product_id = $v;
          $this->modifiedColumns[] = TrustedShopsProtectionProductsPeer::PRODUCT_ID;
        }

	} // setProductId()

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
      if ($this->getDispatcher()->getListeners('TrustedShopsProtectionProducts.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShopsProtectionProducts.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->trusted_shops_id = $rs->getInt($startcol + 3);

      $this->currency = $rs->getString($startcol + 4);

      $this->gross = $rs->getString($startcol + 5);
      if (null !== $this->gross && $this->gross == intval($this->gross))
      {
        $this->gross = (string)intval($this->gross);
      }

      $this->netto = $rs->getString($startcol + 6);
      if (null !== $this->netto && $this->netto == intval($this->netto))
      {
        $this->netto = (string)intval($this->netto);
      }

      $this->amount = $rs->getString($startcol + 7);
      if (null !== $this->amount && $this->amount == intval($this->amount))
      {
        $this->amount = (string)intval($this->amount);
      }

      $this->duration = $rs->getInt($startcol + 8);

      $this->product_id = $rs->getString($startcol + 9);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('TrustedShopsProtectionProducts.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShopsProtectionProducts.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 10)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 10; // 10 = TrustedShopsProtectionProductsPeer::NUM_COLUMNS - TrustedShopsProtectionProductsPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating TrustedShopsProtectionProducts object", $e);
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

    if ($this->getDispatcher()->getListeners('TrustedShopsProtectionProducts.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShopsProtectionProducts.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTrustedShopsProtectionProducts:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseTrustedShopsProtectionProducts:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(TrustedShopsProtectionProductsPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      TrustedShopsProtectionProductsPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('TrustedShopsProtectionProducts.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShopsProtectionProducts.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTrustedShopsProtectionProducts:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseTrustedShopsProtectionProducts:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('TrustedShopsProtectionProducts.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShopsProtectionProducts.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseTrustedShopsProtectionProducts:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(TrustedShopsProtectionProductsPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(TrustedShopsProtectionProductsPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(TrustedShopsProtectionProductsPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('TrustedShopsProtectionProducts.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShopsProtectionProducts.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseTrustedShopsProtectionProducts:save:post') as $callable)
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

			if ($this->aTrustedShops !== null) {
				if ($this->aTrustedShops->isModified()) {
					$affectedRows += $this->aTrustedShops->save($con);
				}
				$this->setTrustedShops($this->aTrustedShops);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TrustedShopsProtectionProductsPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += TrustedShopsProtectionProductsPeer::doUpdate($this, $con);
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

			if ($this->aTrustedShops !== null) {
				if (!$this->aTrustedShops->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTrustedShops->getValidationFailures());
				}
			}


			if (($retval = TrustedShopsProtectionProductsPeer::doValidate($this, $columns)) !== true) {
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
		$pos = TrustedShopsProtectionProductsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getTrustedShopsId();
				break;
			case 4:
				return $this->getCurrency();
				break;
			case 5:
				return $this->getGross();
				break;
			case 6:
				return $this->getNetto();
				break;
			case 7:
				return $this->getAmount();
				break;
			case 8:
				return $this->getDuration();
				break;
			case 9:
				return $this->getProductId();
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
		$keys = TrustedShopsProtectionProductsPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getTrustedShopsId(),
			$keys[4] => $this->getCurrency(),
			$keys[5] => $this->getGross(),
			$keys[6] => $this->getNetto(),
			$keys[7] => $this->getAmount(),
			$keys[8] => $this->getDuration(),
			$keys[9] => $this->getProductId(),
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
		$pos = TrustedShopsProtectionProductsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setTrustedShopsId($value);
				break;
			case 4:
				$this->setCurrency($value);
				break;
			case 5:
				$this->setGross($value);
				break;
			case 6:
				$this->setNetto($value);
				break;
			case 7:
				$this->setAmount($value);
				break;
			case 8:
				$this->setDuration($value);
				break;
			case 9:
				$this->setProductId($value);
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
		$keys = TrustedShopsProtectionProductsPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTrustedShopsId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCurrency($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setGross($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setNetto($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setAmount($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setDuration($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setProductId($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(TrustedShopsProtectionProductsPeer::DATABASE_NAME);

		if ($this->isColumnModified(TrustedShopsProtectionProductsPeer::CREATED_AT)) $criteria->add(TrustedShopsProtectionProductsPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(TrustedShopsProtectionProductsPeer::UPDATED_AT)) $criteria->add(TrustedShopsProtectionProductsPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(TrustedShopsProtectionProductsPeer::ID)) $criteria->add(TrustedShopsProtectionProductsPeer::ID, $this->id);
		if ($this->isColumnModified(TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID)) $criteria->add(TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID, $this->trusted_shops_id);
		if ($this->isColumnModified(TrustedShopsProtectionProductsPeer::CURRENCY)) $criteria->add(TrustedShopsProtectionProductsPeer::CURRENCY, $this->currency);
		if ($this->isColumnModified(TrustedShopsProtectionProductsPeer::GROSS)) $criteria->add(TrustedShopsProtectionProductsPeer::GROSS, $this->gross);
		if ($this->isColumnModified(TrustedShopsProtectionProductsPeer::NETTO)) $criteria->add(TrustedShopsProtectionProductsPeer::NETTO, $this->netto);
		if ($this->isColumnModified(TrustedShopsProtectionProductsPeer::AMOUNT)) $criteria->add(TrustedShopsProtectionProductsPeer::AMOUNT, $this->amount);
		if ($this->isColumnModified(TrustedShopsProtectionProductsPeer::DURATION)) $criteria->add(TrustedShopsProtectionProductsPeer::DURATION, $this->duration);
		if ($this->isColumnModified(TrustedShopsProtectionProductsPeer::PRODUCT_ID)) $criteria->add(TrustedShopsProtectionProductsPeer::PRODUCT_ID, $this->product_id);

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
		$criteria = new Criteria(TrustedShopsProtectionProductsPeer::DATABASE_NAME);

		$criteria->add(TrustedShopsProtectionProductsPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of TrustedShopsProtectionProducts (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setTrustedShopsId($this->trusted_shops_id);

		$copyObj->setCurrency($this->currency);

		$copyObj->setGross($this->gross);

		$copyObj->setNetto($this->netto);

		$copyObj->setAmount($this->amount);

		$copyObj->setDuration($this->duration);

		$copyObj->setProductId($this->product_id);


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
	 * @return     TrustedShopsProtectionProducts Clone of current object.
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
	 * @return     TrustedShopsProtectionProductsPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new TrustedShopsProtectionProductsPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a TrustedShops object.
	 *
	 * @param      TrustedShops $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setTrustedShops($v)
	{


		if ($v === null) {
			$this->setTrustedShopsId(NULL);
		} else {
			$this->setTrustedShopsId($v->getId());
		}


		$this->aTrustedShops = $v;
	}


	/**
	 * Get the associated TrustedShops object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     TrustedShops The associated TrustedShops object.
	 * @throws     PropelException
	 */
	public function getTrustedShops($con = null)
	{
		if ($this->aTrustedShops === null && ($this->trusted_shops_id !== null)) {
			// include the related Peer class
			$this->aTrustedShops = TrustedShopsPeer::retrieveByPK($this->trusted_shops_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = TrustedShopsPeer::retrieveByPK($this->trusted_shops_id, $con);
			   $obj->addTrustedShopss($this);
			 */
		}
		return $this->aTrustedShops;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'TrustedShopsProtectionProducts.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseTrustedShopsProtectionProducts:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseTrustedShopsProtectionProducts::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseTrustedShopsProtectionProducts
