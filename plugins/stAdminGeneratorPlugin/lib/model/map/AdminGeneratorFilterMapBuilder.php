<?php


/**
 * This class adds structure of 'st_admin_generator_filter' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stAdminGeneratorPlugin.lib.model.map
 */
class AdminGeneratorFilterMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stAdminGeneratorPlugin.lib.model.map.AdminGeneratorFilterMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_admin_generator_filter');
        $tMap->setPhpName('AdminGeneratorFilter');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('GUARD_USER_ID', 'GuardUserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

        $tMap->addForeignKey('DATA_ID', 'DataId', 'int', CreoleTypes::INTEGER, 'st_admin_generator_filter_data', 'ID', true, null);

        $tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, true, 64);

        $tMap->addColumn('MODULE_NAMESPACE', 'ModuleNamespace', 'string', CreoleTypes::VARCHAR, true, 64);

        $tMap->addColumn('IS_GLOBAL', 'IsGlobal', 'boolean', CreoleTypes::BOOLEAN, false, null);

    } // doBuild()

} // AdminGeneratorFilterMapBuilder
