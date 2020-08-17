<?php


/**
 * This class adds structure of 'st_order' table to 'propel' DatabaseMap object.
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
class OrderMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.OrderMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_order');
        $tMap->setPhpName('Order');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('ORDER_DELIVERY_ID', 'OrderDeliveryId', 'int', CreoleTypes::INTEGER, 'st_order_delivery', 'ID', false, null);

        $tMap->addForeignKey('SF_GUARD_USER_ID', 'SfGuardUserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', false, null);

        $tMap->addForeignKey('ORDER_USER_DATA_DELIVERY_ID', 'OrderUserDataDeliveryId', 'int', CreoleTypes::INTEGER, 'st_order_user_data_delivery', 'ID', false, null);

        $tMap->addForeignKey('ORDER_USER_DATA_BILLING_ID', 'OrderUserDataBillingId', 'int', CreoleTypes::INTEGER, 'st_order_user_data_billing', 'ID', false, null);

        $tMap->addForeignKey('ORDER_CURRENCY_ID', 'OrderCurrencyId', 'int', CreoleTypes::INTEGER, 'st_order_currency', 'ID', true, null);

        $tMap->addForeignKey('ORDER_STATUS_ID', 'OrderStatusId', 'int', CreoleTypes::INTEGER, 'st_order_status', 'ID', true, null);

        $tMap->addForeignKey('DISCOUNT_COUPON_CODE_ID', 'DiscountCouponCodeId', 'int', CreoleTypes::INTEGER, 'st_discount_coupon_code', 'ID', false, null);

        $tMap->addForeignKey('DISCOUNT_ID', 'DiscountId', 'int', CreoleTypes::INTEGER, 'st_discount', 'ID', false, null);

        $tMap->addColumn('ORDER_DISCOUNT', 'OrderDiscount', 'array', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('HASH_CODE', 'HashCode', 'string', CreoleTypes::CHAR, false, 32);

        $tMap->addColumn('PAYMENT_SECURITY_HASH', 'PaymentSecurityHash', 'string', CreoleTypes::CHAR, false, 40);

        $tMap->addColumn('SESSION_HASH', 'SessionHash', 'string', CreoleTypes::CHAR, false, 32);

        $tMap->addColumn('IS_CONFIRMED', 'IsConfirmed', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('IS_MARKED_AS_READ', 'IsMarkedAsRead', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('NUMBER', 'Number', 'string', CreoleTypes::VARCHAR, false, 64);

        $tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('ORDER_TYPE', 'OrderType', 'string', CreoleTypes::VARCHAR, false, 20);

        $tMap->addColumn('MERCHANT_NOTES', 'MerchantNotes', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('CLIENT_CULTURE', 'ClientCulture', 'string', CreoleTypes::VARCHAR, false, 7);

        $tMap->addColumn('HOST', 'Host', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_TOTAL_AMOUNT', 'OptTotalAmount', 'double', CreoleTypes::DECIMAL, true, 10);

        $tMap->addColumn('OPT_IS_PAYED', 'OptIsPayed', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('OPT_CLIENT_NAME', 'OptClientName', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_CLIENT_EMAIL', 'OptClientEmail', 'string', CreoleTypes::VARCHAR, false, 128);

        $tMap->addColumn('OPT_CLIENT_COMPANY', 'OptClientCompany', 'string', CreoleTypes::VARCHAR, false, 128);

        $tMap->addColumn('REMOTE_ADDRESS', 'RemoteAddress', 'string', CreoleTypes::VARCHAR, false, 45);

        $tMap->addColumn('IS_CODES_SENT', 'IsCodesSent', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('OPT_ALLEGRO_NICK', 'OptAllegroNick', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('OPT_ALLEGRO_CHECKOUT_FORM_ID', 'OptAllegroCheckoutFormId', 'string', CreoleTypes::CHAR, false, 36);

        $tMap->addColumn('SHOW_OPINION', 'ShowOpinion', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('CHANGE_STOCK_ON', 'ChangeStockOn', 'string', CreoleTypes::VARCHAR, false, 45);

        $tMap->addForeignKey('PARTNER_ID', 'PartnerId', 'int', CreoleTypes::INTEGER, 'st_partner', 'ID', false, null);

        $tMap->addColumn('PROVISION_VALUE', 'ProvisionValue', 'double', CreoleTypes::FLOAT, false, null);

        $tMap->addColumn('PROVISION_PAYED', 'ProvisionPayed', 'boolean', CreoleTypes::BOOLEAN, false, null);

    } // doBuild()

} // OrderMapBuilder
