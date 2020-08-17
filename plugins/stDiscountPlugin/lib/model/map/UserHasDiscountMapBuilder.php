<?php


/**
 * This class adds structure of 'st_user_has_discount' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stDiscountPlugin.lib.model.map
 */
class UserHasDiscountMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stDiscountPlugin.lib.model.map.UserHasDiscountMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_user_has_discount');
        $tMap->setPhpName('UserHasDiscount');

        $tMap->setUseIdGenerator(false);

        $tMap->addForeignPrimaryKey('SF_GUARD_USER_ID', 'SfGuardUserId', 'int' , CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

        $tMap->addForeignPrimaryKey('DISCOUNT_ID', 'DiscountId', 'int' , CreoleTypes::INTEGER, 'st_discount', 'ID', true, null);

        $tMap->addColumn('AUTO', 'Auto', 'boolean', CreoleTypes::BOOLEAN, true, null);

    } // doBuild()

} // UserHasDiscountMapBuilder
