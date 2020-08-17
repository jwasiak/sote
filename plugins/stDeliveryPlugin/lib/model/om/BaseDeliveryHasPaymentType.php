<?php

/**
 * Base class that represents a row from the 'st_delivery_has_payment_type' table.
 *
 * 
 *
 * @package    plugins.stDeliveryPlugin.lib.model.om
 */
abstract class BaseDeliveryHasPaymentType extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        DeliveryHasPaymentTypePeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the payment_type_id field.
	 * @var        int
	 */
	protected $payment_type_id;


	/**
	 * The value for the delivery_id field.
	 * @var        int
	 */
	protected $delivery_id;


	/**
	 * The value for the is_active field.
	 * @var        boolean
	 */
	protected $is_active = false;


	/**
	 * The value for the is_default field.
	 * @var        boolean
	 */
	protected $is_default = false;


	/**
	 * The value for the cost field.
	 * @var        double
	 */
	protected $cost = 0;


	/**
	 * The value for the cost_brutto field.
	 * @var        double
	 */
	protected $cost_brutto;


	/**
	 * The value for the free_from field.
	 * @var        double
	 */
	protected $free_from = 0;


	/**
	 * The value for the cost_type field.
	 * @var        string
	 */
	protected $cost_type = 'P';


	/**
	 * The value for the courier_cost field.
	 * @var        double
	 */
	protected $courier_cost;

	/**
	 * @var        PaymentType
	 */
	protected $aPaymentType;

	/**
	 * @var        Delivery
	 */
	protected $aDelivery;

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
     * Get the [payment_type_id] column value.
     * 
     * @return     int
     */
    public function getPaymentTypeId()
    {

            return $this->payment_type_id;
    }

    /**
     * Get the [delivery_id] column value.
     * 
     * @return     int
     */
    public function getDeliveryId()
    {

            return $this->delivery_id;
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
     * Get the [is_default] column value.
     * 
     * @return     boolean
     */
    public function getIsDefault()
    {

            return $this->is_default;
    }

    /**
     * Get the [cost] column value.
     * 
     * @return     double
     */
    public function getCost()
    {

            return null !== $this->cost ? (string)$this->cost : null;
    }

    /**
     * Get the [cost_brutto] column value.
     * 
     * @return     double
     */
    public function getCostBrutto()
    {

            return null !== $this->cost_brutto ? (string)$this->cost_brutto : null;
    }

    /**
     * Get the [free_from] column value.
     * 
     * @return     double
     */
    public function getFreeFrom()
    {

            return null !== $this->free_from ? (string)$this->free_from : null;
    }

    /**
     * Get the [cost_type] column value.
     * 
     * @return     string
     */
    public function getCostType()
    {

            return $this->cost_type;
    }

    /**
     * Get the [courier_cost] column value.
     * 
     * @return     double
     */
    public function getCourierCost()
    {

            return null !== $this->courier_cost ? (string)$this->courier_cost : null;
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
          $this->modifiedColumns[] = DeliveryHasPaymentTypePeer::ID;
        }

	} // setId()

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
          $this->modifiedColumns[] = DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID;
        }

		if ($this->aPaymentType !== null && $this->aPaymentType->getId() !== $v) {
			$this->aPaymentType = null;
		}

	} // setPaymentTypeId()

	/**
	 * Set the value of [delivery_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setDeliveryId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->delivery_id !== $v) {
          $this->delivery_id = $v;
          $this->modifiedColumns[] = DeliveryHasPaymentTypePeer::DELIVERY_ID;
        }

		if ($this->aDelivery !== null && $this->aDelivery->getId() !== $v) {
			$this->aDelivery = null;
		}

	} // setDeliveryId()

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

        if ($this->is_active !== $v || $v === false) {
          $this->is_active = $v;
          $this->modifiedColumns[] = DeliveryHasPaymentTypePeer::IS_ACTIVE;
        }

	} // setIsActive()

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
          $this->modifiedColumns[] = DeliveryHasPaymentTypePeer::IS_DEFAULT;
        }

	} // setIsDefault()

	/**
	 * Set the value of [cost] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setCost($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->cost !== $v || $v === 0) {
          $this->cost = $v;
          $this->modifiedColumns[] = DeliveryHasPaymentTypePeer::COST;
        }

	} // setCost()

	/**
	 * Set the value of [cost_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setCostBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->cost_brutto !== $v) {
          $this->cost_brutto = $v;
          $this->modifiedColumns[] = DeliveryHasPaymentTypePeer::COST_BRUTTO;
        }

	} // setCostBrutto()

	/**
	 * Set the value of [free_from] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setFreeFrom($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->free_from !== $v || $v === 0) {
          $this->free_from = $v;
          $this->modifiedColumns[] = DeliveryHasPaymentTypePeer::FREE_FROM;
        }

	} // setFreeFrom()

	/**
	 * Set the value of [cost_type] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCostType($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->cost_type !== $v || $v === 'P') {
          $this->cost_type = $v;
          $this->modifiedColumns[] = DeliveryHasPaymentTypePeer::COST_TYPE;
        }

	} // setCostType()

	/**
	 * Set the value of [courier_cost] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setCourierCost($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->courier_cost !== $v) {
          $this->courier_cost = $v;
          $this->modifiedColumns[] = DeliveryHasPaymentTypePeer::COURIER_COST;
        }

	} // setCourierCost()

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
      if ($this->getDispatcher()->getListeners('DeliveryHasPaymentType.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'DeliveryHasPaymentType.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->payment_type_id = $rs->getInt($startcol + 1);

      $this->delivery_id = $rs->getInt($startcol + 2);

      $this->is_active = $rs->getBoolean($startcol + 3);

      $this->is_default = $rs->getBoolean($startcol + 4);

      $this->cost = $rs->getString($startcol + 5);
      if (null !== $this->cost && $this->cost == intval($this->cost))
      {
        $this->cost = (string)intval($this->cost);
      }

      $this->cost_brutto = $rs->getString($startcol + 6);
      if (null !== $this->cost_brutto && $this->cost_brutto == intval($this->cost_brutto))
      {
        $this->cost_brutto = (string)intval($this->cost_brutto);
      }

      $this->free_from = $rs->getString($startcol + 7);
      if (null !== $this->free_from && $this->free_from == intval($this->free_from))
      {
        $this->free_from = (string)intval($this->free_from);
      }

      $this->cost_type = $rs->getString($startcol + 8);

      $this->courier_cost = $rs->getString($startcol + 9);
      if (null !== $this->courier_cost && $this->courier_cost == intval($this->courier_cost))
      {
        $this->courier_cost = (string)intval($this->courier_cost);
      }

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('DeliveryHasPaymentType.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'DeliveryHasPaymentType.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 10)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 10; // 10 = DeliveryHasPaymentTypePeer::NUM_COLUMNS - DeliveryHasPaymentTypePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating DeliveryHasPaymentType object", $e);
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

    if ($this->getDispatcher()->getListeners('DeliveryHasPaymentType.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'DeliveryHasPaymentType.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseDeliveryHasPaymentType:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseDeliveryHasPaymentType:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(DeliveryHasPaymentTypePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      DeliveryHasPaymentTypePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('DeliveryHasPaymentType.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'DeliveryHasPaymentType.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseDeliveryHasPaymentType:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseDeliveryHasPaymentType:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('DeliveryHasPaymentType.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'DeliveryHasPaymentType.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseDeliveryHasPaymentType:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(DeliveryHasPaymentTypePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('DeliveryHasPaymentType.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'DeliveryHasPaymentType.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseDeliveryHasPaymentType:save:post') as $callable)
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

			if ($this->aPaymentType !== null) {
				if ($this->aPaymentType->isModified() || $this->aPaymentType->getCurrentPaymentTypeI18n()->isModified()) {
					$affectedRows += $this->aPaymentType->save($con);
				}
				$this->setPaymentType($this->aPaymentType);
			}

			if ($this->aDelivery !== null) {
				if ($this->aDelivery->isModified() || $this->aDelivery->getCurrentDeliveryI18n()->isModified()) {
					$affectedRows += $this->aDelivery->save($con);
				}
				$this->setDelivery($this->aDelivery);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = DeliveryHasPaymentTypePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += DeliveryHasPaymentTypePeer::doUpdate($this, $con);
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

			if ($this->aPaymentType !== null) {
				if (!$this->aPaymentType->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPaymentType->getValidationFailures());
				}
			}

			if ($this->aDelivery !== null) {
				if (!$this->aDelivery->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDelivery->getValidationFailures());
				}
			}


			if (($retval = DeliveryHasPaymentTypePeer::doValidate($this, $columns)) !== true) {
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
		$pos = DeliveryHasPaymentTypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getPaymentTypeId();
				break;
			case 2:
				return $this->getDeliveryId();
				break;
			case 3:
				return $this->getIsActive();
				break;
			case 4:
				return $this->getIsDefault();
				break;
			case 5:
				return $this->getCost();
				break;
			case 6:
				return $this->getCostBrutto();
				break;
			case 7:
				return $this->getFreeFrom();
				break;
			case 8:
				return $this->getCostType();
				break;
			case 9:
				return $this->getCourierCost();
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
		$keys = DeliveryHasPaymentTypePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getPaymentTypeId(),
			$keys[2] => $this->getDeliveryId(),
			$keys[3] => $this->getIsActive(),
			$keys[4] => $this->getIsDefault(),
			$keys[5] => $this->getCost(),
			$keys[6] => $this->getCostBrutto(),
			$keys[7] => $this->getFreeFrom(),
			$keys[8] => $this->getCostType(),
			$keys[9] => $this->getCourierCost(),
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
		$pos = DeliveryHasPaymentTypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setPaymentTypeId($value);
				break;
			case 2:
				$this->setDeliveryId($value);
				break;
			case 3:
				$this->setIsActive($value);
				break;
			case 4:
				$this->setIsDefault($value);
				break;
			case 5:
				$this->setCost($value);
				break;
			case 6:
				$this->setCostBrutto($value);
				break;
			case 7:
				$this->setFreeFrom($value);
				break;
			case 8:
				$this->setCostType($value);
				break;
			case 9:
				$this->setCourierCost($value);
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
		$keys = DeliveryHasPaymentTypePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPaymentTypeId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDeliveryId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setIsActive($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setIsDefault($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCost($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCostBrutto($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setFreeFrom($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCostType($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setCourierCost($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(DeliveryHasPaymentTypePeer::DATABASE_NAME);

		if ($this->isColumnModified(DeliveryHasPaymentTypePeer::ID)) $criteria->add(DeliveryHasPaymentTypePeer::ID, $this->id);
		if ($this->isColumnModified(DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID)) $criteria->add(DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID, $this->payment_type_id);
		if ($this->isColumnModified(DeliveryHasPaymentTypePeer::DELIVERY_ID)) $criteria->add(DeliveryHasPaymentTypePeer::DELIVERY_ID, $this->delivery_id);
		if ($this->isColumnModified(DeliveryHasPaymentTypePeer::IS_ACTIVE)) $criteria->add(DeliveryHasPaymentTypePeer::IS_ACTIVE, $this->is_active);
		if ($this->isColumnModified(DeliveryHasPaymentTypePeer::IS_DEFAULT)) $criteria->add(DeliveryHasPaymentTypePeer::IS_DEFAULT, $this->is_default);
		if ($this->isColumnModified(DeliveryHasPaymentTypePeer::COST)) $criteria->add(DeliveryHasPaymentTypePeer::COST, $this->cost);
		if ($this->isColumnModified(DeliveryHasPaymentTypePeer::COST_BRUTTO)) $criteria->add(DeliveryHasPaymentTypePeer::COST_BRUTTO, $this->cost_brutto);
		if ($this->isColumnModified(DeliveryHasPaymentTypePeer::FREE_FROM)) $criteria->add(DeliveryHasPaymentTypePeer::FREE_FROM, $this->free_from);
		if ($this->isColumnModified(DeliveryHasPaymentTypePeer::COST_TYPE)) $criteria->add(DeliveryHasPaymentTypePeer::COST_TYPE, $this->cost_type);
		if ($this->isColumnModified(DeliveryHasPaymentTypePeer::COURIER_COST)) $criteria->add(DeliveryHasPaymentTypePeer::COURIER_COST, $this->courier_cost);

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
		$criteria = new Criteria(DeliveryHasPaymentTypePeer::DATABASE_NAME);

		$criteria->add(DeliveryHasPaymentTypePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of DeliveryHasPaymentType (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setPaymentTypeId($this->payment_type_id);

		$copyObj->setDeliveryId($this->delivery_id);

		$copyObj->setIsActive($this->is_active);

		$copyObj->setIsDefault($this->is_default);

		$copyObj->setCost($this->cost);

		$copyObj->setCostBrutto($this->cost_brutto);

		$copyObj->setFreeFrom($this->free_from);

		$copyObj->setCostType($this->cost_type);

		$copyObj->setCourierCost($this->courier_cost);


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
	 * @return     DeliveryHasPaymentType Clone of current object.
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
	 * @return     DeliveryHasPaymentTypePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new DeliveryHasPaymentTypePeer();
		}
		return self::$peer;
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

	/**
	 * Declares an association between this object and a Delivery object.
	 *
	 * @param      Delivery $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setDelivery($v)
	{


		if ($v === null) {
			$this->setDeliveryId(NULL);
		} else {
			$this->setDeliveryId($v->getId());
		}


		$this->aDelivery = $v;
	}


	/**
	 * Get the associated Delivery object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Delivery The associated Delivery object.
	 * @throws     PropelException
	 */
	public function getDelivery($con = null)
	{
		if ($this->aDelivery === null && ($this->delivery_id !== null)) {
			// include the related Peer class
			$this->aDelivery = DeliveryPeer::retrieveByPK($this->delivery_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = DeliveryPeer::retrieveByPK($this->delivery_id, $con);
			   $obj->addDeliverys($this);
			 */
		}
		return $this->aDelivery;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'DeliveryHasPaymentType.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseDeliveryHasPaymentType:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseDeliveryHasPaymentType::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseDeliveryHasPaymentType
