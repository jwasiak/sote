<?php


/**
 * This class adds structure of 'st_basic_price_unit_measure' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stBasicPricePlugin.lib.model.map
 */
class BasicPriceUnitMeasureMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stBasicPricePlugin.lib.model.map.BasicPriceUnitMeasureMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_basic_price_unit_measure');
        $tMap->setPhpName('BasicPriceUnitMeasure');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('IS_DEFAULT', 'IsDefault', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('IS_SYSTEM', 'IsSystem', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('UNIT_NAME', 'UnitName', 'string', CreoleTypes::VARCHAR, false, 32);

        $tMap->addColumn('UNIT_SYMBOL', 'UnitSymbol', 'string', CreoleTypes::VARCHAR, true, 10);

        $tMap->addColumn('UNIT_GROUP', 'UnitGroup', 'string', CreoleTypes::VARCHAR, true, 10);

        $tMap->addColumn('MULTIPLIER', 'Multiplier', 'double', CreoleTypes::DECIMAL, false, 12);

    } // doBuild()

} // BasicPriceUnitMeasureMapBuilder
