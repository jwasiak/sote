<?php

/**
 * Base class that represents a row from the 'st_admin_generator_filter_data' table.
 *
 * 
 *
 * @package    plugins.stAdminGeneratorPlugin.lib.model.om
 */
abstract class BaseAdminGeneratorFilterData extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        AdminGeneratorFilterDataPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the data field.
	 * @var        string
	 */
	protected $data;

	/**
	 * Collection to store aggregation of collAdminGeneratorFilters.
	 * @var        array
	 */
	protected $collAdminGeneratorFilters;

	/**
	 * The criteria used to select the current contents of collAdminGeneratorFilters.
	 * @var        Criteria
	 */
	protected $lastAdminGeneratorFilterCriteria = null;

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
     * Get the [data] column value.
     * 
     * @return     string
     */
    public function getData()
    {

            return $this->data;
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
          $this->modifiedColumns[] = AdminGeneratorFilterDataPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [data] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setData($v)
	{

        if ($this->data !== $v) {
          $this->data = $v;
          $this->modifiedColumns[] = AdminGeneratorFilterDataPeer::DATA;
        }

	} // setData()

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
      if ($this->getDispatcher()->getListeners('AdminGeneratorFilterData.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'AdminGeneratorFilterData.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->data = $rs->getString($startcol + 1) ? unserialize($rs->getString($startcol + 1)) : null;

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('AdminGeneratorFilterData.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'AdminGeneratorFilterData.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 2)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 2; // 2 = AdminGeneratorFilterDataPeer::NUM_COLUMNS - AdminGeneratorFilterDataPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating AdminGeneratorFilterData object", $e);
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

    if ($this->getDispatcher()->getListeners('AdminGeneratorFilterData.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'AdminGeneratorFilterData.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseAdminGeneratorFilterData:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseAdminGeneratorFilterData:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(AdminGeneratorFilterDataPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      AdminGeneratorFilterDataPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('AdminGeneratorFilterData.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'AdminGeneratorFilterData.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseAdminGeneratorFilterData:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseAdminGeneratorFilterData:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('AdminGeneratorFilterData.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'AdminGeneratorFilterData.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseAdminGeneratorFilterData:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(AdminGeneratorFilterDataPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('AdminGeneratorFilterData.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'AdminGeneratorFilterData.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseAdminGeneratorFilterData:save:post') as $callable)
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
              $o_data = $this->data;
              if (null !== $this->data && $this->isColumnModified(AdminGeneratorFilterDataPeer::DATA)) {
                  $this->data = serialize($this->data);
              }

				if ($this->isNew()) {
					$pk = AdminGeneratorFilterDataPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += AdminGeneratorFilterDataPeer::doUpdate($this, $con);
				}
				$this->resetModified();
             $this->data = $o_data;
 // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collAdminGeneratorFilters !== null) {
				foreach($this->collAdminGeneratorFilters as $referrerFK) {
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


			if (($retval = AdminGeneratorFilterDataPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collAdminGeneratorFilters !== null) {
					foreach($this->collAdminGeneratorFilters as $referrerFK) {
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
		$pos = AdminGeneratorFilterDataPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getData();
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
		$keys = AdminGeneratorFilterDataPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getData(),
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
		$pos = AdminGeneratorFilterDataPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setData($value);
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
		$keys = AdminGeneratorFilterDataPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setData($arr[$keys[1]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(AdminGeneratorFilterDataPeer::DATABASE_NAME);

		if ($this->isColumnModified(AdminGeneratorFilterDataPeer::ID)) $criteria->add(AdminGeneratorFilterDataPeer::ID, $this->id);
		if ($this->isColumnModified(AdminGeneratorFilterDataPeer::DATA)) $criteria->add(AdminGeneratorFilterDataPeer::DATA, $this->data);

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
		$criteria = new Criteria(AdminGeneratorFilterDataPeer::DATABASE_NAME);

		$criteria->add(AdminGeneratorFilterDataPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of AdminGeneratorFilterData (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setData($this->data);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getAdminGeneratorFilters() as $relObj) {
				$copyObj->addAdminGeneratorFilter($relObj->copy($deepCopy));
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
	 * @return     AdminGeneratorFilterData Clone of current object.
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
	 * @return     AdminGeneratorFilterDataPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new AdminGeneratorFilterDataPeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collAdminGeneratorFilters to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initAdminGeneratorFilters()
	{
		if ($this->collAdminGeneratorFilters === null) {
			$this->collAdminGeneratorFilters = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this AdminGeneratorFilterData has previously
	 * been saved, it will retrieve related AdminGeneratorFilters from storage.
	 * If this AdminGeneratorFilterData is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getAdminGeneratorFilters($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAdminGeneratorFilters === null) {
			if ($this->isNew()) {
			   $this->collAdminGeneratorFilters = array();
			} else {

				$criteria->add(AdminGeneratorFilterPeer::DATA_ID, $this->getId());

				AdminGeneratorFilterPeer::addSelectColumns($criteria);
				$this->collAdminGeneratorFilters = AdminGeneratorFilterPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AdminGeneratorFilterPeer::DATA_ID, $this->getId());

				AdminGeneratorFilterPeer::addSelectColumns($criteria);
				if (!isset($this->lastAdminGeneratorFilterCriteria) || !$this->lastAdminGeneratorFilterCriteria->equals($criteria)) {
					$this->collAdminGeneratorFilters = AdminGeneratorFilterPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAdminGeneratorFilterCriteria = $criteria;
		return $this->collAdminGeneratorFilters;
	}

	/**
	 * Returns the number of related AdminGeneratorFilters.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countAdminGeneratorFilters($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AdminGeneratorFilterPeer::DATA_ID, $this->getId());

		return AdminGeneratorFilterPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a AdminGeneratorFilter object to this object
	 * through the AdminGeneratorFilter foreign key attribute
	 *
	 * @param      AdminGeneratorFilter $l AdminGeneratorFilter
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAdminGeneratorFilter(AdminGeneratorFilter $l)
	{
		$this->collAdminGeneratorFilters[] = $l;
		$l->setAdminGeneratorFilterData($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this AdminGeneratorFilterData is new, it will return
	 * an empty collection; or if this AdminGeneratorFilterData has previously
	 * been saved, it will retrieve related AdminGeneratorFilters from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in AdminGeneratorFilterData.
	 */
	public function getAdminGeneratorFiltersJoinsfGuardUser($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAdminGeneratorFilters === null) {
			if ($this->isNew()) {
				$this->collAdminGeneratorFilters = array();
			} else {

				$criteria->add(AdminGeneratorFilterPeer::DATA_ID, $this->getId());

				$this->collAdminGeneratorFilters = AdminGeneratorFilterPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AdminGeneratorFilterPeer::DATA_ID, $this->getId());

			if (!isset($this->lastAdminGeneratorFilterCriteria) || !$this->lastAdminGeneratorFilterCriteria->equals($criteria)) {
				$this->collAdminGeneratorFilters = AdminGeneratorFilterPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastAdminGeneratorFilterCriteria = $criteria;

		return $this->collAdminGeneratorFilters;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'AdminGeneratorFilterData.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseAdminGeneratorFilterData:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseAdminGeneratorFilterData::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseAdminGeneratorFilterData
