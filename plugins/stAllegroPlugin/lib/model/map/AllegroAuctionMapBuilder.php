<?php


/**
 * This class adds structure of 'st_allegro_auction' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stAllegroPlugin.lib.model.map
 */
class AllegroAuctionMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stAllegroPlugin.lib.model.map.AllegroAuctionMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_allegro_auction');
        $tMap->setPhpName('AllegroAuction');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('PRODUCT_ID', 'ProductId', 'int', CreoleTypes::INTEGER, 'st_product', 'ID', true, null);

        $tMap->addColumn('PRODUCT_OPTIONS', 'ProductOptions', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('REQUIRES_SYNC', 'RequiresSync', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('SITE', 'Site', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('AUCTION_ID', 'AuctionId', 'string', CreoleTypes::BIGINT, false, null);

        $tMap->addColumn('ENDED', 'Ended', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('ENDED_AT', 'EndedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('COMMANDS', 'Commands', 'array', CreoleTypes::VARCHAR, false, 1024);

    } // doBuild()

} // AllegroAuctionMapBuilder
