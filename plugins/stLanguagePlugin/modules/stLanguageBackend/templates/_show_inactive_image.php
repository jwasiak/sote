<?php if($language->getInactiveImage()):?>
    <?php echo image_tag('/'.sfConfig::get('sf_upload_dir_name')."/stLanguagePlugin/".$language->getInactiveImage())?>
<?php else:?>
    <?php echo __('brak obrazka')?>
<?php endif;?>