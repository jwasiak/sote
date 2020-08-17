<?php

/**
 * Base class that represents a row from the 'st_positioning' table.
 *
 * 
 *
 * @package    plugins.stPositioningPlugin.lib.model.om
 */
abstract class BasePositioning extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PositioningPeer
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
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the system_name field.
	 * @var        string
	 */
	protected $system_name;


	/**
	 * The value for the opt_title field.
	 * @var        string
	 */
	protected $opt_title;


	/**
	 * The value for the opt_keywords field.
	 * @var        string
	 */
	protected $opt_keywords;


	/**
	 * The value for the opt_description field.
	 * @var        string
	 */
	protected $opt_description;


	/**
	 * The value for the opt_type field.
	 * @var        int
	 */
	protected $opt_type;


	/**
	 * The value for the opt_default_title field.
	 * @var        string
	 */
	protected $opt_default_title;


	/**
	 * The value for the opt_title_product field.
	 * @var        string
	 */
	protected $opt_title_product;


	/**
	 * The value for the opt_title_category field.
	 * @var        string
	 */
	protected $opt_title_category;


	/**
	 * The value for the opt_title_manufacteur field.
	 * @var        string
	 */
	protected $opt_title_manufacteur;


	/**
	 * The value for the opt_title_blog field.
	 * @var        string
	 */
	protected $opt_title_blog;


	/**
	 * The value for the opt_title_product_group field.
	 * @var        string
	 */
	protected $opt_title_product_group;


	/**
	 * The value for the opt_title_webpage field.
	 * @var        string
	 */
	protected $opt_title_webpage;

	/**
	 * Collection to store aggregation of collPositioningI18ns.
	 * @var        array
	 */
	protected $collPositioningI18ns;

	/**
	 * The criteria used to select the current contents of collPositioningI18ns.
	 * @var        Criteria
	 */
	protected $lastPositioningI18nCriteria = null;

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
     * Get the [name] column value.
     * 
     * @return     string
     */
    public function getName()
    {

            return $this->name;
    }

    /**
     * Get the [system_name] column value.
     * 
     * @return     string
     */
    public function getSystemName()
    {

            return $this->system_name;
    }

    /**
     * Get the [opt_title] column value.
     * 
     * @return     string
     */
    public function getOptTitle()
    {

            return $this->opt_title;
    }

    /**
     * Get the [opt_keywords] column value.
     * 
     * @return     string
     */
    public function getOptKeywords()
    {

            return $this->opt_keywords;
    }

    /**
     * Get the [opt_description] column value.
     * 
     * @return     string
     */
    public function getOptDescription()
    {

            return $this->opt_description;
    }

    /**
     * Get the [opt_type] column value.
     * 
     * @return     int
     */
    public function getOptType()
    {

            return $this->opt_type;
    }

    /**
     * Get the [opt_default_title] column value.
     * 
     * @return     string
     */
    public function getOptDefaultTitle()
    {

            return $this->opt_default_title;
    }

    /**
     * Get the [opt_title_product] column value.
     * 
     * @return     string
     */
    public function getOptTitleProduct()
    {

            return $this->opt_title_product;
    }

    /**
     * Get the [opt_title_category] column value.
     * 
     * @return     string
     */
    public function getOptTitleCategory()
    {

            return $this->opt_title_category;
    }

    /**
     * Get the [opt_title_manufacteur] column value.
     * 
     * @return     string
     */
    public function getOptTitleManufacteur()
    {

            return $this->opt_title_manufacteur;
    }

    /**
     * Get the [opt_title_blog] column value.
     * 
     * @return     string
     */
    public function getOptTitleBlog()
    {

            return $this->opt_title_blog;
    }

    /**
     * Get the [opt_title_product_group] column value.
     * 
     * @return     string
     */
    public function getOptTitleProductGroup()
    {

            return $this->opt_title_product_group;
    }

    /**
     * Get the [opt_title_webpage] column value.
     * 
     * @return     string
     */
    public function getOptTitleWebpage()
    {

            return $this->opt_title_webpage;
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
			$this->modifiedColumns[] = PositioningPeer::CREATED_AT;
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
			$this->modifiedColumns[] = PositioningPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = PositioningPeer::ID;
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
          $this->modifiedColumns[] = PositioningPeer::NAME;
        }

	} // setName()

	/**
	 * Set the value of [system_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setSystemName($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->system_name !== $v) {
          $this->system_name = $v;
          $this->modifiedColumns[] = PositioningPeer::SYSTEM_NAME;
        }

	} // setSystemName()

	/**
	 * Set the value of [opt_title] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptTitle($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_title !== $v) {
          $this->opt_title = $v;
          $this->modifiedColumns[] = PositioningPeer::OPT_TITLE;
        }

	} // setOptTitle()

	/**
	 * Set the value of [opt_keywords] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptKeywords($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_keywords !== $v) {
          $this->opt_keywords = $v;
          $this->modifiedColumns[] = PositioningPeer::OPT_KEYWORDS;
        }

	} // setOptKeywords()

	/**
	 * Set the value of [opt_description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_description !== $v) {
          $this->opt_description = $v;
          $this->modifiedColumns[] = PositioningPeer::OPT_DESCRIPTION;
        }

	} // setOptDescription()

	/**
	 * Set the value of [opt_type] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOptType($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->opt_type !== $v) {
          $this->opt_type = $v;
          $this->modifiedColumns[] = PositioningPeer::OPT_TYPE;
        }

	} // setOptType()

	/**
	 * Set the value of [opt_default_title] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptDefaultTitle($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_default_title !== $v) {
          $this->opt_default_title = $v;
          $this->modifiedColumns[] = PositioningPeer::OPT_DEFAULT_TITLE;
        }

	} // setOptDefaultTitle()

	/**
	 * Set the value of [opt_title_product] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptTitleProduct($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_title_product !== $v) {
          $this->opt_title_product = $v;
          $this->modifiedColumns[] = PositioningPeer::OPT_TITLE_PRODUCT;
        }

	} // setOptTitleProduct()

	/**
	 * Set the value of [opt_title_category] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptTitleCategory($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_title_category !== $v) {
          $this->opt_title_category = $v;
          $this->modifiedColumns[] = PositioningPeer::OPT_TITLE_CATEGORY;
        }

	} // setOptTitleCategory()

	/**
	 * Set the value of [opt_title_manufacteur] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptTitleManufacteur($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_title_manufacteur !== $v) {
          $this->opt_title_manufacteur = $v;
          $this->modifiedColumns[] = PositioningPeer::OPT_TITLE_MANUFACTEUR;
        }

	} // setOptTitleManufacteur()

	/**
	 * Set the value of [opt_title_blog] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptTitleBlog($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_title_blog !== $v) {
          $this->opt_title_blog = $v;
          $this->modifiedColumns[] = PositioningPeer::OPT_TITLE_BLOG;
        }

	} // setOptTitleBlog()

	/**
	 * Set the value of [opt_title_product_group] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptTitleProductGroup($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_title_product_group !== $v) {
          $this->opt_title_product_group = $v;
          $this->modifiedColumns[] = PositioningPeer::OPT_TITLE_PRODUCT_GROUP;
        }

	} // setOptTitleProductGroup()

	/**
	 * Set the value of [opt_title_webpage] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptTitleWebpage($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_title_webpage !== $v) {
          $this->opt_title_webpage = $v;
          $this->modifiedColumns[] = PositioningPeer::OPT_TITLE_WEBPAGE;
        }

	} // setOptTitleWebpage()

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
      if ($this->getDispatcher()->getListeners('Positioning.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Positioning.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->name = $rs->getString($startcol + 3);

      $this->system_name = $rs->getString($startcol + 4);

      $this->opt_title = $rs->getString($startcol + 5);

      $this->opt_keywords = $rs->getString($startcol + 6);

      $this->opt_description = $rs->getString($startcol + 7);

      $this->opt_type = $rs->getInt($startcol + 8);

      $this->opt_default_title = $rs->getString($startcol + 9);

      $this->opt_title_product = $rs->getString($startcol + 10);

      $this->opt_title_category = $rs->getString($startcol + 11);

      $this->opt_title_manufacteur = $rs->getString($startcol + 12);

      $this->opt_title_blog = $rs->getString($startcol + 13);

      $this->opt_title_product_group = $rs->getString($startcol + 14);

      $this->opt_title_webpage = $rs->getString($startcol + 15);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Positioning.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Positioning.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 16)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 16; // 16 = PositioningPeer::NUM_COLUMNS - PositioningPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Positioning object", $e);
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

    if ($this->getDispatcher()->getListeners('Positioning.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Positioning.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePositioning:delete:pre'))
    {
      foreach (sfMixer::getCallables('BasePositioning:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(PositioningPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      PositioningPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Positioning.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Positioning.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePositioning:delete:post'))
    {
      foreach (sfMixer::getCallables('BasePositioning:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Positioning.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Positioning.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BasePositioning:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(PositioningPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(PositioningPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(PositioningPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Positioning.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Positioning.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BasePositioning:save:post') as $callable)
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
					$pk = PositioningPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PositioningPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPositioningI18ns !== null) {
				foreach($this->collPositioningI18ns as $referrerFK) {
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


			if (($retval = PositioningPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPositioningI18ns !== null) {
					foreach($this->collPositioningI18ns as $referrerFK) {
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
		$pos = PositioningPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getName();
				break;
			case 4:
				return $this->getSystemName();
				break;
			case 5:
				return $this->getOptTitle();
				break;
			case 6:
				return $this->getOptKeywords();
				break;
			case 7:
				return $this->getOptDescription();
				break;
			case 8:
				return $this->getOptType();
				break;
			case 9:
				return $this->getOptDefaultTitle();
				break;
			case 10:
				return $this->getOptTitleProduct();
				break;
			case 11:
				return $this->getOptTitleCategory();
				break;
			case 12:
				return $this->getOptTitleManufacteur();
				break;
			case 13:
				return $this->getOptTitleBlog();
				break;
			case 14:
				return $this->getOptTitleProductGroup();
				break;
			case 15:
				return $this->getOptTitleWebpage();
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
		$keys = PositioningPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getName(),
			$keys[4] => $this->getSystemName(),
			$keys[5] => $this->getOptTitle(),
			$keys[6] => $this->getOptKeywords(),
			$keys[7] => $this->getOptDescription(),
			$keys[8] => $this->getOptType(),
			$keys[9] => $this->getOptDefaultTitle(),
			$keys[10] => $this->getOptTitleProduct(),
			$keys[11] => $this->getOptTitleCategory(),
			$keys[12] => $this->getOptTitleManufacteur(),
			$keys[13] => $this->getOptTitleBlog(),
			$keys[14] => $this->getOptTitleProductGroup(),
			$keys[15] => $this->getOptTitleWebpage(),
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
		$pos = PositioningPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setName($value);
				break;
			case 4:
				$this->setSystemName($value);
				break;
			case 5:
				$this->setOptTitle($value);
				break;
			case 6:
				$this->setOptKeywords($value);
				break;
			case 7:
				$this->setOptDescription($value);
				break;
			case 8:
				$this->setOptType($value);
				break;
			case 9:
				$this->setOptDefaultTitle($value);
				break;
			case 10:
				$this->setOptTitleProduct($value);
				break;
			case 11:
				$this->setOptTitleCategory($value);
				break;
			case 12:
				$this->setOptTitleManufacteur($value);
				break;
			case 13:
				$this->setOptTitleBlog($value);
				break;
			case 14:
				$this->setOptTitleProductGroup($value);
				break;
			case 15:
				$this->setOptTitleWebpage($value);
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
		$keys = PositioningPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSystemName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOptTitle($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setOptKeywords($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setOptDescription($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setOptType($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setOptDefaultTitle($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setOptTitleProduct($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setOptTitleCategory($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setOptTitleManufacteur($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setOptTitleBlog($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setOptTitleProductGroup($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setOptTitleWebpage($arr[$keys[15]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PositioningPeer::DATABASE_NAME);

		if ($this->isColumnModified(PositioningPeer::CREATED_AT)) $criteria->add(PositioningPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(PositioningPeer::UPDATED_AT)) $criteria->add(PositioningPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(PositioningPeer::ID)) $criteria->add(PositioningPeer::ID, $this->id);
		if ($this->isColumnModified(PositioningPeer::NAME)) $criteria->add(PositioningPeer::NAME, $this->name);
		if ($this->isColumnModified(PositioningPeer::SYSTEM_NAME)) $criteria->add(PositioningPeer::SYSTEM_NAME, $this->system_name);
		if ($this->isColumnModified(PositioningPeer::OPT_TITLE)) $criteria->add(PositioningPeer::OPT_TITLE, $this->opt_title);
		if ($this->isColumnModified(PositioningPeer::OPT_KEYWORDS)) $criteria->add(PositioningPeer::OPT_KEYWORDS, $this->opt_keywords);
		if ($this->isColumnModified(PositioningPeer::OPT_DESCRIPTION)) $criteria->add(PositioningPeer::OPT_DESCRIPTION, $this->opt_description);
		if ($this->isColumnModified(PositioningPeer::OPT_TYPE)) $criteria->add(PositioningPeer::OPT_TYPE, $this->opt_type);
		if ($this->isColumnModified(PositioningPeer::OPT_DEFAULT_TITLE)) $criteria->add(PositioningPeer::OPT_DEFAULT_TITLE, $this->opt_default_title);
		if ($this->isColumnModified(PositioningPeer::OPT_TITLE_PRODUCT)) $criteria->add(PositioningPeer::OPT_TITLE_PRODUCT, $this->opt_title_product);
		if ($this->isColumnModified(PositioningPeer::OPT_TITLE_CATEGORY)) $criteria->add(PositioningPeer::OPT_TITLE_CATEGORY, $this->opt_title_category);
		if ($this->isColumnModified(PositioningPeer::OPT_TITLE_MANUFACTEUR)) $criteria->add(PositioningPeer::OPT_TITLE_MANUFACTEUR, $this->opt_title_manufacteur);
		if ($this->isColumnModified(PositioningPeer::OPT_TITLE_BLOG)) $criteria->add(PositioningPeer::OPT_TITLE_BLOG, $this->opt_title_blog);
		if ($this->isColumnModified(PositioningPeer::OPT_TITLE_PRODUCT_GROUP)) $criteria->add(PositioningPeer::OPT_TITLE_PRODUCT_GROUP, $this->opt_title_product_group);
		if ($this->isColumnModified(PositioningPeer::OPT_TITLE_WEBPAGE)) $criteria->add(PositioningPeer::OPT_TITLE_WEBPAGE, $this->opt_title_webpage);

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
		$criteria = new Criteria(PositioningPeer::DATABASE_NAME);

		$criteria->add(PositioningPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Positioning (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setName($this->name);

		$copyObj->setSystemName($this->system_name);

		$copyObj->setOptTitle($this->opt_title);

		$copyObj->setOptKeywords($this->opt_keywords);

		$copyObj->setOptDescription($this->opt_description);

		$copyObj->setOptType($this->opt_type);

		$copyObj->setOptDefaultTitle($this->opt_default_title);

		$copyObj->setOptTitleProduct($this->opt_title_product);

		$copyObj->setOptTitleCategory($this->opt_title_category);

		$copyObj->setOptTitleManufacteur($this->opt_title_manufacteur);

		$copyObj->setOptTitleBlog($this->opt_title_blog);

		$copyObj->setOptTitleProductGroup($this->opt_title_product_group);

		$copyObj->setOptTitleWebpage($this->opt_title_webpage);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getPositioningI18ns() as $relObj) {
				$copyObj->addPositioningI18n($relObj->copy($deepCopy));
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
	 * @return     Positioning Clone of current object.
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
	 * @return     PositioningPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PositioningPeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collPositioningI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPositioningI18ns()
	{
		if ($this->collPositioningI18ns === null) {
			$this->collPositioningI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Positioning has previously
	 * been saved, it will retrieve related PositioningI18ns from storage.
	 * If this Positioning is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPositioningI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPositioningI18ns === null) {
			if ($this->isNew()) {
			   $this->collPositioningI18ns = array();
			} else {

				$criteria->add(PositioningI18nPeer::ID, $this->getId());

				PositioningI18nPeer::addSelectColumns($criteria);
				$this->collPositioningI18ns = PositioningI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PositioningI18nPeer::ID, $this->getId());

				PositioningI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastPositioningI18nCriteria) || !$this->lastPositioningI18nCriteria->equals($criteria)) {
					$this->collPositioningI18ns = PositioningI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPositioningI18nCriteria = $criteria;
		return $this->collPositioningI18ns;
	}

	/**
	 * Returns the number of related PositioningI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPositioningI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PositioningI18nPeer::ID, $this->getId());

		return PositioningI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a PositioningI18n object to this object
	 * through the PositioningI18n foreign key attribute
	 *
	 * @param      PositioningI18n $l PositioningI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPositioningI18n(PositioningI18n $l)
	{
		$this->collPositioningI18ns[] = $l;
		$l->setPositioning($this);
	}

  public function getCulture()
  {
    return $this->culture;
  }

  public function setCulture($culture)
  {
    $this->culture = $culture;
  }

  public function getTitle()
  {
    $obj = $this->getCurrentPositioningI18n();

    return ($obj ? $obj->getTitle() : null);
  }

  public function setTitle($value)
  {
    $this->getCurrentPositioningI18n()->setTitle($value);
  }

  public function getKeywords()
  {
    $obj = $this->getCurrentPositioningI18n();

    return ($obj ? $obj->getKeywords() : null);
  }

  public function setKeywords($value)
  {
    $this->getCurrentPositioningI18n()->setKeywords($value);
  }

  public function getDescription()
  {
    $obj = $this->getCurrentPositioningI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentPositioningI18n()->setDescription($value);
  }

  public function getTitleProduct()
  {
    $obj = $this->getCurrentPositioningI18n();

    return ($obj ? $obj->getTitleProduct() : null);
  }

  public function setTitleProduct($value)
  {
    $this->getCurrentPositioningI18n()->setTitleProduct($value);
  }

  public function getTitleCategory()
  {
    $obj = $this->getCurrentPositioningI18n();

    return ($obj ? $obj->getTitleCategory() : null);
  }

  public function setTitleCategory($value)
  {
    $this->getCurrentPositioningI18n()->setTitleCategory($value);
  }

  public function getTitleManufacteur()
  {
    $obj = $this->getCurrentPositioningI18n();

    return ($obj ? $obj->getTitleManufacteur() : null);
  }

  public function setTitleManufacteur($value)
  {
    $this->getCurrentPositioningI18n()->setTitleManufacteur($value);
  }

  public function getTitleBlog()
  {
    $obj = $this->getCurrentPositioningI18n();

    return ($obj ? $obj->getTitleBlog() : null);
  }

  public function setTitleBlog($value)
  {
    $this->getCurrentPositioningI18n()->setTitleBlog($value);
  }

  public function getTitleProductGroup()
  {
    $obj = $this->getCurrentPositioningI18n();

    return ($obj ? $obj->getTitleProductGroup() : null);
  }

  public function setTitleProductGroup($value)
  {
    $this->getCurrentPositioningI18n()->setTitleProductGroup($value);
  }

  public function getTitleWebpage()
  {
    $obj = $this->getCurrentPositioningI18n();

    return ($obj ? $obj->getTitleWebpage() : null);
  }

  public function setTitleWebpage($value)
  {
    $this->getCurrentPositioningI18n()->setTitleWebpage($value);
  }

  public function getType()
  {
    $obj = $this->getCurrentPositioningI18n();

    return ($obj ? $obj->getType() : null);
  }

  public function setType($value)
  {
    $this->getCurrentPositioningI18n()->setType($value);
  }

  public function getDefaultTitle()
  {
    $obj = $this->getCurrentPositioningI18n();

    return ($obj ? $obj->getDefaultTitle() : null);
  }

  public function setDefaultTitle($value)
  {
    $this->getCurrentPositioningI18n()->setDefaultTitle($value);
  }

  public $current_i18n = array();

  public function getCurrentPositioningI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = PositioningI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setPositioningI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setPositioningI18nForCulture(new PositioningI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setPositioningI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addPositioningI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Positioning.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BasePositioning:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BasePositioning::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BasePositioning
