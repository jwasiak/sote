<?php


/**
 * This class adds structure of 'st_export_profile_has_export_field' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stImportExportPlugin.lib.model.map
 */
class ExportProfileHasExportFieldMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stImportExportPlugin.lib.model.map.ExportProfileHasExportFieldMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_export_profile_has_export_field');
        $tMap->setPhpName('ExportProfileHasExportField');

        $tMap->setUseIdGenerator(false);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addForeignPrimaryKey('EXPORT_PROFILE_ID', 'ExportProfileId', 'int' , CreoleTypes::INTEGER, 'st_export_profile', 'ID', true, null);

        $tMap->addForeignPrimaryKey('EXPORT_FIELD_ID', 'ExportFieldId', 'int' , CreoleTypes::INTEGER, 'st_export_field', 'ID', true, null);

    } // doBuild()

} // ExportProfileHasExportFieldMapBuilder
