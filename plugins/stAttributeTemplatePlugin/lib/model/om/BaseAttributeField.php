<?php

/**
 * Base class that represents a row from the 'st_attribute_field' table.
 *
 * 
 *
 * @package    plugins.stAttributeTemplatePlugin.lib.model.om
 */
abstract class BaseAttributeField extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        AttributeFieldPeer
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
	 * The value for the attribute_template_id field.
	 * @var        int
	 */
	protected $attribute_template_id;


	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the rank field.
	 * @var        int
	 */
	protected $rank;

	/**
	 * @var        AttributeTemplate
	 */
	protected $aAttributeTemplate;

	/**
	 * Collection to store aggregation of collProductHasAttributeFields.
	 * @var        array
	 */
	protected $collProductHasAttributeFields;

	/**
	 * The criteria used to select the current contents of collProductHasAttributeFields.
	 * @var        Criteria
	 */
	protected $lastProductHasAttributeFieldCriteria = null;

	/**
	 * Collection to store aggregation of collDeliverySectionss.
	 * @var        array
	 */
	protected $collDeliverySectionss;

	/**
	 * The criteria used to select the current contents of collDeliverySectionss.
	 * @var        Criteria
	 */
	protected $lastDeliverySectionsCriteria = null;

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
     * Get the [attribute_template_id] column value.
     * 
     * @return     int
     */
    public function getAttributeTemplateId()
    {

            return $this->attribute_template_id;
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
     * Get the [rank] column value.
     * 
     * @return     int
     */
    public function getRank()
    {

            return $this->rank;
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
			$this->modifiedColumns[] = AttributeFieldPeer::CREATED_AT;
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
			$this->modifiedColumns[] = AttributeFieldPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = AttributeFieldPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [attribute_template_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setAttributeTemplateId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->attribute_template_id !== $v) {
          $this->attribute_template_id = $v;
          $this->modifiedColumns[] = AttributeFieldPeer::ATTRIBUTE_TEMPLATE_ID;
        }

		if ($this->aAttributeTemplate !== null && $this->aAttributeTemplate->getId() !== $v) {
			$this->aAttributeTemplate = null;
		}

	} // setAttributeTemplateId()

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
          $this->modifiedColumns[] = AttributeFieldPeer::NAME;
        }

	} // setName()

	/**
	 * Set the value of [rank] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setRank($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->rank !== $v) {
          $this->rank = $v;
          $this->modifiedColumns[] = AttributeFieldPeer::RANK;
        }

	} // setRank()

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
      if ($this->getDispatcher()->getListeners('AttributeField.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'AttributeField.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->attribute_template_id = $rs->getInt($startcol + 3);

      $this->name = $rs->getString($startcol + 4);

      $this->rank = $rs->getInt($startcol + 5);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('AttributeField.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'AttributeField.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 6)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 6; // 6 = AttributeFieldPeer::NUM_COLUMNS - AttributeFieldPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating AttributeField object", $e);
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

    if ($this->getDispatcher()->getListeners('AttributeField.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'AttributeField.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseAttributeField:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseAttributeField:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(AttributeFieldPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      AttributeFieldPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('AttributeField.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'AttributeField.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseAttributeField:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseAttributeField:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('AttributeField.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'AttributeField.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseAttributeField:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(AttributeFieldPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(AttributeFieldPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(AttributeFieldPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('AttributeField.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'AttributeField.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseAttributeField:save:post') as $callable)
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

			if ($this->aAttributeTemplate !== null) {
				if ($this->aAttributeTemplate->isModified()) {
					$affectedRows += $this->aAttributeTemplate->save($con);
				}
				$this->setAttributeTemplate($this->aAttributeTemplate);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = AttributeFieldPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += AttributeFieldPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collProductHasAttributeFields !== null) {
				foreach($this->collProductHasAttributeFields as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDeliverySectionss !== null) {
				foreach($this->collDeliverySectionss as $referrerFK) {
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

			if ($this->aAttributeTemplate !== null) {
				if (!$this->aAttributeTemplate->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aAttributeTemplate->getValidationFailures());
				}
			}


			if (($retval = AttributeFieldPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collProductHasAttributeFields !== null) {
					foreach($this->collProductHasAttributeFields as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDeliverySectionss !== null) {
					foreach($this->collDeliverySectionss as $referrerFK) {
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
		$pos = AttributeFieldPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getAttributeTemplateId();
				break;
			case 4:
				return $this->getName();
				break;
			case 5:
				return $this->getRank();
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
		$keys = AttributeFieldPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getAttributeTemplateId(),
			$keys[4] => $this->getName(),
			$keys[5] => $this->getRank(),
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
		$pos = AttributeFieldPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setAttributeTemplateId($value);
				break;
			case 4:
				$this->setName($value);
				break;
			case 5:
				$this->setRank($value);
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
		$keys = AttributeFieldPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setAttributeTemplateId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setRank($arr[$keys[5]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(AttributeFieldPeer::DATABASE_NAME);

		if ($this->isColumnModified(AttributeFieldPeer::CREATED_AT)) $criteria->add(AttributeFieldPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(AttributeFieldPeer::UPDATED_AT)) $criteria->add(AttributeFieldPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(AttributeFieldPeer::ID)) $criteria->add(AttributeFieldPeer::ID, $this->id);
		if ($this->isColumnModified(AttributeFieldPeer::ATTRIBUTE_TEMPLATE_ID)) $criteria->add(AttributeFieldPeer::ATTRIBUTE_TEMPLATE_ID, $this->attribute_template_id);
		if ($this->isColumnModified(AttributeFieldPeer::NAME)) $criteria->add(AttributeFieldPeer::NAME, $this->name);
		if ($this->isColumnModified(AttributeFieldPeer::RANK)) $criteria->add(AttributeFieldPeer::RANK, $this->rank);

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
		$criteria = new Criteria(AttributeFieldPeer::DATABASE_NAME);

		$criteria->add(AttributeFieldPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of AttributeField (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setAttributeTemplateId($this->attribute_template_id);

		$copyObj->setName($this->name);

		$copyObj->setRank($this->rank);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getProductHasAttributeFields() as $relObj) {
				$copyObj->addProductHasAttributeField($relObj->copy($deepCopy));
			}

			foreach($this->getDeliverySectionss() as $relObj) {
				$copyObj->addDeliverySections($relObj->copy($deepCopy));
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
	 * @return     AttributeField Clone of current object.
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
	 * @return     AttributeFieldPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new AttributeFieldPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a AttributeTemplate object.
	 *
	 * @param      AttributeTemplate $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setAttributeTemplate($v)
	{


		if ($v === null) {
			$this->setAttributeTemplateId(NULL);
		} else {
			$this->setAttributeTemplateId($v->getId());
		}


		$this->aAttributeTemplate = $v;
	}


	/**
	 * Get the associated AttributeTemplate object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     AttributeTemplate The associated AttributeTemplate object.
	 * @throws     PropelException
	 */
	public function getAttributeTemplate($con = null)
	{
		if ($this->aAttributeTemplate === null && ($this->attribute_template_id !== null)) {
			// include the related Peer class
			$this->aAttributeTemplate = AttributeTemplatePeer::retrieveByPK($this->attribute_template_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = AttributeTemplatePeer::retrieveByPK($this->attribute_template_id, $con);
			   $obj->addAttributeTemplates($this);
			 */
		}
		return $this->aAttributeTemplate;
	}

	/**
	 * Temporary storage of collProductHasAttributeFields to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductHasAttributeFields()
	{
		if ($this->collProductHasAttributeFields === null) {
			$this->collProductHasAttributeFields = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this AttributeField has previously
	 * been saved, it will retrieve related ProductHasAttributeFields from storage.
	 * If this AttributeField is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductHasAttributeFields($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasAttributeFields === null) {
			if ($this->isNew()) {
			   $this->collProductHasAttributeFields = array();
			} else {

				$criteria->add(ProductHasAttributeFieldPeer::ATTRIBUTE_FIELD_ID, $this->getId());

				ProductHasAttributeFieldPeer::addSelectColumns($criteria);
				$this->collProductHasAttributeFields = ProductHasAttributeFieldPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasAttributeFieldPeer::ATTRIBUTE_FIELD_ID, $this->getId());

				ProductHasAttributeFieldPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductHasAttributeFieldCriteria) || !$this->lastProductHasAttributeFieldCriteria->equals($criteria)) {
					$this->collProductHasAttributeFields = ProductHasAttributeFieldPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductHasAttributeFieldCriteria = $criteria;
		return $this->collProductHasAttributeFields;
	}

	/**
	 * Returns the number of related ProductHasAttributeFields.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductHasAttributeFields($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductHasAttributeFieldPeer::ATTRIBUTE_FIELD_ID, $this->getId());

		return ProductHasAttributeFieldPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductHasAttributeField object to this object
	 * through the ProductHasAttributeField foreign key attribute
	 *
	 * @param      ProductHasAttributeField $l ProductHasAttributeField
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductHasAttributeField(ProductHasAttributeField $l)
	{
		$this->collProductHasAttributeFields[] = $l;
		$l->setAttributeField($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this AttributeField is new, it will return
	 * an empty collection; or if this AttributeField has previously
	 * been saved, it will retrieve related ProductHasAttributeFields from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in AttributeField.
	 */
	public function getProductHasAttributeFieldsJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasAttributeFields === null) {
			if ($this->isNew()) {
				$this->collProductHasAttributeFields = array();
			} else {

				$criteria->add(ProductHasAttributeFieldPeer::ATTRIBUTE_FIELD_ID, $this->getId());

				$this->collProductHasAttributeFields = ProductHasAttributeFieldPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductHasAttributeFieldPeer::ATTRIBUTE_FIELD_ID, $this->getId());

			if (!isset($this->lastProductHasAttributeFieldCriteria) || !$this->lastProductHasAttributeFieldCriteria->equals($criteria)) {
				$this->collProductHasAttributeFields = ProductHasAttributeFieldPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastProductHasAttributeFieldCriteria = $criteria;

		return $this->collProductHasAttributeFields;
	}

	/**
	 * Temporary storage of collDeliverySectionss to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDeliverySectionss()
	{
		if ($this->collDeliverySectionss === null) {
			$this->collDeliverySectionss = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this AttributeField has previously
	 * been saved, it will retrieve related DeliverySectionss from storage.
	 * If this AttributeField is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDeliverySectionss($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDeliverySectionss === null) {
			if ($this->isNew()) {
			   $this->collDeliverySectionss = array();
			} else {

				$criteria->add(DeliverySectionsPeer::ATTRIBUTE_FIELD_ID, $this->getId());

				DeliverySectionsPeer::addSelectColumns($criteria);
				$this->collDeliverySectionss = DeliverySectionsPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DeliverySectionsPeer::ATTRIBUTE_FIELD_ID, $this->getId());

				DeliverySectionsPeer::addSelectColumns($criteria);
				if (!isset($this->lastDeliverySectionsCriteria) || !$this->lastDeliverySectionsCriteria->equals($criteria)) {
					$this->collDeliverySectionss = DeliverySectionsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDeliverySectionsCriteria = $criteria;
		return $this->collDeliverySectionss;
	}

	/**
	 * Returns the number of related DeliverySectionss.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDeliverySectionss($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DeliverySectionsPeer::ATTRIBUTE_FIELD_ID, $this->getId());

		return DeliverySectionsPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DeliverySections object to this object
	 * through the DeliverySections foreign key attribute
	 *
	 * @param      DeliverySections $l DeliverySections
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDeliverySections(DeliverySections $l)
	{
		$this->collDeliverySectionss[] = $l;
		$l->setAttributeField($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this AttributeField is new, it will return
	 * an empty collection; or if this AttributeField has previously
	 * been saved, it will retrieve related DeliverySectionss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in AttributeField.
	 */
	public function getDeliverySectionssJoinDelivery($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDeliverySectionss === null) {
			if ($this->isNew()) {
				$this->collDeliverySectionss = array();
			} else {

				$criteria->add(DeliverySectionsPeer::ATTRIBUTE_FIELD_ID, $this->getId());

				$this->collDeliverySectionss = DeliverySectionsPeer::doSelectJoinDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DeliverySectionsPeer::ATTRIBUTE_FIELD_ID, $this->getId());

			if (!isset($this->lastDeliverySectionsCriteria) || !$this->lastDeliverySectionsCriteria->equals($criteria)) {
				$this->collDeliverySectionss = DeliverySectionsPeer::doSelectJoinDelivery($criteria, $con);
			}
		}
		$this->lastDeliverySectionsCriteria = $criteria;

		return $this->collDeliverySectionss;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'AttributeField.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseAttributeField:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseAttributeField::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseAttributeField
