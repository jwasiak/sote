<?php

/**
 * Base class that represents a row from the 'st_newsletter_user' table.
 *
 * 
 *
 * @package    plugins.stNewsletterPlugin.lib.model.om
 */
abstract class BaseNewsletterUser extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        NewsletterUserPeer
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
	 * The value for the sf_guard_user_id field.
	 * @var        int
	 */
	protected $sf_guard_user_id;


	/**
	 * The value for the email field.
	 * @var        string
	 */
	protected $email;


	/**
	 * The value for the active field.
	 * @var        boolean
	 */
	protected $active = true;


	/**
	 * The value for the confirm field.
	 * @var        boolean
	 */
	protected $confirm = false;


	/**
	 * The value for the hash field.
	 * @var        string
	 */
	protected $hash;


	/**
	 * The value for the language field.
	 * @var        string
	 */
	protected $language;

	/**
	 * @var        sfGuardUser
	 */
	protected $asfGuardUser;

	/**
	 * Collection to store aggregation of collNewsletterUserHasNewsletterGroups.
	 * @var        array
	 */
	protected $collNewsletterUserHasNewsletterGroups;

	/**
	 * The criteria used to select the current contents of collNewsletterUserHasNewsletterGroups.
	 * @var        Criteria
	 */
	protected $lastNewsletterUserHasNewsletterGroupCriteria = null;

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
     * Get the [sf_guard_user_id] column value.
     * 
     * @return     int
     */
    public function getSfGuardUserId()
    {

            return $this->sf_guard_user_id;
    }

    /**
     * Get the [email] column value.
     * 
     * @return     string
     */
    public function getEmail()
    {

            return $this->email;
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
     * Get the [confirm] column value.
     * 
     * @return     boolean
     */
    public function getConfirm()
    {

            return $this->confirm;
    }

    /**
     * Get the [hash] column value.
     * 
     * @return     string
     */
    public function getHash()
    {

            return $this->hash;
    }

    /**
     * Get the [language] column value.
     * 
     * @return     string
     */
    public function getLanguage()
    {

            return $this->language;
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
			$this->modifiedColumns[] = NewsletterUserPeer::CREATED_AT;
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
			$this->modifiedColumns[] = NewsletterUserPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = NewsletterUserPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [sf_guard_user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setSfGuardUserId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->sf_guard_user_id !== $v) {
          $this->sf_guard_user_id = $v;
          $this->modifiedColumns[] = NewsletterUserPeer::SF_GUARD_USER_ID;
        }

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} // setSfGuardUserId()

	/**
	 * Set the value of [email] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setEmail($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->email !== $v) {
          $this->email = $v;
          $this->modifiedColumns[] = NewsletterUserPeer::EMAIL;
        }

	} // setEmail()

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
          $this->modifiedColumns[] = NewsletterUserPeer::ACTIVE;
        }

	} // setActive()

	/**
	 * Set the value of [confirm] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setConfirm($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->confirm !== $v || $v === false) {
          $this->confirm = $v;
          $this->modifiedColumns[] = NewsletterUserPeer::CONFIRM;
        }

	} // setConfirm()

	/**
	 * Set the value of [hash] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setHash($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->hash !== $v) {
          $this->hash = $v;
          $this->modifiedColumns[] = NewsletterUserPeer::HASH;
        }

	} // setHash()

	/**
	 * Set the value of [language] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setLanguage($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->language !== $v) {
          $this->language = $v;
          $this->modifiedColumns[] = NewsletterUserPeer::LANGUAGE;
        }

	} // setLanguage()

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
      if ($this->getDispatcher()->getListeners('NewsletterUser.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterUser.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->sf_guard_user_id = $rs->getInt($startcol + 3);

      $this->email = $rs->getString($startcol + 4);

      $this->active = $rs->getBoolean($startcol + 5);

      $this->confirm = $rs->getBoolean($startcol + 6);

      $this->hash = $rs->getString($startcol + 7);

      $this->language = $rs->getString($startcol + 8);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('NewsletterUser.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterUser.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 9)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 9; // 9 = NewsletterUserPeer::NUM_COLUMNS - NewsletterUserPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating NewsletterUser object", $e);
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

    if ($this->getDispatcher()->getListeners('NewsletterUser.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterUser.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseNewsletterUser:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseNewsletterUser:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(NewsletterUserPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      NewsletterUserPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('NewsletterUser.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterUser.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseNewsletterUser:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseNewsletterUser:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('NewsletterUser.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterUser.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseNewsletterUser:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(NewsletterUserPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(NewsletterUserPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(NewsletterUserPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('NewsletterUser.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterUser.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseNewsletterUser:save:post') as $callable)
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

			if ($this->asfGuardUser !== null) {
				if ($this->asfGuardUser->isModified()) {
					$affectedRows += $this->asfGuardUser->save($con);
				}
				$this->setsfGuardUser($this->asfGuardUser);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = NewsletterUserPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += NewsletterUserPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collNewsletterUserHasNewsletterGroups !== null) {
				foreach($this->collNewsletterUserHasNewsletterGroups as $referrerFK) {
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

			if ($this->asfGuardUser !== null) {
				if (!$this->asfGuardUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUser->getValidationFailures());
				}
			}


			if (($retval = NewsletterUserPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collNewsletterUserHasNewsletterGroups !== null) {
					foreach($this->collNewsletterUserHasNewsletterGroups as $referrerFK) {
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
		$pos = NewsletterUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getSfGuardUserId();
				break;
			case 4:
				return $this->getEmail();
				break;
			case 5:
				return $this->getActive();
				break;
			case 6:
				return $this->getConfirm();
				break;
			case 7:
				return $this->getHash();
				break;
			case 8:
				return $this->getLanguage();
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
		$keys = NewsletterUserPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getSfGuardUserId(),
			$keys[4] => $this->getEmail(),
			$keys[5] => $this->getActive(),
			$keys[6] => $this->getConfirm(),
			$keys[7] => $this->getHash(),
			$keys[8] => $this->getLanguage(),
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
		$pos = NewsletterUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setSfGuardUserId($value);
				break;
			case 4:
				$this->setEmail($value);
				break;
			case 5:
				$this->setActive($value);
				break;
			case 6:
				$this->setConfirm($value);
				break;
			case 7:
				$this->setHash($value);
				break;
			case 8:
				$this->setLanguage($value);
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
		$keys = NewsletterUserPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSfGuardUserId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setEmail($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setActive($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setConfirm($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setHash($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setLanguage($arr[$keys[8]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(NewsletterUserPeer::DATABASE_NAME);

		if ($this->isColumnModified(NewsletterUserPeer::CREATED_AT)) $criteria->add(NewsletterUserPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(NewsletterUserPeer::UPDATED_AT)) $criteria->add(NewsletterUserPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(NewsletterUserPeer::ID)) $criteria->add(NewsletterUserPeer::ID, $this->id);
		if ($this->isColumnModified(NewsletterUserPeer::SF_GUARD_USER_ID)) $criteria->add(NewsletterUserPeer::SF_GUARD_USER_ID, $this->sf_guard_user_id);
		if ($this->isColumnModified(NewsletterUserPeer::EMAIL)) $criteria->add(NewsletterUserPeer::EMAIL, $this->email);
		if ($this->isColumnModified(NewsletterUserPeer::ACTIVE)) $criteria->add(NewsletterUserPeer::ACTIVE, $this->active);
		if ($this->isColumnModified(NewsletterUserPeer::CONFIRM)) $criteria->add(NewsletterUserPeer::CONFIRM, $this->confirm);
		if ($this->isColumnModified(NewsletterUserPeer::HASH)) $criteria->add(NewsletterUserPeer::HASH, $this->hash);
		if ($this->isColumnModified(NewsletterUserPeer::LANGUAGE)) $criteria->add(NewsletterUserPeer::LANGUAGE, $this->language);

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
		$criteria = new Criteria(NewsletterUserPeer::DATABASE_NAME);

		$criteria->add(NewsletterUserPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of NewsletterUser (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setSfGuardUserId($this->sf_guard_user_id);

		$copyObj->setEmail($this->email);

		$copyObj->setActive($this->active);

		$copyObj->setConfirm($this->confirm);

		$copyObj->setHash($this->hash);

		$copyObj->setLanguage($this->language);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getNewsletterUserHasNewsletterGroups() as $relObj) {
				$copyObj->addNewsletterUserHasNewsletterGroup($relObj->copy($deepCopy));
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
	 * @return     NewsletterUser Clone of current object.
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
	 * @return     NewsletterUserPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new NewsletterUserPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a sfGuardUser object.
	 *
	 * @param      sfGuardUser $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setsfGuardUser($v)
	{


		if ($v === null) {
			$this->setSfGuardUserId(NULL);
		} else {
			$this->setSfGuardUserId($v->getId());
		}


		$this->asfGuardUser = $v;
	}


	/**
	 * Get the associated sfGuardUser object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     sfGuardUser The associated sfGuardUser object.
	 * @throws     PropelException
	 */
	public function getsfGuardUser($con = null)
	{
		if ($this->asfGuardUser === null && ($this->sf_guard_user_id !== null)) {
			// include the related Peer class
			$this->asfGuardUser = sfGuardUserPeer::retrieveByPK($this->sf_guard_user_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = sfGuardUserPeer::retrieveByPK($this->sf_guard_user_id, $con);
			   $obj->addsfGuardUsers($this);
			 */
		}
		return $this->asfGuardUser;
	}

	/**
	 * Temporary storage of collNewsletterUserHasNewsletterGroups to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initNewsletterUserHasNewsletterGroups()
	{
		if ($this->collNewsletterUserHasNewsletterGroups === null) {
			$this->collNewsletterUserHasNewsletterGroups = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this NewsletterUser has previously
	 * been saved, it will retrieve related NewsletterUserHasNewsletterGroups from storage.
	 * If this NewsletterUser is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getNewsletterUserHasNewsletterGroups($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNewsletterUserHasNewsletterGroups === null) {
			if ($this->isNew()) {
			   $this->collNewsletterUserHasNewsletterGroups = array();
			} else {

				$criteria->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $this->getId());

				NewsletterUserHasNewsletterGroupPeer::addSelectColumns($criteria);
				$this->collNewsletterUserHasNewsletterGroups = NewsletterUserHasNewsletterGroupPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $this->getId());

				NewsletterUserHasNewsletterGroupPeer::addSelectColumns($criteria);
				if (!isset($this->lastNewsletterUserHasNewsletterGroupCriteria) || !$this->lastNewsletterUserHasNewsletterGroupCriteria->equals($criteria)) {
					$this->collNewsletterUserHasNewsletterGroups = NewsletterUserHasNewsletterGroupPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastNewsletterUserHasNewsletterGroupCriteria = $criteria;
		return $this->collNewsletterUserHasNewsletterGroups;
	}

	/**
	 * Returns the number of related NewsletterUserHasNewsletterGroups.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countNewsletterUserHasNewsletterGroups($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $this->getId());

		return NewsletterUserHasNewsletterGroupPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a NewsletterUserHasNewsletterGroup object to this object
	 * through the NewsletterUserHasNewsletterGroup foreign key attribute
	 *
	 * @param      NewsletterUserHasNewsletterGroup $l NewsletterUserHasNewsletterGroup
	 * @return     void
	 * @throws     PropelException
	 */
	public function addNewsletterUserHasNewsletterGroup(NewsletterUserHasNewsletterGroup $l)
	{
		$this->collNewsletterUserHasNewsletterGroups[] = $l;
		$l->setNewsletterUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this NewsletterUser is new, it will return
	 * an empty collection; or if this NewsletterUser has previously
	 * been saved, it will retrieve related NewsletterUserHasNewsletterGroups from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in NewsletterUser.
	 */
	public function getNewsletterUserHasNewsletterGroupsJoinNewsletterGroup($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNewsletterUserHasNewsletterGroups === null) {
			if ($this->isNew()) {
				$this->collNewsletterUserHasNewsletterGroups = array();
			} else {

				$criteria->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $this->getId());

				$this->collNewsletterUserHasNewsletterGroups = NewsletterUserHasNewsletterGroupPeer::doSelectJoinNewsletterGroup($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NewsletterUserHasNewsletterGroupPeer::NEWSLETTER_USER_ID, $this->getId());

			if (!isset($this->lastNewsletterUserHasNewsletterGroupCriteria) || !$this->lastNewsletterUserHasNewsletterGroupCriteria->equals($criteria)) {
				$this->collNewsletterUserHasNewsletterGroups = NewsletterUserHasNewsletterGroupPeer::doSelectJoinNewsletterGroup($criteria, $con);
			}
		}
		$this->lastNewsletterUserHasNewsletterGroupCriteria = $criteria;

		return $this->collNewsletterUserHasNewsletterGroups;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'NewsletterUser.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseNewsletterUser:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseNewsletterUser::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseNewsletterUser
