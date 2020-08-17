<?php

/**
 * Base class that represents a row from the 'st_slide_banner' table.
 *
 * 
 *
 * @package    plugins.stSlideBannerPlugin.lib.model.om
 */
abstract class BaseSlideBanner extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        SlideBannerPeer
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
	 * The value for the language_id field.
	 * @var        int
	 */
	protected $language_id;


	/**
	 * The value for the image field.
	 * @var        string
	 */
	protected $image;


	/**
	 * The value for the image_small field.
	 * @var        string
	 */
	protected $image_small;


	/**
	 * The value for the banner_type field.
	 * @var        int
	 */
	protected $banner_type = 0;


	/**
	 * The value for the link field.
	 * @var        string
	 */
	protected $link;


	/**
	 * The value for the group_name field.
	 * @var        string
	 */
	protected $group_name;


	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;


	/**
	 * The value for the banner_title field.
	 * @var        string
	 */
	protected $banner_title;


	/**
	 * The value for the banner_description field.
	 * @var        string
	 */
	protected $banner_description;


	/**
	 * The value for the button_text field.
	 * @var        string
	 */
	protected $button_text;


	/**
	 * The value for the button_link field.
	 * @var        string
	 */
	protected $button_link;


	/**
	 * The value for the banner_description_position field.
	 * @var        int
	 */
	protected $banner_description_position = 0;


	/**
	 * The value for the banner_margin_left field.
	 * @var        string
	 */
	protected $banner_margin_left;


	/**
	 * The value for the banner_margin_right field.
	 * @var        string
	 */
	protected $banner_margin_right;


	/**
	 * The value for the is_active field.
	 * @var        boolean
	 */
	protected $is_active = true;


	/**
	 * The value for the opt_culture field.
	 * @var        string
	 */
	protected $opt_culture;


	/**
	 * The value for the rank field.
	 * @var        int
	 */
	protected $rank;

	/**
	 * @var        Language
	 */
	protected $aLanguage;

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
     * Get the [language_id] column value.
     * 
     * @return     int
     */
    public function getLanguageId()
    {

            return $this->language_id;
    }

    /**
     * Get the [image] column value.
     * 
     * @return     string
     */
    public function getImage()
    {

            return $this->image;
    }

    /**
     * Get the [image_small] column value.
     * 
     * @return     string
     */
    public function getImageSmall()
    {

            return $this->image_small;
    }

    /**
     * Get the [banner_type] column value.
     * 
     * @return     int
     */
    public function getBannerType()
    {

            return $this->banner_type;
    }

    /**
     * Get the [link] column value.
     * 
     * @return     string
     */
    public function getLink()
    {

            return $this->link;
    }

    /**
     * Get the [group_name] column value.
     * 
     * @return     string
     */
    public function getGroupName()
    {

            return $this->group_name;
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
     * Get the [banner_title] column value.
     * 
     * @return     string
     */
    public function getBannerTitle()
    {

            return $this->banner_title;
    }

    /**
     * Get the [banner_description] column value.
     * 
     * @return     string
     */
    public function getBannerDescription()
    {

            return $this->banner_description;
    }

    /**
     * Get the [button_text] column value.
     * 
     * @return     string
     */
    public function getButtonText()
    {

            return $this->button_text;
    }

    /**
     * Get the [button_link] column value.
     * 
     * @return     string
     */
    public function getButtonLink()
    {

            return $this->button_link;
    }

    /**
     * Get the [banner_description_position] column value.
     * 
     * @return     int
     */
    public function getBannerDescriptionPosition()
    {

            return $this->banner_description_position;
    }

    /**
     * Get the [banner_margin_left] column value.
     * 
     * @return     string
     */
    public function getBannerMarginLeft()
    {

            return $this->banner_margin_left;
    }

    /**
     * Get the [banner_margin_right] column value.
     * 
     * @return     string
     */
    public function getBannerMarginRight()
    {

            return $this->banner_margin_right;
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
     * Get the [opt_culture] column value.
     * 
     * @return     string
     */
    public function getOptCulture()
    {

            return $this->opt_culture;
    }

    /**
     * Get the [rank] column value.
     * 
     * @return     int
     */
    public function getRank()
    {

            return $this->rank;
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
			$this->modifiedColumns[] = SlideBannerPeer::CREATED_AT;
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
			$this->modifiedColumns[] = SlideBannerPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = SlideBannerPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [language_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setLanguageId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->language_id !== $v) {
          $this->language_id = $v;
          $this->modifiedColumns[] = SlideBannerPeer::LANGUAGE_ID;
        }

		if ($this->aLanguage !== null && $this->aLanguage->getId() !== $v) {
			$this->aLanguage = null;
		}

	} // setLanguageId()

	/**
	 * Set the value of [image] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setImage($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->image !== $v) {
          $this->image = $v;
          $this->modifiedColumns[] = SlideBannerPeer::IMAGE;
        }

	} // setImage()

	/**
	 * Set the value of [image_small] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setImageSmall($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->image_small !== $v) {
          $this->image_small = $v;
          $this->modifiedColumns[] = SlideBannerPeer::IMAGE_SMALL;
        }

	} // setImageSmall()

	/**
	 * Set the value of [banner_type] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setBannerType($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->banner_type !== $v || $v === 0) {
          $this->banner_type = $v;
          $this->modifiedColumns[] = SlideBannerPeer::BANNER_TYPE;
        }

	} // setBannerType()

	/**
	 * Set the value of [link] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setLink($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->link !== $v) {
          $this->link = $v;
          $this->modifiedColumns[] = SlideBannerPeer::LINK;
        }

	} // setLink()

	/**
	 * Set the value of [group_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setGroupName($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->group_name !== $v) {
          $this->group_name = $v;
          $this->modifiedColumns[] = SlideBannerPeer::GROUP_NAME;
        }

	} // setGroupName()

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
          $this->modifiedColumns[] = SlideBannerPeer::DESCRIPTION;
        }

	} // setDescription()

	/**
	 * Set the value of [banner_title] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setBannerTitle($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->banner_title !== $v) {
          $this->banner_title = $v;
          $this->modifiedColumns[] = SlideBannerPeer::BANNER_TITLE;
        }

	} // setBannerTitle()

	/**
	 * Set the value of [banner_description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setBannerDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->banner_description !== $v) {
          $this->banner_description = $v;
          $this->modifiedColumns[] = SlideBannerPeer::BANNER_DESCRIPTION;
        }

	} // setBannerDescription()

	/**
	 * Set the value of [button_text] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setButtonText($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->button_text !== $v) {
          $this->button_text = $v;
          $this->modifiedColumns[] = SlideBannerPeer::BUTTON_TEXT;
        }

	} // setButtonText()

	/**
	 * Set the value of [button_link] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setButtonLink($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->button_link !== $v) {
          $this->button_link = $v;
          $this->modifiedColumns[] = SlideBannerPeer::BUTTON_LINK;
        }

	} // setButtonLink()

	/**
	 * Set the value of [banner_description_position] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setBannerDescriptionPosition($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->banner_description_position !== $v || $v === 0) {
          $this->banner_description_position = $v;
          $this->modifiedColumns[] = SlideBannerPeer::BANNER_DESCRIPTION_POSITION;
        }

	} // setBannerDescriptionPosition()

	/**
	 * Set the value of [banner_margin_left] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setBannerMarginLeft($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->banner_margin_left !== $v) {
          $this->banner_margin_left = $v;
          $this->modifiedColumns[] = SlideBannerPeer::BANNER_MARGIN_LEFT;
        }

	} // setBannerMarginLeft()

	/**
	 * Set the value of [banner_margin_right] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setBannerMarginRight($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->banner_margin_right !== $v) {
          $this->banner_margin_right = $v;
          $this->modifiedColumns[] = SlideBannerPeer::BANNER_MARGIN_RIGHT;
        }

	} // setBannerMarginRight()

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
          $this->modifiedColumns[] = SlideBannerPeer::IS_ACTIVE;
        }

	} // setIsActive()

	/**
	 * Set the value of [opt_culture] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptCulture($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_culture !== $v) {
          $this->opt_culture = $v;
          $this->modifiedColumns[] = SlideBannerPeer::OPT_CULTURE;
        }

	} // setOptCulture()

	/**
	 * Set the value of [rank] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setRank($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->rank !== $v) {
          $this->rank = $v;
          $this->modifiedColumns[] = SlideBannerPeer::RANK;
        }

	} // setRank()

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
      if ($this->getDispatcher()->getListeners('SlideBanner.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'SlideBanner.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->language_id = $rs->getInt($startcol + 3);

      $this->image = $rs->getString($startcol + 4);

      $this->image_small = $rs->getString($startcol + 5);

      $this->banner_type = $rs->getInt($startcol + 6);

      $this->link = $rs->getString($startcol + 7);

      $this->group_name = $rs->getString($startcol + 8);

      $this->description = $rs->getString($startcol + 9);

      $this->banner_title = $rs->getString($startcol + 10);

      $this->banner_description = $rs->getString($startcol + 11);

      $this->button_text = $rs->getString($startcol + 12);

      $this->button_link = $rs->getString($startcol + 13);

      $this->banner_description_position = $rs->getInt($startcol + 14);

      $this->banner_margin_left = $rs->getString($startcol + 15);

      $this->banner_margin_right = $rs->getString($startcol + 16);

      $this->is_active = $rs->getBoolean($startcol + 17);

      $this->opt_culture = $rs->getString($startcol + 18);

      $this->rank = $rs->getInt($startcol + 19);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('SlideBanner.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'SlideBanner.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 20)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 20; // 20 = SlideBannerPeer::NUM_COLUMNS - SlideBannerPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating SlideBanner object", $e);
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

    if ($this->getDispatcher()->getListeners('SlideBanner.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'SlideBanner.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseSlideBanner:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseSlideBanner:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(SlideBannerPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      SlideBannerPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('SlideBanner.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'SlideBanner.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseSlideBanner:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseSlideBanner:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('SlideBanner.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'SlideBanner.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseSlideBanner:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(SlideBannerPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(SlideBannerPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(SlideBannerPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('SlideBanner.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'SlideBanner.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseSlideBanner:save:post') as $callable)
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

			if ($this->aLanguage !== null) {
				if ($this->aLanguage->isModified() || $this->aLanguage->getCurrentLanguageI18n()->isModified()) {
					$affectedRows += $this->aLanguage->save($con);
				}
				$this->setLanguage($this->aLanguage);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = SlideBannerPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += SlideBannerPeer::doUpdate($this, $con);
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

			if ($this->aLanguage !== null) {
				if (!$this->aLanguage->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aLanguage->getValidationFailures());
				}
			}


			if (($retval = SlideBannerPeer::doValidate($this, $columns)) !== true) {
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
		$pos = SlideBannerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getLanguageId();
				break;
			case 4:
				return $this->getImage();
				break;
			case 5:
				return $this->getImageSmall();
				break;
			case 6:
				return $this->getBannerType();
				break;
			case 7:
				return $this->getLink();
				break;
			case 8:
				return $this->getGroupName();
				break;
			case 9:
				return $this->getDescription();
				break;
			case 10:
				return $this->getBannerTitle();
				break;
			case 11:
				return $this->getBannerDescription();
				break;
			case 12:
				return $this->getButtonText();
				break;
			case 13:
				return $this->getButtonLink();
				break;
			case 14:
				return $this->getBannerDescriptionPosition();
				break;
			case 15:
				return $this->getBannerMarginLeft();
				break;
			case 16:
				return $this->getBannerMarginRight();
				break;
			case 17:
				return $this->getIsActive();
				break;
			case 18:
				return $this->getOptCulture();
				break;
			case 19:
				return $this->getRank();
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
		$keys = SlideBannerPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getLanguageId(),
			$keys[4] => $this->getImage(),
			$keys[5] => $this->getImageSmall(),
			$keys[6] => $this->getBannerType(),
			$keys[7] => $this->getLink(),
			$keys[8] => $this->getGroupName(),
			$keys[9] => $this->getDescription(),
			$keys[10] => $this->getBannerTitle(),
			$keys[11] => $this->getBannerDescription(),
			$keys[12] => $this->getButtonText(),
			$keys[13] => $this->getButtonLink(),
			$keys[14] => $this->getBannerDescriptionPosition(),
			$keys[15] => $this->getBannerMarginLeft(),
			$keys[16] => $this->getBannerMarginRight(),
			$keys[17] => $this->getIsActive(),
			$keys[18] => $this->getOptCulture(),
			$keys[19] => $this->getRank(),
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
		$pos = SlideBannerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setLanguageId($value);
				break;
			case 4:
				$this->setImage($value);
				break;
			case 5:
				$this->setImageSmall($value);
				break;
			case 6:
				$this->setBannerType($value);
				break;
			case 7:
				$this->setLink($value);
				break;
			case 8:
				$this->setGroupName($value);
				break;
			case 9:
				$this->setDescription($value);
				break;
			case 10:
				$this->setBannerTitle($value);
				break;
			case 11:
				$this->setBannerDescription($value);
				break;
			case 12:
				$this->setButtonText($value);
				break;
			case 13:
				$this->setButtonLink($value);
				break;
			case 14:
				$this->setBannerDescriptionPosition($value);
				break;
			case 15:
				$this->setBannerMarginLeft($value);
				break;
			case 16:
				$this->setBannerMarginRight($value);
				break;
			case 17:
				$this->setIsActive($value);
				break;
			case 18:
				$this->setOptCulture($value);
				break;
			case 19:
				$this->setRank($value);
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
		$keys = SlideBannerPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setLanguageId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setImage($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setImageSmall($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setBannerType($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setLink($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setGroupName($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setDescription($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setBannerTitle($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setBannerDescription($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setButtonText($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setButtonLink($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setBannerDescriptionPosition($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setBannerMarginLeft($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setBannerMarginRight($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setIsActive($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setOptCulture($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setRank($arr[$keys[19]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(SlideBannerPeer::DATABASE_NAME);

		if ($this->isColumnModified(SlideBannerPeer::CREATED_AT)) $criteria->add(SlideBannerPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(SlideBannerPeer::UPDATED_AT)) $criteria->add(SlideBannerPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(SlideBannerPeer::ID)) $criteria->add(SlideBannerPeer::ID, $this->id);
		if ($this->isColumnModified(SlideBannerPeer::LANGUAGE_ID)) $criteria->add(SlideBannerPeer::LANGUAGE_ID, $this->language_id);
		if ($this->isColumnModified(SlideBannerPeer::IMAGE)) $criteria->add(SlideBannerPeer::IMAGE, $this->image);
		if ($this->isColumnModified(SlideBannerPeer::IMAGE_SMALL)) $criteria->add(SlideBannerPeer::IMAGE_SMALL, $this->image_small);
		if ($this->isColumnModified(SlideBannerPeer::BANNER_TYPE)) $criteria->add(SlideBannerPeer::BANNER_TYPE, $this->banner_type);
		if ($this->isColumnModified(SlideBannerPeer::LINK)) $criteria->add(SlideBannerPeer::LINK, $this->link);
		if ($this->isColumnModified(SlideBannerPeer::GROUP_NAME)) $criteria->add(SlideBannerPeer::GROUP_NAME, $this->group_name);
		if ($this->isColumnModified(SlideBannerPeer::DESCRIPTION)) $criteria->add(SlideBannerPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(SlideBannerPeer::BANNER_TITLE)) $criteria->add(SlideBannerPeer::BANNER_TITLE, $this->banner_title);
		if ($this->isColumnModified(SlideBannerPeer::BANNER_DESCRIPTION)) $criteria->add(SlideBannerPeer::BANNER_DESCRIPTION, $this->banner_description);
		if ($this->isColumnModified(SlideBannerPeer::BUTTON_TEXT)) $criteria->add(SlideBannerPeer::BUTTON_TEXT, $this->button_text);
		if ($this->isColumnModified(SlideBannerPeer::BUTTON_LINK)) $criteria->add(SlideBannerPeer::BUTTON_LINK, $this->button_link);
		if ($this->isColumnModified(SlideBannerPeer::BANNER_DESCRIPTION_POSITION)) $criteria->add(SlideBannerPeer::BANNER_DESCRIPTION_POSITION, $this->banner_description_position);
		if ($this->isColumnModified(SlideBannerPeer::BANNER_MARGIN_LEFT)) $criteria->add(SlideBannerPeer::BANNER_MARGIN_LEFT, $this->banner_margin_left);
		if ($this->isColumnModified(SlideBannerPeer::BANNER_MARGIN_RIGHT)) $criteria->add(SlideBannerPeer::BANNER_MARGIN_RIGHT, $this->banner_margin_right);
		if ($this->isColumnModified(SlideBannerPeer::IS_ACTIVE)) $criteria->add(SlideBannerPeer::IS_ACTIVE, $this->is_active);
		if ($this->isColumnModified(SlideBannerPeer::OPT_CULTURE)) $criteria->add(SlideBannerPeer::OPT_CULTURE, $this->opt_culture);
		if ($this->isColumnModified(SlideBannerPeer::RANK)) $criteria->add(SlideBannerPeer::RANK, $this->rank);

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
		$criteria = new Criteria(SlideBannerPeer::DATABASE_NAME);

		$criteria->add(SlideBannerPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of SlideBanner (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setLanguageId($this->language_id);

		$copyObj->setImage($this->image);

		$copyObj->setImageSmall($this->image_small);

		$copyObj->setBannerType($this->banner_type);

		$copyObj->setLink($this->link);

		$copyObj->setGroupName($this->group_name);

		$copyObj->setDescription($this->description);

		$copyObj->setBannerTitle($this->banner_title);

		$copyObj->setBannerDescription($this->banner_description);

		$copyObj->setButtonText($this->button_text);

		$copyObj->setButtonLink($this->button_link);

		$copyObj->setBannerDescriptionPosition($this->banner_description_position);

		$copyObj->setBannerMarginLeft($this->banner_margin_left);

		$copyObj->setBannerMarginRight($this->banner_margin_right);

		$copyObj->setIsActive($this->is_active);

		$copyObj->setOptCulture($this->opt_culture);

		$copyObj->setRank($this->rank);


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
	 * @return     SlideBanner Clone of current object.
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
	 * @return     SlideBannerPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new SlideBannerPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Language object.
	 *
	 * @param      Language $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setLanguage($v)
	{


		if ($v === null) {
			$this->setLanguageId(NULL);
		} else {
			$this->setLanguageId($v->getId());
		}


		$this->aLanguage = $v;
	}


	/**
	 * Get the associated Language object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Language The associated Language object.
	 * @throws     PropelException
	 */
	public function getLanguage($con = null)
	{
		if ($this->aLanguage === null && ($this->language_id !== null)) {
			// include the related Peer class
			$this->aLanguage = LanguagePeer::retrieveByPK($this->language_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = LanguagePeer::retrieveByPK($this->language_id, $con);
			   $obj->addLanguages($this);
			 */
		}
		return $this->aLanguage;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'SlideBanner.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseSlideBanner:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseSlideBanner::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseSlideBanner
