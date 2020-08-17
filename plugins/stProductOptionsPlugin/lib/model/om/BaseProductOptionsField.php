<?php

/**
 * Base class that represents a row from the 'st_product_options_field' table.
 *
 * 
 *
 * @package    plugins.stProductOptionsPlugin.lib.model.om
 */
abstract class BaseProductOptionsField extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ProductOptionsFieldPeer
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
	 * The value for the product_options_template_id field.
	 * @var        int
	 */
	protected $product_options_template_id;


	/**
	 * The value for the product_options_filter_id field.
	 * @var        int
	 */
	protected $product_options_filter_id;


	/**
	 * The value for the required field.
	 * @var        boolean
	 */
	protected $required;


	/**
	 * The value for the typ field.
	 * @var        string
	 */
	protected $typ;


	/**
	 * The value for the opt_name field.
	 * @var        string
	 */
	protected $opt_name;


	/**
	 * The value for the opt_default_value field.
	 * @var        string
	 */
	protected $opt_default_value;


	/**
	 * The value for the opt_value_id field.
	 * @var        int
	 */
	protected $opt_value_id;


	/**
	 * The value for the field_order field.
	 * @var        int
	 */
	protected $field_order;

	/**
	 * @var        ProductOptionsTemplate
	 */
	protected $aProductOptionsTemplate;

	/**
	 * @var        ProductOptionsFilter
	 */
	protected $aProductOptionsFilter;

	/**
	 * Collection to store aggregation of collProductOptionsDefaultValues.
	 * @var        array
	 */
	protected $collProductOptionsDefaultValues;

	/**
	 * The criteria used to select the current contents of collProductOptionsDefaultValues.
	 * @var        Criteria
	 */
	protected $lastProductOptionsDefaultValueCriteria = null;

	/**
	 * Collection to store aggregation of collProductOptionsValues.
	 * @var        array
	 */
	protected $collProductOptionsValues;

	/**
	 * The criteria used to select the current contents of collProductOptionsValues.
	 * @var        Criteria
	 */
	protected $lastProductOptionsValueCriteria = null;

	/**
	 * Collection to store aggregation of collProductOptionsFieldI18ns.
	 * @var        array
	 */
	protected $collProductOptionsFieldI18ns;

	/**
	 * The criteria used to select the current contents of collProductOptionsFieldI18ns.
	 * @var        Criteria
	 */
	protected $lastProductOptionsFieldI18nCriteria = null;

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
     * Get the [product_options_template_id] column value.
     * 
     * @return     int
     */
    public function getProductOptionsTemplateId()
    {

            return $this->product_options_template_id;
    }

    /**
     * Get the [product_options_filter_id] column value.
     * 
     * @return     int
     */
    public function getProductOptionsFilterId()
    {

            return $this->product_options_filter_id;
    }

    /**
     * Get the [required] column value.
     * 
     * @return     boolean
     */
    public function getRequired()
    {

            return $this->required;
    }

    /**
     * Get the [typ] column value.
     * 
     * @return     string
     */
    public function getTyp()
    {

            return $this->typ;
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
     * Get the [opt_default_value] column value.
     * 
     * @return     string
     */
    public function getOptDefaultValue()
    {

            return $this->opt_default_value;
    }

    /**
     * Get the [opt_value_id] column value.
     * 
     * @return     int
     */
    public function getOptValueId()
    {

            return $this->opt_value_id;
    }

    /**
     * Get the [field_order] column value.
     * 
     * @return     int
     */
    public function getFieldOrder()
    {

            return $this->field_order;
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
			$this->modifiedColumns[] = ProductOptionsFieldPeer::CREATED_AT;
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
			$this->modifiedColumns[] = ProductOptionsFieldPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = ProductOptionsFieldPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [product_options_template_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setProductOptionsTemplateId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->product_options_template_id !== $v) {
          $this->product_options_template_id = $v;
          $this->modifiedColumns[] = ProductOptionsFieldPeer::PRODUCT_OPTIONS_TEMPLATE_ID;
        }

		if ($this->aProductOptionsTemplate !== null && $this->aProductOptionsTemplate->getId() !== $v) {
			$this->aProductOptionsTemplate = null;
		}

	} // setProductOptionsTemplateId()

	/**
	 * Set the value of [product_options_filter_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setProductOptionsFilterId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->product_options_filter_id !== $v) {
          $this->product_options_filter_id = $v;
          $this->modifiedColumns[] = ProductOptionsFieldPeer::PRODUCT_OPTIONS_FILTER_ID;
        }

		if ($this->aProductOptionsFilter !== null && $this->aProductOptionsFilter->getId() !== $v) {
			$this->aProductOptionsFilter = null;
		}

	} // setProductOptionsFilterId()

	/**
	 * Set the value of [required] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setRequired($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->required !== $v) {
          $this->required = $v;
          $this->modifiedColumns[] = ProductOptionsFieldPeer::REQUIRED;
        }

	} // setRequired()

	/**
	 * Set the value of [typ] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTyp($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->typ !== $v) {
          $this->typ = $v;
          $this->modifiedColumns[] = ProductOptionsFieldPeer::TYP;
        }

	} // setTyp()

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
          $this->modifiedColumns[] = ProductOptionsFieldPeer::OPT_NAME;
        }

	} // setOptName()

	/**
	 * Set the value of [opt_default_value] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptDefaultValue($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_default_value !== $v) {
          $this->opt_default_value = $v;
          $this->modifiedColumns[] = ProductOptionsFieldPeer::OPT_DEFAULT_VALUE;
        }

	} // setOptDefaultValue()

	/**
	 * Set the value of [opt_value_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOptValueId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->opt_value_id !== $v) {
          $this->opt_value_id = $v;
          $this->modifiedColumns[] = ProductOptionsFieldPeer::OPT_VALUE_ID;
        }

	} // setOptValueId()

	/**
	 * Set the value of [field_order] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setFieldOrder($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->field_order !== $v) {
          $this->field_order = $v;
          $this->modifiedColumns[] = ProductOptionsFieldPeer::FIELD_ORDER;
        }

	} // setFieldOrder()

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
      if ($this->getDispatcher()->getListeners('ProductOptionsField.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsField.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->product_options_template_id = $rs->getInt($startcol + 3);

      $this->product_options_filter_id = $rs->getInt($startcol + 4);

      $this->required = $rs->getBoolean($startcol + 5);

      $this->typ = $rs->getString($startcol + 6);

      $this->opt_name = $rs->getString($startcol + 7);

      $this->opt_default_value = $rs->getString($startcol + 8);

      $this->opt_value_id = $rs->getInt($startcol + 9);

      $this->field_order = $rs->getInt($startcol + 10);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('ProductOptionsField.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsField.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 11)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 11; // 11 = ProductOptionsFieldPeer::NUM_COLUMNS - ProductOptionsFieldPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating ProductOptionsField object", $e);
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

    if ($this->getDispatcher()->getListeners('ProductOptionsField.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsField.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductOptionsField:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseProductOptionsField:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ProductOptionsFieldPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ProductOptionsFieldPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('ProductOptionsField.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsField.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductOptionsField:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseProductOptionsField:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('ProductOptionsField.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsField.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseProductOptionsField:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(ProductOptionsFieldPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ProductOptionsFieldPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(ProductOptionsFieldPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('ProductOptionsField.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'ProductOptionsField.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseProductOptionsField:save:post') as $callable)
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

			if ($this->aProductOptionsTemplate !== null) {
				if ($this->aProductOptionsTemplate->isModified() || $this->aProductOptionsTemplate->getCurrentProductOptionsTemplateI18n()->isModified()) {
					$affectedRows += $this->aProductOptionsTemplate->save($con);
				}
				$this->setProductOptionsTemplate($this->aProductOptionsTemplate);
			}

			if ($this->aProductOptionsFilter !== null) {
				if ($this->aProductOptionsFilter->isModified() || $this->aProductOptionsFilter->getCurrentProductOptionsFilterI18n()->isModified()) {
					$affectedRows += $this->aProductOptionsFilter->save($con);
				}
				$this->setProductOptionsFilter($this->aProductOptionsFilter);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ProductOptionsFieldPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ProductOptionsFieldPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collProductOptionsDefaultValues !== null) {
				foreach($this->collProductOptionsDefaultValues as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductOptionsValues !== null) {
				foreach($this->collProductOptionsValues as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductOptionsFieldI18ns !== null) {
				foreach($this->collProductOptionsFieldI18ns as $referrerFK) {
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

			if ($this->aProductOptionsTemplate !== null) {
				if (!$this->aProductOptionsTemplate->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProductOptionsTemplate->getValidationFailures());
				}
			}

			if ($this->aProductOptionsFilter !== null) {
				if (!$this->aProductOptionsFilter->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProductOptionsFilter->getValidationFailures());
				}
			}


			if (($retval = ProductOptionsFieldPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collProductOptionsDefaultValues !== null) {
					foreach($this->collProductOptionsDefaultValues as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductOptionsValues !== null) {
					foreach($this->collProductOptionsValues as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductOptionsFieldI18ns !== null) {
					foreach($this->collProductOptionsFieldI18ns as $referrerFK) {
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
		$pos = ProductOptionsFieldPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getProductOptionsTemplateId();
				break;
			case 4:
				return $this->getProductOptionsFilterId();
				break;
			case 5:
				return $this->getRequired();
				break;
			case 6:
				return $this->getTyp();
				break;
			case 7:
				return $this->getOptName();
				break;
			case 8:
				return $this->getOptDefaultValue();
				break;
			case 9:
				return $this->getOptValueId();
				break;
			case 10:
				return $this->getFieldOrder();
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
		$keys = ProductOptionsFieldPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getProductOptionsTemplateId(),
			$keys[4] => $this->getProductOptionsFilterId(),
			$keys[5] => $this->getRequired(),
			$keys[6] => $this->getTyp(),
			$keys[7] => $this->getOptName(),
			$keys[8] => $this->getOptDefaultValue(),
			$keys[9] => $this->getOptValueId(),
			$keys[10] => $this->getFieldOrder(),
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
		$pos = ProductOptionsFieldPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setProductOptionsTemplateId($value);
				break;
			case 4:
				$this->setProductOptionsFilterId($value);
				break;
			case 5:
				$this->setRequired($value);
				break;
			case 6:
				$this->setTyp($value);
				break;
			case 7:
				$this->setOptName($value);
				break;
			case 8:
				$this->setOptDefaultValue($value);
				break;
			case 9:
				$this->setOptValueId($value);
				break;
			case 10:
				$this->setFieldOrder($value);
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
		$keys = ProductOptionsFieldPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setProductOptionsTemplateId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setProductOptionsFilterId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setRequired($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setTyp($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setOptName($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setOptDefaultValue($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setOptValueId($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setFieldOrder($arr[$keys[10]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ProductOptionsFieldPeer::DATABASE_NAME);

		if ($this->isColumnModified(ProductOptionsFieldPeer::CREATED_AT)) $criteria->add(ProductOptionsFieldPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ProductOptionsFieldPeer::UPDATED_AT)) $criteria->add(ProductOptionsFieldPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(ProductOptionsFieldPeer::ID)) $criteria->add(ProductOptionsFieldPeer::ID, $this->id);
		if ($this->isColumnModified(ProductOptionsFieldPeer::PRODUCT_OPTIONS_TEMPLATE_ID)) $criteria->add(ProductOptionsFieldPeer::PRODUCT_OPTIONS_TEMPLATE_ID, $this->product_options_template_id);
		if ($this->isColumnModified(ProductOptionsFieldPeer::PRODUCT_OPTIONS_FILTER_ID)) $criteria->add(ProductOptionsFieldPeer::PRODUCT_OPTIONS_FILTER_ID, $this->product_options_filter_id);
		if ($this->isColumnModified(ProductOptionsFieldPeer::REQUIRED)) $criteria->add(ProductOptionsFieldPeer::REQUIRED, $this->required);
		if ($this->isColumnModified(ProductOptionsFieldPeer::TYP)) $criteria->add(ProductOptionsFieldPeer::TYP, $this->typ);
		if ($this->isColumnModified(ProductOptionsFieldPeer::OPT_NAME)) $criteria->add(ProductOptionsFieldPeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(ProductOptionsFieldPeer::OPT_DEFAULT_VALUE)) $criteria->add(ProductOptionsFieldPeer::OPT_DEFAULT_VALUE, $this->opt_default_value);
		if ($this->isColumnModified(ProductOptionsFieldPeer::OPT_VALUE_ID)) $criteria->add(ProductOptionsFieldPeer::OPT_VALUE_ID, $this->opt_value_id);
		if ($this->isColumnModified(ProductOptionsFieldPeer::FIELD_ORDER)) $criteria->add(ProductOptionsFieldPeer::FIELD_ORDER, $this->field_order);

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
		$criteria = new Criteria(ProductOptionsFieldPeer::DATABASE_NAME);

		$criteria->add(ProductOptionsFieldPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of ProductOptionsField (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setProductOptionsTemplateId($this->product_options_template_id);

		$copyObj->setProductOptionsFilterId($this->product_options_filter_id);

		$copyObj->setRequired($this->required);

		$copyObj->setTyp($this->typ);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setOptDefaultValue($this->opt_default_value);

		$copyObj->setOptValueId($this->opt_value_id);

		$copyObj->setFieldOrder($this->field_order);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getProductOptionsDefaultValues() as $relObj) {
				$copyObj->addProductOptionsDefaultValue($relObj->copy($deepCopy));
			}

			foreach($this->getProductOptionsValues() as $relObj) {
				$copyObj->addProductOptionsValue($relObj->copy($deepCopy));
			}

			foreach($this->getProductOptionsFieldI18ns() as $relObj) {
				$copyObj->addProductOptionsFieldI18n($relObj->copy($deepCopy));
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
	 * @return     ProductOptionsField Clone of current object.
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
	 * @return     ProductOptionsFieldPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ProductOptionsFieldPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a ProductOptionsTemplate object.
	 *
	 * @param      ProductOptionsTemplate $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setProductOptionsTemplate($v)
	{


		if ($v === null) {
			$this->setProductOptionsTemplateId(NULL);
		} else {
			$this->setProductOptionsTemplateId($v->getId());
		}


		$this->aProductOptionsTemplate = $v;
	}


	/**
	 * Get the associated ProductOptionsTemplate object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     ProductOptionsTemplate The associated ProductOptionsTemplate object.
	 * @throws     PropelException
	 */
	public function getProductOptionsTemplate($con = null)
	{
		if ($this->aProductOptionsTemplate === null && ($this->product_options_template_id !== null)) {
			// include the related Peer class
			$this->aProductOptionsTemplate = ProductOptionsTemplatePeer::retrieveByPK($this->product_options_template_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductOptionsTemplatePeer::retrieveByPK($this->product_options_template_id, $con);
			   $obj->addProductOptionsTemplates($this);
			 */
		}
		return $this->aProductOptionsTemplate;
	}

	/**
	 * Declares an association between this object and a ProductOptionsFilter object.
	 *
	 * @param      ProductOptionsFilter $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setProductOptionsFilter($v)
	{


		if ($v === null) {
			$this->setProductOptionsFilterId(NULL);
		} else {
			$this->setProductOptionsFilterId($v->getId());
		}


		$this->aProductOptionsFilter = $v;
	}


	/**
	 * Get the associated ProductOptionsFilter object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     ProductOptionsFilter The associated ProductOptionsFilter object.
	 * @throws     PropelException
	 */
	public function getProductOptionsFilter($con = null)
	{
		if ($this->aProductOptionsFilter === null && ($this->product_options_filter_id !== null)) {
			// include the related Peer class
			$this->aProductOptionsFilter = ProductOptionsFilterPeer::retrieveByPK($this->product_options_filter_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductOptionsFilterPeer::retrieveByPK($this->product_options_filter_id, $con);
			   $obj->addProductOptionsFilters($this);
			 */
		}
		return $this->aProductOptionsFilter;
	}

	/**
	 * Temporary storage of collProductOptionsDefaultValues to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductOptionsDefaultValues()
	{
		if ($this->collProductOptionsDefaultValues === null) {
			$this->collProductOptionsDefaultValues = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsField has previously
	 * been saved, it will retrieve related ProductOptionsDefaultValues from storage.
	 * If this ProductOptionsField is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductOptionsDefaultValues($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsDefaultValues === null) {
			if ($this->isNew()) {
			   $this->collProductOptionsDefaultValues = array();
			} else {

				$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

				ProductOptionsDefaultValuePeer::addSelectColumns($criteria);
				$this->collProductOptionsDefaultValues = ProductOptionsDefaultValuePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

				ProductOptionsDefaultValuePeer::addSelectColumns($criteria);
				if (!isset($this->lastProductOptionsDefaultValueCriteria) || !$this->lastProductOptionsDefaultValueCriteria->equals($criteria)) {
					$this->collProductOptionsDefaultValues = ProductOptionsDefaultValuePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductOptionsDefaultValueCriteria = $criteria;
		return $this->collProductOptionsDefaultValues;
	}

	/**
	 * Returns the number of related ProductOptionsDefaultValues.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductOptionsDefaultValues($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

		return ProductOptionsDefaultValuePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductOptionsDefaultValue object to this object
	 * through the ProductOptionsDefaultValue foreign key attribute
	 *
	 * @param      ProductOptionsDefaultValue $l ProductOptionsDefaultValue
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductOptionsDefaultValue(ProductOptionsDefaultValue $l)
	{
		$this->collProductOptionsDefaultValues[] = $l;
		$l->setProductOptionsField($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsField is new, it will return
	 * an empty collection; or if this ProductOptionsField has previously
	 * been saved, it will retrieve related ProductOptionsDefaultValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsField.
	 */
	public function getProductOptionsDefaultValuesJoinProductOptionsTemplate($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsDefaultValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsDefaultValues = array();
			} else {

				$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

				$this->collProductOptionsDefaultValues = ProductOptionsDefaultValuePeer::doSelectJoinProductOptionsTemplate($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

			if (!isset($this->lastProductOptionsDefaultValueCriteria) || !$this->lastProductOptionsDefaultValueCriteria->equals($criteria)) {
				$this->collProductOptionsDefaultValues = ProductOptionsDefaultValuePeer::doSelectJoinProductOptionsTemplate($criteria, $con);
			}
		}
		$this->lastProductOptionsDefaultValueCriteria = $criteria;

		return $this->collProductOptionsDefaultValues;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsField is new, it will return
	 * an empty collection; or if this ProductOptionsField has previously
	 * been saved, it will retrieve related ProductOptionsDefaultValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsField.
	 */
	public function getProductOptionsDefaultValuesJoinProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsDefaultValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsDefaultValues = array();
			} else {

				$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

				$this->collProductOptionsDefaultValues = ProductOptionsDefaultValuePeer::doSelectJoinProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

			if (!isset($this->lastProductOptionsDefaultValueCriteria) || !$this->lastProductOptionsDefaultValueCriteria->equals($criteria)) {
				$this->collProductOptionsDefaultValues = ProductOptionsDefaultValuePeer::doSelectJoinProductOptionsDefaultValueRelatedByProductOptionsDefaultValueId($criteria, $con);
			}
		}
		$this->lastProductOptionsDefaultValueCriteria = $criteria;

		return $this->collProductOptionsDefaultValues;
	}

	/**
	 * Temporary storage of collProductOptionsValues to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductOptionsValues()
	{
		if ($this->collProductOptionsValues === null) {
			$this->collProductOptionsValues = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsField has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 * If this ProductOptionsField is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductOptionsValues($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
			   $this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

				ProductOptionsValuePeer::addSelectColumns($criteria);
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

				ProductOptionsValuePeer::addSelectColumns($criteria);
				if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
					$this->collProductOptionsValues = ProductOptionsValuePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;
		return $this->collProductOptionsValues;
	}

	/**
	 * Returns the number of related ProductOptionsValues.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductOptionsValues($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

		return ProductOptionsValuePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductOptionsValue object to this object
	 * through the ProductOptionsValue foreign key attribute
	 *
	 * @param      ProductOptionsValue $l ProductOptionsValue
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductOptionsValue(ProductOptionsValue $l)
	{
		$this->collProductOptionsValues[] = $l;
		$l->setProductOptionsField($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsField is new, it will return
	 * an empty collection; or if this ProductOptionsField has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsField.
	 */
	public function getProductOptionsValuesJoinsfAsset($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinsfAsset($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinsfAsset($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsField is new, it will return
	 * an empty collection; or if this ProductOptionsField has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsField.
	 */
	public function getProductOptionsValuesJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsField is new, it will return
	 * an empty collection; or if this ProductOptionsField has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsField.
	 */
	public function getProductOptionsValuesJoinProductOptionsTemplate($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsTemplate($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsTemplate($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsField is new, it will return
	 * an empty collection; or if this ProductOptionsField has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in ProductOptionsField.
	 */
	public function getProductOptionsValuesJoinProductOptionsValueRelatedByProductOptionsValueId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsValueRelatedByProductOptionsValueId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsValueRelatedByProductOptionsValueId($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}

	/**
	 * Temporary storage of collProductOptionsFieldI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductOptionsFieldI18ns()
	{
		if ($this->collProductOptionsFieldI18ns === null) {
			$this->collProductOptionsFieldI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this ProductOptionsField has previously
	 * been saved, it will retrieve related ProductOptionsFieldI18ns from storage.
	 * If this ProductOptionsField is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductOptionsFieldI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsFieldI18ns === null) {
			if ($this->isNew()) {
			   $this->collProductOptionsFieldI18ns = array();
			} else {

				$criteria->add(ProductOptionsFieldI18nPeer::ID, $this->getId());

				ProductOptionsFieldI18nPeer::addSelectColumns($criteria);
				$this->collProductOptionsFieldI18ns = ProductOptionsFieldI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductOptionsFieldI18nPeer::ID, $this->getId());

				ProductOptionsFieldI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductOptionsFieldI18nCriteria) || !$this->lastProductOptionsFieldI18nCriteria->equals($criteria)) {
					$this->collProductOptionsFieldI18ns = ProductOptionsFieldI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductOptionsFieldI18nCriteria = $criteria;
		return $this->collProductOptionsFieldI18ns;
	}

	/**
	 * Returns the number of related ProductOptionsFieldI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductOptionsFieldI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductOptionsFieldI18nPeer::ID, $this->getId());

		return ProductOptionsFieldI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductOptionsFieldI18n object to this object
	 * through the ProductOptionsFieldI18n foreign key attribute
	 *
	 * @param      ProductOptionsFieldI18n $l ProductOptionsFieldI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductOptionsFieldI18n(ProductOptionsFieldI18n $l)
	{
		$this->collProductOptionsFieldI18ns[] = $l;
		$l->setProductOptionsField($this);
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
    $obj = $this->getCurrentProductOptionsFieldI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentProductOptionsFieldI18n()->setName($value);
  }

  public function getDefaultValue()
  {
    $obj = $this->getCurrentProductOptionsFieldI18n();

    return ($obj ? $obj->getDefaultValue() : null);
  }

  public function setDefaultValue($value)
  {
    $this->getCurrentProductOptionsFieldI18n()->setDefaultValue($value);
  }

  public $current_i18n = array();

  public function getCurrentProductOptionsFieldI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = ProductOptionsFieldI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setProductOptionsFieldI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setProductOptionsFieldI18nForCulture(new ProductOptionsFieldI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setProductOptionsFieldI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addProductOptionsFieldI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'ProductOptionsField.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseProductOptionsField:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseProductOptionsField::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseProductOptionsField
