<?php


/**
 * This class adds structure of 'st_product_has_wholesale' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stWholesalePlugin.lib.model.map
 */
class ProductHasWholesaleMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stWholesalePlugin.lib.model.map.ProductHasWholesaleMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_product_has_wholesale');
        $tMap->setPhpName('ProductHasWholesale');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('PRODUCT_ID', 'ProductId', 'int', CreoleTypes::INTEGER, 'st_product', 'ID', true, null);

        $tMap->addColumn('PRICE_A', 'PriceA', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('PRICE_B', 'PriceB', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('PRICE_C', 'PriceC', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('OPT_PRICE_BRUTTO_A', 'OptPriceBruttoA', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('OPT_PRICE_BRUTTO_B', 'OptPriceBruttoB', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('OPT_PRICE_BRUTTO_C', 'OptPriceBruttoC', 'double', CreoleTypes::DECIMAL, false, 10);

    } // doBuild()

} // ProductHasWholesaleMapBuilder
