<?php

/**
 * Base class that represents a row from the 'sf_asset_folder' table.
 *
 * 
 *
 * @package    plugins.sfAssetsLibraryPlugin.lib.model.om
 */
abstract class BasesfAssetFolder extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        sfAssetFolderPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the tree_left field.
	 * @var        int
	 */
	protected $tree_left;


	/**
	 * The value for the tree_right field.
	 * @var        int
	 */
	protected $tree_right;


	/**
	 * The value for the tree_parent field.
	 * @var        int
	 */
	protected $tree_parent;


	/**
	 * The value for the tree_depth field.
	 * @var        int
	 */
	protected $tree_depth;


	/**
	 * The value for the static_scope field.
	 * @var        int
	 */
	protected $static_scope;


	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the relative_path field.
	 * @var        string
	 */
	protected $relative_path;


	/**
	 * The value for the is_enabled field.
	 * @var        boolean
	 */
	protected $is_enabled = true;


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
	 * @var        sfAssetFolder
	 */
	protected $asfAssetFolderRelatedByTreeParent;

	/**
	 * Collection to store aggregation of collsfAssetFoldersRelatedByTreeParent.
	 * @var        array
	 */
	protected $collsfAssetFoldersRelatedByTreeParent;

	/**
	 * The criteria used to select the current contents of collsfAssetFoldersRelatedByTreeParent.
	 * @var        Criteria
	 */
	protected $lastsfAssetFolderRelatedByTreeParentCriteria = null;

	/**
	 * Collection to store aggregation of collsfAssets.
	 * @var        array
	 */
	protected $collsfAssets;

	/**
	 * The criteria used to select the current contents of collsfAssets.
	 * @var        Criteria
	 */
	protected $lastsfAssetCriteria = null;

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
     * Get the [tree_left] column value.
     * 
     * @return     int
     */
    public function getTreeLeft()
    {

            return $this->tree_left;
    }

    /**
     * Get the [tree_right] column value.
     * 
     * @return     int
     */
    public function getTreeRight()
    {

            return $this->tree_right;
    }

    /**
     * Get the [tree_parent] column value.
     * 
     * @return     int
     */
    public function getTreeParent()
    {

            return $this->tree_parent;
    }

    /**
     * Get the [tree_depth] column value.
     * 
     * @return     int
     */
    public function getTreeDepth()
    {

            return $this->tree_depth;
    }

    /**
     * Get the [static_scope] column value.
     * 
     * @return     int
     */
    public function getStaticScope()
    {

            return $this->static_scope;
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
     * Get the [relative_path] column value.
     * 
     * @return     string
     */
    public function getRelativePath()
    {

            return $this->relative_path;
    }

    /**
     * Get the [is_enabled] column value.
     * 
     * @return     boolean
     */
    public function getIsEnabled()
    {

            return $this->is_enabled;
    }

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
          $this->modifiedColumns[] = sfAssetFolderPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [tree_left] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setTreeLeft($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->tree_left !== $v) {
          $this->tree_left = $v;
          $this->modifiedColumns[] = sfAssetFolderPeer::TREE_LEFT;
        }

	} // setTreeLeft()

	/**
	 * Set the value of [tree_right] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setTreeRight($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->tree_right !== $v) {
          $this->tree_right = $v;
          $this->modifiedColumns[] = sfAssetFolderPeer::TREE_RIGHT;
        }

	} // setTreeRight()

	/**
	 * Set the value of [tree_parent] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setTreeParent($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->tree_parent !== $v) {
          $this->tree_parent = $v;
          $this->modifiedColumns[] = sfAssetFolderPeer::TREE_PARENT;
        }

		if ($this->asfAssetFolderRelatedByTreeParent !== null && $this->asfAssetFolderRelatedByTreeParent->getId() !== $v) {
			$this->asfAssetFolderRelatedByTreeParent = null;
		}

	} // setTreeParent()

	/**
	 * Set the value of [tree_depth] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setTreeDepth($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->tree_depth !== $v) {
          $this->tree_depth = $v;
          $this->modifiedColumns[] = sfAssetFolderPeer::TREE_DEPTH;
        }

	} // setTreeDepth()

	/**
	 * Set the value of [static_scope] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setStaticScope($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->static_scope !== $v) {
          $this->static_scope = $v;
          $this->modifiedColumns[] = sfAssetFolderPeer::STATIC_SCOPE;
        }

	} // setStaticScope()

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
          $this->modifiedColumns[] = sfAssetFolderPeer::NAME;
        }

	} // setName()

	/**
	 * Set the value of [relative_path] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setRelativePath($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->relative_path !== $v) {
          $this->relative_path = $v;
          $this->modifiedColumns[] = sfAssetFolderPeer::RELATIVE_PATH;
        }

	} // setRelativePath()

	/**
	 * Set the value of [is_enabled] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsEnabled($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_enabled !== $v || $v === true) {
          $this->is_enabled = $v;
          $this->modifiedColumns[] = sfAssetFolderPeer::IS_ENABLED;
        }

	} // setIsEnabled()

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
			$this->modifiedColumns[] = sfAssetFolderPeer::CREATED_AT;
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
			$this->modifiedColumns[] = sfAssetFolderPeer::UPDATED_AT;
		}

	} // setUpdatedAt()

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
      if ($this->getDispatcher()->getListeners('sfAssetFolder.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'sfAssetFolder.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->tree_left = $rs->getInt($startcol + 1);

      $this->tree_right = $rs->getInt($startcol + 2);

      $this->tree_parent = $rs->getInt($startcol + 3);

      $this->tree_depth = $rs->getInt($startcol + 4);

      $this->static_scope = $rs->getInt($startcol + 5);

      $this->name = $rs->getString($startcol + 6);

      $this->relative_path = $rs->getString($startcol + 7);

      $this->is_enabled = $rs->getBoolean($startcol + 8);

      $this->created_at = $rs->getTimestamp($startcol + 9, null);

      $this->updated_at = $rs->getTimestamp($startcol + 10, null);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('sfAssetFolder.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'sfAssetFolder.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 11)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 11; // 11 = sfAssetFolderPeer::NUM_COLUMNS - sfAssetFolderPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating sfAssetFolder object", $e);
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

    if ($this->getDispatcher()->getListeners('sfAssetFolder.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'sfAssetFolder.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasesfAssetFolder:delete:pre'))
    {
      foreach (sfMixer::getCallables('BasesfAssetFolder:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(sfAssetFolderPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      sfAssetFolderPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('sfAssetFolder.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'sfAssetFolder.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasesfAssetFolder:delete:post'))
    {
      foreach (sfMixer::getCallables('BasesfAssetFolder:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('sfAssetFolder.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'sfAssetFolder.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BasesfAssetFolder:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(sfAssetFolderPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(sfAssetFolderPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(sfAssetFolderPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('sfAssetFolder.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'sfAssetFolder.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BasesfAssetFolder:save:post') as $callable)
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

			if ($this->asfAssetFolderRelatedByTreeParent !== null) {
				if ($this->asfAssetFolderRelatedByTreeParent->isModified()) {
					$affectedRows += $this->asfAssetFolderRelatedByTreeParent->save($con);
				}
				$this->setsfAssetFolderRelatedByTreeParent($this->asfAssetFolderRelatedByTreeParent);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfAssetFolderPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += sfAssetFolderPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collsfAssetFoldersRelatedByTreeParent !== null) {
				foreach($this->collsfAssetFoldersRelatedByTreeParent as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collsfAssets !== null) {
				foreach($this->collsfAssets as $referrerFK) {
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

			if ($this->asfAssetFolderRelatedByTreeParent !== null) {
				if (!$this->asfAssetFolderRelatedByTreeParent->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfAssetFolderRelatedByTreeParent->getValidationFailures());
				}
			}


			if (($retval = sfAssetFolderPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collsfAssets !== null) {
					foreach($this->collsfAssets as $referrerFK) {
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
		$pos = sfAssetFolderPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getTreeLeft();
				break;
			case 2:
				return $this->getTreeRight();
				break;
			case 3:
				return $this->getTreeParent();
				break;
			case 4:
				return $this->getTreeDepth();
				break;
			case 5:
				return $this->getStaticScope();
				break;
			case 6:
				return $this->getName();
				break;
			case 7:
				return $this->getRelativePath();
				break;
			case 8:
				return $this->getIsEnabled();
				break;
			case 9:
				return $this->getCreatedAt();
				break;
			case 10:
				return $this->getUpdatedAt();
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
		$keys = sfAssetFolderPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTreeLeft(),
			$keys[2] => $this->getTreeRight(),
			$keys[3] => $this->getTreeParent(),
			$keys[4] => $this->getTreeDepth(),
			$keys[5] => $this->getStaticScope(),
			$keys[6] => $this->getName(),
			$keys[7] => $this->getRelativePath(),
			$keys[8] => $this->getIsEnabled(),
			$keys[9] => $this->getCreatedAt(),
			$keys[10] => $this->getUpdatedAt(),
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
		$pos = sfAssetFolderPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setTreeLeft($value);
				break;
			case 2:
				$this->setTreeRight($value);
				break;
			case 3:
				$this->setTreeParent($value);
				break;
			case 4:
				$this->setTreeDepth($value);
				break;
			case 5:
				$this->setStaticScope($value);
				break;
			case 6:
				$this->setName($value);
				break;
			case 7:
				$this->setRelativePath($value);
				break;
			case 8:
				$this->setIsEnabled($value);
				break;
			case 9:
				$this->setCreatedAt($value);
				break;
			case 10:
				$this->setUpdatedAt($value);
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
		$keys = sfAssetFolderPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTreeLeft($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTreeRight($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTreeParent($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTreeDepth($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setStaticScope($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setName($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setRelativePath($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsEnabled($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setCreatedAt($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setUpdatedAt($arr[$keys[10]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(sfAssetFolderPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfAssetFolderPeer::ID)) $criteria->add(sfAssetFolderPeer::ID, $this->id);
		if ($this->isColumnModified(sfAssetFolderPeer::TREE_LEFT)) $criteria->add(sfAssetFolderPeer::TREE_LEFT, $this->tree_left);
		if ($this->isColumnModified(sfAssetFolderPeer::TREE_RIGHT)) $criteria->add(sfAssetFolderPeer::TREE_RIGHT, $this->tree_right);
		if ($this->isColumnModified(sfAssetFolderPeer::TREE_PARENT)) $criteria->add(sfAssetFolderPeer::TREE_PARENT, $this->tree_parent);
		if ($this->isColumnModified(sfAssetFolderPeer::TREE_DEPTH)) $criteria->add(sfAssetFolderPeer::TREE_DEPTH, $this->tree_depth);
		if ($this->isColumnModified(sfAssetFolderPeer::STATIC_SCOPE)) $criteria->add(sfAssetFolderPeer::STATIC_SCOPE, $this->static_scope);
		if ($this->isColumnModified(sfAssetFolderPeer::NAME)) $criteria->add(sfAssetFolderPeer::NAME, $this->name);
		if ($this->isColumnModified(sfAssetFolderPeer::RELATIVE_PATH)) $criteria->add(sfAssetFolderPeer::RELATIVE_PATH, $this->relative_path);
		if ($this->isColumnModified(sfAssetFolderPeer::IS_ENABLED)) $criteria->add(sfAssetFolderPeer::IS_ENABLED, $this->is_enabled);
		if ($this->isColumnModified(sfAssetFolderPeer::CREATED_AT)) $criteria->add(sfAssetFolderPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(sfAssetFolderPeer::UPDATED_AT)) $criteria->add(sfAssetFolderPeer::UPDATED_AT, $this->updated_at);

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
		$criteria = new Criteria(sfAssetFolderPeer::DATABASE_NAME);

		$criteria->add(sfAssetFolderPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of sfAssetFolder (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTreeLeft($this->tree_left);

		$copyObj->setTreeRight($this->tree_right);

		$copyObj->setTreeParent($this->tree_parent);

		$copyObj->setTreeDepth($this->tree_depth);

		$copyObj->setStaticScope($this->static_scope);

		$copyObj->setName($this->name);

		$copyObj->setRelativePath($this->relative_path);

		$copyObj->setIsEnabled($this->is_enabled);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getsfAssetFoldersRelatedByTreeParent() as $relObj) {
				if($this->getPrimaryKey() === $relObj->getPrimaryKey()) {
						continue;
				}

				$copyObj->addsfAssetFolderRelatedByTreeParent($relObj->copy($deepCopy));
			}

			foreach($this->getsfAssets() as $relObj) {
				$copyObj->addsfAsset($relObj->copy($deepCopy));
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
	 * @return     sfAssetFolder Clone of current object.
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
	 * @return     sfAssetFolderPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new sfAssetFolderPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a sfAssetFolder object.
	 *
	 * @param      sfAssetFolder $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setsfAssetFolderRelatedByTreeParent($v)
	{


		if ($v === null) {
			$this->setTreeParent(NULL);
		} else {
			$this->setTreeParent($v->getId());
		}


		$this->asfAssetFolderRelatedByTreeParent = $v;
	}


	/**
	 * Get the associated sfAssetFolder object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     sfAssetFolder The associated sfAssetFolder object.
	 * @throws     PropelException
	 */
	public function getsfAssetFolderRelatedByTreeParent($con = null)
	{
		if ($this->asfAssetFolderRelatedByTreeParent === null && ($this->tree_parent !== null)) {
			// include the related Peer class
			$this->asfAssetFolderRelatedByTreeParent = sfAssetFolderPeer::retrieveByPK($this->tree_parent, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = sfAssetFolderPeer::retrieveByPK($this->tree_parent, $con);
			   $obj->addsfAssetFoldersRelatedByTreeParent($this);
			 */
		}
		return $this->asfAssetFolderRelatedByTreeParent;
	}

	/**
	 * Temporary storage of collsfAssetFoldersRelatedByTreeParent to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initsfAssetFoldersRelatedByTreeParent()
	{
		if ($this->collsfAssetFoldersRelatedByTreeParent === null) {
			$this->collsfAssetFoldersRelatedByTreeParent = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAssetFolder has previously
	 * been saved, it will retrieve related sfAssetFoldersRelatedByTreeParent from storage.
	 * If this sfAssetFolder is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getsfAssetFoldersRelatedByTreeParent($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfAssetFoldersRelatedByTreeParent === null) {
			if ($this->isNew()) {
			   $this->collsfAssetFoldersRelatedByTreeParent = array();
			} else {

				$criteria->add(sfAssetFolderPeer::TREE_PARENT, $this->getId());

				sfAssetFolderPeer::addSelectColumns($criteria);
				$this->collsfAssetFoldersRelatedByTreeParent = sfAssetFolderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(sfAssetFolderPeer::TREE_PARENT, $this->getId());

				sfAssetFolderPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfAssetFolderRelatedByTreeParentCriteria) || !$this->lastsfAssetFolderRelatedByTreeParentCriteria->equals($criteria)) {
					$this->collsfAssetFoldersRelatedByTreeParent = sfAssetFolderPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfAssetFolderRelatedByTreeParentCriteria = $criteria;
		return $this->collsfAssetFoldersRelatedByTreeParent;
	}

	/**
	 * Returns the number of related sfAssetFoldersRelatedByTreeParent.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countsfAssetFoldersRelatedByTreeParent($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfAssetFolderPeer::TREE_PARENT, $this->getId());

		return sfAssetFolderPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a sfAssetFolder object to this object
	 * through the sfAssetFolder foreign key attribute
	 *
	 * @param      sfAssetFolder $l sfAssetFolder
	 * @return     void
	 * @throws     PropelException
	 */
	public function addsfAssetFolderRelatedByTreeParent(sfAssetFolder $l)
	{
		$this->collsfAssetFoldersRelatedByTreeParent[] = $l;
		$l->setsfAssetFolderRelatedByTreeParent($this);
	}

	/**
	 * Temporary storage of collsfAssets to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initsfAssets()
	{
		if ($this->collsfAssets === null) {
			$this->collsfAssets = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAssetFolder has previously
	 * been saved, it will retrieve related sfAssets from storage.
	 * If this sfAssetFolder is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getsfAssets($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfAssets === null) {
			if ($this->isNew()) {
			   $this->collsfAssets = array();
			} else {

				$criteria->add(sfAssetPeer::FOLDER_ID, $this->getId());

				sfAssetPeer::addSelectColumns($criteria);
				$this->collsfAssets = sfAssetPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(sfAssetPeer::FOLDER_ID, $this->getId());

				sfAssetPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfAssetCriteria) || !$this->lastsfAssetCriteria->equals($criteria)) {
					$this->collsfAssets = sfAssetPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfAssetCriteria = $criteria;
		return $this->collsfAssets;
	}

	/**
	 * Returns the number of related sfAssets.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countsfAssets($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfAssetPeer::FOLDER_ID, $this->getId());

		return sfAssetPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a sfAsset object to this object
	 * through the sfAsset foreign key attribute
	 *
	 * @param      sfAsset $l sfAsset
	 * @return     void
	 * @throws     PropelException
	 */
	public function addsfAsset(sfAsset $l)
	{
		$this->collsfAssets[] = $l;
		$l->setsfAssetFolder($this);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'sfAssetFolder.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BasesfAssetFolder:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BasesfAssetFolder::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BasesfAssetFolder
