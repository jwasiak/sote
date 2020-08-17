<?php

/**
 * Base class that represents a row from the 'st_search_link_i18n' table.
 *
 * 
 *
 * @package    plugins.stSearchPlugin.lib.model.om
 */
abstract class BaseSearchLinkI18n extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        SearchLinkI18nPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the culture field.
	 * @var        string
	 */
	protected $culture;


	/**
	 * The value for the title field.
	 * @var        string
	 */
	protected $title;


	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;


	/**
	 * The value for the url field.
	 * @var        string
	 */
	protected $url;


	/**
	 * The value for the meta_title field.
	 * @var        string
	 */
	protected $meta_title;


	/**
	 * The value for the meta_keywords field.
	 * @var        string
	 */
	protected $meta_keywords;


	/**
	 * The value for the meta_description field.
	 * @var        string
	 */
	protected $meta_description;


	/**
	 * The value for the search_keywords field.
	 * @var        string
	 */
	protected $search_keywords;

	/**
	 * @var        SearchLink
	 */
	protected $aSearchLink;

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
     * Get the [id] column value.
     * 
     * @return     int
     */
    public function getId()
    {

            return $this->id;
    }

    /**
     * Get the [culture] column value.
     * 
     * @return     string
     */
    public function getCulture()
    {

            return $this->culture;
    }

    /**
     * Get the [title] column value.
     * 
     * @return     string
     */
    public function getTitle()
    {

            return $this->title;
    }

    /**
     * Get the [description] column value.
     * 
     * @return     string
     */
    public function getDescription()
    {

            return $this->description;
    }

    /**
     * Get the [url] column value.
     * 
     * @return     string
     */
    public function getUrl()
    {

            return $this->url;
    }

    /**
     * Get the [meta_title] column value.
     * 
     * @return     string
     */
    public function getMetaTitle()
    {

            return $this->meta_title;
    }

    /**
     * Get the [meta_keywords] column value.
     * 
     * @return     string
     */
    public function getMetaKeywords()
    {

            return $this->meta_keywords;
    }

    /**
     * Get the [meta_description] column value.
     * 
     * @return     string
     */
    public function getMetaDescription()
    {

            return $this->meta_description;
    }

    /**
     * Get the [search_keywords] column value.
     * 
     * @return     string
     */
    public function getSearchKeywords()
    {

            return $this->search_keywords;
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
          $this->modifiedColumns[] = SearchLinkI18nPeer::ID;
        }

		if ($this->aSearchLink !== null && $this->aSearchLink->getId() !== $v) {
			$this->aSearchLink = null;
		}

	} // setId()

	/**
	 * Set the value of [culture] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCulture($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->culture !== $v) {
          $this->culture = $v;
          $this->modifiedColumns[] = SearchLinkI18nPeer::CULTURE;
        }

	} // setCulture()

	/**
	 * Set the value of [title] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTitle($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->title !== $v) {
          $this->title = $v;
          $this->modifiedColumns[] = SearchLinkI18nPeer::TITLE;
        }

	} // setTitle()

	/**
	 * Set the value of [description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->description !== $v) {
          $this->description = $v;
          $this->modifiedColumns[] = SearchLinkI18nPeer::DESCRIPTION;
        }

	} // setDescription()

	/**
	 * Set the value of [url] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUrl($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->url !== $v) {
          $this->url = $v;
          $this->modifiedColumns[] = SearchLinkI18nPeer::URL;
        }

	} // setUrl()

	/**
	 * Set the value of [meta_title] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setMetaTitle($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->meta_title !== $v) {
          $this->meta_title = $v;
          $this->modifiedColumns[] = SearchLinkI18nPeer::META_TITLE;
        }

	} // setMetaTitle()

	/**
	 * Set the value of [meta_keywords] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setMetaKeywords($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->meta_keywords !== $v) {
          $this->meta_keywords = $v;
          $this->modifiedColumns[] = SearchLinkI18nPeer::META_KEYWORDS;
        }

	} // setMetaKeywords()

	/**
	 * Set the value of [meta_description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setMetaDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->meta_description !== $v) {
          $this->meta_description = $v;
          $this->modifiedColumns[] = SearchLinkI18nPeer::META_DESCRIPTION;
        }

	} // setMetaDescription()

	/**
	 * Set the value of [search_keywords] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setSearchKeywords($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->search_keywords !== $v) {
          $this->search_keywords = $v;
          $this->modifiedColumns[] = SearchLinkI18nPeer::SEARCH_KEYWORDS;
        }

	} // setSearchKeywords()

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
      if ($this->getDispatcher()->getListeners('SearchLinkI18n.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'SearchLinkI18n.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->culture = $rs->getString($startcol + 1);

      $this->title = $rs->getString($startcol + 2);

      $this->description = $rs->getString($startcol + 3);

      $this->url = $rs->getString($startcol + 4);

      $this->meta_title = $rs->getString($startcol + 5);

      $this->meta_keywords = $rs->getString($startcol + 6);

      $this->meta_description = $rs->getString($startcol + 7);

      $this->search_keywords = $rs->getString($startcol + 8);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('SearchLinkI18n.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'SearchLinkI18n.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 9)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 9; // 9 = SearchLinkI18nPeer::NUM_COLUMNS - SearchLinkI18nPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating SearchLinkI18n object", $e);
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

    if ($this->getDispatcher()->getListeners('SearchLinkI18n.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'SearchLinkI18n.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseSearchLinkI18n:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseSearchLinkI18n:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(SearchLinkI18nPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      SearchLinkI18nPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('SearchLinkI18n.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'SearchLinkI18n.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseSearchLinkI18n:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseSearchLinkI18n:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('SearchLinkI18n.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'SearchLinkI18n.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseSearchLinkI18n:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(SearchLinkI18nPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('SearchLinkI18n.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'SearchLinkI18n.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseSearchLinkI18n:save:post') as $callable)
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

			if ($this->aSearchLink !== null) {
				if ($this->aSearchLink->isModified() || $this->aSearchLink->getCurrentSearchLinkI18n()->isModified()) {
					$affectedRows += $this->aSearchLink->save($con);
				}
				$this->setSearchLink($this->aSearchLink);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = SearchLinkI18nPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += SearchLinkI18nPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
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

			if ($this->aSearchLink !== null) {
				if (!$this->aSearchLink->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aSearchLink->getValidationFailures());
				}
			}


			if (($retval = SearchLinkI18nPeer::doValidate($this, $columns)) !== true) {
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
		$pos = SearchLinkI18nPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCulture();
				break;
			case 2:
				return $this->getTitle();
				break;
			case 3:
				return $this->getDescription();
				break;
			case 4:
				return $this->getUrl();
				break;
			case 5:
				return $this->getMetaTitle();
				break;
			case 6:
				return $this->getMetaKeywords();
				break;
			case 7:
				return $this->getMetaDescription();
				break;
			case 8:
				return $this->getSearchKeywords();
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
		$keys = SearchLinkI18nPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCulture(),
			$keys[2] => $this->getTitle(),
			$keys[3] => $this->getDescription(),
			$keys[4] => $this->getUrl(),
			$keys[5] => $this->getMetaTitle(),
			$keys[6] => $this->getMetaKeywords(),
			$keys[7] => $this->getMetaDescription(),
			$keys[8] => $this->getSearchKeywords(),
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
		$pos = SearchLinkI18nPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setCulture($value);
				break;
			case 2:
				$this->setTitle($value);
				break;
			case 3:
				$this->setDescription($value);
				break;
			case 4:
				$this->setUrl($value);
				break;
			case 5:
				$this->setMetaTitle($value);
				break;
			case 6:
				$this->setMetaKeywords($value);
				break;
			case 7:
				$this->setMetaDescription($value);
				break;
			case 8:
				$this->setSearchKeywords($value);
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
		$keys = SearchLinkI18nPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCulture($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTitle($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDescription($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setUrl($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setMetaTitle($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setMetaKeywords($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setMetaDescription($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setSearchKeywords($arr[$keys[8]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(SearchLinkI18nPeer::DATABASE_NAME);

		if ($this->isColumnModified(SearchLinkI18nPeer::ID)) $criteria->add(SearchLinkI18nPeer::ID, $this->id);
		if ($this->isColumnModified(SearchLinkI18nPeer::CULTURE)) $criteria->add(SearchLinkI18nPeer::CULTURE, $this->culture);
		if ($this->isColumnModified(SearchLinkI18nPeer::TITLE)) $criteria->add(SearchLinkI18nPeer::TITLE, $this->title);
		if ($this->isColumnModified(SearchLinkI18nPeer::DESCRIPTION)) $criteria->add(SearchLinkI18nPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(SearchLinkI18nPeer::URL)) $criteria->add(SearchLinkI18nPeer::URL, $this->url);
		if ($this->isColumnModified(SearchLinkI18nPeer::META_TITLE)) $criteria->add(SearchLinkI18nPeer::META_TITLE, $this->meta_title);
		if ($this->isColumnModified(SearchLinkI18nPeer::META_KEYWORDS)) $criteria->add(SearchLinkI18nPeer::META_KEYWORDS, $this->meta_keywords);
		if ($this->isColumnModified(SearchLinkI18nPeer::META_DESCRIPTION)) $criteria->add(SearchLinkI18nPeer::META_DESCRIPTION, $this->meta_description);
		if ($this->isColumnModified(SearchLinkI18nPeer::SEARCH_KEYWORDS)) $criteria->add(SearchLinkI18nPeer::SEARCH_KEYWORDS, $this->search_keywords);

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
		$criteria = new Criteria(SearchLinkI18nPeer::DATABASE_NAME);

		$criteria->add(SearchLinkI18nPeer::ID, $this->id);
		$criteria->add(SearchLinkI18nPeer::CULTURE, $this->culture);

		return $criteria;
	}

	/**
	 * Returns the composite primary key for this object.
	 * The array elements will be in same order as specified in XML.
	 * @return     array
	 */
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId();

		$pks[1] = $this->getCulture();

		return $pks;
	}

	/**
	 * Set the [composite] primary key.
	 *
	 * @param      array $keys The elements of the composite key (order must match the order in XML file).
	 * @return     void
	 */
	public function setPrimaryKey($keys)
	{

		$this->setId($keys[0]);

		$this->setCulture($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of SearchLinkI18n (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTitle($this->title);

		$copyObj->setDescription($this->description);

		$copyObj->setUrl($this->url);

		$copyObj->setMetaTitle($this->meta_title);

		$copyObj->setMetaKeywords($this->meta_keywords);

		$copyObj->setMetaDescription($this->meta_description);

		$copyObj->setSearchKeywords($this->search_keywords);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a pkey column, so set to default value

		$copyObj->setCulture(NULL); // this is a pkey column, so set to default value

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
	 * @return     SearchLinkI18n Clone of current object.
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
	 * @return     SearchLinkI18nPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new SearchLinkI18nPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a SearchLink object.
	 *
	 * @param      SearchLink $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setSearchLink($v)
	{


		if ($v === null) {
			$this->setId(NULL);
		} else {
			$this->setId($v->getId());
		}


		$this->aSearchLink = $v;
	}


	/**
	 * Get the associated SearchLink object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     SearchLink The associated SearchLink object.
	 * @throws     PropelException
	 */
	public function getSearchLink($con = null)
	{
		if ($this->aSearchLink === null && ($this->id !== null)) {
			// include the related Peer class
			$this->aSearchLink = SearchLinkPeer::retrieveByPK($this->id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = SearchLinkPeer::retrieveByPK($this->id, $con);
			   $obj->addSearchLinks($this);
			 */
		}
		return $this->aSearchLink;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'SearchLinkI18n.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseSearchLinkI18n:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseSearchLinkI18n::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseSearchLinkI18n
