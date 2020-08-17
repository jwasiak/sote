<?php 
	$id = $product_has_attachment->getLanguageId();
	$c = new Criteria();
    $c->add(LanguagePeer::ID, $id);
    $language = LanguagePeer::doSelectOne($c);
?>

<?php if($language->getActiveImage()):?>
    <?php echo image_tag('/'.sfConfig::get('sf_upload_dir_name')."/stLanguagePlugin/".$language->getActiveImage())?>
<?php else:?>
    <?php echo $language; ?>
<?php endif;?>