<?php

/**
 * Base class that represents a row from the 'st_dashboard_gadget' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseDashboardGadget extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        DashboardGadgetPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the dashboard_id field.
	 * @var        int
	 */
	protected $dashboard_id;


	/**
	 * The value for the refreshed_at field.
	 * @var        int
	 */
	protected $refreshed_at = 0;


	/**
	 * The value for the refresh_by field.
	 * @var        int
	 */
	protected $refresh_by = 0;


	/**
	 * The value for the dashboard_column_no field.
	 * @var        int
	 */
	protected $dashboard_column_no;


	/**
	 * The value for the position field.
	 * @var        int
	 */
	protected $position = 1;


	/**
	 * The value for the color field.
	 * @var        string
	 */
	protected $color;


	/**
	 * The value for the is_minimized field.
	 * @var        boolean
	 */
	protected $is_minimized = false;


	/**
	 * The value for the title field.
	 * @var        string
	 */
	protected $title;


	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;

	/**
	 * @var        Dashboard
	 */
	protected $aDashboard;

	/**
	 * Collection to store aggregation of collDashboardGadgetConfigurations.
	 * @var        array
	 */
	protected $collDashboardGadgetConfigurations;

	/**
	 * The criteria used to select the current contents of collDashboardGadgetConfigurations.
	 * @var        Criteria
	 */
	protected $lastDashboardGadgetConfigurationCriteria = null;

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
     * Get the [dashboard_id] column value.
     * 
     * @return     int
     */
    public function getDashboardId()
    {

            return $this->dashboard_id;
    }

    /**
     * Get the [refreshed_at] column value.
     * 
     * @return     int
     */
    public function getRefreshedAt()
    {

            return $this->refreshed_at;
    }

    /**
     * Get the [refresh_by] column value.
     * 
     * @return     int
     */
    public function getRefreshBy()
    {

            return $this->refresh_by;
    }

    /**
     * Get the [dashboard_column_no] column value.
     * 
     * @return     int
     */
    public function getDashboardColumnNo()
    {

            return $this->dashboard_column_no;
    }

    /**
     * Get the [position] column value.
     * 
     * @return     int
     */
    public function getPosition()
    {

            return $this->position;
    }

    /**
     * Get the [color] column value.
     * 
     * @return     string
     */
    public function getColor()
    {

            return $this->color;
    }

    /**
     * Get the [is_minimized] column value.
     * 
     * @return     boolean
     */
    public function getIsMinimized()
    {

            return $this->is_minimized;
    }

    /**
     * Get the [title] column value.
     * 
     * @return     string
     */
    public function getTitle()
    {

            return $this->title;
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
          $this->modifiedColumns[] = DashboardGadgetPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [dashboard_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setDashboardId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->dashboard_id !== $v) {
          $this->dashboard_id = $v;
          $this->modifiedColumns[] = DashboardGadgetPeer::DASHBOARD_ID;
        }

		if ($this->aDashboard !== null && $this->aDashboard->getId() !== $v) {
			$this->aDashboard = null;
		}

	} // setDashboardId()

	/**
	 * Set the value of [refreshed_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setRefreshedAt($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->refreshed_at !== $v || $v === 0) {
          $this->refreshed_at = $v;
          $this->modifiedColumns[] = DashboardGadgetPeer::REFRESHED_AT;
        }

	} // setRefreshedAt()

	/**
	 * Set the value of [refresh_by] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setRefreshBy($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->refresh_by !== $v || $v === 0) {
          $this->refresh_by = $v;
          $this->modifiedColumns[] = DashboardGadgetPeer::REFRESH_BY;
        }

	} // setRefreshBy()

	/**
	 * Set the value of [dashboard_column_no] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setDashboardColumnNo($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->dashboard_column_no !== $v) {
          $this->dashboard_column_no = $v;
          $this->modifiedColumns[] = DashboardGadgetPeer::DASHBOARD_COLUMN_NO;
        }

	} // setDashboardColumnNo()

	/**
	 * Set the value of [position] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPosition($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->position !== $v || $v === 1) {
          $this->position = $v;
          $this->modifiedColumns[] = DashboardGadgetPeer::POSITION;
        }

	} // setPosition()

	/**
	 * Set the value of [color] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setColor($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->color !== $v) {
          $this->color = $v;
          $this->modifiedColumns[] = DashboardGadgetPeer::COLOR;
        }

	} // setColor()

	/**
	 * Set the value of [is_minimized] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsMinimized($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_minimized !== $v || $v === false) {
          $this->is_minimized = $v;
          $this->modifiedColumns[] = DashboardGadgetPeer::IS_MINIMIZED;
        }

	} // setIsMinimized()

	/**
	 * Set the value of [title] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTitle($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->title !== $v) {
          $this->title = $v;
          $this->modifiedColumns[] = DashboardGadgetPeer::TITLE;
        }

	} // setTitle()

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
          $this->modifiedColumns[] = DashboardGadgetPeer::NAME;
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
      if ($this->getDispatcher()->getListeners('DashboardGadget.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'DashboardGadget.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->dashboard_id = $rs->getInt($startcol + 1);

      $this->refreshed_at = $rs->getInt($startcol + 2);

      $this->refresh_by = $rs->getInt($startcol + 3);

      $this->dashboard_column_no = $rs->getInt($startcol + 4);

      $this->position = $rs->getInt($startcol + 5);

      $this->color = $rs->getString($startcol + 6);

      $this->is_minimized = $rs->getBoolean($startcol + 7);

      $this->title = $rs->getString($startcol + 8);

      $this->name = $rs->getString($startcol + 9);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('DashboardGadget.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'DashboardGadget.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 10)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 10; // 10 = DashboardGadgetPeer::NUM_COLUMNS - DashboardGadgetPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating DashboardGadget object", $e);
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

    if ($this->getDispatcher()->getListeners('DashboardGadget.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'DashboardGadget.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseDashboardGadget:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseDashboardGadget:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(DashboardGadgetPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      DashboardGadgetPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('DashboardGadget.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'DashboardGadget.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseDashboardGadget:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseDashboardGadget:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('DashboardGadget.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'DashboardGadget.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseDashboardGadget:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(DashboardGadgetPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('DashboardGadget.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'DashboardGadget.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseDashboardGadget:save:post') as $callable)
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

			if ($this->aDashboard !== null) {
				if ($this->aDashboard->isModified()) {
					$affectedRows += $this->aDashboard->save($con);
				}
				$this->setDashboard($this->aDashboard);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = DashboardGadgetPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += DashboardGadgetPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collDashboardGadgetConfigurations !== null) {
				foreach($this->collDashboardGadgetConfigurations as $referrerFK) {
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

			if ($this->aDashboard !== null) {
				if (!$this->aDashboard->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDashboard->getValidationFailures());
				}
			}


			if (($retval = DashboardGadgetPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collDashboardGadgetConfigurations !== null) {
					foreach($this->collDashboardGadgetConfigurations as $referrerFK) {
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
		$pos = DashboardGadgetPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getDashboardId();
				break;
			case 2:
				return $this->getRefreshedAt();
				break;
			case 3:
				return $this->getRefreshBy();
				break;
			case 4:
				return $this->getDashboardColumnNo();
				break;
			case 5:
				return $this->getPosition();
				break;
			case 6:
				return $this->getColor();
				break;
			case 7:
				return $this->getIsMinimized();
				break;
			case 8:
				return $this->getTitle();
				break;
			case 9:
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
		$keys = DashboardGadgetPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getDashboardId(),
			$keys[2] => $this->getRefreshedAt(),
			$keys[3] => $this->getRefreshBy(),
			$keys[4] => $this->getDashboardColumnNo(),
			$keys[5] => $this->getPosition(),
			$keys[6] => $this->getColor(),
			$keys[7] => $this->getIsMinimized(),
			$keys[8] => $this->getTitle(),
			$keys[9] => $this->getName(),
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
		$pos = DashboardGadgetPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setDashboardId($value);
				break;
			case 2:
				$this->setRefreshedAt($value);
				break;
			case 3:
				$this->setRefreshBy($value);
				break;
			case 4:
				$this->setDashboardColumnNo($value);
				break;
			case 5:
				$this->setPosition($value);
				break;
			case 6:
				$this->setColor($value);
				break;
			case 7:
				$this->setIsMinimized($value);
				break;
			case 8:
				$this->setTitle($value);
				break;
			case 9:
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
		$keys = DashboardGadgetPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDashboardId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setRefreshedAt($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setRefreshBy($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDashboardColumnNo($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPosition($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setColor($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsMinimized($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setTitle($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setName($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(DashboardGadgetPeer::DATABASE_NAME);

		if ($this->isColumnModified(DashboardGadgetPeer::ID)) $criteria->add(DashboardGadgetPeer::ID, $this->id);
		if ($this->isColumnModified(DashboardGadgetPeer::DASHBOARD_ID)) $criteria->add(DashboardGadgetPeer::DASHBOARD_ID, $this->dashboard_id);
		if ($this->isColumnModified(DashboardGadgetPeer::REFRESHED_AT)) $criteria->add(DashboardGadgetPeer::REFRESHED_AT, $this->refreshed_at);
		if ($this->isColumnModified(DashboardGadgetPeer::REFRESH_BY)) $criteria->add(DashboardGadgetPeer::REFRESH_BY, $this->refresh_by);
		if ($this->isColumnModified(DashboardGadgetPeer::DASHBOARD_COLUMN_NO)) $criteria->add(DashboardGadgetPeer::DASHBOARD_COLUMN_NO, $this->dashboard_column_no);
		if ($this->isColumnModified(DashboardGadgetPeer::POSITION)) $criteria->add(DashboardGadgetPeer::POSITION, $this->position);
		if ($this->isColumnModified(DashboardGadgetPeer::COLOR)) $criteria->add(DashboardGadgetPeer::COLOR, $this->color);
		if ($this->isColumnModified(DashboardGadgetPeer::IS_MINIMIZED)) $criteria->add(DashboardGadgetPeer::IS_MINIMIZED, $this->is_minimized);
		if ($this->isColumnModified(DashboardGadgetPeer::TITLE)) $criteria->add(DashboardGadgetPeer::TITLE, $this->title);
		if ($this->isColumnModified(DashboardGadgetPeer::NAME)) $criteria->add(DashboardGadgetPeer::NAME, $this->name);

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
		$criteria = new Criteria(DashboardGadgetPeer::DATABASE_NAME);

		$criteria->add(DashboardGadgetPeer::ID, $this->id);
		$criteria->add(DashboardGadgetPeer::DASHBOARD_ID, $this->dashboard_id);

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

		$pks[0] = $this->getId();

		$pks[1] = $this->getDashboardId();

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

		$this->setId($keys[0]);

		$this->setDashboardId($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of DashboardGadget (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setRefreshedAt($this->refreshed_at);

		$copyObj->setRefreshBy($this->refresh_by);

		$copyObj->setDashboardColumnNo($this->dashboard_column_no);

		$copyObj->setPosition($this->position);

		$copyObj->setColor($this->color);

		$copyObj->setIsMinimized($this->is_minimized);

		$copyObj->setTitle($this->title);

		$copyObj->setName($this->name);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getDashboardGadgetConfigurations() as $relObj) {
				$copyObj->addDashboardGadgetConfiguration($relObj->copy($deepCopy));
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a pkey column, so set to default value

		$copyObj->setDashboardId(NULL); // this is a pkey column, so set to default value

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
	 * @return     DashboardGadget Clone of current object.
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
	 * @return     DashboardGadgetPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new DashboardGadgetPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Dashboard object.
	 *
	 * @param      Dashboard $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setDashboard($v)
	{


		if ($v === null) {
			$this->setDashboardId(NULL);
		} else {
			$this->setDashboardId($v->getId());
		}


		$this->aDashboard = $v;
	}


	/**
	 * Get the associated Dashboard object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Dashboard The associated Dashboard object.
	 * @throws     PropelException
	 */
	public function getDashboard($con = null)
	{
		if ($this->aDashboard === null && ($this->dashboard_id !== null)) {
			// include the related Peer class
			$this->aDashboard = DashboardPeer::retrieveByPK($this->dashboard_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = DashboardPeer::retrieveByPK($this->dashboard_id, $con);
			   $obj->addDashboards($this);
			 */
		}
		return $this->aDashboard;
	}

	/**
	 * Temporary storage of collDashboardGadgetConfigurations to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDashboardGadgetConfigurations()
	{
		if ($this->collDashboardGadgetConfigurations === null) {
			$this->collDashboardGadgetConfigurations = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DashboardGadget has previously
	 * been saved, it will retrieve related DashboardGadgetConfigurations from storage.
	 * If this DashboardGadget is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDashboardGadgetConfigurations($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDashboardGadgetConfigurations === null) {
			if ($this->isNew()) {
			   $this->collDashboardGadgetConfigurations = array();
			} else {

				$criteria->add(DashboardGadgetConfigurationPeer::ID, $this->getId());

				DashboardGadgetConfigurationPeer::addSelectColumns($criteria);
				$this->collDashboardGadgetConfigurations = DashboardGadgetConfigurationPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DashboardGadgetConfigurationPeer::ID, $this->getId());

				DashboardGadgetConfigurationPeer::addSelectColumns($criteria);
				if (!isset($this->lastDashboardGadgetConfigurationCriteria) || !$this->lastDashboardGadgetConfigurationCriteria->equals($criteria)) {
					$this->collDashboardGadgetConfigurations = DashboardGadgetConfigurationPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDashboardGadgetConfigurationCriteria = $criteria;
		return $this->collDashboardGadgetConfigurations;
	}

	/**
	 * Returns the number of related DashboardGadgetConfigurations.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDashboardGadgetConfigurations($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DashboardGadgetConfigurationPeer::ID, $this->getId());

		return DashboardGadgetConfigurationPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DashboardGadgetConfiguration object to this object
	 * through the DashboardGadgetConfiguration foreign key attribute
	 *
	 * @param      DashboardGadgetConfiguration $l DashboardGadgetConfiguration
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDashboardGadgetConfiguration(DashboardGadgetConfiguration $l)
	{
		$this->collDashboardGadgetConfigurations[] = $l;
		$l->setDashboardGadget($this);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'DashboardGadget.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseDashboardGadget:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseDashboardGadget::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseDashboardGadget
