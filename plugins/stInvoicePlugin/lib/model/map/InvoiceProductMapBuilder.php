<?php


/**
 * This class adds structure of 'st_invoice_product' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stInvoicePlugin.lib.model.map
 */
class InvoiceProductMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stInvoicePlugin.lib.model.map.InvoiceProductMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_invoice_product');
        $tMap->setPhpName('InvoiceProduct');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('INVOICE_ID', 'InvoiceId', 'int', CreoleTypes::INTEGER, 'st_invoice', 'ID', true, null);

        $tMap->addForeignKey('PRODUCT_ID', 'ProductId', 'int', CreoleTypes::INTEGER, 'st_product', 'ID', false, null);

        $tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 1024);

        $tMap->addColumn('CODE', 'Code', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('PKWIU', 'Pkwiu', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('QUANTITY', 'Quantity', 'double', CreoleTypes::DECIMAL, false, 8);

        $tMap->addColumn('MEASURE_UNIT', 'MeasureUnit', 'string', CreoleTypes::VARCHAR, false, 20);

        $tMap->addColumn('DISCOUNT', 'Discount', 'double', CreoleTypes::FLOAT, false, null);

        $tMap->addColumn('PRICE_NETTO', 'PriceNetto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('PRICE_BRUTTO', 'PriceBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('VAT', 'Vat', 'double', CreoleTypes::FLOAT, false, null);

        $tMap->addColumn('VAT_ID', 'VatId', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('TOTAL_PRICE_NETTO', 'TotalPriceNetto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('VAT_AMMOUNT', 'VatAmmount', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('OPT_TOTAL_PRICE_BRUTTO', 'OptTotalPriceBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

    } // doBuild()

} // InvoiceProductMapBuilder
