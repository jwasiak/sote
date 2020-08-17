<?php


/**
 * This class adds structure of 'st_discount' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stDiscountPlugin.lib.model.map
 */
class DiscountMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stDiscountPlugin.lib.model.map.DiscountMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_discount');
        $tMap->setPhpName('Discount');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('TYPE', 'Type', 'string', CreoleTypes::VARCHAR, true, 1);

        $tMap->addColumn('PRICE_TYPE', 'PriceType', 'string', CreoleTypes::VARCHAR, true, 1);

        $tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, true, 64);

        $tMap->addColumn('VALUE', 'Value', 'double', CreoleTypes::DECIMAL, true, 8);

        $tMap->addColumn('CONDITIONS', 'Conditions', 'array', CreoleTypes::VARCHAR, false, 4096);

        $tMap->addColumn('PRIORITY', 'Priority', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('ACTIVE', 'Active', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('ALL_PRODUCTS', 'AllProducts', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('ALL_CLIENTS', 'AllClients', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('ALLOW_ANONYMOUS_CLIENTS', 'AllowAnonymousClients', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('AUTO_ACTIVE', 'AutoActive', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addForeignKey('PRODUCT_ID', 'ProductId', 'int', CreoleTypes::INTEGER, 'st_product', 'ID', false, null);

    } // doBuild()

} // DiscountMapBuilder
