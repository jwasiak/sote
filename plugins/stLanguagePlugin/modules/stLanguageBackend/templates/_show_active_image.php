<?php if($language->getActiveImage()):?>
    <?php echo image_tag('/'.sfConfig::get('sf_upload_dir_name')."/stLanguagePlugin/".$language->getActiveImage())?>
<?php else:?>
    <?php echo __('brak obrazka')?>
<?php endif;?>