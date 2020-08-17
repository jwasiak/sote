<?php

/**
 * Base class that represents a row from the 'st_category' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseCategory extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        CategoryPeer
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
	 * The value for the opt_image field.
	 * @var        string
	 */
	protected $opt_image;


	/**
	 * The value for the lft field.
	 * @var        int
	 */
	protected $lft;


	/**
	 * The value for the rgt field.
	 * @var        int
	 */
	protected $rgt;


	/**
	 * The value for the scope field.
	 * @var        int
	 */
	protected $scope;


	/**
	 * The value for the main_page field.
	 * @var        boolean
	 */
	protected $main_page;


	/**
	 * The value for the parent_id field.
	 * @var        int
	 */
	protected $parent_id;


	/**
	 * The value for the sf_asset_id field.
	 * @var        int
	 */
	protected $sf_asset_id;


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
	 * The value for the opt_image_crop field.
	 * @var        string
	 */
	protected $opt_image_crop;


	/**
	 * The value for the depth field.
	 * @var        int
	 */
	protected $depth = 0;


	/**
	 * The value for the root_position field.
	 * @var        int
	 */
	protected $root_position;


	/**
	 * The value for the is_active field.
	 * @var        boolean
	 */
	protected $is_active = true;


	/**
	 * The value for the is_hidden field.
	 * @var        boolean
	 */
	protected $is_hidden = false;


	/**
	 * The value for the show_children_products field.
	 * @var        boolean
	 */
	protected $show_children_products = false;


	/**
	 * The value for the opt_url field.
	 * @var        string
	 */
	protected $opt_url;


	/**
	 * The value for the is_app_image_tag_active field.
	 * @var        boolean
	 */
	protected $is_app_image_tag_active = true;

	/**
	 * @var        Category
	 */
	protected $aCategoryRelatedByParentId;

	/**
	 * @var        sfAsset
	 */
	protected $asfAsset;

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
	 * Collection to store aggregation of collCategorysRelatedByParentId.
	 * @var        array
	 */
	protected $collCategorysRelatedByParentId;

	/**
	 * The criteria used to select the current contents of collCategorysRelatedByParentId.
	 * @var        Criteria
	 */
	protected $lastCategoryRelatedByParentIdCriteria = null;

	/**
	 * Collection to store aggregation of collCategoryI18ns.
	 * @var        array
	 */
	protected $collCategoryI18ns;

	/**
	 * The criteria used to select the current contents of collCategoryI18ns.
	 * @var        Criteria
	 */
	protected $lastCategoryI18nCriteria = null;

	/**
	 * Collection to store aggregation of collProductHasCategorys.
	 * @var        array
	 */
	protected $collProductHasCategorys;

	/**
	 * The criteria used to select the current contents of collProductHasCategorys.
	 * @var        Criteria
	 */
	protected $lastProductHasCategoryCriteria = null;

	/**
	 * Collection to store aggregation of collappCategoryImageTags.
	 * @var        array
	 */
	protected $collappCategoryImageTags;

	/**
	 * The criteria used to select the current contents of collappCategoryImageTags.
	 * @var        Criteria
	 */
	protected $lastappCategoryImageTagCriteria = null;

	/**
	 * Collection to store aggregation of collappCategoryImageTagGallerys.
	 * @var        array
	 */
	protected $collappCategoryImageTagGallerys;

	/**
	 * The criteria used to select the current contents of collappCategoryImageTagGallerys.
	 * @var        Criteria
	 */
	protected $lastappCategoryImageTagGalleryCriteria = null;

	/**
	 * Collection to store aggregation of collGiftCardHasCategorys.
	 * @var        array
	 */
	protected $collGiftCardHasCategorys;

	/**
	 * The criteria used to select the current contents of collGiftCardHasCategorys.
	 * @var        Criteria
	 */
	protected $lastGiftCardHasCategoryCriteria = null;

	/**
	 * Collection to store aggregation of collappProductAttributeHasCategorys.
	 * @var        array
	 */
	protected $collappProductAttributeHasCategorys;

	/**
	 * The criteria used to select the current contents of collappProductAttributeHasCategorys.
	 * @var        Criteria
	 */
	protected $lastappProductAttributeHasCategoryCriteria = null;

	/**
	 * Collection to store aggregation of collCategoryHasPositionings.
	 * @var        array
	 */
	protected $collCategoryHasPositionings;

	/**
	 * The criteria used to select the current contents of collCategoryHasPositionings.
	 * @var        Criteria
	 */
	protected $lastCategoryHasPositioningCriteria = null;

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
     * Get the [opt_image] column value.
     * 
     * @return     string
     */
    public function getOptImage()
    {

            return $this->opt_image;
    }

    /**
     * Get the [lft] column value.
     * 
     * @return     int
     */
    public function getLft()
    {

            return $this->lft;
    }

    /**
     * Get the [rgt] column value.
     * 
     * @return     int
     */
    public function getRgt()
    {

            return $this->rgt;
    }

    /**
     * Get the [scope] column value.
     * 
     * @return     int
     */
    public function getScope()
    {

            return $this->scope;
    }

    /**
     * Get the [main_page] column value.
     * 
     * @return     boolean
     */
    public function getMainPage()
    {

            return $this->main_page;
    }

    /**
     * Get the [parent_id] column value.
     * 
     * @return     int
     */
    public function getParentId()
    {

            return $this->parent_id;
    }

    /**
     * Get the [sf_asset_id] column value.
     * 
     * @return     int
     */
    public function getSfAssetId()
    {

            return $this->sf_asset_id;
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
     * Get the [opt_image_crop] column value.
     * 
     * @return     string
     */
    public function getImageCrop()
    {

            return $this->opt_image_crop;
    }

    /**
     * Get the [depth] column value.
     * 
     * @return     int
     */
    public function getDepth()
    {

            return $this->depth;
    }

    /**
     * Get the [root_position] column value.
     * 
     * @return     int
     */
    public function getRootPosition()
    {

            return $this->root_position;
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
     * Get the [is_hidden] column value.
     * 
     * @return     boolean
     */
    public function getIsHidden()
    {

            return $this->is_hidden;
    }

    /**
     * Get the [show_children_products] column value.
     * 
     * @return     boolean
     */
    public function getShowChildrenProducts()
    {

            return $this->show_children_products;
    }

    /**
     * Get the [opt_url] column value.
     * 
     * @return     string
     */
    public function getOptUrl()
    {

            return $this->opt_url;
    }

    /**
     * Get the [is_app_image_tag_active] column value.
     * 
     * @return     boolean
     */
    public function getIsAppImageTagActive()
    {

            return $this->is_app_image_tag_active;
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
			$this->modifiedColumns[] = CategoryPeer::CREATED_AT;
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
			$this->modifiedColumns[] = CategoryPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = CategoryPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [opt_image] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptImage($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_image !== $v) {
          $this->opt_image = $v;
          $this->modifiedColumns[] = CategoryPeer::OPT_IMAGE;
        }

	} // setOptImage()

	/**
	 * Set the value of [lft] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setLft($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->lft !== $v) {
          $this->lft = $v;
          $this->modifiedColumns[] = CategoryPeer::LFT;
        }

	} // setLft()

	/**
	 * Set the value of [rgt] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setRgt($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->rgt !== $v) {
          $this->rgt = $v;
          $this->modifiedColumns[] = CategoryPeer::RGT;
        }

	} // setRgt()

	/**
	 * Set the value of [scope] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setScope($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->scope !== $v) {
          $this->scope = $v;
          $this->modifiedColumns[] = CategoryPeer::SCOPE;
        }

	} // setScope()

	/**
	 * Set the value of [main_page] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setMainPage($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->main_page !== $v) {
          $this->main_page = $v;
          $this->modifiedColumns[] = CategoryPeer::MAIN_PAGE;
        }

	} // setMainPage()

	/**
	 * Set the value of [parent_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setParentId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->parent_id !== $v) {
          $this->parent_id = $v;
          $this->modifiedColumns[] = CategoryPeer::PARENT_ID;
        }

		if ($this->aCategoryRelatedByParentId !== null && $this->aCategoryRelatedByParentId->getId() !== $v) {
			$this->aCategoryRelatedByParentId = null;
		}

	} // setParentId()

	/**
	 * Set the value of [sf_asset_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setSfAssetId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->sf_asset_id !== $v) {
          $this->sf_asset_id = $v;
          $this->modifiedColumns[] = CategoryPeer::SF_ASSET_ID;
        }

		if ($this->asfAsset !== null && $this->asfAsset->getId() !== $v) {
			$this->asfAsset = null;
		}

	} // setSfAssetId()

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
          $this->modifiedColumns[] = CategoryPeer::OPT_NAME;
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
          $this->modifiedColumns[] = CategoryPeer::OPT_DESCRIPTION;
        }

	} // setOptDescription()

	/**
	 * Set the value of [opt_image_crop] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setImageCrop($v)
	{

        if ($this->opt_image_crop !== $v) {
          $this->opt_image_crop = $v;
          $this->modifiedColumns[] = CategoryPeer::OPT_IMAGE_CROP;
        }

	} // setImageCrop()

	/**
	 * Set the value of [depth] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setDepth($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->depth !== $v || $v === 0) {
          $this->depth = $v;
          $this->modifiedColumns[] = CategoryPeer::DEPTH;
        }

	} // setDepth()

	/**
	 * Set the value of [root_position] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setRootPosition($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->root_position !== $v) {
          $this->root_position = $v;
          $this->modifiedColumns[] = CategoryPeer::ROOT_POSITION;
        }

	} // setRootPosition()

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
          $this->modifiedColumns[] = CategoryPeer::IS_ACTIVE;
        }

	} // setIsActive()

	/**
	 * Set the value of [is_hidden] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsHidden($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_hidden !== $v || $v === false) {
          $this->is_hidden = $v;
          $this->modifiedColumns[] = CategoryPeer::IS_HIDDEN;
        }

	} // setIsHidden()

	/**
	 * Set the value of [show_children_products] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setShowChildrenProducts($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->show_children_products !== $v || $v === false) {
          $this->show_children_products = $v;
          $this->modifiedColumns[] = CategoryPeer::SHOW_CHILDREN_PRODUCTS;
        }

	} // setShowChildrenProducts()

	/**
	 * Set the value of [opt_url] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptUrl($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_url !== $v) {
          $this->opt_url = $v;
          $this->modifiedColumns[] = CategoryPeer::OPT_URL;
        }

	} // setOptUrl()

	/**
	 * Set the value of [is_app_image_tag_active] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsAppImageTagActive($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_app_image_tag_active !== $v || $v === true) {
          $this->is_app_image_tag_active = $v;
          $this->modifiedColumns[] = CategoryPeer::IS_APP_IMAGE_TAG_ACTIVE;
        }

	} // setIsAppImageTagActive()

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
      if ($this->getDispatcher()->getListeners('Category.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Category.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->opt_image = $rs->getString($startcol + 3);

      $this->lft = $rs->getInt($startcol + 4);

      $this->rgt = $rs->getInt($startcol + 5);

      $this->scope = $rs->getInt($startcol + 6);

      $this->main_page = $rs->getBoolean($startcol + 7);

      $this->parent_id = $rs->getInt($startcol + 8);

      $this->sf_asset_id = $rs->getInt($startcol + 9);

      $this->opt_name = $rs->getString($startcol + 10);

      $this->opt_description = $rs->getString($startcol + 11);

      $this->opt_image_crop = $rs->getString($startcol + 12) ? unserialize($rs->getString($startcol + 12)) : null;

      $this->depth = $rs->getInt($startcol + 13);

      $this->root_position = $rs->getInt($startcol + 14);

      $this->is_active = $rs->getBoolean($startcol + 15);

      $this->is_hidden = $rs->getBoolean($startcol + 16);

      $this->show_children_products = $rs->getBoolean($startcol + 17);

      $this->opt_url = $rs->getString($startcol + 18);

      $this->is_app_image_tag_active = $rs->getBoolean($startcol + 19);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Category.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Category.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 20)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 20; // 20 = CategoryPeer::NUM_COLUMNS - CategoryPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Category object", $e);
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

    if ($this->getDispatcher()->getListeners('Category.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Category.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseCategory:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseCategory:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(CategoryPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      CategoryPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Category.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Category.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseCategory:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseCategory:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Category.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Category.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseCategory:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(CategoryPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(CategoryPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(CategoryPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Category.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Category.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseCategory:save:post') as $callable)
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

			if ($this->aCategoryRelatedByParentId !== null) {
				if ($this->aCategoryRelatedByParentId->isModified() || $this->aCategoryRelatedByParentId->getCurrentCategoryI18n()->isModified()) {
					$affectedRows += $this->aCategoryRelatedByParentId->save($con);
				}
				$this->setCategoryRelatedByParentId($this->aCategoryRelatedByParentId);
			}

			if ($this->asfAsset !== null) {
				if ($this->asfAsset->isModified() || $this->asfAsset->getCurrentsfAssetI18n()->isModified()) {
					$affectedRows += $this->asfAsset->save($con);
				}
				$this->setsfAsset($this->asfAsset);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
              $o_opt_image_crop = $this->opt_image_crop;
              if (null !== $this->opt_image_crop && $this->isColumnModified(CategoryPeer::OPT_IMAGE_CROP)) {
                  $this->opt_image_crop = serialize($this->opt_image_crop);
              }

				if ($this->isNew()) {
					$pk = CategoryPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += CategoryPeer::doUpdate($this, $con);
				}
				$this->resetModified();
             $this->opt_image_crop = $o_opt_image_crop;
 // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collDiscountHasCategorys !== null) {
				foreach($this->collDiscountHasCategorys as $referrerFK) {
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

			if ($this->collCategorysRelatedByParentId !== null) {
				foreach($this->collCategorysRelatedByParentId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collCategoryI18ns !== null) {
				foreach($this->collCategoryI18ns as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductHasCategorys !== null) {
				foreach($this->collProductHasCategorys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collappCategoryImageTags !== null) {
				foreach($this->collappCategoryImageTags as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collappCategoryImageTagGallerys !== null) {
				foreach($this->collappCategoryImageTagGallerys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGiftCardHasCategorys !== null) {
				foreach($this->collGiftCardHasCategorys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collappProductAttributeHasCategorys !== null) {
				foreach($this->collappProductAttributeHasCategorys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collCategoryHasPositionings !== null) {
				foreach($this->collCategoryHasPositionings as $referrerFK) {
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

			if ($this->aCategoryRelatedByParentId !== null) {
				if (!$this->aCategoryRelatedByParentId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCategoryRelatedByParentId->getValidationFailures());
				}
			}

			if ($this->asfAsset !== null) {
				if (!$this->asfAsset->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfAsset->getValidationFailures());
				}
			}


			if (($retval = CategoryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collDiscountHasCategorys !== null) {
					foreach($this->collDiscountHasCategorys as $referrerFK) {
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

				if ($this->collCategoryI18ns !== null) {
					foreach($this->collCategoryI18ns as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductHasCategorys !== null) {
					foreach($this->collProductHasCategorys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collappCategoryImageTags !== null) {
					foreach($this->collappCategoryImageTags as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collappCategoryImageTagGallerys !== null) {
					foreach($this->collappCategoryImageTagGallerys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGiftCardHasCategorys !== null) {
					foreach($this->collGiftCardHasCategorys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collappProductAttributeHasCategorys !== null) {
					foreach($this->collappProductAttributeHasCategorys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collCategoryHasPositionings !== null) {
					foreach($this->collCategoryHasPositionings as $referrerFK) {
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
		$pos = CategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getOptImage();
				break;
			case 4:
				return $this->getLft();
				break;
			case 5:
				return $this->getRgt();
				break;
			case 6:
				return $this->getScope();
				break;
			case 7:
				return $this->getMainPage();
				break;
			case 8:
				return $this->getParentId();
				break;
			case 9:
				return $this->getSfAssetId();
				break;
			case 10:
				return $this->getOptName();
				break;
			case 11:
				return $this->getOptDescription();
				break;
			case 12:
				return $this->getImageCrop();
				break;
			case 13:
				return $this->getDepth();
				break;
			case 14:
				return $this->getRootPosition();
				break;
			case 15:
				return $this->getIsActive();
				break;
			case 16:
				return $this->getIsHidden();
				break;
			case 17:
				return $this->getShowChildrenProducts();
				break;
			case 18:
				return $this->getOptUrl();
				break;
			case 19:
				return $this->getIsAppImageTagActive();
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
		$keys = CategoryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getOptImage(),
			$keys[4] => $this->getLft(),
			$keys[5] => $this->getRgt(),
			$keys[6] => $this->getScope(),
			$keys[7] => $this->getMainPage(),
			$keys[8] => $this->getParentId(),
			$keys[9] => $this->getSfAssetId(),
			$keys[10] => $this->getOptName(),
			$keys[11] => $this->getOptDescription(),
			$keys[12] => $this->getImageCrop(),
			$keys[13] => $this->getDepth(),
			$keys[14] => $this->getRootPosition(),
			$keys[15] => $this->getIsActive(),
			$keys[16] => $this->getIsHidden(),
			$keys[17] => $this->getShowChildrenProducts(),
			$keys[18] => $this->getOptUrl(),
			$keys[19] => $this->getIsAppImageTagActive(),
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
		$pos = CategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setOptImage($value);
				break;
			case 4:
				$this->setLft($value);
				break;
			case 5:
				$this->setRgt($value);
				break;
			case 6:
				$this->setScope($value);
				break;
			case 7:
				$this->setMainPage($value);
				break;
			case 8:
				$this->setParentId($value);
				break;
			case 9:
				$this->setSfAssetId($value);
				break;
			case 10:
				$this->setOptName($value);
				break;
			case 11:
				$this->setOptDescription($value);
				break;
			case 12:
				$this->setImageCrop($value);
				break;
			case 13:
				$this->setDepth($value);
				break;
			case 14:
				$this->setRootPosition($value);
				break;
			case 15:
				$this->setIsActive($value);
				break;
			case 16:
				$this->setIsHidden($value);
				break;
			case 17:
				$this->setShowChildrenProducts($value);
				break;
			case 18:
				$this->setOptUrl($value);
				break;
			case 19:
				$this->setIsAppImageTagActive($value);
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
		$keys = CategoryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setOptImage($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setLft($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setRgt($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setScope($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setMainPage($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setParentId($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setSfAssetId($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setOptName($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setOptDescription($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setImageCrop($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setDepth($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setRootPosition($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setIsActive($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setIsHidden($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setShowChildrenProducts($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setOptUrl($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setIsAppImageTagActive($arr[$keys[19]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(CategoryPeer::DATABASE_NAME);

		if ($this->isColumnModified(CategoryPeer::CREATED_AT)) $criteria->add(CategoryPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(CategoryPeer::UPDATED_AT)) $criteria->add(CategoryPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(CategoryPeer::ID)) $criteria->add(CategoryPeer::ID, $this->id);
		if ($this->isColumnModified(CategoryPeer::OPT_IMAGE)) $criteria->add(CategoryPeer::OPT_IMAGE, $this->opt_image);
		if ($this->isColumnModified(CategoryPeer::LFT)) $criteria->add(CategoryPeer::LFT, $this->lft);
		if ($this->isColumnModified(CategoryPeer::RGT)) $criteria->add(CategoryPeer::RGT, $this->rgt);
		if ($this->isColumnModified(CategoryPeer::SCOPE)) $criteria->add(CategoryPeer::SCOPE, $this->scope);
		if ($this->isColumnModified(CategoryPeer::MAIN_PAGE)) $criteria->add(CategoryPeer::MAIN_PAGE, $this->main_page);
		if ($this->isColumnModified(CategoryPeer::PARENT_ID)) $criteria->add(CategoryPeer::PARENT_ID, $this->parent_id);
		if ($this->isColumnModified(CategoryPeer::SF_ASSET_ID)) $criteria->add(CategoryPeer::SF_ASSET_ID, $this->sf_asset_id);
		if ($this->isColumnModified(CategoryPeer::OPT_NAME)) $criteria->add(CategoryPeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(CategoryPeer::OPT_DESCRIPTION)) $criteria->add(CategoryPeer::OPT_DESCRIPTION, $this->opt_description);
		if ($this->isColumnModified(CategoryPeer::OPT_IMAGE_CROP)) $criteria->add(CategoryPeer::OPT_IMAGE_CROP, $this->opt_image_crop);
		if ($this->isColumnModified(CategoryPeer::DEPTH)) $criteria->add(CategoryPeer::DEPTH, $this->depth);
		if ($this->isColumnModified(CategoryPeer::ROOT_POSITION)) $criteria->add(CategoryPeer::ROOT_POSITION, $this->root_position);
		if ($this->isColumnModified(CategoryPeer::IS_ACTIVE)) $criteria->add(CategoryPeer::IS_ACTIVE, $this->is_active);
		if ($this->isColumnModified(CategoryPeer::IS_HIDDEN)) $criteria->add(CategoryPeer::IS_HIDDEN, $this->is_hidden);
		if ($this->isColumnModified(CategoryPeer::SHOW_CHILDREN_PRODUCTS)) $criteria->add(CategoryPeer::SHOW_CHILDREN_PRODUCTS, $this->show_children_products);
		if ($this->isColumnModified(CategoryPeer::OPT_URL)) $criteria->add(CategoryPeer::OPT_URL, $this->opt_url);
		if ($this->isColumnModified(CategoryPeer::IS_APP_IMAGE_TAG_ACTIVE)) $criteria->add(CategoryPeer::IS_APP_IMAGE_TAG_ACTIVE, $this->is_app_image_tag_active);

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
		$criteria = new Criteria(CategoryPeer::DATABASE_NAME);

		$criteria->add(CategoryPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Category (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setOptImage($this->opt_image);

		$copyObj->setLft($this->lft);

		$copyObj->setRgt($this->rgt);

		$copyObj->setScope($this->scope);

		$copyObj->setMainPage($this->main_page);

		$copyObj->setParentId($this->parent_id);

		$copyObj->setSfAssetId($this->sf_asset_id);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setOptDescription($this->opt_description);

		$copyObj->setImageCrop($this->opt_image_crop);

		$copyObj->setDepth($this->depth);

		$copyObj->setRootPosition($this->root_position);

		$copyObj->setIsActive($this->is_active);

		$copyObj->setIsHidden($this->is_hidden);

		$copyObj->setShowChildrenProducts($this->show_children_products);

		$copyObj->setOptUrl($this->opt_url);

		$copyObj->setIsAppImageTagActive($this->is_app_image_tag_active);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getDiscountHasCategorys() as $relObj) {
				$copyObj->addDiscountHasCategory($relObj->copy($deepCopy));
			}

			foreach($this->getDiscountCouponCodeHasCategorys() as $relObj) {
				$copyObj->addDiscountCouponCodeHasCategory($relObj->copy($deepCopy));
			}

			foreach($this->getCategorysRelatedByParentId() as $relObj) {
				if($this->getPrimaryKey() === $relObj->getPrimaryKey()) {
						continue;
				}

				$copyObj->addCategoryRelatedByParentId($relObj->copy($deepCopy));
			}

			foreach($this->getCategoryI18ns() as $relObj) {
				$copyObj->addCategoryI18n($relObj->copy($deepCopy));
			}

			foreach($this->getProductHasCategorys() as $relObj) {
				$copyObj->addProductHasCategory($relObj->copy($deepCopy));
			}

			foreach($this->getappCategoryImageTags() as $relObj) {
				$copyObj->addappCategoryImageTag($relObj->copy($deepCopy));
			}

			foreach($this->getappCategoryImageTagGallerys() as $relObj) {
				$copyObj->addappCategoryImageTagGallery($relObj->copy($deepCopy));
			}

			foreach($this->getGiftCardHasCategorys() as $relObj) {
				$copyObj->addGiftCardHasCategory($relObj->copy($deepCopy));
			}

			foreach($this->getappProductAttributeHasCategorys() as $relObj) {
				$copyObj->addappProductAttributeHasCategory($relObj->copy($deepCopy));
			}

			foreach($this->getCategoryHasPositionings() as $relObj) {
				$copyObj->addCategoryHasPositioning($relObj->copy($deepCopy));
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
	 * @return     Category Clone of current object.
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
	 * @return     CategoryPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new CategoryPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Category object.
	 *
	 * @param      Category $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setCategoryRelatedByParentId($v)
	{


		if ($v === null) {
			$this->setParentId(NULL);
		} else {
			$this->setParentId($v->getId());
		}


		$this->aCategoryRelatedByParentId = $v;
	}


	/**
	 * Get the associated Category object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Category The associated Category object.
	 * @throws     PropelException
	 */
	public function getCategoryRelatedByParentId($con = null)
	{
		if ($this->aCategoryRelatedByParentId === null && ($this->parent_id !== null)) {
			// include the related Peer class
			$this->aCategoryRelatedByParentId = CategoryPeer::retrieveByPK($this->parent_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = CategoryPeer::retrieveByPK($this->parent_id, $con);
			   $obj->addCategorysRelatedByParentId($this);
			 */
		}
		return $this->aCategoryRelatedByParentId;
	}

	/**
	 * Declares an association between this object and a sfAsset object.
	 *
	 * @param      sfAsset $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setsfAsset($v)
	{


		if ($v === null) {
			$this->setSfAssetId(NULL);
		} else {
			$this->setSfAssetId($v->getId());
		}


		$this->asfAsset = $v;
	}


	/**
	 * Get the associated sfAsset object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     sfAsset The associated sfAsset object.
	 * @throws     PropelException
	 */
	public function getsfAsset($con = null)
	{
		if ($this->asfAsset === null && ($this->sf_asset_id !== null)) {
			// include the related Peer class
			$this->asfAsset = sfAssetPeer::retrieveByPK($this->sf_asset_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = sfAssetPeer::retrieveByPK($this->sf_asset_id, $con);
			   $obj->addsfAssets($this);
			 */
		}
		return $this->asfAsset;
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
	 * Otherwise if this Category has previously
	 * been saved, it will retrieve related DiscountHasCategorys from storage.
	 * If this Category is new, it will return
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

				$criteria->add(DiscountHasCategoryPeer::CATEGORY_ID, $this->getId());

				DiscountHasCategoryPeer::addSelectColumns($criteria);
				$this->collDiscountHasCategorys = DiscountHasCategoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountHasCategoryPeer::CATEGORY_ID, $this->getId());

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

		$criteria->add(DiscountHasCategoryPeer::CATEGORY_ID, $this->getId());

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
		$l->setCategory($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Category is new, it will return
	 * an empty collection; or if this Category has previously
	 * been saved, it will retrieve related DiscountHasCategorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Category.
	 */
	public function getDiscountHasCategorysJoinDiscount($criteria = null, $con = null)
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

				$criteria->add(DiscountHasCategoryPeer::CATEGORY_ID, $this->getId());

				$this->collDiscountHasCategorys = DiscountHasCategoryPeer::doSelectJoinDiscount($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DiscountHasCategoryPeer::CATEGORY_ID, $this->getId());

			if (!isset($this->lastDiscountHasCategoryCriteria) || !$this->lastDiscountHasCategoryCriteria->equals($criteria)) {
				$this->collDiscountHasCategorys = DiscountHasCategoryPeer::doSelectJoinDiscount($criteria, $con);
			}
		}
		$this->lastDiscountHasCategoryCriteria = $criteria;

		return $this->collDiscountHasCategorys;
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
	 * Otherwise if this Category has previously
	 * been saved, it will retrieve related DiscountCouponCodeHasCategorys from storage.
	 * If this Category is new, it will return
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

				$criteria->add(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, $this->getId());

				DiscountCouponCodeHasCategoryPeer::addSelectColumns($criteria);
				$this->collDiscountCouponCodeHasCategorys = DiscountCouponCodeHasCategoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, $this->getId());

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

		$criteria->add(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, $this->getId());

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
		$l->setCategory($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Category is new, it will return
	 * an empty collection; or if this Category has previously
	 * been saved, it will retrieve related DiscountCouponCodeHasCategorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Category.
	 */
	public function getDiscountCouponCodeHasCategorysJoinDiscountCouponCode($criteria = null, $con = null)
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

				$criteria->add(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, $this->getId());

				$this->collDiscountCouponCodeHasCategorys = DiscountCouponCodeHasCategoryPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DiscountCouponCodeHasCategoryPeer::CATEGORY_ID, $this->getId());

			if (!isset($this->lastDiscountCouponCodeHasCategoryCriteria) || !$this->lastDiscountCouponCodeHasCategoryCriteria->equals($criteria)) {
				$this->collDiscountCouponCodeHasCategorys = DiscountCouponCodeHasCategoryPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		}
		$this->lastDiscountCouponCodeHasCategoryCriteria = $criteria;

		return $this->collDiscountCouponCodeHasCategorys;
	}

	/**
	 * Temporary storage of collCategorysRelatedByParentId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initCategorysRelatedByParentId()
	{
		if ($this->collCategorysRelatedByParentId === null) {
			$this->collCategorysRelatedByParentId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Category has previously
	 * been saved, it will retrieve related CategorysRelatedByParentId from storage.
	 * If this Category is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getCategorysRelatedByParentId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCategorysRelatedByParentId === null) {
			if ($this->isNew()) {
			   $this->collCategorysRelatedByParentId = array();
			} else {

				$criteria->add(CategoryPeer::PARENT_ID, $this->getId());

				CategoryPeer::addSelectColumns($criteria);
				$this->collCategorysRelatedByParentId = CategoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(CategoryPeer::PARENT_ID, $this->getId());

				CategoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastCategoryRelatedByParentIdCriteria) || !$this->lastCategoryRelatedByParentIdCriteria->equals($criteria)) {
					$this->collCategorysRelatedByParentId = CategoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCategoryRelatedByParentIdCriteria = $criteria;
		return $this->collCategorysRelatedByParentId;
	}

	/**
	 * Returns the number of related CategorysRelatedByParentId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countCategorysRelatedByParentId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CategoryPeer::PARENT_ID, $this->getId());

		return CategoryPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Category object to this object
	 * through the Category foreign key attribute
	 *
	 * @param      Category $l Category
	 * @return     void
	 * @throws     PropelException
	 */
	public function addCategoryRelatedByParentId(Category $l)
	{
		$this->collCategorysRelatedByParentId[] = $l;
		$l->setCategoryRelatedByParentId($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Category is new, it will return
	 * an empty collection; or if this Category has previously
	 * been saved, it will retrieve related CategorysRelatedByParentId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Category.
	 */
	public function getCategorysRelatedByParentIdJoinsfAsset($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCategorysRelatedByParentId === null) {
			if ($this->isNew()) {
				$this->collCategorysRelatedByParentId = array();
			} else {

				$criteria->add(CategoryPeer::PARENT_ID, $this->getId());

				$this->collCategorysRelatedByParentId = CategoryPeer::doSelectJoinsfAsset($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(CategoryPeer::PARENT_ID, $this->getId());

			if (!isset($this->lastCategoryRelatedByParentIdCriteria) || !$this->lastCategoryRelatedByParentIdCriteria->equals($criteria)) {
				$this->collCategorysRelatedByParentId = CategoryPeer::doSelectJoinsfAsset($criteria, $con);
			}
		}
		$this->lastCategoryRelatedByParentIdCriteria = $criteria;

		return $this->collCategorysRelatedByParentId;
	}

	/**
	 * Temporary storage of collCategoryI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initCategoryI18ns()
	{
		if ($this->collCategoryI18ns === null) {
			$this->collCategoryI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Category has previously
	 * been saved, it will retrieve related CategoryI18ns from storage.
	 * If this Category is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getCategoryI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCategoryI18ns === null) {
			if ($this->isNew()) {
			   $this->collCategoryI18ns = array();
			} else {

				$criteria->add(CategoryI18nPeer::ID, $this->getId());

				CategoryI18nPeer::addSelectColumns($criteria);
				$this->collCategoryI18ns = CategoryI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(CategoryI18nPeer::ID, $this->getId());

				CategoryI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastCategoryI18nCriteria) || !$this->lastCategoryI18nCriteria->equals($criteria)) {
					$this->collCategoryI18ns = CategoryI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCategoryI18nCriteria = $criteria;
		return $this->collCategoryI18ns;
	}

	/**
	 * Returns the number of related CategoryI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countCategoryI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CategoryI18nPeer::ID, $this->getId());

		return CategoryI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a CategoryI18n object to this object
	 * through the CategoryI18n foreign key attribute
	 *
	 * @param      CategoryI18n $l CategoryI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addCategoryI18n(CategoryI18n $l)
	{
		$this->collCategoryI18ns[] = $l;
		$l->setCategory($this);
	}

	/**
	 * Temporary storage of collProductHasCategorys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductHasCategorys()
	{
		if ($this->collProductHasCategorys === null) {
			$this->collProductHasCategorys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Category has previously
	 * been saved, it will retrieve related ProductHasCategorys from storage.
	 * If this Category is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductHasCategorys($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasCategorys === null) {
			if ($this->isNew()) {
			   $this->collProductHasCategorys = array();
			} else {

				$criteria->add(ProductHasCategoryPeer::CATEGORY_ID, $this->getId());

				ProductHasCategoryPeer::addSelectColumns($criteria);
				$this->collProductHasCategorys = ProductHasCategoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasCategoryPeer::CATEGORY_ID, $this->getId());

				ProductHasCategoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductHasCategoryCriteria) || !$this->lastProductHasCategoryCriteria->equals($criteria)) {
					$this->collProductHasCategorys = ProductHasCategoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductHasCategoryCriteria = $criteria;
		return $this->collProductHasCategorys;
	}

	/**
	 * Returns the number of related ProductHasCategorys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductHasCategorys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductHasCategoryPeer::CATEGORY_ID, $this->getId());

		return ProductHasCategoryPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductHasCategory object to this object
	 * through the ProductHasCategory foreign key attribute
	 *
	 * @param      ProductHasCategory $l ProductHasCategory
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductHasCategory(ProductHasCategory $l)
	{
		$this->collProductHasCategorys[] = $l;
		$l->setCategory($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Category is new, it will return
	 * an empty collection; or if this Category has previously
	 * been saved, it will retrieve related ProductHasCategorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Category.
	 */
	public function getProductHasCategorysJoinProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasCategorys === null) {
			if ($this->isNew()) {
				$this->collProductHasCategorys = array();
			} else {

				$criteria->add(ProductHasCategoryPeer::CATEGORY_ID, $this->getId());

				$this->collProductHasCategorys = ProductHasCategoryPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductHasCategoryPeer::CATEGORY_ID, $this->getId());

			if (!isset($this->lastProductHasCategoryCriteria) || !$this->lastProductHasCategoryCriteria->equals($criteria)) {
				$this->collProductHasCategorys = ProductHasCategoryPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastProductHasCategoryCriteria = $criteria;

		return $this->collProductHasCategorys;
	}

	/**
	 * Temporary storage of collappCategoryImageTags to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initappCategoryImageTags()
	{
		if ($this->collappCategoryImageTags === null) {
			$this->collappCategoryImageTags = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Category has previously
	 * been saved, it will retrieve related appCategoryImageTags from storage.
	 * If this Category is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getappCategoryImageTags($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collappCategoryImageTags === null) {
			if ($this->isNew()) {
			   $this->collappCategoryImageTags = array();
			} else {

				$criteria->add(appCategoryImageTagPeer::ID, $this->getId());

				appCategoryImageTagPeer::addSelectColumns($criteria);
				$this->collappCategoryImageTags = appCategoryImageTagPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(appCategoryImageTagPeer::ID, $this->getId());

				appCategoryImageTagPeer::addSelectColumns($criteria);
				if (!isset($this->lastappCategoryImageTagCriteria) || !$this->lastappCategoryImageTagCriteria->equals($criteria)) {
					$this->collappCategoryImageTags = appCategoryImageTagPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastappCategoryImageTagCriteria = $criteria;
		return $this->collappCategoryImageTags;
	}

	/**
	 * Returns the number of related appCategoryImageTags.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countappCategoryImageTags($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(appCategoryImageTagPeer::ID, $this->getId());

		return appCategoryImageTagPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a appCategoryImageTag object to this object
	 * through the appCategoryImageTag foreign key attribute
	 *
	 * @param      appCategoryImageTag $l appCategoryImageTag
	 * @return     void
	 * @throws     PropelException
	 */
	public function addappCategoryImageTag(appCategoryImageTag $l)
	{
		$this->collappCategoryImageTags[] = $l;
		$l->setCategory($this);
	}

	/**
	 * Temporary storage of collappCategoryImageTagGallerys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initappCategoryImageTagGallerys()
	{
		if ($this->collappCategoryImageTagGallerys === null) {
			$this->collappCategoryImageTagGallerys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Category has previously
	 * been saved, it will retrieve related appCategoryImageTagGallerys from storage.
	 * If this Category is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getappCategoryImageTagGallerys($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collappCategoryImageTagGallerys === null) {
			if ($this->isNew()) {
			   $this->collappCategoryImageTagGallerys = array();
			} else {

				$criteria->add(appCategoryImageTagGalleryPeer::CATEGORY_ID, $this->getId());

				appCategoryImageTagGalleryPeer::addSelectColumns($criteria);
				$this->collappCategoryImageTagGallerys = appCategoryImageTagGalleryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(appCategoryImageTagGalleryPeer::CATEGORY_ID, $this->getId());

				appCategoryImageTagGalleryPeer::addSelectColumns($criteria);
				if (!isset($this->lastappCategoryImageTagGalleryCriteria) || !$this->lastappCategoryImageTagGalleryCriteria->equals($criteria)) {
					$this->collappCategoryImageTagGallerys = appCategoryImageTagGalleryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastappCategoryImageTagGalleryCriteria = $criteria;
		return $this->collappCategoryImageTagGallerys;
	}

	/**
	 * Returns the number of related appCategoryImageTagGallerys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countappCategoryImageTagGallerys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(appCategoryImageTagGalleryPeer::CATEGORY_ID, $this->getId());

		return appCategoryImageTagGalleryPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a appCategoryImageTagGallery object to this object
	 * through the appCategoryImageTagGallery foreign key attribute
	 *
	 * @param      appCategoryImageTagGallery $l appCategoryImageTagGallery
	 * @return     void
	 * @throws     PropelException
	 */
	public function addappCategoryImageTagGallery(appCategoryImageTagGallery $l)
	{
		$this->collappCategoryImageTagGallerys[] = $l;
		$l->setCategory($this);
	}

	/**
	 * Temporary storage of collGiftCardHasCategorys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initGiftCardHasCategorys()
	{
		if ($this->collGiftCardHasCategorys === null) {
			$this->collGiftCardHasCategorys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Category has previously
	 * been saved, it will retrieve related GiftCardHasCategorys from storage.
	 * If this Category is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getGiftCardHasCategorys($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGiftCardHasCategorys === null) {
			if ($this->isNew()) {
			   $this->collGiftCardHasCategorys = array();
			} else {

				$criteria->add(GiftCardHasCategoryPeer::CATEGORY_ID, $this->getId());

				GiftCardHasCategoryPeer::addSelectColumns($criteria);
				$this->collGiftCardHasCategorys = GiftCardHasCategoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GiftCardHasCategoryPeer::CATEGORY_ID, $this->getId());

				GiftCardHasCategoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastGiftCardHasCategoryCriteria) || !$this->lastGiftCardHasCategoryCriteria->equals($criteria)) {
					$this->collGiftCardHasCategorys = GiftCardHasCategoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGiftCardHasCategoryCriteria = $criteria;
		return $this->collGiftCardHasCategorys;
	}

	/**
	 * Returns the number of related GiftCardHasCategorys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countGiftCardHasCategorys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(GiftCardHasCategoryPeer::CATEGORY_ID, $this->getId());

		return GiftCardHasCategoryPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a GiftCardHasCategory object to this object
	 * through the GiftCardHasCategory foreign key attribute
	 *
	 * @param      GiftCardHasCategory $l GiftCardHasCategory
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGiftCardHasCategory(GiftCardHasCategory $l)
	{
		$this->collGiftCardHasCategorys[] = $l;
		$l->setCategory($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Category is new, it will return
	 * an empty collection; or if this Category has previously
	 * been saved, it will retrieve related GiftCardHasCategorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Category.
	 */
	public function getGiftCardHasCategorysJoinGiftCard($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGiftCardHasCategorys === null) {
			if ($this->isNew()) {
				$this->collGiftCardHasCategorys = array();
			} else {

				$criteria->add(GiftCardHasCategoryPeer::CATEGORY_ID, $this->getId());

				$this->collGiftCardHasCategorys = GiftCardHasCategoryPeer::doSelectJoinGiftCard($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(GiftCardHasCategoryPeer::CATEGORY_ID, $this->getId());

			if (!isset($this->lastGiftCardHasCategoryCriteria) || !$this->lastGiftCardHasCategoryCriteria->equals($criteria)) {
				$this->collGiftCardHasCategorys = GiftCardHasCategoryPeer::doSelectJoinGiftCard($criteria, $con);
			}
		}
		$this->lastGiftCardHasCategoryCriteria = $criteria;

		return $this->collGiftCardHasCategorys;
	}

	/**
	 * Temporary storage of collappProductAttributeHasCategorys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initappProductAttributeHasCategorys()
	{
		if ($this->collappProductAttributeHasCategorys === null) {
			$this->collappProductAttributeHasCategorys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Category has previously
	 * been saved, it will retrieve related appProductAttributeHasCategorys from storage.
	 * If this Category is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getappProductAttributeHasCategorys($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collappProductAttributeHasCategorys === null) {
			if ($this->isNew()) {
			   $this->collappProductAttributeHasCategorys = array();
			} else {

				$criteria->add(appProductAttributeHasCategoryPeer::CATEGORY_ID, $this->getId());

				appProductAttributeHasCategoryPeer::addSelectColumns($criteria);
				$this->collappProductAttributeHasCategorys = appProductAttributeHasCategoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(appProductAttributeHasCategoryPeer::CATEGORY_ID, $this->getId());

				appProductAttributeHasCategoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastappProductAttributeHasCategoryCriteria) || !$this->lastappProductAttributeHasCategoryCriteria->equals($criteria)) {
					$this->collappProductAttributeHasCategorys = appProductAttributeHasCategoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastappProductAttributeHasCategoryCriteria = $criteria;
		return $this->collappProductAttributeHasCategorys;
	}

	/**
	 * Returns the number of related appProductAttributeHasCategorys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countappProductAttributeHasCategorys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(appProductAttributeHasCategoryPeer::CATEGORY_ID, $this->getId());

		return appProductAttributeHasCategoryPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a appProductAttributeHasCategory object to this object
	 * through the appProductAttributeHasCategory foreign key attribute
	 *
	 * @param      appProductAttributeHasCategory $l appProductAttributeHasCategory
	 * @return     void
	 * @throws     PropelException
	 */
	public function addappProductAttributeHasCategory(appProductAttributeHasCategory $l)
	{
		$this->collappProductAttributeHasCategorys[] = $l;
		$l->setCategory($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Category is new, it will return
	 * an empty collection; or if this Category has previously
	 * been saved, it will retrieve related appProductAttributeHasCategorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Category.
	 */
	public function getappProductAttributeHasCategorysJoinappProductAttribute($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collappProductAttributeHasCategorys === null) {
			if ($this->isNew()) {
				$this->collappProductAttributeHasCategorys = array();
			} else {

				$criteria->add(appProductAttributeHasCategoryPeer::CATEGORY_ID, $this->getId());

				$this->collappProductAttributeHasCategorys = appProductAttributeHasCategoryPeer::doSelectJoinappProductAttribute($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(appProductAttributeHasCategoryPeer::CATEGORY_ID, $this->getId());

			if (!isset($this->lastappProductAttributeHasCategoryCriteria) || !$this->lastappProductAttributeHasCategoryCriteria->equals($criteria)) {
				$this->collappProductAttributeHasCategorys = appProductAttributeHasCategoryPeer::doSelectJoinappProductAttribute($criteria, $con);
			}
		}
		$this->lastappProductAttributeHasCategoryCriteria = $criteria;

		return $this->collappProductAttributeHasCategorys;
	}

	/**
	 * Temporary storage of collCategoryHasPositionings to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initCategoryHasPositionings()
	{
		if ($this->collCategoryHasPositionings === null) {
			$this->collCategoryHasPositionings = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Category has previously
	 * been saved, it will retrieve related CategoryHasPositionings from storage.
	 * If this Category is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getCategoryHasPositionings($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCategoryHasPositionings === null) {
			if ($this->isNew()) {
			   $this->collCategoryHasPositionings = array();
			} else {

				$criteria->add(CategoryHasPositioningPeer::CATEGORY_ID, $this->getId());

				CategoryHasPositioningPeer::addSelectColumns($criteria);
				$this->collCategoryHasPositionings = CategoryHasPositioningPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(CategoryHasPositioningPeer::CATEGORY_ID, $this->getId());

				CategoryHasPositioningPeer::addSelectColumns($criteria);
				if (!isset($this->lastCategoryHasPositioningCriteria) || !$this->lastCategoryHasPositioningCriteria->equals($criteria)) {
					$this->collCategoryHasPositionings = CategoryHasPositioningPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCategoryHasPositioningCriteria = $criteria;
		return $this->collCategoryHasPositionings;
	}

	/**
	 * Returns the number of related CategoryHasPositionings.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countCategoryHasPositionings($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CategoryHasPositioningPeer::CATEGORY_ID, $this->getId());

		return CategoryHasPositioningPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a CategoryHasPositioning object to this object
	 * through the CategoryHasPositioning foreign key attribute
	 *
	 * @param      CategoryHasPositioning $l CategoryHasPositioning
	 * @return     void
	 * @throws     PropelException
	 */
	public function addCategoryHasPositioning(CategoryHasPositioning $l)
	{
		$this->collCategoryHasPositionings[] = $l;
		$l->setCategory($this);
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
    $obj = $this->getCurrentCategoryI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentCategoryI18n()->setName($value);
  }

  public function getUrl()
  {
    $obj = $this->getCurrentCategoryI18n();

    return ($obj ? $obj->getUrl() : null);
  }

  public function setUrl($value)
  {
    $this->getCurrentCategoryI18n()->setUrl($value);
  }

  public function getDescription()
  {
    $obj = $this->getCurrentCategoryI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentCategoryI18n()->setDescription($value);
  }

  public $current_i18n = array();

  public function getCurrentCategoryI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = CategoryI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setCategoryI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setCategoryI18nForCulture(new CategoryI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setCategoryI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addCategoryI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Category.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseCategory:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseCategory::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseCategory
