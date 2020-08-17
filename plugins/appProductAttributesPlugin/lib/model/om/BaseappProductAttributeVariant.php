<?php

/**
 * Base class that represents a row from the 'app_product_attribute_variant' table.
 *
 * 
 *
 * @package    plugins.appProductAttributesPlugin.lib.model.om
 */
abstract class BaseappProductAttributeVariant extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        appProductAttributeVariantPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the opt_value field.
	 * @var        string
	 */
	protected $opt_value;


	/**
	 * The value for the opt_name field.
	 * @var        string
	 */
	protected $opt_name;


	/**
	 * The value for the type field.
	 * @var        string
	 */
	protected $type;


	/**
	 * The value for the position field.
	 * @var        int
	 */
	protected $position = 0;

	/**
	 * Collection to store aggregation of collappProductAttributeHasVariants.
	 * @var        array
	 */
	protected $collappProductAttributeHasVariants;

	/**
	 * The criteria used to select the current contents of collappProductAttributeHasVariants.
	 * @var        Criteria
	 */
	protected $lastappProductAttributeHasVariantCriteria = null;

	/**
	 * Collection to store aggregation of collappProductAttributeVariantHasProducts.
	 * @var        array
	 */
	protected $collappProductAttributeVariantHasProducts;

	/**
	 * The criteria used to select the current contents of collappProductAttributeVariantHasProducts.
	 * @var        Criteria
	 */
	protected $lastappProductAttributeVariantHasProductCriteria = null;

	/**
	 * Collection to store aggregation of collappProductAttributeVariantI18ns.
	 * @var        array
	 */
	protected $collappProductAttributeVariantI18ns;

	/**
	 * The criteria used to select the current contents of collappProductAttributeVariantI18ns.
	 * @var        Criteria
	 */
	protected $lastappProductAttributeVariantI18nCriteria = null;

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
     * Get the [id] column value.
     * 
     * @return     int
     */
    public function getId()
    {

            return $this->id;
    }

    /**
     * Get the [opt_value] column value.
     * 
     * @return     string
     */
    public function getOptValue()
    {

            return $this->opt_value;
    }

    /**
     * Get the [opt_name] column value.
     * 
     * @return     string
     */
    public function getOptName()
    {

            return $this->opt_name;
    }

    /**
     * Get the [type] column value.
     * 
     * @return     string
     */
    public function getType()
    {

            return $this->type;
    }

    /**
     * Get the [position] column value.
     * 
     * @return     int
     */
    public function getPosition()
    {

            return $this->position;
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
          $this->modifiedColumns[] = appProductAttributeVariantPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [opt_value] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptValue($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_value !== $v) {
          $this->opt_value = $v;
          $this->modifiedColumns[] = appProductAttributeVariantPeer::OPT_VALUE;
        }

	} // setOptValue()

	/**
	 * Set the value of [opt_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptName($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_name !== $v) {
          $this->opt_name = $v;
          $this->modifiedColumns[] = appProductAttributeVariantPeer::OPT_NAME;
        }

	} // setOptName()

	/**
	 * Set the value of [type] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setType($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->type !== $v) {
          $this->type = $v;
          $this->modifiedColumns[] = appProductAttributeVariantPeer::TYPE;
        }

	} // setType()

	/**
	 * Set the value of [position] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPosition($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->position !== $v || $v === 0) {
          $this->position = $v;
          $this->modifiedColumns[] = appProductAttributeVariantPeer::POSITION;
        }

	} // setPosition()

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
      if ($this->getDispatcher()->getListeners('appProductAttributeVariant.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'appProductAttributeVariant.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->opt_value = $rs->getString($startcol + 1);

      $this->opt_name = $rs->getString($startcol + 2);

      $this->type = $rs->getString($startcol + 3);

      $this->position = $rs->getInt($startcol + 4);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('appProductAttributeVariant.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'appProductAttributeVariant.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 5)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 5; // 5 = appProductAttributeVariantPeer::NUM_COLUMNS - appProductAttributeVariantPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating appProductAttributeVariant object", $e);
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

    if ($this->getDispatcher()->getListeners('appProductAttributeVariant.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'appProductAttributeVariant.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseappProductAttributeVariant:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseappProductAttributeVariant:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(appProductAttributeVariantPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      appProductAttributeVariantPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('appProductAttributeVariant.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'appProductAttributeVariant.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseappProductAttributeVariant:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseappProductAttributeVariant:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('appProductAttributeVariant.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'appProductAttributeVariant.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseappProductAttributeVariant:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(appProductAttributeVariantPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('appProductAttributeVariant.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'appProductAttributeVariant.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseappProductAttributeVariant:save:post') as $callable)
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
					$pk = appProductAttributeVariantPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += appProductAttributeVariantPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collappProductAttributeHasVariants !== null) {
				foreach($this->collappProductAttributeHasVariants as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collappProductAttributeVariantHasProducts !== null) {
				foreach($this->collappProductAttributeVariantHasProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collappProductAttributeVariantI18ns !== null) {
				foreach($this->collappProductAttributeVariantI18ns as $referrerFK) {
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


			if (($retval = appProductAttributeVariantPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collappProductAttributeHasVariants !== null) {
					foreach($this->collappProductAttributeHasVariants as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collappProductAttributeVariantHasProducts !== null) {
					foreach($this->collappProductAttributeVariantHasProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collappProductAttributeVariantI18ns !== null) {
					foreach($this->collappProductAttributeVariantI18ns as $referrerFK) {
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
		$pos = appProductAttributeVariantPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getOptValue();
				break;
			case 2:
				return $this->getOptName();
				break;
			case 3:
				return $this->getType();
				break;
			case 4:
				return $this->getPosition();
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
		$keys = appProductAttributeVariantPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getOptValue(),
			$keys[2] => $this->getOptName(),
			$keys[3] => $this->getType(),
			$keys[4] => $this->getPosition(),
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
		$pos = appProductAttributeVariantPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setOptValue($value);
				break;
			case 2:
				$this->setOptName($value);
				break;
			case 3:
				$this->setType($value);
				break;
			case 4:
				$this->setPosition($value);
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
		$keys = appProductAttributeVariantPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setOptValue($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setOptName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setType($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPosition($arr[$keys[4]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(appProductAttributeVariantPeer::DATABASE_NAME);

		if ($this->isColumnModified(appProductAttributeVariantPeer::ID)) $criteria->add(appProductAttributeVariantPeer::ID, $this->id);
		if ($this->isColumnModified(appProductAttributeVariantPeer::OPT_VALUE)) $criteria->add(appProductAttributeVariantPeer::OPT_VALUE, $this->opt_value);
		if ($this->isColumnModified(appProductAttributeVariantPeer::OPT_NAME)) $criteria->add(appProductAttributeVariantPeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(appProductAttributeVariantPeer::TYPE)) $criteria->add(appProductAttributeVariantPeer::TYPE, $this->type);
		if ($this->isColumnModified(appProductAttributeVariantPeer::POSITION)) $criteria->add(appProductAttributeVariantPeer::POSITION, $this->position);

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
		$criteria = new Criteria(appProductAttributeVariantPeer::DATABASE_NAME);

		$criteria->add(appProductAttributeVariantPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of appProductAttributeVariant (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setOptValue($this->opt_value);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setType($this->type);

		$copyObj->setPosition($this->position);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getappProductAttributeHasVariants() as $relObj) {
				$copyObj->addappProductAttributeHasVariant($relObj->copy($deepCopy));
			}

			foreach($this->getappProductAttributeVariantHasProducts() as $relObj) {
				$copyObj->addappProductAttributeVariantHasProduct($relObj->copy($deepCopy));
			}

			foreach($this->getappProductAttributeVariantI18ns() as $relObj) {
				$copyObj->addappProductAttributeVariantI18n($relObj->copy($deepCopy));
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
	 * @return     appProductAttributeVariant Clone of current object.
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
	 * @return     appProductAttributeVariantPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new appProductAttributeVariantPeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collappProductAttributeHasVariants to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initappProductAttributeHasVariants()
	{
		if ($this->collappProductAttributeHasVariants === null) {
			$this->collappProductAttributeHasVariants = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this appProductAttributeVariant has previously
	 * been saved, it will retrieve related appProductAttributeHasVariants from storage.
	 * If this appProductAttributeVariant is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getappProductAttributeHasVariants($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collappProductAttributeHasVariants === null) {
			if ($this->isNew()) {
			   $this->collappProductAttributeHasVariants = array();
			} else {

				$criteria->add(appProductAttributeHasVariantPeer::VARIANT_ID, $this->getId());

				appProductAttributeHasVariantPeer::addSelectColumns($criteria);
				$this->collappProductAttributeHasVariants = appProductAttributeHasVariantPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(appProductAttributeHasVariantPeer::VARIANT_ID, $this->getId());

				appProductAttributeHasVariantPeer::addSelectColumns($criteria);
				if (!isset($this->lastappProductAttributeHasVariantCriteria) || !$this->lastappProductAttributeHasVariantCriteria->equals($criteria)) {
					$this->collappProductAttributeHasVariants = appProductAttributeHasVariantPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastappProductAttributeHasVariantCriteria = $criteria;
		return $this->collappProductAttributeHasVariants;
	}

	/**
	 * Returns the number of related appProductAttributeHasVariants.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countappProductAttributeHasVariants($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(appProductAttributeHasVariantPeer::VARIANT_ID, $this->getId());

		return appProductAttributeHasVariantPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a appProductAttributeHasVariant object to this object
	 * through the appProductAttributeHasVariant foreign key attribute
	 *
	 * @param      appProductAttributeHasVariant $l appProductAttributeHasVariant
	 * @return     void
	 * @throws     PropelException
	 */
	public function addappProductAttributeHasVariant(appProductAttributeHasVariant $l)
	{
		$this->collappProductAttributeHasVariants[] = $l;
		$l->setappProductAttributeVariant($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this appProductAttributeVariant is new, it will return
	 * an empty collection; or if this appProductAttributeVariant has previously
	 * been saved, it will retrieve related appProductAttributeHasVariants from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in appProductAttributeVariant.
	 */
	public function getappProductAttributeHasVariantsJoinappProductAttribute($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collappProductAttributeHasVariants === null) {
			if ($this->isNew()) {
				$this->collappProductAttributeHasVariants = array();
			} else {

				$criteria->add(appProductAttributeHasVariantPeer::VARIANT_ID, $this->getId());

				$this->collappProductAttributeHasVariants = appProductAttributeHasVariantPeer::doSelectJoinappProductAttribute($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(appProductAttributeHasVariantPeer::VARIANT_ID, $this->getId());

			if (!isset($this->lastappProductAttributeHasVariantCriteria) || !$this->lastappProductAttributeHasVariantCriteria->equals($criteria)) {
				$this->collappProductAttributeHasVariants = appProductAttributeHasVariantPeer::doSelectJoinappProductAttribute($criteria, $con);
			}
		}
		$this->lastappProductAttributeHasVariantCriteria = $criteria;

		return $this->collappProductAttributeHasVariants;
	}

	/**
	 * Temporary storage of collappProductAttributeVariantHasProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initappProductAttributeVariantHasProducts()
	{
		if ($this->collappProductAttributeVariantHasProducts === null) {
			$this->collappProductAttributeVariantHasProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this appProductAttributeVariant has previously
	 * been saved, it will retrieve related appProductAttributeVariantHasProducts from storage.
	 * If this appProductAttributeVariant is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getappProductAttributeVariantHasProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collappProductAttributeVariantHasProducts === null) {
			if ($this->isNew()) {
			   $this->collappProductAttributeVariantHasProducts = array();
			} else {

				$criteria->add(appProductAttributeVariantHasProductPeer::VARIANT_ID, $this->getId());

				appProductAttributeVariantHasProductPeer::addSelectColumns($criteria);
				$this->collappProductAttributeVariantHasProducts = appProductAttributeVariantHasProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(appProductAttributeVariantHasProductPeer::VARIANT_ID, $this->getId());

				appProductAttributeVariantHasProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastappProductAttributeVariantHasProductCriteria) || !$this->lastappProductAttributeVariantHasProductCriteria->equals($criteria)) {
					$this->collappProductAttributeVariantHasProducts = appProductAttributeVariantHasProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastappProductAttributeVariantHasProductCriteria = $criteria;
		return $this->collappProductAttributeVariantHasProducts;
	}

	/**
	 * Returns the number of related appProductAttributeVariantHasProducts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countappProductAttributeVariantHasProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(appProductAttributeVariantHasProductPeer::VARIANT_ID, $this->getId());

		return appProductAttributeVariantHasProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a appProductAttributeVariantHasProduct object to this object
	 * through the appProductAttributeVariantHasProduct foreign key attribute
	 *
	 * @param      appProductAttributeVariantHasProduct $l appProductAttributeVariantHasProduct
	 * @return     void
	 * @throws     PropelException
	 */
	public function addappProductAttributeVariantHasProduct(appProductAttributeVariantHasProduct $l)
	{
		$this->collappProductAttributeVariantHasProducts[] = $l;
		$l->setappProductAttributeVariant($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this appProductAttributeVariant is new, it will return
	 * an empty collection; or if this appProductAttributeVariant has previously
	 * been saved, it will retrieve related appProductAttributeVariantHasProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in appProductAttributeVariant.
	 */
	public function getappProductAttributeVariantHasProductsJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collappProductAttributeVariantHasProducts === null) {
			if ($this->isNew()) {
				$this->collappProductAttributeVariantHasProducts = array();
			} else {

				$criteria->add(appProductAttributeVariantHasProductPeer::VARIANT_ID, $this->getId());

				$this->collappProductAttributeVariantHasProducts = appProductAttributeVariantHasProductPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(appProductAttributeVariantHasProductPeer::VARIANT_ID, $this->getId());

			if (!isset($this->lastappProductAttributeVariantHasProductCriteria) || !$this->lastappProductAttributeVariantHasProductCriteria->equals($criteria)) {
				$this->collappProductAttributeVariantHasProducts = appProductAttributeVariantHasProductPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastappProductAttributeVariantHasProductCriteria = $criteria;

		return $this->collappProductAttributeVariantHasProducts;
	}

	/**
	 * Temporary storage of collappProductAttributeVariantI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initappProductAttributeVariantI18ns()
	{
		if ($this->collappProductAttributeVariantI18ns === null) {
			$this->collappProductAttributeVariantI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this appProductAttributeVariant has previously
	 * been saved, it will retrieve related appProductAttributeVariantI18ns from storage.
	 * If this appProductAttributeVariant is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getappProductAttributeVariantI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collappProductAttributeVariantI18ns === null) {
			if ($this->isNew()) {
			   $this->collappProductAttributeVariantI18ns = array();
			} else {

				$criteria->add(appProductAttributeVariantI18nPeer::ID, $this->getId());

				appProductAttributeVariantI18nPeer::addSelectColumns($criteria);
				$this->collappProductAttributeVariantI18ns = appProductAttributeVariantI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(appProductAttributeVariantI18nPeer::ID, $this->getId());

				appProductAttributeVariantI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastappProductAttributeVariantI18nCriteria) || !$this->lastappProductAttributeVariantI18nCriteria->equals($criteria)) {
					$this->collappProductAttributeVariantI18ns = appProductAttributeVariantI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastappProductAttributeVariantI18nCriteria = $criteria;
		return $this->collappProductAttributeVariantI18ns;
	}

	/**
	 * Returns the number of related appProductAttributeVariantI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countappProductAttributeVariantI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(appProductAttributeVariantI18nPeer::ID, $this->getId());

		return appProductAttributeVariantI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a appProductAttributeVariantI18n object to this object
	 * through the appProductAttributeVariantI18n foreign key attribute
	 *
	 * @param      appProductAttributeVariantI18n $l appProductAttributeVariantI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addappProductAttributeVariantI18n(appProductAttributeVariantI18n $l)
	{
		$this->collappProductAttributeVariantI18ns[] = $l;
		$l->setappProductAttributeVariant($this);
	}

  public function getCulture()
  {
    return $this->culture;
  }

  public function setCulture($culture)
  {
    $this->culture = $culture;
  }

  public function getValue()
  {
    $obj = $this->getCurrentappProductAttributeVariantI18n();

    return ($obj ? $obj->getValue() : null);
  }

  public function setValue($value)
  {
    $this->getCurrentappProductAttributeVariantI18n()->setValue($value);
  }

  public function getName()
  {
    $obj = $this->getCurrentappProductAttributeVariantI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentappProductAttributeVariantI18n()->setName($value);
  }

  public $current_i18n = array();

  public function getCurrentappProductAttributeVariantI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = appProductAttributeVariantI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setappProductAttributeVariantI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setappProductAttributeVariantI18nForCulture(new appProductAttributeVariantI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setappProductAttributeVariantI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addappProductAttributeVariantI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'appProductAttributeVariant.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseappProductAttributeVariant:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseappProductAttributeVariant::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseappProductAttributeVariant
