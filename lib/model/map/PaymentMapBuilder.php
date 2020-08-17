<?php


/**
 * This class adds structure of 'st_payment' table to 'propel' DatabaseMap object.
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
class PaymentMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.PaymentMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_payment');
        $tMap->setPhpName('Payment');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('SF_GUARD_USER_ID', 'SfGuardUserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', false, null);

        $tMap->addForeignKey('PAYMENT_TYPE_ID', 'PaymentTypeId', 'int', CreoleTypes::INTEGER, 'st_payment_type', 'ID', false, null);

        $tMap->addColumn('AMOUNT', 'Amount', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('STATUS', 'Status', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('IN_PROGRESS', 'InProgress', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('CANCEL', 'Cancel', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('TRANSACTION_ID', 'TransactionId', 'string', CreoleTypes::VARCHAR, false, 36);

        $tMap->addColumn('HASH', 'Hash', 'string', CreoleTypes::CHAR, false, 32);

        $tMap->addColumn('PAYMENT_SECURITY_HASH', 'PaymentSecurityHash', 'string', CreoleTypes::CHAR, false, 40);

        $tMap->addColumn('PAYED_AT', 'PayedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('VERSION', 'Version', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('CONFIGURATION', 'Configuration', 'array', CreoleTypes::VARCHAR, false, 1024);

        $tMap->addColumn('ALLEGRO_PAYMENT_TYPE', 'AllegroPaymentType', 'string', CreoleTypes::VARCHAR, false, 24);

        $tMap->addForeignKey('GIFT_CARD_ID', 'GiftCardId', 'int', CreoleTypes::INTEGER, 'st_gift_card', 'ID', false, null);

    } // doBuild()

} // PaymentMapBuilder
