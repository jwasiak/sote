<br/>
<table cellpadding="0" cellspacing="0" border="0" width="440">
<tr>
<td width="10px"></td>

<td>

<table cellpadding="0" cellspacing="0" border="1" width="270px">
    
    <tr>
        <td height="14" style="text-align:center;" bgcolor="#ccc"><b><?php echo __('Dane dostawy:') ?></b></td>
    </tr>
    
    <tr>
        <td style="text-align:left;">

        <?php echo $orderUserDataDelivery->getCompany(); ?> <?php echo $orderUserDataDelivery->getName(); ?> <?php echo $orderUserDataDelivery->getSurname(); ?><br />
        <?php echo $orderUserDataDelivery->getStreet(); ?> <?php echo $orderUserDataDelivery->getHouse(); ?> <?php echo $orderUserDataDelivery->getFlat() ? "/" : null ?> <?php echo $orderUserDataDelivery->getFlat() ?><br />
        <?php echo $orderUserDataDelivery->getCode(); ?> <?php echo $orderUserDataDelivery->getTown(); ?> <?php echo $orderUserDataDelivery->getCountry(); ?><br /> 
    
        </td>
    </tr>
            
    </table>
    
</td>
</tr>
            
</table>