<?php use_helper('stOrder', 'Date', 'stProductImage', 'stUrl') ?>


<?php st_theme_use_stylesheet('stOrder.css') ?>

<?php $count_confirmed = 0; ?>

<?php $count_unconfirmed = 0; ?>

<?php $row=array(); ?>

<?php foreach ($orders as $order): ?>

<?php if($order->getIsConfirmed()==0 && $order->getOrderStatusId()==1): ?>

<?php else: ?>

    <?php if($order->getIsConfirmed()==1): ?>
       
        <?php $row[$order->getId()]['is_confirmed']=__('tak') ?>
        
        <?php $row[$order->getId()]['is_confirmed_orders'] = 1 ?>
        
        <?php $smarty->assign('confirmed_orders',1); ?>
        
    
    <?php else: ?>   	
    
        <?php $row[$order->getId()]['is_confirmed']=' | ' .link_to(__('potwierdź'), '@stOrderConfirmForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode(). '&register=0'. '&cancel=0', array("style"=>"color:green;"))." | ".link_to(__('anuluj'), '@stOrderConfirmForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode(). '&register=0'.'&cancel=1', array("style"=>"color:red;", "onclick"=>"if (confirm('Jesteś pewien?')) { f = document.createElement('form'); document.body.appendChild(f); f.method = 'POST'; f.action = this.href; f.submit(); };return false;")) ?>
        
        <?php $row[$order->getId()]['is_confirmed_orders'] = 0 ?>
        
        <?php $smarty->assign('unconfirmed_orders',1); ?>
    
    
    <?php endif; ?>

	<?php 
	$created_at = explode(" ",$order->getCreatedAt());
	$date = explode("-",$created_at[0]);
	?>

    <?php $row[$order->getId()]['link']=link_to($date[2]."-".$date[1]."-".$date[0]." ".$created_at[1] . ' | ' . st_order_total_amount($order), '@stOrderListShowForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode()); ?>
    
        <?php foreach ($order->getOrderProducts($limit) as $order_product): ?>
        
            <?php $row[$order->getId()]['products'][$order_product->getId()]['quantity']=$order_product->getQuantity() ?> 
    
            <?php $row[$order->getId()]['products'][$order_product->getId()]['name']=$order_product->getName() ?>
            
            <?php $row[$order->getId()]['products'][$order_product->getId()]['photo'] = st_link_to(st_product_image_tag($order_product, 'icon'), 'stProduct/show?url='.$order_product->getProduct()->getFriendlyUrl()); ?>
            
        <?php endforeach; ?>
    
    
<?php endif; ?>

    
<?php endforeach; ?>

<?php $check_all_url = "/order/list" ?>


<?php $smarty->assign('check_all', link_to(__("Zobacz wszystkie"),$check_all_url)) ?>

<?php $smarty->assign('check_all_url', $check_all_url) ?>

<?php if (empty($orders)): ?>

    <?php $smarty->assign('no_orders', empty($orders)) ?>

<?php endif; ?>

<?php $smarty->assign('results',$row); ?>

<?php $smarty->assign('count_confirmed',$count_confirmed); ?>

<?php $smarty->assign('count_unconfirmed',$count_unconfirmed); ?>

<?php $smarty->display('order_last_orders_by_user.html') ?>