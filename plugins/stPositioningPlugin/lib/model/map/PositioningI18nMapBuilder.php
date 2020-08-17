<?php


/**
 * This class adds structure of 'st_positioning_i18n' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stPositioningPlugin.lib.model.map
 */
class PositioningI18nMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stPositioningPlugin.lib.model.map.PositioningI18nMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_positioning_i18n');
        $tMap->setPhpName('PositioningI18n');

        $tMap->setUseIdGenerator(false);

        $tMap->addForeignPrimaryKey('ID', 'Id', 'int' , CreoleTypes::INTEGER, 'st_positioning', 'ID', true, null);

        $tMap->addPrimaryKey('CULTURE', 'Culture', 'string', CreoleTypes::VARCHAR, true, 7);

        $tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('KEYWORDS', 'Keywords', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('TITLE_PRODUCT', 'TitleProduct', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('TITLE_CATEGORY', 'TitleCategory', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('TITLE_MANUFACTEUR', 'TitleManufacteur', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('TITLE_BLOG', 'TitleBlog', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('TITLE_PRODUCT_GROUP', 'TitleProductGroup', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('TITLE_WEBPAGE', 'TitleWebpage', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('TYPE', 'Type', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('DEFAULT_TITLE', 'DefaultTitle', 'string', CreoleTypes::VARCHAR, false, 255);

    } // doBuild()

} // PositioningI18nMapBuilder
