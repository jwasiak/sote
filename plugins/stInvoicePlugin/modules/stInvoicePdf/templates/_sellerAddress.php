<br/>
<table cellpadding="0" cellspacing="0" border="1"><tr><td height="14" style="text-align:center;"><b><?php echo __('Sprzedawca') ?>:</b></td></tr>
<tr>
<td style="text-align:left;">
<?php echo $InvoiceUserSeller->getCompany(); ?> <br />
<?php if($InvoiceUserSeller->getCompany()==""): ?>
<?php echo $InvoiceUserSeller->getFullName(); ?><br />
<?php endif; ?>
<?php echo $InvoiceUserSeller->getAddress(); ?><br />
<?php if($InvoiceUserSeller->getAddressMore()!=""): ?>
<?php echo $InvoiceUserSeller->getAddressMore(); ?><br />
<?php endif; ?>
<?php if($InvoiceUserSeller->getRegion()!=""): ?>
<?php echo $InvoiceUserSeller->getRegion(); ?><br />
<?php endif; ?>
<?php echo $InvoiceUserSeller->getCode(); ?> <?php echo $InvoiceUserSeller->getTown(); ?> <?php echo $InvoiceUserSeller->getCountry(); ?><br />
<?php echo __('NIP')?>: <?php echo $InvoiceUserSeller->getVatNumber(); ?>
</td>
</tr>
</table>