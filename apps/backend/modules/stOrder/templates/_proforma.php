<?php if($type == "none"): ?>
    <?php echo __("Brak"); ?>
<?php else: ?>
    <?php if ($ifirma_enabled && $order->getIfirmaProformaId()>0): ?>
        <?php echo st_external_link_to(__("Pobierz"),"stIFirmaPdf/showProforma?id=".$order->getIfirmaProformaId()."&download=true") ?>
    <?php else: ?>
        <?php echo st_external_link_to(__("Pokaż"),"stInvoiceBackend/viewCustom?id=".$invoice_id."&type=proforma") ?> |
        <?php echo st_external_link_to(__("Pobierz"),"stInvoicePdf/show?id=".$invoice_id."&download=true") ?> |
        <?php echo st_external_link_to(__("Aktualizuj"),"stInvoiceBackend/update?id=".$order_id.'&invoice_id='.$invoice_id) ?>
    <?php endif; ?>
<?php endif; ?>
