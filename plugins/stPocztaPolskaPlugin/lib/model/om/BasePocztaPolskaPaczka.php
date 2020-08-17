<?php

/**
 * Base class that represents a row from the 'st_poczta_polska_paczka' table.
 *
 * 
 *
 * @package    plugins.stPocztaPolskaPlugin.lib.model.om
 */
abstract class BasePocztaPolskaPaczka extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PocztaPolskaPaczkaPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the order_id field.
	 * @var        int
	 */
	protected $order_id;


	/**
	 * The value for the guid field.
	 * @var        string
	 */
	protected $guid;


	/**
	 * The value for the numer_nadania field.
	 * @var        string
	 */
	protected $numer_nadania;


	/**
	 * The value for the envelope_id field.
	 * @var        int
	 */
	protected $envelope_id;


	/**
	 * The value for the bufor_id field.
	 * @var        int
	 */
	protected $bufor_id;


	/**
	 * The value for the parameters field.
	 * @var        string
	 */
	protected $parameters;

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
     * Get the [id] column value.
     * 
     * @return     int
     */
    public function getId()
    {

            return $this->id;
    }

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
     * Get the [guid] column value.
     * 
     * @return     string
     */
    public function getGuid()
    {

            return $this->guid;
    }

    /**
     * Get the [numer_nadania] column value.
     * 
     * @return     string
     */
    public function getNumerNadania()
    {

            return $this->numer_nadania;
    }

    /**
     * Get the [envelope_id] column value.
     * 
     * @return     int
     */
    public function getEnvelopeId()
    {

            return $this->envelope_id;
    }

    /**
     * Get the [bufor_id] column value.
     * 
     * @return     int
     */
    public function getBuforId()
    {

            return $this->bufor_id;
    }

    /**
     * Get the [parameters] column value.
     * 
     * @return     string
     */
    public function getParameters()
    {

            return $this->parameters;
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
          $this->modifiedColumns[] = PocztaPolskaPaczkaPeer::ID;
        }

	} // setId()

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
          $this->modifiedColumns[] = PocztaPolskaPaczkaPeer::ORDER_ID;
        }

		if ($this->aOrder !== null && $this->aOrder->getId() !== $v) {
			$this->aOrder = null;
		}

	} // setOrderId()

	/**
	 * Set the value of [guid] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setGuid($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->guid !== $v) {
          $this->guid = $v;
          $this->modifiedColumns[] = PocztaPolskaPaczkaPeer::GUID;
        }

	} // setGuid()

	/**
	 * Set the value of [numer_nadania] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setNumerNadania($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->numer_nadania !== $v) {
          $this->numer_nadania = $v;
          $this->modifiedColumns[] = PocztaPolskaPaczkaPeer::NUMER_NADANIA;
        }

	} // setNumerNadania()

	/**
	 * Set the value of [envelope_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setEnvelopeId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->envelope_id !== $v) {
          $this->envelope_id = $v;
          $this->modifiedColumns[] = PocztaPolskaPaczkaPeer::ENVELOPE_ID;
        }

	} // setEnvelopeId()

	/**
	 * Set the value of [bufor_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setBuforId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->bufor_id !== $v) {
          $this->bufor_id = $v;
          $this->modifiedColumns[] = PocztaPolskaPaczkaPeer::BUFOR_ID;
        }

	} // setBuforId()

	/**
	 * Set the value of [parameters] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setParameters($v)
	{

        if ($this->parameters !== $v) {
          $this->parameters = $v;
          $this->modifiedColumns[] = PocztaPolskaPaczkaPeer::PARAMETERS;
        }

	} // setParameters()

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
      if ($this->getDispatcher()->getListeners('PocztaPolskaPaczka.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'PocztaPolskaPaczka.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->order_id = $rs->getInt($startcol + 1);

      $this->guid = $rs->getString($startcol + 2);

      $this->numer_nadania = $rs->getString($startcol + 3);

      $this->envelope_id = $rs->getInt($startcol + 4);

      $this->bufor_id = $rs->getInt($startcol + 5);

      $this->parameters = $rs->getString($startcol + 6) ? unserialize($rs->getString($startcol + 6)) : null;

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('PocztaPolskaPaczka.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'PocztaPolskaPaczka.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 7)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 7; // 7 = PocztaPolskaPaczkaPeer::NUM_COLUMNS - PocztaPolskaPaczkaPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating PocztaPolskaPaczka object", $e);
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

    if ($this->getDispatcher()->getListeners('PocztaPolskaPaczka.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'PocztaPolskaPaczka.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePocztaPolskaPaczka:delete:pre'))
    {
      foreach (sfMixer::getCallables('BasePocztaPolskaPaczka:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(PocztaPolskaPaczkaPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      PocztaPolskaPaczkaPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('PocztaPolskaPaczka.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'PocztaPolskaPaczka.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePocztaPolskaPaczka:delete:post'))
    {
      foreach (sfMixer::getCallables('BasePocztaPolskaPaczka:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('PocztaPolskaPaczka.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'PocztaPolskaPaczka.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BasePocztaPolskaPaczka:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(PocztaPolskaPaczkaPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('PocztaPolskaPaczka.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'PocztaPolskaPaczka.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BasePocztaPolskaPaczka:save:post') as $callable)
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
              $o_parameters = $this->parameters;
              if (null !== $this->parameters && $this->isColumnModified(PocztaPolskaPaczkaPeer::PARAMETERS)) {
                  $this->parameters = serialize($this->parameters);
              }

				if ($this->isNew()) {
					$pk = PocztaPolskaPaczkaPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PocztaPolskaPaczkaPeer::doUpdate($this, $con);
				}
				$this->resetModified();
             $this->parameters = $o_parameters;
 // [HL] After being saved an object is no longer 'modified'
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


			if (($retval = PocztaPolskaPaczkaPeer::doValidate($this, $columns)) !== true) {
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
		$pos = PocztaPolskaPaczkaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getOrderId();
				break;
			case 2:
				return $this->getGuid();
				break;
			case 3:
				return $this->getNumerNadania();
				break;
			case 4:
				return $this->getEnvelopeId();
				break;
			case 5:
				return $this->getBuforId();
				break;
			case 6:
				return $this->getParameters();
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
		$keys = PocztaPolskaPaczkaPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getOrderId(),
			$keys[2] => $this->getGuid(),
			$keys[3] => $this->getNumerNadania(),
			$keys[4] => $this->getEnvelopeId(),
			$keys[5] => $this->getBuforId(),
			$keys[6] => $this->getParameters(),
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
		$pos = PocztaPolskaPaczkaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setOrderId($value);
				break;
			case 2:
				$this->setGuid($value);
				break;
			case 3:
				$this->setNumerNadania($value);
				break;
			case 4:
				$this->setEnvelopeId($value);
				break;
			case 5:
				$this->setBuforId($value);
				break;
			case 6:
				$this->setParameters($value);
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
		$keys = PocztaPolskaPaczkaPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setOrderId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setGuid($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setNumerNadania($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setEnvelopeId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setBuforId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setParameters($arr[$keys[6]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PocztaPolskaPaczkaPeer::DATABASE_NAME);

		if ($this->isColumnModified(PocztaPolskaPaczkaPeer::ID)) $criteria->add(PocztaPolskaPaczkaPeer::ID, $this->id);
		if ($this->isColumnModified(PocztaPolskaPaczkaPeer::ORDER_ID)) $criteria->add(PocztaPolskaPaczkaPeer::ORDER_ID, $this->order_id);
		if ($this->isColumnModified(PocztaPolskaPaczkaPeer::GUID)) $criteria->add(PocztaPolskaPaczkaPeer::GUID, $this->guid);
		if ($this->isColumnModified(PocztaPolskaPaczkaPeer::NUMER_NADANIA)) $criteria->add(PocztaPolskaPaczkaPeer::NUMER_NADANIA, $this->numer_nadania);
		if ($this->isColumnModified(PocztaPolskaPaczkaPeer::ENVELOPE_ID)) $criteria->add(PocztaPolskaPaczkaPeer::ENVELOPE_ID, $this->envelope_id);
		if ($this->isColumnModified(PocztaPolskaPaczkaPeer::BUFOR_ID)) $criteria->add(PocztaPolskaPaczkaPeer::BUFOR_ID, $this->bufor_id);
		if ($this->isColumnModified(PocztaPolskaPaczkaPeer::PARAMETERS)) $criteria->add(PocztaPolskaPaczkaPeer::PARAMETERS, $this->parameters);

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
		$criteria = new Criteria(PocztaPolskaPaczkaPeer::DATABASE_NAME);

		$criteria->add(PocztaPolskaPaczkaPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of PocztaPolskaPaczka (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setOrderId($this->order_id);

		$copyObj->setGuid($this->guid);

		$copyObj->setNumerNadania($this->numer_nadania);

		$copyObj->setEnvelopeId($this->envelope_id);

		$copyObj->setBuforId($this->bufor_id);

		$copyObj->setParameters($this->parameters);


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
	 * @return     PocztaPolskaPaczka Clone of current object.
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
	 * @return     PocztaPolskaPaczkaPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PocztaPolskaPaczkaPeer();
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'PocztaPolskaPaczka.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BasePocztaPolskaPaczka:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BasePocztaPolskaPaczka::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BasePocztaPolskaPaczka
