<?php


/**
 * This class adds structure of 'st_paczkomaty_pack' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stPaczkomatyPlugin.lib.model.map
 */
class PaczkomatyPackMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stPaczkomatyPlugin.lib.model.map.PaczkomatyPackMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_paczkomaty_pack');
        $tMap->setPhpName('PaczkomatyPack');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('CUSTOMER_EMAIL', 'CustomerEmail', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('CUSTOMER_PHONE', 'CustomerPhone', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('CUSTOMER_PACZKOMAT', 'CustomerPaczkomat', 'string', CreoleTypes::VARCHAR, false, 24);

        $tMap->addColumn('SENDING_METHOD', 'SendingMethod', 'string', CreoleTypes::VARCHAR, false, 48);

        $tMap->addColumn('SENDER_PACZKOMAT', 'SenderPaczkomat', 'string', CreoleTypes::VARCHAR, false, 24);

        $tMap->addColumn('USE_SENDER_PACZKOMAT', 'UseSenderPaczkomat', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('PACK_TYPE', 'PackType', 'string', CreoleTypes::CHAR, false, 1);

        $tMap->addColumn('INPOST_SHIPMENT_ID', 'InpostShipmentId', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('INSURANCE', 'Insurance', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('CASH_ON_DELIVERY', 'CashOnDelivery', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('CODE', 'Code', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('HAS_CASH_ON_DELIVERY', 'HasCashOnDelivery', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('CUSTOMER_DELIVERING_CODE', 'CustomerDeliveringCode', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('STATUS', 'Status', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('STATUS_CHANGED_AT', 'StatusChangedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addForeignKey('ORDER_ID', 'OrderId', 'int', CreoleTypes::INTEGER, 'st_order', 'ID', false, null);

    } // doBuild()

} // PaczkomatyPackMapBuilder
