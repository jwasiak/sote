<?php

/**
 * Base class that represents a row from the 'st_product_has_product_search_tag' table.
 *
 * 
 *
 * @package    plugins.stSearchPlugin.lib.model.om
 */
abstract class BaseProductHasProductSearchTag extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ProductHasProductSearchTagPeer
	 */
	protected static $peer;


	/**
	 * The value for the product_id field.
	 * @var        int
	 */
	protected $product_id;


	/**
	 * The value for the product_search_tag_id field.
	 * @var        int
	 */
	protected $product_search_tag_id;


	/**
	 * The value for the culture field.
	 * @var        string
	 */
	protected $culture;


	/**
	 * The value for the tag_value field.
	 * @var        int
	 */
	protected $tag_value = 1;

	/**
	 * @var        Product
	 */
	protected $aProduct;

	/**
	 * @var        ProductSearchTag
	 */
	protected $aProductSearchTag;

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
     * Get the [product_id] column value.
     * 
     * @return     int
     */
    public function getProductId()
    {

            return $this->product_id;
    }

    /**
     * Get the [product_search_tag_id] column value.
     * 
     * @return     int
     */
    public function getProductSearchTagId()
    {

            return $this->product_search_tag_id;
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
     * Get the [tag_value] column value.
     * 
     * @return     int
     */
    public function getTagValue()
    {

            return $this->tag_value;
    }

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
          $this->modifiedColumns[] = ProductHasProductSearchTagPeer::PRODUCT_ID;
        }

		if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
			$this->aProduct = null;
		}

	} // setProductId()

	/**
	 * Set the value of [product_search_tag_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setProductSearchTagId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->product_search_tag_id !== $v) {
          $this->product_search_tag_id = $v;
          $this->modifiedColumns[] = ProductHasProductSearchTagPeer::PRODUCT_SEARCH_TAG_ID;
        }

		if ($this->aProductSearchTag !== null && $this->aProductSearchTag->getId() !== $v) {
			$this->aProductSearchTag = null;
		}

	} // setProductSearchTagId()

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
          $this->modifiedColumns[] = ProductHasProductSearchTagPeer::CULTURE;
        }

	} // setCulture()

	/**
	 * Set the value of [tag_value] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setTagValue($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->tag_value !== $v || $v === 1) {
          $this->tag_value = $v;
          $this->modifiedColumns[] = ProductHasProductSearchTagPeer::TAG_VALUE;
        }

	} // setTagValue()

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
      if ($this->getDispatcher()->getListeners('ProductHasProductSearchTag.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductHasProductSearchTag.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->product_id = $rs->getInt($startcol + 0);

      $this->product_search_tag_id = $rs->getInt($startcol + 1);

      $this->culture = $rs->getString($startcol + 2);

      $this->tag_value = $rs->getInt($startcol + 3);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('ProductHasProductSearchTag.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'ProductHasProductSearchTag.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 4)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 4; // 4 = ProductHasProductSearchTagPeer::NUM_COLUMNS - ProductHasProductSearchTagPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating ProductHasProductSearchTag object", $e);
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

    if ($this->getDispatcher()->getListeners('ProductHasProductSearchTag.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductHasProductSearchTag.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductHasProductSearchTag:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseProductHasProductSearchTag:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ProductHasProductSearchTagPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ProductHasProductSearchTagPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('ProductHasProductSearchTag.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'ProductHasProductSearchTag.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProductHasProductSearchTag:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseProductHasProductSearchTag:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('ProductHasProductSearchTag.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'ProductHasProductSearchTag.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseProductHasProductSearchTag:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(ProductHasProductSearchTagPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('ProductHasProductSearchTag.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'ProductHasProductSearchTag.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseProductHasProductSearchTag:save:post') as $callable)
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

			if ($this->aProductSearchTag !== null) {
				if ($this->aProductSearchTag->isModified()) {
					$affectedRows += $this->aProductSearchTag->save($con);
				}
				$this->setProductSearchTag($this->aProductSearchTag);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ProductHasProductSearchTagPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += ProductHasProductSearchTagPeer::doUpdate($this, $con);
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

			if ($this->aProductSearchTag !== null) {
				if (!$this->aProductSearchTag->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProductSearchTag->getValidationFailures());
				}
			}


			if (($retval = ProductHasProductSearchTagPeer::doValidate($this, $columns)) !== true) {
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
		$pos = ProductHasProductSearchTagPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getProductId();
				break;
			case 1:
				return $this->getProductSearchTagId();
				break;
			case 2:
				return $this->getCulture();
				break;
			case 3:
				return $this->getTagValue();
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
		$keys = ProductHasProductSearchTagPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getProductId(),
			$keys[1] => $this->getProductSearchTagId(),
			$keys[2] => $this->getCulture(),
			$keys[3] => $this->getTagValue(),
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
		$pos = ProductHasProductSearchTagPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setProductId($value);
				break;
			case 1:
				$this->setProductSearchTagId($value);
				break;
			case 2:
				$this->setCulture($value);
				break;
			case 3:
				$this->setTagValue($value);
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
		$keys = ProductHasProductSearchTagPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setProductId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setProductSearchTagId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setCulture($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTagValue($arr[$keys[3]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ProductHasProductSearchTagPeer::DATABASE_NAME);

		if ($this->isColumnModified(ProductHasProductSearchTagPeer::PRODUCT_ID)) $criteria->add(ProductHasProductSearchTagPeer::PRODUCT_ID, $this->product_id);
		if ($this->isColumnModified(ProductHasProductSearchTagPeer::PRODUCT_SEARCH_TAG_ID)) $criteria->add(ProductHasProductSearchTagPeer::PRODUCT_SEARCH_TAG_ID, $this->product_search_tag_id);
		if ($this->isColumnModified(ProductHasProductSearchTagPeer::CULTURE)) $criteria->add(ProductHasProductSearchTagPeer::CULTURE, $this->culture);
		if ($this->isColumnModified(ProductHasProductSearchTagPeer::TAG_VALUE)) $criteria->add(ProductHasProductSearchTagPeer::TAG_VALUE, $this->tag_value);

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
		$criteria = new Criteria(ProductHasProductSearchTagPeer::DATABASE_NAME);

		$criteria->add(ProductHasProductSearchTagPeer::PRODUCT_ID, $this->product_id);
		$criteria->add(ProductHasProductSearchTagPeer::PRODUCT_SEARCH_TAG_ID, $this->product_search_tag_id);
		$criteria->add(ProductHasProductSearchTagPeer::CULTURE, $this->culture);

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

		$pks[0] = $this->getProductId();

		$pks[1] = $this->getProductSearchTagId();

		$pks[2] = $this->getCulture();

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

		$this->setProductId($keys[0]);

		$this->setProductSearchTagId($keys[1]);

		$this->setCulture($keys[2]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of ProductHasProductSearchTag (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTagValue($this->tag_value);


		$copyObj->setNew(true);

		$copyObj->setProductId(NULL); // this is a pkey column, so set to default value

		$copyObj->setProductSearchTagId(NULL); // this is a pkey column, so set to default value

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
	 * @return     ProductHasProductSearchTag Clone of current object.
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
	 * @return     ProductHasProductSearchTagPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ProductHasProductSearchTagPeer();
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
	 * Declares an association between this object and a ProductSearchTag object.
	 *
	 * @param      ProductSearchTag $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setProductSearchTag($v)
	{


		if ($v === null) {
			$this->setProductSearchTagId(NULL);
		} else {
			$this->setProductSearchTagId($v->getId());
		}


		$this->aProductSearchTag = $v;
	}


	/**
	 * Get the associated ProductSearchTag object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     ProductSearchTag The associated ProductSearchTag object.
	 * @throws     PropelException
	 */
	public function getProductSearchTag($con = null)
	{
		if ($this->aProductSearchTag === null && ($this->product_search_tag_id !== null)) {
			// include the related Peer class
			$this->aProductSearchTag = ProductSearchTagPeer::retrieveByPK($this->product_search_tag_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductSearchTagPeer::retrieveByPK($this->product_search_tag_id, $con);
			   $obj->addProductSearchTags($this);
			 */
		}
		return $this->aProductSearchTag;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'ProductHasProductSearchTag.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseProductHasProductSearchTag:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseProductHasProductSearchTag::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseProductHasProductSearchTag
