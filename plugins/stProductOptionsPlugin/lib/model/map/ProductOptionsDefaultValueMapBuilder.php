<?php


/**
 * This class adds structure of 'st_product_options_default_value' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stProductOptionsPlugin.lib.model.map
 */
class ProductOptionsDefaultValueMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stProductOptionsPlugin.lib.model.map.ProductOptionsDefaultValueMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_product_options_default_value');
        $tMap->setPhpName('ProductOptionsDefaultValue');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('PRODUCT_OPTIONS_TEMPLATE_ID', 'ProductOptionsTemplateId', 'int', CreoleTypes::INTEGER, 'st_product_options_template', 'ID', true, null);

        $tMap->addForeignKey('PRODUCT_OPTIONS_DEFAULT_VALUE_ID', 'ProductOptionsDefaultValueId', 'int', CreoleTypes::INTEGER, 'st_product_options_default_value', 'ID', false, null);

        $tMap->addForeignKey('PRODUCT_OPTIONS_FIELD_ID', 'ProductOptionsFieldId', 'int', CreoleTypes::INTEGER, 'st_product_options_field', 'ID', false, null);

        $tMap->addColumn('PRICE', 'Price', 'string', CreoleTypes::VARCHAR, false, 16);

        $tMap->addColumn('WEIGHT', 'Weight', 'string', CreoleTypes::VARCHAR, false, 10);

        $tMap->addColumn('LFT', 'Lft', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('RGT', 'Rgt', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('OPT_VALUE', 'OptValue', 'string', CreoleTypes::VARCHAR, false, 128);

        $tMap->addColumn('PRICE_TYPE', 'PriceType', 'string', CreoleTypes::VARCHAR, false, 6);

        $tMap->addColumn('DEPTH', 'Depth', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('OPT_VERSION', 'OptVersion', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('COLOR', 'Color', 'string', CreoleTypes::VARCHAR, false, 128);

        $tMap->addColumn('USE_IMAGE_AS_COLOR', 'UseImageAsColor', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('OLD_PRICE', 'OldPrice', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('PUM', 'Pum', 'double', CreoleTypes::DECIMAL, false, 10);

    } // doBuild()

} // ProductOptionsDefaultValueMapBuilder
