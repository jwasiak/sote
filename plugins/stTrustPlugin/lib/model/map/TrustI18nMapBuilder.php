<?php


/**
 * This class adds structure of 'st_trust_i18n' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stTrustPlugin.lib.model.map
 */
class TrustI18nMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stTrustPlugin.lib.model.map.TrustI18nMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_trust_i18n');
        $tMap->setPhpName('TrustI18n');

        $tMap->setUseIdGenerator(false);

        $tMap->addForeignPrimaryKey('ID', 'Id', 'int' , CreoleTypes::INTEGER, 'st_trust', 'ID', true, null);

        $tMap->addPrimaryKey('CULTURE', 'Culture', 'string', CreoleTypes::VARCHAR, true, 7);

        $tMap->addColumn('FIELD_DESCRIPTION', 'FieldDescription', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('FIELD_LABEL_F', 'FieldLabelF', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('FIELD_SUB_LABEL_F', 'FieldSubLabelF', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('FIELD_DESCRIPTION_F', 'FieldDescriptionF', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('ICON_F', 'IconF', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('FIELD_LABEL_S', 'FieldLabelS', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('FIELD_SUB_LABEL_S', 'FieldSubLabelS', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('FIELD_DESCRIPTION_S', 'FieldDescriptionS', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('ICON_S', 'IconS', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('FIELD_LABEL_T', 'FieldLabelT', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('FIELD_SUB_LABEL_T', 'FieldSubLabelT', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('FIELD_DESCRIPTION_T', 'FieldDescriptionT', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('ICON_T', 'IconT', 'string', CreoleTypes::VARCHAR, false, 255);

    } // doBuild()

} // TrustI18nMapBuilder
