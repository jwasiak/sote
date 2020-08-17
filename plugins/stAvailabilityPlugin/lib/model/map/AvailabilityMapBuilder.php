<?php


/**
 * This class adds structure of 'st_availability' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stAvailabilityPlugin.lib.model.map
 */
class AvailabilityMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stAvailabilityPlugin.lib.model.map.AvailabilityMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_availability');
        $tMap->setPhpName('Availability');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('SF_ASSET_ID', 'SfAssetId', 'int', CreoleTypes::INTEGER, 'sf_asset', 'ID', false, null);

        $tMap->addColumn('STOCK_FROM', 'StockFrom', 'double', CreoleTypes::DECIMAL, false, 8);

        $tMap->addColumn('IS_SYSTEM_DEFAULT', 'IsSystemDefault', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('OPT_AVAILABILITY_NAME', 'OptAvailabilityName', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('COLOR', 'Color', 'string', CreoleTypes::VARCHAR, false, 6);

        $tMap->addColumn('IMAGE', 'Image', 'string', CreoleTypes::VARCHAR, false, 255);

    } // doBuild()

} // AvailabilityMapBuilder
