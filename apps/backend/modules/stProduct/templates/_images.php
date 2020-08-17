<?php use_helper('stProductPhoto');?>
<?php foreach ($photos as $photo):?>
    <div style="float:left; margin:10px">
        <?php if ($photo==get_main_image($photos)):?>
            <?php echo image_tag('/uploads/products/'.$dir.'/'.$photo, array('width'=>150))?>
        <?php else:?>
            <?php echo image_tag('/uploads/products/'.$dir.'/'.$photo, array('width'=>50))?>
        <?php endif;?>
        
    </div>
<?php endforeach;?>
<br>
<?php echo link_to(__('Przejdź do galerii aby zarządzać zdjęciami produktu'), 'product/galleryEdit?id='.$product->getId())?>