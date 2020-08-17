<?php


/**
 * This class adds structure of 'st_group_price' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stGroupPricePlugin.lib.model.map
 */
class GroupPriceMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stGroupPricePlugin.lib.model.map.GroupPriceMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_group_price');
        $tMap->setPhpName('GroupPrice');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addForeignKey('TAX_ID', 'TaxId', 'int', CreoleTypes::INTEGER, 'st_tax', 'ID', false, null);

        $tMap->addColumn('OPT_VAT', 'OptVat', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addForeignKey('CURRENCY_ID', 'CurrencyId', 'int', CreoleTypes::INTEGER, 'st_currency', 'ID', false, null);

        $tMap->addColumn('PRICE_NETTO', 'PriceNetto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('PRICE_BRUTTO', 'PriceBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('OLD_PRICE_NETTO', 'OldPriceNetto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('OLD_PRICE_BRUTTO', 'OldPriceBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('WHOLESALE_A_NETTO', 'WholesaleANetto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('WHOLESALE_A_BRUTTO', 'WholesaleABrutto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('WHOLESALE_B_NETTO', 'WholesaleBNetto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('WHOLESALE_B_BRUTTO', 'WholesaleBBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('WHOLESALE_C_NETTO', 'WholesaleCNetto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('WHOLESALE_C_BRUTTO', 'WholesaleCBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

    } // doBuild()

} // GroupPriceMapBuilder