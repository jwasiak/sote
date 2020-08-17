<?php

/**
 * Base class that represents a row from the 'st_delivery' table.
 *
 * 
 *
 * @package    plugins.stDeliveryPlugin.lib.model.om
 */
abstract class BaseDelivery extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        DeliveryPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the countries_area_id field.
	 * @var        int
	 */
	protected $countries_area_id;


	/**
	 * The value for the tax_id field.
	 * @var        int
	 */
	protected $tax_id;


	/**
	 * The value for the type_id field.
	 * @var        int
	 */
	protected $type_id;


	/**
	 * The value for the free_delivery field.
	 * @var        double
	 */
	protected $free_delivery = 0;


	/**
	 * The value for the active field.
	 * @var        boolean
	 */
	protected $active;


	/**
	 * The value for the allow_in_selected_products field.
	 * @var        boolean
	 */
	protected $allow_in_selected_products = false;


	/**
	 * The value for the default_cost field.
	 * @var        double
	 */
	protected $default_cost = 0;


	/**
	 * The value for the default_cost_brutto field.
	 * @var        double
	 */
	protected $default_cost_brutto;


	/**
	 * The value for the width field.
	 * @var        int
	 */
	protected $width = 0;


	/**
	 * The value for the height field.
	 * @var        int
	 */
	protected $height = 0;


	/**
	 * The value for the depth field.
	 * @var        int
	 */
	protected $depth = 0;


	/**
	 * The value for the volume field.
	 * @var        int
	 */
	protected $volume = 0;


	/**
	 * The value for the is_system_default field.
	 * @var        boolean
	 */
	protected $is_system_default = false;


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
	 * The value for the is_default field.
	 * @var        boolean
	 */
	protected $is_default = false;


	/**
	 * The value for the section_cost_type field.
	 * @var        string
	 */
	protected $section_cost_type;


	/**
	 * The value for the max_order_weight field.
	 * @var        double
	 */
	protected $max_order_weight = 0;


	/**
	 * The value for the max_order_amount field.
	 * @var        double
	 */
	protected $max_order_amount = 0;


	/**
	 * The value for the max_order_quantity field.
	 * @var        int
	 */
	protected $max_order_quantity = 0;


	/**
	 * The value for the min_order_weight field.
	 * @var        double
	 */
	protected $min_order_weight = 0;


	/**
	 * The value for the min_order_amount field.
	 * @var        double
	 */
	protected $min_order_amount = 0;


	/**
	 * The value for the min_order_quantity field.
	 * @var        int
	 */
	protected $min_order_quantity = 0;


	/**
	 * The value for the position field.
	 * @var        int
	 */
	protected $position = 0;


	/**
	 * The value for the params field.
	 * @var        string
	 */
	protected $params;


	/**
	 * The value for the paczkomaty_type field.
	 * @var        string
	 */
	protected $paczkomaty_type;


	/**
	 * The value for the paczkomaty_size field.
	 * @var        string
	 */
	protected $paczkomaty_size;

	/**
	 * @var        CountriesArea
	 */
	protected $aCountriesArea;

	/**
	 * @var        Tax
	 */
	protected $aTax;

	/**
	 * @var        DeliveryType
	 */
	protected $aDeliveryType;

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
	 * Collection to store aggregation of collDeliverySectionss.
	 * @var        array
	 */
	protected $collDeliverySectionss;

	/**
	 * The criteria used to select the current contents of collDeliverySectionss.
	 * @var        Criteria
	 */
	protected $lastDeliverySectionsCriteria = null;

	/**
	 * Collection to store aggregation of collDeliveryHasPaymentTypes.
	 * @var        array
	 */
	protected $collDeliveryHasPaymentTypes;

	/**
	 * The criteria used to select the current contents of collDeliveryHasPaymentTypes.
	 * @var        Criteria
	 */
	protected $lastDeliveryHasPaymentTypeCriteria = null;

	/**
	 * Collection to store aggregation of collDeliveryI18ns.
	 * @var        array
	 */
	protected $collDeliveryI18ns;

	/**
	 * The criteria used to select the current contents of collDeliveryI18ns.
	 * @var        Criteria
	 */
	protected $lastDeliveryI18nCriteria = null;

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
     * Get the [id] column value.
     * 
     * @return     int
     */
    public function getId()
    {

            return $this->id;
    }

    /**
     * Get the [countries_area_id] column value.
     * 
     * @return     int
     */
    public function getCountriesAreaId()
    {

            return $this->countries_area_id;
    }

    /**
     * Get the [tax_id] column value.
     * 
     * @return     int
     */
    public function getTaxId()
    {

            return $this->tax_id;
    }

    /**
     * Get the [type_id] column value.
     * 
     * @return     int
     */
    public function getTypeId()
    {

            return $this->type_id;
    }

    /**
     * Get the [free_delivery] column value.
     * 
     * @return     double
     */
    public function getFreeDelivery()
    {

            return null !== $this->free_delivery ? (string)$this->free_delivery : null;
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
     * Get the [allow_in_selected_products] column value.
     * 
     * @return     boolean
     */
    public function getAllowInSelectedProducts()
    {

            return $this->allow_in_selected_products;
    }

    /**
     * Get the [default_cost] column value.
     * 
     * @return     double
     */
    public function getDefaultCost()
    {

            return null !== $this->default_cost ? (string)$this->default_cost : null;
    }

    /**
     * Get the [default_cost_brutto] column value.
     * 
     * @return     double
     */
    public function getDefaultCostBrutto()
    {

            return null !== $this->default_cost_brutto ? (string)$this->default_cost_brutto : null;
    }

    /**
     * Get the [width] column value.
     * 
     * @return     int
     */
    public function getWidth()
    {

            return $this->width;
    }

    /**
     * Get the [height] column value.
     * 
     * @return     int
     */
    public function getHeight()
    {

            return $this->height;
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
     * Get the [volume] column value.
     * 
     * @return     int
     */
    public function getVolume()
    {

            return $this->volume;
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
     * Get the [is_default] column value.
     * 
     * @return     boolean
     */
    public function getIsDefault()
    {

            return $this->is_default;
    }

    /**
     * Get the [section_cost_type] column value.
     * 
     * @return     string
     */
    public function getSectionCostType()
    {

            return $this->section_cost_type;
    }

    /**
     * Get the [max_order_weight] column value.
     * 
     * @return     double
     */
    public function getMaxOrderWeight()
    {

            return null !== $this->max_order_weight ? (string)$this->max_order_weight : null;
    }

    /**
     * Get the [max_order_amount] column value.
     * 
     * @return     double
     */
    public function getMaxOrderAmount()
    {

            return null !== $this->max_order_amount ? (string)$this->max_order_amount : null;
    }

    /**
     * Get the [max_order_quantity] column value.
     * 
     * @return     int
     */
    public function getMaxOrderQuantity()
    {

            return $this->max_order_quantity;
    }

    /**
     * Get the [min_order_weight] column value.
     * 
     * @return     double
     */
    public function getMinOrderWeight()
    {

            return null !== $this->min_order_weight ? (string)$this->min_order_weight : null;
    }

    /**
     * Get the [min_order_amount] column value.
     * 
     * @return     double
     */
    public function getMinOrderAmount()
    {

            return null !== $this->min_order_amount ? (string)$this->min_order_amount : null;
    }

    /**
     * Get the [min_order_quantity] column value.
     * 
     * @return     int
     */
    public function getMinOrderQuantity()
    {

            return $this->min_order_quantity;
    }

    /**
     * Get the [position] column value.
     * 
     * @return     int
     */
    public function getPosition()
    {

            return $this->position;
    }

    /**
     * Get the [params] column value.
     * 
     * @return     string
     */
    public function getParams()
    {

            return $this->params;
    }

    /**
     * Get the [paczkomaty_type] column value.
     * 
     * @return     string
     */
    public function getPaczkomatyType()
    {

            return $this->paczkomaty_type;
    }

    /**
     * Get the [paczkomaty_size] column value.
     * 
     * @return     string
     */
    public function getPaczkomatySize()
    {

            return $this->paczkomaty_size;
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
          $this->modifiedColumns[] = DeliveryPeer::ID;
        }

	} // setId()

	/**
	 * Set the value of [countries_area_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCountriesAreaId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->countries_area_id !== $v) {
          $this->countries_area_id = $v;
          $this->modifiedColumns[] = DeliveryPeer::COUNTRIES_AREA_ID;
        }

		if ($this->aCountriesArea !== null && $this->aCountriesArea->getId() !== $v) {
			$this->aCountriesArea = null;
		}

	} // setCountriesAreaId()

	/**
	 * Set the value of [tax_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setTaxId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->tax_id !== $v) {
          $this->tax_id = $v;
          $this->modifiedColumns[] = DeliveryPeer::TAX_ID;
        }

		if ($this->aTax !== null && $this->aTax->getId() !== $v) {
			$this->aTax = null;
		}

	} // setTaxId()

	/**
	 * Set the value of [type_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setTypeId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->type_id !== $v) {
          $this->type_id = $v;
          $this->modifiedColumns[] = DeliveryPeer::TYPE_ID;
        }

		if ($this->aDeliveryType !== null && $this->aDeliveryType->getId() !== $v) {
			$this->aDeliveryType = null;
		}

	} // setTypeId()

	/**
	 * Set the value of [free_delivery] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setFreeDelivery($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->free_delivery !== $v || $v === 0) {
          $this->free_delivery = $v;
          $this->modifiedColumns[] = DeliveryPeer::FREE_DELIVERY;
        }

	} // setFreeDelivery()

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

        if ($this->active !== $v) {
          $this->active = $v;
          $this->modifiedColumns[] = DeliveryPeer::ACTIVE;
        }

	} // setActive()

	/**
	 * Set the value of [allow_in_selected_products] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setAllowInSelectedProducts($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->allow_in_selected_products !== $v || $v === false) {
          $this->allow_in_selected_products = $v;
          $this->modifiedColumns[] = DeliveryPeer::ALLOW_IN_SELECTED_PRODUCTS;
        }

	} // setAllowInSelectedProducts()

	/**
	 * Set the value of [default_cost] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setDefaultCost($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->default_cost !== $v || $v === 0) {
          $this->default_cost = $v;
          $this->modifiedColumns[] = DeliveryPeer::DEFAULT_COST;
        }

	} // setDefaultCost()

	/**
	 * Set the value of [default_cost_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setDefaultCostBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->default_cost_brutto !== $v) {
          $this->default_cost_brutto = $v;
          $this->modifiedColumns[] = DeliveryPeer::DEFAULT_COST_BRUTTO;
        }

	} // setDefaultCostBrutto()

	/**
	 * Set the value of [width] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setWidth($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->width !== $v || $v === 0) {
          $this->width = $v;
          $this->modifiedColumns[] = DeliveryPeer::WIDTH;
        }

	} // setWidth()

	/**
	 * Set the value of [height] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setHeight($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->height !== $v || $v === 0) {
          $this->height = $v;
          $this->modifiedColumns[] = DeliveryPeer::HEIGHT;
        }

	} // setHeight()

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
          $this->modifiedColumns[] = DeliveryPeer::DEPTH;
        }

	} // setDepth()

	/**
	 * Set the value of [volume] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setVolume($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->volume !== $v || $v === 0) {
          $this->volume = $v;
          $this->modifiedColumns[] = DeliveryPeer::VOLUME;
        }

	} // setVolume()

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
          $this->modifiedColumns[] = DeliveryPeer::IS_SYSTEM_DEFAULT;
        }

	} // setIsSystemDefault()

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
          $this->modifiedColumns[] = DeliveryPeer::OPT_NAME;
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
          $this->modifiedColumns[] = DeliveryPeer::OPT_DESCRIPTION;
        }

	} // setOptDescription()

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
          $this->modifiedColumns[] = DeliveryPeer::IS_DEFAULT;
        }

	} // setIsDefault()

	/**
	 * Set the value of [section_cost_type] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setSectionCostType($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->section_cost_type !== $v) {
          $this->section_cost_type = $v;
          $this->modifiedColumns[] = DeliveryPeer::SECTION_COST_TYPE;
        }

	} // setSectionCostType()

	/**
	 * Set the value of [max_order_weight] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setMaxOrderWeight($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->max_order_weight !== $v || $v === 0) {
          $this->max_order_weight = $v;
          $this->modifiedColumns[] = DeliveryPeer::MAX_ORDER_WEIGHT;
        }

	} // setMaxOrderWeight()

	/**
	 * Set the value of [max_order_amount] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setMaxOrderAmount($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->max_order_amount !== $v || $v === 0) {
          $this->max_order_amount = $v;
          $this->modifiedColumns[] = DeliveryPeer::MAX_ORDER_AMOUNT;
        }

	} // setMaxOrderAmount()

	/**
	 * Set the value of [max_order_quantity] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setMaxOrderQuantity($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->max_order_quantity !== $v || $v === 0) {
          $this->max_order_quantity = $v;
          $this->modifiedColumns[] = DeliveryPeer::MAX_ORDER_QUANTITY;
        }

	} // setMaxOrderQuantity()

	/**
	 * Set the value of [min_order_weight] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setMinOrderWeight($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->min_order_weight !== $v || $v === 0) {
          $this->min_order_weight = $v;
          $this->modifiedColumns[] = DeliveryPeer::MIN_ORDER_WEIGHT;
        }

	} // setMinOrderWeight()

	/**
	 * Set the value of [min_order_amount] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setMinOrderAmount($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->min_order_amount !== $v || $v === 0) {
          $this->min_order_amount = $v;
          $this->modifiedColumns[] = DeliveryPeer::MIN_ORDER_AMOUNT;
        }

	} // setMinOrderAmount()

	/**
	 * Set the value of [min_order_quantity] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setMinOrderQuantity($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->min_order_quantity !== $v || $v === 0) {
          $this->min_order_quantity = $v;
          $this->modifiedColumns[] = DeliveryPeer::MIN_ORDER_QUANTITY;
        }

	} // setMinOrderQuantity()

	/**
	 * Set the value of [position] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPosition($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->position !== $v || $v === 0) {
          $this->position = $v;
          $this->modifiedColumns[] = DeliveryPeer::POSITION;
        }

	} // setPosition()

	/**
	 * Set the value of [params] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setParams($v)
	{

        if ($this->params !== $v) {
          $this->params = $v;
          $this->modifiedColumns[] = DeliveryPeer::PARAMS;
        }

	} // setParams()

	/**
	 * Set the value of [paczkomaty_type] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPaczkomatyType($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->paczkomaty_type !== $v) {
          $this->paczkomaty_type = $v;
          $this->modifiedColumns[] = DeliveryPeer::PACZKOMATY_TYPE;
        }

	} // setPaczkomatyType()

	/**
	 * Set the value of [paczkomaty_size] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPaczkomatySize($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->paczkomaty_size !== $v) {
          $this->paczkomaty_size = $v;
          $this->modifiedColumns[] = DeliveryPeer::PACZKOMATY_SIZE;
        }

	} // setPaczkomatySize()

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
      if ($this->getDispatcher()->getListeners('Delivery.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Delivery.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->id = $rs->getInt($startcol + 0);

      $this->countries_area_id = $rs->getInt($startcol + 1);

      $this->tax_id = $rs->getInt($startcol + 2);

      $this->type_id = $rs->getInt($startcol + 3);

      $this->free_delivery = $rs->getString($startcol + 4);
      if (null !== $this->free_delivery && $this->free_delivery == intval($this->free_delivery))
      {
        $this->free_delivery = (string)intval($this->free_delivery);
      }

      $this->active = $rs->getBoolean($startcol + 5);

      $this->allow_in_selected_products = $rs->getBoolean($startcol + 6);

      $this->default_cost = $rs->getString($startcol + 7);
      if (null !== $this->default_cost && $this->default_cost == intval($this->default_cost))
      {
        $this->default_cost = (string)intval($this->default_cost);
      }

      $this->default_cost_brutto = $rs->getString($startcol + 8);
      if (null !== $this->default_cost_brutto && $this->default_cost_brutto == intval($this->default_cost_brutto))
      {
        $this->default_cost_brutto = (string)intval($this->default_cost_brutto);
      }

      $this->width = $rs->getInt($startcol + 9);

      $this->height = $rs->getInt($startcol + 10);

      $this->depth = $rs->getInt($startcol + 11);

      $this->volume = $rs->getInt($startcol + 12);

      $this->is_system_default = $rs->getBoolean($startcol + 13);

      $this->opt_name = $rs->getString($startcol + 14);

      $this->opt_description = $rs->getString($startcol + 15);

      $this->is_default = $rs->getBoolean($startcol + 16);

      $this->section_cost_type = $rs->getString($startcol + 17);

      $this->max_order_weight = $rs->getString($startcol + 18);
      if (null !== $this->max_order_weight && $this->max_order_weight == intval($this->max_order_weight))
      {
        $this->max_order_weight = (string)intval($this->max_order_weight);
      }

      $this->max_order_amount = $rs->getString($startcol + 19);
      if (null !== $this->max_order_amount && $this->max_order_amount == intval($this->max_order_amount))
      {
        $this->max_order_amount = (string)intval($this->max_order_amount);
      }

      $this->max_order_quantity = $rs->getInt($startcol + 20);

      $this->min_order_weight = $rs->getString($startcol + 21);
      if (null !== $this->min_order_weight && $this->min_order_weight == intval($this->min_order_weight))
      {
        $this->min_order_weight = (string)intval($this->min_order_weight);
      }

      $this->min_order_amount = $rs->getString($startcol + 22);
      if (null !== $this->min_order_amount && $this->min_order_amount == intval($this->min_order_amount))
      {
        $this->min_order_amount = (string)intval($this->min_order_amount);
      }

      $this->min_order_quantity = $rs->getInt($startcol + 23);

      $this->position = $rs->getInt($startcol + 24);

      $this->params = $rs->getString($startcol + 25) ? unserialize($rs->getString($startcol + 25)) : null;

      $this->paczkomaty_type = $rs->getString($startcol + 26);

      $this->paczkomaty_size = $rs->getString($startcol + 27);

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Delivery.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Delivery.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 28)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 28; // 28 = DeliveryPeer::NUM_COLUMNS - DeliveryPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Delivery object", $e);
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

    if ($this->getDispatcher()->getListeners('Delivery.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Delivery.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseDelivery:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseDelivery:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(DeliveryPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      DeliveryPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Delivery.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Delivery.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseDelivery:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseDelivery:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Delivery.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Delivery.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseDelivery:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    

    if ($con === null) {
      $con = Propel::getConnection(DeliveryPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Delivery.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Delivery.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseDelivery:save:post') as $callable)
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

			if ($this->aCountriesArea !== null) {
				if ($this->aCountriesArea->isModified()) {
					$affectedRows += $this->aCountriesArea->save($con);
				}
				$this->setCountriesArea($this->aCountriesArea);
			}

			if ($this->aTax !== null) {
				if ($this->aTax->isModified()) {
					$affectedRows += $this->aTax->save($con);
				}
				$this->setTax($this->aTax);
			}

			if ($this->aDeliveryType !== null) {
				if ($this->aDeliveryType->isModified()) {
					$affectedRows += $this->aDeliveryType->save($con);
				}
				$this->setDeliveryType($this->aDeliveryType);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
              $o_params = $this->params;
              if (null !== $this->params && $this->isColumnModified(DeliveryPeer::PARAMS)) {
                  $this->params = serialize($this->params);
              }

				if ($this->isNew()) {
					$pk = DeliveryPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += DeliveryPeer::doUpdate($this, $con);
				}
				$this->resetModified();
             $this->params = $o_params;
 // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collOrderDeliverys !== null) {
				foreach($this->collOrderDeliverys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDeliverySectionss !== null) {
				foreach($this->collDeliverySectionss as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDeliveryHasPaymentTypes !== null) {
				foreach($this->collDeliveryHasPaymentTypes as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDeliveryI18ns !== null) {
				foreach($this->collDeliveryI18ns as $referrerFK) {
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

			if ($this->aCountriesArea !== null) {
				if (!$this->aCountriesArea->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCountriesArea->getValidationFailures());
				}
			}

			if ($this->aTax !== null) {
				if (!$this->aTax->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTax->getValidationFailures());
				}
			}

			if ($this->aDeliveryType !== null) {
				if (!$this->aDeliveryType->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDeliveryType->getValidationFailures());
				}
			}


			if (($retval = DeliveryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOrderDeliverys !== null) {
					foreach($this->collOrderDeliverys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDeliverySectionss !== null) {
					foreach($this->collDeliverySectionss as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDeliveryHasPaymentTypes !== null) {
					foreach($this->collDeliveryHasPaymentTypes as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDeliveryI18ns !== null) {
					foreach($this->collDeliveryI18ns as $referrerFK) {
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
		$pos = DeliveryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCountriesAreaId();
				break;
			case 2:
				return $this->getTaxId();
				break;
			case 3:
				return $this->getTypeId();
				break;
			case 4:
				return $this->getFreeDelivery();
				break;
			case 5:
				return $this->getActive();
				break;
			case 6:
				return $this->getAllowInSelectedProducts();
				break;
			case 7:
				return $this->getDefaultCost();
				break;
			case 8:
				return $this->getDefaultCostBrutto();
				break;
			case 9:
				return $this->getWidth();
				break;
			case 10:
				return $this->getHeight();
				break;
			case 11:
				return $this->getDepth();
				break;
			case 12:
				return $this->getVolume();
				break;
			case 13:
				return $this->getIsSystemDefault();
				break;
			case 14:
				return $this->getOptName();
				break;
			case 15:
				return $this->getOptDescription();
				break;
			case 16:
				return $this->getIsDefault();
				break;
			case 17:
				return $this->getSectionCostType();
				break;
			case 18:
				return $this->getMaxOrderWeight();
				break;
			case 19:
				return $this->getMaxOrderAmount();
				break;
			case 20:
				return $this->getMaxOrderQuantity();
				break;
			case 21:
				return $this->getMinOrderWeight();
				break;
			case 22:
				return $this->getMinOrderAmount();
				break;
			case 23:
				return $this->getMinOrderQuantity();
				break;
			case 24:
				return $this->getPosition();
				break;
			case 25:
				return $this->getParams();
				break;
			case 26:
				return $this->getPaczkomatyType();
				break;
			case 27:
				return $this->getPaczkomatySize();
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
		$keys = DeliveryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCountriesAreaId(),
			$keys[2] => $this->getTaxId(),
			$keys[3] => $this->getTypeId(),
			$keys[4] => $this->getFreeDelivery(),
			$keys[5] => $this->getActive(),
			$keys[6] => $this->getAllowInSelectedProducts(),
			$keys[7] => $this->getDefaultCost(),
			$keys[8] => $this->getDefaultCostBrutto(),
			$keys[9] => $this->getWidth(),
			$keys[10] => $this->getHeight(),
			$keys[11] => $this->getDepth(),
			$keys[12] => $this->getVolume(),
			$keys[13] => $this->getIsSystemDefault(),
			$keys[14] => $this->getOptName(),
			$keys[15] => $this->getOptDescription(),
			$keys[16] => $this->getIsDefault(),
			$keys[17] => $this->getSectionCostType(),
			$keys[18] => $this->getMaxOrderWeight(),
			$keys[19] => $this->getMaxOrderAmount(),
			$keys[20] => $this->getMaxOrderQuantity(),
			$keys[21] => $this->getMinOrderWeight(),
			$keys[22] => $this->getMinOrderAmount(),
			$keys[23] => $this->getMinOrderQuantity(),
			$keys[24] => $this->getPosition(),
			$keys[25] => $this->getParams(),
			$keys[26] => $this->getPaczkomatyType(),
			$keys[27] => $this->getPaczkomatySize(),
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
		$pos = DeliveryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setCountriesAreaId($value);
				break;
			case 2:
				$this->setTaxId($value);
				break;
			case 3:
				$this->setTypeId($value);
				break;
			case 4:
				$this->setFreeDelivery($value);
				break;
			case 5:
				$this->setActive($value);
				break;
			case 6:
				$this->setAllowInSelectedProducts($value);
				break;
			case 7:
				$this->setDefaultCost($value);
				break;
			case 8:
				$this->setDefaultCostBrutto($value);
				break;
			case 9:
				$this->setWidth($value);
				break;
			case 10:
				$this->setHeight($value);
				break;
			case 11:
				$this->setDepth($value);
				break;
			case 12:
				$this->setVolume($value);
				break;
			case 13:
				$this->setIsSystemDefault($value);
				break;
			case 14:
				$this->setOptName($value);
				break;
			case 15:
				$this->setOptDescription($value);
				break;
			case 16:
				$this->setIsDefault($value);
				break;
			case 17:
				$this->setSectionCostType($value);
				break;
			case 18:
				$this->setMaxOrderWeight($value);
				break;
			case 19:
				$this->setMaxOrderAmount($value);
				break;
			case 20:
				$this->setMaxOrderQuantity($value);
				break;
			case 21:
				$this->setMinOrderWeight($value);
				break;
			case 22:
				$this->setMinOrderAmount($value);
				break;
			case 23:
				$this->setMinOrderQuantity($value);
				break;
			case 24:
				$this->setPosition($value);
				break;
			case 25:
				$this->setParams($value);
				break;
			case 26:
				$this->setPaczkomatyType($value);
				break;
			case 27:
				$this->setPaczkomatySize($value);
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
		$keys = DeliveryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCountriesAreaId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTaxId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTypeId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setFreeDelivery($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setActive($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setAllowInSelectedProducts($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setDefaultCost($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setDefaultCostBrutto($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setWidth($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setHeight($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setDepth($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setVolume($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setIsSystemDefault($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setOptName($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setOptDescription($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setIsDefault($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setSectionCostType($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setMaxOrderWeight($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setMaxOrderAmount($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setMaxOrderQuantity($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setMinOrderWeight($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setMinOrderAmount($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setMinOrderQuantity($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setPosition($arr[$keys[24]]);
		if (array_key_exists($keys[25], $arr)) $this->setParams($arr[$keys[25]]);
		if (array_key_exists($keys[26], $arr)) $this->setPaczkomatyType($arr[$keys[26]]);
		if (array_key_exists($keys[27], $arr)) $this->setPaczkomatySize($arr[$keys[27]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(DeliveryPeer::DATABASE_NAME);

		if ($this->isColumnModified(DeliveryPeer::ID)) $criteria->add(DeliveryPeer::ID, $this->id);
		if ($this->isColumnModified(DeliveryPeer::COUNTRIES_AREA_ID)) $criteria->add(DeliveryPeer::COUNTRIES_AREA_ID, $this->countries_area_id);
		if ($this->isColumnModified(DeliveryPeer::TAX_ID)) $criteria->add(DeliveryPeer::TAX_ID, $this->tax_id);
		if ($this->isColumnModified(DeliveryPeer::TYPE_ID)) $criteria->add(DeliveryPeer::TYPE_ID, $this->type_id);
		if ($this->isColumnModified(DeliveryPeer::FREE_DELIVERY)) $criteria->add(DeliveryPeer::FREE_DELIVERY, $this->free_delivery);
		if ($this->isColumnModified(DeliveryPeer::ACTIVE)) $criteria->add(DeliveryPeer::ACTIVE, $this->active);
		if ($this->isColumnModified(DeliveryPeer::ALLOW_IN_SELECTED_PRODUCTS)) $criteria->add(DeliveryPeer::ALLOW_IN_SELECTED_PRODUCTS, $this->allow_in_selected_products);
		if ($this->isColumnModified(DeliveryPeer::DEFAULT_COST)) $criteria->add(DeliveryPeer::DEFAULT_COST, $this->default_cost);
		if ($this->isColumnModified(DeliveryPeer::DEFAULT_COST_BRUTTO)) $criteria->add(DeliveryPeer::DEFAULT_COST_BRUTTO, $this->default_cost_brutto);
		if ($this->isColumnModified(DeliveryPeer::WIDTH)) $criteria->add(DeliveryPeer::WIDTH, $this->width);
		if ($this->isColumnModified(DeliveryPeer::HEIGHT)) $criteria->add(DeliveryPeer::HEIGHT, $this->height);
		if ($this->isColumnModified(DeliveryPeer::DEPTH)) $criteria->add(DeliveryPeer::DEPTH, $this->depth);
		if ($this->isColumnModified(DeliveryPeer::VOLUME)) $criteria->add(DeliveryPeer::VOLUME, $this->volume);
		if ($this->isColumnModified(DeliveryPeer::IS_SYSTEM_DEFAULT)) $criteria->add(DeliveryPeer::IS_SYSTEM_DEFAULT, $this->is_system_default);
		if ($this->isColumnModified(DeliveryPeer::OPT_NAME)) $criteria->add(DeliveryPeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(DeliveryPeer::OPT_DESCRIPTION)) $criteria->add(DeliveryPeer::OPT_DESCRIPTION, $this->opt_description);
		if ($this->isColumnModified(DeliveryPeer::IS_DEFAULT)) $criteria->add(DeliveryPeer::IS_DEFAULT, $this->is_default);
		if ($this->isColumnModified(DeliveryPeer::SECTION_COST_TYPE)) $criteria->add(DeliveryPeer::SECTION_COST_TYPE, $this->section_cost_type);
		if ($this->isColumnModified(DeliveryPeer::MAX_ORDER_WEIGHT)) $criteria->add(DeliveryPeer::MAX_ORDER_WEIGHT, $this->max_order_weight);
		if ($this->isColumnModified(DeliveryPeer::MAX_ORDER_AMOUNT)) $criteria->add(DeliveryPeer::MAX_ORDER_AMOUNT, $this->max_order_amount);
		if ($this->isColumnModified(DeliveryPeer::MAX_ORDER_QUANTITY)) $criteria->add(DeliveryPeer::MAX_ORDER_QUANTITY, $this->max_order_quantity);
		if ($this->isColumnModified(DeliveryPeer::MIN_ORDER_WEIGHT)) $criteria->add(DeliveryPeer::MIN_ORDER_WEIGHT, $this->min_order_weight);
		if ($this->isColumnModified(DeliveryPeer::MIN_ORDER_AMOUNT)) $criteria->add(DeliveryPeer::MIN_ORDER_AMOUNT, $this->min_order_amount);
		if ($this->isColumnModified(DeliveryPeer::MIN_ORDER_QUANTITY)) $criteria->add(DeliveryPeer::MIN_ORDER_QUANTITY, $this->min_order_quantity);
		if ($this->isColumnModified(DeliveryPeer::POSITION)) $criteria->add(DeliveryPeer::POSITION, $this->position);
		if ($this->isColumnModified(DeliveryPeer::PARAMS)) $criteria->add(DeliveryPeer::PARAMS, $this->params);
		if ($this->isColumnModified(DeliveryPeer::PACZKOMATY_TYPE)) $criteria->add(DeliveryPeer::PACZKOMATY_TYPE, $this->paczkomaty_type);
		if ($this->isColumnModified(DeliveryPeer::PACZKOMATY_SIZE)) $criteria->add(DeliveryPeer::PACZKOMATY_SIZE, $this->paczkomaty_size);

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
		$criteria = new Criteria(DeliveryPeer::DATABASE_NAME);

		$criteria->add(DeliveryPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Delivery (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCountriesAreaId($this->countries_area_id);

		$copyObj->setTaxId($this->tax_id);

		$copyObj->setTypeId($this->type_id);

		$copyObj->setFreeDelivery($this->free_delivery);

		$copyObj->setActive($this->active);

		$copyObj->setAllowInSelectedProducts($this->allow_in_selected_products);

		$copyObj->setDefaultCost($this->default_cost);

		$copyObj->setDefaultCostBrutto($this->default_cost_brutto);

		$copyObj->setWidth($this->width);

		$copyObj->setHeight($this->height);

		$copyObj->setDepth($this->depth);

		$copyObj->setVolume($this->volume);

		$copyObj->setIsSystemDefault($this->is_system_default);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setOptDescription($this->opt_description);

		$copyObj->setIsDefault($this->is_default);

		$copyObj->setSectionCostType($this->section_cost_type);

		$copyObj->setMaxOrderWeight($this->max_order_weight);

		$copyObj->setMaxOrderAmount($this->max_order_amount);

		$copyObj->setMaxOrderQuantity($this->max_order_quantity);

		$copyObj->setMinOrderWeight($this->min_order_weight);

		$copyObj->setMinOrderAmount($this->min_order_amount);

		$copyObj->setMinOrderQuantity($this->min_order_quantity);

		$copyObj->setPosition($this->position);

		$copyObj->setParams($this->params);

		$copyObj->setPaczkomatyType($this->paczkomaty_type);

		$copyObj->setPaczkomatySize($this->paczkomaty_size);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getOrderDeliverys() as $relObj) {
				$copyObj->addOrderDelivery($relObj->copy($deepCopy));
			}

			foreach($this->getDeliverySectionss() as $relObj) {
				$copyObj->addDeliverySections($relObj->copy($deepCopy));
			}

			foreach($this->getDeliveryHasPaymentTypes() as $relObj) {
				$copyObj->addDeliveryHasPaymentType($relObj->copy($deepCopy));
			}

			foreach($this->getDeliveryI18ns() as $relObj) {
				$copyObj->addDeliveryI18n($relObj->copy($deepCopy));
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
	 * @return     Delivery Clone of current object.
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
	 * @return     DeliveryPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new DeliveryPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a CountriesArea object.
	 *
	 * @param      CountriesArea $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setCountriesArea($v)
	{


		if ($v === null) {
			$this->setCountriesAreaId(NULL);
		} else {
			$this->setCountriesAreaId($v->getId());
		}


		$this->aCountriesArea = $v;
	}


	/**
	 * Get the associated CountriesArea object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     CountriesArea The associated CountriesArea object.
	 * @throws     PropelException
	 */
	public function getCountriesArea($con = null)
	{
		if ($this->aCountriesArea === null && ($this->countries_area_id !== null)) {
			// include the related Peer class
			$this->aCountriesArea = CountriesAreaPeer::retrieveByPK($this->countries_area_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = CountriesAreaPeer::retrieveByPK($this->countries_area_id, $con);
			   $obj->addCountriesAreas($this);
			 */
		}
		return $this->aCountriesArea;
	}

	/**
	 * Declares an association between this object and a Tax object.
	 *
	 * @param      Tax $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setTax($v)
	{


		if ($v === null) {
			$this->setTaxId(NULL);
		} else {
			$this->setTaxId($v->getId());
		}


		$this->aTax = $v;
	}


	/**
	 * Get the associated Tax object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Tax The associated Tax object.
	 * @throws     PropelException
	 */
	public function getTax($con = null)
	{
		if ($this->aTax === null && ($this->tax_id !== null)) {
			// include the related Peer class
			$this->aTax = TaxPeer::retrieveByPK($this->tax_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = TaxPeer::retrieveByPK($this->tax_id, $con);
			   $obj->addTaxs($this);
			 */
		}
		return $this->aTax;
	}

	/**
	 * Declares an association between this object and a DeliveryType object.
	 *
	 * @param      DeliveryType $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setDeliveryType($v)
	{


		if ($v === null) {
			$this->setTypeId(NULL);
		} else {
			$this->setTypeId($v->getId());
		}


		$this->aDeliveryType = $v;
	}


	/**
	 * Get the associated DeliveryType object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     DeliveryType The associated DeliveryType object.
	 * @throws     PropelException
	 */
	public function getDeliveryType($con = null)
	{
		if ($this->aDeliveryType === null && ($this->type_id !== null)) {
			// include the related Peer class
			$this->aDeliveryType = DeliveryTypePeer::retrieveByPK($this->type_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = DeliveryTypePeer::retrieveByPK($this->type_id, $con);
			   $obj->addDeliveryTypes($this);
			 */
		}
		return $this->aDeliveryType;
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
	 * Otherwise if this Delivery has previously
	 * been saved, it will retrieve related OrderDeliverys from storage.
	 * If this Delivery is new, it will return
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

				$criteria->add(OrderDeliveryPeer::DELIVERY_ID, $this->getId());

				OrderDeliveryPeer::addSelectColumns($criteria);
				$this->collOrderDeliverys = OrderDeliveryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderDeliveryPeer::DELIVERY_ID, $this->getId());

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

		$criteria->add(OrderDeliveryPeer::DELIVERY_ID, $this->getId());

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
		$l->setDelivery($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Delivery is new, it will return
	 * an empty collection; or if this Delivery has previously
	 * been saved, it will retrieve related OrderDeliverys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Delivery.
	 */
	public function getOrderDeliverysJoinTax($criteria = null, $con = null)
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

				$criteria->add(OrderDeliveryPeer::DELIVERY_ID, $this->getId());

				$this->collOrderDeliverys = OrderDeliveryPeer::doSelectJoinTax($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderDeliveryPeer::DELIVERY_ID, $this->getId());

			if (!isset($this->lastOrderDeliveryCriteria) || !$this->lastOrderDeliveryCriteria->equals($criteria)) {
				$this->collOrderDeliverys = OrderDeliveryPeer::doSelectJoinTax($criteria, $con);
			}
		}
		$this->lastOrderDeliveryCriteria = $criteria;

		return $this->collOrderDeliverys;
	}

	/**
	 * Temporary storage of collDeliverySectionss to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDeliverySectionss()
	{
		if ($this->collDeliverySectionss === null) {
			$this->collDeliverySectionss = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Delivery has previously
	 * been saved, it will retrieve related DeliverySectionss from storage.
	 * If this Delivery is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDeliverySectionss($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDeliverySectionss === null) {
			if ($this->isNew()) {
			   $this->collDeliverySectionss = array();
			} else {

				$criteria->add(DeliverySectionsPeer::DELIVERY_ID, $this->getId());

				DeliverySectionsPeer::addSelectColumns($criteria);
				$this->collDeliverySectionss = DeliverySectionsPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DeliverySectionsPeer::DELIVERY_ID, $this->getId());

				DeliverySectionsPeer::addSelectColumns($criteria);
				if (!isset($this->lastDeliverySectionsCriteria) || !$this->lastDeliverySectionsCriteria->equals($criteria)) {
					$this->collDeliverySectionss = DeliverySectionsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDeliverySectionsCriteria = $criteria;
		return $this->collDeliverySectionss;
	}

	/**
	 * Returns the number of related DeliverySectionss.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDeliverySectionss($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DeliverySectionsPeer::DELIVERY_ID, $this->getId());

		return DeliverySectionsPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DeliverySections object to this object
	 * through the DeliverySections foreign key attribute
	 *
	 * @param      DeliverySections $l DeliverySections
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDeliverySections(DeliverySections $l)
	{
		$this->collDeliverySectionss[] = $l;
		$l->setDelivery($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Delivery is new, it will return
	 * an empty collection; or if this Delivery has previously
	 * been saved, it will retrieve related DeliverySectionss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Delivery.
	 */
	public function getDeliverySectionssJoinAttributeField($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDeliverySectionss === null) {
			if ($this->isNew()) {
				$this->collDeliverySectionss = array();
			} else {

				$criteria->add(DeliverySectionsPeer::DELIVERY_ID, $this->getId());

				$this->collDeliverySectionss = DeliverySectionsPeer::doSelectJoinAttributeField($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DeliverySectionsPeer::DELIVERY_ID, $this->getId());

			if (!isset($this->lastDeliverySectionsCriteria) || !$this->lastDeliverySectionsCriteria->equals($criteria)) {
				$this->collDeliverySectionss = DeliverySectionsPeer::doSelectJoinAttributeField($criteria, $con);
			}
		}
		$this->lastDeliverySectionsCriteria = $criteria;

		return $this->collDeliverySectionss;
	}

	/**
	 * Temporary storage of collDeliveryHasPaymentTypes to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDeliveryHasPaymentTypes()
	{
		if ($this->collDeliveryHasPaymentTypes === null) {
			$this->collDeliveryHasPaymentTypes = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Delivery has previously
	 * been saved, it will retrieve related DeliveryHasPaymentTypes from storage.
	 * If this Delivery is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDeliveryHasPaymentTypes($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDeliveryHasPaymentTypes === null) {
			if ($this->isNew()) {
			   $this->collDeliveryHasPaymentTypes = array();
			} else {

				$criteria->add(DeliveryHasPaymentTypePeer::DELIVERY_ID, $this->getId());

				DeliveryHasPaymentTypePeer::addSelectColumns($criteria);
				$this->collDeliveryHasPaymentTypes = DeliveryHasPaymentTypePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DeliveryHasPaymentTypePeer::DELIVERY_ID, $this->getId());

				DeliveryHasPaymentTypePeer::addSelectColumns($criteria);
				if (!isset($this->lastDeliveryHasPaymentTypeCriteria) || !$this->lastDeliveryHasPaymentTypeCriteria->equals($criteria)) {
					$this->collDeliveryHasPaymentTypes = DeliveryHasPaymentTypePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDeliveryHasPaymentTypeCriteria = $criteria;
		return $this->collDeliveryHasPaymentTypes;
	}

	/**
	 * Returns the number of related DeliveryHasPaymentTypes.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDeliveryHasPaymentTypes($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DeliveryHasPaymentTypePeer::DELIVERY_ID, $this->getId());

		return DeliveryHasPaymentTypePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DeliveryHasPaymentType object to this object
	 * through the DeliveryHasPaymentType foreign key attribute
	 *
	 * @param      DeliveryHasPaymentType $l DeliveryHasPaymentType
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDeliveryHasPaymentType(DeliveryHasPaymentType $l)
	{
		$this->collDeliveryHasPaymentTypes[] = $l;
		$l->setDelivery($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Delivery is new, it will return
	 * an empty collection; or if this Delivery has previously
	 * been saved, it will retrieve related DeliveryHasPaymentTypes from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Delivery.
	 */
	public function getDeliveryHasPaymentTypesJoinPaymentType($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDeliveryHasPaymentTypes === null) {
			if ($this->isNew()) {
				$this->collDeliveryHasPaymentTypes = array();
			} else {

				$criteria->add(DeliveryHasPaymentTypePeer::DELIVERY_ID, $this->getId());

				$this->collDeliveryHasPaymentTypes = DeliveryHasPaymentTypePeer::doSelectJoinPaymentType($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DeliveryHasPaymentTypePeer::DELIVERY_ID, $this->getId());

			if (!isset($this->lastDeliveryHasPaymentTypeCriteria) || !$this->lastDeliveryHasPaymentTypeCriteria->equals($criteria)) {
				$this->collDeliveryHasPaymentTypes = DeliveryHasPaymentTypePeer::doSelectJoinPaymentType($criteria, $con);
			}
		}
		$this->lastDeliveryHasPaymentTypeCriteria = $criteria;

		return $this->collDeliveryHasPaymentTypes;
	}

	/**
	 * Temporary storage of collDeliveryI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDeliveryI18ns()
	{
		if ($this->collDeliveryI18ns === null) {
			$this->collDeliveryI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Delivery has previously
	 * been saved, it will retrieve related DeliveryI18ns from storage.
	 * If this Delivery is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDeliveryI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDeliveryI18ns === null) {
			if ($this->isNew()) {
			   $this->collDeliveryI18ns = array();
			} else {

				$criteria->add(DeliveryI18nPeer::ID, $this->getId());

				DeliveryI18nPeer::addSelectColumns($criteria);
				$this->collDeliveryI18ns = DeliveryI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DeliveryI18nPeer::ID, $this->getId());

				DeliveryI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastDeliveryI18nCriteria) || !$this->lastDeliveryI18nCriteria->equals($criteria)) {
					$this->collDeliveryI18ns = DeliveryI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDeliveryI18nCriteria = $criteria;
		return $this->collDeliveryI18ns;
	}

	/**
	 * Returns the number of related DeliveryI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDeliveryI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DeliveryI18nPeer::ID, $this->getId());

		return DeliveryI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a DeliveryI18n object to this object
	 * through the DeliveryI18n foreign key attribute
	 *
	 * @param      DeliveryI18n $l DeliveryI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDeliveryI18n(DeliveryI18n $l)
	{
		$this->collDeliveryI18ns[] = $l;
		$l->setDelivery($this);
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
    $obj = $this->getCurrentDeliveryI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentDeliveryI18n()->setName($value);
  }

  public function getDescription()
  {
    $obj = $this->getCurrentDeliveryI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentDeliveryI18n()->setDescription($value);
  }

  public $current_i18n = array();

  public function getCurrentDeliveryI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = DeliveryI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setDeliveryI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setDeliveryI18nForCulture(new DeliveryI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setDeliveryI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addDeliveryI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Delivery.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseDelivery:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseDelivery::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseDelivery
