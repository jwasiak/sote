<?php


/**
 * This class adds structure of 'st_blog_has_blog_category' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stBlogPlugin.lib.model.map
 */
class BlogHasBlogCategoryMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stBlogPlugin.lib.model.map.BlogHasBlogCategoryMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_blog_has_blog_category');
        $tMap->setPhpName('BlogHasBlogCategory');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('BLOG_ID', 'BlogId', 'int', CreoleTypes::INTEGER, 'st_blog', 'ID', true, null);

        $tMap->addForeignKey('BLOG_CATEGORY_ID', 'BlogCategoryId', 'int', CreoleTypes::INTEGER, 'st_blog_category', 'ID', true, null);

    } // doBuild()

} // BlogHasBlogCategoryMapBuilder