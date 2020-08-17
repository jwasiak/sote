<?php

/**
 * Base class that represents a row from the 'st_gift_card' table.
 *
 * 
 *
 * @package    plugins.stGiftCardPlugin.lib.model.om
 */
abstract class BaseGiftCard extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        GiftCardPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the status field.
	 * @var        string
	 */
	protected $status = 'A';


	/**
	 * The value for the amount field.
	 * @var        double
	 */
	protected $amount;


	/**
	 * The value for the min_order_amount field.
	 * @var        int
	 */
	protected $min_order_amount = 0;


	/**
	 * The value for the code field.
	 * @var        string
	 */
	protected $code;


	/**
	 * The value for the valid_to field.
	 * @var        int
	 */
	protected $valid_to;


	/**
	 * The value for the currency_id field.
	 * @var        int
	 */
	protected $currency_id;


	/**
	 * The value for the allow_all_products field.
	 * @var        boolean
	 */
	protected $allow_all_products;

	/**
	 * @var        Currency
	 */
	protected $aCurrency;

	/**
	 * Collection to store aggregation of collPayments.
	 * @var        array
	 */
	protected $collPayments;

	/**
	 * The criteria used to select the current contents of collPayments.
	 * @var        Criteria
	 */
	protected $lastPaymentCriteria = null;

	/**
	 * Collection to store aggregation of collGiftCardHasCategorys.
	 * @var        array
	 */
	protected $collGiftCardHasCategorys;

	/**
	 * The criteria used to select the current contents of collGiftCardHasCategorys.
	 * @var        Criteria
	 */
	protected $lastGiftCardHasCategoryCriteria = null;

	/**
	 * Collection to store aggregation of collGiftCardHasProducers.
	 * @var        array
	 */
	protected $collGiftCardHasProducers;

	/**
	 * The criteria used to select the current contents of collGiftCardHasProducers.
	 * @var        Criteria
	 */
	protected $lastGiftCardHasProducerCriteria = null;

	/**
	 * Collection to store aggregation of collGiftCardHasProducts.
	 * @var        array
	 */
	protected $collGiftCardHasProducts;

	/**
	 * The criteria used to select the current contents of collGiftCardHasProducts.
	 * @var        Criteria
	 */
	protected $lastGiftCardHasProductCriteria = null;

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
     * Get the [id] column value.
     * 
     * @return     int
     */
    public function getId()
    {

            return $this->id;
    }

    /**
     * Get the [status] column value.
     * 
     * @return     string
     */
    public function getStatus()
    {

            return $this->status;
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
     * Get the [min_order_amount] column value.
     * 
     * @return     int
     */
    public function getMinOrderAmount()
    {

            return $this->min_order_amount;
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
	 * Get the [optionally formatted] [valid_to] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getValidTo($format = 'Y-m-d')
	{

		if ($this->valid_to === null || $this->valid_to === '') {
			return null;
		} elseif (!is_int($this->valid_to)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->valid_to);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [valid_to] as date/time value: " . var_export($this->valid_to, true));
			}
		} else {
			$ts = $this->valid_to;
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
     * Get the [currency_id] column value.
     * 
     * @return     int
     */
    public function getCurrencyId()
    {

            return $this->currency_id;
    }

    /**
     * Get the [allow_all_products] column value.
     * 
     * @return     boolean
     */
    public function getAllowAllProducts()
    {

            return $this->allow_all_products;
    }

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
          $this->modifiedColumns[] = GiftCardPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [status] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setStatus($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->status !== $v || $v === 'A') {
          $this->status = $v;
          $this->modifiedColumns[] = GiftCardPeer::STATUS;
        }

	} // setStatus()

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
          $this->modifiedColumns[] = GiftCardPeer::AMOUNT;
        }

	} // setAmount()

	/**
	 * Set the value of [min_order_amount] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setMinOrderAmount($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->min_order_amount !== $v || $v === 0) {
          $this->min_order_amount = $v;
          $this->modifiedColumns[] = GiftCardPeer::MIN_ORDER_AMOUNT;
        }

	} // setMinOrderAmount()

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
          $this->modifiedColumns[] = GiftCardPeer::CODE;
        }

	} // setCode()

	/**
	 * Set the value of [valid_to] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setValidTo($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [valid_to] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->valid_to !== $ts) {
			$this->valid_to = $ts;
			$this->modifiedColumns[] = GiftCardPeer::VALID_TO;
		}

	} // setValidTo()

	/**
	 * Set the value of [currency_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCurrencyId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->currency_id !== $v) {
          $this->currency_id = $v;
          $this->modifiedColumns[] = GiftCardPeer::CURRENCY_ID;
        }

		if ($this->aCurrency !== null && $this->aCurrency->getId() !== $v) {
			$this->aCurrency = null;
		}

	} // setCurrencyId()

	/**
	 * Set the value of [allow_all_products] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setAllowAllProducts($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->allow_all_products !== $v) {
          $this->allow_all_products = $v;
          $this->modifiedColumns[] = GiftCardPeer::ALLOW_ALL_PRODUCTS;
        }

	} // setAllowAllProducts()

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
      if ($this->getDispatcher()->getListeners('GiftCard.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'GiftCard.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->status = $rs->getString($startcol + 1);

      $this->amount = $rs->getString($startcol + 2);
      if (null !== $this->amount && $this->amount == intval($this->amount))
      {
        $this->amount = (string)intval($this->amount);
      }

      $this->min_order_amount = $rs->getInt($startcol + 3);

      $this->code = $rs->getString($startcol + 4);

      $this->valid_to = $rs->getDate($startcol + 5, null);

      $this->currency_id = $rs->getInt($startcol + 6);

      $this->allow_all_products = $rs->getBoolean($startcol + 7);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('GiftCard.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'GiftCard.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 8)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 8; // 8 = GiftCardPeer::NUM_COLUMNS - GiftCardPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating GiftCard object", $e);
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

    if ($this->getDispatcher()->getListeners('GiftCard.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'GiftCard.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseGiftCard:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseGiftCard:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(GiftCardPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      GiftCardPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('GiftCard.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'GiftCard.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseGiftCard:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseGiftCard:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('GiftCard.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'GiftCard.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseGiftCard:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(GiftCardPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('GiftCard.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'GiftCard.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseGiftCard:save:post') as $callable)
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

			if ($this->aCurrency !== null) {
				if ($this->aCurrency->isModified() || $this->aCurrency->getCurrentCurrencyI18n()->isModified()) {
					$affectedRows += $this->aCurrency->save($con);
				}
				$this->setCurrency($this->aCurrency);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = GiftCardPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += GiftCardPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPayments !== null) {
				foreach($this->collPayments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGiftCardHasCategorys !== null) {
				foreach($this->collGiftCardHasCategorys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGiftCardHasProducers !== null) {
				foreach($this->collGiftCardHasProducers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGiftCardHasProducts !== null) {
				foreach($this->collGiftCardHasProducts as $referrerFK) {
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

			if ($this->aCurrency !== null) {
				if (!$this->aCurrency->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCurrency->getValidationFailures());
				}
			}


			if (($retval = GiftCardPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPayments !== null) {
					foreach($this->collPayments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGiftCardHasCategorys !== null) {
					foreach($this->collGiftCardHasCategorys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGiftCardHasProducers !== null) {
					foreach($this->collGiftCardHasProducers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGiftCardHasProducts !== null) {
					foreach($this->collGiftCardHasProducts as $referrerFK) {
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
		$pos = GiftCardPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getId();
				break;
			case 1:
				return $this->getStatus();
				break;
			case 2:
				return $this->getAmount();
				break;
			case 3:
				return $this->getMinOrderAmount();
				break;
			case 4:
				return $this->getCode();
				break;
			case 5:
				return $this->getValidTo();
				break;
			case 6:
				return $this->getCurrencyId();
				break;
			case 7:
				return $this->getAllowAllProducts();
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
		$keys = GiftCardPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getStatus(),
			$keys[2] => $this->getAmount(),
			$keys[3] => $this->getMinOrderAmount(),
			$keys[4] => $this->getCode(),
			$keys[5] => $this->getValidTo(),
			$keys[6] => $this->getCurrencyId(),
			$keys[7] => $this->getAllowAllProducts(),
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
		$pos = GiftCardPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setId($value);
				break;
			case 1:
				$this->setStatus($value);
				break;
			case 2:
				$this->setAmount($value);
				break;
			case 3:
				$this->setMinOrderAmount($value);
				break;
			case 4:
				$this->setCode($value);
				break;
			case 5:
				$this->setValidTo($value);
				break;
			case 6:
				$this->setCurrencyId($value);
				break;
			case 7:
				$this->setAllowAllProducts($value);
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
		$keys = GiftCardPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setStatus($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setAmount($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setMinOrderAmount($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCode($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setValidTo($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCurrencyId($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setAllowAllProducts($arr[$keys[7]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(GiftCardPeer::DATABASE_NAME);

		if ($this->isColumnModified(GiftCardPeer::ID)) $criteria->add(GiftCardPeer::ID, $this->id);
		if ($this->isColumnModified(GiftCardPeer::STATUS)) $criteria->add(GiftCardPeer::STATUS, $this->status);
		if ($this->isColumnModified(GiftCardPeer::AMOUNT)) $criteria->add(GiftCardPeer::AMOUNT, $this->amount);
		if ($this->isColumnModified(GiftCardPeer::MIN_ORDER_AMOUNT)) $criteria->add(GiftCardPeer::MIN_ORDER_AMOUNT, $this->min_order_amount);
		if ($this->isColumnModified(GiftCardPeer::CODE)) $criteria->add(GiftCardPeer::CODE, $this->code);
		if ($this->isColumnModified(GiftCardPeer::VALID_TO)) $criteria->add(GiftCardPeer::VALID_TO, $this->valid_to);
		if ($this->isColumnModified(GiftCardPeer::CURRENCY_ID)) $criteria->add(GiftCardPeer::CURRENCY_ID, $this->currency_id);
		if ($this->isColumnModified(GiftCardPeer::ALLOW_ALL_PRODUCTS)) $criteria->add(GiftCardPeer::ALLOW_ALL_PRODUCTS, $this->allow_all_products);

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
		$criteria = new Criteria(GiftCardPeer::DATABASE_NAME);

		$criteria->add(GiftCardPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of GiftCard (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setStatus($this->status);

		$copyObj->setAmount($this->amount);

		$copyObj->setMinOrderAmount($this->min_order_amount);

		$copyObj->setCode($this->code);

		$copyObj->setValidTo($this->valid_to);

		$copyObj->setCurrencyId($this->currency_id);

		$copyObj->setAllowAllProducts($this->allow_all_products);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getPayments() as $relObj) {
				$copyObj->addPayment($relObj->copy($deepCopy));
			}

			foreach($this->getGiftCardHasCategorys() as $relObj) {
				$copyObj->addGiftCardHasCategory($relObj->copy($deepCopy));
			}

			foreach($this->getGiftCardHasProducers() as $relObj) {
				$copyObj->addGiftCardHasProducer($relObj->copy($deepCopy));
			}

			foreach($this->getGiftCardHasProducts() as $relObj) {
				$copyObj->addGiftCardHasProduct($relObj->copy($deepCopy));
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
	 * @return     GiftCard Clone of current object.
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
	 * @return     GiftCardPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new GiftCardPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Currency object.
	 *
	 * @param      Currency $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setCurrency($v)
	{


		if ($v === null) {
			$this->setCurrencyId(NULL);
		} else {
			$this->setCurrencyId($v->getId());
		}


		$this->aCurrency = $v;
	}


	/**
	 * Get the associated Currency object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Currency The associated Currency object.
	 * @throws     PropelException
	 */
	public function getCurrency($con = null)
	{
		if ($this->aCurrency === null && ($this->currency_id !== null)) {
			// include the related Peer class
			$this->aCurrency = CurrencyPeer::retrieveByPK($this->currency_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = CurrencyPeer::retrieveByPK($this->currency_id, $con);
			   $obj->addCurrencys($this);
			 */
		}
		return $this->aCurrency;
	}

	/**
	 * Temporary storage of collPayments to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPayments()
	{
		if ($this->collPayments === null) {
			$this->collPayments = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GiftCard has previously
	 * been saved, it will retrieve related Payments from storage.
	 * If this GiftCard is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPayments($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPayments === null) {
			if ($this->isNew()) {
			   $this->collPayments = array();
			} else {

				$criteria->add(PaymentPeer::GIFT_CARD_ID, $this->getId());

				PaymentPeer::addSelectColumns($criteria);
				$this->collPayments = PaymentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PaymentPeer::GIFT_CARD_ID, $this->getId());

				PaymentPeer::addSelectColumns($criteria);
				if (!isset($this->lastPaymentCriteria) || !$this->lastPaymentCriteria->equals($criteria)) {
					$this->collPayments = PaymentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPaymentCriteria = $criteria;
		return $this->collPayments;
	}

	/**
	 * Returns the number of related Payments.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPayments($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PaymentPeer::GIFT_CARD_ID, $this->getId());

		return PaymentPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Payment object to this object
	 * through the Payment foreign key attribute
	 *
	 * @param      Payment $l Payment
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPayment(Payment $l)
	{
		$this->collPayments[] = $l;
		$l->setGiftCard($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GiftCard is new, it will return
	 * an empty collection; or if this GiftCard has previously
	 * been saved, it will retrieve related Payments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in GiftCard.
	 */
	public function getPaymentsJoinsfGuardUser($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPayments === null) {
			if ($this->isNew()) {
				$this->collPayments = array();
			} else {

				$criteria->add(PaymentPeer::GIFT_CARD_ID, $this->getId());

				$this->collPayments = PaymentPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PaymentPeer::GIFT_CARD_ID, $this->getId());

			if (!isset($this->lastPaymentCriteria) || !$this->lastPaymentCriteria->equals($criteria)) {
				$this->collPayments = PaymentPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastPaymentCriteria = $criteria;

		return $this->collPayments;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GiftCard is new, it will return
	 * an empty collection; or if this GiftCard has previously
	 * been saved, it will retrieve related Payments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in GiftCard.
	 */
	public function getPaymentsJoinPaymentType($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPayments === null) {
			if ($this->isNew()) {
				$this->collPayments = array();
			} else {

				$criteria->add(PaymentPeer::GIFT_CARD_ID, $this->getId());

				$this->collPayments = PaymentPeer::doSelectJoinPaymentType($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PaymentPeer::GIFT_CARD_ID, $this->getId());

			if (!isset($this->lastPaymentCriteria) || !$this->lastPaymentCriteria->equals($criteria)) {
				$this->collPayments = PaymentPeer::doSelectJoinPaymentType($criteria, $con);
			}
		}
		$this->lastPaymentCriteria = $criteria;

		return $this->collPayments;
	}

	/**
	 * Temporary storage of collGiftCardHasCategorys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initGiftCardHasCategorys()
	{
		if ($this->collGiftCardHasCategorys === null) {
			$this->collGiftCardHasCategorys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GiftCard has previously
	 * been saved, it will retrieve related GiftCardHasCategorys from storage.
	 * If this GiftCard is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getGiftCardHasCategorys($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGiftCardHasCategorys === null) {
			if ($this->isNew()) {
			   $this->collGiftCardHasCategorys = array();
			} else {

				$criteria->add(GiftCardHasCategoryPeer::GIFT_CARD_ID, $this->getId());

				GiftCardHasCategoryPeer::addSelectColumns($criteria);
				$this->collGiftCardHasCategorys = GiftCardHasCategoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GiftCardHasCategoryPeer::GIFT_CARD_ID, $this->getId());

				GiftCardHasCategoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastGiftCardHasCategoryCriteria) || !$this->lastGiftCardHasCategoryCriteria->equals($criteria)) {
					$this->collGiftCardHasCategorys = GiftCardHasCategoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGiftCardHasCategoryCriteria = $criteria;
		return $this->collGiftCardHasCategorys;
	}

	/**
	 * Returns the number of related GiftCardHasCategorys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countGiftCardHasCategorys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(GiftCardHasCategoryPeer::GIFT_CARD_ID, $this->getId());

		return GiftCardHasCategoryPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a GiftCardHasCategory object to this object
	 * through the GiftCardHasCategory foreign key attribute
	 *
	 * @param      GiftCardHasCategory $l GiftCardHasCategory
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGiftCardHasCategory(GiftCardHasCategory $l)
	{
		$this->collGiftCardHasCategorys[] = $l;
		$l->setGiftCard($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GiftCard is new, it will return
	 * an empty collection; or if this GiftCard has previously
	 * been saved, it will retrieve related GiftCardHasCategorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in GiftCard.
	 */
	public function getGiftCardHasCategorysJoinCategory($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGiftCardHasCategorys === null) {
			if ($this->isNew()) {
				$this->collGiftCardHasCategorys = array();
			} else {

				$criteria->add(GiftCardHasCategoryPeer::GIFT_CARD_ID, $this->getId());

				$this->collGiftCardHasCategorys = GiftCardHasCategoryPeer::doSelectJoinCategory($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(GiftCardHasCategoryPeer::GIFT_CARD_ID, $this->getId());

			if (!isset($this->lastGiftCardHasCategoryCriteria) || !$this->lastGiftCardHasCategoryCriteria->equals($criteria)) {
				$this->collGiftCardHasCategorys = GiftCardHasCategoryPeer::doSelectJoinCategory($criteria, $con);
			}
		}
		$this->lastGiftCardHasCategoryCriteria = $criteria;

		return $this->collGiftCardHasCategorys;
	}

	/**
	 * Temporary storage of collGiftCardHasProducers to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initGiftCardHasProducers()
	{
		if ($this->collGiftCardHasProducers === null) {
			$this->collGiftCardHasProducers = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GiftCard has previously
	 * been saved, it will retrieve related GiftCardHasProducers from storage.
	 * If this GiftCard is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getGiftCardHasProducers($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGiftCardHasProducers === null) {
			if ($this->isNew()) {
			   $this->collGiftCardHasProducers = array();
			} else {

				$criteria->add(GiftCardHasProducerPeer::GIFT_CARD_ID, $this->getId());

				GiftCardHasProducerPeer::addSelectColumns($criteria);
				$this->collGiftCardHasProducers = GiftCardHasProducerPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GiftCardHasProducerPeer::GIFT_CARD_ID, $this->getId());

				GiftCardHasProducerPeer::addSelectColumns($criteria);
				if (!isset($this->lastGiftCardHasProducerCriteria) || !$this->lastGiftCardHasProducerCriteria->equals($criteria)) {
					$this->collGiftCardHasProducers = GiftCardHasProducerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGiftCardHasProducerCriteria = $criteria;
		return $this->collGiftCardHasProducers;
	}

	/**
	 * Returns the number of related GiftCardHasProducers.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countGiftCardHasProducers($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(GiftCardHasProducerPeer::GIFT_CARD_ID, $this->getId());

		return GiftCardHasProducerPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a GiftCardHasProducer object to this object
	 * through the GiftCardHasProducer foreign key attribute
	 *
	 * @param      GiftCardHasProducer $l GiftCardHasProducer
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGiftCardHasProducer(GiftCardHasProducer $l)
	{
		$this->collGiftCardHasProducers[] = $l;
		$l->setGiftCard($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GiftCard is new, it will return
	 * an empty collection; or if this GiftCard has previously
	 * been saved, it will retrieve related GiftCardHasProducers from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in GiftCard.
	 */
	public function getGiftCardHasProducersJoinProducer($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGiftCardHasProducers === null) {
			if ($this->isNew()) {
				$this->collGiftCardHasProducers = array();
			} else {

				$criteria->add(GiftCardHasProducerPeer::GIFT_CARD_ID, $this->getId());

				$this->collGiftCardHasProducers = GiftCardHasProducerPeer::doSelectJoinProducer($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(GiftCardHasProducerPeer::GIFT_CARD_ID, $this->getId());

			if (!isset($this->lastGiftCardHasProducerCriteria) || !$this->lastGiftCardHasProducerCriteria->equals($criteria)) {
				$this->collGiftCardHasProducers = GiftCardHasProducerPeer::doSelectJoinProducer($criteria, $con);
			}
		}
		$this->lastGiftCardHasProducerCriteria = $criteria;

		return $this->collGiftCardHasProducers;
	}

	/**
	 * Temporary storage of collGiftCardHasProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initGiftCardHasProducts()
	{
		if ($this->collGiftCardHasProducts === null) {
			$this->collGiftCardHasProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GiftCard has previously
	 * been saved, it will retrieve related GiftCardHasProducts from storage.
	 * If this GiftCard is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getGiftCardHasProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGiftCardHasProducts === null) {
			if ($this->isNew()) {
			   $this->collGiftCardHasProducts = array();
			} else {

				$criteria->add(GiftCardHasProductPeer::GIFT_CARD_ID, $this->getId());

				GiftCardHasProductPeer::addSelectColumns($criteria);
				$this->collGiftCardHasProducts = GiftCardHasProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GiftCardHasProductPeer::GIFT_CARD_ID, $this->getId());

				GiftCardHasProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastGiftCardHasProductCriteria) || !$this->lastGiftCardHasProductCriteria->equals($criteria)) {
					$this->collGiftCardHasProducts = GiftCardHasProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGiftCardHasProductCriteria = $criteria;
		return $this->collGiftCardHasProducts;
	}

	/**
	 * Returns the number of related GiftCardHasProducts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countGiftCardHasProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(GiftCardHasProductPeer::GIFT_CARD_ID, $this->getId());

		return GiftCardHasProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a GiftCardHasProduct object to this object
	 * through the GiftCardHasProduct foreign key attribute
	 *
	 * @param      GiftCardHasProduct $l GiftCardHasProduct
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGiftCardHasProduct(GiftCardHasProduct $l)
	{
		$this->collGiftCardHasProducts[] = $l;
		$l->setGiftCard($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this GiftCard is new, it will return
	 * an empty collection; or if this GiftCard has previously
	 * been saved, it will retrieve related GiftCardHasProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in GiftCard.
	 */
	public function getGiftCardHasProductsJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGiftCardHasProducts === null) {
			if ($this->isNew()) {
				$this->collGiftCardHasProducts = array();
			} else {

				$criteria->add(GiftCardHasProductPeer::GIFT_CARD_ID, $this->getId());

				$this->collGiftCardHasProducts = GiftCardHasProductPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(GiftCardHasProductPeer::GIFT_CARD_ID, $this->getId());

			if (!isset($this->lastGiftCardHasProductCriteria) || !$this->lastGiftCardHasProductCriteria->equals($criteria)) {
				$this->collGiftCardHasProducts = GiftCardHasProductPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastGiftCardHasProductCriteria = $criteria;

		return $this->collGiftCardHasProducts;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'GiftCard.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseGiftCard:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseGiftCard::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseGiftCard
