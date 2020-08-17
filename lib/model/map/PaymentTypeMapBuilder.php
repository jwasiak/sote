<?php


/**
 * This class adds structure of 'st_payment_type' table to 'propel' DatabaseMap object.
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
class PaymentTypeMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.PaymentTypeMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_payment_type');
        $tMap->setPhpName('PaymentType');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('MODULE_NAME', 'ModuleName', 'string', CreoleTypes::VARCHAR, false, 32);

        $tMap->addColumn('HIDE_MODULE', 'HideModule', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('HIDE_FOR_CONFIGURATION', 'HideForConfiguration', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('HIDE_FOR_WHOLESALE', 'HideForWholesale', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('ACTIVE', 'Active', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('IMAGE', 'Image', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('CONFIGURATION', 'Configuration', 'array', CreoleTypes::VARCHAR, false, 1024);

        $tMap->addColumn('OPT_NAME', 'OptName', 'string', CreoleTypes::VARCHAR, true, 128);

        $tMap->addColumn('OPT_DESCRIPTION', 'OptDescription', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('OPT_SUMMARY_DESCRIPTION', 'OptSummaryDescription', 'string', CreoleTypes::LONGVARCHAR, false, null);

    } // doBuild()

} // PaymentTypeMapBuilder
