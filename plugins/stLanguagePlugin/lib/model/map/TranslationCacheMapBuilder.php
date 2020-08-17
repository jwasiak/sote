<?php


/**
 * This class adds structure of 'st_translation_cache' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stLanguagePlugin.lib.model.map
 */
class TranslationCacheMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stLanguagePlugin.lib.model.map.TranslationCacheMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_translation_cache');
        $tMap->setPhpName('TranslationCache');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('LANGUAGE_ID', 'LanguageId', 'int', CreoleTypes::INTEGER, 'st_language', 'ID', true, null);

        $tMap->addColumn('CATALOGUE', 'Catalogue', 'string', CreoleTypes::VARCHAR, false, 100);

        $tMap->addColumn('CATALOGUE_INDEX', 'CatalogueIndex', 'string', CreoleTypes::VARCHAR, false, 8);

        $tMap->addColumn('VALUE', 'Value', 'string', CreoleTypes::LONGVARCHAR, false, null);

    } // doBuild()

} // TranslationCacheMapBuilder
