<?php


/**
 * This class adds structure of 'st_order_delivery' table to 'propel' DatabaseMap object.
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
class OrderDeliveryMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.OrderDeliveryMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_order_delivery');
        $tMap->setPhpName('OrderDelivery');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('TAX_ID', 'TaxId', 'int', CreoleTypes::INTEGER, 'st_tax', 'ID', false, null);

        $tMap->addForeignKey('DELIVERY_ID', 'DeliveryId', 'int', CreoleTypes::INTEGER, 'st_delivery', 'ID', false, null);

        $tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('COST', 'Cost', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('PAYMENT_COST', 'PaymentCost', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('OPT_TAX', 'OptTax', 'double', CreoleTypes::DECIMAL, false, 5);

        $tMap->addColumn('NUMBER', 'Number', 'string', CreoleTypes::VARCHAR, false, 128);

        $tMap->addColumn('COST_BRUTTO', 'CostBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('PAYMENT_COST_BRUTTO', 'PaymentCostBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('CUSTOM_COST_BRUTTO', 'CustomCostBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('DELIVERY_DATE', 'DeliveryDate', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('PICKUP_POINT', 'PickupPoint', 'string', CreoleTypes::VARCHAR, false, 64);

        $tMap->addColumn('OPT_ALLEGRO_DELIVERY_METHOD_ID', 'OptAllegroDeliveryMethodId', 'string', CreoleTypes::CHAR, false, 36);

        $tMap->addColumn('OPT_ALLEGRO_DELIVERY_SMART', 'OptAllegroDeliverySmart', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('PACZKOMATY_NUMBER', 'PaczkomatyNumber', 'string', CreoleTypes::VARCHAR, false, 20);

    } // doBuild()

} // OrderDeliveryMapBuilder
