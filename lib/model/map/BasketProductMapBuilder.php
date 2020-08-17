<?php


/**
 * This class adds structure of 'st_basket_product' table to 'propel' DatabaseMap object.
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
class BasketProductMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.BasketProductMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_basket_product');
        $tMap->setPhpName('BasketProduct');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('PRODUCT_ID', 'ProductId', 'int', CreoleTypes::INTEGER, 'st_product', 'ID', true, null);

        $tMap->addColumn('PRODUCT_SET_DISCOUNT_ID', 'ProductSetDiscountId', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addForeignKey('BASKET_ID', 'BasketId', 'int', CreoleTypes::INTEGER, 'st_basket', 'ID', true, null);

        $tMap->addColumn('IS_GIFT', 'IsGift', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('QUANTITY', 'Quantity', 'double', CreoleTypes::DECIMAL, false, 8);

        $tMap->addColumn('MAX_QUANTITY', 'MaxQuantity', 'double', CreoleTypes::DECIMAL, false, 8);

        $tMap->addColumn('CODE', 'Code', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('IMAGE', 'Image', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('ITEM_ID', 'ItemId', 'string', CreoleTypes::VARCHAR, false, 32);

        $tMap->addColumn('PRICE', 'Price', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('PRICE_BRUTTO', 'PriceBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('VAT', 'Vat', 'double', CreoleTypes::FLOAT, false, null);

        $tMap->addColumn('WEIGHT', 'Weight', 'double', CreoleTypes::FLOAT, false, null);

        $tMap->addColumn('PRODUCT_FOR_POINTS', 'ProductForPoints', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('PRICE_MODIFIERS', 'PriceModifiers', 'array', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('DISCOUNT', 'Discount', 'array', CreoleTypes::VARCHAR, false, 1024);

        $tMap->addColumn('CURRENCY', 'Currency', 'array', CreoleTypes::VARCHAR, false, 1024);

        $tMap->addColumn('WHOLESALE', 'Wholesale', 'array', CreoleTypes::VARCHAR, false, 1024);

        $tMap->addColumn('OPTIONS', 'Options', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('NEW_OPTIONS', 'NewOptions', 'array', CreoleTypes::LONGVARCHAR, false, null);

    } // doBuild()

} // BasketProductMapBuilder
