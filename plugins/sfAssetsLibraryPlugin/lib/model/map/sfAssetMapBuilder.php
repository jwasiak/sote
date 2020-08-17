<?php


/**
 * This class adds structure of 'sf_asset' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.sfAssetsLibraryPlugin.lib.model.map
 */
class sfAssetMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.sfAssetsLibraryPlugin.lib.model.map.sfAssetMapBuilder';

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

        $tMap = $this->dbMap->addTable('sf_asset');
        $tMap->setPhpName('sfAsset');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('FOLDER_ID', 'FolderId', 'int', CreoleTypes::INTEGER, 'sf_asset_folder', 'ID', true, null);

        $tMap->addColumn('FILENAME', 'Filename', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_DESCRIPTION', 'OptDescription', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('AUTHOR', 'Author', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('COPYRIGHT', 'Copyright', 'string', CreoleTypes::VARCHAR, false, 100);

        $tMap->addColumn('TYPE', 'Type', 'string', CreoleTypes::VARCHAR, false, 10);

        $tMap->addColumn('FILESIZE', 'Filesize', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

    } // doBuild()

} // sfAssetMapBuilder
