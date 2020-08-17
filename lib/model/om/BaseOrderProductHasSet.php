<?php

/**
 * Base class that represents a row from the 'st_order_product_has_set' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseOrderProductHasSet extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        OrderProductHasSetPeer
	 */
	protected static $peer;


	/**
	 * The value for the order_product_id field.
	 * @var        int
	 */
	protected $order_product_id;


	/**
	 * The value for the product_id field.
	 * @var        int
	 */
	protected $product_id;


	/**
	 * The value for the code field.
	 * @var        string
	 */
	protected $code;


	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;


	/**
	 * The value for the price_netto field.
	 * @var        double
	 */
	protected $price_netto;


	/**
	 * The value for the price_brutto field.
	 * @var        double
	 */
	protected $price_brutto;

	/**
	 * @var        OrderProduct
	 */
	protected $aOrderProduct;

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
     * Get the [order_product_id] column value.
     * 
     * @return     int
     */
    public function getOrderProductId()
    {

            return $this->order_product_id;
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
     * Get the [code] column value.
     * 
     * @return     string
     */
    public function getCode()
    {

            return $this->code;
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
     * Get the [price_netto] column value.
     * 
     * @return     double
     */
    public function getPriceNetto()
    {

            return null !== $this->price_netto ? (string)$this->price_netto : null;
    }

    /**
     * Get the [price_brutto] column value.
     * 
     * @return     double
     */
    public function getPriceBrutto()
    {

            return null !== $this->price_brutto ? (string)$this->price_brutto : null;
    }

	/**
	 * Set the value of [order_product_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOrderProductId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->order_product_id !== $v) {
          $this->order_product_id = $v;
          $this->modifiedColumns[] = OrderProductHasSetPeer::ORDER_PRODUCT_ID;
        }

		if ($this->aOrderProduct !== null && $this->aOrderProduct->getId() !== $v) {
			$this->aOrderProduct = null;
		}

	} // setOrderProductId()

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
          $this->modifiedColumns[] = OrderProductHasSetPeer::PRODUCT_ID;
        }

		if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
			$this->aProduct = null;
		}

	} // setProductId()

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
          $this->modifiedColumns[] = OrderProductHasSetPeer::CODE;
        }

	} // setCode()

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
          $this->modifiedColumns[] = OrderProductHasSetPeer::NAME;
        }

	} // setName()

	/**
	 * Set the value of [price_netto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setPriceNetto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->price_netto !== $v) {
          $this->price_netto = $v;
          $this->modifiedColumns[] = OrderProductHasSetPeer::PRICE_NETTO;
        }

	} // setPriceNetto()

	/**
	 * Set the value of [price_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setPriceBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->price_brutto !== $v) {
          $this->price_brutto = $v;
          $this->modifiedColumns[] = OrderProductHasSetPeer::PRICE_BRUTTO;
        }

	} // setPriceBrutto()

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
      if ($this->getDispatcher()->getListeners('OrderProductHasSet.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'OrderProductHasSet.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->order_product_id = $rs->getInt($startcol + 0);

      $this->product_id = $rs->getInt($startcol + 1);

      $this->code = $rs->getString($startcol + 2);

      $this->name = $rs->getString($startcol + 3);

      $this->price_netto = $rs->getString($startcol + 4);
      if (null !== $this->price_netto && $this->price_netto == intval($this->price_netto))
      {
        $this->price_netto = (string)intval($this->price_netto);
      }

      $this->price_brutto = $rs->getString($startcol + 5);
      if (null !== $this->price_brutto && $this->price_brutto == intval($this->price_brutto))
      {
        $this->price_brutto = (string)intval($this->price_brutto);
      }

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('OrderProductHasSet.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'OrderProductHasSet.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 6)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 6; // 6 = OrderProductHasSetPeer::NUM_COLUMNS - OrderProductHasSetPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating OrderProductHasSet object", $e);
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

    if ($this->getDispatcher()->getListeners('OrderProductHasSet.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'OrderProductHasSet.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseOrderProductHasSet:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseOrderProductHasSet:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(OrderProductHasSetPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      OrderProductHasSetPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('OrderProductHasSet.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'OrderProductHasSet.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseOrderProductHasSet:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseOrderProductHasSet:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('OrderProductHasSet.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'OrderProductHasSet.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseOrderProductHasSet:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(OrderProductHasSetPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('OrderProductHasSet.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'OrderProductHasSet.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseOrderProductHasSet:save:post') as $callable)
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

			if ($this->aOrderProduct !== null) {
				if ($this->aOrderProduct->isModified()) {
					$affectedRows += $this->aOrderProduct->save($con);
				}
				$this->setOrderProduct($this->aOrderProduct);
			}

			if ($this->aProduct !== null) {
				if ($this->aProduct->isModified() || $this->aProduct->getCurrentProductI18n()->isModified()) {
					$affectedRows += $this->aProduct->save($con);
				}
				$this->setProduct($this->aProduct);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OrderProductHasSetPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += OrderProductHasSetPeer::doUpdate($this, $con);
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

			if ($this->aOrderProduct !== null) {
				if (!$this->aOrderProduct->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOrderProduct->getValidationFailures());
				}
			}

			if ($this->aProduct !== null) {
				if (!$this->aProduct->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProduct->getValidationFailures());
				}
			}


			if (($retval = OrderProductHasSetPeer::doValidate($this, $columns)) !== true) {
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
		$pos = OrderProductHasSetPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getOrderProductId();
				break;
			case 1:
				return $this->getProductId();
				break;
			case 2:
				return $this->getCode();
				break;
			case 3:
				return $this->getName();
				break;
			case 4:
				return $this->getPriceNetto();
				break;
			case 5:
				return $this->getPriceBrutto();
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
		$keys = OrderProductHasSetPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getOrderProductId(),
			$keys[1] => $this->getProductId(),
			$keys[2] => $this->getCode(),
			$keys[3] => $this->getName(),
			$keys[4] => $this->getPriceNetto(),
			$keys[5] => $this->getPriceBrutto(),
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
		$pos = OrderProductHasSetPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setOrderProductId($value);
				break;
			case 1:
				$this->setProductId($value);
				break;
			case 2:
				$this->setCode($value);
				break;
			case 3:
				$this->setName($value);
				break;
			case 4:
				$this->setPriceNetto($value);
				break;
			case 5:
				$this->setPriceBrutto($value);
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
		$keys = OrderProductHasSetPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setOrderProductId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setProductId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setCode($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPriceNetto($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPriceBrutto($arr[$keys[5]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(OrderProductHasSetPeer::DATABASE_NAME);

		if ($this->isColumnModified(OrderProductHasSetPeer::ORDER_PRODUCT_ID)) $criteria->add(OrderProductHasSetPeer::ORDER_PRODUCT_ID, $this->order_product_id);
		if ($this->isColumnModified(OrderProductHasSetPeer::PRODUCT_ID)) $criteria->add(OrderProductHasSetPeer::PRODUCT_ID, $this->product_id);
		if ($this->isColumnModified(OrderProductHasSetPeer::CODE)) $criteria->add(OrderProductHasSetPeer::CODE, $this->code);
		if ($this->isColumnModified(OrderProductHasSetPeer::NAME)) $criteria->add(OrderProductHasSetPeer::NAME, $this->name);
		if ($this->isColumnModified(OrderProductHasSetPeer::PRICE_NETTO)) $criteria->add(OrderProductHasSetPeer::PRICE_NETTO, $this->price_netto);
		if ($this->isColumnModified(OrderProductHasSetPeer::PRICE_BRUTTO)) $criteria->add(OrderProductHasSetPeer::PRICE_BRUTTO, $this->price_brutto);

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
		$criteria = new Criteria(OrderProductHasSetPeer::DATABASE_NAME);

		$criteria->add(OrderProductHasSetPeer::ORDER_PRODUCT_ID, $this->order_product_id);
		$criteria->add(OrderProductHasSetPeer::PRODUCT_ID, $this->product_id);

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

		$pks[0] = $this->getOrderProductId();

		$pks[1] = $this->getProductId();

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

		$this->setOrderProductId($keys[0]);

		$this->setProductId($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of OrderProductHasSet (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCode($this->code);

		$copyObj->setName($this->name);

		$copyObj->setPriceNetto($this->price_netto);

		$copyObj->setPriceBrutto($this->price_brutto);


		$copyObj->setNew(true);

		$copyObj->setOrderProductId(NULL); // this is a pkey column, so set to default value

		$copyObj->setProductId(NULL); // this is a pkey column, so set to default value

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
	 * @return     OrderProductHasSet Clone of current object.
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
	 * @return     OrderProductHasSetPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new OrderProductHasSetPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a OrderProduct object.
	 *
	 * @param      OrderProduct $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setOrderProduct($v)
	{


		if ($v === null) {
			$this->setOrderProductId(NULL);
		} else {
			$this->setOrderProductId($v->getId());
		}


		$this->aOrderProduct = $v;
	}


	/**
	 * Get the associated OrderProduct object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     OrderProduct The associated OrderProduct object.
	 * @throws     PropelException
	 */
	public function getOrderProduct($con = null)
	{
		if ($this->aOrderProduct === null && ($this->order_product_id !== null)) {
			// include the related Peer class
			$this->aOrderProduct = OrderProductPeer::retrieveByPK($this->order_product_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = OrderProductPeer::retrieveByPK($this->order_product_id, $con);
			   $obj->addOrderProducts($this);
			 */
		}
		return $this->aOrderProduct;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'OrderProductHasSet.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseOrderProductHasSet:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseOrderProductHasSet::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseOrderProductHasSet
