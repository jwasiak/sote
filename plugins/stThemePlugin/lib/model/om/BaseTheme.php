<?php

/**
 * Base class that represents a row from the 'st_theme' table.
 *
 * 
 *
 * @package    plugins.stThemePlugin.lib.model.om
 */
abstract class BaseTheme extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ThemePeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the base_theme_id field.
	 * @var        int
	 */
	protected $base_theme_id;


	/**
	 * The value for the theme field.
	 * @var        string
	 */
	protected $theme;


	/**
	 * The value for the active field.
	 * @var        boolean
	 */
	protected $active = false;


	/**
	 * The value for the opt_color_scheme field.
	 * @var        string
	 */
	protected $opt_color_scheme;


	/**
	 * The value for the version field.
	 * @var        int
	 */
	protected $version;


	/**
	 * The value for the is_system_default field.
	 * @var        boolean
	 */
	protected $is_system_default = false;


	/**
	 * The value for the is_hidden field.
	 * @var        boolean
	 */
	protected $is_hidden = false;

	/**
	 * @var        Theme
	 */
	protected $aThemeRelatedByBaseThemeId;

	/**
	 * Collection to store aggregation of collSmartySlots.
	 * @var        array
	 */
	protected $collSmartySlots;

	/**
	 * The criteria used to select the current contents of collSmartySlots.
	 * @var        Criteria
	 */
	protected $lastSmartySlotCriteria = null;

	/**
	 * Collection to store aggregation of collThemeLayouts.
	 * @var        array
	 */
	protected $collThemeLayouts;

	/**
	 * The criteria used to select the current contents of collThemeLayouts.
	 * @var        Criteria
	 */
	protected $lastThemeLayoutCriteria = null;

	/**
	 * Collection to store aggregation of collThemesRelatedByBaseThemeId.
	 * @var        array
	 */
	protected $collThemesRelatedByBaseThemeId;

	/**
	 * The criteria used to select the current contents of collThemesRelatedByBaseThemeId.
	 * @var        Criteria
	 */
	protected $lastThemeRelatedByBaseThemeIdCriteria = null;

	/**
	 * Collection to store aggregation of collThemeCsss.
	 * @var        array
	 */
	protected $collThemeCsss;

	/**
	 * The criteria used to select the current contents of collThemeCsss.
	 * @var        Criteria
	 */
	protected $lastThemeCssCriteria = null;

	/**
	 * Collection to store aggregation of collThemeColorSchemes.
	 * @var        array
	 */
	protected $collThemeColorSchemes;

	/**
	 * The criteria used to select the current contents of collThemeColorSchemes.
	 * @var        Criteria
	 */
	protected $lastThemeColorSchemeCriteria = null;

	/**
	 * Collection to store aggregation of collThemeConfigs.
	 * @var        array
	 */
	protected $collThemeConfigs;

	/**
	 * The criteria used to select the current contents of collThemeConfigs.
	 * @var        Criteria
	 */
	protected $lastThemeConfigCriteria = null;

	/**
	 * Collection to store aggregation of collThemeContents.
	 * @var        array
	 */
	protected $collThemeContents;

	/**
	 * The criteria used to select the current contents of collThemeContents.
	 * @var        Criteria
	 */
	protected $lastThemeContentCriteria = null;

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
     * Get the [base_theme_id] column value.
     * 
     * @return     int
     */
    public function getBaseThemeId()
    {

            return $this->base_theme_id;
    }

    /**
     * Get the [theme] column value.
     * 
     * @return     string
     */
    public function getTheme()
    {

            return $this->theme;
    }

    /**
     * Get the [active] column value.
     * 
     * @return     boolean
     */
    public function getActive()
    {

            return $this->active;
    }

    /**
     * Get the [opt_color_scheme] column value.
     * 
     * @return     string
     */
    public function getOptColorScheme()
    {

            return $this->opt_color_scheme;
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
     * Get the [is_system_default] column value.
     * 
     * @return     boolean
     */
    public function getIsSystemDefault()
    {

            return $this->is_system_default;
    }

    /**
     * Get the [is_hidden] column value.
     * 
     * @return     boolean
     */
    public function getIsHidden()
    {

            return $this->is_hidden;
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
          $this->modifiedColumns[] = ThemePeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [base_theme_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setBaseThemeId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->base_theme_id !== $v) {
          $this->base_theme_id = $v;
          $this->modifiedColumns[] = ThemePeer::BASE_THEME_ID;
        }

		if ($this->aThemeRelatedByBaseThemeId !== null && $this->aThemeRelatedByBaseThemeId->getId() !== $v) {
			$this->aThemeRelatedByBaseThemeId = null;
		}

	} // setBaseThemeId()

	/**
	 * Set the value of [theme] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTheme($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->theme !== $v) {
          $this->theme = $v;
          $this->modifiedColumns[] = ThemePeer::THEME;
        }

	} // setTheme()

	/**
	 * Set the value of [active] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setActive($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->active !== $v || $v === false) {
          $this->active = $v;
          $this->modifiedColumns[] = ThemePeer::ACTIVE;
        }

	} // setActive()

	/**
	 * Set the value of [opt_color_scheme] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptColorScheme($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_color_scheme !== $v) {
          $this->opt_color_scheme = $v;
          $this->modifiedColumns[] = ThemePeer::OPT_COLOR_SCHEME;
        }

	} // setOptColorScheme()

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

        if ($this->version !== $v) {
          $this->version = $v;
          $this->modifiedColumns[] = ThemePeer::VERSION;
        }

	} // setVersion()

	/**
	 * Set the value of [is_system_default] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsSystemDefault($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_system_default !== $v || $v === false) {
          $this->is_system_default = $v;
          $this->modifiedColumns[] = ThemePeer::IS_SYSTEM_DEFAULT;
        }

	} // setIsSystemDefault()

	/**
	 * Set the value of [is_hidden] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsHidden($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_hidden !== $v || $v === false) {
          $this->is_hidden = $v;
          $this->modifiedColumns[] = ThemePeer::IS_HIDDEN;
        }

	} // setIsHidden()

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
      if ($this->getDispatcher()->getListeners('Theme.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Theme.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->base_theme_id = $rs->getInt($startcol + 1);

      $this->theme = $rs->getString($startcol + 2);

      $this->active = $rs->getBoolean($startcol + 3);

      $this->opt_color_scheme = $rs->getString($startcol + 4);

      $this->version = $rs->getInt($startcol + 5);

      $this->is_system_default = $rs->getBoolean($startcol + 6);

      $this->is_hidden = $rs->getBoolean($startcol + 7);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Theme.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Theme.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 8)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 8; // 8 = ThemePeer::NUM_COLUMNS - ThemePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Theme object", $e);
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

    if ($this->getDispatcher()->getListeners('Theme.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Theme.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTheme:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseTheme:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ThemePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ThemePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Theme.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Theme.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTheme:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseTheme:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Theme.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Theme.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseTheme:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(ThemePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Theme.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Theme.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseTheme:save:post') as $callable)
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

			if ($this->aThemeRelatedByBaseThemeId !== null) {
				if ($this->aThemeRelatedByBaseThemeId->isModified()) {
					$affectedRows += $this->aThemeRelatedByBaseThemeId->save($con);
				}
				$this->setThemeRelatedByBaseThemeId($this->aThemeRelatedByBaseThemeId);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ThemePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ThemePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collSmartySlots !== null) {
				foreach($this->collSmartySlots as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collThemeLayouts !== null) {
				foreach($this->collThemeLayouts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collThemesRelatedByBaseThemeId !== null) {
				foreach($this->collThemesRelatedByBaseThemeId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collThemeCsss !== null) {
				foreach($this->collThemeCsss as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collThemeColorSchemes !== null) {
				foreach($this->collThemeColorSchemes as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collThemeConfigs !== null) {
				foreach($this->collThemeConfigs as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collThemeContents !== null) {
				foreach($this->collThemeContents as $referrerFK) {
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

			if ($this->aThemeRelatedByBaseThemeId !== null) {
				if (!$this->aThemeRelatedByBaseThemeId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aThemeRelatedByBaseThemeId->getValidationFailures());
				}
			}


			if (($retval = ThemePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collSmartySlots !== null) {
					foreach($this->collSmartySlots as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collThemeLayouts !== null) {
					foreach($this->collThemeLayouts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collThemeCsss !== null) {
					foreach($this->collThemeCsss as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collThemeColorSchemes !== null) {
					foreach($this->collThemeColorSchemes as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collThemeConfigs !== null) {
					foreach($this->collThemeConfigs as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collThemeContents !== null) {
					foreach($this->collThemeContents as $referrerFK) {
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
		$pos = ThemePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getBaseThemeId();
				break;
			case 2:
				return $this->getTheme();
				break;
			case 3:
				return $this->getActive();
				break;
			case 4:
				return $this->getOptColorScheme();
				break;
			case 5:
				return $this->getVersion();
				break;
			case 6:
				return $this->getIsSystemDefault();
				break;
			case 7:
				return $this->getIsHidden();
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
		$keys = ThemePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getBaseThemeId(),
			$keys[2] => $this->getTheme(),
			$keys[3] => $this->getActive(),
			$keys[4] => $this->getOptColorScheme(),
			$keys[5] => $this->getVersion(),
			$keys[6] => $this->getIsSystemDefault(),
			$keys[7] => $this->getIsHidden(),
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
		$pos = ThemePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setBaseThemeId($value);
				break;
			case 2:
				$this->setTheme($value);
				break;
			case 3:
				$this->setActive($value);
				break;
			case 4:
				$this->setOptColorScheme($value);
				break;
			case 5:
				$this->setVersion($value);
				break;
			case 6:
				$this->setIsSystemDefault($value);
				break;
			case 7:
				$this->setIsHidden($value);
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
		$keys = ThemePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setBaseThemeId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTheme($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setActive($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setOptColorScheme($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setVersion($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsSystemDefault($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsHidden($arr[$keys[7]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ThemePeer::DATABASE_NAME);

		if ($this->isColumnModified(ThemePeer::ID)) $criteria->add(ThemePeer::ID, $this->id);
		if ($this->isColumnModified(ThemePeer::BASE_THEME_ID)) $criteria->add(ThemePeer::BASE_THEME_ID, $this->base_theme_id);
		if ($this->isColumnModified(ThemePeer::THEME)) $criteria->add(ThemePeer::THEME, $this->theme);
		if ($this->isColumnModified(ThemePeer::ACTIVE)) $criteria->add(ThemePeer::ACTIVE, $this->active);
		if ($this->isColumnModified(ThemePeer::OPT_COLOR_SCHEME)) $criteria->add(ThemePeer::OPT_COLOR_SCHEME, $this->opt_color_scheme);
		if ($this->isColumnModified(ThemePeer::VERSION)) $criteria->add(ThemePeer::VERSION, $this->version);
		if ($this->isColumnModified(ThemePeer::IS_SYSTEM_DEFAULT)) $criteria->add(ThemePeer::IS_SYSTEM_DEFAULT, $this->is_system_default);
		if ($this->isColumnModified(ThemePeer::IS_HIDDEN)) $criteria->add(ThemePeer::IS_HIDDEN, $this->is_hidden);

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
		$criteria = new Criteria(ThemePeer::DATABASE_NAME);

		$criteria->add(ThemePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Theme (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setBaseThemeId($this->base_theme_id);

		$copyObj->setTheme($this->theme);

		$copyObj->setActive($this->active);

		$copyObj->setOptColorScheme($this->opt_color_scheme);

		$copyObj->setVersion($this->version);

		$copyObj->setIsSystemDefault($this->is_system_default);

		$copyObj->setIsHidden($this->is_hidden);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getSmartySlots() as $relObj) {
				$copyObj->addSmartySlot($relObj->copy($deepCopy));
			}

			foreach($this->getThemeLayouts() as $relObj) {
				$copyObj->addThemeLayout($relObj->copy($deepCopy));
			}

			foreach($this->getThemesRelatedByBaseThemeId() as $relObj) {
				if($this->getPrimaryKey() === $relObj->getPrimaryKey()) {
						continue;
				}

				$copyObj->addThemeRelatedByBaseThemeId($relObj->copy($deepCopy));
			}

			foreach($this->getThemeCsss() as $relObj) {
				$copyObj->addThemeCss($relObj->copy($deepCopy));
			}

			foreach($this->getThemeColorSchemes() as $relObj) {
				$copyObj->addThemeColorScheme($relObj->copy($deepCopy));
			}

			foreach($this->getThemeConfigs() as $relObj) {
				$copyObj->addThemeConfig($relObj->copy($deepCopy));
			}

			foreach($this->getThemeContents() as $relObj) {
				$copyObj->addThemeContent($relObj->copy($deepCopy));
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
	 * @return     Theme Clone of current object.
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
	 * @return     ThemePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ThemePeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Theme object.
	 *
	 * @param      Theme $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setThemeRelatedByBaseThemeId($v)
	{


		if ($v === null) {
			$this->setBaseThemeId(NULL);
		} else {
			$this->setBaseThemeId($v->getId());
		}


		$this->aThemeRelatedByBaseThemeId = $v;
	}


	/**
	 * Get the associated Theme object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Theme The associated Theme object.
	 * @throws     PropelException
	 */
	public function getThemeRelatedByBaseThemeId($con = null)
	{
		if ($this->aThemeRelatedByBaseThemeId === null && ($this->base_theme_id !== null)) {
			// include the related Peer class
			$this->aThemeRelatedByBaseThemeId = ThemePeer::retrieveByPK($this->base_theme_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ThemePeer::retrieveByPK($this->base_theme_id, $con);
			   $obj->addThemesRelatedByBaseThemeId($this);
			 */
		}
		return $this->aThemeRelatedByBaseThemeId;
	}

	/**
	 * Temporary storage of collSmartySlots to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initSmartySlots()
	{
		if ($this->collSmartySlots === null) {
			$this->collSmartySlots = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Theme has previously
	 * been saved, it will retrieve related SmartySlots from storage.
	 * If this Theme is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getSmartySlots($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSmartySlots === null) {
			if ($this->isNew()) {
			   $this->collSmartySlots = array();
			} else {

				$criteria->add(SmartySlotPeer::THEME_ID, $this->getId());

				SmartySlotPeer::addSelectColumns($criteria);
				$this->collSmartySlots = SmartySlotPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(SmartySlotPeer::THEME_ID, $this->getId());

				SmartySlotPeer::addSelectColumns($criteria);
				if (!isset($this->lastSmartySlotCriteria) || !$this->lastSmartySlotCriteria->equals($criteria)) {
					$this->collSmartySlots = SmartySlotPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSmartySlotCriteria = $criteria;
		return $this->collSmartySlots;
	}

	/**
	 * Returns the number of related SmartySlots.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countSmartySlots($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(SmartySlotPeer::THEME_ID, $this->getId());

		return SmartySlotPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a SmartySlot object to this object
	 * through the SmartySlot foreign key attribute
	 *
	 * @param      SmartySlot $l SmartySlot
	 * @return     void
	 * @throws     PropelException
	 */
	public function addSmartySlot(SmartySlot $l)
	{
		$this->collSmartySlots[] = $l;
		$l->setTheme($this);
	}

	/**
	 * Temporary storage of collThemeLayouts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initThemeLayouts()
	{
		if ($this->collThemeLayouts === null) {
			$this->collThemeLayouts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Theme has previously
	 * been saved, it will retrieve related ThemeLayouts from storage.
	 * If this Theme is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getThemeLayouts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collThemeLayouts === null) {
			if ($this->isNew()) {
			   $this->collThemeLayouts = array();
			} else {

				$criteria->add(ThemeLayoutPeer::THEME_ID, $this->getId());

				ThemeLayoutPeer::addSelectColumns($criteria);
				$this->collThemeLayouts = ThemeLayoutPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ThemeLayoutPeer::THEME_ID, $this->getId());

				ThemeLayoutPeer::addSelectColumns($criteria);
				if (!isset($this->lastThemeLayoutCriteria) || !$this->lastThemeLayoutCriteria->equals($criteria)) {
					$this->collThemeLayouts = ThemeLayoutPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastThemeLayoutCriteria = $criteria;
		return $this->collThemeLayouts;
	}

	/**
	 * Returns the number of related ThemeLayouts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countThemeLayouts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ThemeLayoutPeer::THEME_ID, $this->getId());

		return ThemeLayoutPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ThemeLayout object to this object
	 * through the ThemeLayout foreign key attribute
	 *
	 * @param      ThemeLayout $l ThemeLayout
	 * @return     void
	 * @throws     PropelException
	 */
	public function addThemeLayout(ThemeLayout $l)
	{
		$this->collThemeLayouts[] = $l;
		$l->setTheme($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Theme is new, it will return
	 * an empty collection; or if this Theme has previously
	 * been saved, it will retrieve related ThemeLayouts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Theme.
	 */
	public function getThemeLayoutsJoinsfGuardUser($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collThemeLayouts === null) {
			if ($this->isNew()) {
				$this->collThemeLayouts = array();
			} else {

				$criteria->add(ThemeLayoutPeer::THEME_ID, $this->getId());

				$this->collThemeLayouts = ThemeLayoutPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ThemeLayoutPeer::THEME_ID, $this->getId());

			if (!isset($this->lastThemeLayoutCriteria) || !$this->lastThemeLayoutCriteria->equals($criteria)) {
				$this->collThemeLayouts = ThemeLayoutPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastThemeLayoutCriteria = $criteria;

		return $this->collThemeLayouts;
	}

	/**
	 * Temporary storage of collThemesRelatedByBaseThemeId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initThemesRelatedByBaseThemeId()
	{
		if ($this->collThemesRelatedByBaseThemeId === null) {
			$this->collThemesRelatedByBaseThemeId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Theme has previously
	 * been saved, it will retrieve related ThemesRelatedByBaseThemeId from storage.
	 * If this Theme is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getThemesRelatedByBaseThemeId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collThemesRelatedByBaseThemeId === null) {
			if ($this->isNew()) {
			   $this->collThemesRelatedByBaseThemeId = array();
			} else {

				$criteria->add(ThemePeer::BASE_THEME_ID, $this->getId());

				ThemePeer::addSelectColumns($criteria);
				$this->collThemesRelatedByBaseThemeId = ThemePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ThemePeer::BASE_THEME_ID, $this->getId());

				ThemePeer::addSelectColumns($criteria);
				if (!isset($this->lastThemeRelatedByBaseThemeIdCriteria) || !$this->lastThemeRelatedByBaseThemeIdCriteria->equals($criteria)) {
					$this->collThemesRelatedByBaseThemeId = ThemePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastThemeRelatedByBaseThemeIdCriteria = $criteria;
		return $this->collThemesRelatedByBaseThemeId;
	}

	/**
	 * Returns the number of related ThemesRelatedByBaseThemeId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countThemesRelatedByBaseThemeId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ThemePeer::BASE_THEME_ID, $this->getId());

		return ThemePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Theme object to this object
	 * through the Theme foreign key attribute
	 *
	 * @param      Theme $l Theme
	 * @return     void
	 * @throws     PropelException
	 */
	public function addThemeRelatedByBaseThemeId(Theme $l)
	{
		$this->collThemesRelatedByBaseThemeId[] = $l;
		$l->setThemeRelatedByBaseThemeId($this);
	}

	/**
	 * Temporary storage of collThemeCsss to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initThemeCsss()
	{
		if ($this->collThemeCsss === null) {
			$this->collThemeCsss = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Theme has previously
	 * been saved, it will retrieve related ThemeCsss from storage.
	 * If this Theme is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getThemeCsss($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collThemeCsss === null) {
			if ($this->isNew()) {
			   $this->collThemeCsss = array();
			} else {

				$criteria->add(ThemeCssPeer::THEME_ID, $this->getId());

				ThemeCssPeer::addSelectColumns($criteria);
				$this->collThemeCsss = ThemeCssPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ThemeCssPeer::THEME_ID, $this->getId());

				ThemeCssPeer::addSelectColumns($criteria);
				if (!isset($this->lastThemeCssCriteria) || !$this->lastThemeCssCriteria->equals($criteria)) {
					$this->collThemeCsss = ThemeCssPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastThemeCssCriteria = $criteria;
		return $this->collThemeCsss;
	}

	/**
	 * Returns the number of related ThemeCsss.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countThemeCsss($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ThemeCssPeer::THEME_ID, $this->getId());

		return ThemeCssPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ThemeCss object to this object
	 * through the ThemeCss foreign key attribute
	 *
	 * @param      ThemeCss $l ThemeCss
	 * @return     void
	 * @throws     PropelException
	 */
	public function addThemeCss(ThemeCss $l)
	{
		$this->collThemeCsss[] = $l;
		$l->setTheme($this);
	}

	/**
	 * Temporary storage of collThemeColorSchemes to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initThemeColorSchemes()
	{
		if ($this->collThemeColorSchemes === null) {
			$this->collThemeColorSchemes = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Theme has previously
	 * been saved, it will retrieve related ThemeColorSchemes from storage.
	 * If this Theme is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getThemeColorSchemes($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collThemeColorSchemes === null) {
			if ($this->isNew()) {
			   $this->collThemeColorSchemes = array();
			} else {

				$criteria->add(ThemeColorSchemePeer::THEME_ID, $this->getId());

				ThemeColorSchemePeer::addSelectColumns($criteria);
				$this->collThemeColorSchemes = ThemeColorSchemePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ThemeColorSchemePeer::THEME_ID, $this->getId());

				ThemeColorSchemePeer::addSelectColumns($criteria);
				if (!isset($this->lastThemeColorSchemeCriteria) || !$this->lastThemeColorSchemeCriteria->equals($criteria)) {
					$this->collThemeColorSchemes = ThemeColorSchemePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastThemeColorSchemeCriteria = $criteria;
		return $this->collThemeColorSchemes;
	}

	/**
	 * Returns the number of related ThemeColorSchemes.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countThemeColorSchemes($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ThemeColorSchemePeer::THEME_ID, $this->getId());

		return ThemeColorSchemePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ThemeColorScheme object to this object
	 * through the ThemeColorScheme foreign key attribute
	 *
	 * @param      ThemeColorScheme $l ThemeColorScheme
	 * @return     void
	 * @throws     PropelException
	 */
	public function addThemeColorScheme(ThemeColorScheme $l)
	{
		$this->collThemeColorSchemes[] = $l;
		$l->setTheme($this);
	}

	/**
	 * Temporary storage of collThemeConfigs to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initThemeConfigs()
	{
		if ($this->collThemeConfigs === null) {
			$this->collThemeConfigs = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Theme has previously
	 * been saved, it will retrieve related ThemeConfigs from storage.
	 * If this Theme is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getThemeConfigs($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collThemeConfigs === null) {
			if ($this->isNew()) {
			   $this->collThemeConfigs = array();
			} else {

				$criteria->add(ThemeConfigPeer::ID, $this->getId());

				ThemeConfigPeer::addSelectColumns($criteria);
				$this->collThemeConfigs = ThemeConfigPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ThemeConfigPeer::ID, $this->getId());

				ThemeConfigPeer::addSelectColumns($criteria);
				if (!isset($this->lastThemeConfigCriteria) || !$this->lastThemeConfigCriteria->equals($criteria)) {
					$this->collThemeConfigs = ThemeConfigPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastThemeConfigCriteria = $criteria;
		return $this->collThemeConfigs;
	}

	/**
	 * Returns the number of related ThemeConfigs.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countThemeConfigs($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ThemeConfigPeer::ID, $this->getId());

		return ThemeConfigPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ThemeConfig object to this object
	 * through the ThemeConfig foreign key attribute
	 *
	 * @param      ThemeConfig $l ThemeConfig
	 * @return     void
	 * @throws     PropelException
	 */
	public function addThemeConfig(ThemeConfig $l)
	{
		$this->collThemeConfigs[] = $l;
		$l->setTheme($this);
	}

	/**
	 * Temporary storage of collThemeContents to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initThemeContents()
	{
		if ($this->collThemeContents === null) {
			$this->collThemeContents = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Theme has previously
	 * been saved, it will retrieve related ThemeContents from storage.
	 * If this Theme is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getThemeContents($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collThemeContents === null) {
			if ($this->isNew()) {
			   $this->collThemeContents = array();
			} else {

				$criteria->add(ThemeContentPeer::THEME_ID, $this->getId());

				ThemeContentPeer::addSelectColumns($criteria);
				$this->collThemeContents = ThemeContentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ThemeContentPeer::THEME_ID, $this->getId());

				ThemeContentPeer::addSelectColumns($criteria);
				if (!isset($this->lastThemeContentCriteria) || !$this->lastThemeContentCriteria->equals($criteria)) {
					$this->collThemeContents = ThemeContentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastThemeContentCriteria = $criteria;
		return $this->collThemeContents;
	}

	/**
	 * Returns the number of related ThemeContents.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countThemeContents($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ThemeContentPeer::THEME_ID, $this->getId());

		return ThemeContentPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ThemeContent object to this object
	 * through the ThemeContent foreign key attribute
	 *
	 * @param      ThemeContent $l ThemeContent
	 * @return     void
	 * @throws     PropelException
	 */
	public function addThemeContent(ThemeContent $l)
	{
		$this->collThemeContents[] = $l;
		$l->setTheme($this);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Theme.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseTheme:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseTheme::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseTheme
