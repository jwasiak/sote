<?php

/**
 * Base class that represents a row from the 'st_questions' table.
 *
 * 
 *
 * @package    plugins.stQuestionPlugin.lib.model.om
 */
abstract class BaseQuestions extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        QuestionsPeer
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
	 * The value for the item_id field.
	 * @var        int
	 */
	protected $item_id;


	/**
	 * The value for the question_status_id field.
	 * @var        int
	 */
	protected $question_status_id;


	/**
	 * The value for the email field.
	 * @var        string
	 */
	protected $email;


	/**
	 * The value for the type field.
	 * @var        string
	 */
	protected $type;


	/**
	 * The value for the item_name field.
	 * @var        string
	 */
	protected $item_name;


	/**
	 * The value for the text field.
	 * @var        string
	 */
	protected $text;


	/**
	 * The value for the answer_text field.
	 * @var        string
	 */
	protected $answer_text;

	/**
	 * @var        Product
	 */
	protected $aProduct;

	/**
	 * @var        QuestionStatus
	 */
	protected $aQuestionStatus;

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
     * Get the [item_id] column value.
     * 
     * @return     int
     */
    public function getItemId()
    {

            return $this->item_id;
    }

    /**
     * Get the [question_status_id] column value.
     * 
     * @return     int
     */
    public function getQuestionStatusId()
    {

            return $this->question_status_id;
    }

    /**
     * Get the [email] column value.
     * 
     * @return     string
     */
    public function getEmail()
    {

            return $this->email;
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
     * Get the [item_name] column value.
     * 
     * @return     string
     */
    public function getItemName()
    {

            return $this->item_name;
    }

    /**
     * Get the [text] column value.
     * 
     * @return     string
     */
    public function getText()
    {

            return $this->text;
    }

    /**
     * Get the [answer_text] column value.
     * 
     * @return     string
     */
    public function getAnswerText()
    {

            return $this->answer_text;
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
			$this->modifiedColumns[] = QuestionsPeer::CREATED_AT;
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
			$this->modifiedColumns[] = QuestionsPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = QuestionsPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [item_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setItemId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->item_id !== $v) {
          $this->item_id = $v;
          $this->modifiedColumns[] = QuestionsPeer::ITEM_ID;
        }

		if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
			$this->aProduct = null;
		}

	} // setItemId()

	/**
	 * Set the value of [question_status_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setQuestionStatusId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->question_status_id !== $v) {
          $this->question_status_id = $v;
          $this->modifiedColumns[] = QuestionsPeer::QUESTION_STATUS_ID;
        }

		if ($this->aQuestionStatus !== null && $this->aQuestionStatus->getId() !== $v) {
			$this->aQuestionStatus = null;
		}

	} // setQuestionStatusId()

	/**
	 * Set the value of [email] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setEmail($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->email !== $v) {
          $this->email = $v;
          $this->modifiedColumns[] = QuestionsPeer::EMAIL;
        }

	} // setEmail()

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

        if ($this->type !== $v) {
          $this->type = $v;
          $this->modifiedColumns[] = QuestionsPeer::TYPE;
        }

	} // setType()

	/**
	 * Set the value of [item_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setItemName($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->item_name !== $v) {
          $this->item_name = $v;
          $this->modifiedColumns[] = QuestionsPeer::ITEM_NAME;
        }

	} // setItemName()

	/**
	 * Set the value of [text] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setText($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->text !== $v) {
          $this->text = $v;
          $this->modifiedColumns[] = QuestionsPeer::TEXT;
        }

	} // setText()

	/**
	 * Set the value of [answer_text] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setAnswerText($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->answer_text !== $v) {
          $this->answer_text = $v;
          $this->modifiedColumns[] = QuestionsPeer::ANSWER_TEXT;
        }

	} // setAnswerText()

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
      if ($this->getDispatcher()->getListeners('Questions.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Questions.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->item_id = $rs->getInt($startcol + 3);

      $this->question_status_id = $rs->getInt($startcol + 4);

      $this->email = $rs->getString($startcol + 5);

      $this->type = $rs->getString($startcol + 6);

      $this->item_name = $rs->getString($startcol + 7);

      $this->text = $rs->getString($startcol + 8);

      $this->answer_text = $rs->getString($startcol + 9);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Questions.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Questions.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 10)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 10; // 10 = QuestionsPeer::NUM_COLUMNS - QuestionsPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Questions object", $e);
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

    if ($this->getDispatcher()->getListeners('Questions.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Questions.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseQuestions:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseQuestions:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(QuestionsPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      QuestionsPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Questions.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Questions.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseQuestions:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseQuestions:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Questions.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Questions.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseQuestions:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(QuestionsPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(QuestionsPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(QuestionsPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Questions.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Questions.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseQuestions:save:post') as $callable)
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

			if ($this->aQuestionStatus !== null) {
				if ($this->aQuestionStatus->isModified() || $this->aQuestionStatus->getCurrentQuestionStatusI18n()->isModified()) {
					$affectedRows += $this->aQuestionStatus->save($con);
				}
				$this->setQuestionStatus($this->aQuestionStatus);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = QuestionsPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += QuestionsPeer::doUpdate($this, $con);
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

			if ($this->aQuestionStatus !== null) {
				if (!$this->aQuestionStatus->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aQuestionStatus->getValidationFailures());
				}
			}


			if (($retval = QuestionsPeer::doValidate($this, $columns)) !== true) {
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
		$pos = QuestionsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getItemId();
				break;
			case 4:
				return $this->getQuestionStatusId();
				break;
			case 5:
				return $this->getEmail();
				break;
			case 6:
				return $this->getType();
				break;
			case 7:
				return $this->getItemName();
				break;
			case 8:
				return $this->getText();
				break;
			case 9:
				return $this->getAnswerText();
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
		$keys = QuestionsPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getItemId(),
			$keys[4] => $this->getQuestionStatusId(),
			$keys[5] => $this->getEmail(),
			$keys[6] => $this->getType(),
			$keys[7] => $this->getItemName(),
			$keys[8] => $this->getText(),
			$keys[9] => $this->getAnswerText(),
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
		$pos = QuestionsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setItemId($value);
				break;
			case 4:
				$this->setQuestionStatusId($value);
				break;
			case 5:
				$this->setEmail($value);
				break;
			case 6:
				$this->setType($value);
				break;
			case 7:
				$this->setItemName($value);
				break;
			case 8:
				$this->setText($value);
				break;
			case 9:
				$this->setAnswerText($value);
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
		$keys = QuestionsPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setItemId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setQuestionStatusId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setEmail($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setType($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setItemName($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setText($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setAnswerText($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(QuestionsPeer::DATABASE_NAME);

		if ($this->isColumnModified(QuestionsPeer::CREATED_AT)) $criteria->add(QuestionsPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(QuestionsPeer::UPDATED_AT)) $criteria->add(QuestionsPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(QuestionsPeer::ID)) $criteria->add(QuestionsPeer::ID, $this->id);
		if ($this->isColumnModified(QuestionsPeer::ITEM_ID)) $criteria->add(QuestionsPeer::ITEM_ID, $this->item_id);
		if ($this->isColumnModified(QuestionsPeer::QUESTION_STATUS_ID)) $criteria->add(QuestionsPeer::QUESTION_STATUS_ID, $this->question_status_id);
		if ($this->isColumnModified(QuestionsPeer::EMAIL)) $criteria->add(QuestionsPeer::EMAIL, $this->email);
		if ($this->isColumnModified(QuestionsPeer::TYPE)) $criteria->add(QuestionsPeer::TYPE, $this->type);
		if ($this->isColumnModified(QuestionsPeer::ITEM_NAME)) $criteria->add(QuestionsPeer::ITEM_NAME, $this->item_name);
		if ($this->isColumnModified(QuestionsPeer::TEXT)) $criteria->add(QuestionsPeer::TEXT, $this->text);
		if ($this->isColumnModified(QuestionsPeer::ANSWER_TEXT)) $criteria->add(QuestionsPeer::ANSWER_TEXT, $this->answer_text);

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
		$criteria = new Criteria(QuestionsPeer::DATABASE_NAME);

		$criteria->add(QuestionsPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Questions (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setItemId($this->item_id);

		$copyObj->setQuestionStatusId($this->question_status_id);

		$copyObj->setEmail($this->email);

		$copyObj->setType($this->type);

		$copyObj->setItemName($this->item_name);

		$copyObj->setText($this->text);

		$copyObj->setAnswerText($this->answer_text);


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
	 * @return     Questions Clone of current object.
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
	 * @return     QuestionsPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new QuestionsPeer();
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
			$this->setItemId(NULL);
		} else {
			$this->setItemId($v->getId());
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
		if ($this->aProduct === null && ($this->item_id !== null)) {
			// include the related Peer class
			$this->aProduct = ProductPeer::retrieveByPK($this->item_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductPeer::retrieveByPK($this->item_id, $con);
			   $obj->addProducts($this);
			 */
		}
		return $this->aProduct;
	}

	/**
	 * Declares an association between this object and a QuestionStatus object.
	 *
	 * @param      QuestionStatus $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setQuestionStatus($v)
	{


		if ($v === null) {
			$this->setQuestionStatusId(NULL);
		} else {
			$this->setQuestionStatusId($v->getId());
		}


		$this->aQuestionStatus = $v;
	}


	/**
	 * Get the associated QuestionStatus object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     QuestionStatus The associated QuestionStatus object.
	 * @throws     PropelException
	 */
	public function getQuestionStatus($con = null)
	{
		if ($this->aQuestionStatus === null && ($this->question_status_id !== null)) {
			// include the related Peer class
			$this->aQuestionStatus = QuestionStatusPeer::retrieveByPK($this->question_status_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = QuestionStatusPeer::retrieveByPK($this->question_status_id, $con);
			   $obj->addQuestionStatuss($this);
			 */
		}
		return $this->aQuestionStatus;
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Questions.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseQuestions:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseQuestions::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseQuestions
