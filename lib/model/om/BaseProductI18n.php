<?php

/**
 * Base class that represents a row from the 'st_product_i18n' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseProductI18n extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ProductI18nPeer
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
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the short_description field.
	 * @var        string
	 */
	protected $short_description;


	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;


	/**
	 * The value for the search_keywords field.
	 * @var        string
	 */
	protected $search_keywords;


	/**
	 * The value for the url field.
	 * @var        string
	 */
	protected $url;


	/**
	 * The value for the uom field.
	 * @var        string
	 */
	protected $uom;


	/**
	 * The value for the execution_time field.
	 * @var        string
	 */
	protected $execution_time;


	/**
	 * The value for the description2 field.
	 * @var        string
	 */
	protected $description2;


	/**
	 * The value for the attributes_label field.
	 * @var        string
	 */
	protected $attributes_label;

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
     * Get the [name] column value.
     * 
     * @return     string
     */
    public function getName()
    {

            return $this->name;
    }

    /**
     * Get the [short_description] column value.
     * 
     * @return     string
     */
    public function getShortDescription()
    {

            return $this->short_description;
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
     * Get the [search_keywords] column value.
     * 
     * @return     string
     */
    public function getSearchKeywords()
    {

            return $this->search_keywords;
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
     * Get the [uom] column value.
     * 
     * @return     string
     */
    public function getUom()
    {

            return $this->uom;
    }

    /**
     * Get the [execution_time] column value.
     * 
     * @return     string
     */
    public function getExecutionTime()
    {

            return $this->execution_time;
    }

    /**
     * Get the [description2] column value.
     * 
     * @return     string
     */
    public function getDescription2()
    {

            return $this->description2;
    }

    /**
     * Get the [attributes_label] column value.
     * 
     * @return     string
     */
    public function getAttributesLabel()
    {

            return $this->attributes_label;
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
          $this->modifiedColumns[] = ProductI18nPeer::ID;
        }

		if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
			$this->aProduct = null;
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
          $this->modifiedColumns[] = ProductI18nPeer::CULTURE;
        }

	} // setCulture()

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
          $this->modifiedColumns[] = ProductI18nPeer::NAME;
        }

	} // setName()

	/**
	 * Set the value of [short_description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setShortDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->short_description !== $v) {
          $this->short_description = $v;
          $this->modifiedColumns[] = ProductI18nPeer::SHORT_DESCRIPTION;
        }

	} // setShortDescription()

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
          $this->modifiedColumns[] = ProductI18nPeer::DESCRIPTION;
        }

	} // setDescription()

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
          $this->modifiedColumns[] = ProductI18nPeer::SEARCH_KEYWORDS;
        }

	} // setSearchKeywords()

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
          $this->modifiedColumns[] = ProductI18nPeer::URL;
        }

	} // setUrl()

	/**
	 * Set the value of [uom] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUom($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->uom !== $v) {
          $this->uom = $v;
          $this->modifiedColumns[] = ProductI18nPeer::UOM;
        }

	} // setUom()

	/**
	 * Set the value of [execution_time] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setExecutionTime($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->execution_time !== $v) {
          $this->execution_time = $v;
          $this->modifiedColumns[] = ProductI18nPeer::EXECUTION_TIME;
        }

	} // setExecutionTime()

	/**
	 * Set the value of [description2] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setDescription2($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->description2 !== $v) {
          $this->description2 = $v;
          $this->modifiedColumns[] = ProductI18nPeer::DESCRIPTION2;
        }

	} // setDescription2()

	/**
	 * Set the value of [attributes_label] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setAttributesLabel($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->attributes_label !== $v) {
          $this->attributes_label = $v;
          $this->modifiedColumns[] = ProductI18nPeer::ATTRIBUTES_LABEL;
        }

	} // setAttributesLabel()

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
      if ($this->getDispatcher()->getListeners('ProductI18n.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductI18n.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->culture = $rs->getString($startcol + 1);

      $this->name = $rs->getString($startcol + 2);

      $this->short_description = $rs->getString($startcol + 3);

      $this->description = $rs->getString($startcol + 4);

      $this->search_keywords = $rs->getString($startcol + 5);

      $this->url = $rs->getString($startcol + 6);

      $this->uom = $rs->getString($startcol + 7);

      $this->execution_time = $rs->getString($startcol + 8);

      $this->description2 = $rs->getString($startcol + 9);

      $this->attributes_label = $rs->getString($startcol + 10);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('ProductI18n.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductI18n.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 11)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 11; // 11 = ProductI18nPeer::NUM_COLUMNS - ProductI18nPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating ProductI18n object", $e);
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

    if ($this->getDispatcher()->getListeners('ProductI18n.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductI18n.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductI18n:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseProductI18n:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ProductI18nPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ProductI18nPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('ProductI18n.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductI18n.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductI18n:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseProductI18n:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('ProductI18n.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'ProductI18n.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseProductI18n:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(ProductI18nPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('ProductI18n.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'ProductI18n.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseProductI18n:save:post') as $callable)
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
				if ($this->isNew()) {
					$pk = ProductI18nPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += ProductI18nPeer::doUpdate($this, $con);
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

			if ($this->aProduct !== null) {
				if (!$this->aProduct->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProduct->getValidationFailures());
				}
			}


			if (($retval = ProductI18nPeer::doValidate($this, $columns)) !== true) {
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
		$pos = ProductI18nPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getName();
				break;
			case 3:
				return $this->getShortDescription();
				break;
			case 4:
				return $this->getDescription();
				break;
			case 5:
				return $this->getSearchKeywords();
				break;
			case 6:
				return $this->getUrl();
				break;
			case 7:
				return $this->getUom();
				break;
			case 8:
				return $this->getExecutionTime();
				break;
			case 9:
				return $this->getDescription2();
				break;
			case 10:
				return $this->getAttributesLabel();
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
		$keys = ProductI18nPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCulture(),
			$keys[2] => $this->getName(),
			$keys[3] => $this->getShortDescription(),
			$keys[4] => $this->getDescription(),
			$keys[5] => $this->getSearchKeywords(),
			$keys[6] => $this->getUrl(),
			$keys[7] => $this->getUom(),
			$keys[8] => $this->getExecutionTime(),
			$keys[9] => $this->getDescription2(),
			$keys[10] => $this->getAttributesLabel(),
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
		$pos = ProductI18nPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setName($value);
				break;
			case 3:
				$this->setShortDescription($value);
				break;
			case 4:
				$this->setDescription($value);
				break;
			case 5:
				$this->setSearchKeywords($value);
				break;
			case 6:
				$this->setUrl($value);
				break;
			case 7:
				$this->setUom($value);
				break;
			case 8:
				$this->setExecutionTime($value);
				break;
			case 9:
				$this->setDescription2($value);
				break;
			case 10:
				$this->setAttributesLabel($value);
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
		$keys = ProductI18nPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCulture($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setShortDescription($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDescription($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setSearchKeywords($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setUrl($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setUom($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setExecutionTime($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setDescription2($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setAttributesLabel($arr[$keys[10]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ProductI18nPeer::DATABASE_NAME);

		if ($this->isColumnModified(ProductI18nPeer::ID)) $criteria->add(ProductI18nPeer::ID, $this->id);
		if ($this->isColumnModified(ProductI18nPeer::CULTURE)) $criteria->add(ProductI18nPeer::CULTURE, $this->culture);
		if ($this->isColumnModified(ProductI18nPeer::NAME)) $criteria->add(ProductI18nPeer::NAME, $this->name);
		if ($this->isColumnModified(ProductI18nPeer::SHORT_DESCRIPTION)) $criteria->add(ProductI18nPeer::SHORT_DESCRIPTION, $this->short_description);
		if ($this->isColumnModified(ProductI18nPeer::DESCRIPTION)) $criteria->add(ProductI18nPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(ProductI18nPeer::SEARCH_KEYWORDS)) $criteria->add(ProductI18nPeer::SEARCH_KEYWORDS, $this->search_keywords);
		if ($this->isColumnModified(ProductI18nPeer::URL)) $criteria->add(ProductI18nPeer::URL, $this->url);
		if ($this->isColumnModified(ProductI18nPeer::UOM)) $criteria->add(ProductI18nPeer::UOM, $this->uom);
		if ($this->isColumnModified(ProductI18nPeer::EXECUTION_TIME)) $criteria->add(ProductI18nPeer::EXECUTION_TIME, $this->execution_time);
		if ($this->isColumnModified(ProductI18nPeer::DESCRIPTION2)) $criteria->add(ProductI18nPeer::DESCRIPTION2, $this->description2);
		if ($this->isColumnModified(ProductI18nPeer::ATTRIBUTES_LABEL)) $criteria->add(ProductI18nPeer::ATTRIBUTES_LABEL, $this->attributes_label);

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
		$criteria = new Criteria(ProductI18nPeer::DATABASE_NAME);

		$criteria->add(ProductI18nPeer::ID, $this->id);
		$criteria->add(ProductI18nPeer::CULTURE, $this->culture);

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
	 * @param      object $copyObj An object of ProductI18n (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setShortDescription($this->short_description);

		$copyObj->setDescription($this->description);

		$copyObj->setSearchKeywords($this->search_keywords);

		$copyObj->setUrl($this->url);

		$copyObj->setUom($this->uom);

		$copyObj->setExecutionTime($this->execution_time);

		$copyObj->setDescription2($this->description2);

		$copyObj->setAttributesLabel($this->attributes_label);


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
	 * @return     ProductI18n Clone of current object.
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
	 * @return     ProductI18nPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ProductI18nPeer();
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
			$this->setId(NULL);
		} else {
			$this->setId($v->getId());
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
		if ($this->aProduct === null && ($this->id !== null)) {
			// include the related Peer class
			$this->aProduct = ProductPeer::retrieveByPK($this->id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductPeer::retrieveByPK($this->id, $con);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'ProductI18n.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseProductI18n:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseProductI18n::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseProductI18n
