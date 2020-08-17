<?php


/**
 * This class adds structure of 'st_order_status' table to 'propel' DatabaseMap object.
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
class OrderStatusMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.OrderStatusMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_order_status');
        $tMap->setPhpName('OrderStatus');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('COUPON_CODE_ID', 'CouponCodeId', 'int', CreoleTypes::INTEGER, 'st_order_status_coupon_code', 'ID', false, null);

        $tMap->addColumn('OPT_NAME', 'OptName', 'string', CreoleTypes::VARCHAR, false, 128);

        $tMap->addColumn('OPT_DESCRIPTION', 'OptDescription', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('TYPE', 'Type', 'string', CreoleTypes::VARCHAR, false, 16);

        $tMap->addColumn('IS_DEFAULT', 'IsDefault', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('IS_SYSTEM_DEFAULT', 'IsSystemDefault', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('HAS_MAIL_NOTIFICATION', 'HasMailNotification', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('HAS_COUPON_CODE', 'HasCouponCode', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('HAS_INVOICE_PROFORMA', 'HasInvoiceProforma', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('HAS_INVOICE', 'HasInvoice', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('DEPOSITORY_ACTION', 'DepositoryAction', 'string', CreoleTypes::CHAR, false, 1);

    } // doBuild()

} // OrderStatusMapBuilder
