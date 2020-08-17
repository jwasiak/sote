<?php


/**
 * This class adds structure of 'st_search_link' table to 'propel' DatabaseMap object.
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
class SearchLinkMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stSearchPlugin.lib.model.map.SearchLinkMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_search_link');
        $tMap->setPhpName('SearchLink');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('OPT_TITLE', 'OptTitle', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_DESCRIPTION', 'OptDescription', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('OPT_URL', 'OptUrl', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_META_TITLE', 'OptMetaTitle', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_META_KEYWORDS', 'OptMetaKeywords', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_META_DESCRIPTION', 'OptMetaDescription', 'string', CreoleTypes::VARCHAR, false, 160);

        $tMap->addColumn('OPT_SEARCH_KEYWORDS', 'OptSearchKeywords', 'string', CreoleTypes::VARCHAR, false, 100);

    } // doBuild()

} // SearchLinkMapBuilder
