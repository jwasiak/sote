<?php

/**
 * Base class that represents a row from the 'st_export_profile_has_export_field' table.
 *
 * 
 *
 * @package    plugins.stImportExportPlugin.lib.model.om
 */
abstract class BaseExportProfileHasExportField extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ExportProfileHasExportFieldPeer
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
	 * The value for the export_profile_id field.
	 * @var        int
	 */
	protected $export_profile_id;


	/**
	 * The value for the export_field_id field.
	 * @var        int
	 */
	protected $export_field_id;

	/**
	 * @var        ExportProfile
	 */
	protected $aExportProfile;

	/**
	 * @var        ExportField
	 */
	protected $aExportField;

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
     * Get the [export_profile_id] column value.
     * 
     * @return     int
     */
    public function getExportProfileId()
    {

            return $this->export_profile_id;
    }

    /**
     * Get the [export_field_id] column value.
     * 
     * @return     int
     */
    public function getExportFieldId()
    {

            return $this->export_field_id;
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
			$this->modifiedColumns[] = ExportProfileHasExportFieldPeer::CREATED_AT;
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
			$this->modifiedColumns[] = ExportProfileHasExportFieldPeer::UPDATED_AT;
		}

	} // setUpdatedAt()

	/**
	 * Set the value of [export_profile_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setExportProfileId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->export_profile_id !== $v) {
          $this->export_profile_id = $v;
          $this->modifiedColumns[] = ExportProfileHasExportFieldPeer::EXPORT_PROFILE_ID;
        }

		if ($this->aExportProfile !== null && $this->aExportProfile->getId() !== $v) {
			$this->aExportProfile = null;
		}

	} // setExportProfileId()

	/**
	 * Set the value of [export_field_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setExportFieldId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->export_field_id !== $v) {
          $this->export_field_id = $v;
          $this->modifiedColumns[] = ExportProfileHasExportFieldPeer::EXPORT_FIELD_ID;
        }

		if ($this->aExportField !== null && $this->aExportField->getId() !== $v) {
			$this->aExportField = null;
		}

	} // setExportFieldId()

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
      if ($this->getDispatcher()->getListeners('ExportProfileHasExportField.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ExportProfileHasExportField.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->export_profile_id = $rs->getInt($startcol + 2);

      $this->export_field_id = $rs->getInt($startcol + 3);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('ExportProfileHasExportField.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ExportProfileHasExportField.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 4)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 4; // 4 = ExportProfileHasExportFieldPeer::NUM_COLUMNS - ExportProfileHasExportFieldPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating ExportProfileHasExportField object", $e);
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

    if ($this->getDispatcher()->getListeners('ExportProfileHasExportField.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ExportProfileHasExportField.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseExportProfileHasExportField:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseExportProfileHasExportField:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ExportProfileHasExportFieldPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ExportProfileHasExportFieldPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('ExportProfileHasExportField.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ExportProfileHasExportField.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseExportProfileHasExportField:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseExportProfileHasExportField:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('ExportProfileHasExportField.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'ExportProfileHasExportField.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseExportProfileHasExportField:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(ExportProfileHasExportFieldPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ExportProfileHasExportFieldPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(ExportProfileHasExportFieldPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('ExportProfileHasExportField.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'ExportProfileHasExportField.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseExportProfileHasExportField:save:post') as $callable)
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

			if ($this->aExportProfile !== null) {
				if ($this->aExportProfile->isModified()) {
					$affectedRows += $this->aExportProfile->save($con);
				}
				$this->setExportProfile($this->aExportProfile);
			}

			if ($this->aExportField !== null) {
				if ($this->aExportField->isModified()) {
					$affectedRows += $this->aExportField->save($con);
				}
				$this->setExportField($this->aExportField);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ExportProfileHasExportFieldPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += ExportProfileHasExportFieldPeer::doUpdate($this, $con);
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

			if ($this->aExportProfile !== null) {
				if (!$this->aExportProfile->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aExportProfile->getValidationFailures());
				}
			}

			if ($this->aExportField !== null) {
				if (!$this->aExportField->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aExportField->getValidationFailures());
				}
			}


			if (($retval = ExportProfileHasExportFieldPeer::doValidate($this, $columns)) !== true) {
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
		$pos = ExportProfileHasExportFieldPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getExportProfileId();
				break;
			case 3:
				return $this->getExportFieldId();
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
		$keys = ExportProfileHasExportFieldPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getExportProfileId(),
			$keys[3] => $this->getExportFieldId(),
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
		$pos = ExportProfileHasExportFieldPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setExportProfileId($value);
				break;
			case 3:
				$this->setExportFieldId($value);
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
		$keys = ExportProfileHasExportFieldPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setExportProfileId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setExportFieldId($arr[$keys[3]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ExportProfileHasExportFieldPeer::DATABASE_NAME);

		if ($this->isColumnModified(ExportProfileHasExportFieldPeer::CREATED_AT)) $criteria->add(ExportProfileHasExportFieldPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ExportProfileHasExportFieldPeer::UPDATED_AT)) $criteria->add(ExportProfileHasExportFieldPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(ExportProfileHasExportFieldPeer::EXPORT_PROFILE_ID)) $criteria->add(ExportProfileHasExportFieldPeer::EXPORT_PROFILE_ID, $this->export_profile_id);
		if ($this->isColumnModified(ExportProfileHasExportFieldPeer::EXPORT_FIELD_ID)) $criteria->add(ExportProfileHasExportFieldPeer::EXPORT_FIELD_ID, $this->export_field_id);

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
		$criteria = new Criteria(ExportProfileHasExportFieldPeer::DATABASE_NAME);

		$criteria->add(ExportProfileHasExportFieldPeer::EXPORT_PROFILE_ID, $this->export_profile_id);
		$criteria->add(ExportProfileHasExportFieldPeer::EXPORT_FIELD_ID, $this->export_field_id);

		return $criteria;
	}

	/**
	 * Returns the composite primary key for this object.
	 * The array elements will be in same order as specified in XML.
	 * @return     array
	 */
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getExportProfileId();

		$pks[1] = $this->getExportFieldId();

		return $pks;
	}

	/**
	 * Set the [composite] primary key.
	 *
	 * @param      array $keys The elements of the composite key (order must match the order in XML file).
	 * @return     void
	 */
	public function setPrimaryKey($keys)
	{

		$this->setExportProfileId($keys[0]);

		$this->setExportFieldId($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of ExportProfileHasExportField (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		$copyObj->setNew(true);

		$copyObj->setExportProfileId(NULL); // this is a pkey column, so set to default value

		$copyObj->setExportFieldId(NULL); // this is a pkey column, so set to default value

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
	 * @return     ExportProfileHasExportField Clone of current object.
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
	 * @return     ExportProfileHasExportFieldPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ExportProfileHasExportFieldPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a ExportProfile object.
	 *
	 * @param      ExportProfile $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setExportProfile($v)
	{


		if ($v === null) {
			$this->setExportProfileId(NULL);
		} else {
			$this->setExportProfileId($v->getId());
		}


		$this->aExportProfile = $v;
	}


	/**
	 * Get the associated ExportProfile object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     ExportProfile The associated ExportProfile object.
	 * @throws     PropelException
	 */
	public function getExportProfile($con = null)
	{
		if ($this->aExportProfile === null && ($this->export_profile_id !== null)) {
			// include the related Peer class
			$this->aExportProfile = ExportProfilePeer::retrieveByPK($this->export_profile_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ExportProfilePeer::retrieveByPK($this->export_profile_id, $con);
			   $obj->addExportProfiles($this);
			 */
		}
		return $this->aExportProfile;
	}

	/**
	 * Declares an association between this object and a ExportField object.
	 *
	 * @param      ExportField $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setExportField($v)
	{


		if ($v === null) {
			$this->setExportFieldId(NULL);
		} else {
			$this->setExportFieldId($v->getId());
		}


		$this->aExportField = $v;
	}


	/**
	 * Get the associated ExportField object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     ExportField The associated ExportField object.
	 * @throws     PropelException
	 */
	public function getExportField($con = null)
	{
		if ($this->aExportField === null && ($this->export_field_id !== null)) {
			// include the related Peer class
			$this->aExportField = ExportFieldPeer::retrieveByPK($this->export_field_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ExportFieldPeer::retrieveByPK($this->export_field_id, $con);
			   $obj->addExportFields($this);
			 */
		}
		return $this->aExportField;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'ExportProfileHasExportField.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseExportProfileHasExportField:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseExportProfileHasExportField::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseExportProfileHasExportField
