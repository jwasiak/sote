<?php


/**
 * This class adds structure of 'st_user_points' table to 'propel' DatabaseMap object.
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
class UserPointsMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.UserPointsMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_user_points');
        $tMap->setPhpName('UserPoints');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('SF_GUARD_USER_ID', 'SfGuardUserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

        $tMap->addColumn('POINTS', 'Points', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('CHANGE_POINTS', 'ChangePoints', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('CHANGE_POINTS_VARCHAR', 'ChangePointsVarchar', 'string', CreoleTypes::VARCHAR, false, 10);

        $tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addForeignKey('ORDER_ID', 'OrderId', 'int', CreoleTypes::INTEGER, 'st_order', 'ID', false, null);

        $tMap->addColumn('ORDER_NUMBER', 'OrderNumber', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('ORDER_HASH', 'OrderHash', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addForeignKey('ADMIN_ID', 'AdminId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', false, null);

    } // doBuild()

} // UserPointsMapBuilder
