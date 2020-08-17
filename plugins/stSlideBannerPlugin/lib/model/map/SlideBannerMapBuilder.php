<?php


/**
 * This class adds structure of 'st_slide_banner' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stSlideBannerPlugin.lib.model.map
 */
class SlideBannerMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stSlideBannerPlugin.lib.model.map.SlideBannerMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_slide_banner');
        $tMap->setPhpName('SlideBanner');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('LANGUAGE_ID', 'LanguageId', 'int', CreoleTypes::INTEGER, 'st_language', 'ID', true, null);

        $tMap->addColumn('IMAGE', 'Image', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('IMAGE_SMALL', 'ImageSmall', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('BANNER_TYPE', 'BannerType', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('LINK', 'Link', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('GROUP_NAME', 'GroupName', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('BANNER_TITLE', 'BannerTitle', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('BANNER_DESCRIPTION', 'BannerDescription', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('BUTTON_TEXT', 'ButtonText', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('BUTTON_LINK', 'ButtonLink', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('BANNER_DESCRIPTION_POSITION', 'BannerDescriptionPosition', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('BANNER_MARGIN_LEFT', 'BannerMarginLeft', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('BANNER_MARGIN_RIGHT', 'BannerMarginRight', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('IS_ACTIVE', 'IsActive', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('OPT_CULTURE', 'OptCulture', 'string', CreoleTypes::VARCHAR, true, 7);

        $tMap->addColumn('RANK', 'Rank', 'int', CreoleTypes::INTEGER, false, null);

    } // doBuild()

} // SlideBannerMapBuilder
