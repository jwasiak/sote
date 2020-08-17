<?php


/**
 * This class adds structure of 'sf_guard_group_permission' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.sfGuardPlugin.lib.model.map
 */
class sfGuardGroupPermissionMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.sfGuardPlugin.lib.model.map.sfGuardGroupPermissionMapBuilder';

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

        $tMap = $this->dbMap->addTable('sf_guard_group_permission');
        $tMap->setPhpName('sfGuardGroupPermission');

        $tMap->setUseIdGenerator(false);

        $tMap->addForeignPrimaryKey('GROUP_ID', 'GroupId', 'int' , CreoleTypes::INTEGER, 'sf_guard_group', 'ID', true, null);

        $tMap->addForeignPrimaryKey('PERMISSION_ID', 'PermissionId', 'int' , CreoleTypes::INTEGER, 'sf_guard_permission', 'ID', true, null);

    } // doBuild()

} // sfGuardGroupPermissionMapBuilder
