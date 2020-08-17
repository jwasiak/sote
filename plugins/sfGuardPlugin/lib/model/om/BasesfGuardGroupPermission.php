<?php

/**
 * Base class that represents a row from the 'sf_guard_group_permission' table.
 *
 * 
 *
 * @package    plugins.sfGuardPlugin.lib.model.om
 */
abstract class BasesfGuardGroupPermission extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        sfGuardGroupPermissionPeer
	 */
	protected static $peer;


	/**
	 * The value for the group_id field.
	 * @var        int
	 */
	protected $group_id;


	/**
	 * The value for the permission_id field.
	 * @var        int
	 */
	protected $permission_id;

	/**
	 * @var        sfGuardGroup
	 */
	protected $asfGuardGroup;

	/**
	 * @var        sfGuardPermission
	 */
	protected $asfGuardPermission;

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
     * Get the [group_id] column value.
     * 
     * @return     int
     */
    public function getGroupId()
    {

            return $this->group_id;
    }

    /**
     * Get the [permission_id] column value.
     * 
     * @return     int
     */
    public function getPermissionId()
    {

            return $this->permission_id;
    }

	/**
	 * Set the value of [group_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setGroupId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->group_id !== $v) {
          $this->group_id = $v;
          $this->modifiedColumns[] = sfGuardGroupPermissionPeer::GROUP_ID;
        }

		if ($this->asfGuardGroup !== null && $this->asfGuardGroup->getId() !== $v) {
			$this->asfGuardGroup = null;
		}

	} // setGroupId()

	/**
	 * Set the value of [permission_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPermissionId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->permission_id !== $v) {
          $this->permission_id = $v;
          $this->modifiedColumns[] = sfGuardGroupPermissionPeer::PERMISSION_ID;
        }

		if ($this->asfGuardPermission !== null && $this->asfGuardPermission->getId() !== $v) {
			$this->asfGuardPermission = null;
		}

	} // setPermissionId()

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
      if ($this->getDispatcher()->getListeners('sfGuardGroupPermission.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardGroupPermission.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->group_id = $rs->getInt($startcol + 0);

      $this->permission_id = $rs->getInt($startcol + 1);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('sfGuardGroupPermission.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardGroupPermission.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 2)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 2; // 2 = sfGuardGroupPermissionPeer::NUM_COLUMNS - sfGuardGroupPermissionPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating sfGuardGroupPermission object", $e);
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

    if ($this->getDispatcher()->getListeners('sfGuardGroupPermission.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardGroupPermission.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasesfGuardGroupPermission:delete:pre'))
    {
      foreach (sfMixer::getCallables('BasesfGuardGroupPermission:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      sfGuardGroupPermissionPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('sfGuardGroupPermission.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardGroupPermission.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasesfGuardGroupPermission:delete:post'))
    {
      foreach (sfMixer::getCallables('BasesfGuardGroupPermission:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('sfGuardGroupPermission.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardGroupPermission.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BasesfGuardGroupPermission:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('sfGuardGroupPermission.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardGroupPermission.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BasesfGuardGroupPermission:save:post') as $callable)
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

			if ($this->asfGuardGroup !== null) {
				if ($this->asfGuardGroup->isModified()) {
					$affectedRows += $this->asfGuardGroup->save($con);
				}
				$this->setsfGuardGroup($this->asfGuardGroup);
			}

			if ($this->asfGuardPermission !== null) {
				if ($this->asfGuardPermission->isModified()) {
					$affectedRows += $this->asfGuardPermission->save($con);
				}
				$this->setsfGuardPermission($this->asfGuardPermission);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfGuardGroupPermissionPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += sfGuardGroupPermissionPeer::doUpdate($this, $con);
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

			if ($this->asfGuardGroup !== null) {
				if (!$this->asfGuardGroup->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardGroup->getValidationFailures());
				}
			}

			if ($this->asfGuardPermission !== null) {
				if (!$this->asfGuardPermission->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardPermission->getValidationFailures());
				}
			}


			if (($retval = sfGuardGroupPermissionPeer::doValidate($this, $columns)) !== true) {
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
		$pos = sfGuardGroupPermissionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getGroupId();
				break;
			case 1:
				return $this->getPermissionId();
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
		$keys = sfGuardGroupPermissionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getGroupId(),
			$keys[1] => $this->getPermissionId(),
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
		$pos = sfGuardGroupPermissionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setGroupId($value);
				break;
			case 1:
				$this->setPermissionId($value);
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
		$keys = sfGuardGroupPermissionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setGroupId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPermissionId($arr[$keys[1]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(sfGuardGroupPermissionPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfGuardGroupPermissionPeer::GROUP_ID)) $criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->group_id);
		if ($this->isColumnModified(sfGuardGroupPermissionPeer::PERMISSION_ID)) $criteria->add(sfGuardGroupPermissionPeer::PERMISSION_ID, $this->permission_id);

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
		$criteria = new Criteria(sfGuardGroupPermissionPeer::DATABASE_NAME);

		$criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->group_id);
		$criteria->add(sfGuardGroupPermissionPeer::PERMISSION_ID, $this->permission_id);

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

		$pks[0] = $this->getGroupId();

		$pks[1] = $this->getPermissionId();

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

		$this->setGroupId($keys[0]);

		$this->setPermissionId($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of sfGuardGroupPermission (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{


		$copyObj->setNew(true);

		$copyObj->setGroupId(NULL); // this is a pkey column, so set to default value

		$copyObj->setPermissionId(NULL); // this is a pkey column, so set to default value

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
	 * @return     sfGuardGroupPermission Clone of current object.
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
	 * @return     sfGuardGroupPermissionPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new sfGuardGroupPermissionPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a sfGuardGroup object.
	 *
	 * @param      sfGuardGroup $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setsfGuardGroup($v)
	{


		if ($v === null) {
			$this->setGroupId(NULL);
		} else {
			$this->setGroupId($v->getId());
		}


		$this->asfGuardGroup = $v;
	}


	/**
	 * Get the associated sfGuardGroup object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     sfGuardGroup The associated sfGuardGroup object.
	 * @throws     PropelException
	 */
	public function getsfGuardGroup($con = null)
	{
		if ($this->asfGuardGroup === null && ($this->group_id !== null)) {
			// include the related Peer class
			$this->asfGuardGroup = sfGuardGroupPeer::retrieveByPK($this->group_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = sfGuardGroupPeer::retrieveByPK($this->group_id, $con);
			   $obj->addsfGuardGroups($this);
			 */
		}
		return $this->asfGuardGroup;
	}

	/**
	 * Declares an association between this object and a sfGuardPermission object.
	 *
	 * @param      sfGuardPermission $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setsfGuardPermission($v)
	{


		if ($v === null) {
			$this->setPermissionId(NULL);
		} else {
			$this->setPermissionId($v->getId());
		}


		$this->asfGuardPermission = $v;
	}


	/**
	 * Get the associated sfGuardPermission object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     sfGuardPermission The associated sfGuardPermission object.
	 * @throws     PropelException
	 */
	public function getsfGuardPermission($con = null)
	{
		if ($this->asfGuardPermission === null && ($this->permission_id !== null)) {
			// include the related Peer class
			$this->asfGuardPermission = sfGuardPermissionPeer::retrieveByPK($this->permission_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = sfGuardPermissionPeer::retrieveByPK($this->permission_id, $con);
			   $obj->addsfGuardPermissions($this);
			 */
		}
		return $this->asfGuardPermission;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'sfGuardGroupPermission.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BasesfGuardGroupPermission:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BasesfGuardGroupPermission::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BasesfGuardGroupPermission
