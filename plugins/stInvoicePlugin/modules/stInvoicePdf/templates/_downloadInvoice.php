
<?php if($showProforma == 1 && $number!=false): ?>
    
	<?php if(stTheme::is_responsive()): ?>	
		<a class="download btn btn-default" href="/stInvoicePdf/show/id/<?php echo $number; ?>/download/1/hash_code/<?php echo $order->getHashCode(); ?>" rel="noindex, nofollow">
            <span class="glyphicon glyphicon-file"></span>
            <?php echo __('Proforma PDF'); ?>
        </a>
		<?php else: ?>
		    <?php use_stylesheet('/css/frontend/theme/default2/stInvoicePlugin.css'); ?>
		    
		    <div id="invoice_icon">
            <div class="invoice_img">
                <?php if($ifirma_enabled): ?>
                    <?php echo link_to(image_tag("frontend/theme/default/invoice_download.png"),"stIFirmaPdf/showProforma?id=".$order->getIfirmaProformaId()."&download=true", array( "rel"=>"noindex, nofollow")); ?>
                <?php else: ?>    
                    <?php echo link_to(image_tag("frontend/theme/default/invoice_download.png"),"/stInvoicePdf/show?id=".$number."&download=1&hash_code=".$order->getHashCode(), array( "rel"=>"noindex, nofollow") ); ?>
                <?php endif; ?>             
            </div>
            <div class="invoice-text">
                <?php echo link_to(__("Proforma"),"/stInvoicePdf/show?id=".$number."&download=1&hash_code=".$order->getHashCode(), array( "rel"=>"noindex, nofollow") ); ?>
            </div>      
        </div>
		    
		<?php endif; ?>    
		    
<?php endif; ?>
