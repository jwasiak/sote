<?php


/**
 * This class adds structure of 'st_order_product_has_set' table to 'propel' DatabaseMap object.
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
class OrderProductHasSetMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.OrderProductHasSetMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_order_product_has_set');
        $tMap->setPhpName('OrderProductHasSet');

        $tMap->setUseIdGenerator(false);

        $tMap->addForeignPrimaryKey('ORDER_PRODUCT_ID', 'OrderProductId', 'int' , CreoleTypes::INTEGER, 'st_order_product', 'ID', true, null);

        $tMap->addForeignPrimaryKey('PRODUCT_ID', 'ProductId', 'int' , CreoleTypes::INTEGER, 'st_product', 'ID', true, null);

        $tMap->addColumn('CODE', 'Code', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('PRICE_NETTO', 'PriceNetto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('PRICE_BRUTTO', 'PriceBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

    } // doBuild()

} // OrderProductHasSetMapBuilder
