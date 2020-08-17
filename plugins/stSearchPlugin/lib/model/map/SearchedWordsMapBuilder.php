<?php


/**
 * This class adds structure of 'st_searched_words' table to 'propel' DatabaseMap object.
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
class SearchedWordsMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stSearchPlugin.lib.model.map.SearchedWordsMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_searched_words');
        $tMap->setPhpName('SearchedWords');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('WORD', 'Word', 'string', CreoleTypes::VARCHAR, true, 255);

        $tMap->addColumn('RESULTS', 'Results', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('SEARCHED', 'Searched', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('SWAP', 'Swap', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('URL', 'Url', 'string', CreoleTypes::VARCHAR, false, 255);

    } // doBuild()

} // SearchedWordsMapBuilder
