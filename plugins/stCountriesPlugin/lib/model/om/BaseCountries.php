<?php

/**
 * Base class that represents a row from the 'st_countries' table.
 *
 * 
 *
 * @package    plugins.stCountriesPlugin.lib.model.om
 */
abstract class BaseCountries extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        CountriesPeer
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
	 * The value for the iso_a2 field.
	 * @var        string
	 */
	protected $iso_a2;


	/**
	 * The value for the iso_a3 field.
	 * @var        string
	 */
	protected $iso_a3;


	/**
	 * The value for the continent field.
	 * @var        string
	 */
	protected $continent;


	/**
	 * The value for the number field.
	 * @var        string
	 */
	protected $number;


	/**
	 * The value for the opt_name field.
	 * @var        string
	 */
	protected $opt_name;


	/**
	 * The value for the is_active field.
	 * @var        boolean
	 */
	protected $is_active = false;


	/**
	 * The value for the is_default field.
	 * @var        boolean
	 */
	protected $is_default = false;

	/**
	 * Collection to store aggregation of collCountriesAreaHasCountriess.
	 * @var        array
	 */
	protected $collCountriesAreaHasCountriess;

	/**
	 * The criteria used to select the current contents of collCountriesAreaHasCountriess.
	 * @var        Criteria
	 */
	protected $lastCountriesAreaHasCountriesCriteria = null;

	/**
	 * Collection to store aggregation of collCountriesI18ns.
	 * @var        array
	 */
	protected $collCountriesI18ns;

	/**
	 * The criteria used to select the current contents of collCountriesI18ns.
	 * @var        Criteria
	 */
	protected $lastCountriesI18nCriteria = null;

	/**
	 * Collection to store aggregation of collOrderUserDataBillings.
	 * @var        array
	 */
	protected $collOrderUserDataBillings;

	/**
	 * The criteria used to select the current contents of collOrderUserDataBillings.
	 * @var        Criteria
	 */
	protected $lastOrderUserDataBillingCriteria = null;

	/**
	 * Collection to store aggregation of collOrderUserDataDeliverys.
	 * @var        array
	 */
	protected $collOrderUserDataDeliverys;

	/**
	 * The criteria used to select the current contents of collOrderUserDataDeliverys.
	 * @var        Criteria
	 */
	protected $lastOrderUserDataDeliveryCriteria = null;

	/**
	 * Collection to store aggregation of collUserDatas.
	 * @var        array
	 */
	protected $collUserDatas;

	/**
	 * The criteria used to select the current contents of collUserDatas.
	 * @var        Criteria
	 */
	protected $lastUserDataCriteria = null;

	/**
	 * Collection to store aggregation of collPartners.
	 * @var        array
	 */
	protected $collPartners;

	/**
	 * The criteria used to select the current contents of collPartners.
	 * @var        Criteria
	 */
	protected $lastPartnerCriteria = null;

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
     * Get the [iso_a2] column value.
     * 
     * @return     string
     */
    public function getIsoA2()
    {

            return $this->iso_a2;
    }

    /**
     * Get the [iso_a3] column value.
     * 
     * @return     string
     */
    public function getIsoA3()
    {

            return $this->iso_a3;
    }

    /**
     * Get the [continent] column value.
     * 
     * @return     string
     */
    public function getContinent()
    {

            return $this->continent;
    }

    /**
     * Get the [number] column value.
     * 
     * @return     string
     */
    public function getNumber()
    {

            return $this->number;
    }

    /**
     * Get the [opt_name] column value.
     * 
     * @return     string
     */
    public function getOptName()
    {

            return $this->opt_name;
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
     * Get the [is_default] column value.
     * 
     * @return     boolean
     */
    public function getIsDefault()
    {

            return $this->is_default;
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
			$this->modifiedColumns[] = CountriesPeer::CREATED_AT;
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
			$this->modifiedColumns[] = CountriesPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = CountriesPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [iso_a2] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setIsoA2($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->iso_a2 !== $v) {
          $this->iso_a2 = $v;
          $this->modifiedColumns[] = CountriesPeer::ISO_A2;
        }

	} // setIsoA2()

	/**
	 * Set the value of [iso_a3] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setIsoA3($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->iso_a3 !== $v) {
          $this->iso_a3 = $v;
          $this->modifiedColumns[] = CountriesPeer::ISO_A3;
        }

	} // setIsoA3()

	/**
	 * Set the value of [continent] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setContinent($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->continent !== $v) {
          $this->continent = $v;
          $this->modifiedColumns[] = CountriesPeer::CONTINENT;
        }

	} // setContinent()

	/**
	 * Set the value of [number] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setNumber($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->number !== $v) {
          $this->number = $v;
          $this->modifiedColumns[] = CountriesPeer::NUMBER;
        }

	} // setNumber()

	/**
	 * Set the value of [opt_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptName($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_name !== $v) {
          $this->opt_name = $v;
          $this->modifiedColumns[] = CountriesPeer::OPT_NAME;
        }

	} // setOptName()

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

        if ($this->is_active !== $v || $v === false) {
          $this->is_active = $v;
          $this->modifiedColumns[] = CountriesPeer::IS_ACTIVE;
        }

	} // setIsActive()

	/**
	 * Set the value of [is_default] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsDefault($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_default !== $v || $v === false) {
          $this->is_default = $v;
          $this->modifiedColumns[] = CountriesPeer::IS_DEFAULT;
        }

	} // setIsDefault()

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
      if ($this->getDispatcher()->getListeners('Countries.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Countries.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->iso_a2 = $rs->getString($startcol + 3);

      $this->iso_a3 = $rs->getString($startcol + 4);

      $this->continent = $rs->getString($startcol + 5);

      $this->number = $rs->getString($startcol + 6);

      $this->opt_name = $rs->getString($startcol + 7);

      $this->is_active = $rs->getBoolean($startcol + 8);

      $this->is_default = $rs->getBoolean($startcol + 9);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Countries.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Countries.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 10)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 10; // 10 = CountriesPeer::NUM_COLUMNS - CountriesPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Countries object", $e);
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

    if ($this->getDispatcher()->getListeners('Countries.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Countries.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseCountries:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseCountries:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(CountriesPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      CountriesPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Countries.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Countries.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseCountries:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseCountries:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Countries.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Countries.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseCountries:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(CountriesPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(CountriesPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(CountriesPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Countries.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Countries.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseCountries:save:post') as $callable)
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
					$pk = CountriesPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += CountriesPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collCountriesAreaHasCountriess !== null) {
				foreach($this->collCountriesAreaHasCountriess as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collCountriesI18ns !== null) {
				foreach($this->collCountriesI18ns as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOrderUserDataBillings !== null) {
				foreach($this->collOrderUserDataBillings as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOrderUserDataDeliverys !== null) {
				foreach($this->collOrderUserDataDeliverys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserDatas !== null) {
				foreach($this->collUserDatas as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPartners !== null) {
				foreach($this->collPartners as $referrerFK) {
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


			if (($retval = CountriesPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collCountriesAreaHasCountriess !== null) {
					foreach($this->collCountriesAreaHasCountriess as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collCountriesI18ns !== null) {
					foreach($this->collCountriesI18ns as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOrderUserDataBillings !== null) {
					foreach($this->collOrderUserDataBillings as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOrderUserDataDeliverys !== null) {
					foreach($this->collOrderUserDataDeliverys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserDatas !== null) {
					foreach($this->collUserDatas as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPartners !== null) {
					foreach($this->collPartners as $referrerFK) {
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
		$pos = CountriesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getIsoA2();
				break;
			case 4:
				return $this->getIsoA3();
				break;
			case 5:
				return $this->getContinent();
				break;
			case 6:
				return $this->getNumber();
				break;
			case 7:
				return $this->getOptName();
				break;
			case 8:
				return $this->getIsActive();
				break;
			case 9:
				return $this->getIsDefault();
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
		$keys = CountriesPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getIsoA2(),
			$keys[4] => $this->getIsoA3(),
			$keys[5] => $this->getContinent(),
			$keys[6] => $this->getNumber(),
			$keys[7] => $this->getOptName(),
			$keys[8] => $this->getIsActive(),
			$keys[9] => $this->getIsDefault(),
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
		$pos = CountriesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setIsoA2($value);
				break;
			case 4:
				$this->setIsoA3($value);
				break;
			case 5:
				$this->setContinent($value);
				break;
			case 6:
				$this->setNumber($value);
				break;
			case 7:
				$this->setOptName($value);
				break;
			case 8:
				$this->setIsActive($value);
				break;
			case 9:
				$this->setIsDefault($value);
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
		$keys = CountriesPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setIsoA2($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setIsoA3($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setContinent($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setNumber($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setOptName($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsActive($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setIsDefault($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(CountriesPeer::DATABASE_NAME);

		if ($this->isColumnModified(CountriesPeer::CREATED_AT)) $criteria->add(CountriesPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(CountriesPeer::UPDATED_AT)) $criteria->add(CountriesPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(CountriesPeer::ID)) $criteria->add(CountriesPeer::ID, $this->id);
		if ($this->isColumnModified(CountriesPeer::ISO_A2)) $criteria->add(CountriesPeer::ISO_A2, $this->iso_a2);
		if ($this->isColumnModified(CountriesPeer::ISO_A3)) $criteria->add(CountriesPeer::ISO_A3, $this->iso_a3);
		if ($this->isColumnModified(CountriesPeer::CONTINENT)) $criteria->add(CountriesPeer::CONTINENT, $this->continent);
		if ($this->isColumnModified(CountriesPeer::NUMBER)) $criteria->add(CountriesPeer::NUMBER, $this->number);
		if ($this->isColumnModified(CountriesPeer::OPT_NAME)) $criteria->add(CountriesPeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(CountriesPeer::IS_ACTIVE)) $criteria->add(CountriesPeer::IS_ACTIVE, $this->is_active);
		if ($this->isColumnModified(CountriesPeer::IS_DEFAULT)) $criteria->add(CountriesPeer::IS_DEFAULT, $this->is_default);

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
		$criteria = new Criteria(CountriesPeer::DATABASE_NAME);

		$criteria->add(CountriesPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Countries (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setIsoA2($this->iso_a2);

		$copyObj->setIsoA3($this->iso_a3);

		$copyObj->setContinent($this->continent);

		$copyObj->setNumber($this->number);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setIsActive($this->is_active);

		$copyObj->setIsDefault($this->is_default);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getCountriesAreaHasCountriess() as $relObj) {
				$copyObj->addCountriesAreaHasCountries($relObj->copy($deepCopy));
			}

			foreach($this->getCountriesI18ns() as $relObj) {
				$copyObj->addCountriesI18n($relObj->copy($deepCopy));
			}

			foreach($this->getOrderUserDataBillings() as $relObj) {
				$copyObj->addOrderUserDataBilling($relObj->copy($deepCopy));
			}

			foreach($this->getOrderUserDataDeliverys() as $relObj) {
				$copyObj->addOrderUserDataDelivery($relObj->copy($deepCopy));
			}

			foreach($this->getUserDatas() as $relObj) {
				$copyObj->addUserData($relObj->copy($deepCopy));
			}

			foreach($this->getPartners() as $relObj) {
				$copyObj->addPartner($relObj->copy($deepCopy));
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
	 * @return     Countries Clone of current object.
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
	 * @return     CountriesPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new CountriesPeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collCountriesAreaHasCountriess to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initCountriesAreaHasCountriess()
	{
		if ($this->collCountriesAreaHasCountriess === null) {
			$this->collCountriesAreaHasCountriess = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Countries has previously
	 * been saved, it will retrieve related CountriesAreaHasCountriess from storage.
	 * If this Countries is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getCountriesAreaHasCountriess($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCountriesAreaHasCountriess === null) {
			if ($this->isNew()) {
			   $this->collCountriesAreaHasCountriess = array();
			} else {

				$criteria->add(CountriesAreaHasCountriesPeer::COUNTRIES_ID, $this->getId());

				CountriesAreaHasCountriesPeer::addSelectColumns($criteria);
				$this->collCountriesAreaHasCountriess = CountriesAreaHasCountriesPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(CountriesAreaHasCountriesPeer::COUNTRIES_ID, $this->getId());

				CountriesAreaHasCountriesPeer::addSelectColumns($criteria);
				if (!isset($this->lastCountriesAreaHasCountriesCriteria) || !$this->lastCountriesAreaHasCountriesCriteria->equals($criteria)) {
					$this->collCountriesAreaHasCountriess = CountriesAreaHasCountriesPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCountriesAreaHasCountriesCriteria = $criteria;
		return $this->collCountriesAreaHasCountriess;
	}

	/**
	 * Returns the number of related CountriesAreaHasCountriess.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countCountriesAreaHasCountriess($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CountriesAreaHasCountriesPeer::COUNTRIES_ID, $this->getId());

		return CountriesAreaHasCountriesPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a CountriesAreaHasCountries object to this object
	 * through the CountriesAreaHasCountries foreign key attribute
	 *
	 * @param      CountriesAreaHasCountries $l CountriesAreaHasCountries
	 * @return     void
	 * @throws     PropelException
	 */
	public function addCountriesAreaHasCountries(CountriesAreaHasCountries $l)
	{
		$this->collCountriesAreaHasCountriess[] = $l;
		$l->setCountries($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Countries is new, it will return
	 * an empty collection; or if this Countries has previously
	 * been saved, it will retrieve related CountriesAreaHasCountriess from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Countries.
	 */
	public function getCountriesAreaHasCountriessJoinCountriesArea($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCountriesAreaHasCountriess === null) {
			if ($this->isNew()) {
				$this->collCountriesAreaHasCountriess = array();
			} else {

				$criteria->add(CountriesAreaHasCountriesPeer::COUNTRIES_ID, $this->getId());

				$this->collCountriesAreaHasCountriess = CountriesAreaHasCountriesPeer::doSelectJoinCountriesArea($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(CountriesAreaHasCountriesPeer::COUNTRIES_ID, $this->getId());

			if (!isset($this->lastCountriesAreaHasCountriesCriteria) || !$this->lastCountriesAreaHasCountriesCriteria->equals($criteria)) {
				$this->collCountriesAreaHasCountriess = CountriesAreaHasCountriesPeer::doSelectJoinCountriesArea($criteria, $con);
			}
		}
		$this->lastCountriesAreaHasCountriesCriteria = $criteria;

		return $this->collCountriesAreaHasCountriess;
	}

	/**
	 * Temporary storage of collCountriesI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initCountriesI18ns()
	{
		if ($this->collCountriesI18ns === null) {
			$this->collCountriesI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Countries has previously
	 * been saved, it will retrieve related CountriesI18ns from storage.
	 * If this Countries is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getCountriesI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCountriesI18ns === null) {
			if ($this->isNew()) {
			   $this->collCountriesI18ns = array();
			} else {

				$criteria->add(CountriesI18nPeer::ID, $this->getId());

				CountriesI18nPeer::addSelectColumns($criteria);
				$this->collCountriesI18ns = CountriesI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(CountriesI18nPeer::ID, $this->getId());

				CountriesI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastCountriesI18nCriteria) || !$this->lastCountriesI18nCriteria->equals($criteria)) {
					$this->collCountriesI18ns = CountriesI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCountriesI18nCriteria = $criteria;
		return $this->collCountriesI18ns;
	}

	/**
	 * Returns the number of related CountriesI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countCountriesI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CountriesI18nPeer::ID, $this->getId());

		return CountriesI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a CountriesI18n object to this object
	 * through the CountriesI18n foreign key attribute
	 *
	 * @param      CountriesI18n $l CountriesI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addCountriesI18n(CountriesI18n $l)
	{
		$this->collCountriesI18ns[] = $l;
		$l->setCountries($this);
	}

	/**
	 * Temporary storage of collOrderUserDataBillings to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOrderUserDataBillings()
	{
		if ($this->collOrderUserDataBillings === null) {
			$this->collOrderUserDataBillings = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Countries has previously
	 * been saved, it will retrieve related OrderUserDataBillings from storage.
	 * If this Countries is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOrderUserDataBillings($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderUserDataBillings === null) {
			if ($this->isNew()) {
			   $this->collOrderUserDataBillings = array();
			} else {

				$criteria->add(OrderUserDataBillingPeer::COUNTRIES_ID, $this->getId());

				OrderUserDataBillingPeer::addSelectColumns($criteria);
				$this->collOrderUserDataBillings = OrderUserDataBillingPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderUserDataBillingPeer::COUNTRIES_ID, $this->getId());

				OrderUserDataBillingPeer::addSelectColumns($criteria);
				if (!isset($this->lastOrderUserDataBillingCriteria) || !$this->lastOrderUserDataBillingCriteria->equals($criteria)) {
					$this->collOrderUserDataBillings = OrderUserDataBillingPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOrderUserDataBillingCriteria = $criteria;
		return $this->collOrderUserDataBillings;
	}

	/**
	 * Returns the number of related OrderUserDataBillings.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOrderUserDataBillings($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OrderUserDataBillingPeer::COUNTRIES_ID, $this->getId());

		return OrderUserDataBillingPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a OrderUserDataBilling object to this object
	 * through the OrderUserDataBilling foreign key attribute
	 *
	 * @param      OrderUserDataBilling $l OrderUserDataBilling
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOrderUserDataBilling(OrderUserDataBilling $l)
	{
		$this->collOrderUserDataBillings[] = $l;
		$l->setCountries($this);
	}

	/**
	 * Temporary storage of collOrderUserDataDeliverys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOrderUserDataDeliverys()
	{
		if ($this->collOrderUserDataDeliverys === null) {
			$this->collOrderUserDataDeliverys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Countries has previously
	 * been saved, it will retrieve related OrderUserDataDeliverys from storage.
	 * If this Countries is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOrderUserDataDeliverys($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderUserDataDeliverys === null) {
			if ($this->isNew()) {
			   $this->collOrderUserDataDeliverys = array();
			} else {

				$criteria->add(OrderUserDataDeliveryPeer::COUNTRIES_ID, $this->getId());

				OrderUserDataDeliveryPeer::addSelectColumns($criteria);
				$this->collOrderUserDataDeliverys = OrderUserDataDeliveryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderUserDataDeliveryPeer::COUNTRIES_ID, $this->getId());

				OrderUserDataDeliveryPeer::addSelectColumns($criteria);
				if (!isset($this->lastOrderUserDataDeliveryCriteria) || !$this->lastOrderUserDataDeliveryCriteria->equals($criteria)) {
					$this->collOrderUserDataDeliverys = OrderUserDataDeliveryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOrderUserDataDeliveryCriteria = $criteria;
		return $this->collOrderUserDataDeliverys;
	}

	/**
	 * Returns the number of related OrderUserDataDeliverys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOrderUserDataDeliverys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OrderUserDataDeliveryPeer::COUNTRIES_ID, $this->getId());

		return OrderUserDataDeliveryPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a OrderUserDataDelivery object to this object
	 * through the OrderUserDataDelivery foreign key attribute
	 *
	 * @param      OrderUserDataDelivery $l OrderUserDataDelivery
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOrderUserDataDelivery(OrderUserDataDelivery $l)
	{
		$this->collOrderUserDataDeliverys[] = $l;
		$l->setCountries($this);
	}

	/**
	 * Temporary storage of collUserDatas to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initUserDatas()
	{
		if ($this->collUserDatas === null) {
			$this->collUserDatas = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Countries has previously
	 * been saved, it will retrieve related UserDatas from storage.
	 * If this Countries is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getUserDatas($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserDatas === null) {
			if ($this->isNew()) {
			   $this->collUserDatas = array();
			} else {

				$criteria->add(UserDataPeer::COUNTRIES_ID, $this->getId());

				UserDataPeer::addSelectColumns($criteria);
				$this->collUserDatas = UserDataPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserDataPeer::COUNTRIES_ID, $this->getId());

				UserDataPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserDataCriteria) || !$this->lastUserDataCriteria->equals($criteria)) {
					$this->collUserDatas = UserDataPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserDataCriteria = $criteria;
		return $this->collUserDatas;
	}

	/**
	 * Returns the number of related UserDatas.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countUserDatas($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(UserDataPeer::COUNTRIES_ID, $this->getId());

		return UserDataPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a UserData object to this object
	 * through the UserData foreign key attribute
	 *
	 * @param      UserData $l UserData
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserData(UserData $l)
	{
		$this->collUserDatas[] = $l;
		$l->setCountries($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Countries is new, it will return
	 * an empty collection; or if this Countries has previously
	 * been saved, it will retrieve related UserDatas from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Countries.
	 */
	public function getUserDatasJoinsfGuardUser($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserDatas === null) {
			if ($this->isNew()) {
				$this->collUserDatas = array();
			} else {

				$criteria->add(UserDataPeer::COUNTRIES_ID, $this->getId());

				$this->collUserDatas = UserDataPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserDataPeer::COUNTRIES_ID, $this->getId());

			if (!isset($this->lastUserDataCriteria) || !$this->lastUserDataCriteria->equals($criteria)) {
				$this->collUserDatas = UserDataPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastUserDataCriteria = $criteria;

		return $this->collUserDatas;
	}

	/**
	 * Temporary storage of collPartners to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPartners()
	{
		if ($this->collPartners === null) {
			$this->collPartners = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Countries has previously
	 * been saved, it will retrieve related Partners from storage.
	 * If this Countries is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPartners($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPartners === null) {
			if ($this->isNew()) {
			   $this->collPartners = array();
			} else {

				$criteria->add(PartnerPeer::COUNTRIES_ID, $this->getId());

				PartnerPeer::addSelectColumns($criteria);
				$this->collPartners = PartnerPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PartnerPeer::COUNTRIES_ID, $this->getId());

				PartnerPeer::addSelectColumns($criteria);
				if (!isset($this->lastPartnerCriteria) || !$this->lastPartnerCriteria->equals($criteria)) {
					$this->collPartners = PartnerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPartnerCriteria = $criteria;
		return $this->collPartners;
	}

	/**
	 * Returns the number of related Partners.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPartners($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PartnerPeer::COUNTRIES_ID, $this->getId());

		return PartnerPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Partner object to this object
	 * through the Partner foreign key attribute
	 *
	 * @param      Partner $l Partner
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPartner(Partner $l)
	{
		$this->collPartners[] = $l;
		$l->setCountries($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Countries is new, it will return
	 * an empty collection; or if this Countries has previously
	 * been saved, it will retrieve related Partners from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Countries.
	 */
	public function getPartnersJoinsfGuardUser($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPartners === null) {
			if ($this->isNew()) {
				$this->collPartners = array();
			} else {

				$criteria->add(PartnerPeer::COUNTRIES_ID, $this->getId());

				$this->collPartners = PartnerPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PartnerPeer::COUNTRIES_ID, $this->getId());

			if (!isset($this->lastPartnerCriteria) || !$this->lastPartnerCriteria->equals($criteria)) {
				$this->collPartners = PartnerPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastPartnerCriteria = $criteria;

		return $this->collPartners;
	}

  public function getCulture()
  {
    return $this->culture;
  }

  public function setCulture($culture)
  {
    $this->culture = $culture;
  }

  public function getName()
  {
    $obj = $this->getCurrentCountriesI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentCountriesI18n()->setName($value);
  }

  public $current_i18n = array();

  public function getCurrentCountriesI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = CountriesI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setCountriesI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setCountriesI18nForCulture(new CountriesI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setCountriesI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addCountriesI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Countries.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseCountries:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseCountries::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseCountries
