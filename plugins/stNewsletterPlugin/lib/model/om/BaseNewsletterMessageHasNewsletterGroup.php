<?php

/**
 * Base class that represents a row from the 'st_newsletter_message_has_newsletter_group' table.
 *
 * 
 *
 * @package    plugins.stNewsletterPlugin.lib.model.om
 */
abstract class BaseNewsletterMessageHasNewsletterGroup extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        NewsletterMessageHasNewsletterGroupPeer
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
	 * The value for the newsletter_message_id field.
	 * @var        int
	 */
	protected $newsletter_message_id;


	/**
	 * The value for the newsletter_group_id field.
	 * @var        int
	 */
	protected $newsletter_group_id;

	/**
	 * @var        NewsletterMessage
	 */
	protected $aNewsletterMessage;

	/**
	 * @var        NewsletterGroup
	 */
	protected $aNewsletterGroup;

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
     * Get the [newsletter_message_id] column value.
     * 
     * @return     int
     */
    public function getNewsletterMessageId()
    {

            return $this->newsletter_message_id;
    }

    /**
     * Get the [newsletter_group_id] column value.
     * 
     * @return     int
     */
    public function getNewsletterGroupId()
    {

            return $this->newsletter_group_id;
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
			$this->modifiedColumns[] = NewsletterMessageHasNewsletterGroupPeer::CREATED_AT;
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
			$this->modifiedColumns[] = NewsletterMessageHasNewsletterGroupPeer::UPDATED_AT;
		}

	} // setUpdatedAt()

	/**
	 * Set the value of [newsletter_message_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setNewsletterMessageId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->newsletter_message_id !== $v) {
          $this->newsletter_message_id = $v;
          $this->modifiedColumns[] = NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_MESSAGE_ID;
        }

		if ($this->aNewsletterMessage !== null && $this->aNewsletterMessage->getId() !== $v) {
			$this->aNewsletterMessage = null;
		}

	} // setNewsletterMessageId()

	/**
	 * Set the value of [newsletter_group_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setNewsletterGroupId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->newsletter_group_id !== $v) {
          $this->newsletter_group_id = $v;
          $this->modifiedColumns[] = NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID;
        }

		if ($this->aNewsletterGroup !== null && $this->aNewsletterGroup->getId() !== $v) {
			$this->aNewsletterGroup = null;
		}

	} // setNewsletterGroupId()

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
      if ($this->getDispatcher()->getListeners('NewsletterMessageHasNewsletterGroup.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterMessageHasNewsletterGroup.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->newsletter_message_id = $rs->getInt($startcol + 2);

      $this->newsletter_group_id = $rs->getInt($startcol + 3);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('NewsletterMessageHasNewsletterGroup.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterMessageHasNewsletterGroup.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 4)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 4; // 4 = NewsletterMessageHasNewsletterGroupPeer::NUM_COLUMNS - NewsletterMessageHasNewsletterGroupPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating NewsletterMessageHasNewsletterGroup object", $e);
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

    if ($this->getDispatcher()->getListeners('NewsletterMessageHasNewsletterGroup.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterMessageHasNewsletterGroup.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseNewsletterMessageHasNewsletterGroup:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseNewsletterMessageHasNewsletterGroup:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(NewsletterMessageHasNewsletterGroupPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      NewsletterMessageHasNewsletterGroupPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('NewsletterMessageHasNewsletterGroup.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterMessageHasNewsletterGroup.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseNewsletterMessageHasNewsletterGroup:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseNewsletterMessageHasNewsletterGroup:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('NewsletterMessageHasNewsletterGroup.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterMessageHasNewsletterGroup.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseNewsletterMessageHasNewsletterGroup:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(NewsletterMessageHasNewsletterGroupPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(NewsletterMessageHasNewsletterGroupPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(NewsletterMessageHasNewsletterGroupPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('NewsletterMessageHasNewsletterGroup.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'NewsletterMessageHasNewsletterGroup.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseNewsletterMessageHasNewsletterGroup:save:post') as $callable)
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

			if ($this->aNewsletterMessage !== null) {
				if ($this->aNewsletterMessage->isModified() || $this->aNewsletterMessage->getCurrentNewsletterMessageI18n()->isModified()) {
					$affectedRows += $this->aNewsletterMessage->save($con);
				}
				$this->setNewsletterMessage($this->aNewsletterMessage);
			}

			if ($this->aNewsletterGroup !== null) {
				if ($this->aNewsletterGroup->isModified() || $this->aNewsletterGroup->getCurrentNewsletterGroupI18n()->isModified()) {
					$affectedRows += $this->aNewsletterGroup->save($con);
				}
				$this->setNewsletterGroup($this->aNewsletterGroup);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = NewsletterMessageHasNewsletterGroupPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += NewsletterMessageHasNewsletterGroupPeer::doUpdate($this, $con);
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

			if ($this->aNewsletterMessage !== null) {
				if (!$this->aNewsletterMessage->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aNewsletterMessage->getValidationFailures());
				}
			}

			if ($this->aNewsletterGroup !== null) {
				if (!$this->aNewsletterGroup->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aNewsletterGroup->getValidationFailures());
				}
			}


			if (($retval = NewsletterMessageHasNewsletterGroupPeer::doValidate($this, $columns)) !== true) {
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
		$pos = NewsletterMessageHasNewsletterGroupPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getNewsletterMessageId();
				break;
			case 3:
				return $this->getNewsletterGroupId();
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
		$keys = NewsletterMessageHasNewsletterGroupPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getNewsletterMessageId(),
			$keys[3] => $this->getNewsletterGroupId(),
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
		$pos = NewsletterMessageHasNewsletterGroupPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setNewsletterMessageId($value);
				break;
			case 3:
				$this->setNewsletterGroupId($value);
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
		$keys = NewsletterMessageHasNewsletterGroupPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setNewsletterMessageId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setNewsletterGroupId($arr[$keys[3]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(NewsletterMessageHasNewsletterGroupPeer::DATABASE_NAME);

		if ($this->isColumnModified(NewsletterMessageHasNewsletterGroupPeer::CREATED_AT)) $criteria->add(NewsletterMessageHasNewsletterGroupPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(NewsletterMessageHasNewsletterGroupPeer::UPDATED_AT)) $criteria->add(NewsletterMessageHasNewsletterGroupPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_MESSAGE_ID)) $criteria->add(NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_MESSAGE_ID, $this->newsletter_message_id);
		if ($this->isColumnModified(NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID)) $criteria->add(NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, $this->newsletter_group_id);

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
		$criteria = new Criteria(NewsletterMessageHasNewsletterGroupPeer::DATABASE_NAME);

		$criteria->add(NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_MESSAGE_ID, $this->newsletter_message_id);
		$criteria->add(NewsletterMessageHasNewsletterGroupPeer::NEWSLETTER_GROUP_ID, $this->newsletter_group_id);

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

		$pks[0] = $this->getNewsletterMessageId();

		$pks[1] = $this->getNewsletterGroupId();

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

		$this->setNewsletterMessageId($keys[0]);

		$this->setNewsletterGroupId($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of NewsletterMessageHasNewsletterGroup (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		$copyObj->setNew(true);

		$copyObj->setNewsletterMessageId(NULL); // this is a pkey column, so set to default value

		$copyObj->setNewsletterGroupId(NULL); // this is a pkey column, so set to default value

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
	 * @return     NewsletterMessageHasNewsletterGroup Clone of current object.
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
	 * @return     NewsletterMessageHasNewsletterGroupPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new NewsletterMessageHasNewsletterGroupPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a NewsletterMessage object.
	 *
	 * @param      NewsletterMessage $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setNewsletterMessage($v)
	{


		if ($v === null) {
			$this->setNewsletterMessageId(NULL);
		} else {
			$this->setNewsletterMessageId($v->getId());
		}


		$this->aNewsletterMessage = $v;
	}


	/**
	 * Get the associated NewsletterMessage object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     NewsletterMessage The associated NewsletterMessage object.
	 * @throws     PropelException
	 */
	public function getNewsletterMessage($con = null)
	{
		if ($this->aNewsletterMessage === null && ($this->newsletter_message_id !== null)) {
			// include the related Peer class
			$this->aNewsletterMessage = NewsletterMessagePeer::retrieveByPK($this->newsletter_message_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = NewsletterMessagePeer::retrieveByPK($this->newsletter_message_id, $con);
			   $obj->addNewsletterMessages($this);
			 */
		}
		return $this->aNewsletterMessage;
	}

	/**
	 * Declares an association between this object and a NewsletterGroup object.
	 *
	 * @param      NewsletterGroup $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setNewsletterGroup($v)
	{


		if ($v === null) {
			$this->setNewsletterGroupId(NULL);
		} else {
			$this->setNewsletterGroupId($v->getId());
		}


		$this->aNewsletterGroup = $v;
	}


	/**
	 * Get the associated NewsletterGroup object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     NewsletterGroup The associated NewsletterGroup object.
	 * @throws     PropelException
	 */
	public function getNewsletterGroup($con = null)
	{
		if ($this->aNewsletterGroup === null && ($this->newsletter_group_id !== null)) {
			// include the related Peer class
			$this->aNewsletterGroup = NewsletterGroupPeer::retrieveByPK($this->newsletter_group_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = NewsletterGroupPeer::retrieveByPK($this->newsletter_group_id, $con);
			   $obj->addNewsletterGroups($this);
			 */
		}
		return $this->aNewsletterGroup;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'NewsletterMessageHasNewsletterGroup.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseNewsletterMessageHasNewsletterGroup:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseNewsletterMessageHasNewsletterGroup::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseNewsletterMessageHasNewsletterGroup
