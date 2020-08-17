<?php


/**
 * This class adds structure of 'st_delivery_has_payment_type' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stDeliveryPlugin.lib.model.map
 */
class DeliveryHasPaymentTypeMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stDeliveryPlugin.lib.model.map.DeliveryHasPaymentTypeMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_delivery_has_payment_type');
        $tMap->setPhpName('DeliveryHasPaymentType');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('PAYMENT_TYPE_ID', 'PaymentTypeId', 'int', CreoleTypes::INTEGER, 'st_payment_type', 'ID', true, null);

        $tMap->addForeignKey('DELIVERY_ID', 'DeliveryId', 'int', CreoleTypes::INTEGER, 'st_delivery', 'ID', true, null);

        $tMap->addColumn('IS_ACTIVE', 'IsActive', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('IS_DEFAULT', 'IsDefault', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('COST', 'Cost', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('COST_BRUTTO', 'CostBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('FREE_FROM', 'FreeFrom', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('COST_TYPE', 'CostType', 'string', CreoleTypes::CHAR, true, null);

        $tMap->addColumn('COURIER_COST', 'CourierCost', 'double', CreoleTypes::DECIMAL, false, 10);

    } // doBuild()

} // DeliveryHasPaymentTypeMapBuilder
