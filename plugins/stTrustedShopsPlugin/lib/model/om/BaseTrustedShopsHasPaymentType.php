<?php

/**
 * Base class that represents a row from the 'st_trusted_shops_has_payment_type' table.
 *
 * 
 *
 * @package    plugins.stTrustedShopsPlugin.lib.model.om
 */
abstract class BaseTrustedShopsHasPaymentType extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        TrustedShopsHasPaymentTypePeer
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
	 * The value for the trusted_shops_id field.
	 * @var        int
	 */
	protected $trusted_shops_id;


	/**
	 * The value for the payment_type_id field.
	 * @var        int
	 */
	protected $payment_type_id;


	/**
	 * The value for the method field.
	 * @var        string
	 */
	protected $method;

	/**
	 * @var        TrustedShops
	 */
	protected $aTrustedShops;

	/**
	 * @var        PaymentType
	 */
	protected $aPaymentType;

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
     * Get the [trusted_shops_id] column value.
     * 
     * @return     int
     */
    public function getTrustedShopsId()
    {

            return $this->trusted_shops_id;
    }

    /**
     * Get the [payment_type_id] column value.
     * 
     * @return     int
     */
    public function getPaymentTypeId()
    {

            return $this->payment_type_id;
    }

    /**
     * Get the [method] column value.
     * 
     * @return     string
     */
    public function getMethod()
    {

            return $this->method;
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
			$this->modifiedColumns[] = TrustedShopsHasPaymentTypePeer::CREATED_AT;
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
			$this->modifiedColumns[] = TrustedShopsHasPaymentTypePeer::UPDATED_AT;
		}

	} // setUpdatedAt()

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
          $this->modifiedColumns[] = TrustedShopsHasPaymentTypePeer::TRUSTED_SHOPS_ID;
        }

		if ($this->aTrustedShops !== null && $this->aTrustedShops->getId() !== $v) {
			$this->aTrustedShops = null;
		}

	} // setTrustedShopsId()

	/**
	 * Set the value of [payment_type_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPaymentTypeId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->payment_type_id !== $v) {
          $this->payment_type_id = $v;
          $this->modifiedColumns[] = TrustedShopsHasPaymentTypePeer::PAYMENT_TYPE_ID;
        }

		if ($this->aPaymentType !== null && $this->aPaymentType->getId() !== $v) {
			$this->aPaymentType = null;
		}

	} // setPaymentTypeId()

	/**
	 * Set the value of [method] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setMethod($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->method !== $v) {
          $this->method = $v;
          $this->modifiedColumns[] = TrustedShopsHasPaymentTypePeer::METHOD;
        }

	} // setMethod()

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
      if ($this->getDispatcher()->getListeners('TrustedShopsHasPaymentType.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShopsHasPaymentType.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->trusted_shops_id = $rs->getInt($startcol + 2);

      $this->payment_type_id = $rs->getInt($startcol + 3);

      $this->method = $rs->getString($startcol + 4);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('TrustedShopsHasPaymentType.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShopsHasPaymentType.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 5)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 5; // 5 = TrustedShopsHasPaymentTypePeer::NUM_COLUMNS - TrustedShopsHasPaymentTypePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating TrustedShopsHasPaymentType object", $e);
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

    if ($this->getDispatcher()->getListeners('TrustedShopsHasPaymentType.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShopsHasPaymentType.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTrustedShopsHasPaymentType:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseTrustedShopsHasPaymentType:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(TrustedShopsHasPaymentTypePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      TrustedShopsHasPaymentTypePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('TrustedShopsHasPaymentType.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShopsHasPaymentType.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTrustedShopsHasPaymentType:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseTrustedShopsHasPaymentType:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('TrustedShopsHasPaymentType.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShopsHasPaymentType.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseTrustedShopsHasPaymentType:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(TrustedShopsHasPaymentTypePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(TrustedShopsHasPaymentTypePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(TrustedShopsHasPaymentTypePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('TrustedShopsHasPaymentType.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'TrustedShopsHasPaymentType.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseTrustedShopsHasPaymentType:save:post') as $callable)
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

			if ($this->aPaymentType !== null) {
				if ($this->aPaymentType->isModified() || $this->aPaymentType->getCurrentPaymentTypeI18n()->isModified()) {
					$affectedRows += $this->aPaymentType->save($con);
				}
				$this->setPaymentType($this->aPaymentType);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TrustedShopsHasPaymentTypePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += TrustedShopsHasPaymentTypePeer::doUpdate($this, $con);
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

			if ($this->aPaymentType !== null) {
				if (!$this->aPaymentType->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPaymentType->getValidationFailures());
				}
			}


			if (($retval = TrustedShopsHasPaymentTypePeer::doValidate($this, $columns)) !== true) {
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
		$pos = TrustedShopsHasPaymentTypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getTrustedShopsId();
				break;
			case 3:
				return $this->getPaymentTypeId();
				break;
			case 4:
				return $this->getMethod();
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
		$keys = TrustedShopsHasPaymentTypePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getTrustedShopsId(),
			$keys[3] => $this->getPaymentTypeId(),
			$keys[4] => $this->getMethod(),
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
		$pos = TrustedShopsHasPaymentTypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setTrustedShopsId($value);
				break;
			case 3:
				$this->setPaymentTypeId($value);
				break;
			case 4:
				$this->setMethod($value);
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
		$keys = TrustedShopsHasPaymentTypePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTrustedShopsId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPaymentTypeId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setMethod($arr[$keys[4]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(TrustedShopsHasPaymentTypePeer::DATABASE_NAME);

		if ($this->isColumnModified(TrustedShopsHasPaymentTypePeer::CREATED_AT)) $criteria->add(TrustedShopsHasPaymentTypePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(TrustedShopsHasPaymentTypePeer::UPDATED_AT)) $criteria->add(TrustedShopsHasPaymentTypePeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(TrustedShopsHasPaymentTypePeer::TRUSTED_SHOPS_ID)) $criteria->add(TrustedShopsHasPaymentTypePeer::TRUSTED_SHOPS_ID, $this->trusted_shops_id);
		if ($this->isColumnModified(TrustedShopsHasPaymentTypePeer::PAYMENT_TYPE_ID)) $criteria->add(TrustedShopsHasPaymentTypePeer::PAYMENT_TYPE_ID, $this->payment_type_id);
		if ($this->isColumnModified(TrustedShopsHasPaymentTypePeer::METHOD)) $criteria->add(TrustedShopsHasPaymentTypePeer::METHOD, $this->method);

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
		$criteria = new Criteria(TrustedShopsHasPaymentTypePeer::DATABASE_NAME);

		$criteria->add(TrustedShopsHasPaymentTypePeer::TRUSTED_SHOPS_ID, $this->trusted_shops_id);
		$criteria->add(TrustedShopsHasPaymentTypePeer::PAYMENT_TYPE_ID, $this->payment_type_id);

		return $criteria;
	}

	/**
	 * Returns the composite primary key for this object.
	 * The array elements will be in same order as specified in XML.
	 * @return     array
	 */
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getTrustedShopsId();

		$pks[1] = $this->getPaymentTypeId();

		return $pks;
	}

	/**
	 * Set the [composite] primary key.
	 *
	 * @param      array $keys The elements of the composite key (order must match the order in XML file).
	 * @return     void
	 */
	public function setPrimaryKey($keys)
	{

		$this->setTrustedShopsId($keys[0]);

		$this->setPaymentTypeId($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of TrustedShopsHasPaymentType (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setMethod($this->method);


		$copyObj->setNew(true);

		$copyObj->setTrustedShopsId(NULL); // this is a pkey column, so set to default value

		$copyObj->setPaymentTypeId(NULL); // this is a pkey column, so set to default value

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
	 * @return     TrustedShopsHasPaymentType Clone of current object.
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
	 * @return     TrustedShopsHasPaymentTypePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new TrustedShopsHasPaymentTypePeer();
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

	/**
	 * Declares an association between this object and a PaymentType object.
	 *
	 * @param      PaymentType $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setPaymentType($v)
	{


		if ($v === null) {
			$this->setPaymentTypeId(NULL);
		} else {
			$this->setPaymentTypeId($v->getId());
		}


		$this->aPaymentType = $v;
	}


	/**
	 * Get the associated PaymentType object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     PaymentType The associated PaymentType object.
	 * @throws     PropelException
	 */
	public function getPaymentType($con = null)
	{
		if ($this->aPaymentType === null && ($this->payment_type_id !== null)) {
			// include the related Peer class
			$this->aPaymentType = PaymentTypePeer::retrieveByPK($this->payment_type_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = PaymentTypePeer::retrieveByPK($this->payment_type_id, $con);
			   $obj->addPaymentTypes($this);
			 */
		}
		return $this->aPaymentType;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'TrustedShopsHasPaymentType.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseTrustedShopsHasPaymentType:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseTrustedShopsHasPaymentType::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseTrustedShopsHasPaymentType
