<?php use_helper('stProductPhoto','stImageSize');?>
<?php use_stylesheet('/css/backend/stProduct.css'); ?>        
<?php if($product):?>
    <?php foreach ($photos as $photo):?>
            <?php if ($photo==get_main_image($dir)):?>
            <div style="width:200px; height:200px;border:1px solid #D6D6D6; padding: 10px;">
                <?php echo link_to(st_product_photo('/uploads/products/'.$dir.'/'.$photo, 200, 200), 'product/galleryEdit?id='.$product->getId() )?><br>
            </div>
            <?php endif;?>
    <?php endforeach;?>
<?php echo link_to(__('Przejdź do galerii'), 'product/galleryEdit?id='.$product->getId())?>
<?php endif;?>