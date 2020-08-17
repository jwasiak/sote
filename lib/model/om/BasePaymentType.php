<?php

/**
 * Base class that represents a row from the 'st_payment_type' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePaymentType extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PaymentTypePeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the module_name field.
	 * @var        string
	 */
	protected $module_name;


	/**
	 * The value for the hide_module field.
	 * @var        boolean
	 */
	protected $hide_module = false;


	/**
	 * The value for the hide_for_configuration field.
	 * @var        boolean
	 */
	protected $hide_for_configuration = false;


	/**
	 * The value for the hide_for_wholesale field.
	 * @var        boolean
	 */
	protected $hide_for_wholesale = false;


	/**
	 * The value for the active field.
	 * @var        boolean
	 */
	protected $active = true;


	/**
	 * The value for the image field.
	 * @var        string
	 */
	protected $image;


	/**
	 * The value for the configuration field.
	 * @var        string
	 */
	protected $configuration;


	/**
	 * The value for the opt_name field.
	 * @var        string
	 */
	protected $opt_name;


	/**
	 * The value for the opt_description field.
	 * @var        string
	 */
	protected $opt_description;


	/**
	 * The value for the opt_summary_description field.
	 * @var        string
	 */
	protected $opt_summary_description;

	/**
	 * Collection to store aggregation of collPayments.
	 * @var        array
	 */
	protected $collPayments;

	/**
	 * The criteria used to select the current contents of collPayments.
	 * @var        Criteria
	 */
	protected $lastPaymentCriteria = null;

	/**
	 * Collection to store aggregation of collPaymentTypeI18ns.
	 * @var        array
	 */
	protected $collPaymentTypeI18ns;

	/**
	 * The criteria used to select the current contents of collPaymentTypeI18ns.
	 * @var        Criteria
	 */
	protected $lastPaymentTypeI18nCriteria = null;

	/**
	 * Collection to store aggregation of collDeliveryHasPaymentTypes.
	 * @var        array
	 */
	protected $collDeliveryHasPaymentTypes;

	/**
	 * The criteria used to select the current contents of collDeliveryHasPaymentTypes.
	 * @var        Criteria
	 */
	protected $lastDeliveryHasPaymentTypeCriteria = null;

	/**
	 * Collection to store aggregation of collTrustedShopsHasPaymentTypes.
	 * @var        array
	 */
	protected $collTrustedShopsHasPaymentTypes;

	/**
	 * The criteria used to select the current contents of collTrustedShopsHasPaymentTypes.
	 * @var        Criteria
	 */
	protected $lastTrustedShopsHasPaymentTypeCriteria = null;

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
     * Get the [module_name] column value.
     * 
     * @return     string
     */
    public function getModuleName()
    {

            return $this->module_name;
    }

    /**
     * Get the [hide_module] column value.
     * 
     * @return     boolean
     */
    public function getHideModule()
    {

            return $this->hide_module;
    }

    /**
     * Get the [hide_for_configuration] column value.
     * 
     * @return     boolean
     */
    public function getHideForConfiguration()
    {

            return $this->hide_for_configuration;
    }

    /**
     * Get the [hide_for_wholesale] column value.
     * 
     * @return     boolean
     */
    public function getHideForWholesale()
    {

            return $this->hide_for_wholesale;
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
     * Get the [image] column value.
     * 
     * @return     string
     */
    public function getImage()
    {

            return $this->image;
    }

    /**
     * Get the [configuration] column value.
     * 
     * @return     string
     */
    public function getConfiguration()
    {

            return $this->configuration;
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
     * Get the [opt_description] column value.
     * 
     * @return     string
     */
    public function getOptDescription()
    {

            return $this->opt_description;
    }

    /**
     * Get the [opt_summary_description] column value.
     * 
     * @return     string
     */
    public function getOptSummaryDescription()
    {

            return $this->opt_summary_description;
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
          $this->modifiedColumns[] = PaymentTypePeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [module_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setModuleName($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->module_name !== $v) {
          $this->module_name = $v;
          $this->modifiedColumns[] = PaymentTypePeer::MODULE_NAME;
        }

	} // setModuleName()

	/**
	 * Set the value of [hide_module] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setHideModule($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->hide_module !== $v || $v === false) {
          $this->hide_module = $v;
          $this->modifiedColumns[] = PaymentTypePeer::HIDE_MODULE;
        }

	} // setHideModule()

	/**
	 * Set the value of [hide_for_configuration] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setHideForConfiguration($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->hide_for_configuration !== $v || $v === false) {
          $this->hide_for_configuration = $v;
          $this->modifiedColumns[] = PaymentTypePeer::HIDE_FOR_CONFIGURATION;
        }

	} // setHideForConfiguration()

	/**
	 * Set the value of [hide_for_wholesale] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setHideForWholesale($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->hide_for_wholesale !== $v || $v === false) {
          $this->hide_for_wholesale = $v;
          $this->modifiedColumns[] = PaymentTypePeer::HIDE_FOR_WHOLESALE;
        }

	} // setHideForWholesale()

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

        if ($this->active !== $v || $v === true) {
          $this->active = $v;
          $this->modifiedColumns[] = PaymentTypePeer::ACTIVE;
        }

	} // setActive()

	/**
	 * Set the value of [image] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setImage($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->image !== $v) {
          $this->image = $v;
          $this->modifiedColumns[] = PaymentTypePeer::IMAGE;
        }

	} // setImage()

	/**
	 * Set the value of [configuration] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setConfiguration($v)
	{

        if ($this->configuration !== $v) {
          $this->configuration = $v;
          $this->modifiedColumns[] = PaymentTypePeer::CONFIGURATION;
        }

	} // setConfiguration()

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
          $this->modifiedColumns[] = PaymentTypePeer::OPT_NAME;
        }

	} // setOptName()

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
          $this->modifiedColumns[] = PaymentTypePeer::OPT_DESCRIPTION;
        }

	} // setOptDescription()

	/**
	 * Set the value of [opt_summary_description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptSummaryDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_summary_description !== $v) {
          $this->opt_summary_description = $v;
          $this->modifiedColumns[] = PaymentTypePeer::OPT_SUMMARY_DESCRIPTION;
        }

	} // setOptSummaryDescription()

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
      if ($this->getDispatcher()->getListeners('PaymentType.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'PaymentType.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->module_name = $rs->getString($startcol + 1);

      $this->hide_module = $rs->getBoolean($startcol + 2);

      $this->hide_for_configuration = $rs->getBoolean($startcol + 3);

      $this->hide_for_wholesale = $rs->getBoolean($startcol + 4);

      $this->active = $rs->getBoolean($startcol + 5);

      $this->image = $rs->getString($startcol + 6);

      $this->configuration = $rs->getString($startcol + 7) ? unserialize($rs->getString($startcol + 7)) : null;

      $this->opt_name = $rs->getString($startcol + 8);

      $this->opt_description = $rs->getString($startcol + 9);

      $this->opt_summary_description = $rs->getString($startcol + 10);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('PaymentType.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'PaymentType.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 11)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 11; // 11 = PaymentTypePeer::NUM_COLUMNS - PaymentTypePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating PaymentType object", $e);
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

    if ($this->getDispatcher()->getListeners('PaymentType.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'PaymentType.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePaymentType:delete:pre'))
    {
      foreach (sfMixer::getCallables('BasePaymentType:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(PaymentTypePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      PaymentTypePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('PaymentType.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'PaymentType.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BasePaymentType:delete:post'))
    {
      foreach (sfMixer::getCallables('BasePaymentType:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('PaymentType.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'PaymentType.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BasePaymentType:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(PaymentTypePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('PaymentType.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'PaymentType.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BasePaymentType:save:post') as $callable)
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
              $o_configuration = $this->configuration;
              if (null !== $this->configuration && $this->isColumnModified(PaymentTypePeer::CONFIGURATION)) {
                  $this->configuration = serialize($this->configuration);
              }

				if ($this->isNew()) {
					$pk = PaymentTypePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PaymentTypePeer::doUpdate($this, $con);
				}
				$this->resetModified();
             $this->configuration = $o_configuration;
 // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPayments !== null) {
				foreach($this->collPayments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPaymentTypeI18ns !== null) {
				foreach($this->collPaymentTypeI18ns as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDeliveryHasPaymentTypes !== null) {
				foreach($this->collDeliveryHasPaymentTypes as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTrustedShopsHasPaymentTypes !== null) {
				foreach($this->collTrustedShopsHasPaymentTypes as $referrerFK) {
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


			if (($retval = PaymentTypePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPayments !== null) {
					foreach($this->collPayments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPaymentTypeI18ns !== null) {
					foreach($this->collPaymentTypeI18ns as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDeliveryHasPaymentTypes !== null) {
					foreach($this->collDeliveryHasPaymentTypes as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTrustedShopsHasPaymentTypes !== null) {
					foreach($this->collTrustedShopsHasPaymentTypes as $referrerFK) {
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
		$pos = PaymentTypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getModuleName();
				break;
			case 2:
				return $this->getHideModule();
				break;
			case 3:
				return $this->getHideForConfiguration();
				break;
			case 4:
				return $this->getHideForWholesale();
				break;
			case 5:
				return $this->getActive();
				break;
			case 6:
				return $this->getImage();
				break;
			case 7:
				return $this->getConfiguration();
				break;
			case 8:
				return $this->getOptName();
				break;
			case 9:
				return $this->getOptDescription();
				break;
			case 10:
				return $this->getOptSummaryDescription();
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
		$keys = PaymentTypePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getModuleName(),
			$keys[2] => $this->getHideModule(),
			$keys[3] => $this->getHideForConfiguration(),
			$keys[4] => $this->getHideForWholesale(),
			$keys[5] => $this->getActive(),
			$keys[6] => $this->getImage(),
			$keys[7] => $this->getConfiguration(),
			$keys[8] => $this->getOptName(),
			$keys[9] => $this->getOptDescription(),
			$keys[10] => $this->getOptSummaryDescription(),
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
		$pos = PaymentTypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setModuleName($value);
				break;
			case 2:
				$this->setHideModule($value);
				break;
			case 3:
				$this->setHideForConfiguration($value);
				break;
			case 4:
				$this->setHideForWholesale($value);
				break;
			case 5:
				$this->setActive($value);
				break;
			case 6:
				$this->setImage($value);
				break;
			case 7:
				$this->setConfiguration($value);
				break;
			case 8:
				$this->setOptName($value);
				break;
			case 9:
				$this->setOptDescription($value);
				break;
			case 10:
				$this->setOptSummaryDescription($value);
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
		$keys = PaymentTypePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setModuleName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setHideModule($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setHideForConfiguration($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setHideForWholesale($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setActive($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setImage($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setConfiguration($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setOptName($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setOptDescription($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setOptSummaryDescription($arr[$keys[10]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PaymentTypePeer::DATABASE_NAME);

		if ($this->isColumnModified(PaymentTypePeer::ID)) $criteria->add(PaymentTypePeer::ID, $this->id);
		if ($this->isColumnModified(PaymentTypePeer::MODULE_NAME)) $criteria->add(PaymentTypePeer::MODULE_NAME, $this->module_name);
		if ($this->isColumnModified(PaymentTypePeer::HIDE_MODULE)) $criteria->add(PaymentTypePeer::HIDE_MODULE, $this->hide_module);
		if ($this->isColumnModified(PaymentTypePeer::HIDE_FOR_CONFIGURATION)) $criteria->add(PaymentTypePeer::HIDE_FOR_CONFIGURATION, $this->hide_for_configuration);
		if ($this->isColumnModified(PaymentTypePeer::HIDE_FOR_WHOLESALE)) $criteria->add(PaymentTypePeer::HIDE_FOR_WHOLESALE, $this->hide_for_wholesale);
		if ($this->isColumnModified(PaymentTypePeer::ACTIVE)) $criteria->add(PaymentTypePeer::ACTIVE, $this->active);
		if ($this->isColumnModified(PaymentTypePeer::IMAGE)) $criteria->add(PaymentTypePeer::IMAGE, $this->image);
		if ($this->isColumnModified(PaymentTypePeer::CONFIGURATION)) $criteria->add(PaymentTypePeer::CONFIGURATION, $this->configuration);
		if ($this->isColumnModified(PaymentTypePeer::OPT_NAME)) $criteria->add(PaymentTypePeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(PaymentTypePeer::OPT_DESCRIPTION)) $criteria->add(PaymentTypePeer::OPT_DESCRIPTION, $this->opt_description);
		if ($this->isColumnModified(PaymentTypePeer::OPT_SUMMARY_DESCRIPTION)) $criteria->add(PaymentTypePeer::OPT_SUMMARY_DESCRIPTION, $this->opt_summary_description);

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
		$criteria = new Criteria(PaymentTypePeer::DATABASE_NAME);

		$criteria->add(PaymentTypePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of PaymentType (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setModuleName($this->module_name);

		$copyObj->setHideModule($this->hide_module);

		$copyObj->setHideForConfiguration($this->hide_for_configuration);

		$copyObj->setHideForWholesale($this->hide_for_wholesale);

		$copyObj->setActive($this->active);

		$copyObj->setImage($this->image);

		$copyObj->setConfiguration($this->configuration);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setOptDescription($this->opt_description);

		$copyObj->setOptSummaryDescription($this->opt_summary_description);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getPayments() as $relObj) {
				$copyObj->addPayment($relObj->copy($deepCopy));
			}

			foreach($this->getPaymentTypeI18ns() as $relObj) {
				$copyObj->addPaymentTypeI18n($relObj->copy($deepCopy));
			}

			foreach($this->getDeliveryHasPaymentTypes() as $relObj) {
				$copyObj->addDeliveryHasPaymentType($relObj->copy($deepCopy));
			}

			foreach($this->getTrustedShopsHasPaymentTypes() as $relObj) {
				$copyObj->addTrustedShopsHasPaymentType($relObj->copy($deepCopy));
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
	 * @return     PaymentType Clone of current object.
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
	 * @return     PaymentTypePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PaymentTypePeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collPayments to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPayments()
	{
		if ($this->collPayments === null) {
			$this->collPayments = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PaymentType has previously
	 * been saved, it will retrieve related Payments from storage.
	 * If this PaymentType is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPayments($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPayments === null) {
			if ($this->isNew()) {
			   $this->collPayments = array();
			} else {

				$criteria->add(PaymentPeer::PAYMENT_TYPE_ID, $this->getId());

				PaymentPeer::addSelectColumns($criteria);
				$this->collPayments = PaymentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PaymentPeer::PAYMENT_TYPE_ID, $this->getId());

				PaymentPeer::addSelectColumns($criteria);
				if (!isset($this->lastPaymentCriteria) || !$this->lastPaymentCriteria->equals($criteria)) {
					$this->collPayments = PaymentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPaymentCriteria = $criteria;
		return $this->collPayments;
	}

	/**
	 * Returns the number of related Payments.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPayments($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PaymentPeer::PAYMENT_TYPE_ID, $this->getId());

		return PaymentPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Payment object to this object
	 * through the Payment foreign key attribute
	 *
	 * @param      Payment $l Payment
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPayment(Payment $l)
	{
		$this->collPayments[] = $l;
		$l->setPaymentType($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PaymentType is new, it will return
	 * an empty collection; or if this PaymentType has previously
	 * been saved, it will retrieve related Payments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PaymentType.
	 */
	public function getPaymentsJoinsfGuardUser($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPayments === null) {
			if ($this->isNew()) {
				$this->collPayments = array();
			} else {

				$criteria->add(PaymentPeer::PAYMENT_TYPE_ID, $this->getId());

				$this->collPayments = PaymentPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PaymentPeer::PAYMENT_TYPE_ID, $this->getId());

			if (!isset($this->lastPaymentCriteria) || !$this->lastPaymentCriteria->equals($criteria)) {
				$this->collPayments = PaymentPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastPaymentCriteria = $criteria;

		return $this->collPayments;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PaymentType is new, it will return
	 * an empty collection; or if this PaymentType has previously
	 * been saved, it will retrieve related Payments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PaymentType.
	 */
	public function getPaymentsJoinGiftCard($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPayments === null) {
			if ($this->isNew()) {
				$this->collPayments = array();
			} else {

				$criteria->add(PaymentPeer::PAYMENT_TYPE_ID, $this->getId());

				$this->collPayments = PaymentPeer::doSelectJoinGiftCard($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PaymentPeer::PAYMENT_TYPE_ID, $this->getId());

			if (!isset($this->lastPaymentCriteria) || !$this->lastPaymentCriteria->equals($criteria)) {
				$this->collPayments = PaymentPeer::doSelectJoinGiftCard($criteria, $con);
			}
		}
		$this->lastPaymentCriteria = $criteria;

		return $this->collPayments;
	}

	/**
	 * Temporary storage of collPaymentTypeI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPaymentTypeI18ns()
	{
		if ($this->collPaymentTypeI18ns === null) {
			$this->collPaymentTypeI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PaymentType has previously
	 * been saved, it will retrieve related PaymentTypeI18ns from storage.
	 * If this PaymentType is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPaymentTypeI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPaymentTypeI18ns === null) {
			if ($this->isNew()) {
			   $this->collPaymentTypeI18ns = array();
			} else {

				$criteria->add(PaymentTypeI18nPeer::ID, $this->getId());

				PaymentTypeI18nPeer::addSelectColumns($criteria);
				$this->collPaymentTypeI18ns = PaymentTypeI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PaymentTypeI18nPeer::ID, $this->getId());

				PaymentTypeI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastPaymentTypeI18nCriteria) || !$this->lastPaymentTypeI18nCriteria->equals($criteria)) {
					$this->collPaymentTypeI18ns = PaymentTypeI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPaymentTypeI18nCriteria = $criteria;
		return $this->collPaymentTypeI18ns;
	}

	/**
	 * Returns the number of related PaymentTypeI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPaymentTypeI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PaymentTypeI18nPeer::ID, $this->getId());

		return PaymentTypeI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a PaymentTypeI18n object to this object
	 * through the PaymentTypeI18n foreign key attribute
	 *
	 * @param      PaymentTypeI18n $l PaymentTypeI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPaymentTypeI18n(PaymentTypeI18n $l)
	{
		$this->collPaymentTypeI18ns[] = $l;
		$l->setPaymentType($this);
	}

	/**
	 * Temporary storage of collDeliveryHasPaymentTypes to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDeliveryHasPaymentTypes()
	{
		if ($this->collDeliveryHasPaymentTypes === null) {
			$this->collDeliveryHasPaymentTypes = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PaymentType has previously
	 * been saved, it will retrieve related DeliveryHasPaymentTypes from storage.
	 * If this PaymentType is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDeliveryHasPaymentTypes($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDeliveryHasPaymentTypes === null) {
			if ($this->isNew()) {
			   $this->collDeliveryHasPaymentTypes = array();
			} else {

				$criteria->add(DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID, $this->getId());

				DeliveryHasPaymentTypePeer::addSelectColumns($criteria);
				$this->collDeliveryHasPaymentTypes = DeliveryHasPaymentTypePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID, $this->getId());

				DeliveryHasPaymentTypePeer::addSelectColumns($criteria);
				if (!isset($this->lastDeliveryHasPaymentTypeCriteria) || !$this->lastDeliveryHasPaymentTypeCriteria->equals($criteria)) {
					$this->collDeliveryHasPaymentTypes = DeliveryHasPaymentTypePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDeliveryHasPaymentTypeCriteria = $criteria;
		return $this->collDeliveryHasPaymentTypes;
	}

	/**
	 * Returns the number of related DeliveryHasPaymentTypes.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDeliveryHasPaymentTypes($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID, $this->getId());

		return DeliveryHasPaymentTypePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DeliveryHasPaymentType object to this object
	 * through the DeliveryHasPaymentType foreign key attribute
	 *
	 * @param      DeliveryHasPaymentType $l DeliveryHasPaymentType
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDeliveryHasPaymentType(DeliveryHasPaymentType $l)
	{
		$this->collDeliveryHasPaymentTypes[] = $l;
		$l->setPaymentType($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PaymentType is new, it will return
	 * an empty collection; or if this PaymentType has previously
	 * been saved, it will retrieve related DeliveryHasPaymentTypes from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PaymentType.
	 */
	public function getDeliveryHasPaymentTypesJoinDelivery($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDeliveryHasPaymentTypes === null) {
			if ($this->isNew()) {
				$this->collDeliveryHasPaymentTypes = array();
			} else {

				$criteria->add(DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID, $this->getId());

				$this->collDeliveryHasPaymentTypes = DeliveryHasPaymentTypePeer::doSelectJoinDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DeliveryHasPaymentTypePeer::PAYMENT_TYPE_ID, $this->getId());

			if (!isset($this->lastDeliveryHasPaymentTypeCriteria) || !$this->lastDeliveryHasPaymentTypeCriteria->equals($criteria)) {
				$this->collDeliveryHasPaymentTypes = DeliveryHasPaymentTypePeer::doSelectJoinDelivery($criteria, $con);
			}
		}
		$this->lastDeliveryHasPaymentTypeCriteria = $criteria;

		return $this->collDeliveryHasPaymentTypes;
	}

	/**
	 * Temporary storage of collTrustedShopsHasPaymentTypes to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initTrustedShopsHasPaymentTypes()
	{
		if ($this->collTrustedShopsHasPaymentTypes === null) {
			$this->collTrustedShopsHasPaymentTypes = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PaymentType has previously
	 * been saved, it will retrieve related TrustedShopsHasPaymentTypes from storage.
	 * If this PaymentType is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getTrustedShopsHasPaymentTypes($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTrustedShopsHasPaymentTypes === null) {
			if ($this->isNew()) {
			   $this->collTrustedShopsHasPaymentTypes = array();
			} else {

				$criteria->add(TrustedShopsHasPaymentTypePeer::PAYMENT_TYPE_ID, $this->getId());

				TrustedShopsHasPaymentTypePeer::addSelectColumns($criteria);
				$this->collTrustedShopsHasPaymentTypes = TrustedShopsHasPaymentTypePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(TrustedShopsHasPaymentTypePeer::PAYMENT_TYPE_ID, $this->getId());

				TrustedShopsHasPaymentTypePeer::addSelectColumns($criteria);
				if (!isset($this->lastTrustedShopsHasPaymentTypeCriteria) || !$this->lastTrustedShopsHasPaymentTypeCriteria->equals($criteria)) {
					$this->collTrustedShopsHasPaymentTypes = TrustedShopsHasPaymentTypePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTrustedShopsHasPaymentTypeCriteria = $criteria;
		return $this->collTrustedShopsHasPaymentTypes;
	}

	/**
	 * Returns the number of related TrustedShopsHasPaymentTypes.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countTrustedShopsHasPaymentTypes($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TrustedShopsHasPaymentTypePeer::PAYMENT_TYPE_ID, $this->getId());

		return TrustedShopsHasPaymentTypePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a TrustedShopsHasPaymentType object to this object
	 * through the TrustedShopsHasPaymentType foreign key attribute
	 *
	 * @param      TrustedShopsHasPaymentType $l TrustedShopsHasPaymentType
	 * @return     void
	 * @throws     PropelException
	 */
	public function addTrustedShopsHasPaymentType(TrustedShopsHasPaymentType $l)
	{
		$this->collTrustedShopsHasPaymentTypes[] = $l;
		$l->setPaymentType($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PaymentType is new, it will return
	 * an empty collection; or if this PaymentType has previously
	 * been saved, it will retrieve related TrustedShopsHasPaymentTypes from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PaymentType.
	 */
	public function getTrustedShopsHasPaymentTypesJoinTrustedShops($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTrustedShopsHasPaymentTypes === null) {
			if ($this->isNew()) {
				$this->collTrustedShopsHasPaymentTypes = array();
			} else {

				$criteria->add(TrustedShopsHasPaymentTypePeer::PAYMENT_TYPE_ID, $this->getId());

				$this->collTrustedShopsHasPaymentTypes = TrustedShopsHasPaymentTypePeer::doSelectJoinTrustedShops($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(TrustedShopsHasPaymentTypePeer::PAYMENT_TYPE_ID, $this->getId());

			if (!isset($this->lastTrustedShopsHasPaymentTypeCriteria) || !$this->lastTrustedShopsHasPaymentTypeCriteria->equals($criteria)) {
				$this->collTrustedShopsHasPaymentTypes = TrustedShopsHasPaymentTypePeer::doSelectJoinTrustedShops($criteria, $con);
			}
		}
		$this->lastTrustedShopsHasPaymentTypeCriteria = $criteria;

		return $this->collTrustedShopsHasPaymentTypes;
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
    $obj = $this->getCurrentPaymentTypeI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentPaymentTypeI18n()->setName($value);
  }

  public function getDescription()
  {
    $obj = $this->getCurrentPaymentTypeI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentPaymentTypeI18n()->setDescription($value);
  }

  public function getSummaryDescription()
  {
    $obj = $this->getCurrentPaymentTypeI18n();

    return ($obj ? $obj->getSummaryDescription() : null);
  }

  public function setSummaryDescription($value)
  {
    $this->getCurrentPaymentTypeI18n()->setSummaryDescription($value);
  }

  public $current_i18n = array();

  public function getCurrentPaymentTypeI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = PaymentTypeI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setPaymentTypeI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setPaymentTypeI18nForCulture(new PaymentTypeI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setPaymentTypeI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addPaymentTypeI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'PaymentType.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BasePaymentType:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BasePaymentType::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BasePaymentType
