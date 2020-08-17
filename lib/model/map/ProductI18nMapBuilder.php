<?php


/**
 * This class adds structure of 'st_product_i18n' table to 'propel' DatabaseMap object.
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
class ProductI18nMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.ProductI18nMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_product_i18n');
        $tMap->setPhpName('ProductI18n');

        $tMap->setUseIdGenerator(false);

        $tMap->addForeignPrimaryKey('ID', 'Id', 'int' , CreoleTypes::INTEGER, 'st_product', 'ID', true, null);

        $tMap->addPrimaryKey('CULTURE', 'Culture', 'string', CreoleTypes::VARCHAR, true, 7);

        $tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('SHORT_DESCRIPTION', 'ShortDescription', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::MEDIUMTEXT, false, null);

        $tMap->addColumn('SEARCH_KEYWORDS', 'SearchKeywords', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('URL', 'Url', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('UOM', 'Uom', 'string', CreoleTypes::VARCHAR, false, 10);

        $tMap->addColumn('EXECUTION_TIME', 'ExecutionTime', 'string', CreoleTypes::VARCHAR, false, 64);

        $tMap->addColumn('DESCRIPTION2', 'Description2', 'string', CreoleTypes::MEDIUMTEXT, false, null);

        $tMap->addColumn('ATTRIBUTES_LABEL', 'AttributesLabel', 'string', CreoleTypes::VARCHAR, false, 48);

    } // doBuild()

} // ProductI18nMapBuilder
