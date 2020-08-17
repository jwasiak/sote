<?php

/**
 * Base class that represents a row from the 'st_mail_account' table.
 *
 * 
 *
 * @package    plugins.stMailPlugin.lib.model.om
 */
abstract class BaseMailAccount extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        MailAccountPeer
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
	 * The value for the mail_smtp_profile_id field.
	 * @var        int
	 */
	protected $mail_smtp_profile_id;


	/**
	 * The value for the version field.
	 * @var        int
	 */
	protected $version = 1;


	/**
	 * The value for the username field.
	 * @var        string
	 */
	protected $username;


	/**
	 * The value for the password field.
	 * @var        string
	 */
	protected $password;


	/**
	 * The value for the email field.
	 * @var        string
	 */
	protected $email;


	/**
	 * The value for the is_default field.
	 * @var        boolean
	 */
	protected $is_default = false;


	/**
	 * The value for the is_newsletter field.
	 * @var        boolean
	 */
	protected $is_newsletter = false;


	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;

	/**
	 * @var        MailSmtpProfile
	 */
	protected $aMailSmtpProfile;

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
     * Get the [mail_smtp_profile_id] column value.
     * 
     * @return     int
     */
    public function getMailSmtpProfileId()
    {

            return $this->mail_smtp_profile_id;
    }

    /**
     * Get the [version] column value.
     * 
     * @return     int
     */
    public function getVersion()
    {

            return $this->version;
    }

    /**
     * Get the [username] column value.
     * 
     * @return     string
     */
    public function getUsername()
    {

            return $this->username;
    }

    /**
     * Get the [password] column value.
     * 
     * @return     string
     */
    public function getPassword()
    {

            return $this->password;
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
     * Get the [is_default] column value.
     * 
     * @return     boolean
     */
    public function getIsDefault()
    {

            return $this->is_default;
    }

    /**
     * Get the [is_newsletter] column value.
     * 
     * @return     boolean
     */
    public function getIsNewsletter()
    {

            return $this->is_newsletter;
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
			$this->modifiedColumns[] = MailAccountPeer::CREATED_AT;
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
			$this->modifiedColumns[] = MailAccountPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = MailAccountPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [mail_smtp_profile_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setMailSmtpProfileId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->mail_smtp_profile_id !== $v) {
          $this->mail_smtp_profile_id = $v;
          $this->modifiedColumns[] = MailAccountPeer::MAIL_SMTP_PROFILE_ID;
        }

		if ($this->aMailSmtpProfile !== null && $this->aMailSmtpProfile->getId() !== $v) {
			$this->aMailSmtpProfile = null;
		}

	} // setMailSmtpProfileId()

	/**
	 * Set the value of [version] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setVersion($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->version !== $v || $v === 1) {
          $this->version = $v;
          $this->modifiedColumns[] = MailAccountPeer::VERSION;
        }

	} // setVersion()

	/**
	 * Set the value of [username] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUsername($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->username !== $v) {
          $this->username = $v;
          $this->modifiedColumns[] = MailAccountPeer::USERNAME;
        }

	} // setUsername()

	/**
	 * Set the value of [password] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPassword($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->password !== $v) {
          $this->password = $v;
          $this->modifiedColumns[] = MailAccountPeer::PASSWORD;
        }

	} // setPassword()

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
          $this->modifiedColumns[] = MailAccountPeer::EMAIL;
        }

	} // setEmail()

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
          $this->modifiedColumns[] = MailAccountPeer::IS_DEFAULT;
        }

	} // setIsDefault()

	/**
	 * Set the value of [is_newsletter] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsNewsletter($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_newsletter !== $v || $v === false) {
          $this->is_newsletter = $v;
          $this->modifiedColumns[] = MailAccountPeer::IS_NEWSLETTER;
        }

	} // setIsNewsletter()

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
          $this->modifiedColumns[] = MailAccountPeer::NAME;
        }

	} // setName()

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
      if ($this->getDispatcher()->getListeners('MailAccount.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'MailAccount.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->mail_smtp_profile_id = $rs->getInt($startcol + 3);

      $this->version = $rs->getInt($startcol + 4);

      $this->username = $rs->getString($startcol + 5);

      $this->password = $rs->getString($startcol + 6);

      $this->email = $rs->getString($startcol + 7);

      $this->is_default = $rs->getBoolean($startcol + 8);

      $this->is_newsletter = $rs->getBoolean($startcol + 9);

      $this->name = $rs->getString($startcol + 10);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('MailAccount.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'MailAccount.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 11)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 11; // 11 = MailAccountPeer::NUM_COLUMNS - MailAccountPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating MailAccount object", $e);
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

    if ($this->getDispatcher()->getListeners('MailAccount.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'MailAccount.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseMailAccount:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseMailAccount:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(MailAccountPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      MailAccountPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('MailAccount.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'MailAccount.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseMailAccount:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseMailAccount:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('MailAccount.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'MailAccount.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseMailAccount:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(MailAccountPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(MailAccountPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(MailAccountPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('MailAccount.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'MailAccount.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseMailAccount:save:post') as $callable)
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

			if ($this->aMailSmtpProfile !== null) {
				if ($this->aMailSmtpProfile->isModified()) {
					$affectedRows += $this->aMailSmtpProfile->save($con);
				}
				$this->setMailSmtpProfile($this->aMailSmtpProfile);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MailAccountPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += MailAccountPeer::doUpdate($this, $con);
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

			if ($this->aMailSmtpProfile !== null) {
				if (!$this->aMailSmtpProfile->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMailSmtpProfile->getValidationFailures());
				}
			}


			if (($retval = MailAccountPeer::doValidate($this, $columns)) !== true) {
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
		$pos = MailAccountPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getMailSmtpProfileId();
				break;
			case 4:
				return $this->getVersion();
				break;
			case 5:
				return $this->getUsername();
				break;
			case 6:
				return $this->getPassword();
				break;
			case 7:
				return $this->getEmail();
				break;
			case 8:
				return $this->getIsDefault();
				break;
			case 9:
				return $this->getIsNewsletter();
				break;
			case 10:
				return $this->getName();
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
		$keys = MailAccountPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getMailSmtpProfileId(),
			$keys[4] => $this->getVersion(),
			$keys[5] => $this->getUsername(),
			$keys[6] => $this->getPassword(),
			$keys[7] => $this->getEmail(),
			$keys[8] => $this->getIsDefault(),
			$keys[9] => $this->getIsNewsletter(),
			$keys[10] => $this->getName(),
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
		$pos = MailAccountPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setMailSmtpProfileId($value);
				break;
			case 4:
				$this->setVersion($value);
				break;
			case 5:
				$this->setUsername($value);
				break;
			case 6:
				$this->setPassword($value);
				break;
			case 7:
				$this->setEmail($value);
				break;
			case 8:
				$this->setIsDefault($value);
				break;
			case 9:
				$this->setIsNewsletter($value);
				break;
			case 10:
				$this->setName($value);
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
		$keys = MailAccountPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setMailSmtpProfileId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setVersion($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setUsername($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setPassword($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setEmail($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsDefault($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setIsNewsletter($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setName($arr[$keys[10]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(MailAccountPeer::DATABASE_NAME);

		if ($this->isColumnModified(MailAccountPeer::CREATED_AT)) $criteria->add(MailAccountPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(MailAccountPeer::UPDATED_AT)) $criteria->add(MailAccountPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(MailAccountPeer::ID)) $criteria->add(MailAccountPeer::ID, $this->id);
		if ($this->isColumnModified(MailAccountPeer::MAIL_SMTP_PROFILE_ID)) $criteria->add(MailAccountPeer::MAIL_SMTP_PROFILE_ID, $this->mail_smtp_profile_id);
		if ($this->isColumnModified(MailAccountPeer::VERSION)) $criteria->add(MailAccountPeer::VERSION, $this->version);
		if ($this->isColumnModified(MailAccountPeer::USERNAME)) $criteria->add(MailAccountPeer::USERNAME, $this->username);
		if ($this->isColumnModified(MailAccountPeer::PASSWORD)) $criteria->add(MailAccountPeer::PASSWORD, $this->password);
		if ($this->isColumnModified(MailAccountPeer::EMAIL)) $criteria->add(MailAccountPeer::EMAIL, $this->email);
		if ($this->isColumnModified(MailAccountPeer::IS_DEFAULT)) $criteria->add(MailAccountPeer::IS_DEFAULT, $this->is_default);
		if ($this->isColumnModified(MailAccountPeer::IS_NEWSLETTER)) $criteria->add(MailAccountPeer::IS_NEWSLETTER, $this->is_newsletter);
		if ($this->isColumnModified(MailAccountPeer::NAME)) $criteria->add(MailAccountPeer::NAME, $this->name);

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
		$criteria = new Criteria(MailAccountPeer::DATABASE_NAME);

		$criteria->add(MailAccountPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of MailAccount (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setMailSmtpProfileId($this->mail_smtp_profile_id);

		$copyObj->setVersion($this->version);

		$copyObj->setUsername($this->username);

		$copyObj->setPassword($this->password);

		$copyObj->setEmail($this->email);

		$copyObj->setIsDefault($this->is_default);

		$copyObj->setIsNewsletter($this->is_newsletter);

		$copyObj->setName($this->name);


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
	 * @return     MailAccount Clone of current object.
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
	 * @return     MailAccountPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new MailAccountPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a MailSmtpProfile object.
	 *
	 * @param      MailSmtpProfile $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setMailSmtpProfile($v)
	{


		if ($v === null) {
			$this->setMailSmtpProfileId(NULL);
		} else {
			$this->setMailSmtpProfileId($v->getId());
		}


		$this->aMailSmtpProfile = $v;
	}


	/**
	 * Get the associated MailSmtpProfile object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     MailSmtpProfile The associated MailSmtpProfile object.
	 * @throws     PropelException
	 */
	public function getMailSmtpProfile($con = null)
	{
		if ($this->aMailSmtpProfile === null && ($this->mail_smtp_profile_id !== null)) {
			// include the related Peer class
			$this->aMailSmtpProfile = MailSmtpProfilePeer::retrieveByPK($this->mail_smtp_profile_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = MailSmtpProfilePeer::retrieveByPK($this->mail_smtp_profile_id, $con);
			   $obj->addMailSmtpProfiles($this);
			 */
		}
		return $this->aMailSmtpProfile;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'MailAccount.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseMailAccount:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseMailAccount::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseMailAccount
