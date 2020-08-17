<?php

/**
 * Base class that represents a row from the 'st_blog' table.
 *
 * 
 *
 * @package    plugins.stBlogPlugin.lib.model.om
 */
abstract class BaseBlog extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        BlogPeer
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
	 * The value for the sf_asset_id field.
	 * @var        int
	 */
	protected $sf_asset_id;


	/**
	 * The value for the active field.
	 * @var        boolean
	 */
	protected $active;


	/**
	 * The value for the opt_name field.
	 * @var        string
	 */
	protected $opt_name;


	/**
	 * The value for the opt_short_description field.
	 * @var        string
	 */
	protected $opt_short_description;


	/**
	 * The value for the opt_long_description field.
	 * @var        string
	 */
	protected $opt_long_description;


	/**
	 * The value for the image_main_page field.
	 * @var        string
	 */
	protected $image_main_page;


	/**
	 * The value for the image field.
	 * @var        string
	 */
	protected $image;


	/**
	 * The value for the opt_url field.
	 * @var        string
	 */
	protected $opt_url;


	/**
	 * The value for the alternative_url field.
	 * @var        string
	 */
	protected $alternative_url;


	/**
	 * The value for the gallery field.
	 * @var        string
	 */
	protected $gallery;

	/**
	 * @var        sfAsset
	 */
	protected $asfAsset;

	/**
	 * Collection to store aggregation of collBlogHasBlogCategorys.
	 * @var        array
	 */
	protected $collBlogHasBlogCategorys;

	/**
	 * The criteria used to select the current contents of collBlogHasBlogCategorys.
	 * @var        Criteria
	 */
	protected $lastBlogHasBlogCategoryCriteria = null;

	/**
	 * Collection to store aggregation of collBlogI18ns.
	 * @var        array
	 */
	protected $collBlogI18ns;

	/**
	 * The criteria used to select the current contents of collBlogI18ns.
	 * @var        Criteria
	 */
	protected $lastBlogI18nCriteria = null;

	/**
	 * Collection to store aggregation of collBlogHasPositionings.
	 * @var        array
	 */
	protected $collBlogHasPositionings;

	/**
	 * The criteria used to select the current contents of collBlogHasPositionings.
	 * @var        Criteria
	 */
	protected $lastBlogHasPositioningCriteria = null;

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
     * Get the [sf_asset_id] column value.
     * 
     * @return     int
     */
    public function getSfAssetId()
    {

            return $this->sf_asset_id;
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
     * Get the [opt_name] column value.
     * 
     * @return     string
     */
    public function getOptName()
    {

            return $this->opt_name;
    }

    /**
     * Get the [opt_short_description] column value.
     * 
     * @return     string
     */
    public function getOptShortDescription()
    {

            return $this->opt_short_description;
    }

    /**
     * Get the [opt_long_description] column value.
     * 
     * @return     string
     */
    public function getOptLongDescription()
    {

            return $this->opt_long_description;
    }

    /**
     * Get the [image_main_page] column value.
     * 
     * @return     string
     */
    public function getImageMainPage()
    {

            return $this->image_main_page;
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
     * Get the [opt_url] column value.
     * 
     * @return     string
     */
    public function getOptUrl()
    {

            return $this->opt_url;
    }

    /**
     * Get the [alternative_url] column value.
     * 
     * @return     string
     */
    public function getAlternativeUrl()
    {

            return $this->alternative_url;
    }

    /**
     * Get the [gallery] column value.
     * 
     * @return     string
     */
    public function getGallery()
    {

            return $this->gallery;
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
			$this->modifiedColumns[] = BlogPeer::CREATED_AT;
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
			$this->modifiedColumns[] = BlogPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = BlogPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [sf_asset_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setSfAssetId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->sf_asset_id !== $v) {
          $this->sf_asset_id = $v;
          $this->modifiedColumns[] = BlogPeer::SF_ASSET_ID;
        }

		if ($this->asfAsset !== null && $this->asfAsset->getId() !== $v) {
			$this->asfAsset = null;
		}

	} // setSfAssetId()

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
          $this->modifiedColumns[] = BlogPeer::ACTIVE;
        }

	} // setActive()

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
          $this->modifiedColumns[] = BlogPeer::OPT_NAME;
        }

	} // setOptName()

	/**
	 * Set the value of [opt_short_description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptShortDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_short_description !== $v) {
          $this->opt_short_description = $v;
          $this->modifiedColumns[] = BlogPeer::OPT_SHORT_DESCRIPTION;
        }

	} // setOptShortDescription()

	/**
	 * Set the value of [opt_long_description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptLongDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_long_description !== $v) {
          $this->opt_long_description = $v;
          $this->modifiedColumns[] = BlogPeer::OPT_LONG_DESCRIPTION;
        }

	} // setOptLongDescription()

	/**
	 * Set the value of [image_main_page] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setImageMainPage($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->image_main_page !== $v) {
          $this->image_main_page = $v;
          $this->modifiedColumns[] = BlogPeer::IMAGE_MAIN_PAGE;
        }

	} // setImageMainPage()

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
          $this->modifiedColumns[] = BlogPeer::IMAGE;
        }

	} // setImage()

	/**
	 * Set the value of [opt_url] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptUrl($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_url !== $v) {
          $this->opt_url = $v;
          $this->modifiedColumns[] = BlogPeer::OPT_URL;
        }

	} // setOptUrl()

	/**
	 * Set the value of [alternative_url] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setAlternativeUrl($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->alternative_url !== $v) {
          $this->alternative_url = $v;
          $this->modifiedColumns[] = BlogPeer::ALTERNATIVE_URL;
        }

	} // setAlternativeUrl()

	/**
	 * Set the value of [gallery] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setGallery($v)
	{

        if ($this->gallery !== $v) {
          $this->gallery = $v;
          $this->modifiedColumns[] = BlogPeer::GALLERY;
        }

	} // setGallery()

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
      if ($this->getDispatcher()->getListeners('Blog.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Blog.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->sf_asset_id = $rs->getInt($startcol + 3);

      $this->active = $rs->getBoolean($startcol + 4);

      $this->opt_name = $rs->getString($startcol + 5);

      $this->opt_short_description = $rs->getString($startcol + 6);

      $this->opt_long_description = $rs->getString($startcol + 7);

      $this->image_main_page = $rs->getString($startcol + 8);

      $this->image = $rs->getString($startcol + 9);

      $this->opt_url = $rs->getString($startcol + 10);

      $this->alternative_url = $rs->getString($startcol + 11);

      $this->gallery = $rs->getString($startcol + 12) ? unserialize($rs->getString($startcol + 12)) : null;

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Blog.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Blog.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 13)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 13; // 13 = BlogPeer::NUM_COLUMNS - BlogPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Blog object", $e);
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

    if ($this->getDispatcher()->getListeners('Blog.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Blog.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseBlog:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseBlog:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(BlogPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      BlogPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Blog.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Blog.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseBlog:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseBlog:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Blog.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Blog.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseBlog:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(BlogPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(BlogPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(BlogPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Blog.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Blog.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseBlog:save:post') as $callable)
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

			if ($this->asfAsset !== null) {
				if ($this->asfAsset->isModified() || $this->asfAsset->getCurrentsfAssetI18n()->isModified()) {
					$affectedRows += $this->asfAsset->save($con);
				}
				$this->setsfAsset($this->asfAsset);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
              $o_gallery = $this->gallery;
              if (null !== $this->gallery && $this->isColumnModified(BlogPeer::GALLERY)) {
                  $this->gallery = serialize($this->gallery);
              }

				if ($this->isNew()) {
					$pk = BlogPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += BlogPeer::doUpdate($this, $con);
				}
				$this->resetModified();
             $this->gallery = $o_gallery;
 // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collBlogHasBlogCategorys !== null) {
				foreach($this->collBlogHasBlogCategorys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collBlogI18ns !== null) {
				foreach($this->collBlogI18ns as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collBlogHasPositionings !== null) {
				foreach($this->collBlogHasPositionings as $referrerFK) {
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

			if ($this->asfAsset !== null) {
				if (!$this->asfAsset->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfAsset->getValidationFailures());
				}
			}


			if (($retval = BlogPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collBlogHasBlogCategorys !== null) {
					foreach($this->collBlogHasBlogCategorys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collBlogI18ns !== null) {
					foreach($this->collBlogI18ns as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collBlogHasPositionings !== null) {
					foreach($this->collBlogHasPositionings as $referrerFK) {
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
		$pos = BlogPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getSfAssetId();
				break;
			case 4:
				return $this->getActive();
				break;
			case 5:
				return $this->getOptName();
				break;
			case 6:
				return $this->getOptShortDescription();
				break;
			case 7:
				return $this->getOptLongDescription();
				break;
			case 8:
				return $this->getImageMainPage();
				break;
			case 9:
				return $this->getImage();
				break;
			case 10:
				return $this->getOptUrl();
				break;
			case 11:
				return $this->getAlternativeUrl();
				break;
			case 12:
				return $this->getGallery();
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
		$keys = BlogPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getSfAssetId(),
			$keys[4] => $this->getActive(),
			$keys[5] => $this->getOptName(),
			$keys[6] => $this->getOptShortDescription(),
			$keys[7] => $this->getOptLongDescription(),
			$keys[8] => $this->getImageMainPage(),
			$keys[9] => $this->getImage(),
			$keys[10] => $this->getOptUrl(),
			$keys[11] => $this->getAlternativeUrl(),
			$keys[12] => $this->getGallery(),
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
		$pos = BlogPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setSfAssetId($value);
				break;
			case 4:
				$this->setActive($value);
				break;
			case 5:
				$this->setOptName($value);
				break;
			case 6:
				$this->setOptShortDescription($value);
				break;
			case 7:
				$this->setOptLongDescription($value);
				break;
			case 8:
				$this->setImageMainPage($value);
				break;
			case 9:
				$this->setImage($value);
				break;
			case 10:
				$this->setOptUrl($value);
				break;
			case 11:
				$this->setAlternativeUrl($value);
				break;
			case 12:
				$this->setGallery($value);
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
		$keys = BlogPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSfAssetId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setActive($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOptName($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setOptShortDescription($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setOptLongDescription($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setImageMainPage($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setImage($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setOptUrl($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setAlternativeUrl($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setGallery($arr[$keys[12]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(BlogPeer::DATABASE_NAME);

		if ($this->isColumnModified(BlogPeer::CREATED_AT)) $criteria->add(BlogPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(BlogPeer::UPDATED_AT)) $criteria->add(BlogPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(BlogPeer::ID)) $criteria->add(BlogPeer::ID, $this->id);
		if ($this->isColumnModified(BlogPeer::SF_ASSET_ID)) $criteria->add(BlogPeer::SF_ASSET_ID, $this->sf_asset_id);
		if ($this->isColumnModified(BlogPeer::ACTIVE)) $criteria->add(BlogPeer::ACTIVE, $this->active);
		if ($this->isColumnModified(BlogPeer::OPT_NAME)) $criteria->add(BlogPeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(BlogPeer::OPT_SHORT_DESCRIPTION)) $criteria->add(BlogPeer::OPT_SHORT_DESCRIPTION, $this->opt_short_description);
		if ($this->isColumnModified(BlogPeer::OPT_LONG_DESCRIPTION)) $criteria->add(BlogPeer::OPT_LONG_DESCRIPTION, $this->opt_long_description);
		if ($this->isColumnModified(BlogPeer::IMAGE_MAIN_PAGE)) $criteria->add(BlogPeer::IMAGE_MAIN_PAGE, $this->image_main_page);
		if ($this->isColumnModified(BlogPeer::IMAGE)) $criteria->add(BlogPeer::IMAGE, $this->image);
		if ($this->isColumnModified(BlogPeer::OPT_URL)) $criteria->add(BlogPeer::OPT_URL, $this->opt_url);
		if ($this->isColumnModified(BlogPeer::ALTERNATIVE_URL)) $criteria->add(BlogPeer::ALTERNATIVE_URL, $this->alternative_url);
		if ($this->isColumnModified(BlogPeer::GALLERY)) $criteria->add(BlogPeer::GALLERY, $this->gallery);

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
		$criteria = new Criteria(BlogPeer::DATABASE_NAME);

		$criteria->add(BlogPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Blog (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setSfAssetId($this->sf_asset_id);

		$copyObj->setActive($this->active);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setOptShortDescription($this->opt_short_description);

		$copyObj->setOptLongDescription($this->opt_long_description);

		$copyObj->setImageMainPage($this->image_main_page);

		$copyObj->setImage($this->image);

		$copyObj->setOptUrl($this->opt_url);

		$copyObj->setAlternativeUrl($this->alternative_url);

		$copyObj->setGallery($this->gallery);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getBlogHasBlogCategorys() as $relObj) {
				$copyObj->addBlogHasBlogCategory($relObj->copy($deepCopy));
			}

			foreach($this->getBlogI18ns() as $relObj) {
				$copyObj->addBlogI18n($relObj->copy($deepCopy));
			}

			foreach($this->getBlogHasPositionings() as $relObj) {
				$copyObj->addBlogHasPositioning($relObj->copy($deepCopy));
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
	 * @return     Blog Clone of current object.
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
	 * @return     BlogPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new BlogPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a sfAsset object.
	 *
	 * @param      sfAsset $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setsfAsset($v)
	{


		if ($v === null) {
			$this->setSfAssetId(NULL);
		} else {
			$this->setSfAssetId($v->getId());
		}


		$this->asfAsset = $v;
	}


	/**
	 * Get the associated sfAsset object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     sfAsset The associated sfAsset object.
	 * @throws     PropelException
	 */
	public function getsfAsset($con = null)
	{
		if ($this->asfAsset === null && ($this->sf_asset_id !== null)) {
			// include the related Peer class
			$this->asfAsset = sfAssetPeer::retrieveByPK($this->sf_asset_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = sfAssetPeer::retrieveByPK($this->sf_asset_id, $con);
			   $obj->addsfAssets($this);
			 */
		}
		return $this->asfAsset;
	}

	/**
	 * Temporary storage of collBlogHasBlogCategorys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initBlogHasBlogCategorys()
	{
		if ($this->collBlogHasBlogCategorys === null) {
			$this->collBlogHasBlogCategorys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Blog has previously
	 * been saved, it will retrieve related BlogHasBlogCategorys from storage.
	 * If this Blog is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getBlogHasBlogCategorys($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBlogHasBlogCategorys === null) {
			if ($this->isNew()) {
			   $this->collBlogHasBlogCategorys = array();
			} else {

				$criteria->add(BlogHasBlogCategoryPeer::BLOG_ID, $this->getId());

				BlogHasBlogCategoryPeer::addSelectColumns($criteria);
				$this->collBlogHasBlogCategorys = BlogHasBlogCategoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(BlogHasBlogCategoryPeer::BLOG_ID, $this->getId());

				BlogHasBlogCategoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastBlogHasBlogCategoryCriteria) || !$this->lastBlogHasBlogCategoryCriteria->equals($criteria)) {
					$this->collBlogHasBlogCategorys = BlogHasBlogCategoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastBlogHasBlogCategoryCriteria = $criteria;
		return $this->collBlogHasBlogCategorys;
	}

	/**
	 * Returns the number of related BlogHasBlogCategorys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countBlogHasBlogCategorys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(BlogHasBlogCategoryPeer::BLOG_ID, $this->getId());

		return BlogHasBlogCategoryPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a BlogHasBlogCategory object to this object
	 * through the BlogHasBlogCategory foreign key attribute
	 *
	 * @param      BlogHasBlogCategory $l BlogHasBlogCategory
	 * @return     void
	 * @throws     PropelException
	 */
	public function addBlogHasBlogCategory(BlogHasBlogCategory $l)
	{
		$this->collBlogHasBlogCategorys[] = $l;
		$l->setBlog($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Blog is new, it will return
	 * an empty collection; or if this Blog has previously
	 * been saved, it will retrieve related BlogHasBlogCategorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Blog.
	 */
	public function getBlogHasBlogCategorysJoinBlogCategory($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBlogHasBlogCategorys === null) {
			if ($this->isNew()) {
				$this->collBlogHasBlogCategorys = array();
			} else {

				$criteria->add(BlogHasBlogCategoryPeer::BLOG_ID, $this->getId());

				$this->collBlogHasBlogCategorys = BlogHasBlogCategoryPeer::doSelectJoinBlogCategory($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(BlogHasBlogCategoryPeer::BLOG_ID, $this->getId());

			if (!isset($this->lastBlogHasBlogCategoryCriteria) || !$this->lastBlogHasBlogCategoryCriteria->equals($criteria)) {
				$this->collBlogHasBlogCategorys = BlogHasBlogCategoryPeer::doSelectJoinBlogCategory($criteria, $con);
			}
		}
		$this->lastBlogHasBlogCategoryCriteria = $criteria;

		return $this->collBlogHasBlogCategorys;
	}

	/**
	 * Temporary storage of collBlogI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initBlogI18ns()
	{
		if ($this->collBlogI18ns === null) {
			$this->collBlogI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Blog has previously
	 * been saved, it will retrieve related BlogI18ns from storage.
	 * If this Blog is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getBlogI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBlogI18ns === null) {
			if ($this->isNew()) {
			   $this->collBlogI18ns = array();
			} else {

				$criteria->add(BlogI18nPeer::ID, $this->getId());

				BlogI18nPeer::addSelectColumns($criteria);
				$this->collBlogI18ns = BlogI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(BlogI18nPeer::ID, $this->getId());

				BlogI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastBlogI18nCriteria) || !$this->lastBlogI18nCriteria->equals($criteria)) {
					$this->collBlogI18ns = BlogI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastBlogI18nCriteria = $criteria;
		return $this->collBlogI18ns;
	}

	/**
	 * Returns the number of related BlogI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countBlogI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(BlogI18nPeer::ID, $this->getId());

		return BlogI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a BlogI18n object to this object
	 * through the BlogI18n foreign key attribute
	 *
	 * @param      BlogI18n $l BlogI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addBlogI18n(BlogI18n $l)
	{
		$this->collBlogI18ns[] = $l;
		$l->setBlog($this);
	}

	/**
	 * Temporary storage of collBlogHasPositionings to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initBlogHasPositionings()
	{
		if ($this->collBlogHasPositionings === null) {
			$this->collBlogHasPositionings = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Blog has previously
	 * been saved, it will retrieve related BlogHasPositionings from storage.
	 * If this Blog is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getBlogHasPositionings($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBlogHasPositionings === null) {
			if ($this->isNew()) {
			   $this->collBlogHasPositionings = array();
			} else {

				$criteria->add(BlogHasPositioningPeer::BLOG_ID, $this->getId());

				BlogHasPositioningPeer::addSelectColumns($criteria);
				$this->collBlogHasPositionings = BlogHasPositioningPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(BlogHasPositioningPeer::BLOG_ID, $this->getId());

				BlogHasPositioningPeer::addSelectColumns($criteria);
				if (!isset($this->lastBlogHasPositioningCriteria) || !$this->lastBlogHasPositioningCriteria->equals($criteria)) {
					$this->collBlogHasPositionings = BlogHasPositioningPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastBlogHasPositioningCriteria = $criteria;
		return $this->collBlogHasPositionings;
	}

	/**
	 * Returns the number of related BlogHasPositionings.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countBlogHasPositionings($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(BlogHasPositioningPeer::BLOG_ID, $this->getId());

		return BlogHasPositioningPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a BlogHasPositioning object to this object
	 * through the BlogHasPositioning foreign key attribute
	 *
	 * @param      BlogHasPositioning $l BlogHasPositioning
	 * @return     void
	 * @throws     PropelException
	 */
	public function addBlogHasPositioning(BlogHasPositioning $l)
	{
		$this->collBlogHasPositionings[] = $l;
		$l->setBlog($this);
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
    $obj = $this->getCurrentBlogI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentBlogI18n()->setName($value);
  }

  public function getShortDescription()
  {
    $obj = $this->getCurrentBlogI18n();

    return ($obj ? $obj->getShortDescription() : null);
  }

  public function setShortDescription($value)
  {
    $this->getCurrentBlogI18n()->setShortDescription($value);
  }

  public function getLongDescription()
  {
    $obj = $this->getCurrentBlogI18n();

    return ($obj ? $obj->getLongDescription() : null);
  }

  public function setLongDescription($value)
  {
    $this->getCurrentBlogI18n()->setLongDescription($value);
  }

  public function getUrl()
  {
    $obj = $this->getCurrentBlogI18n();

    return ($obj ? $obj->getUrl() : null);
  }

  public function setUrl($value)
  {
    $this->getCurrentBlogI18n()->setUrl($value);
  }

  public $current_i18n = array();

  public function getCurrentBlogI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = BlogI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setBlogI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setBlogI18nForCulture(new BlogI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setBlogI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addBlogI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Blog.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseBlog:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseBlog::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseBlog
