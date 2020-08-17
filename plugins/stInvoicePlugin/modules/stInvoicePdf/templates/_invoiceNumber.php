<?php if($invoice->getIsProforma() == 1 ): ?>

<br /> 
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    
    <tr>
        <td height="20" style="text-align:center;"><font size="14"><?php echo $config->get('invoice_label', null, true); ?> <?php echo $invoice->getNumber(); ?> </font></td>
    </tr>
    
</table>


<?php else: ?>

<br /> 
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    
    <tr>
        <td height="20" style="text-align:center;"><font size="14"><?php echo $config->get('invoice_label', null, true); ?> <?php echo $invoice->getNumber(); ?>  </font></td>
    </tr>
    
</table>

<?php endif; ?>