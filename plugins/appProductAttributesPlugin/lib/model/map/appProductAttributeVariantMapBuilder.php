<?php


/**
 * This class adds structure of 'app_product_attribute_variant' table to 'propel' DatabaseMap object.
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
class appProductAttributeVariantMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.appProductAttributesPlugin.lib.model.map.appProductAttributeVariantMapBuilder';

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

        $tMap = $this->dbMap->addTable('app_product_attribute_variant');
        $tMap->setPhpName('appProductAttributeVariant');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('OPT_VALUE', 'OptValue', 'string', CreoleTypes::VARCHAR, true, 255);

        $tMap->addColumn('OPT_NAME', 'OptName', 'string', CreoleTypes::VARCHAR, false, 64);

        $tMap->addColumn('TYPE', 'Type', 'string', CreoleTypes::CHAR, false, 1);

        $tMap->addColumn('POSITION', 'Position', 'int', CreoleTypes::INTEGER, true, null);

    } // doBuild()

} // appProductAttributeVariantMapBuilder
