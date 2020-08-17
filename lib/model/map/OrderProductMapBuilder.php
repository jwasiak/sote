<?php


/**
 * This class adds structure of 'st_order_product' table to 'propel' DatabaseMap object.
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
class OrderProductMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.OrderProductMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_order_product');
        $tMap->setPhpName('OrderProduct');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('ORDER_ID', 'OrderId', 'int', CreoleTypes::INTEGER, 'st_order', 'ID', true, null);

        $tMap->addForeignKey('PRODUCT_ID', 'ProductId', 'int', CreoleTypes::INTEGER, 'st_product', 'ID', false, null);

        $tMap->addForeignKey('TAX_ID', 'TaxId', 'int', CreoleTypes::INTEGER, 'st_tax', 'ID', false, null);

        $tMap->addColumn('QUANTITY', 'Quantity', 'double', CreoleTypes::DECIMAL, true, 8);

        $tMap->addColumn('CODE', 'Code', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 1024);

        $tMap->addColumn('IMAGE', 'Image', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('PRICE', 'Price', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('PRICE_BRUTTO', 'PriceBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('CUSTOM_PRICE', 'CustomPrice', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('CUSTOM_PRICE_BRUTTO', 'CustomPriceBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('VAT', 'Vat', 'double', CreoleTypes::DECIMAL, false, 5);

        $tMap->addColumn('POINTS_VALUE', 'PointsValue', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('POINTS_EARN', 'PointsEarn', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('PRODUCT_FOR_POINTS', 'ProductForPoints', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('VERSION', 'Version', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('IS_SET', 'IsSet', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('IS_GIFT', 'IsGift', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('SEND_REVIEW', 'SendReview', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('PRICE_MODIFIERS', 'PriceModifiers', 'array', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('DISCOUNT', 'Discount', 'array', CreoleTypes::VARCHAR, false, 1024);

        $tMap->addColumn('CURRENCY', 'Currency', 'array', CreoleTypes::VARCHAR, false, 1024);

        $tMap->addColumn('WHOLESALE', 'Wholesale', 'array', CreoleTypes::VARCHAR, false, 1024);

        $tMap->addColumn('ONLINE_CODE', 'OnlineCode', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('ALLEGRO_AUCTION_ID', 'AllegroAuctionId', 'string', CreoleTypes::BIGINT, false, null);

        $tMap->addColumn('OPTIONS', 'Options', 'string', CreoleTypes::VARCHAR, false, 255);

    } // doBuild()

} // OrderProductMapBuilder
