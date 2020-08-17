<br/>
<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td><table cellpadding="0" cellspacing="0" border="1">
<tr>
<td height="14" style="text-align:center;" bgcolor="#ccc"><b><?php echo __('Nabywca') ?>:</b></td>
</tr>
<tr>
<td style="text-align:left;">
<?php if($InvoiceUserCustomer->getCompany()): ?>   
<?php echo $InvoiceUserCustomer->getCompany(); ?><br />
<?php endif; ?>
<?php if($InvoiceUserCustomer->getCompany()==""): ?> 
<?php echo $InvoiceUserCustomer->getFullName(); ?><br />
<?php endif; ?>
<?php echo $InvoiceUserCustomer->getAddress(); ?><br />
<?php if($InvoiceUserCustomer->getAddressMore()!=""): ?>
<?php echo $InvoiceUserCustomer->getAddressMore(); ?><br />
<?php endif; ?>
<?php if($InvoiceUserCustomer->getRegion()!=""): ?>
<?php echo $InvoiceUserCustomer->getRegion(); ?><br />
<?php endif; ?>
<?php echo $InvoiceUserCustomer->getCode(); ?> <?php echo $InvoiceUserCustomer->getTown(); ?> <?php echo $InvoiceUserCustomer->getCountry(); ?>
<?php if($InvoiceUserCustomer->getPesel()!=""): ?>
<br /><?php echo __('PESEL')?>: <?php echo $InvoiceUserCustomer->getPesel(); ?>
<?php endif; ?>
<?php if ($InvoiceUserCustomer->getVatNumber()): ?>
<br /><?php echo __('NIP')?>: <?php echo $InvoiceUserCustomer->getVatNumber(); ?>
<?php endif; ?>
</td>
</tr>
</table>
</td>
</tr>
</table>