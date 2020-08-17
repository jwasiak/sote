<?php


/**
 * This class adds structure of 'app_product_attribute' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.appProductAttributesPlugin.lib.model.map
 */
class appProductAttributeMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.appProductAttributesPlugin.lib.model.map.appProductAttributeMapBuilder';

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

        $tMap = $this->dbMap->addTable('app_product_attribute');
        $tMap->setPhpName('appProductAttribute');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('IS_ACTIVE', 'IsActive', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('IS_SEARCHABLE', 'IsSearchable', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('IS_VISIBLE_ON_PP', 'IsVisibleOnPp', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('OPT_NAME', 'OptName', 'string', CreoleTypes::VARCHAR, true, 128);

        $tMap->addColumn('TYPE', 'Type', 'string', CreoleTypes::CHAR, true, 1);

        $tMap->addColumn('POSITION', 'Position', 'int', CreoleTypes::INTEGER, true, null);

    } // doBuild()

} // appProductAttributeMapBuilder