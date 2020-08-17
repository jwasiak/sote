<?php use_helper('stWidgets');?>
<?php echo st_open_widget('Order',__('Ostatnio sprzedane produkty'));?>

      <div style="float:right;">

         <?php echo __('Ostatnie', null, 'stBackendMain'); ?>:

         <?php if($date_type == "day"): ?>
            <b><?php echo link_to_remote(__('24h', null, 'stBackendMain'), array('update'=>'product-last-order-widget', 'url'=>'stOrder/productLastOrderWidget?date_type=day',)) ?></b>
         <?php else: ?>
            <?php echo link_to_remote(__('24h', null, 'stBackendMain'), array('update'=>'product-last-order-widget', 'url'=>'stOrder/productLastOrderWidget?date_type=day',)) ?>
         <?php endif; ?>

         <?php if($date_type == "week"): ?>
            <b><?php echo link_to_remote(__('7 dni', null, 'stBackendMain'), array('update'=>'product-last-order-widget', 'url'=>'stOrder/productLastOrderWidget?date_type=week',)) ?></b>
         <?php else: ?>
            <?php echo link_to_remote(__('7 dni', null, 'stBackendMain'), array('update'=>'product-last-order-widget', 'url'=>'stOrder/productLastOrderWidget?date_type=week',)) ?>
         <?php endif; ?>

         <?php if($date_type == "month"): ?>
            <b><?php echo link_to_remote(__('miesiąc', null, 'stBackendMain'), array('update'=>'product-last-order-widget', 'url'=>'stOrder/productLastOrderWidget?date_type=month',)) ?></b>
         <?php else: ?>
            <?php echo link_to_remote(__('miesiąc', null, 'stBackendMain'), array('update'=>'product-last-order-widget', 'url'=>'stOrder/productLastOrderWidget?date_type=month',)) ?>
         <?php endif; ?>

         <?php if($date_type == "lastlog"): ?>
            <b><?php echo link_to_remote(__('logowanie', null, 'stBackendMain'), array('update'=>'product-last-order-widget', 'url'=>'stOrder/productLastOrderWidget?date_type=lastlog',)) ?></b>
         <?php else: ?>
            <?php echo link_to_remote(__('logowanie', null, 'stBackendMain'), array('update'=>'product-last-order-widget', 'url'=>'stOrder/productLastOrderWidget?date_type=lastlog',)) ?>
         <?php endif; ?>

      </div>
<div style="clear:both"></div>
        <div id="sf_admin_container">


<?php $width = (count($orderProducts) * 100)+100; ?>
<div style="height:160px; overflow:auto;">
<div style="width:<?php echo $width ?>px">
   
<?php $i = 0; ?>
<?php foreach ($orderProducts as $product): ?>
<?php $i++; ?>

   <?php if($order != $product->getOrderId() && $i!=1): ?>

   <div style="width:10px; height:10px; float:left;"></div>

   <?php endif; ?>

   <div style="float:left; width:100px; text-align: center;">

       <div onmouseout="document.getElementById('buttons<?php echo $i.$product->getProductId(); ?>').style.visibility = 'hidden'" onMouseOver="document.getElementById('buttons<?php echo $i.$product->getProductId(); ?>').style.visibility = 'visible'">

       <div style="border-radius: 5px 5px 5px 5px; height:90px; width:90px; border:1px solid #ccc; margin:0px auto; background: url(<?php echo st_product_image_path($product->getProduct(), 'thumb'); ?>) no-repeat; background-position:center; ">

           <div style="float:left; margin-left: 3px;">
               <?php if($product->getQuantity() != 1):?>
                   <b><?php echo __('szt.') ?> <?php echo $product->getQuantity(); ?></b>
               <?php else: ?>
                   <?php echo __('szt.') ?> <?php echo $product->getQuantity(); ?>
               <?php endif; ?>
           </div>

           <div style="visibility:hidden" id="buttons<?php echo $i.$product->getProductId(); ?>">

           <div style="float:right;">
               <?php echo st_link_to(image_tag('/images/backend/main/icons/order.png'), 'stOrder/edit?id='.$product->getOrderId()); ?>
               <?php echo st_link_to(image_tag('/images/backend/main/icons/user.png'), 'stUser/edit?id='.$product->getOrder()->getSfGuardUserId()); ?>
           </div>
         </div>

       </div>
       <div style="font-size:10px; line-height: 12px; padding-top: 3px; padding-bottom: 5px; width: 100px; height: 12px; text-align: left; padding-left: 5px;">
 
       </div>
       <?php echo st_back_price($product->getPriceBrutto(), true, true) ?>
       </div>
   </div>
   <?php $order = $product->getOrderId(); ?>
<?php endforeach ; ?>
      <div style="clear: both;"></div>
   </div>

   </div>
</div>

<div style="clear:both"></div>


<?php echo st_close_widget(); ?>