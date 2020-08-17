<?php

/**
 * Base class that represents a row from the 'st_discount' table.
 *
 * 
 *
 * @package    plugins.stDiscountPlugin.lib.model.om
 */
abstract class BaseDiscount extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        DiscountPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the type field.
	 * @var        string
	 */
	protected $type = 'P';


	/**
	 * The value for the price_type field.
	 * @var        string
	 */
	protected $price_type = '%';


	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the value field.
	 * @var        double
	 */
	protected $value = 0;


	/**
	 * The value for the conditions field.
	 * @var        string
	 */
	protected $conditions;


	/**
	 * The value for the priority field.
	 * @var        int
	 */
	protected $priority = 0;


	/**
	 * The value for the active field.
	 * @var        boolean
	 */
	protected $active = true;


	/**
	 * The value for the all_products field.
	 * @var        boolean
	 */
	protected $all_products = false;


	/**
	 * The value for the all_clients field.
	 * @var        boolean
	 */
	protected $all_clients = false;


	/**
	 * The value for the allow_anonymous_clients field.
	 * @var        boolean
	 */
	protected $allow_anonymous_clients = false;


	/**
	 * The value for the auto_active field.
	 * @var        boolean
	 */
	protected $auto_active = false;


	/**
	 * The value for the product_id field.
	 * @var        int
	 */
	protected $product_id;

	/**
	 * @var        Product
	 */
	protected $aProduct;

	/**
	 * Collection to store aggregation of collUserHasDiscounts.
	 * @var        array
	 */
	protected $collUserHasDiscounts;

	/**
	 * The criteria used to select the current contents of collUserHasDiscounts.
	 * @var        Criteria
	 */
	protected $lastUserHasDiscountCriteria = null;

	/**
	 * Collection to store aggregation of collDiscountHasProducts.
	 * @var        array
	 */
	protected $collDiscountHasProducts;

	/**
	 * The criteria used to select the current contents of collDiscountHasProducts.
	 * @var        Criteria
	 */
	protected $lastDiscountHasProductCriteria = null;

	/**
	 * Collection to store aggregation of collDiscountRanges.
	 * @var        array
	 */
	protected $collDiscountRanges;

	/**
	 * The criteria used to select the current contents of collDiscountRanges.
	 * @var        Criteria
	 */
	protected $lastDiscountRangeCriteria = null;

	/**
	 * Collection to store aggregation of collDiscountHasProducers.
	 * @var        array
	 */
	protected $collDiscountHasProducers;

	/**
	 * The criteria used to select the current contents of collDiscountHasProducers.
	 * @var        Criteria
	 */
	protected $lastDiscountHasProducerCriteria = null;

	/**
	 * Collection to store aggregation of collDiscountHasCategorys.
	 * @var        array
	 */
	protected $collDiscountHasCategorys;

	/**
	 * The criteria used to select the current contents of collDiscountHasCategorys.
	 * @var        Criteria
	 */
	protected $lastDiscountHasCategoryCriteria = null;

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
     * Get the [type] column value.
     * 
     * @return     string
     */
    public function getType()
    {

            return $this->type;
    }

    /**
     * Get the [price_type] column value.
     * 
     * @return     string
     */
    public function getPriceType()
    {

            return $this->price_type;
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
     * Get the [value] column value.
     * 
     * @return     double
     */
    public function getValue()
    {

            return null !== $this->value ? (string)$this->value : null;
    }

    /**
     * Get the [conditions] column value.
     * 
     * @return     string
     */
    public function getConditions()
    {

            return $this->conditions;
    }

    /**
     * Get the [priority] column value.
     * 
     * @return     int
     */
    public function getPriority()
    {

            return $this->priority;
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
     * Get the [all_products] column value.
     * 
     * @return     boolean
     */
    public function getAllProducts()
    {

            return $this->all_products;
    }

    /**
     * Get the [all_clients] column value.
     * 
     * @return     boolean
     */
    public function getAllClients()
    {

            return $this->all_clients;
    }

    /**
     * Get the [allow_anonymous_clients] column value.
     * 
     * @return     boolean
     */
    public function getAllowAnonymousClients()
    {

            return $this->allow_anonymous_clients;
    }

    /**
     * Get the [auto_active] column value.
     * 
     * @return     boolean
     */
    public function getAutoActive()
    {

            return $this->auto_active;
    }

    /**
     * Get the [product_id] column value.
     * 
     * @return     int
     */
    public function getProductId()
    {

            return $this->product_id;
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
          $this->modifiedColumns[] = DiscountPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [type] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setType($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->type !== $v || $v === 'P') {
          $this->type = $v;
          $this->modifiedColumns[] = DiscountPeer::TYPE;
        }

	} // setType()

	/**
	 * Set the value of [price_type] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPriceType($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->price_type !== $v || $v === '%') {
          $this->price_type = $v;
          $this->modifiedColumns[] = DiscountPeer::PRICE_TYPE;
        }

	} // setPriceType()

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
          $this->modifiedColumns[] = DiscountPeer::NAME;
        }

	} // setName()

	/**
	 * Set the value of [value] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setValue($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->value !== $v || $v === 0) {
          $this->value = $v;
          $this->modifiedColumns[] = DiscountPeer::VALUE;
        }

	} // setValue()

	/**
	 * Set the value of [conditions] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setConditions($v)
	{

        if ($this->conditions !== $v) {
          $this->conditions = $v;
          $this->modifiedColumns[] = DiscountPeer::CONDITIONS;
        }

	} // setConditions()

	/**
	 * Set the value of [priority] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPriority($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->priority !== $v || $v === 0) {
          $this->priority = $v;
          $this->modifiedColumns[] = DiscountPeer::PRIORITY;
        }

	} // setPriority()

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
          $this->modifiedColumns[] = DiscountPeer::ACTIVE;
        }

	} // setActive()

	/**
	 * Set the value of [all_products] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setAllProducts($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->all_products !== $v || $v === false) {
          $this->all_products = $v;
          $this->modifiedColumns[] = DiscountPeer::ALL_PRODUCTS;
        }

	} // setAllProducts()

	/**
	 * Set the value of [all_clients] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setAllClients($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->all_clients !== $v || $v === false) {
          $this->all_clients = $v;
          $this->modifiedColumns[] = DiscountPeer::ALL_CLIENTS;
        }

	} // setAllClients()

	/**
	 * Set the value of [allow_anonymous_clients] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setAllowAnonymousClients($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->allow_anonymous_clients !== $v || $v === false) {
          $this->allow_anonymous_clients = $v;
          $this->modifiedColumns[] = DiscountPeer::ALLOW_ANONYMOUS_CLIENTS;
        }

	} // setAllowAnonymousClients()

	/**
	 * Set the value of [auto_active] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setAutoActive($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->auto_active !== $v || $v === false) {
          $this->auto_active = $v;
          $this->modifiedColumns[] = DiscountPeer::AUTO_ACTIVE;
        }

	} // setAutoActive()

	/**
	 * Set the value of [product_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setProductId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->product_id !== $v) {
          $this->product_id = $v;
          $this->modifiedColumns[] = DiscountPeer::PRODUCT_ID;
        }

		if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
			$this->aProduct = null;
		}

	} // setProductId()

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
      if ($this->getDispatcher()->getListeners('Discount.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Discount.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->type = $rs->getString($startcol + 1);

      $this->price_type = $rs->getString($startcol + 2);

      $this->name = $rs->getString($startcol + 3);

      $this->value = $rs->getString($startcol + 4);
      if (null !== $this->value && $this->value == intval($this->value))
      {
        $this->value = (string)intval($this->value);
      }

      $this->conditions = $rs->getString($startcol + 5) ? unserialize($rs->getString($startcol + 5)) : null;

      $this->priority = $rs->getInt($startcol + 6);

      $this->active = $rs->getBoolean($startcol + 7);

      $this->all_products = $rs->getBoolean($startcol + 8);

      $this->all_clients = $rs->getBoolean($startcol + 9);

      $this->allow_anonymous_clients = $rs->getBoolean($startcol + 10);

      $this->auto_active = $rs->getBoolean($startcol + 11);

      $this->product_id = $rs->getInt($startcol + 12);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Discount.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Discount.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 13)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 13; // 13 = DiscountPeer::NUM_COLUMNS - DiscountPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Discount object", $e);
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

    if ($this->getDispatcher()->getListeners('Discount.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Discount.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseDiscount:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseDiscount:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(DiscountPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      DiscountPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Discount.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Discount.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseDiscount:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseDiscount:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Discount.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Discount.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseDiscount:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(DiscountPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Discount.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Discount.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseDiscount:save:post') as $callable)
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
              $o_conditions = $this->conditions;
              if (null !== $this->conditions && $this->isColumnModified(DiscountPeer::CONDITIONS)) {
                  $this->conditions = serialize($this->conditions);
              }

				if ($this->isNew()) {
					$pk = DiscountPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += DiscountPeer::doUpdate($this, $con);
				}
				$this->resetModified();
             $this->conditions = $o_conditions;
 // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collUserHasDiscounts !== null) {
				foreach($this->collUserHasDiscounts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDiscountHasProducts !== null) {
				foreach($this->collDiscountHasProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDiscountRanges !== null) {
				foreach($this->collDiscountRanges as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDiscountHasProducers !== null) {
				foreach($this->collDiscountHasProducers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDiscountHasCategorys !== null) {
				foreach($this->collDiscountHasCategorys as $referrerFK) {
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


			if (($retval = DiscountPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collUserHasDiscounts !== null) {
					foreach($this->collUserHasDiscounts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDiscountHasProducts !== null) {
					foreach($this->collDiscountHasProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDiscountRanges !== null) {
					foreach($this->collDiscountRanges as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDiscountHasProducers !== null) {
					foreach($this->collDiscountHasProducers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDiscountHasCategorys !== null) {
					foreach($this->collDiscountHasCategorys as $referrerFK) {
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
		$pos = DiscountPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getType();
				break;
			case 2:
				return $this->getPriceType();
				break;
			case 3:
				return $this->getName();
				break;
			case 4:
				return $this->getValue();
				break;
			case 5:
				return $this->getConditions();
				break;
			case 6:
				return $this->getPriority();
				break;
			case 7:
				return $this->getActive();
				break;
			case 8:
				return $this->getAllProducts();
				break;
			case 9:
				return $this->getAllClients();
				break;
			case 10:
				return $this->getAllowAnonymousClients();
				break;
			case 11:
				return $this->getAutoActive();
				break;
			case 12:
				return $this->getProductId();
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
		$keys = DiscountPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getType(),
			$keys[2] => $this->getPriceType(),
			$keys[3] => $this->getName(),
			$keys[4] => $this->getValue(),
			$keys[5] => $this->getConditions(),
			$keys[6] => $this->getPriority(),
			$keys[7] => $this->getActive(),
			$keys[8] => $this->getAllProducts(),
			$keys[9] => $this->getAllClients(),
			$keys[10] => $this->getAllowAnonymousClients(),
			$keys[11] => $this->getAutoActive(),
			$keys[12] => $this->getProductId(),
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
		$pos = DiscountPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setType($value);
				break;
			case 2:
				$this->setPriceType($value);
				break;
			case 3:
				$this->setName($value);
				break;
			case 4:
				$this->setValue($value);
				break;
			case 5:
				$this->setConditions($value);
				break;
			case 6:
				$this->setPriority($value);
				break;
			case 7:
				$this->setActive($value);
				break;
			case 8:
				$this->setAllProducts($value);
				break;
			case 9:
				$this->setAllClients($value);
				break;
			case 10:
				$this->setAllowAnonymousClients($value);
				break;
			case 11:
				$this->setAutoActive($value);
				break;
			case 12:
				$this->setProductId($value);
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
		$keys = DiscountPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setType($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPriceType($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setValue($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setConditions($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setPriority($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setActive($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setAllProducts($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setAllClients($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setAllowAnonymousClients($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setAutoActive($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setProductId($arr[$keys[12]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(DiscountPeer::DATABASE_NAME);

		if ($this->isColumnModified(DiscountPeer::ID)) $criteria->add(DiscountPeer::ID, $this->id);
		if ($this->isColumnModified(DiscountPeer::TYPE)) $criteria->add(DiscountPeer::TYPE, $this->type);
		if ($this->isColumnModified(DiscountPeer::PRICE_TYPE)) $criteria->add(DiscountPeer::PRICE_TYPE, $this->price_type);
		if ($this->isColumnModified(DiscountPeer::NAME)) $criteria->add(DiscountPeer::NAME, $this->name);
		if ($this->isColumnModified(DiscountPeer::VALUE)) $criteria->add(DiscountPeer::VALUE, $this->value);
		if ($this->isColumnModified(DiscountPeer::CONDITIONS)) $criteria->add(DiscountPeer::CONDITIONS, $this->conditions);
		if ($this->isColumnModified(DiscountPeer::PRIORITY)) $criteria->add(DiscountPeer::PRIORITY, $this->priority);
		if ($this->isColumnModified(DiscountPeer::ACTIVE)) $criteria->add(DiscountPeer::ACTIVE, $this->active);
		if ($this->isColumnModified(DiscountPeer::ALL_PRODUCTS)) $criteria->add(DiscountPeer::ALL_PRODUCTS, $this->all_products);
		if ($this->isColumnModified(DiscountPeer::ALL_CLIENTS)) $criteria->add(DiscountPeer::ALL_CLIENTS, $this->all_clients);
		if ($this->isColumnModified(DiscountPeer::ALLOW_ANONYMOUS_CLIENTS)) $criteria->add(DiscountPeer::ALLOW_ANONYMOUS_CLIENTS, $this->allow_anonymous_clients);
		if ($this->isColumnModified(DiscountPeer::AUTO_ACTIVE)) $criteria->add(DiscountPeer::AUTO_ACTIVE, $this->auto_active);
		if ($this->isColumnModified(DiscountPeer::PRODUCT_ID)) $criteria->add(DiscountPeer::PRODUCT_ID, $this->product_id);

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
		$criteria = new Criteria(DiscountPeer::DATABASE_NAME);

		$criteria->add(DiscountPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Discount (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setType($this->type);

		$copyObj->setPriceType($this->price_type);

		$copyObj->setName($this->name);

		$copyObj->setValue($this->value);

		$copyObj->setConditions($this->conditions);

		$copyObj->setPriority($this->priority);

		$copyObj->setActive($this->active);

		$copyObj->setAllProducts($this->all_products);

		$copyObj->setAllClients($this->all_clients);

		$copyObj->setAllowAnonymousClients($this->allow_anonymous_clients);

		$copyObj->setAutoActive($this->auto_active);

		$copyObj->setProductId($this->product_id);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getUserHasDiscounts() as $relObj) {
				$copyObj->addUserHasDiscount($relObj->copy($deepCopy));
			}

			foreach($this->getDiscountHasProducts() as $relObj) {
				$copyObj->addDiscountHasProduct($relObj->copy($deepCopy));
			}

			foreach($this->getDiscountRanges() as $relObj) {
				$copyObj->addDiscountRange($relObj->copy($deepCopy));
			}

			foreach($this->getDiscountHasProducers() as $relObj) {
				$copyObj->addDiscountHasProducer($relObj->copy($deepCopy));
			}

			foreach($this->getDiscountHasCategorys() as $relObj) {
				$copyObj->addDiscountHasCategory($relObj->copy($deepCopy));
			}

			foreach($this->getOrders() as $relObj) {
				$copyObj->addOrder($relObj->copy($deepCopy));
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
	 * @return     Discount Clone of current object.
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
	 * @return     DiscountPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new DiscountPeer();
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
			$this->setProductId(NULL);
		} else {
			$this->setProductId($v->getId());
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
		if ($this->aProduct === null && ($this->product_id !== null)) {
			// include the related Peer class
			$this->aProduct = ProductPeer::retrieveByPK($this->product_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductPeer::retrieveByPK($this->product_id, $con);
			   $obj->addProducts($this);
			 */
		}
		return $this->aProduct;
	}

	/**
	 * Temporary storage of collUserHasDiscounts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initUserHasDiscounts()
	{
		if ($this->collUserHasDiscounts === null) {
			$this->collUserHasDiscounts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Discount has previously
	 * been saved, it will retrieve related UserHasDiscounts from storage.
	 * If this Discount is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getUserHasDiscounts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserHasDiscounts === null) {
			if ($this->isNew()) {
			   $this->collUserHasDiscounts = array();
			} else {

				$criteria->add(UserHasDiscountPeer::DISCOUNT_ID, $this->getId());

				UserHasDiscountPeer::addSelectColumns($criteria);
				$this->collUserHasDiscounts = UserHasDiscountPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserHasDiscountPeer::DISCOUNT_ID, $this->getId());

				UserHasDiscountPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserHasDiscountCriteria) || !$this->lastUserHasDiscountCriteria->equals($criteria)) {
					$this->collUserHasDiscounts = UserHasDiscountPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserHasDiscountCriteria = $criteria;
		return $this->collUserHasDiscounts;
	}

	/**
	 * Returns the number of related UserHasDiscounts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countUserHasDiscounts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(UserHasDiscountPeer::DISCOUNT_ID, $this->getId());

		return UserHasDiscountPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a UserHasDiscount object to this object
	 * through the UserHasDiscount foreign key attribute
	 *
	 * @param      UserHasDiscount $l UserHasDiscount
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserHasDiscount(UserHasDiscount $l)
	{
		$this->collUserHasDiscounts[] = $l;
		$l->setDiscount($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Discount is new, it will return
	 * an empty collection; or if this Discount has previously
	 * been saved, it will retrieve related UserHasDiscounts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Discount.
	 */
	public function getUserHasDiscountsJoinsfGuardUser($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserHasDiscounts === null) {
			if ($this->isNew()) {
				$this->collUserHasDiscounts = array();
			} else {

				$criteria->add(UserHasDiscountPeer::DISCOUNT_ID, $this->getId());

				$this->collUserHasDiscounts = UserHasDiscountPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserHasDiscountPeer::DISCOUNT_ID, $this->getId());

			if (!isset($this->lastUserHasDiscountCriteria) || !$this->lastUserHasDiscountCriteria->equals($criteria)) {
				$this->collUserHasDiscounts = UserHasDiscountPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastUserHasDiscountCriteria = $criteria;

		return $this->collUserHasDiscounts;
	}

	/**
	 * Temporary storage of collDiscountHasProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDiscountHasProducts()
	{
		if ($this->collDiscountHasProducts === null) {
			$this->collDiscountHasProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Discount has previously
	 * been saved, it will retrieve related DiscountHasProducts from storage.
	 * If this Discount is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDiscountHasProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountHasProducts === null) {
			if ($this->isNew()) {
			   $this->collDiscountHasProducts = array();
			} else {

				$criteria->add(DiscountHasProductPeer::DISCOUNT_ID, $this->getId());

				DiscountHasProductPeer::addSelectColumns($criteria);
				$this->collDiscountHasProducts = DiscountHasProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountHasProductPeer::DISCOUNT_ID, $this->getId());

				DiscountHasProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastDiscountHasProductCriteria) || !$this->lastDiscountHasProductCriteria->equals($criteria)) {
					$this->collDiscountHasProducts = DiscountHasProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDiscountHasProductCriteria = $criteria;
		return $this->collDiscountHasProducts;
	}

	/**
	 * Returns the number of related DiscountHasProducts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDiscountHasProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DiscountHasProductPeer::DISCOUNT_ID, $this->getId());

		return DiscountHasProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DiscountHasProduct object to this object
	 * through the DiscountHasProduct foreign key attribute
	 *
	 * @param      DiscountHasProduct $l DiscountHasProduct
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDiscountHasProduct(DiscountHasProduct $l)
	{
		$this->collDiscountHasProducts[] = $l;
		$l->setDiscount($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Discount is new, it will return
	 * an empty collection; or if this Discount has previously
	 * been saved, it will retrieve related DiscountHasProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Discount.
	 */
	public function getDiscountHasProductsJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountHasProducts === null) {
			if ($this->isNew()) {
				$this->collDiscountHasProducts = array();
			} else {

				$criteria->add(DiscountHasProductPeer::DISCOUNT_ID, $this->getId());

				$this->collDiscountHasProducts = DiscountHasProductPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DiscountHasProductPeer::DISCOUNT_ID, $this->getId());

			if (!isset($this->lastDiscountHasProductCriteria) || !$this->lastDiscountHasProductCriteria->equals($criteria)) {
				$this->collDiscountHasProducts = DiscountHasProductPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastDiscountHasProductCriteria = $criteria;

		return $this->collDiscountHasProducts;
	}

	/**
	 * Temporary storage of collDiscountRanges to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDiscountRanges()
	{
		if ($this->collDiscountRanges === null) {
			$this->collDiscountRanges = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Discount has previously
	 * been saved, it will retrieve related DiscountRanges from storage.
	 * If this Discount is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDiscountRanges($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountRanges === null) {
			if ($this->isNew()) {
			   $this->collDiscountRanges = array();
			} else {

				$criteria->add(DiscountRangePeer::DISCOUNT_ID, $this->getId());

				DiscountRangePeer::addSelectColumns($criteria);
				$this->collDiscountRanges = DiscountRangePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountRangePeer::DISCOUNT_ID, $this->getId());

				DiscountRangePeer::addSelectColumns($criteria);
				if (!isset($this->lastDiscountRangeCriteria) || !$this->lastDiscountRangeCriteria->equals($criteria)) {
					$this->collDiscountRanges = DiscountRangePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDiscountRangeCriteria = $criteria;
		return $this->collDiscountRanges;
	}

	/**
	 * Returns the number of related DiscountRanges.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDiscountRanges($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DiscountRangePeer::DISCOUNT_ID, $this->getId());

		return DiscountRangePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DiscountRange object to this object
	 * through the DiscountRange foreign key attribute
	 *
	 * @param      DiscountRange $l DiscountRange
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDiscountRange(DiscountRange $l)
	{
		$this->collDiscountRanges[] = $l;
		$l->setDiscount($this);
	}

	/**
	 * Temporary storage of collDiscountHasProducers to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDiscountHasProducers()
	{
		if ($this->collDiscountHasProducers === null) {
			$this->collDiscountHasProducers = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Discount has previously
	 * been saved, it will retrieve related DiscountHasProducers from storage.
	 * If this Discount is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDiscountHasProducers($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountHasProducers === null) {
			if ($this->isNew()) {
			   $this->collDiscountHasProducers = array();
			} else {

				$criteria->add(DiscountHasProducerPeer::DISCOUNT_ID, $this->getId());

				DiscountHasProducerPeer::addSelectColumns($criteria);
				$this->collDiscountHasProducers = DiscountHasProducerPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountHasProducerPeer::DISCOUNT_ID, $this->getId());

				DiscountHasProducerPeer::addSelectColumns($criteria);
				if (!isset($this->lastDiscountHasProducerCriteria) || !$this->lastDiscountHasProducerCriteria->equals($criteria)) {
					$this->collDiscountHasProducers = DiscountHasProducerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDiscountHasProducerCriteria = $criteria;
		return $this->collDiscountHasProducers;
	}

	/**
	 * Returns the number of related DiscountHasProducers.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDiscountHasProducers($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DiscountHasProducerPeer::DISCOUNT_ID, $this->getId());

		return DiscountHasProducerPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DiscountHasProducer object to this object
	 * through the DiscountHasProducer foreign key attribute
	 *
	 * @param      DiscountHasProducer $l DiscountHasProducer
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDiscountHasProducer(DiscountHasProducer $l)
	{
		$this->collDiscountHasProducers[] = $l;
		$l->setDiscount($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Discount is new, it will return
	 * an empty collection; or if this Discount has previously
	 * been saved, it will retrieve related DiscountHasProducers from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Discount.
	 */
	public function getDiscountHasProducersJoinProducer($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountHasProducers === null) {
			if ($this->isNew()) {
				$this->collDiscountHasProducers = array();
			} else {

				$criteria->add(DiscountHasProducerPeer::DISCOUNT_ID, $this->getId());

				$this->collDiscountHasProducers = DiscountHasProducerPeer::doSelectJoinProducer($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DiscountHasProducerPeer::DISCOUNT_ID, $this->getId());

			if (!isset($this->lastDiscountHasProducerCriteria) || !$this->lastDiscountHasProducerCriteria->equals($criteria)) {
				$this->collDiscountHasProducers = DiscountHasProducerPeer::doSelectJoinProducer($criteria, $con);
			}
		}
		$this->lastDiscountHasProducerCriteria = $criteria;

		return $this->collDiscountHasProducers;
	}

	/**
	 * Temporary storage of collDiscountHasCategorys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDiscountHasCategorys()
	{
		if ($this->collDiscountHasCategorys === null) {
			$this->collDiscountHasCategorys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Discount has previously
	 * been saved, it will retrieve related DiscountHasCategorys from storage.
	 * If this Discount is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDiscountHasCategorys($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountHasCategorys === null) {
			if ($this->isNew()) {
			   $this->collDiscountHasCategorys = array();
			} else {

				$criteria->add(DiscountHasCategoryPeer::DISCOUNT_ID, $this->getId());

				DiscountHasCategoryPeer::addSelectColumns($criteria);
				$this->collDiscountHasCategorys = DiscountHasCategoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountHasCategoryPeer::DISCOUNT_ID, $this->getId());

				DiscountHasCategoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastDiscountHasCategoryCriteria) || !$this->lastDiscountHasCategoryCriteria->equals($criteria)) {
					$this->collDiscountHasCategorys = DiscountHasCategoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDiscountHasCategoryCriteria = $criteria;
		return $this->collDiscountHasCategorys;
	}

	/**
	 * Returns the number of related DiscountHasCategorys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDiscountHasCategorys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DiscountHasCategoryPeer::DISCOUNT_ID, $this->getId());

		return DiscountHasCategoryPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DiscountHasCategory object to this object
	 * through the DiscountHasCategory foreign key attribute
	 *
	 * @param      DiscountHasCategory $l DiscountHasCategory
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDiscountHasCategory(DiscountHasCategory $l)
	{
		$this->collDiscountHasCategorys[] = $l;
		$l->setDiscount($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Discount is new, it will return
	 * an empty collection; or if this Discount has previously
	 * been saved, it will retrieve related DiscountHasCategorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Discount.
	 */
	public function getDiscountHasCategorysJoinCategory($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscountHasCategorys === null) {
			if ($this->isNew()) {
				$this->collDiscountHasCategorys = array();
			} else {

				$criteria->add(DiscountHasCategoryPeer::DISCOUNT_ID, $this->getId());

				$this->collDiscountHasCategorys = DiscountHasCategoryPeer::doSelectJoinCategory($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DiscountHasCategoryPeer::DISCOUNT_ID, $this->getId());

			if (!isset($this->lastDiscountHasCategoryCriteria) || !$this->lastDiscountHasCategoryCriteria->equals($criteria)) {
				$this->collDiscountHasCategorys = DiscountHasCategoryPeer::doSelectJoinCategory($criteria, $con);
			}
		}
		$this->lastDiscountHasCategoryCriteria = $criteria;

		return $this->collDiscountHasCategorys;
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
	 * Otherwise if this Discount has previously
	 * been saved, it will retrieve related Orders from storage.
	 * If this Discount is new, it will return
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

				$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

				OrderPeer::addSelectColumns($criteria);
				$this->collOrders = OrderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

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

		$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

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
		$l->setDiscount($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Discount is new, it will return
	 * an empty collection; or if this Discount has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Discount.
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

				$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

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
	 * Otherwise if this Discount is new, it will return
	 * an empty collection; or if this Discount has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Discount.
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

				$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

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
	 * Otherwise if this Discount is new, it will return
	 * an empty collection; or if this Discount has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Discount.
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

				$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataDelivery($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

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
	 * Otherwise if this Discount is new, it will return
	 * an empty collection; or if this Discount has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Discount.
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

				$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderUserDataBilling($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

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
	 * Otherwise if this Discount is new, it will return
	 * an empty collection; or if this Discount has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Discount.
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

				$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

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
	 * Otherwise if this Discount is new, it will return
	 * an empty collection; or if this Discount has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Discount.
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

				$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinOrderStatus($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

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
	 * Otherwise if this Discount is new, it will return
	 * an empty collection; or if this Discount has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Discount.
	 */
	public function getOrdersJoinDiscountCouponCode($criteria = null, $con = null)
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

				$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Discount is new, it will return
	 * an empty collection; or if this Discount has previously
	 * been saved, it will retrieve related Orders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Discount.
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

				$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

				$this->collOrders = OrderPeer::doSelectJoinPartner($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderPeer::DISCOUNT_ID, $this->getId());

			if (!isset($this->lastOrderCriteria) || !$this->lastOrderCriteria->equals($criteria)) {
				$this->collOrders = OrderPeer::doSelectJoinPartner($criteria, $con);
			}
		}
		$this->lastOrderCriteria = $criteria;

		return $this->collOrders;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Discount.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseDiscount:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseDiscount::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseDiscount
