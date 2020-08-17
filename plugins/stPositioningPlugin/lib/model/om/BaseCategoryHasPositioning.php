<?php

/**
 * Base class that represents a row from the 'st_category_has_positioning' table.
 *
 * 
 *
 * @package    plugins.stPositioningPlugin.lib.model.om
 */
abstract class BaseCategoryHasPositioning extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        CategoryHasPositioningPeer
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
	 * The value for the category_id field.
	 * @var        int
	 */
	protected $category_id;


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
	 * @var        Category
	 */
	protected $aCategory;

	/**
	 * Collection to store aggregation of collCategoryHasPositioningI18ns.
	 * @var        array
	 */
	protected $collCategoryHasPositioningI18ns;

	/**
	 * The criteria used to select the current contents of collCategoryHasPositioningI18ns.
	 * @var        Criteria
	 */
	protected $lastCategoryHasPositioningI18nCriteria = null;

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
     * Get the [category_id] column value.
     * 
     * @return     int
     */
    public function getCategoryId()
    {

            return $this->category_id;
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
			$this->modifiedColumns[] = CategoryHasPositioningPeer::CREATED_AT;
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
			$this->modifiedColumns[] = CategoryHasPositioningPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = CategoryHasPositioningPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [category_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCategoryId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->category_id !== $v) {
          $this->category_id = $v;
          $this->modifiedColumns[] = CategoryHasPositioningPeer::CATEGORY_ID;
        }

		if ($this->aCategory !== null && $this->aCategory->getId() !== $v) {
			$this->aCategory = null;
		}

	} // setCategoryId()

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
          $this->modifiedColumns[] = CategoryHasPositioningPeer::OPT_TITLE;
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
          $this->modifiedColumns[] = CategoryHasPositioningPeer::OPT_KEYWORDS;
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
          $this->modifiedColumns[] = CategoryHasPositioningPeer::OPT_DESCRIPTION;
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
          $this->modifiedColumns[] = CategoryHasPositioningPeer::OPT_TYPE;
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
      if ($this->getDispatcher()->getListeners('CategoryHasPositioning.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'CategoryHasPositioning.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->category_id = $rs->getInt($startcol + 3);

      $this->opt_title = $rs->getString($startcol + 4);

      $this->opt_keywords = $rs->getString($startcol + 5);

      $this->opt_description = $rs->getString($startcol + 6);

      $this->opt_type = $rs->getInt($startcol + 7);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('CategoryHasPositioning.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'CategoryHasPositioning.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 8)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 8; // 8 = CategoryHasPositioningPeer::NUM_COLUMNS - CategoryHasPositioningPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating CategoryHasPositioning object", $e);
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

    if ($this->getDispatcher()->getListeners('CategoryHasPositioning.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'CategoryHasPositioning.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseCategoryHasPositioning:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseCategoryHasPositioning:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(CategoryHasPositioningPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      CategoryHasPositioningPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('CategoryHasPositioning.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'CategoryHasPositioning.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseCategoryHasPositioning:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseCategoryHasPositioning:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('CategoryHasPositioning.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'CategoryHasPositioning.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseCategoryHasPositioning:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(CategoryHasPositioningPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(CategoryHasPositioningPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(CategoryHasPositioningPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('CategoryHasPositioning.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'CategoryHasPositioning.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseCategoryHasPositioning:save:post') as $callable)
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

			if ($this->aCategory !== null) {
				if ($this->aCategory->isModified() || $this->aCategory->getCurrentCategoryI18n()->isModified()) {
					$affectedRows += $this->aCategory->save($con);
				}
				$this->setCategory($this->aCategory);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = CategoryHasPositioningPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += CategoryHasPositioningPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collCategoryHasPositioningI18ns !== null) {
				foreach($this->collCategoryHasPositioningI18ns as $referrerFK) {
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

			if ($this->aCategory !== null) {
				if (!$this->aCategory->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCategory->getValidationFailures());
				}
			}


			if (($retval = CategoryHasPositioningPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collCategoryHasPositioningI18ns !== null) {
					foreach($this->collCategoryHasPositioningI18ns as $referrerFK) {
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
		$pos = CategoryHasPositioningPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCategoryId();
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
		$keys = CategoryHasPositioningPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getCategoryId(),
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
		$pos = CategoryHasPositioningPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setCategoryId($value);
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
		$keys = CategoryHasPositioningPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCategoryId($arr[$keys[3]]);
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
		$criteria = new Criteria(CategoryHasPositioningPeer::DATABASE_NAME);

		if ($this->isColumnModified(CategoryHasPositioningPeer::CREATED_AT)) $criteria->add(CategoryHasPositioningPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(CategoryHasPositioningPeer::UPDATED_AT)) $criteria->add(CategoryHasPositioningPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(CategoryHasPositioningPeer::ID)) $criteria->add(CategoryHasPositioningPeer::ID, $this->id);
		if ($this->isColumnModified(CategoryHasPositioningPeer::CATEGORY_ID)) $criteria->add(CategoryHasPositioningPeer::CATEGORY_ID, $this->category_id);
		if ($this->isColumnModified(CategoryHasPositioningPeer::OPT_TITLE)) $criteria->add(CategoryHasPositioningPeer::OPT_TITLE, $this->opt_title);
		if ($this->isColumnModified(CategoryHasPositioningPeer::OPT_KEYWORDS)) $criteria->add(CategoryHasPositioningPeer::OPT_KEYWORDS, $this->opt_keywords);
		if ($this->isColumnModified(CategoryHasPositioningPeer::OPT_DESCRIPTION)) $criteria->add(CategoryHasPositioningPeer::OPT_DESCRIPTION, $this->opt_description);
		if ($this->isColumnModified(CategoryHasPositioningPeer::OPT_TYPE)) $criteria->add(CategoryHasPositioningPeer::OPT_TYPE, $this->opt_type);

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
		$criteria = new Criteria(CategoryHasPositioningPeer::DATABASE_NAME);

		$criteria->add(CategoryHasPositioningPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of CategoryHasPositioning (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setCategoryId($this->category_id);

		$copyObj->setOptTitle($this->opt_title);

		$copyObj->setOptKeywords($this->opt_keywords);

		$copyObj->setOptDescription($this->opt_description);

		$copyObj->setOptType($this->opt_type);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getCategoryHasPositioningI18ns() as $relObj) {
				$copyObj->addCategoryHasPositioningI18n($relObj->copy($deepCopy));
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
	 * @return     CategoryHasPositioning Clone of current object.
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
	 * @return     CategoryHasPositioningPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new CategoryHasPositioningPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Category object.
	 *
	 * @param      Category $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setCategory($v)
	{


		if ($v === null) {
			$this->setCategoryId(NULL);
		} else {
			$this->setCategoryId($v->getId());
		}


		$this->aCategory = $v;
	}


	/**
	 * Get the associated Category object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Category The associated Category object.
	 * @throws     PropelException
	 */
	public function getCategory($con = null)
	{
		if ($this->aCategory === null && ($this->category_id !== null)) {
			// include the related Peer class
			$this->aCategory = CategoryPeer::retrieveByPK($this->category_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = CategoryPeer::retrieveByPK($this->category_id, $con);
			   $obj->addCategorys($this);
			 */
		}
		return $this->aCategory;
	}

	/**
	 * Temporary storage of collCategoryHasPositioningI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initCategoryHasPositioningI18ns()
	{
		if ($this->collCategoryHasPositioningI18ns === null) {
			$this->collCategoryHasPositioningI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this CategoryHasPositioning has previously
	 * been saved, it will retrieve related CategoryHasPositioningI18ns from storage.
	 * If this CategoryHasPositioning is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getCategoryHasPositioningI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCategoryHasPositioningI18ns === null) {
			if ($this->isNew()) {
			   $this->collCategoryHasPositioningI18ns = array();
			} else {

				$criteria->add(CategoryHasPositioningI18nPeer::ID, $this->getId());

				CategoryHasPositioningI18nPeer::addSelectColumns($criteria);
				$this->collCategoryHasPositioningI18ns = CategoryHasPositioningI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(CategoryHasPositioningI18nPeer::ID, $this->getId());

				CategoryHasPositioningI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastCategoryHasPositioningI18nCriteria) || !$this->lastCategoryHasPositioningI18nCriteria->equals($criteria)) {
					$this->collCategoryHasPositioningI18ns = CategoryHasPositioningI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCategoryHasPositioningI18nCriteria = $criteria;
		return $this->collCategoryHasPositioningI18ns;
	}

	/**
	 * Returns the number of related CategoryHasPositioningI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countCategoryHasPositioningI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CategoryHasPositioningI18nPeer::ID, $this->getId());

		return CategoryHasPositioningI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a CategoryHasPositioningI18n object to this object
	 * through the CategoryHasPositioningI18n foreign key attribute
	 *
	 * @param      CategoryHasPositioningI18n $l CategoryHasPositioningI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addCategoryHasPositioningI18n(CategoryHasPositioningI18n $l)
	{
		$this->collCategoryHasPositioningI18ns[] = $l;
		$l->setCategoryHasPositioning($this);
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
    $obj = $this->getCurrentCategoryHasPositioningI18n();

    return ($obj ? $obj->getTitle() : null);
  }

  public function setTitle($value)
  {
    $this->getCurrentCategoryHasPositioningI18n()->setTitle($value);
  }

  public function getKeywords()
  {
    $obj = $this->getCurrentCategoryHasPositioningI18n();

    return ($obj ? $obj->getKeywords() : null);
  }

  public function setKeywords($value)
  {
    $this->getCurrentCategoryHasPositioningI18n()->setKeywords($value);
  }

  public function getDescription()
  {
    $obj = $this->getCurrentCategoryHasPositioningI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentCategoryHasPositioningI18n()->setDescription($value);
  }

  public function getType()
  {
    $obj = $this->getCurrentCategoryHasPositioningI18n();

    return ($obj ? $obj->getType() : null);
  }

  public function setType($value)
  {
    $this->getCurrentCategoryHasPositioningI18n()->setType($value);
  }

  public $current_i18n = array();

  public function getCurrentCategoryHasPositioningI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = CategoryHasPositioningI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setCategoryHasPositioningI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setCategoryHasPositioningI18nForCulture(new CategoryHasPositioningI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setCategoryHasPositioningI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addCategoryHasPositioningI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'CategoryHasPositioning.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseCategoryHasPositioning:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseCategoryHasPositioning::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseCategoryHasPositioning