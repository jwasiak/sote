<?php

/**
 * Base class that represents a row from the 'st_language' table.
 *
 * 
 *
 * @package    plugins.stLanguagePlugin.lib.model.om
 */
abstract class BaseLanguage extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        LanguagePeer
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
	 * The value for the currency_id field.
	 * @var        int
	 */
	protected $currency_id = 0;


	/**
	 * The value for the active_image field.
	 * @var        string
	 */
	protected $active_image;


	/**
	 * The value for the inactive_image field.
	 * @var        string
	 */
	protected $inactive_image;


	/**
	 * The value for the shortcut field.
	 * @var        string
	 */
	protected $shortcut;


	/**
	 * The value for the is_default field.
	 * @var        boolean
	 */
	protected $is_default = false;


	/**
	 * The value for the active field.
	 * @var        boolean
	 */
	protected $active = true;


	/**
	 * The value for the language field.
	 * @var        string
	 */
	protected $language;


	/**
	 * The value for the is_translate field.
	 * @var        boolean
	 */
	protected $is_translate = false;


	/**
	 * The value for the system field.
	 * @var        boolean
	 */
	protected $system = false;


	/**
	 * The value for the is_default_panel field.
	 * @var        boolean
	 */
	protected $is_default_panel;


	/**
	 * The value for the is_translate_panel field.
	 * @var        boolean
	 */
	protected $is_translate_panel;


	/**
	 * The value for the opt_name field.
	 * @var        string
	 */
	protected $opt_name;

	/**
	 * @var        Currency
	 */
	protected $aCurrency;

	/**
	 * Collection to store aggregation of collProductHasAttachments.
	 * @var        array
	 */
	protected $collProductHasAttachments;

	/**
	 * The criteria used to select the current contents of collProductHasAttachments.
	 * @var        Criteria
	 */
	protected $lastProductHasAttachmentCriteria = null;

	/**
	 * Collection to store aggregation of collSlideBanners.
	 * @var        array
	 */
	protected $collSlideBanners;

	/**
	 * The criteria used to select the current contents of collSlideBanners.
	 * @var        Criteria
	 */
	protected $lastSlideBannerCriteria = null;

	/**
	 * Collection to store aggregation of collLanguageHasDomains.
	 * @var        array
	 */
	protected $collLanguageHasDomains;

	/**
	 * The criteria used to select the current contents of collLanguageHasDomains.
	 * @var        Criteria
	 */
	protected $lastLanguageHasDomainCriteria = null;

	/**
	 * Collection to store aggregation of collTranslationCaches.
	 * @var        array
	 */
	protected $collTranslationCaches;

	/**
	 * The criteria used to select the current contents of collTranslationCaches.
	 * @var        Criteria
	 */
	protected $lastTranslationCacheCriteria = null;

	/**
	 * Collection to store aggregation of collLanguageI18ns.
	 * @var        array
	 */
	protected $collLanguageI18ns;

	/**
	 * The criteria used to select the current contents of collLanguageI18ns.
	 * @var        Criteria
	 */
	protected $lastLanguageI18nCriteria = null;

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
     * Get the [currency_id] column value.
     * 
     * @return     int
     */
    public function getCurrencyId()
    {

            return $this->currency_id;
    }

    /**
     * Get the [active_image] column value.
     * 
     * @return     string
     */
    public function getActiveImage()
    {

            return $this->active_image;
    }

    /**
     * Get the [inactive_image] column value.
     * 
     * @return     string
     */
    public function getInactiveImage()
    {

            return $this->inactive_image;
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
     * Get the [is_default] column value.
     * 
     * @return     boolean
     */
    public function getIsDefault()
    {

            return $this->is_default;
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
     * Get the [language] column value.
     * 
     * @return     string
     */
    public function getLanguage()
    {

            return $this->language;
    }

    /**
     * Get the [is_translate] column value.
     * 
     * @return     boolean
     */
    public function getIsTranslate()
    {

            return $this->is_translate;
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
     * Get the [is_default_panel] column value.
     * 
     * @return     boolean
     */
    public function getIsDefaultPanel()
    {

            return $this->is_default_panel;
    }

    /**
     * Get the [is_translate_panel] column value.
     * 
     * @return     boolean
     */
    public function getIsTranslatePanel()
    {

            return $this->is_translate_panel;
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
			$this->modifiedColumns[] = LanguagePeer::CREATED_AT;
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
			$this->modifiedColumns[] = LanguagePeer::UPDATED_AT;
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
          $this->modifiedColumns[] = LanguagePeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [currency_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCurrencyId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->currency_id !== $v || $v === 0) {
          $this->currency_id = $v;
          $this->modifiedColumns[] = LanguagePeer::CURRENCY_ID;
        }

		if ($this->aCurrency !== null && $this->aCurrency->getId() !== $v) {
			$this->aCurrency = null;
		}

	} // setCurrencyId()

	/**
	 * Set the value of [active_image] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setActiveImage($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->active_image !== $v) {
          $this->active_image = $v;
          $this->modifiedColumns[] = LanguagePeer::ACTIVE_IMAGE;
        }

	} // setActiveImage()

	/**
	 * Set the value of [inactive_image] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setInactiveImage($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->inactive_image !== $v) {
          $this->inactive_image = $v;
          $this->modifiedColumns[] = LanguagePeer::INACTIVE_IMAGE;
        }

	} // setInactiveImage()

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
          $this->modifiedColumns[] = LanguagePeer::SHORTCUT;
        }

	} // setShortcut()

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
          $this->modifiedColumns[] = LanguagePeer::IS_DEFAULT;
        }

	} // setIsDefault()

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

        if ($this->active !== $v || $v === true) {
          $this->active = $v;
          $this->modifiedColumns[] = LanguagePeer::ACTIVE;
        }

	} // setActive()

	/**
	 * Set the value of [language] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setLanguage($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->language !== $v) {
          $this->language = $v;
          $this->modifiedColumns[] = LanguagePeer::LANGUAGE;
        }

	} // setLanguage()

	/**
	 * Set the value of [is_translate] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsTranslate($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_translate !== $v || $v === false) {
          $this->is_translate = $v;
          $this->modifiedColumns[] = LanguagePeer::IS_TRANSLATE;
        }

	} // setIsTranslate()

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

        if ($this->system !== $v || $v === false) {
          $this->system = $v;
          $this->modifiedColumns[] = LanguagePeer::SYSTEM;
        }

	} // setSystem()

	/**
	 * Set the value of [is_default_panel] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsDefaultPanel($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_default_panel !== $v) {
          $this->is_default_panel = $v;
          $this->modifiedColumns[] = LanguagePeer::IS_DEFAULT_PANEL;
        }

	} // setIsDefaultPanel()

	/**
	 * Set the value of [is_translate_panel] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsTranslatePanel($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_translate_panel !== $v) {
          $this->is_translate_panel = $v;
          $this->modifiedColumns[] = LanguagePeer::IS_TRANSLATE_PANEL;
        }

	} // setIsTranslatePanel()

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
          $this->modifiedColumns[] = LanguagePeer::OPT_NAME;
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
      if ($this->getDispatcher()->getListeners('Language.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Language.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->currency_id = $rs->getInt($startcol + 3);

      $this->active_image = $rs->getString($startcol + 4);

      $this->inactive_image = $rs->getString($startcol + 5);

      $this->shortcut = $rs->getString($startcol + 6);

      $this->is_default = $rs->getBoolean($startcol + 7);

      $this->active = $rs->getBoolean($startcol + 8);

      $this->language = $rs->getString($startcol + 9);

      $this->is_translate = $rs->getBoolean($startcol + 10);

      $this->system = $rs->getBoolean($startcol + 11);

      $this->is_default_panel = $rs->getBoolean($startcol + 12);

      $this->is_translate_panel = $rs->getBoolean($startcol + 13);

      $this->opt_name = $rs->getString($startcol + 14);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Language.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Language.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 15)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 15; // 15 = LanguagePeer::NUM_COLUMNS - LanguagePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Language object", $e);
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

    if ($this->getDispatcher()->getListeners('Language.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Language.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseLanguage:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseLanguage:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(LanguagePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      LanguagePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Language.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Language.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseLanguage:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseLanguage:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Language.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Language.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseLanguage:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(LanguagePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(LanguagePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(LanguagePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Language.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Language.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseLanguage:save:post') as $callable)
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

			if ($this->aCurrency !== null) {
				if ($this->aCurrency->isModified() || $this->aCurrency->getCurrentCurrencyI18n()->isModified()) {
					$affectedRows += $this->aCurrency->save($con);
				}
				$this->setCurrency($this->aCurrency);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = LanguagePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += LanguagePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collProductHasAttachments !== null) {
				foreach($this->collProductHasAttachments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collSlideBanners !== null) {
				foreach($this->collSlideBanners as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLanguageHasDomains !== null) {
				foreach($this->collLanguageHasDomains as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTranslationCaches !== null) {
				foreach($this->collTranslationCaches as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLanguageI18ns !== null) {
				foreach($this->collLanguageI18ns as $referrerFK) {
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

			if ($this->aCurrency !== null) {
				if (!$this->aCurrency->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCurrency->getValidationFailures());
				}
			}


			if (($retval = LanguagePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collProductHasAttachments !== null) {
					foreach($this->collProductHasAttachments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collSlideBanners !== null) {
					foreach($this->collSlideBanners as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLanguageHasDomains !== null) {
					foreach($this->collLanguageHasDomains as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTranslationCaches !== null) {
					foreach($this->collTranslationCaches as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLanguageI18ns !== null) {
					foreach($this->collLanguageI18ns as $referrerFK) {
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
		$pos = LanguagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCurrencyId();
				break;
			case 4:
				return $this->getActiveImage();
				break;
			case 5:
				return $this->getInactiveImage();
				break;
			case 6:
				return $this->getShortcut();
				break;
			case 7:
				return $this->getIsDefault();
				break;
			case 8:
				return $this->getActive();
				break;
			case 9:
				return $this->getLanguage();
				break;
			case 10:
				return $this->getIsTranslate();
				break;
			case 11:
				return $this->getSystem();
				break;
			case 12:
				return $this->getIsDefaultPanel();
				break;
			case 13:
				return $this->getIsTranslatePanel();
				break;
			case 14:
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
		$keys = LanguagePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getCurrencyId(),
			$keys[4] => $this->getActiveImage(),
			$keys[5] => $this->getInactiveImage(),
			$keys[6] => $this->getShortcut(),
			$keys[7] => $this->getIsDefault(),
			$keys[8] => $this->getActive(),
			$keys[9] => $this->getLanguage(),
			$keys[10] => $this->getIsTranslate(),
			$keys[11] => $this->getSystem(),
			$keys[12] => $this->getIsDefaultPanel(),
			$keys[13] => $this->getIsTranslatePanel(),
			$keys[14] => $this->getOptName(),
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
		$pos = LanguagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setCurrencyId($value);
				break;
			case 4:
				$this->setActiveImage($value);
				break;
			case 5:
				$this->setInactiveImage($value);
				break;
			case 6:
				$this->setShortcut($value);
				break;
			case 7:
				$this->setIsDefault($value);
				break;
			case 8:
				$this->setActive($value);
				break;
			case 9:
				$this->setLanguage($value);
				break;
			case 10:
				$this->setIsTranslate($value);
				break;
			case 11:
				$this->setSystem($value);
				break;
			case 12:
				$this->setIsDefaultPanel($value);
				break;
			case 13:
				$this->setIsTranslatePanel($value);
				break;
			case 14:
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
		$keys = LanguagePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCurrencyId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setActiveImage($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setInactiveImage($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setShortcut($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsDefault($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setActive($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setLanguage($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setIsTranslate($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setSystem($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setIsDefaultPanel($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setIsTranslatePanel($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setOptName($arr[$keys[14]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(LanguagePeer::DATABASE_NAME);

		if ($this->isColumnModified(LanguagePeer::CREATED_AT)) $criteria->add(LanguagePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(LanguagePeer::UPDATED_AT)) $criteria->add(LanguagePeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(LanguagePeer::ID)) $criteria->add(LanguagePeer::ID, $this->id);
		if ($this->isColumnModified(LanguagePeer::CURRENCY_ID)) $criteria->add(LanguagePeer::CURRENCY_ID, $this->currency_id);
		if ($this->isColumnModified(LanguagePeer::ACTIVE_IMAGE)) $criteria->add(LanguagePeer::ACTIVE_IMAGE, $this->active_image);
		if ($this->isColumnModified(LanguagePeer::INACTIVE_IMAGE)) $criteria->add(LanguagePeer::INACTIVE_IMAGE, $this->inactive_image);
		if ($this->isColumnModified(LanguagePeer::SHORTCUT)) $criteria->add(LanguagePeer::SHORTCUT, $this->shortcut);
		if ($this->isColumnModified(LanguagePeer::IS_DEFAULT)) $criteria->add(LanguagePeer::IS_DEFAULT, $this->is_default);
		if ($this->isColumnModified(LanguagePeer::ACTIVE)) $criteria->add(LanguagePeer::ACTIVE, $this->active);
		if ($this->isColumnModified(LanguagePeer::LANGUAGE)) $criteria->add(LanguagePeer::LANGUAGE, $this->language);
		if ($this->isColumnModified(LanguagePeer::IS_TRANSLATE)) $criteria->add(LanguagePeer::IS_TRANSLATE, $this->is_translate);
		if ($this->isColumnModified(LanguagePeer::SYSTEM)) $criteria->add(LanguagePeer::SYSTEM, $this->system);
		if ($this->isColumnModified(LanguagePeer::IS_DEFAULT_PANEL)) $criteria->add(LanguagePeer::IS_DEFAULT_PANEL, $this->is_default_panel);
		if ($this->isColumnModified(LanguagePeer::IS_TRANSLATE_PANEL)) $criteria->add(LanguagePeer::IS_TRANSLATE_PANEL, $this->is_translate_panel);
		if ($this->isColumnModified(LanguagePeer::OPT_NAME)) $criteria->add(LanguagePeer::OPT_NAME, $this->opt_name);

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
		$criteria = new Criteria(LanguagePeer::DATABASE_NAME);

		$criteria->add(LanguagePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Language (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setCurrencyId($this->currency_id);

		$copyObj->setActiveImage($this->active_image);

		$copyObj->setInactiveImage($this->inactive_image);

		$copyObj->setShortcut($this->shortcut);

		$copyObj->setIsDefault($this->is_default);

		$copyObj->setActive($this->active);

		$copyObj->setLanguage($this->language);

		$copyObj->setIsTranslate($this->is_translate);

		$copyObj->setSystem($this->system);

		$copyObj->setIsDefaultPanel($this->is_default_panel);

		$copyObj->setIsTranslatePanel($this->is_translate_panel);

		$copyObj->setOptName($this->opt_name);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getProductHasAttachments() as $relObj) {
				$copyObj->addProductHasAttachment($relObj->copy($deepCopy));
			}

			foreach($this->getSlideBanners() as $relObj) {
				$copyObj->addSlideBanner($relObj->copy($deepCopy));
			}

			foreach($this->getLanguageHasDomains() as $relObj) {
				$copyObj->addLanguageHasDomain($relObj->copy($deepCopy));
			}

			foreach($this->getTranslationCaches() as $relObj) {
				$copyObj->addTranslationCache($relObj->copy($deepCopy));
			}

			foreach($this->getLanguageI18ns() as $relObj) {
				$copyObj->addLanguageI18n($relObj->copy($deepCopy));
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
	 * @return     Language Clone of current object.
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
	 * @return     LanguagePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new LanguagePeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Currency object.
	 *
	 * @param      Currency $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setCurrency($v)
	{


		if ($v === null) {
			$this->setCurrencyId('0');
		} else {
			$this->setCurrencyId($v->getId());
		}


		$this->aCurrency = $v;
	}


	/**
	 * Get the associated Currency object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Currency The associated Currency object.
	 * @throws     PropelException
	 */
	public function getCurrency($con = null)
	{
		if ($this->aCurrency === null && ($this->currency_id !== null)) {
			// include the related Peer class
			$this->aCurrency = CurrencyPeer::retrieveByPK($this->currency_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = CurrencyPeer::retrieveByPK($this->currency_id, $con);
			   $obj->addCurrencys($this);
			 */
		}
		return $this->aCurrency;
	}

	/**
	 * Temporary storage of collProductHasAttachments to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductHasAttachments()
	{
		if ($this->collProductHasAttachments === null) {
			$this->collProductHasAttachments = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language has previously
	 * been saved, it will retrieve related ProductHasAttachments from storage.
	 * If this Language is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductHasAttachments($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasAttachments === null) {
			if ($this->isNew()) {
			   $this->collProductHasAttachments = array();
			} else {

				$criteria->add(ProductHasAttachmentPeer::LANGUAGE_ID, $this->getId());

				ProductHasAttachmentPeer::addSelectColumns($criteria);
				$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasAttachmentPeer::LANGUAGE_ID, $this->getId());

				ProductHasAttachmentPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductHasAttachmentCriteria) || !$this->lastProductHasAttachmentCriteria->equals($criteria)) {
					$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductHasAttachmentCriteria = $criteria;
		return $this->collProductHasAttachments;
	}

	/**
	 * Returns the number of related ProductHasAttachments.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductHasAttachments($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductHasAttachmentPeer::LANGUAGE_ID, $this->getId());

		return ProductHasAttachmentPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductHasAttachment object to this object
	 * through the ProductHasAttachment foreign key attribute
	 *
	 * @param      ProductHasAttachment $l ProductHasAttachment
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductHasAttachment(ProductHasAttachment $l)
	{
		$this->collProductHasAttachments[] = $l;
		$l->setLanguage($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related ProductHasAttachments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getProductHasAttachmentsJoinsfAsset($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasAttachments === null) {
			if ($this->isNew()) {
				$this->collProductHasAttachments = array();
			} else {

				$criteria->add(ProductHasAttachmentPeer::LANGUAGE_ID, $this->getId());

				$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelectJoinsfAsset($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductHasAttachmentPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastProductHasAttachmentCriteria) || !$this->lastProductHasAttachmentCriteria->equals($criteria)) {
				$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelectJoinsfAsset($criteria, $con);
			}
		}
		$this->lastProductHasAttachmentCriteria = $criteria;

		return $this->collProductHasAttachments;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related ProductHasAttachments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getProductHasAttachmentsJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasAttachments === null) {
			if ($this->isNew()) {
				$this->collProductHasAttachments = array();
			} else {

				$criteria->add(ProductHasAttachmentPeer::LANGUAGE_ID, $this->getId());

				$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductHasAttachmentPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastProductHasAttachmentCriteria) || !$this->lastProductHasAttachmentCriteria->equals($criteria)) {
				$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastProductHasAttachmentCriteria = $criteria;

		return $this->collProductHasAttachments;
	}

	/**
	 * Temporary storage of collSlideBanners to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initSlideBanners()
	{
		if ($this->collSlideBanners === null) {
			$this->collSlideBanners = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language has previously
	 * been saved, it will retrieve related SlideBanners from storage.
	 * If this Language is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getSlideBanners($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSlideBanners === null) {
			if ($this->isNew()) {
			   $this->collSlideBanners = array();
			} else {

				$criteria->add(SlideBannerPeer::LANGUAGE_ID, $this->getId());

				SlideBannerPeer::addSelectColumns($criteria);
				$this->collSlideBanners = SlideBannerPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(SlideBannerPeer::LANGUAGE_ID, $this->getId());

				SlideBannerPeer::addSelectColumns($criteria);
				if (!isset($this->lastSlideBannerCriteria) || !$this->lastSlideBannerCriteria->equals($criteria)) {
					$this->collSlideBanners = SlideBannerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSlideBannerCriteria = $criteria;
		return $this->collSlideBanners;
	}

	/**
	 * Returns the number of related SlideBanners.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countSlideBanners($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(SlideBannerPeer::LANGUAGE_ID, $this->getId());

		return SlideBannerPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a SlideBanner object to this object
	 * through the SlideBanner foreign key attribute
	 *
	 * @param      SlideBanner $l SlideBanner
	 * @return     void
	 * @throws     PropelException
	 */
	public function addSlideBanner(SlideBanner $l)
	{
		$this->collSlideBanners[] = $l;
		$l->setLanguage($this);
	}

	/**
	 * Temporary storage of collLanguageHasDomains to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initLanguageHasDomains()
	{
		if ($this->collLanguageHasDomains === null) {
			$this->collLanguageHasDomains = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language has previously
	 * been saved, it will retrieve related LanguageHasDomains from storage.
	 * If this Language is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getLanguageHasDomains($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLanguageHasDomains === null) {
			if ($this->isNew()) {
			   $this->collLanguageHasDomains = array();
			} else {

				$criteria->add(LanguageHasDomainPeer::LANGUAGE_ID, $this->getId());

				LanguageHasDomainPeer::addSelectColumns($criteria);
				$this->collLanguageHasDomains = LanguageHasDomainPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(LanguageHasDomainPeer::LANGUAGE_ID, $this->getId());

				LanguageHasDomainPeer::addSelectColumns($criteria);
				if (!isset($this->lastLanguageHasDomainCriteria) || !$this->lastLanguageHasDomainCriteria->equals($criteria)) {
					$this->collLanguageHasDomains = LanguageHasDomainPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastLanguageHasDomainCriteria = $criteria;
		return $this->collLanguageHasDomains;
	}

	/**
	 * Returns the number of related LanguageHasDomains.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countLanguageHasDomains($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(LanguageHasDomainPeer::LANGUAGE_ID, $this->getId());

		return LanguageHasDomainPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a LanguageHasDomain object to this object
	 * through the LanguageHasDomain foreign key attribute
	 *
	 * @param      LanguageHasDomain $l LanguageHasDomain
	 * @return     void
	 * @throws     PropelException
	 */
	public function addLanguageHasDomain(LanguageHasDomain $l)
	{
		$this->collLanguageHasDomains[] = $l;
		$l->setLanguage($this);
	}

	/**
	 * Temporary storage of collTranslationCaches to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initTranslationCaches()
	{
		if ($this->collTranslationCaches === null) {
			$this->collTranslationCaches = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language has previously
	 * been saved, it will retrieve related TranslationCaches from storage.
	 * If this Language is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getTranslationCaches($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTranslationCaches === null) {
			if ($this->isNew()) {
			   $this->collTranslationCaches = array();
			} else {

				$criteria->add(TranslationCachePeer::LANGUAGE_ID, $this->getId());

				TranslationCachePeer::addSelectColumns($criteria);
				$this->collTranslationCaches = TranslationCachePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(TranslationCachePeer::LANGUAGE_ID, $this->getId());

				TranslationCachePeer::addSelectColumns($criteria);
				if (!isset($this->lastTranslationCacheCriteria) || !$this->lastTranslationCacheCriteria->equals($criteria)) {
					$this->collTranslationCaches = TranslationCachePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTranslationCacheCriteria = $criteria;
		return $this->collTranslationCaches;
	}

	/**
	 * Returns the number of related TranslationCaches.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countTranslationCaches($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TranslationCachePeer::LANGUAGE_ID, $this->getId());

		return TranslationCachePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a TranslationCache object to this object
	 * through the TranslationCache foreign key attribute
	 *
	 * @param      TranslationCache $l TranslationCache
	 * @return     void
	 * @throws     PropelException
	 */
	public function addTranslationCache(TranslationCache $l)
	{
		$this->collTranslationCaches[] = $l;
		$l->setLanguage($this);
	}

	/**
	 * Temporary storage of collLanguageI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initLanguageI18ns()
	{
		if ($this->collLanguageI18ns === null) {
			$this->collLanguageI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language has previously
	 * been saved, it will retrieve related LanguageI18ns from storage.
	 * If this Language is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getLanguageI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLanguageI18ns === null) {
			if ($this->isNew()) {
			   $this->collLanguageI18ns = array();
			} else {

				$criteria->add(LanguageI18nPeer::ID, $this->getId());

				LanguageI18nPeer::addSelectColumns($criteria);
				$this->collLanguageI18ns = LanguageI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(LanguageI18nPeer::ID, $this->getId());

				LanguageI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastLanguageI18nCriteria) || !$this->lastLanguageI18nCriteria->equals($criteria)) {
					$this->collLanguageI18ns = LanguageI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastLanguageI18nCriteria = $criteria;
		return $this->collLanguageI18ns;
	}

	/**
	 * Returns the number of related LanguageI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countLanguageI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(LanguageI18nPeer::ID, $this->getId());

		return LanguageI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a LanguageI18n object to this object
	 * through the LanguageI18n foreign key attribute
	 *
	 * @param      LanguageI18n $l LanguageI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addLanguageI18n(LanguageI18n $l)
	{
		$this->collLanguageI18ns[] = $l;
		$l->setLanguage($this);
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
    $obj = $this->getCurrentLanguageI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentLanguageI18n()->setName($value);
  }

  public $current_i18n = array();

  public function getCurrentLanguageI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = LanguageI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setLanguageI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setLanguageI18nForCulture(new LanguageI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setLanguageI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addLanguageI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Language.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseLanguage:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseLanguage::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseLanguage
