<?php

/**
 * Base class that represents a row from the 'st_discount_coupon_code' table.
 *
 * 
 *
 * @package    plugins.stDiscountPlugin.lib.model.om
 */
abstract class BaseDiscountCouponCode extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        DiscountCouponCodePeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the sf_guard_user_id field.
	 * @var        int
	 */
	protected $sf_guard_user_id;


	/**
	 * The value for the order_id field.
	 * @var        int
	 */
	protected $order_id;


	/**
	 * The value for the code field.
	 * @var        string
	 */
	protected $code;


	/**
	 * The value for the used field.
	 * @var        int
	 */
	protected $used = 0;


	/**
	 * The value for the valid_usage field.
	 * @var        int
	 */
	protected $valid_usage = 0;


	/**
	 * The value for the allow_all_products field.
	 * @var        boolean
	 */
	protected $allow_all_products;


	/**
	 * The value for the valid_from field.
	 * @var        int
	 */
	protected $valid_from;


	/**
	 * The value for the valid_to field.
	 * @var        int
	 */
	protected $valid_to;


	/**
	 * The value for the discount field.
	 * @var        double
	 */
	protected $discount = 0;

	/**
	 * @var        sfGuardUser
	 */
	protected $asfGuardUser;

	/**
	 * @var        Order
	 */
	protected $aOrder;

	/**
	 * Collection to store aggregation of collDiscountCouponCodeHasProducers.
	 * @var        array
	 */
	protected $collDiscountCouponCodeHasProducers;

	/**
	 * The criteria used to select the current contents of collDiscountCouponCodeHasProducers.
	 * @var        Criteria
	 */
	protected $lastDiscountCouponCodeHasProducerCriteria = null;

	/**
	 * Collection to store aggregation of collDiscountCouponCodeHasCategorys.
	 * @var        array
	 */
	protected $collDiscountCouponCodeHasCategorys;

	/**
	 * The criteria used to select the current contents of collDiscountCouponCodeHasCategorys.
	 * @var        Criteria
	 */
	protected $lastDiscountCouponCodeHasCategoryCriteria = null;

	/**
	 * Collection to store aggregation of collDiscountCouponCodeHasProducts.
	 * @var        array
	 */
	protected $collDiscountCouponCodeHasProducts;

	/**
	 * The criteria used to select the current contents of collDiscountCouponCodeHasProducts.
	 * @var        Criteria
	 */
	protected $lastDiscountCouponCodeHasProductCriteria = null;

	/**
	 * Collection to store aggregation of collOrders.
	 * @var        array
	 */
	protected $collOrders;

	/**
	 * The criteria used to select the current contents of collOrders.
	 * @var        Criteria
	 */
	protected $lastOrderCriteria = null;

	/**
	 * Collection to store aggregation of collBaskets.
	 * @var        array
	 */
	protected $collBaskets;

	/**
	 * The criteria used to select the current contents of collBaskets.
	 * @var        Criteria
	 */
	protected $lastBasketCriteria = null;

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
     * Get the [sf_guard_user_id] column value.
     * 
     * @return     int
     */
    public function getSfGuardUserId()
    {

            return $this->sf_guard_user_id;
    }

    /**
     * Get the [order_id] column value.
     * 
     * @return     int
     */
    public function getOrderId()
    {

            return $this->order_id;
    }

    /**
     * Get the [code] column value.
     * 
     * @return     string
     */
    public function getCode()
    {

            return $this->code;
    }

    /**
     * Get the [used] column value.
     * 
     * @return     int
     */
    public function getUsed()
    {

            return $this->used;
    }

    /**
     * Get the [valid_usage] column value.
     * 
     * @return     int
     */
    public function getValidUsage()
    {

            return $this->valid_usage;
    }

    /**
     * Get the [allow_all_products] column value.
     * 
     * @return     boolean
     */
    public function getAllowAllProducts()
    {

            return $this->allow_all_products;
    }

	/**
	 * Get the [optionally formatted] [valid_from] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getValidFrom($format = 'Y-m-d H:i:s')
	{

		if ($this->valid_from === null || $this->valid_from === '') {
			return null;
		} elseif (!is_int($this->valid_from)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->valid_from);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [valid_from] as date/time value: " . var_export($this->valid_from, true));
			}
		} else {
			$ts = $this->valid_from;
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
	 * Get the [optionally formatted] [valid_to] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getValidTo($format = 'Y-m-d H:i:s')
	{

		if ($this->valid_to === null || $this->valid_to === '') {
			return null;
		} elseif (!is_int($this->valid_to)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->valid_to);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [valid_to] as date/time value: " . var_export($this->valid_to, true));
			}
		} else {
			$ts = $this->valid_to;
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
     * Get the [discount] column value.
     * 
     * @return     double
     */
    public function getDiscount()
    {

            return null !== $this->discount ? (string)$this->discount : null;
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
          $this->modifiedColumns[] = DiscountCouponCodePeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [sf_guard_user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setSfGuardUserId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->sf_guard_user_id !== $v) {
          $this->sf_guard_user_id = $v;
          $this->modifiedColumns[] = DiscountCouponCodePeer::SF_GUARD_USER_ID;
        }

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

	} // setSfGuardUserId()

	/**
	 * Set the value of [order_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOrderId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->order_id !== $v) {
          $this->order_id = $v;
          $this->modifiedColumns[] = DiscountCouponCodePeer::ORDER_ID;
        }

		if ($this->aOrder !== null && $this->aOrder->getId() !== $v) {
			$this->aOrder = null;
		}

	} // setOrderId()

	/**
	 * Set the value of [code] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setCode($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->code !== $v) {
          $this->code = $v;
          $this->modifiedColumns[] = DiscountCouponCodePeer::CODE;
        }

	} // setCode()

	/**
	 * Set the value of [used] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setUsed($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->used !== $v || $v === 0) {
          $this->used = $v;
          $this->modifiedColumns[] = DiscountCouponCodePeer::USED;
        }

	} // setUsed()

	/**
	 * Set the value of [valid_usage] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setValidUsage($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->valid_usage !== $v || $v === 0) {
          $this->valid_usage = $v;
          $this->modifiedColumns[] = DiscountCouponCodePeer::VALID_USAGE;
        }

	} // setValidUsage()

	/**
	 * Set the value of [allow_all_products] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setAllowAllProducts($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->allow_all_products !== $v) {
          $this->allow_all_products = $v;
          $this->modifiedColumns[] = DiscountCouponCodePeer::ALLOW_ALL_PRODUCTS;
        }

	} // setAllowAllProducts()

	/**
	 * Set the value of [valid_from] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setValidFrom($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [valid_from] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->valid_from !== $ts) {
			$this->valid_from = $ts;
			$this->modifiedColumns[] = DiscountCouponCodePeer::VALID_FROM;
		}

	} // setValidFrom()

	/**
	 * Set the value of [valid_to] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setValidTo($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [valid_to] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->valid_to !== $ts) {
			$this->valid_to = $ts;
			$this->modifiedColumns[] = DiscountCouponCodePeer::VALID_TO;
		}

	} // setValidTo()

	/**
	 * Set the value of [discount] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setDiscount($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->discount !== $v || $v === 0) {
          $this->discount = $v;
          $this->modifiedColumns[] = DiscountCouponCodePeer::DISCOUNT;
        }

	} // setDiscount()

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
      if ($this->getDispatcher()->getListeners('DiscountCouponCode.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'DiscountCouponCode.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->sf_guard_user_id = $rs->getInt($startcol + 1);

      $this->order_id = $rs->getInt($startcol + 2);

      $this->code = $rs->getString($startcol + 3);

      $this->used = $rs->getInt($startcol + 4);

      $this->valid_usage = $rs->getInt($startcol + 5);

      $this->allow_all_products = $rs->getBoolean($startcol + 6);

      $this->valid_from = $rs->getTimestamp($startcol + 7, null);

      $this->valid_to = $rs->getTimestamp($startcol + 8, null);

      $this->discount = $rs->getString($startcol + 9);
      if (null !== $this->discount && $this->discount == intval($this->discount))
      {
        $this->discount = (string)intval($this->discount);
      }

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('DiscountCouponCode.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'DiscountCouponCode.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 10)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 10; // 10 = DiscountCouponCodePeer::NUM_COLUMNS - DiscountCouponCodePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating DiscountCouponCode object", $e);
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

    if ($this->getDispatcher()->getListeners('DiscountCouponCode.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'DiscountCouponCode.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseDiscountCouponCode:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseDiscountCouponCode:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(DiscountCouponCodePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      DiscountCouponCodePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('DiscountCouponCode.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'DiscountCouponCode.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseDiscountCouponCode:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseDiscountCouponCode:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('DiscountCouponCode.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'DiscountCouponCode.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseDiscountCouponCode:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(DiscountCouponCodePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('DiscountCouponCode.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'DiscountCouponCode.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseDiscountCouponCode:save:post') as $callable)
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

			if ($this->asfGuardUser !== null) {
				if ($this->asfGuardUser->isModified()) {
					$affectedRows += $this->asfGuardUser->save($con);
				}
				$this->setsfGuardUser($this->asfGuardUser);
			}

			if ($this->aOrder !== null) {
				if ($this->aOrder->isModified()) {
					$affectedRows += $this->aOrder->save($con);
				}
				$this->setOrder($this->aOrder);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = DiscountCouponCodePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += DiscountCouponCodePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collDiscountCouponCodeHasProducers !== null) {
				foreach($this->collDiscountCouponCodeHasProducers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDiscountCouponCodeHasCategorys !== null) {
				foreach($this->collDiscountCouponCodeHasCategorys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDiscountCouponCodeHasProducts !== null) {
				foreach($this->collDiscountCouponCodeHasProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOrders !== null) {
				foreach($this->collOrders as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collBaskets !== null) {
				foreach($this->collBaskets as $referrerFK) {
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

			if ($this->asfGuardUser !== null) {
				if (!$this->asfGuardUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUser->getValidationFailures());
				}
			}

			if ($this->aOrder !== null) {
				if (!$this->aOrder->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOrder->getValidationFailures());
				}
			}


			if (($retval = DiscountCouponCodePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collDiscountCouponCodeHasProducers !== null) {
					foreach($this->collDiscountCouponCodeHasProducers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDiscountCouponCodeHasCategorys !== null) {
					foreach($this->collDiscountCouponCodeHasCategorys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDiscountCouponCodeHasProducts !== null) {
					foreach($this->collDiscountCouponCodeHasProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOrders !== null) {
					foreach($this->collOrders as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collBaskets !== null) {
					foreach($this->collBaskets as $referrerFK) {
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
		$pos = DiscountCouponCodePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getSfGuardUserId();
				break;
			case 2:
				return $this->getOrderId();
				break;
			case 3:
				return $this->getCode();
				break;
			case 4:
				return $this->getUsed();
				break;
			case 5:
				return $this->getValidUsage();
				break;
			case 6:
				return $this->getAllowAllProducts();
				break;
			case 7:
				return $this->getValidFrom();
				break;
			case 8:
				return $this->getValidTo();
				break;
			case 9:
				return $this->getDiscount();
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
		$keys = DiscountCouponCodePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getSfGuardUserId(),
			$keys[2] => $this->getOrderId(),
			$keys[3] => $this->getCode(),
			$keys[4] => $this->getUsed(),
			$keys[5] => $this->getValidUsage(),
			$keys[6] => $this->getAllowAllProducts(),
			$keys[7] => $this->getValidFrom(),
			$keys[8] => $this->getValidTo(),
			$keys[9] => $this->getDiscount(),
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
		$pos = DiscountCouponCodePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setSfGuardUserId($value);
				break;
			case 2:
				$this->setOrderId($value);
				break;
			case 3:
				$this->setCode($value);
				break;
			case 4:
				$this->setUsed($value);
				break;
			case 5:
				$this->setValidUsage($value);
				break;
			case 6:
				$this->setAllowAllProducts($value);
				break;
			case 7:
				$this->setValidFrom($value);
				break;
			case 8:
				$this->setValidTo($value);
				break;
			case 9:
				$this->setDiscount($value);
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
		$keys = DiscountCouponCodePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setSfGuardUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setOrderId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCode($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setUsed($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setValidUsage($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setAllowAllProducts($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setValidFrom($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setValidTo($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setDiscount($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(DiscountCouponCodePeer::DATABASE_NAME);

		if ($this->isColumnModified(DiscountCouponCodePeer::ID)) $criteria->add(DiscountCouponCodePeer::ID, $this->id);
		if ($this->isColumnModified(DiscountCouponCodePeer::SF_GUARD_USER_ID)) $criteria->add(DiscountCouponCodePeer::SF_GUARD_USER_ID, $this->sf_guard_user_id);
		if ($this->isColumnModified(DiscountCouponCodePeer::ORDER_ID)) $criteria->add(DiscountCouponCodePeer::ORDER_ID, $this->order_id);
		if ($this->isColumnModified(DiscountCouponCodePeer::CODE)) $criteria->add(DiscountCouponCodePeer::CODE, $this->code);
		if ($this->isColumnModified(DiscountCouponCodePeer::USED)) $criteria->add(DiscountCouponCodePeer::USED, $this->used);
		if ($this->isColumnModified(DiscountCouponCodePeer::VALID_USAGE)) $criteria->add(DiscountCouponCodePeer::VALID_USAGE, $this->valid_usage);
		if ($this->isColumnModified(DiscountCouponCodePeer::ALLOW_ALL_PRODUCTS)) $criteria->add(DiscountCouponCodePeer::ALLOW_ALL_PRODUCTS, $this->allow_all_products);
		if ($this->isColumnModified(DiscountCouponCodePeer::VALID_FROM)) $criteria->add(DiscountCouponCodePeer::VALID_FROM, $this->valid_from);
		if ($this->isColumnModified(DiscountCouponCodePeer::VALID_TO)) $criteria->add(DiscountCouponCodePeer::VALID_TO, $this->valid_to);
		if ($this->isColumnModified(DiscountCouponCodePeer::DISCOUNT)) $criteria->add(DiscountCouponCodePeer::DISCOUNT, $this->discount);

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
		$criteria = new Criteria(DiscountCouponCodePeer::DATABASE_NAME);

		$criteria->add(DiscountCouponCodePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of DiscountCouponCode (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setSfGuardUserId($this->sf_guard_user_id);

		$copyObj->setOrderId($this->order_id);

		$copyObj->setCode($this->code);

		$copyObj->setUsed($this->used);

		$copyObj->setValidUsage($this->valid_usage);

		$copyObj->setAllowAllProducts($this->allow_all_products);

		$copyObj->setValidFrom($this->valid_from);

		$copyObj->setValidTo($this->valid_to);

		$copyObj->setDiscount($this->discount);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getDiscountCouponCodeHasProducers() as $relObj) {
				$copyObj->addDiscountCouponCodeHasProducer($relObj->copy($deepCopy));
			}

			foreach($this->getDiscountCouponCodeHasCategorys() as $relObj) {
				$copyObj->addDiscountCouponCodeHasCategory($relObj->copy($deepCopy));
			}

			foreach($this->getDiscountCouponCodeHasProducts() as $relObj) {
				$copyObj->addDiscountCouponCodeHasProduct($relObj->copy($deepCopy));
			}

			foreach($this->getOrders() as $relObj) {
				$copyObj->addOrder($relObj->copy($deepCopy));
			}

			foreach($this->getBaskets() as $relObj) {
				$copyObj->addBasket($relObj->copy($deepCopy));
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
	 * @return     DiscountCouponCode Clone of current object.
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
	 * @return     DiscountCouponCodePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new DiscountCouponCodePeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a sfGuardUser object.
	 *
	 * @param      sfGuardUser $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setsfGuardUser($v)
	{


		if ($v === null) {
			$this->setSfGuardUserId(NULL);
		} else {
			$this->setSfGuardUserId($v->getId());
		}


		$this->asfGuardUser = $v;
	}


	/**
	 * Get the associated sfGuardUser object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     sfGuardUser The associated sfGuardUser object.
	 * @throws     PropelException
	 */
	public function getsfGuardUser($con = null)
	{
		if ($this->asfGuardUser === null && ($this->sf_guard_user_id !== null)) {
			// include the related Peer class
			$this->asfGuardUser = sfGuardUserPeer::retrieveByPK($this->sf_guard_user_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = sfGuardUserPeer::retrieveByPK($this->sf_guard_user_id, $con);
			   $obj->addsfGuardUsers($this);
			 */
		}
		return $this->asfGuardUser;
	}

	/**
	 * Declares an association between this object and a Order object.
	 *
	 * @param      Order $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setOrder($v)
	{


		if ($v === null) {
			$this->setOrderId(NULL);
		} else {
			$this->setOrderId($v->getId());
		}


		$this->aOrder = $v;
	}


	/**
	 * Get the associated Order object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Order The associated Order object.
	 * @throws     PropelException
	 */
	public function getOrder($con = null)
	{
		if ($this->aOrder === null && ($this->order_id !== null)) {
			// include the related Peer class
			$this->aOrder = OrderPeer::retrieveByPK($this->order_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = OrderPeer::retrieveByPK($this->order_id, $con);
			   $obj->addOrders($this);
			 */
		}
		return $this->aOrder;
	}

	/**
	 * Temporary storage of collDiscountCouponCodeHasProducers to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDiscountCouponCodeHasProducers()
	{
		if ($this->collDiscountCouponCodeHasProducers === null) {
			$this->collDiscountCouponCodeHasProducers = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode has previously
	 * been saved, it will retrieve related DiscountCouponCodeHasProducers from storage.
	 * If this DiscountCouponCode is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDiscountCouponCodeHasProducers($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountCouponCodeHasProducers === null) {
			if ($this->isNew()) {
			   $this->collDiscountCouponCodeHasProducers = array();
			} else {

				$criteria->add(DiscountCouponCodeHasProducerPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				DiscountCouponCodeHasProducerPeer::addSelectColumns($criteria);
				$this->collDiscountCouponCodeHasProducers = DiscountCouponCodeHasProducerPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountCouponCodeHasProducerPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				DiscountCouponCodeHasProducerPeer::addSelectColumns($criteria);
				if (!isset($this->lastDiscountCouponCodeHasProducerCriteria) || !$this->lastDiscountCouponCodeHasProducerCriteria->equals($criteria)) {
					$this->collDiscountCouponCodeHasProducers = DiscountCouponCodeHasProducerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDiscountCouponCodeHasProducerCriteria = $criteria;
		return $this->collDiscountCouponCodeHasProducers;
	}

	/**
	 * Returns the number of related DiscountCouponCodeHasProducers.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDiscountCouponCodeHasProducers($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DiscountCouponCodeHasProducerPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

		return DiscountCouponCodeHasProducerPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DiscountCouponCodeHasProducer object to this object
	 * through the DiscountCouponCodeHasProducer foreign key attribute
	 *
	 * @param      DiscountCouponCodeHasProducer $l DiscountCouponCodeHasProducer
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDiscountCouponCodeHasProducer(DiscountCouponCodeHasProducer $l)
	{
		$this->collDiscountCouponCodeHasProducers[] = $l;
		$l->setDiscountCouponCode($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode is new, it will return
	 * an empty collection; or if this DiscountCouponCode has previously
	 * been saved, it will retrieve related DiscountCouponCodeHasProducers from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DiscountCouponCode.
	 */
	public function getDiscountCouponCodeHasProducersJoinProducer($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountCouponCodeHasProducers === null) {
			if ($this->isNew()) {
				$this->collDiscountCouponCodeHasProducers = array();
			} else {

				$criteria->add(DiscountCouponCodeHasProducerPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				$this->collDiscountCouponCodeHasProducers = DiscountCouponCodeHasProducerPeer::doSelectJoinProducer($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DiscountCouponCodeHasProducerPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

			if (!isset($this->lastDiscountCouponCodeHasProducerCriteria) || !$this->lastDiscountCouponCodeHasProducerCriteria->equals($criteria)) {
				$this->collDiscountCouponCodeHasProducers = DiscountCouponCodeHasProducerPeer::doSelectJoinProducer($criteria, $con);
			}
		}
		$this->lastDiscountCouponCodeHasProducerCriteria = $criteria;

		return $this->collDiscountCouponCodeHasProducers;
	}

	/**
	 * Temporary storage of collDiscountCouponCodeHasCategorys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDiscountCouponCodeHasCategorys()
	{
		if ($this->collDiscountCouponCodeHasCategorys === null) {
			$this->collDiscountCouponCodeHasCategorys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode has previously
	 * been saved, it will retrieve related DiscountCouponCodeHasCategorys from storage.
	 * If this DiscountCouponCode is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDiscountCouponCodeHasCategorys($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountCouponCodeHasCategorys === null) {
			if ($this->isNew()) {
			   $this->collDiscountCouponCodeHasCategorys = array();
			} else {

				$criteria->add(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				DiscountCouponCodeHasCategoryPeer::addSelectColumns($criteria);
				$this->collDiscountCouponCodeHasCategorys = DiscountCouponCodeHasCategoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				DiscountCouponCodeHasCategoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastDiscountCouponCodeHasCategoryCriteria) || !$this->lastDiscountCouponCodeHasCategoryCriteria->equals($criteria)) {
					$this->collDiscountCouponCodeHasCategorys = DiscountCouponCodeHasCategoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDiscountCouponCodeHasCategoryCriteria = $criteria;
		return $this->collDiscountCouponCodeHasCategorys;
	}

	/**
	 * Returns the number of related DiscountCouponCodeHasCategorys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDiscountCouponCodeHasCategorys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

		return DiscountCouponCodeHasCategoryPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DiscountCouponCodeHasCategory object to this object
	 * through the DiscountCouponCodeHasCategory foreign key attribute
	 *
	 * @param      DiscountCouponCodeHasCategory $l DiscountCouponCodeHasCategory
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDiscountCouponCodeHasCategory(DiscountCouponCodeHasCategory $l)
	{
		$this->collDiscountCouponCodeHasCategorys[] = $l;
		$l->setDiscountCouponCode($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode is new, it will return
	 * an empty collection; or if this DiscountCouponCode has previously
	 * been saved, it will retrieve related DiscountCouponCodeHasCategorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DiscountCouponCode.
	 */
	public function getDiscountCouponCodeHasCategorysJoinCategory($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountCouponCodeHasCategorys === null) {
			if ($this->isNew()) {
				$this->collDiscountCouponCodeHasCategorys = array();
			} else {

				$criteria->add(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				$this->collDiscountCouponCodeHasCategorys = DiscountCouponCodeHasCategoryPeer::doSelectJoinCategory($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

			if (!isset($this->lastDiscountCouponCodeHasCategoryCriteria) || !$this->lastDiscountCouponCodeHasCategoryCriteria->equals($criteria)) {
				$this->collDiscountCouponCodeHasCategorys = DiscountCouponCodeHasCategoryPeer::doSelectJoinCategory($criteria, $con);
			}
		}
		$this->lastDiscountCouponCodeHasCategoryCriteria = $criteria;

		return $this->collDiscountCouponCodeHasCategorys;
	}

	/**
	 * Temporary storage of collDiscountCouponCodeHasProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDiscountCouponCodeHasProducts()
	{
		if ($this->collDiscountCouponCodeHasProducts === null) {
			$this->collDiscountCouponCodeHasProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode has previously
	 * been saved, it will retrieve related DiscountCouponCodeHasProducts from storage.
	 * If this DiscountCouponCode is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDiscountCouponCodeHasProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountCouponCodeHasProducts === null) {
			if ($this->isNew()) {
			   $this->collDiscountCouponCodeHasProducts = array();
			} else {

				$criteria->add(DiscountCouponCodeHasProductPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				DiscountCouponCodeHasProductPeer::addSelectColumns($criteria);
				$this->collDiscountCouponCodeHasProducts = DiscountCouponCodeHasProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountCouponCodeHasProductPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				DiscountCouponCodeHasProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastDiscountCouponCodeHasProductCriteria) || !$this->lastDiscountCouponCodeHasProductCriteria->equals($criteria)) {
					$this->collDiscountCouponCodeHasProducts = DiscountCouponCodeHasProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDiscountCouponCodeHasProductCriteria = $criteria;
		return $this->collDiscountCouponCodeHasProducts;
	}

	/**
	 * Returns the number of related DiscountCouponCodeHasProducts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDiscountCouponCodeHasProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DiscountCouponCodeHasProductPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

		return DiscountCouponCodeHasProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DiscountCouponCodeHasProduct object to this object
	 * through the DiscountCouponCodeHasProduct foreign key attribute
	 *
	 * @param      DiscountCouponCodeHasProduct $l DiscountCouponCodeHasProduct
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDiscountCouponCodeHasProduct(DiscountCouponCodeHasProduct $l)
	{
		$this->collDiscountCouponCodeHasProducts[] = $l;
		$l->setDiscountCouponCode($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode is new, it will return
	 * an empty collection; or if this DiscountCouponCode has previously
	 * been saved, it will retrieve related DiscountCouponCodeHasProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DiscountCouponCode.
	 */
	public function getDiscountCouponCodeHasProductsJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountCouponCodeHasProducts === null) {
			if ($this->isNew()) {
				$this->collDiscountCouponCodeHasProducts = array();
			} else {

				$criteria->add(DiscountCouponCodeHasProductPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				$this->collDiscountCouponCodeHasProducts = DiscountCouponCodeHasProductPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DiscountCouponCodeHasProductPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

			if (!isset($this->lastDiscountCouponCodeHasProductCriteria) || !$this->lastDiscountCouponCodeHasProductCriteria->equals($criteria)) {
				$this->collDiscountCouponCodeHasProducts = DiscountCouponCodeHasProductPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastDiscountCouponCodeHasProductCriteria = $criteria;

		return $this->collDiscountCouponCodeHasProducts;
	}

	/**
	 * Temporary storage of collOrders to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOrders()
	{
		if ($this->collOrders === null) {
			$this->collOrders = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode has previously
	 * been saved, it will retrieve related Orders from storage.
	 * If this DiscountCouponCode is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOrders($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
			   $this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				OrderPeer::addSelectColumns($criteria);
				$this->collOrders = OrderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				OrderPeer::addSelectColumns($criteria);
				if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
					$this->collOrders = OrderPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOrderCriteria = $criteria;
		return $this->collOrders;
	}

	/**
	 * Returns the number of related Orders.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOrders($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

		return OrderPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Order object to this object
	 * through the Order foreign key attribute
	 *
	 * @param      Order $l Order
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOrder(Order $l)
	{
		$this->collOrders[] = $l;
		$l->setDiscountCouponCode($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode is new, it will return
	 * an empty collection; or if this DiscountCouponCode has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DiscountCouponCode.
	 */
	public function getOrdersJoinOrderDelivery($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinOrderDelivery($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode is new, it will return
	 * an empty collection; or if this DiscountCouponCode has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DiscountCouponCode.
	 */
	public function getOrdersJoinsfGuardUser($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode is new, it will return
	 * an empty collection; or if this DiscountCouponCode has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DiscountCouponCode.
	 */
	public function getOrdersJoinOrderUserDataDelivery($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataDelivery($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode is new, it will return
	 * an empty collection; or if this DiscountCouponCode has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DiscountCouponCode.
	 */
	public function getOrdersJoinOrderUserDataBilling($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataBilling($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataBilling($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode is new, it will return
	 * an empty collection; or if this DiscountCouponCode has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DiscountCouponCode.
	 */
	public function getOrdersJoinOrderCurrency($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinOrderCurrency($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode is new, it will return
	 * an empty collection; or if this DiscountCouponCode has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DiscountCouponCode.
	 */
	public function getOrdersJoinOrderStatus($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderStatus($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinOrderStatus($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode is new, it will return
	 * an empty collection; or if this DiscountCouponCode has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DiscountCouponCode.
	 */
	public function getOrdersJoinDiscount($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinDiscount($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinDiscount($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode is new, it will return
	 * an empty collection; or if this DiscountCouponCode has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DiscountCouponCode.
	 */
	public function getOrdersJoinPartner($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrders === null) {
			if ($this->isNew()) {
				$this->collOrders = array();
			} else {

				$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinPartner($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinPartner($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}

	/**
	 * Temporary storage of collBaskets to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initBaskets()
	{
		if ($this->collBaskets === null) {
			$this->collBaskets = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode has previously
	 * been saved, it will retrieve related Baskets from storage.
	 * If this DiscountCouponCode is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getBaskets($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBaskets === null) {
			if ($this->isNew()) {
			   $this->collBaskets = array();
			} else {

				$criteria->add(BasketPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				BasketPeer::addSelectColumns($criteria);
				$this->collBaskets = BasketPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(BasketPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				BasketPeer::addSelectColumns($criteria);
				if (!isset($this->lastBasketCriteria) || !$this->lastBasketCriteria->equals($criteria)) {
					$this->collBaskets = BasketPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastBasketCriteria = $criteria;
		return $this->collBaskets;
	}

	/**
	 * Returns the number of related Baskets.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countBaskets($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(BasketPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

		return BasketPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Basket object to this object
	 * through the Basket foreign key attribute
	 *
	 * @param      Basket $l Basket
	 * @return     void
	 * @throws     PropelException
	 */
	public function addBasket(Basket $l)
	{
		$this->collBaskets[] = $l;
		$l->setDiscountCouponCode($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DiscountCouponCode is new, it will return
	 * an empty collection; or if this DiscountCouponCode has previously
	 * been saved, it will retrieve related Baskets from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DiscountCouponCode.
	 */
	public function getBasketsJoinsfGuardUser($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBaskets === null) {
			if ($this->isNew()) {
				$this->collBaskets = array();
			} else {

				$criteria->add(BasketPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

				$this->collBaskets = BasketPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(BasketPeer::DISCOUNT_COUPON_CODE_ID, $this->getId());

			if (!isset($this->lastBasketCriteria) || !$this->lastBasketCriteria->equals($criteria)) {
				$this->collBaskets = BasketPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastBasketCriteria = $criteria;

		return $this->collBaskets;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'DiscountCouponCode.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseDiscountCouponCode:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseDiscountCouponCode::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseDiscountCouponCode
