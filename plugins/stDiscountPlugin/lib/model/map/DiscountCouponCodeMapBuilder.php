<?php


/**
 * This class adds structure of 'st_discount_coupon_code' table to 'propel' DatabaseMap object.
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
class DiscountCouponCodeMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stDiscountPlugin.lib.model.map.DiscountCouponCodeMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_discount_coupon_code');
        $tMap->setPhpName('DiscountCouponCode');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('SF_GUARD_USER_ID', 'SfGuardUserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', false, null);

        $tMap->addForeignKey('ORDER_ID', 'OrderId', 'int', CreoleTypes::INTEGER, 'st_order', 'ID', false, null);

        $tMap->addColumn('CODE', 'Code', 'string', CreoleTypes::VARCHAR, true, 16);

        $tMap->addColumn('USED', 'Used', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('VALID_USAGE', 'ValidUsage', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('ALLOW_ALL_PRODUCTS', 'AllowAllProducts', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('VALID_FROM', 'ValidFrom', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('VALID_TO', 'ValidTo', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('DISCOUNT', 'Discount', 'double', CreoleTypes::DECIMAL, true, 3);

    } // doBuild()

} // DiscountCouponCodeMapBuilder
