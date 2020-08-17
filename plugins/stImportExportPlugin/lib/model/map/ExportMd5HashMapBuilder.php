<?php


/**
 * This class adds structure of 'st_export_md5_hash' table to 'propel' DatabaseMap object.
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
class ExportMd5HashMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stImportExportPlugin.lib.model.map.ExportMd5HashMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_export_md5_hash');
        $tMap->setPhpName('ExportMd5Hash');

        $tMap->setUseIdGenerator(false);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addPrimaryKey('TYPE_ID', 'TypeId', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('MD5HASH', 'Md5hash', 'array', CreoleTypes::VARCHAR, false, 8192);

    } // doBuild()

} // ExportMd5HashMapBuilder
