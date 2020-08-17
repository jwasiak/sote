<?php

/**
 * Base class that represents a row from the 'st_newsletter_message' table.
 *
 * 
 *
 * @package    plugins.stNewsletterPlugin.lib.model.om
 */
abstract class BaseNewsletterMessage extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        NewsletterMessagePeer
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
	 * The value for the opt_subject field.
	 * @var        string
	 */
	protected $opt_subject;


	/**
	 * The value for the opt_content field.
	 * @var        string
	 */
	protected $opt_content;


	/**
	 * The value for the sent_at field.
	 * @var        int
	 */
	protected $sent_at;

	/**
	 * Collection to store aggregation of collNewsletterMessageHasNewsletterGroups.
	 * @var        array
	 */
	protected $collNewsletterMessageHasNewsletterGroups;

	/**
	 * The criteria used to select the current contents of collNewsletterMessageHasNewsletterGroups.
	 * @var        Criteria
	 */
	protected $lastNewsletterMessageHasNewsletterGroupCriteria = null;

	/**
	 * Collection to store aggregation of collNewsletterMessageI18ns.
	 * @var        array
	 */
	protected $collNewsletterMessageI18ns;

	/**
	 * The criteria used to select the current contents of collNewsletterMessageI18ns.
	 * @var        Criteria
	 */
	protected $lastNewsletterMessageI18nCriteria = null;

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
     * Get the [opt_subject] column value.
     * 
     * @return     string
     */
    public function getOptSubject()
    {

            return $this->opt_subject;
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
	 * Get the [optionally formatted] [sent_at] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getSentAt($format = 'Y-m-d H:i:s')
	{

		if ($this->sent_at === null || $this->sent_at === '') {
			return null;
		} elseif (!is_int($this->sent_at)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->sent_at);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [sent_at] as date/time value: " . var_export($this->sent_at, true));
			}
		} else {
			$ts = $this->sent_at;
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
			$this->modifiedColumns[] = NewsletterMessagePeer::CREATED_AT;
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
			$this->modifiedColumns[] = NewsletterMessagePeer::UPDATED_AT;
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
          $this->modifiedColumns[] = NewsletterMessagePeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [opt_subject] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptSubject($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_subject !== $v) {
          $this->opt_subject = $v;
          $this->modifiedColumns[] = NewsletterMessagePeer::OPT_SUBJECT;
        }

	} // setOptSubject()

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
          $this->modifiedColumns[] = NewsletterMessagePeer::OPT_CONTENT;
        }

	} // setOptContent()

	/**
	 * Set the value of [sent_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setSentAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [sent_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->sent_at !== $ts) {
			$this->sent_at = $ts;
			$this->modifiedColumns[] = NewsletterMessagePeer::SENT_AT;
		}

	} // setSentAt()

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
      if ($this->getDispatcher()->getListeners('NewsletterMessage.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterMessage.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->opt_subject = $rs->getString($startcol + 3);

      $this->opt_content = $rs->getString($startcol + 4);

      $this->sent_at = $rs->getTimestamp($startcol + 5, null);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('NewsletterMessage.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterMessage.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 6)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 6; // 6 = NewsletterMessagePeer::NUM_COLUMNS - NewsletterMessagePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating NewsletterMessage object", $e);
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

    if ($this->getDispatcher()->getListeners('NewsletterMessage.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterMessage.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseNewsletterMessage:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseNewsletterMessage:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(NewsletterMessagePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      NewsletterMessagePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('NewsletterMessage.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterMessage.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseNewsletterMessage:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseNewsletterMessage:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('NewsletterMessage.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterMessage.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseNewsletterMessage:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(NewsletterMessagePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(NewsletterMessagePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(NewsletterMessagePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('NewsletterMessage.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterMessage.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseNewsletterMessage:save:post') as $callable)
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
					$pk = NewsletterMessagePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += NewsletterMessagePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collNewsletterMessageHasNewsletterGroups !== null) {
				foreach($this->collNewsletterMessageHasNewsletterGroups as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collNewsletterMessageI18ns !== null) {
				foreach($this->collNewsletterMessageI18ns as $referrerFK) {
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


			if (($retval = NewsletterMessagePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collNewsletterMessageHasNewsletterGroups !== null) {
					foreach($this->collNewsletterMessageHasNewsletterGroups as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collNewsletterMessageI18ns !== null) {
					foreach($this->collNewsletterMessageI18ns as $referrerFK) {
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
		$pos = NewsletterMessagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getOptSubject();
				break;
			case 4:
				return $this->getOptContent();
				break;
			case 5:
				return $this->getSentAt();
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
		$keys = NewsletterMessagePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getOptSubject(),
			$keys[4] => $this->getOptContent(),
			$keys[5] => $this->getSentAt(),
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
		$pos = NewsletterMessagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setOptSubject($value);
				break;
			case 4:
				$this->setOptContent($value);
				break;
			case 5:
				$this->setSentAt($value);
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
		$keys = NewsletterMessagePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setOptSubject($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setOptContent($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setSentAt($arr[$keys[5]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(NewsletterMessagePeer::DATABASE_NAME);

		if ($this->isColumnModified(NewsletterMessagePeer::CREATED_AT)) $criteria->add(NewsletterMessagePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(NewsletterMessagePeer::UPDATED_AT)) $criteria->add(NewsletterMessagePeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(NewsletterMessagePeer::ID)) $criteria->add(NewsletterMessagePeer::ID, $this->id);
		if ($this->isColumnModified(NewsletterMessagePeer::OPT_SUBJECT)) $criteria->add(NewsletterMessagePeer::OPT_SUBJECT, $this->opt_subject);
		if ($this->isColumnModified(NewsletterMessagePeer::OPT_CONTENT)) $criteria->add(NewsletterMessagePeer::OPT_CONTENT, $this->opt_content);
		if ($this->isColumnModified(NewsletterMessagePeer::SENT_AT)) $criteria->add(NewsletterMessagePeer::SENT_AT, $this->sent_at);

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
		$criteria = new Criteria(NewsletterMessagePeer::DATABASE_NAME);

		$criteria->add(NewsletterMessagePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of NewsletterMessage (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setOptSubject($this->opt_subject);

		$copyObj->setOptContent($this->opt_content);

		$copyObj->setSentAt($this->sent_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getNewsletterMessageHasNewsletterGroups() as $relObj) {
				$copyObj->addNewsletterMessageHasNewsletterGroup($relObj->copy($deepCopy));
			}

			foreach($this->getNewsletterMessageI18ns() as $relObj) {
				$copyObj->addNewsletterMessageI18n($relObj->copy($deepCopy));
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
	 * @return     NewsletterMessage Clone of current object.
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
	 * @return     NewsletterMessagePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new NewsletterMessagePeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collNewsletterMessageHasNewsletterGroups to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initNewsletterMessageHasNewsletterGroups()
	{
		if ($this->collNewsletterMessageHasNewsletterGroups === null) {
			$this->collNewsletterMessageHasNewsletterGroups = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this NewsletterMessage has previously
	 * been saved, it will retrieve related NewsletterMessageHasNewsletterGroups from storage.
	 * If this NewsletterMessage is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getNewsletterMessageHasNewsletterGroups($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNewsletterMessageHasNewsletterGroups === null) {
			if ($this->isNew()) {
			   $this->collNewsletterMessageHasNewsletterGroups = array();
			} else {

				$criteria->add(NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_MESSAGE_ID, $this->getId());

				NewsletterMessageHasNewsletterGroupPeer::addSelectColumns($criteria);
				$this->collNewsletterMessageHasNewsletterGroups = NewsletterMessageHasNewsletterGroupPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_MESSAGE_ID, $this->getId());

				NewsletterMessageHasNewsletterGroupPeer::addSelectColumns($criteria);
				if (!isset($this->lastNewsletterMessageHasNewsletterGroupCriteria) || !$this->lastNewsletterMessageHasNewsletterGroupCriteria->equals($criteria)) {
					$this->collNewsletterMessageHasNewsletterGroups = NewsletterMessageHasNewsletterGroupPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastNewsletterMessageHasNewsletterGroupCriteria = $criteria;
		return $this->collNewsletterMessageHasNewsletterGroups;
	}

	/**
	 * Returns the number of related NewsletterMessageHasNewsletterGroups.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countNewsletterMessageHasNewsletterGroups($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_MESSAGE_ID, $this->getId());

		return NewsletterMessageHasNewsletterGroupPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a NewsletterMessageHasNewsletterGroup object to this object
	 * through the NewsletterMessageHasNewsletterGroup foreign key attribute
	 *
	 * @param      NewsletterMessageHasNewsletterGroup $l NewsletterMessageHasNewsletterGroup
	 * @return     void
	 * @throws     PropelException
	 */
	public function addNewsletterMessageHasNewsletterGroup(NewsletterMessageHasNewsletterGroup $l)
	{
		$this->collNewsletterMessageHasNewsletterGroups[] = $l;
		$l->setNewsletterMessage($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this NewsletterMessage is new, it will return
	 * an empty collection; or if this NewsletterMessage has previously
	 * been saved, it will retrieve related NewsletterMessageHasNewsletterGroups from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in NewsletterMessage.
	 */
	public function getNewsletterMessageHasNewsletterGroupsJoinNewsletterGroup($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNewsletterMessageHasNewsletterGroups === null) {
			if ($this->isNew()) {
				$this->collNewsletterMessageHasNewsletterGroups = array();
			} else {

				$criteria->add(NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_MESSAGE_ID, $this->getId());

				$this->collNewsletterMessageHasNewsletterGroups = NewsletterMessageHasNewsletterGroupPeer::doSelectJoinNewsletterGroup($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_MESSAGE_ID, $this->getId());

			if (!isset($this->lastNewsletterMessageHasNewsletterGroupCriteria) || !$this->lastNewsletterMessageHasNewsletterGroupCriteria->equals($criteria)) {
				$this->collNewsletterMessageHasNewsletterGroups = NewsletterMessageHasNewsletterGroupPeer::doSelectJoinNewsletterGroup($criteria, $con);
			}
		}
		$this->lastNewsletterMessageHasNewsletterGroupCriteria = $criteria;

		return $this->collNewsletterMessageHasNewsletterGroups;
	}

	/**
	 * Temporary storage of collNewsletterMessageI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initNewsletterMessageI18ns()
	{
		if ($this->collNewsletterMessageI18ns === null) {
			$this->collNewsletterMessageI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this NewsletterMessage has previously
	 * been saved, it will retrieve related NewsletterMessageI18ns from storage.
	 * If this NewsletterMessage is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getNewsletterMessageI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNewsletterMessageI18ns === null) {
			if ($this->isNew()) {
			   $this->collNewsletterMessageI18ns = array();
			} else {

				$criteria->add(NewsletterMessageI18nPeer::ID, $this->getId());

				NewsletterMessageI18nPeer::addSelectColumns($criteria);
				$this->collNewsletterMessageI18ns = NewsletterMessageI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(NewsletterMessageI18nPeer::ID, $this->getId());

				NewsletterMessageI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastNewsletterMessageI18nCriteria) || !$this->lastNewsletterMessageI18nCriteria->equals($criteria)) {
					$this->collNewsletterMessageI18ns = NewsletterMessageI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastNewsletterMessageI18nCriteria = $criteria;
		return $this->collNewsletterMessageI18ns;
	}

	/**
	 * Returns the number of related NewsletterMessageI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countNewsletterMessageI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(NewsletterMessageI18nPeer::ID, $this->getId());

		return NewsletterMessageI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a NewsletterMessageI18n object to this object
	 * through the NewsletterMessageI18n foreign key attribute
	 *
	 * @param      NewsletterMessageI18n $l NewsletterMessageI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addNewsletterMessageI18n(NewsletterMessageI18n $l)
	{
		$this->collNewsletterMessageI18ns[] = $l;
		$l->setNewsletterMessage($this);
	}

  public function getCulture()
  {
    return $this->culture;
  }

  public function setCulture($culture)
  {
    $this->culture = $culture;
  }

  public function getSubject()
  {
    $obj = $this->getCurrentNewsletterMessageI18n();

    return ($obj ? $obj->getSubject() : null);
  }

  public function setSubject($value)
  {
    $this->getCurrentNewsletterMessageI18n()->setSubject($value);
  }

  public function getContent()
  {
    $obj = $this->getCurrentNewsletterMessageI18n();

    return ($obj ? $obj->getContent() : null);
  }

  public function setContent($value)
  {
    $this->getCurrentNewsletterMessageI18n()->setContent($value);
  }

  public $current_i18n = array();

  public function getCurrentNewsletterMessageI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = NewsletterMessageI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setNewsletterMessageI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setNewsletterMessageI18nForCulture(new NewsletterMessageI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setNewsletterMessageI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addNewsletterMessageI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'NewsletterMessage.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseNewsletterMessage:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseNewsletterMessage::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseNewsletterMessage
