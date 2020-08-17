<?php

/**
 * Base class that represents a row from the 'st_basic_price_unit_measure' table.
 *
 * 
 *
 * @package    plugins.stBasicPricePlugin.lib.model.om
 */
abstract class BaseBasicPriceUnitMeasure extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        BasicPriceUnitMeasurePeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the is_default field.
	 * @var        boolean
	 */
	protected $is_default = false;


	/**
	 * The value for the is_system field.
	 * @var        boolean
	 */
	protected $is_system = true;


	/**
	 * The value for the unit_name field.
	 * @var        string
	 */
	protected $unit_name;


	/**
	 * The value for the unit_symbol field.
	 * @var        string
	 */
	protected $unit_symbol;


	/**
	 * The value for the unit_group field.
	 * @var        string
	 */
	protected $unit_group;


	/**
	 * The value for the multiplier field.
	 * @var        double
	 */
	protected $multiplier;

	/**
	 * Collection to store aggregation of collProductsRelatedByBpumDefaultId.
	 * @var        array
	 */
	protected $collProductsRelatedByBpumDefaultId;

	/**
	 * The criteria used to select the current contents of collProductsRelatedByBpumDefaultId.
	 * @var        Criteria
	 */
	protected $lastProductRelatedByBpumDefaultIdCriteria = null;

	/**
	 * Collection to store aggregation of collProductsRelatedByBpumId.
	 * @var        array
	 */
	protected $collProductsRelatedByBpumId;

	/**
	 * The criteria used to select the current contents of collProductsRelatedByBpumId.
	 * @var        Criteria
	 */
	protected $lastProductRelatedByBpumIdCriteria = null;

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
     * Get the [is_default] column value.
     * 
     * @return     boolean
     */
    public function getIsDefault()
    {

            return $this->is_default;
    }

    /**
     * Get the [is_system] column value.
     * 
     * @return     boolean
     */
    public function getIsSystem()
    {

            return $this->is_system;
    }

    /**
     * Get the [unit_name] column value.
     * 
     * @return     string
     */
    public function getUnitName()
    {

            return $this->unit_name;
    }

    /**
     * Get the [unit_symbol] column value.
     * 
     * @return     string
     */
    public function getUnitSymbol()
    {

            return $this->unit_symbol;
    }

    /**
     * Get the [unit_group] column value.
     * 
     * @return     string
     */
    public function getUnitGroup()
    {

            return $this->unit_group;
    }

    /**
     * Get the [multiplier] column value.
     * 
     * @return     double
     */
    public function getMultiplier()
    {

            return null !== $this->multiplier ? (string)$this->multiplier : null;
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
          $this->modifiedColumns[] = BasicPriceUnitMeasurePeer::ID;
        }

	} // setId()

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
          $this->modifiedColumns[] = BasicPriceUnitMeasurePeer::IS_DEFAULT;
        }

	} // setIsDefault()

	/**
	 * Set the value of [is_system] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsSystem($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_system !== $v || $v === true) {
          $this->is_system = $v;
          $this->modifiedColumns[] = BasicPriceUnitMeasurePeer::IS_SYSTEM;
        }

	} // setIsSystem()

	/**
	 * Set the value of [unit_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUnitName($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->unit_name !== $v) {
          $this->unit_name = $v;
          $this->modifiedColumns[] = BasicPriceUnitMeasurePeer::UNIT_NAME;
        }

	} // setUnitName()

	/**
	 * Set the value of [unit_symbol] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUnitSymbol($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->unit_symbol !== $v) {
          $this->unit_symbol = $v;
          $this->modifiedColumns[] = BasicPriceUnitMeasurePeer::UNIT_SYMBOL;
        }

	} // setUnitSymbol()

	/**
	 * Set the value of [unit_group] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUnitGroup($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->unit_group !== $v) {
          $this->unit_group = $v;
          $this->modifiedColumns[] = BasicPriceUnitMeasurePeer::UNIT_GROUP;
        }

	} // setUnitGroup()

	/**
	 * Set the value of [multiplier] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setMultiplier($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->multiplier !== $v) {
          $this->multiplier = $v;
          $this->modifiedColumns[] = BasicPriceUnitMeasurePeer::MULTIPLIER;
        }

	} // setMultiplier()

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
      if ($this->getDispatcher()->getListeners('BasicPriceUnitMeasure.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'BasicPriceUnitMeasure.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->is_default = $rs->getBoolean($startcol + 1);

      $this->is_system = $rs->getBoolean($startcol + 2);

      $this->unit_name = $rs->getString($startcol + 3);

      $this->unit_symbol = $rs->getString($startcol + 4);

      $this->unit_group = $rs->getString($startcol + 5);

      $this->multiplier = $rs->getString($startcol + 6);
      if (null !== $this->multiplier && $this->multiplier == intval($this->multiplier))
      {
        $this->multiplier = (string)intval($this->multiplier);
      }

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('BasicPriceUnitMeasure.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'BasicPriceUnitMeasure.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 7)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 7; // 7 = BasicPriceUnitMeasurePeer::NUM_COLUMNS - BasicPriceUnitMeasurePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating BasicPriceUnitMeasure object", $e);
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

    if ($this->getDispatcher()->getListeners('BasicPriceUnitMeasure.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'BasicPriceUnitMeasure.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseBasicPriceUnitMeasure:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseBasicPriceUnitMeasure:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(BasicPriceUnitMeasurePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      BasicPriceUnitMeasurePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('BasicPriceUnitMeasure.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'BasicPriceUnitMeasure.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseBasicPriceUnitMeasure:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseBasicPriceUnitMeasure:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('BasicPriceUnitMeasure.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'BasicPriceUnitMeasure.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseBasicPriceUnitMeasure:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(BasicPriceUnitMeasurePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('BasicPriceUnitMeasure.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'BasicPriceUnitMeasure.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseBasicPriceUnitMeasure:save:post') as $callable)
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
					$pk = BasicPriceUnitMeasurePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += BasicPriceUnitMeasurePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collProductsRelatedByBpumDefaultId !== null) {
				foreach($this->collProductsRelatedByBpumDefaultId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductsRelatedByBpumId !== null) {
				foreach($this->collProductsRelatedByBpumId as $referrerFK) {
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


			if (($retval = BasicPriceUnitMeasurePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collProductsRelatedByBpumDefaultId !== null) {
					foreach($this->collProductsRelatedByBpumDefaultId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductsRelatedByBpumId !== null) {
					foreach($this->collProductsRelatedByBpumId as $referrerFK) {
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
		$pos = BasicPriceUnitMeasurePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getIsDefault();
				break;
			case 2:
				return $this->getIsSystem();
				break;
			case 3:
				return $this->getUnitName();
				break;
			case 4:
				return $this->getUnitSymbol();
				break;
			case 5:
				return $this->getUnitGroup();
				break;
			case 6:
				return $this->getMultiplier();
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
		$keys = BasicPriceUnitMeasurePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getIsDefault(),
			$keys[2] => $this->getIsSystem(),
			$keys[3] => $this->getUnitName(),
			$keys[4] => $this->getUnitSymbol(),
			$keys[5] => $this->getUnitGroup(),
			$keys[6] => $this->getMultiplier(),
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
		$pos = BasicPriceUnitMeasurePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setIsDefault($value);
				break;
			case 2:
				$this->setIsSystem($value);
				break;
			case 3:
				$this->setUnitName($value);
				break;
			case 4:
				$this->setUnitSymbol($value);
				break;
			case 5:
				$this->setUnitGroup($value);
				break;
			case 6:
				$this->setMultiplier($value);
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
		$keys = BasicPriceUnitMeasurePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setIsDefault($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIsSystem($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setUnitName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setUnitSymbol($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setUnitGroup($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setMultiplier($arr[$keys[6]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(BasicPriceUnitMeasurePeer::DATABASE_NAME);

		if ($this->isColumnModified(BasicPriceUnitMeasurePeer::ID)) $criteria->add(BasicPriceUnitMeasurePeer::ID, $this->id);
		if ($this->isColumnModified(BasicPriceUnitMeasurePeer::IS_DEFAULT)) $criteria->add(BasicPriceUnitMeasurePeer::IS_DEFAULT, $this->is_default);
		if ($this->isColumnModified(BasicPriceUnitMeasurePeer::IS_SYSTEM)) $criteria->add(BasicPriceUnitMeasurePeer::IS_SYSTEM, $this->is_system);
		if ($this->isColumnModified(BasicPriceUnitMeasurePeer::UNIT_NAME)) $criteria->add(BasicPriceUnitMeasurePeer::UNIT_NAME, $this->unit_name);
		if ($this->isColumnModified(BasicPriceUnitMeasurePeer::UNIT_SYMBOL)) $criteria->add(BasicPriceUnitMeasurePeer::UNIT_SYMBOL, $this->unit_symbol);
		if ($this->isColumnModified(BasicPriceUnitMeasurePeer::UNIT_GROUP)) $criteria->add(BasicPriceUnitMeasurePeer::UNIT_GROUP, $this->unit_group);
		if ($this->isColumnModified(BasicPriceUnitMeasurePeer::MULTIPLIER)) $criteria->add(BasicPriceUnitMeasurePeer::MULTIPLIER, $this->multiplier);

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
		$criteria = new Criteria(BasicPriceUnitMeasurePeer::DATABASE_NAME);

		$criteria->add(BasicPriceUnitMeasurePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of BasicPriceUnitMeasure (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setIsDefault($this->is_default);

		$copyObj->setIsSystem($this->is_system);

		$copyObj->setUnitName($this->unit_name);

		$copyObj->setUnitSymbol($this->unit_symbol);

		$copyObj->setUnitGroup($this->unit_group);

		$copyObj->setMultiplier($this->multiplier);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getProductsRelatedByBpumDefaultId() as $relObj) {
				$copyObj->addProductRelatedByBpumDefaultId($relObj->copy($deepCopy));
			}

			foreach($this->getProductsRelatedByBpumId() as $relObj) {
				$copyObj->addProductRelatedByBpumId($relObj->copy($deepCopy));
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
	 * @return     BasicPriceUnitMeasure Clone of current object.
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
	 * @return     BasicPriceUnitMeasurePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new BasicPriceUnitMeasurePeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collProductsRelatedByBpumDefaultId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductsRelatedByBpumDefaultId()
	{
		if ($this->collProductsRelatedByBpumDefaultId === null) {
			$this->collProductsRelatedByBpumDefaultId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumDefaultId from storage.
	 * If this BasicPriceUnitMeasure is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductsRelatedByBpumDefaultId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumDefaultId === null) {
			if ($this->isNew()) {
			   $this->collProductsRelatedByBpumDefaultId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

				ProductPeer::addSelectColumns($criteria);
				$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

				ProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductRelatedByBpumDefaultIdCriteria) || !$this->lastProductRelatedByBpumDefaultIdCriteria->equals($criteria)) {
					$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductRelatedByBpumDefaultIdCriteria = $criteria;
		return $this->collProductsRelatedByBpumDefaultId;
	}

	/**
	 * Returns the number of related ProductsRelatedByBpumDefaultId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductsRelatedByBpumDefaultId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

		return ProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Product object to this object
	 * through the Product foreign key attribute
	 *
	 * @param      Product $l Product
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductRelatedByBpumDefaultId(Product $l)
	{
		$this->collProductsRelatedByBpumDefaultId[] = $l;
		$l->setBasicPriceUnitMeasureRelatedByBpumDefaultId($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure is new, it will return
	 * an empty collection; or if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumDefaultId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BasicPriceUnitMeasure.
	 */
	public function getProductsRelatedByBpumDefaultIdJoinProductRelatedByParentId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumDefaultId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByBpumDefaultId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

				$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelectJoinProductRelatedByParentId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

			if (!isset($this->lastProductRelatedByBpumDefaultIdCriteria) || !$this->lastProductRelatedByBpumDefaultIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelectJoinProductRelatedByParentId($criteria, $con);
			}
		}
		$this->lastProductRelatedByBpumDefaultIdCriteria = $criteria;

		return $this->collProductsRelatedByBpumDefaultId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure is new, it will return
	 * an empty collection; or if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumDefaultId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BasicPriceUnitMeasure.
	 */
	public function getProductsRelatedByBpumDefaultIdJoinCurrency($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumDefaultId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByBpumDefaultId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

				$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelectJoinCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

			if (!isset($this->lastProductRelatedByBpumDefaultIdCriteria) || !$this->lastProductRelatedByBpumDefaultIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelectJoinCurrency($criteria, $con);
			}
		}
		$this->lastProductRelatedByBpumDefaultIdCriteria = $criteria;

		return $this->collProductsRelatedByBpumDefaultId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure is new, it will return
	 * an empty collection; or if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumDefaultId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BasicPriceUnitMeasure.
	 */
	public function getProductsRelatedByBpumDefaultIdJoinProducer($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumDefaultId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByBpumDefaultId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

				$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelectJoinProducer($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

			if (!isset($this->lastProductRelatedByBpumDefaultIdCriteria) || !$this->lastProductRelatedByBpumDefaultIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelectJoinProducer($criteria, $con);
			}
		}
		$this->lastProductRelatedByBpumDefaultIdCriteria = $criteria;

		return $this->collProductsRelatedByBpumDefaultId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure is new, it will return
	 * an empty collection; or if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumDefaultId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BasicPriceUnitMeasure.
	 */
	public function getProductsRelatedByBpumDefaultIdJoinProductDimension($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumDefaultId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByBpumDefaultId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

				$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelectJoinProductDimension($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

			if (!isset($this->lastProductRelatedByBpumDefaultIdCriteria) || !$this->lastProductRelatedByBpumDefaultIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelectJoinProductDimension($criteria, $con);
			}
		}
		$this->lastProductRelatedByBpumDefaultIdCriteria = $criteria;

		return $this->collProductsRelatedByBpumDefaultId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure is new, it will return
	 * an empty collection; or if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumDefaultId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BasicPriceUnitMeasure.
	 */
	public function getProductsRelatedByBpumDefaultIdJoinAvailability($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumDefaultId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByBpumDefaultId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

				$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelectJoinAvailability($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

			if (!isset($this->lastProductRelatedByBpumDefaultIdCriteria) || !$this->lastProductRelatedByBpumDefaultIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelectJoinAvailability($criteria, $con);
			}
		}
		$this->lastProductRelatedByBpumDefaultIdCriteria = $criteria;

		return $this->collProductsRelatedByBpumDefaultId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure is new, it will return
	 * an empty collection; or if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumDefaultId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BasicPriceUnitMeasure.
	 */
	public function getProductsRelatedByBpumDefaultIdJoinGroupPrice($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumDefaultId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByBpumDefaultId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

				$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelectJoinGroupPrice($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

			if (!isset($this->lastProductRelatedByBpumDefaultIdCriteria) || !$this->lastProductRelatedByBpumDefaultIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelectJoinGroupPrice($criteria, $con);
			}
		}
		$this->lastProductRelatedByBpumDefaultIdCriteria = $criteria;

		return $this->collProductsRelatedByBpumDefaultId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure is new, it will return
	 * an empty collection; or if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumDefaultId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BasicPriceUnitMeasure.
	 */
	public function getProductsRelatedByBpumDefaultIdJoinTax($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumDefaultId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByBpumDefaultId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

				$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelectJoinTax($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->getId());

			if (!isset($this->lastProductRelatedByBpumDefaultIdCriteria) || !$this->lastProductRelatedByBpumDefaultIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByBpumDefaultId = ProductPeer::doSelectJoinTax($criteria, $con);
			}
		}
		$this->lastProductRelatedByBpumDefaultIdCriteria = $criteria;

		return $this->collProductsRelatedByBpumDefaultId;
	}

	/**
	 * Temporary storage of collProductsRelatedByBpumId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductsRelatedByBpumId()
	{
		if ($this->collProductsRelatedByBpumId === null) {
			$this->collProductsRelatedByBpumId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumId from storage.
	 * If this BasicPriceUnitMeasure is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductsRelatedByBpumId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumId === null) {
			if ($this->isNew()) {
			   $this->collProductsRelatedByBpumId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_ID, $this->getId());

				ProductPeer::addSelectColumns($criteria);
				$this->collProductsRelatedByBpumId = ProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductPeer::BPUM_ID, $this->getId());

				ProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductRelatedByBpumIdCriteria) || !$this->lastProductRelatedByBpumIdCriteria->equals($criteria)) {
					$this->collProductsRelatedByBpumId = ProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductRelatedByBpumIdCriteria = $criteria;
		return $this->collProductsRelatedByBpumId;
	}

	/**
	 * Returns the number of related ProductsRelatedByBpumId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductsRelatedByBpumId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductPeer::BPUM_ID, $this->getId());

		return ProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Product object to this object
	 * through the Product foreign key attribute
	 *
	 * @param      Product $l Product
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductRelatedByBpumId(Product $l)
	{
		$this->collProductsRelatedByBpumId[] = $l;
		$l->setBasicPriceUnitMeasureRelatedByBpumId($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure is new, it will return
	 * an empty collection; or if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BasicPriceUnitMeasure.
	 */
	public function getProductsRelatedByBpumIdJoinProductRelatedByParentId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByBpumId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_ID, $this->getId());

				$this->collProductsRelatedByBpumId = ProductPeer::doSelectJoinProductRelatedByParentId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::BPUM_ID, $this->getId());

			if (!isset($this->lastProductRelatedByBpumIdCriteria) || !$this->lastProductRelatedByBpumIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByBpumId = ProductPeer::doSelectJoinProductRelatedByParentId($criteria, $con);
			}
		}
		$this->lastProductRelatedByBpumIdCriteria = $criteria;

		return $this->collProductsRelatedByBpumId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure is new, it will return
	 * an empty collection; or if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BasicPriceUnitMeasure.
	 */
	public function getProductsRelatedByBpumIdJoinCurrency($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByBpumId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_ID, $this->getId());

				$this->collProductsRelatedByBpumId = ProductPeer::doSelectJoinCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::BPUM_ID, $this->getId());

			if (!isset($this->lastProductRelatedByBpumIdCriteria) || !$this->lastProductRelatedByBpumIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByBpumId = ProductPeer::doSelectJoinCurrency($criteria, $con);
			}
		}
		$this->lastProductRelatedByBpumIdCriteria = $criteria;

		return $this->collProductsRelatedByBpumId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure is new, it will return
	 * an empty collection; or if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BasicPriceUnitMeasure.
	 */
	public function getProductsRelatedByBpumIdJoinProducer($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByBpumId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_ID, $this->getId());

				$this->collProductsRelatedByBpumId = ProductPeer::doSelectJoinProducer($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::BPUM_ID, $this->getId());

			if (!isset($this->lastProductRelatedByBpumIdCriteria) || !$this->lastProductRelatedByBpumIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByBpumId = ProductPeer::doSelectJoinProducer($criteria, $con);
			}
		}
		$this->lastProductRelatedByBpumIdCriteria = $criteria;

		return $this->collProductsRelatedByBpumId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure is new, it will return
	 * an empty collection; or if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BasicPriceUnitMeasure.
	 */
	public function getProductsRelatedByBpumIdJoinProductDimension($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByBpumId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_ID, $this->getId());

				$this->collProductsRelatedByBpumId = ProductPeer::doSelectJoinProductDimension($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::BPUM_ID, $this->getId());

			if (!isset($this->lastProductRelatedByBpumIdCriteria) || !$this->lastProductRelatedByBpumIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByBpumId = ProductPeer::doSelectJoinProductDimension($criteria, $con);
			}
		}
		$this->lastProductRelatedByBpumIdCriteria = $criteria;

		return $this->collProductsRelatedByBpumId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure is new, it will return
	 * an empty collection; or if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BasicPriceUnitMeasure.
	 */
	public function getProductsRelatedByBpumIdJoinAvailability($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByBpumId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_ID, $this->getId());

				$this->collProductsRelatedByBpumId = ProductPeer::doSelectJoinAvailability($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::BPUM_ID, $this->getId());

			if (!isset($this->lastProductRelatedByBpumIdCriteria) || !$this->lastProductRelatedByBpumIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByBpumId = ProductPeer::doSelectJoinAvailability($criteria, $con);
			}
		}
		$this->lastProductRelatedByBpumIdCriteria = $criteria;

		return $this->collProductsRelatedByBpumId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure is new, it will return
	 * an empty collection; or if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BasicPriceUnitMeasure.
	 */
	public function getProductsRelatedByBpumIdJoinGroupPrice($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByBpumId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_ID, $this->getId());

				$this->collProductsRelatedByBpumId = ProductPeer::doSelectJoinGroupPrice($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::BPUM_ID, $this->getId());

			if (!isset($this->lastProductRelatedByBpumIdCriteria) || !$this->lastProductRelatedByBpumIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByBpumId = ProductPeer::doSelectJoinGroupPrice($criteria, $con);
			}
		}
		$this->lastProductRelatedByBpumIdCriteria = $criteria;

		return $this->collProductsRelatedByBpumId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BasicPriceUnitMeasure is new, it will return
	 * an empty collection; or if this BasicPriceUnitMeasure has previously
	 * been saved, it will retrieve related ProductsRelatedByBpumId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BasicPriceUnitMeasure.
	 */
	public function getProductsRelatedByBpumIdJoinTax($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByBpumId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByBpumId = array();
			} else {

				$criteria->add(ProductPeer::BPUM_ID, $this->getId());

				$this->collProductsRelatedByBpumId = ProductPeer::doSelectJoinTax($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::BPUM_ID, $this->getId());

			if (!isset($this->lastProductRelatedByBpumIdCriteria) || !$this->lastProductRelatedByBpumIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByBpumId = ProductPeer::doSelectJoinTax($criteria, $con);
			}
		}
		$this->lastProductRelatedByBpumIdCriteria = $criteria;

		return $this->collProductsRelatedByBpumId;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'BasicPriceUnitMeasure.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseBasicPriceUnitMeasure:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseBasicPriceUnitMeasure::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseBasicPriceUnitMeasure
