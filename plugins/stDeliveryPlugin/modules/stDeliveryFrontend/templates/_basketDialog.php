<?php if ($delivery):?>
    <?php use_helper('Javascript', 'stCurrency');?>
    <?php st_theme_use_stylesheet('stDelivery.css') ?>
    <?php $results=array(); ?>
    <?php foreach ($delivery as $deliver): ?>
        <?php $row['radiobutton']=radiobutton_tag('deliver', $deliver->getId(), $deliver->getId() == $checked, array("onclick" => remote_function(array('update' => 'st_component-st_basket-sumary', 'url' => 'stDeliveryFrontend/ajaxDeliveryUpdate', 'with' => "'id=' + this.value", 'script' => true, 'complete' => visual_effect('highlight', 'st_component-st_basket-sumary', array('duration' => 3))))));?>
        <?php $row['name']=$deliver->getName();?>
        <?php $row['cost']=st_price($deliver->getCost($basket->getItems(), $order_sum), true, true);?>
        <?php $row['description']=$deliver->getDescription();?>
        <?php $results[]=$row;?>
     <?php endforeach; ?>
     <?php $smarty->assign('results',$results); ?>
     <?php $smarty->display('delivery_basket_dialog.html'); ?> 
<?php endif;?>