<?php

/**
 * Base class that represents a row from the 'st_currency' table.
 *
 * 
 *
 * @package    plugins.stCurrencyPlugin.lib.model.om
 */
abstract class BaseCurrency extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        CurrencyPeer
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
	 * The value for the currency_standard_id field.
	 * @var        int
	 */
	protected $currency_standard_id;


	/**
	 * The value for the shortcut field.
	 * @var        string
	 */
	protected $shortcut;


	/**
	 * The value for the exchange field.
	 * @var        double
	 */
	protected $exchange;


	/**
	 * The value for the active field.
	 * @var        boolean
	 */
	protected $active;


	/**
	 * The value for the main field.
	 * @var        boolean
	 */
	protected $main;


	/**
	 * The value for the front_symbol field.
	 * @var        string
	 */
	protected $front_symbol;


	/**
	 * The value for the back_symbol field.
	 * @var        string
	 */
	protected $back_symbol;


	/**
	 * The value for the nbp_exchange field.
	 * @var        double
	 */
	protected $nbp_exchange;


	/**
	 * The value for the system field.
	 * @var        boolean
	 */
	protected $system;


	/**
	 * The value for the opt_name field.
	 * @var        string
	 */
	protected $opt_name;

	/**
	 * @var        CurrencyStandard
	 */
	protected $aCurrencyStandard;

	/**
	 * Collection to store aggregation of collProducts.
	 * @var        array
	 */
	protected $collProducts;

	/**
	 * The criteria used to select the current contents of collProducts.
	 * @var        Criteria
	 */
	protected $lastProductCriteria = null;

	/**
	 * Collection to store aggregation of collAddPrices.
	 * @var        array
	 */
	protected $collAddPrices;

	/**
	 * The criteria used to select the current contents of collAddPrices.
	 * @var        Criteria
	 */
	protected $lastAddPriceCriteria = null;

	/**
	 * Collection to store aggregation of collAddGroupPrices.
	 * @var        array
	 */
	protected $collAddGroupPrices;

	/**
	 * The criteria used to select the current contents of collAddGroupPrices.
	 * @var        Criteria
	 */
	protected $lastAddGroupPriceCriteria = null;

	/**
	 * Collection to store aggregation of collCurrencyI18ns.
	 * @var        array
	 */
	protected $collCurrencyI18ns;

	/**
	 * The criteria used to select the current contents of collCurrencyI18ns.
	 * @var        Criteria
	 */
	protected $lastCurrencyI18nCriteria = null;

	/**
	 * Collection to store aggregation of collGiftCards.
	 * @var        array
	 */
	protected $collGiftCards;

	/**
	 * The criteria used to select the current contents of collGiftCards.
	 * @var        Criteria
	 */
	protected $lastGiftCardCriteria = null;

	/**
	 * Collection to store aggregation of collGroupPrices.
	 * @var        array
	 */
	protected $collGroupPrices;

	/**
	 * The criteria used to select the current contents of collGroupPrices.
	 * @var        Criteria
	 */
	protected $lastGroupPriceCriteria = null;

	/**
	 * Collection to store aggregation of collLanguages.
	 * @var        array
	 */
	protected $collLanguages;

	/**
	 * The criteria used to select the current contents of collLanguages.
	 * @var        Criteria
	 */
	protected $lastLanguageCriteria = null;

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
     * Get the [currency_standard_id] column value.
     * 
     * @return     int
     */
    public function getCurrencyStandardId()
    {

            return $this->currency_standard_id;
    }

    /**
     * Get the [shortcut] column value.
     * 
     * @return     string
     */
    public function getShortcut()
    {

            return $this->shortcut;
    }

    /**
     * Get the [exchange] column value.
     * 
     * @return     double
     */
    public function getExchange()
    {

            return null !== $this->exchange ? (string)$this->exchange : null;
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
     * Get the [main] column value.
     * 
     * @return     boolean
     */
    public function getMain()
    {

            return $this->main;
    }

    /**
     * Get the [front_symbol] column value.
     * 
     * @return     string
     */
    public function getFrontSymbol()
    {

            return $this->front_symbol;
    }

    /**
     * Get the [back_symbol] column value.
     * 
     * @return     string
     */
    public function getBackSymbol()
    {

            return $this->back_symbol;
    }

    /**
     * Get the [nbp_exchange] column value.
     * 
     * @return     double
     */
    public function getNbpExchange()
    {

            return $this->nbp_exchange;
    }

    /**
     * Get the [system] column value.
     * 
     * @return     boolean
     */
    public function getSystem()
    {

            return $this->system;
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
			$this->modifiedColumns[] = CurrencyPeer::CREATED_AT;
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
			$this->modifiedColumns[] = CurrencyPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = CurrencyPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [currency_standard_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCurrencyStandardId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->currency_standard_id !== $v) {
          $this->currency_standard_id = $v;
          $this->modifiedColumns[] = CurrencyPeer::CURRENCY_STANDARD_ID;
        }

		if ($this->aCurrencyStandard !== null && $this->aCurrencyStandard->getId() !== $v) {
			$this->aCurrencyStandard = null;
		}

	} // setCurrencyStandardId()

	/**
	 * Set the value of [shortcut] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setShortcut($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->shortcut !== $v) {
          $this->shortcut = $v;
          $this->modifiedColumns[] = CurrencyPeer::SHORTCUT;
        }

	} // setShortcut()

	/**
	 * Set the value of [exchange] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setExchange($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->exchange !== $v) {
          $this->exchange = $v;
          $this->modifiedColumns[] = CurrencyPeer::EXCHANGE;
        }

	} // setExchange()

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

        if ($this->active !== $v) {
          $this->active = $v;
          $this->modifiedColumns[] = CurrencyPeer::ACTIVE;
        }

	} // setActive()

	/**
	 * Set the value of [main] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setMain($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->main !== $v) {
          $this->main = $v;
          $this->modifiedColumns[] = CurrencyPeer::MAIN;
        }

	} // setMain()

	/**
	 * Set the value of [front_symbol] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFrontSymbol($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->front_symbol !== $v) {
          $this->front_symbol = $v;
          $this->modifiedColumns[] = CurrencyPeer::FRONT_SYMBOL;
        }

	} // setFrontSymbol()

	/**
	 * Set the value of [back_symbol] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setBackSymbol($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->back_symbol !== $v) {
          $this->back_symbol = $v;
          $this->modifiedColumns[] = CurrencyPeer::BACK_SYMBOL;
        }

	} // setBackSymbol()

	/**
	 * Set the value of [nbp_exchange] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setNbpExchange($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->nbp_exchange !== $v) {
          $this->nbp_exchange = $v;
          $this->modifiedColumns[] = CurrencyPeer::NBP_EXCHANGE;
        }

	} // setNbpExchange()

	/**
	 * Set the value of [system] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setSystem($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->system !== $v) {
          $this->system = $v;
          $this->modifiedColumns[] = CurrencyPeer::SYSTEM;
        }

	} // setSystem()

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
          $this->modifiedColumns[] = CurrencyPeer::OPT_NAME;
        }

	} // setOptName()

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
      if ($this->getDispatcher()->getListeners('Currency.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Currency.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->currency_standard_id = $rs->getInt($startcol + 3);

      $this->shortcut = $rs->getString($startcol + 4);

      $this->exchange = $rs->getString($startcol + 5);
      if (null !== $this->exchange && $this->exchange == intval($this->exchange))
      {
        $this->exchange = (string)intval($this->exchange);
      }

      $this->active = $rs->getBoolean($startcol + 6);

      $this->main = $rs->getBoolean($startcol + 7);

      $this->front_symbol = $rs->getString($startcol + 8);

      $this->back_symbol = $rs->getString($startcol + 9);

      $this->nbp_exchange = $rs->getFloat($startcol + 10);

      $this->system = $rs->getBoolean($startcol + 11);

      $this->opt_name = $rs->getString($startcol + 12);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Currency.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Currency.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 13)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 13; // 13 = CurrencyPeer::NUM_COLUMNS - CurrencyPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Currency object", $e);
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

    if ($this->getDispatcher()->getListeners('Currency.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Currency.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseCurrency:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseCurrency:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(CurrencyPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      CurrencyPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Currency.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Currency.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseCurrency:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseCurrency:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Currency.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Currency.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseCurrency:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(CurrencyPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(CurrencyPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(CurrencyPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Currency.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Currency.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseCurrency:save:post') as $callable)
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

			if ($this->aCurrencyStandard !== null) {
				if ($this->aCurrencyStandard->isModified()) {
					$affectedRows += $this->aCurrencyStandard->save($con);
				}
				$this->setCurrencyStandard($this->aCurrencyStandard);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = CurrencyPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += CurrencyPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collProducts !== null) {
				foreach($this->collProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAddPrices !== null) {
				foreach($this->collAddPrices as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAddGroupPrices !== null) {
				foreach($this->collAddGroupPrices as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collCurrencyI18ns !== null) {
				foreach($this->collCurrencyI18ns as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGiftCards !== null) {
				foreach($this->collGiftCards as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGroupPrices !== null) {
				foreach($this->collGroupPrices as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLanguages !== null) {
				foreach($this->collLanguages as $referrerFK) {
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

			if ($this->aCurrencyStandard !== null) {
				if (!$this->aCurrencyStandard->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCurrencyStandard->getValidationFailures());
				}
			}


			if (($retval = CurrencyPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collProducts !== null) {
					foreach($this->collProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAddPrices !== null) {
					foreach($this->collAddPrices as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAddGroupPrices !== null) {
					foreach($this->collAddGroupPrices as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collCurrencyI18ns !== null) {
					foreach($this->collCurrencyI18ns as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGiftCards !== null) {
					foreach($this->collGiftCards as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGroupPrices !== null) {
					foreach($this->collGroupPrices as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLanguages !== null) {
					foreach($this->collLanguages as $referrerFK) {
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
		$pos = CurrencyPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCurrencyStandardId();
				break;
			case 4:
				return $this->getShortcut();
				break;
			case 5:
				return $this->getExchange();
				break;
			case 6:
				return $this->getActive();
				break;
			case 7:
				return $this->getMain();
				break;
			case 8:
				return $this->getFrontSymbol();
				break;
			case 9:
				return $this->getBackSymbol();
				break;
			case 10:
				return $this->getNbpExchange();
				break;
			case 11:
				return $this->getSystem();
				break;
			case 12:
				return $this->getOptName();
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
		$keys = CurrencyPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getCurrencyStandardId(),
			$keys[4] => $this->getShortcut(),
			$keys[5] => $this->getExchange(),
			$keys[6] => $this->getActive(),
			$keys[7] => $this->getMain(),
			$keys[8] => $this->getFrontSymbol(),
			$keys[9] => $this->getBackSymbol(),
			$keys[10] => $this->getNbpExchange(),
			$keys[11] => $this->getSystem(),
			$keys[12] => $this->getOptName(),
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
		$pos = CurrencyPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setCurrencyStandardId($value);
				break;
			case 4:
				$this->setShortcut($value);
				break;
			case 5:
				$this->setExchange($value);
				break;
			case 6:
				$this->setActive($value);
				break;
			case 7:
				$this->setMain($value);
				break;
			case 8:
				$this->setFrontSymbol($value);
				break;
			case 9:
				$this->setBackSymbol($value);
				break;
			case 10:
				$this->setNbpExchange($value);
				break;
			case 11:
				$this->setSystem($value);
				break;
			case 12:
				$this->setOptName($value);
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
		$keys = CurrencyPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCurrencyStandardId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setShortcut($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setExchange($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setActive($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setMain($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setFrontSymbol($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setBackSymbol($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setNbpExchange($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setSystem($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setOptName($arr[$keys[12]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(CurrencyPeer::DATABASE_NAME);

		if ($this->isColumnModified(CurrencyPeer::CREATED_AT)) $criteria->add(CurrencyPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(CurrencyPeer::UPDATED_AT)) $criteria->add(CurrencyPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(CurrencyPeer::ID)) $criteria->add(CurrencyPeer::ID, $this->id);
		if ($this->isColumnModified(CurrencyPeer::CURRENCY_STANDARD_ID)) $criteria->add(CurrencyPeer::CURRENCY_STANDARD_ID, $this->currency_standard_id);
		if ($this->isColumnModified(CurrencyPeer::SHORTCUT)) $criteria->add(CurrencyPeer::SHORTCUT, $this->shortcut);
		if ($this->isColumnModified(CurrencyPeer::EXCHANGE)) $criteria->add(CurrencyPeer::EXCHANGE, $this->exchange);
		if ($this->isColumnModified(CurrencyPeer::ACTIVE)) $criteria->add(CurrencyPeer::ACTIVE, $this->active);
		if ($this->isColumnModified(CurrencyPeer::MAIN)) $criteria->add(CurrencyPeer::MAIN, $this->main);
		if ($this->isColumnModified(CurrencyPeer::FRONT_SYMBOL)) $criteria->add(CurrencyPeer::FRONT_SYMBOL, $this->front_symbol);
		if ($this->isColumnModified(CurrencyPeer::BACK_SYMBOL)) $criteria->add(CurrencyPeer::BACK_SYMBOL, $this->back_symbol);
		if ($this->isColumnModified(CurrencyPeer::NBP_EXCHANGE)) $criteria->add(CurrencyPeer::NBP_EXCHANGE, $this->nbp_exchange);
		if ($this->isColumnModified(CurrencyPeer::SYSTEM)) $criteria->add(CurrencyPeer::SYSTEM, $this->system);
		if ($this->isColumnModified(CurrencyPeer::OPT_NAME)) $criteria->add(CurrencyPeer::OPT_NAME, $this->opt_name);

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
		$criteria = new Criteria(CurrencyPeer::DATABASE_NAME);

		$criteria->add(CurrencyPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Currency (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setCurrencyStandardId($this->currency_standard_id);

		$copyObj->setShortcut($this->shortcut);

		$copyObj->setExchange($this->exchange);

		$copyObj->setActive($this->active);

		$copyObj->setMain($this->main);

		$copyObj->setFrontSymbol($this->front_symbol);

		$copyObj->setBackSymbol($this->back_symbol);

		$copyObj->setNbpExchange($this->nbp_exchange);

		$copyObj->setSystem($this->system);

		$copyObj->setOptName($this->opt_name);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getProducts() as $relObj) {
				$copyObj->addProduct($relObj->copy($deepCopy));
			}

			foreach($this->getAddPrices() as $relObj) {
				$copyObj->addAddPrice($relObj->copy($deepCopy));
			}

			foreach($this->getAddGroupPrices() as $relObj) {
				$copyObj->addAddGroupPrice($relObj->copy($deepCopy));
			}

			foreach($this->getCurrencyI18ns() as $relObj) {
				$copyObj->addCurrencyI18n($relObj->copy($deepCopy));
			}

			foreach($this->getGiftCards() as $relObj) {
				$copyObj->addGiftCard($relObj->copy($deepCopy));
			}

			foreach($this->getGroupPrices() as $relObj) {
				$copyObj->addGroupPrice($relObj->copy($deepCopy));
			}

			foreach($this->getLanguages() as $relObj) {
				$copyObj->addLanguage($relObj->copy($deepCopy));
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
	 * @return     Currency Clone of current object.
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
	 * @return     CurrencyPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new CurrencyPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a CurrencyStandard object.
	 *
	 * @param      CurrencyStandard $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setCurrencyStandard($v)
	{


		if ($v === null) {
			$this->setCurrencyStandardId(NULL);
		} else {
			$this->setCurrencyStandardId($v->getId());
		}


		$this->aCurrencyStandard = $v;
	}


	/**
	 * Get the associated CurrencyStandard object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     CurrencyStandard The associated CurrencyStandard object.
	 * @throws     PropelException
	 */
	public function getCurrencyStandard($con = null)
	{
		if ($this->aCurrencyStandard === null && ($this->currency_standard_id !== null)) {
			// include the related Peer class
			$this->aCurrencyStandard = CurrencyStandardPeer::retrieveByPK($this->currency_standard_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = CurrencyStandardPeer::retrieveByPK($this->currency_standard_id, $con);
			   $obj->addCurrencyStandards($this);
			 */
		}
		return $this->aCurrencyStandard;
	}

	/**
	 * Temporary storage of collProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProducts()
	{
		if ($this->collProducts === null) {
			$this->collProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency has previously
	 * been saved, it will retrieve related Products from storage.
	 * If this Currency is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
			   $this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

				ProductPeer::addSelectColumns($criteria);
				$this->collProducts = ProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

				ProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
					$this->collProducts = ProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductCriteria = $criteria;
		return $this->collProducts;
	}

	/**
	 * Returns the number of related Products.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

		return ProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Product object to this object
	 * through the Product foreign key attribute
	 *
	 * @param      Product $l Product
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProduct(Product $l)
	{
		$this->collProducts[] = $l;
		$l->setCurrency($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency is new, it will return
	 * an empty collection; or if this Currency has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Currency.
	 */
	public function getProductsJoinProductRelatedByParentId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinProductRelatedByParentId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinProductRelatedByParentId($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency is new, it will return
	 * an empty collection; or if this Currency has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Currency.
	 */
	public function getProductsJoinProducer($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinProducer($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinProducer($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency is new, it will return
	 * an empty collection; or if this Currency has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Currency.
	 */
	public function getProductsJoinBasicPriceUnitMeasureRelatedByBpumDefaultId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumDefaultId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumDefaultId($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency is new, it will return
	 * an empty collection; or if this Currency has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Currency.
	 */
	public function getProductsJoinBasicPriceUnitMeasureRelatedByBpumId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumId($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency is new, it will return
	 * an empty collection; or if this Currency has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Currency.
	 */
	public function getProductsJoinProductDimension($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinProductDimension($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinProductDimension($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency is new, it will return
	 * an empty collection; or if this Currency has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Currency.
	 */
	public function getProductsJoinAvailability($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinAvailability($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinAvailability($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency is new, it will return
	 * an empty collection; or if this Currency has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Currency.
	 */
	public function getProductsJoinGroupPrice($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinGroupPrice($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinGroupPrice($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency is new, it will return
	 * an empty collection; or if this Currency has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Currency.
	 */
	public function getProductsJoinTax($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinTax($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::CURRENCY_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinTax($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}

	/**
	 * Temporary storage of collAddPrices to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initAddPrices()
	{
		if ($this->collAddPrices === null) {
			$this->collAddPrices = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency has previously
	 * been saved, it will retrieve related AddPrices from storage.
	 * If this Currency is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getAddPrices($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAddPrices === null) {
			if ($this->isNew()) {
			   $this->collAddPrices = array();
			} else {

				$criteria->add(AddPricePeer::CURRENCY_ID, $this->getId());

				AddPricePeer::addSelectColumns($criteria);
				$this->collAddPrices = AddPricePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AddPricePeer::CURRENCY_ID, $this->getId());

				AddPricePeer::addSelectColumns($criteria);
				if (!isset($this->lastAddPriceCriteria) || !$this->lastAddPriceCriteria->equals($criteria)) {
					$this->collAddPrices = AddPricePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAddPriceCriteria = $criteria;
		return $this->collAddPrices;
	}

	/**
	 * Returns the number of related AddPrices.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countAddPrices($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AddPricePeer::CURRENCY_ID, $this->getId());

		return AddPricePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a AddPrice object to this object
	 * through the AddPrice foreign key attribute
	 *
	 * @param      AddPrice $l AddPrice
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAddPrice(AddPrice $l)
	{
		$this->collAddPrices[] = $l;
		$l->setCurrency($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency is new, it will return
	 * an empty collection; or if this Currency has previously
	 * been saved, it will retrieve related AddPrices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Currency.
	 */
	public function getAddPricesJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAddPrices === null) {
			if ($this->isNew()) {
				$this->collAddPrices = array();
			} else {

				$criteria->add(AddPricePeer::CURRENCY_ID, $this->getId());

				$this->collAddPrices = AddPricePeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AddPricePeer::CURRENCY_ID, $this->getId());

			if (!isset($this->lastAddPriceCriteria) || !$this->lastAddPriceCriteria->equals($criteria)) {
				$this->collAddPrices = AddPricePeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastAddPriceCriteria = $criteria;

		return $this->collAddPrices;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency is new, it will return
	 * an empty collection; or if this Currency has previously
	 * been saved, it will retrieve related AddPrices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Currency.
	 */
	public function getAddPricesJoinTax($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAddPrices === null) {
			if ($this->isNew()) {
				$this->collAddPrices = array();
			} else {

				$criteria->add(AddPricePeer::CURRENCY_ID, $this->getId());

				$this->collAddPrices = AddPricePeer::doSelectJoinTax($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AddPricePeer::CURRENCY_ID, $this->getId());

			if (!isset($this->lastAddPriceCriteria) || !$this->lastAddPriceCriteria->equals($criteria)) {
				$this->collAddPrices = AddPricePeer::doSelectJoinTax($criteria, $con);
			}
		}
		$this->lastAddPriceCriteria = $criteria;

		return $this->collAddPrices;
	}

	/**
	 * Temporary storage of collAddGroupPrices to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initAddGroupPrices()
	{
		if ($this->collAddGroupPrices === null) {
			$this->collAddGroupPrices = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency has previously
	 * been saved, it will retrieve related AddGroupPrices from storage.
	 * If this Currency is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getAddGroupPrices($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAddGroupPrices === null) {
			if ($this->isNew()) {
			   $this->collAddGroupPrices = array();
			} else {

				$criteria->add(AddGroupPricePeer::CURRENCY_ID, $this->getId());

				AddGroupPricePeer::addSelectColumns($criteria);
				$this->collAddGroupPrices = AddGroupPricePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AddGroupPricePeer::CURRENCY_ID, $this->getId());

				AddGroupPricePeer::addSelectColumns($criteria);
				if (!isset($this->lastAddGroupPriceCriteria) || !$this->lastAddGroupPriceCriteria->equals($criteria)) {
					$this->collAddGroupPrices = AddGroupPricePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAddGroupPriceCriteria = $criteria;
		return $this->collAddGroupPrices;
	}

	/**
	 * Returns the number of related AddGroupPrices.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countAddGroupPrices($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AddGroupPricePeer::CURRENCY_ID, $this->getId());

		return AddGroupPricePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a AddGroupPrice object to this object
	 * through the AddGroupPrice foreign key attribute
	 *
	 * @param      AddGroupPrice $l AddGroupPrice
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAddGroupPrice(AddGroupPrice $l)
	{
		$this->collAddGroupPrices[] = $l;
		$l->setCurrency($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency is new, it will return
	 * an empty collection; or if this Currency has previously
	 * been saved, it will retrieve related AddGroupPrices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Currency.
	 */
	public function getAddGroupPricesJoinGroupPrice($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAddGroupPrices === null) {
			if ($this->isNew()) {
				$this->collAddGroupPrices = array();
			} else {

				$criteria->add(AddGroupPricePeer::CURRENCY_ID, $this->getId());

				$this->collAddGroupPrices = AddGroupPricePeer::doSelectJoinGroupPrice($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AddGroupPricePeer::CURRENCY_ID, $this->getId());

			if (!isset($this->lastAddGroupPriceCriteria) || !$this->lastAddGroupPriceCriteria->equals($criteria)) {
				$this->collAddGroupPrices = AddGroupPricePeer::doSelectJoinGroupPrice($criteria, $con);
			}
		}
		$this->lastAddGroupPriceCriteria = $criteria;

		return $this->collAddGroupPrices;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency is new, it will return
	 * an empty collection; or if this Currency has previously
	 * been saved, it will retrieve related AddGroupPrices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Currency.
	 */
	public function getAddGroupPricesJoinTax($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAddGroupPrices === null) {
			if ($this->isNew()) {
				$this->collAddGroupPrices = array();
			} else {

				$criteria->add(AddGroupPricePeer::CURRENCY_ID, $this->getId());

				$this->collAddGroupPrices = AddGroupPricePeer::doSelectJoinTax($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AddGroupPricePeer::CURRENCY_ID, $this->getId());

			if (!isset($this->lastAddGroupPriceCriteria) || !$this->lastAddGroupPriceCriteria->equals($criteria)) {
				$this->collAddGroupPrices = AddGroupPricePeer::doSelectJoinTax($criteria, $con);
			}
		}
		$this->lastAddGroupPriceCriteria = $criteria;

		return $this->collAddGroupPrices;
	}

	/**
	 * Temporary storage of collCurrencyI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initCurrencyI18ns()
	{
		if ($this->collCurrencyI18ns === null) {
			$this->collCurrencyI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency has previously
	 * been saved, it will retrieve related CurrencyI18ns from storage.
	 * If this Currency is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getCurrencyI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCurrencyI18ns === null) {
			if ($this->isNew()) {
			   $this->collCurrencyI18ns = array();
			} else {

				$criteria->add(CurrencyI18nPeer::ID, $this->getId());

				CurrencyI18nPeer::addSelectColumns($criteria);
				$this->collCurrencyI18ns = CurrencyI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(CurrencyI18nPeer::ID, $this->getId());

				CurrencyI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastCurrencyI18nCriteria) || !$this->lastCurrencyI18nCriteria->equals($criteria)) {
					$this->collCurrencyI18ns = CurrencyI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCurrencyI18nCriteria = $criteria;
		return $this->collCurrencyI18ns;
	}

	/**
	 * Returns the number of related CurrencyI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countCurrencyI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CurrencyI18nPeer::ID, $this->getId());

		return CurrencyI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a CurrencyI18n object to this object
	 * through the CurrencyI18n foreign key attribute
	 *
	 * @param      CurrencyI18n $l CurrencyI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addCurrencyI18n(CurrencyI18n $l)
	{
		$this->collCurrencyI18ns[] = $l;
		$l->setCurrency($this);
	}

	/**
	 * Temporary storage of collGiftCards to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initGiftCards()
	{
		if ($this->collGiftCards === null) {
			$this->collGiftCards = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency has previously
	 * been saved, it will retrieve related GiftCards from storage.
	 * If this Currency is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getGiftCards($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGiftCards === null) {
			if ($this->isNew()) {
			   $this->collGiftCards = array();
			} else {

				$criteria->add(GiftCardPeer::CURRENCY_ID, $this->getId());

				GiftCardPeer::addSelectColumns($criteria);
				$this->collGiftCards = GiftCardPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GiftCardPeer::CURRENCY_ID, $this->getId());

				GiftCardPeer::addSelectColumns($criteria);
				if (!isset($this->lastGiftCardCriteria) || !$this->lastGiftCardCriteria->equals($criteria)) {
					$this->collGiftCards = GiftCardPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGiftCardCriteria = $criteria;
		return $this->collGiftCards;
	}

	/**
	 * Returns the number of related GiftCards.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countGiftCards($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(GiftCardPeer::CURRENCY_ID, $this->getId());

		return GiftCardPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a GiftCard object to this object
	 * through the GiftCard foreign key attribute
	 *
	 * @param      GiftCard $l GiftCard
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGiftCard(GiftCard $l)
	{
		$this->collGiftCards[] = $l;
		$l->setCurrency($this);
	}

	/**
	 * Temporary storage of collGroupPrices to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initGroupPrices()
	{
		if ($this->collGroupPrices === null) {
			$this->collGroupPrices = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency has previously
	 * been saved, it will retrieve related GroupPrices from storage.
	 * If this Currency is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getGroupPrices($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGroupPrices === null) {
			if ($this->isNew()) {
			   $this->collGroupPrices = array();
			} else {

				$criteria->add(GroupPricePeer::CURRENCY_ID, $this->getId());

				GroupPricePeer::addSelectColumns($criteria);
				$this->collGroupPrices = GroupPricePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GroupPricePeer::CURRENCY_ID, $this->getId());

				GroupPricePeer::addSelectColumns($criteria);
				if (!isset($this->lastGroupPriceCriteria) || !$this->lastGroupPriceCriteria->equals($criteria)) {
					$this->collGroupPrices = GroupPricePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGroupPriceCriteria = $criteria;
		return $this->collGroupPrices;
	}

	/**
	 * Returns the number of related GroupPrices.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countGroupPrices($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(GroupPricePeer::CURRENCY_ID, $this->getId());

		return GroupPricePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a GroupPrice object to this object
	 * through the GroupPrice foreign key attribute
	 *
	 * @param      GroupPrice $l GroupPrice
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGroupPrice(GroupPrice $l)
	{
		$this->collGroupPrices[] = $l;
		$l->setCurrency($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency is new, it will return
	 * an empty collection; or if this Currency has previously
	 * been saved, it will retrieve related GroupPrices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Currency.
	 */
	public function getGroupPricesJoinTax($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGroupPrices === null) {
			if ($this->isNew()) {
				$this->collGroupPrices = array();
			} else {

				$criteria->add(GroupPricePeer::CURRENCY_ID, $this->getId());

				$this->collGroupPrices = GroupPricePeer::doSelectJoinTax($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(GroupPricePeer::CURRENCY_ID, $this->getId());

			if (!isset($this->lastGroupPriceCriteria) || !$this->lastGroupPriceCriteria->equals($criteria)) {
				$this->collGroupPrices = GroupPricePeer::doSelectJoinTax($criteria, $con);
			}
		}
		$this->lastGroupPriceCriteria = $criteria;

		return $this->collGroupPrices;
	}

	/**
	 * Temporary storage of collLanguages to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initLanguages()
	{
		if ($this->collLanguages === null) {
			$this->collLanguages = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Currency has previously
	 * been saved, it will retrieve related Languages from storage.
	 * If this Currency is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getLanguages($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLanguages === null) {
			if ($this->isNew()) {
			   $this->collLanguages = array();
			} else {

				$criteria->add(LanguagePeer::CURRENCY_ID, $this->getId());

				LanguagePeer::addSelectColumns($criteria);
				$this->collLanguages = LanguagePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(LanguagePeer::CURRENCY_ID, $this->getId());

				LanguagePeer::addSelectColumns($criteria);
				if (!isset($this->lastLanguageCriteria) || !$this->lastLanguageCriteria->equals($criteria)) {
					$this->collLanguages = LanguagePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastLanguageCriteria = $criteria;
		return $this->collLanguages;
	}

	/**
	 * Returns the number of related Languages.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countLanguages($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(LanguagePeer::CURRENCY_ID, $this->getId());

		return LanguagePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Language object to this object
	 * through the Language foreign key attribute
	 *
	 * @param      Language $l Language
	 * @return     void
	 * @throws     PropelException
	 */
	public function addLanguage(Language $l)
	{
		$this->collLanguages[] = $l;
		$l->setCurrency($this);
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
    $obj = $this->getCurrentCurrencyI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentCurrencyI18n()->setName($value);
  }

  public $current_i18n = array();

  public function getCurrentCurrencyI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = CurrencyI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setCurrencyI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setCurrencyI18nForCulture(new CurrencyI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setCurrencyI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addCurrencyI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Currency.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseCurrency:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseCurrency::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseCurrency
