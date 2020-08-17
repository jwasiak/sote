<?php $path_objects = $product_options_value->getPath() ?>

<?php //use_stylesheet('backend/stProductOptionsPlugin.css')?>

<?php $path = '<ul style="text-align: left">' ?>
<?php foreach($path_objects as $path_object): ?>
    <?php $path .= $path_object->isRoot() ? '' : '<li><strong>'.$path_object->getProductOptionsField()->getName().':</strong> '.$path_object->getValue().'</li>' ?>
<?php endforeach; ?>
<?php if($product_options_value->getProductOptionsField()): ?>
<?php $path .= '<li><strong>'.$product_options_value->getProductOptionsField()->getName().':</strong> ' ?>
<?php endif; ?>
<?php echo $path.$product_options_value->getValue().'</li></ul>' ?>