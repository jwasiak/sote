<?php


/**
 * This class adds structure of 'st_invoice' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stInvoicePlugin.lib.model.map
 */
class InvoiceMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stInvoicePlugin.lib.model.map.InvoiceMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_invoice');
        $tMap->setPhpName('Invoice');

        $tMap->setUseIdGenerator(true);

        $tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignKey('INVOICE_USER_SELLER_ID', 'InvoiceUserSellerId', 'int', CreoleTypes::INTEGER, 'st_invoice_user_seller', 'ID', false, null);

        $tMap->addForeignKey('INVOICE_USER_CUSTOMER_ID', 'InvoiceUserCustomerId', 'int', CreoleTypes::INTEGER, 'st_invoice_user_customer', 'ID', false, null);

        $tMap->addForeignKey('ORDER_ID', 'OrderId', 'int', CreoleTypes::INTEGER, 'st_order', 'ID', false, null);

        $tMap->addForeignKey('INVOICE_CURRENCY_ID', 'InvoiceCurrencyId', 'int', CreoleTypes::INTEGER, 'st_invoice_currency', 'ID', false, null);

        $tMap->addColumn('INVOICE_PROFORMA_ID', 'InvoiceProformaId', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('COMPANY_DESCRIPTION', 'CompanyDescription', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('INVOICE_DESCRIPTION', 'InvoiceDescription', 'string', CreoleTypes::LONGVARCHAR, false, null);

        $tMap->addColumn('ORDER_DISCOUNT', 'OrderDiscount', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('DATE_SELLE', 'DateSelle', 'int', CreoleTypes::DATE, false, null);

        $tMap->addColumn('DATE_CREATE_COPY', 'DateCreateCopy', 'int', CreoleTypes::DATE, false, null);

        $tMap->addColumn('NUMBER', 'Number', 'string', CreoleTypes::VARCHAR, false, 45);

        $tMap->addColumn('SIGNATURE_SELLER', 'SignatureSeller', 'string', CreoleTypes::VARCHAR, false, 45);

        $tMap->addColumn('SIGNATURE_CUSTOMER', 'SignatureCustomer', 'string', CreoleTypes::VARCHAR, false, 45);

        $tMap->addColumn('OPT_TOTAL_AMMOUNT_BRUTTO', 'OptTotalAmmountBrutto', 'double', CreoleTypes::DECIMAL, false, 10);

        $tMap->addColumn('TOWN', 'Town', 'string', CreoleTypes::VARCHAR, false, 255);

        $tMap->addColumn('CURENCY', 'Curency', 'string', CreoleTypes::VARCHAR, false, 20);

        $tMap->addColumn('MAX_DAY', 'MaxDay', 'string', CreoleTypes::VARCHAR, false, 20);

        $tMap->addColumn('PAYMENT_TYPE', 'PaymentType', 'string', CreoleTypes::VARCHAR, false, 20);

        $tMap->addColumn('IS_PROFORMA', 'IsProforma', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('IS_REQUEST', 'IsRequest', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('IS_CONFIRM', 'IsConfirm', 'boolean', CreoleTypes::BOOLEAN, false, null);

    } // doBuild()

} // InvoiceMapBuilder
