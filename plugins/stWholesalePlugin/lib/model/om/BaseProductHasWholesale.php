<?php

/**
 * Base class that represents a row from the 'st_product_has_wholesale' table.
 *
 * 
 *
 * @package    plugins.stWholesalePlugin.lib.model.om
 */
abstract class BaseProductHasWholesale extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ProductHasWholesalePeer
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
	 * The value for the product_id field.
	 * @var        int
	 */
	protected $product_id;


	/**
	 * The value for the price_a field.
	 * @var        double
	 */
	protected $price_a;


	/**
	 * The value for the price_b field.
	 * @var        double
	 */
	protected $price_b;


	/**
	 * The value for the price_c field.
	 * @var        double
	 */
	protected $price_c;


	/**
	 * The value for the opt_price_brutto_a field.
	 * @var        double
	 */
	protected $opt_price_brutto_a;


	/**
	 * The value for the opt_price_brutto_b field.
	 * @var        double
	 */
	protected $opt_price_brutto_b;


	/**
	 * The value for the opt_price_brutto_c field.
	 * @var        double
	 */
	protected $opt_price_brutto_c;

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
     * Get the [product_id] column value.
     * 
     * @return     int
     */
    public function getProductId()
    {

            return $this->product_id;
    }

    /**
     * Get the [price_a] column value.
     * 
     * @return     double
     */
    public function getPriceA()
    {

            return null !== $this->price_a ? (string)$this->price_a : null;
    }

    /**
     * Get the [price_b] column value.
     * 
     * @return     double
     */
    public function getPriceB()
    {

            return null !== $this->price_b ? (string)$this->price_b : null;
    }

    /**
     * Get the [price_c] column value.
     * 
     * @return     double
     */
    public function getPriceC()
    {

            return null !== $this->price_c ? (string)$this->price_c : null;
    }

    /**
     * Get the [opt_price_brutto_a] column value.
     * 
     * @return     double
     */
    public function getOptPriceBruttoA()
    {

            return null !== $this->opt_price_brutto_a ? (string)$this->opt_price_brutto_a : null;
    }

    /**
     * Get the [opt_price_brutto_b] column value.
     * 
     * @return     double
     */
    public function getOptPriceBruttoB()
    {

            return null !== $this->opt_price_brutto_b ? (string)$this->opt_price_brutto_b : null;
    }

    /**
     * Get the [opt_price_brutto_c] column value.
     * 
     * @return     double
     */
    public function getOptPriceBruttoC()
    {

            return null !== $this->opt_price_brutto_c ? (string)$this->opt_price_brutto_c : null;
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
			$this->modifiedColumns[] = ProductHasWholesalePeer::CREATED_AT;
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
			$this->modifiedColumns[] = ProductHasWholesalePeer::UPDATED_AT;
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
          $this->modifiedColumns[] = ProductHasWholesalePeer::ID;
        }

	} // setId()

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
          $this->modifiedColumns[] = ProductHasWholesalePeer::PRODUCT_ID;
        }

		if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
			$this->aProduct = null;
		}

	} // setProductId()

	/**
	 * Set the value of [price_a] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setPriceA($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->price_a !== $v) {
          $this->price_a = $v;
          $this->modifiedColumns[] = ProductHasWholesalePeer::PRICE_A;
        }

	} // setPriceA()

	/**
	 * Set the value of [price_b] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setPriceB($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->price_b !== $v) {
          $this->price_b = $v;
          $this->modifiedColumns[] = ProductHasWholesalePeer::PRICE_B;
        }

	} // setPriceB()

	/**
	 * Set the value of [price_c] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setPriceC($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->price_c !== $v) {
          $this->price_c = $v;
          $this->modifiedColumns[] = ProductHasWholesalePeer::PRICE_C;
        }

	} // setPriceC()

	/**
	 * Set the value of [opt_price_brutto_a] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOptPriceBruttoA($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->opt_price_brutto_a !== $v) {
          $this->opt_price_brutto_a = $v;
          $this->modifiedColumns[] = ProductHasWholesalePeer::OPT_PRICE_BRUTTO_A;
        }

	} // setOptPriceBruttoA()

	/**
	 * Set the value of [opt_price_brutto_b] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOptPriceBruttoB($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->opt_price_brutto_b !== $v) {
          $this->opt_price_brutto_b = $v;
          $this->modifiedColumns[] = ProductHasWholesalePeer::OPT_PRICE_BRUTTO_B;
        }

	} // setOptPriceBruttoB()

	/**
	 * Set the value of [opt_price_brutto_c] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOptPriceBruttoC($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->opt_price_brutto_c !== $v) {
          $this->opt_price_brutto_c = $v;
          $this->modifiedColumns[] = ProductHasWholesalePeer::OPT_PRICE_BRUTTO_C;
        }

	} // setOptPriceBruttoC()

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
      if ($this->getDispatcher()->getListeners('ProductHasWholesale.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductHasWholesale.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->product_id = $rs->getInt($startcol + 3);

      $this->price_a = $rs->getString($startcol + 4);
      if (null !== $this->price_a && $this->price_a == intval($this->price_a))
      {
        $this->price_a = (string)intval($this->price_a);
      }

      $this->price_b = $rs->getString($startcol + 5);
      if (null !== $this->price_b && $this->price_b == intval($this->price_b))
      {
        $this->price_b = (string)intval($this->price_b);
      }

      $this->price_c = $rs->getString($startcol + 6);
      if (null !== $this->price_c && $this->price_c == intval($this->price_c))
      {
        $this->price_c = (string)intval($this->price_c);
      }

      $this->opt_price_brutto_a = $rs->getString($startcol + 7);
      if (null !== $this->opt_price_brutto_a && $this->opt_price_brutto_a == intval($this->opt_price_brutto_a))
      {
        $this->opt_price_brutto_a = (string)intval($this->opt_price_brutto_a);
      }

      $this->opt_price_brutto_b = $rs->getString($startcol + 8);
      if (null !== $this->opt_price_brutto_b && $this->opt_price_brutto_b == intval($this->opt_price_brutto_b))
      {
        $this->opt_price_brutto_b = (string)intval($this->opt_price_brutto_b);
      }

      $this->opt_price_brutto_c = $rs->getString($startcol + 9);
      if (null !== $this->opt_price_brutto_c && $this->opt_price_brutto_c == intval($this->opt_price_brutto_c))
      {
        $this->opt_price_brutto_c = (string)intval($this->opt_price_brutto_c);
      }

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('ProductHasWholesale.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductHasWholesale.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 10)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 10; // 10 = ProductHasWholesalePeer::NUM_COLUMNS - ProductHasWholesalePeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating ProductHasWholesale object", $e);
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

    if ($this->getDispatcher()->getListeners('ProductHasWholesale.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductHasWholesale.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductHasWholesale:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseProductHasWholesale:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ProductHasWholesalePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ProductHasWholesalePeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('ProductHasWholesale.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductHasWholesale.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductHasWholesale:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseProductHasWholesale:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('ProductHasWholesale.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'ProductHasWholesale.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseProductHasWholesale:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(ProductHasWholesalePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ProductHasWholesalePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(ProductHasWholesalePeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('ProductHasWholesale.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'ProductHasWholesale.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseProductHasWholesale:save:post') as $callable)
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
					$pk = ProductHasWholesalePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ProductHasWholesalePeer::doUpdate($this, $con);
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


			if (($retval = ProductHasWholesalePeer::doValidate($this, $columns)) !== true) {
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
		$pos = ProductHasWholesalePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getProductId();
				break;
			case 4:
				return $this->getPriceA();
				break;
			case 5:
				return $this->getPriceB();
				break;
			case 6:
				return $this->getPriceC();
				break;
			case 7:
				return $this->getOptPriceBruttoA();
				break;
			case 8:
				return $this->getOptPriceBruttoB();
				break;
			case 9:
				return $this->getOptPriceBruttoC();
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
		$keys = ProductHasWholesalePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getProductId(),
			$keys[4] => $this->getPriceA(),
			$keys[5] => $this->getPriceB(),
			$keys[6] => $this->getPriceC(),
			$keys[7] => $this->getOptPriceBruttoA(),
			$keys[8] => $this->getOptPriceBruttoB(),
			$keys[9] => $this->getOptPriceBruttoC(),
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
		$pos = ProductHasWholesalePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setProductId($value);
				break;
			case 4:
				$this->setPriceA($value);
				break;
			case 5:
				$this->setPriceB($value);
				break;
			case 6:
				$this->setPriceC($value);
				break;
			case 7:
				$this->setOptPriceBruttoA($value);
				break;
			case 8:
				$this->setOptPriceBruttoB($value);
				break;
			case 9:
				$this->setOptPriceBruttoC($value);
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
		$keys = ProductHasWholesalePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setProductId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPriceA($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPriceB($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setPriceC($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setOptPriceBruttoA($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setOptPriceBruttoB($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setOptPriceBruttoC($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ProductHasWholesalePeer::DATABASE_NAME);

		if ($this->isColumnModified(ProductHasWholesalePeer::CREATED_AT)) $criteria->add(ProductHasWholesalePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ProductHasWholesalePeer::UPDATED_AT)) $criteria->add(ProductHasWholesalePeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(ProductHasWholesalePeer::ID)) $criteria->add(ProductHasWholesalePeer::ID, $this->id);
		if ($this->isColumnModified(ProductHasWholesalePeer::PRODUCT_ID)) $criteria->add(ProductHasWholesalePeer::PRODUCT_ID, $this->product_id);
		if ($this->isColumnModified(ProductHasWholesalePeer::PRICE_A)) $criteria->add(ProductHasWholesalePeer::PRICE_A, $this->price_a);
		if ($this->isColumnModified(ProductHasWholesalePeer::PRICE_B)) $criteria->add(ProductHasWholesalePeer::PRICE_B, $this->price_b);
		if ($this->isColumnModified(ProductHasWholesalePeer::PRICE_C)) $criteria->add(ProductHasWholesalePeer::PRICE_C, $this->price_c);
		if ($this->isColumnModified(ProductHasWholesalePeer::OPT_PRICE_BRUTTO_A)) $criteria->add(ProductHasWholesalePeer::OPT_PRICE_BRUTTO_A, $this->opt_price_brutto_a);
		if ($this->isColumnModified(ProductHasWholesalePeer::OPT_PRICE_BRUTTO_B)) $criteria->add(ProductHasWholesalePeer::OPT_PRICE_BRUTTO_B, $this->opt_price_brutto_b);
		if ($this->isColumnModified(ProductHasWholesalePeer::OPT_PRICE_BRUTTO_C)) $criteria->add(ProductHasWholesalePeer::OPT_PRICE_BRUTTO_C, $this->opt_price_brutto_c);

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
		$criteria = new Criteria(ProductHasWholesalePeer::DATABASE_NAME);

		$criteria->add(ProductHasWholesalePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of ProductHasWholesale (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setProductId($this->product_id);

		$copyObj->setPriceA($this->price_a);

		$copyObj->setPriceB($this->price_b);

		$copyObj->setPriceC($this->price_c);

		$copyObj->setOptPriceBruttoA($this->opt_price_brutto_a);

		$copyObj->setOptPriceBruttoB($this->opt_price_brutto_b);

		$copyObj->setOptPriceBruttoC($this->opt_price_brutto_c);


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
	 * @return     ProductHasWholesale Clone of current object.
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
	 * @return     ProductHasWholesalePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ProductHasWholesalePeer();
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'ProductHasWholesale.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseProductHasWholesale:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseProductHasWholesale::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseProductHasWholesale
