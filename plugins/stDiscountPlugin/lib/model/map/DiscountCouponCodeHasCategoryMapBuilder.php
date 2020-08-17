<?php


/**
 * This class adds structure of 'st_discount_coupon_code_has_category' table to 'propel' DatabaseMap object.
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
class DiscountCouponCodeHasCategoryMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stDiscountPlugin.lib.model.map.DiscountCouponCodeHasCategoryMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_discount_coupon_code_has_category');
        $tMap->setPhpName('DiscountCouponCodeHasCategory');

        $tMap->setUseIdGenerator(false);

        $tMap->addForeignPrimaryKey('DISCOUNT_COUPON_CODE_ID', 'DiscountCouponCodeId', 'int' , CreoleTypes::INTEGER, 'st_discount_coupon_code', 'ID', true, null);

        $tMap->addForeignPrimaryKey('CATEGORY_ID', 'CategoryId', 'int' , CreoleTypes::INTEGER, 'st_category', 'ID', true, null);

        $tMap->addColumn('IS_OPT', 'IsOpt', 'boolean', CreoleTypes::BOOLEAN, true, null);

    } // doBuild()

} // DiscountCouponCodeHasCategoryMapBuilder
