<?php


/**
 * This class adds structure of 'st_poczta_polska_punkt_odbioru' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stPocztaPolskaPlugin.lib.model.map
 */
class PocztaPolskaPunktOdbioruMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stPocztaPolskaPlugin.lib.model.map.PocztaPolskaPunktOdbioruMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_poczta_polska_punkt_odbioru');
        $tMap->setPhpName('PocztaPolskaPunktOdbioru');

        $tMap->setUseIdGenerator(false);

        $tMap->addForeignPrimaryKey('ORDER_ID', 'OrderId', 'int' , CreoleTypes::INTEGER, 'st_order', 'ID', true, null);

        $tMap->addColumn('PNI', 'Pni', 'string', CreoleTypes::VARCHAR, false, 16);

        $tMap->addColumn('TYPE', 'Type', 'string', CreoleTypes::VARCHAR, false, 16);

        $tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 64);

        $tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::VARCHAR, false, 512);

        $tMap->addColumn('PHONE', 'Phone', 'string', CreoleTypes::VARCHAR, false, 128);

        $tMap->addColumn('STREET', 'Street', 'string', CreoleTypes::VARCHAR, false, 100);

        $tMap->addColumn('CITY', 'City', 'string', CreoleTypes::VARCHAR, false, 64);

        $tMap->addColumn('ZIP_CODE', 'ZipCode', 'string', CreoleTypes::VARCHAR, false, 16);

        $tMap->addColumn('PROVINCE', 'Province', 'string', CreoleTypes::VARCHAR, false, 45);

        $tMap->addColumn('EKSPRES24', 'Ekspres24', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('KURIER48', 'Kurier48', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('PACZKA_EKSTRA24', 'PaczkaEkstra24', 'boolean', CreoleTypes::BOOLEAN, false, null);

    } // doBuild()

} // PocztaPolskaPunktOdbioruMapBuilder
