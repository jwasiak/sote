<?php

/**
 * Base class that represents a row from the 'st_trust' table.
 *
 * 
 *
 * @package    plugins.stTrustPlugin.lib.model.om
 */
abstract class BaseTrust extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        TrustPeer
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
	protected $product_id;


	/**
	 * The value for the field_on field.
	 * @var        boolean
	 */
	protected $field_on = false;


	/**
	 * The value for the field_f_on field.
	 * @var        boolean
	 */
	protected $field_f_on = false;


	/**
	 * The value for the field_s_on field.
	 * @var        boolean
	 */
	protected $field_s_on = false;


	/**
	 * The value for the field_t_on field.
	 * @var        boolean
	 */
	protected $field_t_on = false;

	/**
	 * @var        Product
	 */
	protected $aProduct;

	/**
	 * Collection to store aggregation of collTrustI18ns.
	 * @var        array
	 */
	protected $collTrustI18ns;

	/**
	 * The criteria used to select the current contents of collTrustI18ns.
	 * @var        Criteria
	 */
	protected $lastTrustI18nCriteria = null;

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
   * The value for the culture field.
   * @var string
   */
  protected $culture;

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
     * Get the [field_on] column value.
     * 
     * @return     boolean
     */
    public function getFieldOn()
    {

            return $this->field_on;
    }

    /**
     * Get the [field_f_on] column value.
     * 
     * @return     boolean
     */
    public function getFieldFOn()
    {

            return $this->field_f_on;
    }

    /**
     * Get the [field_s_on] column value.
     * 
     * @return     boolean
     */
    public function getFieldSOn()
    {

            return $this->field_s_on;
    }

    /**
     * Get the [field_t_on] column value.
     * 
     * @return     boolean
     */
    public function getFieldTOn()
    {

            return $this->field_t_on;
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
			$this->modifiedColumns[] = TrustPeer::CREATED_AT;
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
			$this->modifiedColumns[] = TrustPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = TrustPeer::ID;
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

        if ($this->product_id !== $v) {
          $this->product_id = $v;
          $this->modifiedColumns[] = TrustPeer::PRODUCT_ID;
        }

		if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
			$this->aProduct = null;
		}

	} // setProductId()

	/**
	 * Set the value of [field_on] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setFieldOn($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->field_on !== $v || $v === false) {
          $this->field_on = $v;
          $this->modifiedColumns[] = TrustPeer::FIELD_ON;
        }

	} // setFieldOn()

	/**
	 * Set the value of [field_f_on] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setFieldFOn($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->field_f_on !== $v || $v === false) {
          $this->field_f_on = $v;
          $this->modifiedColumns[] = TrustPeer::FIELD_F_ON;
        }

	} // setFieldFOn()

	/**
	 * Set the value of [field_s_on] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setFieldSOn($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->field_s_on !== $v || $v === false) {
          $this->field_s_on = $v;
          $this->modifiedColumns[] = TrustPeer::FIELD_S_ON;
        }

	} // setFieldSOn()

	/**
	 * Set the value of [field_t_on] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setFieldTOn($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->field_t_on !== $v || $v === false) {
          $this->field_t_on = $v;
          $this->modifiedColumns[] = TrustPeer::FIELD_T_ON;
        }

	} // setFieldTOn()

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
      if ($this->getDispatcher()->getListeners('Trust.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Trust.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->product_id = $rs->getInt($startcol + 3);

      $this->field_on = $rs->getBoolean($startcol + 4);

      $this->field_f_on = $rs->getBoolean($startcol + 5);

      $this->field_s_on = $rs->getBoolean($startcol + 6);

      $this->field_t_on = $rs->getBoolean($startcol + 7);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Trust.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Trust.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 8)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 8; // 8 = TrustPeer::NUM_COLUMNS - TrustPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Trust object", $e);
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

    if ($this->getDispatcher()->getListeners('Trust.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Trust.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTrust:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseTrust:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(TrustPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      TrustPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Trust.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Trust.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTrust:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseTrust:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Trust.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Trust.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseTrust:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(TrustPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(TrustPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(TrustPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Trust.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Trust.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseTrust:save:post') as $callable)
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


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TrustPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += TrustPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collTrustI18ns !== null) {
				foreach($this->collTrustI18ns as $referrerFK) {
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

			if ($this->aProduct !== null) {
				if (!$this->aProduct->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProduct->getValidationFailures());
				}
			}


			if (($retval = TrustPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collTrustI18ns !== null) {
					foreach($this->collTrustI18ns as $referrerFK) {
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
		$pos = TrustPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getFieldOn();
				break;
			case 5:
				return $this->getFieldFOn();
				break;
			case 6:
				return $this->getFieldSOn();
				break;
			case 7:
				return $this->getFieldTOn();
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
		$keys = TrustPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getProductId(),
			$keys[4] => $this->getFieldOn(),
			$keys[5] => $this->getFieldFOn(),
			$keys[6] => $this->getFieldSOn(),
			$keys[7] => $this->getFieldTOn(),
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
		$pos = TrustPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setFieldOn($value);
				break;
			case 5:
				$this->setFieldFOn($value);
				break;
			case 6:
				$this->setFieldSOn($value);
				break;
			case 7:
				$this->setFieldTOn($value);
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
		$keys = TrustPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setProductId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setFieldOn($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setFieldFOn($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setFieldSOn($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setFieldTOn($arr[$keys[7]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(TrustPeer::DATABASE_NAME);

		if ($this->isColumnModified(TrustPeer::CREATED_AT)) $criteria->add(TrustPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(TrustPeer::UPDATED_AT)) $criteria->add(TrustPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(TrustPeer::ID)) $criteria->add(TrustPeer::ID, $this->id);
		if ($this->isColumnModified(TrustPeer::PRODUCT_ID)) $criteria->add(TrustPeer::PRODUCT_ID, $this->product_id);
		if ($this->isColumnModified(TrustPeer::FIELD_ON)) $criteria->add(TrustPeer::FIELD_ON, $this->field_on);
		if ($this->isColumnModified(TrustPeer::FIELD_F_ON)) $criteria->add(TrustPeer::FIELD_F_ON, $this->field_f_on);
		if ($this->isColumnModified(TrustPeer::FIELD_S_ON)) $criteria->add(TrustPeer::FIELD_S_ON, $this->field_s_on);
		if ($this->isColumnModified(TrustPeer::FIELD_T_ON)) $criteria->add(TrustPeer::FIELD_T_ON, $this->field_t_on);

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
		$criteria = new Criteria(TrustPeer::DATABASE_NAME);

		$criteria->add(TrustPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Trust (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setProductId($this->product_id);

		$copyObj->setFieldOn($this->field_on);

		$copyObj->setFieldFOn($this->field_f_on);

		$copyObj->setFieldSOn($this->field_s_on);

		$copyObj->setFieldTOn($this->field_t_on);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getTrustI18ns() as $relObj) {
				$copyObj->addTrustI18n($relObj->copy($deepCopy));
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
	 * @return     Trust Clone of current object.
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
	 * @return     TrustPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new TrustPeer();
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
	 * Temporary storage of collTrustI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initTrustI18ns()
	{
		if ($this->collTrustI18ns === null) {
			$this->collTrustI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Trust has previously
	 * been saved, it will retrieve related TrustI18ns from storage.
	 * If this Trust is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getTrustI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTrustI18ns === null) {
			if ($this->isNew()) {
			   $this->collTrustI18ns = array();
			} else {

				$criteria->add(TrustI18nPeer::ID, $this->getId());

				TrustI18nPeer::addSelectColumns($criteria);
				$this->collTrustI18ns = TrustI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(TrustI18nPeer::ID, $this->getId());

				TrustI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastTrustI18nCriteria) || !$this->lastTrustI18nCriteria->equals($criteria)) {
					$this->collTrustI18ns = TrustI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTrustI18nCriteria = $criteria;
		return $this->collTrustI18ns;
	}

	/**
	 * Returns the number of related TrustI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countTrustI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TrustI18nPeer::ID, $this->getId());

		return TrustI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a TrustI18n object to this object
	 * through the TrustI18n foreign key attribute
	 *
	 * @param      TrustI18n $l TrustI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addTrustI18n(TrustI18n $l)
	{
		$this->collTrustI18ns[] = $l;
		$l->setTrust($this);
	}

  public function getCulture()
  {
    return $this->culture;
  }

  public function setCulture($culture)
  {
    $this->culture = $culture;
  }

  public function getFieldDescription()
  {
    $obj = $this->getCurrentTrustI18n();

    return ($obj ? $obj->getFieldDescription() : null);
  }

  public function setFieldDescription($value)
  {
    $this->getCurrentTrustI18n()->setFieldDescription($value);
  }

  public function getFieldLabelF()
  {
    $obj = $this->getCurrentTrustI18n();

    return ($obj ? $obj->getFieldLabelF() : null);
  }

  public function setFieldLabelF($value)
  {
    $this->getCurrentTrustI18n()->setFieldLabelF($value);
  }

  public function getFieldSubLabelF()
  {
    $obj = $this->getCurrentTrustI18n();

    return ($obj ? $obj->getFieldSubLabelF() : null);
  }

  public function setFieldSubLabelF($value)
  {
    $this->getCurrentTrustI18n()->setFieldSubLabelF($value);
  }

  public function getFieldDescriptionF()
  {
    $obj = $this->getCurrentTrustI18n();

    return ($obj ? $obj->getFieldDescriptionF() : null);
  }

  public function setFieldDescriptionF($value)
  {
    $this->getCurrentTrustI18n()->setFieldDescriptionF($value);
  }

  public function getIconF()
  {
    $obj = $this->getCurrentTrustI18n();

    return ($obj ? $obj->getIconF() : null);
  }

  public function setIconF($value)
  {
    $this->getCurrentTrustI18n()->setIconF($value);
  }

  public function getFieldLabelS()
  {
    $obj = $this->getCurrentTrustI18n();

    return ($obj ? $obj->getFieldLabelS() : null);
  }

  public function setFieldLabelS($value)
  {
    $this->getCurrentTrustI18n()->setFieldLabelS($value);
  }

  public function getFieldSubLabelS()
  {
    $obj = $this->getCurrentTrustI18n();

    return ($obj ? $obj->getFieldSubLabelS() : null);
  }

  public function setFieldSubLabelS($value)
  {
    $this->getCurrentTrustI18n()->setFieldSubLabelS($value);
  }

  public function getFieldDescriptionS()
  {
    $obj = $this->getCurrentTrustI18n();

    return ($obj ? $obj->getFieldDescriptionS() : null);
  }

  public function setFieldDescriptionS($value)
  {
    $this->getCurrentTrustI18n()->setFieldDescriptionS($value);
  }

  public function getIconS()
  {
    $obj = $this->getCurrentTrustI18n();

    return ($obj ? $obj->getIconS() : null);
  }

  public function setIconS($value)
  {
    $this->getCurrentTrustI18n()->setIconS($value);
  }

  public function getFieldLabelT()
  {
    $obj = $this->getCurrentTrustI18n();

    return ($obj ? $obj->getFieldLabelT() : null);
  }

  public function setFieldLabelT($value)
  {
    $this->getCurrentTrustI18n()->setFieldLabelT($value);
  }

  public function getFieldSubLabelT()
  {
    $obj = $this->getCurrentTrustI18n();

    return ($obj ? $obj->getFieldSubLabelT() : null);
  }

  public function setFieldSubLabelT($value)
  {
    $this->getCurrentTrustI18n()->setFieldSubLabelT($value);
  }

  public function getFieldDescriptionT()
  {
    $obj = $this->getCurrentTrustI18n();

    return ($obj ? $obj->getFieldDescriptionT() : null);
  }

  public function setFieldDescriptionT($value)
  {
    $this->getCurrentTrustI18n()->setFieldDescriptionT($value);
  }

  public function getIconT()
  {
    $obj = $this->getCurrentTrustI18n();

    return ($obj ? $obj->getIconT() : null);
  }

  public function setIconT($value)
  {
    $this->getCurrentTrustI18n()->setIconT($value);
  }

  public $current_i18n = array();

  public function getCurrentTrustI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = TrustI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setTrustI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setTrustI18nForCulture(new TrustI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setTrustI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addTrustI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Trust.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseTrust:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseTrust::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseTrust
