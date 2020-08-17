<?php


/**
 * This class adds structure of 'st_product_options_filter' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stProductOptionsPlugin.lib.model.map
 */
class ProductOptionsFilterMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stProductOptionsPlugin.lib.model.map.ProductOptionsFilterMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_product_options_filter');
        $tMap->setPhpName('ProductOptionsFilter');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('OPT_NAME', 'OptName', 'string', CreoleTypes::VARCHAR, false, 128);

        $tMap->addColumn('FILTER_TYPE', 'FilterType', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('RANK', 'Rank', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('PRICE_FROM', 'PriceFrom', 'double', CreoleTypes::DOUBLE, false, null);

        $tMap->addColumn('PRICE_TO', 'PriceTo', 'double', CreoleTypes::DOUBLE, false, null);

        $tMap->addColumn('IS_VISIBLE', 'IsVisible', 'boolean', CreoleTypes::BOOLEAN, false, null);

    } // doBuild()

} // ProductOptionsFilterMapBuilder