<?php

/**
 * Base class that represents a row from the 'st_product_options_filter' table.
 *
 * 
 *
 * @package    plugins.stProductOptionsPlugin.lib.model.om
 */
abstract class BaseProductOptionsFilter extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ProductOptionsFilterPeer
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
	 * The value for the opt_name field.
	 * @var        string
	 */
	protected $opt_name;


	/**
	 * The value for the filter_type field.
	 * @var        int
	 */
	protected $filter_type;


	/**
	 * The value for the rank field.
	 * @var        int
	 */
	protected $rank;


	/**
	 * The value for the price_from field.
	 * @var        double
	 */
	protected $price_from;


	/**
	 * The value for the price_to field.
	 * @var        double
	 */
	protected $price_to;


	/**
	 * The value for the is_visible field.
	 * @var        boolean
	 */
	protected $is_visible = true;

	/**
	 * Collection to store aggregation of collProductOptionsFields.
	 * @var        array
	 */
	protected $collProductOptionsFields;

	/**
	 * The criteria used to select the current contents of collProductOptionsFields.
	 * @var        Criteria
	 */
	protected $lastProductOptionsFieldCriteria = null;

	/**
	 * Collection to store aggregation of collProductOptionsFilterI18ns.
	 * @var        array
	 */
	protected $collProductOptionsFilterI18ns;

	/**
	 * The criteria used to select the current contents of collProductOptionsFilterI18ns.
	 * @var        Criteria
	 */
	protected $lastProductOptionsFilterI18nCriteria = null;

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
     * Get the [opt_name] column value.
     * 
     * @return     string
     */
    public function getOptName()
    {

            return $this->opt_name;
    }

    /**
     * Get the [filter_type] column value.
     * 
     * @return     int
     */
    public function getFilterType()
    {

            return $this->filter_type;
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
     * Get the [price_from] column value.
     * 
     * @return     double
     */
    public function getPriceFrom()
    {

            return $this->price_from;
    }

    /**
     * Get the [price_to] column value.
     * 
     * @return     double
     */
    public function getPriceTo()
    {

            return $this->price_to;
    }

    /**
     * Get the [is_visible] column value.
     * 
     * @return     boolean
     */
    public function getIsVisible()
    {

            return $this->is_visible;
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
			$this->modifiedColumns[] = ProductOptionsFilterPeer::CREATED_AT;
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
			$this->modifiedColumns[] = ProductOptionsFilterPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = ProductOptionsFilterPeer::ID;
        }

	} // setId()

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
          $this->modifiedColumns[] = ProductOptionsFilterPeer::OPT_NAME;
        }

	} // setOptName()

	/**
	 * Set the value of [filter_type] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setFilterType($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->filter_type !== $v) {
          $this->filter_type = $v;
          $this->modifiedColumns[] = ProductOptionsFilterPeer::FILTER_TYPE;
        }

	} // setFilterType()

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
          $this->modifiedColumns[] = ProductOptionsFilterPeer::RANK;
        }

	} // setRank()

	/**
	 * Set the value of [price_from] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setPriceFrom($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->price_from !== $v) {
          $this->price_from = $v;
          $this->modifiedColumns[] = ProductOptionsFilterPeer::PRICE_FROM;
        }

	} // setPriceFrom()

	/**
	 * Set the value of [price_to] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setPriceTo($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->price_to !== $v) {
          $this->price_to = $v;
          $this->modifiedColumns[] = ProductOptionsFilterPeer::PRICE_TO;
        }

	} // setPriceTo()

	/**
	 * Set the value of [is_visible] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsVisible($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_visible !== $v || $v === true) {
          $this->is_visible = $v;
          $this->modifiedColumns[] = ProductOptionsFilterPeer::IS_VISIBLE;
        }

	} // setIsVisible()

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
      if ($this->getDispatcher()->getListeners('ProductOptionsFilter.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsFilter.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->opt_name = $rs->getString($startcol + 3);

      $this->filter_type = $rs->getInt($startcol + 4);

      $this->rank = $rs->getInt($startcol + 5);

      $this->price_from = $rs->getFloat($startcol + 6);

      $this->price_to = $rs->getFloat($startcol + 7);

      $this->is_visible = $rs->getBoolean($startcol + 8);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('ProductOptionsFilter.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsFilter.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 9)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 9; // 9 = ProductOptionsFilterPeer::NUM_COLUMNS - ProductOptionsFilterPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating ProductOptionsFilter object", $e);
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

    if ($this->getDispatcher()->getListeners('ProductOptionsFilter.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsFilter.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductOptionsFilter:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseProductOptionsFilter:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ProductOptionsFilterPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ProductOptionsFilterPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('ProductOptionsFilter.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsFilter.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductOptionsFilter:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseProductOptionsFilter:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('ProductOptionsFilter.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsFilter.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseProductOptionsFilter:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(ProductOptionsFilterPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ProductOptionsFilterPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(ProductOptionsFilterPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('ProductOptionsFilter.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsFilter.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseProductOptionsFilter:save:post') as $callable)
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
					$pk = ProductOptionsFilterPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ProductOptionsFilterPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collProductOptionsFields !== null) {
				foreach($this->collProductOptionsFields as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductOptionsFilterI18ns !== null) {
				foreach($this->collProductOptionsFilterI18ns as $referrerFK) {
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


			if (($retval = ProductOptionsFilterPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collProductOptionsFields !== null) {
					foreach($this->collProductOptionsFields as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductOptionsFilterI18ns !== null) {
					foreach($this->collProductOptionsFilterI18ns as $referrerFK) {
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
		$pos = ProductOptionsFilterPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getOptName();
				break;
			case 4:
				return $this->getFilterType();
				break;
			case 5:
				return $this->getRank();
				break;
			case 6:
				return $this->getPriceFrom();
				break;
			case 7:
				return $this->getPriceTo();
				break;
			case 8:
				return $this->getIsVisible();
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
		$keys = ProductOptionsFilterPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getOptName(),
			$keys[4] => $this->getFilterType(),
			$keys[5] => $this->getRank(),
			$keys[6] => $this->getPriceFrom(),
			$keys[7] => $this->getPriceTo(),
			$keys[8] => $this->getIsVisible(),
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
		$pos = ProductOptionsFilterPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setOptName($value);
				break;
			case 4:
				$this->setFilterType($value);
				break;
			case 5:
				$this->setRank($value);
				break;
			case 6:
				$this->setPriceFrom($value);
				break;
			case 7:
				$this->setPriceTo($value);
				break;
			case 8:
				$this->setIsVisible($value);
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
		$keys = ProductOptionsFilterPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setOptName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setFilterType($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setRank($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setPriceFrom($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPriceTo($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsVisible($arr[$keys[8]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ProductOptionsFilterPeer::DATABASE_NAME);

		if ($this->isColumnModified(ProductOptionsFilterPeer::CREATED_AT)) $criteria->add(ProductOptionsFilterPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ProductOptionsFilterPeer::UPDATED_AT)) $criteria->add(ProductOptionsFilterPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(ProductOptionsFilterPeer::ID)) $criteria->add(ProductOptionsFilterPeer::ID, $this->id);
		if ($this->isColumnModified(ProductOptionsFilterPeer::OPT_NAME)) $criteria->add(ProductOptionsFilterPeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(ProductOptionsFilterPeer::FILTER_TYPE)) $criteria->add(ProductOptionsFilterPeer::FILTER_TYPE, $this->filter_type);
		if ($this->isColumnModified(ProductOptionsFilterPeer::RANK)) $criteria->add(ProductOptionsFilterPeer::RANK, $this->rank);
		if ($this->isColumnModified(ProductOptionsFilterPeer::PRICE_FROM)) $criteria->add(ProductOptionsFilterPeer::PRICE_FROM, $this->price_from);
		if ($this->isColumnModified(ProductOptionsFilterPeer::PRICE_TO)) $criteria->add(ProductOptionsFilterPeer::PRICE_TO, $this->price_to);
		if ($this->isColumnModified(ProductOptionsFilterPeer::IS_VISIBLE)) $criteria->add(ProductOptionsFilterPeer::IS_VISIBLE, $this->is_visible);

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
		$criteria = new Criteria(ProductOptionsFilterPeer::DATABASE_NAME);

		$criteria->add(ProductOptionsFilterPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of ProductOptionsFilter (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setFilterType($this->filter_type);

		$copyObj->setRank($this->rank);

		$copyObj->setPriceFrom($this->price_from);

		$copyObj->setPriceTo($this->price_to);

		$copyObj->setIsVisible($this->is_visible);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getProductOptionsFields() as $relObj) {
				$copyObj->addProductOptionsField($relObj->copy($deepCopy));
			}

			foreach($this->getProductOptionsFilterI18ns() as $relObj) {
				$copyObj->addProductOptionsFilterI18n($relObj->copy($deepCopy));
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
	 * @return     ProductOptionsFilter Clone of current object.
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
	 * @return     ProductOptionsFilterPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ProductOptionsFilterPeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collProductOptionsFields to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductOptionsFields()
	{
		if ($this->collProductOptionsFields === null) {
			$this->collProductOptionsFields = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsFilter has previously
	 * been saved, it will retrieve related ProductOptionsFields from storage.
	 * If this ProductOptionsFilter is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductOptionsFields($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsFields === null) {
			if ($this->isNew()) {
			   $this->collProductOptionsFields = array();
			} else {

				$criteria->add(ProductOptionsFieldPeer::PRODUCT_OPTIONS_FILTER_ID, $this->getId());

				ProductOptionsFieldPeer::addSelectColumns($criteria);
				$this->collProductOptionsFields = ProductOptionsFieldPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductOptionsFieldPeer::PRODUCT_OPTIONS_FILTER_ID, $this->getId());

				ProductOptionsFieldPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductOptionsFieldCriteria) || !$this->lastProductOptionsFieldCriteria->equals($criteria)) {
					$this->collProductOptionsFields = ProductOptionsFieldPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductOptionsFieldCriteria = $criteria;
		return $this->collProductOptionsFields;
	}

	/**
	 * Returns the number of related ProductOptionsFields.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductOptionsFields($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductOptionsFieldPeer::PRODUCT_OPTIONS_FILTER_ID, $this->getId());

		return ProductOptionsFieldPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductOptionsField object to this object
	 * through the ProductOptionsField foreign key attribute
	 *
	 * @param      ProductOptionsField $l ProductOptionsField
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductOptionsField(ProductOptionsField $l)
	{
		$this->collProductOptionsFields[] = $l;
		$l->setProductOptionsFilter($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsFilter is new, it will return
	 * an empty collection; or if this ProductOptionsFilter has previously
	 * been saved, it will retrieve related ProductOptionsFields from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsFilter.
	 */
	public function getProductOptionsFieldsJoinProductOptionsTemplate($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsFields === null) {
			if ($this->isNew()) {
				$this->collProductOptionsFields = array();
			} else {

				$criteria->add(ProductOptionsFieldPeer::PRODUCT_OPTIONS_FILTER_ID, $this->getId());

				$this->collProductOptionsFields = ProductOptionsFieldPeer::doSelectJoinProductOptionsTemplate($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsFieldPeer::PRODUCT_OPTIONS_FILTER_ID, $this->getId());

			if (!isset($this->lastProductOptionsFieldCriteria) || !$this->lastProductOptionsFieldCriteria->equals($criteria)) {
				$this->collProductOptionsFields = ProductOptionsFieldPeer::doSelectJoinProductOptionsTemplate($criteria, $con);
			}
		}
		$this->lastProductOptionsFieldCriteria = $criteria;

		return $this->collProductOptionsFields;
	}

	/**
	 * Temporary storage of collProductOptionsFilterI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductOptionsFilterI18ns()
	{
		if ($this->collProductOptionsFilterI18ns === null) {
			$this->collProductOptionsFilterI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsFilter has previously
	 * been saved, it will retrieve related ProductOptionsFilterI18ns from storage.
	 * If this ProductOptionsFilter is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductOptionsFilterI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsFilterI18ns === null) {
			if ($this->isNew()) {
			   $this->collProductOptionsFilterI18ns = array();
			} else {

				$criteria->add(ProductOptionsFilterI18nPeer::ID, $this->getId());

				ProductOptionsFilterI18nPeer::addSelectColumns($criteria);
				$this->collProductOptionsFilterI18ns = ProductOptionsFilterI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductOptionsFilterI18nPeer::ID, $this->getId());

				ProductOptionsFilterI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductOptionsFilterI18nCriteria) || !$this->lastProductOptionsFilterI18nCriteria->equals($criteria)) {
					$this->collProductOptionsFilterI18ns = ProductOptionsFilterI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductOptionsFilterI18nCriteria = $criteria;
		return $this->collProductOptionsFilterI18ns;
	}

	/**
	 * Returns the number of related ProductOptionsFilterI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductOptionsFilterI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductOptionsFilterI18nPeer::ID, $this->getId());

		return ProductOptionsFilterI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductOptionsFilterI18n object to this object
	 * through the ProductOptionsFilterI18n foreign key attribute
	 *
	 * @param      ProductOptionsFilterI18n $l ProductOptionsFilterI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductOptionsFilterI18n(ProductOptionsFilterI18n $l)
	{
		$this->collProductOptionsFilterI18ns[] = $l;
		$l->setProductOptionsFilter($this);
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
    $obj = $this->getCurrentProductOptionsFilterI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentProductOptionsFilterI18n()->setName($value);
  }

  public $current_i18n = array();

  public function getCurrentProductOptionsFilterI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = ProductOptionsFilterI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setProductOptionsFilterI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setProductOptionsFilterI18nForCulture(new ProductOptionsFilterI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setProductOptionsFilterI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addProductOptionsFilterI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'ProductOptionsFilter.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseProductOptionsFilter:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseProductOptionsFilter::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseProductOptionsFilter
