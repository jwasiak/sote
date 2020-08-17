<?php

/**
 * Base class that represents a row from the 'st_product_options_template' table.
 *
 * 
 *
 * @package    plugins.stProductOptionsPlugin.lib.model.om
 */
abstract class BaseProductOptionsTemplate extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ProductOptionsTemplatePeer
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
	 * The value for the opt_name field.
	 * @var        string
	 */
	protected $opt_name;

	/**
	 * Collection to store aggregation of collProductOptionsFields.
	 * @var        array
	 */
	protected $collProductOptionsFields;

	/**
	 * The criteria used to select the current contents of collProductOptionsFields.
	 * @var        Criteria
	 */
	protected $lastProductOptionsFieldCriteria = null;

	/**
	 * Collection to store aggregation of collProductOptionsDefaultValues.
	 * @var        array
	 */
	protected $collProductOptionsDefaultValues;

	/**
	 * The criteria used to select the current contents of collProductOptionsDefaultValues.
	 * @var        Criteria
	 */
	protected $lastProductOptionsDefaultValueCriteria = null;

	/**
	 * Collection to store aggregation of collProductOptionsValues.
	 * @var        array
	 */
	protected $collProductOptionsValues;

	/**
	 * The criteria used to select the current contents of collProductOptionsValues.
	 * @var        Criteria
	 */
	protected $lastProductOptionsValueCriteria = null;

	/**
	 * Collection to store aggregation of collProductOptionsTemplateI18ns.
	 * @var        array
	 */
	protected $collProductOptionsTemplateI18ns;

	/**
	 * The criteria used to select the current contents of collProductOptionsTemplateI18ns.
	 * @var        Criteria
	 */
	protected $lastProductOptionsTemplateI18nCriteria = null;

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
     * Get the [opt_name] column value.
     * 
     * @return     string
     */
    public function getOptName()
    {

            return $this->opt_name;
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
			$this->modifiedColumns[] = ProductOptionsTemplatePeer::CREATED_AT;
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
			$this->modifiedColumns[] = ProductOptionsTemplatePeer::UPDATED_AT;
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
          $this->modifiedColumns[] = ProductOptionsTemplatePeer::ID;
        }

	} // setId()

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
          $this->modifiedColumns[] = ProductOptionsTemplatePeer::OPT_NAME;
        }

	} // setOptName()

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
      if ($this->getDispatcher()->getListeners('ProductOptionsTemplate.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsTemplate.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->opt_name = $rs->getString($startcol + 3);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('ProductOptionsTemplate.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsTemplate.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 4)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 4; // 4 = ProductOptionsTemplatePeer::NUM_COLUMNS - ProductOptionsTemplatePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating ProductOptionsTemplate object", $e);
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

    if ($this->getDispatcher()->getListeners('ProductOptionsTemplate.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsTemplate.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductOptionsTemplate:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseProductOptionsTemplate:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ProductOptionsTemplatePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ProductOptionsTemplatePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('ProductOptionsTemplate.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsTemplate.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductOptionsTemplate:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseProductOptionsTemplate:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('ProductOptionsTemplate.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsTemplate.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseProductOptionsTemplate:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(ProductOptionsTemplatePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ProductOptionsTemplatePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(ProductOptionsTemplatePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('ProductOptionsTemplate.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsTemplate.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseProductOptionsTemplate:save:post') as $callable)
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
					$pk = ProductOptionsTemplatePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ProductOptionsTemplatePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collProductOptionsFields !== null) {
				foreach($this->collProductOptionsFields as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductOptionsDefaultValues !== null) {
				foreach($this->collProductOptionsDefaultValues as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductOptionsValues !== null) {
				foreach($this->collProductOptionsValues as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductOptionsTemplateI18ns !== null) {
				foreach($this->collProductOptionsTemplateI18ns as $referrerFK) {
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


			if (($retval = ProductOptionsTemplatePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collProductOptionsFields !== null) {
					foreach($this->collProductOptionsFields as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductOptionsDefaultValues !== null) {
					foreach($this->collProductOptionsDefaultValues as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductOptionsValues !== null) {
					foreach($this->collProductOptionsValues as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductOptionsTemplateI18ns !== null) {
					foreach($this->collProductOptionsTemplateI18ns as $referrerFK) {
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
		$pos = ProductOptionsTemplatePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getOptName();
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
		$keys = ProductOptionsTemplatePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getOptName(),
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
		$pos = ProductOptionsTemplatePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setOptName($value);
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
		$keys = ProductOptionsTemplatePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setOptName($arr[$keys[3]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ProductOptionsTemplatePeer::DATABASE_NAME);

		if ($this->isColumnModified(ProductOptionsTemplatePeer::CREATED_AT)) $criteria->add(ProductOptionsTemplatePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ProductOptionsTemplatePeer::UPDATED_AT)) $criteria->add(ProductOptionsTemplatePeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(ProductOptionsTemplatePeer::ID)) $criteria->add(ProductOptionsTemplatePeer::ID, $this->id);
		if ($this->isColumnModified(ProductOptionsTemplatePeer::OPT_NAME)) $criteria->add(ProductOptionsTemplatePeer::OPT_NAME, $this->opt_name);

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
		$criteria = new Criteria(ProductOptionsTemplatePeer::DATABASE_NAME);

		$criteria->add(ProductOptionsTemplatePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of ProductOptionsTemplate (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setOptName($this->opt_name);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getProductOptionsFields() as $relObj) {
				$copyObj->addProductOptionsField($relObj->copy($deepCopy));
			}

			foreach($this->getProductOptionsDefaultValues() as $relObj) {
				$copyObj->addProductOptionsDefaultValue($relObj->copy($deepCopy));
			}

			foreach($this->getProductOptionsValues() as $relObj) {
				$copyObj->addProductOptionsValue($relObj->copy($deepCopy));
			}

			foreach($this->getProductOptionsTemplateI18ns() as $relObj) {
				$copyObj->addProductOptionsTemplateI18n($relObj->copy($deepCopy));
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
	 * @return     ProductOptionsTemplate Clone of current object.
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
	 * @return     ProductOptionsTemplatePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ProductOptionsTemplatePeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collProductOptionsFields to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductOptionsFields()
	{
		if ($this->collProductOptionsFields === null) {
			$this->collProductOptionsFields = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsTemplate has previously
	 * been saved, it will retrieve related ProductOptionsFields from storage.
	 * If this ProductOptionsTemplate is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductOptionsFields($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsFields === null) {
			if ($this->isNew()) {
			   $this->collProductOptionsFields = array();
			} else {

				$criteria->add(ProductOptionsFieldPeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

				ProductOptionsFieldPeer::addSelectColumns($criteria);
				$this->collProductOptionsFields = ProductOptionsFieldPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductOptionsFieldPeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

				ProductOptionsFieldPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductOptionsFieldCriteria) || !$this->lastProductOptionsFieldCriteria->equals($criteria)) {
					$this->collProductOptionsFields = ProductOptionsFieldPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductOptionsFieldCriteria = $criteria;
		return $this->collProductOptionsFields;
	}

	/**
	 * Returns the number of related ProductOptionsFields.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductOptionsFields($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductOptionsFieldPeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

		return ProductOptionsFieldPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductOptionsField object to this object
	 * through the ProductOptionsField foreign key attribute
	 *
	 * @param      ProductOptionsField $l ProductOptionsField
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductOptionsField(ProductOptionsField $l)
	{
		$this->collProductOptionsFields[] = $l;
		$l->setProductOptionsTemplate($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsTemplate is new, it will return
	 * an empty collection; or if this ProductOptionsTemplate has previously
	 * been saved, it will retrieve related ProductOptionsFields from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsTemplate.
	 */
	public function getProductOptionsFieldsJoinProductOptionsFilter($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsFields === null) {
			if ($this->isNew()) {
				$this->collProductOptionsFields = array();
			} else {

				$criteria->add(ProductOptionsFieldPeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

				$this->collProductOptionsFields = ProductOptionsFieldPeer::doSelectJoinProductOptionsFilter($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsFieldPeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

			if (!isset($this->lastProductOptionsFieldCriteria) || !$this->lastProductOptionsFieldCriteria->equals($criteria)) {
				$this->collProductOptionsFields = ProductOptionsFieldPeer::doSelectJoinProductOptionsFilter($criteria, $con);
			}
		}
		$this->lastProductOptionsFieldCriteria = $criteria;

		return $this->collProductOptionsFields;
	}

	/**
	 * Temporary storage of collProductOptionsDefaultValues to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductOptionsDefaultValues()
	{
		if ($this->collProductOptionsDefaultValues === null) {
			$this->collProductOptionsDefaultValues = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsTemplate has previously
	 * been saved, it will retrieve related ProductOptionsDefaultValues from storage.
	 * If this ProductOptionsTemplate is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductOptionsDefaultValues($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsDefaultValues === null) {
			if ($this->isNew()) {
			   $this->collProductOptionsDefaultValues = array();
			} else {

				$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

				ProductOptionsDefaultValuePeer::addSelectColumns($criteria);
				$this->collProductOptionsDefaultValues = ProductOptionsDefaultValuePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

				ProductOptionsDefaultValuePeer::addSelectColumns($criteria);
				if (!isset($this->lastProductOptionsDefaultValueCriteria) || !$this->lastProductOptionsDefaultValueCriteria->equals($criteria)) {
					$this->collProductOptionsDefaultValues = ProductOptionsDefaultValuePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductOptionsDefaultValueCriteria = $criteria;
		return $this->collProductOptionsDefaultValues;
	}

	/**
	 * Returns the number of related ProductOptionsDefaultValues.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductOptionsDefaultValues($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

		return ProductOptionsDefaultValuePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductOptionsDefaultValue object to this object
	 * through the ProductOptionsDefaultValue foreign key attribute
	 *
	 * @param      ProductOptionsDefaultValue $l ProductOptionsDefaultValue
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductOptionsDefaultValue(ProductOptionsDefaultValue $l)
	{
		$this->collProductOptionsDefaultValues[] = $l;
		$l->setProductOptionsTemplate($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsTemplate is new, it will return
	 * an empty collection; or if this ProductOptionsTemplate has previously
	 * been saved, it will retrieve related ProductOptionsDefaultValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsTemplate.
	 */
	public function getProductOptionsDefaultValuesJoinProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsDefaultValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsDefaultValues = array();
			} else {

				$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

				$this->collProductOptionsDefaultValues = ProductOptionsDefaultValuePeer::doSelectJoinProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

			if (!isset($this->lastProductOptionsDefaultValueCriteria) || !$this->lastProductOptionsDefaultValueCriteria->equals($criteria)) {
				$this->collProductOptionsDefaultValues = ProductOptionsDefaultValuePeer::doSelectJoinProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId($criteria, $con);
			}
		}
		$this->lastProductOptionsDefaultValueCriteria = $criteria;

		return $this->collProductOptionsDefaultValues;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsTemplate is new, it will return
	 * an empty collection; or if this ProductOptionsTemplate has previously
	 * been saved, it will retrieve related ProductOptionsDefaultValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsTemplate.
	 */
	public function getProductOptionsDefaultValuesJoinProductOptionsField($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsDefaultValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsDefaultValues = array();
			} else {

				$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

				$this->collProductOptionsDefaultValues = ProductOptionsDefaultValuePeer::doSelectJoinProductOptionsField($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

			if (!isset($this->lastProductOptionsDefaultValueCriteria) || !$this->lastProductOptionsDefaultValueCriteria->equals($criteria)) {
				$this->collProductOptionsDefaultValues = ProductOptionsDefaultValuePeer::doSelectJoinProductOptionsField($criteria, $con);
			}
		}
		$this->lastProductOptionsDefaultValueCriteria = $criteria;

		return $this->collProductOptionsDefaultValues;
	}

	/**
	 * Temporary storage of collProductOptionsValues to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductOptionsValues()
	{
		if ($this->collProductOptionsValues === null) {
			$this->collProductOptionsValues = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsTemplate has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 * If this ProductOptionsTemplate is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductOptionsValues($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
			   $this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

				ProductOptionsValuePeer::addSelectColumns($criteria);
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

				ProductOptionsValuePeer::addSelectColumns($criteria);
				if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
					$this->collProductOptionsValues = ProductOptionsValuePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;
		return $this->collProductOptionsValues;
	}

	/**
	 * Returns the number of related ProductOptionsValues.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductOptionsValues($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

		return ProductOptionsValuePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductOptionsValue object to this object
	 * through the ProductOptionsValue foreign key attribute
	 *
	 * @param      ProductOptionsValue $l ProductOptionsValue
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductOptionsValue(ProductOptionsValue $l)
	{
		$this->collProductOptionsValues[] = $l;
		$l->setProductOptionsTemplate($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsTemplate is new, it will return
	 * an empty collection; or if this ProductOptionsTemplate has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsTemplate.
	 */
	public function getProductOptionsValuesJoinsfAsset($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinsfAsset($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinsfAsset($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsTemplate is new, it will return
	 * an empty collection; or if this ProductOptionsTemplate has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsTemplate.
	 */
	public function getProductOptionsValuesJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsTemplate is new, it will return
	 * an empty collection; or if this ProductOptionsTemplate has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsTemplate.
	 */
	public function getProductOptionsValuesJoinProductOptionsValueRelatedByProductOptionsValueId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsValueRelatedByProductOptionsValueId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsValueRelatedByProductOptionsValueId($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsTemplate is new, it will return
	 * an empty collection; or if this ProductOptionsTemplate has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsTemplate.
	 */
	public function getProductOptionsValuesJoinProductOptionsField($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsField($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsField($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}

	/**
	 * Temporary storage of collProductOptionsTemplateI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductOptionsTemplateI18ns()
	{
		if ($this->collProductOptionsTemplateI18ns === null) {
			$this->collProductOptionsTemplateI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsTemplate has previously
	 * been saved, it will retrieve related ProductOptionsTemplateI18ns from storage.
	 * If this ProductOptionsTemplate is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductOptionsTemplateI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsTemplateI18ns === null) {
			if ($this->isNew()) {
			   $this->collProductOptionsTemplateI18ns = array();
			} else {

				$criteria->add(ProductOptionsTemplateI18nPeer::ID, $this->getId());

				ProductOptionsTemplateI18nPeer::addSelectColumns($criteria);
				$this->collProductOptionsTemplateI18ns = ProductOptionsTemplateI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductOptionsTemplateI18nPeer::ID, $this->getId());

				ProductOptionsTemplateI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductOptionsTemplateI18nCriteria) || !$this->lastProductOptionsTemplateI18nCriteria->equals($criteria)) {
					$this->collProductOptionsTemplateI18ns = ProductOptionsTemplateI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductOptionsTemplateI18nCriteria = $criteria;
		return $this->collProductOptionsTemplateI18ns;
	}

	/**
	 * Returns the number of related ProductOptionsTemplateI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductOptionsTemplateI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductOptionsTemplateI18nPeer::ID, $this->getId());

		return ProductOptionsTemplateI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductOptionsTemplateI18n object to this object
	 * through the ProductOptionsTemplateI18n foreign key attribute
	 *
	 * @param      ProductOptionsTemplateI18n $l ProductOptionsTemplateI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductOptionsTemplateI18n(ProductOptionsTemplateI18n $l)
	{
		$this->collProductOptionsTemplateI18ns[] = $l;
		$l->setProductOptionsTemplate($this);
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
    $obj = $this->getCurrentProductOptionsTemplateI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentProductOptionsTemplateI18n()->setName($value);
  }

  public $current_i18n = array();

  public function getCurrentProductOptionsTemplateI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = ProductOptionsTemplateI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setProductOptionsTemplateI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setProductOptionsTemplateI18nForCulture(new ProductOptionsTemplateI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setProductOptionsTemplateI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addProductOptionsTemplateI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'ProductOptionsTemplate.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseProductOptionsTemplate:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseProductOptionsTemplate::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseProductOptionsTemplate
