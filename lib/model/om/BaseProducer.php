<?php

/**
 * Base class that represents a row from the 'st_producer' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseProducer extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ProducerPeer
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
	 * The value for the image field.
	 * @var        string
	 */
	protected $image;


	/**
	 * The value for the link field.
	 * @var        string
	 */
	protected $link;


	/**
	 * The value for the opt_name field.
	 * @var        string
	 */
	protected $opt_name;


	/**
	 * The value for the opt_url field.
	 * @var        string
	 */
	protected $opt_url;


	/**
	 * The value for the opt_description field.
	 * @var        string
	 */
	protected $opt_description;


	/**
	 * The value for the opt_image_crop field.
	 * @var        string
	 */
	protected $opt_image_crop;

	/**
	 * @var        sfAsset
	 */
	protected $asfAsset;

	/**
	 * Collection to store aggregation of collDiscountHasProducers.
	 * @var        array
	 */
	protected $collDiscountHasProducers;

	/**
	 * The criteria used to select the current contents of collDiscountHasProducers.
	 * @var        Criteria
	 */
	protected $lastDiscountHasProducerCriteria = null;

	/**
	 * Collection to store aggregation of collDiscountCouponCodeHasProducers.
	 * @var        array
	 */
	protected $collDiscountCouponCodeHasProducers;

	/**
	 * The criteria used to select the current contents of collDiscountCouponCodeHasProducers.
	 * @var        Criteria
	 */
	protected $lastDiscountCouponCodeHasProducerCriteria = null;

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
	 * Collection to store aggregation of collGiftCardHasProducers.
	 * @var        array
	 */
	protected $collGiftCardHasProducers;

	/**
	 * The criteria used to select the current contents of collGiftCardHasProducers.
	 * @var        Criteria
	 */
	protected $lastGiftCardHasProducerCriteria = null;

	/**
	 * Collection to store aggregation of collProducerI18ns.
	 * @var        array
	 */
	protected $collProducerI18ns;

	/**
	 * The criteria used to select the current contents of collProducerI18ns.
	 * @var        Criteria
	 */
	protected $lastProducerI18nCriteria = null;

	/**
	 * Collection to store aggregation of collProducerHasPositionings.
	 * @var        array
	 */
	protected $collProducerHasPositionings;

	/**
	 * The criteria used to select the current contents of collProducerHasPositionings.
	 * @var        Criteria
	 */
	protected $lastProducerHasPositioningCriteria = null;

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
     * Get the [image] column value.
     * 
     * @return     string
     */
    public function getImage()
    {

            return $this->image;
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
     * Get the [opt_name] column value.
     * 
     * @return     string
     */
    public function getOptName()
    {

            return $this->opt_name;
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
     * Get the [opt_description] column value.
     * 
     * @return     string
     */
    public function getOptDescription()
    {

            return $this->opt_description;
    }

    /**
     * Get the [opt_image_crop] column value.
     * 
     * @return     string
     */
    public function getImageCrop()
    {

            return $this->opt_image_crop;
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
			$this->modifiedColumns[] = ProducerPeer::CREATED_AT;
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
			$this->modifiedColumns[] = ProducerPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = ProducerPeer::ID;
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
          $this->modifiedColumns[] = ProducerPeer::SF_ASSET_ID;
        }

		if ($this->asfAsset !== null && $this->asfAsset->getId() !== $v) {
			$this->asfAsset = null;
		}

	} // setSfAssetId()

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
          $this->modifiedColumns[] = ProducerPeer::IMAGE;
        }

	} // setImage()

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
          $this->modifiedColumns[] = ProducerPeer::LINK;
        }

	} // setLink()

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
          $this->modifiedColumns[] = ProducerPeer::OPT_NAME;
        }

	} // setOptName()

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
          $this->modifiedColumns[] = ProducerPeer::OPT_URL;
        }

	} // setOptUrl()

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
          $this->modifiedColumns[] = ProducerPeer::OPT_DESCRIPTION;
        }

	} // setOptDescription()

	/**
	 * Set the value of [opt_image_crop] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setImageCrop($v)
	{

        if ($this->opt_image_crop !== $v) {
          $this->opt_image_crop = $v;
          $this->modifiedColumns[] = ProducerPeer::OPT_IMAGE_CROP;
        }

	} // setImageCrop()

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
      if ($this->getDispatcher()->getListeners('Producer.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Producer.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->sf_asset_id = $rs->getInt($startcol + 3);

      $this->image = $rs->getString($startcol + 4);

      $this->link = $rs->getString($startcol + 5);

      $this->opt_name = $rs->getString($startcol + 6);

      $this->opt_url = $rs->getString($startcol + 7);

      $this->opt_description = $rs->getString($startcol + 8);

      $this->opt_image_crop = $rs->getString($startcol + 9) ? unserialize($rs->getString($startcol + 9)) : null;

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Producer.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Producer.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 10)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 10; // 10 = ProducerPeer::NUM_COLUMNS - ProducerPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Producer object", $e);
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

    if ($this->getDispatcher()->getListeners('Producer.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Producer.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProducer:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseProducer:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ProducerPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ProducerPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Producer.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Producer.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProducer:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseProducer:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Producer.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Producer.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseProducer:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(ProducerPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ProducerPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(ProducerPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Producer.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Producer.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseProducer:save:post') as $callable)
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
              $o_opt_image_crop = $this->opt_image_crop;
              if (null !== $this->opt_image_crop && $this->isColumnModified(ProducerPeer::OPT_IMAGE_CROP)) {
                  $this->opt_image_crop = serialize($this->opt_image_crop);
              }

				if ($this->isNew()) {
					$pk = ProducerPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ProducerPeer::doUpdate($this, $con);
				}
				$this->resetModified();
             $this->opt_image_crop = $o_opt_image_crop;
 // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collDiscountHasProducers !== null) {
				foreach($this->collDiscountHasProducers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDiscountCouponCodeHasProducers !== null) {
				foreach($this->collDiscountCouponCodeHasProducers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProducts !== null) {
				foreach($this->collProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGiftCardHasProducers !== null) {
				foreach($this->collGiftCardHasProducers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProducerI18ns !== null) {
				foreach($this->collProducerI18ns as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProducerHasPositionings !== null) {
				foreach($this->collProducerHasPositionings as $referrerFK) {
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


			if (($retval = ProducerPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collDiscountHasProducers !== null) {
					foreach($this->collDiscountHasProducers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDiscountCouponCodeHasProducers !== null) {
					foreach($this->collDiscountCouponCodeHasProducers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProducts !== null) {
					foreach($this->collProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGiftCardHasProducers !== null) {
					foreach($this->collGiftCardHasProducers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProducerI18ns !== null) {
					foreach($this->collProducerI18ns as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProducerHasPositionings !== null) {
					foreach($this->collProducerHasPositionings as $referrerFK) {
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
		$pos = ProducerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getImage();
				break;
			case 5:
				return $this->getLink();
				break;
			case 6:
				return $this->getOptName();
				break;
			case 7:
				return $this->getOptUrl();
				break;
			case 8:
				return $this->getOptDescription();
				break;
			case 9:
				return $this->getImageCrop();
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
		$keys = ProducerPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getSfAssetId(),
			$keys[4] => $this->getImage(),
			$keys[5] => $this->getLink(),
			$keys[6] => $this->getOptName(),
			$keys[7] => $this->getOptUrl(),
			$keys[8] => $this->getOptDescription(),
			$keys[9] => $this->getImageCrop(),
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
		$pos = ProducerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setImage($value);
				break;
			case 5:
				$this->setLink($value);
				break;
			case 6:
				$this->setOptName($value);
				break;
			case 7:
				$this->setOptUrl($value);
				break;
			case 8:
				$this->setOptDescription($value);
				break;
			case 9:
				$this->setImageCrop($value);
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
		$keys = ProducerPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSfAssetId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setImage($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setLink($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setOptName($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setOptUrl($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setOptDescription($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setImageCrop($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ProducerPeer::DATABASE_NAME);

		if ($this->isColumnModified(ProducerPeer::CREATED_AT)) $criteria->add(ProducerPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ProducerPeer::UPDATED_AT)) $criteria->add(ProducerPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(ProducerPeer::ID)) $criteria->add(ProducerPeer::ID, $this->id);
		if ($this->isColumnModified(ProducerPeer::SF_ASSET_ID)) $criteria->add(ProducerPeer::SF_ASSET_ID, $this->sf_asset_id);
		if ($this->isColumnModified(ProducerPeer::IMAGE)) $criteria->add(ProducerPeer::IMAGE, $this->image);
		if ($this->isColumnModified(ProducerPeer::LINK)) $criteria->add(ProducerPeer::LINK, $this->link);
		if ($this->isColumnModified(ProducerPeer::OPT_NAME)) $criteria->add(ProducerPeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(ProducerPeer::OPT_URL)) $criteria->add(ProducerPeer::OPT_URL, $this->opt_url);
		if ($this->isColumnModified(ProducerPeer::OPT_DESCRIPTION)) $criteria->add(ProducerPeer::OPT_DESCRIPTION, $this->opt_description);
		if ($this->isColumnModified(ProducerPeer::OPT_IMAGE_CROP)) $criteria->add(ProducerPeer::OPT_IMAGE_CROP, $this->opt_image_crop);

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
		$criteria = new Criteria(ProducerPeer::DATABASE_NAME);

		$criteria->add(ProducerPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Producer (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setSfAssetId($this->sf_asset_id);

		$copyObj->setImage($this->image);

		$copyObj->setLink($this->link);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setOptUrl($this->opt_url);

		$copyObj->setOptDescription($this->opt_description);

		$copyObj->setImageCrop($this->opt_image_crop);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getDiscountHasProducers() as $relObj) {
				$copyObj->addDiscountHasProducer($relObj->copy($deepCopy));
			}

			foreach($this->getDiscountCouponCodeHasProducers() as $relObj) {
				$copyObj->addDiscountCouponCodeHasProducer($relObj->copy($deepCopy));
			}

			foreach($this->getProducts() as $relObj) {
				$copyObj->addProduct($relObj->copy($deepCopy));
			}

			foreach($this->getGiftCardHasProducers() as $relObj) {
				$copyObj->addGiftCardHasProducer($relObj->copy($deepCopy));
			}

			foreach($this->getProducerI18ns() as $relObj) {
				$copyObj->addProducerI18n($relObj->copy($deepCopy));
			}

			foreach($this->getProducerHasPositionings() as $relObj) {
				$copyObj->addProducerHasPositioning($relObj->copy($deepCopy));
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
	 * @return     Producer Clone of current object.
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
	 * @return     ProducerPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ProducerPeer();
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
	 * Temporary storage of collDiscountHasProducers to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDiscountHasProducers()
	{
		if ($this->collDiscountHasProducers === null) {
			$this->collDiscountHasProducers = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Producer has previously
	 * been saved, it will retrieve related DiscountHasProducers from storage.
	 * If this Producer is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDiscountHasProducers($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountHasProducers === null) {
			if ($this->isNew()) {
			   $this->collDiscountHasProducers = array();
			} else {

				$criteria->add(DiscountHasProducerPeer::PRODUCER_ID, $this->getId());

				DiscountHasProducerPeer::addSelectColumns($criteria);
				$this->collDiscountHasProducers = DiscountHasProducerPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountHasProducerPeer::PRODUCER_ID, $this->getId());

				DiscountHasProducerPeer::addSelectColumns($criteria);
				if (!isset($this->lastDiscountHasProducerCriteria) || !$this->lastDiscountHasProducerCriteria->equals($criteria)) {
					$this->collDiscountHasProducers = DiscountHasProducerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDiscountHasProducerCriteria = $criteria;
		return $this->collDiscountHasProducers;
	}

	/**
	 * Returns the number of related DiscountHasProducers.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDiscountHasProducers($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DiscountHasProducerPeer::PRODUCER_ID, $this->getId());

		return DiscountHasProducerPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DiscountHasProducer object to this object
	 * through the DiscountHasProducer foreign key attribute
	 *
	 * @param      DiscountHasProducer $l DiscountHasProducer
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDiscountHasProducer(DiscountHasProducer $l)
	{
		$this->collDiscountHasProducers[] = $l;
		$l->setProducer($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Producer is new, it will return
	 * an empty collection; or if this Producer has previously
	 * been saved, it will retrieve related DiscountHasProducers from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Producer.
	 */
	public function getDiscountHasProducersJoinDiscount($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountHasProducers === null) {
			if ($this->isNew()) {
				$this->collDiscountHasProducers = array();
			} else {

				$criteria->add(DiscountHasProducerPeer::PRODUCER_ID, $this->getId());

				$this->collDiscountHasProducers = DiscountHasProducerPeer::doSelectJoinDiscount($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DiscountHasProducerPeer::PRODUCER_ID, $this->getId());

			if (!isset($this->lastDiscountHasProducerCriteria) || !$this->lastDiscountHasProducerCriteria->equals($criteria)) {
				$this->collDiscountHasProducers = DiscountHasProducerPeer::doSelectJoinDiscount($criteria, $con);
			}
		}
		$this->lastDiscountHasProducerCriteria = $criteria;

		return $this->collDiscountHasProducers;
	}

	/**
	 * Temporary storage of collDiscountCouponCodeHasProducers to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDiscountCouponCodeHasProducers()
	{
		if ($this->collDiscountCouponCodeHasProducers === null) {
			$this->collDiscountCouponCodeHasProducers = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Producer has previously
	 * been saved, it will retrieve related DiscountCouponCodeHasProducers from storage.
	 * If this Producer is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDiscountCouponCodeHasProducers($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountCouponCodeHasProducers === null) {
			if ($this->isNew()) {
			   $this->collDiscountCouponCodeHasProducers = array();
			} else {

				$criteria->add(DiscountCouponCodeHasProducerPeer::PRODUCER_ID, $this->getId());

				DiscountCouponCodeHasProducerPeer::addSelectColumns($criteria);
				$this->collDiscountCouponCodeHasProducers = DiscountCouponCodeHasProducerPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountCouponCodeHasProducerPeer::PRODUCER_ID, $this->getId());

				DiscountCouponCodeHasProducerPeer::addSelectColumns($criteria);
				if (!isset($this->lastDiscountCouponCodeHasProducerCriteria) || !$this->lastDiscountCouponCodeHasProducerCriteria->equals($criteria)) {
					$this->collDiscountCouponCodeHasProducers = DiscountCouponCodeHasProducerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDiscountCouponCodeHasProducerCriteria = $criteria;
		return $this->collDiscountCouponCodeHasProducers;
	}

	/**
	 * Returns the number of related DiscountCouponCodeHasProducers.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDiscountCouponCodeHasProducers($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DiscountCouponCodeHasProducerPeer::PRODUCER_ID, $this->getId());

		return DiscountCouponCodeHasProducerPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DiscountCouponCodeHasProducer object to this object
	 * through the DiscountCouponCodeHasProducer foreign key attribute
	 *
	 * @param      DiscountCouponCodeHasProducer $l DiscountCouponCodeHasProducer
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDiscountCouponCodeHasProducer(DiscountCouponCodeHasProducer $l)
	{
		$this->collDiscountCouponCodeHasProducers[] = $l;
		$l->setProducer($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Producer is new, it will return
	 * an empty collection; or if this Producer has previously
	 * been saved, it will retrieve related DiscountCouponCodeHasProducers from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Producer.
	 */
	public function getDiscountCouponCodeHasProducersJoinDiscountCouponCode($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountCouponCodeHasProducers === null) {
			if ($this->isNew()) {
				$this->collDiscountCouponCodeHasProducers = array();
			} else {

				$criteria->add(DiscountCouponCodeHasProducerPeer::PRODUCER_ID, $this->getId());

				$this->collDiscountCouponCodeHasProducers = DiscountCouponCodeHasProducerPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DiscountCouponCodeHasProducerPeer::PRODUCER_ID, $this->getId());

			if (!isset($this->lastDiscountCouponCodeHasProducerCriteria) || !$this->lastDiscountCouponCodeHasProducerCriteria->equals($criteria)) {
				$this->collDiscountCouponCodeHasProducers = DiscountCouponCodeHasProducerPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		}
		$this->lastDiscountCouponCodeHasProducerCriteria = $criteria;

		return $this->collDiscountCouponCodeHasProducers;
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
	 * Otherwise if this Producer has previously
	 * been saved, it will retrieve related Products from storage.
	 * If this Producer is new, it will return
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

				$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

				ProductPeer::addSelectColumns($criteria);
				$this->collProducts = ProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

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

		$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

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
		$l->setProducer($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Producer is new, it will return
	 * an empty collection; or if this Producer has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Producer.
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

				$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinProductRelatedByParentId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

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
	 * Otherwise if this Producer is new, it will return
	 * an empty collection; or if this Producer has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Producer.
	 */
	public function getProductsJoinCurrency($criteria = null, $con = null)
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

				$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinCurrency($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Producer is new, it will return
	 * an empty collection; or if this Producer has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Producer.
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

				$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumDefaultId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

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
	 * Otherwise if this Producer is new, it will return
	 * an empty collection; or if this Producer has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Producer.
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

				$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

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
	 * Otherwise if this Producer is new, it will return
	 * an empty collection; or if this Producer has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Producer.
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

				$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinProductDimension($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

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
	 * Otherwise if this Producer is new, it will return
	 * an empty collection; or if this Producer has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Producer.
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

				$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinAvailability($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

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
	 * Otherwise if this Producer is new, it will return
	 * an empty collection; or if this Producer has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Producer.
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

				$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinGroupPrice($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

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
	 * Otherwise if this Producer is new, it will return
	 * an empty collection; or if this Producer has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Producer.
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

				$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinTax($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PRODUCER_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinTax($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}

	/**
	 * Temporary storage of collGiftCardHasProducers to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initGiftCardHasProducers()
	{
		if ($this->collGiftCardHasProducers === null) {
			$this->collGiftCardHasProducers = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Producer has previously
	 * been saved, it will retrieve related GiftCardHasProducers from storage.
	 * If this Producer is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getGiftCardHasProducers($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGiftCardHasProducers === null) {
			if ($this->isNew()) {
			   $this->collGiftCardHasProducers = array();
			} else {

				$criteria->add(GiftCardHasProducerPeer::PRODUCER_ID, $this->getId());

				GiftCardHasProducerPeer::addSelectColumns($criteria);
				$this->collGiftCardHasProducers = GiftCardHasProducerPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GiftCardHasProducerPeer::PRODUCER_ID, $this->getId());

				GiftCardHasProducerPeer::addSelectColumns($criteria);
				if (!isset($this->lastGiftCardHasProducerCriteria) || !$this->lastGiftCardHasProducerCriteria->equals($criteria)) {
					$this->collGiftCardHasProducers = GiftCardHasProducerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGiftCardHasProducerCriteria = $criteria;
		return $this->collGiftCardHasProducers;
	}

	/**
	 * Returns the number of related GiftCardHasProducers.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countGiftCardHasProducers($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(GiftCardHasProducerPeer::PRODUCER_ID, $this->getId());

		return GiftCardHasProducerPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a GiftCardHasProducer object to this object
	 * through the GiftCardHasProducer foreign key attribute
	 *
	 * @param      GiftCardHasProducer $l GiftCardHasProducer
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGiftCardHasProducer(GiftCardHasProducer $l)
	{
		$this->collGiftCardHasProducers[] = $l;
		$l->setProducer($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Producer is new, it will return
	 * an empty collection; or if this Producer has previously
	 * been saved, it will retrieve related GiftCardHasProducers from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Producer.
	 */
	public function getGiftCardHasProducersJoinGiftCard($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGiftCardHasProducers === null) {
			if ($this->isNew()) {
				$this->collGiftCardHasProducers = array();
			} else {

				$criteria->add(GiftCardHasProducerPeer::PRODUCER_ID, $this->getId());

				$this->collGiftCardHasProducers = GiftCardHasProducerPeer::doSelectJoinGiftCard($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(GiftCardHasProducerPeer::PRODUCER_ID, $this->getId());

			if (!isset($this->lastGiftCardHasProducerCriteria) || !$this->lastGiftCardHasProducerCriteria->equals($criteria)) {
				$this->collGiftCardHasProducers = GiftCardHasProducerPeer::doSelectJoinGiftCard($criteria, $con);
			}
		}
		$this->lastGiftCardHasProducerCriteria = $criteria;

		return $this->collGiftCardHasProducers;
	}

	/**
	 * Temporary storage of collProducerI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProducerI18ns()
	{
		if ($this->collProducerI18ns === null) {
			$this->collProducerI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Producer has previously
	 * been saved, it will retrieve related ProducerI18ns from storage.
	 * If this Producer is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProducerI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducerI18ns === null) {
			if ($this->isNew()) {
			   $this->collProducerI18ns = array();
			} else {

				$criteria->add(ProducerI18nPeer::ID, $this->getId());

				ProducerI18nPeer::addSelectColumns($criteria);
				$this->collProducerI18ns = ProducerI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProducerI18nPeer::ID, $this->getId());

				ProducerI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastProducerI18nCriteria) || !$this->lastProducerI18nCriteria->equals($criteria)) {
					$this->collProducerI18ns = ProducerI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProducerI18nCriteria = $criteria;
		return $this->collProducerI18ns;
	}

	/**
	 * Returns the number of related ProducerI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProducerI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProducerI18nPeer::ID, $this->getId());

		return ProducerI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProducerI18n object to this object
	 * through the ProducerI18n foreign key attribute
	 *
	 * @param      ProducerI18n $l ProducerI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProducerI18n(ProducerI18n $l)
	{
		$this->collProducerI18ns[] = $l;
		$l->setProducer($this);
	}

	/**
	 * Temporary storage of collProducerHasPositionings to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProducerHasPositionings()
	{
		if ($this->collProducerHasPositionings === null) {
			$this->collProducerHasPositionings = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Producer has previously
	 * been saved, it will retrieve related ProducerHasPositionings from storage.
	 * If this Producer is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProducerHasPositionings($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducerHasPositionings === null) {
			if ($this->isNew()) {
			   $this->collProducerHasPositionings = array();
			} else {

				$criteria->add(ProducerHasPositioningPeer::PRODUCER_ID, $this->getId());

				ProducerHasPositioningPeer::addSelectColumns($criteria);
				$this->collProducerHasPositionings = ProducerHasPositioningPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProducerHasPositioningPeer::PRODUCER_ID, $this->getId());

				ProducerHasPositioningPeer::addSelectColumns($criteria);
				if (!isset($this->lastProducerHasPositioningCriteria) || !$this->lastProducerHasPositioningCriteria->equals($criteria)) {
					$this->collProducerHasPositionings = ProducerHasPositioningPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProducerHasPositioningCriteria = $criteria;
		return $this->collProducerHasPositionings;
	}

	/**
	 * Returns the number of related ProducerHasPositionings.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProducerHasPositionings($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProducerHasPositioningPeer::PRODUCER_ID, $this->getId());

		return ProducerHasPositioningPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProducerHasPositioning object to this object
	 * through the ProducerHasPositioning foreign key attribute
	 *
	 * @param      ProducerHasPositioning $l ProducerHasPositioning
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProducerHasPositioning(ProducerHasPositioning $l)
	{
		$this->collProducerHasPositionings[] = $l;
		$l->setProducer($this);
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
    $obj = $this->getCurrentProducerI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentProducerI18n()->setName($value);
  }

  public function getUrl()
  {
    $obj = $this->getCurrentProducerI18n();

    return ($obj ? $obj->getUrl() : null);
  }

  public function setUrl($value)
  {
    $this->getCurrentProducerI18n()->setUrl($value);
  }

  public function getDescription()
  {
    $obj = $this->getCurrentProducerI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentProducerI18n()->setDescription($value);
  }

  public $current_i18n = array();

  public function getCurrentProducerI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = ProducerI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setProducerI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setProducerI18nForCulture(new ProducerI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setProducerI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addProducerI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Producer.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseProducer:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseProducer::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseProducer
