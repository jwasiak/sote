<?php use_helper('stCurrency') ?> 
<br />
<?php if ($invoice->getIsProforma() != 1): ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td><table border="1" cellpadding="0" cellspacing="0">
<tr>
<td  style="text-align:center; width: 190%"><font size="8"><?php echo __('według stawki VAT') ?></font></td>
<td  style="text-align:center; width: 70%" ><font size="8"><?php echo __('wartość netto') ?></font></td>
<td  style="text-align:center; width: 70%" ><font size="8"><?php echo __('kwota VAT') ?></font></td>
<td  style="text-align:center; width: 70%" ><font size="8"><?php echo __('wartość brutto') ?></font></td>
</tr>
<?php $i = 0; ?>
<?php
               $sumTotalNetto = 0;
               $sumTotalAmmountVat = 0;
               $sumTotalBrutto = 0;
?>
<?php foreach ($taxProducts as $taxProduct): ?>
<tr>
<td style="text-align:left;  width: 190%"><font size="8">
<?php if($taxProduct['is_default']==1): ?>
<?php echo __('Podstawowy podatek VAT') ?> <?php echo $taxProduct['vat_name'] ?>
<?php else: ?>
<?php echo __('Podatek VAT') ?> <?php echo $taxProduct['vat_name'] ?>
<?php endif; ?>
</font>
</td>
<td  style="text-align:right; width: 70%"><font size="8"><?php echo st_back_price($taxProduct['total_netto']) ?></font></td>
<td  style="text-align:right; width: 70%"><font size="8"><?php echo st_back_price($taxProduct['total_ammount_vat']) ?></font></td>
<td  style="text-align:right; width: 70%"><font size="8"><?php echo st_back_price($taxProduct['total_brutto']) ?></font></td>
</tr>
<?php
$sumTotalNetto += $taxProduct['total_netto'];
$sumTotalAmmountVat += $taxProduct['total_ammount_vat'];
$sumTotalBrutto += $taxProduct['total_brutto'];
?>
<?php endforeach; ?>
<tr>
<td  style="border-color: #fff; text-align:right; width: 190%"><font size="8"><?php echo __('Razem') ?>:</font></td>
<td  style="border-color: #fff; text-align:right; width: 70%"><font size="8"><?php echo st_back_price($sumTotalNetto) ?></font></td>
<td  style="border-color: #fff; text-align:right; width: 70%"><font size="8"><?php echo st_back_price($sumTotalAmmountVat) ?></font></td>
<td  style="border-color: #fff; text-align:right; width: 70%"><font size="8"><?php echo st_back_price($sumTotalBrutto) ?></font></td>
</tr>
</table>
</td>
</tr> 
</table>
<?php endif; ?>