use_helper('stCurrency','stText', 'stProductPrice', 'stProductImage', 'stUrl'); ?>
<?php st_theme_use_stylesheet('stProduct.css') ?>

<?php if($products): ?>
    <?php $smarty->assign("show_name", $config->get('show_name_group'));?>
    <?php $smarty->assign("show_image", $config->get('show_image_group'));?>
    <?php $smarty->assign("show_price", $config->get('show_price_group'));?>
    <?php $smarty->assign("show_basket", $config->get('show_basket_long'));?>    
    <?php $smarty->assign("price_view", $config->get('price_view_group'));?>
    <?php $smarty->assign("show_description", $config->get('show_description_group'));?>
    <?php $smarty->assign("show_old_price", $config->get('show_old_price_group'));?>
    <?php $smarty->assign("show_discount", $config->get('show_discount_group'));?>
    <?php $i=0;?> 
    <?php $results=array(); ?>
    <?php foreach ($products as $product): $row = array(); $row['instance'] = $product  ?>

        <?php $i++; ?>
        <?php if ($i==1): ?>                
            <?php $row['class']='st_component-st_product-product_main_box_first' ?>
        <?php elseif ($i==3): ?>                
            <?php $row['class']='st_component-st_product-product_main_box_last' ?>
            <?php $i=0; ?>
        <?php else: ?>                 
            <?php $row['class']='st_component-st_product-product_main_box_middle' ?>
        <?php endif; ?>                   
        
    <?php if ((ShowProductPrice(st_price($product->getPriceBrutto(), true, true)) == false) || ($product->getHidePrice()==1)):?>
        <?php $row['check_price']=1;?>
    <?php else:?>
        <?php $row['check_price']=0;?>
    <?php endif;?>
    
        <?php $row['hide_price']=$product->getHidePrice();?>      
    
        <?php if ($config->get('cut_name_group')!=1 || (st_check_strlen($product->getName())<$config->get('cut_name_num_group'))):?>
            <?php $row['name']=st_link_to($product->getName(), 'stProduct/show?url='.$product->getFriendlyUrl(),array('class'=>'product_name'));?>
        <?php else: ?>
            <?php $row['name']='<span title="'.$product->getName().'"  class="hint">'.st_link_to(st_truncate_text($product->getName(),$config->get('cut_name_num_group'),'...'), 'stProduct/show?url='.$product->getFriendlyUrl(),array('class'=>'product_name'))."</span>"; ?>
       <?php endif;?>
    
        <?php $row['id']=$product->getId() ?>
         
       <?php if ($config->get('description_type_group')=='short'):?>
           <?php if ($config->get('cut_description_group')!=1 || (st_check_strlen($product->getShortDescription())<$config->get('cut_description_num_group'))):?> 
               <?php $row['description']=$product->getShortDescription();?>
           <?php else:?>
               <?php $row['description']=st_truncate_text($product->getShortDescription(),$config->get('cut_description_num_group'),'...'); ?>
           <?php endif;?>
       <?php elseif ($config->get('description_type_group')=='full'):?>
           <?php if ($config->get('cut_description_group')!=1 || (st_check_strlen($product->getDescription())<$config->get('cut_description_num_group'))):?>
               <?php $row['description']=$product->getDescription();?> 
           <?php else:?>
               <?php $row['description']=st_truncate_text($product->getDescription(),$config->get('cut_description_num_group'),'...'); ?>
           <?php endif;?>
       <?php endif;?>
        
        <?php $row['price']=ShowProductPrice(st_price($product->getPriceBrutto(), true, true)) ?>
        <?php $row['price_net']=ShowProductPrice(st_price($product->getPriceNetto(), true, true)) ?>
        <?php $row['basket']=st_get_component('stBasket', 'add', array('product' => $product)) ?>
        <?php $row['photo']=st_link_to(st_product_image_tag($product, 'small'), 'stProduct/show?url='.$product->getFriendlyUrl()); ?>
        <?php $row['wholesale']=$product->getWholesale();?>
        
        <?php if ($product->getOldPriceBrutto()!=0): ?>
            <?php $row['check_old_price']=1;?>
        <?php else:?>
            <?php $row['check_old_price']=0;?>
        <?php endif;?>
        
        <?php $row['old_price']=ShowProductPrice(st_price($product->getOldPriceBrutto(), true, true)) ?>
        <?php $row['old_price_net']=ShowProductPrice(st_price($product->getOldPriceNetto(), true, true)) ?>
        <?php $row['discount'] = $product->getPrecentSafeBrutto(); ?>
        <?php $row['name_without_link'] = $product->getName();?>
        <?php $row['link'] = st_url_for('stProduct/show?url=' . $product->getFriendlyUrl());?>
        <?php $row['code'] = $product->getCode();?>
        
        <?php
        if ($config->get('show_basic_price_long') && $product->hasBasicPrice() && $product->getBasicPriceBrutto()!=0)
        {
            $row['basic_price'] = array(
                'netto' => st_currency_format($product->getBasicPriceNetto(true)),
                'brutto' => st_currency_format($product->getBasicPriceBrutto(true)),
                'quantity' => st_product_basic_price_quantity($product),
                'for_quantity' => st_product_basic_price_for_quantity($product),
            );
        }   
        ?>

    <?php $results[]=$row;?>
    <?php endforeach;?>


    <?php $smarty->assign('results',$results); ?>       
    <?php $smarty->display('product_main.html') ?>
<?php endif; ?>
