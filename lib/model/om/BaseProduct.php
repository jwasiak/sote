<?php

/**
 * Base class that represents a row from the 'st_product' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseProduct extends BaseObject  implements Persistent {


              protected static $dispatcher = null;

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ProductPeer
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
	 * The value for the parent_id field.
	 * @var        int
	 */
	protected $parent_id;


	/**
	 * The value for the currency_id field.
	 * @var        int
	 */
	protected $currency_id;


	/**
	 * The value for the producer_id field.
	 * @var        int
	 */
	protected $producer_id;


	/**
	 * The value for the code field.
	 * @var        string
	 */
	protected $code;


	/**
	 * The value for the price field.
	 * @var        double
	 */
	protected $price;


	/**
	 * The value for the opt_price_brutto field.
	 * @var        double
	 */
	protected $opt_price_brutto;


	/**
	 * The value for the delivery_price field.
	 * @var        double
	 */
	protected $delivery_price;


	/**
	 * The value for the bpum_default_id field.
	 * @var        int
	 */
	protected $bpum_default_id;


	/**
	 * The value for the bpum_default_value field.
	 * @var        double
	 */
	protected $bpum_default_value;


	/**
	 * The value for the bpum_id field.
	 * @var        int
	 */
	protected $bpum_id;


	/**
	 * The value for the bpum_value field.
	 * @var        double
	 */
	protected $bpum_value;


	/**
	 * The value for the currency_price field.
	 * @var        double
	 */
	protected $currency_price;


	/**
	 * The value for the old_price field.
	 * @var        double
	 */
	protected $old_price;


	/**
	 * The value for the opt_old_price_brutto field.
	 * @var        double
	 */
	protected $opt_old_price_brutto;


	/**
	 * The value for the points_value field.
	 * @var        int
	 */
	protected $points_value = 0;


	/**
	 * The value for the points_earn field.
	 * @var        int
	 */
	protected $points_earn = 0;


	/**
	 * The value for the points_only field.
	 * @var        boolean
	 */
	protected $points_only = false;


	/**
	 * The value for the currency_old_price field.
	 * @var        double
	 */
	protected $currency_old_price;


	/**
	 * The value for the opt_vat field.
	 * @var        double
	 */
	protected $opt_vat;


	/**
	 * The value for the currency_exchange field.
	 * @var        double
	 */
	protected $currency_exchange = 1;


	/**
	 * The value for the active field.
	 * @var        boolean
	 */
	protected $active = true;


	/**
	 * The value for the hide_price field.
	 * @var        int
	 */
	protected $hide_price = 0;


	/**
	 * The value for the has_fixed_currency field.
	 * @var        boolean
	 */
	protected $has_fixed_currency = false;


	/**
	 * The value for the opt_image field.
	 * @var        string
	 */
	protected $opt_image;


	/**
	 * The value for the opt_name field.
	 * @var        string
	 */
	protected $opt_name;


	/**
	 * The value for the opt_short_description field.
	 * @var        string
	 */
	protected $opt_short_description;


	/**
	 * The value for the opt_description field.
	 * @var        string
	 */
	protected $opt_description;


	/**
	 * The value for the opt_url field.
	 * @var        string
	 */
	protected $opt_url;


	/**
	 * The value for the opt_asset_folder field.
	 * @var        string
	 */
	protected $opt_asset_folder;


	/**
	 * The value for the opt_uom field.
	 * @var        string
	 */
	protected $opt_uom;


	/**
	 * The value for the deliveries field.
	 * @var        string
	 */
	protected $deliveries;


	/**
	 * The value for the min_qty field.
	 * @var        double
	 */
	protected $min_qty = 1;


	/**
	 * The value for the max_qty field.
	 * @var        double
	 */
	protected $max_qty = 0;


	/**
	 * The value for the step_qty field.
	 * @var        double
	 */
	protected $step_qty = 0;


	/**
	 * The value for the is_stock_validated field.
	 * @var        boolean
	 */
	protected $is_stock_validated;


	/**
	 * The value for the is_gift field.
	 * @var        int
	 */
	protected $is_gift = 0;


	/**
	 * The value for the is_service field.
	 * @var        boolean
	 */
	protected $is_service = false;


	/**
	 * The value for the stock_in_decimals field.
	 * @var        int
	 */
	protected $stock_in_decimals = 0;


	/**
	 * The value for the man_code field.
	 * @var        string
	 */
	protected $man_code;


	/**
	 * The value for the main_page_order field.
	 * @var        int
	 */
	protected $main_page_order = 0;


	/**
	 * The value for the priority field.
	 * @var        int
	 */
	protected $priority = 0;


	/**
	 * The value for the stock_managment field.
	 * @var        int
	 */
	protected $stock_managment = 0;


	/**
	 * The value for the dimension_id field.
	 * @var        int
	 */
	protected $dimension_id;


	/**
	 * The value for the width field.
	 * @var        double
	 */
	protected $width = 0;


	/**
	 * The value for the height field.
	 * @var        double
	 */
	protected $height = 0;


	/**
	 * The value for the depth field.
	 * @var        double
	 */
	protected $depth = 0;


	/**
	 * The value for the opt_product_group field.
	 * @var        string
	 */
	protected $opt_product_group;


	/**
	 * The value for the opt_execution_time field.
	 * @var        string
	 */
	protected $opt_execution_time;


	/**
	 * The value for the availability_id field.
	 * @var        int
	 */
	protected $availability_id;


	/**
	 * The value for the weight field.
	 * @var        double
	 */
	protected $weight;


	/**
	 * The value for the stock field.
	 * @var        double
	 */
	protected $stock = 1;


	/**
	 * The value for the max_discount field.
	 * @var        double
	 */
	protected $max_discount = 100;


	/**
	 * The value for the mpn_code field.
	 * @var        string
	 */
	protected $mpn_code;


	/**
	 * The value for the group_price_id field.
	 * @var        int
	 */
	protected $group_price_id;


	/**
	 * The value for the opt_has_options field.
	 * @var        int
	 */
	protected $opt_has_options;


	/**
	 * The value for the options_color field.
	 * @var        string
	 */
	protected $options_color;


	/**
	 * The value for the tax_id field.
	 * @var        int
	 */
	protected $tax_id;


	/**
	 * The value for the wholesale_a_netto field.
	 * @var        double
	 */
	protected $wholesale_a_netto = 0;


	/**
	 * The value for the wholesale_b_netto field.
	 * @var        double
	 */
	protected $wholesale_b_netto = 0;


	/**
	 * The value for the wholesale_c_netto field.
	 * @var        double
	 */
	protected $wholesale_c_netto = 0;


	/**
	 * The value for the wholesale_a_brutto field.
	 * @var        double
	 */
	protected $wholesale_a_brutto = 0;


	/**
	 * The value for the wholesale_b_brutto field.
	 * @var        double
	 */
	protected $wholesale_b_brutto = 0;


	/**
	 * The value for the wholesale_c_brutto field.
	 * @var        double
	 */
	protected $wholesale_c_brutto = 0;


	/**
	 * The value for the currency_wholesale_a field.
	 * @var        double
	 */
	protected $currency_wholesale_a;


	/**
	 * The value for the currency_wholesale_b field.
	 * @var        double
	 */
	protected $currency_wholesale_b;


	/**
	 * The value for the currency_wholesale_c field.
	 * @var        double
	 */
	protected $currency_wholesale_c;

	/**
	 * @var        Product
	 */
	protected $aProductRelatedByParentId;

	/**
	 * @var        Currency
	 */
	protected $aCurrency;

	/**
	 * @var        Producer
	 */
	protected $aProducer;

	/**
	 * @var        BasicPriceUnitMeasure
	 */
	protected $aBasicPriceUnitMeasureRelatedByBpumDefaultId;

	/**
	 * @var        BasicPriceUnitMeasure
	 */
	protected $aBasicPriceUnitMeasureRelatedByBpumId;

	/**
	 * @var        ProductDimension
	 */
	protected $aProductDimension;

	/**
	 * @var        Availability
	 */
	protected $aAvailability;

	/**
	 * @var        GroupPrice
	 */
	protected $aGroupPrice;

	/**
	 * @var        Tax
	 */
	protected $aTax;

	/**
	 * Collection to store aggregation of collProductHasWholesales.
	 * @var        array
	 */
	protected $collProductHasWholesales;

	/**
	 * The criteria used to select the current contents of collProductHasWholesales.
	 * @var        Criteria
	 */
	protected $lastProductHasWholesaleCriteria = null;

	/**
	 * Collection to store aggregation of collHandelos.
	 * @var        array
	 */
	protected $collHandelos;

	/**
	 * The criteria used to select the current contents of collHandelos.
	 * @var        Criteria
	 */
	protected $lastHandeloCriteria = null;

	/**
	 * Collection to store aggregation of collGoogleShoppings.
	 * @var        array
	 */
	protected $collGoogleShoppings;

	/**
	 * The criteria used to select the current contents of collGoogleShoppings.
	 * @var        Criteria
	 */
	protected $lastGoogleShoppingCriteria = null;

	/**
	 * Collection to store aggregation of collProductHasAttributeFields.
	 * @var        array
	 */
	protected $collProductHasAttributeFields;

	/**
	 * The criteria used to select the current contents of collProductHasAttributeFields.
	 * @var        Criteria
	 */
	protected $lastProductHasAttributeFieldCriteria = null;

	/**
	 * Collection to store aggregation of collAllegroAuctions.
	 * @var        array
	 */
	protected $collAllegroAuctions;

	/**
	 * The criteria used to select the current contents of collAllegroAuctions.
	 * @var        Criteria
	 */
	protected $lastAllegroAuctionCriteria = null;

	/**
	 * Collection to store aggregation of collCrossellingsRelatedByFirstProductId.
	 * @var        array
	 */
	protected $collCrossellingsRelatedByFirstProductId;

	/**
	 * The criteria used to select the current contents of collCrossellingsRelatedByFirstProductId.
	 * @var        Criteria
	 */
	protected $lastCrossellingRelatedByFirstProductIdCriteria = null;

	/**
	 * Collection to store aggregation of collCrossellingsRelatedBySecoundProductId.
	 * @var        array
	 */
	protected $collCrossellingsRelatedBySecoundProductId;

	/**
	 * The criteria used to select the current contents of collCrossellingsRelatedBySecoundProductId.
	 * @var        Criteria
	 */
	protected $lastCrossellingRelatedBySecoundProductIdCriteria = null;

	/**
	 * Collection to store aggregation of collLukasProducts.
	 * @var        array
	 */
	protected $collLukasProducts;

	/**
	 * The criteria used to select the current contents of collLukasProducts.
	 * @var        Criteria
	 */
	protected $lastLukasProductCriteria = null;

	/**
	 * Collection to store aggregation of collDiscounts.
	 * @var        array
	 */
	protected $collDiscounts;

	/**
	 * The criteria used to select the current contents of collDiscounts.
	 * @var        Criteria
	 */
	protected $lastDiscountCriteria = null;

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
	 * Collection to store aggregation of collProductsRelatedByParentId.
	 * @var        array
	 */
	protected $collProductsRelatedByParentId;

	/**
	 * The criteria used to select the current contents of collProductsRelatedByParentId.
	 * @var        Criteria
	 */
	protected $lastProductRelatedByParentIdCriteria = null;

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
	 * Collection to store aggregation of collProductHasSfAssets.
	 * @var        array
	 */
	protected $collProductHasSfAssets;

	/**
	 * The criteria used to select the current contents of collProductHasSfAssets.
	 * @var        Criteria
	 */
	protected $lastProductHasSfAssetCriteria = null;

	/**
	 * Collection to store aggregation of collProductHasAttachments.
	 * @var        array
	 */
	protected $collProductHasAttachments;

	/**
	 * The criteria used to select the current contents of collProductHasAttachments.
	 * @var        Criteria
	 */
	protected $lastProductHasAttachmentCriteria = null;

	/**
	 * Collection to store aggregation of collProductHasRecommendsRelatedByRecommendId.
	 * @var        array
	 */
	protected $collProductHasRecommendsRelatedByRecommendId;

	/**
	 * The criteria used to select the current contents of collProductHasRecommendsRelatedByRecommendId.
	 * @var        Criteria
	 */
	protected $lastProductHasRecommendRelatedByRecommendIdCriteria = null;

	/**
	 * Collection to store aggregation of collProductHasRecommendsRelatedByProductId.
	 * @var        array
	 */
	protected $collProductHasRecommendsRelatedByProductId;

	/**
	 * The criteria used to select the current contents of collProductHasRecommendsRelatedByProductId.
	 * @var        Criteria
	 */
	protected $lastProductHasRecommendRelatedByProductIdCriteria = null;

	/**
	 * Collection to store aggregation of collProductI18ns.
	 * @var        array
	 */
	protected $collProductI18ns;

	/**
	 * The criteria used to select the current contents of collProductI18ns.
	 * @var        Criteria
	 */
	protected $lastProductI18nCriteria = null;

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
	 * Collection to store aggregation of collOnlineCodess.
	 * @var        array
	 */
	protected $collOnlineCodess;

	/**
	 * The criteria used to select the current contents of collOnlineCodess.
	 * @var        Criteria
	 */
	protected $lastOnlineCodesCriteria = null;

	/**
	 * Collection to store aggregation of collOnlineFiless.
	 * @var        array
	 */
	protected $collOnlineFiless;

	/**
	 * The criteria used to select the current contents of collOnlineFiless.
	 * @var        Criteria
	 */
	protected $lastOnlineFilesCriteria = null;

	/**
	 * Collection to store aggregation of collBazzars.
	 * @var        array
	 */
	protected $collBazzars;

	/**
	 * The criteria used to select the current contents of collBazzars.
	 * @var        Criteria
	 */
	protected $lastBazzarCriteria = null;

	/**
	 * Collection to store aggregation of collTrusts.
	 * @var        array
	 */
	protected $collTrusts;

	/**
	 * The criteria used to select the current contents of collTrusts.
	 * @var        Criteria
	 */
	protected $lastTrustCriteria = null;

	/**
	 * Collection to store aggregation of collRadars.
	 * @var        array
	 */
	protected $collRadars;

	/**
	 * The criteria used to select the current contents of collRadars.
	 * @var        Criteria
	 */
	protected $lastRadarCriteria = null;

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
	 * Collection to store aggregation of collOrderProductHasSets.
	 * @var        array
	 */
	protected $collOrderProductHasSets;

	/**
	 * The criteria used to select the current contents of collOrderProductHasSets.
	 * @var        Criteria
	 */
	protected $lastOrderProductHasSetCriteria = null;

	/**
	 * Collection to store aggregation of collCeneos.
	 * @var        array
	 */
	protected $collCeneos;

	/**
	 * The criteria used to select the current contents of collCeneos.
	 * @var        Criteria
	 */
	protected $lastCeneoCriteria = null;

	/**
	 * Collection to store aggregation of collGiftCardHasProducts.
	 * @var        array
	 */
	protected $collGiftCardHasProducts;

	/**
	 * The criteria used to select the current contents of collGiftCardHasProducts.
	 * @var        Criteria
	 */
	protected $lastGiftCardHasProductCriteria = null;

	/**
	 * Collection to store aggregation of collReviews.
	 * @var        array
	 */
	protected $collReviews;

	/**
	 * The criteria used to select the current contents of collReviews.
	 * @var        Criteria
	 */
	protected $lastReviewCriteria = null;

	/**
	 * Collection to store aggregation of collappProductAttributeVariantHasProducts.
	 * @var        array
	 */
	protected $collappProductAttributeVariantHasProducts;

	/**
	 * The criteria used to select the current contents of collappProductAttributeVariantHasProducts.
	 * @var        Criteria
	 */
	protected $lastappProductAttributeVariantHasProductCriteria = null;

	/**
	 * Collection to store aggregation of collOnets.
	 * @var        array
	 */
	protected $collOnets;

	/**
	 * The criteria used to select the current contents of collOnets.
	 * @var        Criteria
	 */
	protected $lastOnetCriteria = null;

	/**
	 * Collection to store aggregation of collZakupomats.
	 * @var        array
	 */
	protected $collZakupomats;

	/**
	 * The criteria used to select the current contents of collZakupomats.
	 * @var        Criteria
	 */
	protected $lastZakupomatCriteria = null;

	/**
	 * Collection to store aggregation of collOkazjes.
	 * @var        array
	 */
	protected $collOkazjes;

	/**
	 * The criteria used to select the current contents of collOkazjes.
	 * @var        Criteria
	 */
	protected $lastOkazjeCriteria = null;

	/**
	 * Collection to store aggregation of collProductOptionsValues.
	 * @var        array
	 */
	protected $collProductOptionsValues;

	/**
	 * The criteria used to select the current contents of collProductOptionsValues.
	 * @var        Criteria
	 */
	protected $lastProductOptionsValueCriteria = null;

	/**
	 * Collection to store aggregation of collProductSearchIndexs.
	 * @var        array
	 */
	protected $collProductSearchIndexs;

	/**
	 * The criteria used to select the current contents of collProductSearchIndexs.
	 * @var        Criteria
	 */
	protected $lastProductSearchIndexCriteria = null;

	/**
	 * Collection to store aggregation of collProductHasProductSearchTags.
	 * @var        array
	 */
	protected $collProductHasProductSearchTags;

	/**
	 * The criteria used to select the current contents of collProductHasProductSearchTags.
	 * @var        Criteria
	 */
	protected $lastProductHasProductSearchTagCriteria = null;

	/**
	 * Collection to store aggregation of collBasketProducts.
	 * @var        array
	 */
	protected $collBasketProducts;

	/**
	 * The criteria used to select the current contents of collBasketProducts.
	 * @var        Criteria
	 */
	protected $lastBasketProductCriteria = null;

	/**
	 * Collection to store aggregation of collInvoiceProducts.
	 * @var        array
	 */
	protected $collInvoiceProducts;

	/**
	 * The criteria used to select the current contents of collInvoiceProducts.
	 * @var        Criteria
	 */
	protected $lastInvoiceProductCriteria = null;

	/**
	 * Collection to store aggregation of collOferciaks.
	 * @var        array
	 */
	protected $collOferciaks;

	/**
	 * The criteria used to select the current contents of collOferciaks.
	 * @var        Criteria
	 */
	protected $lastOferciakCriteria = null;

	/**
	 * Collection to store aggregation of collProductHasAccessoriessRelatedByAccessoriesId.
	 * @var        array
	 */
	protected $collProductHasAccessoriessRelatedByAccessoriesId;

	/**
	 * The criteria used to select the current contents of collProductHasAccessoriessRelatedByAccessoriesId.
	 * @var        Criteria
	 */
	protected $lastProductHasAccessoriesRelatedByAccessoriesIdCriteria = null;

	/**
	 * Collection to store aggregation of collProductHasAccessoriessRelatedByProductId.
	 * @var        array
	 */
	protected $collProductHasAccessoriessRelatedByProductId;

	/**
	 * The criteria used to select the current contents of collProductHasAccessoriessRelatedByProductId.
	 * @var        Criteria
	 */
	protected $lastProductHasAccessoriesRelatedByProductIdCriteria = null;

	/**
	 * Collection to store aggregation of collWps.
	 * @var        array
	 */
	protected $collWps;

	/**
	 * The criteria used to select the current contents of collWps.
	 * @var        Criteria
	 */
	protected $lastWpCriteria = null;

	/**
	 * Collection to store aggregation of collNokauts.
	 * @var        array
	 */
	protected $collNokauts;

	/**
	 * The criteria used to select the current contents of collNokauts.
	 * @var        Criteria
	 */
	protected $lastNokautCriteria = null;

	/**
	 * Collection to store aggregation of collProductHasPositionings.
	 * @var        array
	 */
	protected $collProductHasPositionings;

	/**
	 * The criteria used to select the current contents of collProductHasPositionings.
	 * @var        Criteria
	 */
	protected $lastProductHasPositioningCriteria = null;

	/**
	 * Collection to store aggregation of collSklepy24s.
	 * @var        array
	 */
	protected $collSklepy24s;

	/**
	 * The criteria used to select the current contents of collSklepy24s.
	 * @var        Criteria
	 */
	protected $lastSklepy24Criteria = null;

	/**
	 * Collection to store aggregation of collProductGroupHasProducts.
	 * @var        array
	 */
	protected $collProductGroupHasProducts;

	/**
	 * The criteria used to select the current contents of collProductGroupHasProducts.
	 * @var        Criteria
	 */
	protected $lastProductGroupHasProductCriteria = null;

	/**
	 * Collection to store aggregation of collQuestionss.
	 * @var        array
	 */
	protected $collQuestionss;

	/**
	 * The criteria used to select the current contents of collQuestionss.
	 * @var        Criteria
	 */
	protected $lastQuestionsCriteria = null;

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
     * Get the [parent_id] column value.
     * 
     * @return     int
     */
    public function getParentId()
    {

            return $this->parent_id;
    }

    /**
     * Get the [currency_id] column value.
     * 
     * @return     int
     */
    public function getCurrencyId()
    {

            return $this->currency_id;
    }

    /**
     * Get the [producer_id] column value.
     * 
     * @return     int
     */
    public function getProducerId()
    {

            return $this->producer_id;
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
     * Get the [price] column value.
     * 
     * @return     double
     */
    public function getPrice()
    {

            return null !== $this->price ? (string)$this->price : null;
    }

    /**
     * Get the [opt_price_brutto] column value.
     * 
     * @return     double
     */
    public function getOptPriceBrutto()
    {

            return null !== $this->opt_price_brutto ? (string)$this->opt_price_brutto : null;
    }

    /**
     * Get the [delivery_price] column value.
     * 
     * @return     double
     */
    public function getDeliveryPrice()
    {

            return null !== $this->delivery_price ? (string)$this->delivery_price : null;
    }

    /**
     * Get the [bpum_default_id] column value.
     * 
     * @return     int
     */
    public function getBpumDefaultId()
    {

            return $this->bpum_default_id;
    }

    /**
     * Get the [bpum_default_value] column value.
     * 
     * @return     double
     */
    public function getBpumDefaultValue()
    {

            return null !== $this->bpum_default_value ? (string)$this->bpum_default_value : null;
    }

    /**
     * Get the [bpum_id] column value.
     * 
     * @return     int
     */
    public function getBpumId()
    {

            return $this->bpum_id;
    }

    /**
     * Get the [bpum_value] column value.
     * 
     * @return     double
     */
    public function getBpumValue()
    {

            return null !== $this->bpum_value ? (string)$this->bpum_value : null;
    }

    /**
     * Get the [currency_price] column value.
     * 
     * @return     double
     */
    public function getCurrencyPrice()
    {

            return null !== $this->currency_price ? (string)$this->currency_price : null;
    }

    /**
     * Get the [old_price] column value.
     * 
     * @return     double
     */
    public function getOldPrice()
    {

            return null !== $this->old_price ? (string)$this->old_price : null;
    }

    /**
     * Get the [opt_old_price_brutto] column value.
     * 
     * @return     double
     */
    public function getOptOldPriceBrutto()
    {

            return null !== $this->opt_old_price_brutto ? (string)$this->opt_old_price_brutto : null;
    }

    /**
     * Get the [points_value] column value.
     * 
     * @return     int
     */
    public function getPointsValue()
    {

            return $this->points_value;
    }

    /**
     * Get the [points_earn] column value.
     * 
     * @return     int
     */
    public function getPointsEarn()
    {

            return $this->points_earn;
    }

    /**
     * Get the [points_only] column value.
     * 
     * @return     boolean
     */
    public function getPointsOnly()
    {

            return $this->points_only;
    }

    /**
     * Get the [currency_old_price] column value.
     * 
     * @return     double
     */
    public function getCurrencyOldPrice()
    {

            return null !== $this->currency_old_price ? (string)$this->currency_old_price : null;
    }

    /**
     * Get the [opt_vat] column value.
     * 
     * @return     double
     */
    public function getOptVat()
    {

            return null !== $this->opt_vat ? (string)$this->opt_vat : null;
    }

    /**
     * Get the [currency_exchange] column value.
     * 
     * @return     double
     */
    public function getCurrencyExchange()
    {

            return null !== $this->currency_exchange ? (string)$this->currency_exchange : null;
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
     * Get the [hide_price] column value.
     * 
     * @return     int
     */
    public function getHidePrice()
    {

            return $this->hide_price;
    }

    /**
     * Get the [has_fixed_currency] column value.
     * 
     * @return     boolean
     */
    public function getHasFixedCurrency()
    {

            return $this->has_fixed_currency;
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
     * Get the [opt_name] column value.
     * 
     * @return     string
     */
    public function getOptName()
    {

            return $this->opt_name;
    }

    /**
     * Get the [opt_short_description] column value.
     * 
     * @return     string
     */
    public function getOptShortDescription()
    {

            return $this->opt_short_description;
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
     * Get the [opt_url] column value.
     * 
     * @return     string
     */
    public function getOptUrl()
    {

            return $this->opt_url;
    }

    /**
     * Get the [opt_asset_folder] column value.
     * 
     * @return     string
     */
    public function getOptAssetFolder()
    {

            return $this->opt_asset_folder;
    }

    /**
     * Get the [opt_uom] column value.
     * 
     * @return     string
     */
    public function getOptUom()
    {

            return $this->opt_uom;
    }

    /**
     * Get the [deliveries] column value.
     * 
     * @return     string
     */
    public function getDeliveries()
    {

            return $this->deliveries;
    }

    /**
     * Get the [min_qty] column value.
     * 
     * @return     double
     */
    public function getMinQty()
    {

            return null !== $this->min_qty ? (string)$this->min_qty : null;
    }

    /**
     * Get the [max_qty] column value.
     * 
     * @return     double
     */
    public function getMaxQty()
    {

            return null !== $this->max_qty ? (string)$this->max_qty : null;
    }

    /**
     * Get the [step_qty] column value.
     * 
     * @return     double
     */
    public function getStepQty()
    {

            return null !== $this->step_qty ? (string)$this->step_qty : null;
    }

    /**
     * Get the [is_stock_validated] column value.
     * 
     * @return     boolean
     */
    public function getIsStockValidated()
    {

            return $this->is_stock_validated;
    }

    /**
     * Get the [is_gift] column value.
     * 
     * @return     int
     */
    public function getIsGift()
    {

            return $this->is_gift;
    }

    /**
     * Get the [is_service] column value.
     * 
     * @return     boolean
     */
    public function getIsService()
    {

            return $this->is_service;
    }

    /**
     * Get the [stock_in_decimals] column value.
     * 
     * @return     int
     */
    public function getStockInDecimals()
    {

            return $this->stock_in_decimals;
    }

    /**
     * Get the [man_code] column value.
     * 
     * @return     string
     */
    public function getManCode()
    {

            return $this->man_code;
    }

    /**
     * Get the [main_page_order] column value.
     * 
     * @return     int
     */
    public function getMainPageOrder()
    {

            return $this->main_page_order;
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
     * Get the [stock_managment] column value.
     * 
     * @return     int
     */
    public function getStockManagment()
    {

            return $this->stock_managment;
    }

    /**
     * Get the [dimension_id] column value.
     * 
     * @return     int
     */
    public function getDimensionId()
    {

            return $this->dimension_id;
    }

    /**
     * Get the [width] column value.
     * 
     * @return     double
     */
    public function getWidth()
    {

            return $this->width;
    }

    /**
     * Get the [height] column value.
     * 
     * @return     double
     */
    public function getHeight()
    {

            return $this->height;
    }

    /**
     * Get the [depth] column value.
     * 
     * @return     double
     */
    public function getDepth()
    {

            return $this->depth;
    }

    /**
     * Get the [opt_product_group] column value.
     * 
     * @return     string
     */
    public function getOptProductGroup()
    {

            return $this->opt_product_group;
    }

    /**
     * Get the [opt_execution_time] column value.
     * 
     * @return     string
     */
    public function getOptExecutionTime()
    {

            return $this->opt_execution_time;
    }

    /**
     * Get the [availability_id] column value.
     * 
     * @return     int
     */
    public function getAvailabilityId()
    {

            return $this->availability_id;
    }

    /**
     * Get the [weight] column value.
     * 
     * @return     double
     */
    public function getWeight()
    {

            return $this->weight;
    }

    /**
     * Get the [stock] column value.
     * 
     * @return     double
     */
    public function getStock()
    {

            return null !== $this->stock ? (string)$this->stock : null;
    }

    /**
     * Get the [max_discount] column value.
     * 
     * @return     double
     */
    public function getMaxDiscount()
    {

            return $this->max_discount;
    }

    /**
     * Get the [mpn_code] column value.
     * 
     * @return     string
     */
    public function getMpnCode()
    {

            return $this->mpn_code;
    }

    /**
     * Get the [group_price_id] column value.
     * 
     * @return     int
     */
    public function getGroupPriceId()
    {

            return $this->group_price_id;
    }

    /**
     * Get the [opt_has_options] column value.
     * 
     * @return     int
     */
    public function getOptHasOptions()
    {

            return $this->opt_has_options;
    }

    /**
     * Get the [options_color] column value.
     * 
     * @return     string
     */
    public function getOptionsColor()
    {

            return $this->options_color;
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
     * Get the [wholesale_a_netto] column value.
     * 
     * @return     double
     */
    public function getWholesaleANetto()
    {

            return null !== $this->wholesale_a_netto ? (string)$this->wholesale_a_netto : null;
    }

    /**
     * Get the [wholesale_b_netto] column value.
     * 
     * @return     double
     */
    public function getWholesaleBNetto()
    {

            return null !== $this->wholesale_b_netto ? (string)$this->wholesale_b_netto : null;
    }

    /**
     * Get the [wholesale_c_netto] column value.
     * 
     * @return     double
     */
    public function getWholesaleCNetto()
    {

            return null !== $this->wholesale_c_netto ? (string)$this->wholesale_c_netto : null;
    }

    /**
     * Get the [wholesale_a_brutto] column value.
     * 
     * @return     double
     */
    public function getWholesaleABrutto()
    {

            return null !== $this->wholesale_a_brutto ? (string)$this->wholesale_a_brutto : null;
    }

    /**
     * Get the [wholesale_b_brutto] column value.
     * 
     * @return     double
     */
    public function getWholesaleBBrutto()
    {

            return null !== $this->wholesale_b_brutto ? (string)$this->wholesale_b_brutto : null;
    }

    /**
     * Get the [wholesale_c_brutto] column value.
     * 
     * @return     double
     */
    public function getWholesaleCBrutto()
    {

            return null !== $this->wholesale_c_brutto ? (string)$this->wholesale_c_brutto : null;
    }

    /**
     * Get the [currency_wholesale_a] column value.
     * 
     * @return     double
     */
    public function getCurrencyWholesaleA()
    {

            return null !== $this->currency_wholesale_a ? (string)$this->currency_wholesale_a : null;
    }

    /**
     * Get the [currency_wholesale_b] column value.
     * 
     * @return     double
     */
    public function getCurrencyWholesaleB()
    {

            return null !== $this->currency_wholesale_b ? (string)$this->currency_wholesale_b : null;
    }

    /**
     * Get the [currency_wholesale_c] column value.
     * 
     * @return     double
     */
    public function getCurrencyWholesaleC()
    {

            return null !== $this->currency_wholesale_c ? (string)$this->currency_wholesale_c : null;
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
			$this->modifiedColumns[] = ProductPeer::CREATED_AT;
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
			$this->modifiedColumns[] = ProductPeer::UPDATED_AT;
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
          $this->modifiedColumns[] = ProductPeer::ID;
        }

	} // setId()

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
          $this->modifiedColumns[] = ProductPeer::PARENT_ID;
        }

		if ($this->aProductRelatedByParentId !== null && $this->aProductRelatedByParentId->getId() !== $v) {
			$this->aProductRelatedByParentId = null;
		}

	} // setParentId()

	/**
	 * Set the value of [currency_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCurrencyId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->currency_id !== $v) {
          $this->currency_id = $v;
          $this->modifiedColumns[] = ProductPeer::CURRENCY_ID;
        }

		if ($this->aCurrency !== null && $this->aCurrency->getId() !== $v) {
			$this->aCurrency = null;
		}

	} // setCurrencyId()

	/**
	 * Set the value of [producer_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setProducerId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->producer_id !== $v) {
          $this->producer_id = $v;
          $this->modifiedColumns[] = ProductPeer::PRODUCER_ID;
        }

		if ($this->aProducer !== null && $this->aProducer->getId() !== $v) {
			$this->aProducer = null;
		}

	} // setProducerId()

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
          $this->modifiedColumns[] = ProductPeer::CODE;
        }

	} // setCode()

	/**
	 * Set the value of [price] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setPrice($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->price !== $v) {
          $this->price = $v;
          $this->modifiedColumns[] = ProductPeer::PRICE;
        }

	} // setPrice()

	/**
	 * Set the value of [opt_price_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOptPriceBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->opt_price_brutto !== $v) {
          $this->opt_price_brutto = $v;
          $this->modifiedColumns[] = ProductPeer::OPT_PRICE_BRUTTO;
        }

	} // setOptPriceBrutto()

	/**
	 * Set the value of [delivery_price] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setDeliveryPrice($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->delivery_price !== $v) {
          $this->delivery_price = $v;
          $this->modifiedColumns[] = ProductPeer::DELIVERY_PRICE;
        }

	} // setDeliveryPrice()

	/**
	 * Set the value of [bpum_default_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setBpumDefaultId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->bpum_default_id !== $v) {
          $this->bpum_default_id = $v;
          $this->modifiedColumns[] = ProductPeer::BPUM_DEFAULT_ID;
        }

		if ($this->aBasicPriceUnitMeasureRelatedByBpumDefaultId !== null && $this->aBasicPriceUnitMeasureRelatedByBpumDefaultId->getId() !== $v) {
			$this->aBasicPriceUnitMeasureRelatedByBpumDefaultId = null;
		}

	} // setBpumDefaultId()

	/**
	 * Set the value of [bpum_default_value] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setBpumDefaultValue($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->bpum_default_value !== $v) {
          $this->bpum_default_value = $v;
          $this->modifiedColumns[] = ProductPeer::BPUM_DEFAULT_VALUE;
        }

	} // setBpumDefaultValue()

	/**
	 * Set the value of [bpum_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setBpumId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->bpum_id !== $v) {
          $this->bpum_id = $v;
          $this->modifiedColumns[] = ProductPeer::BPUM_ID;
        }

		if ($this->aBasicPriceUnitMeasureRelatedByBpumId !== null && $this->aBasicPriceUnitMeasureRelatedByBpumId->getId() !== $v) {
			$this->aBasicPriceUnitMeasureRelatedByBpumId = null;
		}

	} // setBpumId()

	/**
	 * Set the value of [bpum_value] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setBpumValue($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->bpum_value !== $v) {
          $this->bpum_value = $v;
          $this->modifiedColumns[] = ProductPeer::BPUM_VALUE;
        }

	} // setBpumValue()

	/**
	 * Set the value of [currency_price] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setCurrencyPrice($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->currency_price !== $v) {
          $this->currency_price = $v;
          $this->modifiedColumns[] = ProductPeer::CURRENCY_PRICE;
        }

	} // setCurrencyPrice()

	/**
	 * Set the value of [old_price] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOldPrice($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->old_price !== $v) {
          $this->old_price = $v;
          $this->modifiedColumns[] = ProductPeer::OLD_PRICE;
        }

	} // setOldPrice()

	/**
	 * Set the value of [opt_old_price_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOptOldPriceBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->opt_old_price_brutto !== $v) {
          $this->opt_old_price_brutto = $v;
          $this->modifiedColumns[] = ProductPeer::OPT_OLD_PRICE_BRUTTO;
        }

	} // setOptOldPriceBrutto()

	/**
	 * Set the value of [points_value] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPointsValue($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->points_value !== $v || $v === 0) {
          $this->points_value = $v;
          $this->modifiedColumns[] = ProductPeer::POINTS_VALUE;
        }

	} // setPointsValue()

	/**
	 * Set the value of [points_earn] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPointsEarn($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->points_earn !== $v || $v === 0) {
          $this->points_earn = $v;
          $this->modifiedColumns[] = ProductPeer::POINTS_EARN;
        }

	} // setPointsEarn()

	/**
	 * Set the value of [points_only] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setPointsOnly($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->points_only !== $v || $v === false) {
          $this->points_only = $v;
          $this->modifiedColumns[] = ProductPeer::POINTS_ONLY;
        }

	} // setPointsOnly()

	/**
	 * Set the value of [currency_old_price] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setCurrencyOldPrice($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->currency_old_price !== $v) {
          $this->currency_old_price = $v;
          $this->modifiedColumns[] = ProductPeer::CURRENCY_OLD_PRICE;
        }

	} // setCurrencyOldPrice()

	/**
	 * Set the value of [opt_vat] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setOptVat($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->opt_vat !== $v) {
          $this->opt_vat = $v;
          $this->modifiedColumns[] = ProductPeer::OPT_VAT;
        }

	} // setOptVat()

	/**
	 * Set the value of [currency_exchange] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setCurrencyExchange($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->currency_exchange !== $v || $v === 1) {
          $this->currency_exchange = $v;
          $this->modifiedColumns[] = ProductPeer::CURRENCY_EXCHANGE;
        }

	} // setCurrencyExchange()

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
          $this->modifiedColumns[] = ProductPeer::ACTIVE;
        }

	} // setActive()

	/**
	 * Set the value of [hide_price] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setHidePrice($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->hide_price !== $v || $v === 0) {
          $this->hide_price = $v;
          $this->modifiedColumns[] = ProductPeer::HIDE_PRICE;
        }

	} // setHidePrice()

	/**
	 * Set the value of [has_fixed_currency] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setHasFixedCurrency($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->has_fixed_currency !== $v || $v === false) {
          $this->has_fixed_currency = $v;
          $this->modifiedColumns[] = ProductPeer::HAS_FIXED_CURRENCY;
        }

	} // setHasFixedCurrency()

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
          $this->modifiedColumns[] = ProductPeer::OPT_IMAGE;
        }

	} // setOptImage()

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
          $this->modifiedColumns[] = ProductPeer::OPT_NAME;
        }

	} // setOptName()

	/**
	 * Set the value of [opt_short_description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptShortDescription($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_short_description !== $v) {
          $this->opt_short_description = $v;
          $this->modifiedColumns[] = ProductPeer::OPT_SHORT_DESCRIPTION;
        }

	} // setOptShortDescription()

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
          $this->modifiedColumns[] = ProductPeer::OPT_DESCRIPTION;
        }

	} // setOptDescription()

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
          $this->modifiedColumns[] = ProductPeer::OPT_URL;
        }

	} // setOptUrl()

	/**
	 * Set the value of [opt_asset_folder] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptAssetFolder($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_asset_folder !== $v) {
          $this->opt_asset_folder = $v;
          $this->modifiedColumns[] = ProductPeer::OPT_ASSET_FOLDER;
        }

	} // setOptAssetFolder()

	/**
	 * Set the value of [opt_uom] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptUom($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_uom !== $v) {
          $this->opt_uom = $v;
          $this->modifiedColumns[] = ProductPeer::OPT_UOM;
        }

	} // setOptUom()

	/**
	 * Set the value of [deliveries] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setDeliveries($v)
	{

        if ($this->deliveries !== $v) {
          $this->deliveries = $v;
          $this->modifiedColumns[] = ProductPeer::DELIVERIES;
        }

	} // setDeliveries()

	/**
	 * Set the value of [min_qty] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setMinQty($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->min_qty !== $v || $v === 1) {
          $this->min_qty = $v;
          $this->modifiedColumns[] = ProductPeer::MIN_QTY;
        }

	} // setMinQty()

	/**
	 * Set the value of [max_qty] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setMaxQty($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->max_qty !== $v || $v === 0) {
          $this->max_qty = $v;
          $this->modifiedColumns[] = ProductPeer::MAX_QTY;
        }

	} // setMaxQty()

	/**
	 * Set the value of [step_qty] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setStepQty($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->step_qty !== $v || $v === 0) {
          $this->step_qty = $v;
          $this->modifiedColumns[] = ProductPeer::STEP_QTY;
        }

	} // setStepQty()

	/**
	 * Set the value of [is_stock_validated] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsStockValidated($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_stock_validated !== $v) {
          $this->is_stock_validated = $v;
          $this->modifiedColumns[] = ProductPeer::IS_STOCK_VALIDATED;
        }

	} // setIsStockValidated()

	/**
	 * Set the value of [is_gift] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setIsGift($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->is_gift !== $v || $v === 0) {
          $this->is_gift = $v;
          $this->modifiedColumns[] = ProductPeer::IS_GIFT;
        }

	} // setIsGift()

	/**
	 * Set the value of [is_service] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsService($v)
	{

        if ($v !== null && !is_bool($v)) {
          $v = (bool) $v;
        }

        if ($this->is_service !== $v || $v === false) {
          $this->is_service = $v;
          $this->modifiedColumns[] = ProductPeer::IS_SERVICE;
        }

	} // setIsService()

	/**
	 * Set the value of [stock_in_decimals] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setStockInDecimals($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->stock_in_decimals !== $v || $v === 0) {
          $this->stock_in_decimals = $v;
          $this->modifiedColumns[] = ProductPeer::STOCK_IN_DECIMALS;
        }

	} // setStockInDecimals()

	/**
	 * Set the value of [man_code] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setManCode($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->man_code !== $v) {
          $this->man_code = $v;
          $this->modifiedColumns[] = ProductPeer::MAN_CODE;
        }

	} // setManCode()

	/**
	 * Set the value of [main_page_order] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setMainPageOrder($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->main_page_order !== $v || $v === 0) {
          $this->main_page_order = $v;
          $this->modifiedColumns[] = ProductPeer::MAIN_PAGE_ORDER;
        }

	} // setMainPageOrder()

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
          $this->modifiedColumns[] = ProductPeer::PRIORITY;
        }

	} // setPriority()

	/**
	 * Set the value of [stock_managment] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setStockManagment($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->stock_managment !== $v || $v === 0) {
          $this->stock_managment = $v;
          $this->modifiedColumns[] = ProductPeer::STOCK_MANAGMENT;
        }

	} // setStockManagment()

	/**
	 * Set the value of [dimension_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setDimensionId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->dimension_id !== $v) {
          $this->dimension_id = $v;
          $this->modifiedColumns[] = ProductPeer::DIMENSION_ID;
        }

		if ($this->aProductDimension !== null && $this->aProductDimension->getId() !== $v) {
			$this->aProductDimension = null;
		}

	} // setDimensionId()

	/**
	 * Set the value of [width] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setWidth($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->width !== $v || $v === 0) {
          $this->width = $v;
          $this->modifiedColumns[] = ProductPeer::WIDTH;
        }

	} // setWidth()

	/**
	 * Set the value of [height] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setHeight($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->height !== $v || $v === 0) {
          $this->height = $v;
          $this->modifiedColumns[] = ProductPeer::HEIGHT;
        }

	} // setHeight()

	/**
	 * Set the value of [depth] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setDepth($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->depth !== $v || $v === 0) {
          $this->depth = $v;
          $this->modifiedColumns[] = ProductPeer::DEPTH;
        }

	} // setDepth()

	/**
	 * Set the value of [opt_product_group] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptProductGroup($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_product_group !== $v) {
          $this->opt_product_group = $v;
          $this->modifiedColumns[] = ProductPeer::OPT_PRODUCT_GROUP;
        }

	} // setOptProductGroup()

	/**
	 * Set the value of [opt_execution_time] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptExecutionTime($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->opt_execution_time !== $v) {
          $this->opt_execution_time = $v;
          $this->modifiedColumns[] = ProductPeer::OPT_EXECUTION_TIME;
        }

	} // setOptExecutionTime()

	/**
	 * Set the value of [availability_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setAvailabilityId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->availability_id !== $v) {
          $this->availability_id = $v;
          $this->modifiedColumns[] = ProductPeer::AVAILABILITY_ID;
        }

		if ($this->aAvailability !== null && $this->aAvailability->getId() !== $v) {
			$this->aAvailability = null;
		}

	} // setAvailabilityId()

	/**
	 * Set the value of [weight] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setWeight($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->weight !== $v) {
          $this->weight = $v;
          $this->modifiedColumns[] = ProductPeer::WEIGHT;
        }

	} // setWeight()

	/**
	 * Set the value of [stock] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setStock($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->stock !== $v || $v === 1) {
          $this->stock = $v;
          $this->modifiedColumns[] = ProductPeer::STOCK;
        }

	} // setStock()

	/**
	 * Set the value of [max_discount] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setMaxDiscount($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->max_discount !== $v || $v === 100) {
          $this->max_discount = $v;
          $this->modifiedColumns[] = ProductPeer::MAX_DISCOUNT;
        }

	} // setMaxDiscount()

	/**
	 * Set the value of [mpn_code] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setMpnCode($v)
	{

        if ($v !== null && !is_string($v)) {
          $v = (string) $v;
        }

        if ($this->mpn_code !== $v) {
          $this->mpn_code = $v;
          $this->modifiedColumns[] = ProductPeer::MPN_CODE;
        }

	} // setMpnCode()

	/**
	 * Set the value of [group_price_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setGroupPriceId($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->group_price_id !== $v) {
          $this->group_price_id = $v;
          $this->modifiedColumns[] = ProductPeer::GROUP_PRICE_ID;
        }

		if ($this->aGroupPrice !== null && $this->aGroupPrice->getId() !== $v) {
			$this->aGroupPrice = null;
		}

	} // setGroupPriceId()

	/**
	 * Set the value of [opt_has_options] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOptHasOptions($v)
	{

        if ($v !== null && !is_int($v) && is_numeric($v)) {
          $v = (int) $v;
        }

        if ($this->opt_has_options !== $v) {
          $this->opt_has_options = $v;
          $this->modifiedColumns[] = ProductPeer::OPT_HAS_OPTIONS;
        }

	} // setOptHasOptions()

	/**
	 * Set the value of [options_color] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOptionsColor($v)
	{

        if ($this->options_color !== $v) {
          $this->options_color = $v;
          $this->modifiedColumns[] = ProductPeer::OPTIONS_COLOR;
        }

	} // setOptionsColor()

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
          $this->modifiedColumns[] = ProductPeer::TAX_ID;
        }

		if ($this->aTax !== null && $this->aTax->getId() !== $v) {
			$this->aTax = null;
		}

	} // setTaxId()

	/**
	 * Set the value of [wholesale_a_netto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setWholesaleANetto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->wholesale_a_netto !== $v || $v === 0) {
          $this->wholesale_a_netto = $v;
          $this->modifiedColumns[] = ProductPeer::WHOLESALE_A_NETTO;
        }

	} // setWholesaleANetto()

	/**
	 * Set the value of [wholesale_b_netto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setWholesaleBNetto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->wholesale_b_netto !== $v || $v === 0) {
          $this->wholesale_b_netto = $v;
          $this->modifiedColumns[] = ProductPeer::WHOLESALE_B_NETTO;
        }

	} // setWholesaleBNetto()

	/**
	 * Set the value of [wholesale_c_netto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setWholesaleCNetto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->wholesale_c_netto !== $v || $v === 0) {
          $this->wholesale_c_netto = $v;
          $this->modifiedColumns[] = ProductPeer::WHOLESALE_C_NETTO;
        }

	} // setWholesaleCNetto()

	/**
	 * Set the value of [wholesale_a_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setWholesaleABrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->wholesale_a_brutto !== $v || $v === 0) {
          $this->wholesale_a_brutto = $v;
          $this->modifiedColumns[] = ProductPeer::WHOLESALE_A_BRUTTO;
        }

	} // setWholesaleABrutto()

	/**
	 * Set the value of [wholesale_b_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setWholesaleBBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->wholesale_b_brutto !== $v || $v === 0) {
          $this->wholesale_b_brutto = $v;
          $this->modifiedColumns[] = ProductPeer::WHOLESALE_B_BRUTTO;
        }

	} // setWholesaleBBrutto()

	/**
	 * Set the value of [wholesale_c_brutto] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setWholesaleCBrutto($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->wholesale_c_brutto !== $v || $v === 0) {
          $this->wholesale_c_brutto = $v;
          $this->modifiedColumns[] = ProductPeer::WHOLESALE_C_BRUTTO;
        }

	} // setWholesaleCBrutto()

	/**
	 * Set the value of [currency_wholesale_a] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setCurrencyWholesaleA($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->currency_wholesale_a !== $v) {
          $this->currency_wholesale_a = $v;
          $this->modifiedColumns[] = ProductPeer::CURRENCY_WHOLESALE_A;
        }

	} // setCurrencyWholesaleA()

	/**
	 * Set the value of [currency_wholesale_b] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setCurrencyWholesaleB($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->currency_wholesale_b !== $v) {
          $this->currency_wholesale_b = $v;
          $this->modifiedColumns[] = ProductPeer::CURRENCY_WHOLESALE_B;
        }

	} // setCurrencyWholesaleB()

	/**
	 * Set the value of [currency_wholesale_c] column.
	 * 
	 * @param      double $v new value
	 * @return     void
	 */
	public function setCurrencyWholesaleC($v)
	{

        if ($v !== null && !is_float($v) && is_numeric($v)) {
          $v = (float) $v;
        }

        if ($this->currency_wholesale_c !== $v) {
          $this->currency_wholesale_c = $v;
          $this->modifiedColumns[] = ProductPeer::CURRENCY_WHOLESALE_C;
        }

	} // setCurrencyWholesaleC()

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
      if ($this->getDispatcher()->getListeners('Product.preHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Product.preHydrate', array('resultset' => $rs, 'startcol' => $startcol)));
          $startcol = $event['startcol'];
      }

      $this->created_at = $rs->getTimestamp($startcol + 0, null);

      $this->updated_at = $rs->getTimestamp($startcol + 1, null);

      $this->id = $rs->getInt($startcol + 2);

      $this->parent_id = $rs->getInt($startcol + 3);

      $this->currency_id = $rs->getInt($startcol + 4);

      $this->producer_id = $rs->getInt($startcol + 5);

      $this->code = $rs->getString($startcol + 6);

      $this->price = $rs->getString($startcol + 7);
      if (null !== $this->price && $this->price == intval($this->price))
      {
        $this->price = (string)intval($this->price);
      }

      $this->opt_price_brutto = $rs->getString($startcol + 8);
      if (null !== $this->opt_price_brutto && $this->opt_price_brutto == intval($this->opt_price_brutto))
      {
        $this->opt_price_brutto = (string)intval($this->opt_price_brutto);
      }

      $this->delivery_price = $rs->getString($startcol + 9);
      if (null !== $this->delivery_price && $this->delivery_price == intval($this->delivery_price))
      {
        $this->delivery_price = (string)intval($this->delivery_price);
      }

      $this->bpum_default_id = $rs->getInt($startcol + 10);

      $this->bpum_default_value = $rs->getString($startcol + 11);
      if (null !== $this->bpum_default_value && $this->bpum_default_value == intval($this->bpum_default_value))
      {
        $this->bpum_default_value = (string)intval($this->bpum_default_value);
      }

      $this->bpum_id = $rs->getInt($startcol + 12);

      $this->bpum_value = $rs->getString($startcol + 13);
      if (null !== $this->bpum_value && $this->bpum_value == intval($this->bpum_value))
      {
        $this->bpum_value = (string)intval($this->bpum_value);
      }

      $this->currency_price = $rs->getString($startcol + 14);
      if (null !== $this->currency_price && $this->currency_price == intval($this->currency_price))
      {
        $this->currency_price = (string)intval($this->currency_price);
      }

      $this->old_price = $rs->getString($startcol + 15);
      if (null !== $this->old_price && $this->old_price == intval($this->old_price))
      {
        $this->old_price = (string)intval($this->old_price);
      }

      $this->opt_old_price_brutto = $rs->getString($startcol + 16);
      if (null !== $this->opt_old_price_brutto && $this->opt_old_price_brutto == intval($this->opt_old_price_brutto))
      {
        $this->opt_old_price_brutto = (string)intval($this->opt_old_price_brutto);
      }

      $this->points_value = $rs->getInt($startcol + 17);

      $this->points_earn = $rs->getInt($startcol + 18);

      $this->points_only = $rs->getBoolean($startcol + 19);

      $this->currency_old_price = $rs->getString($startcol + 20);
      if (null !== $this->currency_old_price && $this->currency_old_price == intval($this->currency_old_price))
      {
        $this->currency_old_price = (string)intval($this->currency_old_price);
      }

      $this->opt_vat = $rs->getString($startcol + 21);
      if (null !== $this->opt_vat && $this->opt_vat == intval($this->opt_vat))
      {
        $this->opt_vat = (string)intval($this->opt_vat);
      }

      $this->currency_exchange = $rs->getString($startcol + 22);
      if (null !== $this->currency_exchange && $this->currency_exchange == intval($this->currency_exchange))
      {
        $this->currency_exchange = (string)intval($this->currency_exchange);
      }

      $this->active = $rs->getBoolean($startcol + 23);

      $this->hide_price = $rs->getInt($startcol + 24);

      $this->has_fixed_currency = $rs->getBoolean($startcol + 25);

      $this->opt_image = $rs->getString($startcol + 26);

      $this->opt_name = $rs->getString($startcol + 27);

      $this->opt_short_description = $rs->getString($startcol + 28);

      $this->opt_description = $rs->getString($startcol + 29);

      $this->opt_url = $rs->getString($startcol + 30);

      $this->opt_asset_folder = $rs->getString($startcol + 31);

      $this->opt_uom = $rs->getString($startcol + 32);

      $this->deliveries = $rs->getString($startcol + 33) ? unserialize($rs->getString($startcol + 33)) : null;

      $this->min_qty = $rs->getString($startcol + 34);
      if (null !== $this->min_qty && $this->min_qty == intval($this->min_qty))
      {
        $this->min_qty = (string)intval($this->min_qty);
      }

      $this->max_qty = $rs->getString($startcol + 35);
      if (null !== $this->max_qty && $this->max_qty == intval($this->max_qty))
      {
        $this->max_qty = (string)intval($this->max_qty);
      }

      $this->step_qty = $rs->getString($startcol + 36);
      if (null !== $this->step_qty && $this->step_qty == intval($this->step_qty))
      {
        $this->step_qty = (string)intval($this->step_qty);
      }

      $this->is_stock_validated = $rs->getBoolean($startcol + 37);

      $this->is_gift = $rs->getInt($startcol + 38);

      $this->is_service = $rs->getBoolean($startcol + 39);

      $this->stock_in_decimals = $rs->getInt($startcol + 40);

      $this->man_code = $rs->getString($startcol + 41);

      $this->main_page_order = $rs->getInt($startcol + 42);

      $this->priority = $rs->getInt($startcol + 43);

      $this->stock_managment = $rs->getInt($startcol + 44);

      $this->dimension_id = $rs->getInt($startcol + 45);

      $this->width = $rs->getFloat($startcol + 46);

      $this->height = $rs->getFloat($startcol + 47);

      $this->depth = $rs->getFloat($startcol + 48);

      $this->opt_product_group = $rs->getString($startcol + 49);

      $this->opt_execution_time = $rs->getString($startcol + 50);

      $this->availability_id = $rs->getInt($startcol + 51);

      $this->weight = $rs->getFloat($startcol + 52);

      $this->stock = $rs->getString($startcol + 53);
      if (null !== $this->stock && $this->stock == intval($this->stock))
      {
        $this->stock = (string)intval($this->stock);
      }

      $this->max_discount = $rs->getFloat($startcol + 54);

      $this->mpn_code = $rs->getString($startcol + 55);

      $this->group_price_id = $rs->getInt($startcol + 56);

      $this->opt_has_options = $rs->getInt($startcol + 57);

      $this->options_color = $rs->getString($startcol + 58) ? unserialize($rs->getString($startcol + 58)) : null;

      $this->tax_id = $rs->getInt($startcol + 59);

      $this->wholesale_a_netto = $rs->getString($startcol + 60);
      if (null !== $this->wholesale_a_netto && $this->wholesale_a_netto == intval($this->wholesale_a_netto))
      {
        $this->wholesale_a_netto = (string)intval($this->wholesale_a_netto);
      }

      $this->wholesale_b_netto = $rs->getString($startcol + 61);
      if (null !== $this->wholesale_b_netto && $this->wholesale_b_netto == intval($this->wholesale_b_netto))
      {
        $this->wholesale_b_netto = (string)intval($this->wholesale_b_netto);
      }

      $this->wholesale_c_netto = $rs->getString($startcol + 62);
      if (null !== $this->wholesale_c_netto && $this->wholesale_c_netto == intval($this->wholesale_c_netto))
      {
        $this->wholesale_c_netto = (string)intval($this->wholesale_c_netto);
      }

      $this->wholesale_a_brutto = $rs->getString($startcol + 63);
      if (null !== $this->wholesale_a_brutto && $this->wholesale_a_brutto == intval($this->wholesale_a_brutto))
      {
        $this->wholesale_a_brutto = (string)intval($this->wholesale_a_brutto);
      }

      $this->wholesale_b_brutto = $rs->getString($startcol + 64);
      if (null !== $this->wholesale_b_brutto && $this->wholesale_b_brutto == intval($this->wholesale_b_brutto))
      {
        $this->wholesale_b_brutto = (string)intval($this->wholesale_b_brutto);
      }

      $this->wholesale_c_brutto = $rs->getString($startcol + 65);
      if (null !== $this->wholesale_c_brutto && $this->wholesale_c_brutto == intval($this->wholesale_c_brutto))
      {
        $this->wholesale_c_brutto = (string)intval($this->wholesale_c_brutto);
      }

      $this->currency_wholesale_a = $rs->getString($startcol + 66);
      if (null !== $this->currency_wholesale_a && $this->currency_wholesale_a == intval($this->currency_wholesale_a))
      {
        $this->currency_wholesale_a = (string)intval($this->currency_wholesale_a);
      }

      $this->currency_wholesale_b = $rs->getString($startcol + 67);
      if (null !== $this->currency_wholesale_b && $this->currency_wholesale_b == intval($this->currency_wholesale_b))
      {
        $this->currency_wholesale_b = (string)intval($this->currency_wholesale_b);
      }

      $this->currency_wholesale_c = $rs->getString($startcol + 68);
      if (null !== $this->currency_wholesale_c && $this->currency_wholesale_c == intval($this->currency_wholesale_c))
      {
        $this->currency_wholesale_c = (string)intval($this->currency_wholesale_c);
      }

      $this->resetModified();

      $this->setNew(false);
      if ($this->getDispatcher()->getListeners('Product.postHydrate')) {
          $event = $this->getDispatcher()->notify(new sfEvent($this, 'Product.postHydrate', array('resultset' => $rs, 'startcol' => $startcol + 69)));
          return $event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return $startcol + 69; // 69 = ProductPeer::NUM_COLUMNS - ProductPeer::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception $e) {
      throw new PropelException("Error populating Product object", $e);
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

    if ($this->getDispatcher()->getListeners('Product.preDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Product.preDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProduct:delete:pre'))
    {
      foreach (sfMixer::getCallables('BaseProduct:delete:pre') as $callable)
      {
        $ret = call_user_func($callable, $this, $con);
        if ($ret)
        {
          return;
        }
      }
    }

    if ($con === null) {
      $con = Propel::getConnection(ProductPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      ProductPeer::doDelete($this, $con);
      $this->setDeleted(true);
      $con->commit();
    } catch (PropelException $e) {
      $con->rollback();
      throw $e;
    }

    if ($this->getDispatcher()->getListeners('Product.postDelete')) {
        $this->getDispatcher()->notify(new sfEvent($this, 'Product.postDelete', array('con' => $con)));
    }

    if (sfMixer::hasCallables('BaseProduct:delete:post'))
    {
      foreach (sfMixer::getCallables('BaseProduct:delete:post') as $callable)
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
      if ($this->getDispatcher()->getListeners('Product.preSave')) {
          $this->getDispatcher()->notify(new sfEvent($this, 'Product.preSave', array('con' => $con)));
      }

      foreach (sfMixer::getCallables('BaseProduct:save:pre') as $callable)
      {
        $affectedRows = call_user_func($callable, $this, $con);
        if (is_int($affectedRows))
        {
          return $affectedRows;
        }
      }
    }

    
    if ($this->isNew() && !$this->isColumnModified(ProductPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ProductPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }


    if ($con === null) {
      $con = Propel::getConnection(ProductPeer::DATABASE_NAME);
    }

    try {
      $con->begin();
      $affectedRows = $this->doSave($con);
      $con->commit();

      if (!$this->alreadyInSave) {
        if ($this->getDispatcher()->getListeners('Product.postSave')) {
            $this->getDispatcher()->notify(new sfEvent($this, 'Product.postSave', array('con' => $con)));
        }
     
        foreach (sfMixer::getCallables('BaseProduct:save:post') as $callable)
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

			if ($this->aProductRelatedByParentId !== null) {
				if ($this->aProductRelatedByParentId->isModified() || $this->aProductRelatedByParentId->getCurrentProductI18n()->isModified()) {
					$affectedRows += $this->aProductRelatedByParentId->save($con);
				}
				$this->setProductRelatedByParentId($this->aProductRelatedByParentId);
			}

			if ($this->aCurrency !== null) {
				if ($this->aCurrency->isModified() || $this->aCurrency->getCurrentCurrencyI18n()->isModified()) {
					$affectedRows += $this->aCurrency->save($con);
				}
				$this->setCurrency($this->aCurrency);
			}

			if ($this->aProducer !== null) {
				if ($this->aProducer->isModified() || $this->aProducer->getCurrentProducerI18n()->isModified()) {
					$affectedRows += $this->aProducer->save($con);
				}
				$this->setProducer($this->aProducer);
			}

			if ($this->aBasicPriceUnitMeasureRelatedByBpumDefaultId !== null) {
				if ($this->aBasicPriceUnitMeasureRelatedByBpumDefaultId->isModified()) {
					$affectedRows += $this->aBasicPriceUnitMeasureRelatedByBpumDefaultId->save($con);
				}
				$this->setBasicPriceUnitMeasureRelatedByBpumDefaultId($this->aBasicPriceUnitMeasureRelatedByBpumDefaultId);
			}

			if ($this->aBasicPriceUnitMeasureRelatedByBpumId !== null) {
				if ($this->aBasicPriceUnitMeasureRelatedByBpumId->isModified()) {
					$affectedRows += $this->aBasicPriceUnitMeasureRelatedByBpumId->save($con);
				}
				$this->setBasicPriceUnitMeasureRelatedByBpumId($this->aBasicPriceUnitMeasureRelatedByBpumId);
			}

			if ($this->aProductDimension !== null) {
				if ($this->aProductDimension->isModified()) {
					$affectedRows += $this->aProductDimension->save($con);
				}
				$this->setProductDimension($this->aProductDimension);
			}

			if ($this->aAvailability !== null) {
				if ($this->aAvailability->isModified() || $this->aAvailability->getCurrentAvailabilityI18n()->isModified()) {
					$affectedRows += $this->aAvailability->save($con);
				}
				$this->setAvailability($this->aAvailability);
			}

			if ($this->aGroupPrice !== null) {
				if ($this->aGroupPrice->isModified()) {
					$affectedRows += $this->aGroupPrice->save($con);
				}
				$this->setGroupPrice($this->aGroupPrice);
			}

			if ($this->aTax !== null) {
				if ($this->aTax->isModified()) {
					$affectedRows += $this->aTax->save($con);
				}
				$this->setTax($this->aTax);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
              $o_deliveries = $this->deliveries;
              if (null !== $this->deliveries && $this->isColumnModified(ProductPeer::DELIVERIES)) {
                  $this->deliveries = serialize($this->deliveries);
              }

              $o_options_color = $this->options_color;
              if (null !== $this->options_color && $this->isColumnModified(ProductPeer::OPTIONS_COLOR)) {
                  $this->options_color = serialize($this->options_color);
              }

				if ($this->isNew()) {
					$pk = ProductPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ProductPeer::doUpdate($this, $con);
				}
				$this->resetModified();
             $this->deliveries = $o_deliveries;

             $this->options_color = $o_options_color;
 // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collProductHasWholesales !== null) {
				foreach($this->collProductHasWholesales as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collHandelos !== null) {
				foreach($this->collHandelos as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGoogleShoppings !== null) {
				foreach($this->collGoogleShoppings as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductHasAttributeFields !== null) {
				foreach($this->collProductHasAttributeFields as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAllegroAuctions !== null) {
				foreach($this->collAllegroAuctions as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collCrossellingsRelatedByFirstProductId !== null) {
				foreach($this->collCrossellingsRelatedByFirstProductId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collCrossellingsRelatedBySecoundProductId !== null) {
				foreach($this->collCrossellingsRelatedBySecoundProductId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLukasProducts !== null) {
				foreach($this->collLukasProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDiscounts !== null) {
				foreach($this->collDiscounts as $referrerFK) {
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

			if ($this->collDiscountCouponCodeHasProducts !== null) {
				foreach($this->collDiscountCouponCodeHasProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductsRelatedByParentId !== null) {
				foreach($this->collProductsRelatedByParentId as $referrerFK) {
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

			if ($this->collProductHasSfAssets !== null) {
				foreach($this->collProductHasSfAssets as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductHasAttachments !== null) {
				foreach($this->collProductHasAttachments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductHasRecommendsRelatedByRecommendId !== null) {
				foreach($this->collProductHasRecommendsRelatedByRecommendId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductHasRecommendsRelatedByProductId !== null) {
				foreach($this->collProductHasRecommendsRelatedByProductId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductI18ns !== null) {
				foreach($this->collProductI18ns as $referrerFK) {
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

			if ($this->collOnlineCodess !== null) {
				foreach($this->collOnlineCodess as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOnlineFiless !== null) {
				foreach($this->collOnlineFiless as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collBazzars !== null) {
				foreach($this->collBazzars as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTrusts !== null) {
				foreach($this->collTrusts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collRadars !== null) {
				foreach($this->collRadars as $referrerFK) {
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

			if ($this->collOrderProductHasSets !== null) {
				foreach($this->collOrderProductHasSets as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collCeneos !== null) {
				foreach($this->collCeneos as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGiftCardHasProducts !== null) {
				foreach($this->collGiftCardHasProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collReviews !== null) {
				foreach($this->collReviews as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collappProductAttributeVariantHasProducts !== null) {
				foreach($this->collappProductAttributeVariantHasProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOnets !== null) {
				foreach($this->collOnets as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collZakupomats !== null) {
				foreach($this->collZakupomats as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOkazjes !== null) {
				foreach($this->collOkazjes as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductOptionsValues !== null) {
				foreach($this->collProductOptionsValues as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductSearchIndexs !== null) {
				foreach($this->collProductSearchIndexs as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductHasProductSearchTags !== null) {
				foreach($this->collProductHasProductSearchTags as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collBasketProducts !== null) {
				foreach($this->collBasketProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collInvoiceProducts !== null) {
				foreach($this->collInvoiceProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOferciaks !== null) {
				foreach($this->collOferciaks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductHasAccessoriessRelatedByAccessoriesId !== null) {
				foreach($this->collProductHasAccessoriessRelatedByAccessoriesId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductHasAccessoriessRelatedByProductId !== null) {
				foreach($this->collProductHasAccessoriessRelatedByProductId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collWps !== null) {
				foreach($this->collWps as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collNokauts !== null) {
				foreach($this->collNokauts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductHasPositionings !== null) {
				foreach($this->collProductHasPositionings as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collSklepy24s !== null) {
				foreach($this->collSklepy24s as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collProductGroupHasProducts !== null) {
				foreach($this->collProductGroupHasProducts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collQuestionss !== null) {
				foreach($this->collQuestionss as $referrerFK) {
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

			if ($this->aProductRelatedByParentId !== null) {
				if (!$this->aProductRelatedByParentId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProductRelatedByParentId->getValidationFailures());
				}
			}

			if ($this->aCurrency !== null) {
				if (!$this->aCurrency->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCurrency->getValidationFailures());
				}
			}

			if ($this->aProducer !== null) {
				if (!$this->aProducer->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProducer->getValidationFailures());
				}
			}

			if ($this->aBasicPriceUnitMeasureRelatedByBpumDefaultId !== null) {
				if (!$this->aBasicPriceUnitMeasureRelatedByBpumDefaultId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aBasicPriceUnitMeasureRelatedByBpumDefaultId->getValidationFailures());
				}
			}

			if ($this->aBasicPriceUnitMeasureRelatedByBpumId !== null) {
				if (!$this->aBasicPriceUnitMeasureRelatedByBpumId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aBasicPriceUnitMeasureRelatedByBpumId->getValidationFailures());
				}
			}

			if ($this->aProductDimension !== null) {
				if (!$this->aProductDimension->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProductDimension->getValidationFailures());
				}
			}

			if ($this->aAvailability !== null) {
				if (!$this->aAvailability->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aAvailability->getValidationFailures());
				}
			}

			if ($this->aGroupPrice !== null) {
				if (!$this->aGroupPrice->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aGroupPrice->getValidationFailures());
				}
			}

			if ($this->aTax !== null) {
				if (!$this->aTax->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTax->getValidationFailures());
				}
			}


			if (($retval = ProductPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collProductHasWholesales !== null) {
					foreach($this->collProductHasWholesales as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collHandelos !== null) {
					foreach($this->collHandelos as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGoogleShoppings !== null) {
					foreach($this->collGoogleShoppings as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductHasAttributeFields !== null) {
					foreach($this->collProductHasAttributeFields as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAllegroAuctions !== null) {
					foreach($this->collAllegroAuctions as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collCrossellingsRelatedByFirstProductId !== null) {
					foreach($this->collCrossellingsRelatedByFirstProductId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collCrossellingsRelatedBySecoundProductId !== null) {
					foreach($this->collCrossellingsRelatedBySecoundProductId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLukasProducts !== null) {
					foreach($this->collLukasProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDiscounts !== null) {
					foreach($this->collDiscounts as $referrerFK) {
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

				if ($this->collDiscountCouponCodeHasProducts !== null) {
					foreach($this->collDiscountCouponCodeHasProducts as $referrerFK) {
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

				if ($this->collProductHasSfAssets !== null) {
					foreach($this->collProductHasSfAssets as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductHasAttachments !== null) {
					foreach($this->collProductHasAttachments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductHasRecommendsRelatedByRecommendId !== null) {
					foreach($this->collProductHasRecommendsRelatedByRecommendId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductHasRecommendsRelatedByProductId !== null) {
					foreach($this->collProductHasRecommendsRelatedByProductId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductI18ns !== null) {
					foreach($this->collProductI18ns as $referrerFK) {
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

				if ($this->collOnlineCodess !== null) {
					foreach($this->collOnlineCodess as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOnlineFiless !== null) {
					foreach($this->collOnlineFiless as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collBazzars !== null) {
					foreach($this->collBazzars as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTrusts !== null) {
					foreach($this->collTrusts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRadars !== null) {
					foreach($this->collRadars as $referrerFK) {
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

				if ($this->collOrderProductHasSets !== null) {
					foreach($this->collOrderProductHasSets as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collCeneos !== null) {
					foreach($this->collCeneos as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGiftCardHasProducts !== null) {
					foreach($this->collGiftCardHasProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collReviews !== null) {
					foreach($this->collReviews as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collappProductAttributeVariantHasProducts !== null) {
					foreach($this->collappProductAttributeVariantHasProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOnets !== null) {
					foreach($this->collOnets as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collZakupomats !== null) {
					foreach($this->collZakupomats as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOkazjes !== null) {
					foreach($this->collOkazjes as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductOptionsValues !== null) {
					foreach($this->collProductOptionsValues as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductSearchIndexs !== null) {
					foreach($this->collProductSearchIndexs as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductHasProductSearchTags !== null) {
					foreach($this->collProductHasProductSearchTags as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collBasketProducts !== null) {
					foreach($this->collBasketProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collInvoiceProducts !== null) {
					foreach($this->collInvoiceProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOferciaks !== null) {
					foreach($this->collOferciaks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductHasAccessoriessRelatedByAccessoriesId !== null) {
					foreach($this->collProductHasAccessoriessRelatedByAccessoriesId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductHasAccessoriessRelatedByProductId !== null) {
					foreach($this->collProductHasAccessoriessRelatedByProductId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collWps !== null) {
					foreach($this->collWps as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collNokauts !== null) {
					foreach($this->collNokauts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductHasPositionings !== null) {
					foreach($this->collProductHasPositionings as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collSklepy24s !== null) {
					foreach($this->collSklepy24s as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collProductGroupHasProducts !== null) {
					foreach($this->collProductGroupHasProducts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collQuestionss !== null) {
					foreach($this->collQuestionss as $referrerFK) {
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
		$pos = ProductPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getParentId();
				break;
			case 4:
				return $this->getCurrencyId();
				break;
			case 5:
				return $this->getProducerId();
				break;
			case 6:
				return $this->getCode();
				break;
			case 7:
				return $this->getPrice();
				break;
			case 8:
				return $this->getOptPriceBrutto();
				break;
			case 9:
				return $this->getDeliveryPrice();
				break;
			case 10:
				return $this->getBpumDefaultId();
				break;
			case 11:
				return $this->getBpumDefaultValue();
				break;
			case 12:
				return $this->getBpumId();
				break;
			case 13:
				return $this->getBpumValue();
				break;
			case 14:
				return $this->getCurrencyPrice();
				break;
			case 15:
				return $this->getOldPrice();
				break;
			case 16:
				return $this->getOptOldPriceBrutto();
				break;
			case 17:
				return $this->getPointsValue();
				break;
			case 18:
				return $this->getPointsEarn();
				break;
			case 19:
				return $this->getPointsOnly();
				break;
			case 20:
				return $this->getCurrencyOldPrice();
				break;
			case 21:
				return $this->getOptVat();
				break;
			case 22:
				return $this->getCurrencyExchange();
				break;
			case 23:
				return $this->getActive();
				break;
			case 24:
				return $this->getHidePrice();
				break;
			case 25:
				return $this->getHasFixedCurrency();
				break;
			case 26:
				return $this->getOptImage();
				break;
			case 27:
				return $this->getOptName();
				break;
			case 28:
				return $this->getOptShortDescription();
				break;
			case 29:
				return $this->getOptDescription();
				break;
			case 30:
				return $this->getOptUrl();
				break;
			case 31:
				return $this->getOptAssetFolder();
				break;
			case 32:
				return $this->getOptUom();
				break;
			case 33:
				return $this->getDeliveries();
				break;
			case 34:
				return $this->getMinQty();
				break;
			case 35:
				return $this->getMaxQty();
				break;
			case 36:
				return $this->getStepQty();
				break;
			case 37:
				return $this->getIsStockValidated();
				break;
			case 38:
				return $this->getIsGift();
				break;
			case 39:
				return $this->getIsService();
				break;
			case 40:
				return $this->getStockInDecimals();
				break;
			case 41:
				return $this->getManCode();
				break;
			case 42:
				return $this->getMainPageOrder();
				break;
			case 43:
				return $this->getPriority();
				break;
			case 44:
				return $this->getStockManagment();
				break;
			case 45:
				return $this->getDimensionId();
				break;
			case 46:
				return $this->getWidth();
				break;
			case 47:
				return $this->getHeight();
				break;
			case 48:
				return $this->getDepth();
				break;
			case 49:
				return $this->getOptProductGroup();
				break;
			case 50:
				return $this->getOptExecutionTime();
				break;
			case 51:
				return $this->getAvailabilityId();
				break;
			case 52:
				return $this->getWeight();
				break;
			case 53:
				return $this->getStock();
				break;
			case 54:
				return $this->getMaxDiscount();
				break;
			case 55:
				return $this->getMpnCode();
				break;
			case 56:
				return $this->getGroupPriceId();
				break;
			case 57:
				return $this->getOptHasOptions();
				break;
			case 58:
				return $this->getOptionsColor();
				break;
			case 59:
				return $this->getTaxId();
				break;
			case 60:
				return $this->getWholesaleANetto();
				break;
			case 61:
				return $this->getWholesaleBNetto();
				break;
			case 62:
				return $this->getWholesaleCNetto();
				break;
			case 63:
				return $this->getWholesaleABrutto();
				break;
			case 64:
				return $this->getWholesaleBBrutto();
				break;
			case 65:
				return $this->getWholesaleCBrutto();
				break;
			case 66:
				return $this->getCurrencyWholesaleA();
				break;
			case 67:
				return $this->getCurrencyWholesaleB();
				break;
			case 68:
				return $this->getCurrencyWholesaleC();
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
		$keys = ProductPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getUpdatedAt(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getParentId(),
			$keys[4] => $this->getCurrencyId(),
			$keys[5] => $this->getProducerId(),
			$keys[6] => $this->getCode(),
			$keys[7] => $this->getPrice(),
			$keys[8] => $this->getOptPriceBrutto(),
			$keys[9] => $this->getDeliveryPrice(),
			$keys[10] => $this->getBpumDefaultId(),
			$keys[11] => $this->getBpumDefaultValue(),
			$keys[12] => $this->getBpumId(),
			$keys[13] => $this->getBpumValue(),
			$keys[14] => $this->getCurrencyPrice(),
			$keys[15] => $this->getOldPrice(),
			$keys[16] => $this->getOptOldPriceBrutto(),
			$keys[17] => $this->getPointsValue(),
			$keys[18] => $this->getPointsEarn(),
			$keys[19] => $this->getPointsOnly(),
			$keys[20] => $this->getCurrencyOldPrice(),
			$keys[21] => $this->getOptVat(),
			$keys[22] => $this->getCurrencyExchange(),
			$keys[23] => $this->getActive(),
			$keys[24] => $this->getHidePrice(),
			$keys[25] => $this->getHasFixedCurrency(),
			$keys[26] => $this->getOptImage(),
			$keys[27] => $this->getOptName(),
			$keys[28] => $this->getOptShortDescription(),
			$keys[29] => $this->getOptDescription(),
			$keys[30] => $this->getOptUrl(),
			$keys[31] => $this->getOptAssetFolder(),
			$keys[32] => $this->getOptUom(),
			$keys[33] => $this->getDeliveries(),
			$keys[34] => $this->getMinQty(),
			$keys[35] => $this->getMaxQty(),
			$keys[36] => $this->getStepQty(),
			$keys[37] => $this->getIsStockValidated(),
			$keys[38] => $this->getIsGift(),
			$keys[39] => $this->getIsService(),
			$keys[40] => $this->getStockInDecimals(),
			$keys[41] => $this->getManCode(),
			$keys[42] => $this->getMainPageOrder(),
			$keys[43] => $this->getPriority(),
			$keys[44] => $this->getStockManagment(),
			$keys[45] => $this->getDimensionId(),
			$keys[46] => $this->getWidth(),
			$keys[47] => $this->getHeight(),
			$keys[48] => $this->getDepth(),
			$keys[49] => $this->getOptProductGroup(),
			$keys[50] => $this->getOptExecutionTime(),
			$keys[51] => $this->getAvailabilityId(),
			$keys[52] => $this->getWeight(),
			$keys[53] => $this->getStock(),
			$keys[54] => $this->getMaxDiscount(),
			$keys[55] => $this->getMpnCode(),
			$keys[56] => $this->getGroupPriceId(),
			$keys[57] => $this->getOptHasOptions(),
			$keys[58] => $this->getOptionsColor(),
			$keys[59] => $this->getTaxId(),
			$keys[60] => $this->getWholesaleANetto(),
			$keys[61] => $this->getWholesaleBNetto(),
			$keys[62] => $this->getWholesaleCNetto(),
			$keys[63] => $this->getWholesaleABrutto(),
			$keys[64] => $this->getWholesaleBBrutto(),
			$keys[65] => $this->getWholesaleCBrutto(),
			$keys[66] => $this->getCurrencyWholesaleA(),
			$keys[67] => $this->getCurrencyWholesaleB(),
			$keys[68] => $this->getCurrencyWholesaleC(),
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
		$pos = ProductPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setParentId($value);
				break;
			case 4:
				$this->setCurrencyId($value);
				break;
			case 5:
				$this->setProducerId($value);
				break;
			case 6:
				$this->setCode($value);
				break;
			case 7:
				$this->setPrice($value);
				break;
			case 8:
				$this->setOptPriceBrutto($value);
				break;
			case 9:
				$this->setDeliveryPrice($value);
				break;
			case 10:
				$this->setBpumDefaultId($value);
				break;
			case 11:
				$this->setBpumDefaultValue($value);
				break;
			case 12:
				$this->setBpumId($value);
				break;
			case 13:
				$this->setBpumValue($value);
				break;
			case 14:
				$this->setCurrencyPrice($value);
				break;
			case 15:
				$this->setOldPrice($value);
				break;
			case 16:
				$this->setOptOldPriceBrutto($value);
				break;
			case 17:
				$this->setPointsValue($value);
				break;
			case 18:
				$this->setPointsEarn($value);
				break;
			case 19:
				$this->setPointsOnly($value);
				break;
			case 20:
				$this->setCurrencyOldPrice($value);
				break;
			case 21:
				$this->setOptVat($value);
				break;
			case 22:
				$this->setCurrencyExchange($value);
				break;
			case 23:
				$this->setActive($value);
				break;
			case 24:
				$this->setHidePrice($value);
				break;
			case 25:
				$this->setHasFixedCurrency($value);
				break;
			case 26:
				$this->setOptImage($value);
				break;
			case 27:
				$this->setOptName($value);
				break;
			case 28:
				$this->setOptShortDescription($value);
				break;
			case 29:
				$this->setOptDescription($value);
				break;
			case 30:
				$this->setOptUrl($value);
				break;
			case 31:
				$this->setOptAssetFolder($value);
				break;
			case 32:
				$this->setOptUom($value);
				break;
			case 33:
				$this->setDeliveries($value);
				break;
			case 34:
				$this->setMinQty($value);
				break;
			case 35:
				$this->setMaxQty($value);
				break;
			case 36:
				$this->setStepQty($value);
				break;
			case 37:
				$this->setIsStockValidated($value);
				break;
			case 38:
				$this->setIsGift($value);
				break;
			case 39:
				$this->setIsService($value);
				break;
			case 40:
				$this->setStockInDecimals($value);
				break;
			case 41:
				$this->setManCode($value);
				break;
			case 42:
				$this->setMainPageOrder($value);
				break;
			case 43:
				$this->setPriority($value);
				break;
			case 44:
				$this->setStockManagment($value);
				break;
			case 45:
				$this->setDimensionId($value);
				break;
			case 46:
				$this->setWidth($value);
				break;
			case 47:
				$this->setHeight($value);
				break;
			case 48:
				$this->setDepth($value);
				break;
			case 49:
				$this->setOptProductGroup($value);
				break;
			case 50:
				$this->setOptExecutionTime($value);
				break;
			case 51:
				$this->setAvailabilityId($value);
				break;
			case 52:
				$this->setWeight($value);
				break;
			case 53:
				$this->setStock($value);
				break;
			case 54:
				$this->setMaxDiscount($value);
				break;
			case 55:
				$this->setMpnCode($value);
				break;
			case 56:
				$this->setGroupPriceId($value);
				break;
			case 57:
				$this->setOptHasOptions($value);
				break;
			case 58:
				$this->setOptionsColor($value);
				break;
			case 59:
				$this->setTaxId($value);
				break;
			case 60:
				$this->setWholesaleANetto($value);
				break;
			case 61:
				$this->setWholesaleBNetto($value);
				break;
			case 62:
				$this->setWholesaleCNetto($value);
				break;
			case 63:
				$this->setWholesaleABrutto($value);
				break;
			case 64:
				$this->setWholesaleBBrutto($value);
				break;
			case 65:
				$this->setWholesaleCBrutto($value);
				break;
			case 66:
				$this->setCurrencyWholesaleA($value);
				break;
			case 67:
				$this->setCurrencyWholesaleB($value);
				break;
			case 68:
				$this->setCurrencyWholesaleC($value);
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
		$keys = ProductPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUpdatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setParentId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCurrencyId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setProducerId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCode($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPrice($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setOptPriceBrutto($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setDeliveryPrice($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setBpumDefaultId($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setBpumDefaultValue($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setBpumId($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setBpumValue($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setCurrencyPrice($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setOldPrice($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setOptOldPriceBrutto($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setPointsValue($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setPointsEarn($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setPointsOnly($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setCurrencyOldPrice($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setOptVat($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setCurrencyExchange($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setActive($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setHidePrice($arr[$keys[24]]);
		if (array_key_exists($keys[25], $arr)) $this->setHasFixedCurrency($arr[$keys[25]]);
		if (array_key_exists($keys[26], $arr)) $this->setOptImage($arr[$keys[26]]);
		if (array_key_exists($keys[27], $arr)) $this->setOptName($arr[$keys[27]]);
		if (array_key_exists($keys[28], $arr)) $this->setOptShortDescription($arr[$keys[28]]);
		if (array_key_exists($keys[29], $arr)) $this->setOptDescription($arr[$keys[29]]);
		if (array_key_exists($keys[30], $arr)) $this->setOptUrl($arr[$keys[30]]);
		if (array_key_exists($keys[31], $arr)) $this->setOptAssetFolder($arr[$keys[31]]);
		if (array_key_exists($keys[32], $arr)) $this->setOptUom($arr[$keys[32]]);
		if (array_key_exists($keys[33], $arr)) $this->setDeliveries($arr[$keys[33]]);
		if (array_key_exists($keys[34], $arr)) $this->setMinQty($arr[$keys[34]]);
		if (array_key_exists($keys[35], $arr)) $this->setMaxQty($arr[$keys[35]]);
		if (array_key_exists($keys[36], $arr)) $this->setStepQty($arr[$keys[36]]);
		if (array_key_exists($keys[37], $arr)) $this->setIsStockValidated($arr[$keys[37]]);
		if (array_key_exists($keys[38], $arr)) $this->setIsGift($arr[$keys[38]]);
		if (array_key_exists($keys[39], $arr)) $this->setIsService($arr[$keys[39]]);
		if (array_key_exists($keys[40], $arr)) $this->setStockInDecimals($arr[$keys[40]]);
		if (array_key_exists($keys[41], $arr)) $this->setManCode($arr[$keys[41]]);
		if (array_key_exists($keys[42], $arr)) $this->setMainPageOrder($arr[$keys[42]]);
		if (array_key_exists($keys[43], $arr)) $this->setPriority($arr[$keys[43]]);
		if (array_key_exists($keys[44], $arr)) $this->setStockManagment($arr[$keys[44]]);
		if (array_key_exists($keys[45], $arr)) $this->setDimensionId($arr[$keys[45]]);
		if (array_key_exists($keys[46], $arr)) $this->setWidth($arr[$keys[46]]);
		if (array_key_exists($keys[47], $arr)) $this->setHeight($arr[$keys[47]]);
		if (array_key_exists($keys[48], $arr)) $this->setDepth($arr[$keys[48]]);
		if (array_key_exists($keys[49], $arr)) $this->setOptProductGroup($arr[$keys[49]]);
		if (array_key_exists($keys[50], $arr)) $this->setOptExecutionTime($arr[$keys[50]]);
		if (array_key_exists($keys[51], $arr)) $this->setAvailabilityId($arr[$keys[51]]);
		if (array_key_exists($keys[52], $arr)) $this->setWeight($arr[$keys[52]]);
		if (array_key_exists($keys[53], $arr)) $this->setStock($arr[$keys[53]]);
		if (array_key_exists($keys[54], $arr)) $this->setMaxDiscount($arr[$keys[54]]);
		if (array_key_exists($keys[55], $arr)) $this->setMpnCode($arr[$keys[55]]);
		if (array_key_exists($keys[56], $arr)) $this->setGroupPriceId($arr[$keys[56]]);
		if (array_key_exists($keys[57], $arr)) $this->setOptHasOptions($arr[$keys[57]]);
		if (array_key_exists($keys[58], $arr)) $this->setOptionsColor($arr[$keys[58]]);
		if (array_key_exists($keys[59], $arr)) $this->setTaxId($arr[$keys[59]]);
		if (array_key_exists($keys[60], $arr)) $this->setWholesaleANetto($arr[$keys[60]]);
		if (array_key_exists($keys[61], $arr)) $this->setWholesaleBNetto($arr[$keys[61]]);
		if (array_key_exists($keys[62], $arr)) $this->setWholesaleCNetto($arr[$keys[62]]);
		if (array_key_exists($keys[63], $arr)) $this->setWholesaleABrutto($arr[$keys[63]]);
		if (array_key_exists($keys[64], $arr)) $this->setWholesaleBBrutto($arr[$keys[64]]);
		if (array_key_exists($keys[65], $arr)) $this->setWholesaleCBrutto($arr[$keys[65]]);
		if (array_key_exists($keys[66], $arr)) $this->setCurrencyWholesaleA($arr[$keys[66]]);
		if (array_key_exists($keys[67], $arr)) $this->setCurrencyWholesaleB($arr[$keys[67]]);
		if (array_key_exists($keys[68], $arr)) $this->setCurrencyWholesaleC($arr[$keys[68]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ProductPeer::DATABASE_NAME);

		if ($this->isColumnModified(ProductPeer::CREATED_AT)) $criteria->add(ProductPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ProductPeer::UPDATED_AT)) $criteria->add(ProductPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(ProductPeer::ID)) $criteria->add(ProductPeer::ID, $this->id);
		if ($this->isColumnModified(ProductPeer::PARENT_ID)) $criteria->add(ProductPeer::PARENT_ID, $this->parent_id);
		if ($this->isColumnModified(ProductPeer::CURRENCY_ID)) $criteria->add(ProductPeer::CURRENCY_ID, $this->currency_id);
		if ($this->isColumnModified(ProductPeer::PRODUCER_ID)) $criteria->add(ProductPeer::PRODUCER_ID, $this->producer_id);
		if ($this->isColumnModified(ProductPeer::CODE)) $criteria->add(ProductPeer::CODE, $this->code);
		if ($this->isColumnModified(ProductPeer::PRICE)) $criteria->add(ProductPeer::PRICE, $this->price);
		if ($this->isColumnModified(ProductPeer::OPT_PRICE_BRUTTO)) $criteria->add(ProductPeer::OPT_PRICE_BRUTTO, $this->opt_price_brutto);
		if ($this->isColumnModified(ProductPeer::DELIVERY_PRICE)) $criteria->add(ProductPeer::DELIVERY_PRICE, $this->delivery_price);
		if ($this->isColumnModified(ProductPeer::BPUM_DEFAULT_ID)) $criteria->add(ProductPeer::BPUM_DEFAULT_ID, $this->bpum_default_id);
		if ($this->isColumnModified(ProductPeer::BPUM_DEFAULT_VALUE)) $criteria->add(ProductPeer::BPUM_DEFAULT_VALUE, $this->bpum_default_value);
		if ($this->isColumnModified(ProductPeer::BPUM_ID)) $criteria->add(ProductPeer::BPUM_ID, $this->bpum_id);
		if ($this->isColumnModified(ProductPeer::BPUM_VALUE)) $criteria->add(ProductPeer::BPUM_VALUE, $this->bpum_value);
		if ($this->isColumnModified(ProductPeer::CURRENCY_PRICE)) $criteria->add(ProductPeer::CURRENCY_PRICE, $this->currency_price);
		if ($this->isColumnModified(ProductPeer::OLD_PRICE)) $criteria->add(ProductPeer::OLD_PRICE, $this->old_price);
		if ($this->isColumnModified(ProductPeer::OPT_OLD_PRICE_BRUTTO)) $criteria->add(ProductPeer::OPT_OLD_PRICE_BRUTTO, $this->opt_old_price_brutto);
		if ($this->isColumnModified(ProductPeer::POINTS_VALUE)) $criteria->add(ProductPeer::POINTS_VALUE, $this->points_value);
		if ($this->isColumnModified(ProductPeer::POINTS_EARN)) $criteria->add(ProductPeer::POINTS_EARN, $this->points_earn);
		if ($this->isColumnModified(ProductPeer::POINTS_ONLY)) $criteria->add(ProductPeer::POINTS_ONLY, $this->points_only);
		if ($this->isColumnModified(ProductPeer::CURRENCY_OLD_PRICE)) $criteria->add(ProductPeer::CURRENCY_OLD_PRICE, $this->currency_old_price);
		if ($this->isColumnModified(ProductPeer::OPT_VAT)) $criteria->add(ProductPeer::OPT_VAT, $this->opt_vat);
		if ($this->isColumnModified(ProductPeer::CURRENCY_EXCHANGE)) $criteria->add(ProductPeer::CURRENCY_EXCHANGE, $this->currency_exchange);
		if ($this->isColumnModified(ProductPeer::ACTIVE)) $criteria->add(ProductPeer::ACTIVE, $this->active);
		if ($this->isColumnModified(ProductPeer::HIDE_PRICE)) $criteria->add(ProductPeer::HIDE_PRICE, $this->hide_price);
		if ($this->isColumnModified(ProductPeer::HAS_FIXED_CURRENCY)) $criteria->add(ProductPeer::HAS_FIXED_CURRENCY, $this->has_fixed_currency);
		if ($this->isColumnModified(ProductPeer::OPT_IMAGE)) $criteria->add(ProductPeer::OPT_IMAGE, $this->opt_image);
		if ($this->isColumnModified(ProductPeer::OPT_NAME)) $criteria->add(ProductPeer::OPT_NAME, $this->opt_name);
		if ($this->isColumnModified(ProductPeer::OPT_SHORT_DESCRIPTION)) $criteria->add(ProductPeer::OPT_SHORT_DESCRIPTION, $this->opt_short_description);
		if ($this->isColumnModified(ProductPeer::OPT_DESCRIPTION)) $criteria->add(ProductPeer::OPT_DESCRIPTION, $this->opt_description);
		if ($this->isColumnModified(ProductPeer::OPT_URL)) $criteria->add(ProductPeer::OPT_URL, $this->opt_url);
		if ($this->isColumnModified(ProductPeer::OPT_ASSET_FOLDER)) $criteria->add(ProductPeer::OPT_ASSET_FOLDER, $this->opt_asset_folder);
		if ($this->isColumnModified(ProductPeer::OPT_UOM)) $criteria->add(ProductPeer::OPT_UOM, $this->opt_uom);
		if ($this->isColumnModified(ProductPeer::DELIVERIES)) $criteria->add(ProductPeer::DELIVERIES, $this->deliveries);
		if ($this->isColumnModified(ProductPeer::MIN_QTY)) $criteria->add(ProductPeer::MIN_QTY, $this->min_qty);
		if ($this->isColumnModified(ProductPeer::MAX_QTY)) $criteria->add(ProductPeer::MAX_QTY, $this->max_qty);
		if ($this->isColumnModified(ProductPeer::STEP_QTY)) $criteria->add(ProductPeer::STEP_QTY, $this->step_qty);
		if ($this->isColumnModified(ProductPeer::IS_STOCK_VALIDATED)) $criteria->add(ProductPeer::IS_STOCK_VALIDATED, $this->is_stock_validated);
		if ($this->isColumnModified(ProductPeer::IS_GIFT)) $criteria->add(ProductPeer::IS_GIFT, $this->is_gift);
		if ($this->isColumnModified(ProductPeer::IS_SERVICE)) $criteria->add(ProductPeer::IS_SERVICE, $this->is_service);
		if ($this->isColumnModified(ProductPeer::STOCK_IN_DECIMALS)) $criteria->add(ProductPeer::STOCK_IN_DECIMALS, $this->stock_in_decimals);
		if ($this->isColumnModified(ProductPeer::MAN_CODE)) $criteria->add(ProductPeer::MAN_CODE, $this->man_code);
		if ($this->isColumnModified(ProductPeer::MAIN_PAGE_ORDER)) $criteria->add(ProductPeer::MAIN_PAGE_ORDER, $this->main_page_order);
		if ($this->isColumnModified(ProductPeer::PRIORITY)) $criteria->add(ProductPeer::PRIORITY, $this->priority);
		if ($this->isColumnModified(ProductPeer::STOCK_MANAGMENT)) $criteria->add(ProductPeer::STOCK_MANAGMENT, $this->stock_managment);
		if ($this->isColumnModified(ProductPeer::DIMENSION_ID)) $criteria->add(ProductPeer::DIMENSION_ID, $this->dimension_id);
		if ($this->isColumnModified(ProductPeer::WIDTH)) $criteria->add(ProductPeer::WIDTH, $this->width);
		if ($this->isColumnModified(ProductPeer::HEIGHT)) $criteria->add(ProductPeer::HEIGHT, $this->height);
		if ($this->isColumnModified(ProductPeer::DEPTH)) $criteria->add(ProductPeer::DEPTH, $this->depth);
		if ($this->isColumnModified(ProductPeer::OPT_PRODUCT_GROUP)) $criteria->add(ProductPeer::OPT_PRODUCT_GROUP, $this->opt_product_group);
		if ($this->isColumnModified(ProductPeer::OPT_EXECUTION_TIME)) $criteria->add(ProductPeer::OPT_EXECUTION_TIME, $this->opt_execution_time);
		if ($this->isColumnModified(ProductPeer::AVAILABILITY_ID)) $criteria->add(ProductPeer::AVAILABILITY_ID, $this->availability_id);
		if ($this->isColumnModified(ProductPeer::WEIGHT)) $criteria->add(ProductPeer::WEIGHT, $this->weight);
		if ($this->isColumnModified(ProductPeer::STOCK)) $criteria->add(ProductPeer::STOCK, $this->stock);
		if ($this->isColumnModified(ProductPeer::MAX_DISCOUNT)) $criteria->add(ProductPeer::MAX_DISCOUNT, $this->max_discount);
		if ($this->isColumnModified(ProductPeer::MPN_CODE)) $criteria->add(ProductPeer::MPN_CODE, $this->mpn_code);
		if ($this->isColumnModified(ProductPeer::GROUP_PRICE_ID)) $criteria->add(ProductPeer::GROUP_PRICE_ID, $this->group_price_id);
		if ($this->isColumnModified(ProductPeer::OPT_HAS_OPTIONS)) $criteria->add(ProductPeer::OPT_HAS_OPTIONS, $this->opt_has_options);
		if ($this->isColumnModified(ProductPeer::OPTIONS_COLOR)) $criteria->add(ProductPeer::OPTIONS_COLOR, $this->options_color);
		if ($this->isColumnModified(ProductPeer::TAX_ID)) $criteria->add(ProductPeer::TAX_ID, $this->tax_id);
		if ($this->isColumnModified(ProductPeer::WHOLESALE_A_NETTO)) $criteria->add(ProductPeer::WHOLESALE_A_NETTO, $this->wholesale_a_netto);
		if ($this->isColumnModified(ProductPeer::WHOLESALE_B_NETTO)) $criteria->add(ProductPeer::WHOLESALE_B_NETTO, $this->wholesale_b_netto);
		if ($this->isColumnModified(ProductPeer::WHOLESALE_C_NETTO)) $criteria->add(ProductPeer::WHOLESALE_C_NETTO, $this->wholesale_c_netto);
		if ($this->isColumnModified(ProductPeer::WHOLESALE_A_BRUTTO)) $criteria->add(ProductPeer::WHOLESALE_A_BRUTTO, $this->wholesale_a_brutto);
		if ($this->isColumnModified(ProductPeer::WHOLESALE_B_BRUTTO)) $criteria->add(ProductPeer::WHOLESALE_B_BRUTTO, $this->wholesale_b_brutto);
		if ($this->isColumnModified(ProductPeer::WHOLESALE_C_BRUTTO)) $criteria->add(ProductPeer::WHOLESALE_C_BRUTTO, $this->wholesale_c_brutto);
		if ($this->isColumnModified(ProductPeer::CURRENCY_WHOLESALE_A)) $criteria->add(ProductPeer::CURRENCY_WHOLESALE_A, $this->currency_wholesale_a);
		if ($this->isColumnModified(ProductPeer::CURRENCY_WHOLESALE_B)) $criteria->add(ProductPeer::CURRENCY_WHOLESALE_B, $this->currency_wholesale_b);
		if ($this->isColumnModified(ProductPeer::CURRENCY_WHOLESALE_C)) $criteria->add(ProductPeer::CURRENCY_WHOLESALE_C, $this->currency_wholesale_c);

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
		$criteria = new Criteria(ProductPeer::DATABASE_NAME);

		$criteria->add(ProductPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Product (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setParentId($this->parent_id);

		$copyObj->setCurrencyId($this->currency_id);

		$copyObj->setProducerId($this->producer_id);

		$copyObj->setCode($this->code);

		$copyObj->setPrice($this->price);

		$copyObj->setOptPriceBrutto($this->opt_price_brutto);

		$copyObj->setDeliveryPrice($this->delivery_price);

		$copyObj->setBpumDefaultId($this->bpum_default_id);

		$copyObj->setBpumDefaultValue($this->bpum_default_value);

		$copyObj->setBpumId($this->bpum_id);

		$copyObj->setBpumValue($this->bpum_value);

		$copyObj->setCurrencyPrice($this->currency_price);

		$copyObj->setOldPrice($this->old_price);

		$copyObj->setOptOldPriceBrutto($this->opt_old_price_brutto);

		$copyObj->setPointsValue($this->points_value);

		$copyObj->setPointsEarn($this->points_earn);

		$copyObj->setPointsOnly($this->points_only);

		$copyObj->setCurrencyOldPrice($this->currency_old_price);

		$copyObj->setOptVat($this->opt_vat);

		$copyObj->setCurrencyExchange($this->currency_exchange);

		$copyObj->setActive($this->active);

		$copyObj->setHidePrice($this->hide_price);

		$copyObj->setHasFixedCurrency($this->has_fixed_currency);

		$copyObj->setOptImage($this->opt_image);

		$copyObj->setOptName($this->opt_name);

		$copyObj->setOptShortDescription($this->opt_short_description);

		$copyObj->setOptDescription($this->opt_description);

		$copyObj->setOptUrl($this->opt_url);

		$copyObj->setOptAssetFolder($this->opt_asset_folder);

		$copyObj->setOptUom($this->opt_uom);

		$copyObj->setDeliveries($this->deliveries);

		$copyObj->setMinQty($this->min_qty);

		$copyObj->setMaxQty($this->max_qty);

		$copyObj->setStepQty($this->step_qty);

		$copyObj->setIsStockValidated($this->is_stock_validated);

		$copyObj->setIsGift($this->is_gift);

		$copyObj->setIsService($this->is_service);

		$copyObj->setStockInDecimals($this->stock_in_decimals);

		$copyObj->setManCode($this->man_code);

		$copyObj->setMainPageOrder($this->main_page_order);

		$copyObj->setPriority($this->priority);

		$copyObj->setStockManagment($this->stock_managment);

		$copyObj->setDimensionId($this->dimension_id);

		$copyObj->setWidth($this->width);

		$copyObj->setHeight($this->height);

		$copyObj->setDepth($this->depth);

		$copyObj->setOptProductGroup($this->opt_product_group);

		$copyObj->setOptExecutionTime($this->opt_execution_time);

		$copyObj->setAvailabilityId($this->availability_id);

		$copyObj->setWeight($this->weight);

		$copyObj->setStock($this->stock);

		$copyObj->setMaxDiscount($this->max_discount);

		$copyObj->setMpnCode($this->mpn_code);

		$copyObj->setGroupPriceId($this->group_price_id);

		$copyObj->setOptHasOptions($this->opt_has_options);

		$copyObj->setOptionsColor($this->options_color);

		$copyObj->setTaxId($this->tax_id);

		$copyObj->setWholesaleANetto($this->wholesale_a_netto);

		$copyObj->setWholesaleBNetto($this->wholesale_b_netto);

		$copyObj->setWholesaleCNetto($this->wholesale_c_netto);

		$copyObj->setWholesaleABrutto($this->wholesale_a_brutto);

		$copyObj->setWholesaleBBrutto($this->wholesale_b_brutto);

		$copyObj->setWholesaleCBrutto($this->wholesale_c_brutto);

		$copyObj->setCurrencyWholesaleA($this->currency_wholesale_a);

		$copyObj->setCurrencyWholesaleB($this->currency_wholesale_b);

		$copyObj->setCurrencyWholesaleC($this->currency_wholesale_c);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getProductHasWholesales() as $relObj) {
				$copyObj->addProductHasWholesale($relObj->copy($deepCopy));
			}

			foreach($this->getHandelos() as $relObj) {
				$copyObj->addHandelo($relObj->copy($deepCopy));
			}

			foreach($this->getGoogleShoppings() as $relObj) {
				$copyObj->addGoogleShopping($relObj->copy($deepCopy));
			}

			foreach($this->getProductHasAttributeFields() as $relObj) {
				$copyObj->addProductHasAttributeField($relObj->copy($deepCopy));
			}

			foreach($this->getAllegroAuctions() as $relObj) {
				$copyObj->addAllegroAuction($relObj->copy($deepCopy));
			}

			foreach($this->getCrossellingsRelatedByFirstProductId() as $relObj) {
				$copyObj->addCrossellingRelatedByFirstProductId($relObj->copy($deepCopy));
			}

			foreach($this->getCrossellingsRelatedBySecoundProductId() as $relObj) {
				$copyObj->addCrossellingRelatedBySecoundProductId($relObj->copy($deepCopy));
			}

			foreach($this->getLukasProducts() as $relObj) {
				$copyObj->addLukasProduct($relObj->copy($deepCopy));
			}

			foreach($this->getDiscounts() as $relObj) {
				$copyObj->addDiscount($relObj->copy($deepCopy));
			}

			foreach($this->getDiscountHasProducts() as $relObj) {
				$copyObj->addDiscountHasProduct($relObj->copy($deepCopy));
			}

			foreach($this->getDiscountCouponCodeHasProducts() as $relObj) {
				$copyObj->addDiscountCouponCodeHasProduct($relObj->copy($deepCopy));
			}

			foreach($this->getProductsRelatedByParentId() as $relObj) {
				if($this->getPrimaryKey() === $relObj->getPrimaryKey()) {
						continue;
				}

				$copyObj->addProductRelatedByParentId($relObj->copy($deepCopy));
			}

			foreach($this->getProductHasCategorys() as $relObj) {
				$copyObj->addProductHasCategory($relObj->copy($deepCopy));
			}

			foreach($this->getProductHasSfAssets() as $relObj) {
				$copyObj->addProductHasSfAsset($relObj->copy($deepCopy));
			}

			foreach($this->getProductHasAttachments() as $relObj) {
				$copyObj->addProductHasAttachment($relObj->copy($deepCopy));
			}

			foreach($this->getProductHasRecommendsRelatedByRecommendId() as $relObj) {
				$copyObj->addProductHasRecommendRelatedByRecommendId($relObj->copy($deepCopy));
			}

			foreach($this->getProductHasRecommendsRelatedByProductId() as $relObj) {
				$copyObj->addProductHasRecommendRelatedByProductId($relObj->copy($deepCopy));
			}

			foreach($this->getProductI18ns() as $relObj) {
				$copyObj->addProductI18n($relObj->copy($deepCopy));
			}

			foreach($this->getAddPrices() as $relObj) {
				$copyObj->addAddPrice($relObj->copy($deepCopy));
			}

			foreach($this->getOnlineCodess() as $relObj) {
				$copyObj->addOnlineCodes($relObj->copy($deepCopy));
			}

			foreach($this->getOnlineFiless() as $relObj) {
				$copyObj->addOnlineFiles($relObj->copy($deepCopy));
			}

			foreach($this->getBazzars() as $relObj) {
				$copyObj->addBazzar($relObj->copy($deepCopy));
			}

			foreach($this->getTrusts() as $relObj) {
				$copyObj->addTrust($relObj->copy($deepCopy));
			}

			foreach($this->getRadars() as $relObj) {
				$copyObj->addRadar($relObj->copy($deepCopy));
			}

			foreach($this->getOrderProducts() as $relObj) {
				$copyObj->addOrderProduct($relObj->copy($deepCopy));
			}

			foreach($this->getOrderProductHasSets() as $relObj) {
				$copyObj->addOrderProductHasSet($relObj->copy($deepCopy));
			}

			foreach($this->getCeneos() as $relObj) {
				$copyObj->addCeneo($relObj->copy($deepCopy));
			}

			foreach($this->getGiftCardHasProducts() as $relObj) {
				$copyObj->addGiftCardHasProduct($relObj->copy($deepCopy));
			}

			foreach($this->getReviews() as $relObj) {
				$copyObj->addReview($relObj->copy($deepCopy));
			}

			foreach($this->getappProductAttributeVariantHasProducts() as $relObj) {
				$copyObj->addappProductAttributeVariantHasProduct($relObj->copy($deepCopy));
			}

			foreach($this->getOnets() as $relObj) {
				$copyObj->addOnet($relObj->copy($deepCopy));
			}

			foreach($this->getZakupomats() as $relObj) {
				$copyObj->addZakupomat($relObj->copy($deepCopy));
			}

			foreach($this->getOkazjes() as $relObj) {
				$copyObj->addOkazje($relObj->copy($deepCopy));
			}

			foreach($this->getProductOptionsValues() as $relObj) {
				$copyObj->addProductOptionsValue($relObj->copy($deepCopy));
			}

			foreach($this->getProductSearchIndexs() as $relObj) {
				$copyObj->addProductSearchIndex($relObj->copy($deepCopy));
			}

			foreach($this->getProductHasProductSearchTags() as $relObj) {
				$copyObj->addProductHasProductSearchTag($relObj->copy($deepCopy));
			}

			foreach($this->getBasketProducts() as $relObj) {
				$copyObj->addBasketProduct($relObj->copy($deepCopy));
			}

			foreach($this->getInvoiceProducts() as $relObj) {
				$copyObj->addInvoiceProduct($relObj->copy($deepCopy));
			}

			foreach($this->getOferciaks() as $relObj) {
				$copyObj->addOferciak($relObj->copy($deepCopy));
			}

			foreach($this->getProductHasAccessoriessRelatedByAccessoriesId() as $relObj) {
				$copyObj->addProductHasAccessoriesRelatedByAccessoriesId($relObj->copy($deepCopy));
			}

			foreach($this->getProductHasAccessoriessRelatedByProductId() as $relObj) {
				$copyObj->addProductHasAccessoriesRelatedByProductId($relObj->copy($deepCopy));
			}

			foreach($this->getWps() as $relObj) {
				$copyObj->addWp($relObj->copy($deepCopy));
			}

			foreach($this->getNokauts() as $relObj) {
				$copyObj->addNokaut($relObj->copy($deepCopy));
			}

			foreach($this->getProductHasPositionings() as $relObj) {
				$copyObj->addProductHasPositioning($relObj->copy($deepCopy));
			}

			foreach($this->getSklepy24s() as $relObj) {
				$copyObj->addSklepy24($relObj->copy($deepCopy));
			}

			foreach($this->getProductGroupHasProducts() as $relObj) {
				$copyObj->addProductGroupHasProduct($relObj->copy($deepCopy));
			}

			foreach($this->getQuestionss() as $relObj) {
				$copyObj->addQuestions($relObj->copy($deepCopy));
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
	 * @return     Product Clone of current object.
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
	 * @return     ProductPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ProductPeer();
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
	public function setProductRelatedByParentId($v)
	{


		if ($v === null) {
			$this->setParentId(NULL);
		} else {
			$this->setParentId($v->getId());
		}


		$this->aProductRelatedByParentId = $v;
	}


	/**
	 * Get the associated Product object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Product The associated Product object.
	 * @throws     PropelException
	 */
	public function getProductRelatedByParentId($con = null)
	{
		if ($this->aProductRelatedByParentId === null && ($this->parent_id !== null)) {
			// include the related Peer class
			$this->aProductRelatedByParentId = ProductPeer::retrieveByPK($this->parent_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductPeer::retrieveByPK($this->parent_id, $con);
			   $obj->addProductsRelatedByParentId($this);
			 */
		}
		return $this->aProductRelatedByParentId;
	}

	/**
	 * Declares an association between this object and a Currency object.
	 *
	 * @param      Currency $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setCurrency($v)
	{


		if ($v === null) {
			$this->setCurrencyId(NULL);
		} else {
			$this->setCurrencyId($v->getId());
		}


		$this->aCurrency = $v;
	}


	/**
	 * Get the associated Currency object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Currency The associated Currency object.
	 * @throws     PropelException
	 */
	public function getCurrency($con = null)
	{
		if ($this->aCurrency === null && ($this->currency_id !== null)) {
			// include the related Peer class
			$this->aCurrency = CurrencyPeer::retrieveByPK($this->currency_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = CurrencyPeer::retrieveByPK($this->currency_id, $con);
			   $obj->addCurrencys($this);
			 */
		}
		return $this->aCurrency;
	}

	/**
	 * Declares an association between this object and a Producer object.
	 *
	 * @param      Producer $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setProducer($v)
	{


		if ($v === null) {
			$this->setProducerId(NULL);
		} else {
			$this->setProducerId($v->getId());
		}


		$this->aProducer = $v;
	}


	/**
	 * Get the associated Producer object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Producer The associated Producer object.
	 * @throws     PropelException
	 */
	public function getProducer($con = null)
	{
		if ($this->aProducer === null && ($this->producer_id !== null)) {
			// include the related Peer class
			$this->aProducer = ProducerPeer::retrieveByPK($this->producer_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProducerPeer::retrieveByPK($this->producer_id, $con);
			   $obj->addProducers($this);
			 */
		}
		return $this->aProducer;
	}

	/**
	 * Declares an association between this object and a BasicPriceUnitMeasure object.
	 *
	 * @param      BasicPriceUnitMeasure $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setBasicPriceUnitMeasureRelatedByBpumDefaultId($v)
	{


		if ($v === null) {
			$this->setBpumDefaultId(NULL);
		} else {
			$this->setBpumDefaultId($v->getId());
		}


		$this->aBasicPriceUnitMeasureRelatedByBpumDefaultId = $v;
	}


	/**
	 * Get the associated BasicPriceUnitMeasure object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     BasicPriceUnitMeasure The associated BasicPriceUnitMeasure object.
	 * @throws     PropelException
	 */
	public function getBasicPriceUnitMeasureRelatedByBpumDefaultId($con = null)
	{
		if ($this->aBasicPriceUnitMeasureRelatedByBpumDefaultId === null && ($this->bpum_default_id !== null)) {
			// include the related Peer class
			$this->aBasicPriceUnitMeasureRelatedByBpumDefaultId = BasicPriceUnitMeasurePeer::retrieveByPK($this->bpum_default_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = BasicPriceUnitMeasurePeer::retrieveByPK($this->bpum_default_id, $con);
			   $obj->addBasicPriceUnitMeasuresRelatedByBpumDefaultId($this);
			 */
		}
		return $this->aBasicPriceUnitMeasureRelatedByBpumDefaultId;
	}

	/**
	 * Declares an association between this object and a BasicPriceUnitMeasure object.
	 *
	 * @param      BasicPriceUnitMeasure $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setBasicPriceUnitMeasureRelatedByBpumId($v)
	{


		if ($v === null) {
			$this->setBpumId(NULL);
		} else {
			$this->setBpumId($v->getId());
		}


		$this->aBasicPriceUnitMeasureRelatedByBpumId = $v;
	}


	/**
	 * Get the associated BasicPriceUnitMeasure object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     BasicPriceUnitMeasure The associated BasicPriceUnitMeasure object.
	 * @throws     PropelException
	 */
	public function getBasicPriceUnitMeasureRelatedByBpumId($con = null)
	{
		if ($this->aBasicPriceUnitMeasureRelatedByBpumId === null && ($this->bpum_id !== null)) {
			// include the related Peer class
			$this->aBasicPriceUnitMeasureRelatedByBpumId = BasicPriceUnitMeasurePeer::retrieveByPK($this->bpum_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = BasicPriceUnitMeasurePeer::retrieveByPK($this->bpum_id, $con);
			   $obj->addBasicPriceUnitMeasuresRelatedByBpumId($this);
			 */
		}
		return $this->aBasicPriceUnitMeasureRelatedByBpumId;
	}

	/**
	 * Declares an association between this object and a ProductDimension object.
	 *
	 * @param      ProductDimension $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setProductDimension($v)
	{


		if ($v === null) {
			$this->setDimensionId(NULL);
		} else {
			$this->setDimensionId($v->getId());
		}


		$this->aProductDimension = $v;
	}


	/**
	 * Get the associated ProductDimension object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     ProductDimension The associated ProductDimension object.
	 * @throws     PropelException
	 */
	public function getProductDimension($con = null)
	{
		if ($this->aProductDimension === null && ($this->dimension_id !== null)) {
			// include the related Peer class
			$this->aProductDimension = ProductDimensionPeer::retrieveByPK($this->dimension_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = ProductDimensionPeer::retrieveByPK($this->dimension_id, $con);
			   $obj->addProductDimensions($this);
			 */
		}
		return $this->aProductDimension;
	}

	/**
	 * Declares an association between this object and a Availability object.
	 *
	 * @param      Availability $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setAvailability($v)
	{


		if ($v === null) {
			$this->setAvailabilityId(NULL);
		} else {
			$this->setAvailabilityId($v->getId());
		}


		$this->aAvailability = $v;
	}


	/**
	 * Get the associated Availability object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Availability The associated Availability object.
	 * @throws     PropelException
	 */
	public function getAvailability($con = null)
	{
		if ($this->aAvailability === null && ($this->availability_id !== null)) {
			// include the related Peer class
			$this->aAvailability = AvailabilityPeer::retrieveByPK($this->availability_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = AvailabilityPeer::retrieveByPK($this->availability_id, $con);
			   $obj->addAvailabilitys($this);
			 */
		}
		return $this->aAvailability;
	}

	/**
	 * Declares an association between this object and a GroupPrice object.
	 *
	 * @param      GroupPrice $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setGroupPrice($v)
	{


		if ($v === null) {
			$this->setGroupPriceId(NULL);
		} else {
			$this->setGroupPriceId($v->getId());
		}


		$this->aGroupPrice = $v;
	}


	/**
	 * Get the associated GroupPrice object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     GroupPrice The associated GroupPrice object.
	 * @throws     PropelException
	 */
	public function getGroupPrice($con = null)
	{
		if ($this->aGroupPrice === null && ($this->group_price_id !== null)) {
			// include the related Peer class
			$this->aGroupPrice = GroupPricePeer::retrieveByPK($this->group_price_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = GroupPricePeer::retrieveByPK($this->group_price_id, $con);
			   $obj->addGroupPrices($this);
			 */
		}
		return $this->aGroupPrice;
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
	 * Temporary storage of collProductHasWholesales to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductHasWholesales()
	{
		if ($this->collProductHasWholesales === null) {
			$this->collProductHasWholesales = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductHasWholesales from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductHasWholesales($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasWholesales === null) {
			if ($this->isNew()) {
			   $this->collProductHasWholesales = array();
			} else {

				$criteria->add(ProductHasWholesalePeer::PRODUCT_ID, $this->getId());

				ProductHasWholesalePeer::addSelectColumns($criteria);
				$this->collProductHasWholesales = ProductHasWholesalePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasWholesalePeer::PRODUCT_ID, $this->getId());

				ProductHasWholesalePeer::addSelectColumns($criteria);
				if (!isset($this->lastProductHasWholesaleCriteria) || !$this->lastProductHasWholesaleCriteria->equals($criteria)) {
					$this->collProductHasWholesales = ProductHasWholesalePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductHasWholesaleCriteria = $criteria;
		return $this->collProductHasWholesales;
	}

	/**
	 * Returns the number of related ProductHasWholesales.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductHasWholesales($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductHasWholesalePeer::PRODUCT_ID, $this->getId());

		return ProductHasWholesalePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductHasWholesale object to this object
	 * through the ProductHasWholesale foreign key attribute
	 *
	 * @param      ProductHasWholesale $l ProductHasWholesale
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductHasWholesale(ProductHasWholesale $l)
	{
		$this->collProductHasWholesales[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collHandelos to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initHandelos()
	{
		if ($this->collHandelos === null) {
			$this->collHandelos = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related Handelos from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getHandelos($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHandelos === null) {
			if ($this->isNew()) {
			   $this->collHandelos = array();
			} else {

				$criteria->add(HandeloPeer::PRODUCT_ID, $this->getId());

				HandeloPeer::addSelectColumns($criteria);
				$this->collHandelos = HandeloPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(HandeloPeer::PRODUCT_ID, $this->getId());

				HandeloPeer::addSelectColumns($criteria);
				if (!isset($this->lastHandeloCriteria) || !$this->lastHandeloCriteria->equals($criteria)) {
					$this->collHandelos = HandeloPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastHandeloCriteria = $criteria;
		return $this->collHandelos;
	}

	/**
	 * Returns the number of related Handelos.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countHandelos($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(HandeloPeer::PRODUCT_ID, $this->getId());

		return HandeloPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Handelo object to this object
	 * through the Handelo foreign key attribute
	 *
	 * @param      Handelo $l Handelo
	 * @return     void
	 * @throws     PropelException
	 */
	public function addHandelo(Handelo $l)
	{
		$this->collHandelos[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collGoogleShoppings to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initGoogleShoppings()
	{
		if ($this->collGoogleShoppings === null) {
			$this->collGoogleShoppings = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related GoogleShoppings from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getGoogleShoppings($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGoogleShoppings === null) {
			if ($this->isNew()) {
			   $this->collGoogleShoppings = array();
			} else {

				$criteria->add(GoogleShoppingPeer::PRODUCT_ID, $this->getId());

				GoogleShoppingPeer::addSelectColumns($criteria);
				$this->collGoogleShoppings = GoogleShoppingPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GoogleShoppingPeer::PRODUCT_ID, $this->getId());

				GoogleShoppingPeer::addSelectColumns($criteria);
				if (!isset($this->lastGoogleShoppingCriteria) || !$this->lastGoogleShoppingCriteria->equals($criteria)) {
					$this->collGoogleShoppings = GoogleShoppingPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGoogleShoppingCriteria = $criteria;
		return $this->collGoogleShoppings;
	}

	/**
	 * Returns the number of related GoogleShoppings.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countGoogleShoppings($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(GoogleShoppingPeer::PRODUCT_ID, $this->getId());

		return GoogleShoppingPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a GoogleShopping object to this object
	 * through the GoogleShopping foreign key attribute
	 *
	 * @param      GoogleShopping $l GoogleShopping
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGoogleShopping(GoogleShopping $l)
	{
		$this->collGoogleShoppings[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collProductHasAttributeFields to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductHasAttributeFields()
	{
		if ($this->collProductHasAttributeFields === null) {
			$this->collProductHasAttributeFields = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductHasAttributeFields from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductHasAttributeFields($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasAttributeFields === null) {
			if ($this->isNew()) {
			   $this->collProductHasAttributeFields = array();
			} else {

				$criteria->add(ProductHasAttributeFieldPeer::PRODUCT_ID, $this->getId());

				ProductHasAttributeFieldPeer::addSelectColumns($criteria);
				$this->collProductHasAttributeFields = ProductHasAttributeFieldPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasAttributeFieldPeer::PRODUCT_ID, $this->getId());

				ProductHasAttributeFieldPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductHasAttributeFieldCriteria) || !$this->lastProductHasAttributeFieldCriteria->equals($criteria)) {
					$this->collProductHasAttributeFields = ProductHasAttributeFieldPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductHasAttributeFieldCriteria = $criteria;
		return $this->collProductHasAttributeFields;
	}

	/**
	 * Returns the number of related ProductHasAttributeFields.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductHasAttributeFields($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductHasAttributeFieldPeer::PRODUCT_ID, $this->getId());

		return ProductHasAttributeFieldPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductHasAttributeField object to this object
	 * through the ProductHasAttributeField foreign key attribute
	 *
	 * @param      ProductHasAttributeField $l ProductHasAttributeField
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductHasAttributeField(ProductHasAttributeField $l)
	{
		$this->collProductHasAttributeFields[] = $l;
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductHasAttributeFields from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductHasAttributeFieldsJoinAttributeField($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasAttributeFields === null) {
			if ($this->isNew()) {
				$this->collProductHasAttributeFields = array();
			} else {

				$criteria->add(ProductHasAttributeFieldPeer::PRODUCT_ID, $this->getId());

				$this->collProductHasAttributeFields = ProductHasAttributeFieldPeer::doSelectJoinAttributeField($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductHasAttributeFieldPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastProductHasAttributeFieldCriteria) || !$this->lastProductHasAttributeFieldCriteria->equals($criteria)) {
				$this->collProductHasAttributeFields = ProductHasAttributeFieldPeer::doSelectJoinAttributeField($criteria, $con);
			}
		}
		$this->lastProductHasAttributeFieldCriteria = $criteria;

		return $this->collProductHasAttributeFields;
	}

	/**
	 * Temporary storage of collAllegroAuctions to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initAllegroAuctions()
	{
		if ($this->collAllegroAuctions === null) {
			$this->collAllegroAuctions = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related AllegroAuctions from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getAllegroAuctions($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAllegroAuctions === null) {
			if ($this->isNew()) {
			   $this->collAllegroAuctions = array();
			} else {

				$criteria->add(AllegroAuctionPeer::PRODUCT_ID, $this->getId());

				AllegroAuctionPeer::addSelectColumns($criteria);
				$this->collAllegroAuctions = AllegroAuctionPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AllegroAuctionPeer::PRODUCT_ID, $this->getId());

				AllegroAuctionPeer::addSelectColumns($criteria);
				if (!isset($this->lastAllegroAuctionCriteria) || !$this->lastAllegroAuctionCriteria->equals($criteria)) {
					$this->collAllegroAuctions = AllegroAuctionPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAllegroAuctionCriteria = $criteria;
		return $this->collAllegroAuctions;
	}

	/**
	 * Returns the number of related AllegroAuctions.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countAllegroAuctions($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(AllegroAuctionPeer::PRODUCT_ID, $this->getId());

		return AllegroAuctionPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a AllegroAuction object to this object
	 * through the AllegroAuction foreign key attribute
	 *
	 * @param      AllegroAuction $l AllegroAuction
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAllegroAuction(AllegroAuction $l)
	{
		$this->collAllegroAuctions[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collCrossellingsRelatedByFirstProductId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initCrossellingsRelatedByFirstProductId()
	{
		if ($this->collCrossellingsRelatedByFirstProductId === null) {
			$this->collCrossellingsRelatedByFirstProductId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related CrossellingsRelatedByFirstProductId from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getCrossellingsRelatedByFirstProductId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCrossellingsRelatedByFirstProductId === null) {
			if ($this->isNew()) {
			   $this->collCrossellingsRelatedByFirstProductId = array();
			} else {

				$criteria->add(CrossellingPeer::FIRST_PRODUCT_ID, $this->getId());

				CrossellingPeer::addSelectColumns($criteria);
				$this->collCrossellingsRelatedByFirstProductId = CrossellingPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(CrossellingPeer::FIRST_PRODUCT_ID, $this->getId());

				CrossellingPeer::addSelectColumns($criteria);
				if (!isset($this->lastCrossellingRelatedByFirstProductIdCriteria) || !$this->lastCrossellingRelatedByFirstProductIdCriteria->equals($criteria)) {
					$this->collCrossellingsRelatedByFirstProductId = CrossellingPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCrossellingRelatedByFirstProductIdCriteria = $criteria;
		return $this->collCrossellingsRelatedByFirstProductId;
	}

	/**
	 * Returns the number of related CrossellingsRelatedByFirstProductId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countCrossellingsRelatedByFirstProductId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CrossellingPeer::FIRST_PRODUCT_ID, $this->getId());

		return CrossellingPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Crosselling object to this object
	 * through the Crosselling foreign key attribute
	 *
	 * @param      Crosselling $l Crosselling
	 * @return     void
	 * @throws     PropelException
	 */
	public function addCrossellingRelatedByFirstProductId(Crosselling $l)
	{
		$this->collCrossellingsRelatedByFirstProductId[] = $l;
		$l->setProductRelatedByFirstProductId($this);
	}

	/**
	 * Temporary storage of collCrossellingsRelatedBySecoundProductId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initCrossellingsRelatedBySecoundProductId()
	{
		if ($this->collCrossellingsRelatedBySecoundProductId === null) {
			$this->collCrossellingsRelatedBySecoundProductId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related CrossellingsRelatedBySecoundProductId from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getCrossellingsRelatedBySecoundProductId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCrossellingsRelatedBySecoundProductId === null) {
			if ($this->isNew()) {
			   $this->collCrossellingsRelatedBySecoundProductId = array();
			} else {

				$criteria->add(CrossellingPeer::SECOUND_PRODUCT_ID, $this->getId());

				CrossellingPeer::addSelectColumns($criteria);
				$this->collCrossellingsRelatedBySecoundProductId = CrossellingPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(CrossellingPeer::SECOUND_PRODUCT_ID, $this->getId());

				CrossellingPeer::addSelectColumns($criteria);
				if (!isset($this->lastCrossellingRelatedBySecoundProductIdCriteria) || !$this->lastCrossellingRelatedBySecoundProductIdCriteria->equals($criteria)) {
					$this->collCrossellingsRelatedBySecoundProductId = CrossellingPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCrossellingRelatedBySecoundProductIdCriteria = $criteria;
		return $this->collCrossellingsRelatedBySecoundProductId;
	}

	/**
	 * Returns the number of related CrossellingsRelatedBySecoundProductId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countCrossellingsRelatedBySecoundProductId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CrossellingPeer::SECOUND_PRODUCT_ID, $this->getId());

		return CrossellingPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Crosselling object to this object
	 * through the Crosselling foreign key attribute
	 *
	 * @param      Crosselling $l Crosselling
	 * @return     void
	 * @throws     PropelException
	 */
	public function addCrossellingRelatedBySecoundProductId(Crosselling $l)
	{
		$this->collCrossellingsRelatedBySecoundProductId[] = $l;
		$l->setProductRelatedBySecoundProductId($this);
	}

	/**
	 * Temporary storage of collLukasProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initLukasProducts()
	{
		if ($this->collLukasProducts === null) {
			$this->collLukasProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related LukasProducts from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getLukasProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLukasProducts === null) {
			if ($this->isNew()) {
			   $this->collLukasProducts = array();
			} else {

				$criteria->add(LukasProductPeer::PRODUCT_ID, $this->getId());

				LukasProductPeer::addSelectColumns($criteria);
				$this->collLukasProducts = LukasProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(LukasProductPeer::PRODUCT_ID, $this->getId());

				LukasProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastLukasProductCriteria) || !$this->lastLukasProductCriteria->equals($criteria)) {
					$this->collLukasProducts = LukasProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastLukasProductCriteria = $criteria;
		return $this->collLukasProducts;
	}

	/**
	 * Returns the number of related LukasProducts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countLukasProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(LukasProductPeer::PRODUCT_ID, $this->getId());

		return LukasProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a LukasProduct object to this object
	 * through the LukasProduct foreign key attribute
	 *
	 * @param      LukasProduct $l LukasProduct
	 * @return     void
	 * @throws     PropelException
	 */
	public function addLukasProduct(LukasProduct $l)
	{
		$this->collLukasProducts[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collDiscounts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDiscounts()
	{
		if ($this->collDiscounts === null) {
			$this->collDiscounts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related Discounts from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDiscounts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDiscounts === null) {
			if ($this->isNew()) {
			   $this->collDiscounts = array();
			} else {

				$criteria->add(DiscountPeer::PRODUCT_ID, $this->getId());

				DiscountPeer::addSelectColumns($criteria);
				$this->collDiscounts = DiscountPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountPeer::PRODUCT_ID, $this->getId());

				DiscountPeer::addSelectColumns($criteria);
				if (!isset($this->lastDiscountCriteria) || !$this->lastDiscountCriteria->equals($criteria)) {
					$this->collDiscounts = DiscountPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDiscountCriteria = $criteria;
		return $this->collDiscounts;
	}

	/**
	 * Returns the number of related Discounts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDiscounts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DiscountPeer::PRODUCT_ID, $this->getId());

		return DiscountPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Discount object to this object
	 * through the Discount foreign key attribute
	 *
	 * @param      Discount $l Discount
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDiscount(Discount $l)
	{
		$this->collDiscounts[] = $l;
		$l->setProduct($this);
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
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related DiscountHasProducts from storage.
	 * If this Product is new, it will return
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

				$criteria->add(DiscountHasProductPeer::PRODUCT_ID, $this->getId());

				DiscountHasProductPeer::addSelectColumns($criteria);
				$this->collDiscountHasProducts = DiscountHasProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountHasProductPeer::PRODUCT_ID, $this->getId());

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

		$criteria->add(DiscountHasProductPeer::PRODUCT_ID, $this->getId());

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
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related DiscountHasProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getDiscountHasProductsJoinDiscount($criteria = null, $con = null)
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

				$criteria->add(DiscountHasProductPeer::PRODUCT_ID, $this->getId());

				$this->collDiscountHasProducts = DiscountHasProductPeer::doSelectJoinDiscount($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DiscountHasProductPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastDiscountHasProductCriteria) || !$this->lastDiscountHasProductCriteria->equals($criteria)) {
				$this->collDiscountHasProducts = DiscountHasProductPeer::doSelectJoinDiscount($criteria, $con);
			}
		}
		$this->lastDiscountHasProductCriteria = $criteria;

		return $this->collDiscountHasProducts;
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
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related DiscountCouponCodeHasProducts from storage.
	 * If this Product is new, it will return
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

				$criteria->add(DiscountCouponCodeHasProductPeer::PRODUCT_ID, $this->getId());

				DiscountCouponCodeHasProductPeer::addSelectColumns($criteria);
				$this->collDiscountCouponCodeHasProducts = DiscountCouponCodeHasProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DiscountCouponCodeHasProductPeer::PRODUCT_ID, $this->getId());

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

		$criteria->add(DiscountCouponCodeHasProductPeer::PRODUCT_ID, $this->getId());

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
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related DiscountCouponCodeHasProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getDiscountCouponCodeHasProductsJoinDiscountCouponCode($criteria = null, $con = null)
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

				$criteria->add(DiscountCouponCodeHasProductPeer::PRODUCT_ID, $this->getId());

				$this->collDiscountCouponCodeHasProducts = DiscountCouponCodeHasProductPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DiscountCouponCodeHasProductPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastDiscountCouponCodeHasProductCriteria) || !$this->lastDiscountCouponCodeHasProductCriteria->equals($criteria)) {
				$this->collDiscountCouponCodeHasProducts = DiscountCouponCodeHasProductPeer::doSelectJoinDiscountCouponCode($criteria, $con);
			}
		}
		$this->lastDiscountCouponCodeHasProductCriteria = $criteria;

		return $this->collDiscountCouponCodeHasProducts;
	}

	/**
	 * Temporary storage of collProductsRelatedByParentId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductsRelatedByParentId()
	{
		if ($this->collProductsRelatedByParentId === null) {
			$this->collProductsRelatedByParentId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductsRelatedByParentId from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductsRelatedByParentId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByParentId === null) {
			if ($this->isNew()) {
			   $this->collProductsRelatedByParentId = array();
			} else {

				$criteria->add(ProductPeer::PARENT_ID, $this->getId());

				ProductPeer::addSelectColumns($criteria);
				$this->collProductsRelatedByParentId = ProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductPeer::PARENT_ID, $this->getId());

				ProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductRelatedByParentIdCriteria) || !$this->lastProductRelatedByParentIdCriteria->equals($criteria)) {
					$this->collProductsRelatedByParentId = ProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductRelatedByParentIdCriteria = $criteria;
		return $this->collProductsRelatedByParentId;
	}

	/**
	 * Returns the number of related ProductsRelatedByParentId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductsRelatedByParentId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductPeer::PARENT_ID, $this->getId());

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
	public function addProductRelatedByParentId(Product $l)
	{
		$this->collProductsRelatedByParentId[] = $l;
		$l->setProductRelatedByParentId($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductsRelatedByParentId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductsRelatedByParentIdJoinCurrency($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByParentId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByParentId = array();
			} else {

				$criteria->add(ProductPeer::PARENT_ID, $this->getId());

				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PARENT_ID, $this->getId());

			if (!isset($this->lastProductRelatedByParentIdCriteria) || !$this->lastProductRelatedByParentIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinCurrency($criteria, $con);
			}
		}
		$this->lastProductRelatedByParentIdCriteria = $criteria;

		return $this->collProductsRelatedByParentId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductsRelatedByParentId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductsRelatedByParentIdJoinProducer($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByParentId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByParentId = array();
			} else {

				$criteria->add(ProductPeer::PARENT_ID, $this->getId());

				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinProducer($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PARENT_ID, $this->getId());

			if (!isset($this->lastProductRelatedByParentIdCriteria) || !$this->lastProductRelatedByParentIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinProducer($criteria, $con);
			}
		}
		$this->lastProductRelatedByParentIdCriteria = $criteria;

		return $this->collProductsRelatedByParentId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductsRelatedByParentId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductsRelatedByParentIdJoinBasicPriceUnitMeasureRelatedByBpumDefaultId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByParentId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByParentId = array();
			} else {

				$criteria->add(ProductPeer::PARENT_ID, $this->getId());

				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumDefaultId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PARENT_ID, $this->getId());

			if (!isset($this->lastProductRelatedByParentIdCriteria) || !$this->lastProductRelatedByParentIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumDefaultId($criteria, $con);
			}
		}
		$this->lastProductRelatedByParentIdCriteria = $criteria;

		return $this->collProductsRelatedByParentId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductsRelatedByParentId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductsRelatedByParentIdJoinBasicPriceUnitMeasureRelatedByBpumId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByParentId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByParentId = array();
			} else {

				$criteria->add(ProductPeer::PARENT_ID, $this->getId());

				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PARENT_ID, $this->getId());

			if (!isset($this->lastProductRelatedByParentIdCriteria) || !$this->lastProductRelatedByParentIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinBasicPriceUnitMeasureRelatedByBpumId($criteria, $con);
			}
		}
		$this->lastProductRelatedByParentIdCriteria = $criteria;

		return $this->collProductsRelatedByParentId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductsRelatedByParentId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductsRelatedByParentIdJoinProductDimension($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByParentId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByParentId = array();
			} else {

				$criteria->add(ProductPeer::PARENT_ID, $this->getId());

				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinProductDimension($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PARENT_ID, $this->getId());

			if (!isset($this->lastProductRelatedByParentIdCriteria) || !$this->lastProductRelatedByParentIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinProductDimension($criteria, $con);
			}
		}
		$this->lastProductRelatedByParentIdCriteria = $criteria;

		return $this->collProductsRelatedByParentId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductsRelatedByParentId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductsRelatedByParentIdJoinAvailability($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByParentId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByParentId = array();
			} else {

				$criteria->add(ProductPeer::PARENT_ID, $this->getId());

				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinAvailability($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PARENT_ID, $this->getId());

			if (!isset($this->lastProductRelatedByParentIdCriteria) || !$this->lastProductRelatedByParentIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinAvailability($criteria, $con);
			}
		}
		$this->lastProductRelatedByParentIdCriteria = $criteria;

		return $this->collProductsRelatedByParentId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductsRelatedByParentId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductsRelatedByParentIdJoinGroupPrice($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByParentId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByParentId = array();
			} else {

				$criteria->add(ProductPeer::PARENT_ID, $this->getId());

				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinGroupPrice($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PARENT_ID, $this->getId());

			if (!isset($this->lastProductRelatedByParentIdCriteria) || !$this->lastProductRelatedByParentIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinGroupPrice($criteria, $con);
			}
		}
		$this->lastProductRelatedByParentIdCriteria = $criteria;

		return $this->collProductsRelatedByParentId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductsRelatedByParentId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductsRelatedByParentIdJoinTax($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductsRelatedByParentId === null) {
			if ($this->isNew()) {
				$this->collProductsRelatedByParentId = array();
			} else {

				$criteria->add(ProductPeer::PARENT_ID, $this->getId());

				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinTax($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductPeer::PARENT_ID, $this->getId());

			if (!isset($this->lastProductRelatedByParentIdCriteria) || !$this->lastProductRelatedByParentIdCriteria->equals($criteria)) {
				$this->collProductsRelatedByParentId = ProductPeer::doSelectJoinTax($criteria, $con);
			}
		}
		$this->lastProductRelatedByParentIdCriteria = $criteria;

		return $this->collProductsRelatedByParentId;
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
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductHasCategorys from storage.
	 * If this Product is new, it will return
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

				$criteria->add(ProductHasCategoryPeer::PRODUCT_ID, $this->getId());

				ProductHasCategoryPeer::addSelectColumns($criteria);
				$this->collProductHasCategorys = ProductHasCategoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasCategoryPeer::PRODUCT_ID, $this->getId());

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

		$criteria->add(ProductHasCategoryPeer::PRODUCT_ID, $this->getId());

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
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductHasCategorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductHasCategorysJoinCategory($criteria = null, $con = null)
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

				$criteria->add(ProductHasCategoryPeer::PRODUCT_ID, $this->getId());

				$this->collProductHasCategorys = ProductHasCategoryPeer::doSelectJoinCategory($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductHasCategoryPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastProductHasCategoryCriteria) || !$this->lastProductHasCategoryCriteria->equals($criteria)) {
				$this->collProductHasCategorys = ProductHasCategoryPeer::doSelectJoinCategory($criteria, $con);
			}
		}
		$this->lastProductHasCategoryCriteria = $criteria;

		return $this->collProductHasCategorys;
	}

	/**
	 * Temporary storage of collProductHasSfAssets to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductHasSfAssets()
	{
		if ($this->collProductHasSfAssets === null) {
			$this->collProductHasSfAssets = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductHasSfAssets from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductHasSfAssets($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasSfAssets === null) {
			if ($this->isNew()) {
			   $this->collProductHasSfAssets = array();
			} else {

				$criteria->add(ProductHasSfAssetPeer::PRODUCT_ID, $this->getId());

				ProductHasSfAssetPeer::addSelectColumns($criteria);
				$this->collProductHasSfAssets = ProductHasSfAssetPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasSfAssetPeer::PRODUCT_ID, $this->getId());

				ProductHasSfAssetPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductHasSfAssetCriteria) || !$this->lastProductHasSfAssetCriteria->equals($criteria)) {
					$this->collProductHasSfAssets = ProductHasSfAssetPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductHasSfAssetCriteria = $criteria;
		return $this->collProductHasSfAssets;
	}

	/**
	 * Returns the number of related ProductHasSfAssets.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductHasSfAssets($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductHasSfAssetPeer::PRODUCT_ID, $this->getId());

		return ProductHasSfAssetPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductHasSfAsset object to this object
	 * through the ProductHasSfAsset foreign key attribute
	 *
	 * @param      ProductHasSfAsset $l ProductHasSfAsset
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductHasSfAsset(ProductHasSfAsset $l)
	{
		$this->collProductHasSfAssets[] = $l;
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductHasSfAssets from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductHasSfAssetsJoinsfAsset($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasSfAssets === null) {
			if ($this->isNew()) {
				$this->collProductHasSfAssets = array();
			} else {

				$criteria->add(ProductHasSfAssetPeer::PRODUCT_ID, $this->getId());

				$this->collProductHasSfAssets = ProductHasSfAssetPeer::doSelectJoinsfAsset($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductHasSfAssetPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastProductHasSfAssetCriteria) || !$this->lastProductHasSfAssetCriteria->equals($criteria)) {
				$this->collProductHasSfAssets = ProductHasSfAssetPeer::doSelectJoinsfAsset($criteria, $con);
			}
		}
		$this->lastProductHasSfAssetCriteria = $criteria;

		return $this->collProductHasSfAssets;
	}

	/**
	 * Temporary storage of collProductHasAttachments to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductHasAttachments()
	{
		if ($this->collProductHasAttachments === null) {
			$this->collProductHasAttachments = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductHasAttachments from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductHasAttachments($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasAttachments === null) {
			if ($this->isNew()) {
			   $this->collProductHasAttachments = array();
			} else {

				$criteria->add(ProductHasAttachmentPeer::PRODUCT_ID, $this->getId());

				ProductHasAttachmentPeer::addSelectColumns($criteria);
				$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasAttachmentPeer::PRODUCT_ID, $this->getId());

				ProductHasAttachmentPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductHasAttachmentCriteria) || !$this->lastProductHasAttachmentCriteria->equals($criteria)) {
					$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductHasAttachmentCriteria = $criteria;
		return $this->collProductHasAttachments;
	}

	/**
	 * Returns the number of related ProductHasAttachments.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductHasAttachments($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductHasAttachmentPeer::PRODUCT_ID, $this->getId());

		return ProductHasAttachmentPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductHasAttachment object to this object
	 * through the ProductHasAttachment foreign key attribute
	 *
	 * @param      ProductHasAttachment $l ProductHasAttachment
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductHasAttachment(ProductHasAttachment $l)
	{
		$this->collProductHasAttachments[] = $l;
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductHasAttachments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductHasAttachmentsJoinLanguage($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasAttachments === null) {
			if ($this->isNew()) {
				$this->collProductHasAttachments = array();
			} else {

				$criteria->add(ProductHasAttachmentPeer::PRODUCT_ID, $this->getId());

				$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelectJoinLanguage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductHasAttachmentPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastProductHasAttachmentCriteria) || !$this->lastProductHasAttachmentCriteria->equals($criteria)) {
				$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelectJoinLanguage($criteria, $con);
			}
		}
		$this->lastProductHasAttachmentCriteria = $criteria;

		return $this->collProductHasAttachments;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductHasAttachments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductHasAttachmentsJoinsfAsset($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasAttachments === null) {
			if ($this->isNew()) {
				$this->collProductHasAttachments = array();
			} else {

				$criteria->add(ProductHasAttachmentPeer::PRODUCT_ID, $this->getId());

				$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelectJoinsfAsset($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductHasAttachmentPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastProductHasAttachmentCriteria) || !$this->lastProductHasAttachmentCriteria->equals($criteria)) {
				$this->collProductHasAttachments = ProductHasAttachmentPeer::doSelectJoinsfAsset($criteria, $con);
			}
		}
		$this->lastProductHasAttachmentCriteria = $criteria;

		return $this->collProductHasAttachments;
	}

	/**
	 * Temporary storage of collProductHasRecommendsRelatedByRecommendId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductHasRecommendsRelatedByRecommendId()
	{
		if ($this->collProductHasRecommendsRelatedByRecommendId === null) {
			$this->collProductHasRecommendsRelatedByRecommendId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductHasRecommendsRelatedByRecommendId from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductHasRecommendsRelatedByRecommendId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasRecommendsRelatedByRecommendId === null) {
			if ($this->isNew()) {
			   $this->collProductHasRecommendsRelatedByRecommendId = array();
			} else {

				$criteria->add(ProductHasRecommendPeer::RECOMMEND_ID, $this->getId());

				ProductHasRecommendPeer::addSelectColumns($criteria);
				$this->collProductHasRecommendsRelatedByRecommendId = ProductHasRecommendPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasRecommendPeer::RECOMMEND_ID, $this->getId());

				ProductHasRecommendPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductHasRecommendRelatedByRecommendIdCriteria) || !$this->lastProductHasRecommendRelatedByRecommendIdCriteria->equals($criteria)) {
					$this->collProductHasRecommendsRelatedByRecommendId = ProductHasRecommendPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductHasRecommendRelatedByRecommendIdCriteria = $criteria;
		return $this->collProductHasRecommendsRelatedByRecommendId;
	}

	/**
	 * Returns the number of related ProductHasRecommendsRelatedByRecommendId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductHasRecommendsRelatedByRecommendId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductHasRecommendPeer::RECOMMEND_ID, $this->getId());

		return ProductHasRecommendPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductHasRecommend object to this object
	 * through the ProductHasRecommend foreign key attribute
	 *
	 * @param      ProductHasRecommend $l ProductHasRecommend
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductHasRecommendRelatedByRecommendId(ProductHasRecommend $l)
	{
		$this->collProductHasRecommendsRelatedByRecommendId[] = $l;
		$l->setProductRelatedByRecommendId($this);
	}

	/**
	 * Temporary storage of collProductHasRecommendsRelatedByProductId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductHasRecommendsRelatedByProductId()
	{
		if ($this->collProductHasRecommendsRelatedByProductId === null) {
			$this->collProductHasRecommendsRelatedByProductId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductHasRecommendsRelatedByProductId from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductHasRecommendsRelatedByProductId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasRecommendsRelatedByProductId === null) {
			if ($this->isNew()) {
			   $this->collProductHasRecommendsRelatedByProductId = array();
			} else {

				$criteria->add(ProductHasRecommendPeer::PRODUCT_ID, $this->getId());

				ProductHasRecommendPeer::addSelectColumns($criteria);
				$this->collProductHasRecommendsRelatedByProductId = ProductHasRecommendPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasRecommendPeer::PRODUCT_ID, $this->getId());

				ProductHasRecommendPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductHasRecommendRelatedByProductIdCriteria) || !$this->lastProductHasRecommendRelatedByProductIdCriteria->equals($criteria)) {
					$this->collProductHasRecommendsRelatedByProductId = ProductHasRecommendPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductHasRecommendRelatedByProductIdCriteria = $criteria;
		return $this->collProductHasRecommendsRelatedByProductId;
	}

	/**
	 * Returns the number of related ProductHasRecommendsRelatedByProductId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductHasRecommendsRelatedByProductId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductHasRecommendPeer::PRODUCT_ID, $this->getId());

		return ProductHasRecommendPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductHasRecommend object to this object
	 * through the ProductHasRecommend foreign key attribute
	 *
	 * @param      ProductHasRecommend $l ProductHasRecommend
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductHasRecommendRelatedByProductId(ProductHasRecommend $l)
	{
		$this->collProductHasRecommendsRelatedByProductId[] = $l;
		$l->setProductRelatedByProductId($this);
	}

	/**
	 * Temporary storage of collProductI18ns to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductI18ns()
	{
		if ($this->collProductI18ns === null) {
			$this->collProductI18ns = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductI18ns from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductI18ns($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductI18ns === null) {
			if ($this->isNew()) {
			   $this->collProductI18ns = array();
			} else {

				$criteria->add(ProductI18nPeer::ID, $this->getId());

				ProductI18nPeer::addSelectColumns($criteria);
				$this->collProductI18ns = ProductI18nPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductI18nPeer::ID, $this->getId());

				ProductI18nPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductI18nCriteria) || !$this->lastProductI18nCriteria->equals($criteria)) {
					$this->collProductI18ns = ProductI18nPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductI18nCriteria = $criteria;
		return $this->collProductI18ns;
	}

	/**
	 * Returns the number of related ProductI18ns.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductI18ns($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductI18nPeer::ID, $this->getId());

		return ProductI18nPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductI18n object to this object
	 * through the ProductI18n foreign key attribute
	 *
	 * @param      ProductI18n $l ProductI18n
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductI18n(ProductI18n $l)
	{
		$this->collProductI18ns[] = $l;
		$l->setProduct($this);
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
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related AddPrices from storage.
	 * If this Product is new, it will return
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

				$criteria->add(AddPricePeer::ID, $this->getId());

				AddPricePeer::addSelectColumns($criteria);
				$this->collAddPrices = AddPricePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AddPricePeer::ID, $this->getId());

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

		$criteria->add(AddPricePeer::ID, $this->getId());

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
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related AddPrices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
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

				$criteria->add(AddPricePeer::ID, $this->getId());

				$this->collAddPrices = AddPricePeer::doSelectJoinCurrency($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AddPricePeer::ID, $this->getId());

			if (!isset($this->lastAddPriceCriteria) || !$this->lastAddPriceCriteria->equals($criteria)) {
				$this->collAddPrices = AddPricePeer::doSelectJoinCurrency($criteria, $con);
			}
		}
		$this->lastAddPriceCriteria = $criteria;

		return $this->collAddPrices;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related AddPrices from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getAddPricesJoinTax($criteria = null, $con = null)
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

				$criteria->add(AddPricePeer::ID, $this->getId());

				$this->collAddPrices = AddPricePeer::doSelectJoinTax($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AddPricePeer::ID, $this->getId());

			if (!isset($this->lastAddPriceCriteria) || !$this->lastAddPriceCriteria->equals($criteria)) {
				$this->collAddPrices = AddPricePeer::doSelectJoinTax($criteria, $con);
			}
		}
		$this->lastAddPriceCriteria = $criteria;

		return $this->collAddPrices;
	}

	/**
	 * Temporary storage of collOnlineCodess to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOnlineCodess()
	{
		if ($this->collOnlineCodess === null) {
			$this->collOnlineCodess = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related OnlineCodess from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOnlineCodess($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOnlineCodess === null) {
			if ($this->isNew()) {
			   $this->collOnlineCodess = array();
			} else {

				$criteria->add(OnlineCodesPeer::PRODUCT_ID, $this->getId());

				OnlineCodesPeer::addSelectColumns($criteria);
				$this->collOnlineCodess = OnlineCodesPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OnlineCodesPeer::PRODUCT_ID, $this->getId());

				OnlineCodesPeer::addSelectColumns($criteria);
				if (!isset($this->lastOnlineCodesCriteria) || !$this->lastOnlineCodesCriteria->equals($criteria)) {
					$this->collOnlineCodess = OnlineCodesPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOnlineCodesCriteria = $criteria;
		return $this->collOnlineCodess;
	}

	/**
	 * Returns the number of related OnlineCodess.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOnlineCodess($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OnlineCodesPeer::PRODUCT_ID, $this->getId());

		return OnlineCodesPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a OnlineCodes object to this object
	 * through the OnlineCodes foreign key attribute
	 *
	 * @param      OnlineCodes $l OnlineCodes
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOnlineCodes(OnlineCodes $l)
	{
		$this->collOnlineCodess[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collOnlineFiless to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOnlineFiless()
	{
		if ($this->collOnlineFiless === null) {
			$this->collOnlineFiless = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related OnlineFiless from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOnlineFiless($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOnlineFiless === null) {
			if ($this->isNew()) {
			   $this->collOnlineFiless = array();
			} else {

				$criteria->add(OnlineFilesPeer::PRODUCT_ID, $this->getId());

				OnlineFilesPeer::addSelectColumns($criteria);
				$this->collOnlineFiless = OnlineFilesPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OnlineFilesPeer::PRODUCT_ID, $this->getId());

				OnlineFilesPeer::addSelectColumns($criteria);
				if (!isset($this->lastOnlineFilesCriteria) || !$this->lastOnlineFilesCriteria->equals($criteria)) {
					$this->collOnlineFiless = OnlineFilesPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOnlineFilesCriteria = $criteria;
		return $this->collOnlineFiless;
	}

	/**
	 * Returns the number of related OnlineFiless.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOnlineFiless($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OnlineFilesPeer::PRODUCT_ID, $this->getId());

		return OnlineFilesPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a OnlineFiles object to this object
	 * through the OnlineFiles foreign key attribute
	 *
	 * @param      OnlineFiles $l OnlineFiles
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOnlineFiles(OnlineFiles $l)
	{
		$this->collOnlineFiless[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collBazzars to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initBazzars()
	{
		if ($this->collBazzars === null) {
			$this->collBazzars = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related Bazzars from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getBazzars($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBazzars === null) {
			if ($this->isNew()) {
			   $this->collBazzars = array();
			} else {

				$criteria->add(BazzarPeer::PRODUCT_ID, $this->getId());

				BazzarPeer::addSelectColumns($criteria);
				$this->collBazzars = BazzarPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(BazzarPeer::PRODUCT_ID, $this->getId());

				BazzarPeer::addSelectColumns($criteria);
				if (!isset($this->lastBazzarCriteria) || !$this->lastBazzarCriteria->equals($criteria)) {
					$this->collBazzars = BazzarPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastBazzarCriteria = $criteria;
		return $this->collBazzars;
	}

	/**
	 * Returns the number of related Bazzars.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countBazzars($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(BazzarPeer::PRODUCT_ID, $this->getId());

		return BazzarPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Bazzar object to this object
	 * through the Bazzar foreign key attribute
	 *
	 * @param      Bazzar $l Bazzar
	 * @return     void
	 * @throws     PropelException
	 */
	public function addBazzar(Bazzar $l)
	{
		$this->collBazzars[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collTrusts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initTrusts()
	{
		if ($this->collTrusts === null) {
			$this->collTrusts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related Trusts from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getTrusts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTrusts === null) {
			if ($this->isNew()) {
			   $this->collTrusts = array();
			} else {

				$criteria->add(TrustPeer::PRODUCT_ID, $this->getId());

				TrustPeer::addSelectColumns($criteria);
				$this->collTrusts = TrustPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(TrustPeer::PRODUCT_ID, $this->getId());

				TrustPeer::addSelectColumns($criteria);
				if (!isset($this->lastTrustCriteria) || !$this->lastTrustCriteria->equals($criteria)) {
					$this->collTrusts = TrustPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTrustCriteria = $criteria;
		return $this->collTrusts;
	}

	/**
	 * Returns the number of related Trusts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countTrusts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TrustPeer::PRODUCT_ID, $this->getId());

		return TrustPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Trust object to this object
	 * through the Trust foreign key attribute
	 *
	 * @param      Trust $l Trust
	 * @return     void
	 * @throws     PropelException
	 */
	public function addTrust(Trust $l)
	{
		$this->collTrusts[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collRadars to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initRadars()
	{
		if ($this->collRadars === null) {
			$this->collRadars = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related Radars from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getRadars($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRadars === null) {
			if ($this->isNew()) {
			   $this->collRadars = array();
			} else {

				$criteria->add(RadarPeer::PRODUCT_ID, $this->getId());

				RadarPeer::addSelectColumns($criteria);
				$this->collRadars = RadarPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(RadarPeer::PRODUCT_ID, $this->getId());

				RadarPeer::addSelectColumns($criteria);
				if (!isset($this->lastRadarCriteria) || !$this->lastRadarCriteria->equals($criteria)) {
					$this->collRadars = RadarPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastRadarCriteria = $criteria;
		return $this->collRadars;
	}

	/**
	 * Returns the number of related Radars.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countRadars($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(RadarPeer::PRODUCT_ID, $this->getId());

		return RadarPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Radar object to this object
	 * through the Radar foreign key attribute
	 *
	 * @param      Radar $l Radar
	 * @return     void
	 * @throws     PropelException
	 */
	public function addRadar(Radar $l)
	{
		$this->collRadars[] = $l;
		$l->setProduct($this);
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
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related OrderProducts from storage.
	 * If this Product is new, it will return
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

				$criteria->add(OrderProductPeer::PRODUCT_ID, $this->getId());

				OrderProductPeer::addSelectColumns($criteria);
				$this->collOrderProducts = OrderProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderProductPeer::PRODUCT_ID, $this->getId());

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

		$criteria->add(OrderProductPeer::PRODUCT_ID, $this->getId());

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
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related OrderProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
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

				$criteria->add(OrderProductPeer::PRODUCT_ID, $this->getId());

				$this->collOrderProducts = OrderProductPeer::doSelectJoinOrder($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderProductPeer::PRODUCT_ID, $this->getId());

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
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related OrderProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getOrderProductsJoinTax($criteria = null, $con = null)
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

				$criteria->add(OrderProductPeer::PRODUCT_ID, $this->getId());

				$this->collOrderProducts = OrderProductPeer::doSelectJoinTax($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderProductPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastOrderProductCriteria) || !$this->lastOrderProductCriteria->equals($criteria)) {
				$this->collOrderProducts = OrderProductPeer::doSelectJoinTax($criteria, $con);
			}
		}
		$this->lastOrderProductCriteria = $criteria;

		return $this->collOrderProducts;
	}

	/**
	 * Temporary storage of collOrderProductHasSets to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOrderProductHasSets()
	{
		if ($this->collOrderProductHasSets === null) {
			$this->collOrderProductHasSets = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related OrderProductHasSets from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOrderProductHasSets($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderProductHasSets === null) {
			if ($this->isNew()) {
			   $this->collOrderProductHasSets = array();
			} else {

				$criteria->add(OrderProductHasSetPeer::PRODUCT_ID, $this->getId());

				OrderProductHasSetPeer::addSelectColumns($criteria);
				$this->collOrderProductHasSets = OrderProductHasSetPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OrderProductHasSetPeer::PRODUCT_ID, $this->getId());

				OrderProductHasSetPeer::addSelectColumns($criteria);
				if (!isset($this->lastOrderProductHasSetCriteria) || !$this->lastOrderProductHasSetCriteria->equals($criteria)) {
					$this->collOrderProductHasSets = OrderProductHasSetPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOrderProductHasSetCriteria = $criteria;
		return $this->collOrderProductHasSets;
	}

	/**
	 * Returns the number of related OrderProductHasSets.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOrderProductHasSets($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OrderProductHasSetPeer::PRODUCT_ID, $this->getId());

		return OrderProductHasSetPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a OrderProductHasSet object to this object
	 * through the OrderProductHasSet foreign key attribute
	 *
	 * @param      OrderProductHasSet $l OrderProductHasSet
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOrderProductHasSet(OrderProductHasSet $l)
	{
		$this->collOrderProductHasSets[] = $l;
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related OrderProductHasSets from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getOrderProductHasSetsJoinOrderProduct($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOrderProductHasSets === null) {
			if ($this->isNew()) {
				$this->collOrderProductHasSets = array();
			} else {

				$criteria->add(OrderProductHasSetPeer::PRODUCT_ID, $this->getId());

				$this->collOrderProductHasSets = OrderProductHasSetPeer::doSelectJoinOrderProduct($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(OrderProductHasSetPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastOrderProductHasSetCriteria) || !$this->lastOrderProductHasSetCriteria->equals($criteria)) {
				$this->collOrderProductHasSets = OrderProductHasSetPeer::doSelectJoinOrderProduct($criteria, $con);
			}
		}
		$this->lastOrderProductHasSetCriteria = $criteria;

		return $this->collOrderProductHasSets;
	}

	/**
	 * Temporary storage of collCeneos to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initCeneos()
	{
		if ($this->collCeneos === null) {
			$this->collCeneos = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related Ceneos from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getCeneos($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCeneos === null) {
			if ($this->isNew()) {
			   $this->collCeneos = array();
			} else {

				$criteria->add(CeneoPeer::PRODUCT_ID, $this->getId());

				CeneoPeer::addSelectColumns($criteria);
				$this->collCeneos = CeneoPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(CeneoPeer::PRODUCT_ID, $this->getId());

				CeneoPeer::addSelectColumns($criteria);
				if (!isset($this->lastCeneoCriteria) || !$this->lastCeneoCriteria->equals($criteria)) {
					$this->collCeneos = CeneoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCeneoCriteria = $criteria;
		return $this->collCeneos;
	}

	/**
	 * Returns the number of related Ceneos.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countCeneos($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CeneoPeer::PRODUCT_ID, $this->getId());

		return CeneoPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Ceneo object to this object
	 * through the Ceneo foreign key attribute
	 *
	 * @param      Ceneo $l Ceneo
	 * @return     void
	 * @throws     PropelException
	 */
	public function addCeneo(Ceneo $l)
	{
		$this->collCeneos[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collGiftCardHasProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initGiftCardHasProducts()
	{
		if ($this->collGiftCardHasProducts === null) {
			$this->collGiftCardHasProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related GiftCardHasProducts from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getGiftCardHasProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGiftCardHasProducts === null) {
			if ($this->isNew()) {
			   $this->collGiftCardHasProducts = array();
			} else {

				$criteria->add(GiftCardHasProductPeer::PRODUCT_ID, $this->getId());

				GiftCardHasProductPeer::addSelectColumns($criteria);
				$this->collGiftCardHasProducts = GiftCardHasProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GiftCardHasProductPeer::PRODUCT_ID, $this->getId());

				GiftCardHasProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastGiftCardHasProductCriteria) || !$this->lastGiftCardHasProductCriteria->equals($criteria)) {
					$this->collGiftCardHasProducts = GiftCardHasProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGiftCardHasProductCriteria = $criteria;
		return $this->collGiftCardHasProducts;
	}

	/**
	 * Returns the number of related GiftCardHasProducts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countGiftCardHasProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(GiftCardHasProductPeer::PRODUCT_ID, $this->getId());

		return GiftCardHasProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a GiftCardHasProduct object to this object
	 * through the GiftCardHasProduct foreign key attribute
	 *
	 * @param      GiftCardHasProduct $l GiftCardHasProduct
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGiftCardHasProduct(GiftCardHasProduct $l)
	{
		$this->collGiftCardHasProducts[] = $l;
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related GiftCardHasProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getGiftCardHasProductsJoinGiftCard($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGiftCardHasProducts === null) {
			if ($this->isNew()) {
				$this->collGiftCardHasProducts = array();
			} else {

				$criteria->add(GiftCardHasProductPeer::PRODUCT_ID, $this->getId());

				$this->collGiftCardHasProducts = GiftCardHasProductPeer::doSelectJoinGiftCard($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(GiftCardHasProductPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastGiftCardHasProductCriteria) || !$this->lastGiftCardHasProductCriteria->equals($criteria)) {
				$this->collGiftCardHasProducts = GiftCardHasProductPeer::doSelectJoinGiftCard($criteria, $con);
			}
		}
		$this->lastGiftCardHasProductCriteria = $criteria;

		return $this->collGiftCardHasProducts;
	}

	/**
	 * Temporary storage of collReviews to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initReviews()
	{
		if ($this->collReviews === null) {
			$this->collReviews = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related Reviews from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getReviews($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReviews === null) {
			if ($this->isNew()) {
			   $this->collReviews = array();
			} else {

				$criteria->add(ReviewPeer::PRODUCT_ID, $this->getId());

				ReviewPeer::addSelectColumns($criteria);
				$this->collReviews = ReviewPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ReviewPeer::PRODUCT_ID, $this->getId());

				ReviewPeer::addSelectColumns($criteria);
				if (!isset($this->lastReviewCriteria) || !$this->lastReviewCriteria->equals($criteria)) {
					$this->collReviews = ReviewPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastReviewCriteria = $criteria;
		return $this->collReviews;
	}

	/**
	 * Returns the number of related Reviews.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countReviews($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ReviewPeer::PRODUCT_ID, $this->getId());

		return ReviewPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Review object to this object
	 * through the Review foreign key attribute
	 *
	 * @param      Review $l Review
	 * @return     void
	 * @throws     PropelException
	 */
	public function addReview(Review $l)
	{
		$this->collReviews[] = $l;
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related Reviews from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getReviewsJoinOrder($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReviews === null) {
			if ($this->isNew()) {
				$this->collReviews = array();
			} else {

				$criteria->add(ReviewPeer::PRODUCT_ID, $this->getId());

				$this->collReviews = ReviewPeer::doSelectJoinOrder($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ReviewPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastReviewCriteria) || !$this->lastReviewCriteria->equals($criteria)) {
				$this->collReviews = ReviewPeer::doSelectJoinOrder($criteria, $con);
			}
		}
		$this->lastReviewCriteria = $criteria;

		return $this->collReviews;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related Reviews from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getReviewsJoinsfGuardUser($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collReviews === null) {
			if ($this->isNew()) {
				$this->collReviews = array();
			} else {

				$criteria->add(ReviewPeer::PRODUCT_ID, $this->getId());

				$this->collReviews = ReviewPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ReviewPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastReviewCriteria) || !$this->lastReviewCriteria->equals($criteria)) {
				$this->collReviews = ReviewPeer::doSelectJoinsfGuardUser($criteria, $con);
			}
		}
		$this->lastReviewCriteria = $criteria;

		return $this->collReviews;
	}

	/**
	 * Temporary storage of collappProductAttributeVariantHasProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initappProductAttributeVariantHasProducts()
	{
		if ($this->collappProductAttributeVariantHasProducts === null) {
			$this->collappProductAttributeVariantHasProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related appProductAttributeVariantHasProducts from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getappProductAttributeVariantHasProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collappProductAttributeVariantHasProducts === null) {
			if ($this->isNew()) {
			   $this->collappProductAttributeVariantHasProducts = array();
			} else {

				$criteria->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $this->getId());

				appProductAttributeVariantHasProductPeer::addSelectColumns($criteria);
				$this->collappProductAttributeVariantHasProducts = appProductAttributeVariantHasProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $this->getId());

				appProductAttributeVariantHasProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastappProductAttributeVariantHasProductCriteria) || !$this->lastappProductAttributeVariantHasProductCriteria->equals($criteria)) {
					$this->collappProductAttributeVariantHasProducts = appProductAttributeVariantHasProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastappProductAttributeVariantHasProductCriteria = $criteria;
		return $this->collappProductAttributeVariantHasProducts;
	}

	/**
	 * Returns the number of related appProductAttributeVariantHasProducts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countappProductAttributeVariantHasProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $this->getId());

		return appProductAttributeVariantHasProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a appProductAttributeVariantHasProduct object to this object
	 * through the appProductAttributeVariantHasProduct foreign key attribute
	 *
	 * @param      appProductAttributeVariantHasProduct $l appProductAttributeVariantHasProduct
	 * @return     void
	 * @throws     PropelException
	 */
	public function addappProductAttributeVariantHasProduct(appProductAttributeVariantHasProduct $l)
	{
		$this->collappProductAttributeVariantHasProducts[] = $l;
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related appProductAttributeVariantHasProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getappProductAttributeVariantHasProductsJoinappProductAttributeVariant($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collappProductAttributeVariantHasProducts === null) {
			if ($this->isNew()) {
				$this->collappProductAttributeVariantHasProducts = array();
			} else {

				$criteria->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $this->getId());

				$this->collappProductAttributeVariantHasProducts = appProductAttributeVariantHasProductPeer::doSelectJoinappProductAttributeVariant($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastappProductAttributeVariantHasProductCriteria) || !$this->lastappProductAttributeVariantHasProductCriteria->equals($criteria)) {
				$this->collappProductAttributeVariantHasProducts = appProductAttributeVariantHasProductPeer::doSelectJoinappProductAttributeVariant($criteria, $con);
			}
		}
		$this->lastappProductAttributeVariantHasProductCriteria = $criteria;

		return $this->collappProductAttributeVariantHasProducts;
	}

	/**
	 * Temporary storage of collOnets to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOnets()
	{
		if ($this->collOnets === null) {
			$this->collOnets = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related Onets from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOnets($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOnets === null) {
			if ($this->isNew()) {
			   $this->collOnets = array();
			} else {

				$criteria->add(OnetPeer::PRODUCT_ID, $this->getId());

				OnetPeer::addSelectColumns($criteria);
				$this->collOnets = OnetPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OnetPeer::PRODUCT_ID, $this->getId());

				OnetPeer::addSelectColumns($criteria);
				if (!isset($this->lastOnetCriteria) || !$this->lastOnetCriteria->equals($criteria)) {
					$this->collOnets = OnetPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOnetCriteria = $criteria;
		return $this->collOnets;
	}

	/**
	 * Returns the number of related Onets.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOnets($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OnetPeer::PRODUCT_ID, $this->getId());

		return OnetPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Onet object to this object
	 * through the Onet foreign key attribute
	 *
	 * @param      Onet $l Onet
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOnet(Onet $l)
	{
		$this->collOnets[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collZakupomats to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initZakupomats()
	{
		if ($this->collZakupomats === null) {
			$this->collZakupomats = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related Zakupomats from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getZakupomats($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collZakupomats === null) {
			if ($this->isNew()) {
			   $this->collZakupomats = array();
			} else {

				$criteria->add(ZakupomatPeer::PRODUCT_ID, $this->getId());

				ZakupomatPeer::addSelectColumns($criteria);
				$this->collZakupomats = ZakupomatPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ZakupomatPeer::PRODUCT_ID, $this->getId());

				ZakupomatPeer::addSelectColumns($criteria);
				if (!isset($this->lastZakupomatCriteria) || !$this->lastZakupomatCriteria->equals($criteria)) {
					$this->collZakupomats = ZakupomatPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastZakupomatCriteria = $criteria;
		return $this->collZakupomats;
	}

	/**
	 * Returns the number of related Zakupomats.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countZakupomats($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ZakupomatPeer::PRODUCT_ID, $this->getId());

		return ZakupomatPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Zakupomat object to this object
	 * through the Zakupomat foreign key attribute
	 *
	 * @param      Zakupomat $l Zakupomat
	 * @return     void
	 * @throws     PropelException
	 */
	public function addZakupomat(Zakupomat $l)
	{
		$this->collZakupomats[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collOkazjes to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOkazjes()
	{
		if ($this->collOkazjes === null) {
			$this->collOkazjes = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related Okazjes from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOkazjes($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOkazjes === null) {
			if ($this->isNew()) {
			   $this->collOkazjes = array();
			} else {

				$criteria->add(OkazjePeer::PRODUCT_ID, $this->getId());

				OkazjePeer::addSelectColumns($criteria);
				$this->collOkazjes = OkazjePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OkazjePeer::PRODUCT_ID, $this->getId());

				OkazjePeer::addSelectColumns($criteria);
				if (!isset($this->lastOkazjeCriteria) || !$this->lastOkazjeCriteria->equals($criteria)) {
					$this->collOkazjes = OkazjePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOkazjeCriteria = $criteria;
		return $this->collOkazjes;
	}

	/**
	 * Returns the number of related Okazjes.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOkazjes($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OkazjePeer::PRODUCT_ID, $this->getId());

		return OkazjePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Okazje object to this object
	 * through the Okazje foreign key attribute
	 *
	 * @param      Okazje $l Okazje
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOkazje(Okazje $l)
	{
		$this->collOkazjes[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collProductOptionsValues to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductOptionsValues()
	{
		if ($this->collProductOptionsValues === null) {
			$this->collProductOptionsValues = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductOptionsValues($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
			   $this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_ID, $this->getId());

				ProductOptionsValuePeer::addSelectColumns($criteria);
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductOptionsValuePeer::PRODUCT_ID, $this->getId());

				ProductOptionsValuePeer::addSelectColumns($criteria);
				if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
					$this->collProductOptionsValues = ProductOptionsValuePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;
		return $this->collProductOptionsValues;
	}

	/**
	 * Returns the number of related ProductOptionsValues.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductOptionsValues($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductOptionsValuePeer::PRODUCT_ID, $this->getId());

		return ProductOptionsValuePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductOptionsValue object to this object
	 * through the ProductOptionsValue foreign key attribute
	 *
	 * @param      ProductOptionsValue $l ProductOptionsValue
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductOptionsValue(ProductOptionsValue $l)
	{
		$this->collProductOptionsValues[] = $l;
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductOptionsValuesJoinsfAsset($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinsfAsset($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinsfAsset($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductOptionsValuesJoinProductOptionsTemplate($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsTemplate($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsTemplate($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductOptionsValuesJoinProductOptionsValueRelatedByProductOptionsValueId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsValueRelatedByProductOptionsValueId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsValueRelatedByProductOptionsValueId($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductOptionsValues from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductOptionsValuesJoinProductOptionsField($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductOptionsValues === null) {
			if ($this->isNew()) {
				$this->collProductOptionsValues = array();
			} else {

				$criteria->add(ProductOptionsValuePeer::PRODUCT_ID, $this->getId());

				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsField($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductOptionsValuePeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastProductOptionsValueCriteria) || !$this->lastProductOptionsValueCriteria->equals($criteria)) {
				$this->collProductOptionsValues = ProductOptionsValuePeer::doSelectJoinProductOptionsField($criteria, $con);
			}
		}
		$this->lastProductOptionsValueCriteria = $criteria;

		return $this->collProductOptionsValues;
	}

	/**
	 * Temporary storage of collProductSearchIndexs to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductSearchIndexs()
	{
		if ($this->collProductSearchIndexs === null) {
			$this->collProductSearchIndexs = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductSearchIndexs from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductSearchIndexs($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductSearchIndexs === null) {
			if ($this->isNew()) {
			   $this->collProductSearchIndexs = array();
			} else {

				$criteria->add(ProductSearchIndexPeer::ID, $this->getId());

				ProductSearchIndexPeer::addSelectColumns($criteria);
				$this->collProductSearchIndexs = ProductSearchIndexPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductSearchIndexPeer::ID, $this->getId());

				ProductSearchIndexPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductSearchIndexCriteria) || !$this->lastProductSearchIndexCriteria->equals($criteria)) {
					$this->collProductSearchIndexs = ProductSearchIndexPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductSearchIndexCriteria = $criteria;
		return $this->collProductSearchIndexs;
	}

	/**
	 * Returns the number of related ProductSearchIndexs.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductSearchIndexs($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductSearchIndexPeer::ID, $this->getId());

		return ProductSearchIndexPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductSearchIndex object to this object
	 * through the ProductSearchIndex foreign key attribute
	 *
	 * @param      ProductSearchIndex $l ProductSearchIndex
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductSearchIndex(ProductSearchIndex $l)
	{
		$this->collProductSearchIndexs[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collProductHasProductSearchTags to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductHasProductSearchTags()
	{
		if ($this->collProductHasProductSearchTags === null) {
			$this->collProductHasProductSearchTags = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductHasProductSearchTags from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductHasProductSearchTags($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasProductSearchTags === null) {
			if ($this->isNew()) {
			   $this->collProductHasProductSearchTags = array();
			} else {

				$criteria->add(ProductHasProductSearchTagPeer::PRODUCT_ID, $this->getId());

				ProductHasProductSearchTagPeer::addSelectColumns($criteria);
				$this->collProductHasProductSearchTags = ProductHasProductSearchTagPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasProductSearchTagPeer::PRODUCT_ID, $this->getId());

				ProductHasProductSearchTagPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductHasProductSearchTagCriteria) || !$this->lastProductHasProductSearchTagCriteria->equals($criteria)) {
					$this->collProductHasProductSearchTags = ProductHasProductSearchTagPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductHasProductSearchTagCriteria = $criteria;
		return $this->collProductHasProductSearchTags;
	}

	/**
	 * Returns the number of related ProductHasProductSearchTags.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductHasProductSearchTags($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductHasProductSearchTagPeer::PRODUCT_ID, $this->getId());

		return ProductHasProductSearchTagPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductHasProductSearchTag object to this object
	 * through the ProductHasProductSearchTag foreign key attribute
	 *
	 * @param      ProductHasProductSearchTag $l ProductHasProductSearchTag
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductHasProductSearchTag(ProductHasProductSearchTag $l)
	{
		$this->collProductHasProductSearchTags[] = $l;
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductHasProductSearchTags from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductHasProductSearchTagsJoinProductSearchTag($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasProductSearchTags === null) {
			if ($this->isNew()) {
				$this->collProductHasProductSearchTags = array();
			} else {

				$criteria->add(ProductHasProductSearchTagPeer::PRODUCT_ID, $this->getId());

				$this->collProductHasProductSearchTags = ProductHasProductSearchTagPeer::doSelectJoinProductSearchTag($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductHasProductSearchTagPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastProductHasProductSearchTagCriteria) || !$this->lastProductHasProductSearchTagCriteria->equals($criteria)) {
				$this->collProductHasProductSearchTags = ProductHasProductSearchTagPeer::doSelectJoinProductSearchTag($criteria, $con);
			}
		}
		$this->lastProductHasProductSearchTagCriteria = $criteria;

		return $this->collProductHasProductSearchTags;
	}

	/**
	 * Temporary storage of collBasketProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initBasketProducts()
	{
		if ($this->collBasketProducts === null) {
			$this->collBasketProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related BasketProducts from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getBasketProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBasketProducts === null) {
			if ($this->isNew()) {
			   $this->collBasketProducts = array();
			} else {

				$criteria->add(BasketProductPeer::PRODUCT_ID, $this->getId());

				BasketProductPeer::addSelectColumns($criteria);
				$this->collBasketProducts = BasketProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(BasketProductPeer::PRODUCT_ID, $this->getId());

				BasketProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastBasketProductCriteria) || !$this->lastBasketProductCriteria->equals($criteria)) {
					$this->collBasketProducts = BasketProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastBasketProductCriteria = $criteria;
		return $this->collBasketProducts;
	}

	/**
	 * Returns the number of related BasketProducts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countBasketProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(BasketProductPeer::PRODUCT_ID, $this->getId());

		return BasketProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a BasketProduct object to this object
	 * through the BasketProduct foreign key attribute
	 *
	 * @param      BasketProduct $l BasketProduct
	 * @return     void
	 * @throws     PropelException
	 */
	public function addBasketProduct(BasketProduct $l)
	{
		$this->collBasketProducts[] = $l;
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related BasketProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getBasketProductsJoinBasket($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collBasketProducts === null) {
			if ($this->isNew()) {
				$this->collBasketProducts = array();
			} else {

				$criteria->add(BasketProductPeer::PRODUCT_ID, $this->getId());

				$this->collBasketProducts = BasketProductPeer::doSelectJoinBasket($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(BasketProductPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastBasketProductCriteria) || !$this->lastBasketProductCriteria->equals($criteria)) {
				$this->collBasketProducts = BasketProductPeer::doSelectJoinBasket($criteria, $con);
			}
		}
		$this->lastBasketProductCriteria = $criteria;

		return $this->collBasketProducts;
	}

	/**
	 * Temporary storage of collInvoiceProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initInvoiceProducts()
	{
		if ($this->collInvoiceProducts === null) {
			$this->collInvoiceProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related InvoiceProducts from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getInvoiceProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collInvoiceProducts === null) {
			if ($this->isNew()) {
			   $this->collInvoiceProducts = array();
			} else {

				$criteria->add(InvoiceProductPeer::PRODUCT_ID, $this->getId());

				InvoiceProductPeer::addSelectColumns($criteria);
				$this->collInvoiceProducts = InvoiceProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(InvoiceProductPeer::PRODUCT_ID, $this->getId());

				InvoiceProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastInvoiceProductCriteria) || !$this->lastInvoiceProductCriteria->equals($criteria)) {
					$this->collInvoiceProducts = InvoiceProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastInvoiceProductCriteria = $criteria;
		return $this->collInvoiceProducts;
	}

	/**
	 * Returns the number of related InvoiceProducts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countInvoiceProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(InvoiceProductPeer::PRODUCT_ID, $this->getId());

		return InvoiceProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a InvoiceProduct object to this object
	 * through the InvoiceProduct foreign key attribute
	 *
	 * @param      InvoiceProduct $l InvoiceProduct
	 * @return     void
	 * @throws     PropelException
	 */
	public function addInvoiceProduct(InvoiceProduct $l)
	{
		$this->collInvoiceProducts[] = $l;
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related InvoiceProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getInvoiceProductsJoinInvoice($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collInvoiceProducts === null) {
			if ($this->isNew()) {
				$this->collInvoiceProducts = array();
			} else {

				$criteria->add(InvoiceProductPeer::PRODUCT_ID, $this->getId());

				$this->collInvoiceProducts = InvoiceProductPeer::doSelectJoinInvoice($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(InvoiceProductPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastInvoiceProductCriteria) || !$this->lastInvoiceProductCriteria->equals($criteria)) {
				$this->collInvoiceProducts = InvoiceProductPeer::doSelectJoinInvoice($criteria, $con);
			}
		}
		$this->lastInvoiceProductCriteria = $criteria;

		return $this->collInvoiceProducts;
	}

	/**
	 * Temporary storage of collOferciaks to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initOferciaks()
	{
		if ($this->collOferciaks === null) {
			$this->collOferciaks = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related Oferciaks from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getOferciaks($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOferciaks === null) {
			if ($this->isNew()) {
			   $this->collOferciaks = array();
			} else {

				$criteria->add(OferciakPeer::PRODUCT_ID, $this->getId());

				OferciakPeer::addSelectColumns($criteria);
				$this->collOferciaks = OferciakPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OferciakPeer::PRODUCT_ID, $this->getId());

				OferciakPeer::addSelectColumns($criteria);
				if (!isset($this->lastOferciakCriteria) || !$this->lastOferciakCriteria->equals($criteria)) {
					$this->collOferciaks = OferciakPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOferciakCriteria = $criteria;
		return $this->collOferciaks;
	}

	/**
	 * Returns the number of related Oferciaks.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countOferciaks($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OferciakPeer::PRODUCT_ID, $this->getId());

		return OferciakPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Oferciak object to this object
	 * through the Oferciak foreign key attribute
	 *
	 * @param      Oferciak $l Oferciak
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOferciak(Oferciak $l)
	{
		$this->collOferciaks[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collProductHasAccessoriessRelatedByAccessoriesId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductHasAccessoriessRelatedByAccessoriesId()
	{
		if ($this->collProductHasAccessoriessRelatedByAccessoriesId === null) {
			$this->collProductHasAccessoriessRelatedByAccessoriesId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductHasAccessoriessRelatedByAccessoriesId from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductHasAccessoriessRelatedByAccessoriesId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasAccessoriessRelatedByAccessoriesId === null) {
			if ($this->isNew()) {
			   $this->collProductHasAccessoriessRelatedByAccessoriesId = array();
			} else {

				$criteria->add(ProductHasAccessoriesPeer::ACCESSORIES_ID, $this->getId());

				ProductHasAccessoriesPeer::addSelectColumns($criteria);
				$this->collProductHasAccessoriessRelatedByAccessoriesId = ProductHasAccessoriesPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasAccessoriesPeer::ACCESSORIES_ID, $this->getId());

				ProductHasAccessoriesPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductHasAccessoriesRelatedByAccessoriesIdCriteria) || !$this->lastProductHasAccessoriesRelatedByAccessoriesIdCriteria->equals($criteria)) {
					$this->collProductHasAccessoriessRelatedByAccessoriesId = ProductHasAccessoriesPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductHasAccessoriesRelatedByAccessoriesIdCriteria = $criteria;
		return $this->collProductHasAccessoriessRelatedByAccessoriesId;
	}

	/**
	 * Returns the number of related ProductHasAccessoriessRelatedByAccessoriesId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductHasAccessoriessRelatedByAccessoriesId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductHasAccessoriesPeer::ACCESSORIES_ID, $this->getId());

		return ProductHasAccessoriesPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductHasAccessories object to this object
	 * through the ProductHasAccessories foreign key attribute
	 *
	 * @param      ProductHasAccessories $l ProductHasAccessories
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductHasAccessoriesRelatedByAccessoriesId(ProductHasAccessories $l)
	{
		$this->collProductHasAccessoriessRelatedByAccessoriesId[] = $l;
		$l->setProductRelatedByAccessoriesId($this);
	}

	/**
	 * Temporary storage of collProductHasAccessoriessRelatedByProductId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductHasAccessoriessRelatedByProductId()
	{
		if ($this->collProductHasAccessoriessRelatedByProductId === null) {
			$this->collProductHasAccessoriessRelatedByProductId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductHasAccessoriessRelatedByProductId from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductHasAccessoriessRelatedByProductId($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasAccessoriessRelatedByProductId === null) {
			if ($this->isNew()) {
			   $this->collProductHasAccessoriessRelatedByProductId = array();
			} else {

				$criteria->add(ProductHasAccessoriesPeer::PRODUCT_ID, $this->getId());

				ProductHasAccessoriesPeer::addSelectColumns($criteria);
				$this->collProductHasAccessoriessRelatedByProductId = ProductHasAccessoriesPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasAccessoriesPeer::PRODUCT_ID, $this->getId());

				ProductHasAccessoriesPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductHasAccessoriesRelatedByProductIdCriteria) || !$this->lastProductHasAccessoriesRelatedByProductIdCriteria->equals($criteria)) {
					$this->collProductHasAccessoriessRelatedByProductId = ProductHasAccessoriesPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductHasAccessoriesRelatedByProductIdCriteria = $criteria;
		return $this->collProductHasAccessoriessRelatedByProductId;
	}

	/**
	 * Returns the number of related ProductHasAccessoriessRelatedByProductId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductHasAccessoriessRelatedByProductId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductHasAccessoriesPeer::PRODUCT_ID, $this->getId());

		return ProductHasAccessoriesPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductHasAccessories object to this object
	 * through the ProductHasAccessories foreign key attribute
	 *
	 * @param      ProductHasAccessories $l ProductHasAccessories
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductHasAccessoriesRelatedByProductId(ProductHasAccessories $l)
	{
		$this->collProductHasAccessoriessRelatedByProductId[] = $l;
		$l->setProductRelatedByProductId($this);
	}

	/**
	 * Temporary storage of collWps to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initWps()
	{
		if ($this->collWps === null) {
			$this->collWps = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related Wps from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getWps($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collWps === null) {
			if ($this->isNew()) {
			   $this->collWps = array();
			} else {

				$criteria->add(WpPeer::PRODUCT_ID, $this->getId());

				WpPeer::addSelectColumns($criteria);
				$this->collWps = WpPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(WpPeer::PRODUCT_ID, $this->getId());

				WpPeer::addSelectColumns($criteria);
				if (!isset($this->lastWpCriteria) || !$this->lastWpCriteria->equals($criteria)) {
					$this->collWps = WpPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastWpCriteria = $criteria;
		return $this->collWps;
	}

	/**
	 * Returns the number of related Wps.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countWps($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(WpPeer::PRODUCT_ID, $this->getId());

		return WpPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Wp object to this object
	 * through the Wp foreign key attribute
	 *
	 * @param      Wp $l Wp
	 * @return     void
	 * @throws     PropelException
	 */
	public function addWp(Wp $l)
	{
		$this->collWps[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collNokauts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initNokauts()
	{
		if ($this->collNokauts === null) {
			$this->collNokauts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related Nokauts from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getNokauts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNokauts === null) {
			if ($this->isNew()) {
			   $this->collNokauts = array();
			} else {

				$criteria->add(NokautPeer::PRODUCT_ID, $this->getId());

				NokautPeer::addSelectColumns($criteria);
				$this->collNokauts = NokautPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(NokautPeer::PRODUCT_ID, $this->getId());

				NokautPeer::addSelectColumns($criteria);
				if (!isset($this->lastNokautCriteria) || !$this->lastNokautCriteria->equals($criteria)) {
					$this->collNokauts = NokautPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastNokautCriteria = $criteria;
		return $this->collNokauts;
	}

	/**
	 * Returns the number of related Nokauts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countNokauts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(NokautPeer::PRODUCT_ID, $this->getId());

		return NokautPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Nokaut object to this object
	 * through the Nokaut foreign key attribute
	 *
	 * @param      Nokaut $l Nokaut
	 * @return     void
	 * @throws     PropelException
	 */
	public function addNokaut(Nokaut $l)
	{
		$this->collNokauts[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collProductHasPositionings to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductHasPositionings()
	{
		if ($this->collProductHasPositionings === null) {
			$this->collProductHasPositionings = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductHasPositionings from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductHasPositionings($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductHasPositionings === null) {
			if ($this->isNew()) {
			   $this->collProductHasPositionings = array();
			} else {

				$criteria->add(ProductHasPositioningPeer::PRODUCT_ID, $this->getId());

				ProductHasPositioningPeer::addSelectColumns($criteria);
				$this->collProductHasPositionings = ProductHasPositioningPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductHasPositioningPeer::PRODUCT_ID, $this->getId());

				ProductHasPositioningPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductHasPositioningCriteria) || !$this->lastProductHasPositioningCriteria->equals($criteria)) {
					$this->collProductHasPositionings = ProductHasPositioningPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductHasPositioningCriteria = $criteria;
		return $this->collProductHasPositionings;
	}

	/**
	 * Returns the number of related ProductHasPositionings.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductHasPositionings($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductHasPositioningPeer::PRODUCT_ID, $this->getId());

		return ProductHasPositioningPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductHasPositioning object to this object
	 * through the ProductHasPositioning foreign key attribute
	 *
	 * @param      ProductHasPositioning $l ProductHasPositioning
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductHasPositioning(ProductHasPositioning $l)
	{
		$this->collProductHasPositionings[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collSklepy24s to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initSklepy24s()
	{
		if ($this->collSklepy24s === null) {
			$this->collSklepy24s = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related Sklepy24s from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getSklepy24s($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSklepy24s === null) {
			if ($this->isNew()) {
			   $this->collSklepy24s = array();
			} else {

				$criteria->add(Sklepy24Peer::PRODUCT_ID, $this->getId());

				Sklepy24Peer::addSelectColumns($criteria);
				$this->collSklepy24s = Sklepy24Peer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(Sklepy24Peer::PRODUCT_ID, $this->getId());

				Sklepy24Peer::addSelectColumns($criteria);
				if (!isset($this->lastSklepy24Criteria) || !$this->lastSklepy24Criteria->equals($criteria)) {
					$this->collSklepy24s = Sklepy24Peer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSklepy24Criteria = $criteria;
		return $this->collSklepy24s;
	}

	/**
	 * Returns the number of related Sklepy24s.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countSklepy24s($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(Sklepy24Peer::PRODUCT_ID, $this->getId());

		return Sklepy24Peer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Sklepy24 object to this object
	 * through the Sklepy24 foreign key attribute
	 *
	 * @param      Sklepy24 $l Sklepy24
	 * @return     void
	 * @throws     PropelException
	 */
	public function addSklepy24(Sklepy24 $l)
	{
		$this->collSklepy24s[] = $l;
		$l->setProduct($this);
	}

	/**
	 * Temporary storage of collProductGroupHasProducts to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initProductGroupHasProducts()
	{
		if ($this->collProductGroupHasProducts === null) {
			$this->collProductGroupHasProducts = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related ProductGroupHasProducts from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getProductGroupHasProducts($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductGroupHasProducts === null) {
			if ($this->isNew()) {
			   $this->collProductGroupHasProducts = array();
			} else {

				$criteria->add(ProductGroupHasProductPeer::PRODUCT_ID, $this->getId());

				ProductGroupHasProductPeer::addSelectColumns($criteria);
				$this->collProductGroupHasProducts = ProductGroupHasProductPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ProductGroupHasProductPeer::PRODUCT_ID, $this->getId());

				ProductGroupHasProductPeer::addSelectColumns($criteria);
				if (!isset($this->lastProductGroupHasProductCriteria) || !$this->lastProductGroupHasProductCriteria->equals($criteria)) {
					$this->collProductGroupHasProducts = ProductGroupHasProductPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastProductGroupHasProductCriteria = $criteria;
		return $this->collProductGroupHasProducts;
	}

	/**
	 * Returns the number of related ProductGroupHasProducts.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countProductGroupHasProducts($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ProductGroupHasProductPeer::PRODUCT_ID, $this->getId());

		return ProductGroupHasProductPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ProductGroupHasProduct object to this object
	 * through the ProductGroupHasProduct foreign key attribute
	 *
	 * @param      ProductGroupHasProduct $l ProductGroupHasProduct
	 * @return     void
	 * @throws     PropelException
	 */
	public function addProductGroupHasProduct(ProductGroupHasProduct $l)
	{
		$this->collProductGroupHasProducts[] = $l;
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related ProductGroupHasProducts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getProductGroupHasProductsJoinProductGroup($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collProductGroupHasProducts === null) {
			if ($this->isNew()) {
				$this->collProductGroupHasProducts = array();
			} else {

				$criteria->add(ProductGroupHasProductPeer::PRODUCT_ID, $this->getId());

				$this->collProductGroupHasProducts = ProductGroupHasProductPeer::doSelectJoinProductGroup($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ProductGroupHasProductPeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastProductGroupHasProductCriteria) || !$this->lastProductGroupHasProductCriteria->equals($criteria)) {
				$this->collProductGroupHasProducts = ProductGroupHasProductPeer::doSelectJoinProductGroup($criteria, $con);
			}
		}
		$this->lastProductGroupHasProductCriteria = $criteria;

		return $this->collProductGroupHasProducts;
	}

	/**
	 * Temporary storage of collQuestionss to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initQuestionss()
	{
		if ($this->collQuestionss === null) {
			$this->collQuestionss = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product has previously
	 * been saved, it will retrieve related Questionss from storage.
	 * If this Product is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getQuestionss($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestionss === null) {
			if ($this->isNew()) {
			   $this->collQuestionss = array();
			} else {

				$criteria->add(QuestionsPeer::ITEM_ID, $this->getId());

				QuestionsPeer::addSelectColumns($criteria);
				$this->collQuestionss = QuestionsPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(QuestionsPeer::ITEM_ID, $this->getId());

				QuestionsPeer::addSelectColumns($criteria);
				if (!isset($this->lastQuestionsCriteria) || !$this->lastQuestionsCriteria->equals($criteria)) {
					$this->collQuestionss = QuestionsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastQuestionsCriteria = $criteria;
		return $this->collQuestionss;
	}

	/**
	 * Returns the number of related Questionss.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countQuestionss($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(QuestionsPeer::ITEM_ID, $this->getId());

		return QuestionsPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Questions object to this object
	 * through the Questions foreign key attribute
	 *
	 * @param      Questions $l Questions
	 * @return     void
	 * @throws     PropelException
	 */
	public function addQuestions(Questions $l)
	{
		$this->collQuestionss[] = $l;
		$l->setProduct($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Product is new, it will return
	 * an empty collection; or if this Product has previously
	 * been saved, it will retrieve related Questionss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Product.
	 */
	public function getQuestionssJoinQuestionStatus($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestionss === null) {
			if ($this->isNew()) {
				$this->collQuestionss = array();
			} else {

				$criteria->add(QuestionsPeer::ITEM_ID, $this->getId());

				$this->collQuestionss = QuestionsPeer::doSelectJoinQuestionStatus($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(QuestionsPeer::ITEM_ID, $this->getId());

			if (!isset($this->lastQuestionsCriteria) || !$this->lastQuestionsCriteria->equals($criteria)) {
				$this->collQuestionss = QuestionsPeer::doSelectJoinQuestionStatus($criteria, $con);
			}
		}
		$this->lastQuestionsCriteria = $criteria;

		return $this->collQuestionss;
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
    $obj = $this->getCurrentProductI18n();

    return ($obj ? $obj->getName() : null);
  }

  public function setName($value)
  {
    $this->getCurrentProductI18n()->setName($value);
  }

  public function getShortDescription()
  {
    $obj = $this->getCurrentProductI18n();

    return ($obj ? $obj->getShortDescription() : null);
  }

  public function setShortDescription($value)
  {
    $this->getCurrentProductI18n()->setShortDescription($value);
  }

  public function getDescription()
  {
    $obj = $this->getCurrentProductI18n();

    return ($obj ? $obj->getDescription() : null);
  }

  public function setDescription($value)
  {
    $this->getCurrentProductI18n()->setDescription($value);
  }

  public function getSearchKeywords()
  {
    $obj = $this->getCurrentProductI18n();

    return ($obj ? $obj->getSearchKeywords() : null);
  }

  public function setSearchKeywords($value)
  {
    $this->getCurrentProductI18n()->setSearchKeywords($value);
  }

  public function getUrl()
  {
    $obj = $this->getCurrentProductI18n();

    return ($obj ? $obj->getUrl() : null);
  }

  public function setUrl($value)
  {
    $this->getCurrentProductI18n()->setUrl($value);
  }

  public function getUom()
  {
    $obj = $this->getCurrentProductI18n();

    return ($obj ? $obj->getUom() : null);
  }

  public function setUom($value)
  {
    $this->getCurrentProductI18n()->setUom($value);
  }

  public function getExecutionTime()
  {
    $obj = $this->getCurrentProductI18n();

    return ($obj ? $obj->getExecutionTime() : null);
  }

  public function setExecutionTime($value)
  {
    $this->getCurrentProductI18n()->setExecutionTime($value);
  }

  public function getDescription2()
  {
    $obj = $this->getCurrentProductI18n();

    return ($obj ? $obj->getDescription2() : null);
  }

  public function setDescription2($value)
  {
    $this->getCurrentProductI18n()->setDescription2($value);
  }

  public function getAttributesLabel()
  {
    $obj = $this->getCurrentProductI18n();

    return ($obj ? $obj->getAttributesLabel() : null);
  }

  public function setAttributesLabel($value)
  {
    $this->getCurrentProductI18n()->setAttributesLabel($value);
  }

  public $current_i18n = array();

  public function getCurrentProductI18n()
  {
    if (!isset($this->current_i18n[$this->culture]))
    {
      $obj = ProductI18nPeer::retrieveByPK($this->getId(), $this->culture);
      if ($obj)
      {
        $this->setProductI18nForCulture($obj, $this->culture);
      }
      else
      {
        $this->setProductI18nForCulture(new ProductI18n(), $this->culture);
        $this->current_i18n[$this->culture]->setCulture($this->culture);
      }
    }

    return $this->current_i18n[$this->culture];
  }

  public function setProductI18nForCulture($object, $culture)
  {
    $this->current_i18n[$culture] = $object;
    $this->addProductI18n($object);
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
      $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'Product.' . $method, array('arguments' => $arguments, 'method' => $method)));

      if ($event->isProcessed())
      {
          return $event->getReturnValue();
      }

      if (!$callable = sfMixer::getCallable('BaseProduct:'.$method))
      {
        throw new sfException(sprintf('Call to undefined method BaseProduct::%s', $method));
      }

      array_unshift($arguments, $this);

      return call_user_func_array($callable, $arguments);
  }

} // BaseProduct
