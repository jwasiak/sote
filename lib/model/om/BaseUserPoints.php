<?php

/**
 * Base class that represents a row from the 'st_user_points' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseUserPoints extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        UserPointsPeer
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
	 * The value for the points field.
	 * @var        int
	 */
	protected $points = 0;


	/**
	 * The value for the change_points field.
	 * @var        int
	 */
	protected $change_points = 0;


	/**
	 * The value for the change_points_varchar field.
	 * @var        string
	 */
	protected $change_points_varchar;


	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;


	/**
	 * The value for the order_id field.
	 * @var        int
	 */
	protected $order_id;


	/**
	 * The value for the order_number field.
	 * @var        string
	 */
	protected $order_number;


	/**
	 * The value for the order_hash field.
	 * @var        string
	 */
	protected $order_hash;


	/**
	 * The value for the admin_id field.
	 * @var        int
	 */
	protected $admin_id;

	/**
	 * @var        sfGuardUser
	 */
	protected $asfGuardUserRelatedBySfGuardUserId;

	/**
	 * @var        Order
	 */
	protected $aOrder;

	/**
	 * @var        sfGuardUser
	 */
	protected $asfGuardUserRelatedByAdminId;

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
     * Get the [points] column value.
     * 
     * @return     int
     */
    public function getPoints()
    {

            return $this->points;
    }

    /**
     * Get the [change_points] column value.
     * 
     * @return     int
     */
    public function getChangePoints()
    {

            return $this->change_points;
    }

    /**
     * Get the [change_points_varchar] column value.
     * 
     * @return     string
     */
    public function getChangePointsVarchar()
    {

            return $this->change_points_varchar;
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
     * Get the [order_id] column value.
     * 
     * @return     int
     */
    public function getOrderId()
    {

            return $this->order_id;
    }

    /**
     * Get the [order_number] column value.
     * 
     * @return     string
     */
    public function getOrderNumber()
    {

            return $this->order_number;
    }

    /**
     * Get the [order_hash] column value.
     * 
     * @return     string
     */
    public function getOrderHash()
    {

            return $this->order_hash;
    }

    /**
     * Get the [admin_id] column value.
     * 
     * @return     int
     */
    public function getAdminId()
    {

            return $this->admin_id;
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
			$this->modifiedColumns[] = UserPointsPeer::CREATED_AT;
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
			$this->modifiedColumns[] = UserPointsPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = UserPointsPeer::ID;
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
          $this->modifiedColumns[] = UserPointsPeer::SF_GUARD_USER_ID;
        }

		if ($this->asfGuardUserRelatedBySfGuardUserId !== null && $this->asfGuardUserRelatedBySfGuardUserId->getId() !== $v) {
			$this->asfGuardUserRelatedBySfGuardUserId = null;
		}

	} // setSfGuardUserId()

	/**
	 * Set the value of [points] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPoints($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->points !== $v || $v === 0) {
          $this->points = $v;
          $this->modifiedColumns[] = UserPointsPeer::POINTS;
        }

	} // setPoints()

	/**
	 * Set the value of [change_points] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setChangePoints($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->change_points !== $v || $v === 0) {
          $this->change_points = $v;
          $this->modifiedColumns[] = UserPointsPeer::CHANGE_POINTS;
        }

	} // setChangePoints()

	/**
	 * Set the value of [change_points_varchar] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setChangePointsVarchar($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->change_points_varchar !== $v) {
          $this->change_points_varchar = $v;
          $this->modifiedColumns[] = UserPointsPeer::CHANGE_POINTS_VARCHAR;
        }

	} // setChangePointsVarchar()

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
          $this->modifiedColumns[] = UserPointsPeer::DESCRIPTION;
        }

	} // setDescription()

	/**
	 * Set the value of [order_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOrderId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->order_id !== $v) {
          $this->order_id = $v;
          $this->modifiedColumns[] = UserPointsPeer::ORDER_ID;
        }

		if ($this->aOrder !== null && $this->aOrder->getId() !== $v) {
			$this->aOrder = null;
		}

	} // setOrderId()

	/**
	 * Set the value of [order_number] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOrderNumber($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->order_number !== $v) {
          $this->order_number = $v;
          $this->modifiedColumns[] = UserPointsPeer::ORDER_NUMBER;
        }

	} // setOrderNumber()

	/**
	 * Set the value of [order_hash] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOrderHash($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->order_hash !== $v) {
          $this->order_hash = $v;
          $this->modifiedColumns[] = UserPointsPeer::ORDER_HASH;
        }

	} // setOrderHash()

	/**
	 * Set the value of [admin_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setAdminId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->admin_id !== $v) {
          $this->admin_id = $v;
          $this->modifiedColumns[] = UserPointsPeer::ADMIN_ID;
        }

		if ($this->asfGuardUserRelatedByAdminId !== null && $this->asfGuardUserRelatedByAdminId->getId() !== $v) {
			$this->asfGuardUserRelatedByAdminId = null;
		}

	} // setAdminId()

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
      if ($this->getDispatcher()->getListeners('UserPoints.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'UserPoints.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->sf_guard_user_id = $rs->getInt($startcol + 3);

      $this->points = $rs->getInt($startcol + 4);

      $this->change_points = $rs->getInt($startcol + 5);

      $this->change_points_varchar = $rs->getString($startcol + 6);

      $this->description = $rs->getString($startcol + 7);

      $this->order_id = $rs->getInt($startcol + 8);

      $this->order_number = $rs->getString($startcol + 9);

      $this->order_hash = $rs->getString($startcol + 10);

      $this->admin_id = $rs->getInt($startcol + 11);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('UserPoints.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'UserPoints.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 12)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 12; // 12 = UserPointsPeer::NUM_COLUMNS - UserPointsPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating UserPoints object", $e);
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

    if ($this->getDispatcher()->getListeners('UserPoints.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'UserPoints.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseUserPoints:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseUserPoints:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(UserPointsPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      UserPointsPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('UserPoints.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'UserPoints.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseUserPoints:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseUserPoints:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('UserPoints.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'UserPoints.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseUserPoints:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(UserPointsPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(UserPointsPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(UserPointsPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('UserPoints.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'UserPoints.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseUserPoints:save:post') as $callable)
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

			if ($this->asfGuardUserRelatedBySfGuardUserId !== null) {
				if ($this->asfGuardUserRelatedBySfGuardUserId->isModified()) {
					$affectedRows += $this->asfGuardUserRelatedBySfGuardUserId->save($con);
				}
				$this->setsfGuardUserRelatedBySfGuardUserId($this->asfGuardUserRelatedBySfGuardUserId);
			}

			if ($this->aOrder !== null) {
				if ($this->aOrder->isModified()) {
					$affectedRows += $this->aOrder->save($con);
				}
				$this->setOrder($this->aOrder);
			}

			if ($this->asfGuardUserRelatedByAdminId !== null) {
				if ($this->asfGuardUserRelatedByAdminId->isModified()) {
					$affectedRows += $this->asfGuardUserRelatedByAdminId->save($con);
				}
				$this->setsfGuardUserRelatedByAdminId($this->asfGuardUserRelatedByAdminId);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = UserPointsPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += UserPointsPeer::doUpdate($this, $con);
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

			if ($this->asfGuardUserRelatedBySfGuardUserId !== null) {
				if (!$this->asfGuardUserRelatedBySfGuardUserId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUserRelatedBySfGuardUserId->getValidationFailures());
				}
			}

			if ($this->aOrder !== null) {
				if (!$this->aOrder->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOrder->getValidationFailures());
				}
			}

			if ($this->asfGuardUserRelatedByAdminId !== null) {
				if (!$this->asfGuardUserRelatedByAdminId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUserRelatedByAdminId->getValidationFailures());
				}
			}


			if (($retval = UserPointsPeer::doValidate($this, $columns)) !== true) {
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
		$pos = UserPointsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getPoints();
				break;
			case 5:
				return $this->getChangePoints();
				break;
			case 6:
				return $this->getChangePointsVarchar();
				break;
			case 7:
				return $this->getDescription();
				break;
			case 8:
				return $this->getOrderId();
				break;
			case 9:
				return $this->getOrderNumber();
				break;
			case 10:
				return $this->getOrderHash();
				break;
			case 11:
				return $this->getAdminId();
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
		$keys = UserPointsPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getSfGuardUserId(),
			$keys[4] => $this->getPoints(),
			$keys[5] => $this->getChangePoints(),
			$keys[6] => $this->getChangePointsVarchar(),
			$keys[7] => $this->getDescription(),
			$keys[8] => $this->getOrderId(),
			$keys[9] => $this->getOrderNumber(),
			$keys[10] => $this->getOrderHash(),
			$keys[11] => $this->getAdminId(),
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
		$pos = UserPointsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setPoints($value);
				break;
			case 5:
				$this->setChangePoints($value);
				break;
			case 6:
				$this->setChangePointsVarchar($value);
				break;
			case 7:
				$this->setDescription($value);
				break;
			case 8:
				$this->setOrderId($value);
				break;
			case 9:
				$this->setOrderNumber($value);
				break;
			case 10:
				$this->setOrderHash($value);
				break;
			case 11:
				$this->setAdminId($value);
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
		$keys = UserPointsPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSfGuardUserId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPoints($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setChangePoints($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setChangePointsVarchar($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setDescription($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setOrderId($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setOrderNumber($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setOrderHash($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setAdminId($arr[$keys[11]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(UserPointsPeer::DATABASE_NAME);

		if ($this->isColumnModified(UserPointsPeer::CREATED_AT)) $criteria->add(UserPointsPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(UserPointsPeer::UPDATED_AT)) $criteria->add(UserPointsPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(UserPointsPeer::ID)) $criteria->add(UserPointsPeer::ID, $this->id);
		if ($this->isColumnModified(UserPointsPeer::SF_GUARD_USER_ID)) $criteria->add(UserPointsPeer::SF_GUARD_USER_ID, $this->sf_guard_user_id);
		if ($this->isColumnModified(UserPointsPeer::POINTS)) $criteria->add(UserPointsPeer::POINTS, $this->points);
		if ($this->isColumnModified(UserPointsPeer::CHANGE_POINTS)) $criteria->add(UserPointsPeer::CHANGE_POINTS, $this->change_points);
		if ($this->isColumnModified(UserPointsPeer::CHANGE_POINTS_VARCHAR)) $criteria->add(UserPointsPeer::CHANGE_POINTS_VARCHAR, $this->change_points_varchar);
		if ($this->isColumnModified(UserPointsPeer::DESCRIPTION)) $criteria->add(UserPointsPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(UserPointsPeer::ORDER_ID)) $criteria->add(UserPointsPeer::ORDER_ID, $this->order_id);
		if ($this->isColumnModified(UserPointsPeer::ORDER_NUMBER)) $criteria->add(UserPointsPeer::ORDER_NUMBER, $this->order_number);
		if ($this->isColumnModified(UserPointsPeer::ORDER_HASH)) $criteria->add(UserPointsPeer::ORDER_HASH, $this->order_hash);
		if ($this->isColumnModified(UserPointsPeer::ADMIN_ID)) $criteria->add(UserPointsPeer::ADMIN_ID, $this->admin_id);

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
		$criteria = new Criteria(UserPointsPeer::DATABASE_NAME);

		$criteria->add(UserPointsPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of UserPoints (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setSfGuardUserId($this->sf_guard_user_id);

		$copyObj->setPoints($this->points);

		$copyObj->setChangePoints($this->change_points);

		$copyObj->setChangePointsVarchar($this->change_points_varchar);

		$copyObj->setDescription($this->description);

		$copyObj->setOrderId($this->order_id);

		$copyObj->setOrderNumber($this->order_number);

		$copyObj->setOrderHash($this->order_hash);

		$copyObj->setAdminId($this->admin_id);


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
	 * @return     UserPoints Clone of current object.
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
	 * @return     UserPointsPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new UserPointsPeer();
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
	public function setsfGuardUserRelatedBySfGuardUserId($v)
	{


		if ($v === null) {
			$this->setSfGuardUserId(NULL);
		} else {
			$this->setSfGuardUserId($v->getId());
		}


		$this->asfGuardUserRelatedBySfGuardUserId = $v;
	}


	/**
	 * Get the associated sfGuardUser object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     sfGuardUser The associated sfGuardUser object.
	 * @throws     PropelException
	 */
	public function getsfGuardUserRelatedBySfGuardUserId($con = null)
	{
		if ($this->asfGuardUserRelatedBySfGuardUserId === null && ($this->sf_guard_user_id !== null)) {
			// include the related Peer class
			$this->asfGuardUserRelatedBySfGuardUserId = sfGuardUserPeer::retrieveByPK($this->sf_guard_user_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = sfGuardUserPeer::retrieveByPK($this->sf_guard_user_id, $con);
			   $obj->addsfGuardUsersRelatedBySfGuardUserId($this);
			 */
		}
		return $this->asfGuardUserRelatedBySfGuardUserId;
	}

	/**
	 * Declares an association between this object and a Order object.
	 *
	 * @param      Order $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setOrder($v)
	{


		if ($v === null) {
			$this->setOrderId(NULL);
		} else {
			$this->setOrderId($v->getId());
		}


		$this->aOrder = $v;
	}


	/**
	 * Get the associated Order object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Order The associated Order object.
	 * @throws     PropelException
	 */
	public function getOrder($con = null)
	{
		if ($this->aOrder === null && ($this->order_id !== null)) {
			// include the related Peer class
			$this->aOrder = OrderPeer::retrieveByPK($this->order_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = OrderPeer::retrieveByPK($this->order_id, $con);
			   $obj->addOrders($this);
			 */
		}
		return $this->aOrder;
	}

	/**
	 * Declares an association between this object and a sfGuardUser object.
	 *
	 * @param      sfGuardUser $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setsfGuardUserRelatedByAdminId($v)
	{


		if ($v === null) {
			$this->setAdminId(NULL);
		} else {
			$this->setAdminId($v->getId());
		}


		$this->asfGuardUserRelatedByAdminId = $v;
	}


	/**
	 * Get the associated sfGuardUser object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     sfGuardUser The associated sfGuardUser object.
	 * @throws     PropelException
	 */
	public function getsfGuardUserRelatedByAdminId($con = null)
	{
		if ($this->asfGuardUserRelatedByAdminId === null && ($this->admin_id !== null)) {
			// include the related Peer class
			$this->asfGuardUserRelatedByAdminId = sfGuardUserPeer::retrieveByPK($this->admin_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = sfGuardUserPeer::retrieveByPK($this->admin_id, $con);
			   $obj->addsfGuardUsersRelatedByAdminId($this);
			 */
		}
		return $this->asfGuardUserRelatedByAdminId;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'UserPoints.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseUserPoints:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseUserPoints::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseUserPoints
