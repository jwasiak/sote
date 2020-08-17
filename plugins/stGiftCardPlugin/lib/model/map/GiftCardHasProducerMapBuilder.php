<?php


/**
 * This class adds structure of 'st_gift_card_has_producer' table to 'propel' DatabaseMap object.
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
class GiftCardHasProducerMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stGiftCardPlugin.lib.model.map.GiftCardHasProducerMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_gift_card_has_producer');
        $tMap->setPhpName('GiftCardHasProducer');

        $tMap->setUseIdGenerator(false);

        $tMap->addForeignPrimaryKey('GIFT_CARD_ID', 'GiftCardId', 'int' , CreoleTypes::INTEGER, 'st_gift_card', 'ID', true, null);

        $tMap->addForeignPrimaryKey('PRODUCER_ID', 'ProducerId', 'int' , CreoleTypes::INTEGER, 'st_producer', 'ID', true, null);

    } // doBuild()

} // GiftCardHasProducerMapBuilder
