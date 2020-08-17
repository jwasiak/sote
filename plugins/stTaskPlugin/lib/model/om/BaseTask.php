<?php

/**
 * Base class that represents a row from the 'st_task' table.
 *
 * 
 *
 * @package    plugins.stTaskPlugin.lib.model.om
 */
abstract class BaseTask extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        TaskPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the is_active field.
	 * @var        boolean
	 */
	protected $is_active = true;


	/**
	 * The value for the task_id field.
	 * @var        string
	 */
	protected $task_id;


	/**
	 * The value for the task_priority field.
	 * @var        int
	 */
	protected $task_priority = 0;


	/**
	 * The value for the status field.
	 * @var        int
	 */
	protected $status = 0;


	/**
	 * The value for the time_interval field.
	 * @var        int
	 */
	protected $time_interval;


	/**
	 * The value for the execute_at field.
	 * @var        int
	 */
	protected $execute_at;


	/**
	 * The value for the last_executed_at field.
	 * @var        int
	 */
	protected $last_executed_at;


	/**
	 * The value for the last_finished_at field.
	 * @var        int
	 */
	protected $last_finished_at;


	/**
	 * The value for the last_active_at field.
	 * @var        int
	 */
	protected $last_active_at;

	/**
	 * Collection to store aggregation of collTaskLogs.
	 * @var        array
	 */
	protected $collTaskLogs;

	/**
	 * The criteria used to select the current contents of collTaskLogs.
	 * @var        Criteria
	 */
	protected $lastTaskLogCriteria = null;

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
     * Get the [is_active] column value.
     * 
     * @return     boolean
     */
    public function getIsActive()
    {

            return $this->is_active;
    }

    /**
     * Get the [task_id] column value.
     * 
     * @return     string
     */
    public function getTaskId()
    {

            return $this->task_id;
    }

    /**
     * Get the [task_priority] column value.
     * 
     * @return     int
     */
    public function getTaskPriority()
    {

            return $this->task_priority;
    }

    /**
     * Get the [status] column value.
     * 
     * @return     int
     */
    public function getStatus()
    {

            return $this->status;
    }

    /**
     * Get the [time_interval] column value.
     * 
     * @return     int
     */
    public function getTimeInterval()
    {

            return $this->time_interval;
    }

	/**
	 * Get the [optionally formatted] [execute_at] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getExecuteAt($format = 'H:i:s')
	{

		if ($this->execute_at === null || $this->execute_at === '') {
			return null;
		} elseif (!is_int($this->execute_at)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->execute_at);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [execute_at] as date/time value: " . var_export($this->execute_at, true));
			}
		} else {
			$ts = $this->execute_at;
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
	 * Get the [optionally formatted] [last_executed_at] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getLastExecutedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->last_executed_at === null || $this->last_executed_at === '') {
			return null;
		} elseif (!is_int($this->last_executed_at)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->last_executed_at);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [last_executed_at] as date/time value: " . var_export($this->last_executed_at, true));
			}
		} else {
			$ts = $this->last_executed_at;
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
	 * Get the [optionally formatted] [last_finished_at] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getLastFinishedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->last_finished_at === null || $this->last_finished_at === '') {
			return null;
		} elseif (!is_int($this->last_finished_at)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->last_finished_at);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [last_finished_at] as date/time value: " . var_export($this->last_finished_at, true));
			}
		} else {
			$ts = $this->last_finished_at;
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
	 * Get the [optionally formatted] [last_active_at] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getLastActiveAt($format = 'Y-m-d H:i:s')
	{

		if ($this->last_active_at === null || $this->last_active_at === '') {
			return null;
		} elseif (!is_int($this->last_active_at)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->last_active_at);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [last_active_at] as date/time value: " . var_export($this->last_active_at, true));
			}
		} else {
			$ts = $this->last_active_at;
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
          $this->modifiedColumns[] = TaskPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [is_active] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsActive($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_active !== $v || $v === true) {
          $this->is_active = $v;
          $this->modifiedColumns[] = TaskPeer::IS_ACTIVE;
        }

	} // setIsActive()

	/**
	 * Set the value of [task_id] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTaskId($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->task_id !== $v) {
          $this->task_id = $v;
          $this->modifiedColumns[] = TaskPeer::TASK_ID;
        }

	} // setTaskId()

	/**
	 * Set the value of [task_priority] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setTaskPriority($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->task_priority !== $v || $v === 0) {
          $this->task_priority = $v;
          $this->modifiedColumns[] = TaskPeer::TASK_PRIORITY;
        }

	} // setTaskPriority()

	/**
	 * Set the value of [status] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setStatus($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->status !== $v || $v === 0) {
          $this->status = $v;
          $this->modifiedColumns[] = TaskPeer::STATUS;
        }

	} // setStatus()

	/**
	 * Set the value of [time_interval] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setTimeInterval($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->time_interval !== $v) {
          $this->time_interval = $v;
          $this->modifiedColumns[] = TaskPeer::TIME_INTERVAL;
        }

	} // setTimeInterval()

	/**
	 * Set the value of [execute_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setExecuteAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [execute_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->execute_at !== $ts) {
			$this->execute_at = $ts;
			$this->modifiedColumns[] = TaskPeer::EXECUTE_AT;
		}

	} // setExecuteAt()

	/**
	 * Set the value of [last_executed_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setLastExecutedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [last_executed_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->last_executed_at !== $ts) {
			$this->last_executed_at = $ts;
			$this->modifiedColumns[] = TaskPeer::LAST_EXECUTED_AT;
		}

	} // setLastExecutedAt()

	/**
	 * Set the value of [last_finished_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setLastFinishedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [last_finished_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->last_finished_at !== $ts) {
			$this->last_finished_at = $ts;
			$this->modifiedColumns[] = TaskPeer::LAST_FINISHED_AT;
		}

	} // setLastFinishedAt()

	/**
	 * Set the value of [last_active_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setLastActiveAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [last_active_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->last_active_at !== $ts) {
			$this->last_active_at = $ts;
			$this->modifiedColumns[] = TaskPeer::LAST_ACTIVE_AT;
		}

	} // setLastActiveAt()

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
      if ($this->getDispatcher()->getListeners('Task.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Task.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->is_active = $rs->getBoolean($startcol + 1);

      $this->task_id = $rs->getString($startcol + 2);

      $this->task_priority = $rs->getInt($startcol + 3);

      $this->status = $rs->getInt($startcol + 4);

      $this->time_interval = $rs->getInt($startcol + 5);

      $this->execute_at = $rs->getTime($startcol + 6, null);

      $this->last_executed_at = $rs->getTimestamp($startcol + 7, null);

      $this->last_finished_at = $rs->getTimestamp($startcol + 8, null);

      $this->last_active_at = $rs->getTimestamp($startcol + 9, null);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Task.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Task.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 10)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 10; // 10 = TaskPeer::NUM_COLUMNS - TaskPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Task object", $e);
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

    if ($this->getDispatcher()->getListeners('Task.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Task.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTask:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseTask:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(TaskPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      TaskPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Task.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Task.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTask:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseTask:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Task.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Task.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseTask:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(TaskPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Task.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Task.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseTask:save:post') as $callable)
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
					$pk = TaskPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += TaskPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collTaskLogs !== null) {
				foreach($this->collTaskLogs as $referrerFK) {
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


			if (($retval = TaskPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collTaskLogs !== null) {
					foreach($this->collTaskLogs as $referrerFK) {
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
		$pos = TaskPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getIsActive();
				break;
			case 2:
				return $this->getTaskId();
				break;
			case 3:
				return $this->getTaskPriority();
				break;
			case 4:
				return $this->getStatus();
				break;
			case 5:
				return $this->getTimeInterval();
				break;
			case 6:
				return $this->getExecuteAt();
				break;
			case 7:
				return $this->getLastExecutedAt();
				break;
			case 8:
				return $this->getLastFinishedAt();
				break;
			case 9:
				return $this->getLastActiveAt();
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
		$keys = TaskPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getIsActive(),
			$keys[2] => $this->getTaskId(),
			$keys[3] => $this->getTaskPriority(),
			$keys[4] => $this->getStatus(),
			$keys[5] => $this->getTimeInterval(),
			$keys[6] => $this->getExecuteAt(),
			$keys[7] => $this->getLastExecutedAt(),
			$keys[8] => $this->getLastFinishedAt(),
			$keys[9] => $this->getLastActiveAt(),
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
		$pos = TaskPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setIsActive($value);
				break;
			case 2:
				$this->setTaskId($value);
				break;
			case 3:
				$this->setTaskPriority($value);
				break;
			case 4:
				$this->setStatus($value);
				break;
			case 5:
				$this->setTimeInterval($value);
				break;
			case 6:
				$this->setExecuteAt($value);
				break;
			case 7:
				$this->setLastExecutedAt($value);
				break;
			case 8:
				$this->setLastFinishedAt($value);
				break;
			case 9:
				$this->setLastActiveAt($value);
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
		$keys = TaskPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setIsActive($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTaskId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTaskPriority($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setStatus($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setTimeInterval($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setExecuteAt($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setLastExecutedAt($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setLastFinishedAt($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setLastActiveAt($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(TaskPeer::DATABASE_NAME);

		if ($this->isColumnModified(TaskPeer::ID)) $criteria->add(TaskPeer::ID, $this->id);
		if ($this->isColumnModified(TaskPeer::IS_ACTIVE)) $criteria->add(TaskPeer::IS_ACTIVE, $this->is_active);
		if ($this->isColumnModified(TaskPeer::TASK_ID)) $criteria->add(TaskPeer::TASK_ID, $this->task_id);
		if ($this->isColumnModified(TaskPeer::TASK_PRIORITY)) $criteria->add(TaskPeer::TASK_PRIORITY, $this->task_priority);
		if ($this->isColumnModified(TaskPeer::STATUS)) $criteria->add(TaskPeer::STATUS, $this->status);
		if ($this->isColumnModified(TaskPeer::TIME_INTERVAL)) $criteria->add(TaskPeer::TIME_INTERVAL, $this->time_interval);
		if ($this->isColumnModified(TaskPeer::EXECUTE_AT)) $criteria->add(TaskPeer::EXECUTE_AT, $this->execute_at);
		if ($this->isColumnModified(TaskPeer::LAST_EXECUTED_AT)) $criteria->add(TaskPeer::LAST_EXECUTED_AT, $this->last_executed_at);
		if ($this->isColumnModified(TaskPeer::LAST_FINISHED_AT)) $criteria->add(TaskPeer::LAST_FINISHED_AT, $this->last_finished_at);
		if ($this->isColumnModified(TaskPeer::LAST_ACTIVE_AT)) $criteria->add(TaskPeer::LAST_ACTIVE_AT, $this->last_active_at);

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
		$criteria = new Criteria(TaskPeer::DATABASE_NAME);

		$criteria->add(TaskPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Task (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setIsActive($this->is_active);

		$copyObj->setTaskId($this->task_id);

		$copyObj->setTaskPriority($this->task_priority);

		$copyObj->setStatus($this->status);

		$copyObj->setTimeInterval($this->time_interval);

		$copyObj->setExecuteAt($this->execute_at);

		$copyObj->setLastExecutedAt($this->last_executed_at);

		$copyObj->setLastFinishedAt($this->last_finished_at);

		$copyObj->setLastActiveAt($this->last_active_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getTaskLogs() as $relObj) {
				$copyObj->addTaskLog($relObj->copy($deepCopy));
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
	 * @return     Task Clone of current object.
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
	 * @return     TaskPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new TaskPeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collTaskLogs to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initTaskLogs()
	{
		if ($this->collTaskLogs === null) {
			$this->collTaskLogs = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Task has previously
	 * been saved, it will retrieve related TaskLogs from storage.
	 * If this Task is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getTaskLogs($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTaskLogs === null) {
			if ($this->isNew()) {
			   $this->collTaskLogs = array();
			} else {

				$criteria->add(TaskLogPeer::TASK_ID, $this->getId());

				TaskLogPeer::addSelectColumns($criteria);
				$this->collTaskLogs = TaskLogPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(TaskLogPeer::TASK_ID, $this->getId());

				TaskLogPeer::addSelectColumns($criteria);
				if (!isset($this->lastTaskLogCriteria) || !$this->lastTaskLogCriteria->equals($criteria)) {
					$this->collTaskLogs = TaskLogPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTaskLogCriteria = $criteria;
		return $this->collTaskLogs;
	}

	/**
	 * Returns the number of related TaskLogs.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countTaskLogs($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TaskLogPeer::TASK_ID, $this->getId());

		return TaskLogPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a TaskLog object to this object
	 * through the TaskLog foreign key attribute
	 *
	 * @param      TaskLog $l TaskLog
	 * @return     void
	 * @throws     PropelException
	 */
	public function addTaskLog(TaskLog $l)
	{
		$this->collTaskLogs[] = $l;
		$l->setTask($this);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Task.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseTask:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseTask::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseTask
