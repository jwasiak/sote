<?php

/**
 * SOTESHOP/stBasket
 *
 * Ten plik należy do aplikacji stBasket opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBasket
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stInvoiceListener.class.php 2695 2009-08-20 12:16:15Z bartek $
 */
/**
 * Ładowanie helpera
 */
sfLoader::loadHelpers(array('Helper', 'stOrder'));

/**
 * Klasa sluchacza dla stBasket
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stBasket
 * @subpackage  libs
 */
class stInvoiceListener {

    public static function postExecuteOrderSave(sfEvent $event) {
        $order = $event -> getSubject() -> order;

        $user_data_billing = $event -> getSubject() -> getRequestParameter('user_data_billing');

        if ($order -> getTotalAmountWithDelivery() != "0.00") {

            $invoiceId = stInvoiceListener::crateInvoiceProforma($order);

            if (isset($user_data_billing['invoice'])) {

                if ($user_data_billing['invoice'] == 1) {
                    stInvoiceListener::crateInvoiceRequest($order, $invoiceId);
                }
            }

        }
    }

    //generowanie faktury proforma
    public static function crateInvoiceProforma($order) {

        //przygotowanie obiektu faktury proforma
        $invoice = new Invoice();

        $invoice -> setIsProforma(1);

        stEventDispatcher::getInstance() -> notify(new sfEvent($order, 'stInvoiceListener.preCrateInvoiceProforma', array('order' => $order, 'invoice' => $invoice)));

        $invoice -> setNumber(stInvoiceListener::createInvoiceNumber("proforma", 1));

        self::createInvoice($invoice);

        $invoice -> save();

        stInvoice::updateInvoice($order, $invoice);

        return $invoice -> getId();
    }

    public static function createInvoice($invoice) {
        $invoiceDataDefault = stConfig::getInstance('stInvoiceBackend');
        $invoiceDataDefault -> setCulture(stLanguage::getOptLanguage());

        $date = date('Y-M-d');

        if ($invoiceDataDefault -> get('date_create_copy') == "") {
            $invoice -> setDateCreateCopy($date);
        } else {
            $invoice -> setDateCreateCopy($invoiceDataDefault -> get('date_create_copy'));
        }

        if ($invoiceDataDefault -> get('date_selle') == "") {
            $invoice -> setDateSelle($date);
        } else {
            $invoice -> setDateSelle($invoiceDataDefault -> get('date_selle'));
        }
    }

    //generowanie faktury
    public static function crateInvoiceRequest($order, $invoiceId = null) {
        //tworzenie faktury
        $invoice = new Invoice();
        $invoice -> setIsProforma(0);
        $invoice -> setIsRequest(1);

        stEventDispatcher::getInstance() -> notify(new sfEvent($order, 'stInvoiceListener.preCrateInvoiceRequest', array('order' => $order, 'invoice' => $invoice)));

        $invoice -> setInvoiceProformaId($invoiceId);

        self::createInvoice($invoice);

        $invoice -> save();

        stInvoice::updateInvoice($order, $invoice);
    }

    public static function getInvoiceNumber($type) {
        $context = sfContext::getInstance();

        $invoiceDefault = stConfig::getInstance($context, 'stInvoiceBackend');
        $invoice = $invoiceDefault -> load();

        if ($type == "proforma") {

            return $invoice['number_proforma'];
        }

        if ($type == "confirm") {
            return $invoice['number_confirm'];
        }
    }

    public static function incarseInvoiceNumber($type) {
        $context = sfContext::getInstance();

        $invoiceDefault = stConfig::getInstance($context, 'stInvoiceBackend');
        $invoice = $invoiceDefault -> load();

        if ($type == "proforma") {
            $invoiceDefault -> set('number_proforma', $invoice['number_proforma'] + 1);
        }

        if ($type == "confirm") {
            $invoiceDefault -> set('number_confirm', $invoice['number_confirm'] + 1);
        }

        $invoiceDefault -> save(true);
    }

    public static function createInvoiceNumber($type, $inc = 0) {
        $invoiceDefault = stConfig::getInstance('stInvoiceBackend');
        $invoice = $invoiceDefault -> load();

        $number = "";

        if ($type == "proforma") {
            if ($invoice['number_proforma_format_prefix'] != "") {
                $number .= $invoice['number_proforma_format_prefix'];
                $number .= $invoice['number_proforma_format_separator'];
            }

            if ($invoice['number_proforma_format'] == 1) {
                $number .= $invoiceDefault -> get('number_proforma');
                $number .= $invoice['number_proforma_format_separator'];
                $number .= date('m');
                $number .= $invoice['number_proforma_format_separator'];
                $number .= date('Y');
            }

            if ($invoice['number_proforma_format'] == 2) {
                $number .= $invoiceDefault -> get('number_proforma');
                $number .= $invoice['number_proforma_format_separator'];
                $number .= date('Y');
            }

            if ($invoice['number_proforma_format'] == 3) {
                $number .= $invoiceDefault -> get('number_proforma');
            }

            if ($invoice['number_proforma_format_sufix'] != "") {
                $number .= $invoice['number_proforma_format_separator'];
                $number .= $invoice['number_proforma_format_sufix'];
            }
        }

        if ($type == "confirm") {

            if ($invoice['number_format_prefix'] != "") {
                $number .= $invoice['number_format_prefix'];
                $number .= $invoice['number_format_separator'];
            }

            if ($invoice['number_format'] == 1) {
                $number .= $invoiceDefault -> get('number_confirm');
                $number .= $invoice['number_format_separator'];
                $number .= date('m');
                $number .= $invoice['number_format_separator'];
                $number .= date('Y');
            }

            if ($invoice['number_format'] == 2) {
                $number .= $invoiceDefault -> get('number_confirm');
                $number .= $invoice['number_format_separator'];
                $number .= date('Y');
            }

            if ($invoice['number_format'] == 3) {
                $number .= $invoiceDefault -> get('number_confirm');
            }

            if ($invoice['number_format_sufix'] != "") {
                $number .= $invoice['number_format_separator'];
                $number .= $invoice['number_format_sufix'];
            }
        }

        if ($inc == 1) {
            $invoiceDefault -> set('number_' . $type, $invoiceDefault -> get('number_' . $type) + 1);

            $invoiceDefault -> save(true);
        }

        return $number;
    }

}
?>
