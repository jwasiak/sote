<?php

/**
 * Base class that represents a row from the 'st_tax' table.
 *
 * 
 *
 * @package    plugins.stTaxPlugin.lib.model.om
 */
abstract class BaseTax extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        TaxPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the vat field.
	 * @var        double
	 */
	protected $vat = 0;


	/**
	 * The value for the is_default field.
	 * @var        boolean
	 */
	protected $is_default = false;


	/**
	 * The value for the is_active field.
	 * @var        boolean
	 */
	protected $is_active = true;


	/**
	 * The value for the vat_name field.
	 * @var        string
	 */
	protected $vat_name;


	/**
	 * The value for the is_system_default field.
	 * @var        boolean
	 */
	protected $is_system_default = false;


	/**
	 * The value for the update_resume field.
	 * @var        string
	 */
	protected $update_resume;

	/**
	 * Collection to store aggregation of collProducts.
	 * @var        array
	 */
	protected $collProducts;

	/**
	 * The criteria used to select the current contents of collProducts.
	 * @var        Criteria
	 */
	protected $lastProductCriteria = null;

	/**
	 * Collection to store aggregation of collAddPrices.
	 * @var        array
	 */
	protected $collAddPrices;

	/**
	 * The criteria used to select the current contents of collAddPrices.
	 * @var        Criteria
	 */
	protected $lastAddPriceCriteria = null;

	/**
	 * Collection to store aggregation of collAddGroupPrices.
	 * @var        array
	 */
	protected $collAddGroupPrices;

	/**
	 * The criteria used to select the current contents of collAddGroupPrices.
	 * @var        Criteria
	 */
	protected $lastAddGroupPriceCriteria = null;

	/**
	 * Collection to store aggregation of collOrderProducts.
	 * @var        array
	 */
	protected $collOrderProducts;

	/**
	 * The criteria used to select the current contents of collOrderProducts.
	 * @var        Criteria
	 */
	protected $lastOrderProductCriteria = null;

	/**
	 * Collection to store aggregation of collOrderDeliverys.
	 * @var        array
	 */
	protected $collOrderDeliverys;

	/**
	 * The criteria used to select the current contents of collOrderDeliverys.
	 * @var        Criteria
	 */
	protected $lastOrderDeliveryCriteria = null;

	/**
	 * Collection to store aggregation of collGroupPrices.
	 * @var        array
	 */
	protected $collGroupPrices;

	/**
	 * The criteria used to select the current contents of collGroupPrices.
	 * @var        Criteria
	 */
	protected $lastGroupPriceCriteria = null;

	/**
	 * Collection to store aggregation of collDeliverys.
	 * @var        array
	 */
	protected $collDeliverys;

	/**
	 * The criteria used to select the current contents of collDeliverys.
	 * @var        Criteria
	 */
	protected $lastDeliveryCriteria = null;

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
     * Get the [vat] column value.
     * 
     * @return     double
     */
    public function getVat()
    {

            return null !== $this->vat ? (string)$this->vat : null;
    }

    /**
     * Get the [is_default] column value.
     * 
     * @return     boolean
     */
    public function getIsDefault()
    {

            return $this->is_default;
    }

    /**
     * Get the [is_active] column value.
     * 
     * @return     boolean
     */
    public function getIsActive()
    {

            return $this->is_active;
    }

    /**
     * Get the [vat_name] column value.
     * 
     * @return     string
     */
    public function getVatName()
    {

            return $this->vat_name;
    }

    /**
     * Get the [is_system_default] column value.
     * 
     * @return     boolean
     */
    public function getIsSystemDefault()
    {

            return $this->is_system_default;
    }

    /**
     * Get the [update_resume] column value.
     * 
     * @return     string
     */
    public function getUpdateResume()
    {

            return $this->update_resume;
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
          $this->modifiedColumns[] = TaxPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [vat] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setVat($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->vat !== $v || $v === 0) {
          $this->vat = $v;
          $this->modifiedColumns[] = TaxPeer::VAT;
        }

	} // setVat()

	/**
	 * Set the value of [is_default] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsDefault($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_default !== $v || $v === false) {
          $this->is_default = $v;
          $this->modifiedColumns[] = TaxPeer::IS_DEFAULT;
        }

	} // setIsDefault()

	/**
	 * Set the value of [is_active] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsActive($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_active !== $v || $v === true) {
          $this->is_active = $v;
          $this->modifiedColumns[] = TaxPeer::IS_ACTIVE;
        }

	} // setIsActive()

	/**
	 * Set the value of [vat_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setVatName($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->vat_name !== $v) {
          $this->vat_name = $v;
          $this->modifiedColumns[] = TaxPeer::VAT_NAME;
        }

	} // setVatName()

	/**
	 * Set the value of [is_system_default] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsSystemDefault($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_system_default !== $v || $v === false) {
          $this->is_system_default = $v;
          $this->modifiedColumns[] = TaxPeer::IS_SYSTEM_DEFAULT;
        }

	} // setIsSystemDefault()

	/**
	 * Set the value of [update_resume] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUpdateResume($v)
	{

        if ($this->update_resume !== $v) {
          $this->update_resume = $v;
          $this->modifiedColumns[] = TaxPeer::UPDATE_RESUME;
        }

	} // setUpdateResume()

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
      if ($this->getDispatcher()->getListeners('Tax.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Tax.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->vat = $rs->getString($startcol + 1);
      if (null !== $this->vat && $this->vat == intval($this->vat))
      {
        $this->vat = (string)intval($this->vat);
      }

      $this->is_default = $rs->getBoolean($startcol + 2);

      $this->is_active = $rs->getBoolean($startcol + 3);

      $this->vat_name = $rs->getString($startcol + 4);

      $this->is_system_default = $rs->getBoolean($startcol + 5);

      $this->update_resume = $rs->getString($startcol + 6) ? unserialize($rs->getString($startcol + 6)) : null;

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Tax.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Tax.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 7)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 7; // 7 = TaxPeer::NUM_COLUMNS - TaxPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Tax object", $e);
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

    if ($this->getDispatcher()->getListeners('Tax.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Tax.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTax:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseTax:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(TaxPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      TaxPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Tax.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Tax.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseTax:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseTax:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Tax.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Tax.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseTax:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(TaxPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Tax.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Tax.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseTax:save:post') as $callable)
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
              $o_update_resume = $this->update_resume;
              if (null !== $this->update_resume && $this->isColumnModified(TaxPeer::UPDATE_RESUME)) {
                  $this->update_resume = serialize($this->update_resume);
              }

				if ($this->isNew()) {
					$pk = TaxPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += TaxPeer::doUpdate($this, $con);
				}
				$this->resetModified();
             $this->update_resume = $o_update_resume;
 // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collProducts !== null) {
				foreach($this->collProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAddPrices !== null) {
				foreach($this->collAddPrices as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAddGroupPrices !== null) {
				foreach($this->collAddGroupPrices as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOrderProducts !== null) {
				foreach($this->collOrderProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOrderDeliverys !== null) {
				foreach($this->collOrderDeliverys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGroupPrices !== null) {
				foreach($this->collGroupPrices as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDeliverys !== null) {
				foreach($this->collDeliverys as $referrerFK) {
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


			if (($retval = TaxPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collProducts !== null) {
					foreach($this->collProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAddPrices !== null) {
					foreach($this->collAddPrices as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAddGroupPrices !== null) {
					foreach($this->collAddGroupPrices as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOrderProducts !== null) {
					foreach($this->collOrderProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOrderDeliverys !== null) {
					foreach($this->collOrderDeliverys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGroupPrices !== null) {
					foreach($this->collGroupPrices as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDeliverys !== null) {
					foreach($this->collDeliverys as $referrerFK) {
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
		$pos = TaxPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getVat();
				break;
			case 2:
				return $this->getIsDefault();
				break;
			case 3:
				return $this->getIsActive();
				break;
			case 4:
				return $this->getVatName();
				break;
			case 5:
				return $this->getIsSystemDefault();
				break;
			case 6:
				return $this->getUpdateResume();
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
		$keys = TaxPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getVat(),
			$keys[2] => $this->getIsDefault(),
			$keys[3] => $this->getIsActive(),
			$keys[4] => $this->getVatName(),
			$keys[5] => $this->getIsSystemDefault(),
			$keys[6] => $this->getUpdateResume(),
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
		$pos = TaxPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setVat($value);
				break;
			case 2:
				$this->setIsDefault($value);
				break;
			case 3:
				$this->setIsActive($value);
				break;
			case 4:
				$this->setVatName($value);
				break;
			case 5:
				$this->setIsSystemDefault($value);
				break;
			case 6:
				$this->setUpdateResume($value);
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
		$keys = TaxPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setVat($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIsDefault($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setIsActive($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setVatName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setIsSystemDefault($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setUpdateResume($arr[$keys[6]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(TaxPeer::DATABASE_NAME);

		if ($this->isColumnModified(TaxPeer::ID)) $criteria->add(TaxPeer::ID, $this->id);
		if ($this->isColumnModified(TaxPeer::VAT)) $criteria->add(TaxPeer::VAT, $this->vat);
		if ($this->isColumnModified(TaxPeer::IS_DEFAULT)) $criteria->add(TaxPeer::IS_DEFAULT, $this->is_default);
		if ($this->isColumnModified(TaxPeer::IS_ACTIVE)) $criteria->add(TaxPeer::IS_ACTIVE, $this->is_active);
		if ($this->isColumnModified(TaxPeer::VAT_NAME)) $criteria->add(TaxPeer::VAT_NAME, $this->vat_name);
		if ($this->isColumnModified(TaxPeer::IS_SYSTEM_DEFAULT)) $criteria->add(TaxPeer::IS_SYSTEM_DEFAULT, $this->is_system_default);
		if ($this->isColumnModified(TaxPeer::UPDATE_RESUME)) $criteria->add(TaxPeer::UPDATE_RESUME, $this->update_resume);

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
		$criteria = new Criteria(TaxPeer::DATABASE_NAME);

		$criteria->add(TaxPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Tax (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setVat($this->vat);

		$copyObj->setIsDefault($this->is_default);

		$copyObj->setIsActive($this->is_active);

		$copyObj->setVatName($this->vat_name);

		$copyObj->setIsSystemDefault($this->is_system_default);

		$copyObj->setUpdateResume($this->update_resume);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getProducts() as $relObj) {
				$copyObj->addProduct($relObj->copy($deepCopy));
			}

			foreach($this->getAddPrices() as $relObj) {
				$copyObj->addAddPrice($relObj->copy($deepCopy));
			}

			foreach($this->getAddGroupPrices() as $relObj) {
				$copyObj->addAddGroupPrice($relObj->copy($deepCopy));
			}

			foreach($this->getOrderProducts() as $relObj) {
				$copyObj->addOrderProduct($relObj->copy($deepCopy));
			}

			foreach($this->getOrderDeliverys() as $relObj) {
				$copyObj->addOrderDelivery($relObj->copy($deepCopy));
			}

			foreach($this->getGroupPrices() as $relObj) {
				$copyObj->addGroupPrice($relObj->copy($deepCopy));
			}

			foreach($this->getDeliverys() as $relObj) {
				$copyObj->addDelivery($relObj->copy($deepCopy));
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
	 * @return     Tax Clone of current object.
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
	 * @return     TaxPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new TaxPeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProducts()
	{
		if ($this->collProducts === null) {
			$this->collProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax has previously
	 * been saved, it will retrieve related Products from storage.
	 * If this Tax is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
			   $this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::TAX_ID, $this->getId());

				ProductPeer::addSelectColumns($criteria);
				$this->collProducts = ProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductPeer::TAX_ID, $this->getId());

				ProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
					$this->collProducts = ProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductCriteria = $criteria;
		return $this->collProducts;
	}

	/**
	 * Returns the number of related Products.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductPeer::TAX_ID, $this->getId());

		return ProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Product object to this object
	 * through the Product foreign key attribute
	 *
	 * @param      Product $l Product
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProduct(Product $l)
	{
		$this->collProducts[] = $l;
		$l->setTax($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getProductsJoinProductRelatedByParentId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::TAX_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinProductRelatedByParentId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::TAX_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinProductRelatedByParentId($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getProductsJoinCurrency($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::TAX_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::TAX_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinCurrency($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getProductsJoinProducer($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::TAX_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinProducer($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::TAX_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinProducer($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getProductsJoinBasicPriceUnitMeasureRelatedByBpumDefaultId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::TAX_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumDefaultId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::TAX_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumDefaultId($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getProductsJoinBasicPriceUnitMeasureRelatedByBpumId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::TAX_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::TAX_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumId($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getProductsJoinProductDimension($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::TAX_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinProductDimension($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::TAX_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinProductDimension($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getProductsJoinAvailability($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::TAX_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinAvailability($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::TAX_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinAvailability($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related Products from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getProductsJoinGroupPrice($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProducts === null) {
			if ($this->isNew()) {
				$this->collProducts = array();
			} else {

				$criteria->add(ProductPeer::TAX_ID, $this->getId());

				$this->collProducts = ProductPeer::doSelectJoinGroupPrice($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::TAX_ID, $this->getId());

			if (!isset($this->lastProductCriteria) || !$this->lastProductCriteria->equals($criteria)) {
				$this->collProducts = ProductPeer::doSelectJoinGroupPrice($criteria, $con);
			}
		}
		$this->lastProductCriteria = $criteria;

		return $this->collProducts;
	}

	/**
	 * Temporary storage of collAddPrices to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initAddPrices()
	{
		if ($this->collAddPrices === null) {
			$this->collAddPrices = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax has previously
	 * been saved, it will retrieve related AddPrices from storage.
	 * If this Tax is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getAddPrices($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAddPrices === null) {
			if ($this->isNew()) {
			   $this->collAddPrices = array();
			} else {

				$criteria->add(AddPricePeer::TAX_ID, $this->getId());

				AddPricePeer::addSelectColumns($criteria);
				$this->collAddPrices = AddPricePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AddPricePeer::TAX_ID, $this->getId());

				AddPricePeer::addSelectColumns($criteria);
				if (!isset($this->lastAddPriceCriteria) || !$this->lastAddPriceCriteria->equals($criteria)) {
					$this->collAddPrices = AddPricePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAddPriceCriteria = $criteria;
		return $this->collAddPrices;
	}

	/**
	 * Returns the number of related AddPrices.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countAddPrices($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AddPricePeer::TAX_ID, $this->getId());

		return AddPricePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a AddPrice object to this object
	 * through the AddPrice foreign key attribute
	 *
	 * @param      AddPrice $l AddPrice
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAddPrice(AddPrice $l)
	{
		$this->collAddPrices[] = $l;
		$l->setTax($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related AddPrices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getAddPricesJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAddPrices === null) {
			if ($this->isNew()) {
				$this->collAddPrices = array();
			} else {

				$criteria->add(AddPricePeer::TAX_ID, $this->getId());

				$this->collAddPrices = AddPricePeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AddPricePeer::TAX_ID, $this->getId());

			if (!isset($this->lastAddPriceCriteria) || !$this->lastAddPriceCriteria->equals($criteria)) {
				$this->collAddPrices = AddPricePeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastAddPriceCriteria = $criteria;

		return $this->collAddPrices;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related AddPrices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getAddPricesJoinCurrency($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAddPrices === null) {
			if ($this->isNew()) {
				$this->collAddPrices = array();
			} else {

				$criteria->add(AddPricePeer::TAX_ID, $this->getId());

				$this->collAddPrices = AddPricePeer::doSelectJoinCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AddPricePeer::TAX_ID, $this->getId());

			if (!isset($this->lastAddPriceCriteria) || !$this->lastAddPriceCriteria->equals($criteria)) {
				$this->collAddPrices = AddPricePeer::doSelectJoinCurrency($criteria, $con);
			}
		}
		$this->lastAddPriceCriteria = $criteria;

		return $this->collAddPrices;
	}

	/**
	 * Temporary storage of collAddGroupPrices to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initAddGroupPrices()
	{
		if ($this->collAddGroupPrices === null) {
			$this->collAddGroupPrices = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax has previously
	 * been saved, it will retrieve related AddGroupPrices from storage.
	 * If this Tax is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getAddGroupPrices($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAddGroupPrices === null) {
			if ($this->isNew()) {
			   $this->collAddGroupPrices = array();
			} else {

				$criteria->add(AddGroupPricePeer::TAX_ID, $this->getId());

				AddGroupPricePeer::addSelectColumns($criteria);
				$this->collAddGroupPrices = AddGroupPricePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AddGroupPricePeer::TAX_ID, $this->getId());

				AddGroupPricePeer::addSelectColumns($criteria);
				if (!isset($this->lastAddGroupPriceCriteria) || !$this->lastAddGroupPriceCriteria->equals($criteria)) {
					$this->collAddGroupPrices = AddGroupPricePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAddGroupPriceCriteria = $criteria;
		return $this->collAddGroupPrices;
	}

	/**
	 * Returns the number of related AddGroupPrices.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countAddGroupPrices($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AddGroupPricePeer::TAX_ID, $this->getId());

		return AddGroupPricePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a AddGroupPrice object to this object
	 * through the AddGroupPrice foreign key attribute
	 *
	 * @param      AddGroupPrice $l AddGroupPrice
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAddGroupPrice(AddGroupPrice $l)
	{
		$this->collAddGroupPrices[] = $l;
		$l->setTax($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related AddGroupPrices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getAddGroupPricesJoinGroupPrice($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAddGroupPrices === null) {
			if ($this->isNew()) {
				$this->collAddGroupPrices = array();
			} else {

				$criteria->add(AddGroupPricePeer::TAX_ID, $this->getId());

				$this->collAddGroupPrices = AddGroupPricePeer::doSelectJoinGroupPrice($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AddGroupPricePeer::TAX_ID, $this->getId());

			if (!isset($this->lastAddGroupPriceCriteria) || !$this->lastAddGroupPriceCriteria->equals($criteria)) {
				$this->collAddGroupPrices = AddGroupPricePeer::doSelectJoinGroupPrice($criteria, $con);
			}
		}
		$this->lastAddGroupPriceCriteria = $criteria;

		return $this->collAddGroupPrices;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related AddGroupPrices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getAddGroupPricesJoinCurrency($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAddGroupPrices === null) {
			if ($this->isNew()) {
				$this->collAddGroupPrices = array();
			} else {

				$criteria->add(AddGroupPricePeer::TAX_ID, $this->getId());

				$this->collAddGroupPrices = AddGroupPricePeer::doSelectJoinCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AddGroupPricePeer::TAX_ID, $this->getId());

			if (!isset($this->lastAddGroupPriceCriteria) || !$this->lastAddGroupPriceCriteria->equals($criteria)) {
				$this->collAddGroupPrices = AddGroupPricePeer::doSelectJoinCurrency($criteria, $con);
			}
		}
		$this->lastAddGroupPriceCriteria = $criteria;

		return $this->collAddGroupPrices;
	}

	/**
	 * Temporary storage of collOrderProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOrderProducts()
	{
		if ($this->collOrderProducts === null) {
			$this->collOrderProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax has previously
	 * been saved, it will retrieve related OrderProducts from storage.
	 * If this Tax is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOrderProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderProducts === null) {
			if ($this->isNew()) {
			   $this->collOrderProducts = array();
			} else {

				$criteria->add(OrderProductPeer::TAX_ID, $this->getId());

				OrderProductPeer::addSelectColumns($criteria);
				$this->collOrderProducts = OrderProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderProductPeer::TAX_ID, $this->getId());

				OrderProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastOrderProductCriteria) || !$this->lastOrderProductCriteria->equals($criteria)) {
					$this->collOrderProducts = OrderProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOrderProductCriteria = $criteria;
		return $this->collOrderProducts;
	}

	/**
	 * Returns the number of related OrderProducts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOrderProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OrderProductPeer::TAX_ID, $this->getId());

		return OrderProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a OrderProduct object to this object
	 * through the OrderProduct foreign key attribute
	 *
	 * @param      OrderProduct $l OrderProduct
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOrderProduct(OrderProduct $l)
	{
		$this->collOrderProducts[] = $l;
		$l->setTax($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related OrderProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getOrderProductsJoinOrder($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderProducts === null) {
			if ($this->isNew()) {
				$this->collOrderProducts = array();
			} else {

				$criteria->add(OrderProductPeer::TAX_ID, $this->getId());

				$this->collOrderProducts = OrderProductPeer::doSelectJoinOrder($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderProductPeer::TAX_ID, $this->getId());

			if (!isset($this->lastOrderProductCriteria) || !$this->lastOrderProductCriteria->equals($criteria)) {
				$this->collOrderProducts = OrderProductPeer::doSelectJoinOrder($criteria, $con);
			}
		}
		$this->lastOrderProductCriteria = $criteria;

		return $this->collOrderProducts;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related OrderProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getOrderProductsJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderProducts === null) {
			if ($this->isNew()) {
				$this->collOrderProducts = array();
			} else {

				$criteria->add(OrderProductPeer::TAX_ID, $this->getId());

				$this->collOrderProducts = OrderProductPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderProductPeer::TAX_ID, $this->getId());

			if (!isset($this->lastOrderProductCriteria) || !$this->lastOrderProductCriteria->equals($criteria)) {
				$this->collOrderProducts = OrderProductPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastOrderProductCriteria = $criteria;

		return $this->collOrderProducts;
	}

	/**
	 * Temporary storage of collOrderDeliverys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOrderDeliverys()
	{
		if ($this->collOrderDeliverys === null) {
			$this->collOrderDeliverys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax has previously
	 * been saved, it will retrieve related OrderDeliverys from storage.
	 * If this Tax is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOrderDeliverys($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderDeliverys === null) {
			if ($this->isNew()) {
			   $this->collOrderDeliverys = array();
			} else {

				$criteria->add(OrderDeliveryPeer::TAX_ID, $this->getId());

				OrderDeliveryPeer::addSelectColumns($criteria);
				$this->collOrderDeliverys = OrderDeliveryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderDeliveryPeer::TAX_ID, $this->getId());

				OrderDeliveryPeer::addSelectColumns($criteria);
				if (!isset($this->lastOrderDeliveryCriteria) || !$this->lastOrderDeliveryCriteria->equals($criteria)) {
					$this->collOrderDeliverys = OrderDeliveryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOrderDeliveryCriteria = $criteria;
		return $this->collOrderDeliverys;
	}

	/**
	 * Returns the number of related OrderDeliverys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOrderDeliverys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OrderDeliveryPeer::TAX_ID, $this->getId());

		return OrderDeliveryPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a OrderDelivery object to this object
	 * through the OrderDelivery foreign key attribute
	 *
	 * @param      OrderDelivery $l OrderDelivery
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOrderDelivery(OrderDelivery $l)
	{
		$this->collOrderDeliverys[] = $l;
		$l->setTax($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related OrderDeliverys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getOrderDeliverysJoinDelivery($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderDeliverys === null) {
			if ($this->isNew()) {
				$this->collOrderDeliverys = array();
			} else {

				$criteria->add(OrderDeliveryPeer::TAX_ID, $this->getId());

				$this->collOrderDeliverys = OrderDeliveryPeer::doSelectJoinDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderDeliveryPeer::TAX_ID, $this->getId());

			if (!isset($this->lastOrderDeliveryCriteria) || !$this->lastOrderDeliveryCriteria->equals($criteria)) {
				$this->collOrderDeliverys = OrderDeliveryPeer::doSelectJoinDelivery($criteria, $con);
			}
		}
		$this->lastOrderDeliveryCriteria = $criteria;

		return $this->collOrderDeliverys;
	}

	/**
	 * Temporary storage of collGroupPrices to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initGroupPrices()
	{
		if ($this->collGroupPrices === null) {
			$this->collGroupPrices = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax has previously
	 * been saved, it will retrieve related GroupPrices from storage.
	 * If this Tax is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getGroupPrices($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGroupPrices === null) {
			if ($this->isNew()) {
			   $this->collGroupPrices = array();
			} else {

				$criteria->add(GroupPricePeer::TAX_ID, $this->getId());

				GroupPricePeer::addSelectColumns($criteria);
				$this->collGroupPrices = GroupPricePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GroupPricePeer::TAX_ID, $this->getId());

				GroupPricePeer::addSelectColumns($criteria);
				if (!isset($this->lastGroupPriceCriteria) || !$this->lastGroupPriceCriteria->equals($criteria)) {
					$this->collGroupPrices = GroupPricePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGroupPriceCriteria = $criteria;
		return $this->collGroupPrices;
	}

	/**
	 * Returns the number of related GroupPrices.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countGroupPrices($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(GroupPricePeer::TAX_ID, $this->getId());

		return GroupPricePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a GroupPrice object to this object
	 * through the GroupPrice foreign key attribute
	 *
	 * @param      GroupPrice $l GroupPrice
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGroupPrice(GroupPrice $l)
	{
		$this->collGroupPrices[] = $l;
		$l->setTax($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related GroupPrices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getGroupPricesJoinCurrency($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGroupPrices === null) {
			if ($this->isNew()) {
				$this->collGroupPrices = array();
			} else {

				$criteria->add(GroupPricePeer::TAX_ID, $this->getId());

				$this->collGroupPrices = GroupPricePeer::doSelectJoinCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(GroupPricePeer::TAX_ID, $this->getId());

			if (!isset($this->lastGroupPriceCriteria) || !$this->lastGroupPriceCriteria->equals($criteria)) {
				$this->collGroupPrices = GroupPricePeer::doSelectJoinCurrency($criteria, $con);
			}
		}
		$this->lastGroupPriceCriteria = $criteria;

		return $this->collGroupPrices;
	}

	/**
	 * Temporary storage of collDeliverys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDeliverys()
	{
		if ($this->collDeliverys === null) {
			$this->collDeliverys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax has previously
	 * been saved, it will retrieve related Deliverys from storage.
	 * If this Tax is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDeliverys($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDeliverys === null) {
			if ($this->isNew()) {
			   $this->collDeliverys = array();
			} else {

				$criteria->add(DeliveryPeer::TAX_ID, $this->getId());

				DeliveryPeer::addSelectColumns($criteria);
				$this->collDeliverys = DeliveryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DeliveryPeer::TAX_ID, $this->getId());

				DeliveryPeer::addSelectColumns($criteria);
				if (!isset($this->lastDeliveryCriteria) || !$this->lastDeliveryCriteria->equals($criteria)) {
					$this->collDeliverys = DeliveryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDeliveryCriteria = $criteria;
		return $this->collDeliverys;
	}

	/**
	 * Returns the number of related Deliverys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDeliverys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DeliveryPeer::TAX_ID, $this->getId());

		return DeliveryPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Delivery object to this object
	 * through the Delivery foreign key attribute
	 *
	 * @param      Delivery $l Delivery
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDelivery(Delivery $l)
	{
		$this->collDeliverys[] = $l;
		$l->setTax($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related Deliverys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getDeliverysJoinCountriesArea($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDeliverys === null) {
			if ($this->isNew()) {
				$this->collDeliverys = array();
			} else {

				$criteria->add(DeliveryPeer::TAX_ID, $this->getId());

				$this->collDeliverys = DeliveryPeer::doSelectJoinCountriesArea($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DeliveryPeer::TAX_ID, $this->getId());

			if (!isset($this->lastDeliveryCriteria) || !$this->lastDeliveryCriteria->equals($criteria)) {
				$this->collDeliverys = DeliveryPeer::doSelectJoinCountriesArea($criteria, $con);
			}
		}
		$this->lastDeliveryCriteria = $criteria;

		return $this->collDeliverys;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Tax is new, it will return
	 * an empty collection; or if this Tax has previously
	 * been saved, it will retrieve related Deliverys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Tax.
	 */
	public function getDeliverysJoinDeliveryType($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDeliverys === null) {
			if ($this->isNew()) {
				$this->collDeliverys = array();
			} else {

				$criteria->add(DeliveryPeer::TAX_ID, $this->getId());

				$this->collDeliverys = DeliveryPeer::doSelectJoinDeliveryType($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DeliveryPeer::TAX_ID, $this->getId());

			if (!isset($this->lastDeliveryCriteria) || !$this->lastDeliveryCriteria->equals($criteria)) {
				$this->collDeliverys = DeliveryPeer::doSelectJoinDeliveryType($criteria, $con);
			}
		}
		$this->lastDeliveryCriteria = $criteria;

		return $this->collDeliverys;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Tax.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseTax:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseTax::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseTax
