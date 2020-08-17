<?php


/**
 * This class adds structure of 'st_language' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stLanguagePlugin.lib.model.map
 */
class LanguageMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stLanguagePlugin.lib.model.map.LanguageMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_language');
        $tMap->setPhpName('Language');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('CURRENCY_ID', 'CurrencyId', 'int', CreoleTypes::INTEGER, 'st_currency', 'ID', false, null);

        $tMap->addColumn('ACTIVE_IMAGE', 'ActiveImage', 'string', CreoleTypes::VARCHAR, false, 36);

        $tMap->addColumn('INACTIVE_IMAGE', 'InactiveImage', 'string', CreoleTypes::VARCHAR, false, 36);

        $tMap->addColumn('SHORTCUT', 'Shortcut', 'string', CreoleTypes::VARCHAR, false, 3);

        $tMap->addColumn('IS_DEFAULT', 'IsDefault', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('ACTIVE', 'Active', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('LANGUAGE', 'Language', 'string', CreoleTypes::VARCHAR, false, 10);

        $tMap->addColumn('IS_TRANSLATE', 'IsTranslate', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('SYSTEM', 'System', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('IS_DEFAULT_PANEL', 'IsDefaultPanel', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('IS_TRANSLATE_PANEL', 'IsTranslatePanel', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('OPT_NAME', 'OptName', 'string', CreoleTypes::VARCHAR, false, 255);

    } // doBuild()

} // LanguageMapBuilder
