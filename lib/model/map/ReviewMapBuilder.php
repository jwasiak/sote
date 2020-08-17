<?php


/**
 * This class adds structure of 'st_review' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ReviewMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.ReviewMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_review');
        $tMap->setPhpName('Review');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('ORDER_ID', 'OrderId', 'int', CreoleTypes::INTEGER, 'st_order', 'ID', false, null);

        $tMap->addForeignKey('SF_GUARD_USER_ID', 'SfGuardUserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', false, null);

        $tMap->addForeignKey('PRODUCT_ID', 'ProductId', 'int', CreoleTypes::INTEGER, 'st_product', 'ID', true, null);

        $tMap->addColumn('ACTIVE', 'Active', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('SCORE', 'Score', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('MERCHANT', 'Merchant', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('ADMIN_NAME', 'AdminName', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('ADMIN_ACTIVE', 'AdminActive', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('ANONYMOUS', 'Anonymous', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('AGREEMENT', 'Agreement', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('SKIPPED', 'Skipped', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('ORDER_NUMBER', 'OrderNumber', 'string', CreoleTypes::VARCHAR, false, 64);

        $tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('USER_IP', 'UserIp', 'string', CreoleTypes::VARCHAR, false, 20);

        $tMap->addColumn('USERNAME', 'Username', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('LANGUAGE', 'Language', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('IS_PIN_REVIEW', 'IsPinReview', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('PIN_REVIEW', 'PinReview', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('USER_PICTURE', 'UserPicture', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('USER_FACEBOOK', 'UserFacebook', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('USER_INSTAGRAM', 'UserInstagram', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('USER_YOUTUBE', 'UserYoutube', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('USER_TWITTER', 'UserTwitter', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('USER_REVIEW_VERIFIED', 'UserReviewVerified', 'boolean', CreoleTypes::BOOLEAN, false, null);

    } // doBuild()

} // ReviewMapBuilder
