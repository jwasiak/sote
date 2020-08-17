<?php

/**
 * Base class that represents a row from the 'st_delivery_sections' table.
 *
 * 
 *
 * @package    plugins.stDeliveryPlugin.lib.model.om
 */
abstract class BaseDeliverySections extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        DeliverySectionsPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the attribute_field_id field.
	 * @var        int
	 */
	protected $attribute_field_id;


	/**
	 * The value for the delivery_id field.
	 * @var        int
	 */
	protected $delivery_id;


	/**
	 * The value for the value_from field.
	 * @var        double
	 */
	protected $value_from = 0;


	/**
	 * The value for the amount field.
	 * @var        double
	 */
	protected $amount = 0;


	/**
	 * The value for the amount_brutto field.
	 * @var        double
	 */
	protected $amount_brutto;

	/**
	 * @var        AttributeField
	 */
	protected $aAttributeField;

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
     * Get the [attribute_field_id] column value.
     * 
     * @return     int
     */
    public function getAttributeFieldId()
    {

            return $this->attribute_field_id;
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
     * Get the [value_from] column value.
     * 
     * @return     double
     */
    public function getValueFrom()
    {

            return null !== $this->value_from ? (string)$this->value_from : null;
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
     * Get the [amount_brutto] column value.
     * 
     * @return     double
     */
    public function getAmountBrutto()
    {

            return null !== $this->amount_brutto ? (string)$this->amount_brutto : null;
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
          $this->modifiedColumns[] = DeliverySectionsPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [attribute_field_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setAttributeFieldId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->attribute_field_id !== $v) {
          $this->attribute_field_id = $v;
          $this->modifiedColumns[] = DeliverySectionsPeer::ATTRIBUTE_FIELD_ID;
        }

		if ($this->aAttributeField !== null && $this->aAttributeField->getId() !== $v) {
			$this->aAttributeField = null;
		}

	} // setAttributeFieldId()

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
          $this->modifiedColumns[] = DeliverySectionsPeer::DELIVERY_ID;
        }

		if ($this->aDelivery !== null && $this->aDelivery->getId() !== $v) {
			$this->aDelivery = null;
		}

	} // setDeliveryId()

	/**
	 * Set the value of [value_from] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setValueFrom($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->value_from !== $v || $v === 0) {
          $this->value_from = $v;
          $this->modifiedColumns[] = DeliverySectionsPeer::VALUE_FROM;
        }

	} // setValueFrom()

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

        if ($this->amount !== $v || $v === 0) {
          $this->amount = $v;
          $this->modifiedColumns[] = DeliverySectionsPeer::AMOUNT;
        }

	} // setAmount()

	/**
	 * Set the value of [amount_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setAmountBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->amount_brutto !== $v) {
          $this->amount_brutto = $v;
          $this->modifiedColumns[] = DeliverySectionsPeer::AMOUNT_BRUTTO;
        }

	} // setAmountBrutto()

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
      if ($this->getDispatcher()->getListeners('DeliverySections.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'DeliverySections.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->attribute_field_id = $rs->getInt($startcol + 1);

      $this->delivery_id = $rs->getInt($startcol + 2);

      $this->value_from = $rs->getString($startcol + 3);
      if (null !== $this->value_from && $this->value_from == intval($this->value_from))
      {
        $this->value_from = (string)intval($this->value_from);
      }

      $this->amount = $rs->getString($startcol + 4);
      if (null !== $this->amount && $this->amount == intval($this->amount))
      {
        $this->amount = (string)intval($this->amount);
      }

      $this->amount_brutto = $rs->getString($startcol + 5);
      if (null !== $this->amount_brutto && $this->amount_brutto == intval($this->amount_brutto))
      {
        $this->amount_brutto = (string)intval($this->amount_brutto);
      }

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('DeliverySections.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'DeliverySections.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 6)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 6; // 6 = DeliverySectionsPeer::NUM_COLUMNS - DeliverySectionsPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating DeliverySections object", $e);
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

    if ($this->getDispatcher()->getListeners('DeliverySections.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'DeliverySections.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseDeliverySections:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseDeliverySections:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(DeliverySectionsPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      DeliverySectionsPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('DeliverySections.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'DeliverySections.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseDeliverySections:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseDeliverySections:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('DeliverySections.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'DeliverySections.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseDeliverySections:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(DeliverySectionsPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('DeliverySections.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'DeliverySections.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseDeliverySections:save:post') as $callable)
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

			if ($this->aAttributeField !== null) {
				if ($this->aAttributeField->isModified()) {
					$affectedRows += $this->aAttributeField->save($con);
				}
				$this->setAttributeField($this->aAttributeField);
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
					$pk = DeliverySectionsPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += DeliverySectionsPeer::doUpdate($this, $con);
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

			if ($this->aAttributeField !== null) {
				if (!$this->aAttributeField->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aAttributeField->getValidationFailures());
				}
			}

			if ($this->aDelivery !== null) {
				if (!$this->aDelivery->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDelivery->getValidationFailures());
				}
			}


			if (($retval = DeliverySectionsPeer::doValidate($this, $columns)) !== true) {
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
		$pos = DeliverySectionsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getAttributeFieldId();
				break;
			case 2:
				return $this->getDeliveryId();
				break;
			case 3:
				return $this->getValueFrom();
				break;
			case 4:
				return $this->getAmount();
				break;
			case 5:
				return $this->getAmountBrutto();
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
		$keys = DeliverySectionsPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getAttributeFieldId(),
			$keys[2] => $this->getDeliveryId(),
			$keys[3] => $this->getValueFrom(),
			$keys[4] => $this->getAmount(),
			$keys[5] => $this->getAmountBrutto(),
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
		$pos = DeliverySectionsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setAttributeFieldId($value);
				break;
			case 2:
				$this->setDeliveryId($value);
				break;
			case 3:
				$this->setValueFrom($value);
				break;
			case 4:
				$this->setAmount($value);
				break;
			case 5:
				$this->setAmountBrutto($value);
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
		$keys = DeliverySectionsPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setAttributeFieldId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDeliveryId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setValueFrom($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setAmount($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setAmountBrutto($arr[$keys[5]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(DeliverySectionsPeer::DATABASE_NAME);

		if ($this->isColumnModified(DeliverySectionsPeer::ID)) $criteria->add(DeliverySectionsPeer::ID, $this->id);
		if ($this->isColumnModified(DeliverySectionsPeer::ATTRIBUTE_FIELD_ID)) $criteria->add(DeliverySectionsPeer::ATTRIBUTE_FIELD_ID, $this->attribute_field_id);
		if ($this->isColumnModified(DeliverySectionsPeer::DELIVERY_ID)) $criteria->add(DeliverySectionsPeer::DELIVERY_ID, $this->delivery_id);
		if ($this->isColumnModified(DeliverySectionsPeer::VALUE_FROM)) $criteria->add(DeliverySectionsPeer::VALUE_FROM, $this->value_from);
		if ($this->isColumnModified(DeliverySectionsPeer::AMOUNT)) $criteria->add(DeliverySectionsPeer::AMOUNT, $this->amount);
		if ($this->isColumnModified(DeliverySectionsPeer::AMOUNT_BRUTTO)) $criteria->add(DeliverySectionsPeer::AMOUNT_BRUTTO, $this->amount_brutto);

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
		$criteria = new Criteria(DeliverySectionsPeer::DATABASE_NAME);

		$criteria->add(DeliverySectionsPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of DeliverySections (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setAttributeFieldId($this->attribute_field_id);

		$copyObj->setDeliveryId($this->delivery_id);

		$copyObj->setValueFrom($this->value_from);

		$copyObj->setAmount($this->amount);

		$copyObj->setAmountBrutto($this->amount_brutto);


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
	 * @return     DeliverySections Clone of current object.
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
	 * @return     DeliverySectionsPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new DeliverySectionsPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a AttributeField object.
	 *
	 * @param      AttributeField $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setAttributeField($v)
	{


		if ($v === null) {
			$this->setAttributeFieldId(NULL);
		} else {
			$this->setAttributeFieldId($v->getId());
		}


		$this->aAttributeField = $v;
	}


	/**
	 * Get the associated AttributeField object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     AttributeField The associated AttributeField object.
	 * @throws     PropelException
	 */
	public function getAttributeField($con = null)
	{
		if ($this->aAttributeField === null && ($this->attribute_field_id !== null)) {
			// include the related Peer class
			$this->aAttributeField = AttributeFieldPeer::retrieveByPK($this->attribute_field_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = AttributeFieldPeer::retrieveByPK($this->attribute_field_id, $con);
			   $obj->addAttributeFields($this);
			 */
		}
		return $this->aAttributeField;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'DeliverySections.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseDeliverySections:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseDeliverySections::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseDeliverySections
