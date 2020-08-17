<?php


/**
 * This class adds structure of 'st_dashboard_gadget' table to 'propel' DatabaseMap object.
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
class DashboardGadgetMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.DashboardGadgetMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_dashboard_gadget');
        $tMap->setPhpName('DashboardGadget');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignPrimaryKey('DASHBOARD_ID', 'DashboardId', 'int' , CreoleTypes::INTEGER, 'st_dashboard', 'ID', true, null);

        $tMap->addColumn('REFRESHED_AT', 'RefreshedAt', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('REFRESH_BY', 'RefreshBy', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('DASHBOARD_COLUMN_NO', 'DashboardColumnNo', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('POSITION', 'Position', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('COLOR', 'Color', 'string', CreoleTypes::VARCHAR, false, 7);

        $tMap->addColumn('IS_MINIMIZED', 'IsMinimized', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::VARCHAR, true, 64);

        $tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, true, 48);

    } // doBuild()

} // DashboardGadgetMapBuilder
