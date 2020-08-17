<?php $product_id = $sf_request->getParameter('product_id'); ?>
<?php $c = new Criteria(); ?>
<?php $c->add(ProductPeer::ID, $forward_parameters['product_id']); ?>
<?php $product = ProductPeer::doSelectOne($c); ?>
<?php echo $product->getName() ?>