<?php


/**
 * This class adds structure of 'st_invoice_status' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stInvoicePlugin.lib.model.map
 */
class InvoiceStatusMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stInvoicePlugin.lib.model.map.InvoiceStatusMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_invoice_status');
        $tMap->setPhpName('InvoiceStatus');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('INVOICE_ID', 'InvoiceId', 'int', CreoleTypes::INTEGER, 'st_invoice', 'ID', true, null);

        $tMap->addColumn('PAYMENT_ID', 'PaymentId', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('OPT_PAYMENT_TYPE_NAME', 'OptPaymentTypeName', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_PAYMENT_STATUS', 'OptPaymentStatus', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('OPT_PAYMENT_TYPE_ID', 'OptPaymentTypeId', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('HAND_MOD', 'HandMod', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('PAID_AMOUNT', 'PaidAmount', 'double', CreoleTypes::DECIMAL, false, 10);

    } // doBuild()

} // InvoiceStatusMapBuilder
