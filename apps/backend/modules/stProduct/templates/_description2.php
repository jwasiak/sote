<?php use_stylesheet('backend/appAdditionalDescPlugin.css'); ?>
<?php $config = stConfig::getInstance('appAdditionalDescBackend'); ?>

<div id="adddesc">
  <div>
    <?php echo object_textarea_tag($product, 'getDescription2', array (
      'control_name' => 'product[description2]',
      'rich' => true,
      'tinymce_options' => 'height:200,width:\'100%\'',
      'disabled' => false,
    )); ?> 
  </div>
    <div class="icon_app" style="margin-top: 10px;">
      <a href="/backend.php/additional_desc/"><img src="/images/backend/main/icons/red/appAdditionalDescPlugin.png"/></a> 
    </div>
</div>