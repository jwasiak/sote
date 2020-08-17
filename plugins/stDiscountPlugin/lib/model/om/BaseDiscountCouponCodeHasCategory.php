<?php

/**
 * Base class that represents a row from the 'st_discount_coupon_code_has_category' table.
 *
 * 
 *
 * @package    plugins.stDiscountPlugin.lib.model.om
 */
abstract class BaseDiscountCouponCodeHasCategory extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        DiscountCouponCodeHasCategoryPeer
	 */
	protected static $peer;


	/**
	 * The value for the discount_coupon_code_id field.
	 * @var        int
	 */
	protected $discount_coupon_code_id;


	/**
	 * The value for the category_id field.
	 * @var        int
	 */
	protected $category_id;


	/**
	 * The value for the is_opt field.
	 * @var        boolean
	 */
	protected $is_opt = false;

	/**
	 * @var        DiscountCouponCode
	 */
	protected $aDiscountCouponCode;

	/**
	 * @var        Category
	 */
	protected $aCategory;

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
     * Get the [discount_coupon_code_id] column value.
     * 
     * @return     int
     */
    public function getDiscountCouponCodeId()
    {

            return $this->discount_coupon_code_id;
    }

    /**
     * Get the [category_id] column value.
     * 
     * @return     int
     */
    public function getCategoryId()
    {

            return $this->category_id;
    }

    /**
     * Get the [is_opt] column value.
     * 
     * @return     boolean
     */
    public function getIsOpt()
    {

            return $this->is_opt;
    }

	/**
	 * Set the value of [discount_coupon_code_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setDiscountCouponCodeId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->discount_coupon_code_id !== $v) {
          $this->discount_coupon_code_id = $v;
          $this->modifiedColumns[] = DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID;
        }

		if ($this->aDiscountCouponCode !== null && $this->aDiscountCouponCode->getId() !== $v) {
			$this->aDiscountCouponCode = null;
		}

	} // setDiscountCouponCodeId()

	/**
	 * Set the value of [category_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCategoryId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->category_id !== $v) {
          $this->category_id = $v;
          $this->modifiedColumns[] = DiscountCouponCodeHasCategoryPeer::CATEGORY_ID;
        }

		if ($this->aCategory !== null && $this->aCategory->getId() !== $v) {
			$this->aCategory = null;
		}

	} // setCategoryId()

	/**
	 * Set the value of [is_opt] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsOpt($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_opt !== $v || $v === false) {
          $this->is_opt = $v;
          $this->modifiedColumns[] = DiscountCouponCodeHasCategoryPeer::IS_OPT;
        }

	} // setIsOpt()

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
      if ($this->getDispatcher()->getListeners('DiscountCouponCodeHasCategory.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'DiscountCouponCodeHasCategory.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->discount_coupon_code_id = $rs->getInt($startcol + 0);

      $this->category_id = $rs->getInt($startcol + 1);

      $this->is_opt = $rs->getBoolean($startcol + 2);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('DiscountCouponCodeHasCategory.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'DiscountCouponCodeHasCategory.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 3)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 3; // 3 = DiscountCouponCodeHasCategoryPeer::NUM_COLUMNS - DiscountCouponCodeHasCategoryPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating DiscountCouponCodeHasCategory object", $e);
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

    if ($this->getDispatcher()->getListeners('DiscountCouponCodeHasCategory.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'DiscountCouponCodeHasCategory.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseDiscountCouponCodeHasCategory:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseDiscountCouponCodeHasCategory:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(DiscountCouponCodeHasCategoryPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      DiscountCouponCodeHasCategoryPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('DiscountCouponCodeHasCategory.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'DiscountCouponCodeHasCategory.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseDiscountCouponCodeHasCategory:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseDiscountCouponCodeHasCategory:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('DiscountCouponCodeHasCategory.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'DiscountCouponCodeHasCategory.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseDiscountCouponCodeHasCategory:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(DiscountCouponCodeHasCategoryPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('DiscountCouponCodeHasCategory.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'DiscountCouponCodeHasCategory.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseDiscountCouponCodeHasCategory:save:post') as $callable)
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

			if ($this->aDiscountCouponCode !== null) {
				if ($this->aDiscountCouponCode->isModified()) {
					$affectedRows += $this->aDiscountCouponCode->save($con);
				}
				$this->setDiscountCouponCode($this->aDiscountCouponCode);
			}

			if ($this->aCategory !== null) {
				if ($this->aCategory->isModified() || $this->aCategory->getCurrentCategoryI18n()->isModified()) {
					$affectedRows += $this->aCategory->save($con);
				}
				$this->setCategory($this->aCategory);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = DiscountCouponCodeHasCategoryPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += DiscountCouponCodeHasCategoryPeer::doUpdate($this, $con);
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

			if ($this->aDiscountCouponCode !== null) {
				if (!$this->aDiscountCouponCode->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDiscountCouponCode->getValidationFailures());
				}
			}

			if ($this->aCategory !== null) {
				if (!$this->aCategory->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCategory->getValidationFailures());
				}
			}


			if (($retval = DiscountCouponCodeHasCategoryPeer::doValidate($this, $columns)) !== true) {
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
		$pos = DiscountCouponCodeHasCategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getDiscountCouponCodeId();
				break;
			case 1:
				return $this->getCategoryId();
				break;
			case 2:
				return $this->getIsOpt();
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
		$keys = DiscountCouponCodeHasCategoryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getDiscountCouponCodeId(),
			$keys[1] => $this->getCategoryId(),
			$keys[2] => $this->getIsOpt(),
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
		$pos = DiscountCouponCodeHasCategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setDiscountCouponCodeId($value);
				break;
			case 1:
				$this->setCategoryId($value);
				break;
			case 2:
				$this->setIsOpt($value);
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
		$keys = DiscountCouponCodeHasCategoryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setDiscountCouponCodeId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCategoryId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIsOpt($arr[$keys[2]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(DiscountCouponCodeHasCategoryPeer::DATABASE_NAME);

		if ($this->isColumnModified(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID)) $criteria->add(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, $this->discount_coupon_code_id);
		if ($this->isColumnModified(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID)) $criteria->add(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, $this->category_id);
		if ($this->isColumnModified(DiscountCouponCodeHasCategoryPeer::IS_OPT)) $criteria->add(DiscountCouponCodeHasCategoryPeer::IS_OPT, $this->is_opt);

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
		$criteria = new Criteria(DiscountCouponCodeHasCategoryPeer::DATABASE_NAME);

		$criteria->add(DiscountCouponCodeHasCategoryPeer::DISCOUNT_COUPON_CODE_ID, $this->discount_coupon_code_id);
		$criteria->add(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, $this->category_id);

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

		$pks[0] = $this->getDiscountCouponCodeId();

		$pks[1] = $this->getCategoryId();

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

		$this->setDiscountCouponCodeId($keys[0]);

		$this->setCategoryId($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of DiscountCouponCodeHasCategory (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setIsOpt($this->is_opt);


		$copyObj->setNew(true);

		$copyObj->setDiscountCouponCodeId(NULL); // this is a pkey column, so set to default value

		$copyObj->setCategoryId(NULL); // this is a pkey column, so set to default value

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
	 * @return     DiscountCouponCodeHasCategory Clone of current object.
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
	 * @return     DiscountCouponCodeHasCategoryPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new DiscountCouponCodeHasCategoryPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a DiscountCouponCode object.
	 *
	 * @param      DiscountCouponCode $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setDiscountCouponCode($v)
	{


		if ($v === null) {
			$this->setDiscountCouponCodeId(NULL);
		} else {
			$this->setDiscountCouponCodeId($v->getId());
		}


		$this->aDiscountCouponCode = $v;
	}


	/**
	 * Get the associated DiscountCouponCode object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     DiscountCouponCode The associated DiscountCouponCode object.
	 * @throws     PropelException
	 */
	public function getDiscountCouponCode($con = null)
	{
		if ($this->aDiscountCouponCode === null && ($this->discount_coupon_code_id !== null)) {
			// include the related Peer class
			$this->aDiscountCouponCode = DiscountCouponCodePeer::retrieveByPK($this->discount_coupon_code_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = DiscountCouponCodePeer::retrieveByPK($this->discount_coupon_code_id, $con);
			   $obj->addDiscountCouponCodes($this);
			 */
		}
		return $this->aDiscountCouponCode;
	}

	/**
	 * Declares an association between this object and a Category object.
	 *
	 * @param      Category $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setCategory($v)
	{


		if ($v === null) {
			$this->setCategoryId(NULL);
		} else {
			$this->setCategoryId($v->getId());
		}


		$this->aCategory = $v;
	}


	/**
	 * Get the associated Category object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Category The associated Category object.
	 * @throws     PropelException
	 */
	public function getCategory($con = null)
	{
		if ($this->aCategory === null && ($this->category_id !== null)) {
			// include the related Peer class
			$this->aCategory = CategoryPeer::retrieveByPK($this->category_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = CategoryPeer::retrieveByPK($this->category_id, $con);
			   $obj->addCategorys($this);
			 */
		}
		return $this->aCategory;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'DiscountCouponCodeHasCategory.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseDiscountCouponCodeHasCategory:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseDiscountCouponCodeHasCategory::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseDiscountCouponCodeHasCategory