<?php


/**
 * This class adds structure of 'st_order_user_data_billing' table to 'propel' DatabaseMap object.
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
class OrderUserDataBillingMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.OrderUserDataBillingMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_order_user_data_billing');
        $tMap->setPhpName('OrderUserDataBilling');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('COUNTRIES_ID', 'CountriesId', 'int', CreoleTypes::INTEGER, 'st_countries', 'ID', false, null);

        $tMap->addColumn('HAS_VALID_VAT_EU', 'HasValidVatEu', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('COUNTRY', 'Country', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('FULL_NAME', 'FullName', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('ADDRESS', 'Address', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('ADDRESS_MORE', 'AddressMore', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('REGION', 'Region', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('SURNAME', 'Surname', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('STREET', 'Street', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('HOUSE', 'House', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('FLAT', 'Flat', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('CODE', 'Code', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('TOWN', 'Town', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('PHONE', 'Phone', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('COMPANY', 'Company', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('VAT_NUMBER', 'VatNumber', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('PESEL', 'Pesel', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('CRYPT', 'Crypt', 'boolean', CreoleTypes::BOOLEAN, false, null);

    } // doBuild()

} // OrderUserDataBillingMapBuilder
