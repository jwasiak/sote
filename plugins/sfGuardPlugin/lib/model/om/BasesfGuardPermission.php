<?php

/**
 * Base class that represents a row from the 'sf_guard_permission' table.
 *
 * 
 *
 * @package    plugins.sfGuardPlugin.lib.model.om
 */
abstract class BasesfGuardPermission extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        sfGuardPermissionPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;

	/**
	 * Collection to store aggregation of collsfGuardGroupPermissions.
	 * @var        array
	 */
	protected $collsfGuardGroupPermissions;

	/**
	 * The criteria used to select the current contents of collsfGuardGroupPermissions.
	 * @var        Criteria
	 */
	protected $lastsfGuardGroupPermissionCriteria = null;

	/**
	 * Collection to store aggregation of collsfGuardUserPermissions.
	 * @var        array
	 */
	protected $collsfGuardUserPermissions;

	/**
	 * The criteria used to select the current contents of collsfGuardUserPermissions.
	 * @var        Criteria
	 */
	protected $lastsfGuardUserPermissionCriteria = null;

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
     * Get the [id] column value.
     * 
     * @return     int
     */
    public function getId()
    {

            return $this->id;
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
     * Get the [description] column value.
     * 
     * @return     string
     */
    public function getDescription()
    {

            return $this->description;
    }

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
          $this->modifiedColumns[] = sfGuardPermissionPeer::ID;
        }

	} // setId()

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
          $this->modifiedColumns[] = sfGuardPermissionPeer::NAME;
        }

	} // setName()

	/**
	 * Set the value of [description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->description !== $v) {
          $this->description = $v;
          $this->modifiedColumns[] = sfGuardPermissionPeer::DESCRIPTION;
        }

	} // setDescription()

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
      if ($this->getDispatcher()->getListeners('sfGuardPermission.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardPermission.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->name = $rs->getString($startcol + 1);

      $this->description = $rs->getString($startcol + 2);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('sfGuardPermission.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardPermission.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 3)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 3; // 3 = sfGuardPermissionPeer::NUM_COLUMNS - sfGuardPermissionPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating sfGuardPermission object", $e);
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

    if ($this->getDispatcher()->getListeners('sfGuardPermission.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardPermission.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasesfGuardPermission:delete:pre'))
    {
      foreach (sfMixer::getCallables('BasesfGuardPermission:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(sfGuardPermissionPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      sfGuardPermissionPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('sfGuardPermission.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardPermission.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasesfGuardPermission:delete:post'))
    {
      foreach (sfMixer::getCallables('BasesfGuardPermission:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('sfGuardPermission.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardPermission.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BasesfGuardPermission:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(sfGuardPermissionPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('sfGuardPermission.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'sfGuardPermission.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BasesfGuardPermission:save:post') as $callable)
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
					$pk = sfGuardPermissionPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += sfGuardPermissionPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collsfGuardGroupPermissions !== null) {
				foreach($this->collsfGuardGroupPermissions as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collsfGuardUserPermissions !== null) {
				foreach($this->collsfGuardUserPermissions as $referrerFK) {
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


			if (($retval = sfGuardPermissionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collsfGuardGroupPermissions !== null) {
					foreach($this->collsfGuardGroupPermissions as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collsfGuardUserPermissions !== null) {
					foreach($this->collsfGuardUserPermissions as $referrerFK) {
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
		$pos = sfGuardPermissionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getId();
				break;
			case 1:
				return $this->getName();
				break;
			case 2:
				return $this->getDescription();
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
		$keys = sfGuardPermissionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getDescription(),
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
		$pos = sfGuardPermissionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setId($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setDescription($value);
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
		$keys = sfGuardPermissionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDescription($arr[$keys[2]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(sfGuardPermissionPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfGuardPermissionPeer::ID)) $criteria->add(sfGuardPermissionPeer::ID, $this->id);
		if ($this->isColumnModified(sfGuardPermissionPeer::NAME)) $criteria->add(sfGuardPermissionPeer::NAME, $this->name);
		if ($this->isColumnModified(sfGuardPermissionPeer::DESCRIPTION)) $criteria->add(sfGuardPermissionPeer::DESCRIPTION, $this->description);

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
		$criteria = new Criteria(sfGuardPermissionPeer::DATABASE_NAME);

		$criteria->add(sfGuardPermissionPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of sfGuardPermission (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setDescription($this->description);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getsfGuardGroupPermissions() as $relObj) {
				$copyObj->addsfGuardGroupPermission($relObj->copy($deepCopy));
			}

			foreach($this->getsfGuardUserPermissions() as $relObj) {
				$copyObj->addsfGuardUserPermission($relObj->copy($deepCopy));
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
	 * @return     sfGuardPermission Clone of current object.
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
	 * @return     sfGuardPermissionPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new sfGuardPermissionPeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collsfGuardGroupPermissions to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initsfGuardGroupPermissions()
	{
		if ($this->collsfGuardGroupPermissions === null) {
			$this->collsfGuardGroupPermissions = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardPermission has previously
	 * been saved, it will retrieve related sfGuardGroupPermissions from storage.
	 * If this sfGuardPermission is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getsfGuardGroupPermissions($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardGroupPermissions === null) {
			if ($this->isNew()) {
			   $this->collsfGuardGroupPermissions = array();
			} else {

				$criteria->add(sfGuardGroupPermissionPeer::PERMISSION_ID, $this->getId());

				sfGuardGroupPermissionPeer::addSelectColumns($criteria);
				$this->collsfGuardGroupPermissions = sfGuardGroupPermissionPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(sfGuardGroupPermissionPeer::PERMISSION_ID, $this->getId());

				sfGuardGroupPermissionPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfGuardGroupPermissionCriteria) || !$this->lastsfGuardGroupPermissionCriteria->equals($criteria)) {
					$this->collsfGuardGroupPermissions = sfGuardGroupPermissionPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfGuardGroupPermissionCriteria = $criteria;
		return $this->collsfGuardGroupPermissions;
	}

	/**
	 * Returns the number of related sfGuardGroupPermissions.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countsfGuardGroupPermissions($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfGuardGroupPermissionPeer::PERMISSION_ID, $this->getId());

		return sfGuardGroupPermissionPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a sfGuardGroupPermission object to this object
	 * through the sfGuardGroupPermission foreign key attribute
	 *
	 * @param      sfGuardGroupPermission $l sfGuardGroupPermission
	 * @return     void
	 * @throws     PropelException
	 */
	public function addsfGuardGroupPermission(sfGuardGroupPermission $l)
	{
		$this->collsfGuardGroupPermissions[] = $l;
		$l->setsfGuardPermission($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardPermission is new, it will return
	 * an empty collection; or if this sfGuardPermission has previously
	 * been saved, it will retrieve related sfGuardGroupPermissions from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardPermission.
	 */
	public function getsfGuardGroupPermissionsJoinsfGuardGroup($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardGroupPermissions === null) {
			if ($this->isNew()) {
				$this->collsfGuardGroupPermissions = array();
			} else {

				$criteria->add(sfGuardGroupPermissionPeer::PERMISSION_ID, $this->getId());

				$this->collsfGuardGroupPermissions = sfGuardGroupPermissionPeer::doSelectJoinsfGuardGroup($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(sfGuardGroupPermissionPeer::PERMISSION_ID, $this->getId());

			if (!isset($this->lastsfGuardGroupPermissionCriteria) || !$this->lastsfGuardGroupPermissionCriteria->equals($criteria)) {
				$this->collsfGuardGroupPermissions = sfGuardGroupPermissionPeer::doSelectJoinsfGuardGroup($criteria, $con);
			}
		}
		$this->lastsfGuardGroupPermissionCriteria = $criteria;

		return $this->collsfGuardGroupPermissions;
	}

	/**
	 * Temporary storage of collsfGuardUserPermissions to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initsfGuardUserPermissions()
	{
		if ($this->collsfGuardUserPermissions === null) {
			$this->collsfGuardUserPermissions = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardPermission has previously
	 * been saved, it will retrieve related sfGuardUserPermissions from storage.
	 * If this sfGuardPermission is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getsfGuardUserPermissions($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUserPermissions === null) {
			if ($this->isNew()) {
			   $this->collsfGuardUserPermissions = array();
			} else {

				$criteria->add(sfGuardUserPermissionPeer::PERMISSION_ID, $this->getId());

				sfGuardUserPermissionPeer::addSelectColumns($criteria);
				$this->collsfGuardUserPermissions = sfGuardUserPermissionPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(sfGuardUserPermissionPeer::PERMISSION_ID, $this->getId());

				sfGuardUserPermissionPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfGuardUserPermissionCriteria) || !$this->lastsfGuardUserPermissionCriteria->equals($criteria)) {
					$this->collsfGuardUserPermissions = sfGuardUserPermissionPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfGuardUserPermissionCriteria = $criteria;
		return $this->collsfGuardUserPermissions;
	}

	/**
	 * Returns the number of related sfGuardUserPermissions.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countsfGuardUserPermissions($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfGuardUserPermissionPeer::PERMISSION_ID, $this->getId());

		return sfGuardUserPermissionPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a sfGuardUserPermission object to this object
	 * through the sfGuardUserPermission foreign key attribute
	 *
	 * @param      sfGuardUserPermission $l sfGuardUserPermission
	 * @return     void
	 * @throws     PropelException
	 */
	public function addsfGuardUserPermission(sfGuardUserPermission $l)
	{
		$this->collsfGuardUserPermissions[] = $l;
		$l->setsfGuardPermission($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfGuardPermission is new, it will return
	 * an empty collection; or if this sfGuardPermission has previously
	 * been saved, it will retrieve related sfGuardUserPermissions from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfGuardPermission.
	 */
	public function getsfGuardUserPermissionsJoinsfGuardUser($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUserPermissions === null) {
			if ($this->isNew()) {
				$this->collsfGuardUserPermissions = array();
			} else {

				$criteria->add(sfGuardUserPermissionPeer::PERMISSION_ID, $this->getId());

				$this->collsfGuardUserPermissions = sfGuardUserPermissionPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(sfGuardUserPermissionPeer::PERMISSION_ID, $this->getId());

			if (!isset($this->lastsfGuardUserPermissionCriteria) || !$this->lastsfGuardUserPermissionCriteria->equals($criteria)) {
				$this->collsfGuardUserPermissions = sfGuardUserPermissionPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastsfGuardUserPermissionCriteria = $criteria;

		return $this->collsfGuardUserPermissions;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'sfGuardPermission.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BasesfGuardPermission:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BasesfGuardPermission::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BasesfGuardPermission
