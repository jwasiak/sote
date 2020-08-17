<?php

/**
 * Base class that represents a row from the 'st_trust_i18n' table.
 *
 * 
 *
 * @package    plugins.stTrustPlugin.lib.model.om
 */
abstract class BaseTrustI18n extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        TrustI18nPeer
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
	 * The value for the field_description field.
	 * @var        string
	 */
	protected $field_description;


	/**
	 * The value for the field_label_f field.
	 * @var        string
	 */
	protected $field_label_f;


	/**
	 * The value for the field_sub_label_f field.
	 * @var        string
	 */
	protected $field_sub_label_f;


	/**
	 * The value for the field_description_f field.
	 * @var        string
	 */
	protected $field_description_f;


	/**
	 * The value for the icon_f field.
	 * @var        string
	 */
	protected $icon_f;


	/**
	 * The value for the field_label_s field.
	 * @var        string
	 */
	protected $field_label_s;


	/**
	 * The value for the field_sub_label_s field.
	 * @var        string
	 */
	protected $field_sub_label_s;


	/**
	 * The value for the field_description_s field.
	 * @var        string
	 */
	protected $field_description_s;


	/**
	 * The value for the icon_s field.
	 * @var        string
	 */
	protected $icon_s;


	/**
	 * The value for the field_label_t field.
	 * @var        string
	 */
	protected $field_label_t;


	/**
	 * The value for the field_sub_label_t field.
	 * @var        string
	 */
	protected $field_sub_label_t;


	/**
	 * The value for the field_description_t field.
	 * @var        string
	 */
	protected $field_description_t;


	/**
	 * The value for the icon_t field.
	 * @var        string
	 */
	protected $icon_t;

	/**
	 * @var        Trust
	 */
	protected $aTrust;

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
     * Get the [field_description] column value.
     * 
     * @return     string
     */
    public function getFieldDescription()
    {

            return $this->field_description;
    }

    /**
     * Get the [field_label_f] column value.
     * 
     * @return     string
     */
    public function getFieldLabelF()
    {

            return $this->field_label_f;
    }

    /**
     * Get the [field_sub_label_f] column value.
     * 
     * @return     string
     */
    public function getFieldSubLabelF()
    {

            return $this->field_sub_label_f;
    }

    /**
     * Get the [field_description_f] column value.
     * 
     * @return     string
     */
    public function getFieldDescriptionF()
    {

            return $this->field_description_f;
    }

    /**
     * Get the [icon_f] column value.
     * 
     * @return     string
     */
    public function getIconF()
    {

            return $this->icon_f;
    }

    /**
     * Get the [field_label_s] column value.
     * 
     * @return     string
     */
    public function getFieldLabelS()
    {

            return $this->field_label_s;
    }

    /**
     * Get the [field_sub_label_s] column value.
     * 
     * @return     string
     */
    public function getFieldSubLabelS()
    {

            return $this->field_sub_label_s;
    }

    /**
     * Get the [field_description_s] column value.
     * 
     * @return     string
     */
    public function getFieldDescriptionS()
    {

            return $this->field_description_s;
    }

    /**
     * Get the [icon_s] column value.
     * 
     * @return     string
     */
    public function getIconS()
    {

            return $this->icon_s;
    }

    /**
     * Get the [field_label_t] column value.
     * 
     * @return     string
     */
    public function getFieldLabelT()
    {

            return $this->field_label_t;
    }

    /**
     * Get the [field_sub_label_t] column value.
     * 
     * @return     string
     */
    public function getFieldSubLabelT()
    {

            return $this->field_sub_label_t;
    }

    /**
     * Get the [field_description_t] column value.
     * 
     * @return     string
     */
    public function getFieldDescriptionT()
    {

            return $this->field_description_t;
    }

    /**
     * Get the [icon_t] column value.
     * 
     * @return     string
     */
    public function getIconT()
    {

            return $this->icon_t;
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
          $this->modifiedColumns[] = TrustI18nPeer::ID;
        }

		if ($this->aTrust !== null && $this->aTrust->getId() !== $v) {
			$this->aTrust = null;
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
          $this->modifiedColumns[] = TrustI18nPeer::CULTURE;
        }

	} // setCulture()

	/**
	 * Set the value of [field_description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFieldDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->field_description !== $v) {
          $this->field_description = $v;
          $this->modifiedColumns[] = TrustI18nPeer::FIELD_DESCRIPTION;
        }

	} // setFieldDescription()

	/**
	 * Set the value of [field_label_f] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFieldLabelF($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->field_label_f !== $v) {
          $this->field_label_f = $v;
          $this->modifiedColumns[] = TrustI18nPeer::FIELD_LABEL_F;
        }

	} // setFieldLabelF()

	/**
	 * Set the value of [field_sub_label_f] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFieldSubLabelF($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->field_sub_label_f !== $v) {
          $this->field_sub_label_f = $v;
          $this->modifiedColumns[] = TrustI18nPeer::FIELD_SUB_LABEL_F;
        }

	} // setFieldSubLabelF()

	/**
	 * Set the value of [field_description_f] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFieldDescriptionF($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->field_description_f !== $v) {
          $this->field_description_f = $v;
          $this->modifiedColumns[] = TrustI18nPeer::FIELD_DESCRIPTION_F;
        }

	} // setFieldDescriptionF()

	/**
	 * Set the value of [icon_f] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setIconF($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->icon_f !== $v) {
          $this->icon_f = $v;
          $this->modifiedColumns[] = TrustI18nPeer::ICON_F;
        }

	} // setIconF()

	/**
	 * Set the value of [field_label_s] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFieldLabelS($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->field_label_s !== $v) {
          $this->field_label_s = $v;
          $this->modifiedColumns[] = TrustI18nPeer::FIELD_LABEL_S;
        }

	} // setFieldLabelS()

	/**
	 * Set the value of [field_sub_label_s] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFieldSubLabelS($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->field_sub_label_s !== $v) {
          $this->field_sub_label_s = $v;
          $this->modifiedColumns[] = TrustI18nPeer::FIELD_SUB_LABEL_S;
        }

	} // setFieldSubLabelS()

	/**
	 * Set the value of [field_description_s] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFieldDescriptionS($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->field_description_s !== $v) {
          $this->field_description_s = $v;
          $this->modifiedColumns[] = TrustI18nPeer::FIELD_DESCRIPTION_S;
        }

	} // setFieldDescriptionS()

	/**
	 * Set the value of [icon_s] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setIconS($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->icon_s !== $v) {
          $this->icon_s = $v;
          $this->modifiedColumns[] = TrustI18nPeer::ICON_S;
        }

	} // setIconS()

	/**
	 * Set the value of [field_label_t] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFieldLabelT($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->field_label_t !== $v) {
          $this->field_label_t = $v;
          $this->modifiedColumns[] = TrustI18nPeer::FIELD_LABEL_T;
        }

	} // setFieldLabelT()

	/**
	 * Set the value of [field_sub_label_t] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFieldSubLabelT($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->field_sub_label_t !== $v) {
          $this->field_sub_label_t = $v;
          $this->modifiedColumns[] = TrustI18nPeer::FIELD_SUB_LABEL_T;
        }

	} // setFieldSubLabelT()

	/**
	 * Set the value of [field_description_t] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFieldDescriptionT($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->field_description_t !== $v) {
          $this->field_description_t = $v;
          $this->modifiedColumns[] = TrustI18nPeer::FIELD_DESCRIPTION_T;
        }

	} // setFieldDescriptionT()

	/**
	 * Set the value of [icon_t] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setIconT($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->icon_t !== $v) {
          $this->icon_t = $v;
          $this->modifiedColumns[] = TrustI18nPeer::ICON_T;
        }

	} // setIconT()

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
      if ($this->getDispatcher()->getListeners('TrustI18n.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'TrustI18n.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->culture = $rs->getString($startcol + 1);

      $this->field_description = $rs->getString($startcol + 2);

      $this->field_label_f = $rs->getString($startcol + 3);

      $this->field_sub_label_f = $rs->getString($startcol + 4);

      $this->field_description_f = $rs->getString($startcol + 5);

      $this->icon_f = $rs->getString($startcol + 6);

      $this->field_label_s = $rs->getString($startcol + 7);

      $this->field_sub_label_s = $rs->getString($startcol + 8);

      $this->field_description_s = $rs->getString($startcol + 9);

      $this->icon_s = $rs->getString($startcol + 10);

      $this->field_label_t = $rs->getString($startcol + 11);

      $this->field_sub_label_t = $rs->getString($startcol + 12);

      $this->field_description_t = $rs->getString($startcol + 13);

      $this->icon_t = $rs->getString($startcol + 14);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('TrustI18n.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'TrustI18n.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 15)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 15; // 15 = TrustI18nPeer::NUM_COLUMNS - TrustI18nPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating TrustI18n object", $e);
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

    if ($this->getDispatcher()->getListeners('TrustI18n.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'TrustI18n.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTrustI18n:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseTrustI18n:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(TrustI18nPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      TrustI18nPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('TrustI18n.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'TrustI18n.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTrustI18n:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseTrustI18n:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('TrustI18n.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'TrustI18n.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseTrustI18n:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(TrustI18nPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('TrustI18n.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'TrustI18n.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseTrustI18n:save:post') as $callable)
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

			if ($this->aTrust !== null) {
				if ($this->aTrust->isModified() || $this->aTrust->getCurrentTrustI18n()->isModified()) {
					$affectedRows += $this->aTrust->save($con);
				}
				$this->setTrust($this->aTrust);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TrustI18nPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += TrustI18nPeer::doUpdate($this, $con);
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

			if ($this->aTrust !== null) {
				if (!$this->aTrust->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTrust->getValidationFailures());
				}
			}


			if (($retval = TrustI18nPeer::doValidate($this, $columns)) !== true) {
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
		$pos = TrustI18nPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getFieldDescription();
				break;
			case 3:
				return $this->getFieldLabelF();
				break;
			case 4:
				return $this->getFieldSubLabelF();
				break;
			case 5:
				return $this->getFieldDescriptionF();
				break;
			case 6:
				return $this->getIconF();
				break;
			case 7:
				return $this->getFieldLabelS();
				break;
			case 8:
				return $this->getFieldSubLabelS();
				break;
			case 9:
				return $this->getFieldDescriptionS();
				break;
			case 10:
				return $this->getIconS();
				break;
			case 11:
				return $this->getFieldLabelT();
				break;
			case 12:
				return $this->getFieldSubLabelT();
				break;
			case 13:
				return $this->getFieldDescriptionT();
				break;
			case 14:
				return $this->getIconT();
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
		$keys = TrustI18nPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCulture(),
			$keys[2] => $this->getFieldDescription(),
			$keys[3] => $this->getFieldLabelF(),
			$keys[4] => $this->getFieldSubLabelF(),
			$keys[5] => $this->getFieldDescriptionF(),
			$keys[6] => $this->getIconF(),
			$keys[7] => $this->getFieldLabelS(),
			$keys[8] => $this->getFieldSubLabelS(),
			$keys[9] => $this->getFieldDescriptionS(),
			$keys[10] => $this->getIconS(),
			$keys[11] => $this->getFieldLabelT(),
			$keys[12] => $this->getFieldSubLabelT(),
			$keys[13] => $this->getFieldDescriptionT(),
			$keys[14] => $this->getIconT(),
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
		$pos = TrustI18nPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setFieldDescription($value);
				break;
			case 3:
				$this->setFieldLabelF($value);
				break;
			case 4:
				$this->setFieldSubLabelF($value);
				break;
			case 5:
				$this->setFieldDescriptionF($value);
				break;
			case 6:
				$this->setIconF($value);
				break;
			case 7:
				$this->setFieldLabelS($value);
				break;
			case 8:
				$this->setFieldSubLabelS($value);
				break;
			case 9:
				$this->setFieldDescriptionS($value);
				break;
			case 10:
				$this->setIconS($value);
				break;
			case 11:
				$this->setFieldLabelT($value);
				break;
			case 12:
				$this->setFieldSubLabelT($value);
				break;
			case 13:
				$this->setFieldDescriptionT($value);
				break;
			case 14:
				$this->setIconT($value);
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
		$keys = TrustI18nPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCulture($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setFieldDescription($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setFieldLabelF($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setFieldSubLabelF($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setFieldDescriptionF($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIconF($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setFieldLabelS($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setFieldSubLabelS($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setFieldDescriptionS($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setIconS($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setFieldLabelT($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setFieldSubLabelT($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setFieldDescriptionT($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setIconT($arr[$keys[14]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(TrustI18nPeer::DATABASE_NAME);

		if ($this->isColumnModified(TrustI18nPeer::ID)) $criteria->add(TrustI18nPeer::ID, $this->id);
		if ($this->isColumnModified(TrustI18nPeer::CULTURE)) $criteria->add(TrustI18nPeer::CULTURE, $this->culture);
		if ($this->isColumnModified(TrustI18nPeer::FIELD_DESCRIPTION)) $criteria->add(TrustI18nPeer::FIELD_DESCRIPTION, $this->field_description);
		if ($this->isColumnModified(TrustI18nPeer::FIELD_LABEL_F)) $criteria->add(TrustI18nPeer::FIELD_LABEL_F, $this->field_label_f);
		if ($this->isColumnModified(TrustI18nPeer::FIELD_SUB_LABEL_F)) $criteria->add(TrustI18nPeer::FIELD_SUB_LABEL_F, $this->field_sub_label_f);
		if ($this->isColumnModified(TrustI18nPeer::FIELD_DESCRIPTION_F)) $criteria->add(TrustI18nPeer::FIELD_DESCRIPTION_F, $this->field_description_f);
		if ($this->isColumnModified(TrustI18nPeer::ICON_F)) $criteria->add(TrustI18nPeer::ICON_F, $this->icon_f);
		if ($this->isColumnModified(TrustI18nPeer::FIELD_LABEL_S)) $criteria->add(TrustI18nPeer::FIELD_LABEL_S, $this->field_label_s);
		if ($this->isColumnModified(TrustI18nPeer::FIELD_SUB_LABEL_S)) $criteria->add(TrustI18nPeer::FIELD_SUB_LABEL_S, $this->field_sub_label_s);
		if ($this->isColumnModified(TrustI18nPeer::FIELD_DESCRIPTION_S)) $criteria->add(TrustI18nPeer::FIELD_DESCRIPTION_S, $this->field_description_s);
		if ($this->isColumnModified(TrustI18nPeer::ICON_S)) $criteria->add(TrustI18nPeer::ICON_S, $this->icon_s);
		if ($this->isColumnModified(TrustI18nPeer::FIELD_LABEL_T)) $criteria->add(TrustI18nPeer::FIELD_LABEL_T, $this->field_label_t);
		if ($this->isColumnModified(TrustI18nPeer::FIELD_SUB_LABEL_T)) $criteria->add(TrustI18nPeer::FIELD_SUB_LABEL_T, $this->field_sub_label_t);
		if ($this->isColumnModified(TrustI18nPeer::FIELD_DESCRIPTION_T)) $criteria->add(TrustI18nPeer::FIELD_DESCRIPTION_T, $this->field_description_t);
		if ($this->isColumnModified(TrustI18nPeer::ICON_T)) $criteria->add(TrustI18nPeer::ICON_T, $this->icon_t);

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
		$criteria = new Criteria(TrustI18nPeer::DATABASE_NAME);

		$criteria->add(TrustI18nPeer::ID, $this->id);
		$criteria->add(TrustI18nPeer::CULTURE, $this->culture);

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
	 * @param      object $copyObj An object of TrustI18n (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setFieldDescription($this->field_description);

		$copyObj->setFieldLabelF($this->field_label_f);

		$copyObj->setFieldSubLabelF($this->field_sub_label_f);

		$copyObj->setFieldDescriptionF($this->field_description_f);

		$copyObj->setIconF($this->icon_f);

		$copyObj->setFieldLabelS($this->field_label_s);

		$copyObj->setFieldSubLabelS($this->field_sub_label_s);

		$copyObj->setFieldDescriptionS($this->field_description_s);

		$copyObj->setIconS($this->icon_s);

		$copyObj->setFieldLabelT($this->field_label_t);

		$copyObj->setFieldSubLabelT($this->field_sub_label_t);

		$copyObj->setFieldDescriptionT($this->field_description_t);

		$copyObj->setIconT($this->icon_t);


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
	 * @return     TrustI18n Clone of current object.
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
	 * @return     TrustI18nPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new TrustI18nPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Trust object.
	 *
	 * @param      Trust $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setTrust($v)
	{


		if ($v === null) {
			$this->setId(NULL);
		} else {
			$this->setId($v->getId());
		}


		$this->aTrust = $v;
	}


	/**
	 * Get the associated Trust object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Trust The associated Trust object.
	 * @throws     PropelException
	 */
	public function getTrust($con = null)
	{
		if ($this->aTrust === null && ($this->id !== null)) {
			// include the related Peer class
			$this->aTrust = TrustPeer::retrieveByPK($this->id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = TrustPeer::retrieveByPK($this->id, $con);
			   $obj->addTrusts($this);
			 */
		}
		return $this->aTrust;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'TrustI18n.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseTrustI18n:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseTrustI18n::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseTrustI18n
