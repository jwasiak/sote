<?php

/**
 * Base class that represents a row from the 'st_positioning_i18n' table.
 *
 * 
 *
 * @package    plugins.stPositioningPlugin.lib.model.om
 */
abstract class BasePositioningI18n extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PositioningI18nPeer
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
	 * The value for the keywords field.
	 * @var        string
	 */
	protected $keywords;


	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;


	/**
	 * The value for the title_product field.
	 * @var        string
	 */
	protected $title_product;


	/**
	 * The value for the title_category field.
	 * @var        string
	 */
	protected $title_category;


	/**
	 * The value for the title_manufacteur field.
	 * @var        string
	 */
	protected $title_manufacteur;


	/**
	 * The value for the title_blog field.
	 * @var        string
	 */
	protected $title_blog;


	/**
	 * The value for the title_product_group field.
	 * @var        string
	 */
	protected $title_product_group;


	/**
	 * The value for the title_webpage field.
	 * @var        string
	 */
	protected $title_webpage;


	/**
	 * The value for the type field.
	 * @var        int
	 */
	protected $type;


	/**
	 * The value for the default_title field.
	 * @var        string
	 */
	protected $default_title;

	/**
	 * @var        Positioning
	 */
	protected $aPositioning;

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
     * Get the [keywords] column value.
     * 
     * @return     string
     */
    public function getKeywords()
    {

            return $this->keywords;
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
     * Get the [title_product] column value.
     * 
     * @return     string
     */
    public function getTitleProduct()
    {

            return $this->title_product;
    }

    /**
     * Get the [title_category] column value.
     * 
     * @return     string
     */
    public function getTitleCategory()
    {

            return $this->title_category;
    }

    /**
     * Get the [title_manufacteur] column value.
     * 
     * @return     string
     */
    public function getTitleManufacteur()
    {

            return $this->title_manufacteur;
    }

    /**
     * Get the [title_blog] column value.
     * 
     * @return     string
     */
    public function getTitleBlog()
    {

            return $this->title_blog;
    }

    /**
     * Get the [title_product_group] column value.
     * 
     * @return     string
     */
    public function getTitleProductGroup()
    {

            return $this->title_product_group;
    }

    /**
     * Get the [title_webpage] column value.
     * 
     * @return     string
     */
    public function getTitleWebpage()
    {

            return $this->title_webpage;
    }

    /**
     * Get the [type] column value.
     * 
     * @return     int
     */
    public function getType()
    {

            return $this->type;
    }

    /**
     * Get the [default_title] column value.
     * 
     * @return     string
     */
    public function getDefaultTitle()
    {

            return $this->default_title;
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
          $this->modifiedColumns[] = PositioningI18nPeer::ID;
        }

		if ($this->aPositioning !== null && $this->aPositioning->getId() !== $v) {
			$this->aPositioning = null;
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
          $this->modifiedColumns[] = PositioningI18nPeer::CULTURE;
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
          $this->modifiedColumns[] = PositioningI18nPeer::TITLE;
        }

	} // setTitle()

	/**
	 * Set the value of [keywords] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setKeywords($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->keywords !== $v) {
          $this->keywords = $v;
          $this->modifiedColumns[] = PositioningI18nPeer::KEYWORDS;
        }

	} // setKeywords()

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
          $this->modifiedColumns[] = PositioningI18nPeer::DESCRIPTION;
        }

	} // setDescription()

	/**
	 * Set the value of [title_product] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTitleProduct($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->title_product !== $v) {
          $this->title_product = $v;
          $this->modifiedColumns[] = PositioningI18nPeer::TITLE_PRODUCT;
        }

	} // setTitleProduct()

	/**
	 * Set the value of [title_category] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTitleCategory($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->title_category !== $v) {
          $this->title_category = $v;
          $this->modifiedColumns[] = PositioningI18nPeer::TITLE_CATEGORY;
        }

	} // setTitleCategory()

	/**
	 * Set the value of [title_manufacteur] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTitleManufacteur($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->title_manufacteur !== $v) {
          $this->title_manufacteur = $v;
          $this->modifiedColumns[] = PositioningI18nPeer::TITLE_MANUFACTEUR;
        }

	} // setTitleManufacteur()

	/**
	 * Set the value of [title_blog] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTitleBlog($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->title_blog !== $v) {
          $this->title_blog = $v;
          $this->modifiedColumns[] = PositioningI18nPeer::TITLE_BLOG;
        }

	} // setTitleBlog()

	/**
	 * Set the value of [title_product_group] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTitleProductGroup($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->title_product_group !== $v) {
          $this->title_product_group = $v;
          $this->modifiedColumns[] = PositioningI18nPeer::TITLE_PRODUCT_GROUP;
        }

	} // setTitleProductGroup()

	/**
	 * Set the value of [title_webpage] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTitleWebpage($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->title_webpage !== $v) {
          $this->title_webpage = $v;
          $this->modifiedColumns[] = PositioningI18nPeer::TITLE_WEBPAGE;
        }

	} // setTitleWebpage()

	/**
	 * Set the value of [type] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setType($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->type !== $v) {
          $this->type = $v;
          $this->modifiedColumns[] = PositioningI18nPeer::TYPE;
        }

	} // setType()

	/**
	 * Set the value of [default_title] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setDefaultTitle($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->default_title !== $v) {
          $this->default_title = $v;
          $this->modifiedColumns[] = PositioningI18nPeer::DEFAULT_TITLE;
        }

	} // setDefaultTitle()

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
      if ($this->getDispatcher()->getListeners('PositioningI18n.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'PositioningI18n.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->culture = $rs->getString($startcol + 1);

      $this->title = $rs->getString($startcol + 2);

      $this->keywords = $rs->getString($startcol + 3);

      $this->description = $rs->getString($startcol + 4);

      $this->title_product = $rs->getString($startcol + 5);

      $this->title_category = $rs->getString($startcol + 6);

      $this->title_manufacteur = $rs->getString($startcol + 7);

      $this->title_blog = $rs->getString($startcol + 8);

      $this->title_product_group = $rs->getString($startcol + 9);

      $this->title_webpage = $rs->getString($startcol + 10);

      $this->type = $rs->getInt($startcol + 11);

      $this->default_title = $rs->getString($startcol + 12);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('PositioningI18n.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'PositioningI18n.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 13)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 13; // 13 = PositioningI18nPeer::NUM_COLUMNS - PositioningI18nPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating PositioningI18n object", $e);
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

    if ($this->getDispatcher()->getListeners('PositioningI18n.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'PositioningI18n.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePositioningI18n:delete:pre'))
    {
      foreach (sfMixer::getCallables('BasePositioningI18n:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(PositioningI18nPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      PositioningI18nPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('PositioningI18n.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'PositioningI18n.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePositioningI18n:delete:post'))
    {
      foreach (sfMixer::getCallables('BasePositioningI18n:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('PositioningI18n.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'PositioningI18n.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BasePositioningI18n:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(PositioningI18nPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('PositioningI18n.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'PositioningI18n.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BasePositioningI18n:save:post') as $callable)
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

			if ($this->aPositioning !== null) {
				if ($this->aPositioning->isModified() || $this->aPositioning->getCurrentPositioningI18n()->isModified()) {
					$affectedRows += $this->aPositioning->save($con);
				}
				$this->setPositioning($this->aPositioning);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PositioningI18nPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += PositioningI18nPeer::doUpdate($this, $con);
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

			if ($this->aPositioning !== null) {
				if (!$this->aPositioning->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPositioning->getValidationFailures());
				}
			}


			if (($retval = PositioningI18nPeer::doValidate($this, $columns)) !== true) {
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
		$pos = PositioningI18nPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getKeywords();
				break;
			case 4:
				return $this->getDescription();
				break;
			case 5:
				return $this->getTitleProduct();
				break;
			case 6:
				return $this->getTitleCategory();
				break;
			case 7:
				return $this->getTitleManufacteur();
				break;
			case 8:
				return $this->getTitleBlog();
				break;
			case 9:
				return $this->getTitleProductGroup();
				break;
			case 10:
				return $this->getTitleWebpage();
				break;
			case 11:
				return $this->getType();
				break;
			case 12:
				return $this->getDefaultTitle();
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
		$keys = PositioningI18nPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCulture(),
			$keys[2] => $this->getTitle(),
			$keys[3] => $this->getKeywords(),
			$keys[4] => $this->getDescription(),
			$keys[5] => $this->getTitleProduct(),
			$keys[6] => $this->getTitleCategory(),
			$keys[7] => $this->getTitleManufacteur(),
			$keys[8] => $this->getTitleBlog(),
			$keys[9] => $this->getTitleProductGroup(),
			$keys[10] => $this->getTitleWebpage(),
			$keys[11] => $this->getType(),
			$keys[12] => $this->getDefaultTitle(),
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
		$pos = PositioningI18nPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setKeywords($value);
				break;
			case 4:
				$this->setDescription($value);
				break;
			case 5:
				$this->setTitleProduct($value);
				break;
			case 6:
				$this->setTitleCategory($value);
				break;
			case 7:
				$this->setTitleManufacteur($value);
				break;
			case 8:
				$this->setTitleBlog($value);
				break;
			case 9:
				$this->setTitleProductGroup($value);
				break;
			case 10:
				$this->setTitleWebpage($value);
				break;
			case 11:
				$this->setType($value);
				break;
			case 12:
				$this->setDefaultTitle($value);
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
		$keys = PositioningI18nPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCulture($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTitle($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setKeywords($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDescription($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setTitleProduct($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setTitleCategory($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setTitleManufacteur($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setTitleBlog($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setTitleProductGroup($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setTitleWebpage($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setType($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setDefaultTitle($arr[$keys[12]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PositioningI18nPeer::DATABASE_NAME);

		if ($this->isColumnModified(PositioningI18nPeer::ID)) $criteria->add(PositioningI18nPeer::ID, $this->id);
		if ($this->isColumnModified(PositioningI18nPeer::CULTURE)) $criteria->add(PositioningI18nPeer::CULTURE, $this->culture);
		if ($this->isColumnModified(PositioningI18nPeer::TITLE)) $criteria->add(PositioningI18nPeer::TITLE, $this->title);
		if ($this->isColumnModified(PositioningI18nPeer::KEYWORDS)) $criteria->add(PositioningI18nPeer::KEYWORDS, $this->keywords);
		if ($this->isColumnModified(PositioningI18nPeer::DESCRIPTION)) $criteria->add(PositioningI18nPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(PositioningI18nPeer::TITLE_PRODUCT)) $criteria->add(PositioningI18nPeer::TITLE_PRODUCT, $this->title_product);
		if ($this->isColumnModified(PositioningI18nPeer::TITLE_CATEGORY)) $criteria->add(PositioningI18nPeer::TITLE_CATEGORY, $this->title_category);
		if ($this->isColumnModified(PositioningI18nPeer::TITLE_MANUFACTEUR)) $criteria->add(PositioningI18nPeer::TITLE_MANUFACTEUR, $this->title_manufacteur);
		if ($this->isColumnModified(PositioningI18nPeer::TITLE_BLOG)) $criteria->add(PositioningI18nPeer::TITLE_BLOG, $this->title_blog);
		if ($this->isColumnModified(PositioningI18nPeer::TITLE_PRODUCT_GROUP)) $criteria->add(PositioningI18nPeer::TITLE_PRODUCT_GROUP, $this->title_product_group);
		if ($this->isColumnModified(PositioningI18nPeer::TITLE_WEBPAGE)) $criteria->add(PositioningI18nPeer::TITLE_WEBPAGE, $this->title_webpage);
		if ($this->isColumnModified(PositioningI18nPeer::TYPE)) $criteria->add(PositioningI18nPeer::TYPE, $this->type);
		if ($this->isColumnModified(PositioningI18nPeer::DEFAULT_TITLE)) $criteria->add(PositioningI18nPeer::DEFAULT_TITLE, $this->default_title);

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
		$criteria = new Criteria(PositioningI18nPeer::DATABASE_NAME);

		$criteria->add(PositioningI18nPeer::ID, $this->id);
		$criteria->add(PositioningI18nPeer::CULTURE, $this->culture);

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
	 * @param      object $copyObj An object of PositioningI18n (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTitle($this->title);

		$copyObj->setKeywords($this->keywords);

		$copyObj->setDescription($this->description);

		$copyObj->setTitleProduct($this->title_product);

		$copyObj->setTitleCategory($this->title_category);

		$copyObj->setTitleManufacteur($this->title_manufacteur);

		$copyObj->setTitleBlog($this->title_blog);

		$copyObj->setTitleProductGroup($this->title_product_group);

		$copyObj->setTitleWebpage($this->title_webpage);

		$copyObj->setType($this->type);

		$copyObj->setDefaultTitle($this->default_title);


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
	 * @return     PositioningI18n Clone of current object.
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
	 * @return     PositioningI18nPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PositioningI18nPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Positioning object.
	 *
	 * @param      Positioning $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setPositioning($v)
	{


		if ($v === null) {
			$this->setId(NULL);
		} else {
			$this->setId($v->getId());
		}


		$this->aPositioning = $v;
	}


	/**
	 * Get the associated Positioning object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Positioning The associated Positioning object.
	 * @throws     PropelException
	 */
	public function getPositioning($con = null)
	{
		if ($this->aPositioning === null && ($this->id !== null)) {
			// include the related Peer class
			$this->aPositioning = PositioningPeer::retrieveByPK($this->id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = PositioningPeer::retrieveByPK($this->id, $con);
			   $obj->addPositionings($this);
			 */
		}
		return $this->aPositioning;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'PositioningI18n.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BasePositioningI18n:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BasePositioningI18n::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BasePositioningI18n
