<?php if ($type == 'none'): ?>
    <?php echo __("Brak"); ?>
<?php elseif($type == "proforma"): ?>
    <?php if ($ifirma_enabled ): ?>
        <?php 
            if ($order->getIfirmaInvoiceId() == 0) echo st_link_to(__("Wystaw fakturę"),"stInvoiceBackend/makeConfirmInvoice?id=".$invoice_id."&type=".$type);
            else echo st_external_link_to(__("Pobierz"),"stIFirmaPdf/showInvoice?id=".$order->getIfirmaInvoiceId()."&download=true") ;
             ?>
    <?php else: ?>
        <?php echo st_external_link_to(__("Wystaw fakturę"),"stInvoiceBackend/makeConfirmInvoice?id=".$invoice_id."&type=".$type) ?>
    <?php endif; ?>
<?php else: ?>
    <?php if ($ifirma_enabled): ?>
        <?php if($order->getIfirmaInvoiceId() == 0): ?>
            <?php echo __("Klient prosi o fakturę"); ?> (<?php echo st_link_to(__("wystaw"),"stIFirmaPdf/makeInvoice?id=".$order->getId()) ?>)
        <?php else: ?>
            <?php echo st_external_link_to(__("Pobierz"),"stIFirmaPdf/showInvoice?id=".$order->getIfirmaInvoiceId()."&download=true") ?>
        <?php endif; ?>
    <?php else: ?>
        <?php echo st_external_link_to(__("Pokaż"),"stInvoiceBackend/viewCustom?id=".$invoice_id."&type=".$type) ?> |
        <?php echo st_external_link_to(__("Pobierz"),"stInvoicePdf/show?id=".$invoice_id."&download=true") ?> |
        <?php echo st_external_link_to(__("Aktualizuj"), 'stInvoiceBackend/update?id='.$order_id.'&invoice_id='.$invoice_id) ?>
		<br/>
        <?php if($type == "request"): ?>
            <?php echo __("Klient prosi o fakturę"); ?> (<?php echo st_external_link_to(__("wystaw"),"stInvoiceBackend/makeConfirmInvoice?id=".$invoice_id."&type=".$type) ?>)
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
