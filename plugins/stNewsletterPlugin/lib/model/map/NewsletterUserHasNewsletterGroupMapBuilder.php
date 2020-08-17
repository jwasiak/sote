<?php


/**
 * This class adds structure of 'st_newsletter_user_has_newsletter_group' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stNewsletterPlugin.lib.model.map
 */
class NewsletterUserHasNewsletterGroupMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stNewsletterPlugin.lib.model.map.NewsletterUserHasNewsletterGroupMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_newsletter_user_has_newsletter_group');
        $tMap->setPhpName('NewsletterUserHasNewsletterGroup');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('NEWSLETTER_GROUP_ID', 'NewsletterGroupId', 'int', CreoleTypes::INTEGER, 'st_newsletter_group', 'ID', true, null);

        $tMap->addForeignKey('NEWSLETTER_USER_ID', 'NewsletterUserId', 'int', CreoleTypes::INTEGER, 'st_newsletter_user', 'ID', true, null);

    } // doBuild()

} // NewsletterUserHasNewsletterGroupMapBuilder
