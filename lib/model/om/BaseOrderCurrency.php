<?php

/**
 * Base class that represents a row from the 'st_order_currency' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseOrderCurrency extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        OrderCurrencyPeer
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
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the exchange field.
	 * @var        double
	 */
	protected $exchange;


	/**
	 * The value for the shortcut field.
	 * @var        string
	 */
	protected $shortcut;


	/**
	 * The value for the front_symbol field.
	 * @var        string
	 */
	protected $front_symbol;


	/**
	 * The value for the back_symbol field.
	 * @var        string
	 */
	protected $back_symbol;

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
     * Get the [name] column value.
     * 
     * @return     string
     */
    public function getName()
    {

            return $this->name;
    }

    /**
     * Get the [exchange] column value.
     * 
     * @return     double
     */
    public function getExchange()
    {

            return null !== $this->exchange ? (string)$this->exchange : null;
    }

    /**
     * Get the [shortcut] column value.
     * 
     * @return     string
     */
    public function getShortcut()
    {

            return $this->shortcut;
    }

    /**
     * Get the [front_symbol] column value.
     * 
     * @return     string
     */
    public function getFrontSymbol()
    {

            return $this->front_symbol;
    }

    /**
     * Get the [back_symbol] column value.
     * 
     * @return     string
     */
    public function getBackSymbol()
    {

            return $this->back_symbol;
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
			$this->modifiedColumns[] = OrderCurrencyPeer::CREATED_AT;
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
			$this->modifiedColumns[] = OrderCurrencyPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = OrderCurrencyPeer::ID;
        }

	} // setId()

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
          $this->modifiedColumns[] = OrderCurrencyPeer::NAME;
        }

	} // setName()

	/**
	 * Set the value of [exchange] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setExchange($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->exchange !== $v) {
          $this->exchange = $v;
          $this->modifiedColumns[] = OrderCurrencyPeer::EXCHANGE;
        }

	} // setExchange()

	/**
	 * Set the value of [shortcut] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setShortcut($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->shortcut !== $v) {
          $this->shortcut = $v;
          $this->modifiedColumns[] = OrderCurrencyPeer::SHORTCUT;
        }

	} // setShortcut()

	/**
	 * Set the value of [front_symbol] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFrontSymbol($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->front_symbol !== $v) {
          $this->front_symbol = $v;
          $this->modifiedColumns[] = OrderCurrencyPeer::FRONT_SYMBOL;
        }

	} // setFrontSymbol()

	/**
	 * Set the value of [back_symbol] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setBackSymbol($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->back_symbol !== $v) {
          $this->back_symbol = $v;
          $this->modifiedColumns[] = OrderCurrencyPeer::BACK_SYMBOL;
        }

	} // setBackSymbol()

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
      if ($this->getDispatcher()->getListeners('OrderCurrency.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'OrderCurrency.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->name = $rs->getString($startcol + 3);

      $this->exchange = $rs->getString($startcol + 4);
      if (null !== $this->exchange && $this->exchange == intval($this->exchange))
      {
        $this->exchange = (string)intval($this->exchange);
      }

      $this->shortcut = $rs->getString($startcol + 5);

      $this->front_symbol = $rs->getString($startcol + 6);

      $this->back_symbol = $rs->getString($startcol + 7);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('OrderCurrency.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'OrderCurrency.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 8)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 8; // 8 = OrderCurrencyPeer::NUM_COLUMNS - OrderCurrencyPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating OrderCurrency object", $e);
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

    if ($this->getDispatcher()->getListeners('OrderCurrency.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'OrderCurrency.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseOrderCurrency:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseOrderCurrency:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(OrderCurrencyPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      OrderCurrencyPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('OrderCurrency.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'OrderCurrency.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseOrderCurrency:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseOrderCurrency:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('OrderCurrency.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'OrderCurrency.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseOrderCurrency:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(OrderCurrencyPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(OrderCurrencyPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(OrderCurrencyPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('OrderCurrency.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'OrderCurrency.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseOrderCurrency:save:post') as $callable)
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
					$pk = OrderCurrencyPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += OrderCurrencyPeer::doUpdate($this, $con);
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


			if (($retval = OrderCurrencyPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOrders !== null) {
					foreach($this->collOrders as $referrerFK) {
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
		$pos = OrderCurrencyPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getName();
				break;
			case 4:
				return $this->getExchange();
				break;
			case 5:
				return $this->getShortcut();
				break;
			case 6:
				return $this->getFrontSymbol();
				break;
			case 7:
				return $this->getBackSymbol();
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
		$keys = OrderCurrencyPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getName(),
			$keys[4] => $this->getExchange(),
			$keys[5] => $this->getShortcut(),
			$keys[6] => $this->getFrontSymbol(),
			$keys[7] => $this->getBackSymbol(),
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
		$pos = OrderCurrencyPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setName($value);
				break;
			case 4:
				$this->setExchange($value);
				break;
			case 5:
				$this->setShortcut($value);
				break;
			case 6:
				$this->setFrontSymbol($value);
				break;
			case 7:
				$this->setBackSymbol($value);
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
		$keys = OrderCurrencyPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setExchange($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setShortcut($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setFrontSymbol($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setBackSymbol($arr[$keys[7]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(OrderCurrencyPeer::DATABASE_NAME);

		if ($this->isColumnModified(OrderCurrencyPeer::CREATED_AT)) $criteria->add(OrderCurrencyPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(OrderCurrencyPeer::UPDATED_AT)) $criteria->add(OrderCurrencyPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(OrderCurrencyPeer::ID)) $criteria->add(OrderCurrencyPeer::ID, $this->id);
		if ($this->isColumnModified(OrderCurrencyPeer::NAME)) $criteria->add(OrderCurrencyPeer::NAME, $this->name);
		if ($this->isColumnModified(OrderCurrencyPeer::EXCHANGE)) $criteria->add(OrderCurrencyPeer::EXCHANGE, $this->exchange);
		if ($this->isColumnModified(OrderCurrencyPeer::SHORTCUT)) $criteria->add(OrderCurrencyPeer::SHORTCUT, $this->shortcut);
		if ($this->isColumnModified(OrderCurrencyPeer::FRONT_SYMBOL)) $criteria->add(OrderCurrencyPeer::FRONT_SYMBOL, $this->front_symbol);
		if ($this->isColumnModified(OrderCurrencyPeer::BACK_SYMBOL)) $criteria->add(OrderCurrencyPeer::BACK_SYMBOL, $this->back_symbol);

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
		$criteria = new Criteria(OrderCurrencyPeer::DATABASE_NAME);

		$criteria->add(OrderCurrencyPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of OrderCurrency (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setName($this->name);

		$copyObj->setExchange($this->exchange);

		$copyObj->setShortcut($this->shortcut);

		$copyObj->setFrontSymbol($this->front_symbol);

		$copyObj->setBackSymbol($this->back_symbol);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getOrders() as $relObj) {
				$copyObj->addOrder($relObj->copy($deepCopy));
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
	 * @return     OrderCurrency Clone of current object.
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
	 * @return     OrderCurrencyPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new OrderCurrencyPeer();
		}
		return self::$peer;
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
	 * Otherwise if this OrderCurrency has previously
	 * been saved, it will retrieve related Orders from storage.
	 * If this OrderCurrency is new, it will return
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

				$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

				OrderPeer::addSelectColumns($criteria);
				$this->collOrders = OrderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

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

		$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

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
		$l->setOrderCurrency($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this OrderCurrency is new, it will return
	 * an empty collection; or if this OrderCurrency has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderCurrency.
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

				$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

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
	 * Otherwise if this OrderCurrency is new, it will return
	 * an empty collection; or if this OrderCurrency has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderCurrency.
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

				$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

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
	 * Otherwise if this OrderCurrency is new, it will return
	 * an empty collection; or if this OrderCurrency has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderCurrency.
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

				$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

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
	 * Otherwise if this OrderCurrency is new, it will return
	 * an empty collection; or if this OrderCurrency has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderCurrency.
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

				$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataBilling($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

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
	 * Otherwise if this OrderCurrency is new, it will return
	 * an empty collection; or if this OrderCurrency has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderCurrency.
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

				$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderStatus($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

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
	 * Otherwise if this OrderCurrency is new, it will return
	 * an empty collection; or if this OrderCurrency has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderCurrency.
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

				$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

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
	 * Otherwise if this OrderCurrency is new, it will return
	 * an empty collection; or if this OrderCurrency has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderCurrency.
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

				$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinDiscount($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinDiscount($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this OrderCurrency is new, it will return
	 * an empty collection; or if this OrderCurrency has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in OrderCurrency.
	 */
	public function getOrdersJoinPartner($criteria = null, $con = null)
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

				$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinPartner($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::ORDER_CURRENCY_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinPartner($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'OrderCurrency.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseOrderCurrency:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseOrderCurrency::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseOrderCurrency
