<?php

/**
 * Base class that represents a row from the 'st_product_group' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseProductGroup extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ProductGroupPeer
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
	 * The value for the product_group field.
	 * @var        string
	 */
	protected $product_group;


	/**
	 * The value for the opt_name field.
	 * @var        string
	 */
	protected $opt_name;


	/**
	 * The value for the product_limit field.
	 * @var        int
	 */
	protected $product_limit;


	/**
	 * The value for the opt_url field.
	 * @var        string
	 */
	protected $opt_url;


	/**
	 * The value for the opt_label field.
	 * @var        string
	 */
	protected $opt_label;


	/**
	 * The value for the opt_image field.
	 * @var        string
	 */
	protected $opt_image;


	/**
	 * The value for the from_basket_value field.
	 * @var        int
	 */
	protected $from_basket_value;

	/**
	 * Collection to store aggregation of collProductGroupHasPositionings.
	 * @var        array
	 */
	protected $collProductGroupHasPositionings;

	/**
	 * The criteria used to select the current contents of collProductGroupHasPositionings.
	 * @var        Criteria
	 */
	protected $lastProductGroupHasPositioningCriteria = null;

	/**
	 * Collection to store aggregation of collProductGroupHasProducts.
	 * @var        array
	 */
	protected $collProductGroupHasProducts;

	/**
	 * The criteria used to select the current contents of collProductGroupHasProducts.
	 * @var        Criteria
	 */
	protected $lastProductGroupHasProductCriteria = null;

	/**
	 * Collection to store aggregation of collProductGroupI18ns.
	 * @var        array
	 */
	protected $collProductGroupI18ns;

	/**
	 * The criteria used to select the current contents of collProductGroupI18ns.
	 * @var        Criteria
	 */
	protected $lastProductGroupI18nCriteria = null;

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
     * Get the [product_group] column value.
     * 
     * @return     string
     */
    public function getProductGroup()
    {

            return $this->product_group;
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
     * Get the [product_limit] column value.
     * 
     * @return     int
     */
    public function getProductLimit()
    {

            return $this->product_limit;
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
     * Get the [opt_label] column value.
     * 
     * @return     string
     */
    public function getOptLabel()
    {

            return $this->opt_label;
    }

    /**
     * Get the [opt_image] column value.
     * 
     * @return     string
     */
    public function getOptImage()
    {

            return $this->opt_image;
    }

    /**
     * Get the [from_basket_value] column value.
     * 
     * @return     int
     */
    public function getFromBasketValue()
    {

            return $this->from_basket_value;
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
			$this->modifiedColumns[] = ProductGroupPeer::CREATED_AT;
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
			$this->modifiedColumns[] = ProductGroupPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = ProductGroupPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [product_group] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setProductGroup($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->product_group !== $v) {
          $this->product_group = $v;
          $this->modifiedColumns[] = ProductGroupPeer::PRODUCT_GROUP;
        }

	} // setProductGroup()

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
          $this->modifiedColumns[] = ProductGroupPeer::OPT_NAME;
        }

	} // setOptName()

	/**
	 * Set the value of [product_limit] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setProductLimit($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->product_limit !== $v) {
          $this->product_limit = $v;
          $this->modifiedColumns[] = ProductGroupPeer::PRODUCT_LIMIT;
        }

	} // setProductLimit()

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
          $this->modifiedColumns[] = ProductGroupPeer::OPT_URL;
        }

	} // setOptUrl()

	/**
	 * Set the value of [opt_label] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptLabel($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_label !== $v) {
          $this->opt_label = $v;
          $this->modifiedColumns[] = ProductGroupPeer::OPT_LABEL;
        }

	} // setOptLabel()

	/**
	 * Set the value of [opt_image] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptImage($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_image !== $v) {
          $this->opt_image = $v;
          $this->modifiedColumns[] = ProductGroupPeer::OPT_IMAGE;
        }

	} // setOptImage()

	/**
	 * Set the value of [from_basket_value] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setFromBasketValue($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->from_basket_value !== $v) {
          $this->from_basket_value = $v;
          $this->modifiedColumns[] = ProductGroupPeer::FROM_BASKET_VALUE;
        }

	} // setFromBasketValue()

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
      if ($this->getDispatcher()->getListeners('ProductGroup.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductGroup.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->product_group = $rs->getString($startcol + 3);

      $this->opt_name = $rs->getString($startcol + 4);

      $this->product_limit = $rs->getInt($startcol + 5);

      $this->opt_url = $rs->getString($startcol + 6);

      $this->opt_label = $rs->getString($startcol + 7);

      $this->opt_image = $rs->getString($startcol + 8);

      $this->from_basket_value = $rs->getInt($startcol + 9);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('ProductGroup.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductGroup.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 10)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 10; // 10 = ProductGroupPeer::NUM_COLUMNS - ProductGroupPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating ProductGroup object", $e);
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

    if ($this->getDispatcher()->getListeners('ProductGroup.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductGroup.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductGroup:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseProductGroup:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ProductGroupPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ProductGroupPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('ProductGroup.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductGroup.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductGroup:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseProductGroup:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('ProductGroup.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'ProductGroup.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseProductGroup:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(ProductGroupPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ProductGroupPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(ProductGroupPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('ProductGroup.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'ProductGroup.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseProductGroup:save:post') as $callable)
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
					$pk = ProductGroupPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ProductGroupPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collProductGroupHasPositionings !== null) {
				foreach($this->collProductGroupHasPositionings as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductGroupHasProducts !== null) {
				foreach($this->collProductGroupHasProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductGroupI18ns !== null) {
				foreach($this->collProductGroupI18ns as $referrerFK) {
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


			if (($retval = ProductGroupPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collProductGroupHasPositionings !== null) {
					foreach($this->collProductGroupHasPositionings as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductGroupHasProducts !== null) {
					foreach($this->collProductGroupHasProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductGroupI18ns !== null) {
					foreach($this->collProductGroupI18ns as $referrerFK) {
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
		$pos = ProductGroupPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getProductGroup();
				break;
			case 4:
				return $this->getOptName();
				break;
			case 5:
				return $this->getProductLimit();
				break;
			case 6:
				return $this->getOptUrl();
				break;
			case 7:
				return $this->getOptLabel();
				break;
			case 8:
				return $this->getOptImage();
				break;
			case 9:
				return $this->getFromBasketValue();
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
		$keys = ProductGroupPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getProductGroup(),
			$keys[4] => $this->getOptName(),
			$keys[5] => $this->getProductLimit(),
			$keys[6] => $this->getOptUrl(),
			$keys[7] => $this->getOptLabel(),
			$keys[8] => $this->getOptImage(),
			$keys[9] => $this->getFromBasketValue(),
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
		$pos = ProductGroupPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setProductGroup($value);
				break;
			case 4:
				$this->setOptName($value);
				break;
			case 5:
				$this->setProductLimit($value);
				break;
			case 6:
				$this->setOptUrl($value);
				break;
			case 7:
				$this->setOptLabel($value);
				break;
			case 8:
				$this->setOptImage($value);
				break;
			case 9:
				$this->setFromBasketValue($value);
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
		$keys = ProductGroupPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setProductGroup($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setOptName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setProductLimit($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setOptUrl($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setOptLabel($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setOptImage($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setFromBasketValue($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ProductGroupPeer::DATABASE_NAME);

		if ($this->isColumnModified(ProductGroupPeer::CREATED_AT)) $criteria->add(ProductGroupPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ProductGroupPeer::UPDATED_AT)) $criteria->add(ProductGroupPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(ProductGroupPeer::ID)) $criteria->add(ProductGroupPeer::ID, $this->id);
		if ($this->isColumnModified(ProductGroupPeer::PRODUCT_GROUP)) $criteria->add(ProductGroupPeer::PRODUCT_GROUP, $this->product_group);
		if ($this->isColumnModified(ProductGroupPeer::OPT_NAME)) $criteria->add(ProductGroupPeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(ProductGroupPeer::PRODUCT_LIMIT)) $criteria->add(ProductGroupPeer::PRODUCT_LIMIT, $this->product_limit);
		if ($this->isColumnModified(ProductGroupPeer::OPT_URL)) $criteria->add(ProductGroupPeer::OPT_URL, $this->opt_url);
		if ($this->isColumnModified(ProductGroupPeer::OPT_LABEL)) $criteria->add(ProductGroupPeer::OPT_LABEL, $this->opt_label);
		if ($this->isColumnModified(ProductGroupPeer::OPT_IMAGE)) $criteria->add(ProductGroupPeer::OPT_IMAGE, $this->opt_image);
		if ($this->isColumnModified(ProductGroupPeer::FROM_BASKET_VALUE)) $criteria->add(ProductGroupPeer::FROM_BASKET_VALUE, $this->from_basket_value);

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
		$criteria = new Criteria(ProductGroupPeer::DATABASE_NAME);

		$criteria->add(ProductGroupPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of ProductGroup (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setProductGroup($this->product_group);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setProductLimit($this->product_limit);

		$copyObj->setOptUrl($this->opt_url);

		$copyObj->setOptLabel($this->opt_label);

		$copyObj->setOptImage($this->opt_image);

		$copyObj->setFromBasketValue($this->from_basket_value);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getProductGroupHasPositionings() as $relObj) {
				$copyObj->addProductGroupHasPositioning($relObj->copy($deepCopy));
			}

			foreach($this->getProductGroupHasProducts() as $relObj) {
				$copyObj->addProductGroupHasProduct($relObj->copy($deepCopy));
			}

			foreach($this->getProductGroupI18ns() as $relObj) {
				$copyObj->addProductGroupI18n($relObj->copy($deepCopy));
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
	 * @return     ProductGroup Clone of current object.
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
	 * @return     ProductGroupPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ProductGroupPeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collProductGroupHasPositionings to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductGroupHasPositionings()
	{
		if ($this->collProductGroupHasPositionings === null) {
			$this->collProductGroupHasPositionings = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductGroup has previously
	 * been saved, it will retrieve related ProductGroupHasPositionings from storage.
	 * If this ProductGroup is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductGroupHasPositionings($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductGroupHasPositionings === null) {
			if ($this->isNew()) {
			   $this->collProductGroupHasPositionings = array();
			} else {

				$criteria->add(ProductGroupHasPositioningPeer::PRODUCT_GROUP_ID, $this->getId());

				ProductGroupHasPositioningPeer::addSelectColumns($criteria);
				$this->collProductGroupHasPositionings = ProductGroupHasPositioningPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductGroupHasPositioningPeer::PRODUCT_GROUP_ID, $this->getId());

				ProductGroupHasPositioningPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductGroupHasPositioningCriteria) || !$this->lastProductGroupHasPositioningCriteria->equals($criteria)) {
					$this->collProductGroupHasPositionings = ProductGroupHasPositioningPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductGroupHasPositioningCriteria = $criteria;
		return $this->collProductGroupHasPositionings;
	}

	/**
	 * Returns the number of related ProductGroupHasPositionings.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductGroupHasPositionings($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductGroupHasPositioningPeer::PRODUCT_GROUP_ID, $this->getId());

		return ProductGroupHasPositioningPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductGroupHasPositioning object to this object
	 * through the ProductGroupHasPositioning foreign key attribute
	 *
	 * @param      ProductGroupHasPositioning $l ProductGroupHasPositioning
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductGroupHasPositioning(ProductGroupHasPositioning $l)
	{
		$this->collProductGroupHasPositionings[] = $l;
		$l->setProductGroup($this);
	}

	/**
	 * Temporary storage of collProductGroupHasProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductGroupHasProducts()
	{
		if ($this->collProductGroupHasProducts === null) {
			$this->collProductGroupHasProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductGroup has previously
	 * been saved, it will retrieve related ProductGroupHasProducts from storage.
	 * If this ProductGroup is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductGroupHasProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductGroupHasProducts === null) {
			if ($this->isNew()) {
			   $this->collProductGroupHasProducts = array();
			} else {

				$criteria->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $this->getId());

				ProductGroupHasProductPeer::addSelectColumns($criteria);
				$this->collProductGroupHasProducts = ProductGroupHasProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $this->getId());

				ProductGroupHasProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductGroupHasProductCriteria) || !$this->lastProductGroupHasProductCriteria->equals($criteria)) {
					$this->collProductGroupHasProducts = ProductGroupHasProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductGroupHasProductCriteria = $criteria;
		return $this->collProductGroupHasProducts;
	}

	/**
	 * Returns the number of related ProductGroupHasProducts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductGroupHasProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $this->getId());

		return ProductGroupHasProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductGroupHasProduct object to this object
	 * through the ProductGroupHasProduct foreign key attribute
	 *
	 * @param      ProductGroupHasProduct $l ProductGroupHasProduct
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductGroupHasProduct(ProductGroupHasProduct $l)
	{
		$this->collProductGroupHasProducts[] = $l;
		$l->setProductGroup($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductGroup is new, it will return
	 * an empty collection; or if this ProductGroup has previously
	 * been saved, it will retrieve related ProductGroupHasProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductGroup.
	 */
	public function getProductGroupHasProductsJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductGroupHasProducts === null) {
			if ($this->isNew()) {
				$this->collProductGroupHasProducts = array();
			} else {

				$criteria->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $this->getId());

				$this->collProductGroupHasProducts = ProductGroupHasProductPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $this->getId());

			if (!isset($this->lastProductGroupHasProductCriteria) || !$this->lastProductGroupHasProductCriteria->equals($criteria)) {
				$this->collProductGroupHasProducts = ProductGroupHasProductPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastProductGroupHasProductCriteria = $criteria;

		return $this->collProductGroupHasProducts;
	}

	/**
	 * Temporary storage of collProductGroupI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductGroupI18ns()
	{
		if ($this->collProductGroupI18ns === null) {
			$this->collProductGroupI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductGroup has previously
	 * been saved, it will retrieve related ProductGroupI18ns from storage.
	 * If this ProductGroup is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductGroupI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductGroupI18ns === null) {
			if ($this->isNew()) {
			   $this->collProductGroupI18ns = array();
			} else {

				$criteria->add(ProductGroupI18nPeer::ID, $this->getId());

				ProductGroupI18nPeer::addSelectColumns($criteria);
				$this->collProductGroupI18ns = ProductGroupI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductGroupI18nPeer::ID, $this->getId());

				ProductGroupI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductGroupI18nCriteria) || !$this->lastProductGroupI18nCriteria->equals($criteria)) {
					$this->collProductGroupI18ns = ProductGroupI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductGroupI18nCriteria = $criteria;
		return $this->collProductGroupI18ns;
	}

	/**
	 * Returns the number of related ProductGroupI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductGroupI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductGroupI18nPeer::ID, $this->getId());

		return ProductGroupI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductGroupI18n object to this object
	 * through the ProductGroupI18n foreign key attribute
	 *
	 * @param      ProductGroupI18n $l ProductGroupI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductGroupI18n(ProductGroupI18n $l)
	{
		$this->collProductGroupI18ns[] = $l;
		$l->setProductGroup($this);
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
    $obj = $this->getCurrentProductGroupI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentProductGroupI18n()->setName($value);
  }

  public function getUrl()
  {
    $obj = $this->getCurrentProductGroupI18n();

    return ($obj ? $obj->getUrl() : null);
  }

  public function setUrl($value)
  {
    $this->getCurrentProductGroupI18n()->setUrl($value);
  }

  public function getLabel()
  {
    $obj = $this->getCurrentProductGroupI18n();

    return ($obj ? $obj->getLabel() : null);
  }

  public function setLabel($value)
  {
    $this->getCurrentProductGroupI18n()->setLabel($value);
  }

  public function getImage()
  {
    $obj = $this->getCurrentProductGroupI18n();

    return ($obj ? $obj->getImage() : null);
  }

  public function setImage($value)
  {
    $this->getCurrentProductGroupI18n()->setImage($value);
  }

  public $current_i18n = array();

  public function getCurrentProductGroupI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = ProductGroupI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setProductGroupI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setProductGroupI18nForCulture(new ProductGroupI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setProductGroupI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addProductGroupI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'ProductGroup.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseProductGroup:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseProductGroup::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseProductGroup
