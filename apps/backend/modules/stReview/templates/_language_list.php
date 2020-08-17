<?php $lang = $review->getLanguage(); ?>
<?php $c = new Criteria(); ?>
<?php $c->add(LanguagePeer::LANGUAGE, $lang); ?>
<?php $language = LanguagePeer::doSelectOne($c); ?>
<?php if($language->getActiveImage()):?>
  <?php echo image_tag('/'.sfConfig::get('sf_upload_dir_name')."/stLanguagePlugin/".$language->getActiveImage(), array('style' => 'vertical-align: middle;')); ?>
<?php else:?>
  <?php echo $language; ?>
<?php endif;?>