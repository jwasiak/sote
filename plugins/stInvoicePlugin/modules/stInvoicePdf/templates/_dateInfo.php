<table cellpadding="0" cellspacing="0" border="0" width="440">
<tr>

<td>
    
    <table cellpadding="0" cellspacing="0" border="0" width="320px">
    
    <tr>
        <td height="14" style="text-align:center;" ><font size="9"><?php echo __('Miejsce wystawienia') ?>:</font></td>
    </tr>
    
    <tr>
        <td height="18" style="text-align:center;"><font size="11"><b><?php echo $invoice->getTown(); ?></b></font></td>
    </tr>
    
    
    <tr>
        <td height="14" style="text-align:center;" ><font size="9"><?php echo $config->get('date_label', null, true); ?>:</font></td>
    </tr>
    
    <tr>
        <td height="18" style="text-align:center;"><font size="11"><b><?php echo $invoice->getDateSelle(); ?></b></font></td>
    </tr>
    
    
    <tr>
        <td height="14" style="text-align:center;"><font size="9"><?php echo __('Data wystawienia') ?>:</font></td>
    </tr>
    
    <tr>
        <td height="18" style="text-align:center;"><font size="11"><b><?php echo $invoice->getDateCreateCopy(); ?></b></font></td>
    </tr>
        
    </table>
    
</td>    
</tr>
</table>