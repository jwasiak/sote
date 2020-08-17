<?php use_helper('stCurrency'); ?>
<?php if($id != "" && $transactions):
?>

<table cellspacing="0" cellpadding="3" class="st_record_list">
    <tr>
        <th style='text-align:center;width:140px;'><?php echo __('Data') ?></th>
        <th style='text-align:right; width:70px;'><?php echo __('Operacja') ?></th>
        <th style='text-align:right; width:70px;'><?php echo __('Stan konta') ?></th>
        <th style='text-align:center; width:200px;'><?php echo __('Zmienił') ?></th>
        <th style='text-align:center; width:225px;'><?php echo __('Opis') ?> </th>
    </tr>

    <?php
    $i=0;
    foreach ($transactions as $transaction) {
        $i++;
        
        if($i <= 5){
            echo "<tr>";
            echo "<td style='text-align:center;'>".$transaction -> getCreatedAt()."</td>";
            
            $change = $transaction -> getChangePointsVarchar();
            if ($change{0} == "-") {
                echo "<td style='text-align:right;'><span style='color:red'>" . $transaction -> getChangePointsVarchar() . "</span></td>";
            } else {
                echo "<td style='text-align:right;'><span style='color:green'>" . $transaction -> getChangePointsVarchar() . "</span></td>";
            }
            
            echo "<td style='text-align:right;'>" . $transaction -> getPoints(). "</td>";
            
            if($transaction -> getAdminId() && !$transaction -> getOrderId()){
                echo "<td style='text-align:center;'>" . link_to(__($transaction ->getSfGuardUserRelatedByAdminId() -> getUsername()),"sfGuardUser/edit?id=".$transaction ->getSfGuardUserRelatedByAdminId() -> getId()). "</td>";    
            }
                          
            if($transaction -> getOrderId()){
                echo "<td style='text-align:center;'>" . link_to(__("Zam").": ".$transaction ->getOrderNumber(),"/order/edit?id=".$transaction ->getOrderId()). "</td>";    
            }
            
            $i18n = sfContext::getInstance() -> getI18n();
            
            echo "<td style='text-align:center;'>" . $i18n -> __($transaction -> getDescription()). "</td>";
            echo "</tr>";
        }
        
        if($i == 5){
            ?>
            
            <tr><th style='text-align:center;'><a href="/backend.php/user/userPointsList/user_id/<?php echo $user->getId(); ?>/type/desc/page/1"> <?php echo __('pokaż starsze'); ?> </a></th><th style='text-align:center;' colspan="4"></th></tr>
            
            <?php
            
        }
        
    }
    ?>
    
</table>


<?php else: ?>
    <?php echo __('Brak operacji na koncie') ?>
<?php endif; ?>