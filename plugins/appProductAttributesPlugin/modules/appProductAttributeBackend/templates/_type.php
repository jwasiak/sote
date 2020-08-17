<?php if ($type == 'edit'): ?>
<?php echo select_tag('app_product_attribute[type]', options_for_select(appProductAttributeHelper::getTypes(), $app_product_attribute->getType()), array('disabled' => !$app_product_attribute->isNew())) ?>
<?php else: ?>
<?php echo appProductAttributeHelper::getLabelByType($app_product_attribute->getType()) ?>
<?php endif ?>