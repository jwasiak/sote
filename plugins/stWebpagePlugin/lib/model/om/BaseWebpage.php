<?php

/**
 * Base class that represents a row from the 'st_webpage' table.
 *
 * 
 *
 * @package    plugins.stWebpagePlugin.lib.model.om
 */
abstract class BaseWebpage extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        WebpagePeer
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
	 * The value for the active field.
	 * @var        boolean
	 */
	protected $active = true;


	/**
	 * The value for the opt_name field.
	 * @var        string
	 */
	protected $opt_name;


	/**
	 * The value for the opt_content field.
	 * @var        string
	 */
	protected $opt_content;


	/**
	 * The value for the opt_url field.
	 * @var        string
	 */
	protected $opt_url;


	/**
	 * The value for the state field.
	 * @var        string
	 */
	protected $state;

	/**
	 * Collection to store aggregation of collWebpageGroupHasWebpages.
	 * @var        array
	 */
	protected $collWebpageGroupHasWebpages;

	/**
	 * The criteria used to select the current contents of collWebpageGroupHasWebpages.
	 * @var        Criteria
	 */
	protected $lastWebpageGroupHasWebpageCriteria = null;

	/**
	 * Collection to store aggregation of collWebpageI18ns.
	 * @var        array
	 */
	protected $collWebpageI18ns;

	/**
	 * The criteria used to select the current contents of collWebpageI18ns.
	 * @var        Criteria
	 */
	protected $lastWebpageI18nCriteria = null;

	/**
	 * Collection to store aggregation of collWebpageHasPositionings.
	 * @var        array
	 */
	protected $collWebpageHasPositionings;

	/**
	 * The criteria used to select the current contents of collWebpageHasPositionings.
	 * @var        Criteria
	 */
	protected $lastWebpageHasPositioningCriteria = null;

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
     * Get the [active] column value.
     * 
     * @return     boolean
     */
    public function getActive()
    {

            return $this->active;
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
     * Get the [opt_content] column value.
     * 
     * @return     string
     */
    public function getOptContent()
    {

            return $this->opt_content;
    }

    /**
     * Get the [opt_url] column value.
     * 
     * @return     string
     */
    public function getOptUrl()
    {

            return $this->opt_url;
    }

    /**
     * Get the [state] column value.
     * 
     * @return     string
     */
    public function getState()
    {

            return $this->state;
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
			$this->modifiedColumns[] = WebpagePeer::CREATED_AT;
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
			$this->modifiedColumns[] = WebpagePeer::UPDATED_AT;
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
          $this->modifiedColumns[] = WebpagePeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [active] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setActive($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->active !== $v || $v === true) {
          $this->active = $v;
          $this->modifiedColumns[] = WebpagePeer::ACTIVE;
        }

	} // setActive()

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
          $this->modifiedColumns[] = WebpagePeer::OPT_NAME;
        }

	} // setOptName()

	/**
	 * Set the value of [opt_content] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptContent($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_content !== $v) {
          $this->opt_content = $v;
          $this->modifiedColumns[] = WebpagePeer::OPT_CONTENT;
        }

	} // setOptContent()

	/**
	 * Set the value of [opt_url] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptUrl($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_url !== $v) {
          $this->opt_url = $v;
          $this->modifiedColumns[] = WebpagePeer::OPT_URL;
        }

	} // setOptUrl()

	/**
	 * Set the value of [state] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setState($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->state !== $v) {
          $this->state = $v;
          $this->modifiedColumns[] = WebpagePeer::STATE;
        }

	} // setState()

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
      if ($this->getDispatcher()->getListeners('Webpage.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Webpage.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->active = $rs->getBoolean($startcol + 3);

      $this->opt_name = $rs->getString($startcol + 4);

      $this->opt_content = $rs->getString($startcol + 5);

      $this->opt_url = $rs->getString($startcol + 6);

      $this->state = $rs->getString($startcol + 7);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Webpage.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Webpage.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 8)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 8; // 8 = WebpagePeer::NUM_COLUMNS - WebpagePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Webpage object", $e);
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

    if ($this->getDispatcher()->getListeners('Webpage.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Webpage.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseWebpage:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseWebpage:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(WebpagePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      WebpagePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Webpage.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Webpage.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseWebpage:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseWebpage:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Webpage.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Webpage.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseWebpage:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(WebpagePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(WebpagePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(WebpagePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Webpage.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Webpage.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseWebpage:save:post') as $callable)
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
					$pk = WebpagePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += WebpagePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collWebpageGroupHasWebpages !== null) {
				foreach($this->collWebpageGroupHasWebpages as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collWebpageI18ns !== null) {
				foreach($this->collWebpageI18ns as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collWebpageHasPositionings !== null) {
				foreach($this->collWebpageHasPositionings as $referrerFK) {
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


			if (($retval = WebpagePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collWebpageGroupHasWebpages !== null) {
					foreach($this->collWebpageGroupHasWebpages as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collWebpageI18ns !== null) {
					foreach($this->collWebpageI18ns as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collWebpageHasPositionings !== null) {
					foreach($this->collWebpageHasPositionings as $referrerFK) {
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
		$pos = WebpagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getActive();
				break;
			case 4:
				return $this->getOptName();
				break;
			case 5:
				return $this->getOptContent();
				break;
			case 6:
				return $this->getOptUrl();
				break;
			case 7:
				return $this->getState();
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
		$keys = WebpagePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getActive(),
			$keys[4] => $this->getOptName(),
			$keys[5] => $this->getOptContent(),
			$keys[6] => $this->getOptUrl(),
			$keys[7] => $this->getState(),
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
		$pos = WebpagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setActive($value);
				break;
			case 4:
				$this->setOptName($value);
				break;
			case 5:
				$this->setOptContent($value);
				break;
			case 6:
				$this->setOptUrl($value);
				break;
			case 7:
				$this->setState($value);
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
		$keys = WebpagePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setActive($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setOptName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOptContent($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setOptUrl($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setState($arr[$keys[7]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(WebpagePeer::DATABASE_NAME);

		if ($this->isColumnModified(WebpagePeer::CREATED_AT)) $criteria->add(WebpagePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(WebpagePeer::UPDATED_AT)) $criteria->add(WebpagePeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(WebpagePeer::ID)) $criteria->add(WebpagePeer::ID, $this->id);
		if ($this->isColumnModified(WebpagePeer::ACTIVE)) $criteria->add(WebpagePeer::ACTIVE, $this->active);
		if ($this->isColumnModified(WebpagePeer::OPT_NAME)) $criteria->add(WebpagePeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(WebpagePeer::OPT_CONTENT)) $criteria->add(WebpagePeer::OPT_CONTENT, $this->opt_content);
		if ($this->isColumnModified(WebpagePeer::OPT_URL)) $criteria->add(WebpagePeer::OPT_URL, $this->opt_url);
		if ($this->isColumnModified(WebpagePeer::STATE)) $criteria->add(WebpagePeer::STATE, $this->state);

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
		$criteria = new Criteria(WebpagePeer::DATABASE_NAME);

		$criteria->add(WebpagePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Webpage (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setActive($this->active);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setOptContent($this->opt_content);

		$copyObj->setOptUrl($this->opt_url);

		$copyObj->setState($this->state);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getWebpageGroupHasWebpages() as $relObj) {
				$copyObj->addWebpageGroupHasWebpage($relObj->copy($deepCopy));
			}

			foreach($this->getWebpageI18ns() as $relObj) {
				$copyObj->addWebpageI18n($relObj->copy($deepCopy));
			}

			foreach($this->getWebpageHasPositionings() as $relObj) {
				$copyObj->addWebpageHasPositioning($relObj->copy($deepCopy));
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
	 * @return     Webpage Clone of current object.
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
	 * @return     WebpagePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new WebpagePeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collWebpageGroupHasWebpages to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initWebpageGroupHasWebpages()
	{
		if ($this->collWebpageGroupHasWebpages === null) {
			$this->collWebpageGroupHasWebpages = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Webpage has previously
	 * been saved, it will retrieve related WebpageGroupHasWebpages from storage.
	 * If this Webpage is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getWebpageGroupHasWebpages($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collWebpageGroupHasWebpages === null) {
			if ($this->isNew()) {
			   $this->collWebpageGroupHasWebpages = array();
			} else {

				$criteria->add(WebpageGroupHasWebpagePeer::WEBPAGE_ID, $this->getId());

				WebpageGroupHasWebpagePeer::addSelectColumns($criteria);
				$this->collWebpageGroupHasWebpages = WebpageGroupHasWebpagePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(WebpageGroupHasWebpagePeer::WEBPAGE_ID, $this->getId());

				WebpageGroupHasWebpagePeer::addSelectColumns($criteria);
				if (!isset($this->lastWebpageGroupHasWebpageCriteria) || !$this->lastWebpageGroupHasWebpageCriteria->equals($criteria)) {
					$this->collWebpageGroupHasWebpages = WebpageGroupHasWebpagePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastWebpageGroupHasWebpageCriteria = $criteria;
		return $this->collWebpageGroupHasWebpages;
	}

	/**
	 * Returns the number of related WebpageGroupHasWebpages.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countWebpageGroupHasWebpages($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(WebpageGroupHasWebpagePeer::WEBPAGE_ID, $this->getId());

		return WebpageGroupHasWebpagePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a WebpageGroupHasWebpage object to this object
	 * through the WebpageGroupHasWebpage foreign key attribute
	 *
	 * @param      WebpageGroupHasWebpage $l WebpageGroupHasWebpage
	 * @return     void
	 * @throws     PropelException
	 */
	public function addWebpageGroupHasWebpage(WebpageGroupHasWebpage $l)
	{
		$this->collWebpageGroupHasWebpages[] = $l;
		$l->setWebpage($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Webpage is new, it will return
	 * an empty collection; or if this Webpage has previously
	 * been saved, it will retrieve related WebpageGroupHasWebpages from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Webpage.
	 */
	public function getWebpageGroupHasWebpagesJoinWebpageGroup($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collWebpageGroupHasWebpages === null) {
			if ($this->isNew()) {
				$this->collWebpageGroupHasWebpages = array();
			} else {

				$criteria->add(WebpageGroupHasWebpagePeer::WEBPAGE_ID, $this->getId());

				$this->collWebpageGroupHasWebpages = WebpageGroupHasWebpagePeer::doSelectJoinWebpageGroup($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(WebpageGroupHasWebpagePeer::WEBPAGE_ID, $this->getId());

			if (!isset($this->lastWebpageGroupHasWebpageCriteria) || !$this->lastWebpageGroupHasWebpageCriteria->equals($criteria)) {
				$this->collWebpageGroupHasWebpages = WebpageGroupHasWebpagePeer::doSelectJoinWebpageGroup($criteria, $con);
			}
		}
		$this->lastWebpageGroupHasWebpageCriteria = $criteria;

		return $this->collWebpageGroupHasWebpages;
	}

	/**
	 * Temporary storage of collWebpageI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initWebpageI18ns()
	{
		if ($this->collWebpageI18ns === null) {
			$this->collWebpageI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Webpage has previously
	 * been saved, it will retrieve related WebpageI18ns from storage.
	 * If this Webpage is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getWebpageI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collWebpageI18ns === null) {
			if ($this->isNew()) {
			   $this->collWebpageI18ns = array();
			} else {

				$criteria->add(WebpageI18nPeer::ID, $this->getId());

				WebpageI18nPeer::addSelectColumns($criteria);
				$this->collWebpageI18ns = WebpageI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(WebpageI18nPeer::ID, $this->getId());

				WebpageI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastWebpageI18nCriteria) || !$this->lastWebpageI18nCriteria->equals($criteria)) {
					$this->collWebpageI18ns = WebpageI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastWebpageI18nCriteria = $criteria;
		return $this->collWebpageI18ns;
	}

	/**
	 * Returns the number of related WebpageI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countWebpageI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(WebpageI18nPeer::ID, $this->getId());

		return WebpageI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a WebpageI18n object to this object
	 * through the WebpageI18n foreign key attribute
	 *
	 * @param      WebpageI18n $l WebpageI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addWebpageI18n(WebpageI18n $l)
	{
		$this->collWebpageI18ns[] = $l;
		$l->setWebpage($this);
	}

	/**
	 * Temporary storage of collWebpageHasPositionings to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initWebpageHasPositionings()
	{
		if ($this->collWebpageHasPositionings === null) {
			$this->collWebpageHasPositionings = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Webpage has previously
	 * been saved, it will retrieve related WebpageHasPositionings from storage.
	 * If this Webpage is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getWebpageHasPositionings($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collWebpageHasPositionings === null) {
			if ($this->isNew()) {
			   $this->collWebpageHasPositionings = array();
			} else {

				$criteria->add(WebpageHasPositioningPeer::WEBPAGE_ID, $this->getId());

				WebpageHasPositioningPeer::addSelectColumns($criteria);
				$this->collWebpageHasPositionings = WebpageHasPositioningPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(WebpageHasPositioningPeer::WEBPAGE_ID, $this->getId());

				WebpageHasPositioningPeer::addSelectColumns($criteria);
				if (!isset($this->lastWebpageHasPositioningCriteria) || !$this->lastWebpageHasPositioningCriteria->equals($criteria)) {
					$this->collWebpageHasPositionings = WebpageHasPositioningPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastWebpageHasPositioningCriteria = $criteria;
		return $this->collWebpageHasPositionings;
	}

	/**
	 * Returns the number of related WebpageHasPositionings.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countWebpageHasPositionings($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(WebpageHasPositioningPeer::WEBPAGE_ID, $this->getId());

		return WebpageHasPositioningPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a WebpageHasPositioning object to this object
	 * through the WebpageHasPositioning foreign key attribute
	 *
	 * @param      WebpageHasPositioning $l WebpageHasPositioning
	 * @return     void
	 * @throws     PropelException
	 */
	public function addWebpageHasPositioning(WebpageHasPositioning $l)
	{
		$this->collWebpageHasPositionings[] = $l;
		$l->setWebpage($this);
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
    $obj = $this->getCurrentWebpageI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentWebpageI18n()->setName($value);
  }

  public function getContent()
  {
    $obj = $this->getCurrentWebpageI18n();

    return ($obj ? $obj->getContent() : null);
  }

  public function setContent($value)
  {
    $this->getCurrentWebpageI18n()->setContent($value);
  }

  public function getUrl()
  {
    $obj = $this->getCurrentWebpageI18n();

    return ($obj ? $obj->getUrl() : null);
  }

  public function setUrl($value)
  {
    $this->getCurrentWebpageI18n()->setUrl($value);
  }

  public function getOtherLink()
  {
    $obj = $this->getCurrentWebpageI18n();

    return ($obj ? $obj->getOtherLink() : null);
  }

  public function setOtherLink($value)
  {
    $this->getCurrentWebpageI18n()->setOtherLink($value);
  }

  public function getTarget()
  {
    $obj = $this->getCurrentWebpageI18n();

    return ($obj ? $obj->getTarget() : null);
  }

  public function setTarget($value)
  {
    $this->getCurrentWebpageI18n()->setTarget($value);
  }

  public $current_i18n = array();

  public function getCurrentWebpageI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = WebpageI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setWebpageI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setWebpageI18nForCulture(new WebpageI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setWebpageI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addWebpageI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Webpage.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseWebpage:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseWebpage::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseWebpage
