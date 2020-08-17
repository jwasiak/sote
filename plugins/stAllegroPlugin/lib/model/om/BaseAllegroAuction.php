<?php

/**
 * Base class that represents a row from the 'st_allegro_auction' table.
 *
 * 
 *
 * @package    plugins.stAllegroPlugin.lib.model.om
 */
abstract class BaseAllegroAuction extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        AllegroAuctionPeer
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
	 * The value for the product_id field.
	 * @var        int
	 */
	protected $product_id;


	/**
	 * The value for the product_options field.
	 * @var        string
	 */
	protected $product_options;


	/**
	 * The value for the requires_sync field.
	 * @var        int
	 */
	protected $requires_sync = 0;


	/**
	 * The value for the site field.
	 * @var        string
	 */
	protected $site;


	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the auction_id field.
	 * @var        string
	 */
	protected $auction_id;


	/**
	 * The value for the ended field.
	 * @var        int
	 */
	protected $ended = 0;


	/**
	 * The value for the ended_at field.
	 * @var        int
	 */
	protected $ended_at;


	/**
	 * The value for the commands field.
	 * @var        string
	 */
	protected $commands;

	/**
	 * @var        Product
	 */
	protected $aProduct;

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
     * Get the [product_id] column value.
     * 
     * @return     int
     */
    public function getProductId()
    {

            return $this->product_id;
    }

    /**
     * Get the [product_options] column value.
     * 
     * @return     string
     */
    public function getProductOptions()
    {

            return $this->product_options;
    }

    /**
     * Get the [requires_sync] column value.
     * 
     * @return     int
     */
    public function getRequiresSync()
    {

            return $this->requires_sync;
    }

    /**
     * Get the [site] column value.
     * 
     * @return     string
     */
    public function getSite()
    {

            return $this->site;
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
     * Get the [auction_id] column value.
     * 
     * @return     string
     */
    public function getAuctionId()
    {

            return $this->auction_id;
    }

    /**
     * Get the [ended] column value.
     * 
     * @return     int
     */
    public function getEnded()
    {

            return $this->ended;
    }

	/**
	 * Get the [optionally formatted] [ended_at] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getEndedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->ended_at === null || $this->ended_at === '') {
			return null;
		} elseif (!is_int($this->ended_at)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->ended_at);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [ended_at] as date/time value: " . var_export($this->ended_at, true));
			}
		} else {
			$ts = $this->ended_at;
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
     * Get the [commands] column value.
     * 
     * @return     string
     */
    public function getCommands()
    {

            return $this->commands;
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
			$this->modifiedColumns[] = AllegroAuctionPeer::CREATED_AT;
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
			$this->modifiedColumns[] = AllegroAuctionPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = AllegroAuctionPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [product_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setProductId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->product_id !== $v) {
          $this->product_id = $v;
          $this->modifiedColumns[] = AllegroAuctionPeer::PRODUCT_ID;
        }

		if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
			$this->aProduct = null;
		}

	} // setProductId()

	/**
	 * Set the value of [product_options] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setProductOptions($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->product_options !== $v) {
          $this->product_options = $v;
          $this->modifiedColumns[] = AllegroAuctionPeer::PRODUCT_OPTIONS;
        }

	} // setProductOptions()

	/**
	 * Set the value of [requires_sync] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setRequiresSync($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->requires_sync !== $v || $v === 0) {
          $this->requires_sync = $v;
          $this->modifiedColumns[] = AllegroAuctionPeer::REQUIRES_SYNC;
        }

	} // setRequiresSync()

	/**
	 * Set the value of [site] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setSite($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->site !== $v) {
          $this->site = $v;
          $this->modifiedColumns[] = AllegroAuctionPeer::SITE;
        }

	} // setSite()

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
          $this->modifiedColumns[] = AllegroAuctionPeer::NAME;
        }

	} // setName()

	/**
	 * Set the value of [auction_id] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setAuctionId($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->auction_id !== $v) {
          $this->auction_id = $v;
          $this->modifiedColumns[] = AllegroAuctionPeer::AUCTION_ID;
        }

	} // setAuctionId()

	/**
	 * Set the value of [ended] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setEnded($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->ended !== $v || $v === 0) {
          $this->ended = $v;
          $this->modifiedColumns[] = AllegroAuctionPeer::ENDED;
        }

	} // setEnded()

	/**
	 * Set the value of [ended_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setEndedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [ended_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->ended_at !== $ts) {
			$this->ended_at = $ts;
			$this->modifiedColumns[] = AllegroAuctionPeer::ENDED_AT;
		}

	} // setEndedAt()

	/**
	 * Set the value of [commands] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCommands($v)
	{

        if ($this->commands !== $v) {
          $this->commands = $v;
          $this->modifiedColumns[] = AllegroAuctionPeer::COMMANDS;
        }

	} // setCommands()

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
      if ($this->getDispatcher()->getListeners('AllegroAuction.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'AllegroAuction.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->product_id = $rs->getInt($startcol + 3);

      $this->product_options = $rs->getString($startcol + 4);

      $this->requires_sync = $rs->getInt($startcol + 5);

      $this->site = $rs->getString($startcol + 6);

      $this->name = $rs->getString($startcol + 7);

      $this->auction_id = $rs->getString($startcol + 8);

      $this->ended = $rs->getInt($startcol + 9);

      $this->ended_at = $rs->getTimestamp($startcol + 10, null);

      $this->commands = $rs->getString($startcol + 11) ? unserialize($rs->getString($startcol + 11)) : null;

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('AllegroAuction.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'AllegroAuction.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 12)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 12; // 12 = AllegroAuctionPeer::NUM_COLUMNS - AllegroAuctionPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating AllegroAuction object", $e);
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

    if ($this->getDispatcher()->getListeners('AllegroAuction.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'AllegroAuction.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseAllegroAuction:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseAllegroAuction:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(AllegroAuctionPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      AllegroAuctionPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('AllegroAuction.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'AllegroAuction.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseAllegroAuction:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseAllegroAuction:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('AllegroAuction.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'AllegroAuction.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseAllegroAuction:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(AllegroAuctionPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(AllegroAuctionPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(AllegroAuctionPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('AllegroAuction.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'AllegroAuction.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseAllegroAuction:save:post') as $callable)
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

			if ($this->aProduct !== null) {
				if ($this->aProduct->isModified() || $this->aProduct->getCurrentProductI18n()->isModified()) {
					$affectedRows += $this->aProduct->save($con);
				}
				$this->setProduct($this->aProduct);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
              $o_commands = $this->commands;
              if (null !== $this->commands && $this->isColumnModified(AllegroAuctionPeer::COMMANDS)) {
                  $this->commands = serialize($this->commands);
              }

				if ($this->isNew()) {
					$pk = AllegroAuctionPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += AllegroAuctionPeer::doUpdate($this, $con);
				}
				$this->resetModified();
             $this->commands = $o_commands;
 // [HL] After being saved an object is no longer 'modified'
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

			if ($this->aProduct !== null) {
				if (!$this->aProduct->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProduct->getValidationFailures());
				}
			}


			if (($retval = AllegroAuctionPeer::doValidate($this, $columns)) !== true) {
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
		$pos = AllegroAuctionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getProductId();
				break;
			case 4:
				return $this->getProductOptions();
				break;
			case 5:
				return $this->getRequiresSync();
				break;
			case 6:
				return $this->getSite();
				break;
			case 7:
				return $this->getName();
				break;
			case 8:
				return $this->getAuctionId();
				break;
			case 9:
				return $this->getEnded();
				break;
			case 10:
				return $this->getEndedAt();
				break;
			case 11:
				return $this->getCommands();
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
		$keys = AllegroAuctionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getProductId(),
			$keys[4] => $this->getProductOptions(),
			$keys[5] => $this->getRequiresSync(),
			$keys[6] => $this->getSite(),
			$keys[7] => $this->getName(),
			$keys[8] => $this->getAuctionId(),
			$keys[9] => $this->getEnded(),
			$keys[10] => $this->getEndedAt(),
			$keys[11] => $this->getCommands(),
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
		$pos = AllegroAuctionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setProductId($value);
				break;
			case 4:
				$this->setProductOptions($value);
				break;
			case 5:
				$this->setRequiresSync($value);
				break;
			case 6:
				$this->setSite($value);
				break;
			case 7:
				$this->setName($value);
				break;
			case 8:
				$this->setAuctionId($value);
				break;
			case 9:
				$this->setEnded($value);
				break;
			case 10:
				$this->setEndedAt($value);
				break;
			case 11:
				$this->setCommands($value);
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
		$keys = AllegroAuctionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setProductId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setProductOptions($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setRequiresSync($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setSite($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setName($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setAuctionId($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setEnded($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setEndedAt($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setCommands($arr[$keys[11]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(AllegroAuctionPeer::DATABASE_NAME);

		if ($this->isColumnModified(AllegroAuctionPeer::CREATED_AT)) $criteria->add(AllegroAuctionPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(AllegroAuctionPeer::UPDATED_AT)) $criteria->add(AllegroAuctionPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(AllegroAuctionPeer::ID)) $criteria->add(AllegroAuctionPeer::ID, $this->id);
		if ($this->isColumnModified(AllegroAuctionPeer::PRODUCT_ID)) $criteria->add(AllegroAuctionPeer::PRODUCT_ID, $this->product_id);
		if ($this->isColumnModified(AllegroAuctionPeer::PRODUCT_OPTIONS)) $criteria->add(AllegroAuctionPeer::PRODUCT_OPTIONS, $this->product_options);
		if ($this->isColumnModified(AllegroAuctionPeer::REQUIRES_SYNC)) $criteria->add(AllegroAuctionPeer::REQUIRES_SYNC, $this->requires_sync);
		if ($this->isColumnModified(AllegroAuctionPeer::SITE)) $criteria->add(AllegroAuctionPeer::SITE, $this->site);
		if ($this->isColumnModified(AllegroAuctionPeer::NAME)) $criteria->add(AllegroAuctionPeer::NAME, $this->name);
		if ($this->isColumnModified(AllegroAuctionPeer::AUCTION_ID)) $criteria->add(AllegroAuctionPeer::AUCTION_ID, $this->auction_id);
		if ($this->isColumnModified(AllegroAuctionPeer::ENDED)) $criteria->add(AllegroAuctionPeer::ENDED, $this->ended);
		if ($this->isColumnModified(AllegroAuctionPeer::ENDED_AT)) $criteria->add(AllegroAuctionPeer::ENDED_AT, $this->ended_at);
		if ($this->isColumnModified(AllegroAuctionPeer::COMMANDS)) $criteria->add(AllegroAuctionPeer::COMMANDS, $this->commands);

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
		$criteria = new Criteria(AllegroAuctionPeer::DATABASE_NAME);

		$criteria->add(AllegroAuctionPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of AllegroAuction (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setProductId($this->product_id);

		$copyObj->setProductOptions($this->product_options);

		$copyObj->setRequiresSync($this->requires_sync);

		$copyObj->setSite($this->site);

		$copyObj->setName($this->name);

		$copyObj->setAuctionId($this->auction_id);

		$copyObj->setEnded($this->ended);

		$copyObj->setEndedAt($this->ended_at);

		$copyObj->setCommands($this->commands);


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
	 * @return     AllegroAuction Clone of current object.
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
	 * @return     AllegroAuctionPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new AllegroAuctionPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Product object.
	 *
	 * @param      Product $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setProduct($v)
	{


		if ($v === null) {
			$this->setProductId(NULL);
		} else {
			$this->setProductId($v->getId());
		}


		$this->aProduct = $v;
	}


	/**
	 * Get the associated Product object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Product The associated Product object.
	 * @throws     PropelException
	 */
	public function getProduct($con = null)
	{
		if ($this->aProduct === null && ($this->product_id !== null)) {
			// include the related Peer class
			$this->aProduct = ProductPeer::retrieveByPK($this->product_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductPeer::retrieveByPK($this->product_id, $con);
			   $obj->addProducts($this);
			 */
		}
		return $this->aProduct;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'AllegroAuction.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseAllegroAuction:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseAllegroAuction::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseAllegroAuction
