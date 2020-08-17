<?php

/**
 * Base class that represents a row from the 'st_box' table.
 *
 * 
 *
 * @package    plugins.stBoxPlugin.lib.model.om
 */
abstract class BaseBox extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        BoxPeer
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
	 * The value for the box_group_id field.
	 * @var        int
	 */
	protected $box_group_id;


	/**
	 * The value for the active field.
	 * @var        boolean
	 */
	protected $active;


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
	 * The value for the show_title field.
	 * @var        boolean
	 */
	protected $show_title;


	/**
	 * The value for the webmaster_id field.
	 * @var        string
	 */
	protected $webmaster_id;

	/**
	 * @var        BoxGroup
	 */
	protected $aBoxGroup;

	/**
	 * Collection to store aggregation of collBoxI18ns.
	 * @var        array
	 */
	protected $collBoxI18ns;

	/**
	 * The criteria used to select the current contents of collBoxI18ns.
	 * @var        Criteria
	 */
	protected $lastBoxI18nCriteria = null;

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
     * Get the [box_group_id] column value.
     * 
     * @return     int
     */
    public function getBoxGroupId()
    {

            return $this->box_group_id;
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
     * Get the [show_title] column value.
     * 
     * @return     boolean
     */
    public function getShowTitle()
    {

            return $this->show_title;
    }

    /**
     * Get the [webmaster_id] column value.
     * 
     * @return     string
     */
    public function getWebmasterId()
    {

            return $this->webmaster_id;
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
			$this->modifiedColumns[] = BoxPeer::CREATED_AT;
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
			$this->modifiedColumns[] = BoxPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = BoxPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [box_group_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setBoxGroupId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->box_group_id !== $v) {
          $this->box_group_id = $v;
          $this->modifiedColumns[] = BoxPeer::BOX_GROUP_ID;
        }

		if ($this->aBoxGroup !== null && $this->aBoxGroup->getId() !== $v) {
			$this->aBoxGroup = null;
		}

	} // setBoxGroupId()

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

        if ($this->active !== $v) {
          $this->active = $v;
          $this->modifiedColumns[] = BoxPeer::ACTIVE;
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
          $this->modifiedColumns[] = BoxPeer::OPT_NAME;
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
          $this->modifiedColumns[] = BoxPeer::OPT_CONTENT;
        }

	} // setOptContent()

	/**
	 * Set the value of [show_title] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setShowTitle($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->show_title !== $v) {
          $this->show_title = $v;
          $this->modifiedColumns[] = BoxPeer::SHOW_TITLE;
        }

	} // setShowTitle()

	/**
	 * Set the value of [webmaster_id] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setWebmasterId($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->webmaster_id !== $v) {
          $this->webmaster_id = $v;
          $this->modifiedColumns[] = BoxPeer::WEBMASTER_ID;
        }

	} // setWebmasterId()

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
      if ($this->getDispatcher()->getListeners('Box.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Box.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->box_group_id = $rs->getInt($startcol + 3);

      $this->active = $rs->getBoolean($startcol + 4);

      $this->opt_name = $rs->getString($startcol + 5);

      $this->opt_content = $rs->getString($startcol + 6);

      $this->show_title = $rs->getBoolean($startcol + 7);

      $this->webmaster_id = $rs->getString($startcol + 8);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Box.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Box.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 9)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 9; // 9 = BoxPeer::NUM_COLUMNS - BoxPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Box object", $e);
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

    if ($this->getDispatcher()->getListeners('Box.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Box.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseBox:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseBox:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(BoxPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      BoxPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Box.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Box.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseBox:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseBox:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Box.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Box.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseBox:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(BoxPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(BoxPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(BoxPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Box.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Box.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseBox:save:post') as $callable)
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

			if ($this->aBoxGroup !== null) {
				if ($this->aBoxGroup->isModified() || $this->aBoxGroup->getCurrentBoxGroupI18n()->isModified()) {
					$affectedRows += $this->aBoxGroup->save($con);
				}
				$this->setBoxGroup($this->aBoxGroup);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = BoxPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += BoxPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collBoxI18ns !== null) {
				foreach($this->collBoxI18ns as $referrerFK) {
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

			if ($this->aBoxGroup !== null) {
				if (!$this->aBoxGroup->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aBoxGroup->getValidationFailures());
				}
			}


			if (($retval = BoxPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collBoxI18ns !== null) {
					foreach($this->collBoxI18ns as $referrerFK) {
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
		$pos = BoxPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getBoxGroupId();
				break;
			case 4:
				return $this->getActive();
				break;
			case 5:
				return $this->getOptName();
				break;
			case 6:
				return $this->getOptContent();
				break;
			case 7:
				return $this->getShowTitle();
				break;
			case 8:
				return $this->getWebmasterId();
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
		$keys = BoxPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getBoxGroupId(),
			$keys[4] => $this->getActive(),
			$keys[5] => $this->getOptName(),
			$keys[6] => $this->getOptContent(),
			$keys[7] => $this->getShowTitle(),
			$keys[8] => $this->getWebmasterId(),
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
		$pos = BoxPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setBoxGroupId($value);
				break;
			case 4:
				$this->setActive($value);
				break;
			case 5:
				$this->setOptName($value);
				break;
			case 6:
				$this->setOptContent($value);
				break;
			case 7:
				$this->setShowTitle($value);
				break;
			case 8:
				$this->setWebmasterId($value);
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
		$keys = BoxPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setBoxGroupId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setActive($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOptName($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setOptContent($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setShowTitle($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setWebmasterId($arr[$keys[8]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(BoxPeer::DATABASE_NAME);

		if ($this->isColumnModified(BoxPeer::CREATED_AT)) $criteria->add(BoxPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(BoxPeer::UPDATED_AT)) $criteria->add(BoxPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(BoxPeer::ID)) $criteria->add(BoxPeer::ID, $this->id);
		if ($this->isColumnModified(BoxPeer::BOX_GROUP_ID)) $criteria->add(BoxPeer::BOX_GROUP_ID, $this->box_group_id);
		if ($this->isColumnModified(BoxPeer::ACTIVE)) $criteria->add(BoxPeer::ACTIVE, $this->active);
		if ($this->isColumnModified(BoxPeer::OPT_NAME)) $criteria->add(BoxPeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(BoxPeer::OPT_CONTENT)) $criteria->add(BoxPeer::OPT_CONTENT, $this->opt_content);
		if ($this->isColumnModified(BoxPeer::SHOW_TITLE)) $criteria->add(BoxPeer::SHOW_TITLE, $this->show_title);
		if ($this->isColumnModified(BoxPeer::WEBMASTER_ID)) $criteria->add(BoxPeer::WEBMASTER_ID, $this->webmaster_id);

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
		$criteria = new Criteria(BoxPeer::DATABASE_NAME);

		$criteria->add(BoxPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Box (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setBoxGroupId($this->box_group_id);

		$copyObj->setActive($this->active);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setOptContent($this->opt_content);

		$copyObj->setShowTitle($this->show_title);

		$copyObj->setWebmasterId($this->webmaster_id);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getBoxI18ns() as $relObj) {
				$copyObj->addBoxI18n($relObj->copy($deepCopy));
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
	 * @return     Box Clone of current object.
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
	 * @return     BoxPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new BoxPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a BoxGroup object.
	 *
	 * @param      BoxGroup $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setBoxGroup($v)
	{


		if ($v === null) {
			$this->setBoxGroupId(NULL);
		} else {
			$this->setBoxGroupId($v->getId());
		}


		$this->aBoxGroup = $v;
	}


	/**
	 * Get the associated BoxGroup object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     BoxGroup The associated BoxGroup object.
	 * @throws     PropelException
	 */
	public function getBoxGroup($con = null)
	{
		if ($this->aBoxGroup === null && ($this->box_group_id !== null)) {
			// include the related Peer class
			$this->aBoxGroup = BoxGroupPeer::retrieveByPK($this->box_group_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = BoxGroupPeer::retrieveByPK($this->box_group_id, $con);
			   $obj->addBoxGroups($this);
			 */
		}
		return $this->aBoxGroup;
	}

	/**
	 * Temporary storage of collBoxI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initBoxI18ns()
	{
		if ($this->collBoxI18ns === null) {
			$this->collBoxI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Box has previously
	 * been saved, it will retrieve related BoxI18ns from storage.
	 * If this Box is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getBoxI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBoxI18ns === null) {
			if ($this->isNew()) {
			   $this->collBoxI18ns = array();
			} else {

				$criteria->add(BoxI18nPeer::ID, $this->getId());

				BoxI18nPeer::addSelectColumns($criteria);
				$this->collBoxI18ns = BoxI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(BoxI18nPeer::ID, $this->getId());

				BoxI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastBoxI18nCriteria) || !$this->lastBoxI18nCriteria->equals($criteria)) {
					$this->collBoxI18ns = BoxI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastBoxI18nCriteria = $criteria;
		return $this->collBoxI18ns;
	}

	/**
	 * Returns the number of related BoxI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countBoxI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(BoxI18nPeer::ID, $this->getId());

		return BoxI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a BoxI18n object to this object
	 * through the BoxI18n foreign key attribute
	 *
	 * @param      BoxI18n $l BoxI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addBoxI18n(BoxI18n $l)
	{
		$this->collBoxI18ns[] = $l;
		$l->setBox($this);
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
    $obj = $this->getCurrentBoxI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentBoxI18n()->setName($value);
  }

  public function getContent()
  {
    $obj = $this->getCurrentBoxI18n();

    return ($obj ? $obj->getContent() : null);
  }

  public function setContent($value)
  {
    $this->getCurrentBoxI18n()->setContent($value);
  }

  public $current_i18n = array();

  public function getCurrentBoxI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = BoxI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setBoxI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setBoxI18nForCulture(new BoxI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setBoxI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addBoxI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Box.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseBox:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseBox::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseBox
