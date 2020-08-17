<?php $url = st_url_for('@appProductAttributesPlugin?action=variantEdit&id='.$app_product_attribute_variant->getId()) ?>
<?php if ($app_product_attribute_variant->getType() == 'C'): ?>
<a class="app_product_attribute_variant_preview" href="<?php echo $url ?>" style="background-color: #<?php echo $app_product_attribute_variant->getColor() ?>"></a>   
<a href="<?php echo $url ?>"><?php echo $app_product_attribute_variant->getName() ?></a>
<?php elseif ($app_product_attribute_variant->getType() == 'P'): ?>
<a class="app_product_attribute_variant_preview" href="<?php echo $url ?>" style="background-image: url('<?php echo $app_product_attribute_variant->getPicturePath() ?>')"></a>
<a href="<?php echo $url ?>"><?php echo $app_product_attribute_variant->getName() ?></a>
<?php else: ?>
<a href="<?php echo $url ?>"><?php echo $app_product_attribute_variant->getValue() ?></a>   
<?php endif ?>