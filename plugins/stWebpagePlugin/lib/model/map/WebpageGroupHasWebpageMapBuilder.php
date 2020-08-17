<?php


/**
 * This class adds structure of 'st_webpage_group_has_webpage' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stWebpagePlugin.lib.model.map
 */
class WebpageGroupHasWebpageMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stWebpagePlugin.lib.model.map.WebpageGroupHasWebpageMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_webpage_group_has_webpage');
        $tMap->setPhpName('WebpageGroupHasWebpage');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('WEBPAGE_ID', 'WebpageId', 'int', CreoleTypes::INTEGER, 'st_webpage', 'ID', true, null);

        $tMap->addForeignKey('WEBPAGE_GROUP_ID', 'WebpageGroupId', 'int', CreoleTypes::INTEGER, 'st_webpage_group', 'ID', true, null);

        $tMap->addColumn('RANK', 'Rank', 'int', CreoleTypes::INTEGER, false, null);

    } // doBuild()

} // WebpageGroupHasWebpageMapBuilder
