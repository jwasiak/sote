<?php


/**
 * This class adds structure of 'st_theme_layout' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stThemePlugin.lib.model.map
 */
class ThemeLayoutMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stThemePlugin.lib.model.map.ThemeLayoutMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_theme_layout');
        $tMap->setPhpName('ThemeLayout');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('THEME_ID', 'ThemeId', 'int', CreoleTypes::INTEGER, 'st_theme', 'ID', true, null);

        $tMap->addForeignKey('SF_GUARD_USER_ID', 'SfGuardUserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', false, null);

        $tMap->addColumn('CONTAINER', 'Container', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('BLOCKS', 'Blocks', 'string', CreoleTypes::LONGVARCHAR, false, null);

    } // doBuild()

} // ThemeLayoutMapBuilder
