<?php


/**
 * This class adds structure of 'st_order_has_payment' table to 'propel' DatabaseMap object.
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
class OrderHasPaymentMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.OrderHasPaymentMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_order_has_payment');
        $tMap->setPhpName('OrderHasPayment');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('ORDER_ID', 'OrderId', 'int', CreoleTypes::INTEGER, 'st_order', 'ID', true, null);

        $tMap->addForeignKey('PAYMENT_ID', 'PaymentId', 'int', CreoleTypes::INTEGER, 'st_payment', 'ID', true, null);

    } // doBuild()

} // OrderHasPaymentMapBuilder
