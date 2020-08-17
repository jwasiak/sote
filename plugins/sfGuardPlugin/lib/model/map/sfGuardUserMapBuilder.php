<?php


/**
 * This class adds structure of 'sf_guard_user' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.sfGuardPlugin.lib.model.map
 */
class sfGuardUserMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.sfGuardPlugin.lib.model.map.sfGuardUserMapBuilder';

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

        $tMap = $this->dbMap->addTable('sf_guard_user');
        $tMap->setPhpName('sfGuardUser');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('USERNAME', 'Username', 'string', CreoleTypes::VARCHAR, true, 128);

        $tMap->addColumn('ALGORITHM', 'Algorithm', 'string', CreoleTypes::VARCHAR, true, 128);

        $tMap->addColumn('SALT', 'Salt', 'string', CreoleTypes::VARCHAR, true, 128);

        $tMap->addColumn('PASSWORD', 'Password', 'string', CreoleTypes::VARCHAR, true, 128);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('LAST_LOGIN', 'LastLogin', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('IS_ACTIVE', 'IsActive', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('IS_SUPER_ADMIN', 'IsSuperAdmin', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('IS_CONFIRM', 'IsConfirm', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('IS_ADMIN_CONFIRM', 'IsAdminConfirm', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('HASH_CODE', 'HashCode', 'string', CreoleTypes::VARCHAR, false, 128);

        $tMap->addColumn('LANGUAGE', 'Language', 'string', CreoleTypes::VARCHAR, false, 10);

        $tMap->addColumn('EXTERNAL_ACCOUNT', 'ExternalAccount', 'string', CreoleTypes::VARCHAR, false, 128);

        $tMap->addColumn('POINTS', 'Points', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('POINTS_AVAILABLE', 'PointsAvailable', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('POINTS_RELEASE', 'PointsRelease', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('OPT_ALLEGRO_USER_ID', 'OptAllegroUserId', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('WHOLESALE', 'Wholesale', 'string', CreoleTypes::CHAR, true, 1);

    } // doBuild()

} // sfGuardUserMapBuilder
