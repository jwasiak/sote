<?php


/**
 * This class adds structure of 'st_search_link_i18n' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stSearchPlugin.lib.model.map
 */
class SearchLinkI18nMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stSearchPlugin.lib.model.map.SearchLinkI18nMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_search_link_i18n');
        $tMap->setPhpName('SearchLinkI18n');

        $tMap->setUseIdGenerator(false);

        $tMap->addForeignPrimaryKey('ID', 'Id', 'int' , CreoleTypes::INTEGER, 'st_search_link', 'ID', true, null);

        $tMap->addPrimaryKey('CULTURE', 'Culture', 'string', CreoleTypes::VARCHAR, true, 7);

        $tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('URL', 'Url', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('META_TITLE', 'MetaTitle', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('META_KEYWORDS', 'MetaKeywords', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('META_DESCRIPTION', 'MetaDescription', 'string', CreoleTypes::VARCHAR, false, 160);

        $tMap->addColumn('SEARCH_KEYWORDS', 'SearchKeywords', 'string', CreoleTypes::VARCHAR, false, 100);

    } // doBuild()

} // SearchLinkI18nMapBuilder
