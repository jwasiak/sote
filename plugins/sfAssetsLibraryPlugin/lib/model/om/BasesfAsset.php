<?php

/**
 * Base class that represents a row from the 'sf_asset' table.
 *
 * 
 *
 * @package    plugins.sfAssetsLibraryPlugin.lib.model.om
 */
abstract class BasesfAsset extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        sfAssetPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the folder_id field.
	 * @var        int
	 */
	protected $folder_id;


	/**
	 * The value for the filename field.
	 * @var        string
	 */
	protected $filename;


	/**
	 * The value for the opt_description field.
	 * @var        string
	 */
	protected $opt_description;


	/**
	 * The value for the author field.
	 * @var        string
	 */
	protected $author;


	/**
	 * The value for the copyright field.
	 * @var        string
	 */
	protected $copyright;


	/**
	 * The value for the type field.
	 * @var        string
	 */
	protected $type;


	/**
	 * The value for the filesize field.
	 * @var        double
	 */
	protected $filesize;


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
	protected $asfAssetFolder;

	/**
	 * Collection to store aggregation of collsfAssetI18ns.
	 * @var        array
	 */
	protected $collsfAssetI18ns;

	/**
	 * The criteria used to select the current contents of collsfAssetI18ns.
	 * @var        Criteria
	 */
	protected $lastsfAssetI18nCriteria = null;

	/**
	 * Collection to store aggregation of collCategorys.
	 * @var        array
	 */
	protected $collCategorys;

	/**
	 * The criteria used to select the current contents of collCategorys.
	 * @var        Criteria
	 */
	protected $lastCategoryCriteria = null;

	/**
	 * Collection to store aggregation of collProductHasSfAssets.
	 * @var        array
	 */
	protected $collProductHasSfAssets;

	/**
	 * The criteria used to select the current contents of collProductHasSfAssets.
	 * @var        Criteria
	 */
	protected $lastProductHasSfAssetCriteria = null;

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
	 * Collection to store aggregation of collProductOptionsValues.
	 * @var        array
	 */
	protected $collProductOptionsValues;

	/**
	 * The criteria used to select the current contents of collProductOptionsValues.
	 * @var        Criteria
	 */
	protected $lastProductOptionsValueCriteria = null;

	/**
	 * Collection to store aggregation of collProducers.
	 * @var        array
	 */
	protected $collProducers;

	/**
	 * The criteria used to select the current contents of collProducers.
	 * @var        Criteria
	 */
	protected $lastProducerCriteria = null;

	/**
	 * Collection to store aggregation of collBlogs.
	 * @var        array
	 */
	protected $collBlogs;

	/**
	 * The criteria used to select the current contents of collBlogs.
	 * @var        Criteria
	 */
	protected $lastBlogCriteria = null;

	/**
	 * Collection to store aggregation of collAvailabilitys.
	 * @var        array
	 */
	protected $collAvailabilitys;

	/**
	 * The criteria used to select the current contents of collAvailabilitys.
	 * @var        Criteria
	 */
	protected $lastAvailabilityCriteria = null;

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
     * Get the [id] column value.
     * 
     * @return     int
     */
    public function getId()
    {

            return $this->id;
    }

    /**
     * Get the [folder_id] column value.
     * 
     * @return     int
     */
    public function getFolderId()
    {

            return $this->folder_id;
    }

    /**
     * Get the [filename] column value.
     * 
     * @return     string
     */
    public function getFilename()
    {

            return $this->filename;
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
     * Get the [author] column value.
     * 
     * @return     string
     */
    public function getAuthor()
    {

            return $this->author;
    }

    /**
     * Get the [copyright] column value.
     * 
     * @return     string
     */
    public function getCopyright()
    {

            return $this->copyright;
    }

    /**
     * Get the [type] column value.
     * 
     * @return     string
     */
    public function getType()
    {

            return $this->type;
    }

    /**
     * Get the [filesize] column value.
     * 
     * @return     double
     */
    public function getFilesize()
    {

            return null !== $this->filesize ? (string)$this->filesize : null;
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
          $this->modifiedColumns[] = sfAssetPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [folder_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setFolderId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->folder_id !== $v) {
          $this->folder_id = $v;
          $this->modifiedColumns[] = sfAssetPeer::FOLDER_ID;
        }

		if ($this->asfAssetFolder !== null && $this->asfAssetFolder->getId() !== $v) {
			$this->asfAssetFolder = null;
		}

	} // setFolderId()

	/**
	 * Set the value of [filename] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFilename($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->filename !== $v) {
          $this->filename = $v;
          $this->modifiedColumns[] = sfAssetPeer::FILENAME;
        }

	} // setFilename()

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
          $this->modifiedColumns[] = sfAssetPeer::OPT_DESCRIPTION;
        }

	} // setOptDescription()

	/**
	 * Set the value of [author] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setAuthor($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->author !== $v) {
          $this->author = $v;
          $this->modifiedColumns[] = sfAssetPeer::AUTHOR;
        }

	} // setAuthor()

	/**
	 * Set the value of [copyright] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCopyright($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->copyright !== $v) {
          $this->copyright = $v;
          $this->modifiedColumns[] = sfAssetPeer::COPYRIGHT;
        }

	} // setCopyright()

	/**
	 * Set the value of [type] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setType($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->type !== $v) {
          $this->type = $v;
          $this->modifiedColumns[] = sfAssetPeer::TYPE;
        }

	} // setType()

	/**
	 * Set the value of [filesize] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setFilesize($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->filesize !== $v) {
          $this->filesize = $v;
          $this->modifiedColumns[] = sfAssetPeer::FILESIZE;
        }

	} // setFilesize()

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
			$this->modifiedColumns[] = sfAssetPeer::CREATED_AT;
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
			$this->modifiedColumns[] = sfAssetPeer::UPDATED_AT;
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
      if ($this->getDispatcher()->getListeners('sfAsset.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'sfAsset.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->folder_id = $rs->getInt($startcol + 1);

      $this->filename = $rs->getString($startcol + 2);

      $this->opt_description = $rs->getString($startcol + 3);

      $this->author = $rs->getString($startcol + 4);

      $this->copyright = $rs->getString($startcol + 5);

      $this->type = $rs->getString($startcol + 6);

      $this->filesize = $rs->getString($startcol + 7);
      if (null !== $this->filesize && $this->filesize == intval($this->filesize))
      {
        $this->filesize = (string)intval($this->filesize);
      }

      $this->created_at = $rs->getTimestamp($startcol + 8, null);

      $this->updated_at = $rs->getTimestamp($startcol + 9, null);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('sfAsset.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'sfAsset.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 10)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 10; // 10 = sfAssetPeer::NUM_COLUMNS - sfAssetPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating sfAsset object", $e);
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

    if ($this->getDispatcher()->getListeners('sfAsset.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'sfAsset.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasesfAsset:delete:pre'))
    {
      foreach (sfMixer::getCallables('BasesfAsset:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(sfAssetPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      sfAssetPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('sfAsset.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'sfAsset.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasesfAsset:delete:post'))
    {
      foreach (sfMixer::getCallables('BasesfAsset:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('sfAsset.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'sfAsset.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BasesfAsset:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(sfAssetPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(sfAssetPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(sfAssetPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('sfAsset.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'sfAsset.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BasesfAsset:save:post') as $callable)
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

			if ($this->asfAssetFolder !== null) {
				if ($this->asfAssetFolder->isModified()) {
					$affectedRows += $this->asfAssetFolder->save($con);
				}
				$this->setsfAssetFolder($this->asfAssetFolder);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfAssetPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += sfAssetPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collsfAssetI18ns !== null) {
				foreach($this->collsfAssetI18ns as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collCategorys !== null) {
				foreach($this->collCategorys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductHasSfAssets !== null) {
				foreach($this->collProductHasSfAssets as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductHasAttachments !== null) {
				foreach($this->collProductHasAttachments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductOptionsValues !== null) {
				foreach($this->collProductOptionsValues as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProducers !== null) {
				foreach($this->collProducers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collBlogs !== null) {
				foreach($this->collBlogs as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAvailabilitys !== null) {
				foreach($this->collAvailabilitys as $referrerFK) {
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

			if ($this->asfAssetFolder !== null) {
				if (!$this->asfAssetFolder->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfAssetFolder->getValidationFailures());
				}
			}


			if (($retval = sfAssetPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collsfAssetI18ns !== null) {
					foreach($this->collsfAssetI18ns as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collCategorys !== null) {
					foreach($this->collCategorys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductHasSfAssets !== null) {
					foreach($this->collProductHasSfAssets as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductHasAttachments !== null) {
					foreach($this->collProductHasAttachments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductOptionsValues !== null) {
					foreach($this->collProductOptionsValues as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProducers !== null) {
					foreach($this->collProducers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collBlogs !== null) {
					foreach($this->collBlogs as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAvailabilitys !== null) {
					foreach($this->collAvailabilitys as $referrerFK) {
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
		$pos = sfAssetPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getFolderId();
				break;
			case 2:
				return $this->getFilename();
				break;
			case 3:
				return $this->getOptDescription();
				break;
			case 4:
				return $this->getAuthor();
				break;
			case 5:
				return $this->getCopyright();
				break;
			case 6:
				return $this->getType();
				break;
			case 7:
				return $this->getFilesize();
				break;
			case 8:
				return $this->getCreatedAt();
				break;
			case 9:
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
		$keys = sfAssetPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getFolderId(),
			$keys[2] => $this->getFilename(),
			$keys[3] => $this->getOptDescription(),
			$keys[4] => $this->getAuthor(),
			$keys[5] => $this->getCopyright(),
			$keys[6] => $this->getType(),
			$keys[7] => $this->getFilesize(),
			$keys[8] => $this->getCreatedAt(),
			$keys[9] => $this->getUpdatedAt(),
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
		$pos = sfAssetPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setFolderId($value);
				break;
			case 2:
				$this->setFilename($value);
				break;
			case 3:
				$this->setOptDescription($value);
				break;
			case 4:
				$this->setAuthor($value);
				break;
			case 5:
				$this->setCopyright($value);
				break;
			case 6:
				$this->setType($value);
				break;
			case 7:
				$this->setFilesize($value);
				break;
			case 8:
				$this->setCreatedAt($value);
				break;
			case 9:
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
		$keys = sfAssetPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setFolderId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setFilename($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setOptDescription($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setAuthor($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCopyright($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setType($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setFilesize($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCreatedAt($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setUpdatedAt($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(sfAssetPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfAssetPeer::ID)) $criteria->add(sfAssetPeer::ID, $this->id);
		if ($this->isColumnModified(sfAssetPeer::FOLDER_ID)) $criteria->add(sfAssetPeer::FOLDER_ID, $this->folder_id);
		if ($this->isColumnModified(sfAssetPeer::FILENAME)) $criteria->add(sfAssetPeer::FILENAME, $this->filename);
		if ($this->isColumnModified(sfAssetPeer::OPT_DESCRIPTION)) $criteria->add(sfAssetPeer::OPT_DESCRIPTION, $this->opt_description);
		if ($this->isColumnModified(sfAssetPeer::AUTHOR)) $criteria->add(sfAssetPeer::AUTHOR, $this->author);
		if ($this->isColumnModified(sfAssetPeer::COPYRIGHT)) $criteria->add(sfAssetPeer::COPYRIGHT, $this->copyright);
		if ($this->isColumnModified(sfAssetPeer::TYPE)) $criteria->add(sfAssetPeer::TYPE, $this->type);
		if ($this->isColumnModified(sfAssetPeer::FILESIZE)) $criteria->add(sfAssetPeer::FILESIZE, $this->filesize);
		if ($this->isColumnModified(sfAssetPeer::CREATED_AT)) $criteria->add(sfAssetPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(sfAssetPeer::UPDATED_AT)) $criteria->add(sfAssetPeer::UPDATED_AT, $this->updated_at);

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
		$criteria = new Criteria(sfAssetPeer::DATABASE_NAME);

		$criteria->add(sfAssetPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of sfAsset (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setFolderId($this->folder_id);

		$copyObj->setFilename($this->filename);

		$copyObj->setOptDescription($this->opt_description);

		$copyObj->setAuthor($this->author);

		$copyObj->setCopyright($this->copyright);

		$copyObj->setType($this->type);

		$copyObj->setFilesize($this->filesize);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getsfAssetI18ns() as $relObj) {
				$copyObj->addsfAssetI18n($relObj->copy($deepCopy));
			}

			foreach($this->getCategorys() as $relObj) {
				$copyObj->addCategory($relObj->copy($deepCopy));
			}

			foreach($this->getProductHasSfAssets() as $relObj) {
				$copyObj->addProductHasSfAsset($relObj->copy($deepCopy));
			}

			foreach($this->getProductHasAttachments() as $relObj) {
				$copyObj->addProductHasAttachment($relObj->copy($deepCopy));
			}

			foreach($this->getProductOptionsValues() as $relObj) {
				$copyObj->addProductOptionsValue($relObj->copy($deepCopy));
			}

			foreach($this->getProducers() as $relObj) {
				$copyObj->addProducer($relObj->copy($deepCopy));
			}

			foreach($this->getBlogs() as $relObj) {
				$copyObj->addBlog($relObj->copy($deepCopy));
			}

			foreach($this->getAvailabilitys() as $relObj) {
				$copyObj->addAvailability($relObj->copy($deepCopy));
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
	 * @return     sfAsset Clone of current object.
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
	 * @return     sfAssetPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new sfAssetPeer();
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
	public function setsfAssetFolder($v)
	{


		if ($v === null) {
			$this->setFolderId(NULL);
		} else {
			$this->setFolderId($v->getId());
		}


		$this->asfAssetFolder = $v;
	}


	/**
	 * Get the associated sfAssetFolder object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     sfAssetFolder The associated sfAssetFolder object.
	 * @throws     PropelException
	 */
	public function getsfAssetFolder($con = null)
	{
		if ($this->asfAssetFolder === null && ($this->folder_id !== null)) {
			// include the related Peer class
			$this->asfAssetFolder = sfAssetFolderPeer::retrieveByPK($this->folder_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = sfAssetFolderPeer::retrieveByPK($this->folder_id, $con);
			   $obj->addsfAssetFolders($this);
			 */
		}
		return $this->asfAssetFolder;
	}

	/**
	 * Temporary storage of collsfAssetI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initsfAssetI18ns()
	{
		if ($this->collsfAssetI18ns === null) {
			$this->collsfAssetI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAsset has previously
	 * been saved, it will retrieve related sfAssetI18ns from storage.
	 * If this sfAsset is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getsfAssetI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfAssetI18ns === null) {
			if ($this->isNew()) {
			   $this->collsfAssetI18ns = array();
			} else {

				$criteria->add(sfAssetI18nPeer::ID, $this->getId());

				sfAssetI18nPeer::addSelectColumns($criteria);
				$this->collsfAssetI18ns = sfAssetI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(sfAssetI18nPeer::ID, $this->getId());

				sfAssetI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfAssetI18nCriteria) || !$this->lastsfAssetI18nCriteria->equals($criteria)) {
					$this->collsfAssetI18ns = sfAssetI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfAssetI18nCriteria = $criteria;
		return $this->collsfAssetI18ns;
	}

	/**
	 * Returns the number of related sfAssetI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countsfAssetI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfAssetI18nPeer::ID, $this->getId());

		return sfAssetI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a sfAssetI18n object to this object
	 * through the sfAssetI18n foreign key attribute
	 *
	 * @param      sfAssetI18n $l sfAssetI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addsfAssetI18n(sfAssetI18n $l)
	{
		$this->collsfAssetI18ns[] = $l;
		$l->setsfAsset($this);
	}

	/**
	 * Temporary storage of collCategorys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initCategorys()
	{
		if ($this->collCategorys === null) {
			$this->collCategorys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAsset has previously
	 * been saved, it will retrieve related Categorys from storage.
	 * If this sfAsset is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getCategorys($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCategorys === null) {
			if ($this->isNew()) {
			   $this->collCategorys = array();
			} else {

				$criteria->add(CategoryPeer::SF_ASSET_ID, $this->getId());

				CategoryPeer::addSelectColumns($criteria);
				$this->collCategorys = CategoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(CategoryPeer::SF_ASSET_ID, $this->getId());

				CategoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastCategoryCriteria) || !$this->lastCategoryCriteria->equals($criteria)) {
					$this->collCategorys = CategoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCategoryCriteria = $criteria;
		return $this->collCategorys;
	}

	/**
	 * Returns the number of related Categorys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countCategorys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CategoryPeer::SF_ASSET_ID, $this->getId());

		return CategoryPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Category object to this object
	 * through the Category foreign key attribute
	 *
	 * @param      Category $l Category
	 * @return     void
	 * @throws     PropelException
	 */
	public function addCategory(Category $l)
	{
		$this->collCategorys[] = $l;
		$l->setsfAsset($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAsset is new, it will return
	 * an empty collection; or if this sfAsset has previously
	 * been saved, it will retrieve related Categorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfAsset.
	 */
	public function getCategorysJoinCategoryRelatedByParentId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCategorys === null) {
			if ($this->isNew()) {
				$this->collCategorys = array();
			} else {

				$criteria->add(CategoryPeer::SF_ASSET_ID, $this->getId());

				$this->collCategorys = CategoryPeer::doSelectJoinCategoryRelatedByParentId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(CategoryPeer::SF_ASSET_ID, $this->getId());

			if (!isset($this->lastCategoryCriteria) || !$this->lastCategoryCriteria->equals($criteria)) {
				$this->collCategorys = CategoryPeer::doSelectJoinCategoryRelatedByParentId($criteria, $con);
			}
		}
		$this->lastCategoryCriteria = $criteria;

		return $this->collCategorys;
	}

	/**
	 * Temporary storage of collProductHasSfAssets to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductHasSfAssets()
	{
		if ($this->collProductHasSfAssets === null) {
			$this->collProductHasSfAssets = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAsset has previously
	 * been saved, it will retrieve related ProductHasSfAssets from storage.
	 * If this sfAsset is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductHasSfAssets($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasSfAssets === null) {
			if ($this->isNew()) {
			   $this->collProductHasSfAssets = array();
			} else {

				$criteria->add(ProductHasSfAssetPeer::SF_ASSET_ID, $this->getId());

				ProductHasSfAssetPeer::addSelectColumns($criteria);
				$this->collProductHasSfAssets = ProductHasSfAssetPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasSfAssetPeer::SF_ASSET_ID, $this->getId());

				ProductHasSfAssetPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductHasSfAssetCriteria) || !$this->lastProductHasSfAssetCriteria->equals($criteria)) {
					$this->collProductHasSfAssets = ProductHasSfAssetPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductHasSfAssetCriteria = $criteria;
		return $this->collProductHasSfAssets;
	}

	/**
	 * Returns the number of related ProductHasSfAssets.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductHasSfAssets($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductHasSfAssetPeer::SF_ASSET_ID, $this->getId());

		return ProductHasSfAssetPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductHasSfAsset object to this object
	 * through the ProductHasSfAsset foreign key attribute
	 *
	 * @param      ProductHasSfAsset $l ProductHasSfAsset
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductHasSfAsset(ProductHasSfAsset $l)
	{
		$this->collProductHasSfAssets[] = $l;
		$l->setsfAsset($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAsset is new, it will return
	 * an empty collection; or if this sfAsset has previously
	 * been saved, it will retrieve related ProductHasSfAssets from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfAsset.
	 */
	public function getProductHasSfAssetsJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasSfAssets === null) {
			if ($this->isNew()) {
				$this->collProductHasSfAssets = array();
			} else {

				$criteria->add(ProductHasSfAssetPeer::SF_ASSET_ID, $this->getId());

				$this->collProductHasSfAssets = ProductHasSfAssetPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductHasSfAssetPeer::SF_ASSET_ID, $this->getId());

			if (!isset($this->lastProductHasSfAssetCriteria) || !$this->lastProductHasSfAssetCriteria->equals($criteria)) {
				$this->collProductHasSfAssets = ProductHasSfAssetPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastProductHasSfAssetCriteria = $criteria;

		return $this->collProductHasSfAssets;
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
	 * Otherwise if this sfAsset has previously
	 * been saved, it will retrieve related ProductHasAttachments from storage.
	 * If this sfAsset is new, it will return
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

				$criteria->add(ProductHasAttachmentPeer::SF_ASSET_ID, $this->getId());

				ProductHasAttachmentPeer::addSelectColumns($criteria);
				$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasAttachmentPeer::SF_ASSET_ID, $this->getId());

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

		$criteria->add(ProductHasAttachmentPeer::SF_ASSET_ID, $this->getId());

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
		$l->setsfAsset($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAsset is new, it will return
	 * an empty collection; or if this sfAsset has previously
	 * been saved, it will retrieve related ProductHasAttachments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfAsset.
	 */
	public function getProductHasAttachmentsJoinLanguage($criteria = null, $con = null)
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

				$criteria->add(ProductHasAttachmentPeer::SF_ASSET_ID, $this->getId());

				$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelectJoinLanguage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductHasAttachmentPeer::SF_ASSET_ID, $this->getId());

			if (!isset($this->lastProductHasAttachmentCriteria) || !$this->lastProductHasAttachmentCriteria->equals($criteria)) {
				$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelectJoinLanguage($criteria, $con);
			}
		}
		$this->lastProductHasAttachmentCriteria = $criteria;

		return $this->collProductHasAttachments;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAsset is new, it will return
	 * an empty collection; or if this sfAsset has previously
	 * been saved, it will retrieve related ProductHasAttachments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfAsset.
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

				$criteria->add(ProductHasAttachmentPeer::SF_ASSET_ID, $this->getId());

				$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductHasAttachmentPeer::SF_ASSET_ID, $this->getId());

			if (!isset($this->lastProductHasAttachmentCriteria) || !$this->lastProductHasAttachmentCriteria->equals($criteria)) {
				$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastProductHasAttachmentCriteria = $criteria;

		return $this->collProductHasAttachments;
	}

	/**
	 * Temporary storage of collProductOptionsValues to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductOptionsValues()
	{
		if ($this->collProductOptionsValues === null) {
			$this->collProductOptionsValues = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAsset has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 * If this sfAsset is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductOptionsValues($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
			   $this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::SF_ASSET_ID, $this->getId());

				ProductOptionsValuePeer::addSelectColumns($criteria);
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductOptionsValuePeer::SF_ASSET_ID, $this->getId());

				ProductOptionsValuePeer::addSelectColumns($criteria);
				if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
					$this->collProductOptionsValues = ProductOptionsValuePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;
		return $this->collProductOptionsValues;
	}

	/**
	 * Returns the number of related ProductOptionsValues.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductOptionsValues($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductOptionsValuePeer::SF_ASSET_ID, $this->getId());

		return ProductOptionsValuePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductOptionsValue object to this object
	 * through the ProductOptionsValue foreign key attribute
	 *
	 * @param      ProductOptionsValue $l ProductOptionsValue
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductOptionsValue(ProductOptionsValue $l)
	{
		$this->collProductOptionsValues[] = $l;
		$l->setsfAsset($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAsset is new, it will return
	 * an empty collection; or if this sfAsset has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfAsset.
	 */
	public function getProductOptionsValuesJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::SF_ASSET_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::SF_ASSET_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAsset is new, it will return
	 * an empty collection; or if this sfAsset has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfAsset.
	 */
	public function getProductOptionsValuesJoinProductOptionsTemplate($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::SF_ASSET_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsTemplate($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::SF_ASSET_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsTemplate($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAsset is new, it will return
	 * an empty collection; or if this sfAsset has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfAsset.
	 */
	public function getProductOptionsValuesJoinProductOptionsValueRelatedByProductOptionsValueId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::SF_ASSET_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsValueRelatedByProductOptionsValueId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::SF_ASSET_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsValueRelatedByProductOptionsValueId($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAsset is new, it will return
	 * an empty collection; or if this sfAsset has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in sfAsset.
	 */
	public function getProductOptionsValuesJoinProductOptionsField($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::SF_ASSET_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsField($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::SF_ASSET_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsField($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}

	/**
	 * Temporary storage of collProducers to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProducers()
	{
		if ($this->collProducers === null) {
			$this->collProducers = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAsset has previously
	 * been saved, it will retrieve related Producers from storage.
	 * If this sfAsset is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProducers($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducers === null) {
			if ($this->isNew()) {
			   $this->collProducers = array();
			} else {

				$criteria->add(ProducerPeer::SF_ASSET_ID, $this->getId());

				ProducerPeer::addSelectColumns($criteria);
				$this->collProducers = ProducerPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProducerPeer::SF_ASSET_ID, $this->getId());

				ProducerPeer::addSelectColumns($criteria);
				if (!isset($this->lastProducerCriteria) || !$this->lastProducerCriteria->equals($criteria)) {
					$this->collProducers = ProducerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProducerCriteria = $criteria;
		return $this->collProducers;
	}

	/**
	 * Returns the number of related Producers.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProducers($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProducerPeer::SF_ASSET_ID, $this->getId());

		return ProducerPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Producer object to this object
	 * through the Producer foreign key attribute
	 *
	 * @param      Producer $l Producer
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProducer(Producer $l)
	{
		$this->collProducers[] = $l;
		$l->setsfAsset($this);
	}

	/**
	 * Temporary storage of collBlogs to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initBlogs()
	{
		if ($this->collBlogs === null) {
			$this->collBlogs = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAsset has previously
	 * been saved, it will retrieve related Blogs from storage.
	 * If this sfAsset is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getBlogs($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBlogs === null) {
			if ($this->isNew()) {
			   $this->collBlogs = array();
			} else {

				$criteria->add(BlogPeer::SF_ASSET_ID, $this->getId());

				BlogPeer::addSelectColumns($criteria);
				$this->collBlogs = BlogPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(BlogPeer::SF_ASSET_ID, $this->getId());

				BlogPeer::addSelectColumns($criteria);
				if (!isset($this->lastBlogCriteria) || !$this->lastBlogCriteria->equals($criteria)) {
					$this->collBlogs = BlogPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastBlogCriteria = $criteria;
		return $this->collBlogs;
	}

	/**
	 * Returns the number of related Blogs.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countBlogs($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(BlogPeer::SF_ASSET_ID, $this->getId());

		return BlogPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Blog object to this object
	 * through the Blog foreign key attribute
	 *
	 * @param      Blog $l Blog
	 * @return     void
	 * @throws     PropelException
	 */
	public function addBlog(Blog $l)
	{
		$this->collBlogs[] = $l;
		$l->setsfAsset($this);
	}

	/**
	 * Temporary storage of collAvailabilitys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initAvailabilitys()
	{
		if ($this->collAvailabilitys === null) {
			$this->collAvailabilitys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this sfAsset has previously
	 * been saved, it will retrieve related Availabilitys from storage.
	 * If this sfAsset is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getAvailabilitys($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAvailabilitys === null) {
			if ($this->isNew()) {
			   $this->collAvailabilitys = array();
			} else {

				$criteria->add(AvailabilityPeer::SF_ASSET_ID, $this->getId());

				AvailabilityPeer::addSelectColumns($criteria);
				$this->collAvailabilitys = AvailabilityPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AvailabilityPeer::SF_ASSET_ID, $this->getId());

				AvailabilityPeer::addSelectColumns($criteria);
				if (!isset($this->lastAvailabilityCriteria) || !$this->lastAvailabilityCriteria->equals($criteria)) {
					$this->collAvailabilitys = AvailabilityPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAvailabilityCriteria = $criteria;
		return $this->collAvailabilitys;
	}

	/**
	 * Returns the number of related Availabilitys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countAvailabilitys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AvailabilityPeer::SF_ASSET_ID, $this->getId());

		return AvailabilityPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Availability object to this object
	 * through the Availability foreign key attribute
	 *
	 * @param      Availability $l Availability
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAvailability(Availability $l)
	{
		$this->collAvailabilitys[] = $l;
		$l->setsfAsset($this);
	}

  public function getCulture()
  {
    return $this->culture;
  }

  public function setCulture($culture)
  {
    $this->culture = $culture;
  }

  public function getDescription()
  {
    $obj = $this->getCurrentsfAssetI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentsfAssetI18n()->setDescription($value);
  }

  public $current_i18n = array();

  public function getCurrentsfAssetI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = sfAssetI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setsfAssetI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setsfAssetI18nForCulture(new sfAssetI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setsfAssetI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addsfAssetI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'sfAsset.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BasesfAsset:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BasesfAsset::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BasesfAsset
