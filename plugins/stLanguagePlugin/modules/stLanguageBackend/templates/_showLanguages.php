<?php foreach ($languages as $key => $language):?>
    <?php if($language->getOriginalLanguage() == stLanguage::getHydrateCulture()):?>
        <?php if($language->getActiveImage()):?>
            <?php echo image_tag('/'.sfConfig::get('sf_upload_dir_name').'/stLanguagePlugin/'.$language->getActiveImage())?>
        <?php else:?>
            <?php echo $language->getShortcut()?>
        <?php endif;?>
    <?php else:?>
        <?php if($language->getInactiveImage()):?>
            <?php echo link_to(image_tag('/'.sfConfig::get('sf_upload_dir_name').'/stLanguagePlugin/'.$language->getInactiveImage()), 'language/changeLanguage?name='.$language->getShortcut())?>
        <?php else:?>
            <?php echo link_to($language->getShortcut(), 'language/changeLanguage?name='.$language->getShortcut())?>
        <?php endif;?>
    <?php endif;?>   
<?php endforeach;?>