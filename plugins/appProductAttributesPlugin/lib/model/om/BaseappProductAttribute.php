<?php

/**
 * Base class that represents a row from the 'app_product_attribute' table.
 *
 * 
 *
 * @package    plugins.appProductAttributesPlugin.lib.model.om
 */
abstract class BaseappProductAttribute extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        appProductAttributePeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the is_active field.
	 * @var        boolean
	 */
	protected $is_active = true;


	/**
	 * The value for the is_searchable field.
	 * @var        boolean
	 */
	protected $is_searchable = false;


	/**
	 * The value for the is_visible_on_pp field.
	 * @var        boolean
	 */
	protected $is_visible_on_pp = true;


	/**
	 * The value for the opt_name field.
	 * @var        string
	 */
	protected $opt_name;


	/**
	 * The value for the type field.
	 * @var        string
	 */
	protected $type = 'T';


	/**
	 * The value for the position field.
	 * @var        int
	 */
	protected $position = 0;

	/**
	 * Collection to store aggregation of collappProductAttributeI18ns.
	 * @var        array
	 */
	protected $collappProductAttributeI18ns;

	/**
	 * The criteria used to select the current contents of collappProductAttributeI18ns.
	 * @var        Criteria
	 */
	protected $lastappProductAttributeI18nCriteria = null;

	/**
	 * Collection to store aggregation of collappProductAttributeHasCategorys.
	 * @var        array
	 */
	protected $collappProductAttributeHasCategorys;

	/**
	 * The criteria used to select the current contents of collappProductAttributeHasCategorys.
	 * @var        Criteria
	 */
	protected $lastappProductAttributeHasCategoryCriteria = null;

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
     * Get the [is_active] column value.
     * 
     * @return     boolean
     */
    public function getIsActive()
    {

            return $this->is_active;
    }

    /**
     * Get the [is_searchable] column value.
     * 
     * @return     boolean
     */
    public function getIsSearchable()
    {

            return $this->is_searchable;
    }

    /**
     * Get the [is_visible_on_pp] column value.
     * 
     * @return     boolean
     */
    public function getIsVisibleOnPp()
    {

            return $this->is_visible_on_pp;
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
          $this->modifiedColumns[] = appProductAttributePeer::ID;
        }

	} // setId()

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

        if ($this->is_active !== $v || $v === true) {
          $this->is_active = $v;
          $this->modifiedColumns[] = appProductAttributePeer::IS_ACTIVE;
        }

	} // setIsActive()

	/**
	 * Set the value of [is_searchable] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsSearchable($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_searchable !== $v || $v === false) {
          $this->is_searchable = $v;
          $this->modifiedColumns[] = appProductAttributePeer::IS_SEARCHABLE;
        }

	} // setIsSearchable()

	/**
	 * Set the value of [is_visible_on_pp] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsVisibleOnPp($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_visible_on_pp !== $v || $v === true) {
          $this->is_visible_on_pp = $v;
          $this->modifiedColumns[] = appProductAttributePeer::IS_VISIBLE_ON_PP;
        }

	} // setIsVisibleOnPp()

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
          $this->modifiedColumns[] = appProductAttributePeer::OPT_NAME;
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

        if ($this->type !== $v || $v === 'T') {
          $this->type = $v;
          $this->modifiedColumns[] = appProductAttributePeer::TYPE;
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
          $this->modifiedColumns[] = appProductAttributePeer::POSITION;
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
      if ($this->getDispatcher()->getListeners('appProductAttribute.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'appProductAttribute.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->is_active = $rs->getBoolean($startcol + 1);

      $this->is_searchable = $rs->getBoolean($startcol + 2);

      $this->is_visible_on_pp = $rs->getBoolean($startcol + 3);

      $this->opt_name = $rs->getString($startcol + 4);

      $this->type = $rs->getString($startcol + 5);

      $this->position = $rs->getInt($startcol + 6);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('appProductAttribute.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'appProductAttribute.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 7)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 7; // 7 = appProductAttributePeer::NUM_COLUMNS - appProductAttributePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating appProductAttribute object", $e);
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

    if ($this->getDispatcher()->getListeners('appProductAttribute.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'appProductAttribute.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseappProductAttribute:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseappProductAttribute:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(appProductAttributePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      appProductAttributePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('appProductAttribute.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'appProductAttribute.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseappProductAttribute:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseappProductAttribute:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('appProductAttribute.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'appProductAttribute.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseappProductAttribute:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(appProductAttributePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('appProductAttribute.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'appProductAttribute.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseappProductAttribute:save:post') as $callable)
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
					$pk = appProductAttributePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += appProductAttributePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collappProductAttributeI18ns !== null) {
				foreach($this->collappProductAttributeI18ns as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collappProductAttributeHasCategorys !== null) {
				foreach($this->collappProductAttributeHasCategorys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collappProductAttributeHasVariants !== null) {
				foreach($this->collappProductAttributeHasVariants as $referrerFK) {
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


			if (($retval = appProductAttributePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collappProductAttributeI18ns !== null) {
					foreach($this->collappProductAttributeI18ns as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collappProductAttributeHasCategorys !== null) {
					foreach($this->collappProductAttributeHasCategorys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collappProductAttributeHasVariants !== null) {
					foreach($this->collappProductAttributeHasVariants as $referrerFK) {
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
		$pos = appProductAttributePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getIsActive();
				break;
			case 2:
				return $this->getIsSearchable();
				break;
			case 3:
				return $this->getIsVisibleOnPp();
				break;
			case 4:
				return $this->getOptName();
				break;
			case 5:
				return $this->getType();
				break;
			case 6:
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
		$keys = appProductAttributePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getIsActive(),
			$keys[2] => $this->getIsSearchable(),
			$keys[3] => $this->getIsVisibleOnPp(),
			$keys[4] => $this->getOptName(),
			$keys[5] => $this->getType(),
			$keys[6] => $this->getPosition(),
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
		$pos = appProductAttributePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setIsActive($value);
				break;
			case 2:
				$this->setIsSearchable($value);
				break;
			case 3:
				$this->setIsVisibleOnPp($value);
				break;
			case 4:
				$this->setOptName($value);
				break;
			case 5:
				$this->setType($value);
				break;
			case 6:
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
		$keys = appProductAttributePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setIsActive($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIsSearchable($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setIsVisibleOnPp($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setOptName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setType($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setPosition($arr[$keys[6]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(appProductAttributePeer::DATABASE_NAME);

		if ($this->isColumnModified(appProductAttributePeer::ID)) $criteria->add(appProductAttributePeer::ID, $this->id);
		if ($this->isColumnModified(appProductAttributePeer::IS_ACTIVE)) $criteria->add(appProductAttributePeer::IS_ACTIVE, $this->is_active);
		if ($this->isColumnModified(appProductAttributePeer::IS_SEARCHABLE)) $criteria->add(appProductAttributePeer::IS_SEARCHABLE, $this->is_searchable);
		if ($this->isColumnModified(appProductAttributePeer::IS_VISIBLE_ON_PP)) $criteria->add(appProductAttributePeer::IS_VISIBLE_ON_PP, $this->is_visible_on_pp);
		if ($this->isColumnModified(appProductAttributePeer::OPT_NAME)) $criteria->add(appProductAttributePeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(appProductAttributePeer::TYPE)) $criteria->add(appProductAttributePeer::TYPE, $this->type);
		if ($this->isColumnModified(appProductAttributePeer::POSITION)) $criteria->add(appProductAttributePeer::POSITION, $this->position);

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
		$criteria = new Criteria(appProductAttributePeer::DATABASE_NAME);

		$criteria->add(appProductAttributePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of appProductAttribute (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setIsActive($this->is_active);

		$copyObj->setIsSearchable($this->is_searchable);

		$copyObj->setIsVisibleOnPp($this->is_visible_on_pp);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setType($this->type);

		$copyObj->setPosition($this->position);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getappProductAttributeI18ns() as $relObj) {
				$copyObj->addappProductAttributeI18n($relObj->copy($deepCopy));
			}

			foreach($this->getappProductAttributeHasCategorys() as $relObj) {
				$copyObj->addappProductAttributeHasCategory($relObj->copy($deepCopy));
			}

			foreach($this->getappProductAttributeHasVariants() as $relObj) {
				$copyObj->addappProductAttributeHasVariant($relObj->copy($deepCopy));
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
	 * @return     appProductAttribute Clone of current object.
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
	 * @return     appProductAttributePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new appProductAttributePeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collappProductAttributeI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initappProductAttributeI18ns()
	{
		if ($this->collappProductAttributeI18ns === null) {
			$this->collappProductAttributeI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this appProductAttribute has previously
	 * been saved, it will retrieve related appProductAttributeI18ns from storage.
	 * If this appProductAttribute is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getappProductAttributeI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collappProductAttributeI18ns === null) {
			if ($this->isNew()) {
			   $this->collappProductAttributeI18ns = array();
			} else {

				$criteria->add(appProductAttributeI18nPeer::ID, $this->getId());

				appProductAttributeI18nPeer::addSelectColumns($criteria);
				$this->collappProductAttributeI18ns = appProductAttributeI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(appProductAttributeI18nPeer::ID, $this->getId());

				appProductAttributeI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastappProductAttributeI18nCriteria) || !$this->lastappProductAttributeI18nCriteria->equals($criteria)) {
					$this->collappProductAttributeI18ns = appProductAttributeI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastappProductAttributeI18nCriteria = $criteria;
		return $this->collappProductAttributeI18ns;
	}

	/**
	 * Returns the number of related appProductAttributeI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countappProductAttributeI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(appProductAttributeI18nPeer::ID, $this->getId());

		return appProductAttributeI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a appProductAttributeI18n object to this object
	 * through the appProductAttributeI18n foreign key attribute
	 *
	 * @param      appProductAttributeI18n $l appProductAttributeI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addappProductAttributeI18n(appProductAttributeI18n $l)
	{
		$this->collappProductAttributeI18ns[] = $l;
		$l->setappProductAttribute($this);
	}

	/**
	 * Temporary storage of collappProductAttributeHasCategorys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initappProductAttributeHasCategorys()
	{
		if ($this->collappProductAttributeHasCategorys === null) {
			$this->collappProductAttributeHasCategorys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this appProductAttribute has previously
	 * been saved, it will retrieve related appProductAttributeHasCategorys from storage.
	 * If this appProductAttribute is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getappProductAttributeHasCategorys($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collappProductAttributeHasCategorys === null) {
			if ($this->isNew()) {
			   $this->collappProductAttributeHasCategorys = array();
			} else {

				$criteria->add(appProductAttributeHasCategoryPeer::ATTRIBUTE_ID, $this->getId());

				appProductAttributeHasCategoryPeer::addSelectColumns($criteria);
				$this->collappProductAttributeHasCategorys = appProductAttributeHasCategoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(appProductAttributeHasCategoryPeer::ATTRIBUTE_ID, $this->getId());

				appProductAttributeHasCategoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastappProductAttributeHasCategoryCriteria) || !$this->lastappProductAttributeHasCategoryCriteria->equals($criteria)) {
					$this->collappProductAttributeHasCategorys = appProductAttributeHasCategoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastappProductAttributeHasCategoryCriteria = $criteria;
		return $this->collappProductAttributeHasCategorys;
	}

	/**
	 * Returns the number of related appProductAttributeHasCategorys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countappProductAttributeHasCategorys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(appProductAttributeHasCategoryPeer::ATTRIBUTE_ID, $this->getId());

		return appProductAttributeHasCategoryPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a appProductAttributeHasCategory object to this object
	 * through the appProductAttributeHasCategory foreign key attribute
	 *
	 * @param      appProductAttributeHasCategory $l appProductAttributeHasCategory
	 * @return     void
	 * @throws     PropelException
	 */
	public function addappProductAttributeHasCategory(appProductAttributeHasCategory $l)
	{
		$this->collappProductAttributeHasCategorys[] = $l;
		$l->setappProductAttribute($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this appProductAttribute is new, it will return
	 * an empty collection; or if this appProductAttribute has previously
	 * been saved, it will retrieve related appProductAttributeHasCategorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in appProductAttribute.
	 */
	public function getappProductAttributeHasCategorysJoinCategory($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collappProductAttributeHasCategorys === null) {
			if ($this->isNew()) {
				$this->collappProductAttributeHasCategorys = array();
			} else {

				$criteria->add(appProductAttributeHasCategoryPeer::ATTRIBUTE_ID, $this->getId());

				$this->collappProductAttributeHasCategorys = appProductAttributeHasCategoryPeer::doSelectJoinCategory($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(appProductAttributeHasCategoryPeer::ATTRIBUTE_ID, $this->getId());

			if (!isset($this->lastappProductAttributeHasCategoryCriteria) || !$this->lastappProductAttributeHasCategoryCriteria->equals($criteria)) {
				$this->collappProductAttributeHasCategorys = appProductAttributeHasCategoryPeer::doSelectJoinCategory($criteria, $con);
			}
		}
		$this->lastappProductAttributeHasCategoryCriteria = $criteria;

		return $this->collappProductAttributeHasCategorys;
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
	 * Otherwise if this appProductAttribute has previously
	 * been saved, it will retrieve related appProductAttributeHasVariants from storage.
	 * If this appProductAttribute is new, it will return
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

				$criteria->add(appProductAttributeHasVariantPeer::ATTRIBUTE_ID, $this->getId());

				appProductAttributeHasVariantPeer::addSelectColumns($criteria);
				$this->collappProductAttributeHasVariants = appProductAttributeHasVariantPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(appProductAttributeHasVariantPeer::ATTRIBUTE_ID, $this->getId());

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

		$criteria->add(appProductAttributeHasVariantPeer::ATTRIBUTE_ID, $this->getId());

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
		$l->setappProductAttribute($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this appProductAttribute is new, it will return
	 * an empty collection; or if this appProductAttribute has previously
	 * been saved, it will retrieve related appProductAttributeHasVariants from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in appProductAttribute.
	 */
	public function getappProductAttributeHasVariantsJoinappProductAttributeVariant($criteria = null, $con = null)
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

				$criteria->add(appProductAttributeHasVariantPeer::ATTRIBUTE_ID, $this->getId());

				$this->collappProductAttributeHasVariants = appProductAttributeHasVariantPeer::doSelectJoinappProductAttributeVariant($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(appProductAttributeHasVariantPeer::ATTRIBUTE_ID, $this->getId());

			if (!isset($this->lastappProductAttributeHasVariantCriteria) || !$this->lastappProductAttributeHasVariantCriteria->equals($criteria)) {
				$this->collappProductAttributeHasVariants = appProductAttributeHasVariantPeer::doSelectJoinappProductAttributeVariant($criteria, $con);
			}
		}
		$this->lastappProductAttributeHasVariantCriteria = $criteria;

		return $this->collappProductAttributeHasVariants;
	}

  public function getCulture()
  {
    return $this->culture;
  }

  public function setCulture($culture)
  {
    $this->culture = $culture;
  }

  public function getName()
  {
    $obj = $this->getCurrentappProductAttributeI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentappProductAttributeI18n()->setName($value);
  }

  public $current_i18n = array();

  public function getCurrentappProductAttributeI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = appProductAttributeI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setappProductAttributeI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setappProductAttributeI18nForCulture(new appProductAttributeI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setappProductAttributeI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addappProductAttributeI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'appProductAttribute.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseappProductAttribute:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseappProductAttribute::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseappProductAttribute
