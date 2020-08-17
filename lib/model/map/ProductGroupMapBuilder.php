<?php


/**
 * This class adds structure of 'st_product_group' table to 'propel' DatabaseMap object.
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
class ProductGroupMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.ProductGroupMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_product_group');
        $tMap->setPhpName('ProductGroup');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('PRODUCT_GROUP', 'ProductGroup', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_NAME', 'OptName', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('PRODUCT_LIMIT', 'ProductLimit', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('OPT_URL', 'OptUrl', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_LABEL', 'OptLabel', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_IMAGE', 'OptImage', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('FROM_BASKET_VALUE', 'FromBasketValue', 'int', CreoleTypes::INTEGER, false, null);

    } // doBuild()

} // ProductGroupMapBuilder