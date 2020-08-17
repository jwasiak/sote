<?php

/**
 * Base class that represents a row from the 'st_export_field' table.
 *
 * 
 *
 * @package    plugins.stImportExportPlugin.lib.model.om
 */
abstract class BaseExportField extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ExportFieldPeer
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
	 * The value for the field field.
	 * @var        string
	 */
	protected $field;


	/**
	 * The value for the model field.
	 * @var        string
	 */
	protected $model;


	/**
	 * The value for the is_key field.
	 * @var        int
	 */
	protected $is_key;


	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the i18n_file field.
	 * @var        string
	 */
	protected $i18n_file;


	/**
	 * The value for the i18n field.
	 * @var        boolean
	 */
	protected $i18n;

	/**
	 * Collection to store aggregation of collExportProfileHasExportFields.
	 * @var        array
	 */
	protected $collExportProfileHasExportFields;

	/**
	 * The criteria used to select the current contents of collExportProfileHasExportFields.
	 * @var        Criteria
	 */
	protected $lastExportProfileHasExportFieldCriteria = null;

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
     * Get the [field] column value.
     * 
     * @return     string
     */
    public function getField()
    {

            return $this->field;
    }

    /**
     * Get the [model] column value.
     * 
     * @return     string
     */
    public function getModel()
    {

            return $this->model;
    }

    /**
     * Get the [is_key] column value.
     * 
     * @return     int
     */
    public function getIsKey()
    {

            return $this->is_key;
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
     * Get the [i18n_file] column value.
     * 
     * @return     string
     */
    public function getI18nFile()
    {

            return $this->i18n_file;
    }

    /**
     * Get the [i18n] column value.
     * 
     * @return     boolean
     */
    public function getI18n()
    {

            return $this->i18n;
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
			$this->modifiedColumns[] = ExportFieldPeer::CREATED_AT;
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
			$this->modifiedColumns[] = ExportFieldPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = ExportFieldPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [field] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setField($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->field !== $v) {
          $this->field = $v;
          $this->modifiedColumns[] = ExportFieldPeer::FIELD;
        }

	} // setField()

	/**
	 * Set the value of [model] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setModel($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->model !== $v) {
          $this->model = $v;
          $this->modifiedColumns[] = ExportFieldPeer::MODEL;
        }

	} // setModel()

	/**
	 * Set the value of [is_key] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setIsKey($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->is_key !== $v) {
          $this->is_key = $v;
          $this->modifiedColumns[] = ExportFieldPeer::IS_KEY;
        }

	} // setIsKey()

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
          $this->modifiedColumns[] = ExportFieldPeer::NAME;
        }

	} // setName()

	/**
	 * Set the value of [i18n_file] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setI18nFile($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->i18n_file !== $v) {
          $this->i18n_file = $v;
          $this->modifiedColumns[] = ExportFieldPeer::I18N_FILE;
        }

	} // setI18nFile()

	/**
	 * Set the value of [i18n] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setI18n($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->i18n !== $v) {
          $this->i18n = $v;
          $this->modifiedColumns[] = ExportFieldPeer::I18N;
        }

	} // setI18n()

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
      if ($this->getDispatcher()->getListeners('ExportField.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ExportField.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->field = $rs->getString($startcol + 3);

      $this->model = $rs->getString($startcol + 4);

      $this->is_key = $rs->getInt($startcol + 5);

      $this->name = $rs->getString($startcol + 6);

      $this->i18n_file = $rs->getString($startcol + 7);

      $this->i18n = $rs->getBoolean($startcol + 8);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('ExportField.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ExportField.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 9)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 9; // 9 = ExportFieldPeer::NUM_COLUMNS - ExportFieldPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating ExportField object", $e);
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

    if ($this->getDispatcher()->getListeners('ExportField.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ExportField.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseExportField:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseExportField:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ExportFieldPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ExportFieldPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('ExportField.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ExportField.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseExportField:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseExportField:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('ExportField.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'ExportField.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseExportField:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(ExportFieldPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ExportFieldPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(ExportFieldPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('ExportField.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'ExportField.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseExportField:save:post') as $callable)
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
					$pk = ExportFieldPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ExportFieldPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collExportProfileHasExportFields !== null) {
				foreach($this->collExportProfileHasExportFields as $referrerFK) {
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


			if (($retval = ExportFieldPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collExportProfileHasExportFields !== null) {
					foreach($this->collExportProfileHasExportFields as $referrerFK) {
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
		$pos = ExportFieldPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getField();
				break;
			case 4:
				return $this->getModel();
				break;
			case 5:
				return $this->getIsKey();
				break;
			case 6:
				return $this->getName();
				break;
			case 7:
				return $this->getI18nFile();
				break;
			case 8:
				return $this->getI18n();
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
		$keys = ExportFieldPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getField(),
			$keys[4] => $this->getModel(),
			$keys[5] => $this->getIsKey(),
			$keys[6] => $this->getName(),
			$keys[7] => $this->getI18nFile(),
			$keys[8] => $this->getI18n(),
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
		$pos = ExportFieldPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setField($value);
				break;
			case 4:
				$this->setModel($value);
				break;
			case 5:
				$this->setIsKey($value);
				break;
			case 6:
				$this->setName($value);
				break;
			case 7:
				$this->setI18nFile($value);
				break;
			case 8:
				$this->setI18n($value);
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
		$keys = ExportFieldPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setField($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setModel($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setIsKey($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setName($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setI18nFile($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setI18n($arr[$keys[8]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ExportFieldPeer::DATABASE_NAME);

		if ($this->isColumnModified(ExportFieldPeer::CREATED_AT)) $criteria->add(ExportFieldPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ExportFieldPeer::UPDATED_AT)) $criteria->add(ExportFieldPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(ExportFieldPeer::ID)) $criteria->add(ExportFieldPeer::ID, $this->id);
		if ($this->isColumnModified(ExportFieldPeer::FIELD)) $criteria->add(ExportFieldPeer::FIELD, $this->field);
		if ($this->isColumnModified(ExportFieldPeer::MODEL)) $criteria->add(ExportFieldPeer::MODEL, $this->model);
		if ($this->isColumnModified(ExportFieldPeer::IS_KEY)) $criteria->add(ExportFieldPeer::IS_KEY, $this->is_key);
		if ($this->isColumnModified(ExportFieldPeer::NAME)) $criteria->add(ExportFieldPeer::NAME, $this->name);
		if ($this->isColumnModified(ExportFieldPeer::I18N_FILE)) $criteria->add(ExportFieldPeer::I18N_FILE, $this->i18n_file);
		if ($this->isColumnModified(ExportFieldPeer::I18N)) $criteria->add(ExportFieldPeer::I18N, $this->i18n);

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
		$criteria = new Criteria(ExportFieldPeer::DATABASE_NAME);

		$criteria->add(ExportFieldPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of ExportField (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setField($this->field);

		$copyObj->setModel($this->model);

		$copyObj->setIsKey($this->is_key);

		$copyObj->setName($this->name);

		$copyObj->setI18nFile($this->i18n_file);

		$copyObj->setI18n($this->i18n);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getExportProfileHasExportFields() as $relObj) {
				$copyObj->addExportProfileHasExportField($relObj->copy($deepCopy));
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
	 * @return     ExportField Clone of current object.
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
	 * @return     ExportFieldPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ExportFieldPeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collExportProfileHasExportFields to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initExportProfileHasExportFields()
	{
		if ($this->collExportProfileHasExportFields === null) {
			$this->collExportProfileHasExportFields = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ExportField has previously
	 * been saved, it will retrieve related ExportProfileHasExportFields from storage.
	 * If this ExportField is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getExportProfileHasExportFields($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collExportProfileHasExportFields === null) {
			if ($this->isNew()) {
			   $this->collExportProfileHasExportFields = array();
			} else {

				$criteria->add(ExportProfileHasExportFieldPeer::EXPORT_FIELD_ID, $this->getId());

				ExportProfileHasExportFieldPeer::addSelectColumns($criteria);
				$this->collExportProfileHasExportFields = ExportProfileHasExportFieldPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ExportProfileHasExportFieldPeer::EXPORT_FIELD_ID, $this->getId());

				ExportProfileHasExportFieldPeer::addSelectColumns($criteria);
				if (!isset($this->lastExportProfileHasExportFieldCriteria) || !$this->lastExportProfileHasExportFieldCriteria->equals($criteria)) {
					$this->collExportProfileHasExportFields = ExportProfileHasExportFieldPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastExportProfileHasExportFieldCriteria = $criteria;
		return $this->collExportProfileHasExportFields;
	}

	/**
	 * Returns the number of related ExportProfileHasExportFields.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countExportProfileHasExportFields($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ExportProfileHasExportFieldPeer::EXPORT_FIELD_ID, $this->getId());

		return ExportProfileHasExportFieldPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ExportProfileHasExportField object to this object
	 * through the ExportProfileHasExportField foreign key attribute
	 *
	 * @param      ExportProfileHasExportField $l ExportProfileHasExportField
	 * @return     void
	 * @throws     PropelException
	 */
	public function addExportProfileHasExportField(ExportProfileHasExportField $l)
	{
		$this->collExportProfileHasExportFields[] = $l;
		$l->setExportField($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ExportField is new, it will return
	 * an empty collection; or if this ExportField has previously
	 * been saved, it will retrieve related ExportProfileHasExportFields from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ExportField.
	 */
	public function getExportProfileHasExportFieldsJoinExportProfile($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collExportProfileHasExportFields === null) {
			if ($this->isNew()) {
				$this->collExportProfileHasExportFields = array();
			} else {

				$criteria->add(ExportProfileHasExportFieldPeer::EXPORT_FIELD_ID, $this->getId());

				$this->collExportProfileHasExportFields = ExportProfileHasExportFieldPeer::doSelectJoinExportProfile($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ExportProfileHasExportFieldPeer::EXPORT_FIELD_ID, $this->getId());

			if (!isset($this->lastExportProfileHasExportFieldCriteria) || !$this->lastExportProfileHasExportFieldCriteria->equals($criteria)) {
				$this->collExportProfileHasExportFields = ExportProfileHasExportFieldPeer::doSelectJoinExportProfile($criteria, $con);
			}
		}
		$this->lastExportProfileHasExportFieldCriteria = $criteria;

		return $this->collExportProfileHasExportFields;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'ExportField.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseExportField:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseExportField::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseExportField
