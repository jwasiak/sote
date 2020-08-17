<?php


/**
 * This class adds structure of 'st_gift_card' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stGiftCardPlugin.lib.model.map
 */
class GiftCardMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stGiftCardPlugin.lib.model.map.GiftCardMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_gift_card');
        $tMap->setPhpName('GiftCard');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('STATUS', 'Status', 'string', CreoleTypes::VARCHAR, false, 1);

        $tMap->addColumn('AMOUNT', 'Amount', 'double', CreoleTypes::DECIMAL, true, 10);

        $tMap->addColumn('MIN_ORDER_AMOUNT', 'MinOrderAmount', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('CODE', 'Code', 'string', CreoleTypes::VARCHAR, true, 64);

        $tMap->addColumn('VALID_TO', 'ValidTo', 'int', CreoleTypes::DATE, false, null);

        $tMap->addForeignKey('CURRENCY_ID', 'CurrencyId', 'int', CreoleTypes::INTEGER, 'st_currency', 'ID', true, null);

        $tMap->addColumn('ALLOW_ALL_PRODUCTS', 'AllowAllProducts', 'boolean', CreoleTypes::BOOLEAN, false, null);

    } // doBuild()

} // GiftCardMapBuilder
