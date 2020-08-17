<?php

/**
 * Base static class for performing query and update operations on the 'st_product' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseProductPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'st_product';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.Product';

	/** The total number of columns. */
	const NUM_COLUMNS = 69;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'st_product.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'st_product.UPDATED_AT';

	/** the column name for the ID field */
	const ID = 'st_product.ID';

	/** the column name for the PARENT_ID field */
	const PARENT_ID = 'st_product.PARENT_ID';

	/** the column name for the CURRENCY_ID field */
	const CURRENCY_ID = 'st_product.CURRENCY_ID';

	/** the column name for the PRODUCER_ID field */
	const PRODUCER_ID = 'st_product.PRODUCER_ID';

	/** the column name for the CODE field */
	const CODE = 'st_product.CODE';

	/** the column name for the PRICE field */
	const PRICE = 'st_product.PRICE';

	/** the column name for the OPT_PRICE_BRUTTO field */
	const OPT_PRICE_BRUTTO = 'st_product.OPT_PRICE_BRUTTO';

	/** the column name for the DELIVERY_PRICE field */
	const DELIVERY_PRICE = 'st_product.DELIVERY_PRICE';

	/** the column name for the BPUM_DEFAULT_ID field */
	const BPUM_DEFAULT_ID = 'st_product.BPUM_DEFAULT_ID';

	/** the column name for the BPUM_DEFAULT_VALUE field */
	const BPUM_DEFAULT_VALUE = 'st_product.BPUM_DEFAULT_VALUE';

	/** the column name for the BPUM_ID field */
	const BPUM_ID = 'st_product.BPUM_ID';

	/** the column name for the BPUM_VALUE field */
	const BPUM_VALUE = 'st_product.BPUM_VALUE';

	/** the column name for the CURRENCY_PRICE field */
	const CURRENCY_PRICE = 'st_product.CURRENCY_PRICE';

	/** the column name for the OLD_PRICE field */
	const OLD_PRICE = 'st_product.OLD_PRICE';

	/** the column name for the OPT_OLD_PRICE_BRUTTO field */
	const OPT_OLD_PRICE_BRUTTO = 'st_product.OPT_OLD_PRICE_BRUTTO';

	/** the column name for the POINTS_VALUE field */
	const POINTS_VALUE = 'st_product.POINTS_VALUE';

	/** the column name for the POINTS_EARN field */
	const POINTS_EARN = 'st_product.POINTS_EARN';

	/** the column name for the POINTS_ONLY field */
	const POINTS_ONLY = 'st_product.POINTS_ONLY';

	/** the column name for the CURRENCY_OLD_PRICE field */
	const CURRENCY_OLD_PRICE = 'st_product.CURRENCY_OLD_PRICE';

	/** the column name for the OPT_VAT field */
	const OPT_VAT = 'st_product.OPT_VAT';

	/** the column name for the CURRENCY_EXCHANGE field */
	const CURRENCY_EXCHANGE = 'st_product.CURRENCY_EXCHANGE';

	/** the column name for the ACTIVE field */
	const ACTIVE = 'st_product.ACTIVE';

	/** the column name for the HIDE_PRICE field */
	const HIDE_PRICE = 'st_product.HIDE_PRICE';

	/** the column name for the HAS_FIXED_CURRENCY field */
	const HAS_FIXED_CURRENCY = 'st_product.HAS_FIXED_CURRENCY';

	/** the column name for the OPT_IMAGE field */
	const OPT_IMAGE = 'st_product.OPT_IMAGE';

	/** the column name for the OPT_NAME field */
	const OPT_NAME = 'st_product.OPT_NAME';

	/** the column name for the OPT_SHORT_DESCRIPTION field */
	const OPT_SHORT_DESCRIPTION = 'st_product.OPT_SHORT_DESCRIPTION';

	/** the column name for the OPT_DESCRIPTION field */
	const OPT_DESCRIPTION = 'st_product.OPT_DESCRIPTION';

	/** the column name for the OPT_URL field */
	const OPT_URL = 'st_product.OPT_URL';

	/** the column name for the OPT_ASSET_FOLDER field */
	const OPT_ASSET_FOLDER = 'st_product.OPT_ASSET_FOLDER';

	/** the column name for the OPT_UOM field */
	const OPT_UOM = 'st_product.OPT_UOM';

	/** the column name for the DELIVERIES field */
	const DELIVERIES = 'st_product.DELIVERIES';

	/** the column name for the MIN_QTY field */
	const MIN_QTY = 'st_product.MIN_QTY';

	/** the column name for the MAX_QTY field */
	const MAX_QTY = 'st_product.MAX_QTY';

	/** the column name for the STEP_QTY field */
	const STEP_QTY = 'st_product.STEP_QTY';

	/** the column name for the IS_STOCK_VALIDATED field */
	const IS_STOCK_VALIDATED = 'st_product.IS_STOCK_VALIDATED';

	/** the column name for the IS_GIFT field */
	const IS_GIFT = 'st_product.IS_GIFT';

	/** the column name for the IS_SERVICE field */
	const IS_SERVICE = 'st_product.IS_SERVICE';

	/** the column name for the STOCK_IN_DECIMALS field */
	const STOCK_IN_DECIMALS = 'st_product.STOCK_IN_DECIMALS';

	/** the column name for the MAN_CODE field */
	const MAN_CODE = 'st_product.MAN_CODE';

	/** the column name for the MAIN_PAGE_ORDER field */
	const MAIN_PAGE_ORDER = 'st_product.MAIN_PAGE_ORDER';

	/** the column name for the PRIORITY field */
	const PRIORITY = 'st_product.PRIORITY';

	/** the column name for the STOCK_MANAGMENT field */
	const STOCK_MANAGMENT = 'st_product.STOCK_MANAGMENT';

	/** the column name for the DIMENSION_ID field */
	const DIMENSION_ID = 'st_product.DIMENSION_ID';

	/** the column name for the WIDTH field */
	const WIDTH = 'st_product.WIDTH';

	/** the column name for the HEIGHT field */
	const HEIGHT = 'st_product.HEIGHT';

	/** the column name for the DEPTH field */
	const DEPTH = 'st_product.DEPTH';

	/** the column name for the OPT_PRODUCT_GROUP field */
	const OPT_PRODUCT_GROUP = 'st_product.OPT_PRODUCT_GROUP';

	/** the column name for the OPT_EXECUTION_TIME field */
	const OPT_EXECUTION_TIME = 'st_product.OPT_EXECUTION_TIME';

	/** the column name for the AVAILABILITY_ID field */
	const AVAILABILITY_ID = 'st_product.AVAILABILITY_ID';

	/** the column name for the WEIGHT field */
	const WEIGHT = 'st_product.WEIGHT';

	/** the column name for the STOCK field */
	const STOCK = 'st_product.STOCK';

	/** the column name for the MAX_DISCOUNT field */
	const MAX_DISCOUNT = 'st_product.MAX_DISCOUNT';

	/** the column name for the MPN_CODE field */
	const MPN_CODE = 'st_product.MPN_CODE';

	/** the column name for the GROUP_PRICE_ID field */
	const GROUP_PRICE_ID = 'st_product.GROUP_PRICE_ID';

	/** the column name for the OPT_HAS_OPTIONS field */
	const OPT_HAS_OPTIONS = 'st_product.OPT_HAS_OPTIONS';

	/** the column name for the OPTIONS_COLOR field */
	const OPTIONS_COLOR = 'st_product.OPTIONS_COLOR';

	/** the column name for the TAX_ID field */
	const TAX_ID = 'st_product.TAX_ID';

	/** the column name for the WHOLESALE_A_NETTO field */
	const WHOLESALE_A_NETTO = 'st_product.WHOLESALE_A_NETTO';

	/** the column name for the WHOLESALE_B_NETTO field */
	const WHOLESALE_B_NETTO = 'st_product.WHOLESALE_B_NETTO';

	/** the column name for the WHOLESALE_C_NETTO field */
	const WHOLESALE_C_NETTO = 'st_product.WHOLESALE_C_NETTO';

	/** the column name for the WHOLESALE_A_BRUTTO field */
	const WHOLESALE_A_BRUTTO = 'st_product.WHOLESALE_A_BRUTTO';

	/** the column name for the WHOLESALE_B_BRUTTO field */
	const WHOLESALE_B_BRUTTO = 'st_product.WHOLESALE_B_BRUTTO';

	/** the column name for the WHOLESALE_C_BRUTTO field */
	const WHOLESALE_C_BRUTTO = 'st_product.WHOLESALE_C_BRUTTO';

	/** the column name for the CURRENCY_WHOLESALE_A field */
	const CURRENCY_WHOLESALE_A = 'st_product.CURRENCY_WHOLESALE_A';

	/** the column name for the CURRENCY_WHOLESALE_B field */
	const CURRENCY_WHOLESALE_B = 'st_product.CURRENCY_WHOLESALE_B';

	/** the column name for the CURRENCY_WHOLESALE_C field */
	const CURRENCY_WHOLESALE_C = 'st_product.CURRENCY_WHOLESALE_C';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'UpdatedAt', 'Id', 'ParentId', 'CurrencyId', 'ProducerId', 'Code', 'Price', 'OptPriceBrutto', 'DeliveryPrice', 'BpumDefaultId', 'BpumDefaultValue', 'BpumId', 'BpumValue', 'CurrencyPrice', 'OldPrice', 'OptOldPriceBrutto', 'PointsValue', 'PointsEarn', 'PointsOnly', 'CurrencyOldPrice', 'OptVat', 'CurrencyExchange', 'Active', 'HidePrice', 'HasFixedCurrency', 'OptImage', 'OptName', 'OptShortDescription', 'OptDescription', 'OptUrl', 'OptAssetFolder', 'OptUom', 'Deliveries', 'MinQty', 'MaxQty', 'StepQty', 'IsStockValidated', 'IsGift', 'IsService', 'StockInDecimals', 'ManCode', 'MainPageOrder', 'Priority', 'StockManagment', 'DimensionId', 'Width', 'Height', 'Depth', 'OptProductGroup', 'OptExecutionTime', 'AvailabilityId', 'Weight', 'Stock', 'MaxDiscount', 'MpnCode', 'GroupPriceId', 'OptHasOptions', 'OptionsColor', 'TaxId', 'WholesaleANetto', 'WholesaleBNetto', 'WholesaleCNetto', 'WholesaleABrutto', 'WholesaleBBrutto', 'WholesaleCBrutto', 'CurrencyWholesaleA', 'CurrencyWholesaleB', 'CurrencyWholesaleC', ),
		BasePeer::TYPE_COLNAME => array (ProductPeer::CREATED_AT, ProductPeer::UPDATED_AT, ProductPeer::ID, ProductPeer::PARENT_ID, ProductPeer::CURRENCY_ID, ProductPeer::PRODUCER_ID, ProductPeer::CODE, ProductPeer::PRICE, ProductPeer::OPT_PRICE_BRUTTO, ProductPeer::DELIVERY_PRICE, ProductPeer::BPUM_DEFAULT_ID, ProductPeer::BPUM_DEFAULT_VALUE, ProductPeer::BPUM_ID, ProductPeer::BPUM_VALUE, ProductPeer::CURRENCY_PRICE, ProductPeer::OLD_PRICE, ProductPeer::OPT_OLD_PRICE_BRUTTO, ProductPeer::POINTS_VALUE, ProductPeer::POINTS_EARN, ProductPeer::POINTS_ONLY, ProductPeer::CURRENCY_OLD_PRICE, ProductPeer::OPT_VAT, ProductPeer::CURRENCY_EXCHANGE, ProductPeer::ACTIVE, ProductPeer::HIDE_PRICE, ProductPeer::HAS_FIXED_CURRENCY, ProductPeer::OPT_IMAGE, ProductPeer::OPT_NAME, ProductPeer::OPT_SHORT_DESCRIPTION, ProductPeer::OPT_DESCRIPTION, ProductPeer::OPT_URL, ProductPeer::OPT_ASSET_FOLDER, ProductPeer::OPT_UOM, ProductPeer::DELIVERIES, ProductPeer::MIN_QTY, ProductPeer::MAX_QTY, ProductPeer::STEP_QTY, ProductPeer::IS_STOCK_VALIDATED, ProductPeer::IS_GIFT, ProductPeer::IS_SERVICE, ProductPeer::STOCK_IN_DECIMALS, ProductPeer::MAN_CODE, ProductPeer::MAIN_PAGE_ORDER, ProductPeer::PRIORITY, ProductPeer::STOCK_MANAGMENT, ProductPeer::DIMENSION_ID, ProductPeer::WIDTH, ProductPeer::HEIGHT, ProductPeer::DEPTH, ProductPeer::OPT_PRODUCT_GROUP, ProductPeer::OPT_EXECUTION_TIME, ProductPeer::AVAILABILITY_ID, ProductPeer::WEIGHT, ProductPeer::STOCK, ProductPeer::MAX_DISCOUNT, ProductPeer::MPN_CODE, ProductPeer::GROUP_PRICE_ID, ProductPeer::OPT_HAS_OPTIONS, ProductPeer::OPTIONS_COLOR, ProductPeer::TAX_ID, ProductPeer::WHOLESALE_A_NETTO, ProductPeer::WHOLESALE_B_NETTO, ProductPeer::WHOLESALE_C_NETTO, ProductPeer::WHOLESALE_A_BRUTTO, ProductPeer::WHOLESALE_B_BRUTTO, ProductPeer::WHOLESALE_C_BRUTTO, ProductPeer::CURRENCY_WHOLESALE_A, ProductPeer::CURRENCY_WHOLESALE_B, ProductPeer::CURRENCY_WHOLESALE_C, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'updated_at', 'id', 'parent_id', 'currency_id', 'producer_id', 'code', 'price', 'opt_price_brutto', 'delivery_price', 'bpum_default_id', 'bpum_default_value', 'bpum_id', 'bpum_value', 'currency_price', 'old_price', 'opt_old_price_brutto', 'points_value', 'points_earn', 'points_only', 'currency_old_price', 'opt_vat', 'currency_exchange', 'active', 'hide_price', 'has_fixed_currency', 'opt_image', 'opt_name', 'opt_short_description', 'opt_description', 'opt_url', 'opt_asset_folder', 'opt_uom', 'deliveries', 'min_qty', 'max_qty', 'step_qty', 'is_stock_validated', 'is_gift', 'is_service', 'stock_in_decimals', 'man_code', 'main_page_order', 'priority', 'stock_managment', 'dimension_id', 'width', 'height', 'depth', 'opt_product_group', 'opt_execution_time', 'availability_id', 'weight', 'stock', 'max_discount', 'mpn_code', 'group_price_id', 'opt_has_options', 'options_color', 'tax_id', 'wholesale_a_netto', 'wholesale_b_netto', 'wholesale_c_netto', 'wholesale_a_brutto', 'wholesale_b_brutto', 'wholesale_c_brutto', 'currency_wholesale_a', 'currency_wholesale_b', 'currency_wholesale_c', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'UpdatedAt' => 1, 'Id' => 2, 'ParentId' => 3, 'CurrencyId' => 4, 'ProducerId' => 5, 'Code' => 6, 'Price' => 7, 'OptPriceBrutto' => 8, 'DeliveryPrice' => 9, 'BpumDefaultId' => 10, 'BpumDefaultValue' => 11, 'BpumId' => 12, 'BpumValue' => 13, 'CurrencyPrice' => 14, 'OldPrice' => 15, 'OptOldPriceBrutto' => 16, 'PointsValue' => 17, 'PointsEarn' => 18, 'PointsOnly' => 19, 'CurrencyOldPrice' => 20, 'OptVat' => 21, 'CurrencyExchange' => 22, 'Active' => 23, 'HidePrice' => 24, 'HasFixedCurrency' => 25, 'OptImage' => 26, 'OptName' => 27, 'OptShortDescription' => 28, 'OptDescription' => 29, 'OptUrl' => 30, 'OptAssetFolder' => 31, 'OptUom' => 32, 'Deliveries' => 33, 'MinQty' => 34, 'MaxQty' => 35, 'StepQty' => 36, 'IsStockValidated' => 37, 'IsGift' => 38, 'IsService' => 39, 'StockInDecimals' => 40, 'ManCode' => 41, 'MainPageOrder' => 42, 'Priority' => 43, 'StockManagment' => 44, 'DimensionId' => 45, 'Width' => 46, 'Height' => 47, 'Depth' => 48, 'OptProductGroup' => 49, 'OptExecutionTime' => 50, 'AvailabilityId' => 51, 'Weight' => 52, 'Stock' => 53, 'MaxDiscount' => 54, 'MpnCode' => 55, 'GroupPriceId' => 56, 'OptHasOptions' => 57, 'OptionsColor' => 58, 'TaxId' => 59, 'WholesaleANetto' => 60, 'WholesaleBNetto' => 61, 'WholesaleCNetto' => 62, 'WholesaleABrutto' => 63, 'WholesaleBBrutto' => 64, 'WholesaleCBrutto' => 65, 'CurrencyWholesaleA' => 66, 'CurrencyWholesaleB' => 67, 'CurrencyWholesaleC' => 68, ),
		BasePeer::TYPE_COLNAME => array (ProductPeer::CREATED_AT => 0, ProductPeer::UPDATED_AT => 1, ProductPeer::ID => 2, ProductPeer::PARENT_ID => 3, ProductPeer::CURRENCY_ID => 4, ProductPeer::PRODUCER_ID => 5, ProductPeer::CODE => 6, ProductPeer::PRICE => 7, ProductPeer::OPT_PRICE_BRUTTO => 8, ProductPeer::DELIVERY_PRICE => 9, ProductPeer::BPUM_DEFAULT_ID => 10, ProductPeer::BPUM_DEFAULT_VALUE => 11, ProductPeer::BPUM_ID => 12, ProductPeer::BPUM_VALUE => 13, ProductPeer::CURRENCY_PRICE => 14, ProductPeer::OLD_PRICE => 15, ProductPeer::OPT_OLD_PRICE_BRUTTO => 16, ProductPeer::POINTS_VALUE => 17, ProductPeer::POINTS_EARN => 18, ProductPeer::POINTS_ONLY => 19, ProductPeer::CURRENCY_OLD_PRICE => 20, ProductPeer::OPT_VAT => 21, ProductPeer::CURRENCY_EXCHANGE => 22, ProductPeer::ACTIVE => 23, ProductPeer::HIDE_PRICE => 24, ProductPeer::HAS_FIXED_CURRENCY => 25, ProductPeer::OPT_IMAGE => 26, ProductPeer::OPT_NAME => 27, ProductPeer::OPT_SHORT_DESCRIPTION => 28, ProductPeer::OPT_DESCRIPTION => 29, ProductPeer::OPT_URL => 30, ProductPeer::OPT_ASSET_FOLDER => 31, ProductPeer::OPT_UOM => 32, ProductPeer::DELIVERIES => 33, ProductPeer::MIN_QTY => 34, ProductPeer::MAX_QTY => 35, ProductPeer::STEP_QTY => 36, ProductPeer::IS_STOCK_VALIDATED => 37, ProductPeer::IS_GIFT => 38, ProductPeer::IS_SERVICE => 39, ProductPeer::STOCK_IN_DECIMALS => 40, ProductPeer::MAN_CODE => 41, ProductPeer::MAIN_PAGE_ORDER => 42, ProductPeer::PRIORITY => 43, ProductPeer::STOCK_MANAGMENT => 44, ProductPeer::DIMENSION_ID => 45, ProductPeer::WIDTH => 46, ProductPeer::HEIGHT => 47, ProductPeer::DEPTH => 48, ProductPeer::OPT_PRODUCT_GROUP => 49, ProductPeer::OPT_EXECUTION_TIME => 50, ProductPeer::AVAILABILITY_ID => 51, ProductPeer::WEIGHT => 52, ProductPeer::STOCK => 53, ProductPeer::MAX_DISCOUNT => 54, ProductPeer::MPN_CODE => 55, ProductPeer::GROUP_PRICE_ID => 56, ProductPeer::OPT_HAS_OPTIONS => 57, ProductPeer::OPTIONS_COLOR => 58, ProductPeer::TAX_ID => 59, ProductPeer::WHOLESALE_A_NETTO => 60, ProductPeer::WHOLESALE_B_NETTO => 61, ProductPeer::WHOLESALE_C_NETTO => 62, ProductPeer::WHOLESALE_A_BRUTTO => 63, ProductPeer::WHOLESALE_B_BRUTTO => 64, ProductPeer::WHOLESALE_C_BRUTTO => 65, ProductPeer::CURRENCY_WHOLESALE_A => 66, ProductPeer::CURRENCY_WHOLESALE_B => 67, ProductPeer::CURRENCY_WHOLESALE_C => 68, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'updated_at' => 1, 'id' => 2, 'parent_id' => 3, 'currency_id' => 4, 'producer_id' => 5, 'code' => 6, 'price' => 7, 'opt_price_brutto' => 8, 'delivery_price' => 9, 'bpum_default_id' => 10, 'bpum_default_value' => 11, 'bpum_id' => 12, 'bpum_value' => 13, 'currency_price' => 14, 'old_price' => 15, 'opt_old_price_brutto' => 16, 'points_value' => 17, 'points_earn' => 18, 'points_only' => 19, 'currency_old_price' => 20, 'opt_vat' => 21, 'currency_exchange' => 22, 'active' => 23, 'hide_price' => 24, 'has_fixed_currency' => 25, 'opt_image' => 26, 'opt_name' => 27, 'opt_short_description' => 28, 'opt_description' => 29, 'opt_url' => 30, 'opt_asset_folder' => 31, 'opt_uom' => 32, 'deliveries' => 33, 'min_qty' => 34, 'max_qty' => 35, 'step_qty' => 36, 'is_stock_validated' => 37, 'is_gift' => 38, 'is_service' => 39, 'stock_in_decimals' => 40, 'man_code' => 41, 'main_page_order' => 42, 'priority' => 43, 'stock_managment' => 44, 'dimension_id' => 45, 'width' => 46, 'height' => 47, 'depth' => 48, 'opt_product_group' => 49, 'opt_execution_time' => 50, 'availability_id' => 51, 'weight' => 52, 'stock' => 53, 'max_discount' => 54, 'mpn_code' => 55, 'group_price_id' => 56, 'opt_has_options' => 57, 'options_color' => 58, 'tax_id' => 59, 'wholesale_a_netto' => 60, 'wholesale_b_netto' => 61, 'wholesale_c_netto' => 62, 'wholesale_a_brutto' => 63, 'wholesale_b_brutto' => 64, 'wholesale_c_brutto' => 65, 'currency_wholesale_a' => 66, 'currency_wholesale_b' => 67, 'currency_wholesale_c' => 68, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, )
	);

         protected static $hydrateMethod = null;

         protected static $postHydrateMethod = null;

         public static function setHydrateMethod($callback)
         {
            self::$hydrateMethod = $callback;
         }

         public static function setPostHydrateMethod($callback)
         {
            self::$postHydrateMethod = $callback;
         }

	/**
	 * @return     MapBuilder the map builder for this peer
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getMapBuilder()
	{
		return BasePeer::getMapBuilder('lib.model.map.ProductMapBuilder');
	}
	/**
	 * Gets a map (hash) of PHP names to DB column names.
	 *
	 * @return     array The PHP to DB name map for this peer
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @deprecated Use the getFieldNames() and translateFieldName() methods instead of this.
	 */
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ProductPeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	/**
	 * Translates a fieldname to another type
	 *
	 * @param      string $name field name
	 * @param      string $fromType One of the class type constants TYPE_PHPNAME,
	 *                         TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @param      string $toType   One of the class type constants
	 * @return     string translated name of the field.
	 */
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	/**
	 * Returns an array of of field names.
	 *
	 * @param      string $type The type of fieldnames to return:
	 *                      One of the class type constants TYPE_PHPNAME,
	 *                      TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     array A list of field names
	 */

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	/**
	 * Convenience method which changes table.column to alias.column.
	 *
	 * Using this method you can maintain SQL abstraction while using column aliases.
	 * <code>
	 *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
	 *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
	 * </code>
	 * @param      string $alias The alias for the current table.
	 * @param      string $column The column name for current table. (i.e. ProductPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(ProductPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	/**
	 * Add all the columns needed to create a new object.
	 *
	 * Note: any columns that were marked with lazyLoad="true" in the
	 * XML schema will not be added to the select list and only loaded
	 * on demand.
	 *
	 * @param      criteria object containing the columns to add.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ProductPeer::CREATED_AT);

		$criteria->addSelectColumn(ProductPeer::UPDATED_AT);

		$criteria->addSelectColumn(ProductPeer::ID);

		$criteria->addSelectColumn(ProductPeer::PARENT_ID);

		$criteria->addSelectColumn(ProductPeer::CURRENCY_ID);

		$criteria->addSelectColumn(ProductPeer::PRODUCER_ID);

		$criteria->addSelectColumn(ProductPeer::CODE);

		$criteria->addSelectColumn(ProductPeer::PRICE);

		$criteria->addSelectColumn(ProductPeer::OPT_PRICE_BRUTTO);

		$criteria->addSelectColumn(ProductPeer::DELIVERY_PRICE);

		$criteria->addSelectColumn(ProductPeer::BPUM_DEFAULT_ID);

		$criteria->addSelectColumn(ProductPeer::BPUM_DEFAULT_VALUE);

		$criteria->addSelectColumn(ProductPeer::BPUM_ID);

		$criteria->addSelectColumn(ProductPeer::BPUM_VALUE);

		$criteria->addSelectColumn(ProductPeer::CURRENCY_PRICE);

		$criteria->addSelectColumn(ProductPeer::OLD_PRICE);

		$criteria->addSelectColumn(ProductPeer::OPT_OLD_PRICE_BRUTTO);

		$criteria->addSelectColumn(ProductPeer::POINTS_VALUE);

		$criteria->addSelectColumn(ProductPeer::POINTS_EARN);

		$criteria->addSelectColumn(ProductPeer::POINTS_ONLY);

		$criteria->addSelectColumn(ProductPeer::CURRENCY_OLD_PRICE);

		$criteria->addSelectColumn(ProductPeer::OPT_VAT);

		$criteria->addSelectColumn(ProductPeer::CURRENCY_EXCHANGE);

		$criteria->addSelectColumn(ProductPeer::ACTIVE);

		$criteria->addSelectColumn(ProductPeer::HIDE_PRICE);

		$criteria->addSelectColumn(ProductPeer::HAS_FIXED_CURRENCY);

		$criteria->addSelectColumn(ProductPeer::OPT_IMAGE);

		$criteria->addSelectColumn(ProductPeer::OPT_NAME);

		$criteria->addSelectColumn(ProductPeer::OPT_SHORT_DESCRIPTION);

		$criteria->addSelectColumn(ProductPeer::OPT_DESCRIPTION);

		$criteria->addSelectColumn(ProductPeer::OPT_URL);

		$criteria->addSelectColumn(ProductPeer::OPT_ASSET_FOLDER);

		$criteria->addSelectColumn(ProductPeer::OPT_UOM);

		$criteria->addSelectColumn(ProductPeer::DELIVERIES);

		$criteria->addSelectColumn(ProductPeer::MIN_QTY);

		$criteria->addSelectColumn(ProductPeer::MAX_QTY);

		$criteria->addSelectColumn(ProductPeer::STEP_QTY);

		$criteria->addSelectColumn(ProductPeer::IS_STOCK_VALIDATED);

		$criteria->addSelectColumn(ProductPeer::IS_GIFT);

		$criteria->addSelectColumn(ProductPeer::IS_SERVICE);

		$criteria->addSelectColumn(ProductPeer::STOCK_IN_DECIMALS);

		$criteria->addSelectColumn(ProductPeer::MAN_CODE);

		$criteria->addSelectColumn(ProductPeer::MAIN_PAGE_ORDER);

		$criteria->addSelectColumn(ProductPeer::PRIORITY);

		$criteria->addSelectColumn(ProductPeer::STOCK_MANAGMENT);

		$criteria->addSelectColumn(ProductPeer::DIMENSION_ID);

		$criteria->addSelectColumn(ProductPeer::WIDTH);

		$criteria->addSelectColumn(ProductPeer::HEIGHT);

		$criteria->addSelectColumn(ProductPeer::DEPTH);

		$criteria->addSelectColumn(ProductPeer::OPT_PRODUCT_GROUP);

		$criteria->addSelectColumn(ProductPeer::OPT_EXECUTION_TIME);

		$criteria->addSelectColumn(ProductPeer::AVAILABILITY_ID);

		$criteria->addSelectColumn(ProductPeer::WEIGHT);

		$criteria->addSelectColumn(ProductPeer::STOCK);

		$criteria->addSelectColumn(ProductPeer::MAX_DISCOUNT);

		$criteria->addSelectColumn(ProductPeer::MPN_CODE);

		$criteria->addSelectColumn(ProductPeer::GROUP_PRICE_ID);

		$criteria->addSelectColumn(ProductPeer::OPT_HAS_OPTIONS);

		$criteria->addSelectColumn(ProductPeer::OPTIONS_COLOR);

		$criteria->addSelectColumn(ProductPeer::TAX_ID);

		$criteria->addSelectColumn(ProductPeer::WHOLESALE_A_NETTO);

		$criteria->addSelectColumn(ProductPeer::WHOLESALE_B_NETTO);

		$criteria->addSelectColumn(ProductPeer::WHOLESALE_C_NETTO);

		$criteria->addSelectColumn(ProductPeer::WHOLESALE_A_BRUTTO);

		$criteria->addSelectColumn(ProductPeer::WHOLESALE_B_BRUTTO);

		$criteria->addSelectColumn(ProductPeer::WHOLESALE_C_BRUTTO);

		$criteria->addSelectColumn(ProductPeer::CURRENCY_WHOLESALE_A);

		$criteria->addSelectColumn(ProductPeer::CURRENCY_WHOLESALE_B);

		$criteria->addSelectColumn(ProductPeer::CURRENCY_WHOLESALE_C);


		if (stEventDispatcher::getInstance()->getListeners('ProductPeer.postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'ProductPeer.postAddSelectColumns'));
		}
	}

	const COUNT = 'COUNT(st_product.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT st_product.ID)';

	/**
	 * Returns the number of rows matching criteria.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}
	/**
	 * Method to select one object from the DB.
	 *
	 * @param      Criteria $criteria object used to create the SELECT statement.
	 * @param      Connection $con
	 * @return     Product
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = ProductPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	/**
	 * Method to do selects.
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      Connection $con
	 * @return     array Array of selected Objects
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ProductPeer::populateObjects(ProductPeer::doSelectRS($criteria, $con));
	}
	/**
	 * Prepares the Criteria object and uses the parent doSelect()
	 * method to get a ResultSet.
	 *
	 * Use this method directly if you want to just get the resultset
	 * (instead of an array of objects).
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      Connection $con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @return     ResultSet The resultset object with numerically-indexed fields.
	 * @see        BasePeer::doSelect()
	 */
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ProductPeer::addSelectColumns($criteria);
		}

		if (stEventDispatcher::getInstance()->getListeners('BasePeer.preDoSelectRs')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($criteria, 'BasePeer.preDoSelectRs'));
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		// BasePeer returns a Creole ResultSet, set to return
		// rows indexed numerically.
		$rs =  BasePeer::doSelect($criteria, $con);

		if (stEventDispatcher::getInstance()->getListeners('BasePeer.postDoSelectRs')) {
			stEventDispatcher::getInstance()->notify(new sfEvent($rs, 'BasePeer.postDoSelectRs'));
		}		

		return $rs;
	}
	/**
	 * The returned array will contain objects of the default type or
	 * objects that inherit from the default.
	 *
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function populateObjects(ResultSet $rs)
	{
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();
	
		// set the class once to avoid overhead in the loop
		$cls = ProductPeer::getOMClass();
		$cls = Propel::import($cls);
		// populate the object(s)
		while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj) : $obj;
			
		}
		return $results;
	}

	/**
	 * Returns the number of rows matching criteria, joining the related Currency table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinCurrency(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Producer table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinProducer(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related BasicPriceUnitMeasureRelatedByBpumDefaultId table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinBasicPriceUnitMeasureRelatedByBpumDefaultId(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related BasicPriceUnitMeasureRelatedByBpumId table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinBasicPriceUnitMeasureRelatedByBpumId(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related ProductDimension table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinProductDimension(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Availability table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAvailability(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related GroupPrice table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinGroupPrice(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Tax table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinTax(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Product objects pre-filled with their Currency objects.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinCurrency(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);

		CurrencyPeer::addSelectColumns($c);

		$c->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);
		$rs = ProductPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Product();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getCurrencyId())
                        {

			   $obj2 = new Currency();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addProduct($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Product objects pre-filled with their Producer objects.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinProducer(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);

		ProducerPeer::addSelectColumns($c);

		$c->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);
		$rs = ProductPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Product();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getProducerId())
                        {

			   $obj2 = new Producer();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addProduct($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Product objects pre-filled with their BasicPriceUnitMeasure objects.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinBasicPriceUnitMeasureRelatedByBpumDefaultId(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);

		BasicPriceUnitMeasurePeer::addSelectColumns($c);

		$c->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);
		$rs = ProductPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Product();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getBpumDefaultId())
                        {

			   $obj2 = new BasicPriceUnitMeasure();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addProductRelatedByBpumDefaultId($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Product objects pre-filled with their BasicPriceUnitMeasure objects.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinBasicPriceUnitMeasureRelatedByBpumId(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);

		BasicPriceUnitMeasurePeer::addSelectColumns($c);

		$c->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);
		$rs = ProductPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Product();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getBpumId())
                        {

			   $obj2 = new BasicPriceUnitMeasure();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addProductRelatedByBpumId($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Product objects pre-filled with their ProductDimension objects.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinProductDimension(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);

		ProductDimensionPeer::addSelectColumns($c);

		$c->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);
		$rs = ProductPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Product();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getDimensionId())
                        {

			   $obj2 = new ProductDimension();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addProduct($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Product objects pre-filled with their Availability objects.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAvailability(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);

		AvailabilityPeer::addSelectColumns($c);

		$c->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);
		$rs = ProductPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Product();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getAvailabilityId())
                        {

			   $obj2 = new Availability();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addProduct($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Product objects pre-filled with their GroupPrice objects.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinGroupPrice(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);

		GroupPricePeer::addSelectColumns($c);

		$c->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);
		$rs = ProductPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Product();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getGroupPriceId())
                        {

			   $obj2 = new GroupPrice();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addProduct($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Selects a collection of Product objects pre-filled with their Tax objects.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinTax(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);

		TaxPeer::addSelectColumns($c);

		$c->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);
		$rs = ProductPeer::doSelectRs($c, $con);
                   
                if (self::$hydrateMethod)
                {
                   return call_user_func(self::$hydrateMethod, $rs);
                }                   

		$results = array();

		while($rs->next()) {

			$obj1 = new Product();
			$startcol = $obj1->hydrate($rs);
                        if ($obj1->getTaxId())
                        {

			   $obj2 = new Tax();
			   $obj2->hydrate($rs, $startcol);
                           $obj2->addProduct($obj1);
                        }
			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining all related tables
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Product objects pre-filled with all related objects.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAll(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);
		$startcol2 = (ProductPeer::NUM_COLUMNS - ProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CurrencyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CurrencyPeer::NUM_COLUMNS;

		ProducerPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProducerPeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol6 = $startcol5 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		ProductDimensionPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + ProductDimensionPeer::NUM_COLUMNS;

		AvailabilityPeer::addSelectColumns($c);
		$startcol8 = $startcol7 + AvailabilityPeer::NUM_COLUMNS;

		GroupPricePeer::addSelectColumns($c);
		$startcol9 = $startcol8 + GroupPricePeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol10 = $startcol9 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined Currency rows
	
			$omClass = CurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCurrency(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProduct($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initProducts();
				$obj2->addProduct($obj1);
			}


				// Add objects for joined Producer rows
	
			$omClass = ProducerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProducer(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProduct($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initProducts();
				$obj3->addProduct($obj1);
			}


				// Add objects for joined BasicPriceUnitMeasure rows
	
			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumDefaultId(); // CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProductRelatedByBpumDefaultId($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj4->initProductsRelatedByBpumDefaultId();
				$obj4->addProductRelatedByBpumDefaultId($obj1);
			}


				// Add objects for joined BasicPriceUnitMeasure rows
	
			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5 = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumId(); // CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addProductRelatedByBpumId($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj5->initProductsRelatedByBpumId();
				$obj5->addProductRelatedByBpumId($obj1);
			}


				// Add objects for joined ProductDimension rows
	
			$omClass = ProductDimensionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6 = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getProductDimension(); // CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addProduct($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj6->initProducts();
				$obj6->addProduct($obj1);
			}


				// Add objects for joined Availability rows
	
			$omClass = AvailabilityPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7 = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getAvailability(); // CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addProduct($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj7->initProducts();
				$obj7->addProduct($obj1);
			}


				// Add objects for joined GroupPrice rows
	
			$omClass = GroupPricePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8 = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getGroupPrice(); // CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addProduct($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj8->initProducts();
				$obj8->addProduct($obj1);
			}


				// Add objects for joined Tax rows
	
			$omClass = TaxPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj9 = new $cls();
			$obj9->hydrate($rs, $startcol9);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj9 = $temp_obj1->getTax(); // CHECKME
				if ($temp_obj9->getPrimaryKey() === $obj9->getPrimaryKey()) {
					$newObject = false;
					$temp_obj9->addProduct($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj9->initProducts();
				$obj9->addProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related ProductRelatedByParentId table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptProductRelatedByParentId(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Currency table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptCurrency(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Producer table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptProducer(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related BasicPriceUnitMeasureRelatedByBpumDefaultId table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptBasicPriceUnitMeasureRelatedByBpumDefaultId(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related BasicPriceUnitMeasureRelatedByBpumId table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptBasicPriceUnitMeasureRelatedByBpumId(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related ProductDimension table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptProductDimension(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Availability table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptAvailability(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related GroupPrice table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptGroupPrice(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Tax table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptTax(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$criteria->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Product objects pre-filled with all related objects except ProductRelatedByParentId.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptProductRelatedByParentId(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);
		$startcol2 = (ProductPeer::NUM_COLUMNS - ProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CurrencyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CurrencyPeer::NUM_COLUMNS;

		ProducerPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProducerPeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol6 = $startcol5 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		ProductDimensionPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + ProductDimensionPeer::NUM_COLUMNS;

		AvailabilityPeer::addSelectColumns($c);
		$startcol8 = $startcol7 + AvailabilityPeer::NUM_COLUMNS;

		GroupPricePeer::addSelectColumns($c);
		$startcol9 = $startcol8 + GroupPricePeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol10 = $startcol9 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = CurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCurrency(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProducts();
				$obj2->addProduct($obj1);
			}

			$omClass = ProducerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProducer(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initProducts();
				$obj3->addProduct($obj1);
			}

			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumDefaultId(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProductRelatedByBpumDefaultId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initProductsRelatedByBpumDefaultId();
				$obj4->addProductRelatedByBpumDefaultId($obj1);
			}

			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumId(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addProductRelatedByBpumId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initProductsRelatedByBpumId();
				$obj5->addProductRelatedByBpumId($obj1);
			}

			$omClass = ProductDimensionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getProductDimension(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initProducts();
				$obj6->addProduct($obj1);
			}

			$omClass = AvailabilityPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getAvailability(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initProducts();
				$obj7->addProduct($obj1);
			}

			$omClass = GroupPricePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getGroupPrice(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initProducts();
				$obj8->addProduct($obj1);
			}

			$omClass = TaxPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj9  = new $cls();
			$obj9->hydrate($rs, $startcol9);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj9 = $temp_obj1->getTax(); //CHECKME
				if ($temp_obj9->getPrimaryKey() === $obj9->getPrimaryKey()) {
					$newObject = false;
					$temp_obj9->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj9->initProducts();
				$obj9->addProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Product objects pre-filled with all related objects except Currency.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptCurrency(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);
		$startcol2 = (ProductPeer::NUM_COLUMNS - ProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ProducerPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ProducerPeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		ProductDimensionPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + ProductDimensionPeer::NUM_COLUMNS;

		AvailabilityPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + AvailabilityPeer::NUM_COLUMNS;

		GroupPricePeer::addSelectColumns($c);
		$startcol8 = $startcol7 + GroupPricePeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol9 = $startcol8 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ProducerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getProducer(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProducts();
				$obj2->addProduct($obj1);
			}

			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumDefaultId(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProductRelatedByBpumDefaultId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initProductsRelatedByBpumDefaultId();
				$obj3->addProductRelatedByBpumDefaultId($obj1);
			}

			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumId(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProductRelatedByBpumId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initProductsRelatedByBpumId();
				$obj4->addProductRelatedByBpumId($obj1);
			}

			$omClass = ProductDimensionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getProductDimension(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initProducts();
				$obj5->addProduct($obj1);
			}

			$omClass = AvailabilityPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getAvailability(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initProducts();
				$obj6->addProduct($obj1);
			}

			$omClass = GroupPricePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getGroupPrice(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initProducts();
				$obj7->addProduct($obj1);
			}

			$omClass = TaxPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getTax(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initProducts();
				$obj8->addProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Product objects pre-filled with all related objects except Producer.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptProducer(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);
		$startcol2 = (ProductPeer::NUM_COLUMNS - ProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CurrencyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CurrencyPeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		ProductDimensionPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + ProductDimensionPeer::NUM_COLUMNS;

		AvailabilityPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + AvailabilityPeer::NUM_COLUMNS;

		GroupPricePeer::addSelectColumns($c);
		$startcol8 = $startcol7 + GroupPricePeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol9 = $startcol8 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = CurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCurrency(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProducts();
				$obj2->addProduct($obj1);
			}

			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumDefaultId(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProductRelatedByBpumDefaultId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initProductsRelatedByBpumDefaultId();
				$obj3->addProductRelatedByBpumDefaultId($obj1);
			}

			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumId(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProductRelatedByBpumId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initProductsRelatedByBpumId();
				$obj4->addProductRelatedByBpumId($obj1);
			}

			$omClass = ProductDimensionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getProductDimension(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initProducts();
				$obj5->addProduct($obj1);
			}

			$omClass = AvailabilityPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getAvailability(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initProducts();
				$obj6->addProduct($obj1);
			}

			$omClass = GroupPricePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getGroupPrice(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initProducts();
				$obj7->addProduct($obj1);
			}

			$omClass = TaxPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getTax(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initProducts();
				$obj8->addProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Product objects pre-filled with all related objects except BasicPriceUnitMeasureRelatedByBpumDefaultId.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptBasicPriceUnitMeasureRelatedByBpumDefaultId(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);
		$startcol2 = (ProductPeer::NUM_COLUMNS - ProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CurrencyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CurrencyPeer::NUM_COLUMNS;

		ProducerPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProducerPeer::NUM_COLUMNS;

		ProductDimensionPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + ProductDimensionPeer::NUM_COLUMNS;

		AvailabilityPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + AvailabilityPeer::NUM_COLUMNS;

		GroupPricePeer::addSelectColumns($c);
		$startcol7 = $startcol6 + GroupPricePeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol8 = $startcol7 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = CurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCurrency(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProducts();
				$obj2->addProduct($obj1);
			}

			$omClass = ProducerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProducer(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initProducts();
				$obj3->addProduct($obj1);
			}

			$omClass = ProductDimensionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getProductDimension(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initProducts();
				$obj4->addProduct($obj1);
			}

			$omClass = AvailabilityPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getAvailability(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initProducts();
				$obj5->addProduct($obj1);
			}

			$omClass = GroupPricePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getGroupPrice(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initProducts();
				$obj6->addProduct($obj1);
			}

			$omClass = TaxPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getTax(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initProducts();
				$obj7->addProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Product objects pre-filled with all related objects except BasicPriceUnitMeasureRelatedByBpumId.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptBasicPriceUnitMeasureRelatedByBpumId(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);
		$startcol2 = (ProductPeer::NUM_COLUMNS - ProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CurrencyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CurrencyPeer::NUM_COLUMNS;

		ProducerPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProducerPeer::NUM_COLUMNS;

		ProductDimensionPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + ProductDimensionPeer::NUM_COLUMNS;

		AvailabilityPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + AvailabilityPeer::NUM_COLUMNS;

		GroupPricePeer::addSelectColumns($c);
		$startcol7 = $startcol6 + GroupPricePeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol8 = $startcol7 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = CurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCurrency(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProducts();
				$obj2->addProduct($obj1);
			}

			$omClass = ProducerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProducer(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initProducts();
				$obj3->addProduct($obj1);
			}

			$omClass = ProductDimensionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getProductDimension(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initProducts();
				$obj4->addProduct($obj1);
			}

			$omClass = AvailabilityPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getAvailability(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initProducts();
				$obj5->addProduct($obj1);
			}

			$omClass = GroupPricePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getGroupPrice(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initProducts();
				$obj6->addProduct($obj1);
			}

			$omClass = TaxPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getTax(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initProducts();
				$obj7->addProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Product objects pre-filled with all related objects except ProductDimension.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptProductDimension(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);
		$startcol2 = (ProductPeer::NUM_COLUMNS - ProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CurrencyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CurrencyPeer::NUM_COLUMNS;

		ProducerPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProducerPeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol6 = $startcol5 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		AvailabilityPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + AvailabilityPeer::NUM_COLUMNS;

		GroupPricePeer::addSelectColumns($c);
		$startcol8 = $startcol7 + GroupPricePeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol9 = $startcol8 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = CurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCurrency(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProducts();
				$obj2->addProduct($obj1);
			}

			$omClass = ProducerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProducer(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initProducts();
				$obj3->addProduct($obj1);
			}

			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumDefaultId(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProductRelatedByBpumDefaultId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initProductsRelatedByBpumDefaultId();
				$obj4->addProductRelatedByBpumDefaultId($obj1);
			}

			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumId(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addProductRelatedByBpumId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initProductsRelatedByBpumId();
				$obj5->addProductRelatedByBpumId($obj1);
			}

			$omClass = AvailabilityPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getAvailability(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initProducts();
				$obj6->addProduct($obj1);
			}

			$omClass = GroupPricePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getGroupPrice(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initProducts();
				$obj7->addProduct($obj1);
			}

			$omClass = TaxPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getTax(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initProducts();
				$obj8->addProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Product objects pre-filled with all related objects except Availability.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptAvailability(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);
		$startcol2 = (ProductPeer::NUM_COLUMNS - ProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CurrencyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CurrencyPeer::NUM_COLUMNS;

		ProducerPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProducerPeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol6 = $startcol5 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		ProductDimensionPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + ProductDimensionPeer::NUM_COLUMNS;

		GroupPricePeer::addSelectColumns($c);
		$startcol8 = $startcol7 + GroupPricePeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol9 = $startcol8 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = CurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCurrency(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProducts();
				$obj2->addProduct($obj1);
			}

			$omClass = ProducerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProducer(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initProducts();
				$obj3->addProduct($obj1);
			}

			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumDefaultId(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProductRelatedByBpumDefaultId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initProductsRelatedByBpumDefaultId();
				$obj4->addProductRelatedByBpumDefaultId($obj1);
			}

			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumId(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addProductRelatedByBpumId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initProductsRelatedByBpumId();
				$obj5->addProductRelatedByBpumId($obj1);
			}

			$omClass = ProductDimensionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getProductDimension(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initProducts();
				$obj6->addProduct($obj1);
			}

			$omClass = GroupPricePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getGroupPrice(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initProducts();
				$obj7->addProduct($obj1);
			}

			$omClass = TaxPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getTax(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initProducts();
				$obj8->addProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Product objects pre-filled with all related objects except GroupPrice.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptGroupPrice(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);
		$startcol2 = (ProductPeer::NUM_COLUMNS - ProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CurrencyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CurrencyPeer::NUM_COLUMNS;

		ProducerPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProducerPeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol6 = $startcol5 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		ProductDimensionPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + ProductDimensionPeer::NUM_COLUMNS;

		AvailabilityPeer::addSelectColumns($c);
		$startcol8 = $startcol7 + AvailabilityPeer::NUM_COLUMNS;

		TaxPeer::addSelectColumns($c);
		$startcol9 = $startcol8 + TaxPeer::NUM_COLUMNS;

		$c->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::TAX_ID, TaxPeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = CurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCurrency(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProducts();
				$obj2->addProduct($obj1);
			}

			$omClass = ProducerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProducer(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initProducts();
				$obj3->addProduct($obj1);
			}

			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumDefaultId(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProductRelatedByBpumDefaultId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initProductsRelatedByBpumDefaultId();
				$obj4->addProductRelatedByBpumDefaultId($obj1);
			}

			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumId(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addProductRelatedByBpumId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initProductsRelatedByBpumId();
				$obj5->addProductRelatedByBpumId($obj1);
			}

			$omClass = ProductDimensionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getProductDimension(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initProducts();
				$obj6->addProduct($obj1);
			}

			$omClass = AvailabilityPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getAvailability(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initProducts();
				$obj7->addProduct($obj1);
			}

			$omClass = TaxPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getTax(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initProducts();
				$obj8->addProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Product objects pre-filled with all related objects except Tax.
	 *
	 * @return     array Array of Product objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptTax(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ProductPeer::addSelectColumns($c);
		$startcol2 = (ProductPeer::NUM_COLUMNS - ProductPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		CurrencyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + CurrencyPeer::NUM_COLUMNS;

		ProducerPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ProducerPeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		BasicPriceUnitMeasurePeer::addSelectColumns($c);
		$startcol6 = $startcol5 + BasicPriceUnitMeasurePeer::NUM_COLUMNS;

		ProductDimensionPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + ProductDimensionPeer::NUM_COLUMNS;

		AvailabilityPeer::addSelectColumns($c);
		$startcol8 = $startcol7 + AvailabilityPeer::NUM_COLUMNS;

		GroupPricePeer::addSelectColumns($c);
		$startcol9 = $startcol8 + GroupPricePeer::NUM_COLUMNS;

		$c->addJoin(ProductPeer::CURRENCY_ID, CurrencyPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::PRODUCER_ID, ProducerPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_DEFAULT_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::BPUM_ID, BasicPriceUnitMeasurePeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::DIMENSION_ID, ProductDimensionPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::AVAILABILITY_ID, AvailabilityPeer::ID, Criteria::LEFT_JOIN);

		$c->addJoin(ProductPeer::GROUP_PRICE_ID, GroupPricePeer::ID, Criteria::LEFT_JOIN);


		$rs = BasePeer::doSelect($c, $con);
		
            if (self::$hydrateMethod)
            {
               return call_user_func(self::$hydrateMethod, $rs);
            }
            $results = array();

		while($rs->next()) {

			$omClass = ProductPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = CurrencyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getCurrency(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initProducts();
				$obj2->addProduct($obj1);
			}

			$omClass = ProducerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getProducer(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initProducts();
				$obj3->addProduct($obj1);
			}

			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumDefaultId(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addProductRelatedByBpumDefaultId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initProductsRelatedByBpumDefaultId();
				$obj4->addProductRelatedByBpumDefaultId($obj1);
			}

			$omClass = BasicPriceUnitMeasurePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getBasicPriceUnitMeasureRelatedByBpumId(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addProductRelatedByBpumId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initProductsRelatedByBpumId();
				$obj5->addProductRelatedByBpumId($obj1);
			}

			$omClass = ProductDimensionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getProductDimension(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initProducts();
				$obj6->addProduct($obj1);
			}

			$omClass = AvailabilityPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7  = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getAvailability(); //CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj7->initProducts();
				$obj7->addProduct($obj1);
			}

			$omClass = GroupPricePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj8  = new $cls();
			$obj8->hydrate($rs, $startcol8);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj8 = $temp_obj1->getGroupPrice(); //CHECKME
				if ($temp_obj8->getPrimaryKey() === $obj8->getPrimaryKey()) {
					$newObject = false;
					$temp_obj8->addProduct($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj8->initProducts();
				$obj8->addProduct($obj1);
			}

			$results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
		}
		return $results;
	}


     /**
      * Selects a collection of Product objects pre-filled with their i18n objects.
      *
      * @return array Array of Product objects.
      * @throws PropelException Any exceptions caught during processing will be
      *     rethrown wrapped into a PropelException.
      */
     public static function doSelectWithI18n(Criteria $c, $culture = null, $con = null)
     {
       $c = clone $c;

       if ($culture === null)
       {
         $culture = sfContext::getInstance()->getUser()->getCulture();
       }

       // Set the correct dbName if it has not been overridden
       if ($c->getDbName() == Propel::getDefaultDB())
       {
         $c->setDbName(self::DATABASE_NAME);
       }
      
       if (!$c->getSelectColumns())
       {
          ProductPeer::addSelectColumns($c);
          ProductI18nPeer::addSelectColumns($c);
       }

      $c->addJoin(ProductPeer::ID, sprintf('%s AND %s = \'%s\'', ProductI18nPeer::ID, ProductI18nPeer::CULTURE, $culture), Criteria::LEFT_JOIN);

      $rs = ProductPeer::doSelectRs($c, $con);

      if (self::$hydrateMethod)
      {
         return call_user_func(self::$hydrateMethod, $rs);
      }

      $results = array();

      while($rs->next()) {

         $obj1 = new Product();
         $startcol = $obj1->hydrate($rs);
         $obj1->setCulture($culture);

         $obj2 = new ProductI18n();
         $obj2->hydrate($rs, $startcol);

         $obj1->setProductI18nForCulture($obj2, $culture);
         $obj2->setProduct($obj1);

         $results[] = self::$postHydrateMethod ? call_user_func(self::$postHydrateMethod, $obj1) : $obj1;
       }
       return $results;
     }

	/**
	 * Returns the TableMap related to this peer.
	 * This method is not needed for general use but a specific application could have a need.
	 * @return     TableMap
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	/**
	 * The class that the Peer will make instances of.
	 *
	 * This uses a dot-path notation which is tranalted into a path
	 * relative to a location on the PHP include_path.
	 * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
	 *
	 * @return     string path.to.ClassName
	 */
	public static function getOMClass()
	{
		return ProductPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a Product or Criteria object.
	 *
	 * @param      mixed $values Criteria or Product object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseProductPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseProductPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from Product object
		}

		$criteria->remove(ProductPeer::ID); // remove pkey col since this table uses auto-increment


		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		try {
			// use transaction because $criteria could contain info
			// for more than one table (I guess, conceivably)
			$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseProductPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseProductPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a Product or Criteria object.
	 *
	 * @param      mixed $values Criteria or Product object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseProductPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseProductPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(ProductPeer::ID);
			$selectCriteria->add(ProductPeer::ID, $criteria->remove(ProductPeer::ID), $comparison);

		} else { // $values is Product object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseProductPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseProductPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the st_product table.
	 *
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += ProductPeer::doOnDeleteCascade(new Criteria(), $con);
			ProductPeer::doOnDeleteSetNull(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(ProductPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a Product or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or Product object or primary key or array of primary keys
	 *              which is used to create the DELETE statement
	 * @param      Connection $con the connection to use
	 * @return     int 	The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
	 *				if supported by native driver or if emulated using Propel.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(ProductPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof Product) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ProductPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += ProductPeer::doOnDeleteCascade($criteria, $con);ProductPeer::doOnDeleteSetNull($criteria, $con);
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * This is a method for emulating ON DELETE CASCADE for DBs that don't support this
	 * feature (like MySQL or SQLite).
	 *
	 * This method is not very speedy because it must perform a query first to get
	 * the implicated records and then perform the deletes by calling those Peer classes.
	 *
	 * This method should be used within a transaction if possible.
	 *
	 * @param      Criteria $criteria
	 * @param      Connection $con
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	protected static function doOnDeleteCascade(Criteria $criteria, Connection $con)
	{
		// initialize var to track total num of affected rows
		$affectedRows = 0;

		// first find the objects that are implicated by the $criteria
		$objects = ProductPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			// delete related Handelo objects
			$c = new Criteria();
			
			$c->add(HandeloPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += HandeloPeer::doDelete($c, $con);

			// delete related GoogleShopping objects
			$c = new Criteria();
			
			$c->add(GoogleShoppingPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += GoogleShoppingPeer::doDelete($c, $con);

			// delete related AllegroAuction objects
			$c = new Criteria();
			
			$c->add(AllegroAuctionPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += AllegroAuctionPeer::doDelete($c, $con);

			// delete related Crosselling objects
			$c = new Criteria();
			
			$c->add(CrossellingPeer::FIRST_PRODUCT_ID, $obj->getId());
			$affectedRows += CrossellingPeer::doDelete($c, $con);

			// delete related Crosselling objects
			$c = new Criteria();
			
			$c->add(CrossellingPeer::SECOUND_PRODUCT_ID, $obj->getId());
			$affectedRows += CrossellingPeer::doDelete($c, $con);

			// delete related Discount objects
			$c = new Criteria();
			
			$c->add(DiscountPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += DiscountPeer::doDelete($c, $con);

			// delete related DiscountHasProduct objects
			$c = new Criteria();
			
			$c->add(DiscountHasProductPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += DiscountHasProductPeer::doDelete($c, $con);

			// delete related DiscountCouponCodeHasProduct objects
			$c = new Criteria();
			
			$c->add(DiscountCouponCodeHasProductPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += DiscountCouponCodeHasProductPeer::doDelete($c, $con);

			// delete related ProductHasCategory objects
			$c = new Criteria();
			
			$c->add(ProductHasCategoryPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += ProductHasCategoryPeer::doDelete($c, $con);

			// delete related ProductHasSfAsset objects
			$c = new Criteria();
			
			$c->add(ProductHasSfAssetPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += ProductHasSfAssetPeer::doDelete($c, $con);

			// delete related ProductHasAttachment objects
			$c = new Criteria();
			
			$c->add(ProductHasAttachmentPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += ProductHasAttachmentPeer::doDelete($c, $con);

			// delete related ProductI18n objects
			$c = new Criteria();
			
			$c->add(ProductI18nPeer::ID, $obj->getId());
			$affectedRows += ProductI18nPeer::doDelete($c, $con);

			// delete related AddPrice objects
			$c = new Criteria();
			
			$c->add(AddPricePeer::ID, $obj->getId());
			$affectedRows += AddPricePeer::doDelete($c, $con);

			// delete related Bazzar objects
			$c = new Criteria();
			
			$c->add(BazzarPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += BazzarPeer::doDelete($c, $con);

			// delete related Trust objects
			$c = new Criteria();
			
			$c->add(TrustPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += TrustPeer::doDelete($c, $con);

			// delete related Radar objects
			$c = new Criteria();
			
			$c->add(RadarPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += RadarPeer::doDelete($c, $con);

			// delete related Ceneo objects
			$c = new Criteria();
			
			$c->add(CeneoPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += CeneoPeer::doDelete($c, $con);

			// delete related GiftCardHasProduct objects
			$c = new Criteria();
			
			$c->add(GiftCardHasProductPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += GiftCardHasProductPeer::doDelete($c, $con);

			// delete related Review objects
			$c = new Criteria();
			
			$c->add(ReviewPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += ReviewPeer::doDelete($c, $con);

			// delete related appProductAttributeVariantHasProduct objects
			$c = new Criteria();
			
			$c->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += appProductAttributeVariantHasProductPeer::doDelete($c, $con);

			// delete related Onet objects
			$c = new Criteria();
			
			$c->add(OnetPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += OnetPeer::doDelete($c, $con);

			// delete related Zakupomat objects
			$c = new Criteria();
			
			$c->add(ZakupomatPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += ZakupomatPeer::doDelete($c, $con);

			// delete related Okazje objects
			$c = new Criteria();
			
			$c->add(OkazjePeer::PRODUCT_ID, $obj->getId());
			$affectedRows += OkazjePeer::doDelete($c, $con);

			// delete related ProductOptionsValue objects
			$c = new Criteria();
			
			$c->add(ProductOptionsValuePeer::PRODUCT_ID, $obj->getId());
			$affectedRows += ProductOptionsValuePeer::doDelete($c, $con);

			// delete related BasketProduct objects
			$c = new Criteria();
			
			$c->add(BasketProductPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += BasketProductPeer::doDelete($c, $con);

			// delete related Oferciak objects
			$c = new Criteria();
			
			$c->add(OferciakPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += OferciakPeer::doDelete($c, $con);

			// delete related ProductHasAccessories objects
			$c = new Criteria();
			
			$c->add(ProductHasAccessoriesPeer::ACCESSORIES_ID, $obj->getId());
			$affectedRows += ProductHasAccessoriesPeer::doDelete($c, $con);

			// delete related ProductHasAccessories objects
			$c = new Criteria();
			
			$c->add(ProductHasAccessoriesPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += ProductHasAccessoriesPeer::doDelete($c, $con);

			// delete related Wp objects
			$c = new Criteria();
			
			$c->add(WpPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += WpPeer::doDelete($c, $con);

			// delete related Nokaut objects
			$c = new Criteria();
			
			$c->add(NokautPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += NokautPeer::doDelete($c, $con);

			// delete related ProductHasPositioning objects
			$c = new Criteria();
			
			$c->add(ProductHasPositioningPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += ProductHasPositioningPeer::doDelete($c, $con);

			// delete related Sklepy24 objects
			$c = new Criteria();
			
			$c->add(Sklepy24Peer::PRODUCT_ID, $obj->getId());
			$affectedRows += Sklepy24Peer::doDelete($c, $con);

			// delete related ProductGroupHasProduct objects
			$c = new Criteria();
			
			$c->add(ProductGroupHasProductPeer::PRODUCT_ID, $obj->getId());
			$affectedRows += ProductGroupHasProductPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	/**
	 * This is a method for emulating ON DELETE SET NULL DBs that don't support this
	 * feature (like MySQL or SQLite).
	 *
	 * This method is not very speedy because it must perform a query first to get
	 * the implicated records and then perform the deletes by calling those Peer classes.
	 *
	 * This method should be used within a transaction if possible.
	 *
	 * @param      Criteria $criteria
	 * @param      Connection $con
	 * @return     void
	 */
	protected static function doOnDeleteSetNull(Criteria $criteria, Connection $con)
	{

		// first find the objects that are implicated by the $criteria
		$objects = ProductPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {

			// set fkey col in related OrderProduct rows to NULL
			$selectCriteria = new Criteria(ProductPeer::DATABASE_NAME);
			$updateValues = new Criteria(ProductPeer::DATABASE_NAME);
			$selectCriteria->add(OrderProductPeer::PRODUCT_ID, $obj->getId());
			$updateValues->add(OrderProductPeer::PRODUCT_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related InvoiceProduct rows to NULL
			$selectCriteria = new Criteria(ProductPeer::DATABASE_NAME);
			$updateValues = new Criteria(ProductPeer::DATABASE_NAME);
			$selectCriteria->add(InvoiceProductPeer::PRODUCT_ID, $obj->getId());
			$updateValues->add(InvoiceProductPeer::PRODUCT_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Questions rows to NULL
			$selectCriteria = new Criteria(ProductPeer::DATABASE_NAME);
			$updateValues = new Criteria(ProductPeer::DATABASE_NAME);
			$selectCriteria->add(QuestionsPeer::ITEM_ID, $obj->getId());
			$updateValues->add(QuestionsPeer::ITEM_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

		}
	}

	/**
	 * Validates all modified columns of given Product object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      Product $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(Product $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ProductPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ProductPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(ProductPeer::DATABASE_NAME, ProductPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ProductPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      mixed $pk the primary key.
	 * @param      Connection $con the connection to use
	 * @return     Product
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(ProductPeer::DATABASE_NAME);

		$criteria->add(ProductPeer::ID, $pk);


		$v = ProductPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	/**
	 * Retrieve multiple objects by pkey.
	 *
	 * @param      array $pks List of primary keys
	 * @param      Connection $con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(ProductPeer::ID, $pks, Criteria::IN);
			$objs = ProductPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseProductPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseProductPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	Propel::registerMapBuilder('lib.model.map.ProductMapBuilder');
}
