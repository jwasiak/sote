<?php


/**
 * This class adds structure of 'st_smarty_content_block' table to 'propel' DatabaseMap object.
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
class SmartyContentBlockMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.SmartyContentBlockMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_smarty_content_block');
        $tMap->setPhpName('SmartyContentBlock');

        $tMap->setUseIdGenerator(false);

        $tMap->addPrimaryKey('NAME', 'Name', 'string', CreoleTypes::VARCHAR, true, 48);

        $tMap->addPrimaryKey('OPT_CULTURE', 'OptCulture', 'string', CreoleTypes::VARCHAR, true, 5);

        $tMap->addColumn('TYPE', 'Type', 'string', CreoleTypes::VARCHAR, true, 6);

        $tMap->addColumn('CONTENT', 'Content', 'array', CreoleTypes::LONGVARCHAR, false, null);

    } // doBuild()

} // SmartyContentBlockMapBuilder
