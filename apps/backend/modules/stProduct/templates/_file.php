<?php use_helper('stImageSize', 'stProductPhoto'); ?>

<div style="width: 300px; float: left">
    <?php if ($sf_request->hasError('product{image}')): ?>
        <?php echo form_error('product{image}', array('class' => 'form-error-msg')) ?>
    <?php endif; ?>
    
    <?php $value = object_admin_input_file_tag($product, 'getImage', array (
      'control_name' => 'product[image]',
      'include_remove' => false,
    )); 
      echo $value ? $value : '&nbsp;' 
    ?>    
    <br />
    <?php echo st_product_photo($product->getImage(), 128, 128, "/sfAsset/edit?id=".$product->getAssetMainId()); ?>
</div>



<?php $assets = getAssets($product->getId(), 6) ?>
<?php $index = 0; ?>
<div style="float: left; border: 1px solid #cccccc;">
    <?php foreach($assets as $asset): ?>
    <?php $index++ ?>
        <div style="margin: 5px; float: left; width: 84px; height: 84px;border: 1px dashed #cccccc"><?php echo st_asset_photo_link($asset->getPath(), 84, 84, "/sfAsset/edit?id=".$asset->getId()); ?></div>
        <?php if ( ($index % 3) == 0): ?><br class="st_clear_all" /><?php endif; ?> 
    <?php endforeach; ?>
</div>
<br class="st_clear_all" />
<br />

<?php if ($sf_request->getParameter("id")): ?>
    <?php echo st_get_admin_actions_head('style="margin-top: 0px; float: right;"') ?>
        <?php echo st_get_admin_action('save', __('Zapisz'), null, array ('name' => 'save',)) ?>   
    <?php echo st_get_admin_actions_foot() ?>
<?php endif; ?>