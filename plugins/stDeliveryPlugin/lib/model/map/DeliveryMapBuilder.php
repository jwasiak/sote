<?php


/**
 * This class adds structure of 'st_delivery' table to 'propel' DatabaseMap object.
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
class DeliveryMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stDeliveryPlugin.lib.model.map.DeliveryMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_delivery');
        $tMap->setPhpName('Delivery');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('COUNTRIES_AREA_ID', 'CountriesAreaId', 'int', CreoleTypes::INTEGER, 'st_countries_area', 'ID', false, null);

        $tMap->addForeignKey('TAX_ID', 'TaxId', 'int', CreoleTypes::INTEGER, 'st_tax', 'ID', false, null);

        $tMap->addForeignKey('TYPE_ID', 'TypeId', 'int', CreoleTypes::INTEGER, 'st_delivery_type', 'ID', false, null);

        $tMap->addColumn('FREE_DELIVERY', 'FreeDelivery', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('ACTIVE', 'Active', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('ALLOW_IN_SELECTED_PRODUCTS', 'AllowInSelectedProducts', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('DEFAULT_COST', 'DefaultCost', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('DEFAULT_COST_BRUTTO', 'DefaultCostBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('WIDTH', 'Width', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('HEIGHT', 'Height', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('DEPTH', 'Depth', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('VOLUME', 'Volume', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('IS_SYSTEM_DEFAULT', 'IsSystemDefault', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('OPT_NAME', 'OptName', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_DESCRIPTION', 'OptDescription', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('IS_DEFAULT', 'IsDefault', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('SECTION_COST_TYPE', 'SectionCostType', 'string', CreoleTypes::VARCHAR, false, 32);

        $tMap->addColumn('MAX_ORDER_WEIGHT', 'MaxOrderWeight', 'double', CreoleTypes::DECIMAL, false, 6);

        $tMap->addColumn('MAX_ORDER_AMOUNT', 'MaxOrderAmount', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('MAX_ORDER_QUANTITY', 'MaxOrderQuantity', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('MIN_ORDER_WEIGHT', 'MinOrderWeight', 'double', CreoleTypes::DECIMAL, false, 6);

        $tMap->addColumn('MIN_ORDER_AMOUNT', 'MinOrderAmount', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('MIN_ORDER_QUANTITY', 'MinOrderQuantity', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('POSITION', 'Position', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('PARAMS', 'Params', 'array', CreoleTypes::VARCHAR, false, 4096);

        $tMap->addColumn('PACZKOMATY_TYPE', 'PaczkomatyType', 'string', CreoleTypes::VARCHAR, false, 5);

        $tMap->addColumn('PACZKOMATY_SIZE', 'PaczkomatySize', 'string', CreoleTypes::VARCHAR, false, 5);

    } // doBuild()

} // DeliveryMapBuilder
