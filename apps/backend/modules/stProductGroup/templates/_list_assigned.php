<?php
$c = new Criteria();
$c->add(ProductGroupHasProductPeer::PRODUCT_GROUP_ID, $forward_parameters['product_group_id']);
$c->add(ProductGroupHasProductPeer::PRODUCT_ID, $product->getId());
if (ProductGroupHasProductPeer::doCount($c)):
?>
<?php echo image_tag(sfConfig::get('sf_admin_web_dir').'/images/tick.png') ?>
<?php else: ?>
-
<?php endif ?>