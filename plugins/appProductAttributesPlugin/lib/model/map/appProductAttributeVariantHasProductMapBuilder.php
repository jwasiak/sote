<?php


/**
 * This class adds structure of 'app_product_attribute_variant_has_product' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.appProductAttributesPlugin.lib.model.map
 */
class appProductAttributeVariantHasProductMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.appProductAttributesPlugin.lib.model.map.appProductAttributeVariantHasProductMapBuilder';

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

        $tMap = $this->dbMap->addTable('app_product_attribute_variant_has_product');
        $tMap->setPhpName('appProductAttributeVariantHasProduct');

        $tMap->setUseIdGenerator(false);

        $tMap->addForeignPrimaryKey('PRODUCT_ID', 'ProductId', 'int' , CreoleTypes::INTEGER, 'st_product', 'ID', true, null);

        $tMap->addForeignPrimaryKey('VARIANT_ID', 'VariantId', 'int' , CreoleTypes::INTEGER, 'app_product_attribute_variant', 'ID', true, null);

    } // doBuild()

} // appProductAttributeVariantHasProductMapBuilder
