<?php use_helper('stOrder') ?>

<?php $results=array(); ?>

<?php foreach ($orders as $order): ?>
    

<?php if($order->getIsConfirmed()==0 && $order->getOrderStatusId()==1): ?>

<?php else: ?>

    <?php $row['number']=link_to($order->getNumber(), '@stOrderListShowForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode()) ?>
    
    <?php
    $created_at = explode(" ",$order->getCreatedAt());
	$date = explode("-",$created_at[0]);
	?>
    
    <?php $row['created_at']=$date[2]."-".$date[1]."-".$date[0]." ".$created_at[1] ?>
    
    <?php $row['status']=st_order_status($order->getOrderStatus()) ?>
    
    <?php $row['total_amount']=st_order_total_amount($order) ?>
    
    <?php
    if(stTheme::is_responsive()):

        $row['is_paid']=$order->getIsPayed() ? "<span class='green'>".__('tak')."</span>" : "<span class=''>".__('nie')."</span>";

    else:

        $row['is_paid']=$order->getIsPayed() ? "<span style='color:green'>".__('tak')."</span>" : "<span style='color:red'>".__('nie')."</span>";

    endif;
    ?>
    
    <?php if($order->getIsConfirmed()==1): ?>
        
        <?php
        if(stTheme::is_responsive()):

            $row['is_confirmed']="<span class='green'>".__('tak')."</span>";

        else:

            $row['is_confirmed']="<span style='color:green'>".__('tak')."</span>";

        endif;
        ?>
        
        <?php $row['is_confirmed_orders'] = 1 ?>
        
        <?php $smarty->assign('confirmed_orders',1); ?>
        
    
    <?php else: ?>
        
        <?php
        if(stTheme::is_responsive()):

            $row['is_confirmed']=link_to(__('potwierdź'), '@stOrderConfirmForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode(). '&register=0'. '&cancel=0', array("class"=>"green"));

        else:

            $row['is_confirmed']=link_to(__('potwierdź'), '@stOrderConfirmForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode(). '&register=0'. '&cancel=0', array("style"=>"color:green;"));

        endif;
        ?>
        
        <?php $row['is_confirmed_orders'] = 0 ?>
        
        <?php $smarty->assign('unconfirmed_orders',1); ?>
    
    <?php endif; ?>
       
    <?php $row['review']=st_get_component('stReview', 'addReviewList', array('order' => $order, 'smarty' => $smarty, 'results' => $results)) ?>
    
    <?php $row['invoice']=st_get_component('stInvoicePdf', 'orderInvoice', array('order' => $order)) ?>
            
<?php $results[]=$row;?>

<?php endif; ?>

<?php endforeach; ?> 

<?php $smarty->assign('results',$results); ?>

<?php $smarty->display('order_orders_list.html') ?>

<?php
if(stTheme::is_responsive()):

endif;
?>