<?php

/**
 * Base class that represents a row from the 'st_search_link' table.
 *
 * 
 *
 * @package    plugins.stSearchPlugin.lib.model.om
 */
abstract class BaseSearchLink extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        SearchLinkPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the opt_title field.
	 * @var        string
	 */
	protected $opt_title;


	/**
	 * The value for the opt_description field.
	 * @var        string
	 */
	protected $opt_description;


	/**
	 * The value for the opt_url field.
	 * @var        string
	 */
	protected $opt_url;


	/**
	 * The value for the opt_meta_title field.
	 * @var        string
	 */
	protected $opt_meta_title;


	/**
	 * The value for the opt_meta_keywords field.
	 * @var        string
	 */
	protected $opt_meta_keywords;


	/**
	 * The value for the opt_meta_description field.
	 * @var        string
	 */
	protected $opt_meta_description;


	/**
	 * The value for the opt_search_keywords field.
	 * @var        string
	 */
	protected $opt_search_keywords;

	/**
	 * Collection to store aggregation of collSearchLinkI18ns.
	 * @var        array
	 */
	protected $collSearchLinkI18ns;

	/**
	 * The criteria used to select the current contents of collSearchLinkI18ns.
	 * @var        Criteria
	 */
	protected $lastSearchLinkI18nCriteria = null;

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
     * Get the [opt_title] column value.
     * 
     * @return     string
     */
    public function getOptTitle()
    {

            return $this->opt_title;
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
     * Get the [opt_url] column value.
     * 
     * @return     string
     */
    public function getOptUrl()
    {

            return $this->opt_url;
    }

    /**
     * Get the [opt_meta_title] column value.
     * 
     * @return     string
     */
    public function getOptMetaTitle()
    {

            return $this->opt_meta_title;
    }

    /**
     * Get the [opt_meta_keywords] column value.
     * 
     * @return     string
     */
    public function getOptMetaKeywords()
    {

            return $this->opt_meta_keywords;
    }

    /**
     * Get the [opt_meta_description] column value.
     * 
     * @return     string
     */
    public function getOptMetaDescription()
    {

            return $this->opt_meta_description;
    }

    /**
     * Get the [opt_search_keywords] column value.
     * 
     * @return     string
     */
    public function getOptSearchKeywords()
    {

            return $this->opt_search_keywords;
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
          $this->modifiedColumns[] = SearchLinkPeer::ID;
        }

	} // setId()

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
          $this->modifiedColumns[] = SearchLinkPeer::OPT_TITLE;
        }

	} // setOptTitle()

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
          $this->modifiedColumns[] = SearchLinkPeer::OPT_DESCRIPTION;
        }

	} // setOptDescription()

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
          $this->modifiedColumns[] = SearchLinkPeer::OPT_URL;
        }

	} // setOptUrl()

	/**
	 * Set the value of [opt_meta_title] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptMetaTitle($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_meta_title !== $v) {
          $this->opt_meta_title = $v;
          $this->modifiedColumns[] = SearchLinkPeer::OPT_META_TITLE;
        }

	} // setOptMetaTitle()

	/**
	 * Set the value of [opt_meta_keywords] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptMetaKeywords($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_meta_keywords !== $v) {
          $this->opt_meta_keywords = $v;
          $this->modifiedColumns[] = SearchLinkPeer::OPT_META_KEYWORDS;
        }

	} // setOptMetaKeywords()

	/**
	 * Set the value of [opt_meta_description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptMetaDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_meta_description !== $v) {
          $this->opt_meta_description = $v;
          $this->modifiedColumns[] = SearchLinkPeer::OPT_META_DESCRIPTION;
        }

	} // setOptMetaDescription()

	/**
	 * Set the value of [opt_search_keywords] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptSearchKeywords($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_search_keywords !== $v) {
          $this->opt_search_keywords = $v;
          $this->modifiedColumns[] = SearchLinkPeer::OPT_SEARCH_KEYWORDS;
        }

	} // setOptSearchKeywords()

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
      if ($this->getDispatcher()->getListeners('SearchLink.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'SearchLink.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->opt_title = $rs->getString($startcol + 1);

      $this->opt_description = $rs->getString($startcol + 2);

      $this->opt_url = $rs->getString($startcol + 3);

      $this->opt_meta_title = $rs->getString($startcol + 4);

      $this->opt_meta_keywords = $rs->getString($startcol + 5);

      $this->opt_meta_description = $rs->getString($startcol + 6);

      $this->opt_search_keywords = $rs->getString($startcol + 7);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('SearchLink.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'SearchLink.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 8)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 8; // 8 = SearchLinkPeer::NUM_COLUMNS - SearchLinkPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating SearchLink object", $e);
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

    if ($this->getDispatcher()->getListeners('SearchLink.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'SearchLink.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseSearchLink:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseSearchLink:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(SearchLinkPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      SearchLinkPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('SearchLink.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'SearchLink.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseSearchLink:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseSearchLink:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('SearchLink.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'SearchLink.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseSearchLink:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(SearchLinkPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('SearchLink.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'SearchLink.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseSearchLink:save:post') as $callable)
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
					$pk = SearchLinkPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += SearchLinkPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collSearchLinkI18ns !== null) {
				foreach($this->collSearchLinkI18ns as $referrerFK) {
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


			if (($retval = SearchLinkPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collSearchLinkI18ns !== null) {
					foreach($this->collSearchLinkI18ns as $referrerFK) {
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
		$pos = SearchLinkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getOptTitle();
				break;
			case 2:
				return $this->getOptDescription();
				break;
			case 3:
				return $this->getOptUrl();
				break;
			case 4:
				return $this->getOptMetaTitle();
				break;
			case 5:
				return $this->getOptMetaKeywords();
				break;
			case 6:
				return $this->getOptMetaDescription();
				break;
			case 7:
				return $this->getOptSearchKeywords();
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
		$keys = SearchLinkPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getOptTitle(),
			$keys[2] => $this->getOptDescription(),
			$keys[3] => $this->getOptUrl(),
			$keys[4] => $this->getOptMetaTitle(),
			$keys[5] => $this->getOptMetaKeywords(),
			$keys[6] => $this->getOptMetaDescription(),
			$keys[7] => $this->getOptSearchKeywords(),
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
		$pos = SearchLinkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setOptTitle($value);
				break;
			case 2:
				$this->setOptDescription($value);
				break;
			case 3:
				$this->setOptUrl($value);
				break;
			case 4:
				$this->setOptMetaTitle($value);
				break;
			case 5:
				$this->setOptMetaKeywords($value);
				break;
			case 6:
				$this->setOptMetaDescription($value);
				break;
			case 7:
				$this->setOptSearchKeywords($value);
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
		$keys = SearchLinkPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setOptTitle($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setOptDescription($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setOptUrl($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setOptMetaTitle($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOptMetaKeywords($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setOptMetaDescription($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setOptSearchKeywords($arr[$keys[7]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(SearchLinkPeer::DATABASE_NAME);

		if ($this->isColumnModified(SearchLinkPeer::ID)) $criteria->add(SearchLinkPeer::ID, $this->id);
		if ($this->isColumnModified(SearchLinkPeer::OPT_TITLE)) $criteria->add(SearchLinkPeer::OPT_TITLE, $this->opt_title);
		if ($this->isColumnModified(SearchLinkPeer::OPT_DESCRIPTION)) $criteria->add(SearchLinkPeer::OPT_DESCRIPTION, $this->opt_description);
		if ($this->isColumnModified(SearchLinkPeer::OPT_URL)) $criteria->add(SearchLinkPeer::OPT_URL, $this->opt_url);
		if ($this->isColumnModified(SearchLinkPeer::OPT_META_TITLE)) $criteria->add(SearchLinkPeer::OPT_META_TITLE, $this->opt_meta_title);
		if ($this->isColumnModified(SearchLinkPeer::OPT_META_KEYWORDS)) $criteria->add(SearchLinkPeer::OPT_META_KEYWORDS, $this->opt_meta_keywords);
		if ($this->isColumnModified(SearchLinkPeer::OPT_META_DESCRIPTION)) $criteria->add(SearchLinkPeer::OPT_META_DESCRIPTION, $this->opt_meta_description);
		if ($this->isColumnModified(SearchLinkPeer::OPT_SEARCH_KEYWORDS)) $criteria->add(SearchLinkPeer::OPT_SEARCH_KEYWORDS, $this->opt_search_keywords);

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
		$criteria = new Criteria(SearchLinkPeer::DATABASE_NAME);

		$criteria->add(SearchLinkPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of SearchLink (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setOptTitle($this->opt_title);

		$copyObj->setOptDescription($this->opt_description);

		$copyObj->setOptUrl($this->opt_url);

		$copyObj->setOptMetaTitle($this->opt_meta_title);

		$copyObj->setOptMetaKeywords($this->opt_meta_keywords);

		$copyObj->setOptMetaDescription($this->opt_meta_description);

		$copyObj->setOptSearchKeywords($this->opt_search_keywords);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getSearchLinkI18ns() as $relObj) {
				$copyObj->addSearchLinkI18n($relObj->copy($deepCopy));
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
	 * @return     SearchLink Clone of current object.
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
	 * @return     SearchLinkPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new SearchLinkPeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collSearchLinkI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initSearchLinkI18ns()
	{
		if ($this->collSearchLinkI18ns === null) {
			$this->collSearchLinkI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this SearchLink has previously
	 * been saved, it will retrieve related SearchLinkI18ns from storage.
	 * If this SearchLink is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getSearchLinkI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSearchLinkI18ns === null) {
			if ($this->isNew()) {
			   $this->collSearchLinkI18ns = array();
			} else {

				$criteria->add(SearchLinkI18nPeer::ID, $this->getId());

				SearchLinkI18nPeer::addSelectColumns($criteria);
				$this->collSearchLinkI18ns = SearchLinkI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(SearchLinkI18nPeer::ID, $this->getId());

				SearchLinkI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastSearchLinkI18nCriteria) || !$this->lastSearchLinkI18nCriteria->equals($criteria)) {
					$this->collSearchLinkI18ns = SearchLinkI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSearchLinkI18nCriteria = $criteria;
		return $this->collSearchLinkI18ns;
	}

	/**
	 * Returns the number of related SearchLinkI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countSearchLinkI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(SearchLinkI18nPeer::ID, $this->getId());

		return SearchLinkI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a SearchLinkI18n object to this object
	 * through the SearchLinkI18n foreign key attribute
	 *
	 * @param      SearchLinkI18n $l SearchLinkI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addSearchLinkI18n(SearchLinkI18n $l)
	{
		$this->collSearchLinkI18ns[] = $l;
		$l->setSearchLink($this);
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
    $obj = $this->getCurrentSearchLinkI18n();

    return ($obj ? $obj->getTitle() : null);
  }

  public function setTitle($value)
  {
    $this->getCurrentSearchLinkI18n()->setTitle($value);
  }

  public function getDescription()
  {
    $obj = $this->getCurrentSearchLinkI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentSearchLinkI18n()->setDescription($value);
  }

  public function getUrl()
  {
    $obj = $this->getCurrentSearchLinkI18n();

    return ($obj ? $obj->getUrl() : null);
  }

  public function setUrl($value)
  {
    $this->getCurrentSearchLinkI18n()->setUrl($value);
  }

  public function getMetaTitle()
  {
    $obj = $this->getCurrentSearchLinkI18n();

    return ($obj ? $obj->getMetaTitle() : null);
  }

  public function setMetaTitle($value)
  {
    $this->getCurrentSearchLinkI18n()->setMetaTitle($value);
  }

  public function getMetaKeywords()
  {
    $obj = $this->getCurrentSearchLinkI18n();

    return ($obj ? $obj->getMetaKeywords() : null);
  }

  public function setMetaKeywords($value)
  {
    $this->getCurrentSearchLinkI18n()->setMetaKeywords($value);
  }

  public function getMetaDescription()
  {
    $obj = $this->getCurrentSearchLinkI18n();

    return ($obj ? $obj->getMetaDescription() : null);
  }

  public function setMetaDescription($value)
  {
    $this->getCurrentSearchLinkI18n()->setMetaDescription($value);
  }

  public function getSearchKeywords()
  {
    $obj = $this->getCurrentSearchLinkI18n();

    return ($obj ? $obj->getSearchKeywords() : null);
  }

  public function setSearchKeywords($value)
  {
    $this->getCurrentSearchLinkI18n()->setSearchKeywords($value);
  }

  public $current_i18n = array();

  public function getCurrentSearchLinkI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = SearchLinkI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setSearchLinkI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setSearchLinkI18nForCulture(new SearchLinkI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setSearchLinkI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addSearchLinkI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'SearchLink.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseSearchLink:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseSearchLink::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseSearchLink
