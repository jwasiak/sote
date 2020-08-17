<?php

/**
 * Base class that represents a row from the 'st_blog_category' table.
 *
 * 
 *
 * @package    plugins.stBlogPlugin.lib.model.om
 */
abstract class BaseBlogCategory extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        BlogCategoryPeer
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
	 * The value for the opt_url field.
	 * @var        string
	 */
	protected $opt_url;


	/**
	 * The value for the banner_group field.
	 * @var        string
	 */
	protected $banner_group;

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
	 * Collection to store aggregation of collBlogCategoryI18ns.
	 * @var        array
	 */
	protected $collBlogCategoryI18ns;

	/**
	 * The criteria used to select the current contents of collBlogCategoryI18ns.
	 * @var        Criteria
	 */
	protected $lastBlogCategoryI18nCriteria = null;

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
     * Get the [opt_url] column value.
     * 
     * @return     string
     */
    public function getOptUrl()
    {

            return $this->opt_url;
    }

    /**
     * Get the [banner_group] column value.
     * 
     * @return     string
     */
    public function getBannerGroup()
    {

            return $this->banner_group;
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
			$this->modifiedColumns[] = BlogCategoryPeer::CREATED_AT;
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
			$this->modifiedColumns[] = BlogCategoryPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = BlogCategoryPeer::ID;
        }

	} // setId()

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
          $this->modifiedColumns[] = BlogCategoryPeer::ACTIVE;
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
          $this->modifiedColumns[] = BlogCategoryPeer::OPT_NAME;
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
          $this->modifiedColumns[] = BlogCategoryPeer::OPT_URL;
        }

	} // setOptUrl()

	/**
	 * Set the value of [banner_group] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setBannerGroup($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->banner_group !== $v) {
          $this->banner_group = $v;
          $this->modifiedColumns[] = BlogCategoryPeer::BANNER_GROUP;
        }

	} // setBannerGroup()

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
      if ($this->getDispatcher()->getListeners('BlogCategory.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'BlogCategory.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->active = $rs->getBoolean($startcol + 3);

      $this->opt_name = $rs->getString($startcol + 4);

      $this->opt_url = $rs->getString($startcol + 5);

      $this->banner_group = $rs->getString($startcol + 6);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('BlogCategory.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'BlogCategory.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 7)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 7; // 7 = BlogCategoryPeer::NUM_COLUMNS - BlogCategoryPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating BlogCategory object", $e);
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

    if ($this->getDispatcher()->getListeners('BlogCategory.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'BlogCategory.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseBlogCategory:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseBlogCategory:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(BlogCategoryPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      BlogCategoryPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('BlogCategory.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'BlogCategory.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseBlogCategory:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseBlogCategory:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('BlogCategory.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'BlogCategory.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseBlogCategory:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(BlogCategoryPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(BlogCategoryPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(BlogCategoryPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('BlogCategory.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'BlogCategory.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseBlogCategory:save:post') as $callable)
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
					$pk = BlogCategoryPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += BlogCategoryPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collBlogHasBlogCategorys !== null) {
				foreach($this->collBlogHasBlogCategorys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collBlogCategoryI18ns !== null) {
				foreach($this->collBlogCategoryI18ns as $referrerFK) {
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


			if (($retval = BlogCategoryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collBlogHasBlogCategorys !== null) {
					foreach($this->collBlogHasBlogCategorys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collBlogCategoryI18ns !== null) {
					foreach($this->collBlogCategoryI18ns as $referrerFK) {
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
		$pos = BlogCategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getActive();
				break;
			case 4:
				return $this->getOptName();
				break;
			case 5:
				return $this->getOptUrl();
				break;
			case 6:
				return $this->getBannerGroup();
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
		$keys = BlogCategoryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getActive(),
			$keys[4] => $this->getOptName(),
			$keys[5] => $this->getOptUrl(),
			$keys[6] => $this->getBannerGroup(),
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
		$pos = BlogCategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setActive($value);
				break;
			case 4:
				$this->setOptName($value);
				break;
			case 5:
				$this->setOptUrl($value);
				break;
			case 6:
				$this->setBannerGroup($value);
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
		$keys = BlogCategoryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setActive($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setOptName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOptUrl($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setBannerGroup($arr[$keys[6]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(BlogCategoryPeer::DATABASE_NAME);

		if ($this->isColumnModified(BlogCategoryPeer::CREATED_AT)) $criteria->add(BlogCategoryPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(BlogCategoryPeer::UPDATED_AT)) $criteria->add(BlogCategoryPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(BlogCategoryPeer::ID)) $criteria->add(BlogCategoryPeer::ID, $this->id);
		if ($this->isColumnModified(BlogCategoryPeer::ACTIVE)) $criteria->add(BlogCategoryPeer::ACTIVE, $this->active);
		if ($this->isColumnModified(BlogCategoryPeer::OPT_NAME)) $criteria->add(BlogCategoryPeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(BlogCategoryPeer::OPT_URL)) $criteria->add(BlogCategoryPeer::OPT_URL, $this->opt_url);
		if ($this->isColumnModified(BlogCategoryPeer::BANNER_GROUP)) $criteria->add(BlogCategoryPeer::BANNER_GROUP, $this->banner_group);

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
		$criteria = new Criteria(BlogCategoryPeer::DATABASE_NAME);

		$criteria->add(BlogCategoryPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of BlogCategory (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setActive($this->active);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setOptUrl($this->opt_url);

		$copyObj->setBannerGroup($this->banner_group);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getBlogHasBlogCategorys() as $relObj) {
				$copyObj->addBlogHasBlogCategory($relObj->copy($deepCopy));
			}

			foreach($this->getBlogCategoryI18ns() as $relObj) {
				$copyObj->addBlogCategoryI18n($relObj->copy($deepCopy));
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
	 * @return     BlogCategory Clone of current object.
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
	 * @return     BlogCategoryPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new BlogCategoryPeer();
		}
		return self::$peer;
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
	 * Otherwise if this BlogCategory has previously
	 * been saved, it will retrieve related BlogHasBlogCategorys from storage.
	 * If this BlogCategory is new, it will return
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

				$criteria->add(BlogHasBlogCategoryPeer::BLOG_CATEGORY_ID, $this->getId());

				BlogHasBlogCategoryPeer::addSelectColumns($criteria);
				$this->collBlogHasBlogCategorys = BlogHasBlogCategoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(BlogHasBlogCategoryPeer::BLOG_CATEGORY_ID, $this->getId());

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

		$criteria->add(BlogHasBlogCategoryPeer::BLOG_CATEGORY_ID, $this->getId());

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
		$l->setBlogCategory($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BlogCategory is new, it will return
	 * an empty collection; or if this BlogCategory has previously
	 * been saved, it will retrieve related BlogHasBlogCategorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BlogCategory.
	 */
	public function getBlogHasBlogCategorysJoinBlog($criteria = null, $con = null)
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

				$criteria->add(BlogHasBlogCategoryPeer::BLOG_CATEGORY_ID, $this->getId());

				$this->collBlogHasBlogCategorys = BlogHasBlogCategoryPeer::doSelectJoinBlog($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(BlogHasBlogCategoryPeer::BLOG_CATEGORY_ID, $this->getId());

			if (!isset($this->lastBlogHasBlogCategoryCriteria) || !$this->lastBlogHasBlogCategoryCriteria->equals($criteria)) {
				$this->collBlogHasBlogCategorys = BlogHasBlogCategoryPeer::doSelectJoinBlog($criteria, $con);
			}
		}
		$this->lastBlogHasBlogCategoryCriteria = $criteria;

		return $this->collBlogHasBlogCategorys;
	}

	/**
	 * Temporary storage of collBlogCategoryI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initBlogCategoryI18ns()
	{
		if ($this->collBlogCategoryI18ns === null) {
			$this->collBlogCategoryI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BlogCategory has previously
	 * been saved, it will retrieve related BlogCategoryI18ns from storage.
	 * If this BlogCategory is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getBlogCategoryI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBlogCategoryI18ns === null) {
			if ($this->isNew()) {
			   $this->collBlogCategoryI18ns = array();
			} else {

				$criteria->add(BlogCategoryI18nPeer::ID, $this->getId());

				BlogCategoryI18nPeer::addSelectColumns($criteria);
				$this->collBlogCategoryI18ns = BlogCategoryI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(BlogCategoryI18nPeer::ID, $this->getId());

				BlogCategoryI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastBlogCategoryI18nCriteria) || !$this->lastBlogCategoryI18nCriteria->equals($criteria)) {
					$this->collBlogCategoryI18ns = BlogCategoryI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastBlogCategoryI18nCriteria = $criteria;
		return $this->collBlogCategoryI18ns;
	}

	/**
	 * Returns the number of related BlogCategoryI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countBlogCategoryI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(BlogCategoryI18nPeer::ID, $this->getId());

		return BlogCategoryI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a BlogCategoryI18n object to this object
	 * through the BlogCategoryI18n foreign key attribute
	 *
	 * @param      BlogCategoryI18n $l BlogCategoryI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addBlogCategoryI18n(BlogCategoryI18n $l)
	{
		$this->collBlogCategoryI18ns[] = $l;
		$l->setBlogCategory($this);
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
    $obj = $this->getCurrentBlogCategoryI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentBlogCategoryI18n()->setName($value);
  }

  public function getUrl()
  {
    $obj = $this->getCurrentBlogCategoryI18n();

    return ($obj ? $obj->getUrl() : null);
  }

  public function setUrl($value)
  {
    $this->getCurrentBlogCategoryI18n()->setUrl($value);
  }

  public $current_i18n = array();

  public function getCurrentBlogCategoryI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = BlogCategoryI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setBlogCategoryI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setBlogCategoryI18nForCulture(new BlogCategoryI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setBlogCategoryI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addBlogCategoryI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'BlogCategory.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseBlogCategory:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseBlogCategory::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseBlogCategory
