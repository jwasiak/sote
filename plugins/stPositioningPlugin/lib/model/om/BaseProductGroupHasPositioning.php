<?php

/**
 * Base class that represents a row from the 'st_product_group_has_positioning' table.
 *
 * 
 *
 * @package    plugins.stPositioningPlugin.lib.model.om
 */
abstract class BaseProductGroupHasPositioning extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ProductGroupHasPositioningPeer
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
	 * The value for the product_group_id field.
	 * @var        int
	 */
	protected $product_group_id;


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
	 * @var        ProductGroup
	 */
	protected $aProductGroup;

	/**
	 * Collection to store aggregation of collProductGroupHasPositioningI18ns.
	 * @var        array
	 */
	protected $collProductGroupHasPositioningI18ns;

	/**
	 * The criteria used to select the current contents of collProductGroupHasPositioningI18ns.
	 * @var        Criteria
	 */
	protected $lastProductGroupHasPositioningI18nCriteria = null;

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
     * Get the [product_group_id] column value.
     * 
     * @return     int
     */
    public function getProductGroupId()
    {

            return $this->product_group_id;
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
			$this->modifiedColumns[] = ProductGroupHasPositioningPeer::CREATED_AT;
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
			$this->modifiedColumns[] = ProductGroupHasPositioningPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = ProductGroupHasPositioningPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [product_group_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setProductGroupId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->product_group_id !== $v) {
          $this->product_group_id = $v;
          $this->modifiedColumns[] = ProductGroupHasPositioningPeer::PRODUCT_GROUP_ID;
        }

		if ($this->aProductGroup !== null && $this->aProductGroup->getId() !== $v) {
			$this->aProductGroup = null;
		}

	} // setProductGroupId()

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
          $this->modifiedColumns[] = ProductGroupHasPositioningPeer::OPT_TITLE;
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
          $this->modifiedColumns[] = ProductGroupHasPositioningPeer::OPT_KEYWORDS;
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
          $this->modifiedColumns[] = ProductGroupHasPositioningPeer::OPT_DESCRIPTION;
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
          $this->modifiedColumns[] = ProductGroupHasPositioningPeer::OPT_TYPE;
        }

	} // setOptType()

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
      if ($this->getDispatcher()->getListeners('ProductGroupHasPositioning.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductGroupHasPositioning.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->product_group_id = $rs->getInt($startcol + 3);

      $this->opt_title = $rs->getString($startcol + 4);

      $this->opt_keywords = $rs->getString($startcol + 5);

      $this->opt_description = $rs->getString($startcol + 6);

      $this->opt_type = $rs->getInt($startcol + 7);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('ProductGroupHasPositioning.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductGroupHasPositioning.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 8)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 8; // 8 = ProductGroupHasPositioningPeer::NUM_COLUMNS - ProductGroupHasPositioningPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating ProductGroupHasPositioning object", $e);
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

    if ($this->getDispatcher()->getListeners('ProductGroupHasPositioning.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductGroupHasPositioning.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductGroupHasPositioning:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseProductGroupHasPositioning:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ProductGroupHasPositioningPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ProductGroupHasPositioningPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('ProductGroupHasPositioning.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductGroupHasPositioning.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductGroupHasPositioning:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseProductGroupHasPositioning:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('ProductGroupHasPositioning.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'ProductGroupHasPositioning.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseProductGroupHasPositioning:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(ProductGroupHasPositioningPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ProductGroupHasPositioningPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(ProductGroupHasPositioningPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('ProductGroupHasPositioning.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'ProductGroupHasPositioning.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseProductGroupHasPositioning:save:post') as $callable)
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

			if ($this->aProductGroup !== null) {
				if ($this->aProductGroup->isModified() || $this->aProductGroup->getCurrentProductGroupI18n()->isModified()) {
					$affectedRows += $this->aProductGroup->save($con);
				}
				$this->setProductGroup($this->aProductGroup);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ProductGroupHasPositioningPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ProductGroupHasPositioningPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collProductGroupHasPositioningI18ns !== null) {
				foreach($this->collProductGroupHasPositioningI18ns as $referrerFK) {
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

			if ($this->aProductGroup !== null) {
				if (!$this->aProductGroup->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProductGroup->getValidationFailures());
				}
			}


			if (($retval = ProductGroupHasPositioningPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collProductGroupHasPositioningI18ns !== null) {
					foreach($this->collProductGroupHasPositioningI18ns as $referrerFK) {
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
		$pos = ProductGroupHasPositioningPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getProductGroupId();
				break;
			case 4:
				return $this->getOptTitle();
				break;
			case 5:
				return $this->getOptKeywords();
				break;
			case 6:
				return $this->getOptDescription();
				break;
			case 7:
				return $this->getOptType();
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
		$keys = ProductGroupHasPositioningPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getProductGroupId(),
			$keys[4] => $this->getOptTitle(),
			$keys[5] => $this->getOptKeywords(),
			$keys[6] => $this->getOptDescription(),
			$keys[7] => $this->getOptType(),
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
		$pos = ProductGroupHasPositioningPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setProductGroupId($value);
				break;
			case 4:
				$this->setOptTitle($value);
				break;
			case 5:
				$this->setOptKeywords($value);
				break;
			case 6:
				$this->setOptDescription($value);
				break;
			case 7:
				$this->setOptType($value);
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
		$keys = ProductGroupHasPositioningPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setProductGroupId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setOptTitle($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOptKeywords($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setOptDescription($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setOptType($arr[$keys[7]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ProductGroupHasPositioningPeer::DATABASE_NAME);

		if ($this->isColumnModified(ProductGroupHasPositioningPeer::CREATED_AT)) $criteria->add(ProductGroupHasPositioningPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ProductGroupHasPositioningPeer::UPDATED_AT)) $criteria->add(ProductGroupHasPositioningPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(ProductGroupHasPositioningPeer::ID)) $criteria->add(ProductGroupHasPositioningPeer::ID, $this->id);
		if ($this->isColumnModified(ProductGroupHasPositioningPeer::PRODUCT_GROUP_ID)) $criteria->add(ProductGroupHasPositioningPeer::PRODUCT_GROUP_ID, $this->product_group_id);
		if ($this->isColumnModified(ProductGroupHasPositioningPeer::OPT_TITLE)) $criteria->add(ProductGroupHasPositioningPeer::OPT_TITLE, $this->opt_title);
		if ($this->isColumnModified(ProductGroupHasPositioningPeer::OPT_KEYWORDS)) $criteria->add(ProductGroupHasPositioningPeer::OPT_KEYWORDS, $this->opt_keywords);
		if ($this->isColumnModified(ProductGroupHasPositioningPeer::OPT_DESCRIPTION)) $criteria->add(ProductGroupHasPositioningPeer::OPT_DESCRIPTION, $this->opt_description);
		if ($this->isColumnModified(ProductGroupHasPositioningPeer::OPT_TYPE)) $criteria->add(ProductGroupHasPositioningPeer::OPT_TYPE, $this->opt_type);

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
		$criteria = new Criteria(ProductGroupHasPositioningPeer::DATABASE_NAME);

		$criteria->add(ProductGroupHasPositioningPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of ProductGroupHasPositioning (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setProductGroupId($this->product_group_id);

		$copyObj->setOptTitle($this->opt_title);

		$copyObj->setOptKeywords($this->opt_keywords);

		$copyObj->setOptDescription($this->opt_description);

		$copyObj->setOptType($this->opt_type);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getProductGroupHasPositioningI18ns() as $relObj) {
				$copyObj->addProductGroupHasPositioningI18n($relObj->copy($deepCopy));
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
	 * @return     ProductGroupHasPositioning Clone of current object.
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
	 * @return     ProductGroupHasPositioningPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ProductGroupHasPositioningPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a ProductGroup object.
	 *
	 * @param      ProductGroup $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setProductGroup($v)
	{


		if ($v === null) {
			$this->setProductGroupId(NULL);
		} else {
			$this->setProductGroupId($v->getId());
		}


		$this->aProductGroup = $v;
	}


	/**
	 * Get the associated ProductGroup object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     ProductGroup The associated ProductGroup object.
	 * @throws     PropelException
	 */
	public function getProductGroup($con = null)
	{
		if ($this->aProductGroup === null && ($this->product_group_id !== null)) {
			// include the related Peer class
			$this->aProductGroup = ProductGroupPeer::retrieveByPK($this->product_group_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductGroupPeer::retrieveByPK($this->product_group_id, $con);
			   $obj->addProductGroups($this);
			 */
		}
		return $this->aProductGroup;
	}

	/**
	 * Temporary storage of collProductGroupHasPositioningI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductGroupHasPositioningI18ns()
	{
		if ($this->collProductGroupHasPositioningI18ns === null) {
			$this->collProductGroupHasPositioningI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductGroupHasPositioning has previously
	 * been saved, it will retrieve related ProductGroupHasPositioningI18ns from storage.
	 * If this ProductGroupHasPositioning is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductGroupHasPositioningI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductGroupHasPositioningI18ns === null) {
			if ($this->isNew()) {
			   $this->collProductGroupHasPositioningI18ns = array();
			} else {

				$criteria->add(ProductGroupHasPositioningI18nPeer::ID, $this->getId());

				ProductGroupHasPositioningI18nPeer::addSelectColumns($criteria);
				$this->collProductGroupHasPositioningI18ns = ProductGroupHasPositioningI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductGroupHasPositioningI18nPeer::ID, $this->getId());

				ProductGroupHasPositioningI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductGroupHasPositioningI18nCriteria) || !$this->lastProductGroupHasPositioningI18nCriteria->equals($criteria)) {
					$this->collProductGroupHasPositioningI18ns = ProductGroupHasPositioningI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductGroupHasPositioningI18nCriteria = $criteria;
		return $this->collProductGroupHasPositioningI18ns;
	}

	/**
	 * Returns the number of related ProductGroupHasPositioningI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductGroupHasPositioningI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductGroupHasPositioningI18nPeer::ID, $this->getId());

		return ProductGroupHasPositioningI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductGroupHasPositioningI18n object to this object
	 * through the ProductGroupHasPositioningI18n foreign key attribute
	 *
	 * @param      ProductGroupHasPositioningI18n $l ProductGroupHasPositioningI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductGroupHasPositioningI18n(ProductGroupHasPositioningI18n $l)
	{
		$this->collProductGroupHasPositioningI18ns[] = $l;
		$l->setProductGroupHasPositioning($this);
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
    $obj = $this->getCurrentProductGroupHasPositioningI18n();

    return ($obj ? $obj->getTitle() : null);
  }

  public function setTitle($value)
  {
    $this->getCurrentProductGroupHasPositioningI18n()->setTitle($value);
  }

  public function getKeywords()
  {
    $obj = $this->getCurrentProductGroupHasPositioningI18n();

    return ($obj ? $obj->getKeywords() : null);
  }

  public function setKeywords($value)
  {
    $this->getCurrentProductGroupHasPositioningI18n()->setKeywords($value);
  }

  public function getDescription()
  {
    $obj = $this->getCurrentProductGroupHasPositioningI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentProductGroupHasPositioningI18n()->setDescription($value);
  }

  public function getType()
  {
    $obj = $this->getCurrentProductGroupHasPositioningI18n();

    return ($obj ? $obj->getType() : null);
  }

  public function setType($value)
  {
    $this->getCurrentProductGroupHasPositioningI18n()->setType($value);
  }

  public $current_i18n = array();

  public function getCurrentProductGroupHasPositioningI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = ProductGroupHasPositioningI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setProductGroupHasPositioningI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setProductGroupHasPositioningI18nForCulture(new ProductGroupHasPositioningI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setProductGroupHasPositioningI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addProductGroupHasPositioningI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'ProductGroupHasPositioning.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseProductGroupHasPositioning:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseProductGroupHasPositioning::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseProductGroupHasPositioning