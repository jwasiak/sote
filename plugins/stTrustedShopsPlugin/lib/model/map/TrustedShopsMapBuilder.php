<?php


/**
 * This class adds structure of 'st_trusted_shops' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stTrustedShopsPlugin.lib.model.map
 */
class TrustedShopsMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stTrustedShopsPlugin.lib.model.map.TrustedShopsMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_trusted_shops');
        $tMap->setPhpName('TrustedShops');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('CERTIFICATE', 'Certificate', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('USERNAME', 'Username', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('PASSWORD', 'Password', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('TYPE', 'Type', 'string', CreoleTypes::VARCHAR, false, 20);

        $tMap->addColumn('URL', 'Url', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('LANGUAGE', 'Language', 'string', CreoleTypes::VARCHAR, false, 2);

        $tMap->addColumn('STATUS', 'Status', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('LOGO', 'Logo', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('RATING_WIDGET', 'RatingWidget', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('RATING_STATUS', 'RatingStatus', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('RATING_IN_ORDER_MAIL', 'RatingInOrderMail', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('TRUSTBADGE_CODE', 'TrustbadgeCode', 'string', CreoleTypes::LONGVARCHAR, false, null);

    } // doBuild()

} // TrustedShopsMapBuilder
