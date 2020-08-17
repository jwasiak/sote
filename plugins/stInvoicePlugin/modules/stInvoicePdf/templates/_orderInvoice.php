<?php if($ifirma_enabled): ?>
    <?php if($order->getIfirmaInvoiceId()>0): ?>
        <?php echo link_to(image_tag("frontend/theme/default/invoice_download_small.png"),"stIFirmaPdf/showInvoice?id=".$order->getIfirmaInvoiceId()."&download=true"); ?>
    <?php else: ?>
        <?php if($order->getIfirmaProformaId()>0): ?>
            <?php echo link_to(image_tag("frontend/theme/default/invoice_download_small_green.png"),"stIFirmaPdf/showProforma?id=".$order->getIfirmaProformaId()."&download=true"); ?>
        <?php endif; ?>
    <?php endif; ?>
<?php else:?>

    <?php if($showProforma == 1): ?>

        <?php if(isset($invoiceNumberProforma)): ?>
        <?php echo link_to(image_tag("frontend/theme/default/invoice_download_small.png"),"/stInvoicePdf/show?id=".$invoiceNumberProforma."&download=1&hash_code=".$order->getHashCode()); ?>
        <?php endif; ?>
        
    <?php endif; ?>
        
        <?php if(isset($invoiceNumber)): ?>
        <?php echo link_to(image_tag("frontend/theme/default/invoice_download_small_green.png"),"/stInvoicePdf/show?id=".$invoiceNumber."&download=1&hash_code=".$order->getHashCode()); ?>
        <?php endif; ?>
<?php endif; ?>
