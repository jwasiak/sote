<?php


/**
 * This class adds structure of 'st_product' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ProductMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.ProductMapBuilder';

    /**
     * The database map.
     */
    private $dbMap;

    /**
     * Tells us if this DatabaseMapBuilder is built so that we
     * don't have to re-build it every time.
     *
     * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
     */
    public function isBuilt()
    {
        return ($this->dbMap !== null);
    }

    /**
     * Gets the databasemap this map builder built.
     *
     * @return     the databasemap
     */
    public function getDatabaseMap()
    {
        return $this->dbMap;
    }

    /**
     * The doBuild() method builds the DatabaseMap
     *
     * @return     void
     * @throws     PropelException
     */
    public function doBuild()
    {
        $this->dbMap = Propel::getDatabaseMap('propel');

        $tMap = $this->dbMap->addTable('st_product');
        $tMap->setPhpName('Product');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('PARENT_ID', 'ParentId', 'int', CreoleTypes::INTEGER, 'st_product', 'ID', false, null);

        $tMap->addForeignKey('CURRENCY_ID', 'CurrencyId', 'int', CreoleTypes::INTEGER, 'st_currency', 'ID', false, null);

        $tMap->addForeignKey('PRODUCER_ID', 'ProducerId', 'int', CreoleTypes::INTEGER, 'st_producer', 'ID', false, null);

        $tMap->addColumn('CODE', 'Code', 'string', CreoleTypes::VARCHAR, true, 255);

        $tMap->addColumn('PRICE', 'Price', 'double', CreoleTypes::DECIMAL, true, 10);

        $tMap->addColumn('OPT_PRICE_BRUTTO', 'OptPriceBrutto', 'double', CreoleTypes::DECIMAL, true, 10);

        $tMap->addColumn('DELIVERY_PRICE', 'DeliveryPrice', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addForeignKey('BPUM_DEFAULT_ID', 'BpumDefaultId', 'int', CreoleTypes::INTEGER, 'st_basic_price_unit_measure', 'ID', false, null);

        $tMap->addColumn('BPUM_DEFAULT_VALUE', 'BpumDefaultValue', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addForeignKey('BPUM_ID', 'BpumId', 'int', CreoleTypes::INTEGER, 'st_basic_price_unit_measure', 'ID', false, null);

        $tMap->addColumn('BPUM_VALUE', 'BpumValue', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('CURRENCY_PRICE', 'CurrencyPrice', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('OLD_PRICE', 'OldPrice', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('OPT_OLD_PRICE_BRUTTO', 'OptOldPriceBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('POINTS_VALUE', 'PointsValue', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('POINTS_EARN', 'PointsEarn', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('POINTS_ONLY', 'PointsOnly', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('CURRENCY_OLD_PRICE', 'CurrencyOldPrice', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('OPT_VAT', 'OptVat', 'double', CreoleTypes::DECIMAL, false, 5);

        $tMap->addColumn('CURRENCY_EXCHANGE', 'CurrencyExchange', 'double', CreoleTypes::DECIMAL, false, 6);

        $tMap->addColumn('ACTIVE', 'Active', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('HIDE_PRICE', 'HidePrice', 'int', CreoleTypes::TINYINT, false, null);

        $tMap->addColumn('HAS_FIXED_CURRENCY', 'HasFixedCurrency', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('OPT_IMAGE', 'OptImage', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_NAME', 'OptName', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_SHORT_DESCRIPTION', 'OptShortDescription', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('OPT_DESCRIPTION', 'OptDescription', 'string', CreoleTypes::MEDIUMTEXT, false, null);

        $tMap->addColumn('OPT_URL', 'OptUrl', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_ASSET_FOLDER', 'OptAssetFolder', 'string', CreoleTypes::VARCHAR, false, 32);

        $tMap->addColumn('OPT_UOM', 'OptUom', 'string', CreoleTypes::VARCHAR, false, 10);

        $tMap->addColumn('DELIVERIES', 'Deliveries', 'array', CreoleTypes::VARCHAR, false, 1024);

        $tMap->addColumn('MIN_QTY', 'MinQty', 'double', CreoleTypes::DECIMAL, false, 8);

        $tMap->addColumn('MAX_QTY', 'MaxQty', 'double', CreoleTypes::DECIMAL, false, 8);

        $tMap->addColumn('STEP_QTY', 'StepQty', 'double', CreoleTypes::DECIMAL, false, 8);

        $tMap->addColumn('IS_STOCK_VALIDATED', 'IsStockValidated', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('IS_GIFT', 'IsGift', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('IS_SERVICE', 'IsService', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('STOCK_IN_DECIMALS', 'StockInDecimals', 'int', CreoleTypes::TINYINT, false, null);

        $tMap->addColumn('MAN_CODE', 'ManCode', 'string', CreoleTypes::VARCHAR, false, 20);

        $tMap->addColumn('MAIN_PAGE_ORDER', 'MainPageOrder', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('PRIORITY', 'Priority', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('STOCK_MANAGMENT', 'StockManagment', 'int', CreoleTypes::TINYINT, false, null);

        $tMap->addForeignKey('DIMENSION_ID', 'DimensionId', 'int', CreoleTypes::INTEGER, 'st_product_dimension', 'ID', false, null);

        $tMap->addColumn('WIDTH', 'Width', 'double', CreoleTypes::FLOAT, true, null);

        $tMap->addColumn('HEIGHT', 'Height', 'double', CreoleTypes::FLOAT, true, null);

        $tMap->addColumn('DEPTH', 'Depth', 'double', CreoleTypes::FLOAT, true, null);

        $tMap->addColumn('OPT_PRODUCT_GROUP', 'OptProductGroup', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('OPT_EXECUTION_TIME', 'OptExecutionTime', 'string', CreoleTypes::VARCHAR, false, 64);

        $tMap->addForeignKey('AVAILABILITY_ID', 'AvailabilityId', 'int', CreoleTypes::INTEGER, 'st_availability', 'ID', false, null);

        $tMap->addColumn('WEIGHT', 'Weight', 'double', CreoleTypes::FLOAT, false, null);

        $tMap->addColumn('STOCK', 'Stock', 'double', CreoleTypes::DECIMAL, false, 8);

        $tMap->addColumn('MAX_DISCOUNT', 'MaxDiscount', 'double', CreoleTypes::DOUBLE, false, null);

        $tMap->addColumn('MPN_CODE', 'MpnCode', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addForeignKey('GROUP_PRICE_ID', 'GroupPriceId', 'int', CreoleTypes::INTEGER, 'st_group_price', 'ID', false, null);

        $tMap->addColumn('OPT_HAS_OPTIONS', 'OptHasOptions', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('OPTIONS_COLOR', 'OptionsColor', 'array', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addForeignKey('TAX_ID', 'TaxId', 'int', CreoleTypes::INTEGER, 'st_tax', 'ID', false, null);

        $tMap->addColumn('WHOLESALE_A_NETTO', 'WholesaleANetto', 'double', CreoleTypes::DECIMAL, true, 10);

        $tMap->addColumn('WHOLESALE_B_NETTO', 'WholesaleBNetto', 'double', CreoleTypes::DECIMAL, true, 10);

        $tMap->addColumn('WHOLESALE_C_NETTO', 'WholesaleCNetto', 'double', CreoleTypes::DECIMAL, true, 10);

        $tMap->addColumn('WHOLESALE_A_BRUTTO', 'WholesaleABrutto', 'double', CreoleTypes::DECIMAL, true, 10);

        $tMap->addColumn('WHOLESALE_B_BRUTTO', 'WholesaleBBrutto', 'double', CreoleTypes::DECIMAL, true, 10);

        $tMap->addColumn('WHOLESALE_C_BRUTTO', 'WholesaleCBrutto', 'double', CreoleTypes::DECIMAL, true, 10);

        $tMap->addColumn('CURRENCY_WHOLESALE_A', 'CurrencyWholesaleA', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('CURRENCY_WHOLESALE_B', 'CurrencyWholesaleB', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('CURRENCY_WHOLESALE_C', 'CurrencyWholesaleC', 'double', CreoleTypes::DECIMAL, false, 10);

    } // doBuild()

} // ProductMapBuilder
