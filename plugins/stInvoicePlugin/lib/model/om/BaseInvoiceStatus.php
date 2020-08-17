<?php

/**
 * Base class that represents a row from the 'st_invoice_status' table.
 *
 * 
 *
 * @package    plugins.stInvoicePlugin.lib.model.om
 */
abstract class BaseInvoiceStatus extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        InvoiceStatusPeer
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
	 * The value for the invoice_id field.
	 * @var        int
	 */
	protected $invoice_id;


	/**
	 * The value for the payment_id field.
	 * @var        int
	 */
	protected $payment_id = 0;


	/**
	 * The value for the opt_payment_type_name field.
	 * @var        string
	 */
	protected $opt_payment_type_name;


	/**
	 * The value for the opt_payment_status field.
	 * @var        boolean
	 */
	protected $opt_payment_status = false;


	/**
	 * The value for the opt_payment_type_id field.
	 * @var        int
	 */
	protected $opt_payment_type_id;


	/**
	 * The value for the hand_mod field.
	 * @var        boolean
	 */
	protected $hand_mod = false;


	/**
	 * The value for the paid_amount field.
	 * @var        double
	 */
	protected $paid_amount;

	/**
	 * @var        Invoice
	 */
	protected $aInvoice;

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
     * Get the [invoice_id] column value.
     * 
     * @return     int
     */
    public function getInvoiceId()
    {

            return $this->invoice_id;
    }

    /**
     * Get the [payment_id] column value.
     * 
     * @return     int
     */
    public function getPaymentId()
    {

            return $this->payment_id;
    }

    /**
     * Get the [opt_payment_type_name] column value.
     * 
     * @return     string
     */
    public function getOptPaymentTypeName()
    {

            return $this->opt_payment_type_name;
    }

    /**
     * Get the [opt_payment_status] column value.
     * 
     * @return     boolean
     */
    public function getOptPaymentStatus()
    {

            return $this->opt_payment_status;
    }

    /**
     * Get the [opt_payment_type_id] column value.
     * 
     * @return     int
     */
    public function getOptPaymentTypeId()
    {

            return $this->opt_payment_type_id;
    }

    /**
     * Get the [hand_mod] column value.
     * 
     * @return     boolean
     */
    public function getHandMod()
    {

            return $this->hand_mod;
    }

    /**
     * Get the [paid_amount] column value.
     * 
     * @return     double
     */
    public function getPaidAmount()
    {

            return null !== $this->paid_amount ? (string)$this->paid_amount : null;
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
			$this->modifiedColumns[] = InvoiceStatusPeer::CREATED_AT;
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
			$this->modifiedColumns[] = InvoiceStatusPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = InvoiceStatusPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [invoice_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setInvoiceId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->invoice_id !== $v) {
          $this->invoice_id = $v;
          $this->modifiedColumns[] = InvoiceStatusPeer::INVOICE_ID;
        }

		if ($this->aInvoice !== null && $this->aInvoice->getId() !== $v) {
			$this->aInvoice = null;
		}

	} // setInvoiceId()

	/**
	 * Set the value of [payment_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPaymentId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->payment_id !== $v || $v === 0) {
          $this->payment_id = $v;
          $this->modifiedColumns[] = InvoiceStatusPeer::PAYMENT_ID;
        }

	} // setPaymentId()

	/**
	 * Set the value of [opt_payment_type_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptPaymentTypeName($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_payment_type_name !== $v) {
          $this->opt_payment_type_name = $v;
          $this->modifiedColumns[] = InvoiceStatusPeer::OPT_PAYMENT_TYPE_NAME;
        }

	} // setOptPaymentTypeName()

	/**
	 * Set the value of [opt_payment_status] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setOptPaymentStatus($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->opt_payment_status !== $v || $v === false) {
          $this->opt_payment_status = $v;
          $this->modifiedColumns[] = InvoiceStatusPeer::OPT_PAYMENT_STATUS;
        }

	} // setOptPaymentStatus()

	/**
	 * Set the value of [opt_payment_type_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOptPaymentTypeId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->opt_payment_type_id !== $v) {
          $this->opt_payment_type_id = $v;
          $this->modifiedColumns[] = InvoiceStatusPeer::OPT_PAYMENT_TYPE_ID;
        }

	} // setOptPaymentTypeId()

	/**
	 * Set the value of [hand_mod] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setHandMod($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->hand_mod !== $v || $v === false) {
          $this->hand_mod = $v;
          $this->modifiedColumns[] = InvoiceStatusPeer::HAND_MOD;
        }

	} // setHandMod()

	/**
	 * Set the value of [paid_amount] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setPaidAmount($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->paid_amount !== $v) {
          $this->paid_amount = $v;
          $this->modifiedColumns[] = InvoiceStatusPeer::PAID_AMOUNT;
        }

	} // setPaidAmount()

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
      if ($this->getDispatcher()->getListeners('InvoiceStatus.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceStatus.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->invoice_id = $rs->getInt($startcol + 3);

      $this->payment_id = $rs->getInt($startcol + 4);

      $this->opt_payment_type_name = $rs->getString($startcol + 5);

      $this->opt_payment_status = $rs->getBoolean($startcol + 6);

      $this->opt_payment_type_id = $rs->getInt($startcol + 7);

      $this->hand_mod = $rs->getBoolean($startcol + 8);

      $this->paid_amount = $rs->getString($startcol + 9);
      if (null !== $this->paid_amount && $this->paid_amount == intval($this->paid_amount))
      {
        $this->paid_amount = (string)intval($this->paid_amount);
      }

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('InvoiceStatus.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceStatus.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 10)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 10; // 10 = InvoiceStatusPeer::NUM_COLUMNS - InvoiceStatusPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating InvoiceStatus object", $e);
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

    if ($this->getDispatcher()->getListeners('InvoiceStatus.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceStatus.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseInvoiceStatus:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseInvoiceStatus:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(InvoiceStatusPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      InvoiceStatusPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('InvoiceStatus.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceStatus.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseInvoiceStatus:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseInvoiceStatus:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('InvoiceStatus.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceStatus.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseInvoiceStatus:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(InvoiceStatusPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(InvoiceStatusPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(InvoiceStatusPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('InvoiceStatus.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'InvoiceStatus.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseInvoiceStatus:save:post') as $callable)
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

			if ($this->aInvoice !== null) {
				if ($this->aInvoice->isModified()) {
					$affectedRows += $this->aInvoice->save($con);
				}
				$this->setInvoice($this->aInvoice);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = InvoiceStatusPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += InvoiceStatusPeer::doUpdate($this, $con);
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

			if ($this->aInvoice !== null) {
				if (!$this->aInvoice->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aInvoice->getValidationFailures());
				}
			}


			if (($retval = InvoiceStatusPeer::doValidate($this, $columns)) !== true) {
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
		$pos = InvoiceStatusPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getInvoiceId();
				break;
			case 4:
				return $this->getPaymentId();
				break;
			case 5:
				return $this->getOptPaymentTypeName();
				break;
			case 6:
				return $this->getOptPaymentStatus();
				break;
			case 7:
				return $this->getOptPaymentTypeId();
				break;
			case 8:
				return $this->getHandMod();
				break;
			case 9:
				return $this->getPaidAmount();
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
		$keys = InvoiceStatusPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getInvoiceId(),
			$keys[4] => $this->getPaymentId(),
			$keys[5] => $this->getOptPaymentTypeName(),
			$keys[6] => $this->getOptPaymentStatus(),
			$keys[7] => $this->getOptPaymentTypeId(),
			$keys[8] => $this->getHandMod(),
			$keys[9] => $this->getPaidAmount(),
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
		$pos = InvoiceStatusPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setInvoiceId($value);
				break;
			case 4:
				$this->setPaymentId($value);
				break;
			case 5:
				$this->setOptPaymentTypeName($value);
				break;
			case 6:
				$this->setOptPaymentStatus($value);
				break;
			case 7:
				$this->setOptPaymentTypeId($value);
				break;
			case 8:
				$this->setHandMod($value);
				break;
			case 9:
				$this->setPaidAmount($value);
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
		$keys = InvoiceStatusPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setInvoiceId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPaymentId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOptPaymentTypeName($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setOptPaymentStatus($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setOptPaymentTypeId($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setHandMod($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setPaidAmount($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(InvoiceStatusPeer::DATABASE_NAME);

		if ($this->isColumnModified(InvoiceStatusPeer::CREATED_AT)) $criteria->add(InvoiceStatusPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(InvoiceStatusPeer::UPDATED_AT)) $criteria->add(InvoiceStatusPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(InvoiceStatusPeer::ID)) $criteria->add(InvoiceStatusPeer::ID, $this->id);
		if ($this->isColumnModified(InvoiceStatusPeer::INVOICE_ID)) $criteria->add(InvoiceStatusPeer::INVOICE_ID, $this->invoice_id);
		if ($this->isColumnModified(InvoiceStatusPeer::PAYMENT_ID)) $criteria->add(InvoiceStatusPeer::PAYMENT_ID, $this->payment_id);
		if ($this->isColumnModified(InvoiceStatusPeer::OPT_PAYMENT_TYPE_NAME)) $criteria->add(InvoiceStatusPeer::OPT_PAYMENT_TYPE_NAME, $this->opt_payment_type_name);
		if ($this->isColumnModified(InvoiceStatusPeer::OPT_PAYMENT_STATUS)) $criteria->add(InvoiceStatusPeer::OPT_PAYMENT_STATUS, $this->opt_payment_status);
		if ($this->isColumnModified(InvoiceStatusPeer::OPT_PAYMENT_TYPE_ID)) $criteria->add(InvoiceStatusPeer::OPT_PAYMENT_TYPE_ID, $this->opt_payment_type_id);
		if ($this->isColumnModified(InvoiceStatusPeer::HAND_MOD)) $criteria->add(InvoiceStatusPeer::HAND_MOD, $this->hand_mod);
		if ($this->isColumnModified(InvoiceStatusPeer::PAID_AMOUNT)) $criteria->add(InvoiceStatusPeer::PAID_AMOUNT, $this->paid_amount);

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
		$criteria = new Criteria(InvoiceStatusPeer::DATABASE_NAME);

		$criteria->add(InvoiceStatusPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of InvoiceStatus (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setInvoiceId($this->invoice_id);

		$copyObj->setPaymentId($this->payment_id);

		$copyObj->setOptPaymentTypeName($this->opt_payment_type_name);

		$copyObj->setOptPaymentStatus($this->opt_payment_status);

		$copyObj->setOptPaymentTypeId($this->opt_payment_type_id);

		$copyObj->setHandMod($this->hand_mod);

		$copyObj->setPaidAmount($this->paid_amount);


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
	 * @return     InvoiceStatus Clone of current object.
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
	 * @return     InvoiceStatusPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new InvoiceStatusPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Invoice object.
	 *
	 * @param      Invoice $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setInvoice($v)
	{


		if ($v === null) {
			$this->setInvoiceId(NULL);
		} else {
			$this->setInvoiceId($v->getId());
		}


		$this->aInvoice = $v;
	}


	/**
	 * Get the associated Invoice object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Invoice The associated Invoice object.
	 * @throws     PropelException
	 */
	public function getInvoice($con = null)
	{
		if ($this->aInvoice === null && ($this->invoice_id !== null)) {
			// include the related Peer class
			$this->aInvoice = InvoicePeer::retrieveByPK($this->invoice_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = InvoicePeer::retrieveByPK($this->invoice_id, $con);
			   $obj->addInvoices($this);
			 */
		}
		return $this->aInvoice;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'InvoiceStatus.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseInvoiceStatus:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseInvoiceStatus::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseInvoiceStatus
